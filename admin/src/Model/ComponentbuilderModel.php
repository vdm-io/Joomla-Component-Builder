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
namespace VDM\Component\Componentbuilder\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\User\User;
use Joomla\Utilities\ArrayHelper;
use Joomla\Input\Input;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder List Model
 *
 * @since  1.6
 */
class ComponentbuilderModel extends ListModel
{
	/**
	 * The styles array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $styles = [
		'administrator/components/com_componentbuilder/assets/css/admin.css',
		'administrator/components/com_componentbuilder/assets/css/dashboard.css'
 	];

	/**
	 * The scripts array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $scripts = [
		'administrator/components/com_componentbuilder/assets/js/admin.js'
 	];

	public function getIcons()
	{
		// load user for access menus
		$user = Factory::getApplication()->getIdentity();
		// reset icon array
		$icons  = [];
		// view groups array
		$viewGroups = array(
			'main' => array('png.compiler', 'png.joomla_components', 'png.joomla_modules', 'png.joomla_plugins', 'png.powers', 'png.search', 'png.admin_views', 'png.custom_admin_views', 'png.site_views', 'png.template.add', 'png.templates', 'png.layouts', 'png.dynamic_get.add', 'png.dynamic_gets', 'png.custom_codes', 'png.placeholders', 'png.libraries', 'png.snippets', 'png.validation_rules', 'png.field.add', 'png.fields', 'png.fields.catid_qpo0O0oqp_com_componentbuilder_po0O0oq_field', 'png.fieldtypes', 'png.fieldtypes.catid_qpo0O0oqp_com_componentbuilder_po0O0oq_fieldtype', 'png.language_translations', 'png.languages', 'png.servers', 'png.help_documents')
		);
		// view access array
		$viewAccess = [
			'compiler.submenu' => 'compiler.submenu',
			'compiler.dashboard_list' => 'compiler.dashboard_list',
			'search.access' => 'search.access',
			'search.submenu' => 'search.submenu',
			'search.dashboard_list' => 'search.dashboard_list',
			'joomla_component.create' => 'joomla_component.create',
			'joomla_components.access' => 'joomla_component.access',
			'joomla_component.access' => 'joomla_component.access',
			'joomla_components.submenu' => 'joomla_component.submenu',
			'joomla_components.dashboard_list' => 'joomla_component.dashboard_list',
			'joomla_module.create' => 'joomla_module.create',
			'joomla_modules.access' => 'joomla_module.access',
			'joomla_module.access' => 'joomla_module.access',
			'joomla_modules.submenu' => 'joomla_module.submenu',
			'joomla_modules.dashboard_list' => 'joomla_module.dashboard_list',
			'joomla_plugin.create' => 'joomla_plugin.create',
			'joomla_plugins.access' => 'joomla_plugin.access',
			'joomla_plugin.access' => 'joomla_plugin.access',
			'joomla_plugins.submenu' => 'joomla_plugin.submenu',
			'joomla_plugins.dashboard_list' => 'joomla_plugin.dashboard_list',
			'joomla_power.create' => 'joomla_power.create',
			'joomla_powers.access' => 'joomla_power.access',
			'joomla_power.access' => 'joomla_power.access',
			'joomla_powers.submenu' => 'joomla_power.submenu',
			'power.create' => 'power.create',
			'powers.access' => 'power.access',
			'power.access' => 'power.access',
			'powers.submenu' => 'power.submenu',
			'powers.dashboard_list' => 'power.dashboard_list',
			'admin_view.create' => 'admin_view.create',
			'admin_views.access' => 'admin_view.access',
			'admin_view.access' => 'admin_view.access',
			'admin_views.submenu' => 'admin_view.submenu',
			'admin_views.dashboard_list' => 'admin_view.dashboard_list',
			'custom_admin_views.access' => 'custom_admin_view.access',
			'custom_admin_view.access' => 'custom_admin_view.access',
			'custom_admin_views.submenu' => 'custom_admin_view.submenu',
			'custom_admin_views.dashboard_list' => 'custom_admin_view.dashboard_list',
			'site_views.access' => 'site_view.access',
			'site_view.access' => 'site_view.access',
			'site_views.submenu' => 'site_view.submenu',
			'site_views.dashboard_list' => 'site_view.dashboard_list',
			'templates.access' => 'template.access',
			'template.access' => 'template.access',
			'templates.submenu' => 'template.submenu',
			'templates.dashboard_list' => 'template.dashboard_list',
			'template.dashboard_add' => 'template.dashboard_add',
			'layouts.access' => 'layout.access',
			'layout.access' => 'layout.access',
			'layouts.submenu' => 'layout.submenu',
			'layouts.dashboard_list' => 'layout.dashboard_list',
			'dynamic_get.create' => 'dynamic_get.create',
			'dynamic_gets.access' => 'dynamic_get.access',
			'dynamic_get.access' => 'dynamic_get.access',
			'dynamic_gets.submenu' => 'dynamic_get.submenu',
			'dynamic_gets.dashboard_list' => 'dynamic_get.dashboard_list',
			'dynamic_get.dashboard_add' => 'dynamic_get.dashboard_add',
			'custom_code.create' => 'custom_code.create',
			'custom_codes.access' => 'custom_code.access',
			'custom_code.access' => 'custom_code.access',
			'custom_codes.submenu' => 'custom_code.submenu',
			'custom_codes.dashboard_list' => 'custom_code.dashboard_list',
			'class_property.create' => 'class_property.create',
			'class_properties.access' => 'class_property.access',
			'class_property.access' => 'class_property.access',
			'class_method.create' => 'class_method.create',
			'class_methods.access' => 'class_method.access',
			'class_method.access' => 'class_method.access',
			'placeholder.create' => 'placeholder.create',
			'placeholders.access' => 'placeholder.access',
			'placeholder.access' => 'placeholder.access',
			'placeholders.submenu' => 'placeholder.submenu',
			'placeholders.dashboard_list' => 'placeholder.dashboard_list',
			'library.create' => 'library.create',
			'libraries.access' => 'library.access',
			'library.access' => 'library.access',
			'libraries.submenu' => 'library.submenu',
			'libraries.dashboard_list' => 'library.dashboard_list',
			'snippets.access' => 'snippet.access',
			'snippet.access' => 'snippet.access',
			'snippets.submenu' => 'snippet.submenu',
			'snippets.dashboard_list' => 'snippet.dashboard_list',
			'validation_rule.create' => 'validation_rule.create',
			'validation_rules.access' => 'validation_rule.access',
			'validation_rule.access' => 'validation_rule.access',
			'validation_rules.submenu' => 'validation_rule.submenu',
			'validation_rules.dashboard_list' => 'validation_rule.dashboard_list',
			'field.create' => 'field.create',
			'fields.access' => 'field.access',
			'field.access' => 'field.access',
			'fields.submenu' => 'field.submenu',
			'fields.dashboard_list' => 'field.dashboard_list',
			'field.dashboard_add' => 'field.dashboard_add',
			'fieldtype.create' => 'fieldtype.create',
			'fieldtypes.access' => 'fieldtype.access',
			'fieldtype.access' => 'fieldtype.access',
			'fieldtypes.submenu' => 'fieldtype.submenu',
			'fieldtypes.dashboard_list' => 'fieldtype.dashboard_list',
			'language_translation.create' => 'language_translation.create',
			'language_translations.access' => 'language_translation.access',
			'language_translation.access' => 'language_translation.access',
			'language_translations.submenu' => 'language_translation.submenu',
			'language_translations.dashboard_list' => 'language_translation.dashboard_list',
			'language.create' => 'language.create',
			'languages.access' => 'language.access',
			'language.access' => 'language.access',
			'languages.submenu' => 'language.submenu',
			'languages.dashboard_list' => 'language.dashboard_list',
			'server.create' => 'server.create',
			'servers.access' => 'server.access',
			'server.access' => 'server.access',
			'servers.submenu' => 'server.submenu',
			'servers.dashboard_list' => 'server.dashboard_list',
			'help_document.create' => 'help_document.create',
			'help_documents.access' => 'help_document.access',
			'help_document.access' => 'help_document.access',
			'help_documents.submenu' => 'help_document.submenu',
			'help_documents.dashboard_list' => 'help_document.dashboard_list',
			'admin_fields.create' => 'admin_fields.create',
			'admins_fields.access' => 'admin_fields.access',
			'admin_fields.access' => 'admin_fields.access',
			'admin_fields_conditions.create' => 'admin_fields_conditions.create',
			'admins_fields_conditions.access' => 'admin_fields_conditions.access',
			'admin_fields_conditions.access' => 'admin_fields_conditions.access',
			'admin_fields_relations.create' => 'admin_fields_relations.create',
			'admins_fields_relations.access' => 'admin_fields_relations.access',
			'admin_fields_relations.access' => 'admin_fields_relations.access',
			'admin_custom_tabs.create' => 'admin_custom_tabs.create',
			'admins_custom_tabs.access' => 'admin_custom_tabs.access',
			'admin_custom_tabs.access' => 'admin_custom_tabs.access',
			'component_admin_views.create' => 'component_admin_views.create',
			'components_admin_views.access' => 'component_admin_views.access',
			'component_admin_views.access' => 'component_admin_views.access',
			'component_site_views.create' => 'component_site_views.create',
			'components_site_views.access' => 'component_site_views.access',
			'component_site_views.access' => 'component_site_views.access',
			'component_custom_admin_views.create' => 'component_custom_admin_views.create',
			'components_custom_admin_views.access' => 'component_custom_admin_views.access',
			'component_custom_admin_views.access' => 'component_custom_admin_views.access',
			'component_updates.create' => 'component_updates.create',
			'components_updates.access' => 'component_updates.access',
			'component_updates.access' => 'component_updates.access',
			'component_mysql_tweaks.create' => 'component_mysql_tweaks.create',
			'components_mysql_tweaks.access' => 'component_mysql_tweaks.access',
			'component_mysql_tweaks.access' => 'component_mysql_tweaks.access',
			'component_custom_admin_menus.create' => 'component_custom_admin_menus.create',
			'components_custom_admin_menus.access' => 'component_custom_admin_menus.access',
			'component_custom_admin_menus.access' => 'component_custom_admin_menus.access',
			'component_router.create' => 'component_router.create',
			'components_routers.access' => 'component_router.access',
			'component_router.access' => 'component_router.access',
			'component_config.create' => 'component_config.create',
			'components_config.access' => 'component_config.access',
			'component_config.access' => 'component_config.access',
			'component_dashboard.create' => 'component_dashboard.create',
			'components_dashboard.access' => 'component_dashboard.access',
			'component_dashboard.access' => 'component_dashboard.access',
			'component_files_folders.create' => 'component_files_folders.create',
			'components_files_folders.access' => 'component_files_folders.access',
			'component_files_folders.access' => 'component_files_folders.access',
			'component_placeholders.create' => 'component_placeholders.create',
			'components_placeholders.access' => 'component_placeholders.access',
			'component_placeholders.access' => 'component_placeholders.access',
			'component_plugins.create' => 'component_plugins.create',
			'components_plugins.access' => 'component_plugins.access',
			'component_plugins.access' => 'component_plugins.access',
			'component_modules.create' => 'component_modules.create',
			'components_modules.access' => 'component_modules.access',
			'component_modules.access' => 'component_modules.access',
			'snippet_type.create' => 'snippet_type.create',
			'snippet_types.access' => 'snippet_type.access',
			'snippet_type.access' => 'snippet_type.access',
			'library_config.create' => 'library_config.create',
			'libraries_config.access' => 'library_config.access',
			'library_config.access' => 'library_config.access',
			'library_files_folders_urls.create' => 'library_files_folders_urls.create',
			'libraries_files_folders_urls.access' => 'library_files_folders_urls.access',
			'library_files_folders_urls.access' => 'library_files_folders_urls.access',
			'class_extends.create' => 'class_extends.create',
			'class_extendings.access' => 'class_extends.access',
			'class_extends.access' => 'class_extends.access',
			'joomla_module_updates.create' => 'joomla_module_updates.create',
			'joomla_modules_updates.access' => 'joomla_module_updates.access',
			'joomla_module_updates.access' => 'joomla_module_updates.access',
			'joomla_module_files_folders_urls.create' => 'joomla_module_files_folders_urls.create',
			'joomla_modules_files_folders_urls.access' => 'joomla_module_files_folders_urls.access',
			'joomla_module_files_folders_urls.access' => 'joomla_module_files_folders_urls.access',
			'joomla_plugin_groups.access' => 'joomla_plugin_group.access',
			'joomla_plugin_group.access' => 'joomla_plugin_group.access',
			'joomla_plugin_updates.create' => 'joomla_plugin_updates.create',
			'joomla_plugins_updates.access' => 'joomla_plugin_updates.access',
			'joomla_plugin_updates.access' => 'joomla_plugin_updates.access',
			'joomla_plugin_files_folders_urls.create' => 'joomla_plugin_files_folders_urls.create',
			'joomla_plugins_files_folders_urls.access' => 'joomla_plugin_files_folders_urls.access',
			'joomla_plugin_files_folders_urls.access' => 'joomla_plugin_files_folders_urls.access',
		];
		// loop over the $views
		foreach($viewGroups as $group => $views)
		{
			$i = 0;
			if (UtilitiesArrayHelper::check($views))
			{
				foreach($views as $view)
				{
					$add = false;
					// external views (links)
					if (strpos($view,'||') !== false)
					{
						$dwd = explode('||', $view);
						if (count($dwd) == 3)
						{
							list($type, $name, $url) = $dwd;
							$viewName = $name;
							$alt      = $name;
							$url      = $url;
							$image    = $name . '.' . $type;
							$name     = 'COM_COMPONENTBUILDER_DASHBOARD_' . StringHelper::safe($name,'U');
						}
					}
					// internal views
					elseif (strpos($view,'.') !== false)
					{
						$dwd = explode('.', $view);
						if (count($dwd) == 3)
						{
							list($type, $name, $action) = $dwd;
						}
						elseif (count($dwd) == 2)
						{
							list($type, $name) = $dwd;
							$action = false;
						}
						if ($action)
						{
							$viewName = $name;
							switch($action)
							{
								case 'add':
									$url   = 'index.php?option=com_componentbuilder&view=' . $name . '&layout=edit';
									$image = $name . '_' . $action.  '.' . $type;
									$alt   = $name . '&nbsp;' . $action;
									$name  = 'COM_COMPONENTBUILDER_DASHBOARD_'.StringHelper::safe($name,'U').'_ADD';
									$add   = true;
								break;
								default:
									// check for new convention (more stable)
									if (strpos($action, '_qpo0O0oqp_') !== false)
									{
										list($action, $extension) = (array) explode('_qpo0O0oqp_', $action);
										$extension = str_replace('_po0O0oq_', '.', $extension);
									}
									else
									{
										$extension = 'com_componentbuilder.' . $name;
									}
									$url   = 'index.php?option=com_categories&view=categories&extension=' . $extension;
									$image = $name . '_' . $action . '.' . $type;
									$alt   = $viewName . '&nbsp;' . $action;
									$name  = 'COM_COMPONENTBUILDER_DASHBOARD_' . StringHelper::safe($name,'U') . '_' . StringHelper::safe($action,'U');
								break;
							}
						}
						else
						{
							$viewName = $name;
							$alt      = $name;
							$url      = 'index.php?option=com_componentbuilder&view=' . $name;
							$image    = $name . '.' . $type;
							$name     = 'COM_COMPONENTBUILDER_DASHBOARD_' . StringHelper::safe($name,'U');
							$hover    = false;
						}
					}
					else
					{
						$viewName = $view;
						$alt      = $view;
						$url      = 'index.php?option=com_componentbuilder&view=' . $view;
						$image    = $view . '.png';
						$name     = ucwords($view).'<br /><br />';
						$hover    = false;
					}
					// first make sure the view access is set
					if (UtilitiesArrayHelper::check($viewAccess))
					{
						// setup some defaults
						$dashboard_add = false;
						$dashboard_list = false;
						$accessTo = '';
						$accessAdd = '';
						// access checking start
						$accessCreate = (isset($viewAccess[$viewName.'.create'])) ? StringHelper::check($viewAccess[$viewName.'.create']):false;
						$accessAccess = (isset($viewAccess[$viewName.'.access'])) ? StringHelper::check($viewAccess[$viewName.'.access']):false;
						// set main controllers
						$accessDashboard_add = (isset($viewAccess[$viewName.'.dashboard_add'])) ? StringHelper::check($viewAccess[$viewName.'.dashboard_add']):false;
						$accessDashboard_list = (isset($viewAccess[$viewName.'.dashboard_list'])) ? StringHelper::check($viewAccess[$viewName.'.dashboard_list']):false;
						// check for adding access
						if ($add && $accessCreate)
						{
							$accessAdd = $viewAccess[$viewName.'.create'];
						}
						elseif ($add)
						{
							$accessAdd = 'core.create';
						}
						// check if access to view is set
						if ($accessAccess)
						{
							$accessTo = $viewAccess[$viewName.'.access'];
						}
						// set main access controllers
						if ($accessDashboard_add)
						{
							$dashboard_add    = $user->authorise($viewAccess[$viewName.'.dashboard_add'], 'com_componentbuilder');
						}
						if ($accessDashboard_list)
						{
							$dashboard_list = $user->authorise($viewAccess[$viewName.'.dashboard_list'], 'com_componentbuilder');
						}
						if (StringHelper::check($accessAdd) && StringHelper::check($accessTo))
						{
							// check access
							if($user->authorise($accessAdd, 'com_componentbuilder') && $user->authorise($accessTo, 'com_componentbuilder') && $dashboard_add)
							{
								$icons[$group][$i]        = new \StdClass;
								$icons[$group][$i]->url   = $url;
								$icons[$group][$i]->name  = $name;
								$icons[$group][$i]->image = $image;
								$icons[$group][$i]->alt   = $alt;
							}
						}
						elseif (StringHelper::check($accessTo))
						{
							// check access
							if($user->authorise($accessTo, 'com_componentbuilder') && $dashboard_list)
							{
								$icons[$group][$i]        = new \StdClass;
								$icons[$group][$i]->url   = $url;
								$icons[$group][$i]->name  = $name;
								$icons[$group][$i]->image = $image;
								$icons[$group][$i]->alt   = $alt;
							}
						}
						elseif (StringHelper::check($accessAdd))
						{
							// check access
							if($user->authorise($accessAdd, 'com_componentbuilder') && $dashboard_add)
							{
								$icons[$group][$i]        = new \StdClass;
								$icons[$group][$i]->url   = $url;
								$icons[$group][$i]->name  = $name;
								$icons[$group][$i]->image = $image;
								$icons[$group][$i]->alt   = $alt;
							}
						}
						else
						{
							$icons[$group][$i]        = new \StdClass;
							$icons[$group][$i]->url   = $url;
							$icons[$group][$i]->name  = $name;
							$icons[$group][$i]->image = $image;
							$icons[$group][$i]->alt   = $alt;
						}
					}
					else
					{
						$icons[$group][$i]        = new \StdClass;
						$icons[$group][$i]->url   = $url;
						$icons[$group][$i]->name  = $name;
						$icons[$group][$i]->image = $image;
						$icons[$group][$i]->alt   = $alt;
					}
					$i++;
				}
			}
			else
			{
					$icons[$group][$i] = false;
			}
		}
		return $icons;
	}

	/**
	 * Method to get the styles that have to be included on the view
	 *
	 * @return  array    styles files
	 * @since   4.3
	 */
	public function getStyles(): array
	{
		return $this->styles;
	}

