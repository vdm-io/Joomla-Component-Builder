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

	@version			1.0.0
	@created		26th December, 2016
	@package		Component Builder
	@subpackage		extrusion.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Extrusion class
 */
class Extrusion extends Builder
{
	/***
	 * Constructor
	 */
	public function __construct(&$data)
	{
		// first we run the perent constructor
		if (parent::__construct($data))
		{
			// link the view data to the component
			$data['addadmin_views'] = $this->linkAdminViews();
			if (ComponentbuilderHelper::checkJson($data['addadmin_views']))
			{
				$this->app->enqueueMessage(
					JText::_('All the fields and views from your sql dump has been created and linked to this component.'),
					'Success'
				);
				return true;
			}
		}
		return false;
	}
	
	/**
	 *	link the build views to the component
	 */
	protected function linkAdminViews()
	{
		// check if views were set
		if (ComponentbuilderHelper::checkArray($this->views))
		{
			// insure arrays are set
			if (!isset($this->addadmin_views['adminview']))
			{
				$this->addadmin_views['adminview'] = array();
			}
			if (!isset($this->addadmin_views['icomoon']))
			{
				$this->addadmin_views['icomoon'] = array();
			}
			if (!isset($this->addadmin_views['mainmenu']))
			{
				$this->addadmin_views['mainmenu'] = array();
			}
			if (!isset($this->addadmin_views['dashboard_add']))
			{
				$this->addadmin_views['dashboard_add'] = array();
			}
			if (!isset($this->addadmin_views['dashboard_list']))
			{
				$this->addadmin_views['dashboard_list'] = array();
			}
			if (!isset($this->addadmin_views['submenu']))
			{
				$this->addadmin_views['submenu'] = array();
			}
			if (!isset($this->addadmin_views['checkin']))
			{
				$this->addadmin_views['checkin'] = array();
			}
			if (!isset($this->addadmin_views['history']))
			{
				$this->addadmin_views['history'] = array();
			}
			if (!isset($this->addadmin_views['metadata']))
			{
				$this->addadmin_views['metadata'] = array();
			}
			if (!isset($this->addadmin_views['access']))
			{
				$this->addadmin_views['access'] = array();
			}
			if (!isset($this->addadmin_views['port']))
			{
				$this->addadmin_views['port'] = array();
			}
			if (!isset($this->addadmin_views['edit_create_site_view']))
			{
				$this->addadmin_views['edit_create_site_view'] = array();
			}
			if (!isset($this->addadmin_views['order']))
			{
				$this->addadmin_views['order'] = array();
			}
			// set the admin view data linking
			foreach ($this->views as $id)
			{
				$this->addadmin_views['adminview'][] = $id;
				$this->addadmin_views['icomoon'][] = 'joomla';
				$this->addadmin_views['mainmenu'][] = 1;
				$this->addadmin_views['dashboard_add'][] = 1;
				$this->addadmin_views['dashboard_list'][] = 1;
				$this->addadmin_views['submenu'][] = 1;
				$this->addadmin_views['checkin'][] = 1;
				$this->addadmin_views['history'][] = 1;
				$this->addadmin_views['metadata'][] = 1;
				$this->addadmin_views['access'][] = 1;
				$this->addadmin_views['port'][] = 1;
				$this->addadmin_views['edit_create_site_view'][] = 0;
				$this->addadmin_views['order'][] = count($this->addadmin_views['order']) + 1;
			}
		}
		if (isset($this->addadmin_views) && ComponentbuilderHelper::checkArray($this->addadmin_views))
		{
			return json_encode($this->addadmin_views);
		}
		return '';
	}	
}
