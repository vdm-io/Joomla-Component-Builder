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

namespace VDM\Joomla\Componentbuilder\Fieldtype\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;
use VDM\Joomla\Componentbuilder\Package\Readme\Main as ExtendingMain;


/**
 * Field Type Main Readme
 * 
 * @since  5.0.3
 */
final class Main extends ExtendingMain implements MainInterface
{
	/**
	 * Generate the main README for the JCB Field Types repository in Markdown format.
	 *
	 * Field Types define reusable templates for Joomla form fields inside JCB. Each field type links directly
	 * to Joomla's native XML field structure and allows easy reuse of predefined properties across multiple fields.
	 *
	 * @param  array  $items  All field types currently stored in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  3.2.0
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Field Types';
		$readme[] = '';

		// What is it?
		$readme[] = '### What Are JCB Field Types?';
		$readme[] = <<<MD
JCB Field Types act as **blueprints for Joomla form fields**.  
Each Field Type defines the structure, rules, and properties (such as required, translatable, adjustable) of a Joomla-compatible field.  

Instead of manually building repetitive XML field definitions, Field Types allow you to define:

- **Input Types** (`text`, `list`, `radio`, etc.)
- **Field Parameters** (`required`, `label`, `description`, etc.)
- **Default Values and Validation**
- **Custom Logic and Layout Overrides**

These definitions are stored centrally and reused across all fields built in JCB.

---
MD;

		$readme[] = '### Why Use Field Types?';
		$readme[] = <<<MD
When you create a new Field in JCB, you start by selecting a Field Type.  
This selection **automatically inherits all the structure and metadata** you defined in the Field Type.

This templating system:

- Saves time and reduces duplication
- Keeps your form field definitions consistent
- Ensures compatibility with Joomla's XML-based field system
- Allows global updates to propagate to all child fields

---
MD;

		$readme[] = '### How Do Field Types Integrate with Joomla?';
		$readme[] = <<<MD
Each Field Type generates **conventional Joomla XML**, which Joomla uses to automatically render HTML forms in both admin and site interfaces.  
The entire workflow is standards-based — meaning what JCB builds, Joomla understands and renders as expected.

---
MD;

		$readme[] = '### Customization & Syncing';
		$readme[] = <<<MD
Field Types are version-controlled and centrally managed.

- To **update a field type** from this repository in your JCB instance, simply use the `Reset` button inside the JCB GUI of field types.
- You can also **fork this repository** and point your JCB to your fork — giving you full control and independence from upstream updates.

This design promotes **collaborative sharing** while allowing **custom autonomy**.

---
MD;

		$readme[] = '### Index of JCB Field Types';
		$readme[] = '';

		// Field type listing
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

