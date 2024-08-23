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
use Joomla\CMS\Form\FormFactoryInterface;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\Input\Input;
use Joomla\CMS\Versioning\VersionableControllerTrait;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\JoomlaPower\Factory as JoomlaPowerFactory;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_power Form Controller
 *
 * @since  1.6
 */
class Joomla_powerController extends FormController
{
	use VersionableControllerTrait;

	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_POWER';

	/**
	 * Current or most recently performed task.
	 *
	 * @var    string
	 * @since  12.2
	 * @note   Replaces _task.
	 */
	protected $task;

	/**
	 * The URL view list variable.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $view_list = 'joomla_powers';


	/**
	 * Resets the specified Joomla Power.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the item data posted by the user.
	 * 3. It checks whether the current user has the necessary permissions to reset the Joomla Power.
	 * 4. It validates the presence of the necessary item identifiers (ID and GUID).
	 * 5. If the user is authorized and the identifiers are valid, it attempts to reset the specified Joomla Power.
	 * 6. Depending on the result of the reset operation, it sets the appropriate success or error message.
	 * 7. It redirects the user to a specified URL with the result message and status.
	 *
	 * @return bool True on successful reset, false on failure.
	 */
	public function resetPowers()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// get Item posted
		$item = $this->input->post->get('jform', array(), 'array');

		// check if user has the right
		$user = Factory::getUser();

		// set default error message
		$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PERMISSION_DENIED') . '</h1>';
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RESET_THIS_JOOMLA_POWER') . '</p>';
		$status = 'error';
		$success = false;

		// load the ID
		$id = $item['id'] ?? null;
		$guid = $item['guid'] ?? null;

		// check if there is any selections
		if ($id === null || $guid === null)
		{
			// set error message
			$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_NOT_SAVED') . '</h1>';
			$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_SAVE_THE_JOOMLA_POWER_BEFORE_YOU_CAN_USE_THIS_FEATURE') . '</p>';
		}
		elseif($user->authorise('joomla_power.reset', 'com_componentbuilder'))
		{
			if (JoomlaPowerFactory::_('Joomla.Power.Remote.Get')->reset([$guid]))
			{
				// set success message
				$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_SUCCESS').'</h1>';
				$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_THE_JOOMLA_POWER_HAS_SUCCESSFULLY_BEEN_RESET').'</p>';
				$status = 'success';
				$success = true;
			}
			else
			{
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_FAILED') . '</h1>';
				$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_RESET_OF_THIS_JOOMLA_POWER_HAS_FAILED') . '</p>';
			}
		}

		// set redirect
		$redirect_url = Route::_(
			'index.php?option=com_componentbuilder&view=joomla_power'
			. $this->getRedirectToItemAppend($id), $success
		);

		$this->setRedirect($redirect_url, $message, $status);

