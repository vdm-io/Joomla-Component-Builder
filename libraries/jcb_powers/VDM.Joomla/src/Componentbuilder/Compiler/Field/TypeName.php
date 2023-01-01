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

namespace VDM\Joomla\Componentbuilder\Compiler\Field;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\String\TypeHelper;


/**
 * Compiler Field Type Name
 * 
 * @since 3.2.0
 */
class TypeName
{
	/**
	 * Get the field's actual type
	 *
	 * @param   object  $field  The field object
	 *
	 * @return  string   Success returns field type
	 * @since 3.2.0
	 */
	public function get(&$field)
	{
		// check if we have done this already
		if (isset($field['type_name']))
		{
			return $field['type_name'];
		}

		// check that we have the properties
		if (isset($field['settings'])
			&& ObjectHelper::check(
				$field['settings']
			)
			&& isset($field['settings']->properties)
			&& ArrayHelper::check(
				$field['settings']->properties
			))
		{
			// search for own custom fields
			if (strpos((string) $field['settings']->type_name, '@') !== false)
			{
				// set own custom field
				$field['settings']->own_custom = $field['settings']->type_name;
				$field['settings']->type_name  = 'Custom';
			}

			// set the type name
			$type_name = TypeHelper::safe(
				$field['settings']->type_name
			);

			// if custom (we must use the xml value)
			if (strtolower((string) $type_name) === 'custom'
				|| strtolower((string) $type_name) === 'customuser')
			{
				$type = TypeHelper::safe(
					GetHelper::between(
						$field['settings']->xml, 'type="', '"'
					)
				);
			}
			else
			{
				// loop over properties looking for the type value
				foreach ($field['settings']->properties as $property)
				{
					if ($property['name']
						=== 'type') // type field is never adjustable (unless custom)
					{
						// force the default value
						if (isset($property['example'])
							&& StringHelper::check(
								$property['example']
							))
						{
							$type = TypeHelper::safe(
								$property['example']
							);
						}
						// fall back on the xml settings (not ideal)
						else
						{
							$type = TypeHelper::safe(
								GetHelper::between(
									$field['settings']->xml, 'type="', '"'
								)
							);
						}
						// exit foreach loop
						break;
					}
				}
			}
			// check if the value is set
			if (isset($type) && StringHelper::check($type))
			{
				return $type;
			}
			// fallback on type name set in name field (not ideal)
			else
			{
				return $type_name;
			}
		}

		// fall back to text
		return 'text';
	}

}

