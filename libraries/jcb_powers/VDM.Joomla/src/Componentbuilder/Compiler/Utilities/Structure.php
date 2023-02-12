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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File as JoomlaFile;
use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Component\Settings;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Compiler Utilities To Build Structure
 * 
 * @since 3.2.0
 */
class Structure
{
	/**
	 * Compiler Component Joomla Version Settings
	 *
	 * @var    Settings
	 * @since 3.2.0
	 */
	protected Settings $settings;

	/**
	 * Compiler Utilities Paths
	 *
	 * @var    Paths
	 * @since 3.2.0
	 */
	protected Paths $paths;

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
	 * Compiler Utilities Files
	 *
	 * @var    Files
	 * @since 3.2.0
	 */
	protected Files $files;

	/**
	 * Database object to query local DB
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor.
	 *
	 * @param Settings|null         $settings    The compiler component joomla version settings object.
	 * @param Paths|null            $paths       The compiler paths object.
	 * @param Counter|null          $counter     The compiler counter object.
	 * @param File|null             $file        The compiler file object.
	 * @param Files|null            $files       The compiler files object.
	 * @param CMSApplication|null   $app         The CMS Application object.
	 *
	 * @since 3.2.0
	 * @throws \Exception
	 */
	public function __construct(?Settings $settings = null, ?Paths $paths = null,
		?Counter $counter = null, ?File $file = null, ?Files $files = null,
		?CMSApplication $app = null)
	{
		$this->settings = $settings ?: Compiler::_('Component.Settings');
		$this->paths = $paths ?: Compiler::_('Utilities.Paths');
		$this->counter = $counter ?: Compiler::_('Utilities.Counter');
		$this->file = $file ?: Compiler::_('Utilities.File');
		$this->files = $files ?: Compiler::_('Utilities.Files');
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Build Structural Needed Files & Folders
	 *
	 * @param   array        $target    The main target and name
	 * @param   string       $type      The type in the target
	 * @param   string|null  $fileName  The custom file name
	 * @param   array|null   $config    To add more data to the files info
	 *
	 * @return  bool  true on success
	 * @since 3.2.0
	 */
	public function build(array $target, string $type,
		?string $fileName = null, ?array $config = null): bool
	{
		// did we build the files (any number)
		$build_status = false;

		// check that we have the target values
		if (ArrayHelper::check($target))
		{
			// search the target
			foreach ($target as $main => $name)
			{
				// make sure it is lower case
				$name = StringHelper::safe($name);

				// setup the files
				foreach ($this->settings->multiple()->{$main} as $item => $details)
				{
					if ($details->type === $type)
					{
						$file_details = $this->getFileDetails(
							$details,
							(string) $item,
							$name,
							$fileName,
							$config
						);

						if (is_array($file_details))
						{
							// store the new files
							$this->files->appendArray('dynamic.' . $file_details['view'],
								$file_details);

							// we have build at least one
							$build_status = true;
						}
					}
				}
			}
		}

		return $build_status;
	}

	/**
	 * Get the details
	 *
	 * @param   object       $details   The item details
	 * @param   string       $item      The item name
	 * @param   string       $name      The given name
	 * @param   string|null  $fileName  The custom file name
	 * @param   array|null   $config    To add more data to the files info
	 *
	 * @return  array|null  The details
	 * @since 3.2.0
	 */
	private function getFileDetails(object $details, string $item,
		string $name, ?string $fileName = null, ?array $config = null): ?array
	{
		$zip_path = '';
		if (($path = $this->getPath($details, $zip_path, $name)) === null)
		{
			return null;
		}

		// setup the folder
		if (!Folder::exists($path))
		{
			Folder::create($path);
			$this->file->html($zip_path);

			// count the folder created
			$this->counter->folder++;
		}

		$new_name = $this->getNewName($details, $item, $name, $fileName);

		if (!JoomlaFile::exists($path . '/' . $new_name))
		{
			// move the file to its place
			JoomlaFile::copy(
				$this->paths->template_path . '/' . $item,
				$path . '/' . $new_name
			);

			// count the file created
			$this->counter->file++;
		}

		// we can't have dots in a view name
		if (strpos($name, '.') !== false)
		{
			$name = preg_replace('/[\.]+/', '_', (string) $name);
		}

		// setup array for new file
		$file = [
			'path' => $path . '/' . $new_name,
			'name' => $new_name,
			'view' => $name,
			'zip'  => $zip_path . '/' . $new_name
		];

		if (ArrayHelper::check($config))
		{
			$file['config'] = $config;
		}

		return $file;
	}

	/**
	 * Get the path
	 *
	 * @param   object     $details   The item details
	 * @param   string     $zipPath   The zip path
	 * @param   string     $name      The name
	 *
	 * @return  string|null  The path
	 * @since 3.2.0
	 */
	private function getPath(object $details, string &$zipPath, string $name): ?string
	{
		// set destination path
		if (strpos((string) $details->path, 'VIEW') !== false)
		{
			$path = str_replace('VIEW', $name, (string) $details->path);
		}
		else
		{
			$path = $details->path;
		}

		// make sure we have component to replace
		if (strpos((string) $path, 'c0mp0n3nt') !== false)
		{
			$zipPath = str_replace('c0mp0n3nt/', '', (string) $path);

			return str_replace(
				'c0mp0n3nt/', $this->paths->component_path . '/', (string) $path
			);
		}

		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_HR_HTHREECZEROMPZERONTHREENT_ISSUE_FOUNDHTHREEPTHE_PATH_S_COULD_NOT_BE_USEDP',
				$path
			), 'Error'
		);

		return null;
	}

	/**
	 * Get the new name
	 *
	 * @param   object       $details   The item details
	 * @param   string       $item      The item name
	 * @param   string       $name      The name
	 * @param   string|null  $fileName  The custom file name
	 *
	 * @return  string      The new name
	 * @since 3.2.0
	 */
	private function getNewName(object $details, string $item,
		string &$name, ?string $fileName = null): string
	{
		// do the file need renaming
		if ($details->rename)
		{
			if (!empty($fileName))
			{
				$name = $name . '_' . $fileName;

				return str_replace(
					$details->rename, $fileName, $item
				);
			}
			elseif ($details->rename === 'new')
			{
				return $details->newName;
			}

			return str_replace(
				$details->rename, $name, $item
			);
		}

		return $item;
	}

}

