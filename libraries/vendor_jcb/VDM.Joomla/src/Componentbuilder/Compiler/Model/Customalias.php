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


use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomAlias as BuilderCustomAlias;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name as FieldName;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Custom Alias Class
 * 
 * @since 3.2.0
 */
class Customalias
{
	/**
	 * The BuilderCustomAlias Class.
	 *
	 * @var   BuilderCustomAlias
	 * @since 3.2.0
	 */
	protected BuilderCustomAlias $customalias;

	/**
	 * The Name Class.
	 *
	 * @var   FieldName
	 * @since 3.2.0
	 */
	protected FieldName $fieldname;

	/**
	 * Constructor.
	 *
	 * @param BuilderCustomAlias   $customalias   The CustomAlias Class.
	 * @param FieldName            $fieldname     The Name Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(BuilderCustomAlias $customalias, FieldName $fieldname)
	{
		$this->customalias = $customalias;
		$this->fieldname = $fieldname;
	}

	/**
	 * Set activate alias builder
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		if (!$this->customalias->get($item->name_single_code)
			&& isset($item->alias_builder_type) && 2 == $item->alias_builder_type
			&& isset($item->alias_builder) && JsonHelper::check($item->alias_builder))
		{
			// get the aliasFields
			$alias_fields = (array) json_decode((string) $item->alias_builder, true);

			// get the active fields
			$alias_fields = (array) array_filter(
				$item->fields, function ($field) use ($alias_fields) {
					// check if field is in view fields
					if (in_array($field['field'], $alias_fields))
					{
						return true;
					}

					return false;
				}
			);

			// check if all is well
			if (ArrayHelper::check($alias_fields))
			{
				// load the field names
				$this->customalias->set($item->name_single_code,
					(array) array_map(
						function ($field) use (&$item) {
							return $this->fieldname->get(
								$field, $item->name_list_code
							);
						}, $alias_fields
					)
				);
			}
		}

		// unset
		unset($item->alias_builder);
	}
}

