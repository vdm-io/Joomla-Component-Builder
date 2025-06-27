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

namespace VDM\Joomla\Componentbuilder\Package\Field\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Field Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Fields repository in Markdown format.
	 *
	 * Fields define the structure, behavior, and storage of data throughout various
	 * JCB-managed entities and are central to the Joomla component architecture.
	 *
	 * @param  array  $items  All Field definitions in this repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Title
		$readme[] = '# JCB! Fields';
		$readme[] = '';

		// Introduction
		$readme[] = '### What Are Fields?';
		$readme[] = <<<MD
Fields are the **foundation** of every Joomla Component Builder (JCB) project.

They define how data is **stored**, **validated**, **rendered**, and **interacted with** in your Joomla extensions.

Fields let you control everything from the **underlying database schema** to the **user interface**, all within a single configuration.

Each Field:
- Defines **database structure** (type, size, default, null, unique keys, indexes)
- Binds to a **fieldtype**, determining HTML rendering and behavior
- Supports per-field **custom PHP** for model saving and retrieval
- Allows styling and scripting (HTML attributes, JS, CSS)
- Automatically generates Joomla-compliant XML field definitions

MD;

		// Scope of Use
		$readme[] = '### Where Are Fields Used in JCB?';
		$readme[] = <<<MD
Fields are universal integrated — they are used in, highly structured areas:

- ✅ **Admin Views** (the native Joomla back-end editing views)
- ✅ **Modules** (frontend display configurations)
- ✅ **Plugins** (event-driven integrations)
- ✅ **Component Configurations** (global parameter settings)

MD;

		// Field Capabilities
		$readme[] = '### What Can a Field Do?';
		$readme[] = <<<MD
A Field in JCB can define:

- **Database Type & Schema**: `int`, `varchar`, `json`, custom, nullable, defaults, indexes
- **Permissions**: who can view/edit the field (ACL)
- **Rendering Options**: HTML classes, labels, JS behaviors
- **Model Integration**: how the value is saved or retrieved
- **Dynamic Logic**: PHP hooks for `onGet`, `onSave`, `onPrepareForm`, etc.
- **Fieldtypes**: link to rich behaviors like Model Selects, Subforms, Toggle Switches, Encrypted Fields, etc.

This centralization makes field management efficient and highly reusable.

MD;

		// Reusability
		$readme[] = '### Reuse and Sharing';
		$readme[] = <<<MD
Fields are standalone entities:

- Define once, **reuse across multiple Admin Views**, Modules, or Plugins
- Fields can also be exported and shared via repositories
- JCB will automatically adjust them to fit into each consuming context

This means less duplication, and greater consistency across your entire component structure.

MD;

		// Versioning / Sync
		$readme[] = '### Versioning and Customization';
		$readme[] = <<<MD
To update a field:

- Click **"reset"** in the JCB UI to sync with this repository
- Or **fork** this repository, customize the field, and point JCB to your fork

This preserves version control while allowing your own field improvements to live independently.

>Fields define both structure and behavior — they are where your data comes alive.

---
MD;

		// Index section
		$readme[] = '### Index of Fields';
		$readme[] = '';

		// Add index
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

