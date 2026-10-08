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
 * View Document Metadata Interface.
 * 
 * @since 6.1.7
 */
interface DocumentMetadataInterface
{
	/**
	 * Build the statements that set the document metadata of a view.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string;
}

