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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Adminview\DefaultOrdering;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\FilterListSetInterface;


/**
 * Admin Views Filter List Set Class.
 * 
 * Builds the fields a list view is ordered and paged by: what it can be sorted
 * on, and how many rows it shows at a time.
 * 
 * How each of those two is labelled and told to submit is what the compile
 * target decides, and they are the two extension points below.
 * 
 * @since 6.1.7
 */
class FilterListSet implements FilterListSetInterface
{
	/**
	 * The Admin Filter Type Builder Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

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
	 * The Default Ordering Class.
	 *
	 * @var   DefaultOrdering
	 * @since 6.1.7
	 */
	protected DefaultOrdering $defaultordering;

	/**
	 * Constructor.
	 *
	 * @param AdminFilterType $adminfiltertype The Admin Filter Type Builder Class.
	 * @param FieldNames      $fieldnames      The Field Names Builder Class.
	 * @param Sort            $sort            The Sort Builder Class.
	 * @param DefaultOrdering $defaultordering The Default Ordering Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(AdminFilterType $adminfiltertype,
		FieldNames $fieldnames,
		Sort $sort,
		DefaultOrdering $defaultordering)
	{
		$this->adminfiltertype = $adminfiltertype;
		$this->fieldnames = $fieldnames;
		$this->sort = $sort;
		$this->defaultordering = $defaultordering;
	}

	/**
	 * Build the list ordering fields of a list view.
	 *
	 * Only a view the component was given the searchable filter for gets any.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The fields, in xml.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		// check if this is the above/new filter option
		if ($this->adminfiltertype->get($nameListCode, 1) == 2)
		{
			// keep track of all fields already added
			$donelist = ['ordering' => true, 'id' => true];
			// now build the XML
			$list_sets   = [];
			$list_sets[] = Indent::_(1) . '<fields name="list">';
			$list_sets[] = Indent::_(2) . '<field';
			$list_sets[] = Indent::_(3) . 'name="fullordering"';
			$list_sets[] = Indent::_(3) . 'type="list"';
			$list_sets = array_merge($list_sets, $this->orderingAttributes());
			// add dynamic ordering (Admin view)
			$default_ordering = $this->defaultordering->get(
				$nameListCode
			);
			// set the default ordering
			$list_sets[] = Indent::_(3) . 'default="'
				. $default_ordering['name'] . ' '
				. $default_ordering['direction'] . '"';
			$list_sets[] = Indent::_(3) . 'validate="options"';
			$list_sets[] = Indent::_(2) . '>';
			$list_sets[] = Indent::_(3)
				. '<option value="">JGLOBAL_SORT_BY</option>';
			$list_sets[] = Indent::_(3)
				. '<option value="a.ordering ASC">JGRID_HEADING_ORDERING_ASC</option>';
			$list_sets[] = Indent::_(3)
				. '<option value="a.ordering DESC">JGRID_HEADING_ORDERING_DESC</option>';
			// add the published filter if published is not set
			if (!$this->fieldnames->isString($nameSingleCode . '.published'))
			{
				// add to done list
				$donelist['published'] = true;
				// add to xml :)
				$list_sets[] = Indent::_(3)
					. '<option value="a.published ASC">JSTATUS_ASC</option>';
				$list_sets[] = Indent::_(3)
					. '<option value="a.published DESC">JSTATUS_DESC</option>';
			}

			// add the rest of the set filters
			if ($this->sort->exists($nameListCode))
			{
				foreach ($this->sort->get($nameListCode) as $filter)
				{
					if (!isset($donelist[$filter['code']]))
					{
						if ($filter['type'] === 'category')
						{
							$list_sets[] = Indent::_(3)
								. '<option value="category_title ASC">'
								. $filter['lang_asc'] . '</option>';
							$list_sets[] = Indent::_(3)
								. '<option value="category_title DESC">'
								. $filter['lang_desc'] . '</option>';
						}
						elseif (ArrayHelper::check(
							$filter['custom']
						))
						{
							$list_sets[] = Indent::_(3) . '<option value="'
								. $filter['custom']['db'] . '.'
								. $filter['custom']['text'] . ' ASC">'
								. $filter['lang_asc'] . '</option>';
							$list_sets[] = Indent::_(3) . '<option value="'
								. $filter['custom']['db'] . '.'
								. $filter['custom']['text'] . ' DESC">'
								. $filter['lang_desc'] . '</option>';
						}
						else
						{
							$list_sets[] = Indent::_(3) . '<option value="a.'
								. $filter['code'] . ' ASC">'
								. $filter['lang_asc'] . '</option>';
							$list_sets[] = Indent::_(3) . '<option value="a.'
								. $filter['code'] . ' DESC">'
								. $filter['lang_desc'] . '</option>';
						}
						// do not add again
						$donelist[$filter['code']] = true;
					}
				}
			}

			$list_sets[] = Indent::_(3)
				. '<option value="a.id ASC">JGRID_HEADING_ID_ASC</option>';
			$list_sets[] = Indent::_(3)
				. '<option value="a.id DESC">JGRID_HEADING_ID_DESC</option>';
			$list_sets[] = Indent::_(2) . '</field>' . PHP_EOL;

			$list_sets = array_merge($list_sets, $this->limitField());
			$list_sets[] = Indent::_(1) . '</fields>';

			return implode(PHP_EOL, $list_sets);
		}

		return '';
	}

	/**
	 * How the ordering field is labelled and told to submit.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function orderingAttributes(): array
	{
		return [
			Indent::_(3) . 'label="JGLOBAL_SORT_BY"',
			Indent::_(3) . 'class="js-select-submit-on-change"'
		];
	}

	/**
	 * The field that says how many rows the list shows at a time.
	 *
	 * @return  array<string>  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function limitField(): array
	{
		$lines   = [];
		$lines[] = Indent::_(2) . '<field';
		$lines[] = Indent::_(3) . 'name="limit"';
		$lines[] = Indent::_(3) . 'type="limitbox"';
		$lines[] = Indent::_(3) . 'label="JGLOBAL_LIST_LIMIT"';
		$lines[] = Indent::_(3) . 'default="25"';
		$lines[] = Indent::_(3) . 'class="js-select-submit-on-change"';
		$lines[] = Indent::_(2) . '/>';

		return $lines;
	}
}

