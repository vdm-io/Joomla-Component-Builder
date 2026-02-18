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
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\JoinStructure;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteDynamicGet;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherQuery;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Dynamic Get Queries
 * 
 * @since 5.1.2
 */
final class Queries
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The JoinStructure Class.
	 *
	 * @var   JoinStructure
	 * @since 5.1.2
	 */
	protected JoinStructure $joinstructure;

	/**
	 * The SiteDynamicGet Class.
	 *
	 * @var   SiteDynamicGet
	 * @since 5.1.2
	 */
	protected SiteDynamicGet $sitedynamicget;

	/**
	 * The OtherQuery Class.
	 *
	 * @var   OtherQuery
	 * @since 5.1.2
	 */
	protected OtherQuery $otherquery;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The custom view query checker array.
	 *
	 * @var   array
	 * @since 5.1.2
	 */
	protected $customViewQueryChecker = [];

	/**
	 * Constructor.
	 *
	 * @param Config           $config           The Config Class.
	 * @param JoinStructure    $joinstructure    The JoinStructure Class.
	 * @param SiteDynamicGet   $sitedynamicget   The SiteDynamicGet Class.
	 * @param OtherQuery       $otherquery       The OtherQuery Class.
	 * @param Placeholder      $placeholder      The Placeholder Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, JoinStructure $joinstructure,
		SiteDynamicGet $sitedynamicget, OtherQuery $otherquery,
		Placeholder $placeholder)
	{
		$this->config = $config;
		$this->joinstructure = $joinstructure;
		$this->sitedynamicget = $sitedynamicget;
		$this->otherquery = $otherquery;
		$this->placeholder = $placeholder;
	}

	/**
	 * Get the dynamic get query.
	 *
	 * @param  array   $gets   The data to build the query from.
	 * @param  string  $code   The build code.
	 * @param  string  $tab    The tab indentation.
	 * @param  string  $type   The query type (main|custom).
	 *
	 * @return string  The compiled query string.
	 * @since  5.1.2
	 */
	public function get(array $gets, $code, string $tab = '', string $type = 'main'): string
	{
		if (empty($gets) || empty($code))
		{
			return '';
		}

		$query = '';

		$mainAsArray = [];
		$check       = 'zzz';

		foreach ($gets as $nr => $theGet)
		{
			if ($this->isUniqueQueryEntry($theGet, $code))
			{
				$getItem = $this->buildSelectPart($theGet, $tab);

				$getItem .= $this->buildFromOrJoinPart($theGet, $nr, $tab, $type, $check);

				$query .= $this->appendWithMethodDefaults($theGet, $code, $getItem, $check, $mainAsArray);
			}
		}

		return $query;
	}

	/**
	 * Check if the query entry is unique.
	 *
	 * @param  array   $theGet  The query data.
	 * @param  string  $code     The build code.
	 *
	 * @return bool  True if unique, false otherwise.
	 * @since  5.1.2
	 */
	protected function isUniqueQueryEntry(array $theGet, string $code): bool
	{
		$checker = md5(serialize($theGet) . $code);
		$target  = $this->config->build_target;

		if (!isset($this->customViewQueryChecker[$target][$checker]))
		{
			$this->customViewQueryChecker[$target][$checker] = true;
			return true;
		}

		return false;
	}

	/**
	 * Build the select part of the query.
	 *
	 * @param  array   $theGet  The query data.
	 * @param  string  $tab      The tab indentation.
	 *
	 * @return string  The select part.
	 * @since  5.1.2
	 */
	protected function buildSelectPart(array $theGet, string $tab): string
	{
		$getItem = '';
		if (isset($theGet['selection']['type']) && StringHelper::check($theGet['selection']['type']))
		{
			$getItem = PHP_EOL . PHP_EOL . Indent::_(1) . $tab
				. Indent::_(1) . "//" . Line::_(__LINE__, __CLASS__)
				. " Get from " . $theGet['selection']['table']
				. " as " . $theGet['as'];

			$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. $theGet['selection']['select'];
		}
		elseif (!empty($theGet['selection']['select']))
		{
			$getItem = PHP_EOL . PHP_EOL . Indent::_(1) . $tab
				. Indent::_(1) . "//" . Line::_(__LINE__, __CLASS__)
				. " Get data";

			$getItem .= PHP_EOL . $this->placeholder->update_(
				$theGet['selection']['select']
			);
		}

		return $getItem;
	}

	/**
	 * Build the FROM or JOIN part of the query.
	 *
	 * @param  array   $theGet  The query data.
	 * @param  int     $nr       The current iteration number.
	 * @param  string  $tab      The tab indentation.
	 * @param  string  $type     The query type.
	 * @param  string  &$check   The check variable.
	 *
	 * @return string  The FROM or JOIN part.
	 * @since  5.1.2
	 */
	protected function buildFromOrJoinPart(array $theGet, int $nr, string $tab, string $type, string &$check): string
	{
		$output = '';

		if (
			($nr === 0
				&& (!isset($theGet['join_field']) || !StringHelper::check($theGet['join_field']))
				&& isset($theGet['selection']['type']) && StringHelper::check($theGet['selection']['type']))
			|| ($type === 'custom'
				&& isset($theGet['selection']['type']) && StringHelper::check($theGet['selection']['type']))
		)
		{
			$output .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. '$query->from(' . $theGet['selection']['from'] . ');';
		}
		elseif (
			isset($theGet['join_field']) && StringHelper::check($theGet['join_field'])
			&& isset($theGet['selection']['type']) && StringHelper::check($theGet['selection']['type'])
		)
		{
			$output .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. "\$query->join('" . $theGet['type'] . "', (" . $theGet['selection']['from']
				. ") . ' ON (' . \$db->quoteName('" . $theGet['on_field']
				. "') . ' " . $theGet['operator']
				. " ' . \$db->quoteName('" . $theGet['join_field'] . "') . ')');";

			$check = current(explode(".", (string) $theGet['on_field']));
		}

		return $output;
	}

	/**
	 * Append the method defaults handling to the query string.
	 *
	 * @param  array   $theGet       The query data.
	 * @param  string  $code         The build code.
	 * @param  string  $getItem      The built query part.
	 * @param  string  $check        The check variable.
	 * @param  array   &$mainAsArray The main AS array.
	 *
	 * @return string  The resulting query addition.
	 * @since  5.1.2
	 */
	protected function appendWithMethodDefaults(array $theGet, string $code, string $getItem, string $check, array &$mainAsArray): string
	{
		$output = '';

		if (($default = $this->joinstructure->get($theGet, $code)) !== null)
		{
			$joinFieldKey = $this->config->build_target . '.' . $default['code'] . '.' . $default['as'] . '.' . $default['join_field'];

			if (($join_field_ = $this->sitedynamicget->get($joinFieldKey)) !== null
				&& !in_array($check, $mainAsArray))
			{
				$this->otherquery->add(
					$this->config->build_target . '.' . $default['code'] . '.' . $join_field_ . '.' . $default['valueName'],
					$getItem,
					false
				);
			}
			else
			{
				$mainAsArray[] = $default['as'];
				$output .= $getItem;
			}
		}

		return $output;
	}
}

