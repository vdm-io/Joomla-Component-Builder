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
namespace VDM\Joomla\Import;


use VDM\Joomla\Interfaces\Import\RowInterface as Row;
use VDM\Joomla\Interfaces\Import\RowItemInterface as ImportItem;
use VDM\Joomla\Interfaces\Import\MapperInterface as Mapper;
use VDM\Joomla\Interfaces\Registryinterface as Data;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Interfaces\Database\LoadInterface as Load;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Interfaces\Import\ParentTableInterface;


/**
 * Import Item Parent Table Class
 * 
 * @since  5.0.2
 */
final class ParentTable implements ParentTableInterface
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
	 * @param Data         $data         The Data Class.
	 * @param Item         $item         The Item Class.
	 * @param Load         $load         The Load Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Row $row, ImportItem $importitem, Mapper $mapper,
		Data $data, Item $item, Load $load)
	{
		$this->row = $row;
		$this->importitem = $importitem;
		$this->mapper = $mapper;
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
	 * @return  mixed  The parent value
	 * @since  5.0.2
	 *
	 * @throws  \UnexpectedValueException
	 * @throws  \DomainException
	 */
	public function set(string $linkKey, string $parentKey, string $parentTable)
	{
		$this->link = $linkKey;
		$this->key = $parentKey;
		$this->table = $parentTable;

		$parent = $this->getParent();

		$this->validateParent($parent);

		$parent_value = $this->processParent($parent);

		if (!$this->validateParentValue($parent_value))
		{
			return null;
		}

		return $parent_value;
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
	 * @return  void
	 * @since  5.0.2
	 *
	 * @throws  \UnexpectedValueException
	 */
	private function validateParent(?array $parent): void
	{
		if (empty($parent) || empty($parent[$this->link]))
		{
			throw new \UnexpectedValueException(
				sprintf(
					'Row %s is missing required parent key "%s".',
					$this->row->getIndex(),
					$this->table . ':' . $this->link
				)
			);
		}
	}

	/**
	 * Process parent data, performing insert or update as needed.
	 *
	 * @param   array  $parent  The parent item.
	 *
	 * @return  mixed
	 * @since  5.0.2
	 */
	private function processParent(array &$parent)
	{
		$key = $this->key;

		$parent_where = [
			'a.' . $this->link => $parent[$this->link]
		];
		$parent_tables = [
			'a' => $this->table
		];

		$parent_select = ['a.' . $key => $key];

		if (($parent_value = $this->load->value($parent_select, $parent_tables, $parent_where)) !== null)
		{
			// Update existing
			$parent[$key] = $parent_value;
			$parent['modified_by'] ??= $this->data->get('import.created_by', 0); // must be created by :)
			$this->item->table($this->table)->set((object) $parent, $key, 'update');
		}
		elseif ($key === 'guid')
		{
			// Insert new
			$parent[$key] ??= GuidHelper::get();
			$parent['access'] ??= 1;
			$parent['created_by'] ??= $this->data->get('import.created_by', 0);
			$this->item->table($this->table)->set((object) $parent, $key);

			$parent_value = $parent[$key];
		}
		elseif ($key === 'id')
		{
			// Insert new
			$parent[$key] ??= 0;
			$parent['access'] ??= 1;
			$parent['created_by'] ??= $this->data->get('import.created_by', 0);
			$this->item->table($this->table)->set((object) $parent, $key);

			$parent[$key] = $this->item->id();
			$parent_value = $parent[$key];
		}

		return $parent_value;
	}

	/**
	 * Validate the retrieved parent value.
	 *
	 * @param   mixed  $value  The parent key value.
	 *
	 * @return  bool
	 * @since   5.1.4
	 *
	 * @throws  \DomainException
	 */
	private function validateParentValue($value): bool
	{
		$key = $this->key;

		$isValid = match ($key)
		{
			'guid' => GuidHelper::valid($value),

			'id' => is_numeric($value) && (int) $value >= 1,

			default => (
				// numeric but not zero
				(is_numeric($value) && (float) $value != 0.0)
				||
				// non-empty string
				(is_string($value) && trim($value) !== '')
			),
		};

		if (!$isValid)
		{
			throw new \DomainException(
				sprintf(
					'Row %s resolved an invalid parent value for "%s".',
					$this->row->getIndex(),
					$this->table . ':' . $key
				)
			);
		}

		return true;
	}
}

