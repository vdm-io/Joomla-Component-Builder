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

namespace VDM\Joomla\Interfaces\Remote;


/**
 * Set data based on global unique ids to remote system
 * 
 * @since 3.2.2
 */
interface SetInterface
{
	/**
	 * Set the current active table
	 *
	 * @param string $table The table that should be active
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function table(string $table): self;

	/**
	 * Set the current active area
	 *
	 * @param string $area The area that should be active
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function area(string $area): self;

	/**
	 * Set the settings path
	 *
	 * @param string    $settingsPath    The repository settings path
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function setSettingsPath(string $settingsPath): self;

	/**
	 * Set the index settings path
	 *
	 * @param string    $settingsIndexPath    The repository index settings path
	 *
	 * @return self
	 * @since 3.2.2
	 */
	public function setIndexSettingsPath(string $settingsIndexPath): self;

	/**
	 * Save items remotely
	 *
	 * @param array   $guids    The global unique id of the item
	 *
	 * @return bool
	 * @throws \Exception
	 * @since 3.2.2
	 */
	public function items(array $guids): bool;
}

