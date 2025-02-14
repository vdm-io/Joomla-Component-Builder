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

namespace VDM\Joomla\Componentbuilder\Interfaces;


/**
 * Import Row Interface
 * 
 * @since  3.0.3
 */
interface ImportRowInterface
{
	/**
	 * Set the row details
	 *
	 * @param   int        $index    The row index
	 * @param   array   $values   The values
	 *
	 * @return  void
	 * @since  3.0.3
	 */
	public function set(int $index, array $values): void;

	/**
	 * Clear the row details
	 *
	 * @return  self
	 * @since  3.0.3
	 */
	public function clear(): self;

	/**
	 * Get Index
	 *
	 * @return  int
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  3.0.3
	 */
	public function getIndex(): int;

	/**
	 * Get Value
	 *
	 * @return  mixed
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  3.0.3
	 */
	public function getValue(string $key);

	/**
	 * Unset Value
	 *
	 * @return  void
	 * @throws \InvalidArgumentException if any of the parameters are null or empty.
	 * @since  3.0.3
	 */
	public function unsetValue(string $key): void;
}

