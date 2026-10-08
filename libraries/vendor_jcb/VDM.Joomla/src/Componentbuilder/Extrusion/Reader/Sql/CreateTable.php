<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Reader\Sql;


/**
 * Parses one CREATE TABLE statement into table and column metadata.
 * 
 * This is the pure replacement for the legacy trick of executing the extracted
 * DDL against the live database and reading MySQL's normalised metadata back.
 * Nothing here touches a database, a file, or the Joomla application, so the
 * parser is testable in isolation and an untrusted dump can never reach a
 * query.
 * 
 * The reproduced metadata is the set the field derivation depends on: the type
 * keyword and its size, unsigned, the null switch, the default, the auto
 * increment flag, the column comment that carries the author's JCB notes, and
 * the key status, ranked so the stronger claim always wins: 3 is primary, 2 is
 * unique, 1 is a plain index, and 0 is none. Table level key clauses and inline
 * column keys are both honoured, and a composite key
 * marks every column it names.
 * 
 * @since 6.1.6
 */
final class CreateTable
{
	/**
	 * A quoted identifier or string literal.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const QUOTED = '`(?:[^`]|``)*`|\'(?:[^\']|\'\')*\'|"(?:[^"]|"")*"';

	/**
	 * A possibly qualified identifier, quoted or bare.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const IDENTIFIER = '(?:' . self::QUOTED . '|[^\s(,.]+)(?:\.(?:'
		. self::QUOTED . '|[^\s(,.]+))*';

	/**
	 * The CREATE TABLE header, up to and including the opening parenthesis.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const HEADER = '/^CREATE\s+(?:TEMPORARY\s+)?TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?('
		. self::IDENTIFIER . ')\s*\(/is';

	/**
	 * Definition list keywords that introduce a table level clause.
	 *
	 * A column whose name is one of these words is invalid MySQL unless it is
	 * quoted, so a bare leading keyword from this list is never a column.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const CLAUSES = [
		'PRIMARY', 'UNIQUE', 'KEY', 'INDEX', 'FULLTEXT',
		'SPATIAL', 'CONSTRAINT', 'FOREIGN', 'CHECK'
	];

	/**
	 * Trailing words that belong to a multi word type keyword.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const QUALIFIERS = ['PRECISION', 'VARYING'];

	/**
	 * Backslash escape sequences understood inside a MySQL string literal.
	 *
	 * @var    array<string, string>
	 * @since  6.1.6
	 */
	private const ESCAPES = [
		'0' => "\0",
		'b' => "\x08",
		'n' => "\n",
		'r' => "\r",
		't' => "\t",
		'Z' => "\x1a",
		'\\' => '\\',
		'\'' => '\'',
		'"' => '"',
		'%' => '\\%',
		'_' => '\\_'
	];

	/**
	 * Parse one statement into table and column metadata.
	 *
	 * @param   string  $statement  One SQL statement.
	 *
	 * @return  array{table: string, columns: array<string, array>}|null
	 *          The parsed table, or null when the statement is not a
	 *          CREATE TABLE this parser understands.
	 * @since   6.1.6
	 */
	public function parse(string $statement): ?array
	{
		$sql = trim($this->clean($statement));

		if (preg_match(self::HEADER, $sql, $match) !== 1)
		{
			return null;
		}

		$table = $this->name($match[1]);
		$open = strlen($match[0]) - 1;
		$close = $this->balanced($sql, $open);

		if ($table === '' || $close === null)
		{
			return null;
		}

		$columns = [];
		$keys = [];

		foreach ($this->parts(substr($sql, $open + 1, $close - $open - 1)) as $part)
		{
			$keyword = $this->keyword($part);

			if ($keyword !== null && in_array($keyword, self::CLAUSES, true))
			{
				$this->clause($part, $keyword, $keys);

				continue;
			}

			$column = $this->column($part, count($columns));

			if ($column !== null)
			{
				$columns[$column['name']] = $column;
			}
		}

		if ($columns === [])
		{
			return null;
		}

		return [
			'table' => $table,
			'columns' => $this->apply($columns, $keys),
			'options' => $this->options(substr($sql, $close + 1))
		];
	}

