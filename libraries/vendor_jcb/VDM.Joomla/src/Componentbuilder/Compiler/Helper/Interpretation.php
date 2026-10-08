<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Helper;


use Joomla\Filesystem\File;
use Joomla\Filesystem\Folder;
use Joomla\CMS\Language\Text;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\CMS\Form\Form;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\MathHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Minify;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;
use VDM\Joomla\Componentbuilder\Compiler\Helper\Fields;


/**
 * Interpretation class
 * 
 * @deprecated 3.3
 */
class Interpretation extends Fields
{
	/**
	 * The Import & Export View
	 *
	 * @since 3.2.0
	 * @var      array
	 */
	public $eximportView = [];

	/**
	 * The Import & Export Custom Script
	 *
	 * @since 3.2.0
	 * @var      array
	 */
	public $importCustomScripts = [];

	/**
	 * The contributors
	 *
	 * @since 3.2.0
	 * @var    string
	 */
	public $theContributors = '';

	/**
	 * The unistall script builder
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $uninstallScriptBuilder = [];

	/**
	 * The unistall script fields
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $uninstallScriptFields = [];

	/**
	 * The unistall script content
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $uninstallScriptContent = [];

	/**
	 * The last update url
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $lastupdateURL;

	/**
	 * The List Column Builder
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $listColnrBuilder = [];

	/**
	 * The customs field builder
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $customFieldBuilder = [];

	/**
	 * The category builder
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $buildCategories = [];

	/**
	 * The icon builder
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $iconBuilder = [];

	/**
	 * The validation fix builder
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $validationFixBuilder = [];

	/**
	 * The view script builder
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $viewScriptBuilder = [];

	/**
	 * The target relation control
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $targetRelationControl = [];

	/**
	 * The target control script checker
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $targetControlsScriptChecker = [];

	/**
	 * The router helper
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $setRouterHelpDone = [];

	/**
	 * The other where
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $otherWhere = [];

	/**
	 * The dashboard get custom data
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $DashboardGetCustomData = [];

	/**
	 * The custom admin added
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	public $customAdminAdded = [];

	/**
	 * Custom Admin View List Link
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	protected $customAdminViewListLink = [];

	/**
	 * Custom Admin View List Id
	 *
	 * @var    array
	 * @since  6.1.7
	 */
	protected $customAdminViewListId = [];

	/**
	 * load Tracker of fields to fix
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	protected $loadTracker = [];

	/**
	 * alignment names
	 *
	 * @since 3.2.0
	 * @var    array
	 */
	protected $alignmentOptions
		= array(1 => 'left', 2 => 'right', 3 => 'fullwidth', 4 => 'above',
			5 => 'under', 6 => 'leftside', 7 => 'rightside');

	/**
	 * Constructor
	 *
	 * @since 3.2.0
	 */
	public function __construct()
	{
		// first we run the parent constructor
		if (parent::__construct())
		{
			return true;
		}

		return false;
	}

	/**
	 * set the lock license
	 *
	 * @deprecated 6.1.7 Use the Architecture.Component.LicenseLock service.
	 *
	 * @since 3.2.0
	 */
	public function setLockLicense()
	{
		CFactory::_('Architecture.Component.LicenseLock')->set();
	}

	/**
	 * set Lock License Per
	 *
	 * @param   string  $view
	 * @param   string  $target
	 *
	 * @deprecated 6.1.7 Use the Architecture.Component.LicenseLock service.
	 *
	 * @since 3.2.0
	 */
	public function setLockLicensePer(&$view, $target)
	{
		CFactory::_('Architecture.Component.LicenseLock')->setView($view);
	}

	/**
	 * Check statment license locked
	 *
	 * @param   type  $boolMethod
	 * @param   type  $thIIS
	 *
	 * @return string
	 *
	 * @since 3.2.0
	 */
	public function checkStatmentLicenseLocked($boolMethod, $thIIS = '$this')
	{
		return CFactory::_('Architecture.Component.LicenseLock')
			->checkStatement($boolMethod, $thIIS);
	}

	/**
	 * set Bool License Lock
	 *
	 * @param   type  $boolMethod
	 * @param   type  $globalbool
	 *
	 * @return string
	 *
	 * @since 3.2.0
	 */
	public function setBoolLicenseLock($boolMethod, $globalbool)
	{
		return CFactory::_('Architecture.Component.LicenseLock')
			->boolMethod($boolMethod, $globalbool);
	}

	/**
	 * set Helper License Lock
	 *
	 * @param   type  $_WHMCS
	 * @param   type  $target
	 *
	 * @return string
	 *
	 * @since 3.2.0
	 */
	public function setHelperLicenseLock($_WHMCS, $target)
	{
		return CFactory::_('Architecture.Component.LicenseLock')
			->helperMethod();
	}

	/**
	 * set Init License Lock
	 *
	 * @param   type  $_WHMCS
	 *
	 * @return string
	 *
	 * @since 3.2.0
	 */
	public function setInitLicenseLock($_WHMCS)
	{
		return CFactory::_('Architecture.Component.LicenseLock')
			->initLock($_WHMCS);
	}

	/**
	 * set WHMCS Cryption
	 *
	 * @return string
	 *
	 * @since 3.2.0
	 */
	public function setWHMCSCryption()
	{
		return CFactory::_('Architecture.Component.Whmcs')->get();
	}

	/**
	 * set Get Crypt Key
	 *
	 * @return string
	 *
	 * @since 3.2.0
	 */
	public function setGetCryptKey()
	{
		return CFactory::_('Architecture.ComHelperClass.CryptKey')->get();
	}

	/**
	 * set Version Controller
	 *
	 * @since 3.2.0
	 */
	public function setVersionController()
	{
		$versionUpdate = CFactory::_('Extension.VersionUpdate');
		$versionUpdate->setLastUpdateUrl(
			is_string($this->lastupdateURL) ? $this->lastupdateURL : null
		);
		$versionUpdate->set();
		$this->lastupdateURL = $versionUpdate->getLastUpdateUrl();
	}

	/**
	 * set Dynamic Update XML SQL
	 *
	 * @param   array  $updateXML
	 * @param   bool   $current_version
	 *
	 * @since 3.2.0
	 */
	public function setDynamicUpdateXMLSQL(&$updateXML, $current_version = false)
	{
		$versionUpdate = CFactory::_('Extension.VersionUpdate');
		$versionUpdate->setLastUpdateUrl(
			is_string($this->lastupdateURL) ? $this->lastupdateURL : null
		);
		$versionUpdate->setDynamicUpdateXmlSql($updateXML, (bool) $current_version);
		$this->lastupdateURL = $versionUpdate->getLastUpdateUrl();
	}

	/**
	 * set Update XML SQL
	 *
	 * @param   array    $update
	 * @param   array    $updateXML
	 * @param   boolean  $addDynamicSQL
	 *
	 * @since 3.2.0
	 */
	public function setUpdateXMLSQL(&$update, &$updateXML, &$addDynamicSQL)
	{
		$versionUpdate = CFactory::_('Extension.VersionUpdate');
		$versionUpdate->setLastUpdateUrl(
			is_string($this->lastupdateURL) ? $this->lastupdateURL : null
		);
		$versionUpdate->setUpdateXmlSql($update, $updateXML, $addDynamicSQL);
		$this->lastupdateURL = $versionUpdate->getLastUpdateUrl();
	}

	/**
	 * set the helper excel methods
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.ComHelperClass.ExcelMethods service.
	 */
	public function setHelperExelMethods()
	{
		return CFactory::_('Architecture.ComHelperClass.ExcelMethods')->get();
	}

