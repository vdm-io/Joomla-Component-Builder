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

namespace VDM\Joomla\Componentbuilder\Power\Remote;


use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Interfaces\Readme\ItemInterface as ItemReadme;
use VDM\Joomla\Interfaces\Readme\MainInterface as MainReadme;
use VDM\Joomla\Interfaces\Git\Repository\ContentsInterface as Git;
use VDM\Joomla\Componentbuilder\Power\Parser;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Abstraction\Remote\Set as ExtendingSet;


/**
 * Set Power based on global unique ids to remote repository
 * 
 * @since 5.0.2
 */
final class Set extends ExtendingSet implements SetInterface
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since  5.0.3
	 */
	protected string $table = 'power';

	/**
	 * Area Name
	 *
	 * @var    string
	 * @since  5.0.3
	 */
	protected string $area = 'Super Power';

	/**
	 * Prefix Key
	 *
	 * @var    string
	 * @since  5.0.3
	 */
	protected string $prefix_key = 'Super---';

	/**
	 * The item map
	 *
	 * @var    array
	 * @since  5.0.3
	 */
	protected array $map = [
		'add_head' => 'add_head',
		'description' => 'description',
		'extends' => 'extends',
		'extendsinterfaces' => 'extendsinterfaces',
		'guid' => 'guid',
		'head' => 'head',
		'use_selection' => 'use_selection',
		'implements' => 'implements',
		'load_selection' => 'load_selection',
		'name' => 'name',
		'power_version' => 'power_version',
		'system_name' => 'system_name',
		'type' => 'type',
		'namespace' => 'namespace',
		'composer' => 'composer',
		'add_licensing_template' => 'add_licensing_template',
		'licensing_template' => 'licensing_template',
		'main_class_code' => 'main_class_code'
	];

	/**
	 * The index map
	 *
	 * @var    array
	 * @since  5.0.3
	 */
	protected array $index_map = [
		'name' => 'index_map_IndexName',
		'type' => 'index_map_TypeName',
		'namespace' => 'index_map_NameSpace',
		'code' => 'index_map_CodePath',
		'power' => 'index_map_PowerPath',
		'settings' => 'index_map_IndexSettingsPath',
		'path' => 'index_map_IndexPath',
		'spk' => 'index_map_IndexKey',
		'guid' => 'index_map_IndexGUID'
	];

	/**
	 * The item settings file path
	 *
	 * @var   string
	 * @since  5.0.3
	 */
	protected string $settings_path = 'settings.json';

	/**
	 * The index settings file path
	 *
	 * @var    string
	 * @since  5.0.3
	 */
	protected string $index_settings_path = 'super-powers.json';

	/**
	 * The Parser Class.
	 *
	 * @var   Parser|null
	 * @since 5.0.2
	 */
	protected ?Parser $parser;

	/**
	 * Constructor.
	 *
	 * @param array        $repos               The active repos
	 * @param Grep         $grep                The Grep Class.
	 * @param Items        $items               The Items Class.
	 * @param ItemReadme   $itemReadme          The Item Readme Class.
	 * @param MainReadme   $mainReadme          The Main Readme Class.
	 * @param Git          $git                 The Contents Class.
	 * @param string|null  $table               The table name.
	 * @param string|null  $settingsPath        The settings path.
	 * @param string|null  $settingsIndexPath   The index settings path.
	 * @param Parser|null  $parser              The Parser Class.
	 *
	 * @since 3.2.2
	 */
	public function __construct(array $repos, Grep $grep, Items $items,
		ItemReadme $itemReadme, MainReadme $mainReadme, Git $git,
		?string $table = null, ?string $settingsPath = null,
		?string $settingsIndexPath = null, ?Parser $parser = null)
	{
		parent::__construct($repos, $grep, $items, $itemReadme, $mainReadme,
			$git, $table, $settingsPath, $settingsIndexPath);

		$this->parser = $parser;
	}

	/**
	 * Map a single item value (extends)
	 *
	 * @param object $item  The item to be mapped
	 * @param array  $item  The bucket to to place new values
	 * @param string  $map   The item map to be mapped
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function mapItemValue_extends(object &$item, array &$power): void
	{
		if ($item->type !== 'interface')
		{
			$value = $item->extends ?? '';
			$extends_custom = $item->extends_custom ?? null;
			if ($value == -1 && $extends_custom !== null)
			{
				$power['extends_name'] = ClassfunctionHelper::safe(
					$this->updatePlaceholders((string) $extends_custom)
				);
				$power['extends_custom'] = $extends_custom;
				$power['extends'] = -1;
			}
			elseif (GuidHelper::valid($value))
			{
				$name = GuidHelper::item($value, 'power', 'a.name', 'componentbuilder');
				if ($name !== null)
				{
					$power['extends_name'] = ClassfunctionHelper::safe(
						$this->updatePlaceholders($name)
					);
				}
			}
			else
			{
				$power['extends'] = '';
			}
			// always rest these for normal classes
			$power['extendsinterfaces'] = null;
			$power['extendsinterfaces_custom'] = '';
		}
	}

	/**
	 * Map a single item value (extendsinterfaces)
	 *
	 * @param object $item  The item to be mapped
	 * @param array  $item  The bucket to to place new values
	 * @param string  $map   The item map to be mapped
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function mapItemValue_extendsinterfaces(object &$item, array &$power): void
	{
		if ($item->type === 'interface')
		{
			$values = $item->extendsinterfaces ?? null;
			if (!empty($values))
			{
				$values = (array) $values;
				$extends_names = [];
				$extendsinterfaces_custom = $item->extendsinterfaces_custom ?? null;

				foreach ($values as $value)
				{
					if ($value == -1 && StringHelper::check($extendsinterfaces_custom))
					{
						$extends_names[] = ClassfunctionHelper::safe(
							$this->updatePlaceholders($extendsinterfaces_custom)
						);

						$power['extendsinterfaces_custom'] = $extendsinterfaces_custom;
						$extendsinterfaces_custom = null;
					}
					elseif (GuidHelper::valid($value))
					{
						$name = GuidHelper::item($value, 'power', 'a.name', 'componentbuilder');
						if ($name !== null)
						{
							$extends_names[] = ClassfunctionHelper::safe(
								$this->updatePlaceholders($name)
							);
						}
					}
				}

				if ($extends_names !== [])
				{
					$power['extendsinterfaces'] = array_values($values);
					$power['extends_name'] = implode(', ', $extends_names);
				}
			}
			else
			{
				$power['extendsinterfaces'] = null;
				$power['extendsinterfaces_custom'] = '';
			}
			// always rest these for interfaces
			$power['extends'] = '';
			$power['extends_custom'] = '';
		}
	}

	/**
	 * Map a single item value (use_selection)
	 *
	 * @param object $item  The item to be mapped
	 * @param array  $item  The bucket to to place new values
	 * @param string  $map   The item map to be mapped
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function mapItemValue_use_selection(object &$item, array &$power): void
	{
		$value = $item->use_selection ?? null;
		if (!empty($value))
		{
			$value = (array) $value;
			$power['use_selection'] = $value;
		}
		else
		{
			$power['use_selection'] = null;
		}
	}

	/**
	 * Map a single item value (load_selection)
	 *
	 * @param object $item  The item to be mapped
	 * @param array  $item  The bucket to to place new values
	 * @param string  $map   The item map to be mapped
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function mapItemValue_load_selection(object &$item, array &$power): void
	{
		$value = $item->load_selection ?? null;
		if (!empty($value))
		{
			$value = (array) $value;
			$power['load_selection'] = $value;
		}
		else
		{
			$power['load_selection'] = null;
		}
	}

	/**
	 * Map a single item value (composer)
	 *
	 * @param object $item  The item to be mapped
	 * @param array  $item  The bucket to to place new values
	 * @param string  $map   The item map to be mapped
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function mapItemValue_composer(object &$item, array &$power): void
	{
		$value = $item->composer ?? null;
		if (!empty($value))
		{
			$value = (array) $value;
			$power['composer'] = array_values($value);
		}
		else
		{
			$power['composer'] = '';
		}
	}

	/**
	 * Map a single item value (implements)
	 *
	 * @param object $item  The item to be mapped
	 * @param array  $item  The bucket to to place new values
	 * @param string  $map   The item map to be mapped
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function mapItemValue_implements(object &$item, array &$power): void
	{
		$values = $item->implements ?? '';
		if (!empty($values))
		{
			$values = (array) $values;
			$implement_names = [];
			$implements_custom = $item->implements_custom ?? null;

			foreach ($values as $value)
			{
				if ($value == -1 && StringHelper::check($implements_custom))
				{
					$implement_names[] = ClassfunctionHelper::safe(
						$this->updatePlaceholders($implements_custom)
					);
					$implements_custom = null;
				}
				elseif (GuidHelper::valid($value))
				{
					$name = GuidHelper::item($value, 'power', 'a.name', 'componentbuilder');
					if ($name !== null)
					{
						$implement_names[] = ClassfunctionHelper::safe(
							$this->updatePlaceholders($name)
						);
					}
				}
			}

			if ($implement_names !== [])
			{
				$power['implements'] = array_values($values);
				$power['implement_names'] = $implement_names;
			}
			else
			{
				$power['implements'] = null;
			}
		}
	}

	/**
	 * update an existing item (if changed)
	 *
	 * @param object $item
	 * @param object $existing
	 * @param object $repo
	 *
	 * @return bool
	 * @since  5.0.3
	 */
	protected function updateItem(object $item, object $existing, object $repo): bool
	{
		// make sure there was a change
		$sha = $existing->params->source[$repo->guid . '-settings'] ?? null;
		$_existing = $this->mapItem($existing);

		if ($sha === null || $this->areObjectsEqual($item, $_existing))
		{
			return false;
		}
		else
		{
			// strip these values form the settings
			$code = (string) $item->main_class_code ?? '';
			$extends_name = (string) $item->extends_name ?? '';
			$implement_names = (string) $item->implement_names ?? '';
			unset($item->main_class_code);
			unset($item->extends_name);
			unset($item->implement_names);

			$this->git->update(
				$repo->organisation, // The owner name.
				$repo->repository, // The repository name.
				'src/' . $item->guid . '/' . $this->getSettingsPath(), // The file path.
				json_encode($item, JSON_PRETTY_PRINT), // The file content.
				'Update ' . $item->system_name . ' settings', // The commit message.
				$sha, // The blob SHA of the old file.
				$repo->write_branch // The branch name.
			);

			$item->main_class_code = $code;
			$item->extends_name = $extends_name;
			$item->implement_names = $implement_names;
		}

		return $this->updatePower($item, $existing, $repo);
	}

	/**
	 * update an existing power code (if changed)
	 *
	 * @param object $item
	 * @param object $existing
	 * @param object $repo
	 *
	 * @return bool
	 * @since  5.0.3
	 */
	protected function updatePower(object $item, object $existing, object $repo): bool
	{
		// make sure there was a change
		$sha = $existing->params->source[$repo->guid . '-power'] ?? null;

		if ($sha === null)
		{
			return false;
		}

		// Calculate the new SHA from the current content
		$power = $item->main_class_code ?? '';
		$newSha = sha1("blob " . strlen($power) . "\0" . $power);

		// Check if the new SHA matches the existing SHA
		if ($sha === $newSha)
		{
			return false;
		}

		$this->git->update(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/code.power', // The file path.
			$power, // The file content.
			'Update ' . $item->system_name . ' code', // The commit message.
			$sha, // The blob SHA of the old file.
			$repo->write_branch // The branch name.
		);

		return true;
	}

	/**
	 * create a new item
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return void
	 * @since  5.0.3
	 */
	protected function createItem(object $item, object $repo): void
	{
		// strip these values form the settings
		$code = (string) $item->main_class_code ?? '';
		$extends_name = (string) $item->extends_name ?? '';
		$implement_names = (string) $item->implement_names ?? '';
		unset($item->main_class_code);
		unset($item->extends_name);
		unset($item->implement_names);

		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/' . $this->getSettingsPath(), // The file path.
			json_encode($item, JSON_PRETTY_PRINT), // The file content.
			'Create ' . $item->system_name . ' settings', // The commit message.
			$repo->write_branch // The branch name.
		);

		$item->main_class_code = $code;
		$item->extends_name = $extends_name;
		$item->implement_names = $implement_names;

		$this->createPower($item, $repo);
	}

	/**
	 * create a new power
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return void
	 * @since  5.0.3
	 */
	protected function createPower(object $item, object $repo): void
	{
		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/code.power', // The file path.
			$item->main_class_code, // The file content.
			'Create ' . $item->system_name . ' code', // The commit message.
			$repo->write_branch // The branch name.
		);
	}

	/**
	 * update an existing item readme
	 *
	 * @param object $item
	 * @param object $existing
	 * @param object $repo
	 *
	 * @return void
	 * @since  5.0.3
	 */
	protected function updateItemReadme(object $item, object $existing, object $repo): void
	{
		// make sure there was a change
		$sha = $existing->params->source[$repo->guid . '-readme'] ?? null;
		if ($sha === null)
		{
			return;
		}

		if ($this->parser !== null)
		{
			$item->parsed_class_code = $this->parser->code($item->main_class_code);
		}
		$item->code_name = $this->index_map_IndexName($item);
		$item->_namespace = $this->index_map_NameSpace($item);

		$readme = $this->itemReadme->get($item);
		$newSha = sha1("blob " . strlen($readme) . "\0" . $readme);

		// Check if the new SHA matches the existing SHA
		if ($sha === $newSha)
		{
			return;
		}

		$this->git->update(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/README.md', // The file path.
			$readme, // The file content.
			'Update ' . $item->system_name . ' readme file', // The commit message.
			$sha, // The blob SHA of the old file.
			$repo->write_branch // The branch name.
		);
	}

	/**
	 * create a new item readme
	 *
	 * @param object  $item
	 * @param object  $repo
	 *
	 * @return void
	 * @since  5.0.3
	 */
	protected function createItemReadme(object $item, object $repo): void
	{
		if ($this->parser !== null)
		{
			$item->parsed_class_code = $this->parser->code($item->main_class_code);
		}
		$item->code_name = $this->index_map_IndexName($item);
		$item->_namespace = $this->index_map_NameSpace($item);

		$this->git->create(
			$repo->organisation, // The owner name.
			$repo->repository, // The repository name.
			'src/' . $item->guid . '/README.md', // The file path.
			$this->itemReadme->get($item), // The file content.
			'Create ' . $item->system_name . ' readme file', // The commit message.
			$repo->write_branch // The branch name.
		);
	}

	/**
	 * check that we have a target repo of this item
	 *
	 * @param object  $item  The item
	 * @param object  $repo  The current repo
	 *
	 * @return bool
	 * @since  5.0.3
	 */
	protected function targetRepo(object $item, object $repo): bool
	{
		if (!isset($item->approved) || $item->approved != 1 ||
			!isset($item->approved_paths) || !is_array($item->approved_paths))
		{
			return false;
		}

		$repo_path = "{$repo->organisation}/{$repo->repository}";

		foreach ($item->approved_paths as $approved_path)
		{
			if ($repo_path === $approved_path)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the item name for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function index_map_IndexName(object $item): ?string
	{
		$name = $item->name ?? null;
		if ($name !== null)
		{
			return ClassfunctionHelper::safe(
				$this->updatePlaceholders($name)
			);
		}

		return null;
	}

	/**
	 * Get the item type for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function index_map_TypeName(object $item): ?string
	{
		return $item->type ?? null;
	}

	/**
	 * Get the item code path for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function index_map_CodePath(object $item): ?string
	{
		return $this->index_map_IndexPath($item) . '/code.php';
	}

	/**
	 * Get the item power path for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function index_map_PowerPath(object $item): ?string
	{
		return $this->index_map_IndexPath($item) . '/code.power';
	}

	/**
	 * Get the item namespace for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function index_map_NameSpace(object $item): ?string
	{
		return $this->getNamespace($item->namespace ?? '', $item->name ?? '');
	}

	/**
	 * Set the namespace for this power
	 *
	 * @param string  $namespace  The raw namespace
	 * @param string  $className  The class name
	 *
	 * @return string|null
	 * @since  5.0.3
	 */
	protected function getNamespace(string $namespace, string $className): ?string
	{
		// set namespace
		$namespace = $this->updatePlaceholders($namespace);

		// validate namespace
		if (strpos($namespace, '\\') === false)
		{
			// we break out here
			return null;
		}

		// setup the path array
		$path_array = (array) explode('\\', $namespace);

		// make sure it has two or more
		if (ArrayHelper::check($path_array) <= 1)
		{
			// we break out here
			return null;
		}

		// get the file and class name (the last value in array)
		$file_name = array_pop($path_array);

		// do we have src folders
		if (strpos($file_name, '.') !== false)
		{
			// we have src folders in the namespace
			$src_array = (array) explode('.', $file_name);

			// get the file and class name (the last value in array)
			$file_name = array_pop($src_array);

			// namespace array
			$namespace_array = [...$path_array, ...$src_array];
		}
		else
		{
			// namespace array
			$namespace_array = $path_array;
		}

		// the last value is the same as the class name
		if ($file_name !== $className)
		{
			// we break out here
			return null;
		}

		// make sure the arrays are namespace safe
		$namespace_array =
			array_map(
				fn($val) => $this->getCleanNamespace($val),
				$namespace_array
			);

		// set the actual class namespace
		return implode('\\', $namespace_array);
	}

	/**
	 * Get Clean Namespace without use or ; as part of the name space
	 *
	 * @param string  $namespace        The actual name space
	 *
	 * @return string
	 * @since  5.0.3
	 */
	protected function getCleanNamespace(string $namespace): string
	{
		// trim possible (use) or (;) or (starting or ending \) added to the namespace
		return NamespaceHelper::safe(str_replace(['use ', ';'], '', $namespace));
	}
}