	/**
	 * Read the table options a CREATE TABLE states after its closing bracket.
	 *
	 * The engine a table runs on, the character set it stores text in and the
	 * row format it uses are the table's own, and a component states all of
	 * them here. They are not properties of any column, so nothing about the
	 * columns could recover them, and a table rebuilt without them silently
	 * becomes whatever the platform defaults to -- which for JCB is MyISAM and
	 * utf8, not what a modern component asked for.
	 *
	 * @param   string  $tail  Everything after the column list's closing bracket.
	 *
	 * @return  array<string, string>  Option name keyed to its stated value.
	 * @since   6.1.8
	 */
	private function options(string $tail): array
	{
		$found = [];
		$tail = trim(rtrim(trim($tail), ';'));

		if ($tail === '')
		{
			return $found;
		}

		foreach ([
			'engine' => 'ENGINE',
			'charset' => '(?:DEFAULT\s+)?CHARSET|(?:DEFAULT\s+)?CHARACTER\s+SET',
			'collate' => '(?:DEFAULT\s+)?COLLATE',
			'row_format' => 'ROW_FORMAT'
		] as $key => $pattern)
		{
			if (preg_match('/\b(?:' . $pattern . ')\s*=?\s*([A-Za-z0-9_]+)/i', $tail, $match) === 1)
			{
				$found[$key] = $match[1];
			}
		}

		return $found;
	}

	/**
	 * Merge the table level key ranks into the parsed columns.
	 *
	 * @param   array<string, array>  $columns  The parsed columns.
	 * @param   array<string, int>    $keys     Key rank keyed to column name.
	 *
	 * @return  array<string, array>  The columns with their final key status.
	 * @since   6.1.6
	 */
	private function apply(array $columns, array $keys): array
	{
		foreach ($keys as $name => $rank)
		{
			if (!isset($columns[$name]))
			{
				continue;
			}

			$columns[$name]['key'] = max($columns[$name]['key'], $rank);

			if ($columns[$name]['key'] === 3)
			{
				$columns[$name]['null'] = 'NOT NULL';
			}
		}

		return $columns;
	}

	/**
	 * Read one table level key clause into the key ranks.
	 *
	 * A CONSTRAINT wrapper is unwrapped so a named primary or unique key still
	 * counts. A plain KEY or INDEX clause is an index the component asked for,
	 * and is read as one. FOREIGN KEY, CHECK, FULLTEXT and SPATIAL make no
	 * claim on a column's own key status and are therefore ignored.
	 *
	 * @param   string              $part     The clause text.
	 * @param   string              $keyword  The clause's leading keyword.
	 * @param   array<string, int>  $keys     Key rank keyed to column name.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function clause(string $part, string $keyword, array &$keys): void
	{
		if ($keyword === 'CONSTRAINT')
		{
			$part = $this->constraint($part);
			$keyword = (string) $this->keyword($part);
		}

		if ($keyword === 'PRIMARY')
		{
			$rank = 3;
		}
		elseif ($keyword === 'UNIQUE')
		{
			$rank = 2;
		}
		elseif ($keyword === 'KEY' || $keyword === 'INDEX')
		{
			$rank = 1;
		}
		else
		{
			return;
		}

		foreach ($this->indexed($part) as $name)
		{
			$keys[$name] = max($keys[$name] ?? 0, $rank);
		}
	}

	/**
	 * Strip a CONSTRAINT keyword and its optional symbol from a clause.
	 *
	 * @param   string  $part  The clause text.
	 *
	 * @return  string  The clause without its CONSTRAINT wrapper.
	 * @since   6.1.6
	 */
	private function constraint(string $part): string
	{
		$part = (string) preg_replace('/^CONSTRAINT\s*/i', '', $part, 1);

		return (string) preg_replace(
			'/^(?!PRIMARY\b|UNIQUE\b|FOREIGN\b|CHECK\b)(?:' . self::QUOTED . '|[^\s(]+)\s*/i',
			'',
			$part,
			1
		);
	}

