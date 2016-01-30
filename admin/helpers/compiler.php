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

	@version		2.0.8
	@build			30th January, 2016
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		compiler.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// include class to minify js
require_once JPATH_ADMINISTRATOR.'/components/com_componentbuilder/helpers/js.php';

// import the Joomla librarys
jimport('joomla.application.component.modellist');
jimport('joomla.application');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');

/**
 * Compiler class
 */
class Compiler
{
	public $folderCount			= 0;
	public $fileCount			= 0;
	public $lineCount			= 0;
	public $filepath			= '';
	public $componentFolderName             = '';
	// fixed pathes
	protected $compilerPath;
	protected $templatePath;
	protected $bomPath;
	protected $componentPath;
	protected $tempPath;
	protected $add2SalesServer					= false;
	protected $backupPath						= false;
	protected $gitPath						= false;
	// data sets
	protected $params;
	protected $componentCodeName;
	protected $componentData;
	protected $joomlaVersion;
	protected $joomlaVersionData;
	protected $loadLineNr						= false;
	protected $addEximport						= false;
	protected $googlechart						= false;
	// new
	protected $newFiles						= array();
	protected $codes						= array();
	protected $notNew						= array();
	protected $langContent						= array();
	protected $placeholders						= array();
	protected $addCheckin						= false;
	protected $addContributors					= false;
	protected $addAjax						= false;
	protected $theContributors					= '';
	protected $fileContentStatic                                    = array();
	protected $fileContentDynamic                                   = array();
	protected $langPrefix						= 'COM_';
	protected $lang							= 'admin';
	protected $queryBuilder						= array();
	protected $dbUniqueKeys						= array();
	protected $dbKeys						= array();
	protected $customScriptBuilder                                  = array();
	protected $uninstallBuilder					= array();
	protected $listBuilder						= array();
	protected $listColnrBuilder					= array();
	protected $sortBuilder						= array();
	protected $searchBuilder					= array();
	protected $filterBuilder					= array();
	protected $layoutBuilder					= array();
	protected $permissionBuilder                                    = array();
	protected $permissionDashboard                                  = array();
	protected $permissionCore					= array();
	protected $customFieldBuilder                                   = array();
	protected $aliasBuilder						= array();
	protected $catCodeBuilder					= array();
	protected $titleBuilder						= array();
	protected $buildCategories					= array();
	protected $iconBuilder						= array();
	protected $hiddenFieldsBuilder                                  = array();
	protected $dynamicfieldsBuilder                                 = array();
	protected $intFieldsBuilder					= array();
	protected $customFieldLinksBuilder                              = array();
	protected $tabCounter						= array();
	protected $tagsBuilder						= array();
	protected $historyBuilder					= array();
	protected $checkboxBuilder					= array();
	protected $jsonItemBuilder					= array();
	protected $jsonStringBuilder                                    = array();
	protected $base64Builder					= array();
	protected $basicEncryptionBuilder                               = array();
	protected $advancedEncryptionBuilder                            = array();
	protected $customBuilder					= array();
	protected $selectionTranslationFixBuilder                       = array();
	protected $validationFixBuilder                                 = array();
	protected $customBuilderList                                    = array();
	protected $setTagHistory					= false;
	protected $editBodyViewScriptBuilder                            = array();
	protected $targetRelationControl                                = array();
	protected $targetControlsScriptChecker                          = array();
	protected $setScriptUserSwitch                                  = array();
	protected $setScriptMediaSwitch                                 = array();
	protected $setGroupControl					= array();
	protected $footableScripts					= array();
	protected $doNotEscape						= array();
	protected $setRouterHelpDone					= array();
	// front new
	protected $uikit						= false;
	protected $uikitComp						= array();
	protected $templateData						= array();
	protected $layoutData						= array();
	protected $getAsLookup						= array();
	protected $otherWhere						= array();

	/**
	 * Constructor
	 */
	public function __construct($config = array ())
	{
		if (isset($config) && count($config))
		{
			$this->params			= JComponentHelper::getParams('com_componentbuilder');
			$this->compilerPath		= $this->params->get('compiler_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/compiler');
			$this->joomlaVersion		= $config['joomlaVersion'];
			$this->templatePath		= $this->compilerPath.'/joomla_'.$config['joomlaVersion'];
			$this->templatePathCustom	= $this->params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom');
			$this->componentData		= $this->getComponentData($config['componentId']); // get the version settings
			$this->loadLineNr		= ($this->componentData->debug_linenr) ? true:false;
			$this->joomlaVersionData	= $this->setJoomlaVersionData();
			$this->componentSalesName	= 'com_'.$this->componentData->sales_name.'__J'.$this->joomlaVersion;
			$this->componentBackupName	= 'com_'.$this->componentData->sales_name.'_v'.str_replace('.','_',$this->componentData->component_version).'__J'.$this->joomlaVersion;
			$this->componentFolderName	= 'com_'.$this->componentData->name_code.'_v'.str_replace('.','_',$this->componentData->component_version).'__J'.$this->joomlaVersion;
			$this->componentPath		= $this->compilerPath.'/'.$this->componentFolderName;
			// set temp directory
			$comConfig			= JFactory::getConfig();
			$this->tempPath			= $comConfig->get('tmp_path');
			// set some folder paths in relation to distribution
			if ($config['addBackup'])
			{
				$this->backupPath	= $this->params->get('backup_folder_path', $this->tempPath).'/'.$this->componentBackupName.'.zip';
				$this->add2SalesServer	= true;
			}
			if ($config['addGit'])
			{
				$this->gitPath		= $this->params->get('git_folder_path', null);
			}
			// build the component
			return $this->buildComponent();
		}
		return false;
	}
	
	protected function setLine($nr)
	{
		if ($this->loadLineNr)
		{
			return ' ['.$nr.']';	
		}
		return '';
	}

	protected function buildComponent()
	{
		// make sure there is no old build
		$this->removeFolder($this->componentPath);
		// set all the needed folders
		if ($this->buildFolders())
		{
			// build the static files
			if ($this->setStatic())
			{
				// build the dynamique files
				if ($this->dynamique())
				{
					// build the update to update all content in all files
					if ($this->buildFileContent())
					{
						// now update the files
						if ($this->updateFiles())
						{
							// zip the component
							if ($this->zipComponent())
							{
								// done
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	protected function buildFileContent()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			// ###COMPONENT###
			$this->fileContentStatic['###COMPONENT###'] = ComponentbuilderHelper::safeString($this->componentData->name_code, 'U');

			// ###Component###
			$this->fileContentStatic['###Component###'] = ComponentbuilderHelper::safeString($this->componentData->name_code, 'F');

			// ###component###
			$this->fileContentStatic['###component###'] = ComponentbuilderHelper::safeString($this->componentData->name_code);

			// ###COMPANYNAME###
			$this->fileContentStatic['###COMPANYNAME###'] = trim($this->componentData->companyname);
			
			// ###CREATIONDATE###
			$this->fileContentStatic['###CREATIONDATE###'] = JFactory::getDate($this->componentData->created)->format('jS F, Y');
			
			// ###BUILDDATE###
			$this->fileContentStatic['###BUILDDATE###'] = JFactory::getDate()->format('jS F, Y');
			
			// ###AUTHOR###
			$this->fileContentStatic['###AUTHOR###'] = trim($this->componentData->author);

			// ###AUTHOREMAIL###
			$this->fileContentStatic['###AUTHOREMAIL###'] = trim($this->componentData->email);

			// ###AUTHORWEBSITE###
			$this->fileContentStatic['###AUTHORWEBSITE###'] = trim($this->componentData->website);

			// ###COPYRIGHT###
			$this->fileContentStatic['###COPYRIGHT###'] = trim($this->componentData->copyright);

			// ###LICENSE###
			$this->fileContentStatic['###LICENSE###'] = trim($this->componentData->license);

			// ###VERSION###
			$this->fileContentStatic['###VERSION###'] = trim($this->componentData->component_version);

			// ###Component_name###
			$this->fileContentStatic['###Component_name###'] = ComponentbuilderHelper::safeString($this->componentData->name,'W');

			// ###SHORT_DISCRIPTION###
			$this->fileContentStatic['###SHORT_DESCRIPTION###'] = trim($this->componentData->short_description);

			// ###DESCRIPTION###
			$this->fileContentStatic['###DESCRIPTION###'] = trim($this->componentData->description);

			// ###COMP_IMAGE_TYPE###
			$this->fileContentStatic['###COMP_IMAGE_TYPE###'] = $this->setComponentImageType($this->componentData->image);

			// ###ACCESS_SECTIONS###
			$this->fileContentStatic['###ACCESS_SECTIONS###'] = $this->setAccessSections();

			// set component place holders
			$this->placeholders = array(
				'###Component###'		=> $this->fileContentStatic['###Component###'],
				'###component###'		=> $this->fileContentStatic['###component###'],
				'###COMPONENT###'		=> $this->fileContentStatic['###COMPONENT###'],
				'[[[Component]]]'		=> $this->fileContentStatic['###Component###'],
				'[[[component]]]'		=> $this->fileContentStatic['###component###'],
				'[[[COMPONENT]]]'		=> $this->fileContentStatic['###COMPONENT###']
				);
			
			// ###CONFIG_FIELDSETS###
			$keepLang = $this->lang;
			$this->lang = 'admin';
			// run the field sets for first time
			$this->setConfigFieldsets(1);
			$this->lang = $keepLang;
			
			// ###ADMINCSS###
			$this->fileContentStatic['###ADMINCSS###'] = str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['component_css']);
			// ###SITECSS###
			$this->fileContentStatic['###SITECSS###'] = str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['component_css']);

			// ###CUSTOM_HELPER_SCRIPT###
			$this->fileContentStatic['###CUSTOM_HELPER_SCRIPT###'] = str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['component_php_helper_admin']);
			
			// ###ADMIN_GLOBAL_EVENT_HELPER###
			$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] = '';
			
			// ###ADMIN_GLOBAL_EVENT###
			$this->fileContentStatic['###ADMIN_GLOBAL_EVENT###'] = '';
			// now load the data for the global event if needed
			if ($this->componentData->add_admin_event == 1)
			{
				// ###ADMIN_GLOBAL_EVENT###
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT###'] = "\n\n".'// Triger the Global Admin Event';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT###'] .= "\n".$this->fileContentStatic['###Component###'].'Helper::globalEvent($document);';
				// ###ADMIN_GLOBAL_EVENT_HELPER###
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] = "\n\n\t".'/**';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= "\n\t".'*	The Global Admin Event Method.';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= "\n\t".'**/';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= "\n\t".'public static function globalEvent($document)';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= "\n\t".'{';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['component_php_admin_event']);
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= "\n\t".'}';
			}
			
			// ###HELPER_CREATEUSER###
			$this->fileContentStatic['###HELPER_CREATEUSER###'] = $this->setCreateUserHelperMethod($this->componentData->creatuserhelper);

			// ###HELP###
			$this->fileContentStatic['###HELP###'] = $this->noHelp();
			// ###HELP_SITE###
			$this->fileContentStatic['###HELP_SITE###'] = $this->noHelp();
			// ###UPDATE_VERSION_MYSQL###
			$this->setVersionController();

			// setup back-views and all needed stuff for the admin
			if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
			{
				// reset view array
				$viewarray = array();
				$site_edit_view_array = array();
				// start dynamic build
				foreach ($this->componentData->admin_views as $view)
				{
					$this->lang = 'admin';
					// set main keys
					$viewName_single = ComponentbuilderHelper::safeString($view['settings']->name_single);
					$viewName_list = ComponentbuilderHelper::safeString($view['settings']->name_list);
					// set site edit view array
					if ($view['edit_create_site_view'])
					{
						$site_edit_view_array[] = "\t\t\t\t'".$viewName_single."'";
						$this->lang = 'both';
					}
					// set the export/import option
					if ($view['port'])
					{
						$this->eximportView[$viewName_list] = true;
					}
					else
					{
						$this->eximportView[$viewName_list] = false;
					}
					// check if help is being loaded
					$this->checkHelp($viewName_single);
					// set custom admin view list links
					$this->setCustomAdminViewListLink($view,$viewName_list);
					
					// set view array
					$viewarray[] = "\t\t\t\t'".$viewName_single."' => '".$viewName_list."'";
					// set the view names
					if ($view['settings']->name_single != 'null')
					{
						// ###VIEW### <<<DYNAMIC>>>
						$viewName_u = ComponentbuilderHelper::safeString($view['settings']->name_single,'U');
						$this->fileContentDynamic[$viewName_single]['###VIEW###'] = $viewName_u;
						$this->fileContentDynamic[$viewName_list]['###VIEW###'] = $viewName_u;

						// ###View### <<<DYNAMIC>>>
						$viewName_f = ComponentbuilderHelper::safeString($view['settings']->name_single,'F');
						$this->fileContentDynamic[$viewName_single]['###View###'] = $viewName_f;
						$this->fileContentDynamic[$viewName_list]['###View###'] = $viewName_f;

						// ###view### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###view###'] = $viewName_single;
						$this->fileContentDynamic[$viewName_list]['###view###'] = $viewName_single;

						// set some place holder for the views
						$this->placeholders['###view###'] = $viewName_single;
						
						// set license per view if needed
						$this->setLockLicensePer($viewName_single);
						$this->setLockLicensePer($viewName_list);

						// ###FIELDSETS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###FIELDSETS###'] = $this->setFieldSet($view, $this->fileContentStatic['###component###']);

						// ###ACCESSCONTROL### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###ACCESSCONTROL###'] = $this->setFieldSetAccessControl($viewName_single);

						// ###LINKEDVIEWITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWITEMS###'] = '';

						// ###ADDTOOLBAR### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###ADDTOOLBAR###'] = $this->setAddToolBar($view);

						// set the script for this view
						$this->buildTheViewScript($view, $this->fileContentStatic['###component###']);

						// ###VIEW_SCRIPT###
						$this->fileContentDynamic[$viewName_single]['###VIEW_SCRIPT###'] = $this->setViewScript($viewName_single);

						// ###EDITBODYSCRIPT###
						$this->fileContentDynamic[$viewName_single]['###EDITBODYSCRIPT###'] = $this->setEditBodyScript($viewName_single);

						// ###AJAXTOKE### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###AJAXTOKE###'] = $this->setAjaxToke($viewName_single);

						// ###LINKEDVIEWTABLESCRIPTS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWTABLESCRIPTS###'] = '';

						// ###VALIDATEFIX### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###VALIDATIONFIX###'] = $this->setValidationFix($viewName_single, $this->fileContentStatic['###Component###']);

						// ###EDITBODY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###EDITBODY###'] = $this->setEditBody($view);

						// ###JTABLECONSTRUCTOR### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###JTABLECONSTRUCTOR###'] = $this->setJtableConstructor($viewName_single);

						// ###JTABLEALIASCATEGORY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###JTABLEALIASCATEGORY###'] = $this->setJtableAliasCategory($viewName_single);

						// ###METHOD_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###METHOD_GET_ITEM###'] = $this->setMethodGetItem($viewName_single);

						// ###LINKEDVIEWGLOBAL### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWGLOBAL###'] = '';

						// ###LINKEDVIEWMETHODS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWMETHODS###'] = '';

						// ###JMODELADMIN_BEFORE_DELETE### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_BEFORE_DELETE###'] = $this->setJmodelAdminBeforeDelete($viewName_single);

						// ###JMODELADMIN_AFTER_DELETE### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_AFTER_DELETE###'] = $this->setJmodelAdminAfterDelete($viewName_single);

						// ###CHECKBOX_SAVE### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###CHECKBOX_SAVE###'] = $this->setCheckboxSave($viewName_single);

						// ###METHOD_ITEM_SAVE### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###METHOD_ITEM_SAVE###'] = $this->setMethodItemSave($viewName_single);

						// ###POSTSAVEHOOK### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_single]['###POSTSAVEHOOK###'] = $this->setPostSaveHook($viewName_single);

						if (isset($this->customScriptBuilder['css_view'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['css_view'][$viewName_single]))
						{
							// ###VIEWCSS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_single]['###VIEWCSS###']
								= str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['css_view'][$viewName_single]);
							// clear some memory
							unset($this->customScriptBuilder['css_view'][$viewName_single]);
						}
						else
						{
							// ###VIEWCSS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_single]['###VIEWCSS###'] = '';
						}
						// add css to front end
						if ($view['edit_create_site_view'])
						{
							$this->fileContentDynamic[$viewName_single]['###SITE_VIEWCSS###'] = $this->fileContentDynamic[$viewName_single]['###VIEWCSS###'];
						}
					}
					// set the views names
					if ($view['settings']->name_list != 'null')
					{
						$this->lang = 'admin';
						// ###VIEWS### <<<DYNAMIC>>>
						$viewsName_u = ComponentbuilderHelper::safeString($view['settings']->name_list,'U');
						$this->fileContentDynamic[$viewName_list]['###VIEWS###'] = $viewsName_u;
						$this->fileContentDynamic[$viewName_single]['###VIEWS###'] = $viewsName_u;

						// ###Views### <<<DYNAMIC>>>
						$viewsName_f = ComponentbuilderHelper::safeString($view['settings']->name_list,'F');
						$this->fileContentDynamic[$viewName_list]['###Views###'] = $viewsName_f;
						$this->fileContentDynamic[$viewName_single]['###Views###'] = $viewsName_f;

						// ###views### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###views###'] = $viewName_list;
						$this->fileContentDynamic[$viewName_single]['###views###'] = $viewName_list;
						// ###ICOMOON### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###ICOMOON###'] = $view['icomoon'];

						// set some place holder for the views
						$this->placeholders['###views###'] = $viewName_list;

						// set Autocheckin function
						if ($view['checkin'] == 1)
						{
							// ###AUTOCHECKIN### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_list]['###AUTOCHECKIN###'] = $this->setAutoCheckin($viewName_single,$this->fileContentStatic['###component###']);
							// ###CHECKINCALL### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_list]['###CHECKINCALL###'] = $this->setCheckinCall();
						}
						else
						{
							// ###AUTOCHECKIN### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_list]['###AUTOCHECKIN###'] = '';
							// ###CHECKINCALL### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_list]['###CHECKINCALL###'] = '';
						}

						// ###STORE_METHOD_FIX### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###GET_ITEMS_METHOD_STRING_FIX###'] = $this->setGetItemsMethodStringFix($viewName_single,$this->fileContentStatic['###Component###']);

						// ###SELECTIONTRANSLATIONFIX### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###SELECTIONTRANSLATIONFIX###'] = $this->setSelectionTranslationFix($viewName_list,$this->fileContentStatic['###Component###']);

						// ###SELECTIONTRANSLATIONFIXFUNC### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###SELECTIONTRANSLATIONFIXFUNC###'] = $this->setSelectionTranslationFixFunc($viewName_list,$this->fileContentStatic['###Component###']);

						// ###FILTER_FIELDS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###FILTER_FIELDS###'] = $this->setFilterFields($viewName_list);

						// ###STOREDID### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###STOREDID###'] = $this->setStoredId($viewName_list);

						// ###POPULATESTATE### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###POPULATESTATE###'] = $this->setPopulateState($viewName_list);

						// ###SORTFIELDS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###SORTFIELDS###'] = $this->setSortFields($viewName_list);

						// ###CATEGORYFILTER### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###CATEGORYFILTER###'] = $this->setCategoryFilter($viewName_list);

						// ###CATEGORY_VIEWS###
						if (!isset($this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###']))
						{
							$this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###'] = '';
						}
						$this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###'] .= $this->setRouterCategoryViews($viewName_single,$viewName_list);

						// ###OTHERFILTERS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###OTHERFILTERS###'] = $this->setOtherFilter($viewName_list);

						// ###FILTERFUNCTIONS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###FILTERFUNCTIONS###'] = $this->setFilterFunctions($viewName_single,$viewName_list);

						// ###LISTQUERY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###LISTQUERY###'] = $this->setListQuery($viewName_single,$viewName_list);

						// ###MODELEXPORTMETHOD### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###MODELEXPORTMETHOD###'] = $this->setModelExportMethod($viewName_single, $viewName_list);

						// ###MODELEXIMPORTMETHOD### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###CONTROLLEREXIMPORTMETHOD###'] = $this->setControllerEximportMethod($viewName_single, $viewName_list);

						// ###EXPORTBUTTON### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###EXPORTBUTTON###'] = $this->setExportButton($viewName_single, $viewName_list);

						// ###IMPORTBUTTON### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###IMPORTBUTTON###'] = $this->setImportButton($viewName_single, $viewName_list);

						// ###LISTHEAD### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###LISTHEAD###'] = $this->setListHead($viewName_single,$viewName_list);

						// ###LISTBODY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###LISTBODY###'] = $this->setListBody($viewName_single,$viewName_list);

						// ###LISTCOLNR### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###LISTCOLNR###'] = $this->setListColnr($viewName_list);

						// ###JVIEWLISTCANDO### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###JVIEWLISTCANDO###'] = $this->setJviewListCanDo($viewName_single,$viewName_list);
						
						if (isset($this->customScriptBuilder['css_views'][$viewName_list]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['css_views'][$viewName_list]))
						{
							// ###VIEWCSS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_list]['###VIEWSCSS###']
								= str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['css_views'][$viewName_list]);
							// clear some memory
							unset($this->customScriptBuilder['css_views'][$viewName_list]);
						}
						else
						{
							// ###VIEWCSS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_list]['###VIEWSCSS###'] = '';
						}
					}

					// set u fields used in batch
					$this->fileContentDynamic[$viewName_single]['###UNIQUEFIELDS###'] = $this->setUniqueFields($viewName_single);

					// ###TITLEALIASFIX### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###TITLEALIASFIX###'] = $this->setAliasTitleFix($viewName_single);

					// ###GENERATENEWTITLE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###GENERATENEWTITLE###'] = $this->setGenerateNewTitle($viewName_single);

					// ###MODEL_BATCH_COPY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###MODEL_BATCH_COPY###'] = $this->setBatchCopy($viewName_single);

					// ###MODEL_BATCH_MOVE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###MODEL_BATCH_MOVE###'] = $this->setBatchMove($viewName_single);

					// ###JCONTROLLERFORM_ALLOWADD### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JCONTROLLERFORM_ALLOWADD###'] = $this->setJcontrollerAllowAdd($viewName_single,$viewName_list);

					// ###JCONTROLLERFORM_ALLOWEDIT### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JCONTROLLERFORM_ALLOWEDIT###'] = $this->setJcontrollerAllowEdit($viewName_single,$viewName_list);

					// ###JMODELADMIN_GETFORM### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_GETFORM###'] = $this->setJmodelAdminGetForm($viewName_single,$viewName_list);

					// ###JMODELADMIN_ALLOWEDIT### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_ALLOWEDIT###'] = $this->setJmodelAdminAllowEdit($viewName_single,$viewName_list);

					// ###JMODELADMIN_CANDELETE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_CANDELETE###'] = $this->setJmodelAdminCanDelete($viewName_single,$viewName_list);

					// ###JMODELADMIN_CANEDITSTATE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_CANEDITSTATE###'] = $this->setJmodelAdminCanEditState($viewName_single,$viewName_list);
					
					// set custom admin view Toolbare buttons
					// ###CUSTOM_ADMIN_DYNAMIC_BUTTONS###  <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###CUSTOM_ADMIN_DYNAMIC_BUTTONS###'] = $this->setCustomAdminDynamicButton($viewName_list);
					// ###CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER###  <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER###'] = $this->setCustomAdminDynamicButtonController($viewName_list);

					// set helper router
					if (!isset($this->fileContentStatic['###ROUTEHELPER###']))
					{
						$this->fileContentStatic['###ROUTEHELPER###'] = '';
					}
					$this->fileContentStatic['###ROUTEHELPER###'] .= $this->setRouterHelp($viewName_single, $viewName_list);

					// ###ACCESS_SECTIONS###
					if (!isset($this->fileContentStatic['###ACCESS_SECTIONS###']))
					{
						$this->fileContentStatic['###ACCESS_SECTIONS###'] = '';
					}
					$this->fileContentStatic['###ACCESS_SECTIONS###'] .= $this->setAccessSectionsCategory($viewName_single, $viewName_list);

					// ###HELPER_EXEL###
					$this->fileContentStatic['###HELPER_EXEL###'] = $this->setExelHelperMethods();

				}

				// setup custom_admin_views and all needed stuff for the site
				if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
				{
					$this->target		= 'custom_admin';
					$this->lang		= 'admin';
					// var_dump($this->componentData->custom_admin_views);exit;
					// start dynamic build
					foreach ($this->componentData->custom_admin_views as $view)
					{
						// for single views
						$this->fileContentDynamic[$view['settings']->code]['###SView###'] = $view['settings']->Code;
						$this->fileContentDynamic[$view['settings']->code]['###sview###'] = $view['settings']->code;
						$this->fileContentDynamic[$view['settings']->code]['###SVIEW###'] = $view['settings']->CODE;
						// for list views
						$this->fileContentDynamic[$view['settings']->code]['###SViews###'] = $view['settings']->Code;
						$this->fileContentDynamic[$view['settings']->code]['###sviews###'] = $view['settings']->code;
						$this->fileContentDynamic[$view['settings']->code]['###SVIEWS###'] = $view['settings']->CODE;
						// add to lang array
						if (!isset($this->langContent[$this->lang][$this->langPrefix.'_'.$view['settings']->CODE]))
						{
							$this->langContent[$this->lang][$this->langPrefix.'_'.$view['settings']->CODE] = $view['settings']->name;
						}
						if (!isset($this->langContent[$this->lang][$this->langPrefix.'_'.$view['settings']->CODE.'_DESC']))
						{
							$this->langContent[$this->lang][$this->langPrefix.'_'.$view['settings']->CODE.'_DESC'] = $view['settings']->description;
						}
						// ###ICOMOON### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###ICOMOON###'] = $view['icomoon'];
						
						// set placeholders
						$this->placeholders['###SView###'] = $view['settings']->Code;
						$this->placeholders['###sview###'] = $view['settings']->code;
						$this->placeholders['###SVIEW###'] = $view['settings']->CODE;
						$this->placeholders['[[[SView]]]'] = $view['settings']->Code;
						$this->placeholders['[[[sview]]]'] = $view['settings']->code;
						$this->placeholders['[[[SVIEW]]]'] = $view['settings']->CODE;
						$this->placeholders['###SViews###'] = $view['settings']->Code;
						$this->placeholders['###sviews###'] = $view['settings']->code;
						$this->placeholders['###SVIEWS###'] = $view['settings']->CODE;
						$this->placeholders['[[[SViews]]]'] = $view['settings']->Code;
						$this->placeholders['[[[sviews]]]'] = $view['settings']->code;
						$this->placeholders['[[[SVIEWS]]]'] = $view['settings']->CODE;
						
						// set license per view if needed
						$this->setLockLicensePer($view['settings']->code);
						
						if ($view['settings']->main_get->gettype == 1)
						{
							// check if there is any custom script
							if (isset($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]))
							{
								// ###CUSTOM_ADMIN_BEFORE_GET_ITEM### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_BEFORE_GET_ITEM###']
									= str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]);
								// clear some memory
								unset($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]);
							}
							else
							{
								// ###CUSTOM_ADMIN_BEFORE_GET_ITEM### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_BEFORE_GET_ITEM###'] = '';
							}

							// ###CUSTOM_ADMIN_GET_ITEM### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_GET_ITEM###'] = $this->setCustomViewGetItem($view['settings']->main_get, $view['settings']->code,"\t\t");

							// check if there is any custom script
							if (isset($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]))
							{
								// ###CUSTOM_ADMIN_AFTER_GET_ITEM### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_AFTER_GET_ITEM###']
									= str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]);
								// clear some memory
								unset($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]);
							}
							else
							{
								// ###CUSTOM_ADMIN_AFTER_GET_ITEM### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_AFTER_GET_ITEM###'] = '';
							}
						}
						elseif ($view['settings']->main_get->gettype == 2)
						{
							// ###CUSTOM_ADMIN_GET_LIST_QUERY### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_GET_LIST_QUERY###'] = $this->setCustomViewListQuery($view['settings']->main_get, $view['settings']->code);
							
							// check if there is any custom script
							if (isset($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]))
							{
								// ###CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY###']
									= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]);
								// clear some memory
								unset($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]);
							}
							else
							{
								// ###CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY###'] = '';
							}

							// check if there is any custom script
							if (isset($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]))
							{
								// ###CUSTOM_ADMIN_BEFORE_GET_ITEMS### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_BEFORE_GET_ITEMS###']
									= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]);
								// clear some memory
								unset($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]);
							}
							else
							{
								// ###CUSTOM_ADMIN_BEFORE_GET_ITEMS### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_BEFORE_GET_ITEMS###'] = '';
							}

							// ###CUSTOM_ADMIN_GET_ITEMS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_GET_ITEMS###'] = $this->setCustomViewGetItems($view['settings']->main_get, $view['settings']->code);

							// check if there is any custom script
							if (isset($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]))
							{
								// ###CUSTOM_ADMIN_AFTER_GET_ITEMS### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_AFTER_GET_ITEMS###']
									= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]);
								// clear some memory
								unset($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]);
							}
							else
							{
								// ###CUSTOM_ADMIN_AFTER_GET_ITEMS### <<<DYNAMIC>>>
								$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_AFTER_GET_ITEMS###'] = '';
							}
						}

						// ###CUSTOM_ADMIN_CUSTOM_METHODS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_CUSTOM_METHODS###'] = $this->setCustomViewCustomItemMethods($view['settings']->main_get, $view['settings']->code);
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_CUSTOM_METHODS###'] .= $this->setCustomViewCustomMethods($view, $view['settings']->code);
						// ###CUSTOM_ADMIN_DIPLAY_METHOD### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_DIPLAY_METHOD###'] = $this->setCustomViewDisplayMethod($view);
						// set document details
						$this->setPrepareDocument($view);
						// ###CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS###'] = $this->setCustomViewExtraDisplayMethods($view);
						// ###CUSTOM_ADMIN_CODE_BODY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_CODE_BODY###'] = $this->setCustomViewCodeBody($view);
						// ###CUSTOM_ADMIN_BODY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_BODY###'] = $this->setCustomViewBody($view);

						// setup the templates
						$this->setCustomViewTemplateBody($view);
					}

					// setup the layouts
					$this->setCustomViewLayouts();
				}

				// ###VIEWARRAY###
				$this->fileContentStatic['###VIEWARRAY###'] = "\n".implode(",\n",$viewarray);
				
				// ###CUSTOM_ADMIN_EDIT_VIEW_ARRAY###
				$this->fileContentStatic['###SITE_EDIT_VIEW_ARRAY###'] = "\n".implode(",\n",$site_edit_view_array);

				// ###MAINMENUS###
				$this->fileContentStatic['###MAINMENUS###'] = $this->setMainMenus();

				// ###SUBMENU###
				$this->fileContentStatic['###SUBMENU###'] = $this->setSubMenus();

				// ###GET_CRYPT_KEY###
				$this->fileContentStatic['###GET_CRYPT_KEY###'] = $this->setGetCryptKey();
				
				// set the license locker
				$this->setLockLicense();

				// ###CONTRIBUTORS###
				$this->fileContentStatic['###CONTRIBUTORS###'] = $this->theContributors;

				// ###INSTALL###
				$this->fileContentStatic['###INSTALL###'] = $this->setInstall();

				// ###UNINSTALL###
				$this->fileContentStatic['###UNINSTALL###'] = $this->setUninstall();

				// ###DASHBOARDICONS###
				$this->fileContentDynamic[$this->fileContentStatic['###component###']]['###DASHBOARDICONS###'] = $this->setDashboardIcons();

				// ###DASHBOARDICONACCESS###
				$this->fileContentDynamic[$this->fileContentStatic['###component###']]['###DASHBOARDICONACCESS###'] = $this->setDashboardIconAccess();

				// add import
				if (isset($this->addEximport) && $this->addEximport)
				{
					// setup import files
					$target = array('admin' => 'import');
					$this->buildDynamique($target,'import');
					// set the controller
					$this->fileContentDynamic['import']['###BLABLABLA###'] = '';
				}

				// ensure that the ajax model and controller is set if needed
				if (isset($this->addAjax) && $this->addAjax)
				{
					// setup Ajax files
					$target = array('admin' => 'ajax');
					$this->buildDynamique($target,'ajax');
					// set the controller
					$this->fileContentDynamic['ajax']['###REGISTER_AJAX_TASK###'] = $this->setRegisterAjaxTask('admin');
					$this->fileContentDynamic['ajax']['###AJAX_INPUT_RETURN###'] = $this->setAjaxInputReturn('admin');
					// set the module
					$this->fileContentDynamic['ajax']['###AJAX_MODEL_METHODS###'] = $this->setAjaxModelMethods('admin');
				}

				// ensure that the site ajax model and controller is set if needed
				if (isset($this->addSiteAjax) && $this->addSiteAjax)
				{
					// setup Ajax files
					$target = array('site' => 'ajax');
					$this->buildDynamique($target,'ajax');
					// set the controller
					$this->fileContentDynamic['ajax']['###REGISTER_SITE_AJAX_TASK###'] = $this->setRegisterAjaxTask('site' );
					$this->fileContentDynamic['ajax']['###AJAX_SITE_INPUT_RETURN###'] = $this->setAjaxInputReturn('site' );
					// set the module
					$this->fileContentDynamic['ajax']['###AJAX_SITE_MODEL_METHODS###'] = $this->setAjaxModelMethods('site');
				}

				// run the second run if needed
				if (isset($this->secondRunAdmin) && ComponentbuilderHelper::checkArray($this->secondRunAdmin))
				{
					// start dynamic build
					foreach ($this->secondRunAdmin as $function => $arrays)
					{
						if (ComponentbuilderHelper::checkArray($arrays) && ComponentbuilderHelper::checkString($function))
						{
							foreach ($arrays as $array)
							{
								$this->{$function}($array);
							}
						}
					}

				}
					
				// ###CONFIG_FIELDSETS###
				$keepLang = $this->lang;
				$this->lang = 'admin';
				// run field sets for second time
				$this->setConfigFieldsets(2);
				$this->lang = $keepLang;
			}

			// build route parse switch
			$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] = '';
			
			// setup front-views and all needed stuff for the site
			if (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views))
			{
				$this->target = 'site';
				// build route views
				$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] = '';
				// var_dump($this->componentData->site_views);exit;
				// start dynamic build
				foreach ($this->componentData->site_views as $view)
				{
					// for list views
					$this->fileContentDynamic[$view['settings']->code]['###SViews###'] = $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code]['###sviews###'] = $view['settings']->code;
					// for single views
					$this->fileContentDynamic[$view['settings']->code]['###SView###'] = $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code]['###sview###'] = $view['settings']->code;

					// set placeholder
					$this->placeholders['###SView###'] = $view['settings']->Code;
					$this->placeholders['###sview###'] = $view['settings']->code;
					$this->placeholders['###SVIEW###'] = $view['settings']->CODE;
					$this->placeholders['[[[SView]]]'] = $view['settings']->Code;
					$this->placeholders['[[[sview]]]'] = $view['settings']->code;
					$this->placeholders['[[[SVIEW]]]'] = $view['settings']->CODE;
					$this->placeholders['###SViews###'] = $view['settings']->Code;
					$this->placeholders['###sviews###'] = $view['settings']->code;
					$this->placeholders['###SVIEWS###'] = $view['settings']->CODE;
					$this->placeholders['[[[SViews]]]'] = $view['settings']->Code;
					$this->placeholders['[[[sviews]]]'] = $view['settings']->code;
					$this->placeholders['[[[SVIEWS]]]'] = $view['settings']->CODE;
						
					// set license per view if needed
					$this->setLockLicensePer($view['settings']->code);
					
					// set the site default view
					if ($view['default_view'] == 1)
					{
						$this->fileContentStatic['###SITE_DEFAULT_VIEW###'] = $view['settings']->code;
					}
					// add site menu
					if ($view['menu'] == 1)
					{
						// ###SITE_MENU_XML### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_MENU_XML###'] = $this->setCustomViewMenu($view);
					}
					
					// insure the needed route helper is loaded
					$this->fileContentStatic['###ROUTEHELPER###'] .= $this->setRouterHelp($view['settings']->code,$view['settings']->code, true);
					// build route details 
					$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] .= $this->routerParseSwitch($view['settings']->code,1);
					$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] .= $this->routerBuildViews($view['settings']->code);
					
					if ($view['settings']->main_get->gettype == 1)
					{
						// check if there is any custom script
						if (isset($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]))
						{
							// ###SITE_BEFORE_GET_ITEM### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_BEFORE_GET_ITEM###']
								= str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]);
							// clear some memory
							unset($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view['settings']->code]);
						}
						else
						{
							// ###SITE_BEFORE_GET_ITEM### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_BEFORE_GET_ITEM###'] = '';
						}

						// ###SITE_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_GET_ITEM###'] = $this->setCustomViewGetItem($view['settings']->main_get, $view['settings']->code,"\t\t");

						// check if there is any custom script
						if (isset($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]))
						{
							// ###SITE_AFTER_GET_ITEM### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_AFTER_GET_ITEM###']
								= str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]);
							// clear some memory
							unset($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view['settings']->code]);
						}
						else
						{
							// ###SITE_AFTER_GET_ITEM### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_AFTER_GET_ITEM###'] = '';
						}
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{						
						// ###SITE_GET_LIST_QUERY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_GET_LIST_QUERY###'] = $this->setCustomViewListQuery($view['settings']->main_get, $view['settings']->code);

						// check if there is any custom script
						if (isset($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]))
						{
							// ###SITE_CUSTOM_BEFORE_LIST_QUERY### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_CUSTOM_BEFORE_LIST_QUERY###']
								= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]);
							// clear some memory
							unset($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view['settings']->code]);
						}
						else
						{
							// ###SITE_CUSTOM_BEFORE_LIST_QUERY### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_CUSTOM_BEFORE_LIST_QUERY###'] = '';
						}

						// check if there is any custom script
						if (isset($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]))
						{
							// ###SITE_BEFORE_GET_ITEMS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_BEFORE_GET_ITEMS###']
								= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]);
							// clear some memory
							unset($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view['settings']->code]);
						}
						else
						{
							// ###SITE_BEFORE_GET_ITEMS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_BEFORE_GET_ITEMS###'] = '';
						}
						
						// ###SITE_GET_ITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_GET_ITEMS###'] = $this->setCustomViewGetItems($view['settings']->main_get, $view['settings']->code);
						
						// check if there is any custom script
						if (isset($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]))
						{
							// ###SITE_AFTER_GET_ITEMS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_AFTER_GET_ITEMS###']
								= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]);
							// clear some memory
							unset($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view['settings']->code]);
						}
						else
						{
							// ###SITE_AFTER_GET_ITEMS### <<<DYNAMIC>>>
							$this->fileContentDynamic[$view['settings']->code]['###SITE_AFTER_GET_ITEMS###'] = '';
						}
					}
					// add to lang array
					if (!isset($this->langContent['site'][$this->langPrefix.'_'.$view['settings']->CODE]))
					{
						$this->langContent['site'][$this->langPrefix.'_'.$view['settings']->CODE] = $view['settings']->name;
					}
					if (!isset($this->langContent['site'][$this->langPrefix.'_'.$view['settings']->CODE.'_DESC']))
					{
						$this->langContent['site'][$this->langPrefix.'_'.$view['settings']->CODE.'_DESC'] = $view['settings']->description;
					}
					// ###SITE_CUSTOM_METHODS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code]['###SITE_CUSTOM_METHODS###'] = $this->setCustomViewCustomItemMethods($view['settings']->main_get, $view['settings']->code);
					$this->fileContentDynamic[$view['settings']->code]['###SITE_CUSTOM_METHODS###'] .= $this->setCustomViewCustomMethods($view, $view['settings']->code);
					// ###SITE_DIPLAY_METHOD### <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code]['###SITE_DIPLAY_METHOD###'] = $this->setCustomViewDisplayMethod($view);
					// set document details
					$this->setPrepareDocument($view);
					// ###SITE_EXTRA_DIPLAY_METHODS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code]['###SITE_EXTRA_DIPLAY_METHODS###'] = $this->setCustomViewExtraDisplayMethods($view);
					// ###SITE_CODE_BODY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code]['###SITE_CODE_BODY###'] = $this->setCustomViewCodeBody($view);
					// ###SITE_BODY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code]['###SITE_BODY###'] = $this->setCustomViewBody($view);

					// setup the templates
					$this->setCustomViewTemplateBody($view);
				}
				// set site custom script to helper class
				// ###SITE_CUSTOM_HELPER_SCRIPT###
				$this->fileContentStatic['###SITE_CUSTOM_HELPER_SCRIPT###'] = str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['component_php_helper_site']);
				// ###SITE_GLOBAL_EVENT_HELPER###
				$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] = '';
				// ###SITE_GLOBAL_EVENT###
				$this->fileContentStatic['###SITE_GLOBAL_EVENT###'] = '';
				// now load the data for the global event if needed
				if ($this->componentData->add_site_event == 1)
				{
					$this->fileContentStatic['###SITE_GLOBAL_EVENT###'] = "\n\n".'// Triger the Global Site Event';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT###'] .= "\n".$this->fileContentStatic['###Component###'].'Helper::globalEvent($document);';
					// ###SITE_GLOBAL_EVENT_HELPER###
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] = "\n\n\t".'/**';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= "\n\t".'*	The Global Site Event Method.';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= "\n\t".'**/';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= "\n\t".'public static function globalEvent($document)';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= "\n\t".'{';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['component_php_site_event']);
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= "\n\t".'}';
				}
				// setup the layouts
				$this->setCustomViewLayouts();
			}
			
			// ###LANG_ADMIN###
			$this->fileContentStatic['###LANG_ADMIN###'] = $this->setLangAdmin();

			// ###LANG_ADMIN_SYS###
			$this->fileContentStatic['###LANG_ADMIN_SYS###'] = $this->setLangAdminSys();
			
			// ###LANG_SITE###
			$this->fileContentStatic['###LANG_SITE###'] = $this->setLangSite();
			
			// ###LANG_SITE_SYS###
			$this->fileContentStatic['###LANG_SITE_SYS###'] = $this->setLangSiteSys();

			// ###INSTALLSCRIPT###
			$this->fileContentStatic['###INSTALLSCRIPT###'] = $this->setInstallScript();

			// ###UPDATESCRIPT###
			$this->fileContentStatic['###UPDATESCRIPT###'] = $this->setUpdateScript();

			// ###UNINSTALLSCRIPT###
			$this->fileContentStatic['###UNINSTALLSCRIPT###'] = $this->setUninstallScript();
			
			// ###HELPER_UIKIT###
			$this->fileContentStatic['###HELPER_UIKIT###'] = $this->setUikitHelperMethods();
			
			// ###CONFIG_FIELDSETS###
			$this->fileContentStatic['###CONFIG_FIELDSETS###'] = implode("\n",$this->configFieldSets);
			
			// check if this has been set
			if (!isset($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']) || !ComponentbuilderHelper::checkString($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']))
			{
				$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] = 0;
			}
			else
			{
				$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] = '('.$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'].')';
			}
			
			// ###README###
			if ($this->componentData->addreadme)
			{
				$this->fileContentStatic['###README###'] = $this->componentData->readme;
			}
			return true;
		}
		return false;
	}

	protected function setLockLicense()
	{
		if ($this->componentData->add_license && $this->componentData->license_type == 2)
		{
			$_VDM = '_'.ComponentbuilderHelper::safeString(ComponentbuilderHelper::randomkey(10),'U');
			// add it to the system
			$this->fileContentStatic['###HELPER_SITE_LICENSE_LOCK###'] = $this->setHelperLincenseLock($_VDM,'site');
			$this->fileContentStatic['###HELPER_LICENSE_LOCK###'] = $this->setHelperLincenseLock($_VDM,'admin');
			$this->fileContentStatic['###LICENSE_LOCKED_INT###'] = $this->setInitLincenseLock($_VDM);
			$this->fileContentStatic['###LICENSE_LOCKED_DEFINED###'] = "\n\n".'defined(\''.$_VDM.'\') or die(JText::_(\'NIE_REG_NIE\'));';
		}
		else
		{
			// don't add it to the system
			$this->fileContentStatic['###HELPER_SITE_LICENSE_LOCK###'] = '';
			$this->fileContentStatic['###HELPER_LICENSE_LOCK###'] = '';
			$this->fileContentStatic['###LICENSE_LOCKED_INT###'] = '';
			$this->fileContentStatic['###LICENSE_LOCKED_DEFINED###'] = '';
		}
	}
	
	protected function setLockLicensePer($view)
	{
		if ($this->componentData->add_license && $this->componentData->license_type == 2)
		{
			$boolMethod	= 'isHonest';
			$globalbool	= ComponentbuilderHelper::safeString(ComponentbuilderHelper::randomkey(4));
			// add it to the system
			$this->fileContentDynamic[$view]['###LICENSE_LOCKED_SET_BOOL###']	= $this->setBoolLincenseLock($boolMethod,$globalbool);
			$this->fileContentDynamic[$view]['###LICENSE_LOCKED_CHECK###']		= $this->checkStatmentLicenseLocked();
		}
		else
		{
			// don't add it to the system
			$this->fileContentDynamic[$view]['###LICENSE_LOCKED_SET_BOOL###']	= '';
			$this->fileContentDynamic[$view]['###LICENSE_LOCKED_CHECK###']		= '';
		}
	}
	
	protected function checkStatmentLicenseLocked($boolMethod,$globalbool)
	{
		$statment[] = "\n\t\tif (!\$this->isHonest())";
		$statment[] = "\t\t{";
		$statment[] = "\t\t\tJError::raiseWarning(500, JText::_('NIE_REG_NIE'));";
		$statment[] = "\t\t\tJFactory::getApplication()->redirect('index.php');";
		$statment[] = "\t\t\treturn false;";
		$statment[] = "\t\t}";
		// return the genuine mentod statement
		return implode("\n", $statment);
	}
	
	protected function setBoolLincenseLock($boolMethod,$globalbool)
	{
		$bool[] = "\n\n\t/**";
		$bool[] = "\t* Check if this install has a license.";
		$bool[] = "\t**/";
		$bool[] = "\tprivate function ".$boolMethod."()";
		$bool[] = "\t{";
		$bool[] = "\t\tif(isset(\$this->".$globalbool."))";
		$bool[] = "\t\t{";
		$bool[] = "\t\t\treturn \$this->".$globalbool.";";
		$bool[] = "\t\t}";
		$bool[] = "\t\t//".$this->setLine(__LINE__)." Get the global params";
		$bool[] = "\t\t\$params = JComponentHelper::getParams('com_".$this->fileContentStatic['###component###']."', true);";
		$bool[] = "\t\t\$license_key = \$params->get('license_key', null);";
		$bool[] = "\t\tif (\$license_key)";
		$bool[] = "\t\t{";
		$bool[] = "\t\t\t//".$this->setLine(__LINE__)." load the file";
		$bool[] = "\t\t\tJLoader::import( 'vdm', JPATH_COMPONENT_ADMINISTRATOR);";
		$bool[] = "\t\t\t\$the = new VDM(\$license_key);";
		$bool[] = "\t\t\t\$this->".$globalbool." = \$the->_is;";
		$bool[] = "\t\t\treturn \$this->".$globalbool.";";
		$bool[] = "\t\t}";
		$bool[] = "\t\treturn false;";
		$bool[] = "\t}";
		// return the genuine mentod statement
		return implode("\n", $bool);
	}
	
	protected function setHelperLincenseLock($_VDM,$target)
	{
		$helper[] = "\n\n\t/**";
		$helper[] = "\t* Check if this install has a license.";
		$helper[] = "\t**/";
		$helper[] = "\tpublic static function isGenuine()";
		$helper[] = "\t{";
		$helper[] = "\t\t//".$this->setLine(__LINE__)." Get the global params";
		$helper[] = "\t\t\$params = JComponentHelper::getParams('com_".$this->fileContentStatic['###component###']."', true);";
		$helper[] = "\t\t\$license_key = \$params->get('license_key', null);";
		$helper[] = "\t\tif (\$license_key)";
		$helper[] = "\t\t{";
		$helper[] = "\t\t\t//".$this->setLine(__LINE__)." load the file";
		$helper[] = "\t\t\tJLoader::import( 'vdm', JPATH_COMPONENT_ADMINISTRATOR);";
		$helper[] = "\t\t\t\$the = new VDM(\$license_key);";
		$helper[] = "\t\t\treturn \$the->_is;";
		$helper[] = "\t\t}";
		$helper[] = "\t\treturn false;";
		$helper[] = "\t}";
		// return the genuine mentod statement
		return implode("\n", $helper);
	}
	
	protected function setInitLincenseLock($_VDM)
	{
		$init[] = "\nif (!defined('".$_VDM."'))";
		$init[] = "{";
		$init[] = "\t\$allow = ".$this->fileContentStatic['###Component###']."Helper::isGenuine();";
		$init[] = "\tif (\$allow)";
		$init[] = "\t{";
		$init[] = "\t\tdefine('".$_VDM."', 1);";
		$init[] = "\t}";
		$init[] = "}";
		// return the initializing statement
		return implode("\n", $init);
	}
	
	protected function setVDMCryption()
	{
		// make sure we have the correct file
		if (isset($this->componentData->whmcs_key) && ComponentbuilderHelper::checkString($this->componentData->whmcs_key))
		{
			// Get the basic encription.
			$basickey = ComponentbuilderHelper::getCryptKey('basic');
			// Get the encription object.
			$basic = new FOFEncryptAes($basickey, 128);
			if (!empty($this->componentData->whmcs_key) && $basickey && !is_numeric($this->componentData->whmcs_key) && $this->componentData->whmcs_key === base64_encode(base64_decode($this->componentData->whmcs_key, true)))
			{
				// basic decript data whmcs_key.
				$this->componentData->whmcs_key = rtrim($basic->decryptString($this->componentData->whmcs_key), "\0");
				// set the needed string to connect to whmcs
				$key["kasier"] = $this->componentData->whmcs_url;
				$key["geheim"] = $this->componentData->whmcs_key;
				$key["onthou"] = 1;
				// prep the call info
				$theKey = base64_encode(serialize($key));
				// set the script
				$encrypt[] = "/**";
				$encrypt[] = "* ".$this->setLine(__LINE__)."VDM Class ";
				$encrypt[] = "**/";
				$encrypt[] = "\nclass VDM";
				$encrypt[] = "{";
				$encrypt[] = "\tpublic \$_key = false;";
				$encrypt[] = "\tpublic \$_is = false;";
				$encrypt[] = "\t";
				$encrypt[] = "\tpublic function __construct(\$Vk5smi0wjnjb)";
				$encrypt[] = "\t{";
				$encrypt[] = "\t\t// get the session";
				$encrypt[] = "\t\t\$session = JFactory::getSession();";
				$encrypt[] = "\t\t\$V2uekt2wcgwk = \$session->get(\$Vk5smi0wjnjb, null);";
				$encrypt[] = "\t\t\$h4sgrGsqq = \$this->get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk);";
				$encrypt[] = "\t\tif (isset(\$h4sgrGsqq['nuut']) && \$h4sgrGsqq['nuut'] && \$h4sgrGsqq['status'] == 'Active' && isset(\$h4sgrGsqq['eiegrendel']) && strlen(\$h4sgrGsqq['eiegrendel']) > 300)";
				$encrypt[] = "\t\t{";
				$encrypt[] = "\t\t\t\$session->set(\$Vk5smi0wjnjb, \$h4sgrGsqq['eiegrendel']);";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tif (\$h4sgrGsqq['status'] == 'Active' && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 && isset(\$h4sgrGsqq['customfields']) && strlen(\$h4sgrGsqq['customfields']) > 4)";
				$encrypt[] = "\t\t{";
				$encrypt[] = "\t\t\t\$this->_key = md5(\$h4sgrGsqq['customfields']);";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tif (\$h4sgrGsqq['status'] == 'Active' && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 )";
				$encrypt[] = "\t\t{";
				$encrypt[] = "\t\t\t\$this->_is = true;";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t}";
				$encrypt[] = "\t";
				$encrypt[] = "\tprivate function get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk)";
				$encrypt[] = "\t{";
				$encrypt[] = "\t\t\$Viioj50xuqu2 = unserialize(base64_decode('".$theKey."'));";
				$encrypt[] = "\t\t\$Visqfrd1caus = time() . md5(mt_rand(1000000000, 9999999999) . \$Vk5smi0wjnjb);";
				$encrypt[] = "\t\t\$Vo4tezfgcf3e = date(\"Ymd\");";
				$encrypt[] = "\t\t\$Vozblwvfym2f = \$_SERVER['SERVER_NAME'];";
				$encrypt[] = "\t\t\$Vozblwvfym2fdie = isset(\$_SERVER['SERVER_ADDR']) ? \$_SERVER['SERVER_ADDR'] : \$_SERVER['LOCAL_ADDR'];";
				$encrypt[] = "\t\t\$V343jp03dxco = dirname(__FILE__);";
				$encrypt[] = "\t\t\$Vc2rayehw4f0 = unserialize(base64_decode('czozNjoibW9kdWxlcy9zZXJ2ZXJzL2xpY2Vuc2luZy92ZXJpZnkucGhwIjs='));";
				$encrypt[] = "\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\tif (\$V2uekt2wcgwk) {";
				$encrypt[] = "\t\t\t\$V2uekt2wcgwk = str_replace(\"".'\n'."\", '', \$V2uekt2wcgwk);";
				$encrypt[] = "\t\t\t\$Vm5cxjdc43g4 = substr(\$V2uekt2wcgwk, 0, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = "\t\t\t\$Vbgx0efeu2sy = substr(\$V2uekt2wcgwk, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = "\t\t\tif (\$Vbgx0efeu2sy == md5(\$Vm5cxjdc43g4 . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4 = strrev(\$Vm5cxjdc43g4);";
				$encrypt[] = "\t\t\t\t\$Vbgx0efeu2sy = substr(\$Vm5cxjdc43g4, 0, 32);";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4 = substr(\$Vm5cxjdc43g4, 32);";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4 = base64_decode(\$Vm5cxjdc43g4);";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4finding = unserialize(\$Vm5cxjdc43g4);";
				$encrypt[] = "\t\t\t\t\$V3qqz0p00fbq  = \$Vm5cxjdc43g4finding['dan'];";
				$encrypt[] = "\t\t\t\tif (\$Vbgx0efeu2sy == md5(\$V3qqz0p00fbq  . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = "\t\t\t\t\t\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = "\t\t\t\t\tif (\$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = "\t\t\t\t\t\t\$Vlpolphukogz = true;";
				$encrypt[] = "\t\t\t\t\t\t\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = "\t\t\t\t\t\t\$Vcixw3trerrt = explode(',', \$Vwasqoybpyed['validdomain']);";
				$encrypt[] = "\t\t\t\t\t\tif (!in_array(\$_SERVER['SERVER_NAME'], \$Vcixw3trerrt)) {";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t\t\$Vkni3xyhkqzv = explode(',', \$Vwasqoybpyed['validip']);";
				$encrypt[] = "\t\t\t\t\t\tif (!in_array(\$Vozblwvfym2fdie, \$Vkni3xyhkqzv)) {";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t\t\$Vckfvnepoaxj = explode(',', \$Vwasqoybpyed['validdirectory']);";
				$encrypt[] = "\t\t\t\t\t\tif (!in_array(\$V343jp03dxco, \$Vckfvnepoaxj)) {";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tif (!\$Vlpolphukogz) {";
				$encrypt[] = "\t\t\t\$V1u0c4dl3ehp = array(";
				$encrypt[] = "\t\t\t\t'licensekey' => \$Vk5smi0wjnjb,";
				$encrypt[] = "\t\t\t\t'domain' => \$Vozblwvfym2f,";
				$encrypt[] = "\t\t\t\t'ip' => \$Vozblwvfym2fdie,";
				$encrypt[] = "\t\t\t\t'dir' => \$V343jp03dxco,";
				$encrypt[] = "\t\t\t);";
				$encrypt[] = "\t\t\tif (\$Visqfrd1caus) \$V1u0c4dl3ehp['check_token'] = \$Visqfrd1caus;";
				$encrypt[] = "\t\t\t\$Vdsjeyjmpq2o = '';";
				$encrypt[] = "\t\t\tforeach (\$V1u0c4dl3ehp AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = "\t\t\t\t\$Vdsjeyjmpq2o .= \$V2sgyscukmgi.'='.urlencode(\$V1u00zkzmb1d).'&';";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (function_exists('curl_exec')) {";
				$encrypt[] = "\t\t\t\t\$Vdathuqgjyf0 = curl_init();";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_URL, \$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_POST, 1);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_POSTFIELDS, \$Vdsjeyjmpq2o);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_TIMEOUT, 30);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_RETURNTRANSFER, 1);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5 = curl_exec(\$Vdathuqgjyf0);";
				$encrypt[] = "\t\t\t\tcurl_close(\$Vdathuqgjyf0);";
				$encrypt[] = "\t\t\t} else {";
				$encrypt[] = "\t\t\t\t\$Vrpmu4bvnmkp = fsockopen(\$Viioj50xuqu2['kasier'], 80, \$Vc0t5kmpwkwk, \$Va3g41fnofhu, 5);";
				$encrypt[] = "\t\t\t\tif (\$Vrpmu4bvnmkp) {";
				$encrypt[] = "\t\t\t\t\t\$Vznkm0a0me1y = \"\r\n\";";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop = \"POST \".\$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0 . \" HTTP/1.0\" . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Host: \".\$Viioj50xuqu2['kasier'] . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Content-type: application/x-www-form-urlencoded\" . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Content-length: \".@strlen(\$Vdsjeyjmpq2o) . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Connection: close\" . \$Vznkm0a0me1y . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \$Vdsjeyjmpq2o;";
				$encrypt[] = "\t\t\t\t\t\$Vqojefyeohg5 = '';";
				$encrypt[] = "\t\t\t\t\t@stream_set_timeout(\$Vrpmu4bvnmkp, 20);";
				$encrypt[] = "\t\t\t\t\t@fputs(\$Vrpmu4bvnmkp, \$V2sgyscukmgiop);";
				$encrypt[] = "\t\t\t\t\t\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = "\t\t\t\t\twhile (!@feof(\$Vrpmu4bvnmkp)&&\$V2czq24pjexf) {";
				$encrypt[] = "\t\t\t\t\t\t\$Vqojefyeohg5 .= @fgets(\$Vrpmu4bvnmkp, 1024);";
				$encrypt[] = "\t\t\t\t\t\t\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = "\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t@fclose (\$Vqojefyeohg5);";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (!\$Vqojefyeohg5) {";
				$encrypt[] = "\t\t\t\t\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = "\t\t\t\tif (isset(\$V3qqz0p00fbq) && \$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = "\t\t\t\t} else {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['description'] = \"Remote Check Failed\";";
				$encrypt[] = "\t\t\t\t\treturn \$Vwasqoybpyed;";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t} else {";
				$encrypt[] = "\t\t\t\tpreg_match_all('/<(.*?)>([^<]+)<\/\1>/i', \$Vqojefyeohg5, \$V1ot20wob03f);";
				$encrypt[] = "\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\tforeach (\$V1ot20wob03f[1] AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed[\$V1u00zkzmb1d] = \$V1ot20wob03f[2][\$V2sgyscukmgi];";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (!is_array(\$Vwasqoybpyed)) {";
				$encrypt[] = "\t\t\t\tdie(\"Invalid License Server Response\");";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (isset(\$Vwasqoybpyed['md5hash']) && \$Vwasqoybpyed['md5hash']) {";
				$encrypt[] = "\t\t\t\tif (\$Vwasqoybpyed['md5hash'] != md5(\$Viioj50xuqu2['geheim'] . \$Visqfrd1caus)) {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['description'] = \"MD5 Checksum Verification Failed\";";
				$encrypt[] = "\t\t\t\t\treturn \$Vwasqoybpyed;";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (isset(\$Vwasqoybpyed['status']) && \$Vwasqoybpyed['status'] == \"Active\") {";
				$encrypt[] = "\t\t\t\t\$Vwasqoybpyed['dan'] = \$Vo4tezfgcf3e;";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = serialize(\$Vwasqoybpyed);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = base64_encode(\$Vqojefyeohg5ing);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = md5(\$Vo4tezfgcf3e . \$Viioj50xuqu2['geheim']) . \$Vqojefyeohg5ing;";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = strrev(\$Vqojefyeohg5ing);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = \$Vqojefyeohg5ing . md5(\$Vqojefyeohg5ing . \$Viioj50xuqu2['geheim']);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = wordwrap(\$Vqojefyeohg5ing, 80, \"".'\n'."\", true);";
				$encrypt[] = "\t\t\t\t\$Vwasqoybpyed['eiegrendel'] = \$Vqojefyeohg5ing;";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\t\$Vwasqoybpyed['nuut'] = true;";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tunset(\$V1u0c4dl3ehp,\$Vqojefyeohg5,\$V1ot20wob03f,\$Viioj50xuqu2['kasier'],\$Viioj50xuqu2['geheim'],\$Vo4tezfgcf3e,\$Vozblwvfym2fdie,\$Viioj50xuqu2['onthou'],\$Vbgx0efeu2sy);";
				$encrypt[] = "\t\treturn \$Vwasqoybpyed;";
				$encrypt[] = "\t}";
				$encrypt[] = "}";

				// return the help methods
				return implode("\n",$encrypt);
			}
		}
		return '';
	}

	protected function setGetCryptKey()
	{
		// ###ENCRYPT_FILE###
		$this->fileContentStatic['###ENCRYPT_FILE###'] = '';
		if ((isset($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder)) || (isset($this->advancedEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder)) || $this->componentData->add_license)
		{
			if (isset($this->advancedEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder) || $this->componentData->add_license)
			{
				// set advanced encrypt file into place
				$target = array('admin' => 'encrypt');
				$done = $this->buildDynamique($target,'encrypt');
				// the text for the file ###VDM_ENCRYPTION_BODY###
				$this->fileContentDynamic['encrypt']['###VDM_ENCRYPTION_BODY###'] = $this->setVDMCryption();
				// ###ENCRYPT_FILE###
				$this->fileContentStatic['###ENCRYPT_FILE###'] = "\n\t\t\t<filename>vdm.php</filename>";
			}
			// get component name
			$component	= $this->fileContentStatic['###component###'];
			// set the getCryptKey function to the helper class
			$function = array();
			if (isset($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder))
			{
				$function[] = "\n\n\tpublic static function getCryptKey(\$type)";
				$function[] = "\t{";
				$function[] = "\t\t//".$this->setLine(__LINE__)." Get the global params";
				$function[] = "\t\t\$params = JComponentHelper::getParams('com_".$component."', true);";
				$function[] = "\t\tif ('advanced' == \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t\$advanced_key = \$params->get('advanced_key', null);";
				$function[] = "\t\t\tif (\$advanced_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." load the file";
				$function[] = "\t\t\t\tJLoader::import( 'vdm', JPATH_COMPONENT_ADMINISTRATOR);";
				$function[] = "\n\t\t\t\t\$the = new VDM(\$advanced_key);";
				$function[] = "\n\t\t\t\treturn \$the->_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\telseif ('basic' == \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t\$basic_key = \$params->get('basic_key', null);";
				$function[] = "\t\t\tif (\$basic_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\treturn \$basic_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\treturn false;";
				$function[] = "\t}";
			}
			elseif (isset($this->advancedEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder))
			{
				$function[] = "\n\n\tpublic static function getCryptKey(\$type)";
				$function[] = "\t{";
				$function[] = "\t\tif ('advanced' == \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t//".$this->setLine(__LINE__)." Get the global params";
				$function[] = "\t\t\t\$params = JComponentHelper::getParams('com_".$component."', true);";
				$function[] = "\t\t\t\$advanced_key = \$params->get('advanced_key', null);";
				$function[] = "\t\t\tif (\$advanced_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." load the file";
				$function[] = "\t\t\t\tJLoader::import( 'vdm', JPATH_COMPONENT_ADMINISTRATOR);";
				$function[] = "\n\t\t\t\t\$the = new VDM(\$advanced_key);";
				$function[] = "\n\t\t\t\treturn \$the->_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\treturn false;";
				$function[] = "\t}";
			}
			elseif (isset($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder))
			{
				$function[] = "\n\n\tpublic static function getCryptKey(\$type)";
				$function[] = "\t{";
				$function[] = "\t\tif ('basic' == \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t//".$this->setLine(__LINE__)." Get the global params";
				$function[] = "\t\t\t\$params = JComponentHelper::getParams('com_".$component."', true);";
				$function[] = "\t\t\t\$basic_key = \$params->get('basic_key', null);";
				$function[] = "\t\t\tif (\$basic_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\treturn \$basic_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\treturn false;";
				$function[] = "\t}";
			}
			// return the help methods
			return implode("\n",$function);
		}
		return '';
	}
	
	protected function setVersionController()
	{
		$updateServer = '';
		if (ComponentbuilderHelper::checkArray($this->componentData->version_update))
		{
			$updateXML = array();
			// add the update server
			if ($this->componentData->add_update_server)
			{
				$updateXML[] = '<updates>';
			}
			// add the update sql
			$addSQL = true;
			foreach ($this->componentData->version_update as $update)
			{
				// ensure version naming is correct
				$update['version'] = preg_replace('/[^0-9.]+/', '', $update['version']);
				// check if the sql should be added
				if ($update['version'] == $this->componentData->component_version)
				{
					$addSQL = false;
				}
				// setup import files
				if ($addSQL)
				{
					$name = ComponentbuilderHelper::safeString($update['version']);
					$target = array('admin' => $name);
					$this->buildDynamique($target,'sql_update',$update['version']);
					$this->fileContentDynamic[$name.'_'.$update['version']]['###UPDATE_VERSION_MYSQL###'] = $update['mysql'];
				}
				// add the update server
				if ($this->componentData->add_update_server)
				{
					// build update xml
					$updateXML[] = "\t<update>";
					$updateXML[] = "\t\t<name>".$this->fileContentStatic['###Component_name###']."</name>";
					$updateXML[] = "\t\t<description>".$this->fileContentStatic['###SHORT_DESCRIPTION###']."</description>";
					$updateXML[] = "\t\t<element>com_".$this->fileContentStatic['###component###']."</element>";
					$updateXML[] = "\t\t<type>component</type>";
					$updateXML[] = "\t\t<version>".$update['version']."</version>";
					$updateXML[] = "\t\t".'<infourl title="'.$this->fileContentStatic['###Component_name###'].'!">'.$this->fileContentStatic['###AUTHORWEBSITE###'].'</infourl>';
					$updateXML[] = "\t\t<downloads>";
					$updateXML[] = "\t\t\t".'<downloadurl type="full" format="zip">'.$update['url'].'</downloadurl>';
					$updateXML[] = "\t\t</downloads>";
					$updateXML[] = "\t\t<tags>";
					$updateXML[] = "\t\t\t<tag>stable</tag>";
					$updateXML[] = "\t\t</tags>";
					$updateXML[] = "\t\t<maintainer>".$this->fileContentStatic['###AUTHOR###']."</maintainer>";
					$updateXML[] = "\t\t<maintainerurl>".$this->fileContentStatic['###AUTHORWEBSITE###']."</maintainerurl>";
					$updateXML[] = "\t\t".'<targetplatform name="joomla" version="3.*"/>';
					$updateXML[] = "\t</update>";
				}
			}
			// add the update server 
			if ($this->componentData->add_update_server)
			{
				$updateXML[] = '</updates>';
				// ###UPDATE_SERVER_XML###
				$name = str_replace('.xml', '', substr($this->componentData->update_server, strrpos($this->componentData->update_server, '/') + 1));
				$target = array('admin' => $name);
				$this->buildDynamique($target,'update_server');
				$this->fileContentDynamic[$name]['###UPDATE_SERVER_XML###'] = implode("\n", $updateXML);
				
				// set the Update server file name
				$this->updateServerFileName = $name;

				// ###UPDATESERVER###
				$updateServer = array();
				$updateServer[] = "\n\t<updateservers>";
				$updateServer[] = "\t\t".'<server type="extension" enabled="1" element="com_'.$this->fileContentStatic['###component###'].'" name="'.$this->fileContentStatic['###Component_name###'].'">'.$this->componentData->update_server.'</server>';
				$updateServer[] = "\t</updateservers>";
				// return the array to string
				$updateServer = implode("\n", $updateServer);
			}
		}
		// add update server details to component XML file
		$this->fileContentStatic['###UPDATESERVER###'] = $updateServer;
	}

	protected function noHelp()
	{
		$help = array();
		$help[] = "\n\n\t/**";
		$help[] = "\t*	Can be used to build help urls.";
		$help[] = "\t**/";
		$help[] = "\tpublic static function getHelpUrl(\$view)";
		$help[] = "\t{";
		$help[] = "\t\treturn false;";
		$help[] = "\t}";
		// return the no help method
		return implode("\n",$help);
	}

	protected function checkHelp($viewName_single)
	{
		if ($viewName_single == "help_document")
		{
			// set help file into admin place
			$target = array('admin' => 'help');
			$admindone = $this->buildDynamique($target,'help');
			// set the help file into site place
			$target = array('site' => 'help');
			$sitedone = $this->buildDynamique($target,'help');
			if ($admindone && $sitedone)
			{
				// ###HELP###
				$this->fileContentStatic['###HELP###'] = $this->setHelp(1);
				// ###HELP_SITE###
				$this->fileContentStatic['###HELP_SITE###'] = $this->setHelp(2);
				// to make sure the file is updated TODO
				$this->fileContentDynamic['help']['###BLABLA###'] = 'blabla';
				return true;
			}
		}
		return false;
	}

	protected function setHelp($location)
	{
		// set hte help function to the helper class
		$target = 'admin_view';
		if ($location == 2)
		{
			$target = 'site_view';
		}
		$help = array();
		$help[] = "\n\n\t/**";
		$help[] = "\t*	Load the Component Help URLs.";
		$help[] = "\t**/";
		$help[] = "\tpublic static function getHelpUrl(\$view)";
		$help[] = "\t{";
		$help[] = "\t\t\$user	= JFactory::getUser();";
		$help[] = "\t\t\$groups = \$user->get('groups');";
		$help[] = "\t\t\$db	= JFactory::getDbo();";
		$help[] = "\t\t\$query	= \$db->getQuery(true);";
		$help[] = "\t\t\$query->select(array('a.id','a.groups','a.target','a.type','a.article','a.url'));";
		$help[] = "\t\t\$query->from('#__".$this->fileContentStatic['###component###']."_help_document AS a');";
		$help[] = "\t\t\$query->where('a.".$target." = '.\$db->quote(\$view));";
		$help[] = "\t\t\$query->where('a.location = ".(int) $location."');";
		$help[] = "\t\t\$query->where('a.published = 1');";
		$help[] = "\t\t\$db->setQuery(\$query);";
		$help[] = "\t\t\$db->execute();";
		$help[] = "\t\tif(\$db->getNumRows())";
		$help[] = "\t\t{";
		$help[] = "\t\t\t\$helps = \$db->loadObjectList();";
		$help[] = "\t\t\tif (self::checkArray(\$helps))";
		$help[] = "\t\t\t{";
		$help[] = "\t\t\t\tforeach (\$helps as \$nr => \$help)";
		$help[] = "\t\t\t\t{";
		$help[] = "\t\t\t\t\tif (\$help->target == 1)";
		$help[] = "\t\t\t\t\t{";
		$help[] = "\t\t\t\t\t\t\$targetgroups = json_decode(\$help->groups, true);";
		$help[] = "\t\t\t\t\t\tif (!array_intersect(\$targetgroups, \$groups))";
		$help[] = "\t\t\t\t\t\t{";
		$help[] = "\t\t\t\t\t\t\t//".$this->setLine(__LINE__)." if user not in those target groups then remove the item";
		$help[] = "\t\t\t\t\t\t\tunset(\$helps[\$nr]);";
		$help[] = "\t\t\t\t\t\t\tcontinue;";
		$help[] = "\t\t\t\t\t\t}";
		$help[] = "\t\t\t\t\t}";
		$help[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." set the return type";
		$help[] = "\t\t\t\t\tswitch (\$help->type)";
		$help[] = "\t\t\t\t\t{";
		$help[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." set joomla article";
		$help[] = "\t\t\t\t\t\tcase 1:";
		$help[] = "\t\t\t\t\t\t\treturn self::loadArticleLink(\$help->article);";
		$help[] = "\t\t\t\t\t\tbreak;";
		$help[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." set help text";
		$help[] = "\t\t\t\t\t\tcase 2:";
		$help[] = "\t\t\t\t\t\t\treturn self::loadHelpTextLink(\$help->id);";
		$help[] = "\t\t\t\t\t\tbreak;";
		$help[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." set Link";
		$help[] = "\t\t\t\t\t\tcase 3:";
		$help[] = "\t\t\t\t\t\t\treturn \$help->url;";
		$help[] = "\t\t\t\t\t\tbreak;";
		$help[] = "\t\t\t\t\t}";
		$help[] = "\t\t\t\t}";
		$help[] = "\t\t\t}";
		$help[] = "\t\t}";
		$help[] = "\t\treturn false;";
		$help[] = "\t}";
		$help[] = "\n\t/**";
		$help[] = "\t*	Get the Article Link.";
		$help[] = "\t**/";
		$help[] = "\tprotected static function loadArticleLink(\$id)";
		$help[] = "\t{";
		$help[] = "\t\treturn JURI::root().'index.php?option=com_content&view=article&id='.\$id.'&tmpl=component&layout=modal';";
		$help[] = "\t}";
		$help[] = "\n\t/**";
		$help[] = "\t*	Get the Help Text Link.";
		$help[] = "\t**/";
		$help[] = "\tprotected static function loadHelpTextLink(\$id)";
		$help[] = "\t{";
		$help[] = "\t\t\$token = JSession::getFormToken();";
		$help[] = "\t\treturn 'index.php?option=com_".$this->fileContentStatic['###component###']."&task=help.getText&id=' . (int) \$id . '&token=' . \$token;";
		$help[] = "\t}";
		// return the help methods
		return implode("\n",$help);
	}

	protected function setExelHelperMethods()
	{
		if ($this->addEximport)
		{
			$exel = array();
			$exel[] = "\n\n\t/**";
			$exel[] = "\t * Prepares the xml document";
			$exel[] = "\t */";
			$exel[] = "\tpublic static function xls(\$rows,\$fileName = null,\$title = null,\$subjectTab = null,\$creator = '".$this->fileContentStatic['###COMPANYNAME###']."',\$description = null,\$category = null,\$keywords = null,\$modified = null)";
			$exel[] = "\t{";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set the user";
			$exel[] = "\t\t\$user = JFactory::getUser();";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set fieldname if not set";
			$exel[] = "\t\tif (!\$fileName)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$fileName = 'exported_'.JFactory::getDate()->format('jS_F_Y');";
			$exel[] = "\t\t}";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set modiefied if not set";
			$exel[] = "\t\tif (!\$modified)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$modified = \$user->name;";
			$exel[] = "\t\t}";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set title if not set";
			$exel[] = "\t\tif (!\$title)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$title = 'Book1';";
			$exel[] = "\t\t}";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set tab name if not set";
			$exel[] = "\t\tif (!\$subjectTab)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$subjectTab = 'Sheet1';";
			$exel[] = "\t\t}";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." make sure the file is loaded\t\t";
			$exel[] = "\t\tJLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Create new PHPExcel object";
			$exel[] = "\t\t\$objPHPExcel = new PHPExcel();";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Set document properties";
			$exel[] = "\t\t\$objPHPExcel->getProperties()->setCreator(\$creator)";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setCompany('".$this->fileContentStatic['###COMPANYNAME###']."')";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setLastModifiedBy(\$modified)";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setTitle(\$title)";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setSubject(\$subjectTab);";
			$exel[] = "\t\tif (!\$description)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$objPHPExcel->getProperties()->setDescription(\$description);";
			$exel[] = "\t\t}";
			$exel[] = "\t\tif (!\$keywords)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$objPHPExcel->getProperties()->setKeywords(\$keywords);";
			$exel[] = "\t\t}";
			$exel[] = "\t\tif (!\$category)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$objPHPExcel->getProperties()->setCategory(\$category);";
			$exel[] = "\t\t}";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Some styles";
			$exel[] = "\t\t\$headerStyles = array(";
			$exel[] = "\t\t\t'font'  => array(";
			$exel[] = "\t\t\t\t'bold'  => true,";
			$exel[] = "\t\t\t\t'color' => array('rgb' => '1171A3'),";
			$exel[] = "\t\t\t\t'size'  => 12,";
			$exel[] = "\t\t\t\t'name'  => 'Verdana'";
			$exel[] = "\t\t));";
			$exel[] = "\t\t\$sideStyles = array(";
			$exel[] = "\t\t\t'font'  => array(";
			$exel[] = "\t\t\t\t'bold'  => true,";
			$exel[] = "\t\t\t\t'color' => array('rgb' => '444444'),";
			$exel[] = "\t\t\t\t'size'  => 11,";
			$exel[] = "\t\t\t\t'name'  => 'Verdana'";
			$exel[] = "\t\t));";
			$exel[] = "\t\t\$normalStyles = array(";
			$exel[] = "\t\t\t'font'  => array(";
			$exel[] = "\t\t\t\t'color' => array('rgb' => '444444'),";
			$exel[] = "\t\t\t\t'size'  => 11,";
			$exel[] = "\t\t\t\t'name'  => 'Verdana'";
			$exel[] = "\t\t));";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Add some data";
			$exel[] = "\t\tif (self::checkArray(\$rows))";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$i = 1;";
			$exel[] = "\t\t\tforeach (\$rows as \$array){";
			$exel[] = "\t\t\t\t\$a = 'A';";
			$exel[] = "\t\t\t\tforeach (\$array as \$value){";
			$exel[] = "\t\t\t\t\t\$objPHPExcel->setActiveSheetIndex(0)->setCellValue(\$a.\$i, \$value);";
			$exel[] = "\t\t\t\t\tif (\$i == 1){";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getColumnDimension(\$a)->setAutoSize(true);";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$headerStyles);";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);";
			$exel[] = "\t\t\t\t\t} elseif (\$a == 'A'){";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$sideStyles);";
			$exel[] = "\t\t\t\t\t} else {";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$normalStyles);";
			$exel[] = "\t\t\t\t\t}";
			$exel[] = "\t\t\t\t\t\$a++;";
			$exel[] = "\t\t\t\t}";
			$exel[] = "\t\t\t\t\$i++;";
			$exel[] = "\t\t\t}";
			$exel[] = "\t\t}";
			$exel[] = "\t\telse";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\treturn false;";
			$exel[] = "\t\t}";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Rename worksheet";
			$exel[] = "\t\t\$objPHPExcel->getActiveSheet()->setTitle(\$subjectTab);";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Set active sheet index to the first sheet, so Excel opens this as the first sheet";
			$exel[] = "\t\t\$objPHPExcel->setActiveSheetIndex(0);";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Redirect output to a client's web browser (Excel5)";
			$exel[] = "\t\theader('Content-Type: application/vnd.ms-excel');";
			$exel[] = "\t\theader('Content-Disposition: attachment;filename=\"'.\$fileName.'.xls\"');";
			$exel[] = "\t\theader('Cache-Control: max-age=0');";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." If you're serving to IE 9, then the following may be needed";
			$exel[] = "\t\theader('Cache-Control: max-age=1');";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." If you're serving to IE over SSL, then the following may be needed";
			$exel[] = "\t\theader ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past";
			$exel[] = "\t\theader ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified";
			$exel[] = "\t\theader ('Cache-Control: cache, must-revalidate'); // HTTP/1.1";
			$exel[] = "\t\theader ('Pragma: public'); // HTTP/1.0";
			$exel[] = "\t\t";
			$exel[] = "\t\t\$objWriter = PHPExcel_IOFactory::createWriter(\$objPHPExcel, 'Excel5');";
			$exel[] = "\t\t\$objWriter->save('php://output');";
			$exel[] = "\t\tjexit();";
			$exel[] = "\t}";
			$exel[] = "\t";
			$exel[] = "\t/**";
			$exel[] = "\t* Get CSV Headers";
			$exel[] = "\t*/";
			$exel[] = "\tpublic static function getFileHeaders(\$dataType)";
			$exel[] = "\t{\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." make sure the file is loaded\t\t";
			$exel[] = "\t\tJLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." get session object";
			$exel[] = "\t\t\$session \t= JFactory::getSession();";
			$exel[] = "\t\t\$package\t= \$session->get('package', null);";
			$exel[] = "\t\t\$package\t= json_decode(\$package, true);";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set the headers";
			$exel[] = "\t\tif(isset(\$package['dir']))";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$inputFileType = PHPExcel_IOFactory::identify(\$package['dir']);";
			$exel[] = "\t\t\t\$excelReader = PHPExcel_IOFactory::createReader(\$inputFileType);";
			$exel[] = "\t\t\t\$excelReader->setReadDataOnly(true);";
			$exel[] = "\t\t\t\$excelObj = \$excelReader->load(\$package['dir']);";
			$exel[] = "\t\t\t\$headers = array();";
			$exel[] = "\t\t\tforeach (\$excelObj->getActiveSheet()->getRowIterator() as \$row)";
			$exel[] = "\t\t\t{";
			$exel[] = "\t\t\t\tif(\$row->getRowIndex() == 1)";
			$exel[] = "\t\t\t\t{";
			$exel[] = "\t\t\t\t\t\$cellIterator = \$row->getCellIterator();";
			$exel[] = "\t\t\t\t\t\$cellIterator->setIterateOnlyExistingCells(false);";
			$exel[] = "\t\t\t\t\tforeach (\$cellIterator as \$cell)";
			$exel[] = "\t\t\t\t\t{";
			$exel[] = "\t\t\t\t\t\tif (!is_null(\$cell))";
			$exel[] = "\t\t\t\t\t\t{";
			$exel[] = "\t\t\t\t\t\t\t\$headers[\$cell->getColumn()] = \$cell->getValue();";
			$exel[] = "\t\t\t\t\t\t}";
			$exel[] = "\t\t\t\t\t}";
			$exel[] = "\t\t\t\t\t\$excelObj->disconnectWorksheets();";
			$exel[] = "\t\t\t\t\tunset(\$excelObj);";
			$exel[] = "\t\t\t\t\tbreak;";
			$exel[] = "\t\t\t\t}";
			$exel[] = "\t\t\t}";
			$exel[] = "\t\t\treturn \$headers;";
			$exel[] = "\t\t}";
			$exel[] = "\t\treturn false;";
			$exel[] = "\t}";
			// return the help methods
			return implode("\n",$exel);
		}
		return '';
	}

	protected function setCreateUserHelperMethod($add)
	{
		if ($add)
		{
			$method = array();
			$method[] = "\n\n\t/**";
			$method[] = "\t* Greate user and update given table";
			$method[] = "\t*/";
			$method[] = "\tpublic static function createUser(\$new)";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." load the user component language files if there is an error.";
			$method[] = "\t\t\$lang = JFactory::getLanguage();";
			$method[] = "\t\t\$extension = 'com_users';";
			$method[] = "\t\t\$base_dir = JPATH_SITE;";
			$method[] = "\t\t\$language_tag = 'en-GB';";
			$method[] = "\t\t\$reload = true;";
			$method[] = "\t\t\$lang->load(\$extension, \$base_dir, \$language_tag, \$reload);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." load the user regestration model";
			$method[] = "\t\t\$model = self::getModel('registration', JPATH_ROOT. '/components/com_users', 'Users');";
			$method[] = "\t\t//".$this->setLine(__LINE__)." make sure no activation is needed";
			$method[] = "\t\t\$useractivation = self::setParams('com_users','useractivation',0);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." make sure password is send";
			$method[] = "\t\t\$sendpassword = self::setParams('com_users','sendpassword',1);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Check if password was set";
			$method[] = "\t\tif (isset(\$new['password']) && isset(\$new['password2']) && self::checkString(\$new['password']) && self::checkString(\$new['password2']))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Use the users passwords";
			$method[] = "\t\t\t\$password = \$new['password'];";
			$method[] = "\t\t\t\$password2 = \$new['password2'];";
			$method[] = "\t\t}";
			$method[] = "\t\telse";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Set random password";
			$method[] = "\t\t\t\$password = self::randomkey(8);";
			$method[] = "\t\t\t\$password2 = \$password;";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." set username";
			$method[] = "\t\tif (isset(\$new['username']) && self::checkString(\$new['username']))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t\$new['username'] = self::safeString(\$new['username']);";
			$method[] = "\t\t}";
			$method[] = "\t\telse";
			$method[] = "\t\t{";
			$method[] = "\t\t\t\$new['username'] = self::safeString(\$new['name']);\t\t\t";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." linup new user data";
			$method[] = "\t\t\$data = array(";
			$method[] = "\t\t\t'username' => \$new['username'],";
			$method[] = "\t\t\t'name' => \$new['name'],";
			$method[] = "\t\t\t'email1' => \$new['email'],";
			$method[] = "\t\t\t'password1' => \$password, // First password field";
			$method[] = "\t\t\t'password2' => \$password2, // Confirm password field";
			$method[] = "\t\t\t'block' => 0 );";
			$method[] = "\t\t//".$this->setLine(__LINE__)." register the new user";
			$method[] = "\t\t\$userId = \$model->register(\$data);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." set activation back to default";
			$method[] = "\t\tself::setParams('com_users','useractivation',\$useractivation);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." set send password back to default";
			$method[] = "\t\tself::setParams('com_users','sendpassword',\$sendpassword);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." if user is created";
			$method[] = "\t\tif (\$userId > 0)";
			$method[] = "\t\t{";
			$method[] = "\t\t\treturn \$userId;";
			$method[] = "\t\t}";
			$method[] = "\t\treturn \$model->getError();";
			$method[] = "\t}";

			$method[] = "\n\tprotected static function setParams(\$component,\$target,\$value)";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Get the params and set the new values";
			$method[] = "\t\t\$params = JComponentHelper::getParams(\$component);";
			$method[] = "\t\t\$was = \$params->get(\$target, null);";
			$method[] = "\t\tif (\$was != \$value)";
			$method[] = "\t\t{";
			$method[] = "\t\t\t\$params->set(\$target, \$value);";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get a new database query instance";
			$method[] = "\t\t\t\$db = JFactory::getDBO();";
			$method[] = "\t\t\t\$query = \$db->getQuery(true);";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Build the query";
			$method[] = "\t\t\t\$query->update('#__extensions AS a');";
			$method[] = "\t\t\t\$query->set('a.params = ' . \$db->quote((string)\$params));";
			$method[] = "\t\t\t\$query->where('a.element = ' . \$db->quote((string)\$component));";
			$method[] = "\t\t\t";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Execute the query";
			$method[] = "\t\t\t\$db->setQuery(\$query);";
			$method[] = "\t\t\t\$db->query();";
			$method[] = "\t\t}";
			$method[] = "\t\treturn \$was;";
			$method[] = "\t}";

			// return the help method
			return implode("\n",$method);
		}
		return '';
	}

	protected function setCustomViewMenu($view)
	{
		$xml = '';
		// build the file
		$target = array('site' => $view['settings']->code);
		$done = $this->buildDynamique($target,'menu');
		if ($done)
		{
			// set the lang
			$lang = ComponentbuilderHelper::safeString('com_'.$this->fileContentStatic['###component###'].'_menu_'.$view['settings']->code, 'U');
			$this->langContent['adminsys'][$lang.'_TITLE'] = $view['settings']->name;
			$this->langContent['adminsys'][$lang.'_OPTION'] = $view['settings']->name;
			$this->langContent['adminsys'][$lang.'_DESC'] = $view['settings']->description;
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= "\n".'<metadata>';
			$xml .= "\n\t".'<layout title="'.$lang.'_TITLE" option="'.$lang.'_OPTION">';
			$xml .= "\n\t\t".'<message>';
			$xml .= "\n\t\t\t".'<![CDATA['.$lang.'_DESC]]>';
			$xml .= "\n\t\t".'</message>';
			$xml .= "\n\t".'</layout>';
			if (isset($this->hasIdRequest[$view['settings']->code]))
			{
				$requestField = str_replace($view['settings']->code.'_request_id', 'id', $this->hasIdRequest[$view['settings']->code]);
				
				$xml .= "\n\t".'<!--'.$this->setLine(__LINE__).' Add fields to the request variables for the layout. -->';
				$xml .= "\n\t".'<fields name="request">';
				$xml .= "\n\t\t".'<fieldset name="request"';
				$xml .= "\n\t\t\t".'addfieldpath="/administrator/components/com_'.$this->fileContentStatic['###component###'].'/models/fields">';
				$xml .= "\n\t\t\t".$requestField;
				$xml .= "\n\t\t".'</fieldset>';
				$xml .= "\n\t".'</fields>';
			}
			if (isset($this->frontEndParams) && isset($this->frontEndParams[$view['settings']->name]))
			{
				// first we must setup the fields for the page use
				$params = $this->setupFrontendParamFields($this->frontEndParams[$view['settings']->name],$view['settings']->code);
				// now load the fields
				if (ComponentbuilderHelper::checkArray($params))
				{
					$xml .= "\n\t".'<!--'.$this->setLine(__LINE__).' Adding page parameters -->';
					$xml .= "\n\t".'<fields name="params">';
					$xml .= "\n\t\t".'<fieldset name="basic" label="COM_'.$this->fileContentStatic['###COMPONENT###'].'">';
					$xml .= implode("\t\t\t",$params);
					$xml .= "\n\t\t".'</fieldset>';
					$xml .= "\n\t".'</fields>';
				}
			}
			$xml .= "\n".'</metadata>';
		}
		return $xml;
	}
	
	protected function setupFrontendParamFields($params,$view)
	{
		$keep = array();
		$menuSetter = $view.'_menu';
		foreach ($params as $field)
		{
			// we load fields that have options
			if (strpos($field,'Option Set. -->') !== false && strpos($field,$menuSetter) === false)
			{
				// we add the global option
				$field = str_replace('Option Set. -->', $this->setLine(__LINE__).' Global & Option Set. -->'."\n\t\t\t".'<option value="">'."\n\t\t\t\t".'JGLOBAL_USE_GLOBAL</option>', $field);
				// update the default to be global
				$field = preg_replace('/default=".+"/', 'default=""', $field);
				// update the default to be filter
				$field = preg_replace('/filter=".+"/', 'filter="string"', $field);
				// update required
				$field = str_replace('required="true"', 'required="false"', $field);
				// add to keeper array
				$keep[] = $field;
			}
			else
			{
				// TODO add convetion to filter fields that we should not load
				$keep[] = $field;
			}
		}
		return $keep;
	}

	protected function setCustomViewQuery(&$gets,&$code,$tab = '',$type = 'main')
	{
		$query = '';
		if (ComponentbuilderHelper::checkArray($gets))
		{
			$mainAsArray = array();
			$check = 'zzz';
			foreach ($gets as $nr => $the_get)
			{
				// to insure that there be no double entries of a call
				$checker = md5(serialize($the_get).$code);
				if (!isset($this->customViewQueryChecker[$this->target]) || !in_array($checker,$this->customViewQueryChecker[$this->target]))
				{
					// load this unuiqe key 
					$this->customViewQueryChecker[$this->target][] = $checker;
					if (ComponentbuilderHelper::checkString($the_get['selection']['type']))
					{
						$getItem = "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." Get from ".$the_get['selection']['table']." as ".$the_get['as'];
					}
					else
					{
						$getItem = "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." Get data";
					}
					// set the selection
					$getItem .= "\n\t".$tab."\t".$the_get['selection']['select'];
					if (($nr == 0 && (!isset($the_get['join_field']) || !ComponentbuilderHelper::checkString($the_get['join_field'])) && (isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))) ||
						($type == 'custom' && (isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))))
					{
						$getItem .= "\n\t".$tab."\t".'$query->from('.$the_get['selection']['from'].');';
					}
					elseif (isset($the_get['join_field']) && ComponentbuilderHelper::checkString($the_get['join_field']) && isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))
					{
						$getItem .= "\n\t".$tab."\t\$query->join('".$the_get['type'];
						$getItem .= "', (".$the_get['selection']['from'];
						$getItem .= ") . ' ON (' . \$db->quoteName('".$the_get['on_field'];
						$getItem .= "') . ' ".$the_get['operator'];
						$getItem .= " ' . \$db->quoteName('".$the_get['join_field']."') . ')');";

						$check = current(explode(".", $the_get['on_field']));
					}

					// set the method defaults
					$default = $this->setCustomViewMethodDefaults($the_get,$code);
					if (isset($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && ComponentbuilderHelper::checkString($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && !in_array($check,$mainAsArray))
					{
						// load to other query
						if (!isset($this->otherQuery[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']]))
						{
							$this->otherQuery[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] = '';
						}
						$this->otherQuery[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] .= $getItem;
					}
					else
					{
						$mainAsArray[] = $default['as'];
						$query .= $getItem;
					}
				}
			}
		}
		return $query;
	}

	protected function setCustomViewFieldDecodeFilter(&$get,&$filters,$string,$removeString,$code,$tab)
	{
		$filter = '';
		// check if filter is set for this field
		if (ComponentbuilderHelper::checkArray($filters))
		{
			foreach ($filters as $field => $ter)
			{
				if (strpos($get['selection']['select'], $ter['table_key']) !== false)
				{
					$as = '';
					$felt = '';
					list($as,$felt) = array_map('trim', explode('.',$ter['table_key']));
					if ($get['as'] == $as)
					{
						switch ($ter['filter_type'])
						{
							case 4:
							// COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
							$filter .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." filter ".$as." based on user groups";
							$filter .= "\n\t".$tab."\t\$remove = (count(array_intersect((array) \$this->groups, (array) ".$string."->".$field."))) ? false : true;";
							$filter .= "\n\t".$tab."\tif (\$remove)";
							$filter .= "\n\t".$tab."\t{";
							if ($removeString == $string)
							{
								$filter .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." Remove ".$string." if user not in groups";
								$filter .= "\n\t".$tab."\t\t".$string." = null;";
								$filter .= "\n\t".$tab."\t\treturn false;";
							}
							else
							{
								$filter .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." Unset ".$string." if user not in groups";
								$filter .= "\n\t".$tab."\t\tunset(".$removeString.");";
								$filter .= "\n\t".$tab."\t\tcontinue;";
							}
							$filter .= "\n\t".$tab."\t}";
							break;
							case 9:
							// COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE

							$filter .= "\n\n\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(".$string."->".$field."))";
							$filter .= "\n\t".$tab."\t{";

							$filter .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." do your thing here";

							$filter .= "\n\t".$tab."\t}";
							$filter .= "\n\t".$tab."\telse";
							$filter .= "\n\t".$tab."\t{";

							if ($removeString == $string)
							{
								$filter .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." Remove ".$string." if not array.";
								$filter .= "\n\t".$tab."\t\t".$string." = null;";
							}
							else
							{
								$filter .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." Unset ".$string." if not array.";
								$filter .= "\n\t".$tab."\t\tunset(".$removeString.");";
								$filter .= "\n\t".$tab."\t\tcontinue;";
							}

							$filter .= "\n\t".$tab."\t}";
							break;
							case 10:
							// COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
							$filter .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." filter ".$as." based on repeatable value";
							$filter .= "\n\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkString(".$string."->".$field."))";
							$filter .= "\n\t".$tab."\t{";

							$filter .= "\n\t\t".$tab."\t\$array = json_decode(".$string."->".$field.",true);";
							$filter .= "\n\t\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$array))";
							$filter .= "\n\t\t".$tab."\t{";

							$filter .= "\n\t\t".$tab."\t\t//".$this->setLine(__LINE__)." do your thing here";

							$filter .= "\n\t\t".$tab."\t}";
							$filter .= "\n\t".$tab."\t\telse";
							$filter .= "\n\t".$tab."\t\t{";

							if ($removeString == $string)
							{
								$filter .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." Remove ".$string." if not array.";
								$filter .= "\n\t".$tab."\t\t\t".$string." = null;";
							}
							else
							{
								$filter .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." Unset ".$string." if not array.";
								$filter .= "\n\t".$tab."\t\t\tunset(".$removeString.");";
								$filter .= "\n\t".$tab."\t\t\tcontinue;";
							}

							$filter .= "\n\t".$tab."\t\t}";

							$filter .= "\n\t".$tab."\t}";
							$filter .= "\n\t".$tab."\telse";
							$filter .= "\n\t".$tab."\t{";

							if ($removeString == $string)
							{
								$filter .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." Remove ".$string." if not string.";
								$filter .= "\n\t".$tab."\t\t".$string." = null;";
							}
							else
							{
								$filter .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." Unset ".$string." if not string.";
								$filter .= "\n\t".$tab."\t\tunset(".$removeString.");";
								$filter .= "\n\t".$tab."\t\tcontinue;";
							}

							$filter .= "\n\t".$tab."\t}";
							break;
						}
					}
				}
			}
		}
		return $filter;
	}

	protected function setCustomViewFieldDecode(&$get,$checker,$string,$code,$tab = '')
	{
		$fieldDecode = '';
		foreach ($checker as $field => $array)
		{
			if (strpos($get['selection']['select'], $field) !== false)
			{
				if ($array['decode'] == 'json')
				{
					$if = "\n\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkString(".$string."->".$field."))\n\t".$tab."\t{";
					// json_decode
					$decoder = $string."->".$field." = json_decode(".$string."->".$field.", true);";
					// TODO Use the type of field to prepare it even more for use in the view
				}
				elseif ($array['decode'] == 'base64')
				{
					$if = "\n\t".$tab."\tif (!empty(".$string."->".$field.") && ".$string."->".$field." === base64_encode(base64_decode(".$string."->".$field.")))\n\t".$tab."\t{";
					// base64_decode
					$decoder = $string."->".$field." = base64_decode(".$string."->".$field.");";
					// TODO Use the type of field to prepare it even more for use in the view
				}
				elseif ($array['decode'] == 'basic_encryption')
				{
					$if = "\n\t".$tab."\tif (!empty(".$string."->".$field.") && \$basickey && !is_numeric(".$string."->".$field.") && ".$string."->".$field." === base64_encode(base64_decode(".$string."->".$field.", true)))\n\t".$tab."\t{";
					// basic decryption
					$decoder = $string."->".$field." = rtrim(\$basic->decryptString(".$string."->".$field."), ".'"\0"'.");";
					$this->siteDecrypt['basic'][$code] = true;
				}
				elseif ($array['decode'] == 'advance_encryption')
				{
					$if = "\n\t".$tab."\tif (!empty(".$string."->".$field.") && \$advancedkey && !is_numeric(".$string."->".$field.") && ".$string."->".$field." === base64_encode(base64_decode(".$string."->".$field.", true)))\n\t".$tab."\t{";
					// advanced decryption
					$decoder = $string."->".$field." = rtrim(\$advanced->decryptString(".$string."->".$field."), ".'"\0"'.");";
					$this->siteDecrypt['advanced'][$code] = true;
				}

				// build decoder string
				$fieldDecode .= $if."\n\t".$tab."\t\t//".$this->setLine(__LINE__)." Decode ".$field;
				$fieldDecode .= "\n\t".$tab."\t\t".$decoder."\n\t".$tab."\t}";
			}
		}
		return $fieldDecode;
	}

	protected function setCustomViewFieldUikitChecker(&$get,$checker,$string,$code,$tab = '')
	{
		$fieldUikit = '';
		foreach ($checker as $field => $array)
		{
			if (strpos($get['selection']['select'], $field) !== false)
			{
				// build decoder string
				$fieldUikit .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Make sure the content prepare plugins fire on ".$field.".";
				$fieldUikit .= "\n\t".$tab."\t".$string."->".$field." = JHtml::_('content.prepare',".$string."->".$field.");";
				$fieldUikit .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Checking if ".$field." has uikit components that must be loaded.";
				$fieldUikit .= "\n\t".$tab."\t\$this->uikitComp = ".$this->fileContentStatic['###Component###']."Helper::getUikitComp(".$string."->".$field.",\$this->uikitComp);";
			}
		}
		return $fieldUikit;
	}

	protected function setCustomViewCustomJoin(&$gets,$string,$code,&$asBucket,$tab = '')
	{
		if (ComponentbuilderHelper::checkArray($gets))
		{
			$customJoin = '';
			foreach ($gets as $get)
			{
				// set the value name $default
				$default = $this->setCustomViewMethodDefaults($get,$code);
				if ($this->checkJoint($default,$get,$asBucket))
				{
					// build custom join string
					$otherJoin = "\n\t###TAB###\t//".$this->setLine(__LINE__)." set ".$default['valueName']." to the ###STRING### object.";
					$otherJoin .= "\n\t###TAB###\t###STRING###->".$default['valueName']." = \$this->get".$default['methodName']."(###STRING###->".$this->getAsLookup[$get['key']][$get['on_field']].");";
					// load to other join
					if (!isset($this->otherJoin[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']]))
					{
						$this->otherJoin[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] = '';
					}
					$this->otherJoin[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] .= $otherJoin;
				}
				else
				{
					// build custom join string
					$customJoin .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." set ".$default['valueName']." to the ".$string." object.";
					$customJoin .= "\n\t".$tab."\t".$string."->".$default['valueName']." = \$this->get".$default['methodName']."(".$string."->".$this->getAsLookup[$get['key']][$get['on_field']].");";
				}
			}
			return $customJoin;
		}
		return '';
	}
	
	protected function checkJoint(&$default,&$get,&$asBucket)
	{
		// check if this function is not linked to the main call 
		list($aJoin) = explode('.',$get['on_field']);
		if (ComponentbuilderHelper::checkArray($asBucket) && in_array($aJoin,$asBucket))
		{
			return false;
		}
		// default fallback
		elseif (isset($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && ComponentbuilderHelper::checkString($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]))
		{
			return true;
		}
		return false;
	}

	protected function setCustomViewFilter(&$filter,&$code,$tab = '')
	{
		$filters = '';
		if (ComponentbuilderHelper::checkArray($filter))
		{
			foreach ($filter as $ter)
			{
				$as = '';
				$field = '';
				$string = '';
				if (strpos($ter['table_key'],'.') !== false)
				{
					list($as,$field) = array_map('trim', explode('.',$ter['table_key']));
				}
				switch ($ter['filter_type'])
				{
					case 1:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_ID
					$string = "\n\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . (int) \$pk);";
					break;
					case 2:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_USER
					$string = "\n\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . (int) \$this->userId);";
					break;
					case 3:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_ACCESS_LEVEL
					$string = "\n\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " (' . implode(',', \$this->levels) . ')');";
					break;
					case 4:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
					$decodeChecker = $this->siteFieldData['decode'][$code][$ter['key']][$as][$field];
					if (ComponentbuilderHelper::checkArray($decodeChecker) || $ter['state_key'] == 'array')
					{
						// set needed fields to filter after query
						$this->siteFieldDecodeFilter[$this->target][$code][$ter['key']][$as][$field] = $ter;
					}
					else
					{
						$string = "\n\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " (' . implode(',', \$this->groups) . ')');";
					}
					break;
					case 5:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_CATEGORIES
					$string = "";
					break;
					case 6:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_TAGS
					$string = "";
					break;
					case 7:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_DATE
					$string = "";
					break;
					case 8:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_FUNCTIONVAR
					if ($ter['operator'] == 'IN' || $ter['operator'] == 'NOT IN')
					{						
						$string = "\n\t\t".$tab."//".$this->setLine(__LINE__)." Check if " . $ter['state_key'] . " is an array with values.";
						$string .= "\n\t\t".$tab."\$array = " . $ter['state_key'].";";
						$string .= "\n\t\t".$tab."if (isset(\$array) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$array))";
						$string .= "\n\t\t".$tab."{";
						$string .= "\n\t\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator']  . " (' . implode(',', \$array) . ')');";
						$string .= "\n\t\t".$tab."}";
						$string .= "\n\t\t".$tab."else";
						$string .= "\n\t\t".$tab."{";
						$string .= "\n\t\t".$tab."\treturn false;";
						$string .= "\n\t\t".$tab."}";
					}
					else
					{						
						$string = "\n\t\t".$tab."//".$this->setLine(__LINE__)." Check if " . $ter['state_key'] . " is a string or numeric value.";
						$string .= "\n\t\t".$tab."\$checkValue = " . $ter['state_key'].";";
						$string .= "\n\t\t".$tab."if (isset(\$checkValue) && ".$this->fileContentStatic['###Component###']."Helper::checkString(\$checkValue))";
						$string .= "\n\t\t".$tab."{";
						$string .= "\n\t\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . \$db->quote(\$checkValue));";
						$string .= "\n\t\t".$tab."}";
						$string .= "\n\t\t".$tab."elseif (is_numeric(\$checkValue))";
						$string .= "\n\t\t".$tab."{";
						$string .= "\n\t\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . \$checkValue);";
						$string .= "\n\t\t".$tab."}";
						$string .= "\n\t\t".$tab."else";
						$string .= "\n\t\t".$tab."{";
						$string .= "\n\t\t".$tab."\treturn false;";
						$string .= "\n\t\t".$tab."}";
					}
					break;
					case 9:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE
					$string = "";
					// set needed fields to filter after query
					$this->siteFieldDecodeFilter[$this->target][$code][$ter['key']][$as][$field] = $ter;
					break;
					case 10:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
					$string = "";
					// set needed fields to filter after query
					$this->siteFieldDecodeFilter[$this->target][$code][$ter['key']][$as][$field] = $ter;
					break;
					case 11:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_OTHER
					if (strpos($as,'(') !== false)
					{
						// TODO (for now we only fix extra sql methods here)
						list($dump,$as) = array_map('trim', explode('(',$as));
						$field = trim(str_replace(')', '', $field));
					}
					$string = "\n\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ". $ter['state_key']."');";
					break;
				}
				// only add if the filter is set
				if (ComponentbuilderHelper::checkString($string))
				{
					// sort where
					if ($as == 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
					{
						$filters .= $string;
					}
					elseif($as != 'a')
					{
						$this->otherFilter[$this->target][$code][$as][$field] = $string;
					}
				}
			}
		}
		return $filters;
	}

	protected function setCustomViewOrder(&$order,&$code,$tab = '')
	{
		$ordering = '';
		if (ComponentbuilderHelper::checkArray($order))
		{
			foreach ($order as $or)
			{
				list($as,$field) = array_map('trim', explode('.',$or['table_key']));

				// set the string
				$string = "\$query->order('".$or['table_key']." ".$or['direction']."');";
				// sort where
				if ($as == 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
				{
					$ordering .= "\n\t".$tab."\t".$string;
				}
				else
				{
					$this->otherOrder[$this->target][$code][$as][$field] = "\n\t\t".$string;
				}
			}
		}
		return $ordering;
	}

	protected function setCustomViewWhere(&$where,&$code,$tab = '')
	{
		$wheres = '';
		if (ComponentbuilderHelper::checkArray($where))
		{
			foreach ($where as $whe)
			{
				$as = '';
				$field = '';
				$value = '';
				list($as,$field) = array_map('trim', explode('.',$whe['table_key']));
				if (is_numeric($whe['value_key']))
				{
					$value = " ".$whe['value_key']."');";

				}
				elseif (strpos($whe['value_key'],'$this->') !== false)
				{
					if ($whe['operator'] == 'IN' || $whe['operator'] == 'NOT IN')
					{
						$value = " (' . implode(',', " . $whe['value_key'] . ") . ')');";
					}
					else
					{
						$value = " ' . \$db->quote(".$whe['value_key']."));";
					}
				}
				elseif (strpos($whe['value_key'],'.') !== false)
				{
					$value = " ".$whe['value_key']."');";
				}
				// only load if there is a value
				if (ComponentbuilderHelper::checkString($value))
				{
					// set the string
					if ($whe['operator'] == 'IN' || $whe['operator'] == 'NOT IN')
					{
						$tabe = '';
						if ($as == 'a')
						{
							$tabe = $tab;
						}
						$string = "if (isset(" . $whe['value_key']. ") && ".$this->fileContentStatic['###Component###']."Helper::checkArray(" . $whe['value_key']. "))";
						$string .= "\n\t".$tabe."\t{";
						$string .= "\n\t".$tabe."\t\t\$query->where('".$whe['table_key']." ".$whe['operator'].$value;
						$string .= "\n\t".$tabe."\t}";
						$string .= "\n\t".$tabe."\telse";
						$string .= "\n\t".$tabe."\t{";
						$string .= "\n\t".$tabe."\t\treturn false;";
						$string .= "\n\t".$tabe."\t}";

					}
					else
					{
						$string = "\$query->where('".$whe['table_key']." ".$whe['operator'].$value;
					}
					// sort where
					if ($as == 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
					{
						$wheres .= "\n\t".$tab."\t".$string;
					}
					elseif ($as != 'a')
					{
						$this->otherWhere[$this->target][$code][$as][$field] = "\n\t\t".$string;
					}
				}
			}
		}
		return $wheres;
	}

	protected function setCustomViewGlobals(&$global,$string,$as,$tab = '')
	{
		$globals = '';
		if (ComponentbuilderHelper::checkArray($global))
		{
			$as = array_unique($as);
			foreach ($global as $glo)
			{
				if (in_array($glo['as'],$as))
				{
					switch ($glo['type'])
					{
						case 1:
						// SET STATE
						$value = "\$this->setState('" . $glo['as'] . "." . $glo['name'] . "', " . $string . "->" . $glo['key'] . ");";
						break;
						case 2:
						// SET THIS
						$value = "\$this->" . $glo['as'] . "_" . $glo['name'] . " = " . $string . "->" . $glo['key'] . ";";
						break;
					}
					// only add if the filter is set
					if (ComponentbuilderHelper::checkString($value))
					{
						$globals .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." set the global " . $glo['name'] . " value.\n\t".$tab."\t".$value;
					}
				}
			}
		}
		return $globals;
	}

	protected function removeAsDot($string,$type = '')
	{
		if (strpos($string,'.') !== false)
		{
			list($dump,$field) = array_map('trim', explode('.',$string));
		}
		else
		{
			$field = $string;
		}
		return $field;
	}

	protected function setCustomViewGetItem(&$get,&$code,$tab = '',$type = 'main')
	{
		if (ComponentbuilderHelper::checkObject($get))
		{
			$this->siteDecrypt['basic'][$code] = false;
			$this->siteDecrypt['advanced'][$code] = false;

			$getItem = "\n\t".$tab."\t//".$this->setLine(__LINE__)." Get a db connection.";
			$getItem .= "\n\t".$tab."\t\$db = JFactory::getDbo();";
			$getItem .= "\n\n".$tab."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$getItem .= "\n\t".$tab."\t\$query = \$db->getQuery(true);";
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get,$code,$tab);
			// setup filters
			$getItem .= $this->setCustomViewFilter($get->filter,$code,$tab);
			// setup Where
			$getItem .= $this->setCustomViewWhere($get->where,$code,$tab);
			// setup ordering
			$getItem .= $this->setCustomViewOrder($get->order,$code,$tab);
			// get ready to get query
			$getItem .= "\n\n".$tab."\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
			$getItem .= "\n\t".$tab."\t\$db->setQuery(\$query);";
			$getItem .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Load the results as a stdClass object.";
			$getItem .= "\n\t".$tab."\t\$data = \$db->loadObject();";
			$getItem .= "\n\n".$tab."\t\tif (empty(\$data))";
			$getItem .= "\n\t".$tab."\t{";
			if ($type == 'main')
			{
				$langKeyWord = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Not found or access denied','U');
				if (!isset($this->langContent[$this->lang][$langKeyWord]))
				{
					$this->langContent[$this->lang][$langKeyWord] = 'Not found, or access denied.';
				}
				$getItem .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." If no data is found redirect to default page and show warning.";
				$getItem .= "\n\t".$tab."\t\tJError::raiseWarning(500, JText::_('".$langKeyWord."'));";
				if ('site' == $this->target)
				{
					$getItem .= "\n\t".$tab."\t\tJFactory::getApplication()->redirect('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$this->fileContentStatic['###SITE_DEFAULT_VIEW###']."');";
				}
				else
				{
					$getItem .= "\n\t".$tab."\t\tJFactory::getApplication()->redirect('index.php?option=com_".$this->fileContentStatic['###component###']."');";
				}
				$getItem .= "\n\t".$tab."\t\treturn false;";
			}
			else
			{
				$getItem .= "\n\t".$tab."\t\treturn false;";
			}
			$getItem .= "\n\t".$tab."\t}";
			if (ComponentbuilderHelper::checkArray($get->main_get))
			{
				$asBucket = array();
				foreach ($get->main_get as $main_get)
				{
					if (isset($this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeChecker = $this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeChecker))
						{
							// set decoding of needed fields
							$getItem .= $this->setCustomViewFieldDecode($main_get,$decodeChecker,'$data',$code,$tab);
						}
					}
						
					if (isset ($this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeFilter))
						{
							// also filter fields if needed
							$getItem .= $this->setCustomViewFieldDecodeFilter($main_get,$decodeFilter,'$data','$data',$code,$tab);
						}
					}
						
					if (isset($this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']]))
					{
						$uikitChecker = $this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($uikitChecker))
						{
							// set uikit checkers on needed fields
							$getItem .= $this->setCustomViewFieldUikitChecker($main_get,$uikitChecker,'$data',$code,$tab);
						}
					}
					$asBucket[] = $main_get['as'];
				}
			}

			if ((isset($this->siteDecrypt['basic'][$code]) && $this->siteDecrypt['basic'][$code]) || (isset($this->siteDecrypt['advanced'][$code]) && $this->siteDecrypt['advanced'][$code]))
			{
				$Component	= $this->fileContentStatic['###Component###'];
				$script = '';
				if (isset($this->siteDecrypt['basic'][$code]) && $this->siteDecrypt['basic'][$code])
				{
					$script .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the basic encription.";
					$script .= "\n\t".$tab."\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
					$script .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the encription object.";
					$script .= "\n\t".$tab."\t\$basic = new FOFEncryptAes(\$basickey, 128);";
				}
				if (isset($this->siteDecrypt['advanced'][$code]) && $this->siteDecrypt['advanced'][$code])
				{
					$script .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the advanced encription.";
					$script .= "\n\t".$tab."\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
					$script .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the encription object.";
					$script .= "\n\t".$tab."\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
				}
				$getItem = $script . $getItem;
			}
			// setup Globals
			$getItem .= $this->setCustomViewGlobals($get->global,'$data',$asBucket,$tab);
			// setup the custom gets that returns multipal values
			$getItem .= $this->setCustomViewCustomJoin($get->custom_get,'$data',$code,$asBucket,$tab);
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode("\n",$get->php_calculation);
				$getItem .= "\n\t".$tab."\t".implode("\n\t".$tab."\t",$get->php_calculation);
			}
			if ($type == 'custom')
			{
				// return the object
				$getItem .=  "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." return data object.";
				$getItem .=  "\n\t".$tab."\treturn \$data;";
			}
			else
			{
				// set the object
				$getItem .=  "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." set data object to item.";
				$getItem .=  "\n\t".$tab."\t\$this->_item[\$pk] = \$data;";
			}
			return $getItem;
		}
		return "\n\t".$tab."\t//".$this->setLine(__LINE__)."add your custom code here.";
	}

	protected function setCustomViewCustomMethods($main_view,$code)
	{
		$methods = '';
		// then set the needed custom methods
		if (ComponentbuilderHelper::checkArray($main_view['settings']->custom_get))
		{
			// start dynamic build
			foreach ($main_view['settings']->custom_get as $view)
			{
				// fix alias to use in code
				$view->code = ComponentbuilderHelper::safeString($code);
				$view->Code = ComponentbuilderHelper::safeString($view->code, 'F');
				$view->CODE = ComponentbuilderHelper::safeString($view->code, 'U');
				$main = '';
				if ($view->gettype == 3)
				{
					// ###SITE_GET_ITEM### <<<DYNAMIC>>>
					$main .= "\n\n\t\tif (!isset(\$this->initSet) || !\$this->initSet)";
					$main .= "\n\t\t{";
					$main .= "\n\t\t\t\$this->user\t\t= JFactory::getUser();";
					$main .= "\n\t\t\t\$this->userId\t\t= \$this->user->get('id');";
					$main .= "\n\t\t\t\$this->guest\t\t= \$this->user->get('guest');";
					$main .= "\n\t\t\t\$this->groups\t\t= \$this->user->get('groups');";
					$main .= "\n\t\t\t\$this->authorisedGroups\t= \$this->user->getAuthorisedGroups();";
					$main .= "\n\t\t\t\$this->levels\t\t= \$this->user->getAuthorisedViewLevels();";
					$main .= "\n\t\t\t\$this->initSet\t\t= true;";
					$main .= "\n\t\t}";
					$main .= $this->setCustomViewGetItem($view, $view->code,'','custom');
					$type = 'mixed  item data object on success, false on failure.';
				}
				elseif ($view->gettype == 4)
				{
					$main .= "\n\n\t\tif (!isset(\$this->initSet) || !\$this->initSet)";
					$main .= "\n\t\t{";
					$main .= "\n\t\t\t\$this->user\t\t= JFactory::getUser();";
					$main .= "\n\t\t\t\$this->userId\t\t= \$this->user->get('id');";
					$main .= "\n\t\t\t\$this->guest\t\t= \$this->user->get('guest');";
					$main .= "\n\t\t\t\$this->groups\t\t= \$this->user->get('groups');";
					$main .= "\n\t\t\t\$this->authorisedGroups\t= \$this->user->getAuthorisedGroups();";
					$main .= "\n\t\t\t\$this->levels\t\t= \$this->user->getAuthorisedViewLevels();";
					$main .= "\n\t\t\t\$this->initSet\t\t= true;";
					$main .= "\n\t\t}";
					$main .= "\n\n\t\t//".$this->setLine(__LINE__)." Get the global params";
					$main .= "\n\t\t\$globalParams = JComponentHelper::getParams('com_".$this->fileContentStatic['###component###']."', true);";
					// ###SITE_GET_LIST_QUERY### <<<DYNAMIC>>>
					$main .= $this->setCustomViewListQuery($view, $view->code, false);
					// load the object list
					$main .= "\n\n\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$main .= "\n\t\t\$db->setQuery(\$query);";
					$main .= "\n\t\t\$items = \$db->loadObjectList();";
					$main .= "\n\n\t\tif (empty(\$items))";
					$main .= "\n\t\t{";
					$main .= "\n\t\t\treturn false;";
					$main .= "\n\t\t}";
					// ###SITE_GET_ITEMS### <<<DYNAMIC>>>
					$main .= $this->setCustomViewGetItems($view,$view->code);
					$main .= "\n\t\t//".$this->setLine(__LINE__)." return items";
					$main .= "\n\t\treturn \$items;";
					$type = 'mixed  An array of objects on success, false on failure.';
				}
				// load the main mehtod
				$methods .= $this->setMainCustomMehtod($main,$view->getcustom,$type);
				// ###SITE_CUSTOM_METHODS### <<<DYNAMIC>>>
				$methods .= $this->setCustomViewCustomItemMethods($view, $view->code);
			}
		}
		// load uikit get method
		$methods .= $this->setUikitGetMethod();

		return $methods;
	}

	protected function setUikitHelperMethods()
	{
		if ($this->uikit)
		{
			// build uikit get method
			$ukit = array();
			$ukit[] = "\n\n\t/**";
			$ukit[] = "\t* \tUIKIT Component Classes";
			$ukit[] = "\t**/";
			$ukit[] = "\tpublic static \$uk_components = array(";
			$ukit[] = "\t\t\t'data-uk-grid' => array(";
			$ukit[] = "\t\t\t\t'grid' ),";
			$ukit[] = "\t\t\t'uk-accordion' => array(";
			$ukit[] = "\t\t\t\t'accordion' ),";
			$ukit[] = "\t\t\t'uk-autocomplete' => array(";
			$ukit[] = "\t\t\t\t'autocomplete' ),";
			$ukit[] = "\t\t\t'data-uk-datepicker' => array(";
			$ukit[] = "\t\t\t\t'datepicker' ),";
			$ukit[] = "\t\t\t'uk-form-password' => array(";
			$ukit[] = "\t\t\t\t'form-password' ),";
			$ukit[] = "\t\t\t'uk-form-select' => array(";
			$ukit[] = "\t\t\t\t'form-select' ),";
			$ukit[] = "\t\t\t'data-uk-htmleditor' => array(";
			$ukit[] = "\t\t\t\t'htmleditor' ),";
			$ukit[] = "\t\t\t'data-uk-lightbox' => array(";
			$ukit[] = "\t\t\t\t'lightbox' ),";
			$ukit[] = "\t\t\t'uk-nestable' => array(";
			$ukit[] = "\t\t\t\t'nestable' ),";
			$ukit[] = "\t\t\t'UIkit.notify' => array(";
			$ukit[] = "\t\t\t\t'notify' ),";
			$ukit[] = "\t\t\t'data-uk-parallax' => array(";
			$ukit[] = "\t\t\t\t'parallax' ),";
			$ukit[] = "\t\t\t'uk-search' => array(";
			$ukit[] = "\t\t\t\t'search' ),";
			$ukit[] = "\t\t\t'uk-slider' => array(";
			$ukit[] = "\t\t\t\t'slider' ),";
			$ukit[] = "\t\t\t'uk-slideset' => array(";
			$ukit[] = "\t\t\t\t'slideset' ),";
			$ukit[] = "\t\t\t'uk-slideshow' => array(";
			$ukit[] = "\t\t\t\t'slideshow',";
			$ukit[] = "\t\t\t\t'slideshow-fx' ),";
			$ukit[] = "\t\t\t'uk-sortable' => array(";
			$ukit[] = "\t\t\t\t'sortable' ),";
			$ukit[] = "\t\t\t'data-uk-sticky' => array(";
			$ukit[] = "\t\t\t\t'sticky' ),";
			$ukit[] = "\t\t\t'data-uk-timepicker' => array(";
			$ukit[] = "\t\t\t\t'timepicker' ),";
			$ukit[] = "\t\t\t'data-uk-tooltip' => array(";
			$ukit[] = "\t\t\t\t'tooltip' ),";
			$ukit[] = "\t\t\t'uk-placeholder' => array(";
			$ukit[] = "\t\t\t\t'placeholder' ),";
			$ukit[] = "\t\t\t'uk-dotnav' => array(";
			$ukit[] = "\t\t\t\t'dotnav' ),";
			$ukit[] = "\t\t\t'uk-slidenav' => array(";
			$ukit[] = "\t\t\t\t'slidenav' ),";
			$ukit[] = "\t\t\t'uk-form' => array(";
			$ukit[] = "\t\t\t\t'form-advanced' ),";
			$ukit[] = "\t\t\t'uk-progress' => array(";
			$ukit[] = "\t\t\t\t'progress' ),";
			$ukit[] = "\t\t\t'upload-drop' => array(";
			$ukit[] = "\t\t\t\t'upload', 'form-file' )";
			$ukit[] = "\t\t\t);";
			$ukit[] = "\t";
			$ukit[] = "\t/**";
			$ukit[] = "\t* \tAdd UIKIT Components";
			$ukit[] = "\t**/";
			$ukit[] = "\tpublic static \$uikit = false;";
			$ukit[] = "";
			$ukit[] = "\t/**";
			$ukit[] = "\t* \tGet UIKIT Components";
			$ukit[] = "\t**/";
			$ukit[] = "\tpublic static function getUikitComp(\$content,\$classes = array())";
			$ukit[] = "\t{";
			$ukit[] = "\t\tif (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = "\t\t{";
			$ukit[] = "\t\t\t//".$this->setLine(__LINE__)." reset";
			$ukit[] = "\t\t\t\$temp = array();";
			$ukit[] = "\t\t\tforeach (self::\$uk_components as \$looking => \$add)";
			$ukit[] = "\t\t\t{";
			$ukit[] = "\t\t\t\tif (strpos(\$content,\$looking) !== false)";
			$ukit[] = "\t\t\t\t{";
			$ukit[] = "\t\t\t\t\t\$temp[] = \$looking;";
			$ukit[] = "\t\t\t\t}";
			$ukit[] = "\t\t\t}";
			$ukit[] = "\t\t\t//".$this->setLine(__LINE__)." make sure uikit is loaded to config";
			$ukit[] = "\t\t\tif (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = "\t\t\t{";
			$ukit[] = "\t\t\t\tself::\$uikit = true;";
			$ukit[] = "\t\t\t}";
			$ukit[] = "\t\t\t//".$this->setLine(__LINE__)." sorter";
			$ukit[] = "\t\t\tif (self::checkArray(\$temp))";
			$ukit[] = "\t\t\t{";
			$ukit[] = "\t\t\t\t//".$this->setLine(__LINE__)." merger";
			$ukit[] = "\t\t\t\tif (self::checkArray(\$classes))";
			$ukit[] = "\t\t\t\t{";
			$ukit[] = "\t\t\t\t\t\$newTemp = array_merge(\$temp,\$classes);";
			$ukit[] = "\t\t\t\t\t\$temp = array_unique(\$newTemp);";
			$ukit[] = "\t\t\t\t}";
			$ukit[] = "\t\t\t\treturn \$temp;";
			$ukit[] = "\t\t\t}";
			$ukit[] = "\t\t}\t";
			$ukit[] = "\t\tif (self::checkArray(\$classes))";
			$ukit[] = "\t\t{";
			$ukit[] = "\t\t\treturn \$classes;";
			$ukit[] = "\t\t}";
			$ukit[] = "\t\treturn false;";
			$ukit[] = "\t}";

			// return the help methods
			return implode("\n",$ukit);
		}
		return '';
	}

	protected function setUikitGetMethod()
	{
		$method = '';
		if ($this->uikit)
		{
			// build uikit get method
			$method .= "\n\n\t/**";
			$method .= "\n\t* Get the uikit needed components";
			$method .= "\n\t*";
			$method .= "\n\t* @return mixed  An array of objects on success.";
			$method .= "\n\t*";
			$method .= "\n\t*/";
			$method .= "\n\tpublic function getUikitComp()";
			$method .= "\n\t{";
			$method .= "\n\t\tif (isset(\$this->uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$this->uikitComp))";
			$method .= "\n\t\t{";
			$method .= "\n\t\t\treturn \$this->uikitComp;";
			$method .= "\n\t\t}";
			$method .= "\n\t\treturn false;";
			$method .= "\n\t}";
		}
		return $method;
	}

	protected function setMainCustomMehtod(&$body,$nAme,$type)
	{
		$method = '';
		if (ComponentbuilderHelper::checkString($body))
		{
			// build custom method
			$method .= "\n\n\t/**";
			$method .= "\n\t* Custom Method";
			$method .= "\n\t*";
			$method .= "\n\t* @return ".$type;
			$method .= "\n\t*";
			$method .= "\n\t*/";
			$method .= "\n\tpublic function ".$nAme."()";
			$method .= "\n\t{".$body;
			$method .= "\n\t}";
		}
		return $method;
	}

	protected function setCustomViewCustomItemMethods(&$main_get,$code)
	{
		$methods = '';
		// first set the needed item/s methods
		if (ComponentbuilderHelper::checkObject($main_get))
		{
			if (isset($main_get->custom_get) && ComponentbuilderHelper::checkArray($main_get->custom_get))
			{
				foreach ($main_get->custom_get as $get)
				{
					$this->siteDecrypt['basic'][$code] = false;
					$this->siteDecrypt['advanced'][$code] = false;
					// set the method defaults
					$default = $this->setCustomViewMethodDefaults($get,$code);
					// build custom method
					$methods .= "\n\n\t/**";
					$methods .= "\n\t* Method to get an array of ".$default['name']." Objects.";
					$methods .= "\n\t*";
					$methods .= "\n\t* @return mixed  An array of ".$default['name']." Objects on success, false on failure.";
					$methods .= "\n\t*";
					$methods .= "\n\t*/";
					$methods .= "\n\tpublic function get".$default['methodName']."(\$".$default['on_field'].")";
					$methods .= "\n\t{###CRYPT###";
					$methods .= "\n\t\t//".$this->setLine(__LINE__)." Get a db connection.";
					$methods .= "\n\t\t\$db = JFactory::getDbo();";
					$methods .= "\n\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
					$methods .= "\n\t\t\$query = \$db->getQuery(true);";
					$methods .= "\n\n\t\t//".$this->setLine(__LINE__)." Get from ".$get['selection']['table']." as ".$default['as'];
					$methods .= "\n\t\t".$get['selection']['select'];
					$methods .= "\n\t\t".'$query->from('.$get['selection']['from'].');';
					// set the string
					if ($get['operator'] == 'IN' || $get['operator'] == 'NOT IN')
					{
						$methods .= "\n\n\t\t//".$this->setLine(__LINE__)." Check if \$" . $default['on_field'] . " is an array with values.";
						$methods .= "\n\t\t\$array = \$" . $default['on_field'] . ";";
						$methods .= "\n\t\tif (isset(\$array) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$array))";
						$methods .= "\n\t\t{";
						$methods .= "\n\t\t\t\$query->where('".$get['join_field']." ".$get['operator']." (' . implode(',', \$array) . ')');";
						$methods .= "\n\t\t}";
						$methods .= "\n\t\telse";
						$methods .= "\n\t\t{";
						$methods .= "\n\t\t\treturn false;";
						$methods .= "\n\t\t}";
					}
					else
					{
						$methods .= "\n\t\t\$query->where('".$get['join_field']." ".$get['operator']." ' . \$db->quote(\$".$default['on_field']."));";
					}
					// check if other queries should be loaded
					$queryChecker = (isset($this->otherQuery[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherQuery[$this->target][$default['code']][$default['as']])) ? $this->otherQuery[$this->target][$default['code']][$default['as']] : '';
					if (ComponentbuilderHelper::checkArray($queryChecker))
					{
						foreach ($queryChecker as $query)
						{
							$methods .= $query;
						}
					}
					// add any other filter that was set
					if (isset($this->otherFilter[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherFilter[$this->target][$default['code']][$default['as']]))
					{
						foreach ($this->otherFilter[$this->target][$default['code']][$default['as']] as $field => $string)
						{
							$methods .= $string;
						}
					}
					// add any other where that was set
					if (isset($this->otherWhere[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherWhere[$this->target][$default['code']][$default['as']]))
					{
						foreach ($this->otherWhere[$this->target][$default['code']][$default['as']] as $field => $string)
						{
							$methods .= $string;
						}
					}
					// add any other order that was set
					if (isset($this->otherOrder[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherOrder[$this->target][$default['code']][$default['as']]))
					{
						foreach ($this->otherOrder[$this->target][$default['code']][$default['as']] as $field => $string)
						{
							$methods .= $string;
						}
					}
					$methods .= "\n\n\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$methods .= "\n\t\t\$db->setQuery(\$query);";
					$methods .= "\n\t\t\$db->execute();";
					$methods .= "\n\n\t\t//".$this->setLine(__LINE__)." check if there was data returned";
					$methods .= "\n\t\tif (\$db->getNumRows())";
					$methods .= "\n\t\t{";
					// set decoding of needed fields
					if (isset($this->siteFieldData['decode'][$default['code']][$get['key']][$default['as']]))
					{
						$decodeChecker = $this->siteFieldData['decode'][$default['code']][$get['key']][$default['as']];
					}
					// also filter fields if needed
					if (isset($this->siteFieldDecodeFilter[$this->target][$default['code']][$get['key']][$default['as']]))
					{
						$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$default['code']][$get['key']][$default['as']];
					}
					// set uikit checkers on needed fields
					if (isset($this->siteFieldData['uikit'][$default['code']][$get['key']][$default['as']]))
					{
						$uikitChecker = $this->siteFieldData['uikit'][$default['code']][$get['key']][$default['as']];
					}
					// set joined values
					$placeholders = array('###TAB###' => "\t\t", '###STRING###' => '$item');
					$joinedChecker = (isset($this->otherJoin[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherJoin[$this->target][$default['code']][$default['as']])) ? $this->otherJoin[$this->target][$default['code']][$default['as']] : '';
					if (	(isset($decodeChecker) && ComponentbuilderHelper::checkArray($decodeChecker)) || 
						(isset($uikitChecker) && ComponentbuilderHelper::checkArray($uikitChecker)) || 
						(isset($decodeFilter) && ComponentbuilderHelper::checkArray($decodeFilter)) || 
						ComponentbuilderHelper::checkArray($joinedChecker))
					{
						$decoder = '';
						if (isset($decodeChecker) && ComponentbuilderHelper::checkArray($decodeChecker))
						{
							// also filter fields if needed
							$decoder = $this->setCustomViewFieldDecode($get,$decodeChecker,'$item',$default['code'],"\t\t");
						}
						$decoder_filter = '';
						if (isset($decodeFilter) && ComponentbuilderHelper::checkArray($decodeFilter))
						{
							$decoder_filter = $this->setCustomViewFieldDecodeFilter($get,$decodeFilter,'$item','$items[$nr]',$default['code'],"\t\t");
						}
						$uikit = '';
						if (isset($uikitChecker) && ComponentbuilderHelper::checkArray($uikitChecker))
						{
							$uikit = $this->setCustomViewFieldUikitChecker($get,$uikitChecker,'$item',$default['code'],"\t\t");
						}
						$joine = '';
						if (ComponentbuilderHelper::checkArray($joinedChecker))
						{
							foreach ($joinedChecker as $joinedString)
							{
								$joine .= str_replace(array_keys($placeholders),array_values($placeholders),$joinedString);
							}
						}
						if (ComponentbuilderHelper::checkString($decoder) || ComponentbuilderHelper::checkString($uikit) || ComponentbuilderHelper::checkString($decoder_filter) || ComponentbuilderHelper::checkString($joine))
						{
							$methods .= "\n\t\t\t\$items = \$db->loadObjectList();";
							$methods .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Convert the parameter fields into objects.";
							$methods .= "\n\t\t\tforeach (\$items as \$nr => &\$item)";
							$methods .= "\n\t\t\t{";
							if (ComponentbuilderHelper::checkString($decoder))
							{
								$methods .= $decoder;
							}
							if (ComponentbuilderHelper::checkString($decoder_filter))
							{
								$methods .= $decoder_filter;
							}
							if (ComponentbuilderHelper::checkString($uikit))
							{
								$methods .= $uikit;
							}
							if (ComponentbuilderHelper::checkString($joine))
							{
								$methods .= $joine;
							}
							$methods .= "\n\t\t\t}";
							$methods .= "\n\t\t\treturn \$items;";
						}
						else
						{
							$methods .= "\n\t\t\treturn \$db->loadObjectList();";
						}
					}
					else
					{
						$methods .= "\n\t\t\treturn \$db->loadObjectList();";
					}
					$methods .= "\n\t\t}";
					$methods .= "\n\t\treturn false;";
					$methods .= "\n\t}";

					if ((isset($this->siteDecrypt['basic'][$code]) && $this->siteDecrypt['basic'][$code]) || (isset($this->siteDecrypt['advanced'][$code]) && $this->siteDecrypt['advanced'][$code]))
					{
						$Component	= $this->fileContentStatic['###Component###'];
						$script = '';
						if ($this->siteDecrypt['basic'][$code])
						{
							$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the basic encription.";
							$script .= "\n\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
							$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the encription object.";
							$script .= "\n\t\t\$basic = new FOFEncryptAes(\$basickey, 128);\n";
						}
						if ($this->siteDecrypt['advanced'][$code])
						{
							$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the advanced encription.";
							$script .= "\n\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
							$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the encription object.";
							$script .= "\n\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);\n";
						}
						$methods = str_replace('###CRYPT###',$script,$methods);
					}
				}
				$methods = str_replace('###CRYPT###','',$methods);
			}
		}
		return $methods."\n";
	}

	protected function setCustomViewMethodDefaults($get,$code)
	{
		$key = substr(ComponentbuilderHelper::safeString(preg_replace('/[0-9]+/', '', md5($get['key'])),'F'), 0, 4);
		$method['on_field'] = (isset($get['on_field'])) ? $this->removeAsDot($get['on_field']):null;
		$method['join_field'] = (isset($get['join_field'])) ? ComponentbuilderHelper::safeString($this->removeAsDot($get['join_field'])):null;
		$method['Join_field'] = (isset($method['join_field'])) ? ComponentbuilderHelper::safeString($method['join_field'],'F'):null;
		$method['name'] = ComponentbuilderHelper::safeString($get['selection']['name'],'F');
		$method['code'] = ComponentbuilderHelper::safeString($code);
		$method['AS'] = ComponentbuilderHelper::safeString($get['as'],'U');
		$method['as'] = ComponentbuilderHelper::safeString($get['as']);
		$method['valueName'] = $method['on_field'] . $method['Join_field'] . $method['name'] . $method['AS'];
		$method['methodName'] = ComponentbuilderHelper::safeString($method['on_field'],'F') . $method['Join_field'] . $method['name'] . $key .'_'. $method['AS'];
		// return
		return $method;
	}

	protected function setCustomViewListQuery(&$get,$code,$return = true)
	{
		if (ComponentbuilderHelper::checkObject($get))
		{
			if ($get->pagination == 1)
			{
				$getItem = "\n\t\t//".$this->setLine(__LINE__)." Get a db connection.";
			}
			else
			{
				$getItem = "\n\t\t//".$this->setLine(__LINE__)." Make sure all records load, since no pagination allowed.";
				$getItem .= "\n\t\t\$this->setState('list.limit', 0);";
				$getItem .= "\n\t\t//".$this->setLine(__LINE__)." Get a db connection.";
			}
			$getItem .= "\n\t\t\$db = JFactory::getDbo();";
			$getItem .= "\n\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$getItem .= "\n\t\t\$query = \$db->getQuery(true);";
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get,$code);
			// setup filters
			$getItem .= $this->setCustomViewFilter($get->filter,$code);
			// setup where
			$getItem .= $this->setCustomViewWhere($get->where,$code);
			// setup ordering
			$getItem .= $this->setCustomViewOrder($get->order,$code);
			if ($return)
			{
				// return the query object
				$getItem .= "\n\n\t\t//".$this->setLine(__LINE__)." return the query object\n\t\treturn \$query;";
			}

			return $getItem;
		}
		return "\n\t\t//".$this->setLine(__LINE__)."add your custom code here.";
	}

	protected function setCustomViewGetItems(&$get,$code)
	{
		$getItem = '';
		$this->siteDecrypt['basic'][$code] = false;
		$this->siteDecrypt['advanced'][$code] = false;
		if (ComponentbuilderHelper::checkObject($get))
		{
			$getItem .= "\n\n\t\t//".$this->setLine(__LINE__)." Convert the parameter fields into objects.";
			$getItem .= "\n\t\tforeach (\$items as \$nr => &\$item)";
			$getItem .= "\n\t\t{";
			$getItem .= "\n\t\t\t//".$this->setLine(__LINE__)." Always create a slug for sef URL's";
			$getItem .= "\n\t\t\t\$item->slug = (isset(\$item->alias)) ? \$item->id.':'.\$item->alias : \$item->id;";
			if (isset($get->main_get) && ComponentbuilderHelper::checkArray($get->main_get))
			{
				$asBucket = array();
				foreach ($get->main_get as $main_get)
				{
					if (isset($this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeChecker = $this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeChecker))
						{
							// set decoding of needed fields
							$getItem .= $this->setCustomViewFieldDecode($main_get,$decodeChecker,"\$item",$code,"\t");
						}
					}
					// also filter fields if needed
					if (isset($this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeFilter))
						{
							$getItem .= $this->setCustomViewFieldDecodeFilter($main_get,$decodeFilter,"\$item",'$items[$nr]',$code,"\t");
						}
					}
					if (isset($this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']]))
					{
						$uikitChecker = $this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($uikitChecker))
						{
							// set uikit checkers on needed fields
							$getItem .= $this->setCustomViewFieldUikitChecker($main_get,$uikitChecker,"\$item",$code,"\t");
						}
					}
					$asBucket[] = $main_get['as'];
				}
			}
			// setup Globals
			$getItem .= $this->setCustomViewGlobals($get->global,'$item',$asBucket,"\t");
			// setup the custom gets that returns multipal values
			$getItem .= $this->setCustomViewCustomJoin($get->custom_get,"\$item",$code,$asBucket,"\t");
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode("\n",$get->php_calculation);
				if (ComponentbuilderHelper::checkArray($get->php_calculation))
				{
					$getItem .= str_replace(array_keys($this->placeholders),array_values($this->placeholders),"\n\t\t\t".implode("\n\t\t\t",$get->php_calculation));
				}
			}
			$getItem .= "\n\t\t}";
			// remove empty foreach
			if (strlen($getItem) <= 100)
			{
				$getItem = "\n";
			}
		}

		if ($this->siteDecrypt['basic'][$code] || $this->siteDecrypt['advanced'][$code])
		{
			$Component	= $this->fileContentStatic['###Component###'];
			$script = '';
			if ($this->siteDecrypt['basic'][$code])
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Get the basic encription.";
				$script .= "\n\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the encription object.";
				$script .= "\n\t\t\$basic = new FOFEncryptAes(\$basickey, 128);";
			}
			if ($this->siteDecrypt['advanced'][$code])
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Get the advanced encription.";
				$script .= "\n\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the encription object.";
				$script .= "\n\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
			}
			$getItem = $script . $getItem;
		}
		return $getItem;
	}

	protected function setCustomViewDisplayMethod(&$view)
	{
		$method = '';
		if (isset($view['settings']->main_get) && ComponentbuilderHelper::checkObject($view['settings']->main_get))
		{
			if ($view['settings']->main_get->gettype == 1)
			{
				// for single views
				$method .= "\n\t\t//".$this->setLine(__LINE__)." Initialise variables.";
				$method .= "\n\t\t\$this->item\t= \$this->get('Item');";
			}
			elseif ($view['settings']->main_get->gettype == 2)
			{
				// for list views
				$method .= "\n\t\t//".$this->setLine(__LINE__)." Initialise variables.";
				$method .= "\n\t\t\$this->items\t= \$this->get('Items');";
				// only add if pagination is requered
				if ($view['settings']->main_get->pagination == 1)
				{
					$method .= "\n\t\t\$this->pagination\t= \$this->get('Pagination');";
				}
				// add id to list view
				if (isset($this->customAdminViewListId[$view['settings']->code]))
				{
					// ###HIDDEN_INPUT_VALUES###
					$this->fileContentDynamic[$view['settings']->code]['###HIDDEN_INPUT_VALUES###'] = "\n\t".'<input type="hidden" name="id" value="<?php echo $this->app->input->getInt(\'id\', 0); ?>" />';
				}
				else
				{
					// also set the input value ###HIDDEN_INPUT_VALUES###
					$this->fileContentDynamic[$view['settings']->code]['###HIDDEN_INPUT_VALUES###'] = '';
				}
			}
			// add the custom get methods
			if (isset($view['settings']->custom_get) && ComponentbuilderHelper::checkArray($view['settings']->custom_get))
			{
				foreach ($view['settings']->custom_get as $custom_get)
				{
					$custom_get_name = str_replace('get','',$custom_get->getcustom);
					$method .= "\n\t\t\$this->".ComponentbuilderHelper::safeString($custom_get_name)."\t= \$this->get('".$custom_get_name."');";
				}
			}

			$method .= "\n\n\t\t//".$this->setLine(__LINE__)." Check for errors.";
			$method .= "\n\t\tif (count(\$errors = \$this->get('Errors')))";
			$method .= "\n\t\t{";
			$method .= "\n\t\t\tJError::raiseWarning(500, ".'implode("\n", $errors));';
			$method .= "\n\t\t\treturn false;";
			$method .= "\n\t\t}";
			// add custom script
			if ($view['settings']->add_php_jview_display == 1)
			{
				$view['settings']->php_jview_display = (array) explode("\n",$view['settings']->php_jview_display);
				if (ComponentbuilderHelper::checkArray($view['settings']->php_jview_display))
				{
					$method .= str_replace(array_keys($this->placeholders),array_values($this->placeholders),"\n\t\t".implode("\n\t\t",$view['settings']->php_jview_display));
				}
			}
			if ('site' == $this->target)
			{
				$method .= "\n\n\t\t//".$this->setLine(__LINE__)." Set the toolbar";
				$method .= "\n\t\t\$this->addToolBar();";
				$method .= "\n\n\t\t//".$this->setLine(__LINE__)." set the document";
				$method .= "\n\t\t\$this->_prepareDocument();";
			}
			elseif ('custom_admin' == $this->target)
			{
				$method .= "\n\n\t\t//".$this->setLine(__LINE__)." We don't need toolbar in the modal window.";
				$method .= "\n\t\tif (\$this->getLayout() !== 'modal')";
				$method .= "\n\t\t{";
				$method .= "\n\t\t\t//".$this->setLine(__LINE__)." add the tool bar";
				$method .= "\n\t\t\t\$this->addToolBar();";
				$method .= "\n\t\t}";
				$method .= "\n\n\t\t//".$this->setLine(__LINE__)." set the document";
				$method .= "\n\t\t\$this->setDocument();";
			}
			$method .= "\n\n\t\tparent::display(\$tpl);";
		}
		return $method;
	}

	protected function setPrepareDocument($view)
	{
		// ensure correct target is set
		$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
		// set uikit ###'.$TARGET.'_UIKIT_LOADER###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_UIKIT_LOADER###'] = $this->setUikitLoader($view);

		// set uikit ###'.$TARGET.'_GOOGLECHART_LOADER###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GOOGLECHART_LOADER###'] = $this->setGoogleChartLoader($view);

		// set uikit ###FOOTABLE_LOADER###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_FOOTABLE_LOADER###'] = $this->setFootableScriptsLoader($view);

		// set metadata ###DOCUMENT_METADATA###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_METADATA###'] = $this->setDocumentMetadata($view);

		// set custom php scripting ###DOCUMENT_CUSTOM_PHP###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_CUSTOM_PHP###'] = $this->setDocumentCustomPHP($view);

		// set custom css ###DOCUMENT_CUSTOM_CSS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_CUSTOM_CSS###'] = $this->setDocumentCustomCSS($view);

		// set custom javascript ###DOCUMENT_CUSTOM_JS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_CUSTOM_JS###'] = $this->setDocumentCustomJS($view);

		// set custom css file ###VIEWCSS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_VIEWCSS###'] = $this->setCustomCSS($view);

		// set the custom buttons ###CUSTOM_BUTTONS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_CUSTOM_BUTTONS###'] = $this->setCustomButtons($view);
		
		// only set the custom get form method if site target
		if ('site' == $this->target)
		{
			// set the custom get form method  ###SITE_CUSTOM_GET_FORM_METHOD###
			$this->fileContentDynamic[$view['settings']->code]['###SITE_CUSTOM_GET_FORM_METHOD###'] = $this->setCustomGetForm($view);
		}
		
		// see if we should add get modules to the view.html
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GET_MODULE###'] = $this->setGetModules($view,$TARGET);
		
	}
	
	protected function setGetModules($view,$TARGET)
	{
		if ($this->getModule[$this->target][$view['settings']->code])
		{
			$addModule = array();
			$addModule[] = "\n\n\t/**";
			$addModule[] = "\t * Get the modules published in a position";
			$addModule[] = "\t */";
			$addModule[] = "\tpublic function getModules(\$position, \$seperator = '', \$class = '')";
			$addModule[] = "\t{";
			$addModule[] = "\t\t//".$this->setLine(__LINE__)." set default";
			$addModule[] = "\t\t\$found = false;";
			$addModule[] = "\t\t//".$this->setLine(__LINE__)." check if we aleady have these modules loaded";
			$addModule[] = "\t\tif (isset(\$this->setModules[\$position]))";
			$addModule[] = "\t\t{";
			$addModule[] = "\t\t\t\$found = true;";
			$addModule[] = "\t\t}";
			$addModule[] = "\t\telse";
			$addModule[] = "\t\t{";
			$addModule[] = "\t\t\t//".$this->setLine(__LINE__)." this is where you want to load your module position";
			$addModule[] = "\t\t\t\$modules = JModuleHelper::getModules(\$position);";
			$addModule[] = "\t\t\tif (\$modules)";
			$addModule[] = "\t\t\t{";
			$addModule[] = "\t\t\t\t//".$this->setLine(__LINE__)." set the place holder";
			$addModule[] = "\t\t\t\t\$this->setModules[\$position] = array();";
			$addModule[] = "\t\t\t\tforeach(\$modules as \$module)";
			$addModule[] = "\t\t\t\t{";
			$addModule[] = "\t\t\t\t\t\$this->setModules[\$position][] = JModuleHelper::renderModule(\$module);";
			$addModule[] = "\t\t\t\t}";
			$addModule[] = "\t\t\t\t\$found = true;";
			$addModule[] = "\t\t\t}";
			$addModule[] = "\t\t}";
			$addModule[] = "\t\t//".$this->setLine(__LINE__)." check if modules were found";
			$addModule[] = "\t\tif (\$found && isset(\$this->setModules[\$position]) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$this->setModules[\$position]))";
			$addModule[] = "\t\t{";
			$addModule[] = "\t\t\t//".$this->setLine(__LINE__)." set class";
			$addModule[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkString(\$class))";
			$addModule[] = "\t\t\t{";
			$addModule[] = "\t\t\t\t\$class = ' class=\"'.\$class.'\" ';";
			$addModule[] = "\t\t\t}";
			$addModule[] = "\t\t\t//".$this->setLine(__LINE__)." set seperating return values";
			$addModule[] = "\t\t\tswitch(\$seperator)";
			$addModule[] = "\t\t\t{";
			$addModule[] = "\t\t\t\tcase 'none':";
			$addModule[] = "\t\t\t\t\treturn implode('', \$this->setModules[\$position]);";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tcase 'div':";
			$addModule[] = "\t\t\t\t\treturn '<div'.\$class.'>'.implode('</div><div'.\$class.'>', \$this->setModules[\$position]).'</div>';";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tcase 'list':";
			$addModule[] = "\t\t\t\t\treturn '<ul'.\$class.'><li>'.implode('</li><li>', \$this->setModules[\$position]).'</li></ul>';";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tcase 'array':";
			$addModule[] = "\t\t\t\tcase 'Array':";
			$addModule[] = "\t\t\t\t\treturn \$this->setModules[\$position];";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tdefault:";
			$addModule[] = "\t\t\t\t\treturn implode('<br />', \$this->setModules[\$position]);";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\t";
			$addModule[] = "\t\t\t}";
			$addModule[] = "\t\t}";
			$addModule[] = "\t\treturn false;";
			$addModule[] = "\t}";
			
			$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GET_MODULE_JIMPORT###'] = "\njimport('joomla.application.module.helper');";
			
			return implode("\n",$addModule);
		}	
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GET_MODULE_JIMPORT###'] = '';
		return '';
	}

	protected function setCustomGetForm($view)
	{
		return '';
	}

	protected function setDocumentCustomPHP($view)
	{
		if ($view['settings']->add_php_document == 1)
		{
			$view['settings']->php_document = (array) explode("\n",$view['settings']->php_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->php_document))
			{
				return str_replace(array_keys($this->placeholders),array_values($this->placeholders),"\n\t\t".implode("\n\t\t",$view['settings']->php_document));
			}
		}
		return '';
	}

	protected function setCustomButtons($view)
	{
		// ensure correct target is set
		$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
		// set the custom buttons ###CUSTOM_BUTTONS_CONTROLLER###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_CUSTOM_BUTTONS_CONTROLLER###'] = '';
		// set the custom buttons ###CUSTOM_BUTTONS_METHOD###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_CUSTOM_BUTTONS_METHOD###'] = '';
		// if site add buttons to view
		if ($this->target == 'site')
		{
			// set the custom buttons ###SITE_TOP_BUTTON###
			$this->fileContentDynamic[$view['settings']->code]['###SITE_TOP_BUTTON###'] = '';
			// set the custom buttons ###SITE_BOTTOM_BUTTON###
			$this->fileContentDynamic[$view['settings']->code]['###SITE_BOTTOM_BUTTON###'] = '';
			// load into place
			switch ($view['settings']->button_position)
			{
				case 1:
					// set buttons to top right of the view
					$this->fileContentDynamic[$view['settings']->code]['###SITE_TOP_BUTTON###'] = '<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>';
					break;
				case 2:
					// set buttons to top left of the view
					$this->fileContentDynamic[$view['settings']->code]['###SITE_TOP_BUTTON###'] = '<?php echo $this->toolbar->render(); ?>';
					break;
				case 3:
					// set buttons to buttom right of the view
					$this->fileContentDynamic[$view['settings']->code]['###SITE_BOTTOM_BUTTON###'] = '<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>';
					break;
				case 4:
					// set buttons to buttom left of the view
					$this->fileContentDynamic[$view['settings']->code]['###SITE_BOTTOM_BUTTON###'] = '<?php echo $this->toolbar->render(); ?>';
					break;
				case 5:
					// set buttons to buttom left of the view
					$this->placeholders['[[[SITE_TOOLBAR]]]'] = '<?php echo $this->toolbar->render(); ?>';
					break;
					
			}

		}
		// check if custom button should be added
		if (isset($view['settings']->add_custom_button) && $view['settings']->add_custom_button == 1)
		{
			if (ComponentbuilderHelper::checkArray($view['settings']->custom_buttons))
			{
				$buttons = array();
				foreach ($view['settings']->custom_buttons as $custom_button)
				{
					if ($custom_button['target'] != 2 || $this->target == 'site')
					{
						// Load to lang
						$keyLang = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($custom_button['name'],'U');
                                                $keyCode = ComponentbuilderHelper::safeString($custom_button['name']);
						$this->langContent[$this->lang][$keyLang] = trim($custom_button['name']);
						// add cpanel button
						$buttons[] = "\t\tif (\$this->canDo->get('".$view['settings']->code.".".$keyCode."'))";
						$buttons[] = "\t\t{";
						$buttons[] = "\t\t\t//".$this->setLine(__LINE__)." add ".$custom_button['name']." button.";
						$buttons[] = "\t\t\tJToolBarHelper::custom('".$view['settings']->code.".".$custom_button['method']."', '".$custom_button['icomoon']."', '', '".$keyLang."', false);";
						$buttons[] = "\t\t}";
					}
				}
				if (ComponentbuilderHelper::checkArray($buttons))
				{
					if (ComponentbuilderHelper::checkString($view['settings']->php_controller))
					{
						// set the custom buttons ###CUSTOM_BUTTONS_CONTROLLER###
						$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_CUSTOM_BUTTONS_CONTROLLER###'] =
						"\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$view['settings']->php_controller);
						if ('site' == $this->target)
						{
							// add the controller for this view
							// build the file
							$target = array($this->target => $view['settings']->code);
							$this->buildDynamique($target,'custom_form');
							###GET_FORM_CUSTOM###
						}
					}
					if (ComponentbuilderHelper::checkString($view['settings']->php_model))
					{
						// set the custom buttons ###CUSTOM_BUTTONS_METHOD###
						$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_CUSTOM_BUTTONS_METHOD###'] =
						"\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$view['settings']->php_model);
					}

					return "\n".implode("\n",$buttons);
				}
			}
		}
		return '';
	}

	protected function setCustomCSS($view)
	{
		if ($view['settings']->add_css == 1)
		{
			if (ComponentbuilderHelper::checkString($view['settings']->css))
			{
				return str_replace(array_keys($this->placeholders),array_values($this->placeholders),$view['settings']->css);
			}
		}
		return '';
	}

	protected function setDocumentCustomCSS($view)
	{
		if ($view['settings']->add_css_document == 1)
		{
			$view['settings']->css_document = (array) explode("\n",$view['settings']->css_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->css_document))
			{
				$script = "\n\t\t//".$this->setLine(__LINE__)." Set the Custom CSS script to view\n\t\t".'$this->document->addStyleDeclaration("';
				$cssDocument = str_replace('"', '\"', implode("\n\t\t\t",$view['settings']->css_document));
				return $script.str_replace(array_keys($this->placeholders),array_values($this->placeholders),"\n\t\t\t".$cssDocument)."\n\t\t".'");';
			}
		}
		return '';
	}

	protected function setDocumentCustomJS($view)
	{
		if ($view['settings']->add_js_document == 1)
		{
			$view['settings']->js_document = (array) explode("\n",$view['settings']->js_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->js_document))
			{
				$script = "\n\t\t//".$this->setLine(__LINE__)." Set the Custom JS script to view\n\t\t".'$this->document->addScriptDeclaration("';
				$jsDocument = str_replace('"', '\"', implode("\n\t\t\t",$view['settings']->js_document));
				return $script.str_replace(array_keys($this->placeholders),array_values($this->placeholders),"\n\t\t\t".$jsDocument)."\n\t\t".'");';
			}
		}
		return '';
	}

	protected function setFootableScriptsLoader($view)
	{
		if (isset($this->footableScripts[$this->target][$view['settings']->code]) && $this->footableScripts[$this->target][$view['settings']->code])
		{
			return $this->setFootableScripts(false,'$this->document');
		}
		return '';
	}

	protected function setDocumentMetadata($view)
	{
		if ($view['settings']->main_get->gettype == 1 && $view['metadata'] == 1)
		{
			return $this->setMetadataItem();
		}
		elseif ($view['metadata'] == 1)
		{
			// lets check if we have a custom get method that has the same name as the view
			// if we do then it posibly can be that the metadata is loaded via that method
			// and we can load the full metadata structure with its vars
			if (isset($view['settings']->custom_get) && ComponentbuilderHelper::checkArray($view['settings']->custom_get))
			{
				$found = false;
				$searchFor = 'get'.$view['settings']->Code;
				foreach ($view['settings']->custom_get as $custom_get)
				{
					if ($searchFor == $custom_get->getcustom)
					{
						$found = true;
						break;
					}
				}
				// now lets see
				if ($found)
				{
					return $this->setMetadataItem($view['settings']->code);
				}
				else
				{
					return $this->setMetadataList();
				}
			}
			else
			{
				return $this->setMetadataList();
			}
		}
		return '';
	}
	
	protected function setMetadataItem($item = 'item')
	{
		$meta = array();
		$meta[] = "\n\t\t//".$this->setLine(__LINE__)." load the meta description";
		$meta[] = "\t\tif (isset(\$this->".$item."->metadesc) && \$this->".$item."->metadesc)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setDescription(\$this->".$item."->metadesc);";
		$meta[] = "\t\t}";
		$meta[] = "\t\telseif (\$this->params->get('menu-meta_description'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." load the key words if set";
		$meta[] = "\t\tif (isset(\$this->".$item."->metakey) && \$this->".$item."->metakey)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('keywords', \$this->".$item."->metakey);";
		$meta[] = "\t\t}";
		$meta[] = "\t\telseif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check the robot params";
		$meta[] = "\t\tif (isset(\$this->".$item."->robots) && \$this->".$item."->robots)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('robots', \$this->".$item."->robots);";
		$meta[] = "\t\t}";
		$meta[] = "\t\telseif (\$this->params->get('robots'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check if autor is to be set";
		$meta[] = "\t\tif (isset(\$this->".$item."->created_by) && \$this->params->get('MetaAuthor') == '1')";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetaData('author', \$this->".$item."->created_by);";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check if metadata is available";
		$meta[] = "\t\tif (isset(\$this->".$item."->metadata) && \$this->".$item."->metadata)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$mdata = json_decode(\$this->".$item."->metadata,true);";
		$meta[] = "\t\t\tforeach (\$mdata as \$k => \$v)";
		$meta[] = "\t\t\t{";
		$meta[] = "\t\t\t\tif (\$v)";
		$meta[] = "\t\t\t\t{";
		$meta[] = "\t\t\t\t\t\$this->document->setMetadata(\$k, \$v);";
		$meta[] = "\t\t\t\t}";
		$meta[] = "\t\t\t}";
		$meta[] = "\t\t}";

		return implode("\n",$meta);
	}
	
	protected function setMetadataList()
	{
		$meta = array();
		$meta[] = "\n\t\t//".$this->setLine(__LINE__)." load the meta description";
		$meta[] = "\t\tif (\$this->params->get('menu-meta_description'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." load the key words if set";
		$meta[] = "\t\tif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check the robot params";
		$meta[] = "\t\tif (\$this->params->get('robots'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = "\t\t}";

		return implode("\n",$meta);
	}

	protected function setGoogleChartLoader($view)
	{
		if (isset($this->googleChart[$this->target][$view['settings']->code]) && $this->googleChart[$this->target][$view['settings']->code])
		{
			$chart = array();
			$chart[] = "\n\n\t\t//".$this->setLine(__LINE__)." add the google chart builder class.";
			$chart[] = "\t\trequire_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/chartbuilder.php';";
			$chart[] = "\t\t//".$this->setLine(__LINE__)." load the google chart js.";
			$chart[] = "\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/js/google.jsapi.js');";
			$chart[] = "\t\t\$this->document->addScript('https://canvg.googlecode.com/svn/trunk/rgbcolor.js');";
			$chart[] = "\t\t\$this->document->addScript('https://canvg.googlecode.com/svn/trunk/canvg.js');";
			return implode("\n",$chart);
		}
		return '';
	}

	protected function setUikitLoader($view)
	{
		// reset buktes
		$setter = '';
		$loader['css'] = array();
		$loader['js'] = array();
		// allways load these in
		$setter .= "\n\n\t\t//".$this->setLine(__LINE__)." always make sure jquery is loaded.";
		$setter .= "\n\t\tJHtml::_('jquery.framework');";
		$setter .= "\n\t\t//".$this->setLine(__LINE__)." Load the header checker class.";
		$setter .= "\n\t\trequire_once( JPATH_COMPONENT_SITE.'/helpers/headercheck.php' );";
		$setter .= "\n\t\t//".$this->setLine(__LINE__)." Initialize the header checker.";
		$setter .= "\n\t\t\$HeaderCheck = new HeaderCheck;";
		// load the defaults needed
		if ($this->uikit)
		{
			$setter .= "\n\n\t\t//".$this->setLine(__LINE__)." Load uikit options.";
			$setter .= "\n\t\t\$uikit = \$this->params->get('uikit_load');";
			$setter .= "\n\t\t//".$this->setLine(__LINE__)." Set script size.";
			$setter .= "\n\t\t\$size = \$this->params->get('uikit_min');";
			$setter .= "\n\t\t//".$this->setLine(__LINE__)." Set css style.";
			$setter .= "\n\t\t\$style = \$this->params->get('uikit_style');";

			$setter .= "\n\n\t\t//".$this->setLine(__LINE__)." The uikit css.";
			$setter .= "\n\t\tif ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= "\n\t\t{";
			$setter .= "\n\t\t\t\$this->document->addStyleSheet(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/uikit'.\$style.\$size.'.css');";
			$setter .= "\n\t\t}";
			$setter .= "\n\t\t//".$this->setLine(__LINE__)." The uikit js.";
			$setter .= "\n\t\tif ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= "\n\t\t{";
			$setter .= "\n\t\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/uikit'.\$size.'.js');";
			$setter .= "\n\t\t}";
		}
		// load the components need
		if ($this->uikit && isset($this->uikitComp[$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->uikitComp[$view['settings']->code]))
		{
			$setter .= "\n\n\t\t//".$this->setLine(__LINE__)." Load the script to find all uikit components needed.";
			$setter .= "\n\t\tif (\$uikit != 2)";
			$setter .= "\n\t\t{";
			$setter .= "\n\t\t\t//".$this->setLine(__LINE__)." Set the default uikit components in this view.";
			$setter .= "\n\t\t\t\$uikitComp = array();";
			foreach ($this->uikitComp[$view['settings']->code] as $class)
			{
				$setter .= "\n\t\t\t\$uikitComp[] = '".$class."';";
			}
			// check content for more needed components
			if (isset($this->siteFieldData['uikit'][$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->siteFieldData['uikit'][$view['settings']->code]))
			{
				$setter .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Get field uikit components needed in this view.";
				$setter .= "\n\t\t\t\$uikitFieldComp = \$this->get('UikitComp');";
				$setter .= "\n\t\t\tif (isset(\$uikitFieldComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitFieldComp))";
				$setter .= "\n\t\t\t{";
				$setter .= "\n\t\t\t\tif (isset(\$uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitComp))";
				$setter .= "\n\t\t\t\t{";
				$setter .= "\n\t\t\t\t\t\$uikitComp = array_merge(\$uikitComp, \$uikitFieldComp);";
				$setter .= "\n\t\t\t\t\t\$uikitComp = array_unique(\$uikitComp);";
				$setter .= "\n\t\t\t\t}";
				$setter .= "\n\t\t\t\telse";
				$setter .= "\n\t\t\t\t{";
				$setter .= "\n\t\t\t\t\t\$uikitComp = \$uikitFieldComp;";
				$setter .= "\n\t\t\t\t}";
				$setter .= "\n\t\t\t}";
			}
			$setter .= "\n\t\t}";
			$setter .= "\n\n\t\t//".$this->setLine(__LINE__)." Load the needed uikit components in this view.";
			$setter .= "\n\t\tif (\$uikit != 2 && isset(\$uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitComp))";
			$setter .= "\n\t\t{";
			$setter .= "\n\t\t\t//".$this->setLine(__LINE__)." load just in case.";
			$setter .= "\n\t\t\tjimport('joomla.filesystem.file');";
			$setter .= "\n\t\t\t//".$this->setLine(__LINE__)." loading...";
			$setter .= "\n\t\t\tforeach (\$uikitComp as \$class)";
			$setter .= "\n\t\t\t{";
			$setter .= "\n\t\t\t\tforeach (".$this->fileContentStatic['###Component###']."Helper::\$uk_components[\$class] as \$name)";
			$setter .= "\n\t\t\t\t{";
			$setter .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." check if the CSS file exists.";
			$setter .= "\n\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= "\n\t\t\t\t\t{";
			$setter .= "\n\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the css.";
			$setter .= "\n\t\t\t\t\t\t\$this->document->addStyleSheet(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css');";
			$setter .= "\n\t\t\t\t\t}";
			$setter .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." check if the JavaScript file exists.";
			$setter .= "\n\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js'))";
			$setter .= "\n\t\t\t\t\t{";
			$setter .= "\n\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the js.";
			$setter .= "\n\t\t\t\t\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js');";
			$setter .= "\n\t\t\t\t\t}";
			$setter .= "\n\t\t\t\t}";
			$setter .= "\n\t\t\t}";
			$setter .= "\n\t\t}";
		}
		elseif ($this->uikit && ComponentbuilderHelper::checkArray($this->siteFieldData['uikit'][$view['settings']->code]))
		{
			$setter .= "\n\n\t\t//".$this->setLine(__LINE__)." Load the needed uikit components in this view.";
			$setter .= "\n\t\t\$uikitComp = \$this->get('UikitComp');";
			$setter .= "\n\t\tif (\$uikit != 2 && isset(\$uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitComp))";
			$setter .= "\n\t\t{";
			$setter .= "\n\t\t\t//".$this->setLine(__LINE__)." load just in case.";
			$setter .= "\n\t\t\tjimport('joomla.filesystem.file');";
			$setter .= "\n\t\t\t//".$this->setLine(__LINE__)." loading...";
			$setter .= "\n\t\t\tforeach (\$uikitComp as \$class)";
			$setter .= "\n\t\t\t{";
			$setter .= "\n\t\t\t\tforeach (".$this->fileContentStatic['###Component###']."Helper::\$uk_components[\$class] as \$name)";
			$setter .= "\n\t\t\t\t{";
			$setter .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." check if the CSS file exists.";
			$setter .= "\n\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= "\n\t\t\t\t\t{";
			$setter .= "\n\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the css.";
			$setter .= "\n\t\t\t\t\t\t\$this->document->addStyleSheet(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css');";
			$setter .= "\n\t\t\t\t\t}";
			$setter .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." check if the JavaScript file exists.";
			$setter .= "\n\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js'))";
			$setter .= "\n\t\t\t\t\t{";
			$setter .= "\n\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the js.";
			$setter .= "\n\t\t\t\t\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js');";
			$setter .= "\n\t\t\t\t\t}";
			$setter .= "\n\t\t\t\t}";
			$setter .= "\n\t\t\t}";
			$setter .= "\n\t\t}";
		}
		return $setter;
	}

	protected function setCustomViewExtraDisplayMethods(&$view)
	{
		if ($view['settings']->add_php_jview == 1)
		{
			return str_replace(array_keys($this->placeholders),array_values($this->placeholders),"\n\n".$view['settings']->php_jview);
		}
		return '';
	}

	protected function setCustomViewBody(&$view)
	{
		if (ComponentbuilderHelper::checkString($view['settings']->default))
		{
			if ($view['settings']->main_get->gettype == 2 && $view['settings']->main_get->pagination == 1)
			{
				// build body
				$body = array();
				// add limit box
				if (strpos($view['settings']->default, '[[[LIMITBOX]]]') !== false)
				{
					$this->placeholders['[[[LIMITBOX]]]'] = '<?php echo $this->pagination->getLimitBox(); ?>';
				}
				$body[] = str_replace(array_keys($this->placeholders),array_values($this->placeholders),$view['settings']->default);
				$body[] = "\n".'<?php if (isset($this->items) && '.$this->fileContentStatic['###component###'].'Helper::checkArray($this->items) && count($this->items) > 4): ?>';
				$body[] = '<form name="adminForm" method="post">';
				$body[] = "\t".'<div class="pagination">';
				$body[] = "\t\t".'<?php if ($this->params->def(\'show_pagination_results\', 1)) : ?>';
				
				if (strpos($view['settings']->default, '[[[LIMITBOX]]]') === false)
				{
					$body[] = "\t\t\t".'<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>';
				}
				else
				{
					$body[] = "\t\t\t".'<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>';
				}
				$body[] = "\t\t".'<?php endif; ?>';
				$body[] = "\t\t".'<?php echo $this->pagination->getPagesLinks(); ?>';
				$body[] = "\t".'</div>';
				$body[] = '</form>';
				$body[] = '<?php endif; ?>';
				
				return implode("\n",$body);
			}
			else
			{
				return "\n". str_replace(array_keys($this->placeholders),array_values($this->placeholders),$view['settings']->default);
			}
			
		}
		return '';
	}

	protected function setCustomViewCodeBody(&$view)
	{
		if ($view['settings']->add_php_view == 1)
		{
			$view['settings']->php_view = (array) explode("\n",$view['settings']->php_view);
			if (ComponentbuilderHelper::checkArray($view['settings']->php_view))
			{
				return str_replace(array_keys($this->placeholders),array_values($this->placeholders),"\n\n".implode("\n",$view['settings']->php_view));
			}
		}
		return '';
	}

	protected function setCustomViewTemplateBody(&$view)
	{
		if (isset($this->templateData[$this->target][$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->templateData[$this->target][$view['settings']->code]))
		{
			foreach ($this->templateData[$this->target][$view['settings']->code] as $template => $data)
			{
				// build the file
				$target = array($this->target => $view['settings']->code);
				$this->buildDynamique($target,'template',$template);
				// set the file data
				$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
				// ###SITE_TEMPLATE_BODY### <<<DYNAMIC>>>
				$this->fileContentDynamic[$view['settings']->code.'_'.$template]['###'.$TARGET.'_TEMPLATE_BODY###'] = "\n" . str_replace(array_keys($this->placeholders),array_values($this->placeholders),$data['html']);
				// ###SITE_TEMPLATE_CODE_BODY### <<<DYNAMIC>>>
				$this->fileContentDynamic[$view['settings']->code.'_'.$template]['###'.$TARGET.'_TEMPLATE_CODE_BODY###'] = $this->setCustomViewTemplateCode($data['php_view']);
			}
		}
	}

	protected function setCustomViewTemplateCode(&$php)
	{
		if (ComponentbuilderHelper::checkString($php))
		{
			$php_view = (array) explode("\n",$php);
			if (ComponentbuilderHelper::checkArray($php_view))
			{
				$php_view = "\n\n".implode("\n",$php_view);
				return str_replace(array_keys($this->placeholders),array_values($this->placeholders),$php_view);
			}
		}
		return '';
	}

	protected function setCustomViewLayouts()
	{
		if (isset($this->layoutData[$this->target]) && ComponentbuilderHelper::checkArray($this->layoutData[$this->target]))
		{
			foreach ($this->layoutData[$this->target] as $layout => $data)
			{
				// build the file
				$target = array($this->target => $layout);
				$this->buildDynamique($target,'layout');
				// set the file data
				$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
				// ###SITE_LAYOUT_CODE### <<<DYNAMIC>>>
				$php_view = (array) explode("\n",$data['php_view']);
				if (ComponentbuilderHelper::checkArray($php_view))
				{
					$php_view = "\n\n".implode("\n",$php_view);
					$this->fileContentDynamic[$layout]['###'.$TARGET.'_LAYOUT_CODE###'] = str_replace(array_keys($this->placeholders),array_values($this->placeholders),$php_view);
				}
				else
				{
					$this->fileContentDynamic[$layout]['###'.$TARGET.'_LAYOUT_CODE###'] = '';
				}
				// ###SITE_LAYOUT_BODY### <<<DYNAMIC>>>
				$this->fileContentDynamic[$layout]['###'.$TARGET.'_LAYOUT_BODY###'] = "\n" . str_replace(array_keys($this->placeholders),array_values($this->placeholders),$data['html']);

			}
		}
	}

	protected function getReplacementNames()
	{
		foreach ($this->newFiles as $type => $files)
		{
			foreach ($files as $view => $file)
			{
				if (isset($file['path']) && ComponentbuilderHelper::checkArray($file))
				{
					if (JFile::exists($file['path']))
					{
						$string = file_get_contents($file['path']);
						$buket['static'][] = $this->getInbetweenStrings($string);
					}
				}
				elseif (ComponentbuilderHelper::checkArray($file))
				{
					foreach ($file as $nr => $doc)
					{
						if (ComponentbuilderHelper::checkArray($doc))
						{
							if (JFile::exists($doc['path']))
							{
								$string = file_get_contents($doc['path']);
								$buket[$view][] = $this->getInbetweenStrings($string);
							}
						}
					}
				}
			}
		}
		foreach ($buket as $type => $array)
		{
			foreach ($array as $replacments)
			{
				$replacments = array_unique($replacments);
				foreach ($replacments as $replacment)
				{
					if ($type != 'static')
					{
						//var_dump($replacment); echo "\n";
						$echos[$replacment] = "###".$replacment."###<br />";
					}
					elseif ($type == 'static')
					{
						//var_dump($replacment); echo "\n";
						$echos[$replacment] = "###".$replacment."###<br />";
					}
				}
			}
		}

		foreach ($echos as $echo)
		{
			echo $echo.'<br />';
		}
	}

	protected function updateFiles()
	{
		if (isset($this->newFiles['static']) && ComponentbuilderHelper::checkArray($this->newFiles['static']) && isset($this->newFiles['dynamic']) && ComponentbuilderHelper::checkArray($this->newFiles['dynamic']))
		{
			// get the bom file
			$bom = JFile::read($this->bomPath);
			// first we do the static files
			foreach ($this->newFiles['static'] as $static)
			{
				if (JFile::exists($static['path']))
				{
					$this->fileContentStatic['###FILENAME###'] = $static['name'];
					$php = '';
					if (ComponentbuilderHelper::checkFileType($static['name'],'php'))
					{
						$php = "<?php\n";
					}
					$string = JFile::read($static['path']);
					if (strpos($string,'###BOM###') !== false)
					{
						list($wast,$code) = explode('###BOM###',$string);
						$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$php.$bom.$code);
						// add to zip array
						$this->writeFile($static['path'],$answer);
					}
					else
					{
						$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$string);
						// add to zip array
						$this->writeFile($static['path'],$answer);
					}
					$this->lineCount = $this->lineCount + substr_count($answer, PHP_EOL );
				}
			}
			// now we do the dynamic files
			foreach ($this->newFiles['dynamic'] as $view => $files)
			{
				if (isset($this->fileContentDynamic[$view]) && ComponentbuilderHelper::checkArray($this->fileContentDynamic[$view]))
				{
					foreach ($files as $file)
					{
						if ($file['view'] == $view)
						{
							if (JFile::exists($file['path']))
							{
								$this->fileContentStatic['###FILENAME###'] = $file['name'];
								$php = '';
								if (ComponentbuilderHelper::checkFileType($file['name'],'php'))
								{
									$php = "<?php\n";
								}
								$string = JFile::read($file['path']);
								if (strpos($string,'###BOM###') !== false)
								{
									list($bin,$code) = explode('###BOM###',$string);
									$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$php.$bom.$code);
									$answer = str_replace(array_keys($this->fileContentDynamic[$view]),array_values($this->fileContentDynamic[$view]),$answer);
									// add to zip array
									$this->writeFile($file['path'],$answer);
								}
								else
								{
									$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$string);
									$answer = str_replace(array_keys($this->fileContentDynamic[$view]),array_values($this->fileContentDynamic[$view]),$answer);
									// add to zip array
									$this->writeFile($file['path'],$answer);
								}
								$this->lineCount = $this->lineCount + substr_count($answer, PHP_EOL );
							}
						}
					}
				}
			}
			// do a final run to update the readme file
			foreach ($this->newFiles['static'] as $static)
			{
				if ($this->componentData->addreadme && 'README.md' == $static['name'] && JFile::exists($static['path']))
				{
					$this->buildReadMe($static['path']);
					break;
				}
			}
			// move the update server to host
			if ($this->componentData->add_update_server && isset($this->updateServerFileName) && $this->add2SalesServer)
			{
				$xml_update_server_path = $this->componentPath.'/'.$this->updateServerFileName.'.xml';
				// make sure we have the correct file
				if (JFile::exists($xml_update_server_path) && isset($this->componentData->update_server_ftp))
				{
					// Get the basic encription.
					$basickey = ComponentbuilderHelper::getCryptKey('basic');
					// Get the encription object.
					$basic = new FOFEncryptAes($basickey, 128);
					if (!empty($this->componentData->update_server_ftp) && $basickey && !is_numeric($this->componentData->update_server_ftp) && $this->componentData->update_server_ftp === base64_encode(base64_decode($this->componentData->update_server_ftp, true)))
					{
						// basic decript data update_server_ftp.
						$this->componentData->update_server_ftp = rtrim($basic->decryptString($this->componentData->update_server_ftp), "\0");
					}
					// now move the file
					$this->moveFileToFtpServer($xml_update_server_path,$this->componentData->update_server_ftp);
				}
			}
			return true;
		}
		return false;
	}
	
	protected function moveFileToFtpServer($localPath, $clientInput, $remote = null, $removeLocal = true)
	{
		// get the ftp opbject
		$ftp = $this->getFTP($clientInput);
		// chack if we are conected
		if ($ftp instanceof JClientFtp && $ftp->isConnected())
		{
			// move the file
			if ($ftp->store($localPath,$remote))
			{
				// if moved then remove the file from repository
				if ($removeLocal)
				{
					JFile::delete($localPath);
				}
			}
			// at the end close the conection
			$ftp->quit();
		}
	}
	
	protected function getFTP($clientInput)
	{
		$signature = md5($clientInput);
		if (isset($this->FTP[$signature]) && $this->FTP[$signature] instanceof JClientFtp)
		{
			return $this->FTP[$signature];
		}
		else
		{
			// make sure we have a string and it is not default or empty
			if (ComponentbuilderHelper::checkString($clientInput))
			{
				// turn into vars
				parse_str($clientInput);
				// set options
				if (isset($options) && ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option => $value)
					{
						if ('timeout' == $option)
						{
							$options[$option] = (int) $value;
						}
						if ('type' == $option)
						{
							$options[$option] = (string) $value;
						}
					}
				}
				else
				{
					$options = array();
				}
				// get ftp object
				if (isset($host) && $host != 'HOSTNAME' && isset($port) && $port != 'PORT_INT' && isset($username) && $username != 'user@name.com' && isset($password) && $password != 'password')
				{
					// load for reuse
					$this->FTP[$signature] = JClientFtp::getInstance($host, $port, $options, $username, $password);
					return $this->FTP[$signature];
				}
			}
		}
		return false;
	}
	
	protected function buildReadMe($path)
	{
		// setup the unrealistic numbers
		$folders	= $this->folderCount * 5;
		$files		= $this->fileCount * 5;
		$lines		= $this->lineCount * 10;
		$seconds	= $folders + $files + $lines;
		$totalHours	= round($seconds / 3600);
		$totalDays	= round($totalHours / 8);
		// setup the more realistic numbers
		$debugging		= $seconds / 4;
		$planning		= $seconds / 7;
		$mapping		= $seconds / 10;
		$office			= $seconds / 6;
		$seconds		= $folders + $files + $lines + $debugging + $planning + $mapping + $office;
		$actualTotalHours	= round($seconds / 3600);
		$actualTotalDays	= round($actualTotalHours / 8);
		$debuggingHours		= round($debugging / 3600);
		$planningHours		= round($planning / 3600);
		$mappingHours		= round($mapping / 3600);
		$officeHours		= round($office / 3600);
		// the actual time spent
		$actualHoursSpent = $actualTotalHours - $totalHours;
		$actualDaysSpent = $actualTotalDays - $totalDays;
		// calculate the projects actual time frame of completion
		$projectWeekTime = round($actualTotalDays / 5,1);
		$projectMonthTime = round($actualTotalDays / 24,1);
		// set some defaults
		$this->fileContentStatic['###LINE_COUNT###'] = $this->lineCount;
		$this->fileContentStatic['###FILE_COUNT###'] = $this->fileCount;
		$this->fileContentStatic['###FOLDER_COUNT###'] = $this->folderCount;
		$this->fileContentStatic['###folders###'] = $folders;
		$this->fileContentStatic['###files###'] = $files;
		$this->fileContentStatic['###lines###'] = $lines;
		$this->fileContentStatic['###seconds###'] = $seconds;
		$this->fileContentStatic['###totalHours###'] = $totalHours;
		$this->fileContentStatic['###totalDays###'] = $totalDays;
		$this->fileContentStatic['###debugging###'] = $debugging;
		$this->fileContentStatic['###planning###'] = $planning;
		$this->fileContentStatic['###mapping###'] = $mapping;
		$this->fileContentStatic['###office###'] = $office;
		$this->fileContentStatic['###actualTotalHours###'] = $actualTotalHours;
		$this->fileContentStatic['###actualTotalDays###'] = $actualTotalDays;
		$this->fileContentStatic['###debuggingHours###'] = $debuggingHours;
		$this->fileContentStatic['###planningHours###'] = $planningHours;
		$this->fileContentStatic['###mappingHours###'] = $mappingHours;
		$this->fileContentStatic['###officeHours###'] = $officeHours;
		$this->fileContentStatic['###actualHoursSpent###'] = $actualHoursSpent;
		$this->fileContentStatic['###actualDaysSpent###'] = $actualDaysSpent;
		$this->fileContentStatic['###projectWeekTime###'] = $projectWeekTime;
		$this->fileContentStatic['###projectMonthTime###'] = $projectMonthTime;
		// get the file
		$string = JFile::read($path);
		// update the file
		$answer = str_replace(array_keys($this->fileContentStatic),array_values($this->fileContentStatic),$string);
		// add to zip array
		$this->writeFile($path,$answer);
	}

	protected function zipComponent()
	{
		// before we zip the component we first need to move it to the git folder if set
		if (ComponentbuilderHelper::checkString($this->gitPath))
		{
			// set the git path
			$this->gitPath = $this->gitPath.'/com_'.$this->componentData->sales_name.'__joomla_'.$this->joomlaVersion;
			// remove old data
			$this->removeFolder($this->gitPath,true);
			// set the new data
			JFolder::copy($this->componentPath, $this->gitPath, '', true);
		}
		// the name of the zip file to create
		$this->filepath = $this->tempPath.'/'.$this->componentFolderName.'.zip';
		// store the current joomla working directory
		$joomla = getcwd();

		// we are changing the working directory to the componet temp folder
		chdir($this->componentPath);

		// the full file path of the zip file
		$this->filepath = JPath::clean($this->filepath);

		// delete an existing zip file (or use an exclusion parameter in JFolder::files()
		JFile::delete($this->filepath);

		// get a list of files in the current directory tree
		$files = JFolder::files('.', '', true, true);
		$zipArray = array();
		// setup the zip array
		foreach ($files as $file)
		{
		   $tmp = array();
		   $tmp['name'] = str_replace('./', '', $file);
		   $tmp['data'] = JFile::read($file);
		   $tmp['time'] = filemtime($file);
		   $zipArray[] = $tmp;
		}

		// change back to joomla working directory
		chdir($joomla);

		// get the zip adapter
		$zip = JArchive::getAdapter('zip');

		//create the zip file
		if ($zip->create($this->filepath, $zipArray))
		{
			// now move to backup if zip was made and backup is requered
			if ($this->backupPath)
			{
				JFile::copy($this->filepath, $this->backupPath);
			}
			// move to sales server host
			if ($this->componentData->add_sales_server)
			{
				// make sure we have the correct file
				if (isset($this->componentData->sales_server_ftp))
				{
					// Get the basic encription.
					$basickey = ComponentbuilderHelper::getCryptKey('basic');
					// Get the encription object.
					$basic = new FOFEncryptAes($basickey, 128);
					if (!empty($this->componentData->sales_server_ftp) && $basickey && !is_numeric($this->componentData->sales_server_ftp) && $this->componentData->sales_server_ftp === base64_encode(base64_decode($this->componentData->sales_server_ftp, true)))
					{
						// basic decript data update_server_ftp.
						$this->componentData->sales_server_ftp = rtrim($basic->decryptString($this->componentData->sales_server_ftp), "\0");
					}
					// now move the file
					$this->moveFileToFtpServer($this->filepath, $this->componentData->sales_server_ftp, $this->componentSalesName.'.zip',false);
				}
			}
			// remove the component folder since we are done
			if ($this->removeFolder($this->componentPath))
			{
				return true;
			}
		}
		return false;
	}

	protected function removeFolder($dir, $git = false)
	{
		if (JFolder::exists($dir))
		{
			$it = new RecursiveDirectoryIterator($dir);
			$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($it as $file)
			{
				if ('.' === $file->getBasename() || '..' ===  $file->getBasename()) continue;
				if ($file->isDir())
				{
					if ($git && strpos($file->getPathname(), $dir.'/.git') !== false) continue;
					JFolder::delete($file->getPathname());
				}
				else
				{
					if ($git && strpos($file->getPathname(), $dir.'/.git') !== false) continue;
					JFile::delete($file->getPathname());
				}
			}
			if (!$git && JFolder::delete($dir))
			{
				return true;
			}
		}
		return false;
	}

	protected function writeFile($path,$data)
	{
		$fh = fopen($path, "w");
		if (!is_resource($fh))
		{
			return false;
		}
		if (fwrite($fh, $data))
		{
			// close file.
			fclose($fh);
			return true;
		}
		// close file.
		fclose($fh);
		return false;
	}

	protected function setMethodGetItem($view)
	{
		$script = '';
		// go from json to array
		if(isset($this->jsonItemBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonItemBuilder[$view]))
		{
			foreach ($this->jsonItemBuilder[$view] as $jsonItem)
			{
				$script .= "\n\n\t\t\tif (!empty(\$item->".$jsonItem."))";
				$script .= "\n\t\t\t{";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Convert the ".$jsonItem." field to an array.";
				$script .= "\n\t\t\t\t\$".$jsonItem." = new Registry;";
				$script .= "\n\t\t\t\t\$".$jsonItem."->loadString(\$item->".$jsonItem.");";
				$script .= "\n\t\t\t\t\$item->".$jsonItem." = \$".$jsonItem."->toArray();";
				$script .= "\n\t\t\t}";
			}
		}
		// go from json to string
		if (isset($this->jsonStringBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonStringBuilder[$view]))
		{
			$makeArray = '';
			foreach ($this->jsonStringBuilder[$view] as $jsonString)
			{
			$script .= "\n\n\t\t\tif (!empty(\$item->".$jsonString."))";
				$script .= "\n\t\t\t{";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." JSON Decode ".$jsonString.".";
				if (strpos($jsonString, 'group') !== false)
				{
					$makeArray = ',true';
				}
				$script .= "\n\t\t\t\t\$item->".$jsonString." = json_decode(\$item->".$jsonString.$makeArray.");";
				$script .= "\n\t\t\t}";
			}
		}
		// go from base64 to string
		if (isset($this->base64Builder[$view]) && ComponentbuilderHelper::checkArray($this->base64Builder[$view]))
		{
			foreach ($this->base64Builder[$view] as $baseString)
			{
				$script .= "\n\n\t\t\tif (!empty(\$item->".$baseString."))"; // TODO && base64_encode(base64_decode(\$item->".$baseString.", true)) === \$item->".$baseString.")";
				$script .= "\n\t\t\t{";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." base64 Decode ".$baseString.".";
				$script .= "\n\t\t\t\t\$item->".$baseString." = base64_decode(\$item->".$baseString.");";
				$script .= "\n\t\t\t}";
			}
		}
		// decryption
		if ((isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view])) || (isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view])))
		{
			$Component	= $this->fileContentStatic['###Component###'];
			if (isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view]))
			{
				$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Get the basic encription.";
				$script .= "\n\t\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Get the encription object.";
				$script .= "\n\t\t\t\$basic = new FOFEncryptAes(\$basickey, 128);";
				foreach ($this->basicEncryptionBuilder[$view] as $baseString)
				{
					$script .= "\n\n\t\t\tif (!empty(\$item->".$baseString.") && \$basickey && !is_numeric(\$item->".$baseString.") && \$item->".$baseString." === base64_encode(base64_decode(\$item->".$baseString.", true)))";
					$script .= "\n\t\t\t{";
					$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." basic decript data ".$baseString.".";
					$script .= "\n\t\t\t\t\$item->".$baseString." = rtrim(\$basic->decryptString(\$item->".$baseString."), ".'"\0"'.");";
					$script .= "\n\t\t\t}";
				}
			}
			if (isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view]))
			{
				$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Get the advanced encription key.";
				$script .= "\n\t\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Get the encription object.";
				$script .= "\n\t\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
				foreach ($this->advancedEncryptionBuilder[$view] as $baseString)
				{
					$script .= "\n\n\t\t\tif (!empty(\$item->".$baseString.") && \$advancedkey && !is_numeric(\$item->".$baseString.") && \$item->".$baseString." === base64_encode(base64_decode(\$item->".$baseString.", true)))";
					$script .= "\n\t\t\t{";
					$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." advanced decript data ".$baseString.".";
					$script .= "\n\t\t\t\t\$item->".$baseString." = rtrim(\$advanced->decryptString(\$item->".$baseString."), ".'"\0"'.");";
					$script .= "\n\t\t\t}";
				}
			}
		}

		// add custom php to getitem method
		if (isset($this->customScriptBuilder['php_getitem'][$view]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_getitem'][$view]))
		{
			$script .= "\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_getitem'][$view]);
		}

		return $script;
	}

	protected function setCheckboxSave($view)
	{
		$script = '';
		if(isset($this->checkboxBuilder[$view]) && ComponentbuilderHelper::checkArray($this->checkboxBuilder[$view]))
		{
			foreach ($this->checkboxBuilder[$view] as $checkbox)
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Set the empty ".$checkbox." item to data";
				$script .= "\n\t\tif (!isset(\$data['".$checkbox."']))";
				$script .= "\n\t\t{";
				$script .= "\n\t\t\t\$data['".$checkbox."'] = '';";
				$script .= "\n\t\t}";
			}
		}
		return $script;
	}

	protected function setMethodItemSave($view)
	{
		$script = '';
		// turn array into JSON string
		if(isset($this->jsonItemBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonItemBuilder[$view]))
		{
			foreach ($this->jsonItemBuilder[$view] as $jsonItem)
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Set the ".$jsonItem." items to data.";
				$script .= "\n\t\tif (isset(\$data['".$jsonItem."']) && is_array(\$data['".$jsonItem."']))";
				$script .= "\n\t\t{";
				$script .= "\n\t\t\t\$".$jsonItem." = new JRegistry;";
				$script .= "\n\t\t\t\$".$jsonItem."->loadArray(\$data['".$jsonItem."']);";
				$script .= "\n\t\t\t\$data['".$jsonItem."'] = (string) \$".$jsonItem.";";
				$script .= "\n\t\t}";
				$script .= "\n\t\telseif (!isset(\$data['".$jsonItem."']))";
				$script .= "\n\t\t{";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Set the empty ".$jsonItem." to data";
				$script .= "\n\t\t\t\$data['".$jsonItem."'] = '';";
				$script .= "\n\t\t}";
			}
		}
		// turn string into json string
		if(isset($this->jsonStringBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonStringBuilder[$view]))
		{
			foreach ($this->jsonStringBuilder[$view] as $jsonString)
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Set the ".$jsonString." string to JSON string.";
				$script .= "\n\t\tif (isset(\$data['".$jsonString."']))";
				$script .= "\n\t\t{";
				$script .= "\n\t\t\t\$data['".$jsonString."'] = (string) json_encode(\$data['".$jsonString."']);";
				$script .= "\n\t\t}";
			}
		}
		// turn string into base 64 string
		if(isset($this->base64Builder[$view]) && ComponentbuilderHelper::checkArray($this->base64Builder[$view]))
		{
			foreach ($this->base64Builder[$view] as $baseString)
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Set the ".$baseString." string to base64 string.";
				$script .= "\n\t\tif (isset(\$data['".$baseString."']))";
				$script .= "\n\t\t{";
				$script .= "\n\t\t\t\$data['".$baseString."'] = base64_encode(\$data['".$baseString."']);";
				$script .= "\n\t\t}";
			}
		}
		// turn string into encrypted string
		if((isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view])) || (isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view])))
		{
			$Component	= $this->fileContentStatic['###Component###'];
			if(isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view]))
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Get the basic encription key.";
				$script .= "\n\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the encription object";
				$script .= "\n\t\t\$basic = new FOFEncryptAes(\$basickey, 128);";
				foreach ($this->basicEncryptionBuilder[$view] as $baseString)
				{
					$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Encript data ".$baseString.".";
					$script .= "\n\t\tif (isset(\$data['".$baseString."']) && \$basickey)";
					$script .= "\n\t\t{";
					$script .= "\n\t\t\t\$data['".$baseString."'] = \$basic->encryptString(\$data['".$baseString."']);";
					$script .= "\n\t\t}";
				}
			}
			if(isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view]))
			{
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Get the advanced encription key.";
				$script .= "\n\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Get the encription object";
				$script .= "\n\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
				foreach ($this->advancedEncryptionBuilder[$view] as $baseString)
				{
					$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Encript data ".$baseString.".";
					$script .= "\n\t\tif (isset(\$data['".$baseString."']) && \$advancedkey)";
					$script .= "\n\t\t{";
					$script .= "\n\t\t\t\$data['".$baseString."'] = \$advanced->encryptString(\$data['".$baseString."']);";
					$script .= "\n\t\t}";
				}
			}
		}
		// add custom PHP to the save method
		if(isset($this->customScriptBuilder['php_save'][$view]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_save'][$view]))
		{
			$script .= "\n\n" . str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_save'][$view]);
		}
		return $script;
	}
	
	protected function setJmodelAdminBeforeDelete($view)
	{
		// add custom PHP to the delete Method
		if(isset($this->customScriptBuilder['php_before_delete'][$view]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_before_delete'][$view]))
		{
			return "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_before_delete'][$view]);
		}
		return "";
	}
	
	protected function setJmodelAdminAfterDelete($view)
	{
		// add custom PHP to the delete Method
		if(isset($this->customScriptBuilder['php_after_delete'][$view]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_after_delete'][$view]))
		{
			return "\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_after_delete'][$view]);
		}
		return "";
	}

	protected function setPostSaveHook($view)
	{
		// add custom PHP to the post save hook Method
		if(isset($this->customScriptBuilder['php_postsavehook'][$view]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_postsavehook'][$view]))
		{
			return "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_postsavehook'][$view])."\n\n\t\treturn;";
		}
		return "\n\t\treturn;";

	}

	protected function setJtableConstructor($view)
	{
		// reset
		$oserver = "";
		// set component name
		$component	= $this->fileContentStatic['###component###'];
		// add the tags observer
		if (isset($this->tagsBuilder[$view]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$view]))
		{
			$oserver .= "\n\n\t\t//".$this->setLine(__LINE__)." Adding Tag Options";
			$oserver .= "\n\t\tJTableObserverTags::createObserver(\$this, array('typeAlias' => 'com_".$component.".".$view."'));";
		}
		// add the history/version observer
		if (isset($this->historyBuilder[$view]) && ComponentbuilderHelper::checkString($this->historyBuilder[$view]))
		{
			$oserver .= "\n\n\t\t//".$this->setLine(__LINE__)." Adding History Options";
			$oserver .= "\n\t\tJTableObserverContenthistory::createObserver(\$this, array('typeAlias' => 'com_".$component.".".$view."'));";
		}
		return $oserver;
	}

	protected function setJtableAliasCategory($view)
	{
		// only add Observers if both title, alias and category is availabe in view
		if (array_key_exists($view, $this->catCodeBuilder))
		{
			$code = $this->catCodeBuilder[$view]['code'];
			return ", '".$code."' => \$this->".$code;
		}
		return '';
	}

	protected function setUninstallScript()
	{
		// reset script
		$script = '';
		if (isset($this->uninstallScriptBuilder) && ComponentbuilderHelper::checkArray($this->uninstallScriptBuilder))
		{
			$component = $this->fileContentStatic['###component###'];
			// start loading the data to delet
			$script .= "\n\t\t//".$this->setLine(__LINE__)." Get Application object";
			$script .= "\n\t\t\$app = JFactory::getApplication();";
			$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Get The Database object";
			$script .= "\n\t\t\$db = JFactory::getDbo();";

			foreach ($this->uninstallScriptBuilder as $viewName => $typeAlias)
			{
				// set a var value
				$view = ComponentbuilderHelper::safeString($viewName);

				// First check if data is till in table
				$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= "\n\t\t\$query = \$db->getQuery(true);";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Select id from content type table";
				$script .= "\n\t\t\$query->select(\$db->quoteName('type_id'));";
				$script .= "\n\t\t\$query->from(\$db->quoteName('#__content_types'));";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Where ".$viewName." alias is found";
				$script .= "\n\t\t\$query->where( \$db->quoteName('type_alias') . ' = '. \$db->quote('".$typeAlias."') );";
				$script .= "\n\t\t\$db->setQuery(\$query);";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Execute query to see if alias is found";
				$script .= "\n\t\t\$db->execute();";
				$script .= "\n\t\t\$".$view."_found = \$db->getNumRows();";
				$script .= "\n\t\t//".$this->setLine(__LINE__)." Now check if there were any rows";
				$script .= "\n\t\tif (\$".$view."_found)";
				$script .= "\n\t\t{";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Since there are load the needed  ".$view." type ids";
				$script .= "\n\t\t\t\$".$view."_ids = \$db->loadColumn();";

				// Now remove the actual type entry
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." from the content type table";
				$script .= "\n\t\t\t\$".$view."_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('".$typeAlias."') );";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= "\n\t\t\t\$query = \$db->getQuery(true);";
				$script .= "\n\t\t\t\$query->delete(\$db->quoteName('#__content_types'));";
				$script .= "\n\t\t\t\$query->where(\$".$view."_condition);";
				$script .= "\n\t\t\t\$db->setQuery(\$query);";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= "\n\t\t\t\$".$view."_done = \$db->execute();";
				$script .= "\n\t\t\tif (\$".$view."_done);";
				$script .= "\n\t\t\t{";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$viewName." add queued success message.";
				// TODO lang is not translated
				$script .= "\n\t\t\t\t\$app->enqueueMessage(JText::_('The (".$typeAlias.") type alias was removed from the <b>#__content_type</b> table'));";
				$script .= "\n\t\t\t}";

				// Now remove the related items from contentitem tag map table
				$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the contentitem tag map table";
				$script .= "\n\t\t\t\$".$view."_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('".$typeAlias."') );";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= "\n\t\t\t\$query = \$db->getQuery(true);";
				$script .= "\n\t\t\t\$query->delete(\$db->quoteName('#__contentitem_tag_map'));";
				$script .= "\n\t\t\t\$query->where(\$".$view."_condition);";
				$script .= "\n\t\t\t\$db->setQuery(\$query);";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= "\n\t\t\t\$".$view."_done = \$db->execute();";
				$script .= "\n\t\t\tif (\$".$view."_done);";
				$script .= "\n\t\t\t{";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$viewName." add queued success message.";
				// TODO lang is not translated
				$script .= "\n\t\t\t\t\$app->enqueueMessage(JText::_('The (".$typeAlias.") type alias was removed from the <b>#__contentitem_tag_map</b> table'));";
				$script .= "\n\t\t\t}";

				// Now remove the related items from ucm content table
				$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the ucm content table";
				$script .= "\n\t\t\t\$".$view."_condition = array( \$db->quoteName('core_type_alias') . ' = ' . \$db->quote('".$typeAlias."') );";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= "\n\t\t\t\$query = \$db->getQuery(true);";
				$script .= "\n\t\t\t\$query->delete(\$db->quoteName('#__ucm_content'));";
				$script .= "\n\t\t\t\$query->where(\$".$view."_condition);";
				$script .= "\n\t\t\t\$db->setQuery(\$query);";
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= "\n\t\t\t\$".$view."_done = \$db->execute();";
				$script .= "\n\t\t\tif (\$".$view."_done);";
				$script .= "\n\t\t\t{";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$viewName." add queued success message.";
				// TODO lang is not translated
				$script .= "\n\t\t\t\t\$app->enqueueMessage(JText::_('The (".$typeAlias.") type alias was removed from the <b>#__ucm_content</b> table'));";
				$script .= "\n\t\t\t}";

				// setup the foreach loop of ids
				$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Make sure that all the ".$viewName." items are cleared from DB";
				$script .= "\n\t\t\tforeach (\$".$view."_ids as \$".$view."_id)";
				$script .= "\n\t\t\t{";

				// Now remove the related items from ucm base table
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the ucm base table";
				$script .= "\n\t\t\t\t\$".$view."_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$".$view."_id);";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= "\n\t\t\t\t\$query = \$db->getQuery(true);";
				$script .= "\n\t\t\t\t\$query->delete(\$db->quoteName('#__ucm_base'));";
				$script .= "\n\t\t\t\t\$query->where(\$".$view."_condition);";
				$script .= "\n\t\t\t\t\$db->setQuery(\$query);";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= "\n\t\t\t\t\$db->execute();";

				// Now remove the related items from ucm history table
				$script .= "\n\n\t\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the ucm history table";
				$script .= "\n\t\t\t\t\$".$view."_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$".$view."_id);";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= "\n\t\t\t\t\$query = \$db->getQuery(true);";
				$script .= "\n\t\t\t\t\$query->delete(\$db->quoteName('#__ucm_history'));";
				$script .= "\n\t\t\t\t\$query->where(\$".$view."_condition);";
				$script .= "\n\t\t\t\t\$db->setQuery(\$query);";
				$script .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= "\n\t\t\t\t\$db->execute();";

				$script .= "\n\t\t\t}";

				$script .= "\n\t\t}";
			}

			$script .= "\n\n\t\t//".$this->setLine(__LINE__)." If All related items was removed queued success message.";
			// TODO lang is not translated
			$script .= "\n\t\t\$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_base</b> table'));";
			$script .= "\n\t\t\$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_history</b> table'));";
			// finaly remove the assets from the assets table
			$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Remove ".$component." assets from the assets table";
			$script .= "\n\t\t\$".$component."_condition = array( \$db->quoteName('name') . ' LIKE ' . \$db->quote('com_".$component."%') );";
			$script .= "\n\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$script .= "\n\t\t\$query = \$db->getQuery(true);";
			$script .= "\n\t\t\$query->delete(\$db->quoteName('#__assets'));";
			$script .= "\n\t\t\$query->where(\$".$component."_condition);";
			$script .= "\n\t\t\$db->setQuery(\$query);";
			$script .= "\n\t\t\$".$view."_done = \$db->execute();";
			$script .= "\n\t\tif (\$".$view."_done);";
			$script .= "\n\t\t{";
			$script .= "\n\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$component." add queued success message.";
			// TODO lang is not translated
			$script .= "\n\t\t\t\$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));";
			$script .= "\n\t\t}";
			// done
			$script .= "\n";
			
		}
		return $script;
	}

	protected function setInstallScript()
	{
		// reset script
		$script = '';
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			// set component name
			$component	= $this->fileContentStatic['###component###'];
			// reset
			$dbStuff	= array();
			// start loading the content type data
			foreach ($this->componentData->admin_views as $viewData)
			{
				// set main keys
				$view = ComponentbuilderHelper::safeString($viewData['settings']->name_single);
				// set list view keys
				$views = ComponentbuilderHelper::safeString($viewData['settings']->name_list);
				// get this views content type data
				$dbStuff[$view] = $this->getContentType($view, $component);
				// get the correct views name
				$checkViews = (isset($this->catCodeBuilder[$view]['views']) && ComponentbuilderHelper::checkString($this->catCodeBuilder[$view]['views'])) ? $this->catCodeBuilder[$view]['views'] : $views;
				if (ComponentbuilderHelper::checkArray($dbStuff[$view]) && array_key_exists($view, $this->catCodeBuilder) && ($checkViews == $views))
				{
					$dbStuff[$view.' catagory'] = $this->getCategoryContentType($view, $views, $component);
				}
				elseif(!isset($dbStuff[$view]) || !ComponentbuilderHelper::checkArray($dbStuff[$view]))
				{
					// remove if not array
					unset($dbStuff[$view]);
				}

			}
			// build the db insert query
			if (ComponentbuilderHelper::checkArray($dbStuff))
			{
				$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Get The Database object";
				$script .= "\n\n\t\t\t\$db = JFactory::getDbo();";
				foreach ($dbStuff as $name => $tables)
				{
					if (ComponentbuilderHelper::checkArray($tables))
					{
						$code = ComponentbuilderHelper::safeString($name);
						$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Create the ".$name." content type object.";
						$script .= "\n\t\t\t\$".$code." = new stdClass();";
						foreach ($tables as $table => $data)
						{
							$script .= "\n\t\t\t\$".$code."->".$table." = '".$data."';";
						}
						$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Insert the object into the content types table.";
						$script .= "\n\t\t\t\$".$code."Inserted = \$db->insertObject('#__content_types', \$".$code.");";
					}
				}
				$script .= "\n\n";
			}
		}

		if (isset($this->paramsBuilder) && ComponentbuilderHelper::checkString($this->paramsBuilder))
		{
			if (ComponentbuilderHelper::checkString($script))
			{
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Install the global extenstion params.";
			}
			else
			{
				$script .= "\n\t\t\t//".$this->setLine(__LINE__)." Install the global extenstion params.";
				$script .= "\n\t\t\t\$db = JFactory::getDbo();";
			}
			$script .= "\n\t\t\t\$query = \$db->getQuery(true);";
			$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Field to update.";
			$script .= "\n\t\t\t\$fields = array(";
			$script .= "\n\t\t\t\t\$db->quoteName('params') . ' = ' . \$db->quote('{".$this->paramsBuilder."}'),";
			$script .= "\n\t\t\t);";
			$script .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Condition.";
			$script .= "\n\t\t\t\$conditions = array(";
			$script .= "\n\t\t\t\t\$db->quoteName('element') . ' = ' . \$db->quote('com_".$component."')";
			$script .= "\n\t\t\t);";
			$script .= "\n\n\t\t\t\$query->update(\$db->quoteName('#__extensions'))->set(\$fields)->where(\$conditions);";
			$script .= "\n\t\t\t\$db->setQuery(\$query);";
			$script .= "\n\t\t\t\$allDone = \$db->execute();";
		}

		if (ComponentbuilderHelper::checkString($script))
		{
			$script .= "\n\t\t\t".'echo \'<a target="_blank" href="'.$this->fileContentStatic['###AUTHORWEBSITE###'].'" title="'.$this->fileContentStatic['###Component_name###'].'">';
			$script .= "\n\t\t\t\t".'<img src="components/com_'.$component.'/assets/images/component-300.jpg"/>';
			$script .= "\n\t\t\t\t".'</a>\';';
			
			return $script;
		}
		return "\n\t\t\t//".$this->setLine(__LINE__)." noting to install.";
	}
	
	protected function setUpdateScript()
	{
		// reset script
		$script = '';
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$script .= "\n\t\t\t".'echo \'<a target="_blank" href="'.$this->fileContentStatic['###AUTHORWEBSITE###'].'" title="'.$this->fileContentStatic['###Component_name###'].'">';
			$script .= "\n\t\t\t\t".'<img src="components/com_'.$this->fileContentStatic['###component###'].'/assets/images/component-300.jpg"/>';
			$script .= "\n\t\t\t\t".'</a>';
			$script .= "\n\t\t\t\t<h3>Upgrade to Version ".$this->fileContentStatic['###VERSION###']." Was Successful! Let us know if anything is not working as expected.</h3>';";
		}

		if (ComponentbuilderHelper::checkString($script))
		{
			return $script;
		}
		return "\n\t\t\t//".$this->setLine(__LINE__)." noting to update.";
	}

	protected function getContentType($view, $component)
	{
		// add if history is to be kept or if tags is added
		if ((isset($this->historyBuilder[$view]) && ComponentbuilderHelper::checkString($this->historyBuilder[$view])) || (isset($this->tagsBuilder[$view]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$view])))
		{
			// reset array
			$array = array();
			// set needed defaults
			$alias			= (array_key_exists($view, $this->aliasBuilder)) ? $this->aliasBuilder[$view] : 'null';
			$title			= (array_key_exists($view, $this->titleBuilder)) ? $this->titleBuilder[$view] : 'null';
			$category		= (array_key_exists($view, $this->catCodeBuilder)) ? $this->catCodeBuilder[$view]['code'] : 'null';
			$categoryHistory	= (array_key_exists($view, $this->catCodeBuilder)) ?
			'{"sourceColumn": "'.$category.'","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},': '';
			$Component		= ComponentbuilderHelper::safeString($component, 'F');
			$View			= ComponentbuilderHelper::safeString($view, 'F');
			$maintext		= (isset($this->maintextBuilder[$view]) && ComponentbuilderHelper::checkString($this->maintextBuilder[$view])) ? $this->maintextBuilder[$view] : 'null';
			$hiddenFields 		= (isset($this->hiddenFieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->hiddenFieldsBuilder[$view])) ? $this->hiddenFieldsBuilder[$view]: '';
			$dynamicfields 		= (isset($this->dynamicfieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->dynamicfieldsBuilder[$view])) ? $this->dynamicfieldsBuilder[$view] : '';
			$intFields 		= (isset($this->intFieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->intFieldsBuilder[$view])) ? $this->intFieldsBuilder[$view] : '';
			$customfieldlinks	= (isset($this->customFieldLinksBuilder[$view]) && ComponentbuilderHelper::checkString($this->customFieldLinksBuilder[$view])) ? $this->customFieldLinksBuilder[$view] : '';
			// build uninstall script for content types
			$this->uninstallScriptBuilder[$View] = 'com_'.$component.'.'.$view;
			// check if this view has metadata
			if (isset($this->metadataBuilder[$view]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view]))
			{
				$core_metadata = 'metadata';
				$core_metakey = 'metakey';
				$core_metadesc = 'metadesc';
			}
			else
			{
				$core_metadata = 'null';
				$core_metakey = 'null';
				$core_metadesc = 'null';
			}
			// check if view has access
			if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
			{
				$core_access = 'access';
				$accessHistory = ',{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"}';
			}
			else
			{
				$core_access = 'null';
				$accessHistory = '';
			}
			// set the title
			$array['type_title'] = $Component.' '.$View;
			// set the alias
			$array['type_alias'] = 'com_'.$component.'.'.$view;
			// set the table
			$array['table'] = '{"special": {"dbtable": "#__'.$component.'_'.$view.'","key": "id","type": "'.$View.'","prefix": "'.$component.'Table","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			// set field map
			$array['field_mappings'] = '{"common": {"core_content_item_id": "id","core_title": "'.$title.'","core_state": "published","core_alias": "'.$alias.'","core_created_time": "created","core_modified_time": "modified","core_body": "'.$maintext.'","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "'.$core_access.'","core_params": "params","core_featured": "null","core_metadata": "'.$core_metadata.'","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "'.$core_metakey.'","core_metadesc": "'.$core_metadesc.'","core_catid": "'.$category.'","core_xreference": "null","asset_id": "asset_id"},"special": {'.$dynamicfields.'}}';
			// set the router class method
			$array['router'] = $Component.'HelperRoute::get'.$View.'Route';
			// set content history
			$array['content_history_options'] = '{"formFile": "administrator/components/com_'.$component.'/models/forms/'.$view.'.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"'.$hiddenFields.'],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"'.$intFields.'],"displayLookup": ['.$categoryHistory.'{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'.$accessHistory.',{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'.$customfieldlinks.']}';

			return $array;
		}
		return false;
	}

	protected function getCategoryContentType($view, $views, $component)
	{
		$category		= $this->catCodeBuilder[$view]['code'];
		$Component		= ComponentbuilderHelper::safeString($component, 'F');
		$View			= ComponentbuilderHelper::safeString($view, 'F');
		// build uninstall script for content types
		$this->uninstallScriptBuilder[$View.' '.$category] = 'com_'.$component.'.'.$views.'.category';
		// set the title
		$array['type_title'] = $Component.' '.$View.' '.ComponentbuilderHelper::safeString($category, 'F');
		// set the alias
		$array['type_alias'] = 'com_'.$component.'.'.$views.'.category';
		// set the table
		$array['table'] = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
		// set field map
		$array['field_mappings'] = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
		// set the router class method
		$array['router'] = $Component.'HelperRoute::getCategoryRoute';
		// set content history
		$array['content_history_options'] = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

		return $array;
	}

	protected function setRouterHelp($viewName_single, $viewName_list, $front = false)
	{
		// add if tags is added, also for all front item views
		if (((isset($this->tagsBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$viewName_single])) || $front) && (!in_array($viewName_single,$this->setRouterHelpDone)))
		{
			// insure we load a view only once
			$this->setRouterHelpDone[] = $viewName_single;
			// build view route helper
			$View = ComponentbuilderHelper::safeString($viewName_single, 'F');
			$routeHelper = array();
			$routeHelper[] = "\n\n\t/**";
			$routeHelper[] = "\t* @param int The route of the ".$View;
			$routeHelper[] = "\t*/";
			if ('category' == $viewName_single || 'categories' == $viewName_single)
			{
				$routeHelper[] = "\tpublic static function get".$View."Route(\$id = 0)";
			}
			else
			{
				$routeHelper[] = "\tpublic static function get".$View."Route(\$id = 0, \$catid = 0)";
			}
			$routeHelper[] = "\t{";
			$routeHelper[] = "\t\tif (\$id > 0)";
			$routeHelper[] = "\t\t{";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)." Initialize the needel array.";
			$routeHelper[] = "\t\t\t\$needles = array(";
			$routeHelper[] = "\t\t\t\t'".$viewName_single."'  => array((int) \$id)";
			$routeHelper[] = "\t\t\t);";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)." Create the link";
			$routeHelper[] = "\t\t\t\$link = 'index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_single."&id='. \$id;";
			$routeHelper[] = "\t\t}";
			$routeHelper[] = "\t\telse";
			$routeHelper[] = "\t\t{";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)." Initialize the needel array.";
			$routeHelper[] = "\t\t\t\$needles = array();";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)."Create the link but don't add the id.";
			$routeHelper[] = "\t\t\t\$link = 'index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_single."';";
			$routeHelper[] = "\t\t}";			
			if ('category' != $viewName_single && 'categories' != $viewName_single)
			{
				$routeHelper[] = "\t\tif (\$catid > 1)";
				$routeHelper[] = "\t\t{";
				$routeHelper[] = "\t\t\t\$categories = JCategories::getInstance('".$this->fileContentStatic['###component###'].".".$viewName_list."');";
				$routeHelper[] = "\t\t\t\$category = \$categories->get(\$catid);";
				$routeHelper[] = "\t\t\tif (\$category)";
				$routeHelper[] = "\t\t\t{";
				$routeHelper[] = "\t\t\t\t\$needles['category'] = array_reverse(\$category->getPath());";
				$routeHelper[] = "\t\t\t\t\$needles['categories'] = \$needles['category'];";
				$routeHelper[] = "\t\t\t\t\$link .= '&catid='.\$catid;";
				$routeHelper[] = "\t\t\t}";
				$routeHelper[] = "\t\t}";
			}
			if (isset($this->hasMenuGlobal[$viewName_single]))
			{
				$routeHelper[] = "\n\t\tif (\$item = self::_findItem(\$needles, '".$viewName_single."'))";
			}
			else
			{				
				$routeHelper[] = "\n\t\tif (\$item = self::_findItem(\$needles))";
			}
			$routeHelper[] = "\t\t{";
			$routeHelper[] = "\t\t\t\$link .= '&Itemid='.\$item;";
			$routeHelper[] = "\t\t}";
			$routeHelper[] = "\n\t\treturn \$link;";
			$routeHelper[] = "\t}";

			return implode("\n",$routeHelper);
		}
		return '';
	}
	
	protected function routerParseSwitch($view)
	{
		// add if tags is added, also for all front item views
		if (1)
		{
			// build view route switch
			$routerSwitch = array();
			
			$routerSwitch[] = "\n\t\t\tcase '".$view."':";
			$routerSwitch[] = "\t\t\t\t\$vars['view'] = '".$view."';";
			$routerSwitch[] = "\t\t\t\tif (is_numeric(\$segments[\$count-1]))";
			$routerSwitch[] = "\t\t\t\t{";
			$routerSwitch[] = "\t\t\t\t\t\$vars['id'] = (int) \$segments[\$count-1];";
			$routerSwitch[] = "\t\t\t\t}";
			$routerSwitch[] = "\t\t\t\telse";
			$routerSwitch[] = "\t\t\t\t{";
			$routerSwitch[] = "\t\t\t\t\t\$id = \$this->getVar('".$view."', \$segments[\$count-1], 'alias', 'id');";
			$routerSwitch[] = "\t\t\t\t\tif(\$id)";
			$routerSwitch[] = "\t\t\t\t\t{";
			$routerSwitch[] = "\t\t\t\t\t\t\$vars['id'] = \$id;";
			$routerSwitch[] = "\t\t\t\t\t}";
			$routerSwitch[] = "\t\t\t\t}";
			$routerSwitch[] = "\t\t\t\tbreak;";

			return implode("\n",$routerSwitch);
		}
		elseif (0)
		{
			// build view route switch
			$routerSwitch = array();
			
			$routerSwitch[] = "\n\t\t\tcase '".$view."':";
			$routerSwitch[] = "\t\t\t\t\$vars['view'] = '".$view."';";
			$routerSwitch[] = "\t\t\t\tbreak;";

			return implode("\n",$routerSwitch);
		}
		return '';
	}
	
	protected function routerBuildViews($view)
	{
		if (isset($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']) && ComponentbuilderHelper::checkString($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']))
		{
			return " || \$view == '".$view."'";
		}
		else
		{
			return "\$view == '".$view."'";
		}
	}

	protected function setBatchMove($viewName_single)
	{
		// set needed defaults
		$title			= false;
		$alias			= false;
		$category		= false;
		$batchmove		= array();
		$VIEW			= ComponentbuilderHelper::safeString($viewName_single, 'U');
		// component helper name
		$Helper = $this->fileContentStatic['###Component###'].'Helper';
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// only load category if set in this view
		if (array_key_exists($viewName_single, $this->catCodeBuilder))
		{
			$category		= $this->catCodeBuilder[$viewName_single]['code'];
		}
		// only load alias if set in this view
		if (array_key_exists($viewName_single, $this->aliasBuilder))
		{
			$alias		= $this->aliasBuilder[$viewName_single];
		}
		// only load title if set in this view
		if (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$title 		= $this->titleBuilder[$viewName_single];
		}
		// prepare custom script
		if (isset($this->customScriptBuilder['php_batchmove'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_batchmove'][$viewName_single]))
		{
			$customScript = "\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_batchmove'][$viewName_single]);
		}
		else
		{
			$customScript = '';
		}

		$batchmove[] = "\n\t/**";
		$batchmove[] = "\t * Batch move items to a new category";
		$batchmove[] = "\t *";
		$batchmove[] = "\t * @param   integer  \$value     The new category ID.";
		$batchmove[] = "\t * @param   array    \$pks       An array of row IDs.";
		$batchmove[] = "\t * @param   array    \$contexts  An array of item contexts.";
		$batchmove[] = "\t *";
		$batchmove[] = "\t * @return  boolean  True if successful, false otherwise and internal error is set.";
		$batchmove[] = "\t *";
		$batchmove[] = "\t * @since\t12.2";
		$batchmove[] = "\t */";
		$batchmove[] = "\tprotected function batchMove(\$values, \$pks, \$contexts)";
		$batchmove[] = "\t{";
		$batchmove[] = "\t\tif (empty(\$this->batchSet))";
		$batchmove[] = "\t\t{";
		$batchmove[] = "\t\t\t//".$this->setLine(__LINE__)." Set some needed variables.";
		$batchmove[] = "\t\t\t\$this->user		= JFactory::getUser();";
		$batchmove[] = "\t\t\t\$this->table		= \$this->getTable();";
		$batchmove[] = "\t\t\t\$this->tableClassName	= get_class(\$this->table);";
		$batchmove[] = "\t\t\t\$this->contentType	= new JUcmType;";
		$batchmove[] = "\t\t\t\$this->type		= \$this->contentType->getTypeByTable(\$this->tableClassName);";
		$batchmove[] = "\t\t\t\$this->canDo		= ".$Helper."::getActions('".$viewName_single."');";
		$batchmove[] = "\t\t}";

		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
		{
			$batchmove[] = "\n\t\tif (!\$this->canDo->get('".$core['core.edit']."') && !\$this->canDo->get('".$core['core.batch']."'))";
		}
		else
		{
			$batchmove[] = "\n\t\tif (!\$this->canDo->get('core.edit') && !\$this->canDo->get('core.batch'))";
		}
		$batchmove[] = "\t\t{";
		$batchmove[] = "\t\t\t\$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";
		$batchmove[] = "\t\t\treturn false;";
		$batchmove[] = "\t\t}".$customScript;

		$batchmove[] = "\n\t\t//".$this->setLine(__LINE__)." make sure published only updates if user has the permission.";
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$batchmove[] = "\t\tif (isset(\$values['published']) && !\$this->canDo->get('".$core['core.edit.state']."'))";
		}
		else
		{
			$batchmove[] = "\t\tif (isset(\$values['published']) && !\$this->canDo->get('core.edit.state'))";
		}
		$batchmove[] = "\t\t{";
		$batchmove[] = "\t\t\tunset(\$values['published']);";
		$batchmove[] = "\t\t}";

		$batchmove[] = "\t\t//".$this->setLine(__LINE__)." remove move_copy from array";
		$batchmove[] = "\t\tunset(\$values['move_copy']);";

		if ($category)
		{
			$batchmove[] = "\n\t\tif (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchmove[] = "\t\t{";
			$batchmove[] = "\t\t\treturn false;";
			$batchmove[] = "\t\t}";
			$batchmove[] = "\t\telseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchmove[] = "\t\t{";
			$batchmove[] = "\t\t\t//".$this->setLine(__LINE__)." move the category value to correct field name";
			$batchmove[] = "\t\t\t\$values['".$category."'] = \$values['category'];";
			$batchmove[] = "\t\t\tunset(\$values['category']);";
			$batchmove[] = "\t\t}";
			$batchmove[] = "\t\telseif (isset(\$values['category']))";
			$batchmove[] = "\t\t{";
			$batchmove[] = "\t\t\tunset(\$values['category']);";
			$batchmove[] = "\t\t}\n";
		}

		$batchmove[] = "\n\t\t//".$this->setLine(__LINE__)." Parent exists so we proceed";
		$batchmove[] = "\t\tforeach (\$pks as \$pk)";
		$batchmove[] = "\t\t{";
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
		{
			$batchmove[] = "\t\t\tif (!\$this->user->authorise('".$core['core.edit']."', \$contexts[\$pk]))";
		}
		else
		{
			$batchmove[] = "\t\t\tif (!\$this->user->authorise('core.edit', \$contexts[\$pk]))";
		}
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";

		$batchmove[] = "\n\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = "\n\t\t\t//".$this->setLine(__LINE__)." Check that the row actually exists";
		$batchmove[] = "\t\t\tif (!\$this->table->load(\$pk))";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\tif (\$error = \$this->table->getError())";
		$batchmove[] = "\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Fatal error";
		$batchmove[] = "\t\t\t\t\t\$this->setError(\$error);";

		$batchmove[] = "\n\t\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t\t}";
		$batchmove[] = "\t\t\t\telse";
		$batchmove[] = "\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Not fatal error";
		$batchmove[] = "\t\t\t\t\t\$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchmove[] = "\t\t\t\t\tcontinue;";
		$batchmove[] = "\t\t\t\t}";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = "\n\t\t\t//".$this->setLine(__LINE__)." insert all set values.";
		$batchmove[] = "\t\t\tif (".$Helper."::checkArray(\$values))";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\tforeach (\$values as \$key => \$value)";
		$batchmove[] = "\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Do special action for access.";
		$batchmove[] = "\t\t\t\t\tif ('access' == \$key && strlen(\$value) > 0)";
		$batchmove[] = "\t\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t\t\$this->table->\$key = \$value;";
		$batchmove[] = "\t\t\t\t\t}";
		$batchmove[] = "\t\t\t\t\telseif (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchmove[] = "\t\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t\t\$this->table->\$key = \$value;";
		$batchmove[] = "\t\t\t\t\t}";
		$batchmove[] = "\t\t\t\t}";
		$batchmove[] = "\t\t\t}\n";

		$batchmove[] = "\n\t\t\t//".$this->setLine(__LINE__)." Check the row.";
		$batchmove[] = "\t\t\tif (!\$this->table->check())";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchmove[] = "\n\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = "\n\t\t\tif (!empty(\$this->type))";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = "\n\t\t\t//".$this->setLine(__LINE__)." Store the row.";
		$batchmove[] = "\t\t\tif (!\$this->table->store())";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchmove[] = "\n\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t}";
		$batchmove[] = "\t\t}";

		$batchmove[] = "\n\t\t//".$this->setLine(__LINE__)." Clean the cache";
		$batchmove[] = "\t\t\$this->cleanCache();";

		$batchmove[] = "\n\t\treturn true;";
		$batchmove[] = "\t}";

		return "\n".implode("\n",$batchmove);
	}

	protected function setBatchCopy($viewName_single)
	{
		// set needed defaults
		$title			= false;
		$alias			= false;
		$category		= false;
		$batchcopy		= array();
		$VIEW			= ComponentbuilderHelper::safeString($viewName_single, 'U');
		// component helper name
		$Helper = $this->fileContentStatic['###Component###'].'Helper';
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// only load category if set in this view
		if (array_key_exists($viewName_single, $this->catCodeBuilder))
		{
			$category = $this->catCodeBuilder[$viewName_single]['code'];
		}

		// only load alias if set in this view
		if (array_key_exists($viewName_single, $this->aliasBuilder))
		{
			$alias = $this->aliasBuilder[$viewName_single];
		}
		// only load title if set in this view
		if (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$title = $this->titleBuilder[$viewName_single];
		}
		// prepare custom script
		if (isset($this->customScriptBuilder['php_batchcopy'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_batchcopy'][$viewName_single]))
		{
			$customScript = "\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_batchcopy'][$viewName_single]);
		}
		else
		{
			$customScript = '';
		}

		$batchcopy[] = "\n\t/**";
		$batchcopy[] = "\t * Batch copy items to a new category or current.";
		$batchcopy[] = "\t *";
		$batchcopy[] = "\t * @param   integer  \$values    The new values.";
		$batchcopy[] = "\t * @param   array    \$pks       An array of row IDs.";
		$batchcopy[] = "\t * @param   array    \$contexts  An array of item contexts.";
		$batchcopy[] = "\t *";
		$batchcopy[] = "\t * @return  mixed  An array of new IDs on success, boolean false on failure.";
		$batchcopy[] = "\t *";
		$batchcopy[] = "\t * @since\t12.2";
		$batchcopy[] = "\t */";
		$batchcopy[] = "\tprotected function batchCopy(\$values, \$pks, \$contexts)";
		$batchcopy[] = "\t{";

		$batchcopy[] = "\t\tif (empty(\$this->batchSet))";
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." Set some needed variables.";
		$batchcopy[] = "\t\t\t\$this->user 		= JFactory::getUser();";
		$batchcopy[] = "\t\t\t\$this->table 		= \$this->getTable();";
		$batchcopy[] = "\t\t\t\$this->tableClassName	= get_class(\$this->table);";
		$batchcopy[] = "\t\t\t\$this->contentType	= new JUcmType;";
		$batchcopy[] = "\t\t\t\$this->type		= \$this->contentType->getTypeByTable(\$this->tableClassName);";
		$batchcopy[] = "\t\t\t\$this->canDo		= ".$Helper."::getActions('".$viewName_single."');";
		$batchcopy[] = "\t\t}";
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
		{
			$batchcopy[] = "\n\t\tif (!\$this->canDo->get('".$core['core.create']."') && !\$this->canDo->get('".$core['core.batch']."'))";
		}
		else
		{
			$batchcopy[] = "\n\t\tif (!\$this->canDo->get('core.create') || !\$this->canDo->get('core.batch'))";
		}
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\treturn false;";
		$batchcopy[] = "\t\t}".$customScript;

		$batchcopy[] = "\n\t\t//".$this->setLine(__LINE__)." get list of uniqe fields";
		$batchcopy[] = "\t\t\$uniqeFields = \$this->getUniqeFields();";
		$batchcopy[] = "\t\t//".$this->setLine(__LINE__)." remove move_copy from array";
		$batchcopy[] = "\t\tunset(\$values['move_copy']);";

		$batchcopy[] = "\n\t\t//".$this->setLine(__LINE__)." make sure published is set";
		$batchcopy[] = "\t\tif (!isset(\$values['published']))";
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t\$values['published'] = 0;";
		$batchcopy[] = "\t\t}";
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$batchcopy[] = "\t\telseif (isset(\$values['published']) && !\$this->canDo->get('".$core['core.edit.state']."'))";
		}
		else
		{
			$batchcopy[] = "\t\telseif (isset(\$values['published']) && !\$this->canDo->get('core.edit.state'))";
		}
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t\t\$values['published'] = 0;";
		$batchcopy[] = "\t\t}";

		if ($category)
		{
			$batchcopy[] = "\n\t\tif (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchcopy[] = "\t\t{";
			$batchcopy[] = "\t\t\treturn false;";
			$batchcopy[] = "\t\t}";
			$batchcopy[] = "\t\telseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchcopy[] = "\t\t{";
			$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." move the category value to correct field name";
			$batchcopy[] = "\t\t\t\$values['".$category."'] = \$values['category'];";
			$batchcopy[] = "\t\t\tunset(\$values['category']);";
			$batchcopy[] = "\t\t}";
			$batchcopy[] = "\t\telseif (isset(\$values['category']))";
			$batchcopy[] = "\t\t{";
			$batchcopy[] = "\t\t\tunset(\$values['category']);";
			$batchcopy[] = "\t\t}";
		}

		$batchcopy[] = "\n\t\t\$newIds = array();";

		$batchcopy[] = "\n\t\t//".$this->setLine(__LINE__)." Parent exists so let's proceed";
		$batchcopy[] = "\t\twhile (!empty(\$pks))";
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." Pop the first ID off the stack";
		$batchcopy[] = "\t\t\t\$pk = array_shift(\$pks);";

		$batchcopy[] = "\n\t\t\t\$this->table->reset();";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." only allow copy if user may edit this item.";
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
		{
			$batchcopy[] = "\n\t\t\tif (!\$this->user->authorise('".$core['core.edit']."', \$contexts[\$pk]))";
		}
		else
		{
			$batchcopy[] = "\n\t\t\tif (!\$this->user->authorise('core.edit', \$contexts[\$pk]))";
		}
		$batchcopy[] = "\n\t\t\t{";
		$batchcopy[] = "\n\t\t\t\t//".$this->setLine(__LINE__)." Not fatal error";
		$batchcopy[] = "\n\t\t\t\t\$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = "\n\t\t\t\tcontinue;";
		$batchcopy[] = "\n\t\t\t}";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." Check that the row actually exists";
		$batchcopy[] = "\t\t\tif (!\$this->table->load(\$pk))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\tif (\$error = \$this->table->getError())";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Fatal error";
		$batchcopy[] = "\t\t\t\t\t\$this->setError(\$error);";

		$batchcopy[] = "\n\t\t\t\t\treturn false;";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t\telse";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Not fatal error";
		$batchcopy[] = "\t\t\t\t\t\$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = "\t\t\t\t\tcontinue;";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t}";
		if ($category && $alias == 'alias' && $title == 'title')
		{
			$batchcopy[] = "\n\t\t\tif (isset(\$values['".$category."']))";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tstatic::generateTitle((int) \$values['".$category."'], \$this->table);";
			$batchcopy[] = "\t\t\t}";
			$batchcopy[] = "\t\t\telse";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tstatic::generateTitle((int) \$this->table->".$category.", \$this->table);";
			$batchcopy[] = "\t\t\t}";
		}
		elseif ($category && $alias && $title)
		{
			$batchcopy[] = "\n\t\t\tif (isset(\$values['".$category."']))";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tlist(\$this->table->".$title.", \$this->table->".$alias.") = \$this->generateNewTitle(\$values['".$category."'], \$this->table->".$alias.", \$this->table->".$title.");";
			$batchcopy[] = "\t\t\t}";
			$batchcopy[] = "\t\t\telse";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tlist(\$this->table->".$title.", \$this->table->".$alias.") = \$this->generateNewTitle(\$this->table->".$category.", \$this->table->".$alias.", \$this->table->".$title.");";
			$batchcopy[] = "\t\t\t}";
		}
		elseif (!$category && $alias && $title)
		{
			$batchcopy[] = "\n\t\t\tlist(\$this->table->".$title.", \$this->table->".$alias.") = \$this->_generateNewTitle(\$this->table->".$alias.", \$this->table->".$title.");";
		}
		elseif (!$category && !$alias && $title && $title != 'user')
		{
			$batchcopy[] = "\n\t\t\t\$this->table->".$title." = \$this->generateUniqe('".$title."',\$this->table->".$title.");";
		}

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." insert all set values";
		$batchcopy[] = "\t\t\tif (".$Helper."::checkArray(\$values))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\tforeach (\$values as \$key => \$value)";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\tif (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchcopy[] = "\t\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t\t\$this->table->\$key = \$value;";
		$batchcopy[] = "\t\t\t\t\t}";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t}\n";

		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." update all uniqe fields";
		$batchcopy[] = "\t\t\tif (".$Helper."::checkArray(\$uniqeFields))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\tforeach (\$uniqeFields as \$uniqeField)";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t\$this->table->\$uniqeField = \$this->generateUniqe(\$uniqeField,\$this->table->\$uniqeField);";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." Reset the ID because we are making a copy";
		$batchcopy[] = "\t\t\t\$this->table->id = 0;";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." TODO: Deal with ordering?";
		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." \$this->table->ordering\t= 1;";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." Check the row.";
		$batchcopy[] = "\t\t\tif (!\$this->table->check())";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchcopy[] = "\n\t\t\t\treturn false;";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = "\n\t\t\tif (!empty(\$this->type))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\t\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." Store the row.";
		$batchcopy[] = "\t\t\tif (!\$this->table->store())";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchcopy[] = "\n\t\t\t\treturn false;";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." Get the new item ID";
		$batchcopy[] = "\t\t\t\$newId = \$this->table->get('id');";

		$batchcopy[] = "\n\t\t\t//".$this->setLine(__LINE__)." Add the new ID to the array";
		$batchcopy[] = "\t\t\t\$newIds[\$pk] = \$newId;";
		$batchcopy[] = "\t\t}";

		$batchcopy[] = "\n\t\t//".$this->setLine(__LINE__)." Clean the cache";
		$batchcopy[] = "\t\t\$this->cleanCache();";

		$batchcopy[] = "\n\t\treturn \$newIds;";
		$batchcopy[] = "\t}";

		return "\n".implode("\n",$batchcopy);
	}

	protected function setAliasTitleFix($viewName_single)
	{
		$fixUniqe = array();
		// only load this if these two items are set
		if (array_key_exists($viewName_single, $this->aliasBuilder) && array_key_exists($viewName_single, $this->titleBuilder))
		{
			// set needed defaults
			$setCategory	= false;
			$alias			= $this->aliasBuilder[$viewName_single];
			$title			= $this->titleBuilder[$viewName_single];
			$VIEW			= ComponentbuilderHelper::safeString($viewName_single, 'U');
			if (array_key_exists($viewName_single, $this->catCodeBuilder))
			{
				$category		= $this->catCodeBuilder[$viewName_single]['code'];
				$setCategory	= true;
			}
			// start building the fix
			$fixUniqe[] = "\n\t\t//".$this->setLine(__LINE__)." Alter the ".$title." for save as copy";
			$fixUniqe[] = "\t\tif (\$input->get('task') == 'save2copy')";
			$fixUniqe[] = "\t\t{";
			$fixUniqe[] = "\t\t\t\$origTable = clone \$this->getTable();";
			$fixUniqe[] = "\t\t\t\$origTable->load(\$input->getInt('id'));";
			$fixUniqe[] = "\n\t\t\tif (\$data['".$title."'] == \$origTable->".$title.")";
			$fixUniqe[] = "\t\t\t{";
			if ($setCategory)
			{
				$fixUniqe[] = "\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->generateNewTitle(\$data['".$category."'], \$data['".$alias."'], \$data['".$title."']);";
			}
			else
			{
				$fixUniqe[] = "\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->_generateNewTitle(\$data['".$alias."'], \$data['".$title."']);";
			}
			$fixUniqe[] = "\t\t\t\t\$data['".$title."'] = \$".$title.";";
			$fixUniqe[] = "\t\t\t\t\$data['".$alias."'] = \$".$alias.";";
			$fixUniqe[] = "\t\t\t}";
			$fixUniqe[] = "\t\t\telse";
			$fixUniqe[] = "\t\t\t{";
			$fixUniqe[] = "\t\t\t\tif (\$data['".$alias."'] == \$origTable->".$alias.")";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\t\$data['".$alias."'] = '';";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = "\t\t\t}";
			$fixUniqe[] = "\n\t\t\t\$data['published'] = 0;";
			$fixUniqe[] = "\t\t}";
			$fixUniqe[] = "\n\t\t//".$this->setLine(__LINE__)." Automatic handling of ".$alias." for empty fields";
			$fixUniqe[] = "\t\tif (in_array(\$input->get('task'), array('apply', 'save', 'save2new')) && (int) \$input->get('id') == 0)";
			$fixUniqe[] = "\t\t{";
			$fixUniqe[] = "\t\t\tif (\$data['".$alias."'] == null)";
			$fixUniqe[] = "\t\t\t{";
			$fixUniqe[] = "\t\t\t\tif (JFactory::getConfig()->get('unicodeslugs') == 1)";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\t\$data['".$alias."'] = JFilterOutput::stringURLUnicodeSlug(\$data['".$title."']);";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = "\t\t\t\telse";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\t\$data['".$alias."'] = JFilterOutput::stringURLSafe(\$data['".$title."']);";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = "\n\t\t\t\t\$table = JTable::getInstance('".$viewName_single."', '".$this->fileContentStatic['###component###']."Table');";
			if ($setCategory)
			{
				$fixUniqe[] = "\n\t\t\t\tif (\$table->load(array('".$alias."' => \$data['".$alias."'], '".$category."' => \$data['".$category."'])) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUniqe[] = "\t\t\t\t{";
				$fixUniqe[] = "\t\t\t\t\t\$msg = JText::_('COM_".$this->fileContentStatic['###COMPONENT###']."_".$VIEW."_SAVE_WARNING');";
				$fixUniqe[] = "\t\t\t\t}";
				$fixUniqe[] = "\n\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->generateNewTitle(\$data['".$category."'], \$data['".$alias."'], \$data['".$title."']);";
			}
			else
			{
				$fixUniqe[] = "\n\t\t\t\tif (\$table->load(array('".$alias."' => \$data['".$alias."'])) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUniqe[] = "\t\t\t\t{";
				$fixUniqe[] = "\t\t\t\t\t\$msg = JText::_('COM_".$this->fileContentStatic['###COMPONENT###']."_".$VIEW."_SAVE_WARNING');";
				$fixUniqe[] = "\t\t\t\t}";
				$fixUniqe[] = "\n\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->_generateNewTitle(\$data['".$alias."'], \$data['".$title."']);";
			}
			$fixUniqe[] = "\t\t\t\t\$data['".$alias."'] = \$".$alias.";";
			$fixUniqe[] = "\n\t\t\t\tif (isset(\$msg))";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\tJFactory::getApplication()->enqueueMessage(\$msg, 'warning');";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = "\t\t\t}";
			$fixUniqe[] = "\t\t}";
		}
		// handel other uniqe fields
		$fixUniqe[] = "\n\t\t//".$this->setLine(__LINE__)." Alter the uniqe field for save as copy";
		$fixUniqe[] = "\t\tif (\$input->get('task') == 'save2copy')";
		$fixUniqe[] = "\t\t{";
		$fixUniqe[] = "\t\t\t//".$this->setLine(__LINE__)." Automatic handling of other uniqe fields";
		$fixUniqe[] = "\t\t\t\$uniqeFields = \$this->getUniqeFields();";
		$fixUniqe[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uniqeFields))";
		$fixUniqe[] = "\t\t\t{";
		$fixUniqe[] = "\t\t\t\tforeach (\$uniqeFields as \$uniqeField)";
		$fixUniqe[] = "\t\t\t\t{";
		$fixUniqe[] = "\t\t\t\t\t\$data[\$uniqeField] = \$this->generateUniqe(\$uniqeField,\$data[\$uniqeField]);";
		$fixUniqe[] = "\t\t\t\t}";
		$fixUniqe[] = "\t\t\t}";
		$fixUniqe[] = "\t\t}";

		return "\n".implode("\n",$fixUniqe);
	}

	protected function setGenerateNewTitle($viewName_single)
	{
		// if category is added to this view then do nothing
		if (array_key_exists($viewName_single, $this->aliasBuilder) && array_key_exists($viewName_single, $this->titleBuilder))
		{
			$newFunction = array();
			$newFunction[] = "\n\n\t/**";
			$newFunction[] = "\t* Method to change the title & alias.";
			$newFunction[] = "\t*";
			$newFunction[] = "\t* @param   string   \$alias        The alias.";
			$newFunction[] = "\t* @param   string   \$title        The title.";
	 		$newFunction[] = "\t*";
	 		$newFunction[] = "\t* @return	array  Contains the modified title and alias.";
	 		$newFunction[] = "\t*";
			$newFunction[] = "\t*/";
			$newFunction[] = "\tprotected function _generateNewTitle(\$alias, \$title)";
			$newFunction[] = "\t{";
			$newFunction[] = "\n\t\t//".$this->setLine(__LINE__)." Alter the title & alias";
			$newFunction[] = "\t\t\$table = \$this->getTable();";
			$newFunction[] = "\n\t\twhile (\$table->load(array('alias' => \$alias)))";
			$newFunction[] = "\t\t{";
			$newFunction[] = "\t\t\t\$title = JString::increment(\$title);";
			$newFunction[] = "\t\t\t\$alias = JString::increment(\$alias, 'dash');";
			$newFunction[] = "\t\t}";
			$newFunction[] = "\n\t\treturn array(\$title, \$alias);";
			$newFunction[] = "\t}";
			return implode("\n",$newFunction);
		}
		elseif (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$newFunction = array();
			$newFunction[] = "\n\n\t/**";
			$newFunction[] = "\t* Method to change the title & alias.";
			$newFunction[] = "\t*";
			$newFunction[] = "\t* @param   string   \$title        The title.";
	 		$newFunction[] = "\t*";
	 		$newFunction[] = "\t* @return	array  Contains the modified title and alias.";
	 		$newFunction[] = "\t*";
			$newFunction[] = "\t*/";
			$newFunction[] = "\tprotected function _generateNewTitle(\$title)";
			$newFunction[] = "\t{";
			$newFunction[] = "\n\t\t//".$this->setLine(__LINE__)." Alter the title";
			$newFunction[] = "\t\t\$table = \$this->getTable();";
			$newFunction[] = "\n\t\twhile (\$table->load(array('title' => \$title)))";
			$newFunction[] = "\t\t{";
			$newFunction[] = "\t\t\t\$title = JString::increment(\$title);";
			$newFunction[] = "\t\t}";
			$newFunction[] = "\n\t\treturn \$title;";
			$newFunction[] = "\t}";
			return implode("\n",$newFunction);
		}
		return '';
	}

	protected function setInstall()
	{
		if (isset($this->queryBuilder) && ComponentbuilderHelper::checkArray($this->queryBuilder))
		{
			// set the main db prefix
			$component = $this->fileContentStatic['###component###'];
			// start building the db

			$db = '';
			foreach ($this->queryBuilder as $view => $fields)
			{
				// build the uninstall array
				$this->uninstallBuilder[] = "DROP TABLE IF EXISTS `#__".$component."_".$view."`;";

				// setup the tables
				$db .= "CREATE TABLE IF NOT EXISTS `#__".$component."_".$view."` (";
				$db .= "\n\t`id` int(11) NOT NULL AUTO_INCREMENT,";
				$db .= "\n\t`asset_id` INT(255) UNSIGNED NOT NULL DEFAULT '0',";
				ksort($fields);
				foreach ($fields as $field => $data)
				{
					// set default
					$default = $data['default'];
					if ( $default == 'Other' )
					{
						$default = $data['other'];
					}
					if ($default == 'DATETIME' || $default == 'CURRENT_TIMESTAMP')
					{
						$default =  $default.' '.$data['null_switch'];
					}
					elseif ($default == 0 || $default)
					{
						$default = $data['null_switch']." DEFAULT '".$default."'";
					}
					elseif ($data['null_switch'] == 'NULL')
					{
						$default = "DEFAULT NULL";
					}
					else
					{
						$default = $data['null_switch']." DEFAULT ''";
					}
					// set the lenght
					$lenght = '';
					if (isset($data['lenght']) && $data['lenght'] > 0)
					{
						$lenght = '('.$data['lenght'].')';
					}
					// set the field to db
					$db .= "\n\t`".$field."` ".$data['type'].$lenght." ".$default.",";
				}
				$db .= "\n\t`params` TEXT NOT NULL DEFAULT '',";
				$db .= "\n\t`published` tinyint(1) NOT NULL DEFAULT '1',";
				$db .= "\n\t`created_by` int(11) NOT NULL DEFAULT '0',";
				$db .= "\n\t`modified_by` int(11) NOT NULL DEFAULT '0',";
				$db .= "\n\t`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				$db .= "\n\t`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				$db .= "\n\t`checked_out` int(11) NOT NULL,";
				$db .= "\n\t`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				$db .= "\n\t`version` int(11) NOT NULL DEFAULT '1',";
				$db .= "\n\t`hits` int(11) NOT NULL DEFAULT '0',";
				// check if view has access
				if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
				{
					$db .= "\n\t`access` int(11) DEFAULT NULL,";
				}
				$db .= "\n\t`ordering` int(11) NOT NULL DEFAULT '0',";
				// check if metadata is added to this view
				if (isset($this->metadataBuilder[$view]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view]))
				{
					$db .= "\n\t`metakey` TEXT NOT NULL DEFAULT '',";
					$db .= "\n\t`metadesc` TEXT NOT NULL DEFAULT '',";
					$db .= "\n\t`metadata` TEXT NOT NULL DEFAULT '',";
				}
				$db .= "\n\tPRIMARY KEY  (`id`)";
				if (isset($this->dbUniqueKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbUniqueKeys[$view]))
				{
					foreach ($this->dbUniqueKeys[$view] as $nr => $key)
					{
						$db .= ",\n\tUNIQUE KEY `idx_".$key."` (`".$key."`)";
					}
				}
				// check if view has access
				if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
				{
					$db .= ",\n\tKEY `idx_access` (`access`)";
				}
				$db .= ",\n\tKEY `idx_checkout` (`checked_out`)";
				$db .= ",\n\tKEY `idx_createdby` (`created_by`)";
				$db .= ",\n\tKEY `idx_modifiedby` (`modified_by`)";
				$db .= ",\n\tKEY `idx_state` (`published`)";
				if (isset($this->dbKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbKeys[$view]))
				{
					foreach ($this->dbKeys[$view] as $nr => $key)
					{
						$db .= ",\n\tKEY `idx_".$key."` (`".$key."`)";
					}
				}
				$db .= "\n) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;\n\n";
			}
			// add custom sql dump to the file
			if (isset($this->customScriptBuilder['sql']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder['sql']))
			{
				foreach ($this->customScriptBuilder['sql'] as $for => $customSql)
				{
					$placeholders = array('[[[component]]]' => $component, '[[[view]]]' => $for);
					$db .= "\n\n".str_replace(array_keys($placeholders),array_values($placeholders),$customSql);
				}

			}
			return $db;
		}
		return '';
	}

	protected function setUninstall()
	{
		if (isset($this->queryBuilder) && ComponentbuilderHelper::checkArray($this->queryBuilder))
		{
			$bd = '';
			foreach ($this->uninstallBuilder as $line)
			{
				$bd .= $line."\n";
			}
			return $bd;
		}
		return '';
	}

	protected function setLangAdmin()
	{
		// add final list of needed lang strings
		$this->langContent['adminsys'][$this->langPrefix]				= ComponentbuilderHelper::safeString($this->componentData->name,'W');
		$this->langContent['adminsys'][$this->langPrefix.'_CONFIGURATION']		= ComponentbuilderHelper::safeString($this->componentData->name,'W').' Configuration';
		$this->langContent[$this->lang][$this->langPrefix]				= ComponentbuilderHelper::safeString($this->componentData->name,'W');
		$this->langContent['admin'][$this->langPrefix.'_BACK']				= 'Back';
		$this->langContent['admin'][$this->langPrefix.'_DASH']				= 'Dashboard';
		$this->langContent['admin'][$this->langPrefix.'_VERSION']			= 'Version';
		$this->langContent['admin'][$this->langPrefix.'_DATE']				= 'Date';
		$this->langContent['admin'][$this->langPrefix.'_AUTHOR']			= 'Author';
		$this->langContent['admin'][$this->langPrefix.'_WEBSITE']			= 'Website';
		$this->langContent['admin'][$this->langPrefix.'_LICENSE']			= 'License';
		$this->langContent['admin'][$this->langPrefix.'_CONTRIBUTORS']			= 'Contributors';
		$this->langContent['admin'][$this->langPrefix.'_CONTRIBUTOR']			= 'Contributor';
		$this->langContent['admin'][$this->langPrefix.'_DASHBOARD']			= ComponentbuilderHelper::safeString($this->componentData->name,'W').' Dashboard';
		$this->langContent['admin'][$this->langPrefix.'_SAVE_SUCCESS']			= "Great! Item successfully saved.";
		$this->langContent['admin'][$this->langPrefix.'_SAVE_WARNING']			= "The value already existed so please select another.";
		$this->langContent['admin'][$this->langPrefix.'_HELP_MANAGER']			= "Help";
		$this->langContent['admin'][$this->langPrefix.'_NEW']				= "New";
		$this->langContent['admin'][$this->langPrefix.'_KEEP_ORIGINAL_STATE']           = "- Keep Original State -";
		$this->langContent['admin'][$this->langPrefix.'_KEEP_ORIGINAL_ACCESS']          = "- Keep Original Access -";
		$this->langContent['admin'][$this->langPrefix.'_KEEP_ORIGINAL_CATEGORY']        = "- Keep Original Category -";
		if ($this->componentData->add_license && $this->componentData->license_type == 2)
		{
			$this->langContent['admin']['NIE_REG_NIE'] = "<br /><br /><center><h1>Lincense not set for ".$this->componentData->name.".</h1><p>Notify your administrator!<br />The lincense can be obtained from ".$this->componentData->companyname.".</p></center>";
		}
		// add the langug files needed to import and export data
		if ($this->addEximport)
		{
			$this->langContent['admin'][$this->langPrefix.'_EXPORT_FAILED']					= "Export Failed";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FAILED']					= "Import Failed";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_TITLE']					= "Data Importer";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_NO_IMPORT_TYPE_FOUND']			= "Import type not found.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE']		= "Package to import not found.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_ERROR']					= "Import error.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SUCCESS']				= "Great! Import successful.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_WARNIMPORTFILE']			= "Warning, import file error.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_NO_FILE_SELECTED']			= "No import file selected.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_SELECT_A_FILE']		= "Please select a file to import.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_SELECT_ALL_COLUMNS']          = "Please link all columns.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY'] 		= "Please enter the file directory.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_WARNIMPORTUPLOADERROR']		= "Warning, import upload error.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY']	= "Please enter the file directory.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE']	= "Path does not have a valid file.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE']	= "Does not have a valid file type.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_ENTER_A_URL']			= "Please enter a url.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_INVALID_URL']			= "Invalid url.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_CONTINUE']				= "Continue";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FROM_UPLOAD']				= "Upload";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SELECT_FILE']				= "Select File";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_UPLOAD_BOTTON']				= "Upload File";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FROM_DIRECTORY']				= "Directory";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SELECT_FILE_DIRECTORY']			= "Set the path to file";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_GET_BOTTON']				= "Get File";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FROM_URL']				= "URL";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SELECT_FILE_URL']			= "Enter file URL";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_UPDATE_DATA']				= "Import Data";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FORMATS_ACCEPTED']			= "formats accepted";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_LINK_FILE_TO_TABLE_COLUMNS']		= "Link File to Table Columns";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_TABLE_COLUMNS']				= "Table Columns";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FILE_COLUMNS']				= "File Columns";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_PLEASE_SELECT_COLUMN']			= "-- Please Select Column --";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_IGNORE_COLUMN']				= "-- Ignore This Column --";
                        $this->langContent['admin'][$this->langPrefix.'_NO_ACCESS_GRANTED']				= "No Access Granted!";
		}
		// check if the both array is set
		if (isset($this->langContent['both']) && ComponentbuilderHelper::checkArray($this->langContent['both']))
		{
			foreach ($this->langContent['both'] as $keylang => $langval)
			{
				$this->langContent['admin'][$keylang] = $langval;
			}
		}

		if (isset($this->langContent['admin']) && ComponentbuilderHelper::checkArray($this->langContent['admin']))
		{
			ksort($this->langContent['admin']);
			foreach ($this->langContent['admin'] as $key => $value)
			{
				if (strlen($key) > 0)
				{
					if (!isset($lang))
					{
						$lang = '';
					}
					$lang .= $key.'="'.$value.'"'."\n";
				}
			}
			return $lang;
		}
		return '';
	}

	protected function setLangSite()
	{
		// add final list of needed lang strings
		$this->langContent['site'][$this->langPrefix] = ComponentbuilderHelper::safeString($this->componentData->name,'W');
		// some more defaults
		$this->langContent['site']['JTOOLBAR_APPLY']		= "Save";
		$this->langContent['site']['JTOOLBAR_SAVE_AS_COPY']	= "Save as Copy";
		$this->langContent['site']['JTOOLBAR_SAVE']		= "Save & Close";
		$this->langContent['site']['JTOOLBAR_SAVE_AND_NEW']	= "Save & New";
		$this->langContent['site']['JTOOLBAR_CANCEL']		= "Cancel";
		$this->langContent['site']['JTOOLBAR_CLOSE']		= "Close";
		$this->langContent['site']['JTOOLBAR_HELP']		= "Help";
		$this->langContent['site']['JGLOBAL_FIELD_ID_LABEL']		= "ID";
		$this->langContent['site']['JGLOBAL_FIELD_ID_DESC']		= "Record number in the database.";
		$this->langContent['site']['JGLOBAL_FIELD_MODIFIED_LABEL']	= "Modified Date";
		$this->langContent['site']['COM_CONTENT_FIELD_MODIFIED_DESC']	= "The last date this item was modified.";
		$this->langContent['site']['JGLOBAL_FIELD_MODIFIED_BY_LABEL']	= "Modified By";
		$this->langContent['site']['JGLOBAL_FIELD_MODIFIED_BY_DESC']	= "The user who did the last modification.";

		// check if the both array is set
		if (isset($this->langContent['both']) && ComponentbuilderHelper::checkArray($this->langContent['both']))
		{
			foreach ($this->langContent[$this->lang] as $keylang => $langval)
			{
				$this->langContent['site'][$keylang] = $langval;
			}
		}
		if (isset($this->langContent['site']) && ComponentbuilderHelper::checkArray($this->langContent['site']))
		{
			ksort($this->langContent['site']);
			foreach ($this->langContent['site'] as $key => $value)
			{
				if (strlen($key) > 0)
				{
					if (!isset($lang))
					{
						$lang = '';
					}
					$lang .= $key.'="'.$value.'"'."\n";
				}
			}
			return $lang;
		}
		return '';
	}

	protected function setLangSiteSys()
	{
		// add final list of needed lang strings
		$this->langContent['sitesys'][$this->langPrefix] = ComponentbuilderHelper::safeString($this->componentData->name,'W');

		if (isset($this->langContent['sitesys']) && ComponentbuilderHelper::checkArray($this->langContent['sitesys']))
		{
			ksort($this->langContent['sitesys']);
			foreach ($this->langContent['sitesys'] as $key => $value)
			{
				if (strlen($key) > 0)
				{
					if (!isset($lang))
					{
						$lang = '';
					}
					$lang .= $key.'="'.$value.'"'."\n";
				}
			}
			return $lang;
		}
		return '';
	}

	protected function setLangAdminSys()
	{
		if (isset($this->langContent['adminsys']) && ComponentbuilderHelper::checkArray($this->langContent['adminsys']))
		{
			ksort($this->langContent['adminsys']);
			foreach ($this->langContent['adminsys'] as $key => $value)
			{
				if (strlen($key) > 0)
				{
					if (!isset($lang))
					{
						$lang = '';
					}
					$lang .= $key.'="'.$value.'"'."\n";
				}
			}
			return $lang;
		}
		return '';
	}

	protected function setCustomAdminViewListLink($view,$viewName_list)
	{
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $custom_admin_view)
			{
				if (ComponentbuilderHelper::checkArray($custom_admin_view['adminviews']))
				{
					foreach ($custom_admin_view['adminviews'] as $adminview)
					{
						if ($view['adminview'] == $adminview)
						{
							// set the needed keys
							$setId = false;
							if (ComponentbuilderHelper::checkArray($custom_admin_view['settings']->main_get->filter))
							{
								foreach ($custom_admin_view['settings']->main_get->filter as $filter)
								{
									if ($filter['filter_type'] == 1 || '$id' == $filter['state_key'])
									{
										$setId = true;
									}
								}
							}
							// set the needed array values
							$set = array(
								'icon' => $custom_admin_view['icomoon'],
								'link' => $custom_admin_view['settings']->code,
								'NAME' => $custom_admin_view['settings']->CODE,
								'name' => $custom_admin_view['settings']->name);
							// only load to list if it has id filter
							if ($setId)
							{
								// now load it to the global object for items list
								$this->customAdminViewListLink[$viewName_list][] = $set;
								// add to set id for list view if needed
								$this->customAdminViewListId[$custom_admin_view['settings']->code] = true;
							}
							else
							{
								// now load it to the global object for tool bar
								$this->customAdminDynamicButtons[$viewName_list][] = $set;
							}
						}
					}
				}
			}
		}
	}

	protected function setListBody($viewName_single,$viewName_list)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic['###Component###'].'Helper';
			// setup correct core target
			$coreLoad = false;
			if (isset($this->permissionCore[$viewName_single]))
			{
				$core = $this->permissionCore[$viewName_single];
				$coreLoad = true;
			}
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// add the default
			$body = "<?php foreach (\$this->items as \$i => \$item): ?>";
			$body .= "\n\t<?php";
			$body .= "\n\t\t\$canCheckin = \$this->user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$this->user->id || \$item->checked_out == 0;";
			$body .= "\n\t\t\$userChkOut = JFactory::getUser(\$item->checked_out);";
			$body .= "\n\t\t\$canDo = ".$Helper."::getActions('".$viewName_single."',\$item,'".$viewName_list."');";
			$body .= "\n\t?>";
			$body .= "\n\t".'<tr class="row<?php echo $i % 2; ?>">';
			$body .= "\n\t\t".'<td class="order nowrap center hidden-phone">';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
			{
				$body .= "\n\t\t<?php if (\$canDo->get('".$core['core.edit.state']."')): ?>";
			}
			else
			{
				$body .= "\n\t\t<?php if (\$canDo->get('core.edit.state')): ?>";
			}
			$body .= "\n\t\t\t<?php";
			$body .= "\n\t\t\t\tif (\$this->saveOrder)";
			$body .= "\n\t\t\t\t{";
			$body .= "\n\t\t\t\t\t\$iconClass = ' inactive';";
			$body .= "\n\t\t\t\t}";
			$body .= "\n\t\t\t\telse";
			$body .= "\n\t\t\t\t{";
			$body .= "\n\t\t\t\t\t\$iconClass = ' inactive tip-top".'" hasTooltip" title="'."' . JHtml::tooltipText('JORDERINGDISABLED');";
			$body .= "\n\t\t\t\t}";
			$body .= "\n\t\t\t?>";
			$body .= "\n\t\t\t".'<span class="sortable-handler<?php echo $iconClass; ?>">';
			$body .= "\n\t\t\t\t".'<i class="icon-menu"></i>';
			$body .= "\n\t\t\t</span>";
			$body .= "\n\t\t\t<?php if (\$this->saveOrder) : ?>";
			$body .= "\n\t\t\t\t".'<input type="text" style="display:none" name="order[]" size="5"';
			$body .= "\n\t\t\t\t".'value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />';
			$body .= "\n\t\t\t<?php endif; ?>";
			$body .= "\n\t\t<?php else: ?>";
			$body .= "\n\t\t\t&#8942;";
			$body .= "\n\t\t<?php endif; ?>";
			$body .= "\n\t\t</td>";
			$body .= "\n\t\t".'<td class="nowrap center">';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$body .= "\n\t\t<?php if (\$canDo->get('".$core['core.edit']."')): ?>";
			}
			else
			{
				$body .= "\n\t\t<?php if (\$canDo->get('core.edit')): ?>";
			}
			$body .= "\n\t\t\t\t<?php if (\$item->checked_out) : ?>";
			$body .= "\n\t\t\t\t\t<?php if (\$canCheckin) : ?>";
			$body .= "\n\t\t\t\t\t\t<?php echo JHtml::_('grid.id', \$i, \$item->id); ?>";
			$body .= "\n\t\t\t\t\t<?php else: ?>";
			$body .= "\n\t\t\t\t\t\t&#9633;";
			$body .= "\n\t\t\t\t\t<?php endif; ?>";
			$body .= "\n\t\t\t\t<?php else: ?>";
			$body .= "\n\t\t\t\t\t<?php echo JHtml::_('grid.id', \$i, \$item->id); ?>";
			$body .= "\n\t\t\t\t<?php endif; ?>";
			$body .= "\n\t\t<?php else: ?>";
			$body .= "\n\t\t\t&#9633;";
			$body .= "\n\t\t<?php endif; ?>";
			$body .= "\n\t\t</td>";
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (isset($this->doNotEscape[$viewName_list]))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				$checkoutTriger = false;
				if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']))
				{
					$item['id'] = $item['code'];
					$item['code'] = $item['code'].'_'.$item['custom']['text'];
				}
				// check if translated vlaue is used
				if (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list])
					&& array_key_exists($item['code'],$this->selectionTranslationFixBuilder[$viewName_list]))
				{
					$itemCode = '<?php echo JText::_($item->'.$item['code'].'); ?>';
				}
				elseif ($item['custom']['text'] == 'user')
				{
					$itemCode = '<?php echo JFactory::getUser((int)$item->'.$item['code'].')->name; ?>';
				}
				elseif ($doNotEscape)
				{
					if (in_array($item['code'], $this->doNotEscape[$viewName_list]))
					{
						$itemCode = '<?php echo $item->'.$item['code'].'; ?>';
					}
					else
					{
						$itemCode = '<?php echo $this->escape($item->'.$item['code'].'); ?>';
					}
				}
				else
				{
					$itemCode = '<?php echo $this->escape($item->'.$item['code'].'); ?>';
				}
				if ($item['link'])
				{
					// allways rest custom links
					$customAdminView = '';
					// if to be linked
					if ($item['type'] == 'category' && !$item['title'])
					{
						$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
						// category and linked
						$body .= "\n\t\t".'<td class="nowrap">';
						$body .= "\n\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$otherViews.".category.' . (int)\$item->".$item['code'].")): ?>";
						$body .= "\n\t\t\t\t".'<a href="index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->'.$item['code'].'; ?>&extension=com_'.$this->fileContentStatic['###component###'].'.'.$otherViews.'"><?php echo $this->escape($item->category_title); ?></a>';
						$body .= "\n\t\t\t<?php else: ?>";
						$body .= "\n\t\t\t\t<?php echo \$this->escape(\$item->category_title); ?>";
						$body .= "\n\t\t\t<?php endif; ?>";
						$body .= "\n\t\t</td>";
					}
					elseif ($item['type'] == 'user' && !$item['title'])
					{
						// user and linked
						$body .= "\n\t\t<?php \$itemUser = JFactory::getUser(\$item->user); ?>";
						$body .= "\n\t\t".'<td class="nowrap">';
						$body .= "\n\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_users')): ?>";
						$body .= "\n\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->user ?>"><?php echo $itemUser->name; ?></a>';
						$body .= "\n\t\t\t<?php else: ?>";
						$body .= "\n\t\t\t\t<?php echo \$itemUser->name; ?>";
						$body .= "\n\t\t\t<?php endif; ?>";
						$body .= "\n\t\t</td>";
					}
					else
					{
						$add = true;
						if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] != 'user' && !$item['title'])
						{
							// link to that item instead
							$link = 'index.php?option='.$item['custom']['component'].'&view='.$item['custom']['views'].'&task='.$item['custom']['view'].'.edit&id=<?php echo $item->'.$item['id'].'; ?>&ref='.$viewName_list;
							
							$coreLoadLink = false;
							if (isset($this->permissionCore[$item['custom']['view']]))
							{
								$coreLink = $this->permissionCore[$item['custom']['view']];
								$coreLoadLink = true;
							}
							// check if the item has permissions.
							if ($coreLoadLink && isset($this->permissionBuilder[$coreLink['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$coreLink['core.edit']]) && in_array($item['custom']['view'],$this->permissionBuilder[$coreLink['core.edit']]))
							{
								$accessCheck = "\$this->user->authorise('".$coreLink['core.edit']."', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
							}
							else
							{
								$accessCheck = "\$this->user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
							}
						}
						elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] == 'user' && !$item['title'])
						{
							// user and linked
							$body .= "\n\t\t<?php \$".$item['id']." = JFactory::getUser(\$item->".$item['id']."); ?>";
							$body .= "\n\t\t".'<td class="nowrap">';
							$body .= "\n\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_users')): ?>";
							$body .= "\n\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $'.$item['id'].'->name; ?></a>';
							$body .= "\n\t\t\t<?php else: ?>";
							$body .= "\n\t\t\t\t<?php echo \$".$item['id']."->name; ?>";
							$body .= "\n\t\t\t<?php endif; ?>";
							$body .= "\n\t\t</td>";

							$add = false;
						}
						else
						{
                                                        // start building the links
							$link = '<?php echo $edit; ?>&id=<?php echo $item->id; ?>';
                                                        // check if custom links should be added to this list views
                                                        if (isset($this->customAdminViewListLink[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminViewListLink[$viewName_list]) && $firstTimeBeingAdded)
                                                        {
                                                                // make sure the custom links are only added once
                                                                $firstTimeBeingAdded = false;
                                                                // start building the links
                                                                $customAdminView = "\n\t\t\t".'<div class="btn-group">';
                                                                foreach ($this->customAdminViewListLink[$viewName_list] as $customLinkView)
                                                                {
                                                                        $customAdminView .= "\n\t\t\t<?php if (\$canDo->get('".$customLinkView['link'].".access')): ?>";
                                                                        $customAdminView .= "\n\t\t\t\t".'<a class="hasTooltip btn btn-mini" href="index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$customLinkView['link'].'&id=<?php echo $item->id; ?>" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>" ><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= "\n\t\t\t<?php else: ?>";
                                                                        $customAdminView .= "\n\t\t\t\t".'<a class="hasTooltip btn btn-mini disabled" href="#" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>"><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= "\n\t\t\t<?php endif; ?>";
                                                                }
                                                                $customAdminView .= "\n\t\t\t".'</div>';

                                                        }
							// check if the item has permissions.
							if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
							{
								// set permissions.
								$accessCheck = "\$canDo->get('".$core['core.edit']."')";
							}
							else
							{
								// set permissions.
								$accessCheck = "\$canDo->get('core.edit')";
							}
							// triger the checked out script to be added
							$checkoutTriger = true;
						}

						if ($add)
						{
							// set as linked
							$body .= "\n\t\t".'<td class="nowrap">';
							$body .= "\n\t\t\t<?php if (".$accessCheck."): ?>";
							$body .= "\n\t\t\t\t".'<div class="name">'."\n\t\t\t\t\t".'<a href="'.$link.'">'.$itemCode.'</a>';
							if ($checkoutTriger)
							{
								$body .= "\n\t\t\t\t\t<?php if (\$item->checked_out): ?>";
								$body .= "\n\t\t\t\t\t\t<?php echo JHtml::_('jgrid.checkedout', \$i, \$userChkOut->name, \$item->checked_out_time, '".$viewName_list.".', \$canCheckin); ?>";
								$body .= "\n\t\t\t\t\t<?php endif; ?>";
							}
							$body .= "\n\t\t\t\t".'</div>';
							$body .= "\n\t\t\t<?php else: ?>";
							$body .= "\n\t\t\t\t".'<div class="name">'.$itemCode.'</div>';
							$body .= "\n\t\t\t<?php endif; ?>";
                                                        $body .= $customAdminView;
							$body .= "\n\t\t</td>";
						}
					}
				}
				else
				{
					if ($item['type'] == 'category')
					{
						$body .= "\n\t\t<td class=\"hidden-phone\">";
						$body .= "\n\t\t\t<?php echo \$this->escape(\$item->category_title); ?>";
						$body .= "\n\t\t</td>";
					}
					elseif (ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] == 'user')
					{
						// custom user and linked
						$body .= "\n\t\t<?php \$".$item['code']." = JFactory::getUser(\$item->".$item['id']."); ?>";
						$body .= "\n\t\t".'<td class="nowrap hidden-phone">';
						$body .= "\n\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_users')): ?>";
						$body .= "\n\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $'.$item['code'].'->name; ?></a>';
						$body .= "\n\t\t\t<?php else: ?>";
						$body .= "\n\t\t\t\t<?php echo \$".$item['code']."->name; ?>";
						$body .= "\n\t\t\t<?php endif; ?>";
						$body .= "\n\t\t</td>";
					}
					else
					{
						// normal not linked
						$body .= "\n\t\t<td class=\"hidden-phone\">";
						$body .= "\n\t\t\t".$itemCode;
						$body .= "\n\t\t</td>";
					}
				}
			}
			// add the defaults
			$body .= "\n\t\t".'<td class="center">';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
			{
				$body .= "\n\t\t<?php if (\$canDo->get('".$core['core.edit.state']."')) : ?>";
			}
			else
			{
				$body .= "\n\t\t<?php if (\$canDo->get('core.edit.state')) : ?>";
			}
			$body .= "\n\t\t\t\t<?php if (\$item->checked_out) : ?>";
			$body .= "\n\t\t\t\t\t<?php if (\$canCheckin) : ?>";
			$body .= "\n\t\t\t\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', true, 'cb'); ?>";
			$body .= "\n\t\t\t\t\t<?php else: ?>";
			$body .= "\n\t\t\t\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', false, 'cb'); ?>";
			$body .= "\n\t\t\t\t\t<?php endif; ?>";
			$body .= "\n\t\t\t\t<?php else: ?>";
			$body .= "\n\t\t\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', true, 'cb'); ?>";
			$body .= "\n\t\t\t\t<?php endif; ?>";
			$body .= "\n\t\t<?php else: ?>";
			$body .= "\n\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', false, 'cb'); ?>";
			$body .= "\n\t\t<?php endif; ?>";
			$body .= "\n\t\t</td>";
			$body .= "\n\t\t".'<td class="nowrap center hidden-phone">';
			$body .= "\n\t\t\t<?php echo \$item->id; ?>";
			$body .= "\n\t\t</td>";
			$body .= "\n\t</tr>";
			$body .= "\n<?php endforeach; ?>";
			// return the build
			return $body;
		}
		return '';
	}

	protected function setListHead($viewName_single,$viewName_list)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// main lang prefix
			$langView = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($viewName_single,'U');
			// set status lang
			$statusLangName = $langView.'_STATUS';
			// set id lang
			$idLangName = $langView.'_ID';
			// add to lang array
			if (!isset($this->langContent[$this->lang][$statusLangName]))
			{
				$this->langContent[$this->lang][$statusLangName] = 'Status';
			}
			// add to lang array
			if (!isset($this->langContent[$this->lang][$idLangName ]))
			{
				$this->langContent[$this->lang][$idLangName] = 'Id';
			}
			// set default
			$head = '<tr>';
			$head .= "\n\t<?php if (\$this->canEdit&& \$this->canState): ?>";
			$head .= "\n\t\t".'<th width="1%" class="nowrap center hidden-phone">';
			$head .= "\n\t\t\t<?php echo JHtml::_('grid.sort', '".'<i class="icon-menu-2"></i>'."', 'ordering', \$this->listDirn, \$this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>";
			$head .= "\n\t\t</th>";
			$head .= "\n\t\t".'<th width="20" class="nowrap center">';
			$head .= "\n\t\t\t<?php echo JHtml::_('grid.checkall'); ?>";
			$head .= "\n\t\t</th>";
			$head .= "\n\t<?php else: ?>";
			$head .= "\n\t\t".'<th width="20" class="nowrap center hidden-phone">';
			$head .= "\n\t\t\t&#9662;";
			$head .= "\n\t\t</th>";
			$head .= "\n\t\t".'<th width="20" class="nowrap center">';
			$head .= "\n\t\t\t&#9632;";
			$head .= "\n\t\t</th>";
			$head .= "\n\t<?php endif; ?>";
			// set footer Column number
			$this->listColnrBuilder[$viewName_list] = 4;
			// build the dynamic fields
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				if (ComponentbuilderHelper::checkArray($item['custom']))
				{
					$item['code'] = $item['code'].'_'.$item['custom']['text'];
				}
				$class = 'nowrap hidden-phone';
				if ($item['link'])
				{
					$class = 'nowrap';
				}
				$title = "<?php echo JText::_('".$item['lang']."'); ?>";
				if ($item['sort'])
				{
					$title = "<?php echo JHtml::_('grid.sort', '".$item['lang']."', '".$item['code']."', \$this->listDirn, \$this->listOrder); ?>";
				}
				$head .= "\n\t".'<th class="'.$class.'" >';
				$head .= "\n\t\t\t".$title;
				$head .= "\n\t</th>";
				$this->listColnrBuilder[$viewName_list]++;
			}
			// set default
			$head .= "\n\t<?php if (\$this->canState): ?>";
 			$head .= "\n\t\t".'<th width="10" class="nowrap center" >';
   			$head .= "\n\t\t\t<?php echo JHtml::_('grid.sort', '".$statusLangName."', 'published', \$this->listDirn, \$this->listOrder); ?>";
 			$head .= "\n\t\t</th>";
			$head .= "\n\t<?php else: ?>";
 			$head .= "\n\t\t".'<th width="10" class="nowrap center" >';
   			$head .= "\n\t\t\t<?php echo JText::_('".$statusLangName."'); ?>";
 			$head .= "\n\t\t</th>";
			$head .= "\n\t<?php endif; ?>";
 			$head .= "\n\t".'<th width="5" class="nowrap center hidden-phone" >';
 			$head .= "\n\t\t\t<?php echo JHtml::_('grid.sort', '".$idLangName."', 'id', \$this->listDirn, \$this->listOrder); ?>";
 			$head .= "\n\t</th>";
 			$head .= "\n</tr>";

			return $head;
		}
		return '';
	}

	protected function setListColnr($viewName_list)
	{
		if (isset($this->listColnrBuilder[$viewName_list]))
		{
			return $this->listColnrBuilder[$viewName_list];
		}
		return '';
	}

	protected function setEditBody(&$view)
	{
		// set view name
		$viewName_single = ComponentbuilderHelper::safeString($view['settings']->name_single);
		// alignment
		$alignmentNames = array(1 => 'left', 2 => 'right', 3 => 'fullwidth', 4 => 'above', 5 => 'under', 6 => 'leftside', 7 => 'rightside');
		// main lang prefix
		$langView = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($viewName_single,'U');

		if (isset($this->layoutBuilder[$viewName_single]) && ComponentbuilderHelper::checkArray($this->layoutBuilder[$viewName_single]))
		{
			// set the linked view tabs
			$linkedTab = array();
			$keys = array();
			if (isset($this->linkedAdminViews[$viewName_single]) && ComponentbuilderHelper::checkArray($this->linkedAdminViews[$viewName_single]))
			{
				foreach ($this->linkedAdminViews[$viewName_single] as $linkedView)
				{
					$tabName = $view['settings']->tabs[(int) $linkedView['tab']];
					$this->tabCounter[$viewName_single][$linkedView['tab']] = $tabName;
					$linkedTab[$linkedView['adminview']] = $linkedView['tab'];
					if (ComponentbuilderHelper::checkString($linkedView['key']) && ComponentbuilderHelper::checkString($linkedView['parentkey']))
					{
						$keys[$linkedView['adminview']] = array( 'key' => $linkedView['key'], 'parentKey' => $linkedView['parentkey']);
					}
					else
					{
						$keys[$linkedView['adminview']] = array( 'key' => null, 'parentKey' => null);
					}
					if (isset($linkedView['addnew']))
					{
						$keys[$linkedView['adminview']]['addNewButton'] = (int) $linkedView['addnew'];
					}
					else
					{
						$keys[$linkedView['adminview']]['addNewButton'] = 0;
					}
				}
			}
			// start tab set
			$bucket = array();
			$leftside 	= '';
			$rightside 	= '';
			$footer = '';
			$header = '';
			$mainwidth = 12;
			$sidewidth = 0;
			ksort($this->tabCounter[$viewName_single]);
			foreach ($this->tabCounter[$viewName_single] as $tabNr => $tabName)
			{
				$tabWidth = 12;
				$lrCounter = 0;
				// set tab lang
				$tabLangName = $langView.'_'.ComponentbuilderHelper::safeString($tabName,'U');
				// set tab code name
				$tabCodeName = ComponentbuilderHelper::safeString($tabName);
				// add to lang array
				if (!isset($this->langContent[$this->lang][$tabLangName]))
				{
					$this->langContent[$this->lang][$tabLangName] = $tabName;
				}
				// check if linked view belongs to this tab
				$buildLayout = true;
				$linkedViewId = '';
				if (ComponentbuilderHelper::checkArray($linkedTab))
				{
					$linkedViewId = array_search($tabNr,$linkedTab);
					if ($linkedViewId)
					{
						// don't build
						$buildLayout = false;
					}
				}
				if ($buildLayout)
				{
					// sort to make sure it loads left first
					$alignments = $this->layoutBuilder[$viewName_single][$tabName];
					ksort($alignments);
					foreach ($alignments as $alignment => $names)
					{
						// set layout code name
						$layoutCodeName = $tabCodeName.'_'.$alignmentNames[$alignment];
						// reset each time
						$items  = '';
						$itemCounter = 0;
						ksort($names);
						foreach ($names as $nr => $name)
						{
							if ($itemCounter == 0)
							{
								$items .= "'".$name."'";
							}
							else
							{
								$items .= ",\n\t'".$name."'";
							}
							$itemCounter++;
						}
						switch($alignment)
						{
							case 1: // left
							case 2: // right
								// count
								$lrCounter++;
								// set as items layout
								$this->setLayout($viewName_single,$layoutCodeName,$items,'layoutitems');
								// set the lang to tab
								$bucket[$tabCodeName]['lang'] = $tabLangName;
								// load the body
								if (!isset($bucket[$tabCodeName][(int) $alignment]))
								{
									$bucket[$tabCodeName][(int) $alignment] = '';
								}
								$bucket[$tabCodeName][(int) $alignment] .= "<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 3: // fullwidth
								// set as items layout
								$this->setLayout($viewName_single,$layoutCodeName,$items,'layoutfull');
								// set the lang to tab
								$bucket[$tabCodeName]['lang'] = $tabLangName;
								// load the body
								if (!isset($bucket[$tabCodeName][(int) $alignment]))
								{
									$bucket[$tabCodeName][(int) $alignment] = '';
								}
								$bucket[$tabCodeName][(int) $alignment] .= "<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 4: // above
								// set as title layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layouttitle');
								// load to header
								$header .= "\n\t<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 5: // under
								// set as title layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layouttitle');
								// load to footer
								$footer .= "\n\n<div class=\"clearfix\"></div>\n<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 6: // left side
								$tabWidth = $tabWidth - 2;
								// set as items layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layoutitems');
								// load the body
								$leftside .= "\n\t<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 7: // right side
								$tabWidth = $tabWidth - 2;
								// set as items layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layoutitems');
								// load the body
								$rightside .= "\n\t<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
						}
					}
				}
				else
				{
					// set layout code name
					$layoutCodeName = $tabCodeName.'_fullwidth';
					//set function name
					$codeName = ComponentbuilderHelper::safeString(ComponentbuilderHelper::randomkey(3).$tabCodeName);
					// set as items layout
					$this->setLayout($viewName_single,$layoutCodeName,$codeName,'layoutlinkedview');
					// set the lang to tab
					$bucket[$tabCodeName]['lang'] = $tabLangName;
					// set all the linked view stuff
					$this->secondRunAdmin['setLinkedView'][] = array(
						'viewId' => $linkedViewId,
						'viewName_single' => $viewName_single,
						'codeName' => $codeName,
						'layoutCodeName' => $layoutCodeName,
						'key' => $keys[$linkedViewId]['key'],
						'parentKey' => $keys[$linkedViewId]['parentKey'],
						'addNewButon' => $keys[$linkedViewId]['addNewButton']);
					// load the body
					if (!isset($bucket[$tabCodeName][3]))
					{
						$bucket[$tabCodeName][3] = '';
					}
					$bucket[$tabCodeName][3] .= "<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
				}
				// width calculator :)
				if ($tabWidth == 8)
				{
					$mainwidth = 8;
					$sidewidth = 2;
				}
				elseif ($tabWidth == 10 && $mainwidth != 8)
				{
					$mainwidth = 9;
					$sidewidth = 3;
				}
				$bucket[$tabCodeName]['lr'] = $lrCounter;
			}
			// tab counter
			$tabCounter = 0;
			// check if width is still 12
			$span = '';
			if ($mainwidth != 12)
			{
				$span = ' span'.$mainwidth;
			}
			// start building body
			$body = '<div class="form-horizontal'.$span.'">';
			// now build the template
			foreach ($bucket as $tabCodeName => $posions)
			{
				// check main if both left and right is set
				$lrCounter = $posions['lr'];
				// get lang string
				$tabLangName = $posions['lang'];
				// build main center
				$main 		= '';
				$mainbottom = '';
				foreach ($posions as $posion => $string)
				{
					if ($lrCounter == 2)
					{
						switch($posion)
						{
							case 1: // left
							case 2: // right
								$main .= "\n\t\t\t".'<div class="span6">';
								$main .= "\n\t\t\t\t".$string;
								$main .= "\n\t\t\t".'</div>';
							break;
						}
					}
					else
					{
						switch($posion)
						{
							case 1: // left
							case 2: // right
								$main .= "\n\t\t\t".'<div class="span12">';
								$main .= "\n\t\t\t\t".$string;
								$main .= "\n\t\t\t".'</div>';
							break;
						}
					}
					switch($posion)
					{
						case 3: // fullwidth
							$mainbottom .= "\n\t\t\t".'<div class="span12">';
							$mainbottom .= "\n\t\t\t\t".$string;
							$mainbottom .= "\n\t\t\t".'</div>';
						break;
					}
				}
				// set acctive tab
				if ($tabCounter == 0)
				{
					$body .= "\n\n\t<?php echo JHtml::_('bootstrap.startTabSet', '".$viewName_single."Tab', array('active' => '".$tabCodeName."')); ?>";
				}
				// start tab
				$body .= "\n\n\t<?php echo JHtml::_('bootstrap.addTab', '".$viewName_single."Tab', '".$tabCodeName."', JText::_('".$tabLangName."', true)); ?>";
				// add the main
				$body .= "\n\t\t".'<div class="row-fluid form-horizontal-desktop">';
				$body .= $main;
				$body .= "\n\t\t</div>";
				if (strlen($mainbottom) > 0)
				{
					// add the main bottom
					$body .= "\n\t\t".'<div class="row-fluid form-horizontal-desktop">';
					$body .= $mainbottom;
					$body .= "\n\t\t</div>";
				}
				$body .= "\n\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
				// set counter
				$tabCounter++;
			}
			// set default publishing tab lang
			$tabLangName = $langView.'_PUBLISHING';
			// add to lang array
			if (!isset($this->langContent[$this->lang][$tabLangName]))
			{
				$this->langContent[$this->lang][$tabLangName] = 'Publishing';
			}
			// check if access is added to this view
			if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
			{
				$addAccess = ",\n\t'access'";
			}
			else
			{
				$addAccess = "";
			}
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName_single]))
			{
				// set default publishing tab code name
				$tabCodeNameLeft = 'publishing';
				$tabCodeNameRight = 'metadata';
				// the default publishing tiems
				$items = "'created',\n\t'created_by',\n\t'modified',\n\t'modified_by',\n\t'published',\n\t'ordering'".$addAccess.",\n\t'version',\n\t'hits',\n\t'id'";
				// set the publishing layout
				$this->setLayout($viewName_single, $tabCodeNameLeft, $items, 'layoutpublished');
				$this->setLayout($viewName_single, $tabCodeNameRight, false, 'layoutmetadata');
			}
			else
			{
				// set default publishing tab code name
				$tabCodeNameLeft = 'publishing';
				$tabCodeNameRight = 'publlshing';
				// the default publishing tiems
				$items_one = "'created',\n\t'created_by',\n\t'modified',\n\t'modified_by'";
				$items_two = "'published',\n\t'ordering'".$addAccess.",\n\t'version',\n\t'hits',\n\t'id'";
				// set the publishing layout
				$this->setLayout($viewName_single, $tabCodeNameLeft, $items_one, 'layoutpublished');
				$this->setLayout($viewName_single, $tabCodeNameRight, $items_two, 'layoutpublished');
			}
			// set the default publishing tab
			$body .= "\n\n\t<?php echo JHtml::_('bootstrap.addTab', '".$viewName_single."Tab', '".$tabCodeNameLeft."', JText::_('".$tabLangName."', true)); ?>";
			$body .= "\n\t\t".'<div class="row-fluid form-horizontal-desktop">';
			$body .= "\n\t\t\t".'<div class="span6">';
			$body .= "\n\t\t\t\t<?php echo JLayoutHelper::render('".$viewName_single.".".$tabCodeNameLeft."', \$this); ?>";
			$body .= "\n\t\t\t</div>";
			$body .= "\n\t\t\t".'<div class="span6">';
			$body .= "\n\t\t\t\t<?php echo JLayoutHelper::render('".$viewName_single.".".$tabCodeNameRight."', \$this); ?>";
			$body .= "\n\t\t\t</div>";
			$body .= "\n\t\t</div>";
			$body .= "\n\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
			// make sure we dont load it to a view with the name component
			if ($viewName_single != 'component')
			{
				// set permissions tab lang
				$tabLangName = $langView.'_PERMISSION';
				// set permissions tab code name
				$tabCodeName = 'permissions';
				// add to lang array
				if (!isset($this->langContent[$this->lang][$tabLangName]))
				{
					$this->langContent[$this->lang][$tabLangName] = 'Permissions';
				}
				// set the permissions tab
				$body .= "\n\n\t<?php if (\$this->canDo->get('core.admin')) : ?>";
				$body .= "\n\t<?php echo JHtml::_('bootstrap.addTab', '".$viewName_single."Tab', '".$tabCodeName."', JText::_('".$tabLangName."', true)); ?>";
				$body .= "\n\t\t".'<div class="row-fluid form-horizontal-desktop">';
				$body .= "\n\t\t\t".'<div class="span12">';
				$body .= "\n\t\t\t\t".'<fieldset class="adminform">';
				$body .= "\n\t\t\t\t\t".'<div class="adminformlist">';
				$body .= "\n\t\t\t\t\t<?php foreach (\$this->form->getFieldset('accesscontrol') as \$field): ?>";
				$body .= "\n\t\t\t\t\t\t<div>";
				$body .= "\n\t\t\t\t\t\t\t<?php echo \$field->label; echo \$field->input;?>";
				$body .= "\n\t\t\t\t\t\t</div>";
				$body .= "\n\t\t\t\t\t\t".'<div class="clearfix"></div>';
				$body .= "\n\t\t\t\t\t<?php endforeach; ?>";
				$body .= "\n\t\t\t\t\t</div>";
				$body .= "\n\t\t\t\t</fieldset>";
				$body .= "\n\t\t\t</div>";
				$body .= "\n\t\t</div>";
				$body .= "\n\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
				$body .= "\n\t<?php endif; ?>";
			}
			// end the tab set
			$body .= "\n\n\t<?php echo JHtml::_('bootstrap.endTabSet'); ?>";
			$body .= "\n\n\t<div>";
			$body .= "\n\t\t".'<input type="hidden" name="task" value="'.$viewName_single.'.edit" />';
			$body .= "\n\t\t<?php echo JHtml::_('form.token'); ?>";
			$body .= "\n\t</div>";
			$body .= "\n</div>";
			// check if left has been set
			if (strlen($leftside) > 0 )
			{
				$left = '<div class="span'.$sidewidth.'">'.$leftside."\n</div>";
			}
			else
			{
				$left = '';
			}
			// check if right has been set
			if (strlen($rightside) > 0 )
			{
				$right = '<div class="span'.$sidewidth.'">'.$rightside."\n</div>";
			}
			else
			{
				$right = '';
			}
			// set active tab and return
			return $header.$left.$body.$right.$footer;
		}
		return '';
	}

	protected function setLayout($viewName_single, $layoutName, $items, $type)
	{
		// first build the layout file
		$target = array('admin' => $viewName_single);
		$this->buildDynamique($target,$type,$layoutName);
		// add to front if needed
		if ($this->lang == 'both')
		{
			$target = array('site' => $viewName_single);
			$this->buildDynamique($target,$type,$layoutName);
		}
		if (ComponentbuilderHelper::checkString($items))
		{
			// ###LAYOUTITEMS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single.'_'.$layoutName]['###LAYOUTITEMS###'] = $items;
		}
		else
		{
			// ###LAYOUTITEMS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single.'_'.$layoutName]['###bogus###'] = 'boom';
		}
	}

	protected function setLinkedView($args)
	{
		extract($args, EXTR_PREFIX_SAME, "oops");
		$single = '';
		$list 	= '';
		foreach ($this->componentData->admin_views as $array)
		{
			if ($array['adminview'] == $viewId)
			{
				$single = ComponentbuilderHelper::safeString($array['settings']->name_single);
				$list = ComponentbuilderHelper::safeString($array['settings']->name_list);
				break;
			}
		}
		if (ComponentbuilderHelper::checkString($single) && ComponentbuilderHelper::checkString($list))
		{
			$head = $this->setListHeadLinked($single,$list,$addNewButon);
			$body = $this->setListBodyLinked($single,$list,$viewName_single);
			$functionName = ComponentbuilderHelper::safeString($codeName,'F');
			// ###LAYOUTITEMSTABLE### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSTABLE###'] = $head.$body;
			// ###LAYOUTITEMSHEADER### <<<DYNAMIC>>>
			$headerscript = '$edit	= "index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$list.'&task='.$single.'.edit";';
			if ($addNewButon)
			{
				$headerscript .= "\n".'$ref	= ($id) ? "&ref='.$viewName_single.'&refid=".$id : "";';
				$headerscript .= "\n".'$new	= "index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$single.'&layout=edit".$ref;';
				$headerscript .= "\n".'$can	= '.$this->fileContentStatic['###Component###'].'Helper::getActions('."'".$single."'".');';
			}
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSHEADER###'] = $headerscript;
			// ###LINKEDVIEWITEMS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWITEMS###'] .=  "\n\n\t\t//".$this->setLine(__LINE__)." Get Linked view data\n\t\t\$this->".$codeName."\t\t= \$this->get('".$functionName."');";
			// ###LINKEDVIEWTABLESCRIPTS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWTABLESCRIPTS###'] = $this->setFootableScripts();
			if(strpos($parentKey, '-R>') !== false || strpos($parentKey, '-A>') !== false)
			{
				list($parent_key) = explode('-',$parentKey);
			}
			else
			{
				$parent_key = $parentKey;
			}
			if(strpos($key, '-R>') !== false || strpos($key, '-A>') !== false)
			{
				list($_key) = explode('-',$key);
			}
			else
			{
				$_key = $key;
			}
			// set the global key
			$globalKey = ComponentbuilderHelper::safeString($_key.ComponentbuilderHelper::randomkey(4));
			// ###LINKEDVIEWGLOBAL### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWGLOBAL###'] .= "\n\t\t\$this->".$globalKey." = \$item->".$parent_key.";";
			// ###LINKEDVIEWMETHODS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWMETHODS###'] .= $this->setListQueryLinked($single, $list, $functionName, $key, $_key, $parentKey, $parent_key, $globalKey);
		}
		else
		{
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSTABLE###'] = 'oops! error.....';
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSHEADER###'] = '';
		}
	}

	protected function setFootableScripts($init = true, $document = '$document')
	{
		$foo = "\n\n\t\t//".$this->setLine(__LINE__)." Add the CSS for Footable.";
		$foo .= "\n\t\t".$document."->addStyleSheet(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/css/footable.core.min.css');";
		$foo .= "\n\n\t\t//".$this->setLine(__LINE__)." Use the Metro Style";
		$foo .= "\n\t\tif (!isset(\$this->fooTableStyle) || 0 == \$this->fooTableStyle)";
		$foo .= "\n\t\t{";
		$foo .= "\n\t\t\t".$document."->addStyleSheet(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/css/footable.metro.min.css');";
		$foo .= "\n\t\t}";
		$foo .= "\n\t\t//".$this->setLine(__LINE__)." Use the Legacy Style.";
		$foo .= "\n\t\telseif (isset(\$this->fooTableStyle) && 1 == \$this->fooTableStyle)";
		$foo .= "\n\t\t{";
		$foo .= "\n\t\t\t".$document."->addStyleSheet(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/css/footable.standalone.min.css');";
		$foo .= "\n\t\t}";
		$foo .= "\n\n\t\t//".$this->setLine(__LINE__)." Add the JavaScript for Footable";
		$foo .= "\n\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.js');";
		$foo .= "\n\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.sort.js');";
		$foo .= "\n\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.filter.js');";
		$foo .= "\n\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.paginate.js');";
		if ($init)
		{
			$foo .= "\n\n\t\t".'$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery('."'.footable'".').footable(); }); jQuery('."'.nav-tabs'".').on('."'click'".', '."'li'".', function() { setTimeout(tableFix, 10); }); }); function tableFix() { jQuery('."'.footable'".').trigger('."'footable_resize'".'); }";';
			$foo .= "\n\t\t\$document->addScriptDeclaration(\$footable);\n";
		}
		return $foo;
	}

	protected function setListBodyLinked($viewName_single,$viewName_list,$refview)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic['###Component###'].'Helper';
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// setup correct core target
			$coreLoad = false;
			if (isset($this->permissionCore[$viewName_single]))
			{
				$core = $this->permissionCore[$viewName_single];
				$coreLoad = true;
			}
			$counter = 0;
			// add the default
			$body = "\n<tbody>";
			$body .= "\n<?php foreach (\$items as \$i => \$item): ?>";
			$body .= "\n\t<?php";
			$body .= "\n\t\t\$canCheckin = \$user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$user->id || \$item->checked_out == 0;";
			$body .= "\n\t\t\$userChkOut = JFactory::getUser(\$item->checked_out);";
			$body .= "\n\t\t\$canDo = ".$Helper."::getActions('".$viewName_single."',\$item,'".$viewName_list."');";
			$body .= "\n\t?>";
			$body .= "\n\t".'<tr>';
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (isset($this->doNotEscape[$viewName_list]))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				$counter++;
				$checkoutTriger = false;
				if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']))
				{
					$item['id'] = $item['code'];
					$item['code'] = $item['code'].'_'.$item['custom']['text'];
				}
				// check if translated vlaue is used
				if (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list])
					&& array_key_exists($item['code'],$this->selectionTranslationFixBuilder[$viewName_list]))
				{
					$itemCode = '<?php echo JText::_($item->'.$item['code'].'); ?>';
				}
				elseif ($item['custom']['text'] == 'user')
				{
					$itemCode = '<?php echo JFactory::getUser((int)$item->'.$item['code'].')->name; ?>';
				}
				elseif ($doNotEscape)
				{
					if (in_array($item['code'], $this->doNotEscape[$viewName_list]))
					{
						$itemCode = '<?php echo $item->'.$item['code'].'; ?>';
					}
					else
					{
						$itemCode = '<?php echo $displayData->escape($item->'.$item['code'].'); ?>';
					}
				}
				else
				{
					$itemCode = '<?php echo $displayData->escape($item->'.$item['code'].'); ?>';
				}

				if ($item['link'])
				{
					// allways rest custom links
					$customAdminView = '';
					// if to be linked
					if ($item['type'] == 'category' && !$item['title'])
					{
						$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
						// category and linked
						$body .= "\n\t\t".'<td class="nowrap">';
						$body .= "\n\t\t\t<?php if (\$user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$otherViews.".category.' . (int)\$item->".$item['code'].")): ?>";
						$body .= "\n\t\t\t\t".'<a href="index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->'.$item['code'].'; ?>&extension=com_'.$this->fileContentStatic['###component###'].'.'.$otherViews.'"><?php echo $displayData->escape($item->category_title); ?></a>';
						$body .= "\n\t\t\t<?php else: ?>";
						$body .= "\n\t\t\t\t<?php echo \$displayData->escape(\$item->category_title); ?>";
						$body .= "\n\t\t\t<?php endif; ?>";
						$body .= "\n\t\t</td>";
					}
					elseif ($item['type'] == 'user' && !$item['title'])
					{
						// user and linked
						$body .= "\n\t\t<?php \$itemUser = JFactory::getUser(\$item->user); ?>";
						$body .= "\n\t\t".'<td class="nowrap">';
						$body .= "\n\t\t\t<?php if (\$user->authorise('core.edit', 'com_users')): ?>";
						$body .= "\n\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->user ?>"><?php echo $itemUser->name; ?></a>';
						$body .= "\n\t\t\t<?php else: ?>";
						$body .= "\n\t\t\t\t<?php echo \$itemUser->name; ?>";
						$body .= "\n\t\t\t<?php endif; ?>";
						$body .= "\n\t\t</td>";
					}
					else
					{
						$add = true;
						if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] != 'user' && !$item['title'])
						{
							if ($refview == $item['custom']['view'])
							{
								// normal not linked
								$body .= "\n\t\t<td>";
								$body .= "\n\t\t\t".$itemCode;
								$body .= "\n\t\t</td>";

								$add = false;
							}
							else
							{
								// link to that item instead
								$link = 'index.php?option='.$item['custom']['component'].'&view='.$item['custom']['views'].'&task='.$item['custom']['view'].'.edit&id=<?php echo $item->'.$item['id'].'; ?>&ref='.$refview.'&refid=<?php echo $id; ?>';

								
								$coreLoadLink = false;
								if (isset($this->permissionCore[$item['custom']['view']]))
								{
									$coreLink = $this->permissionCore[$item['custom']['view']];
									$coreLoadLink = true;
								}
								// check if the item has permissions.
								if ($coreLoadLink && isset($this->permissionBuilder[$coreLink['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$coreLink['core.edit']]) && in_array($item['custom']['view'],$this->permissionBuilder[$coreLink['core.edit']]))
								{
									$accessCheck = "\$user->authorise('".$coreLink['core.edit']."', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
								}
								else
								{
									$accessCheck = "\$user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
								}
							}
						}
						elseif (ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] == 'user' && !$item['title'])
						{
							// user and linked
							$body .= "\n\t\t<?php \$_".$item['id']." = JFactory::getUser(\$item->".$item['id']."); ?>";
							$body .= "\n\t\t".'<td class="nowrap">';
							$body .= "\n\t\t\t<?php if (\$user->authorise('core.edit', 'com_users')): ?>";
							$body .= "\n\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $_'.$item['id'].'->name; ?></a>';
							$body .= "\n\t\t\t<?php else: ?>";
							$body .= "\n\t\t\t\t<?php echo \$_".$item['id']."->name; ?>";
							$body .= "\n\t\t\t<?php endif; ?>";
							$body .= "\n\t\t</td>";

							$add = false;
						}
						else
						{
							$link = '<?php echo $edit; ?>&id=<?php echo $item->id; ?>&ref='.$refview.'&refid=<?php echo $id; ?>';
							// check if custom links should be added to this list views
							if (isset($this->customAdminViewListLink[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminViewListLink[$viewName_list]) && $firstTimeBeingAdded)
							{
								// make sure the custom links are only added once
								$firstTimeBeingAdded = false;
								// start building the links
								$customAdminView = "\n\t\t\t".'<div class="btn-group">';
								foreach ($this->customAdminViewListLink[$viewName_list] as $customLinkView)
								{
                                                                        $customAdminView .= "\n\t\t\t<?php if (\$canDo->get('".$customLinkView['link'].".access')): ?>";
									$customAdminView .= "\n\t\t\t\t".'<a class="hasTooltip btn btn-mini" href="index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$customLinkView['link'].'&id=<?php echo $item->id; ?>&ref='.$refview.'&refid=<?php echo $id; ?>" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>" ><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= "\n\t\t\t<?php else: ?>";
									$customAdminView .= "\n\t\t\t\t".'<a class="hasTooltip btn btn-mini disabled" href="#" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>"><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= "\n\t\t\t<?php endif; ?>";
								}
								$customAdminView .= "\n\t\t\t".'</div>';

							}
							// check if the item has permissions.
							if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
							{
								// set permissions.
								$accessCheck = "\$canDo->get('".$core['core.edit']."')";
							}
							else
							{
								// set permissions.
								$accessCheck = "\$canDo->get('core.edit')";
							}
							// triger the checked out script to be added
							$checkoutTriger = true;
						}

						if ($add)
						{
							// set as linked
							$body .= "\n\t\t".'<td class="nowrap">';
							$body .= "\n\t\t\t<?php if (".$accessCheck."): ?>";
							$body .= "\n\t\t\t\t".'<a href="'.$link.'">'.$itemCode.'</a>';
							if ($checkoutTriger)
							{
								$body .= "\n\t\t\t\t\t<?php if (\$item->checked_out): ?>";
								$body .= "\n\t\t\t\t\t\t<?php echo JHtml::_('jgrid.checkedout', \$i, \$userChkOut->name, \$item->checked_out_time, '".$viewName_list.".', \$canCheckin); ?>";
								$body .= "\n\t\t\t\t\t<?php endif; ?>";
							}
							$body .= "\n\t\t\t<?php else: ?>";
							$body .= "\n\t\t\t\t".'<div class="name">'.$itemCode.'</div>';
							$body .= "\n\t\t\t<?php endif; ?>";
                                                        $body .= $customAdminView;
							$body .= "\n\t\t</td>";
						}
					}
				}
				else
				{
					if ($item['type'] == 'category')
					{
						$body .= "\n\t\t<td>";
						$body .= "\n\t\t\t<?php echo \$displayData->escape(\$item->category_title); ?>";
						$body .= "\n\t\t</td>";
					}
					elseif (ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] == 'user')
					{
						// custom user and linked
						$body .= "\n\t\t<?php \$_".$item['code']." = JFactory::getUser(\$item->".$item['id']."); ?>";
						$body .= "\n\t\t".'<td>';
						$body .= "\n\t\t\t<?php if (\$user->authorise('core.edit', 'com_users')): ?>";
						$body .= "\n\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $_'.$item['code'].'->name; ?></a>';
						$body .= "\n\t\t\t<?php else: ?>";
						$body .= "\n\t\t\t\t<?php echo \$_".$item['code']."->name; ?>";
						$body .= "\n\t\t\t<?php endif; ?>";
						$body .= "\n\t\t</td>";
					}
					else
					{
						// normal not linked
						$body .= "\n\t\t<td>";
						$body .= "\n\t\t\t".$itemCode;
						$body .= "\n\t\t</td>";
					}
				}
			}
			$counter = $counter + 2;
			// add the defaults
			$body .= "\n\t\t<?php if (\$item->published == 1):?>";
                        $body .= "\n\t\t\t".'<td class="center"  data-value="1">';
                        $body .= "\n\t\t\t\t".'<span class="status-metro status-published" title="<?php echo JText::_('."'PUBLISHED'".');  ?>">';
                        $body .= "\n\t\t\t\t\t".'<?php echo JText::_('."'PUBLISHED'".'); ?>';
                        $body .= "\n\t\t\t\t".'</span>';
                        $body .= "\n\t\t\t".'</td>';

			$body .= "\n\t\t<?php elseif (\$item->published == 0):?>";
                        $body .= "\n\t\t\t".'<td class="center"  data-value="2">';
                        $body .= "\n\t\t\t\t".'<span class="status-metro status-inactive" title="<?php echo JText::_('."'INACTIVE'".');  ?>">';
                        $body .= "\n\t\t\t\t\t".'<?php echo JText::_('."'INACTIVE'".'); ?>';
                        $body .= "\n\t\t\t\t".'</span>';
                        $body .= "\n\t\t\t".'</td>';

			$body .= "\n\t\t<?php elseif (\$item->published == 2):?>";
                        $body .= "\n\t\t\t".'<td class="center"  data-value="3">';
                        $body .= "\n\t\t\t\t".'<span class="status-metro status-archived" title="<?php echo JText::_('."'ARCHIVED'".');  ?>">';
                        $body .= "\n\t\t\t\t\t".'<?php echo JText::_('."'ARCHIVED'".'); ?>';
                        $body .= "\n\t\t\t\t".'</span>';
                        $body .= "\n\t\t\t".'</td>';

			$body .= "\n\t\t<?php elseif (\$item->published == -2):?>";
                        $body .= "\n\t\t\t".'<td class="center"  data-value="4">';
                        $body .= "\n\t\t\t\t".'<span class="status-metro status-trashed" title="<?php echo JText::_('."'ARCHIVED'".');  ?>">';
                        $body .= "\n\t\t\t\t\t".'<?php echo JText::_('."'ARCHIVED'".'); ?>';
                        $body .= "\n\t\t\t\t".'</span>';
                        $body .= "\n\t\t\t".'</td>';
                        $body .= "\n\t\t".'<?php endif; ?>';

			$body .= "\n\t\t".'<td class="nowrap center hidden-phone">';
			$body .= "\n\t\t\t<?php echo \$item->id; ?>";
			$body .= "\n\t\t</td>";
			$body .= "\n\t</tr>";
			$body .= "\n<?php endforeach; ?>";
			$body .= "\n</tbody>";
                        $body .= "\n".'<tfoot class="hide-if-no-paging">';
                        $body .= "\n\t".'<tr>';
                        $body .= "\n\t\t".'<td colspan="'.$counter.'">';
                        $body .= "\n\t\t\t".'<div class="pagination pagination-centered"></div>';
                        $body .= "\n\t\t".'</td>';
                        $body .= "\n\t".'</tr>';
                        $body .= "\n".'</tfoot>';
                        $body .= "\n".'</table>';
			$body .= "\n".'<?php else: ?>';
			$body .= "\n\t".'<div class="alert alert-no-items">';
			$body .= "\n\t\t".'<?php echo JText::_('."'JGLOBAL_NO_MATCHING_RESULTS'".'); ?>';
			$body .= "\n\t".'</div>';
			$body .= "\n".'<?php endif; ?>';
			// return the build
			return $body;
		}
		return '';
	}

	protected function setListHeadLinked($viewName_single,$viewName_list,$addNewButon)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic['###Component###'].'Helper';
			$head = '';
			// only add new button if set
			if ($addNewButon)
			{
				// setup correct core target
				$coreLoad = false;
				if (isset($this->permissionCore[$viewName_single]))
				{
					$core = $this->permissionCore[$viewName_single];
					$coreLoad = true;
				}
				// check if the item has permissions.
				if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
				{
					// set permissions.
					$accessCheck = "\$can->get('".$core['core.create']."')";
				}
				else
				{
					// set permissions.
					$accessCheck = "\$can->get('core.create')";
				}
				// add a button for new
				$head = '<?php if ('.$accessCheck.'): ?>';
				$head .= "\n\t".'<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo JText::_('."'".$this->langPrefix."_NEW'".'); ?></a><br /><br />';
				$head .= "\n".'<?php endif; ?>'."\n";
			}
			$head .= '<?php if ('.$Helper.'::checkArray($items)): ?>';
			// add some filters

			$head .= "\n".'<table class="footable table data '.$viewName_list.' metro-blue" data-filter="#filter_'.$viewName_list.'" data-page-size="20">';
			$head .= "\n<thead>";
			// main lang prefix
			$langView = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($viewName_single,'U');
			// set status lang
			$statusLangName = $langView.'_STATUS';
			// set id lang
			$idLangName = $langView.'_ID';
			// make sure only first link is used as togeler
			$firstLink = true;
			// add to lang array
			if (!isset($this->langContent[$this->lang][$statusLangName]))
			{
				$this->langContent[$this->lang][$statusLangName] = 'Status';
			}
			// add to lang array
			if (!isset($this->langContent[$this->lang][$idLangName ]))
			{
				$this->langContent[$this->lang][$idLangName] = 'Id';
			}
 			$head .= "\n\t<tr>";
			// set controller for data hiding options
			$controller = 1;
			// build the dynamic fields
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				$setin = 'data-hide="phone"';
				if ($controller > 3)
				{
					$setin = 'data-hide="phone,tablet"';
				}

				if ($controller > 6)
				{
					$setin = 'data-hide="all"';
				}

				if ($item['link'] && $firstLink)
				{
					$setin = 'data-toggle="true"';
					$firstLink = false;
				}
				$head .= "\n\t\t<th ".$setin.">";
				$head .= "\n\t\t\t<?php echo JText::_('".$item['lang']."'); ?>";
				$head .= "\n\t\t</th>";
				$controller++;
			}
			// set default
 			$head .= "\n\t\t".'<th width="10" data-hide="phone,tablet">';
   			$head .= "\n\t\t\t<?php echo JText::_('".$statusLangName."'); ?>";
 			$head .= "\n\t\t</th>";
 			$head .= "\n\t\t".'<th width="5" data-type="numeric" data-hide="phone,tablet">';
   			$head .= "\n\t\t\t<?php echo JText::_('".$idLangName."'); ?>";
 			$head .= "\n\t\t</th>";
 			$head .= "\n\t</tr>";
			$head .= "\n</thead>";

			return $head;
		}
		return '';
	}

	protected function setListQueryLinked($viewName_single, $viewName_list, $functionName, $key, $_key, $parentKey, $parent_key, $globalKey)
	{
		// check if this view has category added
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			$categoryCodeName = $this->categoryBuilder[$viewName_list]['code'];
			$addCategory = true;
		}
		else
		{
			$addCategory = false;
		}
		$query = "\n\n\t/**";
		$query .= "\n\t* Method to get list data.";
		$query .= "\n\t*";
		$query .= "\n\t* @return mixed  An array of data items on success, false on failure.";
		$query .= "\n\t*/";
		$query .= "\n\tpublic function get".$functionName."()";
		$query .= "\n\t{";
		// setup the query
		$query .= "\n\t\t//".$this->setLine(__LINE__)." Get the user object.";
		$query .= "\n\t\t\$user = JFactory::getUser();";
		$query .= "\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
		$query .= "\n\t\t\$db = JFactory::getDBO();";
		$query .= "\n\t\t\$query = \$db->getQuery(true);";
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Select some fields";
		$query .= "\n\t\t\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= "\n\t\t\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." From the ".$this->fileContentStatic['###component###']."_".$viewName_single." table";
		$query .= "\n\t\t\$query->from(\$db->quoteName('#__".$this->fileContentStatic['###component###']."_".$viewName_single."', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= "\n\t\t\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a.".$categoryCodeName."') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
		if (isset($this->customScriptBuilder['php_getlistquery'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_getlistquery'][$viewName_single]))
		{
			$query .= "\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_getlistquery'][$viewName_single]);
		}
		// add the custom fields query
		$query .= $this->setCustomQuery($viewName_list, $viewName_single);
		if ($key && strpos($key,'-R>') === false && strpos($key,'-A>') === false && strpos($parentKey,'-R>') === false && strpos($parentKey,'-A>') === false)
		{
			$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." global.";
			$query .= "\n\t\t\$".$globalKey." = \$this->".$globalKey.";";
			$query .= "\n\t\tif (is_numeric(\$".$globalKey." ))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$query->where('a.".$key." = ' . (int) \$".$globalKey." );";
			$query .= "\n\t\t}";
			$query .= "\n\t\telseif (is_string(\$".$globalKey."))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$query->where('a.".$key." = ' . \$db->quote(\$".$globalKey."));";
			$query .= "\n\t\t}";
			$query .= "\n\t\telse";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$query->where('a.".$key." = -5');";
			$query .= "\n\t\t}";
		}
		if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
		{
			$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Join over the asset groups.";
			$query .= "\n\t\t\$query->select('ag.title AS access_level');";
			$query .= "\n\t\t\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			$query .= "\n\t\t//".$this->setLine(__LINE__)." Filter by access level.";
			$query .= "\n\t\tif (\$access = \$this->getState('filter.access'))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$query->where('a.access = ' . (int) \$access);";
			$query .= "\n\t\t}";
			$query .= "\n\t\t//".$this->setLine(__LINE__)." Implement View Level Access";
			$query .= "\n\t\tif (!\$user->authorise('core.options', 'com_".$this->fileContentStatic['###component###']."'))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= "\n\t\t\t\$query->where('a.access IN (' . \$groups . ')');";
			$query .= "\n\t\t}";
		}
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Order the results by ordering";
		$query .= "\n\t\t\$query->order('a.ordering  ASC');";
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Load the items";
		$query .= "\n\t\t\$db->setQuery(\$query);";
		$query .= "\n\t\t\$db->execute();";
		$query .= "\n\t\tif (\$db->getNumRows())";
		$query .= "\n\t\t{";
		$query .= "\n\t\t\t\$items = \$db->loadObjectList();";
		// ###STORE_METHOD_FIX### <<<DYNAMIC>>>
		$query .= $this->setGetItemsMethodStringFix($viewName_single,$this->fileContentStatic['###Component###'],"\t");
		// ###SELECTIONTRANSLATIONFIX### <<<DYNAMIC>>>
		$query .= $this->setSelectionTranslationFix($viewName_list,$this->fileContentStatic['###Component###'],"\t");

		// filter by child repetable field values
		if ($key && strpos($key,'-R>') !== false && strpos($key,'-A>') === false)
		{
			$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." Repetable Field";
			$query .= "\n\t\t\$".$globalKey." = \$this->".$globalKey.";";
		}
		// filter by child array field values
		if ($key && strpos($key,'-R>') === false && strpos($key,'-A>') !== false)
		{
			$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." Array Field";
			$query .= "\n\t\t\$".$globalKey." = \$this->".$globalKey.";";

		}
		// filter by parent repetable field values
		if ($key && strpos($parentKey,'-R>') !== false && strpos($parentKey,'-A>') === false)
		{
			list($bin,$target) = explode('-R>',$parentKey);
			$query .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Filter by ".$_key." Repetable Field";
			$query .= "\n\t\t\t\$".$globalKey." = json_decode(\$this->".$globalKey.",true);";
			$query .= "\n\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$items) && isset(\$".$globalKey.") && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."))";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\tforeach (\$items as \$nr => &\$item)";
			$query .= "\n\t\t\t\t{";
			$query .= "\n\t\t\t\t\tif (\$item->".$_key." && isset(\$".$globalKey."['".$target."']) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."['".$target."']))";
			$query .= "\n\t\t\t\t\t{";
			$query .= "\n\t\t\t\t\t\tif (!in_array(\$item->".$_key.",\$".$globalKey."['".$target."']))";
			$query .= "\n\t\t\t\t\t\t{";
			$query .= "\n\t\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= "\n\t\t\t\t\t\t\tcontinue;";
			$query .= "\n\t\t\t\t\t\t}";
			$query .= "\n\t\t\t\t\t}";
			$query .= "\n\t\t\t\t}";
			$query .= "\n\t\t\t}";
			$query .= "\n\t\t\telse";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\treturn false;";
			$query .= "\n\t\t\t}";
		}
		// filter by parent array field values
		if ($key && strpos($parentKey,'-R>') === false && strpos($parentKey,'-A>') !== false)
		{
			$query .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." Array Field";
			$query .= "\n\t\t\t\$".$globalKey." = \$this->".$globalKey.";";
			$query .= "\n\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$items) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."))";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\tforeach (\$items as \$nr => &\$item)";
			$query .= "\n\t\t\t\t{";
			list($bin,$target) = explode('-A>',$parentKey);
			if (ComponentbuilderHelper::checkString($target))
			{
				$query .= "\n\t\t\t\t\tif (\$item->".$_key." && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."['".$target."']))";
				$query .= "\n\t\t\t\t\t{";
				$query .= "\n\t\t\t\t\t\tif (!in_array(\$item->".$_key.",\$".$globalKey."['".$target."']))";
			}
			else
			{
				$query .= "\n\t\t\t\t\tif (\$item->".$_key.")";
				$query .= "\n\t\t\t\t\t{";
				$query .= "\n\t\t\t\t\t\tif (!in_array(\$item->".$_key.",\$".$globalKey."))";
			}
			$query .= "\n\t\t\t\t\t\t{";
			$query .= "\n\t\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= "\n\t\t\t\t\t\t\tcontinue;";
			$query .= "\n\t\t\t\t\t\t}";
			$query .= "\n\t\t\t\t\t}";
			$query .= "\n\t\t\t\t}";
			$query .= "\n\t\t\t}";
			$query .= "\n\t\t\telse";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\treturn false;";
			$query .= "\n\t\t\t}";
		}

		$query .= "\n\t\t\treturn \$items;";
		$query .= "\n\t\t}";
		$query .= "\n\t\treturn false;";
		$query .= "\n\t}";
		// ###SELECTIONTRANSLATIONFIXFUNC###<<<DYNAMIC>>>
		$query .= $this->setSelectionTranslationFixFunc($viewName_list,$this->fileContentStatic['###Component###']);

		// fixe mothod name clash
		$query = str_replace('selectionTranslation(','selectionTranslation'.$functionName.'(',$query);

		return $query;
	}

	protected function setCustomAdminDynamicButton($viewName_list)
	{
		$buttons = '';
		if (isset($this->customAdminDynamicButtons[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminDynamicButtons[$viewName_list]))
		{
			$buttons = array();
			foreach ($this->customAdminDynamicButtons[$viewName_list] as $custom_button)
			{
				// Load to lang
				$keyLang = $this->langPrefix.'_'.$custom_button['NAME'];
				$this->langContent[$this->lang][$keyLang] = ComponentbuilderHelper::safeString($custom_button['name'],'Ww');
				// add cpanel button
				$buttons[] = "\t\tif (\$this->canDo->get('".$custom_button['link'].".access'))";
				$buttons[] = "\t\t{";
				$buttons[] = "\t\t\t//".$this->setLine(__LINE__)." add ".$custom_button['name']." button.";
				$buttons[] = "\t\t\tJToolBarHelper::custom('".$viewName_list.".redirectTo".ComponentbuilderHelper::safeString($custom_button['link'],'F')."', '".$custom_button['icon']."', '', '".$keyLang."', true);";
				$buttons[] = "\t\t}";
			}
			if (ComponentbuilderHelper::checkArray($buttons))
			{
				return implode("\n",$buttons);
			}
		}
		return $buttons;
	}
	
	protected function setCustomAdminDynamicButtonController($viewName_list)
	{
		$method = '';
		if (isset($this->customAdminDynamicButtons[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminDynamicButtons[$viewName_list]))
		{
			$method = array();
			foreach ($this->customAdminDynamicButtons[$viewName_list] as $custom_button)
			{
				// add the custom redirect method
				$method[] = "\n\n\tpublic function redirectTo".ComponentbuilderHelper::safeString($custom_button['link'],'F')."()";
				$method[] = "\t{";
				$method[] = "\t\t//".$this->setLine(__LINE__)." Check for request forgeries";
				$method[] = "\t\tJSession::checkToken() or die(JText::_('JINVALID_TOKEN'));";
				$method[] = "\t\t//".$this->setLine(__LINE__)." check if export is allowed for this user.";
				$method[] = "\t\t\$user = JFactory::getUser();";
				$method[] = "\t\tif (\$user->authorise('".$custom_button['link'].".access', 'com_".$this->fileContentStatic['###component###']."'))";
				$method[] = "\t\t{";
				$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the input";
				$method[] = "\t\t\t\$input = JFactory::getApplication()->input;";
				$method[] = "\t\t\t\$pks = \$input->post->get('cid', array(), 'array');";
				$method[] = "\t\t\t//".$this->setLine(__LINE__)." Sanitize the input";
				$method[] = "\t\t\tJArrayHelper::toInteger(\$pks);";
				$method[] = "\t\t\t//".$this->setLine(__LINE__)." convert to string";
				$method[] = "\t\t\t\$ids = implode('_', \$pks);";
				$method[] = "\t\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$custom_button['link']."&cid='.\$ids, false));";
				$method[] = "\t\t\treturn;";
				$method[] = "\t\t}";
				$method[] = "\t\t//".$this->setLine(__LINE__)." Redirect to the list screen with error.";
				$method[] = "\t\t\$message = JText::_('".$this->langPrefix."_ACCESS_TO_".$custom_button['NAME']."_FAILED');";
				$method[] = "\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_list."', false), \$message, 'error');";
				$method[] = "\t\treturn;";
				$method[] = "\t}";
				// add to lang array
				$lankey = $this->langPrefix."_ACCESS_TO_".$custom_button['NAME']."_FAILED";
				if (!isset($this->langContent[$this->lang][$lankey]))
				{
					$this->langContent[$this->lang][$lankey] = 'Access to '.$custom_button['link'].' was denied.';
				}
			}

			return implode("\n",$method);
		}
		return $method;
	}

	protected function setModelExportMethod($viewName_single, $viewName_list)
	{
		$query = '';
		if ($this->eximportView[$viewName_list])
		{
			$query = "\n\n\t/**";
			$query .= "\n\t* Method to get list export data.";
			$query .= "\n\t*";
			$query .= "\n\t* @return mixed  An array of data items on success, false on failure.";
			$query .= "\n\t*/";
			$query .= "\n\tpublic function getExportData(\$pks)";
			$query .= "\n\t{";
			$query .= "\n\t\t//".$this->setLine(__LINE__)." setup the query";
			$query .= "\n\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$pks))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t//".$this->setLine(__LINE__)." Get the user object.";
			$query .= "\n\t\t\t\$user = JFactory::getUser();";
			$query .= "\n\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$query .= "\n\t\t\t\$db = JFactory::getDBO();";
			$query .= "\n\t\t\t\$query = \$db->getQuery(true);";
			$query .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Select some fields";
			$query .= "\n\t\t\t\$query->select('a.*');";
			$query .= "\n\n\t\t\t//".$this->setLine(__LINE__)." From the ".$this->fileContentStatic['###component###']."_".$viewName_single." table";
			$query .= "\n\t\t\t\$query->from(\$db->quoteName('#__".$this->fileContentStatic['###component###']."_".$viewName_single."', 'a'));";
			$query .= "\n\t\t\t\$query->where('a.id IN (' . implode(',',\$pks) . ')');";
			// add custom filtering php
			if (isset($this->customScriptBuilder['php_getlistquery'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_getlistquery'][$viewName_single]))
			{
				$query .= "\n\n\t".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_getlistquery'][$viewName_single]);
			}
			if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
			{
				$query .= "\n\t\t\t//".$this->setLine(__LINE__)." Implement View Level Access";
				$query .= "\n\t\t\tif (!\$user->authorise('core.options', 'com_".$this->fileContentStatic['###component###']."'))";
				$query .= "\n\t\t\t{";
				$query .= "\n\t\t\t\t\$groups = implode(',', \$user->getAuthorisedViewLevels());";
				$query .= "\n\t\t\t\t\$query->where('a.access IN (' . \$groups . ')');";
				$query .= "\n\t\t\t}";
			}
			$query .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Order the results by ordering";
			$query .= "\n\t\t\t\$query->order('a.ordering  ASC');";
			$query .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Load the items";
			$query .= "\n\t\t\t\$db->setQuery(\$query);";
			$query .= "\n\t\t\t\$db->execute();";
			$query .= "\n\t\t\tif (\$db->getNumRows())";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\t\$items = \$db->loadObjectList();";
			$query .= $this->setGetItemsMethodStringFix($viewName_single,$this->fileContentStatic['###Component###'],"\t\t",true);
			$query .= "\n\t\t\t\treturn \$items;";
			$query .= "\n\t\t\t}";
			$query .= "\n\t\t}";
			$query .= "\n\t\treturn false;";
			$query .= "\n\t}";

			$query .= "\n\n\t/**";
			$query .= "\n\t* Method to get header.";
			$query .= "\n\t*";
			$query .= "\n\t* @return mixed  An array of data items on success, false on failure.";
			$query .= "\n\t*/";
			$query .= "\n\tpublic function getExImPortHeaders()";
			$query .= "\n\t{";
			$query .= "\n\t\t//".$this->setLine(__LINE__)." Get a db connection.";
			$query .= "\n\t\t\$db = JFactory::getDbo();";
			$query .= "\n\t\t//".$this->setLine(__LINE__)." get the columns";
			$query .= "\n\t\t\$columns = \$db->getTableColumns(".'"#__'.$this->fileContentStatic['###component###'].'_'.$viewName_single.'");';
			$query .= "\n\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$columns))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t//".$this->setLine(__LINE__)." remove the headers you don't import/export.";
			$query .= "\n\t\t\tunset(\$columns['asset_id']);";
			$query .= "\n\t\t\tunset(\$columns['checked_out']);";
			$query .= "\n\t\t\tunset(\$columns['checked_out_time']);";
			$query .= "\n\t\t\t\$headers = new stdClass();";
			$query .= "\n\t\t\tforeach (\$columns as \$column => \$type)";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\t\$headers->{\$column} = \$column;";
			$query .= "\n\t\t\t}";
			$query .= "\n\t\t\treturn \$headers;";
			$query .= "\n\t\t}";
			$query .= "\n\t\treturn false;";
			$query .= "\n\t}";
		}
		return $query;
	}

	protected function setControllerEximportMethod($viewName_single, $viewName_list)
	{
		$method = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			$method = array();

			// add the export method
			$method[] = "\n\n\tpublic function exportData()";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Check for request forgeries";
			$method[] = "\t\tJSession::checkToken() or die(JText::_('JINVALID_TOKEN'));";
			$method[] = "\t\t//".$this->setLine(__LINE__)." check if export is allowed for this user.";
			$method[] = "\t\t\$user = JFactory::getUser();";
			$method[] = "\t\tif (\$user->authorise('".$viewName_single.".export', 'com_".$this->fileContentStatic['###component###']."') && \$user->authorise('core.export', 'com_".$this->fileContentStatic['###component###']."'))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the input";
			$method[] = "\t\t\t\$input = JFactory::getApplication()->input;";
			$method[] = "\t\t\t\$pks = \$input->post->get('cid', array(), 'array');";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Sanitize the input";
			$method[] = "\t\t\tJArrayHelper::toInteger(\$pks);";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the model";
			$method[] = "\t\t\t\$model = \$this->getModel('".ComponentbuilderHelper::safeString($viewName_list,'F')."');";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." get the data to export";
			$method[] = "\t\t\t\$data = \$model->getExportData(\$pks);";
			$method[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$data))";
			$method[] = "\t\t\t{";
			$method[] = "\t\t\t\t//".$this->setLine(__LINE__)." now set the data to the spreadsheet";
			$method[] = "\t\t\t\t\$date = JFactory::getDate();";
			$method[] = "\t\t\t\t".$this->fileContentStatic['###Component###']."Helper::xls(\$data,'".ComponentbuilderHelper::safeString($viewName_list,'F')."_'.\$date->format('jS_F_Y'),'".ComponentbuilderHelper::safeString($viewName_list,'Ww')." exported ('.\$date->format('jS F, Y').')','".ComponentbuilderHelper::safeString($viewName_list,'w')."');";
			$method[] = "\t\t\t}";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Redirect to the list screen with error.";
			$method[] = "\t\t\$message = JText::_('".$this->langPrefix."_EXPORT_FAILED');";
			$method[] = "\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_list."', false), \$message, 'error');";
			$method[] = "\t\treturn;";
			$method[] = "\t}";

			// add the import method
			$method[] = "\n\n\tpublic function importData()";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Check for request forgeries";
			$method[] = "\t\tJSession::checkToken() or die(JText::_('JINVALID_TOKEN'));";
			$method[] = "\t\t//".$this->setLine(__LINE__)." check if import is allowed for this user.";
			$method[] = "\t\t\$user = JFactory::getUser();";
			$method[] = "\t\tif (\$user->authorise('".$viewName_single.".import', 'com_".$this->fileContentStatic['###component###']."') && \$user->authorise('core.import', 'com_".$this->fileContentStatic['###component###']."'))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the import model";
			$method[] = "\t\t\t\$model = \$this->getModel('".ComponentbuilderHelper::safeString($viewName_list,'F')."');";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." get the headers to import";
			$method[] = "\t\t\t\$headers = \$model->getExImPortHeaders();";
			$method[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkObject(\$headers))";
			$method[] = "\t\t\t{";
			$method[] = "\t\t\t\t//".$this->setLine(__LINE__)." Load headers to session.";
			$method[] = "\t\t\t\t\$session = JFactory::getSession();";
			$method[] = "\t\t\t\t\$headers = json_encode(\$headers);";
			$method[] = "\t\t\t\t\$session->set('".$viewName_single."_VDM_IMPORTHEADERS', \$headers);";
			$method[] = "\t\t\t\t\$session->set('backto_VDM_IMPORT', '".$viewName_list."');";
			$method[] = "\t\t\t\t\$session->set('dataType_VDM_IMPORTINTO', '".$viewName_single."');";
			$method[] = "\t\t\t\t//".$this->setLine(__LINE__)." Redirect to import view.";
			// add to lang array
			$selectImportFileNote = $this->langPrefix."_IMPORT_SELECT_FILE_FOR_".ComponentbuilderHelper::safeString($viewName_list,'U');
			if (!isset($this->langContent[$this->lang][$selectImportFileNote]))
			{
				$this->langContent[$this->lang][$selectImportFileNote] = 'Select the file to import data to '.$viewName_list.'.';
			}
			$method[] = "\t\t\t\t\$message = JText::_('".$selectImportFileNote."');";
			$method[] = "\t\t\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=import', false), \$message);";
			$method[] = "\t\t\t\treturn;";
			$method[] = "\t\t\t}";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Redirect to the list screen with error.";
			$method[] = "\t\t\$message = JText::_('".$this->langPrefix."_IMPORT_FAILED');";
			$method[] = "\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_list."', false), \$message, 'error');";
			$method[] = "\t\treturn;";
			$method[] = "\t}";
			return implode("\n",$method);
		}
		return $method;
	}

	protected function setExportButton($viewName_single, $viewName_list)
	{
		$button = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			// main lang prefix
			$langExport = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Export Data','U');
			// add to lang array
			if (!isset($this->langContent[$this->lang][$langExport]))
			{
				$this->langContent[$this->lang][$langExport] = 'Export Data';
			}
			$button = array();
			$button[] = "\n\n\t\t\tif (\$this->canDo->get('core.export') && \$this->canDo->get('".$viewName_single.".export'))";
			$button[] = "\t\t\t{";
			$button[] = "\t\t\t\tJToolBarHelper::custom('".$viewName_list.".exportData', 'download', '', '".$langExport."', true);";
			$button[] = "\t\t\t}";
			return implode("\n",$button);
		}
		return $button;
	}

	protected function setImportButton($viewName_single, $viewName_list)
	{
		$button = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			// main lang prefix
			$langImport = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Import Data','U');
			// add to lang array
			if (!isset($this->langContent[$this->lang][$langImport]))
			{
				$this->langContent[$this->lang][$langImport] = 'Import Data';
			}
			$button = array();
			$button[] = "\n\n\t\tif (\$this->canDo->get('core.import') && \$this->canDo->get('".$viewName_single.".import'))";
			$button[] = "\t\t{";
			$button[] = "\t\t\tJToolBarHelper::custom('".$viewName_list.".importData', 'upload', '', '".$langImport."', false);";
			$button[] = "\t\t}";
			return implode("\n",$button);
		}
		return $button;
	}

	protected function setListQuery($viewName_single, $viewName_list)
	{
		// check if this view has category added
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			$categoryCodeName = $this->categoryBuilder[$viewName_list]['code'];
			$addCategory = true;
		}
		else
		{
			$addCategory = false;
		}
		// setup the query
		$query = "//".$this->setLine(__LINE__)." Get the user object.";
		$query .= "\n\t\t\$user = JFactory::getUser();";
		$query .= "\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
		$query .= "\n\t\t\$db = JFactory::getDBO();";
		$query .= "\n\t\t\$query = \$db->getQuery(true);";
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Select some fields";
		$query .= "\n\t\t\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= "\n\t\t\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." From the ".$this->fileContentStatic['###component###']."_item table";
		$query .= "\n\t\t\$query->from(\$db->quoteName('#__".$this->fileContentStatic['###component###']."_".$viewName_single."', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= "\n\t\t\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a.".$categoryCodeName."') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
		if (isset($this->customScriptBuilder['php_getlistquery'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_getlistquery'][$viewName_single]))
		{
			$query .= "\n\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_getlistquery'][$viewName_single]);
		}
		// add the custom fields query
		$query .= $this->setCustomQuery($viewName_list, $viewName_single);
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Filter by published state";
		$query .= "\n\t\t\$published = \$this->getState('filter.published');";
		$query .= "\n\t\tif (is_numeric(\$published))";
		$query .= "\n\t\t{";
		$query .= "\n\t\t\t\$query->where('a.published = ' . (int) \$published);";
		$query .= "\n\t\t}";
		$query .= "\n\t\telseif (\$published === '')";
		$query .= "\n\t\t{";
		$query .= "\n\t\t\t\$query->where('(a.published = 0 OR a.published = 1)');";
		$query .= "\n\t\t}";
		if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
		{
			$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Join over the asset groups.";
			$query .= "\n\t\t\$query->select('ag.title AS access_level');";
			$query .= "\n\t\t\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			$query .= "\n\t\t//".$this->setLine(__LINE__)." Filter by access level.";
			$query .= "\n\t\tif (\$access = \$this->getState('filter.access'))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$query->where('a.access = ' . (int) \$access);";
			$query .= "\n\t\t}";
			$query .= "\n\t\t//".$this->setLine(__LINE__)." Implement View Level Access";
			$query .= "\n\t\tif (!\$user->authorise('core.options', 'com_".$this->fileContentStatic['###component###']."'))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= "\n\t\t\t\$query->where('a.access IN (' . \$groups . ')');";
			$query .= "\n\t\t}";
		}
		// set the search query
		$query .= $this->setSearchQuery($viewName_list);
		// set other filters
		$query .= $this->setFilterQuery($viewName_list);
		// add the category
		if ($addCategory)
		{
			$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Filter by a single or group of categories.";
			$query .= "\n\t\t\$baselevel = 1;";
			$query .= "\n\t\t\$categoryId = \$this->getState('filter.category_id');";
			$query .= "\n";
			$query .= "\n\t\tif (is_numeric(\$categoryId))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\t\$cat_tbl = JTable::getInstance('Category', 'JTable');";
			$query .= "\n\t\t\t\$cat_tbl->load(\$categoryId);";
			$query .= "\n\t\t\t\$rgt = \$cat_tbl->rgt;";
			$query .= "\n\t\t\t\$lft = \$cat_tbl->lft;";
			$query .= "\n\t\t\t\$baselevel = (int) \$cat_tbl->level;";
			$query .= "\n\t\t\t\$query->where('c.lft >= ' . (int) \$lft)";
			$query .= "\n\t\t\t\t->where('c.rgt <= ' . (int) \$rgt);";
			$query .= "\n\t\t}";
			$query .= "\n\t\telseif (is_array(\$categoryId))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\tJArrayHelper::toInteger(\$categoryId);";
			$query .= "\n\t\t\t\$categoryId = implode(',', \$categoryId);";
			$query .= "\n\t\t\t\$query->where('a.category IN (' . \$categoryId . ')');";
			$query .= "\n\t\t}";
			$query .= "\n";
		}
		$query .= "\n\n\t\t//".$this->setLine(__LINE__)." Add the list ordering clause.";
		$query .= "\n\t\t\$orderCol = \$this->state->get('list.ordering', 'a.id');";
		$query .= "\n\t\t\$orderDirn = \$this->state->get('list.direction', 'asc');	";
		$query .= "\n\t\tif (\$orderCol != '')";
		$query .= "\n\t\t{";
		$query .= "\n\t\t\t\$query->order(\$db->escape(\$orderCol . ' ' . \$orderDirn));";
		$query .= "\n\t\t}";
		$query .= "\n";
		$query .= "\n\t\treturn \$query;";

		return $query;
	}

	protected function setSearchQuery($viewName_list)
	{
		if (isset($this->searchBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->searchBuilder[$viewName_list]))
		{
			// setup the searh options
			$search = "'(";
			foreach ($this->searchBuilder[$viewName_list] as $nr => $array)
			{
				// array( 'type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $field['list']);
				if ($nr == 0)
				{
					$search .= "a.".$array['code']." LIKE '.\$search.'";
					if (ComponentbuilderHelper::checkArray($array['custom']) && 1 == $array['list'])
					{
						$search .= " OR ".$array['custom']['db'].".".$array['custom']['text']." LIKE '.\$search.'";
					}
				}
				else
				{
					$search .= " OR a.".$array['code']." LIKE '.\$search.'";
					if (ComponentbuilderHelper::checkArray($array['custom']) && 1 == $array['list'])
					{
						$search .= " OR ".$array['custom']['db'].".".$array['custom']['text']." LIKE '.\$search.'";
					}
				}
			}
			$search .= ")'";
			// now setup query
			$query = "\n\t\t//".$this->setLine(__LINE__)." Filter by search.";
			$query .= "\n\t\t\$search = \$this->getState('filter.search');";
			$query .= "\n\t\tif (!empty(\$search))";
			$query .= "\n\t\t{";
			$query .= "\n\t\t\tif (stripos(\$search, 'id:') === 0)";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\t\$query->where('a.id = ' . (int) substr(\$search, 3));";
			$query .= "\n\t\t\t}";
			$query .= "\n\t\t\telse";
			$query .= "\n\t\t\t{";
			$query .= "\n\t\t\t\t\$search = \$db->quote('%' . \$db->escape(\$search, true) . '%');";
			$query .= "\n\t\t\t\t\$query->where(".$search.");";
			$query .= "\n\t\t\t}";
			$query .= "\n\t\t}";
			$query .= "\n";

			return $query;
		}
		return '';
	}

	protected function setCustomQuery($viewName_list, $viewName_single)
	{
		if (isset($this->customBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customBuilder[$viewName_list]))
		{
			$query = "";
			foreach ($this->customBuilder[$viewName_list] as $filter)
			{
				if (isset($this->customBuilderList[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customBuilderList[$viewName_list]) && in_array($filter['code'],$this->customBuilderList[$viewName_list]))
				{
					$query .= "\n\n\t\t//".$this->setLine(__LINE__)." From the ".ComponentbuilderHelper::safeString(ComponentbuilderHelper::safeString($filter['custom']['table'],'w'))." table.";
					$query .= "\n\t\t\$query->select(\$db->quoteName('".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'));";
					$query .= "\n\t\t\$query->join('LEFT', \$db->quoteName('".$filter['custom']['table']."', '".$filter['custom']['db']."') . ' ON (' . \$db->quoteName('a.".$filter['code']."') . ' = ' . \$db->quoteName('".$filter['custom']['db'].".".$filter['custom']['id']."') . ')');";
				}
				// build the field type file
				$this->setCustomFieldTypeFile($filter, $viewName_list, $viewName_single);
			}
			return $query;
		}
	}

	protected function setCustomFieldTypeFile($data, $viewName_list, $viewName_single)
	{
		// make sure it is not already been build
		if (!isset($this->fileContentDynamic['customfield_'.$data['type']]) || !ComponentbuilderHelper::checkArray($this->fileContentDynamic['customfield_'.$data['type']]))
		{
			// first build the custom field type file
			$target = array('admin' => 'customfield');
			$this->buildDynamique($target,'field'.$data['custom']['extends'],$data['custom']['type']);
			// set tab and break replacements
			$tabBreak = array(
				'\t' => "\t",
				'\n' => "\n"
			);
			// make field dynamic
			$replace = array(
				'###TABLE###' => $data['custom']['table'],
				'###ID###' => $data['custom']['id'],
				'###TEXT###' => $data['custom']['text'],
				'###CODE_TEXT###' => $data['code'].'_'.$data['custom']['text'],
				'###CODE###' => $data['code'],
				'###component###' => $this->fileContentStatic['###component###'],
				'###Component###' => $this->fileContentStatic['###Component###'],
				'###view_type###' => $viewName_single.'_'.$data['type'],
				'###type###' => $data['type'],
				'###view###' => $viewName_single,
				'###views###' => $viewName_list
			);
			// now load the php script
			if (isset($data['custom']['php']) && ComponentbuilderHelper::checkArray($data['custom']['php']))
			{
				// make sure the ar is reset
				$phpCode = '';
				foreach ($data['custom']['php'] as $line => $code)
				{
					if (ComponentbuilderHelper::checkString($code))
					{
						if ($line == 1)
						{
							$phpCode .= str_replace(array_keys($tabBreak),array_values($tabBreak),$code);
						}
						else
						{
							$phpCode .= "\n\t\t".str_replace(array_keys($tabBreak),array_values($tabBreak),$code);
						}
					}
				}
				// replace the placholders
				$phpCode = str_replace(array_keys($replace),array_values($replace),$phpCode);
			}
			else
			{
				$phpCode = 'return null;';
			}
			if (!ComponentbuilderHelper::checkString($phpCode))
			{
				$phpCode = 'return null;';
			}

			if ($data['custom']['extends'] == 'user')
			{
				// now load the php xclude script
				if (ComponentbuilderHelper::checkArray($data['custom']['phpx']))
				{
					// make sure the ar is reset
					$phpxCode = '';
					foreach ($data['custom']['phpx'] as $line => $code)
					{
						if (ComponentbuilderHelper::checkString($code))
						{
							if ($line == 1)
							{
								$phpxCode .= str_replace(array_keys($tabBreak),array_values($tabBreak),$code);
							}
							else
							{
								$phpxCode .= "\n\t\t".str_replace(array_keys($tabBreak),array_values($tabBreak),$code);
							}
						}
					}
					// replace the placholders
					$phpxCode = str_replace(array_keys($replace),array_values($replace),$phpxCode);
				}
				else
				{
					$phpxCode = 'return null;';
				}
				if (!ComponentbuilderHelper::checkString($phpxCode))
				{
					$phpxCode = 'return null;';
				}
				// temp holder for name
				$tempName = $data['custom']['label'].' Group';
				// set lang
				$groupLangName = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($tempName,'U');
				// add to lang array
				$this->langContent[$this->lang][$groupLangName] = ComponentbuilderHelper::safeString($tempName,'W');
				// build the Group Control
				$this->setGroupControl[$data['type']] = $groupLangName;
				// ###JFORM_GETGROUPS_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'.$data['type']]['###JFORM_GETGROUPS_PHP###'] = $phpCode;

				// ###JFORM_GETEXCLUDED_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'.$data['type']]['###JFORM_GETEXCLUDED_PHP###'] = $phpxCode;
			}
			else
			{
				// ###JFORM_GETOPTIONS_PHP### <<<DYNAMIC>>>
				$this->fileContentDynamic['customfield_'.$data['type']]['###JFORM_GETOPTIONS_PHP###'] = $phpCode;
			}
			// ###Type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_'.$data['type']]['###Type###'] = ComponentbuilderHelper::safeString($data['custom']['type'],'F');
			// ###type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_'.$data['type']]['###type###'] = $data['custom']['type'];
			// ###type### <<<DYNAMIC>>>
			$this->fileContentDynamic['customfield_'.$data['type']]['###ADD_BUTTON###'] = $this->setAddButttonToListField($data['custom']['view']);
		}
	}

	protected function setAddButttonToListField($targetView)
	{
		$addButton = array();
		$addButton[] = "\n\t/**";
		$addButton[] = "\t * Override to add new button";
		$addButton[] = "\t *";
		$addButton[] = "\t * @return  string  The field input markup.";
		$addButton[] = "\t *";
		$addButton[] = "\t * @since   3.2";
		$addButton[] = "\t */";
		$addButton[] = "\tprotected function getInput()";
		$addButton[] = "\t{";
		$addButton[] = "\t\t//".$this->setLine(__LINE__)." see if we should add buttons";
		$addButton[] = "\t\t\$setButton = \$this->getAttribute('button');";
		$addButton[] = "\t\t//".$this->setLine(__LINE__)." get html";
		$addButton[] = "\t\t\$html = parent::getInput();";
		$addButton[] = "\t\t//".$this->setLine(__LINE__)." if true set button";
		$addButton[] = "\t\tif (\$setButton === 'true')";
		$addButton[] = "\t\t{";
		$addButton[] = "\t\t\t\$user = JFactory::getUser();";
		$addButton[] = "\t\t\t//".$this->setLine(__LINE__)." only add if user allowed to create " . $targetView;
		// get core permissions
		$coreLoad = false;
		if (isset($this->permissionCore[$targetView]))
		{
			$core = $this->permissionCore[$targetView];
			$coreLoad = true;
		}
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($targetView,$this->permissionBuilder['global'][$core['core.create']]))
		{
			$addButton[] = "\t\t\tif (\$user->authorise('".$core['core.create']."', 'com_".$this->fileContentStatic['###component###']."'))";
		}
		else
		{
			$addButton[] = "\t\t\tif (\$user->authorise('core.create', 'com_".$this->fileContentStatic['###component###']."'))";
		}
		$addButton[] = "\t\t\t{";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." get the input from url";
		$addButton[] = "\t\t\t\t\$jinput = JFactory::getApplication()->input;";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." get the view name & id";
		$addButton[] = "\t\t\t\t\$values = \$jinput->getArray(array(";
		$addButton[] = "\t\t\t\t\t'id' => 'int',";
		$addButton[] = "\t\t\t\t\t'view' => 'word'";
		$addButton[] = "\t\t\t\t));";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." check if new item";
		$addButton[] = "\t\t\t\t\$ref = '';";
		$addButton[] = "\t\t\t\tif (!is_null(\$values['id']) && strlen(\$values['view']))";
		$addButton[] = "\t\t\t\t{";
		$addButton[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." only load referal if not new item.";
		$addButton[] = "\t\t\t\t\t\$ref = '&amp;ref=' . \$values['view'] . '&amp;refid=' . \$values['id'];";
		$addButton[] = "\t\t\t\t}";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." build the button";
		$addButton[] = "\t\t\t\t\$button = '<a class=\"btn btn-small btn-success\"";
		$addButton[] = "\t\t\t\t\thref=\"index.php?option=com_" . $this->fileContentStatic['###component###'] . "&amp;view=" . $targetView . "&amp;layout=edit'.\$ref.'\" >";
		$addButton[] = "\t\t\t\t\t<span class=\"icon-new icon-white\"></span>' . JText::_('COM_".$this->fileContentStatic['###COMPONENT###']."_NEW') . '</a>';";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." return the button attached to input field";
		$addButton[] = "\t\t\t\treturn \$html . \$button;";
		$addButton[] = "\t\t\t}";
		$addButton[] = "\t\t}";
		$addButton[] = "\t\treturn \$html;";
		$addButton[] = "\t}";

		return implode("\n",$addButton);
	}

	protected function setFilterQuery($viewName_list)
	{
		if (isset($this->filterBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$viewName_list]))
		{
			$filterQuery = "";
			foreach ($this->filterBuilder[$viewName_list] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']))
				{
					$filterQuery .= "\n\t\t//".$this->setLine(__LINE__)." Filter by ".$filter['code'].".";
					$filterQuery .= "\n\t\tif (\$".$filter['code']." = \$this->getState('filter.".$filter['code']."'))";
					$filterQuery .= "\n\t\t{";
					$filterQuery .= "\n\t\t\t\$query->where('a.".$filter['code']." = ' . \$db->quote(\$db->escape(\$".$filter['code'].", true)));";
					$filterQuery .= "\n\t\t}";

				}
				elseif ($filter['type'] != 'category')
				{
					$filterQuery .= "\n\t\t//".$this->setLine(__LINE__)." Filter by ".ucwords($filter['code']).".";
					$filterQuery .= "\n\t\tif (\$".$filter['code']." = \$this->getState('filter.".$filter['code']."'))";
					$filterQuery .= "\n\t\t{";
					$filterQuery .= "\n\t\t\t\$query->where('a.".$filter['code']." = ' . \$db->quote(\$db->escape(\$".$filter['code'].", true)));";
					$filterQuery .= "\n\t\t}";
				}
			}
			return $filterQuery;
		}
		return '';
	}

	protected function buildTheViewScript($viewArray, $component)
	{
		// set the view name
		$viewName = ComponentbuilderHelper::safeString($viewArray['settings']->name_single);
		// setup the str_replace values
		$placeholders = array('[[[component]]]' => $component, '[[[view]]]' => $viewName);
		// add conditions to this view
		if (isset($viewArray['settings']->conditions) && ComponentbuilderHelper::checkArray($viewArray['settings']->conditions))
		{
			// reset defaults
			$getValue		= array();
			$ifValue		= array();
			$targetControls		= array();
			$functions		= array();
			foreach ($viewArray['settings']->conditions as $condition)
			{
				if (isset($condition['match_name']) && ComponentbuilderHelper::checkString($condition['match_name']))
				{
					$uniqueVar		= ComponentbuilderHelper::randomkey(7);
					$matchName 		= $condition['match_name'].'_'.$uniqueVar;
					$targetBehavior		= ($condition['target_behavior'] == 1) ? 'show' : 'hide';
					$targetDefault		= ($condition['target_behavior'] == 1) ? 'hide' : 'show';

					// make sure only one relation is set
					$firstTime = true;
					// set the realtation if any
					if ($condition['target_relation'] && $firstTime)
					{
						// chain to other items of the same target
						$relations = $this->getTargetRelationScript($viewArray['settings']->conditions,$condition,$viewName);
						if (ComponentbuilderHelper::checkArray($relations))
						{
							// set behavior and default array
							$behaviors[$matchName]	= $targetBehavior;
							$defaults[$matchName]	= $targetDefault;
							// set the type buket
							$typeBuket[$matchName] = $condition['match_type'];
							// set function array
							$functions[$uniqueVar][0]	= $matchName;
							$matchNames[$matchName]		= $condition['match_name'];
							// get the select value
							$getValue[$matchName] = $this->getValueScript($condition['match_type'],$condition['match_name'],$uniqueVar);
							// get the options
							$options = $this->getOptionsScript($condition['match_type'],$condition['match_options']);
							// set the if values
							$ifValue[$matchName] = $this->ifValueScript($matchName,$condition['match_behavior'],$condition['match_type'],$options);
							// set the target controls
							$targetControls[$matchName] = $this->setTargetControlsScript($condition['target_field'],$targetBehavior,$targetDefault,$uniqueVar,$viewName);

							$firstTime = false;
							foreach($relations as $relation)
							{
								if (ComponentbuilderHelper::checkString($relation['match_name']))
								{
									$relationName = $relation['match_name'].'_'.$uniqueVar;
									// set the type buket
									$typeBuket[$relationName] = $relation['match_type'];
									// set function array
									$functions[$uniqueVar][]	= $relationName;
									$matchNames[$relationName]	= $relation['match_name'];
									// get the relation option
									$relationOptions			= $this->getOptionsScript($relation['match_type'],$relation['match_options']);
									$getValue[$relationName]	= $this->getValueScript($relation['match_type'],$relation['match_name'],$uniqueVar);
									$ifValue[$relationName]		= $this->ifValueScript($relationName,$relation['match_behavior'],$relation['match_type'],$relationOptions);
								}
							}
						}
					}
					else
					{
						// set behavior and default array
						$behaviors[$matchName]	= $targetBehavior;
						$defaults[$matchName]	= $targetDefault;
						// set the type buket
						$typeBuket[$matchName] = $condition['match_type'];
						// set function array
						$functions[$uniqueVar][0]	= $matchName;
						$matchNames[$matchName]		= $condition['match_name'];
						// get the select value
						$getValue[$matchName] = $this->getValueScript($condition['match_type'],$condition['match_name'],$uniqueVar);
						// get the options
						$options = $this->getOptionsScript($condition['match_type'],$condition['match_options']);
						// set the if values
						$ifValue[$matchName] = $this->ifValueScript($matchName,$condition['match_behavior'],$condition['match_type'],$options);
						// set the target controls
						$targetControls[$matchName] = $this->setTargetControlsScript($condition['target_field'],$targetBehavior,$targetDefault,$uniqueVar,$viewName);
					}
				}
			}
			// reset buckets
			$initial = '';
			$func = '';
			$validation = '';
			$isSet = '';
			$listener = '';
			if (ComponentbuilderHelper::checkArray($functions))
			{
				// now build the initial script
				$initial .= "// Initial Script\njQuery(document).ready(function()";
				$initial .= "\n{";
				foreach ($functions as $function => $matchKeys)
				{
					$func_call = $this->buildFunctionCall($function,$matchKeys,$getValue);
					$initial .= $func_call['code'];
				}
				$initial .= "});\n";
				// for modal fields
				$modal = '';
				// now build the listener scripts
				foreach ($functions as $l_function => $l_matchKeys)
				{
					$funcCall = '';
					foreach ($l_matchKeys as $l_matchKey)
					{
						$name			= $matchNames[$l_matchKey];
						$matchTypeKey	= $typeBuket[$l_matchKey];
						$funcCall		= $this->buildFunctionCall($l_function,$l_matchKeys,$getValue);
						if (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($matchTypeKey,$this->setScriptUserSwitch))
						{
							$modal .= $funcCall['code'];
						}
						elseif(isset($this->setScriptMediaSwitch) && ComponentbuilderHelper::checkArray($this->setScriptMediaSwitch) && in_array($matchTypeKey,$this->setScriptMediaSwitch))
						{
							$modal .= $funcCall['code'];
						}
						else
						{
							$listener .= "\n// #jform_".$name." listeners for ".$l_matchKey." function";
							$listener .= "\njQuery('#jform_".$name."').on('keyup',function()";
							$listener .= "\n{";
							$listener .= $funcCall['code'];
							$listener .= "\n});";
							$listener .= "\njQuery('#adminForm').on('change', '#jform_".$name."',function (e)";
							$listener .= "\n{";
							$listener .= "\n\te.preventDefault();";
							$listener .= $funcCall['code'];
							$listener .= "\n});\n";
						}
					}
				}
				if (ComponentbuilderHelper::checkString($modal))
				{
					$listener .= "\nwindow.SqueezeBox.initialize({";
					$listener .= "\n\tonClose:function(){";
					$listener .= $modal;
					$listener .= "\n\t}";
					$listener .= "\n});\n";
				}

				// now build the function
				$func = '';
				$head = '';
				foreach ($functions as $f_function => $f_matchKeys)
				{
					$map = '';
					// does this function require an array
					$addArray = false;
					$func_ = $this->buildFunctionCall($f_function,$f_matchKeys,$getValue);
					// set array switch
					if ($func_['array'])
					{
						$addArray = true;
					}
					$func .= "\n// the ".$f_function." function";
					$func .= "\nfunction ".$f_function."(";
					$fucounter = 0;
					foreach ($f_matchKeys as $fu_matchKey)
					{
						if (ComponentbuilderHelper::checkString($fu_matchKey))
						{
							if ($fucounter == 0)
							{
								$func .= $fu_matchKey;
							}
							else
							{
								$func .= ','.$fu_matchKey;
							}
							$fucounter++;
						}
					}
					$func .= ")";
					$func .= "\n{";
					if ($addArray)
					{
						foreach ($f_matchKeys as $a_matchKey)
						{
							$name = $matchNames[$a_matchKey];
							$func .= "\n\tif (isSet(".$a_matchKey.") && ".$a_matchKey.".constructor !== Array)\n\t{\n\t\tvar temp_".$f_function." = ".$a_matchKey.";\n\t\tvar ".$a_matchKey." = [];\n\t\t".$a_matchKey.".push(temp_".$f_function.");\n\t}";
							$func .= "\n\telse if (!isSet(".$a_matchKey."))\n\t{";
							$func .= "\n\t\tvar ".$a_matchKey." = [];";
							$func .= "\n\t}";
							$func .= "\n\tvar ".$name." = ".$a_matchKey.".some(".$a_matchKey."_SomeFunc);\n";

							// setup the map function
							$map .= "\n// the ".$f_function." Some function";
							$map .= "\nfunction ".$a_matchKey."_SomeFunc(".$a_matchKey.")";
							$map .= "\n{";
							$map .= "\n\t//".$this->setLine(__LINE__)." set the function logic";
							$map .= "\n\tif (";
							$if = $ifValue[$a_matchKey];
							if (ComponentbuilderHelper::checkString($if))
							{
								$map .= $if;
							}
							$map .= ")";
							$map .= "\n\t{";
							$map .= "\n\t\treturn true;";
							$map .= "\n\t}\n\treturn false;";
							$map .= "\n}\n";
						}
						$func .= "\n\n\t//".$this->setLine(__LINE__)." set this function logic";
						$func .= "\n\tif (";
						// set if counter
						$aifcounter = 0;
						foreach ($f_matchKeys as $af_matchKey)
						{
							$name = $matchNames[$af_matchKey];
							if ($aifcounter == 0)
							{
								$func .= $name;
							}
							else
							{
								$func .= ' && '.$name;
							}
							$aifcounter++;
						}
						$func .= ")\n\t{";

					}
					else
					{
						$func .= "\n\t//".$this->setLine(__LINE__)." set the function logic";
						$func .= "\n\tif (";
						// set if counter
						$ifcounter = 0;
						foreach ($f_matchKeys as $f_matchKey)
						{
							$if = $ifValue[$f_matchKey];
							if (ComponentbuilderHelper::checkString($if))
							{
								if ($ifcounter == 0)
								{
									$func .= $if;
								}
								else
								{
									$func .= ' && '.$if;
								}
								$ifcounter++;
							}
						}
						$func .= ")\n\t{";
					}
					// get the controles
					$controls = $targetControls[$f_matchKeys[0]];
					// get target behavior and default
					$targetBehavior = $behaviors[$f_matchKeys[0]];
					$targetDefault = $defaults[$f_matchKeys[0]];
					// load the target behavior
					foreach($controls as $target => $action)
					{
						$func .= $action['behavior'];
						if (ComponentbuilderHelper::checkString($action['hide']))
						{
							$func .= $action[$targetBehavior];
							$head .= $action['requiredVar'];
						}
					}
					$func .= "\n\t}\n\telse\n\t{";
					foreach($controls as $target => $action)
					{
						$func .= $action['default'];
						if (ComponentbuilderHelper::checkString($action['hide']))
						{
							$func .= $action[$targetDefault];
						}
					}
					$func .= "\n\t}\n}\n".$map;
				}
				// add the needed validation to file
				if (isset($this->validationFixBuilder[$viewName]) && ComponentbuilderHelper::checkArray($this->validationFixBuilder[$viewName]))
				{
					$validation .= "\n// update required fields";
					$validation .= "\nfunction updateFieldRequired(name,status)";
					$validation .= "\n{";
					$validation .= "\n\tvar not_required = jQuery('#jform_not_required').val();";
					$validation .= "\n\n\tif(status == 1)";
					$validation .= "\n\t{";
					$validation .= "\n\t\tif (isSet(not_required) && not_required != 0)";
					$validation .= "\n\t\t{";
					$validation .= "\n\t\t\tnot_required = not_required+','+name;";
					$validation .= "\n\t\t}";
					$validation .= "\n\t\telse";
					$validation .= "\n\t\t{";
					$validation .= "\n\t\t\tnot_required = ','+name;";
					$validation .= "\n\t\t}";
					$validation .= "\n\t}";
					$validation .= "\n\telse";
					$validation .= "\n\t{";
					$validation .= "\n\t\tif (isSet(not_required) && not_required != 0)";
					$validation .= "\n\t\t{";
					$validation .= "\n\t\t\tnot_required = not_required.replace(','+name,'');";
					$validation .= "\n\t\t}";
					$validation .= "\n\t}";
					$validation .= "\n\n\tjQuery('#jform_not_required').val(not_required);";
					$validation .= "\n}\n";
				}
				// set the isSet function
				$isSet = "\n// the isSet function";
				$isSet .= "\nfunction isSet(val)";
				$isSet .= "\n{";
				$isSet .= "\n\tif ((val != undefined) && (val != null) && 0 !== val.length){";
				$isSet .= "\n\t\treturn true;";
				$isSet .= "\n\t}";
				$isSet .= "\n\treturn false;";
				$isSet .= "\n}";
			}
			// load to this buket
			$fileScript	= $initial.$func.$validation.$isSet;
			$footerScript	= $listener;
		}
		// add custom script to file
		if (isset($this->customScriptBuilder['view_file'][$viewName]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['view_file'][$viewName]))
		{
			if (!isset($fileScript))
			{
				$fileScript = '';
			}
			$fileScript .= "\n\n".str_replace(array_keys($placeholders),array_values($placeholders),$this->customScriptBuilder['view_file'][$viewName]);
		}
		// add custom script to footer
		if (isset($this->customScriptBuilder['view_footer'][$viewName]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['view_footer'][$viewName]))
		{
			$customFooterScript = "\n\n".str_replace(array_keys($placeholders),array_values($placeholders),$this->customScriptBuilder['view_footer'][$viewName]);
			if (strpos($customFooterScript,'<?php') === false)
			{
				// only add now if no php is added to the footer script
				if (!isset($footerScript))
				{
					$footerScript = '';
				}
				$footerScript .= $customFooterScript;
				unset($customFooterScript);
			}

		}
		// minfy the script
		if ($this->params->get('minify') && isset($fileScript) && ComponentbuilderHelper::checkString($fileScript))
		{
			// minify the fielScript javscript
			$minifier = new JS;
			$minifier->add($fileScript);
			$fileScript = $minifier->minify();
		}
		// minfy the script
		if ($this->params->get('minify') && isset($footerScript) && ComponentbuilderHelper::checkString($footerScript))
		{
			// minify the footerScript javscript
			$minifier = new JS;
			$minifier->add($footerScript);
			$footerScript = $minifier->minify();
		}
		// make sure there is script to add
		if (isset($fileScript) && ComponentbuilderHelper::checkString($fileScript))
		{
			// add the head script if set
			if (isset($head) && ComponentbuilderHelper::checkString($head))
			{
				$fileScript = "// Some Global Values\n".$head."\n".$fileScript;
			}
			// load the script
			$this->editBodyViewScriptBuilder[$viewName]['fileScript'] = $fileScript;
		}
		// make sure to add custom footer script if php was found in it, since we canot minfy it with php
		if (isset($customFooterScript) && ComponentbuilderHelper::checkString($customFooterScript))
		{
			if (!isset($footerScript))
			{
				$footerScript = '';
			}
			$footerScript .= $customFooterScript;
		}
		// make sure there is script to add
		if (isset($footerScript) && ComponentbuilderHelper::checkString($footerScript))
		{
			// add the needed script tags
			$footerScript = "\n\n".'<script type="text/javascript">'."\n".$footerScript."\n</script>";
			$this->editBodyViewScriptBuilder[$viewName]['footerScript'] = $footerScript;
		}
	}

	protected function buildFunctionCall($function,$matchKeys,$getValue)
	{
		$initial	= '';
		$funcsets	= array();
		$array		= false;
		foreach ($matchKeys as $matchKey)
		{
			$value = $getValue[$matchKey];
			if ($value['isArray'])
			{
				$initial .= "\n\t".$value['get'];
				$funcsets[] = $matchKey;
				$array = true;
			}
			else
			{
				$initial .= "\n\t".$value['get'];
				$funcsets[] = $matchKey;
			}
		}

		// make sure that the function is loaded only once
		if (ComponentbuilderHelper::checkArray($funcsets))
		{
			$initial .= "\n\t".$function."(";
			$initial .= implode(',',$funcsets);
			$initial .= ");\n";
		}
		return array('code' => $initial, 'array' => $array);
	}

	protected function getTargetRelationScript($relations,$condition,$view)
	{
		// reset the buket
		$buket = array();
		// convert to name array
		foreach ($condition['target_field'] as $targetField)
		{
			if (ComponentbuilderHelper::checkArray($targetField))
			{
				$currentTargets[] = $targetField['name'];
			}
		}
		// start the search
		foreach($relations as $relation)
		{
			// reset found
			$found = false;
			if ($relation['match_field'] != $condition['match_field'])
			{
				if (ComponentbuilderHelper::checkArray($relation['target_field']))
				{
					foreach($relation['target_field'] as $target)
					{
						if (ComponentbuilderHelper::checkArray($target) && $this->checkRelationControl($target['name'],$relation['match_name'],$condition['match_name'],$view))
						{
							if (in_array($target['name'],$currentTargets))
							{
								$this->targetRelationControl[$view][$target['name']] = array($relation['match_name'],$condition['match_name']);
								$found = true;
								break;
							}
						}
					}
					if ($found)
					{
						$buket[] = $relation;
					}
				}
			}
		}
		return $buket;
	}

	protected function checkRelationControl($targetName,$relationMatchName,$conditionMatchName,$view)
	{
		if(isset($this->targetRelationControl[$view]) && ComponentbuilderHelper::checkArray($this->targetRelationControl[$view]))
		{
			if(isset($this->targetRelationControl[$view][$targetName]) && ComponentbuilderHelper::checkArray($this->targetRelationControl[$view][$targetName]))
			{
				if (!in_array($relationMatchName,$this->targetRelationControl[$view][$targetName]) || !in_array($conditionMatchName,$this->targetRelationControl[$view][$targetName]))
				{
					return true;
				}
			}
			else
			{
				return true;
			}
		}
		elseif (!isset($this->targetRelationControl[$view]) || !ComponentbuilderHelper::checkArray($this->targetRelationControl[$view]))
		{
			return true;
		}
		return false;
	}

	protected function setTargetControlsScript($targets,$targetBehavior,$targetDefault,$uniqueVar,$viewName)
	{
		$bucket = array();
		if (ComponentbuilderHelper::checkArray($targets) && !in_array($uniqueVar,$this->targetControlsScriptChecker))
		{
			foreach($targets as $target)
			{
				if (ComponentbuilderHelper::checkArray($target))
				{
					// set the required var
					if($target['required'] == 'yes')
					{
						$unique = $uniqueVar.ComponentbuilderHelper::randomkey(3);
						$bucket[$target['name']]['requiredVar'] = "jform_".$unique."_required = false;\n";
					}
					else
					{
						$bucket[$target['name']]['requiredVar'] = '';
					}
					// set target type
					$targetTypeSufix = "";
					if ($this->defaultField($target['type'], 'spacer'))
					{
						// target a class if this is a note or spacer
						$targetType = ".";
					}
					elseif ($target['type'] == 'editor')
					{
						// target the label if  editor field
						$targetType = "#jform_";
						// since the id is not alway accessable we use the lable TODO (not best way)
						$targetTypeSufix = "-lbl";
					}
					else
					{
						// target an id if this is a field
						$targetType = "#jform_";
					}
					// set the target behavior
					$bucket[$target['name']]['behavior'] = "\n\t\tjQuery('".$targetType.$target['name'].$targetTypeSufix."').closest('.control-group').".$targetBehavior."();";
					// set the target default
					$bucket[$target['name']]['default'] = "\n\t\tjQuery('".$targetType.$target['name'].$targetTypeSufix."').closest('.control-group').".$targetDefault."();";
					// the hide required function
					if($target['required'] == 'yes')
					{
						$hide = "\n\t\tif (!jform_".$unique."_required)";
						$hide .= "\n\t\t{";
						$hide .= "\n\t\t\tupdateFieldRequired('".$target['name']."',1);";
						$hide .= "\n\t\t\tjQuery('#jform_".$target['name']."').removeAttr('required');";
						$hide .= "\n\t\t\tjQuery('#jform_".$target['name']."').removeAttr('aria-required');";
						$hide .= "\n\t\t\tjQuery('#jform_".$target['name']."').removeClass('required');";
						$hide .= "\n\t\t\tjform_".$unique."_required = true;";
						$hide .= "\n\t\t}";
						$bucket[$target['name']]['hide'] = $hide;
						// the show required function
						$show = "\n\t\tif (jform_".$unique."_required)";
						$show .= "\n\t\t{";
						$show .= "\n\t\t\tupdateFieldRequired('".$target['name']."',0);";
						$show .= "\n\t\t\tjQuery('#jform_".$target['name']."').prop('required','required');";
						$show .= "\n\t\t\tjQuery('#jform_".$target['name']."').attr('aria-required',true);";
						$show .= "\n\t\t\tjQuery('#jform_".$target['name']."').addClass('required');";
						$show .= "\n\t\t\tjform_".$unique."_required = false;";
						$show .= "\n\t\t}\n";
						$bucket[$target['name']]['show'] = $show;
						// make sure that the axaj and other needed things for this view is loaded
						$this->validationFixBuilder[$viewName][] = $target['name'];
					}
					else
					{
						$bucket[$target['name']]['hide'] = '';
						$bucket[$target['name']]['show'] = '';
					}
				}
			}
			$this->targetControlsScriptChecker[] = $uniqueVar;
		}
		return $bucket;
	}


	protected function ifValueScript($value,$behavior,$type,$options)
	{
		// reset string
		$string = '';
		switch ($behavior)
		{
			case 1: // Is
			// only 4 list/radio/checkboxes
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option)
					{
						if (!is_numeric($option))
						{
							if($option != 'true' && $option != 'false')
							{
								$option = "'".$option."'";
							}
						}
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.' == '.$option;
						}
						else
						{
							$string .= $value.' == '.$option;
						}
					}
				}
				else
				{
					$string .= 'isSet('.$value.')';
				}
			}
			break;
			case 2: // Is Not
			// only 4 list/radio/checkboxes
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option)
					{
						if (!is_numeric($option))
						{
							if($option != 'true' && $option != 'false')
							{
								$option = "'".$option."'";
							}
						}
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.' != '.$option;
						}
						else
						{
							$string .= $value.' != '.$option;
						}
					}
				}
				else
				{
					$string .= '!isSet('.$value.')';
				}
			}
			break;
			case 3: // Any Selection
			// only 4 list/radio/checkboxes/dynamic_list
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option)
					{
						if (!is_numeric($option))
						{
							if($option != 'true' && $option != 'false')
							{
								$option = "'".$option."'";
							}
						}
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.' == '.$option;
						}
						else
						{
							$string .= $value.' == '.$option;
						}
					}
				}
				else
				{
					$userFix = '';
					if (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($type,$this->setScriptUserSwitch))
					{
						// TODO this needs a closer look, a bit buggy
						$userFix = " && ".$value." != 'Select a User.'";
					}
					//echo '<pre>'; var_dump($type);exit;
					$string .= 'isSet('.$value.')'.$userFix;
				}
			}
			break;
			case 4: // Active (not empty)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				$string .= 'isSet('.$value.')';
			}
			break;
			case 5: // Unactive (empty)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				$string .= '!isSet('.$value.')';
			}
			break;
			case 6: // Key Word All (case-sensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' && '.$value.'.indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 7: // Key Word Any (case-sensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.'.indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 8: // Key Word All (case-insensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						$keyword = ComponentbuilderHelper::safeString($keyword, 'w');
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' && '.$value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 9: // Key Word Any (case-insensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						$keyword = ComponentbuilderHelper::safeString($keyword, 'w');
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 10: // Min Length
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					if ($options['length'])
					{
						$string .= $value.'.length >= '.(int) $options['length'];
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.'.length >= 5';
				}
			}
			break;
			case 11: // Max Length
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))

			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					if ($options['length'])
					{
						$string .= $value.'.length <= '.(int) $options['length'];
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.'.length <= 5';
				}
			}
			break;
			case 12: // Exact Length
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					if ($options['length'])
					{
						$string .= $value.'.length == '.(int) $options['length'];
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.'.length == 5';
				}
			}
			break;
		}
		if(!ComponentbuilderHelper::checkString($string))
		{
			$string = 0;
		}
		return $string;
	}

	protected function getOptionsScript($type,$options)
	{
		$buket = array();
		if(ComponentbuilderHelper::checkString($options))
		{
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				$optionsArray = explode(PHP_EOL, $options);
				if (!ComponentbuilderHelper::checkArray($optionsArray))
				{
					$optionsArray[] = $optionsArray;
				}
				foreach($optionsArray as $option)
				{
					if (strpos($option,'|') !== false)
					{
						list($option) = explode('|', $option);
					}
					if ($option != 'dynamic_list')
					{
						// add option to return buket
						$buket[] = $option;
					}
				}
			}
			elseif(ComponentbuilderHelper::typeField($type, 'text'))
			{
				// check to get the key words if set
				$keywords = ComponentbuilderHelper::getBetween($options,'keywords="','"');
				if (ComponentbuilderHelper::checkString($keywords))
				{
					if (strpos($keywords,',') !== false)
					{
						$keywords = explode(',', $keywords);
						foreach($keywords as $keyword)
						{
							$buket['keywords'][] = trim($keyword);
						}

					}
					else
					{
						$buket['keywords'][] = trim($keywords);
					}
				}
				// check to ket string length if set
				$length = ComponentbuilderHelper::getBetween($options,'length="','"');
				if (ComponentbuilderHelper::checkString($length))
				{
					$buket['length'] = $length;
				} else {
					$buket['length'] = false;
				}
			}
		}

		return $buket;
	}

	protected function getValueScript($type,$name,$unique)
	{
		$select		= '';
		$isArray	= false;
		$keyName	= $name.'_'.$unique;
		if ($type == 'checkboxes')
		{
			$select =  "var ".$keyName." = [];\n\tjQuery('#jform_".$name." input[type=checkbox]').each(function()\n\t{\n\t\tif (jQuery(this).is(':checked'))\n\t\t{\n\t\t\t".$keyName.".push(jQuery(this).prop('value'));\n\t\t}\n\t});";
			$isArray = true;
		}
		elseif($type == 'checkbox')
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.'").prop(\'checked\');';
		}
		elseif ($type == 'radio')
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.' input[type=\'radio\']:checked").val();';
		}
		elseif ($type == 'list' || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.'").val();';
			$isArray = true;
		}
		elseif(ComponentbuilderHelper::typeField($type, 'text'))
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.'").val();';
		}
		return array( 'get' => $select, 'isArray' => $isArray);
	}

	protected function clearValueScript($type,$name,$unique)
	{
		$clear		= '';
		$isArray	= false;
		$keyName	= $name.'_'.$unique;
		if($type == 'text' || $type == 'password' || $type == 'textarea')
		{
			$clear =  "jQuery('#jform_".$name."').value = '';";
		}
		elseif($type == 'radio')
		{
			$clear = "jQuery('#jform_".$name."').checked = false;";
		}
		elseif($type == 'checkboxes' || $type == 'checkbox' || $type == 'checkbox')
		{
			$clear = "jQuery('#jform_".$name."').selectedIndex = -1;";
		}
		return $clear;
	}

	protected function setViewScript($view)
	{
		if (isset($this->editBodyViewScriptBuilder[$view]) && isset($this->editBodyViewScriptBuilder[$view]['fileScript']))
		{
			return $this->editBodyViewScriptBuilder[$view]['fileScript'];
		}
		return '';
	}

	protected function setEditBodyScript($view)
	{
		if (isset($this->editBodyViewScriptBuilder[$view]) && isset($this->editBodyViewScriptBuilder[$view]['footerScript']))
		{
			return $this->editBodyViewScriptBuilder[$view]['footerScript'];
		}
		return '';
	}

	protected function setValidationFix($view,$Component)
	{
		$fix = '';
		if (isset($this->validationFixBuilder[$view]) && ComponentbuilderHelper::checkArray($this->validationFixBuilder[$view]))
		{
			$fix .= "\n\n\t/**";
			$fix .= "\n\t* Method to validate the form data.";
			$fix .= "\n\t*";
			$fix .= "\n\t* @param   JForm   \$form   The form to validate against.";
			$fix .= "\n\t* @param   array   \$data   The data to validate.";
			$fix .= "\n\t* @param   string  \$group  The name of the field group to validate.";
			$fix .= "\n\t*";
			$fix .= "\n\t* @return  mixed  Array of filtered data if valid, false otherwise.";
			$fix .= "\n\t*";
			$fix .= "\n\t* @see     JFormRule";
			$fix .= "\n\t* @see     JFilterInput";
			$fix .= "\n\t* @since   12.2";
			$fix .= "\n\t*/";
			$fix .= "\n\tpublic function validate(\$form, \$data, \$group = null)";
			$fix .= "\n\t{";
			$fix .= "\n\t\t//".$this->setLine(__LINE__)." check if the not_required field is set";
			$fix .= "\n\t\tif (".$Component."Helper::checkString(\$data['not_required']))";
			$fix .= "\n\t\t{";
			$fix .= "\n\t\t\t\$requiredFields = (array) explode(',',(string) \$data['not_required']);";
			$fix .= "\n\t\t\t\$requiredFields = array_unique(\$requiredFields);";
			$fix .= "\n\t\t\t//".$this->setLine(__LINE__)." now change the required field attributes value";
			$fix .= "\n\t\t\tforeach (\$requiredFields as \$requiredField)";
			$fix .= "\n\t\t\t{";
			$fix .= "\n\t\t\t\t//".$this->setLine(__LINE__)." make sure there is a string value";
			$fix .= "\n\t\t\t\tif (".$Component."Helper::checkString(\$requiredField))";
			$fix .= "\n\t\t\t\t{";
			$fix .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." change to false";
			$fix .= "\n\t\t\t\t\t\$form->setFieldAttribute(\$requiredField, 'required', 'false');";
			$fix .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." also clear the data set";
			$fix .= "\n\t\t\t\t\t\$data[\$requiredField] = '';";
			$fix .= "\n\t\t\t\t}";
			$fix .= "\n\t\t\t}";
			$fix .= "\n\t\t}";
			$fix .= "\n\t\treturn parent::validate(\$form, \$data, \$group);";
			$fix .= "\n\t}";
		}
		return $fix;
	}

	protected function setAjaxToke($view)
	{
		$fix = '';
		if (isset($this->customScriptBuilder['token'][$view]) && $this->customScriptBuilder['token'][$view])
		{
			$fix .= "\n\t\t//".$this->setLine(__LINE__)." Add Ajax Token";
			$fix .= "\n\t\t\$document->addScriptDeclaration(\"var token = '\".JSession::getFormToken().\"';\");";
		}
		return $fix;
	}

	protected function setRegisterAjaxTask($target)
	{
		$tasks = '';
		if (isset($this->customScriptBuilder[$target]['ajax_controller']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder[$target]['ajax_controller']))
		{
			$taskArray = array();
			foreach ($this->customScriptBuilder[$target]['ajax_controller'] as $view)
			{
				foreach ($view as $task)
				{
					$taskArray[$task['task_name']] = $task['task_name'];
				}
			}
			if (ComponentbuilderHelper::checkArray($taskArray))
			{
				foreach ($taskArray as $name)
				{
					$tasks .= "\n\t\t\$this->registerTask('".$name."', 'ajax');";
				}
			}
		}
		return $tasks;
	}

	protected function setAjaxInputReturn($target)
	{
		$cases = '';
		if (isset($this->customScriptBuilder[$target]['ajax_controller']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder[$target]['ajax_controller']))
		{
			$input = array();
			$valueArray = array();
			$getModel = array();
			foreach ($this->customScriptBuilder[$target]['ajax_controller'] as $view)
			{
				foreach ($view as $task)
				{
					$input[$task['task_name']][] = "\n\t\t\t\t\t\t\$".$task['value_name']."Value = \$jinput->get('".$task['value_name']."', ".$task['input_default'].", '".$task['input_filter']."');";
					$valueArray[$task['task_name']][] = "\$".$task['value_name']."Value";
					$getModel[$task['task_name']] = "\n\t\t\t\t\t\t\t\$result = \$this->getModel('ajax')->".$task['method_name']."([[[valueArray]]]);";
					
					// see user check is needed
					if (!isset($task['user_check']) || 1 == $task['user_check'])
					{
						// add it since this means it was not set, and in the old method we assumed it was inplace
						// or it is set and 1 means we still want it inplace
						$userCheck[$task['task_name']] = ' && $user->id != 0';
					}
					else
					{
						$userCheck[$task['task_name']] = '';
					}
				}
			}
			if (ComponentbuilderHelper::checkArray($getModel))
			{
				foreach ($getModel as $task => $getMethod)
				{
					$cases .= "\n\t\t\t\tcase '".$task."':";
					$cases .= "\n\t\t\t\t\ttry";
					$cases .= "\n\t\t\t\t\t{";
					foreach ($input[$task] as $string)
					{
						$cases .= $string;
					}
					// set the values
					$values = implode(', ',$valueArray[$task]);
					$ifvalues = implode(' && ',$valueArray[$task]);
					// set the values to method
					$getMethod = str_replace('[[[valueArray]]]',$values,$getMethod);
					$cases .= "\n\t\t\t\t\t\tif(".$ifvalues.$userCheck[$task].")";
					$cases .= "\n\t\t\t\t\t\t{";
					$cases .= $getMethod;
					$cases .= "\n\t\t\t\t\t\t}";
					$cases .= "\n\t\t\t\t\t\telse";
					$cases .= "\n\t\t\t\t\t\t{";
					$cases .= "\n\t\t\t\t\t\t\t\$result = false;";
					$cases .= "\n\t\t\t\t\t\t}";
					$cases .= "\n\t\t\t\t\t\tif(array_key_exists('callback',\$_GET))";
					$cases .= "\n\t\t\t\t\t\t{";
					$cases .= "\n\t\t\t\t\t\t\techo \$_GET['callback'] . \"(\".json_encode(\$result).\");\";";
					$cases .= "\n\t\t\t\t\t\t}";
					$cases .= "\n\t\t\t\t\t\telse";
					$cases .= "\n\t\t\t\t\t\t{";
					$cases .= "\n\t\t\t\t\t\t\techo \"(\".json_encode(\$result).\");\";";
					$cases .= "\n\t\t\t\t\t\t}";
					$cases .= "\n\t\t\t\t\t}";
					$cases .= "\n\t\t\t\t\tcatch(Exception \$e)";
					$cases .= "\n\t\t\t\t\t{";
					$cases .= "\n\t\t\t\t\t\tif(array_key_exists('callback',\$_GET))";
					$cases .= "\n\t\t\t\t\t\t{";
					$cases .= "\n\t\t\t\t\t\t\techo \$_GET['callback'].\"(\".json_encode(\$e).\");\";";
					$cases .= "\n\t\t\t\t\t\t}";
					$cases .= "\n\t\t\t\t\t\telse";
					$cases .= "\n\t\t\t\t\t\t{";
					$cases .= "\n\t\t\t\t\t\t\techo \"(\".json_encode(\$e).\");\";";
					$cases .= "\n\t\t\t\t\t\t}";
					$cases .= "\n\t\t\t\t\t}";
					$cases .= "\n\t\t\t\tbreak;";
				}
			}
		}
		return $cases;
	}

	protected function setAjaxModelMethods($target)
	{
		$methods = '';
		if (isset($this->customScriptBuilder[$target]['ajax_model']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder[$target]['ajax_model']))
		{
			foreach ($this->customScriptBuilder[$target]['ajax_model'] as $view => $method)
			{
				$methods .= "\n\n\t//".$this->setLine(__LINE__)." Used in ".$view."\n";
				$methods .= str_replace(array_keys($this->placeholders),array_values($this->placeholders),$method);
			}
		}
		return $methods;
	}


	protected function setFilterFunctions($viewName_single,$viewName_list)
	{
		if (isset($this->filterBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$viewName_list]))
		{
			$function = array();
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
			foreach ($this->filterBuilder[$viewName_list] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] == 'user')
				{
					$function[] = "\n\tprotected function getThe".$filter['function'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F')."Selections()";
					$function[] = "\t{";
					$function[] = "\t\t//".$this->setLine(__LINE__)." Get a db connection.";
					$function[] = "\t\t\$db = JFactory::getDbo();";
					$function[] = "\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
					$function[] = "\t\t\$query = \$db->getQuery(true);";
					$function[] = "\n\t\t//".$this->setLine(__LINE__)." Select the text.";
					$function[] = "\t\t\$query->select(\$db->quoteName(array('a.".$filter['custom']['id']."','a.".$filter['custom']['text']."')));";
					$function[] = "\t\t\$query->from(\$db->quoteName('".$filter['custom']['table']."', 'a'));";
					$function[] = "\t\t//".$this->setLine(__LINE__)." get the targeted groups";
					$function[] = "\t\t\$groups= JComponentHelper::getParams('com_".$component."')->get('".$filter['type']."');";
					$function[] = "\t\tif (count(\$groups) > 0)";
					$function[] = "\t\t{";
					$function[] = "\t\t\t\$query->join('LEFT', \$db->quoteName('#__user_usergroup_map', 'group') . ' ON (' . \$db->quoteName('group.user_id') . ' = ' . \$db->quoteName('a.id') . ')');";
					$function[] = "\t\t\t\$query->where('group.group_id IN (' . implode(',', \$groups) . ')');";
					$function[] = "\t\t}";
					$function[] = "\t\t\$query->order('a.".$filter['custom']['text']." ASC');";
					$function[] = "\n\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$function[] = "\t\t\$db->setQuery(\$query);";
					$function[] = "\n\t\t\$results = \$db->loadObjectList();";
					$function[] = "\t\tif (\$results)";
					$function[] = "\t\t{";
					$function[] = "\t\t\t\$filter = array();";
					$function[] = "\t\t\t\$batch = array();";
					$function[] = "\t\t\tforeach (\$results as \$result)";
					$function[] = "\t\t\t{";
					$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", \$result->".$filter['custom']['text'].");";
					$function[] = "\t\t\t}";
					$function[] = "\t\t\treturn  \$filter;";
					$function[] = "\t\t}";
					$function[] = "\t\treturn false;";
					$function[] = "\t}";

					/* else
					{
						$function[] = "\n\tprotected function getThe".$filter['function'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F')."Selections()";
						$function[] = "\t{";
						$function[] = "\t\t//".$this->setLine(__LINE__)." Get a db connection.";
						$function[] = "\t\t\$db = JFactory::getDbo();";
						$function[] = "\n\t\t//".$this->setLine(__LINE__)." Select the text.";
						$function[] = "\t\t\$query = \$db->getQuery(true);";
						$function[] = "\n\t\t//".$this->setLine(__LINE__)." Select the text.";
						$function[] = "\t\t\$query->select(\$db->quoteName(array('".$filter['custom']['id']."','".$filter['custom']['text']."')));";
						$function[] = "\t\t\$query->from(\$db->quoteName('".$filter['custom']['table']."'));";
						$function[] = "\t\t\$query->where(\$db->quoteName('published') . ' = 1');";
						$function[] = "\t\t\$query->order(\$db->quoteName('".$filter['custom']['text']."') . ' ASC');";
						$function[] = "\n\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
						$function[] = "\t\t\$db->setQuery(\$query);";
						$function[] = "\n\t\t\$results = \$db->loadObjectList();";
						$function[] = "\n\t\tif (\$results)";
						$function[] = "\t\t{";
						$function[] = "\t\t\t\$filter = array();";
						$function[] = "\t\t\t\$batch = array();";
						$function[] = "\t\t\tforeach (\$results as \$result)";
						$function[] = "\t\t\t{";
						if ($filter['custom']['text'] == 'user')
						{
							$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['text'].", JFactory::getUser(\$result->".$filter['custom']['text'].")->name);";
							$function[] = "\t\t\t\t\$batch[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", JFactory::getUser(\$result->".$filter['custom']['text'].")->name);";
						}
						else
						{
							$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['text'].", \$result->".$filter['custom']['text'].");";
							$function[] = "\t\t\t\t\$batch[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", \$result->".$filter['custom']['text'].");";
						}
						$function[] = "\t\t\t}";
						$function[] = "\t\t\treturn array('filter' => \$filter, 'batch' => \$batch);";
						$function[] = "\t\t}";
						$function[] = "\t\treturn false;";
						$function[] = "\t}";
					}*/
				}
				elseif ($filter['type'] != 'category' && !ComponentbuilderHelper::checkArray($filter['custom']))
				{
					$translation = false;
					if (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list])
						&& array_key_exists($filter['code'],$this->selectionTranslationFixBuilder[$viewName_list]))
					{
						$translation = true;
					}
					$function[] = "\n\tprotected function getThe".$filter['function']."Selections()";
					$function[] = "\t{";
					$function[] = "\t\t//".$this->setLine(__LINE__)." Get a db connection.";
					$function[] = "\t\t\$db = JFactory::getDbo();";
					$function[] = "\n\t\t//".$this->setLine(__LINE__)." Create a new query object.";
					$function[] = "\t\t\$query = \$db->getQuery(true);";
					$function[] = "\n\t\t//".$this->setLine(__LINE__)." Select the text.";
					$function[] = "\t\t\$query->select(\$db->quoteName('".$filter['code']."'));";
					$function[] = "\t\t\$query->from(\$db->quoteName('#__".$component."_".$filter['database']."'));";
					$function[] = "\t\t\$query->order(\$db->quoteName('".$filter['code']."') . ' ASC');";
					$function[] = "\n\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$function[] = "\t\t\$db->setQuery(\$query);";
					$function[] = "\n\t\t\$results = \$db->loadColumn();";
					$function[] = "\n\t\tif (\$results)";
					$function[] = "\t\t{";
					// check if translated vlaue is used
					if ($translation)
					{
						$function[] = "\t\t\t//".$this->setLine(__LINE__)." get model";
						$function[] = "\t\t\t\$model = \$this->getModel();";
					}
					$function[] = "\t\t\t\$results = array_unique(\$results);";
					$function[] = "\t\t\t\$filter = array();";
					$function[] = "\t\t\tforeach (\$results as \$".$filter['code'].")";
					$function[] = "\t\t\t{";

					// check if translated vlaue is used
					if ($translation)
					{
						$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." Translate the ".$filter['code']." selection";
						$function[] = "\t\t\t\t\$text = \$model->selectionTranslation(\$".$filter['code'].",'".$filter['code']."');";
						$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." Now add the ".$filter['code']." and its text to the options array";
						$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$".$filter['code'].", JText::_(\$text));";
					}
					else
					{
						$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." Now add the ".$filter['code']." and its text to the options array";
						$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$".$filter['code'].", \$".$filter['code'].");";
					}
					$function[] = "\t\t\t}";
					$function[] = "\t\t\treturn \$filter;";
					$function[] = "\t\t}";
					$function[] = "\t\treturn false;";
					$function[] = "\t}";
				}
			}
			if (ComponentbuilderHelper::checkArray($function))
			{
				// return the function
				return "\n".implode("\n",$function);
			}
		}
		return '';
	}

	protected function setUniqueFields($view)
	{
		$fields = array();
		$fields[] = "\n\n\t/**";
		$fields[] = "\t * Method to get the unique fields of this table.";
		$fields[] = "\t *";
		$fields[] = "\t * @return  mixed  An array of field names, boolean false if none is set.";
		$fields[] = "\t *";
		$fields[] = "\t * @since   3.0";
		$fields[] = "\t */";
		$fields[] = "\tprotected function getUniqeFields()";
		$fields[] = "\t{";
		if (isset($this->dbUniqueKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbUniqueKeys[$view]))
		{
			$fields[] = "\t\treturn array('".implode("','",$this->dbUniqueKeys[$view])."');";
		}
		else
		{
			$fields[] = "\t\treturn false;";
		}
		$fields[] = "\t}";
		// return the unique fields
		return implode("\n",$fields);
	}

	protected function setOtherFilter($view)
	{
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			$otherFilter = array();
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] !== 'user')
				{
					$CodeName = ComponentbuilderHelper::safeString($filter['code'].' '.$filter['custom']['text'],'W');
					$codeName = $filter['code'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F');
					$type = ComponentbuilderHelper::safeString($filter['custom']['type'],'F');
					$otherFilter[] = "\n\t\t//".$this->setLine(__LINE__)." Set ".$CodeName." Selection";
					$otherFilter[] = "\t\t\$this->".$codeName."Options = JFormHelper::loadFieldType('".$type."')->getOptions();";
					$otherFilter[] = "\t\tif (\$this->".$codeName."Options)";
					$otherFilter[] = "\t\t{";
					$otherFilter[] = "\t\t\t//".$this->setLine(__LINE__)." ".$CodeName." Filter";
					$otherFilter[] = "\t\t\tJHtmlSidebar::addFilter(";
					$otherFilter[] = "\t\t\t\t'- Select '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t'filter_".$filter['code']."',";
					$otherFilter[] = "\t\t\t\tJHtml::_('select.options', \$this->".$codeName."Options, 'value', 'text', \$this->state->get('filter.".$filter['code']."'))";
					$otherFilter[] = "\t\t\t);";

					$otherFilter[] = "\n\t\t\tif (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$otherFilter[] = "\t\t\t{";
					$otherFilter[] = "\t\t\t\t//".$this->setLine(__LINE__)." ".$CodeName." Batch Selection";
					$otherFilter[] = "\t\t\t\tJHtmlBatch_::addListSelection(";
					$otherFilter[] = "\t\t\t\t\t'- Keep Original '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t\t'batch[".$filter['code']."]',";
					$otherFilter[] = "\t\t\t\t\tJHtml::_('select.options', \$this->".$codeName."Options, 'value', 'text')";
					$otherFilter[] = "\t\t\t\t);";
					$otherFilter[] = "\t\t\t}";

					$otherFilter[] = "\t\t}";
				}
				elseif ($filter['type'] != 'category')
				{
					$Codename = ComponentbuilderHelper::safeString($filter['code'],'W');
					if (isset($filter['custom']) && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] === 'user')
					{
						$functionName = "\$this->getThe".$filter['function'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F')."Selections();";
					}
					else
					{
						$functionName = "\$this->getThe".$filter['function']."Selections();";
					}
					$otherFilter[] = "\n\t\t//".$this->setLine(__LINE__)." Set ".$Codename." Selection";
					$otherFilter[] = "\t\t\$this->".$filter['code']."Options = ".$functionName;
					$otherFilter[] = "\t\tif (\$this->".$filter['code']."Options)";
					$otherFilter[] = "\t\t{";
					$otherFilter[] = "\t\t\t//".$this->setLine(__LINE__)." ".$Codename." Filter";
					$otherFilter[] = "\t\t\tJHtmlSidebar::addFilter(";
					$otherFilter[] = "\t\t\t\t'- Select '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t'filter_".$filter['code']."',";
					$otherFilter[] = "\t\t\t\tJHtml::_('select.options', \$this->".$filter['code']."Options, 'value', 'text', \$this->state->get('filter.".$filter['code']."'))";
					$otherFilter[] = "\t\t\t);";

					$otherFilter[] = "\n\t\t\tif (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$otherFilter[] = "\t\t\t{";
					$otherFilter[] = "\t\t\t\t//".$this->setLine(__LINE__)." ".$Codename." Batch Selection";
					$otherFilter[] = "\t\t\t\tJHtmlBatch_::addListSelection(";
					$otherFilter[] = "\t\t\t\t\t'- Keep Original '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t\t'batch[".$filter['code']."]',";
					$otherFilter[] = "\t\t\t\t\tJHtml::_('select.options', \$this->".$filter['code']."Options, 'value', 'text')";
					$otherFilter[] = "\t\t\t\t);";
					$otherFilter[] = "\t\t\t}";

					$otherFilter[] = "\t\t}";
				}
			}
			if (ComponentbuilderHelper::checkArray($otherFilter))
			{
				// return the filter
				return "\n".implode("\n",$otherFilter);
			}
		}
		return '';
	}

	protected function setCategoryFilter($viewName_list)
	{
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			// check if category has another name
			if (isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
			}
			else
			{
				$otherViews = $viewName_list;
			}
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
			$COMONENT = ComponentbuilderHelper::safeString($this->componentData->name_code,'U');
			// set filter
			$filter = array();
			$filter[] = "\n\n\t\t//".$this->setLine(__LINE__)." Category Filter.";
			$filter[] = "\t\tJHtmlSidebar::addFilter(";
			$filter[] = "\t\t\tJText::_('JOPTION_SELECT_CATEGORY'),";
			$filter[] = "\t\t\t'filter_category_id',";
			$filter[] = "\t\t\tJHtml::_('select.options', JHtml::_('category.options', 'com_".$component.".".$otherViews."'), 'value', 'text', \$this->state->get('filter.category_id'))";
			$filter[] = "\t\t);";


			$filter[] = "\n\t\tif (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
			$filter[] = "\t\t{";
			$filter[] = "\t\t\t//".$this->setLine(__LINE__)." Category Batch selection.";
			$filter[] = "\t\t\tJHtmlBatch_::addListSelection(";
			$filter[] = "\t\t\t\tJText::_('COM_".$COMONENT."_KEEP_ORIGINAL_CATEGORY'),";
			$filter[] = "\t\t\t\t'batch[category]',";
			$filter[] = "\t\t\t\tJHtml::_('select.options', JHtml::_('category.options', 'com_".$component.".".$otherViews."'), 'value', 'text')";
			$filter[] = "\t\t\t);";
			$filter[] = "\t\t}";

			// return the filter
			return implode("\n",$filter);
		}
		return '';
	}



	protected function setRouterCategoryViews($viewName_single,$viewName_list)
	{
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// check if category has another name
			if (isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// return category view string
			if (isset($this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###']) && ComponentbuilderHelper::checkString($this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###']))
			{
				return ",\n\t\t\t".'"com_'.$component.'.'.$otherViews.'" => "'.$otherView.'"';
			}
			else
			{
				return "\n\t\t\t".'"com_'.$component.'.'.$otherViews.'" => "'.$otherView.'"';
			}
		}
		return '';

	}

	protected function setJcontrollerAllowAdd($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if item has category
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." get the user object";
			$allow[] = "\t\t\$user = JFactory::getUser();";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = \$user->authorise('".$core['core.access']."', 'com_".$component."');";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			$allow[] = "\t\t\$categoryId = JArrayHelper::getValue(\$data, 'catid', \$this->input->getInt('filter_category_id'), 'int');";
			$allow[] = "\t\t\$allow = null;";
			$allow[] = "\n\t\tif (\$categoryId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." If the category has been passed in the URL check it.";
			$allow[] = "\t\t\t\$allow = \$user->authorise('core.create', \$this->option . '.".$otherViews.".category.' . \$categoryId);";
			$allow[] = "\t\t}";
			$allow[] = "\n\t\tif (\$allow === null)";
			$allow[] = "\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
			{
				// setup the default script
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\t\treturn \$user->authorise('".$core['core.create']."', \$this->option);";
			}
			else
			{
				// setup the default script
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\t\treturn parent::allowAdd(\$data);";
			}
			$allow[] = "\t\t}";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\treturn \$allow;";
			$allow[] = "\t\t}";
		}
		else
		{
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = JFactory::getUser()->authorise('".$core['core.access']."', 'com_".$component."');";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
			{
				// setup the default script
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn JFactory::getUser()->authorise('".$core['core.create']."', \$this->option);";
			}
			else
			{
				// setup the default script
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn parent::allowAdd(\$data);";
			}
		}
		return implode("\n",$allow);
	}

	protected function setJcontrollerAllowEdit($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// prepare custom permission script
		if (isset($this->customScriptBuilder['php_allowedit'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_allowedit'][$viewName_single]))
		{
			$customAllow = str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_allowedit'][$viewName_single]);
		}
		else
		{
			$customAllow = '';
		}
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$allow[] = "\t\t//".$this->setLine(__LINE__)." get user object.";
			$allow[] = "\t\t\$user\t\t= JFactory::getUser();";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." get record id.";
			$allow[] = "\t\t\$recordId\t= (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = (\$user->authorise('".$core['core.access']."', 'com_".$component.".".$otherView.".' . (int) \$recordId) && \$user->authorise('".$core['core.access']."', 'com_".$component."'));";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			$allow[] = "\n\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($otherView,$this->permissionBuilder[$core['core.edit']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit']."', 'com_".$component.".".$otherView.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit', 'com_".$component.".".$otherView.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission && !is_null(\$permission))";
			$allow[] = "\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder[$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.own']]) && in_array($otherView,$this->permissionBuilder[$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component.".".$otherView.".' . \$recordId))";
			}
			else
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component.".".$otherView.".' . \$recordId))";
			}
			$allow[] = "\t\t\t\t{";
			$allow[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Fallback on edit.own. Now test the owner is the user.";
			$allow[] = "\t\t\t\t\t\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = "\t\t\t\t\tif (empty(\$ownerId))";
			$allow[] = "\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." Need to do a lookup from the model.";
			$allow[] = "\t\t\t\t\t\t\$record = \$this->getModel()->getItem(\$recordId);";
			$allow[] = "\n\t\t\t\t\t\tif (empty(\$record))";
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn false;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t\t\$ownerId = \$record->created_by;";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = "\n\t\t\t\t\t//".$this->setLine(__LINE__)." If the owner matches 'me' then do the test.";
			$allow[] = "\t\t\t\t\tif (\$ownerId == \$user->id)";
			$allow[] = "\t\t\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder['global'][$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.own']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component."'))";
			}
			else
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component."'))";
			}
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn true;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = "\t\t\t\t}";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\n\t\t\t\$categoryId = (int) isset(\$data['catid']) ? \$data['catid']: \$this->getModel()->getItem(\$recordId)->catid;";
			$allow[] = "\n\t\t\tif (\$categoryId)";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." The category has been set. Check the category permissions.";
			$allow[] = "\t\t\t\t\$catpermission = \$user->authorise('core.edit', \$this->option . '.".$otherViews.".category.' . \$categoryId);";
			$allow[] = "\t\t\t\tif (!\$catpermission && !is_null(\$catpermission))";
			$allow[] = "\t\t\t\t{";
			$allow[] = "\t\t\t\t\treturn false;";
			$allow[] = "\t\t\t\t}";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit']."', \$this->option);";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn parent::allowEdit(\$data, \$key);";
			}
		}
		else
		{
			// setup the category script
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." get user object.";
			$allow[] = "\t\t\$user\t\t= JFactory::getUser();";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." get record id.";
			$allow[] = "\t\t\$recordId\t= (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder[$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.access']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.access']]))
			{
				$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = (\$user->authorise('".$core['core.access']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId) &&  \$user->authorise('".$core['core.access']."', 'com_".$component."'));";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			$allow[] = "\n\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission && !is_null(\$permission))";
			$allow[] = "\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder[$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.own']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component.".".$viewName_single.".' . \$recordId))";
			}
			else
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component.".".$viewName_single.".' . \$recordId))";
			}
			$allow[] = "\t\t\t\t{";
			$allow[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Now test the owner is the user.";
			$allow[] = "\t\t\t\t\t\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = "\t\t\t\t\tif (empty(\$ownerId))";
			$allow[] = "\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." Need to do a lookup from the model.";
			$allow[] = "\t\t\t\t\t\t\$record = \$this->getModel()->getItem(\$recordId);";
			$allow[] = "\n\t\t\t\t\t\tif (empty(\$record))";
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn false;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t\t\$ownerId = \$record->created_by;";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = "\n\t\t\t\t\t//".$this->setLine(__LINE__)." If the owner matches 'me' then allow.";
			$allow[] = "\t\t\t\t\tif (\$ownerId == \$user->id)";
			$allow[] = "\t\t\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder['global'][$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.own']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component."'))";
			}
			else
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component."'))";
			}
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn true;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = "\t\t\t\t}";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit']."', \$this->option);";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn parent::allowEdit(\$data, \$key);";
			}
		}

		return implode("\n",$allow);
	}

	protected function setJmodelAdminGetForm($viewName_single,$viewName_list)
	{
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// allways load these
		$allow = array();
		$allow[] = "\t\t//".$this->setLine(__LINE__)." Get the form.";
		$allow[] = "\t\t\$form = \$this->loadForm('com_".$component.".".$viewName_single."', '".$viewName_single."', array('control' => 'jform', 'load_data' => \$loadData));";
		$allow[] = "\n\t\tif (empty(\$form))";
		$allow[] = "\t\t{";
		$allow[] = "\t\t\treturn false;";
		$allow[] = "\t\t}";
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$allow[] = "\n\t\t\$jinput = JFactory::getApplication()->input;";
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$allow[] = "\t\tif (\$jinput->get('a_id'))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('a_id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Determine correct permissions to check.";
			$allow[] = "\t\tif (\$this->getState('".$viewName_single.".id'))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$this->getState('".$viewName_single.".id');";
			$allow[] = "\n\t\t\t\$catid = 0;";
			$allow[] = "\t\t\tif (isset(\$this->getItem(\$id)->catid))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." set catagory id";
			$allow[] = "\t\t\t\t\$catid = \$this->getItem(\$id)->catid;";
			$allow[] = "\n\t\t\t\t//".$this->setLine(__LINE__)." Existing record. Can only edit in selected categories.";
			$allow[] = "\t\t\t\t\$form->setFieldAttribute('catid', 'action', 'core.edit');";
			$allow[] = "\n\t\t\t\t//".$this->setLine(__LINE__)." Existing record. Can only edit own items in selected categories.";
			$allow[] = "\t\t\t\t\$form->setFieldAttribute('catid', 'action', 'core.edit.own');";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." New record. Can only create in selected categories.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('catid', 'action', 'core.create');";
			$allow[] = "\t\t}";
			$allow[] = "\n\t\t\$user = JFactory::getUser();";
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Check for existing item.";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit State access controls.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (isset(\$catid) && \$catid != 0 && !\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_list.".category.' . (int) \$catid))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.state']."', 'com_".$component."')))";
			}
			else
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (isset(\$catid) && \$catid != 0 && !\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_list.".category.' . (int) \$catid))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('core.edit.state', 'com_".$component."')))";
			}
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'disabled', 'true');";
			$allow[] = "\n\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'filter', 'unset');";
			$allow[] = "\t\t}";
		}
		else
		{
			$allow[] = "\n\t\t\$jinput = JFactory::getApplication()->input;";
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$allow[] = "\t\tif (\$jinput->get('a_id'))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('a_id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = "\n\t\t\$user = JFactory::getUser();";
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Check for existing item.";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit State access controls.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.state']."', 'com_".$component."')))";
			}
			else
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('core.edit.state', 'com_".$component."')))";
			}
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'disabled', 'true');";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'filter', 'unset');";
			$allow[] = "\t\t}";
		}
		$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit Creaded By access controls.";
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit.created_by']) && isset($this->permissionBuilder[$core['core.edit.created_by']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.created_by']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.created_by']]))
		{
			$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.created_by']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
			$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.created_by']."', 'com_".$component."')))";
		}
		else
		{
			$allow[] = "\t\tif (!\$user->authorise('core.edit.created_by', 'com_".$component."'))";
		}
		$allow[] = "\t\t{";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created_by', 'disabled', 'true');";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created_by', 'readonly', 'true');";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created_by', 'filter', 'unset');";
		$allow[] = "\t\t}";
		$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit Creaded Date access controls.";
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit.created']) && isset($this->permissionBuilder[$core['core.edit.created']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.created']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.created']]))
		{
			$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.created']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
			$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.created']."', 'com_".$component."')))";
		}
		else
		{
			$allow[] = "\t\tif (!\$user->authorise('core.edit.created', 'com_".$component."'))";
		}
		$allow[] = "\t\t{";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created', 'disabled', 'true');";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created', 'filter', 'unset');";
		$allow[] = "\t\t}";
		// handel the fields permissions
		if (isset($this->permissionFields[$viewName_single]) && ComponentbuilderHelper::checkArray($this->permissionFields[$viewName_single]))
		{
			foreach ($this->permissionFields[$viewName_single] as $fieldName => $fieldType)
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit ".ComponentbuilderHelper::safeString($fieldName, 'W')." access controls.";
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$viewName_single.".edit.".$fieldName."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$viewName_single.".edit.".$fieldName."', 'com_".$component."')))";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
				$allow[] = "\t\t\t\$form->setFieldAttribute('".$fieldName."', 'disabled', 'true');";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
				$allow[] = "\t\t\t\$form->setFieldAttribute('".$fieldName."', 'readonly', 'true');";
				if ('radio' == $fieldType || 'repeatable' == $fieldType)
				{
					$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable radio button for display.";
					$allow[] = "\t\t\t\$class = \$form->getFieldAttribute('".$fieldName."', 'class', '');";
					$allow[] = "\t\t\t\$form->setFieldAttribute('".$fieldName."', 'class', \$class.' disabled no-click');";
				}
				$allow[] = "\t\t\tif (!\$form->getValue('".$fieldName."'))";
				$allow[] = "\t\t\t{";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
				$allow[] = "\t\t\t\t\$form->setFieldAttribute('".$fieldName."', 'filter', 'unset');";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
				$allow[] = "\t\t\t\t\$form->setFieldAttribute('".$fieldName."', 'required', 'false');";
				$allow[] = "\t\t\t}";
				$allow[] = "\t\t}";
			}
		}
		// setup the default script
		$allow[] = "\n\t\treturn \$form;";

		return implode("\n",$allow);
	}

	protected function setJmodelAdminAllowEdit($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// prepare custom permission script
		if (isset($this->customScriptBuilder['php_allowedit'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_allowedit'][$viewName_single]))
		{
			$customAllow = "\t\t\$recordId\t= (int) isset(\$data[\$key]) ? \$data[\$key] : 0;\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_allowedit'][$viewName_single]);
		}
		else
		{
			$customAllow = '';
		}
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
		{
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Check specific edit permission then general edit permission.";
			$allow[] = "\t\t\$user = JFactory::getUser();";
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = "\t\treturn \$user->authorise('".$core['core.edit']."', 'com_".$component.".".$viewName_single.".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or \$user->authorise('".$core['core.edit']."',  'com_".$component."');";
		}
		else
		{
			$allow[] = "\n\t\t//".$this->setLine(__LINE__)." Check specific edit permission then general edit permission.";
			if (ComponentbuilderHelper::checkString($customAllow))
			{
				$allow[] = "\t\t\$user = JFactory::getUser();";
			}
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = "\t\treturn JFactory::getUser()->authorise('core.edit', 'com_".$component.".".$viewName_single.".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or parent::allowEdit(\$data, \$key);";
		}

		return implode("\n",$allow);
	}

	protected function setJmodelAdminCanDelete($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$allow[] = "\n\t\tif (!empty(\$record->id))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\tif (\$record->published != -2)";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn;";
			$allow[] = "\t\t\t}";
			$allow[] = "\n\t\t\t\$user = JFactory::getUser();";
			$allow[] = "\t\t\t\$allow = \$user->authorise('core.delete', 'com_".$component.".".$otherViews.".category.' . (int) \$record->catid);";
			// check if the item has permissions.
			if ($coreLoad && isset($this->permissionBuilder[$core['core.delete']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.delete']]) && in_array($otherView,$this->permissionBuilder[$core['core.delete']]))
			{
				$allow[] = "\n\t\t\tif (\$allow)";
				$allow[] = "\t\t\t{";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\t\treturn \$user->authorise('".$core['core.delete']."', 'com_".$component.".".$otherView.".' . (int) \$record->id);";
				$allow[] = "\t\t\t}";
			}
			else
			{
				$allow[] = "\n\t\t\tif (\$allow)";
				$allow[] = "\t\t\t{";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\t\treturn \$user->authorise('core.delete', 'com_".$component.".".$otherView.".' . (int) \$record->id);";
				$allow[] = "\t\t\t}";
			}
			$allow[] = "\t\t\treturn \$allow;";
			$allow[] = "\t\t}";
			$allow[] = "\t\treturn false;";
		}
		else
		{
			// setup the default script
			$allow[] = "\n\t\tif (!empty(\$record->id))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\tif (\$record->published != -2)";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn;";
			$allow[] = "\t\t\t}";
			// check if the item has permissions.
			if ($coreLoad && isset($this->permissionBuilder[$core['core.delete']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.delete']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.delete']]))
			{
				$allow[] = "\n\t\t\t\$user = JFactory::getUser();";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\treturn \$user->authorise('".$core['core.delete']."', 'com_".$component.".".$viewName_single.".' . (int) \$record->id);";
			}
			else
			{
				$allow[] = "\n\t\t\t\$user = JFactory::getUser();";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\treturn \$user->authorise('core.delete', 'com_".$component.".".$viewName_single.".' . (int) \$record->id);";
			}
			$allow[] = "\t\t}";
			$allow[] = "\t\treturn false;";
		}

		return implode("\n",$allow);
	}

	protected function setJmodelAdminCanEditState($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
			// check if category has another name
			if (isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			$allow[] = "\n\t\t\$user = JFactory::getUser();";
			$allow[] = "\t\t\$recordId\t= (!empty(\$record->id)) ? \$record->id : 0;";
			$allow[] = "\n\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission && !is_null(\$permission))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			// setup the category script
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Check against the category.";
			$allow[] = "\t\tif (!empty(\$record->catid))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$catpermission = \$user->authorise('core.edit.state', 'com_".$component.".".$otherViews.".category.' . (int) \$record->catid);";
			$allow[] = "\t\t\tif (!\$catpermission && !is_null(\$catpermission))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit.state']."', 'com_".$component."');";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn parent::canEditState(\$record);";
			}
		}
		else
		{
			// setup the default script
			$allow[] = "\n\t\t\$user = JFactory::getUser();";
			$allow[] = "\t\t\$recordId\t= (!empty(\$record->id)) ? \$record->id : 0;";
			$allow[] = "\n\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission && !is_null(\$permission))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit.state']."', 'com_".$component."');";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn parent::canEditState(\$record);";
			}
		}
		return implode("\n",$allow);
	}



	protected function setJviewListCanDo($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if the item has permissions for edit.
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
		{
			$allow[] = "\n\t\t\$this->canEdit\t\t= \$this->canDo->get('".$core['core.edit']."');";
		}
		else
		{
			$allow[] = "\n\t\t\$this->canEdit\t\t= \$this->canDo->get('core.edit');";
		}
		// check if the item has permissions for edit state.
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$allow[] = "\t\t\$this->canState\t\t= \$this->canDo->get('".$core['core.edit.state']."');";
		}
		else
		{
			$allow[] = "\t\t\$this->canState\t\t= \$this->canDo->get('core.edit.state');";
		}
		// check if the item has permissions for create.
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
		{
			$allow[] = "\t\t\$this->canCreate\t= \$this->canDo->get('".$core['core.create']."');";
		}
		else
		{
			$allow[] = "\t\t\$this->canCreate\t= \$this->canDo->get('core.create');";
		}
		// check if the item has permissions for delete.
		if ($coreLoad && isset($core['core.delete']) && isset($this->permissionBuilder['global'][$core['core.delete']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.delete']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.delete']]))
		{
			$allow[] = "\t\t\$this->canDelete\t= \$this->canDo->get('".$core['core.delete']."');";
		}
		else
		{
			$allow[] = "\t\t\$this->canDelete\t= \$this->canDo->get('core.delete');";
		}
		// check if the item has permissions for batch.
		if ($coreLoad && isset($core['core.batch']) && isset($this->permissionBuilder['global']['global'][$core['core.batch']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global']['global'][$core['core.batch']]) && in_array($viewName_single,$this->permissionBuilder['global']['global'][$core['core.delete']]))
		{
			$allow[] = "\t\t\$this->canBatch\t= (\$this->canDo->get('".$core['core.batch']."') && \$this->canDo->get('core.batch'));";
		}
		else
		{
			$allow[] = "\t\t\$this->canBatch\t= \$this->canDo->get('core.batch');";
		}

		return implode("\n",$allow);
	}

	protected function setFieldSetAccessControl($view)
	{
		$access = '';
		if ($view != 'component')
		{
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// set label
			$label = 'Permissions in relation to this '.$view;
			// set the access fieldset
			$access = "<!--".$this->setLine(__LINE__)." Access Control Fields. -->";
			$access .= "\n\t".'<fieldset name="accesscontrol">';
			$access .= "\n\t\t<!--".$this->setLine(__LINE__)." Asset Id Field. Type: Hidden (joomla) -->";
			$access .= "\n\t\t".'<field';
			$access .= "\n\t\t\t".'name="asset_id"';
			$access .= "\n\t\t\t".'type="hidden"';
			$access .= "\n\t\t\t".'filter="unset"';
			$access .= "\n\t\t".'/>';
			$access .= "\n\t\t<!--".$this->setLine(__LINE__)." Rules Field. Type: Rules (joomla) -->";
			$access .= "\n\t\t".'<field';
			$access .= "\n\t\t\t".'name="rules"';
			$access .= "\n\t\t\t".'type="rules"';
			$access .= "\n\t\t\t".'label="'.$label.'"';
			$access .= "\n\t\t\t".'translate_label="false"';
			$access .= "\n\t\t\t".'filter="rules"';
			$access .= "\n\t\t\t".'validate="rules"';
			$access .= "\n\t\t\t".'class="inputbox"';
			$access .= "\n\t\t\t".'component="com_'.$component.'"';
			$access .= "\n\t\t\t".'section="'.$view.'"';
			$access .= "\n\t\t".'/>';
			$access .= "\n\t".'</fieldset>';
		}
		// return access field set
		return $access;
	}

	protected function setFilterFields($view)
	{
		// keep track of all fields already added
		$donelist = array('id','search','published','access','created_by','modified_by');
		// default filter fields
		$fields = "'a.id','id'";
		$fields .= ",\n\t\t\t\t'a.published','published'";
		if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
		{
			$fields .= ",\n\t\t\t\t'a.access','access'";
		}
		$fields .= ",\n\t\t\t\t'a.ordering','ordering'";
		$fields .= ",\n\t\t\t\t'a.created_by','created_by'";
		$fields .= ",\n\t\t\t\t'a.modified_by','modified_by'";

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] == 'category')
					{
						$fields .= ",\n\t\t\t\t'c.title','category_title'";
						$fields .= ",\n\t\t\t\t'c.id', 'category_id'";
						if ($filter['code'] != 'category')
						{
							$fields .= ",\n\t\t\t\t'a.".$filter['code']."', '".$filter['code']."'";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$fields .= ",\n\t\t\t\t'".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'";
						}*/
						$fields .= ",\n\t\t\t\t'a.".$filter['code']."','".$filter['code']."'";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		// add the rest of the set filters
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] == 'category')
					{
						$fields .= ",\n\t\t\t\t'c.title','category_title'";
						$fields .= ",\n\t\t\t\t'c.id', 'category_id'";
						if ($filter['code'] != 'category')
						{
							$fields .= ",\n\t\t\t\t'a.".$filter['code']."', '".$filter['code']."'";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$fields .= ",\n\t\t\t\t'".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'";
						}*/
						$fields .= ",\n\t\t\t\t'a.".$filter['code']."','".$filter['code']."'";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		return $fields;
	}

	protected function setStoredId($view)
	{
		// keep track of all fields already added
		$donelist = array('id','search','published','access','created_by','modified_by');
		// set the defaults first
		$stored = "//".$this->setLine(__LINE__)." Compile the store id.";
		$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.id');";
		$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.search');";
		$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.published');";
		if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
		{
			$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.access');";
		}
		$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.ordering');";
		$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.created_by');";
		$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.modified_by');";
		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] == 'category')
					{
						$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.category');";
						$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.category_id');";
						if ($filter['code'] != 'category')
						{
							$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."_".$filter['custom']['text']."');";
						}*/
						$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		// add the rest of the set filters
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] == 'category')
					{
						$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.category');";
						$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.category_id');";
						if ($filter['code'] != 'category')
						{
							$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."_".$filter['custom']['text']."');";
						}*/
						$stored .= "\n\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		return $stored;
	}

	protected function setAddToolBar($view)
	{
		// set view name
		$viewName = ComponentbuilderHelper::safeString($view['settings']->name_single);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName]))
		{
			$core = $this->permissionCore[$viewName];
			$coreLoad = true;
		}
		// check type
		if ($view['settings']->type == 2)
		{
			// set lang strings
			$viewNameLang_readonly	= $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_single.' readonly','U');
			// load to lang
			$this->langContent[$this->lang][$viewNameLang_readonly] = $view['settings']->name_single.' :: Readonly';

			// build toolbar
			$toolBar = "JFactory::getApplication()->input->set('hidemainmenu', true);";
			$toolBar .= "\n\t\tJToolBarHelper::title(JText::_('".$viewNameLang_readonly."'), '".$viewName."');";
			$toolBar .= "\n\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CLOSE');";
		}
		else
		{
			// set lang strings
			$viewNameLang_new	= $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_single.' New','U');
			$viewNameLang_edit	= $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_single.' Edit','U');
			// load to lang
			$this->langContent[$this->lang][$viewNameLang_new] = 'A New '.$view['settings']->name_single;
			$this->langContent[$this->lang][$viewNameLang_edit] = 'Editing the '.$view['settings']->name_single;
			// build toolbar
			$toolBar = "JFactory::getApplication()->input->set('hidemainmenu', true);";
			$toolBar .= "\n\t\t\$user = JFactory::getUser();";
			$toolBar .= "\n\t\t\$userId	= \$user->id;";
			$toolBar .= "\n\t\t\$isNew = \$this->item->id == 0;";
			$toolBar .= "\n\n\t\tJToolbarHelper::title( JText::_(\$isNew ? '".$viewNameLang_new."' : '".$viewNameLang_edit."'), 'pencil-2 article-add');";
			$toolBar .= "\n\t\t//".$this->setLine(__LINE__)." Built the actions for new and existing records.";
			$toolBar .= "\n\t\tif (\$this->refid || \$this->ref)";
			$toolBar .= "\n\t\t{";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= "\n\t\t\tif (\$this->canDo->get('".$core['core.create']."') && \$isNew)";
			}
			else
			{
				$toolBar .= "\n\t\t\tif (\$this->canDo->get('core.create') && \$isNew)";
			}
			$toolBar .= "\n\t\t\t{";
			$toolBar .= "\n\t\t\t\t//".$this->setLine(__LINE__)." We can create the record.";
			$toolBar .= "\n\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= "\n\t\t\t}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$toolBar .= "\n\t\t\telseif (\$this->canDo->get('".$core['core.edit']."'))";
			}
			else
			{
				$toolBar .= "\n\t\t\telseif (\$this->canDo->get('core.edit'))";
			}
			$toolBar .= "\n\t\t\t{";
			$toolBar .= "\n\t\t\t\t//".$this->setLine(__LINE__)." We can save the record.";
			$toolBar .= "\n\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= "\n\t\t\t}";
			$toolBar .= "\n\t\t\tif (\$isNew)";
			$toolBar .= "\n\t\t\t{";
			$toolBar .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Do not creat but cancel.";
			$toolBar .= "\n\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= "\n\t\t\t}";
			$toolBar .= "\n\t\t\telse";
			$toolBar .= "\n\t\t\t{";
			$toolBar .= "\n\t\t\t\t//".$this->setLine(__LINE__)." We can close it.";
			$toolBar .= "\n\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= "\n\t\t\t}";
			$toolBar .= "\n\t\t}";
			$toolBar .= "\n\t\telse";
			$toolBar .= "\n\t\t{";
			$toolBar .= "\n\t\t\tif (\$isNew)";
			$toolBar .= "\n\t\t\t{";
			$toolBar .= "\n\t\t\t\t//".$this->setLine(__LINE__)." For new records, check the create permission.";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= "\n\t\t\t\tif (\$this->canDo->get('".$core['core.create']."'))";
			}
			else
			{
				$toolBar .= "\n\t\t\t\tif (\$this->canDo->get('core.create'))";
			}
			$toolBar .= "\n\t\t\t\t{";
			$toolBar .= "\n\t\t\t\t\tJToolBarHelper::apply('".$viewName.".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= "\n\t\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= "\n\t\t\t\t\tJToolBarHelper::custom('".$viewName.".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= "\n\t\t\t\t};";
			$toolBar .= "\n\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= "\n\t\t\t}";
			$toolBar .= "\n\t\t\telse";
			$toolBar .= "\n\t\t\t{";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$toolBar .= "\n\t\t\t\tif (\$this->canDo->get('".$core['core.edit']."'))";
			}
			else
			{
				$toolBar .= "\n\t\t\t\tif (\$this->canDo->get('core.edit'))";
			}
			$toolBar .= "\n\t\t\t\t{";
			$toolBar .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." We can save the new record";
			$toolBar .= "\n\t\t\t\t\tJToolBarHelper::apply('".$viewName.".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= "\n\t\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." We can save this record, but check the create permission to see";
			$toolBar .= "\n\t\t\t\t\t//".$this->setLine(__LINE__)." if we can return to make a new one.";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= "\n\t\t\t\t\tif (\$this->canDo->get('".$core['core.create']."'))";
			}
			else
			{
				$toolBar .= "\n\t\t\t\t\tif (\$this->canDo->get('core.create'))";
			}
			$toolBar .= "\n\t\t\t\t\t{";
			$toolBar .= "\n\t\t\t\t\t\tJToolBarHelper::custom('".$viewName.".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= "\n\t\t\t\t\t}";
			$toolBar .= "\n\t\t\t\t}";
			if ($coreLoad && isset($this->historyBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->historyBuilder[$viewName]))
			{
				$toolBar .= "\n\t\t\t\t\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('".$core['core.version']."'));";
				$toolBar .= "\n\t\t\t\tif (\$this->state->params->get('save_history', 1) && \$this->canDo->get('".$core['core.edit']."') && \$canVersion)";
				$toolBar .= "\n\t\t\t\t{";
				$toolBar .= "\n\t\t\t\t\tJToolbarHelper::versions('com_".$this->fileContentStatic['###component###'].".".$viewName."', \$this->item->id);";
				$toolBar .= "\n\t\t\t\t}";
			}
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= "\n\t\t\t\tif (\$this->canDo->get('".$core['core.create']."'))";
			}
			else
			{
				$toolBar .= "\n\t\t\t\tif (\$this->canDo->get('core.create'))";
			}
			$toolBar .= "\n\t\t\t\t{";
			$toolBar .= "\n\t\t\t\t\tJToolBarHelper::custom('".$viewName.".save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);";
			$toolBar .= "\n\t\t\t\t}";
			$toolBar .= "\n\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= "\n\t\t\t}";
			$toolBar .= "\n\t\t}";
			$toolBar .= "\n\t\tJToolbarHelper::divider();";
			$toolBar .= "\n\t\t//".$this->setLine(__LINE__)." set help url for this view if found";
			$toolBar .= "\n\t\t\$help_url = ".$this->fileContentStatic['###Component###']."Helper::getHelpUrl('".$viewName."');";
			$toolBar .= "\n\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkString(\$help_url))";
			$toolBar .= "\n\t\t{";
			$toolBar .= "\n\t\t\tJToolbarHelper::help('".$this->langPrefix."_HELP_MANAGER', false, \$help_url);";
			$toolBar .= "\n\t\t}";
		}
		return $toolBar;
	}

	protected function setPopulateState($view)
	{
		// rest buket
		$state = '';
		// keep track of all fields already added
		$donelist = array();

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] == 'category')
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = "\n\n\t\t";
						}
						$state .= $spacer."\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
						$state .= "\n\t\t\$this->setState('filter.category', \$category);";
						$state .= "\n\n\t\t\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
						$state .= "\n\t\t\$this->setState('filter.category_id', \$categoryId);";
						if ($filter['code'] != 'category')
						{
							$state .= "\n\n\t\t\$".$filter['code']." = \$app->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
							$state .= "\n\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
						}
					}
					else
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = "\n\n\t\t";
						}
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$state .= $spacer."\$".$filter['code']."_".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."_".$filter['custom']['text']."', 'filter_".$filter['code']."_".$filter['custom']['text']."');";
							$state .= "\n\t\t\$this->setState('filter.".$filter['code']."_".$filter['custom']['text']."', \$".$filter['code']."_".$filter['custom']['text'].");";
							$spacer = "\n\n\t\t";
						}*/
						$state .= $spacer."\$".$filter['code']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
						$state .= "\n\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		// add the rest of the set filters
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] == 'category')
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = "\n\n\t\t";
						}
						$state .= $spacer."\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
						$state .= "\n\t\t\$this->setState('filter.category', \$category);";
						$state .= "\n\n\t\t\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
						$state .= "\n\t\t\$this->setState('filter.category_id', \$categoryId);";
						if ($filter['code'] != 'category')
						{
							$state .= "\n\n\t\t\$".$filter['code']." = \$app->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
							$state .= "\n\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
						}
					}
					else
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = "\n\n\t\t";
						}
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$state .= $spacer."\$".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['custom']['text']."', 'filter_".$filter['custom']['text']."');";
							$state .= "\n\t\t\$this->setState('filter.".$filter['custom']['text']."', \$".$filter['custom']['text'].");";
							$state .= "\n\t\t\$".$filter['code']."_".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."_".$filter['custom']['text']."', 'filter_".$filter['code']."_".$filter['custom']['text']."');";
							$state .= "\n\t\t\$this->setState('filter.".$filter['code']."_".$filter['custom']['text']."', \$".$filter['code']."_".$filter['custom']['text'].");";
							$spacer = "\n\n\t\t";
						}*/
						$state .= $spacer."\$".$filter['code']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
						$state .= "\n\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		return $state;
	}

	protected function setSortFields($view)
	{
		// set the default first
		$fields = "return array(";
		$fields .= "\n\t\t\t'a.sorting' => JText::_('JGRID_HEADING_ORDERING')";
		$fields .= ",\n\t\t\t'a.published' => JText::_('JSTATUS')";

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if ($filter['type'] == 'category')
				{
					$fields .= ",\n\t\t\t'c.category_title' => JText::_('".$filter['lang']."')";
				}
				elseif (ComponentbuilderHelper::checkArray($filter['custom']))
				{
					$fields .= ",\n\t\t\t'".$filter['custom']['db'].".".$filter['custom']['text']."' => JText::_('".$filter['lang']."')";
				}
				else
				{
					$fields .= ",\n\t\t\t'a.".$filter['code']."' => JText::_('".$filter['lang']."')";
				}
			}
		}
		$fields .= ",\n\t\t\t'a.id' => JText::_('JGRID_HEADING_ID')";
		$fields .= "\n\t\t);";
		// return fields
		return $fields;
	}

	protected function setCheckinCall()
	{
		$call = "\n\t\t//".$this->setLine(__LINE__)." check in items";
		$call .= "\n\t\t\$this->checkInNow();\n";

		return $call;
	}

	protected function setAutoCheckin($view,$component)
	{
		$checkin = "\n\n\t/**";
		$checkin .= "\n\t* Build an SQL query to checkin all items left checked out longer then a set time.";
		$checkin .= "\n\t*";
		$checkin .= "\n\t* @return  a bool";
		$checkin .= "\n\t*";
		$checkin .= "\n\t*/";
		$checkin .= "\n\tprotected function checkInNow()";
		$checkin .= "\n\t{";
		$checkin .= "\n\t\t//".$this->setLine(__LINE__)." Get set check in time";
		$checkin .= "\n\t\t\$time = JComponentHelper::getParams('com_".$component."')->get('check_in');";
		$checkin .= "\n\t\t";
		$checkin .= "\n\t\tif (\$time)";
		$checkin .= "\n\t\t{";
		$checkin .= "\n\n\t\t\t//".$this->setLine(__LINE__)." Get a db connection.";
		$checkin .= "\n\t\t\t\$db = JFactory::getDbo();";
		$checkin .= "\n\t\t\t//".$this->setLine(__LINE__)." reset query";
		$checkin .= "\n\t\t\t\$query = \$db->getQuery(true);";
		$checkin .= "\n\t\t\t\$query->select('*');";
		$checkin .= "\n\t\t\t\$query->from(\$db->quoteName('#__".$component."_".$view."'));";
		$checkin .= "\n\t\t\t\$db->setQuery(\$query);";
		$checkin .= "\n\t\t\t\$db->execute();";
		$checkin .= "\n\t\t\tif (\$db->getNumRows())";
		$checkin .= "\n\t\t\t{";
		$checkin .= "\n\t\t\t\t//".$this->setLine(__LINE__)." Get Yesterdays date";
		$checkin .= "\n\t\t\t\t\$date = JFactory::getDate()->modify(\$time)->toSql();";
		$checkin .= "\n\t\t\t\t//".$this->setLine(__LINE__)." reset query";
		$checkin .= "\n\t\t\t\t\$query = \$db->getQuery(true);";
		$checkin .= "\n\n\t\t\t\t//".$this->setLine(__LINE__)." Fields to update.";
		$checkin .= "\n\t\t\t\t\$fields = array(";
		$checkin .= "\n\t\t\t\t\t\$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',";
		$checkin .= "\n\t\t\t\t\t\$db->quoteName('checked_out') . '=0'";
		$checkin .= "\n\t\t\t\t);";
		$checkin .= "\n\n\t\t\t\t//".$this->setLine(__LINE__)." Conditions for which records should be updated.";
		$checkin .= "\n\t\t\t\t\$conditions = array(";
		$checkin .= "\n\t\t\t\t\t\$db->quoteName('checked_out') . '!=0', ";
		$checkin .= "\n\t\t\t\t\t\$db->quoteName('checked_out_time') . '<\''.\$date.'\''";
		$checkin .= "\n\t\t\t\t);";
		$checkin .= "\n\n\t\t\t\t//".$this->setLine(__LINE__)." Check table";
		$checkin .= "\n\t\t\t\t\$query->update(\$db->quoteName('#__".$component."_".$view."'))->set(\$fields)->where(\$conditions); ";
		$checkin .= "\n\n\t\t\t\t\$db->setQuery(\$query);";
		$checkin .= "\n\n\t\t\t\t\$db->execute();";
		$checkin .= "\n\t\t\t}";
		$checkin .= "\n\t\t}";
		$checkin .= "\n\n\t\treturn false;";
		$checkin .= "\n\t}";

		return $checkin;
	}

	protected function setGetItemsMethodStringFix($view,$Component,$tab = '',$export = false)
	{
		// add the fix if this view has the need for it
		$fix = '';
		// encription switches
		$basicCrypt = false;
		$advancedCrypt = false;
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$view]))
		{
			$core = $this->permissionCore[$view];
			$coreLoad = true;
		}
		$component = ComponentbuilderHelper::safeString($Component);
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder[$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.access']]) && in_array($view,$this->permissionBuilder[$core['core.access']]))
		{
			$fix .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." set values to display correctly.";
			$fix .= "\n\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
			$fix .= "\n\t".$tab."\t{";
			$fix .= "\n\t".$tab."\t\t//".$this->setLine(__LINE__)." get user object.";
			$fix .= "\n\t".$tab."\t\t\$user = JFactory::getUser();";
			$fix .= "\n\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
			$fix .= "\n\t".$tab."\t\t{";
			$fix .= "\n\t".$tab."\t\t\t\$access = (\$user->authorise('".$core['core.access']."', 'com_".$component.".".$view.".' . (int) \$item->id) && \$user->authorise('".$core['core.access']."', 'com_".$component."'));";
			$fix .= "\n\t".$tab."\t\t\tif (!\$access)";
			$fix .= "\n\t".$tab."\t\t\t{";
			$fix .= "\n\t".$tab."\t\t\t\tunset(\$items[\$nr]);";
			$fix .= "\n\t".$tab."\t\t\t\tcontinue;";
			$fix .= "\n\t".$tab."\t\t\t}\n";

		}
		
		if (!$export)
		{
			$methodName = 'getItemsMethodListStringFixBuilder';
		}
		else
		{
			$methodName = 'getItemsMethodEximportStringFixBuilder';
		}
		
		if (isset($this->{$methodName}[$view]) && ComponentbuilderHelper::checkArray($this->{$methodName}[$view]))
		{
			if (!ComponentbuilderHelper::checkString($fix))
			{
				$fix .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." set values to display correctly.";
				$fix .= "\n\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
				$fix .= "\n\t".$tab."\t{";
				$fix .= "\n\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
				$fix .= "\n\t".$tab."\t\t{";
			}
			
			foreach ($this->{$methodName}[$view] as $item)
			{
				switch ($item['method'])
				{
					case 1:
					// JSON_STRING_ENCODE
					$decode = 'json_decode';
					$suffix_decode = ', true';
					break;
					case 2:
					// BASE_SIXTY_FOUR
					$decode = 'base64_decode';
					$suffix_decode = '';
					break;
					case 3:
					// BASIC_ENCRYPTION_LOCALKEY
					$decode = '$basic->decryptString';
					$basicCrypt = true;
					$suffix_decode = '';
					break;
					case 4:
					// ADVANCE_ENCRYPTION_VDMKEY
					$decode = '$advanced->decryptString';
					$advancedCrypt = true;
					$suffix_decode = '';
					break;
					default:
					// JSON_ARRAY_ENCODE
					$decode = 'json_decode';
					$suffix_decode = ', true';
					break;
				}
				
				if ($item['type'] == 'usergroup' && !$export)
				{
					$fix .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." decode ".$item['name'];
					$fix .= "\n\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= "\n\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
					$fix .= "\n\t".$tab."\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\$".$item['name']."Names = '';";
					$fix .= "\n\t".$tab."\t\t\t\t\$counter = 0;";
					$fix .= "\n\t".$tab."\t\t\t\tforeach (\$".$item['name']."Array as \$".$item['name'].")";
					$fix .= "\n\t".$tab."\t\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\tif (\$counter == 0)";
					$fix .= "\n\t".$tab."\t\t\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= ".$Component."Helper::getGroupName(\$".$item['name'].");";
					$fix .= "\n\t".$tab."\t\t\t\t\t}";
					$fix .= "\n\t".$tab."\t\t\t\t\telse";
					$fix .= "\n\t".$tab."\t\t\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= ', '.".$Component."Helper::getGroupName(\$".$item['name'].");";
					$fix .= "\n\t".$tab."\t\t\t\t\t}";
					$fix .= "\n\t".$tab."\t\t\t\t\t\$counter++;";
					$fix .= "\n\t".$tab."\t\t\t\t}";
					$fix .= "\n\t".$tab."\t\t\t\t\$item->".$item['name']." = \$".$item['name']."Names;";
					$fix .= "\n\t".$tab."\t\t\t}";
				}
				/*elseif ($item['type'] == 'usergroup' && $export)
				{
					$fix .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." decode ".$item['name'];
					$fix .= "\n\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= "\n\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
					$fix .= "\n\t".$tab."\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\$item->".$item['name']." = implode('|',\$".$item['name']."Array);";
					$fix .= "\n\t".$tab."\t\t\t}";
				}*/
				elseif ($item['translation'] && !$export)
				{
					$fix .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." convert ".$item['name'];
					$fix .= "\n\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= "\n\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
					$fix .= "\n\t".$tab."\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\$".$item['name']."Names = '';";
					$fix .= "\n\t".$tab."\t\t\t\t\$counter = 0;";
					$fix .= "\n\t".$tab."\t\t\t\tforeach (\$".$item['name']."Array as \$".$item['name'].")";
					$fix .= "\n\t".$tab."\t\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\tif (\$counter == 0)";
					$fix .= "\n\t".$tab."\t\t\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= JText::_(\$this->selectionTranslation(\$".$item['name'].", '".$item['name']."'));";
					$fix .= "\n\t".$tab."\t\t\t\t\t}";
					$fix .= "\n\t".$tab."\t\t\t\t\telse";
					$fix .= "\n\t".$tab."\t\t\t\t\t{";
					$fix .= "\n\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= ', '.JText::_(\$this->selectionTranslation(\$".$item['name'].", '".$item['name']."'));";
					$fix .= "\n\t".$tab."\t\t\t\t\t}";
					$fix .= "\n\t".$tab."\t\t\t\t\t\$counter++;";
					$fix .= "\n\t".$tab."\t\t\t\t}";
					$fix .= "\n\t".$tab."\t\t\t\t\$item->".$item['name']." = \$".$item['name']."Names;";
					$fix .= "\n\t".$tab."\t\t\t}";
				}
				else
				{
					if ($item['method'] == 2 || $item['method'] == 3 || $item['method'] == 4)
					{
						$taber = '';
						if ($item['method'] == 3)
						{
							$taber = "\t";
							$fix .= "\n\t".$tab."\t\t\tif (\$basickey && !is_numeric(\$item->".$item['name'].") && \$item->".$item['name']." === base64_encode(base64_decode(\$item->".$item['name'].", true)))";
							$fix .= "\n\t".$tab."\t\t\t{";
						}
						if ($item['method'] == 4)
						{
							$taber = "\t";
							$fix .= "\n\t".$tab."\t\t\tif (\$advancedkey && !is_numeric(\$item->".$item['name'].") && \$item->".$item['name']." === base64_encode(base64_decode(\$item->".$item['name'].", true)))";
							$fix .= "\n\t".$tab."\t\t\t{";
						}
						if ($item['method'] == 3 || $item['method'] == 4)
						{
							$fix .= "\n\t".$tab."\t\t\t\t//".$this->setLine(__LINE__)." decrypt ".$item['name'];
						}
						else
						{
							$fix .= "\n\t".$tab.$taber."\t\t\t//".$this->setLine(__LINE__)." decode ".$item['name'];
						}
						$fix .= "\n\t".$tab.$taber."\t\t\t\$item->".$item['name']." = ".$decode."(\$item->".$item['name'].");";

						if ($item['method'] == 3 || $item['method'] == 4)
						{
							$fix .= "\n\t".$tab."\t\t\t}";
						}
					}
					else
					{
						if ($export && $item['type'] == 'repeatable')
						{
							$fix .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." decode repeatable ".$item['name'];
							$fix .= "\n\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
							$fix .= "\n\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
							$fix .= "\n\t".$tab."\t\t\t{";
							$fix .= "\n\t".$tab."\t\t\t\t\$bucket".$item['name']." = array();";
							$fix .= "\n\t".$tab."\t\t\t\tforeach (\$".$item['name']."Array as \$".$item['name']."FieldName => \$".$item['name'].")";
							$fix .= "\n\t".$tab."\t\t\t\t{";
							$fix .= "\n\t".$tab."\t\t\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."))";
							$fix .= "\n\t".$tab."\t\t\t\t\t{";
							$fix .= "\n\t".$tab."\t\t\t\t\t\t\$bucket".$item['name']."[] = \$".$item['name']."FieldName . '<||VDM||>' . implode('<|VDM|>',\$".$item['name'].");";
							$fix .= "\n\t".$tab."\t\t\t\t\t}";
							$fix .= "\n\t".$tab."\t\t\t\t}";
							$fix .= "\n\t".$tab."\t\t\t\t//".$this->setLine(__LINE__)." make sure the bucket has values.";
							$fix .= "\n\t".$tab."\t\t\t\tif (".$Component."Helper::checkArray(\$bucket".$item['name']."))";
							$fix .= "\n\t".$tab."\t\t\t\t{";
							$fix .= "\n\t".$tab."\t\t\t\t\t//".$this->setLine(__LINE__)." clear the repeatable field.";
							$fix .= "\n\t".$tab."\t\t\t\t\tunset(\$item->".$item['name'].");";
							$fix .= "\n\t".$tab."\t\t\t\t\t//".$this->setLine(__LINE__)." set repeatable field for export.";
							$fix .= "\n\t".$tab."\t\t\t\t\t\$item->".$item['name']." = implode('<|||VDM|||>',\$bucket".$item['name'].");";
							$fix .= "\n\t".$tab."\t\t\t\t\t//".$this->setLine(__LINE__)." unset the bucket.";
							$fix .= "\n\t".$tab."\t\t\t\t\tunset(\$bucket".$item['name'].");";
							$fix .= "\n\t".$tab."\t\t\t\t}";
							$fix .= "\n\t".$tab."\t\t\t}";
						}
						else
						{
							if (!$export)
							{
								// TODO we must add options for multi custom selection.
								$fix .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." convert ".$item['name'];
								$fix .= "\n\t".$tab."\t\t\t\$item->".$item['name']." = ".$Component."Helper::jsonToString(\$item->".$item['name'].");";
							}
						}
					}
				}
			}
		}

		// close the foreach if needed
		if (!ComponentbuilderHelper::checkString($fix) && $export)
		{
			$fix .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." set values to display correctly.";
			$fix .= "\n\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
			$fix .= "\n\t".$tab."\t{";
			$fix .= "\n\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
			$fix .= "\n\t".$tab."\t\t{";
		}
		// close the foreach if needed
		if (ComponentbuilderHelper::checkString($fix))
		{
			// remove these values if export
			if ($export)
			{
				$fix .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." unset the values we don't want exported.";
				$fix .= "\n\t".$tab."\t\t\tunset(\$item->asset_id);";
				$fix .= "\n\t".$tab."\t\t\tunset(\$item->checked_out);";
				$fix .= "\n\t".$tab."\t\t\tunset(\$item->checked_out_time);";
			}
			$fix .= "\n\t".$tab."\t\t}";
			$fix .= "\n\t".$tab."\t}";
			if ($export)
			{
				$fix .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Add headers to items array.";
				$fix .= "\n\t".$tab."\t\$headers = \$this->getExImPortHeaders();";
				$fix .= "\n\t".$tab."\tif (".$Component."Helper::checkObject(\$headers))";
				$fix .= "\n\t".$tab."\t{";
				$fix .= "\n\t".$tab."\t\tarray_unshift(\$items,\$headers);";
				$fix .= "\n\t".$tab."\t}";
			}
		}

		// add custom php to getitems method
		if (isset($this->customScriptBuilder['php_getitems'][$view]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_getitems'][$view]))
		{
			$fix .= "\n\n".$tab."".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_getitems'][$view]);
		}

		if ($basicCrypt)
		{
			$script = "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the basic encription key.";
			$script .= "\n\t".$tab."\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
			$script .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the encription object.";
			$script .= "\n\t".$tab."\t\$basic = new FOFEncryptAes(\$basickey, 128);";
			// add the encryption script
			$fix = $script . $fix;
		}

		if ($advancedCrypt)
		{
			$script = "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the advanced encription key.";
			$script .= "\n\t".$tab."\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
			$script .= "\n\t".$tab."\t//".$this->setLine(__LINE__)." Get the encription object.";
			$script .= "\n\t".$tab."\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
			// add the encryption script
			$fix = $script . $fix;
		}

		return $fix;
	}

	protected function setSelectionTranslationFix($views,$Component,$tab = '')
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (isset($this->selectionTranslationFixBuilder[$views]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$views]))
		{
			$fix .= "\n\n\t".$tab."\t//".$this->setLine(__LINE__)." set selection value to a translatable value";
			$fix .= "\n\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
			$fix .= "\n\t".$tab."\t{";
			$fix .= "\n\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
			$fix .= "\n\t".$tab."\t\t{";
			foreach ($this->selectionTranslationFixBuilder[$views] as $name => $values)
			{
				$fix .= "\n\t".$tab."\t\t\t//".$this->setLine(__LINE__)." convert ".$name;
				$fix .= "\n\t".$tab."\t\t\t\$item->".$name." = \$this->selectionTranslation(\$item->".$name.", '".$name."');";
			}
			$fix .= "\n\t".$tab."\t\t}";
			$fix .= "\n\t".$tab."\t}\n";
		}
		return $fix;
	}

	protected function setSelectionTranslationFixFunc($views,$Component)
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (isset( $this->selectionTranslationFixBuilder[$views]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$views]))
		{
			$fix .= "\n\n\t/**";
			$fix .= "\n\t* Method to convert selection values to translatable string.";
			$fix .= "\n\t*";
			$fix .= "\n\t* @return translatable string";
			$fix .= "\n\t*/";
			$fix .= "\n\tpublic function selectionTranslation(\$value,\$name)";
			$fix .= "\n\t{";
			foreach ($this->selectionTranslationFixBuilder[$views] as $name => $values)
			{
				if (ComponentbuilderHelper::checkArray($values))
				{
					$fix .= "\n\t\t//".$this->setLine(__LINE__)." Array of ".$name." language strings";
					$fix .= "\n\t\tif (\$name == '".$name."')";
					$fix .= "\n\t\t{";
					$fix .= "\n\t\t\t\$".$name."Array = array(";
					$counter = 0;
					foreach ($values as $value => $translang)
					{
						// only add quotes to strings
						if (ComponentbuilderHelper::checkString($value))
						{
							$key = "'".$value."'";
						}
						else
						{
							if ($value == '')
							{
								$value = 0;
							}
							$key = $value;
						}
						if ($counter == 0)
						{
							$fix .=  "\n\t\t\t\t".$key." => '".$translang."'";
						}
						else
						{
							$fix .= ",\n\t\t\t\t".$key." => '".$translang."'";
						}
						$counter++;
					}
					$fix .= "\n\t\t\t);";
					$fix .= "\n\t\t\t//".$this->setLine(__LINE__)." Now check if value is found in this array";
					$fix .= "\n\t\t\tif (isset(\$".$name."Array[\$value]) && ".$Component."Helper::checkString(\$".$name."Array[\$value]))";
					$fix .= "\n\t\t\t{";
					$fix .= "\n\t\t\t\treturn \$".$name."Array[\$value];";
					$fix .= "\n\t\t\t}";
					$fix .= "\n\t\t}";
				}
			}
			$fix .= "\n\t\treturn \$value;";
			$fix .= "\n\t}";
		}
		return $fix;
	}

	protected function setFieldSet($view,$component)
	{
		// setup the fieldset of this view
		if (isset($view['settings']->fields) && ComponentbuilderHelper::checkArray($view['settings']->fields))
		{
			// setup the list view and single view name
			$listViewName	= ComponentbuilderHelper::safeString($view['settings']->name_list);
			$viewName	= ComponentbuilderHelper::safeString($view['settings']->name_single);
			// add metadata to the view
			if ($view['metadata'])
			{
				$this->metadataBuilder[$viewName] = $viewName;
			}
			// add access to the view
			if ($view['access'])
			{
				$this->accessBuilder[$viewName] = $viewName;
			}
			// set the read only
			$readOnly = "";
			if ($view['settings']->type == 2)
			{
				$readOnly = "\n\t\t\t".'readonly="true"'."\n\t\t\t".'disabled="true"';
			}
			// main lang prefix
			$langView = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_single,'U');
			$langViews = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_list,'U');
			// set default lang
			$this->langContent[$this->lang][$langView]							= $view['settings']->name_single;
			$this->langContent[$this->lang][$langViews]							= $view['settings']->name_list;
			// set the singel name
			$viewSingleName = ComponentbuilderHelper::safeString($view['settings']->name_single,'W');
			// set global item strings
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_ARCHIVED']				= "%s ".$view['settings']->name_list." archived.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_ARCHIVED_1']			= "%s ".$view['settings']->name_single." archived.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_CHECKED_IN_0']			= "No ".$view['settings']->name_single." successfully checked in.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_CHECKED_IN_1']			= "%d ".$view['settings']->name_single." successfully checked in.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_CHECKED_IN_MORE']		= "%d ".$view['settings']->name_list." successfully checked in.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_DELETED']				= "%s ".$view['settings']->name_list." deleted.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_DELETED_1']			= "%s ".$view['settings']->name_single." deleted.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_FEATURED']				= "%s ".$view['settings']->name_list." featured.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_FEATURED_1']			= "%s ".$view['settings']->name_single." featured.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_PUBLISHED']			= "%s ".$view['settings']->name_list." published.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_PUBLISHED_1']			= "%s ".$view['settings']->name_single." published.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_TRASHED']				= "%s ".$view['settings']->name_list." trashed.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_TRASHED_1']			= "%s ".$view['settings']->name_single." trashed.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_UNFEATURED']			= "%s ".$view['settings']->name_list." unfeatured.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_UNFEATURED_1']			= "%s ".$view['settings']->name_single." unfeatured.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_UNPUBLISHED']			= "%s ".$view['settings']->name_list." unpublished.";
			$this->langContent[$this->lang][$langViews.'_N_ITEMS_UNPUBLISHED_1']		= "%s ".$view['settings']->name_single." unpublished.";
			$this->langContent[$this->lang][$langViews.'_BATCH_OPTIONS']				= "Batch process the selected ".$view['settings']->name_list;
			$this->langContent[$this->lang][$langViews.'_BATCH_TIP']					= "All changes will be applied to all selected ".$view['settings']->name_list;
			// set some basic defaults
			$this->langContent[$this->lang][$langView.'_ERROR_UNIQUE_ALIAS']		= "Another ".$view['settings']->name_single." has the same alias.";
			$this->langContent[$this->lang][$langView.'_CREATED_DATE_LABEL']		= "Created date";
			$this->langContent[$this->lang][$langView.'_CREATED_DATE_DESC']			= "The date ".$view['settings']->name_single." was created.";
			$this->langContent[$this->lang][$langView.'_CREATED_BY_LABEL']			= "Created by";
			$this->langContent[$this->lang][$langView.'_CREATED_BY_DESC']			= "The user that created the ".$view['settings']->name_single.".";
			$this->langContent[$this->lang][$langView.'_ORDERING_LABEL']			= "Ordering";
			$this->langContent[$this->lang][$langView.'_VERSION_LABEL']				= "Revision";
			$this->langContent[$this->lang][$langView.'_VERSION_DESC']				= "A count of the number of times this ".$view['settings']->name_single." has been revised.";
			$this->langContent[$this->lang][$langView.'_SAVE_WARNING']				= "Alias already existed so a number was added at the end. You can re-edit the ".$view['settings']->name_single." to customise the alias.";
			// set the defautl fields
			$fieldSet = '<fieldset name="details">';
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Default Fields. -->";
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Id Field. Type: Text (joomla) -->";
			$fieldSet .= "\n\t\t<field";
			$fieldSet .= "\n\t\t\tname=".'"id"';
			$fieldSet .= "\n\t\t\t".'type="text" class="readonly" label="JGLOBAL_FIELD_ID_LABEL"';
			$fieldSet .= "\n\t\t\t".'description ="JGLOBAL_FIELD_ID_DESC" size="10" default="0"';
			$fieldSet .= "\n\t\t\t".'readonly="true"';
			$fieldSet .= "\n\t\t/>";
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Date Created Field. Type: Calendar (joomla) -->";
			$fieldSet .= "\n\t\t<field";
			$fieldSet .= "\n\t\t\tname=".'"created"';
			$fieldSet .= "\n\t\t\ttype=".'"calendar"';
			$fieldSet .= "\n\t\t\tlabel=".'"'.$langView.'_CREATED_DATE_LABEL"';
			$fieldSet .= "\n\t\t\tdescription=".'"'.$langView.'_CREATED_DATE_DESC"';
			$fieldSet .= "\n\t\t\tsize=".'"22"';
			$fieldSet .= $readOnly;
			$fieldSet .= "\n\t\t\tformat=".'"%Y-%m-%d %H:%M:%S"';
			$fieldSet .= "\n\t\t\tfilter=".'"user_utc"';
			$fieldSet .= "\n\t\t/>";
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." User Created Field. Type: User (joomla) -->";
			$fieldSet .= "\n\t\t<field";
			$fieldSet .= "\n\t\t\tname=".'"created_by"';
			$fieldSet .= "\n\t\t\ttype=".'"user"';
			$fieldSet .= "\n\t\t\tlabel=".'"'.$langView.'_CREATED_BY_LABEL"';
			$fieldSet .= $readOnly;
			$fieldSet .= "\n\t\t\tdescription=".'"'.$langView.'_CREATED_BY_DESC"';
			$fieldSet .= "\n\t\t/>";
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Published Field. Type: List (joomla) -->";
			$fieldSet .= "\n\t\t<field name=".'"published" type="list" label="JSTATUS"';
			$fieldSet .= "\n\t\t\tdescription=".'"JFIELD_PUBLISHED_DESC" class="chzn-color-state"';
			$fieldSet .= $readOnly;
			$fieldSet .= "\n\t\t\tfilter=".'"intval" size="1" default="1" >';

			$fieldSet .= "\n\t\t\t<option value=".'"1">';
			$fieldSet .= "\n\t\t\t\tJPUBLISHED</option>";
			$fieldSet .= "\n\t\t\t<option value=".'"0">';
			$fieldSet .= "\n\t\t\t\tJUNPUBLISHED</option>";
			$fieldSet .= "\n\t\t\t<option value=".'"2">';
			$fieldSet .= "\n\t\t\t\tJARCHIVED</option>";
			$fieldSet .= "\n\t\t\t<option value=".'"-2">';
			$fieldSet .= "\n\t\t\t\tJTRASHED</option>";
			$fieldSet .= "\n\t\t</field>";
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Date Modified Field. Type: Calendar (joomla) -->";
			$fieldSet .= "\n\t\t".'<field name="modified" type="calendar" class="readonly"';
			$fieldSet .= "\n\t\t\t".'label="JGLOBAL_FIELD_MODIFIED_LABEL" description="COM_CONTENT_FIELD_MODIFIED_DESC"';
			$fieldSet .= "\n\t\t\t".'size="22" readonly="true" format="%Y-%m-%d %H:%M:%S" filter="user_utc" />';
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." User Modified Field. Type: User (joomla) -->";
			$fieldSet .= "\n\t\t".'<field name="modified_by" type="user"';
			$fieldSet .= "\n\t\t\t".'label="JGLOBAL_FIELD_MODIFIED_BY_LABEL"';
			$fieldSet .= "\n\t\t\t".'class="readonly"';
			$fieldSet .= "\n\t\t\t".'readonly="true"';
			$fieldSet .= "\n\t\t\t".'filter="unset"';
			$fieldSet .= "\n\t\t/>";
			// check if view has access
			if (isset($this->accessBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName]))
			{
				$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Access Field. Type: Accesslevel (joomla) -->";
				$fieldSet .= "\n\t\t".'<field name="access"';
				$fieldSet .= "\n\t\t\t".'type="accesslevel"';
				$fieldSet .= "\n\t\t\t".'label="JFIELD_ACCESS_LABEL"';
				$fieldSet .= "\n\t\t\t".'description="JFIELD_ACCESS_DESC"';
				$fieldSet .= "\n\t\t\t".'default="1"';
				$fieldSet .= $readOnly;
				$fieldSet .= "\n\t\t\t".'required="false"';
				$fieldSet .= "\n\t\t/>";
			}
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Ordering Field. Type: Numbers (joomla) -->";
			$fieldSet .= "\n\t\t<field";
			$fieldSet .= "\n\t\t\t".'name="ordering"';
			$fieldSet .= "\n\t\t\t".'type="number"';
			$fieldSet .= "\n\t\t\t".'class="inputbox validate-ordering"';
			$fieldSet .= "\n\t\t\t".'label="'.$langView.'_ORDERING_LABEL'.'"';
			$fieldSet .= "\n\t\t\t".'description=""';
			$fieldSet .= "\n\t\t\t".'default="0"';
			$fieldSet .= "\n\t\t\t".'size="6"';
			$fieldSet .= $readOnly;
			$fieldSet .= "\n\t\t\t".'required="false"';
			$fieldSet .= "\n\t\t/>";
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Version Field. Type: Text (joomla) -->";
			$fieldSet .= "\n\t\t<field";
			$fieldSet .= "\n\t\t\t".'name="version"';
			$fieldSet .= "\n\t\t\t".'type="text"';
			$fieldSet .= "\n\t\t\t".'class="readonly"';
			$fieldSet .= "\n\t\t\t".'label="'.$langView.'_VERSION_LABEL"';
			$fieldSet .= "\n\t\t\t".'description="'.$langView.'_VERSION_DESC"';
			$fieldSet .= "\n\t\t\t".'size="6"';
			$fieldSet .= "\n\t\t\t".'readonly="true"';
			$fieldSet .= "\n\t\t\t".'filter="unset"';
			$fieldSet .= "\n\t\t/>";
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName]))
			{
				$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Metakey Field. Type: Textarea (joomla) -->";
				$fieldSet .= "\n\t\t<field";
				$fieldSet .= "\n\t\t\t".'name="metakey"';
				$fieldSet .= "\n\t\t\t".'type="textarea"';
				$fieldSet .= "\n\t\t\t".'label="JFIELD_META_KEYWORDS_LABEL"';
				$fieldSet .= "\n\t\t\t".'description="JFIELD_META_KEYWORDS_DESC"';
				$fieldSet .= "\n\t\t\t".'rows="3"';
				$fieldSet .= "\n\t\t\t".'cols="30"';
				$fieldSet .= "\n\t\t/>";
				$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Metadesc Field. Type: Textarea (joomla) -->";
				$fieldSet .= "\n\t\t<field";
				$fieldSet .= "\n\t\t\t".'name="metadesc"';
				$fieldSet .= "\n\t\t\t".'type="textarea"';
				$fieldSet .= "\n\t\t\t".'label="JFIELD_META_DESCRIPTION_LABEL"';
				$fieldSet .= "\n\t\t\t".'description="JFIELD_META_DESCRIPTION_DESC"';
				$fieldSet .= "\n\t\t\t".'rows="3"';
				$fieldSet .= "\n\t\t\t".'cols="30"';
				$fieldSet .= "\n\t\t/>";
			}
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." Dynamic Fields. -->";
			// start adding dynamc fields
			$placeholders = array(
				'###component###' => $component,
				'###view###' => $viewName,
				'###views###' => $listViewName);
			$spacerCounter = 'a';
			// set the custom table key
			$dbkey = 'g';
			// TODO we should add the global and local view switch if field for front end
			foreach ($view['settings']->fields as $field)
			{
				$fieldSet .= $this->setDynamicField($field,$view,$view['settings']->type,$langView,$viewName,$listViewName,$spacerCounter,$placeholders,$dbkey,true);
			}

			$fieldSet .= "\n\t</fieldset>";
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName]))
			{
				$fieldSet .= "\n\n\t<!--".$this->setLine(__LINE__)." Metadata Fields. -->";
				$fieldSet .= "\n\t<fields".' name="metadata" label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				$fieldSet .= "\n\t\t".'<fieldset name="vdmmetadata"';
				$fieldSet .= "\n\t\t\t".'label="JGLOBAL_FIELDSET_METADATA_OPTIONS">';
				$fieldSet .= "\n\t\t\t<!--".$this->setLine(__LINE__)." Robots Field. Type: List (joomla) -->";
				$fieldSet .= "\n\t\t\t".'<field name="robots"';
				$fieldSet .= "\n\t\t\t\t".'type="list"';
				$fieldSet .= "\n\t\t\t\t".'label="JFIELD_METADATA_ROBOTS_LABEL"';
				$fieldSet .= "\n\t\t\t\t".'description="JFIELD_METADATA_ROBOTS_DESC" >';
				$fieldSet .= "\n\t\t\t\t".'<option value="">JGLOBAL_USE_GLOBAL</option>';
				$fieldSet .= "\n\t\t\t\t".'<option value="index, follow">JGLOBAL_INDEX_FOLLOW</option>';
				$fieldSet .= "\n\t\t\t\t".'<option value="noindex, follow">JGLOBAL_NOINDEX_FOLLOW</option>';
				$fieldSet .= "\n\t\t\t\t".'<option value="index, nofollow">JGLOBAL_INDEX_NOFOLLOW</option>';
				$fieldSet .= "\n\t\t\t\t".'<option value="noindex, nofollow">JGLOBAL_NOINDEX_NOFOLLOW</option>';
				$fieldSet .= "\n\t\t\t".'</field>';
				$fieldSet .= "\n\t\t\t<!--".$this->setLine(__LINE__)." Author Field. Type: Text (joomla) -->";
				$fieldSet .= "\n\t\t\t".'<field name="author"';
				$fieldSet .= "\n\t\t\t\t".'type="text"';
				$fieldSet .= "\n\t\t\t\t".'label="JAUTHOR" description="JFIELD_METADATA_AUTHOR_DESC"';
				$fieldSet .= "\n\t\t\t\t".'size="20"';
				$fieldSet .= "\n\t\t\t/>";
				$fieldSet .= "\n\t\t\t<!--".$this->setLine(__LINE__)." Rights Field. Type: Textarea (joomla) -->";
				$fieldSet .= "\n\t\t\t".'<field name="rights" type="textarea" label="JFIELD_META_RIGHTS_LABEL"';
				$fieldSet .= "\n\t\t\t\t".'description="JFIELD_META_RIGHTS_DESC" required="false" filter="string"';
				$fieldSet .= "\n\t\t\t\t".'cols="30" rows="2"';
				$fieldSet .= "\n\t\t\t/>";
				$fieldSet .= "\n\t\t</fieldset>";
				$fieldSet .= "\n\t</fields>";
			}
			// retunr the set
			return $fieldSet;
		}
		return '';
	}

	protected function setDynamicField(&$field,&$view,&$viewType, &$langView,&$viewName,&$listViewName,&$spacerCounter,&$placeholders,&$dbkey,$build)
	{
		$name		= ComponentbuilderHelper::safeString($field['settings']->name);
		$typeName	= ComponentbuilderHelper::safeString($field['settings']->type_name);
		$multiple	= false;
		$langLabel  = '';
		$taber		= '';
		$fieldSet	= '';
		// get field values
		$fieldValues = $this->setFieldValues($field,$viewType,$name,$typeName,$multiple,$langLabel,$langView,$spacerCounter,$listViewName,$viewName,$placeholders);
		// check if values were set
		if (ComponentbuilderHelper::checkArray($fieldValues))
		{
			if ($this->defaultField($typeName, 'option'))
			{
				//reset options array
				$optionArray = array();
				// now add to the field set
				$fieldSet .= $this->setField('option',$taber,$fieldValues,$name,$typeName,$langView,$viewName,$listViewName,$placeholders,$optionArray);
				if ($build)
				{
					// set builders
					$this->setBuilders($langLabel, $langView,$viewName,$listViewName,$name,$view,$field,$typeName,$multiple,false,$optionArray);
				}
			}
			elseif ($this->defaultField($typeName, 'plain'))
			{
				if ($build)
				{
					// set builders
					$this->setBuilders($langLabel, $langView,$viewName,$listViewName,$name,$view,$field,$typeName,$multiple);
				}
				// now add to the field set
				$fieldSet .= $this->setField('plain',$taber,$fieldValues,$name,$typeName,$langView,$viewName,$listViewName,$placeholders,$optionArray);
			}
			elseif ($this->defaultField($typeName, 'spacer'))
			{
				if ($build)
				{
					// make sure spacers gets loaded to layout
					$tabName = '';
					if (isset($view['settings']->tabs) && isset($view['settings']->tabs[(int) $field['tab']]))
					{
						$tabName = $view['settings']->tabs[(int) $field['tab']];
					}
					$this->setLayoutBuilder($viewName,$tabName,$name,$field);
				}
				// now add to the field set
				$fieldSet .= $this->setField('spacer',$taber,$fieldValues,$name,$typeName,$langView,$viewName,$listViewName,$placeholders,$optionArray);
				// increment spacer counter
				if ($typeName == 'spacer')
				{
					$spacerCounter++;
				}
			}
			elseif($this->defaultField($typeName, 'special'))
			{
				// set the repeatable field
				if ($typeName == 'repeatable')
				{
					if ($build)
					{
						// set builders
						$this->setBuilders($langLabel,$langView,$viewName,$listViewName,$name,$view,$field,$typeName,$multiple,false);
					}
					// now add to the field set
					$fieldSet .= $this->setField('special',$taber,$fieldValues,$name,$typeName,$langView,$viewName,$listViewName,$placeholders,$optionArray);
				}
			}
			elseif (ComponentbuilderHelper::checkArray($fieldValues['custom']))
			{
				// set the custom array
				$custom = $fieldValues['custom'];
				unset($fieldValues['custom']);
				// set db key
				$custom['db'] = $dbkey;
				// increment the db key
				$dbkey++;
				if ($build)
				{
					// set builders
					$this->setBuilders($langLabel,$langView,$viewName,$listViewName,$name,$view,$field,$typeName,$multiple,$custom);
				}
				// now add to the field set
				$fieldSet .= $this->setField('custom',$taber,$fieldValues,$name,$typeName,$langView,$viewName,$listViewName,$placeholders,$optionArray);
			}
		}
		return $fieldSet;
	}

	protected function setField($setType,$taber,&$fieldValues,&$name,&$typeName,&$langView,&$viewName,&$listViewName,$placeholders,&$optionArray)
	{
		$fieldSet = '';
		if ($setType == 'option')
		{
			// now add to the field set
			$fieldSet .= "\n\t".$taber."\t<!--".$this->setLine(__LINE__)." ".ComponentbuilderHelper::safeString($name, 'F')." Field. Type: ".ComponentbuilderHelper::safeString($typeName, 'F').". (joomla) -->";
			$fieldSet .= "\n\t".$taber."\t<field";
			$optionSet	= '';
			foreach ($fieldValues as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= "\n\t\t".$taber."\t".$property.'="'.$value.'"';
				}
				elseif ($property == 'option')
				{
					$optionSet = '';
					if (strpos($value,',') !== false)
					{
						// mulitpal options
						$options = explode(',',$value);
						foreach ($options as $option)
						{
							if (strpos($option,'|') !== false)
							{
								// has other value then text
								list($v,$t) = explode('|',$option);
								$langValue = $langView.'_'.ComponentbuilderHelper::safeString($t,'U');
								// add to lang array
								$this->langContent[$this->lang][$langValue]	= $t;
								// no add to option set
								$optionSet .= "\n\t".$taber."\t\t".'<option value="'.$v.'">'."\n\t".$taber."\t\t\t".$langValue.'</option>';
								$optionArray[$v] = $langValue;
							}
							else
							{
								// text is also the value
								$langValue = $langView.'_'.ComponentbuilderHelper::safeString($option,'U');
								// add to lang array
								$this->langContent[$this->lang][$langValue]	= $option;
								// no add to option set
								$optionSet .= "\n\t\t".$taber."\t".'<option value="'.$option.'">'."\n\t\t".$taber."\t\t".$langValue.'</option>';
								$optionArray[$option] = $langValue;
							}
						}
					}
					else
					{
						// one option
						if (strpos($value,'|') !== false)
						{
							// has other value then text
							list($v,$t) = explode('|',$value);
							$langValue = $langView.'_'.ComponentbuilderHelper::safeString($t,'U');
							// add to lang array
							$this->langContent[$this->lang][$langValue]	= $t;
							// no add to option set
							$optionSet .= "\n\t\t".$taber."\t".'<option value="'.$v.'">'."\n\t\t".$taber."\t\t".$langValue.'</option>';
							$optionArray[$v] = $langValue;
						}
						else
						{
							// text is also the value
							$langValue = $langView.'_'.ComponentbuilderHelper::safeString($value,'U');
							// add to lang array
							$this->langContent[$this->lang][$langValue]	= $value;
							// no add to option set
							$optionSet .= "\n\t\t".$taber."\t".'<option value="'.$value.'">'."\n\t\t".$taber."\t\t".$langValue.'</option>';
							$optionArray[$value] = $langValue;
						}

					}
				}
			}
			if (ComponentbuilderHelper::checkString($optionSet))
			{
				$fieldSet .= '>';
				$fieldSet .= "\n\t\t\t".$taber."<!--".$this->setLine(__LINE__)." Option Set. -->";
				$fieldSet .= $optionSet;
				$fieldSet .= "\n\t\t".$taber."</field>";
			}
			else
			{
				$optionArray = false;
				$fieldSet .= "\n\t\t\t".$taber."<!--".$this->setLine(__LINE__)." No Manual Options Were Added In Field Settings. -->";
				$fieldSet .= "\n\t\t".$taber."/>";
			}
		}
		elseif ($setType == 'plain')
		{
			// now add to the field set
			$fieldSet .= "\n\t\t".$taber."<!--".$this->setLine(__LINE__)." ".ComponentbuilderHelper::safeString($name, 'F')." Field. Type: ".ComponentbuilderHelper::safeString($typeName, 'F').". (joomla) -->";
			$fieldSet .= "\n\t\t".$taber."<field";
			foreach ($fieldValues as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= "\n\t\t".$taber."\t".$property.'="'.$value.'"';
				}
			}
			$fieldSet .= "\n\t\t".$taber."/>";
		}
		elseif ($setType == 'spacer')
		{
			// now add to the field set
			$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." ".ComponentbuilderHelper::safeString($name, 'F')." Field. Type: ".ComponentbuilderHelper::safeString($typeName, 'F').". A None Database Field. (joomla) -->";
			$fieldSet .= "\n\t\t<field";
			foreach ($fieldValues as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= " ".$property.'="'.$value.'"';
				}
			}
			$fieldSet .= " />";
		}
		elseif ($setType == 'special')
		{
			// set the repeatable field
			if ($typeName == 'repeatable')
			{
				// now add to the field set
				$fieldSet .= "\n\t\t<!--".$this->setLine(__LINE__)." ".ComponentbuilderHelper::safeString($name, 'F')." Field. Type: ".ComponentbuilderHelper::safeString($typeName, 'F').". (joomla) -->";
				$fieldSet .= "\n\t\t<field";
				$fieldsSet	= array();
				foreach ($fieldValues as $property => $value)
				{
					if ($property != 'fields')
					{
						$fieldSet .= "\n\t\t\t".$property.'="'.$value.'"';
					}
				}
				$fieldSet .= ">";
				$fieldSet .= "\n\t\t\t".'<fields name="'.$fieldValues['name'].'_fields" label="">';
				$fieldSet .= "\n\t\t\t\t".'<fieldset hidden="true" name="'.$fieldValues['name'].'_modal" repeat="true">';
				if (strpos($fieldValues['fields'],',') !== false)
				{
					// mulitpal fields
					$fieldsSets = explode(',',$fieldValues['fields']);
				}
				else
				{
					// single field
					$fieldsSets[] = $fieldValues['fields'];
				}
				// only continue if we have a field set
				if (ComponentbuilderHelper::checkArray($fieldsSets))
				{
					foreach ($fieldsSets as $fieldId)
					{
						// get the field data
						$fieldData['settings'] = $this->getFieldData($fieldId,$viewName);
						if (ComponentbuilderHelper::checkObject($fieldData['settings']))
						{
							$r_name			= ComponentbuilderHelper::safeString($fieldData['settings']->name);
							$r_typeName		= ComponentbuilderHelper::safeString($fieldData['settings']->type_name);
							$r_multiple		= false;
							$r_langLabel	= '';
							// make sure that these fields are not required
							$fieldData['settings']->xml = str_replace('required="','requirenot="',$fieldData['settings']->xml);
							// add the tabs needed
							$taber 			= "\t\t\t";
							// get field values
							$r_fieldValues = $this->setFieldValues($fieldData,$view,$r_name,$r_typeName,$r_multiple,$r_langLabel,$langView,$spacerCounter,$listViewName,$viewName,$placeholders,true);
							// check if values were set
							if (ComponentbuilderHelper::checkArray($r_fieldValues))
							{
								//reset options array
								$r_optionArray = array();
								if ($this->defaultField($r_typeName, 'option'))
								{
									// now add to the field set
									$fieldSet .= $this->setField('option',$taber,$r_fieldValues,$r_name,$r_typeName,$langView,$viewName,$listViewName,$placeholders,$r_optionArray);
								}
								elseif ($this->defaultField($r_typeName, 'plain'))
								{
									// now add to the field set
									$fieldSet .= $this->setField('plain',$taber,$r_fieldValues,$r_name,$r_typeName,$langView,$viewName,$listViewName,$placeholders,$r_optionArray);
								}
								elseif (ComponentbuilderHelper::checkArray($r_fieldValues['custom']))
								{
									// add to custom
									$custom = $r_fieldValues['custom'];
									unset($r_fieldValues['custom']);
									// now add to the field set
									$fieldSet .= $this->setField('custom',$taber,$r_fieldValues,$r_name,$r_typeName,$langView,$viewName,$listViewName,$placeholders,$r_optionArray);
									// set lang (just incase)
									$r_listLangName = $langView.'_'.ComponentbuilderHelper::safeString($r_name,'U');
									// add to lang array
									$this->langContent[$this->lang][$r_listLangName] = ComponentbuilderHelper::safeString($r_name,'W');
									// if label was set use instead
									if (ComponentbuilderHelper::checkString($r_langLabel))
									{
										$r_listLangName = $r_langLabel;
									}
									// set the custom array
									$data = array( 'type' => $r_typeName, 'code' => $r_name, 'lang' => $r_listLangName, 'custom' => $custom);
									// set the custom field file
									$this->setCustomFieldTypeFile($data,$listViewName,$viewName);
								}
							}
						}
					}
				}
				$fieldSet .= "\n\t\t\t\t</fieldset>";
				$fieldSet .= "\n\t\t\t</fields>";
				$fieldSet .= "\n\t\t</field>";
			}
		}
		elseif ($setType == 'custom')
		{
			// now add to the field set
			$fieldSet .= "\n\t\t".$taber."<!--".$this->setLine(__LINE__)." ".ComponentbuilderHelper::safeString($name, 'F')." Field. Type: ".ComponentbuilderHelper::safeString($typeName, 'F').". (custom) -->";
			$fieldSet .= "\n\t\t".$taber."<field";
			foreach ($fieldValues as $property => $value)
			{
				if ($property != 'option')
				{
					$fieldSet .= "\n\t\t".$taber."\t".$property.'="'.$value.'"';
				}
			}
			$fieldSet .= "\n\t\t".$taber."/>";

		}
		return $fieldSet;
	}

	protected function setFieldValues(&$field,&$viewType,&$name,&$typeName,&$multiple,&$langLabel,$langView,&$spacerCounter,$listViewName,$viewName,$placeholders,$repeatable = false)
	{
		// reset array`
		$fieldValues	= array();
		$setCustom	= false;
		// setup joomla default fields
		if (!$this->defaultField($typeName))
		{
			$fieldValues['custom']	= array();
			$setCustom		= true;
		}
		// setup a default field
		if (ComponentbuilderHelper::checkArray($field['settings']->properties))
		{
			foreach ($field['settings']->properties as $property)
			{
				// reset
				$xmlValue	= '';
				$langValue	= '';
				if ($property['name'] == 'type')
				{
					if ($typeName == 'custom' || $typeName == 'customuser')
					{
						$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml,'type="','"'));
					}
					// use field core type only if not found
					elseif (ComponentbuilderHelper::checkString($typeName))
					{
						$xmlValue = $typeName;
					}
					// make sure none adjustable fields are set
					elseif (isset($property['example']) && ComponentbuilderHelper::checkString($property['example']) && $property['adjustable'] == 0)
					{
						$xmlValue = $property['example'];
					}
					// fall back on the xml settings
					else
					{
						$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml,'type="','"'));
					}

					// check if the value is set
					if (ComponentbuilderHelper::checkString($xmlValue))
					{
						// add the value
						$typeName = $xmlValue;
					}
					else
					{
						// fall back to text
						$xmlValue = 'text';
						$typeName = $xmlValue;
					}

					// add to custom if it is custom
					if	($setCustom)

					{
						// set the type just to make sure.
						$fieldValues['custom']['type'] = $typeName;
					}
				}
				elseif ($property['name'] == 'name')
				{
					// if category then name must be catid (only one per view)
					if ($typeName == 'category')
					{
						// quick check if this is a category linked to view page
						$requeSt_id = ComponentbuilderHelper::getBetween($field['settings']->xml,'name="','"');
						if (strpos($requeSt_id, '_request_id') !== false)
						{
							// keep it then, don't change
							$xmlValue = $requeSt_id;
						}
						else
						{
							$xmlValue = 'catid';
						}
						// check if we should use another Text Name as this views name
						$otherName = ComponentbuilderHelper::getBetween($field['settings']->xml,'othername="','"');
						$otherViews = ComponentbuilderHelper::getBetween($field['settings']->xml,'views="','"');
						$otherView = ComponentbuilderHelper::getBetween($field['settings']->xml,'view="','"');
						if (ComponentbuilderHelper::checkString($otherName) && ComponentbuilderHelper::checkString($otherViews) && ComponentbuilderHelper::checkString($otherView))
						{
							$this->catOtherName[$listViewName] = array(
								'name' => ComponentbuilderHelper::safeString($otherName),
								'views' => ComponentbuilderHelper::safeString($otherViews),
								'view' => ComponentbuilderHelper::safeString($otherView)
							);
						}

					}
					// if tag is set then enable all tag options for this view (only one per view)
					elseif ($typeName == 'tag')
					{
						$xmlValue = 'tags';
					}
					// if the field is set as alias it must be called alias
					elseif (isset($field['alias']) && $field['alias'])
					{
						$xmlValue = 'alias';
					}
					elseif ($typeName == 'spacer')
					{
						// make sure the name is unique
						$xmlValue = $name.'_'.$spacerCounter;
					}
					else
					{
						$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml,'name="','"'));
					}

					// use field core name only if not found in xml
					if (!ComponentbuilderHelper::checkString($xmlValue))
					{
						$xmlValue = $name;
					}
					// set the name if found
					else
					{
						$name = $xmlValue;
					}
				}
				elseif ($property['name'] == 'extension' || $property['name'] == 'directory')
				{
					$xmlValue = ComponentbuilderHelper::getBetween($field['settings']->xml,$property['name'].'="','"');
					// replace the placeholders
					$xmlValue = str_replace(array_keys($placeholders),array_values($placeholders),$xmlValue);
				}
				elseif (strpos($property['name'],'type_php_') !== false && $setCustom)
				{
					// set the line number
					$phpLine = (int) str_replace('type_php_','',$property['name']);
					// load the php for the custom field file
					$fieldValues['custom']['php'][$phpLine] = ComponentbuilderHelper::getBetween($field['settings']->xml,$property['name'].'="','"');
				}
				elseif (strpos($property['name'],'type_phpx_') !== false && $setCustom)
				{
					// set the line number
					$phpLine = (int) str_replace('type_phpx_','',$property['name']);
					// load the php for the custom field file
					$fieldValues['custom']['phpx'][$phpLine] = ComponentbuilderHelper::getBetween($field['settings']->xml,$property['name'].'="','"');
				}
				elseif ($property['name'] == 'extends' && $setCustom)
				{
					// load the class that is being extended
					$fieldValues['custom']['extends'] = ComponentbuilderHelper::getBetween($field['settings']->xml,'extends="','"');
				}
				elseif ($property['name'] == 'view' && $setCustom)
				{
					// load the view name
					$fieldValues['custom']['view'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml,'view="','"'));
				}
				elseif ($property['name'] == 'views' && $setCustom)
				{
					// load the views name
					$fieldValues['custom']['views'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml,'views="','"'));
				}
				elseif ($property['name'] == 'component' && $setCustom)
				{
					// load the component name
					$fieldValues['custom']['component'] = ComponentbuilderHelper::getBetween($field['settings']->xml,'component="','"');
					// replace the placeholders
					$fieldValues['custom']['component'] = str_replace(array_keys($placeholders),array_values($placeholders),$fieldValues['custom']['component']);
				}
				elseif ($property['name'] == 'table' && $setCustom)
				{
					// load the main table that is queried
					$fieldValues['custom']['table'] = ComponentbuilderHelper::getBetween($field['settings']->xml,'table="','"');
					// replace the placeholders
					$fieldValues['custom']['table'] = str_replace(array_keys($placeholders),array_values($placeholders),$fieldValues['custom']['table']);
				}
				elseif ($property['name'] == 'value_field' && $setCustom)
				{
					// load the text key
					$fieldValues['custom']['text'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml,'value_field="','"'));
				}
				elseif ($property['name'] == 'key_field' && $setCustom)
				{
					// load the id key
					$fieldValues['custom']['id'] = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml,'key_field="','"'));
				}
				elseif ($property['name'] == 'button' && $repeatable && $setCustom)
				{
					// dont load the button to repeatable
					$xmlValue = 'false';
				}
				elseif ($viewType == 2 && ($property['name'] == 'readonly' || $property['name'] == 'disabled'))
				{
					// set read only
					$xmlValue = 'true';
				}
				elseif ($property['name'] == 'multiple')
				{
					$xmlValue = ComponentbuilderHelper::getBetween($field['settings']->xml,$property['name'].'="','"');
					// add the multipal
					if ('true' == $xmlValue)
					{
						$multiple = true;
					}
				}
				// make sure the name is added as a cless name for use in javascript
				elseif ($property['name'] == 'class' && ($typeName == 'note' || $typeName == 'spacer'))
				{
					$xmlValue = ComponentbuilderHelper::getBetween($field['settings']->xml, 'class="','"');
					// add the type class
					if (ComponentbuilderHelper::checkString($xmlValue))
					{
						if (strpos($xmlValue,$name) === false)
						{
							$xmlValue = $xmlValue.' '.$name;
						}
					}
					else
					{
						$xmlValue = $name;
					}
				}
				else
				{
					// set the rest of the fields
					$xmlValue = ComponentbuilderHelper::getBetween($field['settings']->xml,$property['name'].'="','"');
				}

				// check if translatable
				if (ComponentbuilderHelper::checkString($xmlValue) && $property['translatable'] == 1)
				{
					// replace placeholders
					$xmlValue = str_replace(array_keys($placeholders),array_values($placeholders),$xmlValue);
					// insure custom lables dont get messed up
					if	($setCustom)
					{
						$customLabel = $xmlValue;
					}
					// set lang key
					$langValue = $langView.'_'.ComponentbuilderHelper::safeString($name.' '.$property['name'],'U');
					// add to lang array
					$this->langContent[$this->lang][$langValue]	= $xmlValue;
					// use lang value
					$xmlValue = $langValue;

				}
				elseif (isset($field['alias']) && $field['alias'] && $property['translatable'] == 1)
				{
					if ($property['name'] == 'label')
					{
						$xmlValue = 'JFIELD_ALIAS_LABEL';
					}
					elseif ($property['name'] == 'description')
					{
						$xmlValue = 'JFIELD_ALIAS_DESC';
					}
					elseif ($property['name'] == 'hint')
					{
						$xmlValue = 'JFIELD_ALIAS_PLACEHOLDER';
					}
				}
				elseif (isset($field['title']) && $field['title'] && $property['translatable'] == 1)
				{
					if ($property['name'] == 'label')
					{
						$xmlValue	= 'JGLOBAL_TITLE';
					}
					elseif ($property['name'] == 'description')
					{
						$xmlValue = 'JFIELD_TITLE_DESC';
					}
				}
				// only load value if found or is mandatory
				if (ComponentbuilderHelper::checkString($xmlValue) || ($property['mandatory'] == 1 && !$setCustom))
				{
					// make sure mantory fields are added
					if (!ComponentbuilderHelper::checkString($xmlValue))
					{
						if (isset($property['example']) && ComponentbuilderHelper::checkString($property['example']))
						{
							$xmlValue = $property['example'];
						}
					}

					$fieldValues[$property['name']] = $xmlValue;

					// load to langBuilder down the line
					if ($property['name'] == 'label')
					{
						$langLabel = $xmlValue;
						if	($setCustom)
						{
							$fieldValues['custom']['label'] = $customLabel;
						}
					}
				}
			}
			// do some nice twigs beyond the default
			if (isset($fieldValues['name']))
			{
				// check if we find reason to remove this field from being escaped
				$escaped = ComponentbuilderHelper::getBetween($field['settings']->xml,'escape="','"');
				if (ComponentbuilderHelper::checkString($escaped))
				{
					$this->doNotEscape[$listViewName][] = $fieldValues['name'];
				}
			}
		}
		return $fieldValues;
	}

	protected function setBuilders($langLabel, $langView,$viewName,$listViewName,$name,$view,$field,$typeName,$multiple,$custom = false,$options = false)
	{
		if ($typeName == 'tag')
		{
			// set tags for this view but don't load to DB
			$this->tagsBuilder[$viewName] = $viewName;
		}
		else
		{
			// insure default not none if number type
			$intKeys = array('INT','TINYINT','BIGINT','FLOAT','DECIMAL','DOUBLE');
			if (in_array($field['settings']->datatype,$intKeys))
			{
				if ($field['settings']->datadefault == 'Other')
				{
					if (!is_numeric($field['settings']->datadefault_other) || $field['settings']->datadefault_other !== '0000-00-00 00:00:00')
					{
						$field['settings']->datadefault_other = '0';
					}
				}
				elseif (!is_numeric($field['settings']->datadefault))
				{
					$field['settings']->datadefault = '0';
				}
			}
			// build the query values
			$this->queryBuilder[$viewName][$name] = array(
				'type' => $field['settings']->datatype,
				'lenght' => $field['settings']->datalenght,
				'default' => $field['settings']->datadefault,
				'other' => $field['settings']->datadefault_other,
				'null_switch' => $field['settings']->null_switch);
			// don't use these as index or uniqe keys
			$notKeys = array('TEXT','TINYTEXT','MEDIUMTEXT','LONGTEXT','BLOB','TINYBLOB','MEDIUMBLOB','LONGBLOB');
			// set index types
			if ($field['settings']->indexes == 1 && !in_array($field['settings']->datatype,$notKeys))
			{
				// build unique keys of this view for db
				$this->dbUniqueKeys[$viewName][] = $name;
			}
			elseif(($field['settings']->indexes == 2 || $field['alias'] || $field['title'] || $typeName == 'category') && !in_array($field['settings']->datatype,$notKeys))
			{
				// build keys of this view for db
				$this->dbKeys[$viewName][] = $name;
			}

		}
		// add history to this view
		if ($view['history'])
		{
			$this->historyBuilder[$viewName] = $viewName;
		}
		// set Alias (only one title per view)
		if ($field['alias'])
		{
			$this->aliasBuilder[$viewName] = $name;
		}
		// set Titles (only one title per view)
		if ($field['title'])
		{
			$this->titleBuilder[$viewName] = $name;
		}
		// category name fix
		if ($typeName == 'category')
		{
			if (isset($this->catOtherName[$listViewName]) && ComponentbuilderHelper::checkArray($this->catOtherName[$listViewName]))
			{
				$tempName = $this->catOtherName[$listViewName]['name'];
			}
			else
			{
				$tempName = $viewName.' category';
			}
			// set lang
			$listLangName = $langView.'_'.ComponentbuilderHelper::safeString($tempName,'U');
			// add to lang array
			$this->langContent[$this->lang][$listLangName] = ComponentbuilderHelper::safeString($tempName,'W');
		}
		else
		{
			// set lang (just incase)
			$listLangName = $langView.'_'.ComponentbuilderHelper::safeString($name,'U');
			// add to lang array
			$this->langContent[$this->lang][$listLangName] = ComponentbuilderHelper::safeString($name,'W');
			// if label was set use instead
			if (ComponentbuilderHelper::checkString($langLabel))
			{
				$listLangName = $langLabel;
			}
		}
		// build the list values
		if ($field['list'] == 1 && $typeName != 'repeatable')
		{
			// load to list builder
			$this->listBuilder[$listViewName][] = array(
				'type' => $typeName,
				'code' => $name,
				'lang' => $listLangName,
				'title' => ($field['title']) ? true:false,
				'alias' => ($field['alias']) ? true:false,
				'link' => ($field['link']) ? true:false,
				'sort' => ($field['sort']) ? true:false,
				'custom' => $custom,
				'options' => $options );

			$this->customBuilderList[$listViewName][] = $name;
		}
		// set the hidden field of this view
		if ($typeName == 'hidden')
		{
			if (!isset($this->hiddenFieldsBuilder[$viewName]))
			{
				$this->hiddenFieldsBuilder[$viewName] = '';
			}
			$this->hiddenFieldsBuilder[$viewName] .= ',"'.$name.'"';
		}
		// set all int fields of this view
		if ($field['settings']->datatype == 'INT' || $field['settings']->datatype == 'TINYINT' || $field['settings']->datatype == 'BIGINT'  )
		{
			if (!isset($this->intFieldsBuilder[$viewName]))
			{
				$this->intFieldsBuilder[$viewName] = '';
			}
			$this->intFieldsBuilder[$viewName] .= ',"'.$name.'"';
		}
		// set all dynamic field of this view
		if ($typeName != 'category' && $typeName != 'repeatable')
		{
			if (!isset($this->dynamicfieldsBuilder[$viewName]))
			{
				$this->dynamicfieldsBuilder[$viewName] = '';
			}
			if (isset($this->dynamicfieldsBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->dynamicfieldsBuilder[$viewName]))
			{
				$this->dynamicfieldsBuilder[$viewName] .= ',"'.$name.'":"'.$name.'"';
			}
			else
			{
				$this->dynamicfieldsBuilder[$viewName] .= '"'.$name.'":"'.$name.'"';
			}
		}
		// TODO we may need to add a switch instead (since now it uses the first editor field)
		// set the main(biggest) text field of this view
		if ($typeName == 'editor')
		{
			if (!isset($this->maintextBuilder[$viewName]) || !ComponentbuilderHelper::checkString($this->maintextBuilder[$viewName]))
			{
				$this->maintextBuilder[$viewName] = $name;
			}
		}
		// set the custom builder
		if (ComponentbuilderHelper::checkArray($custom) && $typeName != 'category' && $typeName != 'repeatable')
		{
			$this->customBuilder[$listViewName][] = array( 'type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom);
			// set the custom fields needed in content type data
			if (!isset($this->customFieldLinksBuilder[$viewName]))
			{
				$this->customFieldLinksBuilder[$viewName] = '';
			}
			$this->customFieldLinksBuilder[$viewName] .= ',{"sourceColumn": "'.$name.'","targetTable": "'.$custom['table'].'","targetColumn": "'.$custom['id'].'","displayColumn": "'.$custom['text'].'"}';
			// build script switch for user
			if ($custom['extends'] == 'user')
			{
				$this->setScriptUserSwitch[$typeName] = $typeName;
			}
		}
		if ($typeName == 'media')
		{
			$this->setScriptMediaSwitch[$typeName] = $typeName;
		}
		// setup gategory for this view
		if ($typeName == 'category')
		{
			if (isset($this->catOtherName[$listViewName]) && ComponentbuilderHelper::checkArray($this->catOtherName[$listViewName]))
			{
				$otherViews = $this->catOtherName[$listViewName]['views'];
				$otherView = $this->catOtherName[$listViewName]['view'];
			}
			else
			{
				$otherViews = $listViewName;
				$otherView = $viewName;
			}
			$this->categoryBuilder[$listViewName] = array('code' => $name, 'name' => $listLangName);
			// also set code name for title alias fix
			$this->catCodeBuilder[$viewName] = array('code' => $name, 'views' => $otherViews, 'view' => $otherView);
		}
		// setup checkbox for this view
		if ($typeName == 'checkbox')
		{
			$this->checkboxBuilder[$viewName][] = $name;
		}
		// setup checkboxes and other json items for this view
		if (($typeName == 'checkboxes' || $multiple || $field['settings']->store != 0) && $typeName != 'tag')
		{
			switch ($field['settings']->store)
			{
				case 1:
				// JSON_STRING_ENCODE
				$this->jsonStringBuilder[$viewName][] = $name;
				// Site settings of each field if needed
				$this->buildSiteFieldData($viewName,$name,'json',$typeName);
				break;
				case 2:
				// BASE_SIXTY_FOUR
				$this->base64Builder[$viewName][] = $name;
				// Site settings of each field if needed
				$this->buildSiteFieldData($viewName,$name,'base64',$typeName);
				break;
				case 3:
				// BASIC_ENCRYPTION_LOCALKEY
				$this->basicEncryptionBuilder[$viewName][] = $name;
				// Site settings of each field if needed
				$this->buildSiteFieldData($viewName,$name,'basic_encryption',$typeName);
				break;
				case 4:
				// ADVANCE_ENCRYPTION_VDMKEY
				$this->advancedEncryptionBuilder[$viewName][] = $name;
				// Site settings of each field if needed
				$this->buildSiteFieldData($viewName,$name,'advance_encryption',$typeName);
				break;
				default:
				// JSON_ARRAY_ENCODE
				$this->jsonItemBuilder[$viewName][] = $name;
				// Site settings of each field if needed
				$this->buildSiteFieldData($viewName,$name,'json',$typeName);
				break;
			}
			// just a heads-up for usergroups set to multiple
			if ($typeName == 'usergroup')
			{
				$this->buildSiteFieldData($viewName,$name,'json',$typeName);
			}

			// load the json list display fix
			if ($field['list'] == 1  && $typeName != 'repeatable')
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					$this->getItemsMethodListStringFixBuilder[$viewName][] = array('name' => $name, 'type' => $typeName, 'translation' => true, 'custom' => $custom, 'method' => $field['settings']->store);
				}
				else
				{
					$this->getItemsMethodListStringFixBuilder[$viewName][] = array('name' => $name, 'type' => $typeName, 'translation' => false, 'custom' => $custom, 'method' => $field['settings']->store);
				}
			}
		}
		// build the data for the export & import methods $typeName == 'repeatable' ||
		if (($typeName == 'checkboxes' || $multiple || $field['settings']->store != 0) && !ComponentbuilderHelper::checkArray($options))
		{
			$this->getItemsMethodEximportStringFixBuilder[$viewName][] = array('name' => $name, 'type' => $typeName, 'translation' => false, 'custom' => $custom, 'method' => $field['settings']->store);
		}

		// check if field should be added to uikit
		$this->buildSiteFieldData($viewName,$name,'uikit',$typeName);
		// load the selection translation fix
		if (ComponentbuilderHelper::checkArray($options) && $field['list'] == 1 && $typeName != 'repeatable')
		{
			$this->selectionTranslationFixBuilder[$listViewName][$name] = $options;
		}
		// build the sort values
		if ($field['sort'] == 1 && $field['list'] == 1 && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable'))
		{
			$this->sortBuilder[$listViewName][] = array( 'type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'custom' => $custom, 'options' => $options);
		}
		// build the search values
		if ($field['search'] == 1)
		{
			$this->searchBuilder[$listViewName][] = array( 'type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $field['list']);
		}
		// build the filter values
		if ($field['filter'] == 1 && $field['list'] == 1 && (!$multiple && $typeName != 'checkbox' && $typeName != 'checkboxes' && $typeName != 'repeatable'))
		{
			$this->filterBuilder[$listViewName][] = array( 'type' => $typeName, 'code' => $name, 'lang' => $listLangName, 'database' => $viewName, 'function' => ComponentbuilderHelper::safeString($name,'F'), 'custom' => $custom, 'options' => $options);
		}

		// build the layout
		$tabName = '';
		if (isset($view['settings']->tabs) && isset($view['settings']->tabs[(int) $field['tab']]))
		{
			$tabName = $view['settings']->tabs[(int) $field['tab']];
		}
		$this->setLayoutBuilder($viewName,$tabName,$name,$field);

	}

	protected function setLayoutBuilder(&$viewName,&$tabName,&$name,&$field)
	{
		if (ComponentbuilderHelper::checkString($tabName))
		{
			$this->tabCounter[$viewName][(int) $field['tab']] = $tabName;
			if (isset($this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = count($this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][(int) $field['order_edit']]) + 1;
				$this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][$size] = $name;
			}
			else
			{
				$this->layoutBuilder[$viewName][$tabName][(int) $field['alignment']][(int) $field['order_edit']] = $name;
			}
		}
		else
		{
			$this->tabCounter[$viewName][1] = 'Details';
			if (isset($this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][(int) $field['order_edit']]))
			{
				$size = count($this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][(int) $field['order_edit']]) + 1;
				$this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][$size] = $name;
			}
			else
			{
				$this->layoutBuilder[$viewName]['Details'][(int) $field['alignment']][(int) $field['order_edit']] = $name;
			}
		}
	}

	protected function buildSiteFieldData($view,$field,$set,$type)
	{
		$decode = array('json','base64','basic_encryption','advance_encryption');
		$uikit = array('textarea','editor');
		if (isset($this->siteFields[$view][$field]) && ComponentbuilderHelper::checkArray($this->siteFields[$view][$field]))
		{
			foreach ($this->siteFields[$view][$field] as $code => $array)
			{
				// set the decoding methods
				if (in_array($set,$decode))
				{
					$this->siteFieldData['decode'][$array['site']][$code][$array['as']][$array['key']] = array('decode' => $set, 'type' => $type);
				}
				// set the uikit checker
				if (in_array($type,$uikit))
				{
					$this->siteFieldData['uikit'][$array['site']][$code][$array['as']][$array['key']] = $array;
				}
			}
		}
	}

	protected function setRouterCase($viewName)
	{
		if (strlen($viewName) > 0)
		{
			$router = "\n\t\tcase '".$viewName."':";
			$router .= "\n\t\t\t\$id = explode(':', \$segments[$count-1]);";
			$router .= "\n\t\t\t\$vars['id'] = (int) \$id[0];";
			$router .= "\n\t\t\t\$vars['view'] = '".$viewName."';";
			$router .= "\n\t\tbreak;";

			return $router;
		}
		return '';

	}

	protected function setComponentImageType($path)
	{
		$type = ComponentbuilderHelper::imageInfo($path);
		if ($type)
		{
			$imagePath = $this->componentPath.'/admin/assets/images';
			// move the image to its place
			JFile::copy(JPATH_SITE.'/'.$path, $imagePath.'/component-300.'.$type,'',true);
			// return image type
			return $type;
		}
		return 'jpg';
	}

	protected function setDashboardIconAccess()
	{
		if (isset($this->permissionDashboard) && ComponentbuilderHelper::checkArray($this->permissionDashboard))
		{
			$this->permissionDashboard = array_unique($this->permissionDashboard);
			return "\n\t\t//".$this->setLine(__LINE__)." view access array\n\t\t\$viewAccess = array(\n\t\t\t".implode(",\n\t\t\t",$this->permissionDashboard).");";
		}
		return '';

	}
	protected function setDashboardIcons()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$icons = '';
			$counter = 0;
			$catArray = array();
			foreach ($this->componentData->admin_views as $view)
			{
				$name_single = ComponentbuilderHelper::safeString($view['settings']->name_single);
				$name_list = ComponentbuilderHelper::safeString($view['settings']->name_list);

				$icons .= $this->addCustomDashboardIcons($view,$counter);
				if ($view['dashboard_add'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo($view['settings']->icon_add);
					if ($type)
					{
						$type = $type.".";
						// icon builder loader
						$this->iconBuilder[$type.$name_single.".add"] = $view['settings']->icon_add;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'".$type.$name_single.".add'";
					}
					else
					{
						$icons .= ", '".$type.$name_single.".add'";
					}
					// build lang
					$langName	= 'Add&nbsp;'.ComponentbuilderHelper::safeString($view['settings']->name_single, 'W').'<br /><br />';
					$langKey	= $this->langPrefix.'_DASHBOARD_'.ComponentbuilderHelper::safeString($view['settings']->name_single,'U').'_ADD';
					// add to lang
					$this->langContent[$this->lang][$langKey] = $langName;
					$counter++;
				}
				if ($view['dashboard_list'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo($view['settings']->icon);
					if ($type)
					{
						$type = $type.".";
						// icon builder loader
						$this->iconBuilder[$type.$name_list] = $view['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'".$type.$name_list."'";
					}
					else
					{
						$icons .= ", '".$type.$name_list."'";
					}
					// build lang
					$langName	= ComponentbuilderHelper::safeString($view['settings']->name_list, 'W').'<br /><br />';
					$langKey	= $this->langPrefix.'_DASHBOARD_'.ComponentbuilderHelper::safeString($view['settings']->name_list,'U');
					// add to lang
					$this->langContent[$this->lang][$langKey] = $langName;
					$counter++;
				}
				if (isset($this->categoryBuilder[$name_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$name_list]))
				{
					$catCode = $this->categoryBuilder[$name_list]['code'];

					// check if category has another name
					if (isset($this->catOtherName[$name_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$name_list]))
					{
						$otherViews = $this->catOtherName[$name_list]['views'];
						$otherNames = $this->catOtherName[$name_list]['name'];
						// build lang
						$langName = ComponentbuilderHelper::safeString($otherNames, 'W');
					}
					else
					{
						$otherViews = $name_list;
						// build lang
						$langName = 'Catagory &nbsp;For<br />'.ComponentbuilderHelper::safeString($otherViews, 'W');
					}
					if(!in_array($otherViews,$catArray))
					{
						// add to lang
						$langKey = $this->langPrefix.'_DASHBOARD_'.ComponentbuilderHelper::safeString($otherViews,'U').'_'.ComponentbuilderHelper::safeString($catCode,'U');
						$this->langContent[$this->lang][$langKey] = $langName;
						// get image type
						$type = ComponentbuilderHelper::imageInfo($view['settings']->icon_category);
						if ($type)
						{
							$type = $type.".";
							// icon builder loader
							$this->iconBuilder[$type.$otherViews.".".$catCode] = $view['settings']->icon_category;
						}
						else
						{
							$type = 'png.';
						}
						if ($counter == 0)
						{
							$icons .= "'".$type.$otherViews.".".$catCode."'";
						}
						else
						{
							$icons .= ", '".$type.$otherViews.".".$catCode."'";
						}
						$counter++;
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
				}
			}
			if (isset($this->lastCustomDashboardIcon) && ComponentbuilderHelper::checkArray($this->lastCustomDashboardIcon))
			{
				foreach ($this->lastCustomDashboardIcon as $icon)
				{
					$icons .= $icon;
				}
				unset($this->lastCustomDashboardIcon);
			}
			if (isset($this->iconBuilder) && ComponentbuilderHelper::checkArray($this->iconBuilder))
			{
				$imagePath = $this->componentPath.'/admin/assets/images/icons';
				foreach ($this->iconBuilder as $icon => $path)
				{
					$array_buket = explode('.', $icon);
					if (count($array_buket) == 3)
					{
						list($type, $name, $action) = $array_buket;
					}
					else
					{
						list($type, $name) = $array_buket;
						$action = false;
					}
					// set the new image name
					if ($action)
					{
						$imageName 	= $name.'_'.$action.'.'.$type;
					}
					else
					{
						$imageName 	= $name.'.'.$type;
					}
					// move the image to its place
					JFile::copy(JPATH_SITE.'/'.$path, $imagePath.'/'.$imageName,'',true);
				}
			}
			return $icons;
		}
		return false;
	}

	protected function addCustomDashboardIcons(&$view,&$counter)
	{
		// see if we should have custom menus
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
				$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
				if ($menu['dashboard_list'] == 1 && $view['adminview'] == $menu['before'])
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						// TODO must look at adding custom links to icons aswell
						return '';
					}
					else
					{
						$type = ComponentbuilderHelper::imageInfo('images/'.$menu['icon']);
						if ($type)
						{
							$type = $type.".";
							// icon builder loader
							$this->iconBuilder[$type.$nameList] = 'images/'.$menu['icon'];
						}
						else
						{
							$type = 'png.';
						}
						// build lang
						$langName	= $menu['name'].'<br /><br />';
						$langKey	= $this->langPrefix.'_DASHBOARD_'.$nameUpper;
						// add to lang
						$this->langContent[$this->lang][$langKey] = $langName;
						// set icon
						if ($counter == 0)
						{
							$counter++;
							return "'".$type.$nameList."'";
						}
						else
						{
							$counter++;
							return ", '".$type.$nameList."'";
						}
					}
				}
				elseif($menu['dashboard_list'] == 1 && empty($menu['before']))
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						// TODO must look at adding custom links to icons aswell
						return '';
					}
					else
					{
						$type = ComponentbuilderHelper::imageInfo('images/'.$menu['icon']);
						if ($type)
						{
							$type = $type.".";
							// icon builder loader
							$this->iconBuilder[$type.$nameList] = 'images/'.$menu['icon'];
						}
						else
						{
							$type = 'png.';
						}
						// build lang
						$langName	= $menu['name'].'<br /><br />';
						$langKey	= $this->langPrefix.'_DASHBOARD_'.$nameUpper;
						// add to lang
						$this->langContent[$this->lang][$langKey] = $langName;
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '".$type.$nameList."'";
					}
				}
			}
		}
		return '';
	}

	protected function setSubMenus()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$menus = '';
			// main lang prefix
			$lang = $this->langPrefix.'_SUBMENU';
			// set the code name
			$codeName = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// set dashboard
			$menus .= "JHtmlSidebar::addEntry(JText::_('".$lang."_DASHBOARD'), 'index.php?option=com_".$codeName."&view=".$codeName."', \$submenu == '".$codeName."');";
			$this->langContent[$this->lang][$lang.'_DASHBOARD'] = 'Dashboard';
			$catArray = array();
			foreach ($this->componentData->admin_views as $view)
			{
				// set custom menu
				$menus .= $this->addCustomSubMenu($view,$codeName,$lang);
				if ($view['submenu'] == 1)
				{
					// setup access defaults
					$tab = "";
					$nameSingle = ComponentbuilderHelper::safeString($view['settings']->name_single);
					$coreLoad = false;
					if (isset($this->permissionCore[$nameSingle]))
					{
						$core = $this->permissionCore[$nameSingle];
						$coreLoad = true;
					}
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
					{
						$menus .= "\n\t\tif (\$user->authorise('".$core['core.access']."', 'com_".$codeName."') && \$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
						$menus .= "\n\t\t{";
						// add tab to lines to follow
						$tab = "\t";
					}
					$nameList	= ComponentbuilderHelper::safeString($view['settings']->name_list);
					$nameUpper	= ComponentbuilderHelper::safeString($view['settings']->name_list, 'U');
					$menus .= "\n\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), 'index.php?option=com_".$codeName."&view=".$nameList."', \$submenu == '".$nameList."');";
					$this->langContent[$this->lang][$lang."_".$nameUpper] = $view['settings']->name_list;
					// check if category has another name
					if (isset($this->catOtherName[$nameList]) && ComponentbuilderHelper::checkArray($this->catOtherName[$nameList]))
					{
						$otherViews = $this->catOtherName[$nameList]['views'];
					}
					else
					{
						$otherViews = $nameList;
					}
					if (isset($this->categoryBuilder[$nameList]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$nameList]) && !in_array($otherViews,$catArray))
					{
						$menus .= "\n\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$this->categoryBuilder[$nameList]['name']."'), 'index.php?option=com_categories&view=categories&extension=com_".$codeName.".".$otherViews."', \$submenu == 'categories.".$otherViews."');";
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
					{
						$menus .= "\n\t\t}";
					}
				}
			}
			if (isset($this->lastCustomSubMenu) && ComponentbuilderHelper::checkArray($this->lastCustomSubMenu))
			{
				foreach ($this->lastCustomSubMenu as $menu)
				{
					$menus .= $menu;
				}
				unset($this->lastCustomSubMenu);
			}
			return $menus;
		}
		return false;
	}

	protected function addCustomSubMenu(&$view,&$codeName,&$lang)
	{
		// see if we should have custom menus
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				if ($menu['submenu'] == 1 && $view['adminview'] == $menu['before'])
				{
					// setup access defaults
					$tab = "";
					$nameSingle	= ComponentbuilderHelper::safeString($menu['name']);
					$coreLoad = false;
					if (isset($this->permissionCore[$nameSingle]))
					{
						$core = $this->permissionCore[$nameSingle];
						$coreLoad = true;
					}
					$custom = '';
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
					{
						$custom .= "\n\t\t//".$this->setLine(__LINE__)." Access control (".$core['core.access']." && ".$nameSingle.".submenu).";
						$custom .= "\n\t\tif (\$user->authorise('".$core['core.access']."', 'com_".$codeName."') && \$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
						$custom .= "\n\t\t{";
						// add tab to lines to follow
						$tab = "\t";
					}
					else
					{
						$custom .= "\n\t\t//".$this->setLine(__LINE__)." Access control (".$nameSingle.".submenu).";
						$custom .= "\n\t\tif (\$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
						$custom .= "\n\t\t{";
						// add tab to lines to follow
						$tab = "\t";
					}
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$custom .= "\n\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), '".$menu['link']."', \$submenu == '".$nameList."');";
					}
					else
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$custom .= "\n\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), 'index.php?option=com_".$codeName."&view=".$nameList."', \$submenu == '".$nameList."');";
					}
					// check if the item has permissions.
					$custom .= "\n\t\t}";

					return $custom;
				}
				elseif($menu['submenu'] == 1 && empty($menu['before']))
				{
					// setup access defaults
					$tab = "";
					$nameSingle	= ComponentbuilderHelper::safeString($menu['name']);
					$coreLoad = false;
					if (isset($this->permissionCore[$nameSingle]))
					{
						$core = $this->permissionCore[$nameSingle];
						$coreLoad = true;
					}
					$this->lastCustomSubMenu[$nr] = '';
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
					{
						$this->lastCustomSubMenu[$nr] .= "\n\t\tif (\$user->authorise('".$core['core.access']."', 'com_".$codeName."') && \$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
						$this->lastCustomSubMenu[$nr] .= "\n\t\t{";
						// add tab to lines to follow
						$tab = "\t";
					}
					else
					{
						$this->lastCustomSubMenu[$nr] .= "\n\t\tif (\$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
						$this->lastCustomSubMenu[$nr] .= "\n\t\t{";
						// add tab to lines to follow
						$tab = "\t";
					}
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$this->lastCustomSubMenu[$nr] .= "\n\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), '".$menu['link']."', \$submenu == '".$nameList."');";
					}
					else
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$this->lastCustomSubMenu[$nr] .= "\n\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), 'index.php?option=com_".$codeName."&view=".$nameList."', \$submenu == '".$nameList."');";
					}
					// check if the item has permissions.
					$this->lastCustomSubMenu[$nr] .= "\n\t\t}";
				}
			}
		}
		return '';

	}

	protected function setMainMenus()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$menus = '';
			// main lang prefix
			$lang = $this->langPrefix.'_MENU';
			// set the code name
			$codeName = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// set main menu name to lang
			$this->langContent['adminsys'][$lang] = '&#187; '.$this->componentData->name;
			foreach ($this->componentData->admin_views as $view)
			{
				// set custom menu
				$menus .= $this->addCustomMainMenu($view,$codeName,$lang);
				if ($view['mainmenu'] == 1)
				{
					$nameList	= ComponentbuilderHelper::safeString($view['settings']->name_list);
					$nameUpper	= ComponentbuilderHelper::safeString($view['settings']->name_list, 'U');
					$menus .= "\n\t\t\t".'<menu option="com_'.$codeName.'" view="'.$nameList.'">'.$lang.'_'.$nameUpper.'</menu>';
					$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $view['settings']->name_list;
				}
			}
			if (isset($this->lastCustomMainMenu) && ComponentbuilderHelper::checkArray($this->lastCustomMainMenu))
			{
				foreach ($this->lastCustomMainMenu as $menu)
				{
					$menus .= $menu;
				}
				unset($this->lastCustomMainMenu);
			}
			return $menus;
		}
		return false;
	}

	protected function addCustomMainMenu(&$view,&$codeName,&$lang)
	{
		// see if we should have custom menus
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				if ($menu['mainmenu'] == 1 && $view['adminview'] == $menu['before'])
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						return "\n\t\t\t".'<menu link="'.$menu['link'].'">'.$lang.'_'.$nameUpper.'</menu>';
					}
					else
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						return "\n\t\t\t".'<menu option="com_'.$codeName.'" view="'.$nameList.'">'.$lang.'_'.$nameUpper.'</menu>';
					}
				}
				elseif($menu['mainmenu'] == 1 && empty($menu['before']))
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$this->lastCustomMainMenu[$nr] = "\n\t\t\t".'<menu link="'.$menu['link'].'">'.$lang.'_'.$nameUpper.'</menu>';
					}
					else
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$this->lastCustomMainMenu[$nr] = "\n\t\t\t".'<menu option="com_'.$codeName.'" view="'.$nameList.'">'.$lang.'_'.$nameUpper.'</menu>';
					}
				}
			}
		}
		return '';

	}

	protected function setConfigFieldsets($timer = 0)
	{
		// main lang prefix
		$lang = $this->langPrefix.'_CONFIG';
		if (1 == $timer) // this is before the admin views are build
		{
			// start loading Global params
			$autorName = ComponentbuilderHelper::htmlEscape($this->componentData->author);
			$autorEmail = ComponentbuilderHelper::htmlEscape($this->componentData->email);
			$this->paramsBuilder = '"autorName":"'.$autorName.'","autorEmail":"'.$autorEmail.'"';
			// set the custom fields
			if (isset($this->componentData->config) && ComponentbuilderHelper::checkArray($this->componentData->config))
			{
				$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
				$viewName = 'config';
				$listViewName = 'configs';
				$placeholders = array(
						'###component###' => $component,
						'###view###' => $viewName,
						'###views###' => $listViewName);
				$spacerCounter = 'a';
				$view = '';
				$viewType = 0;
				// set the custom table key
				$dbkey = 'g';
				foreach ($this->componentData->config as $field)
				{
					$xmlField = $this->setDynamicField($field, $view, $viewType, $lang, $viewName, $listViewName, $spacerCounter, $placeholders, $dbkey, false);
					if (ComponentbuilderHelper::checkString($xmlField))
					{
						$this->configFieldSetsCustomField[$field['tabname']][] = $xmlField;
						// set global params to db on install
						$fieldName = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xmlField,'name="','"'));
						$fieldDefault = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xmlField,'default="','"'));
						if (isset($field['custom_value']) && ComponentbuilderHelper::checkString($field['custom_value']))
						{
							// load the Global checkin defautls
							$this->paramsBuilder .= ',"'.$fieldName.'":"'.$field['custom_value'].'"';
						}
						elseif (ComponentbuilderHelper::checkString($fieldDefault))
						{
							// load the Global checkin defautls
							$this->paramsBuilder .= ',"'.$fieldName.'":"'.$fieldDefault.'"';
						}
					}
				}
			}
			// first run we must set the globals
			$this->setGlobalConfigFieldsets($lang,$autorName,$autorEmail);
			$this->setSiteControlConfigFieldsets($lang);
			
		}
		elseif (2 == $timer) // this is after the admin views are build
		{
			// these field sets can only be added after admin view is build
			$this->setGroupControlConfigFieldsets($lang);
			// these can be added anytime really (but looks best after groups
			$this->setUikitConfigFieldsets($lang);
			$this->setGooglechartConfigFieldsets($lang);
			$this->setEncryptionConfigFieldsets($lang);
			// these are the coustom settings
			$this->setCustomControlConfigFieldsets($lang);
		}
		// we cad add more event (timers as we need)
	}
	
	protected function setSiteControlConfigFieldsets($lang)
	{
		$front_end = array();
		// do quick build of front-end views
		if (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views))
		{
			// load the names only to link the page params
			foreach ($this->componentData->site_views as $siteView)
			{
				// now load the view name to the front-end array
				$front_end[] = $siteView['settings']->name;
			}
		}

		// add frontend view stuff including menus
		if (isset($this->configFieldSetsCustomField) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField))
		{
			foreach ($this->configFieldSetsCustomField as $tab => &$tabFields)
			{
				$tabCode = ComponentbuilderHelper::safeString($tab).'_custom_config';
				$tabUpper = ComponentbuilderHelper::safeString($tab,'U');
				$tabLower = ComponentbuilderHelper::safeString($tab);
				// load the regust id setters for menu views
				$viewRequest = 'name="'.$tabLower.'_request_id"';
				foreach($tabFields as $et => $id_field)
				{
					if(strpos($id_field,$viewRequest) !== false)
					{
						// set the values needed to insure route is done correclty
						$this->hasIdRequest[$tabLower] = $id_field;
						unset($tabFields[$et]);
					}
					elseif (strpos($id_field,'_request_id"') !== false)
					{
						// not loaded to a tab "view" name
						$_viewRequest = ComponentbuilderHelper::getBetween($id_field,'name="','_request_id"');
						// set the values needed to insure route is done correclty
						$this->hasIdRequest[$_viewRequest] = $id_field;
						unset($tabFields[$et]);
					}
				}
				// load the global menu setters for single fields
				$menuSetter = $tabLower.'_menu';
				$pageSettings = array();
				foreach($tabFields as $ct => $field)
				{
					if(strpos($field,$menuSetter) !== false)
					{
						// set the values needed to insure route is done correclty
						$this->hasMenuGlobal[$tabLower] = $menuSetter;
					}
					elseif (strpos($field,'_menu"') !== false)
					{
						// not loaded to a tab "view" name
						$_tabLower = ComponentbuilderHelper::getBetween($field,'name="','_menu"');
						// set the values needed to insure route is done correclty
						$this->hasMenuGlobal[$_tabLower] = $_tabLower.'_menu';
					}
					else
					{
						$pageSettings[$ct] = $field;
					}
				}
				// insure we load the needed params
				if (in_array($tab,$front_end))
				{
					$this->frontEndParams[$tab] = $pageSettings;
				}
			}
		}
	}

	protected function setCustomControlConfigFieldsets($lang)
	{
		// add custom new global fields set
		if (isset($this->configFieldSetsCustomField) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField))
		{
			foreach ($this->configFieldSetsCustomField as $tab => $tabFields)
			{
				$tabCode = ComponentbuilderHelper::safeString($tab).'_custom_config';
				$tabUpper = ComponentbuilderHelper::safeString($tab,'U');
				$tabLower = ComponentbuilderHelper::safeString($tab);
				// setup lang
				$this->langContent[$this->lang][$lang.'_'.$tabUpper] = $tab;
				// start field set
				$this->configFieldSets[] = "\t<fieldset";
				$this->configFieldSets[] = "\t\t".'name="'.$tabCode.'"';
				$this->configFieldSets[] = "\t\t".'label="'.$lang.'_'.$tabUpper.'">';
				// set the fields
				$this->configFieldSets[] = implode("\t\t",$tabFields);
				// close field set
				$this->configFieldSets[] = "\t</fieldset>";
				// remove after loading
				unset($this->configFieldSetsCustomField[$tab]);
			}
		}
	}
	
	protected function setGroupControlConfigFieldsets($lang)
	{
		// start loading Group control params if needed
		if (isset($this->setGroupControl) && ComponentbuilderHelper::checkArray($this->setGroupControl))
		{
			// start building field set for config
			$this->configFieldSets[] = "\t<fieldset";
			$this->configFieldSets[] = "\t\t".'name="group_config"';
			$this->configFieldSets[] = "\t\t".'label="'.$lang.'_GROUPS_LABEL"';
			$this->configFieldSets[] = "\t\t".'description="'.$lang.'_GROUPS_DESC">';
			// setup lang
			$this->langContent[$this->lang][$lang.'_GROUPS_LABEL']		= "Target Groups";
			$this->langContent[$this->lang][$lang.'_GROUPS_DESC']		= "The Parameters for the targeted groups are set here.";
			$this->langContent[$this->lang][$lang.'_TARGET_GROUP_DESC']	= "Set the group/s being targeted by this user type.";

			foreach ($this->setGroupControl as $selector => $label)
			{
				$this->configFieldSets[] = "\t\t".'<field name="'.$selector.'"';
				$this->configFieldSets[] = "\t\t\t".'type="usergroup"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$label.'"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_TARGET_GROUP_DESC"';
				$this->configFieldSets[] = "\t\t\t".'multiple="true"';
				$this->configFieldSets[] = "\t\t/>";
				// set params defaults
				$this->paramsBuilder .= ',"'.$selector.'":["2"]';
			}
			// add custom Target Groups fields
			if (isset($this->configFieldSetsCustomField['Target Groups']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Target Groups']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Target Groups']);
				unset($this->configFieldSetsCustomField['Target Groups']);
			}
			// close that fieldset
			$this->configFieldSets[] = "\t</fieldset>";
		}
	}
	
	protected function setGlobalConfigFieldsets($lang,$autorName,$autorEmail)
	{
		// start building field set for config
		$this->configFieldSets[] = '<fieldset';
		$this->configFieldSets[] = "\t\t".'name="global_config"';
		$this->configFieldSets[] = "\t\t".'label="'.$lang.'_GLOBAL_LABEL"';
		$this->configFieldSets[] = "\t\t".'description="'.$lang.'_GLOBAL_DESC">';
		// set application update License Key
		if ($this->componentData->add_license)
		{
			// set licence type switch
			switch ($this->componentData->license_type)
			{
				case 1:
					// for updates
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_LABEL']= "Your License Key";
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_DESC']	= "To get updates you must add the license key here that you recieved from ".$this->componentData->companyname;
					// set the field
					$this->configFieldSets[] = "\t\t".'<field type="note" name="license_key_note" class="alert alert-info" label="'.$lang.'_LICENSE_KEY_NOTE_LABEL" description="'.$lang.'_LICENSE_KEY_NOTE_DESC"  />';
					break;
				case 2:
					// with vdm to lock down ownership
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_LABEL']= "Your License Key";
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_DESC']	= "To use this component you must add the license key here that you recieved from ".$this->componentData->companyname;
					// set the field
					$this->configFieldSets[] = "\t\t".'<field type="note" name="license_key_note" class="alert alert-info" label="'.$lang.'_LICENSE_KEY_NOTE_LABEL" description="'.$lang.'_LICENSE_KEY_NOTE_DESC"  />';
					break;
			}
			// setup lang
			$this->langContent[$this->lang][$lang.'_LICENSE_KEY_LABEL']	= "License Key";
			$this->langContent[$this->lang][$lang.'_LICENSE_KEY_DESC']	= "Add your license key here.";
			// add the field
			$this->configFieldSets[] = "\t\t".'<field name="license_key"';
			$this->configFieldSets[] = "\t\t\t".'type="text"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_LICENSE_KEY_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_LICENSE_KEY_DESC"';
			$this->configFieldSets[] = "\t\t\t".'size="60"';
			$this->configFieldSets[] = "\t\t\t".'default=""';
			$this->configFieldSets[] = "\t\t/>";
			$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerLicense" hr="true" />';
		}
		// setup lang
		$this->langContent[$this->lang][$lang.'_GLOBAL_LABEL']	= "Global";
		$this->langContent[$this->lang][$lang.'_GLOBAL_DESC']	= "The Global Parameters";
		// add auto checin if required
		if ($this->addCheckin)
		{
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\t".'name="check_in"';
			$this->configFieldSets[] = "\t\t\t".'type="list"';
			$this->configFieldSets[] = "\t\t\t".'default="0"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_CHECK_TIMER_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_CHECK_TIMER_DESC">';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-5 hours">'.$lang.'_CHECK_TIMER_OPTION_ONE</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-12 hours">'.$lang.'_CHECK_TIMER_OPTION_TWO</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-1 day">'.$lang.'_CHECK_TIMER_OPTION_THREE</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-2 day">'.$lang.'_CHECK_TIMER_OPTION_FOUR</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-1 week">'.$lang.'_CHECK_TIMER_OPTION_FIVE</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="0">'.$lang.'_CHECK_TIMER_OPTION_SIX</option>';
			$this->configFieldSets[] = "\t\t</field>";
			$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerAuthor" hr="true" />';
			// setup lang
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_LABEL']		= "Check in timer";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_DESC']		= "Set the intervals for the auto checkin fuction of tables that checks out the items to an user.";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_ONE']	= "Every five hours";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_TWO']	= "Every twelve hours";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_THREE']	= "Once a day";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_FOUR']	= "Every second day";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_FIVE']	= "Once a week";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_SIX']	= "Never";
			// load the Global checkin defautls
			$this->paramsBuilder .= ',"check_in":"-1 day"';
		}
		// set history control
		if ($this->setTagHistory)
		{
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\t".'name="save_history"';
			$this->configFieldSets[] = "\t\t\t".'type="radio"';
			$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = "\t\t\t".'default="0"';
			$this->configFieldSets[] = "\t\t\t".'label="JGLOBAL_SAVE_HISTORY_OPTIONS_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="JGLOBAL_SAVE_HISTORY_OPTIONS_DESC"';
			$this->configFieldSets[] = "\t\t\t>";
			$this->configFieldSets[] = "\t\t\t".'<option value="1">JYES</option>';
			$this->configFieldSets[] = "\t\t\t".'<option value="0">JNO</option>';
			$this->configFieldSets[] = "\t\t</field>";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\t".'name="history_limit"';
			$this->configFieldSets[] = "\t\t\t".'type="text"';
			$this->configFieldSets[] = "\t\t\t".'filter="integer"';
			$this->configFieldSets[] = "\t\t\t".'label="JGLOBAL_HISTORY_LIMIT_OPTIONS_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="JGLOBAL_HISTORY_LIMIT_OPTIONS_DESC"';
			$this->configFieldSets[] = "\t\t\t".'default="10"';
			$this->configFieldSets[] = "\t\t/>";
			$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerHistory" hr="true" />';
			// load the Global checkin defautls
			$this->paramsBuilder .= ',"save_history":"1","history_limit":"10"';
		}
		// add custom global fields
		if (isset($this->configFieldSetsCustomField['Global']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Global']))
		{
			$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Global']);
			unset($this->configFieldSetsCustomField['Global']);
		}
		// set the author details
		$this->configFieldSets[] = "\t\t".'<field name="autorTitle"';
		$this->configFieldSets[] = "\t\t\t".'type="spacer"';
		$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_AUTHOR"';
		$this->configFieldSets[] = "\t\t/>";
		$this->configFieldSets[] = "\t\t".'<field name="autorName"';
		$this->configFieldSets[] = "\t\t\t".'type="text"';
		$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_AUTHOR_NAME_LABEL"';
		$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_AUTHOR_NAME_DESC"';
		$this->configFieldSets[] = "\t\t\t".'size="60"';
		$this->configFieldSets[] = "\t\t\t".'default="'.$autorName.'"';
		$this->configFieldSets[] = "\t\t\t".'readonly="true"';
		$this->configFieldSets[] = "\t\t\t".'class="readonly"';
		$this->configFieldSets[] = "\t\t/>";
		$this->configFieldSets[] = "\t\t".'<field name="autorEmail"';
		$this->configFieldSets[] = "\t\t\t".'type="email"';
		$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_AUTHOR_EMAIL_LABEL"';
		$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_AUTHOR_EMAIL_DESC"';
		$this->configFieldSets[] = "\t\t\t".'size="60"';
		$this->configFieldSets[] = "\t\t\t".'default="'.$autorEmail.'"';
		$this->configFieldSets[] = "\t\t\t".'readonly="true"';
		$this->configFieldSets[] = "\t\t\t".'class="readonly"';
		$this->configFieldSets[] = "\t\t/>";
		// setup lang
		$this->langContent[$this->lang][$lang.'_AUTHOR']		= "Author Info";
		$this->langContent[$this->lang][$lang.'_AUTHOR_NAME_LABEL']	= "Author Name";
		$this->langContent[$this->lang][$lang.'_AUTHOR_NAME_DESC']	= "The name of the author of this component.";
		$this->langContent[$this->lang][$lang.'_AUTHOR_EMAIL_LABEL']	= "Author Email";
		$this->langContent[$this->lang][$lang.'_AUTHOR_EMAIL_DESC']	= "The email address of the author of this component.";
		// set if contributors were added
		$langCont = $lang.'_CONTRIBUTOR';
		if (isset($this->addContributors) && $this->addContributors && isset($this->componentData->contributors) && ComponentbuilderHelper::checkArray($this->componentData->contributors))
		{
			foreach ($this->componentData->contributors as $counter => $contributor)
			{
				// make sure we dont use 0
				$counter++;
				// get the word for this number
				$COUNTER = ComponentbuilderHelper::safeString($counter,'U');
				// set the dynamic values
				$cbTitle	= htmlspecialchars($contributor['title'], ENT_XML1, 'UTF-8');
				$cbName		= htmlspecialchars($contributor['name'], ENT_XML1, 'UTF-8');
				$cbEmail	= htmlspecialchars($contributor['email'], ENT_XML1, 'UTF-8');
				$cbWebsite	= htmlspecialchars($contributor['website'], ENT_XML1, 'UTF-8'); // ComponentbuilderHelper::htmlEscape($contributor['website']);
				// load to the $fieldsets
				$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerContributor'.$counter.'" hr="true" />';
				$this->configFieldSets[] = "\t\t".'<field name="contributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="spacer"';
				$this->configFieldSets[] = "\t\t\t".'class="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_'.$COUNTER.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="titleContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_TITLE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_TITLE_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbTitle.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="nameContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_NAME_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_NAME_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbName.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="emailContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="email"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_EMAIL_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_EMAIL_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbEmail.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="linkContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="url"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_LINK_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_LINK_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbWebsite.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="useContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="'.(int) $contributor['use'].'"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_USE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_USE_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_USE_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_USE_EMAIL</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_USE_WWW</option>';
				$this->configFieldSets[] = "\t\t</field>";
				$this->configFieldSets[] = "\t\t".'<field name="showContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="'.(int) $contributor['show'].'"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_SHOW_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_SHOW_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_SHOW_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_SHOW_BACK</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_SHOW_FRONT</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="3">'.$langCont.'_SHOW_ALL</option>';
				$this->configFieldSets[] = "\t\t</field>";
				// add the contributor
				$this->theContributors .= "\n\t@".strtolower($contributor['title'])."\t\t".$contributor['name'].' <'.$contributor['website'].'>';
				// setup lang
				$Counter = ComponentbuilderHelper::safeString($counter,'Ww');
				$this->langContent[$this->lang][$langCont.'_'.$COUNTER]	= "Contributor ".$Counter;
				// load the Global checkin defautls
				$this->paramsBuilder .= ',"titleContributor'.$counter.'":"'.$cbTitle.'"';
				$this->paramsBuilder .= ',"nameContributor'.$counter.'":"'.$cbName.'"';
				$this->paramsBuilder .= ',"emailContributor'.$counter.'":"'.$cbEmail.'"';
				$this->paramsBuilder .= ',"linkContributor'.$counter.'":"'.$cbWebsite.'"';
				$this->paramsBuilder .= ',"useContributor'.$counter.'":"'.(int) $contributor['use'].'"';
				$this->paramsBuilder .= ',"showContributor'.$counter.'":"'.(int) $contributor['show'].'"';
			}
		}
		// add more contributors if required
		if (1 == $this->componentData->emptycontributors)
		{
			if (isset($counter)){
				$min = $counter + 1;
				unset($counter);
			}
			else
			{
				$min = 1;
			}
			$max = $min + $this->componentData->number - 1;
			$moreContributerFields = range($min,$max, 1);
			foreach ($moreContributerFields as $counter)
			{
				$COUNTER = ComponentbuilderHelper::safeString($counter,'U');

				$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerContributor'.$counter.'" hr="true" />';
				$this->configFieldSets[] = "\t\t".'<field name="contributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="spacer"';
				$this->configFieldSets[] = "\t\t\t".'class="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_'.$COUNTER.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="titleContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_TITLE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_TITLE_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="nameContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_NAME_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_NAME_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="emailContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="email"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_EMAIL_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_EMAIL_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="linkContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="url"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_LINK_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_LINK_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="useContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="0"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_USE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_USE_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_USE_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_USE_EMAIL</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_USE_WWW</option>';
				$this->configFieldSets[] = "\t\t</field>";
				$this->configFieldSets[] = "\t\t".'<field name="showContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="0"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_SHOW_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_SHOW_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_SHOW_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_SHOW_BACK</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_SHOW_FRONT</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="3">'.$langCont.'_SHOW_ALL</option>';
				$this->configFieldSets[] = "\t\t</field>";
				// setup lang
				$Counter = ComponentbuilderHelper::safeString($counter,'Ww');
				$this->langContent[$this->lang][$langCont.'_'.$COUNTER]	= "Contributor ".$Counter;
			}
		}
		if ($this->addContributors || $this->componentData->emptycontributors == 1)
		{
			// setup lang
			$this->langContent[$this->lang][$langCont.'_TITLE_LABEL']	= "Contributor Job Title";
			$this->langContent[$this->lang][$langCont.'_TITLE_DESC']	= "The job title that best describes the contributor's relationship to this component.";
			$this->langContent[$this->lang][$langCont.'_NAME_LABEL']	= "Contributor Name";
			$this->langContent[$this->lang][$langCont.'_NAME_DESC']		= "The name of this contributor.";
			$this->langContent[$this->lang][$langCont.'_EMAIL_LABEL']	= "Contributor Email";
			$this->langContent[$this->lang][$langCont.'_EMAIL_DESC']	= "The email of this contributor.";
			$this->langContent[$this->lang][$langCont.'_LINK_LABEL']	= "Contributor Website";
			$this->langContent[$this->lang][$langCont.'_LINK_DESC']		= "The link to this contributor's website.";
			$this->langContent[$this->lang][$langCont.'_USE_LABEL']		= "Use";
			$this->langContent[$this->lang][$langCont.'_USE_DESC']		= "How should we link to this contributor.";
			$this->langContent[$this->lang][$langCont.'_USE_NONE']		= "None";
			$this->langContent[$this->lang][$langCont.'_USE_EMAIL']		= "Email";
			$this->langContent[$this->lang][$langCont.'_USE_WWW']		= "Website";
			$this->langContent[$this->lang][$langCont.'_SHOW_LABEL']	= "Show";
			$this->langContent[$this->lang][$langCont.'_SHOW_DESC']		= "Select where you want this contributor's details to show in the component.";
			$this->langContent[$this->lang][$langCont.'_SHOW_NONE']		= "Hide";
			$this->langContent[$this->lang][$langCont.'_SHOW_BACK']		= "Back-end";
			$this->langContent[$this->lang][$langCont.'_SHOW_FRONT']	= "Front-end";
			$this->langContent[$this->lang][$langCont.'_SHOW_ALL']		= "Both Front & Back-end";
		}
		// close that fieldset
		$this->configFieldSets[] = "\t</fieldset>";
	}
	
	protected function setUikitConfigFieldsets($lang)
	{
		if ($this->uikit)
		{
			// main lang prefix
			$lang = $lang.'';
			// start building field set for uikit functions
			$this->configFieldSets[] = "\t<fieldset";
			$this->configFieldSets[] = "\t\t".'name="uikit_config"';
			$this->configFieldSets[] = "\t\t".'label="'.$lang.'_UIKIT_LABEL"';
			$this->configFieldSets[] = "\t\t".'description="'.$lang.'_UIKIT_DESC">';
			// set tab lang
			$this->langContent[$this->lang][$lang.'_UIKIT_LABEL']	= "Uikit Settings";
			$this->langContent[$this->lang][$lang.'_UIKIT_DESC']	= "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href=\"http://getuikit.com/\" >http://getuikit.com/</a>";

			// set field lang
			$this->langContent[$this->lang][$lang.'_UIKIT_LOAD_LABEL']	= "Loading Options";
			$this->langContent[$this->lang][$lang.'_UIKIT_LOAD_DESC']	= "Set the uikit loading option.";
			$this->langContent[$this->lang][$lang.'_AUTO_LOAD']		= "Auto";
			$this->langContent[$this->lang][$lang.'_FORCE_LOAD']		= "Force";
			$this->langContent[$this->lang][$lang.'_DONT_LOAD']		= "Not";
			$this->langContent[$this->lang][$lang.'_ONLY_EXTRA']		= "Only Extra";
			// set the field
			$this->configFieldSets[] = "\t\t".'<field name="uikit_load"';
			$this->configFieldSets[] = "\t\t\t".'type="radio"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_UIKIT_LOAD_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_UIKIT_LOAD_DESC"';
			$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = "\t\t\t".'default="">';
			$this->configFieldSets[] = "\t\t\t".'<!--'.$this->setLine(__LINE__).' Option Set. -->';
			$this->configFieldSets[] = "\t\t\t".'<option value="">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_AUTO_LOAD</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value="1">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_FORCE_LOAD</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value="3">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_ONLY_EXTRA</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value="2">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_DONT_LOAD</option>"';
			$this->configFieldSets[] = "\t\t</field>";
			// set params defaults
			$this->paramsBuilder .= ',"uikit_load":"1"';

			// set field lang
			$this->langContent[$this->lang][$lang.'_UIKIT_MIN_LABEL']	= "Load Minified";
			$this->langContent[$this->lang][$lang.'_UIKIT_MIN_DESC']	= "Should the minified version of uikit files be loaded?";
			$this->langContent[$this->lang][$lang.'_YES']			= "Yes";
			$this->langContent[$this->lang][$lang.'_NO']			= "No";
			// set the field
			$this->configFieldSets[] = "\t\t".'<field name="uikit_min"';
			$this->configFieldSets[] = "\t\t\t".'type="radio"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_UIKIT_MIN_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_UIKIT_MIN_DESC"';
			$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = "\t\t\t".'default="">';
			$this->configFieldSets[] = "\t\t\t".'<!--'.$this->setLine(__LINE__).' Option Set. -->';
			$this->configFieldSets[] = "\t\t\t".'<option value="">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_NO</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value=".min">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_YES</option>"';
			$this->configFieldSets[] = "\t\t</field>";
			// set params defaults
			$this->paramsBuilder .= ',"uikit_min":""';
			// set field lang
			$this->langContent[$this->lang][$lang.'_UIKIT_STYLE_LABEL']	= "css Style";
			$this->langContent[$this->lang][$lang.'_UIKIT_STYLE_DESC']	= "Set the css style that should be used.";
			$this->langContent[$this->lang][$lang.'_FLAT_LOAD']		= "Flat";
			$this->langContent[$this->lang][$lang.'_ALMOST_FLAT_LOAD']	= "Almost Flat";
			$this->langContent[$this->lang][$lang.'_GRADIANT_LOAD']		= "Gradient";
			// set the field
			$this->configFieldSets[] = "\t\t".'<field name="uikit_style"';
			$this->configFieldSets[] = "\t\t\t".'type="radio"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_UIKIT_STYLE_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_UIKIT_STYLE_DESC"';
			$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = "\t\t\t".'default="">';
			$this->configFieldSets[] = "\t\t\t".'<!--'.$this->setLine(__LINE__).' Option Set. -->';
			$this->configFieldSets[] = "\t\t\t".'<option value="">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_FLAT_LOAD</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value=".almost-flat">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_ALMOST_FLAT_LOAD</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value=".gradient">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_GRADIANT_LOAD</option>"';
			$this->configFieldSets[] = "\t\t</field>";
			// set params defaults
			$this->paramsBuilder .= ',"uikit_style":""';
			// add custom Uikit Settings fields
			if (isset($this->configFieldSetsCustomField['Uikit Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Uikit Settings']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Uikit Settings']);
				unset($this->configFieldSetsCustomField['Uikit Settings']);
			}
			// close that fieldset
			$this->configFieldSets[] = "\t</fieldset>";
		}

	}
	
	protected function setGooglechartConfigFieldsets($lang)
	{
		if ($this->googlechart)
		{
			$this->configFieldSets[] = "\n\t<fieldset";
			$this->configFieldSets[] = "\t\tname=\"googlechart_config\"";
			$this->configFieldSets[] = "\t\tlabel=\"".$lang."_CHART_SETTINGS_LABEL\"";
			$this->configFieldSets[] = "\t\tdescription=\"".$lang."_CHART_SETTINGS_DESC\">";
			$this->configFieldSets[] = "\t\t";
			$this->configFieldSets[] = "\t\t<field type=\"note\" name=\"chart_admin_naote\" class=\"alert alert-info\" label=\"".$lang."_ADMIN_CHART_NOTE_LABEL\" description=\"".$lang."_ADMIN_CHART_NOTE_DESC\"  />";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartbackground Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartbackground\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#F7F7FA\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTBACKGROUND_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTBACKGROUND_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_mainwidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_mainwidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_MAINWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_MAINWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add area width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_MAINWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_a Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_a\" hr=\"true\" class=\"spacer_chartadmin_hr_a\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartareatop Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartareatop\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREATOP_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREATOP_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add top spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREATOP_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartarealeft Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartarealeft\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREALEFT_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREALEFT_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add left spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREALEFT_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartareawidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartareawidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREAWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREAWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add chart width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREAWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_b Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_b\" hr=\"true\" class=\"spacer_chartadmin_hr_b\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_legendtextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_legendtextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_legendtextstylefontsize Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_legendtextstylefontsize\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add size of the legend here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_c Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_c\" hr=\"true\" class=\"spacer_chartadmin_hr_c\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_vaxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_vaxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_d Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_d\" hr=\"true\" class=\"spacer_chartadmin_hr_d\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_haxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_haxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_haxistitletextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_haxistitletextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>";
			$this->configFieldSets[] = "\t\t";
			$this->configFieldSets[] = "\t\t<field type=\"note\" name=\"chart_site_note\" class=\"alert alert-info\" label=\"".$lang."_SITE_CHART_NOTE_LABEL\" description=\"".$lang."_SITE_CHART_NOTE_DESC\"  />";
			$this->configFieldSets[] = "\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartbackground Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartbackground\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#F7F7FA\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTBACKGROUND_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTBACKGROUND_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_mainwidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_mainwidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_MAINWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_MAINWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add area width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_MAINWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_a Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_a\" hr=\"true\" class=\"spacer_chartsite_hr_a\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartareatop Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartareatop\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREATOP_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREATOP_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add top spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREATOP_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartarealeft Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartarealeft\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREALEFT_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREALEFT_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add left spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREALEFT_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartareawidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartareawidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREAWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREAWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add chart width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREAWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_b Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_b\" hr=\"true\" class=\"spacer_chartsite_hr_b\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_legendtextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_legendtextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_legendtextstylefontsize Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_legendtextstylefontsize\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add size of the legend here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_c Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_c\" hr=\"true\" class=\"spacer_chartsite_hr_c\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_vaxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_vaxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_d Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_d\" hr=\"true\" class=\"spacer_chartsite_hr_d\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_haxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_haxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_haxistitletextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_haxistitletextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>";
			
			// add custom Encryption Settings fields
			if (isset($this->configFieldSetsCustomField['Chart Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Chart Settings']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Chart Settings']);
				unset($this->configFieldSetsCustomField['Chart Settings']);
			}
			
			$this->configFieldSets[] = "\t</fieldset>";

			// set params defaults
			$this->paramsBuilder .= ',"admin_chartbackground":"#F7F7FA","admin_mainwidth":"1000","admin_chartareatop":"20","admin_chartarealeft":"20","admin_chartareawidth":"170","admin_legendtextstylefontcolor":"10","admin_legendtextstylefontsize":"20","admin_vaxistextstylefontcolor":"#63B1F2","admin_haxistextstylefontcolor":"#63B1F2","admin_haxistitletextstylefontcolor":"#63B1F2","site_chartbackground":"#F7F7FA","site_mainwidth":"1000","site_chartareatop":"20","site_chartarealeft":"20","site_chartareawidth":"170","site_legendtextstylefontcolor":"10","site_legendtextstylefontsize":"20","site_vaxistextstylefontcolor":"#63B1F2","site_haxistextstylefontcolor":"#63B1F2","site_haxistitletextstylefontcolor":"#63B1F2"';

			// set field lang
			$this->langContent[$this->lang][$lang.'_CHART_SETTINGS_LABEL']			= "Chart Settings";
			$this->langContent[$this->lang][$lang.'_CHART_SETTINGS_DESC']			= "The Google Chart Display Settings Are Made Here.";
			$this->langContent[$this->lang][$lang.'_ADMIN_CHART_NOTE_LABEL']		= "Admin Settings";
			$this->langContent[$this->lang][$lang.'_ADMIN_CHART_NOTE_DESC']			= "The following settings are used on the back-end of the site called (admin).";
			$this->langContent[$this->lang][$lang.'_SITE_CHART_NOTE_LABEL']			= "Site Settings";
			$this->langContent[$this->lang][$lang.'_SITE_CHART_NOTE_DESC']			= "The following settings are used on the front-end of the site called (site).";

			$this->langContent[$this->lang][$lang.'_CHARTAREALEFT_DESC']			= "Set in pixels the spacing from the left of the chart area to the beginning of the chart it self. Please don't add the px sign";
			$this->langContent[$this->lang][$lang.'_CHARTAREALEFT_HINT']			= "170";
			$this->langContent[$this->lang][$lang.'_CHARTAREALEFT_LABEL']			= "Left Spacing";
			$this->langContent[$this->lang][$lang.'_CHARTAREATOP_DESC']			= "Set in pixels the spacing from the top of the chart area to the beginning of the chart it self. Please don't add the px sign";
			$this->langContent[$this->lang][$lang.'_CHARTAREATOP_HINT']			= "20";
			$this->langContent[$this->lang][$lang.'_CHARTAREATOP_LABEL']			= "Top Spacing";
			$this->langContent[$this->lang][$lang.'_CHARTAREAWIDTH_DESC']			= "Set in % the width of the chart it self inside the chart area. Please don't add the % sign";
			$this->langContent[$this->lang][$lang.'_CHARTAREAWIDTH_HINT']			= "60";
			$this->langContent[$this->lang][$lang.'_CHARTAREAWIDTH_LABEL']			= "Chart Width";
			$this->langContent[$this->lang][$lang.'_CHARTBACKGROUND_DESC']			= "Select the chart background color here.";
			$this->langContent[$this->lang][$lang.'_CHARTBACKGROUND_LABEL']			= "Chart Background";
			$this->langContent[$this->lang][$lang.'_HAXISTEXTSTYLEFONTCOLOR_DESC']		= "Select the horizontal axis font color.";
			$this->langContent[$this->lang][$lang.'_HAXISTEXTSTYLEFONTCOLOR_LABEL']		= "hAxis Font Color";
			$this->langContent[$this->lang][$lang.'_HAXISTITLETEXTSTYLEFONTCOLOR_DESC']     = "Select the horizontal axis title's font color.";
			$this->langContent[$this->lang][$lang.'_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL']    = "hAxis Title Font Color";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTCOLOR_DESC']		= "Select the legend font color.";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTCOLOR_LABEL']        = "Legend Font Color";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTSIZE_DESC']		= "Set in pixels the font size of the legend";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTSIZE_HINT']		= "10";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTSIZE_LABEL']		= "Legend Font Size";
			$this->langContent[$this->lang][$lang.'_MAINWIDTH_DESC']			= "Set the width of the entire chart area";
			$this->langContent[$this->lang][$lang.'_MAINWIDTH_HINT']			= "1000";
			$this->langContent[$this->lang][$lang.'_MAINWIDTH_LABEL']			= "Chart Area Width";
			$this->langContent[$this->lang][$lang.'_VAXISTEXTSTYLEFONTCOLOR_DESC']		= "Select the vertical axis font color.";
			$this->langContent[$this->lang][$lang.'_VAXISTEXTSTYLEFONTCOLOR_LABEL']		= "vAxis Font Color";
		}
	}
	
	protected function setEncryptionConfigFieldsets($lang)
	{
		// Add encryption if needed
		if ((isset($this->basicEncryption) && $this->basicEncryption) || (isset($this->advancedEncryption) && $this->advancedEncryption))
		{
			// start building field set for uikit functions
			$this->configFieldSets[] = "\t<fieldset";
			$this->configFieldSets[] = "\t\t".'name="encryption_config"';
			$this->configFieldSets[] = "\t\t".'label="'.$lang.'_ENCRYPTION_LABEL"';
			$this->configFieldSets[] = "\t\t".'description="'.$lang.'_ENCRYPTION_DESC">';
			// set tab lang
			$this->langContent[$this->lang][$lang.'_ENCRYPTION_LABEL']	= "Encryption Settings";
			$this->langContent[$this->lang][$lang.'_ENCRYPTION_DESC']	= "The encription key for the field encryption is set here.";

			if (isset($this->basicEncryption) && $this->basicEncryption)
			{
				// set field lang
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_LABEL']	= "Basic Key <small>(basic encryption)</small>";
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_DESC']	= "Set the basic local key here.";
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_NOTE_LABEL']	= "Basic Encryption";
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_NOTE_DESC']	= "When using the basic encryption please use a 32 character passphrase.<br />Never change this passphrase once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>";
				// set the field
				$this->configFieldSets[] = "\t\t".'<field type="note" name="basic_key_note" class="alert alert-info" label="'.$lang.'_BASIC_KEY_NOTE_LABEL" description="'.$lang.'_BASIC_KEY_NOTE_DESC"  />';
				$this->configFieldSets[] = "\t\t".'<field name="basic_key"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_BASIC_KEY_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_BASIC_KEY_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
			}

			if (isset($this->advancedEncryption) && $this->advancedEncryption)
			{
				// set field lang
				$this->langContent[$this->lang][$lang.'_VDM_KEY_LABEL']		= "VDM Key <small>(advanced encryption)</small>";
				$this->langContent[$this->lang][$lang.'_VDM_KEY_DESC']		= "Add the VDM public key here.";
				$this->langContent[$this->lang][$lang.'_VDM_KEY_NOTE_LABEL']	= "Advanced Encryption";
				$this->langContent[$this->lang][$lang.'_VDM_KEY_NOTE_DESC']	= "When using the advanced encryption you need to get a VDM public key from https://www.vdm.io/encryption/<br />Never change this public key once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>";
				// set the field
				$this->configFieldSets[] = "\t\t".'<field type="note" name="vdm_key_note" class="alert alert-info" label="'.$lang.'_VDM_KEY_NOTE_LABEL" description="'.$lang.'_VDM_KEY_NOTE_DESC"  />';
				$this->configFieldSets[] = "\t\t".'<field name="advanced_key"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_VDM_KEY_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_VDM_KEY_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
			}
			// add custom Encryption Settings fields
			if (isset($this->configFieldSetsCustomField['Encryption Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Encryption Settings']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Encryption Settings']);
				unset($this->configFieldSetsCustomField['Encryption Settings']);
			}
			// close that fieldset
			$this->configFieldSets[] = "\t</fieldset>";
		}
	}

	protected function setAccessSectionsCategory($viewName_single, $viewName_list)
	{
		$component = '';
		// check if view has category
		if (array_key_exists($viewName_single, $this->catCodeBuilder))
		{
			$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
			if ($otherViews == $viewName_list)
			{
				$component .= "\n\t".'<section name="category.'.$otherViews.'">';
				$component .= "\n\t\t".'<action name="core.create" title="JACTION_CREATE" description="JACTION_CREATE_COMPONENT_DESC" />';
				$component .= "\n\t\t".'<action name="core.delete" title="JACTION_DELETE" description="COM_CATEGORIES_ACCESS_DELETE_DESC" />';
				$component .= "\n\t\t".'<action name="core.edit" title="JACTION_EDIT" description="COM_CATEGORIES_ACCESS_EDIT_DESC" />';
				$component .= "\n\t\t".'<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_CATEGORIES_ACCESS_EDITSTATE_DESC" />';
				$component .= "\n\t\t".'<action name="core.edit.own" title="JACTION_EDITOWN" description="COM_CATEGORIES_ACCESS_EDITOWN_DESC" />';
				$component .= "\n\t</section>";
			}
		}
		return $component;
	}

	protected function setAccessSections()
	{
		// set the default component access values
		$componentHead  = array();
		$componentHead[] = '<section name="component">';
		$componentHead[] = "\t\t".'<action name="core.admin" title="JACTION_ADMIN" description="JACTION_ADMIN_COMPONENT_DESC" />';
		$componentHead[] = "\t\t".'<action name="core.options" title="JACTION_OPTIONS" description="JACTION_OPTIONS_COMPONENT_DESC" />';
		$componentHead[] = "\t\t".'<action name="core.manage" title="JACTION_MANAGE" description="JACTION_MANAGE_COMPONENT_DESC" />';
		if ($this->addEximport)
		{
			$exportTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Export Data','U');
			$exportDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Export Data','U').'_DESC';
			$this->langContent['admin'][$exportTitle]	= 'Export Data';
			$this->langContent['admin'][$exportDesc]	= ' Allows users in this group to export data.';
			$componentHead[] = "\t\t".'<action name="core.export" title="'.$exportTitle.'" description="'.$exportDesc.'" />';

			$importTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Import Data','U');
			$importDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Import Data','U').'_DESC';
			$this->langContent['admin'][$importTitle]	= 'Import Data';
			$this->langContent['admin'][$importDesc]	= ' Allows users in this group to import data.';
			$componentHead[] = "\t\t".'<action name="core.import" title="'.$importTitle.'" description="'.$importDesc.'" />';
		}
		// version permission
		$batchTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Use Batch','U');
		$batchDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Use Batch','U').'_DESC';
		$this->langContent['admin'][$batchTitle]	= 'Use Batch';
		$this->langContent['admin'][$batchDesc]	= ' Allows users in this group to use batch copy/update method.';
		$componentHead[] = "\t\t".'<action name="core.batch" title="'.$batchTitle.'" description="'.$batchDesc.'" />';
		// version permission
		$importTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Versions','U');
		$importDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Versions','U').'_DESC';
		$this->langContent['admin'][$importTitle]	= 'Edit Version';
		$this->langContent['admin'][$importDesc]	= ' Allows users in this group to edit versions.';
		$componentHead[] = "\t\t".'<action name="core.version" title="'.$importTitle.'" description="'.$importDesc.'" />';
		// set the defaults
		$componentHead[] = "\t\t".'<action name="core.create" title="JACTION_CREATE" description="JACTION_CREATE_COMPONENT_DESC" />';
		$componentHead[] = "\t\t".'<action name="core.delete" title="JACTION_DELETE" description="JACTION_DELETE_COMPONENT_DESC" />';
		$componentHead[] = "\t\t".'<action name="core.edit" title="JACTION_EDIT" description="JACTION_EDIT_COMPONENT_DESC" />';
		$componentHead[] = "\t\t".'<action name="core.edit.state" title="JACTION_EDITSTATE" description="JACTION_ACCESS_EDITSTATE_DESC" />';
		$componentHead[] = "\t\t".'<action name="core.edit.own" title="JACTION_EDITOWN" description="JACTION_EDITOWN_COMPONENT_DESC" />';
		// new custom created by permissions
		$created_byTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created By','U');
		$created_byDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created By','U').'_DESC';
		$this->langContent['admin'][$created_byTitle]	= 'Edit Created By';
		$this->langContent['admin'][$created_byDesc]	= ' Allows users in this group to edit created by.';
		$componentHead[] = "\t\t".'<action name="core.edit.created_by" title="'.$created_byTitle.'" description="'.$created_byDesc.'" />';
		// new custom created date permissions
		$createdTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created Date','U');
		$createdDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created Date','U').'_DESC';
		$this->langContent['admin'][$createdTitle]	= 'Edit Created Date';
		$this->langContent['admin'][$createdDesc]	= ' Allows users in this group to edit created date.';
		$componentHead[] = "\t\t".'<action name="core.edit.created" title="'.$createdTitle.'" description="'.$createdDesc.'" />';
		// setup the view array
		$views = array();
		$componentGlobal = array();
		// set the menu controller lookup
		$menuControllers = array('submenu','dashboard_list','dashboard_add');
                // set the custom admin views permissions
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
                        foreach ($this->componentData->custom_admin_views as $custom_admin_view)
			{
                                // new custom permissions to access this view
                                $customAdminName        = $custom_admin_view['settings']->name;
                                $customAdminCode        = $custom_admin_view['settings']->code;
                                $customAdminTitle       = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($customAdminName.' Access','U');
                                $customAdminDesc        = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($customAdminName.' Access','U').'_DESC';
                                $sortKey                = ComponentbuilderHelper::safeString($customAdminName.' Access');
                                $this->langContent['admin'][$customAdminTitle]	= $customAdminName.' Access';
                                $this->langContent['admin'][$customAdminDesc]	= ' Allows the users in this group to access '.ComponentbuilderHelper::safeString($customAdminName,'w').'.';
                                $componentGlobal[$sortKey]                      = "\t\t".'<action name="'.$customAdminCode.'.access" title="'.$customAdminTitle.'" description="'.$customAdminDesc.'" />';
                                // add the custom permissions to use the buttons of this view
                                if (ComponentbuilderHelper::checkArray($custom_admin_view['settings']->custom_buttons))
                                {
                                       foreach ($custom_admin_view['settings']->custom_buttons as $custom_buttons)
                                       {
                                                $customAdminButtonName  = $custom_buttons['name'];
                                                $customAdminButtonCode  = ComponentbuilderHelper::safeString($customAdminButtonName);
                                                $customAdminButtonTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($customAdminName.' '.$customAdminButtonName.' Button Access','U');
                                                $customAdminButtonDesc  = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($customAdminName.' '.$customAdminButtonName.' Button Access','U').'_DESC';
                                                $sortButtonKey          = ComponentbuilderHelper::safeString($customAdminName.' '.$customAdminButtonName.' Button Access');
                                                $this->langContent['admin'][$customAdminButtonTitle]	= $customAdminName.' '.$customAdminButtonName.' Button Access';
                                                $this->langContent['admin'][$customAdminButtonDesc]	= ' Allows the users in this group to access the '.ComponentbuilderHelper::safeString($customAdminButtonName,'w').' button.';
                                                $componentGlobal[$sortButtonKey]  = "\t\t".'<action name="'.$customAdminCode.'.'.$customAdminButtonCode.'" title="'.$customAdminButtonTitle.'" description="'.$customAdminButtonDesc.'" />';
                                       }
                                }
				// add menu controll view that has menus options
				foreach ($menuControllers  as $menuController)
				{
					// add menu controll view that has menus options
					if (isset($custom_admin_view[$menuController]) && $custom_admin_view[$menuController])
					{
						// TODO for CUSTOM MENUS!!!
					}
				}
                        }
                }
		// set the site views permissions
		if (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views))
		{
                        foreach ($this->componentData->site_views as $site_view)
			{
                                // new custom permissions to access this view
                                $siteName       = $site_view['settings']->name;
                                $siteCode       = $site_view['settings']->code;
				$siteTitle      = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($siteName.' Access Site','U');
				$siteDesc       = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($siteName.' Access Site','U').'_DESC';
				$sortKey        = ComponentbuilderHelper::safeString($siteName.' Access Site');
				$this->langContent['admin'][$siteTitle]	= $siteName.' (Site) Access';
				$this->langContent['admin'][$siteDesc]	= ' Allows the users in this group to access site '.ComponentbuilderHelper::safeString($siteName,'w').'.';
				$componentGlobal[$sortKey]              = "\t\t".'<action name="site.'.$siteCode.'.access" title="'.$siteTitle.'" description="'.$siteDesc.'" />';
                                // add the custom permissions to use the buttons of this view
                                /* if (ComponentbuilderHelper::checkArray($site_view['settings']->custom_buttons))
                                {
                                       foreach ($site_view['settings']->custom_buttons as $custom_buttons)
                                       {
                                                $siteButtonName  = $custom_buttons['name'];
                                                $siteButtonCode  = ComponentbuilderHelper::safeString($siteButtonName);
                                                $siteButtonTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($siteName.' '.$siteButtonName.' Button Access','U');
                                                $siteButtonDesc  = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($siteName.' '.$siteButtonName.' Button Access','U').'_DESC';
                                                $sortButtonKey   = ComponentbuilderHelper::safeString($siteButtonTitle);
                                                $this->langContent['admin'][$siteButtonTitle]	= $siteName.' '.$siteButtonName.' Button Access';
                                                $this->langContent['admin'][$siteButtonDesc]	= ' Allows the users in this group to access the '.ComponentbuilderHelper::safeString($siteButtonName,'w').' button.';
                                                $componentGlobal[$sortButtonKey]  = "\t\t".'<action name="'.$siteCode.'.'.$siteButtonCode.'" title="'.$siteButtonTitle.'" description="'.$siteButtonDesc.'" />';
                                       }
                                }
				// add menu controll view that has menus options
				foreach ($menuControllers  as $menuController)
				{
					// add menu controll view that has menus options
					if ($site_view[$menuController])
					{
						// TODO for CUSTOM MENUS!!!
					}
				} */
                        }
                }
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			foreach ($this->componentData->admin_views as $view)
			{
				// set view name
				$nameView = ComponentbuilderHelper::safeString($view['settings']->name_single);
				$nameViews = ComponentbuilderHelper::safeString($view['settings']->name_list);
				if ($nameView != 'component')
				{

					// add menu controll view that has menus options
					foreach ($menuControllers  as $menuController)
					{
						// add menu controll view that has menus options
						if ($view[$menuController])
						{
							$targetView_ = 'views.';
							if ($menuController == 'dashboard_add')
							{
								$targetView_ = 'view.';
							}
							// menucontroller
							$menucontrollerView['action'] = $targetView_.$menuController;
							$menucontrollerView['implementation'] = '2';
							if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
							{
								array_push($view['settings']->permissions,$menucontrollerView);
							}
							else
							{
								$view['settings']->permissions = array();
								$view['settings']->permissions[] = $menucontrollerView;
							}
							unset($menucontrollerView);
						}
					}
					// check if there are fields
					if (ComponentbuilderHelper::checkArray($view['settings']->fields))
					{
						// check the fields for their permission settings
						foreach($view['settings']->fields as $field)
						{
							// see if field require permissions to be set
							if (isset($field['permission']) && $field['permission'])
							{
								if (ComponentbuilderHelper::checkArray($field['settings']->properties))
								{
									foreach ($field['settings']->properties as $property)
									{
										if ($property['name'] == 'type')
										{
											$propertyType = $property;
										}
									}
									$fieldType = $this->getFieldType($field['settings']->type_name,$field['settings']->xml,$propertyType);
									$fieldName = $this->getFieldName($fieldType,$field['settings']->xml,$field['alias']);
									$fieldView = array();
									// set the permission for this field
									$fieldView['action'] = 'view.edit.'.$fieldName;
									$fieldView['implementation'] = '3';
									if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
									{
										array_push($view['settings']->permissions,$fieldView);
									}
									else
									{
										$view['settings']->permissions = array();
										$view['settings']->permissions[] = $fieldView;
									}
									// load to global field permission set
									$this->permissionFields[$nameView][$fieldName] = $fieldType;
								}
							}
						}
					}
					if (ComponentbuilderHelper::checkArray($view['settings']->permissions) || $view['port'] || $view['history'])
					{
						// add export/import permissions to each view that has export/import options
						if ($view['port'])
						{
							// export
							$exportView['action'] = 'view.export';
							$exportView['implementation'] = '2';
							if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
							{
								array_push($view['settings']->permissions,$exportView);
							}
							else
							{
								$view['settings']->permissions = array();
								$view['settings']->permissions[] = $exportView;
							}
							// import
							$importView['action'] = 'view.import';
							$importView['implementation'] = '2';
							if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
							{
								array_push($view['settings']->permissions,$importView);
							}
							else
							{
								$view['settings']->permissions = array();
								$view['settings']->permissions[] = $importView;
							}
						}
						// add version opstions to each view that has it added
						if ($view['history'])
						{
							// set version control
							$versionView['action'] = 'view.version';
							$versionView['implementation'] = '3';
							if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
							{
								array_push($view['settings']->permissions,$versionView);
							}
							else
							{
								$view['settings']->permissions = array();
								$view['settings']->permissions[] = $versionView;
							}
						}
						// set batch control
						$batchView['action'] = 'view.batch';
						$batchView['implementation'] = '2';
						if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
						{
							array_push($view['settings']->permissions,$batchView);
						}
						else
						{
							$view['settings']->permissions = array();
							$view['settings']->permissions[] = $batchView;
						}

						foreach ($view['settings']->permissions as $permission)
						{
							// set acction name
							$arr = explode('.',trim($permission['action']));
							if ($arr[0] != 'core' || $arr[0] == 'view')
							{
								array_shift($arr);
								$actionMain = implode('.',$arr);
								$action = $nameView.'.'.$actionMain;
							}
							else
							{
								if ($arr[0] == 'core')
								{
									// core is already set in global access
									$permission['implementation'] = 1;
								}
								$action = $permission['action'];
							}
							// build action name
							$actionNameBuilder = explode('.',trim($permission['action']));
							array_shift($actionNameBuilder);
							$nameBuilder = trim(implode('___',$actionNameBuilder));
							$customName = trim(implode(' ',$actionNameBuilder));
							$W_NameList = ComponentbuilderHelper::safeString($view['settings']->name_list, 'W');
							$w_NameList = ComponentbuilderHelper::safeString($customName.' '.$view['settings']->name_list, 'w');
							$w_NameSingle = ComponentbuilderHelper::safeString($view['settings']->name_single, 'w');
							switch ($nameBuilder)
							{
								case 'edit':
								// set edit title
								$permission['title'] =  $W_NameList . ' Edit';
								// set edit description
								$permission['description'] = ' Allows the users in this group to edit the ' . $w_NameSingle;
								break;
								case 'edit___own':
								// set edit title
								$permission['title'] = $W_NameList . ' Edit Own';
								// set edit description
								$permission['description'] = ' Allows the users in this group to edit ' . $w_NameList . ' created by them';
								break;
								case 'edit___state':
								// set edit title
								$permission['title'] = $W_NameList . ' Edit State';
								// set edit description
								$permission['description'] = ' Allows the users in this group to update the state of the ' . $w_NameSingle;
								break;
								case 'edit___created_by':
								// set edit title
								$permission['title'] = $W_NameList . ' Edit Created By';
								// set edit description
								$permission['description'] = ' Allows the users in this group to update the created by of the ' . $w_NameList;
								break;
								case 'edit___created':
								// set edit title
								$permission['title'] = $W_NameList . ' Edit Created Date';
								// set edit description
								$permission['description'] = ' Allows the users in this group to update the created date of the ' . $w_NameList;
								break;
								case 'create':
								// set edit title
								$permission['title'] = $W_NameList . ' Create';
								// set edit description
								$permission['description'] = ' Allows the users in this group to create ' . $w_NameList;
								break;
								case 'delete':
								// set edit title
								$permission['title'] = $W_NameList . ' Delete';
								// set edit description
								$permission['description'] = ' Allows the users in this group to delete ' . $w_NameList;
								break;
								case 'access':
								// set edit title
								$permission['title'] = $W_NameList . ' Access';
								// set edit description
								$permission['description'] = ' Allows the users in this group to access ' . $w_NameList;
								break;
								case 'export':
								// set edit title
								$permission['title'] = $W_NameList . ' Export';
								// set edit description
								$permission['description'] = ' Allows the users in this group to export ' . $w_NameList;
								break;
								case 'import':
								// set edit title
								$permission['title'] = $W_NameList . ' Import';
								// set edit description
								$permission['description'] = ' Allows the users in this group to import ' . $w_NameList;
								break;
								case 'version':
								// set edit title
								$permission['title'] = $W_NameList . ' Edit Version';
								// set edit description
								$permission['description'] = ' Allows users in this group to edit versions of ' . $w_NameList;
								break;
								case 'batch':
								// set edit title
								$permission['title'] = $W_NameList . ' Batch Use';
								// set edit description
								$permission['description'] = ' Allows users in this group to use batch copy/update method of ' . $w_NameList;
								break;
								default:
								// set edit title
								$permission['title'] = $W_NameList . ' ' . ComponentbuilderHelper::safeString($customName, 'W');
								// set edit description
								$permission['description'] = ' Allows the users in this group to update the ' . ComponentbuilderHelper::safeString($customName, 'w') . ' of the ' . $w_NameSingle;
								break;
							}
							// if core is not used update all core strings
							$coreCheck = explode('.',$action);
							$coreCheck[0] = 'core';
							$coreTarget = implode('.',$coreCheck);
							$this->permissionCore[$nameView][$coreTarget] = $action;
							// set array sort name
							$sortKey = ComponentbuilderHelper::safeString($permission['title']);
							// set title
							$title = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($permission['title'],'U');
							// load the actions
							if ($permission['implementation'] == 1)
							{
								// only related to view
								$views[$nameView][] = '<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
								// load permission to action
								$this->permissionBuilder[$action][$nameView] = $nameView;
							}
							elseif ($permission['implementation'] == 2)
							{
								// relation to whole component
								$componentGlobal[$sortKey] = "\t\t".'<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
								// build permission switch
								$this->permissionBuilder['global'][$action][$nameView] = $nameView;
								// dashboard icon checker
								if ($coreTarget == 'core.access')
								{
									$this->permissionDashboard[] = "'" . $nameViews . ".access' => '" . $action . "'";
									$this->permissionDashboard[] = "'" . $nameView . ".access' => '" . $action . "'";
								}
								if ($coreTarget == 'core.create')
								{
									$this->permissionDashboard[] = "'" . $nameView . ".create' => '" . $action . "'";
								}
								// add menu controll view that has menus options
								foreach ($menuControllers  as $menuController)
								{
									if ($coreTarget == 'core.'.$menuController)
									{
										if ($menuController == 'dashboard_add')
										{
											$this->permissionDashboard[] = "'" . $nameView . ".".$menuController."' => '" . $action . "'";
										}
										else
										{
											$this->permissionDashboard[] = "'" . $nameViews . ".".$menuController."' => '" . $action . "'";
										}
									}
								}
							}
							elseif ($permission['implementation'] == 3)
							{
								// only related to view
								$views[$nameView][] = '<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
								// load permission to action
								$this->permissionBuilder[$action][$nameView] = $nameView;
								// relation to whole component
								$componentGlobal[$sortKey] = "\t\t".'<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
								// build permission switch
								$this->permissionBuilder['global'][$action][$nameView] = $nameView;
								// dashboard icon checker
								if ($coreTarget == 'core.access')
								{
									$this->permissionDashboard[] = "'" . $nameViews . ".access' => '" . $action . "'";
									$this->permissionDashboard[] = "'" . $nameView . ".access' => '" . $action . "'";
								}
								if ($coreTarget == 'core.create')
								{
									$this->permissionDashboard[] = "'" . $nameView . ".create' => '" . $action . "'";
								}
								// add menu controll view that has menus options
								foreach ($menuControllers  as $menuController)
								{
									if ($coreTarget == 'core.'.$menuController)
									{
										if ($menuController == 'dashboard_add')
										{
											$this->permissionDashboard[] = "'" . $nameView . ".".$menuController."' => '" . $action . "'";
										}
										else
										{
											$this->permissionDashboard[] = "'" . $nameViews . ".".$menuController."' => '" . $action . "'";
										}
									}
								}
							}
							// set to language file
							$this->langContent['admin'][$title]			= trim($permission['title']);
							$this->langContent['admin'][$title.'_DESC']	= trim($permission['description']);
						}
					}
				}
			}
			// set the views permissions now
			if (ComponentbuilderHelper::checkArray($views))
			{
				foreach ($views as $viewName => $actions)
				{
					$componentViews[] = "\t".'<section name="'.$viewName.'">';
					foreach ($actions as $action)
					{
						$componentViews[] = "\t\t".$action;
					}
					$componentViews[] = "\t</section>";
				}
			}
			/// now build the section
			$component = implode("\n",$componentHead);
			// sort the array to insure easy search
			ksort($componentGlobal,SORT_STRING);
			// add global to the compnent section
			$component .= "\n".implode("\n",$componentGlobal)."\n\t</section>";
			// add views to the compnent section
			$component .= "\n".implode("\n",$componentViews);
			// return the build
			return $component;
		}
		return false;
	}

	protected function getFieldName($typeName,$xml,$alias)
	{
		// if category then name must be catid (only one per view)
		if ($typeName == 'category')
		{
			return 'catid';

		}
		// if tag is set then enable all tag options for this view (only one per view)
		elseif ($typeName == 'tag')
		{
			return 'tags';
		}
		// if the field is set as alias it must be called alias
		elseif ($alias)
		{
			return 'alias';
		}
		elseif ($typeName == 'spacer')
		{
			// make sure the name is unique
			return false;
		}
		else
		{
			return ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xml,'name="','"'));
		}
	}

	protected function getFieldType($typeName,$xml,$property)
	{
		// make sure its lower case
		$typeName = ComponentbuilderHelper::safeString($typeName);

		if ($typeName == 'custom' || $typeName == 'customuser')
		{
			$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xml,'type="','"'));
		}
		// use field core type only if not found
		elseif (ComponentbuilderHelper::checkString($typeName))
		{
			$xmlValue = $typeName;
		}
		// make sure none adjustable fields are set
		elseif (isset($property['example']) && ComponentbuilderHelper::checkString($property['example']) && $property['adjustable'] == 0)
		{
			$xmlValue = $property['example'];
		}
		// fall back on the xml settings
		else
		{
			$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xml,'type="','"'));
		}

		// check if the value is set
		if (ComponentbuilderHelper::checkString($xmlValue))
		{
			// add the value
			return $xmlValue;
		}
		else
		{
			// fall back to text
			return 'text';
		}
	}

	protected function setJoomlaVersionData()
	{
		// set the version data
		$versionData = json_decode(file_get_contents($this->templatePath.'/settings.json'));
		// add custom folders
		if ((isset($this->componentData->folders) && ComponentbuilderHelper::checkArray($this->componentData->folders)) || $this->addEximport || $this->uikit || $this->footable)
		{
			if ($this->addEximport)
			{
				// move the import view folder in place
				$importView = array( 'folder' => 'importViews', 'path' => 'admin/views/import', 'rename' => 1);
				$this->componentData->folders[] = $importView;
				// move the PHPExel Folder
				$PHPExcel = array( 'folder' => 'PHPExcel', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->folders[] = $PHPExcel;
			}
			if ($this->uikit)
			{
				// move the UIKIT Folder into place
				$uikit = array( 'folder' => 'uikit', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $uikit;
			}
			if ($this->footable)
			{
				// move the footable folder into place
				$footable = array( 'folder' => 'footable', 'path' => 'media', 'rename' => 0);
				$this->componentData->folders[] = $footable;

			}
			
			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->folders as $custom)
			{
				// fix path
				$custom['path'] = rtrim($custom['path'], '/');
				$custom['path'] = ltrim($custom['path'], '/');
				// make sure we use the correct name
				$pathArray = (array) explode('/',$custom['path']);
				$firstFolder = array_values($pathArray)[0];
				$lastFolder = end($pathArray);
				// only rename folder if last has folder name
				if ($custom['rename'] == 1)
				{
					$custom['path'] = str_replace('/'.$lastFolder,'',$custom['path']);
					$rename = 'new';
					$newname = $lastFolder;
					if(($tkey = array_search($lastFolder, $pathArray)) !== false)
					{
						unset($pathArray[$tkey]);
					}
				}
				else
				{
					$lastFolder = $custom['folder'];
					$rename = false;
					$newname = '';
				}
				// check if we sould add it to the media xml list
				if (!isset($this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder == 'media')
				{
					$this->fileContentStatic['###EXSTRA_MEDIA_FOLDERS###'] .= "\n\t\t<folder>".$lastFolder."</folder>";
				}
				// check if we sould add it to the site xml list
				if (!isset($this->fileContentStatic['###EXSTRA_SITE_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_SITE_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder == 'site')
				{
					$this->fileContentStatic['###EXSTRA_SITE_FOLDERS###'] .= "\n\t\t<folder>".$lastFolder."</folder>";
				}
				// check if we sould add it to the admin xml list
				if (!isset($this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###']))
				{
					$this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###'] = '';
				}
				if (count($pathArray) == 1 && $firstFolder == 'admin')
				{
					$this->fileContentStatic['###EXSTRA_ADMIN_FOLDERS###'] .= "\n\t\t\t<folder>".$lastFolder."</folder>";
				}
				// make we have not duplicates
				$key_pointer = ComponentbuilderHelper::safeString($custom['folder']).'_f'.$pointer_tracker;
				$pointer_tracker++;
				// set new folder to object
				$versionData->move->static->$key_pointer = new stdClass();
				$versionData->move->static->$key_pointer->naam = $custom['folder'];
				$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/'.$custom['path'];
				$versionData->move->static->$key_pointer->rename = $rename;
				$versionData->move->static->$key_pointer->newName = $newname;
				$versionData->move->static->$key_pointer->type = 'folder';
				$versionData->move->static->$key_pointer->custom = true;
			}
			unset($this->componentData->folders);
			unset($custom);
		}
		// add custom files
		if ((isset($this->componentData->files) && ComponentbuilderHelper::checkArray($this->componentData->files)) || $this->addEximport || $this->googlechart)
		{
			if ($this->addEximport)
			{
				// move the PHPExel main file
				$PHPExcel = array( 'file' => 'PHPExcel.php', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->files[] = $PHPExcel;
			}
			if ($this->googlechart)
			{
				// move the google chart files
				$googleChart = array( 'file' => 'google.jsapi.js', 'path' => 'media/js', 'rename' => 0);
				$this->componentData->files[] = $googleChart;
				$googleChart = array( 'file' => 'chartbuilder.php', 'path' => 'admin/helpers', 'rename' => 0);
				$this->componentData->files[] = $googleChart;
			}
			
			// pointer tracker
			$pointer_tracker = 'h';
			foreach ($this->componentData->files as $custom)
			{
				// make we have not duplicates
				$key_pointer = ComponentbuilderHelper::safeString($custom['file']).'_g'.$pointer_tracker;
				$pointer_tracker++;
				// set new file to object
				$versionData->move->static->$key_pointer = new stdClass();
				$versionData->move->static->$key_pointer->naam = $custom['file'];
				// get the path info
				$pathInfo = pathinfo($custom['path']);
				if (isset($pathInfo['extension']) && $pathInfo['extension'])
				{
					$pathInfo['dirname'] = rtrim($pathInfo['dirname'], '/');
					$pathInfo['dirname'] = ltrim($pathInfo['dirname'], '/');
					$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/'.$pathInfo['dirname'];
					$versionData->move->static->$key_pointer->rename = 'new';
					$versionData->move->static->$key_pointer->newName = $pathInfo['basename'];
					// set the name
					$name = $pathInfo['basename'];
				}
				else
				{
					$custom['path'] = rtrim($custom['path'], '/');
					$custom['path'] = ltrim($custom['path'], '/');
					$versionData->move->static->$key_pointer->path = 'c0mp0n3nt/'.$custom['path'];
					$versionData->move->static->$key_pointer->rename = false;
					// set the name
					$name = $custom['file'];
				}
				// check if file should be updated
				if (isset($custom['notnew']) && $custom['notnew'] == 0)
				{
					$this->notNew[] = $key_pointer;
				}
				$versionData->move->static->$key_pointer->type = 'file';
				$versionData->move->static->$key_pointer->custom = true;
			}
			unset($this->componentData->files);
			unset($custom);
		}
		return $versionData;
	}

	protected function dynamique()
	{
		$back = false;
		$front = false;
		if ((isset($this->joomlaVersionData->move->dynamic) && ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->dynamic)) && (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views)))
		{
			// setup dashboard
			$target = array('admin' => $this->componentData->name_code);
			$this->buildDynamique($target,'dashboard');
			// now the rest of the views
			foreach ($this->componentData->admin_views as $nr => $view)
			{
				if (ComponentbuilderHelper::checkObject($view['settings']))
				{
					if ($view['settings']->name_list != 'null')
					{
						$target = array('admin' => $view['settings']->name_list);
						$this->buildDynamique($target,'list');
					}
					if ($view['settings']->name_single != 'null')
					{
						$target = array('admin' => $view['settings']->name_single);
						$this->buildDynamique($target,'single');
					}
					if($view['edit_create_site_view'])
					{
						// setup the front site edit-view files
						$target = array('site' => $view['settings']->name_single);
						$this->buildDynamique($target,'edit');
					}
				}
				// quick set of checkin once
				if ($view['checkin'] == 1 && !$this->addCheckin)
				{
					// swtich to add checking to config
					$this->addCheckin = true;
				}
			}
			$back = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic) && ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->dynamic)) && (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views)))
		{

			foreach ($this->componentData->site_views as $nr => $view)
			{
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view
					$target = array('site' => $view['settings']->code);
					$this->buildDynamique($target,'list');
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('site' => $view['settings']->code);
					$this->buildDynamique($target,'single');
				}
			}
			$front = true;
		}
		if ((isset($this->joomlaVersionData->move->dynamic) && ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->dynamic)) && (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views)))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $view)
			{
				if ($view['settings']->main_get->gettype == 2)
				{
					// set list view
					$target = array('custom_admin' => $view['settings']->code);
					$this->buildDynamique($target,'list');
				}
				elseif ($view['settings']->main_get->gettype == 1)
				{
					// set single view
					$target = array('custom_admin' => $view['settings']->code);
					$this->buildDynamique($target,'single');
				}
			}
			$back = true;
		}
		// chekc if we had success
		if ($back || $front)
		{
			return true;
		}
		return false;
	}

	protected function buildDynamique($target,$type,$fileName = false)
	{
		if (ComponentbuilderHelper::checkArray($target))
		{
			foreach ($target as  $main => $name)
			{
				// make sure it is lower case
				$name = ComponentbuilderHelper::safeString($name);
				// setup the files
				foreach ($this->joomlaVersionData->move->dynamic->{$main} as $item => $details)
				{
					if ($details->type == $type)
					{
						// set destination path
						$path =  '';
						if (strpos($details->path,'VIEW') !== false)
						{
							$path = str_replace('VIEW',$name,$details->path);
						}
						else
						{
							$path = $details->path;
						}
						$zipPath	= str_replace('c0mp0n3nt/','', $path);
						$path		= str_replace('c0mp0n3nt/',$this->componentPath.'/', $path);

						// setup the folder
						if (!JFolder::exists($path))
						{
							JFolder::create($path);
							$this->indexHTML($zipPath);
							// count the folder created
							$this->folderCount++;
						}
						// do the file renaming
						if ($details->rename)
						{
							if ($fileName)
							{
								$new = str_replace($details->rename, $fileName, $item);
								$name = $name.'_'.$fileName;
							}
							elseif ($details->rename == 'new')
							{
								$new = $details->newName;
							}
							else
							{
								$new = str_replace($details->rename, $name, $item);
							}
						}
						else
						{
							$new = $item;
						}
						if (!JFile::exists($path.'/'.$new))
						{
							// move the file to its place
							JFile::copy($this->templatePath.'/'.$item, $path.'/'.$new,'',true);
							// count the file created
							$this->fileCount++;
						}
						// store the new files
						$this->newFiles['dynamic'][$name][] = array( 'path' => $path.'/'.$new, 'name' => $new , 'view' => $name, 'zip' => $zipPath.'/'.$new);
					}
				}
			}
			return true;
		}
		return false;
	}

	protected function setStatic()
	{
		if (ComponentbuilderHelper::checkObject($this->joomlaVersionData->move->static))
		{
			// TODO needs more looking at this must be dynamic actualy
			$codeName = ComponentbuilderHelper::safeString($this->componentData->name_code);
			$this->notNew[] = 'PHPExcel.php';
			$this->notNew[] = 'LICENSE.txt';
			// do license check
			$LICENSE = false;
			$licenseChecker = strtolower($this->componentData->license);
			if (strpos($licenseChecker,'gnu') !== false && strpos($licenseChecker,'gpl') !== false)
			{
				$LICENSE = true;
			}
			// do README check
			$README = false;			
			// add the README file if needed
			if ($this->componentData->addreadme)
			{
				$README = true;
			}
			// start moving
			foreach ($this->joomlaVersionData->move->static as $ftem => $details)
			{
				// set item
				$item = $details->naam;
				// do the file renaming
				if ($details->rename)
				{
					if ($details->rename == 'new')
					{
						$new = $details->newName;
					}
					else
					{
						$new = str_replace($details->rename, $codeName, $item);
					}
				}
				else
				{
					$new = $item;
				}
				// if not gnu/gpl license dont add the LICENSE.txt file
				if ($item == 'LICENSE.txt' && !$LICENSE)
				{
					continue;
				}
				// if not needed do not add
				if ($item == 'README.md' && !$README)
				{
					continue;
				}
				// set destination path
				$zipPath	= str_replace('c0mp0n3nt/','', $details->path);
				$path		= str_replace('c0mp0n3nt/',$this->componentPath.'/', $details->path);
				// set the template folder path
				$templatePath = (isset($details->custom) && $details->custom) ? $this->templatePathCustom : $this->templatePath;
				// now mov the file
				if ($details->type == 'file')
				{
					// move the file to its place
					JFile::copy($templatePath.'/'.$item, $path.'/'.$new);
					// count the file created
					$this->fileCount++;
					// store the new files
					if (!in_array($ftem,$this->notNew))
					{
						$this->newFiles['static'][] = array( 'path' => $path.'/'.$new, 'name' => $new, 'zip' => $zipPath.'/'.$new );
					}
				}
				elseif ($details->type == 'folder')
				{
					// move the folder to its place
					JFolder::copy($templatePath.'/'.$item, $path.'/'.$new);
					// count the folder created
					$this->folderCount++;
				}
			}
			return true;
		}
		return false;
	}

	protected function getComponentData($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$query->select('a.*');
		$query->from('#__componentbuilder_component AS a');
		$query->where($db->quoteName('a.id') . ' = '. $db->quote($id));

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects
		$component = $db->loadObject();
		// set lang prefix
		$this->langPrefix .= ComponentbuilderHelper::safeString($component->name_code,'U');
		// set component code name
		$this->componentCodeName = ComponentbuilderHelper::safeString($component->name_code);
		// set component sales name
		$component->sales_name = ComponentbuilderHelper::safeString($component->system_name);
		// ensure version naming is correct
		$this->component_version = preg_replace('/[^0-9.]+/', '', $component->component_version);
		// ser the addfolders data
		$addfolders	= json_decode($component->addfolders,true);
		if (ComponentbuilderHelper::checkArray($addfolders))
		{
			foreach ($addfolders as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->folders[$nr][$option] = $value;
				}
			}
			unset($component->addfolders);
		}
		// ser the addfiles data
		$addfiles	= json_decode($component->addfiles,true);
		if (ComponentbuilderHelper::checkArray($addfiles))
		{
			foreach ($addfiles as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->files[$nr][$option] = $value;
				}
			}
			unset($component->addfiles);
		}
		// set the uikit switch
		if ($component->adduikit)
		{
			$this->uikit = true;
		}
		// set the footable switch
		if ($component->addfootable)
		{
			$this->footable = true;
		}

		// ser the addcustommenu data
		$addcustommenus	= json_decode($component->addcustommenus,true);
		if (ComponentbuilderHelper::checkArray($addcustommenus))
		{
			foreach ($addcustommenus as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->custommenus[$nr][$option] = $value;
				}
			}
			unset($component->addcustommenus);
		}
		
		// tweak the mysql dump settings if needed
		$sql_tweak	= json_decode($component->sql_tweak,true);
		if (ComponentbuilderHelper::checkArray($sql_tweak))
		{
			$component->sql_tweak = array();
			foreach ($sql_tweak as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->sql_tweak[$nr][$option] = (int) $value;
					}
					else
					{
						$component->sql_tweak[$nr][$option] = $value;
					}
				}
			}
			// build the tweak settings
			$this->setSqlTweaking($component->sql_tweak);
			unset($component->sql_tweak);
		}
		
		// set the admin_view data
		$admin_views	= json_decode($component->addadmin_views,true);
		if (ComponentbuilderHelper::checkArray($admin_views))
		{
			foreach ($admin_views as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->admin_views[$nr][$option] = (int) $value;
					}
					else
					{
						$component->admin_views[$nr][$option] = $value;
					}
				}
			}
			unset($component->addadmin_views);
			// sort the views acording to order
			usort($component->admin_views, function($a, $b)
			{
				if ($a['order'] != 0 && $b['order'] != 0)
				{
					return $a['order'] - $b['order'];
				}
				elseif ($b['order'] != 0 && $a['order'] == 0)
				{
					return 1;
				}
				elseif ($a['order'] != 0 && $b['order'] == 0)
				{
					return 0;
				}
				return 1;
			});
			// load the view and field data
			foreach ($component->admin_views as $key => &$view)
			{
				if ($view['port'] && !$this->addEximport)
				{
					$this->addEximport = true;
				}
				if ($view['history'] && !$this->setTagHistory)
				{
					$this->setTagHistory = true;
				}
				if ($view['edit_create_site_view'])
				{
					$this->siteEditView[$view['adminview']] = true;
				}
				// TODO this is a temp fix until front view is added
				$view['view'] = $view['adminview'];
				$view['settings'] = $this->getAdminViewData($view['view']);
			}
			unset($component->addadmin_view);
		}

		// set the site_view data
		$site_views	= json_decode($component->addsite_views,true);
		if (ComponentbuilderHelper::checkArray($site_views))
		{
			foreach ($site_views as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->site_views[$nr][$option] = (int) $value;
					}
					else
					{
						$component->site_views[$nr][$option] = $value;
					}
				}
			}
			unset($component->addsite_views);
			$this->lang = 'site';
			$this->target = 'site';
			// load the view and field data
			foreach ($component->site_views as $key => &$view)
			{
				// TODO this is a temp fix until front view is added
				$view['view'] = $view['siteview'];
				$view['settings'] = $this->getCustomViewData($view['view']);
			}
		}

		// set the custom_admin_views data
		$custom_admin_views	= json_decode($component->addcustom_admin_views,true);
		if (ComponentbuilderHelper::checkArray($custom_admin_views))
		{
			foreach ($custom_admin_views as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					if ((string)(int)$value == $value)
					{
						$component->custom_admin_views[$nr][$option] = (int) $value;
					}
					else
					{
						$component->custom_admin_views[$nr][$option] = $value;
					}
				}
			}
			unset($component->addcustom_admin_views);
			$this->lang = 'admin';
			$this->target = 'custom_admin';
			// load the view and field data
			foreach ($component->custom_admin_views as $key => &$view)
			{
				// TODO this is a temp fix until front view is added
				$view['view'] = $view['customadminview'];
				$view['settings'] = $this->getCustomViewData($view['view'], 'custom_admin_view');
			}
		}

		// ser the config data
		$addconfig	= json_decode($component->addconfig,true);
		if (ComponentbuilderHelper::checkArray($addconfig))
		{
			foreach ($addconfig as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->config[$nr]['alias'] = 0;
					$component->config[$nr]['title'] = 0;
					if ($option == 'field')
					{
						// load the field data
						$component->config[$nr]['settings'] = $this->getFieldData($value);
					}
					else
					{
						$component->config[$nr][$option] = $value;
					}
				}
			}
			unset($component->addconfig);
		}

		// check if any contributors is to be added
		$contributors = json_decode($component->addcontributors,true);
		if (ComponentbuilderHelper::checkArray($contributors))
		{
			$this->addContributors = true;
			foreach ($contributors as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->contributors[$nr][$option] = $value;
				}
			}
			unset($component->addcontributors);
		}

		// check if version updating is set
		$version_update = json_decode($component->version_update,true);
		if (ComponentbuilderHelper::checkArray($version_update))
		{
			$component->version_update = array();
			foreach ($version_update as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$component->version_update[$nr][$option] = $value;
				}
			}
		}

		// add_css
		if ($component->add_css == 1)
		{
			$this->customScriptBuilder['component_css'] = base64_decode($component->css);
			unset($component->css);
		}
		else
		{
			$this->customScriptBuilder['component_css'] = '';
		}
		// add_php_helper
		if ($component->add_php_helper_admin == 1)
		{
			$this->lang = 'admin';
			$this->customScriptBuilder['component_php_helper_admin'] = "\n\n".$this->setCustomContentLang(base64_decode($component->php_helper_admin));
			unset($component->php_helper);
		}
		else
		{
			$this->customScriptBuilder['component_php_helper_admin'] = '';
		}
		// add_admin_event
		if ($component->add_admin_event == 1)
		{
			$this->lang = 'admin';
			$this->customScriptBuilder['component_php_admin_event'] = $this->setCustomContentLang(base64_decode($component->php_admin_event));
			unset($component->php_admin_event);
		}
		else
		{
			$this->customScriptBuilder['component_php_admin_event'] = '';
		}
		// add_php_helper_site
		if ($component->add_php_helper_site == 1)
		{
			$this->lang = 'site';
			$this->customScriptBuilder['component_php_helper_site'] = "\n\n".$this->setCustomContentLang(base64_decode($component->php_helper_site));
			unset($component->php_helper);
		}
		else
		{
			$this->customScriptBuilder['component_php_helper_site'] = '';
		}
		// add_site_event
		if ($component->add_site_event == 1)
		{
			$this->lang = 'site';
			$this->customScriptBuilder['component_php_site_event'] = $this->setCustomContentLang(base64_decode($component->php_site_event));
			unset($component->php_site_event);
		}
		else
		{
			$this->customScriptBuilder['component_php_site_event'] = '';
		}
		// add_sql
		if ($component->add_sql == 1)
		{
			$this->customScriptBuilder['sql']['component_sql'] = base64_decode($component->sql);
			unset($component->sql);
		}
		// bom
		if (ComponentbuilderHelper::checkString($component->bom))
		{
			$this->bomPath = $this->compilerPath.'/'.$component->bom;
			unset($component->bom);
		}
		else
		{
			$this->bomPath = $this->compilerPath.'/default.txt';
		}
		// README
		if ($component->addreadme)
		{
			$component->readme = base64_decode($component->readme);
		}
		else
		{
			$component->readme = '';
		}

		// return the found component data
		return $component;
	}
	
	protected function setSqlTweaking($settings)
	{
		if (ComponentbuilderHelper::checkArray($settings))
		{
			foreach($settings as $setting)
			{
				// should sql dump be added
				if (1 == $setting['add_sql'])
				{
					// add sql (by option)
					if (2 == $setting['add_sql_options'])
					{
						// rest always 
						$id_array = array();
						// by id (first remove backups)
						$ids = $setting['ids'];
						// now get the ids
						if (strpos($ids, ',') !== false)
						{
							$id_array = (array) array_map('trim',explode(',', $ids));
						}
						else
						{
							$id_array[] = trim($ids);
						}
						// check for ranges
						foreach ($id_array as $key => $id)
						{
							if (strpos($id, '=>') !== false)
							{
								$id_range = (array) array_map('trim', explode('=>', $id));
								unset($id_array[$key]);
								// build range
								if (count($id_range) == 2)
								{
									$range = range($id_range[0],$id_range[1]);
									$id_array = array_merge($id_array,$range);
								}
							}
						}
						// final fixing to array
						if (ComponentbuilderHelper::checkArray($id_array))
						{
							// uniqe
							$id_array = array_unique($id_array, SORT_NUMERIC);
							// sort
							sort($id_array, SORT_NUMERIC);
							// now set it to global
							$this->sqlTweak[ (int) $setting['adminview']]['where'] = implode(',', $id_array);
						}
					}
				}
				else
				{
					// remove all sql dump options
					$this->sqlTweak[ (int) $setting['adminview']]['remove'] = true;
					
				}
			}
		}
	}

	protected function getAdminViewData($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$query->select('a.*');
		$query->from('#__componentbuilder_admin_view AS a');
		$query->where($db->quoteName('a.id') . ' = '. (int) $id);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$view = $db->loadObject();
		// reset fields
		$view->fields = array();
		// setup view name to use in storing the data
		$name_single = ComponentbuilderHelper::safeString($view->name_single);
		$name_list = ComponentbuilderHelper::safeString($view->name_list);
		// setup token check
		$this->customScriptBuilder['token'][$name_single] = false;
		$this->customScriptBuilder['token'][$name_list] = false;
		// load the values form params
		$permissions	= json_decode($view->addpermissions,true);
		unset($view->addpermissions);
		$tabs			= json_decode($view->addtabs,true);
		unset($view->addtabs);
		$fields			= json_decode($view->addfields,true);
		unset($view->addfields);
		$conditions		= json_decode($view->addconditions,true);
		unset($view->addconditions);
		$linked_views	= json_decode($view->addlinked_views,true);
		unset($view->addlinked_views);
		$tables	= json_decode($view->addtables,true);
		unset($view->addtables);
		// sort the values
		if (ComponentbuilderHelper::checkArray($tables))
		{
			foreach ($tables as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$view->tables[$nr][$option] = $value;
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($tabs))
		{
			foreach ($tabs as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$fix = $nr+1;
					$view->tabs[$fix] = $value;
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($permissions))
		{
			foreach ($permissions as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$view->permissions[$nr][$option] = $value;
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($fields))
		{
			foreach ($fields as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$view->fields[$nr][$option] = (int) $value;
				}
			}
			// sort the fields acording to order
			usort($view->fields, function($a, $b)
			{
				if ($a['order_list'] != 0 && $b['order_list'] != 0)
				{
					return $a['order_list'] - $b['order_list'];
				}
				elseif ($b['order_list'] != 0 && $a['order_list'] == 0)
				{
					return 1;
				}
				elseif ($a['order_list'] != 0 && $b['order_list'] == 0)
				{
					return 0;
				}
				return 1;
			});
			// load the field data
			foreach ($view->fields as $key => &$field)
			{
				$field['settings'] = $this->getFieldData($field['field'],$name_single,$name_list);
			}
		}
		if (ComponentbuilderHelper::checkArray($conditions))
		{
			foreach ($conditions as $condition => $conditionValues)
			{
				foreach ($conditionValues as $nr => $conditionValue)
				{
					if ($condition == 'target_field')
					{
						if (ComponentbuilderHelper::checkArray($conditionValue) && ComponentbuilderHelper::checkArray($view->fields))
						{
							foreach ($conditionValue as $fieldKey => $fieldId)
							{
								foreach ($view->fields as $fieldValues)
								{
									if ((int) $fieldValues['field'] == (int) $fieldId)
									{
										// load the field details
										$required	= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'required="','"');
										$required	= ($required == true) ? 'yes' : 'no';
										$filter		= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'filter="','"');
										$filter		= ComponentbuilderHelper::checkString($filter) ? $filter : 'none';
										// get name
										$name		= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'name="','"');
										$name		= ComponentbuilderHelper::checkString($name) ? $name : $fieldValues['settings']->name;
										// get type
										$type		= ComponentbuilderHelper::getBetween($fieldValues['settings']->xml,'type="','"');
										$type		= ComponentbuilderHelper::checkString($type) ? $type : $fieldValues['settings']->type_name;
										// set the field name
										$conditionValue[$fieldKey] = array(
											'name' => ComponentbuilderHelper::safeString($name),
											'type' => ComponentbuilderHelper::safeString($type),
											'required' => $required,
											'filter' => $filter
											);
										break;
									}
								}
							}
						}
					}
					if ($condition == 'match_field')
					{
						foreach ($view->fields as $fieldValue)
						{
							if ((int) $fieldValue['field'] == (int) $conditionValue)
							{
								// get name
								$name = ComponentbuilderHelper::getBetween($fieldValue['settings']->xml,'name="','"');
								$name = ComponentbuilderHelper::checkString($name) ? $name : $fieldValue['settings']->name;
								// get type
								$type = ComponentbuilderHelper::getBetween($fieldValue['settings']->xml,'type="','"');
								$type = ComponentbuilderHelper::checkString($type) ? $type : $fieldValue['settings']->type_name;
								// set the field details
								$view->conditions[$nr]['match_name']	= ComponentbuilderHelper::safeString($name);
								$view->conditions[$nr]['match_type']	= ComponentbuilderHelper::safeString($type);
								$view->conditions[$nr]['match_xml']		= $fieldValue['settings']->xml;
								break;
							}
						}
					}
					// set condition values
					$view->conditions[$nr][$condition] = $conditionValue;
				}
			}
		}
		// set linked views
		$linked_views_sorted = null;
		if (ComponentbuilderHelper::checkArray($linked_views))
		{
			$linked_views_sorted = array();
			foreach ($linked_views as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$linked_views_sorted[$nr][$option] = $value;
				}
			}
		}
		unset($linked_views);
		// setup linked views to global data sets
		$this->linkedAdminViews[$name_single] = $linked_views_sorted;
		unset($linked_views_sorted);
		// add_javascript_view_file
		if ($view->add_javascript_view_file == 1)
		{
			$view->javascript_view_file = base64_decode($view->javascript_view_file);
			$this->customScriptBuilder['view_file'][$name_single] = $view->javascript_view_file;
			if (strpos($view->javascript_view_file,"token") !== false && strpos($view->javascript_view_file,"task=ajax") !== false)
			{
				if (!$this->customScriptBuilder['token'][$name_single])
				{
					$this->customScriptBuilder['token'][$name_single] = true;
				}
			}
			unset($view->javascript_view_file);
		}
		// add_javascript_view_footer
		if ($view->add_javascript_view_footer == 1)
		{
			$view->javascript_view_footer = base64_decode($view->javascript_view_footer);
			if (!isset($this->customScriptBuilder['view_footer'][$name_single]))
			{
				$this->customScriptBuilder['view_footer'][$name_single] = '';
			}
			$this->customScriptBuilder['view_footer'][$name_single] .= $view->javascript_view_footer;
			if (strpos($view->javascript_view_footer,"token") !== false && strpos($view->javascript_view_footer,"task=ajax") !== false)
			{
				if (!$this->customScriptBuilder['token'][$name_single])
				{
					$this->customScriptBuilder['token'][$name_single] = true;
				}
			}
			unset($view->javascript_view_footer);
		}
		// add_javascript_view_file
		if ($view->add_javascript_views_file == 1)
		{
			$view->javascript_views_file = base64_decode($view->javascript_views_file);
			$this->customScriptBuilder['views_file'][$name_list] = $view->javascript_views_file;
			if (strpos($view->javascript_views_file,"token") !== false && strpos($view->javascript_views_file,"task=ajax") !== false)
			{
				if (!$this->customScriptBuilder['token'][$name_list])
				{
					$this->customScriptBuilder['token'][$name_list] = true;
				}
			}
			unset($view->javascript_views_file);
		}
		// add_javascript_views_footer
		if ($view->add_javascript_views_footer == 1)
		{
			$view->javascript_views_footer = base64_decode($view->javascript_views_footer);
			$this->customScriptBuilder['views_footer'][$name_list] .= $view->javascript_views_footer;
			if (strpos($view->javascript_views_footer,"token") !== false && strpos($view->javascript_views_footer,"task=ajax") !== false)
			{
				if (!$this->customScriptBuilder['token'][$name_list])
				{
					$this->customScriptBuilder['token'][$name_list] = true;
				}
			}
			unset($view->javascript_views_footer);
		}
		// add_css_view
		if ($view->add_css_view == 1)
		{
			$this->customScriptBuilder['css_view'][$name_single] .= base64_decode($view->css_view);
			unset($view->css_view);
		}
		// add_css_views
		if ($view->add_css_views == 1)
		{
			$this->customScriptBuilder['css_views'][$name_list] .= base64_decode($view->css_views);
			unset($view->css_views);
		}
		
		$this->lang = 'admin';
		$addArray = array('php_getitem','php_save','php_postsavehook','php_getitems','php_getlistquery','php_allowedit','php_before_delete','php_after_delete','php_batchcopy','php_batchmove');
		foreach ($addArray as $scripter)
		{
			if (isset($view->{'add_'.$scripter}) && $view->{'add_'.$scripter} == 1)
			{
				$this->customScriptBuilder[$scripter][$name_single] = $this->setCustomContentLang(base64_decode($view->$scripter));
				unset($view->$scripter);
			}
		}
		
		// add_Ajax for this view
		if ($view->add_php_ajax == 1)
		{
			$addAjaxSite = false;
			if (isset($this->siteEditView[$id]) && $this->siteEditView[$id])
			{
				// we should add this site ajax to fron ajax
				$addAjaxSite = true;
				if (!isset($this->addSiteAjax) || !$this->addSiteAjax)
				{
					$this->addSiteAjax = true;
				}
			}
			// check if controller input as been set
			$ajax_input = json_decode($view->ajax_input,true);
			if (ComponentbuilderHelper::checkArray($ajax_input))
			{
				foreach ($ajax_input as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						if ($addAjaxSite)
						{
							$this->customScriptBuilder['site']['ajax_controller'][$name_single][$nr][$option] = $value;
						}
						$this->customScriptBuilder['admin']['ajax_controller'][$name_single][$nr][$option] = $value;
					}
				}
				if ($addAjaxSite)
				{
					$this->customScriptBuilder['site']['ajax_model'][$name_single] = $this->setCustomContentLang(base64_decode($view->php_ajaxmethod));
				}
				$this->customScriptBuilder['admin']['ajax_model'][$name_single] = $this->setCustomContentLang(base64_decode($view->php_ajaxmethod));
				$this->addAjax = true;
				unset($view->ajax_input);
			}
			// unset anyway
			unset($view->php_ajaxmethod);
		}
		// add_sql
		if ($view->add_sql == 1)
		{
			if ($view->source == 1)
			{
				// build and add the SQL dump
				$this->customScriptBuilder['sql'][$name_single] = $this->buildSqlDump($view->tables,$name_single, $id);
				unset($view->tables);
			}
			elseif ($view->source == 2)
			{
				// add the SQL dump string
				$this->customScriptBuilder['sql'][$name_single] = base64_decode($view->sql);
				unset($view->sql);
			}
		}
		// return the found view data
		return $view;
	}

	protected function uniqueCode($code)
	{
		if (!isset($this->codes[$this->target]) || !in_array($code,$this->codes[$this->target]))
		{
			$this->codes[$this->target][] = $code;
			return $code;
		}
		// make sure it is unique
		return $this->uniqueCode($code.ComponentbuilderHelper::randomkey(1));
	}

	protected function getCustomViewData($id, $table = 'site_view')
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		$query->select('a.*');
		$query->from('#__componentbuilder_'.$table.' AS a');
		$query->where($db->quoteName('a.id') . ' = '. (int) $id);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$view = $db->loadObject();
		if ($table == 'site_view')
		{
			$this->lang = 'site';
		}
		else
		{
			$this->lang = 'admin';
		}
		// set the default data
		$view->default = base64_decode($view->default);
		$view->default = $this->setCustomContentLang($view->default);
		// fix alias to use in code
		$view->code = $this->uniqueCode(ComponentbuilderHelper::safeString($view->alias));
		$view->Code = ComponentbuilderHelper::safeString($view->code, 'F');
		$view->CODE = ComponentbuilderHelper::safeString($view->code, 'U');
		// insure the uikit components are loaded
		if (!isset($this->uikitComp[$view->code]))
		{
			$this->uikitComp[$view->code] = array();
		}
		$this->uikitComp[$view->code] = ComponentbuilderHelper::getUikitComp($view->default,$this->uikitComp[$view->code]);
		// check for footable
		if (!isset($this->footableScripts[$this->target][$view->code]) || !$this->footableScripts[$this->target][$view->code])
		{
			$foundFoo = $this->getFootableScripts($view->default);
			if ($foundFoo)
			{
				$this->footableScripts[$this->target][$view->code] = true;
			}
			if ($foundFoo && !$this->footableScripts)
			{
				$this->footable = true;
			}
		}
		// check for get module
		if (!isset($this->getModule[$this->target][$view->code]) || !$this->getModule[$this->target][$view->code])
		{
			$found = $this->getGetModule($view->default);
			if ($found)
			{
				$this->getModule[$this->target][$view->code] = true;
			}
		}
		// setup template array
		$this->templateData[$this->target][$view->code] = array();
		// setup template and layout data
		$this->setTemplateAndLayoutData($view->default,$view->code);
		// set the main get data
		$main_get = $this->setGetData(array($view->main_get),$view->code);
		$view->main_get = $main_get[0];
		// set the custom_get data
		$view->custom_get = $this->setGetData(json_decode($view->custom_get,true),$view->code);
		// set array adding array of scripts
		$addArray = array('php_view','php_jview','php_jview_display','php_document','js_document','css_document','css');
		foreach ($addArray as $scripter)
		{
			if (isset($view->{'add_'.$scripter}) && $view->{'add_'.$scripter} == 1)
			{
				$view->$scripter = base64_decode($view->$scripter);
				$view->$scripter = $this->setCustomContentLang($view->$scripter);
				// set uikit to views
				$this->uikitComp[$view->code] = ComponentbuilderHelper::getUikitComp($view->$scripter,$this->uikitComp[$view->code]);
				
				$this->setTemplateAndLayoutData($view->$scripter,$view->code);
				
				// check for footable
				if (!isset($this->footableScripts[$this->target][$view->code]) || !$this->footableScripts[$this->target][$view->code])
				{
					$foundFoo = $this->getFootableScripts($view->$scripter);
					if ($foundFoo)
					{
						$this->footableScripts[$this->target][$view->code] = true;
					}
					if ($foundFoo && !$this->footable)
					{
						$this->footable = true;
					}
				}
				// check for google chart
				if (!isset($this->googleChart[$this->target][$view->code]) || !$this->googleChart[$this->target][$view->code])
				{
					$found = $this->getGoogleChart($view->$scripter);
					if ($found)
					{
						$this->googleChart[$this->target][$view->code] = true;
					}
					if ($found && !$this->googlechart)
					{
						$this->googlechart = true;
					}
				}
				// check for get module
				if (!isset($this->getModule[$this->target][$view->code]) || !$this->getModule[$this->target][$view->code])
				{
					$found = $this->getGetModule($view->$scripter);
					if ($found)
					{
						$this->getModule[$this->target][$view->code] = true;
					}
				}
			}
		}
		// add_Ajax for this view
		if (isset($view->add_php_ajax) && $view->add_php_ajax == 1)
		{
			// check if controller input as been set
			$ajax_input = json_decode($view->ajax_input,true);
			if (ComponentbuilderHelper::checkArray($ajax_input))
			{
				foreach ($ajax_input as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$this->customScriptBuilder[$this->target]['ajax_controller'][$view->code][$nr][$option] = $value;
					}
				}
				$this->customScriptBuilder[$this->target]['ajax_model'][$view->code] = $this->setCustomContentLang(base64_decode($view->php_ajaxmethod));
				$this->addSiteAjax = true;
				unset($view->ajax_input);
			}
			// unset anyway
			unset($view->php_ajaxmethod);
		}
		// add the custom buttons
		if (isset($view->add_custom_button) && $view->add_custom_button == 1)
		{
			if (ComponentbuilderHelper::checkString($view->php_model))
			{
				$view->php_model = base64_decode($view->php_model);
				$view->php_model = $this->setCustomContentLang($view->php_model);
			}
			$view->php_controller = base64_decode($view->php_controller);
			$view->php_controller = $this->setCustomContentLang($view->php_controller);
			// set the button array
			$buttons = json_decode($view->custom_button,true);
			unset($view->custom_button);
			// sort the values
			if (ComponentbuilderHelper::checkArray($buttons))
			{
				foreach ($buttons as $option => $values)
				{
					foreach ($values as $nr => $value)
					{
						$view->custom_buttons[$nr][$option] = $value;
					}
				}
			}
		}
		// return the found view data
		return $view;
	}

	protected function setCustomContentLang($content)
	{
		// set language data
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, "JText::_('","')");
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, 'JText::_("','")');
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, "JText::sprintf('","'");
		$langCheck[] = ComponentbuilderHelper::getAllBetween($content, 'JText::sprintf("','"');
		$langHolders = array();
		$lang = array();
		foreach ($langCheck as $langChecked)
		{
			if (ComponentbuilderHelper::checkArray($langChecked))
			{
				$lang = array_merge($lang,$langChecked);
			}
		}
		if (ComponentbuilderHelper::checkArray($lang))
		{
			foreach ($lang as $string)
			{
				if (ComponentbuilderHelper::safeString($string,'U') == $string)
				{
					continue;
				}
				// only load if string is not already set
				$keyLang = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($string,'U');
				$this->langContent[$this->lang][$keyLang] = trim($string);
				$langHolders["JText::_('".$string."')"] = "JText::_('".$keyLang."')";
				$langHolders['JText::_("'.$string.'")'] = 'JText::_("'.$keyLang.'")';
				$langHolders["JText::sprintf('".$string."',"] = "JText::sprintf('".$keyLang."',";
				$langHolders['JText::sprintf("'.$string.'",'] = 'JText::sprintf("'.$keyLang.'",';
			}
			$content = str_replace(array_keys($langHolders),array_values($langHolders),$content);
		}
		return $content;
	}

	protected function setTemplateAndLayoutData($default,$view)
	{
		// set the Tempale date
		$temp1 = ComponentbuilderHelper::getAllBetween($default, "\$this->loadTemplate('","')");
		$temp2 = ComponentbuilderHelper::getAllBetween($default, '$this->loadTemplate("','")');
		$templates = array();
		$again = array();
		if (ComponentbuilderHelper::checkArray($temp1) && ComponentbuilderHelper::checkArray($temp2))
		{
			$templates = array_merge($temp1,$temp2);
		}
		else
		{
			if (ComponentbuilderHelper::checkArray($temp1))
			{
				$templates = $temp1;
			}
			elseif (ComponentbuilderHelper::checkArray($temp2))
			{
				$templates = $temp2;
			}
		}
		if (ComponentbuilderHelper::checkArray($templates))
		{
			foreach ($templates as $template)
			{
				if (!isset($this->templateData[$this->target][$view]) || !array_key_exists($template,$this->templateData[$this->target][$view]))
				{
					$data = $this->getDataWithAlias($template,'template',$view);
					if (ComponentbuilderHelper::checkArray($data))
					{
						$this->templateData[$this->target][$view][$template] = $data;
						// call self to get child data
						$again[] = array($data['html'],$view);
						$again[] = array($data['php_view'],$view);
					}
				}
			}
		}
		// set  the layout data
		$lay1 = ComponentbuilderHelper::getAllBetween($default, "JLayoutHelper::render('","',");
		$lay2 = ComponentbuilderHelper::getAllBetween($default, 'JLayoutHelper::render("','",');;
		if (ComponentbuilderHelper::checkArray($lay1) && ComponentbuilderHelper::checkArray($lay2))
		{
			$layouts = array_merge($lay1,$lay2);
		}
		else
		{
			if (ComponentbuilderHelper::checkArray($lay1))
			{
				$layouts = $lay1;
			}
			elseif (ComponentbuilderHelper::checkArray($lay2))
			{
				$layouts = $lay2;
			}
		}
		if (isset($layouts) && ComponentbuilderHelper::checkArray($layouts))
		{
			foreach ($layouts as $layout)
			{
				if (!isset($this->layoutData[$this->target]) || !ComponentbuilderHelper::checkArray($this->layoutData[$this->target]) || !array_key_exists($layout,$this->layoutData[$this->target]))
				{
					$data = $this->getDataWithAlias($layout,'layout',$view);
					if (ComponentbuilderHelper::checkArray($data))
					{
						$this->layoutData[$this->target][$layout] = $data;
						// call self to get child data
						$again[] = array($data['html'],$view);
						$again[] = array($data['php_view'],$view);
					}
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($again))
		{
			foreach ($again as $go)
			{
				$this->setTemplateAndLayoutData($go[0],$go[1]);
			}
		}
	}

	protected function getDataWithAlias($n_ame,$table,$view)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_'.$table.' AS a');
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		foreach ($rows as $row)
		{
			$k_ey = ComponentbuilderHelper::safeString($row->alias);
			$key = preg_replace("/[^A-Za-z]/", '', $k_ey);
			$name = preg_replace("/[^A-Za-z]/", '', $n_ame);
			if ($k_ey == $n_ame || $key == $name)
			{
				$php_view = '';
				if ($row->add_php_view == 1)
				{
					$php_view = base64_decode($row->php_view);
					$php_view = $this->setCustomContentLang($php_view);
				}
				$contnent = base64_decode($row->{$table});
				$contnent = $this->setCustomContentLang($contnent);
				// set uikit to views
				$this->uikitComp[$view] = ComponentbuilderHelper::getUikitComp($contnent,$this->uikitComp[$view]);
				// set footable to views and turn it on
				if (!isset($this->footableScripts[$this->target][$view]) || !$this->footableScripts[$this->target][$view])
				{
					$foundFoo = $this->getFootableScripts($contnent);
					if ($foundFoo)
					{
						$this->footableScripts[$this->target][$view] = true;
					}
					if ($foundFoo && !$this->footable)
					{
						$this->footable = true;
					}
				}
				// set google charts to views and turn it on
				if (!isset($this->googleChart[$this->target][$view]) || !$this->googleChart[$this->target][$view])
				{
					$foundA = $this->getGoogleChart($php_view);
					$foundB = $this->getGoogleChart($contnent);
					if ($foundA || $foundB)
					{
						$this->googleChart[$this->target][$view] = true;
					}
					if ($foundA || $foundB && !$this->googlechart)
					{
						$this->googlechart = true;
					}
				}
				// check for get module
				if (!isset($this->getModule[$this->target][$view]) || !$this->getModule[$this->target][$view])
				{
					$foundA = $this->getGetModule($php_view);
					$foundB = $this->getGetModule($contnent);
					if ($foundA || $foundB)
					{
						$this->getModule[$this->target][$view] = true;
					}
				}
				return array('id' => $row->id, 'html' => $contnent, 'php_view' => $php_view);
			}
		}
		return false;
	}

	/**
	* 	Get Google Chart class name
	**/
	protected function getFootableScripts($content)
	{
		if (strpos($content,'footable') !== false)
		{
			return true;
		}
		return false;
	}

	/**
	* 	Ge Get Module class name
	**/
	protected function getGetModule($content)
	{
		if (strpos($content,'this->getModules(') !== false)
		{
			return true;
		}
		return false;
	}

	/**
	* 	Get Google Chart class name
	**/
	protected function getGoogleChart($content)
	{
		if (strpos($content,'Chartbuilder(') !== false)
		{
			return true;
		}
		return false;
	}

	protected function setGetData($ids,$view_code)
	{
		if (ComponentbuilderHelper::checkArray($ids))
		{
			$ids = implode(',', $ids);
			if (ComponentbuilderHelper::checkString($ids))
			{
				// Get a db connection.
				$db = JFactory::getDbo();
				// Create a new query object.
				$query = $db->getQuery(true);
				$query->select('a.*');
				$query->from('#__componentbuilder_dynamic_get AS a');
				$query->where('a.id IN (' . $ids . ')');
				$db->setQuery($query);
				$db->execute();
				if ($db->getNumRows())
				{
					$results = $db->loadObjectList();
					$typeArray = array(1 => 'LEFT', 2 => 'LEFT OUTER', 3 => 'INNER', 4 => 'RIGHT', 5 => 'RIGHT OUTER');
					$operatorArray = array(1 => '=', 2 => '!=', 3 => '<>', 4 => '>', 5 => '<', 6 => '>=', 7 => '<=', 8 => '!<', 9 => '!>', 10 => 'IN', 11 => 'NOT IN');
					foreach ($results as $nr => &$result)
					{
						// add calculations if set
						if($result->addcalculation == 1)
						{
							$result->php_calculation = base64_decode($result->php_calculation);
						}
						// add php custom scripting (php_before_getitem)
						if($result->add_php_before_getitem == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_before_getitem'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_before_getitem'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_before_getitem'][$view_code] .= "\n\n".base64_decode($result->php_before_getitem);
							unset($result->php_before_getitem);
						}
						// add php custom scripting (php_after_getitem)
						if($result->add_php_after_getitem == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_after_getitem'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_after_getitem'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_after_getitem'][$view_code] .= "\n\n".base64_decode($result->php_after_getitem);
							unset($result->php_after_getitem);
						}
						// add php custom scripting (php_before_getitems)
						if($result->add_php_before_getitems == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_before_getitems'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_before_getitems'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_before_getitems'][$view_code] .= "\n\n".base64_decode($result->php_before_getitems);
							unset($result->php_before_getitems);
						}
						// add php custom scripting (php_after_getitems)
						if($result->add_php_after_getitems == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_after_getitems'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_after_getitems'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_after_getitems'][$view_code] .= "\n\n".base64_decode($result->php_after_getitems);
							unset($result->php_after_getitems);
						}
						// add php custom scripting (php_getlistquery)
						if($result->add_php_getlistquery == 1)
						{
							if (!isset($this->customScriptBuilder[$this->target.'_php_getlistquery'][$view_code]))
							{
								$this->customScriptBuilder[$this->target.'_php_getlistquery'][$view_code] = '';
							}
							$this->customScriptBuilder[$this->target.'_php_getlistquery'][$view_code] .= "\n\n".base64_decode($result->php_getlistquery);
							unset($result->php_getlistquery);
						}
						// set the getmethod code name
						$result->key = ComponentbuilderHelper::safeString($view_code. ' ' .$result->name . ' ' .$result->id);
						// reset buckets
						$result->main_get = array();
						$result->custom_get = array();
						// set source data
						switch ($result->main_source)
						{
							case 1:
							// set the view data
							$result->main_get[0]['selection'] = $this->setDataSelection($result->key,$view_code,$result->view_selection,$result->view_table_main,'a','','view');
							$result->main_get[0]['as'] = 'a';
							$result->main_get[0]['key'] = $result->key;
							unset($result->view_selection);
							break;
							case 2:
							// set the database data
							$result->main_get[0]['selection'] = $this->setDataSelection($result->key,$view_code,$result->db_selection,$result->db_table_main,'a','','db');
							$result->main_get[0]['as'] = 'a';
							$result->main_get[0]['key'] = $result->key;
							unset($result->db_selection);
							break;
							case 3:
							// set custom script
							$result->main_get[0]['selection'] = array(
								'select' => base64_decode($result->php_custom_get),
								'from' => '', 'table' => '', 'type' => '');
							break;
						}
						// set join_view_table details
						$join_view_table = json_decode($result->join_view_table,true);
						unset($result->join_view_table);
						$result->join_view_table = array();
						if (ComponentbuilderHelper::checkArray($join_view_table))
						{
							foreach ($join_view_table as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'selection')
										{
											$on_field_as = '';
											$on_field = '';
											list($on_field_as,$on_field) = array_map('trim', explode('.',$result->join_view_table[$nr]['on_field']));
											$join_field_as = '';
											$join_field = '';
											list($join_field_as,$join_field) = array_map('trim', explode('.',$result->join_view_table[$nr]['join_field']));
											$result->join_view_table[$nr][$option] =
											$this->setDataSelection($result->key,$view_code,$value,$result->join_view_table[$nr]['view_table'],$result->join_view_table[$nr]['as'],$result->join_view_table[$nr]['row_type'],'view');
											$result->join_view_table[$nr]['key'] = $result->key;
											if ($result->join_view_table[$nr]['row_type'] == 1)
											{
												$result->main_get[] = $result->join_view_table[$nr];
												if ($on_field_as == 'a')
												{
													$this->siteMainGet[$this->target][$view_code][$result->join_view_table[$nr]['as']] = $result->join_view_table[$nr]['as'];
												}
												else
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_view_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											elseif ($result->join_view_table[$nr]['row_type'] == 2)
											{
												$result->custom_get[] = $result->join_view_table[$nr];
												if ($on_field_as != 'a')
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_view_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											unset($result->join_view_table[$nr]);
										}
										else
										{
											if ($option == 'type')
											{
												$value = $typeArray[$value];
											}
											if ($option == 'operator')
											{
												$value = $operatorArray[$value];
											}
											$result->join_view_table[$nr][$option] = $value;
										}
									}
								}
							}
						}
						unset($result->join_view_table);
						// set join_db_table details
						$join_db_table = json_decode($result->join_db_table,true);
						unset($result->join_db_table);
						$result->join_db_table = array();
						if (ComponentbuilderHelper::checkArray($join_db_table))
						{
							foreach ($join_db_table as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'selection')
										{
											$on_field_as = '';
											$on_field = '';
											list($on_field_as,$on_field) = array_map('trim', explode('.',$result->join_db_table[$nr]['on_field']));
											$join_field_as = '';
											$join_field = '';
											list($join_field_as,$join_field) = array_map('trim', explode('.',$result->join_db_table[$nr]['join_field']));
											$result->join_db_table[$nr][$option] =
											$this->setDataSelection($result->key,$view_code,$value,$result->join_db_table[$nr]['db_table'],$result->join_db_table[$nr]['as'],$result->join_db_table[$nr]['row_type'],'db');
											$result->join_db_table[$nr]['key'] = $result->key;
											if ($result->join_db_table[$nr]['row_type'] == 1)
											{
												$result->main_get[] = $result->join_db_table[$nr];
												if ($on_field_as == 'a')
												{
													$this->siteMainGet[$this->target][$view_code][$result->join_db_table[$nr]['as']] = $result->join_db_table[$nr]['as'];
												}
												else
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_db_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											elseif ($result->join_db_table[$nr]['row_type'] == 2)
											{
												$result->custom_get[] = $result->join_db_table[$nr];
												if ($on_field_as != 'a')
												{
													$this->siteDynamicGet[$this->target][$view_code][$result->join_db_table[$nr]['as']][$join_field] = $on_field_as;
												}
											}
											unset($result->join_db_table[$nr]);
										}
										else
										{
											if ($option == 'type')
											{
												$value = $typeArray[$value];
											}
											if ($option == 'operator')
											{
												$value = $operatorArray[$value];
											}
											$result->join_db_table[$nr][$option] = $value;
										}
									}
								}
							}
						}
						unset($result->join_db_table);
						// set filter details
						$filter = json_decode($result->filter,true);
						unset($result->filter);
						$result->filter = array();
						if (ComponentbuilderHelper::checkArray($filter))
						{
							foreach ($filter as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'operator')
										{
											$value = $operatorArray[$value];
											$result->filter[$nr]['key'] = $result->key;
										}
										$result->filter[$nr][$option] = $value;
									}
								}
							}
						}
						// set global details
						$global = json_decode($result->global,true);
						unset($result->global);
						$result->global = array();
						if (ComponentbuilderHelper::checkArray($global))
						{
							foreach ($global as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										$result->global[$nr][$option] = $value;
									}
								}
							}
						}
						// set order details
						$order = json_decode($result->order,true);
						unset($result->order);
						$result->order = array();
						if (ComponentbuilderHelper::checkArray($order))
						{
							foreach ($order as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										$result->order[$nr][$option] = $value;
									}
								}
							}
						}
						// set where details
						$where = json_decode($result->where,true);
						unset($result->where);
						$result->where = array();
						if (ComponentbuilderHelper::checkArray($where))
						{
							foreach ($where as $option => $values)
							{
								foreach ($values as $nr => $value)
								{
									if (ComponentbuilderHelper::checkString($value))
									{
										if ($option == 'operator')
										{
											$value = $operatorArray[$value];
										}
										$result->where[$nr][$option] = $value;
									}
								}
							}
						}
					}
					return $results;
				}
			}
		}
		return false;
	}

	protected function setDataSelection($method_key,$view_code,$string,$asset,$as,$row_type,$type)
	{
		if (ComponentbuilderHelper::checkString($string))
		{
			$lines = explode(PHP_EOL,$string);
			if (ComponentbuilderHelper::checkArray($lines))
			{
				$db = JFactory::getDbo();
				if ('db' == $type)
				{
					$table = '#__'.$asset;
					$queryName = $asset;
					$view =  '';
				}
				elseif ('view' == $type)
				{
					$view = $this->getViewTableName($asset);
					$table = '#__'.$this->componentCodeName.'_'.$view;
					$queryName = $view;
				}
				$gets = array();
				$keys = array();
				foreach ($lines as $line)
				{
					if (strpos($line,'AS') !== false)
					{
						list($get,$key) = explode("AS",$line);
					}
					elseif (strpos($line,'as') !== false)
					{
						list($get,$key) = explode("as",$line);
					}
					else
					{
						$get = $line;
						$key = null;
					}
					$get = trim($get);
					$key = trim($key);
					// only add the view
					if ('a' != $as && 1 == $row_type && 'view' == $type && strpos('#'.$key,'#'.$view.'_') === false)
					{
						$key = $view.'_'.trim($key);
					}
					if (ComponentbuilderHelper::checkString($get))
					{
						$gets[] = $db->quote($get);
						if (ComponentbuilderHelper::checkString($key))
						{
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[] = $db->quote($key);
						}
						else
						{
							$key = str_replace($as.'.','',$get);
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[] = $db->quote($key);
						}
						if (ComponentbuilderHelper::checkString($view))
						{
							$field = str_replace($as.'.','',$get);
							$this->siteFields[$view][$field][$method_key] = array('site' => $view_code, 'get' => $get, 'as' => $as, 'key' => $key);
						}
					}
				}
				if (ComponentbuilderHelper::checkArray($gets) && ComponentbuilderHelper::checkArray($keys))
				{
					$querySelect = '$query->select($db->quoteName('."\n\t\t\t".'array('.implode(',',$gets).'),'."\n\t\t\t".'array('.implode(',',$keys).')));';
					$queryFrom = '$db->quoteName('.$db->quote($table).', '.$db->quote($as).')';
					// return the select query
					return array('select' => $querySelect, 'from' => $queryFrom, 'name' => $queryName, 'table' => $table, 'type' => $type, 'select_gets' => $gets, 'select_keys' => $keys);
				}
			}
		}
		return false;
	}

	protected function getViewTableName($id)
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.name_single')));
		$query->from($db->quoteName('#__componentbuilder_admin_view','a'));
		$query->where($db->quoteName('a.id') . ' = '. (int) $id);
		$db->setQuery($query);
		return ComponentbuilderHelper::safeString($db->loadResult());

	}

	protected function buildSqlDump($tables,$view,$view_id)
	{
		// first build a query statment to get all the data (insure it must be added - check the tweaking)
		if (ComponentbuilderHelper::checkArray($tables) && (!isset($this->sqlTweak[$view_id]['remove']) || !$this->sqlTweak[$view_id]['remove']))
		{
			$counter = 'a';
			// Get a db connection.
			$db = JFactory::getDbo();
			// Create a new query object.
			$query = $db->getQuery(true);
			foreach ($tables as $table)
			{
				if ($counter == 'a')
				{
					// the main table fields
					if (strpos($table['sourcemap'],PHP_EOL) !== false)
					{
						$fields = explode(PHP_EOL,$table['sourcemap']);
						if (ComponentbuilderHelper::checkArray($fields))
						{
							// reset array buckets
							$sourceArray = array();
							$targetArray = array();
							foreach ($fields as $field)
							{
								if (strpos($field,"=>") !== false)
								{
									list($source,$target) = explode("=>",$field);
									$sourceArray[] = $counter.'.'.trim($source);
									$targetArray[] = trim($target);
								}
							}
							if (ComponentbuilderHelper::checkArray($sourceArray) && ComponentbuilderHelper::checkArray($targetArray))
							{
								// add to query
								$query->select($db->quoteName($sourceArray,$targetArray));
								$query->from('#__'.$table['table'].' AS a');
							}
							// we may need to filter the selection
							if (isset($this->sqlTweak[$view_id]['where']))
							{
								// add to query the where filter
								$query->where('a.id IN (' . $this->sqlTweak[$view_id]['where'] . ')');
							}
						}
					}
				}
				else
				{
					// the other tables
					if (strpos($table['sourcemap'],PHP_EOL) !== false)
					{
						$fields = explode(PHP_EOL,$table['sourcemap']);
						if (ComponentbuilderHelper::checkArray($fields))
						{
							// reset array buckets
							$sourceArray = array();
							$targetArray = array();
							foreach ($fields as $field)
							{
								if (strpos($field,"=>") !== false)
								{
									list($source,$target) = explode("=>",$field);
									$sourceArray[] = $counter.'.'.trim($source);
									$targetArray[] = trim($target);
								}
								if (strpos($field,"==") !== false)
								{
									list($aKey,$bKey) = explode("==",$field);
									// add to query
									$query->join('LEFT', $db->quoteName('#__'.$table['table'], $counter) . ' ON (' . $db->quoteName('a.'.trim($aKey)) . ' = ' . $db->quoteName($counter.'.'.trim($bKey)) . ')');
								}
							}
							if (ComponentbuilderHelper::checkArray($sourceArray) && ComponentbuilderHelper::checkArray($targetArray))
							{
								// add to query
								$query->select($db->quoteName($sourceArray,$targetArray));
							}
						}
					}
				}
				$counter++;
			}
			// now get the data
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				// get the data
				$data = $db->loadObjectList();
				// echo'<pre>';var_dump($data);exit;
				// start building the MySql dump
				$dump = "--";
				$dump .= "\n-- Dumping data for table `#__[[[component]]]_".$view."`";
				$dump .= "\n--";
				$dump .= "\n\nINSERT INTO `#__[[[component]]]_".$view."` (";
				foreach ($data as $line)
				{
					$comaSet = 0;
					foreach($line as $fieldName => $fieldValue)
					{
						if ($comaSet == 0)
						{
							$dump .= $db->quoteName($fieldName);
						}
						else
						{
							$dump .= ", ".$db->quoteName($fieldName);
						}
						$comaSet++;
					}
					break;
				}
				$dump .= ") VALUES";
				$coma = 0;
				foreach ($data as $line)
				{
					if ($coma == 0)
					{
						$dump .= "\n(";
					}
					else
					{
						$dump .= ",\n(";
					}
					$comaSet = 0;
					foreach($line as $fieldName => $fieldValue)
					{
						if ($comaSet == 0)
						{
							$dump .= $this->mysql_escape($fieldValue);
						}
						else
						{
							$dump .= ", ". $this->mysql_escape($fieldValue);
						}
						$comaSet++;
					}
					$dump .= ")";
					$coma++;
				}
				$dump .= ";";
				// return build dump query
				return $dump;
			}
		}
		return false;
	}

	protected function mysql_escape($value)
	{
		// if array then return maped
		if(ComponentbuilderHelper::checkArray($value))
		{
			return array_map(__METHOD__, $value);
		}
		// if string make sure it is correctly escaped
		if(ComponentbuilderHelper::checkString($value) && !is_numeric($value))
		{
			// Get a db connection.
			$db = JFactory::getDbo();
			return $db->quote($value);
		}
		// if empty value return place holder
		if(empty($value))
		{
			return "''";
		}
		// if not array or string then return number
		return $value;
	}

	protected function getFieldData($id,$name_single = null,$name_list = null)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Order it by the ordering field.
		$query->select('a.*');
		$query->select($db->quoteName(array('c.name', 'c.properties'),array('type_name','type_properties')));
		$query->from('#__componentbuilder_field AS a');
		$query->join('LEFT', $db->quoteName('#__componentbuilder_fieldtype', 'c') . ' ON (' . $db->quoteName('a.type') . ' = ' . $db->quoteName('c.id') . ')');
		$query->where($db->quoteName('a.id') . ' = '. $db->quote($id));

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$field = $db->loadObject();

		// load the values form params
		$field->xml = json_decode($field->xml);

		// load the type values form type params
		$properties = json_decode($field->type_properties,true);
		unset($field->type_properties);

		if (ComponentbuilderHelper::checkArray($properties))
		{
			foreach ($properties as $option => $values)
			{
				foreach ($values as $nr => $value)
				{
					$field->properties[$nr][$option] = $value;
				}
			}
		}
		// check if we have advanced encryption
		if (4 == $field->store &&  (!isset($this->advancedEncryption) || !$this->advancedEncryption))
		{
			 $this->advancedEncryption = true;
		}
		// check if we have basic encryption
		elseif (3 == $field->store &&  (!isset($this->basicEncryption) || !$this->basicEncryption))
		{
			 $this->basicEncryption = true;
		}

		// check if we should load scripts for single view
		if (ComponentbuilderHelper::checkString($name_single) && !isset($this->customFieldScript[$name_single][$id]))
		{
			// add_javascript_view_footer
			if ($field->add_javascript_view_footer == 1)
			{
				if(!isset($this->customScriptBuilder['view_footer']))
				{
					$this->customScriptBuilder['view_footer'] = array();
				}
				if (!isset($this->customScriptBuilder['view_footer'][$name_single]))
				{
					$this->customScriptBuilder['view_footer'][$name_single] = '';
				}
				$this->customScriptBuilder['view_footer'][$name_single] .= "\n".base64_decode($field->javascript_view_footer);
				if (strpos($field->javascript_view_footer,"token") !== false && strpos($field->javascript_view_footer,"task=ajax") !== false)
				{
					if (!isset($this->customScriptBuilder['token'][$name_single]) || !$this->customScriptBuilder['token'][$name_single])
					{
						if(!isset($this->customScriptBuilder['token']))
						{
							$this->customScriptBuilder['token'] = array();
						}
						$this->customScriptBuilder['token'][$name_single] = true;
					}
				}
				unset($field->javascript_view_footer);
			}

			// add_css_view
			if ($field->add_css_view == 1)
			{
				if (!isset($this->customScriptBuilder['css_view'][$name_single]))
				{
					$this->customScriptBuilder['css_view'][$name_single] = '';
				}
				$this->customScriptBuilder['css_view'][$name_single] .= "\n".base64_decode($field->css_view);
				unset($field->css_view);
			}

			// add this only once to view.
			$this->customFieldScript[$name_single][$id] = true;
		}
		else
		{
			// unset if not needed
			unset($field->javascript_view_footer);
			unset($field->css_view);
		}
		// check if we should load scripts for list views
		if (ComponentbuilderHelper::checkString($name_list))
		{
			// add_javascript_views_footer
			if ($field->add_javascript_views_footer == 1)
			{
				$field->javascript_views_footer = base64_decode($field->javascript_views_footer);
				$this->customScriptBuilder['views_footer'][$name_list] .= $field->javascript_views_footer;
				if (strpos($field->javascript_views_footer,"token") !== false && strpos($field->javascript_views_footer,"task=ajax") !== false)
				{
					if (!$this->customScriptBuilder['token'][$name_list])
					{
						$this->customScriptBuilder['token'][$name_list] = true;
					}
				}
				unset($field->javascript_views_footer);
			}
			// add_css_views
			if ($field->add_css_views == 1)
			{
				if (!isset($this->customScriptBuilder['css_views'][$name_list]))
				{
					$this->customScriptBuilder['css_views'][$name_list] = '';
				}
				$this->customScriptBuilder['css_views'][$name_list] .= base64_decode($field->css_views);
				unset($field->css_views);
			}
		}
		else
		{
			// unset if not needed
			unset($field->javascript_views_footer);
			unset($field->css_views);

		}
		// return the found field data
		return $field;
	}

	protected function defaultField($type,$option = 'default')
	{
		// list of default fields
		// https://docs.joomla.org/Form_field
		$defaults = array(
			'default' => array(
				'accesslevel','cachehandler','calendar','captcha','category','checkbox',
				'checkboxes','color','combo','componentlayout','contentlanguage','editor',
				'chromestyle','contenttype','databaseconnection','editors','email','file',
				'filelist','folderlist','groupedlist','hidden','file','headertag','helpsite',
				'imagelist','integer','language','list','media','menu','note','number','password',
				'plugins','radio','repeatable','range','rules','sessionhandler','spacer','sql','tag',
				'tel','menuitem','meter','modulelayout','moduleorder','moduleposition','moduletag',
				'templatestyle','text','textarea','timezone','url','user','usergroup'
			),
			'plain' => array(
				'accesslevel','checkbox','cachehandler','calendar','category','chromestyle','color',
				'contenttype','combo','componentlayout','databaseconnection','editor','editors',
				'email','file','filelist','folderlist','headertag','helpsite',
				'hidden','imagelist','integer','language','media','menu',
				'menuitem','meter','modulelayout','moduleorder','moduletag','number','password','range','rules',
				'sessionhandler','tag','tel','text','textarea',
				'timezone','url','user','usergroup'
			),
			'spacer' => array(
				'note','spacer'
			),
			'option' => array(
				'plugins','checkboxes','contentlanguage','list','radio','sql'
			),
			'special' => array(
				'contentlanguage','groupedlist','moduleposition','plugin',
				'repeatable','templatestyle'
			)
		);

		if (in_array($type,$defaults[$option]))
		{
			return true;
		}
		return false;
	}

	protected function buildFolders()
	{
		if (ComponentbuilderHelper::checkObject($this->joomlaVersionData->create))
		{
			// creat the main componet folder
			if (!JFolder::exists($this->componentPath))
			{
				JFolder::create($this->componentPath);
				// count the folder created
				$this->folderCount++;
				$this->indexHTML('');
			}
			// now build all folders needed for this component
			foreach ($this->joomlaVersionData->create as $main => $folders)
			{
				if (!JFolder::exists($this->componentPath.'/'.$main))
				{
					JFolder::create($this->componentPath.'/'.$main);
					// count the folder created
					$this->folderCount++;
					$this->indexHTML($main);
				}
				if (ComponentbuilderHelper::checkObject($folders))
				{
					foreach ($folders as $sub => $subFolders)
					{
						if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub))
						{
							JFolder::create($this->componentPath.'/'.$main.'/'.$sub);
							// count the folder created
							$this->folderCount++;
							$this->indexHTML($main.'/'.$sub);
						}
						if (ComponentbuilderHelper::checkObject($subFolders))
						{
							foreach ($subFolders as $sub_2 => $subFolders_2)
							{
								if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2))
								{
									JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2);
									// count the folder created
									$this->folderCount++;
									$this->indexHTML($main.'/'.$sub.'/'.$sub_2);
								}
								if (ComponentbuilderHelper::checkObject($subFolders_2))
								{
									foreach ($subFolders_2 as $sub_3 => $subFolders_3)
									{

										if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3))
										{
											JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3);
											// count the folder created
											$this->folderCount++;
											$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3);
										}
										if (ComponentbuilderHelper::checkObject($subFolders_3))
										{
											foreach ($subFolders_3 as $sub_4 => $subFolders_4)
											{
												if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4))
												{
													JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4);
													// count the folder created
													$this->folderCount++;
													$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4);
												}
												if (ComponentbuilderHelper::checkObject($subFolders_4))
												{
													foreach ($subFolders_4 as $sub_5 => $subFolders_5)
													{
														if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5))
														{
															JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5);
															// count the folder created
															$this->folderCount++;
															$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5);
														}
														if (ComponentbuilderHelper::checkObject($subFolders_5))
														{
															foreach ($subFolders_5 as $sub_6 => $subFolders_6)
															{
																if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6))
																{
																	JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6);
																	// count the folder created
																	$this->folderCount++;
																	$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6);
																}
																if (ComponentbuilderHelper::checkObject($subFolders_6))
																{
																	foreach ($subFolders_6 as $sub_7 => $subFolders_7)
																	{
																		if (!JFolder::exists($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6.'/'.$sub_7))
																		{
																			JFolder::create($this->componentPath.'/'.$main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6.'/'.$sub_7);
																			// count the folder created
																			$this->folderCount++;
																			$this->indexHTML($main.'/'.$sub.'/'.$sub_2.'/'.$sub_3.'/'.$sub_4.'/'.$sub_5.'/'.$sub_6.'/'.$sub_7);
																		}
																	}
																}
															}
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			return true;
		}
		return false;
	}

	protected function getInbetweenStrings($str, $start = '###', $end = '###')
	{
		$matches = array();
		$regex = "/$start([a-zA-Z0-9_]*)$end/";
		preg_match_all($regex, $str, $matches);
		return $matches[1];
	}

	protected function indexHTML($path)
	{
		if (strlen($path) > 0)
		{
			JFile::copy($this->templatePath.'/index.html', $this->componentPath.'/'.$path.'/index.html');
			// count the file created
			$this->fileCount++;
		}
		else
		{
			JFile::copy($this->templatePath.'/index.html', $this->componentPath.'/index.html');
			// count the file created
			$this->fileCount++;
		}
	}
}
