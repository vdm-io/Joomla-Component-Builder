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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\View;


use VDM\Joomla\Componentbuilder\Compiler\Builder\FootableScripts as FootableScriptsBuilder;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\FootableScriptsInterface;


/**
 * View Footable Scripts Loader Class.
 * 
 * Gives a view the footable scripts it needs. Only a view that was found to
 * have a footable table on it gets them, and it gets them without the
 * initialisation an admin view asks for.
 * 
 * @since  6.1.7
 */
final class FootableScriptsLoader
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Footable Scripts Builder Class.
	 *
	 * @var   FootableScriptsBuilder
	 * @since 6.1.7
	 */
	protected FootableScriptsBuilder $footablescripts;

	/**
	 * The Footable Scripts Class.
	 *
	 * @var   FootableScriptsInterface
	 * @since 6.1.7
	 */
	protected FootableScriptsInterface $scripts;

	/**
	 * Constructor.
	 *
	 * @param Config                    $config           The Config Class.
	 * @param FootableScriptsBuilder    $footablescripts  The Footable Scripts Builder Class.
	 * @param FootableScriptsInterface  $scripts          The Footable Scripts Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		FootableScriptsBuilder $footablescripts,
		FootableScriptsInterface $scripts)
	{
		$this->config = $config;
		$this->footablescripts = $footablescripts;
		$this->scripts = $scripts;
	}

	/**
	 * Build the statements that load the footable scripts a view needs.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string  The statements, or nothing when the view has no footable table.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string
	{
		if ($this->footablescripts->
			exists($this->config->build_target . '.' . $view['settings']->code))
		{
			return $this->scripts->get(false);
		}

		return '';
	}
}

