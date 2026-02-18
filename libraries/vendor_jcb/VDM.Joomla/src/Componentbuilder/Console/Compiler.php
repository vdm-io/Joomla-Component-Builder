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

namespace VDM\Joomla\Componentbuilder\Console;


use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Installer\Installer;
use Joomla\CMS\Installer\InstallerHelper;
use Joomla\CMS\Version;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use VDM\Joomla\Componentbuilder\Compiler\Factory as JCB;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Abstraction\Console;


/**
 * Compiler Command (CLI infrastructure for the compiler).
 * 
 * Provides:
 * - Consistent compiler CLI options (GUI parity)
 * - Component GUID resolution (inline, JSON, file, env fallback)
 * - Compiler option normalization into Joomla input (underscore keys)
 * - Optional bundle options support (JSON or @file)
 * - Strict allowed-value validation for known radio/list fields
 * - Flushes both MessageBus messages and Joomla application message queue to terminal
 * - Safe exception handling and stable exit codes
 * 
 * @since  5.1.4
 */
final class Compiler extends Console
{
	/**
	 * The component option (com_example).
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	private const COMPONENT_OPTION = 'com_componentbuilder';

	/**
	 * Environment variable for a single component GUID.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	private const ENV_COMPONENT = 'JCB_COMPILE_COMPONENT';

	/**
	 * Environment variable for components list (CSV/newlines/JSON).
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	private const ENV_COMPONENTS = 'JCB_COMPILE_COMPONENTS';

	/**
	 * Environment variable for components file path.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	private const ENV_COMPONENTS_FILE = 'JCB_COMPILE_COMPONENTS_FILE';

	/**
	 * Environment variable for options bundle (JSON or @file).
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	private const ENV_OPTIONS = 'JCB_COMPILER_OPTIONS';

	/**
	 * Environment variable to trigger auto install of compiled extentions.
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	private const ENV_INSTALL = 'JCB_COMPILE_INSTALL';

	/**
	 * Per-option environment prefix (e.g. JCB_BACKUP=1).
	 *
	 * @var   string
	 * @since 5.1.4
	 */
	private const ENV_PREFIX = 'JCB_';

	/**
	 * The SymfonyStyle IO helper (HUMAN OUTPUT -> STDERR).
	 *
	 * @var   SymfonyStyle
	 * @since 5.1.4
	 */
	private SymfonyStyle $ioStyle;

	/**
	 * Stores the Input Object
	 * @var InputInterface
	 * @since 4.0.0
	 */
	private $cliInput;
    
	/**
	 * STDOUT stream (MACHINE OUTPUT).
	 *
	 * @var   OutputInterface
	 * @since 5.1.4
	 */
	private OutputInterface $stdout;

	/**
	 * STDERR stream (HUMAN OUTPUT).
	 *
	 * @var   OutputInterface
	 * @since 5.1.4
	 */
	private OutputInterface $stderr;

	/**
	 * The messages.
	 *
	 * @var   array<int, string>
	 * @since 5.1.4
	 */
	private array $messages = [];

	/**
	 * Collected machine-output paths.
	 *
	 * @var   array<int, string>
	 * @since 5.1.4
	 */
	private array $outputPaths = [];

	/**
	 * Auto install switch
	 *
	 * @var     bool
	 * @since 5.1.4
	 */
	private bool $autoInstall;

	/**
	 * The Item class
	 *
	 * @var     Item
	 * @since 5.1.4
	 */
	private Item $item;

	/**
	 * Command constructor.
	 *
	 * @param  string  $name  The full command name (e.g. component:compile)
	 * @param  Item    $item  The power item that can get and set items locally and remotely.
	 *
	 * @since  5.1.4
	 */
	public function __construct(string $name, Item $item)
	{
		if ($name === '')
		{
			throw new \InvalidArgumentException('Command name may not be empty.');
		}

		// Component context for CLI execution
		Helper::setOption(static::COMPONENT_OPTION);

		// Load administrator language file for backend
		$lang = Factory::getApplication()->getLanguage();
		$lang->load(static::COMPONENT_OPTION, JPATH_ADMINISTRATOR);

		// load the item class
		$this->item = $item;

		parent::__construct($name);

		// Keeps reflection-based tooling consistent
		static::$defaultName = $name;
	}

