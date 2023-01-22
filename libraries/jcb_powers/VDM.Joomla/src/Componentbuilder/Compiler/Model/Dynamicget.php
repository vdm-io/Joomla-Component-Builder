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


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
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
	 * @since 3.2.0
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
	 * @since 3.2.0
	 */
	protected array $operator = [
		1  => '=',
		2 => '!=',
		3 => '<>',
		4  => '>',
		5 => '<',
		6 => '>=',
		7  => '<=',
		8 => '!<',
		9 => '!>',
		10 => 'IN',
		11 => 'NOT IN'
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
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Compiler Dynamic Get Selection
	 *
	 * @var    Selection
	 * @since 3.2.0
	 **/
	protected Selection $selection;

	/**
	 * Constructor
	 *
	 * @param Config|null        $config       The compiler config.
	 * @param Registry|null      $registry     The compiler registry.
	 * @param Customcode|null    $customcode   The compiler customcode object.
	 * @param Gui|null           $gui          The compiler customcode gui.
	 * @param Placeholder|null   $placeholder  The compiler placeholder object.
	 * @param Selection|null     $selection    The compiler dynamic get selection object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null, ?Customcode $customcode = null,
		?Gui $gui = null, ?Placeholder $placeholder = null, ?Selection $selection = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->selection = $selection ?: Compiler::_('Dynamicget.Selection');
	}

	/**
	 * Set Dynamic Get
	 *
	 * @param   object    $item       The item data
	 * @param   string    $view_code  The view code name
	 * @param   string    $context    The context for events
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item, string $view_code, string $context)
	{
		// reset buckets
		$item->main_get   = [];
		$item->custom_get = [];

		// should joined and other tweaks be added
		$add_tweaks_joints = true;

		// set source data
		switch ($item->main_source)
		{
			case 1:
				// check if auto sync is set
				if ($item->select_all == 1)
				{
					$item->view_selection = '*';
				}
				// set the view data
				$item->main_get[0]['selection'] = $this->selection->get(
					$item->key, $view_code,
					$item->view_selection,
					$item->view_table_main, 'a', 'view'
				);
				$item->main_get[0]['as']      = 'a';
				$item->main_get[0]['key']     = $item->key;
				$item->main_get[0]['context'] = $context;
				unset($item->view_selection);
				break;
			case 2:
				// check if auto sync is set
				if ($item->select_all == 1)
				{
					$item->db_selection = '*';
				}
				// set the database data
				$item->main_get[0]['selection'] = $this->selection->get(
					$item->key, $view_code,
					$item->db_selection,
					$item->db_table_main, 'a', 'db'
				);
				$item->main_get[0]['as']      = 'a';
				$item->main_get[0]['key']     = $item->key;
				$item->main_get[0]['context'] = $context;
				unset($item->db_selection);
				break;
			case 3:
				// set GUI mapper field
				$this->guiMapper['field'] = 'php_custom_get';
				// get the custom query
				$customQueryString
					= $this->gui->set(
					$this->customcode->update(
						base64_decode((string) $item->php_custom_get)
					),
					$this->guiMapper
				);

				// get the table name
				$_searchQuery
					= GetHelper::between(
					$customQueryString, '$query->from(', ')'
				);

				if (StringHelper::check(
						$_searchQuery
					)
					&& strpos((string) $_searchQuery, '#__') !== false)
				{
					$_queryName = GetHelper::between(
						$_searchQuery, '#__', "'"
					);

					if (!StringHelper::check(
						$_queryName
					))
					{
						$_queryName = GetHelper::between(
							$_searchQuery, '#__', '"'
						);
					}
				}

				// set to blank if not found
				if (!isset($_queryName)
					|| !StringHelper::check(
						$_queryName
					))
				{
					$_queryName = '';
				}

				// set custom script
				$item->main_get[0]['selection'] = [
					'select' => $customQueryString,
					'from'   => '', 'table' => '', 'type' => '',
					'name'   => $_queryName];
				$item->main_get[0]['as']        = 'a';
				$item->main_get[0]['key']       = $item->key;
				$item->main_get[0]['context']   = $context;

				// do not add
				$add_tweaks_joints = false;

				break;
		}

		// only add if main source is not custom
		if ($add_tweaks_joints)
		{
			// set join_view_table details
			$item->join_view_table = json_decode(
				(string) $item->join_view_table, true
			);

			if (ArrayHelper::check(
				$item->join_view_table
			))
			{
				// start the part of a table bucket
				$_part_of_a = [];
				// build relationship
				$_relationship = array_map(
					function ($op) use (&$_part_of_a) {
						$bucket = array();
						// array(on_field_as, on_field)
						$bucket['on_field'] = array_map(
							'trim',
							explode('.', (string) $op['on_field'])
						);
						// array(join_field_as, join_field)
						$bucket['join_field'] = array_map(
							'trim',
							explode('.', (string) $op['join_field'])
						);
						// triget filed that has table a relationship
						if ($op['row_type'] == 1
							&& ($bucket['on_field'][0] === 'a'
								|| isset($_part_of_a[$bucket['on_field'][0]])
								|| isset($_part_of_a[$bucket['join_field'][0]])))
						{
							$_part_of_a[$op['as']] = $op['as'];
						}

						return $bucket;
					}, $item->join_view_table
				);

				// loop joints
				foreach (
					$item->join_view_table as $nr => &$option
				)
				{
					if (StringHelper::check(
						$option['selection']
					))
					{
						// convert the type
						$option['type']
							= $this->jointer[$option['type']];
						// convert the operator
						$option['operator']
							= $this->operator[$option['operator']];
						// get the on field values
						$on_field
							= $_relationship[$nr]['on_field'];
						// get the join field values
						$join_field
							= $_relationship[$nr]['join_field'];
						// set selection
						$option['selection']
							= $this->selection->get(
								$item->key,
								$view_code,
								$option['selection'],
								$option['view_table'],
								$option['as'],
								'view',
								$option['row_type']
							);
						$option['key']     = $item->key;
						$option['context'] = $context;
						// load to the getters
						if ($option['row_type'] == 1)
						{
							$item->main_get[] = $option;
							if ($on_field[0] === 'a'
								|| isset($_part_of_a[$join_field[0]])
								|| isset($_part_of_a[$on_field[0]]))
							{
								$this->registry->
									set('builder.site_main_get.' . $this->config->build_target .
										'.' . $view_code . '.' . $option['as'], $option['as']);
							}
							else
							{
								$this->registry->
									set('builder.site_dynamic_get.' . $this->config->build_target .
										'.' . $view_code . '.' . $option['as'] . '.' . $join_field[1], $on_field[0]);
							}
						}
						elseif ($option['row_type'] == 2)
						{
							$item->custom_get[] = $option;
							if ($on_field[0] != 'a')
							{
								$this->registry->
									set('builder.site_dynamic_get.' . $this->config->build_target .
										'.' . $view_code . '.' . $option['as'] . '.' . $join_field[1], $on_field[0]);
							}
						}
					}
					unset($item->join_view_table[$nr]);
				}
			}
			unset($item->join_view_table);

			// set join_db_table details
			$item->join_db_table = json_decode(
				(string) $item->join_db_table, true
			);

			if (ArrayHelper::check(
				$item->join_db_table
			))
			{
				// start the part of a table bucket
				$_part_of_a = array();
				// build relationship
				$_relationship = array_map(
					function ($op) use (&$_part_of_a) {
						$bucket = array();
						// array(on_field_as, on_field)
						$bucket['on_field'] = array_map(
							'trim',
							explode('.', (string) $op['on_field'])
						);
						// array(join_field_as, join_field)
						$bucket['join_field'] = array_map(
							'trim',
							explode('.', (string) $op['join_field'])
						);
						// triget filed that has table a relationship
						if ($op['row_type'] == 1
							&& ($bucket['on_field'][0] === 'a'
								|| isset($_part_of_a[$bucket['on_field'][0]])
								|| isset($_part_of_a[$bucket['join_field'][0]])))
						{
							$_part_of_a[$op['as']] = $op['as'];
						}

						return $bucket;
					}, $item->join_db_table
				);

				// loop joints
				foreach (
					$item->join_db_table as $nr => &$option1
				)
				{
					if (StringHelper::check(
						$option1['selection']
					))
					{
						// convert the type
						$option1['type']
							= $this->jointer[$option1['type']];
						// convert the operator
						$option1['operator']
							= $this->operator[$option1['operator']];
						// get the on field values
						$on_field
							= $_relationship[$nr]['on_field'];
						// get the join field values
						$join_field
							= $_relationship[$nr]['join_field'];
						// set selection
						$option1['selection']
							= $this->selection->get(
								$item->key,
								$view_code,
								$option1['selection'],
								$option1['db_table'],
								$option1['as'],
								'db',
								$option1['row_type']
							);
						$option1['key']     = $item->key;
						$option1['context'] = $context;
						// load to the getters
						if ($option1['row_type'] == 1)
						{
							$item->main_get[] = $option1;
							if ($on_field[0] === 'a'
								|| isset($_part_of_a[$join_field[0]])
								|| isset($_part_of_a[$on_field[0]]))
							{
								$this->registry->
									set('builder.site_main_get.' . $this->config->build_target .
										'.' . $view_code . '.' . $option1['as'], $option1['as']);
							}
							else
							{
								$this->registry->
									set('builder.site_dynamic_get.' . $this->config->build_target .
										'.' . $view_code . '.' . $option1['as'] . '.' . $join_field[1], $on_field[0]);
							}
						}
						elseif ($option1['row_type'] == 2)
						{
							$item->custom_get[] = $option1;
							if ($on_field[0] != 'a')
							{
								$this->registry->
									set('builder.site_dynamic_get.' . $this->config->build_target .
										'.' . $view_code . '.' . $option1['as'] . '.' . $join_field[1], $on_field[0]);
							}
						}
					}
					unset($item->join_db_table[$nr]);
				}
			}
			unset($item->join_db_table);

			// set filter details
			$item->filter = json_decode(
				(string) $item->filter, true
			);

			if (ArrayHelper::check(
				$item->filter
			))
			{
				foreach ($item->filter as $nr => &$option2)
				{
					if (isset($option2['operator']))
					{
						$option2['operator'] = $this->operator[$option2['operator']];
						$option2['state_key'] = $this->placeholder->update_(
							$this->customcode->update(
								$option2['state_key']
							)
						);
						$option2['key'] = $item->key;
					}
					else
					{
						unset($item->filter[$nr]);
					}
				}
			}

			// set where details
			$item->where = json_decode((string) $item->where, true);
			if (ArrayHelper::check(
				$item->where
			))
			{
				foreach ($item->where as $nr => &$option3)
				{
					if (isset($option3['operator']))
					{
						$option3['operator']
							= $this->operator[$option3['operator']];
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

			// set order details
			$item->order = json_decode((string) $item->order, true);
			if (!ArrayHelper::check(
				$item->order
			))
			{
				unset($item->order);
			}

			// set grouping
			$item->group = json_decode((string) $item->group, true);
			if (!ArrayHelper::check(
				$item->group
			))
			{
				unset($item->group);
			}

			// set global details
			$item->global = json_decode(
				(string) $item->global, true
			);

			if (!ArrayHelper::check(
				$item->global
			))
			{
				unset($item->global);
			}
		}
		else
		{
			// when we have a custom query script we do not add the dynamic options
			unset($item->join_view_table);
			unset($item->join_db_table);
			unset($item->filter);
			unset($item->where);
			unset($item->order);
			unset($item->group);
			unset($item->global);
		}
	}

}

