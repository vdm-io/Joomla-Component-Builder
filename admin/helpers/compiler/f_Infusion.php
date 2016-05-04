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

/**
 * Interpretation class
 */
class Infusion extends Interpretation
{

	public $eximportView = array();
	public $importCustomScripts = array();

	/**
	 * Constructor
	 */
	public function __construct($config = array ())
	{
		// first we run the perent constructor
		if (parent::__construct($config))
		{
			// infuse the data into the structure
			return $this->buildFileContent();		
		}
		return false;
	}
	
	/**
	 * Build the content for the structure
	 * 
	 *
	 * @return  boolean  on success
	 * 
	 */
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
			$this->fileContentStatic['###COMPANYNAME###'] = trim(JFilterOutput::cleanText($this->componentData->companyname));
			
			// ###CREATIONDATE###
			$this->fileContentStatic['###CREATIONDATE###'] = JFactory::getDate($this->componentData->created)->format('jS F, Y');
			
			// ###BUILDDATE###
			$this->fileContentStatic['###BUILDDATE###'] = JFactory::getDate()->format('jS F, Y');
			
			// ###AUTHOR###
			$this->fileContentStatic['###AUTHOR###'] = trim(JFilterOutput::cleanText($this->componentData->author));

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
			$this->fileContentStatic['###Component_name###'] = JFilterOutput::cleanText($this->componentData->name);;

			// ###SHORT_DISCRIPTION###
			$this->fileContentStatic['###SHORT_DESCRIPTION###'] = trim(JFilterOutput::cleanText($this->componentData->short_description));

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

			// build route parse switch
			$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] = '';
			// build route views
			$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] = '';
			
			// add the helper emailer if set
			$this->fileContentStatic['###HELPER_EMAIL###'] = $this->addEmailHelper();

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
						$this->placeholders['###VIEW###'] = $viewName_u;
						$this->placeholders['###View###'] = $viewName_f;
						
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
						
						if (isset($this->customScriptBuilder['php_document'][$viewName_single]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['php_document'][$viewName_single]))
						{
							// ###DOCUMENT_CUSTOM_PHP### <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_single]['###DOCUMENT_CUSTOM_PHP###'] 
								= "\n".str_replace(array_keys($this->placeholders),array_values($this->placeholders),$this->customScriptBuilder['php_document'][$viewName_single]);
							// clear some memory
							unset($this->customScriptBuilder['php_document'][$viewName_single]);
						}
						else
						{
							$this->fileContentDynamic[$viewName_single]['###DOCUMENT_CUSTOM_PHP###'] = '';
						}
						
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
						$this->placeholders['###VIEWS###'] = $viewsName_u;
						$this->placeholders['###Views###'] = $viewsName_f;
						
						// set the export/import option
						if ($view['port'])
						{
							$this->eximportView[$viewName_list] = true;
							if (1 == $view['settings']->add_custom_import)
							{
								// this view has custom import scripting
								$this->importCustomScripts[$viewName_list] = true;
								$this->setImportCustomScripts($viewName_list);
							}
						}
						else
						{
							$this->eximportView[$viewName_list] = false;
						}

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
					
					if ($view['edit_create_site_view'])
					{
						// add needed router stuff for front edit views
						$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] .= $this->routerParseSwitch($viewName_single);
						$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] .= $this->routerBuildViews($viewName_single);
					}

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

				// ###DASH_MODEL_METHODS###
				$this->fileContentDynamic[$this->fileContentStatic['###component###']]['###DASH_MODEL_METHODS###'] = $this->setDashboardModelMethods();

				// ###DASH_GET_CUSTOM_DATA###
				$this->fileContentDynamic[$this->fileContentStatic['###component###']]['###DASH_GET_CUSTOM_DATA###'] = $this->setDashboardGetCustomData();

				// ###DASH_DISPLAY_DATA###
				$this->fileContentDynamic[$this->fileContentStatic['###component###']]['###DASH_DISPLAY_DATA###'] = $this->setDashboardDisplayData();
				
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
			
			// setup front-views and all needed stuff for the site
			if (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views))
			{
				$this->target = 'site';
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
					$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] .= $this->routerParseSwitch($view['settings']->code);
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

}
