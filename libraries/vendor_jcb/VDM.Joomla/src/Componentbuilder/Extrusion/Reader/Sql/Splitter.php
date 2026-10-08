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
 * Splits one SQL dump into its individual statements.
 * 
 * The scan is literal aware. Single and double quoted strings, backtick
 * identifiers, line comments introduced by -- or #, and block comments each
 * swallow every semicolon they contain, so a statement is only ever cut on a
 * semicolon the parser can actually see. Comments are dropped from the emitted
 * statements, which hands the statement parsers clean input and keeps a dump's
 * decorative comment banners out of the captured seed data.
 * 
 * @since 6.1.6
 */
final class Splitter
{
	/**
	 * The UTF-8 byte order mark.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const BOM = "\xEF\xBB\xBF";

	/**
	 * Split a SQL dump into its statements.
	 *
	 * A byte order mark is dropped first. It is invisible in an editor but it
	 * sits ahead of the dump's first statement, where it would leave that one
	 * statement unrecognisable to the statement parsers and so silently lose
	 * whatever it declares.
	 *
	 * @param   string  $sql  The complete SQL dump.
	 *
	 * @return  array<string>  Trimmed statements, comment free, without their semicolons.
	 * @since   6.1.6
	 */
	public function split(string $sql): array
	{
		$statements = [];
		$buffer = '';
		$sql = $this->mark($sql);
		$length = strlen($sql);
		$index = 0;

		while ($index < $length)
		{
			$character = $sql[$index];

			if ($character === "'" || $character === '"' || $character === '`')
			{
				$end = $this->literal($sql, $index);
				$buffer .= substr($sql, $index, $end - $index);
				$index = $end;

				continue;
			}

			if (substr($sql, $index, 2) === '/*')
			{
				$index = $this->block($sql, $index, $length);
				$buffer .= ' ';

				continue;
			}

			if ($character === '#' || $this->dash($sql, $index, $length))
			{
				$index = $this->line($sql, $index, $length);
				$buffer .= ' ';

				continue;
			}

			if ($character === ';')
			{
				$this->collect($statements, $buffer);
				$buffer = '';
				$index++;

				continue;
			}

			$buffer .= $character;
			$index++;
		}

		$this->collect($statements, $buffer);

		return $statements;
	}

	/**
	 * Remove a leading byte order mark from a dump.
	 *
	 * @param   string  $sql  The complete SQL dump.
	 *
	 * @return  string  The dump without its byte order mark.
	 * @since   6.1.6
	 */
	private function mark(string $sql): string
	{
		return strncmp($sql, self::BOM, 3) === 0 ? substr($sql, 3) : $sql;
	}

	/**
	 * Collect one candidate statement, discarding anything empty.
	 *
	 * @param   array<string>  $statements  The statements collected so far.
	 * @param   string         $buffer      The candidate statement text.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	private function collect(array &$statements, string $buffer): void
	{
		$statement = trim($buffer);

		if ($statement !== '')
		{
			$statements[] = $statement;
		}
	}

	/**
	 * Find the offset just past a quoted string or backtick identifier.
	 *
	 * Backslash escapes are honoured inside string literals but not inside a
	 * backtick identifier, where MySQL only understands the doubled backtick.
	 * A doubled quote is an escaped quote in every case.
	 *
	 * @param   string  $sql    The source being scanned.
	 * @param   int     $index  Offset of the opening quote.
	 *
	 * @return  int  Offset just past the closing quote, or the end of the source.
	 * @since   6.1.6
	 */
	private function literal(string $sql, int $index): int
	{
		$quote = $sql[$index];
		$length = strlen($sql);
		$cursor = $index + 1;

		while ($cursor < $length)
		{
			$character = $sql[$cursor];

			if ($character === '\\' && $quote !== '`')
			{
				$cursor += 2;

				continue;
			}

			if ($character === $quote)
			{
				if ($cursor + 1 < $length && $sql[$cursor + 1] === $quote)
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

	/**
	 * Determine whether a double dash opens a line comment here.
	 *
	 * MySQL only treats -- as a comment when whitespace or the end of the
	 * input follows it, which keeps an expression such as 1--2 intact.
	 *
	 * @param   string  $sql     The source being scanned.
	 * @param   int     $index   Current offset.
	 * @param   int     $length  Length of the source.
	 *
	 * @return  bool  True when a line comment starts at this offset.
	 * @since   6.1.6
	 */
	private function dash(string $sql, int $index, int $length): bool
	{
		if (substr($sql, $index, 2) !== '--')
		{
			return false;
		}

		if ($index + 2 >= $length)
		{
			return true;
		}

		return strpos(" \t\n\r\0\x0B", $sql[$index + 2]) !== false;
	}

	/**
	 * Find the offset of the newline that closes a line comment.
	 *
	 * The newline itself is left in place so the surrounding statement keeps
	 * its line structure.
	 *
	 * @param   string  $sql     The source being scanned.
	 * @param   int     $index   Offset of the comment opener.
	 * @param   int     $length  Length of the source.
	 *
	 * @return  int  Offset of the closing newline, or the end of the source.
	 * @since   6.1.6
	 */
	private function line(string $sql, int $index, int $length): int
	{
		$position = strpos($sql, "\n", $index);

		return $position === false ? $length : $position;
	}

	/**
	 * Find the offset just past a block comment.
	 *
	 * @param   string  $sql     The source being scanned.
	 * @param   int     $index   Offset of the comment opener.
	 * @param   int     $length  Length of the source.
	 *
	 * @return  int  Offset just past the comment, or the end of the source.
	 * @since   6.1.6
	 */
	private function block(string $sql, int $index, int $length): int
	{
		$position = strpos($sql, '*/', $index + 2);

		return $position === false ? $length : $position + 2;
	}
}

