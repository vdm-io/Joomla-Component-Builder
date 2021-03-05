<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');###LICENSE_LOCKED_DEFINED###

###ADMIN_VIEWS_HEADER###
if ($this->saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_###component###&task=###views###.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', '###view###List', 'adminForm', strtolower($this->listDirn), $saveOrderingUrl);
}
?>
###VIEWS_DEFAULT_BODY######VIEWS_FOOTER_SCRIPT###
