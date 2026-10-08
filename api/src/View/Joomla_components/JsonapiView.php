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
namespace VDM\Component\Componentbuilder\Api\View\Joomla_components;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Joomla_componentSerializer;
use VDM\Joomla\FOF\Encrypt\AES;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Json View class for the Joomla_components
 *
 * @since  4.0.0
 */
class JsonapiView extends BaseApiView
{
	/**
	 * The fields to render items in the documents
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $fieldsToRenderList = [
		'id',
		'system_name',
		'name_code',
		'short_description',
		'companyname',
		'buildcompsql',
		'translation_tool',
		'jcb_powers_path',
		'sales_server',
		'add_update_server',
		'add_sql',
		'add_php_postflight_install',
		'mvc_versiondate',
		'remove_line_breaks',
		'add_placeholders',
		'debug_linenr',
		'add_php_preflight_install',
		'description',
		'add_php_method_uninstall',
		'author',
		'assets_table_fix',
		'email',
		'website',
		'add_git_folder_path',
		'license',
		'add_css_admin',
		'crowdin_username',
		'dashboard_type',
		'bom',
		'component_version',
		'add_css_site',
		'image',
		'dashboard',
		'copyright',
		'add_php_preflight_update',
		'preferred_joomla_version',
		'add_php_postflight_update',
		'add_powers',
		'add_php_method_install',
		'add_sql_uninstall',
		'readme',
		'update_server_target',
		'update_server',
		'git_folder_path',
		'changelog_server_url',
		'crowdin_project_identifier',
		'add_namespace_prefix',
		'created',
		'namespace_prefix',
		'javascript',
		'css_admin',
		'add_menu_prefix',
		'css_site',
		'menu_prefix',
		'php_preflight_install',
		'toignore',
		'php_preflight_update',
		'php_postflight_install',
		'php_postflight_update',
		'addcontributors',
		'php_method_uninstall',
		'emptycontributors',
		'php_method_install',
		'number',
		'sql',
		'sql_uninstall',
		'addreadme',
		'update_server_url',
		'creatuserhelper',
		'add_sales_server',
		'adduikit',
		'add_backup_folder_path',
		'addfootable',
		'backup_folder_path',
		'add_email_helper',
		'add_php_helper_both',
		'add_jcb_powers_path',
		'php_helper_both',
		'add_changelog_server',
		'add_php_helper_admin',
		'changelog_server_target',
		'php_helper_admin',
		'add_admin_event',
		'changelog_server',
		'php_admin_event',
		'add_php_helper_site',
		'crowdin_project_api_key',
		'php_helper_site',
		'crowdin_account_api_key',
		'add_site_event',
		'buildcomp',
		'php_site_event',
		'guid',
		'add_javascript',
		'modified',
		'name',
		'created_by',
		'modified_by',
		'published',
		'ordering',
		'access',
		'version',
		'hits',
		'metakey',
		'metadesc',
		'metadata',
	];

	/**
	 * The relationships the items have
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $relationship = [
		'sales_server',
		'dashboard',
		'update_server',
		'changelog_server',
		'created_by',
		'modified_by',
	];

	/**
	 * Constructor.
	 *
	 * @param   array  $config  A named configuration array for object construction.
	 *                          contentType: the name (optional) of the content type to use for the serialization
	 *
	 * @since   4.0.0
	 */
	public function __construct($config = [])
	{
		if (\array_key_exists('contentType', $config))
		{
			$this->serializer = new Joomla_componentSerializer($config['contentType']);
		}

		parent::__construct($config);
	}

	/**
	 * Execute and display a template script.
	 *
	 * @param   ?array  $items  Array of items
	 *
	 * @return  string
	 *
	 * @since   4.0.0
	 */
	public function displayList(?array $items = null)
	{

		return parent::displayList($items);
	}

