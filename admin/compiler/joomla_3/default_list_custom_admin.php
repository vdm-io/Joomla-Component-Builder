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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');###LICENSE_LOCKED_DEFINED###

###CUSTOM_ADMIN_VIEWS_HEADER######CUSTOM_ADMIN_CODE_BODY###
?>
<?php if ($this->canDo->get('###sview###.access')): ?>###CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT###
###CUSTOM_ADMIN_TOP_FORM######CUSTOM_ADMIN_BODY######CUSTOM_ADMIN_BOTTOM_FORM###
<?php else: ?>
		<h1><?php echo Text::_('COM_###COMPONENT###_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
