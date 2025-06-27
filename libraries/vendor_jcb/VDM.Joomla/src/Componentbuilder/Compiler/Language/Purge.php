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
	 * Purge unused language strings linked to a component.
	 *
	 * This method removes or updates language strings that are no longer linked
	 * to the specified component. It checks if the strings are linked to other
	 * extensions and either updates, archives, or deletes them based on the
	 * conditions.
	 *
	 * @param array  $values     Active string sources.
	 * @param string $targetGuid The GUID of the target entity.
	 * @param string $target     Target extension type. Default: 'components'.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function execute(array $values, string $targetGuid, string $target = 'components'): void
	{
		$validTargets = ['components' => 'components', 'modules' => 'modules', 'plugins' => 'plugins'];

		if (!isset($validTargets[$target]))
		{
			return;
		}

		$otherTargets = array_diff_key($validTargets, [$target => $target]);

		$query = $this->db->getQuery(true)
			->select($this->db->quoteName(['id', 'translation', 'components', 'modules', 'plugins']))
			->from($this->db->quoteName('#__componentbuilder_language_translation', 'a'))
			->where($this->db->quoteName('a.source') . ' NOT IN (' . implode(',', array_map([$this->db, 'quote'], $values)) . ')')
			->where($this->db->quoteName('a.published') . ' = 1');

		$this->db->setQuery($query);
		$this->db->execute();

		if (!$this->db->getNumRows())
		{
			return;
		}

		$today         = Factory::getDate()->toSql();
		$items         = $this->db->loadAssocList();
		$counterUpdate = 0;

		foreach ($items as $item)
		{
			if (!JsonHelper::check($item[$target]))
			{
				continue;
			}

			$targets = (array) json_decode((string) $item[$target], true);

			if (($key = array_search($targetGuid, $targets, true)) === false)
			{
				continue;
			}

			unset($targets[$key]);

			if (ArrayHelper::check($targets))
			{
				$this->update->set($item['id'], $target, $targets, 1, $today, $counterUpdate);
				$counterUpdate++;
				$this->update->execute(50);
			}
			else
			{
				$this->handleUnlinkedString($item, $otherTargets, $target, $targets, $today, $counterUpdate);
			}
		}

		$this->update->execute();
	}

	/**
	 * Handle strings no longer linked to the current component.
	 *
	 * @param array  $item        The language string item.
	 * @param array  $otherTypes  Other extension types.
	 * @param string $target      The current target extension type.
	 * @param array  $targets     Remaining targets to update.
	 * @param string $today       Current date in SQL format.
	 * @param int    $counter     Counter for updates.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function handleUnlinkedString(array $item, array $otherTypes, string $target,
		array $targets, string $today, int &$counter): void
	{
		$action = 1; // 1 = remove, 2 = archive, 0 = keep

		foreach ($otherTypes as $type)
		{
			if (JsonHelper::check($item[$type]))
			{
				$linked = json_decode((string) $item[$type], true);
				if (ArrayHelper::check($linked))
				{
					$action = 0;
					break;
				}
			}
		}

		if ($action && JsonHelper::check($item['translation']))
		{
			$translation = json_decode((string) $item['translation'], true);

			if (ArrayHelper::check($translation))
			{
				$this->update->set($item['id'], $target, $targets, 2, $today, $counter);
				$counter++;
				$this->update->execute(50);
				$action = 2; // just to show intent :)
				return;
			}
		}

		if ($action === 1)
		{
			$this->removeLanguageString($item['id']);
		}
	}

	/**
	 * Delete a language string by ID.
	 *
	 * @param int $id The ID of the string.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function removeLanguageString(int $id): void
	{
		$query = $this->db->getQuery(true)
			->delete($this->db->quoteName('#__componentbuilder_language_translation'))
			->where($this->db->quoteName('id') . ' = ' . (int) $id);

		$this->db->setQuery($query);
		$this->db->execute();
	}
}

