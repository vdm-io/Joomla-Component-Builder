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
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;

/**
 * Get class as the main compilers class
 * @deprecated 3.3
 */
class Get
{

	/**
	 * The Joomla Version
	 *
	 * @var     string
	 * @deprecated 3.3 Use CFactory::_('Config')->joomla_version;
	 */
	public $joomlaVersion;

	/**
	 * The Joomla Versions
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Config')->joomla_versions;
	 */
	public $joomlaVersions = array(
		3    => array('folder_key' => 3, 'xml_version' => 3.9), // only joomla 3
		3.10 => array('folder_key' => 3, 'xml_version' => 4.0) // legacy joomla 4
	);

	/**
	 * The hash placeholder
	 *
	 * @var     string
	 * @deprecated 3.3 Use Placefix::h();
	 */
	public $hhh = '#' . '#' . '#';

	/**
	 * The open bracket placeholder
	 *
	 * @var     string
	 * @deprecated 3.3 Use Placefix::b();
	 */
	public $bbb = '[' . '[' . '[';

	/**
	 * The close bracket placeholder
	 *
	 * @var     string
	 * @deprecated 3.3 Use Placefix::d();
	 */
	public $ddd = ']' . ']' . ']';

	/**
	 * The app
	 *
	 * @var     object
	 */
	public $app;

	/**
	 * The Params
	 *
	 * @var     object
	 */
	public $params;

	/**
	 * Add strict field export permissions
	 *
	 * @var     boolean
	 */
	public $strictFieldExportPermissions = false;

	/**
	 * Add text only export options
	 *
	 * @var     boolean
	 */
	public $exportTextOnly = false;

	/**
	 * The global placeholders
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Component.Placeholder')->get();
	 */
	public $globalPlaceholders = [];

	/**
	 * The placeholders
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Placeholder')->active[];
	 */
	public $placeholders = [];

	/**
	 * The Compiler Path
	 *
	 * @var     object
	 * @deprecated 3.3 Use CFactory::_('Config')->compiler_path;
	 */
	public $compilerPath;

	/**
	 * The JCB Powers Path
	 *
	 * @var     object
	 * @deprecated 3.3 Use CFactory::_('Config')->jcb_powers_path;
	 */
	public $jcbPowersPath;

	/**
	 * Switch to add assets table fix
	 *
	 * @var     int
	 * @deprecated 3.3 Use CFactory::_('Config')->add_assets_table_fix;
	 */
	public $addAssetsTableFix = 1;

	/**
	 * Assets table worse case
	 *
	 * @var     int
	 * @deprecated 3.3 Use CFactory::_('Config')->access_worse_case;
	 */
	public $accessWorseCase;

	/**
	 * Switch to add assets table name fix
	 *
	 * @var     bool
	 * @deprecated 3.3 Use CFactory::_('Config')->add_assets_table_name_fix;
	 */
	public $addAssetsTableNameFix = false;

	/**
	 * Switch to add custom code placeholders
	 *
	 * @var     bool
	 * @deprecated 3.3 Use CFactory::_('Config')->add_placeholders;
	 */
	public $addPlaceholders = false;

	/**
	 * Switch to remove line breaks from language strings
	 *
	 * @var     bool
	 * @deprecated 3.3 Use CFactory::_('Config')->remove_line_breaks;
	 */
	public $removeLineBreaks = false;

	/**
	 * The placeholders for custom code keys
	 *
	 * @var     array
	 * @deprecated 3.3
	 */
	protected $customCodeKeyPlacholders
		= array(
			'&#91;' => '[',
			'&#93;' => ']',
			'&#44;' => ',',
			'&#43;' => '+',
			'&#61;' => '='
		);

	/**
	 * The Component data
	 *
	 * @var      object
	 * @deprecated 3.3 Use CFactory::_('Component');
	 */
	public $componentData;

	/**
	 * The Switch to add Powers data
	 *
	 * @var      boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->add_power;
	 */
	public $addPower;

	/**
	 * The Powers data
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Power')->active;
	 */
	public $powers = [];

	/**
	 * The state of all Powers
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	public $statePowers = [];

	/**
	 * The linked Powers
	 *
	 * @var      array
	 */
	public $linkedPowers = [];

	/**
	 * The Plugins data
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Joomlaplugin.Data')->get();
	 */
	public $joomlaPlugins = [];

	/**
	 * The Modules data
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Joomlamodule.Data')->get();
	 */
	public $joomlaModules = [];

	/**
	 *    The custom script placeholders - we use the (xxx) to avoid detection it should be (***)
	 *    ##################################--->  PHP/JS  <---####################################
	 *
	 *    New Insert Code        = /xxx[INSERT<>$$$$]xxx/                /xxx[/INSERT<>$$$$]xxx/
	 *    New Replace Code    = /xxx[REPLACE<>$$$$]xxx/               /xxx[/REPLACE<>$$$$]xxx/
	 *
	 *    //////////////////////////////// when JCB adds it back //////////////////////////////////
	 *    JCB Add Inserted Code    = /xxx[INSERTED$$$$]xxx//xx23xx/          /xxx[/INSERTED$$$$]xxx/
	 *    JCB Add Replaced Code    = /xxx[REPLACED$$$$]xxx//xx25xx/          /xxx[/REPLACED$$$$]xxx/
	 *
	 *    /////////////////////////////// changeing existing custom code /////////////////////////
	 *    Update Inserted Code    = /xxx[INSERTED<>$$$$]xxx//xx23xx/        /xxx[/INSERTED<>$$$$]xxx/
	 *    Update Replaced Code    = /xxx[REPLACED<>$$$$]xxx//xx25xx/        /xxx[/REPLACED<>$$$$]xxx/
	 *
	 *    The custom script placeholders - we use the (==) to avoid detection it should be (--)
	 *    ###################################--->  HTML  <---#####################################
	 *
	 *    New Insert Code        = <!==[INSERT<>$$$$]==>                 <!==[/INSERT<>$$$$]==>
	 *    New Replace Code    = <!==[REPLACE<>$$$$]==>                <!==[/REPLACE<>$$$$]==>
	 *
	 *    ///////////////////////////////// when JCB adds it back ///////////////////////////////
	 *    JCB Add Inserted Code    = <!==[INSERTED$$$$]==><!==23==>        <!==[/INSERTED$$$$]==>
	 *    JCB Add Replaced Code    = <!==[REPLACED$$$$]==><!==25==>        <!==[/REPLACED$$$$]==>
	 *
	 *    //////////////////////////// changeing existing custom code ///////////////////////////
	 *    Update Inserted Code    = <!==[INSERTED<>$$$$]==><!==23==>      <!==[/INSERTED<>$$$$]==>
	 *    Update Replaced Code    = <!==[REPLACED<>$$$$]==><!==25==>      <!==[/REPLACED<>$$$$]==>
	 *
	 *    ////////23 is the ID of the code in the system don't change it!!!!!!!!!!!!!!!!!!!!!!!!!!
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $customCodePlaceholders
		= array(
			1 => 'REPLACE<>$$$$]',
			2 => 'INSERT<>$$$$]',
			3 => 'REPLACED<>$$$$]',
			4 => 'INSERTED<>$$$$]'
		);

	/**
	 * The custom code to be added
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Customcode')->active
	 */
	public $customCode;

	/**
	 * The custom code to be added
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $customCodeData = [];

	/**
	 * The function name memory ids
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Customcode')->functionNameMemory
	 */
	public $functionNameMemory = [];

	/**
	 * The custom code for local memory
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Customcode')->memory
	 */
	public $customCodeMemory = [];

	/**
	 * The custom code in local files that already exist in system
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $existingCustomCode = [];

	/**
	 * The custom code in local files this are new
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $newCustomCode = [];

	/**
	 * The index of code already loaded
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $codeAreadyDone = [];

	/**
	 * The external code/string to be added
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $externalCodeString = [];

	/**
	 * The external code/string cutter
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $externalCodeCutter = [];

	/*
	 * The line numbers Switch
	 *
	 * @var      boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->debug_line_nr;
	 */
	public $debugLinenr = false;

	/*
	 * The percentage when a language should be added
	 *
	 * @var      int
	 * @deprecated 3.3 Use CFactory::_('Config')->percentage_language_add
	 */
	public $percentageLanguageAdd = 0;

	/**
	 * The Placholder Language prefix
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Config')->lang_prefix;
	 */
	public $langPrefix;

	/**
	 * The Language content
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	public $langContent = [];

	/**
	 * The Languages bucket
	 *
	 * @var      array
	 */
	public $languages
		= array('components' => array(), 'modules' => array(),
		        'plugins'    => array());

	/**
	 * The Main Languages
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Config')->lang_tag;
	 */
	public $langTag = 'en-GB';

