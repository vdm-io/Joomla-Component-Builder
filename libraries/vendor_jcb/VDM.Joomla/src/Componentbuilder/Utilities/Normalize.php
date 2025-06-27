<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Utilities;


use VDM\Joomla\Utilities\MimeHelper;
use VDM\Joomla\Componentbuilder\Utilities\Constantpaths;


/**
 * Utilities Normalize Paths
 * 
 * @since 5.1.1
 */
class Normalize extends Constantpaths
{
	/**
	 * Normalize a given file or folder path based on the target type.
	 *
	 * @param  string  $path    The input path, may contain constants or hashes.
	 * @param  string  $target  One of: 'custom', 'full', or 'images'.
	 *
	 * @return array|null  ['path' => relative path, 'full' => absolute path, 'key' => unique key]
	 * @since  5.1.1
	 */
	public function path(string $path, string $target): ?array
	{
		// Remove image hash if target is images
		if ($target === 'images')
		{
			$path = preg_replace('/[?#].*$/', '', $path);
		}

		$result = $this->build($path, $target);

		if ($result === null || !($absolutePath = realpath($result['full'])) || (!is_file($absolutePath) && !is_dir($absolutePath)))
		{
			return null;
		}

		// Sanitize relative path by removing base
		$relativePath = ltrim(str_replace(str_replace('\\', '/', $result['base']), '', str_replace('\\', '/', $absolutePath)), '/');

		// Build UUID key
		$key = $this->key($relativePath);

		// If it's a file, append the extension (e.g., .jpg or .txt)
		if (is_file($absolutePath))
		{
			$extension = strtolower(pathinfo($absolutePath, PATHINFO_EXTENSION));
			if (!empty($extension))
			{
				$key .= '.' . $extension;
			}
		}
		else
		{
			$key .= '.zip'; // all directories are zipped
		}

		return [
			'path' => $relativePath,
			'full' => $absolutePath,
			'key' => $key
		];
	}

	/**
	 * Reconstruct the full absolute path from a normalized relative path and target type.
	 *
	 * @param  string  $path    The relative normalized path.
	 * @param  string  $target  One of: 'custom', 'full', or 'images'.
	 *
	 * @return string|null   The fully-qualified absolute path or null on failure.
	 * @since  5.1.1
	 */
	public function full(string $path, string $target): ?string
	{
		$path = ltrim($path, '/\\');

		$result = $this->build($path, $target);

		return $result ? $result['full'] : null;
	}

	/**
	 * Convert a string path to a deterministic UUIDv5 (36-char) using SHA1 hashing and optimized logic.
	 *
	 * @param  string  $path  The original input path
	 *
	 * @return string  UUIDv5-compatible, deterministic 36-character string
	 * @since  5.1.1
	 */
	public function key(string $path): string
	{
		// Static binary namespace (NAMESPACE_URL) for performance
		static $namespaceBin = null;
		if ($namespaceBin === null)
		{
			$namespaceHex = '6ba7b8119dad11d180b400c04fd430c8';
			$namespaceBin = hex2bin($namespaceHex);
		}

		// Normalize + sanitize path
		$normalized = strtr(
			str_replace(['\\', '/'], '/', $path),
			[
				':' => '__c_0_l_0_n__',
				'/' => '__dIrecTory__separaTor__',
				'.' => '__d_0_t__',
				'?' => '__q_u_e_s_t__',
				'&' => '__a_m_p__',
				'=' => '__e_q__',
				'#' => '__h_a_s_h__',
				'%' => '__p_e_r__',
				'+' => '__p_l_u_s__',
				' ' => '__s_p__',
			]
		);

		// SHA1 hash of (namespace + normalized path)
		$hash = sha1($namespaceBin . strtolower($normalized));

		// Compose version 5 UUID (bit masking directly in hex)
		return sprintf(
			'%08s-%04s-%04x-%04x-%012s',
			substr($hash, 0, 8),
			substr($hash, 8, 4),
			(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
			(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
			substr($hash, 20, 12)
		);
	}

	/**
	 * Internal logic to build the full absolute path and base root for a given target.
	 *
	 * @param  string  $path    Raw input or relative path.
	 * @param  string  $target  One of: 'custom', 'full', or 'images'.
	 *
	 * @return array|null   ['base' => base path, 'full' => absolute path]
	 * @since  5.1.1
	 */
	protected function build(string $path, string $target): ?array
	{
		$path = ltrim($path, '/\\');

		switch ($target)
		{
			case 'custom':
				$basePath = JPATH_ADMINISTRATOR . '/components/com_componentbuilder/custom';
				break;

			case 'images':
				$basePath = JPATH_SITE;
				break;

			case 'full':
				$basePath = JPATH_ROOT;

				// Replace constants (e.g. JPATH_SITE) with real values
				$path = str_replace(array_keys($this->paths), array_values($this->paths), $path);
				break;

			default:
				return null;
		}

		$fullPath = str_replace(['\\', '//'], '/', $basePath . '/' . $path);

		return [
			'base' => str_replace(['\\', '//'], '/', $basePath),
			'full' => $fullPath
		];
	}
}

