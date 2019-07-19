<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Joomlaplugins Form Field class for the Componentbuilder component
 */
class JFormFieldJoomlaplugins extends JFormFieldList
{
	/**
	 * The joomlaplugins field type.
	 *
	 * @var		string
	 */
	public $type = 'joomlaplugins';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Get the databse object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.system_name','a.name','b.name','c.name'),array('id','plugin_system_name','name','class_extends_name','joomla_plugin_group_name')));
		$query->from($db->quoteName('#__componentbuilder_joomla_plugin', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_class_extends', 'b') . ' ON (' . $db->quoteName('a.class_extends') . ' = ' . $db->quoteName('b.id') . ')');
		$query->join('LEFT', $db->quoteName('#__componentbuilder_joomla_plugin_group', 'c') . ' ON (' . $db->quoteName('a.joomla_plugin_group') . ' = ' . $db->quoteName('c.id') . ')');
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.system_name ASC');
		// Implement View Level Access (if set in table)
		if (!$user->authorise('core.options', 'com_componentbuilder'))
		{
			$columns = $db->getTableColumns('#__componentbuilder_joomla_plugin');
			if(isset($columns['access']))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}
		}
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$options[] = JHtml::_('select.option', '', 'Select a plugin');
			foreach($items as $item)
			{
				// set a full class name
				$options[] = JHtml::_('select.option', $item->id, '( ' . $item->plugin_system_name . ' ) class Plg' . ucfirst($item->joomla_plugin_group_name) . $item->name . ' extends ' . $item->class_extends_name);
			}
		}
		return $options;
	}
}
