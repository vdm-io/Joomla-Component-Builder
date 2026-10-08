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


use VDM\Joomla\Componentbuilder\Compiler\Builder\Search;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomField;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Search Query Class.
 * 
 * Builds the search clause a list model applies when the user types into the
 * search box: one LIKE test per searchable field, plus the text column of any
 * custom field that is joined into the list.
 * 
 * The clause reads the same on every Joomla target, so this is one class.
 * 
 * @since  6.1.7
 */
final class SearchQuery
{
	/**
	 * The Search Class.
	 *
	 * @var   Search
	 * @since 6.1.7
	 */
	protected Search $search;

	/**
	 * Custom-field definitions used by the list query join renderer.
	 *
	 * @var    CustomField
	 * @since  6.2.0
	 */
	protected CustomField $customfield;

	/**
	 * Constructor.
	 *
	 * @param   Search       $search       The Search Class.
	 * @param   CustomField  $customfield  The custom-field definitions.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Search $search, CustomField $customfield)
	{
		$this->search = $search;
		$this->customfield = $customfield;
	}

	/**
	 * Build the search clause of a list model.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get($nameListCode)
	{
		if ($this->search->exists($nameListCode))
		{
			// setup the searh options
			$search = "'(";
			foreach ($this->search->get($nameListCode) as $nr => $array)
			{
				$search .= ($nr == 0 ? '' : ' OR ') . "a." . $array['code'] . " LIKE '.\$search.'";
				$column = $this->joinedColumn($nameListCode, $array);

				if ($column !== null)
				{
					$search .= " OR " . $column . " LIKE '.\$search.'";
				}
			}
			$search .= ")'";
			// now setup query
			$query = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Filter by search.";
			$query .= PHP_EOL . Indent::_(2)
				. "\$search = \$this->getState('filter.search');";
			$query .= PHP_EOL . Indent::_(2) . "if (!empty(\$search))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3)
				. "if (stripos(\$search, 'id:') === 0)";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "\$query->where('a.id = ' . (int) substr(\$search, 3));";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(3) . "else";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "\$search = \$db->quote('%' . \$db->escape(\$search) . '%');";
			$query .= PHP_EOL . Indent::_(4) . "\$query->where(" . $search
				. ");";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(2) . "}";
			$query .= PHP_EOL;

			return $query;
		}

		return '';
	}

	/**
	 * Resolve a display column only when its custom field is joined into the list.
	 *
	 * Creator\Builders registers every list=1 field in CustomList. Its storage
	 * method and table metadata must also satisfy CustomQuery's join conditions.
	 * Local a.field searches do not depend on this optional display-column lookup.
	 *
	 * @param   string  $nameListCode  The list view code name.
	 * @param   array   $field         The searchable field definition.
	 *
	 * @return  string|null
	 * @since   6.2.0
	 */
	private function joinedColumn(string $nameListCode, array $field): ?string
	{
		if (1 != $field['list'])
		{
			return null;
		}

		foreach ($this->customfield->get($nameListCode, []) as $definition)
		{
			if ($definition['code'] !== $field['code'] || !isset($definition['method'])
				|| $definition['method'] != 0)
			{
				continue;
			}

			$custom = $definition['custom'] ?? [];

			foreach (['table', 'db', 'text', 'id'] as $key)
			{
				if (!StringHelper::check($custom[$key] ?? null))
				{
					return null;
				}
			}

			return $custom['db'] . '.' . $custom['text'];
		}

		return null;
	}
}

