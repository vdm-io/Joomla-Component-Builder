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
 * Listfields Form Field class for the Componentbuilder component
 */
class JFormFieldListfields extends JFormFieldList
{
	/**
	 * The listfields field type.
	 *
	 * @var		string
	 */
	public $type = 'listfields';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array    An array of JHtml options.
	 */
	protected function getOptions()
	{
		// load the db opbject
		$db = JFactory::getDBO();		
		// get the input from url
		$jinput = JFactory::getApplication()->input;
		// get the id
		$ID = $jinput->getInt('id', 0);
		// rest the fields ids
		$fieldIds = array();
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the admin view ID
			$adminView = ComponentbuilderHelper::getVar('admin_fields_relations', (int) $ID, 'id', 'admin_view');
		}
		else
		{
			// get the admin view ID
			$adminView = $jinput->getInt('refid', 0);
		}
		if (is_numeric($adminView) && $adminView >= 1)
		{
			// get all the fields linked to the admin view
			if ($addFields = ComponentbuilderHelper::getVar('admin_fields', (int) $adminView, 'admin_view', 'addfields'))
			{
				if (ComponentbuilderHelper::checkJson($addFields))
				{
					$addFields = json_decode($addFields, true);
					if (ComponentbuilderHelper::checkArray($addFields))
					{
						foreach($addFields as $addField)
						{
							if (isset($addField['field']) && isset($addField['list']) && $addField['list'] == 1)
							{
								$fieldIds[] = (int) $addField['field'];
							}
						}
					}
				}
			}
			// filter by fields linked
			if (ComponentbuilderHelper::checkArray($fieldIds))
			{
				$query = $db->getQuery(true);
				$query->select($db->quoteName(array('a.id','a.name'),array('id','name')));
				$query->from($db->quoteName('#__componentbuilder_field', 'a'));
				$query->where($db->quoteName('a.published') . ' >= 1');
				// only load these fields
				$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $fieldIds) . ')');
				$query->order('a.name ASC');
				$db->setQuery((string)$query);
				$items = $db->loadObjectList();
				$options = array();
				if ($items)
				{
					$options[] = JHtml::_('select.option', '', JText::_('COM_COMPONENTBUILDER_SELECT_AN_OPTION'));
					foreach($items as $item)
					{
						$options[] = JHtml::_('select.option', $item->id, $item->name);
					}
				}
				return $options;
			}
		}
		return false;
	}
}
