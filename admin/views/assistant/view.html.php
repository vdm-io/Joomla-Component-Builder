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
 * Componentbuilder View class for the Assistant
 */
class ComponentbuilderViewAssistant extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = JComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app = JFactory::getApplication();
		// get the user object
		$this->user = JFactory::getUser();
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('assistant');
		// Initialise variables.
		$this->item = $this->get('Item');
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('builder');
			JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=assistant');
			$this->sidebar = JHtmlSidebar::render();
		}
		// get the forms
		$this->forms = $this->setForms();
		//
		JHtml::_('jquery.ui', array('core', 'sortable'));

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// add the tool bar
			$this->addToolBar();
		}

		// set the document
		$this->setDocument();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode(PHP_EOL, $errors), 500);
		}

		parent::display($tpl);
	}

	protected function setForms()
	{
		// get component form (just required fields)
		
		// get admin form (just required fields)
		
		// get field form (just required fields)
		
	}

	/**
	 * Prepares the document
	 */
	protected function setDocument()
	{

		// always make sure jquery is loaded.
		JHtml::_('jquery.framework');
		// Load the header checker class.
		require_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/headercheck.php' );
		// Initialize the header checker.
		$HeaderCheck = new componentbuilderHeaderCheck;

		// Add View JavaScript File
		$this->document->addScript(JURI::root(true) . "/administrator/components/com_componentbuilder/assets/js/assistant.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/uikit'.$style.$size.'.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/uikit'.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		}

		// Load the script to find all uikit components needed.
		if ($uikit != 2)
		{
			// Set the default uikit components in this view.
			$uikitComp = array();
			$uikitComp[] = 'UIkit.notify';
			$uikitComp[] = 'data-uk-grid';
		}

		// Load the needed uikit components in this view.
		if ($uikit != 2 && isset($uikitComp) && ComponentbuilderHelper::checkArray($uikitComp))
		{
			// load just in case.
			jimport('joomla.filesystem.file');
			// loading...
			foreach ($uikitComp as $class)
			{
				foreach (ComponentbuilderHelper::$uk_components[$class] as $name)
				{
					// check if the CSS file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
					}
					// check if the JavaScript file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);
					}
				}
			}
		}
		// add marked library
		$this->document->addScript(JURI::root() . "administrator/components/com_componentbuilder/custom/marked.js");
		
		// Add the JavaScript for JStore
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jquery.json.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jstorage.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/strtotime.js');
		// check if we should use browser storage
		$setBrowserStorage = $this->params->get('set_browser_storage', null);
		if ($setBrowserStorage)
		{
			// check what (Time To Live) show we use
			$storageTimeToLive = $this->params->get('storage_time_to_live', 'global');
			if ('global' == $storageTimeToLive)
			{
				// use the global session time
				$session = JFactory::getSession();
				// must have itin milliseconds
				$expire = ($session->getExpire()*60)* 1000;
			}
			else
			{
				// use the Componentbuilder Global setting
				if (0 !=  $storageTimeToLive)
				{
					// this will convert the time into milliseconds
					$storageTimeToLive =  $storageTimeToLive * 1000;
				}
				$expire = $storageTimeToLive;
			}
		}
		else
		{
			// set to use no storage
			$expire = 30000; // only 30 seconds
		}
		// Set the Time To Live To JavaScript
		$this->document->addScriptDeclaration("var expire = ". (int) $expire.";");
		// set snippet path
		$this->document->addScriptDeclaration("var planPath = '';");
		$this->document->addScriptDeclaration("var plansPath = '';");
		// $this->document->addScriptDeclaration("var planPath = '". ComponentbuilderHelper::$planPath ."';");
		// $this->document->addScriptDeclaration("var plansPath = '". ComponentbuilderHelper::$plansPath ."';");
		// token
		$this->document->addScriptDeclaration("var token = '". JSession::getFormToken() ."';");
		// add some global items buckets for bulk updating
		$this->document->addScriptDeclaration("var bulkItems = {};");
		$this->document->addScriptDeclaration("bulkItems.new = [];");
		$this->document->addScriptDeclaration("bulkItems.diverged = [];");
		$this->document->addScriptDeclaration("bulkItems.ahead = [];");
		$this->document->addScriptDeclaration("bulkItems.behind = [];");
		// set an error message if needed
		$this->document->addScriptDeclaration("var returnError = '<div class=\"uk-alert uk-alert-warning\"><h1>".JText::_('COM_COMPONENTBUILDER_AN_ERROR_HAS_OCCURRED')."!</h1><p>".JText::_('COM_COMPONENTBUILDER_PLEASE_TRY_AGAIN_LATER').".</p></div>';");
		// need to add some language strings
		JText::script('COM_COMPONENTBUILDER_JCB_COMMUNITY_PLANS');
		JText::script('COM_COMPONENTBUILDER_PLANS');
		JText::script('COM_COMPONENTBUILDER_PLAN');
		JText::script('COM_COMPONENTBUILDER_VIEW_PLAN_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_PLAN');
		JText::script('COM_COMPONENTBUILDER_LOCAL_PLAN');
		JText::script('COM_COMPONENTBUILDER_GET_THE_PLAN_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_THE_PLAN_FROM_GITHUB_AND_INSTALL_IT_LOCALLY');
		JText::script('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_USAGE');
		JText::script('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_DESCRIPTION');
		JText::script('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_VIEW_BLAME');
		JText::script('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_PLAN');
		JText::script('COM_COMPONENTBUILDER_VIEW_PLAN_REFERENCE_URL');
		JText::script('COM_COMPONENTBUILDER_PLAN_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_PLANS_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR');
		JText::script('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS');
		JText::script('COM_COMPONENTBUILDER_JCB_COMMUNITY');
		JText::script('COM_COMPONENTBUILDER_COMPANY_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_EMAIL');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_WEBSITE');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_PLANS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_PLANS_TO_UPDATE_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_AVAILABLE_CATEGORIES');
		JText::script('COM_COMPONENTBUILDER_OPEN_CATEGORY_PLANS');
		// Set the local plans array
		$this->document->addScriptDeclaration("var local_plans = '';");
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_componentbuilder/assets/css/assistant.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// hide the main menu
		$this->app->input->set('hidemainmenu', true);
		// set the title
		if (isset($this->item->name) && $this->item->name)
		{
			$title = $this->item->name;
		}
		// Check for empty title and add view name if param is set
		if (empty($title))
		{
			$title = JText::_('COM_COMPONENTBUILDER_ASSISTANT');
		}
		// add title to the page
		JToolbarHelper::title($title,'heart');
		// add the back button
		// JToolBarHelper::custom('assistant.back', 'undo-2', '', 'COM_COMPONENTBUILDER_BACK', false);
		// add cpanel button
		JToolBarHelper::custom('assistant.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('assistant');
		if (ComponentbuilderHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_componentbuilder');
		}
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		// use the helper htmlEscape method instead.
		return ComponentbuilderHelper::htmlEscape($var, $this->_charset);
	}
}
?>
