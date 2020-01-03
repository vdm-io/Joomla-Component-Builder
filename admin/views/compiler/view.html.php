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
 * Componentbuilder View class for the Compiler
 */
class ComponentbuilderViewCompiler extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
		// get component params
		$this->params = JComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app = JFactory::getApplication();
		// get the user object
		$this->user	= JFactory::getUser();
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
		$this->Components 	= $this->get('Components');
		$this->form		= $this->setForm();

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

	public function setForm()
	{		
		if(ComponentbuilderHelper::checkArray($this->Components))
		{
			// start the form
			$form = array();
			// sales attributes
			$attributes = array(
				'type' => 'radio',
				'name' => 'backup',
				'label' => 'COM_COMPONENTBUILDER_ADD_TO_BACKUP_FOLDER_AMP_SALES_SERVER_SMALLIF_SETSMALL',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_THE_ZIPPED_PACKAGE_OF_THE_COMPONENT_BE_MOVED_TO_THE_LOCAL_BACKUP_AND_REMOTE_SALES_SERVER_THIS_IS_ONLY_APPLICABLE_IF_THIS_COMPONENT_HAS_THOSE_VALUES_SET',
				'default' => '0');
			// set the sales options
			$options = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// add to form
			$form[] = ComponentbuilderHelper::getFieldObject($attributes, 0, $options);
			// repository attributes
			$attributes = array(
				'type' => 'radio',
				'name' => 'repository',
				'label' => 'COM_COMPONENTBUILDER_ADD_TO_REPOSITORY_FOLDER',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_THE_COMPONENT_BE_MOVED_TO_YOUR_LOCAL_REPOSITORY_FOLDER',
				'default' => '1');
			// start the repository options
			$options = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// add to form
			$form[] = ComponentbuilderHelper::getFieldObject($attributes, 1, $options);
			// placeholders attributes
			$attributes = array(
				'type' => 'radio',
				'name' => 'placeholders',
				'label' => 'COM_COMPONENTBUILDER_ADD_CUSTOM_CODE_PLACEHOLDERS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_JCB_INSERT_THE_CUSTOM_CODE_PLACEHOLDERS_THIS_IS_ONLY_APPLICABLE_IF_THIS_COMPONENT_HAS_CUSTOM_CODE',
				'default' => '2');
			// start the placeholders options
			$options = array(
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// add to form
			$form[] = ComponentbuilderHelper::getFieldObject($attributes, 2, $options);
			// debuglinenr attributes
			$attributes = array(
				'type' => 'radio',
				'name' => 'debuglinenr',
				'label' => 'COM_COMPONENTBUILDER_DEBUG_LINE_NUMBERS',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_ADD_CORRESPONDING_LINE_NUMBERS_TO_THE_DYNAMIC_COMMENTS_SO_TO_SEE_WHERE_IN_THE_COMPILER_THE_LINES_OF_CODE_WAS_BUILD_THIS_WILL_HELP_IF_YOU_NEED_TO_GET_MORE_TECHNICAL_WITH_AN_ISSUE_ON_GITHUB_OR_EVEN_FOR_YOUR_OWN_DEBUGGING',
				'default' => '2');
			$options = array(
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// add to form
			$form[] = ComponentbuilderHelper::getFieldObject($attributes, 2, $options);
			// minify attributes
			$attributes = array(
				'type' => 'radio',
				'name' => 'minify',
				'label' => 'COM_COMPONENTBUILDER_MINIFY_JAVASCRIPT',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_THE_JAVASCRIPT_BE_MINIFIED_IN_THE_COMPONENT',
				'default' => '2');
			$options = array(
				'2' => 'COM_COMPONENTBUILDER_GLOBAL',
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// add to form
			$form[] = ComponentbuilderHelper::getFieldObject($attributes, 2, $options);
			// component attributes
			$attributes = array(
				'type' => 'list',
				'name' => 'component',
				'label' => 'COM_COMPONENTBUILDER_COMPONENTS',
				'class' => 'list_class',
				'description' => 'COM_COMPONENTBUILDER_SELECT_THE_COMPONENT_TO_COMPILE',
				'required' => 'true');
			// start the component options
			$options = array();
			$options[''] = 'COM_COMPONENTBUILDER__SELECT_COMPONENT_';
			// load component options from array
			foreach($this->Components as $componet)
			{
				$options[(int) $componet->id] = $this->escape($componet->name);
			}
			// add to form
			$form[] = ComponentbuilderHelper::getFieldObject($attributes, '', $options);

			// return the form array
			return $form;
		}
		return false;
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

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/uikit'.$style.$size.'.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/uikit'.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		}

		// Load the needed uikit components in this view.
		$uikitComp = $this->get('UikitComp');
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
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
					}
					// check if the JavaScript file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);
					}
				}
			}
		}
		// add marked library
		$this->document->addScript(JURI::root() . "administrator/components/com_componentbuilder/custom/marked.js");
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_componentbuilder/assets/css/compiler.css', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		// Set the Custom CSS script to view
		$this->document->addStyleDeclaration("
			.j-sidebar-container {
			margin: -37px 0 0 -1px !important;
			}
		");
		// Set the Custom JS script to view
		$this->document->addScriptDeclaration("
			function getComponentDetails_server(id){
				var getUrl = JRouter(\"index.php?option=com_componentbuilder&task=ajax.getComponentDetails&format=json&raw=true\");
				if(token.length > 0 && id > 0){
					var request = token+'=1&id='+id;
				}
				return jQuery.ajax({
					type: 'GET',
					url: getUrl,
					dataType: 'json',
					data: request,
					jsonp: false
				});
			}
			function getComponentDetails(id) {
				getComponentDetails_server(id).done(function(result) {
					if(result.html) {
						jQuery('#component-details').html(result.html);
					}
				});
			}
			
			var noticeboard = \"https://vdm.bz/componentbuilder-noticeboard-md\";
			var proboard = \"https://vdm.bz/componentbuilder-pro-noticeboard-md\";
			jQuery(document).ready(function () {
				jQuery.get(noticeboard)
				.success(function(board) { 
					if (board.length > 5) {
						jQuery(\"#noticeboard-md\").html(marked(board));
						getIS(1,board).done(function(result) {
							if (result){
								jQuery(\"#vdm-new-notice\").show();
								getIS(2,board);
							}
						});
					} else {
						jQuery(\"#noticeboard-md\").html(all_is_good);
					}
				})
				.error(function(jqXHR, textStatus, errorThrown) { 
					jQuery(\"#noticeboard-md\").html(all_is_good);
				});
				jQuery.get(proboard)
				.success(function(board) { 
					if (board.length > 5) {
						jQuery(\"#proboard-md\").html(marked(board));
					} else {
						jQuery(\"#proboard-md\").html(all_is_good);
					}
				})
				.error(function(jqXHR, textStatus, errorThrown) { 
					jQuery(\"#proboard-md\").html(all_is_good);
				});
			});
			// to check is READ/NEW
			function getIS(type,notice){
				if (type == 1) {
					var getUrl = JRouter(\"index.php?option=com_componentbuilder&task=ajax.isNew&format=json&raw=true\");
				} else if (type == 2) {
					var getUrl = JRouter(\"index.php?option=com_componentbuilder&task=ajax.isRead&format=json&raw=true\");
				}	
				if(token.length > 0 && notice.length){
					var request = token+\"=1&notice=\"+notice;
				}
				return jQuery.ajax({
					type: \"POST\",
					url: getUrl,
					dataType: 'json',
					data: request,
					jsonp: false
				});
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
		JToolbarHelper::title(JText::_('COM_COMPONENTBUILDER_COMPILER'),'cogs');
		// add the back button
		// JToolBarHelper::custom('compiler.back', 'undo-2', '', 'COM_COMPONENTBUILDER_BACK', false);
		// add cpanel button
		JToolBarHelper::custom('compiler.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('compiler.run_expansion'))
		{
			// add Run Expansion button.
			JToolBarHelper::custom('compiler.runExpansion', 'expand-2', '', 'COM_COMPONENTBUILDER_RUN_EXPANSION', false);
		}
		if ($this->canDo->get('compiler.translate'))
		{
			// add Translate button.
			JToolBarHelper::custom('compiler.runTranslator', 'comments-2', '', 'COM_COMPONENTBUILDER_TRANSLATE', false);
		}
		if ($this->canDo->get('compiler.clear_tmp'))
		{
			// add Clear tmp button.
			JToolBarHelper::custom('compiler.clearTmp', 'purge', '', 'COM_COMPONENTBUILDER_CLEAR_TMP', false);
		}

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('compiler');
		if (ComponentbuilderHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
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
