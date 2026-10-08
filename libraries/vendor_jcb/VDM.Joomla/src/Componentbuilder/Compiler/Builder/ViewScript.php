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
 * View Script Builder Class
 * 
 * The javascript each admin view carries, keyed by the view code name and then
 * by which of the view's files it belongs in: `fileScript`, `footerScript` or
 * `list_fileScript`. It is built while the view is interpreted and read back
 * when the view's content is assembled.
 * 
 * @since 6.1.7
 */
final class ViewScript extends Registry implements Registryinterface
{
}

