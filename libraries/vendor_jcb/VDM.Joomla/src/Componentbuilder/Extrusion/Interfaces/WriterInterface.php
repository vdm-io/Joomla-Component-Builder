<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Interfaces;


/**
 * Persists resolved extrusion state into JCB's own definition tables.
 * 
 * Every implementation writes through the shared Data pipeline so that insert
 * against update is resolved from the GUID and each value is encoded by the
 * store declared in the table definition class. A writer therefore passes raw
 * values and never encodes them itself.
 * 
 * @since 6.1.6
 */
interface WriterInterface
{
	/**
	 * Write this writer's slice of the resolved state.
	 *
	 * @return  int  The number of definitions written.
	 * @since   6.1.6
	 */
	public function write(): int;
}