	/**
	 * Initialize common Joomla CLI context and IO helper.
	 *
	 * IMPORTANT:
	 * - STDOUT = machine output (pipe-safe)
	 * - STDERR = human messages
	 *
	 * @param   InputInterface   $input
	 * @param   OutputInterface  $output
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function initialize(InputInterface $input, OutputInterface $output): void
	{
		$this->stdout ??= $output;
		$this->stderr ??= $output->getErrorOutput();
		$this->cliInput = $input;

		// SymfonyStyle must NEVER write to STDOUT
		$this->ioStyle ??= new SymfonyStyle($input, $this->stderr);
	}

	/**
	 * Configure the command.
	 *
	 * NOTE:
	 * - Component selection is required, but may be provided via multiple mechanisms.
	 * - All compiler options are optional; omitted options imply GLOBAL behavior downstream.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function configure(): void
	{
		$this->setDescription('Compile a component using the JCB compiler via CLI.');

		$this->setHelp(
<<<'EOF'
Compile a component using the JCB compiler via CLI.

Component inputs (at least one is required):
  --component / -c         Single component GUID
  --components             CSV/newline/JSON list of component GUIDs
  --components-file        Path to file containing components (CSV/newlines/JSON)
  --components=@/path      Shorthand file syntax via --components option

Options bundle:
  --options / -o           JSON object or @/path/to/file (merged; explicit CLI flags override)

Environment fallbacks:
  JCB_COMPILE_COMPONENT
  JCB_COMPILE_COMPONENTS
  JCB_COMPILE_COMPONENTS_FILE
  JCB_COMPILER_OPTIONS
  JCB_COMPILE_INSTALL

Per-option environment variables:
  JCB_BACKUP
  JCB_REPOSITORY
  JCB_ADD_PLACEHOLDERS
  JCB_DEBUG_LINE_NR
  JCB_MINIFY
  JCB_POWERS
  JCB_JOOMLA_VERSION
  JCB_POWERS_REPOSITORY
  JCB_INDENTATION_VALUE
  JCB_ADD_BUILD_DATE
  JCB_BUILD_DATE

Notes:
  - Options are injected into Joomla input using underscore keys (e.g. add_placeholders).
  - If an option is not provided, it is not set (GLOBAL behavior is handled downstream).
EOF
		);

		$this->addOption(
			'component',
			'c',
			InputOption::VALUE_OPTIONAL,
			'Single component GUID. ENV fallback: ' . static::ENV_COMPONENT
		);

		$this->addOption(
			'components',
			null,
			InputOption::VALUE_OPTIONAL,
			'Components list as CSV/newlines/JSON. Supports @/path/to/file. ENV fallback: ' . static::ENV_COMPONENTS
		);

		$this->addOption(
			'components-file',
			null,
			InputOption::VALUE_OPTIONAL,
			'Path to file containing components (CSV/newlines/JSON). ENV fallback: ' . static::ENV_COMPONENTS_FILE
		);

		// GUI parity options
		$this->addSharedOptions();
	}

	/**
	 * Register shared CLI options derived from the Builder dynamic form.
	 *
	 * @param  array<string>  $exclude  A list of option keys to exclude.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function addSharedOptions(): void
	{
		$this->addOption(
			'backup',
			'b',
			InputOption::VALUE_NONE,
			'Add compiled package to backup and sales server. ENV fallback: JCB_BACKUP'
		);

		$this->addOption(
			'repository',
			'r',
			InputOption::VALUE_NONE,
			'Move compiled component to local repository folder. ENV fallback: JCB_REPOSITORY'
		);

		$this->addOption(
			'add-placeholders',
			null,
			InputOption::VALUE_OPTIONAL,
			'Insert custom code placeholders. Values: 2=global, 1=yes, 0=no. ENV fallback: JCB_ADD_PLACEHOLDERS'
		);

		$this->addOption(
			'debug-line-nr',
			null,
			InputOption::VALUE_OPTIONAL,
			'Add compiler debug line numbers. Values: 2=global, 1=yes, 0=no. ENV fallback: JCB_DEBUG_LINE_NR'
		);

		$this->addOption(
			'minify',
			'm',
			InputOption::VALUE_OPTIONAL,
			'Minify JavaScript output. Values: 2=global, 1=yes, 0=no. ENV fallback: JCB_MINIFY'
		);

		$this->addOption(
			'powers',
			'p',
			InputOption::VALUE_OPTIONAL,
			'Add powers linked to the component. Values: 2=global, 1=yes, 0=no. ENV fallback: JCB_POWERS'
		);

		$this->addOption(
			'joomla-version',
			'j',
			InputOption::VALUE_OPTIONAL,
			'Target Joomla version. Allowed: 3, 4, 5, 6 (default: ' . Version::MAJOR_VERSION . '). ENV fallback: JCB_JOOMLA_VERSION'
		);

		$this->addOption(
			'powers-repository',
			null,
			InputOption::VALUE_OPTIONAL,
			'Activate Super Powers repository sync. Values: 2=global, 1=yes, 0=no. ENV fallback: JCB_POWERS_REPOSITORY'
		);

		$this->addOption(
			'indentation-value',
			null,
			InputOption::VALUE_OPTIONAL,
			'Indentation style. Values: 1=tab, 2=two spaces, 4=four spaces. ENV fallback: JCB_INDENTATION_VALUE'
		);

		$this->addOption(
			'add-build-date',
			null,
			InputOption::VALUE_OPTIONAL,
			'Build date mode. Values: 1=default, 2=manual, 3=component. ENV fallback: JCB_ADD_BUILD_DATE'
		);

		$this->addOption(
			'build-date',
			'd',
			InputOption::VALUE_OPTIONAL,
			'Manual build date (YYYY-MM-DD). ENV fallback: JCB_BUILD_DATE'
		);

		// Options bundle (JSON or @file)
		$this->addOption(
			'options',
			'o',
			InputOption::VALUE_OPTIONAL,
			'Compiler options as JSON or @/path/to/file (merged; explicit CLI flags override). ENV fallback: ' . static::ENV_OPTIONS
		);

		// Options auto install
		$this->addOption(
			'install',
			'i',
			InputOption::VALUE_NONE,
			'Auto install the extension that are compiled. ENV fallback: ' . static::ENV_INSTALL
		);
	}

	/**
	 * Execute wrapper with consistent exception handling.
	 *
	 * @param   InputInterface   $input
	 * @param   OutputInterface  $output
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	final protected function doExecute(InputInterface $input, OutputInterface $output): int
	{
		try
		{
			$this->initialize($input, $output);
			$status = (int) $this->doExecuteAction();
		}
		catch (\InvalidArgumentException $e)
		{
			$this->ioStyle->error($e->getMessage());
			return 1;
		}
		catch (\Throwable $e)
		{
			$this->ioStyle->error('An unexpected error occurred.');
			$this->ioStyle->writeln($e->getMessage());
			return 2;
		}

		// Flush human messages
		$busOut = $this->renderMessageBus();

		if (!$busOut && $status === 0)
		{
			$this->ioStyle->success('Task completed with no additional messages.');
		}

		// Install if compiler was without errors
		if ($status === 0)
		{
			return $this->installExtensions();
		}

		return (int) $status;
	}

	/**
	 * Action-specific compiler logic.
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	protected function doExecuteAction(): int
	{
		$components = $this->resolveComponents();

		if ($components === [])
		{
			throw new \InvalidArgumentException(
				'No component GUID(s) provided. Use --component, --components, --components-file, or environment variables.'
			);
		}

		LayoutHelper::$defaultBasePath =
			JPATH_ADMINISTRATOR . '/components/com_componentbuilder/layouts';

		$this->normalizeCompilerOptions();

		$appInput = $this->getApplication()->getInput();
		$status   = 0;

		foreach ($components as $componentGuid)
		{
			$component = is_numeric($componentGuid)
				? $componentGuid
				: $this->item->table('joomla_component')->value($componentGuid);

			if (!is_numeric($component))
			{
				$this->ioStyle->error('Component GUID "' . $componentGuid . '" not found.');
				$status = 1;
				continue;
			}

			$appInput->post->set('component_id', $component);

			$this->ioStyle->section('Compile Request');
			$this->ioStyle->definitionList(['Component' => $componentGuid]);

			if (!JCB::_('Compiler')->run())
			{
				$this->ioStyle->error('Compiler failed');
				$status = 1;
				JCB::unset();
				continue;
			}

			$message = LayoutHelper::render('jcbbuildersuccessmessagecli');
			$message = JCB::_('Placeholder')->update(
				$message, JCB::_('Compiler.Builder.Content.One')->allActive()
			);

			$this->messages[] = $message;

			$this->collectCompilerPaths();

			JCB::unset();
		}

		return $status;
	}

	/**
	 * Collect compiled file paths from the compiler.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function collectCompilerPaths(): void
	{
		$component = JCB::_('FilePaths')->get('component');
		$modules = JCB::_('FilePaths')->get('modules');
		$plugins = JCB::_('FilePaths')->get('plugins');

		if (!empty($component))
		{
			$this->outputPaths[] = $component;
		}

		if (!empty($modules))
		{
			foreach($modules as $module)
			{
				$this->outputPaths[] = $module;
			}
		}

		if (!empty($plugins))
		{
			foreach($plugins as $plugin)
			{
				$this->outputPaths[] = $plugin;
			}
		}
	}

	/**
	 * Install the compiled extensions 
	 *
	 * @return  int
	 * @since   5.1.4
	 */
	protected function installExtensions(): int
	{
		if (!$this->autoInstall || $this->outputPaths === [])
		{
			return 0;
		}

		$paths = array_values(array_unique($this->outputPaths));
		$tmpPath  = $this->getApplication()->get('tmp_path');

		foreach ($paths as $path)
		{
			if (!$this->processPathInstallation($path, $tmpPath))
			{
				return 2;
			}
		}

		return 0;
	}

