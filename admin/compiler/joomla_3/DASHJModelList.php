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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('joomla.application.component.helper');

/**
 * ###Component### Model
 */
class ###Component###Model###Component### extends JModelList
{
	public function getIcons()
	{
		// load user for access menus
		$user = JFactory::getUser();
		// reset icon array
		$icons  = array();
		// view groups array
		$viewGroups = array(
			'main' => array(###DASHBOARDICONS###)
		);###DASHBOARDICONACCESS###
		foreach($viewGroups as $group => $views)
		{
			$i = 0;
			if (###Component###Helper::checkArray($views))
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
										$url 	='index.php?option=com_###component###&view='.$name.'&layout=edit';
										$image 	= $name.'_'.$action.'.'.$type;
										$alt 	= $name.'&nbsp;'.$action;
										$name	= 'COM_###COMPONENT###_DASHBOARD_'.###Component###Helper::safeString($name,'U').'_ADD';
										$add	= true;
									break;
									default:
										$url 	= 'index.php?option=com_categories&view=categories&extension=com_###component###.'.$name;
										$image 	= $name.'_'.$action.'.'.$type;
										$alt 	= $name.'&nbsp;'.$action;
										$name	= 'COM_###COMPONENT###_DASHBOARD_'.###Component###Helper::safeString($name,'U').'_'.###Component###Helper::safeString($action,'U');
									break;
								}
							}
							else
							{
								$viewName 	= $name;
								$alt 		= $name;
								$url 		= 'index.php?option=com_###component###&view='.$name;
								$image 		= $name.'.'.$type;
								$name 		= 'COM_###COMPONENT###_DASHBOARD_'.###Component###Helper::safeString($name,'U');
								$hover		= false;
							}
					}
					else
					{
						$viewName 	= $view;
						$alt 		= $view;
						$url 		= 'index.php?option=com_###component###&view='.$view;
						$image 		= $view.'.png';
						$name 		= ucwords($view).'<br /><br />';
						$hover		= false;
					}
					// first make sure the view access is set
					if (###Component###Helper::checkArray($viewAccess))
					{
						// setup some defaults
						$dashboard_add = false;
						$dashboard_list = false;
						$accessTo = '';
						$accessAdd = '';
						// acces checking start
						$accessCreate = (isset($viewAccess[$viewName.'.create'])) ? ###Component###Helper::checkString($viewAccess[$viewName.'.create']):false;
						$accessAccess = (isset($viewAccess[$viewName.'.access'])) ? ###Component###Helper::checkString($viewAccess[$viewName.'.access']):false;
						// set main controllers
						$accessDashboard_add = (isset($viewAccess[$viewName.'.dashboard_add'])) ? ###Component###Helper::checkString($viewAccess[$viewName.'.dashboard_add']):false;
						$accessDashboard_list = (isset($viewAccess[$viewName.'.dashboard_list'])) ? ###Component###Helper::checkString($viewAccess[$viewName.'.dashboard_list']):false;
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
							$dashboard_add	= $user->authorise($viewAccess[$viewName.'.dashboard_add'], 'com_###component###');
						}
						if ($accessDashboard_list)
						{
							$dashboard_list = $user->authorise($viewAccess[$viewName.'.dashboard_list'], 'com_###component###');
						}
						if (###Component###Helper::checkString($accessAdd) && ###Component###Helper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessAdd, 'com_###component###') && $user->authorise($accessTo, 'com_###component###') && $dashboard_add)
							{
								$icons[$group][$i]              = new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (###Component###Helper::checkString($accessTo))
						{
							// check access
							if($user->authorise($accessTo, 'com_###component###') && $dashboard_list)
							{
								$icons[$group][$i]              = new StdClass;
								$icons[$group][$i]->url 	= $url;
								$icons[$group][$i]->name 	= $name;
								$icons[$group][$i]->image 	= $image;
								$icons[$group][$i]->alt 	= $alt;
							}
						}
						elseif (###Component###Helper::checkString($accessAdd))
						{
							// check access
							if($user->authorise($accessAdd, 'com_###component###') && $dashboard_add)
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
	}###DASH_MODEL_METHODS###
}
