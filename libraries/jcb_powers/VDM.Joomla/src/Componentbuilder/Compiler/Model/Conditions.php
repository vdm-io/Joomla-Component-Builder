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


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Field\TypeName;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name as FieldName;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups as FieldGroups;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;


/**
 * Model Conditions Class
 * 
 * @since 3.2.0
 */
class Conditions
{
	/**
	 * Compiler Type Name
	 *
	 * @var    TypeName
	 * @since 3.2.0
	 */
	protected TypeName $typeName;

	/**
	 * Compiler Field Name
	 *
	 * @var    FieldName
	 * @since 3.2.0
	 */
	protected FieldName $fieldName;

	/**
	 * Compiler Field Groups
	 *
	 * @var    FieldGroups
	 * @since 3.2.0
	 */
	protected FieldGroups $fieldGroups;

	/**
	 * Constructor
	 *
	 * @param TypeName|null     $typeName      The compiler type name object.
	 * @param FieldName|null    $fieldName     The compiler field name object.
	 * @param FieldGroups|null  $fieldGroups   The compiler field groups object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?TypeName $typeName = null, ?FieldName $fieldName = null, ?FieldGroups $fieldGroups = null)
	{
		$this->typeName = $typeName ?: Compiler::_('Field.Type.Name');
		$this->fieldName = $fieldName ?: Compiler::_('Field.Name');
		$this->fieldGroups = $fieldGroups ?: Compiler::_('Field.Groups');
	}

	/**
	 * Set the conditions
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addconditions = (isset($item->addconditions)
			&& JsonHelper::check($item->addconditions))
			? json_decode((string) $item->addconditions, true) : null;

		if (ArrayHelper::check($item->addconditions))
		{
			$item->conditions = [];
			$ne               = 0;
			foreach ($item->addconditions as $nr => $conditionValue)
			{
				if (ArrayHelper::check(
						$conditionValue['target_field']
					) && ArrayHelper::check($item->fields))
				{
					foreach ( $conditionValue['target_field'] as $fieldKey => $fieldId)
					{
						foreach ($item->fields as $fieldValues)
						{
							if ((int) $fieldValues['field'] == (int) $fieldId)
							{
								// load the field details
								$required = GetHelper::between(
									$fieldValues['settings']->xml,
									'required="', '"'
								);

								$required = ($required === 'true'
									|| $required === '1') ? 'yes' : 'no';

								$filter = GetHelper::between(
									$fieldValues['settings']->xml,
									'filter="', '"'
								);

								$filter = StringHelper::check(
									$filter
								) ? $filter : 'none';

								// set the field name
								$conditionValue['target_field'][$fieldKey] = [
									'name' => $this->fieldName->get(
										$fieldValues, $item->name_list_code
									),
									'type' => $this->typeName->get(
										$fieldValues
									),
									'required' => $required,
									'filter'   => $filter
								];

								break;
							}
						}
					}
				}

				// load match field
				if (ArrayHelper::check($item->fields)
					&& isset($conditionValue['match_field']))
				{
					foreach ($item->fields as $fieldValue)
					{
						if ((int) $fieldValue['field'] == (int) $conditionValue['match_field'])
						{
							// set the type
							$type = $this->typeName->get($fieldValue);
							// set the field details
							$conditionValue['match_name'] = $this->fieldName->get(
								$fieldValue, $item->name_list_code
							);
							$conditionValue['match_type'] = $type;
							$conditionValue['match_xml'] = $fieldValue['settings']->xml;

							// if custom field load field being extended
							if (!$this->fieldGroups->check($type))
							{
								$conditionValue['match_extends'] = GetHelper::between(
									$fieldValue['settings']->xml,
									'extends="', '"'
								);
							}
							else
							{
								$conditionValue['match_extends'] = '';
							}
							break;
						}
					}
				}

				// set condition values
				$item->conditions[$ne] = $conditionValue;

				$ne++;
			}
		}

		unset($item->addconditions);
	}
}

