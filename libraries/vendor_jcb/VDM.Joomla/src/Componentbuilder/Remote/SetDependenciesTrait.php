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

namespace VDM\Joomla\Componentbuilder\Remote;


/**
 * The Set Dependencies Method
 * 
 * @since 5.1.1
 */
trait SetDependenciesTrait
{
	/**
	 * Load dependency records into the tracker.
	 *
	 * This method supports each dependency item being either an object or an associative array.
	 * It verifies the presence of the `key`, `value`, and `entity` properties before adding them to the tracker.
	 *
	 * @param object $power  The remote power object
	 *
	 * @return void
	 * @since 5.1.1
	 */
	protected function setDependencies(object $power): void
	{
		$dependencies = $power->{"@dependencies"} ?? [];

		if (empty($dependencies))
		{
			return;
		}

		foreach ($dependencies as $item)
		{
			// Support both object and array types
			$key    = is_array($item) ? ($item['key'] ?? null)    : ($item->key    ?? null);
			$value  = is_array($item) ? ($item['value'] ?? null)  : ($item->value  ?? null);
			$entity = is_array($item) ? ($item['entity'] ?? null) : ($item->entity ?? null);
			$table = is_array($item) ? ($item['table'] ?? null) : ($item->table ?? null);

			if (empty($key) || empty($value) || empty($entity))
			{
				continue;
			}

			if ($table === 'file_system')
			{
				$pointer = str_replace('.', '--', $key);
				if (!$this->tracker->exists("{$entity}.save.{$pointer}"))
				{
					$this->tracker->set("{$entity}.get.{$pointer}", $item);
				}
			}
			elseif (!$this->tracker->exists("save.{$entity}.{$key}|{$value}"))
			{
				$this->tracker->set("get.{$entity}.{$key}|{$value}", $item);
			}
		}
	}
}

