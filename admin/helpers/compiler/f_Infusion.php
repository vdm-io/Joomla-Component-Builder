<?php

/* --------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
  __      __       _     _____                 _                                  _     __  __      _   _               _
  \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
   \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
    \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
     \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
      \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                      | |
                                                      |_|
  /-------------------------------------------------------------------------------------------------------------------------------/

  @version		2.6.x
  @created		30th April, 2015
  @package		Component Builder
  @subpackage	compiler.php
  @author		Llewellyn van der Merwe <http://www.vdm.io>
  @my wife		Roline van der Merwe <http://www.vdm.io/>
  @copyright	Copyright (C) 2015. All Rights Reserved
  @license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html

  Builds Complex Joomla Components

  /----------------------------------------------------------------------------------------------------------------------------- */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Interpretation class
 */
class Infusion extends Interpretation
{

	public $eximportView = array();
	public $importCustomScripts = array();
	public $langFiles = array();
	public $removeSiteFolder = false;
	public $langNot = array();
	public $langSet = array();

	/**
	 * Constructor
	 */
	public function __construct($config = array())
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
	 * Set the line number in comments
	 * 
	 * @param   int   $nr  The line number
	 * 
	 * @return  void
	 * 
	 */
	private function setLine($nr)
	{
		if ($this->debugLinenr)
		{
			return ' [Infusion ' . $nr . ']';
		}
		return '';
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
			$this->fileContentStatic['###COMPONENT###'] = $this->placeholders['###COMPONENT###'];

			// ###Component###
			$this->fileContentStatic['###Component###'] = $this->placeholders['###Component###'];

			// ###component###
			$this->fileContentStatic['###component###'] = $this->placeholders['###component###'];

			// ###COMPANYNAME###
			$this->fileContentStatic['###COMPANYNAME###'] = trim(JFilterOutput::cleanText($this->componentData->companyname));

			// ###CREATIONDATE###
			$this->fileContentStatic['###CREATIONDATE###'] = JFactory::getDate($this->componentData->created)->format('jS F, Y');
			$this->fileContentStatic['###CREATIONDATE###GLOBAL'] = $this->fileContentStatic['###CREATIONDATE###'];

			// ###BUILDDATE###
			$this->fileContentStatic['###BUILDDATE###'] = JFactory::getDate()->format('jS F, Y');
			$this->fileContentStatic['###BUILDDATE###GLOBAL'] = $this->fileContentStatic['###BUILDDATE###'];

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
			// set the actual global version
			$this->fileContentStatic['###ACTUALVERSION###'] = $this->fileContentStatic['###VERSION###'];

			// do some Tweaks to the version based on selected options
			if (strpos($this->fileContentStatic['###VERSION###'], '.') !== false)
			{
				$versionArray = explode('.', $this->fileContentStatic['###VERSION###']);
			}
			// load only first two values
			if (isset($versionArray) && ComponentbuilderHelper::checkArray($versionArray) && $this->componentData->mvc_versiondate == 2)
			{
				$this->fileContentStatic['###VERSION###'] = $versionArray[0] . '.' . $versionArray[1] . '.x';
			}
			// load only the first value
			elseif (isset($versionArray) && ComponentbuilderHelper::checkArray($versionArray) && $this->componentData->mvc_versiondate == 3)
			{
				$this->fileContentStatic['###VERSION###'] = $versionArray[0] . '.x.x';
			}
			unset($versionArray);

			// set the global version in case			
			$this->fileContentStatic['###VERSION###GLOBAL'] = $this->fileContentStatic['###VERSION###'];

			// ###Component_name###
			$this->fileContentStatic['###Component_name###'] = JFilterOutput::cleanText($this->componentData->name);

			// ###SHORT_DISCRIPTION###
			$this->fileContentStatic['###SHORT_DESCRIPTION###'] = trim(JFilterOutput::cleanText($this->componentData->short_description));

			// ###DESCRIPTION###
			$this->fileContentStatic['###DESCRIPTION###'] = trim($this->componentData->description);

			// ###COMP_IMAGE_TYPE###
			$this->fileContentStatic['###COMP_IMAGE_TYPE###'] = $this->setComponentImageType($this->componentData->image);

			// ###ACCESS_SECTIONS###
			$this->fileContentStatic['###ACCESS_SECTIONS###'] = $this->setAccessSections();

			// ###CONFIG_FIELDSETS###
			$keepLang = $this->lang;
			$this->lang = 'admin';

			// start loading the category tree scripts
			$this->fileContentStatic['###CATEGORY_CLASS_TREES###'] = '';
			// run the field sets for first time
			$this->setConfigFieldsets(1);
			$this->lang = $keepLang;

			// ###ADMINJS###
			$this->fileContentStatic['###ADMINJS###'] = $this->setPlaceholders($this->customScriptBuilder['component_js'], $this->placeholders);
			// ###SITEJS###
			$this->fileContentStatic['###SITEJS###'] = $this->setPlaceholders($this->customScriptBuilder['component_js'], $this->placeholders);

			// ###ADMINCSS###
			$this->fileContentStatic['###ADMINCSS###'] = $this->setPlaceholders($this->customScriptBuilder['component_css_admin'], $this->placeholders);
			// ###SITECSS###
			$this->fileContentStatic['###SITECSS###'] = $this->setPlaceholders($this->customScriptBuilder['component_css_site'], $this->placeholders);

			// ###CUSTOM_HELPER_SCRIPT###
			$this->fileContentStatic['###CUSTOM_HELPER_SCRIPT###'] = $this->setPlaceholders($this->customScriptBuilder['component_php_helper_admin'], $this->placeholders);

			// ###BOTH_CUSTOM_HELPER_SCRIPT###
			$this->fileContentStatic['###BOTH_CUSTOM_HELPER_SCRIPT###'] = $this->setPlaceholders($this->customScriptBuilder['component_php_helper_both'], $this->placeholders);

			// ###ADMIN_GLOBAL_EVENT_HELPER###
			$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] = '';

