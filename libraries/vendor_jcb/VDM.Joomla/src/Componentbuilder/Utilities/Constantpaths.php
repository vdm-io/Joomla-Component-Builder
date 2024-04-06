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

namespace VDM\Joomla\Componentbuilder\Utilities;


/**
 * Utilities Constant Paths
 * 
 * @since 3.2.0
 */
class Constantpaths
{
	/**
	 * The array of constant paths
	 * 
	 * JPATH_SITE is meant to represent the root path of the JSite application,
	 * just as JPATH_ADMINISTRATOR is mean to represent the root path of the JAdministrator application.
	 * 
	 *    JPATH_BASE is the root path for the current requested application.... so if you are in the administrator application:
	 * 
	 *    JPATH_BASE == JPATH_ADMINISTRATOR
	 * 
	 * If you are in the site application:
	 * 
	 *    JPATH_BASE == JPATH_SITE
	 * 
	 * If you are in the installation application:
	 * 
	 *    JPATH_BASE == JPATH_INSTALLATION.
	 * 
	 *    JPATH_ROOT is the root path for the Joomla install and does not depend upon any application.
	 * 
	 * @var     array
	 * @since 3.2.0
	 */
	protected array $paths = [
		// The path to the administrator folder.
		'JPATH_ADMINISTRATOR' => JPATH_ADMINISTRATOR,
		// The path to the installed Joomla! site, or JPATH_ROOT/administrator if executed from the backend.
		'JPATH_BASE' => JPATH_BASE,
		// The path to the cache folder.
		'JPATH_CACHE' => JPATH_CACHE,
		// The path to the administration folder of the current component being executed.
		'JPATH_COMPONENT_ADMINISTRATOR' => JPATH_COMPONENT_ADMINISTRATOR,
		// The path to the site folder of the current component being executed.
		'JPATH_COMPONENT_SITE' => JPATH_COMPONENT_SITE,
		// The path to the current component being executed.
		'JPATH_COMPONENT' => JPATH_COMPONENT,
		// The path to folder containing the configuration.php file.
		'JPATH_CONFIGURATION' => JPATH_CONFIGURATION,
		// The path to the installation folder.
		'JPATH_INSTALLATION' => JPATH_INSTALLATION,
		// The path to the libraries folder.
		'JPATH_LIBRARIES' => JPATH_LIBRARIES,
		// The path to the plugins folder.
		'JPATH_PLUGINS' => JPATH_PLUGINS,
		// The path to the installed Joomla! site.
		'JPATH_ROOT' => JPATH_ROOT,
		// The path to the installed Joomla! site.
		'JPATH_SITE' => JPATH_SITE,
		// The path to the templates folder.
		'JPATH_THEMES' => JPATH_THEMES
	];

	/**
	 * get array of constant paths or just one constant path
	 *
	 * @param   string|null   $path   The path to get
	 *
	 * @return array|string|null
	 * @since 3.2.0
	 */
	public function get(?string $path = null)
	{
		if (is_null($path))
		{
			return $this->paths;
		}

		return $this->paths[$path] ?? null;
	}

}

