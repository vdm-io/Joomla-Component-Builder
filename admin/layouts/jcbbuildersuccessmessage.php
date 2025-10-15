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
use VDM\Joomla\Componentbuilder\Compiler\Factory as CompilerFactory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Version;

// No direct access to this file
defined('JPATH_BASE') or die;

function computeZipUrls(object $model): array
{
	$componentUrl = null;
	$moduleUrls   = [];
	$pluginUrls   = [];

	// Component URL
	$componentPath = $model->compiler->filepath['component'] ?? '';
	if ($componentPath !== '' && ($pos = strpos($componentPath, '/tmp/')) !== false)
	{
		$componentUrl = Uri::root() . substr($componentPath, $pos + 1);
	}

	// Module URLs
	if (!empty($model->compiler->filepath['modules']) && is_array($model->compiler->filepath['modules']))
	{
		foreach ($model->compiler->filepath['modules'] as $moduleId => $modulePath)
		{
			$path = (string) $modulePath;

			if ($path !== '' && ($pos = strpos($path, '/tmp/')) !== false)
			{
				$moduleUrls[(int) $moduleId] = Uri::root() . substr($path, $pos + 1);
			}
		}
	}

	// Plugin URLs
	if (!empty($model->compiler->filepath['plugins']) && is_array($model->compiler->filepath['plugins']))
	{
		foreach ($model->compiler->filepath['plugins'] as $pluginId => $pluginPath)
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

$urls = computeZipUrls($displayData);
$hasPlugins = ArrayHelper::check($displayData->compiler->filepath['plugins'] ?? [], true);
$hasModules = ArrayHelper::check($displayData->compiler->filepath['modules'] ?? [], true);
$multi = ($hasPlugins || $hasModules);
$componentFolder = $displayData->compiler->filepath['component-folder'] ?? '';
$redirect = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
$allowInstall = ((int) (CompilerFactory::_('Config')->joomla_version ?? 0) === (int) Version::MAJOR_VERSION);


?>
<style>
	/* Scope defensively inside the compiler success message container if present */
	.com-componentbuilder-compiler-success :where(.btn) {
		margin-right: .5rem;
		margin-bottom: .5rem;
	}

	/* Back-compat: keep both .btn-small and .btn-sm usable */
	.com-componentbuilder-compiler-success .btn-small { padding: .25rem .5rem; font-size: .875rem; }

	/* Ensure success buttons have readable text in both themes */
	.com-componentbuilder-compiler-success .btn-success,
	.com-componentbuilder-compiler-success .btn.btn-success {
		color: #fff !important;
	}

	/* Joomla 5 dark mode compatibility (data-bs-theme="dark") */
	[data-bs-theme="dark"] .com-componentbuilder-compiler-success .btn-success {
		color: #fff !important;
	}

	/* Organize button groups cleanly */
	.com-componentbuilder-compiler-success .btn-toolbar {
		display: flex;
		flex-wrap: wrap;
		gap: .5rem .75rem;
		margin: .5rem 0 1rem 0;
	}

	.com-componentbuilder-compiler-success .btn-group {
		display: flex;
		flex-wrap: wrap;
		gap: .5rem .5rem;
	}

	/* Code blocks line-wrap paths nicely */
	.com-componentbuilder-compiler-success code {
		white-space: pre-wrap;
		word-break: break-all;
	}
</style>
<div class="com-componentbuilder-compiler-success">
	<?php if ($multi): ?>
		<h1><?php echo Text::_('COM_COMPONENTBUILDER_THE_EXTENSIONS_WERE_SUCCESSFULLY_COMPILED'); ?></h1>
		<h4><?php echo Text::_('COM_COMPONENTBUILDER_YOU_CAN_INSTALL_ANY_ONE_OF_THE_FOLLOWING_EXTENSIONS'); ?></h4>
	<?php else: ?>
		<h1><?php echo Text::sprintf('COM_COMPONENTBUILDER_THE_S_WAS_SUCCESSFULLY_COMPILED', $componentFolder); ?></h1>
	<?php endif; ?>
	<?php if ($allowInstall): ?>
		<?php echo LayoutHelper::render('jcbbuilderinstallbuttons', ['model' => $displayData, 'has_modules' => $hasModules, 'has_plugins' => $hasPlugins, 'multi' => $multi]); ?>
	<?php endif; ?>
	<?php echo LayoutHelper::render('jcbbuilderstatssection', $displayData); ?>
	<?php if ($multi): ?>
		<?php echo LayoutHelper::render('jcbmultipathsdownloads', ['model' => $displayData, 'urls' => $urls]); ?>
	<?php else: ?>
		<?php echo LayoutHelper::render('jcbsinglepathdownload', ['model' => $displayData, 'url' => $urls['componentUrl'] ?? null]); ?>
	<?php endif; ?>
	<p>
		<small><?php echo Text::_('COM_COMPONENTBUILDER_COMPILATION_TOOK'); ?> <b><?php '#'.'##COMPILER_TIMER##'.'#'; ?></b> <?php echo Text::_('COM_COMPONENTBUILDER_SECONDS_TO_COMPLETE'); ?>.</small>
	</p>
</div>
