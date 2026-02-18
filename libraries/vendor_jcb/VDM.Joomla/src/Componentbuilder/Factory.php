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

namespace VDM\Joomla\Componentbuilder;


use VDM\Joomla\Componentbuilder\Package\Factory as PackageFactory;
use VDM\Joomla\Componentbuilder\JoomlaPower\Factory as JoomlaPowerFactory;
use VDM\Joomla\Componentbuilder\Fieldtype\Factory as FieldtypeFactory;
use VDM\Joomla\Componentbuilder\Power\Factory as PowerFactory;
use VDM\Joomla\Componentbuilder\Snippet\Factory as SnippetFactory;
use VDM\Joomla\Componentbuilder\Repository\Factory as RepositoryFactory;
use VDM\Joomla\Interfaces\FactoryInterface as ExtendingFactory;


/**
 * Powerful Factory Registry.
 * 
 * Acts as the central and authoritative routing layer between logical
 * entity identifiers and their corresponding Power factories.
 * 
 * This registry resolves the correct Power factory using either:
 * - a canonical database table name (entity), or
 * - a logical area identifier.
 * 
 * A single canonical mapping is maintained internally:
 *   table (entity) name -> (area identifier, Power factory)
 * 
 * From this source of truth, optimized reverse lookup maps are derived
 * once at initialization time, enabling constant-time (O(1)) resolution
 * in all supported directions without runtime scans, array flips, or
 * repeated normalization work.
 * 
 * By enforcing a single registry for all Power factory resolution,
 * this class guarantees consistency, predictability, and optimal
 * performance across the entire Power architecture.
 * 
 * @since 5.1.4
 */
