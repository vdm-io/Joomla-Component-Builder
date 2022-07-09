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
<div id="j-main-container">
	<div class="form-horizontal">
	<?php echo JHtml::_('bootstrap.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'cpanel', JText::_('cPanel', true)); ?>
		<div class="row-fluid">
			<div class="span9">
				<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_left', array('active' => 'main')); ?>
					<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_left', 'Control Panel', 'main'); ?>
						<?php echo $this->loadTemplate('main');?>
					<?php echo JHtml::_('bootstrap.endSlide'); ?>
				<?php echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
			<div class="span3">
				<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_right', array('active' => 'vdm')); ?>
					<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_right', 'Vast Development Method', 'vdm'); ?>
						<?php echo $this->loadTemplate('vdm');?>
					<?php echo JHtml::_('bootstrap.endSlide'); ?>
				<?php echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>


		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'wiki', JText::_('COM_COMPONENTBUILDER_WIKI', true)); ?>
		<div class="row-fluid">
			<div class="span10">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'wiki_accordian', array('active' => 'wiki_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'wiki_accordian', 'Tutorials', 'wiki_one'); ?>
						<?php echo $this->loadTemplate('wiki_tutorials');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
            <div class="span2">
				<?php echo ComponentbuilderHelper::getDynamicContent('banner', '160-600'); ?>
            </div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'notice_board', JText::_('COM_COMPONENTBUILDER_NOTICE_BOARD', true)); ?>
		<div class="row-fluid">
			<div class="span10">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'notice_board_accordian', array('active' => 'notice_board_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'notice_board_accordian', 'Vast Development Method', 'notice_board_one'); ?>
						<?php echo $this->loadTemplate('notice_board_vast_development_method');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
            <div class="span2">
				<?php echo ComponentbuilderHelper::getDynamicContent('banner', '160-600'); ?>
            </div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'readme', JText::_('COM_COMPONENTBUILDER_README', true)); ?>
		<div class="row-fluid">
			<div class="span10">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'readme_accordian', array('active' => 'readme_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'readme_accordian', 'Information', 'readme_one'); ?>
						<?php echo $this->loadTemplate('readme_information');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
            <div class="span2">
				<?php echo ComponentbuilderHelper::getDynamicContent('banner', '160-600'); ?>
            </div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
</div>