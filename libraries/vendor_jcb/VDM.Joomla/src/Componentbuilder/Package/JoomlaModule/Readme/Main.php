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

namespace VDM\Joomla\Componentbuilder\Package\JoomlaModule\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Joomla Module Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Joomla Modules repository in Markdown format.
	 *
	 * Joomla Modules created in JCB integrate seamlessly with components and render dynamic content
	 * into module positions across a Joomla site. They support fields, custom code, and custom scripts.
	 *
	 * @param  array  $items  All Module definitions in this repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Main heading
		$readme[] = '# JCB! Joomla Modules';
		$readme[] = '';

		// Description
		$readme[] = '### What Are Joomla Modules?';
		$readme[] = <<<MD
**Joomla Modules** built in JCB are standalone display blocks that integrate directly  
into your component and render content into predefined module positions within Joomla.

Each module is compiled alongside the component it's linked to.  
Modules are commonly used for:

- Listing items or statistics on the frontend
- Admin dashboard panels or notices
- Dynamic UI widgets and structured content rendering

Modules in JCB support:

- Fields (for admin-configurable parameters)
- Custom Code (shared logic or snippets)
- Custom Scripting (PHP logic rendered in module output)
- Component-aware compilation
- Joomla version targeting (3.x / 4.x / 5.x)

They follow the native Joomla module structure and install as part of the component.

---
MD;

		// Functional Overview
		$readme[] = '### Why Are Modules Useful in JCB?';
		$readme[] = <<<MD
Modules offer reusable, positionable functionality across your Joomla site:

- Provide compact dynamic views tied to component data
- Accept field-based parameters to drive module behaviour
- Include embedded PHP or Custom Code logic
- Designed to be lightweight and fast-loading
- Automatically compiled with their linked component

---
MD;

		// Sync/Fork Logic
		$readme[] = '### Versioning and Sharing';
		$readme[] = <<<MD
When you need to update Joomla Modules in any JCB project:

- Select the modules to update
- Click **"Reset"** to pull the latest version from this repository
- Or **Fork** this repository and point your JCB instance to your fork

This ensures maintainability while still allowing full customization.

> JCB Modules are tightly integrated with your components — making it easy to deploy dynamic widgets, status panels, and reusable display logic across your Joomla site.

---
MD;

		// Index
		$readme[] = '### Index of Joomla Modules';
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

