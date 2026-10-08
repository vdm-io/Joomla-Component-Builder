<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\View;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\UikitLoader as ExtendingUikitLoader;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\View\UikitLoaderInterface;


/**
 * View Uikit Loader Class for Joomla 6
 * 
 * Joomla 6 does not carry uikit, so nothing is loaded. A component that still
 * needs it adds it through the libraries.
 * 
 * @since 6.1.7
 */
final class UikitLoader extends ExtendingUikitLoader implements UikitLoaderInterface
{
	/**
	 * Build the statements that load the uikit assets a view needs.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(array $view): string
	{
		return '';
	}
}

