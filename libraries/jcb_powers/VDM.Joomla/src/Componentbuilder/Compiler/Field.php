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

namespace VDM\Joomla\Componentbuilder\Compiler;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Field\Data;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name;
use VDM\Joomla\Componentbuilder\Compiler\Field\TypeName;
use VDM\Joomla\Componentbuilder\Compiler\Field\UniqueName;


/**
 * Compiler Field
 * 
 * @since 3.2.0
 */
class Field
{
	/**
	 * Compiler Field Data
	 *
	 * @var    Data
	 * @since 3.2.0
	 **/
	protected Data $data;

	/**
	 * Compiler Field Name
	 *
	 * @var    Name
	 * @since 3.2.0
	 **/
	protected Name $name;

	/**
	 * Compiler Field Type Name
	 *
	 * @var    TypeName
	 * @since 3.2.0
	 **/
	protected TypeName $typeName;

	/**
	 * Compiler Field Unique Name
	 *
	 * @var    UniqueName
	 * @since 3.2.0
	 **/
	protected UniqueName $uniqueName;

	/**
	 * Constructor
	 *
	 * @param Data|null          $data          The compiler field data object.
	 * @param Name|null          $name          The compiler field name object.
	 * @param TypeName|null      $typeName      The compiler field type name object.
	 * @param UniqueName|null    $uniqueName    The compiler field unique name object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Data $data = null, ?Name $name = null, ?TypeName $typeName = null, ?UniqueName $uniqueName = null)
	{
		$this->data = $data ?: Compiler::_('Field.Data');
		$this->name = $name ?: Compiler::_('Field.Name');
		$this->typeName = $typeName ?: Compiler::_('Field.Type.Name');
		$this->uniqueName = $uniqueName ?: Compiler::_('Field.Unique.Name');
	}

	/**
	 * set Field details
	 *
	 * @param   array        $field           The field array.
	 * @param   string|null  $singleViewName  The single view name.
	 * @param   string|null  $listViewName    The list view name.
	 * @param   string       $amicably        The peaceful resolve.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(array &$field, ?string $singleViewName = null, ?string $listViewName = null, string $amicably = '')
	{
		// set hash
		static $hash = 123467890;

		// load hash if not found
		if (!isset($field['hash']))
		{
			$field['hash'] = \md5($field['field'] . $hash);
			// increment hash
			$hash++;
		}

		// set the settings
		if (!isset($field['settings']))
		{
			$field['settings'] = $this->data->get(
				$field['field'], $singleViewName, $listViewName
			);
		}

		// set real field name
		if (!isset($field['base_name']))
		{
			$field['base_name'] = $this->name->get($field);
		}

		// set code name for field type
		if (!isset($field['type_name']))
		{
			$field['type_name'] =  $this->typeName->get($field);
		}

		// check if value is array
		if (isset($field['permission'])
			&& !ArrayHelper::check($field['permission'])
			&& is_numeric($field['permission']) && $field['permission'] > 0)
		{
			$field['permission'] = array($field['permission']);
		}

		// set unique name keeper
		if ($listViewName)
		{
			$this->uniqueName->set(
				$field['base_name'], $listViewName . $amicably
			);
		}
	}

}

