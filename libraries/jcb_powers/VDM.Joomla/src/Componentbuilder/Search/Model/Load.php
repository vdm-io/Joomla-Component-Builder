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
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Interfaces\ModelInterface;
use VDM\Joomla\Abstraction\Model;


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
					$value = base64_decode((string) $value);
				break;
				case 'json':
					// check if there is a json string
					if (JsonHelper::check($value))
					{
						$value = json_decode((string) $value, true);
					}
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
		return true;
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
		// Start note to self
		// Yes we don't search in the field->xml (field) PHP because the xml is messy
		//    first of all we need to change that storage method :((( seriously
		//    and the actual PHP is stored in the xml as base64 with a [__.o0=base64=Oo.__] key in front of it
		//    if I can go back and drag you around by your ear... I will, but okay you did not know better.
		//  Listen you have tried to fix this a few times already (I lost count) and by the time you realize how it works
		//    two hours have been wasted, and you usually only then realize why it's not fixed in the first place... o boy... just walk now!
		//    since unless you have three days don't even look further, this is a huge issue/mess
		//    and while I agree it needs fixing, it will not take a few hours... but days
		// End note to self

		// check values
		if (StringHelper::check($value) || ArrayHelper::check($value, true))
		{
			return true;
		}

		// remove empty values
		return false;

		// Start another note to self
		// If you're still here
		//    the problem is not opening the PHP in the xml,
		//    it is storing it with the updated changes... if any are made via the search-update methods
		//    so the only way to fix this is to change the whole way the xml values in the field table is stored.
		//  Yes, that is right... all the way back to the field view... and then to update all places you open that xml values
		//    and get the values out of the xml string and use them, and if you've forgotten, that is nearly everywhere,
		//    and so let the refactoring of the foundation begin... there I saved you another 3 hours.
		// End another note to self
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

