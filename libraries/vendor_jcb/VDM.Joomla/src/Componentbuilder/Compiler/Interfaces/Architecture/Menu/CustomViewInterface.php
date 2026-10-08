<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    15th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Menu;


/**
 * Custom View Menu Interface
 * 
 * @since  6.1.7
 */
interface CustomViewInterface
{
	/**
	 * Get the custom/site view menu metadata XML.
	 *
	 * @param   array  $view  The view definition with its settings object.
	 *
	 * @return  string  The menu metadata XML, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function get(array $view): string;

	/**
	 * Prepare frontend parameter fields for menu use.
	 *
	 * @param   array   $params  The parameter field XML strings.
	 * @param   string  $view    The view code name.
	 *
	 * @return  array  The parameter fields to keep.
	 *
	 * @since   6.1.7
	 */
	public function params(array $params, string $view): array;
}

