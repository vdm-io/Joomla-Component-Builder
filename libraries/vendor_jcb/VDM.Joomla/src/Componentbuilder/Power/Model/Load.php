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

namespace VDM\Joomla\Componentbuilder\Power\Model;


use VDM\Joomla\Abstraction\Model as AbstractionModel;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Interfaces\ModelInterface;


/**
 * Power Model Load
 * 
 * @since 3.2.0
 */
class Load extends AbstractionModel implements ModelInterface
{
	/**
	 * Model the value
	 *          Example: $this->value(value, 'field_key', 'table_name');
	 *
	 * @param   mixed           $value    The value to model
	 * @param   string          $field    The field key
	 * @param   string|null     $table    The table
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function value($value, string $field, ?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->getTable();
		}

		// check if this is a valid table
		if (($store = $this->table->get($table, $field, 'store')) !== null)
		{
			// open the value based on the store method
			switch($store)
			{
				case 'base64':
					$value = base64_decode((string) $value);
				break;
				case 'json':
					$value = json_decode($value);
				break;
			}
		}

		return $value;
	}

	/**
	 * Validate before the value is modelled
	 *
	 * @param   mixed         $value   The field value
	 * @param   string|null   $field     The field key
	 * @param   string|null   $table   The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function validateBefore(&$value, ?string $field = null, ?string $table = null): bool
	{
		// only strings or numbers allowed
		if (StringHelper::check($value) || is_numeric($value))
		{
			return true;
		}
		// remove empty values
		return false;
	}

	/**
	 * Validate after the value is modelled
	 *
	 * @param   mixed         $value   The field value
	 * @param   string|null   $field     The field key
	 * @param   string|null   $table   The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function validateAfter(&$value, ?string $field = null, ?string $table = null): bool
	{
		// only strings or numbers allowed
		if (StringHelper::check($value) || ArrayHelper::check($value, true)  || ObjectHelper::check($value) || is_numeric($value))
		{
			return true;
		}
		// remove empty values
		return false;
	}

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function getTable(): string
	{
		return 'power';
	}
}

