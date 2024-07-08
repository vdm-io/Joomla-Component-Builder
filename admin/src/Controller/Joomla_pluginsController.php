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
namespace VDM\Component\Componentbuilder\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\StringHelper;
use Joomla\CMS\Uri\Uri;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_plugins Admin Controller
 *
 * @since  1.6
 */
class Joomla_pluginsController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_PLUGINS';

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  \Joomla\CMS\MVC\Model\BaseDatabaseModel
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Joomla_plugin', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}


	/**
	 * Runs the expansion module.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It checks whether the current user has the necessary permissions to run the expansion module.
	 * 3. If the user is authorized, it attempts to run the expansion via an API call.
	 * 4. Depending on the result of the expansion operation, it sets the appropriate success or error message.
	 * 5. It redirects the user to a specified URL with the result message and status.
	 *
	 * @return bool True on successful expansion, false on failure.
	 */
	public function runExpansion()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = Factory::getUser();

		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_plugins', false);

		// set massage
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_EXPANSION_MODULE');

		// check if this user has the right to run expansion
		if($user->authorise('joomla_plugins.run_expansion', 'com_componentbuilder'))
		{
			// set massage
			$message = Text::_('COM_COMPONENTBUILDER_EXPANSION_FAILED_PLEASE_CHECK_YOUR_SETTINGS_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_DEVELOPMENT_METHOD_TAB');

			// run expansion via API
			$result = ComponentbuilderHelper::getFileContents(Uri::root() . 'index.php?option=com_componentbuilder&task=api.expand');

			// is there a message returned
			if (!is_numeric($result) && StringHelper::check($result))
			{
				$this->setRedirect($redirect_url, $result);
				return true;
			}
			elseif (is_numeric($result) && 1 == $result)
			{
				$message = Text::_('COM_COMPONENTBUILDER_BTHE_EXPANSION_WAS_SUCCESSFULLYB_TO_SEE_MORE_INFORMATION_CHANGE_THE_BRETURN_OPTIONS_FOR_BUILDB_TO_BDISPLAY_MESSAGEB_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_DEVELOPMENT_METHOD_TABB');
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
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_plugins', false);
		// set massage
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_GET_BOILERPLATE_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('joomla_plugin.get_boilerplate', 'com_componentbuilder'))
		{
			// set massage
			$message = Text::_('COM_COMPONENTBUILDER_GETTING_JOOMLA_PLUGIN_BOILERPLATE_FAILED_IF_THE_ISSUE_CONTINUES_INFORM_YOUR_SYSTEM_ADMINISTRATOR');
			// Get the model
			$model = $this->getModel('joomla_plugins');
			// check if there is any selections
			if (!$model->getBoilerplate())
			{
				$message = '<b>' . Text::_('COM_COMPONENTBUILDER_GETTING_JOOMLA_PLUGIN_BOILERPLATE_WAS_SUCCESSFULLY') . '</b>';
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
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// redirect to the libraries
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=class_methods', false));
		return;
	}

	public function openClassProperties()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// redirect to the libraries
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=class_properties', false));
		return;
	}
}