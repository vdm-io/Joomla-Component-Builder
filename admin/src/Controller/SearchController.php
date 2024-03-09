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
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\Utilities\ArrayHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Search Base Controller
 *
 * @since  1.6
 */
class SearchController extends BaseController
{
	/**
	 * The context for storing internal data, e.g. record.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $context = 'search';

	/**
	 * The URL view item variable.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $view_item = 'search';

	/**
	 * Adds option to redirect back to the dashboard.
	 *
	 * @return  void
	 * @since   3.0
	 */
	public function dashboard(): void
	{
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder', false));
	}

	public function openCompiler()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// redirect to the libraries
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=compiler', false));
		return;
	}
}
