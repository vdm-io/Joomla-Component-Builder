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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\View;


/**
 * View Document Inline Assets Interface.
 * 
 * @since 6.1.7
 */
interface DocumentInlineAssetsInterface
{
	/**
	 * Build the inline stylesheet a view adds to its document.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function css(array &$view): string;

	/**
	 * Build the inline script a view adds to its document.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function js(array &$view): string;
}

