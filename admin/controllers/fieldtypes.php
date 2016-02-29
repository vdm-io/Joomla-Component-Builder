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

	@version		2.1.0
	@build			29th February, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		fieldtypes.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Fieldtypes Controller
 */
class ComponentbuilderControllerFieldtypes extends JControllerAdmin
{
	protected $text_prefix = 'COM_COMPONENTBUILDER_FIELDTYPES';
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'Fieldtype', $prefix = 'ComponentbuilderModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		
		return $model;
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('fieldtype.export', 'com_componentbuilder') && $user->authorise('core.export', 'com_componentbuilder'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Fieldtypes');
			// get the data to export
			$data = $model->getExportData($pks);
			if (ComponentbuilderHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				ComponentbuilderHelper::xls($data,'Fieldtypes_'.$date->format('jS_F_Y'),'Fieldtypes exported ('.$date->format('jS F, Y').')','fieldtypes');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=fieldtypes', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('fieldtype.import', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
		{
			// Get the import model
			$model = $this->getModel('Fieldtypes');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (ComponentbuilderHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('fieldtype_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'fieldtypes');
				$session->set('dataType_VDM_IMPORTINTO', 'fieldtype');
				// Redirect to import view.
				$message = JText::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_FOR_FIELDTYPES');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=fieldtypes', false), $message, 'error');
		return;
	} 
}
