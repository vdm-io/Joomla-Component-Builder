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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
defined('_JEXEC') or die;

?>
<div id="j-main-container">
	<div class="main-card">
	<?php echo Html::_('uitab.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>

		<?php echo Html::_('uitab.addTab', 'cpanel_tab', 'cpanel', Text::_('cPanel', true)); ?>
		<div class="row">
			<div class="col-md-9">
				<?php echo $this->loadTemplate('main');?>
			</div>
			<div class="col-md-3">
				<?php echo $this->loadTemplate('vdm');?>
			</div>
		</div>
		<?php echo Html::_('uitab.endTab'); ?>

		<?php echo Html::_('uitab.addTab', 'cpanel_tab', 'wiki', Text::_('Wiki', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->loadTemplate('wiki_tutorials');?>
			</div>
		</div>
		<?php echo Html::_('uitab.endTab'); ?>

		<?php echo Html::_('uitab.addTab', 'cpanel_tab', 'notice_board', Text::_('Notice Board', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->loadTemplate('notice_board_vast_development_method');?>
			</div>
		</div>
		<?php echo Html::_('uitab.endTab'); ?>

		<?php echo Html::_('uitab.addTab', 'cpanel_tab', 'readme', Text::_('Readme', true)); ?>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->loadTemplate('readme_information');?>
			</div>
		</div>
		<?php echo Html::_('uitab.endTab'); ?>

	<?php echo Html::_('uitab.endTabSet'); ?>
	</div>
</div>