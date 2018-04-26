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

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		script.php
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.modal');
jimport('joomla.installer.installer');
jimport('joomla.installer.helper');

/**
 * Script File of Componentbuilder Component
 */
class com_componentbuilderInstallerScript
{
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent)
	{

	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent)
	{
		// Get Application object
		$app = JFactory::getApplication();

		// Get The Database object
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Joomla_component alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.joomla_component') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$joomla_component_found = $db->getNumRows();
		// Now check if there were any rows
		if ($joomla_component_found)
		{
			// Since there are load the needed  joomla_component type ids
			$joomla_component_ids = $db->loadColumn();
			// Remove Joomla_component from the content type table
			$joomla_component_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.joomla_component') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($joomla_component_condition);
			$db->setQuery($query);
			// Execute the query to remove Joomla_component items
			$joomla_component_done = $db->execute();
			if ($joomla_component_done);
			{
				// If succesfully remove Joomla_component add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.joomla_component) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Joomla_component items from the contentitem tag map table
			$joomla_component_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.joomla_component') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($joomla_component_condition);
			$db->setQuery($query);
			// Execute the query to remove Joomla_component items
			$joomla_component_done = $db->execute();
			if ($joomla_component_done);
			{
				// If succesfully remove Joomla_component add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.joomla_component) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Joomla_component items from the ucm content table
			$joomla_component_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.joomla_component') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($joomla_component_condition);
			$db->setQuery($query);
			// Execute the query to remove Joomla_component items
			$joomla_component_done = $db->execute();
			if ($joomla_component_done);
			{
				// If succesfully remove Joomla_component add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.joomla_component) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Joomla_component items are cleared from DB
			foreach ($joomla_component_ids as $joomla_component_id)
			{
				// Remove Joomla_component items from the ucm base table
				$joomla_component_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $joomla_component_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($joomla_component_condition);
				$db->setQuery($query);
				// Execute the query to remove Joomla_component items
				$db->execute();

				// Remove Joomla_component items from the ucm history table
				$joomla_component_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $joomla_component_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($joomla_component_condition);
				$db->setQuery($query);
				// Execute the query to remove Joomla_component items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Admin_view alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_view') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$admin_view_found = $db->getNumRows();
		// Now check if there were any rows
		if ($admin_view_found)
		{
			// Since there are load the needed  admin_view type ids
			$admin_view_ids = $db->loadColumn();
			// Remove Admin_view from the content type table
			$admin_view_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($admin_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_view items
			$admin_view_done = $db->execute();
			if ($admin_view_done);
			{
				// If succesfully remove Admin_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_view) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Admin_view items from the contentitem tag map table
			$admin_view_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($admin_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_view items
			$admin_view_done = $db->execute();
			if ($admin_view_done);
			{
				// If succesfully remove Admin_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_view) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Admin_view items from the ucm content table
			$admin_view_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.admin_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($admin_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_view items
			$admin_view_done = $db->execute();
			if ($admin_view_done);
			{
				// If succesfully remove Admin_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_view) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Admin_view items are cleared from DB
			foreach ($admin_view_ids as $admin_view_id)
			{
				// Remove Admin_view items from the ucm base table
				$admin_view_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $admin_view_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($admin_view_condition);
				$db->setQuery($query);
				// Execute the query to remove Admin_view items
				$db->execute();

				// Remove Admin_view items from the ucm history table
				$admin_view_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $admin_view_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($admin_view_condition);
				$db->setQuery($query);
				// Execute the query to remove Admin_view items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Custom_admin_view alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.custom_admin_view') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$custom_admin_view_found = $db->getNumRows();
		// Now check if there were any rows
		if ($custom_admin_view_found)
		{
			// Since there are load the needed  custom_admin_view type ids
			$custom_admin_view_ids = $db->loadColumn();
			// Remove Custom_admin_view from the content type table
			$custom_admin_view_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.custom_admin_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($custom_admin_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Custom_admin_view items
			$custom_admin_view_done = $db->execute();
			if ($custom_admin_view_done);
			{
				// If succesfully remove Custom_admin_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.custom_admin_view) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Custom_admin_view items from the contentitem tag map table
			$custom_admin_view_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.custom_admin_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($custom_admin_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Custom_admin_view items
			$custom_admin_view_done = $db->execute();
			if ($custom_admin_view_done);
			{
				// If succesfully remove Custom_admin_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.custom_admin_view) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Custom_admin_view items from the ucm content table
			$custom_admin_view_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.custom_admin_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($custom_admin_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Custom_admin_view items
			$custom_admin_view_done = $db->execute();
			if ($custom_admin_view_done);
			{
				// If succesfully remove Custom_admin_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.custom_admin_view) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Custom_admin_view items are cleared from DB
			foreach ($custom_admin_view_ids as $custom_admin_view_id)
			{
				// Remove Custom_admin_view items from the ucm base table
				$custom_admin_view_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $custom_admin_view_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($custom_admin_view_condition);
				$db->setQuery($query);
				// Execute the query to remove Custom_admin_view items
				$db->execute();

				// Remove Custom_admin_view items from the ucm history table
				$custom_admin_view_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $custom_admin_view_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($custom_admin_view_condition);
				$db->setQuery($query);
				// Execute the query to remove Custom_admin_view items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Site_view alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.site_view') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$site_view_found = $db->getNumRows();
		// Now check if there were any rows
		if ($site_view_found)
		{
			// Since there are load the needed  site_view type ids
			$site_view_ids = $db->loadColumn();
			// Remove Site_view from the content type table
			$site_view_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.site_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($site_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Site_view items
			$site_view_done = $db->execute();
			if ($site_view_done);
			{
				// If succesfully remove Site_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.site_view) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Site_view items from the contentitem tag map table
			$site_view_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.site_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($site_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Site_view items
			$site_view_done = $db->execute();
			if ($site_view_done);
			{
				// If succesfully remove Site_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.site_view) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Site_view items from the ucm content table
			$site_view_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.site_view') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($site_view_condition);
			$db->setQuery($query);
			// Execute the query to remove Site_view items
			$site_view_done = $db->execute();
			if ($site_view_done);
			{
				// If succesfully remove Site_view add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.site_view) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Site_view items are cleared from DB
			foreach ($site_view_ids as $site_view_id)
			{
				// Remove Site_view items from the ucm base table
				$site_view_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $site_view_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($site_view_condition);
				$db->setQuery($query);
				// Execute the query to remove Site_view items
				$db->execute();

				// Remove Site_view items from the ucm history table
				$site_view_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $site_view_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($site_view_condition);
				$db->setQuery($query);
				// Execute the query to remove Site_view items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Template alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.template') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$template_found = $db->getNumRows();
		// Now check if there were any rows
		if ($template_found)
		{
			// Since there are load the needed  template type ids
			$template_ids = $db->loadColumn();
			// Remove Template from the content type table
			$template_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.template') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($template_condition);
			$db->setQuery($query);
			// Execute the query to remove Template items
			$template_done = $db->execute();
			if ($template_done);
			{
				// If succesfully remove Template add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.template) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Template items from the contentitem tag map table
			$template_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.template') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($template_condition);
			$db->setQuery($query);
			// Execute the query to remove Template items
			$template_done = $db->execute();
			if ($template_done);
			{
				// If succesfully remove Template add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.template) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Template items from the ucm content table
			$template_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.template') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($template_condition);
			$db->setQuery($query);
			// Execute the query to remove Template items
			$template_done = $db->execute();
			if ($template_done);
			{
				// If succesfully remove Template add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.template) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Template items are cleared from DB
			foreach ($template_ids as $template_id)
			{
				// Remove Template items from the ucm base table
				$template_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $template_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($template_condition);
				$db->setQuery($query);
				// Execute the query to remove Template items
				$db->execute();

				// Remove Template items from the ucm history table
				$template_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $template_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($template_condition);
				$db->setQuery($query);
				// Execute the query to remove Template items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Layout alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.layout') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$layout_found = $db->getNumRows();
		// Now check if there were any rows
		if ($layout_found)
		{
			// Since there are load the needed  layout type ids
			$layout_ids = $db->loadColumn();
			// Remove Layout from the content type table
			$layout_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.layout') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($layout_condition);
			$db->setQuery($query);
			// Execute the query to remove Layout items
			$layout_done = $db->execute();
			if ($layout_done);
			{
				// If succesfully remove Layout add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.layout) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Layout items from the contentitem tag map table
			$layout_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.layout') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($layout_condition);
			$db->setQuery($query);
			// Execute the query to remove Layout items
			$layout_done = $db->execute();
			if ($layout_done);
			{
				// If succesfully remove Layout add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.layout) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Layout items from the ucm content table
			$layout_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.layout') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($layout_condition);
			$db->setQuery($query);
			// Execute the query to remove Layout items
			$layout_done = $db->execute();
			if ($layout_done);
			{
				// If succesfully remove Layout add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.layout) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Layout items are cleared from DB
			foreach ($layout_ids as $layout_id)
			{
				// Remove Layout items from the ucm base table
				$layout_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $layout_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($layout_condition);
				$db->setQuery($query);
				// Execute the query to remove Layout items
				$db->execute();

				// Remove Layout items from the ucm history table
				$layout_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $layout_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($layout_condition);
				$db->setQuery($query);
				// Execute the query to remove Layout items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Dynamic_get alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.dynamic_get') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$dynamic_get_found = $db->getNumRows();
		// Now check if there were any rows
		if ($dynamic_get_found)
		{
			// Since there are load the needed  dynamic_get type ids
			$dynamic_get_ids = $db->loadColumn();
			// Remove Dynamic_get from the content type table
			$dynamic_get_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.dynamic_get') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($dynamic_get_condition);
			$db->setQuery($query);
			// Execute the query to remove Dynamic_get items
			$dynamic_get_done = $db->execute();
			if ($dynamic_get_done);
			{
				// If succesfully remove Dynamic_get add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.dynamic_get) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Dynamic_get items from the contentitem tag map table
			$dynamic_get_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.dynamic_get') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($dynamic_get_condition);
			$db->setQuery($query);
			// Execute the query to remove Dynamic_get items
			$dynamic_get_done = $db->execute();
			if ($dynamic_get_done);
			{
				// If succesfully remove Dynamic_get add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.dynamic_get) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Dynamic_get items from the ucm content table
			$dynamic_get_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.dynamic_get') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($dynamic_get_condition);
			$db->setQuery($query);
			// Execute the query to remove Dynamic_get items
			$dynamic_get_done = $db->execute();
			if ($dynamic_get_done);
			{
				// If succesfully remove Dynamic_get add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.dynamic_get) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Dynamic_get items are cleared from DB
			foreach ($dynamic_get_ids as $dynamic_get_id)
			{
				// Remove Dynamic_get items from the ucm base table
				$dynamic_get_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $dynamic_get_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($dynamic_get_condition);
				$db->setQuery($query);
				// Execute the query to remove Dynamic_get items
				$db->execute();

				// Remove Dynamic_get items from the ucm history table
				$dynamic_get_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $dynamic_get_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($dynamic_get_condition);
				$db->setQuery($query);
				// Execute the query to remove Dynamic_get items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Custom_code alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.custom_code') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$custom_code_found = $db->getNumRows();
		// Now check if there were any rows
		if ($custom_code_found)
		{
			// Since there are load the needed  custom_code type ids
			$custom_code_ids = $db->loadColumn();
			// Remove Custom_code from the content type table
			$custom_code_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.custom_code') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($custom_code_condition);
			$db->setQuery($query);
			// Execute the query to remove Custom_code items
			$custom_code_done = $db->execute();
			if ($custom_code_done);
			{
				// If succesfully remove Custom_code add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.custom_code) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Custom_code items from the contentitem tag map table
			$custom_code_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.custom_code') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($custom_code_condition);
			$db->setQuery($query);
			// Execute the query to remove Custom_code items
			$custom_code_done = $db->execute();
			if ($custom_code_done);
			{
				// If succesfully remove Custom_code add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.custom_code) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Custom_code items from the ucm content table
			$custom_code_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.custom_code') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($custom_code_condition);
			$db->setQuery($query);
			// Execute the query to remove Custom_code items
			$custom_code_done = $db->execute();
			if ($custom_code_done);
			{
				// If succesfully remove Custom_code add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.custom_code) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Custom_code items are cleared from DB
			foreach ($custom_code_ids as $custom_code_id)
			{
				// Remove Custom_code items from the ucm base table
				$custom_code_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $custom_code_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($custom_code_condition);
				$db->setQuery($query);
				// Execute the query to remove Custom_code items
				$db->execute();

				// Remove Custom_code items from the ucm history table
				$custom_code_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $custom_code_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($custom_code_condition);
				$db->setQuery($query);
				// Execute the query to remove Custom_code items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Library alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$library_found = $db->getNumRows();
		// Now check if there were any rows
		if ($library_found)
		{
			// Since there are load the needed  library type ids
			$library_ids = $db->loadColumn();
			// Remove Library from the content type table
			$library_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($library_condition);
			$db->setQuery($query);
			// Execute the query to remove Library items
			$library_done = $db->execute();
			if ($library_done);
			{
				// If succesfully remove Library add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Library items from the contentitem tag map table
			$library_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($library_condition);
			$db->setQuery($query);
			// Execute the query to remove Library items
			$library_done = $db->execute();
			if ($library_done);
			{
				// If succesfully remove Library add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Library items from the ucm content table
			$library_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.library') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($library_condition);
			$db->setQuery($query);
			// Execute the query to remove Library items
			$library_done = $db->execute();
			if ($library_done);
			{
				// If succesfully remove Library add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Library items are cleared from DB
			foreach ($library_ids as $library_id)
			{
				// Remove Library items from the ucm base table
				$library_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $library_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($library_condition);
				$db->setQuery($query);
				// Execute the query to remove Library items
				$db->execute();

				// Remove Library items from the ucm history table
				$library_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $library_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($library_condition);
				$db->setQuery($query);
				// Execute the query to remove Library items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Snippet alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.snippet') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$snippet_found = $db->getNumRows();
		// Now check if there were any rows
		if ($snippet_found)
		{
			// Since there are load the needed  snippet type ids
			$snippet_ids = $db->loadColumn();
			// Remove Snippet from the content type table
			$snippet_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.snippet') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($snippet_condition);
			$db->setQuery($query);
			// Execute the query to remove Snippet items
			$snippet_done = $db->execute();
			if ($snippet_done);
			{
				// If succesfully remove Snippet add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.snippet) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Snippet items from the contentitem tag map table
			$snippet_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.snippet') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($snippet_condition);
			$db->setQuery($query);
			// Execute the query to remove Snippet items
			$snippet_done = $db->execute();
			if ($snippet_done);
			{
				// If succesfully remove Snippet add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.snippet) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Snippet items from the ucm content table
			$snippet_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.snippet') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($snippet_condition);
			$db->setQuery($query);
			// Execute the query to remove Snippet items
			$snippet_done = $db->execute();
			if ($snippet_done);
			{
				// If succesfully remove Snippet add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.snippet) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Snippet items are cleared from DB
			foreach ($snippet_ids as $snippet_id)
			{
				// Remove Snippet items from the ucm base table
				$snippet_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $snippet_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($snippet_condition);
				$db->setQuery($query);
				// Execute the query to remove Snippet items
				$db->execute();

				// Remove Snippet items from the ucm history table
				$snippet_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $snippet_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($snippet_condition);
				$db->setQuery($query);
				// Execute the query to remove Snippet items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Validation_rule alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.validation_rule') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$validation_rule_found = $db->getNumRows();
		// Now check if there were any rows
		if ($validation_rule_found)
		{
			// Since there are load the needed  validation_rule type ids
			$validation_rule_ids = $db->loadColumn();
			// Remove Validation_rule from the content type table
			$validation_rule_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.validation_rule') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($validation_rule_condition);
			$db->setQuery($query);
			// Execute the query to remove Validation_rule items
			$validation_rule_done = $db->execute();
			if ($validation_rule_done);
			{
				// If succesfully remove Validation_rule add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.validation_rule) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Validation_rule items from the contentitem tag map table
			$validation_rule_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.validation_rule') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($validation_rule_condition);
			$db->setQuery($query);
			// Execute the query to remove Validation_rule items
			$validation_rule_done = $db->execute();
			if ($validation_rule_done);
			{
				// If succesfully remove Validation_rule add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.validation_rule) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Validation_rule items from the ucm content table
			$validation_rule_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.validation_rule') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($validation_rule_condition);
			$db->setQuery($query);
			// Execute the query to remove Validation_rule items
			$validation_rule_done = $db->execute();
			if ($validation_rule_done);
			{
				// If succesfully remove Validation_rule add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.validation_rule) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Validation_rule items are cleared from DB
			foreach ($validation_rule_ids as $validation_rule_id)
			{
				// Remove Validation_rule items from the ucm base table
				$validation_rule_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $validation_rule_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($validation_rule_condition);
				$db->setQuery($query);
				// Execute the query to remove Validation_rule items
				$db->execute();

				// Remove Validation_rule items from the ucm history table
				$validation_rule_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $validation_rule_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($validation_rule_condition);
				$db->setQuery($query);
				// Execute the query to remove Validation_rule items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Field alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.field') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$field_found = $db->getNumRows();
		// Now check if there were any rows
		if ($field_found)
		{
			// Since there are load the needed  field type ids
			$field_ids = $db->loadColumn();
			// Remove Field from the content type table
			$field_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.field') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($field_condition);
			$db->setQuery($query);
			// Execute the query to remove Field items
			$field_done = $db->execute();
			if ($field_done);
			{
				// If succesfully remove Field add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.field) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Field items from the contentitem tag map table
			$field_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.field') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($field_condition);
			$db->setQuery($query);
			// Execute the query to remove Field items
			$field_done = $db->execute();
			if ($field_done);
			{
				// If succesfully remove Field add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.field) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Field items from the ucm content table
			$field_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.field') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($field_condition);
			$db->setQuery($query);
			// Execute the query to remove Field items
			$field_done = $db->execute();
			if ($field_done);
			{
				// If succesfully remove Field add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.field) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Field items are cleared from DB
			foreach ($field_ids as $field_id)
			{
				// Remove Field items from the ucm base table
				$field_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $field_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($field_condition);
				$db->setQuery($query);
				// Execute the query to remove Field items
				$db->execute();

				// Remove Field items from the ucm history table
				$field_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $field_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($field_condition);
				$db->setQuery($query);
				// Execute the query to remove Field items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Field catid alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fields.category') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$field_catid_found = $db->getNumRows();
		// Now check if there were any rows
		if ($field_catid_found)
		{
			// Since there are load the needed  field_catid type ids
			$field_catid_ids = $db->loadColumn();
			// Remove Field catid from the content type table
			$field_catid_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fields.category') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($field_catid_condition);
			$db->setQuery($query);
			// Execute the query to remove Field catid items
			$field_catid_done = $db->execute();
			if ($field_catid_done);
			{
				// If succesfully remove Field catid add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fields.category) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Field catid items from the contentitem tag map table
			$field_catid_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fields.category') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($field_catid_condition);
			$db->setQuery($query);
			// Execute the query to remove Field catid items
			$field_catid_done = $db->execute();
			if ($field_catid_done);
			{
				// If succesfully remove Field catid add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fields.category) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Field catid items from the ucm content table
			$field_catid_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.fields.category') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($field_catid_condition);
			$db->setQuery($query);
			// Execute the query to remove Field catid items
			$field_catid_done = $db->execute();
			if ($field_catid_done);
			{
				// If succesfully remove Field catid add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fields.category) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Field catid items are cleared from DB
			foreach ($field_catid_ids as $field_catid_id)
			{
				// Remove Field catid items from the ucm base table
				$field_catid_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $field_catid_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($field_catid_condition);
				$db->setQuery($query);
				// Execute the query to remove Field catid items
				$db->execute();

				// Remove Field catid items from the ucm history table
				$field_catid_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $field_catid_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($field_catid_condition);
				$db->setQuery($query);
				// Execute the query to remove Field catid items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Fieldtype alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fieldtype') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$fieldtype_found = $db->getNumRows();
		// Now check if there were any rows
		if ($fieldtype_found)
		{
			// Since there are load the needed  fieldtype type ids
			$fieldtype_ids = $db->loadColumn();
			// Remove Fieldtype from the content type table
			$fieldtype_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fieldtype') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($fieldtype_condition);
			$db->setQuery($query);
			// Execute the query to remove Fieldtype items
			$fieldtype_done = $db->execute();
			if ($fieldtype_done);
			{
				// If succesfully remove Fieldtype add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fieldtype) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Fieldtype items from the contentitem tag map table
			$fieldtype_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fieldtype') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($fieldtype_condition);
			$db->setQuery($query);
			// Execute the query to remove Fieldtype items
			$fieldtype_done = $db->execute();
			if ($fieldtype_done);
			{
				// If succesfully remove Fieldtype add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fieldtype) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Fieldtype items from the ucm content table
			$fieldtype_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.fieldtype') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($fieldtype_condition);
			$db->setQuery($query);
			// Execute the query to remove Fieldtype items
			$fieldtype_done = $db->execute();
			if ($fieldtype_done);
			{
				// If succesfully remove Fieldtype add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fieldtype) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Fieldtype items are cleared from DB
			foreach ($fieldtype_ids as $fieldtype_id)
			{
				// Remove Fieldtype items from the ucm base table
				$fieldtype_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $fieldtype_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($fieldtype_condition);
				$db->setQuery($query);
				// Execute the query to remove Fieldtype items
				$db->execute();

				// Remove Fieldtype items from the ucm history table
				$fieldtype_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $fieldtype_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($fieldtype_condition);
				$db->setQuery($query);
				// Execute the query to remove Fieldtype items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Fieldtype catid alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fieldtypes.category') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$fieldtype_catid_found = $db->getNumRows();
		// Now check if there were any rows
		if ($fieldtype_catid_found)
		{
			// Since there are load the needed  fieldtype_catid type ids
			$fieldtype_catid_ids = $db->loadColumn();
			// Remove Fieldtype catid from the content type table
			$fieldtype_catid_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fieldtypes.category') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($fieldtype_catid_condition);
			$db->setQuery($query);
			// Execute the query to remove Fieldtype catid items
			$fieldtype_catid_done = $db->execute();
			if ($fieldtype_catid_done);
			{
				// If succesfully remove Fieldtype catid add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fieldtypes.category) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Fieldtype catid items from the contentitem tag map table
			$fieldtype_catid_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.fieldtypes.category') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($fieldtype_catid_condition);
			$db->setQuery($query);
			// Execute the query to remove Fieldtype catid items
			$fieldtype_catid_done = $db->execute();
			if ($fieldtype_catid_done);
			{
				// If succesfully remove Fieldtype catid add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fieldtypes.category) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Fieldtype catid items from the ucm content table
			$fieldtype_catid_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.fieldtypes.category') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($fieldtype_catid_condition);
			$db->setQuery($query);
			// Execute the query to remove Fieldtype catid items
			$fieldtype_catid_done = $db->execute();
			if ($fieldtype_catid_done);
			{
				// If succesfully remove Fieldtype catid add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.fieldtypes.category) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Fieldtype catid items are cleared from DB
			foreach ($fieldtype_catid_ids as $fieldtype_catid_id)
			{
				// Remove Fieldtype catid items from the ucm base table
				$fieldtype_catid_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $fieldtype_catid_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($fieldtype_catid_condition);
				$db->setQuery($query);
				// Execute the query to remove Fieldtype catid items
				$db->execute();

				// Remove Fieldtype catid items from the ucm history table
				$fieldtype_catid_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $fieldtype_catid_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($fieldtype_catid_condition);
				$db->setQuery($query);
				// Execute the query to remove Fieldtype catid items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Language_translation alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.language_translation') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$language_translation_found = $db->getNumRows();
		// Now check if there were any rows
		if ($language_translation_found)
		{
			// Since there are load the needed  language_translation type ids
			$language_translation_ids = $db->loadColumn();
			// Remove Language_translation from the content type table
			$language_translation_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.language_translation') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($language_translation_condition);
			$db->setQuery($query);
			// Execute the query to remove Language_translation items
			$language_translation_done = $db->execute();
			if ($language_translation_done);
			{
				// If succesfully remove Language_translation add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.language_translation) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Language_translation items from the contentitem tag map table
			$language_translation_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.language_translation') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($language_translation_condition);
			$db->setQuery($query);
			// Execute the query to remove Language_translation items
			$language_translation_done = $db->execute();
			if ($language_translation_done);
			{
				// If succesfully remove Language_translation add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.language_translation) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Language_translation items from the ucm content table
			$language_translation_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.language_translation') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($language_translation_condition);
			$db->setQuery($query);
			// Execute the query to remove Language_translation items
			$language_translation_done = $db->execute();
			if ($language_translation_done);
			{
				// If succesfully remove Language_translation add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.language_translation) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Language_translation items are cleared from DB
			foreach ($language_translation_ids as $language_translation_id)
			{
				// Remove Language_translation items from the ucm base table
				$language_translation_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $language_translation_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($language_translation_condition);
				$db->setQuery($query);
				// Execute the query to remove Language_translation items
				$db->execute();

				// Remove Language_translation items from the ucm history table
				$language_translation_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $language_translation_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($language_translation_condition);
				$db->setQuery($query);
				// Execute the query to remove Language_translation items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Language alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.language') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$language_found = $db->getNumRows();
		// Now check if there were any rows
		if ($language_found)
		{
			// Since there are load the needed  language type ids
			$language_ids = $db->loadColumn();
			// Remove Language from the content type table
			$language_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.language') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($language_condition);
			$db->setQuery($query);
			// Execute the query to remove Language items
			$language_done = $db->execute();
			if ($language_done);
			{
				// If succesfully remove Language add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.language) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Language items from the contentitem tag map table
			$language_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.language') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($language_condition);
			$db->setQuery($query);
			// Execute the query to remove Language items
			$language_done = $db->execute();
			if ($language_done);
			{
				// If succesfully remove Language add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.language) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Language items from the ucm content table
			$language_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.language') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($language_condition);
			$db->setQuery($query);
			// Execute the query to remove Language items
			$language_done = $db->execute();
			if ($language_done);
			{
				// If succesfully remove Language add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.language) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Language items are cleared from DB
			foreach ($language_ids as $language_id)
			{
				// Remove Language items from the ucm base table
				$language_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $language_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($language_condition);
				$db->setQuery($query);
				// Execute the query to remove Language items
				$db->execute();

				// Remove Language items from the ucm history table
				$language_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $language_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($language_condition);
				$db->setQuery($query);
				// Execute the query to remove Language items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Server alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.server') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$server_found = $db->getNumRows();
		// Now check if there were any rows
		if ($server_found)
		{
			// Since there are load the needed  server type ids
			$server_ids = $db->loadColumn();
			// Remove Server from the content type table
			$server_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.server') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($server_condition);
			$db->setQuery($query);
			// Execute the query to remove Server items
			$server_done = $db->execute();
			if ($server_done);
			{
				// If succesfully remove Server add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.server) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Server items from the contentitem tag map table
			$server_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.server') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($server_condition);
			$db->setQuery($query);
			// Execute the query to remove Server items
			$server_done = $db->execute();
			if ($server_done);
			{
				// If succesfully remove Server add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.server) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Server items from the ucm content table
			$server_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.server') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($server_condition);
			$db->setQuery($query);
			// Execute the query to remove Server items
			$server_done = $db->execute();
			if ($server_done);
			{
				// If succesfully remove Server add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.server) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Server items are cleared from DB
			foreach ($server_ids as $server_id)
			{
				// Remove Server items from the ucm base table
				$server_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $server_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($server_condition);
				$db->setQuery($query);
				// Execute the query to remove Server items
				$db->execute();

				// Remove Server items from the ucm history table
				$server_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $server_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($server_condition);
				$db->setQuery($query);
				// Execute the query to remove Server items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Help_document alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.help_document') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$help_document_found = $db->getNumRows();
		// Now check if there were any rows
		if ($help_document_found)
		{
			// Since there are load the needed  help_document type ids
			$help_document_ids = $db->loadColumn();
			// Remove Help_document from the content type table
			$help_document_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.help_document') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($help_document_condition);
			$db->setQuery($query);
			// Execute the query to remove Help_document items
			$help_document_done = $db->execute();
			if ($help_document_done);
			{
				// If succesfully remove Help_document add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.help_document) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Help_document items from the contentitem tag map table
			$help_document_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.help_document') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($help_document_condition);
			$db->setQuery($query);
			// Execute the query to remove Help_document items
			$help_document_done = $db->execute();
			if ($help_document_done);
			{
				// If succesfully remove Help_document add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.help_document) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Help_document items from the ucm content table
			$help_document_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.help_document') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($help_document_condition);
			$db->setQuery($query);
			// Execute the query to remove Help_document items
			$help_document_done = $db->execute();
			if ($help_document_done);
			{
				// If succesfully remove Help_document add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.help_document) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Help_document items are cleared from DB
			foreach ($help_document_ids as $help_document_id)
			{
				// Remove Help_document items from the ucm base table
				$help_document_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $help_document_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($help_document_condition);
				$db->setQuery($query);
				// Execute the query to remove Help_document items
				$db->execute();

				// Remove Help_document items from the ucm history table
				$help_document_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $help_document_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($help_document_condition);
				$db->setQuery($query);
				// Execute the query to remove Help_document items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Admin_fields alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_fields') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$admin_fields_found = $db->getNumRows();
		// Now check if there were any rows
		if ($admin_fields_found)
		{
			// Since there are load the needed  admin_fields type ids
			$admin_fields_ids = $db->loadColumn();
			// Remove Admin_fields from the content type table
			$admin_fields_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_fields') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($admin_fields_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_fields items
			$admin_fields_done = $db->execute();
			if ($admin_fields_done);
			{
				// If succesfully remove Admin_fields add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_fields) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Admin_fields items from the contentitem tag map table
			$admin_fields_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_fields') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($admin_fields_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_fields items
			$admin_fields_done = $db->execute();
			if ($admin_fields_done);
			{
				// If succesfully remove Admin_fields add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_fields) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Admin_fields items from the ucm content table
			$admin_fields_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.admin_fields') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($admin_fields_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_fields items
			$admin_fields_done = $db->execute();
			if ($admin_fields_done);
			{
				// If succesfully remove Admin_fields add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_fields) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Admin_fields items are cleared from DB
			foreach ($admin_fields_ids as $admin_fields_id)
			{
				// Remove Admin_fields items from the ucm base table
				$admin_fields_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $admin_fields_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($admin_fields_condition);
				$db->setQuery($query);
				// Execute the query to remove Admin_fields items
				$db->execute();

				// Remove Admin_fields items from the ucm history table
				$admin_fields_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $admin_fields_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($admin_fields_condition);
				$db->setQuery($query);
				// Execute the query to remove Admin_fields items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Admin_fields_conditions alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_fields_conditions') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$admin_fields_conditions_found = $db->getNumRows();
		// Now check if there were any rows
		if ($admin_fields_conditions_found)
		{
			// Since there are load the needed  admin_fields_conditions type ids
			$admin_fields_conditions_ids = $db->loadColumn();
			// Remove Admin_fields_conditions from the content type table
			$admin_fields_conditions_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_fields_conditions') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($admin_fields_conditions_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_fields_conditions items
			$admin_fields_conditions_done = $db->execute();
			if ($admin_fields_conditions_done);
			{
				// If succesfully remove Admin_fields_conditions add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_fields_conditions) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Admin_fields_conditions items from the contentitem tag map table
			$admin_fields_conditions_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.admin_fields_conditions') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($admin_fields_conditions_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_fields_conditions items
			$admin_fields_conditions_done = $db->execute();
			if ($admin_fields_conditions_done);
			{
				// If succesfully remove Admin_fields_conditions add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_fields_conditions) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Admin_fields_conditions items from the ucm content table
			$admin_fields_conditions_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.admin_fields_conditions') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($admin_fields_conditions_condition);
			$db->setQuery($query);
			// Execute the query to remove Admin_fields_conditions items
			$admin_fields_conditions_done = $db->execute();
			if ($admin_fields_conditions_done);
			{
				// If succesfully remove Admin_fields_conditions add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.admin_fields_conditions) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Admin_fields_conditions items are cleared from DB
			foreach ($admin_fields_conditions_ids as $admin_fields_conditions_id)
			{
				// Remove Admin_fields_conditions items from the ucm base table
				$admin_fields_conditions_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $admin_fields_conditions_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($admin_fields_conditions_condition);
				$db->setQuery($query);
				// Execute the query to remove Admin_fields_conditions items
				$db->execute();

				// Remove Admin_fields_conditions items from the ucm history table
				$admin_fields_conditions_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $admin_fields_conditions_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($admin_fields_conditions_condition);
				$db->setQuery($query);
				// Execute the query to remove Admin_fields_conditions items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_admin_views alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_admin_views') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_admin_views_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_admin_views_found)
		{
			// Since there are load the needed  component_admin_views type ids
			$component_admin_views_ids = $db->loadColumn();
			// Remove Component_admin_views from the content type table
			$component_admin_views_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_admin_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_admin_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_admin_views items
			$component_admin_views_done = $db->execute();
			if ($component_admin_views_done);
			{
				// If succesfully remove Component_admin_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_admin_views) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_admin_views items from the contentitem tag map table
			$component_admin_views_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_admin_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_admin_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_admin_views items
			$component_admin_views_done = $db->execute();
			if ($component_admin_views_done);
			{
				// If succesfully remove Component_admin_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_admin_views) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_admin_views items from the ucm content table
			$component_admin_views_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_admin_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_admin_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_admin_views items
			$component_admin_views_done = $db->execute();
			if ($component_admin_views_done);
			{
				// If succesfully remove Component_admin_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_admin_views) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_admin_views items are cleared from DB
			foreach ($component_admin_views_ids as $component_admin_views_id)
			{
				// Remove Component_admin_views items from the ucm base table
				$component_admin_views_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_admin_views_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_admin_views_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_admin_views items
				$db->execute();

				// Remove Component_admin_views items from the ucm history table
				$component_admin_views_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_admin_views_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_admin_views_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_admin_views items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_site_views alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_site_views') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_site_views_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_site_views_found)
		{
			// Since there are load the needed  component_site_views type ids
			$component_site_views_ids = $db->loadColumn();
			// Remove Component_site_views from the content type table
			$component_site_views_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_site_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_site_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_site_views items
			$component_site_views_done = $db->execute();
			if ($component_site_views_done);
			{
				// If succesfully remove Component_site_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_site_views) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_site_views items from the contentitem tag map table
			$component_site_views_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_site_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_site_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_site_views items
			$component_site_views_done = $db->execute();
			if ($component_site_views_done);
			{
				// If succesfully remove Component_site_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_site_views) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_site_views items from the ucm content table
			$component_site_views_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_site_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_site_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_site_views items
			$component_site_views_done = $db->execute();
			if ($component_site_views_done);
			{
				// If succesfully remove Component_site_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_site_views) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_site_views items are cleared from DB
			foreach ($component_site_views_ids as $component_site_views_id)
			{
				// Remove Component_site_views items from the ucm base table
				$component_site_views_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_site_views_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_site_views_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_site_views items
				$db->execute();

				// Remove Component_site_views items from the ucm history table
				$component_site_views_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_site_views_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_site_views_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_site_views items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_custom_admin_views alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_custom_admin_views') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_custom_admin_views_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_custom_admin_views_found)
		{
			// Since there are load the needed  component_custom_admin_views type ids
			$component_custom_admin_views_ids = $db->loadColumn();
			// Remove Component_custom_admin_views from the content type table
			$component_custom_admin_views_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_custom_admin_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_custom_admin_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_custom_admin_views items
			$component_custom_admin_views_done = $db->execute();
			if ($component_custom_admin_views_done);
			{
				// If succesfully remove Component_custom_admin_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_custom_admin_views) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_custom_admin_views items from the contentitem tag map table
			$component_custom_admin_views_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_custom_admin_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_custom_admin_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_custom_admin_views items
			$component_custom_admin_views_done = $db->execute();
			if ($component_custom_admin_views_done);
			{
				// If succesfully remove Component_custom_admin_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_custom_admin_views) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_custom_admin_views items from the ucm content table
			$component_custom_admin_views_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_custom_admin_views') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_custom_admin_views_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_custom_admin_views items
			$component_custom_admin_views_done = $db->execute();
			if ($component_custom_admin_views_done);
			{
				// If succesfully remove Component_custom_admin_views add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_custom_admin_views) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_custom_admin_views items are cleared from DB
			foreach ($component_custom_admin_views_ids as $component_custom_admin_views_id)
			{
				// Remove Component_custom_admin_views items from the ucm base table
				$component_custom_admin_views_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_custom_admin_views_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_custom_admin_views_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_custom_admin_views items
				$db->execute();

				// Remove Component_custom_admin_views items from the ucm history table
				$component_custom_admin_views_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_custom_admin_views_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_custom_admin_views_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_custom_admin_views items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_updates alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_updates') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_updates_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_updates_found)
		{
			// Since there are load the needed  component_updates type ids
			$component_updates_ids = $db->loadColumn();
			// Remove Component_updates from the content type table
			$component_updates_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_updates') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_updates_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_updates items
			$component_updates_done = $db->execute();
			if ($component_updates_done);
			{
				// If succesfully remove Component_updates add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_updates) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_updates items from the contentitem tag map table
			$component_updates_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_updates') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_updates_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_updates items
			$component_updates_done = $db->execute();
			if ($component_updates_done);
			{
				// If succesfully remove Component_updates add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_updates) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_updates items from the ucm content table
			$component_updates_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_updates') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_updates_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_updates items
			$component_updates_done = $db->execute();
			if ($component_updates_done);
			{
				// If succesfully remove Component_updates add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_updates) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_updates items are cleared from DB
			foreach ($component_updates_ids as $component_updates_id)
			{
				// Remove Component_updates items from the ucm base table
				$component_updates_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_updates_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_updates_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_updates items
				$db->execute();

				// Remove Component_updates items from the ucm history table
				$component_updates_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_updates_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_updates_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_updates items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_mysql_tweaks alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_mysql_tweaks') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_mysql_tweaks_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_mysql_tweaks_found)
		{
			// Since there are load the needed  component_mysql_tweaks type ids
			$component_mysql_tweaks_ids = $db->loadColumn();
			// Remove Component_mysql_tweaks from the content type table
			$component_mysql_tweaks_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_mysql_tweaks') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_mysql_tweaks_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_mysql_tweaks items
			$component_mysql_tweaks_done = $db->execute();
			if ($component_mysql_tweaks_done);
			{
				// If succesfully remove Component_mysql_tweaks add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_mysql_tweaks) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_mysql_tweaks items from the contentitem tag map table
			$component_mysql_tweaks_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_mysql_tweaks') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_mysql_tweaks_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_mysql_tweaks items
			$component_mysql_tweaks_done = $db->execute();
			if ($component_mysql_tweaks_done);
			{
				// If succesfully remove Component_mysql_tweaks add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_mysql_tweaks) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_mysql_tweaks items from the ucm content table
			$component_mysql_tweaks_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_mysql_tweaks') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_mysql_tweaks_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_mysql_tweaks items
			$component_mysql_tweaks_done = $db->execute();
			if ($component_mysql_tweaks_done);
			{
				// If succesfully remove Component_mysql_tweaks add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_mysql_tweaks) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_mysql_tweaks items are cleared from DB
			foreach ($component_mysql_tweaks_ids as $component_mysql_tweaks_id)
			{
				// Remove Component_mysql_tweaks items from the ucm base table
				$component_mysql_tweaks_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_mysql_tweaks_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_mysql_tweaks_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_mysql_tweaks items
				$db->execute();

				// Remove Component_mysql_tweaks items from the ucm history table
				$component_mysql_tweaks_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_mysql_tweaks_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_mysql_tweaks_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_mysql_tweaks items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_custom_admin_menus alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_custom_admin_menus') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_custom_admin_menus_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_custom_admin_menus_found)
		{
			// Since there are load the needed  component_custom_admin_menus type ids
			$component_custom_admin_menus_ids = $db->loadColumn();
			// Remove Component_custom_admin_menus from the content type table
			$component_custom_admin_menus_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_custom_admin_menus') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_custom_admin_menus_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_custom_admin_menus items
			$component_custom_admin_menus_done = $db->execute();
			if ($component_custom_admin_menus_done);
			{
				// If succesfully remove Component_custom_admin_menus add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_custom_admin_menus) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_custom_admin_menus items from the contentitem tag map table
			$component_custom_admin_menus_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_custom_admin_menus') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_custom_admin_menus_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_custom_admin_menus items
			$component_custom_admin_menus_done = $db->execute();
			if ($component_custom_admin_menus_done);
			{
				// If succesfully remove Component_custom_admin_menus add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_custom_admin_menus) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_custom_admin_menus items from the ucm content table
			$component_custom_admin_menus_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_custom_admin_menus') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_custom_admin_menus_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_custom_admin_menus items
			$component_custom_admin_menus_done = $db->execute();
			if ($component_custom_admin_menus_done);
			{
				// If succesfully remove Component_custom_admin_menus add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_custom_admin_menus) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_custom_admin_menus items are cleared from DB
			foreach ($component_custom_admin_menus_ids as $component_custom_admin_menus_id)
			{
				// Remove Component_custom_admin_menus items from the ucm base table
				$component_custom_admin_menus_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_custom_admin_menus_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_custom_admin_menus_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_custom_admin_menus items
				$db->execute();

				// Remove Component_custom_admin_menus items from the ucm history table
				$component_custom_admin_menus_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_custom_admin_menus_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_custom_admin_menus_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_custom_admin_menus items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_config alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_config') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_config_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_config_found)
		{
			// Since there are load the needed  component_config type ids
			$component_config_ids = $db->loadColumn();
			// Remove Component_config from the content type table
			$component_config_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_config') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_config_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_config items
			$component_config_done = $db->execute();
			if ($component_config_done);
			{
				// If succesfully remove Component_config add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_config) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_config items from the contentitem tag map table
			$component_config_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_config') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_config_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_config items
			$component_config_done = $db->execute();
			if ($component_config_done);
			{
				// If succesfully remove Component_config add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_config) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_config items from the ucm content table
			$component_config_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_config') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_config_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_config items
			$component_config_done = $db->execute();
			if ($component_config_done);
			{
				// If succesfully remove Component_config add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_config) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_config items are cleared from DB
			foreach ($component_config_ids as $component_config_id)
			{
				// Remove Component_config items from the ucm base table
				$component_config_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_config_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_config_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_config items
				$db->execute();

				// Remove Component_config items from the ucm history table
				$component_config_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_config_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_config_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_config items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_dashboard alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_dashboard') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_dashboard_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_dashboard_found)
		{
			// Since there are load the needed  component_dashboard type ids
			$component_dashboard_ids = $db->loadColumn();
			// Remove Component_dashboard from the content type table
			$component_dashboard_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_dashboard') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_dashboard_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_dashboard items
			$component_dashboard_done = $db->execute();
			if ($component_dashboard_done);
			{
				// If succesfully remove Component_dashboard add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_dashboard) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_dashboard items from the contentitem tag map table
			$component_dashboard_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_dashboard') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_dashboard_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_dashboard items
			$component_dashboard_done = $db->execute();
			if ($component_dashboard_done);
			{
				// If succesfully remove Component_dashboard add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_dashboard) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_dashboard items from the ucm content table
			$component_dashboard_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_dashboard') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_dashboard_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_dashboard items
			$component_dashboard_done = $db->execute();
			if ($component_dashboard_done);
			{
				// If succesfully remove Component_dashboard add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_dashboard) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_dashboard items are cleared from DB
			foreach ($component_dashboard_ids as $component_dashboard_id)
			{
				// Remove Component_dashboard items from the ucm base table
				$component_dashboard_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_dashboard_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_dashboard_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_dashboard items
				$db->execute();

				// Remove Component_dashboard items from the ucm history table
				$component_dashboard_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_dashboard_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_dashboard_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_dashboard items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Component_files_folders alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_files_folders') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$component_files_folders_found = $db->getNumRows();
		// Now check if there were any rows
		if ($component_files_folders_found)
		{
			// Since there are load the needed  component_files_folders type ids
			$component_files_folders_ids = $db->loadColumn();
			// Remove Component_files_folders from the content type table
			$component_files_folders_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_files_folders') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($component_files_folders_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_files_folders items
			$component_files_folders_done = $db->execute();
			if ($component_files_folders_done);
			{
				// If succesfully remove Component_files_folders add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_files_folders) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Component_files_folders items from the contentitem tag map table
			$component_files_folders_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.component_files_folders') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($component_files_folders_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_files_folders items
			$component_files_folders_done = $db->execute();
			if ($component_files_folders_done);
			{
				// If succesfully remove Component_files_folders add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_files_folders) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Component_files_folders items from the ucm content table
			$component_files_folders_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.component_files_folders') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($component_files_folders_condition);
			$db->setQuery($query);
			// Execute the query to remove Component_files_folders items
			$component_files_folders_done = $db->execute();
			if ($component_files_folders_done);
			{
				// If succesfully remove Component_files_folders add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.component_files_folders) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Component_files_folders items are cleared from DB
			foreach ($component_files_folders_ids as $component_files_folders_id)
			{
				// Remove Component_files_folders items from the ucm base table
				$component_files_folders_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_files_folders_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($component_files_folders_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_files_folders items
				$db->execute();

				// Remove Component_files_folders items from the ucm history table
				$component_files_folders_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $component_files_folders_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($component_files_folders_condition);
				$db->setQuery($query);
				// Execute the query to remove Component_files_folders items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Snippet_type alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.snippet_type') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$snippet_type_found = $db->getNumRows();
		// Now check if there were any rows
		if ($snippet_type_found)
		{
			// Since there are load the needed  snippet_type type ids
			$snippet_type_ids = $db->loadColumn();
			// Remove Snippet_type from the content type table
			$snippet_type_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.snippet_type') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($snippet_type_condition);
			$db->setQuery($query);
			// Execute the query to remove Snippet_type items
			$snippet_type_done = $db->execute();
			if ($snippet_type_done);
			{
				// If succesfully remove Snippet_type add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.snippet_type) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Snippet_type items from the contentitem tag map table
			$snippet_type_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.snippet_type') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($snippet_type_condition);
			$db->setQuery($query);
			// Execute the query to remove Snippet_type items
			$snippet_type_done = $db->execute();
			if ($snippet_type_done);
			{
				// If succesfully remove Snippet_type add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.snippet_type) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Snippet_type items from the ucm content table
			$snippet_type_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.snippet_type') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($snippet_type_condition);
			$db->setQuery($query);
			// Execute the query to remove Snippet_type items
			$snippet_type_done = $db->execute();
			if ($snippet_type_done);
			{
				// If succesfully remove Snippet_type add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.snippet_type) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Snippet_type items are cleared from DB
			foreach ($snippet_type_ids as $snippet_type_id)
			{
				// Remove Snippet_type items from the ucm base table
				$snippet_type_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $snippet_type_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($snippet_type_condition);
				$db->setQuery($query);
				// Execute the query to remove Snippet_type items
				$db->execute();

				// Remove Snippet_type items from the ucm history table
				$snippet_type_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $snippet_type_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($snippet_type_condition);
				$db->setQuery($query);
				// Execute the query to remove Snippet_type items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Library_config alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library_config') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$library_config_found = $db->getNumRows();
		// Now check if there were any rows
		if ($library_config_found)
		{
			// Since there are load the needed  library_config type ids
			$library_config_ids = $db->loadColumn();
			// Remove Library_config from the content type table
			$library_config_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library_config') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($library_config_condition);
			$db->setQuery($query);
			// Execute the query to remove Library_config items
			$library_config_done = $db->execute();
			if ($library_config_done);
			{
				// If succesfully remove Library_config add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library_config) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Library_config items from the contentitem tag map table
			$library_config_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library_config') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($library_config_condition);
			$db->setQuery($query);
			// Execute the query to remove Library_config items
			$library_config_done = $db->execute();
			if ($library_config_done);
			{
				// If succesfully remove Library_config add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library_config) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Library_config items from the ucm content table
			$library_config_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.library_config') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($library_config_condition);
			$db->setQuery($query);
			// Execute the query to remove Library_config items
			$library_config_done = $db->execute();
			if ($library_config_done);
			{
				// If succesfully remove Library_config add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library_config) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Library_config items are cleared from DB
			foreach ($library_config_ids as $library_config_id)
			{
				// Remove Library_config items from the ucm base table
				$library_config_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $library_config_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($library_config_condition);
				$db->setQuery($query);
				// Execute the query to remove Library_config items
				$db->execute();

				// Remove Library_config items from the ucm history table
				$library_config_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $library_config_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($library_config_condition);
				$db->setQuery($query);
				// Execute the query to remove Library_config items
				$db->execute();
			}
		}

		// Create a new query object.
		$query = $db->getQuery(true);
		// Select id from content type table
		$query->select($db->quoteName('type_id'));
		$query->from($db->quoteName('#__content_types'));
		// Where Library_files_folders_urls alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library_files_folders_urls') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$library_files_folders_urls_found = $db->getNumRows();
		// Now check if there were any rows
		if ($library_files_folders_urls_found)
		{
			// Since there are load the needed  library_files_folders_urls type ids
			$library_files_folders_urls_ids = $db->loadColumn();
			// Remove Library_files_folders_urls from the content type table
			$library_files_folders_urls_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library_files_folders_urls') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($library_files_folders_urls_condition);
			$db->setQuery($query);
			// Execute the query to remove Library_files_folders_urls items
			$library_files_folders_urls_done = $db->execute();
			if ($library_files_folders_urls_done);
			{
				// If succesfully remove Library_files_folders_urls add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library_files_folders_urls) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Library_files_folders_urls items from the contentitem tag map table
			$library_files_folders_urls_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.library_files_folders_urls') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($library_files_folders_urls_condition);
			$db->setQuery($query);
			// Execute the query to remove Library_files_folders_urls items
			$library_files_folders_urls_done = $db->execute();
			if ($library_files_folders_urls_done);
			{
				// If succesfully remove Library_files_folders_urls add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library_files_folders_urls) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Library_files_folders_urls items from the ucm content table
			$library_files_folders_urls_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.library_files_folders_urls') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($library_files_folders_urls_condition);
			$db->setQuery($query);
			// Execute the query to remove Library_files_folders_urls items
			$library_files_folders_urls_done = $db->execute();
			if ($library_files_folders_urls_done);
			{
				// If succesfully remove Library_files_folders_urls add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.library_files_folders_urls) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Library_files_folders_urls items are cleared from DB
			foreach ($library_files_folders_urls_ids as $library_files_folders_urls_id)
			{
				// Remove Library_files_folders_urls items from the ucm base table
				$library_files_folders_urls_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $library_files_folders_urls_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($library_files_folders_urls_condition);
				$db->setQuery($query);
				// Execute the query to remove Library_files_folders_urls items
				$db->execute();

				// Remove Library_files_folders_urls items from the ucm history table
				$library_files_folders_urls_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $library_files_folders_urls_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($library_files_folders_urls_condition);
				$db->setQuery($query);
				// Execute the query to remove Library_files_folders_urls items
				$db->execute();
			}
		}

		// If All related items was removed queued success message.
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_base</b> table'));
		$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_history</b> table'));

		// Remove componentbuilder assets from the assets table
		$componentbuilder_condition = array( $db->quoteName('name') . ' LIKE ' . $db->quote('com_componentbuilder%') );

		// Create a new query object.
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__assets'));
		$query->where($componentbuilder_condition);
		$db->setQuery($query);
		$library_files_folders_urls_done = $db->execute();
		if ($library_files_folders_urls_done);
		{
			// If succesfully remove componentbuilder add queued success message.
			$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));
		}

		// little notice as after service, in case of bad experience with component.
		echo '<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:llewellyn@joomlacomponentbuilder.com">llewellyn@joomlacomponentbuilder.com</a>.
		<br />We at Vast Development Method are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="http://joomlacomponentbuilder.com" target="_blank">http://joomlacomponentbuilder.com</a> today!</p>';
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent)
	{
		
	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// is redundant ...hmmm
		if ($type == 'uninstall')
		{
			return true;
		}
		// the default for both install and update
		$jversion = new JVersion();
		if (!$jversion->isCompatible('3.6.0'))
		{
			$app->enqueueMessage('Please upgrade to at least Joomla! 3.6.0 before continuing!', 'error');
			return false;
		}
		// do any updates needed
		if ($type == 'update')
		{
			// load the helper class
			JLoader::register('ComponentbuilderHelper', JPATH_ADMINISTRATOR . '/components/com_componentbuilder/helpers/componentbuilder.php');
			// check the version of JCB
			$manifest = ComponentbuilderHelper::manifest();
			if (isset($manifest->version) && strpos($manifest->version, '.') !== false)
			{
				// get the version
				$this->JCBversion = explode('.', $manifest->version);
				// Get a db connection.
				$db = JFactory::getDbo();

				// target version less then 2.5.2
				if (count($this->JCBversion) == 3 && $this->JCBversion[0] <= 2 && $this->JCBversion[1] <= 5 && (($this->JCBversion[1] == 5 && $this->JCBversion[2] <= 1) || ($this->JCBversion[1] < 5)))
				{
					// the set values
					$this->setFtpValues = array();
					// Create a new query object.
					$query = $db->getQuery(true);
					// get all Joomla Component FTP values
					$query->select($db->quoteName(array('id', 'sales_server_ftp', 'update_server_ftp')));
					$query->from($db->quoteName('#__componentbuilder_joomla_component'));
					// Reset the query using our newly populated query object.
					$db->setQuery($query);
					$db->execute();
					if ($db->getNumRows())
					{
						$rows = $db->loadObjectList();
						// Get the basic encryption.
						$basickey = ComponentbuilderHelper::getCryptKey('basic');
						// Get the encryption object.
						$basic = new FOFEncryptAes($basickey, 128);
						foreach ($rows as $row)
						{
							if (ComponentbuilderHelper::checkString($row->sales_server_ftp) || ComponentbuilderHelper::checkString($row->update_server_ftp))
							{
								$updatevalue = null;
								// update the update_server_ftp
								if (ComponentbuilderHelper::checkString($row->update_server_ftp) && !is_numeric($row->update_server_ftp) && $basickey && $row->update_server_ftp === base64_encode(base64_decode($row->update_server_ftp, true)))
								{
									$updatevalue = rtrim($basic->decryptString($row->update_server_ftp), "\0");
								}
								elseif (ComponentbuilderHelper::checkString($row->update_server_ftp))
								{
									$updatevalue = $row->update_server_ftp;
								}
								$salesvalue = null;
								// update the sales_server_ftp
								if (ComponentbuilderHelper::checkString($row->sales_server_ftp) && !is_numeric($row->sales_server_ftp) && $basickey && $row->sales_server_ftp === base64_encode(base64_decode($row->sales_server_ftp, true)))
								{
									$salesvalue = rtrim($basic->decryptString($row->sales_server_ftp), "\0");
								}
								elseif (ComponentbuilderHelper::checkString($row->sales_server_ftp))
								{
									$salesvalue = $row->sales_server_ftp;
								}
								// set update Values
								if ($updatevalue)
								{
									$hash = md5($updatevalue) . '__update_server_ftp';
									if (!isset($this->setFtpValues[$hash]))
									{
										$this->setFtpValues[$hash] = array();
										$this->setFtpValues[$hash]['ids'] = array();
										$this->setFtpValues[$hash]['ftp'] = $updatevalue;
										$this->setFtpValues[$hash]['signature'] = $row->update_server_ftp;
									}
									$this->setFtpValues[$hash]['ids'][] = $row->id;
								}
								// set sales Values
								if ($salesvalue)
								{
									$hash = md5($salesvalue) . '__sales_server_ftp';
									if (!isset($this->setFtpValues[$hash]))
									{
										$this->setFtpValues[$hash] = array();
										$this->setFtpValues[$hash]['ids'] = array();
										$this->setFtpValues[$hash]['ftp'] = $salesvalue;
										$this->setFtpValues[$hash]['signature'] = $row->sales_server_ftp;
									}
									$this->setFtpValues[$hash]['ids'][] = $row->id;
								}
							}
						}
					}
				}
				/*
				 * Convert repeatable fields in a table
				 * 
				 * @param   string   $table    The table where the fields are updated
				 * @param   array    $select   The fields +id that should be updated
				 * @param   array    $convert  The array options used to convert the fields
				 *                             check => the array of values in the repeatable field that must exist
				 *                             key   => the name of the field
				 *
				 * @return  void
				 */
				$convertRepeatable = function($db, $table, $select, $convert)
				{
					// update the properties in the field types
					$query = $db->getQuery(true);
					// update all JCB fieldtype properties
					$query->select($db->quoteName($select));
					$query->from($db->quoteName('#__componentbuilder_' . $table));
					// Reset the query using our newly populated query object.
					$db->setQuery($query);
					$db->execute();
					if ($db->getNumRows())
					{
						$rows = $db->loadObjectList();
						foreach ($rows as $row)
						{
							$update = false;
							foreach ($convert as $target => $field)
							{
								// check if it has needed values (it should but just in case)
								$continue = false;
								if (isset($row->{$target}) && ComponentbuilderHelper::checkJson($row->{$target}))
								{
									// open the target and convert
									$jsonArray = json_decode($row->{$target}, true);
									// test if we can do conversion
									$continue = true;
									if (ComponentbuilderHelper::checkArray($jsonArray))
									{
										foreach($field['check'] as $check)
										{
											if (!isset($jsonArray[$check]) || !ComponentbuilderHelper::checkArray($jsonArray[$check]))
											{
												$continue = false;
											}
											// if found but not an array, then clear out the target
											if (isset($jsonArray[$check]) && !ComponentbuilderHelper::checkArray($jsonArray[$check]))
											{
												$row->{$target} = '';
												$update = true;
											}
										}
									}
									else
									{
										$row->{$target} = '';
										$update = true;
									}
								}
								// do the conversion
								if ($continue)
								{
									$bucket = array();
									foreach ($jsonArray as $key => $values)
									{
										foreach ($values as $nr => $value)
										{
											if (!isset($bucket[$field['key'] . $nr]) || !ComponentbuilderHelper::checkArray($bucket[$field['key'] . $nr]))
											{
												$bucket[$field['key'] . $nr] = array();
											}
											$bucket[$field['key'] . $nr][$key] = $value;
										}
									}
									// set the bucket back to properties
									$row->{$target} = json_encode($bucket);
									$update = true;
								}
							}
							// update with the new values
							if ($update)
							{
								$db->updateObject('#__componentbuilder_' . $table, $row, 'id');
							}
						}
					}
				};
				// target version less then 2.5.5 (we need to change the language translation values & the fieldtype properties)
				if (count($this->JCBversion) == 3 && $this->JCBversion[0] <= 2 && $this->JCBversion[1] <= 5 && (($this->JCBversion[1] == 5 && $this->JCBversion[2] <= 4) || ($this->JCBversion[1] < 5)))
				{
					// do some conversions in the translations table
					$convertRepeatable($db, 'language_translation', array('id', 'translation'), array('translation' => array('check' => array('translation'), 'key' => 'translation')));
					// do some conversions in the fieldtype table
					$convertRepeatable($db, 'fieldtype', array('id', 'properties'), array('properties' => array('check' => array('name'), 'key' => 'properties')));
				}
				// target version less then 2.5.6
				if (count($this->JCBversion) == 3 && $this->JCBversion[0] <= 2 && $this->JCBversion[1] <= 5 && (($this->JCBversion[1] == 5 && $this->JCBversion[2] <= 5) || ($this->JCBversion[1] < 5)))
				{
					// do some conversions in the dynamic get table
					$convertRepeatable($db, 'dynamic_get', array('id', 'join_view_table', 'join_db_table', 'filter', 'where', 'order', 'global'),
						array(
							'join_view_table' => array('check' => array('view_table'), 'key' => 'join_view_table'),
							'join_db_table' => array('check' => array('db_table'), 'key' => 'join_db_table'),
							'filter' => array('check' => array('filter_type'), 'key' => 'filter'),
							'where' => array('check' => array('table_key'), 'key' => 'where'),
							'order' => array('check' => array('table_key'), 'key' => 'order'),
							'global' => array('check' => array('name'), 'key' => 'global')
						)
					);
				}
				// get table columns to confirm that this is an old installation
				$activeColumns = $db->getTableColumns('#__componentbuilder_admin_view');
				// target version less then 2.5.7
				if (isset($activeColumns['addfields']) && (count($this->JCBversion) == 3 && $this->JCBversion[0] <= 2 && $this->JCBversion[1] <= 5 && (($this->JCBversion[1] == 5 && $this->JCBversion[2] <= 6) || ($this->JCBversion[1] < 5))))
				{
					// do some conversions in the admin_view table
					$convertRepeatable($db, 'admin_view', array('id', 'ajax_input', 'custom_button', 'addtables', 'addlinked_views', 'addconditions', 'addfields', 'addtabs', 'addpermissions'),
						array(
							'ajax_input' => array('check' => array('value_name'), 'key' => 'ajax_input'),
							'custom_button' => array('check' => array('name'), 'key' => 'custom_button'),
							'addtables' =>  array('check' => array('table'), 'key' => 'addtables'),
							'addlinked_views' =>  array('check' => array('adminview'), 'key' => 'addlinked_views'),
							'addconditions' =>  array('check' => array('target_field'), 'key' => 'addconditions'),
							'addfields' =>  array('check' => array('field'), 'key' => 'addfields'),
							'addtabs' =>  array('check' => array('name'), 'key' => 'addtabs'),
							'addpermissions' =>  array('check' => array('action'), 'key' => 'addpermissions')
						)
					);

					// do some conversions in the site_view table
					$convertRepeatable($db, 'site_view', array('id', 'ajax_input', 'custom_button'),
						array(
							'ajax_input' => array('check' => array('value_name'), 'key' => 'ajax_input'),
							'custom_button' => array('check' => array('name'), 'key' => 'custom_button')
						)
					);

					// do some conversions in the custom_admin_view table
					$convertRepeatable($db, 'custom_admin_view', array('id', 'custom_button'),
						array(
							'custom_button' => array('check' => array('name'), 'key' => 'custom_button')
						)
					);
				}
				// the set move values
				$this->setMoveValues = array();
				// get table columns to confirm that this is an old installation
				$activeColumns = $db->getTableColumns('#__componentbuilder_joomla_component');
				// target version less then 2.6.0
				if (isset($activeColumns['addadmin_views']) && (count($this->JCBversion) == 3 && $this->JCBversion[0] <= 2 && $this->JCBversion[1] <= 5 && (($this->JCBversion[1] == 5 && $this->JCBversion[2] <= 9) || ($this->JCBversion[1] < 6))))
				{
					// do some conversions in the admin_view table
					$convertRepeatable($db, 'joomla_component', array('id', 'addadmin_views', 'addconfig', 'addcontributors', 'addcustom_admin_views', 'addcustommenus', 'addfiles', 'addfolders', 'addsite_views', 'dashboard_tab', 'sql_tweak', 'version_update'),
						array(
							'addadmin_views' => array('check' => array('adminview'), 'key' => 'addadmin_views'),
							'addconfig' => array('check' => array('field'), 'key' => 'addconfig'),
							'addcontributors' => array('check' => array('name'), 'key' => 'addcontributors'),
							'addcustom_admin_views' => array('check' => array('customadminview'), 'key' => 'addcustom_admin_views'),
							'addcustommenus' => array('check' => array('name'), 'key' => 'addcustommenus'),
							'addfiles' => array('check' => array('file'), 'key' => 'addfiles'),
							'addfolders' => array('check' => array('folder'), 'key' => 'addfolders'),
							'addsite_views' => array('check' => array('siteview'), 'key' => 'addsite_views'),
							'dashboard_tab' => array('check' => array('name'), 'key' => 'dashboard_tab'),
							'sql_tweak' => array('check' => array('adminview'), 'key' => 'sql_tweak'),
							'version_update' => array('check' => array('version'), 'key' => 'version_update')
						)
					);
					// move values to their own tables
					$tables = array(
						'admin_fields' => array('id' => 'admin_view', 'addfields' => 'addfields'),
						'admin_fields_conditions' => array('id' => 'admin_view', 'addconditions' => 'addconditions'),
						'component_admin_views' => array('id' => 'joomla_component', 'addadmin_views' => 'addadmin_views'),
						'component_site_views' => array('id' => 'joomla_component', 'addsite_views' => 'addsite_views'),
						'component_custom_admin_views' => array('id' => 'joomla_component', 'addcustom_admin_views' => 'addcustom_admin_views'),
						'component_updates' => array('id' => 'joomla_component', 'version_update' => 'version_update'),
						'component_mysql_tweaks' => array('id' => 'joomla_component', 'sql_tweak' => 'sql_tweak'),
						'component_custom_admin_menus' => array('id' => 'joomla_component', 'addcustommenus' => 'addcustommenus'),
						'component_config' => array('id' => 'joomla_component', 'addconfig' => 'addconfig'),
						'component_dashboard' => array('id' => 'joomla_component', 'dashboard_tab' => 'dashboard_tab', 'php_dashboard_methods' => 'php_dashboard_methods'),
						'component_files_folders' => array('id' => 'joomla_component', 'addfiles' => 'addfiles', 'addfolders' => 'addfolders')
					);
					$this->dynamicTable = array(
						'admin_fields' => 'admin_view',
						'admin_fields_conditions' => 'admin_view',
						'component_admin_views' => 'joomla_component',
						'component_site_views' => 'joomla_component',
						'component_custom_admin_views' => 'joomla_component',
						'component_updates' => 'joomla_component',
						'component_mysql_tweaks' => 'joomla_component',
						'component_custom_admin_menus' => 'joomla_component',
						'component_config' => 'joomla_component',
						'component_dashboard' => 'joomla_component',
						'component_files_folders' => 'joomla_component');
					foreach ($tables as $move => $array)
					{
						// we must first check if the fields are still there
						$columns = $db->getTableColumns('#__componentbuilder_'.$this->dynamicTable[$move]);
						foreach ($array as $column => $as)
						{
							if (!isset($columns[$column]))
							{
								// remove this column since it is no longer found
								unset($array[$column]);
							}
						}
						// do we still need to move any
						if (ComponentbuilderHelper::checkArray($array))
						{
							// move all diverged data
							$query = $db->getQuery(true);
							// update all JCB fieldtype properties
							$query->select($db->quoteName(array_keys($array),array_values($array)));
							$query->from($db->quoteName('#__componentbuilder_'.$this->dynamicTable[$move]));
							// Reset the query using our newly populated query object.
							$db->setQuery($query);
							$db->execute();
							if ($db->getNumRows())
							{
								$this->setMoveValues[$move] = $db->loadObjectList();
							}
						}
					}
				}
			}
		}
		// do any install needed
		if ($type == 'install')
		{
		}
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent)
	{
		// get application
		$app = JFactory::getApplication();
		// We check if we have dynamic folders to copy
		$this->setDynamicF0ld3rs($app, $parent);
		// set the default component settings
		if ($type == 'install')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the joomla_component content type object.
			$joomla_component = new stdClass();
			$joomla_component->type_title = 'Componentbuilder Joomla_component';
			$joomla_component->type_alias = 'com_componentbuilder.joomla_component';
			$joomla_component->table = '{"special": {"dbtable": "#__componentbuilder_joomla_component","key": "id","type": "Joomla_component","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$joomla_component->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "readme","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","component_version":"component_version","short_description":"short_description","companyname":"companyname","author":"author","php_postflight_update":"php_postflight_update","php_preflight_update":"php_preflight_update","javascript":"javascript","css_site":"css_site","debug_linenr":"debug_linenr","add_email_helper":"add_email_helper","copyright":"copyright","add_placeholders":"add_placeholders","description":"description","mvc_versiondate":"mvc_versiondate","sql":"sql","php_helper_admin":"php_helper_admin","add_update_server":"add_update_server","php_helper_site":"php_helper_site","sales_server":"sales_server","adduikit":"adduikit","email":"email","php_helper_both":"php_helper_both","website":"website","php_admin_event":"php_admin_event","add_license":"add_license","php_site_event":"php_site_event","license_type":"license_type","css_admin":"css_admin","whmcs_key":"whmcs_key","php_preflight_install":"php_preflight_install","whmcs_url":"whmcs_url","php_postflight_install":"php_postflight_install","license":"license","php_method_uninstall":"php_method_uninstall","bom":"bom","readme":"readme","image":"image","update_server_target":"update_server_target","not_required":"not_required","update_server":"update_server","buildcomp":"buildcomp","creatuserhelper":"creatuserhelper","addfootable":"addfootable","add_php_helper_both":"add_php_helper_both","add_php_helper_admin":"add_php_helper_admin","add_admin_event":"add_admin_event","add_php_helper_site":"add_php_helper_site","add_site_event":"add_site_event","add_javascript":"add_javascript","add_css_admin":"add_css_admin","toignore":"toignore","add_css_site":"add_css_site","dashboard_type":"dashboard_type","dashboard":"dashboard","export_key":"export_key","add_php_preflight_install":"add_php_preflight_install","export_package_link":"export_package_link","add_php_preflight_update":"add_php_preflight_update","export_buy_link":"export_buy_link","add_php_postflight_install":"add_php_postflight_install","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","add_sql":"add_sql","emptycontributors":"emptycontributors","addreadme":"addreadme","number":"number","update_server_url":"update_server_url","add_sales_server":"add_sales_server","buildcompsql":"buildcompsql","name":"name"}}';
			$joomla_component->router = 'ComponentbuilderHelperRoute::getJoomla_componentRoute';
			$joomla_component->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","debug_linenr","add_email_helper","add_placeholders","mvc_versiondate","add_update_server","sales_server","adduikit","add_license","license_type","update_server_target","not_required","update_server","buildcomp","creatuserhelper","addfootable","add_php_helper_both","add_php_helper_admin","add_admin_event","add_php_helper_site","add_site_event","add_javascript","add_css_admin","add_css_site","dashboard_type","add_php_preflight_install","add_php_preflight_update","add_php_postflight_install","add_php_postflight_update","add_php_method_uninstall","add_sql","emptycontributors","addreadme","number","add_sales_server"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dashboard","targetTable": "#__componentbuilder_custom_admin_view","targetColumn": "","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$joomla_component_Inserted = $db->insertObject('#__content_types', $joomla_component);

			// Create the admin_view content type object.
			$admin_view = new stdClass();
			$admin_view->type_title = 'Componentbuilder Admin_view';
			$admin_view->type_alias = 'com_componentbuilder.admin_view';
			$admin_view->table = '{"special": {"dbtable": "#__componentbuilder_admin_view","key": "id","type": "Admin_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","name_list":"name_list","short_description":"short_description","add_php_batchmove":"add_php_batchmove","add_php_allowedit":"add_php_allowedit","add_php_save":"add_php_save","add_php_getlistquery":"add_php_getlistquery","icon_add":"icon_add","html_import_view":"html_import_view","add_sql":"add_sql","type":"type","add_fadein":"add_fadein","description":"description","icon_category":"icon_category","add_php_after_publish":"add_php_after_publish","not_required":"not_required","add_php_after_delete":"add_php_after_delete","php_import_save":"php_import_save","add_php_getitems_after_all":"add_php_getitems_after_all","add_php_before_save":"add_php_before_save","add_php_postsavehook":"add_php_postsavehook","add_php_batchcopy":"add_php_batchcopy","add_php_before_publish":"add_php_before_publish","alias_builder_type":"alias_builder_type","add_php_before_delete":"add_php_before_delete","add_php_document":"add_php_document","alias_builder":"alias_builder","add_custom_import":"add_custom_import","add_php_getitem":"add_php_getitem","php_import_headers":"php_import_headers","add_php_getitems":"add_php_getitems","icon":"icon","php_getitem":"php_getitem","php_getitems":"php_getitems","add_css_view":"add_css_view","php_getitems_after_all":"php_getitems_after_all","css_view":"css_view","php_getlistquery":"php_getlistquery","add_css_views":"add_css_views","php_before_save":"php_before_save","css_views":"css_views","php_save":"php_save","add_javascript_view_file":"add_javascript_view_file","php_postsavehook":"php_postsavehook","javascript_view_file":"javascript_view_file","php_allowedit":"php_allowedit","add_javascript_view_footer":"add_javascript_view_footer","php_batchcopy":"php_batchcopy","javascript_view_footer":"javascript_view_footer","php_batchmove":"php_batchmove","add_javascript_views_file":"add_javascript_views_file","php_before_publish":"php_before_publish","javascript_views_file":"javascript_views_file","php_after_publish":"php_after_publish","add_javascript_views_footer":"add_javascript_views_footer","php_before_delete":"php_before_delete","javascript_views_footer":"javascript_views_footer","php_after_delete":"php_after_delete","add_custom_button":"add_custom_button","php_document":"php_document","source":"source","php_controller":"php_controller","sql":"sql","php_model":"php_model","php_controller_list":"php_controller_list","php_import_display":"php_import_display","php_model_list":"php_model_list","php_import":"php_import","add_php_ajax":"add_php_ajax","php_import_setdata":"php_import_setdata","php_ajaxmethod":"php_ajaxmethod","php_import_ext":"php_import_ext"}}';
			$admin_view->router = 'ComponentbuilderHelperRoute::getAdmin_viewRoute';
			$admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_php_batchmove","add_php_allowedit","add_php_save","add_php_getlistquery","add_sql","type","add_fadein","add_php_after_publish","add_php_after_delete","add_php_getitems_after_all","add_php_before_save","add_php_postsavehook","add_php_batchcopy","add_php_before_publish","add_php_before_delete","add_php_document","add_custom_import","add_php_getitem","add_php_getitems","add_css_view","add_css_views","add_javascript_view_file","add_javascript_view_footer","add_javascript_views_file","add_javascript_views_footer","add_custom_button","source","add_php_ajax"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "alias_builder","targetTable": "#__componentbuilder_field","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$admin_view_Inserted = $db->insertObject('#__content_types', $admin_view);

			// Create the custom_admin_view content type object.
			$custom_admin_view = new stdClass();
			$custom_admin_view->type_title = 'Componentbuilder Custom_admin_view';
			$custom_admin_view->type_alias = 'com_componentbuilder.custom_admin_view';
			$custom_admin_view->table = '{"special": {"dbtable": "#__componentbuilder_custom_admin_view","key": "id","type": "Custom_admin_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$custom_admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","php_jview_display":"php_jview_display","php_view":"php_view","php_document":"php_document","add_php_ajax":"add_php_ajax","add_css":"add_css","add_js_document":"add_js_document","default":"default","icon":"icon","php_jview":"php_jview","add_javascript_file":"add_javascript_file","libraries":"libraries","js_document":"js_document","add_css_document":"add_css_document","javascript_file":"javascript_file","not_required":"not_required","css_document":"css_document","custom_get":"custom_get","css":"css","main_get":"main_get","php_ajaxmethod":"php_ajaxmethod","dynamic_get":"dynamic_get","add_php_document":"add_php_document","add_php_view":"add_php_view","add_custom_button":"add_custom_button","add_php_jview_display":"add_php_jview_display","add_php_jview":"add_php_jview","php_controller":"php_controller","php_model":"php_model"}}';
			$custom_admin_view->router = 'ComponentbuilderHelperRoute::getCustom_admin_viewRoute';
			$custom_admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/custom_admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_ajax","add_css","add_js_document","add_javascript_file","add_css_document","not_required","main_get","dynamic_get","add_php_document","add_php_view","add_custom_button","add_php_jview_display","add_php_jview"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$custom_admin_view_Inserted = $db->insertObject('#__content_types', $custom_admin_view);

			// Create the site_view content type object.
			$site_view = new stdClass();
			$site_view->type_title = 'Componentbuilder Site_view';
			$site_view->type_alias = 'com_componentbuilder.site_view';
			$site_view->table = '{"special": {"dbtable": "#__componentbuilder_site_view","key": "id","type": "Site_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$site_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","php_document":"php_document","add_php_ajax":"add_php_ajax","add_css":"add_css","add_css_document":"add_css_document","libraries":"libraries","php_jview":"php_jview","default":"default","php_view":"php_view","add_javascript_file":"add_javascript_file","php_jview_display":"php_jview_display","add_js_document":"add_js_document","not_required":"not_required","javascript_file":"javascript_file","custom_get":"custom_get","js_document":"js_document","main_get":"main_get","css_document":"css_document","dynamic_get":"dynamic_get","css":"css","php_ajaxmethod":"php_ajaxmethod","add_custom_button":"add_custom_button","add_php_document":"add_php_document","button_position":"button_position","add_php_view":"add_php_view","add_php_jview_display":"add_php_jview_display","add_php_jview":"add_php_jview","php_controller":"php_controller","php_model":"php_model"}}';
			$site_view->router = 'ComponentbuilderHelperRoute::getSite_viewRoute';
			$site_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/site_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_ajax","add_css","add_css_document","add_javascript_file","add_js_document","not_required","main_get","dynamic_get","add_custom_button","add_php_document","button_position","add_php_view","add_php_jview_display","add_php_jview"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$site_view_Inserted = $db->insertObject('#__content_types', $site_view);

			// Create the template content type object.
			$template = new stdClass();
			$template->type_title = 'Componentbuilder Template';
			$template->type_alias = 'com_componentbuilder.template';
			$template->table = '{"special": {"dbtable": "#__componentbuilder_template","key": "id","type": "Template","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$template->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","snippet":"snippet","php_view":"php_view","add_php_view":"add_php_view","dynamic_get":"dynamic_get","not_required":"not_required","template":"template","libraries":"libraries"}}';
			$template->router = 'ComponentbuilderHelperRoute::getTemplateRoute';
			$template->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/template.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_view","dynamic_get","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$template_Inserted = $db->insertObject('#__content_types', $template);

			// Create the layout content type object.
			$layout = new stdClass();
			$layout->type_title = 'Componentbuilder Layout';
			$layout->type_alias = 'com_componentbuilder.layout';
			$layout->table = '{"special": {"dbtable": "#__componentbuilder_layout","key": "id","type": "Layout","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$layout->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","php_view":"php_view","add_php_view":"add_php_view","not_required":"not_required","layout":"layout","libraries":"libraries"}}';
			$layout->router = 'ComponentbuilderHelperRoute::getLayoutRoute';
			$layout->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/layout.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","dynamic_get","snippet","add_php_view","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$layout_Inserted = $db->insertObject('#__content_types', $layout);

			// Create the dynamic_get content type object.
			$dynamic_get = new stdClass();
			$dynamic_get->type_title = 'Componentbuilder Dynamic_get';
			$dynamic_get->type_alias = 'com_componentbuilder.dynamic_get';
			$dynamic_get->table = '{"special": {"dbtable": "#__componentbuilder_dynamic_get","key": "id","type": "Dynamic_get","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$dynamic_get->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","addcalculation":"addcalculation","add_php_router_parse":"add_php_router_parse","add_php_after_getitems":"add_php_after_getitems","add_php_before_getitems":"add_php_before_getitems","add_php_getlistquery":"add_php_getlistquery","add_php_after_getitem":"add_php_after_getitem","add_php_before_getitem":"add_php_before_getitem","php_custom_get":"php_custom_get","db_selection":"db_selection","db_table_main":"db_table_main","view_selection":"view_selection","view_table_main":"view_table_main","getcustom":"getcustom","php_before_getitem":"php_before_getitem","pagination":"pagination","php_after_getitem":"php_after_getitem","not_required":"not_required","php_getlistquery":"php_getlistquery","php_before_getitems":"php_before_getitems","php_after_getitems":"php_after_getitems","php_router_parse":"php_router_parse","php_calculation":"php_calculation"}}';
			$dynamic_get->router = 'ComponentbuilderHelperRoute::getDynamic_getRoute';
			$dynamic_get->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","main_source","gettype","add_php_router_parse","add_php_after_getitems","add_php_before_getitems","add_php_getlistquery","add_php_after_getitem","add_php_before_getitem","view_table_main","pagination","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$dynamic_get_Inserted = $db->insertObject('#__content_types', $dynamic_get);

			// Create the custom_code content type object.
			$custom_code = new stdClass();
			$custom_code->type_title = 'Componentbuilder Custom_code';
			$custom_code->type_alias = 'com_componentbuilder.custom_code';
			$custom_code->table = '{"special": {"dbtable": "#__componentbuilder_custom_code","key": "id","type": "Custom_code","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$custom_code->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","not_required":"not_required","function_name":"function_name","system_name":"system_name","code":"code","hashendtarget":"hashendtarget","to_line":"to_line","from_line":"from_line","hashtarget":"hashtarget"}}';
			$custom_code->router = 'ComponentbuilderHelperRoute::getCustom_codeRoute';
			$custom_code->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/custom_code.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","component","target","type","comment_type","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$custom_code_Inserted = $db->insertObject('#__content_types', $custom_code);

			// Create the library content type object.
			$library = new stdClass();
			$library->type_title = 'Componentbuilder Library';
			$library->type_alias = 'com_componentbuilder.library';
			$library->table = '{"special": {"dbtable": "#__componentbuilder_library","key": "id","type": "Library","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$library->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","how":"how","type":"type","not_required":"not_required","libraries":"libraries","php_setdocument":"php_setdocument"}}';
			$library->router = 'ComponentbuilderHelperRoute::getLibraryRoute';
			$library->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/library.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","how","type","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$library_Inserted = $db->insertObject('#__content_types', $library);

			// Create the snippet content type object.
			$snippet = new stdClass();
			$snippet->type_title = 'Componentbuilder Snippet';
			$snippet->type_alias = 'com_componentbuilder.snippet';
			$snippet->table = '{"special": {"dbtable": "#__componentbuilder_snippet","key": "id","type": "Snippet","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$snippet->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","url":"url","type":"type","heading":"heading","library":"library","contributor_email":"contributor_email","contributor_name":"contributor_name","contributor_website":"contributor_website","contributor_company":"contributor_company","snippet":"snippet","usage":"usage","description":"description"}}';
			$snippet->router = 'ComponentbuilderHelperRoute::getSnippetRoute';
			$snippet->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/snippet.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "type","targetTable": "#__componentbuilder_snippet_type","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$snippet_Inserted = $db->insertObject('#__content_types', $snippet);

			// Create the validation_rule content type object.
			$validation_rule = new stdClass();
			$validation_rule->type_title = 'Componentbuilder Validation_rule';
			$validation_rule->type_alias = 'com_componentbuilder.validation_rule';
			$validation_rule->table = '{"special": {"dbtable": "#__componentbuilder_validation_rule","key": "id","type": "Validation_rule","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$validation_rule->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","short_description":"short_description","inherit":"inherit","php":"php"}}';
			$validation_rule->router = 'ComponentbuilderHelperRoute::getValidation_ruleRoute';
			$validation_rule->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/validation_rule.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "inherit","targetTable": "#__componentbuilder_validation_rule","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$validation_rule_Inserted = $db->insertObject('#__content_types', $validation_rule);

			// Create the field content type object.
			$field = new stdClass();
			$field->type_title = 'Componentbuilder Field';
			$field->type_alias = 'com_componentbuilder.field';
			$field->table = '{"special": {"dbtable": "#__componentbuilder_field","key": "id","type": "Field","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$field->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","store":"store","css_views":"css_views","add_css_views":"add_css_views","css_view":"css_view","add_css_view":"add_css_view","datalenght":"datalenght","add_javascript_views_footer":"add_javascript_views_footer","datadefault_other":"datadefault_other","datadefault":"datadefault","datalenght_other":"datalenght_other","add_javascript_view_footer":"add_javascript_view_footer","javascript_view_footer":"javascript_view_footer","javascript_views_footer":"javascript_views_footer","not_required":"not_required","xml":"xml"}}';
			$field->router = 'ComponentbuilderHelperRoute::getFieldRoute';
			$field->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required","xml"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","fieldtype","store","catid","add_css_views","add_css_view","add_javascript_views_footer","add_javascript_view_footer"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$field_Inserted = $db->insertObject('#__content_types', $field);

			// Create the field category content type object.
			$field_category = new stdClass();
			$field_category->type_title = 'Componentbuilder Field Catid';
			$field_category->type_alias = 'com_componentbuilder.fields.category';
			$field_category->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$field_category->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$field_category->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$field_category->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Set the object into the content types table.
			$field_category_Inserted = $db->insertObject('#__content_types', $field_category);

			// Create the fieldtype content type object.
			$fieldtype = new stdClass();
			$fieldtype->type_title = 'Componentbuilder Fieldtype';
			$fieldtype->type_alias = 'com_componentbuilder.fieldtype';
			$fieldtype->table = '{"special": {"dbtable": "#__componentbuilder_fieldtype","key": "id","type": "Fieldtype","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$fieldtype->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","short_description":"short_description"}}';
			$fieldtype->router = 'ComponentbuilderHelperRoute::getFieldtypeRoute';
			$fieldtype->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/fieldtype.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","catid"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$fieldtype_Inserted = $db->insertObject('#__content_types', $fieldtype);

			// Create the fieldtype category content type object.
			$fieldtype_category = new stdClass();
			$fieldtype_category->type_title = 'Componentbuilder Fieldtype Catid';
			$fieldtype_category->type_alias = 'com_componentbuilder.fieldtypes.category';
			$fieldtype_category->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$fieldtype_category->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$fieldtype_category->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$fieldtype_category->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Set the object into the content types table.
			$fieldtype_category_Inserted = $db->insertObject('#__content_types', $fieldtype_category);

			// Create the language_translation content type object.
			$language_translation = new stdClass();
			$language_translation->type_title = 'Componentbuilder Language_translation';
			$language_translation->type_alias = 'com_componentbuilder.language_translation';
			$language_translation->table = '{"special": {"dbtable": "#__componentbuilder_language_translation","key": "id","type": "Language_translation","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$language_translation->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "source","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"source":"source","components":"components"}}';
			$language_translation->router = 'ComponentbuilderHelperRoute::getLanguage_translationRoute';
			$language_translation->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/language_translation.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "components","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$language_translation_Inserted = $db->insertObject('#__content_types', $language_translation);

			// Create the language content type object.
			$language = new stdClass();
			$language->type_title = 'Componentbuilder Language';
			$language->type_alias = 'com_componentbuilder.language';
			$language->table = '{"special": {"dbtable": "#__componentbuilder_language","key": "id","type": "Language","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$language->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","langtag":"langtag"}}';
			$language->router = 'ComponentbuilderHelperRoute::getLanguageRoute';
			$language->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/language.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$language_Inserted = $db->insertObject('#__content_types', $language);

			// Create the server content type object.
			$server = new stdClass();
			$server->type_title = 'Componentbuilder Server';
			$server->type_alias = 'com_componentbuilder.server';
			$server->table = '{"special": {"dbtable": "#__componentbuilder_server","key": "id","type": "Server","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$server->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","protocol":"protocol","not_required":"not_required","signature":"signature","private_key":"private_key","secret":"secret","password":"password","private":"private","authentication":"authentication","path":"path","port":"port","host":"host","username":"username"}}';
			$server->router = 'ComponentbuilderHelperRoute::getServerRoute';
			$server->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/server.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","protocol","not_required","authentication"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$server_Inserted = $db->insertObject('#__content_types', $server);

			// Create the help_document content type object.
			$help_document = new stdClass();
			$help_document->type_title = 'Componentbuilder Help_document';
			$help_document->type_alias = 'com_componentbuilder.help_document';
			$help_document->table = '{"special": {"dbtable": "#__componentbuilder_help_document","key": "id","type": "Help_document","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$help_document->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "title","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "content","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"title":"title","type":"type","groups":"groups","location":"location","admin_view":"admin_view","site_view":"site_view","not_required":"not_required","content":"content","article":"article","url":"url","target":"target","alias":"alias"}}';
			$help_document->router = 'ComponentbuilderHelperRoute::getHelp_documentRoute';
			$help_document->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/help_document.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","location","not_required","article","target"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "article","targetTable": "#__content","targetColumn": "id","displayColumn": "title"}]}';

			// Set the object into the content types table.
			$help_document_Inserted = $db->insertObject('#__content_types', $help_document);

			// Create the admin_fields content type object.
			$admin_fields = new stdClass();
			$admin_fields->type_title = 'Componentbuilder Admin_fields';
			$admin_fields->type_alias = 'com_componentbuilder.admin_fields';
			$admin_fields->table = '{"special": {"dbtable": "#__componentbuilder_admin_fields","key": "id","type": "Admin_fields","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_fields->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}';
			$admin_fields->router = 'ComponentbuilderHelperRoute::getAdmin_fieldsRoute';
			$admin_fields->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_fields.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$admin_fields_Inserted = $db->insertObject('#__content_types', $admin_fields);

			// Create the admin_fields_conditions content type object.
			$admin_fields_conditions = new stdClass();
			$admin_fields_conditions->type_title = 'Componentbuilder Admin_fields_conditions';
			$admin_fields_conditions->type_alias = 'com_componentbuilder.admin_fields_conditions';
			$admin_fields_conditions->table = '{"special": {"dbtable": "#__componentbuilder_admin_fields_conditions","key": "id","type": "Admin_fields_conditions","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_fields_conditions->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}';
			$admin_fields_conditions->router = 'ComponentbuilderHelperRoute::getAdmin_fields_conditionsRoute';
			$admin_fields_conditions->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_fields_conditions.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$admin_fields_conditions_Inserted = $db->insertObject('#__content_types', $admin_fields_conditions);

			// Create the component_admin_views content type object.
			$component_admin_views = new stdClass();
			$component_admin_views->type_title = 'Componentbuilder Component_admin_views';
			$component_admin_views->type_alias = 'com_componentbuilder.component_admin_views';
			$component_admin_views->table = '{"special": {"dbtable": "#__componentbuilder_component_admin_views","key": "id","type": "Component_admin_views","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_admin_views->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_admin_views->router = 'ComponentbuilderHelperRoute::getComponent_admin_viewsRoute';
			$component_admin_views->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_admin_views_Inserted = $db->insertObject('#__content_types', $component_admin_views);

			// Create the component_site_views content type object.
			$component_site_views = new stdClass();
			$component_site_views->type_title = 'Componentbuilder Component_site_views';
			$component_site_views->type_alias = 'com_componentbuilder.component_site_views';
			$component_site_views->table = '{"special": {"dbtable": "#__componentbuilder_component_site_views","key": "id","type": "Component_site_views","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_site_views->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_site_views->router = 'ComponentbuilderHelperRoute::getComponent_site_viewsRoute';
			$component_site_views->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_site_views.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_site_views_Inserted = $db->insertObject('#__content_types', $component_site_views);

			// Create the component_custom_admin_views content type object.
			$component_custom_admin_views = new stdClass();
			$component_custom_admin_views->type_title = 'Componentbuilder Component_custom_admin_views';
			$component_custom_admin_views->type_alias = 'com_componentbuilder.component_custom_admin_views';
			$component_custom_admin_views->table = '{"special": {"dbtable": "#__componentbuilder_component_custom_admin_views","key": "id","type": "Component_custom_admin_views","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_custom_admin_views->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_custom_admin_views->router = 'ComponentbuilderHelperRoute::getComponent_custom_admin_viewsRoute';
			$component_custom_admin_views->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_custom_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_custom_admin_views_Inserted = $db->insertObject('#__content_types', $component_custom_admin_views);

			// Create the component_updates content type object.
			$component_updates = new stdClass();
			$component_updates->type_title = 'Componentbuilder Component_updates';
			$component_updates->type_alias = 'com_componentbuilder.component_updates';
			$component_updates->table = '{"special": {"dbtable": "#__componentbuilder_component_updates","key": "id","type": "Component_updates","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_updates->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_updates->router = 'ComponentbuilderHelperRoute::getComponent_updatesRoute';
			$component_updates->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_updates_Inserted = $db->insertObject('#__content_types', $component_updates);

			// Create the component_mysql_tweaks content type object.
			$component_mysql_tweaks = new stdClass();
			$component_mysql_tweaks->type_title = 'Componentbuilder Component_mysql_tweaks';
			$component_mysql_tweaks->type_alias = 'com_componentbuilder.component_mysql_tweaks';
			$component_mysql_tweaks->table = '{"special": {"dbtable": "#__componentbuilder_component_mysql_tweaks","key": "id","type": "Component_mysql_tweaks","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_mysql_tweaks->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_mysql_tweaks->router = 'ComponentbuilderHelperRoute::getComponent_mysql_tweaksRoute';
			$component_mysql_tweaks->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_mysql_tweaks.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_mysql_tweaks_Inserted = $db->insertObject('#__content_types', $component_mysql_tweaks);

			// Create the component_custom_admin_menus content type object.
			$component_custom_admin_menus = new stdClass();
			$component_custom_admin_menus->type_title = 'Componentbuilder Component_custom_admin_menus';
			$component_custom_admin_menus->type_alias = 'com_componentbuilder.component_custom_admin_menus';
			$component_custom_admin_menus->table = '{"special": {"dbtable": "#__componentbuilder_component_custom_admin_menus","key": "id","type": "Component_custom_admin_menus","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_custom_admin_menus->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_custom_admin_menus->router = 'ComponentbuilderHelperRoute::getComponent_custom_admin_menusRoute';
			$component_custom_admin_menus->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_custom_admin_menus.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_custom_admin_menus_Inserted = $db->insertObject('#__content_types', $component_custom_admin_menus);

			// Create the component_config content type object.
			$component_config = new stdClass();
			$component_config->type_title = 'Componentbuilder Component_config';
			$component_config->type_alias = 'com_componentbuilder.component_config';
			$component_config->table = '{"special": {"dbtable": "#__componentbuilder_component_config","key": "id","type": "Component_config","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_config->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_config->router = 'ComponentbuilderHelperRoute::getComponent_configRoute';
			$component_config->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_config.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_config_Inserted = $db->insertObject('#__content_types', $component_config);

			// Create the component_dashboard content type object.
			$component_dashboard = new stdClass();
			$component_dashboard->type_title = 'Componentbuilder Component_dashboard';
			$component_dashboard->type_alias = 'com_componentbuilder.component_dashboard';
			$component_dashboard->table = '{"special": {"dbtable": "#__componentbuilder_component_dashboard","key": "id","type": "Component_dashboard","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_dashboard->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component","php_dashboard_methods":"php_dashboard_methods"}}';
			$component_dashboard->router = 'ComponentbuilderHelperRoute::getComponent_dashboardRoute';
			$component_dashboard->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_dashboard.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_dashboard_Inserted = $db->insertObject('#__content_types', $component_dashboard);

			// Create the component_files_folders content type object.
			$component_files_folders = new stdClass();
			$component_files_folders->type_title = 'Componentbuilder Component_files_folders';
			$component_files_folders->type_alias = 'com_componentbuilder.component_files_folders';
			$component_files_folders->table = '{"special": {"dbtable": "#__componentbuilder_component_files_folders","key": "id","type": "Component_files_folders","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_files_folders->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_files_folders->router = 'ComponentbuilderHelperRoute::getComponent_files_foldersRoute';
			$component_files_folders->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_files_folders.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$component_files_folders_Inserted = $db->insertObject('#__content_types', $component_files_folders);

			// Create the snippet_type content type object.
			$snippet_type = new stdClass();
			$snippet_type->type_title = 'Componentbuilder Snippet_type';
			$snippet_type->type_alias = 'com_componentbuilder.snippet_type';
			$snippet_type->table = '{"special": {"dbtable": "#__componentbuilder_snippet_type","key": "id","type": "Snippet_type","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$snippet_type->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description"}}';
			$snippet_type->router = 'ComponentbuilderHelperRoute::getSnippet_typeRoute';
			$snippet_type->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/snippet_type.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$snippet_type_Inserted = $db->insertObject('#__content_types', $snippet_type);

			// Create the library_config content type object.
			$library_config = new stdClass();
			$library_config->type_title = 'Componentbuilder Library_config';
			$library_config->type_alias = 'com_componentbuilder.library_config';
			$library_config->table = '{"special": {"dbtable": "#__componentbuilder_library_config","key": "id","type": "Library_config","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$library_config->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}';
			$library_config->router = 'ComponentbuilderHelperRoute::getLibrary_configRoute';
			$library_config->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/library_config.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$library_config_Inserted = $db->insertObject('#__content_types', $library_config);

			// Create the library_files_folders_urls content type object.
			$library_files_folders_urls = new stdClass();
			$library_files_folders_urls->type_title = 'Componentbuilder Library_files_folders_urls';
			$library_files_folders_urls->type_alias = 'com_componentbuilder.library_files_folders_urls';
			$library_files_folders_urls->table = '{"special": {"dbtable": "#__componentbuilder_library_files_folders_urls","key": "id","type": "Library_files_folders_urls","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$library_files_folders_urls->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}';
			$library_files_folders_urls->router = 'ComponentbuilderHelperRoute::getLibrary_files_folders_urlsRoute';
			$library_files_folders_urls->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/library_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$library_files_folders_urls_Inserted = $db->insertObject('#__content_types', $library_files_folders_urls);


			// Install the global extenstion params.
			$query = $db->getQuery(true);
			// Field to update.
			$fields = array(
				$db->quoteName('params') . ' = ' . $db->quote('{"autorName":"Llewellyn van der Merwe","autorEmail":"llewellyn@joomlacomponentbuilder.com","minify":"0","language":"en-GB","percentagelanguageadd":"50","compiler_field_builder_type":"2","set_browser_storage":"1","storage_time_to_live":"global","development_method":"1","expansion":"0","return_options_build":"2","cronjob_backup_type":"1","cronjob_backup_server":"0","backup_package_name":"JCB_Backup_[YEAR]_[MONTH]_[DAY]","export_license":"GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html","export_copyright":"Copyright (C) 2015. All Rights Reserved","check_in":"-1 day","save_history":"1","history_limit":"10","uikit_load":"1","uikit_min":"","uikit_style":""}'),
			);
			// Condition.
			$conditions = array(
				$db->quoteName('element') . ' = ' . $db->quote('com_componentbuilder')
			);
			$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();

			echo '<a target="_blank" href="http://joomlacomponentbuilder.com" title="Component Builder">
				<img src="components/com_componentbuilder/assets/images/vdm-component.jpg"/>
				</a>';
		}
		// do any updates needed
		if ($type == 'update')
		{

			// Get The Database object
			$db = JFactory::getDbo();

			// Create the joomla_component content type object.
			$joomla_component = new stdClass();
			$joomla_component->type_title = 'Componentbuilder Joomla_component';
			$joomla_component->type_alias = 'com_componentbuilder.joomla_component';
			$joomla_component->table = '{"special": {"dbtable": "#__componentbuilder_joomla_component","key": "id","type": "Joomla_component","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$joomla_component->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "system_name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "readme","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "metadata","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "metakey","core_metadesc": "metadesc","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","component_version":"component_version","short_description":"short_description","companyname":"companyname","author":"author","php_postflight_update":"php_postflight_update","php_preflight_update":"php_preflight_update","javascript":"javascript","css_site":"css_site","debug_linenr":"debug_linenr","add_email_helper":"add_email_helper","copyright":"copyright","add_placeholders":"add_placeholders","description":"description","mvc_versiondate":"mvc_versiondate","sql":"sql","php_helper_admin":"php_helper_admin","add_update_server":"add_update_server","php_helper_site":"php_helper_site","sales_server":"sales_server","adduikit":"adduikit","email":"email","php_helper_both":"php_helper_both","website":"website","php_admin_event":"php_admin_event","add_license":"add_license","php_site_event":"php_site_event","license_type":"license_type","css_admin":"css_admin","whmcs_key":"whmcs_key","php_preflight_install":"php_preflight_install","whmcs_url":"whmcs_url","php_postflight_install":"php_postflight_install","license":"license","php_method_uninstall":"php_method_uninstall","bom":"bom","readme":"readme","image":"image","update_server_target":"update_server_target","not_required":"not_required","update_server":"update_server","buildcomp":"buildcomp","creatuserhelper":"creatuserhelper","addfootable":"addfootable","add_php_helper_both":"add_php_helper_both","add_php_helper_admin":"add_php_helper_admin","add_admin_event":"add_admin_event","add_php_helper_site":"add_php_helper_site","add_site_event":"add_site_event","add_javascript":"add_javascript","add_css_admin":"add_css_admin","toignore":"toignore","add_css_site":"add_css_site","dashboard_type":"dashboard_type","dashboard":"dashboard","export_key":"export_key","add_php_preflight_install":"add_php_preflight_install","export_package_link":"export_package_link","add_php_preflight_update":"add_php_preflight_update","export_buy_link":"export_buy_link","add_php_postflight_install":"add_php_postflight_install","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","add_sql":"add_sql","emptycontributors":"emptycontributors","addreadme":"addreadme","number":"number","update_server_url":"update_server_url","add_sales_server":"add_sales_server","buildcompsql":"buildcompsql","name":"name"}}';
			$joomla_component->router = 'ComponentbuilderHelperRoute::getJoomla_componentRoute';
			$joomla_component->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","debug_linenr","add_email_helper","add_placeholders","mvc_versiondate","add_update_server","sales_server","adduikit","add_license","license_type","update_server_target","not_required","update_server","buildcomp","creatuserhelper","addfootable","add_php_helper_both","add_php_helper_admin","add_admin_event","add_php_helper_site","add_site_event","add_javascript","add_css_admin","add_css_site","dashboard_type","add_php_preflight_install","add_php_preflight_update","add_php_postflight_install","add_php_postflight_update","add_php_method_uninstall","add_sql","emptycontributors","addreadme","number","add_sales_server"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server","targetTable": "#__componentbuilder_server","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dashboard","targetTable": "#__componentbuilder_custom_admin_view","targetColumn": "","displayColumn": "system_name"}]}';

			// Check if joomla_component type is already in content_type DB.
			$joomla_component_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($joomla_component->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$joomla_component->type_id = $db->loadResult();
				$joomla_component_Updated = $db->updateObject('#__content_types', $joomla_component, 'type_id');
			}
			else
			{
				$joomla_component_Inserted = $db->insertObject('#__content_types', $joomla_component);
			}

			// Create the admin_view content type object.
			$admin_view = new stdClass();
			$admin_view->type_title = 'Componentbuilder Admin_view';
			$admin_view->type_alias = 'com_componentbuilder.admin_view';
			$admin_view->table = '{"special": {"dbtable": "#__componentbuilder_admin_view","key": "id","type": "Admin_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","name_list":"name_list","short_description":"short_description","add_php_batchmove":"add_php_batchmove","add_php_allowedit":"add_php_allowedit","add_php_save":"add_php_save","add_php_getlistquery":"add_php_getlistquery","icon_add":"icon_add","html_import_view":"html_import_view","add_sql":"add_sql","type":"type","add_fadein":"add_fadein","description":"description","icon_category":"icon_category","add_php_after_publish":"add_php_after_publish","not_required":"not_required","add_php_after_delete":"add_php_after_delete","php_import_save":"php_import_save","add_php_getitems_after_all":"add_php_getitems_after_all","add_php_before_save":"add_php_before_save","add_php_postsavehook":"add_php_postsavehook","add_php_batchcopy":"add_php_batchcopy","add_php_before_publish":"add_php_before_publish","alias_builder_type":"alias_builder_type","add_php_before_delete":"add_php_before_delete","add_php_document":"add_php_document","alias_builder":"alias_builder","add_custom_import":"add_custom_import","add_php_getitem":"add_php_getitem","php_import_headers":"php_import_headers","add_php_getitems":"add_php_getitems","icon":"icon","php_getitem":"php_getitem","php_getitems":"php_getitems","add_css_view":"add_css_view","php_getitems_after_all":"php_getitems_after_all","css_view":"css_view","php_getlistquery":"php_getlistquery","add_css_views":"add_css_views","php_before_save":"php_before_save","css_views":"css_views","php_save":"php_save","add_javascript_view_file":"add_javascript_view_file","php_postsavehook":"php_postsavehook","javascript_view_file":"javascript_view_file","php_allowedit":"php_allowedit","add_javascript_view_footer":"add_javascript_view_footer","php_batchcopy":"php_batchcopy","javascript_view_footer":"javascript_view_footer","php_batchmove":"php_batchmove","add_javascript_views_file":"add_javascript_views_file","php_before_publish":"php_before_publish","javascript_views_file":"javascript_views_file","php_after_publish":"php_after_publish","add_javascript_views_footer":"add_javascript_views_footer","php_before_delete":"php_before_delete","javascript_views_footer":"javascript_views_footer","php_after_delete":"php_after_delete","add_custom_button":"add_custom_button","php_document":"php_document","source":"source","php_controller":"php_controller","sql":"sql","php_model":"php_model","php_controller_list":"php_controller_list","php_import_display":"php_import_display","php_model_list":"php_model_list","php_import":"php_import","add_php_ajax":"add_php_ajax","php_import_setdata":"php_import_setdata","php_ajaxmethod":"php_ajaxmethod","php_import_ext":"php_import_ext"}}';
			$admin_view->router = 'ComponentbuilderHelperRoute::getAdmin_viewRoute';
			$admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_php_batchmove","add_php_allowedit","add_php_save","add_php_getlistquery","add_sql","type","add_fadein","add_php_after_publish","add_php_after_delete","add_php_getitems_after_all","add_php_before_save","add_php_postsavehook","add_php_batchcopy","add_php_before_publish","add_php_before_delete","add_php_document","add_custom_import","add_php_getitem","add_php_getitems","add_css_view","add_css_views","add_javascript_view_file","add_javascript_view_footer","add_javascript_views_file","add_javascript_views_footer","add_custom_button","source","add_php_ajax"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "alias_builder","targetTable": "#__componentbuilder_field","targetColumn": "id","displayColumn": "name"}]}';

			// Check if admin_view type is already in content_type DB.
			$admin_view_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($admin_view->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$admin_view->type_id = $db->loadResult();
				$admin_view_Updated = $db->updateObject('#__content_types', $admin_view, 'type_id');
			}
			else
			{
				$admin_view_Inserted = $db->insertObject('#__content_types', $admin_view);
			}

			// Create the custom_admin_view content type object.
			$custom_admin_view = new stdClass();
			$custom_admin_view->type_title = 'Componentbuilder Custom_admin_view';
			$custom_admin_view->type_alias = 'com_componentbuilder.custom_admin_view';
			$custom_admin_view->table = '{"special": {"dbtable": "#__componentbuilder_custom_admin_view","key": "id","type": "Custom_admin_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$custom_admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","php_jview_display":"php_jview_display","php_view":"php_view","php_document":"php_document","add_php_ajax":"add_php_ajax","add_css":"add_css","add_js_document":"add_js_document","default":"default","icon":"icon","php_jview":"php_jview","add_javascript_file":"add_javascript_file","libraries":"libraries","js_document":"js_document","add_css_document":"add_css_document","javascript_file":"javascript_file","not_required":"not_required","css_document":"css_document","custom_get":"custom_get","css":"css","main_get":"main_get","php_ajaxmethod":"php_ajaxmethod","dynamic_get":"dynamic_get","add_php_document":"add_php_document","add_php_view":"add_php_view","add_custom_button":"add_custom_button","add_php_jview_display":"add_php_jview_display","add_php_jview":"add_php_jview","php_controller":"php_controller","php_model":"php_model"}}';
			$custom_admin_view->router = 'ComponentbuilderHelperRoute::getCustom_admin_viewRoute';
			$custom_admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/custom_admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_ajax","add_css","add_js_document","add_javascript_file","add_css_document","not_required","main_get","dynamic_get","add_php_document","add_php_view","add_custom_button","add_php_jview_display","add_php_jview"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

			// Check if custom_admin_view type is already in content_type DB.
			$custom_admin_view_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($custom_admin_view->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$custom_admin_view->type_id = $db->loadResult();
				$custom_admin_view_Updated = $db->updateObject('#__content_types', $custom_admin_view, 'type_id');
			}
			else
			{
				$custom_admin_view_Inserted = $db->insertObject('#__content_types', $custom_admin_view);
			}

			// Create the site_view content type object.
			$site_view = new stdClass();
			$site_view->type_title = 'Componentbuilder Site_view';
			$site_view->type_alias = 'com_componentbuilder.site_view';
			$site_view->table = '{"special": {"dbtable": "#__componentbuilder_site_view","key": "id","type": "Site_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$site_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","php_document":"php_document","add_php_ajax":"add_php_ajax","add_css":"add_css","add_css_document":"add_css_document","libraries":"libraries","php_jview":"php_jview","default":"default","php_view":"php_view","add_javascript_file":"add_javascript_file","php_jview_display":"php_jview_display","add_js_document":"add_js_document","not_required":"not_required","javascript_file":"javascript_file","custom_get":"custom_get","js_document":"js_document","main_get":"main_get","css_document":"css_document","dynamic_get":"dynamic_get","css":"css","php_ajaxmethod":"php_ajaxmethod","add_custom_button":"add_custom_button","add_php_document":"add_php_document","button_position":"button_position","add_php_view":"add_php_view","add_php_jview_display":"add_php_jview_display","add_php_jview":"add_php_jview","php_controller":"php_controller","php_model":"php_model"}}';
			$site_view->router = 'ComponentbuilderHelperRoute::getSite_viewRoute';
			$site_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/site_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_ajax","add_css","add_css_document","add_javascript_file","add_js_document","not_required","main_get","dynamic_get","add_custom_button","add_php_document","button_position","add_php_view","add_php_jview_display","add_php_jview"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

			// Check if site_view type is already in content_type DB.
			$site_view_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($site_view->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$site_view->type_id = $db->loadResult();
				$site_view_Updated = $db->updateObject('#__content_types', $site_view, 'type_id');
			}
			else
			{
				$site_view_Inserted = $db->insertObject('#__content_types', $site_view);
			}

			// Create the template content type object.
			$template = new stdClass();
			$template->type_title = 'Componentbuilder Template';
			$template->type_alias = 'com_componentbuilder.template';
			$template->table = '{"special": {"dbtable": "#__componentbuilder_template","key": "id","type": "Template","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$template->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","snippet":"snippet","php_view":"php_view","add_php_view":"add_php_view","dynamic_get":"dynamic_get","not_required":"not_required","template":"template","libraries":"libraries"}}';
			$template->router = 'ComponentbuilderHelperRoute::getTemplateRoute';
			$template->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/template.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_view","dynamic_get","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Check if template type is already in content_type DB.
			$template_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($template->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$template->type_id = $db->loadResult();
				$template_Updated = $db->updateObject('#__content_types', $template, 'type_id');
			}
			else
			{
				$template_Inserted = $db->insertObject('#__content_types', $template);
			}

			// Create the layout content type object.
			$layout = new stdClass();
			$layout->type_title = 'Componentbuilder Layout';
			$layout->type_alias = 'com_componentbuilder.layout';
			$layout->table = '{"special": {"dbtable": "#__componentbuilder_layout","key": "id","type": "Layout","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$layout->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","php_view":"php_view","add_php_view":"add_php_view","not_required":"not_required","layout":"layout","libraries":"libraries"}}';
			$layout->router = 'ComponentbuilderHelperRoute::getLayoutRoute';
			$layout->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/layout.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","dynamic_get","snippet","add_php_view","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Check if layout type is already in content_type DB.
			$layout_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($layout->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$layout->type_id = $db->loadResult();
				$layout_Updated = $db->updateObject('#__content_types', $layout, 'type_id');
			}
			else
			{
				$layout_Inserted = $db->insertObject('#__content_types', $layout);
			}

			// Create the dynamic_get content type object.
			$dynamic_get = new stdClass();
			$dynamic_get->type_title = 'Componentbuilder Dynamic_get';
			$dynamic_get->type_alias = 'com_componentbuilder.dynamic_get';
			$dynamic_get->table = '{"special": {"dbtable": "#__componentbuilder_dynamic_get","key": "id","type": "Dynamic_get","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$dynamic_get->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","addcalculation":"addcalculation","add_php_router_parse":"add_php_router_parse","add_php_after_getitems":"add_php_after_getitems","add_php_before_getitems":"add_php_before_getitems","add_php_getlistquery":"add_php_getlistquery","add_php_after_getitem":"add_php_after_getitem","add_php_before_getitem":"add_php_before_getitem","php_custom_get":"php_custom_get","db_selection":"db_selection","db_table_main":"db_table_main","view_selection":"view_selection","view_table_main":"view_table_main","getcustom":"getcustom","php_before_getitem":"php_before_getitem","pagination":"pagination","php_after_getitem":"php_after_getitem","not_required":"not_required","php_getlistquery":"php_getlistquery","php_before_getitems":"php_before_getitems","php_after_getitems":"php_after_getitems","php_router_parse":"php_router_parse","php_calculation":"php_calculation"}}';
			$dynamic_get->router = 'ComponentbuilderHelperRoute::getDynamic_getRoute';
			$dynamic_get->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","main_source","gettype","add_php_router_parse","add_php_after_getitems","add_php_before_getitems","add_php_getlistquery","add_php_after_getitem","add_php_before_getitem","view_table_main","pagination","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if dynamic_get type is already in content_type DB.
			$dynamic_get_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($dynamic_get->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$dynamic_get->type_id = $db->loadResult();
				$dynamic_get_Updated = $db->updateObject('#__content_types', $dynamic_get, 'type_id');
			}
			else
			{
				$dynamic_get_Inserted = $db->insertObject('#__content_types', $dynamic_get);
			}

			// Create the custom_code content type object.
			$custom_code = new stdClass();
			$custom_code->type_title = 'Componentbuilder Custom_code';
			$custom_code->type_alias = 'com_componentbuilder.custom_code';
			$custom_code->table = '{"special": {"dbtable": "#__componentbuilder_custom_code","key": "id","type": "Custom_code","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$custom_code->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","not_required":"not_required","function_name":"function_name","system_name":"system_name","code":"code","hashendtarget":"hashendtarget","to_line":"to_line","from_line":"from_line","hashtarget":"hashtarget"}}';
			$custom_code->router = 'ComponentbuilderHelperRoute::getCustom_codeRoute';
			$custom_code->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/custom_code.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","component","target","type","comment_type","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if custom_code type is already in content_type DB.
			$custom_code_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($custom_code->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$custom_code->type_id = $db->loadResult();
				$custom_code_Updated = $db->updateObject('#__content_types', $custom_code, 'type_id');
			}
			else
			{
				$custom_code_Inserted = $db->insertObject('#__content_types', $custom_code);
			}

			// Create the library content type object.
			$library = new stdClass();
			$library->type_title = 'Componentbuilder Library';
			$library->type_alias = 'com_componentbuilder.library';
			$library->table = '{"special": {"dbtable": "#__componentbuilder_library","key": "id","type": "Library","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$library->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","how":"how","type":"type","not_required":"not_required","libraries":"libraries","php_setdocument":"php_setdocument"}}';
			$library->router = 'ComponentbuilderHelperRoute::getLibraryRoute';
			$library->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/library.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","how","type","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "libraries","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Check if library type is already in content_type DB.
			$library_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($library->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$library->type_id = $db->loadResult();
				$library_Updated = $db->updateObject('#__content_types', $library, 'type_id');
			}
			else
			{
				$library_Inserted = $db->insertObject('#__content_types', $library);
			}

			// Create the snippet content type object.
			$snippet = new stdClass();
			$snippet->type_title = 'Componentbuilder Snippet';
			$snippet->type_alias = 'com_componentbuilder.snippet';
			$snippet->table = '{"special": {"dbtable": "#__componentbuilder_snippet","key": "id","type": "Snippet","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$snippet->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","url":"url","type":"type","heading":"heading","library":"library","contributor_email":"contributor_email","contributor_name":"contributor_name","contributor_website":"contributor_website","contributor_company":"contributor_company","snippet":"snippet","usage":"usage","description":"description"}}';
			$snippet->router = 'ComponentbuilderHelperRoute::getSnippetRoute';
			$snippet->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/snippet.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "type","targetTable": "#__componentbuilder_snippet_type","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Check if snippet type is already in content_type DB.
			$snippet_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($snippet->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$snippet->type_id = $db->loadResult();
				$snippet_Updated = $db->updateObject('#__content_types', $snippet, 'type_id');
			}
			else
			{
				$snippet_Inserted = $db->insertObject('#__content_types', $snippet);
			}

			// Create the validation_rule content type object.
			$validation_rule = new stdClass();
			$validation_rule->type_title = 'Componentbuilder Validation_rule';
			$validation_rule->type_alias = 'com_componentbuilder.validation_rule';
			$validation_rule->table = '{"special": {"dbtable": "#__componentbuilder_validation_rule","key": "id","type": "Validation_rule","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$validation_rule->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","short_description":"short_description","inherit":"inherit","php":"php"}}';
			$validation_rule->router = 'ComponentbuilderHelperRoute::getValidation_ruleRoute';
			$validation_rule->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/validation_rule.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "inherit","targetTable": "#__componentbuilder_validation_rule","targetColumn": "id","displayColumn": "name"}]}';

			// Check if validation_rule type is already in content_type DB.
			$validation_rule_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($validation_rule->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$validation_rule->type_id = $db->loadResult();
				$validation_rule_Updated = $db->updateObject('#__content_types', $validation_rule, 'type_id');
			}
			else
			{
				$validation_rule_Inserted = $db->insertObject('#__content_types', $validation_rule);
			}

			// Create the field content type object.
			$field = new stdClass();
			$field->type_title = 'Componentbuilder Field';
			$field->type_alias = 'com_componentbuilder.field';
			$field->table = '{"special": {"dbtable": "#__componentbuilder_field","key": "id","type": "Field","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$field->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","store":"store","css_views":"css_views","add_css_views":"add_css_views","css_view":"css_view","add_css_view":"add_css_view","datalenght":"datalenght","add_javascript_views_footer":"add_javascript_views_footer","datadefault_other":"datadefault_other","datadefault":"datadefault","datalenght_other":"datalenght_other","add_javascript_view_footer":"add_javascript_view_footer","javascript_view_footer":"javascript_view_footer","javascript_views_footer":"javascript_views_footer","not_required":"not_required","xml":"xml"}}';
			$field->router = 'ComponentbuilderHelperRoute::getFieldRoute';
			$field->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required","xml"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","fieldtype","store","catid","add_css_views","add_css_view","add_javascript_views_footer","add_javascript_view_footer"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}';

			// Check if field type is already in content_type DB.
			$field_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($field->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$field->type_id = $db->loadResult();
				$field_Updated = $db->updateObject('#__content_types', $field, 'type_id');
			}
			else
			{
				$field_Inserted = $db->insertObject('#__content_types', $field);
			}

			// Create the field category content type object.
			$field_category = new stdClass();
			$field_category->type_title = 'Componentbuilder Field Catid';
			$field_category->type_alias = 'com_componentbuilder.fields.category';
			$field_category->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$field_category->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$field_category->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$field_category->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Check if field category type is already in content_type DB.
			$field_category_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($field_category->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$field_category->type_id = $db->loadResult();
				$field_category_Updated = $db->updateObject('#__content_types', $field_category, 'type_id');
			}
			else
			{
				$field_category_Inserted = $db->insertObject('#__content_types', $field_category);
			}

			// Create the fieldtype content type object.
			$fieldtype = new stdClass();
			$fieldtype->type_title = 'Componentbuilder Fieldtype';
			$fieldtype->type_alias = 'com_componentbuilder.fieldtype';
			$fieldtype->table = '{"special": {"dbtable": "#__componentbuilder_fieldtype","key": "id","type": "Fieldtype","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$fieldtype->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description","short_description":"short_description"}}';
			$fieldtype->router = 'ComponentbuilderHelperRoute::getFieldtypeRoute';
			$fieldtype->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/fieldtype.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","catid"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if fieldtype type is already in content_type DB.
			$fieldtype_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($fieldtype->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$fieldtype->type_id = $db->loadResult();
				$fieldtype_Updated = $db->updateObject('#__content_types', $fieldtype, 'type_id');
			}
			else
			{
				$fieldtype_Inserted = $db->insertObject('#__content_types', $fieldtype);
			}

			// Create the fieldtype category content type object.
			$fieldtype_category = new stdClass();
			$fieldtype_category->type_title = 'Componentbuilder Fieldtype Catid';
			$fieldtype_category->type_alias = 'com_componentbuilder.fieldtypes.category';
			$fieldtype_category->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$fieldtype_category->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$fieldtype_category->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$fieldtype_category->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Check if fieldtype category type is already in content_type DB.
			$fieldtype_category_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($fieldtype_category->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$fieldtype_category->type_id = $db->loadResult();
				$fieldtype_category_Updated = $db->updateObject('#__content_types', $fieldtype_category, 'type_id');
			}
			else
			{
				$fieldtype_category_Inserted = $db->insertObject('#__content_types', $fieldtype_category);
			}

			// Create the language_translation content type object.
			$language_translation = new stdClass();
			$language_translation->type_title = 'Componentbuilder Language_translation';
			$language_translation->type_alias = 'com_componentbuilder.language_translation';
			$language_translation->table = '{"special": {"dbtable": "#__componentbuilder_language_translation","key": "id","type": "Language_translation","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$language_translation->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "source","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"source":"source","components":"components"}}';
			$language_translation->router = 'ComponentbuilderHelperRoute::getLanguage_translationRoute';
			$language_translation->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/language_translation.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "components","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if language_translation type is already in content_type DB.
			$language_translation_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($language_translation->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$language_translation->type_id = $db->loadResult();
				$language_translation_Updated = $db->updateObject('#__content_types', $language_translation, 'type_id');
			}
			else
			{
				$language_translation_Inserted = $db->insertObject('#__content_types', $language_translation);
			}

			// Create the language content type object.
			$language = new stdClass();
			$language->type_title = 'Componentbuilder Language';
			$language->type_alias = 'com_componentbuilder.language';
			$language->table = '{"special": {"dbtable": "#__componentbuilder_language","key": "id","type": "Language","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$language->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","langtag":"langtag"}}';
			$language->router = 'ComponentbuilderHelperRoute::getLanguageRoute';
			$language->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/language.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if language type is already in content_type DB.
			$language_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($language->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$language->type_id = $db->loadResult();
				$language_Updated = $db->updateObject('#__content_types', $language, 'type_id');
			}
			else
			{
				$language_Inserted = $db->insertObject('#__content_types', $language);
			}

			// Create the server content type object.
			$server = new stdClass();
			$server->type_title = 'Componentbuilder Server';
			$server->type_alias = 'com_componentbuilder.server';
			$server->table = '{"special": {"dbtable": "#__componentbuilder_server","key": "id","type": "Server","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$server->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","protocol":"protocol","not_required":"not_required","signature":"signature","private_key":"private_key","secret":"secret","password":"password","private":"private","authentication":"authentication","path":"path","port":"port","host":"host","username":"username"}}';
			$server->router = 'ComponentbuilderHelperRoute::getServerRoute';
			$server->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/server.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","protocol","not_required","authentication"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if server type is already in content_type DB.
			$server_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($server->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$server->type_id = $db->loadResult();
				$server_Updated = $db->updateObject('#__content_types', $server, 'type_id');
			}
			else
			{
				$server_Inserted = $db->insertObject('#__content_types', $server);
			}

			// Create the help_document content type object.
			$help_document = new stdClass();
			$help_document->type_title = 'Componentbuilder Help_document';
			$help_document->type_alias = 'com_componentbuilder.help_document';
			$help_document->table = '{"special": {"dbtable": "#__componentbuilder_help_document","key": "id","type": "Help_document","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$help_document->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "title","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "content","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"title":"title","type":"type","groups":"groups","location":"location","admin_view":"admin_view","site_view":"site_view","not_required":"not_required","content":"content","article":"article","url":"url","target":"target","alias":"alias"}}';
			$help_document->router = 'ComponentbuilderHelperRoute::getHelp_documentRoute';
			$help_document->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/help_document.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","location","not_required","article","target"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "article","targetTable": "#__content","targetColumn": "id","displayColumn": "title"}]}';

			// Check if help_document type is already in content_type DB.
			$help_document_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($help_document->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$help_document->type_id = $db->loadResult();
				$help_document_Updated = $db->updateObject('#__content_types', $help_document, 'type_id');
			}
			else
			{
				$help_document_Inserted = $db->insertObject('#__content_types', $help_document);
			}

			// Create the admin_fields content type object.
			$admin_fields = new stdClass();
			$admin_fields->type_title = 'Componentbuilder Admin_fields';
			$admin_fields->type_alias = 'com_componentbuilder.admin_fields';
			$admin_fields->table = '{"special": {"dbtable": "#__componentbuilder_admin_fields","key": "id","type": "Admin_fields","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_fields->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}';
			$admin_fields->router = 'ComponentbuilderHelperRoute::getAdmin_fieldsRoute';
			$admin_fields->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_fields.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if admin_fields type is already in content_type DB.
			$admin_fields_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($admin_fields->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$admin_fields->type_id = $db->loadResult();
				$admin_fields_Updated = $db->updateObject('#__content_types', $admin_fields, 'type_id');
			}
			else
			{
				$admin_fields_Inserted = $db->insertObject('#__content_types', $admin_fields);
			}

			// Create the admin_fields_conditions content type object.
			$admin_fields_conditions = new stdClass();
			$admin_fields_conditions->type_title = 'Componentbuilder Admin_fields_conditions';
			$admin_fields_conditions->type_alias = 'com_componentbuilder.admin_fields_conditions';
			$admin_fields_conditions->table = '{"special": {"dbtable": "#__componentbuilder_admin_fields_conditions","key": "id","type": "Admin_fields_conditions","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_fields_conditions->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "admin_view","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"admin_view":"admin_view"}}';
			$admin_fields_conditions->router = 'ComponentbuilderHelperRoute::getAdmin_fields_conditionsRoute';
			$admin_fields_conditions->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_fields_conditions.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","admin_view"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "admin_view","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if admin_fields_conditions type is already in content_type DB.
			$admin_fields_conditions_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($admin_fields_conditions->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$admin_fields_conditions->type_id = $db->loadResult();
				$admin_fields_conditions_Updated = $db->updateObject('#__content_types', $admin_fields_conditions, 'type_id');
			}
			else
			{
				$admin_fields_conditions_Inserted = $db->insertObject('#__content_types', $admin_fields_conditions);
			}

			// Create the component_admin_views content type object.
			$component_admin_views = new stdClass();
			$component_admin_views->type_title = 'Componentbuilder Component_admin_views';
			$component_admin_views->type_alias = 'com_componentbuilder.component_admin_views';
			$component_admin_views->table = '{"special": {"dbtable": "#__componentbuilder_component_admin_views","key": "id","type": "Component_admin_views","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_admin_views->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_admin_views->router = 'ComponentbuilderHelperRoute::getComponent_admin_viewsRoute';
			$component_admin_views->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_admin_views type is already in content_type DB.
			$component_admin_views_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_admin_views->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_admin_views->type_id = $db->loadResult();
				$component_admin_views_Updated = $db->updateObject('#__content_types', $component_admin_views, 'type_id');
			}
			else
			{
				$component_admin_views_Inserted = $db->insertObject('#__content_types', $component_admin_views);
			}

			// Create the component_site_views content type object.
			$component_site_views = new stdClass();
			$component_site_views->type_title = 'Componentbuilder Component_site_views';
			$component_site_views->type_alias = 'com_componentbuilder.component_site_views';
			$component_site_views->table = '{"special": {"dbtable": "#__componentbuilder_component_site_views","key": "id","type": "Component_site_views","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_site_views->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_site_views->router = 'ComponentbuilderHelperRoute::getComponent_site_viewsRoute';
			$component_site_views->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_site_views.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_site_views type is already in content_type DB.
			$component_site_views_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_site_views->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_site_views->type_id = $db->loadResult();
				$component_site_views_Updated = $db->updateObject('#__content_types', $component_site_views, 'type_id');
			}
			else
			{
				$component_site_views_Inserted = $db->insertObject('#__content_types', $component_site_views);
			}

			// Create the component_custom_admin_views content type object.
			$component_custom_admin_views = new stdClass();
			$component_custom_admin_views->type_title = 'Componentbuilder Component_custom_admin_views';
			$component_custom_admin_views->type_alias = 'com_componentbuilder.component_custom_admin_views';
			$component_custom_admin_views->table = '{"special": {"dbtable": "#__componentbuilder_component_custom_admin_views","key": "id","type": "Component_custom_admin_views","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_custom_admin_views->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_custom_admin_views->router = 'ComponentbuilderHelperRoute::getComponent_custom_admin_viewsRoute';
			$component_custom_admin_views->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_custom_admin_views.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_custom_admin_views type is already in content_type DB.
			$component_custom_admin_views_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_custom_admin_views->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_custom_admin_views->type_id = $db->loadResult();
				$component_custom_admin_views_Updated = $db->updateObject('#__content_types', $component_custom_admin_views, 'type_id');
			}
			else
			{
				$component_custom_admin_views_Inserted = $db->insertObject('#__content_types', $component_custom_admin_views);
			}

			// Create the component_updates content type object.
			$component_updates = new stdClass();
			$component_updates->type_title = 'Componentbuilder Component_updates';
			$component_updates->type_alias = 'com_componentbuilder.component_updates';
			$component_updates->table = '{"special": {"dbtable": "#__componentbuilder_component_updates","key": "id","type": "Component_updates","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_updates->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_updates->router = 'ComponentbuilderHelperRoute::getComponent_updatesRoute';
			$component_updates->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_updates.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_updates type is already in content_type DB.
			$component_updates_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_updates->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_updates->type_id = $db->loadResult();
				$component_updates_Updated = $db->updateObject('#__content_types', $component_updates, 'type_id');
			}
			else
			{
				$component_updates_Inserted = $db->insertObject('#__content_types', $component_updates);
			}

			// Create the component_mysql_tweaks content type object.
			$component_mysql_tweaks = new stdClass();
			$component_mysql_tweaks->type_title = 'Componentbuilder Component_mysql_tweaks';
			$component_mysql_tweaks->type_alias = 'com_componentbuilder.component_mysql_tweaks';
			$component_mysql_tweaks->table = '{"special": {"dbtable": "#__componentbuilder_component_mysql_tweaks","key": "id","type": "Component_mysql_tweaks","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_mysql_tweaks->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_mysql_tweaks->router = 'ComponentbuilderHelperRoute::getComponent_mysql_tweaksRoute';
			$component_mysql_tweaks->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_mysql_tweaks.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_mysql_tweaks type is already in content_type DB.
			$component_mysql_tweaks_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_mysql_tweaks->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_mysql_tweaks->type_id = $db->loadResult();
				$component_mysql_tweaks_Updated = $db->updateObject('#__content_types', $component_mysql_tweaks, 'type_id');
			}
			else
			{
				$component_mysql_tweaks_Inserted = $db->insertObject('#__content_types', $component_mysql_tweaks);
			}

			// Create the component_custom_admin_menus content type object.
			$component_custom_admin_menus = new stdClass();
			$component_custom_admin_menus->type_title = 'Componentbuilder Component_custom_admin_menus';
			$component_custom_admin_menus->type_alias = 'com_componentbuilder.component_custom_admin_menus';
			$component_custom_admin_menus->table = '{"special": {"dbtable": "#__componentbuilder_component_custom_admin_menus","key": "id","type": "Component_custom_admin_menus","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_custom_admin_menus->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_custom_admin_menus->router = 'ComponentbuilderHelperRoute::getComponent_custom_admin_menusRoute';
			$component_custom_admin_menus->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_custom_admin_menus.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_custom_admin_menus type is already in content_type DB.
			$component_custom_admin_menus_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_custom_admin_menus->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_custom_admin_menus->type_id = $db->loadResult();
				$component_custom_admin_menus_Updated = $db->updateObject('#__content_types', $component_custom_admin_menus, 'type_id');
			}
			else
			{
				$component_custom_admin_menus_Inserted = $db->insertObject('#__content_types', $component_custom_admin_menus);
			}

			// Create the component_config content type object.
			$component_config = new stdClass();
			$component_config->type_title = 'Componentbuilder Component_config';
			$component_config->type_alias = 'com_componentbuilder.component_config';
			$component_config->table = '{"special": {"dbtable": "#__componentbuilder_component_config","key": "id","type": "Component_config","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_config->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_config->router = 'ComponentbuilderHelperRoute::getComponent_configRoute';
			$component_config->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_config.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_config type is already in content_type DB.
			$component_config_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_config->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_config->type_id = $db->loadResult();
				$component_config_Updated = $db->updateObject('#__content_types', $component_config, 'type_id');
			}
			else
			{
				$component_config_Inserted = $db->insertObject('#__content_types', $component_config);
			}

			// Create the component_dashboard content type object.
			$component_dashboard = new stdClass();
			$component_dashboard->type_title = 'Componentbuilder Component_dashboard';
			$component_dashboard->type_alias = 'com_componentbuilder.component_dashboard';
			$component_dashboard->table = '{"special": {"dbtable": "#__componentbuilder_component_dashboard","key": "id","type": "Component_dashboard","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_dashboard->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component","php_dashboard_methods":"php_dashboard_methods"}}';
			$component_dashboard->router = 'ComponentbuilderHelperRoute::getComponent_dashboardRoute';
			$component_dashboard->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_dashboard.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_dashboard type is already in content_type DB.
			$component_dashboard_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_dashboard->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_dashboard->type_id = $db->loadResult();
				$component_dashboard_Updated = $db->updateObject('#__content_types', $component_dashboard, 'type_id');
			}
			else
			{
				$component_dashboard_Inserted = $db->insertObject('#__content_types', $component_dashboard);
			}

			// Create the component_files_folders content type object.
			$component_files_folders = new stdClass();
			$component_files_folders->type_title = 'Componentbuilder Component_files_folders';
			$component_files_folders->type_alias = 'com_componentbuilder.component_files_folders';
			$component_files_folders->table = '{"special": {"dbtable": "#__componentbuilder_component_files_folders","key": "id","type": "Component_files_folders","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$component_files_folders->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "joomla_component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"joomla_component":"joomla_component"}}';
			$component_files_folders->router = 'ComponentbuilderHelperRoute::getComponent_files_foldersRoute';
			$component_files_folders->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/component_files_folders.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","joomla_component"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "joomla_component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Check if component_files_folders type is already in content_type DB.
			$component_files_folders_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($component_files_folders->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$component_files_folders->type_id = $db->loadResult();
				$component_files_folders_Updated = $db->updateObject('#__content_types', $component_files_folders, 'type_id');
			}
			else
			{
				$component_files_folders_Inserted = $db->insertObject('#__content_types', $component_files_folders);
			}

			// Create the snippet_type content type object.
			$snippet_type = new stdClass();
			$snippet_type->type_title = 'Componentbuilder Snippet_type';
			$snippet_type->type_alias = 'com_componentbuilder.snippet_type';
			$snippet_type->table = '{"special": {"dbtable": "#__componentbuilder_snippet_type","key": "id","type": "Snippet_type","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$snippet_type->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","description":"description"}}';
			$snippet_type->router = 'ComponentbuilderHelperRoute::getSnippet_typeRoute';
			$snippet_type->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/snippet_type.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if snippet_type type is already in content_type DB.
			$snippet_type_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($snippet_type->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$snippet_type->type_id = $db->loadResult();
				$snippet_type_Updated = $db->updateObject('#__content_types', $snippet_type, 'type_id');
			}
			else
			{
				$snippet_type_Inserted = $db->insertObject('#__content_types', $snippet_type);
			}

			// Create the library_config content type object.
			$library_config = new stdClass();
			$library_config->type_title = 'Componentbuilder Library_config';
			$library_config->type_alias = 'com_componentbuilder.library_config';
			$library_config->table = '{"special": {"dbtable": "#__componentbuilder_library_config","key": "id","type": "Library_config","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$library_config->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}';
			$library_config->router = 'ComponentbuilderHelperRoute::getLibrary_configRoute';
			$library_config->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/library_config.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Check if library_config type is already in content_type DB.
			$library_config_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($library_config->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$library_config->type_id = $db->loadResult();
				$library_config_Updated = $db->updateObject('#__content_types', $library_config, 'type_id');
			}
			else
			{
				$library_config_Inserted = $db->insertObject('#__content_types', $library_config);
			}

			// Create the library_files_folders_urls content type object.
			$library_files_folders_urls = new stdClass();
			$library_files_folders_urls->type_title = 'Componentbuilder Library_files_folders_urls';
			$library_files_folders_urls->type_alias = 'com_componentbuilder.library_files_folders_urls';
			$library_files_folders_urls->table = '{"special": {"dbtable": "#__componentbuilder_library_files_folders_urls","key": "id","type": "Library_files_folders_urls","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$library_files_folders_urls->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "library","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"library":"library"}}';
			$library_files_folders_urls->router = 'ComponentbuilderHelperRoute::getLibrary_files_folders_urlsRoute';
			$library_files_folders_urls->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/library_files_folders_urls.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","library"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "library","targetTable": "#__componentbuilder_library","targetColumn": "id","displayColumn": "name"}]}';

			// Check if library_files_folders_urls type is already in content_type DB.
			$library_files_folders_urls_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($library_files_folders_urls->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$library_files_folders_urls->type_id = $db->loadResult();
				$library_files_folders_urls_Updated = $db->updateObject('#__content_types', $library_files_folders_urls, 'type_id');
			}
			else
			{
				$library_files_folders_urls_Inserted = $db->insertObject('#__content_types', $library_files_folders_urls);
			}



			// target version less then 2.6.5
			if ((count($this->JCBversion) == 3 && $this->JCBversion[0] <= 2 && $this->JCBversion[1] <= 6 && (($this->JCBversion[1] == 6 && $this->JCBversion[2] <= 4) || ($this->JCBversion[1] < 6))))
			{
				// add libraries to the snippets
				$libraries = array(
					2 => array('have' => array('getbootstrap.com/docs/4.0', 'v4-alpha.getbootstrap.com')),  // Bootstrap v4
					3 => array('have' => array('getuikit.com/docs/'), 'not' => '.html'),  // Uikit v3
					4 => array('have' => array('getuikit.com/docs/', 'getuikit.com/v2/'), 'and' => '.html'),  // Uikit v2
					5 => array('have' => array('fooplugins.com/footable-demos'))  // FooTable
				);
				// Create a new query object.
				$query = $db->getQuery(true);
				// get all Joomla Component FTP values
				$query->select($db->quoteName(array('id', 'url')));
				$query->from($db->quoteName('#__componentbuilder_snippet'));
				$query->where($db->quoteName('library') . ' < 1'); // only snippets with no lib set
				// Reset the query using our newly populated query object.
				$db->setQuery($query);
				$db->execute();
				if ($db->getNumRows())
				{
					$updater = array();
					$rows = $db->loadObjectList();
					foreach ($rows as $row)
					{
						foreach ($libraries as $id => $library)
						{
							if (!isset($updater[$row->id]) && ComponentbuilderHelper::checkString($row->url))
							{
								foreach($library['have'] as $url)
								{
									if (strpos($row->url, $url) !== false)
									{
										if (isset($library['not']))
										{
											if (strpos($row->url, $library['not']) === false)
											{
												// Create an object.
												$updater[$row->id] = new stdClass();
												$updater[$row->id]->id = $row->id;
												$updater[$row->id]->library = $id;
											}
										}
										elseif (isset($library['and']))
										{
											if (strpos($row->url, $library['and']) !== false)
											{
												// Create an object.
												$updater[$row->id] = new stdClass();
												$updater[$row->id]->id = $row->id;
												$updater[$row->id]->library = $id;
											}
										}
										else
										{
											// Create an object.
											$updater[$row->id] = new stdClass();
											$updater[$row->id]->id = $row->id;
											$updater[$row->id]->library = $id;
										}
									}
								}
							}
						}
						// if still not found
						if (!isset($updater[$row->id]))
						{
							// Create an object.
							$updater[$row->id] = new stdClass();
							$updater[$row->id]->id = $row->id;
							$updater[$row->id]->library = 1; // default (no library)
						}
					}
					// update if set
					if (ComponentbuilderHelper::checkArray($updater))
					{
						foreach($updater as $item)
						{
							// add contributor details to those made by JCB
							if ($item->id < 94)
							{
								$item->contributor_company = 'Vast Development Method';
								$item->contributor_name = 'Llewellyn van der Merwe';
								$item->contributor_email = 'joomla@vdm.io';
								$item->contributor_website = 'https://www.vdm.io/';
							}
							// update the snippets table with the new library ids
							$db->updateObject('#__componentbuilder_snippet', $item, 'id');
						}
					}
				}
			}
			// set some defaults
			if ((isset($this->setFtpValues) && ComponentbuilderHelper::checkArray($this->setFtpValues)) || (isset($this->setMoveValues) && ComponentbuilderHelper::checkArray($this->setMoveValues)))
			{
				// Get the date
				$today = JFactory::getDate()->toSql();
				// Get the user object
				$user = JFactory::getUser();
			}
			// check if we have stuff to move
			if (isset($this->setMoveValues) && ComponentbuilderHelper::checkArray($this->setMoveValues))
			{
				// moving data now... but first check if data not already set
				foreach ($this->setMoveValues as $table => $items)
				{
					if (ComponentbuilderHelper::checkArray($items))
					{
						foreach($items as $item)
						{
							// okay if found ignore move
							if (isset($item->{$this->dynamicTable[$table]}) && $item->{$this->dynamicTable[$table]} > 0 && !ComponentbuilderHelper::getVar($table, (int) $item->{$this->dynamicTable[$table]}, $this->dynamicTable[$table], 'id'))
							{
								$item->published = 1;
								$item->version = 2;
								$item->created = $today;
								$item->created_by = (int) $user->id;
								$done = $db->insertObject('#__componentbuilder_'.$table, $item);
								// update the component if stored
								if ($done)
								{
									// get the last ID
									$newId = $db->insertid();
									// make sure the access of asset is set
									ComponentbuilderHelper::setAsset($newId,$table);
								}
							}
						}
					}
				}
			}
			// check if any links were found
			if (isset($this->setFtpValues) && ComponentbuilderHelper::checkArray($this->setFtpValues))
			{
				// build the storage buckets
				foreach ($this->setFtpValues as $hash => $item)
				{
					// get host name
					$hostusername = ComponentbuilderHelper::getBetween($item['ftp'], 'username=', '&');
					// get key
					$keys = explode('__', $hash);
					$key = $keys[1];
					if (ComponentbuilderHelper::checkString($hostusername) && $hostusername !== 'user@name.com' && strpos($hostusername, '@') !== false && strpos($hostusername, '.') !== false)
					{
						$name = explode('.', $hostusername);
						// Create an object.
						$object = new stdClass();
						$object->signature = $item['signature']; // the still locked version (if there is a basic key)
						$object->name = str_replace('@', ' ', $name[0]);
						$object->published = 1;
						$object->version = 2;
						$object->created = $today;
						$object->created_by = (int) $user->id;
						// safe the FTP server
						$done = $db->insertObject('#__componentbuilder_ftp', $object);
						// update the component if stored
						if ($done)
						{
							// get the last ID
							$newId = $db->insertid();
							// make sure the access of asset is set
							ComponentbuilderHelper::setAsset($newId,'ftp');
							// now update the components
							if (ComponentbuilderHelper::checkArray($item['ids']))
							{
								foreach ($item['ids'] as $compId)
								{
									// Create an object.
									$object = new stdClass();
									$object->id = $compId;
									$object->{$key} = $newId;
									// Update with the object the joomla_component table.
									$db->updateObject('#__componentbuilder_joomla_component', $object, 'id');
								}
							}
						}
					}
					else
					{
						// now update the components
						if (ComponentbuilderHelper::checkArray($item['ids']))
						{
							foreach ($item['ids'] as $compId)
							{
								// Create an object.
								$object = new stdClass();
								$object->id = $compId;
								$object->{$key} = ''; // remove all values to insure stability
								// Insert the object into the joomla_component table.
								$db->updateObject('#__componentbuilder_joomla_component', $object, 'id');
							}
						}
					}
				}
			}
			// check if this install has the libraries in the helper folder, if so remove it
			$vendorPath = JPATH_ADMINISTRATOR . '/components/com_componentbuilder/helpers/vendor';
			if (JFolder::exists($vendorPath))
			{
				ComponentbuilderHelper::removeFolder($vendorPath);
				// set a notice that this was done
				$app->enqueueMessage('<p><b>Best Practice!</b><br />We have removed the composer-vendor folder from the /administrator/components/com_componentbuilder/helpers/ folder and placed it in the /libraries/vdm_io/ folder.</p>', 'Notice');
			}
			echo '<a target="_blank" href="http://joomlacomponentbuilder.com" title="Component Builder">
				<img src="components/com_componentbuilder/assets/images/vdm-component.jpg"/>
				</a>
				<h3>Upgrade to Version 2.7.6 Was Successful! Let us know if anything is not working as expected.</h3>';
		}
	}

	/**
	 * Method to set/copy dynamic folders into place (use with caution)
	 *
	 * @return void
	 */
	protected function setDynamicF0ld3rs($app, $parent)
	{
		// get the instalation path
		$installer = $parent->getParent();
		$installPath = $installer->getPath('source');
		// get all the folders
		$folders = JFolder::folders($installPath);
		// check if we have folders we may want to copy
		$doNotCopy = array('media','admin','site'); // Joomla already deals with these
		if (count($folders) > 1)
		{
			foreach ($folders as $folder)
			{
				// Only copy if not a standard folders
				if (!in_array($folder, $doNotCopy))
				{
					// set the source path
					$src = $installPath.'/'.$folder;
					// set the destination path
					$dest = JPATH_ROOT.'/'.$folder;
					// now try to copy the folder
					if (!JFolder::copy($src, $dest, '', true))
					{
						$app->enqueueMessage('Could not copy '.$folder.' folder into place, please make sure destination is writable!', 'error');
					}
				}
			}
		}
	}
}
