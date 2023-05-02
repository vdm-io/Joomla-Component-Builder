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

namespace VDM\Joomla\Componentbuilder\Compiler\Power;


use Joomla\CMS\Factory;
use VDM\Joomla\Utilities\GuidHelper;


/**
 * Compiler Power Extractor
 * @since 3.2.0
 */
final class Extractor
{
	/**
	 * The pattern to get the powers
	 *
	 * @var    string
	 * @since 3.2.0
	 **/
	protected string $pattern = '/Super_'.'_'.'_[a-zA-Z0-9_]+_'.'_'.'_Power/';

	/**
	 * Powers GUID's
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $powers = [];

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * Constructor
	 *
	 * @param \JDatabaseDriver|null    $db   The database object.
	 * @since 3.2.0
	 */
	public function __construct(?\JDatabaseDriver $db = null)
	{
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Get Super Powers from the code string
	 *
	 * @param string    $code The code
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function get_(): ?array
	{
		return $this->powers !== [] ? $this->powers : null;
	}

	/**
	 * Get Super Powers from the code string
	 *
	 * @param string    $code The code
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function get(string $code): ?array
	{
		$matches = [];
		preg_match_all($this->pattern, $code, $matches);

		$found = $matches[0];

		if (!empty($found))
		{
			return $this->map($found);
		}

		return null;
	}

	/**
	 * Get Super Powers from the code string
	 *
	 * @param string    $code The code
	 *
	 * @return array|null
	 * @since 3.2.0
	 */
	public function reverse(string $code): ?array
	{
		$matches = [];
		preg_match_all($this->pattern, $code, $matches);

		$found = $matches[0];

		if (!empty($found) && ($guids = $this->filter($found)) !== null)
		{
			return $this->namespaces($guids);
		}

		return null;
	}

	/**
	 * Get Super Powers from the code string and load it
	 *
	 * @param string    $code The code
	 *
	 * @return void
	 * @since 3.2.0
	 */
	public function search(string $code)
	{
		$matches = [];
		preg_match_all($this->pattern, $code, $matches);

		$found = $matches[0];

		if (!empty($found))
		{
			$this->load($found);
		}
	}

	/**
	 * Load the Super Powers found
	 *
	 * @param array    $found The found Super Powers
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function load(array $found)
	{
		foreach ($found as $super_power)
		{
			$guid = str_replace(['Super_'.'_'.'_', '_'.'_'.'_Power'], '', $super_power);
			$guid = str_replace('_', '-', $guid);

			if (GuidHelper::valid($guid))
			{
				$this->powers[$guid] = 1; // 1 force the power to be added
			}
		}
	}

	/**
	 * Map the Super Powers to GUIDs
	 *
	 * @param array    $found The found Super Powers
	 *
	 * @return array
	 * @since 3.2.0
	 */
	protected function map(array $found): ?array
	{
		$guids = [];

		foreach ($found as $super_power)
		{
			$guid = str_replace(['Super_'.'_'.'_', '_'.'_'.'_Power'], '', $super_power);
			$guid = str_replace('_', '-', $guid);

			if (GuidHelper::valid($guid))
			{
				$guids[$super_power] = $guid;
			}
		}

		return $guids !== [] ? $guids : null;
	}

	/**
	 * Filter the Super Powers to GUIDs
	 *
	 * @param array    $found The found Super Powers
	 *
	 * @return array
	 * @since 3.2.0
	 */
	protected function filter(array $found): ?array
	{
		$guids = [];

		foreach ($found as $super_power)
		{
			$guid = str_replace(['Super_'.'_'.'_', '_'.'_'.'_Power'], '', $super_power);
			$guid = str_replace('_', '-', $guid);

			if (GuidHelper::valid($guid))
			{
				$guids[$guid] = $guid;
			}
		}

		return $guids !== [] ? array_values($guids) : null;
	}

	/**
	 * Get the complete namespace strings of the guids passed as an array.
	 *
	 * @param array $guids The guids to filter the results
	 *
	 * @return array|null The result namespaces with their guids
	 * @since 3.2.0
	 **/
	protected function namespaces(array $guids): ?array
	{
		$query = $this->db->getQuery(true);
		$query->select(
			'DISTINCT REPLACE('
			. $this->db->quoteName('namespace')
			. ', ".", "\\\") AS full_namespace, '
			. $this->db->quoteName('guid')
			)
			->from($this->db->quoteName('#__componentbuilder_power'))
			->where($this->db->quoteName('guid') . ' IN (' . implode(',', array_map([$this->db, 'quote'], $guids)) . ')');
		$this->db->setQuery($query);
		$this->db->execute();

		if ($this->db->getNumRows())
		{
			return $this->db->loadAssocList('guid', 'full_namespace');
		}

		return null;
	}
}

