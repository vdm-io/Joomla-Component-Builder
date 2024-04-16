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

namespace VDM\Joomla\Componentbuilder\Power\Database;


use VDM\Joomla\Interfaces\ModelInterface as Model;
use VDM\Joomla\Database\Load as Database;
use VDM\Joomla\Componentbuilder\Power\Database\LoadInterface;


/**
 * Power Database Load
 * 
 * @since 2.0.1
 */
class Load implements LoadInterface
{
	/**
	 * Model Load
	 *
	 * @var    Model
	 * @since 2.0.1
	 */
	protected Model $model;

	/**
	 * Database Load
	 *
	 * @var    Database
	 * @since 2.0.1
	 */
	protected Database $load;

	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 3.2.1
	 */
	protected string $table = 'power';

	/**
	 * Constructor
	 *
	 * @param Table       $table     The core table object.
	 * @param Model       $model     The model object.
	 * @param Database    $load      The database object.
	 *
	 * @since 2.0.1
	 */
	public function __construct(Model $model, Database $load)
	{
		$this->model = $model;
		$this->load = $load;
	}

	/**
	 * Get a value from a given table
	 *          Example: $this->value(
	 *                        [
	 *                           'guid' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'
	 *                        ], 'value_key'
	 *                    );
	 *
	 * @param   array      $keys      The item keys
	 * @param   string     $field     The field key
	 * @param   string     $table     The table
	 *
	 * @return  mixed
	 * @since 2.0.1
	 */
	public function value(array $keys, string $field)
	{
		return $this->model->value(
			$this->load->value(
				["a.{$field}" => $field],
				['a' => $this->table],
				$this->prefix($keys)
			),
			$field,
			$this->table
		);
	}

	/**
	 * Get values from a given table
	 *          Example: $this->item(
	 *                        [
	 *                           'guid' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'
	 *                        ]
	 *                    );
	 *
	 * @param   array    $keys      The item keys
	 * @param   string   $table     The table
	 *
	 * @return  object|null
	 * @since 2.0.1
	 */
	public function item(array $keys): ?object
	{
		return $this->model->item(
			$this->load->item(
				['all' => 'a.*'],
				['a' => $this->table],
				$this->prefix($keys)
			),
			$this->table
		);
	}
 
	/**
	 * Get values from a given table
	 *          Example: $this->items(
	 *                        [
	 *                           'guid' => [
	 *                              'operator' => 'IN',
	 *                              'value' => [''xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'', ''xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'']
	 *                           ]
	 *                        ]
	 *                    );
	 *          Example: $this->items($ids, 'table_name');
	 *
	 * @param   array    $keys    The item keys
	 * @param   string   $table   The table
	 *
	 * @return  array|null
	 * @since 2.0.1
	 */
	public function items(array $keys): ?array
	{
		return $this->model->items(
			$this->load->items(
				['all' => 'a.*'], ['a' => $this->table], $this->prefix($keys)
			),
			$this->table
		);
	}

	/**
	 * Add prefix to the keys
	 *
	 * @param   array    $keys The query keys
	 *
	 * @return  array
	 * @since 2.0.1
	 */
	private function prefix(array &$keys): array
	{
		// update the key values
		$bucket = [];
		foreach ($keys as $k => $v)
		{
			$bucket['a.' . $k] = $v;
		}
		return $bucket;
	}
}

