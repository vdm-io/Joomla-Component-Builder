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

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Extrusion Resolved Registry
 * 
 * Final per-field values, each carrying the precedence tier that produced it.
 * 
 * @since 6.1.6
 */
final class Resolved extends Registry implements Registryinterface
{
}

