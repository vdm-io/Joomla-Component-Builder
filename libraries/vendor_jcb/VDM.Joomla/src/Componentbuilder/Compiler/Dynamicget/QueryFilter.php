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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldDecodeFilter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteMainGet;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherFilter;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Dynamic Get Query Filter
 * 
 * @since 5.1.2
 */
final class QueryFilter
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The SiteFieldData Class.
	 *
	 * @var   SiteFieldData
	 * @since 5.1.2
	 */
	protected SiteFieldData $sitefielddata;

	/**
	 * The SiteFieldDecodeFilter Class.
	 *
	 * @var   SiteFieldDecodeFilter
	 * @since 5.1.2
	 */
	protected SiteFieldDecodeFilter $sitefielddecodefilter;

	/**
	 * The SiteMainGet Class.
	 *
	 * @var   SiteMainGet
	 * @since 5.1.2
	 */
	protected SiteMainGet $sitemainget;

	/**
	 * The OtherFilter Class.
	 *
	 * @var   OtherFilter
	 * @since 5.1.2
	 */
	protected OtherFilter $otherfilter;

	/**
	 * Constructor.
	 *
	 * @param Config                  $config                  The Config Class.
	 * @param SiteFieldData           $sitefielddata           The SiteFieldData Class.
	 * @param SiteFieldDecodeFilter   $sitefielddecodefilter   The SiteFieldDecodeFilter Class.
	 * @param SiteMainGet             $sitemainget             The SiteMainGet Class.
	 * @param OtherFilter             $otherfilter             The OtherFilter Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, SiteFieldData $sitefielddata,
		SiteFieldDecodeFilter $sitefielddecodefilter,
		SiteMainGet $sitemainget, OtherFilter $otherfilter)
	{
		$this->config = $config;
		$this->sitefielddata = $sitefielddata;
		$this->sitefielddecodefilter = $sitefielddecodefilter;
		$this->sitemainget = $sitemainget;
		$this->otherfilter = $otherfilter;
	}

	/**
	 * Build the dynamic query filters for a dynamic get.
	 *
	 * @param  array   $filter  The filter configuration array.
	 * @param  string  $code    The code representing the view context.
	 * @param  string  $tab     The indentation tab string.
	 *
	 * @return string  The generated filter query strings.
	 * @since  5.1.2
	 */
	public function get(array $filter, string $code, string $tab = ''): string
	{
		if (empty($filter) || empty($code))
		{
			return '';
		}

		$filters = '';

		foreach ($filter as $ter)
		{
			if (empty($ter['table_key']) || empty($ter['key']) ||
				strpos((string) $ter['table_key'], '.') === false)
			{
				continue;
			}

			$as     = '';
			$field  = '';
			$string = '';

			list($as, $field) = array_map('trim', explode('.', (string) $ter['table_key']));

			$path = $code . '.' . $ter['key'] . '.' . $as . '.' . $field;
			$filterType = $ter['filter_type'] ?? 0;
			$operator = $ter['operator'] ?? '=';

			switch ($filterType)
			{
				case 1: // COM_COMPONENTBUILDER_DYNAMIC_GET_ID
					$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$query->where('" . $ter['table_key'] . " "
						. $operator . " ' . (int) \$pk);";
					break;

				case 2: // COM_COMPONENTBUILDER_DYNAMIC_GET_USER
					$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$query->where('" . $ter['table_key'] . " "
						. $operator . " ' . (int) \$this->userId);";
					break;

				case 3: // COM_COMPONENTBUILDER_DYNAMIC_GET_ACCESS_LEVEL
					$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$query->where('" . $ter['table_key'] . " "
						. $operator . " (' . implode(',', \$this->levels) . ')');";
					break;

				case 4: // COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
					$decodeChecker = $this->sitefielddata->get('decode.' . $path);
					$stateKey = $ter['state_key'] ?? 'none';

					if (ArrayHelper::check($decodeChecker) || $stateKey === 'array')
					{
						$this->sitefielddecodefilter
							->set($this->config->build_target . '.' . $path, $ter);
					}
					else
					{
						$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$query->where('" . $ter['table_key'] . " "
							. $operator . " (' . implode(',', \$this->groups) . ')');";
					}
					break;

				case 5: // COM_COMPONENTBUILDER_DYNAMIC_GET_CATEGORIES
					$string = PHP_EOL . Indent::_(2) . $tab . "//" . Line::_(__LINE__, __CLASS__)
						. " (TODO) The dynamic category filter is not ready.";
					break;

				case 6: // COM_COMPONENTBUILDER_DYNAMIC_GET_TAGS
					$string = PHP_EOL . Indent::_(2) . $tab . "//" . Line::_(__LINE__, __CLASS__)
						. " (TODO) The dynamic tags filter is not ready.";
					break;

				case 7: // COM_COMPONENTBUILDER_DYNAMIC_GET_DATE
					$string = PHP_EOL . Indent::_(2) . $tab . "//" . Line::_(__LINE__, __CLASS__)
						. " (TODO) The dynamic date filter is not ready.";
					break;

				case 8: // COM_COMPONENTBUILDER_DYNAMIC_GET_FUNCTIONVAR
					$string = $this->buildFunctionVarFilter($ter, $tab);
					break;

				case 9:  // COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE
				case 10: // COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
					$this->sitefielddecodefilter
						->set($this->config->build_target . '.' . $path, $ter);
					break;

				case 11: // COM_COMPONENTBUILDER_DYNAMIC_GET_OTHER
					if (strpos($as, '(') !== false)
					{
						list($dump, $as) = array_map('trim', explode('(', $as));
						$field = trim(str_replace(')', '', $field));
					}
					$stateKey = $ter['state_key'] ?? 'error';
					$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$query->where('" . $ter['table_key'] . " "
						. $operator . " " . $stateKey . "');";
					break;
			}

			if (StringHelper::check($string))
			{
				if ($as === 'a' ||
					$this->sitemainget->exists($this->config->build_target . '.' . $code . '.' . $as))
				{
					$filters .= $string;
				}
				elseif ($as !== 'a')
				{
					$this->otherfilter->set($this->config->build_target . '.' . $code . '.' . $as . '.' . $field, $string);
				}
			}
		}

		return $filters;
	}

	/**
	 * Build dynamic filter for "FunctionVar" filter type (case 8).
	 *
	 * @param  array   $ter  The filter term configuration.
	 * @param  string  $tab  The indentation tab string.
	 *
	 * @return string  The generated filter string.
	 * @since  5.1.2
	 */
	protected function buildFunctionVarFilter(array $ter, string $tab): string
	{
		$string = '';
		$operator = $ter['operator'] ?? '=';
		$stateKey = $ter['state_key'] ?? 'error';

		if ($operator === 'IN' || $operator === 'NOT IN')
		{
			$string .= PHP_EOL . Indent::_(2) . $tab . "//" . Line::_(__LINE__, __CLASS__) . " Check if "
				. $stateKey . " is an array with values.";
			$string .= PHP_EOL . Indent::_(2) . $tab . "\$array = " . $stateKey . ";";
			$string .= PHP_EOL . Indent::_(2) . $tab . "if (isset(\$array) && Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$array))";
			$string .= PHP_EOL . Indent::_(2) . $tab . "{";
			$string .= PHP_EOL . Indent::_(2) . $tab . Indent::_(1)
				. "\$query->where('" . $ter['table_key'] . " " . $operator
				. " (' . implode(',', \$array) . ')');";
			$string .= PHP_EOL . Indent::_(2) . $tab . "}";

			if (!isset($ter['empty']) || !$ter['empty'])
			{
				$string .= PHP_EOL . Indent::_(2) . $tab . "else";
				$string .= PHP_EOL . Indent::_(2) . $tab . "{";
				$string .= PHP_EOL . Indent::_(2) . $tab . Indent::_(1) . "return false;";
				$string .= PHP_EOL . Indent::_(2) . $tab . "}";
			}
		}
		else
		{
			$string .= PHP_EOL . Indent::_(2) . $tab . "//" . Line::_(__LINE__, __CLASS__) . " Check if "
				. $stateKey . " is a string or numeric value.";
			$string .= PHP_EOL . Indent::_(2) . $tab . "\$checkValue = " . $stateKey . ";";
			$string .= PHP_EOL . Indent::_(2) . $tab . "if (isset(\$checkValue) && Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$checkValue))";
			$string .= PHP_EOL . Indent::_(2) . $tab . "{";
			$string .= PHP_EOL . Indent::_(2) . $tab . Indent::_(1)
				. "\$query->where('" . $ter['table_key'] . " " . $operator
				. " ' . \$db->quote(\$checkValue));";
			$string .= PHP_EOL . Indent::_(2) . $tab . "}";
			$string .= PHP_EOL . Indent::_(2) . $tab . "elseif (is_numeric(\$checkValue))";
			$string .= PHP_EOL . Indent::_(2) . $tab . "{";
			$string .= PHP_EOL . Indent::_(2) . $tab . Indent::_(1)
				. "\$query->where('" . $ter['table_key'] . " " . $operator
				. " ' . \$checkValue);";
			$string .= PHP_EOL . Indent::_(2) . $tab . "}";

			if (!isset($ter['empty']) || !$ter['empty'])
			{
				$string .= PHP_EOL . Indent::_(2) . $tab . "else";
				$string .= PHP_EOL . Indent::_(2) . $tab . "{";
				$string .= PHP_EOL . Indent::_(2) . $tab . Indent::_(1) . "return false;";
				$string .= PHP_EOL . Indent::_(2) . $tab . "}";
			}
		}

		return $string;
	}
}

