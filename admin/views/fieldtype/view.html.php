<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Fieldtype View class
 */
class ComponentbuilderViewFieldtype extends JViewLegacy
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
		$this->canDo = ComponentbuilderHelper::getActions('fieldtype', $this->item);
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

		// Get Linked view data
		$this->vycfields = $this->get('Vycfields');

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

		JToolbarHelper::title( JText::_($isNew ? 'COM_COMPONENTBUILDER_FIELDTYPE_NEW' : 'COM_COMPONENTBUILDER_FIELDTYPE_EDIT'), 'pencil-2 article-add');
		// Built the actions for new and existing records.
		if (ComponentbuilderHelper::checkString($this->referral))
		{
			if ($this->canDo->get('fieldtype.create') && $isNew)
			{
				// We can create the record.
				JToolBarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('fieldtype.edit'))
			{
				// We can save the record.
				JToolBarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// Do not creat but cancel.
				JToolBarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// We can close it.
				JToolBarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// For new records, check the create permission.
				if ($this->canDo->get('fieldtype.create'))
				{
					JToolBarHelper::apply('fieldtype.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
					JToolBarHelper::custom('fieldtype.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				JToolBarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('fieldtype.edit'))
				{
					// We can save the new record
					JToolBarHelper::apply('fieldtype.apply', 'JTOOLBAR_APPLY');
					JToolBarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
					// We can save this record, but check the create permission to see
					// if we can return to make a new one.
					if ($this->canDo->get('fieldtype.create'))
					{
						JToolBarHelper::custom('fieldtype.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				$canVersion = ($this->canDo->get('core.version') && $this->canDo->get('fieldtype.version'));
				if ($this->state->params->get('save_history', 1) && $this->canDo->get('fieldtype.edit') && $canVersion)
				{
					JToolbarHelper::versions('com_componentbuilder.fieldtype', $this->item->id);
				}
				if ($this->canDo->get('fieldtype.create'))
				{
					JToolBarHelper::custom('fieldtype.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				JToolBarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		JToolbarHelper::divider();
		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('fieldtype');
		if (ComponentbuilderHelper::checkString($this->help_url))
		{
			JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
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
		$this->document->setTitle(JText::_($isNew ? 'COM_COMPONENTBUILDER_FIELDTYPE_NEW' : 'COM_COMPONENTBUILDER_FIELDTYPE_EDIT'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_componentbuilder/assets/css/fieldtype.css", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		// Add Ajax Token
		$this->document->addScriptDeclaration("var token = '".JSession::getFormToken()."';");

		// Add the CSS for Footable
		$this->document->addStyleSheet('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
		$this->document->addStyleSheet(JURI::root() .'media/com_componentbuilder/footable-v3/css/footable.standalone.min.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		// Add the JavaScript for Footable (adding all funtions)
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/footable-v3/js/footable.min.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');

		$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery('.footable').footable();});});";
		$this->document->addScriptDeclaration($footable);

		$this->document->addScript(JURI::root() . $this->script, (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		$this->document->addScript(JURI::root() . "administrator/components/com_componentbuilder/views/fieldtype/submitbutton.js", (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript'); 

		// get Uikit Version
		$this->uikitVersion = $this->params->get('uikit_version', 2);
		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		$isAdmin = JFactory::getApplication()->isClient('administrator');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Use Uikit Version 2
		if (2 == $this->uikitVersion && ($isAdmin || $uikit != 2))
		{
			// Set css style.
			$style = $this->params->get('uikit_style');
			// only load if needed
			if ($isAdmin || $uikit != 3)
			{
				// add the style sheets
				$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/uikit' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			}
			// add the style sheets
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/accordion' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/tooltip' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/notify' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/form-file' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/progress' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/placeholder' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2//css/components/upload' . $style . $size . '.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			// only load if needed
			if ($isAdmin || $uikit != 3)
			{
				// add JavaScripts
				$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/uikit' . $size . '.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
			}
			// add JavaScripts
			$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/accordion' . $size . '.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
			$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/tooltip' . $size . '.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
			$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/lightbox' . $size . '.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
			$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/notify' . $size . '.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
			$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/upload' . $size . '.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		}
		// Use Uikit Version 3
		elseif (3 == $this->uikitVersion && ($isAdmin || $uikit != 2))
		{
			// add the style sheets
			$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v3/css/uikit'.$size.'.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			// add JavaScripts
			$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v3/js/uikit'.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
			// add icons
			$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v3/js/uikit-icons'.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		}
		// add var key
		$this->document->addScriptDeclaration("var vastDevMod = '" . $this->get('VDM') . "';");
		// add return_here
		$this->document->addScriptDeclaration("var return_here = '" . urlencode(base64_encode((string) JUri::getInstance())) . "';");
		JText::script('view not acceptable. Error');
	}
}
