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

namespace VDM\Joomla\Componentbuilder\Package\Component\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Component Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Joomla Components repository in Markdown format.
	 *
	 * Joomla Components act as the central packaging unit in JCB, compiling everything —
	 * views, code, config, logic, and version control — into a final installable extension.
	 *
	 * @param  array  $items  All Joomla components defined in this repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  3.2.0
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Joomla Components';
		$readme[] = '';

		// Overview
		$readme[] = '### What Are Joomla Components in JCB?';
		$readme[] = <<<MD
In Joomla Component Builder (JCB), a Joomla Component is the top-level unit that brings everything together.

It acts as the central container — compiling all attached entities and logic into a complete, versioned, installable Joomla extension.

A Component includes:

- Admin Views (core data tables with fields and ACLs)
- Site Views (frontend output)
- Custom Admin Views (customized backend interfaces)
- Modules & Plugins (packaged alongside)
- Custom Code (injectable and reusable)
- Files and Folders (media, scripts, assets)
- MySQL Tweaks & Schema Updates
- PHP Helper Classes
- Component Configurations (global parameters)
- Placeholders & Overrides
- Dynamic Dashboards (overview screens)
- Routing Setup (site and admin)
- Version Definitions (Joomla 3, 4, 5 support)
- README, Wikis & Docs (optional, for internal reference)

Every entity you build in JCB is ultimately assembled into one or more Joomla Components — which are then compiled into installable packages, ready for use or distribution.

---
MD;

		// Use Cases
		$readme[] = '### What Makes Components So Central?';
		$readme[] = <<<MD
Components control the following:

- Which views, modules, plugins, and helpers are packaged
- How the database is initialized or migrated (via tweaks)
- Where assets are placed in the Joomla filesystem
- Which version of Joomla the output is compatible with
- How the component is installed, updated, and distributed
- What language files, readmes, and wikis are bundled
- Who authored the component and where it lives in Git

> Components are the single point of truth for defining your extension. Once everything else is configured — fields, views, snippets, layouts — you bind them all together through the Component.

---
MD;

		// Maintenance
		$readme[] = '### Version Control, Syncing & Collaboration';
		$readme[] = <<<MD
JCB Components support:

- Branch-specific configuration (Joomla 3, 4, 5)
- Component-level versioning and changelogs
- Resetting from a central repository
- Forking to maintain your own variants
- Pushing updates upstream or into shared team forks

They can also be extended via init/reset/update workflows, just like all other JCB entities.

This makes them ideal for distributed teams, client-specific forks, and open-source extension development.

> A Component in JCB isn't just a bundle of files — it's a fully-defined application package that carries the design, data, logic, and behaviour of your Joomla extension.

---
MD;

		// Index
		$readme[] = '### Index of Joomla Components';
		$readme[] = '';
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

