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
use VDM\Joomla\Componentbuilder\Repository\Factory as RepositoryFactory;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Repositories Admin Controller
 *
 * @since  1.6
 */
class RepositoriesController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_REPOSITORIES';

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
	public function getModel($name = 'Repository', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}


	/**
	 * Redirect the request to the Initialization selection page.
	 *
	 * @return bool True on successful initialization, false on failure.
	 * @since  5.1.1
	 */
	public function initPowers()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = $this->app->getIdentity();

		// set default error message
		$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PERMISSION_DENIED') . '</h1>';
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INITIALIZE_REPOSITORIES') . '</p>';
		$status = 'error';
		$success = false;

		if($user->authorise('repository.init', 'com_componentbuilder'))
		{
			// set success message
			$message = null;

			$status = null;
			$success = true;

			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=initialization_selection&power=Repository&target=Repositories', false);
		}
		else
		{
			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=repositories', false);
		}
		$this->setRedirect($redirect_url, $message, $status);

		return $success;
	}

	/**
	 * Resets the selected Repositories.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the IDs of the selected powers from the user input.
	 * 3. It sanitizes the input by converting the IDs to integers.
	 * 4. It checks whether any powers have been selected.
	 * 5. It checks whether the current user has the necessary permissions to reset the selected Repositories.
	 * 6. If the user is authorized and powers are selected, it attempts to reset the selected Repositories.
	 * 7. Depending on the result of the reset operation, it sets the appropriate success or error message.
	 * 8. It redirects the user to a specified URL with the result message and status.
	 *
	 * @return bool True on successful reset, false on failure.
	 * @since  5.1.1
	 */
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
			$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_NO_SELECTION_DETECTED') . '</h1>';
			$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_PLEASE_FIRST_MAKE_A_SELECTION_FROM_THE_LIST') . '</p>';
			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=repositories', false);
			$this->setRedirect($redirect_url, $message, 'error');
			return false;
		}

		$status = 'error';
		$success = false;

		// check if user has the right
		$user = $this->app->getIdentity();
		if($user->authorise('repository.reset', 'com_componentbuilder'))
		{
			// get the guid field of this entity
			$key_field = RepositoryFactory::_('Repository.Remote.Get')->getGuidField();
			$guids = RepositoryFactory::_('Load')->values([$key_field], ['repository'], ['id' => ['value' => $pks, 'operator' => 'IN']]);

			try {
				if (RepositoryFactory::_('Repository.Remote.Get')->reset($guids))
				{
					// set success message
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_SUCCESS') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THESE_REPOSITORIES_HAVE_SUCCESSFULLY_BEEN_RESET') . '</p>';
					$status = 'success';
					$success = true;
				}
				else
				{
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_FAILED') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_RESET_OF_THESE_REPOSITORIES_HAS_FAILED') . '</p>';
				}
			} catch (\Exception $e) {
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_FAILED') . '</h1>';
				$message .= '<p>' . \htmlspecialchars($e->getMessage()) . '</p>';
			}

			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=repositories', false);
			$this->setRedirect($redirect_url, $message, $status);

			return $success;
		}

		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=repositories', false);
		$this->setRedirect($redirect_url);
		return $success;
	}

	/**
	 * Pushes the selected Repositories.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the IDs of the selected powers from the user input.
	 * 3. It sanitizes the input by converting the IDs to integers.
	 * 4. It checks whether any powers have been selected.
	 * 5. It checks whether the current user has the necessary permissions to push the selected Repositories.
	 * 6. If the user is authorized and powers are selected, it attempts to push the selected Repositories.
	 * 7. Depending on the result of the push operation, it sets the appropriate success or error message.
	 * 8. It redirects the user to a specified URL with the result message and status.
	 *
	 * @return bool True on successful push, false on failure.
	 * @since  5.1.1
	 */
	public function pushPowers()
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
			$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_NO_SELECTION_DETECTED') . '</h1>';
			$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_PLEASE_FIRST_MAKE_A_SELECTION_FROM_THE_LIST') . '</p>';
			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=repositories', false);
			$this->setRedirect($redirect_url, $message, 'error');
			return false;
		}

		$status = 'error';
		$success = false;
		$message_bus = ['warning', 'error'];

		// check if user has the right
		$user = $this->app->getIdentity();
		if($user->authorise('repository.push', 'com_componentbuilder'))
		{
			// get the guid field of this entity
			$key_field = RepositoryFactory::_('Repository.Remote.Set')->getGuidField();
			$guids = RepositoryFactory::_('Load')->values([$key_field], ['repository'], ['id' => ['value' => $pks, 'operator' => 'IN']]);

			try {
				if (RepositoryFactory::_('Repository.Remote.Set')->items($guids))
				{
					// set success message
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_SUCCESS') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THESE_REPOSITORIES_HAVE_SUCCESSFULLY_BEEN_PUSHED') . '</p>';
					$status = 'success';
					$success = true;
				}
				else
				{
					// Load any messages from the message bus
					$message_bucket = [];

					foreach ($message_bus as $message_key)
					{
						if (($messages = RepositoryFactory::_('Power.Message')->get($message_key, null)) !== null)
						{
							$message_bucket[$message_key] = $messages;
						}
					}

					// Initialize base values
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_PUSH_OF_THIS_REPOSITORIES_HAS_FAILED') . '</p>';
					$status = 'error';

					// Handle both error and warning
					if (isset($message_bucket['error'], $message_bucket['warning']))
					{
						$message .= '<p>' . implode('<br>', $message_bucket['error']) . '</p>';

						foreach ($message_bucket['warning'] as $warning)
						{
							$this->app->enqueueMessage($warning, 'warning');
						}
					}
					elseif (isset($message_bucket['error']))
					{
						$message .= '<p>' . implode('<br>', $message_bucket['error']) . '</p>';
					}
					elseif (isset($message_bucket['warning']))
					{
						$status = 'warning';
						$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_WAS_UNSUCCESSFUL') . '</h1>';
						$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_PUSH_OF_THESE_REPOSITORIES_COULD_NOT_BE_COMPLETED') . '</p>';
						$message .= '<p>' . implode('<br>', $message_bucket['warning']) . '</p>';
					}
				}
			} catch (\Exception $e) {
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
				$message .= '<p>' . \htmlspecialchars($e->getMessage()) . '</p>';
			}

			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=repositories', false);
			$this->setRedirect($redirect_url, $message, $status);

			return $success;
		}

		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=repositories', false);
		$this->setRedirect($redirect_url);
		return $success;
	}
}