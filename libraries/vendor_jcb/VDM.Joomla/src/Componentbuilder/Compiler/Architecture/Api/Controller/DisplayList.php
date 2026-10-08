<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller;


use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Api Controller Display List Class.
 * 
 * Builds the displayList method of the list API controller: the request
 * filters, search and ordering are copied onto the model state under the
 * names the generated list model reads, and only the columns the admin list
 * can sort by are accepted as ordering.
 * 
 * @since 6.1.7
 */
final class DisplayList
{
	/**
	 * The Filter Builder Class.
	 *
	 * @var   Filter
	 * @since 6.1.7
	 */
	protected Filter $filter;

	/**
	 * The Sort Builder Class.
	 *
	 * @var   Sort
	 * @since 6.1.7
	 */
	protected Sort $sort;

	/**
	 * The Category Builder Class.
	 *
	 * @var   Category
	 * @since 6.1.7
	 */
	protected Category $category;

	/**
	 * The Access Switch Builder Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The Field Names Builder Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * Constructor.
	 *
	 * @param Filter         $filter         The Filter Builder Class.
	 * @param Sort           $sort           The Sort Builder Class.
	 * @param Category       $category       The Category Builder Class.
	 * @param AccessSwitch   $accessswitch   The Access Switch Builder Class.
	 * @param FieldNames     $fieldnames     The Field Names Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Filter $filter, Sort $sort, Category $category,
		AccessSwitch $accessswitch, FieldNames $fieldnames)
	{
		$this->filter = $filter;
		$this->sort = $sort;
		$this->category = $category;
		$this->accessswitch = $accessswitch;
		$this->fieldnames = $fieldnames;
	}

	/**
	 * Get the display list code of the list API controller.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  string  The display list method body.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode): string
	{
		$code = [];

		$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " Map the request filters onto the list model state.";
		$code[] = Indent::_(2) . "\$filters = \$this->input->get('filter', [], 'array');";
		$code[] = Indent::_(2)
			. "\$this->modelState->set('filter.search', \$this->cleanFilter(\$filters['search'] ?? ''));";
		$code[] = Indent::_(2)
			. "\$this->modelState->set('filter.published', \$this->cleanFilter(\$filters['published'] ?? ''));";

		foreach ($this->filters($nameSingleCode, $nameListCode) as $filter)
		{
			$code[] = PHP_EOL . Indent::_(2) . "if (isset(\$filters['" . $filter . "']))";
			$code[] = Indent::_(2) . "{";
			$code[] = Indent::_(3) . "\$this->modelState->set('filter." . $filter
				. "', \$this->cleanFilter(\$filters['" . $filter . "']));";
			$code[] = Indent::_(2) . "}";
		}

		$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " Map the requested ordering onto the list model state.";
		$code[] = Indent::_(2) . "\$list = \$this->input->get('list', [], 'array');";
		$code[] = Indent::_(2) . "\$ordering = [";

		foreach ($this->ordering($nameSingleCode, $nameListCode) as $key => $column)
		{
			$code[] = Indent::_(3) . "'" . $key . "' => '" . $column . "',";
		}

		$code[] = Indent::_(2) . "];";
		$code[] = PHP_EOL . Indent::_(2)
			. "if (isset(\$list['ordering'], \$ordering[\$list['ordering']]))";
		$code[] = Indent::_(2) . "{";
		$code[] = Indent::_(3)
			. "\$this->modelState->set('list.ordering', \$ordering[\$list['ordering']]);";
		$code[] = Indent::_(2) . "}";
		$code[] = PHP_EOL . Indent::_(2)
			. "if (isset(\$list['direction']) && in_array(strtolower((string) \$list['direction']), ['asc', 'desc'], true))";
		$code[] = Indent::_(2) . "{";
		$code[] = Indent::_(3)
			. "\$this->modelState->set('list.direction', strtolower((string) \$list['direction']));";
		$code[] = Indent::_(2) . "}";
		$code[] = PHP_EOL . Indent::_(2) . "return parent::displayList();";

		return implode(PHP_EOL, $code);
	}

	/**
	 * The filter names the generated list query reads, beyond search and published.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  array  The filter names.
	 * @since   6.1.7
	 */
	private function filters(string $nameSingleCode, string $nameListCode): array
	{
		$filters = [];

		// the access level filter is read when the view has an access field of its own
		if ($this->accessswitch->exists($nameSingleCode)
			&& !$this->fieldnames->isString($nameSingleCode . '.access'))
		{
			$filters[] = 'access';
		}

		// the category filter is read by its id
		if ($this->category->exists($nameListCode))
		{
			$filters[] = 'category_id';
		}

		if ($this->filter->exists($nameListCode))
		{
			foreach ($this->filter->get($nameListCode) as $filter)
			{
				// category filters are read through the category id
				if (isset($filter['type']) && $filter['type'] === 'category')
				{
					continue;
				}

				if (!isset($filter['code']) || !StringHelper::check($filter['code']))
				{
					continue;
				}

				$code = (string) $filter['code'];

				if ($code === 'search' || $code === 'published'
					|| in_array($code, $filters, true))
				{
					continue;
				}

				$filters[] = $code;
			}
		}

		return $filters;
	}

	/**
	 * The ordering the list accepts: the request name to the column expression
	 * the generated list model orders by, the way the admin sort field offers them.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  array  The ordering map.
	 * @since   6.1.7
	 */
	private function ordering(string $nameSingleCode, string $nameListCode): array
	{
		$ordering = [
			'id' => 'a.id',
			'published' => 'a.published',
			'ordering' => 'a.ordering',
			'created_by' => 'a.created_by',
			'modified_by' => 'a.modified_by',
		];

		if ($this->accessswitch->exists($nameSingleCode))
		{
			$ordering['access'] = 'a.access';
		}

		if ($this->sort->exists($nameListCode))
		{
			foreach ($this->sort->get($nameListCode) as $sort)
			{
				if (!isset($sort['code']) || !StringHelper::check($sort['code']))
				{
					continue;
				}

				$code = (string) $sort['code'];

				if (isset($sort['type']) && $sort['type'] === 'category')
				{
					$ordering[$code] = 'category_title';
				}
				elseif (isset($sort['custom']) && ArrayHelper::check($sort['custom'])
					&& isset($sort['custom']['db'], $sort['custom']['text'])
					&& StringHelper::check($sort['custom']['db'])
					&& StringHelper::check($sort['custom']['text']))
				{
					$ordering[$code] = $sort['custom']['db'] . '.' . $sort['custom']['text'];
				}
				else
				{
					$ordering[$code] = 'a.' . $code;
				}
			}
		}

		return $ordering;
	}
}

