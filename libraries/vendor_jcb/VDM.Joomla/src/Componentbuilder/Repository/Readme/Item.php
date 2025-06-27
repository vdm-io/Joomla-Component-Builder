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

namespace VDM\Joomla\Componentbuilder\Repository\Readme;


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Repository Item Readme
 * 
 * @since  5.1.1
 */
final class Item implements ItemInterface
{
	/**
	 * @const array<int, string> Maps target values to labels.
	 * @since  5.1.1
	 */
	private const TARGET_LABELS = [
		1 => 'Super Power',
		2 => 'Joomla Power',
		3 => 'Field Types',
		4 => 'Packages',
		5 => 'Snippets',
		6 => 'Repositories',
	];

	/**
	 * @const array<int, string> Maps access repo values to labels.
	 * @since  5.1.1
	 */
	private const ACCESS_LABELS = [
		0 => 'Global',
		1 => 'Override',
	];

	/**
	 * Generate a structured Markdown README for a JCB Repository.
	 *
	 * This README displays the repository connection metadata, access level,
	 * and Git configuration in a two-column layout similar to plugin README formatting.
	 *
	 * @param  object  $item  The JCB Repository definition.
	 *
	 * @return string  The generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title
		$readme[] = '### JCB! Repository';
		$name = $item->system_name ?? 'error: missing repository name';

		if (!empty($item->base))
		{
			$readme[] = "# [{$name}]({$this->getUrl($item)})";
		}
		else
		{
			$readme[] = "# {$name}";
		}
		$readme[] = '';

		// Access & Target Settings
		$readme[] = "- **Target:** {$this->getTargetLabel($item->target)}";
		$readme[] = "- **Access:** {$this->getAccessLabel($item->access_repo)}";
		$readme[] = '';

		// Prepare Git Metadata
		$readme[] = $this->getDetailsTable($item);

		$readme[] = '';

		// Footer Quote
		$readme[] = '> Defines the Git repository and credentials used by JCB to synchronize content during push, init, and reset operations.';
		$readme[] = '';

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}

	/**
	 * Converts an integer target value to its corresponding string label.
	 *
	 * @param  int     $value     The integer value of the target.
	 * @param  string  $fallback  The fallback label if invalid.
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function getTargetLabel(int $value, string $fallback = 'error: empty target'): string
	{
		return self::TARGET_LABELS[$value] ?? $fallback;
	}

	/**
	 * Converts an integer access_repo value to its corresponding string label.
	 *
	 * @param  int     $value     The integer value of the access_repo.
	 * @param  string  $fallback  The fallback label if invalid.
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function getAccessLabel(int $value, string $fallback = 'error: empty access repo'): string
	{
		return self::ACCESS_LABELS[$value] ?? $fallback;
	}

	/**
	 * Get the repository target URL.
	 *
	 * @param  object  $item  The JCB Repository definition.
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function getUrl(object $item): string
	{
		return sprintf(
			'%s/%s/%s',
			$this->getValue($item, 'base', '[base]'),
			$this->getValue($item, 'organisation', '[org]'),
			$this->getValue($item, 'repository', '[repo]')
		);
	}

	/**
	 * Get the repository details in Markdown table format.
	 *
	 * @param  object  $item  The JCB Repository definition.
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function getDetailsTable(object $item): string
	{
		$details = [
			'Base Url'     => $this->getValue($item, 'base', '[base]'),
			'Organisation' => $this->getValue($item, 'organisation', '[org]'),
			'Repository'   => $this->getValue($item, 'repository', '[repo]'),
			'Username'     => $item->username ?? '[empty username]',
			'Author Name'  => $item->author_name ?? '[empty author name]',
			'Author Email' => $item->author_email ?? '[empty author email]',
			'Read Branch'  => $item->read_branch ?? '[empty read branch]',
			'Write Branch' => $item->write_branch ?? '[empty write branch]',
		];

		$rows = array_map(
			fn($key, $value) => "| {$key} | {$value} |",
			array_keys($details),
			$details
		);

		return "## Repository Details\n\n| Setting | Value |\n|---------|--------|\n" . implode("\n", $rows);
	}

	/**
	 * Retrieve and sanitize a string property from an object.
	 *
	 * @param  object  $item      The source object.
	 * @param  string  $prop      Property name.
	 * @param  string  $fallback  Value to use if not found.
	 *
	 * @return string
	 * @since  5.1.1
	 */
	private function getValue(object $item, string $prop, string $fallback = ''): string
	{
		return trim((string)($item->{$prop} ?? $fallback), '/');
	}
}

