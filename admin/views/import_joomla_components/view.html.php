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
 * Componentbuilder Import_joomla_components View
 */
class ComponentbuilderViewImport_joomla_components extends JViewLegacy
{
	protected $headerList;
	protected $hasPackage = false;
	protected $headers;
	protected $hasHeader = 0;
	protected $dataType;
	protected $packageInfo;
	protected $formPackage;
	protected $vdmPackages = false;
	protected $directories = array();

	public function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('import');
		}
		// get component params
		$this->params = JComponentHelper::getParams('com_componentbuilder');

		$paths = new stdClass;
		$paths->first = '';
		$state = $this->get('state');

		$this->paths = &$paths;
		$this->state = &$state;
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('import');
		// load the application
		$this->app = JFactory::getApplication();

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			// add title to the page
			JToolbarHelper::title(JText::_('COM_COMPONENTBUILDER_JCB_PACKAGE_IMPORT'),'upload');
			// add refesh button.
			JToolBarHelper::custom('joomla_component.refresh', 'refresh', '', 'COM_COMPONENTBUILDER_REFRESH', false);
		}
		// get the session object
		$session = JFactory::getSession();
		// check if it has package
		$this->hasPackage = $session->get('hasPackage', false);
		$this->dataType = $session->get('dataType', false);
		if (!$this->dataType)
		{
			$this->dataType = $session->get('dataType_VDM_IMPORTINTO',  null);
		}

 		// get the management input from global settings
 		$manageDirectories = $this->params->get('manage_jcb_package_directories', 2);
 		if ($manageDirectories == 2)
 		{
 		 	$this->directories = array('vdm','jcb');
 		}
 		elseif ($manageDirectories == 1)
 		{
 			$this->directories = (array) $this->params->get('jcb_package_directories');
 		}

		// set form only if smart package
		if ($this->dataType === 'smart_package')
		{
			$this->packageInfo = json_decode($session->get('smart_package_info', false), true);

			// add the form class
			jimport('joomla.form.form');

			// load the forms
			$this->formPackage = $this->_getForm($this->dataType);
			$this->vdmPackages = $this->_getForm('vdm_package');
			$this->jcbPackages = $this->_getForm('jcb_package');
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// set the document
		$this->setDocument();

		// Display the template
		parent::display($tpl);
	}

	/**
	 * Prepares the document
	 */
	protected function setDocument()
	{
		// always make sure jquery is loaded.
		JHtml::_('jquery.framework');

		// Add the JavaScript for JStore
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jquery.json.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jstorage.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/strtotime.js');
		// add marked library
		$this->document->addScript(JURI::root() . "administrator/components/com_componentbuilder/custom/marked.js");
		// check if we should use browser storage
		$setBrowserStorage = $this->params->get('set_browser_storage', null);
		if ($setBrowserStorage)
		{
			// check what (Time To Live) show we use
			$storageTimeToLive = $this->params->get('storage_time_to_live', 'global');
			if ('global' == $storageTimeToLive)
			{
				// use the global session time
				$session = JFactory::getSession();
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
		$this->document->addScriptDeclaration("var all_is_good = '".JText::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_THERE_IS_NO_NOTICE_AT_THIS_TIME')."';"); 
		// add a token on the page for javascript
		$this->document->addScriptDeclaration("var token = '".JSession::getFormToken()."';"); 

		// add the Uikit v2 style sheets
		$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/uikit.gradient.min.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
		$this->document->addStyleSheet( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/notify.gradient.min.css' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');

		// add Uikit v2 JavaScripts
		$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/uikit.min.js' , (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/lightbox.min.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);
		$this->document->addScript( JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/notify.min.js', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (ComponentbuilderHelper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);
	}

	public function _getForm($type)
	{
		$form = array();
		if ('smart_package' === $type)
		{
			// get the force_update radio field
			$force_update = JFormHelper::loadFieldType('radio',true);
			// start force_update xml
			$force_updateXML = new SimpleXMLElement('<field/>');
			// force_update attributes
			$force_updateAttributes = array(
				'type' => 'radio',
				'name' => 'force_update',
				'label' => 'COM_COMPONENTBUILDER_FORCE_LOCAL_UPDATE',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_WE_FORCE_THE_UPDATE_OF_ALL_LOCAL_DATA_EVEN_IF_IT_IS_NEWER_THEN_THE_DATA_BEING_IMPORTED',
				'default' => '0');
			// load the force_update attributes
			ComponentbuilderHelper::xmlAddAttributes($force_updateXML, $force_updateAttributes);
			// set the force_update options
			$force_updateOptions = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// load the force_update options
			ComponentbuilderHelper::xmlAddOptions($force_updateXML, $force_updateOptions);
			// setup the force_update radio field
			$force_update->setup($force_updateXML,0);
			// add to form
			$form[] = $force_update;

			// get the more_info radio field
			$more_info = JFormHelper::loadFieldType('radio',true);
			// start more_info xml
			$more_infoXML = new SimpleXMLElement('<field/>');
			// more_info attributes
			$more_infoAttributes = array(
				'type' => 'radio',
				'name' => 'more_info',
				'label' => 'COM_COMPONENTBUILDER_SEE_ALL_IMPORT_INFO',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_WE_BE_SHOWING_MORE_ELABORATE_INFORMATION_DURING_IMPORT',
				'default' => '0');
			// load the more_info attributes
			ComponentbuilderHelper::xmlAddAttributes($more_infoXML, $more_infoAttributes);
			// set the more_info options
			$more_infoOptions = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// load the more_info options
			ComponentbuilderHelper::xmlAddOptions($more_infoXML, $more_infoOptions);
			// setup the more_info radio field
			$more_info->setup($more_infoXML,0);
			// add to form
			$form[] = $more_info;

			// get the merge radio field
			$merge = JFormHelper::loadFieldType('radio',true);
			// start merge xml
			$mergeXML = new SimpleXMLElement('<field/>');
			// merge attributes
			$mergeAttributes = array(
				'type' => 'radio',
				'name' => 'canmerge',
				'label' => 'COM_COMPONENTBUILDER_MERGE',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_WE_MERGE_THE_COMPONENTS_WITH_SIMILAR_LOCAL_COMPONENTS_MERGING_THE_COMPONENTS_USE_TO_BE_THE_DEFAULT_BEHAVIOUR_BUT_NOW_YOU_CAN_IMPORT_THE_COMPONENTS_AND_FORCE_IT_NOT_TO_MERGE_THE_FOLLOWING_AREAS_VALIDATION_RULE_FIELDTYPE_SNIPPET_LANGUAGE_LANGUAGE_TRANSLATION_JOOMLA_PLUGIN_GROUP_CLASS_EXTENDS_CLASS_PROPERTY_CLASS_METHOD_BMUST_AND_WILL_STILLB_MERGE_EVEN_OF_YOUR_SELECTION_IS_BNOB_BECAUSE_OF_THE_SINGULAR_NATURE_OF_THOSE_AREAS',
				'default' => '1');
			// load the merge attributes
			ComponentbuilderHelper::xmlAddAttributes($mergeXML, $mergeAttributes);
			// set the merge options
			$mergeOptions = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// load the merge options
			ComponentbuilderHelper::xmlAddOptions($mergeXML, $mergeOptions);
			// setup the merge radio field
			$merge->setup($mergeXML,1);
			// add to form
			$form[] = $merge;
		
			if (!$this->packageInfo || ComponentbuilderHelper::getPackageComponentsKeyStatus($this->packageInfo))
			{
				// set required field
				$required = true;
				// does the packages has info
				if (!$this->packageInfo)
				{
					// get the haskey radio field
					$haskey = JFormHelper::loadFieldType('radio',true);
					// start haskey xml
					$haskeyXML = new SimpleXMLElement('<field/>');
					// haskey attributes
					$haskeyAttributes = array(
						'type' => 'radio',
						'name' => 'haskey',
						'label' => 'COM_COMPONENTBUILDER_USE_KEY',
						'class' => 'btn-group btn-group-yesno',
						'description' => 'COM_COMPONENTBUILDER_DOES_THIS_PACKAGE_REQUIRE_A_KEY_TO_INSTALL',
						'default' => '1',
						'filter' => 'INT');
					// load the haskey attributes
					ComponentbuilderHelper::xmlAddAttributes($haskeyXML, $haskeyAttributes);
					// set the haskey options
					$haskeyOptions = array(
						'1' => 'COM_COMPONENTBUILDER_YES',
						'0' => 'COM_COMPONENTBUILDER_NO');
					// load the haskey options
					ComponentbuilderHelper::xmlAddOptions($haskeyXML, $haskeyOptions);
					// setup the haskey radio field
					$haskey->setup($haskeyXML,1);
					// add to form
					$form[] = $haskey;

					// now make required false
					$required = false;
				}

				// get the sleutle password field
				$sleutle = JFormHelper::loadFieldType('password',true);
				// start sleutle xml
				$sleutleXML = new SimpleXMLElement('<field/>');
				// sleutle attributes
				$sleutleAttributes = array(
					'type' => 'password',
					'name' => 'sleutle',
					'label' => 'COM_COMPONENTBUILDER_KEY',
					'class' => 'text_area',
					'description' => 'COM_COMPONENTBUILDER_THE_KEY_OF_THIS_PACKAGE',
					'autocomplete' => 'false',
					'filter' => 'STRING',
					'hint' => 'COM_COMPONENTBUILDER_ADD_KEY_HERE');
				// should this be required
				if ($required)
				{
					$sleutleAttributes['required'] = 'true';
				}
				// load the sleutle attributes
				ComponentbuilderHelper::xmlAddAttributes($sleutleXML, $sleutleAttributes);
				// setup the sleutle password field
				$sleutle->setup($sleutleXML,'');
				// add to form
				$form[] = $sleutle;
			}
		}
		elseif ('vdm_package' === $type && in_array('vdm', $this->directories) && $vdmListObjects = ComponentbuilderHelper::getGithubRepoFileList('vdmGithubPackages', ComponentbuilderHelper::$vdmGithubPackagesUrl))
		{
			if (ComponentbuilderHelper::checkArray($vdmListObjects))
			{
				// get the vdm_package list field
				$vdm_package = JFormHelper::loadFieldType('list',true);
				// start vdm_package xml
				$vdm_packageXML = new SimpleXMLElement('<field/>');
				// vdm_package attributes
				$vdm_packageAttributes = array(
					'type' => 'list',
					'name' => 'vdm_package',
					'label' => 'COM_COMPONENTBUILDER_PACKAGE',
					'class' => 'list_class',
					'description' => 'COM_COMPONENTBUILDER_SELECT_THE_PACKAGE_TO_IMPORT',
					'onchange' => "getJCBpackageInfo('vdm')");
				// load the list
				$load = false;
				// load the vdm_package attributes
				ComponentbuilderHelper::xmlAddAttributes($vdm_packageXML, $vdm_packageAttributes);
				// start the vdm_package options
				$vdm_packageOptions = array();
				$vdm_packageOptions[''] = 'COM_COMPONENTBUILDER__SELECT_PACKAGE_';
				// load vdm_package options from array
				foreach($vdmListObjects as $vdmListObject)
				{
					if (strpos($vdmListObject->path, '.zip') !== false)
					{
						$vdm_packageOptions[ComponentbuilderHelper::$vdmGithubPackageUrl.$vdmListObject->path] = $this->setPackageName($vdmListObject->path);
						$load = true;
					}
				}
				// only load if at least one item was found
				if ($load)
				{
					// load the vdm_package options
					ComponentbuilderHelper::xmlAddOptions($vdm_packageXML, $vdm_packageOptions);
					// setup the vdm_package radio field
					$vdm_package->setup($vdm_packageXML,'');
					// add to form
					$form[] = $vdm_package;
				}
			}
		}
		elseif ('jcb_package' === $type && in_array('jcb', $this->directories)  && $jcbListObjects = ComponentbuilderHelper::getGithubRepoFileList('communityGithubPackages', ComponentbuilderHelper::$jcbGithubPackagesUrl))
		{
			if (ComponentbuilderHelper::checkArray($jcbListObjects))
			{
				// get the jcb_package list field
				$jcb_package = JFormHelper::loadFieldType('list',true);
				// start jcb_package xml
				$jcb_packageXML = new SimpleXMLElement('<field/>');
				// jcb_package attributes
				$jcb_packageAttributes = array(
					'type' => 'list',
					'name' => 'jcb_package',
					'label' => 'COM_COMPONENTBUILDER_PACKAGE',
					'class' => 'list_class',
					'description' => 'COM_COMPONENTBUILDER_SELECT_THE_PACKAGE_TO_IMPORT',
					'onchange' => "getJCBpackageInfo('jcb')");
				// load the list
				$load = false;
				// load the jcb_package attributes
				ComponentbuilderHelper::xmlAddAttributes($jcb_packageXML, $jcb_packageAttributes);
				// start the jcb_package options
				$jcb_packageOptions = array();
				$jcb_packageOptions[''] = 'COM_COMPONENTBUILDER__SELECT_PACKAGE_';
				// load jcb_package options from array
				foreach($jcbListObjects as $jcbListObject)
				{
					if (strpos($jcbListObject->path, '.zip') !== false)
					{
						$jcb_packageOptions[ComponentbuilderHelper::$jcbGithubPackageUrl.$jcbListObject->path] = $this->setPackageName($jcbListObject->path);
						$load = true;
					}
				}
				// only load if at least one item was found
				if ($load)
				{
					// load the jcb_package options
					ComponentbuilderHelper::xmlAddOptions($jcb_packageXML, $jcb_packageOptions);
					// setup the jcb_package radio field
					$jcb_package->setup($jcb_packageXML,'');
					// add to form
					$form[] = $jcb_package;
				}
			}
		}
		return $form;
	}

	public function setPackageName($name)
	{
		// return the name
		return ComponentbuilderHelper::safeString( preg_replace('/(?<!^)([A-Z])/', '-\ \1', str_replace(array('.zip', 'JCB_'), '', $name)), 'W');
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_COMPONENTBUILDER_IMPORT_TITLE'), 'upload');
		JHtmlSidebar::setAction('index.php?option=com_componentbuilder&view=import_joomla_components');

		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_componentbuilder');
		}

		// set help url for this view if found
		$help_url = ComponentbuilderHelper::getHelpUrl('import_joomla_components');
		if (ComponentbuilderHelper::checkString($help_url))
		{
			   JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
		}
	}
}
