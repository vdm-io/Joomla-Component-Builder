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


use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Interfaces\ImportRowInterface as Row;
use VDM\Joomla\Componentbuilder\Interfaces\ImportItemInterface as ImportItem;
use VDM\Joomla\Componentbuilder\Interfaces\ImportMapperInterface as Mapper;
use VDM\Joomla\Componentbuilder\Interfaces\ImportMessageInterface as Message;
use VDM\Joomla\Componentbuilder\Import\Data;
use VDM\Joomla\Data\Item;
use VDM\Joomla\Database\Load;
use VDM\Joomla\Utilities\GuidHelper;


/**
 * Item Import Parent Table Class
 * 
 * @since  5.0.2
 */
final class ParentTable
{
	/**
	 * The Import Row Class.
	 *
	 * @var   Row
	 * @since 5.0.2
	 */
	protected Row $row;

	/**
	 * The Import Item Class.
	 *
	 * @var   ImportItem
	 * @since 5.0.2
	 */
	protected ImportItem $importitem;

	/**
	 * The Import Mapper Class.
	 *
	 * @var   Mapper
	 * @since 5.0.2
	 */
	protected Mapper $mapper;

	/**
	 * The Import Message Class.
	 *
	 * @var   Message
	 * @since 5.0.2
	 */
	protected Message $message;

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
	 * The the parent table of each row
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $table;

	/**
	 * The the parent table key field
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $key;

	/**
	 * The the parent table linker field
	 *
	 * @var   string
	 * @since 5.0.2
	 */
	protected string $link;

	/**
	 * Constructor.
	 *
	 * @param Row          $row          The Import Row Class.
	 * @param ImportItem   $importitem   The Import Item Class.
	 * @param Mapper       $mapper       The Import Mapper Class.
	 * @param Message      $message      The Import Message Class.
	 * @param Data         $data         The Data Class.
	 * @param Item         $item         The Item Class.
	 * @param Load         $load         The Load Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Row $row, ImportItem $importitem, Mapper $mapper,
		Message $message, Data $data, Item $item, Load $load)
	{
		$this->row = $row;
		$this->importitem = $importitem;
		$this->mapper = $mapper;
		$this->message = $message;
		$this->data = $data;
		$this->item = $item;
		$this->load = $load;
	}

	/**
	 * Set the parent data
	 *
	 * @param   string  $linkKey      The parent linker key field.
	 * @param   string  $parentKey    The parent key field.
	 * @param   string  $parentTable  The parent table.
	 *
	 * @return  string  The parent guid
	 * @since  5.0.2
	 */
	public function set(string $linkKey, string $parentKey, string $parentTable): ?string
	{
		$this->link = $linkKey;
		$this->key = $parentKey;
		$this->table = $parentTable;

		$parent = $this->getParent();

		if (!$this->validateParent($parent))
		{
			return null;
		}

		$parent_guid = $this->processParent($parent);

		if (!$this->validateParentGuid($parent_guid))
		{
			return null;
		}

		return $parent_guid;
	}

	/**
	 * Retrieve parent item.
	 *
	 * @return  array|null
	 * @since  5.0.2
	 */
	private function getParent(): ?array
	{
		return $this->importitem->get($this->table, $this->mapper->getParent());
	}

	/**
	 * Validate the parent item.
	 *
	 * @param   array|null  $parent  The parent item.
	 *
	 * @return  bool
	 * @since  5.0.2
	 */
	private function validateParent(?array $parent): bool
	{
		if (empty($parent) || empty($parent[$this->link]))
		{
			$this->message->addError(Text::sprintf('COM_COMPONENTBUILDER_ROW_S_MISSING_THE_KEY_FIELD_S', $this->row->getIndex(), $this->table . ':' . $this->link));
			return false;
		}
		return true;
	}

	/**
	 * Process parent data, performing insert or update as needed.
	 *
	 * @param   array  $parent  The parent item.
	 *
	 * @return  string|null
	 * @since  5.0.2
	 */
	private function processParent(array &$parent): ?string
	{
		$parent_where = [
			'a.' . $this->link => $parent[$this->link]
		];
		$parent_tables = [
			'a' => $this->table
		];
		$parent_select = ['a.guid' => 'guid'];

		if (($parent_guid = $this->load->value($parent_select, $parent_tables, $parent_where)) !== null)
		{
			// Update existing
			$parent['guid'] = $parent_guid;
			$parent['modified_by'] ??= $this->data->get('import.created_by', 0); // must be created by :)
			$this->item->table($this->table)->set((object) $parent, 'guid', 'update');
		}
		else
		{
			// Insert new
			$parent['guid'] ??= GuidHelper::get();
			$parent['access'] ??= 1;
			$parent['created_by'] ??= $this->data->get('import.created_by', 0);
			$this->item->table($this->table)->set((object)$parent, 'guid');

			$parent_guid = $parent['guid'];
		}

		return $parent_guid;
	}

	/**
	 * Validate the retrieved parent guid.
	 *
	 * @param   string|null  $guid  The parent guid.
	 *
	 * @return  bool
	 * @since  5.0.2
	 */
	private function validateParentGuid(?string $guid): bool
	{
		if (!GuidHelper::valid($guid))
		{
			$this->message->addError(
				Text::sprintf('COM_COMPONENTBUILDER_ROW_S_WAS_UNABLE_TO_RETRIEVE_A_VALID_PARENT_S_VALUE', $this->row->getIndex(), $this->table . ':' . $this->key)
			);
			return false;
		}
		return true;
	}
}

