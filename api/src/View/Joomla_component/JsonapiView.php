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
namespace VDM\Component\Componentbuilder\Api\View\Joomla_component;

use Joomla\CMS\Factory;
use Joomla\CMS\Helper\TagsHelper;
use Joomla\CMS\MVC\View\JsonApiView as BaseApiView;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Component\Componentbuilder\Api\Serializer\Joomla_componentSerializer;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_component Json View class
 *
 * @since  4.0.0
 */
class JsonapiView extends BaseApiView
{
	/**
	 * The fields to render item in the documents
	 *
	 * @var    array
	 * @since  4.0.0
	 */
	protected $fieldsToRenderItem = [
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
	 * The relationships the item has
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
	 * @param   object  $item  Item
	 *
	 * @return  string
	 *
	 * @since   4.0.0
	 */
	public function displayItem($item = null)
	{
		if ($item === null)
		{
			$item = $this->prepareItem($this->getModel()->getItem());
		}

		return parent::displayItem($item);
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
		return parent::prepareItem($item);
	}
}
