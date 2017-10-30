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

	@version		2.5.9
	@build			30th October, 2017
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		controller.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of Componentbuilder component
 */
class ComponentbuilderController extends JControllerLegacy
{
	/**
	 * display task
	 *
	 * @return void
	 */
        function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		$view   = $this->input->getCmd('view', 'Componentbuilder');
		$data	= $this->getViewRelation($view);
		$layout	= $this->input->get('layout', null, 'WORD');
		$id    	= $this->input->getInt('id');

		// Check for edit form.
                if(ComponentbuilderHelper::checkArray($data))
                {
                    if ($data['edit'] && $layout == 'edit' && !$this->checkEditId('com_componentbuilder.edit.'.$data['view'], $id))
                    {
                        // Somehow the person just went to the form - we don't allow that.
                        $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
                        $this->setMessage($this->getError(), 'error');
                        // check if item was opend from other then its own list view
                        $ref 	= $this->input->getCmd('ref', 0);
                        $refid 	= $this->input->getInt('refid', 0);
                        // set redirect
                        if ($refid > 0 && ComponentbuilderHelper::checkString($ref))
                        {
                            // redirect to item of ref
                            $this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view='.(string)$ref.'&layout=edit&id='.(int)$refid, false));
                        }
                        elseif (ComponentbuilderHelper::checkString($ref))
                        {

                            // redirect to ref
                            $this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view='.(string)$ref, false));
                        }
                        else
                        {
                            // normal redirect back to the list view
                            $this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view='.$data['views'], false));
                        }

                        return false;
                    }
                }

		return parent::display($cachable, $urlparams);
	}

	protected function getViewRelation($view)
	{
                if (ComponentbuilderHelper::checkString($view))
                {
                        $views = array(
				'joomla_component' => 'joomla_components',
				'admin_view' => 'admin_views',
				'custom_admin_view' => 'custom_admin_views',
				'site_view' => 'site_views',
				'template' => 'templates',
				'layout' => 'layouts',
				'dynamic_get' => 'dynamic_gets',
				'custom_code' => 'custom_codes',
				'snippet' => 'snippets',
				'field' => 'fields',
				'fieldtype' => 'fieldtypes',
				'language_translation' => 'language_translations',
				'language' => 'languages',
				'ftp' => 'ftps',
				'help_document' => 'help_documents',
				'admin_fields' => 'admins_fields',
				'admin_fields_conditions' => 'admins_fields_conditions',
				'component_admin_views' => 'components_admin_views',
				'component_site_views' => 'components_site_views',
				'component_custom_admin_views' => 'components_custom_admin_views',
				'component_updates' => 'components_updates',
				'component_mysql_tweaks' => 'components_mysql_tweaks',
				'component_custom_admin_menus' => 'components_custom_admin_menus',
				'component_config' => 'components_config',
				'component_dashboard' => 'components_dashboard',
				'component_files_folders' => 'components_files_folders'
                                );
                        // check if this is a list view
                        if (in_array($view,$views))
                        {
                            return array('edit' => false, 'view' => array_search($view,$views), 'views' => $view);
                        }
                        // check if it is an edit view
                        elseif (array_key_exists($view,$views))
                        {
                                return array('edit' => true, 'view' => $view, 'views' => $views[$view]);
                        }
                }
		return false;
	}
}
