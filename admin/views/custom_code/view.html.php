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

	@version		@update number 82 of this MVC
	@build			4th October, 2017
	@created		11th October, 2016
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
 * Custom_code View class
 */
class ComponentbuilderViewCustom_code extends JViewLegacy
{
	/**
	 * display method of View
	 * @return void
	 */
	public function display($tpl = null)
	{
		// Check for errors.
		if (count($errors = $this->get('Errors')))
                {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

		// Assign the variables
		$this->form 		= $this->get('Form');
		$this->item 		= $this->get('Item');
		$this->script 		= $this->get('Script');
		$this->state		= $this->get('State');
                // get action permissions
		$this->canDo		= ComponentbuilderHelper::getActions('custom_code',$this->item);
		// get input
		$jinput = JFactory::getApplication()->input;
		$this->ref 		= $jinput->get('ref', 0, 'word');
		$this->refid            = $jinput->get('refid', 0, 'int');
		$this->referral         = '';
		if ($this->refid)
                {
                        // return to the item that refered to this item
                        $this->referral = '&ref='.(string)$this->ref.'&refid='.(int)$this->refid;
                }
                elseif($this->ref)
                {
                        // return to the list view that refered to this item
                        $this->referral = '&ref='.(string)$this->ref;
                }

		// Set the toolbar
		$this->addToolBar();

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
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId	= $user->id;
		$isNew = $this->item->id == 0;

		JToolbarHelper::title( JText::_($isNew ? 'COM_COMPONENTBUILDER_CUSTOM_CODE_NEW' : 'COM_COMPONENTBUILDER_CUSTOM_CODE_EDIT'), 'pencil-2 article-add');
		// Built the actions for new and existing records.
		if ($this->refid || $this->ref)
		{
			if ($this->canDo->get('custom_code.create') && $isNew)
			{
				// We can create the record.
				JToolBarHelper::save('custom_code.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('custom_code.edit'))
			{
				// We can save the record.
				JToolBarHelper::save('custom_code.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// Do not creat but cancel.
				JToolBarHelper::cancel('custom_code.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// We can close it.
				JToolBarHelper::cancel('custom_code.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// For new records, check the create permission.
				if ($this->canDo->get('custom_code.create'))
				{
					JToolBarHelper::apply('custom_code.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('custom_code.save', 'JTOOLBAR_SAVE');
					JToolBarHelper::custom('custom_code.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				JToolBarHelper::cancel('custom_code.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('custom_code.edit'))
				{
					// We can save the new record
					JToolBarHelper::apply('custom_code.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('custom_code.save', 'JTOOLBAR_SAVE');
					// We can save this record, but check the create permission to see
					// if we can return to make a new one.
					if ($this->canDo->get('custom_code.create'))
					{
						JToolBarHelper::custom('custom_code.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				$canVersion = ($this->canDo->get('core.version') && $this->canDo->get('custom_code.version'));
				if ($this->state->params->get('save_history', 1) && $this->canDo->get('custom_code.edit') && $canVersion)
				{
					JToolbarHelper::versions('com_componentbuilder.custom_code', $this->item->id);
				}
				if ($this->canDo->get('custom_code.create'))
				{
					JToolBarHelper::custom('custom_code.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				JToolBarHelper::cancel('custom_code.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		JToolbarHelper::divider();
		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('custom_code');
		if (ComponentbuilderHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
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
		if(strlen($var) > 30)
		{
    		// use the helper htmlEscape method instead and shorten the string
			return ComponentbuilderHelper::htmlEscape($var, $this->_charset, true, 30);
		}
                // use the helper htmlEscape method instead.
		return ComponentbuilderHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle(JText::_($isNew ? 'COM_COMPONENTBUILDER_CUSTOM_CODE_NEW' : 'COM_COMPONENTBUILDER_CUSTOM_CODE_EDIT'));
		$document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/custom_code.css");
		// Add Ajax Token
		$document->addScriptDeclaration("var token = '".JSession::getFormToken()."';"); 
		$document->addScript(JURI::root() . $this->script);
		$document->addScript(JURI::root() . "administrator/components/com_componentbuilder/views/custom_code/submitbutton.js"); 
		// add JavaScripts
		$document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit/js/uikit.min.js' );
		$document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit/js/components/notify.min.js', 'text/javascript', true);
		// add the style sheets
		$document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit/css/uikit.gradient.min.css' );
		$document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit/css/components/notify.gradient.min.css' );
		JText::script('view not acceptable. Error');
	}
}
