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
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\Data as Module;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;


/**
 * Model  Joomla Modules Class
 * 
 * @since 3.2.0
 */
class Joomlamodules
{
	/**
	 * Compiler Joomla Module Data Class
	 *
	 * @var    Module
	 * @since 3.2.0
	 */
	protected Module $module;

	/**
	 * Constructor
	 *
	 * @param Module|null      $module    The compiler Joomla module data object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Module $module = null)
	{
		$this->module = $module ?: Compiler::_('Joomlamodule.Data');
	}

	/**
	 * Set Joomla Module
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		// get all modules
		$item->addjoomla_modules = (isset($item->addjoomla_modules)
			&& JsonHelper::check($item->addjoomla_modules))
			? json_decode((string) $item->addjoomla_modules, true) : null;

		if (ArrayHelper::check($item->addjoomla_modules))
		{
			$joomla_modules = array_map(
				function ($array) use (&$item) {
					// only load the modules whose target association calls for it
					if (!isset($array['target']) || $array['target'] != 2)
					{
						return $this->module->set(
							$array['module'], $item
						);
					}

					return null;
				}, array_values($item->addjoomla_modules)
			);
		}

		unset($item->addjoomla_modules);
	}

}

