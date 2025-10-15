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

namespace VDM\Joomla\Componentbuilder\Package\Dependency;


use VDM\Joomla\Interfaces\Remote\ConfigInterface as Config;
use VDM\Joomla\Componentbuilder\Utilities\Normalize;
use VDM\Joomla\Interfaces\Registryinterface as Tracker;
use VDM\Joomla\Componentbuilder\Power\Interfaces\TableInterface as Table;
use VDM\Joomla\Interfaces\Database\LoadInterface as Load;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Data\Guid;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Interfaces\Remote\Dependency\ResolverInterface;


/**
 * Package Dependency Resolver
 * 
 * @since 5.1.1
 */
final class Resolver implements ResolverInterface
{
	/**
	 * The Globally Unique Identifier.
	 *
	 * @since 5.1.2
	 */
	use Guid;

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.1
	 */
	protected Config $config;

	/**
	 * The Normalize Class.
	 *
	 * @var   Normalize
	 * @since 5.1.1
	 */
	protected Normalize $normalize;

	/**
	 * The Tracker Class.
	 *
	 * @var   Tracker
	 * @since 5.1.1
	 */
	protected Tracker $tracker;

	/**
	 * The Table Class.
	 *
	 * @var   Table
	 * @since 5.1.1
	 */
	protected Table $table;

	/**
	 * The Load Class.
	 *
	 * @var   Load
	 * @since 5.1.1
	 */
	protected Load $load;

	/**
	 * The Items Class.
	 *
	 * @var   Items
	 * @since 5.1.2
	 */
	protected Items $items;

	/**
	 * The parents fields.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $parents;

	/**
	 * The children dependencies.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $children;

	/**
	 * The code search.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $code;

	/**
	 * The file field names of this entity.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $files;

	/**
	 * The switch to see if this entity has files
	 *
	 * @var   bool
	 * @since 5.1.1
	 */
	protected bool $hasFiles;

	/**
	 * The folder field names of this entity.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $folders;

	/**
	 * The switch to see if this entity has folders
	 *
	 * @var   bool
	 * @since 5.1.1
	 */
	protected bool $hasFolders;

	/**
	 * The placeholders search.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $placeholders;

	/**
	 * The template and layout alias map.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $alias_map = [];

	/**
	 * The Target Table name.
	 *
	 * @var   string
	 * @since 5.1.2
	 */
	protected string $table_name;

	/**
	 * The current item dependencies map.
	 *
	 * @var   array
	 * @since 5.1.1
	 */
	protected array $dependencies;

	/**
	 * Constructor.
	 *
	 * @param Config    $config    The Config Class.
	 * @param Normalize $normalize The Normalize Class.
	 * @param Tracker   $tracker   The Tracker Class.
	 * @param Table     $table     The Table Class.
	 * @param Load      $load      The Load Class.
	 * @param Items     $items     The Items Class.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Config $config, Normalize $normalize,
		Tracker $tracker, Table $table, Load $load, Items $items)
	{
		$this->config = $config;
		$this->normalize = $normalize;
		$this->tracker = $tracker;
		$this->table = $table;
		$this->load = $load;
		$this->items = $items;

		$this->init();
	}

	/**
	 * Set the current active table
	 *
	 * @param string $table The table that should be active
	 *
	 * @return self
	 * @since  5.1.2
	 */
	public function table(string $table): self
	{
		$this->table_name = $table;

		return $this;
	}

	/**
	 * Inspect an item and extract all the dependencies
	 *
	 * This method inspects the item and loads all dependencies
	 *
	 * @param   object  $item  The data item to inspect.
	 *
	 * @return  array|null  The extracted dependencies.
	 * @since   5.1.1
	 */
	public function extract(object $item): ?array
	{
		$this->dependencies = [];

		// Collect dependencies data
		$this->extractParents($item);
		$this->extractChildren($item);
		$this->extractDynamicContent($item);
		$this->extractSubformFields($item);
		$this->extractFiles($item);
		$this->extractFolders($item);

		// return the dependencies
		return $this->getDependencies();
	}

	/**
	 * Return the relationships/dependencies of this given item object
	 *
	 * These relationships are used internally and are not part of the database schema.
	 * They are returned under the special '@dependencies' key to avoid accidental persistence.
	 *
	 * @return  array|null   The relationships attached to this item or null.
	 * @since   5.1.1
	 */
	protected function getDependencies(): ?array
	{
		if (empty($this->dependencies))
		{
			return null;
		}

		return ['@dependencies' => array_values($this->dependencies)];
	}

