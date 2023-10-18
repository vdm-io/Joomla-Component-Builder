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

namespace VDM\Joomla\Componentbuilder\Compiler\Component;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Component\Settings;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Folder;
use VDM\Joomla\Utilities\ObjectHelper;


/**
 * Build/Create Component Structure
 * 
 * @since  3.2.0
 */
final class Structure
{
	/**
	 * Compiler Component Joomla Version Settings
	 *
	 * @var    Settings
	 * @since 3.2.0
	 */
	protected Settings $settings;

	/**
	 * Compiler Paths
	 *
	 * @var    Paths
	 * @since 3.2.0
	 */
	protected Paths $paths;

	/**
	 * Compiler Utilities Folder
	 *
	 * @var    Folder
	 * @since 3.2.0
	 */
	protected Folder $folder;

	/**
	 * Constructor
	 *
	 * @param Settings|null     $settings    The compiler component joomla version settings object.
	 * @param Paths|null        $paths       The compiler paths object.
	 * @param Folder|null       $folder      The compiler folder object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Settings $settings = null, ?Paths $paths = null, ?Folder $folder = null)
	{
		$this->settings = $settings ?: Compiler::_('Component.Settings');
		$this->paths = $paths ?: Compiler::_('Utilities.Paths');
		$this->folder = $folder ?: Compiler::_('Utilities.Folder');
	}

	/**
	 * Build the Component Structure
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	public function build(): bool
	{
		if ($this->settings->exists())
		{
			// setup the main component path
			$this->folder->create($this->paths->component_path);

			// build the version structure
			$this->folders(
				$this->settings->structure(),
				$this->paths->component_path
			);

			return true;
		}

		return false;
	}

	/**
	 * Create the folder and subfolders
	 *
	 * @param   object     $folders   The object[] of folders
	 * @param   string     $path       The path
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function folders(object $folders, string $path)
	{
		foreach ($folders as $folder => $sub_folders)
		{
			$new_path = $path . '/' . $folder;
			$this->folder->create($new_path);

			if (ObjectHelper::check($sub_folders))
			{
				$this->folders($sub_folders, $new_path);
			}
		}
	}
}

