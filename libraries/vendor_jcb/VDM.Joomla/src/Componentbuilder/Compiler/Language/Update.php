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

namespace VDM\Joomla\Componentbuilder\Compiler\Language;


use Joomla\CMS\Factory;


/**
 * Compiler Update Existing Language Strings
 * 
 * @since 5.0.2
 */
final class Update
{
	/**
	 * The items to update
	 *
	 * @var    array
	 * @since  5.0.2
	 **/
	protected array $items = [];

	/**
	 * Database object to query local DB
	 *
	 * @since 5.0.2
	 **/
	protected $db;

	/**
	 * User object
	 *
	 * @since 5.0.2
	 **/
	protected $user;

	/**
	 * Constructor.
	 *
	 * @since 5.0.2
	 */
	public function __construct()
	{
		$this->db = Factory::getDbo();
		$this->user = Factory::getUser();
	}

	/**
	 * Add a language string to the existing language strings array for updating.
	 *
	 * This method prepares and stores the update information for a language string
	 * in the `items` array, which is later used by the `execute` method to update
	 * the database.
	 *
	 * @param int    $id        The ID of the language string.
	 * @param string $target    The target field to be updated.
	 * @param array  $targets   The new values for the target field.
	 * @param int    $published The published state.
	 * @param string $today	    The current date.
	 * @param int    $counter   The counter for the items array.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function set(int $id, string $target, array $targets, int $published, string $today, int $counter): void
	{
		// Start the bucket for this language item.
		$this->items[$counter] = [];
		$this->items[$counter]['id'] = (int) $id;

		// Prepare the conditions for the update query.
		$this->items[$counter]['conditions'] = [];
		$this->items[$counter]['conditions'][] = $this->db->quoteName('id') . ' = ' . $this->db->quote($id);

		// Prepare the fields for the update query.
		$this->items[$counter]['fields'] = [];
		$this->items[$counter]['fields'][] = $this->db->quoteName($target) . ' = ' . $this->db->quote(json_encode($targets));
		$this->items[$counter]['fields'][] = $this->db->quoteName('published') . ' = ' . $this->db->quote($published);
		$this->items[$counter]['fields'][] = $this->db->quoteName('modified') . ' = ' . $this->db->quote($today);
		$this->items[$counter]['fields'][] = $this->db->quoteName('modified_by') . ' = ' . $this->db->quote((int) $this->user->id);
	}

	/**
	 * Update the language placeholders in the database.
	 *
	 * This method updates the language placeholders in the database if the number of items
	 * meets or exceeds the specified threshold (`$when`). It constructs and executes an
	 * update query for each set of values in the `items` array.
	 *
	 * @param int $when The threshold count to determine when to update. Default is 1.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function execute(int $when = 1): void
	{
		if (count((array) $this->items) >= $when)
		{
			foreach ($this->items as $values)
			{
				// Create a new query object.
				$query = $this->db->getQuery(true);

				// Prepare the update query.
				$query->update($this->db->quoteName('#__componentbuilder_language_translation'))
					  ->set($values['fields'])
					  ->where($values['conditions']);

				// Set the query using our newly populated query object and execute it.
				$this->db->setQuery($query);
				$this->db->execute();
			}

			// Clear the items array.
			$this->items = [];
		}
	}
}

