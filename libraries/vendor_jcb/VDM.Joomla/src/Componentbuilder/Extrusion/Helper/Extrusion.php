<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Helper;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelperExtrusion as GetHelper;
use VDM\Joomla\Componentbuilder\Extrusion\Helper\Builder;


/**
 * Extrusion class
 * 
 * @since 3.2.0
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
					Text::_('COM_COMPONENTBUILDER_ALL_THE_FIELDS_AND_VIEWS_FROM_YOUR_SQL_DUMP_HAS_BEEN_CREATED_AND_LINKED_TO_THIS_COMPONENT'),
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
		if (ArrayHelper::check($this->views))
		{
			$count = 0;
			if (ArrayHelper::check($this->addadmin_views))
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
		if (isset($this->addadmin_views) && ArrayHelper::check($this->addadmin_views))
		{
			// set the field object
			$object = new \stdClass();
			$object->joomla_component = $component_id;
			$object->addadmin_views = json_encode($this->addadmin_views, JSON_FORCE_OBJECT);
			$object->created = $this->today;
			$object->created_by = $this->user->id;
			$object->published = 1;
			// check if it is already set
			if ($item_id = GetHelper::var('component_admin_views', $component_id, 'joomla_component', 'id'))
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

