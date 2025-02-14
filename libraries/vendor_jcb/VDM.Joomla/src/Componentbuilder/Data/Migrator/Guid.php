<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Data\Migrator;


use Joomla\CMS\Factory;
use VDM\Joomla\Data\Migrator\Guid as Migrator;


/**
 * Migrator To Globally Unique Identifier
 * 
 * @since  5.0.4
 */
final class Guid
{
	/**
	 * The JCB Update Map to convert ID linking to GUID linking.
	 *
	 * @var   array
	 * @since 5.0.4
	 */
	protected array $config = [
		[
			'table' => 'field',
			'column' => 'fieldtype',
			'linkedTable' => 'fieldtype',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'dynamic_get',
			'column' => 'view_table_main',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'dynamic_get',
			'column' => 'join_view_table',
			'field' => 'view_table',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'site_view',
			'column' => 'main_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'site_view',
			'column' => 'custom_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'site_view',
			'column' => 'dynamic_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'site_view',
			'column' => 'libraries',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'custom_admin_view',
			'column' => 'main_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'custom_admin_view',
			'column' => 'custom_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'custom_admin_view',
			'column' => 'dynamic_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'custom_admin_view',
			'column' => 'libraries',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'template',
			'column' => 'libraries',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'template',
			'column' => 'snippet',
			'linkedTable' => 'snippet',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'template',
			'column' => 'dynamic_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'layout',
			'column' => 'libraries',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'layout',
			'column' => 'snippet',
			'linkedTable' => 'snippet',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'layout',
			'column' => 'dynamic_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'admin_view',
			'column' => 'addlinked_views',
			'field' => 'adminview',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'admin_fields',
			'column' => 'admin_view',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'admin_fields',
			'column' => 'addfields',
			'field' => 'field',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'admin_fields_relations',
			'column' => 'admin_view',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'admin_fields_relations',
			'column' => 'addrelations',
			'field' => 'listfield',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'admin_fields_relations',
			'column' => 'addrelations',
			'field' => 'joinfields',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 2,
		],
		[
			'table' => 'admin_fields_conditions',
			'column' => 'admin_view',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'admin_fields_conditions',
			'column' => 'addconditions',
			'field' => 'target_field',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 2,
		],
		[
			'table' => 'admin_fields_conditions',
			'column' => 'addconditions',
			'field' => 'match_field',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'admin_custom_tabs',
			'column' => 'admin_view',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_admin_views',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_admin_views',
			'column' => 'addadmin_views',
			'field' => 'adminview',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_custom_admin_views',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_custom_admin_views',
			'column' => 'addcustom_admin_views',
			'field' => 'customadminview',
			'linkedTable' => 'custom_admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_custom_admin_views',
			'column' => 'addcustom_admin_views',
			'field' => 'adminviews',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_custom_admin_views',
			'column' => 'addcustom_admin_views',
			'field' => 'before',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_site_views',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_site_views',
			'column' => 'addsite_views',
			'field' => 'siteview',
			'linkedTable' => 'site_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_router',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_config',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_config',
			'column' => 'addconfig',
			'field' => 'field',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_placeholders',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_updates',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_mysql_tweaks',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_mysql_tweaks',
			'column' => 'sql_tweak',
			'field' => 'adminview',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_files_folders',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_custom_admin_menus',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_custom_admin_menus',
			'column' => 'addcustommenus',
			'field' => 'before',
			'linkedTable' => 'admin_view',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_dashboard',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_modules',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_modules',
			'column' => 'addjoomla_modules',
			'field' => 'module',
			'linkedTable' => 'joomla_module',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'component_plugins',
			'column' => 'joomla_component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'component_plugins',
			'column' => 'addjoomla_plugins',
			'field' => 'plugin',
			'linkedTable' => 'joomla_plugin',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'custom_code',
			'column' => 'component',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_module',
			'column' => 'libraries',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_module',
			'column' => 'custom_get',
			'linkedTable' => 'dynamic_get',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_module',
			'column' => 'fields',
			'sub' => 'fields',
			'field' => 'field',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 3,
		],
		[
			'table' => 'joomla_module_updates',
			'column' => 'joomla_module',
			'linkedTable' => 'joomla_module',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_module_files_folders_urls',
			'column' => 'joomla_module',
			'linkedTable' => 'joomla_module',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_plugin',
			'column' => 'class_extends',
			'linkedTable' => 'class_extends',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_plugin',
			'column' => 'joomla_plugin_group',
			'linkedTable' => 'joomla_plugin_group',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_plugin',
			'column' => 'property_selection',
			'field' => 'property',
			'linkedTable' => 'class_property',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'joomla_plugin',
			'column' => 'method_selection',
			'field' => 'method',
			'linkedTable' => 'class_method',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'joomla_plugin',
			'column' => 'fields',
			'sub' => 'fields',
			'field' => 'field',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 3,
		],
		[
			'table' => 'joomla_plugin_updates',
			'column' => 'joomla_plugin',
			'linkedTable' => 'joomla_plugin',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_plugin_files_folders_urls',
			'column' => 'joomla_plugin',
			'linkedTable' => 'joomla_plugin',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'joomla_plugin_group',
			'column' => 'class_extends',
			'linkedTable' => 'class_extends',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'power',
			'column' => 'property_selection',
			'field' => 'property',
			'linkedTable' => 'class_property',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'power',
			'column' => 'property_selection',
			'field' => 'method',
			'linkedTable' => 'class_method',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'language_translation',
			'column' => 'components',
			'linkedTable' => 'joomla_component',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'language_translation',
			'column' => 'modules',
			'linkedTable' => 'joomla_module',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'language_translation',
			'column' => 'plugins',
			'linkedTable' => 'joomla_plugin',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'snippet',
			'column' => 'library',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'snippet',
			'column' => 'type',
			'linkedTable' => 'snippet_type',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'library',
			'column' => 'libraries',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => true,
			'valueType' => 1,
		],
		[
			'table' => 'library_config',
			'column' => 'library',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
		[
			'table' => 'library_config',
			'column' => 'addconfig',
			'field' => 'field',
			'linkedTable' => 'field',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 2,
		],
		[
			'table' => 'library_files_folders_urls',
			'column' => 'library',
			'linkedTable' => 'library',
			'linkedColumn' => 'id',
			'array' => false,
			'valueType' => 1,
		],
	];

	/**
	 * The Migrator To Guid Class.
	 *
	 * @var   Migrator
	 * @since 5.0.4
	 */
	protected Migrator $migrator;

	/**
	 * Application object.
	 *
	 * @since 5.0.4
	 **/
	protected  $app;

	/**
	 * Constructor.
	 *
	 * @param Migrator   $migrator   The Migrator To Guid Class.
	 * @param               $app      The app object.
	 *
	 * @since 5.0.4
	 */
	public function __construct(Migrator $migrator, $app = null)
	{
		$this->migrator = $migrator;
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Processes the configuration to migrate IDs to GUIDs.
	 *
	 * @return void
	 * @since 5.0.4
	 */
	public function process(): void
	{
		if (empty($this->config))
		{
			$this->app->enqueueMessage('No GUID migration configurations found!', 'warning');
			return;
		}

		// try to load the update the tables with the schema class
		try
		{
			$messages = $this->migrator->process($this->config);
		}
		catch (\Exception $e)
		{
			$this->app->enqueueMessage($e->getMessage(), 'warning');
			return;
		}

		foreach ($messages as $message)
		{
			$this->app->enqueueMessage($message, 'message');
		}
	}
}