	/**
	 * The Multi Languages bucket
	 *
	 * @var      array
	 */
	public $multiLangString = [];

	/**
	 * The new lang to add
	 *
	 * @var      array
	 */
	protected $newLangStrings = [];

	/**
	 * The existing lang to update
	 *
	 * @var      array
	 */
	protected $existingLangStrings = [];

	/**
	 * The Language JS matching check
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Language.Extractor')->langMismatch;
	 */
	public $langMismatch = [];

	/**
	 * The Language SC matching check
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Language.Extractor')->langMatch;
	 */
	public $langMatch = [];

	/**
	 * The Language string targets
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Config')->lang_string_targets;
	 */
	public $langStringTargets
		= array(
			'Joomla' . '.JText._(',
			'JText:' . ':script(',
			'Text:' . ':_(',        // namespace and J version will be found
			'Text:' . ':sprintf(',  // namespace and J version will be found
			'JustTEXT:' . ':_('
		);

	/**
	 * The Component Code Name
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Config')->component_code_name;
	 */
	public $componentCodeName;

	/**
	 * The Component Context
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Config')->component_context;
	 */
	public $componentContext;

	/**
	 * The Component Code Name Length
	 *
	 * @var      int
	 * @deprecated 3.3 Use CFactory::_('Config')->component_code_name_length;
	 */
	public $componentCodeNameLength;

	/**
	 * The Component ID
	 *
	 * @var      int
	 * @deprecated 3.3 Use CFactory::_('Config')->component_id;
	 */
	public $componentID;

	/**
	 * The current user
	 *
	 * @var      array
	 */
	public $user;

	/**
	 * The database object
	 *
	 * @var      array
	 */
	public $db;

	/**
	 * The Component version
	 *
	 * @var      string
	 * @deprecated 3.3 Use CFactory::_('Config')->component_version;
	 */
	public $component_version;

	/**
	 * The UIKIT Switch
	 *
	 * @var    boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->uikit;
	 */
	public $uikit = 0;

	/**
	 * The UIKIT component checker
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Uikit.Comp')->get($key);
	 */
	public $uikitComp = [];

	/**
	 * The FOOTABLE Switch
	 *
	 * @var      boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->footable;
	 */
	public $footable = false;

	/**
	 * The FOOTABLE Version
	 *
	 * @var      int
	 * @deprecated 3.3 Use CFactory::_('Config')->footable_version;
	 */
	public $footableVersion;

	/**
	 * The Google Chart Switch per view
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Google.Chart')->get($key);
	 */
	public $googleChart = [];

	/**
	 * The Google Chart Switch
	 *
	 * @var     boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->google_chart;
	 */
	public $googlechart = false;

	/**
	 * The Import & Export Switch
	 *
	 * @var      boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->add_eximport;
	 */
	public $addEximport = false;

	/**
	 * The Import & Export View
	 *
	 * @var      array
	 */
	public $eximportView = [];

	/**
	 * The Import & Export Custom Script
	 *
	 * @var      array
	 */
	public $importCustomScripts = [];

	/**
	 * The Tag & History Switch
	 *
	 * @var      boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->set_tag_history;
	 */
	public $setTagHistory = false;

	/**
	 * The Joomla Fields Switch
	 *
	 * @var      boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->set_joomla_fields;
	 */
	public $setJoomlaFields = false;

	/**
	 * The site edit views
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Site.Edit.View')->get($key);
	 */
	public $siteEditView = [];

	/**
	 * The admin list view filter type
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($key);
	 */
	public $adminFilterType = [];

	/**
	 * The Language target
	 *
	 * @var     string
	 * @deprecated 3.3 Use CFactory::_('Config')->lang_target;
	 */
	public $lang = 'admin';

	/**
	 * The lang keys for extentions
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Language.Extractor')->langKeys;
	 */
	public $langKeys = [];

	/**
	 * The Build target Switch
	 *
	 * @var     string
	 * @deprecated 3.3 Use CFactory::_('Config')->build_target;
	 */
	public $target;

	/**
	 * The unique codes
	 *
	 * @var     array
	 * @deprecated 3.3
	 */
	public $uniquecodes = [];

	/**
	 * The unique keys
	 *
	 * @var     array
	 * @deprecated 3.3
	 */
	public $uniquekeys = [];

	/**
	 * The Add contributors Switch
	 *
	 * @var     boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->add_contributors;
	 */
	public $addContributors = false;

	/**
	 * The Custom Script Builder
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Customcode.Dispenser')->hub;
	 */
	public $customScriptBuilder = [];

	/**
	 * The Footable Script Builder
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Footable.Scripts')->get($key);
	 */
	public $footableScripts = [];

	/**
	 * The pathe to the bom file to be used
	 *
	 * @var     string
	 * @deprecated 3.3 Use CFactory::_('Config')->bom_path;
	 */
	public $bomPath;

	/**
	 * The SQL Tweak of admin views
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Registry')->get('builder.sql_tweak');
	 */
	public $sqlTweak = [];

	/**
	 * The validation rules that should be added
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Registry')->get('validation.rules');
	 */
	public $validationRules = [];

	/**
	 * The validation linked to fields
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Registry')->get('validation.linked');
	 */
	public $validationLinkedFields = [];

	/**
	 * The admin views data array
	 *
	 * @var     array
	 * @deprecated 3.3
	 */
	private $_adminViewData = [];

	/**
	 * The field data array
	 *
	 * @var     array
	 * @deprecated 3.3
	 */
	private $_fieldData = [];

	/**
	 * The custom alias builder
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Custom.Alias')->get($key);
	 */
	public $customAliasBuilder = [];

	/**
	 * The field builder type
	 *
	 * 1 = StringManipulation
	 * 2 = SimpleXMLElement
	 *
	 * @var     int
	 * @deprecated 3.3 Use CFactory::_('Config')->field_builder_type;
	 */
	public $fieldBuilderType;

	/**
	 * Set unique Names
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Registry')->get('unique.names');
	 */
	public $uniqueNames = [];

	/**
	 * Set unique Names
	 *
	 * @var    array
	 * @deprecated
	 */
	protected $uniqueFieldNames = [];

	/**
	 * Category other name bucket
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Category.Other.Name')->get($key);
	 */
	public $catOtherName = [];

	/**
	 * The field relations values
	 *
	 * @var     array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Field.Relations')->get($key);
	 */
	public $fieldRelations = [];

	/**
	 * The views default ordering
	 *
	 * @var     array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Views.Default.Ordering')->get($key);
	 */
	public $viewsDefaultOrdering = [];

	/**
	 * Default Fields
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Config')->default_fields;
	 */
	public $defaultFields
		= array('created', 'created_by', 'modified', 'modified_by', 'published',
			'ordering', 'access', 'version', 'hits', 'id');

	/**
	 * The list join fields
	 *
	 * @var     array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.List.Join')->get($key);
	 */
	public $listJoinBuilder = [];

	/**
	 * The list head over ride
	 *
	 * @var     array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.List.Head.Override')->get($key);
	 */
	public $listHeadOverRide = [];

	/**
	 * The linked admin view tabs
	 *
	 * @var     array
	 * @deprecate 3.3 Use CFactory::_('Registry')->get('builder.linked_admin_views');
	 */
	public $linkedAdminViews = [];

	/**
	 * The custom admin view tabs
	 *
	 * @var     array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Custom.Tabs')->get($key);
	 */
	public $customTabs = [];

	/**
	 * The Add Ajax Switch
	 *
	 * @var    boolean
	 * @deprecate 3.3 Use CFactory::_('Config')->add_ajax
	 */
	public $addAjax = false;

	/**
	 * The Add Site Ajax Switch
	 *
	 * @var     boolean
	 * @deprecate 3.3 Use CFactory::_('Config')->add_site_ajax;
	 */
	public $addSiteAjax = false;

	/**
	 * The get Module Script Switch
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Get.Module')->get($key);
	 */
	public $getModule = [];

	/**
	 * The template data
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Template.Data')->get($key);
	 */
	public $templateData = [];

	/**
	 * The layout data
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Layout.Data')->get($key);
	 */
	public $layoutData = [];

	/**
	 * The Encryption Types
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Config')->cryption_types;
	 */
	public $cryptionTypes = array('basic', 'medium', 'whmcs', 'expert');

	/**
	 * The WHMCS Encryption Switch
	 *
	 * @var    boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->whmcs_encryption;
	 */
	public $whmcsEncryption = false;

	/**
	 * The Basic Encryption Switch
	 *
	 * @var    boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->basic_encryption;
	 */
	public $basicEncryption = false;

	/**
	 * The Medium Encryption Switch
	 *
	 * @var    boolean
	 * @deprecated 3.3 Use CFactory::_('Config')->medium_encryption;
	 */
	public $mediumEncryption = false;

