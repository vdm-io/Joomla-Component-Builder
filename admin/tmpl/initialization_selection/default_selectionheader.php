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
	'AdminView' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESADMIN_VIEWSA',
	'Component' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESCOMPONENTSA',
	'CustomAdminView' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESCUSTOM_ADMIN_VIEWSA',
	'CustomCode' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESCUSTOM_CODESA',
	'DynamicGet' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESDYNAMIC_GETSA',
	'Field' =>  'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESFIELDSA',
	'Joomla.Fieldtype' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESFIELD_TYPESA',
	'Joomla.Power' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESJOOMLA_POWERSA',
	'Layout' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESLAYOUTSA',
	'Library' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESLIBRARIESA',
	'JoomlaModule' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESMODULESA',
	'JoomlaPlugin' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESPLUGINSA',
	'Power' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESPOWERSA',
	'SiteView' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESSITE_VIEWSA',
	'Snippet' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESSNIPPETSA',
	'Template' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESTEMPLATESA',
	'ClassExtends' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESCLASS_EXTENDSA',
	'ClassProperty' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESCLASS_PROPERTIESA',
	'ClassMethod' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESCLASS_METHODSA',
	'Placeholder' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESPLACEHOLDERSA',
	'Repository' => 'COM_COMPONENTBUILDER_INITIALIZE_A_HREFS_TITLESREPOSITORIESA'
];

// Fetch and translate header if area is defined and mapped
$area = $this->item['area_class'] ?? null;
$list_view = $this->item['list_view'] ?? 'joomla_components';
$area_name = $this->item['area_name'] ?? 'Joomla Component';
$title = '"' . Text::sprintf('COM_COMPONENTBUILDER_GO_BACK_TO_S_LIST_VIEW', $area_name) . '"';
$href = sprintf('"index.php?option=com_componentbuilder&view=%s"', $list_view);
$header = $area && isset($headers[$area]) ? $headers[$area] : 'COM_COMPONENTBUILDER_SELECTION_FAILED_PLEASE_TRY_AGAIN';

?>
<h1><?php echo Text::sprintf($header, $href, $title); ?></h1>
