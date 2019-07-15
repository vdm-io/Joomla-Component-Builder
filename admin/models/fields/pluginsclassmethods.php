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
 * Pluginsclassmethods Form Field class for the Componentbuilder component
 */
class JFormFieldPluginsclassmethods extends JFormFieldList
{
	/**
	 * The pluginsclassmethods field type.
	 *
	 * @var		string
	 */
	public $type = 'pluginsclassmethods';

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
		$query->select($db->quoteName(array('a.id','a.name','a.visibility'),array('id','method_name','visibility')));
		$query->from($db->quoteName('#__componentbuilder_class_method', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->where($db->quoteName('a.extension_type') . ' = ' . $db->quote('plugins'));
		$query->order('a.name ASC');
		// Implement View Level Access (if set in table)
		if (!$user->authorise('core.options', 'com_componentbuilder'))
		{
			$columns = $db->getTableColumns('#__componentbuilder_class_method');
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
			$options[] = JHtml::_('select.option', '', 'Select a method');
			foreach($items as $item)
			{
				// we are using this code in more then one field JCB custom_code
				if ('method' === 'method')
				{
					$select = $item->visibility  . ' function ' . $item->method_name . '()';
				}
				else
				{
					$select = $item->visibility  . ' $' . $item->method_name;
				}
				$options[] = JHtml::_('select.option', $item->id, $select);
			}
		}
		return $options;
	}
}
