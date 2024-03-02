<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;

// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Powers Form Field class for the Componentbuilder component
 */
class JFormFieldPowers extends JFormFieldList
{
	/**
	 * The powers field type.
	 *
	 * @var        string
	 */
	public $type = 'powers';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return    array    An array of Html options.
	 */
	protected function getOptions()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Get the databse object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.guid','a.system_name','a.namespace','a.type','a.power_version'),array('guid','power_system_name','namespace','type','version')));
		$query->from($db->quoteName('#__componentbuilder_power', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.system_name ASC');
		$query->order('a.type ASC');
		// Implement View Level Access (if set in table)
		if (!$user->authorise('core.options', 'com_componentbuilder'))
		{
			$columns = $db->getTableColumns('#__componentbuilder_power');
			if(isset($columns['access']))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}
		}
		$db->setQuery((string)$query);
		$items = $db->loadObjectList();
		$options = array();
		// if none was found, we add this to set an alternative to set custom
		if (!$items)
		{
			$options[] = JHtml::_('select.option', '', 'None found');
		}
		if ($items)
		{
			if ($this->multiple === false)
			{
				$options[] = JHtml::_('select.option', '', 'Select an option');
			}
			foreach($items as $item)
			{
				$options[] = JHtml::_('select.option', $item->guid, str_replace('.','\\', $item->namespace) . ' [' . $item->power_system_name . '] (v' . $item->version . ' - ' . $item->type . ')');
			}
		}
		return $options;

	}
}
