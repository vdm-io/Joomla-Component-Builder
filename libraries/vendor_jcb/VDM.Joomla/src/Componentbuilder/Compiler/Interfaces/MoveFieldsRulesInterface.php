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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces;


/**
 * Move Fields Rules Interface
 * 
 * @since 5.1.2
 */
interface MoveFieldsRulesInterface
{
	/**
	 * Move the field and its associated rules.
	 *
	 * @param   array   $field  The field data.
	 * @param   string  $path   The target path to move to.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	public function move(array $field, string $path): void;
}

