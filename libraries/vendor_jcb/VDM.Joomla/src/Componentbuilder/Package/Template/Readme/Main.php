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

namespace VDM\Joomla\Componentbuilder\Package\Template\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Template Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Templates repository in Markdown format.
	 *
	 * Templates define high-level structures for rendering admin or site views
	 * in Joomla components built with JCB. They often include reusable layouts and logic,
	 * and offer developers modular control over output presentation.
	 *
	 * @param  array  $items  All templates currently stored in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  5.1.1
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Templates';
		$readme[] = '';

		// What is it?
		$readme[] = '### What Are JCB Templates?';
		$readme[] = <<<MD
JCB Templates provide **modular, reusable view structures** for rendering HTML output in Joomla components.  
They are used within both **site views** and **custom admin views**, functioning as high-level wrappers for your display logic.

Templates typically include or call:

- **Layouts** — smaller reusable view fragments
- **Other Templates** — to nest and reuse structures
- **PHP Logic & HTML** — for dynamic rendering

Much like Joomla's native template system, JCB Templates allow **clean separation of logic and presentation**, and can be overridden or extended easily.

---
MD;

		$readme[] = '### Why Use Templates in JCB?';
		$readme[] = <<<MD
Templates help you organize and modularize how your component's output is rendered. They offer:

- Clear and reusable structure across views
- Easier maintenance and visual consistency
- The ability to nest layouts and embed templates
- Override support for custom behaviors

This system mirrors Joomla's own MVC view rendering and fits naturally into both frontend and backend component workflows.

---
MD;

		$readme[] = '### How Do You Manage Templates in JCB?';
		$readme[] = <<<MD
Templates are managed directly in the **Templates** tab within JCB's GUI.

To import a template from this repository:

1. Click **Init** in the Templates section.
2. Select the repository you want to pull from.
3. Choose the Templates you'd like to import.

You can then:

- **Reset** any Template to refresh it from the repo
- **Push** updates back if you maintain this repository
- Or **fork** the repo to maintain your own version of templates

This process allows rapid syncing, reuse, and sharing of structured view logic across projects.

---
MD;

		$readme[] = '### Index of JCB Templates';
		$readme[] = '';

		// Template listing
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

