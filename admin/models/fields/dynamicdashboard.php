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
 * Dynamicdashboard Form Field class for the Componentbuilder component
 */
class JFormFieldDynamicdashboard extends JFormFieldList
{
	/**
	 * The dynamicdashboard field type.
	 *
	 * @var		string
	 */
	public $type = 'dynamicdashboard';

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
		// set the targets
		$targets = array('adminview' => 'admin_view', 'customadminview' => 'custom_admin_view');
		$t = array('adminview' => 'A', 'customadminview' => 'C');
		// rest the options
		$options = array();
		// reset the custom admin views array
		$views = false;
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the linked back-end views
			foreach ($targets as $target => $view)
			{
				if ($result = ComponentbuilderHelper::getVar('component_'.$view.'s', (int) $ID, 'joomla_component', 'add'.$view.'s'))
				{
					$views[$target] = $result;
				}
			}
		}
		else
		{
			// not linked so there is none available
			return array(JHtml::_('select.option', '', JText::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_LINK_AN_ADMIN_OR_A_CUSTOM_ADMIN_VIEW_TO_THIS_COMPONENT_THEN_YOU_CAN_SELECT_IT_HERE')));
		}
		// check if we found any values
		if (ComponentbuilderHelper::checkArray($views))
		{
			foreach ($targets as $target => $view)
			{
				if (isset($views[$target]) && ComponentbuilderHelper::checkJson($views[$target]))
				{
					// convert to an array
					$value = json_decode($views[$target], true);
					$type = ComponentbuilderHelper::safeString($view, 'w');
					if (ComponentbuilderHelper::checkArray($value))
					{
						foreach ($value as $_view)
						{
							if (isset($_view[$target]) && is_numeric($_view[$target]))
							{
								// set the view to the selections if found
								if ($name = ComponentbuilderHelper::getVar($view, (int) $_view[$target], 'id', 'system_name'))
								{
									$options[] = JHtml::_('select.option', $t[$target].'_'.$_view[$target], $name.'  ['.$type.']');
								}
							}
						}
					}
				}
			}
		}
		// return found options
		if (ComponentbuilderHelper::checkArray($options))
		{
			array_unshift($options , JHtml::_('select.option', '', JText::_('COM_COMPONENTBUILDER_SELECT_AN_OPTION')));
			return $options;
		}
		// not linked so there is none available
		return array(JHtml::_('select.option', '', JText::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_LINK_AN_ADMIN_OR_A_CUSTOM_ADMIN_VIEW_TO_THIS_COMPONENT_THEN_YOU_CAN_SELECT_IT_HERE')));
	}
}
