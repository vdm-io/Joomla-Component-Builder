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

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Second Run Admin Builder Class
 * 
 * Work an admin view defers to a second pass, keyed by the method that must
 * run it. Building an edit body discovers linked views whose own views are
 * not compiled yet, so it queues them here and the infusion runs the queue
 * once every view exists.
 * 
 * @since 6.1.7
 */
final class SecondRunAdmin extends Registry implements Registryinterface
{
}

