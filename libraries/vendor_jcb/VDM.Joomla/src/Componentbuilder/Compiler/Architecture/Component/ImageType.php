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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use Joomla\Filesystem\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\File\Image;


/**
 * Component Image Type Resolver.
 * 
 * Responsible for resolving, normalizing, and exposing the component image type
 * used during compilation.
 * 
 * This class:
 * - Determines the image type from a source path
 * - Copies the image into the canonical admin assets directory
 * - Stores the resolved type for reuse
 * - Provides a safe default fallback when detection fails
 * 
 * @since 5.1.4
 */
final class ImageType
{
	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 5.1.4
	 */
	protected Paths $paths;

	/**
	 * The Image Class.
	 *
	 * @var   Image
	 * @since 5.1.4
	 */
	protected Image $image;

	/**
	 * The resolved component image type.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $type = 'jpg';

	/**
	 * Constructor.
	 *
	 * @param Paths   $paths   The Paths Class.
	 * @param Image   $image   The Image Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Paths $paths, Image $image)
	{
		$this->paths = $paths;
		$this->image = $image;
	}

	/**
	 * Resolve and set the component image type.
	 *
	 * Inspects the provided image path, determines its image type,
	 * copies the image into the component admin assets directory,
	 * and stores the resolved type for later retrieval.
	 *
	 * If the image type cannot be resolved, a safe default ('jpg')
	 * is applied.
	 *
	 * @param  string  $path  Relative path to the source image.
	 *
	 * @return string  The resolved component image type.
	 * @since  5.1.4
	 */
	public function set(string $path): string
	{
		$type = $this->image->info($path);

		if (empty($type))
		{
			return $this->setDefault();
		}

		$this->copyImage($path, $type);
		$this->type = $type;

		return $type;
	}

	/**
	 * Get the resolved component image type.
	 *
	 * Always returns a valid image type. If no image was previously
	 * resolved, the default ('jpg') is returned.
	 *
	 * @return string  The component image type.
	 * @since  5.1.4
	 */
	public function get(): string
	{
		return $this->type;
	}

	/**
	 * Copy the component image into the admin assets directory.
	 *
	 * @param  string  $sourcePath  Relative path to the source image.
	 * @param  string  $type        Resolved image type.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function copyImage(string $sourcePath, string $type): void
	{
		$imagePath = $this->paths->component_path . '/admin/assets/images';

		File::copy(
			JPATH_SITE . '/' . ltrim($sourcePath, '/'),
			$imagePath . '/vdm-component.' . $type
		);
	}

	/**
	 * Apply and return the default component image type.
	 *
	 * @return string  The default image type.
	 * @since  5.1.4
	 */
	protected function setDefault(): string
	{
		$this->type = 'jpg';

		return $this->type;
	}
}

