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
		if (JoomlaFolder::exists($path))
		{
			$it = new \RecursiveDirectoryIterator($path);
			$it = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);

			// remove ending /
			$path = rtrim($path, '/');

			// now loop the files & folders
			foreach ($it as $file)
			{
				if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;

				// set file dir
				$file_dir = $file->getPathname();

				// check if this is a dir or a file
				if ($file->isDir())
				{
					$keeper = false;
					if (ArrayHelper::check($ignore))
					{
						foreach ($ignore as $keep)
						{
							if (strpos((string) $file_dir, $path . '/' . $keep) !== false)
							{
								$keeper = true;
							}
						}
					}

					if ($keeper)
					{
						continue;
					}

					JoomlaFolder::delete($file_dir);
				}
				else
				{
					$keeper = false;
					if (ArrayHelper::check($ignore))
					{
						foreach ($ignore as $keep)
						{
							if (strpos((string) $file_dir, $path . '/'. $keep) !== false)
							{
								$keeper = true;
							}
						}
					}

					if ($keeper)
					{
						continue;
					}

					JoomlaFile::delete($file_dir);
				}
			}

			// delete the root folder if ignore not set
			if (!ArrayHelper::check($ignore))
			{
				return JoomlaFolder::delete($path);
			}

			return true;
		}
		return false;
	}

}

