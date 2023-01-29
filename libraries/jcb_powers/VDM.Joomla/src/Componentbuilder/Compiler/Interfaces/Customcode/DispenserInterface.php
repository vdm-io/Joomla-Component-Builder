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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode;


/**
 * Customcode Dispenser Interface
 * 
 * @since 3.2.0
 */
interface DispenserInterface
{
	/**
	 * Set the script for the customcode dispenser
	 *
	 * @param   string       $script   The script
	 * @param   string       $first    The first key
	 * @param   string|null  $second   The second key (if not set we use only first key)
	 * @param   string|null  $third    The third key (if not set we use only first and second key)
	 * @param   array        $config   The config options
	 * @param   bool         $base64   The switch to decode base64 the script
	 *                                    default: true
	 * @param   bool         $dynamic  The switch to dynamic update the script
	 *                                    default: true
	 * @param   bool         $add      The switch to add to exiting instead of replace
	 *                                    default: false
	 *
	 * @return  bool    true on success
	 * @since 3.2.0
	 */
	public function set(&$script, string $first, ?string $second = null, ?string $third = null,
		array $config = [], bool $base64 = true, bool $dynamic = true, bool $add = false): bool;

	/**
	 * Get the script from the customcode dispenser
	 *
	 * @param string       $first    The first key
	 * @param string       $second   The second key
	 * @param string       $prefix   The prefix to add in front of the script if found
	 * @param string|null  $note     The switch/note to add to the script
	 * @param bool         $unset    The switch to unset the value if found
	 * @param mixed|null   $default  The switch/string to use as default return if script not found
	 * @param string       $suffix   The suffix to add after the script if found
	 *
	 * @return  mixed  The string/script if found or the default value if not found
	 *
	 * @since 3.2.0
	 */
	public function get(string $first, string $second, string $prefix = '', ?string $note = null,
	                    bool $unset = false, $default = null, string $suffix = '');

}