	/**
	 * set the admin view site menu xml
	 *
	 * @param   string  $nameSingleCode
	 * @param   array   $view
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Menu.AdminView service.
	 */
	public function setAdminViewMenu(&$nameSingleCode, &$view)
	{
		return CFactory::_('Architecture.Menu.AdminView')
			->get($nameSingleCode, $view);
	}

	/**
	 * set the custom view menu xml
	 *
	 * @param   array  $view
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Menu.CustomView service.
	 */
	public function setCustomViewMenu(&$view)
	{
		return CFactory::_('Architecture.Menu.CustomView')->get($view);
	}

	/**
	 * setup the frontend param fields
	 *
	 * @param   array   $params
	 * @param   string  $view
	 *
	 * @return  array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Menu.CustomView service.
	 */
	public function setupFrontendParamFields($params, $view)
	{
		return CFactory::_('Architecture.Menu.CustomView')
			->params($params, $view);
	}

	/**
	 * Set the access check of a view.
	 *
	 * @param   array   $view  The view definition.
	 * @param   string  $type  The kind of view.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.ComHelperClass.UserPermissionCheckAccess instead.
	 */
	public function setUserPermissionCheckAccess($view, $type)
	{
		return CFactory::_('Architecture.ComHelperClass.UserPermissionCheckAccess')
			->get($view, $type);
	}

	/**
	 * set the uikit helper methods
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.ComHelperClass.UikitMethods service.
	 */
	public function setUikitHelperMethods()
	{
		return CFactory::_('Architecture.ComHelperClass.UikitMethods')->get();
	}

	/**
	 * build code for the admin view display method
	 *
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 * @since 3.2.0
	 */
	public function setAdminViewDisplayMethod($nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.DisplayMethod')
			->get($nameListCode);
	}

	/**
	 * build code for the custom view display method
	 *
	 * @param   array  $view  The view data
	 *
	 * @return  string The php to place in the view display method
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.CustomView.DisplayMethod service.
	 */
	public function setCustomViewDisplayMethod(&$view)
	{
		return CFactory::_('Architecture.CustomView.DisplayMethod')->get($view);
	}

	/**
	 * Set the prepare document method of a view.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.PrepareDocument instead.
	 */
	public function setPrepareDocument(&$view)
	{
		CFactory::_('Architecture.View.PrepareDocument')->set($view);
	}

	/**
	 * Set the module loader of a view.
	 *
	 * @param   array   $view    The view definition.
	 * @param   string  $TARGET  The upper case build target of the view.
	 *
	 * @return  string  The generated module loader.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.GetModules instead.
	 */
	public function setGetModules($view, $TARGET)
	{
		return CFactory::_('Architecture.View.GetModules')->get($view, $TARGET);
	}

	/**
	 * Set the custom php a view runs when it prepares its document.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated php.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.DocumentCustomPHP instead.
	 */
	public function setDocumentCustomPHP(&$view)
	{
		return CFactory::_('Architecture.View.DocumentCustomPHP')->get($view);
	}

	/**
	 * Set the stylesheet of a view.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated stylesheet.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.CustomCSS instead.
	 */
	public function setCustomCSS(&$view)
	{
		return CFactory::_('Architecture.View.CustomCSS')->get($view);
	}

	/**
	 * Set the inline stylesheet a view adds to its document.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated statement.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.DocumentInlineAssets instead.
	 */
	public function setDocumentCustomCSS(&$view)
	{
		return CFactory::_('Architecture.View.DocumentInlineAssets')->css($view);
	}

	/**
	 * Set the script file of a view.
	 *
	 * @param   array   $view    The view definition.
	 * @param   string  $TARGET  The upper case build target of the view.
	 *
	 * @return  string  The generated statement.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.JavaScriptFile instead.
	 */
	public function setJavaScriptFile(&$view, $TARGET)
	{
		return CFactory::_('Architecture.View.JavaScriptFile')->get($view, $TARGET);
	}

	/**
	 * Set the inline script a view adds to its document.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated statement.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.DocumentInlineAssets instead.
	 */
	public function setDocumentCustomJS(&$view)
	{
		return CFactory::_('Architecture.View.DocumentInlineAssets')->js($view);
	}

	/**
	 * Set the footable scripts a view loads.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.FootableScriptsLoader instead.
	 */
	public function setFootableScriptsLoader(&$view)
	{
		return CFactory::_('Architecture.View.FootableScriptsLoader')->get($view);
	}

	/**
	 * Set the document metadata of a view.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated metadata statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.DocumentMetadata instead.
	 */
	public function setDocumentMetadata(&$view)
	{
		return CFactory::_('Architecture.View.DocumentMetadata')->get($view);
	}

	/**
	 * Set the google chart assets a view loads.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.GoogleChartLoader instead.
	 */
	public function setGoogleChartLoader(&$view)
	{
		return CFactory::_('Architecture.View.GoogleChartLoader')->get($view);
	}

	/**
	 * Set the libraries a view loads.
	 *
	 * @param   mixed  $view  The view definition, or the module asking for them.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.LibrariesLoader instead.
	 */
	public function setLibrariesLoader($view)
	{
		return CFactory::_('Architecture.View.LibrariesLoader')->get($view);
	}

	/**
	 * Build the statements that load the uikit assets a view needs.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.View.UikitLoader service.
	 */
	public function setUikitLoader(&$view)
	{
		return CFactory::_('Architecture.View.UikitLoader')->get($view);
	}

	/**
	 * Set the extra display methods a custom view was given.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated methods.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.CustomView.ExtraDisplayMethods instead.
	 */
	public function setCustomViewExtraDisplayMethods(&$view)
	{
		return CFactory::_('Architecture.CustomView.ExtraDisplayMethods')
			->get($view);
	}

	/**
	 * Set the body of a custom view.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated body.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.CustomView.Body instead.
	 */
	public function setCustomViewBody(&$view)
	{
		return CFactory::_('Architecture.CustomView.Body')->get($view);
	}

	/**
	 * Set the form a custom view is wrapped in.
	 *
	 * @param   string  $view     The view name.
	 * @param   int     $gettype  What the main get method of the view returns.
	 * @param   int     $type     Which half of the form is wanted.
	 *
	 * @return  string  The generated markup.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.CustomView.Form instead.
	 */
	public function setCustomViewForm(&$view, &$gettype, $type)
	{
		return CFactory::_('Architecture.CustomView.Form')->get($view, $gettype, $type);
	}

	/**
	 * Set the submit button script of a custom view.
	 *
	 * @param   array $view  The view definition.
	 *
	 * @return  string  The generated script.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.CustomView.SubmitButtonScript instead.
	 */
	public function setCustomViewSubmitButtonScript(&$view)
	{
		return CFactory::_('Architecture.CustomView.SubmitButtonScript')
			->get($view);
	}

	/**
	 * Set the php a custom view was drawn with.
	 *
	 * @param   array $view  The view definition.
	 *
	 * @return  string  The generated php.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.CustomView.CodeBody instead.
	 */
	public function setCustomViewCodeBody(&$view)
	{
		return CFactory::_('Architecture.CustomView.CodeBody')->get($view);
	}

	/**
	 * Set the templates a custom view was drawn with.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.CustomView.TemplateBody instead.
	 */
	public function setCustomViewTemplateBody(&$view)
	{
		CFactory::_('Architecture.CustomView.TemplateBody')->set($view);
	}



	/**
	 * Set the layouts of the build target.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.CustomView.Layouts instead.
	 */
	public function setCustomViewLayouts()
	{
		CFactory::_('Architecture.CustomView.Layouts')->set();
	}

	/**
	 * Get the names the compiler replaces in the generated code.
	 *
	 * @return  array  The names.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Placeholder.ReplacementNames instead.
	 */
	public function getReplacementNames()
	{
		return CFactory::_('Placeholder.ReplacementNames')->get();
	}

