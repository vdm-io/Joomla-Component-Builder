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
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Layout\LayoutHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\FormHelper;
use VDM\Joomla\Utilities\StringHelper;

/**
 * Componentbuilder Html View class for the Compiler
 */
class ComponentbuilderViewCompiler extends HtmlView
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = ComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app = Factory::getApplication();
		// get the user object
		$this->user    = Factory::getUser();
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('compiler');
		// Initialise variables.
		$this->items = $this->get('Items');
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('compiler');
			JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=compiler');
			$this->sidebar = JHtmlSidebar::render();
		}
		// get the success message if set
		$this->SuccessMessage = $this->app->getUserState('com_componentbuilder.success_message', false);
		
		// get active components
		$this->Components = $this->get('Components');
		
		// get the needed form fields
		$this->form = $this->getDynamicForm();
		
		// set the compiler artwork from global settings
		$this->builder_gif_size = $this->params->get('builder_gif_size', '480-272');
		
		// only run these checks if he has access
		if ($this->canDo->get('compiler.compiler_animations'))
		{
			// if the new artwork is not being targeted hide download option of artwork
			if ('480-540' !== $this->builder_gif_size)
			{
				$this->canDo->set('compiler.compiler_animations', false);
			}
			// we count of all the files are already there
			else
			{
				$directory_path = JPATH_ROOT . "/administrator/components/com_componentbuilder/assets/images/builder-gif";
				// get all the gif files in the gif folder
				$all_gifs = null;
				if (is_dir($directory_path) && is_readable($directory_path))
				{
					$all_gifs = scandir($directory_path);
				
				}
		
				// check if we have any values
				if ($all_gifs !== null && ArrayHelper::check($all_gifs))
				{
					// count number of files but remove the 2 dot values
					$num_gifs = count($all_gifs) - 2;
					// if we have more or the same number of files that are in the array, the we hide the download option
					if ($num_gifs >= ComponentbuilderHelper::getDynamicContentSize('builder-gif', '480-540'))
					{
						$this->canDo->set('compiler.compiler_animations', false);
					}
				}
			}
		}
		

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
			throw new \Exception(implode(PHP_EOL, $errors), 500);
		}

		// Display the template
		parent::display($tpl);
	}

	// These are subform layouts used in JCB
	// LayoutHelper::render('sectionjcb', [?]); // added to ensure the layout are loaded
	// LayoutHelper::render('repeatablejcb', [?]); // added to ensure the layout are loaded

	/**
	 * Get the dynamic build form fields needed on the page
	 *
	 * @return  Form|null  The form fields
	 *
	 * @since   3.2.0
	 */
	public function getDynamicForm(): ?Form
	{		
		if(ArrayHelper::check($this->Components))
		{
			// start the form
			$form = new Form('Builder');

			$form->load('<form
				addrulepath="/administrator/components/com_componentbuilder/models/rules"
				addfieldpath="/administrator/components/com_componentbuilder/models/fields">
					<fieldset name="builder"></fieldset>
					<fieldset name="advanced"></fieldset>
			</form>');

			// sales attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'backup',
				'label' => 'COM_COMPONENTBUILDER_ADD_TO_BACKUP_FOLDER_AMP_SALES_SERVER_SMALLIF_SETSMALL',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_THE_ZIPPED_PACKAGE_OF_THE_COMPONENT_BE_MOVED_TO_THE_LOCAL_BACKUP_AND_REMOTE_SALES_SERVER_THIS_IS_ONLY_APPLICABLE_IF_THIS_COMPONENT_HAS_THOSE_VALUES_SET',
				'default' => '0'];
			// set the sales options
			$options = [
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// repository attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'repository',
				'label' => 'COM_COMPONENTBUILDER_ADD_TO_REPOSITORY_FOLDER',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_THE_COMPONENT_BE_MOVED_TO_YOUR_LOCAL_REPOSITORY_FOLDER',
				'default' => '1'];
			// start the repository options
			$options = [
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// placeholders attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'add_placeholders',
				'label' => 'COM_COMPONENTBUILDER_ADD_CUSTOM_CODE_PLACEHOLDERS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_JCB_INSERT_THE_CUSTOM_CODE_PLACEHOLDERS_THIS_IS_ONLY_APPLICABLE_IF_THIS_COMPONENT_HAS_CUSTOM_CODE',
				'default' => '2'];
			// start the placeholders options
			$options = [
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// debuglinenr attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'debug_line_nr',
				'label' => 'COM_COMPONENTBUILDER_DEBUG_LINE_NUMBERS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_ADD_CORRESPONDING_LINE_NUMBERS_TO_THE_DYNAMIC_COMMENTS_SO_TO_SEE_WHERE_IN_THE_COMPILER_THE_LINES_OF_CODE_WAS_BUILD_THIS_WILL_HELP_IF_YOU_NEED_TO_GET_MORE_TECHNICAL_WITH_AN_ISSUE_ON_GITHUB_OR_EVEN_FOR_YOUR_OWN_DEBUGGING',
				'default' => '2'];
			$options = [
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// minify attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'minify',
				'label' => 'COM_COMPONENTBUILDER_MINIFY_JAVASCRIPT',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_THE_JAVASCRIPT_BE_MINIFIED_IN_THE_COMPONENT',
				'default' => '2'];
			$options = [
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// powers attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'powers',
				'label' => 'COM_COMPONENTBUILDER_ADD_POWERS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_JCB_ADD_ANY_POWERS_THAT_ARE_CONNECTED_TO_THIS_COMPONENT_THIS_MAY_BE_HELPFUL_IF_YOU_ARE_LOADING_POWERS_VIA_ANOTHER_COMPONENT_AND_WOULD_LIKE_TO_AVOID_ADDING_IT_TO_BOTH_JUST_REMEMBER_THAT_IN_THIS_CASE_YOU_NEED_TO_LOAD_THE_POWERS_VIA_A_PLUGIN',
				'default' => '2'];
			$options = [
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// component attributes
			$attributes = [
				'type' => 'list',
				'name' => 'component_id',
				'label' => 'COM_COMPONENTBUILDER_COMPONENTS',
				'class' => 'list_class',
				'description' => 'COM_COMPONENTBUILDER_SELECT_THE_COMPONENT_TO_COMPILE',
				'required' => 'true'];
			// start the component options
			$options = [];
			$options[''] = 'COM_COMPONENTBUILDER__SELECT_COMPONENT_';
			// load component options from array
			foreach($this->Components as $component)
			{
				$options[(int) $component->id] = $this->escape($component->name);
			}

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// Joomla Versions attributes
			$attributes = [
				'type' => 'list',
				'name' => 'joomla_version',
				'label' => 'COM_COMPONENTBUILDER_JOOMLA_VERSION',
				'class' => 'list_class',
				'description' => 'COM_COMPONENTBUILDER_WHAT_VERSION_OF_JOOMLA_WOULD_YOU_LIKE_TO_TARGET',
				'default' => '3'];
			// start the joomla versions options
			$options = [
				'3' => 'COM_COMPONENTBUILDER_JOOMLA_THREE',
				'4' => 'COM_COMPONENTBUILDER_JOOMLA_FOUR',
				'5' => 'COM_COMPONENTBUILDER_JOOMLA_FIVE'
			];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// Joomla Version 3 attributes
			$attributes = [
				'type' => 'note',
				'name' => 'joomla_version_note_three',
				'description' => 'COM_COMPONENTBUILDER_YOUR_COMPONENT_WILL_BE_COMPILED_TO_WORK_IN_JOOMLA_THREE',
				'class' => 'alert alert-success',
				'showon' => 'joomla_version:3'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// Joomla Version 4 and five attributes
			$attributes = [
				'type' => 'note',
				'name' => 'joomla_version_note_four',
				'description' => 'COM_COMPONENTBUILDER_YOUR_COMPONENT_WILL_BE_COMPILED_TO_WORK_IN_JOOMLA_FOUR',
				'class' => 'alert alert-success',
				'showon' => 'joomla_version:4'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// Joomla Version 5 and five attributes
			$attributes = [
				'type' => 'note',
				'name' => 'joomla_version_note_five',
				'description' => 'COM_COMPONENTBUILDER_YOUR_COMPONENT_WILL_BE_COMPILED_TO_WORK_IN_JOOMLA_FIVE',
				'class' => 'alert alert-success',
				'showon' => 'joomla_version:5'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// Advanced Options
			$attributes = [
				'type' => 'radio',
				'name' => 'show_advanced_options',
				'label' => 'COM_COMPONENTBUILDER_SHOW_ADVANCED_OPTIONS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_WOULD_YOU_LIKE_TO_SEE_THE_ADVANCED_COMPILER_OPTIONS',
				'default' => '0'];
			// start the advanced options switch
			$options = [
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'builder');
			}

			// Advanced Options note attributes
			$attributes = [
				'type' => 'note',
				'name' => 'show_advanced_options_note',
				'label' => "COM_COMPONENTBUILDER_ADVANCED_OPTIONS",
				'heading' => 'h3',
				'showon' => 'show_advanced_options:1'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// powers repository attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'powers_repository',
				'label' => 'COM_COMPONENTBUILDER_ACTIVATE_SUPER_POWERS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_THIS_ADDS_POWERS_TO_A_LOCAL_REPOSITORY_FOLDER_ALL_BAPPROVEDB_POWERS_LINKED_TO_THIS_COMPONENT_WILL_BE_MOVED_TO_YOUR_BLOCALB_POWERS_REPOSITORY_FOLDER_INTO_THEIR_SELECTIVE_TARGET_PATHS_THIS_LOCAL_FOLDER_PATH_MUST_BE_SET_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_BSUPER_POWERB_TAB',
				'default' => '2',
				'showon' => 'show_advanced_options:1'];
			// start the repository options
			$options = [
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// powers local path to repositories attributes
			$attributes = [
				'type' => 'text',
				'name' => 'local_powers_repository_path',
				'label' => 'COM_COMPONENTBUILDER_LOCAL_POWERS_REPOSITORY_PATH',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_HERE_YOU_CAN_SET_THE_PATH_TO_THE_SUPER_POWERS_LOCAL_REPOSITORY_FOLDER_WHERE_BLAYERCOREB_AND_ALL_TARGETED_BLAYEROWNB_SUB_PATHS_WILL_BE_PLACED_WITH_THEIR_SELECTIVE_BSWITCHAPPROVEDB_POWERS',
				'default' => $this->params->get('local_powers_repository_path', ''),
				'showon' => 'show_advanced_options:1[AND]powers_repository:1'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// Indentation attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'indentation_value',
				'label' => 'COM_COMPONENTBUILDER_INDENTATION_OPTIONS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_WHICH_TYPE_OF_INDENTATION_WOULD_YOU_LIKE_TO_USE_PLEASE_NOTE_THAT_THIS_DOES_NOT_YET_IMPACT_THE_STATIC_TEMPLATES',
				'default' => '1',
				'showon' => 'show_advanced_options:1'];

			// start the indentation options
			$options = [
				'1' => 'COM_COMPONENTBUILDER_TAB',
				'2' => 'COM_COMPONENTBUILDER_TWO_SPACES',
				'4' => 'COM_COMPONENTBUILDER_FOUR_SPACES'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// Build date attributes
			$attributes = [
				'type' => 'radio',
				'name' => 'add_build_date',
				'label' => 'COM_COMPONENTBUILDER_BUILD_DATE',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_WOULD_YOU_LIKE_TO_OVERRIDE_THE_BUILD_DATE',
				'default' => '1',
				'showon' => 'show_advanced_options:1'];
			// start the build date options
			$options = [
				'1' => 'COM_COMPONENTBUILDER_DEFAULT',
				'2' => 'COM_COMPONENTBUILDER_MANUAL',
				'3' => 'COM_COMPONENTBUILDER_COMPONENT'];

			// add to form
			$xml = FormHelper::xml($attributes, $options);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// Build date note attributes
			$attributes = [
				'type' => 'note',
				'name' => 'add_build_date_note_two',
				'description' => 'COM_COMPONENTBUILDER_ALLOWS_YOU_TO_OVERRIDE_THE_BUILD_DATE_BY_SELECTING_A_DATE_MANUALLY_FROM_THE_CALENDER',
				'class' => 'alert alert-info',
				'showon' => 'show_advanced_options:1[AND]add_build_date:2'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// Build date note attributes
			$attributes = [
				'type' => 'note',
				'name' => 'add_build_date_note_three',
				'description' => "COM_COMPONENTBUILDER_THE_COMPONENTS_LAST_MODIFIED_DATE_WILL_BE_USED",
				'class' => 'alert alert-info',
				'showon' => 'show_advanced_options:1[AND]add_build_date:3'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// Build date calendar attributes
			$attributes = [
				'type' => 'calendar',
				'name' => 'build_date',
				'label' => 'COM_COMPONENTBUILDER_SELECT_BUILD_DATE',
				'format' => '%Y-%m-%d',
				'filter' => 'user_utc',
				'default' => 'now',
				'size' => '22',
				'showon' => 'show_advanced_options:1[AND]add_build_date:2'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// Build date note attributes
			$attributes = [
				'type' => 'note',
				'name' => 'donations_note',
				'label' => "COM_COMPONENTBUILDER_DONATIONS",
				'description' =>  $this->getSupportMessage(),
				'class' => 'alert alert-success',
				'heading' => 'h1',
				'showon' => 'show_advanced_options:1'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// Build date note line attributes
			$attributes = [
				'type' => 'note',
				'name' => 'donations_note_line',
				'description' => '<hr />',
				'showon' => 'show_advanced_options:1'];

			// add to form
			$xml = FormHelper::xml($attributes);
			if ($xml instanceof SimpleXMLElement)
			{
				$form->setField($xml, null, true, 'advanced');
			}

			// return the form array
			return $form;
		}

		return null;
	}

	/**
	 * Get the dynamic support request/gratitude message
	 *
	 * @return  string  The support message
	 *
	 * @since   3.2.0
	 */
	protected function getSupportMessage(): string
	{
		return LayoutHelper::render('jcbsupportmessage', []);
	}

	/**
	 * Prepares the document
	 */
	protected function setDocument()
	{

		// Only load jQuery if needed. (default is true)
		if ($this->params->get('add_jquery_framework', 1) == 1)
		{
			Html::_('jquery.framework');
		}
		// Load the header checker class.
		require_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/headercheck.php' );
		// Initialize the header checker.
		$HeaderCheck = new componentbuilderHeaderCheck();

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
			$uikitComp[] = 'data-uk-grid';

			// Get field uikit components needed in this view.
			$uikitFieldComp = $this->get('UikitComp');
			if (isset($uikitFieldComp) && ArrayHelper::check($uikitFieldComp))
			{
				if (isset($uikitComp) && ArrayHelper::check($uikitComp))
				{
					$uikitComp = array_merge($uikitComp, $uikitFieldComp);
					$uikitComp = array_unique($uikitComp);
				}
				else
				{
					$uikitComp = $uikitFieldComp;
				}
			}
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
					if (@file_exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css', ['version' => 'auto']);
					}
					// check if the JavaScript file exists.
					if (@file_exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);
					}
				}
			}
		}
		// add marked library
		Html::_('script', 'administrator/components/com_componentbuilder/custom/marked.js', ['version' => 'auto']);
		// add the document default css file
		Html::_('stylesheet', 'administrator/components/com_componentbuilder/assets/css/compiler.css', ['version' => 'auto']);
		// Set the Custom JS script to view
		$this->getDocument()->addScriptDeclaration("
			function getComponentDetails_server(id) {
				let getUrl = JRouter(\"index.php?option=com_componentbuilder&task=ajax.getComponentDetails&format=json&raw=true\");
				let request = new URLSearchParams();
				if (token.length > 0 && id > 0) {
					request.append(token, '1');
					request.append('id', id);
				}
				return fetch(getUrl + '&'  + request.toString(), {
					method: 'GET',
					headers: {
						'Accept': 'application/json'
					}
				}).then(response => response.json());
			}
			function getComponentDetails(id) {
				getComponentDetails_server(id).then(function(result) {
					if (result.html) {
						document.getElementById('component-details').innerHTML = result.html;
						if (result.preferred_joomla_version) {
							jQuery('#joomla_version').val(result.preferred_joomla_version);
							jQuery('#joomla_version').trigger('liszt:updated');
							jQuery('#joomla_version').trigger('change');
						}
					}
				});
			}
			
			document.addEventListener('DOMContentLoaded', function() {
				fetchNoticeboard(\"https://vdm.bz/componentbuilder-noticeboard-md\", \".noticeboard-md\", true);
				fetchNoticeboard(\"https://vdm.bz/componentbuilder-pro-noticeboard-md\", \".proboard-md\", false);
			});
			function fetchNoticeboard(url, selector, processGetIS) {
				fetch(url)
				.then(response => {
					if (!response.ok) {
						throw new Error('Network response was not ok');
					}
					return response.text();
				})
				.then(board => {
					var elements = document.querySelectorAll(selector);
					if (board.length > 5) {
						let html_board = marked.parse(board);
						elements.forEach(element => {
							element.innerHTML = html_board;
						});
						if (processGetIS) {
							getIS(1, board).then(result => {
								if (result) {
									document.querySelectorAll(\".vdm-new-notice\").forEach(element => {
										element.style.display = 'block';
									});
									getIS(2, board);
								}
							});
						}
					} else {
						elements.forEach(element => {
							element.innerHTML = all_is_good;
						});
					}
				})
				.catch(error => {
					console.error('There was an error!', error);
					document.querySelectorAll(selector).forEach(element => {
						element.innerHTML = all_is_good;
					});
				});
			}
			// to check is READ/NEW
			function getIS(type, notice) {
				let getUrl = \"\";
				if (type === 1) {
					getUrl = JRouter(\"index.php?option=com_componentbuilder&task=ajax.isNew&format=json&raw=true\");
				} else if (type === 2) {
					getUrl = JRouter(\"index.php?option=com_componentbuilder&task=ajax.isRead&format=json&raw=true\");
				}
				let request = new URLSearchParams();
				if (token.length > 0 && notice.length) {
					request.append(token, \"1\");
					request.append(\"notice\", notice);
				}
				return fetch(getUrl, {
					method: \"POST\",
					headers: {
						\"Content-Type\": \"application/x-www-form-urlencoded;charset=UTF-8\"
					},
					body: request
				}).then(response => response.json());
			}
		");
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// hide the main menu
		$this->app->input->set('hidemainmenu', true);
		// add title to the page
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_COMPILER'),'cogs');
		// add cpanel button
		ToolbarHelper::custom('compiler.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('compiler.translate'))
		{
			// add Translate button.
			ToolbarHelper::custom('compiler.runTranslator', 'comments-2 custom-button-runtranslator', '', 'COM_COMPONENTBUILDER_TRANSLATE', false);
		}
		if ($this->canDo->get('compiler.compiler_animations'))
		{
			// add Compiler Animations button.
			ToolbarHelper::custom('compiler.getDynamicContent', 'download custom-button-getdynamiccontent', '', 'COM_COMPONENTBUILDER_COMPILER_ANIMATIONS', false);
		}
		if ($this->canDo->get('compiler.clear_tmp'))
		{
			// add Clear tmp button.
			ToolbarHelper::custom('compiler.clearTmp', 'purge custom-button-cleartmp', '', 'COM_COMPONENTBUILDER_CLEAR_TMP', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('compiler');
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
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		// use the helper htmlEscape method instead.
		return StringHelper::html($var, $this->_charset);
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
