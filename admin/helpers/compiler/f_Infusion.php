<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;

/**
 * Infusion class
 */
class Infusion extends Interpretation
{


	public $langFiles = array();
	public $removeSiteFolder = false;
	public $removeSiteEditFolder = true;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// first we run the perent constructor
		if (parent::__construct())
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
		if (isset($this->componentData->admin_views)
			&& ArrayHelper::check(
				$this->componentData->admin_views
			))
		{
			// for plugin event TODO change event api signatures
			$this->placeholders = CFactory::_('Placeholder')->active;
			// Trigger Event: jcb_ce_onBeforeBuildFilesContent
			CFactory::_J('Event')->trigger(
				'jcb_ce_onBeforeBuildFilesContent',
				array(&$this->componentContext, &$this->componentData,
					&$this->fileContentStatic, &$this->fileContentDynamic,
					&$this->placeholders, &$this->hhh)
			);
			// for plugin event TODO change event api signatures
			CFactory::_('Placeholder')->active = $this->placeholders;

			// COMPONENT
			$this->fileContentStatic[Placefix::_h('COMPONENT')]
				= CFactory::_('Placeholder')->active[Placefix::_h('COMPONENT')];

			// Component
			$this->fileContentStatic[Placefix::_h('Component')]
				= CFactory::_('Placeholder')->active[Placefix::_h('Component')];

			// component
			$this->fileContentStatic[Placefix::_h('component')]
				= CFactory::_('Placeholder')->active[Placefix::_h('component')];

			// COMPANYNAME
			$this->fileContentStatic[Placefix::_h('COMPANYNAME')]
				= trim(
				JFilterOutput::cleanText($this->componentData->companyname)
			);

			// CREATIONDATE
			$this->fileContentStatic[Placefix::_h('CREATIONDATE')]
				= JFactory::getDate($this->componentData->created)->format(
				'jS F, Y'
			);
			$this->fileContentStatic[Placefix::_h('CREATIONDATE')
			. 'GLOBAL']
				= $this->fileContentStatic[Placefix::_h('CREATIONDATE')];

			// BUILDDATE
			$this->fileContentStatic[Placefix::_h('BUILDDATE')]
				= JFactory::getDate()->format('jS F, Y');
			$this->fileContentStatic[Placefix::_h('BUILDDATE')
			. 'GLOBAL']
				= $this->fileContentStatic[Placefix::_h('BUILDDATE')];

			// AUTHOR
			$this->fileContentStatic[Placefix::_h('AUTHOR')] = trim(
				JFilterOutput::cleanText($this->componentData->author)
			);

			// AUTHOREMAIL
			$this->fileContentStatic[Placefix::_h('AUTHOREMAIL')]
				= trim($this->componentData->email);

			// AUTHORWEBSITE
			$this->fileContentStatic[Placefix::_h('AUTHORWEBSITE')]
				= trim($this->componentData->website);

			// COPYRIGHT
			$this->fileContentStatic[Placefix::_h('COPYRIGHT')]
				= trim($this->componentData->copyright);

			// LICENSE
			$this->fileContentStatic[Placefix::_h('LICENSE')]
				= trim($this->componentData->license);

			// VERSION
			$this->fileContentStatic[Placefix::_h('VERSION')]
				= trim($this->componentData->component_version);
			// set the actual global version
			$this->fileContentStatic[Placefix::_h('ACTUALVERSION')]
				= $this->fileContentStatic[Placefix::_h('VERSION')];

			// do some Tweaks to the version based on selected options
			if (strpos(
					$this->fileContentStatic[Placefix::_h('VERSION')], '.'
				) !== false)
			{
				$versionArray = explode(
					'.', $this->fileContentStatic[Placefix::_h('VERSION')]
				);
			}
			// load only first two values
			if (isset($versionArray)
				&& ArrayHelper::check(
					$versionArray
				)
				&& $this->componentData->mvc_versiondate == 2)
			{
				$this->fileContentStatic[Placefix::_h('VERSION')]
					= $versionArray[0] . '.' . $versionArray[1] . '.x';
			}
			// load only the first value
			elseif (isset($versionArray)
				&& ArrayHelper::check(
					$versionArray
				)
				&& $this->componentData->mvc_versiondate == 3)
			{
				$this->fileContentStatic[Placefix::_h('VERSION')]
					= $versionArray[0] . '.x.x';
			}
			unset($versionArray);

			// set the global version in case			
			$this->fileContentStatic[Placefix::_h('VERSION')
			. 'GLOBAL']
				= $this->fileContentStatic[Placefix::_h('VERSION')];

			// set the joomla target xml version
			$this->fileContentStatic[Placefix::_h('XMLVERSION')]
				= $this->joomlaVersions[CFactory::_('Config')->joomla_version]['xml_version'];

			// Component_name
			$this->fileContentStatic[Placefix::_h('Component_name')]
				= JFilterOutput::cleanText($this->componentData->name);

			// SHORT_DISCRIPTION
			$this->fileContentStatic[Placefix::_h('SHORT_DESCRIPTION')]
				= trim(
				JFilterOutput::cleanText(
					$this->componentData->short_description
				)
			);

			// DESCRIPTION
			$this->fileContentStatic[Placefix::_h('DESCRIPTION')]
				= trim($this->componentData->description);

			// COMP_IMAGE_TYPE
			$this->fileContentStatic[Placefix::_h('COMP_IMAGE_TYPE')]
				= $this->setComponentImageType($this->componentData->image);

			// ACCESS_SECTIONS
			$this->fileContentStatic[Placefix::_h('ACCESS_SECTIONS')]
				= $this->setAccessSections();

			// CONFIG_FIELDSETS
			$keepLang   = CFactory::_('Config')->lang_target;
			CFactory::_('Config')->lang_target = 'admin';

			// start loading the category tree scripts
			$this->fileContentStatic[Placefix::_h('CATEGORY_CLASS_TREES')]
				= '';
			// run the field sets for first time
			$this->setConfigFieldsets(1);
			CFactory::_('Config')->lang_target = $keepLang;

			// ADMINJS
			$this->fileContentStatic[Placefix::_h('ADMINJS')]
				= CFactory::_('Placeholder')->update(
				$this->customScriptBuilder['component_js'], CFactory::_('Placeholder')->active
			);
			// SITEJS
			$this->fileContentStatic[Placefix::_h('SITEJS')]
				= CFactory::_('Placeholder')->update(
				$this->customScriptBuilder['component_js'], CFactory::_('Placeholder')->active
			);

			// ADMINCSS
			$this->fileContentStatic[Placefix::_h('ADMINCSS')]
				= CFactory::_('Placeholder')->update(
				$this->customScriptBuilder['component_css_admin'],
				CFactory::_('Placeholder')->active
			);
			// SITECSS
			$this->fileContentStatic[Placefix::_h('SITECSS')]
				= CFactory::_('Placeholder')->update(
				$this->customScriptBuilder['component_css_site'],
				CFactory::_('Placeholder')->active
			);

			// CUSTOM_HELPER_SCRIPT
			$this->fileContentStatic[Placefix::_h('CUSTOM_HELPER_SCRIPT')]
				= CFactory::_('Placeholder')->update(
				$this->customScriptBuilder['component_php_helper_admin'],
				CFactory::_('Placeholder')->active
			);

			// BOTH_CUSTOM_HELPER_SCRIPT
			$this->fileContentStatic[Placefix::_h('BOTH_CUSTOM_HELPER_SCRIPT')]
				= CFactory::_('Placeholder')->update(
				$this->customScriptBuilder['component_php_helper_both'],
				CFactory::_('Placeholder')->active
			);

			// ADMIN_GLOBAL_EVENT_HELPER
			if (!isset($this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT')]))
			{
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT')] = '';
			}
			if (!isset($this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]))
			{
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')] = '';
			}
			// now load the data for the global event if needed
			if ($this->componentData->add_admin_event == 1)
			{
				// ADMIN_GLOBAL_EVENT
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT')]
					.= PHP_EOL . PHP_EOL . '// Trigger the Global Admin Event';
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT')]
					.= PHP_EOL . $this->fileContentStatic[Placefix::_h('Component')]
					. 'Helper::globalEvent($document);';
				// ADMIN_GLOBAL_EVENT_HELPER
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]
					.= PHP_EOL . PHP_EOL . Indent::_(1) . '/**';
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]
					.= PHP_EOL . Indent::_(1)
					. '*	The Global Admin Event Method.';
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]
					.= PHP_EOL . Indent::_(1) . '**/';
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]
					.= PHP_EOL . Indent::_(1)
					. 'public static function globalEvent($document)';
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]
					.= PHP_EOL . Indent::_(1) . '{';
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]
					.= PHP_EOL . CFactory::_('Placeholder')->update(
						$this->customScriptBuilder['component_php_admin_event'],
						CFactory::_('Placeholder')->active
					);
				$this->fileContentStatic[Placefix::_h('ADMIN_GLOBAL_EVENT_HELPER')]
					.= PHP_EOL . Indent::_(1) . '}';
			}

			// now load the readme file if needed
			if ($this->componentData->addreadme == 1)
			{
				$this->fileContentStatic[Placefix::_h('EXSTRA_ADMIN_FILES')]
					.= PHP_EOL . Indent::_(3)
					. "<filename>README.txt</filename>";
			}

			// HELPER_CREATEUSER
			$this->fileContentStatic[Placefix::_h('HELPER_CREATEUSER')]
				= $this->setCreateUserHelperMethod(
				$this->componentData->creatuserhelper
			);

			// HELP
			$this->fileContentStatic[Placefix::_h('HELP')]
				= $this->noHelp();
			// HELP_SITE
			$this->fileContentStatic[Placefix::_h('HELP_SITE')]
				= $this->noHelp();

			// build route parse switch
			$this->fileContentStatic[Placefix::_h('ROUTER_PARSE_SWITCH')]
				= '';
			// build route views
			$this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')]
				= '';

			// add the helper emailer if set
			$this->fileContentStatic[Placefix::_h('HELPER_EMAIL')]
				= $this->addEmailHelper();

			// load the global placeholders
			if (ArrayHelper::check($this->globalPlaceholders))
			{
				foreach (
					$this->globalPlaceholders as $globalPlaceholder =>
					$gloabalValue
				)
				{
					$this->fileContentStatic[$globalPlaceholder]
						= $gloabalValue;
				}
			}
			// reset view array
			$viewarray            = array();
			$site_edit_view_array = array();
			// start dynamic build
			foreach ($this->componentData->admin_views as $view)
			{
				// set the target
				CFactory::_('Config')->build_target = 'admin';
				CFactory::_('Config')->lang_target = 'admin';

				// set local names
				$nameSingleCode = $view['settings']->name_single_code;
				$nameListCode   = $view['settings']->name_list_code;

				// set the view placeholders
				$this->setViewPlaceholders($view['settings']);

				// set site edit view array
				if (isset($view['edit_create_site_view'])
					&& is_numeric(
						$view['edit_create_site_view']
					)
					&& $view['edit_create_site_view'] > 0)
				{
					$site_edit_view_array[] = Indent::_(4) . "'"
						. $nameSingleCode . "'";
					CFactory::_('Config')->lang_target = 'both';
					// insure site view does not get removed
					$this->removeSiteEditFolder = false;
				}
				// check if help is being loaded
				$this->checkHelp($nameSingleCode);
				// set custom admin view list links
				$this->setCustomAdminViewListLink(
					$view, $nameListCode
				);

				// set view array
				$viewarray[] = Indent::_(4) . "'"
					. $nameSingleCode . "' => '"
					. $nameListCode . "'";
				// set the view names
				if (isset($view['settings']->name_single)
					&& $view['settings']->name_single != 'null')
				{
					// set license per view if needed
					$this->setLockLicensePer(
						$nameSingleCode, CFactory::_('Config')->build_target
					);
					$this->setLockLicensePer(
						$nameListCode, CFactory::_('Config')->build_target
					);

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onBeforeBuildAdminEditViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onBeforeBuildAdminEditViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$nameSingleCode],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;

					// FIELDSETS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('FIELDSETS')]
						= $this->setFieldSet(
						$view, CFactory::_('Config')->component_code_name,
						$nameSingleCode,
						$nameListCode
					);

					// ACCESSCONTROL <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('ACCESSCONTROL')]
						= $this->setFieldSetAccessControl(
						$nameSingleCode
					);

					// LINKEDVIEWITEMS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('LINKEDVIEWITEMS')]
						= '';

					// ADDTOOLBAR <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('ADDTOOLBAR')]
						= $this->setAddToolBar($view);

					// set the script for this view
					$this->buildTheViewScript($view);

					// VIEW_SCRIPT
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('VIEW_SCRIPT')]
						= $this->setViewScript(
						$nameSingleCode, 'fileScript'
					);

					// EDITBODYSCRIPT
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('EDITBODYSCRIPT')]
						= $this->setViewScript(
						$nameSingleCode, 'footerScript'
					);

					// AJAXTOKE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('AJAXTOKE')]
						= $this->setAjaxToke(
						$nameSingleCode
					);

					// DOCUMENT_CUSTOM_PHP <<<DYNAMIC>>>
					if ($phpDocument = $this->getCustomScriptBuilder(
						'php_document', $nameSingleCode,
						PHP_EOL, null, true,
						false
					))
					{
						$this->fileContentDynamic[$nameSingleCode][Placefix::_h('DOCUMENT_CUSTOM_PHP')]
							= str_replace(
							'$document->', '$this->document->', $phpDocument
						);
						// clear some memory
						unset($phpDocument);
					}
					else
					{
						$this->fileContentDynamic[$nameSingleCode][Placefix::_h('DOCUMENT_CUSTOM_PHP')]
							= '';
					}
					// LINKEDVIEWTABLESCRIPTS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('LINKEDVIEWTABLESCRIPTS')]
						= '';

					// VALIDATEFIX <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('VALIDATIONFIX')]
						= $this->setValidationFix(
						$nameSingleCode,
						$this->fileContentStatic[Placefix::_h('Component')]
					);

					// EDITBODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('EDITBODY')]
						= $this->setEditBody($view);

					// EDITBODYFADEIN <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('EDITBODYFADEIN')]
						= $this->setFadeInEfect($view);

					// JTABLECONSTRUCTOR <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JTABLECONSTRUCTOR')]
						= $this->setJtableConstructor(
						$nameSingleCode
					);

					// JTABLEALIASCATEGORY <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JTABLEALIASCATEGORY')]
						= $this->setJtableAliasCategory(
						$nameSingleCode
					);

					// METHOD_GET_ITEM <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('METHOD_GET_ITEM')]
						= $this->setMethodGetItem(
						$nameSingleCode
					);

					// LINKEDVIEWGLOBAL <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('LINKEDVIEWGLOBAL')]
						= '';

					// LINKEDVIEWMETHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('LINKEDVIEWMETHODS')]
						= '';

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_BEFORE_DELETE')]
						= $this->getCustomScriptBuilder(
						'php_before_delete',
						$nameSingleCode, PHP_EOL
					);

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_AFTER_DELETE')]
						= $this->getCustomScriptBuilder(
						'php_after_delete', $nameSingleCode,
						PHP_EOL . PHP_EOL
					);

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_BEFORE_PUBLISH')]
						= $this->getCustomScriptBuilder(
						'php_before_publish',
						$nameSingleCode, PHP_EOL
					);

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_AFTER_PUBLISH')]
						= $this->getCustomScriptBuilder(
						'php_after_publish',
						$nameSingleCode, PHP_EOL . PHP_EOL
					);

					// CHECKBOX_SAVE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('CHECKBOX_SAVE')]
						= $this->setCheckboxSave(
						$nameSingleCode
					);

					// METHOD_ITEM_SAVE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('METHOD_ITEM_SAVE')]
						= $this->setMethodItemSave(
						$nameSingleCode
					);

					// POSTSAVEHOOK <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('POSTSAVEHOOK')]
						= $this->getCustomScriptBuilder(
						'php_postsavehook', $nameSingleCode,
						PHP_EOL, null,
						true, PHP_EOL . Indent::_(2) . "return;",
						PHP_EOL . PHP_EOL . Indent::_(2) . "return;"
					);

					// VIEWCSS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('VIEWCSS')]
						= $this->getCustomScriptBuilder(
						'css_view', $nameSingleCode, '',
						null, true
					);

					// add css to front end
					if (isset($view['edit_create_site_view'])
						&& is_numeric(
							$view['edit_create_site_view']
						)
						&& $view['edit_create_site_view'] > 0)
					{
						$this->fileContentDynamic[$nameSingleCode][Placefix::_h('SITE_VIEWCSS')]
							= $this->fileContentDynamic[$nameSingleCode][Placefix::_h('VIEWCSS')];
						// check if we should add a create menu
						if ($view['edit_create_site_view'] == 2)
						{
							// SITE_MENU_XML <<<DYNAMIC>>>
							$this->fileContentDynamic[$nameSingleCode][Placefix::_h('SITE_MENU_XML')]
								= $this->setAdminViewMenu(
								$nameSingleCode, $view
							);
						}
						// SITE_ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						$this->fileContentDynamic[$nameSingleCode][Placefix::_h('SITE_ADMIN_VIEW_CONTROLLER_HEADER')]
							= $this->setFileHeader(
							'site.admin.view.controller',
							$nameSingleCode
						);
						// SITE_ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						$this->fileContentDynamic[$nameSingleCode][Placefix::_h('SITE_ADMIN_VIEW_MODEL_HEADER')]
							= $this->setFileHeader(
							'site.admin.view.model',
							$nameSingleCode
						);
						// SITE_ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$nameSingleCode][Placefix::_h('SITE_ADMIN_VIEW_HTML_HEADER')]
							= $this->setFileHeader(
							'site.admin.view.html',
							$nameSingleCode
						);
						// SITE_ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$nameSingleCode][Placefix::_h('SITE_ADMIN_VIEW_HEADER')]
							= $this->setFileHeader(
							'site.admin.view',
							$nameSingleCode
						);
					}

					// TABLAYOUTFIELDSARRAY <<<DYNAMIC>>> add the tab layout fields array to the model
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('TABLAYOUTFIELDSARRAY')]
						= $this->getTabLayoutFieldsArray(
						$nameSingleCode
					);

					// ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('ADMIN_VIEW_CONTROLLER_HEADER')]
						= $this->setFileHeader(
						'admin.view.controller',
						$nameSingleCode
					);
					// ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('ADMIN_VIEW_MODEL_HEADER')]
						= $this->setFileHeader(
						'admin.view.model', $nameSingleCode
					);
					// ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('ADMIN_VIEW_HTML_HEADER')]
						= $this->setFileHeader(
						'admin.view.html', $nameSingleCode
					);
					// ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
					$this->fileContentDynamic[$nameSingleCode][Placefix::_h('ADMIN_VIEW_HEADER')]
						= $this->setFileHeader(
						'admin.view', $nameSingleCode
					);

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onAfterBuildAdminEditViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onAfterBuildAdminEditViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$nameSingleCode],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;
				}
				// set the views names
				if (isset($view['settings']->name_list)
					&& $view['settings']->name_list != 'null')
				{
					CFactory::_('Config')->lang_target = 'admin';

					// ICOMOON <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ICOMOON')]
						= $view['icomoon'];

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onBeforeBuildAdminListViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onBeforeBuildAdminListViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$nameListCode],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;

					// set the export/import option
					if (isset($view['port']) && $view['port']
						|| 1 == $view['settings']->add_custom_import)
					{
						$this->eximportView[$nameListCode]
							= true;
						if (1 == $view['settings']->add_custom_import)
						{
							// this view has custom import scripting
							$this->importCustomScripts[$nameListCode]
								= true;
							// set all custom scripts
							$this->setImportCustomScripts(
								$nameListCode
							);
						}
					}
					else
					{
						$this->eximportView[$nameListCode]
							= false;
					}

					// set Auto check in function
					if (isset($view['checkin']) && $view['checkin'] == 1)
					{
						// AUTOCHECKIN <<<DYNAMIC>>>
						$this->fileContentDynamic[$nameListCode][Placefix::_h('AUTOCHECKIN')]
							= $this->setAutoCheckin(
							$nameSingleCode,
							CFactory::_('Config')->component_code_name
						);
						// CHECKINCALL <<<DYNAMIC>>>
						$this->fileContentDynamic[$nameListCode][Placefix::_h('CHECKINCALL')]
							= $this->setCheckinCall();
					}
					else
					{
						// AUTOCHECKIN <<<DYNAMIC>>>
						$this->fileContentDynamic[$nameListCode][Placefix::_h('AUTOCHECKIN')]
							= '';
						// CHECKINCALL <<<DYNAMIC>>>
						$this->fileContentDynamic[$nameListCode][Placefix::_h('CHECKINCALL')]
							= '';
					}
					// admin list file contnet
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_JAVASCRIPT_FILE')]
						= $this->setViewScript(
						$nameListCode, 'list_fileScript'
					);
					// ADMIN_CUSTOM_BUTTONS_LIST
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_CUSTOM_BUTTONS_LIST')]
						= $this->setCustomButtons($view, 3, Indent::_(1));
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_CUSTOM_FUNCTION_ONLY_BUTTONS_LIST')]
						= $this->setFunctionOnlyButtons(
						$nameListCode
					);

					// GET_ITEMS_METHOD_STRING_FIX <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('GET_ITEMS_METHOD_STRING_FIX')]
						= $this->setGetItemsMethodStringFix(
						$nameSingleCode,
						$nameListCode,
						$this->fileContentStatic[Placefix::_h('Component')]
					);

					// GET_ITEMS_METHOD_AFTER_ALL <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('GET_ITEMS_METHOD_AFTER_ALL')]
						= $this->getCustomScriptBuilder(
						'php_getitems_after_all',
						$nameSingleCode, PHP_EOL
					);

					// SELECTIONTRANSLATIONFIX <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('SELECTIONTRANSLATIONFIX')]
						= $this->setSelectionTranslationFix(
						$nameListCode,
						$this->fileContentStatic[Placefix::_h('Component')]
					);

					// SELECTIONTRANSLATIONFIXFUNC <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('SELECTIONTRANSLATIONFIXFUNC')]
						= $this->setSelectionTranslationFixFunc(
						$nameListCode,
						$this->fileContentStatic[Placefix::_h('Component')]
					);

					// FILTER_FIELDS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('FILTER_FIELDS')]
						= $this->setFilterFieldsArray(
						$nameSingleCode,
						$nameListCode
					);

					// STOREDID <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('STOREDID')]
						= $this->setStoredId(
						$nameSingleCode, $nameListCode
					);

					// POPULATESTATE <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('POPULATESTATE')]
						= $this->setPopulateState(
						$nameSingleCode, $nameListCode
					);

					// SORTFIELDS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('SORTFIELDS')]
						= $this->setSortFields(
						$nameListCode
					);

					// CATEGORY_VIEWS
					if (!isset(
						$this->fileContentStatic[Placefix::_h('ROUTER_CATEGORY_VIEWS')]
					))
					{
						$this->fileContentStatic[Placefix::_h('ROUTER_CATEGORY_VIEWS')]
							= '';
					}
					$this->fileContentStatic[Placefix::_h('ROUTER_CATEGORY_VIEWS')]
						.= $this->setRouterCategoryViews(
						$nameSingleCode,
						$nameListCode
					);

					// FILTERFIELDDISPLAYHELPER <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('FILTERFIELDDISPLAYHELPER')]
						= $this->setFilterFieldSidebarDisplayHelper(
						$nameSingleCode,
						$nameListCode
					);

					// BATCHDISPLAYHELPER <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('BATCHDISPLAYHELPER')]
						= $this->setBatchDisplayHelper(
						$nameSingleCode,
						$nameListCode
					);

					// FILTERFUNCTIONS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('FILTERFUNCTIONS')]
						= $this->setFilterFieldHelper(
						$nameSingleCode,
						$nameListCode
					);

					// FIELDFILTERSETS <<<DYNAMIC>>>
					$this->fileContentDynamic['filter_'
					. $nameListCode][Placefix::_h('FIELDFILTERSETS')]
						= $this->setFieldFilterSet(
						$nameSingleCode,
						$nameListCode
					);

					// FIELDLISTSETS <<<DYNAMIC>>>
					$this->fileContentDynamic['filter_'
					. $nameListCode][Placefix::_h('FIELDLISTSETS')]
						= $this->setFieldFilterListSet(
						$nameSingleCode,
						$nameListCode
					);

					// LISTQUERY <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('LISTQUERY')]
						= $this->setListQuery(
						$nameSingleCode,
						$nameListCode
					);

					// MODELEXPORTMETHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('MODELEXPORTMETHOD')]
						= $this->setGetItemsModelMethod(
						$nameSingleCode,
						$nameListCode
					);

					// MODELEXIMPORTMETHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('CONTROLLEREXIMPORTMETHOD')]
						= $this->setControllerEximportMethod(
						$nameSingleCode,
						$nameListCode
					);

					// EXPORTBUTTON <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('EXPORTBUTTON')]
						= $this->setExportButton(
						$nameSingleCode,
						$nameListCode
					);

					// IMPORTBUTTON <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('IMPORTBUTTON')]
						= $this->setImportButton(
						$nameSingleCode,
						$nameListCode
					);

					// VIEWS_DEFAULT_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('VIEWS_DEFAULT_BODY')]
						= $this->setDefaultViewsBody(
						$nameSingleCode,
						$nameListCode
					);

					// LISTHEAD <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('LISTHEAD')]
						= $this->setListHead(
						$nameSingleCode,
						$nameListCode
					);

					// LISTBODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('LISTBODY')]
						= $this->setListBody(
						$nameSingleCode,
						$nameListCode
					);

					// LISTCOLNR <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('LISTCOLNR')]
						= $this->setListColnr(
						$nameListCode
					);

					// JVIEWLISTCANDO <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('JVIEWLISTCANDO')]
						= $this->setJviewListCanDo(
						$nameSingleCode,
						$nameListCode
					);

					// VIEWSCSS <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('VIEWSCSS')]
						= $this->getCustomScriptBuilder(
						'css_views', $nameSingleCode, '',
						null, true
					);

					// ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_DIPLAY_METHOD')]
						= $this->setAdminViewDisplayMethod(
						$nameListCode
					);

					// VIEWS_FOOTER_SCRIPT <<<DYNAMIC>>>
					$scriptNote = PHP_EOL . '//' . Line::_(__Line__, __Class__)
						. ' ' . $nameListCode
						. ' footer script';
					if (($footerScript = $this->getCustomScriptBuilder(
							'views_footer', $nameSingleCode, '',
							$scriptNote, true,
							false, PHP_EOL
						)) !== false
						&& StringHelper::check($footerScript))
					{
						// only minfy if no php is added to the footer script
						if (CFactory::_('Config')->get('minify', 0)
							&& strpos($footerScript, '<?php') === false)
						{
							// minfy the script
							$minifier = new JS;
							$minifier->add($footerScript);
							$footerScript = $minifier->minify();
							// clear some memory
							unset($minifier);
						}
						$this->fileContentDynamic[$nameListCode][Placefix::_h('VIEWS_FOOTER_SCRIPT')]
							= PHP_EOL . '<script type="text/javascript">'
							. $footerScript . "</script>";
						// clear some memory
						unset($footerScript);
					}
					else
					{
						$this->fileContentDynamic[$nameListCode][Placefix::_h('VIEWS_FOOTER_SCRIPT')]
							= '';
					}

					// ADMIN_VIEWS_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_VIEWS_CONTROLLER_HEADER')]
						= $this->setFileHeader(
						'admin.views.controller',
						$nameListCode
					);
					// ADMIN_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_VIEWS_MODEL_HEADER')]
						= $this->setFileHeader(
						'admin.views.model', $nameListCode
					);
					// ADMIN_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the views
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_VIEWS_HTML_HEADER')]
						= $this->setFileHeader(
						'admin.views.html', $nameListCode
					);
					// ADMIN_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the views
					$this->fileContentDynamic[$nameListCode][Placefix::_h('ADMIN_VIEWS_HEADER')]
						= $this->setFileHeader(
						'admin.views', $nameListCode
					);

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onAfterBuildAdminListViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onAfterBuildAdminListViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$nameListCode],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;
				}

				// set u fields used in batch
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('UNIQUEFIELDS')]
					= $this->setUniqueFields(
					$nameSingleCode
				);

				// TITLEALIASFIX <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('TITLEALIASFIX')]
					= $this->setAliasTitleFix(
					$nameSingleCode
				);

				// GENERATENEWTITLE <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('GENERATENEWTITLE')]
					= $this->setGenerateNewTitle(
					$nameSingleCode
				);

				// GENERATENEWALIAS <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('GENERATENEWALIAS')]
					= $this->setGenerateNewAlias(
					$nameSingleCode
				);

				// MODEL_BATCH_COPY <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('MODEL_BATCH_COPY')]
					= $this->setBatchCopy($nameSingleCode);

				// MODEL_BATCH_MOVE <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('MODEL_BATCH_MOVE')]
					= $this->setBatchMove($nameSingleCode);

				// BATCH_ONCLICK_CANCEL_SCRIPT <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameListCode][Placefix::_h('BATCH_ONCLICK_CANCEL_SCRIPT')]
					= ''; // TODO <-- must still be build

				// JCONTROLLERFORM_ALLOWADD <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JCONTROLLERFORM_ALLOWADD')]
					= $this->setJcontrollerAllowAdd(
					$nameSingleCode,
					$nameListCode
				);

				// JCONTROLLERFORM_BEFORECANCEL <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JCONTROLLERFORM_BEFORECANCEL')]
					= $this->getCustomScriptBuilder(
					'php_before_cancel', $nameSingleCode,
					PHP_EOL, null, null,
					''
				);

				// JCONTROLLERFORM_AFTERCANCEL <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JCONTROLLERFORM_AFTERCANCEL')]
					= $this->getCustomScriptBuilder(
					'php_after_cancel', $nameSingleCode,
					PHP_EOL, null, null,
					''
				);

				// JCONTROLLERFORM_ALLOWEDIT <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JCONTROLLERFORM_ALLOWEDIT')]
					= $this->setJcontrollerAllowEdit(
					$nameSingleCode,
					$nameListCode
				);

				// JMODELADMIN_GETFORM <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_GETFORM')]
					= $this->setJmodelAdminGetForm(
					$nameSingleCode,
					$nameListCode
				);

				// JMODELADMIN_ALLOWEDIT <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_ALLOWEDIT')]
					= $this->setJmodelAdminAllowEdit(
					$nameSingleCode,
					$nameListCode
				);

				// JMODELADMIN_CANDELETE <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_CANDELETE')]
					= $this->setJmodelAdminCanDelete(
					$nameSingleCode,
					$nameListCode
				);

				// JMODELADMIN_CANEDITSTATE <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('JMODELADMIN_CANEDITSTATE')]
					= $this->setJmodelAdminCanEditState(
					$nameSingleCode,
					$nameListCode
				);

				// set custom admin view Toolbare buttons
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS  <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameListCode][Placefix::_h('CUSTOM_ADMIN_DYNAMIC_BUTTONS')]
					= $this->setCustomAdminDynamicButton(
					$nameListCode
				);
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER  <<<DYNAMIC>>>
				$this->fileContentDynamic[$nameListCode][Placefix::_h('CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER')]
					= $this->setCustomAdminDynamicButtonController(
					$nameListCode
				);

				// set helper router
				if (!isset(
					$this->fileContentStatic[Placefix::_h('ROUTEHELPER')]
				))
				{
					$this->fileContentStatic[Placefix::_h('ROUTEHELPER')]
						= '';
				}
				$this->fileContentStatic[Placefix::_h('ROUTEHELPER')]
					.= $this->setRouterHelp(
					$nameSingleCode,
					$nameListCode
				);

				if (isset($view['edit_create_site_view'])
					&& is_numeric(
						$view['edit_create_site_view']
					)
					&& $view['edit_create_site_view'] > 0)
				{
					// add needed router stuff for front edit views
					$this->fileContentStatic[Placefix::_h('ROUTER_PARSE_SWITCH')]
						.= $this->routerParseSwitch(
						$nameSingleCode, null, false
					);
					$this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')]
						.= $this->routerBuildViews(
						$nameSingleCode
					);
				}

				// ACCESS_SECTIONS
				if (!isset(
					$this->fileContentStatic[Placefix::_h('ACCESS_SECTIONS')]
				))
				{
					$this->fileContentStatic[Placefix::_h('ACCESS_SECTIONS')]
						= '';
				}
				$this->fileContentStatic[Placefix::_h('ACCESS_SECTIONS')]
					.= $this->setAccessSectionsCategory(
					$nameSingleCode,
					$nameListCode
				);
				// set the Joomla Fields ACCESS section if needed
				if (isset($view['joomla_fields'])
					&& $view['joomla_fields'] == 1)
				{
					$this->fileContentStatic[Placefix::_h('ACCESS_SECTIONS')]
						.= $this->setAccessSectionsJoomlaFields();
				}

				// for plugin event TODO change event api signatures
				$this->placeholders = CFactory::_('Placeholder')->active;
				// Trigger Event: jcb_ce_onAfterBuildAdminViewContent
				CFactory::_J('Event')->trigger(
					'jcb_ce_onAfterBuildAdminViewContent',
					array(&$this->componentContext, &$view,
						&$nameSingleCode,
						&$nameListCode,
						&$this->fileContentStatic,
						&$this->fileContentDynamic, &$this->placeholders,
						&$this->hhh)
				);
				// for plugin event TODO change event api signatures
				CFactory::_('Placeholder')->active = $this->placeholders;
			}

			// setup the layouts
			$this->setCustomViewLayouts();

			// setup custom_admin_views and all needed stuff for the site
			if (isset($this->componentData->custom_admin_views)
				&& ArrayHelper::check(
					$this->componentData->custom_admin_views
				))
			{
				CFactory::_('Config')->build_target = 'custom_admin';
				CFactory::_('Config')->lang_target = 'admin';
				// start dynamic build
				foreach ($this->componentData->custom_admin_views as $view)
				{
					// for single views
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SView')]
						= $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('sview')]
						= $view['settings']->code;
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SVIEW')]
						= $view['settings']->CODE;
					// for list views
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SViews')]
						= $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('sviews')]
						= $view['settings']->code;
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SVIEWS')]
						= $view['settings']->CODE;
					// add to lang array
					CFactory::_('Language')->set(
						CFactory::_('Config')->lang_target,
						CFactory::_('Config')->lang_prefix . '_' . $view['settings']->CODE,
						$view['settings']->name
					);
					CFactory::_('Language')->set(
						CFactory::_('Config')->lang_target,
						CFactory::_('Config')->lang_prefix . '_' . $view['settings']->CODE
						. '_DESC', $view['settings']->description
					);
					// ICOMOON <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('ICOMOON')]
						= $view['icomoon'];

					// set placeholders
					CFactory::_('Placeholder')->active[Placefix::_h('SView')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_h('sview')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_h('SVIEW')]
						= $view['settings']->CODE;
					CFactory::_('Placeholder')->active[Placefix::_('SView')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_('sview')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_('SVIEW')]
						= $view['settings']->CODE;
					CFactory::_('Placeholder')->active[Placefix::_h('SViews')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_h('sviews')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_h('SVIEWS')]
						= $view['settings']->CODE;
					CFactory::_('Placeholder')->active[Placefix::_('SViews')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_('sviews')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_('SVIEWS')]
						= $view['settings']->CODE;

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onBeforeBuildCustomAdminViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onBeforeBuildCustomAdminViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$view['settings']->code],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;

					// set license per view if needed
					$this->setLockLicensePer(
						$view['settings']->code, CFactory::_('Config')->build_target
					);

					// check if this custom admin view is the default view
					if ($this->dynamicDashboardType === 'custom_admin_views'
						&& $this->dynamicDashboard === $view['settings']->code)
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('HIDEMAINMENU')]
							= '';
					}
					else
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('HIDEMAINMENU')]
							= PHP_EOL . Indent::_(2) . '//' . Line::_(
								__LINE__,__CLASS__
							) . " hide the main menu"
							. PHP_EOL . Indent::_(2)
							. "\$this->app->input->set('hidemainmenu', true);";
					}

					if ($view['settings']->main_get->gettype == 1)
					{
						// CUSTOM_ADMIN_BEFORE_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_BEFORE_GET_ITEM')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_before_getitem',
							$view['settings']->code, '', null, true
						);

						// CUSTOM_ADMIN_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_GET_ITEM')]
							= $this->setCustomViewGetItem(
							$view['settings']->main_get,
							$view['settings']->code, Indent::_(2)
						);

						// CUSTOM_ADMIN_AFTER_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_AFTER_GET_ITEM')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_after_getitem',
							$view['settings']->code, '', null, true
						);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// CUSTOM_ADMIN_GET_LIST_QUERY <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_GET_LIST_QUERY')]
							= $this->setCustomViewListQuery(
							$view['settings']->main_get, $view['settings']->code
						);

						// CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_getlistquery',
							$view['settings']->code, PHP_EOL, null, true
						);

						// CUSTOM_ADMIN_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_BEFORE_GET_ITEMS')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_before_getitems',
							$view['settings']->code, PHP_EOL, null, true
						);

						// CUSTOM_ADMIN_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_GET_ITEMS')]
							= $this->setCustomViewGetItems(
							$view['settings']->main_get, $view['settings']->code
						);

						// CUSTOM_ADMIN_AFTER_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_AFTER_GET_ITEMS')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_after_getitems',
							$view['settings']->code, PHP_EOL, null, true
						);
					}

					// CUSTOM_ADMIN_CUSTOM_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_CUSTOM_METHODS')]
						= $this->setCustomViewCustomItemMethods(
						$view['settings']->main_get, $view['settings']->code
					);
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_CUSTOM_METHODS')]
						.= $this->setCustomViewCustomMethods(
						$view, $view['settings']->code
					);
					// CUSTOM_ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_DIPLAY_METHOD')]
						= $this->setCustomViewDisplayMethod($view);
					// set document details
					$this->setPrepareDocument($view);
					// CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS')]
						= $this->setCustomViewExtraDisplayMethods($view);
					// CUSTOM_ADMIN_CODE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_CODE_BODY')]
						= $this->setCustomViewCodeBody($view);
					// CUSTOM_ADMIN_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_BODY')]
						= $this->setCustomViewBody($view);
					// CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT')]
						= $this->setCustomViewSubmitButtonScript($view);

					// setup the templates
					$this->setCustomViewTemplateBody($view);

					// set the site form if needed
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_TOP_FORM')]
						= $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 1
					);
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_BOTTOM_FORM')]
						= $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 2
					);

					// set headers based on the main get type
					if ($view['settings']->main_get->gettype == 1)
					{
						// CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER')]
							= $this->setFileHeader(
							'custom.admin.view.controller',
							$view['settings']->code
						);
						// CUSTOM_ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEW_MODEL_HEADER')]
							= $this->setFileHeader(
							'custom.admin.view.model', $view['settings']->code
						);
						// CUSTOM_ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEW_HTML_HEADER')]
							= $this->setFileHeader(
							'custom.admin.view.html', $view['settings']->code
						);
						// CUSTOM_ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEW_HEADER')]
							= $this->setFileHeader(
							'custom.admin.view', $view['settings']->code
						);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER')]
							= $this->setFileHeader(
							'custom.admin.views.controller',
							$view['settings']->code
						);
						// CUSTOM_ADMIN_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEWS_MODEL_HEADER')]
							= $this->setFileHeader(
							'custom.admin.views.model', $view['settings']->code
						);
						// CUSTOM_ADMIN_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEWS_HTML_HEADER')]
							= $this->setFileHeader(
							'custom.admin.views.html', $view['settings']->code
						);
						// CUSTOM_ADMIN_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('CUSTOM_ADMIN_VIEWS_HEADER')]
							= $this->setFileHeader(
							'custom.admin.views', $view['settings']->code
						);
					}

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onAfterBuildCustomAdminViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onAfterBuildCustomAdminViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$view['settings']->code],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;
				}

				// setup the layouts
				$this->setCustomViewLayouts();
			}

			// ADMIN_HELPER_CLASS_HEADER
			$this->fileContentStatic[Placefix::_h('ADMIN_HELPER_CLASS_HEADER')]
				= $this->setFileHeader(
				'admin.helper', 'admin'
			);

			// ADMIN_COMPONENT_HEADER
			$this->fileContentStatic[Placefix::_h('ADMIN_COMPONENT_HEADER')]
				= $this->setFileHeader(
				'admin.component', 'admin'
			);

			// SITE_HELPER_CLASS_HEADER
			$this->fileContentStatic[Placefix::_h('SITE_HELPER_CLASS_HEADER')]
				= $this->setFileHeader(
				'site.helper', 'site'
			);

			// SITE_COMPONENT_HEADER
			$this->fileContentStatic[Placefix::_h('SITE_COMPONENT_HEADER')]
				= $this->setFileHeader(
				'site.component', 'site'
			);

			// HELPER_EXEL
			$this->fileContentStatic[Placefix::_h('HELPER_EXEL')]
				= $this->setHelperExelMethods();

			// VIEWARRAY
			$this->fileContentStatic[Placefix::_h('VIEWARRAY')]
				= PHP_EOL . implode("," . PHP_EOL, $viewarray);

			// CUSTOM_ADMIN_EDIT_VIEW_ARRAY
			$this->fileContentStatic[Placefix::_h('SITE_EDIT_VIEW_ARRAY')]
				= PHP_EOL . implode("," . PHP_EOL, $site_edit_view_array);

			// MAINMENUS
			$this->fileContentStatic[Placefix::_h('MAINMENUS')]
				= $this->setMainMenus();

			// SUBMENU
			$this->fileContentStatic[Placefix::_h('SUBMENU')]
				= $this->setSubMenus();

			// GET_CRYPT_KEY
			$this->fileContentStatic[Placefix::_h('GET_CRYPT_KEY')]
				= $this->setGetCryptKey();

			// set the license locker
			$this->setLockLicense();

			// CONTRIBUTORS
			$this->fileContentStatic[Placefix::_h('CONTRIBUTORS')]
				= $this->theContributors;

			// INSTALL
			$this->fileContentStatic[Placefix::_h('INSTALL')]
				= $this->setInstall();

			// UNINSTALL
			$this->fileContentStatic[Placefix::_h('UNINSTALL')]
				= $this->setUninstall();

			// UPDATE_VERSION_MYSQL
			$this->setVersionController();

			// only set these if default dashboard it used
			if (!StringHelper::check($this->dynamicDashboard))
			{
				// DASHBOARDVIEW
				$this->fileContentStatic[Placefix::_h('DASHBOARDVIEW')]
					= CFactory::_('Config')->component_code_name;

				// DASHBOARDICONS
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASHBOARDICONS')]
					= $this->setDashboardIcons();

				// DASHBOARDICONACCESS
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASHBOARDICONACCESS')]
					= $this->setDashboardIconAccess();

				// DASH_MODEL_METHODS
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASH_MODEL_METHODS')]
					= $this->setDashboardModelMethods();

				// DASH_GET_CUSTOM_DATA
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASH_GET_CUSTOM_DATA')]
					= $this->setDashboardGetCustomData();

				// DASH_DISPLAY_DATA
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASH_DISPLAY_DATA')]
					= $this->setDashboardDisplayData();

				// DASH_VIEW_HEADER
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASH_VIEW_HEADER')]
					= $this->setFileHeader('dashboard.view', 'dashboard');
				// DASH_VIEW_HTML_HEADER
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASH_VIEW_HTML_HEADER')]
					= $this->setFileHeader('dashboard.view.html', 'dashboard');
				// DASH_MODEL_HEADER
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASH_MODEL_HEADER')]
					= $this->setFileHeader('dashboard.model', 'dashboard');
				// DASH_CONTROLLER_HEADER
				$this->fileContentDynamic[CFactory::_('Config')->component_code_name][Placefix::_h('DASH_CONTROLLER_HEADER')]
					= $this->setFileHeader('dashboard.controller', 'dashboard');
			}
			else
			{
				// DASHBOARDVIEW
				$this->fileContentStatic[Placefix::_h('DASHBOARDVIEW')]
					= $this->dynamicDashboard;
			}

			// add import
			if (isset($this->addEximport) && $this->addEximport)
			{
				// setup import files
				$target = array('admin' => 'import');
				$this->buildDynamique($target, 'import');
				// IMPORT_EXT_METHOD <<<DYNAMIC>>>
				$this->fileContentDynamic['import'][Placefix::_h('IMPORT_EXT_METHOD')]
					= PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update(
						ComponentbuilderHelper::getDynamicScripts('ext'),
						CFactory::_('Placeholder')->active
					);
				// IMPORT_SETDATA_METHOD <<<DYNAMIC>>>
				$this->fileContentDynamic['import'][Placefix::_h('IMPORT_SETDATA_METHOD')]
					= PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update(
						ComponentbuilderHelper::getDynamicScripts('setdata'),
						CFactory::_('Placeholder')->active
					);
				// IMPORT_SAVE_METHOD <<<DYNAMIC>>>
				$this->fileContentDynamic['import'][Placefix::_h('IMPORT_SAVE_METHOD')]
					= PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update(
						ComponentbuilderHelper::getDynamicScripts('save'),
						CFactory::_('Placeholder')->active
					);
			}

			// ensure that the ajax model and controller is set if needed
			if (isset($this->addAjax) && $this->addAjax)
			{
				// setup Ajax files
				$target = array('admin' => 'ajax');
				$this->buildDynamique($target, 'ajax');
				// set the controller
				$this->fileContentDynamic['ajax'][Placefix::_h('REGISTER_AJAX_TASK')]
					= $this->setRegisterAjaxTask('admin');
				$this->fileContentDynamic['ajax'][Placefix::_h('AJAX_INPUT_RETURN')]
					= $this->setAjaxInputReturn('admin');
				// set the model header
				$this->fileContentDynamic['ajax'][Placefix::_h('AJAX_ADMIN_MODEL_HEADER')]
					= $this->setFileHeader('ajax.admin.model', 'ajax');
				// set the module
				$this->fileContentDynamic['ajax'][Placefix::_h('AJAX_MODEL_METHODS')]
					= $this->setAjaxModelMethods('admin');
			}

			// ensure that the site ajax model and controller is set if needed
			if (isset($this->addSiteAjax) && $this->addSiteAjax)
			{
				// setup Ajax files
				$target = array('site' => 'ajax');
				$this->buildDynamique($target, 'ajax');
				// set the controller
				$this->fileContentDynamic['ajax'][Placefix::_h('REGISTER_SITE_AJAX_TASK')]
					= $this->setRegisterAjaxTask('site');
				$this->fileContentDynamic['ajax'][Placefix::_h('AJAX_SITE_INPUT_RETURN')]
					= $this->setAjaxInputReturn('site');
				// set the model header
				$this->fileContentDynamic['ajax'][Placefix::_h('AJAX_SITE_MODEL_HEADER')]
					= $this->setFileHeader('ajax.site.model', 'ajax');
				// set the module
				$this->fileContentDynamic['ajax'][Placefix::_h('AJAX_SITE_MODEL_METHODS')]
					= $this->setAjaxModelMethods('site');
			}

			// build the validation rules
			if (isset($this->validationRules)
				&& ArrayHelper::check($this->validationRules))
			{
				foreach ($this->validationRules as $rule => $_php)
				{
					// setup rule file
					$target = array('admin' => 'a_rule_zi');
					$this->buildDynamique($target, 'rule', $rule);
					// set the JFormRule Name
					$this->fileContentDynamic['a_rule_zi_' . $rule][Placefix::_h('Name')]
						= ucfirst($rule);
					// set the JFormRule PHP
					$this->fileContentDynamic['a_rule_zi_' . $rule][Placefix::_h('VALIDATION_RULE_METHODS')]
						= PHP_EOL . $_php;
				}
			}

			// run the second run if needed
			if (isset($this->secondRunAdmin)
				&& ArrayHelper::check($this->secondRunAdmin))
			{
				// start dynamic build
				foreach ($this->secondRunAdmin as $function => $arrays)
				{
					if (ArrayHelper::check($arrays)
						&& StringHelper::check($function))
					{
						foreach ($arrays as $array)
						{
							$this->{$function}($array);
						}
					}
				}
			}

			// CONFIG_FIELDSETS
			$keepLang   = CFactory::_('Config')->lang_target;
			CFactory::_('Config')->lang_target = 'admin';
			// run field sets for second time
			$this->setConfigFieldsets(2);
			CFactory::_('Config')->lang_target = $keepLang;

			// setup front-views and all needed stuff for the site
			if (isset($this->componentData->site_views)
				&& ArrayHelper::check(
					$this->componentData->site_views
				))
			{
				CFactory::_('Config')->build_target = 'site';
				// start dynamic build
				foreach ($this->componentData->site_views as $view)
				{
					// for list views
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SViews')]
						= $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('sviews')]
						= $view['settings']->code;
					// for single views
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SView')]
						= $view['settings']->Code;
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('sview')]
						= $view['settings']->code;

					// set placeholder
					CFactory::_('Placeholder')->active[Placefix::_h('SView')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_h('sview')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_h('SVIEW')]
						= $view['settings']->CODE;
					CFactory::_('Placeholder')->active[Placefix::_('SView')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_('sview')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_('SVIEW')]
						= $view['settings']->CODE;
					CFactory::_('Placeholder')->active[Placefix::_h('SViews')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_h('sviews')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_h('SVIEWS')]
						= $view['settings']->CODE;
					CFactory::_('Placeholder')->active[Placefix::_('SViews')]
						= $view['settings']->Code;
					CFactory::_('Placeholder')->active[Placefix::_('sviews')]
						= $view['settings']->code;
					CFactory::_('Placeholder')->active[Placefix::_('SVIEWS')]
						= $view['settings']->CODE;

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onBeforeBuildSiteViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onBeforeBuildSiteViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$view['settings']->code],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;

					// set license per view if needed
					$this->setLockLicensePer(
						$view['settings']->code, CFactory::_('Config')->build_target
					);

					// set the site default view
					if (isset($view['default_view'])
						&& $view['default_view'] == 1)
					{
						$this->fileContentStatic[Placefix::_h('SITE_DEFAULT_VIEW')]
							= $view['settings']->code;
					}
					// add site menu
					if (isset($view['menu']) && $view['menu'] == 1)
					{
						// SITE_MENU_XML <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_MENU_XML')]
							= $this->setCustomViewMenu($view);
					}

					// insure the needed route helper is loaded
					$this->fileContentStatic[Placefix::_h('ROUTEHELPER')]
						.= $this->setRouterHelp(
						$view['settings']->code, $view['settings']->code, true
					);
					// build route details
					$this->fileContentStatic[Placefix::_h('ROUTER_PARSE_SWITCH')]
						.= $this->routerParseSwitch(
						$view['settings']->code, $view
					);
					$this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')]
						.= $this->routerBuildViews($view['settings']->code);

					if ($view['settings']->main_get->gettype == 1)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('USER_PERMISSION_CHECK_ACCESS')]
							= $this->setUserPermissionCheckAccess($view, 1);

						// SITE_BEFORE_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_BEFORE_GET_ITEM')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_before_getitem',
							$view['settings']->code, '', null, true
						);

						// SITE_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_GET_ITEM')]
							= $this->setCustomViewGetItem(
							$view['settings']->main_get,
							$view['settings']->code, Indent::_(2)
						);

						// SITE_AFTER_GET_ITEM <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_AFTER_GET_ITEM')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_after_getitem',
							$view['settings']->code, '', null, true
						);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('USER_PERMISSION_CHECK_ACCESS')]
							= $this->setUserPermissionCheckAccess($view, 2);
						// SITE_GET_LIST_QUERY <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_GET_LIST_QUERY')]
							= $this->setCustomViewListQuery(
							$view['settings']->main_get, $view['settings']->code
						);

						// SITE_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_BEFORE_GET_ITEMS')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_before_getitems',
							$view['settings']->code, PHP_EOL, null, true
						);

						// SITE_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_GET_ITEMS')]
							= $this->setCustomViewGetItems(
							$view['settings']->main_get, $view['settings']->code
						);

						// SITE_AFTER_GET_ITEMS <<<DYNAMIC>>>
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_AFTER_GET_ITEMS')]
							= $this->getCustomScriptBuilder(
							CFactory::_('Config')->build_target . '_php_after_getitems',
							$view['settings']->code, PHP_EOL, null, true
						);
					}
					// add to lang array
					CFactory::_('Language')->set(
						'site',
						CFactory::_('Config')->lang_prefix . '_' . $view['settings']->CODE,
						$view['settings']->name
					);
					CFactory::_('Language')->set(
						'site',
						CFactory::_('Config')->lang_prefix . '_' . $view['settings']->CODE
						. '_DESC', $view['settings']->description
					);
					// SITE_CUSTOM_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_CUSTOM_METHODS')]
						= $this->setCustomViewCustomItemMethods(
						$view['settings']->main_get, $view['settings']->code
					);
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_CUSTOM_METHODS')]
						.= $this->setCustomViewCustomMethods(
						$view, $view['settings']->code
					);
					// SITE_DIPLAY_METHOD <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_DIPLAY_METHOD')]
						= $this->setCustomViewDisplayMethod($view);
					// set document details
					$this->setPrepareDocument($view);
					// SITE_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_EXTRA_DIPLAY_METHODS')]
						= $this->setCustomViewExtraDisplayMethods($view);
					// SITE_CODE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_CODE_BODY')]
						= $this->setCustomViewCodeBody($view);
					// SITE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_BODY')]
						= $this->setCustomViewBody($view);

					// setup the templates
					$this->setCustomViewTemplateBody($view);

					// set the site form if needed
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_TOP_FORM')]
						= $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 1
					);
					$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_BOTTOM_FORM')]
						= $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 2
					);

					// set headers based on the main get type
					if ($view['settings']->main_get->gettype == 1)
					{
						// insure the controller headers are added
						if (StringHelper::check(
								$view['settings']->php_controller
							)
							&& $view['settings']->php_controller != '//')
						{
							// SITE_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the model
							$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEW_CONTROLLER_HEADER')]
								= $this->setFileHeader(
								'site.view.controller', $view['settings']->code
							);
						}
						// SITE_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEW_MODEL_HEADER')]
							= $this->setFileHeader(
							'site.view.model', $view['settings']->code
						);
						// SITE_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEW_HTML_HEADER')]
							= $this->setFileHeader(
							'site.view.html', $view['settings']->code
						);
						// SITE_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEW_HEADER')]
							= $this->setFileHeader(
							'site.view', $view['settings']->code
						);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// insure the controller headers are added
						if (StringHelper::check(
								$view['settings']->php_controller
							)
							&& $view['settings']->php_controller != '//')
						{
							// SITE_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the model
							$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEW_CONTROLLER_HEADER')]
								= $this->setFileHeader(
								'site.views.controller', $view['settings']->code
							);
						}
						// SITE_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEWS_MODEL_HEADER')]
							= $this->setFileHeader(
							'site.views.model', $view['settings']->code
						);
						// SITE_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEWS_HTML_HEADER')]
							= $this->setFileHeader(
							'site.views.html', $view['settings']->code
						);
						// SITE_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
						$this->fileContentDynamic[$view['settings']->code][Placefix::_h('SITE_VIEWS_HEADER')]
							= $this->setFileHeader(
							'site.views', $view['settings']->code
						);
					}

					// for plugin event TODO change event api signatures
					$this->placeholders = CFactory::_('Placeholder')->active;
					// Trigger Event: jcb_ce_onAfterBuildSiteViewContent
					CFactory::_J('Event')->trigger(
						'jcb_ce_onAfterBuildSiteViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$this->fileContentStatic,
							&$this->fileContentDynamic[$view['settings']->code],
							&$this->placeholders, &$this->hhh)
					);
					// for plugin event TODO change event api signatures
					CFactory::_('Placeholder')->active = $this->placeholders;
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
				CFactory::_('Config')->build_target = 'site';
				// if no default site view was set, the redirect to root
				if (!isset(
					$this->fileContentStatic[Placefix::_h('SITE_DEFAULT_VIEW')]
				))
				{
					$this->fileContentStatic[Placefix::_h('SITE_DEFAULT_VIEW')]
						= '';
				}
				// set site custom script to helper class
				// SITE_CUSTOM_HELPER_SCRIPT
				$this->fileContentStatic[Placefix::_h('SITE_CUSTOM_HELPER_SCRIPT')]
					= CFactory::_('Placeholder')->update(
					$this->customScriptBuilder['component_php_helper_site'],
					CFactory::_('Placeholder')->active
				);
				// SITE_GLOBAL_EVENT_HELPER
				if (!isset($this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT')]))
				{
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT')] = '';
				}
				if (!isset($this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]))
				{
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')] = '';
				}
				// now load the data for the global event if needed
				if ($this->componentData->add_site_event == 1)
				{
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT')]
						.= PHP_EOL . PHP_EOL . '// Trigger the Global Site Event';
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT')]
						.= PHP_EOL . $this->fileContentStatic[Placefix::_h('Component')]
						. 'Helper::globalEvent($document);';
					// SITE_GLOBAL_EVENT_HELPER
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]
						.= PHP_EOL . PHP_EOL . Indent::_(1) . '/**';
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]
						.= PHP_EOL . Indent::_(1)
						. '*	The Global Site Event Method.';
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]
						.= PHP_EOL . Indent::_(1) . '**/';
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]
						.= PHP_EOL . Indent::_(1)
						. 'public static function globalEvent($document)';
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]
						.= PHP_EOL . Indent::_(1) . '{';
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]
						.= PHP_EOL . CFactory::_('Placeholder')->update(
							$this->customScriptBuilder['component_php_site_event'],
							CFactory::_('Placeholder')->active
						);
					$this->fileContentStatic[Placefix::_h('SITE_GLOBAL_EVENT_HELPER')]
						.= PHP_EOL . Indent::_(1) . '}';
				}
			}

			// PREINSTALLSCRIPT
			$this->fileContentStatic[Placefix::_h('PREINSTALLSCRIPT')]
				= $this->getCustomScriptBuilder(
				'php_preflight', 'install', PHP_EOL, null, true
			);

			// PREUPDATESCRIPT
			$this->fileContentStatic[Placefix::_h('PREUPDATESCRIPT')]
				= $this->getCustomScriptBuilder(
				'php_preflight', 'update', PHP_EOL, null, true
			);

			// POSTINSTALLSCRIPT
			$this->fileContentStatic[Placefix::_h('POSTINSTALLSCRIPT')]
				= $this->setPostInstallScript();

			// POSTUPDATESCRIPT
			$this->fileContentStatic[Placefix::_h('POSTUPDATESCRIPT')]
				= $this->setPostUpdateScript();

			// UNINSTALLSCRIPT
			$this->fileContentStatic[Placefix::_h('UNINSTALLSCRIPT')]
				= $this->setUninstallScript();

			// MOVEFOLDERSSCRIPT
			$this->fileContentStatic[Placefix::_h('MOVEFOLDERSSCRIPT')]
				= $this->setMoveFolderScript();

			// MOVEFOLDERSMETHOD
			$this->fileContentStatic[Placefix::_h('MOVEFOLDERSMETHOD')]
				= $this->setMoveFolderMethod();

			// HELPER_UIKIT
			$this->fileContentStatic[Placefix::_h('HELPER_UIKIT')]
				= $this->setUikitHelperMethods();

			// CONFIG_FIELDSETS
			$this->fileContentStatic[Placefix::_h('CONFIG_FIELDSETS')]
				= implode(PHP_EOL, $this->configFieldSets);

			// check if this has been set
			if (!isset(
					$this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')]
				)
				|| !StringHelper::check(
					$this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')]
				))
			{
				$this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')]
					= 0;
			}
			else
			{
				$this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')]
					= '(' . $this->fileContentStatic[Placefix::_h('ROUTER_BUILD_VIEWS')] . ')';
			}

			// README
			if ($this->componentData->addreadme)
			{
				$this->fileContentStatic[Placefix::_h('README')]
					= $this->componentData->readme;
			}
			// remove all the power placeholders
			$this->fileContentStatic[Placefix::_h('ADMIN_POWER_HELPER')] = '';
			$this->fileContentStatic[Placefix::_h('SITE_POWER_HELPER')] = '';
			$this->fileContentStatic[Placefix::_h('CUSTOM_POWER_AUTOLOADER')] = '';
			// infuse powers data if set
			if (ArrayHelper::check(CFactory::_('Power')->active))
			{
				// start the autoloader
				$autoloader = array();
				foreach (CFactory::_('Power')->active as $power)
				{
					if (ObjectHelper::check($power))
					{
						// Trigger Event: jcb_ce_onBeforeInfusePowerData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onBeforeInfusePowerData',
							array(&$this->componentContext, &$power, &$this)
						);
						// POWERCODE
						$this->fileContentDynamic[$power->key][Placefix::_h('POWERCODE')]
							= $this->getPowerCode($power);
						// build the autoloader
						$autoloader[implode('.', $power->_namespace_prefix)] = $power->_namespace_prefix;
						// Trigger Event: jcb_ce_onAfterInfusePowerData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onAfterInfusePowerData',
							array(&$this->componentContext, &$power, &$this)
						);
					}
				}
				// now set the power autoloader
				$this->setPowersAutoloader($autoloader, (!$this->removeSiteFolder || !$this->removeSiteEditFolder));
			}
			// tweak system to set stuff to the module domain
			$_backup_target     = CFactory::_('Config')->build_target;
			$_backup_lang       = CFactory::_('Config')->lang_target;
			$_backup_langPrefix = CFactory::_('Config')->lang_prefix;
			// infuse module data if set
			if (ArrayHelper::check($this->joomlaModules))
			{
				foreach ($this->joomlaModules as $module)
				{
					if (ObjectHelper::check($module))
					{
						// Trigger Event: jcb_ce_onBeforeInfuseModuleData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onBeforeInfuseModuleData',
							array(&$this->componentContext, &$module, &$this)
						);
						CFactory::_('Config')->build_target = $module->key;
						CFactory::_('Config')->lang_target = $module->key;
						$this->langPrefix = $module->lang_prefix;
						CFactory::_('Config')->set('lang_prefix', $module->lang_prefix);
						// MODCODE
						$this->fileContentDynamic[$module->key][Placefix::_h('MODCODE')]
							= $this->getModCode($module);
						// DYNAMICGET
						$this->fileContentDynamic[$module->key][Placefix::_h('DYNAMICGETS')]
							= $this->setCustomViewCustomMethods(
							$module, $module->key
						);
						// HELPERCODE
						if ($module->add_class_helper >= 1)
						{
							$this->fileContentDynamic[$module->key][Placefix::_h('HELPERCODE')]
								= $this->getModHelperCode($module);
						}
						// MODDEFAULT
						$this->fileContentDynamic[$module->key][Placefix::_h('MODDEFAULT')]
							= $this->getModDefault($module, $module->key);
						// only add install script if needed
						if ($module->add_install_script)
						{
							// INSTALLCLASS
							$this->fileContentDynamic[$module->key][Placefix::_h('INSTALLCLASS')]
								= CFactory::_J('Extension.InstallScript')->get($module);
						}
						// FIELDSET
						if (isset($module->form_files)
							&& ArrayHelper::check(
								$module->form_files
							))
						{
							foreach ($module->form_files as $file => $files)
							{
								foreach ($files as $field_name => $fieldsets)
								{
									foreach ($fieldsets as $fieldset => $fields)
									{
										// FIELDSET_ . $file.$field_name.$fieldset
										$this->fileContentDynamic[$module->key][Placefix::_h('FIELDSET_'
											. $file . $field_name . $fieldset)]
											= $this->getExtensionFieldsetXML(
											$module, $fields
										);
									}
								}
							}
						}
						// MAINXML
						$this->fileContentDynamic[$module->key][Placefix::_h('MAINXML')]
							= $this->getModuleMainXML($module);
						// Trigger Event: jcb_ce_onAfterInfuseModuleData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onAfterInfuseModuleData',
							array(&$this->componentContext, &$module, &$this)
						);
					}
				}
			}
			// infuse plugin data if set
			if (ArrayHelper::check($this->joomlaPlugins))
			{
				foreach ($this->joomlaPlugins as $plugin)
				{
					if (ObjectHelper::check($plugin))
					{
						// Trigger Event: jcb_ce_onBeforeInfusePluginData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onBeforeInfusePluginData',
							array(&$this->componentContext, &$plugin, &$this)
						);
						CFactory::_('Config')->build_target = $plugin->key;
						CFactory::_('Config')->lang_target = $plugin->key;
						$this->langPrefix = $plugin->lang_prefix;
						CFactory::_('Config')->set('lang_prefix', $plugin->lang_prefix);
						// MAINCLASS
						$this->fileContentDynamic[$plugin->key][Placefix::_h('MAINCLASS')]
							= $this->getPluginMainClass($plugin);
						// only add install script if needed
						if ($plugin->add_install_script)
						{
							// INSTALLCLASS
							$this->fileContentDynamic[$plugin->key][Placefix::_h('INSTALLCLASS')]
								= CFactory::_J('Extension.InstallScript')->get($plugin);
						}
						// FIELDSET
						if (isset($plugin->form_files)
							&& ArrayHelper::check(
								$plugin->form_files
							))
						{
							foreach ($plugin->form_files as $file => $files)
							{
								foreach ($files as $field_name => $fieldsets)
								{
									foreach ($fieldsets as $fieldset => $fields)
									{
										// FIELDSET_ . $file.$field_name.$fieldset
										$this->fileContentDynamic[$plugin->key][Placefix::_h(
											'FIELDSET_' . $file . $field_name . $fieldset)]
											= $this->getExtensionFieldsetXML(
											$plugin, $fields
										);
									}
								}
							}
						}
						// MAINXML
						$this->fileContentDynamic[$plugin->key][Placefix::_h('MAINXML')]
							= $this->getPluginMainXML($plugin);
						// Trigger Event: jcb_ce_onAfterInfusePluginData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onAfterInfusePluginData',
							array(&$this->componentContext, &$plugin, &$this)
						);
					}
				}
			}
			// rest globals
			CFactory::_('Config')->build_target = $_backup_target;
			CFactory::_('Config')->lang_target = $_backup_lang;
			$this->langPrefix = $_backup_langPrefix;
			CFactory::_('Config')->set('lang_prefix', $_backup_langPrefix);
			// for plugin event TODO change event api signatures
			$this->placeholders = CFactory::_('Placeholder')->active;
			// Trigger Event: jcb_ce_onAfterBuildFilesContent
			CFactory::_J('Event')->trigger(
				'jcb_ce_onAfterBuildFilesContent',
				array(&$this->componentContext, &$this->componentData,
					&$this->fileContentStatic, &$this->fileContentDynamic,
					&$this->placeholders, &$this->hhh)
			);
			// for plugin event TODO change event api signatures
			CFactory::_('Placeholder')->active = $this->placeholders;

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
		CFactory::_('Placeholder')->clearType('view');

		// VIEW <<<DYNAMIC>>>
		if (isset($view->name_single) && $view->name_single != 'null')
		{
			// set main keys
			$nameSingleCode              = $view->name_single_code;
			$name_single_uppercase       = StringHelper::safe(
				$view->name_single, 'U'
			);
			$name_single_first_uppercase = StringHelper::safe(
				$view->name_single, 'F'
			);

			// set some place holder for the views
			CFactory::_('Placeholder')->active[Placefix::_h('view')]
				= $nameSingleCode;
			CFactory::_('Placeholder')->active[Placefix::_h('View')]
				= $name_single_first_uppercase;
			CFactory::_('Placeholder')->active[Placefix::_h('VIEW')]
				= $name_single_uppercase;
			CFactory::_('Placeholder')->active[Placefix::_('view')]
				= $nameSingleCode;
			CFactory::_('Placeholder')->active[Placefix::_('View')]
				= $name_single_first_uppercase;
			CFactory::_('Placeholder')->active[Placefix::_('VIEW')]
				= $name_single_uppercase;
		}

		// VIEWS <<<DYNAMIC>>>
		if (isset($view->name_list) && $view->name_list != 'null')
		{
			$nameListCode              = $view->name_list_code;
			$name_list_uppercase       = StringHelper::safe(
				$view->name_list, 'U'
			);
			$name_list_first_uppercase = StringHelper::safe(
				$view->name_list, 'F'
			);

			// set some place holder for the views
			CFactory::_('Placeholder')->active[Placefix::_h('views')]
				= $nameListCode;
			CFactory::_('Placeholder')->active[Placefix::_h('Views')]
				= $name_list_first_uppercase;
			CFactory::_('Placeholder')->active[Placefix::_h('VIEWS')]
				= $name_list_uppercase;
			CFactory::_('Placeholder')->active[Placefix::_('views')]
				= $nameListCode;
			CFactory::_('Placeholder')->active[Placefix::_('Views')]
				= $name_list_first_uppercase;
			CFactory::_('Placeholder')->active[Placefix::_('VIEWS')]
				= $name_list_uppercase;
		}

		// view <<<DYNAMIC>>>
		if (isset($nameSingleCode))
		{
			$this->fileContentDynamic[$nameSingleCode][Placefix::_h('view')]
				= $nameSingleCode;
			$this->fileContentDynamic[$nameSingleCode][Placefix::_h('VIEW')]
				= $name_single_uppercase;
			$this->fileContentDynamic[$nameSingleCode][Placefix::_h('View')]
				= $name_single_first_uppercase;

			if (isset($nameListCode))
			{
				$this->fileContentDynamic[$nameListCode][Placefix::_h('view')]
					= $nameSingleCode;
				$this->fileContentDynamic[$nameListCode][Placefix::_h('VIEW')]
					= $name_single_uppercase;
				$this->fileContentDynamic[$nameListCode][Placefix::_h('View')]
					= $name_single_first_uppercase;
			}
		}

		// views <<<DYNAMIC>>>
		if (isset($nameListCode))
		{
			$this->fileContentDynamic[$nameListCode][Placefix::_h('views')]
				= $nameListCode;
			$this->fileContentDynamic[$nameListCode][Placefix::_h('VIEWS')]
				= $name_list_uppercase;
			$this->fileContentDynamic[$nameListCode][Placefix::_h('Views')]
				= $name_list_first_uppercase;

			if (isset($nameSingleCode))
			{
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('views')]
					= $nameListCode;
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('VIEWS')]
					= $name_list_uppercase;
				$this->fileContentDynamic[$nameSingleCode][Placefix::_h('Views')]
					= $name_list_first_uppercase;
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
		$values         = array();
		$mainLangLoader = array();
		// check the admin lang is set
		if ($this->setLangAdmin())
		{
			$values[]                = array_values(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['admin']
			);
			$mainLangLoader['admin'] = count(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['admin']
			);
		}
		// check the admin system lang is set
		if ($this->setLangAdminSys())
		{
			$values[]                   = array_values(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['adminsys']
			);
			$mainLangLoader['adminsys'] = count(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['adminsys']
			);
		}
		// check the site lang is set
		if ((!$this->removeSiteFolder || !$this->removeSiteEditFolder)
			&& $this->setLangSite())
		{
			$values[]               = array_values(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['site']
			);
			$mainLangLoader['site'] = count(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['site']
			);
		}
		// check the site system lang is set
		if ((!$this->removeSiteFolder || !$this->removeSiteEditFolder)
			&& $this->setLangSiteSys())
		{
			$values[]                  = array_values(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['sitesys']
			);
			$mainLangLoader['sitesys'] = count(
				$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')]['sitesys']
			);
		}
		$values = array_unique(ArrayHelper::merge($values));
		// get the other lang strings if there is any
		$this->multiLangString = $this->getMultiLangStrings($values);
		// update insert the current lang in to DB
		$this->setLangPlaceholders($values, CFactory::_('Config')->component_id);
		// remove old unused language strings
		$this->purgeLanuageStrings($values, CFactory::_('Config')->component_id);
		// path to INI file
		$getPAth = $this->templatePath . '/en-GB.com_admin.ini';
		// Trigger Event: jcb_ce_onBeforeBuildAllLangFiles
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeBuildAllLangFiles',
			array(&$this->componentContext, &$this->languages['components'],
				&$this->langTag)
		);
		// for plugin event TODO change event api signatures
		CFactory::_('Config')->lang_tag = $this->langTag;
		// now we insert the values into the files
		if (ArrayHelper::check($this->languages['components']))
		{
			// rest xml array
			$langXML = array();
			foreach ($this->languages['components'] as $tag => $areas)
			{
				// trim the tag
				$tag = trim($tag);
				foreach ($areas as $area => $languageStrings)
				{
					// set naming convention
					$p = 'admin';
					$t = '';
					if (strpos($area, 'site') !== false)
					{
						if ($this->removeSiteFolder
							&& $this->removeSiteEditFolder)
						{
							continue;
						}
						$p = 'site';
					}
					if (strpos($area, 'sys') !== false)
					{
						$t = '.sys';
					}
					// build the file name
					$file_name = $tag . '.com_' . CFactory::_('Config')->component_code_name . $t
						. '.ini';
					// check if language should be added
					if ($this->shouldLanguageBeAdded(
						$tag, $languageStrings, $mainLangLoader[$area],
						$file_name
					))
					{
						// build the path to place the lang file
						$path = $this->componentPath . '/' . $p . '/language/'
							. $tag . '/';
						if (!Folder::exists($path))
						{
							Folder::create($path);
							// count the folder created
							$this->folderCount++;
						}
						// move the file to its place
						File::copy($getPAth, $path . $file_name);
						// count the file created
						$this->fileCount++;
						// add content to it
						$lang = array_map(
							function ($langstring, $placeholder) {
								return $placeholder . '="' . $langstring . '"';
							}, array_values($languageStrings),
							array_keys($languageStrings)
						);
						// add to language file
						$this->writeFile(
							$path . $file_name, implode(PHP_EOL, $lang)
						);
						// set the line counter
						$this->lineCount = $this->lineCount + count(
								(array) $lang
							);
						unset($lang);
						// build xml strings
						if (!isset($langXML[$p]))
						{
							$langXML[$p] = array();
						}
						$langXML[$p][] = '<language tag="' . $tag
							. '">language/'
							. $tag . '/' . $file_name . '</language>';
					}
				}
			}
			// load the lang xml
			if (ArrayHelper::check($langXML))
			{
				$replace = array();
				if (isset($langXML['admin'])
					&& ArrayHelper::check($langXML['admin']))
				{
					$replace[Placefix::_h('ADMIN_LANGUAGES')]
						= implode(PHP_EOL . Indent::_(3), $langXML['admin']);
				}
				if ((!$this->removeSiteFolder || !$this->removeSiteEditFolder)
					&& isset($langXML['site'])
					&& ArrayHelper::check($langXML['site']))
				{
					$replace[Placefix::_h('SITE_LANGUAGES')]
						= implode(PHP_EOL . Indent::_(2), $langXML['site']);
				}
				// build xml path
				$xmlPath = $this->componentPath . '/' . CFactory::_('Config')->component_code_name
					. '.xml';
				// get the content in xml
				$componentXML = FileHelper::getContent(
					$xmlPath
				);
				// update the xml content
				$componentXML = CFactory::_('Placeholder')->update($componentXML, $replace);
				// store the values back to xml
				$this->writeFile($xmlPath, $componentXML);
			}
		}
	}

}
