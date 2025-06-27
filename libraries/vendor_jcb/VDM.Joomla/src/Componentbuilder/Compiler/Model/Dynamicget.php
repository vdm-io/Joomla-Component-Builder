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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteDynamicGet;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteMainGet;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Selection;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Dynamic Get Class
 * 
 * @since 3.2.0
 */
class Dynamicget
{
	/**
	 * The joint types
	 *
	 * @var    array
	 * @since  3.2.0
	 */
	protected array $jointer = [
		1 => 'LEFT',
		2 => 'LEFT OUTER',
		3 => 'INNER',
		4 => 'RIGHT',
		5 => 'RIGHT OUTER'
	];

	/**
	 * The operator types
	 *
	 * @var    array
	 * @since  3.2.0
	 */
	protected array $operator = [
		1  => '=',
		2  => '!=',
		3  => '<>',
		4  => '>',
		5  => '<',
		6  => '>=',
		7  => '<=',
		8  => '!<',
		9  => '!>',
		10 => 'IN',
		11 => 'NOT IN',
		12 => 'LIKE',
		13 => 'NOT LIKE',
		14 => 'IS NULL',
		15 => 'IS NOT NULL',
		16 => 'BETWEEN',
		17 => 'NOT BETWEEN',
		18 => 'EXISTS',
		19 => 'NOT EXISTS',
		20 => 'REGEXP',
		21 => 'NOT REGEXP',
		22 => 'SOUNDS LIKE'
	];

	/**
	 * The gui mapper array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $guiMapper = [
		'table' => 'dynamic_get',
		'id' => null,
		'field' => null,
		'type'  => 'php'
	];

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The SiteDynamicGet Class.
	 *
	 * @var   SiteDynamicGet
	 * @since 3.2.0
	 */
	protected SiteDynamicGet $sitedynamicget;

	/**
	 * The SiteMainGet Class.
	 *
	 * @var   SiteMainGet
	 * @since 3.2.0
	 */
	protected SiteMainGet $sitemainget;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Gui Class.
	 *
	 * @var   Gui
	 * @since 3.2.0
	 */
	protected Gui $gui;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Selection Class.
	 *
	 * @var   Selection
	 * @since 3.2.0
	 */
	protected Selection $selection;

	/**
	 * Constructor.
	 *
	 * @param Config           $config           The Config Class.
	 * @param SiteDynamicGet   $sitedynamicget   The SiteDynamicGet Class.
	 * @param SiteMainGet      $sitemainget      The SiteMainGet Class.
	 * @param Customcode       $customcode       The Customcode Class.
	 * @param Gui              $gui              The Gui Class.
	 * @param Placeholder      $placeholder      The Placeholder Class.
	 * @param Selection        $selection        The Selection Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, SiteDynamicGet $sitedynamicget,
		SiteMainGet $sitemainget, Customcode $customcode, Gui $gui,
		Placeholder $placeholder, Selection $selection)
	{
		$this->config = $config;
		$this->sitedynamicget = $sitedynamicget;
		$this->sitemainget = $sitemainget;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->placeholder = $placeholder;
		$this->selection = $selection;
	}

	/**
	 * Set Dynamic Get
	 *
	 * @param   object    $item      The item data
	 * @param   string    $viewCode  The view code name
	 * @param   string    $context   The context for events
	 *
	 * @return  void
	 * @since   3.2.0
	 */
	public function set(object &$item, string $viewCode, string $context): void
	{
		$item->main_get = [];
		$item->custom_get = [];
		$addJoins = true;

		switch ($item->main_source)
		{
			case 1:
				$this->configureViewSource($item, $viewCode, $context);
				break;

			case 2:
				$this->configureDbSource($item, $viewCode, $context);
				break;

			case 3:
				$this->configureCustomSource($item, $viewCode, $context);
				$addJoins = false;
				break;
		}

		if ($addJoins)
		{
			$this->processJoins($item, $viewCode, $context);
			$this->processFilters($item);
			$this->processWhere($item);
			$this->processOrderGroupGlobal($item);
		}
		else
		{
			// when we have a custom query script we do not add the dynamic options
			unset(
				$item->join_view_table,
				$item->join_db_table,
				$item->filter,
				$item->where,
				$item->order,
				$item->group,
				$item->global
			);
		}
	}

