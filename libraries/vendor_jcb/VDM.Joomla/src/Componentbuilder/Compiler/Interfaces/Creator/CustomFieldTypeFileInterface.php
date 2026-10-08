<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator;


/**
 * Custom Field Type File Creator Interface
 * 
 * @since  6.1.7
 */
interface CustomFieldTypeFileInterface
{
	/**
	 * Build the field type file of one custom field.
	 *
	 * @param   array   $data            The custom field definition.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(array $data, string $nameListCode, string $nameSingleCode): void;
}

