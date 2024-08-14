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
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Compiler Language Multilingual
 * 
 * @since 5.0.2
 */
final class Multilingual
{
	/**
	 * Database object to query local DB
	 *
	 * @since 5.0.2
	 **/
	protected $db;

	/**
	 * Constructor.
	 *
	 * @since 5.0.2
	 */
	public function __construct()
	{
		$this->db = Factory::getDbo();
	}

	/**
	 * Get the other languages
	 *
	 * @param   array  $values  The lang strings to get
	 *
	 * @return  array
	 * @since   5.0.2
	 */
	public function get(array $values): ?array
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		$query->from(
			$this->db->quoteName(
				'#__componentbuilder_language_translation', 'a'
			)
		);

		if (ArrayHelper::check($values))
		{
			$query->select(
				$this->db->quoteName(
					array('a.id', 'a.translation', 'a.source', 'a.components',
						'a.modules', 'a.plugins', 'a.published')
				)
			);

			$query->where(
				$this->db->quoteName('a.source') . ' IN (' . implode(
					',', array_map(
						fn($a) => $this->db->quote($a), $values
					)
				) . ')'
			);

			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				return $this->db->loadAssocList('source');
			}
		}

		return null;
	}
}

