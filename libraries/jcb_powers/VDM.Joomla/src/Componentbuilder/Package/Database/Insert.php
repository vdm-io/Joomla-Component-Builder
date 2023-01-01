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

namespace VDM\Joomla\Componentbuilder\Package\Database;


use Joomla\CMS\Factory as JoomlaFactory;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Table;
use VDM\Joomla\Componentbuilder\Search\Model\Insert as Model;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Package Database Insert
 * 
 * @since 3.2.0
 */
class Insert
{
	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Search Table
	 *
	 * @var    Table
	 * @since 3.2.0
	 */
	protected Table $table;

	/**
	 * Search Model
	 *
	 * @var    Model
	 * @since 3.2.0
	 */
	protected Model $model;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * Constructor
	 *
	 * @param Config|null              $config      The search config object.
	 * @param Table|null               $table       The search table object.
	 * @param Model|null               $model       The search get model object.
	 * @param \JDatabaseDriver|null    $db          The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Table $table = null,
		?Model $model = null, ?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->table = $table ?: Factory::_('Table');
		$this->model = $model ?: Factory::_('Set.Model');
		$this->db = $db ?: JoomlaFactory::getDbo();
	}

	/**
	 * Set values to a given table
	 *          Example: $this->value(Value, 23, 'value_key', 'table_name');
	 *
	 * @param   mixed          $value     The field value
	 * @param   int            $id        The item ID
	 * @param   string         $field     The field key
	 * @param   string|null    $table     The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function value($value, int $id, string $field, ?string $table = null): bool
	{
		// load the table
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// check if this is a valid field and table
		if ($id > 0 && ($name = $this->table->get($table, $field, 'name')) !== null)
		{
			// build the object
			$item = new \stdClass();
			$item->id = $id;
			$item->{$name} = $this->model->value($value, $name, $table);

			// Update the column of this table using id as the primary key.
			return $this->db->updateObject('#__componentbuilder_' . $table,  $item, 'id');
		}
		return false;
	}

	/**
	 * Set values to a given table
	 *          Example: $this->item(Object, 23, 'table_name');
	 *
	 * @param   object        $item    The item to save
	 * @param   string|null   $table   The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function item(object $item, ?string $table = null): bool
	{
		// load the table
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// check if this is a valid table
		if (($fields = $this->table->fields($table)) !== null)
		{
			// model the item values
			foreach ($fields as $field)
			{
				if (isset($item->{$field}))
				{
					$item->{$field} = $this->model->value($item->{$field}, $field, $table);
				}
			}

			// Update the column of this table using id as the primary key.
			return $this->db->updateObject('#__componentbuilder_' . $table,  $item, 'id');
		}
		return false;
	}

	/**
	 * Set values to a given table
	 *          Example: $this->items(Array, 'table_name');
	 *
	 * @param   array|null     $items    The items being saved
	 * @param   string|null    $table    The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function items(?array $items, string $table = null): bool
	{
		// load the table
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// check if this is a valid table
		if (ArrayHelper::check($items))
		{
			$success = true;
			foreach ($items as $item)
			{
				if (!$this->item($item, $table))
				{
					$success = false;
					break;
				}
			}
			return $success;
		}
		return false;
	}

}

