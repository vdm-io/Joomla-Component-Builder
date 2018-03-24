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
			$radio1 = JFormHelper::loadFieldType('radio',true);
			// Switch to force local update
			$xml = '<field label="'.JText::_('COM_COMPONENTBUILDER_FORCE_LOCAL_UPDATE').'" description="'.JText::_('COM_COMPONENTBUILDER_SHOULD_WE_FORCE_THE_UPDATE_OF_ALL_LOCAL_DATA_EVEN_IF_IT_IS_NEWER_THEN_THE_DATA_BEING_IMPORTED').'" name="force_update" type="radio" class="btn-group btn-group-yesno" default="0" filter="INT">';
			$xml .= '<option value="1">'.JText::_('COM_COMPONENTBUILDER_YES').'</option> <option value="0">'.JText::_('COM_COMPONENTBUILDER_NO').'</option>';
			$xml .= "</field>";
			// prepare the xml
			$force = new SimpleXMLElement($xml);
			// set components to form
			$radio1->setup($force,0);
			// add to form
			$form[] = $radio1;

			$radio2 = JFormHelper::loadFieldType('radio',true);
			// Switch to show more information about the import
			$xml = '<field label="'.JText::_('COM_COMPONENTBUILDER_QUIET').'" description="'.JText::_('COM_COMPONENTBUILDER_SELECT_IF_THE_IMPORT_SHOULD_BE_SHOWING_MORE_ELABORATE_OR_LESS_QUIET_INFORMATION_DURING_IMPORT').'" name="more_info" type="radio" class="btn-group btn-group-yesno" default="0" filter="INT">';
			$xml .= '<option value="0">'.JText::_('COM_COMPONENTBUILDER_YES').'</option> <option value="1">'.JText::_('COM_COMPONENTBUILDER_NO').'</option>';
			$xml .= "</field>";
			// prepare the xml
			$information = new SimpleXMLElement($xml);
			// set information to form
			$radio2->setup($information,0);
			// add to form
			$form[] = $radio2;
		
			if (!$this->packageInfo || (isset($this->packageInfo['getKeyFrom']) && ComponentbuilderHelper::checkArray($this->packageInfo['getKeyFrom'])))
			{
				// set required field
				$required = 'required="true"';
				if (!$this->packageInfo)
				{
					$radio2 = JFormHelper::loadFieldType('radio',true);
					// has key
					$xml = '<field label="'.JText::_('COM_COMPONENTBUILDER_USE_KEY').'" description="'.JText::_('COM_COMPONENTBUILDER_DOES_THIS_PACKAGE_REQUIRE_A_KEY_TO_INSTALL').'" name="haskey" type="radio" class="btn-group btn-group-yesno" default="1" filter="INT">';
					$xml .= '<option value="1">'.JText::_('COM_COMPONENTBUILDER_YES').'</option> <option value="0">'.JText::_('COM_COMPONENTBUILDER_NO').'</option>';
					$xml .= "</field>";
					// prepare the xml
					$license = new SimpleXMLElement($xml);
					// set components to form
					$radio2->setup($license,1);
					$required = ''; // change required field
					// add to form
					$form[] = $radio2;
				}

				$text1 = JFormHelper::loadFieldType('text',true);
				// add the key
				$xml = '<field type="password" label="'.JText::_('COM_COMPONENTBUILDER_KEY').'" description="'.JText::_('COM_COMPONENTBUILDER_THE_KEY_OF_THIS_PACKAGE').'" name="sleutle" autocomplete="false" class="text_area" filter="STRING" hint="add key here" '.$required.' />';
				// prepare the xml
				$sleutle = new SimpleXMLElement($xml);
				// set components to form
				$text1->setup($sleutle,'');
				// add to form
				$form[] = $text1;
			}
		}
		elseif ('vdm_package' === $type && $listObjects = ComponentbuilderHelper::getGithubRepoFileList('jcbGithubPackages', ComponentbuilderHelper::$jcbGithubPackagesUrl.ComponentbuilderHelper::$accessToken))
		{
			if (ComponentbuilderHelper::checkArray($listObjects))
			{
				// load the vdm packages if available
				$list = JFormHelper::loadFieldType('list',true);
				// load the list
				$load = false;
				// start building componet xml field
				$xml = '<field label="Package" description="'.JText::_('COM_COMPONENTBUILDER_SELECT_THE_PACKAGE_TO_IMPORT').'" name="vdm_package" type="list" class="list_class">';
				$xml .= '<option value="">'.JText::_('COM_COMPONENTBUILDER__SELECT_PACKAGE_').'</option>';
				foreach($listObjects as $listObject)
				{
					if (strpos($listObject->path, '.zip') !== false)
					{
						$xml .= '<option value="'.ComponentbuilderHelper::$jcbGithubPackageUrl.$listObject->path.'">'.$this->setPackageName($listObject->path).'</option>';
						$load = true;
					}
				}
				$xml .= "</field>";
				// only load if at least one item was found
				if ($load)
				{
					// prepare the xml
					$packages = new SimpleXMLElement($xml);
					// set components to form
					$list->setup($packages, '');

					// set to form
					$form[] = $list;
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
