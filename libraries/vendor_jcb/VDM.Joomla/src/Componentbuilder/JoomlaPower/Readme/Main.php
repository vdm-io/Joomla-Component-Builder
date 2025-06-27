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

namespace VDM\Joomla\Componentbuilder\JoomlaPower\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;


/**
 * Compiler Joomla Power Main Readme
 * 
 * @since 3.2.0
 */
final class Main implements MainInterface
{
	/**
	 * Generate the main README for the JCB Joomla Powers repository in Markdown format.
	 *
	 * This README explains the purpose and function of Joomla Powers (JPKs), including dynamic class resolution,
	 * namespace management, and automatic `use` statement injection. It also lists all powers in this repository.
	 *
	 * @param  array  $items  All items (Joomla Powers) assigned to this repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  3.2.0
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# Joomla! Power';
		$readme[] = '';

		// Description
		$readme[] = '### What Are Joomla Powers in JCB?';
		$readme[] = <<<MD
Joomla Powers in JCB are a smart way to include Joomla classes in your custom code — **without hardcoding their full class names or import paths**.

Instead of writing `\\Joomla\\CMS\\Factory::getApplication()->enqueueMessage(...);` manually, you can simply place a **Joomla Power Key (JPK)** in your code, like this:

```
Joomla---39403062_84fb_46e0_bac4_0023f766e827---Power::getApplication()->enqueueMessage(...);
```

> Replace each `---` with `___` when using the key inside your code.

JCB will automatically:

- Resolve this JPK to the correct class path for your current Joomla version.
- Add the correct `use` statement to the top of the file.
- Detect and resolve naming collisions by automatically generating an `as` alias (e.g., `use Joomla\CMS\Factory as CMSFactory;`).
- Replace the JPK in your code with the correct class name (either the original or aliased name).

---
MD;

		// Why explanation
		$readme[] = '### Why This Matters';
		$readme[] = <<<MD
Joomla occasionally moves classes between namespaces (e.g., from `Joomla\CMS\` to `Joomla\Framework\`).

By using JPKs, you no longer need to manually update class paths when switching between Joomla 3, 4, or 5+.  
**Your code becomes version-independent** — JCB handles the class namespacing and **use statement** injection during compilation.

You write clean, readable logic — and JCB ensures compatibility under the hood.

---
MD;

		// What can be found here
		$readme[] = '### What's in This Repository?';
		$readme[] = <<<MD
This repository contains a **index of Joomla Powers** to be used in a JCB instance.

The list below shows all Joomla Powers available in this repository — each one usable via its unique JPK.

---
MD;

		// Dynamic list of joomla powers
		$readme[] = $this->readmeBuilder($items);
		$readme[] = '';

		$readme[] = <<<MD
### All used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}

	/**
	 * The readme builder
	 *
	 * @param array    $classes  The powers.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function readmeBuilder(array &$items): string
	{
		$classes = [];
		foreach ($items as $guid => $power)
		{
			// add to the sort bucket
			$classes[] = [
				'name' => $power['name'],
				'link' => $this->indexLinkPower($power)
			];
		}

		return $this->readmeModel($classes);
	}

	/**
	 * Sort and model the readme classes
	 *
	 * @param array $classes The powers.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function readmeModel(array &$classes): string
	{
		$this->sortClasses($classes);

		return $this->generateIndex($classes);
	}

	/**
	 * Generate the index string for classes
	 *
	 * @param array $classes The sorted classes
	 *
	 * @return string The index string
	 */
	private function generateIndex(array &$classes): string
	{
		$result = "# Index of Joomla! Powers\n";

		foreach ($classes as $class)
		{
			// Add the class details
			$result .= "\n - " . $class['link'];
		}

		$result .= "\n> remember to replace the `---` with `___` in the JPK to activate that Joomla! Power in your code";


		return $result;
	}

	/**
	 * Sort the flattened array using a single sorting function
	 *
	 * @param array $classes The classes to sort
	 *
	 * @since 3.2.0
	 */
	private function sortClasses(array &$classes): void
	{
		usort($classes, function ($a, $b) {
			return $this->compareName($a, $b);
		});
	}

	/**
	 * Compare the name of two classes
	 *
	 * @param array $a First class
	 * @param array $b Second class
	 *
	 * @return int Comparison result
	 * @since 3.2.0
	 */
	private function compareName(array $a, array $b): int
	{
		return strcmp($a['name'], $b['name']);
	}

	/**
	 * Build the Link to the power in this repository
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function indexLinkPower(array &$power): string
	{
		$name = $power['name'] ?? 'error';
		return '**' . $name . "** | "
			. $this->linkPowerRepo($power) . ' | '
			. $this->linkPowerSettings($power) . ' | JPK: `'
			. $this->linkPowerJPK($power) .'`';
	}

	/**
	 * Build the Link to the power in this repository
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerRepo(array &$power): string
	{
		$path = $power['path'] ?? 'error';
		return '[Details](' . $path . ')';
	}

	/**
	 * Build the Link to the power settings in this repository
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerSettings(array &$power): string
	{
		$settings = $power['settings'] ?? 'error';
		return '[Settings](' . $settings . ')';
	}

	/**
	 * Get the JoomlaPowerKey (JPK)
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerJPK(array &$power): string
	{
		$jpk = $power['jpk'] ?? 'error';
		return $jpk;
	}
}

