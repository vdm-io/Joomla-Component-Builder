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

namespace VDM\Joomla\Interfaces\Import;


/**
 * Parent Table Interface
 * 
 * @since  5.1.4
 */
interface ParentTableInterface
{
	/**
	 * Set the parent data
	 *
	 * @param   string  $linkKey      The parent linker key field.
	 * @param   string  $parentKey    The parent key field.
	 * @param   string  $parentTable  The parent table.
	 *
	 * @return  mixed  The parent value
	 * @since  5.0.2
	 *
	 * @throws  \UnexpectedValueException
	 * @throws  \DomainException
	 */
	public function set(string $linkKey, string $parentKey, string $parentTable);
}

