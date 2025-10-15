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
use VDM\Joomla\Utilities\ArrayHelper;

// No direct access to this file
defined('JPATH_BASE') or die;

$cPath = $displayData['model']->compiler->filepath['component'] ?? null;
$cUrl  = $displayData['urls']['componentUrl'] ?? null;

?>
<?php if (!empty($cUrl) && !empty($cPath)): ?>
<h2><?php echo Text::_('COM_COMPONENTBUILDER_PATH_TO_ZIP_FILES'); ?></h2>
<p>
	<b><?php echo Text::_('COM_COMPONENTBUILDER_COMPONENT_PATH'); ?>:</b>
	<?php if ($cPath): ?>
		<code><?php echo $cPath; ?></code>
	<?php endif; ?>
	<br>
	<b><?php echo Text::_('COM_COMPONENTBUILDER_COMPONENT_URL'); ?>:</b> <code><?php echo $cUrl; ?></code>
	<br><br>
	<?php if (!empty($displayData['model']->compiler->filepath['modules']) && is_array($displayData['model']->compiler->filepath['modules'])): ?>
		<?php foreach ($displayData['model']->compiler->filepath['modules'] as $moduleId => $modulePath): ?>
			<b><?php echo Text::_('COM_COMPONENTBUILDER_MODULE_PATH'); ?>:</b> <code><?php echo $modulePath; ?></code>
			<br>
			<?php $mUrl = $displayData['urls']['moduleUrls'][$moduleId] ?? 'error'; ?>
			<b><?php echo Text::_('COM_COMPONENTBUILDER_MODULE_URL'); ?>:</b> <code><?php echo $mUrl; ?></code>
			<br>
		<?php endforeach; ?>
	<?php endif; ?>
	<?php if (!empty($displayData['model']->compiler->filepath['plugins']) && is_array($displayData['model']->compiler->filepath['plugins'])): ?>
		<?php foreach ($displayData['model']->compiler->filepath['plugins'] as $pluginId => $pluginPath): ?>
			<b><?php echo Text::_('COM_COMPONENTBUILDER_PLUGIN_PATH'); ?>:</b> <code><?php echo $pluginPath; ?></code>
			<br>
			<?php $pUrl = $displayData['urls']['pluginUrls'][$pluginId] ?? 'error'; ?>
			<b><?php echo Text::_('COM_COMPONENTBUILDER_PLUGIN_URL'); ?>:</b> <code><?php echo $pUrl; ?></code>
			<br>
		<?php endforeach; ?>
	<?php endif; ?>
</p>
<p><small><?php echo Text::_('COM_COMPONENTBUILDER_HEY_YOU_CAN_ALSO_DOWNLOAD_THESE_ZIP_FILES_RIGHT_NOW'); ?></small></p>
<div class="btn-toolbar" role="toolbar">
	<div class="btn-group" role="group">
		<?php if (!empty($cUrl)): ?>
			<a class="btn btn-success btn-small btn-sm" href="<?php echo $cUrl; ?>"><span class="icon-download icon-white"></span> <?php echo Text::_('COM_COMPONENTBUILDER_DOWNLOAD_COMPONENT'); ?></a>
		<?php endif; ?>
		<?php if (!empty($displayData['urls']['moduleUrls']) && ArrayHelper::check($displayData['urls']['moduleUrls'])): ?>
			<?php foreach ($displayData['urls']['moduleUrls'] as $moduleId => $moduleUrl): ?>
				<?php $label = $displayData['model']->compiler->filepath['modules-folder'][$moduleId] ?? 'error'; ?>
				<a class="btn btn-success btn-small btn-sm" href="<?php echo $moduleUrl; ?>"><span class="icon-download icon-white"></span> <?php echo Text::sprintf('COM_COMPONENTBUILDER_DOWNLOAD_S', $label); ?></a>
			<?php endforeach; ?>
		<?php endif; ?>
		<?php if (!empty($displayData['urls']['pluginUrls']) && ArrayHelper::check($displayData['urls']['pluginUrls'])): ?>
			<?php foreach ($displayData['urls']['pluginUrls'] as $pluginId => $pluginUrl): ?>
				<?php $label = $displayData['model']->compiler->filepath['plugins-folder'][$pluginId] ?? 'error'; ?>
				<a class="btn btn-success btn-small btn-sm" href="<?php echo $pluginUrl; ?>"><span class="icon-download icon-white"></span> <?php echo Text::sprintf('COM_COMPONENTBUILDER_DOWNLOAD_S', $label); ?></a>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
<p>
	<small><b><?php echo Text::_('COM_COMPONENTBUILDER_REMEMBERB_THESE_ZIP_FILES_ARE_IN_YOUR_TMP_FOLDER_AND_THEREFORE_PUBLICLY_ACCESSIBLE_UNTIL_YOU_CLICK_CLEAR_TMP'); ?>!</small>
</p>
<?php else: ?>
<div class="alert alert-danger" role="alert">
	<h4><?php echo Text::_('COM_COMPONENTBUILDER_THERE_WAS_AN_ERROR'); ?>!</h4>
	<p><?php echo Text::_('COM_COMPONENTBUILDER_THE_EXTENSIONS_WERE_NOT_COMPILED'); ?></p>
</div>
<?php endif; ?>
