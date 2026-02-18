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


$cUrl  = $displayData['urls']['componentUrl'] ?? null;
$cPath = CompilerFactory::_('FilePaths')->get('component');

$modules = CompilerFactory::_('FilePaths')->get('modules', []);
$modules_folders = CompilerFactory::_('FilePaths')->get('modules-folder', []);

$plugins = CompilerFactory::_('FilePaths')->get('plugins', []);
$plugins_folders = CompilerFactory::_('FilePaths')->get('plugins-folder', []);

/**
 * JCB Compiler - Package Paths & URLs (CLI)
 *
 * SymfonyStyle-compatible CLI layout.
 * Plain text output, no Markdown or HTML artifacts.
 *
 * @since 5.1.4
 */
$lines = [];

if (!empty($cPath))
{
	/**
	 * Section header
	 */
	$lines[] = Text::_('COM_COMPONENTBUILDER_PACKAGE_PATHS');
	$lines[] = str_repeat('-', 60);

	/**
	 * Component
	 */
	$lines[] = Text::_('COM_COMPONENTBUILDER_COMPONENT');
	$lines[] = sprintf(
		'  %s: %s',
		Text::_('COM_COMPONENTBUILDER_PATH'),
		$cPath
	);

	/**
	 * Modules
	 */
	if (!empty($modules) && is_array($modules))
	{
		$lines[] = '';
		$lines[] = Text::_('COM_COMPONENTBUILDER_MODULES');

		foreach ($modules as $moduleId => $modulePath)
		{
			$lines[] = sprintf(
				'  %s: %s',
				Text::_('COM_COMPONENTBUILDER_PATH'),
				$modulePath
			);
		}
	}

	/**
	 * Plugins
	 */
	if (!empty($plugins) && is_array($plugins))
	{
		$lines[] = '';
		$lines[] = Text::_('COM_COMPONENTBUILDER_PLUGINS');

		foreach ($plugins as $pluginId => $pluginPath)
		{
			$lines[] = sprintf(
				'  %s: %s',
				Text::_('COM_COMPONENTBUILDER_PATH'),
				$pluginPath
			);
		}
	}

	/**
	 * Note
	 */
	$lines[] = '';
	$lines[] = Text::_('COM_COMPONENTBUILDER_NOTE_THESE_ZIP_FILES_ARE_STORED_IN_YOUR_TMP_FOLDER_AND_MAY_BE_PUBLICLY_ACCESSIBLE_UNTIL_YOU_CLEAR_TMP');
}
else
{
	/**
	 * Error case
	 */
	$lines[] = Text::_('COM_COMPONENTBUILDER_ERROR_THE_EXTENSIONS_WERE_NOT_COMPILED');
}

?>
<?php echo implode(PHP_EOL, $lines); ?>
