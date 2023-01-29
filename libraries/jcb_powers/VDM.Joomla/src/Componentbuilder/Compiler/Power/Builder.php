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

namespace VDM\Joomla\Componentbuilder\Compiler\Power;


use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Folder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;


/**
 * Power Builder Class
 * 
 * @since 3.2.0
 */
class Builder
{
	/**
	 * we track the creation of htaccess files
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $htaccess = [];

	/**
	 * Power Objects
	 *
	 * @var    Power
	 * @since 3.2.0
	 **/
	protected Power $power;

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
	 * Compiler Event
	 *
	 * @var    EventInterface
	 * @since 3.2.0
	 */
	protected EventInterface $event;

	/**
	 * Compiler Counter
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
	 * Compiler Utilities Folder
	 *
	 * @var    Folder
	 * @since 3.2.0
	 */
	protected Folder $folder;

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
	 * Constructor
	 *
	 * @param Power|null             $power        The power object.
	 * @param Config|null            $config       The compiler config object.
	 * @param Registry|null          $registry     The compiler registry object.
	 * @param EventInterface|null    $event        The compiler event api object.
	 * @param Counter|null           $counter      The compiler counter object.
	 * @param Paths|null             $paths        The compiler paths object.
	 * @param Folder|null            $folder       The compiler folder object.
	 * @param File|null              $file         The compiler file object.
	 * @param Files|null             $files        The compiler files object.
	 * @param CMSApplication|null    $app          The CMS Application object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Power $power = null, ?Config $config = null,
		?Registry $registry = null, ?EventInterface $event = null,
		?Counter $counter = null, ?Paths $paths = null, ?Folder $folder = null,
		?File $file = null, ?Files $files = null, ?CMSApplication $app = null)
	{
		$this->power = $power ?: Compiler::_('Power');
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->event = $event ?: Compiler::_('Event');
		$this->counter = $counter ?: Compiler::_('Utilities.Counter');
		$this->paths = $paths ?: Compiler::_('Utilities.Paths');
		$this->folder = $folder ?: Compiler::_('Utilities.Folder');
		$this->file = $file ?: Compiler::_('Utilities.File');
		$this->files = $files ?: Compiler::_('Utilities.Files');
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Build the Powers files, folders
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function run()
	{
		if (ArrayHelper::check($this->power->active))
		{
			// for plugin event TODO change event api signatures
			$powers = $this->power->active;
			$component_context = $this->config->component_context;
			// Trigger Event: jcb_ce_onBeforeSetModules
			$this->event->trigger(
				'jcb_ce_onBeforeBuildPowers',
				array(&$component_context, &$powers)
			);
			// for plugin event TODO change event api signatures
			$this->power->active = $powers;

			foreach ($this->power->active as $power)
			{
				if (ObjectHelper::check($power)
					&& isset($power->path)
					&& StringHelper::check(
						$power->path
					))
				{
					// activate dynamic folders
					$this->setDynamicFolders();

					// power path
					$power->full_path        = $this->paths->component_path . '/'
						. $power->path;
					$power->full_path_jcb    = $this->paths->component_path . '/'
						. $power->path_jcb;
					$power->full_path_parent = $this->paths->component_path . '/'
						. $power->path_parent;

					// set the power paths
					$this->registry->set('dynamic_paths.' . $power->key, $power->full_path_parent);

					// create the power folder if it does not exist
					// we do it like this to add html files to each part
					$this->folder->create($power->full_path_jcb);
					$this->folder->create($power->full_path_parent);
					$this->folder->create($power->full_path);

					// set power file
					$fileDetails = array('path' => $power->full_path . '/'
						. $power->file_name . '.php',
					                     'name' => $power->file_name . '.php',
					                     'zip' => $power->file_name . '.php');
					$bom = '<?php' . PHP_EOL . '// A POWER FILE' .
						PHP_EOL . Placefix::_h('BOM') . PHP_EOL;

					// add custom override if found
					if ($power->add_licensing_template == 2)
					{
						$bom = '<?php' . PHP_EOL . $power->licensing_template;
					}
					$this->file->write(
						$fileDetails['path'],
						$bom . PHP_EOL . Placefix::_h('POWERCODE')
						. PHP_EOL . Placefix::_h('POWERLINKER')
					);
					$this->files->appendArray($power->key, $fileDetails);

					// count the file created
					$this->counter->file++;

					// set htaccess once per path
					$this->setHtaccess($power);
				}
			}
		}
	}

	/**
	 * Set the .htaccess for this power path
	 *
	 * @param object   $power    The power object
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function setHtaccess(object &$power)
	{
		if (!isset($this->htaccess[$power->path_jcb]))
		{
			// set the htaccess data
			$data = '# Apache 2.4+' . PHP_EOL .
				'<IfModule mod_authz_core.c>' . PHP_EOL .
				'  Require all denied' . PHP_EOL .
				'</IfModule>' . PHP_EOL . PHP_EOL .
				'# Apache 2.0-2.2' . PHP_EOL .
				'<IfModule !mod_authz_core.c>' . PHP_EOL .
				'  Deny from all' . PHP_EOL .
				'</IfModule>' . PHP_EOL;

			// now we must add the .htaccess file
			$fileDetails = array('path' => $power->full_path_jcb . '/.htaccess',
			                     'name' => '.htaccess',
			                     'zip'  => '.htaccess');
			$this->file->write(
				$fileDetails['path'], $data
			);
			$this->files->appendArray($power->key, $fileDetails);

			// count the file created
			$this->counter->file++;

			// now we must add the htaccess.txt file where the zip package my not get the [.] files
			$fileDetails = array('path' => $power->full_path_jcb . '/htaccess.txt',
			                     'name' => 'htaccess.txt',
			                     'zip'  => 'htaccess.txt');
			$this->file->write(
				$fileDetails['path'], $data
			);
			$this->files->appendArray($power->key, $fileDetails);

			// count the file created
			$this->counter->file++;

			// now we must add the web.config file
			$fileDetails = array('path' => $power->full_path_jcb . '/web.config',
			                     'name' => 'web.config',
			                     'zip'  => 'web.config');
			$this->file->write(
				$fileDetails['path'],
				'<?xml version="1.0"?>' . PHP_EOL .
				'    <system.web>' . PHP_EOL .
				'        <authorization>' . PHP_EOL .
				'            <deny users="*" />' . PHP_EOL .
				'        </authorization>' . PHP_EOL .
				'    </system.web>' . PHP_EOL .
				'</configuration>' . PHP_EOL
			);
			$this->files->appendArray($power->key, $fileDetails);

			// count the file created
			$this->counter->file++;

			// we set these files only once
			$this->htaccess[$power->path_jcb] = true;
		}
	}

	/**
	 * Add the dynamic folders
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function setDynamicFolders()
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

