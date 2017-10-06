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

	@version		2.5.6
	@build			6th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		api.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controller');

/**
 * Componentbuilder Api Controller
 */
class ComponentbuilderControllerApi extends JControllerForm
{
	/**
	 * Current or most recently performed task.
	 *
	 * @var    string
	 * @since  12.2
	 * @note   Replaces _task.
	 */
	protected $task;

	public function __construct($config = array())
	{
		$this->view_list = ''; // safeguard for setting the return view listing to the default site view.
		parent::__construct($config);
	}

			
        public function backup()
	{
		// get params
		if (!isset($this->params) || !ComponentbuilderHelper::checkObject($this->params))
		{
			$this->params = JComponentHelper::getParams('com_componentbuilder');
		}
		// get all component IDs to backup
		$pks = componentbuilderHelper::getComponentIDs();
		// Get the model
		$model = componentbuilderHelper::getModel('joomla_components', JPATH_ADMINISTRATOR . '/components/com_componentbuilder');
		// set user
		$model->user = $this->getApiUser();
		// make sure to set active type to backup
		$model->activeType = 'backup';
		// set auto loader
		ComponentbuilderHelper::autoLoader('smart');
		// manual backup message
		$backupNotice = array();
		// get the data to export
		if (ComponentbuilderHelper::checkArray($pks) && $model->getSmartExport($pks))
		{
			$backupNotice[] = JText::_('COM_COMPONENTBUILDER_BACKUP_WAS_DONE_SUCCESSFULLY');
			$backupNoticeStatus = 'Success';
			// set the key string
			if (componentbuilderHelper::checkString($model->key) && strlen($model->key) == 32)
			{
				$textNotice = array();
				$keyNotice = '<h1>' . JText::sprintf('COM_COMPONENTBUILDER_THE_PACKAGE_KEY_IS_CODESCODE', $model->key) . '</h1>';
				$textNotice[] = JText::sprintf('COM_COMPONENTBUILDER_THE_PACKAGE_KEY_IS_S', $model->key);
				$keyNotice .= JText::_('COM_COMPONENTBUILDER_YOUR_DATA_IS_ENCRYPTED_WITH_A_AES_ONE_HUNDRED_AND_TWENTY_EIGHT_BIT_ENCRYPTION_USING_THE_ABOVE_THIRTY_TWO_CHARACTER_KEY_WITHOUT_THIS_KEY_IT_WILL_TAKE_THE_CURRENT_TECHNOLOGY_WITH_A_BRUTE_FORCE_ATTACK_METHOD_MORE_THEN_A_HREFHTTPRANDOMIZECOMHOWLONGTOHACKPASS_TARGET_BLANK_TITLEHOW_LONG_TO_HACK_PASSSEVEN_HUNDRED_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZEROA_YEARS_TO_CRACK_THEORETICALLY_UNLESS_THEY_HAVE_THIS_KEY_ABOVE_SO_DO_KEEP_IT_SAFE') . '<br />';
				// set the package owner info
				if ((isset($model->info['getKeyFrom']['company']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['company'])) || (isset($model->info['getKeyFrom']['owner']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['owner'])))
				{
					$ownerDetails = '<h2>' . JText::_('COM_COMPONENTBUILDER_PACKAGE_OWNER_DETAILS') . '</h2>';
					$textNotice[] = '# ' . JText::_('COM_COMPONENTBUILDER_PACKAGE_OWNER_DETAILS');
					$ownerDetails .= '<ul>';
					if (isset($model->info['getKeyFrom']['company']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['company']))
					{
						$ownerDetails .= '<li>' . JText::sprintf('COM_COMPONENTBUILDER_EMCOMPANYEM_BSB', $model->info['getKeyFrom']['company']) . '</li>';
						$textNotice[] = '- ' . JText::sprintf('COM_COMPONENTBUILDER_COMPANY_S', $model->info['getKeyFrom']['company']);
					}
					// add value only if set
					if (isset($model->info['getKeyFrom']['owner']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['owner']))
					{
						$ownerDetails .= '<li>' . JText::sprintf('COM_COMPONENTBUILDER_EMOWNEREM_BSB', $model->info['getKeyFrom']['owner']) . '</li>';
						$textNotice[] = '- ' . JText::sprintf('COM_COMPONENTBUILDER_OWNER_S', $model->info['getKeyFrom']['owner']);
					}
					// add value only if set
					if (isset($model->info['getKeyFrom']['website']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['website']))
					{
						$ownerDetails .= '<li>' . JText::sprintf('COM_COMPONENTBUILDER_EMWEBSITEEM_BSB', $model->info['getKeyFrom']['website']) . '</li>';
						$textNotice[] = '- ' . JText::sprintf('COM_COMPONENTBUILDER_WEBSITE_S', $model->info['getKeyFrom']['website']);
					}
					// add value only if set
					if (isset($model->info['getKeyFrom']['email']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['email']))
					{
						$ownerDetails .= '<li>' . JText::sprintf('COM_COMPONENTBUILDER_EMEMAILEM_BSB', $model->info['getKeyFrom']['email']) . '</li>';
						$textNotice[] = '- ' . JText::sprintf('COM_COMPONENTBUILDER_EMAIL_S', $model->info['getKeyFrom']['email']);
					}
					// add value only if set
					if (isset($model->info['getKeyFrom']['license']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['license']))
					{
						$ownerDetails .= '<li>' . JText::sprintf('COM_COMPONENTBUILDER_EMLICENSEEM_BSB', $model->info['getKeyFrom']['license']) . '</li>';
						$textNotice[] = '- ' . JText::sprintf('COM_COMPONENTBUILDER_LICENSE_S', $model->info['getKeyFrom']['license']);
					}
					// add value only if set
					if (isset($model->info['getKeyFrom']['copyright']) && componentbuilderHelper::checkString($model->info['getKeyFrom']['copyright']))
					{
						$ownerDetails .= '<li>' . JText::sprintf('COM_COMPONENTBUILDER_EMCOPYRIGHTEM_BSB', $model->info['getKeyFrom']['copyright']) . '</li>';
						$textNotice[] = '- ' . JText::sprintf('COM_COMPONENTBUILDER_COPYRIGHT_S', $model->info['getKeyFrom']['copyright']);
					}							
					$ownerDetails .= '</ul>';
					$backupNotice[] = JText::_('COM_COMPONENTBUILDER_OWNER_DETAILS_WAS_SET');
				}
				else
				{
					$ownerDetails = '<h2>' . JText::_('COM_COMPONENTBUILDER_PACKAGE_OWNER_NOT_SET') . '</h2>';
					$textNotice[] = '# ' . JText::_('COM_COMPONENTBUILDER_PACKAGE_OWNER_DETAILS');
					$ownerDetails .= JText::_('COM_COMPONENTBUILDER_TO_CHANGE_THE_PACKAGE_OWNER_DEFAULTS_OPEN_THE_BJCB_GLOBAL_OPTIONSB_GO_TO_THE_BCOMPANYB_TAB_AND_ADD_THE_CORRECT_COMPANY_DETAILS_THERE') . '<br />';
					$textNotice[] = JText::_('COM_COMPONENTBUILDER_TO_CHANGE_THE_PACKAGE_OWNER_DEFAULTS_OPEN_THE_JCB_GLOBAL_OPTIONS_GO_TO_THE_COMPANY_TAB_AND_ADD_THE_CORRECT_COMPANY_DETAILS_THERE');
					$ownerDetails .= '<h3>' . JText::_('COM_COMPONENTBUILDER_YOU_SHOULD_ADD_THE_CORRECT_OWNER_DETAILS') . '</h3>';
					$textNotice[] = '## ' .  JText::_('COM_COMPONENTBUILDER_YOU_SHOULD_ADD_THE_CORRECT_OWNER_DETAILS');
					$ownerDetails .= JText::_('COM_COMPONENTBUILDER_SINCE_THE_OWNER_DETAILS_ARE_DISPLAYED_DURING_BIMPORT_PROCESSB_BEFORE_ADDING_THE_KEY_THIS_WAY_IF_THE_USERDEV_BDOES_NOTB_HAVE_THE_KEY_THEY_CAN_SEE_BWHERE_TO_GET_ITB') . '<br />';
					$textNotice[] = JText::_('COM_COMPONENTBUILDER_SINCE_THE_OWNER_DETAILS_ARE_DISPLAYED_DURING_IMPORT_PROCESS_BEFORE_ADDING_THE_KEY_THIS_WAY_IF_THE_USERDEV_DOES_NOT_HAVE_THE_KEY_THEY_CAN_SEE_WHERE_TO_GET_IT');
					$backupNotice[] = JText::_('COM_COMPONENTBUILDER_CHECK_YOUR_OWNER_DETAILS_IT_HAS_NOT_BEEN_SET_OPEN_THE_JCB_GLOBAL_OPTIONS_GO_TO_THE_COMPANY_TAB_AND_ADD_THE_CORRECT_COMPANY_DETAILS_THERE');
				}
			}
			else
			{
				$keyNotice = '<h1>' . JText::_('COM_COMPONENTBUILDER_THIS_PACKAGE_HAS_NO_KEY') . '</h1>';
				$textNotice[] = '# ' . JText::_('COM_COMPONENTBUILDER_THIS_PACKAGE_HAS_NO_KEY');
				$ownerDetails = JText::_('COM_COMPONENTBUILDER_THAT_MEANS_ANYONE_WHO_HAS_THIS_PACKAGE_CAN_INSTALL_IT_INTO_JCB_TO_ADD_AN_EXPORT_KEY_SIMPLY_OPEN_THE_COMPONENT_GO_TO_THE_TAB_CALLED_BSETTINGSB_BOTTOM_RIGHT_THERE_IS_A_FIELD_CALLED_BEXPORT_KEYB') . '<br />';
				$textNotice[] = JText::_('COM_COMPONENTBUILDER_THAT_MEANS_ANYONE_WHO_HAS_THIS_PACKAGE_CAN_INSTALL_IT_INTO_JCB_TO_ADD_AN_EXPORT_KEY_SIMPLY_OPEN_THE_COMPONENT_GO_TO_THE_TAB_CALLED_SETTINGS_BOTTOM_RIGHT_THERE_IS_A_FIELD_CALLED_EXPORT_KEY');
				$backupNotice[] = JText::_('COM_COMPONENTBUILDER_NO_KEYS_WERE_FOUND_TO_ADD_AN_EXPORT_KEY_SIMPLY_OPEN_THE_COMPONENT_GO_TO_THE_TAB_CALLED_SETTINGS_BOTTOM_RIGHT_THERE_IS_A_FIELD_CALLED_EXPORT_KEY');
			}
			// get email
			if ($email = $this->params->get('backup_email', null))
			{
				// plain text
				$plainText = implode("\n", $textNotice);
				// set hash to track changes
				$hashTracker = md5($plainText);
				if (ComponentbuilderHelper::newHash($hashTracker))
				{
					// Build final massage.
					$message = $keyNotice . $ownerDetails . '<br /><small>HASH: ' . $hashTracker . '</small>';
					// set the subject
					$subject = JText::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_BUILDER_BACKUP_KEY');
					// email the message
					componentbuilderEmail::send($email, $subject, componentbuilderEmail::setTableBody($message, $subject), $plainText, 1);
					$backupNotice[] = JText::_('COM_COMPONENTBUILDER_EMAIL_WITH_THE_NEW_KEY_WAS_SEND');
				}
				else
				{
					$backupNotice[] = JText::_('COM_COMPONENTBUILDER_KEY_HAS_NOT_CHANGED');
				}
			}
		}
		else
		{
			$backupNotice[] = JText::_('COM_COMPONENTBUILDER_BACKUP_FAILED_PLEASE_TRY_AGAIN_IF_THE_ERROR_CONTINUE_PLEASE_CONTACT_YOUR_SYSTEM_ADMINISTRATOR');
			$backupNoticeStatus = 'Error';
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
		// quite only if auto backup (adding this script from custom code :)
		if ('backup' === 'backup')
		{
			echo "# " . $backupNoticeStatus . "\n" .implode("\n", $backupNotice);
			jexit();
		}
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), implode("<br />", $backupNotice), $backupNoticeStatus);
		return;
	}			

	protected function getApiUser()
	{
		// return user object
		return JFactory::getUser($this->params->get('api', 0, 'INT'));
	}

	/**
	 * Method to check if you can edit an existing record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key; default is id.
	 *
	 * @return  boolean
	 *
	 * @since   12.2
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// to insure no other tampering
		return false;
	}

        /**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		// to insure no other tampering
		return false;
	}

	/**
	 * Method to check if you can save a new or existing record.
	 *
	 * Extended classes can override this if necessary.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   12.2
	 */
	protected function allowSave($data, $key = 'id')
	{
		// to insure no other tampering
		return false;
	}

	/**
	 * Function that allows child controller access to model data
	 * after the data has been saved.
	 *
	 * @param   JModelLegacy  $model      The data model object.
	 * @param   array         $validData  The validated data.
	 *
	 * @return  void
	 *
	 * @since   12.2
	 */
	protected function postSaveHook(JModelLegacy $model, $validData = array())
	{
	}
}
