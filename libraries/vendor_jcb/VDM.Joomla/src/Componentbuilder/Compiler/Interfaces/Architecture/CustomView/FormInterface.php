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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView;


/**
 * Custom View Form Interface.
 * 
 * @since 6.1.7
 */
interface FormInterface
{
	/**
	 * Build the form tag a custom view is wrapped in.
	 *
	 * @param   string  $view     The view being built.
	 * @param   int     $gettype  What the main get method of the view returns.
	 * @param   int     $type     Which half of the form is wanted, the top or the bottom.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(&$view, &$gettype, $type): string;
}

