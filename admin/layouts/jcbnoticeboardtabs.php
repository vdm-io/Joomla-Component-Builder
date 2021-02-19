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
<div id="<?= $displayData ?>">
	<?= JHtml::_('bootstrap.startTabSet', $displayData . '_tab', array('active' => 'vdm-noticeboard')) ?>
		<?= JHtml::_('bootstrap.addTab', $displayData . '_tab', 'vdm-noticeboard', JText::_('COM_COMPONENTBUILDER_VDM_BOARD', true)) ?>
			<?= JLayoutHelper::render('jcbnoticeboardvdm', null) ?>
			<div class="jcb-sponsor-banner"><?php echo ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?></div>
		<?= JHtml::_('bootstrap.endTab'); ?>
		<?= JHtml::_('bootstrap.addTab', $displayData . '_tab', 'proboard', JText::_('COM_COMPONENTBUILDER_JCB_PRO_BOARD', true)) ?>
			<?= JLayoutHelper::render('jcbnoticeboardpro', null) ?>
			<div class="jcb-sponsor-banner"><?= ComponentbuilderHelper::getDynamicContent('banner', '728-90') ?></div>
		<?= JHtml::_('bootstrap.endTab') ?>
	<?= JHtml::_('bootstrap.endTabSet') ?>
</div>
