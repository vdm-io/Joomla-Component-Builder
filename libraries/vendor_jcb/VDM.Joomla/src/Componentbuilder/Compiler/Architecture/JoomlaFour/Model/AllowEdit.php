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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Model;


use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\AllowEditInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\AllowEdit as ExtendingAllowEdit;


/**
 * Model Allow Edit Class for Joomla 4
 * 
 * @since 5.1.4
 */
final class AllowEdit extends ExtendingAllowEdit implements AllowEditInterface
{
}

