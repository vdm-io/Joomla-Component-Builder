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


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\String\TypeHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Field\UniqueName;
use VDM\Joomla\Componentbuilder\Compiler\Registry;


/**
 * Compiler Field Name
 * 
 * @since 3.2.0
 */
class Name
{
	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;
	
	/**
	 * Unique Field Names
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $unique;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * Compiler Field Unique Name
	 *
	 * @var    UniqueName
	 * @since 3.2.0
	 */
	protected UniqueName $uniqueName;

	/**
	 * Constructor
	 *
	 * @param Placeholder|null    $placeholder  The compiler component placeholder object.
	 * @param UniqueName|null     $uniqueName   The compiler field unique name object.
	 * @param Registry|null          $registry   The compiler registry object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Placeholder $placeholder = null, ?UniqueName $uniqueName = null, ?Registry $registry = null)
	{
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->uniqueName = $uniqueName ?: Compiler::_('Field.Unique.Name');
		$this->registry = $registry ?: Compiler::_('Registry');
	}

	/**
	 * Get the field's actual name
	 *
	 * @param   array        $field         The field array
	 * @param   string|null  $listViewName  The list view name
	 * @param   string       $amicably      The peaceful resolve (for fields in subforms in same view :)
	 *
	 * @return  string   Success returns field name
	 * @since 3.2.0
	 */
	public function get(array &$field, ?string $listViewName = null, string $amicably = ''): string
	{
		// return the unique name if already set
		if ($listViewName && StringHelper::check($listViewName)
			&& isset($field['hash'])
			&& isset(
				$this->unique[$listViewName . $amicably . $field['hash']]
			))
		{
			return $this->unique[$listViewName . $amicably . $field['hash']];
		}

		// always make sure we have a field name and type
		if (!isset($field['settings']) || !isset($field['settings']->type_name)
			|| !isset($field['settings']->name))
		{
			return 'error';
		}

		// set the type name
		$type_name = TypeHelper::safe(
			$field['settings']->type_name
		);

		// set the name of the field
		$name = FieldHelper::safe($field['settings']->name);

		// check that we have the properties
		if (ArrayHelper::check($field['settings']->properties))
		{
			foreach ($field['settings']->properties as $property)
			{
				if ($property['name'] === 'name')
				{
					// if category then name must be catid (only one per view)
					if ($type_name === 'category')
					{
						// quick check if this is a category linked to view page
						$requeSt_id = GetHelper::between(
							$field['settings']->xml, 'name="', '"'
						);
						if (strpos($requeSt_id, '_request_id') !== false
							|| strpos($requeSt_id, '_request_catid') !== false)
						{
							// keep it then, don't change
							$name = $this->placeholder->update_(
								$requeSt_id
							);
						}
						else
						{
							$name = 'catid';
						}

						// if list view name is set
						if (StringHelper::check($listViewName))
						{
							// check if we should use another Text Name as this views name
							$otherName  = $this->placeholder->update_(
								GetHelper::between(
									$field['settings']->xml, 'othername="', '"'
								)
							);
							$otherViews = $this->placeholder->update_(
								GetHelper::between(
									$field['settings']->xml, 'views="', '"'
								)
							);
							$otherView  = $this->placeholder->update_(
								GetHelper::between(
									$field['settings']->xml, 'view="', '"'
								)
							);
							// This is to link other view category
							if (StringHelper::check($otherName)
								&& StringHelper::check(
									$otherViews
								) && StringHelper::check(
									$otherView
								))
							{
								// set other category details
								$this->registry->set("category.other.name.${listViewName}", [
									'name'  => FieldHelper::safe(
										$otherName
									),
									'views' => StringHelper::safe(
										$otherViews
									),
									'view'  => StringHelper::safe(
										$otherView
									)
								]);
							}
						}
					}
					// if tag is set then enable all tag options for this view (only one per view)
					elseif ($type_name === 'tag')
					{
						$name = 'tags';
					}
					// if the field is set as alias it must be called alias
					elseif (isset($field['alias']) && $field['alias'])
					{
						$name = 'alias';
					}
					else
					{
						// get value from xml
						$xml = FieldHelper::safe(
							$this->placeholder->update_(
								GetHelper::between(
									$field['settings']->xml, 'name="', '"'
								)
							)
						);
						// check if a value was found
						if (StringHelper::check($xml))
						{
							$name = $xml;
						}
					}
					// exit foreach loop
					break;
				}
			}
		}

		// return the value unique
		if (StringHelper::check($listViewName) && isset($field['hash']))
		{
			$this->unique[$listViewName . $amicably . $field['hash']]
				= $this->uniqueName->get($name, $listViewName . $amicably);

			// now return the unique name
			return $this->unique[$listViewName . $amicably . $field['hash']];
		}

		// fall back to global
		return $name;
	}

}

