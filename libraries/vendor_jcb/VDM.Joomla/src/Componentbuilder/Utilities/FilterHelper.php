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

namespace VDM\Joomla\Componentbuilder\Utilities;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Filter Helper
 * 
 * @since 3.2.0
 */
abstract class FilterHelper
{
	/**
	 * get extensions grouped list xml
	 *
	 * @return string   The XML string of Extentions
	 * @since 3.2.0
	 */
	public static function extensions(): string
	{
		// the extension types
		$extensions = array(
			'joomla_component' => 'COM_COMPONENTBUILDER_COMPONENT',
			'joomla_module' => 'COM_COMPONENTBUILDER_MODULE',
			'joomla_plugin' => 'COM_COMPONENTBUILDER_PLUGIN'
		);

		// get the extension values
		foreach ($extensions as $extension => $label)
		{
			${$extension} = self::names($extension);
		}

		$xml = new \DOMDocument();
		$xml->formatOutput = true;

		$root = $xml->createElement('field');
		$root->setAttributeNode(new \DOMAttr('name', 'extension'));
		$root->setAttributeNode(new \DOMAttr('type', 'groupedlist'));
		$root->setAttributeNode(new \DOMAttr('onchange', 'this.form.submit();'));

		$root
			->appendChild($xml->createElement('option', '- ' . Text::_('COM_COMPONENTBUILDER_SELECT_EXTENSION') . ' -'))
			->setAttributeNode(new \DOMAttr('value', ''));

		foreach ($extensions as $extension => $label)
		{
			$extension_node = $xml->createElement('group');
			$extension_node->setAttributeNode(new \DOMAttr('label', $label));
			if (!ArrayHelper::check(${$extension}))
			{
				$extension_node
					->appendChild($xml->createElement('option', '- ' . Text::_('COM_COMPONENTBUILDER_NONE') . ' -'))
					->setAttributeNode(new \DOMAttr('disabled', 'true'));
			}
			else
			{
				foreach (${$extension} as $id => $element)
				{
					$extension_node
						->appendChild($xml->createElement('option', $element))
						->setAttributeNode(new \DOMAttr('value', $extension . '__' . $id));
				}
			}
			$root->appendChild($extension_node);
		}
		$xml->appendChild($root);

		return $xml->saveXML();
	}

	/**
	 * Get by type the ids and system names
	 *
	 * @param string       $type       The table name to get system names for
	 * @param string|null  $limiter    The to limit by limiter table
	 *
	 * @return array|null   The array of system name and IDs
	 * @since 3.2.0
	 */
	public static function names(string $type, ?string $limiter = null): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($db->quoteName(array('id', 'system_name')))
			->from($db->quoteName('#__componentbuilder_' . $type))
			->where($db->quoteName('published') . ' >= 1')
			->order($db->quoteName('modified') . ' desc')
			->order($db->quoteName('created') . ' desc');

