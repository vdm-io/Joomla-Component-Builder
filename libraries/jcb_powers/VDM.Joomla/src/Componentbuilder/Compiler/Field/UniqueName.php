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

namespace VDM\Joomla\Componentbuilder\Compiler\Field;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Componentbuilder\Compiler\Registry;


/**
 * Compiler Field Unique Name
 * 
 * @since 3.2.0
 */
class UniqueName
{
	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Constructor
	 *
	 * @param Registry|null     $registry   The compiler registry object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Registry $registry = null)
	{
		$this->registry = $registry ?: Compiler::_('Registry');
	}

	/**
	 * Count how many times the same field is used per view
	 *
	 * @param   string  $name  The name of the field
	 * @param   string  $view  The name of the view
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $name, string $view)
	{
		if (($number = $this->registry->get("unique.names.${view}.counter.${name}")) === null)
		{
			$this->registry->set("unique.names.${view}.counter.${name}", 1);

			return;
		}

		// count how many times the field is used
		$this->registry->set("unique.names.${view}.counter.${name}", ++$number);

		return;
	}

	/**
	 * Naming each field with an unique name
	 *
	 * @param   string  $name  The name of the field
	 * @param   string  $view  The name of the view
	 *
	 * @return  string   the name
	 * @since 3.2.0
	 */
	public function get(string $name, string $view): string
	{
		// only increment if the field name is used multiple times
		if ($this->registry->get("unique.names.${view}.counter.${name}") > 1)
		{
			$counter = 1;
			// set the unique name
			$unique_name = FieldHelper::safe(
				$name . '_' . $counter
			);

			while ($this->registry->get("unique.names.${view}.names.${unique_name}") !== null)
			{
				// increment the number
				$counter++;
				// try again
				$unique_name = FieldHelper::safe(
					$name . '_' . $counter
				);
			}

			// set the new name number
			$this->registry->set("unique.names.${view}.names.${unique_name}", $counter);

			// return the unique name
			return $unique_name;
		}

		return $name;
	}

}