	/**
	 * Inspects all fields with outgoing links (type 1) and records their dependencies.
	 *
	 * Handles both plain fields and sub-form paths (denoted by “|”).  Any value
	 * encountered is normalised to one-dimensional strings before recording.
	 *
	 * @param   object  $item  The data item containing potential parent field values.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractParents(object $item): void
	{
		foreach ($this->parents as $fieldName => $link)
		{
			// Decide which normaliser to employ
			$values = (strpos($fieldName, '|') === false)
				? $this->normalizeToStringArray($item->{$fieldName} ?? null)
				: $this->normalizeToSubformArray($fieldName, $item);

			// Persist every resolved value
			foreach ($values as $value)
			{
				$this->record('parent', $link['entity'], $value, $link['table'], $link['key']);
			}
		}
	}

	/**
	 * Extracts entities that depend on this item (incoming links)
	 *
	 * @param   object  $item  The data item containing potential child field values.
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function extractChildren(object $item): void
	{
		foreach ($this->children as $fieldName => $tables)
		{
			$values = $this->normalizeToStringArray($item->{$fieldName} ?? null);

			foreach ($values as $value)
			{
				foreach ($tables as $link)
				{
					$this->record('child', $link['entity'], $value, $link['table'], $link['key']);
				}
			}
		}
	}

	/**
	 * Inspects all fields for dynamic linking content.
	 *
	 * @param   object  $item  The data item containing potential dynamic field values.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractDynamicContent(object $item): void
	{
		foreach ($this->code as $field)
		{
			$value = $item->{$field} ?? '';

			if (!empty($value))
			{
				$this->extractCustomCode($value);
				$this->extractTemplates($value);
				$this->extractLayouts($value);
			}
		}

		foreach ($this->placeholders as $field)
		{
			$value = $item->{$field} ?? '';

			if (!empty($value))
			{
				$this->extractPlaceholders($value);
			}
		}
	}

	/**
	 * Extract subform field dependencies from an item.
	 *
	 * This method checks if the item is a subform field and, if so,
	 * extracts the referenced field GUIDs from its XML definition.
	 * Each valid field reference is recorded as a parent dependency.
	 *
	 * @param  object  $item  The field item to inspect.
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function extractSubformFields(object $item): void
	{
		// Only continue if we are on the field table and this is a subform field
		if (
			$this->config->getTable() !== 'field' ||
			$item->fieldtype !== '7139f2c8-a70a-46a6-bbe3-4eefe54ca515'
		) {
			return;
		}

		// Attempt to extract the `fields` attribute value from XML
		$rawFields = GetHelper::between($item->xml, 'fields="', '"');

		if (empty($rawFields))
		{
			return;
		}

		// Split the list and trim all values
		$fieldList = array_map('trim', explode(',', $rawFields));

		foreach ($fieldList as $field)
		{
			// If numeric, convert ID to GUID
			if (is_numeric($field))
			{
				$field = $this->load->value(['guid'], ['field'], ['id' => $field]);
			}

			$this->record(
				'parent',
				'field',
				$field,
				'#__componentbuilder_field',
				'guid'
			);
		}
	}

	/**
	 * Extract files from entity
	 *
	 * This method checks if the item has files, if so,
	 * extracts the files from the entity based on the config details.
	 *
	 * @param  object  $item  The field item to inspect.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractFiles(object $item): void
	{
		// Only continue if we have
		// files in these kind of entities
		if (!$this->hasFiles)
		{
			return;
		}

		foreach ($this->files as $fieldName => $target)
		{
			// Decide which normaliser to employ
			$values = (strpos($fieldName, '|') === false)
				? $this->normalizeToStringArray($item->{$fieldName} ?? null)
				: $this->normalizeToSubformArray($fieldName, $item);

			// Persist every resolved value
			foreach ($values as $value)
			{
				$this->recordFile($value, $target);
			}
		}
	}

	/**
	 * Extract folders from entity
	 *
	 * This method checks if the item has folders, if so,
	 * extracts the folders from the entity based on the config details.
	 *
	 * @param  object  $item  The field item to inspect.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractFolders(object $item): void
	{
		// Only continue if we have
		// folders in these kind of entities
		if (!$this->hasFolders)
		{
			return;
		}

		foreach ($this->folders as $fieldName => $target)
		{
			// Decide which normaliser to employ
			$values = (strpos($fieldName, '|') === false)
				? $this->normalizeToStringArray($item->{$fieldName} ?? null)
				: $this->normalizeToSubformArray($fieldName, $item);

			// Persist every resolved value
			foreach ($values as $value)
			{
				$this->recordFolder($value, $target);
			}
		}
	}

	/**
	 * Process custom code function references from value.
	 *
	 * @param   string  $value  The input string to scan.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractCustomCode(string $value): void
	{
		$function_names = $this->getCustomCode($value);

		foreach ($function_names as $function_name)
		{
			$this->record(
				'parent',
				'custom_code',
				$function_name,
				'#__componentbuilder_custom_code',
				'function_name'
			);
		}
	}

	/**
	 * Process template usages from value.
	 *
	 * @param   string  $value  The input string to scan.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractTemplates(string $value): void
	{
		$guids = $this->getTemplates($value);

		foreach ($guids as $guid)
		{
			$this->record(
				'parent',
				'template',
				$guid,
				'#__componentbuilder_template',
				'guid'
			);
		}
	}

	/**
	 * Process layout references from value.
	 *
	 * @param   string  $value  The input string to scan.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractLayouts(string $value): void
	{
		$guids = $this->getLayouts($value);

		foreach ($guids as $guid)
		{
			$this->record(
				'parent',
				'layout',
				$guid,
				'#__componentbuilder_layout',
				'guid'
			);
		}
	}

	/**
	 * Process placeholder targets from value.
	 *
	 * @param   string  $value  The input string to scan.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function extractPlaceholders(string $value): void
	{
		foreach ($this->getPlaceholders($value) as $target)
		{
			$this->record('parent', 'placeholder', "[[[{$target}]]]", '#__componentbuilder_placeholder', 'target');
		}
	}

	/**
	 * Extracts custom code function names from a string value.
	 *
	 * Handles both direct names and numeric IDs, including parsing
	 * '+'-delimited forms where only the first token is used.
	 *
	 * @param   string  $value
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	protected function getCustomCode(string $value): array
	{
		if (strpos($value, '[CUSTO' . 'MCODE=') === false)
		{
			return [];
		}

		$results = [];
		$matches = GetHelper::allBetween($value, '[CUSTO' . 'MCODE=', ']') ?? [];

		foreach ($matches as $raw)
		{
			$raw = trim((string) $raw);

			if (!StringHelper::check($raw))
			{
				continue;
			}

			// Support 'id+name' format, prefer the ID
			$key = strpos($raw, '+') !== false ? trim(explode('+', $raw, 2)[0]) : $raw;

			// Use helper lookup for numeric keys
			if (is_numeric($key))
			{
				$name = GetHelper::var('custom_code', $key, 'id', 'function_name');

				if (StringHelper::check($name))
				{
					$results[] = $name;
				}
			}
			elseif (StringHelper::check($key))
			{
				$results[] = $key;
			}
		}

		return array_unique($results);
	}

	/**
	 * Extracts template names (GUIDs) from a string value.
	 *
	 * @param   string  $value
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	protected function getTemplates(string $value): array
	{
		$templates = [];

		$temp1 = GetHelper::allBetween($value, "\$this->load" . "Template('", "')");
		$temp2 = GetHelper::allBetween($value, '$this->load' . 'Template("', '")');

		if (!empty($temp1))
		{
			$templates = array_merge($templates, $temp1);
		}

		if (!empty($temp2))
		{
			$templates = array_merge($templates, $temp2);
		}

		$guids = [];
		foreach ($templates as $template)
		{
			$guid = $this->alias_map['template'][$template] ?? null;
			if ($guid !== null)
			{
				$guids[$guid] = $guid;
			}
		}

		return array_values($guids);
	}

	/**
	 * Extracts layout names (GUIDs) from a string value.
	 *
	 * @param   string  $value
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	protected function getLayouts(string $value): array
	{
		$layouts = [];

		$patterns = [
			["Layout" . "Helper::render('", "'"],
			['Layout' . 'Helper::render("', '"'],
			["Joomla__" . "_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('", "'"],
			['Joomla__' . '_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render("', '"'],
		];

		foreach ($patterns as [$start, $end])
		{
			$found = GetHelper::allBetween($value, $start, $end);
			if (!empty($found))
			{
				$layouts = array_merge($layouts, $found);
			}
		}

		$guids = [];
		foreach ($layouts as $layout)
		{
			$guid = $this->alias_map['layout'][$layout] ?? null;
			if ($guid !== null)
			{
				$guids[$guid] = $guid;
			}
		}
		return array_values($guids);
	}

	/**
	 * Extracts placeholders from a string value.
	 *
	 * @param   string  $value
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	protected function getPlaceholders(string $value): array
	{
		$placeholders = GetHelper::allBetween($value, '[[[', ']]]') ?? [];
		foreach ($placeholders as $key => $placeholder)
		{
			if (!$this->load->value(['id'], ['placeholder'], ['target' => "[[[{$placeholder}]]]"]))
			{
				unset($placeholders[$key]);
			}
		}
		return $placeholders;
	}

	/**
	 * Normalizes a raw field value into an array of strings.
	 *
	 * Accepts strings, arrays of strings, or Traversable of strings. Any invalid or
	 * non-scalar values are excluded.
	 *
	 * @param   mixed  $raw  The raw value from the item field.
	 *
	 * @return  string[]  A list of clean, non-empty string values.
	 * @since   5.1.1
	 */
	protected function normalizeToStringArray(mixed $raw): array
	{
		return array_values(array_filter(match (true) {
			is_string($raw)               => [$raw],
			is_array($raw)                => $raw,
			$raw instanceof \Traversable   => iterator_to_array($raw),
			default                       => [],
		}, static fn($v) => is_string($v) && trim($v) !== ''));
	}

