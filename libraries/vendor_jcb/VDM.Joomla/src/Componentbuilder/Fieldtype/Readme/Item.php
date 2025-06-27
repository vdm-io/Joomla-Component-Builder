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


use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Field Type Item Readme
 * 
 * @since  5.0.3
 */
final class Item implements ItemInterface
{
	/**
	 * Generate a README for a JCB Field Type in Markdown format.
	 *
	 * This includes the field type name, short and full description, and a table of properties if available.
	 *
	 * @param  object  $item  The field type definition object.
	 *
	 * @return string  The generated README as Markdown.
	 * @since  5.0.3
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title and system name
		$readme[] = '### JCB! Field Type';
		$readme[] = '# ' . ($item->name ?? 'error: missing field type name');
		$readme[] = '';

		// Short description
		if (!empty($item->short_description)) {
			$readme[] = '> ' . trim($item->short_description);
			$readme[] = '';
		}

		// Full description
		if (!empty($item->description))
		{
			$readme[] = trim($item->description);
			$readme[] = '';
		}

		// Properties table
		if (!empty($item->properties) && (is_array($item->properties) || is_object($item->properties)))
		{
			$readme[] = $this->buildPropertyTable($item->properties);
			$readme[] = '';
		}

		// Footer
		$readme[] = '> Integrate, customize, and update this JCB Fieldtype with ease through JCB\'s flexible ecosystem.';
		$readme[] = '';

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}

	/**
	 * Builds a Markdown table with details about each form property, including optional PHP code blocks.
	 *
	 * The table includes columns: Property, Example, Adjustable, Mandatory, and Description.
	 * If the 'example' field contains PHP code patterns like variable assignment or object access,
	 * it will be linked to an anchor section with the code shown below the table.
	 * All '|' characters in example and description fields are replaced with '&#124;' to prevent Markdown table breaking.
	 *
	 * @param  array|object  $properties  Associative array of property objects.
	 *
	 * @return string  The generated Markdown output.
	 * @since 5.1.1
	 */
	protected function buildPropertyTable(array|object $properties): string
	{
		$properties = (array) $properties;
		$markdown = [];
		$codeSnippets = [];

		// Table header
		$markdown[] = '| Property | Example | Adjustable | Mandatory | Description |';
		$markdown[] = '|----------|---------|------------|-----------|-------------|';

		foreach ($properties as $prop)
		{
			$prop = (array) $prop;

			$name        = $prop['name'] ?? '—';
			$example     = trim($prop['example'] ?? '');
			$description = trim($prop['description'] ?? '');

			// Replace "|" in raw content to prevent Markdown table breakage
			$name = str_replace('|', '&#124;', $name);
			$example     = str_replace('|', '&#124;', $example);
			$description = str_replace('|', '&#124;', $description);

			$adjustable = (!empty($prop['adjustable']) && $prop['adjustable'] == '1')
				? '![yes](https://img.shields.io/badge/yes-success?style=flat-square)'
				: '![no](https://img.shields.io/badge/no-blue?style=flat-square)';

			$mandatory = (!empty($prop['mandatory']) && $prop['mandatory'] == '1')
				? '![yes](https://img.shields.io/badge/yes-success?style=flat-square)'
				: '![no](https://img.shields.io/badge/no-blue?style=flat-square)';

			// Detect PHP-like code: variable assignment or object access
			$isCode = preg_match('/\$\w+\s*=|\$\w+->\w+/', $example);

			if ($isCode)
			{
				$anchor = 'code-' . preg_replace('/[^a-z0-9]+/i', '-', strtolower($name));
				$link = "[code](#{$anchor})";
				$codeSnippets[$anchor] = $prop['example'];
				$example = $link;
			}
			elseif ($example === '')
			{
				$example = '—';
			}

			$markdown[] = "| {$name} | {$example} | {$adjustable} | {$mandatory} | {$description} |";
		}

		// Join the table
		$output = implode("\n", $markdown);

		// Add code blocks if any
		if (!empty($codeSnippets))
		{
			$output .= "\n\n";
			foreach ($codeSnippets as $anchor => $code)
			{
				$output .= "### <a id=\"{$anchor}\"></a>Code for `{$anchor}`\n\n";
				$output .= "```php\n{$code}\n```\n\n";
			}
		}

		return $output;
	}
}

