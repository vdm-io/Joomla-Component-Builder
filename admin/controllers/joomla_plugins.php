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
 * Joomla_plugins Controller
 */
class ComponentbuilderControllerJoomla_plugins extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_PLUGINS';

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
	public function getModel($name = 'Joomla_plugin', $prefix = 'ComponentbuilderModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
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
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=joomla_plugins', false);
		// set massage
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_EXPANSION_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('joomla_plugins.run_expansion', 'com_componentbuilder'))
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
	 * get Boilerplate
	 *
	 * @return  boolean
	 */
	public function getBoilerplate()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=joomla_plugins', false);
		// set massage
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_GET_BOILERPLATE_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('joomla_plugin.get_boilerplate', 'com_componentbuilder'))
		{
			// set massage
			$message = JText::_('COM_COMPONENTBUILDER_GETTING_JOOMLA_PLUGIN_BOILERPLATE_FAILED_IF_THE_ISSUE_CONTINUES_INFORM_YOUR_SYSTEM_ADMINISTRATOR');
			// Get the model
			$model = $this->getModel('joomla_plugins');
			// check if there is any selections
			if (!$model->getBoilerplate())
			{
				$message = '<b>' . JText::_('COM_COMPONENTBUILDER_GETTING_JOOMLA_PLUGIN_BOILERPLATE_WAS_SUCCESSFULLY') . '</b>';
				$this->setRedirect($redirect_url, $message, 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	public function openClassMethods()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// redirect to the libraries
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=class_methods', false));
		return;
	}

	public function openClassProperties()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// redirect to the libraries
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=class_properties', false));
		return;
	}
}
