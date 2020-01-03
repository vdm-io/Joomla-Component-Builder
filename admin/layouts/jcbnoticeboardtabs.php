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
defined('JPATH_BASE') or die('Restricted access');



?>
<div id="noticeboard">
	<?php echo JHtml::_('bootstrap.startTabSet', 'compiler_tab', array('active' => 'vdm-noticeboard')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'compiler_tab', 'vdm-noticeboard', JText::_('COM_COMPONENTBUILDER_VDM_BOARD', true)); ?>
			<div  class="well well-small">
				<h2 class="module-title nav-header"><?php echo JText::_('COM_COMPONENTBUILDER_VDM_NOTICE_BOARD'); ?><span id="vdm-new-notice" style="display:none; color:red;"> (<?php echo JText::_('COM_COMPONENTBUILDER_NEW_NOTICE'); ?>)</span></h2>
				<div id="noticeboard-md"><small><?php echo JText::_('COM_COMPONENTBUILDER_THE_NOTICE_BOARD_IS_LOADING'); ?><span class="loading-dots">.</span></small></div>
				<div style="text-align:right;"><small><a href="https://github.com/Llewellynvdm" target="_blank" style="color:gray">&lt;&lt;ewe&gt;&gt;yn</a></small></div>
			</div>
			<div><?php echo ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?></div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'compiler_tab', 'proboard', JText::_('COM_COMPONENTBUILDER_JCB_PRO_BOARD', true)); ?>
			<div  class="well well-small">
				<h2 class="module-title nav-header"><?php echo JText::_('COM_COMPONENTBUILDER_JCB_PRO_NOTICE_BOARD'); ?></h2>
				<div id="proboard-md"><small><?php echo JText::_('COM_COMPONENTBUILDER_THE_PRO_BOARD_IS_LOADING'); ?><span class="loading-dots">.</span></small></div>
				<div style="text-align:right;"><small><a href="https://vdm.bz/get-jcb-pro-membership" target="_blank" style="color:gray">JCB PRO</a></small></div>
			</div>
			<div><?php echo ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?></div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php echo JHtml::_('bootstrap.endTabSet'); ?>
</div>
