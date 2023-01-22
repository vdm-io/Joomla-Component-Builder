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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Model Auto Loader Class
 * 
 * @since 3.2.0
 */
class Loader
{
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
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param Registry|null              $registry        The compiler registry object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
	}

	/**
	 * Automatically load some stuff
	 *
	 * @param   string       $key      The key mapper
	 * @param   string       $content  The content to search through
	 * @param   string|null  $target   The area being targeted
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $key, string $content, ?string $target = null)
	{
		// set the target
		$target = $target ?: $this->config->build_target;

		// check for footable
		if (!$this->registry->
			exists('builder.footable_scripts.' . $target . '.' . $key))
		{
			if ($this->getFootableScripts($content))
			{
				$this->registry->
					set('builder.footable_scripts.' . $target . '.' . $key, true);

				$this->config->set('footable ', true);
			}
		}

		// check for google chart
		if (!$this->registry->
			exists('builder.google_chart.' . $target . '.' . $key))
		{
			if ($this->getGoogleChart($content))
			{
				$this->registry->
					set('builder.google_chart.' . $target . '.' . $key, true);

				$this->config->set('google_chart', true);
			}
		}

		// check for get module
		if (!$this->registry->
			exists('builder.get_module.' . $target . '.' . $key))
		{
			if ($this->getGetModule($content))
			{
				$this->registry->
					set('builder.get_module.' . $target . '.' . $key, true);
			}
		}
	}

	/**
	 * Automatically load uikit version 2 data files
	 *
	 * @param   string       $key      The key mapper
	 * @param   string       $content  The content to search through
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function uikit(string $key, string $content)
	{
		// get/set uikit state
		$uikit = false;
		$uikit_ = $this->config->get('uikit', 0);

		// add uikit if required
		if (2 == $uikit_ || 1 == $uikit_)
		{
			$uikit = true;
		}

		// load uikit
		if ($uikit)
		{
			// set uikit to views TODO: convert this getUikitComp to a class
			if (($found = Helper::_('getUikitComp', 
					[$content, (array) $this->registry->get('builder.uikit_comp.' . $key, [])]
				)) !== false)
			{
				$this->registry->set('builder.uikit_comp.' . $key, $found);
			}
		}
	}

	/**
	 * Check for footable scripts
	 *
	 * @param   string  $content  The content to check
	 *
	 * @return  boolean True if found
	 * @since 3.2.0
	 */
	protected function getFootableScripts(string &$content): bool
	{
		return strpos($content, 'footable') !== false;
	}

	/**
	 * Check for getModules script
	 *
	 * @param   string  $content  The content to check
	 *
	 * @return  boolean True if found
	 * @since 3.2.0
	 */
	protected function getGetModule(string &$content): bool
	{
		return strpos($content, 'this->getModules(') !== false;
	}

	/**
	 * Check for get Google Chart script
	 *
	 * @param   string  $content  The content to check
	 *
	 * @return  boolean True if found
	 * @since 3.2.0
	 */
	protected function getGoogleChart(string &$content): bool
	{
		return strpos($content, 'Chartbuilder(') !== false;
	}

}

