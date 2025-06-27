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


use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\File;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Data\Guid;
use VDM\Joomla\Componentbuilder\File\Type;
use VDM\Joomla\Componentbuilder\File\Handler;
use VDM\Joomla\Componentbuilder\File\Image;
use VDM\Joomla\Utilities\MimeHelper;


/**
 * File Manager Class
 * 
 * @since  5.0.2
 */
class Manager
{
	/**
	 * The Globally Unique Identifier.
	 *
	 * @since 5.0.2
	 */
	use Guid;

	/**
	 * The Item Class.
	 *
	 * @var   Item
	 * @since 5.0.2
	 */
	protected Item $item;

	/**
	 * The Items Class.
	 *
	 * @var   Items
	 * @since 5.0.2
	 */
	protected Items $items;

	/**
	 * The Type Class.
	 *
	 * @var   Type
	 * @since 5.0.2
	 */
	protected Type $type;

	/**
	 * The Handler Class.
	 *
	 * @var   Handler
	 * @since 5.0.2
	 */
	protected Handler $handler;

	/**
	 * The Image Class.
	 *
	 * @var   Image
	 * @since 5.1.1
	 */
	protected Image $image;

	/**
	 * The active user
	 *
	 * @var    User
	 * @since 5.0.2
	 */
	protected User $user;

	/**
	 * Table Name
	 *
	 * @var    string
	 * @since 5.0.2
	 */
	protected string $table = 'file';

	/**
	 * Constructor.
	 *
	 * @param Item      $item      The Item Class.
	 * @param Items     $items     The Items Class.
	 * @param Type      $type      The Type Class.
	 * @param Handler   $handler   The Handler Class.
	 * @param Image     $image     The Image Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Item $item, Items $items, Type $type, Handler $handler,
		Image $image)
	{
		$this->item = $item;
		$this->items = $items;
		$this->type = $type;
		$this->handler = $handler;
		$this->image = $image;
		$this->user = Factory::getApplication()->getIdentity();
	}

	/**
	 * Upload a file, of a given file type and link it to an entity.
	 *
	 * @param string $guid    The file type guid
	 * @param string $entity  The entity guid
	 * @param string $target  The target entity name
	 *
	 * @return void
	 * @throws \InvalidArgumentException If the file type is not valid.
	 * @throws \RuntimeException If there is an error during file upload.
	 * @since 5.0.2
	 */
	public function upload(string $guid, string $entity, string $target): void
	{
		if (($fileType = $this->type->load($guid, $target)) === null)
		{
			throw new \InvalidArgumentException(Text::sprintf('COM_COMPONENTBUILDER_FILE_TYPE_NOT_VALID_IN_S_AREA', $target));
		}

		// make sure the user have permissions to upload this file type
		if (!in_array($fileType['access'], $this->user->getAuthorisedViewLevels()))
		{
			throw new \InvalidArgumentException(Text::sprintf('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSIONS_TO_UPLOAD_S', $fileType['name']));
		}

		$details = $this->handler
			->setEnqueueError(false)
			->setLegalFormats($fileType['formats'])
			->getFile(
				$fileType['field'],   // The input field name
				$fileType['type'],    // The file type
				$fileType['filter'],  // The filter to use when uploading the file
				$fileType['path']     // The path to the directory where the file must be placed
			);

		if ($details === null)
		{
			// Throw an exception if file details couldn't be retrieved
			throw new \RuntimeException($this->handler->getErrors());
		}

		if ($fileType['type'] === 'image')
		{
			$this->processImages($details, $guid, $entity, $target, $fileType);
			return;
		}

		// store file in the file table
		$this->item->table($this->getTable())->set(
			$this->modelFileDetails($details, $guid, $entity, $target, $fileType)
		);
	}

	/**
	 * Get the file details for download
	 *
	 * @param string $guid The file guid
	 *
	 * @return array|null
	 * @since 5.0.2
	 */
	public function download(string $guid): ?array
	{
		if (($file = $this->item->table($this->getTable())->get($guid)) !== null &&
			in_array($file->access, $this->user->getAuthorisedViewLevels()))
		{
			return (array) $file;
		}

		return null;
	}

	/**
	 * Delete a file.
	 *
	 * @param string $guid  The file guid
	 *
	 * @return void
	 * @since 5.0.2
	 */
	public function delete(string $guid): void
	{
		if (($file = $this->item->table($this->getTable())->get($guid)) !== null &&
			in_array($file->access, $this->user->getAuthorisedViewLevels()))
		{
			$this->item->table($this->getTable())->delete($guid); // from DB

			if (is_file($file->file_path) && is_writable($file->file_path))
			{
				File::delete($file->file_path); // from file system
			}
		}
	}

