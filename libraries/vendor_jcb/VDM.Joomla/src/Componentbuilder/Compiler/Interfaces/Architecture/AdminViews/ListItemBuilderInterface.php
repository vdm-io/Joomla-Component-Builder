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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews;


/**
 * Admin List View Item Builder Interface
 * 
 * @since  6.1.7
 */
interface ListItemBuilderInterface
{
	/**
	 * Get the completed item value for one table row.
	 *
	 * @param  array    $item            The item array.
	 * @param  string   $nameSingleCode  The single view code name.
	 * @param  string   $nameListCode    The list view code name.
	 * @param  string   $itemClass       The table row default class.
	 * @param  bool     $doNotEscape     The do not escape global switch.
	 * @param  bool     $class           The div class adding switch.
	 * @param  ?string  $ref             The link referral string.
	 * @param  string   $classPointer    The class pointer (this or displaydata).
	 * @param  string   $user            The user code name.
	 * @param  ?string  $refview         The override of the referral view code name.
	 *
	 * @return string  The completed item value for the table row.
	 * @since  6.1.7
	 */
	public function get(
		array $item,
		string $nameSingleCode,
		string $nameListCode,
		string &$itemClass,
		bool $doNotEscape,
		bool $class = true,
		?string $ref = null,
		string $classPointer = '$this->',
		string $user = '$this->user',
		?string $refview = null
	): string;
}

