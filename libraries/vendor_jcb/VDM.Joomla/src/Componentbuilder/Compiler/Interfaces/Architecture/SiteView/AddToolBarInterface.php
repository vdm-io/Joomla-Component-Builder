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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\SiteView;


/**
 * Site View Add ToolBar Interface
 * 
 * @since 5.1.4
 */
interface AddToolBarInterface
{
	/**
	 * Build and return the toolbar configuration code for the given view(s).
	 *
	 * @param  array  $view  The view configuration array, including settings and description.
	 *
	 * @return string  The generated PHP toolbar code.
	 * @since  5.1.4
	 */
	public function get(array $view): string;
}

