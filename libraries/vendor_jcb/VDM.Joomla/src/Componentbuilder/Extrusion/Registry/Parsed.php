<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    29th September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Run-scoped lexical Power observations keyed by the complete source digest.
 * 
 * Context, placement and identity are deliberately absent. Each harvest still
 * reads the source bytes and metadata before it reuses a lexical observation.
 * Scope clears these observations between independent operations.
 * 
 * @since  6.2.0
 */
final class Parsed extends Registry implements Registryinterface
{
}

