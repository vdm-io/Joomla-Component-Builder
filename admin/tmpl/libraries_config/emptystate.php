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

use Joomla\CMS\Layout\LayoutHelper;

// No direct access to this file
defined('_JEXEC') or die;

$displayData = [
	'textPrefix' => 'COM_COMPONENTBUILDER_LIBRARIES_CONFIG',
	'formURL'    => 'index.php?option=com_componentbuilder&view=libraries_config',
	'icon'       => 'icon-joomla',
];

if ($this->user->authorise('library_config.create', 'com_componentbuilder'))
{
	$displayData['createURL'] = 'index.php?option=com_componentbuilder&task=library_config.add';
}

echo LayoutHelper::render('joomla.content.emptystate', $displayData);
