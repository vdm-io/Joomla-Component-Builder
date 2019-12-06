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
 * Interpretation class
 */
class Infusion extends Interpretation
{

	public $eximportView = array();
	public $importCustomScripts = array();
	public $langFiles = array();
	public $removeSiteFolder = false;
	public $removeSiteEditFolder = true;
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
			// Trigger Event: jcb_ce_onBeforeBuildFilesContent
			$this->triggerEvent('jcb_ce_onBeforeBuildFilesContent', array(&$this->componentContext, &$this->componentData, &$this->fileContentStatic, &$this->fileContentDynamic, &$this->placeholders, &$this->hhh));

			// COMPONENT
			$this->fileContentStatic[$this->hhh . 'COMPONENT' . $this->hhh] = $this->placeholders[$this->hhh . 'COMPONENT' . $this->hhh];

			// Component
			$this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] = $this->placeholders[$this->hhh . 'Component' . $this->hhh];

			// component
			$this->fileContentStatic[$this->hhh . 'component' . $this->hhh] = $this->placeholders[$this->hhh . 'component' . $this->hhh];

			// COMPANYNAME
			$this->fileContentStatic[$this->hhh . 'COMPANYNAME' . $this->hhh] = trim(JFilterOutput::cleanText($this->componentData->companyname));

			// CREATIONDATE
			$this->fileContentStatic[$this->hhh . 'CREATIONDATE' . $this->hhh] = JFactory::getDate($this->componentData->created)->format('jS F, Y');
			$this->fileContentStatic[$this->hhh . 'CREATIONDATE' . $this->hhh . 'GLOBAL'] = $this->fileContentStatic[$this->hhh . 'CREATIONDATE' . $this->hhh];

			// BUILDDATE
			$this->fileContentStatic[$this->hhh . 'BUILDDATE' . $this->hhh] = JFactory::getDate()->format('jS F, Y');
			$this->fileContentStatic[$this->hhh . 'BUILDDATE' . $this->hhh . 'GLOBAL'] = $this->fileContentStatic[$this->hhh . 'BUILDDATE' . $this->hhh];

			// AUTHOR
			$this->fileContentStatic[$this->hhh . 'AUTHOR' . $this->hhh] = trim(JFilterOutput::cleanText($this->componentData->author));

			// AUTHOREMAIL
			$this->fileContentStatic[$this->hhh . 'AUTHOREMAIL' . $this->hhh] = trim($this->componentData->email);

			// AUTHORWEBSITE
			$this->fileContentStatic[$this->hhh . 'AUTHORWEBSITE' . $this->hhh] = trim($this->componentData->website);

			// COPYRIGHT
			$this->fileContentStatic[$this->hhh . 'COPYRIGHT' . $this->hhh] = trim($this->componentData->copyright);

			// LICENSE
			$this->fileContentStatic[$this->hhh . 'LICENSE' . $this->hhh] = trim($this->componentData->license);

			// VERSION
			$this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh] = trim($this->componentData->component_version);
			// set the actual global version
			$this->fileContentStatic[$this->hhh . 'ACTUALVERSION' . $this->hhh] = $this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh];

			// do some Tweaks to the version based on selected options
			if (strpos($this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh], '.') !== false)
			{
				$versionArray = explode('.', $this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh]);
			}
			// load only first two values
			if (isset($versionArray) && ComponentbuilderHelper::checkArray($versionArray) && $this->componentData->mvc_versiondate == 2)
			{
				$this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh] = $versionArray[0] . '.' . $versionArray[1] . '.x';
			}
			// load only the first value
			elseif (isset($versionArray) && ComponentbuilderHelper::checkArray($versionArray) && $this->componentData->mvc_versiondate == 3)
			{
				$this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh] = $versionArray[0] . '.x.x';
			}
			unset($versionArray);

			// set the global version in case			
			$this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh . 'GLOBAL'] = $this->fileContentStatic[$this->hhh . 'VERSION' . $this->hhh];

			// Component_name
			$this->fileContentStatic[$this->hhh . 'Component_name' . $this->hhh] = JFilterOutput::cleanText($this->componentData->name);

			// SHORT_DISCRIPTION
			$this->fileContentStatic[$this->hhh . 'SHORT_DESCRIPTION' . $this->hhh] = trim(JFilterOutput::cleanText($this->componentData->short_description));

			// DESCRIPTION
			$this->fileContentStatic[$this->hhh . 'DESCRIPTION' . $this->hhh] = trim($this->componentData->description);

			// COMP_IMAGE_TYPE
			$this->fileContentStatic[$this->hhh . 'COMP_IMAGE_TYPE' . $this->hhh] = $this->setComponentImageType($this->componentData->image);

			// ACCESS_SECTIONS
			$this->fileContentStatic[$this->hhh . 'ACCESS_SECTIONS' . $this->hhh] = $this->setAccessSections();

			// CONFIG_FIELDSETS
			$keepLang = $this->lang;
			$this->lang = 'admin';

			// start loading the category tree scripts
			$this->fileContentStatic[$this->hhh . 'CATEGORY_CLASS_TREES' . $this->hhh] = '';
			// run the field sets for first time
			$this->setConfigFieldsets(1);
			$this->lang = $keepLang;

			// ADMINJS
			$this->fileContentStatic[$this->hhh . 'ADMINJS' . $this->hhh] = $this->setPlaceholders($this->customScriptBuilder['component_js'], $this->placeholders);
			// SITEJS
			$this->fileContentStatic[$this->hhh . 'SITEJS' . $this->hhh] = $this->setPlaceholders($this->customScriptBuilder['component_js'], $this->placeholders);

			// ADMINCSS
			$this->fileContentStatic[$this->hhh . 'ADMINCSS' . $this->hhh] = $this->setPlaceholders($this->customScriptBuilder['component_css_admin'], $this->placeholders);
			// SITECSS
			$this->fileContentStatic[$this->hhh . 'SITECSS' . $this->hhh] = $this->setPlaceholders($this->customScriptBuilder['component_css_site'], $this->placeholders);

			// CUSTOM_HELPER_SCRIPT
			$this->fileContentStatic[$this->hhh . 'CUSTOM_HELPER_SCRIPT' . $this->hhh] = $this->setPlaceholders($this->customScriptBuilder['component_php_helper_admin'], $this->placeholders);

			// BOTH_CUSTOM_HELPER_SCRIPT
			$this->fileContentStatic[$this->hhh . 'BOTH_CUSTOM_HELPER_SCRIPT' . $this->hhh] = $this->setPlaceholders($this->customScriptBuilder['component_php_helper_both'], $this->placeholders);

			// ADMIN_GLOBAL_EVENT_HELPER
			$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] = '';

			// ADMIN_GLOBAL_EVENT
			$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT' . $this->hhh] = '';

			// now load the data for the global event if needed
			if ($this->componentData->add_admin_event == 1)
			{
				// ADMIN_GLOBAL_EVENT
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT' . $this->hhh] = PHP_EOL . PHP_EOL . '// Triger the Global Admin Event';
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT' . $this->hhh] .= PHP_EOL . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper::globalEvent($document);';
				// ADMIN_GLOBAL_EVENT_HELPER
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] = PHP_EOL . PHP_EOL . $this->_t(1) . '/**';
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '*	The Global Admin Event Method.';
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '**/';
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . 'public static function globalEvent($document)';
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '{';
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->setPlaceholders($this->customScriptBuilder['component_php_admin_event'], $this->placeholders);
				$this->fileContentStatic[$this->hhh . 'ADMIN_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '}';
			}

			// now load the readme file if needed
			if ($this->componentData->addreadme == 1)
			{
				$this->fileContentStatic[$this->hhh . 'EXSTRA_ADMIN_FILES' . $this->hhh] .= PHP_EOL . $this->_t(3) . "<filename>README.txt</filename>";
			}

			// HELPER_CREATEUSER
			$this->fileContentStatic[$this->hhh . 'HELPER_CREATEUSER' . $this->hhh] = $this->setCreateUserHelperMethod($this->componentData->creatuserhelper);

			// HELP
			$this->fileContentStatic[$this->hhh . 'HELP' . $this->hhh] = $this->noHelp();
			// HELP_SITE
			$this->fileContentStatic[$this->hhh . 'HELP_SITE' . $this->hhh] = $this->noHelp();

			// build route parse switch
			$this->fileContentStatic[$this->hhh . 'ROUTER_PARSE_SWITCH' . $this->hhh] = '';
			// build route views
			$this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh] = '';

			// add the helper emailer if set
			$this->fileContentStatic[$this->hhh . 'HELPER_EMAIL' . $this->hhh] = $this->addEmailHelper();

			// load the global placeholders
			if (ComponentbuilderHelper::checkArray($this->globalPlaceholders))
			{
				foreach ($this->globalPlaceholders as $globalPlaceholder => $gloabalValue)
				{
					$this->fileContentStatic[$globalPlaceholder] = $gloabalValue;
				}
			}
			// reset view array
			$viewarray = array();
			$site_edit_view_array = array();
			// start dynamic build
			foreach ($this->componentData->admin_views as $view)
			{
				// set the target
				$this->target = 'admin';
				$this->lang = 'admin';
				// reset
				$viewName_single = '';
				$viewName_list = '';

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
				if (isset($view['edit_create_site_view']) && is_numeric($view['edit_create_site_view']) && $view['edit_create_site_view'] > 0)
				{
					$site_edit_view_array[] = $this->_t(4) . "'" . $viewName_single . "'";
					$this->lang = 'both';
					// insure site view does not get removed
					$this->removeSiteEditFolder = false;
				}
				// check if help is being loaded
				$this->checkHelp($viewName_single);
				// set custom admin view list links
				$this->setCustomAdminViewListLink($view, $viewName_list);

				// set view array
				$viewarray[] = $this->_t(4) . "'" . $viewName_single . "' => '" . $viewName_list . "'";
				// set the view names
				if (isset($view['settings']->name_single) && $view['settings']->name_single != 'null')
				{
					// set license per view if needed
					$this->setLockLicensePer($viewName_single, $this->target);
					$this->setLockLicensePer($viewName_list, $this->target);

					// Trigger Event: jcb_ce_onBeforeBuildAdminEditViewContent
					$this->triggerEvent('jcb_ce_onBeforeBuildAdminEditViewContent', array(&$this->componentContext, &$view, &$viewName_single, &$viewName_list, &$this->fileContentStatic, &$this->fileContentDynamic[$viewName_single], &$this->placeholders, &$this->hhh));

					// FIELDSETS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'FIELDSETS' . $this->hhh] = $this->setFieldSet($view, $this->componentCodeName, $viewName_single, $viewName_list);

					// ACCESSCONTROL <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'ACCESSCONTROL' . $this->hhh] = $this->setFieldSetAccessControl($viewName_single);

					// LINKEDVIEWITEMS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'LINKEDVIEWITEMS' . $this->hhh] = '';

					// ADDTOOLBAR <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'ADDTOOLBAR' . $this->hhh] = $this->setAddToolBar($view);

					// set the script for this view
					$this->buildTheViewScript($view);

					// VIEW_SCRIPT
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'VIEW_SCRIPT' . $this->hhh] = $this->setViewScript($viewName_single, 'fileScript');

					// EDITBODYSCRIPT
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'EDITBODYSCRIPT' . $this->hhh] = $this->setViewScript($viewName_single, 'footerScript');

					// AJAXTOKE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'AJAXTOKE' . $this->hhh] = $this->setAjaxToke($viewName_single);

					// DOCUMENT_CUSTOM_PHP <<<DYNAMIC>>>
					if ($phpDocument = $this->getCustomScriptBuilder('php_document', $viewName_single, PHP_EOL, null, true, false))
					{
						$this->fileContentDynamic[$viewName_single][$this->hhh . 'DOCUMENT_CUSTOM_PHP' . $this->hhh] = str_replace('$document->', '$this->document->', $phpDocument);
						// clear some memory
						unset($phpDocument);
					}
					else
					{
						$this->fileContentDynamic[$viewName_single][$this->hhh . 'DOCUMENT_CUSTOM_PHP' . $this->hhh] = '';
					}
					// LINKEDVIEWTABLESCRIPTS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'LINKEDVIEWTABLESCRIPTS' . $this->hhh] = '';

					// VALIDATEFIX <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'VALIDATIONFIX' . $this->hhh] = $this->setValidationFix($viewName_single, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh]);

					// EDITBODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'EDITBODY' . $this->hhh] = $this->setEditBody($view);

					// EDITBODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'EDITBODYFADEIN' . $this->hhh] = $this->setFadeInEfect($view);

					// JTABLECONSTRUCTOR <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'JTABLECONSTRUCTOR' . $this->hhh] = $this->setJtableConstructor($viewName_single);

					// JTABLEALIASCATEGORY <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'JTABLEALIASCATEGORY' . $this->hhh] = $this->setJtableAliasCategory($viewName_single);

					// METHOD_GET_ITEM <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'METHOD_GET_ITEM' . $this->hhh] = $this->setMethodGetItem($viewName_single);

					// LINKEDVIEWGLOBAL <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'LINKEDVIEWGLOBAL' . $this->hhh] = '';

					// LINKEDVIEWMETHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'LINKEDVIEWMETHODS' . $this->hhh] = '';

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_BEFORE_DELETE' . $this->hhh] = $this->getCustomScriptBuilder('php_before_delete', $viewName_single, PHP_EOL);

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_AFTER_DELETE' . $this->hhh] = $this->getCustomScriptBuilder('php_after_delete', $viewName_single, PHP_EOL . PHP_EOL);

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_BEFORE_PUBLISH' . $this->hhh] = $this->getCustomScriptBuilder('php_before_publish', $viewName_single, PHP_EOL);

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_AFTER_PUBLISH' . $this->hhh] = $this->getCustomScriptBuilder('php_after_publish', $viewName_single, PHP_EOL . PHP_EOL);

					// CHECKBOX_SAVE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'CHECKBOX_SAVE' . $this->hhh] = $this->setCheckboxSave($viewName_single);

					// METHOD_ITEM_SAVE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'METHOD_ITEM_SAVE' . $this->hhh] = $this->setMethodItemSave($viewName_single);

					// POSTSAVEHOOK <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'POSTSAVEHOOK' . $this->hhh] = $this->getCustomScriptBuilder('php_postsavehook', $viewName_single, PHP_EOL, null, true, PHP_EOL . $this->_t(2) . "return;", PHP_EOL . PHP_EOL . $this->_t(2) . "return;");

					// VIEWCSS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'VIEWCSS' . $this->hhh] = $this->getCustomScriptBuilder('css_view', $viewName_single, '', null, true);

					// add css to front end
					if (isset($view['edit_create_site_view']) && is_numeric($view['edit_create_site_view']) && $view['edit_create_site_view'] > 0)
					{
						$this->fileContentDynamic[$viewName_single][$this->hhh . 'SITE_VIEWCSS' . $this->hhh] = $this->fileContentDynamic[$viewName_single][$this->hhh . 'VIEWCSS' . $this->hhh];
						// check if we should add a create menu
						if ($view['edit_create_site_view'] == 2)
						{
							// SITE_MENU_XML <<<DYNAMIC>>>
							$this->fileContentDynamic[$viewName_single][$this->hhh . 'SITE_MENU_XML' . $this->hhh] = $this->setAdminViewMenu($viewName_single, $view);
						}
					}

					// TABLAYOUTFIELDSARRAY <<<DYNAMIC>>> add the tab layout fields array to the model
					$this->fileContentDynamic[$viewName_single][$this->hhh . 'TABLAYOUTFIELDSARRAY' . $this->hhh] = $this->getTabLayoutFieldsArray($viewName_single);

					// Trigger Event: jcb_ce_onAfterBuildAdminEditViewContent
					$this->triggerEvent('jcb_ce_onAfterBuildAdminEditViewContent', array(&$this->componentContext, &$view, &$viewName_single, &$viewName_list, &$this->fileContentStatic, &$this->fileContentDynamic[$viewName_single], &$this->placeholders, &$this->hhh));
				}
				// set the views names
				if (isset($view['settings']->name_list) && $view['settings']->name_list != 'null')
				{
					$this->lang = 'admin';

					// ICOMOON <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'ICOMOON' . $this->hhh] = $view['icomoon'];

					// Trigger Event: jcb_ce_onBeforeBuildAdminListViewContent
					$this->triggerEvent('jcb_ce_onBeforeBuildAdminListViewContent', array(&$this->componentContext, &$view, &$viewName_single, &$viewName_list, &$this->fileContentStatic, &$this->fileContentDynamic[$viewName_list], &$this->placeholders, &$this->hhh));

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
						// AUTOCHECKIN <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list][$this->hhh . 'AUTOCHECKIN' . $this->hhh] = $this->setAutoCheckin($viewName_single, $this->componentCodeName);
						// CHECKINCALL <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list][$this->hhh . 'CHECKINCALL' . $this->hhh] = $this->setCheckinCall();
					}
					else
					{
						// AUTOCHECKIN <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list][$this->hhh . 'AUTOCHECKIN' . $this->hhh] = '';
						// CHECKINCALL <<<DYNAMIC>>>
						$this->fileContentDynamic[$viewName_list][$this->hhh . 'CHECKINCALL' . $this->hhh] = '';
					}
					// admin list file contnet
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'ADMIN_JAVASCRIPT_FILE' . $this->hhh] = $this->setViewScript($viewName_list, 'list_fileScript');
					// ADMIN_CUSTOM_BUTTONS_LIST
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'ADMIN_CUSTOM_BUTTONS_LIST' . $this->hhh] = $this->setCustomButtons($view, 3, $this->_t(1));
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'ADMIN_CUSTOM_FUNCTION_ONLY_BUTTONS_LIST' . $this->hhh] = $this->setFunctionOnlyButtons($viewName_list);

					// GET_ITEMS_METHOD_STRING_FIX <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'GET_ITEMS_METHOD_STRING_FIX' . $this->hhh] = $this->setGetItemsMethodStringFix($viewName_single, $viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh]);

					// GET_ITEMS_METHOD_AFTER_ALL <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'GET_ITEMS_METHOD_AFTER_ALL' . $this->hhh] = $this->getCustomScriptBuilder('php_getitems_after_all', $viewName_single, PHP_EOL);

					// SELECTIONTRANSLATIONFIX <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'SELECTIONTRANSLATIONFIX' . $this->hhh] = $this->setSelectionTranslationFix($viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh]);

					// SELECTIONTRANSLATIONFIXFUNC <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'SELECTIONTRANSLATIONFIXFUNC' . $this->hhh] = $this->setSelectionTranslationFixFunc($viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh]);

					// FILTER_FIELDS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'FILTER_FIELDS' . $this->hhh] = $this->setFilterFields($viewName_list);

					// STOREDID <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'STOREDID' . $this->hhh] = $this->setStoredId($viewName_list);

					// POPULATESTATE <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'POPULATESTATE' . $this->hhh] = $this->setPopulateState($viewName_list);

					// SORTFIELDS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'SORTFIELDS' . $this->hhh] = $this->setSortFields($viewName_list);

					// CATEGORYFILTER <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'CATEGORYFILTER' . $this->hhh] = $this->setCategoryFilter($viewName_list);

					// CATEGORY_VIEWS
					if (!isset($this->fileContentStatic[$this->hhh . 'ROUTER_CATEGORY_VIEWS' . $this->hhh]))
					{
						$this->fileContentStatic[$this->hhh . 'ROUTER_CATEGORY_VIEWS' . $this->hhh] = '';
					}
					$this->fileContentStatic[$this->hhh . 'ROUTER_CATEGORY_VIEWS' . $this->hhh] .= $this->setRouterCategoryViews($viewName_single, $viewName_list);

					// OTHERFILTERS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'OTHERFILTERS' . $this->hhh] = $this->setOtherFilter($viewName_list);

					// FILTERFUNCTIONS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'FILTERFUNCTIONS' . $this->hhh] = $this->setFilterFunctions($viewName_single, $viewName_list);

					// LISTQUERY <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'LISTQUERY' . $this->hhh] = $this->setListQuery($viewName_single, $viewName_list);

					// MODELEXPORTMETHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'MODELEXPORTMETHOD' . $this->hhh] = $this->setGetItemsModelMethod($viewName_single, $viewName_list);

					// MODELEXIMPORTMETHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'CONTROLLEREXIMPORTMETHOD' . $this->hhh] = $this->setControllerEximportMethod($viewName_single, $viewName_list);

					// EXPORTBUTTON <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'EXPORTBUTTON' . $this->hhh] = $this->setExportButton($viewName_single, $viewName_list);

					// IMPORTBUTTON <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'IMPORTBUTTON' . $this->hhh] = $this->setImportButton($viewName_single, $viewName_list);

					// LISTHEAD <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'LISTHEAD' . $this->hhh] = $this->setListHead($viewName_single, $viewName_list);

					// LISTBODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'LISTBODY' . $this->hhh] = $this->setListBody($viewName_single, $viewName_list);

					// LISTCOLNR <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'LISTCOLNR' . $this->hhh] = $this->setListColnr($viewName_list);

					// JVIEWLISTCANDO <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'JVIEWLISTCANDO' . $this->hhh] = $this->setJviewListCanDo($viewName_single, $viewName_list);

					// VIEWSCSS <<<DYNAMIC>>>
					$this->fileContentDynamic[$viewName_list][$this->hhh . 'VIEWSCSS' . $this->hhh] = $this->getCustomScriptBuilder('css_views', $viewName_single, '', null, true);

					// VIEWS_FOOTER_SCRIPT <<<DYNAMIC>>>
					$scriptNote = PHP_EOL . '//' . $this->setLine(__LINE__) . ' ' . $viewName_list . ' footer script';
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
						$this->fileContentDynamic[$viewName_list][$this->hhh . 'VIEWS_FOOTER_SCRIPT' . $this->hhh] = PHP_EOL . '<script type="text/javascript">' . $footerScript . "</script>";
						// clear some memory
						unset($footerScript);
					}
					else
					{
						$this->fileContentDynamic[$viewName_list][$this->hhh . 'VIEWS_FOOTER_SCRIPT' . $this->hhh] = '';
					}

					// Trigger Event: jcb_ce_onAfterBuildAdminListViewContent
					$this->triggerEvent('jcb_ce_onAfterBuildAdminListViewContent', array(&$this->componentContext, &$view, &$viewName_single, &$viewName_list, &$this->fileContentStatic, &$this->fileContentDynamic[$viewName_list], &$this->placeholders, &$this->hhh));
				}

				// set u fields used in batch
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'UNIQUEFIELDS' . $this->hhh] = $this->setUniqueFields($viewName_single);

				// TITLEALIASFIX <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'TITLEALIASFIX' . $this->hhh] = $this->setAliasTitleFix($viewName_single);

				// GENERATENEWTITLE <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'GENERATENEWTITLE' . $this->hhh] = $this->setGenerateNewTitle($viewName_single);

				// GENERATENEWALIAS <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'GENERATENEWALIAS' . $this->hhh] = $this->setGenerateNewAlias($viewName_single);

				// MODEL_BATCH_COPY <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'MODEL_BATCH_COPY' . $this->hhh] = $this->setBatchCopy($viewName_single);

				// MODEL_BATCH_MOVE <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'MODEL_BATCH_MOVE' . $this->hhh] = $this->setBatchMove($viewName_single);

				// BATCH_ONCLICK_CANCEL_SCRIPT <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_list][$this->hhh . 'BATCH_ONCLICK_CANCEL_SCRIPT' . $this->hhh] = ''; // TODO <-- must still be build

				// JCONTROLLERFORM_ALLOWADD <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JCONTROLLERFORM_ALLOWADD' . $this->hhh] = $this->setJcontrollerAllowAdd($viewName_single, $viewName_list);

				// JCONTROLLERFORM_BEFORECANCEL <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JCONTROLLERFORM_BEFORECANCEL' . $this->hhh] = $this->getCustomScriptBuilder('php_before_cancel', $viewName_single, PHP_EOL, null, null, '');

				// JCONTROLLERFORM_AFTERCANCEL <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JCONTROLLERFORM_AFTERCANCEL' . $this->hhh] = $this->getCustomScriptBuilder('php_after_cancel', $viewName_single, PHP_EOL, null, null, '');

				// JCONTROLLERFORM_ALLOWEDIT <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JCONTROLLERFORM_ALLOWEDIT' . $this->hhh] = $this->setJcontrollerAllowEdit($viewName_single, $viewName_list);

				// JMODELADMIN_GETFORM <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_GETFORM' . $this->hhh] = $this->setJmodelAdminGetForm($viewName_single, $viewName_list);

				// JMODELADMIN_ALLOWEDIT <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_ALLOWEDIT' . $this->hhh] = $this->setJmodelAdminAllowEdit($viewName_single, $viewName_list);

				// JMODELADMIN_CANDELETE <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_CANDELETE' . $this->hhh] = $this->setJmodelAdminCanDelete($viewName_single, $viewName_list);

				// JMODELADMIN_CANEDITSTATE <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'JMODELADMIN_CANEDITSTATE' . $this->hhh] = $this->setJmodelAdminCanEditState($viewName_single, $viewName_list);

				// set custom admin view Toolbare buttons
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS  <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_list][$this->hhh . 'CUSTOM_ADMIN_DYNAMIC_BUTTONS' . $this->hhh] = $this->setCustomAdminDynamicButton($viewName_list);
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER  <<<DYNAMIC>>>
				$this->fileContentDynamic[$viewName_list][$this->hhh . 'CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER' . $this->hhh] = $this->setCustomAdminDynamicButtonController($viewName_list);

				// set helper router
				if (!isset($this->fileContentStatic[$this->hhh . 'ROUTEHELPER' . $this->hhh]))
				{
					$this->fileContentStatic[$this->hhh . 'ROUTEHELPER' . $this->hhh] = '';
				}
				$this->fileContentStatic[$this->hhh . 'ROUTEHELPER' . $this->hhh] .= $this->setRouterHelp($viewName_single, $viewName_list);

				if (isset($view['edit_create_site_view']) && is_numeric($view['edit_create_site_view']) && $view['edit_create_site_view'] > 0)
				{
					// add needed router stuff for front edit views
					$this->fileContentStatic[$this->hhh . 'ROUTER_PARSE_SWITCH' . $this->hhh] .= $this->routerParseSwitch($viewName_single, null, false);
					$this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh] .= $this->routerBuildViews($viewName_single);
				}

				// ACCESS_SECTIONS
				if (!isset($this->fileContentStatic[$this->hhh . 'ACCESS_SECTIONS' . $this->hhh]))
				{
					$this->fileContentStatic[$this->hhh . 'ACCESS_SECTIONS' . $this->hhh] = '';
				}
				$this->fileContentStatic[$this->hhh . 'ACCESS_SECTIONS' . $this->hhh] .= $this->setAccessSectionsCategory($viewName_single, $viewName_list);
				// set the Joomla Fields ACCESS section if needed
				if (isset($view['joomla_fields']) && $view['joomla_fields'] == 1)
				{
					$this->fileContentStatic[$this->hhh . 'ACCESS_SECTIONS' . $this->hhh] .= $this->setAccessSectionsJoomlaFields();
				}
				// HELPER_EXEL
				$this->fileContentStatic[$this->hhh . 'HELPER_EXEL' . $this->hhh] = $this->setExelHelperMethods();
				// Trigger Event: jcb_ce_onAfterBuildAdminViewContent
				$this->triggerEvent('jcb_ce_onAfterBuildAdminViewContent', array(&$this->componentContext, &$view, &$viewName_single, &$viewName_list, &$this->fileContentStatic, &$this->fileContentDynamic, &$this->placeholders, &$this->hhh));
			}

			// setup custom_admin_views and all needed stuff for the site
			if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
			{
				$this->target = 'custom_admin';
				$this->lang = 'admin';
				// start dynamic build
				foreach ($this->componentData->custom_admin_views as $view)
				{
					// for single views
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SView' . $this->hhh] = $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'sview' . $this->hhh] = $view['settings']->code;
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SVIEW' . $this->hhh] = $view['settings']->CODE;
					// for list views
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SViews' . $this->hhh] = $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'sviews' . $this->hhh] = $view['settings']->code;
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SVIEWS' . $this->hhh] = $view['settings']->CODE;
					// add to lang array
					$this->setLangContent($this->lang, $this->langPrefix . '_' . $view['settings']->CODE, $view['settings']->name);
					$this->setLangContent($this->lang, $this->langPrefix . '_' . $view['settings']->CODE . '_DESC', $view['settings']->description);
					// ICOMOON <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'ICOMOON' . $this->hhh] = $view['icomoon'];

					// set placeholders
					$this->placeholders[$this->hhh . 'SView' . $this->hhh] = $view['settings']->Code;
					$this->placeholders[$this->hhh . 'sview' . $this->hhh] = $view['settings']->code;
					$this->placeholders[$this->hhh . 'SVIEW' . $this->hhh] = $view['settings']->CODE;
					$this->placeholders[$this->bbb . 'SView' . $this->ddd] = $view['settings']->Code;
					$this->placeholders[$this->bbb . 'sview' . $this->ddd] = $view['settings']->code;
					$this->placeholders[$this->bbb . 'SVIEW' . $this->ddd] = $view['settings']->CODE;
					$this->placeholders[$this->hhh . 'SViews' . $this->hhh] = $view['settings']->Code;
					$this->placeholders[$this->hhh . 'sviews' . $this->hhh] = $view['settings']->code;
					$this->placeholders[$this->hhh . 'SVIEWS' . $this->hhh] = $view['settings']->CODE;
					$this->placeholders[$this->bbb . 'SViews' . $this->ddd] = $view['settings']->Code;
					$this->placeholders[$this->bbb . 'sviews' . $this->ddd] = $view['settings']->code;
					$this->placeholders[$this->bbb . 'SVIEWS' . $this->ddd] = $view['settings']->CODE;

					// Trigger Event: jcb_ce_onBeforeBuildCustomAdminViewContent
					$this->triggerEvent('jcb_ce_onBeforeBuildCustomAdminViewContent', array(&$this->componentContext, &$view, &$view['settings']->code, &$this->fileContentStatic, &$this->fileContentDynamic[$view['settings']->code], &$this->placeholders, &$this->hhh));

					// set license per view if needed
					$this->setLockLicensePer($view['settings']->code, $this->target);

					if ($view['settings']->main_get->gettype == 1)
					{
						// CUSTOM_ADMIN_BEFORE_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_BEFORE_GET_ITEM' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_before_getitem', $view['settings']->code, '', null, true);

						// CUSTOM_ADMIN_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_GET_ITEM' . $this->hhh] = $this->setCustomViewGetItem($view['settings']->main_get, $view['settings']->code, $this->_t(2));

						// CUSTOM_ADMIN_AFTER_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_AFTER_GET_ITEM' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_after_getitem', $view['settings']->code, '', null, true);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// CUSTOM_ADMIN_GET_LIST_QUERY <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_GET_LIST_QUERY' . $this->hhh] = $this->setCustomViewListQuery($view['settings']->main_get, $view['settings']->code);

						// CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_getlistquery', $view['settings']->code, PHP_EOL, null, true);

						// CUSTOM_ADMIN_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_BEFORE_GET_ITEMS' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_before_getitems', $view['settings']->code, PHP_EOL, null, true);

						// CUSTOM_ADMIN_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_GET_ITEMS' . $this->hhh] = $this->setCustomViewGetItems($view['settings']->main_get, $view['settings']->code);

						// CUSTOM_ADMIN_AFTER_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_AFTER_GET_ITEMS' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_after_getitems', $view['settings']->code, PHP_EOL, null, true);
					}

					// CUSTOM_ADMIN_CUSTOM_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_CUSTOM_METHODS' . $this->hhh] = $this->setCustomViewCustomItemMethods($view['settings']->main_get, $view['settings']->code);
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_CUSTOM_METHODS' . $this->hhh] .= $this->setCustomViewCustomMethods($view, $view['settings']->code);
					// CUSTOM_ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_DIPLAY_METHOD' . $this->hhh] = $this->setCustomViewDisplayMethod($view);
					// set document details
					$this->setPrepareDocument($view);
					// CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS' . $this->hhh] = $this->setCustomViewExtraDisplayMethods($view);
					// CUSTOM_ADMIN_CODE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_CODE_BODY' . $this->hhh] = $this->setCustomViewCodeBody($view);
					// CUSTOM_ADMIN_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_BODY' . $this->hhh] = $this->setCustomViewBody($view);
					// CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT' . $this->hhh] = $this->setCustomViewSubmitButtonScript($view);

					// setup the templates
					$this->setCustomViewTemplateBody($view);

					// Trigger Event: jcb_ce_onAfterBuildCustomAdminViewContent
					$this->triggerEvent('jcb_ce_onAfterBuildCustomAdminViewContent', array(&$this->componentContext, &$view, &$view['settings']->code, &$this->fileContentStatic, &$this->fileContentDynamic[$view['settings']->code], &$this->placeholders, &$this->hhh));
				}

				// setup the layouts
				$this->setCustomViewLayouts();
			}

			// VIEWARRAY
			$this->fileContentStatic[$this->hhh . 'VIEWARRAY' . $this->hhh] = PHP_EOL . implode("," . PHP_EOL, $viewarray);

			// CUSTOM_ADMIN_EDIT_VIEW_ARRAY
			$this->fileContentStatic[$this->hhh . 'SITE_EDIT_VIEW_ARRAY' . $this->hhh] = PHP_EOL . implode("," . PHP_EOL, $site_edit_view_array);

			// MAINMENUS
			$this->fileContentStatic[$this->hhh . 'MAINMENUS' . $this->hhh] = $this->setMainMenus();

			// SUBMENU
			$this->fileContentStatic[$this->hhh . 'SUBMENU' . $this->hhh] = $this->setSubMenus();

			// GET_CRYPT_KEY
			$this->fileContentStatic[$this->hhh . 'GET_CRYPT_KEY' . $this->hhh] = $this->setGetCryptKey();

			// set the license locker
			$this->setLockLicense();

			// CONTRIBUTORS
			$this->fileContentStatic[$this->hhh . 'CONTRIBUTORS' . $this->hhh] = $this->theContributors;

			// INSTALL
			$this->fileContentStatic[$this->hhh . 'INSTALL' . $this->hhh] = $this->setInstall();

			// UNINSTALL
			$this->fileContentStatic[$this->hhh . 'UNINSTALL' . $this->hhh] = $this->setUninstall();

			// UPDATE_VERSION_MYSQL
			$this->setVersionController();

			// only set these if default dashboard it used
			if (!ComponentbuilderHelper::checkString($this->dynamicDashboard))
			{
				// DASHBOARDVIEW
				$this->fileContentStatic[$this->hhh . 'DASHBOARDVIEW' . $this->hhh] = $this->componentCodeName;

				// DASHBOARDICONS
				$this->fileContentDynamic[$this->componentCodeName][$this->hhh . 'DASHBOARDICONS' . $this->hhh] = $this->setDashboardIcons();

				// DASHBOARDICONACCESS
				$this->fileContentDynamic[$this->componentCodeName][$this->hhh . 'DASHBOARDICONACCESS' . $this->hhh] = $this->setDashboardIconAccess();

				// DASH_MODEL_METHODS
				$this->fileContentDynamic[$this->componentCodeName][$this->hhh . 'DASH_MODEL_METHODS' . $this->hhh] = $this->setDashboardModelMethods();

				// DASH_GET_CUSTOM_DATA
				$this->fileContentDynamic[$this->componentCodeName][$this->hhh . 'DASH_GET_CUSTOM_DATA' . $this->hhh] = $this->setDashboardGetCustomData();

				// DASH_DISPLAY_DATA
				$this->fileContentDynamic[$this->componentCodeName][$this->hhh . 'DASH_DISPLAY_DATA' . $this->hhh] = $this->setDashboardDisplayData();
			}
			else
			{
				// DASHBOARDVIEW
				$this->fileContentStatic[$this->hhh . 'DASHBOARDVIEW' . $this->hhh] = $this->dynamicDashboard;
			}

			// add import
			if (isset($this->addEximport) && $this->addEximport)
			{
				// setup import files
				$target = array('admin' => 'import');
				$this->buildDynamique($target, 'import');
				// set the controller
				$this->fileContentDynamic['import'][$this->hhh . 'BLABLABLA' . $this->hhh] = '';
			}

			// ensure that the ajax model and controller is set if needed
			if (isset($this->addAjax) && $this->addAjax)
			{
				// setup Ajax files
				$target = array('admin' => 'ajax');
				$this->buildDynamique($target, 'ajax');
				// set the controller
				$this->fileContentDynamic['ajax'][$this->hhh . 'REGISTER_AJAX_TASK' . $this->hhh] = $this->setRegisterAjaxTask('admin');
				$this->fileContentDynamic['ajax'][$this->hhh . 'AJAX_INPUT_RETURN' . $this->hhh] = $this->setAjaxInputReturn('admin');
				// set the module
				$this->fileContentDynamic['ajax'][$this->hhh . 'AJAX_MODEL_METHODS' . $this->hhh] = $this->setAjaxModelMethods('admin');
			}

			// ensure that the site ajax model and controller is set if needed
			if (isset($this->addSiteAjax) && $this->addSiteAjax)
			{
				// setup Ajax files
				$target = array('site' => 'ajax');
				$this->buildDynamique($target, 'ajax');
				// set the controller
				$this->fileContentDynamic['ajax'][$this->hhh . 'REGISTER_SITE_AJAX_TASK' . $this->hhh] = $this->setRegisterAjaxTask('site');
				$this->fileContentDynamic['ajax'][$this->hhh . 'AJAX_SITE_INPUT_RETURN' . $this->hhh] = $this->setAjaxInputReturn('site');
				// set the module
				$this->fileContentDynamic['ajax'][$this->hhh . 'AJAX_SITE_MODEL_METHODS' . $this->hhh] = $this->setAjaxModelMethods('site');
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
					$this->fileContentDynamic['a_rule_zi_' . $rule][$this->hhh . 'Name' . $this->hhh] = ucfirst($rule);
					// set the JFormRule PHP
					$this->fileContentDynamic['a_rule_zi_' . $rule][$this->hhh . 'VALIDATION_RULE_METHODS' . $this->hhh] = PHP_EOL . $_php;
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

			// CONFIG_FIELDSETS
			$keepLang = $this->lang;
			$this->lang = 'admin';
			// run field sets for second time
			$this->setConfigFieldsets(2);
			$this->lang = $keepLang;

			// setup front-views and all needed stuff for the site
			if (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views))
			{
				$this->target = 'site';
				// start dynamic build
				foreach ($this->componentData->site_views as $view)
				{
					// for list views
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SViews' . $this->hhh] = $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'sviews' . $this->hhh] = $view['settings']->code;
					// for single views
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SView' . $this->hhh] = $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'sview' . $this->hhh] = $view['settings']->code;

					// set placeholder
					$this->placeholders[$this->hhh . 'SView' . $this->hhh] = $view['settings']->Code;
					$this->placeholders[$this->hhh . 'sview' . $this->hhh] = $view['settings']->code;
					$this->placeholders[$this->hhh . 'SVIEW' . $this->hhh] = $view['settings']->CODE;
					$this->placeholders[$this->bbb . 'SView' . $this->ddd] = $view['settings']->Code;
					$this->placeholders[$this->bbb . 'sview' . $this->ddd] = $view['settings']->code;
					$this->placeholders[$this->bbb . 'SVIEW' . $this->ddd] = $view['settings']->CODE;
					$this->placeholders[$this->hhh . 'SViews' . $this->hhh] = $view['settings']->Code;
					$this->placeholders[$this->hhh . 'sviews' . $this->hhh] = $view['settings']->code;
					$this->placeholders[$this->hhh . 'SVIEWS' . $this->hhh] = $view['settings']->CODE;
					$this->placeholders[$this->bbb . 'SViews' . $this->ddd] = $view['settings']->Code;
					$this->placeholders[$this->bbb . 'sviews' . $this->ddd] = $view['settings']->code;
					$this->placeholders[$this->bbb . 'SVIEWS' . $this->ddd] = $view['settings']->CODE;

					// Trigger Event: jcb_ce_onBeforeBuildSiteViewContent
					$this->triggerEvent('jcb_ce_onBeforeBuildSiteViewContent', array(&$this->componentContext, &$view, &$view['settings']->code, &$this->fileContentStatic, &$this->fileContentDynamic[$view['settings']->code], &$this->placeholders, &$this->hhh));

					// set license per view if needed
					$this->setLockLicensePer($view['settings']->code, $this->target);

					// set the site default view
					if (isset($view['default_view']) && $view['default_view'] == 1)
					{
						$this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh] = $view['settings']->code;
					}
					// add site menu
					if (isset($view['menu']) && $view['menu'] == 1)
					{
						// SITE_MENU_XML <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_MENU_XML' . $this->hhh] = $this->setCustomViewMenu($view);
					}

					// insure the needed route helper is loaded
					$this->fileContentStatic[$this->hhh . 'ROUTEHELPER' . $this->hhh] .= $this->setRouterHelp($view['settings']->code, $view['settings']->code, true);
					// build route details 
					$this->fileContentStatic[$this->hhh . 'ROUTER_PARSE_SWITCH' . $this->hhh] .= $this->routerParseSwitch($view['settings']->code, $view);
					$this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh] .= $this->routerBuildViews($view['settings']->code);

					if ($view['settings']->main_get->gettype == 1)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'USER_PERMISSION_CHECK_ACCESS' . $this->hhh] = $this->setUserPermissionCheckAccess($view, 1);

						// SITE_BEFORE_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_BEFORE_GET_ITEM' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_before_getitem', $view['settings']->code, '', null, true);

						// SITE_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_GET_ITEM' . $this->hhh] = $this->setCustomViewGetItem($view['settings']->main_get, $view['settings']->code, $this->_t(2));

						// SITE_AFTER_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_AFTER_GET_ITEM' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_after_getitem', $view['settings']->code, '', null, true);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'USER_PERMISSION_CHECK_ACCESS' . $this->hhh] = $this->setUserPermissionCheckAccess($view, 2);
						// SITE_GET_LIST_QUERY <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_GET_LIST_QUERY' . $this->hhh] = $this->setCustomViewListQuery($view['settings']->main_get, $view['settings']->code);

						// SITE_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_BEFORE_GET_ITEMS' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_before_getitems', $view['settings']->code, PHP_EOL, null, true);

						// SITE_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_GET_ITEMS' . $this->hhh] = $this->setCustomViewGetItems($view['settings']->main_get, $view['settings']->code);

						// SITE_AFTER_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_AFTER_GET_ITEMS' . $this->hhh] = $this->getCustomScriptBuilder($this->target . '_php_after_getitems', $view['settings']->code, PHP_EOL, null, true);
					}
					// add to lang array
					$this->setLangContent('site', $this->langPrefix . '_' . $view['settings']->CODE, $view['settings']->name);
					$this->setLangContent('site', $this->langPrefix . '_' . $view['settings']->CODE . '_DESC', $view['settings']->description);
					// SITE_CUSTOM_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_CUSTOM_METHODS' . $this->hhh] = $this->setCustomViewCustomItemMethods($view['settings']->main_get, $view['settings']->code);
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_CUSTOM_METHODS' . $this->hhh] .= $this->setCustomViewCustomMethods($view, $view['settings']->code);
					// SITE_DIPLAY_METHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_DIPLAY_METHOD' . $this->hhh] = $this->setCustomViewDisplayMethod($view);
					// set document details
					$this->setPrepareDocument($view);
					// SITE_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_EXTRA_DIPLAY_METHODS' . $this->hhh] = $this->setCustomViewExtraDisplayMethods($view);
					// SITE_CODE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_CODE_BODY' . $this->hhh] = $this->setCustomViewCodeBody($view);
					// SITE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_BODY' . $this->hhh] = $this->setCustomViewBody($view);

					// setup the templates
					$this->setCustomViewTemplateBody($view);
		
					// set the site form if needed
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_TOP_FORM' . $this->hhh] = $this->setCustomViewForm($view['settings']->code, 1);
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_BOTTOM_FORM' . $this->hhh] = $this->setCustomViewForm($view['settings']->code, 2);

					// Trigger Event: jcb_ce_onAfterBuildSiteViewContent
					$this->triggerEvent('jcb_ce_onAfterBuildSiteViewContent', array(&$this->componentContext, &$view, &$view['settings']->code, &$this->fileContentStatic, &$this->fileContentDynamic[$view['settings']->code], &$this->placeholders, &$this->hhh));
				}
				// setup the layouts
				$this->setCustomViewLayouts();
			}
			else
			{
				// clear all site folder since none is needed
				$this->removeSiteFolder = true;
			}
			// load the site statics
			if (!$this->removeSiteFolder || !$this->removeSiteEditFolder)
			{
				$this->target = 'site';
				// if no default site view was set, the redirect to root
				if (!isset($this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh]))
				{
					$this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh] = '';
				}
				// set site custom script to helper class
				// SITE_CUSTOM_HELPER_SCRIPT
				$this->fileContentStatic[$this->hhh . 'SITE_CUSTOM_HELPER_SCRIPT' . $this->hhh] = $this->setPlaceholders($this->customScriptBuilder['component_php_helper_site'], $this->placeholders);
				// SITE_GLOBAL_EVENT_HELPER
				$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] = '';
				// SITE_GLOBAL_EVENT
				$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT' . $this->hhh] = '';
				// now load the data for the global event if needed
				if ($this->componentData->add_site_event == 1)
				{
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT' . $this->hhh] = PHP_EOL . PHP_EOL . '// Triger the Global Site Event';
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT' . $this->hhh] .= PHP_EOL . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper::globalEvent($document);';
					// SITE_GLOBAL_EVENT_HELPER
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] = PHP_EOL . PHP_EOL . $this->_t(1) . '/**';
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '*	The Global Site Event Method.';
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '**/';
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . 'public static function globalEvent($document)';
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '{';
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->setPlaceholders($this->customScriptBuilder['component_php_site_event'], $this->placeholders);
					$this->fileContentStatic[$this->hhh . 'SITE_GLOBAL_EVENT_HELPER' . $this->hhh] .= PHP_EOL . $this->_t(1) . '}';
				}
			}

			// PREINSTALLSCRIPT
			$this->fileContentStatic[$this->hhh . 'PREINSTALLSCRIPT' . $this->hhh] = $this->getCustomScriptBuilder('php_preflight', 'install', PHP_EOL, null, true);

			// PREUPDATESCRIPT
			$this->fileContentStatic[$this->hhh . 'PREUPDATESCRIPT' . $this->hhh] = $this->getCustomScriptBuilder('php_preflight', 'update', PHP_EOL, null, true);

			// POSTINSTALLSCRIPT
			$this->fileContentStatic[$this->hhh . 'POSTINSTALLSCRIPT' . $this->hhh] = $this->setPostInstallScript();

			// POSTUPDATESCRIPT
			$this->fileContentStatic[$this->hhh . 'POSTUPDATESCRIPT' . $this->hhh] = $this->setPostUpdateScript();

			// UNINSTALLSCRIPT
			$this->fileContentStatic[$this->hhh . 'UNINSTALLSCRIPT' . $this->hhh] = $this->setUninstallScript();

			// MOVEFOLDERSSCRIPT
			$this->fileContentStatic[$this->hhh . 'MOVEFOLDERSSCRIPT' . $this->hhh] = $this->setMoveFolderScript();

			// MOVEFOLDERSMETHOD
			$this->fileContentStatic[$this->hhh . 'MOVEFOLDERSMETHOD' . $this->hhh] = $this->setMoveFolderMethod();

			// HELPER_UIKIT
			$this->fileContentStatic[$this->hhh . 'HELPER_UIKIT' . $this->hhh] = $this->setUikitHelperMethods();

			// CONFIG_FIELDSETS
			$this->fileContentStatic[$this->hhh . 'CONFIG_FIELDSETS' . $this->hhh] = implode(PHP_EOL, $this->configFieldSets);

			// check if this has been set
			if (!isset($this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh]) || !ComponentbuilderHelper::checkString($this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh]))
			{
				$this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh] = 0;
			}
			else
			{
				$this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh] = '(' . $this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh] . ')';
			}

			// README
			if ($this->componentData->addreadme)
			{
				$this->fileContentStatic[$this->hhh . 'README' . $this->hhh] = $this->componentData->readme;
			}

			// tweak system to set stuff to the module domain
			$_backup_target = $this->target;
			$_backup_lang = $this->lang;
			$_backup_langPrefix = $this->langPrefix;
			// infuse module data if set
			if (ComponentbuilderHelper::checkArray($this->joomlaModules))
			{
				foreach ($this->joomlaModules as $module)
				{
					if (ComponentbuilderHelper::checkObject($module))
					{
						$this->target     = $module->key;
						$this->lang       = $module->key;
						$this->langPrefix = $module->lang_prefix;
						// MODCODE
						$this->fileContentDynamic[$module->key][$this->hhh . 'MODCODE' . $this->hhh] = $this->getModCode($module);
						// DYNAMICGET
						$this->fileContentDynamic[$module->key][$this->hhh . 'DYNAMICGETS' . $this->hhh] = $this->setCustomViewCustomMethods($module, $module->key);
						// HELPERCODE
						if ($module->add_class_helper >= 1)
						{
							$this->fileContentDynamic[$module->key][$this->hhh . 'HELPERCODE' . $this->hhh] = $this->getModHelperCode($module);
						}
						// MODDEFAULT
						$this->fileContentDynamic[$module->key][$this->hhh . 'MODDEFAULT' . $this->hhh] = $this->getModDefault($module);
						// only add install script if needed
						if ($module->add_install_script)
						{
							// INSTALLCLASS
							$this->fileContentDynamic[$module->key][$this->hhh . 'INSTALLCLASS' . $this->hhh] = $this->getExtensionInstallClass($module);
						}
						// FIELDSET
						if (isset($module->form_files) && ComponentbuilderHelper::checkArray($module->form_files))
						{
							foreach($module->form_files as $file => $files)
							{
								foreach ($files as $field_name => $fieldsets)
								{
									foreach ($fieldsets as $fieldset => $fields)
									{
										// FIELDSET_ . $file.$field_name.$fieldset
										$this->fileContentDynamic[$module->key][$this->hhh . 'FIELDSET_' . $file.$field_name.$fieldset . $this->hhh] =
											$this->getExtensionFieldsetXML($module, $fields);
									}
								}
							}
						}
						// MAINXML
						$this->fileContentDynamic[$module->key][$this->hhh . 'MAINXML' . $this->hhh] = $this->getModuleMainXML($module);
					}
				}
			}
			// infuse plugin data if set
			if (ComponentbuilderHelper::checkArray($this->joomlaPlugins))
			{
				foreach ($this->joomlaPlugins as $plugin)
				{
					if (ComponentbuilderHelper::checkObject($plugin))
					{
						$this->target = $plugin->key;
						$this->lang = $plugin->key;
						$this->langPrefix = $plugin->lang_prefix;
						// MAINCLASS
						$this->fileContentDynamic[$plugin->key][$this->hhh . 'MAINCLASS' . $this->hhh] = $this->getPluginMainClass($plugin);
						// only add install script if needed
						if ($plugin->add_install_script)
						{
							// INSTALLCLASS
							$this->fileContentDynamic[$plugin->key][$this->hhh . 'INSTALLCLASS' . $this->hhh] = $this->getExtensionInstallClass($plugin);
						}
						// FIELDSET
						if (isset($plugin->form_files) && ComponentbuilderHelper::checkArray($plugin->form_files))
						{
							foreach($plugin->form_files as $file => $files)
							{
								foreach ($files as $field_name => $fieldsets)
								{
									foreach ($fieldsets as $fieldset => $fields)
									{
										// FIELDSET_ . $file.$field_name.$fieldset
										$this->fileContentDynamic[$plugin->key][$this->hhh . 'FIELDSET_' . $file.$field_name.$fieldset . $this->hhh] =
											$this->getExtensionFieldsetXML($plugin, $fields);
									}
								}
							}
						}
						// MAINXML
						$this->fileContentDynamic[$plugin->key][$this->hhh . 'MAINXML' . $this->hhh] = $this->getPluginMainXML($plugin);
					}
				}
			}
			// rest globals
			$this->target = $_backup_target;
			$this->lang = $_backup_lang;
			$this->langPrefix = $_backup_langPrefix;

			// Trigger Event: jcb_ce_onAfterBuildFilesContent
			$this->triggerEvent('jcb_ce_onAfterBuildFilesContent', array(&$this->componentContext, &$this->componentData, &$this->fileContentStatic, &$this->fileContentDynamic, &$this->placeholders, &$this->hhh));

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

		// VIEW <<<DYNAMIC>>>
		if (isset($view->name_single))
		{
			// set main keys
			$viewName_single = ComponentbuilderHelper::safeString($view->name_single);
			$viewName_u = ComponentbuilderHelper::safeString($view->name_single, 'U');
			$viewName_f = ComponentbuilderHelper::safeString($view->name_single, 'F');

			// set some place holder for the views
			$this->placeholders[$this->hhh . 'view' . $this->hhh] = $viewName_single;
			$this->placeholders[$this->hhh . 'View' . $this->hhh] = $viewName_f;
			$this->placeholders[$this->hhh . 'VIEW' . $this->hhh] = $viewName_u;
			$this->placeholders[$this->bbb . 'view' . $this->ddd] = $viewName_single;
			$this->placeholders[$this->bbb . 'View' . $this->ddd] = $viewName_f;
			$this->placeholders[$this->bbb . 'VIEW' . $this->ddd] = $viewName_u;
		}

		// VIEWS <<<DYNAMIC>>>
		if (isset($view->name_list))
		{
			$viewName_list = ComponentbuilderHelper::safeString($view->name_list);
			$viewsName_u = ComponentbuilderHelper::safeString($view->name_list, 'U');
			$viewsName_f = ComponentbuilderHelper::safeString($view->name_list, 'F');

			// set some place holder for the views
			$this->placeholders[$this->hhh . 'views' . $this->hhh] = $viewName_list;
			$this->placeholders[$this->hhh . 'Views' . $this->hhh] = $viewsName_f;
			$this->placeholders[$this->hhh . 'VIEWS' . $this->hhh] = $viewsName_u;
			$this->placeholders[$this->bbb . 'views' . $this->ddd] = $viewName_list;
			$this->placeholders[$this->bbb . 'Views' . $this->ddd] = $viewsName_f;
			$this->placeholders[$this->bbb . 'VIEWS' . $this->ddd] = $viewsName_u;
		}

		// view <<<DYNAMIC>>>
		if (isset($viewName_single))
		{
			$this->fileContentDynamic[$viewName_single][$this->hhh . 'view' . $this->hhh] = $viewName_single;
			$this->fileContentDynamic[$viewName_single][$this->hhh . 'VIEW' . $this->hhh] = $viewName_u;
			$this->fileContentDynamic[$viewName_single][$this->hhh . 'View' . $this->hhh] = $viewName_f;

			if (isset($viewName_list))
			{
				$this->fileContentDynamic[$viewName_list][$this->hhh . 'view' . $this->hhh] = $viewName_single;
				$this->fileContentDynamic[$viewName_list][$this->hhh . 'VIEW' . $this->hhh] = $viewName_u;
				$this->fileContentDynamic[$viewName_list][$this->hhh . 'View' . $this->hhh] = $viewName_f;
			}
		}

		// views <<<DYNAMIC>>>
		if (isset($viewName_list))
		{
			$this->fileContentDynamic[$viewName_list][$this->hhh . 'views' . $this->hhh] = $viewName_list;
			$this->fileContentDynamic[$viewName_list][$this->hhh . 'VIEWS' . $this->hhh] = $viewsName_u;
			$this->fileContentDynamic[$viewName_list][$this->hhh . 'Views' . $this->hhh] = $viewsName_f;

			if (isset($viewName_single))
			{
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'views' . $this->hhh] = $viewName_list;
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'VIEWS' . $this->hhh] = $viewsName_u;
				$this->fileContentDynamic[$viewName_single][$this->hhh . 'Views' . $this->hhh] = $viewsName_f;
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
		// reset values
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
		if ((!$this->removeSiteFolder || !$this->removeSiteEditFolder) && $this->setLangSite())
		{
			$values[] = array_values($this->languages[$this->langTag]['site']);
			$mainLangLoader['site'] = count($this->languages[$this->langTag]['site']);
		}
		// check the site system lang is set
		if ((!$this->removeSiteFolder || !$this->removeSiteEditFolder) && $this->setLangSiteSys())
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
			// Trigger Event: jcb_ce_onBeforeBuildAllLangFiles
			$this->triggerEvent('jcb_ce_onBeforeBuildAllLangFiles', array(&$this->componentContext, &$this->languages, &$this->langTag));
			// rest xml array
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
						$langStringSum = ComponentbuilderHelper::bcmath('mul', $langStringNr, 100);
						$percentage = ComponentbuilderHelper::bcmath('div', $langStringSum, $mainLangLoader[$area]);
						$stringNAme = ($langStringNr == 1) ? '(string ' . $tag . ' translated)' : '(strings ' . $tag . ' translated)';
						// force load if debug lines are added
						if (!$this->debugLinenr)
						{
							// check if we sould install this translation
							if ($percentage < $this->percentageLanguageAdd)
							{
								// dont add
								$this->langNot[$area . ' ' . $tag] = '<b>' . $mainLangLoader[$area] . '</b>(total ' . $this->langTag . ' strings) only <b>' . $langStringNr . '</b>' . $stringNAme . ' = ' . $percentage;
								continue;
							}
						}
						// show if it was added as well
						$this->langSet[$area . ' ' . $tag] = '<b>' . $mainLangLoader[$area] . '</b>(total ' . $this->langTag . ' strings) and <b>' . $langStringNr . '</b>' . $stringNAme . ' = ' . $percentage;
					}
					// set naming convention
					$p = 'admin';
					$t = '';
					if (strpos($area, 'site') !== false)
					{
						if ($this->removeSiteFolder  && $this->removeSiteEditFolder)
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
					$lang = array_map(function ($langstring, $placeholder)
					{
						return $placeholder . '="' . $langstring . '"';
					}, $languageStrings, array_keys($languageStrings));
					// add to language file
					$this->writeFile($path . '/' . $fileName, implode(PHP_EOL, $lang));
					// set the line counter
					$this->lineCount = $this->lineCount + count((array) $lang);
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
					$replace[$this->hhh . 'ADMIN_LANGUAGES' . $this->hhh] = implode(PHP_EOL . $this->_t(3), $langXML['admin']);
				}
				if ((!$this->removeSiteFolder || !$this->removeSiteEditFolder) && isset($langXML['site']) && ComponentbuilderHelper::checkArray($langXML['site']))
				{
					$replace[$this->hhh . 'SITE_LANGUAGES' . $this->hhh] = implode(PHP_EOL . $this->_t(2), $langXML['site']);
				}
				// build xml path
				$xmlPath = $this->componentPath . '/' . $this->componentCodeName . '.xml';
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