		return $success;
	}

	 /**
	 * Pushes the specified Joomla Power.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the item data posted by the user.
	 * 3. It checks whether the current user has the necessary permissions to push the Joomla Power.
	 * 4. It validates the presence of the necessary item identifiers (ID and GUID).
	 * 5. If the user is authorized and the identifiers are valid, it attempts to push the specified Joomla Power.
	 * 6. Depending on the result of the push operation, it sets the appropriate success or error message.
	 * 7. It redirects the user to a specified URL with the result message and status.
	 *
	 * @return bool True on successful push, false on failure.
	 */
	public function pushPowers()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// get Item posted
		$item = $this->input->post->get('jform', array(), 'array');

		// check if user has the right
		$user = Factory::getUser();

		// set default error message
		$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PERMISSION_DENIED') . '</h1>';
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_PUSH_THIS_JOOMLA_POWER') . '</p>';
		$status = 'error';
		$success = false;

		// load the ID
		$id = $item['id'] ?? null;
		$guid = $item['guid'] ?? null;

		// check if there is any selections
		if ($id === null || $guid === null)
		{
			// set error message
			$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_NOT_SAVED') . '</h1>';
			$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_SAVE_THE_JOOMLA_POWER_BEFORE_YOU_CAN_USE_THIS_FEATURE') . '</p>';
		}
		elseif($user->authorise('joomla_power.push', 'com_componentbuilder'))
		{
			try {
				if (JoomlaPowerFactory::_('Joomla.Power.Remote.Set')->items([$guid]))
				{
					// set success message
					$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_SUCCESS').'</h1>';
					$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_THE_JOOMLA_POWER_HAS_SUCCESSFULLY_BEEN_PUSHED').'</p>';
					$status = 'success';
					$success = true;
				}
				else
				{
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_PUSH_OF_THIS_JOOMLA_POWER_HAS_FAILED') . '</p>';
				}
			} catch (\Exception $e) {
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
				$message .= '<p>' . \htmlspecialchars($e->getMessage()) . '</p>';
			}
		}

		// set redirect
		$redirect_url = Route::_(
			'index.php?option=com_componentbuilder&view=joomla_power'
			. $this->getRedirectToItemAppend($id), $success
		);

		$this->setRedirect($redirect_url, $message, $status);

		return $success;
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
	protected function allowAdd($data = [])
	{
		// Get user object.
		$user = $this->app->getIdentity();
		// Access check.
		$access = $user->authorise('joomla_power.access', 'com_componentbuilder');
		if (!$access)
		{
			return false;
		}

		// In the absence of better information, revert to the component permissions.
		return $user->authorise('joomla_power.create', $this->option);
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = [], $key = 'id')
	{
		// get user object.
		$user = $this->app->getIdentity();
		// get record id.
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;


		// Access check.
		$access = ($user->authorise('joomla_power.access', 'com_componentbuilder.joomla_power.' . (int) $recordId) && $user->authorise('joomla_power.access', 'com_componentbuilder'));
		if (!$access)
		{
			return false;
		}

		if ($recordId)
		{
			// The record has been set. Check the record permissions.
			$permission = $user->authorise('joomla_power.edit', 'com_componentbuilder.joomla_power.' . (int) $recordId);
			if (!$permission)
			{
				if ($user->authorise('joomla_power.edit.own', 'com_componentbuilder.joomla_power.' . $recordId))
				{
					// Now test the owner is the user.
					$ownerId = (int) isset($data['created_by']) ? $data['created_by'] : 0;
					if (empty($ownerId))
					{
						// Need to do a lookup from the model.
						$record = $this->getModel()->getItem($recordId);

						if (empty($record))
						{
							return false;
						}
						$ownerId = $record->created_by;
					}

					// If the owner matches 'me' then allow.
					if ($ownerId == $user->id)
					{
						if ($user->authorise('joomla_power.edit.own', 'com_componentbuilder'))
						{
							return true;
						}
					}
				}
				return false;
			}
		}
		// Since there is no permission, revert to the component permissions.
		return $user->authorise('joomla_power.edit', $this->option);
	}

	/**
	 * Gets the URL arguments to append to an item redirect.
	 *
	 * @param   integer  $recordId  The primary key id for the item.
	 * @param   string   $urlVar    The name of the URL variable for the id.
	 *
	 * @return  string  The arguments to append to the redirect URL.
	 *
	 * @since   1.6
	 */
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		// get the referral options (old method use return instead see parent)
		$ref = $this->input->get('ref', 0, 'string');
		$refid = $this->input->get('refid', 0, 'int');

		// get redirect info.
		$append = parent::getRedirectToItemAppend($recordId, $urlVar);

		// set the referral options
		if ($refid && $ref)
		{
			$append = '&ref=' . (string) $ref . '&refid='. (int) $refid . $append;
		}
		elseif ($ref)
		{
			$append = '&ref='. (string) $ref . $append;
		}

		return $append;
	}

	/**
	 * Method to run batch operations.
	 *
	 * @param   object  $model  The model.
	 *
	 * @return  boolean   True if successful, false otherwise and internal error is set.
	 *
	 * @since   2.5
	 */
	public function batch($model = null)
	{
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));

		// Set the model
		$model = $this->getModel('Joomla_power', '', []);

		// Preset the redirect
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=joomla_powers' . $this->getRedirectToListAppend(), false));

		return parent::batch($model);
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string  $key  The name of the primary key of the URL variable.
	 *
	 * @return  boolean  True if access level checks pass, false otherwise.
	 *
	 * @since   12.2
	 */
	public function cancel($key = null)
	{
		// get the referral options
		$this->ref = $this->input->get('ref', 0, 'word');
		$this->refid = $this->input->get('refid', 0, 'int');

		// Check if there is a return value
		$return = $this->input->get('return', null, 'base64');

		$cancel = parent::cancel($key);

		if (!is_null($return) && Uri::isInternal(base64_decode($return)))
		{
			$redirect = base64_decode($return);

			// Redirect to the return value.
			$this->setRedirect(
				Route::_(
					$redirect, false
				)
			);
		}
		elseif ($this->refid && $this->ref)
		{
			$redirect = '&view=' . (string)$this->ref . '&layout=edit&id=' . (int)$this->refid;

			// Redirect to the item screen.
			$this->setRedirect(
				Route::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		elseif ($this->ref)
		{
			$redirect = '&view='.(string)$this->ref;

			// Redirect to the list screen.
			$this->setRedirect(
				Route::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		return $cancel;
	}

	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   12.2
	 */
	public function save($key = null, $urlVar = null)
	{
		// get the referral options
		$this->ref = $this->input->get('ref', 0, 'word');
		$this->refid = $this->input->get('refid', 0, 'int');

		// Check if there is a return value
		$return = $this->input->get('return', null, 'base64');
		$canReturn = (!is_null($return) && Uri::isInternal(base64_decode($return)));

		if ($this->ref || $this->refid || $canReturn)
		{
			// to make sure the item is checkedin on redirect
			$this->task = 'save';
		}

		$saved = parent::save($key, $urlVar);

		// This is not needed since parent save already does this
		// Due to the ref and refid implementation we need to add this
		if ($canReturn)
		{
			$redirect = base64_decode($return);

			// Redirect to the return value.
			$this->setRedirect(
				Route::_(
					$redirect, false
				)
			);
		}
		elseif ($this->refid && $this->ref)
		{
			$redirect = '&view=' . (string) $this->ref . '&layout=edit&id=' . (int) $this->refid;

			// Redirect to the item screen.
			$this->setRedirect(
				Route::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		elseif ($this->ref)
		{
			$redirect = '&view=' . (string) $this->ref;

			// Redirect to the list screen.
			$this->setRedirect(
				Route::_(
					'index.php?option=' . $this->option . $redirect, false
				)
			);
		}
		return $saved;
	}

	/**
	 * Function that allows child controller access to model data
	 * after the data has been saved.
	 *
	 * @param   BaseDatabaseModel  $model     The data model object.
	 * @param   array              $validData  The validated data.
	 *
	 * @return  void
	 *
	 * @since   11.1
	 */
	protected function postSaveHook(BaseDatabaseModel $model, $validData = [])
	{
		return;
	}
}
