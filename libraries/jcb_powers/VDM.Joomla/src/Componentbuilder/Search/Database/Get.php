<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Database;


use Joomla\CMS\Factory as JoomlaFactory;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Table;
use VDM\Joomla\Componentbuilder\Search\Model\Get as Model;
use VDM\Joomla\Componentbuilder\Search\Interfaces\GetInterface;


/**
 * Search Database Get
 * 
 * @since 3.2.0
 */
class Get implements GetInterface
{
	/**
	 * Bundle Size
	 *
	 * @var    int
	 * @since 3.2.0
	 */
	protected int $bundle = 300;

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
	 * @param Config|null               $config       The search config object.
	 * @param Table|null                $table        The search table object.
	 * @param Model|null                $model        The search get model object.
	 * @param \JDatabaseDriver|null     $db           The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Table $table = null,
		?Model $model = null, ?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->table = $table ?: Factory::_('Table');
		$this->model = $model ?: Factory::_('Get.Model');
		$this->db = $db ?: JoomlaFactory::getDbo();
	}

	/**
	 * Get a value from a given table
	 *          Example: $this->value(23, 'value_key', 'table_name');
	 *
	 * @param   int              $id        The item ID
	 * @param   string           $field     The field key
	 * @param   string|null      $table     The table
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function value(int $id, string $field, string $table = null)
	{
		// load the table
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// check if this is a valid field and table
		if ($id > 0 && ($name = $this->table->get($table, $field, 'name')) !== null)
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			// Order it by the ordering field.
			$query->select($this->db->quoteName($name));
			$query->from($this->db->quoteName('#__componentbuilder_' . $table));

			// get by id
			$query->where($this->db->quoteName('id') . " = " . (int) $id);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);
			$this->db->execute();

			// check if we have any values
			if ($this->db->getNumRows())
			{
				// return found values
				return $this->model->value($this->db->loadResult(), $name, $table);
			}
		}
		return null;
	}

	/**
	 * Get values from a given table
	 *          Example: $this->item(23, 'table_name');
	 *
	 * @param   int           $id        The item ID
	 * @param   string| null  $table     The table
	 *
	 * @return  object|null
	 * @since 3.2.0
	 */
	public function item(int $id, string $table = null): ?object
	{
		// load the table
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// check if this is a valid table
		if ($id > 0 && ($fields = $this->table->fields($table)) !== null)
		{
			// add the ID
			array_unshift($fields , 'id');

			// Create a new query object.
			$query = $this->db->getQuery(true);

			// Order it by the ordering field.
			$query->select($this->db->quoteName($fields));
			$query->from($this->db->quoteName('#__componentbuilder_' . $table));

			// get by id
			$query->where($this->db->quoteName('id') . " = " . $id);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);
			$this->db->execute();

			// check if we have any values
			if ($this->db->getNumRows())
			{
				// return found values
				return $this->model->item($this->db->loadObject(), $table);
			}
		}
		return null;
	}

	/**
	 * Get values from a given table
	 *          Example: $this->items('table_name');
	 *
	 * @param   string|null   $table   The table
	 * @param   int           $bundle  The bundle to return (0 = all)
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function items(string $table = null, int $bundle = 0): ?array
	{
		// load the table
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// check if this is a valid table
		if (($fields = $this->table->fields($table)) !== null)
		{
			// add the ID
			array_unshift($fields , 'id');

			// get the title value
			$title = $this->table->titleName($table);

			// Create a new query object.
			$query = $this->db->getQuery(true);

			// Order it by the ordering field.
			$query->select($this->db->quoteName($fields));
			$query->from($this->db->quoteName('#__componentbuilder_' . $table));
			$query->order($title .' ASC');

			// add limitation and pagination
			if ($bundle > 0)
			{
				// get the incremental number
				$query->where($this->db->quoteName('id') . " >= " . $this->next($table, $bundle));

				// only return a limited number
				$query->setLimit($this->bundle);
			}

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);
			$this->db->execute();

			// check if we have any values
			if ($this->db->getNumRows())
			{
				// return found values
				return $this->model->items($this->db->loadObjectList('id'), $table);
			}
		}
		return null;
	}

	/**
	 * Get next id to call
	 *
	 * @param   string    $table   The table
	 * @param   int       $bundle  The bundle to return
	 *
	 * @return  int
	 * @since 3.2.0
	 */
	protected function next(string $table, int $bundle): int
	{
		if ($bundle == 1 || $bundle == 0)
		{
			return 1;
		}

		if (($number = $this->model->last($table)) !== null)
		{
			return $number + 1;
		}

		return $this->incremental($bundle);
	}

	/**
	 * Get Incremental number where the set starts
	 *
	 * @param   int    $bundle  The bundle to return
	 *
	 * @return  int
	 * @since 3.2.0
	 */
	protected function incremental(int $bundle): int
	{
		// just in case
		if ($bundle == 1 || $bundle == 0)
		{
			return 1;
		}

		/** Number two set starts at 301
		 * 2 x 300 = 600
		 * 600 - 300 = 300
		 * 300 + 1 = 301 <--
		 *  Number five set starts at 1201
		 * 5 x 300 = 1500
		 * 1500 - 300 = 1200
		 * 1200 + 1 = 1201 <--
		 **/
		return (($bundle * $this->bundle) - $this->bundle) + 1;
	}

}

