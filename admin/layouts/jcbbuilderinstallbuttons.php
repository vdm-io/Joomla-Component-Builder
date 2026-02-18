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
use VDM\Joomla\Componentbuilder\Compiler\Factory as CompilerFactory;

// No direct access to this file
defined('JPATH_BASE') or die;


$component = CompilerFactory::_('FilePaths')->get('component-folder', '');
$modules = CompilerFactory::_('FilePaths')->get('modules-folder', []);
$plugins = CompilerFactory::_('FilePaths')->get('plugins-folder', []);

?>
<div class="btn-toolbar" role="toolbar">
	<div class="btn-group" role="group">
		<button type="button" class="btn btn-success btn-small btn-sm" onclick="Joomla.submitbutton('compiler.installCompiledComponent')">
			<?php echo Text::sprintf('COM_COMPONENTBUILDER_INSTALL_S_ON_THIS', $component); ?> <span class="icon-joomla icon-white"></span> <?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_WEBSITE'); ?>. (component)
		</button>
		<?php if ($displayData['has_modules'] && !empty($modules)): ?>
		<?php foreach ($modules as $moduleId => $moduleFolder): ?>
		<?php $mid = (int) $moduleId; ?>
		<button type="button" class="btn btn-success btn-small btn-sm" onclick="Joomla.submitbutton('compiler.installCompiledModule', <?php echo $mid; ?>)">
			<?php echo Text::sprintf('COM_COMPONENTBUILDER_INSTALL_S_ON_THIS', $moduleFolder); ?> <span class="icon-joomla icon-white"></span> <?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_WEBSITE'); ?>. (module)
		</button>
		<?php endforeach; ?>
		<?php endif; ?>
		<?php if ($displayData['has_plugins'] && !empty($plugins)): ?>
		<?php foreach ($plugins as $pluginId => $pluginFolder): ?>
		<?php $pid = (int) $pluginId; ?>
		<button type="button" class="btn btn-success btn-small btn-sm" onclick="Joomla.submitbutton('compiler.installCompiledPlugin', <?php echo $pid; ?>)">
			<?php echo Text::sprintf('COM_COMPONENTBUILDER_INSTALL_S_ON_THIS', $pluginFolder); ?> <span class="icon-joomla icon-white"></span> <?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_WEBSITE'); ?>. (plugin)
		</button>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>
<?php if ($displayData['multi']): ?>
<h4><?php echo Text::_('COM_COMPONENTBUILDER_YOU_CAN_INSTALL_ALL_COMPILED_EXTENSIONS'); ?></h4>
<div class="btn-toolbar" role="toolbar">
	<div class="btn-group" role="group">
		<button type="button" class="btn btn-success btn-small btn-sm" onclick="Joomla.submitbutton('compiler.installCompiledExtensions')">
			<?php echo Text::_('COM_COMPONENTBUILDER_INSTALL_ALL_ABOVE_EXTENSIONS_ON_THIS'); ?> <span class="icon-joomla icon-white"></span> <?php echo Text::_('COM_COMPONENTBUILDER_JOOMLA_WEBSITE'); ?>.
		</button>
	</div>
</div>
<?php endif; ?>
