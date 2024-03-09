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
namespace VDM\Component\Componentbuilder\Administrator\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Dynamicdashboard Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class DynamicdashboardField extends ListField
{
	/**
	 * The dynamicdashboard field type.
	 *
	 * @var        string
	 */
	public $type = 'Dynamicdashboard';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		// load the db opbject
		$db = Factory::getDBO();		
		// get the input from url
		$jinput = Factory::getApplication()->input;
		// get the id
		$ID = $jinput->getInt('id', 0);
		// set the targets
		$targets = ['adminview' => 'admin_view', 'customadminview' => 'custom_admin_view'];
		$t = ['adminview' => 'A', 'customadminview' => 'C'];
		// rest the options
		$options = [];
		// reset the custom admin views array
		$views = false;
		if (is_numeric($ID) && $ID >= 1)
		{
			// get the linked back-end views
			foreach ($targets as $target => $view)
			{
				if ($result = GetHelper::var('component_'.$view.'s', (int) $ID, 'joomla_component', 'add'.$view.'s'))
				{
					$views[$target] = $result;
				}
			}
		}
		else
		{
			// not linked so there is none available
			return [Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_LINK_AN_ADMIN_OR_A_CUSTOM_ADMIN_VIEW_TO_THIS_COMPONENT_THEN_YOU_CAN_SELECT_IT_HERE'))];
		}
		// check if we found any values
		if (ArrayHelper::check($views))
		{
			foreach ($targets as $target => $view)
			{
				if (isset($views[$target]) && JsonHelper::check($views[$target]))
				{
					// convert to an array
					$value = json_decode($views[$target], true);
					$type = StringHelper::safe($view, 'w');
					if (ArrayHelper::check($value))
					{
						foreach ($value as $_view)
						{
							if (isset($_view[$target]) && is_numeric($_view[$target]))
							{
								// set the view to the selections if found
								if ($name = GetHelper::var($view, (int) $_view[$target], 'id', 'system_name'))
								{
									$options[] = Html::_('select.option', $t[$target].'_'.$_view[$target], $name.'  ['.$type.']');
								}
							}
						}
					}
				}
			}
		}
		// return found options
		if (ArrayHelper::check($options))
		{
			array_unshift($options , Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_SELECT_AN_OPTION')));
			return $options;
		}
		// not linked so there is none available
		return [Html::_('select.option', '', Text::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_LINK_AN_ADMIN_OR_A_CUSTOM_ADMIN_VIEW_TO_THIS_COMPONENT_THEN_YOU_CAN_SELECT_IT_HERE'))];
	}
}