	/**
	 * Configure the main_get using view-based data.
	 *
	 * @param   object   $item      The item data
	 * @param   string   $viewCode  The view code name
	 * @param   string   $context   The context for events
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function configureViewSource(object &$item, string $viewCode, string $context): void
	{
		if ($item->select_all == 1)
		{
			$item->view_selection = '*';
		}

		$item->main_get[] = [
			'selection' => $this->selection->get(
				$item->key,
				$viewCode,
				$item->view_selection,
				$item->view_table_main,
				'a',
				'view'
			),
			'as' => 'a',
			'key' => $item->key,
			'context' => $context
		];

		unset($item->view_selection);
	}

	/**
	 * Configure the main_get using database-table data.
	 *
	 * @param   object   $item       The item data
	 * @param   string   $viewCode   The view code name
	 * @param   string   $context    The context for events
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function configureDbSource(object &$item, string $viewCode, string $context): void
	{
		if ($item->select_all == 1)
		{
			$item->db_selection = '*';
		}

		$item->main_get[] = [
			'selection' => $this->selection->get(
				$item->key,
				$viewCode,
				$item->db_selection,
				$item->db_table_main,
				'a',
				'db'
			),
			'as' => 'a',
			'key' => $item->key,
			'context' => $context
		];

		unset($item->db_selection);
	}

	/**
	 * Configure the main_get using a custom PHP query.
	 *
	 * @param   object   $item      The item data
	 * @param   string   $viewCode  The view code name
	 * @param   string   $context   The context for events
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function configureCustomSource(object &$item, string $viewCode, string $context): void
	{
		$this->guiMapper['field'] = 'php_custom_get';

		$query = $this->gui->set(
			$this->customcode->update(
				base64_decode((string) $item->php_custom_get)
			),
			$this->guiMapper
		);

		$table = GetHelper::between($query, '$query->from(', ')');
		$tableName = '';

		if (StringHelper::check($table) && strpos($table, '#__') !== false)
		{
			$tableName = GetHelper::between($table, '#__', "'") ?: GetHelper::between($table, '#__', '"');
		}

		$item->main_get[] = [
			'selection' => [
				'select' => $query,
				'from' => '',
				'table' => '',
				'type' => '',
				'name' => $tableName
			],
			'as' => 'a',
			'key' => $item->key,
			'context' => $context
		];
	}

	/**
	 * Process filter statements on the item.
	 *
	 * @param   object   $item  The item data
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function processFilters(object &$item): void
	{
		$item->filter = json_decode((string) $item->filter, true);

		if (ArrayHelper::check($item->filter))
		{
			foreach ($item->filter as $nr => &$option)
			{
				if (isset($option['operator']) && isset($this->operator[$option['operator']]))
				{
					$option['operator'] = $this->operator[$option['operator']];
					$option['state_key'] = $this->placeholder->update_(
						$this->customcode->update($option['state_key'])
					);
					$option['key'] = $item->key;
				}
				else
				{
					unset($item->filter[$nr]);
				}
			}
		}
	}

	/**
	 * Process where clause on the item.
	 *
	 * @param  object  $item  The item data
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function processWhere(object &$item): void
	{
		$item->where = json_decode((string) $item->where, true);

		if (ArrayHelper::check($item->where))
		{
			foreach ($item->where as $nr => &$option)
			{
				if (isset($option['operator']) && isset($this->operator[$option['operator']]))
				{
					$option['operator'] = $this->operator[$option['operator']];
				}
				else
				{
					unset($item->where[$nr]);
				}
			}
		}
		else
		{
			unset($item->where);
		}
	}

	/**
	 * Process order, group, and global JSON attributes on the item.
	 *
	 * @param  object  $item  The item data
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function processOrderGroupGlobal(object &$item): void
	{
		$item->order = json_decode((string) $item->order, true);

		if (!ArrayHelper::check($item->order))
		{
			unset($item->order);
		}

		$item->group = json_decode((string) $item->group, true);

		if (!ArrayHelper::check($item->group))
		{
			unset($item->group);
		}

		$item->global = json_decode((string) $item->global, true);

		if (!ArrayHelper::check($item->global))
		{
			unset($item->global);
		}
	}

	/**
	 * Process join logic for both view and db tables.
	 *
	 * @param   object   $item       The item data
	 * @param   string   $viewCode  The view code name
	 * @param   string   $context    The context for events
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function processJoins(object &$item, string $viewCode, string $context): void
	{
		$this->processJoinGroup($item, $viewCode, $context, 'join_view_table', 'view');
		$this->processJoinGroup($item, $viewCode, $context, 'join_db_table', 'db');
	}

	/**
	 * Internal helper to process individual join groups.
	 *
	 * @param   object   $item        The item data
	 * @param   string   $viewCode   The view code name
	 * @param   string   $context     The context for events
	 * @param   string   $joinKey     The property name (join_view_table or join_db_table)
	 * @param   string   $sourceType  The source type (view or db)
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function processJoinGroup(object &$item, string $viewCode, string $context, string $joinKey, string $sourceType): void
	{
		$joins = json_decode((string) ($item->{$joinKey} ?? ''), true);
		if (!ArrayHelper::check($joins))
		{
			unset($item->$joinKey);
			return;
		}

		$_part_of_a = [];
		$_relationship = array_map(function ($op) use (&$_part_of_a) {
			$bucket = [];
			$bucket['on_field'] = array_map('trim', explode('.', (string) $op['on_field']));
			$bucket['join_field'] = array_map('trim', explode('.', (string) $op['join_field']));
			if ($op['row_type'] == 1
				&& ($bucket['on_field'][0] === 'a'
					|| isset($_part_of_a[$bucket['on_field'][0]])
					|| isset($_part_of_a[$bucket['join_field'][0]])))
			{
				$_part_of_a[$op['as']] = $op['as'];
			}
			return $bucket;
		}, $joins);

		foreach ($joins as $nr => &$option)
		{
			if (!StringHelper::check($option['selection'] ?? null))
			{
				continue;
			}

			$option['type'] = $this->jointer[$option['type']];
			$option['operator'] = $this->operator[$option['operator']] ?? null;
			$on_field = $_relationship[$nr]['on_field'];
			$join_field = $_relationship[$nr]['join_field'];

			$option['selection'] = $this->selection->get(
				$item->key,
				$viewCode,
				$option['selection'],
				$option[$sourceType === 'view' ? 'view_table' : 'db_table'],
				$option['as'],
				$sourceType,
				$option['row_type']
			);

			$option['key'] = $item->key;
			$option['context'] = $context;

			if ($option['row_type'] == 1)
			{
				$item->main_get[] = $option;
				if ($on_field[0] === 'a' || isset($_part_of_a[$join_field[0]]) || isset($_part_of_a[$on_field[0]]))
				{
					$this->sitemainget->set(
						"{$this->config->build_target}.{$viewCode}.{$option['as']}",
						$option['as']
					);
				}
				else
				{
					$this->sitedynamicget->set(
						"{$this->config->build_target}.{$viewCode}.{$option['as']}.{$join_field[1]}",
						$on_field[0]
					);
				}
			}
			elseif ($option['row_type'] == 2)
			{
				$item->custom_get[] = $option;
				if ($on_field[0] !== 'a')
				{
					$this->sitedynamicget->set(
						"{$this->config->build_target}.{$viewCode}.{$option['as']}.{$join_field[1]}",
						$on_field[0]
					);
				}
			}
		}

		unset($item->$joinKey);
	}
}

