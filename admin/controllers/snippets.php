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

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		snippets.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');

/**
 * Snippets Controller
 */
class ComponentbuilderControllerSnippets extends JControllerAdmin
{
	protected $text_prefix = 'COM_COMPONENTBUILDER_SNIPPETS';
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'Snippet', $prefix = 'ComponentbuilderModel', $config = array())
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
		if ($user->authorise('snippet.export', 'com_componentbuilder') && $user->authorise('core.export', 'com_componentbuilder'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			JArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Snippets');
			// get the data to export
			$data = $model->getExportData($pks);
			if (ComponentbuilderHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				ComponentbuilderHelper::xls($data,'Snippets_'.$date->format('jS_F_Y'),'Snippets exported ('.$date->format('jS F, Y').')','snippets');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=snippets', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('snippet.import', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
		{
			// Get the import model
			$model = $this->getModel('Snippets');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (ComponentbuilderHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('snippet_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'snippets');
				$session->set('dataType_VDM_IMPORTINTO', 'snippet');
				// Redirect to import view.
				$message = JText::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_FOR_SNIPPETS');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=snippets', false), $message, 'error');
		return;
	}  

	public function getSnippets()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// redirect to the import snippets custom admin view
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=get_snippets', false));
		return;
	}

	public function shareSnippets()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// Get the model
		$model = $this->getModel('snippets');
		// check if import is allowed for this user.
		$model->user = JFactory::getUser();
		if ($model->user->authorise('snippet.import', 'com_componentbuilder') && $model->user->authorise('core.export', 'com_componentbuilder'))
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
				$message = JText::_('COM_COMPONENTBUILDER_NO_SNIPPETS_WERE_SELECTED_PLEASE_MAKE_A_SELECTION_AND_TRY_AGAIN');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=snippets', false), $message, 'error');
				return;
			}
			// set auto loader
			ComponentbuilderHelper::autoLoader('smart');
			// get the data to export
			if ($model->shareSnippets($pks))
			{
				// Message of successful build
				if (count($pks) > 1)
				{
					$message = '<h1>' . JText::_('COM_COMPONENTBUILDER_THE_SNIPPETS_WERE_SUCCESSFULLY_EXPORTED') . '</h1>';
					$message .= '<p>' . JText::sprintf('COM_COMPONENTBUILDER_TO_SHARE_THESE_SNIPPETS_WITH_THE_REST_OF_THE_JCB_COMMUNITY');
				}
				else
				{
					$message = '<h1>' . JText::_('COM_COMPONENTBUILDER_THE_SNIPPET_WAS_SUCCESSFULLY_EXPORTED') . '</h1>';
					$message .= '<p>' . JText::sprintf('COM_COMPONENTBUILDER_TO_SHARE_THIS_SNIPPET_WITH_THE_REST_OF_THE_JCB_COMMUNITY');
				}
				$message .= JText::sprintf('COM_COMPONENTBUILDER_YOU_WILL_NEED_TO_KNOW_HOW_S_WORKS_BASIC_YOU_WILL_ALSO_NEED_A_S_ACCOUNT_AND_KNOW_HOW_TO_MAKE_A_PULL_REQUEST_ON_GITHUB', 
					'<a href="https://try.github.io" target="_blank">git</a>',
					'<a href="https://github.com/join" target="_blank">github.com</a>') . '</p>';

				$message .= '<h2>' . JText::_('COM_COMPONENTBUILDER_NEED_HELP') . '</h2>';
				$message .= '<ul>';
				$message .= '<li>'.JText::sprintf('COM_COMPONENTBUILDER_GENERAL_OVERVIEW_OF_HOW_THINGS_WORK_BSB', '<a href="https://www.youtube.com/watch?v=qr4I1jeCp7I&list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank">https://youtu.be/qr4I1jeCp7I</a>').'</li>';
				$message .= '<li>'.JText::sprintf('COM_COMPONENTBUILDER_BASIC_TUTORIAL_ON_GIT_BSB', '<a href="https://www.udemy.com/git-quick-start/" target="_blank">https://www.udemy.com/git-quick-start/</a>').'</li>';
				$message .= '<li>'.JText::sprintf('COM_COMPONENTBUILDER_GET_AN_ACCOUNT_WITH_GITHUB_BSB', '<a href="https://github.com/join" target="_blank">https://github.com/join</a>').'</li>';
				$message .= '<li>'.JText::sprintf('COM_COMPONENTBUILDER_TUTORIAL_ON_FORKING_JCB_SNIPPETS_BSB', '<a href="https://www.youtube.com/watch?v=0hgHeQVTLOk&list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank">https://youtu.be/0hgHeQVTLOk</a>').'</li>';
				$message .= '<li>'.JText::sprintf('COM_COMPONENTBUILDER_TUTORIAL_ON_MAKING_A_PULL_REQUEST_BSB', '<a href="https://www.youtube.com/watch?v=vQ-yxVtc-Co&list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank">https://youtu.be/vQ-yxVtc-Co</a>').'</li>';
				$message .= '<li>'.JText::sprintf('COM_COMPONENTBUILDER_REPORT_AN_ISSUE_BSB', '<a href="https://github.com/vdm-io/Joomla-Component-Builder-Snippets/issues" target="_blank">https://github.com/vdm-io/Joomla-Component-Builder-Snippets/issues</a>').'</li>';
				$message .= '</ul>';
				$message .= '<h2>' . JText::_('COM_COMPONENTBUILDER_ZIPPED_FILE_LOCATION') . '</h2>';
				$message .= '<p>' . JText::sprintf('COM_COMPONENTBUILDER_PATH_CODESCODE', $model->zipPath). '</p>';
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=snippets', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_SHARE_THE_SNIPPETS_PLEASE_CONTACT_YOUR_SYSTEM_ADMINISTRATOR_FOR_MORE_HELP');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=snippets', false), $message, 'error');
		return;
	}  
}
