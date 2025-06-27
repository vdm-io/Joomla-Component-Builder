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

namespace VDM\Joomla\Componentbuilder\Power\Readme;


use VDM\Joomla\Interfaces\Readme\MainInterface;


/**
 * Compiler Power Main Readme
 * 
 * @since 3.2.0
 */
final class Main implements MainInterface
{
	/**
	 * Generate the main README for the JCB Super Powers repository in Markdown format.
	 *
	 * This README provides an overview of what JCB Super Powers are, how they help,
	 * and lists all registered powers in this repository.
	 *
	 * @param  array  $items  All powers currently registered in the repository.
	 *
	 * @return string  The full generated Markdown README.
	 * @since  3.2.0
	 */
	public function get(array $items): string
	{
		$readme = [];

		// Header
		$readme[] = '# JCB! Super Powers';
		$readme[] = '';

		// Beginner-friendly + accurate explanation
		$readme[] = '### What Are JCB Super Powers?';
		$readme[] = <<<MD
In simple terms, **JCB Super Powers are PHP classes** — but managed entirely from the Joomla Component Builder (JCB) interface.

You can use JCB to create your own:
- **Classes**
- **Interfaces**
- **Abstract classes**
- **Traits**
- **Final classes**

These are full-featured PHP code units that you define visually in the JCB GUI. JCB then takes care of:
- Proper **namespacing**
- Correct **file placement**
- Seamless **project integration**

Every Super Power is treated as a reusable unit of logic. It can be automatically injected into any part of your JCB-powered component, or used in other components or codebases via a **SPK** (Super Power Key).

Even better — you can use **dynamic placeholders** like [[[`NamespacePrefix`]]] or [[[`ComponentNamespace`]]] in your Super Power code Namespace. These automatically adapt when reused in different projects, making your logic portable and future-proof.

> In short: **Super Powers turn JCB into a PHP code factory** — giving you the power of advanced PHP with none of the manual file management.

To learn how to create, manage, and use Super Powers, see the  
[Super Powers Documentation →](https://git.vdm.dev/joomla/super-powers/wiki)
MD;
		$readme[] = '';

		// What's in this repo
		$readme[] = '### What Can I Find Here?';
		$readme[] = <<<MD
This repository acts as a **central registry of approved Super Powers** specific to this JCB instance.  
Only the Super Powers that have been explicitly assigned to this repository are listed here.

In JCB, you can organize your Super Powers across multiple repositories.  
For example, we have separate repositories for:

- [GITEA](https://git.vdm.dev/joomla/gitea)-related classes
- [OpenAI](https://git.vdm.dev/joomla/openai) integrations
- Core [Super Power](https://git.vdm.dev/joomla/super-powers) collection
- and many more...

Each repository maintains its own index, and only the powers assigned to that specific repository will appear in its list.
MD;
		// How to use the Super powers
		$readme[] = '#### How to Use These Super Powers';
		$readme[] = <<<MD
If you want to use any of the classes listed here in your own component logic, simply reference their **SPK** (Super Power Key):

```
Super---[unique-guid]---Power
```

> Replace each `---` with `___` when using the key inside your code.

JCB will automatically resolve this SPK during compilation, placing the associated class in the correct location with the correct namespace based on your component context.  
This makes your logic both **reusable** and **component-aware**, without hardcoding anything.

---
MD;

		// Power list
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
				'namespace' => $power['namespace'],
				'type' => $power['type'],
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
		$this->sortClasses($classes, $this->defineTypeOrder());

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
		$result = "# Index of powers\n";
		$current_namespace = null;

		foreach ($classes as $class)
		{
			if ($class['namespace'] !== $current_namespace)
			{
				$current_namespace = $class['namespace'];
				$result .= "\n- **Namespace**: [{$current_namespace}](#" .
					strtolower(str_replace('\\', '-', $current_namespace)) . ")\n";
			}

			// Add the class details
			$result .= "\n  - " . $class['link'];
		}

		$result .= "\n> remember to replace the `---` with `___` in the SPK to activate that Power in your code";

		return $result;
	}

	/**
	 * Define the order of types for sorting purposes
	 *
	 * @return array The order of types
	 * @since 3.2.0
	 */
	private function defineTypeOrder(): array
	{
		return [
			'interface' => 1,
			'abstract' => 2,
			'abstract class' => 2,
			'final' => 3,
			'final class' => 3,
			'class' => 4,
			'trait' => 5
		];
	}

	/**
	 * Sort the flattened array using a single sorting function
	 *
	 * @param array $classes The classes to sort
	 * @param array $typeOrder The order of types
	 * @since 3.2.0
	 */
	private function sortClasses(array &$classes, array $typeOrder): void
	{
		usort($classes, function ($a, $b) use ($typeOrder) {
			$namespaceDiff = $this->compareNamespace($a, $b);

			if ($namespaceDiff !== 0)
			{
				return $namespaceDiff;
			}

			$typeDiff = $this->compareType($a, $b, $typeOrder);

			if ($typeDiff !== 0)
			{
				return $typeDiff;
			}

			return $this->compareName($a, $b);
		});
	}

	/**
	 * Compare the namespace of two classes
	 *
	 * @param array $a First class
	 * @param array $b Second class
	 *
	 * @return int Comparison result
	 * @since 3.2.0
	 */
	private function compareNamespace(array $a, array $b): int
	{
		$namespaceDepthDiff = substr_count($a['namespace'], '\\') - substr_count($b['namespace'], '\\');

		if ($namespaceDepthDiff === 0)
		{
			return strcmp($a['namespace'], $b['namespace']);
		}

		return $namespaceDepthDiff;
	}

	/**
	 * Compare the type of two classes
	 *
	 * @param array $a First class
	 * @param array $b Second class
	 * @param array $typeOrder The order of types
	 *
	 * @return int Comparison result
	 * @since 3.2.0
	 */
	private function compareType(array $a, array $b, array $typeOrder): int
	{
		return $typeOrder[$a['type']] <=> $typeOrder[$b['type']];
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
		$type = $power['type'] ?? 'error';
		$name = $power['name'] ?? 'error';
		return '**' . $type . ' ' . $name . "** | "
			. $this->linkPowerRepo($power) . ' | '
			. $this->linkPowerRaw($power) . ' | '
			. $this->linkPowerSettings($power) . ' | SPK: `'
			. $this->linkPowerSPK($power) .'`';
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
	 * Build the Link to the power raw code in this repository
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerRaw(array &$power): string
	{
		$raw = $power['power'] ?? 'error';
		return '[Raw](' . $raw . ')';
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
	 * Get the SuperPowerKey (SPK)
	 *
	 * @param array  $power  The power details.
	 *
	 * @return string
	 * @since 3.2.0
	 */
	private function linkPowerSPK(array &$power): string
	{
		$spk = $power['spk'] ?? 'error';
		return $spk;
	}
}

