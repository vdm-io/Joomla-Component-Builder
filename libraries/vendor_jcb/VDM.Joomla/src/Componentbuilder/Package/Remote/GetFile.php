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

namespace VDM\Joomla\Componentbuilder\Package\Remote;


use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Interfaces\Remote\GetInterface;
use VDM\Joomla\Componentbuilder\Package\Remote\GetContent;


/**
 * Get Remote File for JCB
 * 
 * @since 5.1.1
 */
final class GetFile extends GetContent implements GetInterface
{
	/**
	 * Check if an file is found locally
	 *
	 * @param  string   $fullPath  The full path to the file
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected function isLocal(string $fullPath): bool
	{
		return is_file($fullPath);
	}

	/**
	 * Store the found content locally
	 *
	 * @param  string   $content   The content to store (file data)
	 * @param  string   $fullPath  The full path where the file should be restored
	 *
	 * @return bool  True on success, false on failure
	 * @since  5.1.1
	 */
	protected function store(string $content, string $fullPath): bool
	{
		try
		{
			// Ensure the directory exists
			$directory = dirname($fullPath);
			if (!is_dir($directory) && !Folder::create($directory))
			{
				throw new \RuntimeException("Failed to create directory: {$directory}");
			}

			// If file exists, delete it
			if (is_file($fullPath) && !File::delete($fullPath))
			{
				throw new \RuntimeException("Failed to delete existing file: {$fullPath}");
			}

			// Write file using FileHelper
			if (!FileHelper::write($fullPath, $content))
			{
				throw new \RuntimeException("Failed to write file to: {$fullPath}");
			}

			return true;
		}
		catch (\Throwable $e)
		{
			$this->messages->add('error', Text::sprintf('COM_COMPONENTBUILDER_SYSTEMCOULD_NOT_RESTORE_FILE_TO_SBRBRBERROR_MESSAGEBBRS',
				$fullPath, $e->getMessage()
			));
			return false;
		}
	}
}

