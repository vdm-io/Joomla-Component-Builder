<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities\String;


/**
 * Control the naming of a plugin
 */
abstract class PluginHelper
{
	/**
	 * Making plugin folder name safe
	 *
	 * @input	string    $codeName   The name
	 * @input	string    $group   The group name
	 *
	 * @returns string on success
	 */
	public static function safeFolderName($codeName, $group)
	{
		// editors-xtd group plugins must have a class with plgButton<PluginName> structure
		if ($group === 'editors-xtd')
		{
			$group = 'Button';
		}

		return 'plg_' . strtolower($group) . '_' . strtolower(
			$codeName
		);
	}

	/**
	 * Making plugin class name safe
	 *
	 * @input	string    $codeName   The name
	 * @input	string    $group   The group name
	 *
	 * @returns string on success
	 */
	public static function safeClassName($codeName, $group)
	{
		// editors-xtd group plugins must have a class with plgButton<PluginName> structure
		if ($group === 'editors-xtd')
		{
			$group = 'Button';
		}

		return 'Plg' . ucfirst($group) . ucfirst(
			$codeName
		);
	}

	/**
	 * Making plugin install class name safe
	 *
	 * @input	string    $codeName   The name
	 * @input	string    $group   The group name
	 *
	 * @returns string on success
	 */
	public static function safeInstallClassName($codeName, $group)
	{
		// editors-xtd group plugins must have a class with plgButton<PluginName> structure
		if ($group === 'editors-xtd')
		{
			$group = 'Button';
		}

		return 'plg' . ucfirst($group) . ucfirst(
			$codeName
		) . 'InstallerScript';
	}

	/**
	 * Making language prefix safe
	 *
	 * @input	string    $codeName   The name
	 * @input	string    $group   The group name
	 *
	 * @returns string on success
	 */
	public static function safeLangPrefix($codeName, $group)
	{
		// editors-xtd group plugins must have a class with plgButton<PluginName> structure
		if ($group === 'editors-xtd')
		{
			$group = 'Button';
		}

		return 'PLG_' . strtoupper($group) . strtoupper(
			$codeName
		);
	}

}

