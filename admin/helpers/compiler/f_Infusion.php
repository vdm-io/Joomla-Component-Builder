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

use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\Filter\OutputFilter;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Minify;

/**
 * Infusion class
 * @deprecated 3.3
 */
class Infusion extends Interpretation
{

	public $langFiles = [];

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
		if (CFactory::_('Component')->isArray('admin_views'))
		{
			// Trigger Event: jcb_ce_onBeforeBuildFilesContent
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeBuildFilesContent'
			);

			// COMPONENT
			CFactory::_('Compiler.Builder.Content.One')->set('COMPONENT',
				CFactory::_('Placeholder')->get('COMPONENT')
			);

			// Component
			CFactory::_('Compiler.Builder.Content.One')->set('Component',
				CFactory::_('Placeholder')->get('Component')
			);

			// component
			CFactory::_('Compiler.Builder.Content.One')->set('component',
				CFactory::_('Placeholder')->get('component')
			);

			// ComponentNameSpace
			CFactory::_('Compiler.Builder.Content.One')->set('ComponentNameSpace',
				NamespaceHelper::safeSegment(CFactory::_('Placeholder')->get('Component'))
			);

			// COMPANYNAME
			$companyname = CFactory::_('Component')->get('companyname');
			CFactory::_('Compiler.Builder.Content.One')->set('COMPANYNAME', trim(
				(string) JFilterOutput::cleanText($companyname)
			));

			// POWER_LIBRARY_FOLDER
			CFactory::_('Compiler.Builder.Content.One')->set('POWER_LIBRARY_FOLDER',
				CFactory::_('Config')->power_library_folder
			);

			// CREATIONDATE
			CFactory::_('Compiler.Builder.Content.One')->set('CREATIONDATE',
				Factory::getDate(CFactory::_('Component')->get('created'))->format(
				'jS F, Y'
			));
			CFactory::_('Compiler.Builder.Content.One')->set('GLOBALCREATIONDATE',
				CFactory::_('Compiler.Builder.Content.One')->get('CREATIONDATE'));

			// BUILDDATE
			CFactory::_('Compiler.Builder.Content.One')->set('BUILDDATE', Factory::getDate(
				CFactory::_('Config')->get('build_date', 'now'))->format('jS F, Y'));
			CFactory::_('Compiler.Builder.Content.One')->set('GLOBALBUILDDATE',
				CFactory::_('Compiler.Builder.Content.One')->get('BUILDDATE'));

			// AUTHOR
			$author = CFactory::_('Component')->get('author');
			CFactory::_('Compiler.Builder.Content.One')->set('AUTHOR', trim(
				(string) OutputFilter::cleanText($author)
			));

			// AUTHOREMAIL
			CFactory::_('Compiler.Builder.Content.One')->set('AUTHOREMAIL',
				trim((string) CFactory::_('Component')->get('email', ''))
			);

			// AUTHORWEBSITE
			CFactory::_('Compiler.Builder.Content.One')->set('AUTHORWEBSITE',
				trim((string) CFactory::_('Component')->get('website', ''))
			);

			// COPYRIGHT
			CFactory::_('Compiler.Builder.Content.One')->set('COPYRIGHT',
				trim((string) CFactory::_('Component')->get('copyright', ''))
			);

			// LICENSE
			CFactory::_('Compiler.Builder.Content.One')->set('LICENSE',
				trim((string) CFactory::_('Component')->get('license', ''))
			);

			// VERSION
			CFactory::_('Compiler.Builder.Content.One')->set('VERSION',
				trim((string) CFactory::_('Component')->get('component_version', ''))
			);
			// set the actual global version
			CFactory::_('Compiler.Builder.Content.One')->set('ACTUALVERSION',
				CFactory::_('Compiler.Builder.Content.One')->get('VERSION')
			);

			// do some Tweaks to the version based on selected options
			if (strpos((string) CFactory::_('Compiler.Builder.Content.One')->get('VERSION'), '.') !== false)
			{
				$versionArray = explode(
					'.', (string) CFactory::_('Compiler.Builder.Content.One')->get('VERSION')
				);
			}
			// load only first two values
			if (isset($versionArray)
				&& ArrayHelper::check(
					$versionArray
				) && CFactory::_('Component')->get('mvc_versiondate', 0) == 2)
			{
				CFactory::_('Compiler.Builder.Content.One')->set('VERSION',
					$versionArray[0] . '.' . $versionArray[1] . '.x'
				);
			}
			// load only the first value
			elseif (isset($versionArray)
				&& ArrayHelper::check(
					$versionArray
				) && CFactory::_('Component')->get('mvc_versiondate', 0) == 3)
			{
				CFactory::_('Compiler.Builder.Content.One')->set('VERSION',
					$versionArray[0] . '.x.x'
				);
			}
			unset($versionArray);

			// set the namespace prefix
			CFactory::_('Compiler.Builder.Content.One')->set('NAMESPACEPREFIX',
				CFactory::_('Config')->namespace_prefix
			);

			// set the global version in case
			CFactory::_('Compiler.Builder.Content.One')->set('GLOBALVERSION',
				CFactory::_('Compiler.Builder.Content.One')->get('VERSION')
			);

			// set the joomla target xml version
			CFactory::_('Compiler.Builder.Content.One')->set('XMLVERSION',
				CFactory::_('Config')->joomla_versions[CFactory::_('Config')->joomla_version]['xml_version']
			);

			// Component_name
			$name = CFactory::_('Component')->get('name');
			CFactory::_('Compiler.Builder.Content.One')->set('Component_name',
				OutputFilter::cleanText($name)
			);

			// SHORT_DISCRIPTION
			$short_description = CFactory::_('Component')->get('short_description');
			CFactory::_('Compiler.Builder.Content.One')->set('SHORT_DESCRIPTION', trim(
				(string) OutputFilter::cleanText(
					$short_description
				)
			));

			// DESCRIPTION
			CFactory::_('Compiler.Builder.Content.One')->set('DESCRIPTION',
				trim((string) CFactory::_('Component')->get('description'))
			);

			// COMP_IMAGE_TYPE
			CFactory::_('Compiler.Builder.Content.One')->set('COMP_IMAGE_TYPE',
				$this->setComponentImageType(CFactory::_('Component')->get('image'))
			);

			// ACCESS_SECTIONS
			CFactory::_('Compiler.Builder.Content.One')->set('ACCESS_SECTIONS',
				CFactory::_('Compiler.Creator.Access.Sections')->get()
			);

			// CONFIG_FIELDSETS
			$keepLang   = CFactory::_('Config')->lang_target;
			CFactory::_('Config')->lang_target = 'admin';

			// start loading the category tree scripts
			CFactory::_('Compiler.Builder.Content.One')->set('CATEGORY_CLASS_TREES', '');
			// run the field sets for first time
			CFactory::_('Compiler.Creator.Config.Fieldsets')->set(1);
			CFactory::_('Config')->lang_target = $keepLang;

