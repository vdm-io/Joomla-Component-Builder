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

use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Form\Form;
use VDM\Joomla\Componentbuilder\Search\Factory as SearchFactory;

/**
 * Componentbuilder Html View class for the Search
 */
class ComponentbuilderViewSearch extends HtmlView
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = JComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app = JFactory::getApplication();
		// get the user object
		$this->user = JFactory::getUser();
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('search');
		// Initialise variables.
		$this->item = $this->get('Item');
		$this->urlvalues = $this->get('UrlValues');
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('search');
			JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=search');
			$this->sidebar = JHtmlSidebar::render();
		}
		
		// get the needed form fields
		$this->form = $this->getDynamicForm();
		
		// build our table headers
		$this->table_headers = array(
			'edit' => 'E',
			'code' => JText::_('COM_COMPONENTBUILDER_FOUND_TEXT'),
			'table' => JText::_('COM_COMPONENTBUILDER_TABLE'),
			'field' => JText::_('COM_COMPONENTBUILDER_FIELD'),
			'id' => JText::_('ID'),
			'line' => JText::_('COM_COMPONENTBUILDER_LINE')
		);
		
		// set some JavaScript Language
		JText::script('COM_COMPONENTBUILDER_YOUR_ARE_ABOUT_TO_UPDATE_ROW');
		JText::script('COM_COMPONENTBUILDER_FIELD_IN_THE');
		JText::script('COM_COMPONENTBUILDER_TABLE');
		JText::script('COM_COMPONENTBUILDER_THIS_CAN_NOT_BE_UNDONE_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE');
		JText::script('COM_COMPONENTBUILDER_YOUR_ARE_ABOUT_TO_REPLACE_BALLB_SEARCH_RESULTS');
		JText::script('COM_COMPONENTBUILDER_THIS_CAN_NOT_BE_UNDONE_BYOU_HAVE_BEEN_WARNEDB');
		JText::script('COM_COMPONENTBUILDER_ARE_YOU_THEREFORE_ABSOLUTELY_SURE_YOU_WANT_TO_CONTINUE');
		JText::script('COM_COMPONENTBUILDER_SEARCH_FINISHED_IN');
		JText::script('COM_COMPONENTBUILDER_SECONDS');
		

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// add the tool bar
			$this->addToolBar();
		}

		// set the document
		$this->setDocument();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode(PHP_EOL, $errors), 500);
		}

		parent::display($tpl);
	}

	/**
	 * Get the dynamic build form fields needed on the page
	 *
	 * @return  Form|null  The array of form fields
	 *
	 * @since   3.2.0
	 */
	public function getDynamicForm(): ?Form
	{
		if(ComponentbuilderHelper::checkArray($this->item) &&
			ComponentbuilderHelper::checkArray($this->item['tables']) &&
			ComponentbuilderHelper::checkArray($this->item['components']))
		{
			// start the form
			$form = new Form('Search');

			$form->load('<form
				addrulepath="/administrator/components/com_componentbuilder/models/rules"
				addfieldpath="/administrator/components/com_componentbuilder/models/fields">
					<fieldset name="search"></fieldset>
					<fieldset name="settings"></fieldset>
					<fieldset name="view"></fieldset>
			</form>');

			// Search Mode
			$attributes = [
				'type' => 'radio',
				'name' => 'type_search',
				'label' => 'COM_COMPONENTBUILDER_MODE',
				'class' => 'btn-group',
				'description' => 'COM_COMPONENTBUILDER_SEARCH_OR_SEARCH_AND_REPLACE',
				'default' => $this->urlvalues['type_search']];
			// set the mode options
			$options = [
				1 => 'COM_COMPONENTBUILDER_SEARCH',
				2 => 'COM_COMPONENTBUILDER_REPLACE'];
			// add to form
			$xml = ComponentbuilderHelper::getFieldXML($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'search');
			}

			// search text attributes
			$attributes = [
				'type' => 'text',
				'name' => 'search_value',
				'label' => 'COM_COMPONENTBUILDER_SEARCH',
				'size' => 150,
				'maxlength' => 200,
				'description' => 'COM_COMPONENTBUILDER_HERE_YOU_CAN_ENTER_YOUR_SEARCH_TEXT',
				'filter' => 'RAW',
				'class' => 'search-value span12',
				'hint' => 'COM_COMPONENTBUILDER_ENTER_YOUR_SEARCH_TEXT',
				'autocomplete' => true,
				'default' => $this->urlvalues['search_value']];
			// add to form
			$xml = ComponentbuilderHelper::getFieldXML($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'search');
			}

			// replace text attributes
			$attributes = [
				'type' => 'text',
				'name' => 'replace_value',
				'label' => 'COM_COMPONENTBUILDER_REPLACE',
				'size' => 150,
				'maxlength' => 200,
				'description' => 'COM_COMPONENTBUILDER_HERE_YOU_CAN_ENTER_THE_REPLACE_TEXT_THAT_YOU_WOULD_LIKE_TO_USE_AS_REPLACEMENT_FOR_THE_SEARCH_TEXT_FOUND',
				'filter' => 'RAW',
				'class' => 'replace-value span12',
				'hint' => 'COM_COMPONENTBUILDER_ENTER_YOUR_REPLACE_TEXT',
				'autocomplete' => true,
				'showon' => 'type_search:2',
				'default' => $this->urlvalues['replace_value']];
			// add to form
			$xml = ComponentbuilderHelper::getFieldXML($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'search');
			}

			// Search Behaviour
			$default = [];
			if ($this->urlvalues['match_case'] == 1)
			{
				$default[] = 'match_case';
			}
			if ($this->urlvalues['whole_word'] == 1)
			{
				$default[] = 'whole_word';
			}
			if ($this->urlvalues['regex_search'] == 1)
			{
				$default[] = 'regex_search';
			}
			$attributes = [
				'type' => 'checkboxes',
				'name' => 'search_behaviour',
				'label' => 'COM_COMPONENTBUILDER_BEHAVIOUR',
				'description' => 'COM_COMPONENTBUILDER_SET_THE_SEARCH_BEHAVIOUR_HERE'];
			if (ComponentbuilderHelper::checkArray($default))
			{
				$attributes['default'] = implode(',', $default);
			}
			// set the mode options
			$options = [
				'match_case' => 'COM_COMPONENTBUILDER_MATCH_CASE',
				'whole_word' => 'COM_COMPONENTBUILDER_WHOLE_WORD',
				'regex_search' => 'COM_COMPONENTBUILDER_REGEX_SEARCH'];
			// add to form
			$xml = ComponentbuilderHelper::getFieldXML($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'settings');
			}

			// component attributes
			$attributes = [
				'type' => 'list',
				'name' => 'component_id',
				'label' => 'COM_COMPONENTBUILDER_COMPONENTS_BR_SMALLDISABLED_SOONSMALL',
				'class' => 'list_class',
				'description' => 'COM_COMPONENTBUILDER_SELECT_THE_COMPONENT_TO_SEARCH',
				'required' => 'true',
				'disable' => 'true',
				'readonly' => 'true',
				'default' => -1];
			// start the component options
			$options = [];
			$options['-1'] = 'COM_COMPONENTBUILDER__SEARCH_ALL_';
			// load component options from array
			foreach($this->item['components'] as $component)
			{
				$options[(int) $component->id] = $this->escape($component->name);
			}
			// add to form
			$xml = ComponentbuilderHelper::getFieldXML($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'settings');
			}

			// table attributes
			$attributes = [
				'type' => 'list',
				'name' => 'table_name',
				'label' => 'COM_COMPONENTBUILDER_TABLES',
				'class' => 'list_class',
				'description' => 'COM_COMPONENTBUILDER_SELECT_THE_TABLE_TO_SEARCH',
				'required' => 'true',
				'default' => -1];
			// start the component options
			$options = [];
			$options['-1'] = 'COM_COMPONENTBUILDER__SEARCH_ALL_';
			// load table options from array
			foreach($this->item['tables'] as $table)
			{
				$options[$table] = $this->escape($table);
			}
			// add to form
			$xml = ComponentbuilderHelper::getFieldXML($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'settings');
			}

			// editor attributes
			$attributes = [
				'type' => 'editor',
				'name' => 'item_code',
				'label' => 'COM_COMPONENTBUILDER_ITEM_CODE',
				'width' => '100%',
				'height' => '150px',
				'class' => 'item_code_editor',
				'syntax' => 'php',
				'buttons' => 'false',
				'filter' => 'raw',
				'editor' => 'codemirror|none'];
			// add to form
			$xml = ComponentbuilderHelper::getFieldXML($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'view');
			}

			// return the form array
			return $form;
		}

		return null;
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
		$HeaderCheck = new componentbuilderHeaderCheck;

		// always load these files.
		$this->document->addStyleSheet(JURI::root(true) . "/media/com_componentbuilder/datatable/css/datatables.min.css", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/css");
		$this->document->addScript(JURI::root(true) . "/media/com_componentbuilder/datatable/js/pdfmake.min.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");
		$this->document->addScript(JURI::root(true) . "/media/com_componentbuilder/datatable/js/vfs_fonts.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");
		$this->document->addScript(JURI::root(true) . "/media/com_componentbuilder/datatable/js/datatables.min.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");

		// Add View JavaScript File
		$this->document->addScript(JURI::root(true) . "/administrator/components/com_componentbuilder/assets/js/search.js", (ComponentbuilderHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			JHtml::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit'.$style.$size.'.css', ['version' => 'auto']);
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			JHtml::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit'.$size.'.js', ['version' => 'auto']);
		}

		// Load the script to find all uikit components needed.
		if ($uikit != 2)
		{
			// Set the default uikit components in this view.
			$uikitComp = array();
			$uikitComp[] = 'UIkit.notify';
			$uikitComp[] = 'uk-progress';
		}

		// Load the needed uikit components in this view.
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
					if (File::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						JHtml::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css', ['version' => 'auto']);
					}
					// check if the JavaScript file exists.
					if (File::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						JHtml::_('script', 'media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);
					}
				}
			}
		}
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_componentbuilder/assets/css/search.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// hide the main menu
		$this->app->input->set('hidemainmenu', true);
		// set the title
		if (isset($this->item->name) && $this->item->name)
		{
			$title = $this->item->name;
		}
		// Check for empty title and add view name if param is set
		if (empty($title))
		{
			$title = JText::_('COM_COMPONENTBUILDER_SEARCH');
		}
		// add title to the page
		JToolbarHelper::title($title,'search');
		// add cpanel button
		JToolBarHelper::custom('search.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('search.compiler'))
		{
			// add Compiler button.
			JToolBarHelper::custom('search.openCompiler', 'cogs custom-button-opencompiler', '', 'COM_COMPONENTBUILDER_COMPILER', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('search');
		if (ComponentbuilderHelper::checkString($this->help_url))
		{
			JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
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
?>
