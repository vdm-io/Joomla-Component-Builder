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
<div id="noticeboard">
	<?php echo LayoutHelper::render('mastodon', $displayData ?? []); ?>
</div>
<?php echo LayoutHelper::render('socialnetworking', null); ?>
<div class="p-md-3"><?php if (!empty($displayData['dankie']) && $displayData['dankie'] == 2): ?>
<?php echo LayoutHelper::render('jcbsupportmessage', []); ?><?php else: ?>
<?php echo ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?><?php endif; ?>
</div>
