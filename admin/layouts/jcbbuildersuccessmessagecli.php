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
use VDM\Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Version;

// No direct access to this file
defined('JPATH_BASE') or die;


function computeZipUrls(): array
{
	$componentUrl = null;
	$moduleUrls   = [];
	$pluginUrls   = [];

	// Component URL
	$componentPath = CompilerFactory::_('FilePaths')->get('component', '');
	if ($componentPath !== '' && ($pos = strpos($componentPath, '/tmp/')) !== false)
	{
		$componentUrl = Uri::root() . substr($componentPath, $pos + 1);
	}

	// Module URLs
	$modules = CompilerFactory::_('FilePaths')->get('modules');
	if (!empty($modules) && is_array($modules))
	{
		foreach ($modules as $moduleId => $modulePath)
		{
			$path = (string) $modulePath;

			if ($path !== '' && ($pos = strpos($path, '/tmp/')) !== false)
			{
				$moduleUrls[(int) $moduleId] = Uri::root() . substr($path, $pos + 1);
			}
		}
	}

	// Plugin URLs
	$plugins = CompilerFactory::_('FilePaths')->get('plugins');
	if (!empty($plugins) && is_array($plugins))
	{
		foreach ($plugins as $pluginId => $pluginPath)
		{
			$path = (string) $pluginPath;

			if ($path !== '' && ($pos = strpos($path, '/tmp/')) !== false)
			{
				$pluginUrls[(int) $pluginId] = Uri::root() . substr($path, $pos + 1);
			}
		}
	}

	return [
		'componentUrl' => $componentUrl,
		'moduleUrls'   => $moduleUrls,
		'pluginUrls'   => $pluginUrls,
	];
}

$urls = computeZipUrls();
$hasPlugins = ArrayHelper::check($urls['pluginUrls'] ?? [], true);
$hasModules = ArrayHelper::check($urls['moduleUrls'] ?? [], true);
$multi = ($hasPlugins || $hasModules);
$componentFolder = CompilerFactory::_('FilePaths')->get('component-folder', '');
$redirect = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
$allowInstall = ((int) (CompilerFactory::_('Config')->joomla_version ?? 0) === (int) Version::MAJOR_VERSION);

/**
 * JCB Compiler Result - CLI Layout
 *
 * This layout produces clean, SymfonyStyle-compatible
 * CLI output with no Markdown or HTML artifacts.
 *
 * @since 5.1.4
 */
$lines = [];

/**
 * Header
 */
if ($multi)
{
	$lines[] = Text::_('COM_COMPONENTBUILDER_THE_EXTENSIONS_WERE_SUCCESSFULLY_COMPILED');
	$lines[] = Text::_('COM_COMPONENTBUILDER_YOU_CAN_INSTALL_OR_DISTRIBUTE_ANY_OF_THE_FOLLOWING_EXTENSIONS');
}
else
{
	$lines[] = Text::sprintf('COM_COMPONENTBUILDER_THE_COMPONENT_S_WAS_SUCCESSFULLY_COMPILED',
		$componentFolder
	);
}

/**
 * Visual separator (CLI-safe)
 */
$lines[] = str_repeat('=', 60);

/**
 * Install buttons (CLI actions / hints)
 */
if ($allowInstall)
{
	$lines[] = LayoutHelper::render('jcbbuilderinstallbuttonscli',
		[
			'has_modules' => $hasModules,
			'has_plugins' => $hasPlugins,
			'multi'       => $multi,
		]
	);
}

/**
 * Statistics section
 */
$lines[] = LayoutHelper::render('jcbbuilderstatssectioncli',
	[]
);

/**
 * Download paths
 */
if ($multi)
{
	$lines[] = LayoutHelper::render('jcbmultipathsdownloadscli',
		[
			'urls' => $urls,
		]
	);
}
else
{
	$lines[] = LayoutHelper::render('jcbsinglepathdownloadcli',
		[
			'url' => $urls['componentUrl'] ?? null,
		]
	);
}

/**
 * Compilation time
 */
$lines[] = sprintf(
	'%s %s %s.',
	Text::_('COM_COMPONENTBUILDER_COMPILATION_TOOK'),
	'#' . '##COMPILER_TIMER##' . '#',
	Text::_('COM_COMPONENTBUILDER_SECONDS_TO_COMPLETE')
);

/**
 * Valuation & costing report
 */
$lines[] = LayoutHelper::render('jcbbuildervaluationandcostingreportcli', []);

?>
<?php echo implode(PHP_EOL . PHP_EOL, array_filter($lines)); ?>
