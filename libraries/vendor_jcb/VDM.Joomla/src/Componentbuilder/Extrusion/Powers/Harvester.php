<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    22nd August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Powers;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Scanner;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Reader\ClassFile;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Identity;
use VDM\Joomla\Componentbuilder\Extrusion\Powers\Resolver\Namespacer;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Harvest;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Parsed;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Resolver\Guid;


/**
 * Walks the given library folders and gathers every class as a power candidate.
 * 
 * Harvesting is the whole first step of the two-step run: everything here is
 * gathered, identified and grouped, and nothing is written. The tree this
 * builds in the Harvest registry -- library, then sub-folder bundle, then
 * class, each candidate carrying its derived identity and whether it already
 * exists -- is deliberately the shape a caller presents for approval, so the
 * eventual interface only has to render it, never reorganise it.
 * 
 * A declaration's stable source key is independent of a selected database
 * GUID. Raw observations survive ambiguous matching and are re-resolved under
 * the final context and explicit pairing before assembly or persistence.
 * 
 * @since 6.1.7
 */
final class Harvester
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.7
	 */
	protected Config $config;

	/**
	 * The Scanner Class.
	 *
	 * @var    Scanner
	 * @since  6.1.7
	 */
	protected Scanner $scanner;

	/**
	 * The Class File Reader.
	 *
	 * @var    ClassFile
	 * @since  6.1.7
	 */
	protected ClassFile $reader;

	/**
	 * The Namespacer Resolver.
	 *
	 * @var    Namespacer
	 * @since  6.1.7
	 */
	protected Namespacer $namespacer;

	/**
	 * The scoped Power identity resolver.
	 *
	 * @var    Identity
	 * @since  6.1.7
	 */
	protected Identity $identity;

	/**
	 * The Guid Resolver.
	 *
	 * @var    Guid
	 * @since  6.1.7
	 */
	protected Guid $guid;

	/**
	 * The Harvest Registry.
	 *
	 * @var    Harvest
	 * @since  6.1.7
	 */
	protected Harvest $harvest;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.7
	 */
	protected Report $report;

	/**
	 * Lexical declarations from unchanged source content in this run.
	 *
	 * @var    Parsed
	 * @since  6.2.0
	 */
	protected Parsed $parsed;

	/**
	 * Constructor.
	 *
	 * @param   Config      $config      The extrusion configuration.
	 * @param   Scanner     $scanner     The bounded tree scanner.
	 * @param   ClassFile   $reader      The class file reader.
	 * @param   Namespacer  $namespacer  The namespace conversion resolver.
	 * @param   Identity    $identity    The scoped identity resolver.
	 * @param   Guid        $guid        The identity resolver.
	 * @param   Harvest     $harvest     The harvest registry.
	 * @param   Report      $report      The run report registry.
	 * @param   Parsed      $parsed      The content-addressed lexical observations.
	 *
	 * @since   6.1.7
	 */
	public function __construct(
		Config $config,
		Scanner $scanner,
		ClassFile $reader,
		Namespacer $namespacer,
		Identity $identity,
		Guid $guid,
		Harvest $harvest,
		Report $report,
		Parsed $parsed
	)
	{
		$this->config = $config;
		$this->scanner = $scanner;
		$this->reader = $reader;
		$this->namespacer = $namespacer;
		$this->identity = $identity;
		$this->guid = $guid;
		$this->harvest = $harvest;
		$this->report = $report;
		$this->parsed = $parsed;
	}

	/**
	 * Harvest every library folder the run was given, once per identity context.
	 *
	 * A harvest settles identities under the placeholder values of its moment,
	 * so it only stands while those values do: naming another component after
	 * harvesting quietly regathers, rather than extruding identities the new
	 * component would never recognise.
	 *
	 * @return  int  The number of class candidates harvested.
	 * @since   6.1.7
	 */
	public function harvest(): int
	{
		// Re-read source and database evidence at every operation boundary. A
		// namespace-value cache alone cannot detect source/relationship changes.
		$this->harvest->clear();
		$this->identity->refresh();
		$signature = $this->namespacer->signature();
		$this->report->set('counts.powers.parsed', 0);
		$this->report->set('counts.powers.parse_reused', 0);

		$found = 0;
		$existing = 0;

		foreach ((array) $this->config->get('libraries', []) as $path)
		{
			$counts = $this->library((string) $path);
			$found += $counts[0];
			$existing += $counts[1];
		}

		$this->harvest->set('harvested', true);
		$this->harvest->set('signature', $signature);
		$this->report->set('counts.powers.classes', $found);
		$this->report->set('counts.powers.existing', $existing);
		$this->report->set('counts.powers.new', $found - $existing);

		return $found;
	}

	/**
	 * Harvest one library folder.
	 *
	 * @param   string  $path  The library folder path as given.
	 *
	 * @return  array{0: int, 1: int}  How many candidates were found, and how many already exist.
	 * @since   6.1.7
	 */
	protected function library(string $path): array
	{
		$root = $this->scanner->root($path);

		if ($root === null)
		{
			$this->report->set('powers.failed.library.' . md5($path), $path);

			return [0, 0];
		}

		$found = 0;
		$existing = 0;

		foreach ($this->vendors($root) as $folder => $source)
		{
			$counts = $this->vendor($root, (string) $folder, $source);
			$found += $counts[0];
			$existing += $counts[1];
		}

		return [$found, $existing];
	}

	/**
	 * The vendor folders one library path holds, and where each one's classes start.
	 *
	 * A Joomla library extension is a folder of vendor folders: the extension
	 * folder is what Joomla installs, and inside it each vendor folder names a
	 * namespace head in its own dotted name and keeps its classes under src.
	 * Reading the extension folder as though it were the vendor would lose that
	 * name, which is the only place the convention records the head -- so every
	 * folder holding a src is its own library here, and a path that is already
	 * one answers for itself.
	 *
	 * @param   string  $root  The resolved library path.
	 *
	 * @return  array<string, string>  Vendor folder name keyed to its source root.
	 * @since   6.1.8
	 */
	protected function vendors(string $root): array
	{
		if (is_dir($root . '/src'))
		{
			return [basename($root) => $root . '/src'];
		}

		$found = [];
		$handle = @opendir($root);

		if ($handle !== false)
		{
			while (($entry = readdir($handle)) !== false)
			{
				if ($entry === '.' || $entry === '..')
				{
					continue;
				}

				if (is_dir($root . '/' . $entry . '/src'))
				{
					$found[$entry] = $root . '/' . $entry . '/src';
				}
			}

			closedir($handle);
		}

		if ($found === [])
		{
			// nothing states a vendor, so the path speaks for itself
			return [basename($root) => $root];
		}

		ksort($found);

		return $found;
	}

	/**
	 * Harvest one vendor folder.
	 *
	 * @param   string  $root    The library path the vendor sits in.
	 * @param   string  $folder  The vendor folder name, which states its head.
	 * @param   string  $source  The root the dots count from.
	 *
	 * @return  array{0: int, 1: int}  How many candidates were found, and how many already exist.
	 * @since   6.1.8
	 */
	protected function vendor(string $root, string $folder, string $source): array
	{
		$key = $base = $this->key($folder);
		$tail = 1;

		// two libraries may share a folder name without sharing an entry
		while ($this->harvest->exists('libraries.' . $key))
		{
			$key = $base . '_' . ++$tail;
		}

		$found = 0;
		$existing = 0;
		$bundles = [];

		foreach ($this->scanner->files($source, ['php']) as $file)
		{
			$candidate = $this->candidate($file, $source, $key, $folder);

			if ($candidate === null)
			{
				continue;
			}

			$found++;

			if ($candidate['exists'])
			{
				$existing++;
			}

			$bundle = $candidate['bundle'];
			$bundles[$bundle] ??= ['folder' => $bundle, 'count' => 0, 'classes' => []];
			$bundles[$bundle]['count']++;
			$bundles[$bundle]['classes'][] = $candidate['source_key'];
		}

		$this->harvest->set('libraries.' . $key, [
			'path' => $root,
			'folder' => $folder,
			'source' => $source,
			'count' => $found
		]);

		foreach ($bundles as $bundle => $details)
		{
			$this->harvest->set(
				'libraries.' . $key . '.bundles.'
				. ($bundle === '' ? '_root' : $this->key($bundle)),
				$details
			);
		}

		return [$found, $existing];
	}

	/**
	 * Read one file into a harvest candidate.
	 *
	 * @param   string  $file     The absolute file path.
	 * @param   string  $source   The source root the dots count from.
	 * @param   string  $library  The library key the candidate belongs to.
	 * @param   string  $folder   The library's own folder name, which states its head.
	 *
	 * @return  array{source_key: string, guid: string|null, exists: bool, bundle: string}|null  The stored candidate essentials, or null.
	 * @since   6.1.7
	 */
	protected function candidate(string $file, string $source, string $library, string $folder): ?array
	{
		$code = $this->scanner->read($file);

		if ($code === null)
		{
			$this->report->set('powers.skipped.unreadable.' . md5($file), $file);

			return null;
		}

		$snapshot = hash('sha256', $code);
		$observation = $this->parsed->get($snapshot);

		if (is_array($observation))
		{
			$parts = $observation['parts'];
			$this->report->set('counts.powers.parse_reused', (int) $this->report->get('counts.powers.parse_reused', 0) + 1);
		}
		else
		{
			$parts = $this->reader->read($code);
			$this->parsed->set($snapshot, ['parts' => $parts]);
			$this->report->set('counts.powers.parsed', (int) $this->report->get('counts.powers.parsed', 0) + 1);
		}

		if ($parts === null)
		{
			$this->report->set('powers.skipped.noclass.' . md5($file), $file);

			return null;
		}

		if ($parts['type'] === null)
		{
			$this->report->set('powers.skipped.unsupported.' . md5($file), $file);

			return null;
		}

		if ($parts['namespace'] === '')
		{
			$this->report->set('powers.skipped.nonamespace.' . md5($file), $file);

			return null;
		}

		if ($parts['body'] === null)
		{
			// writing a power with a silently lost body would be far worse
			$this->report->set('powers.skipped.unparsable.' . md5($file), $file);

			return null;
		}

		$relative = ltrim(substr($file, strlen($source)), '/');
		$bundle = str_contains($relative, '/') ? dirname($relative) : '';
		$folders = $bundle === '' ? [] : explode('/', $bundle);
		$fqn = $parts['namespace'] . '\\' . $parts['class'];

		if (basename($file, '.php') !== $parts['class'])
		{
			$this->report->set('powers.mismatch.filename.' . md5($file), $file);
		}

		// the source root's own folders may mirror more of the namespace than
		// the folders below it, when the run was aimed below the real root
		$stored = $this->namespacer->stored(
			$parts['namespace'], $parts['class'], $folders, $folder,
			explode('/', trim($source, '/'))
		);

		$placement = $stored !== null && basename($file, '.php') === $parts['class'];
		$metadata = $this->metadata($file, $parts);

		if ($metadata !== null && !isset($metadata['error']))
		{
			$context = $this->namespacer->context((int) $this->config->get('sourceComponent', $this->config->get('component', 0)));
			$observed = $this->namespacer->expand($metadata['namespace'], $context);

			if ($this->namespacer->key($this->namespacer->resolve($metadata['namespace'], $context)) === $this->namespacer->key($fqn))
			{
				// Compiler Power distribution puts code.php beside settings.json.
				// That validated metadata describes its intended compiled location;
				// the GUID-named distribution directory does not imply relocation.
				$stored = $observed;
				$placement = true;
			}
			else
			{
				$metadata['error'] = 'Power metadata does not reconstruct this source namespace.';
			}
		}

		if ($stored === null)
		{
			$stored = $this->namespacer->conventional($parts['namespace'], $parts['class']);
			$this->report->set('powers.derived.convention.' . md5($file), $fqn);
		}

		$sections = explode('\\', $stored);
		$location = str_replace('.', '/', (string) array_pop($sections)) . '.php';
		$unit = 'unit_' . hash('sha256', strtolower(implode('\\', $sections)));
		// A nonconforming filename is still a distinct, visible observation.
		// Absolute installation paths and selected ancestor folders are not
		// logical identity inputs.
		if (!$placement)
		{
			$location .= '|' . basename($file);
		}

		$key = 'source_' . hash('sha256', serialize([$unit, strtolower($fqn), $location, $parts['type']]));
		$occurrence = ['file' => $file, 'relative' => $relative, 'snapshot' => $snapshot];
		$candidate = [
			'source_key' => $key,
			'source_unit' => $unit,
			'source_component_id' => (int) $this->config->get('sourceComponent', $this->config->get('component', 0)),
			'source_guid' => $metadata['guid'] ?? '',
			'metadata_files' => isset($metadata['file']) ? [['file' => $metadata['file'], 'snapshot' => $metadata['snapshot']]] : [],
			'library' => $library,
			'file' => $file,
			'relative' => $relative,
			'location' => $location,
			'bundle' => $bundle,
			'class' => $parts['class'],
			'type' => $parts['type'],
			'namespace' => $parts['namespace'],
			'fqn' => $fqn,
			'stored' => $stored,
			'placement_valid' => $placement,
			'placement_evidence' => $metadata === null ? $relative : 'settings.json',
			'occurrences' => [$occurrence],
			'docblock' => $parts['docblock'],
			'license' => $parts['license'],
			'extends' => $parts['extends'],
			'implements' => $parts['implements'],
			'uses' => $parts['uses'],
			'body' => (string) $parts['body']
		];

		if (isset($metadata['error']))
		{
			$candidate['source_error'] = $metadata['error'];
		}

		$previous = $this->harvest->get('classes.' . $key);

		if (is_array($previous))
		{
			foreach ($previous['occurrences'] as $seen)
			{
				if ($seen['file'] === $file)
				{
					$this->report->set('powers.skipped.duplicate.' . md5($file), $fqn);

					return null;
				}
			}

			$previous['occurrences'][] = $occurrence;
			$previous['metadata_files'] = array_merge($previous['metadata_files'], $candidate['metadata_files']);

			if (isset($candidate['source_error']))
			{
				$previous['source_error'] = $candidate['source_error'];
			}
			elseif ($candidate['source_guid'] !== '' && $previous['source_guid'] !== ''
				&& $candidate['source_guid'] !== $previous['source_guid'])
			{
				$previous['source_error'] = 'Duplicate source declarations contain conflicting Power GUID metadata.';
			}
			elseif ($previous['source_guid'] === '')
			{
				$previous['source_guid'] = $candidate['source_guid'];
			}

			$this->harvest->set('classes.' . $key, $previous);
			$this->report->set('powers.duplicate.sources.' . $key, array_column($previous['occurrences'], 'file'));

			return ['source_key' => $key, 'guid' => $previous['guid'], 'exists' => $previous['exists'], 'bundle' => $bundle];
		}

		$result = $this->identity->resolve($candidate);
		$candidate['resolution'] = $result;
		$candidate['guid'] = $result['write_guid'];
		$candidate['matched_guid'] = $result['matched_guid'];
		$candidate['placeholder'] = $result['namespace']['value'] ?? $this->namespacer->placeholderize(
			$stored, false, $this->identity->sourceContext($candidate)
		);
		$candidate['exists'] = $result['status'] === 'matched';
		$candidate['id'] = $result['target']['id'] ?? 0;
		$candidate['standing'] = $result['target']['namespace'] ?? '';
		$candidate['action'] = $result['status'] === 'new' ? 'create'
			: ($result['status'] === 'matched' ? 'update' : $result['status']);
		$this->harvest->set('classes.' . $key, $candidate);

		return ['source_key' => $key, 'guid' => $candidate['guid'], 'exists' => $candidate['exists'], 'bundle' => $bundle];
	}

	/**
	 * Sanitise one registry path segment.
	 *
	 * @param   string  $segment  The raw segment.
	 *
	 * @return  string  A segment safe to use in a dotted registry path.
	 * @since   6.1.7
	 */
	protected function key(string $segment): string
	{
		return preg_replace('/[^A-Za-z0-9_]/', '_', $segment) ?? $segment;
	}
	/**
	 * Validate optional compiler-generated metadata beside a distributed Power.
	 *
	 * @param   string  $file   An already scanned PHP source file.
	 * @param   array   $parts  The lexically read declaration.
	 *
	 * @return  array|null  Validated identity/namespace metadata, an error, or none.
	 * @since   6.2.0
	 */
	protected function metadata(string $file, array $parts): ?array
	{
		if (basename($file) !== 'code.php')
		{
			return null;
		}

		$path = dirname($file) . '/settings.json';

		if (!is_file($path) || is_link($path) || realpath(dirname($path)) !== realpath(dirname($file)))
		{
			return null;
		}

		$text = $this->scanner->read($path);
		$data = $text === null ? null : json_decode($text, true);

		if (!is_array($data) || !$this->guid->valid($data['guid'] ?? null)
			|| !is_string($data['namespace'] ?? null)
			|| strcasecmp((string) ($data['name'] ?? ''), $parts['class']) !== 0
			|| (string) ($data['type'] ?? '') !== $parts['type'])
		{
			return ['error' => 'The optional Power metadata is malformed or contradicts its declaration.'];
		}

		return ['guid' => strtolower($data['guid']), 'namespace' => $data['namespace'], 'file' => $path, 'snapshot' => hash('sha256', $text)];
	}
}

