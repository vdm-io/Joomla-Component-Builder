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
use Joomla\CMS\Layout\LayoutHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
defined('JPATH_BASE') or die;



?>
<div  class="well well-small">
	<h2 class="module-title nav-header"><?= Text::_('COM_COMPONENTBUILDER_VDM_NOTICE_BOARD') ?><span class="vdm-new-notice" style="display:none; color:red;"> (<?= Text::_('COM_COMPONENTBUILDER_NEW_NOTICE') ?>)</span></h2>
	<div class="noticeboard-md"><small><?= Text::_('COM_COMPONENTBUILDER_THE_NOTICE_BOARD_IS_LOADING') ?><span class="loading-dots">.</span></small></div>
	<div style="text-align:right;"><small><a href="https://github.com/Llewellynvdm" target="_blank" style="color:gray">&lt;&lt;ewe&gt;&gt;yn</a></small></div>
</div>