	/**
	 * Read the column names a key clause lists.
	 *
	 * Prefix lengths and sort direction are discarded, so `name`(10) DESC
	 * yields name.
	 *
	 * @param   string  $part  The clause text.
	 *
	 * @return  array<string>  Every column the clause names.
	 * @since   6.1.6
	 */
	private function indexed(string $part): array
	{
		$open = $this->opening($part);
		$close = $open === null ? null : $this->balanced($part, $open);

		if ($open === null || $close === null)
		{
			return [];
		}

		$names = [];

		foreach ($this->parts(substr($part, $open + 1, $close - $open - 1)) as $entry)
		{
			$name = $this->name($this->token($entry));

			if ($name !== '')
			{
				$names[] = $name;
			}
		}

		return $names;
	}

	/**
	 * Parse one column definition.
	 *
	 * @param   string  $part     The column definition text.
	 * @param   int     $ordinal  The zero based position of the column.
	 *
	 * @return  array|null  The column metadata, or null when unparsable.
	 * @since   6.1.6
	 */
	private function column(string $part, int $ordinal): ?array
	{
		$definition = ltrim($part);
		$raw = $this->token($definition);
		$name = $this->name($raw);

		if ($name === '')
		{
			return null;
		}

		$rest = substr($definition, strlen($raw));

		if (preg_match('/^\s*([A-Za-z][A-Za-z0-9_]*)/', $rest, $match) !== 1)
		{
			return null;
		}

		$keyword = $match[1];
		$cursor = strlen($match[0]);
		$qualifier = '/^\s+(' . implode('|', self::QUALIFIERS) . ')\b/i';

		if (preg_match($qualifier, substr($rest, $cursor), $extra) === 1)
		{
			$keyword .= ' ' . $extra[1];
			$cursor += strlen($extra[0]);
		}

		$spec = '';

		if (preg_match('/^\s*\(/', substr($rest, $cursor), $paren) === 1)
		{
			$start = $cursor + strlen($paren[0]) - 1;
			$end = $this->balanced($rest, $start);

			if ($end !== null)
			{
				$spec = substr($rest, $start, $end - $start + 1);
				$cursor = $end + 1;
			}
		}

		return $this->attributes(
			[
				'name' => $name,
				'type' => strtoupper(explode(' ', $keyword)[0]),
				'raw_type' => strtoupper($keyword) . $spec,
				'size' => $this->size($spec),
				'ordinal' => $ordinal
			],
			substr($rest, $cursor)
		);
	}

	/**
	 * Read the trailing column attributes into the column metadata.
	 *
	 * Every keyword is matched against a masked copy of the tail in which each
	 * literal is replaced by filler of the same length. That keeps the offsets
	 * usable against the original text while making it impossible for a word
	 * inside a comment or a default string to be read as an attribute.
	 *
	 * @param   array   $column  The column metadata gathered so far.
	 * @param   string  $tail    The attribute text following the type.
	 *
	 * @return  array  The completed column metadata.
	 * @since   6.1.6
	 */
	private function attributes(array $column, string $tail): array
	{
		$masked = $this->mask($tail);
		$default = $this->value($tail, $masked);
		$key = 0;

		if (preg_match('/\bPRIMARY\s+KEY\b/i', $masked) === 1)
		{
			$key = 3;
		}
		elseif (preg_match('/\bUNIQUE(?:\s+KEY)?\b/i', $masked) === 1)
		{
			$key = 2;
		}
		elseif (preg_match('/\bKEY\b/i', $masked) === 1)
		{
			$key = 1;
		}

		$null = $key === 3 || preg_match('/\bNOT\s+NULL\b/i', $masked) === 1
			? 'NOT NULL'
			: 'NULL';

		return [
			'name' => $column['name'],
			'type' => $column['type'],
			'raw_type' => $column['raw_type'],
			'size' => $column['size'],
			'unsigned' => preg_match('/\bUNSIGNED\b/i', $masked) === 1,
			'null' => $null,
			'default' => $default ?? '',
			'default_stated' => $default !== null,
			'auto_increment' => preg_match('/\bAUTO_INCREMENT\b/i', $masked) === 1,
			'comment' => $this->comment($tail, $masked),
			'key' => $key,
			'ordinal' => $column['ordinal']
		];
	}