	/**
	 * Traverses an arbitrarily nested sub-form path and returns every value
	 * found as a clean string array.
	 *
	 * Example field path: "contacts|0|address|street".
	 *   • "contacts" is the root field on <code>$item</code> (holds the sub-form rows).
	 *   • Intermediate numeric parts are row indexes; non-numeric parts are keys.
	 *
	 * @param   string  $fieldPath  Full field name containing “|” separators.
	 * @param   object  $item       Source data object (row returned from Joomla DB).
	 *
	 * @return  string[]  One-dimensional list of normalised values.
	 * @since   5.1.1
	 */
	protected function normalizeToSubformArray(string $fieldPath, object $item): array
	{
		$parts     = explode('|', $fieldPath);
		$coreField = array_shift($parts);

		$subData = $item->{$coreField} ?? null;

		// If the core field is missing or isn’t an array, nothing to do
		if (!is_array($subData) && !is_object($subData))
		{
			return [];
		}

		// Collect every leaf value along the remaining path
		$rawValues = $this->collectSubformValues((array) $subData, $parts);

		// Flatten, normalise, de-duplicate
		$result = [];
		foreach ($rawValues as $value)
		{
			foreach ($this->normalizeToStringArray($value) as $v)
			{
				$result[] = $v;
			}
		}

		return array_values(array_unique($result));
	}

