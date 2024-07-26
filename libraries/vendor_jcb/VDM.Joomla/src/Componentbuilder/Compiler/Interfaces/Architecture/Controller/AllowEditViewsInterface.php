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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller;


/**
 * Controller Allow Edit Views Interface
 * 
 * @since 5.0.2
 */
interface AllowEditViewsInterface
{
	/**
	 * Get Array Code
	 *
	 * @param array   $views
	 *
	 * @since 5.0.2
	 * @return  string   The array of Code (string)
	 */
	public function getArray(array $views): string;

	/**
	 * Get Custom Function Code
	 *
	 * @param array   $views
	 *
	 * @since 5.0.2
	 * @return  string   The functions of Code (string)
	 */
	public function getFunctions(array $views): string;
}