	/**
	 * Used for installing extension from a path
	 *
	 * @param   string  $path     Path to the extension zip file
	 * @param   string  $tmpPath  Temp Path of Joomla
	 *
	 * @return boolean
	 * @since  5.1.4
	 * @throws \Exception
	 */
	protected function processPathInstallation(string $path, string $tmpPath): bool
	{
		if (!file_exists($path))
		{
			$this->ioStyle->warning("The extension file path:[{$path}] specified does not exist.");
			return false;
		}

		$package  = InstallerHelper::unpack($path, true);

		if ($package['type'] === false)
		{
			return false;
		}

		$tmp = $tmpPath . '/' . basename($path);

		$jInstaller = Installer::getInstance();
		$result	 = $jInstaller->install($package['extractdir']);
		InstallerHelper::cleanupInstall($tmp, $package['extractdir']);

		return $result;
	}

	/**
	 * Resolve component GUID(s) from CLI / ENV / file / JSON.
	 *
	 * Supports:
	 * - --component GUID
	 * - --components CSV/newlines/JSON
	 * - --components @/path/to/file
	 * - --components-file /path/to/file
	 * - ENV fallbacks
	 *
	 * @return  array<int, string>
	 * @since   5.1.4
	 */
	protected function resolveComponents(): array
	{
		$single = (string) ($this->cliInput->getOption('component') ?? '');
		if ($single === '')
		{
			$single = (string) getenv(static::ENV_COMPONENT);
		}

		$list = (string) ($this->cliInput->getOption('components') ?? '');
		if ($list === '')
		{
			$list = (string) getenv(static::ENV_COMPONENTS);
		}

		$file = (string) ($this->cliInput->getOption('components-file') ?? '');
		if ($file === '')
		{
			$file = (string) getenv(static::ENV_COMPONENTS_FILE);
		}

		$values = [];

		if ($single !== '')
		{
			$values[] = $single;
		}

		// @file shorthand on --components
		if ($list !== '' && str_starts_with($list, '@'))
		{
			$file = substr($list, 1);
			$list = '';
		}

		if ($list !== '')
		{
			$values = array_merge($values, $this->parseStringList($list));
		}

		if ($file !== '')
		{
			$contents = $this->readFileContents($file, 'components-file');
			$values   = array_merge($values, $this->parseStringList($contents));
		}

		return $this->normalizeGuidList($values);
	}

