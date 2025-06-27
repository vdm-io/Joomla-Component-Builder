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

namespace VDM\Joomla\Componentbuilder\Table;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Interfaces\TableInterface;
use VDM\Joomla\Componentbuilder\Table;


/**
 * Joomla Component Builder Tables Search
 * 
 * @since 5.1.0
 */
final class Search extends Table implements TableInterface
{
	/**
	 * Loops over the $tables array and builds a new array with:
	 *  - 'search': an array of field names where type is "text", "textarea", or "editor"
	 *  - 'name': the field name whose 'title' property is true,
	 *  - 'views': the list view name
	 *  - 'not_base64': all the fields not base64 encoded, and what their encoding is
	 *  - 'name': the row name field
	 *  - 'name_link': the row name linking data, to get the string value of the name where needed
	 *
	 * @param string  $area  The target areas to search
	 *
	 * @return array The newly built array.
	 * @since  5.1.0
	 */
	public function getTextSearchSet(string $area): array
	{
		$result = [];

		// Loop over each table in the tables array.
		foreach ($this->tables as $tableName => $fields)
		{
			// get the row field name
			$name = $this->titleName($tableName);

			// Initialize the structure for each table.
			$result[$tableName] = [
				'search' => ['id'],
				'views' => null,
				'decode' => [],
				'name' => $name,
				'name_link' => null,
				'area_name' => 'COM_COMPONENTBUILDER_' . StringHelper::safe($tableName, 'U')
			];

			// add the name to the search array
			if ($name !== 'id')
			{
				$result[$tableName]['search'][] = $name;
			}

			// special treatment for the field class (TODO: will be removed once the field class is refactored)
			if ($tableName === 'field')
			{
				$result[$tableName]['search'][] = 'xml';
			}

			// is this a keeper
			$remove = true;

			// Loop over each field in the current table.
			foreach ($fields as $fieldName => $fieldProperties)
			{
				// we load the list view name once per/table
				if ($result[$tableName]['views'] === null && isset($fieldProperties['list']))
				{
					$result[$tableName]['views'] = $fieldProperties['list'];
				}

				// add the linker if needed
				if ($name === $fieldName && !empty($fieldProperties['link']) && empty($result[$tableName]['name_link']))
				{
					$result[$tableName]['name_link'] = $fieldProperties['link'];
				}

				// Check if the field type is one of the target types.
				if ($area === 'customcode')
				{
					if (isset($fieldProperties['type']) && isset($fieldProperties['db']['type']) &&
						in_array($fieldProperties['type'], ['text', 'textarea', 'editor'], true) &&
						in_array($fieldProperties['db']['type'], ['MEDIUMTEXT', 'TEXT'], true) &&
						$name !== $fieldName)
					{
						$result[$tableName]['search'][] = $fieldName;
						$remove = false;
					}
				}
				elseif ($area === 'placeholders')
				{
					if (isset($fieldProperties['type']) &&
						in_array($fieldProperties['type'], ['text', 'textarea', 'editor'], true) &&
						$name !== $fieldName)
					{
						$result[$tableName]['search'][] = $fieldName;
						$remove = false;
					}
				}

				// check if this field is not stored as base64
				if (in_array($fieldName, $result[$tableName]['search'], true))
				{
					$result[$tableName]['decode'][$fieldName] = $fieldProperties['store'] ?? 'string';
				}
			}

			// remove the table entry if no search fields exist.
			if ($remove)
			{
				unset($result[$tableName]);
			}
		}

		return $result;
	}
}

