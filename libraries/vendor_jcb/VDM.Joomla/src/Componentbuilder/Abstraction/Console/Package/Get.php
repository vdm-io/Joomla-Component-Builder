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

namespace VDM\Joomla\Componentbuilder\Abstraction\Console\Package;


use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VDM\Joomla\Componentbuilder\Package\Builder\Get as Superpower;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Componentbuilder\Utilities\RepoHelper;
use VDM\Joomla\Componentbuilder\Abstraction\Console\Package;


/**
 * Base Package Builder Get Command (Shared CLI infrastructure).
 * 
 * Provides:
 * - Consistent CLI options (items/repo/force/validate)
 * - Robust item parsing (inline, JSON, file, env fallback)
 * - Repo parsing (inline JSON, file, env fallback)
 * - Standard result rendering
 * - Safe exception handling and exit codes
 * 
 * Concrete commands MUST define:
 * - protected const ENTITY
 * 
 * @since  5.1.4
 */
abstract class Get extends Package
{
	/**
	 * Environment variable name: repo JSON inline value.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected const ENV_REPO = 'JCB_GET_REPO';

	/**
	 * Environment variable name: repo JSON file path.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected const ENV_REPO_FILE = 'JCB_GET_REPO_FILE';

	/**
	 * Environment variable name: force flag.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected const ENV_FORCE = 'JCB_GET_FORCE';

	/**
	 * Environment variable name: resolve flag.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected const ENV_RESOLVE = 'JCB_GET_RESOLVE';

	/**
	 * The Get service.
	 *
	 * @var   Superpower|null
	 * @since 5.1.4
	 */
	protected ?Superpower $get = null;

	/**
	 * Get the main super power GET class
	 *
	 * @return Superpower
	 *
	 * @throws \RuntimeException          If required services cannot be created from the factory.
	 *
	 * @since  5.1.4
	 */
	protected function get(): Superpower
	{
		if ($this->get !== null)
		{
			return $this->get;
		}

		$this->get = $this->getEntityClass('Package.Builder.Get');

		if ($this->get === null)
		{
			throw new \RuntimeException(
				'Failed to initialize builder get class.'
			);
		}

		return $this->get;
	}

	/**
	 * Register shared CLI options with optional exclusions.
	 *
	 * Supported option keys:
	 * - items
	 * - items-file
	 * - repo
	 * - repo-file
	 * - force
	 * - resolve
	 *
	 * @param  array<string>  $exclude  A list of option keys to exclude.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function addSharedOptions(array $exclude = []): void
	{
		$exclude = array_flip($exclude);

		if (!isset($exclude['items']))
		{
			$this->addOption(
				'items',
				'i',
				InputOption::VALUE_OPTIONAL,
				'Items (GUIDs/identifiers) as CSV, newline-separated, or JSON array. Supports @/path/to/file.'
			);
		}

		if (!isset($exclude['items-file']))
		{
			$this->addOption(
				'items-file',
				null,
				InputOption::VALUE_OPTIONAL,
				'Path to a file containing items (one per line, CSV, or JSON).'
			);
		}

		if (!isset($exclude['repo']))
		{
			$this->addOption(
				'repo',
				'r',
				InputOption::VALUE_OPTIONAL,
				'Repository JSON object. Supports @/path/to/file.'
			);
		}

		if (!isset($exclude['repo-file']))
		{
			$this->addOption(
				'repo-file',
				null,
				InputOption::VALUE_OPTIONAL,
				'Path to a file containing a repository JSON object.'
			);
		}

		if (!isset($exclude['force']))
		{
			$this->addOption(
				'force',
				'f',
				InputOption::VALUE_NONE,
				'Force overwrite/re-fetch (when supported).'
			);
		}

		if (!isset($exclude['resolve']))
		{
			$this->addOption(
				'resolve',
				null,
				InputOption::VALUE_NONE,
				'Non-GUID values are resolved using the entity\'s configured helper key (when supported).'
			);
		}
	}

	/**
	 * Execute the action-specific command logic.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	abstract protected function doExecuteAction(InputInterface $input, OutputInterface $output): int;

	/**
	 * Resolve repo object from CLI options and environment variables.
	 *
	 * Priority (highest -> lowest):
	 * - --repo
	 * - --repo-file
	 * - ENV (JCB_GET_REPO)
	 * - ENV file (JCB_GET_REPO_FILE)
	 *
	 * Supports:
	 * - Inline JSON object
	 * - Inline GUID
	 * - @/path/to/file JSON or GUID
	 *
	 * If a GUID is provided, it will be resolved locally first and then remotely.
	 * If resolution fails, a warning is recorded and null is returned.
	 *
	 * @param   InputInterface  $input  The input.
	 *
	 * @return  object|null
	 * @since   5.1.4
	 */
	protected function resolveRepo(InputInterface $input): ?object
	{
		$inline = (string) ($input->getOption('repo') ?? '');
		$file   = (string) ($input->getOption('repo-file') ?? '');

		if ($inline === '')
		{
			$inline = (string) getenv(static::ENV_REPO);
		}

		if ($file === '')
		{
			$file = (string) getenv(static::ENV_REPO_FILE);
		}

		// Inline supports @file syntax
		if ($inline !== '' && str_starts_with($inline, '@'))
		{
			$file   = substr($inline, 1);
			$inline = '';
		}

		if ($inline !== '')
		{
			return $this->resolveRepoValue($inline);
		}

		if ($file !== '')
		{
			$contents = $this->readFileContents($file, 'repo-file');

			return $this->resolveRepoValue($contents);
		}

		return null;
	}