			// ###ADMIN_GLOBAL_EVENT###
			$this->fileContentStatic['###ADMIN_GLOBAL_EVENT###'] = '';

			// set incase no extra admin files are loaded
			$this->fileContentStatic['###EXSTRA_ADMIN_FILES###'] = '';

			// now load the data for the global event if needed
			if ($this->componentData->add_admin_event == 1)
			{
				// ###ADMIN_GLOBAL_EVENT###
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT###'] = PHP_EOL . PHP_EOL . '// Triger the Global Admin Event';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT###'] .= PHP_EOL . $this->fileContentStatic['###Component###'] . 'Helper::globalEvent($document);';
				// ###ADMIN_GLOBAL_EVENT_HELPER###
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] = PHP_EOL . PHP_EOL . "\t" . '/**';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '*	The Global Admin Event Method.';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '**/';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . 'public static function globalEvent($document)';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '{';
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . $this->setPlaceholders($this->customScriptBuilder['component_php_admin_event'], $this->placeholders);
				$this->fileContentStatic['###ADMIN_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '}';
			}

			// now load the readme file if needed
			if ($this->componentData->addreadme == 1)
			{
				$this->fileContentStatic['###EXSTRA_ADMIN_FILES###'] .= PHP_EOL . "\t\t\t<filename>README.txt</filename>";
			}

			// ###HELPER_CREATEUSER###
			$this->fileContentStatic['###HELPER_CREATEUSER###'] = $this->setCreateUserHelperMethod($this->componentData->creatuserhelper);

			// ###HELP###
			$this->fileContentStatic['###HELP###'] = $this->noHelp();
			// ###HELP_SITE###
			$this->fileContentStatic['###HELP_SITE###'] = $this->noHelp();

			// build route parse switch
			$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] = '';
			// build route views
			$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] = '';

			// add the helper emailer if set
			$this->fileContentStatic['###HELPER_EMAIL###'] = $this->addEmailHelper();

			// reset view array
			$viewarray = array();
			$site_edit_view_array = array();
			// start dynamic build
			foreach ($this->componentData->admin_views as $view)
			{
				// set the target
				$this->target = 'admin';
				$this->lang = 'admin';

				// set single view
				if (isset($view['settings']->name_single))
				{
					$viewName_single = ComponentbuilderHelper::safeString($view['settings']->name_single);
				}

				// set list view
				if (isset($view['settings']->name_list))
				{
					$viewName_list = ComponentbuilderHelper::safeString($view['settings']->name_list);
				}

				// set the view placeholders
				$this->setViewPlaceholders($view['settings']);

				// set site edit view array
				if (isset($view['edit_create_site_view']) && $view['edit_create_site_view'])
				{
					$site_edit_view_array[] = "\t\t\t\t'" . $viewName_single . "'";
					$this->lang = 'both';
				}
				// check if help is being loaded
				$this->checkHelp($viewName_single);
				// set custom admin view list links
				$this->setCustomAdminViewListLink($view, $viewName_list);

				// set view array
				$viewarray[] = "\t\t\t\t'" . $viewName_single . "' => '" . $viewName_list . "'";
				// set the view names
				if (isset($view['settings']->name_single) && $view['settings']->name_single != 'null')
				{
					// set license per view if needed
					$this->setLockLicensePer($viewName_single, $this->target);
					$this->setLockLicensePer($viewName_list, $this->target);

					// ###FIELDSETS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###FIELDSETS###'] = $this->setFieldSet($view, $this->fileContentStatic['###component###'], $viewName_single, $viewName_list);

					// ###ACCESSCONTROL### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###ACCESSCONTROL###'] = $this->setFieldSetAccessControl($viewName_single);

					// ###LINKEDVIEWITEMS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWITEMS###'] = '';

					// ###ADDTOOLBAR### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###ADDTOOLBAR###'] = $this->setAddToolBar($view);

					// set the script for this view
					$this->buildTheViewScript($view);

					// ###VIEW_SCRIPT###
					$this->fileContentDynamic[$viewName_single]['###VIEW_SCRIPT###'] = $this->setViewScript($viewName_single);

					// ###EDITBODYSCRIPT###
					$this->fileContentDynamic[$viewName_single]['###EDITBODYSCRIPT###'] = $this->setEditBodyScript($viewName_single);

					// ###AJAXTOKE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###AJAXTOKE###'] = $this->setAjaxToke($viewName_single);

					// ###DOCUMENT_CUSTOM_PHP### <<<DYNAMIC>>>
					if ($phpDocument = $this->getCustomScriptBuilder('php_document', $viewName_single, PHP_EOL, null, true, false))
					{
						$this->fileContentDynamic[$viewName_single]['###DOCUMENT_CUSTOM_PHP###'] = str_replace('$document->', '$this->document->', $phpDocument);
						// clear some memory
						unset($phpDocument);
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

					// ###EDITBODY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###EDITBODYFADEIN###'] = $this->setFadeInEfect($view);

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
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_BEFORE_DELETE###'] = $this->getCustomScriptBuilder('php_before_delete', $viewName_single, PHP_EOL);

					// ###JMODELADMIN_AFTER_DELETE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_AFTER_DELETE###'] = $this->getCustomScriptBuilder('php_after_delete', $viewName_single, PHP_EOL . PHP_EOL);

					// ###JMODELADMIN_BEFORE_DELETE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_BEFORE_PUBLISH###'] = $this->getCustomScriptBuilder('php_before_publish', $viewName_single, PHP_EOL);

					// ###JMODELADMIN_AFTER_DELETE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_AFTER_PUBLISH###'] = $this->getCustomScriptBuilder('php_after_publish', $viewName_single, PHP_EOL . PHP_EOL);

					// ###CHECKBOX_SAVE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###CHECKBOX_SAVE###'] = $this->setCheckboxSave($viewName_single);

					// ###METHOD_ITEM_SAVE### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###METHOD_ITEM_SAVE###'] = $this->setMethodItemSave($viewName_single);

					// ###POSTSAVEHOOK### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###POSTSAVEHOOK###'] = $this->getCustomScriptBuilder('php_postsavehook', $viewName_single, PHP_EOL, null, true, PHP_EOL . "\t\treturn;", PHP_EOL . PHP_EOL . "\t\treturn;");

					// ###VIEWCSS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single]['###VIEWCSS###'] = $this->getCustomScriptBuilder('css_view', $viewName_single, '', null, true);

					// add css to front end
					if (isset($view['edit_create_site_view']) && $view['edit_create_site_view'])
					{
						$this->fileContentDynamic[$viewName_single]['###SITE_VIEWCSS###'] = $this->fileContentDynamic[$viewName_single]['###VIEWCSS###'];
					}
				}
				// set the views names
				if (isset($view['settings']->name_list) && $view['settings']->name_list != 'null')
				{
					$this->lang = 'admin';

					// ###ICOMOON### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###ICOMOON###'] = $view['icomoon'];

					// set the export/import option
					if (isset($view['port']) && $view['port'] || 1 == $view['settings']->add_custom_import)
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
					if (isset($view['checkin']) && $view['checkin'] == 1)
					{
						// ###AUTOCHECKIN### <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list]['###AUTOCHECKIN###'] = $this->setAutoCheckin($viewName_single, $this->fileContentStatic['###component###']);
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
					// ###ADMIN_CUSTOM_BUTTONS_LIST###
					$this->fileContentDynamic[$viewName_list]['###ADMIN_CUSTOM_BUTTONS_LIST###'] = $this->setCustomButtons($view, 3, "\t");
					$this->fileContentDynamic[$viewName_list]['###ADMIN_CUSTOM_FUNCTION_ONLY_BUTTONS_LIST###'] = $this->setFunctionOnlyButtons($viewName_list);

					// ###GET_ITEMS_METHOD_STRING_FIX### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###GET_ITEMS_METHOD_STRING_FIX###'] = $this->setGetItemsMethodStringFix($viewName_single, $this->fileContentStatic['###Component###']);

					// ###GET_ITEMS_METHOD_AFTER_ALL### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###GET_ITEMS_METHOD_AFTER_ALL###'] = $this->getCustomScriptBuilder('php_getitems_after_all', $viewName_single, PHP_EOL);

					// ###SELECTIONTRANSLATIONFIX### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###SELECTIONTRANSLATIONFIX###'] = $this->setSelectionTranslationFix($viewName_list, $this->fileContentStatic['###Component###']);

					// ###SELECTIONTRANSLATIONFIXFUNC### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###SELECTIONTRANSLATIONFIXFUNC###'] = $this->setSelectionTranslationFixFunc($viewName_list, $this->fileContentStatic['###Component###']);

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
					$this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###'] .= $this->setRouterCategoryViews($viewName_single, $viewName_list);

					// ###OTHERFILTERS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###OTHERFILTERS###'] = $this->setOtherFilter($viewName_list);

					// ###FILTERFUNCTIONS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###FILTERFUNCTIONS###'] = $this->setFilterFunctions($viewName_single, $viewName_list);

					// ###LISTQUERY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###LISTQUERY###'] = $this->setListQuery($viewName_single, $viewName_list);

					// ###MODELEXPORTMETHOD### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###MODELEXPORTMETHOD###'] = $this->setModelExportMethod($viewName_single, $viewName_list);

					// ###MODELEXIMPORTMETHOD### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###CONTROLLEREXIMPORTMETHOD###'] = $this->setControllerEximportMethod($viewName_single, $viewName_list);

					// ###EXPORTBUTTON### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###EXPORTBUTTON###'] = $this->setExportButton($viewName_single, $viewName_list);

					// ###IMPORTBUTTON### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###IMPORTBUTTON###'] = $this->setImportButton($viewName_single, $viewName_list);

					// ###LISTHEAD### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###LISTHEAD###'] = $this->setListHead($viewName_single, $viewName_list);

					// ###LISTBODY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###LISTBODY###'] = $this->setListBody($viewName_single, $viewName_list);

					// ###LISTCOLNR### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###LISTCOLNR###'] = $this->setListColnr($viewName_list);

					// ###JVIEWLISTCANDO### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###JVIEWLISTCANDO###'] = $this->setJviewListCanDo($viewName_single, $viewName_list);

					// ###VIEWSCSS### <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list]['###VIEWSCSS###'] = $this->getCustomScriptBuilder('css_views', $viewName_list, '', null, true);

					// ###VIEWS_FOOTER_SCRIPT### <<<DYNAMIC>>>
					$scriptNote = PHP_EOL . '//' . $this->setLine(__LINE__) . ' ' . $viewName_list.' footer script';
					if ($footerScript = $this->getCustomScriptBuilder('views_footer', $viewName_single, '', $scriptNote, true, false, PHP_EOL))
					{
						// only minfy if no php is added to the footer script
						if ($this->minify && strpos($footerScript, '<?php') === false)
						{
							// minfy the script
							$minifier = new JS;
							$minifier->add($footerScript);
							$footerScript = $minifier->minify();
							// clear some memory
							unset($minifier);
						}
						$this->fileContentDynamic[$viewName_list]['###VIEWS_FOOTER_SCRIPT###'] = PHP_EOL . '<script type="text/javascript">' . $footerScript . "</script>";
						// clear some memory
						unset($footerScript);
					}
					else
					{
						$this->fileContentDynamic[$viewName_list]['###VIEWS_FOOTER_SCRIPT###'] = '';
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

				// ###BATCH_ONCLICK_CANCEL_SCRIPT### <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_list]['###BATCH_ONCLICK_CANCEL_SCRIPT###'] = ''; // TODO <-- must still be build
				// ###JCONTROLLERFORM_ALLOWADD### <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single]['###JCONTROLLERFORM_ALLOWADD###'] = $this->setJcontrollerAllowAdd($viewName_single, $viewName_list);

				// ###JCONTROLLERFORM_ALLOWEDIT### <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single]['###JCONTROLLERFORM_ALLOWEDIT###'] = $this->setJcontrollerAllowEdit($viewName_single, $viewName_list);

				// ###JMODELADMIN_GETFORM### <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_GETFORM###'] = $this->setJmodelAdminGetForm($viewName_single, $viewName_list);

				// ###JMODELADMIN_ALLOWEDIT### <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_ALLOWEDIT###'] = $this->setJmodelAdminAllowEdit($viewName_single, $viewName_list);

				// ###JMODELADMIN_CANDELETE### <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_CANDELETE###'] = $this->setJmodelAdminCanDelete($viewName_single, $viewName_list);

				// ###JMODELADMIN_CANEDITSTATE### <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single]['###JMODELADMIN_CANEDITSTATE###'] = $this->setJmodelAdminCanEditState($viewName_single, $viewName_list);

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

				if (isset($view['edit_create_site_view']) && $view['edit_create_site_view'])
				{
					// add needed router stuff for front edit views
					$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] .= $this->routerParseSwitch($viewName_single, null, false);
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
				$this->target = 'custom_admin';
				$this->lang = 'admin';
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
					if (!isset($this->langContent[$this->lang][$this->langPrefix . '_' . $view['settings']->CODE]))
					{
						$this->langContent[$this->lang][$this->langPrefix . '_' . $view['settings']->CODE] = $view['settings']->name;
					}
					if (!isset($this->langContent[$this->lang][$this->langPrefix . '_' . $view['settings']->CODE . '_DESC']))
					{
						$this->langContent[$this->lang][$this->langPrefix . '_' . $view['settings']->CODE . '_DESC'] = $view['settings']->description;
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
					$this->setLockLicensePer($view['settings']->code, $this->target);

					if ($view['settings']->main_get->gettype == 1)
					{
						// ###CUSTOM_ADMIN_BEFORE_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_BEFORE_GET_ITEM###'] = $this->getCustomScriptBuilder($this->target . '_php_before_getitem', $view['settings']->code, '', null, true);

						// ###CUSTOM_ADMIN_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_GET_ITEM###'] = $this->setCustomViewGetItem($view['settings']->main_get, $view['settings']->code, "\t\t");

						// ###CUSTOM_ADMIN_AFTER_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_AFTER_GET_ITEM###'] = $this->getCustomScriptBuilder($this->target . '_php_after_getitem', $view['settings']->code, '', null, true);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// ###CUSTOM_ADMIN_GET_LIST_QUERY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_GET_LIST_QUERY###'] = $this->setCustomViewListQuery($view['settings']->main_get, $view['settings']->code);

						// ###CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY###'] = $this->getCustomScriptBuilder($this->target . '_php_getlistquery', $view['settings']->code, PHP_EOL, null, true);

						// ###CUSTOM_ADMIN_BEFORE_GET_ITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_BEFORE_GET_ITEMS###'] = $this->getCustomScriptBuilder($this->target . '_php_before_getitems', $view['settings']->code, PHP_EOL, null, true);

						// ###CUSTOM_ADMIN_GET_ITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_GET_ITEMS###'] = $this->setCustomViewGetItems($view['settings']->main_get, $view['settings']->code);

						// ###CUSTOM_ADMIN_AFTER_GET_ITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_AFTER_GET_ITEMS###'] = $this->getCustomScriptBuilder($this->target . '_php_after_getitems', $view['settings']->code, PHP_EOL, null, true);
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
					// ###CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT### <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code]['###CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT###'] = $this->setCustomViewSubmitButtonScript($view);

					// setup the templates
					$this->setCustomViewTemplateBody($view);
				}

				// setup the layouts
				$this->setCustomViewLayouts();
			}

			// ###VIEWARRAY###
			$this->fileContentStatic['###VIEWARRAY###'] = PHP_EOL . implode("," . PHP_EOL, $viewarray);

			// ###CUSTOM_ADMIN_EDIT_VIEW_ARRAY###
			$this->fileContentStatic['###SITE_EDIT_VIEW_ARRAY###'] = PHP_EOL . implode("," . PHP_EOL, $site_edit_view_array);

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

			// ###UPDATE_VERSION_MYSQL###
			$this->setVersionController();

			// only set these if default dashboard it used
			if (!ComponentbuilderHelper::checkString($this->dynamicDashboard))
			{
				// ###DASHBOARDVIEW###
				$this->fileContentStatic['###DASHBOARDVIEW###'] = $this->fileContentStatic['###component###'];

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
			}
			else
			{
				// ###DASHBOARDVIEW###
				$this->fileContentStatic['###DASHBOARDVIEW###'] = $this->dynamicDashboard;
			}

			// add import
			if (isset($this->addEximport) && $this->addEximport)
			{
				// setup import files
				$target = array('admin' => 'import');
				$this->buildDynamique($target, 'import');
				// set the controller
				$this->fileContentDynamic['import']['###BLABLABLA###'] = '';
			}

			// ensure that the ajax model and controller is set if needed
			if (isset($this->addAjax) && $this->addAjax)
			{
				// setup Ajax files
				$target = array('admin' => 'ajax');
				$this->buildDynamique($target, 'ajax');
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
				$this->buildDynamique($target, 'ajax');
				// set the controller
				$this->fileContentDynamic['ajax']['###REGISTER_SITE_AJAX_TASK###'] = $this->setRegisterAjaxTask('site');
				$this->fileContentDynamic['ajax']['###AJAX_SITE_INPUT_RETURN###'] = $this->setAjaxInputReturn('site');
				// set the module
				$this->fileContentDynamic['ajax']['###AJAX_SITE_MODEL_METHODS###'] = $this->setAjaxModelMethods('site');
			}
			
			// build the validation rules
			if (isset($this->validationRules) && ComponentbuilderHelper::checkArray($this->validationRules))
			{
				foreach ($this->validationRules as $rule => $_php)
				{
					// setup rule file
					$target = array('admin' => 'a_rule_zi');
					$this->buildDynamique($target, 'rule', $rule);
					// set the JFormRule Name
					$this->fileContentDynamic['a_rule_zi_'.$rule]['###Name###'] = ucfirst($rule);
					// set the JFormRule PHP
					$this->fileContentDynamic['a_rule_zi_'.$rule]['###VALIDATION_RULE_METHODS###'] = PHP_EOL . $_php;
				}
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
					$this->setLockLicensePer($view['settings']->code, $this->target);

					// set the site default view
					if (isset($view['default_view']) && $view['default_view'] == 1)
					{
						$this->fileContentStatic['###SITE_DEFAULT_VIEW###'] = $view['settings']->code;
					}
					// add site menu
					if (isset($view['menu']) && $view['menu'] == 1)
					{
						// ###SITE_MENU_XML### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_MENU_XML###'] = $this->setCustomViewMenu($view);
					}

					// insure the needed route helper is loaded
					$this->fileContentStatic['###ROUTEHELPER###'] .= $this->setRouterHelp($view['settings']->code, $view['settings']->code, true);
					// build route details 
					$this->fileContentStatic['###ROUTER_PARSE_SWITCH###'] .= $this->routerParseSwitch($view['settings']->code, $view);
					$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] .= $this->routerBuildViews($view['settings']->code);

					if ($view['settings']->main_get->gettype == 1)
					{
						// set user permission access check ###USER_PERMISSION_CHECK_ACCESS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###USER_PERMISSION_CHECK_ACCESS###'] = $this->setUserPermissionCheckAccess($view, 1);

						// ###SITE_BEFORE_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_BEFORE_GET_ITEM###'] = $this->getCustomScriptBuilder($this->target . '_php_before_getitem', $view['settings']->code, '', null, true);

						// ###SITE_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_GET_ITEM###'] = $this->setCustomViewGetItem($view['settings']->main_get, $view['settings']->code, "\t\t");

						// ###SITE_AFTER_GET_ITEM### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_AFTER_GET_ITEM###'] = $this->getCustomScriptBuilder($this->target . '_php_after_getitem', $view['settings']->code, '', null, true);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// set user permission access check ###USER_PERMISSION_CHECK_ACCESS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###USER_PERMISSION_CHECK_ACCESS###'] = $this->setUserPermissionCheckAccess($view, 2);
						// ###SITE_GET_LIST_QUERY### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_GET_LIST_QUERY###'] = $this->setCustomViewListQuery($view['settings']->main_get, $view['settings']->code);

						// ###SITE_BEFORE_GET_ITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_BEFORE_GET_ITEMS###'] = $this->getCustomScriptBuilder($this->target . '_php_before_getitems', $view['settings']->code, PHP_EOL, null, true);

						// ###SITE_GET_ITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_GET_ITEMS###'] = $this->setCustomViewGetItems($view['settings']->main_get, $view['settings']->code);

						// ###SITE_AFTER_GET_ITEMS### <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code]['###SITE_AFTER_GET_ITEMS###'] = $this->getCustomScriptBuilder($this->target . '_php_after_getitems', $view['settings']->code, PHP_EOL, null, true);
					}
					// add to lang array
					if (!isset($this->langContent['site'][$this->langPrefix . '_' . $view['settings']->CODE]))
					{
						$this->langContent['site'][$this->langPrefix . '_' . $view['settings']->CODE] = $view['settings']->name;
					}
					if (!isset($this->langContent['site'][$this->langPrefix . '_' . $view['settings']->CODE . '_DESC']))
					{
						$this->langContent['site'][$this->langPrefix . '_' . $view['settings']->CODE . '_DESC'] = $view['settings']->description;
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
				// if no default site view was set, the redirect to root
				if (!isset($this->fileContentStatic['###SITE_DEFAULT_VIEW###']))
				{
					$this->fileContentStatic['###SITE_DEFAULT_VIEW###'] = '';
				}
				// set site custom script to helper class
				// ###SITE_CUSTOM_HELPER_SCRIPT###
				$this->fileContentStatic['###SITE_CUSTOM_HELPER_SCRIPT###'] = $this->setPlaceholders($this->customScriptBuilder['component_php_helper_site'], $this->placeholders);
				// ###SITE_GLOBAL_EVENT_HELPER###
				$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] = '';
				// ###SITE_GLOBAL_EVENT###
				$this->fileContentStatic['###SITE_GLOBAL_EVENT###'] = '';
				// now load the data for the global event if needed
				if ($this->componentData->add_site_event == 1)
				{
					$this->fileContentStatic['###SITE_GLOBAL_EVENT###'] = PHP_EOL . PHP_EOL . '// Triger the Global Site Event';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT###'] .= PHP_EOL . $this->fileContentStatic['###Component###'] . 'Helper::globalEvent($document);';
					// ###SITE_GLOBAL_EVENT_HELPER###
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] = PHP_EOL . PHP_EOL . "\t" . '/**';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '*	The Global Site Event Method.';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '**/';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . 'public static function globalEvent($document)';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '{';
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . $this->setPlaceholders($this->customScriptBuilder['component_php_site_event'], $this->placeholders);
					$this->fileContentStatic['###SITE_GLOBAL_EVENT_HELPER###'] .= PHP_EOL . "\t" . '}';
				}
				// setup the layouts
				$this->setCustomViewLayouts();
			}
			else
			{
				// clear all site folder since none is needed
				$this->removeSiteFolder = true;
			}

			// ###PREINSTALLSCRIPT###
			$this->fileContentStatic['###PREINSTALLSCRIPT###'] = $this->getCustomScriptBuilder('php_preflight', 'install', PHP_EOL, null, true);

			// ###PREUPDATESCRIPT###
			$this->fileContentStatic['###PREUPDATESCRIPT###'] = $this->getCustomScriptBuilder('php_preflight', 'update', PHP_EOL, null, true);

			// ###POSTINSTALLSCRIPT###
			$this->fileContentStatic['###POSTINSTALLSCRIPT###'] = $this->setPostInstallScript();

			// ###POSTUPDATESCRIPT###
			$this->fileContentStatic['###POSTUPDATESCRIPT###'] = $this->setPostUpdateScript();

			// ###UNINSTALLSCRIPT###
			$this->fileContentStatic['###UNINSTALLSCRIPT###'] = $this->setUninstallScript();

			// ###MOVEFOLDERSSCRIPT###
			$this->fileContentStatic['###MOVEFOLDERSSCRIPT###'] = $this->setMoveFolderScript();

			// ###MOVEFOLDERSMETHOD###
			$this->fileContentStatic['###MOVEFOLDERSMETHOD###'] = $this->setMoveFolderMethod();

			// ###HELPER_UIKIT###
			$this->fileContentStatic['###HELPER_UIKIT###'] = $this->setUikitHelperMethods();

			// ###CONFIG_FIELDSETS###
			$this->fileContentStatic['###CONFIG_FIELDSETS###'] = implode(PHP_EOL, $this->configFieldSets);

			// check if this has been set
			if (!isset($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']) || !ComponentbuilderHelper::checkString($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']))
			{
				$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] = 0;
			}
			else
			{
				$this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] = '(' . $this->fileContentStatic['###ROUTER_BUILD_VIEWS###'] . ')';
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

	/**
	 * Set the view place holders to global scope
	 * 
	 * @param   object  $view  The view settings
	 * 
	 * @ return void
	 */
	protected function setViewPlaceholders(&$view)
	{
		// just to be safe, lets clear previous view placeholders
		$this->clearFromPlaceHolders('view');

		// ###VIEW### <<<DYNAMIC>>>
		if (isset($view->name_single))
		{
			// set main keys
			$viewName_single = ComponentbuilderHelper::safeString($view->name_single);
			$viewName_u = ComponentbuilderHelper::safeString($view->name_single, 'U');
			$viewName_f = ComponentbuilderHelper::safeString($view->name_single, 'F');

			// set some place holder for the views
			$this->placeholders['###view###'] = $viewName_single;
			$this->placeholders['###View###'] = $viewName_f;
			$this->placeholders['###VIEW###'] = $viewName_u;
			$this->placeholders['[[[view]]]'] = $viewName_single;
			$this->placeholders['[[[View]]]'] = $viewName_f;
			$this->placeholders['[[[VIEW]]]'] = $viewName_u;
		}

		// ###VIEWS### <<<DYNAMIC>>>
		if (isset($view->name_list))
		{
			$viewName_list = ComponentbuilderHelper::safeString($view->name_list);
			$viewsName_u = ComponentbuilderHelper::safeString($view->name_list, 'U');
			$viewsName_f = ComponentbuilderHelper::safeString($view->name_list, 'F');

			// set some place holder for the views
			$this->placeholders['###views###'] = $viewName_list;
			$this->placeholders['###Views###'] = $viewsName_f;
			$this->placeholders['###VIEWS###'] = $viewsName_u;
			$this->placeholders['[[[views]]]'] = $viewName_list;
			$this->placeholders['[[[Views]]]'] = $viewsName_f;
			$this->placeholders['[[[VIEWS]]]'] = $viewsName_u;
		}

		// ###view### <<<DYNAMIC>>>
		if (isset($viewName_single))
		{
			$this->fileContentDynamic[$viewName_single]['###view###'] = $viewName_single;
			$this->fileContentDynamic[$viewName_single]['###VIEW###'] = $viewName_u;
			$this->fileContentDynamic[$viewName_single]['###View###'] = $viewName_f;

			if (isset($viewName_list))
			{
				$this->fileContentDynamic[$viewName_list]['###view###'] = $viewName_single;
				$this->fileContentDynamic[$viewName_list]['###VIEW###'] = $viewName_u;
				$this->fileContentDynamic[$viewName_list]['###View###'] = $viewName_f;
			}
		}

		// ###views### <<<DYNAMIC>>>
		if (isset($viewName_list))
		{
			$this->fileContentDynamic[$viewName_list]['###views###'] = $viewName_list;
			$this->fileContentDynamic[$viewName_list]['###VIEWS###'] = $viewsName_u;
			$this->fileContentDynamic[$viewName_list]['###Views###'] = $viewsName_f;

			if (isset($viewName_single))
			{
				$this->fileContentDynamic[$viewName_single]['###views###'] = $viewName_list;
				$this->fileContentDynamic[$viewName_single]['###VIEWS###'] = $viewsName_u;
				$this->fileContentDynamic[$viewName_single]['###Views###'] = $viewsName_f;
			}
		}
	}

	/**
	 * Build the language values and insert into file
	 *
	 * @return  boolean  on success
	 * 
	 */
	public function setLangFileData()
	{
		$values = array();
		$mainLangLoader = array();
		// check the admin lang is set
		if ($this->setLangAdmin())
		{
			$values[] = array_values($this->languages[$this->langTag]['admin']);
			$mainLangLoader['admin'] = count($this->languages[$this->langTag]['admin']);
		}
		// check the admin system lang is set
		if ($this->setLangAdminSys())
		{
			$values[] = array_values($this->languages[$this->langTag]['adminsys']);
			$mainLangLoader['adminsys'] = count($this->languages[$this->langTag]['adminsys']);
		}
		// check the site lang is set
		if (!$this->removeSiteFolder && $this->setLangSite())
		{
			$values[] = array_values($this->languages[$this->langTag]['site']);
			$mainLangLoader['site'] = count($this->languages[$this->langTag]['site']);
		}
		// check the site system lang is set
		if (!$this->removeSiteFolder && $this->setLangSiteSys())
		{
			$values[] = array_values($this->languages[$this->langTag]['sitesys']);
			$mainLangLoader['sitesys'] = count($this->languages[$this->langTag]['sitesys']);
		}
		$values = array_unique(ComponentbuilderHelper::mergeArrays($values));
		// get the other lang strings if there is any
		$this->multiLangString = $this->getMultiLangStrings($values);
		// update insert the current lang in to DB
		$this->setLangPlaceholders($values);
		// remove old unused language strings
		$this->purgeLanuageStrings($values);
		// path to INI file
		$getPAth = $this->templatePath . '/en-GB.com_admin.ini';
		// now we insert the values into the files
		if (ComponentbuilderHelper::checkArray($this->languages))
		{
			$langXML = array();
			foreach ($this->languages as $tag => $areas)
			{
				// trim the tag
				$tag = trim($tag);
				foreach ($areas as $area => $languageStrings)
				{
					// only log messages for none $this->langTag translations
					if ($this->langTag !== $tag)
					{
						$langStringNr = count($languageStrings);
						$langStringSum = $this->bcmath('mul', $langStringNr, 100);
						$percentage = $this->bcmath('div', $langStringSum, $mainLangLoader[$area]);
						$stringNAme = ($langStringNr == 1) ? '(string ' . $tag . ' translated)' : '(strings ' . $tag . ' translated)';
						// force load if debug lines are added
						if (!$this->debugLinenr)
						{
							// check if we sould install this translation
							if ($percentage < $this->percentageLanguageAdd)
							{
								// dont add
								$this->langNot[$area . ' ' . $tag] = '<b>' . $mainLangLoader[$area] . '</b>(total '.$this->langTag.' strings) only <b>' . $langStringNr . '</b>' . $stringNAme . ' = ' . $percentage;
								continue;
							}
						}
						// show if it was added as well
						$this->langSet[$area . ' ' . $tag] = '<b>' . $mainLangLoader[$area] . '</b>(total '.$this->langTag.' strings) and <b>' . $langStringNr . '</b>' . $stringNAme . ' = ' . $percentage;
					}
					// set naming convention
					$p = 'admin';
					$t = '';
					if (strpos($area, 'site') !== false)
					{
						if ($this->removeSiteFolder)
						{
							continue;
						}
						$p = 'site';
					}
					if (strpos($area, 'sys') !== false)
					{
						$t = '.sys';
					}
					// build the path to to place the lang file
					$path = $this->componentPath . '/' . $p . '/language/' . $tag;
					if (!JFolder::exists($path))
					{
						JFolder::create($path);
						// count the folder created
						$this->folderCount++;
					}
					// build the file name
					$fileName = $tag . '.com_' . $this->componentCodeName . $t . '.ini';
					// move the file to its place
					JFile::copy($getPAth, $path . '/' . $fileName);
					// count the file created
					$this->fileCount++;
					// add content to it
					$lang = array_map(function ($langstring, $placeholder) {
						return $placeholder . '="' . $langstring . '"';
					}, $languageStrings, array_keys($languageStrings));
					// add to language file
					$this->writeFile($path . '/' . $fileName, implode(PHP_EOL, $lang));
					// set the line counter
					$this->lineCount = $this->lineCount + count((array)$lang);
					// build xml strings
					if (!isset($langXML[$p]))
					{
						$langXML[$p] = array();
					}
					$langXML[$p][] = '<language tag="' . $tag . '">language/' . $tag . '/' . $fileName . '</language>';
				}
			}
			// load the lang xml 
			if (ComponentbuilderHelper::checkArray($langXML))
			{
				$replace = array();
				if (isset($langXML['admin']) && ComponentbuilderHelper::checkArray($langXML['admin']))
				{
					$replace['###ADMIN_LANGUAGES###'] = implode(PHP_EOL . "\t\t\t", $langXML['admin']);
				}
				if (!$this->removeSiteFolder && isset($langXML['site']) && ComponentbuilderHelper::checkArray($langXML['site']))
				{
					$replace['###SITE_LANGUAGES###'] = implode(PHP_EOL . "\t\t", $langXML['site']);
				}
				// build xml path
				$xmlPath = $this->componentPath . '/' . $this->fileContentStatic['###component###'] . '.xml';
				// get the content in xml
				$componentXML = ComponentbuilderHelper::getFileContents($xmlPath);
				// update the xml content
				$componentXML = $this->setPlaceholders($componentXML, $replace);
				// store the values back to xml
				$this->writeFile($xmlPath, $componentXML);
			}
		}
	}
}