	/**
	 * Read the column's default value.
	 *
	 * A quoted default is unescaped, so a quoted empty string collapses to an
	 * empty string exactly as an absent default does. DEFAULT NULL is no
	 * default. CURRENT_TIMESTAMP and any other bare function default are kept
	 * verbatim.
	 *
	 * @param   string  $tail    The original attribute text.
	 * @param   string  $masked  The literal masked attribute text.
	 *
	 * @return  string  The default value, or an empty string when there is none.
	 * @since   6.1.6
	 */
	private function value(string $tail, string $masked): ?string
	{
		// a column stating no default at all is not a column defaulting to
		// nothing: one carries no DEFAULT clause, the other carries an empty
		// one, and only null can tell the two apart afterwards
		if (preg_match('/\bDEFAULT\b\s*/i', $masked, $match, PREG_OFFSET_CAPTURE) !== 1)
		{
			return null;
		}

		$text = ltrim(substr($tail, $match[0][1] + strlen($match[0][0])));

		if ($text === '')
		{
			return '';
		}

		if ($text[0] === '(')
		{
			$close = $this->balanced($text, 0);

			return $close === null ? '' : substr($text, 0, $close + 1);
		}

		$raw = $this->token($text);

		if ($raw === '')
		{
			return '';
		}

		if ($raw[0] === '\'' || $raw[0] === '"')
		{
			return $this->unquote($raw);
		}

		if (strcasecmp($raw, 'NULL') === 0)
		{
			// DEFAULT NULL states the same thing as stating no default at all:
			// the column falls back to NULL. Reading it as the empty string
			// would give the column a default of '' instead, which is a
			// different value a query can tell apart
			return null;
		}

		return $raw . $this->call($text, strlen($raw));
	}

	/**
	 * Read the parentheses of a function style default, when present.
	 *
	 * @param   string  $text    The default value text.
	 * @param   int     $offset  Offset just past the function name.
	 *
	 * @return  string  The parenthesised argument list, or an empty string.
	 * @since   6.1.6
	 */
	private function call(string $text, int $offset): string
	{
		if (($text[$offset] ?? '') !== '(')
		{
			return '';
		}

		$close = $this->balanced($text, $offset);

		return $close === null ? '' : substr($text, $offset, $close - $offset + 1);
	}

	/**
	 * Read the column comment, unescaped.
	 *
	 * @param   string  $tail    The original attribute text.
	 * @param   string  $masked  The literal masked attribute text.
	 *
	 * @return  string|null  The comment, or null when the column has none.
	 * @since   6.1.6
	 */
	private function comment(string $tail, string $masked): ?string
	{
		if (preg_match('/\bCOMMENT\b\s*/i', $masked, $match, PREG_OFFSET_CAPTURE) !== 1)
		{
			return null;
		}

		$raw = $this->token(substr($tail, $match[0][1] + strlen($match[0][0])));

		return $raw === '' ? '' : $this->unquote($raw);
	}

	/**
	 * Read a numeric size or precision out of a type's parentheses.
	 *
	 * @param   string  $spec  The parenthesised type specification.
	 *
	 * @return  string|null  The size, such as 255 or 10,2, or null when the
	 *                       specification is not numeric.
	 * @since   6.1.6
	 */
	private function size(string $spec): ?string
	{
		if (preg_match('/^\(\s*(\d+)\s*(?:,\s*(\d+)\s*)?\)$/', $spec, $match) !== 1)
		{
			return null;
		}

		return isset($match[2]) && $match[2] !== ''
			? $match[1] . ',' . $match[2]
			: $match[1];
	}

	/**
	 * Replace every literal with filler of the same length.
	 *
	 * @param   string  $text  The text to mask.
	 *
	 * @return  string  The masked text, byte for byte the same length.
	 * @since   6.1.6
	 */
	private function mask(string $text): string
	{
		$masked = '';
		$length = strlen($text);
		$index = 0;

		while ($index < $length)
		{
			$character = $text[$index];

			if ($character === '\'' || $character === '"' || $character === '`')
			{
				$end = $this->literal($text, $index);
				$masked .= str_repeat('x', $end - $index);
				$index = $end;

				continue;
			}

			$masked .= $character;
			$index++;
		}

		return $masked;
	}

