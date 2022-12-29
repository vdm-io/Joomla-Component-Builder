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
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Interfaces\ModelInterface;
use VDM\Joomla\Componentbuilder\Abstraction\Model;


/**
 * Search Load Model
 * 
 * @since 3.2.0
 */
class Load extends Model implements ModelInterface
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
	 *          Example: $this->value(value, 'value_key', 'table_name');
	 *
	 * @param   mixed          $value    The value to model
	 * @param   string         $field    The field key
	 * @param   string|null    $table    The table
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public function value($value, string $field, ?string $table = null)
	{
		// load the table
		if (empty($table))
		{
			$table = $this->getTable();
		}

		// check if this is a valid table
		if (StringHelper::check($value) && ($store = $this->table->get($table, $field, 'store')) !== null)
		{
			// open the value based on the store method
			switch($store)
			{
				case 'base64':
					$value = base64_decode($value);
				break;
				case 'json':
					// check if there is a json string
					if (JsonHelper::check($value))
					{
						$value = json_decode($value, true);
					}
				break;
			}
		}
		return $value;
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

