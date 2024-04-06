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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplication;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Field;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name as FieldName;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups as FieldGroups;
use VDM\Joomla\Componentbuilder\Compiler\Model\Updatesql;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;


/**
 * Model Fields Class
 * 
 * @since 3.2.0
 */
class Fields
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler History
	 *
	 * @var    HistoryInterface
	 * @since 3.2.0
	 */
	protected HistoryInterface $history;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Field
	 *
	 * @var    Field
	 * @since 3.2.0
	 */
	protected Field $field;

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
	 * Compiler Update Sql
	 *
	 * @var    UpdateSql
	 * @since 3.2.0
	 */
	protected UpdateSql $updateSql;

	/**
	 * Application object.
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param Registry|null             $registry         The compiler registry object.
	 * @param HistoryInterface|null     $history          The compiler history object.
	 * @param Customcode|null           $customcode       The compiler customcode object.
	 * @param Field|null                $field            The compiler field object.
	 * @param FieldName|null            $fieldName        The compiler field name object.
	 * @param FieldGroups|null          $fieldGroups      The compiler field groups object.
	 * @param UpdateSql|null            $updateSql        The compiler field name object.
	 * @param CMSApplication|null       $app              The app object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?HistoryInterface $history = null, ?Customcode $customcode = null,
		?Field $field = null, ?FieldName $fieldName = null, ?FieldGroups $fieldGroups = null,
		?UpdateSql $updateSql = null, ?CMSApplication $app = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->history = $history ?: Compiler::_('History');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->field = $field ?: Compiler::_('Field');
		$this->fieldName = $fieldName ?: Compiler::_('Field.Name');
		$this->fieldGroups = $fieldGroups ?: Compiler::_('Field.Groups');
		$this->updateSql = $updateSql ?: Compiler::_('Model.Updatesql');
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Set fields
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->fields = [];

		$item->addfields = (isset($item->addfields)
			&& JsonHelper::check($item->addfields))
			? json_decode((string) $item->addfields, true) : null;

		if (ArrayHelper::check($item->addfields))
		{
			$ignore_fields = [];
			$default_fields = $this->config->default_fields;

			// load the field data
			$item->fields = array_map(
				function ($field) use (
					&$item, &$ignore_fields, &$default_fields
				) {
					// set the field details
					$this->field->set(
						$field, $item->name_single_code,
						$item->name_list_code
					);

					// check if this field is a default field OR
					// check if this is none database related field
					if (in_array($field['base_name'], $default_fields)
						|| $this->fieldGroups->check($field['type_name'], 'spacer')
						|| (isset($field['list']) && $field['list'] == 2)) // 2 = none database
					{
						$ignore_fields[$field['field']] = $field['field'];
					}

					// return field
					return $field;

				}, array_values($item->addfields)
			);

			// build update SQL
			if ($old_view = $this->history->get(
				'admin_fields', $item->addfields_id
			))
			{
				// add new fields were added
				if (isset($old_view->addfields)
					&& JsonHelper::check(
						$old_view->addfields
					))
				{
					$this->updateSql->set(
						json_decode((string) $old_view->addfields, true),
						$item->addfields, 'field', $item->name_single_code,
						$ignore_fields
					);
				}
				// clear this data
				unset($old_view);
			}

			// sort the fields according to order
			usort(
				$item->fields, function ($a, $b) {
					if (isset($a['order_list']) && isset($b['order_list']))
					{
						if ($a['order_list'] != 0 && $b['order_list'] != 0)
						{
							return $a['order_list'] <=> $b['order_list'];
						}
						elseif ($b['order_list'] != 0 && $a['order_list'] == 0)
						{
							return 1;
						}
						elseif ($a['order_list'] != 0 && $b['order_list'] == 0)
						{
							return -1;
						}

						return 1;
					}

					return 0;
				}
			);

			// do some house cleaning (for fields)
			foreach ($item->fields as $field)
			{
				// so first we lock the field name in
				$field_name = $this->fieldName->get(
					$field, $item->name_list_code
				);
				
				// check if the field changed since the last compilation
				// (default fields never change and are always added)
				if (!isset($ignore_fields[$field['field']])
					&& ObjectHelper::check(
						$field['settings']->history
					))
				{
					// check if the datatype changed
					if (isset($field['settings']->history->datatype))
					{
						$this->updateSql->set(
							$field['settings']->history->datatype,
							$field['settings']->datatype, 'field.datatype',
							$item->name_single_code . '.' . $field_name
						);
					}

					// check if the datatype lenght changed
					if (isset($field['settings']->history->datalenght)
						&& isset($field['settings']->history->datalenght_other))
					{
						$this->updateSql->set(
							$field['settings']->history->datalenght
							. $field['settings']->history->datalenght_other,
							$field['settings']->datalenght
							. $field['settings']->datalenght_other,
							'field.lenght',
							$item->name_single_code . '.' . $field_name
						);
					}

					// check if the name changed
					if (isset($field['settings']->history->xml)
						&& JsonHelper::check(
							$field['settings']->history->xml
						))
					{
						// only run if this is not an alias or a tag
						if ((!isset($field['alias']) || !$field['alias'])
							&& 'tag' !== $field['settings']->type_name)
						{
							// build temp field bucket
							$tmpfield             = [];
							$tmpfield['settings'] = new \stdClass();

							// convert the xml json string to normal string
							$tmpfield['settings']->xml
								= $this->customcode->update(
								json_decode(
									(string) $field['settings']->history->xml
								)
							);

							// add properties from current field as it is generic
							$tmpfield['settings']->properties
								= $field['settings']->properties;
							// add the old name
							$tmpfield['settings']->name
								= $field['settings']->history->name;
							// add the field type from current field since it is generic
							$tmpfield['settings']->type_name
								= $field['settings']->type_name;
							// get the old name
							$old_field_name = $this->fieldName->get(
								$tmpfield
							);

							// only run this if not a multi field
							if ($this->registry->get('unique.names.' . $item->name_list_code . '.names.' . $field_name) === null)
							{
								// this only works when the field is
								// not multiple of the same field
								$this->updateSql->set(
									$old_field_name, $field_name,
									'field.name',
									$item->name_single_code . '.'
									. $field_name
								);
							}
							elseif ($old_field_name !== $field_name)
							{
								// give a notice atleast that the multi fields
								// could have changed and no DB update was done
								$this->app->enqueueMessage(
									Text::_('COM_COMPONENTBUILDER_HR_HTHREEFIELD_NOTICEHTHREE'),
									'Notice'
								);
								$this->app->enqueueMessage(
									Text::sprintf(
										'You have a field called <b>%s</b> that has been added multiple times to the <b>%s</b> view, the name of that field has changed to <b>%s</b>. Normaly we would automaticly add the update SQL to your component, but with multiple fields this does not work automaticly since it could be that noting changed and it just seems like it did. Therefore you will have to do this manualy if it actualy did change!',
										$field_name,
										$item->name_single_code,
										$old_field_name
									), 'Notice'
								);
							}

							// remove tmp
							unset($tmpfield);
						}
					}
				}
			}
		}

		unset($item->addfields);
	}

}