	/**
	 * The Custom field Switch per view
	 *
	 * @var    array
	 * @deprecated 3.3
	 */
	public $customFieldScript = [];

	/**
	 * The site main get
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Site.Main.Get')->get($key);
	 */
	public $siteMainGet = [];

	/**
	 * The site dynamic get
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Site.Dynamic.Get')->get($key);
	 */
	public $siteDynamicGet = [];

	/**
	 * The get AS lookup
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Get.As.Lookup')->get($key);
	 */
	public $getAsLookup = [];

	/**
	 * The site fields
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Site.Fields')->get($key);
	 */
	public $siteFields = [];

	/**
	 * The add SQL
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Registry')->get('builder.add_sql');
	 */
	public $addSQL = [];

	/**
	 * The update SQL
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Registry')->get('builder.update_sql');
	 */
	public $updateSQL = [];

	/**
	 * The data by alias keys
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Registry')->get('builder.data_with_alias_keys');
	 */
	protected $dataWithAliasKeys = [];

	/**
	 * The Library Manager
	 *
	 * @var    array
	 * @deprecate 3.3 Use CFactory::_('Compiler.Builder.Library.Manager')->get($key);
	 */
	public $libManager = [];

	/**
	 * The Libraries
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Registry')->get('builder.libraries');
	 */
	public $libraries = [];

	/**
	 * Is minify Enabled
	 *
	 * @var    int
	 * @deprecated 3.3 Use CFactory::_('Config')->minify;
	 */
	public $minify = 0;

	/**
	 * Is Tidy Enabled
	 *
	 * @var    bool
	 * @deprecated 3.3 Use CFactory::_('Config')->tidy;
	 */
	public $tidy = false;

	/**
	 * Set Tidy warning once switch
	 *
	 * @var    bool
	 * @deprecated 3.3 Use CFactory::_('Config')->set_tidy_warning;
	 */
	public $setTidyWarning = false;

	/**
	 * mysql table setting keys
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Config')->mysql_table_keys;
	 */
	public $mysqlTableKeys
		= array(
			'engine'     => array('default' => 'MyISAM'),
			'charset'    => array('default' => 'utf8'),
			'collate'    => array('default' => 'utf8_general_ci'),
			'row_format' => array('default' => '')
		);

	/**
	 * mysql table settings
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Mysql.Table.Setting')->get($key);
	 */
	public $mysqlTableSetting = [];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// we do not yet have this set as an option
		$config['remove_line_breaks']
			= 2; // 2 is global (use the components value)
		// load application
		$this->app = Factory::getApplication();
		// Set the params
		$this->params = ComponentHelper::getParams('com_componentbuilder');
		// Trigger Event: jcb_ce_onBeforeGet
		CFactory::_('Event')->trigger('jcb_ce_onBeforeGet', array(&$config, &$this));
		// set the Joomla version @deprecated
		$this->joomlaVersion = CFactory::_('Config')->joomla_version;
		// set the minfy switch of the JavaScript @deprecated
		$this->minify = CFactory::_('Config')->get('minify', 0);
		// set the global language @deprecated
		$this->langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
		// also set the helper class langTag (for safeStrings)
		ComponentbuilderHelper::$langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
		// setup the main language array
		$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')] = [];
		// check if we have Tidy enabled @deprecated
		$this->tidy = CFactory::_('Config')->get('tidy', false);
		// set the field type builder @deprecated
		$this->fieldBuilderType = CFactory::_('Config')->get('field_builder_type', 2);
		// check the field builder type logic
		if (!CFactory::_('Config')->get('tidy', false) && CFactory::_('Config')->get('field_builder_type', 2) == 2)
		{
			// we do not have the tidy extension set fall back to StringManipulation
			$this->fieldBuilderType = 1;
			// load the sugestion to use string manipulation
			$this->app->enqueueMessage(
				Text::_('<hr /><h3>Field Notice</h3>'), 'Notice'
			);
			$this->app->enqueueMessage(
				Text::_(
					'Since you do not have <b>Tidy</b> extentsion setup on your system, we could not use the SimpleXMLElement class. We instead used <b>string manipulation</b> to build all your fields, this is a faster method, you must inspect the xml files in your component package to see if you are satisfied with the result.<br />You can make this method your default by opening the global options of JCB and under the <b>Global</b> tab set the <b>Field Builder Type</b> to string manipulation.'
				), 'Notice'
			);
		}
		CFactory::_('Config')->set('field_builder_type', $this->fieldBuilderType);
		// load the compiler path @deprecated
		$this->compilerPath = CFactory::_('Config')->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler');
		// load the jcb powers path @deprecated
		$this->jcbPowersPath = CFactory::_('Config')->get('jcb_powers_path', 'libraries/jcb_powers');
		// set the component ID @deprecated
		$this->componentID = CFactory::_('Config')->component_id;
		// set lang prefix @deprecated
		$this->langPrefix = CFactory::_('Config')->lang_prefix;
		// set component code name @deprecated
		$this->componentCodeName = CFactory::_('Config')->component_code_name;
		// set component context @deprecated
		$this->componentContext = CFactory::_('Config')->component_context;
		// set the component name length @deprecated
		$this->componentCodeNameLength = CFactory::_('Config')->component_code_name_length;
		// set if language strings line breaks should be removed @deprecated
		$this->removeLineBreaks = CFactory::_('Config')->remove_line_breaks;
		// set if placeholders should be added to customcode @deprecated
		$this->addPlaceholders = CFactory::_('Config')->get('add_placeholders', false);
		// set if line numbers should be added to comments @deprecated
		$this->debugLinenr = CFactory::_('Config')->get('debug_line_nr', false);
		// set if powers should be added to component (default is true) @deprecated
		$this->addPower = CFactory::_('Config')->get('add_power', true);
		// set the current user
		$this->user = Factory::getUser();
		// Get a db connection.
		$this->db = Factory::getDbo();
		// get global placeholders @deprecated
		$this->globalPlaceholders = CFactory::_('Component.Placeholder')->get();

		// get the custom code from installed files
		CFactory::_('Customcode.Extractor')->run();