	/**
	 * Prepare item before render.
	 *
	 * @param   object  $item  The model item
	 *
	 * @return  object
	 *
	 * @since   4.0.0
	 */
	protected function prepareItem($item)
	{
		if (isset($item->buildcompsql) && is_string($item->buildcompsql) && $item->buildcompsql !== '')
		{
			// base64 Decode buildcompsql.
			$item->buildcompsql = base64_decode($item->buildcompsql);
		}

		if (isset($item->readme) && is_string($item->readme) && $item->readme !== '')
		{
			// base64 Decode readme.
			$item->readme = base64_decode($item->readme);
		}

		if (isset($item->javascript) && is_string($item->javascript) && $item->javascript !== '')
		{
			// base64 Decode javascript.
			$item->javascript = base64_decode($item->javascript);
		}

		if (isset($item->css_admin) && is_string($item->css_admin) && $item->css_admin !== '')
		{
			// base64 Decode css_admin.
			$item->css_admin = base64_decode($item->css_admin);
		}

		if (isset($item->css_site) && is_string($item->css_site) && $item->css_site !== '')
		{
			// base64 Decode css_site.
			$item->css_site = base64_decode($item->css_site);
		}

		if (isset($item->php_preflight_install) && is_string($item->php_preflight_install) && $item->php_preflight_install !== '')
		{
			// base64 Decode php_preflight_install.
			$item->php_preflight_install = base64_decode($item->php_preflight_install);
		}

		if (isset($item->php_preflight_update) && is_string($item->php_preflight_update) && $item->php_preflight_update !== '')
		{
			// base64 Decode php_preflight_update.
			$item->php_preflight_update = base64_decode($item->php_preflight_update);
		}

		if (isset($item->php_postflight_install) && is_string($item->php_postflight_install) && $item->php_postflight_install !== '')
		{
			// base64 Decode php_postflight_install.
			$item->php_postflight_install = base64_decode($item->php_postflight_install);
		}

		if (isset($item->php_postflight_update) && is_string($item->php_postflight_update) && $item->php_postflight_update !== '')
		{
			// base64 Decode php_postflight_update.
			$item->php_postflight_update = base64_decode($item->php_postflight_update);
		}

		if (isset($item->php_method_uninstall) && is_string($item->php_method_uninstall) && $item->php_method_uninstall !== '')
		{
			// base64 Decode php_method_uninstall.
			$item->php_method_uninstall = base64_decode($item->php_method_uninstall);
		}

		if (isset($item->php_method_install) && is_string($item->php_method_install) && $item->php_method_install !== '')
		{
			// base64 Decode php_method_install.
			$item->php_method_install = base64_decode($item->php_method_install);
		}

		if (isset($item->sql) && is_string($item->sql) && $item->sql !== '')
		{
			// base64 Decode sql.
			$item->sql = base64_decode($item->sql);
		}

		if (isset($item->sql_uninstall) && is_string($item->sql_uninstall) && $item->sql_uninstall !== '')
		{
			// base64 Decode sql_uninstall.
			$item->sql_uninstall = base64_decode($item->sql_uninstall);
		}

		if (isset($item->php_helper_both) && is_string($item->php_helper_both) && $item->php_helper_both !== '')
		{
			// base64 Decode php_helper_both.
			$item->php_helper_both = base64_decode($item->php_helper_both);
		}

		if (isset($item->php_helper_admin) && is_string($item->php_helper_admin) && $item->php_helper_admin !== '')
		{
			// base64 Decode php_helper_admin.
			$item->php_helper_admin = base64_decode($item->php_helper_admin);
		}

		if (isset($item->php_admin_event) && is_string($item->php_admin_event) && $item->php_admin_event !== '')
		{
			// base64 Decode php_admin_event.
			$item->php_admin_event = base64_decode($item->php_admin_event);
		}

		if (isset($item->php_helper_site) && is_string($item->php_helper_site) && $item->php_helper_site !== '')
		{
			// base64 Decode php_helper_site.
			$item->php_helper_site = base64_decode($item->php_helper_site);
		}

		if (isset($item->php_site_event) && is_string($item->php_site_event) && $item->php_site_event !== '')
		{
			// base64 Decode php_site_event.
			$item->php_site_event = base64_decode($item->php_site_event);
		}

		// Get the basic encryption.
		$basickey = ComponentbuilderHelper::getCryptKey('basic');
		// Get the encryption object.
		$basic = new AES($basickey);

		if (!empty($item->crowdin_username) && $basickey && is_string($item->crowdin_username) && !is_numeric($item->crowdin_username) && $item->crowdin_username === base64_encode(base64_decode($item->crowdin_username, true)))
		{
			// basic decrypt data crowdin_username.
			$item->crowdin_username = rtrim($basic->decryptString($item->crowdin_username), "\0");
		}

		if (!empty($item->crowdin_project_api_key) && $basickey && is_string($item->crowdin_project_api_key) && !is_numeric($item->crowdin_project_api_key) && $item->crowdin_project_api_key === base64_encode(base64_decode($item->crowdin_project_api_key, true)))
		{
			// basic decrypt data crowdin_project_api_key.
			$item->crowdin_project_api_key = rtrim($basic->decryptString($item->crowdin_project_api_key), "\0");
		}

		if (!empty($item->crowdin_account_api_key) && $basickey && is_string($item->crowdin_account_api_key) && !is_numeric($item->crowdin_account_api_key) && $item->crowdin_account_api_key === base64_encode(base64_decode($item->crowdin_account_api_key, true)))
		{
			// basic decrypt data crowdin_account_api_key.
			$item->crowdin_account_api_key = rtrim($basic->decryptString($item->crowdin_account_api_key), "\0");
		}

		if (isset($item->addcontributors) && is_string($item->addcontributors) && $item->addcontributors !== '')
		{
			// Convert the addcontributors field to an array.
			$registry = new Registry;
			$registry->loadString($item->addcontributors);
			$item->addcontributors = $registry->toArray();
		}

		return parent::prepareItem($item);
	}
}
