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

/**
 * Componentbuilder Component Category Tree
 */

//Insure this view category file is loaded.
$classname = 'ComponentbuilderFieldCategories';
if (!class_exists($classname))
{
	$path = JPATH_SITE . '/components/com_componentbuilder/helpers/categoryfield.php';
	if (is_file($path))
	{
		include_once $path;
	}
}
//Insure this view category file is loaded.
$classname = 'ComponentbuilderFieldtypeCategories';
if (!class_exists($classname))
{
	$path = JPATH_SITE . '/components/com_componentbuilder/helpers/categoryfieldtype.php';
	if (is_file($path))
	{
		include_once $path;
	}
}
