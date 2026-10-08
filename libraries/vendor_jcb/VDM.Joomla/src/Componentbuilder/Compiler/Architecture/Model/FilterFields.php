<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Filter Fields Class.
 * 
 * Builds the array a list model declares of every field its list may be
 * filtered, searched or ordered by.
 * 
 * @since 6.1.7
 */
final class FilterFields
{
	/**
	 * The Filter Builder Class.
	 *
	 * @var   Filter
	 * @since 6.1.7
	 */
	protected Filter $filter;

	/**
	 * The Access Switch Builder Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The Sort Builder Class.
	 *
	 * @var   Sort
	 * @since 6.1.7
	 */
	protected Sort $sort;

	/**
	 * Constructor.
	 *
	 * @param Filter       $filter       The Filter Builder Class.
	 * @param AccessSwitch $accessswitch The Access Switch Builder Class.
	 * @param Sort         $sort         The Sort Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Filter $filter,
		AccessSwitch $accessswitch,
		Sort $sort)
	{
		$this->filter = $filter;
		$this->accessswitch = $accessswitch;
		$this->sort = $sort;
	}

	/**
	 * Build the filter fields array of a list model.
	 *
	 * Every filter and sort the view offers is named, along with the fields
	 * every list model carries.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The array.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		// keep track of all fields already added
		$donelist = array('id'         => true, 'search' => true,
			'published'  => true, 'access' => true,
			'created_by' => true, 'modified_by' => true);
		// default filter fields
		$fields = "'a.id','id'";
		$fields .= "," . PHP_EOL . Indent::_(4) . "'a.published','published'";
		if ($this->accessswitch->exists($nameSingleCode))
		{
			$fields .= "," . PHP_EOL . Indent::_(4) . "'a.access','access'";
		}
		$fields .= "," . PHP_EOL . Indent::_(4) . "'a.ordering','ordering'";
		$fields .= "," . PHP_EOL . Indent::_(4) . "'a.created_by','created_by'";
		$fields .= "," . PHP_EOL . Indent::_(4)
			. "'a.modified_by','modified_by'";

		// add the rest of the set filters
		if ($this->filter->exists($nameListCode))
		{
			foreach ($this->filter->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$fields                    .= $this->fieldCode(
						$filter
					);
					$donelist[$filter['code']] = true;
				}
			}
		}
		// add the rest of the set filters
		if ($this->sort->exists($nameListCode))
		{
			foreach ($this->sort->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$fields .= $this->fieldCode(
						$filter
					);
					$donelist[$filter['code']] = true;
				}
			}
		}

		return $fields;
	}
	/**
	 * Build the line that names one field of the filter fields array.
	 *
	 * A field the view filters on in the top bar is named twice, once as the
	 * field and once as the filter it is reached by.
	 *
	 * @param   array  $filter  The field being named.
	 *
	 * @return  string  The line.
	 *
	 * @since   6.1.7
	 */
	protected function fieldCode(&$filter): string
	{
		// add the category stuff (may still remove these) TODO
		if ($filter['type'] === 'category')
		{
			$field = "," . PHP_EOL . Indent::_(4)
				. "'c.title','category_title'";
			$field .= "," . PHP_EOL . Indent::_(4)
				. "'c.id', 'category_id'";
			if ($filter['code'] != 'category')
			{
				$field .= "," . PHP_EOL . Indent::_(4) . "'a."
					. $filter['code'] . "','" . $filter['code']
					. "'";
			}
		}
		else
		{
			// check if custom field is set
			if (ArrayHelper::check(
					$filter['custom']
				)
				&& isset($filter['custom']['db'])
				&& StringHelper::check(
					$filter['custom']['db']
				)
				&& isset($filter['custom']['text'])
				&& StringHelper::check(
					$filter['custom']['text']
				))
			{
				$field = "," . PHP_EOL . Indent::_(4) . "'"
					. $filter['custom']['db'] . "."
					. $filter['custom']['text'] . "','" . $filter['code']
					. "'";
			}
			else
			{
				$field = "," . PHP_EOL . Indent::_(4) . "'a."
					. $filter['code'] . "','" . $filter['code']
					. "'";
			}
		}

		return $field;
	}
}

