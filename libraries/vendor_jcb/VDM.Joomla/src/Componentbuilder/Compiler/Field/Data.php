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


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface as History;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Field\Customcode as FieldCustomcode;
use VDM\Joomla\Componentbuilder\Compiler\Field\Rule;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GuidHelper;


/**
 * Compiler Field Data
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * Compiler Fields
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $fields = [];

	/**
	 * tracking GUID index
	 *
	 * @var    array
	 * @since  5.0.4
	 */
	protected array $index = [];

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The HistoryInterface Class.
	 *
	 * @var   History
	 * @since 3.2.0
	 */
	protected History $history;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Customcode Class.
	 *
	 * @var   FieldCustomcode
	 * @since 3.2.0
	 */
	protected FieldCustomcode $fieldcustomcode;

	/**
	 * The Rule Class.
	 *
	 * @var   Rule
	 * @since 3.2.0
	 */
	protected Rule $rule;

	/**
	 * The database class.
	 *
	 * @since 3.2.0
	 */
	protected $db;

	/**
	 * Constructor.
	 *
	 * @param Config                 $config            The Config Class.
	 * @param Event                  $event             The EventInterface Class.
	 * @param History                $history           The HistoryInterface Class.
	 * @param Placeholder            $placeholder       The Placeholder Class.
	 * @param Customcode             $customcode        The Customcode Class.
	 * @param FieldCustomcode        $fieldcustomcode   The Customcode Class.
	 * @param Rule                   $rule              The Rule Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Event $event, History $history,
		Placeholder $placeholder, Customcode $customcode,
		FieldCustomcode $fieldcustomcode, Rule $rule)
	{
		$this->config = $config;
		$this->event = $event;
		$this->history = $history;
		$this->placeholder = $placeholder;
		$this->customcode = $customcode;
		$this->fieldcustomcode = $fieldcustomcode;
		$this->rule = $rule;
		$this->db = Factory::getDbo();
	}

	/**
	 * Get all Field Data
	 *
	 * @param   mixed        $field           The field ID/GUID
	 * @param   string|null  $singleViewName  The view edit or single name
	 * @param   string|null  $listViewName    The view list name
	 *
	 * @return  object|null The field data
	 * @since 3.2.0
	 */
	public function get($field, ?string $singleViewName = null, ?string $listViewName = null): ?object
	{
		if (isset($this->index[$field]))
		{
			$id = $this->index[$field];

			return $this->getFieldData($id, $singleViewName, $listViewName);
		}

		$this->set($field);

		if (isset($this->index[$field]))
		{
			$id = $this->index[$field];

			return $this->getFieldData($id, $singleViewName, $listViewName);
		}

		return null;
	}

	/**
	 * Set Field Data
	 *
	 * @param   int          $id              The field ID
	 * @param   string|null  $singleViewName  The view edit or single name
	 * @param   string|null  $listViewName    The view list name
	 *
	 * @return  object|null The field data
	 * @since 3.2.0
	 */
	private function getFieldData(int $id, ?string $singleViewName = null, ?string $listViewName = null): ?object
	{
		if ($id > 0 && isset($this->fields[$id]))
		{
			// update the customcode of the field
			$this->fieldcustomcode->update($id, $this->fields[$id], $singleViewName, $listViewName);

			// return the field
			return $this->fields[$id];
		}

		return null;
	}

	/**
	 * Set the field
	 *
	 * @param   mixed  $field  The field ID/GUID
	 *
	 * @return  void
	 * @since   5.0.4
	 */
	private function set($field): void
	{
		if (GuidHelper::valid($field))
		{
			$query = $this->getQuery($field, 'guid');
		}
		else
		{
			$query = $this->getQuery($field);
		}

		$data = $this->getData($query);

		if ($data !== null)
		{
			$this->fields[$data->id] = $data;
			$this->index[$data->id] = $data->id;
			$this->index[$data->guid] = $data->id;
		}
	}

	/**
	 * get current field data query
	 *
	 * @param   mixed    $value   The field ID/GUID
	 * @param   string   $key     The type of value
	 *
	 * @return  string  The field data query
	 * @since   5.0.4
	 */
	private function getQuery($value, string $key = 'id')
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		// Select all the values in the field
		$query->select('a.*');
		$query->select(
			$this->db->quoteName(
				array('c.name', 'c.properties'),
				array('type_name', 'properties')
			)
		);

		$query->from('#__componentbuilder_field AS a');
		$query->join(
			'LEFT',
			$this->db->quoteName('#__componentbuilder_fieldtype', 'c')
			. ' ON (' . $this->db->quoteName('a.fieldtype') . ' = '
			. $this->db->quoteName('c.guid') . ')'
		);

		$query->where(
			$this->db->quoteName('a.' . $key) . ' = ' . $this->db->quote($value)
		);

		// Trigger Event: jcb_ce_onBeforeQueryFieldData
		$this->event->trigger(
			'jcb_ce_onBeforeQueryFieldData', [&$value, &$query, &$this->db]
		);

		return $query;
	}

	/**
	 * get field data
	 *
	 * @param   string   $query   The field query
	 *
	 * @return  object|null  The field data
	 * @since   5.0.4
	 */
	private function getData($query): ?object
	{
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$this->db->execute();

		if ($this->db->getNumRows())
		{
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$field = $this->db->loadObject();
			$id = $field->id;

			// Trigger Event: jcb_ce_onBeforeModelFieldData
			$this->event->trigger(
				'jcb_ce_onBeforeModelFieldData', [&$field]
			);

			// adding a fix for the changed name of type to fieldtype
			$field->type = $field->fieldtype;

			// load the values form params
			$field->xml = $this->customcode->update(json_decode((string) $field->xml));

			// check if we have validate (validation rule and set it if found)
			$this->rule->set($id, $field->xml);

			// load the type values form type params
			$field->properties = (isset($field->properties) && JsonHelper::check($field->properties))
				? json_decode((string) $field->properties, true)
				: null;

			if (ArrayHelper::check($field->properties))
			{
				$field->properties = array_values($field->properties);
			}

			// check if we have WHMCS encryption
			if (4 == $field->store
				&& !$this->config->whmcs_encryption)
			{
				$this->config->whmcs_encryption = true;
			}
			// check if we have basic encryption
			elseif (3 == $field->store
				&& !$this->config->basic_encryption)
			{
				$this->config->basic_encryption = true;
			}
			// check if we have better encryption
			elseif (5 == $field->store
				&& $this->config->medium_encryption)
			{
				$this->config->medium_encryption = true;
			}
			// check if we have better encryption
			elseif (6 == $field->store
				&& StringHelper::check(
					$field->on_get_model_field
				)
				&& StringHelper::check(
					$field->on_save_model_field
				))
			{
				// add only if string lenght found
				if (StringHelper::check(
					$field->initiator_on_save_model
				))
				{
					$field->initiator_save_key = md5(
						(string) $field->initiator_on_save_model
					);
					$field->initiator_save     = explode(
						PHP_EOL, $this->placeholder->update_(
							$this->customcode->update(
								base64_decode(
									(string) $field->initiator_on_save_model
								)
							)
						)
					);
				}
				if (StringHelper::check(
					$field->initiator_on_save_model
				))
				{
					$field->initiator_get_key = md5(
						(string) $field->initiator_on_get_model
					);
					$field->initiator_get     = explode(
						PHP_EOL, $this->placeholder->update_(
							$this->customcode->update(
								base64_decode(
									(string) $field->initiator_on_get_model
								)
							)
						)
					);
				}
				// set the field modelling
				$field->model_field['save'] = explode(
					PHP_EOL, $this->placeholder->update_(
						$this->customcode->update(
							base64_decode((string) $field->on_save_model_field)
						)
					)
				);
				$field->model_field['get']  = explode(
					PHP_EOL, $this->placeholder->update_(
						$this->customcode->update(
							base64_decode((string) $field->on_get_model_field)
						)
					)
				);
				// remove the original values
				unset(
					$field->on_save_model_field,
					$field->on_get_model_field,
					$field->initiator_on_save_model,
					$field->initiator_on_get_model
					);
			}

			// get the last used version
			$field->history = $this->history->get('field', $id);

			// Trigger Event: jcb_ce_onAfterModelFieldData
			$this->event->trigger(
				'jcb_ce_onAfterModelFieldData', [&$field]
			);

			return $field;
		}

		return null;
	}
}

