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

namespace VDM\Joomla\Componentbuilder\Remote;


use VDM\Joomla\Interfaces\Remote\GetInterface;
use VDM\Joomla\Abstraction\Remote\Get as ExtendingGet;


/**
 * Remote Get of an Entity
 * 
 * @since 3.2.0
 */
final class Get extends ExtendingGet implements GetInterface
{
}

