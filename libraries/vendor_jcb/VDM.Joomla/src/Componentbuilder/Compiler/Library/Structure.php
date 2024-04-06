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

namespace VDM\Joomla\Componentbuilder\Compiler\Library;


use Joomla\CMS\Filesystem\Folder as JoomlaFolder;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Content;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Folder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\FileHelper;


/**
 * Library Structure Builder Class
 * 
 * @since 3.2.0
 */
class Structure
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 3.2.0
	 */
	protected Component $component;

	/**
	 * The ContentOne Class.
	 *
	 * @var   Content
	 * @since 3.2.0
	 */
	protected Content $content;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 3.2.0
	 */
	protected Paths $paths;

	/**
	 * The Folder Class.
	 *
	 * @var   Folder
	 * @since 3.2.0
	 */
	protected Folder $folder;

	/**
	 * The File Class.
	 *
	 * @var   File
	 * @since 3.2.0
	 */
	protected File $file;

	/**
	 * Constructor.
	 *
	 * @param Config      $config      The Config Class.
	 * @param Registry    $registry    The Registry Class.
	 * @param Event       $event       The EventInterface Class.
	 * @param Component   $component   The Component Class.
	 * @param Content     $content     The ContentOne Class.
	 * @param Counter     $counter     The Counter Class.
	 * @param Paths       $paths       The Paths Class.
	 * @param Folder      $folder      The Folder Class.
	 * @param File        $file        The File Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Registry $registry, Event $event,
		Component $component, Content $content, Counter $counter,
		Paths $paths, Folder $folder, File $file)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->event = $event;
		$this->component = $component;
		$this->content = $content;
		$this->counter = $counter;
		$this->paths = $paths;
		$this->folder = $folder;
		$this->file = $file;
	}

	/**
	 * Build the Libraries files, folders, url's and config
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function build()
	{
		if (($libraries_ = $this->registry->get('builder.libraries')) !== null)
		{
			// for plugin event TODO change event api signatures
			$component_context = $this->config->component_context;

			// Trigger Event: jcb_ce_onBeforeSetLibraries
			$this->event->trigger(
				'jcb_ce_onBeforeSetLibraries',
				array(&$component_context, &$libraries_)
			);

			// creat the main component folder
			if (!JoomlaFolder::exists($this->paths->component_path))
			{
				JoomlaFolder::create($this->paths->component_path);

				// count the folder created
				$this->counter->folder++;
				$this->file->html('');
			}

			// create media path if not set
			$this->folder->create($this->paths->component_path . '/media');
			foreach ($libraries_ as $id => &$library)
			{
				if (ObjectHelper::check($library))
				{
					// check if this lib has files
					if (isset($library->files)
						&& ArrayHelper::check($library->files))
					{
						// add to component files
						foreach ($library->files as $file)
						{
							$this->component->appendArray('files', $file);
						}
					}

					// check if this lib has folders
					if (isset($library->folders)
						&& ArrayHelper::check(
							$library->folders
						))
					{
						// add to component folders
						foreach ($library->folders as $folder)
						{
							$this->component->appendArray('folders', $folder);
						}
					}

					// check if this lib has urls
					if (isset($library->urls)
						&& ArrayHelper::check($library->urls))
					{
						// build media folder path
						$libFolder = strtolower(
							preg_replace(
								'/\s+/', '-',
								(string) StringHelper::safe(
									$library->name, 'filename', ' ', false
								)
							)
						);
						$mediaPath = '/media/' . $libFolder;

						// should we add the local folder
						$addLocalFolder = false;

						// add to component urls
						foreach ($library->urls as $n => &$url)
						{
							if (isset($url['type']) && $url['type'] > 1
								&& isset($url['url'])
								&& StringHelper::check(
									$url['url']
								))
							{
								// create media/lib path if not set
								$this->folder->create(
									$this->paths->component_path . $mediaPath
								);

								// add local folder
								$addLocalFolder = true;

								// set file name
								$fileName = basename((string) $url['url']);

								// get the file contents
								$data = FileHelper::getContent(
									$url['url']
								);

								// build sub path
								if (strpos($fileName, '.js') !== false)
								{
									$path = '/js';
								}
								elseif (strpos($fileName, '.css') !== false)
								{
									$path = '/css';
								}
								else
								{
									$path = '';
								}

								// create sub media path if not set
								$this->folder->create(
									$this->paths->component_path . $mediaPath . $path
								);

								// set the path to library file
								$url['path'] = $mediaPath . $path . '/'
									. $fileName; // we need this for later

								// set full path
								$path = $this->paths->component_path . $url['path'];

								// write data to path
								$this->file->write($path, $data);

								// count the file created
								$this->counter->file++;
							}
						}

						// only add if local
						if ($addLocalFolder)
						{
							// add folder to xml of media folders
							$this->content->add('EXSTRA_MEDIA_FOLDERS',
								PHP_EOL . Indent::_(2) . "<folder>"
								. $libFolder . "</folder>");
						}
					}

					// if config fields are found load into component config (avoiding duplicates)
					if (isset($library->how) && $library->how > 1
						&& isset($library->config)
						&& ArrayHelper::check($library->config))
					{
						foreach ($library->config as $cofig)
						{
							$found = array_filter(
								$this->component->get('config'),
								fn($item) => $item['field'] == $cofig['field']
							);

							// set the config data if not found
							if (!ArrayHelper::check($found))
							{
								$this->component->appendArray('config', $cofig);
							}
						}
					}

					// update the global value just in case for now
					$this->registry->set("builder.libraries.$id", $library);
				}
			}
		}
	}
}

