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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Power as CompilerPower;
use VDM\Joomla\Componentbuilder\Compiler\Power\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Power\Autoloader;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\StaticFiles;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Dynamic;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Module;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Plugin;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Power;
use VDM\Joomla\Utilities\FileHelper;


/**
 * Files Updater Class
 * 
 * @since 5.1.2
 */
final class Updater
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The Power Class.
	 *
	 * @var   CompilerPower
	 * @since 5.1.2
	 */
	protected CompilerPower $compilerpower;

	/**
	 * The Extractor Class.
	 *
	 * @var   Extractor
	 * @since 5.1.2
	 */
	protected Extractor $extractor;

	/**
	 * The Autoloader Class.
	 *
	 * @var   Autoloader
	 * @since 5.1.2
	 */
	protected Autoloader $autoloader;

	/**
	 * The Files Class.
	 *
	 * @var   Files
	 * @since 5.1.2
	 */
	protected Files $files;

	/**
	 * The StaticFiles Class.
	 *
	 * @var   StaticFiles
	 * @since 5.1.2
	 */
	protected StaticFiles $staticfiles;

	/**
	 * The Dynamic Class.
	 *
	 * @var   Dynamic
	 * @since 5.1.2
	 */
	protected Dynamic $dynamic;

	/**
	 * The Module Class.
	 *
	 * @var   Module
	 * @since 5.1.2
	 */
	protected Module $module;

	/**
	 * The Plugin Class.
	 *
	 * @var   Plugin
	 * @since 5.1.2
	 */
	protected Plugin $plugin;

	/**
	 * The Power Class.
	 *
	 * @var   Power
	 * @since 5.1.2
	 */
	protected Power $power;

	/**
	 * Constructor.
	 *
	 * @param Config          $config          The Config Class.
	 * @param CompilerPower   $compilerpower   The Power Class.
	 * @param Extractor       $extractor       The Extractor Class.
	 * @param Autoloader      $autoloader      The Autoloader Class.
	 * @param Files           $files           The Files Class.
	 * @param StaticFiles     $staticfiles     The StaticFiles Class.
	 * @param Dynamic         $dynamic         The Dynamic Class.
	 * @param Module          $module          The Module Class.
	 * @param Plugin          $plugin          The Plugin Class.
	 * @param Power           $power           The Power Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, CompilerPower $compilerpower,
		Extractor $extractor, Autoloader $autoloader,
		Files $files, StaticFiles $staticfiles, Dynamic $dynamic,
		Module $module, Plugin $plugin, Power $power)
	{
		$this->config = $config;
		$this->compilerpower = $compilerpower;
		$this->extractor = $extractor;
		$this->autoloader = $autoloader;
		$this->files = $files;
		$this->staticfiles = $staticfiles;
		$this->dynamic = $dynamic;
		$this->module = $module;
		$this->plugin = $plugin;
		$this->power = $power;
	}

	/**
	 * Update all the extensions files
	 *
	 * @return  bool true on success
	 * @since 5.1.2
	 */
	public function update(): bool
	{
		if ($this->files->exists('static') && $this->files->exists('dynamic'))
		{
			if (($super_powers = $this->extractor->get_()) !== null)
			{
				$this->compilerpower->load($super_powers);
			}

			$bom = FileHelper::getContent($this->config->bom_path);

			$this->staticfiles->update($bom);

			$this->dynamic->update($bom);

			$this->module->update($bom);

			$this->plugin->update($bom);

			$this->power->update($bom);

			$this->autoloader->set();

			$this->staticfiles->autoloader($bom);

			$this->files->remove('dynamic');

			return true;
		}

		return false;
	}
}

