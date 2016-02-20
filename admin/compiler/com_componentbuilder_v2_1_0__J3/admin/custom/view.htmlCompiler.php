<?php
/**
*
*  @version		2.0.0 - September 03, 2014
*  @package		Component Builder
*  @author		Llewellyn van de Merwe <http://www.vdm.io>
*  @copyright		Copyright (C) 2014. All Rights Reserved
*  @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
*
**/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * ###Component### Compiler View
 */
class ###Component###ViewCompiler extends JViewLegacy
{
	/**
	 * ###Component### view display method
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
			###Component###Helper::addSubmenu('compiler');
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
		$canDo = ###Component###Helper::getActions('compiler');
		JToolBarHelper::title(JText::_('Compiler'), 'cogs');
		
		if($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			JToolBarHelper::custom('compiler.clearTmp', 'purge', '', 'Clear tmp', false);
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_###component###');
		}

		// set help url for this view if found
		$help_url = ###Component###Helper::getHelpUrl('compiler');
		if (###Component###Helper::checkString($help_url))
		{
			JToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $help_url);
		}
	}
	
	public function setForm()
	{		
		if(###Component###Helper::checkArray($this->Components)){
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
				$xml .= '<option value="'.$componet->id.'">'.$componet->name.'</option>';
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
}