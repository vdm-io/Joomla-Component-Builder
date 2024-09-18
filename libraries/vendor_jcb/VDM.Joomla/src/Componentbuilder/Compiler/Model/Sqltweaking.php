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
use VDM\Joomla\Utilities\ObjectHelper;


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
			$this->tweak(
				array_map(
					fn($array) => array_map(
						function ($value) {
							if (!ArrayHelper::check($value)
								&& !ObjectHelper::check(
									$value
								)
								&& strval($value) === strval(
									intval($value)
								))
							{
								return (int) $value;
							}

							return $value;
						}, $array
					), array_values($item->sql_tweak)
				)
			);
		}

		unset($item->sql_tweak);
	}

	/**
	 * To limit the SQL Demo data build in the views
	 *
	 * @param   array  $settings  Tweaking array.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function tweak($settings)
	{
		if (ArrayHelper::check($settings))
		{
			foreach ($settings as $setting)
			{
				// should sql dump be added
				if (1 == $setting['add_sql'])
				{
					// add sql (by option)
					if (2 == $setting['add_sql_options'])
					{
						// rest always
						$id_array = [];

						// by id (first remove backups)
						$ids = $setting['ids'];

						// now get the ids
						if (strpos((string) $ids, ',') !== false)
						{
							$id_array = (array) array_map(
								'trim', explode(',', (string) $ids)
							);
						}
						else
						{
							$id_array[] = trim((string) $ids);
						}
						$id_array_new = [];

						// check for ranges
						foreach ($id_array as $key => $id)
						{
							if (strpos($id, '=>') !== false)
							{
								$id_range = (array) array_map(
									'trim', explode('=>', $id)
								);
								unset($id_array[$key]);
								// build range
								if (count((array) $id_range) == 2)
								{
									$range        = range(
										$id_range[0], $id_range[1]
									);
									$id_array_new = [...$id_array_new, ...$range];
								}
							}
						}

						if (ArrayHelper::check($id_array_new))
						{
							$id_array = [...$id_array_new, ...$id_array];
						}

						// final fixing to array
						if (ArrayHelper::check($id_array))
						{
							// unique
							$id_array = array_unique($id_array, SORT_NUMERIC);
							// sort
							sort($id_array, SORT_NUMERIC);
							// now set it to global
							$this->registry->
								set('builder.sql_tweak.' . (int) $setting['adminview'] . '.where', implode(',', $id_array));
						}
					}
				}
				else
				{
					// do not add sql dump options
					$this->registry->
						set('builder.sql_tweak.' . (int) $setting['adminview'] . '.add', false);
				}
			}
		}
	}

}

