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
use VDM\Joomla\Utilities\ArrayHelper;

/**
 * Joomla_plugin Html View class
 */
class ComponentbuilderViewJoomla_plugin extends HtmlView
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
		$this->canDo = ComponentbuilderHelper::getActions('joomla_plugin', $this->item);
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

		ToolbarHelper::title( Text::_($isNew ? 'COM_COMPONENTBUILDER_JOOMLA_PLUGIN_NEW' : 'COM_COMPONENTBUILDER_JOOMLA_PLUGIN_EDIT'), 'pencil-2 article-add');
		// Built the actions for new and existing records.
		if (StringHelper::check($this->referral))
		{
			if ($this->canDo->get('joomla_plugin.create') && $isNew)
			{
				// We can create the record.
				ToolbarHelper::save('joomla_plugin.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('joomla_plugin.edit'))
			{
				// We can save the record.
				ToolbarHelper::save('joomla_plugin.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// Do not creat but cancel.
				ToolbarHelper::cancel('joomla_plugin.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// We can close it.
				ToolbarHelper::cancel('joomla_plugin.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// For new records, check the create permission.
				if ($this->canDo->get('joomla_plugin.create'))
				{
					ToolbarHelper::apply('joomla_plugin.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('joomla_plugin.save', 'JTOOLBAR_SAVE');
					ToolbarHelper::custom('joomla_plugin.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				ToolbarHelper::cancel('joomla_plugin.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('joomla_plugin.edit'))
				{
					// We can save the new record
					ToolbarHelper::apply('joomla_plugin.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('joomla_plugin.save', 'JTOOLBAR_SAVE');
					// We can save this record, but check the create permission to see
					// if we can return to make a new one.
					if ($this->canDo->get('joomla_plugin.create'))
					{
						ToolbarHelper::custom('joomla_plugin.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				$canVersion = ($this->canDo->get('core.version') && $this->canDo->get('joomla_plugin.version'));
				if ($this->state->params->get('save_history', 1) && $this->canDo->get('joomla_plugin.edit') && $canVersion)
				{
					ToolbarHelper::versions('com_componentbuilder.joomla_plugin', $this->item->id);
				}
				if ($this->canDo->get('joomla_plugin.create'))
				{
					ToolbarHelper::custom('joomla_plugin.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				ToolbarHelper::cancel('joomla_plugin.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		ToolbarHelper::divider();
		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('joomla_plugin');
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
		$this->getDocument()->setTitle(Text::_($isNew ? 'COM_COMPONENTBUILDER_JOOMLA_PLUGIN_NEW' : 'COM_COMPONENTBUILDER_JOOMLA_PLUGIN_EDIT'));
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/joomla_plugin.css", ['version' => 'auto']);
		// Add Ajax Token
		$this->getDocument()->addScriptDeclaration("var token = '" . Session::getFormToken() . "';");
		Html::_('script', $this->script, ['version' => 'auto']);
		Html::_('script', "administrator/components/com_componentbuilder/views/joomla_plugin/submitbutton.js", ['version' => 'auto']);


		// add the Uikit v2 style sheets
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit.gradient.min.css', ['version' => 'auto']);
		// add Uikit v2 JavaScripts
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit.min.js', ['version' => 'auto']);

		// add the Uikit v2 extra style sheets
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/notify.gradient.min.css', ['version' => 'auto']);
		// add Uikit v2 extra JavaScripts
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/lightbox.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/notify.min.js', ['version' => 'auto']);
		// Add the JavaScript for JStore
		Html::_('script', 'media/com_componentbuilder/js/jquery.json.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/js/jstorage.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/js/strtotime.js', ['version' => 'auto']);
		// add var key
		$this->document->addScriptDeclaration("var vastDevMod = '" . $this->get('VDM') . "';");
		// add return_here
		$this->document->addScriptDeclaration("var return_here = '" . urlencode(base64_encode((string) \JUri::getInstance())) . "';");
		// set some lang
		Text::script('COM_COMPONENTBUILDER_ALREADY_SELECTED_TRY_ANOTHER');
		Text::script('COM_COMPONENTBUILDER_TYPE_OR_SELECT_SOME_OPTIONS');
		Text::script('COM_COMPONENTBUILDER_NO_RESULTS_MATCH');
		Text::script('COM_COMPONENTBUILDER_SELECT_A_PROPERTY');
		Text::script('COM_COMPONENTBUILDER_NO_DESCRIPTION_FOUND');
		// check if we should use browser storage
		$setBrowserStorage = $this->params->get('set_browser_storage', null);
		if ($setBrowserStorage)
		{
			// check what (Time To Live) show we use
			$storageTimeToLive = $this->params->get('storage_time_to_live', 'global');
			if ('global' == $storageTimeToLive)
			{
				// use the global session time
				$session = Factory::getSession();
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
		$this->document->addScriptDeclaration("selectionArray = {'property':{},'method':{}};");
		// add a few field options via PHP
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
		$tmp_ = JFormHelper::loadFieldType('joomlaplugingroups')->options;
		if (ArrayHelper::check($tmp_))
		{
			$_tmp = array();
			foreach ($tmp_ as $item)
			{
				$_tmp[$item->value] = $item->text;
			}
			// Set the values to JavaScript
			$this->document->addScriptDeclaration("selectionArray['joomla_plugin_group'] = ". json_encode($_tmp) . ";");
		}
		$tmp_ = JFormHelper::loadFieldType('pluginsclassproperties')->options;
		if (ArrayHelper::check($tmp_))
		{
			$_tmp = array();
			foreach ($tmp_ as $item)
			{
				$_tmp[$item->value] = $item->text;
			}
			// Set the values to JavaScript
			$this->document->addScriptDeclaration("selectionArray['property'] = ". json_encode($_tmp) . ";");
		}
		$tmp_ = JFormHelper::loadFieldType('pluginsclassmethods')->options;
		if (ArrayHelper::check($tmp_))
		{
			$_tmp = array();
			foreach ($tmp_ as $item)
			{
				$_tmp[$item->value] = $item->text;
			}
			// Set the values to JavaScript
			$this->document->addScriptDeclaration("selectionArray['method'] = ". json_encode($_tmp) . ";");
		}
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
