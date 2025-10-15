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

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use Joomla\Database\DatabaseInterface;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Model\Dynamicget;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GuidHelper;


/**
 * Dynamic Get Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * The gui mapper array
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $guiMapper = [
		'table' => 'dynamic_get',
		'id' => null,
		'field' => null,
		'type'  => 'php'
	];

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * The Gui Class.
	 *
	 * @var   Gui
	 * @since 3.2.0
	 */
	protected Gui $gui;

	/**
	 * The Dynamicget Class.
	 *
	 * @var   Dynamicget
	 * @since 3.2.0
	 */
	protected Dynamicget $dynamic;

	/**
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 **/
	protected DatabaseInterface $db;

	/**
	 * Constructor.
	 *
	 * @param Config              $config       The Config Class.
	 * @param Registry            $registry     The Registry Class.
	 * @param Event               $event        The EventInterface Class.
	 * @param Customcode          $customcode   The Customcode Class.
	 * @param Dispenser           $dispenser    The Dispenser Class.
	 * @param Gui                 $gui          The Gui Class.
	 * @param Dynamicget          $dynamicget   The Dynamicget Class.
	 * @param DatabaseInterface   $db           The Joomla Database Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Registry $registry, Event $event,
		Customcode $customcode, Dispenser $dispenser, Gui $gui,
		Dynamicget $dynamicget, DatabaseInterface $db)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->event = $event;
		$this->customcode = $customcode;
		$this->dispenser = $dispenser;
		$this->gui = $gui;
		$this->dynamic = $dynamicget;
		$this->db = $db;
	}

	/**
	 * Get Dynamic Get Data
	 *
	 * @param   array   $ids        The ids/guids of the dynamic get
	 * @param   string  $view_code  The view code name
	 * @param   string  $context    The context for events
	 *
	 * @return  array|null    array of object/s on success
	 * @since 3.2.0
	 */
	public function get(array $keys, string $view_code, string $context): ?array
	{
		if ($keys === [])
		{
			return null;
		}

		$types = $this->getKeyTypes($keys);

		if ($types === [])
		{
			return null;
		}

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_dynamic_get AS a');

		if (isset($types['id']))
		{
			$query->where('a.id IN (' . $types['id'] . ')');
		}

		if (isset($types['guid']))
		{
			$query->where('a.guid IN (' . $types['guid'] . ')');
		}

		$this->db->setQuery($query);
		$this->db->execute();

		if ($this->db->getNumRows())
		{
			$results = $this->db->loadObjectList();

			foreach ($results as $_nr => &$result)
			{
				// Trigger Event: jcb_ce_onBeforeModelDynamicGetData
				$this->event->trigger(
					'jcb_ce_onBeforeModelDynamicGetData', [&$result, &$result->id, &$view_code, &$context]
				);

				// set GUI mapper id
				$this->guiMapper['id'] = (int) $result->id;

				// add calculations if set
				if ($result->addcalculation == 1
					&& StringHelper::check(
						$result->php_calculation
					))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'php_calculation';
					$result->php_calculation = $this->gui->set(
						$this->customcode->update(
							base64_decode((string) $result->php_calculation)
						),
						$this->guiMapper
					);
				}

				// setup the router parse
				if (isset($result->add_php_router_parse)
					&& $result->add_php_router_parse == 1
					&& isset($result->php_router_parse)
					&& StringHelper::check(
						$result->php_router_parse
					))
				{
					// set GUI mapper field
					$this->guiMapper['field'] = 'php_router_parse';
					$result->php_router_parse = $this->gui->set(
						$this->customcode->update(
							base64_decode((string) $result->php_router_parse)
						),
						$this->guiMapper
					);
				}
				else
				{
					$result->add_php_router_parse = 0;
				}

				// The array of the php scripts that should be added to the script builder
				$phpSripts = [
					'php_before_getitem',
					'php_after_getitem',
					'php_before_getitems',
					'php_after_getitems',
					'php_getlistquery'
				];

				// load the php scripts
				foreach ($phpSripts as $script)
				{
					// add php script to the script builder
					if (isset($result->{'add_' . $script})
						&& $result->{'add_' . $script} == 1
						&& isset($result->{$script})
						&& StringHelper::check(
							$result->{$script}
						))
					{
						// move all main gets out to the custom script builder
						if ($result->gettype <= 2)
						{
							// set GUI mapper field
							$this->guiMapper['field']  = $script;
							$this->guiMapper['prefix'] = PHP_EOL . PHP_EOL;
							$this->dispenser->set(
								$result->{$script},
								$this->config->build_target . '_' . $script,
								$view_code,
								null,
								$this->guiMapper,
								true,
								true,
								true
							);
							unset($this->guiMapper['prefix']);
							// remove from local item
							unset($result->{$script});
							unset($result->{'add_' . $script});
						}
						else
						{
							// set GUI mapper field
							$this->guiMapper['field']  = $script;
							$this->guiMapper['prefix'] = PHP_EOL;
							// only for custom gets
							$result->{$script} = $this->gui->set(
								$this->customcode->update(
									base64_decode((string) $result->{$script})
								),
								$this->guiMapper
							);
							unset($this->guiMapper['prefix']);
						}
					}
					else
					{
						// remove from local item
						unset($result->{$script});
						unset($result->{'add_' . $script});
					}
				}

				// set the getmethod code name
				$result->key = StringHelper::safe(
					$view_code . ' ' . $result->name . ' ' . $result->id
				);

				// set the dynamic get
				$this->dynamic->set($result, $view_code, $context);

				// load the events if any is set
				if ($result->gettype == 1
					&& JsonHelper::check(
						$result->plugin_events
					))
				{
					$result->plugin_events = json_decode(
						(string) $result->plugin_events, true
					);
				}
				else
				{
					$result->plugin_events = '';
				}

				// Trigger Event: jcb_ce_onAfterModelDynamicGetData
				$this->event->trigger(
					'jcb_ce_onAfterModelDynamicGetData', [&$result, &$result->id, &$view_code, &$context]
				);
			}

			return $results;
		}
		return null;
	}

	/**
	 * Get the key types
	 *
	 * @param   array   $keys The ids/guids of the dynamic get
	 *
	 * @return  array   array of the keys in the correct key type grouping
	 * @since   5.0.4
	 */
	private function getKeyTypes(array $keys): array
	{
		$guids = [];
		$ids = [];
		foreach ($keys as $key)
		{
			if (GuidHelper::valid($key))
			{
				$guids[] = $key;
			}
			elseif (is_numeric($key))
			{
				$ids[] = (int) $key;
			}
		}

		$types = [];

		if ($guids !== [])
		{
			$types['guid'] = '"' . implode('","', $guids) . '"';
		}

		if ($ids !== [])
		{
			$types['id'] = implode(',', $ids);
		}

		return $types;
	}
}

