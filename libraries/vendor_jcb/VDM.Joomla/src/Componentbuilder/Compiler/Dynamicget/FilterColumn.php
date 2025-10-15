<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Custom View Filter Column
 * 
 * @since 5.1.2
 */
final class FilterColumn
{
	/**
	 * A tracker to avoid repeating load logic per field.
	 *
	 * @var   array
	 * @since 5.1.2
	 */
	protected array $loadTracker = [];

	/**
	 * Get the Custom View Field Decode Filter code block.
	 *
	 * @param  array   $get            The GET metadata for the current field.
	 * @param  array   $filters        The filters to apply on the field.
	 * @param  string  $string         The variable name representing the current object.
	 * @param  string  $removeString   The variable name for object removal context.
	 * @param  string  $code           The custom view identifier code.
	 * @param  string  $tab            The tab level for indent formatting.
	 *
	 * @return string  The generated PHP filter code block.
	 * @since  5.1.2
	 */
	public function get(
		array $get,
		array $filters,
		string $string,
		string $removeString,
		string $code,
		string $tab
	): string
	{
		if (empty($get['key']) || empty($get['selection']['select']) || empty($filters) || empty($string) || empty($code))
		{
			return '';
		}

		$filter = '';

		if (ArrayHelper::check($filters))
		{
			foreach ($filters as $field => $ter)
			{
				if (empty($ter['table_key']))
				{
					continue;
				}

				$key = md5($code . $get['key'] . $string . $ter['table_key']);

				if (strpos((string) $get['selection']['select'], (string) $ter['table_key']) !== false &&
					!isset($this->loadTracker[$key]))
				{
					$this->loadTracker[$key] = $key;

					list($as, $felt) = array_map('trim', explode('.', (string) $ter['table_key']));

					if ($get['as'] === $as &&
						isset($ter['filter_type']) &&
						is_numeric($ter['filter_type']))
					{
						$filter .= $this->getFilterCodeByType($ter['filter_type'], $string, $removeString, $field, $tab, $as);
					}
				}
			}
		}

		return $filter;
	}

	/**
	 * Generate the PHP code string for a specific filter type.
	 *
	 * @param  int     $type
	 * @param  string  $string
	 * @param  string  $removeString
	 * @param  string  $field
	 * @param  string  $tab
	 * @param  string  $as
	 *
	 * @return string
	 * @since  5.1.2
	 */
	protected function getFilterCodeByType(
		int $type,
		string $string,
		string $removeString,
		string $field,
		string $tab,
		string $as
	): string
	{
		$code = '';
		$t1 = Indent::_(1) . $tab . Indent::_(1);
		$t2 = Indent::_(1) . $tab . Indent::_(2);
		$t3 = Indent::_(1) . $tab . Indent::_(3);

		switch ($type)
		{
			case 4: // User Groups
				$code .= PHP_EOL . PHP_EOL . $t1 . "//" . Line::_(__LINE__, __CLASS__) . " filter $as based on user groups";
				$code .= PHP_EOL . $t1 . "\$remove = (count(array_intersect((array) \$this->groups, (array) {$string}->{$field}))) ? false : true;";
				$code .= PHP_EOL . $t1 . "if (\$remove)";
				$code .= PHP_EOL . $t1 . "{";
				$code .= $this->getRemovalCode($string, $removeString, $t2);
				$code .= PHP_EOL . $t1 . "}";
				break;

			case 9: // Array Value
				$code .= PHP_EOL . PHP_EOL . $t1 . "if (Super__"."_0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check({$string}->{$field}))";
				$code .= PHP_EOL . $t1 . "{";
				$code .= PHP_EOL . $t2 . "//" . Line::_(__LINE__, __CLASS__) . " do your thing here";
				$code .= PHP_EOL . $t1 . "}";
				$code .= PHP_EOL . $t1 . "else";
				$code .= PHP_EOL . $t1 . "{";
				$code .= $this->getRemovalCode($string, $removeString, $t2);
				$code .= PHP_EOL . $t1 . "}";
				break;

			case 10: // Repeatable Value
				$code .= PHP_EOL . PHP_EOL . $t1 . "//" . Line::_(__LINE__, __CLASS__) . " filter $as based on repeatable value";
				$code .= PHP_EOL . $t1 . "if (Super__"."_1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check({$string}->{$field}))";
				$code .= PHP_EOL . $t1 . "{";
				$code .= PHP_EOL . $t2 . "\$array = json_decode({$string}->{$field}, true);";
				$code .= PHP_EOL . $t2 . "if (Super__"."_0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$array))";
				$code .= PHP_EOL . $t2 . "{";
				$code .= PHP_EOL . $t3 . "//" . Line::_(__LINE__, __CLASS__) . " do your thing here";
				$code .= PHP_EOL . $t2 . "}";
				$code .= PHP_EOL . $t2 . "else";
				$code .= PHP_EOL . $t2 . "{";
				$code .= $this->getRemovalCode($string, $removeString, $t3);
				$code .= PHP_EOL . $t2 . "}";
				$code .= PHP_EOL . $t1 . "}";
				$code .= PHP_EOL . $t1 . "else";
				$code .= PHP_EOL . $t1 . "{";
				$code .= $this->getRemovalCode($string, $removeString, $t2);
				$code .= PHP_EOL . $t1 . "}";
				break;
		}

		return $code;
	}

	/**
	 * Generate the PHP code line to remove or unset a variable.
	 *
	 * @param  string  $string
	 * @param  string  $removeString
	 * @param  string  $indent
	 *
	 * @return string
	 * @since  5.1.2
	 */
	protected function getRemovalCode(string $string, string $removeString, string $indent): string
	{
		if ($removeString == $string)
		{
			return PHP_EOL . $indent . "//" . Line::_(__LINE__, __CLASS__) . " Remove $string if not valid."
			     . PHP_EOL . $indent . "$string = null;"
			     . PHP_EOL . $indent . "return false;";
		}

		return PHP_EOL . $indent . "//" . Line::_(__LINE__, __CLASS__) . " Unset $string if not valid."
		     . PHP_EOL . $indent . "unset($removeString);"
		     . PHP_EOL . $indent . "continue;";
	}
}

