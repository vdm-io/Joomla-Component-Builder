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

###CUSTOM_POWER_AUTOLOADER###

###ADMIN_COMPONENT_HEADER###

// Access check.
if (!Factory::getUser()->authorise('core.manage', 'com_###component###'))
{
	throw new NotAllowed(Text::_('JERROR_ALERTNOAUTHOR'), 403);
}

// Add CSS file for all pages
Html::_('stylesheet', 'components/com_###component###/assets/css/admin.css', ['version' => 'auto']);
Html::_('script', 'components/com_###component###/assets/js/admin.js', ['version' => 'auto']);

// require helper files
JLoader::register('###Component###Helper', __DIR__ . '/helpers/###component###.php');###HELPER_EMAIL###
JLoader::register('JHtmlBatch_', __DIR__ . '/helpers/html/batch_.php');###LICENSE_LOCKED_INT######ADMIN_GLOBAL_EVENT###

// Get an instance of the controller prefixed by ###Component###
$controller = BaseController::getInstance('###Component###');

// Perform the Request task
$controller->execute(Factory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
