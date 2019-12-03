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

JHtml::_('behavior.tooltip');

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
					<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_right', 'Joomla Component Builder', 'vdm'); ?>
						<?php echo $this->loadTemplate('vdm');?>
					<?php echo JHtml::_('bootstrap.endSlide'); ?>
				<?php echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'wiki', JText::_('Wiki', true)); ?>
		<div class="row-fluid">
			<div class="span12">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'wiki_accordian', array('active' => 'wiki_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'wiki_accordian', 'Tutorials', 'wiki_one'); ?>
						<?php echo $this->loadTemplate('wiki_tutorials');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'issues', JText::_('Issues', true)); ?>
		<div class="row-fluid">
			<div class="span12">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'issues_accordian', array('active' => 'issues_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'issues_accordian', 'The open issues on GitHub', 'issues_one'); ?>
						<?php echo $this->loadTemplate('issues_the_open_issues_on_github');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'issues_accordian', 'The closed issues on GitHub', 'issues_two'); ?>
						<?php echo $this->loadTemplate('issues_the_closed_issues_on_github');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'releases', JText::_('Releases', true)); ?>
		<div class="row-fluid">
			<div class="span12">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'releases_accordian', array('active' => 'releases_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'releases_accordian', 'Information', 'releases_one'); ?>
						<?php echo $this->loadTemplate('releases_information');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
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
					<?php  echo JHtml::_('bootstrap.addSlide', 'notice_board_accordian', 'JCB Pro Membership', 'notice_board_two'); ?>
						<?php echo $this->loadTemplate('notice_board_jcb_pro_membership');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
			<div class="span2">
				<?php echo ComponentbuilderHelper::getDynamicContent('banner', '160-600'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'readme', JText::_('Readme', true)); ?>
		<div class="row-fluid">
			<div class="span12">
				<?php  echo JHtml::_('bootstrap.startAccordion', 'readme_accordian', array('active' => 'readme_one')); ?>
					<?php  echo JHtml::_('bootstrap.addSlide', 'readme_accordian', 'Information', 'readme_one'); ?>
						<?php echo $this->loadTemplate('readme_information');?>
					<?php  echo JHtml::_('bootstrap.endSlide'); ?>
				<?php  echo JHtml::_('bootstrap.endAccordion'); ?>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
</div>