	/**
	 * Method to set the styles that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setStyles(string $path): void
	{
		$this->styles[] = $path;
	}

	/**
	 * Method to get the script that have to be included on the view
	 *
	 * @return  array    script files
	 * @since   4.3
	 */
	public function getScripts(): array
	{
		return $this->scripts;
	}

	/**
	 * Method to set the script that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setScript(string $path): void
	{
		$this->scripts[] = $path;
	}


	public function getWiki()
	{
		// the call URL
		$call_url = Uri::base() . 'index.php?option=com_componentbuilder&task=ajax.getWiki&format=json&raw=true&' . Session::getFormToken() . '=1&name=Home';
		$document = Factory::getDocument();
		$document->addScriptDeclaration('
		function getWikiPage(){
			fetch("' . $call_url . '").then((response) => {
				if (response.ok) {
					return response.json();
				}
			}).then((result) => {
				if (typeof result.page !== "undefined") {
					document.getElementById("wiki-md").innerHTML = marked.parse(result.page);
				} else if (typeof result.error !== "undefined") {
					document.getElementById("wiki-md-error").innerHTML = result.error
				}
			});
		}
		setTimeout(getWikiPage, 1000);');

		return '<div id="wiki-md"><small>'.Text::_('COM_COMPONENTBUILDER_THE_WIKI_IS_LOADING').'.<span class="loading-dots">.</span></small></div><div id="wiki-md-error" style="color: red"></div>';
	}
	

	public function getNoticeboard()
	{
		// get the document to load the scripts
		$document = Factory::getDocument();
		Html::_('script', "media/com_componentbuilder/js/marked.js", ['version' => 'auto']);
		$document->addScriptDeclaration('
		var token = "' . Session::getFormToken() . '";
		var noticeboard = "https://vdm.bz/componentbuilder-noticeboard-md";
		document.addEventListener("DOMContentLoaded", function() {
			fetch(noticeboard)
			.then(response => {
				if (!response.ok) {
					throw new Error("Network response was not ok");
				}
				return response.text();
			})
			.then(board => {
				if (board.length > 5) {
					document.getElementById("noticeboard-md").innerHTML = marked.parse(board);
					getIS(1, board)
					.then(result => {
						if (result) {
							document.querySelectorAll("#cpanel_tabTabs a").forEach(link => {
								if (link.href.includes("#vast_development_method") || link.href.includes("#notice_board")) {
									var textVDM = link.textContent;
									link.innerHTML = "<span class=\"label label-important vdm-new-notice\">1</span> " + textVDM;
									link.id = "vdm-new-notice";
									document.getElementById("vdm-new-notice").addEventListener("click", () => {
										getIS(2, board)
										.then(result => {
											if (result) {
												document.querySelectorAll(".vdm-new-notice").forEach(element => {
													element.style.opacity = 0;
												});
											}
										});
									});
								}
							});
						}
					});
				} else {
					document.getElementById("noticeboard-md").innerHTML = "'.Text::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_PLEASE_CHECK_AGAIN_LATER').'.";
				}
			})
			.catch(error => {
				console.error("There was an error!", error);
				document.getElementById("noticeboard-md").innerHTML = "'.Text::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_PLEASE_CHECK_AGAIN_LATER').'.";
			});
		});

		// to check is READ/NEW
		function getIS(type, notice) {
			let getUrl = "";
			if (type === 1) {
				getUrl = "index.php?option=com_componentbuilder&task=ajax.isNew&format=json&raw=true";
			} else if (type === 2) {
				getUrl = "index.php?option=com_componentbuilder&task=ajax.isRead&format=json&raw=true";
			}
			let request = new URLSearchParams();
			if (token.length > 0 && notice.length) {
				request.append(token, "1");
				request.append("notice", notice);
			}
			return fetch(getUrl, {
				method: "POST",
				headers: {
					"Content-Type": "application/x-www-form-urlencoded;charset=UTF-8"
				},
				body: request
			}).then(response => response.json());
		}
		
document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll(".loading-dots").forEach(function(loading_dots) {
		let x = 0;
		let intervalId = setInterval(function() {
			if (!loading_dots.classList.contains("loading-dots")) {
				clearInterval(intervalId);
				return;
			}
			let dots = ".".repeat(x % 8);
			loading_dots.textContent = dots;
			x++;
		}, 500);
	});
});');

		return '<div id="noticeboard-md">'.Text::_('COM_COMPONENTBUILDER_THE_NOTICE_BOARD_IS_LOADING').'.<span class="loading-dots">.</span></small></div>';
	}

	public function getReadme()
	{
		$document = Factory::getDocument();
		$document->addScriptDeclaration('
		var getreadme = "'. Uri::root() . 'administrator/components/com_componentbuilder/README.txt";
		document.addEventListener("DOMContentLoaded", function () {
			fetch(getreadme)
			.then(response => {
				if (!response.ok) {
				    throw new Error("Network response was not ok");
				}
				return response.text();
			})
			.then(readme => {
				document.getElementById("readme-md").innerHTML = marked.parse(readme);
			})
			.catch(error => {
				console.error("There has been a problem with your fetch operation:", error);
				document.getElementById("readme-md").innerHTML = "'.Text::_('COM_COMPONENTBUILDER_PLEASE_CHECK_AGAIN_LATER').'.";
			});
		});');

		return '<div id="readme-md"><small>'.Text::_('COM_COMPONENTBUILDER_THE_README_IS_LOADING').'.<span class="loading-dots">.</span></small></div>';
	}

	/**
	 * get Current Version Bay adding JavaScript to the Page
	 *
	 * @return  void
	 * @since   2.3.0
	 */
	public function getVersion()
	{
		// the call URL
		$call_url = Uri::base() . 'index.php?option=com_componentbuilder&task=ajax.getVersion&format=json&raw=true&' . Session::getFormToken() . '=1&version=1';
		$document = Factory::getDocument();
		$document->addScriptDeclaration('
		function getComponentVersionStatus() {
			fetch("' . $call_url . '").then((response) => {
				if (response.ok) {
					return response.json();
				}
			}).then((result) => {
				if (typeof result.notice !== "undefined") {
					document.getElementById("component-update-notice").innerHTML = result.notice;
				} else if (typeof result.error !== "undefined") {
					document.getElementById("component-update-notice").innerHTML = result.error;
				}
			});
		}
		setTimeout(getComponentVersionStatus, 800);');
	}

}
