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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Version;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\Filesystem\Folder;
use Joomla\Database\DatabaseInterface;

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Script File of Componentbuilder Component
 *
 * @since  3.6
 */
class Com_ComponentbuilderInstallerScript implements InstallerScriptInterface
{
	/**
	 * The CMS Application.
	 *
	 * @var   CMSApplication
	 * @since 4.4.2
	 */
	protected CMSApplication $app;

	/**
	 * The database class.
	 *
	 * @since 4.4.2
	 */
	protected $db;

	/**
	 * The version number of the extension.
	 *
	 * @var   string
	 * @since  3.6
	 */
	protected $release;

	/**
	 * The table the parameters are stored in.
	 *
	 * @var   string
	 * @since  3.6
	 */
	protected $paramTable;

	/**
	 * The extension name. This should be set in the installer script.
	 *
	 * @var   string
	 * @since  3.6
	 */
	protected $extension;

	/**
	 * A list of files to be deleted
	 *
	 * @var   array
	 * @since  3.6
	 */
	protected $deleteFiles = [];

	/**
	 * A list of folders to be deleted
	 *
	 * @var   array
	 * @since  3.6
	 */
	protected $deleteFolders = [];

	/**
	 * A list of CLI script files to be copied to the cli directory
	 *
	 * @var   array
	 * @since  3.6
	 */
	protected $cliScriptFiles = [];

	/**
	 * Minimum PHP version required to install the extension
	 *
	 * @var   string
	 * @since  3.6
	 */
	protected $minimumPhp;

	/**
	 * Minimum Joomla! version required to install the extension
	 *
	 * @var   string
	 * @since  3.6
	 */
	protected $minimumJoomla;

	/**
	 * Extension script constructor.
	 *
	 * @since   3.0.0
	 */
	public function __construct()
	{
		$this->minimumJoomla = '4.3';
		$this->minimumPhp = JOOMLA_MINIMUM_PHP;
		$this->app ??= Factory::getApplication();
		$this->db = Factory::getContainer()->get(DatabaseInterface::class);

		// check if the files exist
		if (is_file(JPATH_ROOT . '/administrator/components/com_componentbuilder/componentbuilder.php'))
		{
			// remove Joomla 3 files
			$this->deleteFiles = [
				'/administrator/components/com_componentbuilder/componentbuilder.php',
				'/administrator/components/com_componentbuilder/controller.php',
				'/components/com_componentbuilder/componentbuilder.php',
				'/components/com_componentbuilder/controller.php',
				'/components/com_componentbuilder/router.php',
			];
		}

		// check if the Folders exist
		if (is_dir(JPATH_ROOT . '/administrator/components/com_componentbuilder/modules'))
		{
			// remove Joomla 3 folder
			$this->deleteFolders = [
				'/administrator/components/com_componentbuilder/controllers',
				'/administrator/components/com_componentbuilder/helpers',
				'/administrator/components/com_componentbuilder/modules',
				'/administrator/components/com_componentbuilder/tables',
				'/administrator/components/com_componentbuilder/views',
				'/components/com_componentbuilder/controllers',
				'/components/com_componentbuilder/helpers',
				'/components/com_componentbuilder/modules',
				'/components/com_componentbuilder/views',
			];
		}
	}

	/**
	 * Function called after the extension is installed.
	 *
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   4.2.0
	 */
	public function install(InstallerAdapter $adapter): bool {return true;}

	/**
	 * Function called after the extension is updated.
	 *
	 * @param   InstallerAdapter   $adapter   The adapter calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   4.2.0
	 */
	public function update(InstallerAdapter $adapter): bool {return true;}

	/**
	 * Function called after the extension is uninstalled.
	 *
	 * @param   InstallerAdapter   $adapter  The adapter calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   4.2.0
	 */
	public function uninstall(InstallerAdapter $adapter): bool
	{
		// Remove Related Component Data.

		// Remove Joomla component Data
		$this->removeViewData("com_componentbuilder.joomla_component");

		// Remove Joomla module Data
		$this->removeViewData("com_componentbuilder.joomla_module");

		// Remove Joomla plugin Data
		$this->removeViewData("com_componentbuilder.joomla_plugin");

		// Remove Power Data
		$this->removeViewData("com_componentbuilder.power");

		// Remove Admin view Data
		$this->removeViewData("com_componentbuilder.admin_view");

		// Remove Custom admin view Data
		$this->removeViewData("com_componentbuilder.custom_admin_view");

		// Remove Site view Data
		$this->removeViewData("com_componentbuilder.site_view");

		// Remove Template Data
		$this->removeViewData("com_componentbuilder.template");

		// Remove Layout Data
		$this->removeViewData("com_componentbuilder.layout");

		// Remove Dynamic get Data
		$this->removeViewData("com_componentbuilder.dynamic_get");

		// Remove Custom code Data
		$this->removeViewData("com_componentbuilder.custom_code");

		// Remove Class property Data
		$this->removeViewData("com_componentbuilder.class_property");

		// Remove Class method Data
		$this->removeViewData("com_componentbuilder.class_method");

		// Remove Placeholder Data
		$this->removeViewData("com_componentbuilder.placeholder");

		// Remove Library Data
		$this->removeViewData("com_componentbuilder.library");

		// Remove Snippet Data
		$this->removeViewData("com_componentbuilder.snippet");

		// Remove Validation rule Data
		$this->removeViewData("com_componentbuilder.validation_rule");

		// Remove Field Data
		$this->removeViewData("com_componentbuilder.field");

		// Remove Field catid Data
		$this->removeViewData("com_componentbuilder.field.category");

		// Remove Fieldtype Data
		$this->removeViewData("com_componentbuilder.fieldtype");

		// Remove Fieldtype catid Data
		$this->removeViewData("com_componentbuilder.fieldtype.category");

		// Remove Language translation Data
		$this->removeViewData("com_componentbuilder.language_translation");

		// Remove Language Data
		$this->removeViewData("com_componentbuilder.language");

		// Remove Server Data
		$this->removeViewData("com_componentbuilder.server");

		// Remove Help document Data
		$this->removeViewData("com_componentbuilder.help_document");

		// Remove Admin fields Data
		$this->removeViewData("com_componentbuilder.admin_fields");

		// Remove Admin fields conditions Data
		$this->removeViewData("com_componentbuilder.admin_fields_conditions");

		// Remove Admin fields relations Data
		$this->removeViewData("com_componentbuilder.admin_fields_relations");

		// Remove Admin custom tabs Data
		$this->removeViewData("com_componentbuilder.admin_custom_tabs");

		// Remove Component admin views Data
		$this->removeViewData("com_componentbuilder.component_admin_views");

		// Remove Component site views Data
		$this->removeViewData("com_componentbuilder.component_site_views");

		// Remove Component custom admin views Data
		$this->removeViewData("com_componentbuilder.component_custom_admin_views");

		// Remove Component updates Data
		$this->removeViewData("com_componentbuilder.component_updates");

		// Remove Component mysql tweaks Data
		$this->removeViewData("com_componentbuilder.component_mysql_tweaks");

		// Remove Component custom admin menus Data
		$this->removeViewData("com_componentbuilder.component_custom_admin_menus");

		// Remove Component router Data
		$this->removeViewData("com_componentbuilder.component_router");

		// Remove Component config Data
		$this->removeViewData("com_componentbuilder.component_config");

		// Remove Component dashboard Data
		$this->removeViewData("com_componentbuilder.component_dashboard");

		// Remove Component files folders Data
		$this->removeViewData("com_componentbuilder.component_files_folders");

		// Remove Component placeholders Data
		$this->removeViewData("com_componentbuilder.component_placeholders");

		// Remove Component plugins Data
		$this->removeViewData("com_componentbuilder.component_plugins");

		// Remove Component modules Data
		$this->removeViewData("com_componentbuilder.component_modules");

		// Remove Snippet type Data
		$this->removeViewData("com_componentbuilder.snippet_type");

		// Remove Library config Data
		$this->removeViewData("com_componentbuilder.library_config");

		// Remove Library files folders urls Data
		$this->removeViewData("com_componentbuilder.library_files_folders_urls");

		// Remove Class extends Data
		$this->removeViewData("com_componentbuilder.class_extends");

		// Remove Joomla module updates Data
		$this->removeViewData("com_componentbuilder.joomla_module_updates");

		// Remove Joomla module files folders urls Data
		$this->removeViewData("com_componentbuilder.joomla_module_files_folders_urls");

		// Remove Joomla plugin group Data
		$this->removeViewData("com_componentbuilder.joomla_plugin_group");

		// Remove Joomla plugin updates Data
		$this->removeViewData("com_componentbuilder.joomla_plugin_updates");

		// Remove Joomla plugin files folders urls Data
		$this->removeViewData("com_componentbuilder.joomla_plugin_files_folders_urls");

		// Remove Asset Data.
		$this->removeAssetData();

		// Revert the assets table rules column back to the default.
		$this->removeDatabaseAssetsRulesFix();

		// Remove component from action logs extensions table.
		$this->removeActionLogsExtensions();

		// Remove Joomla_component from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_component');

		// Remove Joomla_module from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_module');

		// Remove Joomla_plugin from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_plugin');

		// Remove Power from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.power');

		// Remove Admin_view from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.admin_view');

		// Remove Custom_admin_view from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.custom_admin_view');

		// Remove Site_view from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.site_view');

		// Remove Template from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.template');

		// Remove Layout from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.layout');

		// Remove Dynamic_get from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.dynamic_get');

		// Remove Custom_code from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.custom_code');

		// Remove Class_property from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.class_property');

		// Remove Class_method from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.class_method');

		// Remove Placeholder from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.placeholder');

		// Remove Library from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.library');

		// Remove Snippet from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.snippet');

		// Remove Validation_rule from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.validation_rule');

		// Remove Field from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.field');

		// Remove Fieldtype from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.fieldtype');

		// Remove Language_translation from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.language_translation');

		// Remove Language from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.language');

		// Remove Server from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.server');

		// Remove Help_document from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.help_document');

		// Remove Admin_fields from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.admin_fields');

		// Remove Admin_fields_conditions from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.admin_fields_conditions');

		// Remove Admin_fields_relations from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.admin_fields_relations');

		// Remove Admin_custom_tabs from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.admin_custom_tabs');

		// Remove Component_admin_views from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_admin_views');

		// Remove Component_site_views from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_site_views');

		// Remove Component_custom_admin_views from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_custom_admin_views');

		// Remove Component_updates from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_updates');

		// Remove Component_mysql_tweaks from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_mysql_tweaks');

		// Remove Component_custom_admin_menus from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_custom_admin_menus');

		// Remove Component_router from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_router');

		// Remove Component_config from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_config');

		// Remove Component_dashboard from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_dashboard');

		// Remove Component_files_folders from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_files_folders');

		// Remove Component_placeholders from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_placeholders');

		// Remove Component_plugins from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_plugins');

		// Remove Component_modules from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.component_modules');

		// Remove Snippet_type from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.snippet_type');

		// Remove Library_config from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.library_config');

		// Remove Library_files_folders_urls from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.library_files_folders_urls');

		// Remove Class_extends from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.class_extends');

		// Remove Joomla_module_updates from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_module_updates');

		// Remove Joomla_module_files_folders_urls from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_module_files_folders_urls');

		// Remove Joomla_plugin_group from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_plugin_group');

		// Remove Joomla_plugin_updates from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_plugin_updates');

		// Remove Joomla_plugin_files_folders_urls from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_plugin_files_folders_urls');

		// Remove Field from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.field');

		// Remove Joomla_component from action logs config table.
		$this->removeActionLogConfig('com_componentbuilder.joomla_component');
		// little notice as after service, in case of bad experience with component.
		echo '<div style="background-color: #fff;" class="alert alert-info">
		<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:joomla@vdm.io">joomla@vdm.io</a>.
		<br />We at Vast Development Method are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="https://dev.vdm.io" target="_blank">https://dev.vdm.io</a> today!</p></div>';

		return true;
	}

	/**
	 * Function called before extension installation/update/removal procedure commences.
	 *
	 * @param   string            $type     The type of change (install or discover_install, update, uninstall)
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   4.2.0
	 */
	public function preflight(string $type, InstallerAdapter $adapter): bool
	{
		// Check for the minimum PHP version before continuing
		if (!empty($this->minimumPhp) && version_compare(PHP_VERSION, $this->minimumPhp, '<'))
		{
			Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_PHP', $this->minimumPhp), Log::WARNING, 'jerror');

			return false;
		}

		// Check for the minimum Joomla version before continuing
		if (!empty($this->minimumJoomla) && version_compare(JVERSION, $this->minimumJoomla, '<'))
		{
			Log::add(Text::sprintf('JLIB_INSTALLER_MINIMUM_JOOMLA', $this->minimumJoomla), Log::WARNING, 'jerror');

			return false;
		}

		// Extension manifest file version
		$this->extension = $adapter->getName();
		$this->release   = $adapter->getManifest()->version;

		// do any updates needed
		if ($type === 'update')
		{

			// Check if the class and method exist before attempting to call it.
			if (class_exists('\VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper') &&
				method_exists('\VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper', 'removeFolder'))
			{
				// path to the new compiler
				$jcb_powers = JPATH_LIBRARIES . '/jcb_powers/VDM.Joomla/src/Componentbuilder';
				// we always remove all the old files to avoid mismatching
				\VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper::removeFolder($jcb_powers);
			}
		}

		// do any install needed
		if ($type === 'install')
		{
		}

		return true;
	}