abstract class Factory
{
	/**
	 * Canonical entity -> metadata mapping.
	 *
	 * THIS IS THE AUTHORITATIVE MAP OF ENTITY FACTORIES.
	 *
	 * @var array<string, array{area: string, factory: class-string<ExtendingFactory>}>
	 * @since 5.1.4
	 */
	private static array $entityMap = [
		// --- Component ---
		'joomla_component' => [
			'area' => 'Component',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'component_admin_views' => [
			'area' => 'ComponentAdminViews',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_custom_admin_views' => [
			'area' => 'ComponentCustomAdminViews',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_site_views' => [
			'area' => 'ComponentSiteViews',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_router' => [
			'area' => 'ComponentRouter',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_config' => [
			'area' => 'ComponentConfig',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_placeholders' => [
			'area' => 'ComponentPlaceholders',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_updates' => [
			'area' => 'ComponentUpdates',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_files_folders' => [
			'area' => 'ComponentFilesFolders',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_custom_admin_menus' => [
			'area' => 'ComponentCustomAdminMenus',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_dashboard' => [
			'area' => 'ComponentDashboard',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_modules' => [
			'area' => 'ComponentModules',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'component_plugins' => [
			'area' => 'ComponentPlugins',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],

		// --- Joomla Module ---
		'joomla_module' => [
			'area' => 'JoomlaModule',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'joomla_module_updates' => [
			'area' => 'JoomlaModuleUpdates',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'joomla_module_files_folders_urls' => [
			'area' => 'JoomlaModuleFilesFoldersUrls',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],

		// --- Joomla Plugin ---
		'joomla_plugin' => [
			'area' => 'JoomlaPlugin',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'joomla_plugin_group' => [
			'area' => 'JoomlaPluginGroup',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'joomla_plugin_updates' => [
			'area' => 'JoomlaPluginUpdates',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'joomla_plugin_files_folders_urls' => [
			'area' => 'JoomlaPluginFilesFoldersUrls',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],

		// --- Admin views / fields ---
		'admin_view' => [
			'area' => 'AdminView',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'admin_fields' => [
			'area' => 'AdminFields',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'admin_fields_relations' => [
			'area' => 'AdminFieldsRelations',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'admin_fields_conditions' => [
			'area' => 'AdminFieldsConditions',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'admin_custom_tabs' => [
			'area' => 'AdminCustomTabs',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'custom_admin_view' => [
			'area' => 'CustomAdminView',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'site_view' => [
			'area' => 'SiteView',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],

		// --- Other ---
		'template' => [
			'area' => 'Template',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'layout' => [
			'area' => 'Layout',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'dynamic_get' => [
			'area' => 'DynamicGet',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'custom_code' => [
			'area' => 'CustomCode',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'field' => [
			'area' => 'Field',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'validation_rule' => [
			'area' => 'ValidationRule',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'fieldtype' => [
			'area' => 'Joomla.Fieldtype',
			'factory' => FieldtypeFactory::class,
			'superpower' => true,
		],
		'library' => [
			'area' => 'Library',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'library_config' => [
			'area' => 'LibraryConfig',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'library_files_folders_urls' => [
			'area' => 'LibraryFilesFoldersUrls',
			'factory' => PackageFactory::class,
			'superpower' => false,
		],
		'class_method' => [
			'area' => 'ClassMethod',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'class_property' => [
			'area' => 'ClassProperty',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'class_extends' => [
			'area' => 'ClassExtends',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'placeholder' => [
			'area' => 'Placeholder',
			'factory' => PackageFactory::class,
			'superpower' => true,
		],
		'power' => [
			'area' => 'Power',
			'factory' => PowerFactory::class,
			'superpower' => true,
		],
		'joomla_power' => [
			'area' => 'Joomla.Power',
			'factory' => JoomlaPowerFactory::class,
			'superpower' => true,
		],
		'repository' => [
			'area' => 'Repository',
			'factory' => RepositoryFactory::class,
			'superpower' => true,
		],
		'snippet' => [
			'area' => 'Snippet',
			'factory' => SnippetFactory::class,
			'superpower' => true,
		],
	];

	/**
	 * Derived cache: all superpowers.
	 *
	 * Built once (lazy) from the canonical entity map.
	 *
	 * @var array<string, string>
	 * @since 5.1.4
	 */
	private static array $superPowers;

	/**
	 * Derived cache: area -> entity.
	 *
	 * Built once (lazy) from the canonical entity map.
	 *
	 * @var array<string, string>|null
	 * @since 5.1.4
	 */
	private static ?array $areaToEntity = null;

	/**
	 * Derived cache: area -> factory class.
	 *
	 * Built once (lazy) from the canonical table map.
	 *
	 * @var array<string, class-string<ExtendingFactory>>|null
	 * @since 5.1.4
	 */
	private static ?array $areaToFactory = null;

	/**
	 * Resolve and create a class via its Power factory.
	 *
	 * Accepts either:
	 * - a canonical table name, or
	 * - an area name.
	 *
	 * Hot path:
	 * - table target: O(1) single lookup
	 * - area target: O(1) single lookup (after first init)
	 *
	 * @param  string  $target
	 * @param  string  $class
	 *
	 * @return object|null
	 * @since  5.1.4
	 */
	public static function _(string $target, string $class): ?object
	{
		// Fast path: target is a table
		if (isset(self::$entityMap[$target]))
		{
			return self::$entityMap[$target]['factory']::_($class);
		}

		// Second fast path: target is an area (after init)
		self::initDerivedMaps();

		if (isset(self::$areaToFactory[$target]))
		{
			return self::$areaToFactory[$target]::_($class);
		}

		return null;
	}

	/**
	 * Return the superpowers.
	 *
	 * @return array
	 * @since  5.1.4
	 */
	public static function getSuperpowers(): array
	{
		self::initDerivedMaps();

		return self::$superPowers;
	}

	/**
	 * Return the area for a given entity.
	 *
	 * @param  string  $entity
	 *
	 * @return string|null
	 * @since  5.1.4
	 */
	public static function getArea(string $entity): ?string
	{
		return self::$entityMap[$entity]['area'] ?? null;
	}

	/**
	 * Return the table for a given area.
	 *
	 * O(1) after first init, no array_flip, no scans.
	 *
	 * @param  string  $area
	 *
	 * @return string|null
	 * @since  5.1.4
	 */
	public static function getEntity(string $area): ?string
	{
		self::initDerivedMaps();

		return self::$areaToEntity[$area] ?? null;
	}

	/**
	 * Return the factory class for a given entity.
	 *
	 * @param  string  $entity
	 *
	 * @return class-string<ExtendingFactory>|null
	 * @since  5.1.4
	 */
	public static function getEntityFactory(string $entity): ?string
	{
		return self::$entityMap[$entity]['factory'] ?? null;
	}

	/**
	 * Return the factory class for a given area.
	 *
	 * @param  string  $area
	 *
	 * @return class-string<ExtendingFactory>|null
	 * @since  5.1.4
	 */
	public static function getAreaFactory(string $area): ?string
	{
		self::initDerivedMaps();

		return self::$areaToFactory[$area] ?? null;
	}

	/**
	 * Build derived maps once.
	 *
	 * This keeps ONE authoritative map (entityMap) and derives the reverse lookups
	 * exactly once, avoiding any per-call O(n) work.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	private static function initDerivedMaps(): void
	{
		if (self::$areaToEntity !== null)
		{
			return;
		}

		$areaToEntity = [];
		$areaToFactory = [];
		$superPowers = [];

		foreach (self::$entityMap as $table => $entry)
		{
			$area = $entry['area'];

			$areaToEntity[$area] = $table;
			$areaToFactory[$area] = $entry['factory'];

			if ($entry['superpower'])
			{
				$superPowers[$table] = $table;
			}
		}

		self::$superPowers = $superPowers;
		self::$areaToEntity = $areaToEntity;
		self::$areaToFactory = $areaToFactory;
	}
}

