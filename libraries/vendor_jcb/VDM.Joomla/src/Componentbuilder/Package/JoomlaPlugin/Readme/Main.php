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


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Joomla Plugin Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Joomla Plugins repository in Markdown format.
	 *
	 * Joomla Plugins provide event-driven execution of logic within the Joomla framework.
	 * They are built and compiled via the parent component and integrated into the
	 * Joomla plugin architecture seamlessly.
	 *
	 * @param  array  $items  All Plugin definitions in this repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Main heading
		$readme[] = '# JCB! Joomla Plugins';
		$readme[] = '';

		// Description
		$readme[] = '### What Are Joomla Plugins?';
		$readme[] = <<<MD
**Joomla Plugins** created in JCB are event-driven extensions that allow you to inject  
custom logic at key points in the Joomla application lifecycle.

These plugins are automatically built when linked to a component and compiled.  
They support both backend and CLI contexts, and are ideal for scenarios like:

- Command-line (CLI) tasks
- Scheduled cron operations
- Authentication filters
- Data transformation or validations
- System-level integrations

Each plugin can contain raw PHP, helper classes, and plugin XML configuration.  
Fields may also be used to generate configurable plugin parameters.

---
MD;

		// Functional Overview
		$readme[] = '### Why Are Joomla Plugins Useful in JCB?';
		$readme[] = <<<MD
Joomla Plugins extend the runtime behavior of your component:

- Hook into Joomla's native event system
- Perform background logic or validations
- Execute scheduled tasks via CLI
- Access Joomla core APIs without modifying core files

Plugins are automatically compiled in the with component its linked to,  
ensuring that any custom logic tied to system events is deployed alongside your component.

They are excellent tools for modular logic injection, background automation, and clean separation of concerns.

---
MD;

		// Sync/Fork Logic
		$readme[] = '### Versioning and Sharing';
		$readme[] = <<<MD
When you need to update Joomla Plugins in any JCB project:

- Select the plugin(s) you wish to refresh
- Click **"Reset"** to pull the latest version from this repository
- Or **Fork** this repository and point your JCB instance to your fork

This ensures your plugins are version-controlled and up-to-date,  
while still allowing full customization per project.

> Plugins are an essential part of a robust Joomla architecture — offering silent, background-driven functionality with full JCB integration.

---
MD;

		// Index
		$readme[] = '### Index of Joomla Plugins';
		$readme[] = '';

		// Add the dynamic index
		$readme[] = $this->getIndex($items);
		$readme[] = '';

		$readme[] = <<<MD
### All used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}
}

