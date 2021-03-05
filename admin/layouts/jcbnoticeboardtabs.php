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
defined('JPATH_BASE') or die('Restricted access');



?>
<div id="<?= $displayData['id'] ?>">
	<?= JHtml::_('bootstrap.startTabSet', $displayData['id'] . '_tab', array('active' => $displayData['active'] . '-noticeboard')) ?>
		<?= JHtml::_('bootstrap.addTab', $displayData['id'] . '_tab', 'vdm-noticeboard', JText::_('COM_COMPONENTBUILDER_VDM_BOARD', true)) ?>
			<?= JLayoutHelper::render('jcbnoticeboardvdm', null) ?>
			<div><?php echo ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?></div>
		<?= JHtml::_('bootstrap.endTab'); ?>
		<?= JHtml::_('bootstrap.addTab', $displayData['id'] . '_tab', 'pro-noticeboard', JText::_('COM_COMPONENTBUILDER_JCB_PRO_BOARD', true)) ?>
			<?= JLayoutHelper::render('jcbnoticeboardpro', null) ?>
			<div><?= ComponentbuilderHelper::getDynamicContent('banner', '728-90') ?></div>
		<?= JHtml::_('bootstrap.endTab') ?>
	<?= JHtml::_('bootstrap.endTabSet') ?>
</div>
