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

namespace VDM\Joomla\Componentbuilder\Interfaces\File;


use VDM\Joomla\Interfaces\File\TypeDefinitionInterface as ExtendingTypeDefinitionInterface;


/**
 * File Type Definition Interface
 * 
 * Represents a complete file type definition including upload rules, access rules, and metadata.
 * 
 * This class extends the original concept with additional
 *    JCB-driven configuration options such as GUID, access,
 *    quantity limits, and crop settings.
 * 
 * @since  5.1.4
 */
interface TypeDefinitionInterface extends ExtendingTypeDefinitionInterface
{
	/**
	 * Get GUID.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function guid(): string;

	/**
	 * Get human-readable name.
	 *
	 * @return string
	 * @since  5.1.4
	 */
	public function name(): string;

	/**
	 * Get upload access level.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function access(): int;

	/**
	 * Get quantity limit.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function quantity(): int;

	/**
	 * Get download access level.
	 *
	 * @return int
	 * @since  5.1.4
	 */
	public function downloadAccess(): int;

	/**
	 * Get crop configuration.
	 *
	 * @return array
	 * @since  5.1.4
	 */
	public function crop(): array;
}

