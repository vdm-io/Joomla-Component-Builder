<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');



// Set the component css/js
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_componentbuilder/assets/css/site.css');
$document->addScript('components/com_componentbuilder/assets/js/site.js');

// Require helper files
JLoader::register('ComponentbuilderHelper', __DIR__ . '/helpers/componentbuilder.php');
JLoader::register('ComponentbuilderEmail', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/componentbuilderemail.php'); 
JLoader::register('ComponentbuilderHelperRoute', __DIR__ . '/helpers/route.php');

// Trigger the Global Site Event
ComponentbuilderHelper::globalEvent($document);

// Get an instance of the controller prefixed by Componentbuilder
$controller = JControllerLegacy::getInstance('Componentbuilder');

// Perform the request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
