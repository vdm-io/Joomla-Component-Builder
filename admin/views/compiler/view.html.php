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

	@version		2.1.19
	@build			7th September, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		view.html.php
	@author			Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Componentbuilder Compiler View
 */
class ComponentbuilderViewCompiler extends JViewLegacy
{
	/**
	 * Componentbuilder view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		};
		
		$this->Components 	= $this->get('Components');
		$this->form		= $this->setForm();

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('compiler');
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		$canDo = ComponentbuilderHelper::getActions('compiler');
		JToolBarHelper::title(JText::_('Compiler'), 'cogs');
		
		if($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			JToolBarHelper::custom('compiler.clearTmp', 'purge', '', 'Clear tmp', false);
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_componentbuilder');
		}

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('compiler');
		if (ComponentbuilderHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
		}
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
	 * Method to set up the document properties
	 *
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		$document->setTitle(JText::_('The Compiler'));
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
		if(strlen($var) > 50)
		{
                        // use the helper htmlEscape method instead and shorten the string
			return ComponentbuilderHelper::htmlEscape($var, $this->_charset, true);
		}
                // use the helper htmlEscape method instead.
		return ComponentbuilderHelper::htmlEscape($var, $this->_charset);
	}
}