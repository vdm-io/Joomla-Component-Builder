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
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Package\Factory as PackageFactory;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_components Admin Controller
 *
 * @since  1.6
 */
class Joomla_componentsController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_COMPONENTS';

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
	public function getModel($name = 'Joomla_component', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = Factory::getApplication()->getIdentity();
		if ($user->authorise('joomla_component.export', 'com_componentbuilder') && $user->authorise('core.export', 'com_componentbuilder'))
		{
			// Get the input
			$input = Factory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			$pks = ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Joomla_components');
			// get the data to export
			$data = $model->getExportData($pks);
			if (UtilitiesArrayHelper::check($data))
			{
				// now set the data to the spreadsheet
				$date = Factory::getDate();
				ComponentbuilderHelper::xls($data,'Joomla_components_'.$date->format('jS_F_Y'),'Joomla components exported ('.$date->format('jS F, Y').')','joomla components');
			}
		}
		// Redirect to the list screen with error.
		$message = Text::_('COM_COMPONENTBUILDER_EXPORT_FAILED');
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = Factory::getApplication()->getIdentity();
		if ($user->authorise('joomla_component.import', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
		{
			// Get the import model
			$model = $this->getModel('Joomla_components');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (ObjectHelper::check($headers))
			{
				// Load headers to session.
				$session = Factory::getSession();
				$headers = json_encode($headers);
				$session->set('joomla_component_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'joomla_components');
				$session->set('dataType_VDM_IMPORTINTO', 'joomla_component');
				// Redirect to import view.
				$message = Text::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_FOR_JOOMLA_COMPONENTS');
				$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=import_joomla_components', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = Text::_('COM_COMPONENTBUILDER_IMPORT_FAILED');
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}


	/**
	 * Clear tmp folder
	 *
	 * @return  true on success
	 * @since  3.0.0
	 */
	public function clearTmp()
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = Factory::getUser();

		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
		$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_CLEAR_THE_TMP_FOLDER');
		if($user->authorise('joomla_components.clear_tmp', 'com_componentbuilder') && $user->authorise('core.manage', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('compiler');
			// get tmp folder
			$comConfig = Factory::getConfig();
			$tmp = $comConfig->get('tmp_path');
			if ($model->emptyFolder($tmp))
			{
				$message = Text::_('COM_COMPONENTBUILDER_BTHE_TMP_FOLDER_HAS_BEEN_CLEARED_SUCCESSFULLYB');
				$this->setRedirect($redirect_url, $message, 'message');
				// get application
				$app = Factory::getApplication();
				// wipe out the user c-m-p since we are done with them all
				$app->setUserState('com_componentbuilder.component_folder_name', '');
				$app->setUserState('com_componentbuilder.modules_folder_name', '');
				$app->setUserState('com_componentbuilder.plugins_folder_name', '');
				$app->setUserState('com_componentbuilder.success_message', '');

				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
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
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INITIALIZE_JOOMLA_COMPONENTS') . '</p>';
		$status = 'error';
		$success = false;

		if($user->authorise('joomla_component.init', 'com_componentbuilder'))
		{
			// set success message
			$message = null;

			$status = null;
			$success = true;

			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=initialization_selection&power=Component&target=Joomla Components', false);
		}
		else
		{
			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
		}
		$this->setRedirect($redirect_url, $message, $status);

		return $success;
	}

	/**
	 * Resets the selected Joomla Components.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the IDs of the selected powers from the user input.
	 * 3. It sanitizes the input by converting the IDs to integers.
	 * 4. It checks whether any powers have been selected.
	 * 5. It checks whether the current user has the necessary permissions to reset the selected Joomla Components.
	 * 6. If the user is authorized and powers are selected, it attempts to reset the selected Joomla Components.
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
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
			$this->setRedirect($redirect_url, $message, 'error');
			return false;
		}

		$status = 'error';
		$success = false;
		$has_error = false;
		$message_bus = ['success', 'warning', 'error'];

		// check if user has the right
		$user = $this->app->getIdentity();
		if($user->authorise('joomla_component.reset', 'com_componentbuilder'))
		{
			// get the guid field of this entity
			$key_field = PackageFactory::_('Component.Remote.Get')->getGuidField();
			$guids = PackageFactory::_('Load')->values([$key_field], ['joomla_component'], ['id' => ['value' => $pks, 'operator' => 'IN']]);

			try {
				PackageFactory::_('Package.Builder.Get')->reset('joomla_component', $guids);

				foreach ($message_bus as $message_key)
				{
					if (($messages = PackageFactory::_('Power.Message')->get($message_key, null)) !== null)
					{
						$messages = '<p>' . implode('<br>', $messages) . '</p>';
						$this->app->enqueueMessage($messages, $message_key);

						if (!$success && $message_key === 'success')
						{
							$success = true;
						}

						if (!$has_error && $message_key === 'error')
						{
							$has_error = true;
						}
					}
				}

				if ($success)
				{
					// set success message
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_SUCCESS') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THESE_JOOMLA_COMPONENTS_HAVE_SUCCESSFULLY_BEEN_RESET') . '</p>';
					$status = 'success';
				}
				elseif ($has_error)
				{
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_FAILED') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_RESET_OF_THESE_JOOMLA_COMPONENTS_HAS_FAILED') . '</p>';
					$status = 'error';
				}
				else
				{
					// Initialize base values
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_UNSUCCESSFUL') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_RESET_OF_THIS_JOOMLA_COMPONENTS_HAS_NOT_BEEN_SUCCESSFUL') . '</p>';
					$status = 'warning';
				}
			} catch (\Exception $e) {
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_FAILED') . '</h1>';
				$message .= '<p>' . \htmlspecialchars($e->getMessage()) . '</p>';
			}

			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
			$this->setRedirect($redirect_url, $message, $status);

			return $success;
		}

		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
		$this->setRedirect($redirect_url);

		return $success;
	}

	/**
	 * Pushes the selected Joomla Components.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the IDs of the selected powers from the user input.
	 * 3. It sanitizes the input by converting the IDs to integers.
	 * 4. It checks whether any powers have been selected.
	 * 5. It checks whether the current user has the necessary permissions to push the selected Joomla Components.
	 * 6. If the user is authorized and powers are selected, it attempts to push the selected Joomla Components.
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
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
			$this->setRedirect($redirect_url, $message, 'error');
			return false;
		}

		$status = 'error';
		$success = false;
		$has_error = false;
		$message_bus = ['success', 'warning', 'error'];

		// check if user has the right
		$user = $this->app->getIdentity();
		if($user->authorise('joomla_component.push', 'com_componentbuilder'))
		{
			// get the guid field of this entity
			$key_field = PackageFactory::_('Component.Remote.Set')->getGuidField();
			$guids = PackageFactory::_('Load')->values([$key_field], ['joomla_component'], ['id' => ['value' => $pks, 'operator' => 'IN']]);

			try {
				PackageFactory::_('Package.Builder.Set')->items('joomla_component', $guids);

				foreach ($message_bus as $message_key)
				{
					if (($messages = PackageFactory::_('Power.Message')->get($message_key, null)) !== null)
					{
						$messages = '<p>' . implode('<br>', $messages) . '</p>';
						$this->app->enqueueMessage($messages, $message_key);

						if (!$success && $message_key === 'success')
						{
							$success = true;
						}

						if (!$has_error && $message_key === 'error')
						{
							$has_error = true;
						}
					}
				}

				if ($success)
				{
					// set success message
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_SUCCESS') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THESE_JOOMLA_COMPONENTS_HAVE_SUCCESSFULLY_BEEN_PUSHED') . '</p>';
					$status = 'success';
				}
				elseif ($has_error)
				{
					// Initialize base values
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_PUSH_OF_THIS_JOOMLA_COMPONENTS_HAS_FAILED') . '</p>';
					$status = 'error';
				}
				else
				{
					// Initialize base values
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_UNSUCCESSFUL') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_PUSH_OF_THIS_JOOMLA_COMPONENTS_HAS_NOT_BEEN_SUCCESSFUL') . '</p>';
					$status = 'warning';
				}
			} catch (\Exception $e) {
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
				$message .= '<p>' . \htmlspecialchars($e->getMessage()) . '</p>';
			}

			// set redirect
			$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
			$this->setRedirect($redirect_url, $message, $status);

			return $success;
		}

		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
		$this->setRedirect($redirect_url);

		return $success;
	}
}