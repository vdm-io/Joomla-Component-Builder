<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Field\Groups as FieldGroups;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionFields;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\GetFormInterface;


/**
 * Model Get Form Class.
 * 
 * Builds the getForm method of an admin edit view model, including the per
 * field permission guards that unset a field the current user may not edit,
 * access or view.
 * 
 * Only how the current user is put in scope differs between Joomla targets,
 * so that is the extension point the target variants override.
 * 
 * @since  6.1.7
 */
class GetForm implements GetFormInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The Field Groups Class.
	 *
	 * @var   FieldGroups
	 * @since 6.1.7
	 */
	protected FieldGroups $fieldgroups;

	/**
	 * The Permission Fields Class.
	 *
	 * @var   PermissionFields
	 * @since 6.1.7
	 */
	protected PermissionFields $permissionfields;

	/**
	 * Constructor.
	 *
	 * @param Config            $config             The Config Class.
	 * @param Permission        $permission         The Permission Class.
	 * @param Dispenser         $dispenser          The Dispenser Class.
	 * @param FieldGroups       $fieldgroups        The Field Groups Class.
	 * @param PermissionFields  $permissionfields   The Permission Fields Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Permission $permission,
		Dispenser $dispenser,
		FieldGroups $fieldgroups,
		PermissionFields $permissionfields)
	{
		$this->config = $config;
		$this->permission = $permission;
		$this->dispenser = $dispenser;
		$this->fieldgroups = $fieldgroups;
		$this->permissionfields = $permissionfields;
	}

	/**
	 * Build the getForm method of an admin edit view model.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 * @since   6.2.0 Preserve denied and omitted PATCH metadata in API forms.
	 */
	public function get($nameSingleCode, $nameListCode)
	{
		// set component name
		$component = $this->config->component_code_name;
		// allways load these
		$getForm   = [];
		$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if xpath was set in options";
		$getForm[] = Indent::_(2) . "\$xpath = false;";
		$getForm[] = Indent::_(2) . "if (isset(\$options['xpath']))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "\$xpath = \$options['xpath'];";
		$getForm[] = Indent::_(3) . "unset(\$options['xpath']);";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if clear form was set in options";
		$getForm[] = Indent::_(2) . "\$clear = false;";
		$getForm[] = Indent::_(2) . "if (isset(\$options['clear']))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "\$clear = \$options['clear'];";
		$getForm[] = Indent::_(3) . "unset(\$options['clear']);";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the form.";
		$getForm[] = Indent::_(2) . "\$form = \$this->loadForm('com_"
			. $component . "." . $nameSingleCode . "', '" . $nameSingleCode
			. "', \$options, \$clear, \$xpath);";
		$getForm[] = PHP_EOL . Indent::_(2) . "if (empty(\$form))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "return false;";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = PHP_EOL . Indent::_(2)
			. "\$app = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();";
		$getForm[] = PHP_EOL . Indent::_(2)
			. "\$jinput = method_exists(\$app, 'getInput') ? \$app->getInput() : \$app->input;";
		$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			)
			. " The record being saved decides the permissions, so its id wins over the request.";
		$getForm[] = Indent::_(2)
			. "if (is_array(\$data) && isset(\$data['id']) && (int) \$data['id'] > 0)";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "\$id = (int) \$data['id'];";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			)
			. " The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
		$getForm[] = Indent::_(2) . "elseif (\$jinput->get('a_id'))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3)
			. "\$id = \$jinput->get('a_id', 0, 'INT');";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " The back end uses id so we use that the rest of the time and set it to 0 by default.";
		$getForm[] = Indent::_(2) . "else";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "\$id = \$jinput->get('id', 0, 'INT');";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = $this->getUserObject();
		$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Check for existing item.";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Modify the form based on Edit State access controls.";
		// check if the item has permissions.
		$getForm[] = Indent::_(2)
			. "if (\$id != 0 && (!\$user->authorise('"
			. $this->permission->getAction($nameSingleCode, 'core.edit.state') . "', 'com_" . $component . "."
			. $nameSingleCode . ".' . (int) \$id))";
		$getForm[] = Indent::_(3)
			. "|| (\$id == 0 && !\$user->authorise('"
			. $this->permission->getAction($nameSingleCode, 'core.edit.state') . "', 'com_" . $component
			. "')))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Disable fields for display.";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('ordering', 'disabled', 'true');";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('published', 'disabled', 'true');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Disable fields while saving.";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('ordering', 'filter', 'unset');";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('published', 'filter', 'unset');";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " If this is a new item insure the greated by is set.";
		$getForm[] = Indent::_(2) . "if (0 == \$id)";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set the created_by to this user";
		$getForm[] = Indent::_(3)
			. "\$form->setValue('created_by', null, \$user->id);";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Modify the form based on Edit Creaded By access controls.";
		// check if the item has permissions.
		if ($this->permission->actionExist($nameSingleCode, 'core.edit.created_by'))
		{
			$getForm[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit.created_by')
				. "', 'com_" . $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit.created_by')
				. "', 'com_" . $component . "')))";
		}
		else
		{
			$getForm[] = Indent::_(2)
				. "if (!\$user->authorise('core.edit.created_by', 'com_" . $component . "'))";
		}
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "if (\$app->isClient('api'))";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4) . "//" . Line::_(__LINE__, __CLASS__)
			. " Exclude protected metadata from API validation and binding.";
		$getForm[] = Indent::_(4) . "\$form->removeField('created_by');";
		$getForm[] = Indent::_(3) . "}";
		$getForm[] = Indent::_(3) . "else";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4) . "//" . Line::_(__LINE__, __CLASS__)
			. " Retain disabled metadata controls in administrator forms.";
		$getForm[] = Indent::_(4)
			. "\$form->setFieldAttribute('created_by', 'disabled', 'true');";
		$getForm[] = Indent::_(4)
			. "\$form->setFieldAttribute('created_by', 'readonly', 'true');";
		$getForm[] = Indent::_(4)
			. "\$form->setFieldAttribute('created_by', 'filter', 'unset');";
		$getForm[] = Indent::_(3) . "}";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Modify the form based on Edit Creaded Date access controls.";
		// check if the item has permissions.
		if ($this->permission->actionExist($nameSingleCode, 'core.edit.created'))
		{
			$getForm[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit.created')
				. "', 'com_" . $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit.created')
				. "', 'com_" . $component . "')))";
		}
		else
		{
			$getForm[] = Indent::_(2)
				. "if (!\$user->authorise('core.edit.created', 'com_"
				. $component . "'))";
		}
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "if (\$app->isClient('api'))";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4) . "//" . Line::_(__LINE__, __CLASS__)
			. " Exclude protected metadata from API validation and binding.";
		$getForm[] = Indent::_(4) . "\$form->removeField('created');";
		$getForm[] = Indent::_(3) . "}";
		$getForm[] = Indent::_(3) . "else";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4) . "//" . Line::_(__LINE__, __CLASS__)
			. " Retain disabled metadata controls in administrator forms.";
		$getForm[] = Indent::_(4)
			. "\$form->setFieldAttribute('created', 'disabled', 'true');";
		$getForm[] = Indent::_(4)
			. "\$form->setFieldAttribute('created', 'filter', 'unset');";
		$getForm[] = Indent::_(3) . "}";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " Omitted PATCH metadata must not be filtered or rebound from storage.";
		$getForm[] = Indent::_(2) . "if (\$app->isClient('api') && \$jinput->getMethod() === 'PATCH')";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3)
			. "\$submittedApiData = \$jinput->get('data', json_decode(\$jinput->json->getRaw(), true), 'array');";
		$getForm[] = Indent::_(3) . "foreach (['created', 'created_by'] as \$metadataField)";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4)
			. "if (!is_array(\$submittedApiData) || !array_key_exists(\$metadataField, \$submittedApiData))";
		$getForm[] = Indent::_(4) . "{";
		$getForm[] = Indent::_(5) . "\$form->removeField(\$metadataField);";
		$getForm[] = Indent::_(4) . "}";
		$getForm[] = Indent::_(3) . "}";
		$getForm[] = Indent::_(2) . "}";
		// check if the item has access permissions.
		if ($this->permission->actionExist($nameSingleCode, 'core.edit.access'))
		{
			$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on Edit Access 'access' controls.";
			$getForm[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit.access')
				. "', 'com_" . $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.edit.access')
				. "', 'com_" . $component . "')))";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields for display.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('access', 'disabled', 'true');";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('access', 'filter', 'unset');";
			$getForm[] = Indent::_(2) . "}";
		}
		// handel the fields permissions
		if ($this->permissionfields->isArray($nameSingleCode))
		{
			foreach ($this->permissionfields->get($nameSingleCode)
				as $fieldName => $permission_options)
			{
				foreach ($permission_options as $permission_option => $fieldType)
				{
					switch ($permission_option)
					{
						case 'edit':
							$this->setPermissionEditFields(
								$getForm, $nameSingleCode, $fieldName,
								$fieldType, $component
							);
							break;
						case 'access':
							$this->setPermissionAccessFields(
								$getForm, $nameSingleCode, $fieldName,
								$fieldType, $component
							);
							break;
						case 'view':
							$this->setPermissionViewFields(
								$getForm, $nameSingleCode, $fieldName,
								$fieldType, $component
							);
							break;
						case 'edit.own':
						case 'access.own':
							// this must still be build (TODO)
							break;
					}
				}
			}
		}
		// add the redirect trick to set the field of origin
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Only load these values if no id is found";
		$getForm[] = Indent::_(2) . "if (0 == \$id)";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set redirected view name";
		$getForm[] = Indent::_(3)
			. "\$redirectedView = \$jinput->get('ref', null, 'STRING');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set field name (or fall back to view name)";
		$getForm[] = Indent::_(3)
			. "\$redirectedField = \$jinput->get('field', \$redirectedView, 'STRING');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set redirected view id";
		$getForm[] = Indent::_(3)
			. "\$redirectedId = \$jinput->get('refid', 0, 'INT');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set field id (or fall back to redirected view id)";
		$getForm[] = Indent::_(3)
			. "\$redirectedValue = \$jinput->get('field_id', \$redirectedId, 'INT');";
		$getForm[] = Indent::_(3)
			. "if (0 != \$redirectedValue && \$redirectedField)";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
			. " Now set the local-redirected field default value";
		$getForm[] = Indent::_(4)
			. "\$form->setValue(\$redirectedField, null, \$redirectedValue);";
		$getForm[] = Indent::_(3) . "}";

		// new options v5.0.4 (init_defaults) to pass an array of form field defaults
		$getForm[] = Indent::_(3)
			. "\$initDefaults = \$jinput->get('init_defaults', null, 'STRING');";
			// check init defaults value
		$getForm[] = Indent::_(3)
			. "if (!empty(\$initDefaults))";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
			. " Now check if this json values are valid";
		$getForm[] = Indent::_(4) . "\$initDefaults = json_decode(urldecode(\$initDefaults), true);";
		$getForm[] = Indent::_(4) . "if (is_array(\$initDefaults))";
		$getForm[] = Indent::_(4) . "{";
		$getForm[] = Indent::_(5) . "foreach (\$initDefaults as \$field => \$value)";
		$getForm[] = Indent::_(5) . "{";
		$getForm[] = Indent::_(6) . "\$form->setValue(\$field, null, \$value);";
		$getForm[] = Indent::_(5) . "}";
		$getForm[] = Indent::_(4) . "}";
		$getForm[] = Indent::_(3) . "}";

		// load custom script if found
		$getForm[] = Indent::_(2) . "}" . $this->dispenser->get(
				'php_getform', $nameSingleCode, PHP_EOL
			);
		// Keep the actual form so native validation plugins remain authoritative.
		$getForm[] = Indent::_(2) . "if (\$app->isClient('api') && \$jinput->getMethod() === 'PATCH')";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "\$this->setState('jcb.api.patch.form', \$form);";
		$getForm[] = Indent::_(2) . "}";
		// setup the default script
		$getForm[] = Indent::_(2) . "return \$form;";

		return implode(PHP_EOL, $getForm);
	}

	/**
	 * Add the edit permission guard of one field.
	 *
	 * @param   array   $allow            The guard lines being built.
	 * @param   string  $nameSingleCode   The single view code name.
	 * @param   string  $fieldName        The field code name.
	 * @param   string  $fieldType        The field type.
	 * @param   string  $component        The component code name.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function setPermissionEditFields(&$allow, $nameSingleCode, $fieldName, $fieldType, $component)
	{
		// only for fields that can be edited
		if (!$this->fieldgroups->check($fieldType, 'spacer'))
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on Edit "
				. StringHelper::safe($fieldName, 'W')
				. " access controls.";
			$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $nameSingleCode . ".edit." . $fieldName . "', 'com_"
				. $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $nameSingleCode . ".edit." . $fieldName . "', 'com_"
				. $component . "')))";
			$allow[] = Indent::_(2) . "{";

			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable field on display.";
			$allow[] = Indent::_(3) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'disabled', 'true');";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Make field readonly on display.";
			$allow[] = Indent::_(3) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'readonly', 'true');";

			if ('radio' === $fieldType || 'repeatable' === $fieldType || 'subform' === $fieldType)
			{
				$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Disable the buttons form being clickable.";
				$allow[] = Indent::_(3)
					. "\$class = \$form->getFieldAttribute('" . $fieldName
					. "', 'class', '');";
				$allow[] = Indent::_(3) . "\$form->setFieldAttribute('"
					. $fieldName . "', 'class', \$class . ' disabled no-click');";
			}

			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " If there is no value continue.";
			$allow[] = Indent::_(3) . "if (!\$form->getValue('" . $fieldName . "'))";
			$allow[] = Indent::_(3) . "{";

			if ('repeatable' === $fieldType || 'subform' === $fieldType)
			{
				$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " Remove the field";
				$allow[] = Indent::_(4) . "\$form->removeField('" . $fieldName . "');";
			}
			else
			{
				$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " Disable field while saving.";
				$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
					. "', 'filter', 'unset');";
				$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " Disable field while saving.";
				$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
					. "', 'required', 'false');";
			}

			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(2) . "}";
		}
	}

	/**
	 * Add the access permission guard of one field.
	 *
	 * @param   array   $allow            The guard lines being built.
	 * @param   string  $nameSingleCode   The single view code name.
	 * @param   string  $fieldName        The field code name.
	 * @param   string  $fieldType        The field type.
	 * @param   string  $component        The component code name.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function setPermissionAccessFields(&$allow, $nameSingleCode,
		$fieldName, $fieldType, $component
	)
	{
		$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Modify the from the form based on "
			. StringHelper::safe($fieldName, 'W')
			. " access controls.";
		$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
			. $nameSingleCode . ".access." . $fieldName . "', 'com_"
			. $component . "." . $nameSingleCode . ".' . (int) \$id))";
		$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
			. $nameSingleCode . ".access." . $fieldName . "', 'com_"
			. $component . "')))";
		$allow[] = Indent::_(2) . "{";
		$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Remove the field";
		$allow[] = Indent::_(3) . "\$form->removeField('" . $fieldName . "');";
		$allow[] = Indent::_(2) . "}";
	}

	/**
	 * Add the view permission guard of one field.
	 *
	 * @param   array   $allow            The guard lines being built.
	 * @param   string  $nameSingleCode   The single view code name.
	 * @param   string  $fieldName        The field code name.
	 * @param   string  $fieldType        The field type.
	 * @param   string  $component        The component code name.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function setPermissionViewFields(&$allow, $nameSingleCode,
		$fieldName, $fieldType, $component
	)
	{
		if ($this->fieldgroups->check($fieldType, 'spacer'))
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on View "
				. StringHelper::safe($fieldName, 'W')
				. " access controls.";
			$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "')))";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Remove the field";
			$allow[] = Indent::_(3) . "\$form->removeField('" . $fieldName
				. "');";
			$allow[] = Indent::_(2) . "}";
		}
		else
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on View "
				. StringHelper::safe($fieldName, 'W')
				. " access controls.";
			$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "')))";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Make the field hidded.";
			$allow[] = Indent::_(3) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'type', 'hidden');";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " If there is no value continue.";
			$allow[] = Indent::_(3) . "if (!(\$val = \$form->getValue('"
				. $fieldName . "')))";
			$allow[] = Indent::_(3) . "{";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'filter', 'unset');";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'required', 'false');";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Make sure";
			$allow[] = Indent::_(4) . "\$form->setValue('" . $fieldName
				. "', null, '');";
			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(3) . "elseif ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$val))";
			$allow[] = Indent::_(3) . "{";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " We have to unset then (TODO)";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Hiddend field can not handel array value";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Even if we convert to json we get an error";
			$allow[] = Indent::_(4) . "\$form->removeField('" . $fieldName
				. "');";
			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(2) . "}";
		}
	}

	/**
	 * Get the statement that puts the current user in scope.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getUserObject(): string
	{
		return PHP_EOL . Indent::_(2)
			. "\$user = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->getIdentity();";
	}
}