	/**
	 * Recursively digs through the sub-form structure to harvest raw leaf values.
	 *
	 * @param   mixed   $data  Current level (array|object|scalar).
	 * @param   string[] $path  Remaining segments to traverse.
	 *
	 * @return  array  Collected raw values (may still be arrays/scalars at this point).
	 * @since   5.1.1
	 */
	protected function collectSubformValues(mixed $data, array $path): array
	{
		if ($data === null)
		{
			return [];
		}

		// Reached the end of the path → return whatever is here
		if ($path === [])
		{
			return [$data];
		}

		$segment   = array_shift($path);
		$collected = [];

		// ───────────────────────────────────────────────────────────
		// ARRAY HANDLING
		// ───────────────────────────────────────────────────────────
		if (is_array($data))
		{
			// Numeric segment = address specific row
			if (is_numeric($segment))
			{
				$index = (int) $segment;
				if (array_key_exists($index, $data))
				{
					$collected = $this->collectSubformValues($data[$index], $path);
				}
			}
			// Non-numeric segment = traverse same key in *all* rows
			else
			{
				foreach ($data as $row)
				{
					if ((is_array($row) && array_key_exists($segment, $row)) ||
						(is_object($row) && property_exists($row, $segment)))
					{
						$next = is_array($row) ? $row[$segment] : $row->{$segment};
						$collected = array_merge(
							$collected,
							$this->collectSubformValues($next, $path)
						);
					}
				}
			}
		}

		// ───────────────────────────────────────────────────────────
		// OBJECT HANDLING
		// ───────────────────────────────────────────────────────────
		elseif (is_object($data) && property_exists($data, $segment))
		{
			$collected = $this->collectSubformValues($data->{$segment}, $path);
		}

		// ───────────────────────────────────────────────────────────
		// DEEP SEEK HANDLING ;)
		// ───────────────────────────────────────────────────────────
		else
		{
			foreach ($data as $row)
			{
				if ((is_array($row) && array_key_exists($segment, $row)) ||
					(is_object($row) && property_exists($row, $segment)))
				{
					$next = is_array($row) ? $row[$segment] : $row->{$segment};
					$collected = array_merge(
						$collected,
						$this->collectSubformValues($next, $path)
					);
				}
			}
		}

		return $collected;
	}