		// check if we have a limiter for admin views
		if ($type === 'admin_view' && $limiter)
		{
			// first get all views
			$admin_view_ids = array();

			// if this is a plugin or a module, then no views
			if (strpos($limiter, 'joomla_component') !== false)
			{
				$component = (int) str_replace('joomla_component__', '', $limiter);
				// get the views of this component
				if ($add_views = GetHelper::var('component_admin_views', (int) $component, 'joomla_component', 'addadmin_views'))
				{
					if (JsonHelper::check($add_views))
					{
						$add_views = json_decode($add_views, true);
						if (ArrayHelper::check($add_views))
						{
							foreach($add_views as $add_view)
							{
								if (isset($add_view['adminview']))
								{
									$admin_view_ids[(int) $add_view['adminview']] = (int) $add_view['adminview'];
								}
							}
						}
					}
				}
			}
			// now check if we still have admin views
			if (ArrayHelper::check($admin_view_ids))
			{
				$query->where($db->quoteName('id') . ' IN (' . implode(',', $admin_view_ids) . ')');
			}
			else
			{
				return null;
			}
		}

		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			return $db->loadAssocList('id', 'system_name');
		}

		return null;
	}

	/**
	 * get any area linked IDs
	 *
	 * @param int      $id        The target ID
	 * @param string   $method    The target method
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 **/
	public static function linked(int $id, string $method): ?array
	{
		// check if method exist
		if (method_exists(__CLASS__, $method))
		{
			return self::{$method}($id);
		}

		return null;
	}

	/**
	 * get the substrings of the namespace until the last "\" or "."
	 *
	 * @return array|null   The result substrings
	 * @since 3.2.0
	 **/
	public static function namespaces(): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select(
				'DISTINCT REPLACE(SUBSTRING('
				. $db->quoteName('namespace')
				. ', 1, LENGTH('
				. $db->quoteName('namespace')
				. ') - LEAST('
				. 'IF(LOCATE('
				. $db->quote('\\')
				. ', ' . $db->quoteName('namespace')
				. ') > 0, LOCATE('
				. $db->quote('\\')
				. ', REVERSE('
				. $db->quoteName('namespace')
				. ')), 0), '
				. 'IF(LOCATE('
				. $db->quote('.')
				. ', ' . $db->quoteName('namespace')
				. ') > 0, LOCATE('
				. $db->quote('.')
				. ', REVERSE('
				. $db->quoteName('namespace')
				. ')), 0))), ".", "\\\") AS trimmed_namespace'
			)
			->from($db->quoteName('#__componentbuilder_power'))
			->where($db->quoteName('published') . ' = 1')
			->order('LENGTH(trimmed_namespace) ASC, trimmed_namespace ASC');
		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			return $db->loadAssocList('trimmed_namespace', 'trimmed_namespace');
		}

		return null;
	}

	/**
	 * get get IDs of powers matching namespaces
	 *
	 * @param string   $namespace    The target namespace
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 **/
	public static function namegroup(string $namespace): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('id')))
			->from($db->quoteName('#__componentbuilder_power'))
			->where($db->quoteName('published') . ' = 1');

		// we get only those that match the owner and repo (smaller set)
		$paths = explode('\\', $namespace);
		foreach ($paths as $path)
		{
			$query->where($db->quoteName('namespace') . ' REGEXP ' . $db->quote($path));
		}

		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			return $db->loadColumn();
		}

		return null;
	}

	/**
	 * get translation extension ids
	 *
	 * @param int      $extension    The target ID
	 * @param string   $type         The target method
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 **/
	public static function translation(int $extension, string $type): ?array
	{
		// only allow these columns (extension types)
		$columns = array(
			'joomla_component' => 'components',
			'joomla_module' => 'modules',
			'joomla_plugin' => 'plugins'
		);

		// check if the column name is correct
		if (isset($columns[$type]))
		{
			$column = $columns[$type];
			$db = Factory::getDbo();
			$query = $db->getQuery(true);
			$query
				->select($db->quoteName(array('id', $column)))
				->from($db->quoteName('#__componentbuilder_language_translation'))
				->where($db->quoteName($column) . ' != ' . $db->quote(''));

			$db->setQuery($query);
			$db->execute();

			if ($db->getNumRows())
			{
				$results = $db->loadAssocList();
				$matches = [];
				foreach ($results as $k => $v)
				{
					$value = json_decode($v[$column], true);
					if (in_array($extension, $value))
					{
						$matches[$v['id']] = $v['id'];
					}
				}

				// Checks that we found matches
				if (ArrayHelper::check($matches))
				{
					return array_values($matches);
				}
			}
		}

		return null;
	}

	/**
	 * get translation ids
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 **/
	public static function translations($language, $translated = true): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($db->quoteName('id'))
			->from($db->quoteName('#__componentbuilder_language_translation'));

		// Build the where condition
		if ($translated === true) // Translated
		{
			if ($language === 'all')
			{
				if (($languages = self::languages()) !== null)
				{
					$wheres = [];
					foreach ($languages as $k => $v)
					{
						$wheres[] = $db->quoteName('translation') . ' LIKE ' . $db->quote('%' . $k . '%');
					}
					$query->where($wheres);
				}
			}
			else
			{
				$query->where($db->quoteName('translation') . ' LIKE ' . $db->quote('%' . $language . '%'));
			}
		}
		else // Not translated
		{
			if ($language === 'none')
			{
				$query->where(
					array(
						$db->quoteName('translation') . ' = ' . $db->quote(''),
						$db->quoteName('translation') . ' = ' . $db->quote('[]'),
						$db->quoteName('translation') . ' = ' . $db->quote('{}')
					), 'OR'
				);
			}
			else
			{
				$query->where($db->quoteName('translation') . ' NOT LIKE ' . $db->quote('%' . $language . '%'));
			}
		}

		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			return array_unique($db->loadColumn());
		}

		return null;
	}

	/**
	 * get available languages
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 **/
	public static function languages(): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('langtag', 'name')))
			->from($db->quoteName('#__componentbuilder_language'))
			->where($db->quoteName('published') . ' = 1')
			->order($db->quoteName('name') . ' desc');
		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			return $db->loadAssocList('langtag', 'name');
		}

		return null;
	}

	/**
	 * get get IDs of powers link to this path
	 *
	 * @param string   $path    The target PATH
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 **/
	public static function paths(string $path): ?array
	{
		// get all this power ids
		$ids = [];

		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('id', 'approved_paths')))
			->from($db->quoteName('#__componentbuilder_power'))
			->where($db->quoteName('published') . ' = 1');

		// we get only those that match the owner and repo (smaller set)
		if (($pos = strpos($path, '/')) !== false)
		{
			$owner = substr($path,  0, $pos);
			$repo = substr($path, $pos + 1);
			$query
				->where($db->quoteName('approved_paths') . ' REGEXP ' . $db->quote($owner))
				->where($db->quoteName('approved_paths') . ' REGEXP ' . $db->quote($repo));
		}

		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			$result = $db->loadAssocList('id', 'approved_paths');
			foreach ($result as $id => $paths)
			{
				if (JsonHelper::check($paths))
				{
					$paths = json_decode($paths, true);
					if (ArrayHelper::check($paths) && in_array($path, $paths, true))
					{
						$ids[$id] = $id;
					}
				}
			}

			if (ArrayHelper::check($ids))
			{
				return $ids;
			}
		}

		return null;
	}

	/**
	 * get available repositories of target area
	 *
	 * @param int   $target    The target area
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 **/
	public static function repositories(int $target): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName(array('repository', 'organisation')))
			->from($db->quoteName('#__componentbuilder_repository'))
			->where($db->quoteName('published') . ' >= 1')
			->where($db->quoteName('target') . ' = ' . $target)
			->order($db->quoteName('ordering') . ' desc');
		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows())
		{
			$items = $db->loadObjectList();
			$options = [];
			foreach($items as $item)
			{
				$path = $item->organisation . '/' . $item->repository;
				$options[$path] =  $path;
			}
			return $options;
		}

		return null;
	}

	/**
	 * Get a component admin views IDs
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 */
	private static function joomla_component_admin_views(int $id): ?array
	{
		// get all this components views
		$admin_view_ids = [];

		// get the views of this component
		if ($add_views = GetHelper::var('component_admin_views', (int) $id, 'joomla_component', 'addadmin_views'))
		{
			if (JsonHelper::check($add_views))
			{
				$add_views = json_decode($add_views, true);
				if (ArrayHelper::check($add_views))
				{
					foreach($add_views as $add_view)
					{
						if (isset($add_view['adminview']))
						{
							$admin_view_ids[(int) $add_view['adminview']] = (int) $add_view['adminview'];
						}
					}
				}
			}
		}

		// check that we have fields
		if (ArrayHelper::check($admin_view_ids))
		{
			return array_values($admin_view_ids);
		}

		return null;
	}

	/**
	 * get a component custom admin views IDs
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 */
	private static function joomla_component_custom_admin_views($id): ?array
	{
		// get all this components views
		$admin_view_ids = [];

		// get the views of this component
		if ($add_views = GetHelper::var('component_custom_admin_views', (int) $id, 'joomla_component', 'addcustom_admin_views'))
		{
			if (JsonHelper::check($add_views))
			{
				$add_views = json_decode($add_views, true);
				if (ArrayHelper::check($add_views))
				{
					foreach($add_views as $add_view)
					{
						if (isset($add_view['customadminview']))
						{
							$admin_view_ids[(int) $add_view['customadminview']] = (int) $add_view['customadminview'];
						}
					}
				}
			}
		}

		// check that we have fields
		if (ArrayHelper::check($admin_view_ids))
		{
			return array_values($admin_view_ids);
		}

		return null;
	}

	/**
	 * get a component site views IDs
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 */
	private static function joomla_component_site_views($id): ?array
	{
		// get all this components views
		$admin_view_ids = [];

		// get the views of this component
		if ($add_views = GetHelper::var('component_site_views', (int) $id, 'joomla_component', 'addsite_views'))
		{
			if (JsonHelper::check($add_views))
			{
				$add_views = json_decode($add_views, true);
				if (ArrayHelper::check($add_views))
				{
					foreach($add_views as $add_view)
					{
						if (isset($add_view['siteview']))
						{
							$admin_view_ids[(int) $add_view['siteview']] = (int) $add_view['siteview'];
						}
					}
				}
			}
		}

		// check that we have fields
		if (ArrayHelper::check($admin_view_ids))
		{
			return array_values($admin_view_ids);
		}

		return null;
	}

	/**
	 * get a component fields IDs
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 */
	private static function joomla_component($id): ?array
	{
		// we start the field array
		$field_ids = [];

		// first get all views
		$admin_view_ids = [];

		// get the views of this component
		if ($add_views = GetHelper::var('component_admin_views', (int) $id, 'joomla_component', 'addadmin_views'))
		{
			if (JsonHelper::check($add_views))
			{
				$add_views = json_decode($add_views, true);
				if (ArrayHelper::check($add_views))
				{
					foreach($add_views as $add_view)
					{
						if (isset($add_view['adminview']))
						{
							$admin_view_ids[(int) $add_view['adminview']] = (int) $add_view['adminview'];
						}
					}
				}
			}
		}

		// check that we have views
		if (ArrayHelper::check($admin_view_ids))
		{
			foreach ($admin_view_ids as $admin_view)
			{
				// get all the fields linked to the admin view
				if ($add_fields = GetHelper::var('admin_fields', (int) $admin_view, 'admin_view', 'addfields'))
				{
					if (JsonHelper::check($add_fields))
					{
						$add_fields = json_decode($add_fields, true);
						if (ArrayHelper::check($add_fields))
						{
							foreach($add_fields as $add_field)
							{
								if (isset($add_field['field']))
								{
									$field_ids[(int) $add_field['field']] = (int) $add_field['field'];
								}
							}
						}
					}
				}
			}
		}

		// get config values
		if ($add_config = GetHelper::var('component_config', (int) $id, 'joomla_component', 'addconfig'))
		{
			if (JsonHelper::check($add_config))
			{
				$add_config = json_decode($add_config, true);
				if (ArrayHelper::check($add_config))
				{
					foreach($add_config as $add_conf)
					{
						if (isset($add_conf['field']))
						{
							$field_ids[(int) $add_conf['field']] = (int) $add_conf['field'];
						}
					}
				}
			}
		}

		// check that we have fields
		if (ArrayHelper::check($field_ids))
		{
			return array_values($field_ids);
		}

		return null;
	}

	/**
	 * get a module fields IDs
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 */
	private static function joomla_module($id): ?array
	{
		// we start the field array
		$field_ids = [];

		if ($fields = GetHelper::var('joomla_module', (int) $id, 'id', 'fields'))
		{
			if (JsonHelper::check($fields))
			{
				$fields = json_decode($fields, true);
				if (ArrayHelper::check($fields))
				{
					foreach($fields as $form)
					{
						if (isset($form['fields']) && ArrayHelper::check($form['fields']))
						{
							foreach ($form['fields'] as $field)
							{
								if (isset($field['field']))
								{
									$field_ids[(int) $field['field']] = (int) $field['field'];
								}
							}
						}
					}
				}
			}
		}

		// check that we have fields
		if (ArrayHelper::check($field_ids))
		{
			return array_values($field_ids);
		}

		return null;
	}

	/**
	 * get a plugin fields IDs
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 */
	private static function joomla_plugin($id): ?array
	{
		// we start the field array
		$field_ids = [];

		if ($fields = GetHelper::var('joomla_plugin', (int) $id, 'id', 'fields'))
		{
			if (JsonHelper::check($fields))
			{
				$fields = json_decode($fields, true);
				if (ArrayHelper::check($fields))
				{
					foreach($fields as $form)
					{
						if (isset($form['fields']) && ArrayHelper::check($form['fields']))
						{
							foreach ($form['fields'] as $field)
							{
								if (isset($field['field']))
								{
									$field_ids[(int) $field['field']] = (int) $field['field'];
								}
							}
						}
					}
				}
			}
		}

		// check that we have fields
		if (ArrayHelper::check($field_ids))
		{
			return array_values($field_ids);
		}

		return null;
	}

	/**
	 * get an admin view fields IDs
	 *
	 * @param int   $id    The target ID
	 *
	 * @return array|null   The result ids
	 * @since 3.2.0
	 */
	private static function admin_view($id): ?array
	{
		// we start the field array
		$field_ids = [];

		// get all the fields linked to the admin view
		if ($add_fields = GetHelper::var('admin_fields', (int) $id, 'admin_view', 'addfields'))
		{
			if (JsonHelper::check($add_fields))
			{
				$add_fields = json_decode($add_fields, true);
				if (ArrayHelper::check($add_fields))
				{
					foreach($add_fields as $add_field)
					{
						if (isset($add_field['field']))
						{
							$field_ids[(int) $add_field['field']] = (int) $add_field['field'];
						}
					}
				}
			}
		}

		// check that we have fields
		if (ArrayHelper::check($field_ids))
		{
			return array_values($field_ids);
		}

		return null;
	}

}

