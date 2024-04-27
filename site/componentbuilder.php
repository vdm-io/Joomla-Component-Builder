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

// The power autoloader for this project (JPATH_SITE) area.
$power_autoloader = JPATH_SITE . '/components/com_componentbuilder/helpers/powerloader.php';
if (file_exists($power_autoloader))
{
	require_once $power_autoloader;
}

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\MVC\Controller\BaseController;

// Set the component css/js
Html::_('stylesheet', 'components/com_componentbuilder/assets/css/site.css', ['version' => 'auto']);
Html::_('script', 'components/com_componentbuilder/assets/js/site.js', ['version' => 'auto']);

// Require helper files
JLoader::register('ComponentbuilderHelper', __DIR__ . '/helpers/componentbuilder.php');
\JLoader::register('ComponentbuilderEmail', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/componentbuilderemail.php'); 
JLoader::register('ComponentbuilderHelperRoute', __DIR__ . '/helpers/route.php');

//Trigger the Global Site Event
ComponentbuilderHelper::globalEvent(Factory::getDocument());

// Get an instance of the controller prefixed by Componentbuilder
$controller = BaseController::getInstance('Componentbuilder');

// Perform the request task
$controller->execute(Factory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
