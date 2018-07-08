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
			if ($this->setAdminViews($data['id']))
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
	protected function setAdminViews(&$component_id)
	{
		// check if views were set
		if (ComponentbuilderHelper::checkArray($this->views))
		{
			$count = 0;
			if (ComponentbuilderHelper::checkArray($this->addadmin_views))
			{
				$count = (int) count((array)$this->addadmin_views) + 3;
			}
			// set the admin view data linking
			foreach ($this->views as $nr => $id)
			{
				$pointer = $count + $nr;
				$this->addadmin_views['addadmin_views'.$pointer]['adminview'] = $id;
				$this->addadmin_views['addadmin_views'.$pointer]['icomoon'] = 'joomla';
				$this->addadmin_views['addadmin_views'.$pointer]['mainmenu'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['dashboard_add'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['dashboard_list'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['submenu'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['checkin'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['history'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['metadata'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['access'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['port'] = 1;
				$this->addadmin_views['addadmin_views'.$pointer]['edit_create_site_view'] = 0;
				$this->addadmin_views['addadmin_views'.$pointer]['order'] = $pointer + 1;
			}
		}
		if (isset($this->addadmin_views) && ComponentbuilderHelper::checkArray($this->addadmin_views))
		{
			// set the field object
			$object = new stdClass();
			$object->joomla_component = $component_id;
			$object->addadmin_views = json_encode($this->addadmin_views, JSON_FORCE_OBJECT);
			$object->created = $this->today;
			$object->created_by = $this->user->id;
			$object->published = 1;
			// check if it is already set
			if ($item_id = ComponentbuilderHelper::getVar('component_admin_views', $component_id, 'joomla_component', 'id'))
			{
				// set ID
				$object->id = (int) $item_id;
				return $this->db->updateObject('#__componentbuilder_component_admin_views', $object, 'id');
			}
			// add to data base
			return $this->db->insertObject('#__componentbuilder_component_admin_views', $object);
		}
		return false;
	}	
}
