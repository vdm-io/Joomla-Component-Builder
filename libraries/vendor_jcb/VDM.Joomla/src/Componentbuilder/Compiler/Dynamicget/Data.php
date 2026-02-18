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
use Joomla\Database\DatabaseQuery;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Model\Dynamicget;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Package\Builder\Get as Superpower;
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
	 * The gui mapper array.
	 *
	 * @var    array<string, mixed>
	 * @since  3.2.0
	 */
	protected array $guiMapper = [
		'table' => 'dynamic_get',
		'id' => null,
		'field' => null,
		'type'  => 'php',
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
	 * The Event Class.
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
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 5.1.4
	 */
	protected Counter $counter;

	/**
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 **/
	protected DatabaseInterface $db;

	/**
	 * The Super Class.
	 *
	 * @var   Superpower
	 * @since 5.1.4
	 */
	protected Superpower $superpower;

	/**
	 * DynamicGet cache.
	 *
	 * @var    array<int, object>
	 * @since  5.1.4
	 */
	protected array $data = [];

	/**
	 * Index map of key => id.
	 * Stores both numeric IDs and GUIDs pointing to the resolved integer ID.
	 *
	 * @var    array<string|int, int>
	 * @since  5.1.4
	 */
	protected array $index = [];

	/**
	 * Bucket of GUID values.
	 *
	 * @var    array<string, string>
	 * @since  5.1.4
	 */
	protected array $bucket = [];

	/**
	 * The unique counter array.
	 *
	 * @var   array<int, bool>
	 * @since 5.1.4
	 */
	protected array $uniqueCounter = [];

	/**
	 * The state of retry to loaded dynamic gets.
	 *
	 * @var    array<string, bool>
	 * @since  5.1.4
	 **/
	protected array $retry = [];

	/**
	 * Constructor.
	 *
	 * @param Config             $config      The Config Class.
	 * @param Registry           $registry    The Registry Class.
	 * @param Event              $event       The Event Class.
	 * @param Customcode         $customcode  The Customcode Class.
	 * @param Dispenser          $dispenser   The Dispenser Class.
	 * @param Gui                $gui         The Gui Class.
	 * @param Dynamicget         $dynamicget  The Dynamicget Class.
	 * @param Counter            $counter     The Counter Class.
	 * @param DatabaseInterface  $db          The Joomla Database Class.
	 * @param Superpower         $superpower  A Superpower Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(
		Config $config,
		Registry $registry,
		Event $event,
		Customcode $customcode,
		Dispenser $dispenser,
		Gui $gui,
		Dynamicget $dynamicget,
		Counter $counter,
		DatabaseInterface $db,
		Superpower $superpower
	) {
		$this->config = $config;
		$this->registry = $registry;
		$this->event = $event;
		$this->customcode = $customcode;
		$this->dispenser = $dispenser;
		$this->gui = $gui;
		$this->dynamic = $dynamicget;
		$this->counter = $counter;
		$this->db = $db;
		$this->superpower = $superpower;
	}

	/**
	 * Get Dynamic Get Data.
	 *
	 * @param   array<int|string>  $keys      The ids/guids of the dynamic get.
	 * @param   string             $view      The view code name.
	 * @param   string             $context   The context for events.
	 *
	 * @return  array|null  Array of object/s on success.
	 * @since   3.2.0
	 */
	public function get(array $keys, string $view, string $context): ?array
	{
		if ($keys === [])
		{
			return null;
		}

		$missing = $this->getMissing($keys);

		// Nothing missing, return all data.
		if ($missing['ids'] === [] && $missing['guids'] === [])
		{
			return $this->getData($keys, $view, $context);
		}

		$this->set($missing['ids'], $missing['guids']);

		$missing = $this->getMissing($keys);

		if (($missing['ids'] !== [] || $missing['guids'] !== []) && $this->attemptRemoteFetch())
		{
			$this->set($missing['ids'], $missing['guids']);
		}

		return $this->getData($keys, $view, $context);
	}

	/**
	 * Set Dynamic Get Data.
	 *
	 * @param   array<int>     $ids    The IDs to load.
	 * @param   array<string>  $guids  The GUIDs to load.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	private function set(array $ids, array $guids): void
	{
		if ($ids === [] && $guids === [])
		{
			return;
		}

		$query = $this->getQuery($ids, $guids);

		$this->db->setQuery($query);
		$this->db->execute();

		if (!$this->db->getNumRows())
		{
			return;
		}

		$results = $this->db->loadObjectList();

		foreach ($results as $row)
		{
			$id = (int) $row->id;
			$guid = $row->guid ?? null;

			if (empty($this->uniqueCounter[$id]))
			{
				$this->counter->dynamicGet++;
				$this->uniqueCounter[$id] = true;
			}

			$this->data[$id] = $row;
			$this->index[$id] = $id;
			if ($guid !== null)
			{
				$this->index[$guid] = $id;
			}
		}
	}

	/**
	 * Get current dynamic get data query.
	 *
	 * @param   array<int>     $ids    The IDs to load.
	 * @param   array<string>  $guids  The GUIDs to load.
	 *
	 * @return  DatabaseQuery  The dynamic get data query.
	 * @since   5.1.4
	 */
	private function getQuery(array $ids, array $guids): DatabaseQuery
	{
		$query = $this->db->getQuery(true);

		$query->select('a.*');
		$query->from($this->db->quoteName('#__componentbuilder_dynamic_get', 'a'));

		if ($ids !== [])
		{
			$ids = array_values(array_unique(array_map('intval', $ids)));
			$query->where($this->db->quoteName('a.id') . ' IN (' . implode(',', $ids) . ')');
		}

		if ($guids !== [])
		{
			$guids = array_values(array_unique(array_filter($guids, static fn($v) => is_string($v) && $v !== '')));
			$quoted = array_map([$this->db, 'quote'], $guids);
			$query->where($this->db->quoteName('a.guid') . ' IN (' . implode(',', $quoted) . ')');
		}

		return $query;
	}

	/**
	 * Get dynamic get data.
	 *
	 * @param   array<int|string>  $keys     The ids/guids of the dynamic get.
	 * @param   string             $view     The view code name.
	 * @param   string             $context  The context for events.
	 *
	 * @return  array|null  Array of object/s on success.
	 * @since   5.0.4
	 */
	private function getData(array $keys, string $view, string $context): ?array
	{
		$data = [];

		foreach ($keys as $key)
		{
			$id = $this->index[$key] ?? null;

			if ($id !== null && !isset($data[$id]) && isset($this->data[$id]))
			{
				$data[$id] = clone $this->data[$id];
			}
		}

		if ($data === [])
		{
			return null;
		}

		return $this->model(array_values($data), $view, $context);
	}

	/**
	 * Get dynamic get modeled data.
	 *
	 * @param   array<int, object>  $data     The dynamic get data set.
	 * @param   string              $view     The view code name.
	 * @param   string              $context  The context for events.
	 *
	 * @return  array|null  Array of object/s on success.
	 * @since   5.1.4
	 */
	private function model(array $data, string $view, string $context): ?array
	{
		foreach ($data as &$result)
		{
			$this->triggerBeforeModel($result, $view, $context);

			// Prepare a local mapper instance to avoid leaking state between items.
			$guiMapper = $this->guiMapper;
			$guiMapper['id'] = (int) $result->id;

			$this->applyCalculations($result, $guiMapper);
			$this->applyRouterParsing($result, $guiMapper);
			$this->processPhpScripts($result, $view, $guiMapper);
			$this->finalizeDynamic($result, $view, $context);

			$this->triggerAfterModel($result, $view, $context);
		}

		return $data;
	}

	/**
	 * Apply calculation code if enabled.
	 *
	 * @param   object              $result    The result row.
	 * @param   array<string, mixed> $guiMapper  The GUI mapper state for this row.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	private function applyCalculations(object &$result, array $guiMapper): void
	{
		if ((int) ($result->addcalculation ?? 0) === 1 && StringHelper::check($result->php_calculation ?? ''))
		{
			$guiMapper['field'] = 'php_calculation';

			$result->php_calculation = $this->gui->set(
				$this->customcode->update(
					base64_decode((string) $result->php_calculation)
				),
				$guiMapper
			);
		}
	}

	/**
	 * Apply router parsing code if enabled.
	 *
	 * @param   object              $result     The result row.
	 * @param   array<string, mixed> $guiMapper   The GUI mapper state for this row.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	private function applyRouterParsing(object &$result, array $guiMapper): void
	{
		if (
			isset($result->add_php_router_parse)
			&& (int) $result->add_php_router_parse === 1
			&& isset($result->php_router_parse)
			&& StringHelper::check($result->php_router_parse)
		) {
			$guiMapper['field'] = 'php_router_parse';

			$result->php_router_parse = $this->gui->set(
				$this->customcode->update(
					base64_decode((string) $result->php_router_parse)
				),
				$guiMapper
			);

			return;
		}

		$result->add_php_router_parse = 0;
	}

	/**
	 * Process the PHP scripts for the script builder.
	 *
	 * @param   object               $result     The result row.
	 * @param   string               $view       The view code name.
	 * @param   array<string, mixed> $guiMapper  The GUI mapper state for this row.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	private function processPhpScripts(object &$result, string $view, array $guiMapper): void
	{
		$phpScripts = [
			'php_before_getitem',
			'php_after_getitem',
			'php_before_getitems',
			'php_after_getitems',
			'php_getlistquery',
		];

		foreach ($phpScripts as $script)
		{
			$addKey = 'add_' . $script;

			if (
				isset($result->{$addKey})
				&& (int) $result->{$addKey} === 1
				&& isset($result->{$script})
				&& StringHelper::check($result->{$script})
			) {
				// Move all main gets out to the custom script builder.
				if ((int) ($result->gettype ?? 0) <= 2)
				{
					$guiMapper['field']  = $script;
					$guiMapper['prefix'] = PHP_EOL . PHP_EOL;

					$this->dispenser->set(
						$result->{$script},
						$this->config->build_target . '_' . $script,
						$view,
						null,
						$guiMapper,
						true,
						true,
						true
					);

					unset($guiMapper['prefix']);
					unset($result->{$script}, $result->{$addKey});
				}
				else
				{
					$guiMapper['field']  = $script;
					$guiMapper['prefix'] = PHP_EOL;

					$result->{$script} = $this->gui->set(
						$this->customcode->update(
							base64_decode((string) $result->{$script})
						),
						$guiMapper
					);

					unset($guiMapper['prefix']);
				}

				continue;
			}

			// Remove from local item when not applicable.
			unset($result->{$script}, $result->{$addKey});
		}
	}

	/**
	 * Finalize a dynamic get row (key, registration, plugin events).
	 *
	 * @param   object  $result   The result row.
	 * @param   string  $view     The view code name.
	 * @param   string  $context  The context for events.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	private function finalizeDynamic(object &$result, string $view, string $context): void
	{
		$result->key = StringHelper::safe(
			$view . ' ' . ($result->name ?? 'error') . ' ' . (string) ($result->id ?? 'more_serious_error')
		);

		$this->dynamic->set($result, $view, $context);

		if ((int) ($result->gettype ?? 0) === 1 && JsonHelper::check($result->plugin_events ?? ''))
		{
			$result->plugin_events = json_decode((string) $result->plugin_events, true);
		}
		else
		{
			$result->plugin_events = '';
		}
	}

	/**
	 * Trigger Event: jcb_ce_onBeforeModelDynamicGetData.
	 * Defensive: plugin failures must not break compilation.
	 *
	 * @param   object  $result  The result row.
	 * @param   string  $view    The view code name.
	 * @param   string  $context The context for events.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	private function triggerBeforeModel(object &$result, string &$view, string &$context): void
	{
		try
		{
			$this->event->trigger(
				'jcb_ce_onBeforeModelDynamicGetData',
				[&$result, &$result->id, &$view, &$context]
			);
		}
		catch (\Throwable $e)
		{
			// Intentionally swallow to keep compilation stable.
		}
	}

	/**
	 * Trigger Event: jcb_ce_onAfterModelDynamicGetData.
	 * Defensive: plugin failures must not break compilation.
	 *
	 * @param   object  $result   The result row.
	 * @param   string  $view     The view code name.
	 * @param   string  $context  The context for events.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	private function triggerAfterModel(object &$result, string &$view, string &$context): void
	{
		try
		{
			$this->event->trigger(
				'jcb_ce_onAfterModelDynamicGetData',
				[&$result, &$result->id, &$view, &$context]
			);
		}
		catch (\Throwable $e)
		{
			// Intentionally swallow to keep compilation stable.
		}
	}

	/**
	 * Attempt a one-time remote fetch via Superpower.
	 *
	 * @return  bool
	 * @since   5.1.4
	 */
	private function attemptRemoteFetch(): bool
	{
		$guids = [];

		foreach ($this->bucket as $guid)
		{
			if (!empty($this->retry[$guid]) || !empty($this->index[$guid]))
			{
				continue;
			}

			$this->retry[$guid] = true;
			$guids[$guid] = $guid;
		}

		// Always clear the bucket after deciding.
		$this->bucket = [];

		if ($guids !== [])
		{
			$this->superpower->get('dynamic_get', array_values($guids));
			return true;
		}

		return false;
	}

	/**
	 * Get the keys that are not in cache.
	 *
	 * @param   array<int|string>  $keys  The ids/guids of the dynamic get.
	 *
	 * @return  array{ids: array<int>, guids: array<string>}  Missing keys grouped by type.
	 * @since   5.1.4
	 */
	private function getMissing(array $keys): array
	{
		$guids = [];
		$ids = [];

		$this->bucket = [];

		foreach ($keys as $key)
		{
			if (isset($this->index[$key]))
			{
				continue;
			}

			if (is_string($key) && GuidHelper::valid($key))
			{
				// Track those that must be loaded remotely if not found locally.
				$this->bucket[$key] = $key;
				$guids[$key] = $key;
			}
			elseif (is_numeric($key))
			{
				$ids[(int) $key] = (int) $key;
			}
		}

		return [
			'ids' => ($ids !== []) ? array_values($ids) : [],
			'guids' => ($guids !== []) ? array_values($guids) : [],
		];
	}
}

