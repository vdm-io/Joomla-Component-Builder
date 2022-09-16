<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Agent;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Agent\Update;
use VDM\Joomla\Componentbuilder\Search\Interfaces\ReplaceInterface;


/**
 * Search Agent Replace
 * 
 * @since 3.2.0
 */
class Replace implements ReplaceInterface
{
	/**
	 * Updated Values
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $updated = [];

	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Update
	 *
	 * @var   Update
	 * @since 3.2.0
	 */
	protected Update $update;

	/**
	 * Constructor
	 *
	 * @param Config|null     $config      The search config object.
	 * @param Update|null     $update      The update object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Update $update = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->update = $update ?: Factory::_('Agent.Update');
	}

	/**
	 * Get updated values
	 *
	 * @param string|null    $table   The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function get(?string $table = null): ?array
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		if (isset($this->updated[$table]))
		{
			return $this->updated[$table];
		}

		return null;
	}

	/**
	 * Search over an item fields
	 *
	 * @param object         $item    The item object of fields to search through
	 * @param int|null       $id      The item id
	 * @param string|null    $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function item(object $item, ?int $id =null, ?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// set the item id
		if (empty($id))
		{
			$id = $item->id;
		}

		if (ObjectHelper::check($item))
		{
			foreach ($item as $field => $value)
			{
				if ($field !== 'id' && ($_value = $this->update->value($value)) !== null)
				{
					if (empty($this->updated[$table][$id]))
					{
						$this->updated[$table][$id] = new \stdClass();
						$this->updated[$table][$id]->id = $id;
					}
					// add updated value
					$this->updated[$table][$id]->{$field} = $_value;
				}
			}
		}
	}

	/**
	 * Search over an array of items
	 *
	 * @param array|null     $items    The array of items to search through
	 * @param string|null    $table    The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function items(?array $items = null, ?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		if (ArrayHelper::check($items))
		{
			foreach ($items as $id => $item)
			{
				$this->item($item, $id, $table);
			}
		}
	}

	/**
	 * Reset all updated values of a table
	 *
	 * @param string|null    $table   The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function reset(?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		// empty or unset the table active values
		unset($this->updated[$table]);
	}

}

