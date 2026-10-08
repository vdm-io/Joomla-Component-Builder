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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView;


/**
 * Linked View List Query Interface
 * 
 * @since  6.1.7
 */
interface ListQueryInterface
{
	/**
	 * Get the linked view getter of a model.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $functionName    The generated method name suffix.
	 * @param   string  $key             The key of the linked view.
	 * @param   string  $_key            The plain key column.
	 * @param   string  $parentKey       The key of the parent view.
	 * @param   string  $parent_key      The plain parent key column.
	 * @param   mixed   $globalKey       The property the parent exposes the key on.
	 *
	 * @return  string  The generated getter.
	 *
	 * @since   6.1.7
	 */
	public function get($nameSingleCode, $nameListCode,
		$functionName, $key, $_key, $parentKey, $parent_key, $globalKey);
}

