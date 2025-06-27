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

namespace VDM\Joomla\Database;


/**
 * Database Default Trait
 * 
 * @since 5.1.1
 */
trait DefaultTrait
{
	/**
	 * Switch to set the defaults
	 *
	 * @var    bool
	 * @since  3.2.0
	 **/
	protected bool $defaults = true;

	/**
	 * Switch to prevent/allow defaults from being added.
	 *
	 * @param   bool    $trigger      toggle the defaults
	 *
	 * @return  self
	 * @since   3.2.0
	 **/
	public function defaults(bool $trigger = true): self
	{
		$this->defaults = $trigger;

		return $this;
	}
}

