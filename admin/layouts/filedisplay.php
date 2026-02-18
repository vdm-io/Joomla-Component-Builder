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

$images = [];

?>
<?php if (!empty($displayData) && !empty($displayData['data'])): ?>
	<ul class="uk-list uk-list-divider">
		<?php foreach ($displayData['data'] as $file): ?>
		<?php if ($file->task == 'image'): ?>
		<?php $images[] =  $file; ?>
		<?php else: ?>
		<li>
		<div id="<?php echo $file->guid; ?>" class="uk-button-group uk-width-1-1 uk-margin-small-bottom">
			<a class="uk-button uk-button-primary uk-width-3-4" href="<?php echo $file->link; ?>" download>(<?php echo $file->type_name; ?>) <?php echo $file->name; ?></a>
			<button type="button" class="uk-button uk-button-secondary uk-width-1-4" uk-icon="trash" onclick="VDMDeleteFile('file_vdm_uploader', '<?php echo $file->guid; ?>');"></button>
		</div>
		</li>
		<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<?php if ($images !== []): ?>
		<ul class="uk-list uk-list-divider">
			<?php foreach ($images as $file): ?>
			<li>
			<div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="<?php echo $file->link; ?>" uk-img>
			<h1><?php echo $file->type_name; ?></h1>
			</div>
			<div id="<?php echo $file->guid; ?>" class="uk-button-group uk-width-1-1 uk-margin-small-bottom">
				<a class="uk-button uk-button-primary uk-width-3-4" href="<?php echo $file->link; ?>" download>(<?php echo $file->type_name; ?>) <?php echo $file->name; ?></a>
				<button type="button" class="uk-button uk-button-secondary uk-width-1-4" uk-icon="trash" onclick="VDMDeleteFile('file_vdm_uploader', '<?php echo $file->guid; ?>');"></button>
			</div>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
<?php endif; ?>
