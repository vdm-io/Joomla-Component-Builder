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

namespace VDM\Joomla\Componentbuilder\Snippet\Readme;


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Snippet Item Readme
 * 
 * @since  5.1.1
 */
final class Item implements ItemInterface
{
	/**
	 * Generate a README for a JCB Snippet in Markdown format.
	 *
	 * Includes the snippet name, optional heading/description, the code, usage, and contributor info.
	 *
	 * @param  object  $item  The snippet item.
	 *
	 * @return string  The generated README.
	 * @since  5.1.1
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title
		$readme[] = '### JCB! Snippet';
		$name = $item->name ?? 'error: missing snippet name';

		if (!empty($item->url))
		{
			$readme[] = "# [{$name}]({$item->url})";
		}
		else
		{
			$readme[] = "# {$name}";
		}
		$readme[] = '';

		// Heading
		if (!empty($item->heading))
		{
			$readme[] = "## {$item->heading}";
			$readme[] = '';
		}

		// Description
		if (!empty($item->description))
		{
			$readme[] = trim($item->description);
			$readme[] = '';
		}

		// Snippet block
		if (!empty($item->snippet))
		{
			$readme[] = '### Snippet';
			$readme[] = '```';
			$readme[] = rtrim($item->snippet);
			$readme[] = '```';
			$readme[] = '';
		}

		// Usage block
		if (!empty($item->usage))
		{
			$readme[] = '### Usage';
			$readme[] = '> ' . trim($item->usage);
			$readme[] = '';
		}

		// Contributor info (non-anonymous)
		$company = strtolower($item->contributor_company ?? '');
		if (!in_array($company, ['anon', 'anonymous'], true))
		{
			$readme[] = '### Contributor';
			$readme[] = "- " . $item->contributor_company;

			$name = $item->contributor_name ?? '';
			if (
				!empty($name) &&
				!in_array(strtolower($name), ['anon', 'anonymous']) &&
				strtolower($name) !== 'llewellyn van der merwe'
			) {
				$readme[] = "- {$name}";
			}

			if (!empty($item->contributor_email)) {
				$readme[] = "- [email](mailto:" . $item->contributor_email . ")";
			}

			if (!empty($item->contributor_website)) {
				$readme[] = "- [website](" . $item->contributor_website . ")";
			}

			$readme[] = '';
		}

		// Footer
		$readme[] = '> Streamline your Joomla development with a single, reusable snippet designed for flexibility, consistency, and easy updates.';
		$readme[] = '';

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}
}

