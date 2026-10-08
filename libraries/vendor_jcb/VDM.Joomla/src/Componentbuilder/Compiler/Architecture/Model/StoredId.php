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
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Stored Id Class.
 * 
 * Builds the method a list model runs to work out whether the state it was
 * given differs from the state it last stored, so it knows when to throw its
 * cached list away.
 * 
 * @since 6.1.7
 */
final class StoredId
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
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

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
	 * @param AccessSwitch    $accessswitch    The Access Switch Builder Class.
	 * @param FieldNames      $fieldnames      The Field Names Builder Class.
	 * @param Config          $config          The Config Class.
	 * @param Sort            $sort            The Sort Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(AdminFilterType $adminfiltertype,
		Filter $filter,
		AccessSwitch $accessswitch,
		FieldNames $fieldnames,
		Config $config,
		Sort $sort)
	{
		$this->adminfiltertype = $adminfiltertype;
		$this->filter = $filter;
		$this->accessswitch = $accessswitch;
		$this->fieldnames = $fieldnames;
		$this->config = $config;
		$this->sort = $sort;
	}

	/**
	 * Build the stored id method of a list model.
	 *
	 * Every filter, sort and search the view offers is folded into the id, so
	 * a change to any of them is noticed.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The method.
	 *
	 * @since   6.1.7
	 */
	public function get(&$nameSingleCode, &$nameListCode): string
	{
		// set component name
		$Component = ucwords((string) $this->config->component_code_name);
		// keep track of all fields already added
		$donelist = array('id'         => true, 'search' => true,
			'published'  => true, 'access' => true,
			'created_by' => true, 'modified_by' => true);
		// set the defaults first
		$stored = "//" . Line::_(__Line__, __Class__) . " Compile the store id.";
		$stored .= PHP_EOL . Indent::_(2)
			. "\$id .= ':' . \$this->getState('filter.id');";
		$stored .= PHP_EOL . Indent::_(2)
			. "\$id .= ':' . \$this->getState('filter.search');";
		// add this if not already added
		if (!$this->fieldnames->isString($nameSingleCode . '.published'))
		{
			$stored .= PHP_EOL . Indent::_(2)
				. "\$id .= ':' . \$this->getState('filter.published');";
		}
		// add if view calls for it, and not already added
		if ($this->accessswitch->exists($nameSingleCode)
			&& !$this->fieldnames->isString($nameSingleCode . '.access'))
		{
			// the side bar option is single
			if ($this->adminfiltertype->get($nameListCode, 1) == 1)
			{
				$stored .= PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter.access');";
			}
			else
			{
				// top bar selection can result in
				// an array due to multi selection
				$stored .= $this->codeMulti('access', $Component);
			}
		}
		$stored .= PHP_EOL . Indent::_(2)
			. "\$id .= ':' . \$this->getState('filter.ordering');";
		// add this if not already added
		if (!$this->fieldnames->isString($nameSingleCode . '.created_by'))
		{
			$stored .= PHP_EOL . Indent::_(2)
				. "\$id .= ':' . \$this->getState('filter.created_by');";
		}
		// add this if not already added
		if (!$this->fieldnames->isString($nameSingleCode . '.modified_by'))
		{
			$stored .= PHP_EOL . Indent::_(2)
				. "\$id .= ':' . \$this->getState('filter.modified_by');";
		}
		// add the rest of the set filters
		if ($this->filter->exists($nameListCode))
		{
			foreach ($this->filter->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$stored .= $this->code(
						$filter, $nameListCode, $Component
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
					$stored .= $this->code(
						$filter, $nameListCode, $Component
					);
					$donelist[$filter['code']] = true;
				}
			}
		}

		return $stored;
	}
	/**
	 * Build the lines that fold one filter into the stored id.
	 *
	 * A value the view reads from the request is taken from the state it was
	 * put in, and appended to the id being built.
	 *
	 * @param   array   $filter        The field the id is folded from.
	 * @param   string  $nameListCode  The list view name.
	 * @param   string  $Component     The component name.
	 *
	 * @return  string  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function code(&$filter, &$nameListCode, &$Component): string
	{
		if ($filter['type'] === 'category')
		{
			// the side bar option is single (1 = sidebar)
			if ($this->adminfiltertype->get($nameListCode, 1) == 1)
			{
				$stored = PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter.category');";
				$stored .= PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter.category_id');";
				if ($filter['code'] != 'category')
				{
					$stored .= PHP_EOL . Indent::_(2)
						. "\$id .= ':' . \$this->getState('filter."
						. $filter['code'] . "');";
				}
			}
			else
			{
				$stored = $this->codeMulti('category', $Component);
				$stored .= $this->codeMulti(
					'category_id', $Component
				);
				if ($filter['code'] != 'category')
				{
					$stored .= $this->codeMulti(
						$filter['code'], $Component
					);
				}
			}
		}
		else
		{
			// check if this is the topbar filter, and multi option (2 = topbar)
			if (isset($filter['multi']) && $filter['multi'] == 2
				&& $this->adminfiltertype->get($nameListCode, 1) == 2)
			{
				// top bar selection can result in
				// an array due to multi selection
				$stored = $this->codeMulti(
					$filter['code'], $Component
				);
			}
			else
			{
				$stored = PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter."
					. $filter['code'] . "');";
			}
		}

		return $stored;
	}
	/**
	 * Build the lines that fold a value the view may hold many of into the id.
	 *
	 * A top bar selection can arrive as an array, so it is joined before it is
	 * appended and two lists with the same members read the same.
	 *
	 * @param   string  $key        The value name.
	 * @param   string  $Component  The component name.
	 *
	 * @return  string  The lines.
	 *
	 * @since   6.1.7
	 */
	protected function codeMulti($key, &$Component): string
	{
		// top bar selection can result in
		// an array due to multi selection
		$stored = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__Line__, __Class__)
			. " Check if the value is an array";
		$stored .= PHP_EOL . Indent::_(2)
			. "\$_" . $key . " = \$this->getState('filter."
			. $key . "');";
		$stored .= PHP_EOL . Indent::_(2)
			. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$_"
			. $key . "))";
		$stored .= PHP_EOL . Indent::_(2)
			. "{";
		$stored .= PHP_EOL . Indent::_(3)
			. "\$id .= ':' . implode(':', \$_" . $key . ");";
		$stored .= PHP_EOL . Indent::_(2)
			. "}";
		$stored .= PHP_EOL . Indent::_(2)
			. "//" . Line::_(__Line__, __Class__)
			. " Check if this is only an number or string";
		$stored .= PHP_EOL . Indent::_(2)
			. "elseif (is_numeric(\$_" . $key . ")";
		$stored .= PHP_EOL . Indent::_(2)
			. " || Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$_" . $key . "))";
		$stored .= PHP_EOL . Indent::_(2)
			. "{";
		$stored .= PHP_EOL . Indent::_(3)
			. "\$id .= ':' . \$_" . $key . ";";
		$stored .= PHP_EOL . Indent::_(2)
			. "}";

		return $stored;
	}
}

