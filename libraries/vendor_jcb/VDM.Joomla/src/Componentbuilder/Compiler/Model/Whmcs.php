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


use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Whmcs Class
 * 
 * @since 3.2.0
 */
class Whmcs
{
	/**
	 * Set whmcs links if needed
	 *
	 * @param   object  $item  The extension data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		if (1 == $item->add_license
			&& (!isset($item->whmcs_buy_link)
				|| !StringHelper::check(
					$item->whmcs_buy_link
				)))
		{
			// update with the whmcs url
			if (isset($item->whmcs_url)
				&& StringHelper::check($item->whmcs_url))
			{
				$item->whmcs_buy_link = $item->whmcs_url;
			}
			// use the company website
			elseif (isset($item->website)
				&& StringHelper::check($item->website))
			{
				$item->whmcs_buy_link = $item->website;
				$item->whmcs_url      = rtrim((string) $item->website, '/')
					. '/whmcs';
			}
			// none set
			else
			{
				$item->whmcs_buy_link = '#';
				$item->whmcs_url      = '#';
			}
		}
		// since the license details are not set clear
		elseif (0 == $item->add_license)
		{
			$item->whmcs_key      = '';
			$item->whmcs_buy_link = '';
			$item->whmcs_url      = '';
		}
	}

}

