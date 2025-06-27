<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities\String;


use Joomla\CMS\Component\ComponentHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Control the naming of a field type
 * 
 * @since  3.0.9
 */
abstract class TypeHelper
{
	/**
	 * The field builder switch
	 * 
	 * @since  3.0.9
	 */
	protected static int $builder = 0;

	/**
	 * Cache for processed field type names to avoid redundant computations.
	 *
	 * @since  5.1.1
	 */
	protected static array $cache = [];

	/**
	 * Making field type name safe
	 *
	 * @param   String      $string     The you would like to make safe
	 * @param   String      $option    The option for the component.
	 *
	 * @returns string on success
	 * 
	 * @since  3.0.9
	 */
	public static function safe($string, $option = null): string
	{
		// Check if result is already cached
		if (isset(self::$cache[$string]))
		{
			return self::$cache[$string];
		}

		// get global value
		if (self::$builder == 0)
		{
			self::$builder = (int) Helper::getParams($option)->get('type_name_builder', 2);
		}

		// Apply new naming convention
		if (2 == self::$builder)
		{
			// Ensure input is a valid string
			if (StringHelper::check($string))
			{
				// Ensure the first character is not a number
				if (is_numeric(substr($string, 0, 1)))
				{
					$string = StringHelper::numbers($string);
				}

				// Detect if camel case is used
				$has_camel_case = preg_match('/[a-z][A-Z]/', $string);

				// Detect non-ASCII characters (extended Unicode)
				$has_non_ascii = preg_match('/[^\x20-\x7E]/', $string); // Anything outside printable ASCII

				// Detect non-standard symbols (anything that is not a letter, number, underscore, or dot)
				$has_non_standard_symbols = preg_match('/[^a-zA-Z0-9_.]/', $string);

				// Only transliterate if necessary:
				// - If it contains non-ASCII characters, or
				// - If it has non-standard symbols that may affect safe usage
				if ($has_non_ascii || $has_non_standard_symbols)
				{
					// Store original casing before transliteration
					$original_casing = $string;

					// Run transliteration
					$string = StringHelper::transliterate($string);

					// If original had camel case and transliterate altered casing, restore it
					if ($has_camel_case)
					{
						// Use original casing where possible, as Joomla's transliteration might enforce lowercase
						$string = self::restoreCamelCase($original_casing, $string);
					}
				}

				// Clean the string while preserving camelCase
				$cleaned = self::clean($string);

				// Cache the result
				self::$cache[$string] = $cleaned;

				return $cleaned;
			}

			return '';
		}

		// Default behaviour for legacy convention
		$result = StringHelper::safe($string);

		// Cache the result
		self::$cache[$string] = $result;

		return $result;
	}

	/**
	 * Restores the camel case pattern from the original string after transliteration.
	 *
	 * @param   string  $original  The original string before transliteration.
	 * @param   string  $modified  The string after transliteration.
	 *
	 * @return  string  The string with restored camel case.
	 * @since   5.1.1
	 */
	protected static function restoreCamelCase(string $original, string $modified): string
	{
		// Split original and modified strings into character arrays
		$origChars = preg_split('//u', $original, -1, PREG_SPLIT_NO_EMPTY);
		$modChars  = preg_split('//u', $modified, -1, PREG_SPLIT_NO_EMPTY);

		// Ensure lengths match before processing
		if (count($origChars) !== count($modChars))
		{
			return $modified; // Return as-is if lengths differ (indicating complex transformation)
		}

		// Restore camel case where applicable
		foreach ($origChars as $index => $char)
		{
			if (ctype_upper($char))
			{
				$modChars[$index] = strtoupper($modChars[$index]);
			}
		}

		return implode('', $modChars);
	}

	/**
	 * Cleans type name string by:
	 * - Removing all characters except letters, numbers, underscores, and periods.
	 * - Allowing only one period (the first period in the string).
	 *
	 * @param string $string Type name string to clean.
	 *
	 * @return string Cleaned string with only one period (first occurrence).
	 * @since  5.1.1
	 */
	protected static function clean(string $string): string
	{
		// Step 1: Remove unwanted characters (allow letters, numbers, underscores, and periods)
		$string = preg_replace('/[^A-Za-z0-9_.]/', '', $string);

		// Step 2: Keep only the first period, remove all subsequent periods
		$parts = explode('.', $string, 2);  // Split on first period only

		if (count($parts) === 2)
		{
			// Reconstruct string: first part + '.' + remove any further periods from second part
			$cleaned_string = $parts[0] . '.' . str_replace('.', '', $parts[1]);
		}
		else
		{
			// No period or just one part, no further action needed
			$cleaned_string = $string;
		}

		return trim($cleaned_string);
	}
}

