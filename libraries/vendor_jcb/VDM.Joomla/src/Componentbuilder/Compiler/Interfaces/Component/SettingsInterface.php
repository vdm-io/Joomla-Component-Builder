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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Component;


/**
 * Compiler Component Settings Interface
 * 
 * @since 3.2.0
 */
interface SettingsInterface
{
	/**
	 * Check if data set is loaded
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function exists(): bool;

	/**
	 * Get Joomla - Folder Structure to Create
	 *
	 * @return  object The version related structure
	 * @since 3.2.0
	 */
	public function structure(): object;

	/**
	 * Get Joomla - Move Multiple Structure
	 *
	 * @return  object The version related multiple structure
	 * @since 3.2.0
	 */
	public function multiple(): object;

	/**
	 * Get Joomla - Move Single Structure
	 *
	 * @return  object  The version related single structure
	 * @since 3.2.0
	 */
	public function single(): object;

	/**
	 * Check if Folder is a Standard Folder
	 *
	 * @param   string  $folder    The folder name
	 *
	 * @return  bool  true if the folder exists
	 * @since 3.2.0
	 */
	public function standardFolder(string $folder): bool;

	/**
	 * Check if File is a Standard Root File
	 *
	 * @param   string  $file    The file name
	 *
	 * @return  bool  true if the file exists
	 * @since 3.2.0
	 */
	public function standardRootFile(string $file): bool;
}

