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
namespace VDM\Component\Componentbuilder\Administrator\View\Search;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\User\User;
use Joomla\CMS\Document\Document;
use VDM\Component\Componentbuilder\Administrator\Helper\HeaderCheck;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\Filesystem\File;
use VDM\Joomla\Componentbuilder\Search\Factory as SearchFactory;
use Joomla\CMS\Form\Form;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\FormHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
\defined('_JEXEC') or die; 

/**
 * Componentbuilder Html View class for the Search
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @since  1.6
	 */
	public function display($tpl = null)
	{
		// get component params
		$this->params = ComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app ??= Factory::getApplication();
		// get the user object
		$this->user ??= Factory::getApplication()->getIdentity();
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('search');
		$this->styles = $this->get('Styles');
		$this->scripts = $this->get('Scripts');
		// Initialise variables.
		$this->item = $this->get('Item');
		$this->urlvalues = $this->get('UrlValues');
		// get the needed form fields
		$this->form = $this->getDynamicForm();
		
		// build our table headers
		$this->table_headers = array(
			'edit' => 'E',
			'code' => Text::_('COM_COMPONENTBUILDER_FOUND_TEXT'),
			'table' => Text::_('COM_COMPONENTBUILDER_TABLE'),
			'field' => Text::_('COM_COMPONENTBUILDER_FIELD'),
			'id' => Text::_('ID'),
			'line' => Text::_('COM_COMPONENTBUILDER_LINE')
		);
		
		// set some JavaScript Language
		Text::script('COM_COMPONENTBUILDER_YOUR_ARE_ABOUT_TO_UPDATE_ROW');
		Text::script('COM_COMPONENTBUILDER_FIELD_IN_THE');
		Text::script('COM_COMPONENTBUILDER_TABLE');
		Text::script('COM_COMPONENTBUILDER_THIS_CAN_NOT_BE_UNDONE_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE');
		Text::script('COM_COMPONENTBUILDER_YOUR_ARE_ABOUT_TO_UPDATE_BALLB_VALUES_THAT_CAN_BE_FOUND_IN_THE_DATABASE');
		Text::script('COM_COMPONENTBUILDER_YOU_WILL_REPLACE');
		Text::script('COM_COMPONENTBUILDER_WITH');
		Text::script('COM_COMPONENTBUILDER_THIS_CAN_NOT_BE_UNDONE_BYOU_HAVE_BEEN_WARNEDB');
		Text::script('COM_COMPONENTBUILDER_ARE_YOU_THEREFORE_ABSOLUTELY_SURE_YOU_WANT_TO_CONTINUE');
		Text::script('COM_COMPONENTBUILDER_THE_SEARCH_PROCESS_HAD_AN_ERROR_WITH_TABLE');
		Text::script('COM_COMPONENTBUILDER_THE_REPLACE_PROCESS_HAD_AN_ERROR_WITH_TABLE');
		Text::script('COM_COMPONENTBUILDER_REPLACE_PROCESS_COMPLETE');
		Text::script('COM_COMPONENTBUILDER_SEARCHING');
		Text::script('COM_COMPONENTBUILDER_TABLES_WITH');
		Text::script('COM_COMPONENTBUILDER_FIELDS_THAT_HAD');
		Text::script('COM_COMPONENTBUILDER_LINES');
		Text::script('COM_COMPONENTBUILDER_AND_FINISHED_THE_SEARCH_IN');
		Text::script('COM_COMPONENTBUILDER_SECONDS');
		Text::script('COM_COMPONENTBUILDER_WOULD_YOU_LIKE_TO_DO_A_REVERSE_SEARCH');
		Text::script('COM_COMPONENTBUILDER_WOULD_YOU_LIKE_TO_REPEAT_THE_SAME_SEARCH');
		Text::script('COM_COMPONENTBUILDER_YES_UPDATE_ALL');
		Text::script('COM_COMPONENTBUILDER_NO');
		Text::script('COM_COMPONENTBUILDER_YES');
		// just get it on the page for now....
		ToolbarHelper::inlinehelp();

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// add the tool bar
			$this->addToolBar();
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \Exception(implode(PHP_EOL, $errors), 500);
		}

		parent::display($tpl);

		// Set the html view document stuff
		$this->_prepareDocument();
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
		if(ArrayHelper::check($this->item) &&
			ArrayHelper::check($this->item['tables']) &&
			ArrayHelper::check($this->item['components']))
		{
			// start the form
			$form = new Form('Search');

			$form->load('<form
				addruleprefix="VDM\Component\Componentbuilder\Administrator\Rule"
				addfieldprefix="VDM\Component\Componentbuilder\Administrator\Field">
					<config><inlinehelp button="show"/></config>
					<fieldset name="search"></fieldset>
					<fieldset name="settings"></fieldset>
					<fieldset name="view"></fieldset>
			</form>');

			// Search Mode
			$attributes = [
				'type' => 'radio',
				'name' => 'type_search',
				'hiddenLabel' => true,
				'label' => 'COM_COMPONENTBUILDER_MODE',
				'class' => 'btn-group',
				'description' => 'COM_COMPONENTBUILDER_SEARCH_OR_SEARCH_AND_REPLACE',
				'default' => $this->urlvalues['type_search']];
			// set the mode options
			$options = [
				1 => 'COM_COMPONENTBUILDER_SEARCH',
				2 => 'COM_COMPONENTBUILDER_REPLACE',
				0 => 'COM_COMPONENTBUILDER_CLEAR'];
			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof \SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'search');
			}

			// search text attributes
			$attributes = [
				'type' => 'text',
				'name' => 'search_value',
				'hiddenLabel' => 'true',
				'label' => 'COM_COMPONENTBUILDER_SEARCH',
				'size' => 150,
				'maxlength' => 200,
				'description' => 'COM_COMPONENTBUILDER_HERE_YOU_CAN_ENTER_YOUR_SEARCH_TEXT',
				'filter' => 'RAW',
				'class' => 'search-value',
				'hint' => 'COM_COMPONENTBUILDER_ENTER_YOUR_SEARCH_TEXT',
				'autocomplete' => true,
				'default' => $this->urlvalues['search_value']];
			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof \SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'search');
			}

			// replace text attributes
			$attributes = [
				'type' => 'text',
				'name' => 'replace_value',
				'hiddenLabel' => 'true',
				'label' => 'COM_COMPONENTBUILDER_REPLACE',
				'size' => 150,
				'maxlength' => 200,
				'description' => 'COM_COMPONENTBUILDER_HERE_YOU_CAN_ENTER_THE_REPLACE_TEXT_THAT_YOU_WOULD_LIKE_TO_USE_AS_REPLACEMENT_FOR_THE_SEARCH_TEXT_FOUND',
				'filter' => 'RAW',
				'class' => 'replace-value',
				'hint' => 'COM_COMPONENTBUILDER_ENTER_YOUR_REPLACE_TEXT',
				'autocomplete' => true,
				'showon' => 'type_search:2',
				'default' => $this->urlvalues['replace_value']];
			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof \SimpleXMLElement)
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
			if (ArrayHelper::check($default))
			{
				$attributes['default'] = implode(',', $default);
			}
			// set the mode options
			$options = [
				'match_case' => 'COM_COMPONENTBUILDER_MATCH_CASE',
				'whole_word' => 'COM_COMPONENTBUILDER_WHOLE_WORD',
				'regex_search' => 'COM_COMPONENTBUILDER_REGEX_SEARCH'];
			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof \SimpleXMLElement)
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
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof \SimpleXMLElement)
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
				'default' => $this->urlvalues['table_name']];
			// start the component options
			$options = [];
			$options['-1'] = 'COM_COMPONENTBUILDER__SEARCH_ALL_';
			// load table options from array
			foreach($this->item['tables'] as $table)
			{
				$options[$table] = $this->escape($table);
			}
			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof \SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'settings');
			}

			// editor attributes
			$attributes = [
				'type' => 'editor',
				'name' => 'item_code',
				'label' => 'COM_COMPONENTBUILDER_ITEM_CODE',
				'width' => '100%',
				'height' => '350px',
				'class' => 'item_code_editor',
				'syntax' => 'php',
				'buttons' => 'false',
				'filter' => 'raw',
				'editor' => 'codemirror|none'];
			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof \SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'view');
			}

			// return the form array
			return $form;
		}

		return null;
	}

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{

		// Only load jQuery if needed. (default is true)
		if ($this->params->get('add_jquery_framework', 1) == 1)
		{
			Html::_('jquery.framework');
		}
		// Load the header checker class.
		// Initialize the header checker.
		$HeaderCheck = new HeaderCheck();

		// always load these files.
		Html::_('stylesheet', "media/com_componentbuilder/datatable/css/datatables.min.css", ['version' => 'auto']);
		Html::_('script', "media/com_componentbuilder/datatable/js/pdfmake.min.js", ['version' => 'auto']);
		Html::_('script', "media/com_componentbuilder/datatable/js/vfs_fonts.js", ['version' => 'auto']);
		Html::_('script', "media/com_componentbuilder/datatable/js/datatables.min.js", ['version' => 'auto']);

		// Add View JavaScript File
		Html::_('script', "administrator/components/com_componentbuilder/assets/js/search.js", ['version' => 'auto']);

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit'.$style.$size.'.css', ['version' => 'auto']);
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			Html::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit'.$size.'.js', ['version' => 'auto']);
		}

		// Load the script to find all uikit components needed.
		if ($uikit != 2)
		{
			// Set the default uikit components in this view.
			$uikitComp = [];
			$uikitComp[] = 'UIkit.notify';
			$uikitComp[] = 'uk-progress';
		}

		// Load the needed uikit components in this view.
		if ($uikit != 2 && isset($uikitComp) && ArrayHelper::check($uikitComp))
		{
			// loading...
			foreach ($uikitComp as $class)
			{
				foreach (ComponentbuilderHelper::$uk_components[$class] as $name)
				{
					// check if the CSS file exists.
					if (File::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css', ['version' => 'auto']);
					}
					// check if the JavaScript file exists.
					if (File::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);
					}
				}
			}
		}
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
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
			$title = Text::_('COM_COMPONENTBUILDER_SEARCH');
		}
		// add title to the page
		ToolbarHelper::title($title,'search');
		// add cpanel button
		ToolbarHelper::custom('search.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('search.compiler'))
		{
			// add Compiler button.
			ToolbarHelper::custom('search.openCompiler', 'cogs custom-button-opencompiler', '', 'COM_COMPONENTBUILDER_COMPILER', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('search');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_componentbuilder');
		}
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var     The output to escape.
	 * @param   bool   $shorten The switch to shorten.
	 * @param   int    $length  The shorting length.
	 *
	 * @return  mixed  The escaped value.
	 * @since   1.6
	 */
	public function escape($var, bool $shorten = false, int $length = 40)
	{
		if (!is_string($var))
		{
			return $var;
		}

		return StringHelper::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}
}
