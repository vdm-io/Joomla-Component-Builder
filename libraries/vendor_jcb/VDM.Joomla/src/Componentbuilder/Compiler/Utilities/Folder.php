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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use Joomla\CMS\Filesystem\Folder as JoomlaFolder;
use Joomla\CMS\Filesystem\File as JoomlaFile;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Folder helper
 * 
 * @since  3.2.0
 */
class Folder
{
	/**
	 * Compiler Counter
	 *
	 * @var    Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * Compiler Utilities File
	 *
	 * @var    File
	 * @since 3.2.0
	 */
	protected File $file;

	/**
	 * Constructor
	 *
	 * @param Counter|null    $counter    The compiler counter object.
	 * @param File|null       $file       The compiler file object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Counter $counter = null, ?File $file = null)
	{
		$this->counter = $counter ?: Compiler::_('Utilities.Counter');
		$this->file = $file ?: Compiler::_('Utilities.File');
	}

	/**
	 * Create Path if not exist
	 *
	 * @param   string   $path      The path to folder to create
	 * @param   bool     $addHtml   The the switch to add the HTML
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function create(string $path, bool $addHtml = true)
	{
		// check if the path exist
		if (!JoomlaFolder::exists($path))
		{
			// create the path
			JoomlaFolder::create(
				$path
			);

			// count the folder created
			$this->counter->folder++;

			if ($addHtml)
			{
				// add index.html (boring I know)
				$this->file->html(
					$path, ''
				);
			}
		}
	}

	/**
	 * Remove folders with files
	 * 
	 * @param   string      $path    The path to folder to remove
	 * @param   array|null  $ignore  The folders and files to ignore and not remove
	 *
	 * @return  boolean   True if all are removed
	 * @since 3.2.0
	 */
	public function remove(string $path, ?array $ignore = null): bool
	{
		if (!JoomlaFolder::exists($path))
		{
			return false;
		}

		$it = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS);
		$files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

		// Prepare a base path without trailing slash for comparison
		$basePath = rtrim($path, '/');

		foreach ($files as $fileinfo)
		{
			$filePath = $fileinfo->getRealPath();

			if ($this->shouldIgnore($basePath, $filePath, $ignore))
			{
				continue;
			}

			if ($fileinfo->isDir())
			{
				JoomlaFolder::delete($filePath);
			}
			else
			{
				JoomlaFile::delete($filePath);
			}
		}

		// Delete the root folder if ignore not set
		if (!ArrayHelper::check($ignore))
		{
			return JoomlaFolder::delete($path);
		}

		return true;
	}

	/**
	 * Check if the current path should be ignored.
	 * 
	 * @param   string      $basePath  The base directory path
	 * @param   string      $filePath  The current file or directory path
	 * @param   array|null  $ignore    List of items to ignore
	 *
	 * @return  boolean   True if the path should be ignored
	 * @since 3.2.0
	 */
	protected function shouldIgnore(string $basePath, string $filePath, ?array $ignore = null): bool
	{
		if (!$ignore || !ArrayHelper::check($ignore))
		{
			return false;
		}

		foreach ($ignore as $item)
		{
			if (strpos($filePath, $basePath . '/' . $item) !== false)
			{
				return true;
			}
		}

		return false;
	}
}

