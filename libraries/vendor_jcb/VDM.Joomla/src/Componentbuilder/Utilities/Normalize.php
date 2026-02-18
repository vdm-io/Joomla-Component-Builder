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


use VDM\Joomla\Componentbuilder\Utilities\Constantpaths;


/**
 * Path Normalize & Key Generator
 * 
 * Provides deterministic path normalization and UUID-v5 key generation
 * for files and directories used throughout the JCB system.
 * 
 * Responsibilities:
 *   - Resolve absolute paths from logical scopes (custom, compiler, images, image, full)
 *   - Normalize filesystem paths safely
 *   - Derive deterministic UUIDv5 keys
 *   - Ensure consistent identifiers across Linux & Windows
 *   - Convert absolute paths into stable relative-key formats
 * 
 * @since 5.1.1
 */
class Normalize extends Constantpaths
{
	/**
	 * Normalize a given file or folder path based on the target type.
	 *
	 * @param  string  $path    The input path, may contain constants or hashes.
	 * @param  string  $target  One of: 'custom', 'compiler', 'image', 'images', 'full'
	 *
	 * @return array|null  ['path' => relative, 'full' => absolute, 'key' => uuidv5]
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

		if ($result === null)
		{
			return null;
		}

		$absolutePath = realpath($result['full']);

		if ($absolutePath === false || (!is_file($absolutePath) && !is_dir($absolutePath)))
		{
			return null;
		}

		// Sanitize relative path by removing base
		$relativePath = $this->getRelativePath($result['base'], $absolutePath);

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
	 * Build the absolute file system path for a given input path based on a target scope.
	 *
	 * This method expands Joomla constants when operating in `full` mode and ensures
	 * that JPATH_ROOT is only applied when the resolved path is not already absolute.
	 *
	 * Target resolution rules:
	 * - custom : Path is resolved inside the component custom directory.
	 * - compiler : Path is resolved inside the component compiler directory.
	 * - images : Path already includes `images/...` and is resolved from JPATH_SITE.
	 * - image  : Bare filename; resolved inside `/images`.
	 * - full   : Constants are expanded and JPATH_ROOT is only prepended if missing.
	 *
	 * @param  string  $path    Raw input or constant-based path.
	 * @param  string  $target  One of: `custom`, `images`, `image`, `full`.
	 *
	 * @return array|null  ['base' => string, 'full' => string]
	 * @since  5.1.1
	 */
	protected function build(string $path, string $target): ?array
	{
		$path = trim(ltrim($path, '/\\'));

		$targets = [
			'custom' => JPATH_ADMINISTRATOR . '/components/com_componentbuilder/custom',
			'compiler' => JPATH_ADMINISTRATOR . '/components/com_componentbuilder/compiler',
			'image'  => JPATH_SITE . '/images',
			'images' => JPATH_SITE,
			'full'   => JPATH_ROOT,
		];

		if (!isset($targets[$target]))
		{
			return null;
		}

		$basePath = $targets[$target];

		// FULL PATH MODE
		if ($target === 'full')
		{
			// Expand Joomla constants
			$path = str_replace(
				array_keys($this->paths),
				array_values($this->paths),
				$path
			);

			$fullPath = $this->canonicalizePathString($path);

			// If already rooted at $basePath -> return as-is
			if (str_starts_with($fullPath, $basePath))
			{
				return [
					'base' => dirname($fullPath),
					'full' => $fullPath,
				];
			}
		}

		return [
			'base' => $this->canonicalizePathString($basePath),
			'full' => $this->canonicalizePathString($basePath . '/' . $path),
		];
	}

	/**
	 * Canonicalize path string for hashing & identity.
	 *
	 * @param  string  $path
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function canonicalizePathString(string $path): string
	{
		$path = str_replace('\\', '/', $path);
		$path = preg_replace('#/+#', '/', $path);
		return rtrim($path, '/');
	}

	/**
	 * Remove base path from the start of an absolute path if present.
	 *
	 * @param  string  $base
	 * @param  string  $full
	 *
	 * @return string
	 * @since  5.1.4
	 */
	protected function getRelativePath(string $base, string $full): string
	{
		// Remove base only if it is at the START
		if (str_starts_with($full, $base))
		{
			return substr($full, strlen($base) + 1);
		}

		// Otherwise return unchanged
		return ltrim($full, '/');
	}
}