	/**
	 * Set the getItem method of an item model.
	 *
	 * @param   string  $view  The single view code name.
	 *
	 * @return  string  The generated method body.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.GetItemMethod instead.
	 */
	public function setMethodGetItem(&$view)
	{
		return CFactory::_('Architecture.Model.GetItemMethod')->get($view);
	}

	/**
	 * Set the check box handling of the save method of a view.
	 *
	 * @param   array $view  The view definition.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.CheckboxSave instead.
	 */
	public function setCheckboxSave(&$view)
	{
		return CFactory::_('Architecture.Model.CheckboxSave')->get($view);
	}

	/**
	 * build the save method of an admin edit view model
	 *
	 * @param   string  $view  The single view name
	 *
	 * @return  string The php to place in the model
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.ItemSave service.
	 */
	public function setMethodItemSave(&$view)
	{
		return CFactory::_('Architecture.Model.ItemSave')->get($view);
	}

	/**
	 * Set the constructor of the table class of a view.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The generated constructor.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Table.Constructor instead.
	 */
	public function setJtableConstructor(&$view)
	{
		return CFactory::_('Architecture.Table.Constructor')->get($view);
	}

	/**
	 * Set the alias and category handling of the table class of a view.
	 *
	 * @param   array $view  The view definition.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Table.Constructor instead.
	 */
	public function setJtableAliasCategory(&$view)
	{
		return CFactory::_('Architecture.Table.Constructor')->aliasCategory($view);
	}

	/**
	 * Build the content type declarations of every admin view that needs one.
	 *
	 * @param   string  $action  Whether the component is installing or updating.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.ContentTypes service.
	 */
	public function setComponentToContentTypes($action)
	{
		$script = CFactory::_('Architecture.Component.ContentTypes')->get((string) $action);

		// the uninstall script the helper still builds reads these off the properties
		$this->uninstallScriptBuilder = CFactory::_('Compiler.Builder.Uninstall.Script.Context')
			->allActive() + $this->uninstallScriptBuilder;
		$this->uninstallScriptContent = CFactory::_('Compiler.Builder.Uninstall.Script.Content')
			->allActive() + $this->uninstallScriptContent;

		return $script;
	}

	/**
	 * Set the post install script of the component.
	 *
	 * @return  string  The generated script.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Component.PostInstallScript instead.
	 */
	public function setPostInstallScript()
	{
		$script = CFactory::_('Architecture.Component.PostInstallScript')->get();

		// the uninstall script the helper still builds reads these off the properties
		$this->uninstallScriptBuilder = CFactory::_('Compiler.Builder.Uninstall.Script.Context')
			->allActive() + $this->uninstallScriptBuilder;
		$this->uninstallScriptContent = CFactory::_('Compiler.Builder.Uninstall.Script.Content')
			->allActive() + $this->uninstallScriptContent;

		return $script;
	}





	/**
	 * Set the post update script of the component.
	 *
	 * @return  string  The generated script.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Component.PostUpdateScript instead.
	 */
	public function setPostUpdateScript()
	{
		$script = CFactory::_('Architecture.Component.PostUpdateScript')->get();

		// the uninstall script the helper still builds reads these off the properties
		$this->uninstallScriptBuilder = CFactory::_('Compiler.Builder.Uninstall.Script.Context')
			->allActive() + $this->uninstallScriptBuilder;
		$this->uninstallScriptContent = CFactory::_('Compiler.Builder.Uninstall.Script.Content')
			->allActive() + $this->uninstallScriptContent;

		return $script;
	}

	/**
	 * Build the uninstall method body of the script.php for the build target.
	 *
	 * @return  string  The generated uninstall script.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.UninstallScript service.
	 */
	public function setUninstallScript(): string
	{
		return CFactory::_('Architecture.Component.UninstallScript')->get(
			CFactory::_('Compiler.Builder.Uninstall.Script.Context')->allActive()
				+ $this->uninstallScriptBuilder,
			CFactory::_('Compiler.Builder.Uninstall.Script.Fields')->allActive()
				+ $this->uninstallScriptFields
		);
	}

	/**
	 * Build the Joomla 3 uninstall method body of the script.php.
	 *
	 * @return  string  The generated uninstall script.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.J3.UninstallScript service.
	 */
	public function setUninstallScriptJ3(): string
	{
		return CFactory::_('Architecture.Component.J3.UninstallScript')->get(
			CFactory::_('Compiler.Builder.Uninstall.Script.Context')->allActive()
				+ $this->uninstallScriptBuilder,
			CFactory::_('Compiler.Builder.Uninstall.Script.Fields')->allActive()
				+ $this->uninstallScriptFields
		);
	}

	/**
	 * Build the Joomla 4+ uninstall method body of the script.php.
	 *
	 * @return  string  The generated uninstall script.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.Shared.UninstallScript service.
	 */
	public function setUninstallScriptJ4(): string
	{
		return CFactory::_('Architecture.Component.Shared.UninstallScript')->get(
			CFactory::_('Compiler.Builder.Uninstall.Script.Context')->allActive()
				+ $this->uninstallScriptBuilder,
			CFactory::_('Compiler.Builder.Uninstall.Script.Fields')->allActive()
				+ $this->uninstallScriptFields
		);
	}

	/**
	 * build code for the assets table script intelligent fix
	 *
	 * @return  string The php to place in script.php
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.AssetsTable service.
	 */
	protected function getAssetsTableIntelligentInstall(): string
	{
		return CFactory::_('Architecture.Component.AssetsTable')->install();
	}

	/**
	 * build code for the assets table script intelligent reversal
	 *
	 * @return  string The php to place in script.php
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.AssetsTable service.
	 */
	protected function getAssetsTableIntelligentUninstall(): string
	{
		return CFactory::_('Architecture.Component.AssetsTable')->uninstall();
	}

	/**
	 * Build the folder moving code the install script needs.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Component.MoveFolderScript instead.
	 */
	public function setMoveFolderScript()
	{
		return CFactory::_('Architecture.Component.MoveFolderScript')->get();
	}

	/**
	 * Build the folder moving method the install script calls.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Component.MoveFolderMethod instead.
	 */
	public function setMoveFolderMethod()
	{
		return CFactory::_('Architecture.Component.MoveFolderMethod')->get();
	}

	/**
	 * Build one admin view's content type declaration.
	 *
	 * @param   string  $view       The single view code name.
	 * @param   string  $component  The component code name.
	 *
	 * @return  array|false
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.ContentTypes service.
	 */
	public function getContentType($view, $component)
	{
		$type = CFactory::_('Architecture.Component.ContentTypes')->contentType(
			(string) $view, (string) $component
		);

		// the uninstall script the helper still builds reads these off the properties
		$this->uninstallScriptBuilder = CFactory::_('Compiler.Builder.Uninstall.Script.Context')
			->allActive() + $this->uninstallScriptBuilder;
		$this->uninstallScriptContent = CFactory::_('Compiler.Builder.Uninstall.Script.Content')
			->allActive() + $this->uninstallScriptContent;

		return $type;
	}

	/**
	 * Build the content type declaration of one view's own category.
	 *
	 * @param   string  $view       The single view code name.
	 * @param   string  $views      The list view code name.
	 * @param   string  $component  The component code name.
	 *
	 * @return  array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.ContentTypes service.
	 */
	public function getCategoryContentType($view, $views, $component)
	{
		$type = CFactory::_('Architecture.Component.ContentTypes')->categoryContentType(
			(string) $view, (string) $views, (string) $component
		);

		// the uninstall script the helper still builds reads these off the properties
		$this->uninstallScriptBuilder = CFactory::_('Compiler.Builder.Uninstall.Script.Context')
			->allActive() + $this->uninstallScriptBuilder;
		$this->uninstallScriptContent = CFactory::_('Compiler.Builder.Uninstall.Script.Content')
			->allActive() + $this->uninstallScriptContent;

		return $type;
	}

