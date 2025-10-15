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

namespace VDM\Joomla\Componentbuilder\Compiler\Extension\Files;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Componentbuilder\Compiler\Extension\FileContent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\ExtensionFilesUpdateInterface;


/**
 * Static Files Updater Class
 * 
 * @since 5.1.2
 */
final class StaticFiles implements ExtensionFilesUpdateInterface
{
	/**
	 * The Files Class.
	 *
	 * @var   Files
	 * @since 5.1.2
	 */
	protected Files $files;

	/**
	 * The FileContent Class.
	 *
	 * @var   FileContent
	 * @since 5.1.2
	 */
	protected FileContent $filecontent;

	/**
	 * Constructor.
	 *
	 * @param Files         $files         The Files Class.
	 * @param FileContent   $filecontent   The FileContent Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Files $files, FileContent $filecontent)
	{
		$this->files = $files;
		$this->filecontent = $filecontent;
	}

	/**
	 * Update all files (except the autoloader files)
	 *
	 * @param string   $bom   The header details [BOM] of the file
	 *
	 * @return  void
	 * @since 5.1.2
	 */
	public function update(string $bom): void
	{
		if ($this->files->exists('static'))
		{
			// first we do the static files
			foreach ($this->files->get('static') as $static)
			{
				if (!$this->isPowerloader($static['name']) && is_file($static['path']))
				{
					$this->filecontent->set(
						$static['name'], $static['path'], $bom
					);
				}
			}
		}
	}

	/**
	 * Update only the autoloader files
	 *
	 * @param string   $bom   The header details [BOM] of the file
	 *
	 * @return  void
	 * @since 5.1.2
	 */
	public function autoloader(string $bom): void
	{
		if ($this->files->exists('static'))
		{
			// first we do the static files
			foreach ($this->files->get('static') as $static)
			{
				if ($this->isPowerloader($static['name']) && is_file($static['path']))
				{
					$this->filecontent->set(
						$static['name'], $static['path'], $bom
					);
				}
			}
		}
	}

	/**
	 * Check if the filename is a Powerloader PHP file.
	 *
	 * This method performs a highly efficient, case-insensitive check
	 * to determine if the given filename contains the word "powerloader"
	 * and ends with ".php".
	 *
	 * It avoids regex overhead and uses native string operations for speed.
	 *
	 * @param  string  $filename  The filename to check.
	 *
	 * @return bool  True if the filename matches the criteria, false otherwise.
	 * @since  5.1.2
	 */
	private static function isPowerloader(string $filename): bool
	{
		$lower = strtolower($filename);

		if (!str_ends_with($lower, '.php'))
		{
			return false;
		}

		return str_contains($lower, 'powerloader');
	}
}

