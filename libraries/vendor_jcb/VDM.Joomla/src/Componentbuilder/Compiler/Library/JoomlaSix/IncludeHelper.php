<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    23rd October, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Library\JoomlaSix;


use VDM\Joomla\Componentbuilder\Compiler\Library\IncludeHelper as SharedIncludeHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Joomla six IncludeHelper renderer.
 * 
 * @since 6.2.0
 */
final class IncludeHelper extends SharedIncludeHelper
{
	/**
	 * Register and activate a library asset while retaining declaration order.
	 *
	 * @param   string      $path      The library URI or local PHP path.
	 * @param   array|null  $pathInfo  Optional path metadata.
	 *
	 * @return  string
	 * @since   6.2.0
	 */
	public function get(string $path, ?array $pathInfo = null): string
	{
		$pathInfo ??= pathinfo((string) (parse_url($path, PHP_URL_PATH) ?? $path));
		$extension = strtolower($pathInfo['extension'] ?? '');

		if (!in_array($extension, ['js', 'css', 'less'], true))
		{
			return parent::get($path, $pathInfo);
		}

		$type = $extension === 'js' ? 'script' : 'style';
		$uri = str_starts_with($path, '//') ? $path : ltrim($path, '/');
		$name = 'jcb.' . $type . '.' . hash('sha256', $uri);
		$method = ucfirst($type);
		$dependencies = '$jcb' . $method . 'Dependencies';
		$nameCode = var_export($name, true);
		$uriCode = var_export($uri, true);

		if (!str_starts_with($uri, '//') && preg_match('#^[a-z][a-z0-9+.-]*:#i', $uri) !== 1)
		{
			$uriCode = 'Joomla__' . '_eecc143e_b5cf_4c33_ba4d_97da1df61422___Power::root() . ' . $uriCode;
		}

		return '$jcbAssetManager = Joomla__' . '_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->getDocument()->getWebAssetManager();'
			. PHP_EOL . Indent::_(0) . "if (!\$jcbAssetManager->assetExists('{$type}', {$nameCode}))"
			. PHP_EOL . Indent::_(0) . '{'
			. PHP_EOL . Indent::_(1) . "\$jcbAssetManager->register{$method}({$nameCode}, {$uriCode}, ['version' => 'auto'], [], {$dependencies} ?? []);"
			. PHP_EOL . Indent::_(0) . '}'
			. PHP_EOL . Indent::_(0) . "\$jcbAssetManager->use{$method}({$nameCode});"
			. PHP_EOL . Indent::_(0) . "{$dependencies} = array_values(array_unique(array_merge({$dependencies} ?? [], [{$nameCode}])));";
	}
}

