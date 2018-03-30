<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		dynamicdashboard.php
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

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
	 * Override to add new button
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   3.2
	 */
	protected function getInput()
	{
		// see if we should add buttons
		$setButton = $this->getAttribute('button');
		// get html
		$html = parent::getInput();
		// if true set button
		if ($setButton === 'true')
		{
			$button = array();
			$script = array();
			$buttonName = $this->getAttribute('name');
			// get the input from url
			$app = JFactory::getApplication();
			$jinput = $app->input;
			// get the view name & id
			$values = $jinput->getArray(array(
				'id' => 'int',
				'view' => 'word'
			));
			// check if new item
			$ref = '';
			$refJ = '';
			if (!is_null($values['id']) && strlen($values['view']))
			{
				// only load referal if not new item.
				$ref = '&amp;ref=' . $values['view'] . '&amp;refid=' . $values['id'];
				$refJ = '&ref=' . $values['view'] . '&refid=' . $values['id'];
			}
			$user = JFactory::getUser();
			// only add if user allowed to create custom_admin_view
			if ($user->authorise('core.create', 'com_componentbuilder') && $app->isAdmin()) // TODO for now only in admin area.
			{
				// build Create button
				$buttonNamee = trim($buttonName);
				$buttonNamee = preg_replace('/_+/', ' ', $buttonNamee);
				$buttonNamee = preg_replace('/\s+/', ' ', $buttonNamee);
				$buttonNamee = preg_replace("/[^A-Za-z ]/", '', $buttonNamee);
				$buttonNamee = ucfirst(strtolower($buttonNamee));
				$button[] = '<a id="'.$buttonName.'Create" class="btn btn-small btn-success hasTooltip" title="'.JText::sprintf('COM_COMPONENTBUILDER_CREATE_NEW_S', $buttonNamee).'" style="border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;"
					href="index.php?option=com_componentbuilder&amp;view=custom_admin_view&amp;layout=edit'.$ref.'" >
					<span class="icon-new icon-white"></span></a>';
			}
			// only add if user allowed to edit custom_admin_view
			if (($buttonName === 'custom_admin_view' || $buttonName === 'custom_admin_views')  && $user->authorise('core.edit', 'com_componentbuilder') && $app->isAdmin()) // TODO for now only in admin area.
			{
				// build edit button
				$buttonNamee = trim($buttonName);
				$buttonNamee = preg_replace('/_+/', ' ', $buttonNamee);
				$buttonNamee = preg_replace('/\s+/', ' ', $buttonNamee);
				$buttonNamee = preg_replace("/[^A-Za-z ]/", '', $buttonNamee);
				$buttonNamee = ucfirst(strtolower($buttonNamee));
				$button[] = '<a id="'.$buttonName.'Edit" class="btn btn-small hasTooltip" title="'.JText::sprintf('COM_COMPONENTBUILDER_EDIT_S', $buttonNamee).'" style="display: none; padding: 4px 4px 4px 7px;" href="#" >
					<span class="icon-edit"></span></a>';
				// build script
				$script[] = "
					jQuery(document).ready(function() {
						jQuery('#adminForm').on('change', '#jform_".$buttonName."',function (e) {
							e.preventDefault();
							var ".$buttonName."Value = jQuery('#jform_".$buttonName."').val();
							".$buttonName."Button(".$buttonName."Value);
						});
						var ".$buttonName."Value = jQuery('#jform_".$buttonName."').val();
						".$buttonName."Button(".$buttonName."Value);
					});
					function ".$buttonName."Button(value) {
						if (value > 0) {
							// hide the create button
							jQuery('#".$buttonName."Create').hide();
							// show edit button
							jQuery('#".$buttonName."Edit').show();
							var url = 'index.php?option=com_componentbuilder&view=custom_admin_views&task=custom_admin_view.edit&id='+value+'".$refJ."';
							jQuery('#".$buttonName."Edit').attr('href', url);
						} else {
							// show the create button
							jQuery('#".$buttonName."Create').show();
							// hide edit button
							jQuery('#".$buttonName."Edit').hide();
						}
					}";
			}
			// check if button was created for custom_admin_view field.
			if (is_array($button) && count($button) > 0)
			{
				// Load the needed script.
				$document = JFactory::getDocument();
				$document->addScriptDeclaration(implode(' ',$script));
				// return the button attached to input field.
				return '<div class="input-append">' .$html . implode('',$button).'</div>';
			}
		}
		return $html;
	}

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	public function getOptions()
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
