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


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\StringHelper;


/**
 * SQL Dump Class
 * 
 * @since 3.2.0
 */
class Sqldump
{
	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor
	 *
	 * @param Registry    $registry    The compiler registry object.
	 
	 * @since 3.2.0
	 */
	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
		$this->db = Factory::getDbo();
	}

	/**
	 * Get SQL Dump
	 *
	 * @param   array   $tables   The tables to use in build
	 * @param   string  $view     The target view/table to dump in
	 * @param   int     $view_id  The id of the target view
	 *
	 * @return  string|null The data found with the alias
	 * @since 3.2.0
	 */
	public function get(array $tables, string $view, int $view_id): ?string
	{
		// first build a query statement to get all the data (insure it must be added - check the tweaking)
		if (ArrayHelper::check($tables)
			&& $this->registry-> // default is to add
			get('builder.sql_tweak.' . (int) $view_id . '.add', true))
		{
			$counter = 'a';

			// Create a new query object.
			$query = $this->db->getQuery(true);

			// switch to only trigger the run of the query if we have tables to query
			$run_query = false;
			foreach ($tables as $table)
			{
				if (isset($table['table']))
				{
					if ($counter === 'a')
					{
						// the main table fields
						if (strpos((string) $table['sourcemap'], PHP_EOL) !== false)
						{
							$fields = explode(PHP_EOL, (string) $table['sourcemap']);
							if (ArrayHelper::check($fields))
							{
								// reset array buckets
								$sourceArray = [];
								$targetArray = [];
								foreach ($fields as $field)
								{
									if (strpos($field, "=>") !== false)
									{
										list($source, $target) = explode(
											"=>", $field
										);
										$sourceArray[] = $counter . '.' . trim(
												$source
											);
										$targetArray[] = trim($target);
									}
								}
								if (ArrayHelper::check(
										$sourceArray
									)
									&& ArrayHelper::check(
										$targetArray
									))
								{
									// add to query
									$query->select(
										$this->db->quoteName(
											$sourceArray, $targetArray
										)
									);
									$query->from(
										'#__' . $table['table'] . ' AS a'
									);
									$run_query = true;
								}
								// we may need to filter the selection
								if (($ids_ = $this->registry->
									get('builder.sql_tweak.' . (int) $view_id . '.where', null)) !== null)
								{
									// add to query the where filter
									$query->where(
										'a.id IN (' . $ids_ . ')'
									);
								}
							}
						}
					}
					else
					{
						// the other tables
						if (strpos((string) $table['sourcemap'], PHP_EOL) !== false)
						{
							$fields = explode(PHP_EOL, (string) $table['sourcemap']);
							if (ArrayHelper::check($fields))
							{
								// reset array buckets
								$sourceArray = [];
								$targetArray = [];
								foreach ($fields as $field)
								{
									if (strpos($field, "=>") !== false)
									{
										list($source, $target) = explode(
											"=>", $field
										);
										$sourceArray[] = $counter . '.' . trim(
												$source
											);
										$targetArray[] = trim($target);
									}
									if (strpos($field, "==") !== false)
									{
										list($aKey, $bKey) = explode(
											"==", $field
										);
										// add to query
										$query->join(
											'LEFT', $this->db->quoteName(
												'#__' . $table['table'],
												$counter
											) . ' ON (' . $this->db->quoteName(
												'a.' . trim($aKey)
											) . ' = ' . $this->db->quoteName(
												$counter . '.' . trim($bKey)
											) . ')'
										);
									}
								}
								if (ArrayHelper::check(
										$sourceArray
									)
									&& ArrayHelper::check(
										$targetArray
									))
								{
									// add to query
									$query->select(
										$this->db->quoteName(
											$sourceArray, $targetArray
										)
									);
								}
							}
						}
					}
					$counter++;
				}
				else
				{
					// see where
					// var_dump($view);
					// jexit();
				}
			}

			// check if we should run query
			if ($run_query)
			{
				// now get the data
				$this->db->setQuery($query);
				$this->db->execute();
				if ($this->db->getNumRows())
				{
					// get the data
					$data = $this->db->loadObjectList();

					// start building the MySql dump
					$dump = "--";
					$dump .= PHP_EOL . "-- Dumping data for table `#__"
						. Placefix::_("component") . "_" . $view
						. "`";
					$dump .= PHP_EOL . "--";
					$dump .= PHP_EOL . PHP_EOL . "INSERT INTO `#__" . Placefix::_("component") . "_" . $view . "` (";
					foreach ($data as $line)
					{
						$comaSet = 0;
						foreach ($line as $fieldName => $fieldValue)
						{
							if ($comaSet == 0)
							{
								$dump .= $this->db->quoteName($fieldName);
							}
							else
							{
								$dump .= ", " . $this->db->quoteName(
										$fieldName
									);
							}
							$comaSet++;
						}
						break;
					}
					$dump .= ") VALUES";
					$coma = 0;
					foreach ($data as $line)
					{
						if ($coma == 0)
						{
							$dump .= PHP_EOL . "(";
						}
						else
						{
							$dump .= "," . PHP_EOL . "(";
						}
						$comaSet = 0;
						foreach ($line as $fieldName => $fieldValue)
						{
							if ($comaSet == 0)
							{
								$dump .= $this->escape($fieldValue);
							}
							else
							{
								$dump .= ", " . $this->escape(
										$fieldValue
									);
							}
							$comaSet++;
						}
						$dump .= ")";
						$coma++;
					}
					$dump .= ";";

					// return build dump query
					return $dump;
				}
			}
		}

		return null;
	}

	/**
	 * Escape the values for a SQL dump
	 *
	 * @param   string|array  $value  the value to escape
	 *
	 * @return  string|array on success with escaped string
	 * @since 3.2.0
	 */
	protected function escape($value)
	{
		// if array then return mapped
		if (ArrayHelper::check($value))
		{
			return array_map(__METHOD__, $value);
		}

		// if string make sure it is correctly escaped
		if (StringHelper::check($value) && !is_numeric($value))
		{
			return $this->db->quote($value);
		}

		// if empty value return place holder
		if (empty($value))
		{
			return "''";
		}

		// if not array or string then return number
		return $value;
	}

}

