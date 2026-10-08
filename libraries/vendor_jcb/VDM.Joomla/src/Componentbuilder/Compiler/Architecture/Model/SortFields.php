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


use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Sort Fields Class.
 * 
 * Builds the method a list model runs to say which of its fields a list may be
 * ordered by.
 * 
 * @since 6.1.7
 */
final class SortFields
{
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
	 * @param Sort $sort The Sort Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Sort $sort)
	{
		$this->sort = $sort;
	}

	/**
	 * Build the sort fields method of a list model.
	 *
	 * Only a view that was given something to sort by gets one.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  string  The method, or nothing when the view sorts by nothing.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameListCode): string
	{
		// keep track of all fields already added
		$donelist = array('ordering', 'published');
		// set the default first
		$fields = "return array(";
		$fields .= PHP_EOL . Indent::_(3) . "'a.ordering' => Text:"
			. ":_('JGRID_HEADING_ORDERING')";
		$fields .= "," . PHP_EOL . Indent::_(3) . "'a.published' => Text:"
			. ":_('JSTATUS')";

		// add the rest of the set filters
		if ($this->sort->exists($nameListCode))
		{
			foreach ($this->sort->get($nameListCode) as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= "," . PHP_EOL . Indent::_(3)
							. "'category_title' => Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
							. $filter['lang'] . "')";
					}
					elseif (ArrayHelper::check(
						$filter['custom']
					))
					{
						$fields .= "," . PHP_EOL . Indent::_(3) . "'"
							. $filter['custom']['db'] . "."
							. $filter['custom']['text'] . "' => Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
							. $filter['lang'] . "')";
					}
					else
					{
						$fields .= "," . PHP_EOL . Indent::_(3) . "'a."
							. $filter['code'] . "' => Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
							. $filter['lang'] . "')";
					}
				}
			}
		}
		$fields .= "," . PHP_EOL . Indent::_(3) . "'a.id' => Text:"
			. ":_('JGRID_HEADING_ID')";
		$fields .= PHP_EOL . Indent::_(2) . ");";

		// return fields
		return $fields;
	}
}

