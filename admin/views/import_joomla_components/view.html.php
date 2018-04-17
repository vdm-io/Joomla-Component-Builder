<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.7.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		view.html.php
	@author			Llewellyn van der Merwe <http://joomlacomponentbuilder.com>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

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
	protected $freePackages = array('JCB_demo.zip', 'JCB_helloWorld.zip');

	public function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			ComponentbuilderHelper::addSubmenu('import');
		}

		$paths = new stdClass;
		$paths->first = '';
		$state = $this->get('state');

		$this->paths = &$paths;
		$this->state = &$state;
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('import');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
		}
		// load the application
		$app = JFactory::getApplication();
		// get the session object
		$session = JFactory::getSession();
		// check if it has package
		$this->hasPackage = $session->get('hasPackage', false);
		$this->dataType = $session->get('dataType', false);
		if (!$this->dataType)
		{
			$this->dataType = $session->get('dataType_VDM_IMPORTINTO',  null);
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
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);
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
				'description' => 'COM_COMPONENTBUILDER_SHOULD_WE_MERGE_THE_COMPONENTS_WITH_SIMILAR_LOCAL_COMPONENTS_MERGING_THE_COMPONENTS_USE_TO_BE_THE_DEFAULT_BEHAVIOUR_BUT_NOW_YOU_CAN_IMPORT_THE_COMPONENTS_AND_FORCE_IT_NOT_TO_MERGE_THE_FOLLOWING_AREAS_VALIDATION_RULE_FIELDTYPE_SNIPPET_LANGUAGE_LANGUAGE_TRANSLATION_BMUST_AND_WILL_STILLB_MERGE_EVEN_OF_YOUR_SELECTION_IS_BNOB_BECAUSE_OF_THE_SINGULAR_NATURE_OF_THOSE_AREAS',
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
		
			if (!$this->packageInfo || (isset($this->packageInfo['getKeyFrom']) && ComponentbuilderHelper::checkArray($this->packageInfo['getKeyFrom'])))
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
		elseif ('vdm_package' === $type && $listObjects = ComponentbuilderHelper::getGithubRepoFileList('jcbGithubPackages', ComponentbuilderHelper::$jcbGithubPackagesUrl.ComponentbuilderHelper::$accessToken))
		{
			if (ComponentbuilderHelper::checkArray($listObjects))
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
					'description' => 'COM_COMPONENTBUILDER_SELECT_THE_PACKAGE_TO_IMPORT');
				// load the list
				$load = false;
				// load the vdm_package attributes
				ComponentbuilderHelper::xmlAddAttributes($vdm_packageXML, $vdm_packageAttributes);
				// start the vdm_package options
				$vdm_packageOptions = array();
				$vdm_packageOptions[''] = 'COM_COMPONENTBUILDER__SELECT_PACKAGE_';
				// load vdm_package options from array
				foreach($listObjects as $listObject)
				{
					if (strpos($listObject->path, '.zip') !== false)
					{
						$vdm_packageOptions[ComponentbuilderHelper::$jcbGithubPackageUrl.$listObject->path] = $this->setPackageName($listObject->path);
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
		return $form;
	}

	public function setPackageName($name)
	{
		// the free switch
		if (in_array($name, $this->freePackages))
		{
			$type = ' - free';
		}
		else
		{
			$type = ' - paid';
		}
		// return the name
		return ComponentbuilderHelper::safeString( preg_replace('/(?<!^)([A-Z])/', '-\ \1', str_replace(array('.zip', 'JCB_'), '', $name)), 'W').$type;
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