	/**
	 * Build the route method one site view offers.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   bool    $front           Whether this is a front item view.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Router.RouteHelper service.
	 */
	public function setRouterHelp($nameSingleCode, $nameListCode, $front = false)
	{
		return CFactory::_('Architecture.Router.RouteHelper')->get(
			(string) $nameSingleCode, (string) $nameListCode, (bool) $front
		);
	}

	/**
	 * Build one view's case in the router's parse switch.
	 *
	 * @param   string  $view       The view code name.
	 * @param   mixed   $viewArray  The view being built.
	 * @param   bool    $aliasView  Whether the view is reached by an alias.
	 * @param   bool    $idView     Whether the view is reached by an id.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Router.SiteRouter service.
	 */
	public function routerParseSwitch(&$view, $viewArray = null,
		$aliasView = true, $idView = true
	)
	{
		return CFactory::_('Architecture.Router.SiteRouter')->parseSwitch(
			$view, $viewArray, $aliasView, $idView
		);
	}

	/**
	 * Build the test that says a view is one this router builds.
	 *
	 * @param   string  $view  The view code name.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Router.SiteRouter service.
	 */
	public function routerBuildViews(&$view)
	{
		return CFactory::_('Architecture.Router.SiteRouter')->buildViews((string) $view);
	}

	/**
	 * build the batchMove method of an admin model
	 *
	 * @param   string  $nameSingleCode  The single view name
	 *
	 * @return  string The php to place in the model
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.BatchMove service.
	 */
	public function setBatchMove($nameSingleCode)
	{
		return CFactory::_('Architecture.Model.BatchMove')->get($nameSingleCode);
	}

	/**
	 * build the batchCopy method of an admin model
	 *
	 * @param   string  $nameSingleCode  The single view name
	 *
	 * @return  string The php to place in the model
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.BatchCopy service.
	 */
	public function setBatchCopy($nameSingleCode)
	{
		return CFactory::_('Architecture.Model.BatchCopy')->get($nameSingleCode);
	}

	/**
	 * build the title and alias uniqueness fix of a model
	 *
	 * @param   string  $nameSingleCode  The single view name
	 *
	 * @return  string The php to place in the model
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.AliasTitleFix service.
	 */
	public function setAliasTitleFix($nameSingleCode)
	{
		return CFactory::_('Architecture.Model.AliasTitleFix')->get($nameSingleCode);
	}

	/**
	 * Set the generate new title method of an admin model.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 *
	 * @return  string  The generated method.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.GenerateNewTitle instead.
	 */
	public function setGenerateNewTitle($nameSingleCode)
	{
		return CFactory::_('Architecture.Model.GenerateNewTitle')->get($nameSingleCode);
	}

	/**
	 * Set the generate new alias method of an admin model.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 *
	 * @return  string  The generated method.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.GenerateNewAlias instead.
	 */
	public function setGenerateNewAlias($nameSingleCode)
	{
		return CFactory::_('Architecture.Model.GenerateNewAlias')->get($nameSingleCode);
	}

	/**
	 * Build the install.sql content of the component.
	 *
	 * @return  string  The generated install sql.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.InstallSql service.
	 */
	public function setInstall(): string
	{
		return CFactory::_('Architecture.Component.InstallSql')->get();
	}

	/**
	 * Build the uninstall.sql content of the component.
	 *
	 * @return  string  The generated uninstall sql.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Component.UninstallSql service.
	 */
	public function setUninstall(): string
	{
		return CFactory::_('Architecture.Component.UninstallSql')->get();
	}

	/**
	 * Register every language string the administrator side needs.
	 *
	 * @param   string  $componentName  The component name.
	 *
	 * @return  bool
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Language.Admin service.
	 */
	public function setLangAdmin(string $componentName): bool
	{
		return CFactory::_('Architecture.Language.Admin')->get($componentName);
	}

	/**
	 * Register every language string the site side needs.
	 *
	 * @param   string  $componentName  The component name.
	 *
	 * @return  bool
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Language.Site instead.
	 */
	public function setLangSite(string $componentName): bool
	{
		return CFactory::_('Architecture.Language.Site')->get($componentName);
	}

	/**
	 * Register every language string the site side needs before it is installed.
	 *
	 * @param   string  $componentName  The component name.
	 *
	 * @return  bool
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Language.SiteSys instead.
	 */
	public function setLangSiteSys(string $componentName): bool
	{
		return CFactory::_('Architecture.Language.SiteSys')->get($componentName);
	}

	/**
	 * Register every language string the administrator side needs before it is installed.
	 *
	 * @return  bool
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Language.AdminSys instead.
	 */
	public function setLangAdminSys(): bool
	{
		return CFactory::_('Architecture.Language.AdminSys')->get();
	}

	/**
	 * set the custom admin view list links
	 *
	 * @param   array   $view
	 * @param   string  $nameListCode
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.ListLink service.
	 */
	public function setCustomAdminViewListLink($view, $nameListCode)
	{
		CFactory::_('Architecture.AdminViews.ListLink')
			->set($view, $nameListCode);

		// keep the legacy public state in step with the focused builders
		$this->syncCustomAdminState($nameListCode);
	}

	/**
	 * copy the custom admin builder state onto the legacy helper properties
	 *
	 * @param   string  $nameListCode
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 * @deprecated 6.1.7 Read the Compiler.Builder.Custom.Admin.* registries.
	 */
	protected function syncCustomAdminState($nameListCode)
	{
		$links = CFactory::_('Compiler.Builder.Custom.Admin.View.List.Link')
			->get($nameListCode);
		if ($links !== null)
		{
			$this->customAdminViewListLink[$nameListCode] = $links;
		}

		$this->customAdminViewListId = CFactory::_('Compiler.Builder.Custom.Admin.View.List.Id')
			->allActive();
		$this->customAdminAdded = CFactory::_('Compiler.Builder.Custom.Admin.Added')
			->allActive();
	}

