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

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\Utilities\ArrayHelper;

/**
 * Componentbuilder Search Base Controller
 */
class ComponentbuilderControllerSearch extends BaseController
{
	public function __construct($config)
	{
		parent::__construct($config);
	}

	public function dashboard()
	{
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder', false));
		return;
	}

	public function openCompiler()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// redirect to the libraries
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=compiler', false));
		return;
	}
}
