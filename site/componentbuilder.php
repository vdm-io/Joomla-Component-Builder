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

// add the autoloader for the composer classes
$composer_autoloader = JPATH_LIBRARIES . '/phpseclib3/vendor/autoload.php';
if (file_exists($composer_autoloader))
{
	require_once $composer_autoloader;
}

// register additional namespace
\spl_autoload_register(function ($class) {
	// project-specific base directories and namespace prefix
	$search = [
		'libraries/jcb_powers/VDM.Joomla.Openai' => 'VDM\\Joomla\\Openai',
		'libraries/jcb_powers/VDM.Joomla.Gitea' => 'VDM\\Joomla\\Gitea',
		'libraries/jcb_powers/VDM.Joomla.FOF' => 'VDM\\Joomla\\FOF',
		'libraries/jcb_powers/VDM.Joomla' => 'VDM\\Joomla',
		'libraries/jcb_powers/VDM.Minify' => 'VDM\\Minify',
		'libraries/jcb_powers/VDM.Psr' => 'VDM\\Psr'
	];
	// Start the search and load if found
	$found = false;
	$found_base_dir = "";
	$found_len = 0;
	foreach ($search as $base_dir => $prefix)
	{
		// does the class use the namespace prefix?
		$len = strlen($prefix);
		if (strncmp($prefix, $class, $len) === 0)
		{
			// we have a match so load the values
			$found = true;
			$found_base_dir = $base_dir;
			$found_len = $len;
			// done here
			break;
		}
	}
	// check if we found a match
	if (!$found)
	{
		// not found so move to the next registered autoloader
		return;
	}
	// get the relative class name
	$relative_class = substr($class, $found_len);
	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append
	// with .php
	$file = JPATH_ROOT . '/' . $found_base_dir . '/src' . str_replace('\\', '/', $relative_class) . '.php';
	// if the file exists, require it
	if (file_exists($file))
	{
		require $file;
	}
});

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\MVC\Controller\BaseController;

// Set the component css/js
Html::_('stylesheet', 'components/com_componentbuilder/assets/css/site.css', ['version' => 'auto']);
Html::_('script', 'components/com_componentbuilder/assets/js/site.js', ['version' => 'auto']);

// Require helper files
JLoader::register('ComponentbuilderHelper', __DIR__ . '/helpers/componentbuilder.php');
JLoader::register('ComponentbuilderEmail', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/componentbuilderemail.php'); 
JLoader::register('ComponentbuilderHelperRoute', __DIR__ . '/helpers/route.php');

//Trigger the Global Site Event
ComponentbuilderHelper::globalEvent(Factory::getDocument());

// Get an instance of the controller prefixed by Componentbuilder
$controller = BaseController::getInstance('Componentbuilder');

// Perform the request task
$controller->execute(Factory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
