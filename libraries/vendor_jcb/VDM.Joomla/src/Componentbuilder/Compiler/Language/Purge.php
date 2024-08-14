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
use VDM\Joomla\Componentbuilder\Compiler\Language\Update;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Compiler Remove Existing Language Strings
 * 
 * @since 5.0.2
 */
final class Purge
{
	/**
	 * The Update Class.
	 *
	 * @var   Update
	 * @since 5.0.2
	 */
	protected Update $update;

	/**
	 * Database object to query local DB
	 *
	 * @since 5.0.2
	 **/
	protected $db;

	/**
	 * Constructor.
	 *
	 * @param Update $update The Update Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Update $update)
	{
		$this->update = $update;
		$this->db = Factory::getDbo();
	}

	/**
	 * Purge the unused language strings.
	 *
	 * This method removes or updates language strings that are no longer linked
	 * to the specified component. It checks if the strings are linked to other
	 * extensions and either updates, archives, or deletes them based on the
	 * conditions.
	 *
	 * @param array  $values     The active strings.
	 * @param int    $targetId   The target component ID.
	 * @param string $target     The target extension type (default is 'components').
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function execute(array $values, int $targetId, string $target = 'components'): void
	{
		$target_types = ['components' => 'components', 'modules' => 'modules', 'plugins' => 'plugins'];

		if (isset($target_types[$target]))
		{
			unset($target_types[$target]);

			// Create a new query object.
			$query = $this->db->getQuery(true);
			$query->from($this->db->quoteName('#__componentbuilder_language_translation', 'a'))
				  ->select($this->db->quoteName(['a.id', 'a.translation', 'a.components', 'a.modules', 'a.plugins']))
				  ->where($this->db->quoteName('a.source') . ' NOT IN (' . implode(',', array_map(fn($a) => $this->db->quote($a), $values)) . ')')
				  ->where($this->db->quoteName('a.published') . ' = 1');

			$this->db->setQuery($query);
			$this->db->execute();

			if ($this->db->getNumRows())
			{
				$counterUpdate = 0;
				$otherStrings = $this->db->loadAssocList();
				$today = Factory::getDate()->toSql();

				foreach ($otherStrings as $item)
				{
					if (JsonHelper::check($item[$target]))
					{
						$targets = (array) json_decode((string) $item[$target], true);

						if (($key = array_search($targetId, $targets)) !== false)
						{
							unset($targets[$key]);

							if (ArrayHelper::check($targets))
							{
								$this->update->set($item['id'], $target, $targets, 1, $today, $counterUpdate);

								$counterUpdate++;

								$this->update->execute(50);
							}
							else
							{
								$this->handleUnlinkedString($item, $target_types, $targets, $today, $counterUpdate);
							}
						}
					}
				}

				$this->update->execute();
			}
		}
	}

	/**
	 * Handle strings that are unlinked from the current component.
	 *
	 * This method checks if a string is linked to other extensions and either updates,
	 * archives, or deletes it based on the conditions.
	 *
	 * @param array  $item          The language string item.
	 * @param array  $targetTypes  The target extension types.
	 * @param array  $targets       The targets to update.
	 * @param string $today         The current date.
	 * @param int    $counter       The update counter.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function handleUnlinkedString(array $item, array $targetTypes, array $targets, string $today, int &$counter): void
	{
		// the action (1 = remove, 2 = archive, 0 = do nothing)
		$action_with_string = 1;

		foreach ($targetTypes as $other_target)
		{
			if ($action_with_string && JsonHelper::check($item[$other_target]))
			{
				$other_targets = (array) json_decode((string) $item[$other_target], true);

				if (ArrayHelper::check($other_targets))
				{
					$action_with_string = 0;
				}
			}
		}

		if ($action_with_string && JsonHelper::check($item['translation']))
		{
			$translation = json_decode((string) $item['translation'], true);

			if (ArrayHelper::check($translation))
			{
				$this->update->set($item['id'], $targets, $targets, 2, $today, 	$counter);
				$counter++;
				$this->update->execute(50);
				$action_with_string = 2;
			}
		}

		if ($action_with_string == 1)
		{
			$this->removeExitingLangString($item['id']);
		}
	}

	/**
	 * Remove existing language translation strings.
	 *
	 * This method deletes a language string from the database based on its ID.
	 *
	 * @param int $id The string ID to remove.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function removeExitingLangString(int $id): void
	{
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__componentbuilder_language_translation'))
			->where($this->db->quoteName('id') . ' = ' . (int) $id);

		$this->db->setQuery($query);
		$this->db->execute();
	}
}

