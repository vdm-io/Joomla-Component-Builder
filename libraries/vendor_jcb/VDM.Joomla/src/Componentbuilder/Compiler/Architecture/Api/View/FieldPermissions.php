<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View;


use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionFields;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Api View Field Permissions Class.
 * 
 * Builds the guards that drop a field from the rendered field list of a
 * JSON API view when the user lacks its access or view permission, the
 * permissions the admin form removes or hides the same field on.
 * 
 * @since 6.1.7
 */
final class FieldPermissions
{
	/**
	 * The Component code name.
	 *
	 * @var   string
	 * @since 6.1.7
	 */
	protected string $component;

	/**
	 * The Permission Fields Builder Class.
	 *
	 * @var   PermissionFields
	 * @since 6.1.7
	 */
	protected PermissionFields $permissionfields;

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param PermissionFields   $permissionfields   The Permission Fields Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, PermissionFields $permissionfields)
	{
		$this->component = $config->component_code_name;
		$this->permissionfields = $permissionfields;
	}

	/**
	 * Get the field permission guards of a JSON API view.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   bool    $item            Guard the item field list, else the list field list.
	 *
	 * @return  string  The guard lines, or nothing when no field is guarded.
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, bool $item = true): string
	{
		$guarded = $this->guarded($nameSingleCode);

		if ($guarded === [])
		{
			return '';
		}

		$property = $item ? 'fieldsToRenderItem' : 'fieldsToRenderList';
		$code = [];

		// the item guards follow a closing brace, the list guards the opening one
		$code[] = ($item ? PHP_EOL . PHP_EOL : PHP_EOL) . Indent::_(2) . "//"
			. Line::_(__LINE__, __CLASS__) . " Get user object.";
		$code[] = Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";

		if ($item)
		{
			$code[] = Indent::_(2) . "\$id = is_object(\$item) ? (int) \$item->id : 0;";
		}

		foreach ($guarded as $fieldName => $options)
		{
			foreach ($options as $option)
			{
				$action = $nameSingleCode . '.' . $option . '.' . $fieldName;

				$code[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
					. " Remove the " . $fieldName . " value based on "
					. ucfirst($option) . " access controls.";

				if ($item)
				{
					$code[] = Indent::_(2) . "if ((\$id != 0 && !\$user->authorise('"
						. $action . "', 'com_" . $this->component . "."
						. $nameSingleCode . ".' . \$id))";
					$code[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
						. $action . "', 'com_" . $this->component . "')))";
				}
				else
				{
					$code[] = Indent::_(2) . "if (!\$user->authorise('" . $action
						. "', 'com_" . $this->component . "'))";
				}

				$code[] = Indent::_(2) . "{";
				$code[] = Indent::_(3) . "\$this->" . $property
					. " = array_values(array_diff(\$this->" . $property . ", ['"
					. $fieldName . "']));";
				$code[] = Indent::_(3) . "\$this->relationship"
					. " = array_values(array_diff(\$this->relationship, ['"
					. $fieldName . "']));";
				$code[] = Indent::_(2) . "}";
			}
		}

		return implode(PHP_EOL, $code);
	}

	/**
	 * The fields of the view that carry an access or view permission.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 *
	 * @return  array  Field name to its guarded permission options.
	 * @since   6.1.7
	 */
	private function guarded(string $nameSingleCode): array
	{
		$guarded = [];

		if (!$this->permissionfields->isArray($nameSingleCode))
		{
			return $guarded;
		}

		foreach ($this->permissionfields->get($nameSingleCode) as $fieldName => $options)
		{
			if (!is_array($options))
			{
				continue;
			}

			foreach (array_keys($options) as $option)
			{
				if ($option === 'access' || $option === 'view')
				{
					$guarded[(string) $fieldName][] = $option;
				}
			}
		}

		return $guarded;
	}
}

