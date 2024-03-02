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
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use VDM\Joomla\Utilities\StringHelper;

/**
 * Componentbuilder View class
 */
class ComponentbuilderViewComponentbuilder extends HtmlView
{
	/**
	 * View display method
	 * @return void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->icons          = $this->get('Icons');
		$this->contributors   = ComponentbuilderHelper::getContributors();
		$this->wiki = $this->get('Wiki');
		$this->noticeboard = $this->get('Noticeboard');
		$this->readme = $this->get('Readme');
		$this->version = $this->get('Version');

		// get the manifest details of the component
		$this->manifest = ComponentbuilderHelper::manifest();

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
		$canDo = ComponentbuilderHelper::getActions('componentbuilder');
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_DASHBOARD'), 'grid-2');

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('componentbuilder');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
		}

		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_componentbuilder');
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
		$this->document->setTitle(Text::_('COM_COMPONENTBUILDER_DASHBOARD'));

		// add manifest to page JavaScript
		$this->document->addScriptDeclaration("var manifest = jQuery.parseJSON('" . json_encode($this->manifest) . "');", "text/javascript");

		// add dashboard style sheets
		Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/dashboard.css", ['version' => 'auto']);
	}
}
