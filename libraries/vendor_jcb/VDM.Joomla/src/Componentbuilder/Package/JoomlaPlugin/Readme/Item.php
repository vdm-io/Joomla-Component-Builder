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

namespace VDM\Joomla\Componentbuilder\Package\JoomlaPlugin\Readme;


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Joomla Plugin Item Readme
 * 
 * @since  5.1.1
 */
final class Item implements ItemInterface
{
	/**
	 * Generate a structured Markdown README for a Joomla Plugin defined in JCB.
	 *
	 * This README includes component metadata such as version, identifiers,
	 * ownership, feature toggles, licensing, and a collapsible template block.
	 *
	 * @param  object  $item  The JCB Joomla Plugin definition.
	 *
	 * @return string  The generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title Section
		$readme[] = '### JCB! Joomla Plugin';

		$name         = $item->name ?? 'error: missing name';
		$systemName   = $item->system_name ?? 'error: missing system name';
		$version      = $item->plugin_version ?? 'error: missing version';

		$readme[] = "# {$systemName} (v{$version})";
		$readme[] = "## {$name}";
		$readme[] = '';

		// Descriptions
		$description = trim((string) ($item->description ?? ''));
		if ($description !== '' && $description !== $systemName)
		{
			$readme[] = $description;
			$readme[] = '';
		}

		// Plugin Settings
		$addHeaders = ((int) ($item->add_head ?? 0) === 1)
			? '![yes](https://img.shields.io/badge/yes-success?style=flat-square)'
			: '![no](https://img.shields.io/badge/no-blue?style=flat-square)';

		$addReadme = ((int) ($item->addreadme ?? 0) === 1)
			? '![yes](https://img.shields.io/badge/yes-success?style=flat-square)'
			: '![no](https://img.shields.io/badge/no-blue?style=flat-square)';

		$readme[] = '### Plugin Settings';
		$readme[] = <<<MD
| Setting                 | Value         |
|-------------------------|---------------|
| Add Custom Class Header | {$addHeaders} |
| Add README              | {$addReadme}  |

MD;

		// Custom Class Header
		if (($item->add_head ?? 0) == 1 && !empty($item->head))
		{
			$readme[] = '## Class Header:';
			$readme[] = '```php';
			$readme[] = rtrim($item->head);
			$readme[] = '```';
			$readme[] = '';
		}

		// Main Class Code
		if (!empty($item->main_class_code))
		{
			$readme[] = '## Properties & Methods:';
			$readme[] = '```php';
			$readme[] = rtrim($item->main_class_code);
			$readme[] = '```';
			$readme[] = '';
		}

		// Readme Block (if defined in plugin)
		if (($item->addreadme ?? 0) == 1 && !empty($item->readme))
		{
			$readme[] = '<details>';
			$readme[] = '<summary>README Template</summary>';
			$readme[] = '';
			$readme[] = '```markdown';
			$readme[] = $this->normalizeMarkdown($item->readme);
			$readme[] = '```';
			$readme[] = '';
			$readme[] = '</details>';
			$readme[] = '';
		}

		// Footer
		$readme[] = '> Extend Joomla\'s behaviour at key events with this customizable Plugin that integrates cleanly into your JCB-built components.';
		$readme[] = '';

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}

	/**
	 * Normalize Markdown by replacing only Markdown syntax markers:
	 * - Inline code markers: ` → [CODE]
	 * - Fenced code block markers: ``` → [CODE BLOCK]
	 *
	 * Code inside or outside those markers is untouched.
	 *
	 * @param  string  $markdown  The original Markdown content.
	 * @return string  The normalized Markdown content.
	 * @since  5.1.1
	 */
	function normalizeMarkdown(string $markdown): string
	{
		// Replace triple backticks first to avoid interfering with single replacements
		$markdown = str_replace('```', '[CODE BLOCK]', $markdown);

		// Replace single backticks (inline code)
		$markdown = str_replace('`', '[CODE]', $markdown);

		return rtrim($markdown);
	}

}

