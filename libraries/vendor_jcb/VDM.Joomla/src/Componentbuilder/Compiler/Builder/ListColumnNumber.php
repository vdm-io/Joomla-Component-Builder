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

namespace VDM\Joomla\Componentbuilder\Compiler\Builder;


use VDM\Joomla\Interfaces\Registryinterface;
use VDM\Joomla\Abstraction\Registry;


/**
 * List Column Number Builder Class.
 * 
 * Counts the columns rendered in each admin list view head so the matching
 * list footer can span the same number of columns. The count is keyed by
 * the list code name of the view.
 * 
 * @since  6.1.7
 */
final class ListColumnNumber extends Registry implements Registryinterface
{
	/**
	 * Increase the column count of a list view by one.
	 *
	 * @param   string  $nameListCode  The list code name of the view.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function increment(string $nameListCode): void
	{
		$this->set($nameListCode, ((int) $this->get($nameListCode, 0)) + 1);
	}
}

