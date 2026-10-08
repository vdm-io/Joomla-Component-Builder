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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller;


/**
 * Controller Ajax Cases Interface.
 * 
 * @since 6.1.7
 */
interface AjaxCasesInterface
{
	/**
	 * Build the ajax controller cases one build target declares.
	 *
	 * @param   string  $target  The build target, site or administrator.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get($target): string;
}

