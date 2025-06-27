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

namespace VDM\Joomla\Componentbuilder\Package\Remote\DynamicGet;


use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Componentbuilder\Remote\Set as ExtendingSet;


/**
 * Set Dynamic Get based on function names to remote repository
 * 
 * @since 5.1.1
 */
final class Set extends ExtendingSet implements SetInterface
{
	/**
	 * Map a single item value (view_table_main)
	 *
	 * @param object $item   The source object containing raw values
	 * @param array   $power  The destination associative array where processed values will be stored.
	 *
	 * @return void
	 * @since  5.1.1
	 */
	protected function mapItemValue_view_table_main(object &$item, array &$power): void
	{
		$source = $item->main_source ?? 0;

		// Map source values to field reset lists
		$resetMap = [
			3 => [
				'view_table_main', 'db_table_main', 'filter', 'where',
				'order', 'group', 'global', 'join_view_table', 'join_db_table'
			],
			1 => ['db_table_main', 'php_custom_get'],
			2 => ['view_table_main', 'php_custom_get']
		];

		// Apply common resets if defined
		if (isset($resetMap[$source]))
		{
			foreach ($resetMap[$source] as $field)
			{
				$power[$field] = null;
			}
		}

		// Handle additional conditional assignments
		if ($source === 1)
		{
			$power['view_table_main'] = $item->view_table_main ?? null;
		}

	}
}

