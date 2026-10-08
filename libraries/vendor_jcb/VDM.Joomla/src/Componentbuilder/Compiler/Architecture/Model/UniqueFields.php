<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueGuid;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueKeys;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Unique Fields Class.
 * 
 * Builds the statements an admin model runs to keep the fields a view was
 * built to hold unique from clashing with what is already stored.
 * 
 * @since 6.1.7
 */
final class UniqueFields
{
	/**
	 * The Database Unique Guid Builder Class.
	 *
	 * @var   DatabaseUniqueGuid
	 * @since 6.1.7
	 */
	protected DatabaseUniqueGuid $databaseuniqueguid;

	/**
	 * The Database Unique Keys Builder Class.
	 *
	 * @var   DatabaseUniqueKeys
	 * @since 6.1.7
	 */
	protected DatabaseUniqueKeys $databaseuniquekeys;

	/**
	 * Constructor.
	 *
	 * @param DatabaseUniqueGuid $databaseuniqueguid The Database Unique Guid Builder Class.
	 * @param DatabaseUniqueKeys $databaseuniquekeys The Database Unique Keys Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(DatabaseUniqueGuid $databaseuniqueguid,
		DatabaseUniqueKeys $databaseuniquekeys)
	{
		$this->databaseuniqueguid = $databaseuniqueguid;
		$this->databaseuniquekeys = $databaseuniquekeys;
	}

	/**
	 * Build the unique field statements of a view.
	 *
	 * A view with nothing to keep unique gets nothing.
	 *
	 * @param   string  $view  The single view name.
	 *
	 * @return  string  The statements, or nothing when the view holds no unique field.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view): string
	{
		$fields   = [];
		$fields[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$fields[] = Indent::_(1)
			. " * Method to get the unique fields of this table.";
		$fields[] = Indent::_(1) . " *";
		$fields[] = Indent::_(1)
			. " * @return  mixed  An array of field names, boolean false if none is set.";
		$fields[] = Indent::_(1) . " *";
		$fields[] = Indent::_(1) . " * @since   3.0";
		$fields[] = Indent::_(1) . " */";
		$fields[] = Indent::_(1) . "protected function getUniqueFields()";
		$fields[] = Indent::_(1) . "{";
		if ($this->databaseuniquekeys->exists($view))
		{
			// if guid should also be added
			if ($this->databaseuniqueguid->exists($view))
			{
				$fields[] = Indent::_(2) . "return array('" . implode(
						"','", $this->databaseuniquekeys->get($view)
					) . "', 'guid');";
			}
			else
			{
				$fields[] = Indent::_(2) . "return array('" . implode(
						"','", $this->databaseuniquekeys->get($view)
					) . "');";
			}
		}
		// if only GUID is found
		elseif ($this->databaseuniqueguid->exists($view))
		{
			$fields[] = Indent::_(2) . "return array('guid');";
		}
		else
		{
			$fields[] = Indent::_(2) . "return false;";
		}
		$fields[] = Indent::_(1) . "}";

		// return the unique fields
		return implode(PHP_EOL, $fields);
	}
}

