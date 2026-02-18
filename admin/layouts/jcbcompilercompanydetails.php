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
<ul class="list-unstyled">
	<li><strong><?php echo Text::_('COM_COMPONENTBUILDER_COMPANY'); ?>:</strong> <?php echo htmlspecialchars($displayData->companyname ?? 'Vast Development Method', ENT_QUOTES); ?></li>
	<li><strong><?php echo Text::_('COM_COMPONENTBUILDER_AUTHOR'); ?>:</strong> <?php echo htmlspecialchars($displayData->author ?? 'Llewellyn van der Merwe', ENT_QUOTES); ?></li>
	<li><strong><?php echo Text::_('COM_COMPONENTBUILDER_EMAIL'); ?>:</strong>
		<a href="mailto:<?php echo htmlspecialchars($displayData->email ?? 'joomla@vdm.io', ENT_QUOTES); ?>">
			<?php echo htmlspecialchars($displayData->email ?? 'joomla@vdm.io', ENT_QUOTES); ?>
		</a>
	</li>
	<li><strong><?php echo Text::_('COM_COMPONENTBUILDER_WEBSITE'); ?>:</strong>
		<a href="<?php echo htmlspecialchars($displayData->website ?? 'https://dev.vdm.io', ENT_QUOTES); ?>" target="_blank" rel="noopener">
			<?php echo htmlspecialchars($displayData->website ?? 'https://dev.vdm.io', ENT_QUOTES); ?>
		</a>
	</li>
</ul>
