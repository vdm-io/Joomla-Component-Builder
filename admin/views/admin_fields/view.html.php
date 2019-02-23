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
 * Admin_fields View class
 */
class ComponentbuilderViewAdmin_fields extends JViewLegacy
{
	/**
	 * display method of View
	 * @return void
	 */
	public function display($tpl = null)
	{
		// set params
		$this->params = JComponentHelper::getParams('com_componentbuilder');
		// Assign the variables
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->script = $this->get('Script');
		$this->state = $this->get('State');
		// get action permissions
		$this->canDo = ComponentbuilderHelper::getActions('admin_fields', $this->item);
		// get input
		$jinput = JFactory::getApplication()->input;
		$this->ref = $jinput->get('ref', 0, 'word');
		$this->refid = $jinput->get('refid', 0, 'int');
		$return = $jinput->get('return', null, 'base64');
		// set the referral string
		$this->referral = '';
		if ($this->refid && $this->ref)
		{
			// return to the item that referred to this item
			$this->referral = '&ref=' . (string)$this->ref . '&refid=' . (int)$this->refid;
		}
		elseif($this->ref)
		{
			// return to the list view that referred to this item
			$this->referral = '&ref=' . (string)$this->ref;
		}
		// check return value
		if (!is_null($return))
		{
			// add the return value
			$this->referral .= '&return=' . (string)$return;
		}

		// Set the toolbar
		$this->addToolBar();
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
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
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$user = JFactory::getUser();
		$userId	= $user->id;
		$isNew = $this->item->id == 0;

		JToolbarHelper::title( JText::_($isNew ? 'COM_COMPONENTBUILDER_ADMIN_FIELDS_NEW' : 'COM_COMPONENTBUILDER_ADMIN_FIELDS_EDIT'), 'pencil-2 article-add');
		// Built the actions for new and existing records.
		if (ComponentbuilderHelper::checkString($this->referral))
		{
			if ($this->canDo->get('admin_fields.create') && $isNew)
			{
				// We can create the record.
				JToolBarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('admin_fields.edit'))
			{
				// We can save the record.
				JToolBarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// Do not creat but cancel.
				JToolBarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// We can close it.
				JToolBarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// For new records, check the create permission.
				if ($this->canDo->get('admin_fields.create'))
				{
					JToolBarHelper::apply('admin_fields.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
					JToolBarHelper::custom('admin_fields.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				JToolBarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('admin_fields.edit'))
				{
					// We can save the new record
					JToolBarHelper::apply('admin_fields.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
					// We can save this record, but check the create permission to see
					// if we can return to make a new one.
					if ($this->canDo->get('admin_fields.create'))
					{
						JToolBarHelper::custom('admin_fields.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				$canVersion = ($this->canDo->get('core.version') && $this->canDo->get('admin_fields.version'));
				if ($this->state->params->get('save_history', 1) && $this->canDo->get('admin_fields.edit') && $canVersion)
				{
					JToolbarHelper::versions('com_componentbuilder.admin_fields', $this->item->id);
				}
				if ($this->canDo->get('admin_fields.create'))
				{
					JToolBarHelper::custom('admin_fields.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				JToolBarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		JToolbarHelper::divider();
		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('admin_fields');
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
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_($isNew ? 'COM_COMPONENTBUILDER_ADMIN_FIELDS_NEW' : 'COM_COMPONENTBUILDER_ADMIN_FIELDS_EDIT'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/admin_fields.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		$this->document->addScript(JURI::root() . $this->script, (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		$this->document->addScript(JURI::root() . "administrator/components/com_componentbuilder/views/admin_fields/submitbutton.js", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript'); 

		// add the Uikit v2 style sheets
		$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/uikit.gradient.min.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/notify.gradient.min.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');

		// add Uikit v2 JavaScripts
		$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/uikit.min.js' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/lightbox.min.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);
		$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/notify.min.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);
		JText::script('COM_COMPONENTBUILDER_THE_BNONE_DBB_OPTION_WILL_REMOVE_THIS_FIELD_FROM_BEING_SAVED_IN_THE_DATABASE');
		JText::script('COM_COMPONENTBUILDER_ONLY_USE_THE_BNONE_DBB_OPTION_IF_YOU_ARE_PLANNING_ON_TARGETING_THIS_FIELD_WITH_JAVASCRIPTCUSTOM_PHP_TO_MOVE_ITS_VALUE_INTO_ANOTHER_FIELD_THAT_DOES_GET_SAVED_TO_THE_DATABASE');
		JText::script('COM_COMPONENTBUILDER_THE_BSHOW_IN_ALL_LIST_VIEWSB_OPTION_WILL_ADD_THIS_FIELD_TO_ALL_LIST_VIEWS_ADMIN_AMP_LINKED');
		JText::script('COM_COMPONENTBUILDER_THE_BONLY_IN_ADMIN_LIST_VIEWB_OPTION_WILL_ONLY_ADD_THIS_FIELD_TO_THE_ADMIN_LIST_VIEW_NOT_TO_ANY_LINKED_VIEWS');
		JText::script('COM_COMPONENTBUILDER_THE_BONLY_IN_LINKED_LIST_VIEWSB_OPTION_WILL_ONLY_ADD_THIS_FIELD_TO_THE_LINKED_LIST_VIEW_IF_THIS_VIEW_GETS_LINKED_TO_OTHER_VIEW_NOT_TO_THIS_ADMIN_LIST_VIEW');
		JText::script('COM_COMPONENTBUILDER_THESE_OPTIONS_ARE_NOT_AVAILABLE_TO_THE_FIELD_IF_BNONE_DBB_OPTION_IS_SELECTED');
		JText::script('COM_COMPONENTBUILDER_THESE_OPTIONS_ARE_ONLY_AVAILABLE_TO_THE_FIELD_IF_BSHOW_IN_LIST_VIEWB_OPTION_IS_SELECTED');
		JText::script('view not acceptable. Error');
	}
}
