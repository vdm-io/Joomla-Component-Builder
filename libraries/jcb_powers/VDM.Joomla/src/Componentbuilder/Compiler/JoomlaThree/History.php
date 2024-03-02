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

namespace VDM\Joomla\Componentbuilder\Compiler\JoomlaThree;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface;


/**
 * Compiler History
 * 
 * @since 3.2.0
 */
class History implements HistoryInterface
{
	/**
	 * History Item Object
	 *
	 * @var    object|null
	 * @since 3.2.0
	 */
	protected ?object $tmp;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 */
	protected $db;

	/**
	 * Constructor
	 *
	 * @param Config|null      $config      The compiler config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->db = Factory::getDbo();
	}

	/**
	 * Get Item History object
	 *
	 * @param   string  $type  The type of item
	 * @param   int     $id    The item ID
	 *
	 * @return  ?object    The history
	 * @since 3.2.0
	 */
	public function get(string $type, int $id): ?object
	{
		// quick class object to store old history object
		$this->tmp = null;
		// Create a new query object.
		$query = $this->db->getQuery(true);

		$query->select('h.*');
		$query->from('#__ucm_history AS h');
		$query->where(
			$this->db->quoteName('h.ucm_item_id') . ' = ' . (int) $id
		);
		// Join over the content type for the type id
		$query->join(
			'LEFT', '#__content_types AS ct ON ct.type_id = h.ucm_type_id'
		);
		$query->where(
			'ct.type_alias = ' . $this->db->quote(
				'com_componentbuilder.' . $type
			)
		);
		$query->order('h.save_date DESC');
		$this->db->setQuery($query, 0, 1);
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			// new version of this item found
			// so we need to mark it as the last compiled version
			$newActive = $this->db->loadObject();
			// set the new version watch
			$this->set($newActive, 1);
		}
		// Get last compiled verion
		$query = $this->db->getQuery(true);

		$query->select('h.*');
		$query->from('#__ucm_history AS h');
		$query->where(
			$this->db->quoteName('h.ucm_item_id') . ' = ' . (int) $id
		);
		$query->where('h.keep_forever = 1');
		$query->where('h.version_note LIKE ' . $this->db->quote('%component%'));
		// make sure it does not return the active version
		if (isset($newActive) && isset($newActive->version_id))
		{
			$query->where('h.version_id != ' . (int) $newActive->version_id);
		}
		// Join over the content type for the type id
		$query->join(
			'LEFT', '#__content_types AS ct ON ct.type_id = h.ucm_type_id'
		);
		$query->where(
			'ct.type_alias = ' . $this->db->quote(
				'com_componentbuilder.' . $type
			)
		);
		$query->order('h.save_date DESC');
		$this->db->setQuery($query);
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			// the old active version was found
			// so we may need to do an SQL update
			// and unmark the old compiled version
			$oldActives = $this->db->loadObjectList();
			foreach ($oldActives as $oldActive)
			{
				// remove old version watch
				$this->set($oldActive, 0);
			}
		}

		// return the last used history record or null.
		return $this->tmp;
	}

	/**
	 * Set Item History Watch
	 *
	 * @param   Object  $object  The history object
	 * @param   int     $action  The action to take
	 *                           0 = remove watch
	 *                           1 = add watch
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	protected function set(object $object, int $action): bool
	{
		// check the note
		if (JsonHelper::check($object->version_note))
		{
			$version_note = json_decode((string) $object->version_note, true);
		}
		else
		{
			$version_note = array('component' => []);
		}
		// set watch
		switch ($action)
		{
			case 0:
				// remove watch
				if (isset($version_note['component'])
					&& ($key = array_search(
						$this->config->component_id, $version_note['component']
					)) !== false)
				{
					// last version that was used to build/compile
					$this->tmp = json_decode((string) $object->version_data);
					// remove it from this component
					unset($version_note['component'][$key]);
				}
				else
				{
					// since it was not found, no need to update anything
					return true;
				}
				break;
			case 1:
				// add watch
				if (!in_array($this->config->component_id, $version_note['component']))
				{
					$version_note['component'][] = $this->config->component_id;
				}
				else
				{
					// since it is there already, no need to update anything
					return true;
				}
				break;
		}
		// check if we need to still keep this locked
		if (isset($version_note['component'])
			&& ArrayHelper::check($version_note['component']))
		{
			// insure component ids are only added once per item
			$version_note['component'] = array_unique(
				$version_note['component']
			);
			// we may change this, little risky (but since JCB does not have history notes it should be okay for now)
			$object->version_note = json_encode($version_note);
			$object->keep_forever = '1';
		}
		else
		{
			$object->version_note = '';
			$object->keep_forever = '0';
		}

		// run the update
		return $this->db->updateObject('#__ucm_history', $object, 'version_id');
	}

}

