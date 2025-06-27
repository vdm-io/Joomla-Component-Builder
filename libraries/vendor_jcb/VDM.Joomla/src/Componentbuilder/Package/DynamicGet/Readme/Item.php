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

namespace VDM\Joomla\Componentbuilder\Package\DynamicGet\Readme;


use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Dynamic Get Item Readme
 * 
 * @since  5.1.1
 */
final class Item implements ItemInterface
{
	/**
	 * The table name array
	 *
	 * @var    array
	 * @since 5.1.1
	 */
	protected array $tableNames = [];

	/**
	 * Generate a README for a JCB Dynamic Get configuration.
	 *
	 * Includes data source type, retrieval strategy, selection logic, and optional features.
	 *
	 * @param  object  $item  The dynamic get definition.
	 *
	 * @return string  The generated README.
	 * @since  5.1.1
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title
		$readme[] = '### JCB! Dynamic Get';
		$readme[] = '# ' . ($item->name ?? 'error: missing name');
		$readme[] = '';

		// Main source and gettype logic
		$mainSource      = (int) ($item->main_source ?? 0);
		$getType         = (int) ($item->gettype ?? 0);
		$getCustom       = $item->getcustom ?? 'error: missing custom code function name';
		$mainSourceLabel = $this->getMainSourceLabel($mainSource);
		$getTypeLabel    = $this->getGettypeLabel($getType, $getCustom);

		$readme[] = "## {$mainSourceLabel} | {$getTypeLabel}";
		$readme[] = '';

		// Table + selection logic
		$table     = 'Unknown Table';
		$selection = 'No selection provided';

		if ($mainSource === 3)
		{
			$table     = 'Custom Code';
			$selection = $item->php_custom_get ?? 'error: empty code selection';
		}
		elseif ($mainSource === 2)
		{
			$table     = 'Table: ' . ($item->db_table_main ?? '[error] empty db table');
			$selection = ($item->select_all ?? 0) == 1
				? 'a.*'
				: ($item->db_selection ?? 'error: empty db selection');
		}
		elseif ($mainSource === 1)
		{
			$view_table_main = $this->getMainTableName($item);
			$table     = 'Table: ' . ($view_table_main ?? '[error] empty view table');
			$selection = ($item->select_all ?? 0) == 1
				? 'a.*'
				: ($item->view_selection ?? 'error: empty view selection');
		}

		$readme[] = '### Main Focus';
		$readme[] = "**{$table}**";
		$readme[] = '```';
		$readme[] = $selection;
		$readme[] = '```';
		$readme[] = '';

		// Additional settings
		$settings = [];

		if ((int) ($item->pagination ?? 0) === 1 && $getType === 2)
		{
			$settings[] = '- Has pagination';
		}

		if ($getType === 1 && isset($item->plugin_events) && is_array($item->plugin_events))
		{
			$eventList = implode(', ', $item->plugin_events);
			if ($eventList !== '')
			{
				$settings[] = "- Events: {$eventList}";
			}
		}

		if (!empty($settings))
		{
			$readme[] = '### Settings';
			$readme = array_merge($readme, $settings);
			$readme[] = '';
		}

		// Footer
		$readme[] = '> Retrieve and bind data effortlessly with this reusable Dynamic Get, built for easy integration, customization, and performance within JCB.';
		$readme[] = '';

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}

	/**
	 * Converts an integer main_source value to its corresponding string label.
	 *
	 * @param  int  $value  The integer value of the main_source.
	 *
	 * @return string  The matching label or fallback message if invalid.
	 * @since  5.1.1
	 */
	protected function getMainSourceLabel(int $value): string
	{
		static $map = [
			1 => 'Back-end View',
			2 => 'Joomla Database',
			3 => 'Custom',
		];

		return $map[$value] ?? 'error: empty main source';
	}

	/**
	 * Converts an integer gettype value to its corresponding string label.
	 *
	 * @param  int     $value   The integer value of the gettype.
	 * @param  string  $custom  The custom get type name.
	 *
	 * @return string  The matching label or fallback message if invalid.
	 * @since  5.1.1
	 */
	protected function getGettypeLabel(int $value, string $custom): string
	{
		$map = [
			1 => 'getItem',
			2 => 'getListQuery',
			3 => 'getCustom::' . $custom,
			4 => 'getCustoms::' . $custom,
		];

		return $map[$value] ?? 'error: empty gettype';
	}

	/**
	 * Retrieves the main table name for a given item.
	 *
	 * Resolves the table name directly if `view_table_main_name` is set,
	 * otherwise attempts to derive it via `view_table_main` and cache lookup.
	 *
	 * @param  object  $item  The item containing table metadata.
	 *
	 * @return string|null  The resolved main table name or null if not determinable.
	 * @since  5.1.1
	 */
	protected function getMainTableName(object $item): ?string
	{
		// Use explicitly set table name if available
		if (!empty($item->view_table_main_name))
		{
			return $item->view_table_main_name;
		}

		$tableGuid = $item->view_table_main ?? null;

		if (empty($tableGuid))
		{
			return null;
		}

		// Check if the name is already cached
		if (isset($this->tableNames[$tableGuid]))
		{
			return $this->tableNames[$tableGuid];
		}

		// Resolve the name via helper and cache it
		$resolvedName = GetHelper::var('admin_view', $tableGuid, 'guid', 'name_single') ?? $tableGuid;

		if ($resolvedName !== $tableGuid)
		{
			$resolvedName = ClassfunctionHelper::safe($resolvedName);
		}

		return $this->tableNames[$tableGuid] = $resolvedName;
	}
}

