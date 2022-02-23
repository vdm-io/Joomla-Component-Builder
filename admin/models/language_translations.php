<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\Utilities\ArrayHelper;

/**
 * Language_translations Model
 */
class ComponentbuilderModelLanguage_translations extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
        {
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
				'a.access','access',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'a.source','source'
			);
		}

		parent::__construct($config);
	}

	/**
	 * Get the filter form - Override the parent method
	 *
	 * @param   array    $data      data
	 * @param   boolean  $loadData  load current data
	 *
	 * @return  \JForm|boolean  The \JForm object or false on error
	 *
	 * @since   JCB 2.12.5
	 */
	public function getFilterForm($data = array(), $loadData = true)
	{
		// load form from the parent class
		$form = parent::getFilterForm($data, $loadData);

		// Create the "extension" filter
		$form->setField(new SimpleXMLElement(
			ComponentbuilderHelper::getExtensionGroupedListXml()
			),'filter');
		$form->setValue(
			'extension',
			'filter',
			$this->state->get("filter.extension")
		);
		array_push($this->filter_fields, 'extension');

		// Create the "translated in" filter
		$attributes = array(
			'name' => 'translated',
			'type' => 'list',
			'onchange' => 'this.form.submit();',
		);
		// no languages found notice
		$options = array(
			'' => '-  ' . JText::_('COM_COMPONENTBUILDER_NO_LANGUAGES_FOUND') . '  -'
		);
		// check if we have languages set
		if (($languages = ComponentbuilderHelper::getAvailableLanguages()) !== false)
		{
			$options = array(
				'' => '-  ' . JText::_('COM_COMPONENTBUILDER_TRANSLATED_IN') . '  -',
				'all' => JText::_('COM_COMPONENTBUILDER_EVERY_LANGUAGE')
			);

			$options = array_merge($options, $languages);
		}

		$form->setField(ComponentbuilderHelper::getFieldXML($attributes, $options),'filter');
		$form->setValue(
			'translated',
			'filter',
			$this->state->get("filter.translated")
		);
		array_push($this->filter_fields, 'translated');

		// Create the "not translated in" filter
		$attributes = array(
			'name' => 'not_translated',
			'type' => 'list',
			'onchange' => 'this.form.submit();',
		);
		// no languages found notice
		$options = array(
			'' => '-  ' . JText::_('COM_COMPONENTBUILDER_NO_LANGUAGES_FOUND') . '  -'
		);
		// check if we have languages set
		if ($languages)
		{
			$options = array(
				'' => '- ' . JText::_('COM_COMPONENTBUILDER_NOT_TRANSLATED_IN') . ' -',
				'none' => JText::_('COM_COMPONENTBUILDER_ANY_LANGUAGE')
			);

			$options = array_merge($options, $languages);
		}

		$form->setField(ComponentbuilderHelper::getFieldXML($attributes, $options),'filter');
		$form->setValue(
			'not_translated',
			'filter',
			$this->state->get("filter.not_translated")
		);
		array_push($this->filter_fields, 'not_translated');

		return $form;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 *
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		// Check if the form was submitted
		$formSubmited = $app->input->post->get('form_submited');

		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		if ($formSubmited)
		{
			$access = $app->input->post->get('access');
			$this->setState('filter.access', $access);
		}

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		$this->setState('filter.created', $created);

		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$source = $this->getUserStateFromRequest($this->context . '.filter.source', 'filter_source');
		if ($formSubmited)
		{
			$source = $app->input->post->get('source');
			$this->setState('filter.source', $source);
		}

		// List state information.
		parent::populateState($ordering, $direction);
	}
	
	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 */
	public function getItems()
	{
		// Check in items
		$this->checkInNow();

		// load parent items
		$items = parent::getItems();

		// Set values to display correctly.
		if (ComponentbuilderHelper::checkArray($items))
		{
			// Get the user object if not set.
			if (!isset($user) || !ComponentbuilderHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			foreach ($items as $nr => &$item)
			{
				// Remove items the user can't access.
				$access = ($user->authorise('language_translation.access', 'com_componentbuilder.language_translation.' . (int) $item->id) && $user->authorise('language_translation.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

				// escape all strings if not being exported
				if (!isset($_export))
				{
					$item->source = ComponentbuilderHelper::htmlEscape($item->source, 'UTF-8', true, 150);
				}
			}
		}
			// prep the lang strings for export
			if (isset($_export) && $_export && ComponentbuilderHelper::checkArray($items))
			{
				// insure we have the same order in the languages
				$languages = ComponentbuilderHelper::getVars('language', 1, 'published', 'langtag');
				foreach ($items as $nr => &$item)
				{
					// remove some values completely
					unset($item->components);
					unset($item->modules);
					unset($item->plugins);
					unset($item->params);
					unset($item->published);
					unset($item->created_by);
					unset($item->modified_by);
					unset($item->created);
					unset($item->modified);
					unset($item->version);
					unset($item->hits);
					unset($item->access);
					unset($item->ordering);
					// set the lang order
					if ($nr != 0)
					{
						foreach ($languages as $lanTag)
						{
							$item->{$lanTag} = '';
						}
						// now adapt the source
						if (isset($item->translation) && ComponentbuilderHelper::checkJson($item->translation))
						{
							$translations = json_decode($item->translation, true);
							if (ComponentbuilderHelper::checkArray($translations))
							{
								foreach ($translations as $language)
								{
									if (isset($language['translation']) && ComponentbuilderHelper::checkString($language['translation'])
									&& isset($language['language']) && ComponentbuilderHelper::checkString($language['language']))
									{
										$item->{$language['language']} = $language['translation'];
									}
								}
							}
						}
					}
					// remove translation
					unset($item->translation);
				}
			}
        
		// return items
		return $items;
	}
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_item table
		$query->from($db->quoteName('#__componentbuilder_language_translation', 'a'));

		// do not use these filters in the export method
		if (!isset($_export) || !$_export)
		{
			// Filtering "translated in"
			$filter_translated = $this->state->get("filter.translated");
			if ($filter_translated !== null && !empty($filter_translated))
			{
				if (($ids = ComponentbuilderHelper::getTranslationIds($filter_translated)) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
			}

			// Filtering "not translated in"
			$filter_not_translated = $this->state->get("filter.not_translated");
			if ($filter_not_translated !== null && !empty($filter_not_translated))
			{
				if (($ids = ComponentbuilderHelper::getTranslationIds($filter_not_translated, false)) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',',$ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
			}

			// Filtering "extension"
			$filter_extension = $this->state->get("filter.extension");
			if ($filter_extension !== null && !empty($filter_extension))
			{
				// column name, and id
				$type_extension = explode('__', $filter_extension);
				if (($ids = ComponentbuilderHelper::getTranslationExtensionsIds($type_extension[1], $type_extension[0])) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
			}
		}

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		// Filter by access level.
		$_access = $this->getState('filter.access');
		if ($_access && is_numeric($_access))
		{
			$query->where('a.access = ' . (int) $_access);
		}
		elseif (ComponentbuilderHelper::checkArray($_access))
		{
			// Secure the array for the query
			$_access = ArrayHelper::toInteger($_access);
			// Filter by the Access Array.
			$query->where('a.access IN (' . implode(',', $_access) . ')');
		}
		// Implement View Level Access
		if (!$user->authorise('core.options', 'com_componentbuilder'))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}
		// Filter by search.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search) . '%');
				$query->where('(a.source LIKE '.$search.' OR a.translation LIKE '.$search.')');
			}
		}


		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'desc');
		if ($orderCol != '')
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Method to get list export data.
	 *
	 * @param   array  $pks  The ids of the items to get
	 * @param   JUser  $user  The user making the request
	 *
	 * @return mixed  An array of data items on success, false on failure.
	 */
	public function getExportData($pks, $user = null)
	{
		// setup the query
		if (($pks_size = ComponentbuilderHelper::checkArray($pks)) !== false || 'bulk' === $pks)
		{
			// Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// Get the user object if not set.
			if (!isset($user) || !ComponentbuilderHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			// Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select('a.*');

			// From the componentbuilder_language_translation table
			$query->from($db->quoteName('#__componentbuilder_language_translation', 'a'));
			// The bulk export path
			if ('bulk' === $pks)
			{
				$query->where('a.id > 0');
			}
			// A large array of ID's will not work out well
			elseif ($pks_size > 500)
			{
				// Use lowest ID
				$query->where('a.id >= ' . (int) min($pks));
				// Use highest ID
				$query->where('a.id <= ' . (int) max($pks));
			}
			// The normal default path
			else
			{
				$query->where('a.id IN (' . implode(',',$pks) . ')');
			}

			// do not use these filters in the export method
		if (!isset($_export) || !$_export)
		{
			// Filtering "translated in"
			$filter_translated = $this->state->get("filter.translated");
			if ($filter_translated !== null && !empty($filter_translated))
			{
				if (($ids = ComponentbuilderHelper::getTranslationIds($filter_translated)) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
			}

			// Filtering "not translated in"
			$filter_not_translated = $this->state->get("filter.not_translated");
			if ($filter_not_translated !== null && !empty($filter_not_translated))
			{
				if (($ids = ComponentbuilderHelper::getTranslationIds($filter_not_translated, false)) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',',$ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
			}

			// Filtering "extension"
			$filter_extension = $this->state->get("filter.extension");
			if ($filter_extension !== null && !empty($filter_extension))
			{
				// column name, and id
				$type_extension = explode('__', $filter_extension);
				if (($ids = ComponentbuilderHelper::getTranslationExtensionsIds($type_extension[1], $type_extension[0])) !== false)
				{
					$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $ids) . ')');
				}
				else
				{
					// there is none
					$query->where($db->quoteName('a.id') . ' = ' . 0);
				}
			}
		}
			// Implement View Level Access
			if (!$user->authorise('core.options', 'com_componentbuilder'))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.ordering  ASC');

			// Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// Set values to display correctly.
				if (ComponentbuilderHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						// Remove items the user can't access.
						$access = ($user->authorise('language_translation.access', 'com_componentbuilder.language_translation.' . (int) $item->id) && $user->authorise('language_translation.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// escape all strings if not being exported
						if (!isset($_export))
						{
							$item->source = ComponentbuilderHelper::htmlEscape($item->source, 'UTF-8', true, 150);
						}
						// unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// Add headers to items array.
				$headers = $this->getExImPortHeaders();
				if (ComponentbuilderHelper::checkObject($headers))
				{
					array_unshift($items,$headers);
				}

					// prep the lang strings for export
			if (isset($_export) && $_export && ComponentbuilderHelper::checkArray($items))
			{
				// insure we have the same order in the languages
				$languages = ComponentbuilderHelper::getVars('language', 1, 'published', 'langtag');
				foreach ($items as $nr => &$item)
				{
					// remove some values completely
					unset($item->components);
					unset($item->modules);
					unset($item->plugins);
					unset($item->params);
					unset($item->published);
					unset($item->created_by);
					unset($item->modified_by);
					unset($item->created);
					unset($item->modified);
					unset($item->version);
					unset($item->hits);
					unset($item->access);
					unset($item->ordering);
					// set the lang order
					if ($nr != 0)
					{
						foreach ($languages as $lanTag)
						{
							$item->{$lanTag} = '';
						}
						// now adapt the source
						if (isset($item->translation) && ComponentbuilderHelper::checkJson($item->translation))
						{
							$translations = json_decode($item->translation, true);
							if (ComponentbuilderHelper::checkArray($translations))
							{
								foreach ($translations as $language)
								{
									if (isset($language['translation']) && ComponentbuilderHelper::checkString($language['translation'])
									&& isset($language['language']) && ComponentbuilderHelper::checkString($language['language']))
									{
										$item->{$language['language']} = $language['translation'];
									}
								}
							}
						}
					}
					// remove translation
					unset($item->translation);
				}
			}
				return $items;
			}
		}
		return false;
	}

	/**
	* Method to get header.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getExImPortHeaders()
	{
		$languages = ComponentbuilderHelper::getVars('language', 1, 'published', 'langtag');
		// start setup of headers
		$headers = new stdClass();
		$headers->id = 'id';
		$headers->Source = 'Source';
		// add the languages
		if (ComponentbuilderHelper::checkArray($languages))
		{
			foreach ($languages as $language)
			{
				$headers->{$language} = $language;
			}
		}
		return $headers;
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * @return  string  A store id.
	 *
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.id');
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		// Check if the value is an array
		$_access = $this->getState('filter.access');
		if (ComponentbuilderHelper::checkArray($_access))
		{
			$id .= ':' . implode(':', $_access);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_access)
		 || ComponentbuilderHelper::checkString($_access))
		{
			$id .= ':' . $_access;
		}
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		$id .= ':' . $this->getState('filter.source');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to checkin all items left checked out longer then a set time.
	 *
	 * @return  a bool
	 *
	 */
	protected function checkInNow()
	{
		// Get set check in time
		$time = JComponentHelper::getParams('com_componentbuilder')->get('check_in');

		if ($time)
		{

			// Get a db connection.
			$db = JFactory::getDbo();
			// Reset query.
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__componentbuilder_language_translation'));
			// Only select items that are checked out.
			$query->where($db->quoteName('checked_out') . '!=0');
			$db->setQuery($query, 0, 1);
			$db->execute();
			if ($db->getNumRows())
			{
				// Get Yesterdays date.
				$date = JFactory::getDate()->modify($time)->toSql();
				// Reset query.
				$query = $db->getQuery(true);

				// Fields to update.
				$fields = array(
					$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',
					$db->quoteName('checked_out') . '=0'
				);

				// Conditions for which records should be updated.
				$conditions = array(
					$db->quoteName('checked_out') . '!=0', 
					$db->quoteName('checked_out_time') . '<\''.$date.'\''
				);

				// Check table.
				$query->update($db->quoteName('#__componentbuilder_language_translation'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
