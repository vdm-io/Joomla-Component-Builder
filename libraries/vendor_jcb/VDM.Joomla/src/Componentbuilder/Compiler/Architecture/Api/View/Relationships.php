<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View;


use VDM\Joomla\Componentbuilder\Compiler\Builder\ComponentFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Api View Relationships Class.
 * 
 * Maps the relationships of a view's resource from the component field map:
 * every field that links to another table, every user and category field,
 * the users who created and last changed the record, and the tags. The map
 * feeds the relationship list of the JSON API views and the methods of the
 * resource serializer.
 * 
 * @since 6.1.7
 */
final class Relationships
{
	/**
	 * The Component code name.
	 *
	 * @var   string
	 * @since 6.1.7
	 */
	protected string $componentcode;

	/**
	 * The Component Fields Builder Class.
	 *
	 * @var   ComponentFields
	 * @since 6.1.7
	 */
	protected ComponentFields $componentfields;

	/**
	 * The Field Names Builder Class.
	 *
	 * @var   FieldNames
	 * @since 6.1.7
	 */
	protected FieldNames $fieldnames;

	/**
	 * The Tags Builder Class.
	 *
	 * @var   Tags
	 * @since 6.1.7
	 */
	protected Tags $tags;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * Constructor.
	 *
	 * @param Config            $config            The Config Class.
	 * @param ComponentFields   $componentfields   The Component Fields Builder Class.
	 * @param FieldNames        $fieldnames        The Field Names Builder Class.
	 * @param Tags              $tags              The Tags Builder Class.
	 * @param Component         $component         The Component Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, ComponentFields $componentfields,
		FieldNames $fieldnames, Tags $tags, Component $component)
	{
		$this->componentcode = (string) $config->component_code_name;
		$this->componentfields = $componentfields;
		$this->fieldnames = $fieldnames;
		$this->tags = $tags;
		$this->component = $component;
	}

	/**
	 * Get the relationship entries of a JSON API view.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 * @param   bool    $item            Build for the item view, else for the list view.
	 *
	 * @return  string  The array entries, one relationship per line.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, string $nameListCode, bool $item = true): string
	{
		$code = '';

		foreach ($this->map($nameSingleCode, $nameListCode) as $relation)
		{
			if (!$item && !$relation['list'])
			{
				continue;
			}

			$code .= PHP_EOL . Indent::_(2) . "'" . $relation['name'] . "',";
		}

		return $code;
	}

	/**
	 * The relationships of a view's resource.
	 *
	 * Each entry names the relationship, the column that holds the related
	 * id or ids, the type of the related resource, and whether the list
	 * representation carries it as well.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  array  The relationships, in the order the fields are declared.
	 * @since   6.1.7
	 */
	public function map(string $nameSingleCode, string $nameListCode): array
	{
		$map = [];
		$fields = $this->componentfields->get($nameSingleCode);

		if (is_array($fields))
		{
			foreach ($fields as $column => $field)
			{
				$column = (string) $column;

				if ($column === '' || !is_array($field))
				{
					continue;
				}

				$type = $this->relatedType($field);

				if ($type === null)
				{
					continue;
				}

				$map[$column] = $this->relation($column, $type);
			}
		}

		// the users who created and last changed the record
		foreach (['created_by', 'modified_by'] as $column)
		{
			if (!isset($map[$column])
				&& !$this->fieldnames->isString($nameSingleCode . '.' . $column))
			{
				$map[$column] = $this->relation($column, 'users');
			}
		}

		// the tags are only loaded as ids for the item
		if ($this->tags->exists($nameSingleCode))
		{
			$map['tags'] = $this->relation('tags', 'tags', false);
		}

		return array_values($map);
	}

	/**
	 * One relationship entry.
	 *
	 * @param   string  $column  The column holding the related id or ids.
	 * @param   string  $type    The type of the related resource.
	 * @param   bool    $list    Whether the list representation carries it.
	 *
	 * @return  array  The entry.
	 * @since   6.1.7
	 */
	private function relation(string $column, string $type, bool $list = true): array
	{
		return [
			'name' => $column,
			'column' => $column,
			'type' => $type,
			'list' => $list,
		];
	}

	/**
	 * The type of the resource one field relates to, or null when it relates to none.
	 *
	 * @param   array  $field  The component field map entry.
	 *
	 * @return  string|null  The related resource type.
	 * @since   6.1.7
	 */
	private function relatedType(array $field): ?string
	{
		$type = isset($field['type']) ? (string) $field['type'] : '';

		if ($type === 'user')
		{
			return 'users';
		}

		if ($type === 'category')
		{
			return 'categories';
		}

		$link = $field['link'] ?? null;

		if (!is_array($link))
		{
			return null;
		}

		$entity = isset($link['entity']) ? trim((string) $link['entity']) : '';

		if ($entity !== '')
		{
			return $this->listCode($entity);
		}

		$table = isset($link['table']) ? trim((string) $link['table']) : '';

		if ($table !== '')
		{
			return $this->tableType($table, $link['component'] ?? null);
		}

		return null;
	}

	/**
	 * The list code name of an admin view of this component, or the single
	 * code name when the view is not one of this component's.
	 *
	 * @param   string  $entity  The single code name of the linked view.
	 *
	 * @return  string  The resource type.
	 * @since   6.1.7
	 */
	private function listCode(string $entity): string
	{
		$views = $this->component->get('admin_views');

		if (is_array($views))
		{
			foreach ($views as $view)
			{
				$settings = is_array($view) ? ($view['settings'] ?? null) : null;

				if (is_object($settings) && isset($settings->name_single_code, $settings->name_list_code)
					&& (string) $settings->name_single_code === $entity
					&& (string) $settings->name_list_code !== '')
				{
					return (string) $settings->name_list_code;
				}
			}
		}

		return $entity;
	}

	/**
	 * The resource type derived from a linked table: the table name without
	 * the database prefix and without the component's own prefix.
	 *
	 * @param   string  $table      The linked table name.
	 * @param   mixed   $component  The component the link names, when it names one.
	 *
	 * @return  string  The resource type.
	 * @since   6.1.7
	 */
	private function tableType(string $table, $component): string
	{
		$name = ltrim(str_replace('#__', '', $table), '_');
		$code = (is_string($component) && trim($component) !== '')
			? str_replace('com_', '', trim($component))
			: $this->componentcode;

		if ($code !== '' && str_starts_with($name, $code . '_'))
		{
			$name = substr($name, strlen($code) + 1);
		}

		$name = strtolower(preg_replace('/[^A-Za-z0-9_]/', '', $name));

		return ($name === '') ? strtolower(trim($table, '#_')) : $name;
	}
}

