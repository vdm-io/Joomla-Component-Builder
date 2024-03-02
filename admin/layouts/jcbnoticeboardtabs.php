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
defined('JPATH_BASE') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;



?>
<div id="<?php echo  $displayData['id']; ?>">
	<?php echo Html::_('bootstrap.startTabSet', $displayData['id'] . '_tab', array('active' => $displayData['active'] . '-noticeboard')); ?>
		<?php echo Html::_('bootstrap.addTab', $displayData['id'] . '_tab', 'vdm-noticeboard', Text::_('COM_COMPONENTBUILDER_VDM_BOARD', true)); ?>
			<?php echo LayoutHelper::render('jcbnoticeboardvdm', null); ?>
			<div><?php echo ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?></div>
		<?php echo Html::_('bootstrap.endTab'); ?>
		<?php echo Html::_('bootstrap.addTab', $displayData['id'] . '_tab', 'pro-noticeboard', Text::_('COM_COMPONENTBUILDER_JCB_PRO_BOARD', true)); ?>
			<?php echo LayoutHelper::render('jcbnoticeboardpro', null); ?>
			<div><?php echo  ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?></div>
		<?php echo Html::_('bootstrap.endTab'); ?>
	<?php echo Html::_('bootstrap.endTabSet'); ?>
</div>