			// ADMINJS
			CFactory::_('Compiler.Builder.Content.One')->set('ADMINJS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_js']
			));
			// SITEJS
			CFactory::_('Compiler.Builder.Content.One')->set('SITEJS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_js']
			));

			// ADMINCSS
			CFactory::_('Compiler.Builder.Content.One')->set('ADMINCSS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_css_admin']
			));
			// SITECSS
			CFactory::_('Compiler.Builder.Content.One')->set('SITECSS',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_css_site']
			));

			// CUSTOM_HELPER_SCRIPT
			CFactory::_('Compiler.Builder.Content.One')->set('CUSTOM_HELPER_SCRIPT',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_php_helper_admin']
			));

			// BOTH_CUSTOM_HELPER_SCRIPT
			CFactory::_('Compiler.Builder.Content.One')->set('BOTH_CUSTOM_HELPER_SCRIPT',
				CFactory::_('Placeholder')->update_(
				CFactory::_('Customcode.Dispenser')->hub['component_php_helper_both']
			));

			// ADMIN_GLOBAL_EVENT_HELPER
			if (!CFactory::_('Compiler.Builder.Content.One')->exists('ADMIN_GLOBAL_EVENT'))
			{
				CFactory::_('Compiler.Builder.Content.One')->set('ADMIN_GLOBAL_EVENT', '');
			}
			if (!CFactory::_('Compiler.Builder.Content.One')->exists('ADMIN_GLOBAL_EVENT_HELPER'))
			{
				CFactory::_('Compiler.Builder.Content.One')->set('ADMIN_GLOBAL_EVENT_HELPER', '');
			}
			// now load the data for the global event if needed
			if (CFactory::_('Component')->get('add_admin_event', 0) == 1)
			{
				// ADMIN_GLOBAL_EVENT
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT',
					PHP_EOL . PHP_EOL . '// Trigger the Global Admin Event'
				);
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT',
					PHP_EOL . CFactory::_('Compiler.Builder.Content.One')->get('Component')
					. 'Helper::globalEvent(Factory::getDocument());');
				// ADMIN_GLOBAL_EVENT_HELPER
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . PHP_EOL . Indent::_(1) . '/**'
				);
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . Indent::_(1)
					. '*	The Global Admin Event Method.');
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . Indent::_(1) . '**/'
				);
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . Indent::_(1)
					. 'public static function globalEvent($document)');
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . Indent::_(1) . '{'
				);
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . CFactory::_('Placeholder')->update_(
						CFactory::_('Customcode.Dispenser')->hub['component_php_admin_event']
					));
				CFactory::_('Compiler.Builder.Content.One')->add('ADMIN_GLOBAL_EVENT_HELPER',
					PHP_EOL . Indent::_(1) . '}'
				);
			}

			// now load the readme file if needed
			if (CFactory::_('Component')->get('addreadme', 0) == 1)
			{
				CFactory::_('Compiler.Builder.Content.One')->add('EXSTRA_ADMIN_FILES',
					PHP_EOL . Indent::_(3)
					. "<filename>README.txt</filename>");
			}

			// HELPER_CREATEUSER
			CFactory::_('Compiler.Builder.Content.One')->add('HELPER_CREATEUSER',
				$this->setCreateUserHelperMethod(
				CFactory::_('Component')->get('creatuserhelper')
			));

			// HELP
			CFactory::_('Compiler.Builder.Content.One')->set('HELP', $this->noHelp());
			// HELP_SITE
			CFactory::_('Compiler.Builder.Content.One')->set('HELP_SITE', $this->noHelp());

			// build route parse switch
			CFactory::_('Compiler.Builder.Content.One')->set('ROUTER_PARSE_SWITCH', '');
			// build route views
			CFactory::_('Compiler.Builder.Content.One')->set('ROUTER_BUILD_VIEWS', '');

			// add the helper emailer if set
			CFactory::_('Compiler.Builder.Content.One')->set('HELPER_EMAIL', $this->addEmailHelper());

			// load the global placeholders
			foreach (CFactory::_('Component.Placeholder')->get() as $globalPlaceholder =>
				$gloabalValue
			)
			{
				CFactory::_('Compiler.Builder.Content.One')->set($globalPlaceholder, $gloabalValue);
			}

			// reset view array
			$viewarray            = [];
			$site_edit_view_array = [];
			// start dynamic build
			foreach (CFactory::_('Component')->get('admin_views') as $view)
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

					// Trigger Event: jcb_ce_onBeforeBuildAdminEditViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildAdminEditViewContent', [&$view, &$nameSingleCode, &$nameListCode]
					);

					// FIELDSETS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|FIELDSETS',
						CFactory::_('Compiler.Creator.Fieldset')->get(
							$view,
							CFactory::_('Config')->component_code_name,
							$nameSingleCode,
							$nameListCode
						)
					);

					// ACCESSCONTROL <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|ACCESSCONTROL',
						$this->setFieldSetAccessControl(
							$nameSingleCode
						)
					);

					// LINKEDVIEWITEMS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|LINKEDVIEWITEMS', '');

					// ADDTOOLBAR <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|ADDTOOLBAR',
						$this->setAddToolBar($view)
					);

					// set the script for this view
					$this->buildTheViewScript($view);

					// VIEW_SCRIPT
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|VIEW_SCRIPT',
						$this->setViewScript(
							$nameSingleCode, 'fileScript'
						)
					);

					// EDITBODYSCRIPT
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|EDITBODYSCRIPT',
						$this->setViewScript(
							$nameSingleCode, 'footerScript'
						)
					);

					// AJAXTOKE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|AJAXTOKE',
						$this->setAjaxToke(
							$nameSingleCode
						)
					);

					// DOCUMENT_CUSTOM_PHP <<<DYNAMIC>>>
					if ($phpDocument = CFactory::_('Customcode.Dispenser')->get(
						'php_document', $nameSingleCode,
						PHP_EOL, null, true,
						false
					))
					{
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|DOCUMENT_CUSTOM_PHP',
							str_replace(
								'$document->', '$this->document->', (string) $phpDocument
							)
						);
						// clear some memory
						unset($phpDocument);
					}
					else
					{
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|DOCUMENT_CUSTOM_PHP', '');
					}
					// LINKEDVIEWTABLESCRIPTS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|LINKEDVIEWTABLESCRIPTS', '');

					// VALIDATEFIX <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|VALIDATIONFIX',
						$this->setValidationFix(
							$nameSingleCode,
							CFactory::_('Compiler.Builder.Content.One')->get('Component')
						)
					);

					// EDITBODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|EDITBODY',
						$this->setEditBody($view)
					);

					// EDITBODYFADEIN <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|EDITBODYFADEIN',
						$this->setFadeInEfect($view)
					);

					// JTABLECONSTRUCTOR <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JTABLECONSTRUCTOR',
						$this->setJtableConstructor(
							$nameSingleCode
						)
					);

					// JTABLEALIASCATEGORY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JTABLEALIASCATEGORY',
						$this->setJtableAliasCategory(
							$nameSingleCode
						)
					);

					// METHOD_GET_ITEM <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|METHOD_GET_ITEM',
						$this->setMethodGetItem(
							$nameSingleCode
						)
					);

					// LINKEDVIEWGLOBAL <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|LINKEDVIEWGLOBAL', '');

					// LINKEDVIEWMETHODS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|LINKEDVIEWMETHODS', '');

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_BEFORE_DELETE',
						CFactory::_('Customcode.Dispenser')->get(
							'php_before_delete',
							$nameSingleCode, PHP_EOL
						)
					);

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_AFTER_DELETE',
						CFactory::_('Customcode.Dispenser')->get(
							'php_after_delete', $nameSingleCode,
							PHP_EOL . PHP_EOL
						)
					);

					// JMODELADMIN_BEFORE_DELETE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_BEFORE_PUBLISH',
						CFactory::_('Customcode.Dispenser')->get(
							'php_before_publish',
							$nameSingleCode, PHP_EOL
						)
					);

					// JMODELADMIN_AFTER_DELETE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_AFTER_PUBLISH',
						CFactory::_('Customcode.Dispenser')->get(
							'php_after_publish',
							$nameSingleCode, PHP_EOL . PHP_EOL
						)
					);

					// CHECKBOX_SAVE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|CHECKBOX_SAVE',
						$this->setCheckboxSave(
							$nameSingleCode
						)
					);

					// METHOD_ITEM_SAVE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|METHOD_ITEM_SAVE',
						$this->setMethodItemSave(
							$nameSingleCode
						)
					);

					// POSTSAVEHOOK <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|POSTSAVEHOOK',
						CFactory::_('Customcode.Dispenser')->get(
							'php_postsavehook', $nameSingleCode,
							PHP_EOL, null,
							true, PHP_EOL . Indent::_(2) . "return;",
							PHP_EOL . PHP_EOL . Indent::_(2) . "return;"
						)
					);

					// VIEWCSS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|VIEWCSS',
						CFactory::_('Customcode.Dispenser')->get(
							'css_view', $nameSingleCode, '',
							null, true
						)
					);

					// add css to front end
					if (isset($view['edit_create_site_view'])
						&& is_numeric($view['edit_create_site_view'])
						&& $view['edit_create_site_view'] > 0)
					{
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|SITE_VIEWCSS',
							CFactory::_('Compiler.Builder.Content.Multi')->get($nameSingleCode . '|VIEWCSS', '')
						);
						// check if we should add a create menu
						if ($view['edit_create_site_view'] == 2)
						{
							// SITE_MENU_XML <<<DYNAMIC>>>
							CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|SITE_MENU_XML',
								$this->setAdminViewMenu(
									$nameSingleCode, $view
								)
							);
						}
						// SITE_ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|SITE_ADMIN_VIEW_CONTROLLER_HEADER',
							CFactory::_('Header')->get(
								'site.admin.view.controller',
								$nameSingleCode
							)
						);
						// SITE_ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|SITE_ADMIN_VIEW_MODEL_HEADER',
							CFactory::_('Header')->get(
								'site.admin.view.model',
								$nameSingleCode
							)
						);
						// SITE_ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|SITE_ADMIN_VIEW_HTML_HEADER',
							CFactory::_('Header')->get(
								'site.admin.view.html',
								$nameSingleCode
							)
						);
						// SITE_ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|SITE_ADMIN_VIEW_HEADER',
							CFactory::_('Header')->get(
								'site.admin.view',
								$nameSingleCode
							)
						);
					}

					// TABLAYOUTFIELDSARRAY <<<DYNAMIC>>> add the tab layout fields array to the model
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|TABLAYOUTFIELDSARRAY',
						$this->getTabLayoutFieldsArray(
							$nameSingleCode
						)
					);

					// ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|ADMIN_VIEW_CONTROLLER_HEADER',
						CFactory::_('Header')->get(
							'admin.view.controller',
							$nameSingleCode
						)
					);
					// ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|ADMIN_VIEW_MODEL_HEADER',
						CFactory::_('Header')->get(
							'admin.view.model', $nameSingleCode
						)
					);
					// ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|ADMIN_VIEW_HTML_HEADER',
						CFactory::_('Header')->get(
							'admin.view.html', $nameSingleCode
						)
					);
					// ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|ADMIN_VIEW_HEADER',
						CFactory::_('Header')->get(
							'admin.view', $nameSingleCode
						)
					);

					// Trigger Event: jcb_ce_onAfterBuildAdminEditViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildAdminEditViewContent',[&$view, &$nameSingleCode, &$nameListCode]
					);
				}
				// set the views names
				if (isset($view['settings']->name_list)
					&& $view['settings']->name_list != 'null')
				{
					CFactory::_('Config')->lang_target = 'admin';

					// ICOMOON <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ICOMOON', $view['icomoon']);

					// Trigger Event: jcb_ce_onBeforeBuildAdminListViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildAdminListViewContent', [&$view, &$nameSingleCode, &$nameListCode]
					);

					// set the export/import option
					if (isset($view['port']) && $view['port']
						|| 1 == $view['settings']->add_custom_import)
					{
						$this->eximportView[$nameListCode] = true;
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
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|AUTOCHECKIN',
							$this->setAutoCheckin(
								$nameSingleCode,
								CFactory::_('Config')->component_code_name
							)
						);
						// CHECKINCALL <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|CHECKINCALL',
							$this->setCheckinCall()
						);
					}
					else
					{
						// AUTOCHECKIN <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|AUTOCHECKIN', '');
						// CHECKINCALL <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|CHECKINCALL', '');
					}
					// admin list file contnet
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_JAVASCRIPT_FILE',
						$this->setViewScript(
							$nameListCode, 'list_fileScript'
						)
					);
					// ADMIN_CUSTOM_BUTTONS_LIST
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_CUSTOM_BUTTONS_LIST',
						$this->setCustomButtons($view, 3, Indent::_(1)));
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_CUSTOM_FUNCTION_ONLY_BUTTONS_LIST',
						$this->setFunctionOnlyButtons(
							$nameListCode
						)
					);

					// GET_ITEMS_METHOD_STRING_FIX <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|GET_ITEMS_METHOD_STRING_FIX',
						$this->setGetItemsMethodStringFix(
							$nameSingleCode,
							$nameListCode,
							CFactory::_('Compiler.Builder.Content.One')->get('Component')
						)
					);

					// GET_ITEMS_METHOD_AFTER_ALL <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|GET_ITEMS_METHOD_AFTER_ALL',
						CFactory::_('Customcode.Dispenser')->get(
							'php_getitems_after_all',
							$nameSingleCode, PHP_EOL
						)
					);

					// SELECTIONTRANSLATIONFIX <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|SELECTIONTRANSLATIONFIX',
						$this->setSelectionTranslationFix(
							$nameListCode,
							CFactory::_('Compiler.Builder.Content.One')->get('Component')
						)
					);

					// SELECTIONTRANSLATIONFIXFUNC <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|SELECTIONTRANSLATIONFIXFUNC',
						$this->setSelectionTranslationFixFunc(
							$nameListCode,
							CFactory::_('Compiler.Builder.Content.One')->get('Component')
						)
					);

					// FILTER_FIELDS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|FILTER_FIELDS',
						$this->setFilterFieldsArray(
							$nameSingleCode,
							$nameListCode
						)
					);

					// STOREDID <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|STOREDID',
						$this->setStoredId(
							$nameSingleCode, $nameListCode
						)
					);

					// POPULATESTATE <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|POPULATESTATE',
						$this->setPopulateState(
							$nameSingleCode, $nameListCode
						)
					);

					// SORTFIELDS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|SORTFIELDS',
						$this->setSortFields(
							$nameListCode
						)
					);

					// CATEGORY_VIEWS
					CFactory::_('Compiler.Builder.Content.One')->add('ROUTER_CATEGORY_VIEWS',
						$this->setRouterCategoryViews(
						$nameSingleCode,
						$nameListCode
					));

					// FILTERFIELDDISPLAYHELPER <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|FILTERFIELDDISPLAYHELPER',
						$this->setFilterFieldSidebarDisplayHelper(
							$nameSingleCode,
							$nameListCode
						)
					);

					// BATCHDISPLAYHELPER <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|BATCHDISPLAYHELPER',
						$this->setBatchDisplayHelper(
							$nameSingleCode,
							$nameListCode
						)
					);

					// FILTERFUNCTIONS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|FILTERFUNCTIONS',
						$this->setFilterFieldHelper(
							$nameSingleCode,
							$nameListCode
						)
					);

					// FIELDFILTERSETS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set('filter_' . $nameListCode . '|FIELDFILTERSETS',
						$this->setFieldFilterSet(
						$nameSingleCode,
						$nameListCode
					));

					// FIELDLISTSETS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set('filter_' . $nameListCode . '|FIELDLISTSETS',
						$this->setFieldFilterListSet(
						$nameSingleCode,
						$nameListCode
					));

					// LISTQUERY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|LISTQUERY',
						$this->setListQuery(
							$nameSingleCode,
							$nameListCode
						)
					);

					// MODELEXPORTMETHOD <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|MODELEXPORTMETHOD',
						$this->setGetItemsModelMethod(
							$nameSingleCode,
							$nameListCode
						)
					);

					// MODELEXIMPORTMETHOD <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|CONTROLLEREXIMPORTMETHOD',
						$this->setControllerEximportMethod(
							$nameSingleCode,
							$nameListCode
						)
					);

					// EXPORTBUTTON <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|EXPORTBUTTON',
						$this->setExportButton(
							$nameSingleCode,
							$nameListCode
						)
					);

					// IMPORTBUTTON <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|IMPORTBUTTON',
						$this->setImportButton(
							$nameSingleCode,
							$nameListCode
						)
					);

					// VIEWS_DEFAULT_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|VIEWS_DEFAULT_BODY',
						$this->setDefaultViewsBody(
							$nameSingleCode,
							$nameListCode
						)
					);

					// LISTHEAD <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|LISTHEAD',
						$this->setListHead(
							$nameSingleCode,
							$nameListCode
						)
					);

					// LISTBODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|LISTBODY',
						$this->setListBody(
							$nameSingleCode,
							$nameListCode
						)
					);

					// LISTCOLNR <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|LISTCOLNR',
						$this->setListColnr(
							$nameListCode
						)
					);

					// JVIEWLISTCANDO <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|JVIEWLISTCANDO',
						$this->setJviewListCanDo(
							$nameSingleCode,
							$nameListCode
						)
					);

					// VIEWSCSS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|VIEWSCSS',
						CFactory::_('Customcode.Dispenser')->get(
							'css_views', $nameSingleCode, '',
							null, true
						)
					);

					// ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_DIPLAY_METHOD',
						$this->setAdminViewDisplayMethod(
							$nameListCode
						)
					);

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
							&& strpos((string) $footerScript, '<?php') === false)
						{
							// minify the script
							$footerScript = Minify::js($footerScript);
						}
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|VIEWS_FOOTER_SCRIPT',
							PHP_EOL . '<script type="text/javascript">'
							. $footerScript . "</script>");
						// clear some memory
						unset($footerScript);
					}
					else
					{
						CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|VIEWS_FOOTER_SCRIPT', '');
					}

					// ADMIN_VIEWS_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_VIEWS_CONTROLLER_HEADER',
						CFactory::_('Header')->get(
							'admin.views.controller',
							$nameListCode
						)
					);
					// ADMIN_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_VIEWS_MODEL_HEADER',
						CFactory::_('Header')->get(
							'admin.views.model', $nameListCode
						)
					);
					// ADMIN_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the views
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_VIEWS_HTML_HEADER',
						CFactory::_('Header')->get(
							'admin.views.html', $nameListCode
						)
					);
					// ADMIN_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the views
					CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_VIEWS_HEADER',
						CFactory::_('Header')->get(
							'admin.views', $nameListCode
						)
					);

					// Trigger Event: jcb_ce_onAfterBuildAdminListViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildAdminListViewContent', [&$view, &$nameSingleCode, &$nameListCode]
					);
				}

				// set u fields used in batch
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|UNIQUEFIELDS',
					$this->setUniqueFields(
						$nameSingleCode
					)
				);

				// TITLEALIASFIX <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|TITLEALIASFIX',
					$this->setAliasTitleFix(
						$nameSingleCode
					)
				);

				// GENERATENEWTITLE <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|GENERATENEWTITLE',
					$this->setGenerateNewTitle(
						$nameSingleCode
					)
				);

				// GENERATENEWALIAS <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|GENERATENEWALIAS',
					$this->setGenerateNewAlias(
						$nameSingleCode
					)
				);

				// MODEL_BATCH_COPY <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|MODEL_BATCH_COPY',
					$this->setBatchCopy($nameSingleCode)
				);

				// MODEL_BATCH_MOVE <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|MODEL_BATCH_MOVE',
					$this->setBatchMove($nameSingleCode)
				);

				// BATCH_ONCLICK_CANCEL_SCRIPT <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|BATCH_ONCLICK_CANCEL_SCRIPT', ''); // TODO <-- must still be build

				// JCONTROLLERFORM_ALLOWADD <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JCONTROLLERFORM_ALLOWADD',
					CFactory::_('Architecture.Controller.AllowAdd')->get(
						$nameSingleCode,
					)
				);

				// JCONTROLLERFORM_BEFORECANCEL <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JCONTROLLERFORM_BEFORECANCEL',
					CFactory::_('Customcode.Dispenser')->get(
						'php_before_cancel', $nameSingleCode,
						PHP_EOL, null, false,
						''
					)
				);

				// JCONTROLLERFORM_AFTERCANCEL <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JCONTROLLERFORM_AFTERCANCEL',
					CFactory::_('Customcode.Dispenser')->get(
						'php_after_cancel', $nameSingleCode,
						PHP_EOL, null, false,
						''
					)
				);

				// JCONTROLLERFORM_ALLOWEDIT <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JCONTROLLERFORM_ALLOWEDIT',
					CFactory::_('Architecture.Controller.AllowEdit')->get(
						$nameSingleCode,
						$nameListCode
					)
				);

				// JMODELADMIN_GETFORM <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_GETFORM',
					$this->setJmodelAdminGetForm(
						$nameSingleCode,
						$nameListCode
					)
				);

				// JMODELADMIN_ALLOWEDIT <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_ALLOWEDIT',
					$this->setJmodelAdminAllowEdit(
						$nameSingleCode,
						$nameListCode
					)
				);

				// JMODELADMIN_CANDELETE <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_CANDELETE',
					CFactory::_('Architecture.Model.CanDelete')->get(
						$nameSingleCode
					)
				);

				// JMODELADMIN_CANEDITSTATE <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|JMODELADMIN_CANEDITSTATE',
					CFactory::_('Architecture.Model.CanEditState')->get(
						$nameSingleCode
					)
				);

				// set custom admin view Toolbare buttons
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS  <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|CUSTOM_ADMIN_DYNAMIC_BUTTONS',
					$this->setCustomAdminDynamicButton(
						$nameListCode
					)
				);
				// CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER  <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER',
					$this->setCustomAdminDynamicButtonController(
						$nameListCode
					)
				);

				// set helper router
				CFactory::_('Compiler.Builder.Content.One')->add('ROUTEHELPER',
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
					CFactory::_('Compiler.Builder.Content.One')->add('ROUTER_PARSE_SWITCH',
						$this->routerParseSwitch(
						$nameSingleCode, null, false
					));
					CFactory::_('Compiler.Builder.Content.One')->add('ROUTER_BUILD_VIEWS',
						$this->routerBuildViews(
						$nameSingleCode
					));
				}

				// ACCESS_SECTIONS
				CFactory::_('Compiler.Builder.Content.One')->add('ACCESS_SECTIONS',
					CFactory::_('Compiler.Creator.Access.Sections.Category')->get(
						$nameSingleCode,
						$nameListCode
					)
				);
				// set the Joomla Fields ACCESS section if needed
				if (isset($view['joomla_fields'])
					&& $view['joomla_fields'] == 1)
				{
					CFactory::_('Compiler.Builder.Content.One')->add('ACCESS_SECTIONS',
						CFactory::_('Compiler.Creator.Access.Sections.Joomla.Fields')->get()
					);
				}

				// Trigger Event: jcb_ce_onAfterBuildAdminViewContent
				CFactory::_('Event')->trigger(
					'jcb_ce_onAfterBuildAdminViewContent', [&$view, &$nameSingleCode, &$nameListCode]
				);
			}

			// all fields stored in database
			CFactory::_('Compiler.Builder.Content.One')->set('ALL_COMPONENT_FIELDS',
				CFactory::_('Compiler.Builder.Component.Fields')->varExport(null, 1)
			);

			// setup the layouts
			$this->setCustomViewLayouts();

			// setup custom_admin_views and all needed stuff for the site
			if (CFactory::_('Component')->isArray('custom_admin_views'))
			{
				CFactory::_('Config')->build_target = 'custom_admin';
				CFactory::_('Config')->lang_target = 'admin';
				// start dynamic build
				foreach (CFactory::_('Component')->get('custom_admin_views') as $view)
				{
					// for single views
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SView', $view['settings']->Code);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|sview', $view['settings']->code);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SVIEW', $view['settings']->CODE);
					// for list views
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SViews', $view['settings']->Code);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|sviews', $view['settings']->code);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SVIEWS', $view['settings']->CODE);
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
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|ICOMOON', $view['icomoon']);

					// set placeholders
					CFactory::_('Placeholder')->set('SView', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sview', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEW', $view['settings']->CODE);

					CFactory::_('Placeholder')->set('SViews', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sviews', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEWS', $view['settings']->CODE);

					// Trigger Event: jcb_ce_onBeforeBuildCustomAdminViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildCustomAdminViewContent', [&$view, &$view['settings']->code]
					);

					// set license per view if needed
					$this->setLockLicensePer(
						$view['settings']->code, CFactory::_('Config')->build_target
					);

					// check if this custom admin view is the default view
					if (CFactory::_('Registry')->get('build.dashboard.type', '') === 'custom_admin_views'
						&& CFactory::_('Registry')->get('build.dashboard', '') === $view['settings']->code)
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|HIDEMAINMENU', '');
					}
					else
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|HIDEMAINMENU',
							PHP_EOL . Indent::_(2) . '//' . Line::_(
								__LINE__,__CLASS__
							) . " hide the main menu"
							. PHP_EOL . Indent::_(2)
							. "\$this->app->input->set('hidemainmenu', true);"
						);
					}

					if ($view['settings']->main_get->gettype == 1)
					{
						// CUSTOM_ADMIN_BEFORE_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_BEFORE_GET_ITEM',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_before_getitem',
								$view['settings']->code, '', null, true
							)
						);

						// CUSTOM_ADMIN_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_GET_ITEM',
							$this->setCustomViewGetItem(
								$view['settings']->main_get,
								$view['settings']->code, Indent::_(2)
							)
						);

						// CUSTOM_ADMIN_AFTER_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_AFTER_GET_ITEM',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_after_getitem',
								$view['settings']->code, '', null, true
							)
						);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// CUSTOM_ADMIN_GET_LIST_QUERY <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_GET_LIST_QUERY',
							$this->setCustomViewListQuery(
								$view['settings']->main_get, $view['settings']->code
							)
						);

						// CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_getlistquery',
								$view['settings']->code, PHP_EOL, null, true
							)
						);

						// CUSTOM_ADMIN_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_BEFORE_GET_ITEMS',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_before_getitems',
									$view['settings']->code, PHP_EOL, null, true
							)
						);

						// CUSTOM_ADMIN_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_GET_ITEMS',
							$this->setCustomViewGetItems(
								$view['settings']->main_get, $view['settings']->code
							)
						);

						// CUSTOM_ADMIN_AFTER_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_AFTER_GET_ITEMS',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_after_getitems',
								$view['settings']->code, PHP_EOL, null, true
							)
						);
					}

					// CUSTOM_ADMIN_CUSTOM_METHODS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_CUSTOM_METHODS',
						$this->setCustomViewCustomItemMethods(
							$view['settings']->main_get, $view['settings']->code
						)
					);
					CFactory::_('Compiler.Builder.Content.Multi')->add($view['settings']->code . '|CUSTOM_ADMIN_CUSTOM_METHODS',
						$this->setCustomViewCustomMethods(
							$view, $view['settings']->code
						). false
					);
					// CUSTOM_ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_DIPLAY_METHOD',
						$this->setCustomViewDisplayMethod($view)
					);
					// set document details
					$this->setPrepareDocument($view);
					// CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS',
						$this->setCustomViewExtraDisplayMethods($view)
					);
					// CUSTOM_ADMIN_CODE_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_CODE_BODY',
						$this->setCustomViewCodeBody($view)
					);
					// CUSTOM_ADMIN_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_BODY',
						$this->setCustomViewBody($view)
					);
					// CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT',
						$this->setCustomViewSubmitButtonScript($view)
					);

					// setup the templates
					$this->setCustomViewTemplateBody($view);

					// set the site form if needed
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_TOP_FORM',
						$this->setCustomViewForm(
							$view['settings']->code,
							$view['settings']->main_get->gettype, 1
						)
					);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_BOTTOM_FORM',
						$this->setCustomViewForm(
							$view['settings']->code,
							$view['settings']->main_get->gettype, 2
						)
					);

					// set headers based on the main get type
					if ($view['settings']->main_get->gettype == 1)
					{
						// CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.view.controller',
								$view['settings']->code
							)
						);
						// CUSTOM_ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_MODEL_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.view.model', $view['settings']->code
							)
						);
						// CUSTOM_ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_HTML_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.view.html', $view['settings']->code
							)
						);
						// CUSTOM_ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.view', $view['settings']->code
							)
						);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.views.controller',
								$view['settings']->code
							)
						);
						// CUSTOM_ADMIN_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_MODEL_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.views.model', $view['settings']->code
							)
						);
						// CUSTOM_ADMIN_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_HTML_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.views.html', $view['settings']->code
							)
						);
						// CUSTOM_ADMIN_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_HEADER',
							CFactory::_('Header')->get(
								'custom.admin.views', $view['settings']->code
							)
						);
					}

					// Trigger Event: jcb_ce_onAfterBuildCustomAdminViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildCustomAdminViewContent', [&$view, &$view['settings']->code]
					);
				}

				// setup the layouts
				$this->setCustomViewLayouts();
			}

			// ADMIN_HELPER_CLASS_HEADER
			CFactory::_('Compiler.Builder.Content.One')->set('ADMIN_HELPER_CLASS_HEADER',
				CFactory::_('Header')->get(
				'admin.helper', 'admin'
			));

			// ADMIN_COMPONENT_HEADER
			CFactory::_('Compiler.Builder.Content.One')->set('ADMIN_COMPONENT_HEADER',
				CFactory::_('Header')->get(
				'admin.component', 'admin'
			));

			// SITE_HELPER_CLASS_HEADER
			CFactory::_('Compiler.Builder.Content.One')->set('SITE_HELPER_CLASS_HEADER',
				CFactory::_('Header')->get(
				'site.helper', 'site'
			));

			// SITE_COMPONENT_HEADER
			CFactory::_('Compiler.Builder.Content.One')->set('SITE_COMPONENT_HEADER',
				CFactory::_('Header')->get(
				'site.component', 'site'
			));

			// SITE_ROUTER_HEADER (Joomla 4 and above)
			CFactory::_('Compiler.Builder.Content.One')->set('SITE_ROUTER_HEADER',
				CFactory::_('Header')->get(
					'site.router', 'site'
			));

			// HELPER_EXEL
			CFactory::_('Compiler.Builder.Content.One')->set('HELPER_EXEL', $this->setHelperExelMethods());

			// VIEWARRAY
			CFactory::_('Compiler.Builder.Content.One')->set('VIEWARRAY',
				PHP_EOL . implode("," . PHP_EOL, $viewarray)
			);

			// CUSTOM_ADMIN_EDIT_VIEW_ARRAY
			CFactory::_('Compiler.Builder.Content.One')->set('SITE_EDIT_VIEW_ARRAY',
				PHP_EOL . implode("," . PHP_EOL, $site_edit_view_array)
			);

			// MAINMENUS
			CFactory::_('Compiler.Builder.Content.One')->set('MAINMENUS', $this->setMainMenus());

			// SUBMENU
			CFactory::_('Compiler.Builder.Content.One')->set('SUBMENU', $this->setSubMenus());

			// GET_CRYPT_KEY
			CFactory::_('Compiler.Builder.Content.One')->set('GET_CRYPT_KEY', $this->setGetCryptKey());

			// set the license locker
			$this->setLockLicense();

			// CONTRIBUTORS
			CFactory::_('Compiler.Builder.Content.One')->set('CONTRIBUTORS',
				CFactory::_('Compiler.Builder.Contributors')->get('bom', '')
			);

			// INSTALL
			CFactory::_('Compiler.Builder.Content.One')->set('INSTALL', $this->setInstall());

			// UNINSTALL
			CFactory::_('Compiler.Builder.Content.One')->set('UNINSTALL', $this->setUninstall());

			// UPDATE_VERSION_MYSQL
			$this->setVersionController();

			// only set these if default dashboard it used
			if (!CFactory::_('Registry')->get('build.dashboard'))
			{
				// DASHBOARDVIEW
				CFactory::_('Compiler.Builder.Content.One')->set('DASHBOARDVIEW',
					CFactory::_('Config')->component_code_name
				);

				// DASHBOARDICONS
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASHBOARDICONS',
					$this->setDashboardIcons()
				);

				// DASHBOARDICONACCESS
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASHBOARDICONACCESS',
					$this->setDashboardIconAccess()
				);

				// DASH_MODEL_METHODS
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASH_MODEL_METHODS',
					$this->setDashboardModelMethods()
				);

				// DASH_GET_CUSTOM_DATA
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASH_GET_CUSTOM_DATA',
					$this->setDashboardGetCustomData()
				);

				// DASH_DISPLAY_DATA
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASH_DISPLAY_DATA',
					$this->setDashboardDisplayData()
				);

				// DASH_VIEW_HEADER
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASH_VIEW_HEADER',
					CFactory::_('Header')->get('dashboard.view', 'dashboard')
				);
				// DASH_VIEW_HTML_HEADER
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASH_VIEW_HTML_HEADER',
					CFactory::_('Header')->get('dashboard.view.html', 'dashboard')
				);
				// DASH_MODEL_HEADER
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASH_MODEL_HEADER',
					CFactory::_('Header')->get('dashboard.model', 'dashboard')
				);
				// DASH_CONTROLLER_HEADER
				CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '|DASH_CONTROLLER_HEADER',
					CFactory::_('Header')->get('dashboard.controller', 'dashboard')
				);
			}
			else
			{
				// DASHBOARDVIEW
				CFactory::_('Compiler.Builder.Content.One')->set('DASHBOARDVIEW',
					CFactory::_('Registry')->get('build.dashboard')
				);
			}

			// add import
			if (CFactory::_('Config')->get('add_eximport', false))
			{
				// setup import files
				$target = array('admin' => 'import');
				CFactory::_('Utilities.Structure')->build($target, 'import');
				// IMPORT_EXT_METHOD <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set('import' . '|IMPORT_EXT_METHOD',
					PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
						ComponentbuilderHelper::getDynamicScripts('ext')
					)
				);
				// IMPORT_SETDATA_METHOD <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set('import' . '|IMPORT_SETDATA_METHOD',
					PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
						ComponentbuilderHelper::getDynamicScripts('setdata')
					)
				);
				// IMPORT_SAVE_METHOD <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set('import' . '|IMPORT_SAVE_METHOD',
					PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
						ComponentbuilderHelper::getDynamicScripts('save')
					)
				);
				// IMPORT_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
				CFactory::_('Compiler.Builder.Content.Multi')->set('import' . '|IMPORT_CONTROLLER_HEADER',
					CFactory::_('Header')->get(
						'import.controller', 'import'
					)
				);
				// IMPORT_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
				CFactory::_('Compiler.Builder.Content.Multi')->set('import' . '|IMPORT_MODEL_HEADER',
					CFactory::_('Header')->get(
						'import.model', 'import'
					)
				);
			}

			// ensure that the ajax model and controller is set if needed
			if (CFactory::_('Config')->get('add_ajax', false))
			{
				// setup Ajax files
				$target = array('admin' => 'ajax');
				CFactory::_('Utilities.Structure')->build($target, 'ajax');
				// set the controller
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|REGISTER_AJAX_TASK',
					$this->setRegisterAjaxTask('admin')
				);
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|AJAX_INPUT_RETURN',
					$this->setAjaxInputReturn('admin')
				);
				// set the model header
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|AJAX_ADMIN_MODEL_HEADER',
					CFactory::_('Header')->get('ajax.admin.model', 'ajax')
				);
				// set the module
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|AJAX_MODEL_METHODS',
					$this->setAjaxModelMethods('admin')
				);
			}

			// ensure that the site ajax model and controller is set if needed
			if (CFactory::_('Config')->get('add_site_ajax', false))
			{
				// setup Ajax files
				$target = array('site' => 'ajax');
				CFactory::_('Utilities.Structure')->build($target, 'ajax');
				// set the controller
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|REGISTER_SITE_AJAX_TASK',
					$this->setRegisterAjaxTask('site')
				);
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|AJAX_SITE_INPUT_RETURN',
					$this->setAjaxInputReturn('site')
				);
				// set the model header
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|AJAX_SITE_MODEL_HEADER',
					CFactory::_('Header')->get('ajax.site.model', 'ajax')
				);
				// set the module
				CFactory::_('Compiler.Builder.Content.Multi')->set('ajax' . '|AJAX_SITE_MODEL_METHODS',
					$this->setAjaxModelMethods('site')
				);
			}

			// build the validation rules
			if (($validationRules = CFactory::_('Registry')->_('validation.rules')) !== null)
			{
				foreach ($validationRules as $rule => $_php)
				{
					// setup rule file
					$target = array('admin' => 'a_rule_zi');
					CFactory::_('Utilities.Structure')->build($target, 'rule', $rule);
					// set the JFormRule Name
					CFactory::_('Compiler.Builder.Content.Multi')->set('a_rule_zi_' . $rule . '|Name',
						ucfirst((string) $rule)
					);
					// set the JFormRule PHP
					CFactory::_('Compiler.Builder.Content.Multi')->set('a_rule_zi_' . $rule . '|VALIDATION_RULE_METHODS',
						PHP_EOL . $_php
					);
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
			CFactory::_('Compiler.Creator.Config.Fieldsets')->set(2);
			CFactory::_('Config')->lang_target = $keepLang;

			// setup front-views and all needed stuff for the site
			if (CFactory::_('Component')->isArray('site_views'))
			{
				CFactory::_('Config')->build_target = 'site';
				// start dynamic build
				foreach (CFactory::_('Component')->get('site_views') as $view)
				{
					// for list views
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SViews',
						$view['settings']->Code
					);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|sviews',
						$view['settings']->code
					);
					// for single views
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SView',
						$view['settings']->Code
					);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|sview',
						$view['settings']->code
					);

					// set placeholders
					CFactory::_('Placeholder')->set('SView', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sview', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEW', $view['settings']->CODE);

					CFactory::_('Placeholder')->set('SViews', $view['settings']->Code);
					CFactory::_('Placeholder')->set('sviews', $view['settings']->code);
					CFactory::_('Placeholder')->set('SVIEWS', $view['settings']->CODE);

					// Trigger Event: jcb_ce_onBeforeBuildSiteViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeBuildSiteViewContent', [&$view, &$view['settings']->code]
					);

					// set license per view if needed
					$this->setLockLicensePer(
						$view['settings']->code, CFactory::_('Config')->build_target
					);

					// set the site default view
					if (isset($view['default_view'])
						&& $view['default_view'] == 1)
					{
						CFactory::_('Compiler.Builder.Content.One')->set('SITE_DEFAULT_VIEW',
							$view['settings']->code
						);
					}
					// add site menu
					if (isset($view['menu']) && $view['menu'] == 1)
					{
						// SITE_MENU_XML <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_MENU_XML',
							$this->setCustomViewMenu($view)
						);
					}

					// insure the needed route helper is loaded
					CFactory::_('Compiler.Builder.Content.One')->add('ROUTEHELPER',
						$this->setRouterHelp(
						$view['settings']->code, $view['settings']->code, true
					));
					// build route details
					CFactory::_('Compiler.Builder.Content.One')->add('ROUTER_PARSE_SWITCH',
						$this->routerParseSwitch(
						$view['settings']->code, $view
					));
					CFactory::_('Compiler.Builder.Content.One')->add('ROUTER_BUILD_VIEWS',
						$this->routerBuildViews($view['settings']->code)
					);

					if ($view['settings']->main_get->gettype == 1)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|USER_PERMISSION_CHECK_ACCESS',
							$this->setUserPermissionCheckAccess($view, 1)
						);

						// SITE_BEFORE_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_BEFORE_GET_ITEM',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_before_getitem',
								$view['settings']->code, '', null, true
							)
						);

						// SITE_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_GET_ITEM',
							$this->setCustomViewGetItem(
								$view['settings']->main_get,
								$view['settings']->code, Indent::_(2)
							)
						);

						// SITE_AFTER_GET_ITEM <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_AFTER_GET_ITEM',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_after_getitem',
								$view['settings']->code, '', null, true
							)
						);
					}
					elseif ($view['settings']->main_get->gettype == 2)
					{
						// set user permission access check USER_PERMISSION_CHECK_ACCESS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|USER_PERMISSION_CHECK_ACCESS',
							$this->setUserPermissionCheckAccess($view, 2)
						);
						// SITE_GET_LIST_QUERY <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_GET_LIST_QUERY',
							$this->setCustomViewListQuery(
								$view['settings']->main_get, $view['settings']->code
							)
						);

						// SITE_BEFORE_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_BEFORE_GET_ITEMS', CFactory::_('Customcode.Dispenser')->get(
							CFactory::_('Config')->build_target . '_php_before_getitems',
							$view['settings']->code, PHP_EOL, null, true
						));

						// SITE_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_GET_ITEMS',
							$this->setCustomViewGetItems(
								$view['settings']->main_get, $view['settings']->code
							)
						);

						// SITE_AFTER_GET_ITEMS <<<DYNAMIC>>>
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_AFTER_GET_ITEMS',
							CFactory::_('Customcode.Dispenser')->get(
								CFactory::_('Config')->build_target . '_php_after_getitems',
								$view['settings']->code, PHP_EOL, null, true
							)
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
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_CUSTOM_METHODS',
						$this->setCustomViewCustomItemMethods(
							$view['settings']->main_get, $view['settings']->code
						)
					);
					CFactory::_('Compiler.Builder.Content.Multi')->add($view['settings']->code . '|SITE_CUSTOM_METHODS',
						$this->setCustomViewCustomMethods(
							$view, $view['settings']->code
						), false
					);
					// SITE_DIPLAY_METHOD <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_DIPLAY_METHOD',
						$this->setCustomViewDisplayMethod($view)
					);
					// set document details
					$this->setPrepareDocument($view);
					// SITE_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_EXTRA_DIPLAY_METHODS',
						$this->setCustomViewExtraDisplayMethods($view)
					);
					// SITE_CODE_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_CODE_BODY',
						$this->setCustomViewCodeBody($view)
					);
					// SITE_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_BODY',
						$this->setCustomViewBody($view)
					);

					// setup the templates
					$this->setCustomViewTemplateBody($view);

					// set the site form if needed
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_TOP_FORM',
						$this->setCustomViewForm(
							$view['settings']->code,
							$view['settings']->main_get->gettype, 1
						)
					);
					CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_BOTTOM_FORM',
						$this->setCustomViewForm(
							$view['settings']->code,
							$view['settings']->main_get->gettype, 2
						)
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
							CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEW_CONTROLLER_HEADER',
								CFactory::_('Header')->get(
									'site.view.controller', $view['settings']->code
								)
							);
						}
						// SITE_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEW_MODEL_HEADER',
							CFactory::_('Header')->get(
								'site.view.model', $view['settings']->code
							)
						);
						// SITE_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEW_HTML_HEADER',
							CFactory::_('Header')->get(
								'site.view.html', $view['settings']->code
							)
						);
						// SITE_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEW_HEADER',
							CFactory::_('Header')->get(
								'site.view', $view['settings']->code
							)
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
							CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEW_CONTROLLER_HEADER',
								CFactory::_('Header')->get(
									'site.views.controller', $view['settings']->code
								)
							);
						}
						// SITE_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEWS_MODEL_HEADER',
							CFactory::_('Header')->get(
								'site.views.model', $view['settings']->code
							)
						);
						// SITE_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEWS_HTML_HEADER',
							CFactory::_('Header')->get(
								'site.views.html', $view['settings']->code
							)
						);
						// SITE_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
						CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_VIEWS_HEADER',
							CFactory::_('Header')->get(
								'site.views', $view['settings']->code
							)
						);
					}

					// Trigger Event: jcb_ce_onAfterBuildSiteViewContent
					CFactory::_('Event')->trigger(
						'jcb_ce_onAfterBuildSiteViewContent', [&$view, &$view['settings']->code]
					);
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
				if (!CFactory::_('Compiler.Builder.Content.One')->exists('SITE_DEFAULT_VIEW'))
				{
					CFactory::_('Compiler.Builder.Content.One')->set('SITE_DEFAULT_VIEW', '');
				}
				// set site custom script to helper class
				// SITE_CUSTOM_HELPER_SCRIPT
				CFactory::_('Compiler.Builder.Content.One')->set('SITE_CUSTOM_HELPER_SCRIPT',
					CFactory::_('Placeholder')->update_(
					CFactory::_('Customcode.Dispenser')->hub['component_php_helper_site']
				));
				// SITE_GLOBAL_EVENT_HELPER
				if (!CFactory::_('Compiler.Builder.Content.One')->exists('SITE_GLOBAL_EVENT'))
				{
					CFactory::_('Compiler.Builder.Content.One')->set('SITE_GLOBAL_EVENT', '');
				}
				if (!CFactory::_('Compiler.Builder.Content.One')->exists('SITE_GLOBAL_EVENT_HELPER'))
				{
					CFactory::_('Compiler.Builder.Content.One')->set('SITE_GLOBAL_EVENT_HELPER', '');
				}
				// now load the data for the global event if needed
				if (CFactory::_('Component')->get('add_site_event', 0) == 1)
				{
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT', PHP_EOL . PHP_EOL . "//" . Line::_(
							__LINE__,__CLASS__
						) . "Trigger the Global Site Event");
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT',
						PHP_EOL . CFactory::_('Compiler.Builder.Content.One')->get('Component')
						. 'Helper::globalEvent(Factory::getDocument());');
					// SITE_GLOBAL_EVENT_HELPER
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . PHP_EOL . Indent::_(1) . '/**'
					);
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . Indent::_(1)
						. '*	The Global Site Event Method.');
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . Indent::_(1) . '**/'
					);
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . Indent::_(1)
						. 'public static function globalEvent($document)');
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . Indent::_(1) . '{'
					);
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . CFactory::_('Placeholder')->update_(
							CFactory::_('Customcode.Dispenser')->hub['component_php_site_event']
						));
					CFactory::_('Compiler.Builder.Content.One')->add('SITE_GLOBAL_EVENT_HELPER',
						PHP_EOL . Indent::_(1) . '}'
					);
				}
			}

			// PREINSTALLSCRIPT
			CFactory::_('Compiler.Builder.Content.One')->add('PREINSTALLSCRIPT',
				CFactory::_('Customcode.Dispenser')->get(
				'php_preflight', 'install', PHP_EOL, null, true
			));

			// PREUPDATESCRIPT
			CFactory::_('Compiler.Builder.Content.One')->add('PREUPDATESCRIPT',
				CFactory::_('Customcode.Dispenser')->get(
				'php_preflight', 'update', PHP_EOL, null, true
			));

			// POSTINSTALLSCRIPT
			CFactory::_('Compiler.Builder.Content.One')->add('POSTINSTALLSCRIPT', $this->setPostInstallScript());

			// POSTUPDATESCRIPT
			CFactory::_('Compiler.Builder.Content.One')->add('POSTUPDATESCRIPT', $this->setPostUpdateScript());

			// UNINSTALLSCRIPT
			CFactory::_('Compiler.Builder.Content.One')->add('UNINSTALLSCRIPT', $this->setUninstallScript());

			// MOVEFOLDERSSCRIPT
			CFactory::_('Compiler.Builder.Content.One')->set('MOVEFOLDERSSCRIPT', $this->setMoveFolderScript());

			// MOVEFOLDERSMETHOD
			CFactory::_('Compiler.Builder.Content.One')->set('MOVEFOLDERSMETHOD', $this->setMoveFolderMethod());

			// HELPER_UIKIT
			CFactory::_('Compiler.Builder.Content.One')->set('HELPER_UIKIT', $this->setUikitHelperMethods());

			// CONFIG_FIELDSETS
			CFactory::_('Compiler.Builder.Content.One')->set('CONFIG_FIELDSETS',
				implode(PHP_EOL,
					CFactory::_('Compiler.Builder.Config.Fieldsets')->get('component', [])
				)
			);

			// check if this has been set
			if (!CFactory::_('Compiler.Builder.Content.One')->exists('ROUTER_BUILD_VIEWS')
				|| !StringHelper::check(
					CFactory::_('Compiler.Builder.Content.One')->get('ROUTER_BUILD_VIEWS')
				))
			{
				CFactory::_('Compiler.Builder.Content.One')->set('ROUTER_BUILD_VIEWS', 0);
			}
			else
			{
				CFactory::_('Compiler.Builder.Content.One')->set('ROUTER_BUILD_VIEWS',
					'(' . CFactory::_('Compiler.Builder.Content.One')->get('ROUTER_BUILD_VIEWS') . ')'
				);
			}

			// README
			if (CFactory::_('Component')->get('addreadme'))
			{
				CFactory::_('Compiler.Builder.Content.One')->set('README',
					CFactory::_('Component')->get('readme')
				);
			}

			// CHANGELOG
			if (($changelog = CFactory::_('Component')->get('changelog')) !== null)
			{
				CFactory::_('Compiler.Builder.Content.One')->set('CHANGELOG', $changelog);
			}

			// ROUTER
			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				// build route constructor before parent call
				CFactory::_('Compiler.Builder.Content.One')->set('SITE_ROUTER_CONSTRUCTOR_BEFORE_PARENT',
					CFactory::_('Compiler.Creator.Router')->getConstructor()
				);
				// build route constructor after parent call
				CFactory::_('Compiler.Builder.Content.One')->set('SITE_ROUTER_CONSTRUCTOR_AFTER_PARENT',
					CFactory::_('Compiler.Creator.Router')->getConstructorAfterParent()
				);
				// build route methods
				CFactory::_('Compiler.Builder.Content.One')->set('SITE_ROUTER_METHODS',
					CFactory::_('Compiler.Creator.Router')->getMethods()
				);
			}

			// tweak system to set stuff to the module domain
			$_backup_target     = CFactory::_('Config')->build_target;
			$_backup_lang       = CFactory::_('Config')->lang_target;
			$_backup_langPrefix = CFactory::_('Config')->lang_prefix;
			// infuse module data if set
			if (CFactory::_('Joomlamodule.Data')->exists())
			{
				foreach (CFactory::_('Joomlamodule.Data')->get() as $module)
				{
					if (ObjectHelper::check($module))
					{
						// Trigger Event: jcb_ce_onBeforeInfuseModuleData
						CFactory::_('Event')->trigger(
							'jcb_ce_onBeforeInfuseModuleData', [&$module]
						);

						CFactory::_('Config')->build_target = $module->key;
						CFactory::_('Config')->lang_target = $module->key;
						$this->langPrefix = $module->lang_prefix;
						CFactory::_('Config')->set('lang_prefix', $module->lang_prefix);
						// MODCODE
						CFactory::_('Compiler.Builder.Content.Multi')->set($module->key . '|MODCODE',
							$this->getModCode($module)
						);
						// DYNAMICGET
						CFactory::_('Compiler.Builder.Content.Multi')->set($module->key . '|DYNAMICGETS',
							$this->setCustomViewCustomMethods(
								$module, $module->key
							)
						);
						// HELPERCODE
						if ($module->add_class_helper >= 1)
						{
							CFactory::_('Compiler.Builder.Content.Multi')->set($module->key . '|HELPERCODE',
								$this->getModHelperCode($module)
							);
						}
						// MODDEFAULT
						CFactory::_('Compiler.Builder.Content.Multi')->set($module->key . '|MODDEFAULT',
							$this->getModDefault($module, $module->key)
						);
						// MODDEFAULT_XXX
						$this->setModTemplates($module);
						// only add install script if needed
						if ($module->add_install_script)
						{
							// INSTALLCLASS
							CFactory::_('Compiler.Builder.Content.Multi')->set($module->key . '|INSTALLCLASS',
								CFactory::_('Extension.InstallScript')->get($module)
							);
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
										CFactory::_('Compiler.Builder.Content.Multi')->set($module->key .
											'|FIELDSET_' . $file . $field_name . $fieldset,
											$this->getExtensionFieldsetXML(
												$module, $fields
											)
										);
									}
								}
							}
						}
						// MAINXML
						CFactory::_('Compiler.Builder.Content.Multi')->set($module->key . '|MAINXML',
							$this->getModuleMainXML($module)
						);
						// Trigger Event: jcb_ce_onAfterInfuseModuleData
						CFactory::_('Event')->trigger(
							'jcb_ce_onAfterInfuseModuleData', [&$module]
						);
					}
				}
			}
			// infuse plugin data if set
			if (CFactory::_('Joomlaplugin.Data')->exists())
			{
				foreach (CFactory::_('Joomlaplugin.Data')->get() as $plugin)
				{
					if (ObjectHelper::check($plugin))
					{
						// Trigger Event: jcb_ce_onBeforeInfusePluginData
						CFactory::_('Event')->trigger(
							'jcb_ce_onBeforeInfusePluginData', [&$plugin]
						);

						CFactory::_('Config')->build_target = $plugin->key;
						CFactory::_('Config')->lang_target = $plugin->key;
						$this->langPrefix = $plugin->lang_prefix;
						CFactory::_('Config')->set('lang_prefix', $plugin->lang_prefix);
						// MAINCLASS
						CFactory::_('Compiler.Builder.Content.Multi')->set($plugin->key . '|MAINCLASS',
							$this->getPluginMainClass($plugin)
						);
						// only add install script if needed
						if ($plugin->add_install_script)
						{
							// INSTALLCLASS
							CFactory::_('Compiler.Builder.Content.Multi')->set($plugin->key . '|INSTALLCLASS',
								CFactory::_('Extension.InstallScript')->get($plugin)
							);
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
										CFactory::_('Compiler.Builder.Content.Multi')->set($plugin->key .
											'|FIELDSET_' . $file . $field_name . $fieldset,
											$this->getExtensionFieldsetXML(
												$plugin, $fields
											)
										);
									}
								}
							}
						}
						// MAINXML
						CFactory::_('Compiler.Builder.Content.Multi')->set($plugin->key . '|MAINXML',
							$this->getPluginMainXML($plugin)
						);
						// Trigger Event: jcb_ce_onAfterInfusePluginData
						CFactory::_('Event')->trigger(
							'jcb_ce_onAfterInfusePluginData', [&$plugin]
						);
					}
				}
			}
			// rest globals
			CFactory::_('Config')->build_target = $_backup_target;
			CFactory::_('Config')->lang_target = $_backup_lang;
			$this->langPrefix = $_backup_langPrefix;
			CFactory::_('Config')->set('lang_prefix', $_backup_langPrefix);

			// Trigger Event: jcb_ce_onAfterBuildFilesContent
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterBuildFilesContent'
			);
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
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|view', $nameSingleCode);
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|VIEW', $name_single_uppercase);
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|View', $name_single_first_uppercase);

			if (isset($nameListCode))
			{
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|view', $nameSingleCode);
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|VIEW', $name_single_uppercase);
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|View', $name_single_first_uppercase);
			}
		}

		// views <<<DYNAMIC>>>
		if (isset($nameListCode))
		{
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|views', $nameListCode);
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|VIEWS', $name_list_uppercase);
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|Views', $name_list_first_uppercase);

			if (isset($nameSingleCode))
			{
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|views', $nameListCode);
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|VIEWS', $name_list_uppercase);
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|Views', $name_list_first_uppercase);
			}
		}
	}

	/**
	 * Build the language values and insert into file
	 *
	 * @return  void
	 */
	public function setLangFileData(): void
	{
		// add final list of needed lang strings
		$componentName = CFactory::_('Component')->get('name');
		$componentName = OutputFilter::cleanText($componentName);

		// Trigger Event: jcb_ce_onBeforeLoadingAllLangStrings
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeLoadingAllLangStrings', [&$componentName]
		);

		// reset values
		$values         = [];
		$mainLangLoader = [];
		// check the admin lang is set
		if ($this->setLangAdmin($componentName))
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
			&& $this->setLangSite($componentName))
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
			&& $this->setLangSiteSys($componentName))
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
		$getPAth = CFactory::_('Utilities.Paths')->template_path . '/en-GB.com_admin.ini';

		// Trigger Event: jcb_ce_onBeforeBuildAllLangFiles
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeBuildAllLangFiles', [&$this->languages['components']]
		);

		// now we insert the values into the files
		if (ArrayHelper::check($this->languages['components']))
		{
			// rest xml array
			$langXML = [];
			foreach ($this->languages['components'] as $tag => $areas)
			{
				// trim the tag
				$tag = trim((string) $tag);
				foreach ($areas as $area => $languageStrings)
				{
					// set naming convention
					$p = 'admin';
					$t = '';
					if (strpos((string) $area, 'site') !== false)
					{
						if (CFactory::_('Config')->remove_site_folder
							&& CFactory::_('Config')->remove_site_edit_folder)
						{
							continue;
						}
						$p = 'site';
					}
					if (strpos((string) $area, 'sys') !== false)
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
						$path = CFactory::_('Utilities.Paths')->component_path . '/' . $p . '/language/'
							. $tag . '/';
						if (!Folder::exists($path))
						{
							Folder::create($path);
							// count the folder created
							CFactory::_('Utilities.Counter')->folder++;
						}
						// move the file to its place
						File::copy($getPAth, $path . $file_name);
						// count the file created
						CFactory::_('Utilities.Counter')->file++;
						// add content to it
						$lang = array_map(
							fn($langstring, $placeholder) => $placeholder . '="' . $langstring . '"',
							array_values($languageStrings),
							array_keys($languageStrings)
						);
						// add to language file
						CFactory::_('Utilities.File')->write(
							$path . $file_name, implode(PHP_EOL, $lang)
						);
						// set the line counter
						CFactory::_('Utilities.Counter')->line += count(
								(array) $lang
							);
						unset($lang);
						// build xml strings
						if (!isset($langXML[$p]))
						{
							$langXML[$p] = [];
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
				$replace = [];
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
				$xmlPath = CFactory::_('Utilities.Paths')->component_path . '/' . CFactory::_('Config')->component_code_name
					. '.xml';
				// get the content in xml
				$componentXML = FileHelper::getContent(
					$xmlPath
				);
				// update the xml content
				$componentXML = CFactory::_('Placeholder')->update($componentXML, $replace);
				// store the values back to xml
				CFactory::_('Utilities.File')->write($xmlPath, $componentXML);
			}
		}
	}
}
