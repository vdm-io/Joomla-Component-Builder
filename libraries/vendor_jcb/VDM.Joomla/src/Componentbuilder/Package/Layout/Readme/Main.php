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

namespace VDM\Joomla\Componentbuilder\Package\Layout\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Layout Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Layouts repository in Markdown format.
	 *
	 * Layouts provide a modular templating system for rendering reusable HTML views
	 * inside Joomla components, managed through JCB's GUI. This README outlines
	 * what Layouts are, how they work, and how they're managed via repositories.
	 *
	 * @param  array  $items  All layouts currently stored in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Layouts';
		$readme[] = '';

		// What is it?
		$readme[] = '### What Are JCB Layouts?';
		$readme[] = <<<MD
JCB Layouts are **modular Joomla layout files** managed via the [JCB](https://www.joomlacomponentbuilder.com) GUI.  
They are equivalent to Joomla's native layout override files (`/layouts`) and follow the same design principles.

With JCB Layouts, you can define reusable, customizable HTML+PHP views:

- Rendered from anywhere in your component (admin or site)
- Encapsulated in clean, template-driven blocks
- Fully namespace-aware and overridable like native Joomla layouts

This allows your components to remain **cleaner, more maintainable, and DRY** (Don't Repeat Yourself).

---
MD;

		$readme[] = '### Why Use Layouts in JCB?';
		$readme[] = <<<MD
JCB Layouts help you:

- Extract reusable markup from views, fields, and modules
- Maintain structural consistency across your component
- Simplify changes by editing one file instead of many
- Allow for override support via Joomla templates

They're ideal for:
- Form row rendering
- Repeated output (like items in a loop)
- Conditionals and dynamic display logic

---
MD;

		$readme[] = '### How Do You Manage Layouts in JCB?';
		$readme[] = <<<MD
All Layouts are version-controlled and managed inside JCB's GUI under the **Layouts** tab.

To use a layout from a repository:

1. Click the **Init** button inside the Layouts area.
2. Choose a repository to load Layouts from.
3. Select the specific Layout(s) you want to import.
4. The Layout will now be available in your JCB project.

You can:

- **Reset** a Layout to sync with its upstream version
- **Push** your custom Layouts if you have write access
- Or **Fork** this repository to manage your own Layout collection

> This lets you integrate upstream improvements while maintaining your own customization workflow.

---
MD;

		$readme[] = '### Index of JCB Layouts';
		$readme[] = '';

		// Layout listing
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

