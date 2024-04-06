<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2020
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Utilities\String;


/**
 * Control the naming of a plugin
 * 
 * @since  3.0.9
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
	 * 
	 * @since  3.0.9
	 */
	public static function safeFolderName(string $codeName, string $group): string
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
	 * 
	 * @since  3.0.9
	 */
	public static function safeClassName(string $codeName, string $group): string
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
	 * 
	 * @since  3.0.9
	 */
	public static function safeInstallClassName(string $codeName, string $group): string
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
	 * 
	 * @since  3.0.9
	 */
	public static function safeLangPrefix(string $codeName, string $group): string
	{
		// editors-xtd group plugins must have a class with plgButton<PluginName> structure
		if ($group === 'editors-xtd')
		{
			$group = 'Button';
		}

		return 'PLG_' . strtoupper($group) . '_' . strtoupper(
			$codeName
		);
	}

}