	/**
	 * Set the current active table
	 *
	 * @param string $table The table that should be active
	 *
	 * @return self
	 * @since  5.0.2
	 */
	public function table(string $table): self
	{
		$this->table = $table;

		return $this;
	}

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since   5.0.2
	 */
	public function getTable(): string
	{
		return $this->table;
	}

	/**
	 * Process the image(s) as needed based on crop settings
	 *
	 * @param array  $details   The uploaded file details.
	 * @param string $guid      The file type guid
	 * @param string $entity    The entity guid
	 * @param string $target    The target entity name
	 * @param array $fileType   The file type
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function processImages(array $details, string $guid, string $entity, string $target, array $fileType): void
	{
		if (empty($fileType['crop']))
		{
			// store file in the file table
			$this->item->table($this->getTable())->set(
				$this->modelFileDetails($details, $guid, $entity, $target, $fileType)
			);
			return;
		}

		$source = $details['full_path'];
		$path = $details['path'];
		$cropping = $fileType['crop'];

		$placeholders = [
			'{number}' => $this->getFileNumber($fileType, $entity),
			'{name}' => $this->getFileName($details, $entity),
			'{extension}' => $this->getFileExtension($source)
		];

		foreach ($cropping as &$crop)
		{
			$crop['name'] = str_replace(array_keys($placeholders), array_values($placeholders), $crop['name']);
		}

		$images = $this->image->process($source, $path, $cropping);

		foreach($images as $image)
		{
			if (empty($image))
			{
				continue;
			}

			$details['name'] = $image['name'];
			$details['extension'] = $image['extension'];
			$details['size'] = $image['size'];
			$details['mime'] = $image['mime'];
			$details['full_path'] = $image['path'];

			// store file in the file table
			$this->item->table($this->getTable())->set(
				$this->modelFileDetails($details, $guid, $entity, $target, $fileType)
			);
		}

		// clean up source image
		if (is_file($source) && is_writable($source))
		{
			File::delete($source); // from file system
		}
	}

	/**
	 * model the file details to store in the file table
	 *
	 * @param array  $details   The uploaded file details.
	 * @param string $guid      The file type guid
	 * @param string $entity    The entity guid
	 * @param string $target    The target entity name
	 * @param array $fileType   The file type
	 *
	 * @return object
	 * @since 5.0.2
	 */
	protected function modelFileDetails(array $details, string $guid, string $entity, string $target, array $fileType): object
	{
		return (object) [
			'name' => $details['name'],
			'file_type' => $guid,
			'extension' => $details['extension'] ?? 'error',
			'size' => $details['size'] ?? 0,
			'mime' => $details['mime'] ?? '',
			'file_path' => $details['full_path'],
			'entity_type' => $target,
			'entity' => $entity,
			'access' => $fileType['download_access'] ?? 1,
			'guid' => $this->getGuid('guid'),
			'created_by' => $this->user->id
		];
	}

	/**
	 * Get the file name without extension for download.
	 *
	 * If the original name is empty, return the entity GUID.
	 * If the name does not contain a '.', return the name as is.
	 * Otherwise, return the name without the final extension.
	 *
	 * @param   array   $details  The uploaded file details.
	 * @param   string  $entity   The entity GUID used as fallback.
	 *
	 * @return  string  The extracted or fallback file name.
	 * @since   5.1.1
	 */
	protected function getFileName(array $details, string $entity): string
	{
		// Check if name is set and non-empty
		$name = trim($details['name'] ?? '');

		// Return entity if name is empty
		if ($name === '')
		{
			return $entity;
		}

		// If there is no dot in the name, assume no extension — return as-is
		if (strpos($name, '.') === false)
		{
			return $name;
		}

		// Use pathinfo to extract the name without extension
		$info = pathinfo($name);

		// Return filename (without extension)
		return $info['filename'] ?? $name;
	}

	/**
	 * Get the file number TODO: not ideal, if images are deleted we need a better solution
	 *
	 * @param array  $fileType  The uploaded file type details.
	 * @param string $entity    The entity guid
	 *
	 * @return int
	 * @since  5.1.1
	 */
	protected function getFileNumber(array $fileType, string $entity): int
	{
		if (empty($fileType['crop']))
		{
			return 1;
		}

		$number = count($fileType['crop']);
		$number_files = 1;

		if (($files = $this->items->table($this->getTable())->values([$entity], 'entity')) !== null)
		{
			$total = count($files);
			if ($total >= $number)
			{
				$number_files = round($total / $number);
			}

			return ++$number_files;
		}

		return $number_files;
	}

	/**
	 * Get the file extension
	 *
	 * @param sring  $source  The full path to the file
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function getFileExtension(string $source): string
	{
		return MimeHelper::extension($source);
	}
}