	/**
	 * Resolve a repository value which may be JSON or a GUID.
	 *
	 * @param   string  $raw  Raw repo value.
	 *
	 * @return  object|null
	 * @since   5.1.4
	 */
	protected function resolveRepoValue(string $raw): ?object
	{
		$raw = trim($raw);

		if ($raw === '')
		{
			return null;
		}

		// Raw GUID (not JSON)
		if (GuidHelper::valid($raw))
		{
			return $this->resolveRepoByGuid($raw);
		}

		// JSON may decode to object OR string GUID
		try
		{
			$decoded = $this->decodeRepoJson($raw);
		}
		catch (\Throwable $e)
		{
			// Not JSON, not GUID -> ignore silently
			return null;
		}

		if (is_string($decoded) && GuidHelper::valid($decoded))
		{
			return $this->resolveRepoByGuid($decoded);
		}

		if ($this->validRepo($decoded))
		{
			return $decoded;
		}

		return null;
	}

	/**
	 * Validate the repository.
	 *
	 * @param   object|null   $repository  The repository to validate.
	 *
	 * @return bool True if valid repository
	 * @since   5.1.4
	 */
	protected function validRepo(?object &$repository): bool
	{
		if (!is_object($repository))
		{
			return false;
		}

		$entity = $this->getEntity();

		return $this->get()->validRepo($entity, $repository);
	}

	/**
	 * Resolve a repository by GUID using local/remote lookup.
	 *
	 * @param   string  $guid
	 *
	 * @return  object|null
	 * @since   5.1.4
	 */
	protected function resolveRepoByGuid(string $guid): ?object
	{
		try
		{
			$repository = RepoHelper::getRepo($guid);
		}
		catch (\Throwable $e)
		{
			$repository = null;
		}

		if ($repository === null)
		{
			$this->message->add('warning',
				sprintf('Repository with GUID "%s" could not be resolved and was ignored.', $guid)
			);
		}

		if ($this->validRepo($repository))
		{
			return $repository;
		}

		return null;
	}

	/**
	 * Decode a repository JSON string into an object or GUID string.
	 *
	 * @param   string  $raw  JSON string.
	 *
	 * @return  object|string
	 *
	 * @throws \InvalidArgumentException   If raw string is empty or melformed.
	 * @since   5.1.4
	 */
	protected function decodeRepoJson(string $raw)
	{
		$raw = trim($raw);

		if ($raw === '')
		{
			throw new \InvalidArgumentException('Repository JSON is empty.');
		}

		$decoded = json_decode($raw);

		if (json_last_error() !== JSON_ERROR_NONE)
		{
			throw new \InvalidArgumentException('Invalid repository JSON provided.');
		}

		if (is_string($decoded))
		{
			return $decoded;
		}

		if (is_array($decoded))
		{
			return (object) $decoded;
		}

		if (!is_object($decoded))
		{
			throw new \InvalidArgumentException('Repository JSON must decode to an object or GUID string.');
		}

		return $decoded;
	}

	/**
	 * Resolve the "force" flag from CLI or env.
	 *
	 * @param   InputInterface  $input  The input.
	 *
	 * @return  bool
	 * @since   5.1.4
	 */
	protected function resolveForce(InputInterface $input): bool
	{
		if ((bool) $input->getOption('force'))
		{
			return true;
		}

		$env = (string) getenv(static::ENV_FORCE);

		return $this->toBool($env);
	}

	/**
	 * Resolve the "validate" flag from CLI or env.
	 *
	 * @param   InputInterface  $input  The input.
	 *
	 * @return  bool
	 * @since   5.1.4
	 */
	protected function resolveValidate(InputInterface $input): bool
	{
		if ((bool) $input->getOption('resolve'))
		{
			return true;
		}

		$env = (string) getenv(static::ENV_RESOLVE);

		return $this->toBool($env);
	}

	/**
	 * Render standard categorized results.
	 *
	 * Expected format:
	 * array{
	 *   local: array<string,string>,
	 *   not_found: array<string,string>,
	 *   added: array<string,string>
	 * }
	 *
	 * @param   string  $title    The title.
	 * @param   array   $results  The results.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function renderCategorizedResults(string $title, array $results): void
	{
		$this->io->title($title);

		$local    = (array) ($results['local'] ?? []);
		$notFound = (array) ($results['not_found'] ?? []);
		$added    = (array) ($results['added'] ?? []);

		$this->io->definitionList(
			['Entity' => $this->getEntity()],
			['Local' => count($local)],
			['Added' => count($added)],
			['Not Found' => count($notFound)]
		);

		foreach (['added' => $added, 'local' => $local, 'not_found' => $notFound] as $section => $bucket)
		{
			if ($bucket === [])
			{
				continue;
			}

			$this->io->section(ucfirst(str_replace('_', ' ', $section)));

			// Keep output readable in terminals (still complete enough for debugging).
			$shown = 0;
			foreach ($bucket as $guid => $label)
			{
				$this->io->writeln(' - ' . $guid . (is_string($label) && $label !== '' ? (': ' . $label) : ''));
				$shown++;

				if ($shown >= 1000)
				{
					$this->io->writeln(' - … output truncated (1000 entries shown)');
					break;
				}
			}
		}
	}

	/**
	 * Convert common truthy strings to boolean.
	 *
	 * @param   string  $value  The value.
	 *
	 * @return  bool
	 * @since   5.1.4
	 */
	protected function toBool(string $value): bool
	{
		$value = strtolower(trim($value));

		return in_array($value, ['1', 'true', 'yes', 'on'], true);
	}
}

