<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Adminview\DefaultOrdering;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\DisplayMethodInterface;


/**
 * Admin List View Display Method Class.
 * 
 * Generates the body of an admin list view display method: the search-tool
 * filter form retrieval when the view uses the top-bar filter type, and the
 * list ordering clause built from the view's configured default ordering.
 * 
 * The shared implementation emits the search-tools model calls used from
 * Joomla 4 onwards; the Joomla 3 variant overrides the filter-form lines.
 * 
 * @since  6.1.7
 */
class DisplayMethod implements DisplayMethodInterface
{
	/**
	 * The AdminFilterType Class.
	 *
	 * @var   AdminFilterType
	 * @since 6.1.7
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The DefaultOrdering Class.
	 *
	 * @var   DefaultOrdering
	 * @since 6.1.7
	 */
	protected DefaultOrdering $defaultordering;

	/**
	 * Constructor.
	 *
	 * @param AdminFilterType   $adminfiltertype   The AdminFilterType Class.
	 * @param DefaultOrdering   $defaultordering   The DefaultOrdering Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(AdminFilterType $adminfiltertype,
		DefaultOrdering $defaultordering)
	{
		$this->adminfiltertype = $adminfiltertype;
		$this->defaultordering = $defaultordering;
	}

	/**
	 * Get the admin list view display method code.
	 *
	 * @param   string  $nameListCode  The list code name of the view.
	 *
	 * @return  string  The PHP to place in the list view display method.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameListCode): string
	{
		$script = '';
		// add the new filter methods for the search toolbar above the list view (2 = topbar)
		if ($this->adminfiltertype->get($nameListCode, 1) == 2)
		{
			$script .= $this->getFilterForm();
		}
		// get the default ordering values
		$default_ordering = $this->defaultordering->get($nameListCode);
		// now add the default ordering
		$script .= PHP_EOL . Indent::_(2) . "//"
			. Line::_(
				__LINE__,__CLASS__
			) . " Add the list ordering clause.";
		$script .= PHP_EOL . Indent::_(2)
			. "\$this->listOrder = \$this->sanitize(\$this->state->get('list.ordering', '"
			. $default_ordering['name'] . "'));";
		$script .= PHP_EOL . Indent::_(2)
			. "\$this->listDirn = \$this->sanitize(\$this->state->get('list.direction', '"
			. $default_ordering['direction'] . "'));";

		return $script;
	}

	/**
	 * Get the generated filter-form retrieval lines.
	 *
	 * From Joomla 4 the filter form and active filters are read from the
	 * model through its search-tools methods.
	 *
	 * @return  string  The generated filter-form lines.
	 *
	 * @since   6.1.7
	 */
	protected function getFilterForm(): string
	{
		$script = PHP_EOL . Indent::_(2) . "//"
			. Line::_(
				__LINE__,__CLASS__
			) . " Load the filter form from xml for searchtools.";
		$script .= PHP_EOL . Indent::_(2) . "\$this->filterForm "
			. "= \$model->getFilterForm();";
		$script .= PHP_EOL . Indent::_(2) . "//"
			. Line::_(
				__LINE__,__CLASS__
			) . " Load the active filters for searchtools.";
		$script .= PHP_EOL . Indent::_(2) . "\$this->activeFilters "
			. "= \$model->getActiveFilters();";

		return $script;
	}
}

