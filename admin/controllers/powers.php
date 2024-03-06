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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Power\Factory as PowerFactory;

/**
 * Powers Admin Controller
 */
class ComponentbuilderControllerPowers extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_POWERS';

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
	public function getModel($name = 'Power', $prefix = 'ComponentbuilderModel', $config = array('ignore_request' => true))
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
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = \JRoute::_('index.php?option=com_componentbuilder&view=powers', false);
		// set massage
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_EXPANSION_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('powers.run_expansion', 'com_componentbuilder'))
		{
			// set massage
			$message = Text::_('COM_COMPONENTBUILDER_EXPANSION_FAILED_PLEASE_CHECK_YOUR_SETTINGS_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_DEVELOPMENT_METHOD_TAB');
			// run expansion via API
			$result = ComponentbuilderHelper::getFileContents(\JUri::root() . 'index.php?option=com_componentbuilder&task=api.expand');
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

	public function initPowers()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = Factory::getUser();

		// set default error message
		$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PERMISSION_DENIED') . '</h1>';
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INITIALIZE_POWERS') . '</p>';
		$status = 'error';
		$success = false;

		if($user->authorise('power.init', 'com_componentbuilder'))
		{
			if (PowerFactory::_('Superpower')->init())
			{
				// set success message
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_SUCCESSFULLY_INITIALIZED_ALL_REMOTE_POWERS') . '</h1>';
				$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_LOCAL_DATABASE_POWERS_HAS_SUCCESSFULLY_BEEN_SYNCED_WITH_THE_REMOTE_REPOSITORIES') . '</p>';

				$status = 'success';
				$success = true;
			}
			else
			{
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_INITIALIZATION_FAILED') . '</h1>';
				$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_INITIALIZATION_OF_THIS_POWERS_HAS_FAILED') . '</p>';
			}
		}

		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=powers', $success);
		$this->setRedirect($redirect_url, $message, $status);

		return $success;
	}

	public function resetPowers()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// get IDS of the selected powers
		$pks = $this->input->post->get('cid', [], 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);

		// check if there is any selections
		if ($pks == [])
		{
			// set error message
			$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_NO_SELECTION_DETECTED').'</h1>';
			$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_PLEASE_FIRST_MAKE_A_SELECTION_FROM_THE_LIST').'</p>';
			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=powers', false);
			$this->setRedirect($redirect_url, $message, 'error');
			return false;
		}

		// check if user has the right
		$user = Factory::getUser();
		if($user->authorise('power.reset', 'com_componentbuilder'))
		{
			// set success message
			$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_THIS_RESET_FEATURE_IS_STILL_UNDER_DEVELOPMENT').'</h1>';
			$message .= '<p>'.Text::sprintf('COM_COMPONENTBUILDER_PLEASE_CHECK_AGAIN_SOON_ANDOR_FOLLOW_THE_PROGRESS_ON_SGITVDMDEVA', '<a href="https://git.vdm.dev/joomla/Component-Builder/issues/984" target="_blank">').'</p>';
			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=powers', false);
			$this->setRedirect($redirect_url, $message);
			return true;
		}
		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=powers', false);
		$this->setRedirect($redirect_url);
		return false;
	}
}