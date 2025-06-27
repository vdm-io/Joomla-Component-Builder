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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper as Html;

// No direct access to this file
defined('_JEXEC') or die;

$headers = [
	'AdminView' => 'COM_COMPONENTBUILDER_INITIALIZE_ADMIN_VIEWS',
	'Component' => 'COM_COMPONENTBUILDER_INITIALIZE_COMPONENTS',
	'CustomAdminView' => 'COM_COMPONENTBUILDER_INITIALIZE_CUSTOM_ADMIN_VIEWS',
	'CustomCode' => 'COM_COMPONENTBUILDER_INITIALIZE_CUSTOM_CODES',
	'DynamicGet' => 'COM_COMPONENTBUILDER_INITIALIZE_DYNAMIC_GETS',
	'Field' =>  'COM_COMPONENTBUILDER_INITIALIZE_FIELDS',
	'Joomla.Fieldtype' => 'COM_COMPONENTBUILDER_INITIALIZE_FIELD_TYPES',
	'Joomla.Power' => 'COM_COMPONENTBUILDER_INITIALIZE_JOOMLA_POWERS',
	'Layout' => 'COM_COMPONENTBUILDER_INITIALIZE_LAYOUTS',
	'Library' => 'COM_COMPONENTBUILDER_INITIALIZE_LIBRARIES',
	'JoomlaModule' => 'COM_COMPONENTBUILDER_INITIALIZE_MODULES',
	'JoomlaPlugin' => 'COM_COMPONENTBUILDER_INITIALIZE_PLUGINS',
	'Power' => 'COM_COMPONENTBUILDER_INITIALIZE_POWERS',
	'SiteView' => 'COM_COMPONENTBUILDER_INITIALIZE_SITE_VIEWS',
	'Snippet' => 'COM_COMPONENTBUILDER_INITIALIZE_SNIPPETS',
	'Template' => 'COM_COMPONENTBUILDER_INITIALIZE_TEMPLATES',
	'ClassExtends' => 'COM_COMPONENTBUILDER_INITIALIZE_CLASS_EXTENDS',
	'ClassProperty' => 'COM_COMPONENTBUILDER_INITIALIZE_CLASS_PROPERTIES',
	'ClassMethod' => 'COM_COMPONENTBUILDER_INITIALIZE_CLASS_METHODS',
	'Placeholder' => 'COM_COMPONENTBUILDER_INITIALIZE_PLACEHOLDERS',
	'Repository' => 'COM_COMPONENTBUILDER_INITIALIZE_REPOSITORIES'
];

// Fetch and translate header if area is defined and mapped
$area = $this->item['area_class'] ?? null;
$header = $area && isset($headers[$area]) ? $headers[$area] : 'COM_COMPONENTBUILDER_SELECTION_FAILED_PLEASE_TRY_AGAIN';

?>
<h1><?php echo Text::_($header); ?></h1>
