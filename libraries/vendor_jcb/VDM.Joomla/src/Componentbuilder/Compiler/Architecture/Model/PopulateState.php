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


use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Populate State Class.
 * 
 * Builds the statements a list model runs to read its filters, its search and
 * its ordering off the request and put them in the state.
 * 
 * @since 6.1.7
 */
final class PopulateState
{
	/**
	 * The Admin Filter Type Builder Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The Filter Builder Class.
	 *
	 * @var   Filter
	 * @since 6.1.7
	 */
	protected Filter $filter;

	/**
	 * The Field Names Builder Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

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
	 * @param AdminFilterType $adminfiltertype The Admin Filter Type Builder Class.
	 * @param Filter          $filter          The Filter Builder Class.
	 * @param FieldNames      $fieldnames      The Field Names Builder Class.
	 * @param Sort            $sort            The Sort Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(AdminFilterType $adminfiltertype,
		Filter $filter,
		FieldNames $fieldnames,
		Sort $sort)
	{
		$this->adminfiltertype = $adminfiltertype;
		$this->filter = $filter;
		$this->fieldnames = $fieldnames;
		$this->sort = $sort;
	}

	/**
	 * Build the populate state statements of a list model.
	 *
	 * Every filter and sort the view offers is read, along with the search and
	 * the ordering every list model has.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		// reset bucket
		$state = '';
		// keep track of all fields already added
		$donelist = [];
		// we must add the formSubmited code if new above filters is used (2 = topbar)
		$new_filter = false;
		if ($this->adminfiltertype->get($nameListCode, 1) == 2)
		{
			$state      .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Check if the form was submitted";
			$state      .= PHP_EOL . Indent::_(2) . "\$formSubmited"
				. " = \$input->post->get('form_submited');";
			$new_filter = true;
		}
		// add the default populate states (this must be added first)
		$state .= $this->defaults($nameSingleCode, $new_filter);
		// add the filters
		if ($this->filter->exists($nameListCode))
		{
			foreach ($this->filter->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$state                     .= $this->filterCode(
						$filter, $new_filter
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
					$state .= $this->filterCode(
						$filter, $new_filter
					);
					$donelist[$filter['code']] = true;
				}
			}
		}

		return $state;
	}
	/**
	 * Build the statements every list model runs whatever the view offers.
	 *
	 * The search, the access and the published state are read for every view
	 * that carries them.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   bool    $newFilter       Whether the view filters from the top bar.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	protected function defaults(&$nameSingleCode, $newFilter): string
	{
		$state = '';
		// start filter
		$filter = array('type' => 'text');
		// if access is not set add its default filter here
		if (!$this->fieldnames->isString($nameSingleCode . '.access'))
		{
			$filter['code'] = "access";
			$state          .= $this->filterCode(
				$filter, $newFilter, ", 0, 'int'"
			);
		}
		// if published is not set add its default filter here
		if (!$this->fieldnames->isString($nameSingleCode . '.published'))
		{
			$filter['code'] = "published";
			$state          .= $this->filterCode(
				$filter, false, ", ''"
			);
		}
		// if created_by is not set add its default filter here
		if (!$this->fieldnames->isString($nameSingleCode . '.created_by'))
		{
			$filter['code'] = "created_by";
			$state          .= $this->filterCode(
				$filter, false, ", ''"
			);
		}
		// if created is not set add its default filter here
		if (!$this->fieldnames->isString($nameSingleCode . '.created'))
		{
			$filter['code'] = "created";
			$state          .= $this->filterCode(
				$filter, false
			);
		}

		// the sorting defaults are always added
		$filter['code'] = "sorting";
		$state          .= $this->filterCode(
			$filter, false, ", 0, 'int'"
		);
		// the search defaults are always added
		$filter['code'] = "search";
		$state          .= $this->filterCode($filter, false);

		return $state;
	}
	/**
	 * Build the statements that read one filter off the request.
	 *
	 * The value is read through the state it was last put in, so that a request
	 * without it keeps what the user chose before.
	 *
	 * @param   array   $filter     The field being read.
	 * @param   bool    $newFilter  Whether the view filters from the top bar.
	 * @param   string  $extra      What the filter defaults to.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	protected function filterCode(&$filter, $newFilter, $extra = ''): string
	{
		$state = '';
		// add category stuff (may still remove these) TODO
		if (isset($filter['type']) && $filter['type'] === 'category')
		{
			$state .= PHP_EOL . PHP_EOL . Indent::_(2)
				. "\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
			$state .= PHP_EOL . Indent::_(2)
				. "\$this->setState('filter.category', \$category);";
			$state .= PHP_EOL . PHP_EOL . Indent::_(2)
				. "\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
			$state .= PHP_EOL . Indent::_(2)
				. "\$this->setState('filter.category_id', \$categoryId);";
		}
		// always add the default filter
		$state .= PHP_EOL . PHP_EOL . Indent::_(2) . "\$" . $filter['code']
			. " = \$this->getUserStateFromRequest(\$this->context . '.filter."
			. $filter['code'] . "', 'filter_" . $filter['code']
			. "'" . $extra . ");";
		if ($newFilter)
		{
			// add the new filter option
			$state .= PHP_EOL . Indent::_(2)
				. "if (\$formSubmited)";
			$state .= PHP_EOL . Indent::_(2) . "{";
			$state .= PHP_EOL . Indent::_(3) . "\$" . $filter['code']
				. " = \$input->post->get('" . $filter['code'] . "');";
			$state .= PHP_EOL . Indent::_(3)
				. "\$this->setState('filter." . $filter['code']
				. "', \$" . $filter['code'] . ");";
			$state .= PHP_EOL . Indent::_(2) . "}";
		}
		else
		{
			// the old filter option
			$state .= PHP_EOL . Indent::_(2)
				. "\$this->setState('filter." . $filter['code']
				. "', \$" . $filter['code'] . ");";
		}

		return $state;
	}
}

