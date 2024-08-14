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

namespace VDM\Joomla\Componentbuilder\Interfaces\Plugin;


/**
 * Plug-in Infusion Interface
 * 
 * @since 5.0.2
 */
interface InfusionInterface
{
	/**
	 * Infuse the plugin data into the content.
	 *
	 * This method processes each plugin in the data set, triggering events
	 * before and after infusion, setting placeholders, and adding content
	 * such as headers, classes, and XML configurations.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function set(): void;
}

