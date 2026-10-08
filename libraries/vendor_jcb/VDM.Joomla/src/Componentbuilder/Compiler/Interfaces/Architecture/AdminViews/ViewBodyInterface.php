<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews;


/**
 * Admin List View Body Interface
 * 
 * @since  6.1.7
 */
interface ViewBodyInterface
{
	/**
	 * Get the default admin list view body.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  string  The generated default view body.
	 *
	 * @since   6.1.7
	 */
	public function getDefault(string $nameSingleCode, string $nameListCode): string;

	/**
	 * Get the modal admin list view body.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $nameListCode    The list code name of the view.
	 *
	 * @return  string  The generated modal view body.
	 *
	 * @since   6.1.7
	 */
	public function getModal(string $nameSingleCode, string $nameListCode): string;
}

