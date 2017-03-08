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

	@version		2.3.6
	@build			8th March, 2017
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
			$joomla_component->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "readme","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","component_version":"component_version","short_description":"short_description","companyname":"companyname","author":"author","add_php_dashboard_methods":"add_php_dashboard_methods","add_sales_server":"add_sales_server","update_server_ftp":"update_server_ftp","sales_server_ftp":"sales_server_ftp","readme":"readme","name":"name","adduikit":"adduikit","copyright":"copyright","add_php_helper_site":"add_php_helper_site","add_email_helper":"add_email_helper","buildcomp":"buildcomp","php_postflight_update":"php_postflight_update","buildcompsql":"buildcompsql","php_preflight_update":"php_preflight_update","debug_linenr":"debug_linenr","add_placeholders":"add_placeholders","add_admin_event":"add_admin_event","mvc_versiondate":"mvc_versiondate","add_site_event":"add_site_event","update_server":"update_server","description":"description","php_helper_both":"php_helper_both","update_server_target":"update_server_target","php_postflight_install":"php_postflight_install","license":"license","php_method_uninstall":"php_method_uninstall","bom":"bom","php_preflight_install":"php_preflight_install","image":"image","sql":"sql","number":"number","add_update_server":"add_update_server","creatuserhelper":"creatuserhelper","emptycontributors":"emptycontributors","email":"email","website":"website","add_license":"add_license","license_type":"license_type","php_helper_admin":"php_helper_admin","php_admin_event":"php_admin_event","whmcs_key":"whmcs_key","php_helper_site":"php_helper_site","whmcs_url":"whmcs_url","php_site_event":"php_site_event","add_css":"add_css","addfootable":"addfootable","not_required":"not_required","css":"css","add_php_helper_both":"add_php_helper_both","add_php_helper_admin":"add_php_helper_admin","add_php_postflight_install":"add_php_postflight_install","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","php_dashboard_methods":"php_dashboard_methods","add_php_preflight_install":"add_php_preflight_install","add_php_preflight_update":"add_php_preflight_update","add_sql":"add_sql","addreadme":"addreadme"}}';
			$joomla_component->router = 'ComponentbuilderHelperRoute::getJoomla_componentRoute';
			$joomla_component->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_php_dashboard_methods","add_sales_server","adduikit","add_php_helper_site","add_email_helper","buildcomp","debug_linenr","add_placeholders","add_admin_event","mvc_versiondate","add_site_event","update_server_target","number","add_update_server","creatuserhelper","emptycontributors","add_license","license_type","add_css","addfootable","not_required","add_php_helper_both","add_php_helper_admin","add_php_postflight_install","add_php_postflight_update","add_php_method_uninstall","add_php_preflight_install","add_php_preflight_update","add_sql","addreadme"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$joomla_component_Inserted = $db->insertObject('#__content_types', $joomla_component);

			// Create the admin_view content type object.
			$admin_view = new stdClass();
			$admin_view->type_title = 'Componentbuilder Admin_view';
			$admin_view->type_alias = 'com_componentbuilder.admin_view';
			$admin_view->table = '{"special": {"dbtable": "#__componentbuilder_admin_view","key": "id","type": "Admin_view","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","name_list":"name_list","short_description":"short_description","add_php_getitems_after_all":"add_php_getitems_after_all","add_php_after_publish":"add_php_after_publish","description":"description","add_fadein":"add_fadein","add_php_allowedit":"add_php_allowedit","icon":"icon","add_sql":"add_sql","icon_add":"icon_add","icon_category":"icon_category","add_php_save":"add_php_save","add_php_batchmove":"add_php_batchmove","add_php_after_delete":"add_php_after_delete","add_php_getitems":"add_php_getitems","add_php_getlistquery":"add_php_getlistquery","add_php_postsavehook":"add_php_postsavehook","add_php_batchcopy":"add_php_batchcopy","add_php_before_publish":"add_php_before_publish","add_php_before_delete":"add_php_before_delete","html_import_view":"html_import_view","add_php_document":"add_php_document","type":"type","add_php_getitem":"add_php_getitem","add_custom_import":"add_custom_import","not_required":"not_required","php_import_setdata":"php_import_setdata","add_css_view":"add_css_view","css_view":"css_view","php_getitem":"php_getitem","add_css_views":"add_css_views","php_getitems":"php_getitems","css_views":"css_views","php_getitems_after_all":"php_getitems_after_all","add_javascript_view_file":"add_javascript_view_file","php_getlistquery":"php_getlistquery","javascript_view_file":"javascript_view_file","php_save":"php_save","add_javascript_view_footer":"add_javascript_view_footer","php_postsavehook":"php_postsavehook","javascript_view_footer":"javascript_view_footer","php_allowedit":"php_allowedit","add_javascript_views_file":"add_javascript_views_file","php_batchcopy":"php_batchcopy","javascript_views_file":"javascript_views_file","php_batchmove":"php_batchmove","add_javascript_views_footer":"add_javascript_views_footer","php_before_publish":"php_before_publish","javascript_views_footer":"javascript_views_footer","php_after_publish":"php_after_publish","add_custom_button":"add_custom_button","php_before_delete":"php_before_delete","php_after_delete":"php_after_delete","php_controller":"php_controller","php_document":"php_document","php_controller_list":"php_controller_list","source":"source","php_model":"php_model","sql":"sql","php_model_list":"php_model_list","add_php_ajax":"add_php_ajax","php_import_display":"php_import_display","php_ajaxmethod":"php_ajaxmethod","php_import":"php_import","php_import_save":"php_import_save"}}';
			$admin_view->router = 'ComponentbuilderHelperRoute::getAdmin_viewRoute';
			$admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_php_getitems_after_all","add_php_after_publish","add_fadein","add_php_allowedit","add_sql","add_php_save","add_php_batchmove","add_php_after_delete","add_php_getitems","add_php_getlistquery","add_php_postsavehook","add_php_batchcopy","add_php_before_publish","add_php_before_delete","add_php_document","type","add_php_getitem","add_custom_import","not_required","add_css_view","add_css_views","add_javascript_view_file","add_javascript_view_footer","add_javascript_views_file","add_javascript_views_footer","add_custom_button","source","add_php_ajax"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

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
			$layout->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","php_view":"php_view","layout":"layout","add_php_view":"add_php_view","not_required":"not_required"}}';
			$layout->router = 'ComponentbuilderHelperRoute::getLayoutRoute';
			$layout->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/layout.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","dynamic_get","snippet","add_php_view","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "dynamic_get","targetTable": "#__componentbuilder_dynamic_get","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "snippet","targetTable": "#__componentbuilder_snippet","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$layout_Inserted = $db->insertObject('#__content_types', $layout);

			// Create the dynamic_get content type object.
			$dynamic_get = new stdClass();
			$dynamic_get->type_title = 'Componentbuilder Dynamic_get';
			$dynamic_get->type_alias = 'com_componentbuilder.dynamic_get';
			$dynamic_get->table = '{"special": {"dbtable": "#__componentbuilder_dynamic_get","key": "id","type": "Dynamic_get","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$dynamic_get->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","getcustom":"getcustom","pagination":"pagination","php_after_getitem":"php_after_getitem","php_before_getitems":"php_before_getitems","php_before_getitem":"php_before_getitem","view_table_main":"view_table_main","php_getlistquery":"php_getlistquery","view_selection":"view_selection","php_after_getitems":"php_after_getitems","db_table_main":"db_table_main","php_calculation":"php_calculation","db_selection":"db_selection","add_php_before_getitem":"add_php_before_getitem","add_php_after_getitem":"add_php_after_getitem","add_php_getlistquery":"add_php_getlistquery","add_php_before_getitems":"add_php_before_getitems","add_php_after_getitems":"add_php_after_getitems","addcalculation":"addcalculation","php_custom_get":"php_custom_get","not_required":"not_required"}}';
			$dynamic_get->router = 'ComponentbuilderHelperRoute::getDynamic_getRoute';
			$dynamic_get->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","main_source","gettype","pagination","view_table_main","add_php_before_getitem","add_php_after_getitem","add_php_getlistquery","add_php_before_getitems","add_php_after_getitems","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

			// Set the object into the content types table.
			$dynamic_get_Inserted = $db->insertObject('#__content_types', $dynamic_get);

			// Create the custom_code content type object.
			$custom_code = new stdClass();
			$custom_code->type_title = 'Componentbuilder Custom_code';
			$custom_code->type_alias = 'com_componentbuilder.custom_code';
			$custom_code->table = '{"special": {"dbtable": "#__componentbuilder_custom_code","key": "id","type": "Custom_code","prefix": "componentbuilderTable","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			$custom_code->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","system_name":"system_name","function_name":"function_name","from_line":"from_line","hashendtarget":"hashendtarget","not_required":"not_required","code":"code","to_line":"to_line","hashtarget":"hashtarget"}}';
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
			$field->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","datalenght_other":"datalenght_other","datadefault":"datadefault","css_view":"css_view","datadefault_other":"datadefault_other","datalenght":"datalenght","css_views":"css_views","javascript_view_footer":"javascript_view_footer","xml":"xml","javascript_views_footer":"javascript_views_footer","add_css_view":"add_css_view","add_css_views":"add_css_views","add_javascript_view_footer":"add_javascript_view_footer","store":"store","add_javascript_views_footer":"add_javascript_views_footer","not_required":"not_required"}}';
			$field->router = 'ComponentbuilderHelperRoute::getFieldRoute';
			$field->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","fieldtype","add_css_view","catid","add_css_views","add_javascript_view_footer","store","add_javascript_views_footer","not_required"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}';

			// Set the object into the content types table.
			$field_Inserted = $db->insertObject('#__content_types', $field);

			// Create the field catagory content type object.
			$field_catagory = new stdClass();
			$field_catagory->type_title = 'Componentbuilder Field Catid';
			$field_catagory->type_alias = 'com_componentbuilder.fields.category';
			$field_catagory->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$field_catagory->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$field_catagory->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$field_catagory->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Set the object into the content types table.
			$field_catagory_Inserted = $db->insertObject('#__content_types', $field_catagory);

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

			// Create the fieldtype catagory content type object.
			$fieldtype_catagory = new stdClass();
			$fieldtype_catagory->type_title = 'Componentbuilder Fieldtype Catid';
			$fieldtype_catagory->type_alias = 'com_componentbuilder.fieldtypes.category';
			$fieldtype_catagory->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$fieldtype_catagory->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$fieldtype_catagory->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$fieldtype_catagory->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Set the object into the content types table.
			$fieldtype_catagory_Inserted = $db->insertObject('#__content_types', $fieldtype_catagory);

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
				$db->quoteName('params') . ' = ' . $db->quote('{"autorName":"Llewellyn van der Merwe","autorEmail":"joomla@vdm.io","minify":"0","check_in":"-1 day","save_history":"1","history_limit":"10","uikit_load":"1","uikit_min":"","uikit_style":""}'),
			);

			// Condition.
			$conditions = array(
				$db->quoteName('element') . ' = ' . $db->quote('com_componentbuilder')
			);

			$query->update($db->quoteName('#__extensions'))->set($fields)->where($conditions);
			$db->setQuery($query);
			$allDone = $db->execute();
			echo '<a target="_blank" href="http://vdm.bz/component-builder" title="Component Builder">
				<img src="components/com_componentbuilder/assets/images/component-300.jpg"/>
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
			$joomla_component->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "readme","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_code":"name_code","component_version":"component_version","short_description":"short_description","companyname":"companyname","author":"author","add_php_dashboard_methods":"add_php_dashboard_methods","add_sales_server":"add_sales_server","update_server_ftp":"update_server_ftp","sales_server_ftp":"sales_server_ftp","readme":"readme","name":"name","adduikit":"adduikit","copyright":"copyright","add_php_helper_site":"add_php_helper_site","add_email_helper":"add_email_helper","buildcomp":"buildcomp","php_postflight_update":"php_postflight_update","buildcompsql":"buildcompsql","php_preflight_update":"php_preflight_update","debug_linenr":"debug_linenr","add_placeholders":"add_placeholders","add_admin_event":"add_admin_event","mvc_versiondate":"mvc_versiondate","add_site_event":"add_site_event","update_server":"update_server","description":"description","php_helper_both":"php_helper_both","update_server_target":"update_server_target","php_postflight_install":"php_postflight_install","license":"license","php_method_uninstall":"php_method_uninstall","bom":"bom","php_preflight_install":"php_preflight_install","image":"image","sql":"sql","number":"number","add_update_server":"add_update_server","creatuserhelper":"creatuserhelper","emptycontributors":"emptycontributors","email":"email","website":"website","add_license":"add_license","license_type":"license_type","php_helper_admin":"php_helper_admin","php_admin_event":"php_admin_event","whmcs_key":"whmcs_key","php_helper_site":"php_helper_site","whmcs_url":"whmcs_url","php_site_event":"php_site_event","add_css":"add_css","addfootable":"addfootable","not_required":"not_required","css":"css","add_php_helper_both":"add_php_helper_both","add_php_helper_admin":"add_php_helper_admin","add_php_postflight_install":"add_php_postflight_install","add_php_postflight_update":"add_php_postflight_update","add_php_method_uninstall":"add_php_method_uninstall","php_dashboard_methods":"php_dashboard_methods","add_php_preflight_install":"add_php_preflight_install","add_php_preflight_update":"add_php_preflight_update","add_sql":"add_sql","addreadme":"addreadme"}}';
			$joomla_component->router = 'ComponentbuilderHelperRoute::getJoomla_componentRoute';
			$joomla_component->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/joomla_component.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_php_dashboard_methods","add_sales_server","adduikit","add_php_helper_site","add_email_helper","buildcomp","debug_linenr","add_placeholders","add_admin_event","mvc_versiondate","add_site_event","update_server_target","number","add_update_server","creatuserhelper","emptycontributors","add_license","license_type","add_css","addfootable","not_required","add_php_helper_both","add_php_helper_admin","add_php_postflight_install","add_php_postflight_update","add_php_method_uninstall","add_php_preflight_install","add_php_preflight_update","add_sql","addreadme"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

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
			$admin_view->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "null","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"system_name":"system_name","name_single":"name_single","name_list":"name_list","short_description":"short_description","add_php_getitems_after_all":"add_php_getitems_after_all","add_php_after_publish":"add_php_after_publish","description":"description","add_fadein":"add_fadein","add_php_allowedit":"add_php_allowedit","icon":"icon","add_sql":"add_sql","icon_add":"icon_add","icon_category":"icon_category","add_php_save":"add_php_save","add_php_batchmove":"add_php_batchmove","add_php_after_delete":"add_php_after_delete","add_php_getitems":"add_php_getitems","add_php_getlistquery":"add_php_getlistquery","add_php_postsavehook":"add_php_postsavehook","add_php_batchcopy":"add_php_batchcopy","add_php_before_publish":"add_php_before_publish","add_php_before_delete":"add_php_before_delete","html_import_view":"html_import_view","add_php_document":"add_php_document","type":"type","add_php_getitem":"add_php_getitem","add_custom_import":"add_custom_import","not_required":"not_required","php_import_setdata":"php_import_setdata","add_css_view":"add_css_view","css_view":"css_view","php_getitem":"php_getitem","add_css_views":"add_css_views","php_getitems":"php_getitems","css_views":"css_views","php_getitems_after_all":"php_getitems_after_all","add_javascript_view_file":"add_javascript_view_file","php_getlistquery":"php_getlistquery","javascript_view_file":"javascript_view_file","php_save":"php_save","add_javascript_view_footer":"add_javascript_view_footer","php_postsavehook":"php_postsavehook","javascript_view_footer":"javascript_view_footer","php_allowedit":"php_allowedit","add_javascript_views_file":"add_javascript_views_file","php_batchcopy":"php_batchcopy","javascript_views_file":"javascript_views_file","php_batchmove":"php_batchmove","add_javascript_views_footer":"add_javascript_views_footer","php_before_publish":"php_before_publish","javascript_views_footer":"javascript_views_footer","php_after_publish":"php_after_publish","add_custom_button":"add_custom_button","php_before_delete":"php_before_delete","php_after_delete":"php_after_delete","php_controller":"php_controller","php_document":"php_document","php_controller_list":"php_controller_list","source":"source","php_model":"php_model","sql":"sql","php_model_list":"php_model_list","add_php_ajax":"add_php_ajax","php_import_display":"php_import_display","php_ajaxmethod":"php_ajaxmethod","php_import":"php_import","php_import_save":"php_import_save"}}';
			$admin_view->router = 'ComponentbuilderHelperRoute::getAdmin_viewRoute';
			$admin_view->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/admin_view.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","add_php_getitems_after_all","add_php_after_publish","add_fadein","add_php_allowedit","add_sql","add_php_save","add_php_batchmove","add_php_after_delete","add_php_getitems","add_php_getlistquery","add_php_postsavehook","add_php_batchcopy","add_php_before_publish","add_php_before_delete","add_php_document","type","add_php_getitem","add_custom_import","not_required","add_css_view","add_css_views","add_javascript_view_file","add_javascript_view_footer","add_javascript_views_file","add_javascript_views_footer","add_custom_button","source","add_php_ajax"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}]}';

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
			$layout->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "alias","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","alias":"alias","description":"description","dynamic_get":"dynamic_get","snippet":"snippet","php_view":"php_view","layout":"layout","add_php_view":"add_php_view","not_required":"not_required"}}';
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
			$dynamic_get->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","main_source":"main_source","gettype":"gettype","getcustom":"getcustom","pagination":"pagination","php_after_getitem":"php_after_getitem","php_before_getitems":"php_before_getitems","php_before_getitem":"php_before_getitem","view_table_main":"view_table_main","php_getlistquery":"php_getlistquery","view_selection":"view_selection","php_after_getitems":"php_after_getitems","db_table_main":"db_table_main","php_calculation":"php_calculation","db_selection":"db_selection","add_php_before_getitem":"add_php_before_getitem","add_php_after_getitem":"add_php_after_getitem","add_php_getlistquery":"add_php_getlistquery","add_php_before_getitems":"add_php_before_getitems","add_php_after_getitems":"add_php_after_getitems","addcalculation":"addcalculation","php_custom_get":"php_custom_get","not_required":"not_required"}}';
			$dynamic_get->router = 'ComponentbuilderHelperRoute::getDynamic_getRoute';
			$dynamic_get->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/dynamic_get.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","main_source","gettype","pagination","view_table_main","add_php_before_getitem","add_php_after_getitem","add_php_getlistquery","add_php_before_getitems","add_php_after_getitems","not_required"],"displayLookup": [{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "view_table_main","targetTable": "#__componentbuilder_admin_view","targetColumn": "id","displayColumn": "system_name"}]}';

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
			$custom_code->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "component","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "null","core_xreference": "null","asset_id": "asset_id"},"special": {"component":"component","path":"path","target":"target","type":"type","comment_type":"comment_type","system_name":"system_name","function_name":"function_name","from_line":"from_line","hashendtarget":"hashendtarget","not_required":"not_required","code":"code","to_line":"to_line","hashtarget":"hashtarget"}}';
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
			$field->field_mappings = '{"common": {"core_content_item_id": "id","core_title": "name","core_state": "published","core_alias": "null","core_created_time": "created","core_modified_time": "modified","core_body": "null","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "access","core_params": "params","core_featured": "null","core_metadata": "null","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "null","core_metadesc": "null","core_catid": "catid","core_xreference": "null","asset_id": "asset_id"},"special": {"name":"name","fieldtype":"fieldtype","datatype":"datatype","indexes":"indexes","null_switch":"null_switch","datalenght_other":"datalenght_other","datadefault":"datadefault","css_view":"css_view","datadefault_other":"datadefault_other","datalenght":"datalenght","css_views":"css_views","javascript_view_footer":"javascript_view_footer","xml":"xml","javascript_views_footer":"javascript_views_footer","add_css_view":"add_css_view","add_css_views":"add_css_views","add_javascript_view_footer":"add_javascript_view_footer","store":"store","add_javascript_views_footer":"add_javascript_views_footer","not_required":"not_required"}}';
			$field->router = 'ComponentbuilderHelperRoute::getFieldRoute';
			$field->content_history_options = '{"formFile": "administrator/components/com_componentbuilder/models/forms/field.xml","hideFields": ["asset_id","checked_out","checked_out_time","version","not_required"],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","fieldtype","add_css_view","catid","add_css_views","add_javascript_view_footer","store","add_javascript_views_footer","not_required"],"displayLookup": [{"sourceColumn": "catid","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"},{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"},{"sourceColumn": "fieldtype","targetTable": "#__componentbuilder_fieldtype","targetColumn": "id","displayColumn": "name"}]}';

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

			// Create the field catagory content type object.
			$field_catagory = new stdClass();
			$field_catagory->type_title = 'Componentbuilder Field Catid';
			$field_catagory->type_alias = 'com_componentbuilder.fields.category';
			$field_catagory->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$field_catagory->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$field_catagory->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$field_catagory->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Check if field catagory type is already in content_type DB.
			$field_catagory_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($field_catagory->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$field_catagory->type_id = $db->loadResult();
				$field_catagory_Updated = $db->updateObject('#__content_types', $field_catagory, 'type_id');
			}
			else
			{
				$field_catagory_Inserted = $db->insertObject('#__content_types', $field_catagory);
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

			// Create the fieldtype catagory content type object.
			$fieldtype_catagory = new stdClass();
			$fieldtype_catagory->type_title = 'Componentbuilder Fieldtype Catid';
			$fieldtype_catagory->type_alias = 'com_componentbuilder.fieldtypes.category';
			$fieldtype_catagory->table = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
			$fieldtype_catagory->field_mappings = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
			$fieldtype_catagory->router = 'ComponentbuilderHelperRoute::getCategoryRoute';
			$fieldtype_catagory->content_history_options = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

			// Check if fieldtype catagory type is already in content_type DB.
			$fieldtype_catagory_id = null;
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('type_id')));
			$query->from($db->quoteName('#__content_types'));
			$query->where($db->quoteName('type_alias') . ' LIKE '. $db->quote($fieldtype_catagory->type_alias));
			$db->setQuery($query);
			$db->execute();

			// Set the object into the content types table.
			if ($db->getNumRows())
			{
				$fieldtype_catagory->type_id = $db->loadResult();
				$fieldtype_catagory_Updated = $db->updateObject('#__content_types', $fieldtype_catagory, 'type_id');
			}
			else
			{
				$fieldtype_catagory_Inserted = $db->insertObject('#__content_types', $fieldtype_catagory);
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


			echo '<a target="_blank" href="http://vdm.bz/component-builder" title="Component Builder">
				<img src="components/com_componentbuilder/assets/images/component-300.jpg"/>
				</a>
				<h3>Upgrade to Version 2.3.6 Was Successful! Let us know if anything is not working as expected.</h3>';
		}
	}
}