		// Trigger Event: jcb_ce_onBeforeGetComponentData
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeGetComponentData'
		);

		// get the component data @deprecated
		$this->componentData = CFactory::_('Component');

		// Trigger Event: jcb_ce_onAfterGetComponentData
		CFactory::_('Event')->trigger(
			'jcb_ce_onAfterGetComponentData'
		);

		// make sure we have a version
		if (strpos((string) CFactory::_('Component')->component_version, '.')
			=== false)
		{
			CFactory::_('Component')->set('component_version ', '1.0.0');
		}
		// update the version
		if (!CFactory::_('Component')->exists('old_component_version')
			&& (CFactory::_('Registry')->get('builder.add_sql', null)
				|| CFactory::_('Registry')->get('builder.update_sql', null)))
		{
			// set the new version
			$version = (array) explode(
				'.', (string) CFactory::_('Component')->component_version
			);
			// get last key
			end($version);
			$key = key($version);
			// just increment the last
			$version[$key]++;
			// set the old version
			CFactory::_('Component')->set('old_component_version', CFactory::_('Component')->component_version);
			// set the new version, and set update switch
			CFactory::_('Component')->set('component_version', implode(
				'.', $version
			));
		}

		// FOR THE HELPER CLASS POWERS
		// Utilities String Helper
		CFactory::_('Power')->get('1f28cb53-60d9-4db1-b517-3c7dc6b429ef', 1);
		// Utilities Array Helper
		CFactory::_('Power')->get('0a59c65c-9daf-4bc9-baf4-e063ff9e6a8a', 1);
		// Utilities Component Helper
		CFactory::_('Power')->get('640b5352-fb09-425f-a26e-cd44eda03f15', 1);
		// Utilities Object Helper
		CFactory::_('Power')->get('91004529-94a9-4590-b842-e7c6b624ecf5', 1);
		// Utilities GetHelper
		CFactory::_('Power')->get('db87c339-5bb6-4291-a7ef-2c48ea1b06bc', 1);
		// Utilities Json Helper
		CFactory::_('Power')->get('4b225c51-d293-48e4-b3f6-5136cf5c3f18', 1);
		// Utilities FormHelper
		CFactory::_('Power')->get('1198aecf-84c6-45d2-aea8-d531aa4afdfa', 1);

		// load powers *+*+*+*+*+*+*+*
		CFactory::_('Power')->load($this->linkedPowers);
		// set the percentage when a language can be added
		$this->percentageLanguageAdd = (int) CFactory::_('Config')->get('percentage_language_add', 50);

		// Trigger Event: jcb_ce_onBeforeGet
		CFactory::_('Event')->trigger(
			'jcb_ce_onAfterGet'
		);

		return true;
	}

	/**
	 * Set the tab/space
	 *
	 * @param   int  $nr  The number of tag/space
	 *
	 * @return  string
	 * @deprecated 3.3 Use Indent::_($nr);
	 */
	public function _t($nr)
	{
		// use global method for conformity
		return Indent::_($nr);
	}

	/**
	 * Trigger events
	 *
	 * @param   string  $event  The event to trigger
	 * @param   mix     $data   The values to pass to the event/plugin
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Event')->trigger($event, $data);
	 */
	public function triggerEvent($event, $data = null)
	{
		return CFactory::_('Event')->trigger($event, $data);
	}

	/**
	 * get all System Placeholders
	 *
	 * @return  array The global placeholders
	 * @deprecated 3.3 Use CFactory::_('Component.Placeholder')->get();
	 */
	public function getGlobalPlaceholders()
	{
		return CFactory::_('Component.Placeholder')->get();
	}

	/**
	 * get all Component Data
	 *
	 * @return  oject The component data
	 * @deprecated 3.3 Use CFactory::_('Component');
	 */
	public function getComponentData()
	{
		return CFactory::_('Component');
	}

	/**
	 * set the language content values to language content array
	 *
	 * @param   string   $target     The target area for the language string
	 * @param   string   $language   The language key string
	 * @param   string   $string     The language string
	 * @param   boolean  $addPrefix  The switch to add langPrefix
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Language')->set($target, $language, $string, $addPrefix);
	 */
	public function setLangContent($target, $language, $string, $addPrefix = false)
	{
		CFactory::_('Language')->set($target, $language, $string, $addPrefix);
	}

	/**
	 * We need to remove all text breaks from all language strings
	 *
	 * @param   string  $string  The language string
	 *
	 * @return  string
	 * @deprecated 3.3
	 */
	public function fixLangString(&$string)
	{
		if (CFactory::_('Config')->remove_line_breaks)
		{
			return trim(str_replace(array(PHP_EOL, "\r", "\n"), '', $string));
		}

		return trim($string);
	}

	/**
	 * Get all Admin View Data
	 *
	 * @param   int  $id  The view ID
	 *
	 * @return  oject The view data
	 * @deprecated 3.3 Use CFactory::_('Adminview.Data')->get($id);
	 */
	public function getAdminViewData($id)
	{
		return CFactory::_('Adminview.Data')->get($id);
	}

	/**
	 * Get all Custom View Data
	 *
	 * @param   int     $id     The view ID
	 * @param   string  $table  The view table
	 *
	 * @return  oject The view data
	 * @deprecated 3.3 Use CFactory::_('Customview.Data')->get($id, $table);
	 */
	public function getCustomViewData($id, $table = 'site_view')
	{
		return CFactory::_('Customview.Data')->get($id, $table);
	}

	/**
	 * Get all Field Data
	 *
	 * @param   int     $id           The field ID
	 * @param   string  $name_single  The view edit or single name
	 * @param   string  $name_list    The view list name
	 *
	 * @return  oject The field data
	 * @deprecated 3.3 Use CFactory::_('Field.Data')->get($id, $name_single, $name_list);
	 */
	public function getFieldData($id, $name_single = null, $name_list = null)
	{
		return CFactory::_('Field.Data')->get($id, $name_single, $name_list);
	}

	/**
	 * set Field details
	 *
	 * @param   object  $field           The field object
	 * @param   string  $singleViewName  The single view name
	 * @param   string  $listViewName    The list view name
	 * @param   string  $amicably        The peaceful resolve
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Field')->set($field, $singleViewName, $listViewName, $amicably);
	 */
	public function setFieldDetails(&$field, $singleViewName = null, $listViewName = null, $amicably = '')
	{
		CFactory::_('Field')->set($field, $singleViewName, $listViewName, $amicably);
	}

	/**
	 * get the list default ordering values
	 *
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  array
	 *
	 */
	public function getListViewDefaultOrdering(&$nameListCode)
	{
		if (CFactory::_('Compiler.Builder.Views.Default.Ordering')->
			get("$nameListCode.add_admin_ordering", 0) == 1)
		{
			foreach (CFactory::_('Compiler.Builder.Views.Default.Ordering')->
				get("$nameListCode.admin_ordering_fields", []) as $order_field)
			{
				if (($order_field_name = CFactory::_('Field.Database.Name')->get(
						$nameListCode, $order_field['field']
					)) !== false)
				{
					// just the first field is the based ordering state
					return array(
						'name'      => $order_field_name,
						'direction' => $order_field['direction']
					);
				}
			}
		}

		// the default
		return array(
			'name'      => 'a.id',
			'direction' => 'DESC'
		);
	}

	/**
	 * get the field database name and AS prefix
	 *
	 * @param   string  $nameListCode  The list view name
	 * @param   int     $fieldId       The field ID
	 * @param   string  $targetArea    The area being targeted
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Field.Database.Name')->get($nameListCode, $fieldId, $targetArea);
	 */
	public function getFieldDatabaseName($nameListCode, int $fieldId, $targetArea = 'builder.list')
	{
		return CFactory::_('Field.Database.Name')->get($nameListCode, $fieldId, $targetArea);
	}

	/**
	 * Get the field's actual type
	 *
	 * @param   object  $field  The field object
	 *
	 * @return  string   Success returns field type
	 * @deprecated 3.3 Use CFactory::_('Field.Type.Name')->get($field);
	 */
	public function getFieldType(&$field)
	{
		return CFactory::_('Field.Type.Name')->get($field);
	}

	/**
	 * Get the field's actual name
	 *
	 * @param   object  $field         The field object
	 * @param   string  $listViewName  The list view name
	 * @param   string  $amicably      The peaceful resolve (for fields in subforms in same view :)
	 *
	 * @return  string   Success returns field name
	 * @deprecated 3.3 Use CFactory::_('Field.Name')->get($field, $listViewName, $amicably);
	 */
	public function getFieldName(&$field, $listViewName = null, $amicably = '')
	{
		return CFactory::_('Field.Name')->get($field, $listViewName, $amicably);
	}

	/**
	 * Count how many times the same field is used per view
	 *
	 * @param   string  $name  The name of the field
	 * @param   string  $view  The name of the view
	 *
	 * @return  void
	 * @deprecated Use CFactory::_('Field.Unique.Name')->set($name, $view);
	 */
	protected function setUniqueNameCounter($name, $view)
	{
		CFactory::_('Field.Unique.Name')->set($name, $view);
	}

	/**
	 * Naming each field with an unique name
	 *
	 * @param   string  $name  The name of the field
	 * @param   string  $view  The name of the view
	 *
	 * @return  string   the name
	 * @deprecated
	 */
	protected function uniqueName($name, $view)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * Set get Data
	 *
	 * @param   array   $ids        The ids of the dynamic get
	 * @param   string  $view_code  The view code name
	 * @param   string  $context    The context for events
	 *
	 * @return  oject the get dynamicGet data
	 * @deprecated Use CFactory::_('Dynamicget.Data')->get($ids, $view_code, $context);
	 */
	public function setGetData($ids, $view_code, $context)
	{
		return CFactory::_('Dynamicget.Data')->get($ids, $view_code, $context);
	}

	/**
	 * Set the script for the customcode dispenser
	 *
	 * @param   string       $script   The script
	 * @param   string       $first    The first key
	 * @param   string|null  $second   The second key (if not set we use only first key)
	 * @param   string|null  $third    The third key (if not set we use only first and second key)
	 * @param   array        $config   The config options
	 * @param   bool         $base64   The switch to decode base64 the script
	 *                                    default: true
	 * @param   bool         $dynamic  The switch to dynamic update the script
	 *                                    default: true
	 * @param   bool         $add      The switch to add to exiting instead of replace
	 *                                    default: false
	 *
	 * @return  bool    true on success
	 * @deprecated 3.3 Use CFactory::_('Customcode.Dispenser')->set($script, $first, $second, $third, $config, $base64, $dynamic, $add);
	 */
	public function setCustomScriptBuilder(
		&$script,
		string $first,
		?string $second = null,
		?string $third = null,
		array $config = array(),
		bool $base64 = true,
		bool $dynamic = true,
		bool $add = false
	): bool
	{
		return CFactory::_('Customcode.Dispenser')->set($script, $first, $second, $third, $config, $base64, $dynamic, $add);
	}

	/**
	 * get the a script from the custom script builder
	 *
	 * @param   string  $first    The first key
	 * @param   string  $second   The second key
	 * @param   string  $prefix   The prefix to add in front of the script if found
	 * @param   string  $note     The switch/note to add to the script
	 * @param   bool    $unset    The switch to unset the value if found
	 * @param   string  $default  The switch/string to use as default return if script not found
	 * @param   string  $sufix    The sufix  to add after the script if found
	 *
	 * @return  mix    The string/script if found or the default value if not found
	 * @deprecated 3.3 Use CFactory::_('Customcode.Dispenser')->get($first, $second, $prefix, $note, $unset, $default, $sufix);
	 */
	public function getCustomScriptBuilder($first, $second, $prefix = '',
		$note = null, $unset = null, $default = null, $sufix = ''
	)
	{
		return CFactory::_('Customcode.Dispenser')->get($first, $second, $prefix, $note, $unset, $default, $sufix);
	}

	/**
	 * To limit the SQL Demo date build in the views
	 *
	 * @param   array  $settings  Tweaking array.
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	public function setSqlTweaking($settings)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * check if an update SQL is needed
	 *
	 * @param   mix     $old     The old values
	 * @param   mix     $new     The new values
	 * @param   string  $type    The type of values
	 * @param   int     $key     The id/key where values changed
	 * @param   array   $ignore  The ids to ignore
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Model.Updatesql')->set($old, $new, $type, $key, $ignore);
	 */
	protected function setUpdateSQL($old, $new, $type, $key = null,
	                                $ignore = null
	)
	{
		CFactory::_('Model.Updatesql')->set($old, $new, $type, $key, $ignore);
	}

	/**
	 * Set the add sql
	 *
	 * @param   string     $type  The type of values
	 * @param   int        $item  The item id to add
	 * @param   int|null   $key   The id/key where values changed
	 *
	 * @return void
	 * @deprecated 3.3
	 */
	protected function setAddSQL(string $type, int $item, ?int $key = null)
	{
		// add key if found
		if ($key)
		{
			CFactory::_('Registry')->set('builder.add_sql.' . $type . '.' . $key . '.' . $item, $item);
		}
		else
		{
			// convert adminview id to name
			if ('adminview' === $type)
			{
				CFactory::_('Registry')->set('builder.add_sql.' . $type, StringHelper::safe(
					$this->getAdminViewData($item)->name_single
				));
			}
			else
			{
				CFactory::_('Registry')->set('builder.add_sql.' . $type, $item);
			}
		}
	}

	/**
	 * Get Item History values
	 *
	 * @param   string  $type  The type of item
	 * @param   int     $id    The item ID
	 *
	 * @return  object    The history
	 * @deprecated 3.3 Use CFactory::_('History')->get($type, $id);
	 */
	protected function getHistoryWatch($type, $id)
	{
		return CFactory::_('History')->get($type, $id);
	}

	/**
	 * Set Item History Watch
	 *
	 * @param   Object  $object  The history object
	 * @param   int     $action  The action to take
	 *                           0 = remove watch
	 *                           1 = add watch
	 * @param   string  $type    The type of item
	 *
	 * @return  bool
	 * @deprecated 3.3
	 */
	protected function setHistoryWatch($object, $action)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * Set Template and Layout Data
	 *
	 * @param   string   $default    The content to check
	 * @param   string   $view       The view code name
	 * @param   boolean  $found      The proof that something was found
	 * @param   array    $templates  The option to pass templates keys (to avoid search)
	 * @param   array    $layouts    The option to pass layout keys (to avoid search)
	 *
	 * @return  boolean if something was found true
	 * @deprecated 3.3 Use CFactory::_('Templatelayout.Data')->set($default, $view, $found, $templates, $layouts);
	 */
	public function setTemplateAndLayoutData($default, $view, $found = false,
	                                         $templates = array(), $layouts = array()
	)
	{
		return CFactory::_('Templatelayout.Data')->set($default, $view, $found, $templates, $layouts);
	}

	/**
	 * Get Data With Alias
	 *
	 * @param   string  $n_ame  The alias name
	 * @param   string  $table  The table where to find the alias
	 * @param   string  $view   The view code name
	 *
	 * @return  array The data found with the alias
	 * @deprecated 3.3 Use CFactory::_('Alias.Data')->get($n_ame, $table, $view);
	 */
	protected function getDataWithAlias($n_ame, $table, $view)
	{
		return CFactory::_('Alias.Data')->get($n_ame, $table, $view);
	}

	/**
	 * set Data With Alias Keys
	 *
	 * @param   string  $table  The table where to find the alias
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	protected function setDataWithAliasKeys($table)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * Get Media Library Data and store globally
	 *
	 * @param   string  $id  the library id
	 *
	 * @return  bool    true on success
	 * @deprecated 3.3 Use CFactory::_('Library.Data')->get($id);
	 */
	protected function getMediaLibrary($id)
	{
		return CFactory::_('Library.Data')->get($id);
	}

	/**
	 * Set Language Place Holders
	 *
	 * @param   string  $content  The content
	 *
	 * @return  string The content with the updated Language place holder
	 * @deprecated 3.3 Use CFactory::_('Language.Extractor')->engine($content)
	 */
	public function setLangStrings($content)
	{
		return CFactory::_('Language.Extractor')->engine($content);
	}

	/**
	 * Set the language String
	 *
	 * @param   string  $string  The plan text string (English)
	 *
	 * @return  string   The key language string (all uppercase)
	 * @deprecated 3.3 Use CFactory::_('Language')->key($string);
	 */
	public function setLang($string)
	{
		return CFactory::_('Language')->key($string);
	}

	/**
	 * Set Data Selection of the dynamic get
	 *
	 * @param   string  $method_key  The method unique key
	 * @param   string  $view_code   The code name of the view
	 * @param   string  $string      The data string
	 * @param   string  $asset       The asset in question
	 * @param   string  $as          The as string
	 * @param   int     $row_type    The row type
	 * @param   string  $type        The target type (db||view)
	 *
	 * @return  array the select query
	 * @deprecated 3.3 Use CFactory::_('Dynamicget.Selection')->get($method_key, $view_code, $string, $asset, $as, $type, $row_type);
	 */
	public function setDataSelection($method_key, $view_code, $string, $asset,
	                                 $as, $row_type, $type
	)
	{
		return CFactory::_('Dynamicget.Selection')->get(
			$method_key, $view_code, $string, $asset,
			$as, $type, $row_type);
	}

	/**
	 * Get the View Table Name
	 *
	 * @param   int  $id  The admin view in
	 *
	 * @return  string view code name
	 * @deprecated 3.3
	 */
	public function getViewTableName($id)
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('a.name_single')));
		$query->from(
			$this->db->quoteName('#__componentbuilder_admin_view', 'a')
		);
		$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
		$this->db->setQuery($query);

		return StringHelper::safe($this->db->loadResult());
	}

	/**
	 * Build the SQL dump String for a view
	 *
	 * @param   string  $tables   The tables to use in build
	 * @param   string  $view     The target view/table to dump in
	 * @param   int     $view_id  The id of the target view
	 *
	 * @return  string on success with the Dump SQL
	 * @deprecated 3.3 Use CFactory::_('Model.Sqldump')->key($tables, $view, $view_id);
	 */
	public function buildSqlDump($tables, $view, $view_id)
	{
		return CFactory::_('Model.Sqldump')->key($tables, $view, $view_id);
	}

	/**
	 * Escape the values for a SQL dump
	 *
	 * @param   string  $value  the value to escape
	 *
	 * @return  string on success with escaped string
	 * @deprecated 3.3
	 */
	public function mysql_escape($value)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * Creating an uniqueCode
	 *
	 * @param   string  $code  The planed code
	 *
	 * @return  string The unique code
	 * @deprecated 3.3 use Unique::code($code);
	 */
	public function uniqueCode($code)
	{
		return Unique::code($code);
	}

	/**
	 * Creating an unique local key
	 *
	 * @param   int  $size  The key size
	 *
	 * @return  string The unique localkey
	 * @deprecated 3.3 use Unique::get($size);
	 */
	public function uniquekey($size, $random = false,
	                          $newBag = "vvvvvvvvvvvvvvvvvvv"
	)
	{
		return Unique::get($size);
	}

	/**
	 * Check for footable scripts
	 *
	 * @param   string  $content  The content to check
	 *
	 * @return  boolean True if found
	 * @deprecated 3.3
	 */
	public function getFootableScripts($content)
	{
		if (strpos($content, 'footable') !== false)
		{
			return true;
		}

		return false;
	}

	/**
	 * Check for getModules script
	 *
	 * @param   string  $content  The content to check
	 *
	 * @return  boolean True if found
	 * @deprecated 3.3
	 */
	public function getGetModule($content)
	{
		if (strpos($content, 'this->getModules(') !== false)
		{
			return true;
		}

		return false;
	}

	/**
	 * Check for get Google Chart script
	 *
	 * @param   string  $content  The content to check
	 *
	 * @return  boolean True if found
	 * @deprecated 3.3
	 */
	public function getGoogleChart($content)
	{
		if (strpos($content, 'Chartbuilder(') !== false)
		{
			return true;
		}

		return false;
	}

	/**
	 * Set the dynamic values in strings here
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *                           We can now at any time debug the
	 *                           dynamic build values if it gets broken
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Customcode')->update($string, $debug);
	 */
	public function setDynamicValues($string, $debug = 0)
	{
		return CFactory::_('Customcode')->update($string, $debug);
	}

	/**
	 * Set the external code string & load it in to string
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Customcode.External')->set($string, $debug);
	 */
	public function setExternalCodeString($string, $debug = 0)
	{
		return CFactory::_('Customcode.External')->set($string, $debug);
	}

	/**
	 * Get the External Code/String
	 *
	 * @param   string  $string  The content to check
	 * @param   array   $bucket  The Placeholders bucket
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	protected function getExternalCodeString($target, &$bucket)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * Cut the External Code/String
	 *
	 * @param   string  $string    The content to cut
	 * @param   string  $sequence  The cutting sequence
	 * @param   string  $key       The content key
	 *
	 * @return  string
	 * @deprecated 3.3
	 */
	protected function cutExternalCodeString($string, $sequence, $key)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return '';
	}

	/**
	 * We start set the custom code data & can load it in to string
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Customcode')->set($string, $debug, $not);
	 */
	public function setCustomCodeData($string, $debug = 0, $not = null)
	{
		return CFactory::_('Customcode')->set($string, $debug, $not);
	}

	/**
	 * Insert the custom code into the string
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *
	 * @return  string on success
	 * @deprecated 3.3
	 */
	protected function insertCustomCode($ids, $string, $debug = 0)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return '';
	}

	/**
	 * Insert the custom code into the string
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *
	 * @return  string on success
	 * @deprecated 3.3
	 */
	protected function buildCustomCodePlaceholders($item, &$code, $debug = 0)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return '';
	}

	/**
	 * Set a type of placeholder with set of values
	 *
	 * @param   string  $key     The main string for placeholder key
	 * @param   array   $values  The values to add
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Placeholder')->setType($key, $values);
	 */
	public function setThesePlaceHolders($key, $values)
	{
		// use the new container class
		CFactory::_('Placeholder')->setType($key, $values);
	}

	/**
	 * Remove a type of placeholder by main string
	 *
	 * @param   string  $like  The main string for placeholder key
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Placeholder')->clearType($key);
	 */
	public function clearFromPlaceHolders($like)
	{
		// use the new container class
		CFactory::_('Placeholder')->clearType($like);
	}

	/**
	 * to unset stuff that are private or protected
	 *
	 */
	public function unsetNow($remove)
	{
		unset($this->$remove);
	}

	/**
	 * Get the other languages
	 *
	 * @param   array  $values  The lang strings to get
	 *
	 *
	 * @return  void
	 *
	 */
	public function getMultiLangStrings($values)
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->from(
			$this->db->quoteName(
				'#__componentbuilder_language_translation', 'a'
			)
		);
		if (ArrayHelper::check($values))
		{
			$query->select(
				$this->db->quoteName(
					array('a.id', 'a.translation', 'a.source', 'a.components',
						'a.modules', 'a.plugins', 'a.published')
				)
			);
			$query->where(
				$this->db->quoteName('a.source') . ' IN (' . implode(
					',', array_map(
						fn($a) => $this->db->quote($a), $values
					)
				) . ')'
			);
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				return $this->db->loadAssocList('source');
			}
		}

		return false;
	}

	/**
	 * Set the Current language values to DB
	 *
	 *
	 * @return  void
	 *
	 */
	public function setLangPlaceholders($strings, int $target_id,
	                                    $target = 'components'
	)
	{
		$counterInsert = 0;
		$counterUpdate = 0;
		$today         = Factory::getDate()->toSql();
		foreach (
			$this->languages[$target][CFactory::_('Config')->get('lang_tag', 'en-GB')] as $area => $placeholders
		)
		{
			foreach ($placeholders as $placeholder => $string)
			{
				// to keep or remove
				$remove = false;
				// build the translations
				if (StringHelper::check($string)
					&& isset($this->multiLangString[$string]))
				{
					// make sure we have converted the string to array
					if (isset($this->multiLangString[$string]['translation'])
						&& JsonHelper::check(
							$this->multiLangString[$string]['translation']
						))
					{
						$this->multiLangString[$string]['translation']
							= json_decode(
							(string) $this->multiLangString[$string]['translation'], true
						);
					}
					// if we have an array continue
					if (isset($this->multiLangString[$string]['translation'])
						&& ArrayHelper::check(
							$this->multiLangString[$string]['translation']
						))
					{
						// great lets build the multi languages strings
						foreach (
							$this->multiLangString[$string]['translation'] as
							$translations
						)
						{
							if (isset($translations['language'])
								&& isset($translations['translation']))
							{
								// build arrays
								if (!isset($this->languages[$target][$translations['language']]))
								{
									$this->languages[$target][$translations['language']]
										= [];
								}
								if (!isset($this->languages[$target][$translations['language']][$area]))
								{
									$this->languages[$target][$translations['language']][$area]
										= [];
								}
								$this->languages[$target][$translations['language']][$area][$placeholder]
									= CFactory::_('Language')->fix($translations['translation']);
							}
						}
					}
					else
					{
						// remove this string not to be checked again
						$remove = true;
					}
				}
				// do the database management
				if (StringHelper::check($string)
					&& ($key = array_search($string, $strings)) !== false)
				{
					if (isset($this->multiLangString[$string]))
					{
						// update the existing placeholder in db
						$id = $this->multiLangString[$string]['id'];
						if (JsonHelper::check(
							$this->multiLangString[$string][$target]
						))
						{
							$targets = (array) json_decode(
								(string) $this->multiLangString[$string][$target], true
							);
							// check if we should add the target ID
							if (in_array($target_id, $targets))
							{
								// only skip the update if the string is published and has the target ID
								if ($this->multiLangString[$string]['published']
									== 1)
								{
									continue;
								}
							}
							else
							{
								$targets[] = $target_id;
							}
						}
						else
						{
							$targets = array($target_id);
						}
						// start the bucket for this lang
						$this->setUpdateExistingLangStrings(
							$id, $target, $targets, 1, $today, $counterUpdate
						);

						$counterUpdate++;

						// load to db
						$this->setExistingLangStrings(50);
						// remove string if needed
						if ($remove)
						{
							unset($this->multiLangString[$string]);
						}
					}
					else
					{
						// add the new lang placeholder to the db
						if (!isset($this->newLangStrings[$target]))
						{
							$this->newLangStrings[$target] = [];
						}
						$this->newLangStrings[$target][$counterInsert]
							= [];
						$this->newLangStrings[$target][$counterInsert][]
							= $this->db->quote(
							json_encode(array($target_id))
						); // 'target'
						$this->newLangStrings[$target][$counterInsert][]
							= $this->db->quote(
							$string
						);  // 'source'
						$this->newLangStrings[$target][$counterInsert][]
							= $this->db->quote(
							1
						);   // 'published'
						$this->newLangStrings[$target][$counterInsert][]
							= $this->db->quote(
							$today
						);  // 'created'
						$this->newLangStrings[$target][$counterInsert][]
							= $this->db->quote(
							(int) $this->user->id
						);   // 'created_by'
						$this->newLangStrings[$target][$counterInsert][]
							= $this->db->quote(
							1
						);   // 'version'
						$this->newLangStrings[$target][$counterInsert][]
							= $this->db->quote(
							1
						);   // 'access'

						$counterInsert++;

						// load to db
						$this->setNewLangStrings($target, 100);
					}
					// only set the string once
					unset($strings[$key]);
				}
			}
		}
		// just to make sure all is done
		$this->setExistingLangStrings();
		$this->setNewLangStrings($target);
	}

	/**
	 * store the language placeholders
	 *
	 * @param   string  $target  The target extention type
	 * @param   int     $when    To set when to update
	 *
	 * @return  void
	 *
	 */
	protected function setNewLangStrings($target, $when = 1)
	{
		if (isset($this->newLangStrings[$target])
			&& count(
				(array) $this->newLangStrings[$target]
			) >= $when)
		{
			// Create a new query object.
			$query    = $this->db->getQuery(true);
			$continue = false;
			// Insert columns.
			$columns = array($target, 'source', 'published', 'created',
				'created_by', 'version', 'access');
			// Prepare the insert query.
			$query->insert(
				$this->db->quoteName('#__componentbuilder_language_translation')
			);
			$query->columns($this->db->quoteName($columns));
			foreach ($this->newLangStrings[$target] as $values)
			{
				if (count((array) $values) == 7)
				{
					$query->values(implode(',', $values));
					$continue = true;
				}
				else
				{
					// TODO line mismatch... should not happen
				}
			}
			// clear the values array
			$this->newLangStrings[$target] = [];
			if (!$continue)
			{
				return false; // insure we dont continue if no values were loaded
			}
			// Set the query using our newly populated query object and execute it.
			$this->db->setQuery($query);
			$this->db->execute();
		}
	}

	/**
	 * update the language placeholders
	 *
	 * @param   int  $when  To set when to update
	 *
	 * @return  void
	 *
	 */
	protected function setExistingLangStrings($when = 1)
	{
		if (count((array) $this->existingLangStrings) >= $when)
		{
			foreach ($this->existingLangStrings as $values)
			{
				// Create a new query object.
				$query = $this->db->getQuery(true);
				// Prepare the update query.
				$query->update(
					$this->db->quoteName(
						'#__componentbuilder_language_translation'
					)
				)->set($values['fields'])->where($values['conditions']);
				// Set the query using our newly populated query object and execute it.
				$this->db->setQuery($query);
				$this->db->execute();
			}
			// clear the values array
			$this->existingLangStrings = [];
		}
	}

	/**
	 * Remove exiting language translation stings
	 *
	 * @param   int  $id  To string ID to remove
	 *
	 * @return  void
	 *
	 */
	protected function removeExitingLangString($id)
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		// delete all custom keys for user 1001.
		$conditions = array(
			$this->db->quoteName('id') . ' = ' . (int) $id
		);

		$query->delete(
			$this->db->quoteName('#__componentbuilder_language_translation')
		);
		$query->where($conditions);

		$this->db->setQuery($query);
		$this->db->execute();
	}

	/**
	 * Function to purge the unused languge strings
	 *
	 * @param   string  $values  the active strings
	 *
	 * @return  void
	 *
	 */
	public function purgeLanuageStrings($values, $target_id,
	                                    $target = 'components'
	)
	{
		// the target types are
		$target_types = array('components' => 'components',
		                      'modules'    => 'modules',
		                      'plugins'    => 'plugins');
		// make sure we only work with preset targets
		if (isset($target_types[$target]))
		{
			// remove the current target
			unset($target_types[$target]);
			// Create a new query object.
			$query = $this->db->getQuery(true);
			$query->from(
				$this->db->quoteName(
					'#__componentbuilder_language_translation', 'a'
				)
			);
			$query->select(
				$this->db->quoteName(
					array('a.id', 'a.translation', 'a.components', 'a.modules',
						'a.plugins')
				)
			);
			// get all string that are not linked to this component
			$query->where(
				$this->db->quoteName('a.source') . ' NOT IN (' . implode(
					',', array_map(
						fn($a) => $this->db->quote($a), $values
					)
				) . ')'
			);
			$query->where($this->db->quoteName('a.published') . ' = 1');
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				$counterUpdate = 0;
				$otherStrings  = $this->db->loadAssocList();
				$today         = Factory::getDate()->toSql();
				foreach ($otherStrings as $item)
				{
					if (JsonHelper::check($item[$target]))
					{
						$targets = (array) json_decode((string) $item[$target], true);
						// if component is not found ignore this string, and do nothing
						if (($key = array_search($target_id, $targets))
							!== false)
						{
							// first remove the component from the string
							unset($targets[$key]);
							// check if there are more components
							if (ArrayHelper::check($targets))
							{
								// just update the string to unlink the current component
								$this->setUpdateExistingLangStrings(
									$item['id'], $target, $targets, 1, $today,
									$counterUpdate
								);

								$counterUpdate++;

								// load to db
								$this->setExistingLangStrings(50);
							}
							// check if this string has been worked on or is linked to other extensions
							else
							{
								// the action (1 = remove, 2 = archive, 0 = do nothing)
								$action_with_string = 1;
								// now check if it is linked to other extensions
								foreach ($target_types as $other_target)
								{
									// just one linked extension type is enough to stop the search
									if ($action_with_string
										&& JsonHelper::check(
											$item[$other_target]
										))
									{
										$other_targets = (array) json_decode(
											(string) $item[$other_target], true
										);
										// check if linked to other extensions
										if (ArrayHelper::check(
											$other_targets
										))
										{
											$action_with_string
												= 0; // do nothing
										}
									}
								}
								// check we should just archive or remove string
								if ($action_with_string
									&& JsonHelper::check(
										$item['translation']
									))
								{
									$translation = json_decode(
										(string) $item['translation'], true
									);
									if (ArrayHelper::check(
										$translation
									))
									{
										// only archive the item and update the string to unlink the current component
										$this->setUpdateExistingLangStrings(
											$item['id'], $target, $targets, 2,
											$today, $counterUpdate
										);

										$counterUpdate++;

										// load to db
										$this->setExistingLangStrings(50);

										$action_with_string
											= 2; // we archived it
									}
								}
								// remove the string since no translation found and not linked to any other extensions
								if ($action_with_string == 1)
								{
									$this->removeExitingLangString($item['id']);
								}
							}
						}
					}
				}
				// load to db
				$this->setExistingLangStrings();
			}
		}
	}

	/**
	 * just to add lang string to the existing Lang Strings array
	 *
	 * @return  void
	 *
	 */
	protected function setUpdateExistingLangStrings($id, $target, $targets,
	                                                $published, $today, $counterUpdate
	)
	{
		// start the bucket for this lang
		$this->existingLangStrings[$counterUpdate]               = [];
		$this->existingLangStrings[$counterUpdate]['id']         = (int) $id;
		$this->existingLangStrings[$counterUpdate]['conditions'] = [];
		$this->existingLangStrings[$counterUpdate]['conditions'][]
		                                                         = $this->db->quoteName(
				'id'
			) . ' = ' . $this->db->quote($id);
		$this->existingLangStrings[$counterUpdate]['fields']     = [];
		$this->existingLangStrings[$counterUpdate]['fields'][]
		                                                         = $this->db->quoteName(
				$target
			) . ' = ' . $this->db->quote(json_encode($targets));
		$this->existingLangStrings[$counterUpdate]['fields'][]
		                                                         = $this->db->quoteName(
				'published'
			) . ' = ' . $this->db->quote($published);
		$this->existingLangStrings[$counterUpdate]['fields'][]
		                                                         = $this->db->quoteName(
				'modified'
			) . ' = ' . $this->db->quote($today);
		$this->existingLangStrings[$counterUpdate]['fields'][]
		                                                         = $this->db->quoteName(
				'modified_by'
			) . ' = ' . $this->db->quote((int) $this->user->id);
	}

	/**
	 * get the custom code from the system
	 *
	 * @param   array|null     $ids           The custom code ides if known
	 * @param   int|null       $setLang       The set lang switch
	 * @param   int            $debug         The switch to debug the update
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Customcode')->get($ids, $setLang, $debug);
	 */
	public function getCustomCode(?array $ids = null, bool $setLang = true, int $debug = 0)
	{
		CFactory::_('Customcode')->get($ids, $setLang, $debug);
	}

	/**
	 * check if we already have these ids in local memory
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	protected function checkCustomCodeMemory($ids)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * get all the powers linkd to this component
	 *
	 * @return void
	 * @deprecated 3.3 Use CFactory::_('Power')->load($guids);
	 */
	protected function getPowers($guids)
	{
		CFactory::_('Power')->load($guids);
	}

	/**
	 * get a power linkd to this component
	 *
	 * @return mixed
	 * @deprecated 3.3 Use CFactory::_('Power')->get($guid, $build);
	 */
	public function getPower($guid, $build = 0)
	{
		CFactory::_('Power')->get($guid, $build);
	}

	/**
	 * set a power linkd to this component
	 *
	 * @return bool
	 * @deprecated 3.3
	 */
	protected function setPower($guid)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return false;
	}

	/**
	 * get the Joomla module path
	 *
	 * @return  string of module path and target site area on success
	 * @deprecated 3.3
	 */
	protected function getModulePath($id)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return '';
	}

	/**
	 * get the Joomla Modules IDs
	 *
	 * @return  array of IDs on success
	 * @deprecated 3.3
	 */
	protected function getModuleIDs()
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return [];
	}

	/**
	 * set the Joomla modules
	 *
	 * @return  true
	 * @deprecated 3.3 Use CFactory::_('Joomlamodule.Data')->set($id);
	 */
	public function setJoomlaModule($id, &$component)
	{
		return CFactory::_('Joomlamodule.Data')->set($id);
	}

	/**
	 * get the module xml template
	 *
	 * @return  string
	 * @deprecated 3.3
	 */
	public function getModuleXMLTemplate(&$module)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * get the module admin custom script field
	 *
	 * @return  string
	 * @deprecated 3.3
	 */
	public function getModAdminVvvvvvvdm($fieldScriptBucket)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * get the Joomla plugins IDs
	 *
	 * @return  array of IDs on success
	 * @deprecated 3.3
	 */
	protected function getPluginIDs()
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return [];
	}

	/**
	 * get the Joomla plugin path
	 *
	 * @return  string of plugin path on success
	 * @deprecated 3.3
	 */
	protected function getPluginPath($id)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return '';
	}

	/**
	 * set the Joomla plugins
	 *
	 * @return  true
	 * @deprecated 3.3 Use CFactory::_('Joomlamodule.Data')->set($id);
	 */
	public function setJoomlaPlugin($id, &$component)
	{
		return CFactory::_('Joomlaplugin.Data')->set($id);
	}

	/**
	 * get the plugin xml template
	 *
	 * @return  string
	 * @deprecated 3.3
	 */
	public function getPluginXMLTemplate(&$plugin)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= PHP_EOL . '<extension type="plugin" version="'
			. CFactory::_('Config')->joomla_versions[CFactory::_('Config')->joomla_version]['xml_version'] . '" group="'
			. strtolower((string) $plugin->group) . '" method="upgrade">';
		$xml .= PHP_EOL . Indent::_(1) . '<name>' . $plugin->lang_prefix
			. '</name>';
		$xml .= PHP_EOL . Indent::_(1) . '<creationDate>' . Placefix::_h('BUILDDATE') . '</creationDate>';
		$xml .= PHP_EOL . Indent::_(1) . '<author>' . Placefix::_h('AUTHOR') . '</author>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorEmail>' . Placefix::_h('AUTHOREMAIL') . '</authorEmail>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorUrl>' . Placefix::_h('AUTHORWEBSITE') . '</authorUrl>';
		$xml .= PHP_EOL . Indent::_(1) . '<copyright>' . Placefix::_h('COPYRIGHT') . '</copyright>';
		$xml .= PHP_EOL . Indent::_(1) . '<license>' . Placefix::_h('LICENSE') . '</license>';
		$xml .= PHP_EOL . Indent::_(1) . '<version>' . $plugin->plugin_version
			. '</version>';
		$xml .= PHP_EOL . Indent::_(1) . '<description>' . $plugin->lang_prefix
			. '_XML_DESCRIPTION</description>';
		$xml .= Placefix::_h('MAINXML');
		$xml .= PHP_EOL . '</extension>';

		return $xml;
	}

	/**
	 * store the code
	 *
	 * @param   int  $when  To set when to update
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	protected function setNewCustomCode($when = 1)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * store the code
	 *
	 * @param   int  $when  To set when to update
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	protected function setExistingCustomCode($when = 1)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * get the custom code from the local files
	 *
	 * @param   array   $paths  The local paths to parse
	 * @param   string  $today  The date for today
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Customcode.Extractor')->run();
	 */
	protected function customCodeFactory(&$paths, &$today)
	{
		CFactory::_('Customcode.Extractor')->run();
	}

	/**
	 * search a file for placeholders and store result
	 *
	 * @param   array   $counter       The counter for the arrays
	 * @param   string  $file          The file path to search
	 * @param   array   $searchArray   The values to search for
	 * @param   array   $placeholders  The values to replace in the code being stored
	 * @param   string  $today         The date for today
	 *
	 * @return  array    on success
	 *
	 * @deprecated 3.3
	 */
	protected function searchFileContent(&$counter, &$file, &$target,
	                                     &$searchArray, &$placeholders, &$today
	)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return [];
	}

	/**
	 * Set a hash of a file and/or string
	 *
	 * @param   string  $string  The code string
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Customcode.Hash')->set($script);
	 */
	protected function setDynamicHASHING($script)
	{
		return CFactory::_('Customcode.Hash')->set($script);
	}

	/**
	 * Lock a string with bsae64 (basic)
	 *
	 * @param   string  $string  The code string
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Customcode.LockBase')->set($script);
	 */
	protected function setBase64LOCK($script)
	{
		return CFactory::_('Customcode.LockBase')->set($script);
	}

	/**
	 * Set the JCB GUI code placeholder
	 *
	 * @param   string  $string  The code string
	 * @param   array   $config  The placeholder config values
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Customcode.Gui')->set($string, $config);
	 */
	public function setGuiCodePlaceholder($string, $config)
	{
		return CFactory::_('Customcode.Gui')->set($string, $config);
	}

	/**
	 * search a code to see if there is already any custom
	 * code or other reasons not to add the GUI code placeholders
	 *
	 * @param   string  $code  The code to check
	 *
	 * @return  boolean  true if GUI code placeholders can be added
	 * @deprecated 3.3
	 */
	protected function canAddGuiCodePlaceholder(&$code)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return false;
	}

	/**
	 * search a file for gui code blocks that were updated in the IDE
	 *
	 * @param   string  $file          The file path to search
	 * @param   array   $placeholders  The values to replace in the code being stored
	 * @param   string  $today         The date for today
	 * @param   string  $target        The target path type
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Customcode.Gui')->search($file, $placeholders, $today, $target);
	 */
	protected function guiCodeSearch(&$file, &$placeholders, &$today, &$target)
	{
		CFactory::_('Customcode.Gui')->search($file, $placeholders, $today, $target);
	}

	/**
	 * Check if this line should be added
	 *
	 * @param   string  $replaceKey   The key to remove from line
	 * @param   int     $type         The line type
	 * @param   string  $lineContent  The line to check
	 *
	 * @return  bool true    on success
	 *
	 * @deprecated 3.3
	 */
	protected function addLineChecker($replaceKey, $type, $lineContent)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return false;
	}

	/**
	 * set the start replace placeholder
	 *
	 * @param   int     $id            The comment id
	 * @param   int     $commentType   The comment type
	 * @param   string  $startReplace  The main replace string
	 *
	 * @return  array    on success
	 *
	 * @deprecated 3.3
	 */
	protected function setStartReplace($id, $commentType, $startReplace)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return [];
	}

	/**
	 * search for the system id in the line given
	 *
	 * @param   string  $lineContent   The file path to search
	 * @param   string  $placeholders  The values to search for
	 * @param   int     $commentType   The comment type
	 *
	 * @return  int    on success
	 *
	 * @deprecated 3.3
	 */
	protected function getSystemID(&$lineContent, $placeholders, $commentType)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return null;
	}

	/**
	 * Reverse Engineer the dynamic placeholders (TODO hmmmm this is not ideal)
	 *
	 * @param   string  $string        The string to revers
	 * @param   array   $placeholders  The values to search for
	 * @param   string  $target        The target path type
	 * @param   int     $id            The custom code id
	 * @param   string  $field         The field name
	 * @param   string  $table         The table name
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Placeholder.Reverse')->engine($string, $placeholders, $target, $id, $field, $table);
	 */
	protected function reversePlaceholders($string, &$placeholders, &$target,
	                                       $id = null, $field = 'code', $table = 'custom_code'
	)
	{
		// use the new container class
		CFactory::_('Placeholder.Reverse')->engine($string, $placeholders, $target, $id, $field, $table);
	}

	/**
	 * Set the langs strings for the reveres process
	 *
	 * @param   string  $updateString  The string to update
	 * @param   string  $string        The string to use lang update
	 * @param   string  $target        The target path type
	 *
	 * @return  string
	 * @deprecated 3.3 See $this->reversePlaceholders();
	 */
	protected function setReverseLangPlaceholders($updateString, $string,
	                                              &$target
	)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return '';
	}

	/**
	 * Update the data with the placeholders
	 *
	 * @param   string  $data         The actual data
	 * @param   array   $placeholder  The placeholders
	 * @param   int     $action       The action to use
	 *
	 * THE ACTION OPTIONS ARE
	 * 1 -> Just replace (default)
	 * 2 -> Check if data string has placeholders
	 * 3 -> Remove placeholders not in data string
	 *
	 * @return  string
	 * @deprecated 3.3 Use CFactory::_('Placeholder')->update($data, $placeholder, $action);
	 */
	public function setPlaceholders($data, &$placeholder, $action = 1)
	{
		// use the new container class
		CFactory::_('Placeholder')->update($data, $placeholder, $action);
	}

	/**
	 * return the placeholders for inserted and replaced code
	 *
	 * @param   int  $type  The type of placement
	 * @param   int  $id    The code id in the system
	 *
	 * @return  array    on success
	 * @deprecated 3.3 Use CFactory::_('Placeholder')->keys($type, $id);
	 */
	public function getPlaceHolder($type, $id)
	{
		return CFactory::_('Placeholder')->keys($type, $id);
	}

	/**
	 * get the local installed path of this component
	 *
	 * @return  array   of paths on success
	 * @deprecated 3.3
	 */
	protected function getLocalInstallPaths()
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return [];
	}

}
