<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tabstate');

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_componentbuilder'))
{
	throw new JAccessExceptionNotallowed(JText::_('JERROR_ALERTNOAUTHOR'), 403);
};

// Add CSS file for all pages
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_componentbuilder/assets/css/admin.css');
$document->addScript('components/com_componentbuilder/assets/js/admin.js');

// require helper files
JLoader::register('ComponentbuilderHelper', __DIR__ . '/helpers/componentbuilder.php'); 
JLoader::register('ComponentbuilderEmail', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/componentbuilderemail.php'); 
JLoader::register('JHtmlBatch_', __DIR__ . '/helpers/html/batch_.php'); 

// Triger the Global Admin Event
ComponentbuilderHelper::globalEvent($document);

// Get an instance of the controller prefixed by Componentbuilder
$controller = JControllerLegacy::getInstance('Componentbuilder');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
