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
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;


/**
 * Model - Get Modified Date
 * 
 * @since 3.2.0
 */
class Modifieddate
{
	/**
	 * The array of last modified dates
	 *
	 * @var     array
	 * @since 3.2.0
	 */
	protected array $last = [];

	/**
	 * Get the last modified date of an item
	 *
	 * @param   array  $item  The item data
	 *
	 * @return  string The modified date
	 * @since 3.2.0
	 */
	public function get(array $item): string
	{
		$key = $this->getKey($item);

		if (!isset($this->last[$key]))
		{
			$date = max($this->getDate($item), $this->getModified($item));

			$this->last[$key] = Factory::getDate($date)->format(
				'jS F, Y'
			);
		}

		return $this->last[$key];
	}

	/**
	 * Get the last modified date of an item
	 *
	 * @param   array  $item  The item data
	 *
	 * @return  int The modified date as int
	 * @since 3.2.0
	 */
	protected function getDate(array $item): int
	{
		if (isset($item['settings']) && isset($item['settings']->modified)
			&& StringHelper::check($item['settings']->modified)
			&& '0000-00-00 00:00:00' !== $item['settings']->modified)
		{
			return strtotime((string) $item['settings']->modified);
		}

		return strtotime("now");
	}

	/**
	 * Get the last modified date of an item's sub items
	 *
	 * @param   array  $item  The item data
	 *
	 * @return  int The modified date as int
	 * @since 3.2.0
	 */
	protected function getModified(array $item): int
	{
		$date = 0;

		// if not settings is found
		if (!isset($item['settings']) || !ObjectHelper::check($item['settings']))
		{
			return $date;
		}

		// check if we have fields
		if (isset($item['settings']->fields) && ArrayHelper::check($item['settings']->fields))
		{
			foreach ($item['settings']->fields as $field)
			{
				if (isset($field['settings'])
					&& ObjectHelper::check($field['settings'])
					&& isset($field['settings']->modified)
					&& StringHelper::check($field['settings']->modified)
					&& '0000-00-00 00:00:00' !== $field['settings']->modified)
				{
					$modified = strtotime((string) $field['settings']->modified);
					$date = max($date, $modified);
				}
			}
		}
		// check if we have a main dynamic get
		elseif (isset($item['settings']->main_get)
			&& ObjectHelper::check($item['settings']->main_get)
			&& isset($item['settings']->main_get->modified)
			&& StringHelper::check($item['settings']->main_get->modified)
			&& '0000-00-00 00:00:00' !== $item['settings']->main_get->modified)
		{
			$modified = strtotime((string) $item['settings']->main_get->modified);
			$date = max($date, $modified);
		}

		return $date;
	}

	/**
	 * Get the key for an item
	 *
	 * @param   array  $item  The item data
	 *
	 * @return  string  The key
	 * @since 3.2.0
	 */
	protected function getKey(array $item): string
	{
		if (isset($item['adminview']))
		{
			return $item['adminview'] . 'admin';
		}
		elseif (isset($item['siteview']))
		{
			return $item['siteview'] . 'site';
		}
		elseif (isset($item['customadminview']))
		{
			return $item['customadminview'] . 'customadmin';
		}

		return 'error';
	}

}

