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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Tabs Class
 * 
 * @since 3.2.0
 */
class Tabs
{
	/**
	 * Set the local tabs
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addtabs = (isset($item->addtabs)
			&& JsonHelper::check($item->addtabs))
			? json_decode((string) $item->addtabs, true) : null;

		if (ArrayHelper::check($item->addtabs))
		{
			$nr = 1;
			foreach ($item->addtabs as $tab)
			{
				$item->tabs[$nr] = trim((string) $tab['name']);
				$nr++;
			}
		}

		// if Details tab is not set, then set it here
		if (!isset($item->tabs[1]))
		{
			$item->tabs[1] = 'Details';
		}

		// always make sure that publishing is lowercase
		if (($removeKey = array_search(
				'publishing', array_map('strtolower', $item->tabs)
			)) !== false)
		{
			$item->tabs[$removeKey] = 'publishing';
		}

		// make sure to set the publishing tab (just in case we need it)
		$item->tabs[15] = 'publishing';

		unset($item->addtabs);
	}

}

