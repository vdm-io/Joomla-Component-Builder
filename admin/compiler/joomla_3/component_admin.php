<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tabstate');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_###component###'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
};

// Add CSS file for all pages
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_###component###/assets/css/admin.css');
$document->addScript('components/com_###component###/assets/js/admin.js');

// require helper files
JLoader::register('###Component###Helper', __DIR__ . '/helpers/###component###.php'); ###HELPER_EMAIL###
JLoader::register('JHtmlBatch_', __DIR__ . '/helpers/html/batch_.php');###LICENSE_LOCKED_INT### ###ADMIN_GLOBAL_EVENT###

// Get an instance of the controller prefixed by ###Component###
$controller = JControllerLegacy::getInstance('###Component###');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
