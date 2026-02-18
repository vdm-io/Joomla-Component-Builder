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

namespace VDM\Joomla\File;


use VDM\Joomla\Interfaces\File\TypeDefinitionInterface;


/**
 * File Type Definition Class
 * 
 * This class represents an **immutable file handling blueprint** used by the file
 * intake pipeline. It defines:
 * 
 * - The HTML input field responsible for uploads
 * - Allowed file formats
 * - Target filesystem location
 * - Filter engine rule
 * - Image crop definitions (if applicable)
 * 
 * Instances of this class are designed to be:
 * 
 * - Safe to reuse
 * - Immutable after construction
 * - Free of any database concerns
 * - Serializable-friendly
 * 
 * It replaces the older Type database architecture with a deterministic,
 * configuration-based model.
 * 
 * @since  5.1.4
 */
final class TypeDefinition implements TypeDefinitionInterface
{
	/**
	 * HTML form input field name.
	 *
	 * This value determines which $_FILES entry the upload handler reads.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $field;

	/**
	 * File type identifier.
	 *
	 * Common values:
	 * - "file"
	 * - "image"
	 * - "media"
	 * - "document"
	 *
	 * This value is passed directly to the upload handler in order to select
	 * the appropriate validation pipeline.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $type;

	/**
	 * Upload filter rule.
	 *
	 * Determines the sanitization and validation strategy applied by the
	 * upload handler.
	 *
	 * Example values:
	 * - "safe"
	 * - "clean"
	 * - "none"
	 *
	 * @var   string|null
	 * @since 5.1.4
	 */
	protected ?string $filter;

	/**
	 * Target filesystem path for uploads.
	 *
	 * All uploaded files will be stored in this directory.
	 * The directory must exist and be writable.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected string $path;

	/**
	 * Allowed file extensions.
	 *
	 * Values must be defined without leading dots.
	 *
	 * Example:
	 * - ['jpg', 'png']
	 * - ['csv']
	 * - ['pdf', 'docx']
	 *
	 * @var   array<int,string>
	 * @since 5.1.4
	 */
	protected array $formats;

	/**
	 * Constructor.
	 *
	 * Required configuration keys:
	 * - `field`
	 * - `type`
	 * - `path`
	 *
	 * Optional configuration keys:
	 * - `filter`
	 * - `formats`
	 * - `crop`
	 *
	 * @param  array  $config  File type configuration map.
	 *
	 * @throws \InvalidArgumentException If required keys are missing.
	 * @since  5.1.4
	 */
	public function __construct(array $config)
	{
		foreach (['field','type','path'] as $key)
		{
			if (empty($config[$key]))
			{
				throw new \InvalidArgumentException("Missing file type config: {$key}");
			}
		}

		$this->field   = (string) $config['field'];
		$this->type    = (string) $config['type'];
		$this->filter  = $config['filter'] ?? null;
		$this->path    = rtrim((string) $config['path'], '/');
		$this->formats = (array) ($config['formats'] ?? []);
	}

	/**
	 * Get the upload field name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function field(): string
	{
		return $this->field;
	}

	/**
	 * Get the defined file type.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function type(): string
	{
		return $this->type;
	}

	/**
	 * Get the upload filter mode.
	 *
	 * @return string|null
	 * @since  5.1.4
	 */
	public function filter(): ?string
	{
		return $this->filter;
	}

	/**
	 * Get the target filesystem path.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function path(): string
	{
		return $this->path;
	}

	/**
	 * Get the allowed file extensions.
	 *
	 * @return array<int,string>
	 * @since  5.1.4
	 */
	public function formats(): array
	{
		return $this->formats;
	}

	/**
	 * Export the file type definition as an associative array.
	 *
	 * This returns the same structure used to construct the
	 * base TypeDefinition instance, allowing the configuration
	 * to be serialized, stored, or cloned cleanly.
	 *
	 * @return array  The configuration map.
	 * @since  5.1.4
	 */
	public function toArray(): array
	{
		return [
			'field'   => $this->field,
			'type'    => $this->type,
			'filter'  => $this->filter,
			'path'    => $this->path,
			'formats' => $this->formats,
		];
	}
}

