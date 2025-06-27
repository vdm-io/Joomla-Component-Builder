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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Model Sql Tweaking Class
 * 
 * @since 3.2.0
 */
class Sqltweaking
{
	/**
	 * Compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Constructor
	 *
	 * @param Registry    $registry     The compiler registry object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
	}

	/**
	 * Set sql tweaking if needed
	 *
	 * @param   object  $item  The extension data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		// set the sql_tweak data
		$item->sql_tweak = (isset($item->sql_tweak)
			&& JsonHelper::check($item->sql_tweak))
			? json_decode((string) $item->sql_tweak, true) : null;

		if (ArrayHelper::check($item->sql_tweak))
		{
			// build the tweak settings
			$this->tweak($item->sql_tweak);
		}

		unset($item->sql_tweak);
	}

	/**
	 * Limit the SQL Demo data build in the views by applying tweak settings.
	 *
	 * @param   array  $settings  The tweak configuration array.
	 *
	 * @return  void
	 * @since   3.2.0
	 */
	protected function tweak(array $settings): void
	{
		if (!ArrayHelper::check($settings))
		{
			return;
		}

		foreach ($settings as $setting)
		{
			$adminView = $setting['adminview'] ?? null;

			if (!$adminView)
			{
				continue;
			}

			$addSql = (int) ($setting['add_sql'] ?? 0);
			$addSqlOptions = (int) ($setting['add_sql_options'] ?? 0);

			if ($addSql === 1 && $addSqlOptions === 2)
			{
				$ids = $setting['ids'] ?? '';
				$idArray = $this->normalizeIds($ids);

				if (!empty($idArray))
				{
					$this->registry->set(
						'builder.sql_tweak.' . $adminView . '.where',
						implode(',', $idArray)
					);
				}
			}
			elseif ($addSql === 0)
			{
				$this->registry->set(
					'builder.sql_tweak.' . $adminView . '.add',
					false
				);
			}
		}
	}

	/**
	 * Normalize a comma-separated string of IDs or ID ranges into a unique, sorted array.
	 *
	 * Supports individual IDs (e.g., "1,3,5") and ranges (e.g., "10 => 12").
	 *
	 * @param   string  $ids  Raw ID string from settings.
	 *
	 * @return  array<int>  Normalized list of numeric IDs.
	 * @since   5.1.1
	 */
	private function normalizeIds(string $ids): array
	{
		$rawIds = array_map('trim', explode(',', $ids));
		$finalIds = [];

		foreach ($rawIds as $id)
		{
			if (strpos($id, '=>') !== false)
			{
				$rangeParts = array_map('trim', explode('=>', $id));

				if (count($rangeParts) === 2 && is_numeric($rangeParts[0]) && is_numeric($rangeParts[1]))
				{
					$range = range((int) $rangeParts[0], (int) $rangeParts[1]);
					$finalIds = array_merge($finalIds, $range);
					continue;
				}
			}

			if (is_numeric($id))
			{
				$finalIds[] = (int) $id;
			}
		}

		$finalIds = array_unique($finalIds, SORT_NUMERIC);
		sort($finalIds, SORT_NUMERIC);

		return $finalIds;
	}
}

