<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * General Controller of Componentbuilder component
 */
class ComponentbuilderController extends JControllerLegacy
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 * Recognized key values include 'name', 'default_task', 'model_path', and
	 * 'view_path' (this list is not meant to be comprehensive).
	 *
	 * @since   3.0
	 */
	public function __construct($config = array())
	{
		// set the default view
		$config['default_view'] = 'componentbuilder';

		parent::__construct($config);
	}

	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		$view   = $this->input->getCmd('view', 'componentbuilder');
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
		// check the we have a value
		if (ComponentbuilderHelper::checkString($view))
		{
			// the view relationships
			$views = array(
				'joomla_component' => 'joomla_components',
				'joomla_module' => 'joomla_modules',
				'joomla_plugin' => 'joomla_plugins',
				'admin_view' => 'admin_views',
				'custom_admin_view' => 'custom_admin_views',
				'site_view' => 'site_views',
				'template' => 'templates',
				'layout' => 'layouts',
				'dynamic_get' => 'dynamic_gets',
				'custom_code' => 'custom_codes',
				'class_property' => 'class_properties',
				'class_method' => 'class_methods',
				'placeholder' => 'placeholders',
				'library' => 'libraries',
				'snippet' => 'snippets',
				'validation_rule' => 'validation_rules',
				'field' => 'fields',
				'fieldtype' => 'fieldtypes',
				'language_translation' => 'language_translations',
				'language' => 'languages',
				'server' => 'servers',
				'help_document' => 'help_documents',
				'admin_fields' => 'admins_fields',
				'admin_fields_conditions' => 'admins_fields_conditions',
				'admin_fields_relations' => 'admins_fields_relations',
				'admin_custom_tabs' => 'admins_custom_tabs',
				'component_admin_views' => 'components_admin_views',
				'component_site_views' => 'components_site_views',
				'component_custom_admin_views' => 'components_custom_admin_views',
				'component_updates' => 'components_updates',
				'component_mysql_tweaks' => 'components_mysql_tweaks',
				'component_custom_admin_menus' => 'components_custom_admin_menus',
				'component_config' => 'components_config',
				'component_dashboard' => 'components_dashboard',
				'component_files_folders' => 'components_files_folders',
				'component_placeholders' => 'components_placeholders',
				'component_plugins' => 'components_plugins',
				'component_modules' => 'components_modules',
				'snippet_type' => 'snippet_types',
				'library_config' => 'libraries_config',
				'library_files_folders_urls' => 'libraries_files_folders_urls',
				'class_extends' => 'class_extendings',
				'joomla_module_updates' => 'joomla_modules_updates',
				'joomla_module_files_folders_urls' => 'joomla_modules_files_folders_urls',
				'joomla_plugin_group' => 'joomla_plugin_groups',
				'joomla_plugin_updates' => 'joomla_plugins_updates',
				'joomla_plugin_files_folders_urls' => 'joomla_plugins_files_folders_urls'
					);
			// check if this is a list view
			if (in_array($view, $views))
			{
				// this is a list view
				return array('edit' => false, 'view' => array_search($view,$views), 'views' => $view);
			}
			// check if it is an edit view
			elseif (array_key_exists($view, $views))
			{
				// this is a edit view
				return array('edit' => true, 'view' => $view, 'views' => $views[$view]);
			}
		}
		return false;
	}
}
