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

	@version		2.6.0
	@build			1st November, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		componentadminviews.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
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
			// only add if user allowed to create admin_view
			if ($user->authorise('admin_view.create', 'com_componentbuilder') && $app->isAdmin()) // TODO for now only in admin area.
			{
				// build Create button
				$buttonNamee = trim($buttonName);
				$buttonNamee = preg_replace('/_+/', ' ', $buttonNamee);
				$buttonNamee = preg_replace('/\s+/', ' ', $buttonNamee);
				$buttonNamee = preg_replace("/[^A-Za-z ]/", '', $buttonNamee);
				$buttonNamee = ucfirst(strtolower($buttonNamee));
				$button[] = '<a id="'.$buttonName.'Create" class="btn btn-small btn-success hasTooltip" title="'.JText::sprintf('COM_COMPONENTBUILDER_CREATE_NEW_S', $buttonNamee).'" style="border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;"
					href="index.php?option=com_componentbuilder&amp;view=admin_view&amp;layout=edit'.$ref.'" >
					<span class="icon-new icon-white"></span></a>';
			}
			// only add if user allowed to edit admin_view
			if (($buttonName === 'admin_view' || $buttonName === 'admin_views') && $user->authorise('admin_view.edit', 'com_componentbuilder') && $app->isAdmin()) // TODO for now only in admin area.
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
							var url = 'index.php?option=com_componentbuilder&view=admin_views&task=admin_view.edit&id='+value+'".$refJ."';
							jQuery('#".$buttonName."Edit').attr('href', url);
						} else {
							// show the create button
							jQuery('#".$buttonName."Create').show();
							// hide edit button
							jQuery('#".$buttonName."Edit').hide();
						}
					}";
			}
			// check if button was created for admin_view field.
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
