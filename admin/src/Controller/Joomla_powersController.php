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
use VDM\Joomla\Componentbuilder\JoomlaPower\Factory as JoomlaPowerFactory;
use VDM\Joomla\Utilities\GetHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_powers Admin Controller
 *
 * @since  1.6
 */
class Joomla_powersController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_POWERS';

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
	public function getModel($name = 'Joomla_power', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function initPowers()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = Factory::getUser();

		// set default error message
		$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PERMISSION_DENIED') . '</h1>';
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INITIALIZE_JOOMLA_POWERS') . '</p>';
		$status = 'error';
		$success = false;

		if($user->authorise('power.init', 'com_componentbuilder'))
		{
			if (JoomlaPowerFactory::_('Joomlapower')->init())
			{
				// set success message
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_SUCCESSFULLY_INITIALIZED_ALL_REMOTE_JOOMLA_POWERS') . '</h1>';
				$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_LOCAL_DATABASE_JOOMLA_POWERS_HAS_SUCCESSFULLY_BEEN_SYNCED_WITH_THE_REMOTE_REPOSITORIES') . '</p>';

				$status = 'success';
				$success = true;
			}
			else
			{
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_INITIALIZATION_FAILED') . '</h1>';
				$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_INITIALIZATION_OF_THIS_JOOMLA_POWERS_HAS_FAILED') . '</p>';
			}
		}

		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_powers', $success);
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
		if ($pks === [])
		{
			// set error message
			$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_NO_SELECTION_DETECTED').'</h1>';
			$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_PLEASE_FIRST_MAKE_A_SELECTION_FROM_THE_LIST').'</p>';
			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_powers', false);
			$this->setRedirect($redirect_url, $message, 'error');
			return false;
		}

		$status = 'error';
		$success = false;

		// check if user has the right
		$user = Factory::getUser();
		if($user->authorise('power.reset', 'com_componentbuilder'))
		{
			$guids = GetHelper::vars('joomla_power', $pks, 'id', 'guid');

			if (JoomlaPowerFactory::_('Joomlapower')->reset($guids))
			{
				// set success message
				$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_SUCCESS').'</h1>';
				$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_THESE_JOOMLA_POWERS_HAVE_SUCCESSFULLY_BEEN_RESET').'</p>';
				$status = 'success';
				$success = true;
			}
			else
			{
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_FAILED') . '</h1>';
				$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_RESET_OF_THESE_JOOMLA_POWERS_HAS_FAILED') . '</p>';
			}

			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_powers', $success);
			$this->setRedirect($redirect_url, $message, $status);

			return $success;
		}

		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_powers', false);
		$this->setRedirect($redirect_url);
		return $success;
	}
}