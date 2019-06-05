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

/**
 * Joomla_components Controller
 */
class ComponentbuilderControllerJoomla_components extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_COMPONENTS';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Joomla_component', $prefix = 'ComponentbuilderModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
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


	/**
	 * Run the Expansion
	 *
	 * @return  void
	 */
	public function runExpansion()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false);
		// set massage
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_EXPANSION_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('joomla_components.run_expansion', 'com_componentbuilder'))
		{
			// set massage
			$message = JText::_('COM_COMPONENTBUILDER_EXPANSION_FAILED_PLEASE_CHECK_YOUR_SETTINGS_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_DEVELOPMENT_METHOD_TAB');
			// run expansion via API
			$result = ComponentbuilderHelper::getFileContents(JURI::root() . 'index.php?option=com_componentbuilder&task=api.expand');
			// is there a message returned
			if (!is_numeric($result) && ComponentbuilderHelper::checkString($result))
			{
				$this->setRedirect($redirect_url, $result);
				return true;
			}
			elseif (is_numeric($result) && 1 == $result)
			{
				$message = JText::_('COM_COMPONENTBUILDER_BTHE_EXPANSION_WAS_SUCCESSFULLYB_TO_SEE_MORE_INFORMATION_CHANGE_THE_BRETURN_OPTIONS_FOR_BUILDB_TO_BDISPLAY_MESSAGEB_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_DEVELOPMENT_METHOD_TABB');
				$this->setRedirect($redirect_url, $message, 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}


	/**
	 * Clear tmp folder
	 *
	 * @return  true on success
	 */
	public function clearTmp()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false);
		$message = JText::_('COM_COMPONENTBUILDER_COULD_NOT_CLEAR_THE_TMP_FOLDER');
		if($user->authorise('joomla_components.clear_tmp', 'com_componentbuilder') && $user->authorise('core.options', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('compiler');
			// get tmp folder
			$comConfig = JFactory::getConfig();
			$tmp = $comConfig->get('tmp_path');
			if ($model->emptyFolder($tmp))
			{
				$message = JText::_('COM_COMPONENTBUILDER_BTHE_TMP_FOLDER_HAS_BEEN_CLEAR_SUCCESSFULLYB');
				$this->setRedirect($redirect_url, $message, 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	public function smartImport()
	{
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('joomla_component.import_jcb_packages', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
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
		// Get the model
		$model = $this->getModel('Joomla_components');
		// check if export is allowed for this user.
		$model->user = JFactory::getUser();
		if ($model->user->authorise('joomla_component.export_jcb_packages', 'com_componentbuilder') && $model->user->authorise('core.export', 'com_componentbuilder'))
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
			// set auto loader
			ComponentbuilderHelper::autoLoader('smart');
			// get the data to export
			if ($model->getSmartExport($pks))
			{
				// set the key string
				if (componentbuilderHelper::checkString($model->key) && strlen($model->key) == 32)
				{
					$keyNotice = '<h1>' . JText::sprintf('COM_COMPONENTBUILDER_THE_PACKAGE_KEY_IS_CODESCODE', $model->key) . '</h1>';
					$keyNotice .= '<p>' . JText::_('COM_COMPONENTBUILDER_YOUR_DATA_IS_ENCRYPTED_WITH_A_AES_ONE_HUNDRED_AND_TWENTY_EIGHT_BIT_ENCRYPTION_USING_THE_ABOVE_THIRTY_TWO_CHARACTER_KEYBR_WITHOUT_THIS_KEY_IT_WILL_TAKE_THE_CURRENT_TECHNOLOGY_WITH_A_BRUTE_FORCE_ATTACK_METHOD_MORE_THEN_A_HREFHTTPRANDOMIZECOMHOWLONGTOHACKPASS_TARGET_BLANK_TITLEHOW_LONG_TO_HACK_PASSSEVEN_HUNDRED_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZERO_ZEROA_YEARS_TO_CRACK_THEORETICALLY') . '</h1>';
					// set the package owner info
					if (componentbuilderHelper::getPackageOwnerValue('owner', $model->info) || componentbuilderHelper::getPackageOwnerValue('company', $model->info))
					{
						$ownerDetails = componentbuilderHelper::getPackageOwnerDetailsDisplay($model->info, true);
					}
					else
					{
						$ownerDetails = '<h2>' . JText::_('COM_COMPONENTBUILDER_PACKAGE_OWNER_NOT_SET') . '</h2>';
						$ownerDetails .= '<p>' . JText::_('COM_COMPONENTBUILDER_TO_CHANGE_THE_PACKAGE_OWNER_DEFAULTS_OPEN_THE_BJCB_GLOBAL_OPTIONSB_GO_TO_THE_BCOMPANYB_TAB_AND_ADD_THE_CORRECT_COMPANY_DETAILS_THERE') . '</p>';
						$ownerDetails .= '<h3>' . JText::_('COM_COMPONENTBUILDER_YOU_SHOULD_ADD_THE_CORRECT_OWNER_DETAILS') . '</h3>';
						$ownerDetails .= '<p>' . JText::_('COM_COMPONENTBUILDER_SINCE_THE_OWNER_DETAILS_ARE_DISPLAYED_DURING_BIMPORT_PROCESSB_BEFORE_ADDING_THE_KEY_THIS_WAY_IF_THE_USERDEV_BDOES_NOTB_HAVE_THE_KEY_THEY_CAN_SEE_BWHERE_TO_GET_ITB') . '</p>';
					}
				}
				else
				{
					$keyNotice = '<h1>' . JText::_('COM_COMPONENTBUILDER_THIS_PACKAGE_HAS_NO_KEY') . '</h1>';
					$ownerDetails = '<p>' . JText::_('COM_COMPONENTBUILDER_THAT_MEANS_ANYONE_WHO_HAS_THIS_PACKAGE_CAN_INSTALL_IT_INTO_JCB_TO_ADD_AN_EXPORT_KEY_SIMPLY_OPEN_THE_COMPONENT_GO_TO_THE_TAB_CALLED_BSETTINGSB_BOTTOM_RIGHT_THERE_IS_A_FIELD_CALLED_BEXPORT_KEYB') . '</p>';
				}
				// Redirect to the list screen with success.
				$message = array();
				$message[] = '<h1>' . JText::_('COM_COMPONENTBUILDER_EXPORT_COMPLETED') . '</h1>';
				$message[] = '<p>' . JText::sprintf('COM_COMPONENTBUILDER_PATH_TO_THE_ZIPPED_PACKAGE_IS_CODESCODE_BR_S_S', $model->zipPath, $keyNotice, $ownerDetails) . '</p>';
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

	public function backup()
	{
		// get params first
		if (!isset($this->params) || !ComponentbuilderHelper::checkObject($this->params))
		{
			$this->params = JComponentHelper::getParams('com_componentbuilder');
		}
		// Get the model
		$model = componentbuilderHelper::getModel('joomla_components', JPATH_ADMINISTRATOR . '/components/com_componentbuilder');
		// set user
		$model->user = $this->getApiUser();
		// make sure to set active type (adding this script from custom code :)
		$model->activeType = 'manualBackup';
		// check if export is allowed for this user. (we need this sorry)
		if ($model->user->authorise('joomla_component.export_jcb_packages', 'com_componentbuilder') && $model->user->authorise('core.export', 'com_componentbuilder'))
		{
			// get all component IDs to backup
			$pks = componentbuilderHelper::getComponentIDs();
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
			if ('backup' === $model->activeType)
			{
				echo "# " . $backupNoticeStatus . "\n" .implode("\n", $backupNotice);
				// clear session
				JFactory::getApplication()->getSession()->destroy();
				jexit();
			}
			$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), implode("<br />", $backupNotice), $backupNoticeStatus);
			return;
		}
		// quite only if auto backup (adding this script from custom code :)
		if ('backup' === $model->activeType)
		{
			echo "# Error\n" . JText::_('COM_COMPONENTBUILDER_ACCESS_DENIED');
			// clear session
			JFactory::getApplication()->getSession()->destroy();
			jexit();
		}
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), JText::_('COM_COMPONENTBUILDER_ACCESS_DENIED'), 'Error');
		return;
	}

	public function cloner()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// Get the model
		$model = $this->getModel('Joomla_components');
		// check if export is allowed for this user.
		$model->user = JFactory::getUser();
		if ($model->user->authorise('joomla_component.clone', 'com_componentbuilder') && $model->user->authorise('core.copy', 'com_componentbuilder'))
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
				$message = JText::_('COM_COMPONENTBUILDER_NO_COMPONENT_WAS_SELECTED_PLEASE_MAKE_A_SELECTION_OF_ONE_COMPONENT_AND_TRY_AGAIN');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
				return;
			}
			// only one component allowed at this time
			elseif (count( (array) $pks) !== 1)
			{
				// Redirect to the list screen with error.
				$message = JText::_('COM_COMPONENTBUILDER_ONLY_ONE_COMPONENT_CAN_BE_CLONED_AT_A_TIME_PLEASE_SELECT_ONE_AND_TRY_AGAIN');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
				return;
			}
			// set the active type
			$model->activeType = 'clone';
			// clone the component and the views and the fields... everything linked to the component.
			if ($model->cloner($pks))
			{
				// clone was successful
				$message = JText::_('COM_COMPONENTBUILDER_THE_COMPONENT_WITH_ALL_LINKED_ADMIN_VIEWS_FIELDS_LINKED_TO_ADMIN_VIEWS_CUSTOM_ADMIN_VIEWS_SITE_VIEWS_TEMPLATES_AND_LAYOUTS_WERE_CLONED_SUCCESSFUL');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message);
				return;
			}
			// Redirect to the list screen with error.
			$message = JText::_('COM_COMPONENTBUILDER_CLONE_FAILED');
			$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
			return;
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_CLONE_A_COMPONENT_PLEASE_CONTACT_YOUR_SYSTEM_ADMINISTRATOR_FOR_MORE_HELP');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}

	protected function getApiUser()
	{
		// admin area does not have API user, only front-end (so we fallback on login user)
		return JFactory::getUser();
	}
}