	/**
	 * set the list body
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 *
	 * @return string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.ListBody service.
	 */
	public function setListBody($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.ListBody')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * Get the list field class
	 *
	 * @param   string  $name          The field code name
	 * @param   string  $nameListCode  The list view code name
	 * @param   string  $default       The default
	 *
	 * @return  string  The list field class
	 *
	 * @since   3.2.0
	 */
	protected function getListFieldClass($name, $nameListCode, $default = '')
	{
		return CFactory::_('Compiler.Builder.List.Field.Class')->get($nameListCode . '.' . $name, $default);
	}

	/**
	 * Get the custom admin view buttons
	 *
	 * @param   string  $nameListCode  The list view code name
	 * @param   string  $ref           The link referral string
	 *
	 * @return  string of the custom admin view buttons
	 *
	 * @since   3.2.0
	 */
	protected function getCustomAdminViewButtons($nameListCode, $ref = '')
	{
		return CFactory::_('Architecture.AdminViews.ListLink')
			->getButtons($nameListCode, $ref);
	}

	/**
	 * set the default views body
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 *
	 * @return string
	 *
	 * @since   3.2.0
	 */
	public function setDefaultViewsBody(string $nameSingleCode, string $nameListCode): string
	{
		return CFactory::_('Architecture.AdminViews.ViewBody')
			->getDefault($nameSingleCode, $nameListCode);
	}

	/**
	 * set the modal views body
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 *
	 * @return string
	 *
	 * @since   3.2.0
	 */
	public function setModalViewsBody(string $nameSingleCode, string $nameListCode): string
	{
		return CFactory::_('Architecture.AdminViews.ViewBody')
			->getModal($nameSingleCode, $nameListCode);
	}

	/**
	 * set the list body table head
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 *
	 * @return string
	 */
	/**
	 * set the admin list view table head
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.ListHead service.
	 */
	public function setListHead($nameSingleCode, $nameListCode)
	{
		$head = CFactory::_('Architecture.AdminViews.ListHead')
			->get($nameSingleCode, $nameListCode);

		// keep the legacy public column counter in step with the builder
		$columns = CFactory::_('Compiler.Builder.List.Column.Number')
			->get($nameListCode);
		if ($columns !== null)
		{
			$this->listColnrBuilder[$nameListCode] = $columns;
		}

		return $head;
	}

	/**
	 * get the admin list view column count
	 *
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  int|string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Compiler.Builder.List.Column.Number registry.
	 */
	public function setListColnr($nameListCode)
	{
		$columns = CFactory::_('Compiler.Builder.List.Column.Number')
			->get($nameListCode);

		if ($columns !== null)
		{
			return $columns;
		}

		return '';
	}

	/**
	 * set Tabs Layouts Fields Array
	 *
	 * @param   string  $nameSingleCode  The single view name
	 *
	 * @return  string   The array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminView.TabLayoutFields service.
	 */
	public function getTabLayoutFieldsArray($nameSingleCode)
	{
		return CFactory::_('Architecture.AdminView.TabLayoutFields')
			->get($nameSingleCode);
	}

	/**
	 * set Edit Body
	 *
	 * @param   array  $view  The view data
	 *
	 * @return  string   The edit body
	 *
	 * @deprecated 6.1.7 Use the Architecture.AdminView.EditBody service.
	 *
	 * @since   3.2.0
	 */
	public function setEditBody(&$view)
	{
		$body = CFactory::_('Architecture.AdminView.EditBody')->get($view);

		// keep the legacy deferred queue in step with the builder
		$queued = CFactory::_('Compiler.Builder.Second.Run.Admin')->allActive();
		if (ArrayHelper::check($queued))
		{
			$this->secondRunAdmin = $queued;
		}

		return $body;
	}





	/**
	 * Add the custom tabs of a view.
	 *
	 * @param   int     $nr           The tab number to start from.
	 * @param   string  $name_single  The single view name.
	 * @param   string  $target       The build target of the view.
	 *
	 * @return  string  The generated custom tabs.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminView.CustomTabs service.
	 */
	protected function addCustomTabs($nr, $name_single, $target)
	{
		return CFactory::_('Architecture.AdminView.CustomTabs')
			->get($nr, $name_single, $target);
	}

	/**
	 * set the view fade in effect
	 *
	 * @param   array  $view
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminView.FadeInEffect service.
	 */
	public function setFadeInEfect(&$view)
	{
		return CFactory::_('Architecture.AdminView.FadeInEffect')->get($view);
	}

	/**
	 * Build one layout of a view.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $layoutName      The layout name.
	 * @param   string  $items           The generated layout items.
	 * @param   string  $type            The structure type of the layout file.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Layout.View service.
	 */
	public function setLayout($nameSingleCode, $layoutName, $items, $type)
	{
		CFactory::_('Architecture.Layout.View')
			->set($nameSingleCode, $layoutName, $items, $type);
	}

	/**
	 * Build one linked view of a parent view.
	 *
	 * @param   array  $args  The linked view definition queued by the edit body.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.LinkedView.Builder service.
	 */
	public function setLinkedView($args)
	{
		CFactory::_('Architecture.LinkedView.Builder')->set($args);
	}

	/**
	 * @param   bool  $init
	 *
	 * @return string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminView.FootableScripts service.
	 */
	public function setFootableScripts($init = true)
	{
		return CFactory::_('Architecture.AdminView.FootableScripts')
			->get((bool) $init);
	}

	/**
	 * set the list body of the linked admin view
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 * @param   string  $refview
	 *
	 * @return string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.LinkedView.ListBody service.
	 */
	public function setListBodyLinked($nameSingleCode, $nameListCode, $refview)
	{
		return CFactory::_('Architecture.LinkedView.ListBody')->get(
			$nameSingleCode, $nameListCode, $refview
		);
	}

	/**
	 * set the list body table head linked admin view
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 * @param   bool    $addNewButon
	 * @param   string  $refview
	 *
	 * @return string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.LinkedView.ListHead service.
	 */
	public function setListHeadLinked($nameSingleCode, $nameListCode,
		$addNewButon, $refview
	)
	{
		return CFactory::_('Architecture.LinkedView.ListHead')->get(
			$nameSingleCode, $nameListCode, $addNewButon, $refview
		);
	}

	/**
	 * @param $nameSingleCode
	 * @param $nameListCode
	 * @param $functionName
	 * @param $key
	 * @param $_key
	 * @param $parentKey
	 * @param $parent_key
	 * @param $globalKey
	 *
	 * @return string
	 */
	/**
	 * Add the linked view getter to a model.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $functionName    The generated method name suffix.
	 * @param   string  $key             The key of the linked view.
	 * @param   string  $_key            The plain key column.
	 * @param   string  $parentKey       The key of the parent view.
	 * @param   string  $parent_key      The plain parent key column.
	 * @param   mixed   $globalKey       The property the parent exposes the key on.
	 *
	 * @return  string  The generated getter.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.LinkedView.ListQuery service.
	 */
	public function setListQueryLinked($nameSingleCode, $nameListCode,
		$functionName, $key, $_key, $parentKey, $parent_key, $globalKey)
	{
		return CFactory::_('Architecture.LinkedView.ListQuery')->get(
			$nameSingleCode, $nameListCode, $functionName, $key, $_key,
			$parentKey, $parent_key, $globalKey
		);
	}

	/**
	 * Set the controller methods the dynamic buttons of a view call.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  string  The generated methods.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Controller.CustomAdminDynamicButton instead.
	 */
	public function setCustomAdminDynamicButtonController($nameListCode)
	{
		return CFactory::_('Architecture.Controller.CustomAdminDynamicButton')
			->get($nameListCode);
	}

	/**
	 * A function that builds get Items Method for model
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 * @param   array   $config          The config details to adapt the method being build
	 *
	 * @return string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.ItemsMethod service.
	 */
	public function setGetItemsModelMethod(&$nameSingleCode, &$nameListCode,
		$config = array('functionName' => 'getExportData',
			'docDesc'      => 'Method to get list export data.',
			'type'         => 'export')
	)
	{
		// Infusion still sets these flags directly on this helper, so they are
		// carried over to the registry the service reads.
		foreach ($this->eximportView as $view => $active)
		{
			CFactory::_('Compiler.Builder.Eximport.View')->set($view, $active);
		}

		return CFactory::_('Architecture.Model.ItemsMethod')
			->get($nameSingleCode, $nameListCode, $config);
	}

	/**
	 * Build the exportData and importData methods of an admin list controller.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Controller.EximportMethod service.
	 */
	public function setControllerEximportMethod($nameSingleCode,
		$nameListCode)
	{
		// Infusion still sets these flags directly on this helper, so they are
		// carried over to the registries the service reads.
		foreach ($this->eximportView as $view => $active)
		{
			CFactory::_('Compiler.Builder.Eximport.View')->set($view, $active);
		}

		foreach ($this->importCustomScripts as $view => $active)
		{
			CFactory::_('Compiler.Builder.Import.Custom.Scripts')->set($view, $active);
		}

		return CFactory::_('Architecture.Controller.EximportMethod')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * Build the export button of a list view that allows export.
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.AdminViews.EximportButtons instead.
	 */
	public function setExportButton($nameSingleCode, $nameListCode)
	{
		// Infusion still sets these flags directly on this helper, so they are
		// carried over to the registry the service reads.
		foreach ($this->eximportView as $view => $active)
		{
			CFactory::_('Compiler.Builder.Eximport.View')->set($view, $active);
		}

		return CFactory::_('Architecture.AdminViews.EximportButtons')
			->export($nameSingleCode, $nameListCode);
	}

	/**
	 * Build the import button of a list view that allows import.
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.AdminViews.EximportButtons instead.
	 */
	public function setImportButton($nameSingleCode, $nameListCode)
	{
		// Infusion still sets these flags directly on this helper, so they are
		// carried over to the registry the service reads.
		foreach ($this->eximportView as $view => $active)
		{
			CFactory::_('Compiler.Builder.Eximport.View')->set($view, $active);
		}

		return CFactory::_('Architecture.AdminViews.EximportButtons')
			->import($nameSingleCode, $nameListCode);
	}

	/**
	 * Write the custom import files of a list view.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Component.ImportCustomScripts instead.
	 */
	public function setImportCustomScripts($nameListCode)
	{
		CFactory::_('Architecture.Component.ImportCustomScripts')->set($nameListCode);
	}

	/**
	 * build the getListQuery method of an admin list view model
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in the model
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.ListQuery service.
	 */
	public function setListQuery(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.Model.ListQuery')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * build search query
	 *
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  string The php to place in model
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.SearchQuery service.
	 */
	public function setSearchQuery($nameListCode)
	{
		return CFactory::_('Architecture.Model.SearchQuery')->get($nameListCode);
	}

	/**
	 * Add the custom field selects and joins to a list query.
	 *
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $tab             Extra indentation of the generated lines.
	 * @param   bool    $just_text       Select the display text without its id alias.
	 *
	 * @return  string  The generated query lines.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.CustomQuery service.
	 */
	public function setCustomQuery($nameListCode, $nameSingleCode,
		$tab = '',
		$just_text = false
	)
	{
		return CFactory::_('Architecture.Model.CustomQuery')->get(
			$nameListCode, $nameSingleCode, (string) $tab, (bool) $just_text
		);
	}

	/**
	 * build model filter per/field in the list view
	 *
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  string The php to place in model to filter
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.FilterQuery service.
	 */
	public function setFilterQuery($nameListCode)
	{
		return CFactory::_('Architecture.Model.FilterQuery')->get($nameListCode);
	}

	/**
	 * build single filter query
	 *
	 * @param   array   $filter  The field/filter
	 * @param   string  $Helper  The helper name of the component being build
	 * @param   string  $a       The db table target name (a)
	 *
	 * @return  string The php to place in model to filter this field
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.FilterQuery service.
	 */
	protected function setSingleFilterQuery($filter, $Helper, $a = "a")
	{
		return CFactory::_('Architecture.Model.FilterQuery')
			->getSingleFilterQuery($filter, $Helper, $a);
	}

	/**
	 * build multi filter query
	 *
	 * @param   array   $filter  The field/filter
	 * @param   string  $Helper  The helper name of the component being build
	 * @param   string  $a       The db table target name (a)
	 *
	 * @return  string The php to place in model to filter this field
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.FilterQuery service.
	 */
	protected function setMultiFilterQuery($filter, $Helper, $a = "a")
	{
		return CFactory::_('Architecture.Model.FilterQuery')
			->getMultiFilterQuery($filter, $Helper, $a);
	}

	/**
	 * Build the javascript this admin view carries.
	 *
	 * @param   array  $viewArray  The admin view, as the component data carries it.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminView.ViewScript service.
	 */
	public function buildTheViewScript($viewArray)
	{
		CFactory::_('Architecture.AdminView.ViewScript')->get((array) $viewArray);

		// the methods still on this helper read the fixes off this property
		$this->validationFixBuilder = CFactory::_('Compiler.Builder.Validation.Fix')
			->allActive();
	}

	/**
	 * Build the statements that read every watched value and call one function.
	 *
	 * @param   string  $function   The name of the function to call.
	 * @param   array   $matchKeys  The keys of the values the function takes.
	 * @param   array   $getValue   The read statement of every key.
	 *
	 * @return  array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminView.ViewScript service.
	 */
	public function buildFunctionCall($function, $matchKeys, $getValue)
	{
		return CFactory::_('Architecture.AdminView.ViewScript')->functionCall(
			(string) $function, (array) $matchKeys, (array) $getValue
		);
	}

	/**
	 * Find the conditions of this view that steer the same target fields.
	 *
	 * @param   array   $relations  Every condition the view declares.
	 * @param   array   $condition  The condition being chained.
	 * @param   string  $view       The single view code name.
	 *
	 * @return  array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Field.TargetRelationScript service.
	 */
	public function getTargetRelationScript($relations, $condition, $view)
	{
		return CFactory::_('Architecture.Field.TargetRelationScript')->get(
			(array) $relations, (array) $condition, (string) $view
		);
	}

	/**
	 * Test whether this target may still be claimed by this pair of matches.
	 *
	 * @param   string  $targetName          The name of the target field.
	 * @param   mixed   $relationMatchName   The name the chained condition matches on.
	 * @param   mixed   $conditionMatchName  The name the condition being chained matches on.
	 * @param   string  $view                The single view code name.
	 *
	 * @return  bool
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Field.TargetRelationScript service.
	 */
	public function checkRelationControl($targetName, $relationMatchName,
		$conditionMatchName, $view
	)
	{
		return CFactory::_('Architecture.Field.TargetRelationScript')->checkControl(
			(string) $targetName, $relationMatchName, $conditionMatchName,
			(string) $view
		);
	}

	/**
	 * Build the show, hide and required statements for every target field.
	 *
	 * @param   bool    $toggleSwitch    Whether the required attribute is toggled rather than set once.
	 * @param   mixed   $targets         The target fields.
	 * @param   string  $targetBehavior  The jQuery call that reveals a target.
	 * @param   string  $targetDefault   The jQuery call that returns a target to its default.
	 * @param   string  $uniqueVar       The unique key of the condition being built.
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Field.TargetControlsScript service.
	 */
	public function setTargetControlsScript($toggleSwitch, $targets,
		$targetBehavior, $targetDefault, $uniqueVar, $nameSingleCode)
	{
		$bucket = CFactory::_('Architecture.Field.TargetControlsScript')->get(
			(bool) $toggleSwitch, $targets, (string) $targetBehavior,
			(string) $targetDefault, (string) $uniqueVar,
			(string) $nameSingleCode
		);

		// the methods still on this helper read the fixes off this property
		$this->validationFixBuilder = CFactory::_('Compiler.Builder.Validation.Fix')
			->allActive();

		return $bucket;
	}

	/**
	 * Build the javascript test one form condition runs.
	 *
	 * @param   string  $value     The javascript variable holding the watched value.
	 * @param   mixed   $behavior  The match behaviour the condition declares.
	 * @param   mixed   $type      The type of the field being watched.
	 * @param   mixed   $options   The options the field offers.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Field.IfValueScript service.
	 */
	public function ifValueScript($value, $behavior, $type, $options)
	{
		return CFactory::_('Architecture.Field.IfValueScript')->get(
			(string) $value, $behavior, $type, $options
		);
	}

	/**
	 * Read the options a watched field declares.
	 *
	 * @param   mixed  $type     The type of the field being watched.
	 * @param   mixed  $options  The options the field declares.
	 *
	 * @return  array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Field.OptionsScript service.
	 */
	public function getOptionsScript($type, $options)
	{
		return CFactory::_('Architecture.Field.OptionsScript')->get(
			$type, $options
		);
	}

	/**
	 * Build the javascript that reads the watched field's value.
	 *
	 * @param   mixed   $type     The type of the field being watched.
	 * @param   string  $name     The name of the field being watched.
	 * @param   mixed   $extends  The type the field extends, when it is a custom field.
	 * @param   string  $unique   The unique key of the condition being built.
	 *
	 * @return  array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Field.ValueScript service.
	 */
	public function getValueScript($type, $name, $extends, $unique)
	{
		return CFactory::_('Architecture.Field.ValueScript')->get(
			$type, (string) $name, $extends, (string) $unique
		);
	}

	/**
	 * Build the javascript that clears the watched field's value.
	 *
	 * @param   string  $type    The type of the field being watched
	 * @param   string  $name    The name of the field being watched
	 * @param   string  $unique  The unique key of the condition being built
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Field.ClearValueScript instead.
	 */
	public function clearValueScript($type, $name, $unique)
	{
		return CFactory::_('Architecture.Field.ClearValueScript')
			->get($type, $name, $unique);
	}

	/**
	 * Read back one of the scripts an admin view was given.
	 *
	 * @param   string  $view  The view code name.
	 * @param   string  $type  Which script: fileScript, footerScript or list_fileScript.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminView.ViewScript service.
	 */
	public function setViewScript(&$view, $type)
	{
		return CFactory::_('Architecture.AdminView.ViewScript')->script(
			(string) $view, (string) $type
		);
	}

	/**
	 * Set the validation fix statements of a view.
	 *
	 * @param   string  $view       The single view name.
	 * @param   string  $Component  The component name.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.ValidationFix instead.
	 */
	public function setValidationFix($view, $Component)
	{
		return CFactory::_('Architecture.Model.ValidationFix')->get($view, $Component);
	}

	/**
	 * Build the ajax token declaration a view with ajax makes.
	 *
	 * @param   string  $view  The view name
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.AjaxToken instead.
	 */
	public function setAjaxToke(&$view)
	{
		return CFactory::_('Architecture.View.AjaxToken')->get($view);
	}

	/**
	 * Build the task registration of the ajax controller of one target.
	 *
	 * @param   string  $target  The build target the tasks belong to.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Controller.AjaxTasks instead.
	 */
	public function setRegisterAjaxTask($target)
	{
		return CFactory::_('Architecture.Controller.AjaxTasks')->get($target);
	}

	/**
	 * Build the ajax controller cases one build target declares.
	 *
	 * @param   string  $target  The build target, site or administrator
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Controller.AjaxCases instead.
	 */
	public function setAjaxInputReturn($target)
	{
		return CFactory::_('Architecture.Controller.AjaxCases')->get($target);
	}

	/**
	 * Build the ajax model methods one build target declares.
	 *
	 * @param   string  $target  The build target, site or administrator
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.AjaxMethods instead.
	 */
	public function setAjaxModelMethods($target)
	{
		return CFactory::_('Architecture.Model.AjaxMethods')->get($target);
	}

	/**
	 * Build the jQuery framework load the generated view makes.
	 *
	 * @param   array  $view  The view being built
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.Jquery instead.
	 */
	public function setJquery(&$view)
	{
		return CFactory::_('Architecture.View.Jquery')->get($view);
	}

	/**
	 * build filter functions
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterFieldHelper service.
	 */
	public function setFilterFieldHelper(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.FilterFieldHelper')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * Set the unique field statements of a view.
	 *
	 * @param   string  $view  The single view name.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.UniqueFields instead.
	 */
	public function setUniqueFields(&$view)
	{
		return CFactory::_('Architecture.Model.UniqueFields')->get($view);
	}

	/**
	 * build sidebar filter loading scripts
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.AdminViews.SidebarFilters instead.
	 */
	public function setFilterFieldSidebarDisplayHelper(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.SidebarFilters')
			->get($nameSingleCode, $nameListCode);
	}





	/**
	 * build batch loading helper scripts
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.AdminViews.BatchOptions instead.
	 */
	public function setBatchDisplayHelper(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.BatchOptions')
			->get($nameSingleCode, $nameListCode);
	}





	/**
	 * Build the map entry from a category extension to the view that owns it.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Router.SiteRouter service.
	 */
	public function setRouterCategoryViews($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.Router.SiteRouter')->categoryViews(
			(string) $nameSingleCode, (string) $nameListCode
		);
	}

	/**
	 * build the getForm method of an admin edit view model
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in the model
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.GetForm service.
	 */
	public function setJmodelAdminGetForm($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.Model.GetForm')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * Add the edit permission guard of one field.
	 *
	 * @param   array   $allow            The guard lines being built
	 * @param   string  $nameSingleCode   The single view name
	 * @param   string  $fieldName        The field code name
	 * @param   string  $fieldType        The field type
	 * @param   string  $component        The component code name
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.GetForm service.
	 */
	protected function setPermissionEditFields(&$allow, $nameSingleCode, $fieldName, $fieldType, $component)
	{
		CFactory::_('Architecture.Model.GetForm')
			->setPermissionEditFields($allow, $nameSingleCode, $fieldName, $fieldType, $component);
	}

	/**
	 * Add the access permission guard of one field.
	 *
	 * @param   array   $allow            The guard lines being built
	 * @param   string  $nameSingleCode   The single view name
	 * @param   string  $fieldName        The field code name
	 * @param   string  $fieldType        The field type
	 * @param   string  $component        The component code name
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.GetForm service.
	 */
	protected function setPermissionAccessFields(&$allow, $nameSingleCode, $fieldName, $fieldType, $component)
	{
		CFactory::_('Architecture.Model.GetForm')
			->setPermissionAccessFields($allow, $nameSingleCode, $fieldName, $fieldType, $component);
	}

	/**
	 * Add the view permission guard of one field.
	 *
	 * @param   array   $allow            The guard lines being built
	 * @param   string  $nameSingleCode   The single view name
	 * @param   string  $fieldName        The field code name
	 * @param   string  $fieldType        The field type
	 * @param   string  $component        The component code name
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.GetForm service.
	 */
	protected function setPermissionViewFields(&$allow, $nameSingleCode, $fieldName, $fieldType, $component)
	{
		CFactory::_('Architecture.Model.GetForm')
			->setPermissionViewFields($allow, $nameSingleCode, $fieldName, $fieldType, $component);
	}

	/**
	 * Set the permission object of a list view.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.AdminViews.CanDo instead.
	 */
	public function setJviewListCanDo($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.CanDo')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * Set the access control fieldset of a view.
	 *
	 * @param   string  $view  The single view name.
	 *
	 * @return  string  The generated fieldset.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Field.SetAccessControl instead.
	 */
	public function setFieldSetAccessControl(&$view)
	{
		return CFactory::_('Architecture.Field.SetAccessControl')->get($view);
	}

	/**
	 * Set the filter fields array of a list model.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The generated array.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.FilterFields instead.
	 */
	public function setFilterFieldsArray(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.Model.FilterFields')
			->get($nameSingleCode, $nameListCode);
	}



	/**
	 * Set the stored id method of a list model.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The generated method.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.StoredId instead.
	 */
	public function setStoredId(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.Model.StoredId')
			->get($nameSingleCode, $nameListCode);
	}





	/**
	 * Set the populate state statements of a list model.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.PopulateState instead.
	 */
	public function setPopulateState(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.Model.PopulateState')
			->get($nameSingleCode, $nameListCode);
	}





	/**
	 * Set the sort fields method of a list model.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  string  The generated method.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Model.SortFields instead.
	 */
	public function setSortFields(&$nameListCode)
	{
		return CFactory::_('Architecture.Model.SortFields')->get($nameListCode);
	}

	/**
	 * Add the item fixes a list model applies after loading.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $Component       The component code name.
	 * @param   string  $tab             Extra indentation of the generated lines.
	 * @param   bool    $export          Build for an export rather than a list.
	 * @param   bool    $all             Include every field, not only listed ones.
	 *
	 * @return  string  The generated fixes.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.ItemsStringFix service.
	 */
	public function setGetItemsMethodStringFix($nameSingleCode, $nameListCode,
		$Component, $tab = '', $export = false, $all = false)
	{
		return CFactory::_('Architecture.Model.ItemsStringFix')->get(
			$nameSingleCode, $nameListCode, $Component, $tab, $export, $all
		);
	}

	/**
	 * Get the relation statement of one field.
	 *
	 * @param   array   $item          The field definition.
	 * @param   string  $nameListCode  The list view code name.
	 * @param   string  $tab           Extra indentation of the generated lines.
	 *
	 * @return  string  The generated statement.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.FieldRelation service.
	 */
	protected function setModelFieldRelation($item, $nameListCode, $tab)
	{
		return CFactory::_('Architecture.Model.FieldRelation')
			->get((array) $item, (string) $nameListCode, (string) $tab);
	}

	/**
	 * Add the selection translation loop to a list model.
	 *
	 * @param   string  $views      The list view code name.
	 * @param   string  $Component  Unused, kept for the legacy signature.
	 * @param   string  $tab        Extra indentation of the generated lines.
	 *
	 * @return  string  The generated loop.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.SelectionTranslation service.
	 */
	public function setSelectionTranslationFix($views, $Component, $tab = '')
	{
		return CFactory::_('Architecture.Model.SelectionTranslation')
			->get($views, (string) $tab);
	}

	/**
	 * Add the selection translation method to a list model.
	 *
	 * @param   string  $views      The list view code name.
	 * @param   string  $Component  Unused, kept for the legacy signature.
	 *
	 * @return  string  The generated method.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Model.SelectionTranslationMethod service.
	 */
	public function setSelectionTranslationFixFunc($views, $Component)
	{
		return CFactory::_('Architecture.Model.SelectionTranslationMethod')
			->get($views);
	}

	/**
	 * Build one view's case in the router's own parse switch.
	 *
	 * @param   string  $viewsCodeName  The list view code name.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Router.SiteRouter service.
	 */
	public function setRouterCase($viewsCodeName)
	{
		return CFactory::_('Architecture.Router.SiteRouter')->parseCase(
			(string) $viewsCodeName
		);
	}

	/**
	 * Set the access checks the dashboard icons are shown behind.
	 *
	 * @return  string  The generated checks.
	 *
	 * @since   3.2.0
	 */
	public function setDashboardIconAccess()
	{
		return CFactory::_('Compiler.Builder.Permission.Dashboard')->build();
	}

	/**
	 * build the dashboard icons of the component
	 *
	 * @return  string The dashboard icon array
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Dashboard.Icons service.
	 */
	public function setDashboardIcons()
	{
		return CFactory::_('Architecture.Dashboard.Icons')->get(
			CFactory::_('Compiler.Builder.Custom.Admin.Added')->allActive()
				+ $this->customAdminAdded
		);
	}

	/**
	 * Set the methods the dashboard model was built with.
	 *
	 * @return  string  The generated methods.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Dashboard.ModelMethods instead.
	 */
	public function setDashboardModelMethods()
	{
		$methods = CFactory::_('Architecture.Dashboard.ModelMethods')->get();

		// the method names this helper still keeps for anything reading them
		$this->DashboardGetCustomData = CFactory::_('Architecture.Dashboard.ModelMethods')
			->names();

		return $methods;
	}

	/**
	 * Set the custom data the dashboard was built to show.
	 *
	 * @return  string  The generated statements.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Dashboard.ModelMethods instead.
	 */
	public function setDashboardGetCustomData()
	{
		return CFactory::_('Architecture.Dashboard.ModelMethods')->customData();
	}

	/**
	 * add the dashboard icons of one custom admin view
	 *
	 * @param   object  $view     The custom admin view
	 * @param   int     $counter  The icon counter
	 *
	 * @return  string The dashboard icons
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Dashboard.Icons service.
	 */
	public function addCustomDashboardIcons(&$view, &$counter)
	{
		return CFactory::_('Architecture.Dashboard.Icons')->getCustomIcons(
			$view, $counter,
			CFactory::_('Compiler.Builder.Custom.Admin.Added')->allActive()
				+ $this->customAdminAdded
		);
	}

	/**
	 * Build the component's administrator sub menu.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Menu.SubMenus service.
	 */
	public function setSubMenus()
	{
		$menus = CFactory::_('Architecture.Menu.SubMenus')->get();

		// the uninstall script the helper still builds reads these off the properties
		$this->uninstallScriptBuilder = CFactory::_('Compiler.Builder.Uninstall.Script.Context')
			->allActive() + $this->uninstallScriptBuilder;
		$this->uninstallScriptFields = CFactory::_('Compiler.Builder.Uninstall.Script.Fields')
			->allActive() + $this->uninstallScriptFields;

		return $menus;
	}

	/**
	 * Build the custom sub menu entries that sit beside the given admin view.
	 *
	 * @param   array   $view      The admin view being walked.
	 * @param   string  $codeName  The component code name.
	 * @param   string  $lang      The menu language prefix.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Menu.CustomSubMenu service.
	 */
	public function addCustomSubMenu(&$view, &$codeName, &$lang)
	{
		$service = CFactory::_('Architecture.Menu.CustomSubMenu');
		$custom = $service->get(
			$view, (string) $codeName, (string) $lang,
			CFactory::_('Compiler.Builder.Custom.Admin.Added')->allActive()
				+ $this->customAdminAdded
		);

		// the caller reads these off this property once every view is walked,
		// and unsets it, so they are handed over rather than mirrored
		foreach ($service->takeDeferred() as $nr => $deferred)
		{
			$this->lastCustomSubMenu[$nr] = $deferred;
		}

		return $custom;
	}

	/**
	 * Build the component's administrator main menu.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Menu.MainMenus service.
	 */
	public function setMainMenus()
	{
		return CFactory::_('Architecture.Menu.MainMenus')->get();
	}

	/**
	 * Build the custom menu entries that sit before the given admin view.
	 *
	 * @param   array   $view      The admin view being walked.
	 * @param   string  $codeName  The component code name.
	 * @param   string  $lang      The menu language prefix.
	 *
	 * @return  string
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Menu.CustomMainMenu service.
	 */
	public function addCustomMainMenu(&$view, &$codeName, &$lang)
	{
		$service = CFactory::_('Architecture.Menu.CustomMainMenu');
		$customMenu = $service->get(
			$view, (string) $codeName, (string) $lang,
			CFactory::_('Compiler.Builder.Custom.Admin.Added')->allActive()
				+ $this->customAdminAdded
		);

		// the caller reads these off this property once every view is walked,
		// and unsets it, so they are handed over rather than mirrored
		foreach ($service->takeDeferred() as $nr => $deferred)
		{
			$this->lastCustomMainMenu[$nr] = $deferred;
		}

		return $customMenu;
	}

	/**
	 * Get every string that sits between two markers.
	 *
	 * @param   string $str  The string to read.
	 * @param   string $start  The marker each one opens with.
	 * @param   string $end  The marker each one closes with.
	 *
	 * @return  array  The strings.
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Placeholder.ReplacementNames instead.
	 */
	public function getInbetweenStrings($str, $start = '#' . '#' . '#', $end = '#' . '#' . '#')
	{
		return CFactory::_('Placeholder.ReplacementNames')
			->inbetween($str, $start, $end);
	}
}

