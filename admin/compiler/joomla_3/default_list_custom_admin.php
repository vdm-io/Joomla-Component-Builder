<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');###LICENSE_LOCKED_DEFINED### ###CUSTOM_ADMIN_CODE_BODY###

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
?>
<?php if ($this->canDo->get('###sview###.access')): ?>###CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT###
<form action="<?php echo JRoute::_('index.php?option=com_###component###&view=###sviews###'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
        <input type="hidden" name="task" value="" />###HIDDEN_INPUT_VALUES###
        <?php echo JHtml::_('form.token'); ?>
</form>###CUSTOM_ADMIN_BODY###
<?php else: ?>
        <h1><?php echo JText::_('COM_###COMPONENT###_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