	/**
	 * Records a  child/parent in the tracker.
	 *
	 * @param   string  $target  The name of the target direction (child/parent).
	 * @param   string  $entity  The name of the related entity.
	 * @param   string  $value   The string value representing the link.
	 * @param   string  $table   The table name where the link originates.
	 * @param   string  $key     The key in the target table the link refers to.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function record(string $target, string $entity, string $value, string $table, string $key): void
	{
		/**
		 * (all parents) dependencies must be tracked/recorded for export/import of this entity
		 *    parent: dependencies are those entities that [this entity] needs/depends on
		 *
		 * But only (direct children) should be tracked/recorded for export/import of this entity
		 *    children: dependencies are those entities that need/depends on [this entity]
		 *    direct-children: dependencies are those entities that [this entity] ALSO needs/depends on :)
		 */
		if (($target === 'child' && !$this->vaildDirectChild($entity, $value, $table, $key)) || !$this->validValue($value, $key))
		{
			return;
		}

		$record = [
			'key'   => $key,
			'value' => $value,
			'entity' => $entity,
			'table' => $table,
			'direction' => $target === 'child' ? 'in' : 'out'
		];

		// add to the current item (for recovery loading)
		$this->dependencies["{$entity}|{$key}|{$value}"] = $record;

		// check if it has been loaded
		if (!$this->tracker->exists("save.{$entity}.{$key}|{$value}"))
		{
			// all dependencies is added to the
			// global tracker (for later loading)
			$this->tracker->set("set.{$entity}.{$key}|{$value}", $record);
		}
	}

	/**
	 * Records a file in the tracker.
	 *
	 * @param   string  $filePath    The file path.
	 * @param   string  $type    The file target.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function recordFile(string $filePath, string $target): void
	{
		$file = $this->normalize->path($filePath, $target);
		if (!is_array($file) || empty($file['key']) || empty($file['path']) || empty($file['full']))
		{
			return;
		}

		['key' => $key, 'path' => $path, 'full' => $full] = $file;

		$pointer = str_replace('.', '--', $key);

		/**
		 * (all files) files must be tracker/recorded for export/import of this entity
		 *    file: dependencies are those files that [this entity] needs/depends on
		 */
		$record = [
			'key' => $key,
			'pointer' => $pointer,
			'value' => $path,
			'entity' => 'file',
			'table' => 'file_system',
			'target' => $target
		];

		// add to the current item
		// for recovery loading
		$this->dependencies["file|{$pointer}"] = $record;

		if (!$this->tracker->exists("file.save.{$pointer}"))
		{
			// all dependencies is added to the
			// global tracker for later loading
			$record['full'] = $full;
			$this->tracker->set("file.set.{$pointer}", $record);
		}
	}

	/**
	 * Records a folder in the tracker.
	 *
	 * @param   string  $type    The folder target.
	 * @param   string  $path    The folder path.
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	protected function recordFolder(string $folderPath, string $target): void
	{
		$folder = $this->normalize->path($folderPath, $target);
		if (!is_array($folder) || empty($folder['key']) || empty($folder['path']) || empty($folder['full']))
		{
			return;
		}

		['key' => $key, 'path' => $path, 'full' => $full] = $folder;

		$pointer = str_replace('.', '--', $key);

		/**
		 * (all folders) folders must be tracker/recorded for export/import of this entity
		 *    folder: dependencies are those folders that [this entity] needs/depends on
		 */
		$record = [
			'key' => $key,
			'pointer' => $pointer,
			'value' => $path,
			'entity' => 'folder',
			'table' => 'file_system',
			'target' => $target
		];

		// add to the current item
		// for recovery loading
		$this->dependencies["folder|{$pointer}"] = $record;

		if (!$this->tracker->exists("folder.save.{$pointer}"))
		{
			// all dependencies is added to the
			// global tracker for later loading
			$record['full'] = $full;
			$this->tracker->set("folder.set.{$pointer}", $record);
		}
	}

	/**
	 * Check if this is a valid direct child dependencies
	 *
	 * @param   string  $entity  The name of the related entity.
	 * @param   string  $value   The string value representing the link.
	 * @param   string  $table   The table name where the link originates.
	 * @param   string  $key     The key in the target table the link refers to.
	 *
	 * @return  bool   true when this is a valid child
	 * @since   5.1.1
	 */
	protected function vaildDirectChild(string $entity, string $value, string $table, string $key): bool
	{
		// should be part of the children listed
		if (in_array($entity, $this->config->getChildren(), true))
		{
			// confirm the child exist
			return $this->load->value([$key], [$table], [$key => $value]) !== null;
		}

		return false;
	}

	/**
	 * Check if the given value is a valid entity key value.
	 *
	 * @param string    $value  The value to validate.
	 * @param   string  $key    The key in the target table the link refers to.
	 *
	 * @return bool True if valid, false otherwise.
	 * @since  5.1.1
	 */
	protected function validValue(string $value, string $key): bool
	{
		if ($key === 'guid')
		{
			return $this->validGuid($value);
		}

		if (is_numeric($value))
		{
			return (int) $value > 0;
		}

		return strlen(trim($value)) > 3;
	}

	/**
	 * Validate the Globally Unique Identifier
	 *
	 * @param string $guid
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected static function validGuid($guid)
	{
		// check if we have a string
		if (!empty($guid) && is_string($guid))
		{
			return preg_match("/^(\{)?[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}(?(1)\})$/i", $guid);
		}
		return false;
	}

	/**
	 * Initialize the resolver
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function init(): void
	{
		$this->setAliasMap();
		$this->setEntityParents();
		$this->setEntityChildren();
		$this->setEntitySearchAreas();
		$this->setEntityFiles();
		$this->setEntityFolders();
	}

	/**
	 * Set all the linked fields (parents) of this table
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function setEntityParents(): void
	{
		$this->parents = $this->table->parents($this->config->getTable());
	}

	/**
	 * Set all the dependencies (children) of this entity
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function setEntityChildren(): void
	{
		$this->children = $this->table->children($this->config->getTable(), $this->config->getChildren());
	}

	/**
	 * Set all the related table search fields
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function setEntitySearchAreas(): void
	{
		$table = $this->config->getTable();
		$this->code = $this->table->search($table, 'code');

		// Only continue if we are not targeting a placeholder table
		if ($table === 'placeholder' || $table === 'component_placeholders')
		{
			$this->placeholders = [];
			return;
		}

		$this->placeholders = $this->table->search($table, 'placeholders');
	}

	/**
	 * Set all the related table files field names
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function setEntityFiles(): void
	{
		$this->files = $this->config->getFiles();
		if ($this->files === [])
		{
			$this->hasFiles = false;
			return;
		}

		$this->hasFiles = true;
	}

	/**
	 * Set all the related table folders field names
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function setEntityFolders(): void
	{
		$this->folders = $this->config->getFolders();
		if ($this->folders === [])
		{
			$this->hasFolders = false;
			return;
		}

		$this->hasFolders = true;
	}

	/**
	 * Load all alias and GUID's of template and layout tables
	 *
	 * @return  void
	 * @since   5.1.1
	 */
	private function setAliasMap(): void
	{
		// now check if key is found
		foreach(['template', 'layout'] as $table)
		{
			$items = $this->load->items(['id', 'guid', 'alias'], [$table]);
			if ($items !== null)
			{
				$this->alias_map[$table] = [];
				foreach ($items as $item)
				{
					if (empty($item->alias))
					{
						continue;
					}

					if (empty($item->guid) || !$this->validateGuid($item->guid))
					{
						$item->guid = $this->setGuid($item->id, $table);
					}

					// build the key
					$k_ey = StringHelper::safe($item->alias);
					$key  = preg_replace("/[^A-Za-z]/", '', (string) $k_ey);

					// set the keys
					$this->alias_map[$table][$item->alias] = $item->guid;
					$this->alias_map[$table][$k_ey] = $item->guid;
					$this->alias_map[$table][$key] = $item->guid;
				}
			}
		}
	}

	/**
	 * Set GUID for an item.
	 *
	 * @param   int     $id
	 * @param   string  $table
	 *
	 * @return  string  The guid that was set
	 * @since   5.1.2
	 */
	private function setGuid($id, $table): string
	{
		$guid = $this->table($table)->getGuid('guid');

		$this->items->table($table)->set([['id' => $id, 'guid' => $guid]], 'id');

		return $guid;
	}

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since   5.1.2
	 */
	private function getTable(): string
	{
		return $this->table_name;
	}
}

