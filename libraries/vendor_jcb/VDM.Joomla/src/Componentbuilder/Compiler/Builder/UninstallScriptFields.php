<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * Uninstall Script Fields Builder Class
 * 
 * The views whose custom fields the component registered, keyed by view code
 * name. A view listed here has its fields and field groups removed as well as
 * itself when the component is uninstalled.
 * 
 * @since 6.1.7
 */
final class UninstallScriptFields extends Registry implements Registryinterface
{
}

