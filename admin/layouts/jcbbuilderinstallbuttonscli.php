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

/**
 * JCB Compiler - Install Actions (CLI)
 *
 * SymfonyStyle-friendly CLI layout.
 * No Markdown. No HTML. Clean, deterministic output.
 *
 * @since 5.1.4
 */
$lines = [];

/**
 * Section header
 */
$lines[] = Text::_('COM_COMPONENTBUILDER_INSTALL_ACTIONS');
$lines[] = str_repeat('-', 60);

/**
 * Intro
 */
$lines[] = Text::_('COM_COMPONENTBUILDER_THE_FOLLOWING_INSTALL_OPTIONS_ARE_AVAILABLE_IN_THE_GUI');
$lines[] = '';

/**
 * Component
 */
$lines[] = Text::sprintf('COM_COMPONENTBUILDER_COMPONENT_INSTALL_S_ON_THIS_JOOMLA_WEBSITE_COMPONENT',
	$component
);

/**
 * Modules
 */
if (!empty($displayData['has_modules']) && !empty($modules))
{
	$lines[] = '';
	$lines[] = Text::_('COM_COMPONENTBUILDER_MODULES');

	foreach ($modules as $moduleFolder)
	{
		$lines[] = Text::sprintf('COM_COMPONENTBUILDER__INSTALL_S_ON_THIS_JOOMLA_WEBSITE_MODULE',
			$moduleFolder
		);
	}
}

/**
 * Plugins
 */
if (!empty($displayData['has_plugins']) && !empty($plugins))
{
	$lines[] = '';
	$lines[] = Text::_('COM_COMPONENTBUILDER_PLUGINS');

	foreach ($plugins as $pluginFolder)
	{
		$lines[] = Text::sprintf('COM_COMPONENTBUILDER__INSTALL_S_ON_THIS_JOOMLA_WEBSITE_PLUGIN',
			$pluginFolder
		);
	}
}

/**
 * Multi-install option
 */
if (!empty($displayData['multi']))
{
	$lines[] = '';
	$lines[] = Text::_('COM_COMPONENTBUILDER_ALL_EXTENSIONS');
	$lines[] = Text::_('COM_COMPONENTBUILDER__INSTALL_ALL_COMPILED_EXTENSIONS_ON_THIS_JOOMLA_WEBSITE');
}

?>
<?php echo implode(PHP_EOL, $lines); ?>