	/**
	 * Normalize compiler options into Joomla input (underscore keys).
	 *
	 * Resolution order:
	 * 1. Per-option ENV variables (JCB_<OPTION>)
	 * 2. Options bundle (--options or ENV JCB_COMPILER_OPTIONS)
	 * 3. Explicit CLI flags (kebab-case)
	 *
	 * GLOBAL semantics:
	 * - If a value is not resolved, it is NOT set.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function normalizeCompilerOptions(): void
	{
		$appInput = $this->getApplication()->getInput();

		$this->autoInstall = false;

		$allowed = [
			'backup'                => 1, // if set then true
			'repository'            => 1, // if set then true
			'install'               => 1, // if set then true
			'add_placeholders'      => ['0', '1', '2'],
			'debug_line_nr'         => ['0', '1', '2'],
			'minify'                => ['0', '1', '2'],
			'powers'                => ['0', '1', '2'],
			'joomla_version'        => ['3', '4', '5', '6'],
			'powers_repository'     => ['0', '1', '2'],
			'indentation_value'     => ['1', '2', '4'],
			'add_build_date'        => ['1', '2', '3'],
			'build_date'            => null, // string date; downstream decides
		];

		$advance = [
			'powers_repository' => true,
			'indentation_value' => true,
			'add_build_date'    => true,
			'build_date'        => true,
		];

		$resolved = [];

		// 1) Per-option ENV fallback
		foreach ($allowed as $uKey => $_)
		{
			if (!isset($resolved[$uKey]))
			{
				$envName = static::ENV_PREFIX . strtoupper($uKey);
				$envVal  = getenv($envName);

				if (!empty($envVal))
				{
					$resolved[$uKey] = (string) $envVal;
				}
			}
		}

		// 2) Bundle JSON (string or @file)
		$bundle = (string) ($this->cliInput->getOption('options') ?? '');
		if ($bundle === '')
		{
			$bundle = (string) getenv(static::ENV_OPTIONS);
		}

		if ($bundle !== '')
		{
			if (str_starts_with($bundle, '@'))
			{
				$bundle = $this->readFileContents(substr($bundle, 1), 'options');
			}

			$data = json_decode($bundle, true);

			if (!is_array($data))
			{
				throw new \InvalidArgumentException('Invalid compiler options JSON (bundle).');
			}

			foreach ($data as $key => $value)
			{
				$key = $this->normalizeOptionKey((string) $key);
				if (array_key_exists($key, $allowed) && !empty($value))
				{
					$resolved[$key] = (string) $value;
				}
			}
		}

		// 3) Explicit CLI flags override bundle
		foreach ($allowed as $uKey => $_)
		{
			$cliKey = str_replace('_', '-', $uKey);
			$val = $this->cliInput->getOption($cliKey);

			if (!empty($val))
			{
				$resolved[$uKey] = (string) $val;
			}
		}

		// Validate + inject
		foreach ($resolved as $uKey => $val)
		{
			$permitted = $allowed[$uKey];

			if (is_numeric($permitted))
			{
				if ($uKey === 'install')
				{
					$this->autoInstall = true;
					continue;
				}
				$appInput->post->set($uKey, (string) $permitted);
				continue;
			}

			if (is_array($permitted) && !in_array($val, $permitted, true))
			{
				throw new \InvalidArgumentException(
					sprintf('Invalid value "%s" for option "%s".', $val, $uKey)
				);
			}

			if (isset($advance[$uKey]))
			{
				$appInput->post->set('show_advanced_options', '1');

				if ($uKey === 'build_date')
				{
					$appInput->post->set('add_build_date', '2');
				}
			}

			$appInput->post->set($uKey, $val);
		}
	}


	/**
	 * Render local message queue to CLI output.
	 *
	 * @return bool
	 * @since  5.1.4
	 */
	protected function renderMessageBus(): bool
	{
		if ($this->messages === [])
		{
			return false;
		}

		foreach ($this->messages as $message)
		{
			$this->ioStyle->success($message);
		}

		return true;
	}

