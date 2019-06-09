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

/**
 * Componentbuilder Component Category Tree
 */

//Insure this view category file is loaded.
$classname = 'ComponentbuilderFieldsCategories';
if (!class_exists($classname))
{
	$path = JPATH_SITE . '/components/com_componentbuilder/helpers/categoryfields.php';
	if (is_file($path))
	{
		include_once $path;
	}
}
//Insure this view category file is loaded.
$classname = 'ComponentbuilderFieldtypesCategories';
if (!class_exists($classname))
{
	$path = JPATH_SITE . '/components/com_componentbuilder/helpers/categoryfieldtypes.php';
	if (is_file($path))
	{
		include_once $path;
	}
}
