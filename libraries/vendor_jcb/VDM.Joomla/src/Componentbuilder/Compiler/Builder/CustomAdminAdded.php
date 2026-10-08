<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Custom Admin Added Builder Class.
 * 
 * Records which custom admin views have already been linked from an admin view, so the menu builders do not add them a second time.
 * 
 * @since  6.1.7
 */
final class CustomAdminAdded extends Registry implements Registryinterface
{
}

