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

namespace VDM\Joomla\Componentbuilder\Package\Builder;


use VDM\Joomla\Abstraction\Registry;


/**
 * Package Builder Entities
 * 
 * @since 5.1.1
 */
class Entities extends Registry
{
	/**
	 * Constructor.
	 *
	 * Initializes the Registry object with optional data.
	 *
	 * @param  mixed        $data      Optional data to load into the registry.
	 *                                    Can be an array, string, or object.
	 * @param  string|null  $separator The path separator, and empty string will flatten the registry.
	 * @since  5.0.4
	 */
	public function __construct($data = null, ?string $separator = null)
	{
		$entities = [
			'joomla_component' => 'Component',
			'component_admin_views' => 'ComponentAdminViews',
			'component_custom_admin_views' => 'ComponentCustomAdminViews',
			'component_site_views' => 'ComponentSiteViews',
			'component_router' => 'ComponentRouter',
			'component_config' => 'ComponentConfig',
			'component_placeholders' => 'ComponentPlaceholders',
			'component_updates' => 'ComponentUpdates',
			'component_files_folders' => 'ComponentFilesFolders',
			'component_custom_admin_menus' => 'ComponentCustomAdminMenus',
			'component_dashboard' => 'ComponentDashboard',
			'component_modules' => 'ComponentModules',
			'component_plugins' => 'ComponentPlugins',
			'joomla_module' => 'JoomlaModule',
			'joomla_module_updates' => 'JoomlaModuleUpdates',
			'joomla_module_files_folders_urls' => 'JoomlaModuleFilesFoldersUrls',
			'joomla_plugin' => 'JoomlaPlugin',
			'joomla_plugin_group' => 'JoomlaPluginGroup',
			'joomla_plugin_updates' => 'JoomlaPluginUpdates',
			'joomla_plugin_files_folders_urls' => 'JoomlaPluginFilesFoldersUrls',
			'admin_view' => 'AdminView',
			'admin_fields' => 'AdminFields',
			'admin_fields_relations' => 'AdminFieldsRelations',
			'admin_fields_conditions' => 'AdminFieldsConditions',
			'admin_custom_tabs' => 'AdminCustomTabs',
			'custom_admin_view' => 'CustomAdminView',
			'site_view' => 'SiteView',
			'template' => 'Template',
			'layout' => 'Layout',
			'dynamic_get' => 'DynamicGet',
			'custom_code' => 'CustomCode',
			'field' => 'Field',
			'library' => 'Library',
			'library_config' => 'LibraryConfig',
			'library_files_folders_urls' => 'LibraryFilesFoldersUrls',
			'class_method' => 'ClassMethod',
			'class_property' => 'ClassProperty',
			'class_extends' => 'ClassExtends',
			'placeholder' => 'Placeholder'
		];

		parent::__construct($entities);
	}
}

