<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Componentbuilder Model
 */
class ComponentbuilderModelComponentbuilder extends JModelList
{
	public function getIcons()
	{
		// load user for access menus
		$user = JFactory::getUser();
		// reset icon array
		$icons  = array();
		// view groups array
		$viewGroups = array(
			'main' => array('png.assistant', 'png.compiler', 'png.joomla_components', 'png.joomla_modules', 'png.joomla_plugins', 'png||importjcbpackages||index.php?option=com_componentbuilder&view=joomla_components&task=joomla_components.smartImport', 'png.admin_view.add', 'png.admin_views', 'png.custom_admin_view.add', 'png.custom_admin_views', 'png.site_view.add', 'png.site_views', 'png.template.add', 'png.templates', 'png.layouts', 'png.dynamic_get.add', 'png.dynamic_gets', 'png.custom_codes', 'png.placeholders', 'png.libraries', 'png.snippets', 'png.get_snippets', 'png.validation_rules', 'png.field.add', 'png.fields', 'png.fields.catid', 'png.fieldtypes', 'png.fieldtypes.catid', 'png.language_translations', 'png.servers', 'png.help_documents')
		);
		// view access array
		$viewAccess = array(
			'assistant.submenu' => 'assistant.submenu',
			'assistant.dashboard_list' => 'assistant.dashboard_list',
			'compiler.submenu' => 'compiler.submenu',
			'compiler.dashboard_list' => 'compiler.dashboard_list',
			'get_snippets.submenu' => 'get_snippets.submenu',
			'get_snippets.dashboard_list' => 'get_snippets.dashboard_list',
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
			'admin_view.create' => 'admin_view.create',
			'admin_views.access' => 'admin_view.access',
			'admin_view.access' => 'admin_view.access',
			'admin_views.submenu' => 'admin_view.submenu',
			'admin_views.dashboard_list' => 'admin_view.dashboard_list',
			'admin_view.dashboard_add' => 'admin_view.dashboard_add',
			'custom_admin_views.access' => 'custom_admin_view.access',
			'custom_admin_view.access' => 'custom_admin_view.access',
			'custom_admin_views.submenu' => 'custom_admin_view.submenu',
			'custom_admin_views.dashboard_list' => 'custom_admin_view.dashboard_list',
			'custom_admin_view.dashboard_add' => 'custom_admin_view.dashboard_add',
			'site_views.access' => 'site_view.access',
			'site_view.access' => 'site_view.access',
			'site_views.submenu' => 'site_view.submenu',
			'site_views.dashboard_list' => 'site_view.dashboard_list',
			'site_view.dashboard_add' => 'site_view.dashboard_add',
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
			'joomla_plugin_files_folders_urls.access' => 'joomla_plugin_files_folders_urls.access');
		// loop over the $views
		foreach($viewGroups as $group => $views)
		{
			$i = 0;
			if (ComponentbuilderHelper::checkArray($views))
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
							$viewName 	= $name;
							$alt 		= $name;
							$url 		= $url;
							$image 		= $name.'.'.$type;
							$name 		= 'COM_COMPONENTBUILDER_DASHBOARD_'.ComponentbuilderHelper::safeString($name,'U');
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
									$url 	= 'index.php?option=com_componentbuilder&view='.$name.'&layout=edit';
									$image 	= $name.'_'.$action.'.'.$type;
									$alt 	= $name.'&nbsp;'.$action;
									$name	= 'COM_COMPONENTBUILDER_DASHBOARD_'.ComponentbuilderHelper::safeString($name,'U').'_ADD';
									$add	= true;
								break;
								default:
									$url 	= 'index.php?option=com_categories&view=categories&extension=com_componentbuilder.'.$name;
									$image 	= $name.'_'.$action.'.'.$type;
									$alt 	= $name.'&nbsp;'.$action;
									$name	= 'COM_COMPONENTBUILDER_DASHBOARD_'.ComponentbuilderHelper::safeString($name,'U').'_'.ComponentbuilderHelper::safeString($action,'U');
								break;
							}
						}
						else
						{
							$viewName 	= $name;
							$alt 		= $name;
							$url 		= 'index.php?option=com_componentbuilder&view='.$name;
							$image 		= $name.'.'.$type;
							$name 		= 'COM_COMPONENTBUILDER_DASHBOARD_'.ComponentbuilderHelper::safeString($name,'U');
							$hover		= false;
						}
					}
					else
					{
						$viewName 	= $view;
						$alt 		= $view;
						$url 		= 'index.php?option=com_componentbuilder&view='.$view;
						$image 		= $view.'.png';
						$name 		= ucwords($view).'<br /><br />';
						$hover		= false;
					}
					// first make sure the view access is set
					if (ComponentbuilderHelper::checkArray($viewAccess))
					{
						// setup some defaults
						$dashboard_add = false;
						$dashboard_list = false;
						$accessTo = '';
						$accessAdd = '';
						// acces checking start
						$accessCreate = (isset($viewAccess[$viewName.'.create'])) ? ComponentbuilderHelper::checkString($viewAccess[$viewName.'.create']):false;
						$accessAccess = (isset($viewAccess[$viewName.'.access'])) ? ComponentbuilderHelper::checkString($viewAccess[$viewName.'.access']):false;
						// set main controllers
						$accessDashboard_add = (isset($viewAccess[$viewName.'.dashboard_add'])) ? ComponentbuilderHelper::checkString($viewAccess[$viewName.'.dashboard_add']):false;
						$accessDashboard_list = (isset($viewAccess[$viewName.'.dashboard_list'])) ? ComponentbuilderHelper::checkString($viewAccess[$viewName.'.dashboard_list']):false;
						// check for adding access
						if ($add && $accessCreate)
						{
							$accessAdd = $viewAccess[$viewName.'.create'];
						}
						elseif ($add)
						{
							$accessAdd = 'core.create';
						}
						// check if acces to view is set
						if ($accessAccess)
						{
							$accessTo = $viewAccess[$viewName.'.access'];
						}
						// set main access controllers
						if ($accessDashboard_add)
						{
							$dashboard_add	= $user->authorise($viewAccess[$viewName.'.dashboard_add'], 'com_componentbuilder');
						}
						if ($accessDashboard_list)
						{
							$dashboard_list = $user->authorise($viewAccess[$viewName.'.dashboard_list'], 'com_componentbuilder');
						}
						if (ComponentbuilderHelper::checkString($accessAdd) && ComponentbuilderHelper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessAdd, 'com_componentbuilder') && $user->authorise($accessTo, 'com_componentbuilder') && $dashboard_add)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (ComponentbuilderHelper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessTo, 'com_componentbuilder') && $dashboard_list)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (ComponentbuilderHelper::checkString($accessAdd))
						{
							// check access
							if($user->authorise($accessAdd, 'com_componentbuilder') && $dashboard_add)
							{
								$icons[$group][$i]			= new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						else
						{
							$icons[$group][$i]			= new StdClass;
							$icons[$group][$i]->url 	= $url;
							$icons[$group][$i]->name 	= $name;
							$icons[$group][$i]->image 	= $image;
							$icons[$group][$i]->alt 	= $alt;
						}
					}
					else
					{
						$icons[$group][$i]			= new StdClass;
						$icons[$group][$i]->url 	= $url;
						$icons[$group][$i]->name 	= $name;
						$icons[$group][$i]->image 	= $image;
						$icons[$group][$i]->alt 	= $alt;
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


	public function getGithub()
	{
		// load jquery (not sure why... but else the timeago breaks)
		JHtml::_('jquery.framework');
		// get the document to load the scripts
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . "media/com_componentbuilder/js/timeago.js");
		$document->addScriptDeclaration('
		var urlToGetAllOpenIssues = "https://api.github.com/repos/vdm-io/Joomla-Component-Builder/issues?state=open&page=1&per_page=5";
		var urlToGetAllClosedIssues = "https://api.github.com/repos/vdm-io/Joomla-Component-Builder/issues?state=closed&page=1&per_page=5";
		var urlToGetAllReleases = "https://api.github.com/repos/vdm-io/Joomla-Component-Builder/releases?page=1&per_page=5";
		jQuery(document).ready(function () {
			jQuery.getJSON(urlToGetAllOpenIssues, function (openissues) {
				jQuery("#openissues").html("");
				jQuery.each(openissues, function (i, issue) {
					// set time ago
					var timeago = jQuery.timeago(new Date(issue.created_at)); 
					jQuery("#openissues")
            				.append("<h3><a href=\"" + issue.html_url + "\" target=\"_blank\">" + issue.title + "</a></h3>")
					.append("<img alt=\"@" + issue.user.login + "\" style=\"vertical-align: baseline;\" src=\"" + issue.user.avatar_url +"&amp;s=60\" width=\"30\" height=\"30\"> ")
            				.append("<em><a href=\"" + issue.user.html_url + "\" target=\"_blank\">" + issue.user.login + "</a> '.JText::_('COM_COMPONENTBUILDER_OPENED_THIS').' <a href=\"" + issue.html_url + "\" target=\"_blank\">'.JText::_('COM_COMPONENTBUILDER_ISSUE').'-" + issue.number + "</a> (" + timeago + ")</em> ")
            				.append(marked(issue.body))
            				.append("<a href=\"" + issue.html_url + "\" target=\"_blank\"><span class=\'icon-new-tab\'></span>'.JText::_('COM_COMPONENTBUILDER_RESPOND_TO_THIS_ISSUE_ON_GITHUB').'</a>...<hr />");
    				});
			});
			jQuery.getJSON(urlToGetAllClosedIssues, function (closedissues) {
				jQuery("#closedissues").html("");
				jQuery.each(closedissues, function (i, issue) {
					// set time ago
					var timeago = jQuery.timeago(new Date(issue.created_at)); 
					jQuery("#closedissues")
            				.append("<h3><a href=\"" + issue.html_url + "\" target=\"_blank\">" + issue.title + "</a></h3>")
					.append("<img alt=\"@" + issue.user.login + "\" style=\"vertical-align: baseline;\" src=\"" + issue.user.avatar_url +"&amp;s=60\" width=\"30\" height=\"30\"> ")
            				.append("<em><a href=\"" + issue.user.html_url + "\" target=\"_blank\">" + issue.user.login + "</a> '.JText::_('COM_COMPONENTBUILDER_OPENED').' <a href=\"" + issue.html_url + "\" target=\"_blank\">'.JText::_('COM_COMPONENTBUILDER_ISSUE').'-" + issue.number + "</a> (" + timeago + ")</em>")
            				.append(marked(issue.body))
            				.append("<a href=\"" + issue.html_url + "\" target=\"_blank\"><span class=\'icon-new-tab\'></span>'.JText::_('COM_COMPONENTBUILDER_REVIEW_THIS_ISSUE_ON_GITHUB').'</a>...<hr />");
    				});
			});
			jQuery.getJSON(urlToGetAllReleases, function (tagreleases) {				
				// set the update notice while we are at it
				var activeVersion = tagreleases[0].tag_name.substring(1);
				if (activeVersion === manifest.version) {
					// local version is in sync with latest release
					jQuery(".update-notice").html("<small><span style=\'color:green;\'><span class=\'icon-shield\'></span>'.JText::_('COM_COMPONENTBUILDER_UP_TO_DATE').'</span></small>");
				} else {
					// split versions in to array
					var activeVersionArray = activeVersion.split(".");
					var localVersionArray = manifest.version.split(".");					
					if ((+localVersionArray[0] > +activeVersionArray[0]) || 
					(+localVersionArray[0] == +activeVersionArray[0] && +localVersionArray[1] > +activeVersionArray[1]) || 
					(+localVersionArray[0] == +activeVersionArray[0] && +localVersionArray[1] == +activeVersionArray[1] && +localVersionArray[2] > +activeVersionArray[2])) {
						// local version head latest release
						jQuery(".update-notice").html("<small><span style=\'color:#F7B033;\'><span class=\'icon-wrench\'></span>'.JText::_('COM_COMPONENTBUILDER_BETA_RELEASE').'</span></small>");
					} else {
						// local version behind latest release
						jQuery(".update-notice").html("<small><span style=\'color:red;\'><span class=\'icon-warning-circle\'></span>'.JText::_('COM_COMPONENTBUILDER_OUT_OF_DATE').'</span></small>");
					}
				}
				// set the taged releases
				jQuery("#tagreleases").html("");
				jQuery.each(tagreleases, function (i, tagrelease) {
					// set active release
					var activeNotice = "";
					if (i === 0) {
						var activeNotice = "<a class=\'btn btn-small btn-success\' href=\'https://github.com/vdm-io/Joomla-Component-Builder/releases/latest\'><span class=\'icon-shield icon-white\'></span> '.JText::_('COM_COMPONENTBUILDER_LATEST_RELEASE').'</a><br /><br />";
					}
					// set time ago
					var timeago = jQuery.timeago(new Date(tagrelease.published_at)); 
					jQuery("#tagreleases")
            				.append("<h3><a href=\"" + tagrelease.html_url + "\" target=\"_blank\">" + tagrelease.name + "</a></h3>")
					.append(activeNotice)
					.append("<img alt=\"@" + tagrelease.author.login + "\" style=\"vertical-align: baseline;\" src=\"" + tagrelease.author.avatar_url +"&amp;s=60\" width=\"30\" height=\"30\"> ")
            				.append("<em><a href=\"" + tagrelease.author.html_url + "\" target=\"_blank\">" + tagrelease.author.login + "</a> '.JText::_('COM_COMPONENTBUILDER_RELEASED_THIS').'<em> <b><span class=\'icon-tag-2\'></span>" + tagrelease.tag_name+ "</b> (" + timeago + ")")
            				.append(marked(tagrelease.body))
            				.append(" <a class=\"hasTooltip\" href=\"" + tagrelease.assets[0].browser_download_url + "\" title=\"'.JText::_('COM_COMPONENTBUILDER_DOWNLOAD').' " + tagrelease.assets[0].name + "\" target=\"_self\"><span class=\'icon-download\'></span>" + tagrelease.assets[0].name + "</a> (<a class=\"hasTooltip\" href=\"" + tagrelease.assets[0].browser_download_url + "\" title=\"'.JText::_('COM_COMPONENTBUILDER_TOTAL_DOWNLOADS').'\"><small>" + tagrelease.assets[0].download_count + "</small></a>) ")
            				.append("| <a href=\"" + tagrelease.html_url + "\" target=\"_blank\" title=\"'.JText::_('COM_COMPONENTBUILDER_OPEN').' " + tagrelease.name + " '.JText::_('COM_COMPONENTBUILDER_ON_GITHUB').'\"><span class=\'icon-new-tab\'></span>'.JText::_('COM_COMPONENTBUILDER_OPEN_ON_GITHUB').'</a>...<hr />");
    				});
			});
		});');
		$create = '<div class="btn-group pull-right">
					<a href="https://github.com/vdm-io/Joomla-Component-Builder/issues/new" class="btn btn-primary"  target="_blank">'.JText::_('COM_COMPONENTBUILDER_NEW_ISSUE').'</a>
				</div></br >';
		$moreopen = '<b><a href="https://github.com/vdm-io/Joomla-Component-Builder/issues" target="_blank">'.JText::_('COM_COMPONENTBUILDER_VIEW_MORE_ISSUES_ON_GITHUB').'</a>...</b> ';
		$moreclosed = '<b><a href="https://github.com/vdm-io/Joomla-Component-Builder/issues?q=is%3Aissue+is%3Aclosed" target="_blank">'.JText::_('COM_COMPONENTBUILDER_VIEW_MORE_ISSUES_ON_GITHUB').'</a>...</b> ';
		$viewissues = '<b><a href="https://github.com/vdm-io/Joomla-Component-Builder/releases" target="_blank">'.JText::_('COM_COMPONENTBUILDER_VIEW_MORE_RELEASES_ON_GITHUB').'</a>...</b> ';

		return (object) array(
				'openissues' => $create.'<div id="openissues">'.JText::_('COM_COMPONENTBUILDER_A_FEW_OPEN_ISSUES_FROM_GITHUB_IS_LOADING').'.<span class="loading-dots">.</span></small></div>'.$moreopen, 
				'closedissues' => $create.'<div id="closedissues">'.JText::_('COM_COMPONENTBUILDER_A_FEW_CLOSED_ISSUES_FROM_GITHUB_IS_LOADING').'.<span class="loading-dots">.</span></small></div>'.$moreclosed,
				'tagreleases' => '<div id="tagreleases">'.JText::_('COM_COMPONENTBUILDER_LAST_FEW_RELEASES_FROM_GITHUB_IS_LOADING').'.<span class="loading-dots">.</span></small></div>'.$viewissues
		);
	}

	public function getWiki()
	{
		$document = JFactory::getDocument();
		$document->addScriptDeclaration('
		var gewiki = "https://raw.githubusercontent.com/wiki/vdm-io/Joomla-Component-Builder/Home.md";
		jQuery(document).ready(function () {
			jQuery.get(gewiki)
			.success(function(wiki) { 
				jQuery("#wiki-md").html(marked(wiki));
			})
			.error(function(jqXHR, textStatus, errorThrown) { 
				jQuery("#wiki-md").html("'.JText::_('COM_COMPONENTBUILDER_PLEASE_CHECK_AGAIN_LATTER').'");
			});
		});');

		return '<div id="wiki-md"><small>'.JText::_('COM_COMPONENTBUILDER_THE_WIKI_IS_LOADING').'.<span class="loading-dots">.</span></small></div>';
	}

	

	public function getNoticeboard()
	{
		// get the document to load the scripts
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . "media/com_componentbuilder/js/marked.js");
		$document->addScriptDeclaration('
		var token = "'.JSession::getFormToken().'";
		var noticeboard = "https://vdm.bz/componentbuilder-noticeboard-md";
		jQuery(document).ready(function () {
			jQuery.get(noticeboard)
			.success(function(board) { 
				if (board.length > 5) {
					jQuery("#noticeboard-md").html(marked(board));
					getIS(1,board).done(function(result) {
						if (result){
							jQuery("#cpanel_tabTabs a").each(function() {
								if (this.href.indexOf("#vast_development_method") >= 0 || this.href.indexOf("#notice_board") >= 0) {
									var textVDM = jQuery(this).text();
									jQuery(this).html("<span class=\"label label-important vdm-new-notice\">1</span> "+textVDM);
									jQuery(this).attr("id","vdm-new-notice");
									jQuery("#vdm-new-notice").click(function() {
										getIS(2,board).done(function(result) {
												if (result) {
												jQuery(".vdm-new-notice").fadeOut(500);
											}
										});
									});
								}
							});
						}
					});
				} else {
					jQuery("#noticeboard-md").html("'.JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_PLEASE_CHECK_AGAIN_LATTER').'");
				}
			})
			.error(function(jqXHR, textStatus, errorThrown) { 
				jQuery("#noticeboard-md").html("'.JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_PLEASE_CHECK_AGAIN_LATTER').'");
			});
		});
		// to check is READ/NEW
		function getIS(type,notice){
			if(type == 1){
				var getUrl = "index.php?option=com_componentbuilder&task=ajax.isNew&format=json&raw=true";
			} else if (type == 2) {
				var getUrl = "index.php?option=com_componentbuilder&task=ajax.isRead&format=json&raw=true";
			}	
			if(token.length > 0 && notice.length){
				var request = "token="+token+"&notice="+notice;
			}
			return jQuery.ajax({
				type: "POST",
				url: getUrl,
				dataType: "json",
				data: request,
				jsonp: false
			});
		}
		
// nice little dot trick :)
jQuery(document).ready( function($) {
  var x=0;
  setInterval(function() {
	var dots = "";
	x++;
	for (var y=0; y < x%8; y++) {
		dots+=".";
	}
	$(".loading-dots").text(dots);
  } , 500);
});');

		return '<div id="noticeboard-md">'.JText::_('COM_COMPONENTBUILDER_THE_NOTICE_BOARD_IS_LOADING').'.<span class="loading-dots">.</span></small></div>';
	}

	public function getProboard()
	{
		// get the document to load the scripts
		$document = JFactory::getDocument();
		$document->addScriptDeclaration('
		var proboard = "https://vdm.bz/componentbuilder-pro-noticeboard-md";
		jQuery(document).ready(function () {
			jQuery.get(proboard)
			.success(function(board) {
				if (board.length > 5) {
					jQuery("#proboard-md").html(marked(board));
				} else {
					jQuery("#proboard-md").html("'.JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_PLEASE_CHECK_AGAIN_LATTER').'");
				}
			})
			.error(function(jqXHR, textStatus, errorThrown) { 
				jQuery("#proboard-md").html("'.JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_PLEASE_CHECK_AGAIN_LATTER').'");
			});
		});');

		return '<div id="proboard-md">'.JText::_('COM_COMPONENTBUILDER_THE_PRO_BOARD_IS_LOADING').'.<span class="loading-dots">.</span></small></div>';
	}

	public function getReadme()
	{
		$document = JFactory::getDocument();
		$document->addScriptDeclaration('
		var getreadme = "'. JURI::root() . 'administrator/components/com_componentbuilder/README.txt";
		jQuery(document).ready(function () {
			jQuery.get(getreadme)
			.success(function(readme) { 
				jQuery("#readme-md").html(marked(readme));
			})
			.error(function(jqXHR, textStatus, errorThrown) { 
				jQuery("#readme-md").html("'.JText::_('COM_COMPONENTBUILDER_PLEASE_CHECK_AGAIN_LATTER').'");
			});
		});');

		return '<div id="readme-md"><small>'.JText::_('COM_COMPONENTBUILDER_THE_README_IS_LOADING').'.<span class="loading-dots">.</span></small></div>';
	}
}
