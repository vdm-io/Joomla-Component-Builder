<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this JCB template file (EVER)
defined('_JCB_TEMPLATE') or die;
?>
###BOM###
namespace ###NAMESPACEPREFIX###\Component\###ComponentNamespace###\Administrator\Model;

###DASH_MODEL_HEADER###

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * ###Component### List Model
 *
 * @since  1.6
 */
class ###Component###Model extends ListModel
{
	/**
	 * The styles array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $styles = [
		'administrator/components/com_###component###/assets/css/admin.css',
		'administrator/components/com_###component###/assets/css/dashboard.css'
 	];

	/**
	 * The scripts array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $scripts = [
		'administrator/components/com_###component###/assets/js/admin.js'
 	];

	public function getIcons()
	{
		// load user for access menus
		$user = Factory::getApplication()->getIdentity();
		// reset icon array
		$icons  = [];
		// view groups array
		$viewGroups = array(
			'main' => array(###DASHBOARDICONS###)
		);###DASHBOARDICONACCESS###
		// loop over the $views
		foreach($viewGroups as $group => $views)
		{
			$i = 0;
			if (Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($views))
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
							$name     = 'COM_###COMPONENT###_DASHBOARD_' . Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($name,'U');
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
									$url   = 'index.php?option=com_###component###&view=' . $name . '&layout=edit';
									$image = $name . '_' . $action.  '.' . $type;
									$alt   = $name . '&nbsp;' . $action;
									$name  = 'COM_###COMPONENT###_DASHBOARD_'.Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($name,'U').'_ADD';
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
										$extension = 'com_###component###.' . $name;
									}
									$url   = 'index.php?option=com_categories&view=categories&extension=' . $extension;
									$image = $name . '_' . $action . '.' . $type;
									$alt   = $viewName . '&nbsp;' . $action;
									$name  = 'COM_###COMPONENT###_DASHBOARD_' . Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($name,'U') . '_' . Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($action,'U');
								break;
							}
						}
						else
						{
							$viewName = $name;
							$alt      = $name;
							$url      = 'index.php?option=com_###component###&view=' . $name;
							$image    = $name . '.' . $type;
							$name     = 'COM_###COMPONENT###_DASHBOARD_' . Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::safe($name,'U');
							$hover    = false;
						}
					}
					else
					{
						$viewName = $view;
						$alt      = $view;
						$url      = 'index.php?option=com_###component###&view=' . $view;
						$image    = $view . '.png';
						$name     = ucwords($view).'<br /><br />';
						$hover    = false;
					}
					// first make sure the view access is set
					if (Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($viewAccess))
					{
						// setup some defaults
						$dashboard_add = false;
						$dashboard_list = false;
						$accessTo = '';
						$accessAdd = '';
						// access checking start
						$accessCreate = (isset($viewAccess[$viewName.'.create'])) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($viewAccess[$viewName.'.create']):false;
						$accessAccess = (isset($viewAccess[$viewName.'.access'])) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($viewAccess[$viewName.'.access']):false;
						// set main controllers
						$accessDashboard_add = (isset($viewAccess[$viewName.'.dashboard_add'])) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($viewAccess[$viewName.'.dashboard_add']):false;
						$accessDashboard_list = (isset($viewAccess[$viewName.'.dashboard_list'])) ? Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($viewAccess[$viewName.'.dashboard_list']):false;
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
							$dashboard_add    = $user->authorise($viewAccess[$viewName.'.dashboard_add'], 'com_###component###');
						}
						if ($accessDashboard_list)
						{
							$dashboard_list = $user->authorise($viewAccess[$viewName.'.dashboard_list'], 'com_###component###');
						}
						if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($accessAdd) && Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($accessTo))
						{
							// check access
							if($user->authorise($accessAdd, 'com_###component###') && $user->authorise($accessTo, 'com_###component###') && $dashboard_add)
							{
								$icons[$group][$i]        = new \StdClass;
								$icons[$group][$i]->url   = $url;
								$icons[$group][$i]->name  = $name;
								$icons[$group][$i]->image = $image;
								$icons[$group][$i]->alt   = $alt;
							}
						}
						elseif (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($accessTo))
						{
							// check access
							if($user->authorise($accessTo, 'com_###component###') && $dashboard_list)
							{
								$icons[$group][$i]        = new \StdClass;
								$icons[$group][$i]->url   = $url;
								$icons[$group][$i]->name  = $name;
								$icons[$group][$i]->image = $image;
								$icons[$group][$i]->alt   = $alt;
							}
						}
						elseif (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($accessAdd))
						{
							// check access
							if($user->authorise($accessAdd, 'com_###component###') && $dashboard_add)
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
	}###DASH_MODEL_METHODS###
}
