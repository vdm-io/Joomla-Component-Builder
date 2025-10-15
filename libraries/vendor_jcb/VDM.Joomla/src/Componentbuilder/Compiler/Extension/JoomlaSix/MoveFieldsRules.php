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

namespace VDM\Joomla\Componentbuilder\Compiler\Extension\JoomlaSix;


use Joomla\Filesystem\File;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Field;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionCustomFields;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\MoveFieldsRulesInterface;


/**
 * Move Fields & Rules Class
 * 
 * @since 5.1.2
 */
final class MoveFieldsRules implements MoveFieldsRulesInterface
{
	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 5.1.2
	 */
	protected Registry $registry;

	/**
	 * The Field Class.
	 *
	 * @var   Field
	 * @since 5.1.2
	 */
	protected Field $field;

	/**
	 * The ExtensionCustomFields Class.
	 *
	 * @var   ExtensionCustomFields
	 * @since 5.1.2
	 */
	protected ExtensionCustomFields $extensioncustomfields;

	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 5.1.2
	 */
	protected Paths $paths;

	/**
	 * Internal tracking of files already moved.
	 *
	 * @var   array
	 * @since 5.1.2
	 */
	protected array $extensionTrackingFilesMoved = [];

	/**
	 * Constructor.
	 *
	 * @param Registry                $registry                The Registry Class.
	 * @param Field                   $field                   The Field Class.
	 * @param ExtensionCustomFields   $extensioncustomfields   The ExtensionCustomFields Class.
	 * @param Paths                   $paths                   The Paths Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Registry $registry, Field $field,
		ExtensionCustomFields $extensioncustomfields,
		Paths $paths)
	{
		$this->registry = $registry;
		$this->field = $field;
		$this->extensioncustomfields = $extensioncustomfields;
		$this->paths = $paths;
	}

	/**
	 * Move the field and its associated rules.
	 *
	 * @param   array   $field  The field data.
	 * @param   string  $path   The target path to move to.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	public function move(array $field, string $path): void
	{
		$typeName = $field['type_name'] ?? '';

		if (in_array($typeName, ['subform', 'repeatable'], true))
		{
			$this->moveMultiFieldsRules($field, $path);
			return;
		}

		$this->moveCustomField($field, $path);
		$this->moveValidationRule($field, $path);
	}

	/**
	 * Move custom field files if required.
	 *
	 * @param   array   $field  The field data.
	 * @param   string  $path   The target path to move to.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	protected function moveCustomField(array $field, string $path): void
	{
		$typeName = $field['type_name'] ?? '';

		if (!$this->extensioncustomfields->exists($typeName))
		{
			return;
		}

		$check = md5($path . 'type' . $typeName);

		if (isset($this->extensionTrackingFilesMoved[$check]))
		{
			return;
		}

		$typeName  = StringHelper::safe($typeName, 'F') . 'Field';

		$source = $this->paths->component_path . '/admin/src/Field/' . $typeName . '.php';
		$target = $path . '/src/Field/' . $typeName . '.php';

		if (is_file($source))
		{
			// File::copy($source, $target); // TODO we need to update the namespace of the file, for this to load correctly
		}

		$this->extensionTrackingFilesMoved[$check] = true;
	}

	/**
	 * Move custom validation rule files if linked.
	 *
	 * @param   array   $field  The field data.
	 * @param   string  $path   The target path to move to.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	protected function moveValidationRule(array $field, string $path): void
	{
		$fieldId = $field['id'] ?? $field['field'] ?? null;

		if ($fieldId === null)
		{
			return;
		}

		$linkedRule = $this->registry->get('validation.linked.' . $fieldId);

		if ($linkedRule === null)
		{
			return;
		}

		$check = md5($path . 'rule' . $linkedRule);

		if (isset($this->extensionTrackingFilesMoved[$check]))
		{
			return;
		}

		$linkedRule  = StringHelper::safe($linkedRule, 'F') . 'Rule';

		$source = $this->paths->component_path . '/admin/src/Rule/' . $linkedRule . '.php';
		$target = $path . '/src/Rule/' . $linkedRule . '.php';

		if (is_file($source))
		{
			// File::copy($source, $target); // TODO we need to update the namespace of the file, for this to load correctly
		}

		$this->extensionTrackingFilesMoved[$check] = true;
	}

	/**
	 * Move the fields and rules of multi-fields (subform or repeatable).
	 *
	 * @param   array   $multiField  The field data.
	 * @param   string  $path        The target path to move to.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	protected function moveMultiFieldsRules(array $multiField, string $path): void
	{
		$ids = $this->extractFieldIds($multiField);

		if (empty($ids))
		{
			return;
		}

		foreach ($ids as $id)
		{
			$field = ['field' => $id];
			$this->field->set($field);
			$this->move($field, $path);
		}
	}

	/**
	 * Extract field IDs from a multi-field XML definition.
	 *
	 * @param   array  $multiField  The multi-field data.
	 *
	 * @return  array  The extracted field IDs.
	 * @since   5.1.2
	 */
	protected function extractFieldIds(array $multiField): array
	{
		$xml = $multiField['settings']->xml ?? '';

		if (empty($xml))
		{
			return [];
		}

		$rawIds = (string) GetHelper::between($xml, 'fields="', '"');
		$ids = array_map('trim', explode(',', $rawIds));

		return ArrayHelper::check($ids) ? $ids : [];
	}
}

