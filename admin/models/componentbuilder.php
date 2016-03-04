<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.1.2
	@build			4th March, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		componentbuilder.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

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
			'main' => array('png.compiler', 'png.component.add', 'png.components', 'png.admin_view.add', 'png.admin_views', 'png.custom_admin_view.add', 'png.custom_admin_views', 'png.site_view.add', 'png.site_views', 'png.template.add', 'png.templates', 'png.layout.add', 'png.layouts', 'png.dynamic_get.add', 'png.dynamic_gets', 'png.snippet.add', 'png.snippets', 'png.field.add', 'png.fields', 'png.fields.catid', 'png.fieldtype.add', 'png.fieldtypes', 'png.fieldtypes.catid', 'png.help_document.add', 'png.help_documents')
		);
		// view access array
		$viewAccess = array(
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
			'layout.dashboard_add' => 'layout.dashboard_add',
			'dynamic_get.create' => 'dynamic_get.create',
			'dynamic_gets.access' => 'dynamic_get.access',
			'dynamic_get.access' => 'dynamic_get.access',
			'dynamic_gets.submenu' => 'dynamic_get.submenu',
			'dynamic_gets.dashboard_list' => 'dynamic_get.dashboard_list',
			'dynamic_get.dashboard_add' => 'dynamic_get.dashboard_add',
			'snippets.access' => 'snippet.access',
			'snippet.access' => 'snippet.access',
			'snippets.submenu' => 'snippet.submenu',
			'snippets.dashboard_list' => 'snippet.dashboard_list',
			'snippet.dashboard_add' => 'snippet.dashboard_add',
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
			'fieldtype.dashboard_add' => 'fieldtype.dashboard_add',
			'help_document.create' => 'help_document.create',
			'help_documents.access' => 'help_document.access',
			'help_document.access' => 'help_document.access',
			'help_documents.submenu' => 'help_document.submenu',
			'help_documents.dashboard_list' => 'help_document.dashboard_list',
			'help_document.dashboard_add' => 'help_document.dashboard_add');
		foreach($viewGroups as $group => $views)
                {
			$i = 0;
			if (ComponentbuilderHelper::checkArray($views))
                        {
				foreach($views as $view)
				{
					$add = false;
					if (strpos($view,'.') !== false)
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
                                                                        $url 	='index.php?option=com_componentbuilder&view='.$name.'&layout=edit';
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
                                                                $icons[$group][$i]              = new StdClass;
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
                                                                $icons[$group][$i]              = new StdClass;
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
                                                                $icons[$group][$i]              = new StdClass;
                                                                $icons[$group][$i]->url 	= $url;
                                                                $icons[$group][$i]->name 	= $name;
                                                                $icons[$group][$i]->image 	= $image;
                                                                $icons[$group][$i]->alt 	= $alt;
                                                        }
                                                }
                                                else
                                                {
                                                        $icons[$group][$i]              = new StdClass;
                                                        $icons[$group][$i]->url 	= $url;
                                                        $icons[$group][$i]->name 	= $name;
                                                        $icons[$group][$i]->image 	= $image;
                                                        $icons[$group][$i]->alt 	= $alt;
                                                }
                                        }
                                        else
                                        {
                                                $icons[$group][$i]              = new StdClass;
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
}
