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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Joomla Update Server Class
 * 
 * @since 3.2.0
 */
class Updateserver
{
	/**
	 * Set version updates
	 *
	 * @param   object     $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		// set the version updates
		$item->version_update = (isset($item->version_update)
			&& JsonHelper::check($item->version_update))
			? json_decode((string) $item->version_update, true) : null;
		if (ArrayHelper::check($item->version_update))
		{
			$item->version_update = array_values(
				$item->version_update
			);

			// set  the change log details
			$this->changelog($item);
		}
	}

	/**
	 * Set changelog values to component changelog.
	 *
	 * @param  object  $item  The item data.
	 *
	 * @return void
	 * @since  3.2.0
	 */
	protected function changelog(object &$item): void
	{
		$bucket = [];

		foreach ($item->version_update as $update)
		{
			if (
				isset($update['change_log'], $update['version']) &&
				StringHelper::check($update['change_log']) &&
				StringHelper::check($update['version'])
			)
			{

				$logs = preg_split('/\r\n|\r|\n/', (string) $update['change_log']);

				$bucket[] = [
					'version'    => $update['version'],
					'change_log' => '# v' . $update['version'] . PHP_EOL . PHP_EOL . $update['change_log'],
					'logs'       => $logs,
				];
			}
		}

		// Sort bucket by version, newest first
		usort($bucket, static fn($a, $b) => version_compare($b['version'], $a['version']));

		// Extract markdown changelogs
		$sorted_change_logs = array_column($bucket, 'change_log');

		if (ArrayHelper::check($sorted_change_logs))
		{
			$item->changelog   = implode(PHP_EOL . PHP_EOL, $sorted_change_logs);

			// Sort bucket by version, oldest first
			usort($bucket, static fn($a, $b) => version_compare($a['version'], $b['version']));

			$element = isset($item->name_code) ? "com_{$item->name_code}": 'com_componentbuilder';

			$item->changelogxml = $this->getChangelogXml($bucket, $element);
		}
	}

	/**
	 * Build the changelog XML string from the bucket data.
	 *
	 * @param  array   $bucket   The sorted changelog bucket (each item has 'version' and 'logs').
	 * @param  string  $element  The XML element (usually the component name, e.g. "com_example").
	 *
	 * @return string  The full changelog XML string.
	 * @since  5.2.1
	 */
	protected function getChangelogXml(array $bucket, string $element): string
	{
		// Define tag order explicitly
		$tagOrder = ['security', 'fix', 'language', 'addition', 'change', 'remove', 'note'];

		$xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><changelogs/>');

		foreach ($bucket as $entry)
		{
			$changelog = $xml->addChild('changelog');
			$changelog->addChild('element', htmlspecialchars($element, ENT_XML1));
			$changelog->addChild('type', 'component');
			$changelog->addChild('version', htmlspecialchars($entry['version'], ENT_XML1));

			// Collect items grouped by tag first
			$grouped = array_fill_keys($tagOrder, []);

			foreach ($entry['logs'] as $line)
			{
				$line = $this->sanitizeChangelogLine($line);

				if ($line === '')
				{
					continue;
				}

				$tag = $this->classifyChangelogTag($line);
				$grouped[$tag][] = $line;
			}

			// Output tags in the correct order
			foreach ($tagOrder as $tag)
			{
				if (!empty($grouped[$tag]))
				{
					$tagNode = $changelog->addChild($tag);

					foreach ($grouped[$tag] as $line)
					{
						$tagNode->addChild('item', htmlspecialchars($line, ENT_XML1));
					}
				}
			}
		}

		$dom = dom_import_simplexml($xml)->ownerDocument;
		$dom->formatOutput = true;

		return $dom->saveXML();
	}

	/**
	 * Sanitize a changelog line by stripping Markdown-style list markers and trimming whitespace.
	 *
	 * @param  string  $line  The raw changelog line.
	 *
	 * @return string  The cleaned line.
	 * @since  5.2.1
	 */
	protected function sanitizeChangelogLine(string $line): string
	{
		// Remove leading Markdown list markers:
		// - "- something", "* something", "+ something"
		// - "1. something", "1) something"
		// - "• something"
		$line = preg_replace('/^\s*(?:[-*+•]|\d+[.)])\s+/u', '', $line);

		return trim($line);
	}

	/**
	 * Classify which changelog tag a line belongs to.
	 *
	 * Order of priority:
	 *  security > fix > language > addition > change > remove > note (default)
	 *
	 * @param  string  $line  The cleaned changelog line.
	 *
	 * @return string  The tag name to use in XML.
	 * @since  5.2.1
	 */
	protected function classifyChangelogTag(string $line): string
	{
		$l = mb_strtolower($line);

		if (str_contains($l, 'security'))
		{
			return 'security';
		}

		if (str_contains($l, 'fix'))
		{
			return 'fix';
		}

		if (str_contains($l, 'lang'))
		{
			return 'language';
		}

		if (str_contains($l, 'add'))
		{
			return 'addition';
		}

		if (str_contains($l, 'change') || str_contains($l, 'refactor') || str_contains($l, 'update'))
		{
			return 'change';
		}

		if (str_contains($l, 'remov') || str_contains($l, 'delete'))
		{
			return 'remove';
		}

		// Fallback if nothing matched
		return 'note';
	}
}

