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

namespace VDM\Joomla\Componentbuilder\Search\Model;


use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Table;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Interfaces\ModelInterface;
use VDM\Joomla\Componentbuilder\Abstraction\Model;


/**
 * Search Insert Model
 * 
 * @since 3.2.0
 */
class Insert extends Model implements ModelInterface
{
	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Constructor
	 *
	 * @param Config|null       $config           The search config object.
	 * @param Table|null         $table            The search table object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Table $table = null)
	{
		parent::__construct($table ?? Factory::_('Table'));

		$this->config = $config ?: Factory::_('Config');
	}

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
					$value = base64_encode((string) $value);
				break;
				case 'json':
					$value = json_encode($value,  JSON_FORCE_OBJECT);
				break;
			}
		}

		return $value;
	}

	/**
	 * Validate before the value is modelled (basic, override in child class)
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
		// check values
		if (StringHelper::check($value) || ArrayHelper::check($value, true))
		{
			return true;
		}
		// remove empty values
		return false;
	}

	/**
	 * Validate after the value is modelled (basic, override in child class)
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
		return true;
	}

	/**
	 * Get the current active table
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function getTable(): string
	{
		return $this->config->table_name;
	}

}

