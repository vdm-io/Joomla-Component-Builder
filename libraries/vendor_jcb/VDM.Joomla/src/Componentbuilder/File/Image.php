<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\File;


use Joomla\CMS\Image\Image as JoomlaImage;
use Joomla\CMS\Log\Log;
use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use VDM\Joomla\Utilities\MimeHelper;


/**
 * Image Class
 * 
 * @since  5.1.1
 */
final class Image
{
	/**
	 * Process one image into multiple dimensioned versions.
	 *
	 * @param   string  $source         Full path to source image.
	 * @param   string  $destinationDir Destination folder (will be created if missing).
	 * @param   array   $dimensions     Format: [['name' => 'thumb.jpg', 'width' => 100, 'height' => 100], ...]
	 *
	 * @return  array  Result array: ['thumb.jpg' => [...metadata...], 'invalid.jpg' => null, ...]
	 * @since   5.1.1
	 */
	public function process(string $source, string $destinationDir, array $dimensions): array
	{
		$results = [];

		foreach ($dimensions as $set)
		{
			if (
				!isset($set['name'], $set['width'], $set['height']) ||
				!is_numeric($set['width']) ||
				!is_numeric($set['height'])
			)
			{
				$results[$set['name'] ?? 'unknown'] = null;
				continue;
			}

			$outputPath = rtrim($destinationDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $set['name'];
			$results[$set['name']] = $this->cropResize($source, $outputPath, (int) $set['width'], (int) $set['height']);
		}

		return $results;
	}

	/**
	 * Crop or scale an image to target size using center crop or just resize if aspect ratio matches.
	 *
	 * @param   string  $source      Full absolute path to source image.
	 * @param   string  $destination Full absolute path to destination image.
	 * @param   int     $targetW     Target width
	 * @param   int     $targetH     Target height
	 *
	 * @return  array|null  Image metadata on success, false on failure.
	 * @since   5.1.1
	 */
	public function cropResize(string $source, string $destination, int $targetW, int $targetH): ?array
	{
		try
		{
			if (!is_file($source))
			{
				throw new \RuntimeException("Source image not found: $source");
			}

			$destFolder = dirname($destination);
			if (!is_dir($destFolder))
			{
				Folder::create($destFolder);
			}

			$image = new JoomlaImage($source);

			if (!$image->isLoaded())
			{
				throw new \RuntimeException("Failed to load image: $source");
			}

			$originalW = $image->getWidth();
			$originalH = $image->getHeight();

			// If already correct size, copy directly
			if ($originalW === $targetW && $originalH === $targetH)
			{
				File::copy($source, $destination);
			}
			else
			{
				// Perform crop-resize directly
				$image = $image->cropResize($targetW, $targetH, true);
				$type = $this->getImageType($source);

				if ($type === null || !$image->toFile($destination, $type))
				{
					throw new \RuntimeException("Failed to save image to $destination");
				}
			}

			// Return metadata
			return [
				'name'      => basename($destination),
				'extension' => MimeHelper::Extension($destination),
				'size'      => is_file($destination) ? filesize($destination) : 0,
				'mime'      => MimeHelper::MimeType($destination),
				'path'      => $destination,
			];
		}
		catch (\Throwable $e)
		{
			Log::add($e->getMessage(), Log::ERROR, 'image-cropper');
			return null;
		}
	}

	/**
	 * Get the image type constant from the file path
	 *
	 * @param  string  $path  Absolute path to the image file
	 *
	 * @return int|null  Returns the IMAGETYPE_* constant or null if undetectable
	 * @since  5.1.1
	 */
	private static function getImageType(string $path): ?int
	{
		// Use exif_imagetype to get the constant
		$type = @exif_imagetype($path);

		// Validate it's a known IMAGETYPE
		return is_int($type) ? $type : null;
	}
}

