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


use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Interfaces\Readme\ItemInterface;


/**
 * Compiler Field Item Readme
 * 
 * @since  5.1.1
 */
final class Item implements ItemInterface
{
	/**
	 * The field type array
	 *
	 * @var    array
	 * @since 5.1.1
	 */
	protected array $fieldTypes = [];

	/**
	 * Generate a README in Markdown format for a JCB Field.
	 *
	 * Provides a structured summary of the field definition, including type, XML, and database schema.
	 *
	 * @param  object  $item  The field item definition.
	 *
	 * @return string  The generated Markdown.
	 * @since  5.1.1
	 */
	public function get(object $item): string
	{
		$readme = [];

		// Title
		$readme[] = '### JCB! Field';
		$fieldName = $item->name ?? 'error: missing name';
		$readme[] = "# {$fieldName}";
		$readme[] = '';

		// Field type
		$fieldtypeName = $this->getFieldType($item);
		$readme[] = '> Field Type: ' . ($fieldtypeName ?? 'error: missing field type');
		$readme[] = '';

		// Database structure
		$datatype = $item->datatype ?? 'error: missing data type';

		$datalength = $item->datalenght ?? 'other';
		if (strtolower($datalength) === 'other')
		{
			$datalength = $item->datalenght_other ?? 'error: missing data length';
		}

		$datadefault = $item->datadefault ?? 'other';
		if (strtolower($datadefault) === 'other')
		{
			$datadefault = $item->datadefault_other ?? 'error: missing data default';
		}

		$nullSwitch = $item->null_switch ?? 'error: missing null switch';

		$indexType = match ((int) ($item->indexes ?? 0)) {
			2       => 'KEY',
			1       => 'UNIQUE KEY',
			default => 'NOT INDEX',
		};

		$modeling = $this->getEncodingTypeLabel((int) ($item->store ?? 0));

		// XML block
		$readme[] = '## Field XML:';
		$readme[] = '```xml';
		$readme[] = rtrim((string) ($item->xml ?? '<error: missing xml />'));
		$readme[] = '```';
		$readme[] = '';

		// Database block
		$readme[] = '## Database:';
		$readme[] = "- Data type: {$datatype}";
		$readme[] = "- Data length: {$datalength}";
		$readme[] = "- Data default: {$datadefault}";
		$readme[] = "- Null switch: {$nullSwitch}";
		$readme[] = "- Index: {$indexType}";
		$readme[] = "- Modeling: {$modeling}";
		$readme[] = '';

		// Footer
		$readme[] = '> Define, capture, and control data effortlessly with this Field; the core building block of every JCB component.';
		$readme[] = '';

		$readme[] = <<<MD
### Used in [Joomla Component Builder](https://www.joomlacomponentbuilder.com) - [Source](https://git.vdm.dev/joomla/Component-Builder) - [Mirror](https://github.com/vdm-io/Joomla-Component-Builder) - [Download](https://git.vdm.dev/joomla/pkg-component-builder/releases)

---
[![Joomla Volunteer Portal](https://img.shields.io/badge/-Joomla-gold?logo=joomla)](https://volunteers.joomla.org/joomlers/1396-llewellyn-van-der-merwe "Join Llewellyn on the Joomla Volunteer Portal: Shaping the Future Together!") [![Octoleo](https://img.shields.io/badge/-Octoleo-black?logo=linux)](https://git.vdm.dev/octoleo "--quiet") [![Llewellyn](https://img.shields.io/badge/-Llewellyn-ffffff?logo=gitea)](https://git.vdm.dev/Llewellyn "Collaborate and Innovate with Llewellyn on Git: Building a Better Code Future!") [![Telegram](https://img.shields.io/badge/-Telegram-blue?logo=telegram)](https://t.me/Joomla_component_builder "Join Llewellyn and the Community on Telegram: Building Joomla Components Together!") [![Mastodon](https://img.shields.io/badge/-Mastodon-9e9eec?logo=mastodon)](https://joomla.social/@llewellyn "Connect and Engage with Llewellyn on Joomla Social: Empowering Communities, One Post at a Time!") [![X (Twitter)](https://img.shields.io/badge/-X-black?logo=x)](https://x.com/llewellynvdm "Join the Conversation with Llewellyn on X: Where Ideas Take Flight!") [![GitHub](https://img.shields.io/badge/-GitHub-181717?logo=github)](https://github.com/Llewellynvdm "Build, Innovate, and Thrive with Llewellyn on GitHub: Turning Ideas into Impact!") [![YouTube](https://img.shields.io/badge/-YouTube-ff0000?logo=youtube)](https://www.youtube.com/@OctoYou "Explore, Learn, and Create with Llewellyn on YouTube: Your Gateway to Inspiration!") [![n8n](https://img.shields.io/badge/-n8n-black?logo=n8n)](https://n8n.io/creators/octoleo "Effortless Automation and Impactful Workflows with Llewellyn on n8n!") [![Docker Hub](https://img.shields.io/badge/-Docker-grey?logo=docker)](https://hub.docker.com/u/llewellyn "Llewellyn on Docker: Containerize Your Creativity!") [![Open Collective](https://img.shields.io/badge/-Donate-green?logo=opencollective)](https://opencollective.com/joomla-component-builder "Donate towards JCB: Help Llewellyn financially so he can continue developing this great tool!") [![GPG Key](https://img.shields.io/badge/-GPG-blue?logo=gnupg)](https://git.vdm.dev/Llewellyn/gpg "Unlock Trust and Security with Llewellyn's GPG Key: Your Gateway to Verified Connections!")
MD;

		return implode("\n", $readme);
	}

	/**
	 * Converts an integer encoding type value to its corresponding string label.
	 *
	 * @param  int  $value  The integer value representing the encoding type.
	 *
	 * @return string  The matching label or fallback message if invalid.
	 * @since  5.1.1
	 */
	protected function getEncodingTypeLabel(int $value): string
	{
		static $map = [
			0 => 'Default',
			1 => 'JSON',
			2 => 'base64',
			3 => 'Basic Encryption (local-DB-key)',
			5 => 'Medium Encryption (local-file-key)',
			6 => 'Expert Mode - Custom',
		];

		return $map[$value] ?? 'error: unknown encoding type';
	}

	/**
	 * Get the field type value from the item XML or fallback sources.
	 *
	 * Retrieves the field type label based on the item's `fieldtype` and optional cached mappings.
	 * If not cached, it attempts to resolve it via `GetHelper::var()` and caches the result.
	 * If all else fails, tries to extract the field type from raw XML using pattern matching.
	 *
	 * @param  object  $item  The item object containing fieldtype and xml data.
	 *
	 * @return string|null  The resolved field type label or null if not determinable.
	 * @since  5.1.1
	 */
	protected function getFieldType(object $item): ?string
	{
		$fieldtype = $item->fieldtype ?? null;

		// Fastest path: known in cache
		if ($fieldtype !== null && isset($this->fieldTypes[$fieldtype]))
		{
			return $this->fieldTypes[$fieldtype];
		}

		// Attempt to resolve type by name or helper (only if fieldtype exists)
		if ($fieldtype !== null)
		{
			$type = $item->fieldtype_name
				?? GetHelper::var('fieldtype', $fieldtype, 'guid', 'name');

			if ($type !== null)
			{
				$this->fieldTypes[$fieldtype] = $type;
				return $type;
			}
		}

		// Extract XML if present and try to determine type
		if (!empty($item->xml))
		{
			$type = GetHelper::var((string) $item->xml, 'type="', '"');

			if ($fieldtype !== null)
			{
				$this->fieldTypes[$fieldtype] = $type ?? null;
			}

			return $type;
		}

		// Fallback: nothing worked
		if ($fieldtype !== null)
		{
			$this->fieldTypes[$fieldtype] = null;
		}

		return null;
	}
}

