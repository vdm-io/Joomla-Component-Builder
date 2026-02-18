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

namespace VDM\Joomla\Componentbuilder\Abstraction\Console;


use Joomla\CMS\Factory;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Componentbuilder\Package\MessageBus;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Componentbuilder\FactoryTrait;
use VDM\Joomla\Abstraction\Console;


/**
 * Base Package Builder Command (Shared CLI infrastructure).
 * 
 * Provides:
 * - Consistent CLI options
 * - Robust item parsing (inline, JSON, file, env fallback)
 * - Standard result rendering
 * - Safe exception handling and exit codes
 * 
 * Concrete commands MUST define:
 * - protected const ENTITY
 * 
 * @since  5.1.4
 */
abstract class Package extends Console
{
	/**
	 * The factory trait methods
	 * @since 5.1.4
	 */
	use FactoryTrait;

	/**
	 * The component option (com_example).
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected const COMPONENT_OPTION = 'com_componentbuilder';

	/**
	 * Environment variable name: items inline value.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected const ENV_ITEMS = 'JCB_GET_ITEMS';

	/**
	 * Environment variable name: items file path.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	protected const ENV_ITEMS_FILE = 'JCB_GET_ITEMS_FILE';

	/**
	 * The SymfonyStyle IO helper.
	 *
	 * @var   SymfonyStyle
	 * @since 5.1.4
	 */
	protected SymfonyStyle $io;

	/**
	 * The Item Data class.
	 *
	 * @var   Item
	 * @since 5.1.4
	 */
	protected Item $item;

	/**
	 * The Message Bus service.
	 *
	 * @var   MessageBus|null
	 * @since 5.1.4
	 */
	protected ?MessageBus $message = null;

	/**
	 * Base command constructor.
	 *
	 * @param string $name    The full command name (e.g. component:init:field)
	 * @param string $entity  The entity key handled by this command.
	 * @param Item   $item    The power item that can get and set items locally and remotely.
	 *
	 * @since 5.1.4
	 */
	public function __construct(string $name, string $entity, Item $item)
	{
		if ($name === '')
		{
			throw new \InvalidArgumentException('Command name may not be empty.');
		}

		if ($entity === '')
		{
			throw new \InvalidArgumentException('Entity may not be empty.');
		}

		$this->setEntity($entity);

		// Make sure we know what component we are working with
		Helper::setOption(static::COMPONENT_OPTION);

		// Load administrator language file for backend
		$lang = Factory::getApplication()->getLanguage();
		$lang->load(static::COMPONENT_OPTION, JPATH_ADMINISTRATOR);

		// load the item class
		$this->item = $item;

		// This is the canonical Joomla/Symfony way to set the command name
		parent::__construct($name);

		// Optional but keeps reflection-based tooling consistent
		static::$defaultName = $name;
	}

	/**
	 * Initialize common Joomla CLI context and services.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function initialize(InputInterface $input, OutputInterface $output): void
	{
		$this->io  ??= new SymfonyStyle($input, $output);
	}

	/**
	 * Register shared CLI options with optional exclusions.
	 *
	 * Supported option keys:
	 * - items
	 * - items-file
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
	}

	/**
	 * Execute wrapper with consistent exception handling.
	 *
	 * @param   InputInterface   $input   The input to inject into the command.
	 * @param   OutputInterface  $output  The output to inject into the command.
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	final protected function doExecute(InputInterface $input, OutputInterface $output): int
	{
		$this->initialize($input, $output); // just in-case

		try
		{
			$status = (int) $this->doExecuteAction($input, $output);
		}
		catch (\InvalidArgumentException $e)
		{
			$this->io->error($e->getMessage());

			$status = 1;
		}
		catch (\Throwable $e)
		{
			$this->io->error('An unexpected error occurred.');
			$this->io->writeln($e->getMessage());

			$status = 2;
		}

		// Flush message bus to CLI
		if (!$this->renderMessageBus() && $status === 0)
		{
			$this->io->success('Task completed with no additional messages.');
		}

		return $status;
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
	 * Resolve and return the entity-scoped message bus.
	 *
	 * This method provides access to the message bus responsible for dispatching
	 * domain events, commands, or internal messages within the entity boundary.
	 *
	 * Characteristics:
	 * - Lazily resolved via the entity factory.
	 * - Cached for the lifetime of the current execution context.
	 * - Guaranteed to be fully initialized and non-transient.
	 *
	 * The message bus returned by this method must be safe to use for immediate
	 * dispatch operations and must not represent a partially constructed or
	 * deferred service.
	 *
	 * @return MessageBus  The resolved and cached message bus instance.
	 *
	 * @throws \InvalidArgumentException If the message bus service is not registered or resolves to null.
	 *
	 * @since  5.1.4
	 */
	protected function getMessageBus(): MessageBus
	{
		if ($this->message !== null)
		{
			return $this->message;
		}

		$this->message = $this->getEntityClass('Package.Message');

		if ($this->message === null)
		{
			throw new \InvalidArgumentException('The message bus service was not found.');
		}

		return $this->message;
	}


