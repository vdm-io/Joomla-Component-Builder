<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use VDM\Joomla\Utilities\StringHelper;

/**
 * Fieldtype Html View class
 */
class ComponentbuilderViewFieldtype extends HtmlView
{
	/**
	 * display method of View
	 * @return void
	 */
	public function display($tpl = null)
	{
		// set params
		$this->params = ComponentHelper::getParams('com_componentbuilder');
		// Assign the variables
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->script = $this->get('Script');
		$this->state = $this->get('State');
		// get action permissions
		$this->canDo = ComponentbuilderHelper::getActions('fieldtype', $this->item);
		// get input
		$jinput = Factory::getApplication()->input;
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
		Factory::getApplication()->input->set('hidemainmenu', true);
		$user = Factory::getUser();
		$userId	= $user->id;
		$isNew = $this->item->id == 0;

		ToolbarHelper::title( Text::_($isNew ? 'COM_COMPONENTBUILDER_FIELDTYPE_NEW' : 'COM_COMPONENTBUILDER_FIELDTYPE_EDIT'), 'pencil-2 article-add');
		// Built the actions for new and existing records.
		if (StringHelper::check($this->referral))
		{
			if ($this->canDo->get('fieldtype.create') && $isNew)
			{
				// We can create the record.
				ToolbarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('fieldtype.edit'))
			{
				// We can save the record.
				ToolbarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// Do not creat but cancel.
				ToolbarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// We can close it.
				ToolbarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// For new records, check the create permission.
				if ($this->canDo->get('fieldtype.create'))
				{
					ToolbarHelper::apply('fieldtype.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
					ToolbarHelper::custom('fieldtype.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				ToolbarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('fieldtype.edit'))
				{
					// We can save the new record
					ToolbarHelper::apply('fieldtype.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('fieldtype.save', 'JTOOLBAR_SAVE');
					// We can save this record, but check the create permission to see
					// if we can return to make a new one.
					if ($this->canDo->get('fieldtype.create'))
					{
						ToolbarHelper::custom('fieldtype.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				$canVersion = ($this->canDo->get('core.version') && $this->canDo->get('fieldtype.version'));
				if ($this->state->params->get('save_history', 1) && $this->canDo->get('fieldtype.edit') && $canVersion)
				{
					ToolbarHelper::versions('com_componentbuilder.fieldtype', $this->item->id);
				}
				if ($this->canDo->get('fieldtype.create'))
				{
					ToolbarHelper::custom('fieldtype.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				ToolbarHelper::cancel('fieldtype.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		ToolbarHelper::divider();
		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('fieldtype');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
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
			return StringHelper::html($var, $this->_charset, true, 30);
		}
		// use the helper htmlEscape method instead.
		return StringHelper::html($var, $this->_charset);
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$isNew = ($this->item->id < 1);
		$this->getDocument()->setTitle(Text::_($isNew ? 'COM_COMPONENTBUILDER_FIELDTYPE_NEW' : 'COM_COMPONENTBUILDER_FIELDTYPE_EDIT'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/fieldtype.css", ['version' => 'auto']);
		// Add Ajax Token
		$this->getDocument()->addScriptDeclaration("var token = '" . Session::getFormToken() . "';");

		// Add the CSS for Footable
		Html::_('stylesheet', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', ['version' => 'auto']);
		Html::_('stylesheet', 'media/com_componentbuilder/footable-v3/css/footable.standalone.min.css', ['version' => 'auto']);
		// Add the JavaScript for Footable (adding all functions)
		Html::_('script', 'media/com_componentbuilder/footable-v3/js/footable.min.js', ['version' => 'auto']);

		$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery('.footable').footable();});});";
		$this->getDocument()->addScriptDeclaration($footable);

		Html::_('script', $this->script, ['version' => 'auto']);
		Html::_('script', "administrator/components/com_componentbuilder/views/fieldtype/submitbutton.js", ['version' => 'auto']);

		// get Uikit Version
		$this->uikitVersion = $this->params->get('uikit_version', 2);
		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		$isAdmin = Factory::getApplication()->isClient('administrator');
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
				Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit' . $style . $size . '.css' , ['version' => 'auto']);
			}
			// add the style sheets
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/accordion' . $style . $size . '.css' , ['version' => 'auto']);
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/tooltip' . $style . $size . '.css' , ['version' => 'auto']);
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/notify' . $style . $size . '.css' , ['version' => 'auto']);
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/form-file' . $style . $size . '.css' , ['version' => 'auto']);
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/progress' . $style . $size . '.css' , ['version' => 'auto']);
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/placeholder' . $style . $size . '.css' , ['version' => 'auto']);
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2//css/components/upload' . $style . $size . '.css' , ['version' => 'auto']);
			// only load if needed
			if ($isAdmin || $uikit != 3)
			{
				// add JavaScripts
				Html::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit' . $size . '.js', ['version' => 'auto']);
			}
			// add JavaScripts
			Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/accordion' . $size . '.js', ['version' => 'auto']);
			Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/tooltip' . $size . '.js', ['version' => 'auto']);
			Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/lightbox' . $size . '.js', ['version' => 'auto']);
			Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/notify' . $size . '.js', ['version' => 'auto']);
			Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/upload' . $size . '.js', ['version' => 'auto']);
		}
		// Use Uikit Version 3
		elseif (3 == $this->uikitVersion && ($isAdmin || $uikit != 2))
		{
			// add the style sheets
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v3/css/uikit'.$size.'.css', ['version' => 'auto']);
			// add JavaScripts
			Html::_('script', 'media/com_componentbuilder/uikit-v3/js/uikit'.$size.'.js', ['version' => 'auto']);
			// add icons
			Html::_('script', 'media/com_componentbuilder/uikit-v3/js/uikit-icons'.$size.'.js', ['version' => 'auto']);
		}
		// add var key
		$this->document->addScriptDeclaration("var vastDevMod = '" . $this->get('VDM') . "';");
		// add return_here
		$this->document->addScriptDeclaration("var return_here = '" . urlencode(base64_encode((string) JUri::getInstance())) . "';");
		Text::script('view not acceptable. Error');
	}

	/**
	 * Get the Document (helper method toward Joomla 4 and 5)
	 */
	public function getDocument()
	{
		$this->document ??= JFactory::getDocument();

		return $this->document;
	}
}
