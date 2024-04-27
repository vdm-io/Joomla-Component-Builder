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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

###SITE_CUSTOM_POWER_AUTOLOADER###

###SITE_COMPONENT_HEADER###

// Set the component css/js
Html::_('stylesheet', 'components/com_###component###/assets/css/site.css', ['version' => 'auto']);
Html::_('script', 'components/com_###component###/assets/js/site.js', ['version' => 'auto']);

// Require helper files
JLoader::register('###Component###Helper', __DIR__ . '/helpers/###component###.php');###HELPER_EMAIL###
JLoader::register('###Component###HelperRoute', __DIR__ . '/helpers/route.php');###LICENSE_LOCKED_INT######SITE_GLOBAL_EVENT###

// Get an instance of the controller prefixed by ###Component###
$controller = BaseController::getInstance('###Component###');

// Perform the request task
$controller->execute(Factory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
