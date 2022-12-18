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

	/**
	 * Switch to remove site folder
	 *
	 * @var     bool
	 * @deprecated 3.3 Use CFactory::_('Config')->remove_site_folder;
	 */
	public $removeSiteFolder = false;

	/**
	 * Switch to remove site edit folder
	 *
	 * @var     bool
	 * @deprecated 3.3 Use CFactory::_('Config')->remove_site_edit_folder;
	 */
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
			$placeholders = CFactory::_('Placeholder')->active;
			$fileContentStatic = CFactory::_('Content')->active;
			$fileContentDynamic = CFactory::_('Content')->_active;
			// Trigger Event: jcb_ce_onBeforeBuildFilesContent
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeBuildFilesContent',
				array(&$this->componentContext, &$this->componentData,
					&$fileContentStatic, &$fileContentDynamic,
					&$placeholders, &$this->hhh)
			);
			unset($fileContentStatic);
			unset($fileContentDynamic);
			unset($placeholders);

			// COMPONENT
			CFactory::_('Content')->set('COMPONENT', CFactory::_('Placeholder')->get('COMPONENT'));

			// Component
			CFactory::_('Content')->set('Component', CFactory::_('Placeholder')->get('Component'));

			// component
			CFactory::_('Content')->set('component', CFactory::_('Placeholder')->get('component'));

			// COMPANYNAME
			CFactory::_('Content')->set('COMPANYNAME', trim(
				JFilterOutput::cleanText($this->componentData->companyname)
			));

			// CREATIONDATE
			CFactory::_('Content')->set('CREATIONDATE',
				JFactory::getDate($this->componentData->created)->format(
				'jS F, Y'
			));
			CFactory::_('Content')->set('GLOBALCREATIONDATE',
				CFactory::_('Content')->get('CREATIONDATE'));

			// BUILDDATE
			CFactory::_('Content')->set('BUILDDATE', JFactory::getDate()->format('jS F, Y'));
			CFactory::_('Content')->set('GLOBALBUILDDATE',
				CFactory::_('Content')->get('BUILDDATE'));

			// AUTHOR
			CFactory::_('Content')->set('AUTHOR', trim(
				JFilterOutput::cleanText($this->componentData->author)
			));

			// AUTHOREMAIL
			CFactory::_('Content')->set('AUTHOREMAIL', trim($this->componentData->email));

			// AUTHORWEBSITE
			CFactory::_('Content')->set('AUTHORWEBSITE', trim($this->componentData->website));

			// COPYRIGHT
			CFactory::_('Content')->set('COPYRIGHT', trim($this->componentData->copyright));

			// LICENSE
			CFactory::_('Content')->set('LICENSE', trim($this->componentData->license));

			// VERSION
			CFactory::_('Content')->set('VERSION', trim($this->componentData->component_version));
			// set the actual global version
			CFactory::_('Content')->set('ACTUALVERSION', CFactory::_('Content')->get('VERSION'));

			// do some Tweaks to the version based on selected options
			if (strpos(CFactory::_('Content')->get('VERSION'), '.') !== false)
			{
				$versionArray = explode(
					'.', CFactory::_('Content')->get('VERSION')
				);
			}
			// load only first two values
			if (isset($versionArray)
				&& ArrayHelper::check(
					$versionArray
				) && $this->componentData->mvc_versiondate == 2)
			{
				CFactory::_('Content')->set('VERSION', $versionArray[0] . '.' . $versionArray[1] . '.x');
			}
			// load only the first value
			elseif (isset($versionArray)
				&& ArrayHelper::check(
					$versionArray
				) && $this->componentData->mvc_versiondate == 3)
			{
				CFactory::_('Content')->set('VERSION', $versionArray[0] . '.x.x');
			}
			unset($versionArray);

			// set the global version in case			
			CFactory::_('Content')->set('GLOBALVERSION', CFactory::_('Content')->get('VERSION'));

			// set the joomla target xml version
			CFactory::_('Content')->set('XMLVERSION', $this->joomlaVersions[CFactory::_('Config')->joomla_version]['xml_version']);

			// Component_name
			CFactory::_('Content')->set('Component_name', JFilterOutput::cleanText($this->componentData->name));

			// SHORT_DISCRIPTION
			CFactory::_('Content')->set('SHORT_DESCRIPTION', trim(
				JFilterOutput::cleanText(
					$this->componentData->short_description
				)
			));

			// DESCRIPTION
			CFactory::_('Content')->set('DESCRIPTION', trim($this->componentData->description));

			// COMP_IMAGE_TYPE
			CFactory::_('Content')->set('COMP_IMAGE_TYPE', $this->setComponentImageType($this->componentData->image));

			// ACCESS_SECTIONS
			CFactory::_('Content')->set('ACCESS_SECTIONS', $this->setAccessSections());

			// CONFIG_FIELDSETS
			$keepLang   = CFactory::_('Config')->lang_target;
			CFactory::_('Config')->lang_target = 'admin';

			// start loading the category tree scripts
			CFactory::_('Content')->set('CATEGORY_CLASS_TREES', '');
			// run the field sets for first time
			$this->setConfigFieldsets(1);
			CFactory::_('Config')->lang_target = $keepLang;

			// ADMINJS
			CFactory::_('Content')->set('ADMINJS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_js']
			));
			// SITEJS
			CFactory::_('Content')->set('SITEJS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_js']
			));

			// ADMINCSS
			CFactory::_('Content')->set('ADMINCSS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_css_admin']
			));
			// SITECSS
			CFactory::_('Content')->set('SITECSS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_css_site']
			));

			// CUSTOM_HELPER_SCRIPT
			CFactory::_('Content')->set('CUSTOM_HELPER_SCRIPT',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_php_helper_admin']
			));

			// BOTH_CUSTOM_HELPER_SCRIPT
			CFactory::_('Content')->set('BOTH_CUSTOM_HELPER_SCRIPT',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_php_helper_both']
			));

			// ADMIN_GLOBAL_EVENT_HELPER
			if (!CFactory::_('Content')->exist('ADMIN_GLOBAL_EVENT'))
			{
				CFactory::_('Content')->set('ADMIN_GLOBAL_EVENT', '');
			}
			if (!CFactory::_('Content')->exist('ADMIN_GLOBAL_EVENT_HELPER'))
			{
				CFactory::_('Content')->set('ADMIN_GLOBAL_EVENT_HELPER', '');
			}
			// now load the data for the global event if needed
			if ($this->componentData->add_admin_event == 1)
			{
				// ADMIN_GLOBAL_EVENT
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT', PHP_EOL . PHP_EOL . '// Trigger the Global Admin Event');
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT',
					PHP_EOL . CFactory::_('Content')->get('Component')
					. 'Helper::globalEvent($document);');
				// ADMIN_GLOBAL_EVENT_HELPER
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT_HELPER', PHP_EOL . PHP_EOL . Indent::_(1) . '/**');
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . Indent::_(1)
					. '*	The Global Admin Event Method.');
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT_HELPER', PHP_EOL . Indent::_(1) . '**/');
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . Indent::_(1)
					. 'public static function globalEvent($document)');
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT_HELPER', PHP_EOL . Indent::_(1) . '{');
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . CFactory::_('Placeholder')->update_(
						CFactory::_('Customcode.Dispenser')->hub['component_php_admin_event']
					));
				CFactory::_('Content')->add('ADMIN_GLOBAL_EVENT_HELPER', PHP_EOL . Indent::_(1) . '}');
			}

			// now load the readme file if needed
			if ($this->componentData->addreadme == 1)
			{
				CFactory::_('Content')->add('EXSTRA_ADMIN_FILES',
					PHP_EOL . Indent::_(3)
					. "<filename>README.txt</filename>");
			}

			// HELPER_CREATEUSER
			CFactory::_('Content')->add('HELPER_CREATEUSER',
				$this->setCreateUserHelperMethod(
				$this->componentData->creatuserhelper
			));

			// HELP
			CFactory::_('Content')->set('HELP', $this->noHelp());
			// HELP_SITE
			CFactory::_('Content')->set('HELP_SITE', $this->noHelp());

			// build route parse switch
			CFactory::_('Content')->set('ROUTER_PARSE_SWITCH', '');
			// build route views
			CFactory::_('Content')->set('ROUTER_BUILD_VIEWS', '');

			// add the helper emailer if set
			CFactory::_('Content')->set('HELPER_EMAIL', $this->addEmailHelper());

			// load the global placeholders
			foreach (CFactory::_('Component.Placeholder')->get() as $globalPlaceholder =>
				$gloabalValue
			)
			{
				CFactory::_('Content')->set($globalPlaceholder, $gloabalValue);
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
					CFactory::_('Config')->remove_site_edit_folder = false;
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
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onBeforeBuildAdminEditViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildAdminEditViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$fileContentStatic,
							&$fileContentDynamic[$nameSingleCode],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);

					// FIELDSETS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'FIELDSETS', $this->setFieldSet(
						$view, CFactory::_('Config')->component_code_name,
						$nameSingleCode,
						$nameListCode
					));

					// ACCESSCONTROL <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'ACCESSCONTROL', $this->setFieldSetAccessControl(
						$nameSingleCode
					));

					// LINKEDVIEWITEMS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'LINKEDVIEWITEMS', '');

					// ADDTOOLBAR <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'ADDTOOLBAR', $this->setAddToolBar($view));

					// set the script for this view
					$this->buildTheViewScript($view);

					// VIEW_SCRIPT
					CFactory::_('Content')->set_($nameSingleCode, 'VIEW_SCRIPT', $this->setViewScript(
						$nameSingleCode, 'fileScript'
					));

					// EDITBODYSCRIPT
					CFactory::_('Content')->set_($nameSingleCode, 'EDITBODYSCRIPT', $this->setViewScript(
						$nameSingleCode, 'footerScript'
					));

					// AJAXTOKE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'AJAXTOKE', $this->setAjaxToke(
						$nameSingleCode
					));

					// DOCUMENT_CUSTOM_PHP <<<DYNAMIC>>>
					if ($phpDocument = CFactory::_('Customcode.Dispenser')->get(
						'php_document', $nameSingleCode,
						PHP_EOL, null, true,
						false
					))
					{
						CFactory::_('Content')->set_($nameSingleCode, 'DOCUMENT_CUSTOM_PHP', str_replace(
							'$document->', '$this->document->', $phpDocument
						));
						// clear some memory
						unset($phpDocument);
					}
					else
					{
						CFactory::_('Content')->set_($nameSingleCode, 'DOCUMENT_CUSTOM_PHP', '');
					}
					// LINKEDVIEWTABLESCRIPTS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'LINKEDVIEWTABLESCRIPTS', '');

					// VALIDATEFIX <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'VALIDATIONFIX', $this->setValidationFix(
						$nameSingleCode,
						CFactory::_('Content')->get('Component')
					));

					// EDITBODY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'EDITBODY', $this->setEditBody($view));

					// EDITBODYFADEIN <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'EDITBODYFADEIN', $this->setFadeInEfect($view));

					// JTABLECONSTRUCTOR <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'JTABLECONSTRUCTOR', $this->setJtableConstructor(
						$nameSingleCode
					));

					// JTABLEALIASCATEGORY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'JTABLEALIASCATEGORY', $this->setJtableAliasCategory(
						$nameSingleCode
					));

					// METHOD_GET_ITEM <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'METHOD_GET_ITEM', $this->setMethodGetItem(
						$nameSingleCode
					));

					// LINKEDVIEWGLOBAL <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'LINKEDVIEWGLOBAL', '');

					// LINKEDVIEWMETHODS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'LINKEDVIEWMETHODS', '');

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_BEFORE_DELETE', CFactory::_('Customcode.Dispenser')->get(
						'php_before_delete',
						$nameSingleCode, PHP_EOL
					));

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_AFTER_DELETE', CFactory::_('Customcode.Dispenser')->get(
						'php_after_delete', $nameSingleCode,
						PHP_EOL . PHP_EOL
					));

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_BEFORE_PUBLISH', CFactory::_('Customcode.Dispenser')->get(
						'php_before_publish',
						$nameSingleCode, PHP_EOL
					));

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_AFTER_PUBLISH', CFactory::_('Customcode.Dispenser')->get(
						'php_after_publish',
						$nameSingleCode, PHP_EOL . PHP_EOL
					));

					// CHECKBOX_SAVE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'CHECKBOX_SAVE', $this->setCheckboxSave(
						$nameSingleCode
					));

					// METHOD_ITEM_SAVE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'METHOD_ITEM_SAVE', $this->setMethodItemSave(
						$nameSingleCode
					));

					// POSTSAVEHOOK <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'POSTSAVEHOOK', CFactory::_('Customcode.Dispenser')->get(
						'php_postsavehook', $nameSingleCode,
						PHP_EOL, null,
						true, PHP_EOL . Indent::_(2) . "return;",
						PHP_EOL . PHP_EOL . Indent::_(2) . "return;"
					));

					// VIEWCSS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameSingleCode, 'VIEWCSS', CFactory::_('Customcode.Dispenser')->get(
						'css_view', $nameSingleCode, '',
						null, true
					));

					// add css to front end
					if (isset($view['edit_create_site_view'])
						&& is_numeric($view['edit_create_site_view'])
						&& $view['edit_create_site_view'] > 0)
					{
						CFactory::_('Content')->set_($nameSingleCode, 'SITE_VIEWCSS', CFactory::_('Content')->get_($nameSingleCode,'VIEWCSS'));
						// check if we should add a create menu
						if ($view['edit_create_site_view'] == 2)
						{
							// SITE_MENU_XML <<<DYNAMIC>>>
							CFactory::_('Content')->set_($nameSingleCode, 'SITE_MENU_XML', $this->setAdminViewMenu(
								$nameSingleCode, $view
							));
						}
						// SITE_ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						CFactory::_('Content')->set_($nameSingleCode, 'SITE_ADMIN_VIEW_CONTROLLER_HEADER', $this->setFileHeader(
							'site.admin.view.controller',
							$nameSingleCode
						));
						// SITE_ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Content')->set_($nameSingleCode, 'SITE_ADMIN_VIEW_MODEL_HEADER', $this->setFileHeader(
							'site.admin.view.model',
							$nameSingleCode
						));
						// SITE_ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($nameSingleCode, 'SITE_ADMIN_VIEW_HTML_HEADER', $this->setFileHeader(
							'site.admin.view.html',
							$nameSingleCode
						));
						// SITE_ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($nameSingleCode, 'SITE_ADMIN_VIEW_HEADER', $this->setFileHeader(
							'site.admin.view',
							$nameSingleCode
						));
					}

					// TABLAYOUTFIELDSARRAY <<<DYNAMIC>>> add the tab layout fields array to the model
					CFactory::_('Content')->set_($nameSingleCode, 'TABLAYOUTFIELDSARRAY', $this->getTabLayoutFieldsArray(
						$nameSingleCode
					));

					// ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					CFactory::_('Content')->set_($nameSingleCode, 'ADMIN_VIEW_CONTROLLER_HEADER', $this->setFileHeader(
						'admin.view.controller',
						$nameSingleCode
					));
					// ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					CFactory::_('Content')->set_($nameSingleCode, 'ADMIN_VIEW_MODEL_HEADER', $this->setFileHeader(
						'admin.view.model', $nameSingleCode
					));
					// ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
					CFactory::_('Content')->set_($nameSingleCode, 'ADMIN_VIEW_HTML_HEADER', $this->setFileHeader(
						'admin.view.html', $nameSingleCode
					));
					// ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
					CFactory::_('Content')->set_($nameSingleCode, 'ADMIN_VIEW_HEADER', $this->setFileHeader(
						'admin.view', $nameSingleCode
					));

					// for plugin event TODO change event api signatures
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onAfterBuildAdminEditViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildAdminEditViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$fileContentStatic,
							&$fileContentDynamic[$nameSingleCode],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);
				}
				// set the views names
				if (isset($view['settings']->name_list)
					&& $view['settings']->name_list != 'null')
				{
					CFactory::_('Config')->lang_target = 'admin';

					// ICOMOON <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'ICOMOON', $view['icomoon']);

					// for plugin event TODO change event api signatures
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onBeforeBuildAdminListViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildAdminListViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$fileContentStatic,
							&$fileContentDynamic[$nameListCode],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);

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
						CFactory::_('Content')->set_($nameListCode, 'AUTOCHECKIN', $this->setAutoCheckin(
							$nameSingleCode,
							CFactory::_('Config')->component_code_name
						));
						// CHECKINCALL <<<DYNAMIC>>>
						CFactory::_('Content')->set_($nameListCode, 'CHECKINCALL', $this->setCheckinCall());
					}
					else
					{
						// AUTOCHECKIN <<<DYNAMIC>>>
						CFactory::_('Content')->set_($nameListCode, 'AUTOCHECKIN', '');
						// CHECKINCALL <<<DYNAMIC>>>
						CFactory::_('Content')->set_($nameListCode, 'CHECKINCALL', '');
					}
					// admin list file contnet
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_JAVASCRIPT_FILE', $this->setViewScript(
						$nameListCode, 'list_fileScript'
					));
					// ADMIN_CUSTOM_BUTTONS_LIST
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_CUSTOM_BUTTONS_LIST', $this->setCustomButtons($view, 3, Indent::_(1)));
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_CUSTOM_FUNCTION_ONLY_BUTTONS_LIST', $this->setFunctionOnlyButtons(
						$nameListCode
					));

					// GET_ITEMS_METHOD_STRING_FIX <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'GET_ITEMS_METHOD_STRING_FIX', $this->setGetItemsMethodStringFix(
						$nameSingleCode,
						$nameListCode,
						CFactory::_('Content')->get('Component')
					));

					// GET_ITEMS_METHOD_AFTER_ALL <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'GET_ITEMS_METHOD_AFTER_ALL', CFactory::_('Customcode.Dispenser')->get(
						'php_getitems_after_all',
						$nameSingleCode, PHP_EOL
					));

					// SELECTIONTRANSLATIONFIX <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'SELECTIONTRANSLATIONFIX', $this->setSelectionTranslationFix(
						$nameListCode,
						CFactory::_('Content')->get('Component')
					));

					// SELECTIONTRANSLATIONFIXFUNC <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'SELECTIONTRANSLATIONFIXFUNC', $this->setSelectionTranslationFixFunc(
						$nameListCode,
						CFactory::_('Content')->get('Component')
					));

					// FILTER_FIELDS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'FILTER_FIELDS', $this->setFilterFieldsArray(
						$nameSingleCode,
						$nameListCode
					));

					// STOREDID <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'STOREDID', $this->setStoredId(
						$nameSingleCode, $nameListCode
					));

					// POPULATESTATE <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'POPULATESTATE', $this->setPopulateState(
						$nameSingleCode, $nameListCode
					));

					// SORTFIELDS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'SORTFIELDS', $this->setSortFields(
						$nameListCode
					));

					// CATEGORY_VIEWS
					CFactory::_('Content')->add('ROUTER_CATEGORY_VIEWS',
						$this->setRouterCategoryViews(
						$nameSingleCode,
						$nameListCode
					));

					// FILTERFIELDDISPLAYHELPER <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'FILTERFIELDDISPLAYHELPER', $this->setFilterFieldSidebarDisplayHelper(
						$nameSingleCode,
						$nameListCode
					));

					// BATCHDISPLAYHELPER <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'BATCHDISPLAYHELPER', $this->setBatchDisplayHelper(
						$nameSingleCode,
						$nameListCode
					));

					// FILTERFUNCTIONS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'FILTERFUNCTIONS', $this->setFilterFieldHelper(
						$nameSingleCode,
						$nameListCode
					));

					// FIELDFILTERSETS <<<DYNAMIC>>>
					CFactory::_('Content')->set_('filter_' . $nameListCode,'FIELDFILTERSETS',
						$this->setFieldFilterSet(
						$nameSingleCode,
						$nameListCode
					));

					// FIELDLISTSETS <<<DYNAMIC>>>
					CFactory::_('Content')->set_('filter_' . $nameListCode, 'FIELDLISTSETS',
						$this->setFieldFilterListSet(
						$nameSingleCode,
						$nameListCode
					));

					// LISTQUERY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'LISTQUERY', $this->setListQuery(
						$nameSingleCode,
						$nameListCode
					));

					// MODELEXPORTMETHOD <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'MODELEXPORTMETHOD', $this->setGetItemsModelMethod(
						$nameSingleCode,
						$nameListCode
					));

					// MODELEXIMPORTMETHOD <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'CONTROLLEREXIMPORTMETHOD', $this->setControllerEximportMethod(
						$nameSingleCode,
						$nameListCode
					));

					// EXPORTBUTTON <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'EXPORTBUTTON', $this->setExportButton(
						$nameSingleCode,
						$nameListCode
					));

					// IMPORTBUTTON <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'IMPORTBUTTON', $this->setImportButton(
						$nameSingleCode,
						$nameListCode
					));

					// VIEWS_DEFAULT_BODY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'VIEWS_DEFAULT_BODY', $this->setDefaultViewsBody(
						$nameSingleCode,
						$nameListCode
					));

					// LISTHEAD <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'LISTHEAD', $this->setListHead(
						$nameSingleCode,
						$nameListCode
					));

					// LISTBODY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'LISTBODY', $this->setListBody(
						$nameSingleCode,
						$nameListCode
					));

					// LISTCOLNR <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'LISTCOLNR', $this->setListColnr(
						$nameListCode
					));

					// JVIEWLISTCANDO <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'JVIEWLISTCANDO', $this->setJviewListCanDo(
						$nameSingleCode,
						$nameListCode
					));

					// VIEWSCSS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'VIEWSCSS', CFactory::_('Customcode.Dispenser')->get(
						'css_views', $nameSingleCode, '',
						null, true
					));

					// ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_DIPLAY_METHOD', $this->setAdminViewDisplayMethod(
						$nameListCode
					));

					// VIEWS_FOOTER_SCRIPT <<<DYNAMIC>>>
					$scriptNote = PHP_EOL . '//' . Line::_(__Line__, __Class__)
						. ' ' . $nameListCode
						. ' footer script';
					if (($footerScript = CFactory::_('Customcode.Dispenser')->get(
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
						CFactory::_('Content')->set_($nameListCode, 'VIEWS_FOOTER_SCRIPT', PHP_EOL . '<script type="text/javascript">'
							. $footerScript . "</script>");
						// clear some memory
						unset($footerScript);
					}
					else
					{
						CFactory::_('Content')->set_($nameListCode, 'VIEWS_FOOTER_SCRIPT', '');
					}

					// ADMIN_VIEWS_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_VIEWS_CONTROLLER_HEADER', $this->setFileHeader(
						'admin.views.controller',
						$nameListCode
					));
					// ADMIN_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_VIEWS_MODEL_HEADER', $this->setFileHeader(
						'admin.views.model', $nameListCode
					));
					// ADMIN_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the views
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_VIEWS_HTML_HEADER', $this->setFileHeader(
						'admin.views.html', $nameListCode
					));
					// ADMIN_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the views
					CFactory::_('Content')->set_($nameListCode, 'ADMIN_VIEWS_HEADER', $this->setFileHeader(
						'admin.views', $nameListCode
					));

					// for plugin event TODO change event api signatures
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onAfterBuildAdminListViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildAdminListViewContent',
						array(&$this->componentContext, &$view,
							&$nameSingleCode,
							&$nameListCode,
							&$fileContentStatic,
							&$fileContentDynamic[$nameListCode],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);
				}

				// set u fields used in batch
				CFactory::_('Content')->set_($nameSingleCode, 'UNIQUEFIELDS', $this->setUniqueFields(
					$nameSingleCode
				));

				// TITLEALIASFIX <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'TITLEALIASFIX', $this->setAliasTitleFix(
					$nameSingleCode
				));

				// GENERATENEWTITLE <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'GENERATENEWTITLE', $this->setGenerateNewTitle(
					$nameSingleCode
				));

				// GENERATENEWALIAS <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'GENERATENEWALIAS', $this->setGenerateNewAlias(
					$nameSingleCode
				));

				// MODEL_BATCH_COPY <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'MODEL_BATCH_COPY', $this->setBatchCopy($nameSingleCode));

				// MODEL_BATCH_MOVE <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'MODEL_BATCH_MOVE', $this->setBatchMove($nameSingleCode));

				// BATCH_ONCLICK_CANCEL_SCRIPT <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameListCode, 'BATCH_ONCLICK_CANCEL_SCRIPT', ''); // TODO <-- must still be build

				// JCONTROLLERFORM_ALLOWADD <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JCONTROLLERFORM_ALLOWADD', $this->setJcontrollerAllowAdd(
					$nameSingleCode,
					$nameListCode
				));

				// JCONTROLLERFORM_BEFORECANCEL <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JCONTROLLERFORM_BEFORECANCEL', CFactory::_('Customcode.Dispenser')->get(
					'php_before_cancel', $nameSingleCode,
					PHP_EOL, null, false,
					''
				));

				// JCONTROLLERFORM_AFTERCANCEL <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JCONTROLLERFORM_AFTERCANCEL', CFactory::_('Customcode.Dispenser')->get(
					'php_after_cancel', $nameSingleCode,
					PHP_EOL, null, false,
					''
				));

				// JCONTROLLERFORM_ALLOWEDIT <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JCONTROLLERFORM_ALLOWEDIT', $this->setJcontrollerAllowEdit(
					$nameSingleCode,
					$nameListCode
				));

				// JMODELADMIN_GETFORM <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_GETFORM', $this->setJmodelAdminGetForm(
					$nameSingleCode,
					$nameListCode
				));

				// JMODELADMIN_ALLOWEDIT <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_ALLOWEDIT', $this->setJmodelAdminAllowEdit(
					$nameSingleCode,
					$nameListCode
				));

				// JMODELADMIN_CANDELETE <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_CANDELETE', $this->setJmodelAdminCanDelete(
					$nameSingleCode,
					$nameListCode
				));

				// JMODELADMIN_CANEDITSTATE <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameSingleCode, 'JMODELADMIN_CANEDITSTATE', $this->setJmodelAdminCanEditState(
					$nameSingleCode,
					$nameListCode
				));

				// set custom admin view Toolbare buttons
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS  <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameListCode, 'CUSTOM_ADMIN_DYNAMIC_BUTTONS', $this->setCustomAdminDynamicButton(
					$nameListCode
				));
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER  <<<DYNAMIC>>>
				CFactory::_('Content')->set_($nameListCode, 'CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER', $this->setCustomAdminDynamicButtonController(
					$nameListCode
				));

				// set helper router
				CFactory::_('Content')->add('ROUTEHELPER',
					$this->setRouterHelp(
					$nameSingleCode,
					$nameListCode
				));

				if (isset($view['edit_create_site_view'])
					&& is_numeric(
						$view['edit_create_site_view']
					)
					&& $view['edit_create_site_view'] > 0)
				{
					// add needed router stuff for front edit views
					CFactory::_('Content')->add('ROUTER_PARSE_SWITCH',
						$this->routerParseSwitch(
						$nameSingleCode, null, false
					));
					CFactory::_('Content')->add('ROUTER_BUILD_VIEWS',
						$this->routerBuildViews(
						$nameSingleCode
					));
				}

				// ACCESS_SECTIONS
				CFactory::_('Content')->add('ACCESS_SECTIONS',
					$this->setAccessSectionsCategory(
					$nameSingleCode,
					$nameListCode
				));
				// set the Joomla Fields ACCESS section if needed
				if (isset($view['joomla_fields'])
					&& $view['joomla_fields'] == 1)
				{
					CFactory::_('Content')->add('ACCESS_SECTIONS', $this->setAccessSectionsJoomlaFields());
				}

				// for plugin event TODO change event api signatures
				$placeholders = CFactory::_('Placeholder')->active;
				$fileContentStatic = CFactory::_('Content')->active;
				$fileContentDynamic = CFactory::_('Content')->_active;
				// Trigger Event: jcb_ce_onAfterBuildAdminViewContent
				CFactory::_('Event')->trigger(
					'jcb_ce_onAfterBuildAdminViewContent',
					array(&$this->componentContext, &$view,
						&$nameSingleCode,
						&$nameListCode,
						&$fileContentStatic,
						&$fileContentDynamic, &$placeholders,
						&$this->hhh)
				);
				unset($fileContentStatic);
				unset($fileContentDynamic);
				unset($placeholders);
			}

			// all fields stored in database
			CFactory::_('Content')->set('ARRAY_ALL_SEARCH_FIELDS', CFactory::_('Registry')->varExport('all_search_fields', 1));

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
					CFactory::_('Content')->set_($view['settings']->code, 'SView', $view['settings']->Code);
					CFactory::_('Content')->set_($view['settings']->code, 'sview', $view['settings']->code);
					CFactory::_('Content')->set_($view['settings']->code, 'SVIEW', $view['settings']->CODE);
					// for list views
					CFactory::_('Content')->set_($view['settings']->code, 'SViews', $view['settings']->Code);
					CFactory::_('Content')->set_($view['settings']->code, 'sviews', $view['settings']->code);
					CFactory::_('Content')->set_($view['settings']->code, 'SVIEWS', $view['settings']->CODE);
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
					CFactory::_('Content')->set_($view['settings']->code, 'ICOMOON', $view['icomoon']);

					// set placeholders
					CFactory::_('Placeholder')->set('SView', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sview', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEW', $view['settings']->CODE);

					CFactory::_('Placeholder')->set('SViews', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sviews', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEWS', $view['settings']->CODE);

					// for plugin event TODO change event api signatures
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onBeforeBuildCustomAdminViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildCustomAdminViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$fileContentStatic,
							&$fileContentDynamic[$view['settings']->code],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);

					// set license per view if needed
					$this->setLockLicensePer(
						$view['settings']->code, CFactory::_('Config')->build_target
					);

					// check if this custom admin view is the default view
					if ($this->dynamicDashboardType === 'custom_admin_views'
						&& $this->dynamicDashboard === $view['settings']->code)
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'HIDEMAINMENU', '');
					}
					else
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'HIDEMAINMENU', PHP_EOL . Indent::_(2) . '//' . Line::_(
								__LINE__,__CLASS__
							) . " hide the main menu"
							. PHP_EOL . Indent::_(2)
							. "\$this->app->input->set('hidemainmenu', true);");
					}

					if ($view['settings']->main_get->gettype == 1)
					{
						// CUSTOM_ADMIN_BEFORE_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_BEFORE_GET_ITEM', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_before_getitem',
							$view['settings']->code, '', null, true
						));

						// CUSTOM_ADMIN_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_GET_ITEM', $this->setCustomViewGetItem(
							$view['settings']->main_get,
							$view['settings']->code, Indent::_(2)
						));

						// CUSTOM_ADMIN_AFTER_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_AFTER_GET_ITEM', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_after_getitem',
							$view['settings']->code, '', null, true
						));
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// CUSTOM_ADMIN_GET_LIST_QUERY <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_GET_LIST_QUERY', $this->setCustomViewListQuery(
							$view['settings']->main_get, $view['settings']->code
						));

						// CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_getlistquery',
							$view['settings']->code, PHP_EOL, null, true
						));

						// CUSTOM_ADMIN_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_BEFORE_GET_ITEMS', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_before_getitems',
							$view['settings']->code, PHP_EOL, null, true
						));

						// CUSTOM_ADMIN_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_GET_ITEMS', $this->setCustomViewGetItems(
							$view['settings']->main_get, $view['settings']->code
						));

						// CUSTOM_ADMIN_AFTER_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_AFTER_GET_ITEMS', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_after_getitems',
							$view['settings']->code, PHP_EOL, null, true
						));
					}

					// CUSTOM_ADMIN_CUSTOM_METHODS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_CUSTOM_METHODS', $this->setCustomViewCustomItemMethods(
						$view['settings']->main_get, $view['settings']->code
					));
					CFactory::_('Content')->add_($view['settings']->code, 'CUSTOM_ADMIN_CUSTOM_METHODS',
						$this->setCustomViewCustomMethods(
							$view, $view['settings']->code
						)
					);
					// CUSTOM_ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_DIPLAY_METHOD', $this->setCustomViewDisplayMethod($view));
					// set document details
					$this->setPrepareDocument($view);
					// CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS', $this->setCustomViewExtraDisplayMethods($view));
					// CUSTOM_ADMIN_CODE_BODY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_CODE_BODY', $this->setCustomViewCodeBody($view));
					// CUSTOM_ADMIN_BODY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_BODY', $this->setCustomViewBody($view));
					// CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT', $this->setCustomViewSubmitButtonScript($view));

					// setup the templates
					$this->setCustomViewTemplateBody($view);

					// set the site form if needed
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_TOP_FORM', $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 1
					));
					CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_BOTTOM_FORM', $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 2
					));

					// set headers based on the main get type
					if ($view['settings']->main_get->gettype == 1)
					{
						// CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER', $this->setFileHeader(
							'custom.admin.view.controller',
							$view['settings']->code
						));
						// CUSTOM_ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEW_MODEL_HEADER', $this->setFileHeader(
							'custom.admin.view.model', $view['settings']->code
						));
						// CUSTOM_ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEW_HTML_HEADER', $this->setFileHeader(
							'custom.admin.view.html', $view['settings']->code
						));
						// CUSTOM_ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEW_HEADER', $this->setFileHeader(
							'custom.admin.view', $view['settings']->code
						));
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER', $this->setFileHeader(
							'custom.admin.views.controller',
							$view['settings']->code
						));
						// CUSTOM_ADMIN_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEWS_MODEL_HEADER', $this->setFileHeader(
							'custom.admin.views.model', $view['settings']->code
						));
						// CUSTOM_ADMIN_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEWS_HTML_HEADER', $this->setFileHeader(
							'custom.admin.views.html', $view['settings']->code
						));
						// CUSTOM_ADMIN_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'CUSTOM_ADMIN_VIEWS_HEADER', $this->setFileHeader(
							'custom.admin.views', $view['settings']->code
						));
					}

					// for plugin event TODO change event api signatures
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onAfterBuildCustomAdminViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildCustomAdminViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$fileContentStatic,
							&$fileContentDynamic[$view['settings']->code],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);
				}

				// setup the layouts
				$this->setCustomViewLayouts();
			}

			// ADMIN_HELPER_CLASS_HEADER
			CFactory::_('Content')->set('ADMIN_HELPER_CLASS_HEADER',
				$this->setFileHeader(
				'admin.helper', 'admin'
			));

			// ADMIN_COMPONENT_HEADER
			CFactory::_('Content')->set('ADMIN_COMPONENT_HEADER',
				$this->setFileHeader(
				'admin.component', 'admin'
			));

			// SITE_HELPER_CLASS_HEADER
			CFactory::_('Content')->set('SITE_HELPER_CLASS_HEADER',
				$this->setFileHeader(
				'site.helper', 'site'
			));

			// SITE_COMPONENT_HEADER
			CFactory::_('Content')->set('SITE_COMPONENT_HEADER',
				$this->setFileHeader(
				'site.component', 'site'
			));

			// HELPER_EXEL
			CFactory::_('Content')->set('HELPER_EXEL', $this->setHelperExelMethods());

			// VIEWARRAY
			CFactory::_('Content')->set('VIEWARRAY', PHP_EOL . implode("," . PHP_EOL, $viewarray));

			// CUSTOM_ADMIN_EDIT_VIEW_ARRAY
			CFactory::_('Content')->set('SITE_EDIT_VIEW_ARRAY', PHP_EOL . implode("," . PHP_EOL, $site_edit_view_array));

			// MAINMENUS
			CFactory::_('Content')->set('MAINMENUS', $this->setMainMenus());

			// SUBMENU
			CFactory::_('Content')->set('SUBMENU', $this->setSubMenus());

			// GET_CRYPT_KEY
			CFactory::_('Content')->set('GET_CRYPT_KEY', $this->setGetCryptKey());

			// set the license locker
			$this->setLockLicense();

			// CONTRIBUTORS
			CFactory::_('Content')->set('CONTRIBUTORS', $this->theContributors);

			// INSTALL
			CFactory::_('Content')->set('INSTALL', $this->setInstall());

			// UNINSTALL
			CFactory::_('Content')->set('UNINSTALL', $this->setUninstall());

			// UPDATE_VERSION_MYSQL
			$this->setVersionController();

			// only set these if default dashboard it used
			if (!StringHelper::check($this->dynamicDashboard))
			{
				// DASHBOARDVIEW
				CFactory::_('Content')->set('DASHBOARDVIEW', CFactory::_('Config')->component_code_name);

				// DASHBOARDICONS
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASHBOARDICONS', $this->setDashboardIcons());

				// DASHBOARDICONACCESS
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASHBOARDICONACCESS', $this->setDashboardIconAccess());

				// DASH_MODEL_METHODS
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASH_MODEL_METHODS', $this->setDashboardModelMethods());

				// DASH_GET_CUSTOM_DATA
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASH_GET_CUSTOM_DATA', $this->setDashboardGetCustomData());

				// DASH_DISPLAY_DATA
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASH_DISPLAY_DATA', $this->setDashboardDisplayData());

				// DASH_VIEW_HEADER
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASH_VIEW_HEADER', $this->setFileHeader('dashboard.view', 'dashboard'));
				// DASH_VIEW_HTML_HEADER
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASH_VIEW_HTML_HEADER', $this->setFileHeader('dashboard.view.html', 'dashboard'));
				// DASH_MODEL_HEADER
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASH_MODEL_HEADER', $this->setFileHeader('dashboard.model', 'dashboard'));
				// DASH_CONTROLLER_HEADER
				CFactory::_('Content')->set_(CFactory::_('Config')->component_code_name, 'DASH_CONTROLLER_HEADER', $this->setFileHeader('dashboard.controller', 'dashboard'));
			}
			else
			{
				// DASHBOARDVIEW
				CFactory::_('Content')->set('DASHBOARDVIEW', $this->dynamicDashboard);
			}

			// add import
			if (isset($this->addEximport) && $this->addEximport)
			{
				// setup import files
				$target = array('admin' => 'import');
				$this->buildDynamique($target, 'import');
				// IMPORT_EXT_METHOD <<<DYNAMIC>>>
				CFactory::_('Content')->set_('import', 'IMPORT_EXT_METHOD', PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
						ComponentbuilderHelper::getDynamicScripts('ext')
					));
				// IMPORT_SETDATA_METHOD <<<DYNAMIC>>>
				CFactory::_('Content')->set_('import', 'IMPORT_SETDATA_METHOD', PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
						ComponentbuilderHelper::getDynamicScripts('setdata')
					));
				// IMPORT_SAVE_METHOD <<<DYNAMIC>>>
				CFactory::_('Content')->set_('import', 'IMPORT_SAVE_METHOD', PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
						ComponentbuilderHelper::getDynamicScripts('save')
					));
			}

			// ensure that the ajax model and controller is set if needed
			if (isset($this->addAjax) && $this->addAjax)
			{
				// setup Ajax files
				$target = array('admin' => 'ajax');
				$this->buildDynamique($target, 'ajax');
				// set the controller
				CFactory::_('Content')->set_('ajax', 'REGISTER_AJAX_TASK', $this->setRegisterAjaxTask('admin'));
				CFactory::_('Content')->set_('ajax', 'AJAX_INPUT_RETURN', $this->setAjaxInputReturn('admin'));
				// set the model header
				CFactory::_('Content')->set_('ajax', 'AJAX_ADMIN_MODEL_HEADER', $this->setFileHeader('ajax.admin.model', 'ajax'));
				// set the module
				CFactory::_('Content')->set_('ajax', 'AJAX_MODEL_METHODS', $this->setAjaxModelMethods('admin'));
			}

			// ensure that the site ajax model and controller is set if needed
			if (isset($this->addSiteAjax) && $this->addSiteAjax)
			{
				// setup Ajax files
				$target = array('site' => 'ajax');
				$this->buildDynamique($target, 'ajax');
				// set the controller
				CFactory::_('Content')->set_('ajax', 'REGISTER_SITE_AJAX_TASK', $this->setRegisterAjaxTask('site'));
				CFactory::_('Content')->set_('ajax', 'AJAX_SITE_INPUT_RETURN', $this->setAjaxInputReturn('site'));
				// set the model header
				CFactory::_('Content')->set_('ajax', 'AJAX_SITE_MODEL_HEADER', $this->setFileHeader('ajax.site.model', 'ajax'));
				// set the module
				CFactory::_('Content')->set_('ajax', 'AJAX_SITE_MODEL_METHODS', $this->setAjaxModelMethods('site'));
			}

			// build the validation rules
			if (($validationRules = CFactory::_('Registry')->_('validation.rules')) !== null)
			{
				foreach ($validationRules as $rule => $_php)
				{
					// setup rule file
					$target = array('admin' => 'a_rule_zi');
					$this->buildDynamique($target, 'rule', $rule);
					// set the JFormRule Name
					CFactory::_('Content')->set_('a_rule_zi_' . $rule, 'Name', ucfirst($rule));
					// set the JFormRule PHP
					CFactory::_('Content')->set_('a_rule_zi_' . $rule, 'VALIDATION_RULE_METHODS', PHP_EOL . $_php);
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
					CFactory::_('Content')->set_($view['settings']->code, 'SViews', $view['settings']->Code);
					CFactory::_('Content')->set_($view['settings']->code, 'sviews', $view['settings']->code);
					// for single views
					CFactory::_('Content')->set_($view['settings']->code, 'SView', $view['settings']->Code);
					CFactory::_('Content')->set_($view['settings']->code, 'sview', $view['settings']->code);

					// set placeholders
					CFactory::_('Placeholder')->set('SView', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sview', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEW', $view['settings']->CODE);

					CFactory::_('Placeholder')->set('SViews', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sviews', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEWS', $view['settings']->CODE);

					// for plugin event TODO change event api signatures
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onBeforeBuildSiteViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildSiteViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$fileContentStatic,
							&$fileContentDynamic[$view['settings']->code],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);

					// set license per view if needed
					$this->setLockLicensePer(
						$view['settings']->code, CFactory::_('Config')->build_target
					);

					// set the site default view
					if (isset($view['default_view'])
						&& $view['default_view'] == 1)
					{
						CFactory::_('Content')->set('SITE_DEFAULT_VIEW', $view['settings']->code);
					}
					// add site menu
					if (isset($view['menu']) && $view['menu'] == 1)
					{
						// SITE_MENU_XML <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_MENU_XML', $this->setCustomViewMenu($view));
					}

					// insure the needed route helper is loaded
					CFactory::_('Content')->add('ROUTEHELPER',
						$this->setRouterHelp(
						$view['settings']->code, $view['settings']->code, true
					));
					// build route details
					CFactory::_('Content')->add('ROUTER_PARSE_SWITCH',
						$this->routerParseSwitch(
						$view['settings']->code, $view
					));
					CFactory::_('Content')->add('ROUTER_BUILD_VIEWS', $this->routerBuildViews($view['settings']->code));

					if ($view['settings']->main_get->gettype == 1)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'USER_PERMISSION_CHECK_ACCESS', $this->setUserPermissionCheckAccess($view, 1));

						// SITE_BEFORE_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_BEFORE_GET_ITEM', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_before_getitem',
							$view['settings']->code, '', null, true
						));

						// SITE_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_GET_ITEM', $this->setCustomViewGetItem(
							$view['settings']->main_get,
							$view['settings']->code, Indent::_(2)
						));

						// SITE_AFTER_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_AFTER_GET_ITEM', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_after_getitem',
							$view['settings']->code, '', null, true
						));
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'USER_PERMISSION_CHECK_ACCESS', $this->setUserPermissionCheckAccess($view, 2));
						// SITE_GET_LIST_QUERY <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_GET_LIST_QUERY', $this->setCustomViewListQuery(
							$view['settings']->main_get, $view['settings']->code
						));

						// SITE_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_BEFORE_GET_ITEMS', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_before_getitems',
							$view['settings']->code, PHP_EOL, null, true
						));

						// SITE_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_GET_ITEMS', $this->setCustomViewGetItems(
							$view['settings']->main_get, $view['settings']->code
						));

						// SITE_AFTER_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_AFTER_GET_ITEMS', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_after_getitems',
							$view['settings']->code, PHP_EOL, null, true
						));
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
					CFactory::_('Content')->set_($view['settings']->code, 'SITE_CUSTOM_METHODS', $this->setCustomViewCustomItemMethods(
						$view['settings']->main_get, $view['settings']->code
					));
					CFactory::_('Content')->add_($view['settings']->code, 'SITE_CUSTOM_METHODS',
						$this->setCustomViewCustomMethods(
							$view, $view['settings']->code
						)
					);
					// SITE_DIPLAY_METHOD <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'SITE_DIPLAY_METHOD', $this->setCustomViewDisplayMethod($view));
					// set document details
					$this->setPrepareDocument($view);
					// SITE_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'SITE_EXTRA_DIPLAY_METHODS', $this->setCustomViewExtraDisplayMethods($view));
					// SITE_CODE_BODY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'SITE_CODE_BODY', $this->setCustomViewCodeBody($view));
					// SITE_BODY <<<DYNAMIC>>>
					CFactory::_('Content')->set_($view['settings']->code, 'SITE_BODY', $this->setCustomViewBody($view));

					// setup the templates
					$this->setCustomViewTemplateBody($view);

					// set the site form if needed
					CFactory::_('Content')->set_($view['settings']->code, 'SITE_TOP_FORM', $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 1
					));
					CFactory::_('Content')->set_($view['settings']->code, 'SITE_BOTTOM_FORM', $this->setCustomViewForm(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 2
					));

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
							CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEW_CONTROLLER_HEADER', $this->setFileHeader(
								'site.view.controller', $view['settings']->code
							));
						}
						// SITE_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEW_MODEL_HEADER', $this->setFileHeader(
							'site.view.model', $view['settings']->code
						));
						// SITE_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEW_HTML_HEADER', $this->setFileHeader(
							'site.view.html', $view['settings']->code
						));
						// SITE_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEW_HEADER', $this->setFileHeader(
							'site.view', $view['settings']->code
						));
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
							CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEW_CONTROLLER_HEADER', $this->setFileHeader(
								'site.views.controller', $view['settings']->code
							));
						}
						// SITE_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEWS_MODEL_HEADER', $this->setFileHeader(
							'site.views.model', $view['settings']->code
						));
						// SITE_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEWS_HTML_HEADER', $this->setFileHeader(
							'site.views.html', $view['settings']->code
						));
						// SITE_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Content')->set_($view['settings']->code, 'SITE_VIEWS_HEADER', $this->setFileHeader(
							'site.views', $view['settings']->code
						));
					}

					// for plugin event TODO change event api signatures
					$placeholders = CFactory::_('Placeholder')->active;
					$fileContentStatic = CFactory::_('Content')->active;
					$fileContentDynamic = CFactory::_('Content')->_active;
					// Trigger Event: jcb_ce_onAfterBuildSiteViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildSiteViewContent',
						array(&$this->componentContext, &$view,
							&$view['settings']->code,
							&$fileContentStatic,
							&$fileContentDynamic[$view['settings']->code],
							&$placeholders, &$this->hhh)
					);
					unset($fileContentStatic);
					unset($fileContentDynamic);
					unset($placeholders);
				}

				// setup the layouts
				$this->setCustomViewLayouts();
			}
			else
			{
				// clear all site folder since none is needed
				CFactory::_('Config')->remove_site_folder = true;
			}
			// load the site statics
			if (!CFactory::_('Config')->remove_site_folder || !CFactory::_('Config')->remove_site_edit_folder)
			{
				CFactory::_('Config')->build_target = 'site';
				// if no default site view was set, the redirect to root
				if (!CFactory::_('Content')->exist('SITE_DEFAULT_VIEW'))
				{
					CFactory::_('Content')->set('SITE_DEFAULT_VIEW', '');
				}
				// set site custom script to helper class
				// SITE_CUSTOM_HELPER_SCRIPT
				CFactory::_('Content')->set('SITE_CUSTOM_HELPER_SCRIPT',
					CFactory::_('Placeholder')->update_(
					CFactory::_('Customcode.Dispenser')->hub['component_php_helper_site']
				));
				// SITE_GLOBAL_EVENT_HELPER
				if (!CFactory::_('Content')->exist('SITE_GLOBAL_EVENT'))
				{
					CFactory::_('Content')->set('SITE_GLOBAL_EVENT', '');
				}
				if (!CFactory::_('Content')->exist('SITE_GLOBAL_EVENT_HELPER'))
				{
					CFactory::_('Content')->set('SITE_GLOBAL_EVENT_HELPER', '');
				}
				// now load the data for the global event if needed
				if ($this->componentData->add_site_event == 1)
				{
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT', PHP_EOL . PHP_EOL . '// Trigger the Global Site Event');
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT',
						PHP_EOL . CFactory::_('Content')->get('Component')
						. 'Helper::globalEvent($document);');
					// SITE_GLOBAL_EVENT_HELPER
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT_HELPER', PHP_EOL . PHP_EOL . Indent::_(1) . '/**');
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . Indent::_(1)
						. '*	The Global Site Event Method.');
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT_HELPER', PHP_EOL . Indent::_(1) . '**/');
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . Indent::_(1)
						. 'public static function globalEvent($document)');
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT_HELPER', PHP_EOL . Indent::_(1) . '{');
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . CFactory::_('Placeholder')->update_(
							CFactory::_('Customcode.Dispenser')->hub['component_php_site_event']
						));
					CFactory::_('Content')->add('SITE_GLOBAL_EVENT_HELPER', PHP_EOL . Indent::_(1) . '}');
				}
			}

			// PREINSTALLSCRIPT
			CFactory::_('Content')->add('PREINSTALLSCRIPT',
				CFactory::_('Customcode.Dispenser')->get(
				'php_preflight', 'install', PHP_EOL, null, true
			));

			// PREUPDATESCRIPT
			CFactory::_('Content')->add('PREUPDATESCRIPT',
				CFactory::_('Customcode.Dispenser')->get(
				'php_preflight', 'update', PHP_EOL, null, true
			));

			// POSTINSTALLSCRIPT
			CFactory::_('Content')->add('POSTINSTALLSCRIPT', $this->setPostInstallScript());

			// POSTUPDATESCRIPT
			CFactory::_('Content')->add('POSTUPDATESCRIPT', $this->setPostUpdateScript());

			// UNINSTALLSCRIPT
			CFactory::_('Content')->add('UNINSTALLSCRIPT', $this->setUninstallScript());

			// MOVEFOLDERSSCRIPT
			CFactory::_('Content')->set('MOVEFOLDERSSCRIPT', $this->setMoveFolderScript());

			// MOVEFOLDERSMETHOD
			CFactory::_('Content')->set('MOVEFOLDERSMETHOD', $this->setMoveFolderMethod());

			// HELPER_UIKIT
			CFactory::_('Content')->set('HELPER_UIKIT', $this->setUikitHelperMethods());

			// CONFIG_FIELDSETS
			CFactory::_('Content')->set('CONFIG_FIELDSETS', implode(PHP_EOL, $this->configFieldSets));

			// check if this has been set
			if (!CFactory::_('Content')->exist('ROUTER_BUILD_VIEWS')
				|| !StringHelper::check(
					CFactory::_('Content')->get('ROUTER_BUILD_VIEWS')
				))
			{
				CFactory::_('Content')->set('ROUTER_BUILD_VIEWS', 0);
			}
			else
			{
				CFactory::_('Content')->set('ROUTER_BUILD_VIEWS', '(' . CFactory::_('Content')->get('ROUTER_BUILD_VIEWS') . ')');
			}

			// README
			if ($this->componentData->addreadme)
			{
				CFactory::_('Content')->set('README', $this->componentData->readme);
			}

			// Infuse POWERS
			CFactory::_('Power.Infusion')->set();

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
						CFactory::_('Event')->trigger(
							'jcb_ce_onBeforeInfuseModuleData',
							array(&$this->componentContext, &$module, &$this)
						);
						CFactory::_('Config')->build_target = $module->key;
						CFactory::_('Config')->lang_target = $module->key;
						$this->langPrefix = $module->lang_prefix;
						CFactory::_('Config')->set('lang_prefix', $module->lang_prefix);
						// MODCODE
						CFactory::_('Content')->set_($module->key, 'MODCODE', $this->getModCode($module));
						// DYNAMICGET
						CFactory::_('Content')->set_($module->key, 'DYNAMICGETS', $this->setCustomViewCustomMethods(
							$module, $module->key
						));
						// HELPERCODE
						if ($module->add_class_helper >= 1)
						{
							CFactory::_('Content')->set_($module->key, 'HELPERCODE', $this->getModHelperCode($module));
						}
						// MODDEFAULT
						CFactory::_('Content')->set_($module->key, 'MODDEFAULT', $this->getModDefault($module, $module->key));
						// only add install script if needed
						if ($module->add_install_script)
						{
							// INSTALLCLASS
							CFactory::_('Content')->set_($module->key, 'INSTALLCLASS', CFactory::_('Extension.InstallScript')->get($module));
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
										CFactory::_('Content')->set_($module->key,
											'FIELDSET_' . $file . $field_name . $fieldset,
											$this->getExtensionFieldsetXML(
												$module, $fields
											)
										);
									}
								}
							}
						}
						// MAINXML
						CFactory::_('Content')->set_($module->key, 'MAINXML', $this->getModuleMainXML($module));
						// Trigger Event: jcb_ce_onAfterInfuseModuleData
						CFactory::_('Event')->trigger(
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
						CFactory::_('Event')->trigger(
							'jcb_ce_onBeforeInfusePluginData',
							array(&$this->componentContext, &$plugin, &$this)
						);
						CFactory::_('Config')->build_target = $plugin->key;
						CFactory::_('Config')->lang_target = $plugin->key;
						$this->langPrefix = $plugin->lang_prefix;
						CFactory::_('Config')->set('lang_prefix', $plugin->lang_prefix);
						// MAINCLASS
						CFactory::_('Content')->set_($plugin->key, 'MAINCLASS', $this->getPluginMainClass($plugin));
						// only add install script if needed
						if ($plugin->add_install_script)
						{
							// INSTALLCLASS
							CFactory::_('Content')->set_($plugin->key, 'INSTALLCLASS', CFactory::_('Extension.InstallScript')->get($plugin));
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
										CFactory::_('Content')->set_($plugin->key,
											'FIELDSET_' . $file . $field_name . $fieldset,
											$this->getExtensionFieldsetXML(
												$plugin, $fields
											)
										);
									}
								}
							}
						}
						// MAINXML
						CFactory::_('Content')->set_($plugin->key, 'MAINXML', $this->getPluginMainXML($plugin));
						// Trigger Event: jcb_ce_onAfterInfusePluginData
						CFactory::_('Event')->trigger(
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
			$placeholders = CFactory::_('Placeholder')->active;
			$fileContentStatic = CFactory::_('Content')->active;
			$fileContentDynamic = CFactory::_('Content')->_active;
			// Trigger Event: jcb_ce_onAfterBuildFilesContent
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterBuildFilesContent',
				array(&$this->componentContext, &$this->componentData,
					&$fileContentStatic, &$this->fileContentDynamic,
					&$placeholders, &$this->hhh)
			);
			unset($fileContentStatic);
			unset($fileContentDynamic);
			unset($placeholders);

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
		CFactory::_('Placeholder')->clearType('views');

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
			CFactory::_('Placeholder')->set('view', $nameSingleCode);
			CFactory::_('Placeholder')->set('View', $name_single_first_uppercase);
			CFactory::_('Placeholder')->set('VIEW', $name_single_uppercase);
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
			CFactory::_('Placeholder')->set('views', $nameListCode);
			CFactory::_('Placeholder')->set('Views', $name_list_first_uppercase);
			CFactory::_('Placeholder')->set('VIEWS', $name_list_uppercase);
		}

		// view <<<DYNAMIC>>>
		if (isset($nameSingleCode))
		{
			CFactory::_('Content')->set_($nameSingleCode, 'view', $nameSingleCode);
			CFactory::_('Content')->set_($nameSingleCode, 'VIEW', $name_single_uppercase);
			CFactory::_('Content')->set_($nameSingleCode, 'View', $name_single_first_uppercase);

			if (isset($nameListCode))
			{
				CFactory::_('Content')->set_($nameListCode, 'view', $nameSingleCode);
				CFactory::_('Content')->set_($nameListCode, 'VIEW', $name_single_uppercase);
				CFactory::_('Content')->set_($nameListCode, 'View', $name_single_first_uppercase);
			}
		}

		// views <<<DYNAMIC>>>
		if (isset($nameListCode))
		{
			CFactory::_('Content')->set_($nameListCode, 'views', $nameListCode);
			CFactory::_('Content')->set_($nameListCode, 'VIEWS', $name_list_uppercase);
			CFactory::_('Content')->set_($nameListCode, 'Views', $name_list_first_uppercase);

			if (isset($nameSingleCode))
			{
				CFactory::_('Content')->set_($nameSingleCode, 'views', $nameListCode);
				CFactory::_('Content')->set_($nameSingleCode, 'VIEWS', $name_list_uppercase);
				CFactory::_('Content')->set_($nameSingleCode, 'Views', $name_list_first_uppercase);
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
		if ((!CFactory::_('Config')->remove_site_folder || !CFactory::_('Config')->remove_site_edit_folder)
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
		if ((!CFactory::_('Config')->remove_site_folder || !CFactory::_('Config')->remove_site_edit_folder)
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
		CFactory::_('Event')->trigger(
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
						if (CFactory::_('Config')->remove_site_folder
							&& CFactory::_('Config')->remove_site_edit_folder)
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
				if ((!CFactory::_('Config')->remove_site_folder || !CFactory::_('Config')->remove_site_edit_folder)
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
