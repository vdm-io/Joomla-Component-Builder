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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\PluginDataInterface as Plugin;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;


/**
 * Model  Joomla Plugins Class
 * 
 * @since 3.2.0
 */
class Joomlaplugins
{
	/**
	 * Compiler Joomla Plugin Data Class
	 *
	 * @var    Plugin
	 * @since 3.2.0
	 */
	protected Plugin $plugin;

	/**
	 * Constructor
	 *
	 * @param Plugin|null      $plugin    The compiler Joomla plugin data object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Plugin $plugin = null)
	{
		$this->plugin = $plugin ?: Compiler::_('Joomlaplugin.Data');
	}

	/**
	 * Set Joomla Plugins
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		// get all plugins
		$item->addjoomla_plugins = (isset($item->addjoomla_plugins)
			&& JsonHelper::check($item->addjoomla_plugins))
			? json_decode((string) $item->addjoomla_plugins, true) : null;

		if (ArrayHelper::check($item->addjoomla_plugins))
		{
			$joomla_plugins = array_map(
				function ($array) use (&$item) {
					// only load the plugins whose target association calls for it
					if (!isset($array['target']) || $array['target'] != 2)
					{
						return $this->plugin->set(
							$array['plugin'], $item
						);
					}

					return null;
				}, array_values($item->addjoomla_plugins)
			);
		}

		unset($item->addjoomla_plugins);
	}

}