	/**
	 * Split a definition list on its top level commas.
	 *
	 * Parentheses nest and literals are opaque, so a comma inside a type
	 * specification, a key column list, or a string never splits the list.
	 *
	 * @param   string  $definitions  The definition list, without its outer
	 *                                parentheses.
	 *
	 * @return  array<string>  The trimmed top level parts.
	 * @since   6.1.6
	 */
	private function parts(string $definitions): array
	{
		$parts = [];
		$buffer = '';
		$depth = 0;
		$length = strlen($definitions);
		$index = 0;

		while ($index < $length)
		{
			$character = $definitions[$index];

			if ($character === '\'' || $character === '"' || $character === '`')
			{
				$end = $this->literal($definitions, $index);
				$buffer .= substr($definitions, $index, $end - $index);
				$index = $end;

				continue;
			}

			if ($character === '(')
			{
				$depth++;
			}
			elseif ($character === ')')
			{
				$depth = max(0, $depth - 1);
			}
			elseif ($character === ',' && $depth === 0)
			{
				$parts[] = $buffer;
				$buffer = '';
				$index++;

				continue;
			}

			$buffer .= $character;
			$index++;
		}

		$parts[] = $buffer;

		return array_values(array_filter(array_map('trim', $parts), 'strlen'));
	}

	/**
	 * Read the leading bare keyword of a definition list part.
	 *
	 * @param   string  $part  The definition list part.
	 *
	 * @return  string|null  The uppercased keyword, or null when the part opens
	 *                       with a quoted identifier.
	 * @since   6.1.6
	 */
	private function keyword(string $part): ?string
	{
		if (preg_match('/^([A-Za-z_]+)\b/', $part, $match) !== 1)
		{
			return null;
		}

		return strtoupper($match[1]);
	}

	/**
	 * Read the first identifier token of a fragment, quotes included.
	 *
	 * @param   string  $text  The fragment to read.
	 *
	 * @return  string  The raw token, or an empty string when there is none.
	 * @since   6.1.6
	 */
	private function token(string $text): string
	{
		$text = ltrim($text);

		if ($text === '')
		{
			return '';
		}

		if ($text[0] === '`' || $text[0] === '\'' || $text[0] === '"')
		{
			return substr($text, 0, $this->literal($text, 0));
		}

		return preg_match('/^[^\s(,]+/', $text, $match) === 1 ? $match[0] : '';
	}

	/**
	 * Resolve an identifier to its unqualified, unquoted name.
	 *
	 * @param   string  $raw  The raw identifier, possibly qualified and quoted.
	 *
	 * @return  string  The bare name, or an empty string when there is none.
	 * @since   6.1.6
	 */
	private function name(string $raw): string
	{
		$found = preg_match_all(
			'/' . self::QUOTED . '|[^\s.`\'"]+/',
			$raw,
			$matches
		);

		if ($found === false || $found === 0)
		{
			return '';
		}

		$segments = $matches[0];

		return $this->unquote((string) end($segments));
	}

	/**
	 * Strip the quotes from one identifier or string literal.
	 *
	 * @param   string  $raw  The raw token.
	 *
	 * @return  string  The unquoted, unescaped value.
	 * @since   6.1.6
	 */
	private function unquote(string $raw): string
	{
		if (strlen($raw) < 2)
		{
			return $raw;
		}

		$quote = $raw[0];

		if ($quote !== '`' && $quote !== '\'' && $quote !== '"')
		{
			return $raw;
		}

		if (substr($raw, -1) !== $quote)
		{
			return $raw;
		}

		$inner = substr($raw, 1, -1);

		return $quote === '`'
			? str_replace('``', '`', $inner)
			: $this->unescape($inner, $quote);
	}

	/**
	 * Unescape the body of a MySQL string literal.
	 *
	 * @param   string  $inner  The literal body, without its quotes.
	 * @param   string  $quote  The quote character that delimited it.
	 *
	 * @return  string  The decoded value.
	 * @since   6.1.6
	 */
	private function unescape(string $inner, string $quote): string
	{
		$value = '';
		$length = strlen($inner);
		$index = 0;

		while ($index < $length)
		{
			$character = $inner[$index];

			if ($character === '\\' && $index + 1 < $length)
			{
				$next = $inner[$index + 1];
				$value .= self::ESCAPES[$next] ?? $next;
				$index += 2;

				continue;
			}

			if ($character === $quote && ($inner[$index + 1] ?? '') === $quote)
			{
				$value .= $quote;
				$index += 2;

				continue;
			}

			$value .= $character;
			$index++;
		}

		return $value;
	}

