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

namespace VDM\Joomla\Componentbuilder\Package\SiteView\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Site View Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Site Views repository in Markdown format.
	 *
	 * Site Views define the frontend (public-facing) render layer of your component.
	 * This method generates a Markdown README that describes the structure, function,
	 * and usage of Site Views within JCB-based development.
	 *
	 * @param  array  $items  All Site View entries stored in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Main header
		$readme[] = '# JCB! Site Views';
		$readme[] = '';

		// Overview
		$readme[] = '### What Are Site Views?';
		$readme[] = <<<MD
**Site Views** are the public-facing view of your Joomla component — 
offering full control over how data is presented to users on the frontend of your website.

Built with the same powerful toolset as Custom Admin Views, Site Views let you design:
- Custom list views for data records
- Single-item detail pages
- Frontend editors, galleries, dashboards
- AJAX loaders, tabs, and filters
...anything your user interface demands.

Each Site View is composed using:
- One or more **Dynamic Gets** (for safe, powerful data access)
- Integrated **Templates** and **Layouts** (to organize the UI)
- Optional **Custom Code** blocks (to inject reusable frontend logic)
- Optional **JavaScript/CSS Libraries** (to enhance interactivity or styling)

You decide how data is loaded, styled, filtered, and displayed — 
JCB simply generates the Joomla-native view, model, and controller code automatically.

---
MD;

		// Structure & Composition
		$readme[] = '### How Are Site Views Built?';
		$readme[] = <<<MD
You start by creating a Site View and selecting a **Main Dynamic Get**,  
which defines what data will be loaded.

You can then attach:
- **Custom Templates** to control view logic
- **Layouts** for modular rendering
- **Custom Code placeholders** for reusable logic blocks
- **Libraries** for loading external or internal JS/CSS assets

Every part is modular, reusable, and version-controlled via JCB repositories.

And when your project evolves, JCB makes it simple to:
- Reset to default Site View definitions
- Extend or override templates/layouts
- Push updates to shared repositories
- Fork for long-term customization

---
MD;

		// Reset / Fork / Workflow
		$readme[] = '### Version Control and Updates';
		$readme[] = <<<MD
Whenever you need to update Site Views in any JCB project:

- **Select** the relevant Site Views
- Click **"Reset"** to sync them with the latest maintained version
- Or **Fork** this repository and point JCB to your version for full control

This ensures consistent updates while preserving your customizations and logic.

> Site Views are where your component meets your users. Use JCB to control that interaction fully — with logic, layout, and style exactly how you define it.

---
MD;

		// Index
		$readme[] = '### Index of Site Views';
		$readme[] = '';

		// Set the index content
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

