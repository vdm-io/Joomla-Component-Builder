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


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Snippet Main Readme
 * 
 * @since  5.1.1
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Snippets repository in Markdown format.
	 *
	 * Snippets are reusable UI patterns or markup blocks designed to accelerate the development
	 * of Joomla components using JCB. This README outlines what Snippets are, how they are used,
	 * and how they are managed via the JCB interface and Git repositories.
	 *
	 * @param  array  $items  All snippets currently stored in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  3.2.0
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Snippets';
		$readme[] = '';

		// What is it?
		$readme[] = '### What Are JCB Snippets?';
		$readme[] = <<<MD
JCB Snippets are **reusable HTML-based code blocks** used to accelerate the creation of views, templates, and layouts in JCB.

They typically represent:

- UI blocks using frameworks like **UIkit**, **Bootstrap**, etc.
- Common layout structures or placeholders
- Ready-to-use HTML patterns for admin or frontend views

Snippets are ideal for streamlining repetitive markup, prototyping custom layouts, and establishing consistent structure in your components.

---
MD;

		$readme[] = '### Why Use Snippets?';
		$readme[] = <<<MD
JCB Snippets are built to improve **development speed and reusability**:

- Eliminate repetition in view and layout files
- Maintain visual and structural consistency
- Share UI patterns across projects or teams
- Quickly inject reusable frontend logic

Although helpful to beginners, Snippets are not beginner-only features —  
they offer serious workflow efficiency for advanced developers too.

---
MD;

		$readme[] = '### How Are Snippets Used in JCB?';
		$readme[] = <<<MD
Snippets are managed entirely from within the JCB GUI:

1. Click the **Init** button in the Snippets view.
2. Choose a **repository** to fetch Snippets from.
3. After selecting the repository, a list of available Snippets will be shown.
4. Select the Snippets you'd like to initialize into your local JCB project.

Once a snippet is initialized:

- You can **Reset** it at any time to match its latest version from the repository.
- If you have write access, you can **Push** your updates back to the repository.

Alternatively, fork this repository, push changes to your own fork,  
and submit pull requests to propose improvements upstream.

> All Snippets are stored as simple files under version control — supporting both collaboration and independence.

---
MD;

		$readme[] = '### Index of JCB Snippets';
		$readme[] = '';

		// Snippet listing
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

