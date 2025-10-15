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


use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Interfaces\Remote\GetInterface;
use VDM\Joomla\Componentbuilder\Package\Remote\GetContent;


/**
 * Get Remote Folder for JCB
 * 
 * @since 5.1.1
 */
final class GetFolder extends GetContent implements GetInterface
{
	/**
	 * Check if an folder is found locally
	 *
	 * @param  string   $fullPath  The full path to the folder
	 *
	 * @return bool
	 * @since  5.1.1
	 */
	protected function isLocal(string $fullPath): bool
	{
		return is_dir($fullPath);
	}

	/**
	 * Store the found content locally
	 *
	 * @param  string   $content   The zipped content as a string
	 * @param  string   $fullPath  The full path to the content
	 *
	 * @return bool  True on success, false on failure
	 * @since  5.1.1
	 */
	protected function store(string $content, string $fullPath): bool
	{
		$tmpZipPath = $fullPath . '.restore.zip';

		try
		{
			// Remove existing folder
			if (is_dir($fullPath))
			{
				if (!Folder::delete($fullPath))
				{
					throw new \RuntimeException("Failed to remove existing folder at: {$fullPath}");
				}
			}

			// Write zip content to temp file
			if (!File::write($tmpZipPath, $content))
			{
				throw new \RuntimeException("Failed to write temporary zip file to: {$tmpZipPath}");
			}

			// Unzip content
			if (!is_dir($fullPath))
			{
				Folder::create($fullPath);
			}

			$unzipResult = Folder::unpack($tmpZipPath, $fullPath);

			if (!$unzipResult || !is_array($unzipResult) || empty($unzipResult))
			{
				throw new \RuntimeException("Unzipping failed or returned no files for: {$tmpZipPath}");
			}

			return true;
		}
		catch (\Throwable $e)
		{
			$this->messages->add('error', Text::sprintf('COM_COMPONENTBUILDER_SYSTEMCOULD_NOT_RESTORE_FOLDER_TO_SBRBRBERROR_MESSAGEBBRS',
				$fullPath, $e->getMessage()
			));
			return false;
		}
		finally
		{
			// Always try to remove the temp zip file
			if (is_file($tmpZipPath))
			{
				File::delete($tmpZipPath);
			}
		}
	}
}

