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

namespace VDM\Joomla\Componentbuilder\Server;


use VDM\Joomla\Componentbuilder\Compiler\Factory;
use VDM\Joomla\Database\Load as Database;
use VDM\Joomla\Componentbuilder\Server\Model\Load as Model;


/**
 * Server Load Class
 * 
 * @since 3.2.0
 */
class Load
{
	/**
	 * Database Load
	 *
	 * @var    Database
	 * @since 3.2.0
	 */
	protected Database $db;

	/**
	 * Model Class 
	 *
	 * @var    Model
	 * @since 3.2.0
	 */
	protected Model $model;

	/**
	 * Constructor
	 *
	 * @param Database|null     $db       The database object.
	 * @param Model|null        $model    The core crypt object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Database $db = null, ?Model $model = null)
	{
		$this->db = $db ?: Factory::_('Load');
		$this->model = $model ?: Factory::_('Model.Server.Load');
	}

	/**
	 * Get a value from a given server
	 *          Example: $this->value(23, 'protocol');
	 *
	 * @param   int        $id         The item ID
	 * @param   string   $field     The table field
	 *
	 * @return  mixed|null
	 * @since 3.2.0
	 */
	public function value(int $id, string $field)
	{
		if ($id > 0 && ($value = $this->db->value(
				$this->setDatabaseFields([$field]), ['a' => 'server'], ['a.id' => $id]
			)) !== null)
		{
			return $this->model->value($value, $field, 'server');
		}

		return null;
	}

	/**
	 * Get values from a given server
	 *          Example: $this->item(23, ['name', 'of', 'fields']);
	 *
	 * @param   int     $id         The item ID
	 * @param   array   $fields     The table fields
	 *
	 * @return  object|null
	 * @since 3.2.0
	 */
	public function item(int $id, array $fields): ?object
	{
		if ($id > 0 && ($item = $this->db->item(
				$this->setDatabaseFields($fields), ['a' => 'server'], ['a.id' => $id]
			)) !== null)
		{
			return $this->model->item($item, 'server');
		}

		return null;
	}

	/**
	 * Set Fields ready to use in database call
	 *
	 * @param   array   $fields     The table
	 * @param   string    $key  The table key to which the fields belong
	 *
	 * @return  array
	 * @since 3.2.0
	 */
	protected function setDatabaseFields(array $fields, string $key = 'a'): array
	{
		$bucket = [];
		foreach ($fields as $field)
		{
			$bucket[$key . '.' . $field] = $field;
		}

		return $bucket;
	}

}

