<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Joomla\Componentbuilder\Item\Import;


use VDM\Joomla\Componentbuilder\Interfaces\ImportMapperInterface as Mapper;
use VDM\Joomla\Componentbuilder\Interfaces\ImportItemInterface as ImportItem;
use VDM\Joomla\Componentbuilder\Import\Data;
use VDM\Joomla\Data\Item;
use VDM\Joomla\Database\Load;
use VDM\Joomla\Utilities\GuidHelper;


/**
 * Item Import Join Tables Class
 * 
 * @since  5.0.2
 */
final class JoinTables
{
	/**************************************************************************
	 * THESE VALUES BELOW SHOULD BE UPDATE FOR YOUR USE-CASE
	 */

	/**
	 * The current join tables key fields map.
	 *
	 * @var   array
	 * @since 5.0.2
	 */
	protected array $keyFields = [
		'detail' => ['link_fields' => ['entity']]
	];

	/**
	 * THESE VALUES ABOVE SHOULD BE UPDATE FOR YOUR USE-CASE
	 **************************************************************************/

	/**
	 * The Import Mapper Class.
	 *
	 * @var   Mapper
	 * @since 5.0.2
	 */
	protected Mapper $mapper;

	/**
	 * The Import Item Class.
	 *
	 * @var   ImportItem
	 * @since 5.0.2
	 */
	protected ImportItem $importitem;

	/**
	 * The Data Class.
	 *
	 * @var   Data
	 * @since 5.0.2
	 */
	protected Data $data;

	/**
	 * The Item Class.
	 *
	 * @var   Item
	 * @since 5.0.2
	 */
	protected Item $item;

	/**
	 * The Load Class.
	 *
	 * @var   Load
	 * @since 5.0.2
	 */
	protected Load $load;

	/**
	 * Constructor.
	 *
	 * @param Mapper       $mapper       The Import Mapper Class.
	 * @param ImportItem   $importitem   The Import Item Class.
	 * @param Data         $data         The Data Class.
	 * @param Item         $item         The Item Class.
	 * @param Load         $load         The Load Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Mapper $mapper, ImportItem $importitem, Data $data,
		Item $item, Load $load)
	{
		$this->mapper = $mapper;
		$this->importitem = $importitem;
		$this->data = $data;
		$this->item = $item;
		$this->load = $load;
	}

	/**
	 * Process the join tables and save the corresponding data.
	 *
	 * @param   string  $parentKeyValue  The parent key.
	 *
	 * @return  void
	 * @since  5.0.2
	 */
	public function set(string $parentJoinKey, string $parentGuid): void
	{
		foreach ($this->mapper->getJoin() as $table => $columns)
		{
			$key_fields = $this->keyFields[$table]['link_fields'] ?? null;

			if ($key_fields === null)
			{
				continue;
			}

			while ($item = $this->importitem->get($table, $columns))
			{
				if (empty($item))
				{
					break;
				}

				$item[$parentJoinKey] = $parentGuid;

				if ($this->isJoinedItemReady($item, $key_fields, $table))
				{
					$this->saveJoinedItem($item, $key_fields, $table);
				}
			}
		}
	}

	/**
	 * Check if the item is ready to be processed.
	 *
	 * @param   array   $item         The item to check.
	 * @param   array   $keyFields    Key fields for the table.
	 * @param   string  $table        Table name.
	 *
	 * @return  bool
	 * @since  5.0.2
	 */
	private function isJoinedItemReady(array $item, array $keyFields, string $table): bool
	{
		$ready = true;

		foreach ($keyFields as $key_field)
		{
			if (empty($item[$key_field]))
			{
				$ready = false;
			}
		}

		return $ready;
	}

	/**
	 * Save the item (either insert or update).
	 *
	 * @param   array   $item         The item to save.
	 * @param   array   $keyFields    Key fields for the table.
	 * @param   string  $table        The table name.
	 *
	 * @return  void
	 * @since  5.0.2
	 */
	private function saveJoinedItem(array $item, array $keyFields, string $table): void
	{
		$where = [];
		foreach ($keyFields as $key_field)
	 	{
			$where['a.' . $key_field] = $item[$key_field];
		}

		$guid = $this->load->value(['a.guid' => 'guid'], ['a' => $table], $where);

		if ($guid === null)
		{
			$guid = GuidHelper::get();

			$action = 'insert';
			$item['created_by'] ??= $this->data->get('import.created_by', 0);
		}
		else
		{
			$action = 'update';
			$item['modified_by'] ??= $this->data->get('import.created_by', 0); // must be created by :)
		}

		$item['guid'] = $guid;
		$this->item->table($table)->set((object)$item, 'guid', $action);
	}
}

