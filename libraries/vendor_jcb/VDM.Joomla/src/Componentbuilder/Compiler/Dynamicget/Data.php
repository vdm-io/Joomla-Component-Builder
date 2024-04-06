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


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Model\Dynamicget;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


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
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Event
	 *
	 * @var    EventInterface
	 * @since 3.2.0
	 */
	protected EventInterface $event;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Dynamicget Model
	 *
	 * @var    Dynamicget
	 * @since 3.2.0
	 */
	protected Dynamicget $dynamic;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config          The compiler config object.
	 * @param Registry|null             $registry        The compiler registry object.
	 * @param EventInterface|null       $event           The compiler event api object.
	 * @param Customcode|null           $customcode      The compiler customcode object.
	 * @param Dispenser|null            $dispenser       The compiler customcode dispenser object.
	 * @param Gui|null                  $gui             The compiler customcode gui.
	 * @param Dynamicget|null           $dynamic         The compiler dynamicget modeller object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?EventInterface $event = null, ?Customcode $customcode = null,
		?Dispenser $dispenser = null, ?Gui $gui = null,
		?Dynamicget $dynamic = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->event = $event ?: Compiler::_('Event');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->dynamic = $dynamic ?: Compiler::_('Model.Dynamicget');
		$this->db = Factory::getDbo();
	}

	/**
	 * Get Dynamic Get Data
	 *
	 * @param   array   $ids        The ids of the dynamic get
	 * @param   string  $view_code  The view code name
	 * @param   string  $context    The context for events
	 *
	 * @return  array|null    array of object/s on success
	 * @since 3.2.0
	 */
	public function get(array $ids, string $view_code, string $context): ?array
	{
		if ($ids === [])
		{
			return null;
		}

		$ids = implode(',', $ids);

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_dynamic_get AS a');
		$query->where('a.id IN (' . $ids . ')');
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

}

