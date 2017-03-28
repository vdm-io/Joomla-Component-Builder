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

	@version		@update number 214 of this MVC
	@build			28th March, 2017
	@created		6th May, 2015
	@package		Component Builder
	@subpackage		joomla_components.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Joomla_components Controller
 */
class ComponentbuilderControllerJoomla_components extends JControllerAdmin
{
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_COMPONENTS';
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'Joomla_component', $prefix = 'ComponentbuilderModel', $config = array())
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
		if ($user->authorise('joomla_component.export', 'com_componentbuilder') && $user->authorise('core.export', 'com_componentbuilder'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Joomla_components');
			// get the data to export
			$data = $model->getExportData($pks);
			if (ComponentbuilderHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				ComponentbuilderHelper::xls($data,'Joomla_components_'.$date->format('jS_F_Y'),'Joomla components exported ('.$date->format('jS F, Y').')','joomla components');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('joomla_component.import', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
		{
			// Get the import model
			$model = $this->getModel('Joomla_components');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (ComponentbuilderHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('joomla_component_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'joomla_components');
				$session->set('dataType_VDM_IMPORTINTO', 'joomla_component');
				// Redirect to import view.
				$message = JText::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_FOR_JOOMLA_COMPONENTS');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=import_joomla_components', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}  

	public function smartImport()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('joomla_component.import', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
		{
			$session = JFactory::getSession();
			$session->set('backto_VDM_IMPORT', 'joomla_components');
			$session->set('dataType_VDM_IMPORTINTO', 'smart_package');
			// Redirect to import view.
			$message = JText::_('COM_COMPONENTBUILDER_YOU_CAN_NOW_SELECT_THE_COMPONENT_BZIPB_PACKAGE_YOU_WOULD_LIKE_TO_IMPORTBR_SMALLPLEASE_NOTE_THAT_SMART_COMPONENT_IMPORT_ONLY_WORKS_WITH_THE_FOLLOWING_FORMAT_BZIPBSMALL');
			$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=import_joomla_components&target=smartPackage', false), $message);
			return;
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_IMPORT_A_COMPONENT_PLEASE_CONTACT_YOUR_SYSTEM_ADMINISTRATOR_FOR_MORE_HELP');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}  

        public function smartExport()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('joomla_component.export', 'com_componentbuilder') && $user->authorise('core.export', 'com_componentbuilder'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// check if there is any selections
			if (!ComponentbuilderHelper::checkArray($pks))
			{
				// Redirect to the list screen with error.
				$message = JText::_('COM_COMPONENTBUILDER_NO_COMPONENTS_WERE_SELECTED_PLEASE_MAKE_A_SELECTION_AND_TRY_AGAIN');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
				return;
			}
			// Get the model
			$model = $this->getModel('Joomla_components');
			// set auto loader
			ComponentbuilderHelper::autoLoader('smart');
			// get the data to export
			if ($model->getSmartExport($pks))
			{
				// set the key string
				if (componentbuilderHelper::checkString($model->key) && strlen($model->key) == 32)
				{
					$keyNotice = '<h1>' . JText::sprintf('COM_COMPONENTBUILDER_THE_PACKAGE_KEY_IS_CODESCODE', $model->key) . '</h1>';
				}
				else
				{
					$keyNotice = '<h1>' . JText::_('COM_COMPONENTBUILDER_THIS_PACKAGE_HAS_NO_KEY') . '</h1>';
				}
				// Redirect to the list screen with success.
				$message = array();
				$message[] = '<h1>' . JText::_('COM_COMPONENTBUILDER_EXPORT_COMPLETED') . '</h1>';
				$message[] = '<p>' . JText::sprintf('COM_COMPONENTBUILDER_PATH_TO_THE_ZIPPED_PACKAGE_IS_CODESCODE_BR_S', $model->zipPath, $keyNotice) . '</p>';
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), implode('', $message), 'Success');
				return;
			}
			else
			{
				if (componentbuilderHelper::checkString($model->packagePath))
				{
					// clear all if not successful
					ComponentbuilderHelper::removeFolder($model->packagePath);
				}
				if (componentbuilderHelper::checkString($model->zipPath))
				{
					// clear all if not successful
					JFile::delete($model->zipPath);
				}				
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_EXPORT_FAILED_PLEASE_TRY_AGAIN_LATTER');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}
}
