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


use Joomla\CMS\Filesystem\File as JoomlaFile;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Utilities\FileHelper;


/**
 * File helper
 * 
 * @since  3.2.0
 */
class File
{
	/**
	 * Compiler Utilities Counter
	 *
	 * @var    Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * Compiler Utilities Paths
	 *
	 * @var    Paths
	 * @since 3.2.0
	 */
	protected Paths $paths;

	/**
	 * Constructor
	 *
	 * @param Counter|null    $counter    The compiler counter object.
	 * @param Paths|null      $paths      The compiler paths object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Counter $counter = null, ?Paths $paths = null)
	{
		$this->counter = $counter ?: Compiler::_('Utilities.Counter');
		$this->paths = $paths ?: Compiler::_('Utilities.Paths');
	}

	/**
	 * set HTML blank file to a path
	 *
	 * @param   string   $path   The path to where to set the blank html file
	 * @param   string   $root    The root path
	 *
	 * @return void
	 */
	public function html(string $path = '', string $root = 'component')
	{
		if ('component' === $root)
		{
			$root = $this->paths->component_path . '/';
		}

		// use path if exist
		if (strlen($path) > 0)
		{
			JoomlaFile::copy(
				$this->paths->template_path . '/index.html',
				$root . $path . '/index.html'
			);
		}
		else
		{
			JoomlaFile::copy(
				$this->paths->template_path . '/index.html',
				$root . '/index.html'
			);
		}

		// count the file created
		$this->counter->file++;
	}

	/**
	 * Create a file on the server if it does not exist, or Overwrite existing files
	 *
	 * @param  string   $path    The path and file name where to safe the data
	 * @param  string   $data    The data to safe
	 *
	 * @return  bool true   On success
	 * @since  3.2.0
	 */
	public function write(string $path, string $data): bool
	{
		return FileHelper::write($path, $data);
	}

}

