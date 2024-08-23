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
use VDM\Joomla\Componentbuilder\Fieldtype\Factory as FieldtypeFactory;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Fieldtypes Admin Controller
 *
 * @since  1.6
 */
class FieldtypesController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_FIELDTYPES';

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
	public function getModel($name = 'Fieldtype', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}


	/**
	 * Resets the specified Joomla Field Type.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the item data posted by the user.
	 * 3. It checks whether the current user has the necessary permissions to reset the Joomla Field Type.
	 * 4. It validates the presence of the necessary item identifiers (ID and GUID).
	 * 5. If the user is authorized and the identifiers are valid, it attempts to reset the specified Joomla Field Type.
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
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RESET_THIS_JOOMLA_FIELD_TYPE') . '</p>';
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
			$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_SAVE_THE_JOOMLA_FIELD_TYPE_BEFORE_YOU_CAN_USE_THIS_FEATURE') . '</p>';
		}
		elseif($user->authorise('fieldtype.reset', 'com_componentbuilder'))
		{
			if (FieldtypeFactory::_('Joomla.Fieldtype.Remote.Get')->reset([$guid]))
			{
				// set success message
				$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_SUCCESS').'</h1>';
				$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_THE_JOOMLA_FIELD_TYPE_HAS_SUCCESSFULLY_BEEN_RESET').'</p>';
				$status = 'success';
				$success = true;
			}
			else
			{
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_RESET_FAILED') . '</h1>';
				$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_RESET_OF_THIS_JOOMLA_FIELD_TYPE_HAS_FAILED') . '</p>';
			}
		}

		// set redirect
		$redirect_url = Route::_(
			'index.php?option=com_componentbuilder&view=fieldtype'
			. $this->getRedirectToItemAppend($id), $success
		);

		$this->setRedirect($redirect_url, $message, $status);

		return $success;
	}

	 /**
	 * Pushes the specified Joomla Field Type.
	 *
	 * This function performs several checks and operations:
	 * 1. It verifies the authenticity of the request to prevent request forgery.
	 * 2. It retrieves the item data posted by the user.
	 * 3. It checks whether the current user has the necessary permissions to push the Joomla Field Type.
	 * 4. It validates the presence of the necessary item identifiers (ID and GUID).
	 * 5. If the user is authorized and the identifiers are valid, it attempts to push the specified Joomla Field Type.
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
		$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_PUSH_THIS_JOOMLA_FIELD_TYPE') . '</p>';
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
			$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_YOU_MUST_FIRST_SAVE_THE_JOOMLA_FIELD_TYPE_BEFORE_YOU_CAN_USE_THIS_FEATURE') . '</p>';
		}
		elseif($user->authorise('fieldtype.push', 'com_componentbuilder'))
		{
			try {
				if (FieldtypeFactory::_('Joomla.Fieldtype.Remote.Set')->items([$guid]))
				{
					// set success message
					$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_SUCCESS').'</h1>';
					$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_THE_JOOMLA_FIELD_TYPE_HAS_SUCCESSFULLY_BEEN_PUSHED').'</p>';
					$status = 'success';
					$success = true;
				}
				else
				{
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
					$message .= '<p>' . Text::_('COM_COMPONENTBUILDER_THE_PUSH_OF_THIS_JOOMLA_FIELD_TYPE_HAS_FAILED') . '</p>';
				}
			} catch (\Exception $e) {
				$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_PUSH_FAILED') . '</h1>';
				$message .= '<p>' . \htmlspecialchars($e->getMessage()) . '</p>';
			}
		}

		// set redirect
		$redirect_url = Route::_(
			'index.php?option=com_componentbuilder&view=fieldtype'
			. $this->getRedirectToItemAppend($id), $success
		);

		$this->setRedirect($redirect_url, $message, $status);

		return $success;
	}
}