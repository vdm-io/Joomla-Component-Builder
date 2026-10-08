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
 * Recognises one INSERT INTO statement and names the table it seeds.
 * 
 * The statement itself is handed back verbatim. Seed data is stored, never
 * interpreted, so the extrusion keeps the author's rows exactly as written.
 * 
 * @since 6.1.6
 */
final class Insert
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
	 * The INSERT INTO header, up to and including the table name.
	 *
	 * @var    string
	 * @since  6.1.6
	 */
	private const HEADER = '/^\s*INSERT\s+(?:LOW_PRIORITY\s+|DELAYED\s+|HIGH_PRIORITY\s+|IGNORE\s+)*INTO\s+('
		. self::IDENTIFIER . ')/is';

	/**
	 * Parse one statement into a seed record.
	 *
	 * @param   string  $statement  One SQL statement.
	 *
	 * @return  array{table: string, sql: string}|null  The seeded table and the
	 *          statement verbatim, or null when the statement is not an INSERT.
	 * @since   6.1.6
	 */
	public function parse(string $statement): ?array
	{
		if (preg_match(self::HEADER, $statement, $match) !== 1)
		{
			return null;
		}

		$table = $this->name($match[1]);

		if ($table === '')
		{
			return null;
		}

		return ['table' => $table, 'sql' => $statement];
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
	 * Strip the quotes from one identifier.
	 *
	 * @param   string  $raw  The raw token.
	 *
	 * @return  string  The unquoted name.
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

		return str_replace($quote . $quote, $quote, substr($raw, 1, -1));
	}
}

