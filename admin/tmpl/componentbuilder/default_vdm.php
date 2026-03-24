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

use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\ArrayHelper;

// No direct access to this file
defined('_JEXEC') or die;

?>
<div class="com-componentbuilder-dashboard-details">
	<div class="com-componentbuilder-dashboard-details__image mb-4">
		<img
			class="img-fluid w-100"
			alt="<?php echo Text::_('COM_COMPONENTBUILDER'); ?>"
			src="components/com_componentbuilder/assets/images/vdm-component.jpg"
			loading="lazy"
			decoding="async"
		>
	</div>
	<ul class="list-group list-group-flush mb-4">
		<li class="list-group-item d-flex flex-wrap justify-content-between gap-2">
			<span>
				<strong><?php echo Text::_('COM_COMPONENTBUILDER_VERSION'); ?>:</strong>
				<?php echo $this->manifest->version; ?>
			</span>
			<span class="update-notice" id="component-update-notice"></span>
		</li>
		<li class="list-group-item">
			<strong><?php echo Text::_('COM_COMPONENTBUILDER_DATE'); ?>:</strong>
			<?php echo $this->manifest->creationDate; ?>
		</li>
		<li class="list-group-item">
			<strong><?php echo Text::_('COM_COMPONENTBUILDER_AUTHOR'); ?>:</strong>
			<a href="mailto:<?php echo $this->manifest->authorEmail; ?>">
				<?php echo $this->manifest->author; ?>
			</a>
		</li>
		<li class="list-group-item">
			<strong><?php echo Text::_('COM_COMPONENTBUILDER_WEBSITE'); ?>:</strong>
			<a
				href="<?php echo $this->manifest->authorUrl; ?>"
				target="_blank"
				rel="noopener noreferrer"
			>
				<?php echo $this->manifest->authorUrl; ?>
			</a>
		</li>
		<li class="list-group-item">
			<strong><?php echo Text::_('COM_COMPONENTBUILDER_LICENSE'); ?>:</strong>
			<?php echo $this->manifest->license; ?>
		</li>
		<li class="list-group-item">
			<strong><?php echo $this->manifest->copyright; ?></strong>
		</li>
	</ul>
	<?php if (ArrayHelper::check($this->contributors)) : ?>
		<div class="com-componentbuilder-dashboard-details__contributors mt-4">
			<h3 class="h5 mb-3">
				<?php if (count($this->contributors) > 1) : ?>
					<?php echo Text::_('COM_COMPONENTBUILDER_CONTRIBUTORS'); ?>
				<?php else : ?>
					<?php echo Text::_('COM_COMPONENTBUILDER_CONTRIBUTOR'); ?>
				<?php endif; ?>
			</h3>
			<ul class="list-group list-group-flush">
				<?php foreach ($this->contributors as $contributor) : ?>
					<li class="list-group-item">
						<strong><?php echo $contributor['title']; ?>:</strong>
						<?php echo $contributor['name']; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</div>