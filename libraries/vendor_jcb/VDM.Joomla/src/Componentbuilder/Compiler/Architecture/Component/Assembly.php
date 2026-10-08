<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\ComHelperClass\CryptKey;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\LicenseLock;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\UninstallSql;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Controller\AjaxTasks;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Dashboard\Icons;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Dashboard\ModelMethods;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Menu\SubMenus;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\AjaxMethods;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Contributors;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomAdminAdded;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionDashboard;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Extension\VersionUpdate;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\ComHelperClass\ExcelMethodsInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\InstallSqlInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AjaxCasesInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowEditViewsInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Dashboard\ViewInterface as DashboardViewInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Menu\MainMenusInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;


/**
 * Component Assembly Class.
 * 
 * Fills in everything the component needs once its views are built and before
 * its site views are: the headers each generated file opens with, the arrays
 * that name every view to the component, its menus, its install and uninstall
 * sql, its dashboard, its importer, its ajax, and the rules its forms validate
 * against.
 * 
 * It runs between the two halves of the build, so what it reads is what the
 * admin views left behind and what the site views are about to read.
 * 
 * @since 6.1.7
 */
final class Assembly
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Header Class.
	 *
	 * @var   HeaderInterface
	 * @since 6.1.7
	 */
	protected HeaderInterface $header;

	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Component LicenseLock Class.
	 *
	 * @var   LicenseLock
	 * @since 6.1.7
	 */
	protected LicenseLock $licenselock;

	/**
	 * The Compiler Registry Class.
	 *
	 * @var   Registry
	 * @since 6.1.7
	 */
	protected Registry $registry;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The Controller AjaxCases Class.
	 *
	 * @var   AjaxCasesInterface
	 * @since 6.1.7
	 */
	protected AjaxCasesInterface $ajaxcases;

	/**
	 * The Dashboard Icons Class.
	 *
	 * @var   Icons
	 * @since 6.1.7
	 */
	protected Icons $dashboardicons;

	/**
	 * The ComHelperClass CryptKey Class.
	 *
	 * @var   CryptKey
	 * @since 6.1.7
	 */
	protected CryptKey $cryptkey;

	/**
	 * The ComHelperClass ExcelMethods Class.
	 *
	 * @var   ExcelMethodsInterface
	 * @since 6.1.7
	 */
	protected ExcelMethodsInterface $excelmethods;

	/**
	 * The Component InstallSql Class.
	 *
	 * @var   InstallSqlInterface
	 * @since 6.1.7
	 */
	protected InstallSqlInterface $installsql;

	/**
	 * The Component UninstallSql Class.
	 *
	 * @var   UninstallSql
	 * @since 6.1.7
	 */
	protected UninstallSql $uninstallsql;

	/**
	 * The Menu MainMenus Class.
	 *
	 * @var   MainMenusInterface
	 * @since 6.1.7
	 */
	protected MainMenusInterface $mainmenus;

	/**
	 * The Menu SubMenus Class.
	 *
	 * @var   SubMenus
	 * @since 6.1.7
	 */
	protected SubMenus $submenus;

	/**
	 * The Extension VersionUpdate Class.
	 *
	 * @var   VersionUpdate
	 * @since 6.1.7
	 */
	protected VersionUpdate $versionupdate;

	/**
	 * The Dashboard ModelMethods Class.
	 *
	 * @var   ModelMethods
	 * @since 6.1.7
	 */
	protected ModelMethods $dashboardmodelmethods;

	/**
	 * The Model AjaxMethods Class.
	 *
	 * @var   AjaxMethods
	 * @since 6.1.7
	 */
	protected AjaxMethods $ajaxmethods;

	/**
	 * The Controller AjaxTasks Class.
	 *
	 * @var   AjaxTasks
	 * @since 6.1.7
	 */
	protected AjaxTasks $ajaxtasks;

	/**
	 * The Custom Admin Added Builder Class.
	 *
	 * @var   CustomAdminAdded
	 * @since 6.1.7
	 */
	protected CustomAdminAdded $customadminadded;

	/**
	 * The Contributors Builder Class.
	 *
	 * @var   Contributors
	 * @since 6.1.7
	 */
	protected Contributors $contributors;

	/**
	 * The Permission Dashboard Builder Class.
	 *
	 * @var   PermissionDashboard
	 * @since 6.1.7
	 */
	protected PermissionDashboard $permissiondashboard;

	/**
	 * The Controller AllowEditViews Class.
	 *
	 * @var   AllowEditViewsInterface
	 * @since 6.1.7
	 */
	protected AllowEditViewsInterface $alloweditviews;

	/**
	 * The Dashboard View Class.
	 *
	 * @var   DashboardViewInterface
	 * @since 6.1.7
	 */
	protected DashboardViewInterface $dashboardview;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * Constructor.
	 *
	 * @param Config                  $config                      The Config Class.
	 * @param HeaderInterface         $header                      The Header Class.
	 * @param ContentOne              $contentone                  The Content One Builder Class.
	 * @param ContentMulti            $contentmulti                The Content Multi Builder Class.
	 * @param LicenseLock             $licenselock                 The Component LicenseLock Class.
	 * @param Registry                $registry                    The Compiler Registry Class.
	 * @param Placeholder             $placeholder                 The Placeholder Class.
	 * @param AjaxCasesInterface      $ajaxcases                   The Controller AjaxCases Class.
	 * @param Icons                   $dashboardicons              The Dashboard Icons Class.
	 * @param CryptKey                $cryptkey                    The ComHelperClass CryptKey Class.
	 * @param ExcelMethodsInterface   $excelmethods                The ComHelperClass ExcelMethods Class.
	 * @param InstallSqlInterface     $installsql                  The Component InstallSql Class.
	 * @param UninstallSql            $uninstallsql                The Component UninstallSql Class.
	 * @param MainMenusInterface      $mainmenus                   The Menu MainMenus Class.
	 * @param SubMenus                $submenus                    The Menu SubMenus Class.
	 * @param VersionUpdate           $versionupdate               The Extension VersionUpdate Class.
	 * @param ModelMethods            $dashboardmodelmethods       The Dashboard ModelMethods Class.
	 * @param AjaxMethods             $ajaxmethods                 The Model AjaxMethods Class.
	 * @param AjaxTasks               $ajaxtasks                   The Controller AjaxTasks Class.
	 * @param CustomAdminAdded        $customadminadded            The Custom Admin Added Builder Class.
	 * @param Contributors            $contributors                The Contributors Builder Class.
	 * @param PermissionDashboard     $permissiondashboard         The Permission Dashboard Builder Class.
	 * @param AllowEditViewsInterface $alloweditviews              The Controller AllowEditViews Class.
	 * @param DashboardViewInterface  $dashboardview               The Dashboard View Class.
	 * @param Structure               $structure                   The Structure Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		HeaderInterface $header,
		ContentOne $contentone,
		ContentMulti $contentmulti,
		LicenseLock $licenselock,
		Registry $registry,
		Placeholder $placeholder,
		AjaxCasesInterface $ajaxcases,
		Icons $dashboardicons,
		CryptKey $cryptkey,
		ExcelMethodsInterface $excelmethods,
		InstallSqlInterface $installsql,
		UninstallSql $uninstallsql,
		MainMenusInterface $mainmenus,
		SubMenus $submenus,
		VersionUpdate $versionupdate,
		ModelMethods $dashboardmodelmethods,
		AjaxMethods $ajaxmethods,
		AjaxTasks $ajaxtasks,
		CustomAdminAdded $customadminadded,
		Contributors $contributors,
		PermissionDashboard $permissiondashboard,
		AllowEditViewsInterface $alloweditviews,
		DashboardViewInterface $dashboardview,
		Structure $structure)
	{
		$this->config = $config;
		$this->header = $header;
		$this->contentone = $contentone;
		$this->contentmulti = $contentmulti;
		$this->licenselock = $licenselock;
		$this->registry = $registry;
		$this->placeholder = $placeholder;
		$this->ajaxcases = $ajaxcases;
		$this->dashboardicons = $dashboardicons;
		$this->cryptkey = $cryptkey;
		$this->excelmethods = $excelmethods;
		$this->installsql = $installsql;
		$this->uninstallsql = $uninstallsql;
		$this->mainmenus = $mainmenus;
		$this->submenus = $submenus;
		$this->versionupdate = $versionupdate;
		$this->dashboardmodelmethods = $dashboardmodelmethods;
		$this->ajaxmethods = $ajaxmethods;
		$this->ajaxtasks = $ajaxtasks;
		$this->customadminadded = $customadminadded;
		$this->contributors = $contributors;
		$this->permissiondashboard = $permissiondashboard;
		$this->alloweditviews = $alloweditviews;
		$this->dashboardview = $dashboardview;
		$this->structure = $structure;
	}

	/**
	 * Fill in what the component needs once its views are built.
	 *
	 * @param   array  $viewarray             Every admin view, by its two names.
	 * @param   array  $site_edit_view_array  Every view the site may edit.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function build(array $viewarray, array $site_edit_view_array): void
	{
	// ADMIN_HELPER_CLASS_HEADER
	$this->contentone->set('ADMIN_HELPER_CLASS_HEADER',
		$this->header->get(
		'admin.helper', 'admin'
	));

	// ADMIN_COMPONENT_HEADER
	$this->contentone->set('ADMIN_COMPONENT_HEADER',
		$this->header->get(
		'admin.component', 'admin'
	));

	// SITE_HELPER_CLASS_HEADER
	$this->contentone->set('SITE_HELPER_CLASS_HEADER',
		$this->header->get(
		'site.helper', 'site'
	));

	// SITE_COMPONENT_HEADER
	$this->contentone->set('SITE_COMPONENT_HEADER',
		$this->header->get(
		'site.component', 'site'
	));

	// SITE_ROUTER_HEADER (Joomla 4 and above)
	$this->contentone->set('SITE_ROUTER_HEADER',
		$this->header->get(
			'site.router', 'site'
	));

	// HELPER_EXEL
	$this->contentone->set('HELPER_EXEL', $this->excelmethods->get());

	// VIEWARRAY
	$this->contentone->set('VIEWARRAY',
		PHP_EOL . implode("," . PHP_EOL, $viewarray)
	);

	// SITE_EDIT_VIEW_ARRAY (Joomla3 only)
	$this->contentone->set('SITE_EDIT_VIEW_ARRAY',
		PHP_EOL . Indent::_(4) . "'" . implode("'," . PHP_EOL . Indent::_(4) . "'", array_keys($site_edit_view_array)) . "'"
	);

	// SITE_ALLOW_EDIT_VIEWS_ARRAY
	$this->contentone->set('SITE_ALLOW_EDIT_VIEWS_ARRAY',
		$this->alloweditviews->getArray($site_edit_view_array)
	);

	// SITE_ALLOW_EDIT_VIEWS_FUNCTIONS
	$this->contentone->set('SITE_ALLOW_EDIT_VIEWS_FUNCTIONS',
		$this->alloweditviews->getFunctions($site_edit_view_array)
	);

	// MAINMENUS
	$this->contentone->set('MAINMENUS', $this->mainmenus->get());

	// SUBMENU
	$this->contentone->set('SUBMENU', $this->submenus->get());

	// GET_CRYPT_KEY
	$this->contentone->set('GET_CRYPT_KEY', $this->cryptkey->get());

	// set the license locker
	$this->licenselock->set();

	// CONTRIBUTORS
	$this->contentone->set('CONTRIBUTORS',
		$this->contributors->get('bom', '')
	);

	// INSTALL
	$this->contentone->set('INSTALL', $this->installsql->get());

	// UNINSTALL
	$this->contentone->set('UNINSTALL', $this->uninstallsql->get());

	// UPDATE_VERSION_MYSQL
	$this->versionupdate->set();

	// only set these if default dashboard it used
	if (!$this->registry->get('build.dashboard'))
	{
		// DASHBOARDVIEW
		$this->contentone->set('DASHBOARDVIEW',
			$this->config->component_code_name
		);

		// DASHBOARDICONS
		$this->contentmulti->set($this->config->component_code_name . '|DASHBOARDICONS',
			$this->dashboardicons->get(
				$this->customadminadded->allActive()
			)
		);

		// DASHBOARDICONACCESS
		$this->contentmulti->set($this->config->component_code_name . '|DASHBOARDICONACCESS',
			$this->permissiondashboard->build()
		);

		// DASH_MODEL_METHODS
		$this->contentmulti->set($this->config->component_code_name . '|DASH_MODEL_METHODS',
			$this->dashboardmodelmethods->get()
		);

		// DASH_GET_CUSTOM_DATA
		$this->contentmulti->set($this->config->component_code_name . '|DASH_GET_CUSTOM_DATA',
			$this->dashboardmodelmethods->customData()
		);

		// DASH_DISPLAY_DATA
		$this->contentmulti->set($this->config->component_code_name . '|DASH_DISPLAY_DATA',
			$this->dashboardview->get()
		);

		// DASH_VIEW_HEADER
		$this->contentmulti->set($this->config->component_code_name . '|DASH_VIEW_HEADER',
			$this->header->get('dashboard.view', 'dashboard')
		);
		// DASH_VIEW_HTML_HEADER
		$this->contentmulti->set($this->config->component_code_name . '|DASH_VIEW_HTML_HEADER',
			$this->header->get('dashboard.view.html', 'dashboard')
		);
		// DASH_MODEL_HEADER
		$this->contentmulti->set($this->config->component_code_name . '|DASH_MODEL_HEADER',
			$this->header->get('dashboard.model', 'dashboard')
		);
		// DASH_CONTROLLER_HEADER
		$this->contentmulti->set($this->config->component_code_name . '|DASH_CONTROLLER_HEADER',
			$this->header->get('dashboard.controller', 'dashboard')
		);
	}
	else
	{
		// DASHBOARDVIEW
		$this->contentone->set('DASHBOARDVIEW',
			$this->registry->get('build.dashboard')
		);
	}

	// add import
	if ($this->config->get('add_eximport', false))
	{
		// setup import files
		$target = array('admin' => 'import');
		$this->structure->build($target, 'import');
		// IMPORT_EXT_METHOD <<<DYNAMIC>>>
		$this->contentmulti->set('import' . '|IMPORT_EXT_METHOD',
			PHP_EOL . PHP_EOL . $this->placeholder->update_(
				ComponentbuilderHelper::getDynamicScripts('ext')
			)
		);
		// IMPORT_SETDATA_METHOD <<<DYNAMIC>>>
		$this->contentmulti->set('import' . '|IMPORT_SETDATA_METHOD',
			PHP_EOL . PHP_EOL . $this->placeholder->update_(
				ComponentbuilderHelper::getDynamicScripts('setdata')
			)
		);
		// IMPORT_SAVE_METHOD <<<DYNAMIC>>>
		$this->contentmulti->set('import' . '|IMPORT_SAVE_METHOD',
			PHP_EOL . PHP_EOL . $this->placeholder->update_(
				ComponentbuilderHelper::getDynamicScripts('save')
			)
		);
		// IMPORT_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
		$this->contentmulti->set('import' . '|IMPORT_CONTROLLER_HEADER',
			$this->header->get(
				'import.controller', 'import'
			)
		);
		// IMPORT_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
		$this->contentmulti->set('import' . '|IMPORT_MODEL_HEADER',
			$this->header->get(
				'import.model', 'import'
			)
		);
	}

	// ensure that the ajax model and controller is set if needed
	if ($this->config->get('add_ajax', false))
	{
		// setup Ajax files
		$target = array('admin' => 'ajax');
		$this->structure->build($target, 'ajax');
		// set the controller
		$this->contentmulti->set('ajax' . '|REGISTER_AJAX_TASK',
			$this->ajaxtasks->get('admin')
		);
		$this->contentmulti->set('ajax' . '|AJAX_INPUT_RETURN',
			$this->ajaxcases->get('admin')
		);
		// set the model header
		$this->contentmulti->set('ajax' . '|AJAX_ADMIN_MODEL_HEADER',
			$this->header->get('ajax.admin.model', 'ajax')
		);
		// set the module
		$this->contentmulti->set('ajax' . '|AJAX_MODEL_METHODS',
			$this->ajaxmethods->get('admin')
		);
	}

	// ensure that the site ajax model and controller is set if needed
	if ($this->config->get('add_site_ajax', false))
	{
		// setup Ajax files
		$target = array('site' => 'ajax');
		$this->structure->build($target, 'ajax');
		// set the controller
		$this->contentmulti->set('ajax' . '|REGISTER_SITE_AJAX_TASK',
			$this->ajaxtasks->get('site')
		);
		$this->contentmulti->set('ajax' . '|AJAX_SITE_INPUT_RETURN',
			$this->ajaxcases->get('site')
		);
		// set the model header
		$this->contentmulti->set('ajax' . '|AJAX_SITE_MODEL_HEADER',
			$this->header->get('ajax.site.model', 'ajax')
		);
		// set the module
		$this->contentmulti->set('ajax' . '|AJAX_SITE_MODEL_METHODS',
			$this->ajaxmethods->get('site')
		);
	}

	// build the validation rules
	if (($validationRules = $this->registry->_('validation.rules')) !== null)
	{
		foreach ($validationRules as $rule => $_php)
		{
			// setup rule file
			$target = array('admin' => 'a_rule_zi');
			$this->structure->build($target, 'rule', $rule);
			// set the JFormRule Name
			$this->contentmulti->set('a_rule_zi_' . $rule . '|Name',
				ucfirst((string) $rule)
			);
			// set the JFormRule PHP
			$this->contentmulti->set('a_rule_zi_' . $rule . '|VALIDATION_RULE_METHODS',
				PHP_EOL . $_php
			);
		}
	}
	}
}

