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
namespace VDM\Component\Componentbuilder\Administrator\View\Import_joomla_componentsImport;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\FormHelper as UtilitiesFormHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Import_joomla_components Html View
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
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
		$this->params = ComponentHelper::getParams('com_componentbuilder');

		$paths = new \stdClass;
		$paths->first = '';
		$state = $this->get('state');

		$this->paths = &$paths;
		$this->state = &$state;
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('import');
		// load the application
		$this->app = Factory::getApplication();

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			// add title to the page
			ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_JCB_PACKAGE_IMPORT'), 'upload');
			// add refesh button.
			ToolbarHelper::custom('joomla_component.refresh', 'refresh', '', 'COM_COMPONENTBUILDER_REFRESH', false);
		}
		// get the session object
		$session = Factory::getSession();
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
 		 	$this->directories = array('vdm', 'jcb');
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
		Html::_('jquery.framework');

		// Add the JavaScript for JStore
		Html::_('script', 'media/com_componentbuilder/js/jquery.json.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/js/jstorage.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/js/strtotime.js', ['version' => 'auto']);
		// add marked library
		Html::_('script', "media/com_componentbuilder/js/marked.js", ['version' => 'auto']);
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
		$this->document->addScriptDeclaration("var all_is_good = '".Text::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_THERE_IS_NO_NOTICE_AT_THIS_TIME')."';"); 
		// add a token on the page for javascript
		$this->document->addScriptDeclaration("var token = '".\JSession::getFormToken()."';"); 


		// add the Uikit v2 style sheets
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit.gradient.min.css', ['version' => 'auto']);
		// add Uikit v2 JavaScripts
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit.min.js', ['version' => 'auto']);

		// add the Uikit v2 extra style sheets
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/notify.gradient.min.css', ['version' => 'auto']);
		// add Uikit v2 extra JavaScripts
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/lightbox.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/notify.min.js', ['version' => 'auto']);
	}

	public function _getForm($type)
	{
		$form = array();
		if ('smart_package' === $type)
		{
			// get the force_update radio field
			$force_update = FormHelper::loadFieldType('radio',true);
			// start force_update xl
			$force_updateXML = new \SimpleXMLElement('<field/>');
			// force_update attributes
			$force_updateAttributes = array(
				'type' => 'radio',
				'name' => 'force_update',
				'label' => 'COM_COMPONENTBUILDER_FORCE_LOCAL_UPDATE',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_WE_FORCE_THE_UPDATE_OF_ALL_LOCAL_DATA_EVEN_IF_IT_IS_NEWER_THEN_THE_DATA_BEING_IMPORTED',
				'default' => '0');
			// load the force_update attributes
			UtilitiesFormHelper::attributes($force_updateXML, $force_updateAttributes);
			// set the force_update options
			$force_updateOptions = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// load the force_update options
			UtilitiesFormHelper::options($force_updateXML, $force_updateOptions);
			// setup the force_update radio field
			$force_update->setup($force_updateXML,0);
			// add to form
			$form[] = $force_update;

			// get the more_info radio field
			$more_info = FormHelper::loadFieldType('radio',true);
			// start more_info xml
			$more_infoXML = new \SimpleXMLElement('<field/>');
			// more_info attributes
			$more_infoAttributes = array(
				'type' => 'radio',
				'name' => 'more_info',
				'label' => 'COM_COMPONENTBUILDER_SEE_ALL_IMPORT_INFO',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_WE_BE_SHOWING_MORE_ELABORATE_INFORMATION_DURING_IMPORT',
				'default' => '0');
			// load the more_info attributes
			UtilitiesFormHelper::attributes($more_infoXML, $more_infoAttributes);
			// set the more_info options
			$more_infoOptions = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// load the more_info options
			UtilitiesFormHelper::options($more_infoXML, $more_infoOptions);
			// setup the more_info radio field
			$more_info->setup($more_infoXML,0);
			// add to form
			$form[] = $more_info;

			// get the merge radio field
			$merge = FormHelper::loadFieldType('radio',true);
			// start merge xml
			$mergeXML = new \SimpleXMLElement('<field/>');
			// merge attributes
			$mergeAttributes = array(
				'type' => 'radio',
				'name' => 'canmerge',
				'label' => 'COM_COMPONENTBUILDER_MERGE',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_SHOULD_WE_MERGE_THE_COMPONENTS_WITH_SIMILAR_LOCAL_COMPONENTS_MERGING_THE_COMPONENTS_USE_TO_BE_THE_DEFAULT_BEHAVIOUR_BUT_NOW_YOU_CAN_IMPORT_THE_COMPONENTS_AND_FORCE_IT_NOT_TO_MERGE_THE_FOLLOWING_AREAS_VALIDATION_RULE_FIELDTYPE_SNIPPET_LANGUAGE_LANGUAGE_TRANSLATION_JOOMLA_PLUGIN_GROUP_CLASS_EXTENDS_CLASS_PROPERTY_CLASS_METHOD_BMUST_AND_WILL_STILLB_MERGE_EVEN_OF_YOUR_SELECTION_IS_BNOB_BECAUSE_OF_THE_SINGULAR_NATURE_OF_THOSE_AREAS',
				'default' => '1');
			// load the merge attributes
			UtilitiesFormHelper::attributes($mergeXML, $mergeAttributes);
			// set the merge options
			$mergeOptions = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// load the merge options
			UtilitiesFormHelper::options($mergeXML, $mergeOptions);
			// setup the merge radio field
			$merge->setup($mergeXML,1);
			// add to form
			$form[] = $merge;

			// get the import_guid_only radio field
			$import_guid_only = FormHelper::loadFieldType('radio',true);
			// start import_guid_only xml
			$import_guid_onlyXML = new \SimpleXMLElement('<field/>');
			// import_guid_only attributes
			$import_guid_onlyAttributes = array(
				'type' => 'radio',
				'name' => 'import_guid_only',
				'label' => 'COM_COMPONENTBUILDER_IMPORT_BY_GUID_ONLY',
				'class' => 'btn-group btn-group-yesno',
				'description' => 'COM_COMPONENTBUILDER_FORCE_THAT_THIS_JCB_PACKAGE_IMPORT_SEARCH_FOR_LOCAL_ITEMS_TO_BE_DONE_WITH_GUID_VALUE_ONLY_IF_BMERGEB_IS_SET_TO_YES_ABOVE',
				'default' => '1');
			// load the import_guid_only attributes
			UtilitiesFormHelper::attributes($import_guid_onlyXML, $import_guid_onlyAttributes);
			// set the import_guid_only options
			$import_guid_onlyOptions = array(
				'1' => 'COM_COMPONENTBUILDER_YES',
				'0' => 'COM_COMPONENTBUILDER_NO');
			// load the import_guid_only options
			UtilitiesFormHelper::options($import_guid_onlyXML, $import_guid_onlyOptions);
			// setup the import_guid_only radio field
			$import_guid_only->setup($import_guid_onlyXML, $this->params->get('import_guid_only', 0));
			// add to form
			$form[] = $import_guid_only;
		
			if (!$this->packageInfo || ComponentbuilderHelper::getPackageComponentsKeyStatus($this->packageInfo))
			{
				// set required field
				$required = true;
				// does the packages has info
				if (!$this->packageInfo)
				{
					// get the haskey radio field
					$haskey = FormHelper::loadFieldType('radio',true);
					// start haskey xml
					$haskeyXML = new \SimpleXMLElement('<field/>');
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
					UtilitiesFormHelper::attributes($haskeyXML, $haskeyAttributes);
					// set the haskey options
					$haskeyOptions = array(
						'1' => 'COM_COMPONENTBUILDER_YES',
						'0' => 'COM_COMPONENTBUILDER_NO');
					// load the haskey options
					UtilitiesFormHelper::options($haskeyXML, $haskeyOptions);
					// setup the haskey radio field
					$haskey->setup($haskeyXML,1);
					// add to form
					$form[] = $haskey;

					// now make required false
					$required = false;
				}

				// get the sleutle password field
				$sleutle = FormHelper::loadFieldType('password',true);
				// start sleutle xml
				$sleutleXML = new \SimpleXMLElement('<field/>');
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
				UtilitiesFormHelper::attributes($sleutleXML, $sleutleAttributes);
				// setup the sleutle password field
				$sleutle->setup($sleutleXML,'');
				// add to form
				$form[] = $sleutle;
			}
		}
		elseif ('vdm_package' === $type && in_array('vdm', $this->directories) && $vdmListObjects = ComponentbuilderHelper::getGithubRepoFileList('vdmGithubPackages', ComponentbuilderHelper::$vdmGithubPackagesUrl))
		{
			if (ArrayHelper::check($vdmListObjects))
			{
				// get the vdm_package list field
				$vdm_package = FormHelper::loadFieldType('list',true);
				// start vdm_package xml
				$vdm_packageXML = new \SimpleXMLElement('<field/>');
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
				UtilitiesFormHelper::attributes($vdm_packageXML, $vdm_packageAttributes);
				// start the vdm_package options
				$vdm_packageOptions = array();
				$vdm_packageOptions[''] = 'COM_COMPONENTBUILDER__SELECT_PACKAGE_';
				// load vdm_package options from array
				foreach($vdmListObjects as $vdmListObject)
				{
					if (strpos($vdmListObject->path, '.zip') !== false)
					{
						$vdm_packageOptions[base64_encode(ComponentbuilderHelper::$vdmGithubPackageUrl.$vdmListObject->path)] = $this->setPackageName($vdmListObject->path);
						$load = true;
					}
				}
				// only load if at least one item was found
				if ($load)
				{
					// load the vdm_package options
					UtilitiesFormHelper::options($vdm_packageXML, $vdm_packageOptions);
					// setup the vdm_package radio field
					$vdm_package->setup($vdm_packageXML,'');
					// add to form
					$form[] = $vdm_package;
				}
			}
		}
		elseif ('jcb_package' === $type && in_array('jcb', $this->directories)  && $jcbListObjects = ComponentbuilderHelper::getGithubRepoFileList('communityGithubPackages', ComponentbuilderHelper::$jcbGithubPackagesUrl))
		{
			if (ArrayHelper::check($jcbListObjects))
			{
				// get the jcb_package list field
				$jcb_package = FormHelper::loadFieldType('list',true);
				// start jcb_package xml
				$jcb_packageXML = new \SimpleXMLElement('<field/>');
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
				UtilitiesFormHelper::attributes($jcb_packageXML, $jcb_packageAttributes);
				// start the jcb_package options
				$jcb_packageOptions = array();
				$jcb_packageOptions[''] = 'COM_COMPONENTBUILDER__SELECT_PACKAGE_';
				// load jcb_package options from array
				foreach($jcbListObjects as $jcbListObject)
				{
					if (strpos($jcbListObject->path, '.zip') !== false)
					{
						$jcb_packageOptions[base64_encode(ComponentbuilderHelper::$jcbGithubPackageUrl.$jcbListObject->path)] = $this->setPackageName($jcbListObject->path);
						$load = true;
					}
				}
				// only load if at least one item was found
				if ($load)
				{
					// load the jcb_package options
					UtilitiesFormHelper::options($jcb_packageXML, $jcb_packageOptions);
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
		return StringHelper::safe( preg_replace('/(?<!^)([A-Z])/', '-\ \1', str_replace(array('.zip', 'JCB_'), '', $name)), 'W');
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_IMPORT_TITLE'), 'upload');

		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_componentbuilder');
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('import_joomla_components');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
		}
	}
}
