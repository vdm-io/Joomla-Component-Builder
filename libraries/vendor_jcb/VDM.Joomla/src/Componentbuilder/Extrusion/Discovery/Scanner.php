<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Discovery;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Plan;


/**
 * A bounded, contained walk of an untrusted component source tree.
 * 
 * The tree being scanned may be an unzipped upload, so every path this class
 * hands back has been resolved and proven to sit below the source root. The
 * walk is also bounded by an explicit depth and file-count cap so a pathological
 * tree cannot turn discovery into a denial of service.
 * 
 * @since 6.1.6
 */
final class Scanner
{
	/**
	 * Directory names that cannot hold anything extrusion wants.
	 *
	 * Note that vendor is deliberately absent: a JCB-built component often keeps
	 * its table definition class inside a vendored power namespace.
	 *
	 * @var    array<string>
	 * @since  6.1.6
	 */
	private const PRUNE = ['.git', '.svn', '.hg', 'node_modules', '.idea', '.vscode', '.DS_Store'];

	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Report Registry.
	 *
	 * @var    Report
	 * @since  6.1.6
	 */
	protected Report $report;

	/**
	 * The operation source read set.
	 *
	 * @var    Plan
	 * @since  6.2.0
	 */
	protected Plan $plan;

	/**
	 * Constructor.
	 *
	 * @param   Config  $config  The extrusion configuration.
	 * @param   Report  $report  The run report registry.
	 *
	 * @since   6.1.6
	 */
	public function __construct(Config $config, Report $report, Plan $plan)
	{
		$this->config = $config;
		$this->report = $report;
		$this->plan = $plan;
	}

	/**
	 * Resolve a source root to a real, existing directory.
	 *
	 * @param   string  $root  The candidate source root.
	 *
	 * @return  string|null  The resolved root, or null when it is unusable.
	 * @since   6.1.6
	 */
	public function root(string $root): ?string
	{
		if ($root === '')
		{
			return null;
		}

		$resolved = realpath($root);

		if ($resolved === false || !is_dir($resolved))
		{
			return null;
		}

		return rtrim(str_replace('\\', '/', $resolved), '/');
	}

	/**
	 * Resolve one relative candidate below a root, proving containment.
	 *
	 * @param   string  $root      The resolved source root.
	 * @param   string  $relative  The relative candidate path.
	 *
	 * @return  string|null  The contained absolute path, or null.
	 * @since   6.1.6
	 */
	public function resolve(string $root, string $relative): ?string
	{
		$relative = trim(str_replace('\\', '/', $relative), '/');

		if ($relative === '' || str_contains($relative, '..'))
		{
			return null;
		}

		return $this->contain($root, $root . '/' . $relative);
	}

	/**
	 * Prove one absolute candidate sits below the source root.
	 *
	 * A symbolic link is refused outright rather than followed, because a link
	 * is the cheapest way for an uploaded tree to point outside itself.
	 *
	 * @param   string  $root       The resolved source root.
	 * @param   string  $candidate  The absolute candidate path.
	 *
	 * @return  string|null  The contained absolute path, or null.
	 * @since   6.1.6
	 */
	public function contain(string $root, string $candidate): ?string
	{
		if (!file_exists($candidate))
		{
			return null;
		}

		if (is_link($candidate))
		{
			$this->report->set('skipped.symlink.' . md5($candidate), $candidate);

			return null;
		}

		$resolved = realpath($candidate);

		if ($resolved === false)
		{
			return null;
		}

		$resolved = rtrim(str_replace('\\', '/', $resolved), '/');

		if ($resolved !== $root && !str_starts_with($resolved, $root . '/'))
		{
			$this->report->set('skipped.uncontained.' . md5($resolved), $resolved);

			return null;
		}

		return $resolved;
	}

	/**
	 * Walk the tree once, collecting files with the wanted extensions.
	 *
	 * @param   string         $root        The resolved source root.
	 * @param   array<string>  $extensions  Lower-case extensions without the dot.
	 *
	 * @return  array<string>  Absolute, contained file paths.
	 * @since   6.1.6
	 */
	public function files(string $root, array $extensions = []): array
	{
		$maxDepth = (int) $this->config->get('depth', 12);
		$maxFiles = (int) $this->config->get('maxFiles', 20000);
		$wanted = array_flip(array_map('strtolower', $extensions));
		$found = [];
		$queue = [[$root, 0]];
		$seen = 0;

		while ($queue !== [])
		{
			[$directory, $depth] = array_shift($queue);
			$entries = @scandir($directory);

			if ($entries === false)
			{
				continue;
			}

			foreach ($entries as $entry)
			{
				if ($entry === '.' || $entry === '..' || in_array($entry, self::PRUNE, true))
				{
					continue;
				}

				$path = $directory . '/' . $entry;

				if (is_link($path))
				{
					$this->report->set('skipped.symlink.' . md5($path), $path);

					continue;
				}

				if (is_dir($path))
				{
					if ($depth < $maxDepth)
					{
						$queue[] = [$path, $depth + 1];
					}
					else
					{
						$this->report->set('skipped.depth.' . md5($path), $path);
					}

					continue;
				}

				if (!is_file($path))
				{
					continue;
				}

				$seen++;

				if ($seen > $maxFiles)
				{
					$this->report->set('skipped.maxfiles', $maxFiles);

					break 2;
				}

				if ($wanted !== [] && !isset($wanted[strtolower(pathinfo($path, PATHINFO_EXTENSION))]))
				{
					continue;
				}

				$contained = $this->contain($root, $path);

				if ($contained !== null)
				{
					$found[] = $contained;
				}
			}
		}

		sort($found, SORT_STRING);

		if ($this->plan->active())
		{
			$this->plan->directory($root, $extensions, $found);
		}

		return $found;
	}

	/**
	 * Read the head of a file for a cheap content-signature test.
	 *
	 * @param   string  $path   Absolute file path.
	 * @param   int     $bytes  How many bytes to read.
	 *
	 * @return  string  The leading bytes, or an empty string.
	 * @since   6.1.6
	 */
	public function head(string $path, int $bytes = 8192): string
	{
		$handle = @fopen($path, 'rb');

		if ($handle === false)
		{
			return '';
		}

		$content = @fread($handle, max(1, $bytes));
		@fclose($handle);

		return $content === false ? '' : $content;
	}

	/**
	 * Read a whole file as text.
	 *
	 * @param   string  $path  Absolute file path.
	 *
	 * @return  string|null  The content, or null when unreadable.
	 * @since   6.1.6
	 */
	public function read(string $path): ?string
	{
		$content = @file_get_contents($path);

		if ($content !== false && $this->plan->active())
		{
			$this->plan->file($path, hash('sha256', $content));
		}

		return $content === false ? null : $content;
	}
}

