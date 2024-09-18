<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2020
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
use VDM\Joomla\Utilities\MimeHelper;


/**
 * File Manager Class
 * 
 * @since  5.0.2
 */
final class Manager
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
	 *
	 * @since 5.0.2
	 */
	public function __construct(Item $item, Items $items, Type $type, Handler $handler)
	{
		$this->item = $item;
		$this->items = $items;
		$this->type = $type;
		$this->handler = $handler;
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

		// we might need to crop images
		if ($fileType['type'] === 'image')
		{
			// $this->cropImage($details, $guid);
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
		];
	}
}

