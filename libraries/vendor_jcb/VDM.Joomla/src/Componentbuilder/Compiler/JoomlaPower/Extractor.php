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

namespace VDM\Joomla\Componentbuilder\Compiler\JoomlaPower;


use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Power\ExtractorInterface;
use VDM\Joomla\Componentbuilder\Compiler\Power\Extractor as ExtendingExtractor;


/**
 * Compiler Joomla Power Extractor
 * @since 3.2.1
 */
final class Extractor extends ExtendingExtractor implements ExtractorInterface
{
	/**
	 * The pattern to get the powers
	 *
	 * @var    string
	 * @since 3.2.0
	 **/
	protected string $pattern = '/Joomla_'.'_'.'_[a-zA-Z0-9_]+_'.'_'.'_Power/';

	/**
	 * The pattern to get the Front
	 *
	 * @var    string
	 * @since 3.2.1
	 **/
	protected string $_pattern = 'Joomla';

	/**
	 * The pattern to get the Back
	 *
	 * @var    string
	 * @since 3.2.1
	 **/
	protected string $pattern_ = 'Power';

	/**
	 * The Table
	 *
	 * @var    string
	 * @since 3.2.1
	 **/
	protected string $table = 'joomla_power';

	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected $targetVersion;

	/**
	 * Constructor.
	 *
	 * @param int    $targetVersion   The targeted Joomla version.
	 *
	 * @since 3.2.1
	 */
	public function __construct(int $targetVersion)
	{
		parent::__construct();

		$this->targetVersion = $targetVersion;
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
		$query->select($this->db->quoteName(['settings', 'guid']))
			->from($this->db->quoteName('#__componentbuilder_' . $this->table))
			->where($this->db->quoteName('guid') . ' IN (' . implode(',', array_map([$this->db, 'quote'], $guids)) . ')');
		$this->db->setQuery($query);
		$this->db->execute();

		if ($this->db->getNumRows())
		{
			$namespaces = [];
			$items = $this->db->loadAssocList();
			foreach ($items as $item)
			{
				if (JsonHelper::check($item->settings))
				{
					$item->settings = json_decode($item->settings, true);
					echo '<pre>'; var_dump($item->settings, 'Joomla Version: ' . $this->targetVersion); exit;
				}
			}

			if ($namespaces !== [])
			{
				return $namespaces;
			}
		}

		return null;
	}
}