	/**
	 * Render Message Bus contents to the CLI output.
	 *
	 * Supported message types:
	 * - success
	 * - warning
	 * - error
	 *
	 * @return bool    true when there was output
	 * @since  5.1.4
	 */
	protected function renderMessageBus(): bool
	{
		$hasOutput = false;

		$success = (array) $this->getMessageBus()->get('success');
		if ($success !== [])
		{
			$hasOutput = true;
			foreach ($success as $message)
			{
				$this->io->success($message);
			}
		}

		$warnings = (array) $this->getMessageBus()->get('warning');
		if ($warnings !== [])
		{
			$hasOutput = true;
			foreach ($warnings as $message)
			{
				$this->io->warning($message);
			}
		}

		$errors = (array) $this->getMessageBus()->get('error');
		if ($errors !== [])
		{
			$hasOutput = true;
			foreach ($errors as $message)
			{
				$this->io->error($message);
			}
		}

		return $hasOutput;
	}

	/**
	 * Resolve items from CLI options and environment variables.
	 *
	 * Priority (highest -> lowest):
	 * - --items
	 * - --items-file
	 * - ENV (JCB_GET_ITEMS)
	 * - ENV file (JCB_GET_ITEMS_FILE)
	 *
	 * Supports:
	 * - CSV: a,b,c
	 * - Newlines: one per line
	 * - JSON array: ["a","b"]
	 * - File containing any of the above
	 *
	 * @param   InputInterface  $input  The input.
	 *
	 * @return  array
	 * @since   5.1.4
	 */
	protected function resolveItems(InputInterface $input): array
	{
		$inline = (string) ($input->getOption('items') ?? '');
		$file   = (string) ($input->getOption('items-file') ?? '');

		if ($inline === '')
		{
			$inline = (string) getenv(static::ENV_ITEMS);
		}

		if ($file === '')
		{
			$file = (string) getenv(static::ENV_ITEMS_FILE);
		}

		$values = [];

		// Inline supports @file syntax.
		if ($inline !== '' && str_starts_with($inline, '@'))
		{
			$file = substr($inline, 1);
			$inline = '';
		}

		if ($inline !== '')
		{
			$values = array_merge($values, $this->parseItemsString($inline));
		}

		if ($file !== '')
		{
			$contents = $this->readFileContents($file, 'items-file');
			$values   = array_merge($values, $this->parseItemsString($contents));
		}

		$values = $this->normalizeStringList($values);

		return $values;
	}

	/**
	 * Parse items from a string that may be CSV/newlines/JSON.
	 *
	 * @param   string  $raw  The raw string.
	 *
	 * @return  array
	 * @since   5.1.4
	 */
	protected function parseItemsString(string $raw): array
	{
		$raw = trim($raw);

		if ($raw === '')
		{
			return [];
		}

		// Try JSON first (array OR object with items property).
		$decoded = json_decode($raw, true);

		if (json_last_error() === JSON_ERROR_NONE)
		{
			if (is_array($decoded))
			{
				// If associative with items, accept that too.
				if ($this->isAssoc($decoded) && isset($decoded['items']) && is_array($decoded['items']))
				{
					return $decoded['items'];
				}

				// If plain list.
				if (!$this->isAssoc($decoded))
				{
					return $decoded;
				}
			}
		}

		// Fallback: split on commas or newlines.
		$raw = str_replace(["\r\n", "\r"], "\n", $raw);

		// If commas exist, treat as CSV (still handles single value).
		if (str_contains($raw, ','))
		{
			return explode(',', $raw);
		}

		// Otherwise one-per-line.
		return explode("\n", $raw);
	}

	/**
	 * Read file contents safely.
	 *
	 * @param   string  $path        The file path.
	 * @param   string  $optionName  The related option name (for error messages).
	 *
	 * @return  string
	 * @since   5.1.4
	 */
	protected function readFileContents(string $path, string $optionName): string
	{
		$path = trim($path);

		if ($path === '')
		{
			throw new \InvalidArgumentException("The --{$optionName} value is empty.");
		}

		if (!is_file($path) || !is_readable($path))
		{
			throw new \InvalidArgumentException("Unable to read file for --{$optionName}: {$path}");
		}

		$contents = file_get_contents($path);

		if ($contents === false)
		{
			throw new \InvalidArgumentException("Failed to read file for --{$optionName}: {$path}");
		}

		return $contents;
	}

	/**
	 * Normalize a list of strings: trim, drop empties, de-duplicate.
	 *
	 * @param   array  $values  The values.
	 *
	 * @return  array
	 * @since   5.1.4
	 */
	protected function normalizeStringList(array $values): array
	{
		$out = [];

		foreach ($values as $value)
		{
			$value = trim((string) $value);

			if ($value !== '')
			{
				$out[] = $value;
			}
		}

		$out = array_values(array_unique($out));

		return $out;
	}

	/**
	 * Check if array is associative.
	 *
	 * @param   array  $array  The array.
	 *
	 * @return  bool
	 * @since   5.1.4
	 */
	protected function isAssoc(array $array): bool
	{
		if ($array === [])
		{
			return false;
		}

		return array_keys($array) !== range(0, count($array) - 1);
	}
}

