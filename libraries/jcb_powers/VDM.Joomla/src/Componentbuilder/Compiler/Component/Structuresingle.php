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


use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Component\Settings;
use VDM\Joomla\Componentbuilder\Compiler\Content;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Single Files and Folders Builder Class
 * 
 * @since 3.2.0
 */
class Structuresingle
{
	/**
	 * The new name
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $newName;

	/**
	 * Current Full Path
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $currentFullPath;

	/**
	 * Package Full Path
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $packageFullPath;

	/**
	 * ZIP Full Path
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $zipFullPath;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Component Joomla Version Settings
	 *
	 * @var    Settings
	 * @since 3.2.0
	 */
	protected Settings $settings;

	/**
	 * Compiler Component
	 *
	 * @var    Component
	 * @since 3.2.0
	 **/
	protected Component $component;

	/**
	 * Compiler Content
	 *
	 * @var    Content
	 * @since 3.2.0
	 **/
	protected Content $content;

	/**
	 * Compiler Counter
	 *
	 * @var    Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * Compiler Paths
	 *
	 * @var    Paths
	 * @since 3.2.0
	 */
	protected Paths $paths;

	/**
	 * Compiler Utilities Files
	 *
	 * @var    Files
	 * @since 3.2.0
	 */
	protected Files $files;

