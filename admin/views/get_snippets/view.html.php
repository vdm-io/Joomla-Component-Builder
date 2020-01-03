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
 * Componentbuilder View class for the Get_snippets
 */
class ComponentbuilderViewGet_snippets extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = JComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app = JFactory::getApplication();
		// get the user object
		$this->user	= JFactory::getUser();
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('get_snippets');
		// Initialise variables.
		$this->items = $this->get('Items');

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
		$this->document->addScript(JURI::root(true) . "/administrator/components/com_componentbuilder/assets/js/get_snippets.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");

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
		// load the local snippets
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			$local_snippets = array();
			foreach ($this->items as $item)
			{
				$path = ComponentbuilderHelper::safeString($item->library . ' - (' . $item->type . ') ' . $item->name, 'filename', '', false). '.json';
				$local_snippets[$path] = $item;
			}
		}
		
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
		$this->document->addScriptDeclaration("var snippetPath = '". ComponentbuilderHelper::$snippetPath ."';");
		$this->document->addScriptDeclaration("var snippetsPath = '". ComponentbuilderHelper::$snippetsPath ."';");
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
		JText::script('COM_COMPONENTBUILDER_JCB_COMMUNITY_SNIPPETS');
		JText::script('COM_COMPONENTBUILDER_SNIPPETS');
		JText::script('COM_COMPONENTBUILDER_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_VIEW_SNIPPET_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_LOCAL_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_INSTALL_IT_LOCALLY');
		JText::script('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_USAGE');
		JText::script('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_DESCRIPTION');
		JText::script('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_VIEW_BLAME');
		JText::script('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_VIEW_SNIPPET_REFERENCE_URL');
		JText::script('COM_COMPONENTBUILDER_SNIPPET_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_SNIPPETS_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR');
		JText::script('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS');
		JText::script('COM_COMPONENTBUILDER_JCB_COMMUNITY');
		JText::script('COM_COMPONENTBUILDER_COMPANY_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_EMAIL');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_WEBSITE');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_SNIPPETS_TO_UPDATE_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_AVAILABLE_LIBRARIES');
		JText::script('COM_COMPONENTBUILDER_OPEN_LIBRARY_SNIPPETS');
		// add some lang verfy messages
		$this->document->addScriptDeclaration("
			// set the snippet from gitHub
			function getConfirmUpdate(status) {
				switch(status) {
					case 'new':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_ADD_THIS_NEW_JCB_COMMUNITY_SNIPPET_TO_YOUR_LOCAL_SNIPPETS')."';
					break;
					case 'behind':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_UPDATE_YOUR_LOCAL_SNIPPET_WITH_THIS_NEWER_JCB_COMMUNITY_SNIPPET')."';
					break;
					case 'ahead':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_UPDATE_YOUR_LOCAL_SNIPPET_WITH_THIS_OLDER_JCB_COMMUNITY_SNIPPET')."';
					break;
					case 'diverged':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_REPLACE_YOUR_LOCAL_SNIPPET_WITH_THIS_JCB_COMMUNITY_SNIPPET')."';
					break;
					default:
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_CONTINUE')."';
					break;
				}
			}
		");
		// load the local snippets
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			// Set the local snippets array
			$this->document->addScriptDeclaration("var local_snippets = ". json_encode($local_snippets).";");
		}
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_componentbuilder/assets/css/get_snippets.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// hide the main menu
		$this->app->input->set('hidemainmenu', true);
		// add title to the page
		JToolbarHelper::title(JText::_('COM_COMPONENTBUILDER_GET_SNIPPETS'),'search');
		// add the back button
		// JToolBarHelper::custom('get_snippets.back', 'undo-2', '', 'COM_COMPONENTBUILDER_BACK', false);
		// add cpanel button
		JToolBarHelper::custom('get_snippets.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('get_snippets.custom_admin_views'))
		{
			// add Custom Admin Views button.
			JToolBarHelper::custom('get_snippets.openCustomAdminViews', 'screen', '', 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEWS', false);
		}
		if ($this->canDo->get('get_snippets.site_views'))
		{
			// add Site Views button.
			JToolBarHelper::custom('get_snippets.openSiteViews', 'palette', '', 'COM_COMPONENTBUILDER_SITE_VIEWS', false);
		}
		if ($this->canDo->get('get_snippets.templates'))
		{
			// add Templates button.
			JToolBarHelper::custom('get_snippets.openTemplates', 'brush', '', 'COM_COMPONENTBUILDER_TEMPLATES', false);
		}
		if ($this->canDo->get('get_snippets.layouts'))
		{
			// add Layouts button.
			JToolBarHelper::custom('get_snippets.openLayouts', 'brush', '', 'COM_COMPONENTBUILDER_LAYOUTS', false);
		}
		if ($this->canDo->get('get_snippets.snippets'))
		{
			// add Snippets button.
			JToolBarHelper::custom('get_snippets.openSnippets', 'pin', '', 'COM_COMPONENTBUILDER_SNIPPETS', false);
		}
		if ($this->canDo->get('get_snippets.libraries'))
		{
			// add Libraries button.
			JToolBarHelper::custom('get_snippets.openLibraries', 'puzzle', '', 'COM_COMPONENTBUILDER_LIBRARIES', false);
		}

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('get_snippets');
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
