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
use Joomla\CMS\Version;
use VDM\Joomla\Componentbuilder\PHPConfigurationChecker;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Extrusion Admin Controller
 *
 * @since  1.6
 */
class ExtrusionController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_EXTRUSION';

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
	public function getModel($name = 'Extrusion', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	/**
	 * Adds option to redirect back to the dashboard.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function dashboard(): void
	{
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder', false));
	}


	/**
	 * Perform a health check for the Componentbuilder.
	 *
	 * @return bool  True on success.
	 * @since  6.1.6
	 */
	public function healthCheck(): bool
	{
		// Check for request forgeries.
		Session::checkToken()
			or exit(Text::_('JINVALID_TOKEN'));

		// Prepare redirect target.
		$redirectUrl = Route::_('index.php?option=com_componentbuilder&view=extrusion', false);

		// Get current user.
		$user = $this->app->getIdentity();

		// Verify permissions before running the health check.
		if (
			!$user->authorise('extrusion.health_check', 'com_componentbuilder')
			|| !$user->authorise('core.manage', 'com_componentbuilder')
		)
		{
			$this->setRedirect(
				$redirectUrl,
				Text::_('COM_COMPONENTBUILDER_COULD_NOT_DO_A_HEALTH_CHECK_OF_COMPONENTBUILDER'),
				'error'
			);

			return false;
		}

		// Run the health check process.
		(new PHPConfigurationChecker($this->app))->run();

		// Redirect back to the health check view.
		$this->setRedirect($redirectUrl);

		return true;
	}
}
