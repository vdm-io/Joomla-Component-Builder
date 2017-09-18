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

	@version		2.5.5
	@build			18th September, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		script.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
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
		// Where Ftp alias is found
		$query->where( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.ftp') );
		$db->setQuery($query);
		// Execute query to see if alias is found
		$db->execute();
		$ftp_found = $db->getNumRows();
		// Now check if there were any rows
		if ($ftp_found)
		{
			// Since there are load the needed  ftp type ids
			$ftp_ids = $db->loadColumn();
			// Remove Ftp from the content type table
			$ftp_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.ftp') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__content_types'));
			$query->where($ftp_condition);
			$db->setQuery($query);
			// Execute the query to remove Ftp items
			$ftp_done = $db->execute();
			if ($ftp_done);
			{
				// If succesfully remove Ftp add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.ftp) type alias was removed from the <b>#__content_type</b> table'));
			}

			// Remove Ftp items from the contentitem tag map table
			$ftp_condition = array( $db->quoteName('type_alias') . ' = '. $db->quote('com_componentbuilder.ftp') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__contentitem_tag_map'));
			$query->where($ftp_condition);
			$db->setQuery($query);
			// Execute the query to remove Ftp items
			$ftp_done = $db->execute();
			if ($ftp_done);
			{
				// If succesfully remove Ftp add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.ftp) type alias was removed from the <b>#__contentitem_tag_map</b> table'));
			}

			// Remove Ftp items from the ucm content table
			$ftp_condition = array( $db->quoteName('core_type_alias') . ' = ' . $db->quote('com_componentbuilder.ftp') );
			// Create a new query object.
			$query = $db->getQuery(true);
			$query->delete($db->quoteName('#__ucm_content'));
			$query->where($ftp_condition);
			$db->setQuery($query);
			// Execute the query to remove Ftp items
			$ftp_done = $db->execute();
			if ($ftp_done);
			{
				// If succesfully remove Ftp add queued success message.
				$app->enqueueMessage(JText::_('The (com_componentbuilder.ftp) type alias was removed from the <b>#__ucm_content</b> table'));
			}

			// Make sure that all the Ftp items are cleared from DB
			foreach ($ftp_ids as $ftp_id)
			{
				// Remove Ftp items from the ucm base table
				$ftp_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $ftp_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_base'));
				$query->where($ftp_condition);
				$db->setQuery($query);
				// Execute the query to remove Ftp items
				$db->execute();

				// Remove Ftp items from the ucm history table
				$ftp_condition = array( $db->quoteName('ucm_type_id') . ' = ' . $ftp_id);
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->delete($db->quoteName('#__ucm_history'));
				$query->where($ftp_condition);
				$db->setQuery($query);
				// Execute the query to remove Ftp items
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
		$help_document_done = $db->execute();
		if ($help_document_done);
		{
			// If succesfully remove componentbuilder add queued success message.
			$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));
		}

		// little notice as after service, in case of bad experience with component.
		echo '<h2>Did something go wrong? Are you disappointed?</h2>
		<p>Please let me know at <a href="mailto:joomla@vdm.io">joomla@vdm.io</a>.
		<br />We at Vast Development Method are committed to building extensions that performs proficiently! You can help us, really!
		<br />Send me your thoughts on improvements that is needed, trust me, I will be very grateful!
		<br />Visit us at <a href="http://vdm.bz/component-builder" target="_blank">http://vdm.bz/component-builder</a> today!</p>';
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
			$version = explode('.', $manifest->version);
			// target version less then 2.5.2
			if (count($version) == 3 && $version[0] <= 2 && $version[1] <= 5 && (($version[1] == 5 && $version[2] <= 1) || ($version[1] < 5)))
			{
				// the set values
				$this->setFtpValues = array();
				// Get a db connection.
				$db = JFactory::getDbo();
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
			// target version less then 2.5.5 (we need to change the language translation values)
			if (count($version) == 3 && $version[0] <= 2 && $version[1] <= 5 && (($version[1] == 5 && $version[2] <= 4) || ($version[1] < 5)))
			{
				// Get a db connection.
				$db = JFactory::getDbo();
				// Create a new query object.
				$query = $db->getQuery(true);
				// update all JCB lang translations
				$query->select($db->quoteName(array('id', 'translation')));
				$query->from($db->quoteName('#__componentbuilder_language_translation'));
				// Reset the query using our newly populated query object.
				$db->setQuery($query);
				$db->execute();
				if ($db->getNumRows())
				{
					$rows = $db->loadObjectList();
					foreach ($rows as $row)
					{
						// check if it has translations
						if (ComponentbuilderHelper::checkJson($row->translation))
						{
							// open the translations and convert
							$translation = json_decode($row->translation, true);
							if (ComponentbuilderHelper::checkArray($translation) 
							&& isset($translation['translation']) && ComponentbuilderHelper::checkArray($translation['translation'])
							&& isset($translation['language']) && ComponentbuilderHelper::checkArray($translation['language']))
							{
								$bucket = array();
								foreach ($translation['translation'] as $nr => $value)
								{
									$bucket['translation' . $nr] = array( 'translation' => $value, 'language' => $translation['language'][$nr] );
								}
								// set the bucket back to translation
								$row->translation = json_encode($bucket);
								$db->updateObject('#__componentbuilder_language_translation', $row, 'id');
							}
							elseif (!ComponentbuilderHelper::checkArray($translation))
							{
								$row->translation = '';
								$db->updateObject('#__componentbuilder_language_translation', $row, 'id');
							}
						}
					}
				}
				// update the properties in the field types
				$query = $db->getQuery(true);
				// update all JCB lang translations
				$query->select($db->quoteName(array('id', 'properties')));
				$query->from($db->quoteName('#__componentbuilder_fieldtype'));
				// Reset the query using our newly populated query object.
				$db->setQuery($query);
				$db->execute();
				if ($db->getNumRows())
				{
					$rows = $db->loadObjectList();
					foreach ($rows as $row)
					{
						// check if it has translations
						if (ComponentbuilderHelper::checkJson($row->properties))
						{
							// open the properties and convert
							$properties = json_decode($row->properties, true);
							if (ComponentbuilderHelper::checkArray($properties) 
							&& isset($properties['name']) && ComponentbuilderHelper::checkArray($properties['name'])
							&& isset($properties['mandatory']) && ComponentbuilderHelper::checkArray($properties['mandatory']))
							{
								$bucket = array();
								foreach ($properties as $key => $values)
								{
									foreach ($values as $nr => $value)
									{
										if (!isset($bucket['properties' . $nr]) || !ComponentbuilderHelper::checkArray($bucket['properties' . $nr]))
										{
											$bucket['properties' . $nr] = array();
										}
										$bucket['properties' . $nr][$key] = $value;
									}
								}
								// set the bucket back to translation
								$row->properties = json_encode($bucket);
								$db->updateObject('#__componentbuilder_fieldtype', $row, 'id');
							}
							elseif (!ComponentbuilderHelper::checkArray($properties))
							{
								$row->properties = '';
								$db->updateObject('#__componentbuilder_fieldtype', $row, 'id');
							}
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
			$joomla_component->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "readme","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","component_version":"component_version","short_description":"short_description","companyname":"companyname","author":"author","readme":"readme","add_placeholders":"add_placeholders","add_php_dashboard_methods":"add_php_dashboard_methods","description":"description","add_php_helper_admin":"add_php_helper_admin","copyright":"copyright","php_postflight_install":"php_postflight_install","debug_linenr":"debug_linenr","mvc_versiondate":"mvc_versiondate","update_server_ftp":"update_server_ftp","add_php_helper_site":"add_php_helper_site","php_preflight_install":"php_preflight_install","creatuserhelper":"creatuserhelper","php_method_uninstall":"php_method_uninstall","css":"css","email":"email","buildcomp":"buildcomp","website":"website","export_package_link":"export_package_link","add_license":"add_license","addfootable":"addfootable","license_type":"license_type","add_php_helper_both":"add_php_helper_both","add_admin_event":"add_admin_event","whmcs_key":"whmcs_key","add_site_event":"add_site_event","whmcs_url":"whmcs_url","license":"license","php_preflight_update":"php_preflight_update","bom":"bom","php_postflight_update":"php_postflight_update","image":"image","sql":"sql","update_server_target":"update_server_target","add_update_server":"add_update_server","not_required":"not_required","sales_server_ftp":"sales_server_ftp","name":"name","export_key":"export_key","export_buy_link":"export_buy_link","adduikit":"adduikit","add_css":"add_css","add_email_helper":"add_email_helper","php_helper_both":"php_helper_both","php_helper_admin":"php_helper_admin","php_admin_event":"php_admin_event","php_helper_site":"php_helper_site","php_site_event":"php_site_event","php_dashboard_methods":"php_dashboard_methods","add_php_preflight_install":"add_php_preflight_install","add_php_preflight_update":"add_php_preflight_update","emptycontributors":"emptycontributors","add_php_postflight_install":"add_php_postflight_install","number":"number","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","add_sql":"add_sql","addreadme":"addreadme","update_server":"update_server","add_sales_server":"add_sales_server","toignore":"toignore","buildcompsql":"buildcompsql"}}';
			$joomla_component->router = 'ComponentbuilderHelperRoute::getJoomla_componentRoute';
			$joomla_component->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_placeholders","add_php_dashboard_methods","add_php_helper_admin","debug_linenr","mvc_versiondate","update_server_ftp","add_php_helper_site","creatuserhelper","buildcomp","add_license","addfootable","license_type","add_php_helper_both","add_admin_event","add_site_event","update_server_target","add_update_server","not_required","sales_server_ftp","adduikit","add_css","add_email_helper","add_php_preflight_install","add_php_preflight_update","emptycontributors","add_php_postflight_install","number","add_php_postflight_update","add_php_method_uninstall","add_sql","addreadme","add_sales_server"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server_ftp","targetTable": "#__componentbuilder_ftp","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server_ftp","targetTable": "#__componentbuilder_ftp","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$joomla_component_Inserted = $db->insertObject('#__content_types', $joomla_component);

			// Create the admin_view content type object.
			$admin_view = new stdClass();
			$admin_view->type_title = 'Componentbuilder Admin_view';
			$admin_view->type_alias = 'com_componentbuilder.admin_view';
			$admin_view->table = '{"special": {"dbtable": "#__componentbuilder_admin_view","key": "id","type": "Admin_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","name_list":"name_list","short_description":"short_description","php_batchmove":"php_batchmove","type":"type","php_save":"php_save","description":"description","php_after_delete":"php_after_delete","add_fadein":"add_fadein","icon":"icon","php_getlistquery":"php_getlistquery","icon_add":"icon_add","php_allowedit":"php_allowedit","icon_category":"icon_category","php_after_publish":"php_after_publish","source":"source","php_getitems":"php_getitems","php_import":"php_import","php_getitems_after_all":"php_getitems_after_all","php_before_save":"php_before_save","php_postsavehook":"php_postsavehook","php_batchcopy":"php_batchcopy","php_before_publish":"php_before_publish","php_before_delete":"php_before_delete","php_document":"php_document","sql":"sql","not_required":"not_required","php_import_display":"php_import_display","php_getitem":"php_getitem","php_import_save":"php_import_save","add_css_view":"add_css_view","css_view":"css_view","add_php_getitems":"add_php_getitems","add_css_views":"add_css_views","add_php_getitems_after_all":"add_php_getitems_after_all","css_views":"css_views","add_php_getlistquery":"add_php_getlistquery","add_javascript_view_file":"add_javascript_view_file","add_php_before_save":"add_php_before_save","javascript_view_file":"javascript_view_file","add_php_save":"add_php_save","add_javascript_view_footer":"add_javascript_view_footer","add_php_postsavehook":"add_php_postsavehook","javascript_view_footer":"javascript_view_footer","add_php_allowedit":"add_php_allowedit","add_javascript_views_file":"add_javascript_views_file","add_php_batchcopy":"add_php_batchcopy","javascript_views_file":"javascript_views_file","add_php_batchmove":"add_php_batchmove","add_javascript_views_footer":"add_javascript_views_footer","add_php_before_publish":"add_php_before_publish","javascript_views_footer":"javascript_views_footer","add_php_after_publish":"add_php_after_publish","add_custom_button":"add_custom_button","add_php_before_delete":"add_php_before_delete","add_php_after_delete":"add_php_after_delete","php_controller":"php_controller","add_php_document":"add_php_document","php_model":"php_model","add_sql":"add_sql","php_controller_list":"php_controller_list","php_model_list":"php_model_list","add_php_ajax":"add_php_ajax","add_custom_import":"add_custom_import","php_ajaxmethod":"php_ajaxmethod","html_import_view":"html_import_view","php_import_setdata":"php_import_setdata","add_php_getitem":"add_php_getitem","php_import_ext":"php_import_ext"}}';
			$admin_view->router = 'ComponentbuilderHelperRoute::getAdmin_viewRoute';
			$admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","add_fadein","source","not_required","add_css_view","add_php_getitems","add_css_views","add_php_getitems_after_all","add_php_getlistquery","add_javascript_view_file","add_php_before_save","add_php_save","add_javascript_view_footer","add_php_postsavehook","add_php_allowedit","add_javascript_views_file","add_php_batchcopy","add_php_batchmove","add_javascript_views_footer","add_php_before_publish","add_php_after_publish","add_custom_button","add_php_before_delete","add_php_after_delete","add_php_document","add_sql","add_php_ajax","add_custom_import","add_php_getitem"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$admin_view_Inserted = $db->insertObject('#__content_types', $admin_view);

			// Create the custom_admin_view content type object.
			$custom_admin_view = new stdClass();
			$custom_admin_view->type_title = 'Componentbuilder Custom_admin_view';
			$custom_admin_view->type_alias = 'com_componentbuilder.custom_admin_view';
			$custom_admin_view->table = '{"special": {"dbtable": "#__componentbuilder_custom_admin_view","key": "id","type": "Custom_admin_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$custom_admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","php_model":"php_model","css_document":"css_document","php_jview":"php_jview","php_view":"php_view","php_document":"php_document","php_jview_display":"php_jview_display","icon":"icon","js_document":"js_document","css":"css","custom_get":"custom_get","main_get":"main_get","add_php_document":"add_php_document","dynamic_get":"dynamic_get","add_php_view":"add_php_view","add_php_jview_display":"add_php_jview_display","add_php_jview":"add_php_jview","default":"default","add_js_document":"add_js_document","add_custom_button":"add_custom_button","add_css_document":"add_css_document","add_css":"add_css","php_controller":"php_controller","not_required":"not_required"}}';
			$custom_admin_view->router = 'ComponentbuilderHelperRoute::getCustom_admin_viewRoute';
			$custom_admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/custom_admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","main_get","add_php_document","dynamic_get","add_php_view","add_php_jview_display","add_php_jview","add_js_document","add_custom_button","add_css_document","add_css","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$custom_admin_view_Inserted = $db->insertObject('#__content_types', $custom_admin_view);

			// Create the site_view content type object.
			$site_view = new stdClass();
			$site_view->type_title = 'Componentbuilder Site_view';
			$site_view->type_alias = 'com_componentbuilder.site_view';
			$site_view->table = '{"special": {"dbtable": "#__componentbuilder_site_view","key": "id","type": "Site_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$site_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","css":"css","add_php_document":"add_php_document","js_document":"js_document","css_document":"css_document","default":"default","php_ajaxmethod":"php_ajaxmethod","add_php_jview_display":"add_php_jview_display","add_php_view":"add_php_view","php_model":"php_model","add_php_jview":"add_php_jview","not_required":"not_required","custom_get":"custom_get","add_js_document":"add_js_document","main_get":"main_get","add_css_document":"add_css_document","dynamic_get":"dynamic_get","add_css":"add_css","add_php_ajax":"add_php_ajax","button_position":"button_position","add_custom_button":"add_custom_button","php_document":"php_document","php_view":"php_view","php_jview_display":"php_jview_display","php_controller":"php_controller","php_jview":"php_jview"}}';
			$site_view->router = 'ComponentbuilderHelperRoute::getSite_viewRoute';
			$site_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/site_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_document","add_php_jview_display","add_php_view","add_php_jview","not_required","add_js_document","main_get","add_css_document","dynamic_get","add_css","add_php_ajax","button_position","add_custom_button"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$site_view_Inserted = $db->insertObject('#__content_types', $site_view);

			// Create the template content type object.
			$template = new stdClass();
			$template->type_title = 'Componentbuilder Template';
			$template->type_alias = 'com_componentbuilder.template';
			$template->table = '{"special": {"dbtable": "#__componentbuilder_template","key": "id","type": "Template","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$template->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","snippet":"snippet","template":"template","php_view":"php_view","add_php_view":"add_php_view","dynamic_get":"dynamic_get","not_required":"not_required"}}';
			$template->router = 'ComponentbuilderHelperRoute::getTemplateRoute';
			$template->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/template.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_view","dynamic_get","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$template_Inserted = $db->insertObject('#__content_types', $template);

			// Create the layout content type object.
			$layout = new stdClass();
			$layout->type_title = 'Componentbuilder Layout';
			$layout->type_alias = 'com_componentbuilder.layout';
			$layout->table = '{"special": {"dbtable": "#__componentbuilder_layout","key": "id","type": "Layout","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$layout->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","add_php_view":"add_php_view","layout":"layout","not_required":"not_required","php_view":"php_view"}}';
			$layout->router = 'ComponentbuilderHelperRoute::getLayoutRoute';
			$layout->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/layout.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","dynamic_get","snippet","add_php_view","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$layout_Inserted = $db->insertObject('#__content_types', $layout);

			// Create the dynamic_get content type object.
			$dynamic_get = new stdClass();
			$dynamic_get->type_title = 'Componentbuilder Dynamic_get';
			$dynamic_get->type_alias = 'com_componentbuilder.dynamic_get';
			$dynamic_get->table = '{"special": {"dbtable": "#__componentbuilder_dynamic_get","key": "id","type": "Dynamic_get","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$dynamic_get->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","add_php_before_getitem":"add_php_before_getitem","add_php_after_getitems":"add_php_after_getitems","db_selection":"db_selection","add_php_getlistquery":"add_php_getlistquery","view_table_main":"view_table_main","add_php_after_getitem":"add_php_after_getitem","add_php_before_getitems":"add_php_before_getitems","db_table_main":"db_table_main","not_required":"not_required","php_before_getitem":"php_before_getitem","php_custom_get":"php_custom_get","php_after_getitem":"php_after_getitem","view_selection":"view_selection","php_getlistquery":"php_getlistquery","addcalculation":"addcalculation","php_before_getitems":"php_before_getitems","php_after_getitems":"php_after_getitems","getcustom":"getcustom","pagination":"pagination","php_calculation":"php_calculation"}}';
			$dynamic_get->router = 'ComponentbuilderHelperRoute::getDynamic_getRoute';
			$dynamic_get->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","main_source","gettype","add_php_before_getitem","add_php_after_getitems","add_php_getlistquery","view_table_main","add_php_after_getitem","add_php_before_getitems","not_required","pagination"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$dynamic_get_Inserted = $db->insertObject('#__content_types', $dynamic_get);

			// Create the custom_code content type object.
			$custom_code = new stdClass();
			$custom_code->type_title = 'Componentbuilder Custom_code';
			$custom_code->type_alias = 'com_componentbuilder.custom_code';
			$custom_code->table = '{"special": {"dbtable": "#__componentbuilder_custom_code","key": "id","type": "Custom_code","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$custom_code->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","hashtarget":"hashtarget","code":"code","hashendtarget":"hashendtarget","to_line":"to_line","function_name":"function_name","from_line":"from_line","system_name":"system_name","not_required":"not_required"}}';
			$custom_code->router = 'ComponentbuilderHelperRoute::getCustom_codeRoute';
			$custom_code->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/custom_code.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","component","target","type","comment_type","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "component","targetTable": "#__componentbuilder_joomla_component","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$custom_code_Inserted = $db->insertObject('#__content_types', $custom_code);

			// Create the snippet content type object.
			$snippet = new stdClass();
			$snippet->type_title = 'Componentbuilder Snippet';
			$snippet->type_alias = 'com_componentbuilder.snippet';
			$snippet->table = '{"special": {"dbtable": "#__componentbuilder_snippet","key": "id","type": "Snippet","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$snippet->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","url":"url","type":"type","heading":"heading","description":"description","usage":"usage","snippet":"snippet"}}';
			$snippet->router = 'ComponentbuilderHelperRoute::getSnippetRoute';
			$snippet->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/snippet.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$snippet_Inserted = $db->insertObject('#__content_types', $snippet);

			// Create the field content type object.
			$field = new stdClass();
			$field->type_title = 'Componentbuilder Field';
			$field->type_alias = 'com_componentbuilder.field';
			$field->table = '{"special": {"dbtable": "#__componentbuilder_field","key": "id","type": "Field","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$field->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","datalenght_other":"datalenght_other","datadefault":"datadefault","add_css_view":"add_css_view","datadefault_other":"datadefault_other","datalenght":"datalenght","add_css_views":"add_css_views","add_javascript_view_footer":"add_javascript_view_footer","xml":"xml","add_javascript_views_footer":"add_javascript_views_footer","not_required":"not_required","css_view":"css_view","css_views":"css_views","store":"store","javascript_view_footer":"javascript_view_footer","javascript_views_footer":"javascript_views_footer"}}';
			$field->router = 'ComponentbuilderHelperRoute::getFieldRoute';
			$field->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","fieldtype","add_css_view","add_css_views","add_javascript_view_footer","add_javascript_views_footer","not_required","catid","store"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}';

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
			$language_translation->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "entranslation","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"entranslation":"entranslation","components":"components"}}';
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

			// Create the ftp content type object.
			$ftp = new stdClass();
			$ftp->type_title = 'Componentbuilder Ftp';
			$ftp->type_alias = 'com_componentbuilder.ftp';
			$ftp->table = '{"special": {"dbtable": "#__componentbuilder_ftp","key": "id","type": "Ftp","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$ftp->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","signature":"signature"}}';
			$ftp->router = 'ComponentbuilderHelperRoute::getFtpRoute';
			$ftp->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/ftp.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$ftp_Inserted = $db->insertObject('#__content_types', $ftp);

			// Create the help_document content type object.
			$help_document = new stdClass();
			$help_document->type_title = 'Componentbuilder Help_document';
			$help_document->type_alias = 'com_componentbuilder.help_document';
			$help_document->table = '{"special": {"dbtable": "#__componentbuilder_help_document","key": "id","type": "Help_document","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$help_document->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "title","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "content","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "null","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"title":"title","type":"type","groups":"groups","location":"location","admin_view":"admin_view","site_view":"site_view","target":"target","content":"content","alias":"alias","article":"article","url":"url","not_required":"not_required"}}';
			$help_document->router = 'ComponentbuilderHelperRoute::getHelp_documentRoute';
			$help_document->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/help_document.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","location","target","article","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "article","targetTable": "#__content","targetColumn": "id","displayColumn": "title"}]}';

			// Set the object into the content types table.
			$help_document_Inserted = $db->insertObject('#__content_types', $help_document);


			// Install the global extenstion params.
			$query = $db->getQuery(true);
			// Field to update.
			$fields = array(
				$db->quoteName('params') . ' = ' . $db->quote('{"autorName":"Llewellyn van der Merwe","autorEmail":"joomla@vdm.io","minify":"0","percentagelanguageadd":"50","backup_package_name":"JCB_Backup_[YEAR]_[MONTH]_[DAY]","export_license":"GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html","export_copyright":"Copyright (C) 2015. All Rights Reserved","check_in":"-1 day","save_history":"1","history_limit":"10","uikit_load":"1","uikit_min":"","uikit_style":""}'),
			);
			// Condition.
			$conditions = array(
				$db->quoteName('element') . ' = ' . $db->quote('com_componentbuilder')
			);
			$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();

			echo '<a target="_blank" href="http://vdm.bz/component-builder" title="Component Builder">
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
			$joomla_component->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "readme","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","component_version":"component_version","short_description":"short_description","companyname":"companyname","author":"author","readme":"readme","add_placeholders":"add_placeholders","add_php_dashboard_methods":"add_php_dashboard_methods","description":"description","add_php_helper_admin":"add_php_helper_admin","copyright":"copyright","php_postflight_install":"php_postflight_install","debug_linenr":"debug_linenr","mvc_versiondate":"mvc_versiondate","update_server_ftp":"update_server_ftp","add_php_helper_site":"add_php_helper_site","php_preflight_install":"php_preflight_install","creatuserhelper":"creatuserhelper","php_method_uninstall":"php_method_uninstall","css":"css","email":"email","buildcomp":"buildcomp","website":"website","export_package_link":"export_package_link","add_license":"add_license","addfootable":"addfootable","license_type":"license_type","add_php_helper_both":"add_php_helper_both","add_admin_event":"add_admin_event","whmcs_key":"whmcs_key","add_site_event":"add_site_event","whmcs_url":"whmcs_url","license":"license","php_preflight_update":"php_preflight_update","bom":"bom","php_postflight_update":"php_postflight_update","image":"image","sql":"sql","update_server_target":"update_server_target","add_update_server":"add_update_server","not_required":"not_required","sales_server_ftp":"sales_server_ftp","name":"name","export_key":"export_key","export_buy_link":"export_buy_link","adduikit":"adduikit","add_css":"add_css","add_email_helper":"add_email_helper","php_helper_both":"php_helper_both","php_helper_admin":"php_helper_admin","php_admin_event":"php_admin_event","php_helper_site":"php_helper_site","php_site_event":"php_site_event","php_dashboard_methods":"php_dashboard_methods","add_php_preflight_install":"add_php_preflight_install","add_php_preflight_update":"add_php_preflight_update","emptycontributors":"emptycontributors","add_php_postflight_install":"add_php_postflight_install","number":"number","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","add_sql":"add_sql","addreadme":"addreadme","update_server":"update_server","add_sales_server":"add_sales_server","toignore":"toignore","buildcompsql":"buildcompsql"}}';
			$joomla_component->router = 'ComponentbuilderHelperRoute::getJoomla_componentRoute';
			$joomla_component->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_placeholders","add_php_dashboard_methods","add_php_helper_admin","debug_linenr","mvc_versiondate","update_server_ftp","add_php_helper_site","creatuserhelper","buildcomp","add_license","addfootable","license_type","add_php_helper_both","add_admin_event","add_site_event","update_server_target","add_update_server","not_required","sales_server_ftp","adduikit","add_css","add_email_helper","add_php_preflight_install","add_php_preflight_update","emptycontributors","add_php_postflight_install","number","add_php_postflight_update","add_php_method_uninstall","add_sql","addreadme","add_sales_server"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "update_server_ftp","targetTable": "#__componentbuilder_ftp","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "sales_server_ftp","targetTable": "#__componentbuilder_ftp","targetColumn": "id","displayColumn": "name"}]}';

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
			$admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","name_list":"name_list","short_description":"short_description","php_batchmove":"php_batchmove","type":"type","php_save":"php_save","description":"description","php_after_delete":"php_after_delete","add_fadein":"add_fadein","icon":"icon","php_getlistquery":"php_getlistquery","icon_add":"icon_add","php_allowedit":"php_allowedit","icon_category":"icon_category","php_after_publish":"php_after_publish","source":"source","php_getitems":"php_getitems","php_import":"php_import","php_getitems_after_all":"php_getitems_after_all","php_before_save":"php_before_save","php_postsavehook":"php_postsavehook","php_batchcopy":"php_batchcopy","php_before_publish":"php_before_publish","php_before_delete":"php_before_delete","php_document":"php_document","sql":"sql","not_required":"not_required","php_import_display":"php_import_display","php_getitem":"php_getitem","php_import_save":"php_import_save","add_css_view":"add_css_view","css_view":"css_view","add_php_getitems":"add_php_getitems","add_css_views":"add_css_views","add_php_getitems_after_all":"add_php_getitems_after_all","css_views":"css_views","add_php_getlistquery":"add_php_getlistquery","add_javascript_view_file":"add_javascript_view_file","add_php_before_save":"add_php_before_save","javascript_view_file":"javascript_view_file","add_php_save":"add_php_save","add_javascript_view_footer":"add_javascript_view_footer","add_php_postsavehook":"add_php_postsavehook","javascript_view_footer":"javascript_view_footer","add_php_allowedit":"add_php_allowedit","add_javascript_views_file":"add_javascript_views_file","add_php_batchcopy":"add_php_batchcopy","javascript_views_file":"javascript_views_file","add_php_batchmove":"add_php_batchmove","add_javascript_views_footer":"add_javascript_views_footer","add_php_before_publish":"add_php_before_publish","javascript_views_footer":"javascript_views_footer","add_php_after_publish":"add_php_after_publish","add_custom_button":"add_custom_button","add_php_before_delete":"add_php_before_delete","add_php_after_delete":"add_php_after_delete","php_controller":"php_controller","add_php_document":"add_php_document","php_model":"php_model","add_sql":"add_sql","php_controller_list":"php_controller_list","php_model_list":"php_model_list","add_php_ajax":"add_php_ajax","add_custom_import":"add_custom_import","php_ajaxmethod":"php_ajaxmethod","html_import_view":"html_import_view","php_import_setdata":"php_import_setdata","add_php_getitem":"add_php_getitem","php_import_ext":"php_import_ext"}}';
			$admin_view->router = 'ComponentbuilderHelperRoute::getAdmin_viewRoute';
			$admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","add_fadein","source","not_required","add_css_view","add_php_getitems","add_css_views","add_php_getitems_after_all","add_php_getlistquery","add_javascript_view_file","add_php_before_save","add_php_save","add_javascript_view_footer","add_php_postsavehook","add_php_allowedit","add_javascript_views_file","add_php_batchcopy","add_php_batchmove","add_javascript_views_footer","add_php_before_publish","add_php_after_publish","add_custom_button","add_php_before_delete","add_php_after_delete","add_php_document","add_sql","add_php_ajax","add_custom_import","add_php_getitem"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

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
			$custom_admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","php_model":"php_model","css_document":"css_document","php_jview":"php_jview","php_view":"php_view","php_document":"php_document","php_jview_display":"php_jview_display","icon":"icon","js_document":"js_document","css":"css","custom_get":"custom_get","main_get":"main_get","add_php_document":"add_php_document","dynamic_get":"dynamic_get","add_php_view":"add_php_view","add_php_jview_display":"add_php_jview_display","add_php_jview":"add_php_jview","default":"default","add_js_document":"add_js_document","add_custom_button":"add_custom_button","add_css_document":"add_css_document","add_css":"add_css","php_controller":"php_controller","not_required":"not_required"}}';
			$custom_admin_view->router = 'ComponentbuilderHelperRoute::getCustom_admin_viewRoute';
			$custom_admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/custom_admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","main_get","add_php_document","dynamic_get","add_php_view","add_php_jview_display","add_php_jview","add_js_document","add_custom_button","add_css_document","add_css","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

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
			$site_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name":"name","codename":"codename","description":"description","snippet":"snippet","css":"css","add_php_document":"add_php_document","js_document":"js_document","css_document":"css_document","default":"default","php_ajaxmethod":"php_ajaxmethod","add_php_jview_display":"add_php_jview_display","add_php_view":"add_php_view","php_model":"php_model","add_php_jview":"add_php_jview","not_required":"not_required","custom_get":"custom_get","add_js_document":"add_js_document","main_get":"main_get","add_css_document":"add_css_document","dynamic_get":"dynamic_get","add_css":"add_css","add_php_ajax":"add_php_ajax","button_position":"button_position","add_custom_button":"add_custom_button","php_document":"php_document","php_view":"php_view","php_jview_display":"php_jview_display","php_controller":"php_controller","php_jview":"php_jview"}}';
			$site_view->router = 'ComponentbuilderHelperRoute::getSite_viewRoute';
			$site_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/site_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_document","add_php_jview_display","add_php_view","add_php_jview","not_required","add_js_document","main_get","add_css_document","dynamic_get","add_css","add_php_ajax","button_position","add_custom_button"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "custom_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "main_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

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
			$template->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","snippet":"snippet","template":"template","php_view":"php_view","add_php_view":"add_php_view","dynamic_get":"dynamic_get","not_required":"not_required"}}';
			$template->router = 'ComponentbuilderHelperRoute::getTemplateRoute';
			$template->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/template.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","snippet","add_php_view","dynamic_get","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"}]}';

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
			$layout->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","add_php_view":"add_php_view","layout":"layout","not_required":"not_required","php_view":"php_view"}}';
			$layout->router = 'ComponentbuilderHelperRoute::getLayoutRoute';
			$layout->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/layout.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","dynamic_get","snippet","add_php_view","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"}]}';

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
			$dynamic_get->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","add_php_before_getitem":"add_php_before_getitem","add_php_after_getitems":"add_php_after_getitems","db_selection":"db_selection","add_php_getlistquery":"add_php_getlistquery","view_table_main":"view_table_main","add_php_after_getitem":"add_php_after_getitem","add_php_before_getitems":"add_php_before_getitems","db_table_main":"db_table_main","not_required":"not_required","php_before_getitem":"php_before_getitem","php_custom_get":"php_custom_get","php_after_getitem":"php_after_getitem","view_selection":"view_selection","php_getlistquery":"php_getlistquery","addcalculation":"addcalculation","php_before_getitems":"php_before_getitems","php_after_getitems":"php_after_getitems","getcustom":"getcustom","pagination":"pagination","php_calculation":"php_calculation"}}';
			$dynamic_get->router = 'ComponentbuilderHelperRoute::getDynamic_getRoute';
			$dynamic_get->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","main_source","gettype","add_php_before_getitem","add_php_after_getitems","add_php_getlistquery","view_table_main","add_php_after_getitem","add_php_before_getitems","not_required","pagination"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

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
			$custom_code->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","hashtarget":"hashtarget","code":"code","hashendtarget":"hashendtarget","to_line":"to_line","function_name":"function_name","from_line":"from_line","system_name":"system_name","not_required":"not_required"}}';
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

			// Create the snippet content type object.
			$snippet = new stdClass();
			$snippet->type_title = 'Componentbuilder Snippet';
			$snippet->type_alias = 'com_componentbuilder.snippet';
			$snippet->table = '{"special": {"dbtable": "#__componentbuilder_snippet","key": "id","type": "Snippet","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$snippet->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","url":"url","type":"type","heading":"heading","description":"description","usage":"usage","snippet":"snippet"}}';
			$snippet->router = 'ComponentbuilderHelperRoute::getSnippetRoute';
			$snippet->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/snippet.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

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

			// Create the field content type object.
			$field = new stdClass();
			$field->type_title = 'Componentbuilder Field';
			$field->type_alias = 'com_componentbuilder.field';
			$field->table = '{"special": {"dbtable": "#__componentbuilder_field","key": "id","type": "Field","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$field->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","datalenght_other":"datalenght_other","datadefault":"datadefault","add_css_view":"add_css_view","datadefault_other":"datadefault_other","datalenght":"datalenght","add_css_views":"add_css_views","add_javascript_view_footer":"add_javascript_view_footer","xml":"xml","add_javascript_views_footer":"add_javascript_views_footer","not_required":"not_required","css_view":"css_view","css_views":"css_views","store":"store","javascript_view_footer":"javascript_view_footer","javascript_views_footer":"javascript_views_footer"}}';
			$field->router = 'ComponentbuilderHelperRoute::getFieldRoute';
			$field->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","fieldtype","add_css_view","add_css_views","add_javascript_view_footer","add_javascript_views_footer","not_required","catid","store"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}';

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
			$language_translation->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "entranslation","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"entranslation":"entranslation","components":"components"}}';
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

			// Create the ftp content type object.
			$ftp = new stdClass();
			$ftp->type_title = 'Componentbuilder Ftp';
			$ftp->type_alias = 'com_componentbuilder.ftp';
			$ftp->table = '{"special": {"dbtable": "#__componentbuilder_ftp","key": "id","type": "Ftp","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$ftp->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","signature":"signature"}}';
			$ftp->router = 'ComponentbuilderHelperRoute::getFtpRoute';
			$ftp->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/ftp.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Check if ftp type is already in content_type DB.
			$ftp_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($ftp->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$ftp->type_id = $db->loadResult();
				$ftp_Updated = $db->updateObject('#__content_types', $ftp, 'type_id');
			}
			else
			{
				$ftp_Inserted = $db->insertObject('#__content_types', $ftp);
			}

			// Create the help_document content type object.
			$help_document = new stdClass();
			$help_document->type_title = 'Componentbuilder Help_document';
			$help_document->type_alias = 'com_componentbuilder.help_document';
			$help_document->table = '{"special": {"dbtable": "#__componentbuilder_help_document","key": "id","type": "Help_document","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$help_document->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "title","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "content","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "null","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"title":"title","type":"type","groups":"groups","location":"location","admin_view":"admin_view","site_view":"site_view","target":"target","content":"content","alias":"alias","article":"article","url":"url","not_required":"not_required"}}';
			$help_document->router = 'ComponentbuilderHelperRoute::getHelp_documentRoute';
			$help_document->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/help_document.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","type","location","target","article","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "article","targetTable": "#__content","targetColumn": "id","displayColumn": "title"}]}';

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



			// check if any links were found
			if (isset($this->setFtpValues) && ComponentbuilderHelper::checkArray($this->setFtpValues))
			{
				// Get a db connection.
				$db = JFactory::getDbo();
				// Get the date
				$today = JFactory::getDate()->toSql();
				// Get the user object
				$user = JFactory::getUser();
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
			echo '<a target="_blank" href="http://vdm.bz/component-builder" title="Component Builder">
				<img src="components/com_componentbuilder/assets/images/vdm-component.jpg"/>
				</a>
				<h3>Upgrade to Version 2.5.5 Was Successful! Let us know if anything is not working as expected.</h3>';
		}
	}
}