	/**
	 * Normalize list string (CSV/newlines/JSON).
	 *
	 * @param   string  $raw
	 *
	 * @return  array
	 * @since   5.1.4
	 */
	protected function parseStringList(string $raw): array
	{
		$raw = trim($raw);

		if ($raw === '')
		{
			return [];
		}

		$decoded = json_decode($raw, true);

		if (json_last_error() === JSON_ERROR_NONE && is_array($decoded))
		{
			// allow { "components": [...] } or plain list
			if (array_keys($decoded) !== range(0, count($decoded) - 1))
			{
				foreach (['components', 'items'] as $k)
				{
					if (isset($decoded[$k]) && is_array($decoded[$k]))
					{
						return $decoded[$k];
					}
				}

				return array_values($decoded);
			}

			return $decoded;
		}

		$raw = str_replace(["\r\n", "\r"], "\n", $raw);

		if (str_contains($raw, ','))
		{
			return explode(',', $raw);
		}

		return explode("\n", $raw);
	}

	/**
	 * Read file contents safely.
	 *
	 * @param   string  $path
	 * @param   string  $optionName
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
	 * Normalize string(GUID) list: trim, drop empties, de-duplicate.
	 *
	 * @param   array  $values
	 *
	 * @return  array<int, string>
	 * @since   5.1.4
	 */
	protected function normalizeGuidList(array $values): array
	{
		$out = [];

		foreach ($values as $value)
		{
			$value = trim((string) $value);

			if ($value !== '' && GuidHelper::valid($value))
			{
				$out[] = $value;
			}
		}

		return array_values(array_unique($out));
	}

	/**
	 * Normalize an option key to underscore + lowercase.
	 *
	 * @param   string  $key
	 *
	 * @return  string
	 * @since   5.1.4
	 */
	protected function normalizeOptionKey(string $key): string
	{
		$key = trim($key);

		return strtolower(str_replace('-', '_', $key));
	}
}

