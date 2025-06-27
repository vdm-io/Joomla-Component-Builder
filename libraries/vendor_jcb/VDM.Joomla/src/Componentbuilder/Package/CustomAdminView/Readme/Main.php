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

namespace VDM\Joomla\Componentbuilder\Package\CustomAdminView\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Custom Admin View Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Custom Admin Views repository in Markdown format.
	 *
	 * Custom Admin Views represent fully customizable back-end interfaces within Joomla components.
	 * This method generates a Markdown README that explains their purpose, structure, and role in JCB.
	 *
	 * @param  array  $items  All Custom Admin View entries stored in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Custom Admin Views';
		$readme[] = '';

		// Overview
		$readme[] = '### What Are Custom Admin Views?';
		$readme[] = <<<MD
**Custom Admin Views** give you complete freedom to define bespoke administrative interfaces  
within your Joomla components — without being limited to Joomla's default view generators.

They are the **admin-side counterpart to Site Views**, built using:
- **Templates** and **Layouts** (for structural rendering)
- **Dynamic Gets** (for advanced data querying)
- **Custom Code** (for reusable backend logic or overrides)
- Optional **JavaScript and CSS Libraries**

Custom Admin Views let you create:
- Data dashboards
- Import/export areas
- Report generators
- One-off administrative tools
- Multi-tab editing views
...all from inside JCB.

This turns Joomla's back-end into a **powerful canvas** for any interface you envision —  
fully powered by the same JCB architecture used throughout the frontend.

---
MD;

		// Editing and structure
		$readme[] = '### How Are Custom Admin Views Composed?';
		$readme[] = <<<MD
Each Custom Admin View can be:
- An **Item View** (display a single entity)
- A **List View** (show multiple items with pagination)
- A **Hybrid or Utility View** (batch editing, uploading, dashboards, etc.)

These views are built through:
- One or more **Dynamic Gets** to fetch related data across tables
- Optional integration of **Forms**, **Filters**, or **Toolbars**
- **Templates and Layouts** for structuring how content is displayed
- **Custom Code Blocks** to inject logic at strategic compile points

This gives you complete control over both data and design.

---
MD;

		// Reset / Fork / Sync
		$readme[] = '### Reset, Fork, or Customize';
		$readme[] = <<<MD
Just like other JCB-powered assets, Custom Admin Views support version-controlled workflows:

- **Init** a Custom Admin View from this repository
- **Reset** to sync with the latest updates
- **Push** your own improved versions
- Or **Fork** the repo to fully customize your private admin interfaces

Every Custom Admin View can evolve with your project's back-end needs,  
and JCB ensures your changes are safely retained through the compile lifecycle.

> Admin interface design should never be an afterthought. With Custom Admin Views, you own the experience — from logic to layout, all inside Joomla Component Builder.

---
MD;

		// Index header
		$readme[] = '### Index of Custom Admin Views';
		$readme[] = '';

		// Generate the index block
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

