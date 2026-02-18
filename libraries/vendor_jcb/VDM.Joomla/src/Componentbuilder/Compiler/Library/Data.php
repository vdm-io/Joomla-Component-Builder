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

namespace VDM\Joomla\Componentbuilder\Compiler\Library;


use Joomla\Database\DatabaseInterface;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Field\Data as FieldData;
use VDM\Joomla\Componentbuilder\Compiler\Model\Filesfolders;
use VDM\Joomla\Componentbuilder\Package\Builder\Get as Superpower;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GuidHelper;


/**
 * Library Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Field Data
	 *
	 * @var    FieldData
	 * @since 3.2.0
	 */
	protected FieldData $field;

	/**
	 * Compiler Files Folders
	 *
	 * @var    Filesfolders
	 * @since 3.2.0
	 */
	protected Filesfolders $filesFolders;

	/**
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 **/
	protected DatabaseInterface $db;

	/**
	 * The Super Class.
	 *
	 * @var   Superpower
	 * @since 5.1.4
	 */
	protected Superpower $superpower;

	/**
	 * The state of retry to loaded fields
	 *
	 * @var    array
	 * @since  5.1.4
	 **/
	protected array $retry = [];

	/**
	 * Constructor
	 *
	 * @param Config              $config         The compiler config object.
	 * @param Registry            $registry       The compiler registry object.
	 * @param Customcode          $customcode     The compiler customcode object.
	 * @param Gui                 $gui            The compiler customcode gui.
	 * @param FieldData           $field          The compiler field data object.
	 * @param Filesfolders        $filesFolders   The compiler files folders object.
	 * @param DatabaseInterface   $db             The Joomla Database Class.
	 * @param Superpower          $superpower     A Superpower Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Registry $registry,
		Customcode $customcode = null, Gui $gui,
		FieldData $field, Filesfolders $filesFolders,
		DatabaseInterface $db, Superpower $superpower)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->field = $field;
		$this->filesFolders = $filesFolders;
		$this->db = $db;
		$this->superpower = $superpower;
	}

	/**
	 * Get Media Library Data and store globally in registry.
	 *
	 * @param   string  $guid  The library GUID.
	 *
	 * @return  object|bool
	 * @since   5.1.4
	 */
	public function get(string $guid)
	{
		if (!GuidHelper::valid($guid))
		{
			return false;
		}

		// If already resolved, return immediately
		if ($this->registry->exists("builder.libraries.$guid"))
		{
			return $this->registry->get("builder.libraries.$guid", false);
		}

		// Handle static / baseline libraries
		if ($this->handleStaticLibraries($guid))
		{
			$this->registry->set("builder.libraries.$guid", false);
			return false;
		}

		// Attempt local database load
		$library = $this->loadLibraryFromDatabase($guid);

		// If not found locally, try remote superpower fetch (once)
		if ($library === null && $this->attemptRemoteFetch($guid))
		{
			// Retry after remote fetch
			return $this->get($guid);
		}

		// Still not found -> cache failure
		if ($library === null)
		{
			$this->registry->set("builder.libraries.$guid", false);
			return false;
		}

		// Process and register library
		$result = $this->processLibrary($library);

		$this->registry->set("builder.libraries.$guid", $result);

		return $result;
	}

	/**
	 * Process a loaded library definition.
	 *
	 * @param   object  $library
	 *
	 * @return  object|bool
	 * @since   5.1.4
	 */
	protected function processLibrary(object $library)
	{
		$this->applyBuildInFallback($library);

		if ((int) $library->how <= 0)
		{
			return false;
		}

		$this->filesFolders->set($library);

		if ((int) $library->how > 1)
		{
			$this->applyConfigFields($library);
		}

		if ((int) $library->how === 3)
		{
			$this->applyPhpDocument($library);
		}
		elseif ((int) $library->how === 2)
		{
			$this->applyConditions($library);
		}

		unset(
			$library->php_setdocument,
			$library->addconditions,
			$library->addconfig
		);

		return $library;
	}

	/**
	 * Apply built-in fallback behaviour for libraries that map to
	 * compiler-level features (UIkit, FooTable, etc.).
	 *
	 * This method mutates the library object by reference.
	 *
	 * @param   object  $library  The library object loaded from the database.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function applyBuildInFallback(object $library): void
	{
		// Only libraries explicitly marked for built-in handling
		if ((int) $library->how !== 4)
		{
			return;
		}

		/**
		 * Built-in fallback mappings.
		 *
		 * Library ID => config changes
		 */
		$buildin = [
			3 => ['uikit' => 3],                         // UIkit v3
			4 => ['uikit' => 1],                         // UIkit v2
			5 => ['footable_version' => 2, 'footable' => true], // FooTable v2
			6 => ['footable_version' => 3, 'footable' => true], // FooTable v3
		];

		// Apply built-in configuration if available
		if (isset($buildin[$library->id])
			&& ArrayHelper::check($buildin[$library->id]))
		{
			foreach ($buildin[$library->id] as $key => $value)
			{
				$this->config->set($key, $value);
			}

			// Built-in fallback replaces dynamic loading
			$library->how = 0;
		}
		else
		{
			// No built-in mapping found: force dynamic loading
			$library->how = 1;
		}
	}

	/**
	 * Apply dynamic configuration fields to the library.
	 *
	 * This resolves the library configuration fields and attaches the
	 * fully processed configuration array to the library object.
	 *
	 * @param   object  $library  The library object.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function applyConfigFields(object $library): void
	{
		$library->addconfig = (
			isset($library->addconfig)
			&& JsonHelper::check($library->addconfig)
		)
			? json_decode((string) $library->addconfig, true)
			: null;

		if (!ArrayHelper::check($library->addconfig))
		{
			return;
		}

		$library->config = array_map(
			function (array $array) {
				$array['alias']    = 0;
				$array['title']    = 0;
				$array['settings'] = $this->field->get($array['field']);

				return $array;
			},
			array_values($library->addconfig)
		);
	}

	/**
	 * Apply custom PHP document logic for GUI-controlled libraries.
	 *
	 * This decodes, updates, and registers the PHP document code
	 * via the GUI service.
	 *
	 * @param   object  $library  The library object.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function applyPhpDocument(object $library): void
	{
		if (
			!isset($library->php_setdocument)
			|| !StringHelper::check($library->php_setdocument)
		)
		{
			return;
		}

		$library->document = $this->gui->set(
			$this->customcode->update(
				base64_decode((string) $library->php_setdocument)
			),
			[
				'table' => 'library',
				'field' => 'php_setdocument',
				'id'    => (int) $library->id,
				'type'  => 'php',
			]
		);
	}

	/**
	 * Apply conditional loading rules to the library.
	 *
	 * This decodes and normalizes the library conditions array.
	 *
	 * @param   object  $library  The library object.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	protected function applyConditions(object $library): void
	{
		$library->addconditions = (
			isset($library->addconditions)
			&& JsonHelper::check($library->addconditions)
		)
			? json_decode((string) $library->addconditions, true)
			: null;

		if (!ArrayHelper::check($library->addconditions))
		{
			return;
		}

		$library->conditions = array_values($library->addconditions);
	}

	/**
	 * Handle static or baseline libraries that must not be loaded dynamically.
	 *
	 * @param   string  $guid
	 *
	 * @return  int   1+ to block loading, 0 to continue
	 * @since   5.1.4
	 */
	protected function handleStaticLibraries(string $guid): int
	{
		$uikit = (int) $this->config->get('uikit', 0);
		$footable = (int) $this->config->get('footable_version', 0);

		switch ($guid)
		{
			case 'bc8e675d-7536-4a68-b186-fb4b988fa3e2': // No Library
				return 1;

			case '5eeee148-cebd-4a92-bc0e-56efea3cffdc': // UIkit v3
				if ($uikit === 2 || $uikit === 3)
				{
					return 2;
				}
				break;

			case '367fbf66-890e-42a7-a82d-f780d2f86786': // UIkit v2
				if ($uikit === 1 || $uikit === 2)
				{
					return 3;
				}
				break;

			case 'a90edd5a-8521-4fb1-b6b3-9a21e9f56642': // FooTable v2
				if ($footable === 2)
				{
					return 4;
				}
				break;

			case '86829029-dc8a-424e-b046-b189a92565d9': // FooTable v3
				if ($footable === 3)
				{
					return 5;
				}
				break;
		}

		return 0;
	}

	/**
	 * Load a library definition from the database.
	 *
	 * @param   string  $guid
	 *
	 * @return  object|null
	 * @since   5.1.4
	 */
	protected function loadLibraryFromDatabase(string $guid): ?object
	{
		$query = $this->db->getQuery(true)
			->select('a.*')
			->select(
				$this->db->quoteName(
					[
						'a.id', 'a.name', 'a.how', 'a.type',
						'a.addconditions', 'b.addconfig',
						'c.addfiles', 'c.addfolders',
						'c.addfilesfullpath', 'c.addfoldersfullpath',
						'c.addurls', 'a.php_setdocument'
					]
				)
			)
			->from('#__componentbuilder_library AS a')
			->join('LEFT', '#__componentbuilder_library_config AS b ON a.guid = b.library')
			->join('LEFT', '#__componentbuilder_library_files_folders_urls AS c ON a.guid = c.library')
			->where('a.guid = ' . $this->db->quote($guid))
			->where('a.target = 1');

		$this->db->setQuery($query);

		$library = $this->db->loadObject();

		return is_object($library) ? $library : null;
	}

	/**
	 * Attempt a one-time remote fetch via Superpower.
	 *
	 * @param   string  $guid
	 *
	 * @return  bool
	 * @since   5.1.4
	 */
	protected function attemptRemoteFetch(string $guid): bool
	{
		if (!empty($this->retry[$guid]))
		{
			return false;
		}

		$this->retry[$guid] = true;

		$result = $this->superpower->get('library', [$guid]);

		return !empty($result['added'][$guid]);
	}
}

