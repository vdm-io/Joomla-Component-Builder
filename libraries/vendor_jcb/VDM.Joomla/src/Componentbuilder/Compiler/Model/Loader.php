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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FootableScripts;
use VDM\Joomla\Componentbuilder\Compiler\Builder\GoogleChart;
use VDM\Joomla\Componentbuilder\Compiler\Builder\GetModule;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UikitComp;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Model Auto Loader Class
 * 
 * @since 3.2.0
 */
class Loader
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The FootableScripts Class.
	 *
	 * @var   FootableScripts
	 * @since 3.2.0
	 */
	protected FootableScripts $footablescripts;

	/**
	 * The GoogleChart Class.
	 *
	 * @var   GoogleChart
	 * @since 3.2.0
	 */
	protected GoogleChart $googlechart;

	/**
	 * The GetModule Class.
	 *
	 * @var   GetModule
	 * @since 3.2.0
	 */
	protected GetModule $getmodule;

	/**
	 * The UikitComp Class.
	 *
	 * @var   UikitComp
	 * @since 3.2.0
	 */
	protected UikitComp $uikitcomp;

	/**
	 * Constructor.
	 *
	 * @param Config            $config            The Config Class.
	 * @param FootableScripts   $footablescripts   The FootableScripts Class.
	 * @param GoogleChart       $googlechart       The GoogleChart Class.
	 * @param GetModule         $getmodule         The GetModule Class.
	 * @param UikitComp         $uikitcomp         The UikitComp Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, FootableScripts $footablescripts,
		GoogleChart $googlechart, GetModule $getmodule, UikitComp $uikitcomp)
	{
		$this->config = $config;
		$this->footablescripts = $footablescripts;
		$this->googlechart = $googlechart;
		$this->getmodule = $getmodule;
		$this->uikitcomp = $uikitcomp;
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
		if (!$this->footablescripts->exists($target . '.' . $key))
		{
			if ($this->getFootableScripts($content))
			{
				$this->footablescripts->set($target . '.' . $key, true);

				$this->config->set('footable', true);
			}
		}

		// check for google chart
		if (!$this->googlechart->exists($target . '.' . $key))
		{
			if ($this->getGoogleChart($content))
			{
				$this->googlechart->set($target . '.' . $key, true);

				$this->config->set('google_chart', true);
			}
		}

		// check for get module
		if (!$this->getmodule->exists($target . '.' . $key))
		{
			if ($this->getGetModule($content))
			{
				$this->getmodule->set($target . '.' . $key, true);
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
					[$content, $this->uikitcomp->get($key, [])]
				)) !== false)
			{
				$this->uikitcomp->set($key, $found);
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

