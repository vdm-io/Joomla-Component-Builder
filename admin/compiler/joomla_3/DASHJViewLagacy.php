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
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

###DASH_VIEW_HTML_HEADER###

/**
 * ###Component### View class
 */
class ###Component###View###Component### extends HtmlView
{
	/**
	 * View display method
	 * @return void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->icons          = $this->get('Icons');
		$this->contributors   = ###Component###Helper::getContributors();###DASH_GET_CUSTOM_DATA###

		// get the manifest details of the component
		$this->manifest = ###Component###Helper::manifest();

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
		$canDo = ###Component###Helper::getActions('###component###');
		ToolbarHelper::title(Text::_('COM_###COMPONENT###_DASHBOARD'), 'grid-2');

		// set help url for this view if found
		$this->help_url = ###Component###Helper::getHelpUrl('###component###');
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($this->help_url))
		{
			ToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}

		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_###component###');
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		if (!isset($this->document))
		{
			$this->document = Factory::getDocument();
		}
		// set page title
		$this->document->setTitle(Text::_('COM_###COMPONENT###_DASHBOARD'));

		// add manifest to page JavaScript
		$this->document->addScriptDeclaration("var manifest = jQuery.parseJSON('" . json_encode($this->manifest) . "');", "text/javascript");

		// add dashboard style sheets
		Html::_('stylesheet', "administrator/components/com_###component###/assets/css/dashboard.css", ['version' => 'auto']);
	}
}
