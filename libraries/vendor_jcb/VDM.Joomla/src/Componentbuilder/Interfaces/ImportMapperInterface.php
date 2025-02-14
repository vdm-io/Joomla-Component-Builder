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
 * Import Mapper Interface
 * 
 * @since  3.0.3
 */
interface ImportMapperInterface
{
	/**
	 * Set the tables mapper
	 *
	 * @param   object  $map          The import file map.
	 * @param   string  $parentTable  The parent table name.
	 *
	 * @return  void
	 * @since  4.0.3
	 */
	public function set(object $map, string $parentTable): void;

	/**
	 * Get the parent table keys
	 *
	 * @return  array
	 * @since  4.0.3
	 */
	public function getParent(): array;

	/**
	 * Get the join tables keys
	 *
	 * @return  array
	 * @since  4.0.3
	 */
	public function getJoin(): array;
}

