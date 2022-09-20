<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * Compiler Power Interface
 * 
 * @since 3.2.0
 */
interface PowerInterface
{
	/**
	 * load all the powers linked to this component
	 *
	 * @param array   $guids    The global unique ids of the linked powers
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function load(array $guids);

	/**
	 * Get a power
	 *
	 * @param string   $guid    The global unique id of the power
	 * @param int        $build    Force build switch (to override global switch)
	 *
	 * @return mixed
	 * @since 3.2.0
	 */
	public function get(string $guid, int $build = 0);
}