	/**
	 * Find the first parenthesis that is not inside a literal.
	 *
	 * @param   string  $text  The text to scan.
	 *
	 * @return  int|null  The offset of the parenthesis, or null when absent.
	 * @since   6.1.6
	 */
	private function opening(string $text): ?int
	{
		$length = strlen($text);
		$index = 0;

		while ($index < $length)
		{
			$character = $text[$index];

			if ($character === '\'' || $character === '"' || $character === '`')
			{
				$index = $this->literal($text, $index);

				continue;
			}

			if ($character === '(')
			{
				return $index;
			}

			$index++;
		}

		return null;
	}

	/**
	 * Find the parenthesis that closes the one at an offset.
	 *
	 * @param   string  $text   The text to scan.
	 * @param   int     $open   Offset of the opening parenthesis.
	 *
	 * @return  int|null  The offset of the closing parenthesis, or null when the
	 *                    text is unbalanced.
	 * @since   6.1.6
	 */
	private function balanced(string $text, int $open): ?int
	{
		$length = strlen($text);
		$depth = 0;
		$index = $open;

		while ($index < $length)
		{
			$character = $text[$index];

			if ($character === '\'' || $character === '"' || $character === '`')
			{
				$index = $this->literal($text, $index);

				continue;
			}

			if ($character === '(')
			{
				$depth++;
			}
			elseif ($character === ')')
			{
				$depth--;

				if ($depth === 0)
				{
					return $index;
				}
			}

			$index++;
		}

		return null;
	}

	/**
	 * Remove every comment from a statement, leaving literals untouched.
	 *
	 * The splitter already does this for a dump, but the parser stays usable on
	 * a statement that reached it by another route.
	 *
	 * @param   string  $statement  The statement to clean.
	 *
	 * @return  string  The statement without its comments.
	 * @since   6.1.6
	 */
	private function clean(string $statement): string
	{
		$clean = '';
		$length = strlen($statement);
		$index = 0;

		while ($index < $length)
		{
			$character = $statement[$index];

			if ($character === '\'' || $character === '"' || $character === '`')
			{
				$end = $this->literal($statement, $index);
				$clean .= substr($statement, $index, $end - $index);
				$index = $end;

				continue;
			}

			if (substr($statement, $index, 2) === '/*')
			{
				$position = strpos($statement, '*/', $index + 2);
				$index = $position === false ? $length : $position + 2;
				$clean .= ' ';

				continue;
			}

			if ($character === '#' || $this->dash($statement, $index, $length))
			{
				$position = strpos($statement, "\n", $index);
				$index = $position === false ? $length : $position;
				$clean .= ' ';

				continue;
			}

			$clean .= $character;
			$index++;
		}

		return $clean;
	}

	/**
	 * Determine whether a double dash opens a line comment here.
	 *
	 * @param   string  $text    The text being scanned.
	 * @param   int     $index   Current offset.
	 * @param   int     $length  Length of the text.
	 *
	 * @return  bool  True when a line comment starts at this offset.
	 * @since   6.1.6
	 */
	private function dash(string $text, int $index, int $length): bool
	{
		if (substr($text, $index, 2) !== '--')
		{
			return false;
		}

		if ($index + 2 >= $length)
		{
			return true;
		}

		return strpos(" \t\n\r\0\x0B", $text[$index + 2]) !== false;
	}

	/**
	 * Find the offset just past a quoted string or backtick identifier.
	 *
	 * @param   string  $text   The text being scanned.
	 * @param   int     $index  Offset of the opening quote.
	 *
	 * @return  int  Offset just past the closing quote, or the end of the text.
	 * @since   6.1.6
	 */
	private function literal(string $text, int $index): int
	{
		$quote = $text[$index];
		$length = strlen($text);
		$cursor = $index + 1;

		while ($cursor < $length)
		{
			$character = $text[$cursor];

			if ($character === '\\' && $quote !== '`')
			{
				$cursor += 2;

				continue;
			}

			if ($character === $quote)
			{
				if (($text[$cursor + 1] ?? '') === $quote)
				{
					$cursor += 2;

					continue;
				}

				return $cursor + 1;
			}

			$cursor++;
		}

		return $length;
	}
}

