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
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Plugin\Routes;
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
	 * The Api Plugin Routes Class.
	 *
	 * @var    Routes
	 * @since  6.1.7
	 */
	protected Routes $routes;

	/**
	 * Constructor
	 *
	 * @param Plugin|null      $plugin    The compiler Joomla plugin data object.
	 * @param Routes|null      $routes    The Api Plugin Routes Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Plugin $plugin = null, ?Routes $routes = null)
	{
		$this->plugin = $plugin ?: Compiler::_('Joomlaplugin.Data');
		$this->routes = $routes ?: Compiler::_('Architecture.Api.Plugin.Routes');
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
			// make the API routes of the admin views available to the plugins
			$this->routes->set(
				ArrayHelper::check($item->admin_views ?? null) ? $item->admin_views : [],
				ArrayHelper::check($item->custom_admin_views ?? null) ? $item->custom_admin_views : [],
				ArrayHelper::check($item->site_views ?? null) ? $item->site_views : []
			);

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

