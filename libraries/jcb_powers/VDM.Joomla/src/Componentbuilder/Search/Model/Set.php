<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search\Model;


use VDM\Joomla\Componentbuilder\Search\Interfaces\ModelInterface;
use VDM\Joomla\Componentbuilder\Search\Model;


/**
 * Search Set Model
 * 
 * @since 3.2.0
 */
class Set extends Model implements ModelInterface
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
			$table = $this->config->table_name;
		}

		// check if this is a valid table
		if (($store = $this->table->get($table, $field, 'store')) !== null)
		{
			// open the value based on the store method
			switch($store)
			{
				case 'base64':
					$value = \base64_encode($value);
				break;
				case 'json':
					$value = \json_encode($value,  JSON_FORCE_OBJECT);
				break;
			}
		}
		return $value;
	}

}

