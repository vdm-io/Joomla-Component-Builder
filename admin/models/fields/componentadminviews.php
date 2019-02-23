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
 * Componentadminviews Form Field class for the Componentbuilder component
 */
class JFormFieldComponentadminviews extends JFormFieldList
{
	/**
	 * The componentadminviews field type.
	 *
	 * @var		string
	 */
	public $type = 'componentadminviews';

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
		$viewids = array();
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the joomla component ID
			$joomlacomponent = ComponentbuilderHelper::getVar('component_mysql_tweaks', (int) $ID, 'id', 'joomla_component');
		}
		else
		{
			// get the joomla component ID
			$joomlacomponent = $jinput->getInt('refid', 0);
		}
		if (is_numeric($joomlacomponent) && $joomlacomponent >= 1)
		{
			// get all the admin views linked to the joomla component
			if ($addAdminViews = ComponentbuilderHelper::getVar('component_admin_views', (int) $joomlacomponent, 'joomla_component', 'addadmin_views'))
			{
				if (ComponentbuilderHelper::checkJson($addAdminViews))
				{
					$addAdminViews = json_decode($addAdminViews, true);
					if (ComponentbuilderHelper::checkArray($addAdminViews))
					{
						foreach($addAdminViews as $addAdminView)
						{
							if (isset($addAdminView['adminview']))
							{
								$viewids[] = (int) $addAdminView['adminview'];
							}
						}
					}
				}
			}
		}
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.system_name'),array('id','name')));
		$query->from($db->quoteName('#__componentbuilder_admin_view', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		// filter by fields linked
		if (ComponentbuilderHelper::checkArray($viewids))
		{
			// only load these fields
			$query->where($db->quoteName('a.id') . ' IN (' . implode(',', $viewids) . ')');
		}
		$query->order('a.system_name ASC');
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		if ($items)
		{
			$options[] = JHtml::_('select.option', '', 'Select an option');
			foreach($items as $item)
			{
				$options[] = JHtml::_('select.option', $item->id, $item->name);
			}
		}
		
		return $options;
	}
}
