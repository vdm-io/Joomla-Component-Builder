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
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherWhere;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteMainGet;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Dynamic Get Query Where
 * 
 * @since 5.1.2
 */
final class QueryWhere
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The OtherWhere Class.
	 *
	 * @var   OtherWhere
	 * @since 5.1.2
	 */
	protected OtherWhere $otherwhere;

	/**
	 * The SiteMainGet Class.
	 *
	 * @var   SiteMainGet
	 * @since 5.1.2
	 */
	protected SiteMainGet $sitemainget;

	/**
	 * Constructor.
	 *
	 * @param Config        $config        The Config Class.
	 * @param OtherWhere    $otherwhere    The OtherWhere Class.
	 * @param SiteMainGet   $sitemainget   The SiteMainGet Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, OtherWhere $otherwhere,
		SiteMainGet $sitemainget)
	{
		$this->config = $config;
		$this->otherwhere = $otherwhere;
		$this->sitemainget = $sitemainget;
	}

	/**
	 * Process and build WHERE clauses for a given dynamic get.
	 *
	 * @param  array   $where  The WHERE clause definitions.
	 * @param  string  $code   The code identifier for the view.
	 * @param  string  $tab    Optional tab/indentation prefix.
	 *
	 * @return string  The generated WHERE clauses as a string.
	 * @since  5.1.2
	 */
	public function get(array $where, string $code, string $tab = ''): string
	{
		if (empty($where) || empty($code))
		{
			return '';
		}

		$wheres = '';

		foreach ($where as $whe)
		{
			if (empty($whe['table_key']) || trim($whe['value_key']) == "")
			{
				continue;
			}

			$as    = '';
			$field = '';
			$value = '';

			// Extract table alias and field
			list($as, $field) = array_map(
				'trim',
				explode('.', (string) $whe['table_key'])
			);

			// Determine value formatting
			if (is_numeric($whe['value_key']))
			{
				$value = " " . $whe['value_key'] . "');";
			}
			elseif (strpos((string) $whe['value_key'], '$') !== false)
			{
				if (!empty($whe['operator']) && ($whe['operator'] === 'IN' || $whe['operator'] === 'NOT IN'))
				{
					$value = " (' . implode(',', " . $whe['value_key'] . ") . ')');";
				}
				else
				{
					$value = " ' . \$db->quote(" . $whe['value_key'] . "));";
				}
			}
			elseif (strpos((string) $whe['value_key'], '.') !== false)
			{
				if (strpos((string) $whe['value_key'], "'") !== false)
				{
					$value = " ' . \$db->quote(" . $whe['value_key'] . "));";
				}
				else
				{
					$value = " " . $whe['value_key'] . "');";
				}
			}
			elseif (StringHelper::check($whe['value_key']))
			{
				$value = " " . $whe['value_key'] . "');";
			}

			// Only proceed if we have a valid value
			if (StringHelper::check($value))
			{
				$tabe = ($as === 'a') ? $tab : '';
				if (empty($whe['operator']))
				{
					continue;
				}

				// Build string based on operator
				if ($whe['operator'] === 'IN' || $whe['operator'] === 'NOT IN')
				{
					$string = "if (isset(" . $whe['value_key'] . ") && "
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check("
						. $whe['value_key'] . "))";
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1) . "{";
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(2)
						. "//" . Line::_(__LINE__, __CLASS__) . " Get where "
						. $whe['table_key'] . " is " . $whe['value_key'];
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(2)
						. "\$query->where('" . $whe['table_key'] . " "
						. $whe['operator'] . $value;
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1) . "}";
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1) . "else";
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1) . "{";
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(2) . "return false;";
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1) . "}";
				}
				else
				{
					$string = "//" . Line::_(__LINE__, __CLASS__) . " Get where "
						. $whe['table_key'] . " is " . $whe['value_key'];
					$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1)
						. "\$query->where('" . $whe['table_key'] . " "
						. $whe['operator'] . $value;
				}

				// Append or store WHERE clause
				if (
					$as === 'a' ||
					$this->sitemainget->exists($this->config->build_target . '.' . $code . '.' . $as)
				)
				{
					$wheres .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . $string;
				}
				elseif ($as !== 'a')
				{
					$this->otherwhere->set(
						$this->config->build_target . '.' . $code . '.' . $as . '.' . $field,
						PHP_EOL . Indent::_(2) . $string
					);
				}
			}
		}

		return $wheres;
	}
}

