<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Field;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Field\Customcode as FieldCustomcode;
use VDM\Joomla\Componentbuilder\Compiler\Field\Validation;


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
	protected array $fields;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Compiler Event
	 *
	 * @var    EventInterface
	 * @since 3.2.0
	 */
	protected EventInterface $event;

	/**
	 * Compiler History
	 *
	 * @var    HistoryInterface
	 * @since 3.2.0
	 */
	protected HistoryInterface $history;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Field Customcode
	 *
	 * @var    FieldCustomcode
	 * @since 3.2.0
	 */
	protected FieldCustomcode $fieldCustomcode;

	/**
	 * Compiler Field Validation
	 *
	 * @var    Validation
	 * @since 3.2.0
	 */
	protected Validation $validation;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param EventInterface|null       $event            The compiler event api object.
	 * @param HistoryInterface|null     $history          The compiler history object.
	 * @param Placeholder|null          $placeholder      The compiler placeholder object.
	 * @param Customcode|null           $customcode       The compiler customcode object.
	 * @param FieldCustomcode|null      $fieldCustomcode  The field customcode object.
	 * @param Validation|null           $validation       The field validation rule object.
	 * @param \JDatabaseDriver|null     $db               The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?EventInterface $event = null, ?HistoryInterface $history = null,
		?Placeholder $placeholder = null, ?Customcode $customcode = null, ?FieldCustomcode $fieldCustomcode = null,
		?Validation $validation = null, ?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->event = $event ?: Compiler::_('Event');
		$this->history = $history ?: Compiler::_('History');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->fieldCustomcode = $fieldCustomcode ?: Compiler::_('Field.Customcode');
		$this->validation = $validation ?: Compiler::_('Field.Validation');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Get all Field Data
	 *
	 * @param   int          $id              The field ID
	 * @param   string|null  $singleViewName  The view edit or single name
	 * @param   string|null  $listViewName    The view list name
	 *
	 * @return  object|null The field data
	 * @since 3.2.0
	 */
	public function get(int $id, ?string $singleViewName = null, ?string $listViewName = null): ?object
	{
		if ($id > 0 && !isset($this->fields[$id]))
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
				. $this->db->quoteName('c.id') . ')'
			);
			$query->where(
				$this->db->quoteName('a.id') . ' = ' . $this->db->quote($id)
			);

			// TODO we need to update the event signatures
			$context = $this->config->component_context;

			// Trigger Event: jcb_ce_onBeforeQueryFieldData
			$this->event->trigger(
				'jcb_ce_onBeforeQueryFieldData',
				array(&$context, &$id, &$query, &$this->db)
			);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// Load the results as a list of stdClass objects (see later for more options on retrieving data).
				$field = $this->db->loadObject();

				// Trigger Event: jcb_ce_onBeforeModelFieldData
				$this->event->trigger(
					'jcb_ce_onBeforeModelFieldData',
					array(&$context, &$field)
				);

				// adding a fix for the changed name of type to fieldtype
				$field->type = $field->fieldtype;

				// load the values form params
				$field->xml = $this->customcode->update(json_decode($field->xml));

				// check if we have validate (validation rule and set it if found)
				$this->validation->set($id, $field->xml);

				// load the type values form type params
				$field->properties = (isset($field->properties)
					&& JsonHelper::check($field->properties))
					? json_decode($field->properties, true) : null;
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
							$field->initiator_on_save_model
						);
						$field->initiator_save     = explode(
							PHP_EOL, $this->placeholder->update(
							$this->customcode->update(
								base64_decode(
									$field->initiator_on_save_model
								)
							), $this->placeholder->active
						)
						);
					}
					if (StringHelper::check(
						$field->initiator_on_save_model
					))
					{
						$field->initiator_get_key = md5(
							$field->initiator_on_get_model
						);
						$field->initiator_get     = explode(
							PHP_EOL, $this->placeholder->update(
							$this->customcode->update(
								base64_decode(
									$field->initiator_on_get_model
								)
							), $this->placeholder->active
						)
						);
					}
					// set the field modeling
					$field->model_field['save'] = explode(
						PHP_EOL, $this->placeholder->update(
						$this->customcode->update(
							base64_decode($field->on_save_model_field)
						), $this->placeholder->active
					)
					);
					$field->model_field['get']  = explode(
						PHP_EOL, $this->placeholder->update(
						$this->customcode->update(
							base64_decode($field->on_get_model_field)
						), $this->placeholder->active
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
					'jcb_ce_onAfterModelFieldData',
					array(&$context, &$field)
				);

				$this->fields[$id] = $field;
			}
			else
			{
				return null;
			}
		}

		if ($id > 0 && isset($this->fields[$id]))
		{
			// update the customcode of the field
			$this->fieldCustomcode->update($id, $this->fields[$id], $singleViewName, $listViewName);

			// return the field
			return $this->fields[$id];
		}

		return null;
	}

}

