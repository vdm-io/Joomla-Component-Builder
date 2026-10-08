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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Model Filter Query Class.
 * 
 * Builds the per field filter clauses a list model applies. A field filtered
 * from the top bar with multi select enabled gets a clause that accepts a
 * list of values, every other field gets the single value clause.
 * 
 * Category filters are skipped here, the list query handles those itself.
 * 
 * The clauses read the same on every Joomla target, so this is one class.
 * 
 * @since  6.1.7
 */
final class FilterQuery
{
	/**
	 * The Filter Class.
	 *
	 * @var   Filter
	 * @since 6.1.7
	 */
	protected Filter $filter;

	/**
	 * The Admin Filter Type Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * Constructor.
	 *
	 * @param Filter           $filter            The Filter Class.
	 * @param AdminFilterType  $adminfiltertype   The Admin Filter Type Class.
	 * @param ContentOne       $contentone        The ContentOne Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Filter $filter,
		AdminFilterType $adminfiltertype,
		ContentOne $contentone)
	{
		$this->filter = $filter;
		$this->adminfiltertype = $adminfiltertype;
		$this->contentone = $contentone;
	}

	/**
	 * Build the per field filter clauses of a list model.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get($nameListCode)
	{
		if ($this->filter->exists($nameListCode))
		{
			// component helper name
			$Helper = $this->contentone->get('Component') . 'Helper';
			// start building the filter query
			$filterQuery = "";
			foreach ($this->filter->get($nameListCode) as $filter)
			{
				// only add for none category fields
				if ($filter['type'] != 'category')
				{
					$filterQuery .= PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Filter by "
						. ucwords((string) $filter['code']) . ".";
					// we only add multi filter option if new filter type
					// and we have multi filter set for this field (2 = topbar)
					if ($this->adminfiltertype->get($nameListCode, 1) == 2
						&& isset($filter['multi'])
						&& $filter['multi'] == 2)
					{
						$filterQuery .= $this->getMultiFilterQuery(
							$filter, $Helper
						);
					}
					else
					{
						$filterQuery .= $this->getSingleFilterQuery(
							$filter, $Helper
						);
					}
				}
			}

			return $filterQuery;
		}

		return '';
	}

	/**
	 * Build the filter clause of one single value field.
	 *
	 * @param   array   $filter  The field/filter.
	 * @param   string  $Helper  The helper name of the component being built.
	 * @param   string  $a       The db table target name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function getSingleFilterQuery($filter, $Helper, $a = "a")
	{
		$filterQuery = PHP_EOL . Indent::_(2) . "\$_"
			. $filter['code'] . " = \$this->getState('filter."
			. $filter['code'] . "');";
		$filterQuery .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3) . "if (is_float(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (float) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(3) . "else";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (int) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "elseif ("
			. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$_" . $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . \$db->quote(\$db->escape(\$_" . $filter['code']
			. ")));";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";

		return $filterQuery;
	}

	/**
	 * Build the filter clause of one multi select field.
	 *
	 * @param   array   $filter  The field/filter.
	 * @param   string  $Helper  The helper name of the component being built.
	 * @param   string  $a       The db table target name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function getMultiFilterQuery($filter, $Helper, $a = "a")
	{
		$filterQuery = PHP_EOL . Indent::_(2) . "\$_"
			. $filter['code'] . " = \$this->getState('filter."
			. $filter['code'] . "');";
		$filterQuery .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3) . "if (is_float(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (float) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(3) . "else";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (int) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "elseif ("
			. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$_" . $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . \$db->quote(\$db->escape(\$_" . $filter['code']
			. ")));";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "elseif ("
			. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$_" . $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";

		$filterQuery .= PHP_EOL . Indent::_(3) . "//"
			. Line::_(__Line__, __Class__) . " Secure the array for the query";

		$filterQuery .= PHP_EOL . Indent::_(3) . "\$_" . $filter['code']
			. " = array_map( function (\$val) use(&\$db) {";
		$filterQuery .= PHP_EOL . Indent::_(4) . "if (is_numeric(\$val))";
		$filterQuery .= PHP_EOL . Indent::_(4) . "{";
		$filterQuery .= PHP_EOL . Indent::_(5) . "if (is_float(\$val))";
		$filterQuery .= PHP_EOL . Indent::_(5) . "{";
		$filterQuery .= PHP_EOL . Indent::_(6) . "return (float) \$val;";
		$filterQuery .= PHP_EOL . Indent::_(5) . "}";
		$filterQuery .= PHP_EOL . Indent::_(5) . "else";
		$filterQuery .= PHP_EOL . Indent::_(5) . "{";
		$filterQuery .= PHP_EOL . Indent::_(6) . "return (int) \$val;";
		$filterQuery .= PHP_EOL . Indent::_(5) . "}";
		$filterQuery .= PHP_EOL . Indent::_(4) . "}";
		$filterQuery .= PHP_EOL . Indent::_(4) . "elseif ("
			. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$val))";
		$filterQuery .= PHP_EOL . Indent::_(4) . "{";
		$filterQuery .= PHP_EOL . Indent::_(5)
			. "return \$db->quote(\$db->escape(\$val));";
		$filterQuery .= PHP_EOL . Indent::_(4) . "}";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}, \$_"
			. $filter['code'] . ");";

		$filterQuery .= PHP_EOL . Indent::_(3) . "//"
			. Line::_(__Line__, __Class__) . " Filter by the "
			. ucwords((string) $filter['code']) . " Array.";

		$filterQuery .= PHP_EOL . Indent::_(3)
			. "\$query->where('" . $a . "." . $filter['code']
			. " IN (' . implode(',', \$_" . $filter['code'] . ") . ')');";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";

		return $filterQuery;
	}
}