	/**
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor
	 *
	 * @param Config|null           $config           The compiler config object.
	 * @param Registry|null         $registry         The compiler registry object.
	 * @param Settings|null    	    $settings         The compiler component Joomla version settings object.
	 * @param Component|null        $component        The component class.
	 * @param Content|null          $content          The compiler content object.
	 * @param Counter|null          $counter          The compiler counter object.
	 * @param Paths|null            $paths            The compiler paths object.
	 * @param Files|null            $files            The compiler files object.
	 * @param CMSApplication|null   $app              The CMS Application object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?Settings $settings = null, ?Component $component = null,
		?Content $content = null, ?Counter $counter = null, ?Paths $paths = null,
		?Files $files = null, ?CMSApplication $app = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->settings = $settings ?: Compiler::_('Component.Settings');
		$this->component = $component ?: Compiler::_('Component');
		$this->content = $content ?: Compiler::_('Content');
		$this->counter = $counter ?: Compiler::_('Utilities.Counter');
		$this->paths = $paths ?: Compiler::_('Utilities.Paths');
		$this->files = $files ?: Compiler::_('Utilities.Files');
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Build the Single Files & Folders
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function build(): bool
	{
		if ($this->settings->exists())
		{
			// TODO needs more looking at this must be dynamic actually
			$this->registry->appendArray('files.not.new', 'LICENSE.txt');

			// do license check
			$LICENSE = $this->doLicenseCheck();

			// do README check
			$README = $this->doReadmeCheck();

			// do CHANGELOG check
			$CHANGELOG = $this->doChangelogCheck();

			// start moving
			foreach ($this->settings->single() as $target => $details)
			{
				// if not gnu/gpl license dont add the LICENSE.txt file
				if ($details->naam === 'LICENSE.txt' && !$LICENSE)
				{
					continue;
				}

				// if not needed do not add
				if (($details->naam === 'README.md' || $details->naam === 'README.txt')
					&& !$README)
				{
					continue;
				}

				// if not needed do not add
				if ($details->naam === 'CHANGELOG.md' && !$CHANGELOG)
				{
					continue;
				}

				// set new name
				$this->setNewName($details);

				// set all paths
				$this->setPaths($details);

				// check if the path exists
				if ($this->pathExist($details))
				{
					// set the target
					$this->setTarget($target, $details);
				}

				// set dynamic target as needed
				$this->setDynamicTarget($details);
			}

			return true;
		}

		return false;
	}

	/**
	 * Check if license must be added
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	private function doLicenseCheck(): bool
	{
		$licenseChecker = strtolower((string) $this->component->get('license', ''));

		if (strpos($licenseChecker, 'gnu') !== false
			&& strpos(
				$licenseChecker, '2'
			) !== false
			&& (strpos($licenseChecker, 'gpl') !== false
			|| strpos(
				$licenseChecker, 'General public license'
			) !== false))
		{
			return true;
		}

		return false;
	}

	/**
	 * Check if readme must be added
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	private function doReadmeCheck(): bool
	{
		return (bool) $this->component->get('addreadme', false);
	}

	/**
	 * Check if changelog must be added
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	private function doChangelogCheck(): bool
	{
		return (bool) $this->component->get('changelog', false);
	}

	/**
	 * Set the new name
	 *
	 * @param object $details
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setNewName(object $details)
	{
		// do the file renaming
		if (isset($details->rename) && $details->rename)
		{
			if ($details->rename === 'new')
			{
				$this->newName = $details->newName;
			}
			else
			{
				$this->newName = str_replace(
					$details->rename,
					$this->config->component_code_name,
					(string) $details->naam
				);
			}
		}
		else
		{
			$this->newName = $details->naam;
		}
	}

	/**
	 * Set all needed paths
	 *
	 * @param object $details
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setPaths(object $details)
	{
		// check if we have a target value
		if (isset($details->_target))
		{
			// set destination path
			$zipPath = str_replace(
					$details->_target['type'] . '/', '', (string) $details->path
				);
			$path = str_replace(
				$details->_target['type'] . '/',
				$this->registry->get('dynamic_paths.' . $details->_target['key'], '') . '/',
					(string) $details->path
				);
		}
		else
		{
			// set destination path
			$zipPath = str_replace('c0mp0n3nt/', '', (string) $details->path);
			$path = str_replace(
					'c0mp0n3nt/', $this->paths->component_path . '/', (string) $details->path
				);
		}

		// set the template folder path
		$templatePath = (isset($details->custom) && $details->custom)
			? (($details->custom !== 'full') ? $this->paths->template_path_custom
				. '/' : '') : $this->paths->template_path . '/';

		// set the final paths
		$currentFullPath = (preg_match('/^[a-z]:/i', (string) $details->naam)) ? $details->naam
			: $templatePath . '/' . $details->naam;

		$this->currentFullPath = str_replace('//', '/', (string) $currentFullPath);

		$this->packageFullPath = str_replace('//', '/', $path . '/' . $this->newName);

		$this->zipFullPath     = str_replace(
			'//', '/', $zipPath . '/' . $this->newName
		);
	}

	/**
	 * Check if path exists
	 *
	 * @param object $details
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	private function pathExist(object $details): bool
	{
		// check if this has a type
		if (!isset($details->type))
		{
			return false;
		}
		// take action based on type
		elseif ($details->type === 'file' && !File::exists($this->currentFullPath))
		{
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREEFILE_PATH_ERRORHTHREE'), 'Error'
			);
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_THE_FILE_PATH_BSB_DOES_NOT_EXIST_AND_WAS_NOT_ADDED',
					$this->currentFullPath
				), 'Error'
			);

			return false;
		}
		elseif ($details->type === 'folder' && !Folder::exists($this->currentFullPath))
		{
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREEFOLDER_PATH_ERRORHTHREE'),
				'Error'
			);
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_THE_FOLDER_PATH_BSB_DOES_NOT_EXIST_AND_WAS_NOT_ADDED',
					$this->currentFullPath
				), 'Error'
			);

			return false;
		}

		return true;
	}

	/**
	 * Set the target based on target type
	 *
	 * @param string   $target
	 * @param object  $details
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setTarget(string $target, object $details)
	{
		// take action based on type
		if ($details->type === 'file')
		{
			// move the file
			$this->moveFile();

			// register the file
			$this->registerFile($target, $details);
		}
		elseif ($details->type === 'folder')
		{
			// move the folder to its place
			Folder::copy(
				$this->currentFullPath, $this->packageFullPath, '', true
			);

			// count the folder created
			$this->counter->folder++;
		}
	}

	/**
	 * Move/Copy the file into place
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function moveFile()
	{
		// get base name && get the path only
		$packageFullPath0nly = str_replace(
			basename($this->packageFullPath), '', $this->packageFullPath
		);

		// check if path exist, if not creat it
		if (!Folder::exists($packageFullPath0nly))
		{
			Folder::create($packageFullPath0nly);
		}

		// move the file to its place
		File::copy($this->currentFullPath, $this->packageFullPath);

		// count the file created
		$this->counter->file++;
	}

	/**
	 * Register the file
	 *
	 * @param string   $target
	 * @param object  $details
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function registerFile(string $target, object $details)
	{
		// store the new files
		if (!in_array($target, $this->registry->get('files.not.new', [])))
		{
			if (isset($details->_target))
			{
				$this->files->appendArray($details->_target['key'],
					[
						'path' => $this->packageFullPath,
						'name' => $this->newName,
						'zip'  => $this->zipFullPath
					]
				);
			}
			else
			{
				$this->files->appendArray('static',
					[
						'path' => $this->packageFullPath,
						'name' => $this->newName,
						'zip'  => $this->zipFullPath
					]
				);
			}
		}

		// ensure we update this file if needed
		if ($this->registry->exists('update.file.content.' . $target))
		{
			// remove the pointer
			$this->registry->remove('update.file.content.' . $target);

			// set the full path
			$this->registry->set('update.file.content.' . $this->packageFullPath, $this->packageFullPath);
		}
	}

	/**
	 * Set Dynamic Target
	 *
	 * @param object  $details
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setDynamicTarget(object $details)
	{
		// only add if no target found since those belong to plugins and modules
		if (!isset($details->_target))
		{
			// check if we should add the dynamic folder moving script to the installer script
			$checker = array_values((array) explode('/', $this->zipFullPath));

			// TODO <-- this may not be the best way, will keep an eye on this.
			// We basicly only want to check if a folder is added that is not in the stdFolders array
			if (isset($checker[0])
				&& StringHelper::check($checker[0])
				&& !$this->settings->standardFolder($checker[0]))
			{
				// activate dynamic folders
				$this->setDynamicFolders();
			}
			elseif (count((array) $checker) == 2
				&& StringHelper::check($checker[0]))
			{
				$add_to_extra = false;

				// set the target
				$eNAME = 'FILES';
				$ename = 'filename';

				// this should not happen and must have been caught by the above if statment
				if ($details->type === 'folder')
				{
					// only folders outside the standard folder are added
					$eNAME        = 'FOLDERS';
					$ename        = 'folder';
					$add_to_extra = true;
				}
				// if this is a file, it can only be added to the admin/site/media folders
				// all other folders are moved as a whole so their files do not need to be declared
				elseif ($this->settings->standardFolder($checker[0])
					&& !$this->settings->standardRootFile($checker[1]))
				{
					$add_to_extra = true;
				}

				// add if valid folder/file
				if ($add_to_extra)
				{
					// set the tab
					$eTab = Indent::_(2);
					if ('admin' === $checker[0])
					{
						$eTab = Indent::_(3);
					}

					// set the xml file
					$key_ = 'EXSTRA_'
						. StringHelper::safe(
							$checker[0], 'U'
						) . '_' . $eNAME;
					$this->content->add($key_,
						PHP_EOL . $eTab . "<" . $ename . ">"
						. $checker[1] . "</" . $ename . ">");
				}
			}
		}
	}

	/**
	 * Add the dynamic folders
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	private function setDynamicFolders()
	{
		// check if we should add the dynamic folder moving script to the installer script
		if (!$this->registry->get('set_move_folders_install_script'))
		{
			// add the setDynamicF0ld3rs() method to the install scipt.php file
			$this->registry->set('set_move_folders_install_script', true);

			// set message that this was done (will still add a tutorial link later)
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREEDYNAMIC_FOLDERS_WERE_DETECTEDHTHREE'),
				'Notice'
			);
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_A_METHOD_SETDYNAMICFZEROLDTHREERS_WAS_ADDED_TO_THE_INSTALL_BSCRIPTPHPB_OF_THIS_PACKAGE_TO_INSURE_THAT_THE_FOLDERS_ARE_COPIED_INTO_THE_CORRECT_PLACE_WHEN_THIS_COMPONENT_IS_INSTALLED'),
				'Notice'
			);
		}
	}

}