	/**
	 * Function called after extension installation/update/removal procedure commences.
	 *
	 * @param   string            $type     The type of change (install or discover_install, update, uninstall)
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @return  boolean  True on success
	 *
	 * @since   4.2.0
	 */
	public function postflight(string $type, InstallerAdapter $adapter): bool
	{
		// We check if we have dynamic folders to copy
		$this->moveFolders($adapter);

		// set the default component settings
		if ($type === 'install')
		{

			// Install Joomla component Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_component',
				// typeAlias
				'com_componentbuilder.joomla_component',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_component","key": "id","type": "Joomla_componentTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "php_method_uninstall","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","short_description":"short_description","companyname":"companyname","buildcompsql":"buildcompsql","translation_tool":"translation_tool","add_sales_server":"add_sales_server","php_method_uninstall":"php_method_uninstall","php_preflight_install":"php_preflight_install","css_admin":"css_admin","mvc_versiondate":"mvc_versiondate","remove_line_breaks":"remove_line_breaks","add_placeholders":"add_placeholders","debug_linenr":"debug_linenr","php_site_event":"php_site_event","description":"description","author":"author","php_postflight_install":"php_postflight_install","email":"email","sql_uninstall":"sql_uninstall","website":"website","add_license":"add_license","backup_folder_path":"backup_folder_path","php_helper_both":"php_helper_both","crowdin_username":"crowdin_username","php_admin_event":"php_admin_event","license_type":"license_type","component_version":"component_version","php_helper_admin":"php_helper_admin","php_helper_site":"php_helper_site","whmcs_key":"whmcs_key","javascript":"javascript","whmcs_url":"whmcs_url","css_site":"css_site","whmcs_buy_link":"whmcs_buy_link","license":"license","php_preflight_update":"php_preflight_update","bom":"bom","php_postflight_update":"php_postflight_update","image":"image","sql":"sql","copyright":"copyright","addreadme":"addreadme","preferred_joomla_version":"preferred_joomla_version","update_server_url":"update_server_url","add_powers":"add_powers","add_backup_folder_path":"add_backup_folder_path","crowdin_project_identifier":"crowdin_project_identifier","add_php_helper_both":"add_php_helper_both","add_php_helper_admin":"add_php_helper_admin","add_admin_event":"add_admin_event","add_php_helper_site":"add_php_helper_site","add_site_event":"add_site_event","add_namespace_prefix":"add_namespace_prefix","add_javascript":"add_javascript","namespace_prefix":"namespace_prefix","add_css_admin":"add_css_admin","add_css_site":"add_css_site","add_menu_prefix":"add_menu_prefix","dashboard_type":"dashboard_type","menu_prefix":"menu_prefix","dashboard":"dashboard","add_php_preflight_install":"add_php_preflight_install","add_php_preflight_update":"add_php_preflight_update","toignore":"toignore","add_php_postflight_install":"add_php_postflight_install","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","export_key":"export_key","add_sql":"add_sql","joomla_source_link":"joomla_source_link","add_sql_uninstall":"add_sql_uninstall","export_buy_link":"export_buy_link","assets_table_fix":"assets_table_fix","readme":"readme","add_update_server":"add_update_server","update_server_target":"update_server_target","emptycontributors":"emptycontributors","number":"number","update_server":"update_server","sales_server":"sales_server","add_git_folder_path":"add_git_folder_path","git_folder_path":"git_folder_path","crowdin_project_api_key":"crowdin_project_api_key","creatuserhelper":"creatuserhelper","crowdin_account_api_key":"crowdin_account_api_key","adduikit":"adduikit","buildcomp":"buildcomp","addfootable":"addfootable","guid":"guid","add_email_helper":"add_email_helper","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","translation_tool","add_sales_server","mvc_versiondate","remove_line_breaks","add_placeholders","debug_linenr","add_license","license_type","addreadme","preferred_joomla_version","add_powers","add_backup_folder_path","add_php_helper_both","add_php_helper_admin","add_admin_event","add_php_helper_site","add_site_event","add_javascript","add_css_admin","add_css_site","dashboard_type","add_php_preflight_install","add_php_preflight_update","add_php_postflight_install","add_php_postflight_update","add_php_method_uninstall","add_sql","add_sql_uninstall","assets_table_fix","add_update_server","update_server_target","emptycontributors","number","update_server","sales_server","add_git_folder_path","creatuserhelper","adduikit","buildcomp","addfootable","add_email_helper"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dashboard","targetTable": "#__componentbuilder_custom_admin_view","targetColumn": "","displayColumn": "system_name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Joomla module Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_module',
				// typeAlias
				'com_componentbuilder.joomla_module',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_module","key": "id","type": "Joomla_moduleTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "default","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","target":"target","description":"description","add_php_method_uninstall":"add_php_method_uninstall","add_php_postflight_update":"add_php_postflight_update","add_php_postflight_install":"add_php_postflight_install","add_php_preflight_uninstall":"add_php_preflight_uninstall","addreadme":"addreadme","default":"default","snippet":"snippet","add_sql":"add_sql","update_server_target":"update_server_target","add_sql_uninstall":"add_sql_uninstall","update_server":"update_server","add_update_server":"add_update_server","libraries":"libraries","module_version":"module_version","sales_server":"sales_server","custom_get":"custom_get","php_preflight_update":"php_preflight_update","php_preflight_uninstall":"php_preflight_uninstall","mod_code":"mod_code","php_postflight_install":"php_postflight_install","add_class_helper":"add_class_helper","php_postflight_update":"php_postflight_update","add_class_helper_header":"add_class_helper_header","php_method_uninstall":"php_method_uninstall","class_helper_header":"class_helper_header","sql":"sql","class_helper_code":"class_helper_code","sql_uninstall":"sql_uninstall","readme":"readme","add_php_script_construct":"add_php_script_construct","update_server_url":"update_server_url","php_script_construct":"php_script_construct","add_php_preflight_install":"add_php_preflight_install","php_preflight_install":"php_preflight_install","add_sales_server":"add_sales_server","add_php_preflight_update":"add_php_preflight_update","guid":"guid","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_module.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","target","add_php_method_uninstall","add_php_postflight_update","add_php_postflight_install","add_php_preflight_uninstall","addreadme","snippet","add_sql","update_server_target","add_sql_uninstall","update_server","add_update_server","sales_server","add_class_helper","add_class_helper_header","add_php_script_construct","add_php_preflight_install","add_sales_server","add_php_preflight_update"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Joomla plugin Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin',
				// typeAlias
				'com_componentbuilder.joomla_plugin',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin","key": "id","type": "Joomla_pluginTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "head","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","class_extends":"class_extends","joomla_plugin_group":"joomla_plugin_group","add_sql":"add_sql","add_php_method_uninstall":"add_php_method_uninstall","add_php_postflight_update":"add_php_postflight_update","add_php_postflight_install":"add_php_postflight_install","sales_server":"sales_server","add_update_server":"add_update_server","add_head":"add_head","add_sql_uninstall":"add_sql_uninstall","addreadme":"addreadme","head":"head","update_server_target":"update_server_target","main_class_code":"main_class_code","update_server":"update_server","description":"description","php_postflight_install":"php_postflight_install","plugin_version":"plugin_version","php_postflight_update":"php_postflight_update","php_method_uninstall":"php_method_uninstall","add_php_script_construct":"add_php_script_construct","sql":"sql","php_script_construct":"php_script_construct","sql_uninstall":"sql_uninstall","add_php_preflight_install":"add_php_preflight_install","readme":"readme","php_preflight_install":"php_preflight_install","update_server_url":"update_server_url","add_php_preflight_update":"add_php_preflight_update","php_preflight_update":"php_preflight_update","add_php_preflight_uninstall":"add_php_preflight_uninstall","add_sales_server":"add_sales_server","php_preflight_uninstall":"php_preflight_uninstall","guid":"guid","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","class_extends","joomla_plugin_group","add_sql","add_php_method_uninstall","add_php_postflight_update","add_php_postflight_install","sales_server","add_update_server","add_head","add_sql_uninstall","addreadme","update_server_target","update_server","add_php_script_construct","add_php_preflight_install","add_php_preflight_update","add_php_preflight_uninstall","add_sales_server"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "class_extends","targetTable": "#__componentbuilder_class_extends","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin_group","targetTable": "#__componentbuilder_joomla_plugin_group","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Power Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Power',
				// typeAlias
				'com_componentbuilder.power',
				// table
				'{"special": {"dbtable": "#__componentbuilder_power","key": "id","type": "PowerTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "head","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","namespace":"namespace","type":"type","power_version":"power_version","licensing_template":"licensing_template","description":"description","extends":"extends","approved":"approved","add_head":"add_head","extends_custom":"extends_custom","implements_custom":"implements_custom","implements":"implements","head":"head","approved_paths":"approved_paths","main_class_code":"main_class_code","add_licensing_template":"add_licensing_template","guid":"guid","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/power.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","approved","add_head","add_licensing_template"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "extends","targetTable": "#__componentbuilder_power","targetColumn": "guid","displayColumn": "name"},{"sourceColumn": "implements","targetTable": "#__componentbuilder_power","targetColumn": "guid","displayColumn": "name"}]}'
			);
			// Install Admin view Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_view',
				// typeAlias
				'com_componentbuilder.admin_view',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_view","key": "id","type": "Admin_viewTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "php_allowedit","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","short_description":"short_description","php_allowedit":"php_allowedit","php_postsavehook":"php_postsavehook","php_before_save":"php_before_save","php_getlistquery":"php_getlistquery","php_import_ext":"php_import_ext","icon":"icon","php_after_publish":"php_after_publish","add_fadein":"add_fadein","description":"description","icon_category":"icon_category","icon_add":"icon_add","php_after_cancel":"php_after_cancel","mysql_table_charset":"mysql_table_charset","php_batchmove":"php_batchmove","type":"type","php_after_delete":"php_after_delete","source":"source","php_import":"php_import","php_getitems_after_all":"php_getitems_after_all","php_getform":"php_getform","php_save":"php_save","php_allowadd":"php_allowadd","php_before_cancel":"php_before_cancel","php_batchcopy":"php_batchcopy","php_before_publish":"php_before_publish","alias_builder_type":"alias_builder_type","php_before_delete":"php_before_delete","php_document":"php_document","mysql_table_row_format":"mysql_table_row_format","alias_builder":"alias_builder","sql":"sql","php_import_display":"php_import_display","add_category_submenu":"add_category_submenu","php_import_setdata":"php_import_setdata","name_list":"name_list","add_php_getlistquery":"add_php_getlistquery","add_css_view":"add_css_view","add_php_getform":"add_php_getform","css_view":"css_view","add_php_before_save":"add_php_before_save","add_css_views":"add_css_views","add_php_save":"add_php_save","css_views":"css_views","add_php_postsavehook":"add_php_postsavehook","add_javascript_view_file":"add_javascript_view_file","add_php_allowadd":"add_php_allowadd","javascript_view_file":"javascript_view_file","add_php_allowedit":"add_php_allowedit","add_javascript_view_footer":"add_javascript_view_footer","add_php_before_cancel":"add_php_before_cancel","javascript_view_footer":"javascript_view_footer","add_php_after_cancel":"add_php_after_cancel","add_javascript_views_file":"add_javascript_views_file","add_php_batchcopy":"add_php_batchcopy","javascript_views_file":"javascript_views_file","add_php_batchmove":"add_php_batchmove","add_javascript_views_footer":"add_javascript_views_footer","add_php_before_publish":"add_php_before_publish","javascript_views_footer":"javascript_views_footer","add_php_after_publish":"add_php_after_publish","add_custom_button":"add_custom_button","add_php_before_delete":"add_php_before_delete","add_php_after_delete":"add_php_after_delete","php_controller":"php_controller","add_php_document":"add_php_document","php_model":"php_model","mysql_table_engine":"mysql_table_engine","php_controller_list":"php_controller_list","mysql_table_collate":"mysql_table_collate","php_model_list":"php_model_list","add_sql":"add_sql","add_php_ajax":"add_php_ajax","php_ajaxmethod":"php_ajaxmethod","add_custom_import":"add_custom_import","add_php_getitem":"add_php_getitem","html_import_view":"html_import_view","php_getitem":"php_getitem","php_import_headers":"php_import_headers","add_php_getitems":"add_php_getitems","php_import_save":"php_import_save","php_getitems":"php_getitems","guid":"guid","add_php_getitems_after_all":"add_php_getitems_after_all"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","add_fadein","type","source","add_category_submenu","add_php_getlistquery","add_css_view","add_php_getform","add_php_before_save","add_css_views","add_php_save","add_php_postsavehook","add_javascript_view_file","add_php_allowadd","add_php_allowedit","add_javascript_view_footer","add_php_before_cancel","add_php_after_cancel","add_javascript_views_file","add_php_batchcopy","add_php_batchmove","add_javascript_views_footer","add_php_before_publish","add_php_after_publish","add_custom_button","add_php_before_delete","add_php_after_delete","add_php_document","add_sql","add_php_ajax","add_custom_import","add_php_getitem","add_php_getitems","add_php_getitems_after_all"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "alias_builder","targetTable": "#__componentbuilder_field","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Custom admin view Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Custom_admin_view',
				// typeAlias
				'com_componentbuilder.custom_admin_view',
				// table
				'{"special": {"dbtable": "#__componentbuilder_custom_admin_view","key": "id","type": "Custom_admin_viewTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "css_document","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","description":"description","main_get":"main_get","add_php_jview_display":"add_php_jview_display","css_document":"css_document","css":"css","js_document":"js_document","javascript_file":"javascript_file","codename":"codename","default":"default","snippet":"snippet","icon":"icon","add_php_jview":"add_php_jview","context":"context","add_js_document":"add_js_document","custom_get":"custom_get","add_javascript_file":"add_javascript_file","php_ajaxmethod":"php_ajaxmethod","add_css_document":"add_css_document","add_php_document":"add_php_document","add_css":"add_css","add_php_view":"add_php_view","add_php_ajax":"add_php_ajax","libraries":"libraries","dynamic_get":"dynamic_get","php_document":"php_document","php_view":"php_view","add_custom_button":"add_custom_button","php_jview_display":"php_jview_display","php_jview":"php_jview","php_controller":"php_controller","guid":"guid","php_model":"php_model"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/custom_admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","main_get","add_php_jview_display","snippet","add_php_jview","add_js_document","add_javascript_file","add_css_document","add_php_document","add_css","add_php_view","add_php_ajax","dynamic_get","add_custom_button"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Site view Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Site_view',
				// typeAlias
				'com_componentbuilder.site_view',
				// table
				'{"special": {"dbtable": "#__componentbuilder_site_view","key": "id","type": "Site_viewTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "js_document","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","description":"description","main_get":"main_get","add_php_jview_display":"add_php_jview_display","add_php_document":"add_php_document","add_php_view":"add_php_view","js_document":"js_document","codename":"codename","javascript_file":"javascript_file","context":"context","default":"default","snippet":"snippet","add_php_jview":"add_php_jview","custom_get":"custom_get","css_document":"css_document","add_javascript_file":"add_javascript_file","css":"css","add_js_document":"add_js_document","php_ajaxmethod":"php_ajaxmethod","add_css_document":"add_css_document","libraries":"libraries","add_css":"add_css","dynamic_get":"dynamic_get","add_php_ajax":"add_php_ajax","add_custom_button":"add_custom_button","php_document":"php_document","button_position":"button_position","php_view":"php_view","php_jview_display":"php_jview_display","php_jview":"php_jview","php_controller":"php_controller","guid":"guid","php_model":"php_model"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/site_view.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","main_get","add_php_jview_display","add_php_document","add_php_view","snippet","add_php_jview","add_javascript_file","add_js_document","add_css_document","add_css","dynamic_get","add_php_ajax","add_custom_button","button_position"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Template Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Template',
				// typeAlias
				'com_componentbuilder.template',
				// table
				'{"special": {"dbtable": "#__componentbuilder_template","key": "id","type": "TemplateTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "php_view","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","dynamic_get":"dynamic_get","php_view":"php_view","add_php_view":"add_php_view","template":"template","snippet":"snippet","libraries":"libraries","alias":"alias"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/template.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","dynamic_get","add_php_view","snippet"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Layout Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Layout',
				// typeAlias
				'com_componentbuilder.layout',
				// table
				'{"special": {"dbtable": "#__componentbuilder_layout","key": "id","type": "LayoutTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "php_view","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","php_view":"php_view","add_php_view":"add_php_view","layout":"layout","libraries":"libraries","alias":"alias"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/layout.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","dynamic_get","snippet","add_php_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Dynamic get Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Dynamic_get',
				// typeAlias
				'com_componentbuilder.dynamic_get',
				// table
				'{"special": {"dbtable": "#__componentbuilder_dynamic_get","key": "id","type": "Dynamic_getTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "php_calculation","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","php_calculation":"php_calculation","php_router_parse":"php_router_parse","add_php_after_getitems":"add_php_after_getitems","add_php_router_parse":"add_php_router_parse","view_selection":"view_selection","add_php_before_getitems":"add_php_before_getitems","add_php_before_getitem":"add_php_before_getitem","add_php_after_getitem":"add_php_after_getitem","db_table_main":"db_table_main","php_custom_get":"php_custom_get","plugin_events":"plugin_events","db_selection":"db_selection","view_table_main":"view_table_main","add_php_getlistquery":"add_php_getlistquery","select_all":"select_all","php_before_getitem":"php_before_getitem","getcustom":"getcustom","php_after_getitem":"php_after_getitem","pagination":"pagination","php_getlistquery":"php_getlistquery","php_before_getitems":"php_before_getitems","php_after_getitems":"php_after_getitems","addcalculation":"addcalculation","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","main_source","gettype","add_php_after_getitems","add_php_router_parse","add_php_before_getitems","add_php_before_getitem","add_php_after_getitem","view_table_main","add_php_getlistquery","select_all","pagination"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Custom code Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Custom_code',
				// typeAlias
				'com_componentbuilder.custom_code',
				// table
				'{"special": {"dbtable": "#__componentbuilder_custom_code","key": "id","type": "Custom_codeTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "code","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","joomla_version":"joomla_version","function_name":"function_name","system_name":"system_name","code":"code","hashendtarget":"hashendtarget","to_line":"to_line","from_line":"from_line","hashtarget":"hashtarget"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/custom_code.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","component","target","type","comment_type","joomla_version"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Class property Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Class_property',
				// typeAlias
				'com_componentbuilder.class_property',
				// table
				'{"special": {"dbtable": "#__componentbuilder_class_property","key": "id","type": "Class_propertyTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","visibility":"visibility","extension_type":"extension_type","guid":"guid","comment":"comment","joomla_plugin_group":"joomla_plugin_group","default":"default"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/class_property.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin_group"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin_group","targetTable": "#__componentbuilder_joomla_plugin_group","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Class method Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Class_method',
				// typeAlias
				'com_componentbuilder.class_method',
				// table
				'{"special": {"dbtable": "#__componentbuilder_class_method","key": "id","type": "Class_methodTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "code","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","visibility":"visibility","extension_type":"extension_type","guid":"guid","code":"code","comment":"comment","joomla_plugin_group":"joomla_plugin_group","arguments":"arguments"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/class_method.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin_group"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin_group","targetTable": "#__componentbuilder_joomla_plugin_group","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Placeholder Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Placeholder',
				// typeAlias
				'com_componentbuilder.placeholder',
				// table
				'{"special": {"dbtable": "#__componentbuilder_placeholder","key": "id","type": "PlaceholderTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "target","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"target":"target","value":"value"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/placeholder.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Library Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Library',
				// typeAlias
				'com_componentbuilder.library',
				// table
				'{"special": {"dbtable": "#__componentbuilder_library","key": "id","type": "LibraryTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","target":"target","how":"how","type":"type","description":"description","libraries":"libraries","php_setdocument":"php_setdocument","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/library.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","target","how","type"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Snippet Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Snippet',
				// typeAlias
				'com_componentbuilder.snippet',
				// table
				'{"special": {"dbtable": "#__componentbuilder_snippet","key": "id","type": "SnippetTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","url":"url","type":"type","heading":"heading","library":"library","guid":"guid","contributor_email":"contributor_email","contributor_name":"contributor_name","contributor_website":"contributor_website","contributor_company":"contributor_company","snippet":"snippet","usage":"usage","description":"description"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/snippet.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","type","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "type","targetTable": "#__componentbuilder_snippet_type","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Validation rule Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Validation_rule',
				// typeAlias
				'com_componentbuilder.validation_rule',
				// table
				'{"special": {"dbtable": "#__componentbuilder_validation_rule","key": "id","type": "Validation_ruleTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","short_description":"short_description","inherit":"inherit","php":"php"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/validation_rule.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "inherit","targetTable": "#__componentbuilder_validation_rule","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Field Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Field',
				// typeAlias
				'com_componentbuilder.field',
				// table
				'{"special": {"dbtable": "#__componentbuilder_field","key": "id","type": "FieldTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "css_views","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","store":"store","on_save_model_field":"on_save_model_field","initiator_on_get_model":"initiator_on_get_model","initiator_on_save_model":"initiator_on_save_model","xml":"xml","datalenght":"datalenght","css_views":"css_views","css_view":"css_view","datadefault_other":"datadefault_other","datadefault":"datadefault","datalenght_other":"datalenght_other","on_get_model_field":"on_get_model_field","javascript_view_footer":"javascript_view_footer","javascript_views_footer":"javascript_views_footer","add_css_view":"add_css_view","add_css_views":"add_css_views","add_javascript_view_footer":"add_javascript_view_footer","add_javascript_views_footer":"add_javascript_views_footer","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","xml"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","fieldtype","store","catid","add_css_view","add_css_views","add_javascript_view_footer","add_javascript_views_footer"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Field category Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Field Catid',
				// typeAlias
				'com_componentbuilder.field.category',
				// table
				'{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}',
				// rules
				'',
				// fieldMappings
				'{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile":"administrator\/components\/com_categories\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'
			);
			// Install Fieldtype Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Fieldtype',
				// typeAlias
				'com_componentbuilder.fieldtype',
				// table
				'{"special": {"dbtable": "#__componentbuilder_fieldtype","key": "id","type": "FieldtypeTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","store":"store","null_switch":"null_switch","indexes":"indexes","datadefault_other":"datadefault_other","datadefault":"datadefault","short_description":"short_description","datatype":"datatype","has_defaults":"has_defaults","description":"description","datalenght":"datalenght","datalenght_other":"datalenght_other","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/fieldtype.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","store","has_defaults","catid"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Fieldtype category Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Fieldtype Catid',
				// typeAlias
				'com_componentbuilder.fieldtype.category',
				// table
				'{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}',
				// rules
				'',
				// fieldMappings
				'{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile":"administrator\/components\/com_categories\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'
			);
			// Install Language translation Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Language_translation',
				// typeAlias
				'com_componentbuilder.language_translation',
				// table
				'{"special": {"dbtable": "#__componentbuilder_language_translation","key": "id","type": "Language_translationTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "source","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"source":"source","plugins":"plugins","modules":"modules","components":"components"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/language_translation.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "plugins","targetTable": "#__componentbuilder_joomla_plugin","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "modules","targetTable": "#__componentbuilder_joomla_module","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "components","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Language Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Language',
				// typeAlias
				'com_componentbuilder.language',
				// table
				'{"special": {"dbtable": "#__componentbuilder_language","key": "id","type": "LanguageTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","langtag":"langtag"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/language.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Server Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Server',
				// typeAlias
				'com_componentbuilder.server',
				// table
				'{"special": {"dbtable": "#__componentbuilder_server","key": "id","type": "ServerTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","protocol":"protocol","signature":"signature","private_key":"private_key","secret":"secret","password":"password","private":"private","authentication":"authentication","path":"path","port":"port","host":"host","username":"username"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/server.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","protocol","authentication"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Help document Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Help_document',
				// typeAlias
				'com_componentbuilder.help_document',
				// table
				'{"special": {"dbtable": "#__componentbuilder_help_document","key": "id","type": "Help_documentTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "title","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "content","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "null","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"title":"title","type":"type","groups":"groups","location":"location","admin_view":"admin_view","site_view":"site_view","not_required":"not_required","content":"content","article":"article","url":"url","target":"target","alias":"alias"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/help_document.xml","hideFields": ["asset_id","checked_out","checked_out_time","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","type","location","not_required","article","target"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "article","targetTable": "#__content","targetColumn": "id","displayColumn": "title"}]}'
			);
			// Install Admin fields Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_fields',
				// typeAlias
				'com_componentbuilder.admin_fields',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_fields","key": "id","type": "Admin_fieldsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_fields.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Admin fields conditions Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_fields_conditions',
				// typeAlias
				'com_componentbuilder.admin_fields_conditions',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_fields_conditions","key": "id","type": "Admin_fields_conditionsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_fields_conditions.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Admin fields relations Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_fields_relations',
				// typeAlias
				'com_componentbuilder.admin_fields_relations',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_fields_relations","key": "id","type": "Admin_fields_relationsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_fields_relations.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Admin custom tabs Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_custom_tabs',
				// typeAlias
				'com_componentbuilder.admin_custom_tabs',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_custom_tabs","key": "id","type": "Admin_custom_tabsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_custom_tabs.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component admin views Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_admin_views',
				// typeAlias
				'com_componentbuilder.component_admin_views',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_admin_views","key": "id","type": "Component_admin_viewsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component site views Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_site_views',
				// typeAlias
				'com_componentbuilder.component_site_views',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_site_views","key": "id","type": "Component_site_viewsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_site_views.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component custom admin views Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_custom_admin_views',
				// typeAlias
				'com_componentbuilder.component_custom_admin_views',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_custom_admin_views","key": "id","type": "Component_custom_admin_viewsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_custom_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component updates Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_updates',
				// typeAlias
				'com_componentbuilder.component_updates',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_updates","key": "id","type": "Component_updatesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component mysql tweaks Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_mysql_tweaks',
				// typeAlias
				'com_componentbuilder.component_mysql_tweaks',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_mysql_tweaks","key": "id","type": "Component_mysql_tweaksTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_mysql_tweaks.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component custom admin menus Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_custom_admin_menus',
				// typeAlias
				'com_componentbuilder.component_custom_admin_menus',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_custom_admin_menus","key": "id","type": "Component_custom_admin_menusTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_custom_admin_menus.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component router Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_router',
				// typeAlias
				'com_componentbuilder.component_router',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_router","key": "id","type": "Component_routerTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "methods_code","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component","mode_constructor_before_parent":"mode_constructor_before_parent","mode_constructor_after_parent":"mode_constructor_after_parent","mode_methods":"mode_methods","methods_code":"methods_code","constructor_after_parent_code":"constructor_after_parent_code","constructor_before_parent_code":"constructor_before_parent_code"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_router.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component","mode_constructor_before_parent","mode_constructor_after_parent","mode_methods"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component config Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_config',
				// typeAlias
				'com_componentbuilder.component_config',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_config","key": "id","type": "Component_configTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_config.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component dashboard Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_dashboard',
				// typeAlias
				'com_componentbuilder.component_dashboard',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_dashboard","key": "id","type": "Component_dashboardTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component","php_dashboard_methods":"php_dashboard_methods"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_dashboard.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component files folders Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_files_folders',
				// typeAlias
				'com_componentbuilder.component_files_folders',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_files_folders","key": "id","type": "Component_files_foldersTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_files_folders.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component placeholders Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_placeholders',
				// typeAlias
				'com_componentbuilder.component_placeholders',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_placeholders","key": "id","type": "Component_placeholdersTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_placeholders.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component plugins Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_plugins',
				// typeAlias
				'com_componentbuilder.component_plugins',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_plugins","key": "id","type": "Component_pluginsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_plugins.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Component modules Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_modules',
				// typeAlias
				'com_componentbuilder.component_modules',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_modules","key": "id","type": "Component_modulesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_modules.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Snippet type Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Snippet_type',
				// typeAlias
				'com_componentbuilder.snippet_type',
				// table
				'{"special": {"dbtable": "#__componentbuilder_snippet_type","key": "id","type": "Snippet_typeTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/snippet_type.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Library config Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Library_config',
				// typeAlias
				'com_componentbuilder.library_config',
				// table
				'{"special": {"dbtable": "#__componentbuilder_library_config","key": "id","type": "Library_configTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/library_config.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Library files folders urls Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Library_files_folders_urls',
				// typeAlias
				'com_componentbuilder.library_files_folders_urls',
				// table
				'{"special": {"dbtable": "#__componentbuilder_library_files_folders_urls","key": "id","type": "Library_files_folders_urlsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/library_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Class extends Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Class_extends',
				// typeAlias
				'com_componentbuilder.class_extends',
				// table
				'{"special": {"dbtable": "#__componentbuilder_class_extends","key": "id","type": "Class_extendsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "head","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","extension_type":"extension_type","head":"head","comment":"comment"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/class_extends.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Joomla module updates Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_module_updates',
				// typeAlias
				'com_componentbuilder.joomla_module_updates',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_module_updates","key": "id","type": "Joomla_module_updatesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_module","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_module":"joomla_module"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_module_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_module"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_module","targetTable": "#__componentbuilder_joomla_module","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Joomla module files folders urls Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_module_files_folders_urls',
				// typeAlias
				'com_componentbuilder.joomla_module_files_folders_urls',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_module_files_folders_urls","key": "id","type": "Joomla_module_files_folders_urlsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_module","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_module":"joomla_module"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_module_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_module"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_module","targetTable": "#__componentbuilder_joomla_module","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Joomla plugin group Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin_group',
				// typeAlias
				'com_componentbuilder.joomla_plugin_group',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin_group","key": "id","type": "Joomla_plugin_groupTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","class_extends":"class_extends"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin_group.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","class_extends"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "class_extends","targetTable": "#__componentbuilder_class_extends","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Install Joomla plugin updates Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin_updates',
				// typeAlias
				'com_componentbuilder.joomla_plugin_updates',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin_updates","key": "id","type": "Joomla_plugin_updatesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_plugin","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_plugin":"joomla_plugin"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin","targetTable": "#__componentbuilder_joomla_plugin","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Install Joomla plugin files folders urls Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin_files_folders_urls',
				// typeAlias
				'com_componentbuilder.joomla_plugin_files_folders_urls',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin_files_folders_urls","key": "id","type": "Joomla_plugin_files_folders_urlsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_plugin","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_plugin":"joomla_plugin"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin","targetTable": "#__componentbuilder_joomla_plugin","targetColumn": "id","displayColumn": "system_name"}]}'
			);


			// Fix the assets table rules column size.
			$this->setDatabaseAssetsRulesFix(99520, "MEDIUMTEXT");
			// Install the global extension params.
			$this->setExtensionsParams(
				'{"autorName":"Llewellyn van der Merwe","autorEmail":"joomla@vdm.io","subform_layouts":"default","editor":"none","manage_jcb_package_directories":"2","set_browser_storage":"1","storage_time_to_live":"global","super_powers_documentation":"0","powers_repository":"0","super_powers_repositories":"0","approved_paths":"default","add_custom_gitea_url":"1","custom_gitea_url":"https://git.vdm.dev","super_powers_core_organisation":"joomla","super_powers_core":"joomla/super-powers","builder_gif_size":"480-272","compiler_plugin":["componentbuilderactionlogcompiler","componentbuilderfieldorderingcompiler","componentbuilderheaderscompiler","componentbuilderpowersautoloadercompiler","componentbuilderprivacycompiler"],"add_menu_prefix":"1","menu_prefix":"»","namespace_prefix":"JCB","minify":"0","language":"en-GB","percentagelanguageadd":"30","assets_table_fix":"2","compiler_field_builder_type":"2","field_name_builder":"1","type_name_builder":"1","import_guid_only":"1","export_language_strings":"1","development_method":"1","expansion":"0","return_options_build":"2","cronjob_backup_type":"1","cronjob_backup_server":"0","backup_package_name":"JCB_Backup_[YEAR]_[MONTH]_[DAY]","export_license":"GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html","export_copyright":"Copyright (C) 2015. All Rights Reserved","check_in":"-1 day","save_history":"1","history_limit":"10","add_jquery_framework":"1","uikit_load":"1","uikit_min":"","uikit_style":""}'
			);


			echo '<div style="background-color: #fff;" class="alert alert-info"><a target="_blank" href="https://dev.vdm.io" title="Component Builder">
				<img src="components/com_componentbuilder/assets/images/vdm-component.jpg"/>
				</a></div>';

			// Add component to the action logs extensions table.
			$this->setActionLogsExtensions();

			// Add Joomla_component to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_COMPONENT',
				// typeAlias
				'com_componentbuilder.joomla_component',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_component',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_module to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_MODULE',
				// typeAlias
				'com_componentbuilder.joomla_module',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_module',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_plugin to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN',
				// typeAlias
				'com_componentbuilder.joomla_plugin',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_plugin',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Power to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'POWER',
				// typeAlias
				'com_componentbuilder.power',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_power',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Admin_view to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_VIEW',
				// typeAlias
				'com_componentbuilder.admin_view',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_admin_view',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Custom_admin_view to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CUSTOM_ADMIN_VIEW',
				// typeAlias
				'com_componentbuilder.custom_admin_view',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_custom_admin_view',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Site_view to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SITE_VIEW',
				// typeAlias
				'com_componentbuilder.site_view',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_site_view',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Template to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'TEMPLATE',
				// typeAlias
				'com_componentbuilder.template',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_template',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Layout to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LAYOUT',
				// typeAlias
				'com_componentbuilder.layout',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_layout',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Dynamic_get to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'DYNAMIC_GET',
				// typeAlias
				'com_componentbuilder.dynamic_get',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_dynamic_get',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Custom_code to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CUSTOM_CODE',
				// typeAlias
				'com_componentbuilder.custom_code',
				// idHolder
				'id',
				// titleHolder
				'component',
				// tableName
				'#__componentbuilder_custom_code',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Class_property to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CLASS_PROPERTY',
				// typeAlias
				'com_componentbuilder.class_property',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_class_property',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Class_method to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CLASS_METHOD',
				// typeAlias
				'com_componentbuilder.class_method',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_class_method',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Placeholder to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'PLACEHOLDER',
				// typeAlias
				'com_componentbuilder.placeholder',
				// idHolder
				'id',
				// titleHolder
				'target',
				// tableName
				'#__componentbuilder_placeholder',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Library to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LIBRARY',
				// typeAlias
				'com_componentbuilder.library',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_library',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Snippet to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SNIPPET',
				// typeAlias
				'com_componentbuilder.snippet',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_snippet',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Validation_rule to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'VALIDATION_RULE',
				// typeAlias
				'com_componentbuilder.validation_rule',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_validation_rule',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Field to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'FIELD',
				// typeAlias
				'com_componentbuilder.field',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_field',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Fieldtype to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'FIELDTYPE',
				// typeAlias
				'com_componentbuilder.fieldtype',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_fieldtype',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Language_translation to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LANGUAGE_TRANSLATION',
				// typeAlias
				'com_componentbuilder.language_translation',
				// idHolder
				'id',
				// titleHolder
				'source',
				// tableName
				'#__componentbuilder_language_translation',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Language to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LANGUAGE',
				// typeAlias
				'com_componentbuilder.language',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_language',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Server to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SERVER',
				// typeAlias
				'com_componentbuilder.server',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_server',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Help_document to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'HELP_DOCUMENT',
				// typeAlias
				'com_componentbuilder.help_document',
				// idHolder
				'id',
				// titleHolder
				'title',
				// tableName
				'#__componentbuilder_help_document',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Admin_fields to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_FIELDS',
				// typeAlias
				'com_componentbuilder.admin_fields',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_fields',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Admin_fields_conditions to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_FIELDS_CONDITIONS',
				// typeAlias
				'com_componentbuilder.admin_fields_conditions',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_fields_conditions',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Admin_fields_relations to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_FIELDS_RELATIONS',
				// typeAlias
				'com_componentbuilder.admin_fields_relations',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_fields_relations',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Admin_custom_tabs to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_CUSTOM_TABS',
				// typeAlias
				'com_componentbuilder.admin_custom_tabs',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_custom_tabs',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_admin_views to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_ADMIN_VIEWS',
				// typeAlias
				'com_componentbuilder.component_admin_views',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_admin_views',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_site_views to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_SITE_VIEWS',
				// typeAlias
				'com_componentbuilder.component_site_views',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_site_views',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_custom_admin_views to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_CUSTOM_ADMIN_VIEWS',
				// typeAlias
				'com_componentbuilder.component_custom_admin_views',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_custom_admin_views',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_updates to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_UPDATES',
				// typeAlias
				'com_componentbuilder.component_updates',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_updates',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_mysql_tweaks to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_MYSQL_TWEAKS',
				// typeAlias
				'com_componentbuilder.component_mysql_tweaks',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_mysql_tweaks',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_custom_admin_menus to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_CUSTOM_ADMIN_MENUS',
				// typeAlias
				'com_componentbuilder.component_custom_admin_menus',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_custom_admin_menus',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_router to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_ROUTER',
				// typeAlias
				'com_componentbuilder.component_router',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_router',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_config to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_CONFIG',
				// typeAlias
				'com_componentbuilder.component_config',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_config',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_dashboard to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_DASHBOARD',
				// typeAlias
				'com_componentbuilder.component_dashboard',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_dashboard',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_files_folders to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_FILES_FOLDERS',
				// typeAlias
				'com_componentbuilder.component_files_folders',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_files_folders',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_placeholders to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_PLACEHOLDERS',
				// typeAlias
				'com_componentbuilder.component_placeholders',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_placeholders',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_plugins to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_PLUGINS',
				// typeAlias
				'com_componentbuilder.component_plugins',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_plugins',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Component_modules to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_MODULES',
				// typeAlias
				'com_componentbuilder.component_modules',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_modules',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Snippet_type to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SNIPPET_TYPE',
				// typeAlias
				'com_componentbuilder.snippet_type',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_snippet_type',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Library_config to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LIBRARY_CONFIG',
				// typeAlias
				'com_componentbuilder.library_config',
				// idHolder
				'id',
				// titleHolder
				'library',
				// tableName
				'#__componentbuilder_library_config',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Library_files_folders_urls to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LIBRARY_FILES_FOLDERS_URLS',
				// typeAlias
				'com_componentbuilder.library_files_folders_urls',
				// idHolder
				'id',
				// titleHolder
				'library',
				// tableName
				'#__componentbuilder_library_files_folders_urls',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Class_extends to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CLASS_EXTENDS',
				// typeAlias
				'com_componentbuilder.class_extends',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_class_extends',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_module_updates to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_MODULE_UPDATES',
				// typeAlias
				'com_componentbuilder.joomla_module_updates',
				// idHolder
				'id',
				// titleHolder
				'joomla_module',
				// tableName
				'#__componentbuilder_joomla_module_updates',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_module_files_folders_urls to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_MODULE_FILES_FOLDERS_URLS',
				// typeAlias
				'com_componentbuilder.joomla_module_files_folders_urls',
				// idHolder
				'id',
				// titleHolder
				'joomla_module',
				// tableName
				'#__componentbuilder_joomla_module_files_folders_urls',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_plugin_group to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN_GROUP',
				// typeAlias
				'com_componentbuilder.joomla_plugin_group',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_joomla_plugin_group',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_plugin_updates to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN_UPDATES',
				// typeAlias
				'com_componentbuilder.joomla_plugin_updates',
				// idHolder
				'id',
				// titleHolder
				'joomla_plugin',
				// tableName
				'#__componentbuilder_joomla_plugin_updates',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_plugin_files_folders_urls to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN_FILES_FOLDERS_URLS',
				// typeAlias
				'com_componentbuilder.joomla_plugin_files_folders_urls',
				// idHolder
				'id',
				// titleHolder
				'joomla_plugin',
				// tableName
				'#__componentbuilder_joomla_plugin_files_folders_urls',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Field to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'FIELD',
				// typeAlias
				'com_componentbuilder.field',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_field',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add Joomla_component to the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_COMPONENT',
				// typeAlias
				'com_componentbuilder.joomla_component',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_component',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);
		}

		// do any updates needed
		if ($type === 'update')
		{

			// Update Joomla component Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_component',
				// typeAlias
				'com_componentbuilder.joomla_component',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_component","key": "id","type": "Joomla_componentTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "php_method_uninstall","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","short_description":"short_description","companyname":"companyname","buildcompsql":"buildcompsql","translation_tool":"translation_tool","add_sales_server":"add_sales_server","php_method_uninstall":"php_method_uninstall","php_preflight_install":"php_preflight_install","css_admin":"css_admin","mvc_versiondate":"mvc_versiondate","remove_line_breaks":"remove_line_breaks","add_placeholders":"add_placeholders","debug_linenr":"debug_linenr","php_site_event":"php_site_event","description":"description","author":"author","php_postflight_install":"php_postflight_install","email":"email","sql_uninstall":"sql_uninstall","website":"website","add_license":"add_license","backup_folder_path":"backup_folder_path","php_helper_both":"php_helper_both","crowdin_username":"crowdin_username","php_admin_event":"php_admin_event","license_type":"license_type","component_version":"component_version","php_helper_admin":"php_helper_admin","php_helper_site":"php_helper_site","whmcs_key":"whmcs_key","javascript":"javascript","whmcs_url":"whmcs_url","css_site":"css_site","whmcs_buy_link":"whmcs_buy_link","license":"license","php_preflight_update":"php_preflight_update","bom":"bom","php_postflight_update":"php_postflight_update","image":"image","sql":"sql","copyright":"copyright","addreadme":"addreadme","preferred_joomla_version":"preferred_joomla_version","update_server_url":"update_server_url","add_powers":"add_powers","add_backup_folder_path":"add_backup_folder_path","crowdin_project_identifier":"crowdin_project_identifier","add_php_helper_both":"add_php_helper_both","add_php_helper_admin":"add_php_helper_admin","add_admin_event":"add_admin_event","add_php_helper_site":"add_php_helper_site","add_site_event":"add_site_event","add_namespace_prefix":"add_namespace_prefix","add_javascript":"add_javascript","namespace_prefix":"namespace_prefix","add_css_admin":"add_css_admin","add_css_site":"add_css_site","add_menu_prefix":"add_menu_prefix","dashboard_type":"dashboard_type","menu_prefix":"menu_prefix","dashboard":"dashboard","add_php_preflight_install":"add_php_preflight_install","add_php_preflight_update":"add_php_preflight_update","toignore":"toignore","add_php_postflight_install":"add_php_postflight_install","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","export_key":"export_key","add_sql":"add_sql","joomla_source_link":"joomla_source_link","add_sql_uninstall":"add_sql_uninstall","export_buy_link":"export_buy_link","assets_table_fix":"assets_table_fix","readme":"readme","add_update_server":"add_update_server","update_server_target":"update_server_target","emptycontributors":"emptycontributors","number":"number","update_server":"update_server","sales_server":"sales_server","add_git_folder_path":"add_git_folder_path","git_folder_path":"git_folder_path","crowdin_project_api_key":"crowdin_project_api_key","creatuserhelper":"creatuserhelper","crowdin_account_api_key":"crowdin_account_api_key","adduikit":"adduikit","buildcomp":"buildcomp","addfootable":"addfootable","guid":"guid","add_email_helper":"add_email_helper","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","translation_tool","add_sales_server","mvc_versiondate","remove_line_breaks","add_placeholders","debug_linenr","add_license","license_type","addreadme","preferred_joomla_version","add_powers","add_backup_folder_path","add_php_helper_both","add_php_helper_admin","add_admin_event","add_php_helper_site","add_site_event","add_javascript","add_css_admin","add_css_site","dashboard_type","add_php_preflight_install","add_php_preflight_update","add_php_postflight_install","add_php_postflight_update","add_php_method_uninstall","add_sql","add_sql_uninstall","assets_table_fix","add_update_server","update_server_target","emptycontributors","number","update_server","sales_server","add_git_folder_path","creatuserhelper","adduikit","buildcomp","addfootable","add_email_helper"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dashboard","targetTable": "#__componentbuilder_custom_admin_view","targetColumn": "","displayColumn": "system_name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Joomla module Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_module',
				// typeAlias
				'com_componentbuilder.joomla_module',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_module","key": "id","type": "Joomla_moduleTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "default","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","target":"target","description":"description","add_php_method_uninstall":"add_php_method_uninstall","add_php_postflight_update":"add_php_postflight_update","add_php_postflight_install":"add_php_postflight_install","add_php_preflight_uninstall":"add_php_preflight_uninstall","addreadme":"addreadme","default":"default","snippet":"snippet","add_sql":"add_sql","update_server_target":"update_server_target","add_sql_uninstall":"add_sql_uninstall","update_server":"update_server","add_update_server":"add_update_server","libraries":"libraries","module_version":"module_version","sales_server":"sales_server","custom_get":"custom_get","php_preflight_update":"php_preflight_update","php_preflight_uninstall":"php_preflight_uninstall","mod_code":"mod_code","php_postflight_install":"php_postflight_install","add_class_helper":"add_class_helper","php_postflight_update":"php_postflight_update","add_class_helper_header":"add_class_helper_header","php_method_uninstall":"php_method_uninstall","class_helper_header":"class_helper_header","sql":"sql","class_helper_code":"class_helper_code","sql_uninstall":"sql_uninstall","readme":"readme","add_php_script_construct":"add_php_script_construct","update_server_url":"update_server_url","php_script_construct":"php_script_construct","add_php_preflight_install":"add_php_preflight_install","php_preflight_install":"php_preflight_install","add_sales_server":"add_sales_server","add_php_preflight_update":"add_php_preflight_update","guid":"guid","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_module.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","target","add_php_method_uninstall","add_php_postflight_update","add_php_postflight_install","add_php_preflight_uninstall","addreadme","snippet","add_sql","update_server_target","add_sql_uninstall","update_server","add_update_server","sales_server","add_class_helper","add_class_helper_header","add_php_script_construct","add_php_preflight_install","add_sales_server","add_php_preflight_update"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Joomla plugin Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin',
				// typeAlias
				'com_componentbuilder.joomla_plugin',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin","key": "id","type": "Joomla_pluginTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "head","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","class_extends":"class_extends","joomla_plugin_group":"joomla_plugin_group","add_sql":"add_sql","add_php_method_uninstall":"add_php_method_uninstall","add_php_postflight_update":"add_php_postflight_update","add_php_postflight_install":"add_php_postflight_install","sales_server":"sales_server","add_update_server":"add_update_server","add_head":"add_head","add_sql_uninstall":"add_sql_uninstall","addreadme":"addreadme","head":"head","update_server_target":"update_server_target","main_class_code":"main_class_code","update_server":"update_server","description":"description","php_postflight_install":"php_postflight_install","plugin_version":"plugin_version","php_postflight_update":"php_postflight_update","php_method_uninstall":"php_method_uninstall","add_php_script_construct":"add_php_script_construct","sql":"sql","php_script_construct":"php_script_construct","sql_uninstall":"sql_uninstall","add_php_preflight_install":"add_php_preflight_install","readme":"readme","php_preflight_install":"php_preflight_install","update_server_url":"update_server_url","add_php_preflight_update":"add_php_preflight_update","php_preflight_update":"php_preflight_update","add_php_preflight_uninstall":"add_php_preflight_uninstall","add_sales_server":"add_sales_server","php_preflight_uninstall":"php_preflight_uninstall","guid":"guid","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","class_extends","joomla_plugin_group","add_sql","add_php_method_uninstall","add_php_postflight_update","add_php_postflight_install","sales_server","add_update_server","add_head","add_sql_uninstall","addreadme","update_server_target","update_server","add_php_script_construct","add_php_preflight_install","add_php_preflight_update","add_php_preflight_uninstall","add_sales_server"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "class_extends","targetTable": "#__componentbuilder_class_extends","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin_group","targetTable": "#__componentbuilder_joomla_plugin_group","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Power Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Power',
				// typeAlias
				'com_componentbuilder.power',
				// table
				'{"special": {"dbtable": "#__componentbuilder_power","key": "id","type": "PowerTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "head","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","namespace":"namespace","type":"type","power_version":"power_version","licensing_template":"licensing_template","description":"description","extends":"extends","approved":"approved","add_head":"add_head","extends_custom":"extends_custom","implements_custom":"implements_custom","implements":"implements","head":"head","approved_paths":"approved_paths","main_class_code":"main_class_code","add_licensing_template":"add_licensing_template","guid":"guid","name":"name"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/power.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","approved","add_head","add_licensing_template"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "extends","targetTable": "#__componentbuilder_power","targetColumn": "guid","displayColumn": "name"},{"sourceColumn": "implements","targetTable": "#__componentbuilder_power","targetColumn": "guid","displayColumn": "name"}]}'
			);
			// Update Admin view Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_view',
				// typeAlias
				'com_componentbuilder.admin_view',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_view","key": "id","type": "Admin_viewTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "php_allowedit","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","short_description":"short_description","php_allowedit":"php_allowedit","php_postsavehook":"php_postsavehook","php_before_save":"php_before_save","php_getlistquery":"php_getlistquery","php_import_ext":"php_import_ext","icon":"icon","php_after_publish":"php_after_publish","add_fadein":"add_fadein","description":"description","icon_category":"icon_category","icon_add":"icon_add","php_after_cancel":"php_after_cancel","mysql_table_charset":"mysql_table_charset","php_batchmove":"php_batchmove","type":"type","php_after_delete":"php_after_delete","source":"source","php_import":"php_import","php_getitems_after_all":"php_getitems_after_all","php_getform":"php_getform","php_save":"php_save","php_allowadd":"php_allowadd","php_before_cancel":"php_before_cancel","php_batchcopy":"php_batchcopy","php_before_publish":"php_before_publish","alias_builder_type":"alias_builder_type","php_before_delete":"php_before_delete","php_document":"php_document","mysql_table_row_format":"mysql_table_row_format","alias_builder":"alias_builder","sql":"sql","php_import_display":"php_import_display","add_category_submenu":"add_category_submenu","php_import_setdata":"php_import_setdata","name_list":"name_list","add_php_getlistquery":"add_php_getlistquery","add_css_view":"add_css_view","add_php_getform":"add_php_getform","css_view":"css_view","add_php_before_save":"add_php_before_save","add_css_views":"add_css_views","add_php_save":"add_php_save","css_views":"css_views","add_php_postsavehook":"add_php_postsavehook","add_javascript_view_file":"add_javascript_view_file","add_php_allowadd":"add_php_allowadd","javascript_view_file":"javascript_view_file","add_php_allowedit":"add_php_allowedit","add_javascript_view_footer":"add_javascript_view_footer","add_php_before_cancel":"add_php_before_cancel","javascript_view_footer":"javascript_view_footer","add_php_after_cancel":"add_php_after_cancel","add_javascript_views_file":"add_javascript_views_file","add_php_batchcopy":"add_php_batchcopy","javascript_views_file":"javascript_views_file","add_php_batchmove":"add_php_batchmove","add_javascript_views_footer":"add_javascript_views_footer","add_php_before_publish":"add_php_before_publish","javascript_views_footer":"javascript_views_footer","add_php_after_publish":"add_php_after_publish","add_custom_button":"add_custom_button","add_php_before_delete":"add_php_before_delete","add_php_after_delete":"add_php_after_delete","php_controller":"php_controller","add_php_document":"add_php_document","php_model":"php_model","mysql_table_engine":"mysql_table_engine","php_controller_list":"php_controller_list","mysql_table_collate":"mysql_table_collate","php_model_list":"php_model_list","add_sql":"add_sql","add_php_ajax":"add_php_ajax","php_ajaxmethod":"php_ajaxmethod","add_custom_import":"add_custom_import","add_php_getitem":"add_php_getitem","html_import_view":"html_import_view","php_getitem":"php_getitem","php_import_headers":"php_import_headers","add_php_getitems":"add_php_getitems","php_import_save":"php_import_save","php_getitems":"php_getitems","guid":"guid","add_php_getitems_after_all":"add_php_getitems_after_all"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","add_fadein","type","source","add_category_submenu","add_php_getlistquery","add_css_view","add_php_getform","add_php_before_save","add_css_views","add_php_save","add_php_postsavehook","add_javascript_view_file","add_php_allowadd","add_php_allowedit","add_javascript_view_footer","add_php_before_cancel","add_php_after_cancel","add_javascript_views_file","add_php_batchcopy","add_php_batchmove","add_javascript_views_footer","add_php_before_publish","add_php_after_publish","add_custom_button","add_php_before_delete","add_php_after_delete","add_php_document","add_sql","add_php_ajax","add_custom_import","add_php_getitem","add_php_getitems","add_php_getitems_after_all"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "alias_builder","targetTable": "#__componentbuilder_field","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Custom admin view Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Custom_admin_view',
				// typeAlias
				'com_componentbuilder.custom_admin_view',
				// table
				'{"special": {"dbtable": "#__componentbuilder_custom_admin_view","key": "id","type": "Custom_admin_viewTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "css_document","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","description":"description","main_get":"main_get","add_php_jview_display":"add_php_jview_display","css_document":"css_document","css":"css","js_document":"js_document","javascript_file":"javascript_file","codename":"codename","default":"default","snippet":"snippet","icon":"icon","add_php_jview":"add_php_jview","context":"context","add_js_document":"add_js_document","custom_get":"custom_get","add_javascript_file":"add_javascript_file","php_ajaxmethod":"php_ajaxmethod","add_css_document":"add_css_document","add_php_document":"add_php_document","add_css":"add_css","add_php_view":"add_php_view","add_php_ajax":"add_php_ajax","libraries":"libraries","dynamic_get":"dynamic_get","php_document":"php_document","php_view":"php_view","add_custom_button":"add_custom_button","php_jview_display":"php_jview_display","php_jview":"php_jview","php_controller":"php_controller","guid":"guid","php_model":"php_model"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/custom_admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","main_get","add_php_jview_display","snippet","add_php_jview","add_js_document","add_javascript_file","add_css_document","add_php_document","add_css","add_php_view","add_php_ajax","dynamic_get","add_custom_button"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Site view Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Site_view',
				// typeAlias
				'com_componentbuilder.site_view',
				// table
				'{"special": {"dbtable": "#__componentbuilder_site_view","key": "id","type": "Site_viewTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "js_document","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","description":"description","main_get":"main_get","add_php_jview_display":"add_php_jview_display","add_php_document":"add_php_document","add_php_view":"add_php_view","js_document":"js_document","codename":"codename","javascript_file":"javascript_file","context":"context","default":"default","snippet":"snippet","add_php_jview":"add_php_jview","custom_get":"custom_get","css_document":"css_document","add_javascript_file":"add_javascript_file","css":"css","add_js_document":"add_js_document","php_ajaxmethod":"php_ajaxmethod","add_css_document":"add_css_document","libraries":"libraries","add_css":"add_css","dynamic_get":"dynamic_get","add_php_ajax":"add_php_ajax","add_custom_button":"add_custom_button","php_document":"php_document","button_position":"button_position","php_view":"php_view","php_jview_display":"php_jview_display","php_jview":"php_jview","php_controller":"php_controller","guid":"guid","php_model":"php_model"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/site_view.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","main_get","add_php_jview_display","add_php_document","add_php_view","snippet","add_php_jview","add_javascript_file","add_js_document","add_css_document","add_css","dynamic_get","add_php_ajax","add_custom_button","button_position"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Template Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Template',
				// typeAlias
				'com_componentbuilder.template',
				// table
				'{"special": {"dbtable": "#__componentbuilder_template","key": "id","type": "TemplateTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "php_view","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","dynamic_get":"dynamic_get","php_view":"php_view","add_php_view":"add_php_view","template":"template","snippet":"snippet","libraries":"libraries","alias":"alias"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/template.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","dynamic_get","add_php_view","snippet"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Layout Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Layout',
				// typeAlias
				'com_componentbuilder.layout',
				// table
				'{"special": {"dbtable": "#__componentbuilder_layout","key": "id","type": "LayoutTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "php_view","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","php_view":"php_view","add_php_view":"add_php_view","layout":"layout","libraries":"libraries","alias":"alias"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/layout.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","dynamic_get","snippet","add_php_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Dynamic get Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Dynamic_get',
				// typeAlias
				'com_componentbuilder.dynamic_get',
				// table
				'{"special": {"dbtable": "#__componentbuilder_dynamic_get","key": "id","type": "Dynamic_getTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "php_calculation","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","php_calculation":"php_calculation","php_router_parse":"php_router_parse","add_php_after_getitems":"add_php_after_getitems","add_php_router_parse":"add_php_router_parse","view_selection":"view_selection","add_php_before_getitems":"add_php_before_getitems","add_php_before_getitem":"add_php_before_getitem","add_php_after_getitem":"add_php_after_getitem","db_table_main":"db_table_main","php_custom_get":"php_custom_get","plugin_events":"plugin_events","db_selection":"db_selection","view_table_main":"view_table_main","add_php_getlistquery":"add_php_getlistquery","select_all":"select_all","php_before_getitem":"php_before_getitem","getcustom":"getcustom","php_after_getitem":"php_after_getitem","pagination":"pagination","php_getlistquery":"php_getlistquery","php_before_getitems":"php_before_getitems","php_after_getitems":"php_after_getitems","addcalculation":"addcalculation","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","main_source","gettype","add_php_after_getitems","add_php_router_parse","add_php_before_getitems","add_php_before_getitem","add_php_after_getitem","view_table_main","add_php_getlistquery","select_all","pagination"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Custom code Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Custom_code',
				// typeAlias
				'com_componentbuilder.custom_code',
				// table
				'{"special": {"dbtable": "#__componentbuilder_custom_code","key": "id","type": "Custom_codeTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "code","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","joomla_version":"joomla_version","function_name":"function_name","system_name":"system_name","code":"code","hashendtarget":"hashendtarget","to_line":"to_line","from_line":"from_line","hashtarget":"hashtarget"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/custom_code.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","component","target","type","comment_type","joomla_version"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Class property Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Class_property',
				// typeAlias
				'com_componentbuilder.class_property',
				// table
				'{"special": {"dbtable": "#__componentbuilder_class_property","key": "id","type": "Class_propertyTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","visibility":"visibility","extension_type":"extension_type","guid":"guid","comment":"comment","joomla_plugin_group":"joomla_plugin_group","default":"default"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/class_property.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin_group"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin_group","targetTable": "#__componentbuilder_joomla_plugin_group","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Class method Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Class_method',
				// typeAlias
				'com_componentbuilder.class_method',
				// table
				'{"special": {"dbtable": "#__componentbuilder_class_method","key": "id","type": "Class_methodTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "code","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","visibility":"visibility","extension_type":"extension_type","guid":"guid","code":"code","comment":"comment","joomla_plugin_group":"joomla_plugin_group","arguments":"arguments"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/class_method.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin_group"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin_group","targetTable": "#__componentbuilder_joomla_plugin_group","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Placeholder Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Placeholder',
				// typeAlias
				'com_componentbuilder.placeholder',
				// table
				'{"special": {"dbtable": "#__componentbuilder_placeholder","key": "id","type": "PlaceholderTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "target","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"target":"target","value":"value"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/placeholder.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Library Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Library',
				// typeAlias
				'com_componentbuilder.library',
				// table
				'{"special": {"dbtable": "#__componentbuilder_library","key": "id","type": "LibraryTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","target":"target","how":"how","type":"type","description":"description","libraries":"libraries","php_setdocument":"php_setdocument","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/library.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","target","how","type"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Snippet Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Snippet',
				// typeAlias
				'com_componentbuilder.snippet',
				// table
				'{"special": {"dbtable": "#__componentbuilder_snippet","key": "id","type": "SnippetTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","url":"url","type":"type","heading":"heading","library":"library","guid":"guid","contributor_email":"contributor_email","contributor_name":"contributor_name","contributor_website":"contributor_website","contributor_company":"contributor_company","snippet":"snippet","usage":"usage","description":"description"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/snippet.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","type","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "type","targetTable": "#__componentbuilder_snippet_type","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Validation rule Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Validation_rule',
				// typeAlias
				'com_componentbuilder.validation_rule',
				// table
				'{"special": {"dbtable": "#__componentbuilder_validation_rule","key": "id","type": "Validation_ruleTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","short_description":"short_description","inherit":"inherit","php":"php"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/validation_rule.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "inherit","targetTable": "#__componentbuilder_validation_rule","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Field Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Field',
				// typeAlias
				'com_componentbuilder.field',
				// table
				'{"special": {"dbtable": "#__componentbuilder_field","key": "id","type": "FieldTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "css_views","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","store":"store","on_save_model_field":"on_save_model_field","initiator_on_get_model":"initiator_on_get_model","initiator_on_save_model":"initiator_on_save_model","xml":"xml","datalenght":"datalenght","css_views":"css_views","css_view":"css_view","datadefault_other":"datadefault_other","datadefault":"datadefault","datalenght_other":"datalenght_other","on_get_model_field":"on_get_model_field","javascript_view_footer":"javascript_view_footer","javascript_views_footer":"javascript_views_footer","add_css_view":"add_css_view","add_css_views":"add_css_views","add_javascript_view_footer":"add_javascript_view_footer","add_javascript_views_footer":"add_javascript_views_footer","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","xml"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","fieldtype","store","catid","add_css_view","add_css_views","add_javascript_view_footer","add_javascript_views_footer"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Field category Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Field Catid',
				// typeAlias
				'com_componentbuilder.field.category',
				// table
				'{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}',
				// rules
				'',
				// fieldMappings
				'{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile":"administrator\/components\/com_categories\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'
			);
			// Update Fieldtype Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Fieldtype',
				// typeAlias
				'com_componentbuilder.fieldtype',
				// table
				'{"special": {"dbtable": "#__componentbuilder_fieldtype","key": "id","type": "FieldtypeTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","store":"store","null_switch":"null_switch","indexes":"indexes","datadefault_other":"datadefault_other","datadefault":"datadefault","short_description":"short_description","datatype":"datatype","has_defaults":"has_defaults","description":"description","datalenght":"datalenght","datalenght_other":"datalenght_other","guid":"guid"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/fieldtype.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","store","has_defaults","catid"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Fieldtype category Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Fieldtype Catid',
				// typeAlias
				'com_componentbuilder.fieldtype.category',
				// table
				'{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}',
				// rules
				'',
				// fieldMappings
				'{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile":"administrator\/components\/com_categories\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}'
			);
			// Update Language translation Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Language_translation',
				// typeAlias
				'com_componentbuilder.language_translation',
				// table
				'{"special": {"dbtable": "#__componentbuilder_language_translation","key": "id","type": "Language_translationTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "source","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"source":"source","plugins":"plugins","modules":"modules","components":"components"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/language_translation.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "plugins","targetTable": "#__componentbuilder_joomla_plugin","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "modules","targetTable": "#__componentbuilder_joomla_module","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "components","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Language Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Language',
				// typeAlias
				'com_componentbuilder.language',
				// table
				'{"special": {"dbtable": "#__componentbuilder_language","key": "id","type": "LanguageTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","langtag":"langtag"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/language.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Server Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Server',
				// typeAlias
				'com_componentbuilder.server',
				// table
				'{"special": {"dbtable": "#__componentbuilder_server","key": "id","type": "ServerTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","protocol":"protocol","signature":"signature","private_key":"private_key","secret":"secret","password":"password","private":"private","authentication":"authentication","path":"path","port":"port","host":"host","username":"username"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/server.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","protocol","authentication"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Help document Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Help_document',
				// typeAlias
				'com_componentbuilder.help_document',
				// table
				'{"special": {"dbtable": "#__componentbuilder_help_document","key": "id","type": "Help_documentTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "title","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "content","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "null","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"title":"title","type":"type","groups":"groups","location":"location","admin_view":"admin_view","site_view":"site_view","not_required":"not_required","content":"content","article":"article","url":"url","target":"target","alias":"alias"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/help_document.xml","hideFields": ["asset_id","checked_out","checked_out_time","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","type","location","not_required","article","target"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "article","targetTable": "#__content","targetColumn": "id","displayColumn": "title"}]}'
			);
			// Update Admin fields Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_fields',
				// typeAlias
				'com_componentbuilder.admin_fields',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_fields","key": "id","type": "Admin_fieldsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_fields.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Admin fields conditions Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_fields_conditions',
				// typeAlias
				'com_componentbuilder.admin_fields_conditions',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_fields_conditions","key": "id","type": "Admin_fields_conditionsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_fields_conditions.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Admin fields relations Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_fields_relations',
				// typeAlias
				'com_componentbuilder.admin_fields_relations',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_fields_relations","key": "id","type": "Admin_fields_relationsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_fields_relations.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Admin custom tabs Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Admin_custom_tabs',
				// typeAlias
				'com_componentbuilder.admin_custom_tabs',
				// table
				'{"special": {"dbtable": "#__componentbuilder_admin_custom_tabs","key": "id","type": "Admin_custom_tabsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/admin_custom_tabs.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component admin views Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_admin_views',
				// typeAlias
				'com_componentbuilder.component_admin_views',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_admin_views","key": "id","type": "Component_admin_viewsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component site views Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_site_views',
				// typeAlias
				'com_componentbuilder.component_site_views',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_site_views","key": "id","type": "Component_site_viewsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_site_views.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component custom admin views Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_custom_admin_views',
				// typeAlias
				'com_componentbuilder.component_custom_admin_views',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_custom_admin_views","key": "id","type": "Component_custom_admin_viewsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_custom_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component updates Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_updates',
				// typeAlias
				'com_componentbuilder.component_updates',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_updates","key": "id","type": "Component_updatesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component mysql tweaks Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_mysql_tweaks',
				// typeAlias
				'com_componentbuilder.component_mysql_tweaks',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_mysql_tweaks","key": "id","type": "Component_mysql_tweaksTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_mysql_tweaks.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component custom admin menus Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_custom_admin_menus',
				// typeAlias
				'com_componentbuilder.component_custom_admin_menus',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_custom_admin_menus","key": "id","type": "Component_custom_admin_menusTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_custom_admin_menus.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component router Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_router',
				// typeAlias
				'com_componentbuilder.component_router',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_router","key": "id","type": "Component_routerTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "methods_code","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component","mode_constructor_before_parent":"mode_constructor_before_parent","mode_constructor_after_parent":"mode_constructor_after_parent","mode_methods":"mode_methods","methods_code":"methods_code","constructor_after_parent_code":"constructor_after_parent_code","constructor_before_parent_code":"constructor_before_parent_code"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_router.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component","mode_constructor_before_parent","mode_constructor_after_parent","mode_methods"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component config Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_config',
				// typeAlias
				'com_componentbuilder.component_config',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_config","key": "id","type": "Component_configTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_config.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component dashboard Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_dashboard',
				// typeAlias
				'com_componentbuilder.component_dashboard',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_dashboard","key": "id","type": "Component_dashboardTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component","php_dashboard_methods":"php_dashboard_methods"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_dashboard.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component files folders Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_files_folders',
				// typeAlias
				'com_componentbuilder.component_files_folders',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_files_folders","key": "id","type": "Component_files_foldersTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_files_folders.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component placeholders Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_placeholders',
				// typeAlias
				'com_componentbuilder.component_placeholders',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_placeholders","key": "id","type": "Component_placeholdersTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_placeholders.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component plugins Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_plugins',
				// typeAlias
				'com_componentbuilder.component_plugins',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_plugins","key": "id","type": "Component_pluginsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_plugins.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Component modules Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Component_modules',
				// typeAlias
				'com_componentbuilder.component_modules',
				// table
				'{"special": {"dbtable": "#__componentbuilder_component_modules","key": "id","type": "Component_modulesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/component_modules.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"},{"sourceColumn": "clone_me","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Snippet type Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Snippet_type',
				// typeAlias
				'com_componentbuilder.snippet_type',
				// table
				'{"special": {"dbtable": "#__componentbuilder_snippet_type","key": "id","type": "Snippet_typeTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/snippet_type.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Library config Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Library_config',
				// typeAlias
				'com_componentbuilder.library_config',
				// table
				'{"special": {"dbtable": "#__componentbuilder_library_config","key": "id","type": "Library_configTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/library_config.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Library files folders urls Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Library_files_folders_urls',
				// typeAlias
				'com_componentbuilder.library_files_folders_urls',
				// table
				'{"special": {"dbtable": "#__componentbuilder_library_files_folders_urls","key": "id","type": "Library_files_folders_urlsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/library_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Class extends Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Class_extends',
				// typeAlias
				'com_componentbuilder.class_extends',
				// table
				'{"special": {"dbtable": "#__componentbuilder_class_extends","key": "id","type": "Class_extendsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "head","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","extension_type":"extension_type","head":"head","comment":"comment"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/class_extends.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Joomla module updates Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_module_updates',
				// typeAlias
				'com_componentbuilder.joomla_module_updates',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_module_updates","key": "id","type": "Joomla_module_updatesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_module","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_module":"joomla_module"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_module_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_module"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_module","targetTable": "#__componentbuilder_joomla_module","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Joomla module files folders urls Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_module_files_folders_urls',
				// typeAlias
				'com_componentbuilder.joomla_module_files_folders_urls',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_module_files_folders_urls","key": "id","type": "Joomla_module_files_folders_urlsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_module","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_module":"joomla_module"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_module_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_module"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_module","targetTable": "#__componentbuilder_joomla_module","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Joomla plugin group Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin_group',
				// typeAlias
				'com_componentbuilder.joomla_plugin_group',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin_group","key": "id","type": "Joomla_plugin_groupTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","class_extends":"class_extends"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin_group.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","class_extends"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "class_extends","targetTable": "#__componentbuilder_class_extends","targetColumn": "id","displayColumn": "name"}]}'
			);
			// Update Joomla plugin updates Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin_updates',
				// typeAlias
				'com_componentbuilder.joomla_plugin_updates',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin_updates","key": "id","type": "Joomla_plugin_updatesTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_plugin","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_plugin":"joomla_plugin"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin","targetTable": "#__componentbuilder_joomla_plugin","targetColumn": "id","displayColumn": "system_name"}]}'
			);
			// Update Joomla plugin files folders urls Content Types.
			$this->setContentType(
				// typeTitle
				'Componentbuilder Joomla_plugin_files_folders_urls',
				// typeAlias
				'com_componentbuilder.joomla_plugin_files_folders_urls',
				// table
				'{"special": {"dbtable": "#__componentbuilder_joomla_plugin_files_folders_urls","key": "id","type": "Joomla_plugin_files_folders_urlsTable","prefix": "VDM\Component\Componentbuilder\Administrator\Table"}}',
				// rules
				'',
				// fieldMappings
				'{"common": {"core_content_item_id": "id","core_title": "joomla_plugin","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_plugin":"joomla_plugin"}}',
				// router
				'',
				// contentHistoryOptions
				'{"formFile": "administrator/components/com_componentbuilder/forms/joomla_plugin_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits","joomla_plugin"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_plugin","targetTable": "#__componentbuilder_joomla_plugin","targetColumn": "id","displayColumn": "system_name"}]}'
			);



			echo '<div style="background-color: #fff;" class="alert alert-info"><a target="_blank" href="https://dev.vdm.io" title="Component Builder">
				<img src="components/com_componentbuilder/assets/images/vdm-component.jpg"/>
				</a>
				<h3>Upgrade to Version 5.0.0-alpha6 Was Successful! Let us know if anything is not working as expected.</h3></div>';

			// Add/Update component in the action logs extensions table.
			$this->setActionLogsExtensions();

			// Add/Update Joomla_component in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_COMPONENT',
				// typeAlias
				'com_componentbuilder.joomla_component',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_component',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_module in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_MODULE',
				// typeAlias
				'com_componentbuilder.joomla_module',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_module',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_plugin in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN',
				// typeAlias
				'com_componentbuilder.joomla_plugin',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_plugin',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Power in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'POWER',
				// typeAlias
				'com_componentbuilder.power',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_power',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Admin_view in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_VIEW',
				// typeAlias
				'com_componentbuilder.admin_view',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_admin_view',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Custom_admin_view in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CUSTOM_ADMIN_VIEW',
				// typeAlias
				'com_componentbuilder.custom_admin_view',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_custom_admin_view',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Site_view in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SITE_VIEW',
				// typeAlias
				'com_componentbuilder.site_view',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_site_view',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Template in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'TEMPLATE',
				// typeAlias
				'com_componentbuilder.template',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_template',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Layout in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LAYOUT',
				// typeAlias
				'com_componentbuilder.layout',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_layout',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Dynamic_get in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'DYNAMIC_GET',
				// typeAlias
				'com_componentbuilder.dynamic_get',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_dynamic_get',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Custom_code in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CUSTOM_CODE',
				// typeAlias
				'com_componentbuilder.custom_code',
				// idHolder
				'id',
				// titleHolder
				'component',
				// tableName
				'#__componentbuilder_custom_code',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Class_property in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CLASS_PROPERTY',
				// typeAlias
				'com_componentbuilder.class_property',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_class_property',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Class_method in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CLASS_METHOD',
				// typeAlias
				'com_componentbuilder.class_method',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_class_method',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Placeholder in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'PLACEHOLDER',
				// typeAlias
				'com_componentbuilder.placeholder',
				// idHolder
				'id',
				// titleHolder
				'target',
				// tableName
				'#__componentbuilder_placeholder',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Library in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LIBRARY',
				// typeAlias
				'com_componentbuilder.library',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_library',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Snippet in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SNIPPET',
				// typeAlias
				'com_componentbuilder.snippet',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_snippet',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Validation_rule in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'VALIDATION_RULE',
				// typeAlias
				'com_componentbuilder.validation_rule',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_validation_rule',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Field in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'FIELD',
				// typeAlias
				'com_componentbuilder.field',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_field',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Fieldtype in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'FIELDTYPE',
				// typeAlias
				'com_componentbuilder.fieldtype',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_fieldtype',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Language_translation in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LANGUAGE_TRANSLATION',
				// typeAlias
				'com_componentbuilder.language_translation',
				// idHolder
				'id',
				// titleHolder
				'source',
				// tableName
				'#__componentbuilder_language_translation',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Language in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LANGUAGE',
				// typeAlias
				'com_componentbuilder.language',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_language',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Server in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SERVER',
				// typeAlias
				'com_componentbuilder.server',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_server',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Help_document in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'HELP_DOCUMENT',
				// typeAlias
				'com_componentbuilder.help_document',
				// idHolder
				'id',
				// titleHolder
				'title',
				// tableName
				'#__componentbuilder_help_document',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Admin_fields in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_FIELDS',
				// typeAlias
				'com_componentbuilder.admin_fields',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_fields',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Admin_fields_conditions in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_FIELDS_CONDITIONS',
				// typeAlias
				'com_componentbuilder.admin_fields_conditions',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_fields_conditions',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Admin_fields_relations in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_FIELDS_RELATIONS',
				// typeAlias
				'com_componentbuilder.admin_fields_relations',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_fields_relations',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Admin_custom_tabs in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'ADMIN_CUSTOM_TABS',
				// typeAlias
				'com_componentbuilder.admin_custom_tabs',
				// idHolder
				'id',
				// titleHolder
				'admin_view',
				// tableName
				'#__componentbuilder_admin_custom_tabs',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_admin_views in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_ADMIN_VIEWS',
				// typeAlias
				'com_componentbuilder.component_admin_views',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_admin_views',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_site_views in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_SITE_VIEWS',
				// typeAlias
				'com_componentbuilder.component_site_views',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_site_views',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_custom_admin_views in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_CUSTOM_ADMIN_VIEWS',
				// typeAlias
				'com_componentbuilder.component_custom_admin_views',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_custom_admin_views',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_updates in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_UPDATES',
				// typeAlias
				'com_componentbuilder.component_updates',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_updates',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_mysql_tweaks in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_MYSQL_TWEAKS',
				// typeAlias
				'com_componentbuilder.component_mysql_tweaks',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_mysql_tweaks',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_custom_admin_menus in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_CUSTOM_ADMIN_MENUS',
				// typeAlias
				'com_componentbuilder.component_custom_admin_menus',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_custom_admin_menus',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_router in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_ROUTER',
				// typeAlias
				'com_componentbuilder.component_router',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_router',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_config in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_CONFIG',
				// typeAlias
				'com_componentbuilder.component_config',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_config',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_dashboard in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_DASHBOARD',
				// typeAlias
				'com_componentbuilder.component_dashboard',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_dashboard',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_files_folders in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_FILES_FOLDERS',
				// typeAlias
				'com_componentbuilder.component_files_folders',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_files_folders',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_placeholders in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_PLACEHOLDERS',
				// typeAlias
				'com_componentbuilder.component_placeholders',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_placeholders',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_plugins in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_PLUGINS',
				// typeAlias
				'com_componentbuilder.component_plugins',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_plugins',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Component_modules in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'COMPONENT_MODULES',
				// typeAlias
				'com_componentbuilder.component_modules',
				// idHolder
				'id',
				// titleHolder
				'joomla_component',
				// tableName
				'#__componentbuilder_component_modules',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Snippet_type in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'SNIPPET_TYPE',
				// typeAlias
				'com_componentbuilder.snippet_type',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_snippet_type',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Library_config in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LIBRARY_CONFIG',
				// typeAlias
				'com_componentbuilder.library_config',
				// idHolder
				'id',
				// titleHolder
				'library',
				// tableName
				'#__componentbuilder_library_config',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Library_files_folders_urls in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'LIBRARY_FILES_FOLDERS_URLS',
				// typeAlias
				'com_componentbuilder.library_files_folders_urls',
				// idHolder
				'id',
				// titleHolder
				'library',
				// tableName
				'#__componentbuilder_library_files_folders_urls',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Class_extends in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'CLASS_EXTENDS',
				// typeAlias
				'com_componentbuilder.class_extends',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_class_extends',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_module_updates in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_MODULE_UPDATES',
				// typeAlias
				'com_componentbuilder.joomla_module_updates',
				// idHolder
				'id',
				// titleHolder
				'joomla_module',
				// tableName
				'#__componentbuilder_joomla_module_updates',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_module_files_folders_urls in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_MODULE_FILES_FOLDERS_URLS',
				// typeAlias
				'com_componentbuilder.joomla_module_files_folders_urls',
				// idHolder
				'id',
				// titleHolder
				'joomla_module',
				// tableName
				'#__componentbuilder_joomla_module_files_folders_urls',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_plugin_group in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN_GROUP',
				// typeAlias
				'com_componentbuilder.joomla_plugin_group',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_joomla_plugin_group',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_plugin_updates in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN_UPDATES',
				// typeAlias
				'com_componentbuilder.joomla_plugin_updates',
				// idHolder
				'id',
				// titleHolder
				'joomla_plugin',
				// tableName
				'#__componentbuilder_joomla_plugin_updates',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_plugin_files_folders_urls in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_PLUGIN_FILES_FOLDERS_URLS',
				// typeAlias
				'com_componentbuilder.joomla_plugin_files_folders_urls',
				// idHolder
				'id',
				// titleHolder
				'joomla_plugin',
				// tableName
				'#__componentbuilder_joomla_plugin_files_folders_urls',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Field in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'FIELD',
				// typeAlias
				'com_componentbuilder.field',
				// idHolder
				'id',
				// titleHolder
				'name',
				// tableName
				'#__componentbuilder_field',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);

			// Add/Update Joomla_component in the action logs config table.
			$this->setActionLogConfig(
				// typeTitle
				'JOOMLA_COMPONENT',
				// typeAlias
				'com_componentbuilder.joomla_component',
				// idHolder
				'id',
				// titleHolder
				'system_name',
				// tableName
				'#__componentbuilder_joomla_component',
				// textPrefix
				'COM_COMPONENTBUILDER'
			);
		}

		// move CLI files
		$this->moveCliFiles();

		// remove old files and folders
		$this->removeFiles();

		return true;
	}

	/**
	 * Remove the files and folders in the given array from
	 *
	 * @return  void
	 *
	 * @since   3.6
	 */
	protected function removeFiles()
	{
		if (!empty($this->deleteFiles))
		{
			foreach ($this->deleteFiles as $file)
			{
				if (is_file(JPATH_ROOT . $file) && !File::delete(JPATH_ROOT . $file))
				{
					echo Text::sprintf('JLIB_INSTALLER_ERROR_FILE_FOLDER', $file) . '<br>';
				}
			}
		}

		if (!empty($this->deleteFolders))
		{
			foreach ($this->deleteFolders as $folder)
			{
				if (is_dir(JPATH_ROOT . $folder) && !Folder::delete(JPATH_ROOT . $folder))
				{
					echo Text::sprintf('JLIB_INSTALLER_ERROR_FILE_FOLDER', $folder) . '<br>';
				}
			}
		}
	}

	/**
	 * Moves the CLI scripts into the CLI folder in the CMS
	 *
	 * @return  void
	 *
	 * @since   3.6
	 */
	protected function moveCliFiles()
	{
		if (!empty($this->cliScriptFiles))
		{
			foreach ($this->cliScriptFiles as $file)
			{
				$name = basename($file);

				if (file_exists(JPATH_ROOT . $file) && !File::move(JPATH_ROOT . $file, JPATH_ROOT . '/cli/' . $name))
				{
					echo Text::sprintf('JLIB_INSTALLER_FILE_ERROR_MOVE', $name);
				}
			}
		}
	}

	/**
	 * Set content type integration
	 *
	 * @param   string   $typeTitle
	 * @param   string   $typeAlias
	 * @param   string   $table
	 * @param   string   $rules
	 * @param   string   $fieldMappings
	 * @param   string   $router
	 * @param   string   $contentHistoryOptions
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function setContentType(
		string $typeTitle,
		string $typeAlias,
		string $table,
		string $rules,
		string $fieldMappings,
		string $router,
		string $contentHistoryOptions): void
	{
		// Create the content type object.
		$content = new stdClass();
		$content->type_title = $typeTitle;
		$content->type_alias = $typeAlias;
		$content->table = $table;
		$content->rules = $rules;
		$content->field_mappings = $fieldMappings;
		$content->router = $router;
		$content->content_history_options = $contentHistoryOptions;

		// Check if content type is already in content_type DB.
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('type_id')));
		$query->from($this->db->quoteName('#__content_types'));
		$query->where($this->db->quoteName('type_alias') . ' LIKE '. $this->db->quote($content->type_alias));

		$this->db->setQuery($query);
		$this->db->execute();

		// Check if the type alias is already in the content types table.
		if ($this->db->getNumRows())
		{
			$content->type_id = $this->db->loadResult();
			if ($this->db->updateObject('#__content_types', $content, 'type_id'))
			{
				// If its successfully update.
				$this->app->enqueueMessage(
					Text::sprintf('The (%s) was found in the <b>#__content_types</b> table, and updated.', $content->type_alias)
				);
			}
		}
		elseif ($this->db->insertObject('#__content_types', $content))
		{
			// If its successfully added.
			$this->app->enqueueMessage(
				Text::sprintf('The (%s) was added to the <b>#__content_types</b> table.', $content->type_alias)
			);
		}
	}

	/**
	 * Set action log config integration
	 *
	 * @param   string   $typeTitle
	 * @param   string   $typeAlias
	 * @param   string   $idHolder
	 * @param   string   $titleHolder
	 * @param   string   $tableName
	 * @param   string   $textPrefix
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function setActionLogConfig(
		string $typeTitle,
		string $typeAlias,
		string $idHolder,
		string $titleHolder,
		string $tableName,
		string $textPrefix): void
	{
		// Create the content action log config object.
		$content = new stdClass();
		$content->type_title = $typeTitle;
		$content->type_alias = $typeAlias;
		$content->id_holder = $idHolder;
		$content->title_holder = $titleHolder;
		$content->table_name = $tableName;
		$content->text_prefix = $textPrefix;

		// Check if the action log config is already in action_log_config DB.
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(['id']));
		$query->from($this->db->quoteName('#__action_log_config'));
		$query->where($this->db->quoteName('type_alias') . ' LIKE '. $this->db->quote($content->type_alias));

		$this->db->setQuery($query);
		$this->db->execute();

		// Check if the type alias is already in the action log config table.
		if ($this->db->getNumRows())
		{
			$content->id = $this->db->loadResult();
			if ($this->db->updateObject('#__action_log_config', $content, 'id'))
			{
				// If its successfully update.
				$this->app->enqueueMessage(
					Text::sprintf('The (%s) was found in the <b>#__action_log_config</b> table, and updated.', $content->type_alias)
				);
			}
		}
		elseif ($this->db->insertObject('#__action_log_config', $content))
		{
			// If its successfully added.
			$this->app->enqueueMessage(
				Text::sprintf('The (%s) was added to the <b>#__action_log_config</b> table.', $content->type_alias)
			);
		}
	}

	/**
	 * Set action logs extensions integration
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function setActionLogsExtensions(): void
	{
		// Create the extension action logs object.
		$data = new stdClass();
		$data->extension = 'com_componentbuilder';

		// Check if componentbuilder action log extension is already in action logs extensions DB.
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(['id']));
		$query->from($this->db->quoteName('#__action_logs_extensions'));
		$query->where($this->db->quoteName('extension') . ' = '. $this->db->quote($data->extension));

		$this->db->setQuery($query);
		$this->db->execute();

		// Set the object into the action logs extensions table if not found.
		if ($this->db->getNumRows())
		{
			// If its already set don't set it again.
			$this->app->enqueueMessage(
				Text::_('The (com_componentbuilder) is already in the <b>#__action_logs_extensions</b> table.')
			);
		}
		elseif ($this->db->insertObject('#__action_logs_extensions', $data))
		{
			// give a success message
			$this->app->enqueueMessage(
				Text::_('The (com_componentbuilder) was successfully added to the <b>#__action_logs_extensions</b> table.')
			);
		}
	}

	/**
	 * Set global extension assets permission of this component
	 *   (on install only)
	 *
	 * @param   string   $rules   The component rules
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function setAssetsRules(string $rules): void
	{
		// Condition.
		$conditions = [
			$this->db->quoteName('name') . ' = ' . $this->db->quote('com_componentbuilder')
		];

		// Field to update.
		$fields = [
			$this->db->quoteName('rules') . ' = ' . $this->db->quote($rules),
		];

		$query = $this->db->getQuery(true);
		$query->update(
			$this->db->quoteName('#__assets')
		)->set($fields)->where($conditions);

		$this->db->setQuery($query);

		$done = $this->db->execute();
		if ($done)
		{
			// give a success message
			$this->app->enqueueMessage(
				Text::_('The (com_componentbuilder) rules was successfully added to the <b>#__assets</b> table.')
			);
		}
	}

	/**
	 * Set global extension params of this component
	 *   (on install only)
	 *
	 * @param   string   $params   The component rules
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function setExtensionsParams(string $params): void
	{
		// Condition.
		$conditions = [
			$this->db->quoteName('element') . ' = ' . $this->db->quote('com_componentbuilder')
		];

		// Field to update.
		$fields = [
			$this->db->quoteName('params') . ' = ' . $this->db->quote($params),
		];

		$query = $this->db->getQuery(true);
		$query->update(
			$this->db->quoteName('#__extensions')
		)->set($fields)->where($conditions);

		$this->db->setQuery($query);

		$done = $this->db->execute();
		if ($done)
		{
			// give a success message
			$this->app->enqueueMessage(
				Text::_('The (com_componentbuilder) params was successfully added to the <b>#__extensions</b> table.')
			);
		}
	}

	/**
	 * Set database fix (if needed)
	 *  => WHY DO WE NEED AN ASSET TABLE FIX?
	 *   https://git.vdm.dev/joomla/Component-Builder/issues/616#issuecomment-12085
	 *   https://www.mysqltutorial.org/mysql-varchar/
	 *   https://stackoverflow.com/a/15227917/1429677
	 *   https://forums.mysql.com/read.php?24,105964,105964
	 *
	 * @param   int     $accessWorseCase   This is the max rules column size com_componentbuilder would needs.
	 * @param   string  $dataType          This datatype we will change the rules column to if it to small.
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function setDatabaseAssetsRulesFix(int $accessWorseCase, string $dataType): void
	{
		// Get the biggest rule column in the assets table at this point.
		$length = "SELECT CHAR_LENGTH(`rules`) as rule_size FROM #__assets ORDER BY rule_size DESC LIMIT 1";
		$this->db->setQuery($length);
		if ($this->db->execute())
		{
			$rule_length = $this->db->loadResult();
			// Check the size of the rules column
			if ($rule_length <= $accessWorseCase)
			{
				// Fix the assets table rules column size
				$fix = "ALTER TABLE `#__assets` CHANGE `rules` `rules` {$dataType} NOT NULL COMMENT 'JSON encoded access control. Enlarged to {$dataType} by Componentbuilder';";
				$this->db->setQuery($fix);

				$done = $this->db->execute();
				if ($done)
				{
					$this->app->enqueueMessage(
						Text::sprintf('The <b>#__assets</b> table rules column was resized to the %s datatype for the components possible large permission rules.', $dataType)
					);
				}
			}
		}
	}

	/**
	 * Remove remnant data related to this view
	 *
	 * @param   string   $context   The view context
	 * @param   bool     $fields    The switch to also remove related field data
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeViewData(string $context, bool $fields = false): void
	{
		$this->removeContentTypes($context);
		$this->removeViewHistory($context);
		$this->removeUcmContent($context); // this might be obsolete...
		$this->removeContentItemTagMap($context);
		$this->removeActionLogConfig($context);

		if ($fields)
		{
			$this->removeFields($context);
			$this->removeFieldsGroups($context);
		}
	}

	/**
	 * Remove content types related to this view
	 *
	 * @param   string   $context   The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeContentTypes(string $context): void
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		// Select id from content type table
		$query->select($this->db->quoteName('type_id'));
		$query->from($this->db->quoteName('#__content_types'));

		// Where Item alias is found
		$query->where($this->db->quoteName('type_alias') . ' = '. $this->db->quote($context));
		$this->db->setQuery($query);

		// Execute query to see if alias is found
		$this->db->execute();
		$found = $this->db->getNumRows();

		// Now check if there were any rows
		if ($found)
		{
			// Since there are load the needed  item type ids
			$ids = $this->db->loadColumn();

			// Remove Item from the content type table
			$condition = [
				$this->db->quoteName('type_alias') . ' = '. $this->db->quote($context)
			];

			// Create a new query object.
			$query = $this->db->getQuery(true);
			$query->delete($this->db->quoteName('#__content_types'));
			$query->where($condition);
			$this->db->setQuery($query);

			// Execute the query to remove Item items
			$done = $this->db->execute();
			if ($done)
			{
				// If successfully remove Item add queued success message.
				$this->app->enqueueMessage(
					Text::sprintf('The (%s) type alias was removed from the <b>#__content_type</b> table.', $context)
				);
			}

			// Make sure that all the items are cleared from DB
			$this->removeUcmBase($ids);
		}
	}

	/**
	 * Remove fields related to this view
	 *
	 * @param   string   $context   The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeFields(string $context): void
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		// Select ids from fields
		$query->select($this->db->quoteName('id'));
		$query->from($this->db->quoteName('#__fields'));

		// Where context is found
		$query->where(
			$this->db->quoteName('context') . ' = '. $this->db->quote($context)
		);
		$this->db->setQuery($query);

		// Execute query to see if context is found
		$this->db->execute();
		$found = $this->db->getNumRows();

		// Now check if there were any rows
		if ($found)
		{
			// Since there are load the needed  release_check field ids
			$ids = $this->db->loadColumn();

			// Create a new query object.
			$query = $this->db->getQuery(true);

			// Remove context from the field table
			$condition = [
				$this->db->quoteName('context') . ' = '. $this->db->quote($context)
			];

			$query->delete($this->db->quoteName('#__fields'));
			$query->where($condition);

			$this->db->setQuery($query);

			// Execute the query to remove release_check items
			$done = $this->db->execute();
			if ($done)
			{
				// If successfully remove context add queued success message.
				$this->app->enqueueMessage(
					Text::sprintf('The fields with context (%s) was removed from the <b>#__fields</b> table.', $context)
				);
			}

			// Make sure that all the field values are cleared from DB
			$this->removeFieldsValues($context, $ids);
		}
	}

	/**
	 * Remove fields values related to fields
	 *
	 * @param   string   $context   The view context
	 * @param   array    $ids       The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeFieldsValues(string $context, array $ids): void
	{
		$condition = [
			$this->db->quoteName('field_id') . ' IN ('. implode(',', $ids) .')'
		];

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__fields_values'));
		$query->where($condition);
		$this->db->setQuery($query);

		// Execute the query to remove field values
		$done = $this->db->execute();
		if ($done)
		{
			// If successfully remove release_check add queued success message.
			$this->app->enqueueMessage(
				Text::sprintf('The fields values for (%s) was removed from the <b>#__fields_values</b> table.', $context)
			);
		}
	}

	/**
	 * Remove fields groups related to fields
	 *
	 * @param   string   $context   The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeFieldsGroups(string $context): void
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		// Select ids from fields
		$query->select($this->db->quoteName('id'));
		$query->from($this->db->quoteName('#__fields_groups'));

		// Where context is found
		$query->where(
			$this->db->quoteName('context') . ' = '. $this->db->quote($context)
		);
		$this->db->setQuery($query);

		// Execute query to see if context is found
		$this->db->execute();
		$found = $this->db->getNumRows();

		// Now check if there were any rows
		if ($found)
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			// Remove context from the field table
			$condition = [
				$this->db->quoteName('context') . ' = '. $this->db->quote($context)
			];

			$query->delete($this->db->quoteName('#__fields_groups'));
			$query->where($condition);

			$this->db->setQuery($query);

			// Execute the query to remove release_check items
			$done = $this->db->execute();
			if ($done)
			{
				// If successfully remove context add queued success message.
				$this->app->enqueueMessage(
					Text::sprintf('The fields with context (%s) was removed from the <b>#__fields_groups</b> table.', $context)
				);
			}
		}
	}

	/**
	 * Remove history related to this view
	 *
	 * @param   string   $context   The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeViewHistory(string $context): void
	{
		// Remove Item items from the ucm content table
		$condition = [
			$this->db->quoteName('item_id') . ' LIKE ' . $this->db->quote($context . '.%')
		];

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__history'));
		$query->where($condition);
		$this->db->setQuery($query);

		// Execute the query to remove Item items
		$done = $this->db->execute();
		if ($done)
		{
			// If successfully removed Items add queued success message.
			$this->app->enqueueMessage(
				Text::sprintf('The (%s) items were removed from the <b>#__history</b> table.', $context)
			);
		}
	}

	/**
	 * Remove ucm base values related to these IDs
	 *
	 * @param   array   $ids   The type ids
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeUcmBase(array $ids): void
	{
		// Make sure that all the items are cleared from DB
		foreach ($ids as $type_id)
		{
			// Remove Item items from the ucm base table
			$condition = [
				$this->db->quoteName('ucm_type_id') . ' = ' . $type_id
			];

			// Create a new query object.
			$query = $this->db->getQuery(true);
			$query->delete($this->db->quoteName('#__ucm_base'));
			$query->where($condition);
			$this->db->setQuery($query);

			// Execute the query to remove Item items
			$this->db->execute();
		}

		$this->app->enqueueMessage(
			Text::_('All related items was removed from the <b>#__ucm_base</b> table.')
		);
	}

	/**
	 * Remove ucm content values related to this view
	 *
	 * @param   string   $context   The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeUcmContent(string $context): void
	{
		// Remove Item items from the ucm content table
		$condition = [
			$this->db->quoteName('core_type_alias') . ' = ' . $this->db->quote($context)
		];

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__ucm_content'));
		$query->where($condition);
		$this->db->setQuery($query);

		// Execute the query to remove Item items
		$done = $this->db->execute();
		if ($done)
		{
			// If successfully removed Item add queued success message.
			$this->app->enqueueMessage(
				Text::sprintf('The (%s) type alias was removed from the <b>#__ucm_content</b> table.', $context)
			);
		}
	}

	/**
	 * Remove content item tag map related to this view
	 *
	 * @param   string   $context   The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeContentItemTagMap(string $context): void
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		// Remove Item items from the contentitem tag map table
		$condition = [
			$this->db->quoteName('type_alias') . ' = '. $this->db->quote($context)
		];

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__contentitem_tag_map'));
		$query->where($condition);
		$this->db->setQuery($query);

		// Execute the query to remove Item items
		$done = $this->db->execute();
		if ($done)
		{
			// If successfully remove Item add queued success message.
			$this->app->enqueueMessage(
				Text::sprintf('The (%s) type alias was removed from the <b>#__contentitem_tag_map</b> table.', $context)
			);
		}
	}

	/**
	 * Remove action log config related to this view
	 *
	 * @param   string   $context   The view context
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeActionLogConfig(string $context): void
	{
		// Remove componentbuilder view from the action_log_config table
		$condition = [
			$this->db->quoteName('type_alias') . ' = '. $this->db->quote($context)
		];

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__action_log_config'));
		$query->where($condition);
		$this->db->setQuery($query);

		// Execute the query to remove com_componentbuilder.view
		$done = $this->db->execute();
		if ($done)
		{
			// If successfully removed componentbuilder view add queued success message.
			$this->app->enqueueMessage(
				Text::sprintf('The (%s) type alias was removed from the <b>#__action_log_config</b> table.', $context)
			);
		}
	}

	/**
	 * Remove Asset Table Integrated
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeAssetData(): void
	{
		// Remove componentbuilder assets from the assets table
		$condition = [
			$this->db->quoteName('name') . ' LIKE ' . $this->db->quote('com_componentbuilder.%')
		];

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__assets'));
		$query->where($condition);
		$this->db->setQuery($query);
		$done = $this->db->execute();
		if ($done)
		{
			// If successfully removed componentbuilder add queued success message.
			$this->app->enqueueMessage(
				Text::_('All related (com_componentbuilder) items was removed from the <b>#__assets</b> table.')
			);
		}
	}

	/**
	 * Remove action logs extensions integrated
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeActionLogsExtensions(): void
	{
		// Remove componentbuilder from the action_logs_extensions table
		$extension = [
			$this->db->quoteName('extension') . ' = ' . $this->db->quote('com_componentbuilder')
		];

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__action_logs_extensions'));
		$query->where($extension);
		$this->db->setQuery($query);

		// Execute the query to remove componentbuilder
		$done = $this->db->execute();
		if ($done)
		{
			// If successfully remove componentbuilder add queued success message.
			$this->app->enqueueMessage(
				Text::_('The (com_componentbuilder) extension was removed from the <b>#__action_logs_extensions</b> table.')
			);
		}
	}

	/**
	 * Remove remove database fix (if possible)
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function removeDatabaseAssetsRulesFix(): void
	{
		// Get the biggest rule column in the assets table at this point.
		$length = "SELECT CHAR_LENGTH(`rules`) as rule_size FROM #__assets ORDER BY rule_size DESC LIMIT 1";
		$this->db->setQuery($length);
		if ($this->db->execute())
		{
			$rule_length = $this->db->loadResult();
			// Check the size of the rules column
			if ($rule_length < 5120)
			{
				// Revert the assets table rules column back to the default
				$revert_rule = "ALTER TABLE `#__assets` CHANGE `rules` `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.';";
				$this->db->setQuery($revert_rule);
				$this->db->execute();

				$this->app->enqueueMessage(
					Text::_('Reverted the <b>#__assets</b> table rules column back to its default size of varchar(5120).')
				);
			}
			else
			{
				$this->app->enqueueMessage(
					Text::_('Could not revert the <b>#__assets</b> table rules column back to its default size of varchar(5120), since there is still one or more components that still requires the column to be larger.')
				);
			}
		}
	}

	/**
	 * Method to move folders into place.
	 *
	 * @param   InstallerAdapter  $adapter  The adapter calling this method
	 *
	 * @return void
	 * @since 4.4.2
	 */
	protected function moveFolders(InstallerAdapter $adapter): void
	{
		// get the installation path
		$installer = $adapter->getParent();
		$installPath = $installer->getPath('source');
		// get all the folders
		$folders = Folder::folders($installPath);
		// check if we have folders we may want to copy
		$doNotCopy = ['media','admin','site']; // Joomla already deals with these
		if (count((array) $folders) > 1)
		{
			foreach ($folders as $folder)
			{
				// Only copy if not a standard folders
				if (!in_array($folder, $doNotCopy))
				{
					// set the source path
					$src = $installPath.'/'.$folder;
					// set the destination path
					$dest = JPATH_ROOT.'/'.$folder;
					// now try to copy the folder
					if (!Folder::copy($src, $dest, '', true))
					{
						$this->app->enqueueMessage('Could not copy '.$folder.' folder into place, please make sure destination is writable!', 'error');
					}
				}
			}
		}
	}
}
