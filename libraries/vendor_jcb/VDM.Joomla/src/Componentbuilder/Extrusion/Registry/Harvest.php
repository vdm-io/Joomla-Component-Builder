<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    22nd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Extrusion Harvest Registry
 * 
 * The powers pipeline's candidate tree: every class found in the given library
 * folders, grouped by library and sub-folder bundle, each carrying its derived
 * identity and whether it already exists as a power. This is the structure a
 * caller presents for approval before anything is written.
 * 
 * @since 6.1.7
 */
final class Harvest extends Registry implements Registryinterface
{
}

