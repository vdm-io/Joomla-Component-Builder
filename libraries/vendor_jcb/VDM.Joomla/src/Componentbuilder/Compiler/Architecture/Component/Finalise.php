<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Joomla\Componentbuilder\Compiler\Builder\ComponentFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Router;
use VDM\Joomla\Componentbuilder\Compiler\Power\Autoloader;
use VDM\Joomla\Componentbuilder\Interfaces\Module\InfusionInterface as ModuleInfusion;
use VDM\Joomla\Componentbuilder\Interfaces\Plugin\InfusionInterface as PluginInfusion;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Everything the component still needs once every file has its content.
 * 
 * @since 6.1.7
 */
final class Finalise
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Config Fieldsets Builder Class.
	 *
	 * @var   ConfigFieldsets
	 * @since 6.1.7
	 */
	protected ConfigFieldsets $configfieldsets;

	/**
	 * The Component Fields Builder Class.
	 *
	 * @var   ComponentFields
	 * @since 6.1.7
	 */
	protected ComponentFields $componentfields;

	/**
	 * The Creator Router Class.
	 *
	 * @var   Router
	 * @since 6.1.7
	 */
	protected Router $router;

	/**
	 * The Power Autoloader Class.
	 *
	 * @var   Autoloader
	 * @since 6.1.7
	 */
	protected Autoloader $autoloader;

	/**
	 * The Joomlamodule Infusion Class.
	 *
	 * @var   ModuleInfusion
	 * @since 6.1.7
	 */
	protected ModuleInfusion $moduleinfusion;

	/**
	 * The Joomlaplugin Infusion Class.
	 *
	 * @var   PluginInfusion
	 * @since 6.1.7
	 */
	protected PluginInfusion $plugininfusion;

	/**
	 * Constructor.
	 *
	 * @param Config          $config              The Config Class.
	 * @param ContentOne      $contentone          The Content One Builder Class.
	 * @param Component       $component           The Component Class.
	 * @param ConfigFieldsets $configfieldsets     The Config Fieldsets Builder Class.
	 * @param ComponentFields $componentfields     The Component Fields Builder Class.
	 * @param Router          $router              The Creator Router Class.
	 * @param Autoloader      $autoloader          The Power Autoloader Class.
	 * @param ModuleInfusion  $moduleinfusion      The Joomlamodule Infusion Class.
	 * @param PluginInfusion  $plugininfusion      The Joomlaplugin Infusion Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		ContentOne $contentone,
		Component $component,
		ConfigFieldsets $configfieldsets,
		ComponentFields $componentfields,
		Router $router,
		Autoloader $autoloader,
		ModuleInfusion $moduleinfusion,
		PluginInfusion $plugininfusion)
	{
		$this->config = $config;
		$this->contentone = $contentone;
		$this->component = $component;
		$this->configfieldsets = $configfieldsets;
		$this->componentfields = $componentfields;
		$this->router = $router;
		$this->autoloader = $autoloader;
		$this->moduleinfusion = $moduleinfusion;
		$this->plugininfusion = $plugininfusion;
	}

	/**
	 * Set everything the component still needs once every file has content.
	 *
	 * The config fieldsets, the site router, the readme and changelog, the
	 * field map, the power autoloader, and the modules and plugins the
	 * component ships with, which borrow the build target and hand it back.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	public function set(): void
	{
		// CONFIG_FIELDSETS
		$this->contentone->set('CONFIG_FIELDSETS',
			implode(PHP_EOL,
				$this->configfieldsets->get('component', [])
			)
		);

		// check if this has been set
		if (!$this->contentone->exists('ROUTER_BUILD_VIEWS')
			|| !StringHelper::check(
				$this->contentone->get('ROUTER_BUILD_VIEWS')
			))
		{
			$this->contentone->set('ROUTER_BUILD_VIEWS', 0);
		}
		else
		{
			$this->contentone->set('ROUTER_BUILD_VIEWS',
				'(' . $this->contentone->get('ROUTER_BUILD_VIEWS') . ')'
			);
		}

		// README
		if ($this->component->get('addreadme'))
		{
			$this->contentone->set('README',
				$this->component->get('readme')
			);
		}

		// CHANGELOG
		if (($changelog = $this->component->get('changelog')) !== null)
		{
			$this->contentone->set('CHANGELOG', $changelog);
		}

		// ROUTER
		if ($this->config->get('joomla_version', 3) != 3)
		{
			// build route constructor before parent call
			$this->contentone->set('SITE_ROUTER_CONSTRUCTOR_BEFORE_PARENT',
				$this->router->getConstructor()
			);
			// build route constructor after parent call
			$this->contentone->set('SITE_ROUTER_CONSTRUCTOR_AFTER_PARENT',
				$this->router->getConstructorAfterParent()
			);
			// build route methods
			$this->contentone->set('SITE_ROUTER_METHODS',
				$this->router->getMethods()
			);
		}

		// all fields stored in database
		$this->contentone->set('ALL_COMPONENT_FIELDS',
			$this->componentfields->varExport(null, 1)
		);

		// set the autoloader for Powers
		$this->autoloader->setFiles();

		// tweak system to set stuff to the module domain
		$_backup_target     = $this->config->build_target;
		$_backup_lang       = $this->config->lang_target;
		$_backup_langPrefix = $this->config->lang_prefix;

		// infuse module data if set
		$this->moduleinfusion->set();

		// infuse plugin data if set
		$this->plugininfusion->set();

		// rest globals
		$this->config->build_target = $_backup_target;
		$this->config->lang_target = $_backup_lang;
		$this->config->set('lang_prefix', $_backup_langPrefix);
	}
}

