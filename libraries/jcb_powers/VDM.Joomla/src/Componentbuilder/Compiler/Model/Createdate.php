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


use Joomla\CMS\Factory;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model - Get Create Date
 * 
 * @since 3.2.0
 */
class Createdate
{
	/**
	 * Get the create date of an item
	 *
	 * @param   mixed     $item  The item data
	 *
	 * @return  string The create data
	 * @since 3.2.0
	 */
	public function get(&$item): string
	{
		if (isset($item['settings']->created)
			&& StringHelper::check($item['settings']->created))
		{
			// first set the main date
			$date = strtotime((string) $item['settings']->created);
		}
		else
		{
			// first set the main date
			$date = strtotime("now");
		}

		return Factory::getDate($date)->format('jS F, Y');
	}

}

