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

namespace VDM\Joomla\Componentbuilder\JoomlaPower\Readme;


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Joomla Power Item Readme
 * @since 3.2.0
 */
final class Item implements ItemInterface
{
	/**
	 * Generate a README for a Joomla! Power entity in Markdown format.
	 *
	 * This includes the system name, description, settings table, and usage instructions.
	 *
	 * @param  object  $item  The Joomla! Power item definition.
	 *
	 * @return string  The generated README as Markdown.
	 * @since  3.2.2
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title and system name
		$readme[] = '### Joomla! Power';
		$readme[] = '# ' . ($item->system_name ?? 'error: missing system name');
		$readme[] = '';

		// Description block
		if (!empty($item->description))
		{
			$readme[] = trim($item->description);
			$readme[] = '';
		}

		// Settings table
		if (!empty($item->settings) && (is_array($item->settings) || is_object($item->settings)))
		{
			$readme[] = $this->buildSettingsTable($item->settings);
			$readme[] = '';
		}

		// Usage instructions
		$guid = $item->guid ?? 'error_missing_guid';
		$readme[] = '> This Joomla! Power lets you seamlessly integrate and future-proof Joomla classes in your custom code.';
		$readme[] = '';
		$readme[] = 'To add this specific power to your project in JCB:';
		$readme[] = '';
		$readme[] = 'Simply use this JPK:';
		$readme[] = '```';
		$readme[] = 'Joomla---' . str_replace('-', '_', $guid) . '---Power';
		$readme[] = '```';
		$readme[] = '> Remember to replace the `---` with `___` to activate this Joomla! Power in your code.';
		$readme[] = '';

		// Footer

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}

	/**
	 * Builds a Markdown table with details about each setting.
	 *
	 * The table includes columns: Namespace (inline `use ...;` code style) and Joomla Version (as shield badge).
	 *
	 * @param  array|object  $settings  Associative array or object containing settings.
	 *
	 * @return string  The generated Markdown output.
	 * @since 5.1.1
	 */
	protected function buildSettingsTable(array|object $settings): string
	{
		$settings = (array) $settings;
		$markdown = [];

		// Table header
		$markdown[] = '| Namespace | Joomla Version |';
		$markdown[] = '|-----------|----------------|';

		foreach ($settings as $setting)
		{
			$setting = (array) $setting;

			// Inline namespace string as `use Namespace\Class;`
			$namespace = isset($setting['namespace'])
				? '`use ' . $setting['namespace'] . ';`'
				: '`—`';

			// Map version to badge label
			$versionMap = [
				'0' => ['All', 'purple'],
				'3' => ['Joomla 3', 'blue'],
				'4' => ['Joomla 4', 'green'],
				'5' => ['Joomla 5', 'brightgreen']
			];

			$versionCode = (string) ($setting['joomla_version'] ?? '0');
			[$label, $color] = $versionMap[$versionCode] ?? ['Unknown', 'lightgrey'];

			$versionBadge = "![{$label}](https://img.shields.io/badge/{$label}-{$color}?style=flat-square)";

			$markdown[] = "| {$namespace} | {$versionBadge} |";
		}

		return implode("\n", $markdown);
	}
}

