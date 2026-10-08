<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    23rd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Registry;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Extrusion Decision Registry
 * 
 * The caller's pairing verdicts: for each harvested candidate, whether it is
 * created new, updates a named existing definition, or is ignored. The
 * interface collects these against the harvest tree and passes them back, and
 * the writers consult them before settling any identity.
 * 
 * @since 6.1.7
 */
final class Decision extends Registry implements Registryinterface
{
}

