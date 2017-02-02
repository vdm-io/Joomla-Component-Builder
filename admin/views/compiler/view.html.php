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

	@version		@update number 11 of this MVC
	@build			2nd February, 2017
	@created		1st February, 2017
	@package		Component Builder
	@subpackage		view.html.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Componentbuilder View class for the Compiler
 */
class ComponentbuilderViewCompiler extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
                // get component params
		$this->params	= JComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app	= JFactory::getApplication();
		// get the user object
		$this->user	= JFactory::getUser();
                // get global action permissions
		$this->canDo	= ComponentbuilderHelper::getActions('compiler');
		// Initialise variables.
		$this->items	= $this->get('Items');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('compiler');
			JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=compiler');
			$this->sidebar = JHtmlSidebar::render();
		}
		$this->Components 	= $this->get('Components');
		$this->form		= $this->setForm();

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// add the tool bar
			$this->addToolBar();
		}

		// set the document
		$this->setDocument();

		parent::display($tpl);
	}

	public function setForm()
	{		
		if(ComponentbuilderHelper::checkArray($this->Components)){
			jimport('joomla.form.form');
			
			$radio1 = JFormHelper::loadFieldType('radio',true);
			// start building add to sales folder xml field
			$xml = '<field label="Add to Backup Folder &amp; Sales Server &lt;small&gt;(if set)&lt;/small&gt;" description="" name="backup" type="radio" class="btn-group btn-group-yesno" default="0">';
			$xml .= '<option value="1">Yes</option> <option value="0">No</option>';
			$xml .= "</field>";
			// prepare the xml
			$sales = new SimpleXMLElement($xml);
			// set components to form
			$radio1->setup($sales,0);
			
			$radio2 = JFormHelper::loadFieldType('radio',true);
			// start building add to git folder xml field
			$xml = '<field label="Add to Git Folder" description="" name="git" type="radio" class="btn-group btn-group-yesno" default="1">';
			$xml .= '<option value="1">Yes</option> <option value="0">No</option>';
			$xml .= "</field>";
			// prepare the xml
			$git = new SimpleXMLElement($xml);
			// set components to form
			$radio2->setup($git,1);
			
			$list = JFormHelper::loadFieldType('list',true);
			// start building componet xml field
			$xml = '<field label="Components" description="" name="component" type="list" class="btn-group" required="true">';
			$xml .= '<option value="">- Select Component -</option>';
			foreach($this->Components as $componet){
				$xml .= '<option value="'.$componet->id.'">'.$this->escape($componet->name).'</option>';
			}
			$xml .= "</field>";
			// prepare the xml
			$componets = new SimpleXMLElement($xml);
			// set components to form
			$list->setup($componets,0);
						
			return array($radio1,$radio2,$list);
		}
		return false;
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
		$HeaderCheck = new HeaderCheck;

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit/css/uikit'.$style.$size.'.css');
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit/js/uikit'.$size.'.js');
		}

		// Load the needed uikit components in this view.
		$uikitComp = $this->get('UikitComp');
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
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit/css/components/'.$name.$style.$size.'.css');
					}
					// check if the JavaScript file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit/js/components/'.$name.$size.'.js', 'text/javascript', true);
					}
				}
			}
		}   
                // add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_componentbuilder/assets/css/compiler.css'); 
        }

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// hide the main menu
                $this->app->input->set('hidemainmenu', true);
		// add title to the page
		JToolbarHelper::title(JText::_('COM_COMPONENTBUILDER_COMPILER'),'cogs');
                // add the back button
                // JToolBarHelper::custom('compiler.back', 'undo-2', '', 'COM_COMPONENTBUILDER_BACK', false);
                // add cpanel button
		JToolBarHelper::custom('compiler.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('compiler.clear_tmp'))
		{
			// add Clear tmp button.
			JToolBarHelper::custom('compiler.clearTmp', 'purge', '', 'COM_COMPONENTBUILDER_CLEAR_TMP', false);
		}

		// set help url for this view if found
                $help_url = ComponentbuilderHelper::getHelpUrl('compiler');
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
