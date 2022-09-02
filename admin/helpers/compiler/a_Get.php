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
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Utilities\String\TypeHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Utilities\String\PluginHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;

/**
 * Get class as the main compilers class
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
	public $globalPlaceholders = array();

	/**
	 * The placeholders
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Placeholder')->active[];
	 */
	public $placeholders = array();

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
	 */
	public $accessWorseCase;

	/**
	 * Switch to add assets table name fix
	 *
	 * @var     bool
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
	public $powers = array();

	/**
	 * The state of all Powers
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	public $statePowers = array();

	/**
	 * The linked Powers
	 *
	 * @var      array
	 */
	public $linkedPowers = array();

	/**
	 * The Plugins data
	 *
	 * @var      array
	 */
	public $joomlaPlugins = array();

	/**
	 * The Modules data
	 *
	 * @var      array
	 */
	public $joomlaModules = array();

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
	 *
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
	protected $customCodeData = array();

	/**
	 * The function name memory ids
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Customcode')->functionNameMemory
	 */
	public $functionNameMemory = array();

	/**
	 * The custom code for local memory
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Customcode')->memory
	 */
	public $customCodeMemory = array();

	/**
	 * The custom code in local files that already exist in system
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $existingCustomCode = array();

	/**
	 * The custom code in local files this are new
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $newCustomCode = array();

	/**
	 * The index of code already loaded
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $codeAreadyDone = array();

	/**
	 * The external code/string to be added
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $externalCodeString = array();

	/**
	 * The external code/string cutter
	 *
	 * @var      array
	 * @deprecated 3.3
	 */
	protected $externalCodeCutter = array();

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
	 * @var      boolean
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
	public $langContent = array();

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
	public $multiLangString = array();

	/**
	 * The new lang to add
	 *
	 * @var      array
	 */
	protected $newLangStrings = array();

	/**
	 * The existing lang to update
	 *
	 * @var      array
	 */
	protected $existingLangStrings = array();

	/**
	 * The Language JS matching check
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Language.Extractor')->langMismatch;
	 */
	public $langMismatch = array();

	/**
	 * The Language SC matching check
	 *
	 * @var      array
	 * @deprecated 3.3 Use CFactory::_('Language.Extractor')->langMatch;
	 */
	public $langMatch = array();

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
	 */
	public $component_version;

	/**
	 * The UIKIT Switch
	 *
	 * @var    boolean
	 */
	public $uikit = 0;

	/**
	 * The UIKIT component checker
	 *
	 * @var     array
	 */
	public $uikitComp = array();

	/**
	 * The FOOTABLE Switch
	 *
	 * @var      boolean
	 */
	public $footable = false;

	/**
	 * The FOOTABLE Version
	 *
	 * @var      int
	 */
	public $footableVersion;

	/**
	 * The Google Chart Switch per view
	 *
	 * @var     array
	 */
	public $googleChart = array();

	/**
	 * The Google Chart Switch
	 *
	 * @var     boolean
	 */
	public $googlechart = false;

	/**
	 * The Import & Export Switch
	 *
	 * @var      boolean
	 */
	public $addEximport = false;

	/**
	 * The Import & Export View
	 *
	 * @var      array
	 */
	public $eximportView = array();

	/**
	 * The Import & Export Custom Script
	 *
	 * @var      array
	 */
	public $importCustomScripts = array();

	/**
	 * The Tag & History Switch
	 *
	 * @var      boolean
	 */
	public $setTagHistory = false;

	/**
	 * The Joomla Fields Switch
	 *
	 * @var      boolean
	 */
	public $setJoomlaFields = false;

	/**
	 * The site edit views
	 *
	 * @var     array
	 */
	public $siteEditView = array();

	/**
	 * The admin list view filter type
	 *
	 * @var     array
	 */
	public $adminFilterType = array();

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
	public $langKeys = array();

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
	 */
	public $uniquecodes = array();

	/**
	 * The unique keys
	 *
	 * @var     array
	 */
	public $uniquekeys = array();

	/**
	 * The Ad contributors Switch
	 *
	 * @var     boolean
	 */
	public $addContributors = false;

	/**
	 * The Custom Script Builder
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Customcode.Dispenser')->hub;
	 */
	public $customScriptBuilder = array();

	/**
	 * The Footable Script Builder
	 *
	 * @var     array
	 */
	public $footableScripts = array();

	/**
	 * The pathe to the bom file to be used
	 *
	 * @var     string
	 */
	public $bomPath;

	/**
	 * The SQL Tweak of admin views
	 *
	 * @var     array
	 */
	public $sqlTweak = array();

	/**
	 * The validation rules that should be added
	 *
	 * @var     array
	 */
	public $validationRules = array();

	/**
	 * The validation linked to fields
	 *
	 * @var     array
	 */
	public $validationLinkedFields = array();

	/**
	 * The admin views data array
	 *
	 * @var     array
	 */
	private $_adminViewData = array();

	/**
	 * The field data array
	 *
	 * @var     array
	 */
	private $_fieldData = array();

	/**
	 * The custom alias builder
	 *
	 * @var     array
	 */
	public $customAliasBuilder = array();

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
	 */
	public $uniqueNames = array();

	/**
	 * Set unique Names
	 *
	 * @var    array
	 */
	protected $uniqueFieldNames = array();

	/**
	 * Category other name bucket
	 *
	 * @var    array
	 */
	public $catOtherName = array();

	/**
	 * The field relations values
	 *
	 * @var     array
	 */
	public $fieldRelations = array();

	/**
	 * The views default ordering
	 *
	 * @var     array
	 */
	public $viewsDefaultOrdering = array();

	/**
	 * Default Fields
	 *
	 * @var    array
	 */
	public $defaultFields
		= array('created', 'created_by', 'modified', 'modified_by', 'published',
			'ordering', 'access', 'version', 'hits', 'id');

	/**
	 * The list join fields
	 *
	 * @var     array
	 */
	public $listJoinBuilder = array();

	/**
	 * The list head over ride
	 *
	 * @var     array
	 */
	public $listHeadOverRide = array();

	/**
	 * The linked admin view tabs
	 *
	 * @var     array
	 */
	public $linkedAdminViews = array();

	/**
	 * The custom admin view tabs
	 *
	 * @var     array
	 */
	public $customTabs = array();

	/**
	 * The Add Ajax Switch
	 *
	 * @var    boolean
	 */
	public $addAjax = false;

	/**
	 * The Add Site Ajax Switch
	 *
	 * @var     boolean
	 */
	public $addSiteAjax = false;

	/**
	 * The get Module Script Switch
	 *
	 * @var    array
	 */
	public $getModule = array();

	/**
	 * The template data
	 *
	 * @var    array
	 */
	public $templateData = array();

	/**
	 * The layout data
	 *
	 * @var    array
	 */
	public $layoutData = array();

	/**
	 * The Encryption Types
	 *
	 * @var    array
	 */
	public $cryptionTypes = array('basic', 'medium', 'whmcs', 'expert');

	/**
	 * The WHMCS Encryption Switch
	 *
	 * @var    boolean
	 */
	public $whmcsEncryption = false;

	/**
	 * The Basic Encryption Switch
	 *
	 * @var    boolean
	 */
	public $basicEncryption = false;

	/**
	 * The Medium Encryption Switch
	 *
	 * @var    boolean
	 */
	public $mediumEncryption = false;

	/**
	 * The Custom field Switch per view
	 *
	 * @var    array
	 */
	public $customFieldScript = array();

	/**
	 * The site main get
	 *
	 * @var    array
	 */
	public $siteMainGet = array();

	/**
	 * The site dynamic get
	 *
	 * @var    array
	 */
	public $siteDynamicGet = array();

	/**
	 * The get AS lookup
	 *
	 * @var    array
	 */
	public $getAsLookup = array();

	/**
	 * The site fields
	 *
	 * @var    array
	 */
	public $siteFields = array();

	/**
	 * The add SQL
	 *
	 * @var    array
	 */
	public $addSQL = array();

	/**
	 * The update SQL
	 *
	 * @var    array
	 */
	public $updateSQL = array();

	/**
	 * The data by alias keys
	 *
	 * @var    array
	 */
	protected $dataWithAliasKeys = array();

	/**
	 * The Library Manager
	 *
	 * @var    array
	 */
	public $libManager = array();

	/**
	 * The Libraries
	 *
	 * @var    array
	 */
	public $libraries = array();

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
	 */
	public $setTidyWarning = false;

	/**
	 * mysql table setting keys
	 *
	 * @var    array
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
	 */
	public $mysqlTableSetting = array();

	/**
	 * Constructor
	 */
	public function __construct()
	{
		// we do not yet have this set as an option
		$config['remove_line_breaks']
			= 2; // 2 is global (use the components value)
		// load application
		$this->app = JFactory::getApplication();
		// Set the params
		$this->params = JComponentHelper::getParams('com_componentbuilder');
		// Trigger Event: jcb_ce_onBeforeGet
		CFactory::_J('Event')->trigger('jcb_ce_onBeforeGet', array(&$config, &$this));
		// set the Joomla version @deprecated
		$this->joomlaVersion = CFactory::_('Config')->joomla_version;
		// set the minfy switch of the JavaScript @deprecated
		$this->minify = CFactory::_('Config')->get('minify', 0);
		// set the global language @deprecated @deprecated
		$this->langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
		// also set the helper class langTag (for safeStrings)
		ComponentbuilderHelper::$langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
		// setup the main language array
		$this->languages['components'][CFactory::_('Config')->get('lang_tag', 'en-GB')] = array();
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
				JText::_('<hr /><h3>Field Notice</h3>'), 'Notice'
			);
			$this->app->enqueueMessage(
				JText::_(
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
		// add assets table fix @deprecated
		$this->addAssetsTableFix = CFactory::_('Config')->add_assets_table_fix;
		// set if language strings line breaks should be removed @deprecated
		$this->removeLineBreaks = CFactory::_('Config')->remove_line_breaks;
		// set if placeholders should be added to customcode @deprecated
		$this->addPlaceholders = CFactory::_('Config')->get('add_placeholders', false);
		// set if line numbers should be added to comments @deprecated
		$this->debugLinenr = CFactory::_('Config')->get('debug_line_nr', false);
		// set if powers should be added to component (default is true) @deprecated
		$this->addPower = CFactory::_('Config')->get('add_power', true);
		// set the current user
		$this->user = JFactory::getUser();
		// Get a db connection.
		$this->db = JFactory::getDbo();
		// get global placeholders @deprecated
		$this->globalPlaceholders = CFactory::_('Component.Placeholder')->get();

		// get the custom code from installed files
		CFactory::_('Customcode.Extractor')->run();

		// Trigger Event: jcb_ce_onBeforeGetComponentData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeGetComponentData',
			array(&$this->componentContext, &$this)
		);
		// get the component data
		$this->componentData = $this->getComponentData();
		// Trigger Event: jcb_ce_onAfterGetComponentData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onAfterGetComponentData',
			array(&$this->componentContext, &$this)
		);
		// make sure we have a version
		if (strpos($this->componentData->component_version, '.')
			=== false)
		{
			$this->componentData->component_version = '1.0.0';
		}
		// update the version
		if (!isset($this->componentData->old_component_version)
			&& (ArrayHelper::check($this->addSQL)
				|| ArrayHelper::check(
					$this->updateSQL
				)))
		{
			// set the new version
			$version = (array) explode(
				'.', $this->componentData->component_version
			);
			// get last key
			end($version);
			$key = key($version);
			// just increment the last
			$version[$key]++;
			// set the old version
			$this->componentData->old_component_version
				= $this->componentData->component_version;
			// set the new version, and set update switch
			$this->componentData->component_version = implode(
				'.', $version
			);
		}
		// get powers *+*+*+*+*+*+*+*PRO
		CFactory::_('Power')->load($this->linkedPowers);
		// set the percentage when a language can be added
		$this->percentageLanguageAdd = (int) $this->params->get(
			'percentagelanguageadd', 50
		);

		// Trigger Event: jcb_ce_onBeforeGet
		CFactory::_J('Event')->trigger(
			'jcb_ce_onAfterGet', array(&$this->componentContext, &$this)
		);

		return true;
	}

	/**
	 * Set the tab/space
	 *
	 * @param   int  $nr  The number of tag/space
	 *
	 * @return  string
	 *
	 */
	public function _t($nr)
	{
		// use global method for conformity
		return ComponentbuilderHelper::_t($nr);
	}

	/**
	 * Trigger events
	 *
	 * @param   string  $event  The event to trigger
	 * @param   mix     $data   The values to pass to the event/plugin
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_J('Event')->trigger($event, $data);
	 */
	public function triggerEvent($event, $data)
	{
		return CFactory::_J('Event')->trigger($event, $data);
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
	 * @param   int  $id  The component ID
	 *
	 * @return  oject The component data
	 *
	 */
	public function getComponentData()
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);
		// selection
		$selection = array(
			'b.addadmin_views'        => 'addadmin_views',
			'b.id'                    => 'addadmin_views_id',
			'h.addconfig'             => 'addconfig',
			'd.addcustom_admin_views' => 'addcustom_admin_views',
			'g.addcustommenus'        => 'addcustommenus',
			'j.addfiles'              => 'addfiles',
			'j.addfolders'            => 'addfolders',
			'j.addfilesfullpath'      => 'addfilesfullpath',
			'j.addfoldersfullpath'    => 'addfoldersfullpath',
			'c.addsite_views'         => 'addsite_views',
			'l.addjoomla_plugins'     => 'addjoomla_plugins',
			'k.addjoomla_modules'     => 'addjoomla_modules',
			'i.dashboard_tab'         => 'dashboard_tab',
			'i.php_dashboard_methods' => 'php_dashboard_methods',
			'i.params'                => 'dashboard_params',
			'i.id'                    => 'component_dashboard_id',
			'f.sql_tweak'             => 'sql_tweak',
			'e.version_update'        => 'version_update',
			'e.id'                    => 'version_update_id'
		);
		$query->select('a.*');
		$query->select(
			$this->db->quoteName(
				array_keys($selection), array_values($selection)
			)
		);
		// from this table
		$query->from('#__componentbuilder_joomla_component AS a');
		// jointer-map
		$joiners = array(
			'b' => 'component_admin_views',
			'c' => 'component_site_views',
			'd' => 'component_custom_admin_views',
			'e' => 'component_updates',
			'f' => 'component_mysql_tweaks',
			'g' => 'component_custom_admin_menus',
			'h' => 'component_config',
			'i' => 'component_dashboard',
			'j' => 'component_files_folders',
			'l' => 'component_plugins',
			'k' => 'component_modules'
		);
		// load the joins
		foreach ($joiners as $as => $join)
		{
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_' . $join, $as)
				. ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName($as . '.joomla_component') . ')'
			);
		}
		$query->where(
			$this->db->quoteName('a.id') . ' = ' . (int) CFactory::_('Config')->component_id
		);

		// Trigger Event: jcb_ce_onBeforeQueryComponentData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeQueryComponentData',
			array(&$this->componentContext, &$this->componentID, &$query,
				&$this->db)
		);

		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);

		// Load the results as a list of stdClass objects
		$component = $this->db->loadObject();

		// Trigger Event: jcb_ce_onBeforeModelComponentData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeModelComponentData',
			array(&$this->componentContext, &$component)
		);

		// set updater
		$updater = array(
			'unique' => array(
				'addadmin_views'        => array('table' => 'component_admin_views',
				                                 'val'   => (int) $component->addadmin_views_id,
				                                 'key'   => 'id'),
				'addconfig'             => array('table' => 'component_config',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'addcustom_admin_views' => array('table' => 'component_custom_admin_views',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'addcustommenus'        => array('table' => 'component_custom_admin_menus',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'addfiles'              => array('table' => 'component_files_folders',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'addfolders'            => array('table' => 'component_files_folders',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'addsite_views'         => array('table' => 'component_site_views',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'dashboard_tab'         => array('table' => 'component_dashboard',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'sql_tweak'             => array('table' => 'component_mysql_tweaks',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component'),
				'version_update'        => array('table' => 'component_updates',
				                                 'val'   => (int) CFactory::_('Config')->component_id,
				                                 'key'   => 'joomla_component')
			),
			'table'  => 'joomla_component',
			'key'    => 'id',
			'val'    => (int) CFactory::_('Config')->component_id
		);
		// repeatable fields to update
		$searchRepeatables = array(
			// repeatablefield => checker
			'addadmin_views'        => 'adminview',
			'addconfig'             => 'field',
			'addcontributors'       => 'name',
			'addcustom_admin_views' => 'customadminview',
			'addcustommenus'        => 'name',
			'addfiles'              => 'file',
			'addfolders'            => 'folder',
			'addsite_views'         => 'siteview',
			'dashboard_tab'         => 'name',
			'sql_tweak'             => 'adminview',
			'version_update'        => 'version'
		);
		// update the repeatable fields
		$component = ComponentbuilderHelper::convertRepeatableFields(
			$component, $searchRepeatables, $updater
		);

		// load the global placeholders
		if (ArrayHelper::check($this->globalPlaceholders))
		{
			CFactory::_('Placeholder')->active = $this->globalPlaceholders;
		}

		// set component sales name
		$component->sales_name = StringHelper::safe(
			$component->system_name
		);

		// set the component name_code
		$component->name_code = StringHelper::safe(
			$component->name_code
		);

		// ensure version naming is correct
		$this->component_version = preg_replace(
			'/[^0-9.]+/', '', $component->component_version
		);

		// set the add targets
		$addArrayF = array('files'           => 'files',
		                   'folders'         => 'folders',
		                   'filesfullpath'   => 'files',
		                   'foldersfullpath' => 'folders');
		foreach ($addArrayF as $addTarget => $targetHere)
		{
			// set the add target data
			$component->{'add' . $addTarget} = (isset(
					$component->{'add' . $addTarget}
				)
				&& JsonHelper::check(
					$component->{'add' . $addTarget}
				)) ? json_decode($component->{'add' . $addTarget}, true) : null;
			if (ArrayHelper::check(
				$component->{'add' . $addTarget}
			))
			{
				if (isset($component->{$targetHere})
					&& ArrayHelper::check(
						$component->{$targetHere}
					))
				{
					foreach ($component->{'add' . $addTarget} as $taget)
					{
						$component->{$targetHere}[] = $taget;
					}
				}
				else
				{
					$component->{$targetHere} = array_values(
						$component->{'add' . $addTarget}
					);
				}
			}
			unset($component->{'add' . $addTarget});
		}

		// set the uikit switch
		$this->uikit = $component->adduikit;

		// set whmcs links if needed
		if (1 == $component->add_license
			&& (!isset($component->whmcs_buy_link)
				|| !StringHelper::check(
					$component->whmcs_buy_link
				)))
		{
			// update with the whmcs url
			if (isset($component->whmcs_url)
				&& StringHelper::check($component->whmcs_url))
			{
				$component->whmcs_buy_link = $component->whmcs_url;
			}
			// use the company website
			elseif (isset($component->website)
				&& StringHelper::check($component->website))
			{
				$component->whmcs_buy_link = $component->website;
				$component->whmcs_url      = rtrim($component->website, '/')
					. '/whmcs';
			}
			// none set
			else
			{
				$component->whmcs_buy_link = '#';
				$component->whmcs_url      = '#';
			}
		}
		// since the license details are not set clear
		elseif (0 == $component->add_license)
		{
			$component->whmcs_key      = '';
			$component->whmcs_buy_link = '';
			$component->whmcs_url      = '';
		}

		// set the footable switch
		if ($component->addfootable)
		{
			$this->footable = true;
			// add the version
			$this->footableVersion = (1 == $component->addfootable
				|| 2 == $component->addfootable) ? 2 : $component->addfootable;
		}

		// set the addcustommenus data
		$component->addcustommenus = (isset($component->addcustommenus)
			&& JsonHelper::check($component->addcustommenus))
			? json_decode($component->addcustommenus, true) : null;
		if (ArrayHelper::check($component->addcustommenus))
		{
			$component->custommenus = array_values($component->addcustommenus);
		}
		unset($component->addcustommenus);

		// set the sql_tweak data
		$component->sql_tweak = (isset($component->sql_tweak)
			&& JsonHelper::check($component->sql_tweak))
			? json_decode($component->sql_tweak, true) : null;
		if (ArrayHelper::check($component->sql_tweak))
		{
			// build the tweak settings
			$this->setSqlTweaking(
				array_map(
					function ($array) {
						return array_map(
							function ($value) {
								if (!ArrayHelper::check($value)
									&& !ObjectHelper::check(
										$value
									)
									&& strval($value) === strval(
										intval($value)
									))
								{
									return (int) $value;
								}

								return $value;
							}, $array
						);
					}, array_values($component->sql_tweak)
				)
			);
		}
		unset($component->sql_tweak);

		// set the admin_view data
		$component->addadmin_views = (isset($component->addadmin_views)
			&& JsonHelper::check($component->addadmin_views))
			? json_decode($component->addadmin_views, true) : null;
		if (ArrayHelper::check($component->addadmin_views))
		{
			CFactory::_('Config')->lang_target = 'admin';
			CFactory::_('Config')->build_target = 'admin';
			// sort the views according to order
			usort(
				$component->addadmin_views, function ($a, $b) {
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
			}
			);
			// build the admin_views settings
			$component->admin_views = array_map(
				function ($array) {
					$array = array_map(
						function ($value) {
							if (!ArrayHelper::check($value)
								&& !ObjectHelper::check($value)
								&& strval($value) === strval(intval($value)))
							{
								return (int) $value;
							}

							return $value;
						}, $array
					);
					// check if we must add to site
					if (isset($array['edit_create_site_view'])
						&& is_numeric(
							$array['edit_create_site_view']
						)
						&& $array['edit_create_site_view'] > 0)
					{
						$this->siteEditView[$array['adminview']] = true;
						CFactory::_('Config')->lang_target = 'both';
					}
					// set the import/export option for this view
					if (isset($array['port']) && $array['port']
						&& !$this->addEximport)
					{
						$this->addEximport = true;
					}
					// set the history tracking option for this view
					if (isset($array['history']) && $array['history']
						&& !$this->setTagHistory)
					{
						$this->setTagHistory = true;
					}
					// set the custom field integration for this view
					if (isset($array['joomla_fields'])
						&& $array['joomla_fields']
						&& !$this->setJoomlaFields)
					{
						$this->setJoomlaFields = true;
					}
					// has become a legacy issue, can't remove this
					$array['view'] = $array['adminview'];
					// get the admin settings/data
					$array['settings'] = $this->getAdminViewData(
						$array['view']
					);
					// set the filter option for this view
					$this->adminFilterType[$array['settings']->name_list_code]
						= 1; // Side (old) [default for now]
					if (isset($array['filter'])
						&& is_numeric(
							$array['filter']
						)
						&& $array['filter'] > 0)
					{
						$this->adminFilterType[$array['settings']->name_list_code]
							= (int) $array['filter'];
					}

					return $array;
				}, array_values($component->addadmin_views)
			);
		}
		// set the site_view data
		$component->addsite_views = (isset($component->addsite_views)
			&& JsonHelper::check($component->addsite_views))
			? json_decode($component->addsite_views, true) : null;
		if (ArrayHelper::check($component->addsite_views))
		{
			CFactory::_('Config')->lang_target = 'site';
			CFactory::_('Config')->build_target = 'site';
			// build the site_views settings
			$component->site_views = array_map(
				function ($array) {
					// has become a lacacy issue, can't remove this
					$array['view']     = $array['siteview'];
					$array['settings'] = $this->getCustomViewData(
						$array['view']
					);

					return array_map(
						function ($value) {
							if (!ArrayHelper::check($value)
								&& !ObjectHelper::check($value)
								&& strval($value) === strval(intval($value)))
							{
								return (int) $value;
							}

							return $value;
						}, $array
					);
				}, array_values($component->addsite_views)
			);
			// unset original value
			unset($component->addsite_views);
		}

		// set the custom_admin_views data
		$component->addcustom_admin_views
			= (isset($component->addcustom_admin_views)
			&& JsonHelper::check(
				$component->addcustom_admin_views
			)) ? json_decode($component->addcustom_admin_views, true) : null;
		if (ArrayHelper::check(
			$component->addcustom_admin_views
		))
		{
			CFactory::_('Config')->lang_target = 'admin';
			CFactory::_('Config')->build_target = 'custom_admin';
			// build the custom_admin_views settings
			$component->custom_admin_views = array_map(
				function ($array) {
					// has become a lacacy issue, can't remove this
					$array['view']     = $array['customadminview'];
					$array['settings'] = $this->getCustomViewData(
						$array['view'], 'custom_admin_view'
					);

					return array_map(
						function ($value) {
							if (!ArrayHelper::check($value)
								&& !ObjectHelper::check($value)
								&& strval($value) === strval(intval($value)))
							{
								return (int) $value;
							}

							return $value;
						}, $array
					);
				}, array_values($component->addcustom_admin_views)
			);
			// unset original value
			unset($component->addcustom_admin_views);
		}

		// set the config data
		$component->addconfig = (isset($component->addconfig)
			&& JsonHelper::check($component->addconfig))
			? json_decode($component->addconfig, true) : null;
		if (ArrayHelper::check($component->addconfig))
		{
			$component->config = array_map(
				function ($field) {
					// make sure the alias and title is 0
					$field['alias'] = 0;
					$field['title'] = 0;
					// set the field details
					$this->setFieldDetails($field);
					// set unique name counter
					$this->setUniqueNameCounter($field['base_name'], 'configs');

					// return field
					return $field;
				}, array_values($component->addconfig)
			);

			// do some house cleaning (for fields)
			foreach ($component->config as $field)
			{
				// so first we lock the field name in
				$this->getFieldName($field, 'configs');
			}
			// unset original value
			unset($component->addconfig);
		}

		// set the addcustommenus data
		$component->addcontributors = (isset($component->addcontributors)
			&& JsonHelper::check($component->addcontributors))
			? json_decode($component->addcontributors, true) : null;
		if (ArrayHelper::check($component->addcontributors))
		{
			$this->addContributors   = true;
			$component->contributors = array_values(
				$component->addcontributors
			);
		}
		unset($component->addcontributors);

		// set the addcustommenus data
		$component->version_update = (isset($component->version_update)
			&& JsonHelper::check($component->version_update))
			? json_decode($component->version_update, true) : null;
		if (ArrayHelper::check($component->version_update))
		{
			$component->version_update = array_values(
				$component->version_update
			);
		}

		// build update SQL
		$old_admin_views = $this->getHistoryWatch(
			'component_admin_views', $component->addadmin_views_id
		);
		$old_component   = $this->getHistoryWatch(
			'joomla_component', CFactory::_('Config')->component_id
		);
		if ($old_component || $old_admin_views)
		{
			if (ObjectHelper::check($old_admin_views))
			{
				// add new views if found
				if (isset($old_admin_views->addadmin_views)
					&& JsonHelper::check(
						$old_admin_views->addadmin_views
					))
				{
					$this->setUpdateSQL(
						json_decode($old_admin_views->addadmin_views, true),
						$component->addadmin_views, 'adminview'
					);
				}
				// check if a new version was manualy set
				if (ObjectHelper::check($old_component))
				{
					$old_component_version = preg_replace(
						'/[^0-9.]+/', '', $old_component->component_version
					);
					if ($old_component_version != $this->component_version)
					{
						// yes, this is a new version, this mean there may be manual sql and must be checked and updated
						$component->old_component_version
							= $old_component_version;
					}
					// clear this data
					unset($old_component);
				}
				// clear this data
				unset($old_admin_views);
			}
		}
		// unset original value
		unset($component->addadmin_views);

		// set GUI mapper
		$guiMapper = array('table' => 'joomla_component',
		                   'id'    => (int) CFactory::_('Config')->component_id,
		                   'field' => 'javascript', 'type' => 'js');

		// add_javascript
		if ($component->add_javascript == 1)
		{
			CFactory::_('Customcode.Dispenser')->set(
				$component->javascript,
				'component_js',
				null,
				null,
				$guiMapper
			);
		}
		else
		{
			CFactory::_('Customcode.Dispenser')->hub['component_js'] = '';
		}
		unset($component->javascript);

		// add global CSS
		$addGlobalCss = array('admin', 'site');
		foreach ($addGlobalCss as $area)
		{
			// add_css if found
			if (isset($component->{'add_css_' . $area})
				&& $component->{'add_css_' . $area} == 1
				&& isset($component->{'css_' . $area})
				&& StringHelper::check(
					$component->{'css_' . $area}
				))
			{
				CFactory::_('Customcode.Dispenser')->set(
					$component->{'css_' . $area},
					'component_css_' . $area
				);
			}
			else
			{
				CFactory::_('Customcode.Dispenser')->hub['component_css_' . $area] = '';
			}
			unset($component->{'css_' . $area});
		}
		// set the lang target
		CFactory::_('Config')->lang_target = 'admin';
		// add PHP in ADMIN
		$addScriptMethods = array('php_preflight', 'php_postflight',
			'php_method');
		$addScriptTypes   = array('install', 'update', 'uninstall');
		// update GUI mapper
		$guiMapper['type'] = 'php';
		foreach ($addScriptMethods as $scriptMethod)
		{
			foreach ($addScriptTypes as $scriptType)
			{
				if (isset(
						$component->{'add_' . $scriptMethod . '_' . $scriptType}
					)
					&& $component->{'add_' . $scriptMethod . '_' . $scriptType}
					== 1
					&& StringHelper::check(
						$component->{$scriptMethod . '_' . $scriptType}
					))
				{
					// set GUI mapper field
					$guiMapper['field'] = $scriptMethod . '_' . $scriptType;
					CFactory::_('Customcode.Dispenser')->set(
						$component->{$scriptMethod . '_' . $scriptType},
						$scriptMethod,
						$scriptType,
						null,
						$guiMapper
					);
				}
				else
				{
					CFactory::_('Customcode.Dispenser')->hub[$scriptMethod][$scriptType] = '';
				}
				unset($component->{$scriptMethod . '_' . $scriptType});
			}
		}
		// add_php_helper
		if ($component->add_php_helper_admin == 1
			&& StringHelper::check(
				$component->php_helper_admin
			))
		{
			CFactory::_('Config')->lang_target = 'admin';
			// update GUI mapper
			$guiMapper['field']  = 'php_helper_admin';
			$guiMapper['prefix'] = PHP_EOL . PHP_EOL;
			CFactory::_('Customcode.Dispenser')->set(
				$component->php_helper_admin,
				'component_php_helper_admin',
				null,
				null,
				$guiMapper
			);
			unset($guiMapper['prefix']);
		}
		else
		{
			CFactory::_('Customcode.Dispenser')->hub['component_php_helper_admin'] = '';
		}
		unset($component->php_helper);
		// add_admin_event
		if ($component->add_admin_event == 1
			&& StringHelper::check($component->php_admin_event))
		{
			CFactory::_('Config')->lang_target = 'admin';
			// update GUI mapper field
			$guiMapper['field'] = 'php_admin_event';
			CFactory::_('Customcode.Dispenser')->set(
				$component->php_admin_event,
				'component_php_admin_event',
				null,
				null,
				$guiMapper
			);
		}
		else
		{
			CFactory::_('Customcode.Dispenser')->hub['component_php_admin_event'] = '';
		}
		unset($component->php_admin_event);
		// add_php_helper_both
		if ($component->add_php_helper_both == 1
			&& StringHelper::check($component->php_helper_both))
		{
			CFactory::_('Config')->lang_target = 'both';
			// update GUI mapper field
			$guiMapper['field']  = 'php_helper_both';
			$guiMapper['prefix'] = PHP_EOL . PHP_EOL;
			CFactory::_('Customcode.Dispenser')->set(
				$component->php_helper_both,
				'component_php_helper_both',
				null,
				null,
				$guiMapper
			);
			unset($guiMapper['prefix']);
		}
		else
		{
			CFactory::_('Customcode.Dispenser')->hub['component_php_helper_both'] = '';
		}
		// add_php_helper_site
		if ($component->add_php_helper_site == 1
			&& StringHelper::check($component->php_helper_site))
		{
			CFactory::_('Config')->lang_target = 'site';
			// update GUI mapper field
			$guiMapper['field']  = 'php_helper_site';
			$guiMapper['prefix'] = PHP_EOL . PHP_EOL;
			CFactory::_('Customcode.Dispenser')->set(
				$component->php_helper_site,
				'component_php_helper_site',
				null,
				null,
				$guiMapper
			);
			unset($guiMapper['prefix']);
		}
		else
		{
			CFactory::_('Customcode.Dispenser')->hub['component_php_helper_site'] = '';
		}
		unset($component->php_helper);
		// add_site_event
		if ($component->add_site_event == 1
			&& StringHelper::check($component->php_site_event))
		{
			CFactory::_('Config')->lang_target = 'site';
			// update GUI mapper field
			$guiMapper['field'] = 'php_site_event';
			CFactory::_('Customcode.Dispenser')->set(
				$component->php_site_event,
				'component_php_site_event',
				null,
				null,
				$guiMapper
			);
		}
		else
		{
			CFactory::_('Customcode.Dispenser')->hub['component_php_site_event'] = '';
		}
		unset($component->php_site_event);
		// add_sql
		if ($component->add_sql == 1)
		{
			CFactory::_('Customcode.Dispenser')->set(
				$component->sql,
				'sql',
				'component_sql'
			);
		}
		unset($component->sql);
		// add_sql_uninstall
		if ($component->add_sql_uninstall == 1)
		{
			CFactory::_('Customcode.Dispenser')->set(
				$component->sql_uninstall,
				'sql_uninstall'
			);
		}
		unset($component->sql_uninstall);
		// bom
		if (StringHelper::check($component->bom))
		{
			$this->bomPath = CFactory::_('Config')->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler') . '/' . $component->bom;
		}
		else
		{
			$this->bomPath = CFactory::_('Config')->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler') . '/default.txt';
		}
		unset($component->bom);
		// README
		if ($component->addreadme)
		{
			$component->readme = CFactory::_('Customcode')->add(
				base64_decode($component->readme)
			);
		}
		else
		{
			$component->readme = '';
		}

		// set lang now
		$nowLang    = CFactory::_('Config')->lang_target;
		CFactory::_('Config')->lang_target = 'admin';
		// dashboard methods
		$component->dashboard_tab = (isset($component->dashboard_tab)
			&& JsonHelper::check($component->dashboard_tab))
			? json_decode($component->dashboard_tab, true) : null;
		if (ArrayHelper::check($component->dashboard_tab))
		{
			$component->dashboard_tab = array_map(
				function ($array) {
					$array['html'] = CFactory::_('Customcode')->add($array['html']);

					return $array;
				}, array_values($component->dashboard_tab)
			);
		}
		else
		{
			$component->dashboard_tab = '';
		}
		// add the php of the dashboard if set
		if (isset($component->php_dashboard_methods)
			&& StringHelper::check(
				$component->php_dashboard_methods
			))
		{
			// load the php for the dashboard model
			$component->php_dashboard_methods = CFactory::_('Customcode.Gui')->set(
				CFactory::_('Customcode')->add(
					base64_decode($component->php_dashboard_methods)
				),
				array(
					'table' => 'component_dashboard',
					'field' => 'php_dashboard_methods',
					'id'    => (int) $component->component_dashboard_id,
					'type'  => 'php')
			);
		}
		else
		{
			$component->php_dashboard_methods = '';
		}
		// reset back to nowlang
		CFactory::_('Config')->lang_target = $nowLang;

		// add the update/sales server FTP details if that is the expected protocol
		$serverArray = array('update_server', 'sales_server');
		foreach ($serverArray as $server)
		{
			if ($component->{'add_' . $server} == 1
				&& is_numeric(
					$component->{$server}
				)
				&& $component->{$server} > 0)
			{
				// get the server protocol
				$component->{$server . '_protocol'}
					= GetHelper::var(
					'server', (int) $component->{$server}, 'id', 'protocol'
				);
			}
			else
			{
				$component->{$server} = 0;
				// only change this for sales server (update server can be added loacaly to the zip file)
				if ('sales_server' === $server)
				{
					$component->{'add_' . $server} = 0;
				}
				$component->{$server . '_protocol'} = 0;
			}
		}
		// set the ignore folders for repo if found
		if (isset($component->toignore)
			&& StringHelper::check(
				$component->toignore
			))
		{
			if (strpos($component->toignore, ',') !== false)
			{
				$component->toignore = array_map(
					'trim', (array) explode(',', $component->toignore)
				);
			}
			else
			{
				$component->toignore = array(trim($component->toignore));
			}
		}
		else
		{
			// the default is to ignore the repo folder
			$component->toignore = array('.git');
		}
		// get all modules
		$component->addjoomla_modules = (isset($component->addjoomla_modules)
			&& JsonHelper::check($component->addjoomla_modules))
			? json_decode($component->addjoomla_modules, true) : null;
		if (ArrayHelper::check($component->addjoomla_modules))
		{
			$joomla_modules = array_map(
				function ($array) use (&$component) {
					// only load the modules whose target association calls for it
					if (!isset($array['target']) || $array['target'] != 2)
					{
						return $this->setJoomlaModule(
							$array['module'], $component
						);
					}

					return null;
				}, array_values($component->addjoomla_modules)
			);
		}
		unset($component->addjoomla_modules);
		// get all plugins
		$component->addjoomla_plugins = (isset($component->addjoomla_plugins)
			&& JsonHelper::check($component->addjoomla_plugins))
			? json_decode($component->addjoomla_plugins, true) : null;
		if (ArrayHelper::check($component->addjoomla_plugins))
		{
			$joomla_plugins = array_map(
				function ($array) use (&$component) {
					// only load the plugins whose target association calls for it
					if (!isset($array['target']) || $array['target'] != 2)
					{
						return $this->setJoomlaPlugin(
							$array['plugin'], $component
						);
					}

					return null;
				}, array_values($component->addjoomla_plugins)
			);
		}
		unset($component->addjoomla_plugins);

		// Trigger Event: jcb_ce_onAfterModelComponentData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onAfterModelComponentData',
			array(&$this->componentContext, &$component)
		);

		// return the found component data
		return $component;
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
	 *
	 */
	public function setLangContent($target, $language, $string,
	                               $addPrefix = false
	)
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
	 *
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
	 *
	 */
	public function getAdminViewData($id)
	{
		if (!isset($this->_adminViewData[$id]))
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'b.addfields',
						'b.id',
						'c.addconditions',
						'c.id',
						'r.addrelations',
						't.tabs'
					), array(
						'addfields',
						'addfields_id',
						'addconditions',
						'addconditions_id',
						'addrelations',
						'customtabs'
					)
				)
			);
			$query->from('#__componentbuilder_admin_view AS a');
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_admin_fields', 'b')
				. ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('b.admin_view') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_fields_conditions', 'c'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('c.admin_view') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_fields_relations', 'r'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('r.admin_view') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_custom_tabs', 't'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('t.admin_view') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);

			// Trigger Event: jcb_ce_onBeforeQueryViewData
			CFactory::_J('Event')->trigger(
				'jcb_ce_onBeforeQueryViewData',
				array(&$this->componentContext, &$id, &$query, &$this->db)
			);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$view = $this->db->loadObject();

			// setup single view code names to use in storing the data
			$view->name_single_code = 'oops_hmm_' . $id;
			if (isset($view->name_single) && $view->name_single != 'null')
			{
				$view->name_single_code = StringHelper::safe(
					$view->name_single
				);
			}

			// setup list view code name to use in storing the data
			$view->name_list_code = 'oops_hmmm_' . $id;
			if (isset($view->name_list) && $view->name_list != 'null')
			{
				$view->name_list_code = StringHelper::safe(
					$view->name_list
				);
			}

			// check the length of the view name (+5 for com_ and _)
			$name_length = CFactory::_('Config')->component_code_name_length + strlen(
					$view->name_single_code
				) + 5;
			// when the name is larger then 49 we need to add the assets table name fix
			if ($name_length > 49)
			{
				$this->addAssetsTableNameFix = true;
			}

			// set updater
			$updater = array(
				'unique' => array(
					'addfields'     => array('table' => 'admin_fields',
					                         'val'   => (int) $view->addfields_id,
					                         'key'   => 'id'),
					'addconditions' => array('table' => 'admin_fields_conditions',
					                         'val'   => (int) $view->addconditions_id,
					                         'key'   => 'id')
				),
				'table'  => 'admin_view',
				'key'    => 'id',
				'val'    => (int) $id
			);
			// repeatable fields to update
			$searchRepeatables = array(
				// repeatablefield => checker
				'addfields'       => 'field',
				'addconditions'   => 'target_field',
				'ajax_input'      => 'value_name',
				'custom_button'   => 'name',
				'addlinked_views' => 'adminview',
				'addtables'       => 'table',
				'addtabs'         => 'name',
				'addpermissions'  => 'action'
			);
			// update the repeatable fields
			$view = ComponentbuilderHelper::convertRepeatableFields(
				$view, $searchRepeatables, $updater
			);

			// setup token check
			if (!isset(CFactory::_('Customcode.Dispenser')->hub['token']))
			{
				CFactory::_('Customcode.Dispenser')->hub['token'] = [];
			}
			CFactory::_('Customcode.Dispenser')->hub['token'][$view->name_single_code]
				                                                       = false;
			CFactory::_('Customcode.Dispenser')->hub['token'][$view->name_list_code] = false;
			// set some placeholders
			CFactory::_('Placeholder')->active[Placefix::_h('view')]
				= $view->name_single_code;
			CFactory::_('Placeholder')->active[Placefix::_h('views')]
				= $view->name_list_code;
			CFactory::_('Placeholder')->active[Placefix::_h('View')]
				= StringHelper::safe(
				$view->name_single, 'F'
			);
			CFactory::_('Placeholder')->active[Placefix::_h('Views')]
				= StringHelper::safe(
				$view->name_list, 'F'
			);
			CFactory::_('Placeholder')->active[Placefix::_h('VIEW')]
				= StringHelper::safe(
				$view->name_single, 'U'
			);
			CFactory::_('Placeholder')->active[Placefix::_h('VIEWS')]
				= StringHelper::safe(
				$view->name_list, 'U'
			);
			CFactory::_('Placeholder')->active[Placefix::_('view')]
				= CFactory::_('Placeholder')->active[Placefix::_h('view')];
			CFactory::_('Placeholder')->active[Placefix::_('views')]
				= CFactory::_('Placeholder')->active[Placefix::_h('views')];
			CFactory::_('Placeholder')->active[Placefix::_('View')]
				= CFactory::_('Placeholder')->active[Placefix::_h('View')];
			CFactory::_('Placeholder')->active[Placefix::_('Views')]
				= CFactory::_('Placeholder')->active[Placefix::_h('Views')];
			CFactory::_('Placeholder')->active[Placefix::_('VIEW')]
				= CFactory::_('Placeholder')->active[Placefix::_h('VIEW')];
			CFactory::_('Placeholder')->active[Placefix::_('VIEWS')]
				= CFactory::_('Placeholder')->active[Placefix::_h('VIEWS')];

			// for plugin event TODO change event api signatures
			$this->placeholders = CFactory::_('Placeholder')->active;
			// Trigger Event: jcb_ce_onBeforeModelViewData
			CFactory::_J('Event')->trigger(
				'jcb_ce_onBeforeModelViewData',
				array(&$this->componentContext, &$view, &$this->placeholders)
			);
			// for plugin event TODO change event api signatures
			CFactory::_('Placeholder')->active = $this->placeholders;

			// add the tables
			$view->addtables = (isset($view->addtables)
				&& JsonHelper::check($view->addtables))
				? json_decode($view->addtables, true) : null;
			if (ArrayHelper::check($view->addtables))
			{
				$view->tables = array_values($view->addtables);
			}
			unset($view->addtables);

			// set custom tabs
			$this->customTabs[$view->name_single_code] = null;
			$view->customtabs
			                                           = (isset($view->customtabs)
				&& JsonHelper::check($view->customtabs))
				? json_decode($view->customtabs, true) : null;
			if (ArrayHelper::check($view->customtabs))
			{
				// setup custom tabs to global data sets
				$this->customTabs[$view->name_single_code] = array_map(
					function ($tab) use (&$view) {
						// set the view name
						$tab['view'] = $view->name_single_code;
						// load the dynamic data
						$tab['html'] = CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add($tab['html']),
							CFactory::_('Placeholder')->active
						);
						// set the tab name
						$tab['name'] = (isset($tab['name'])
							&& StringHelper::check(
								$tab['name']
							)) ? $tab['name'] : 'Tab';
						// set lang
						$tab['lang'] = CFactory::_('Config')->lang_prefix . '_'
							. StringHelper::safe(
								$tab['view'], 'U'
							) . '_' . StringHelper::safe(
								$tab['name'], 'U'
							);
						CFactory::_('Language')->set(
							'both', $tab['lang'], $tab['name']
						);
						// set code name
						$tab['code'] = StringHelper::safe(
							$tab['name']
						);
						// check if the permissions for the tab should be added
						$_tab = '';
						if (isset($tab['permission'])
							&& $tab['permission'] == 1)
						{
							$_tab = Indent::_(1);
						}
						// check if the php of the tab is set, if not load it now
						if (strpos($tab['html'], 'bootstrap.addTab') === false
							&& strpos($tab['html'], 'bootstrap.endTab')
							=== false)
						{
							// add the tab
							$tmp = PHP_EOL . $_tab . Indent::_(1)
								. "<?php echo JHtml::_('bootstrap.addTab', '"
								. $tab['view'] . "Tab', '" . $tab['code']
								. "', JText::_('" . $tab['lang']
								. "', true)); ?>";
							$tmp .= PHP_EOL . $_tab . Indent::_(2)
								. '<div class="row-fluid form-horizontal-desktop">';
							$tmp .= PHP_EOL . $_tab . Indent::_(3)
								. '<div class="span12">';
							$tmp .= PHP_EOL . $_tab . Indent::_(4) . implode(
									PHP_EOL . $_tab . Indent::_(4),
									(array) explode(PHP_EOL, trim($tab['html']))
								);
							$tmp .= PHP_EOL . $_tab . Indent::_(3) . '</div>';
							$tmp .= PHP_EOL . $_tab . Indent::_(2) . '</div>';
							$tmp .= PHP_EOL . $_tab . Indent::_(1)
								. "<?php echo JHtml::_('bootstrap.endTab'); ?>";
							// update html
							$tab['html'] = $tmp;
						}
						else
						{
							$tab['html'] = PHP_EOL . $_tab . Indent::_(1)
								. implode(
									PHP_EOL . $_tab . Indent::_(1),
									(array) explode(PHP_EOL, trim($tab['html']))
								);
						}
						// add the permissions if needed
						if (isset($tab['permission'])
							&& $tab['permission'] == 1)
						{
							$tmp = PHP_EOL . Indent::_(1)
								. "<?php if (\$this->canDo->get('"
								. $tab['view'] . "." . $tab['code']
								. ".viewtab')) : ?>";
							$tmp .= $tab['html'];
							$tmp .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
							// update html
							$tab['html'] = $tmp;
							// set lang for permissions
							$tab['lang_permission']      = $tab['lang']
								. '_TAB_PERMISSION';
							$tab['lang_permission_desc'] = $tab['lang']
								. '_TAB_PERMISSION_DESC';
							$tab['lang_permission_title']
							                             = CFactory::_('Placeholder')->active[Placefix::_h('Views')] . ' View '
								. $tab['name'] . ' Tab';
							CFactory::_('Language')->set(
								'both', $tab['lang_permission'],
								$tab['lang_permission_title']
							);
							CFactory::_('Language')->set(
								'both', $tab['lang_permission_desc'],
								'Allow the users in this group to view '
								. $tab['name'] . ' Tab of '
								. CFactory::_('Placeholder')->active[Placefix::_h('views')]
							);
							// set the sort key
							$tab['sortKey']
								= StringHelper::safe(
								$tab['lang_permission_title']
							);
						}

						// return tab
						return $tab;
					}, array_values($view->customtabs)
				);
			}
			unset($view->customtabs);

			// add the local tabs
			$view->addtabs = (isset($view->addtabs)
				&& JsonHelper::check($view->addtabs))
				? json_decode($view->addtabs, true) : null;
			if (ArrayHelper::check($view->addtabs))
			{
				$nr = 1;
				foreach ($view->addtabs as $tab)
				{
					$view->tabs[$nr] = trim($tab['name']);
					$nr++;
				}
			}
			// if Details tab is not set, then set it here
			if (!isset($view->tabs[1]))
			{
				$view->tabs[1] = 'Details';
			}
			// always make sure that publishing is lowercase
			if (($removeKey = array_search(
					'publishing', array_map('strtolower', $view->tabs)
				)) !== false)
			{
				$view->tabs[$removeKey] = 'publishing';
			}
			// make sure to set the publishing tab (just incase we need it)
			$view->tabs[15] = 'publishing';
			unset($view->addtabs);
			// add permissions
			$view->addpermissions = (isset($view->addpermissions)
				&& JsonHelper::check($view->addpermissions))
				? json_decode($view->addpermissions, true) : null;
			if (ArrayHelper::check($view->addpermissions))
			{
				$view->permissions = array_values($view->addpermissions);
			}
			unset($view->addpermissions);
			// reset fields
			$view->fields = array();
			// set fields
			$view->addfields = (isset($view->addfields)
				&& JsonHelper::check($view->addfields))
				? json_decode($view->addfields, true) : null;
			if (ArrayHelper::check($view->addfields))
			{
				$ignoreFields = array();
				// load the field data
				$view->fields = array_map(
					function ($field) use (
						&$view, &$ignoreFields
					) {
						// set the field details
						$this->setFieldDetails(
							$field, $view->name_single_code,
							$view->name_list_code
						);
						// check if this field is a default field OR
						// check if this is none database related field
						if (in_array($field['base_name'], $this->defaultFields)
							|| ComponentbuilderHelper::fieldCheck(
								$field['type_name'], 'spacer'
							)
							|| (isset($field['list'])
								&& $field['list'] == 2)) // 2 = none database
						{
							$ignoreFields[$field['field']] = $field['field'];
						}

						// return field
						return $field;
					}, array_values($view->addfields)
				);
				// build update SQL
				if ($old_view = $this->getHistoryWatch(
					'admin_fields', $view->addfields_id
				))
				{
					// add new fields were added
					if (isset($old_view->addfields)
						&& JsonHelper::check(
							$old_view->addfields
						))
					{
						$this->setUpdateSQL(
							json_decode($old_view->addfields, true),
							$view->addfields, 'field', $view->name_single_code,
							$ignoreFields
						);
					}
					// clear this data
					unset($old_view);
				}
				// sort the fields according to order
				usort(
					$view->fields, function ($a, $b) {
					if (isset($a['order_list']) && isset($b['order_list']))
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
					}

					return 0;
				}
				);
				// do some house cleaning (for fields)
				foreach ($view->fields as $field)
				{
					// so first we lock the field name in
					$field_name = $this->getFieldName(
						$field, $view->name_list_code
					);
					// check if the field changed since the last compilation (default fields never change and are always added)
					if (!isset($ignoreFields[$field['field']])
						&& ObjectHelper::check(
							$field['settings']->history
						))
					{
						// check if the datatype changed
						if (isset($field['settings']->history->datatype))
						{
							$this->setUpdateSQL(
								$field['settings']->history->datatype,
								$field['settings']->datatype, 'field.datatype',
								$view->name_single_code . '.' . $field_name
							);
						}
						// check if the datatype lenght changed
						if (isset($field['settings']->history->datalenght)
							&& isset($field['settings']->history->datalenght_other))
						{
							$this->setUpdateSQL(
								$field['settings']->history->datalenght
								. $field['settings']->history->datalenght_other,
								$field['settings']->datalenght
								. $field['settings']->datalenght_other,
								'field.lenght',
								$view->name_single_code . '.' . $field_name
							);
						}
						// check if the name changed
						if (isset($field['settings']->history->xml)
							&& JsonHelper::check(
								$field['settings']->history->xml
							))
						{
							// only run if this is not an alias or a tag
							if ((!isset($field['alias']) || !$field['alias'])
								&& 'tag' !== $field['settings']->type_name)
							{
								// build temp field bucket
								$tmpfield             = array();
								$tmpfield['settings'] = new stdClass();
								// convert the xml json string to normal string
								$tmpfield['settings']->xml
									= CFactory::_('Customcode')->add(
									json_decode(
										$field['settings']->history->xml
									)
								);
								// add properties from current field as it is generic
								$tmpfield['settings']->properties
									= $field['settings']->properties;
								// add the old name
								$tmpfield['settings']->name
									= $field['settings']->history->name;
								// add the field type from current field since it is generic
								$tmpfield['settings']->type_name
									= $field['settings']->type_name;
								// get the old name
								$old_field_name = $this->getFieldName(
									$tmpfield
								);

								// only run this if not a multi field
								if (!isset($this->uniqueNames[$view->name_list_code]['names'][$field_name]))
								{
									// this only works when the field is not multiple of the same field
									$this->setUpdateSQL(
										$old_field_name, $field_name,
										'field.name',
										$view->name_single_code . '.'
										. $field_name
									);
								}
								elseif ($old_field_name !== $field_name)
								{
									// give a notice atleast that the multi fields could have changed and no DB update was done
									$this->app->enqueueMessage(
										JText::_('<hr /><h3>Field Notice</h3>'),
										'Notice'
									);
									$this->app->enqueueMessage(
										JText::sprintf(
											'You have a field called <b>%s</b> that has been added multiple times to the <b>%s</b> view, the name of that field has changed to <b>%s</b>. Normaly we would automaticly add the update SQL to your component, but with multiple fields this does not work automaticly since it could be that noting changed and it just seems like it did. Therefore you will have to do this manualy if it actualy did change!',
											$field_name,
											$view->name_single_code,
											$old_field_name
										), 'Notice'
									);
								}
								// remove tmp
								unset($tmpfield);
							}
						}
					}
				}
			}
			unset($view->addfields);
			// build update SQL
			if ($old_view = $this->getHistoryWatch('admin_view', $id))
			{
				// check if the view name changed
				if (StringHelper::check($old_view->name_single))
				{
					$this->setUpdateSQL(
						StringHelper::safe(
							$old_view->name_single
						), $view->name_single_code, 'table_name',
						$view->name_single_code
					);
				}
				// loop the mysql table settings
				foreach (
					$this->mysqlTableKeys as $_mysqlTableKey => $_mysqlTableVal
				)
				{
					// check if the table engine changed
					if (isset($old_view->{'mysql_table_' . $_mysqlTableKey})
						&& isset($view->{'mysql_table_' . $_mysqlTableKey}))
					{
						$this->setUpdateSQL(
							$old_view->{'mysql_table_' . $_mysqlTableKey},
							$view->{'mysql_table_' . $_mysqlTableKey},
							'table_' . $_mysqlTableKey, $view->name_single_code
						);
					}
					// check if there is no history on table engine, and it changed from the default/global
					elseif (isset($view->{'mysql_table_' . $_mysqlTableKey})
						&& StringHelper::check(
							$view->{'mysql_table_' . $_mysqlTableKey}
						)
						&& !is_numeric(
							$view->{'mysql_table_' . $_mysqlTableKey}
						))
					{
						$this->setUpdateSQL(
							$_mysqlTableVal['default'],
							$view->{'mysql_table_' . $_mysqlTableKey},
							'table_' . $_mysqlTableKey, $view->name_single_code
						);
					}
				}
				// clear this data
				unset($old_view);
			}
			// set the conditions
			$view->addconditions = (isset($view->addconditions)
				&& JsonHelper::check($view->addconditions))
				? json_decode($view->addconditions, true) : null;
			if (ArrayHelper::check($view->addconditions))
			{
				$view->conditions = array();
				$ne               = 0;
				foreach ($view->addconditions as $nr => $conditionValue)
				{
					if (ArrayHelper::check(
							$conditionValue['target_field']
						)
						&& ArrayHelper::check($view->fields))
					{
						foreach (
							$conditionValue['target_field'] as $fieldKey =>
							$fieldId
						)
						{
							foreach ($view->fields as $fieldValues)
							{
								if ((int) $fieldValues['field']
									== (int) $fieldId)
								{
									// load the field details
									$required
										      = GetHelper::between(
										$fieldValues['settings']->xml,
										'required="', '"'
									);
									$required = ($required === 'true'
										|| $required === '1') ? 'yes' : 'no';
									$filter
										      = GetHelper::between(
										$fieldValues['settings']->xml,
										'filter="', '"'
									);
									$filter
										      = StringHelper::check(
										$filter
									) ? $filter : 'none';
									// set the field name
									$conditionValue['target_field'][$fieldKey]
										= array(
										'name'     => $this->getFieldName(
											$fieldValues, $view->name_list_code
										),
										'type'     => $this->getFieldType(
											$fieldValues
										),
										'required' => $required,
										'filter'   => $filter
									);
									break;
								}
							}
						}
					}

					// load match field
					if (ArrayHelper::check($view->fields)
						&& isset($conditionValue['match_field']))
					{
						foreach ($view->fields as $fieldValue)
						{
							if ((int) $fieldValue['field']
								== (int) $conditionValue['match_field'])
							{
								// set the type
								$type = $this->getFieldType($fieldValue);
								// set the field details
								$conditionValue['match_name']
									                          = $this->getFieldName(
									$fieldValue, $view->name_list_code
								);
								$conditionValue['match_type'] = $type;
								$conditionValue['match_xml']
									                          = $fieldValue['settings']->xml;
								// if custom field load field being extended
								if (!ComponentbuilderHelper::fieldCheck($type))
								{
									$conditionValue['match_extends']
										= GetHelper::between(
										$fieldValue['settings']->xml,
										'extends="', '"'
									);
								}
								else
								{
									$conditionValue['match_extends'] = '';
								}
								break;
							}
						}
					}
					// set condition values
					$view->conditions[$ne] = $conditionValue;
					$ne++;
				}
			}
			unset($view->addconditions);

			// prep the buckets
			$this->fieldRelations[$view->name_list_code]   = array();
			$this->listJoinBuilder[$view->name_list_code]  = array();
			$this->listHeadOverRide[$view->name_list_code] = array();
			// set the relations
			$view->addrelations = (isset($view->addrelations)
				&& JsonHelper::check($view->addrelations))
				? json_decode($view->addrelations, true) : null;
			if (ArrayHelper::check($view->addrelations))
			{
				foreach ($view->addrelations as $nr => $relationsValue)
				{
					// only add if list view field is selected and joind fields are set
					if (isset($relationsValue['listfield'])
						&& is_numeric(
							$relationsValue['listfield']
						)
						&& $relationsValue['listfield'] > 0
						&& isset($relationsValue['area'])
						&& is_numeric($relationsValue['area'])
						&& $relationsValue['area'] > 0)
					{
						// do a dynamic update on the set values
						if (isset($relationsValue['set'])
							&& StringHelper::check(
								$relationsValue['set']
							))
						{
							$relationsValue['set'] = CFactory::_('Customcode')->add(
								$relationsValue['set']
							);
						}
						// check that the arrays are set
						if (!isset($this->fieldRelations[$view->name_list_code][(int) $relationsValue['listfield']])
							|| !ArrayHelper::check(
								$this->fieldRelations[$view->name_list_code][(int) $relationsValue['listfield']]
							))
						{
							$this->fieldRelations[$view->name_list_code][(int) $relationsValue['listfield']]
								= array();
						}
						// load the field relations
						$this->fieldRelations[$view->name_list_code][(int) $relationsValue['listfield']][(int) $relationsValue['area']]
							= $relationsValue;
						// load the list joints
						if (isset($relationsValue['joinfields'])
							&& ArrayHelper::check(
								$relationsValue['joinfields']
							))
						{
							foreach ($relationsValue['joinfields'] as $join)
							{
								$this->listJoinBuilder[$view->name_list_code][(int) $join]
									= (int) $join;
							}
						}
						// set header over-ride
						if (isset($relationsValue['column_name'])
							&& StringHelper::check(
								$relationsValue['column_name']
							))
						{
							$check_column_name = trim(
								strtolower($relationsValue['column_name'])
							);
							// confirm it should really make the over ride
							if ('default' !== $check_column_name)
							{
								$column_name_lang = CFactory::_('Config')->lang_prefix . '_'
									. StringHelper::safe(
										$view->name_list_code, 'U'
									) . '_'
									. StringHelper::safe(
										$relationsValue['column_name'], 'U'
									);
								CFactory::_('Language')->set(
									'admin', $column_name_lang,
									$relationsValue['column_name']
								);
								$this->listHeadOverRide[$view->name_list_code][(int) $relationsValue['listfield']]
									= $column_name_lang;
							}
						}
					}
				}
			}
			unset($view->addrelations);

			// set linked views
			$this->linkedAdminViews[$view->name_single_code] = null;
			$view->addlinked_views
			                                                 = (isset($view->addlinked_views)
				&& JsonHelper::check($view->addlinked_views))
				? json_decode($view->addlinked_views, true) : null;
			if (ArrayHelper::check($view->addlinked_views))
			{
				// setup linked views to global data sets
				$this->linkedAdminViews[$view->name_single_code] = array_values(
					$view->addlinked_views
				);
			}
			unset($view->addlinked_views);
			// set the lang target
			CFactory::_('Config')->lang_target = 'admin';
			if (isset($this->siteEditView[$id]))
			{
				CFactory::_('Config')->lang_target = 'both';
			}
			// set GUI mapper
			$guiMapper = array('table' => 'admin_view', 'id' => (int) $id,
			                   'type'  => 'js');
			// add_javascript
			$addArrayJ = array('javascript_view_file', 'javascript_view_footer',
				'javascript_views_file',
				'javascript_views_footer');
			// update GUI mapper
			$guiMapper['prefix'] = PHP_EOL;
			foreach ($addArrayJ as $scripter)
			{
				if (isset($view->{'add_' . $scripter})
					&& $view->{'add_' . $scripter} == 1
					&& StringHelper::check($view->$scripter))
				{
					$scripter_target = str_replace(
						'javascript_', '', $scripter
					);
					// update GUI mapper field
					$guiMapper['field'] = $scripter;
					CFactory::_('Customcode.Dispenser')->set(
						$view->{$scripter},
						$scripter_target,
						$view->name_single_code,
						null,
						$guiMapper,
						true,
						true,
						true
					);
					// check if a token must be set
					if (strpos($view->$scripter, "token") !== false
						|| strpos(
							$view->$scripter, "task=ajax"
						) !== false)
					{
						if (!CFactory::_('Customcode.Dispenser')->hub['token'][$view->name_single_code])
						{
							CFactory::_('Customcode.Dispenser')->hub['token'][$view->name_single_code]
								= true;
						}
					}
					unset($view->{$scripter});
				}
			}
			unset($guiMapper['prefix']);
			// add_css
			$addArrayC = array('css_view', 'css_views');
			foreach ($addArrayC as $scripter)
			{
				if (isset($view->{'add_' . $scripter})
					&& $view->{'add_' . $scripter} == 1
					&& StringHelper::check($view->{$scripter}))
				{
					CFactory::_('Customcode.Dispenser')->set(
						$view->{$scripter},
						$scripter,
						$view->name_single_code,
						null,
						array('prefix' => PHP_EOL),
						true,
						true,
						true
					);
					unset($view->{$scripter});
				}
			}
			// update GUI mapper
			$guiMapper['type'] = 'php';
			// add_php
			$addArrayP = array('php_getitem', 'php_before_save', 'php_save',
				'php_getform', 'php_postsavehook',
				'php_getitems', 'php_getitems_after_all',
				'php_getlistquery', 'php_allowadd',
				'php_allowedit', 'php_before_cancel',
				'php_after_cancel', 'php_before_delete',
				'php_after_delete', 'php_before_publish',
				'php_after_publish', 'php_batchcopy',
				'php_batchmove', 'php_document');
			foreach ($addArrayP as $scripter)
			{
				if (isset($view->{'add_' . $scripter})
					&& $view->{'add_' . $scripter} == 1)
				{
					// update GUI mapper field
					$guiMapper['field'] = $scripter;
					CFactory::_('Customcode.Dispenser')->set(
						$view->{$scripter},
						$scripter,
						$view->name_single_code,
						null,
						$guiMapper
					);

					// check if we have template or layouts to load
					$this->setTemplateAndLayoutData(
						$view->{$scripter}, $view->name_single_code
					);

					unset($view->{$scripter});
				}
			}
			// add the custom buttons
			if (isset($view->add_custom_button)
				&& $view->add_custom_button == 1)
			{
				$button_code_array = array(
					'php_model',
					'php_controller',
					'php_model_list',
					'php_controller_list'
				);
				// set for the code
				foreach ($button_code_array as $button_code_field)
				{
					if (isset($view->{$button_code_field})
						&& StringHelper::check(
							$view->{$button_code_field}
						))
					{
						// set field
						$guiMapper['field'] = $button_code_field;
						$view->{$button_code_field}
						                    = CFactory::_('Customcode.Gui')->set(
							CFactory::_('Customcode')->add(
								base64_decode($view->{$button_code_field})
							),
							$guiMapper
						);

						// check if we have template or layouts to load
						$this->setTemplateAndLayoutData(
							$view->{$button_code_field}, $view->name_single_code
						);
					}
				}
				// set the button array
				$view->custom_button = (isset($view->custom_button)
					&& JsonHelper::check($view->custom_button))
					? json_decode($view->custom_button, true) : null;
				if (ArrayHelper::check($view->custom_button))
				{
					$view->custom_buttons = array_values($view->custom_button);
				}
				unset($view->custom_button);
			}
			// set custom import scripts
			if (isset($view->add_custom_import)
				&& $view->add_custom_import == 1)
			{
				$addImportArray = array('php_import_ext', 'php_import_display',
					'php_import', 'php_import_setdata',
					'php_import_save', 'php_import_headers',
					'html_import_view');
				foreach ($addImportArray as $importScripter)
				{
					if (isset($view->$importScripter)
						&& strlen(
							$view->$importScripter
						) > 0)
					{
						// update GUI mapper field
						$guiMapper['field'] = $importScripter;
						$guiMapper['type']  = 'php';
						// Make sure html gets HTML comment for placeholder
						if ('html_import_view' === $importScripter)
						{
							$guiMapper['type'] = 'html';
						}
						CFactory::_('Customcode.Dispenser')->set(
							$view->$importScripter,
							$importScripter,
							'import_' . $view->name_list_code,
							null,
							$guiMapper
						);
						unset($view->$importScripter);
					}
					else
					{
						// load the default
						CFactory::_('Customcode.Dispenser')->hub[$importScripter]['import_'
						. $view->name_list_code]
							= ComponentbuilderHelper::getDynamicScripts(
							$importScripter, true
						);
					}
				}
			}
			// add_Ajax for this view
			if (isset($view->add_php_ajax) && $view->add_php_ajax == 1)
			{
				// insure the token is added to edit view atleast
				CFactory::_('Customcode.Dispenser')->hub['token'][$view->name_single_code]
					         = true;
				$addAjaxSite = false;
				if (isset($this->siteEditView[$id]) && $this->siteEditView[$id])
				{
					// we should add this site ajax to front ajax
					$addAjaxSite = true;
					if (!isset($this->addSiteAjax) || !$this->addSiteAjax)
					{
						$this->addSiteAjax = true;
					}
				}
				// check if controller input as been set
				$view->ajax_input = (isset($view->ajax_input)
					&& JsonHelper::check($view->ajax_input))
					? json_decode($view->ajax_input, true) : null;
				if (ArrayHelper::check($view->ajax_input))
				{
					if ($addAjaxSite)
					{
						CFactory::_('Customcode.Dispenser')->hub['site']['ajax_controller'][$view->name_single_code]
							= array_values($view->ajax_input);
					}
					CFactory::_('Customcode.Dispenser')->hub['admin']['ajax_controller'][$view->name_single_code]
						           = array_values($view->ajax_input);
					$this->addAjax = true;
					unset($view->ajax_input);
				}
				if (StringHelper::check($view->php_ajaxmethod))
				{
					// make sure we are still in PHP
					$guiMapper['type'] = 'php';
					// update GUI mapper field
					$guiMapper['field'] = 'php_ajaxmethod';
					CFactory::_('Customcode.Dispenser')->set(
						$view->php_ajaxmethod,
						'admin',
						'ajax_model',
						$view->name_single_code,
						$guiMapper
					);

					if ($addAjaxSite)
					{
						CFactory::_('Customcode.Dispenser')->set(
							$view->php_ajaxmethod,
							'site',
							'ajax_model',
							$view->name_single_code,
							$guiMapper,
							false,
							false
						);
					}
					// unset anyway
					unset($view->php_ajaxmethod);
					$this->addAjax = true;
				}
			}
			// activate alias builder
			if (!isset($this->customAliasBuilder[$view->name_single_code])
				&& isset($view->alias_builder_type)
				&& 2 == $view->alias_builder_type
				&& isset($view->alias_builder)
				&& JsonHelper::check($view->alias_builder))
			{
				// get the aliasFields
				$alias_fields = (array) json_decode($view->alias_builder, true);
				// get the active fields
				$alias_fields = (array) array_filter(
					$view->fields, function ($field) use ($alias_fields) {
					// check if field is in view fields
					if (in_array($field['field'], $alias_fields))
					{
						return true;
					}

					return false;
				}
				);
				// check if all is well
				if (ArrayHelper::check($alias_fields))
				{
					// load the field names
					$this->customAliasBuilder[$view->name_single_code]
						= (array) array_map(
						function ($field) use (&$view) {
							return $this->getFieldName(
								$field, $view->name_list_code
							);
						}, $alias_fields
					);
				}
			}
			// unset
			unset($view->alias_builder);
			// add_sql
			if ($view->add_sql == 1)
			{
				if ($view->source == 1 && isset($view->tables))
				{
					// build and add the SQL dump
					CFactory::_('Customcode.Dispenser')->hub['sql'][$view->name_single_code]
						= $this->buildSqlDump(
						$view->tables, $view->name_single_code, $id
					);
					unset($view->tables);
				}
				elseif ($view->source == 2 && isset($view->sql))
				{
					// add the SQL dump string
					CFactory::_('Customcode.Dispenser')->set(
						$view->sql,
						'sql',
						$view->name_single_code
					);
					unset($view->sql);
				}
			}
			// load table settings
			if (!isset($this->mysqlTableSetting[$view->name_single_code]))
			{
				$this->mysqlTableSetting[$view->name_single_code] = array();
			}
			// set mySql Table Settings
			foreach (
				$this->mysqlTableKeys as $_mysqlTableKey => $_mysqlTableVal
			)
			{
				if (isset($view->{'mysql_table_' . $_mysqlTableKey})
					&& StringHelper::check(
						$view->{'mysql_table_' . $_mysqlTableKey}
					)
					&& !is_numeric($view->{'mysql_table_' . $_mysqlTableKey}))
				{
					$this->mysqlTableSetting[$view->name_single_code][$_mysqlTableKey]
						= $view->{'mysql_table_' . $_mysqlTableKey};
				}
				else
				{
					$this->mysqlTableSetting[$view->name_single_code][$_mysqlTableKey]
						= $_mysqlTableVal['default'];
				}
				// remove the table values since we moved to another object
				unset($view->{'mysql_table_' . $_mysqlTableKey});
			}

			// for plugin event TODO change event api signatures
			$this->placeholders = CFactory::_('Placeholder')->active;
			// Trigger Event: jcb_ce_onAfterModelViewData
			CFactory::_J('Event')->trigger(
				'jcb_ce_onAfterModelViewData',
				array(&$this->componentContext, &$view, &$this->placeholders)
			);
			// for plugin event TODO change event api signatures
			CFactory::_('Placeholder')->active = $this->placeholders;

			// clear placeholders
			unset(CFactory::_('Placeholder')->active[Placefix::_h('view')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_h('views')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_h('View')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_h('Views')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_h('VIEW')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_h('VIEWS')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_('view')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_('views')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_('View')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_('Views')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_('VIEW')]);
			unset(CFactory::_('Placeholder')->active[Placefix::_('VIEWS')]);

			// store this view to class object
			$this->_adminViewData[$id] = $view;
		}

		// return the found view data
		return $this->_adminViewData[$id];
	}

	/**
	 * Get all Custom View Data
	 *
	 * @param   int     $id     The view ID
	 * @param   string  $table  The view table
	 *
	 * @return  oject The view data
	 *
	 */
	public function getCustomViewData($id, $table = 'site_view')
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		$query->select('a.*');
		$query->from('#__componentbuilder_' . $table . ' AS a');
		$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);

		// Trigger Event: jcb_ce_onBeforeQueryCustomViewData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeQueryCustomViewData',
			array(&$this->componentContext, &$id, &$table, &$query, &$this->db)
		);

		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$view = $this->db->loadObject();
		// fix alias to use in code
		$view->code = $this->uniqueCode(
			StringHelper::safe($view->codename)
		);
		$view->Code = StringHelper::safe($view->code, 'F');
		$view->CODE = StringHelper::safe($view->code, 'U');
		// Trigger Event: jcb_ce_onBeforeModelCustomViewData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onBeforeModelCustomViewData',
			array(&$this->componentContext, &$view, &$id, &$table)
		);

		if ($table === 'site_view')
		{
			CFactory::_('Config')->lang_target = 'site';
			// repeatable fields to update
			$searchRepeatables = array(
				// repeatablefield => checker
				'ajax_input'    => 'value_name',
				'custom_button' => 'name'
			);
		}
		else
		{
			CFactory::_('Config')->lang_target = 'admin';
			// repeatable fields to update
			$searchRepeatables = array(
				// repeatablefield => checker
				'custom_button' => 'name'
			);
		}
		// set upater
		$updater = array(
			'table' => $table,
			'key'   => 'id',
			'val'   => (int) $id
		);
		// update the repeatable fields
		$view = ComponentbuilderHelper::convertRepeatableFields(
			$view, $searchRepeatables, $updater
		);

		// set GUI mapper
		$guiMapper = array('table' => $table, 'id' => (int) $id,
		                   'field' => 'default', 'type' => 'html');

		// set the default data
		$view->default = CFactory::_('Customcode.Gui')->set(
			CFactory::_('Customcode')->add(base64_decode($view->default)),
			$guiMapper
		);
		// load context if not set
		if (!isset($view->context)
			|| !StringHelper::check(
				$view->context
			))
		{
			$view->context = $view->code;
		}
		else
		{
			// always make sure context is a safe string
			$view->context = StringHelper::safe($view->context);
		}
		// load the library
		if (!isset($this->libManager[CFactory::_('Config')->build_target]))
		{
			$this->libManager[CFactory::_('Config')->build_target] = array();
		}
		if (!isset($this->libManager[CFactory::_('Config')->build_target][$view->code]))
		{
			$this->libManager[CFactory::_('Config')->build_target][$view->code] = array();
		}
		// make sure json become array
		if (JsonHelper::check($view->libraries))
		{
			$view->libraries = json_decode($view->libraries, true);
		}
		// if we have an array add it
		if (ArrayHelper::check($view->libraries))
		{
			foreach ($view->libraries as $library)
			{
				if (!isset($this->libManager[CFactory::_('Config')->build_target][$view->code][$library]))
				{
					if ($this->getMediaLibrary((int) $library))
					{
						$this->libManager[CFactory::_('Config')->build_target][$view->code][(int) $library]
							= true;
					}
				}
			}
		}
		elseif (is_numeric($view->libraries)
			&& !isset($this->libManager[CFactory::_('Config')->build_target][$view->code][(int) $view->libraries]))
		{
			if ($this->getMediaLibrary((int) $view->libraries))
			{
				$this->libManager[CFactory::_('Config')->build_target][$view->code][(int) $view->libraries]
					= true;
			}
		}
		// setup template array
		$this->templateData[CFactory::_('Config')->build_target][$view->code] = array();
		// setup template and layout data
		$this->setTemplateAndLayoutData($view->default, $view->code);
		// insure the uikit components are loaded
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			if (!isset($this->uikitComp[$view->code]))
			{
				$this->uikitComp[$view->code] = array();
			}
			$this->uikitComp[$view->code]
				= ComponentbuilderHelper::getUikitComp(
				$view->default, $this->uikitComp[$view->code]
			);
		}
		// check for footable
		if (!isset($this->footableScripts[CFactory::_('Config')->build_target][$view->code])
			|| !$this->footableScripts[CFactory::_('Config')->build_target][$view->code])
		{
			$foundFoo = $this->getFootableScripts($view->default);
			if ($foundFoo)
			{
				$this->footableScripts[CFactory::_('Config')->build_target][$view->code] = true;
			}
			if ($foundFoo && !$this->footableScripts)
			{
				$this->footable = true;
			}
		}
		// check for get module
		if (!isset($this->getModule[CFactory::_('Config')->build_target][$view->code])
			|| !$this->getModule[CFactory::_('Config')->build_target][$view->code])
		{
			$found = $this->getGetModule($view->default);
			if ($found)
			{
				$this->getModule[CFactory::_('Config')->build_target][$view->code] = true;
			}
		}
		// set the main get data
		$main_get       = $this->setGetData(
			array($view->main_get), $view->code, $view->context
		);
		$view->main_get = $main_get[0];
		// set the custom_get data
		$view->custom_get = $this->setGetData(
			json_decode($view->custom_get, true), $view->code, $view->context
		);
		// set array adding array of scripts
		$addArray = array('php_view', 'php_jview', 'php_jview_display',
			'php_document', 'javascript_file', 'js_document',
			'css_document', 'css');
		// set GUI mapper
		$guiMapper['type'] = 'php';
		foreach ($addArray as $scripter)
		{
			if (isset($view->{'add_' . $scripter})
				&& $view->{'add_' . $scripter} == 1
				&& StringHelper::check($view->$scripter))
			{
				// css does not get placholders yet
				if (strpos($scripter, 'css') === false)
				{
					// set field
					$guiMapper['field'] = $scripter;
					$view->$scripter    = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Customcode')->add(
							base64_decode($view->$scripter)
						),
						$guiMapper
					);
				}
				else
				{
					$view->$scripter = CFactory::_('Customcode')->add(
						base64_decode($view->$scripter)
					);
				}
				if (2 == $this->uikit || 1 == $this->uikit)
				{
					if (!isset($this->uikitComp[$view->code]))
					{
						$this->uikitComp[$view->code] = array();
					}
					// set uikit to views
					$this->uikitComp[$view->code]
						= ComponentbuilderHelper::getUikitComp(
						$view->$scripter, $this->uikitComp[$view->code]
					);
				}

				$this->setTemplateAndLayoutData($view->$scripter, $view->code);

				// check for footable
				if (!isset($this->footableScripts[CFactory::_('Config')->build_target][$view->code])
					|| !$this->footableScripts[CFactory::_('Config')->build_target][$view->code])
				{
					$foundFoo = $this->getFootableScripts($view->$scripter);
					if ($foundFoo)
					{
						$this->footableScripts[CFactory::_('Config')->build_target][$view->code]
							= true;
					}
					if ($foundFoo && !$this->footable)
					{
						$this->footable = true;
					}
				}
				// check for google chart
				if (!isset($this->googleChart[CFactory::_('Config')->build_target][$view->code])
					|| !$this->googleChart[CFactory::_('Config')->build_target][$view->code])
				{
					$found = $this->getGoogleChart($view->$scripter);
					if ($found)
					{
						$this->googleChart[CFactory::_('Config')->build_target][$view->code] = true;
					}
					if ($found && !$this->googlechart)
					{
						$this->googlechart = true;
					}
				}
				// check for get module
				if (!isset($this->getModule[CFactory::_('Config')->build_target][$view->code])
					|| !$this->getModule[CFactory::_('Config')->build_target][$view->code])
				{
					$found = $this->getGetModule($view->$scripter);
					if ($found)
					{
						$this->getModule[CFactory::_('Config')->build_target][$view->code] = true;
					}
				}
			}
		}
		// add_Ajax for this view
		if (isset($view->add_php_ajax) && $view->add_php_ajax == 1)
		{
			// ajax target (since we only have two options really)
			if ('site' === CFactory::_('Config')->build_target)
			{
				$target = 'site';
			}
			else
			{
				$target = 'admin';
			}
			$setAjax = false;
			// check if controller input as been set
			$view->ajax_input = (isset($view->ajax_input)
				&& JsonHelper::check($view->ajax_input))
				? json_decode($view->ajax_input, true) : null;
			if (ArrayHelper::check($view->ajax_input))
			{
				CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_controller'][$view->code]
					     = array_values($view->ajax_input);
				$setAjax = true;
			}
			unset($view->ajax_input);
			// load the ajax class mathods (if set)
			if (StringHelper::check($view->php_ajaxmethod))
			{
				// set field
				$guiMapper['field'] = 'php_ajaxmethod';
				CFactory::_('Customcode.Dispenser')->set(
					$view->php_ajaxmethod,
					$target,
					'ajax_model',
					$view->code,
					$guiMapper
				);
				$setAjax = true;
			}
			// unset anyway
			unset($view->php_ajaxmethod);
			// should ajax be set
			if ($setAjax)
			{
				// turn on ajax area
				if ('site' === CFactory::_('Config')->build_target)
				{
					$this->addSiteAjax = true;
				}
				else
				{
					$this->addAjax = true;
				}
			}
		}
		// add the custom buttons
		if (isset($view->add_custom_button) && $view->add_custom_button == 1)
		{
			$button_code_array = array(
				'php_model',
				'php_controller'
			);
			// set for the code
			foreach ($button_code_array as $button_code_field)
			{
				if (isset($view->{$button_code_field})
					&& StringHelper::check(
						$view->{$button_code_field}
					))
				{
					// set field
					$guiMapper['field']         = $button_code_field;
					$view->{$button_code_field} = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Customcode')->add(
							base64_decode($view->{$button_code_field})
						),
						$guiMapper
					);
				}
			}
			// set the button array
			$view->custom_button = (isset($view->custom_button)
				&& JsonHelper::check($view->custom_button))
				? json_decode($view->custom_button, true) : null;
			if (ArrayHelper::check($view->custom_button))
			{
				$view->custom_buttons = array_values($view->custom_button);
			}
			unset($view->custom_button);
		}

		// Trigger Event: jcb_ce_onAfterModelCustomViewData
		CFactory::_J('Event')->trigger(
			'jcb_ce_onAfterModelCustomViewData',
			array(&$this->componentContext, &$view)
		);

		// return the found view data
		return $view;
	}

	/**
	 * Get all Field Data
	 *
	 * @param   int     $id           The field ID
	 * @param   string  $name_single  The view edit or single name
	 * @param   string  $name_list    The view list name
	 *
	 * @return  oject The field data
	 *
	 */
	public function getFieldData($id, $name_single = null, $name_list = null)
	{
		if ($id > 0 && !isset($this->_fieldData[$id]))
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			// Select all the values in the field
			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array('c.name', 'c.properties'),
					array('type_name', 'properties')
				)
			);
			$query->from('#__componentbuilder_field AS a');
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_fieldtype', 'c')
				. ' ON (' . $this->db->quoteName('a.fieldtype') . ' = '
				. $this->db->quoteName('c.id') . ')'
			);
			$query->where(
				$this->db->quoteName('a.id') . ' = ' . $this->db->quote($id)
			);

			// Trigger Event: jcb_ce_onBeforeQueryFieldData
			CFactory::_J('Event')->trigger(
				'jcb_ce_onBeforeQueryFieldData',
				array(&$this->componentContext, &$id, &$query, &$this->db)
			);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// Load the results as a list of stdClass objects (see later for more options on retrieving data).
				$field = $this->db->loadObject();

				// Trigger Event: jcb_ce_onBeforeModelFieldData
				CFactory::_J('Event')->trigger(
					'jcb_ce_onBeforeModelFieldData',
					array(&$this->componentContext, &$field)
				);

				// adding a fix for the changed name of type to fieldtype
				$field->type = $field->fieldtype;

				// repeatable fields to update
				$searchRepeatables = array(
					// repeatablefield => checker
					'properties' => 'name'
				);
				// set upater
				$updater = array(
					'table' => 'fieldtype',
					'key'   => 'id',
					'val'   => (int) $id
				);
				// update the repeatable fields
				$field = ComponentbuilderHelper::convertRepeatableFields(
					$field, $searchRepeatables, $updater
				);

				// load the values form params
				$field->xml = CFactory::_('Customcode')->add(json_decode($field->xml));

				// check if we have validate (validation rule set)
				$validationRule = GetHelper::between(
					$field->xml, 'validate="', '"'
				);
				if (StringHelper::check($validationRule))
				{
					// make sure it is lowercase
					$validationRule = StringHelper::safe(
						$validationRule
					);
					// link this field to this validation
					$this->validationLinkedFields[$id] = $validationRule;
					// make sure it is not already set
					if (!isset($this->validationRules[$validationRule]))
					{
						// get joomla core validation names
						if ($coreValidationRules
							= ComponentbuilderHelper::getExistingValidationRuleNames(
							true
						))
						{
							// make sure this rule is not a core validation rule
							if (!in_array(
								$validationRule, (array) $coreValidationRules
							))
							{
								// get the class methods for this rule if it exists
								if ($this->validationRules[$validationRule]
									= GetHelper::var(
									'validation_rule', $validationRule, 'name',
									'php'
								))
								{
									// open and set the validation rule
									$this->validationRules[$validationRule]
										= CFactory::_('Customcode.Gui')->set(
										CFactory::_('Placeholder')->update(
											CFactory::_('Customcode')->add(
												base64_decode(
													$this->validationRules[$validationRule]
												)
											), CFactory::_('Placeholder')->active
										),
										array(
											'table' => 'validation_rule',
											'field' => 'php',
											'id'    => GetHelper::var(
												'validation_rule',
												$validationRule, 'name', 'id'
											),
											'type'  => 'php')
									);
								}
								else
								{
									// set the notice that this validation rule is custom and was not found (TODO)
									unset($this->validationLinkedFields[$id], $this->validationRules[$validationRule]);
								}
							}
							else
							{
								// remove link (we only want custom validations linked)
								unset($this->validationLinkedFields[$id]);
							}
						}
					}
				}

				// load the type values form type params
				$field->properties = (isset($field->properties)
					&& JsonHelper::check($field->properties))
					? json_decode($field->properties, true) : null;
				if (ArrayHelper::check($field->properties))
				{
					$field->properties = array_values($field->properties);
				}
				// check if we have WHMCS encryption
				if (4 == $field->store
					&& (!isset($this->whmcsEncryption)
						|| !$this->whmcsEncryption))
				{
					$this->whmcsEncryption = true;
				}
				// check if we have basic encryption
				elseif (3 == $field->store
					&& (!isset($this->basicEncryption)
						|| !$this->basicEncryption))
				{
					$this->basicEncryption = true;
				}
				// check if we have better encryption
				elseif (5 == $field->store
					&& (!isset($this->mediumEncryption)
						|| !$this->mediumEncryption))
				{
					$this->mediumEncryption = true;
				}
				// check if we have better encryption
				elseif (6 == $field->store
					&& StringHelper::check(
						$field->on_get_model_field
					)
					&& StringHelper::check(
						$field->on_save_model_field
					))
				{
					// add only if string lenght found
					if (StringHelper::check(
						$field->initiator_on_save_model
					))
					{
						$field->initiator_save_key = md5(
							$field->initiator_on_save_model
						);
						$field->initiator_save     = explode(
							PHP_EOL, CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode(
									$field->initiator_on_save_model
								)
							), CFactory::_('Placeholder')->active
						)
						);
					}
					if (StringHelper::check(
						$field->initiator_on_save_model
					))
					{
						$field->initiator_get_key = md5(
							$field->initiator_on_get_model
						);
						$field->initiator_get     = explode(
							PHP_EOL, CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode(
									$field->initiator_on_get_model
								)
							), CFactory::_('Placeholder')->active
						)
						);
					}
					// set the field modeling
					$field->model_field['save'] = explode(
						PHP_EOL, CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(
							base64_decode($field->on_save_model_field)
						), CFactory::_('Placeholder')->active
					)
					);
					$field->model_field['get']  = explode(
						PHP_EOL, CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(
							base64_decode($field->on_get_model_field)
						), CFactory::_('Placeholder')->active
					)
					);
					// remove the original values
					unset($field->on_save_model_field, $field->on_get_model_field, $field->initiator_on_save_model, $field->initiator_on_get_model);
				}

				// get the last used version
				$field->history = $this->getHistoryWatch('field', $id);

				// Trigger Event: jcb_ce_onAfterModelFieldData
				CFactory::_J('Event')->trigger(
					'jcb_ce_onAfterModelFieldData',
					array(&$this->componentContext, &$field)
				);

				$this->_fieldData[$id] = $field;
			}
			else
			{
				return false;
			}
		}
		// check if the script should be added to the view each time this field is called
		if ($id > 0 && isset($this->_fieldData[$id]))
		{
			// check if we should load scripts for single view
			if (StringHelper::check($name_single)
				&& !isset($this->customFieldScript[$name_single][$id]))
			{
				// add_javascript_view_footer
				if ($this->_fieldData[$id]->add_javascript_view_footer == 1
					&& StringHelper::check(
						$this->_fieldData[$id]->javascript_view_footer
					))
				{
					$convert__ = true;
					if (isset($this->_fieldData[$id]->javascript_view_footer_decoded)
						&& $this->_fieldData[$id]->javascript_view_footer_decoded)
					{
						$convert__ = false;
					}
					CFactory::_('Customcode.Dispenser')->set(
						$this->_fieldData[$id]->javascript_view_footer,
						'view_footer',
						$name_single,
						null,
						array(
							'table'  => 'field',
							'id'     => (int) $id,
							'field'  => 'javascript_view_footer',
							'type'   => 'js',
							'prefix' => PHP_EOL),
						$convert__,
						$convert__,
						true
					);
					if (!isset($this->_fieldData[$id]->javascript_view_footer_decoded))
					{
						$this->_fieldData[$id]->javascript_view_footer_decoded
							= true;
					}
					if (strpos(
							$this->_fieldData[$id]->javascript_view_footer,
							"token"
						) !== false
						|| strpos(
							$this->_fieldData[$id]->javascript_view_footer,
							"task=ajax"
						) !== false)
					{
						if (!isset(CFactory::_('Customcode.Dispenser')->hub['token']))
						{
							CFactory::_('Customcode.Dispenser')->hub['token'] = [];
						}
						if (!isset(CFactory::_('Customcode.Dispenser')->hub['token'][$name_single])
							|| !CFactory::_('Customcode.Dispenser')->hub['token'][$name_single])
						{
							CFactory::_('Customcode.Dispenser')->hub['token'][$name_single]
								= true;
						}
					}
				}

				// add_css_view
				if ($this->_fieldData[$id]->add_css_view == 1)
				{
					$convert__ = true;
					if (isset($this->_fieldData[$id]->css_view_decoded)
						&& $this->_fieldData[$id]->css_view_decoded)
					{
						$convert__ = false;
					}
					CFactory::_('Customcode.Dispenser')->set(
						$this->_fieldData[$id]->css_view,
						'css_view',
						$name_single,
						null,
						array('prefix' => PHP_EOL),
						$convert__,
						$convert__,
						true
					);
					if (!isset($this->_fieldData[$id]->css_view_decoded))
					{
						$this->_fieldData[$id]->css_view_decoded = true;
					}
				}
			}
			// check if we should load scripts for list views
			if (StringHelper::check($name_list)
				&& !isset($this->customFieldScript[$name_list][$id]))
			{
				// add_javascript_views_footer
				if ($this->_fieldData[$id]->add_javascript_views_footer == 1
					&& StringHelper::check(
						$this->_fieldData[$id]->javascript_views_footer
					))
				{
					$convert__ = true;
					if (isset($this->_fieldData[$id]->javascript_views_footer_decoded)
						&& $this->_fieldData[$id]->javascript_views_footer_decoded)
					{
						$convert__ = false;
					}
					CFactory::_('Customcode.Dispenser')->set(
						$this->_fieldData[$id]->javascript_views_footer,
						'views_footer',
						$name_single,
						null,
						array(
							'table'  => 'field',
							'id'     => (int) $id,
							'field'  => 'javascript_views_footer',
							'type'   => 'js',
							'prefix' => PHP_EOL),
						$convert__,
						$convert__,
						true
					);
					if (!isset($this->_fieldData[$id]->javascript_views_footer_decoded))
					{
						$this->_fieldData[$id]->javascript_views_footer_decoded
							= true;
					}
					if (strpos(
							$this->_fieldData[$id]->javascript_views_footer,
							"token"
						) !== false
						|| strpos(
							$this->_fieldData[$id]->javascript_views_footer,
							"task=ajax"
						) !== false)
					{
						if (!isset(CFactory::_('Customcode.Dispenser')->hub['token']))
						{
							CFactory::_('Customcode.Dispenser')->hub['token'] = [];
						}
						if (!isset(CFactory::_('Customcode.Dispenser')->hub['token'][$name_list])
							|| !CFactory::_('Customcode.Dispenser')->hub['token'][$name_list])
						{
							CFactory::_('Customcode.Dispenser')->hub['token'][$name_list]
								= true;
						}
					}
				}
				// add_css_views
				if ($this->_fieldData[$id]->add_css_views == 1)
				{
					$convert__ = true;
					if (isset($this->_fieldData[$id]->css_views_decoded)
						&& $this->_fieldData[$id]->css_views_decoded)
					{
						$convert__ = false;
					}
					CFactory::_('Customcode.Dispenser')->set(
						$this->_fieldData[$id]->css_views,
						'css_views',
						$name_single,
						null,
						array('prefix' => PHP_EOL),
						$convert__,
						$convert__,
						true
					);
					if (!isset($this->_fieldData[$id]->css_views_decoded))
					{
						$this->_fieldData[$id]->css_views_decoded = true;
					}
				}
			}
			// add this only once to single view.
			$this->customFieldScript[$name_single][$id] = true;
			// add this only once to list view.
			$this->customFieldScript[$name_list][$id] = true;
		}
		if ($id > 0 && isset($this->_fieldData[$id]))
		{
			// return the found field data
			return $this->_fieldData[$id];
		}

		return false;
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
	 *
	 */
	public function setFieldDetails(&$field, $singleViewName = null,
	                                $listViewName = null, $amicably = ''
	)
	{
		// set hash
		static $hash = 123467890;
		// load hash if not found
		if (!isset($field['hash']))
		{
			$field['hash'] = md5($field['field'] . $hash);
			// increment hash
			$hash++;
		}
		// set the settings
		if (!isset($field['settings']))
		{
			$field['settings'] = $this->getFieldData(
				$field['field'], $singleViewName, $listViewName
			);
		}
		// set real field name
		if (!isset($field['base_name']))
		{
			$field['base_name'] = $this->getFieldName($field);
		}
		// set code name for field type
		if (!isset($field['type_name']))
		{
			$field['type_name'] = $this->getFieldType($field);
		}
		// check if value is array
		if (isset($field['permission'])
			&& !ArrayHelper::check(
				$field['permission']
			)
			&& is_numeric($field['permission'])
			&& $field['permission'] > 0)
		{
			$field['permission'] = array($field['permission']);
		}
		// set unique name keeper
		if ($listViewName)
		{
			$this->setUniqueNameCounter(
				$field['base_name'], $listViewName . $amicably
			);
		}
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
		if (isset($this->viewsDefaultOrdering[$nameListCode])
			&& $this->viewsDefaultOrdering[$nameListCode]['add_admin_ordering']
			== 1)
		{
			foreach (
				$this->viewsDefaultOrdering[$nameListCode]['admin_ordering_fields']
				as $order_field
			)
			{
				if (($order_field_name = $this->getFieldDatabaseName(
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
	 *
	 */
	public function getFieldDatabaseName($nameListCode, int $fieldId,
	                                     $targetArea = 'listBuilder'
	)
	{
		if (isset($this->{$targetArea}[$nameListCode]))
		{
			if ($fieldId < 0)
			{
				switch ($fieldId)
				{
					case -1:
						return 'a.id';
					case -2:
						return 'a.ordering';
					case -3:
						return 'a.published';
				}
			}
			foreach ($this->{$targetArea}[$nameListCode] as $field)
			{
				if ($field['id'] == $fieldId)
				{
					// now check if this is a category
					if ($field['type'] === 'category')
					{
						return 'c.title';
					}
					// set the custom code
					elseif (ArrayHelper::check(
						$field['custom']
					))
					{
						return $field['custom']['db'] . "."
							. $field['custom']['text'];
					}
					else
					{
						return 'a.' . $field['code'];
					}
				}
			}
		}

		return false;
	}

	/**
	 * Get the field's actual type
	 *
	 * @param   object  $field  The field object
	 *
	 * @return  string   Success returns field type
	 *
	 */
	public function getFieldType(&$field)
	{
		// check if we have done this already
		if (isset($field['type_name']))
		{
			return $field['type_name'];
		}
		// check that we have the poperties
		if (isset($field['settings'])
			&& ObjectHelper::check(
				$field['settings']
			)
			&& isset($field['settings']->properties)
			&& ArrayHelper::check(
				$field['settings']->properties
			))
		{
			// search for own custom fields
			if (strpos($field['settings']->type_name, '@') !== false)
			{
				// set own custom field
				$field['settings']->own_custom = $field['settings']->type_name;
				$field['settings']->type_name  = 'Custom';
			}
			// set the type name
			$type_name = TypeHelper::safe(
				$field['settings']->type_name
			);
			// if custom (we must use the xml value)
			if (strtolower($type_name) === 'custom'
				|| strtolower($type_name) === 'customuser')
			{
				$type = TypeHelper::safe(
					GetHelper::between(
						$field['settings']->xml, 'type="', '"'
					)
				);
			}
			else
			{
				// loop over properties looking for the type value
				foreach ($field['settings']->properties as $property)
				{
					if ($property['name']
						=== 'type') // type field is never ajustable (unless custom)
					{
						// force the default value
						if (isset($property['example'])
							&& StringHelper::check(
								$property['example']
							))
						{
							$type = TypeHelper::safe(
								$property['example']
							);
						}
						// fall back on the xml settings (not ideal)
						else
						{
							$type = TypeHelper::safe(
								GetHelper::between(
									$field['settings']->xml, 'type="', '"'
								)
							);
						}
						// exit foreach loop
						break;
					}
				}
			}
			// check if the value is set
			if (isset($type) && StringHelper::check($type))
			{
				return $type;
			}
			// fallback on type name set in name field (not ideal)
			else
			{
				return $type_name;
			}
		}

		// fall back to text
		return 'text';
	}

	/**
	 * Get the field's actual name
	 *
	 * @param   object  $field         The field object
	 * @param   string  $listViewName  The list view name
	 * @param   string  $amicably      The peaceful resolve (for fields in subforms in same view :)
	 *
	 * @return  string   Success returns field name
	 *
	 */
	public function getFieldName(&$field, $listViewName = null, $amicably = '')
	{
		// return the unique name if already set
		if (StringHelper::check($listViewName)
			&& isset($field['hash'])
			&& isset(
				$this->uniqueFieldNames[$listViewName . $amicably
				. $field['hash']]
			))
		{
			return $this->uniqueFieldNames[$listViewName . $amicably
			. $field['hash']];
		}
		// always make sure we have a field name and type
		if (!isset($field['settings']) || !isset($field['settings']->type_name)
			|| !isset($field['settings']->name))
		{
			return 'error';
		}
		// set the type name
		$type_name = TypeHelper::safe(
			$field['settings']->type_name
		);
		// set the name of the field
		$name = FieldHelper::safe($field['settings']->name);
		// check that we have the properties
		if (ArrayHelper::check($field['settings']->properties))
		{
			foreach ($field['settings']->properties as $property)
			{
				if ($property['name'] === 'name')
				{
					// if category then name must be catid (only one per view)
					if ($type_name === 'category')
					{
						// quick check if this is a category linked to view page
						$requeSt_id = GetHelper::between(
							$field['settings']->xml, 'name="', '"'
						);
						if (strpos($requeSt_id, '_request_id') !== false
							|| strpos($requeSt_id, '_request_catid') !== false)
						{
							// keep it then, don't change
							$name = CFactory::_('Placeholder')->update(
								$requeSt_id, CFactory::_('Placeholder')->active
							);
						}
						else
						{
							$name = 'catid';
						}
						// if list view name is set
						if (StringHelper::check($listViewName))
						{
							// check if we should use another Text Name as this views name
							$otherName  = CFactory::_('Placeholder')->update(
								GetHelper::between(
									$field['settings']->xml, 'othername="', '"'
								), CFactory::_('Placeholder')->active
							);
							$otherViews = CFactory::_('Placeholder')->update(
								GetHelper::between(
									$field['settings']->xml, 'views="', '"'
								), CFactory::_('Placeholder')->active
							);
							$otherView  = CFactory::_('Placeholder')->update(
								GetHelper::between(
									$field['settings']->xml, 'view="', '"'
								), CFactory::_('Placeholder')->active
							);
							// This is to link other view category
							if (StringHelper::check($otherName)
								&& StringHelper::check(
									$otherViews
								)
								&& StringHelper::check(
									$otherView
								))
							{
								// set other category details
								$this->catOtherName[$listViewName] = array(
									'name'  => FieldHelper::safe(
										$otherName
									),
									'views' => StringHelper::safe(
										$otherViews
									),
									'view'  => StringHelper::safe(
										$otherView
									)
								);
							}
						}
					}
					// if tag is set then enable all tag options for this view (only one per view)
					elseif ($type_name === 'tag')
					{
						$name = 'tags';
					}
					// if the field is set as alias it must be called alias
					elseif (isset($field['alias']) && $field['alias'])
					{
						$name = 'alias';
					}
					else
					{
						// get value from xml
						$xml = FieldHelper::safe(
							CFactory::_('Placeholder')->update(
								GetHelper::between(
									$field['settings']->xml, 'name="', '"'
								), CFactory::_('Placeholder')->active
							)
						);
						// check if a value was found
						if (StringHelper::check($xml))
						{
							$name = $xml;
						}
					}
					// exit foreach loop
					break;
				}
			}
		}
		// return the value unique
		if (StringHelper::check($listViewName)
			&& isset($field['hash']))
		{
			$this->uniqueFieldNames[$listViewName . $amicably . $field['hash']]
				= $this->uniqueName($name, $listViewName . $amicably);

			// now return the unique name
			return $this->uniqueFieldNames[$listViewName . $amicably
			. $field['hash']];
		}

		// fall back to global
		return $name;
	}

	/**
	 * Count how many times the same field is used per view
	 *
	 * @param   string  $name  The name of the field
	 * @param   string  $view  The name of the view
	 *
	 * @return  void
	 *
	 */
	protected function setUniqueNameCounter($name, $view)
	{
		if (!isset($this->uniqueNames[$view]))
		{
			$this->uniqueNames[$view]            = array();
			$this->uniqueNames[$view]['counter'] = array();
			$this->uniqueNames[$view]['names']   = array();
		}
		if (!isset($this->uniqueNames[$view]['counter'][$name]))
		{
			$this->uniqueNames[$view]['counter'][$name] = 1;

			return;
		}
		// count how many times the field is used
		$this->uniqueNames[$view]['counter'][$name]++;

		return;
	}

	/**
	 * Naming each field with an unique name
	 *
	 * @param   string  $name  The name of the field
	 * @param   string  $view  The name of the view
	 *
	 * @return  string   the name
	 *
	 */
	protected function uniqueName($name, $view)
	{
		// only increment if the field name is used multiple times
		if (isset($this->uniqueNames[$view]['counter'][$name])
			&& $this->uniqueNames[$view]['counter'][$name] > 1)
		{
			$counter = 1;
			// set the unique name
			$uniqueName = FieldHelper::safe(
				$name . '_' . $counter
			);
			while (isset($this->uniqueNames[$view]['names'][$uniqueName]))
			{
				// increment the number
				$counter++;
				// try again
				$uniqueName = FieldHelper::safe(
					$name . '_' . $counter
				);
			}
			// set the new name number
			$this->uniqueNames[$view]['names'][$uniqueName] = $counter;

			// return the unique name
			return $uniqueName;
		}

		return $name;
	}

	/**
	 * Set get Data
	 *
	 * @param   array   $ids        The ids of the dynamic get
	 * @param   string  $view_code  The view code name
	 * @param   string  $context    The context for events
	 *
	 * @return  oject the get dynamicGet data
	 *
	 */
	public function setGetData($ids, $view_code, $context)
	{
		if (ArrayHelper::check($ids))
		{
			$ids = implode(',', $ids);
			if (StringHelper::check($ids))
			{
				// Create a new query object.
				$query = $this->db->getQuery(true);
				$query->select('a.*');
				$query->from('#__componentbuilder_dynamic_get AS a');
				$query->where('a.id IN (' . $ids . ')');
				$this->db->setQuery($query);
				$this->db->execute();
				if ($this->db->getNumRows())
				{
					$results       = $this->db->loadObjectList();
					$typeArray     = array(1 => 'LEFT', 2 => 'LEFT OUTER',
					                       3 => 'INNER', 4 => 'RIGHT',
					                       5 => 'RIGHT OUTER');
					$operatorArray = array(1  => '=', 2 => '!=', 3 => '<>',
					                       4  => '>', 5 => '<', 6 => '>=',
					                       7  => '<=', 8 => '!<', 9 => '!>',
					                       10 => 'IN', 11 => 'NOT IN');
					$guiMapper     = array('table' => 'dynamic_get',
					                       'type'  => 'php');
					foreach ($results as $_nr => &$result)
					{
						// Trigger Event: jcb_ce_onBeforeModelDynamicGetData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onBeforeModelDynamicGetData',
							array(&$this->componentContext, &$result, &$result->id, &$view_code, &$context)
						);
						// set GUI mapper id
						$guiMapper['id'] = (int) $result->id;
						// add calculations if set
						if ($result->addcalculation == 1
							&& StringHelper::check(
								$result->php_calculation
							))
						{
							// set GUI mapper field
							$guiMapper['field'] = 'php_calculation';
							$result->php_calculation
							                    = CFactory::_('Customcode.Gui')->set(
								CFactory::_('Customcode')->add(
									base64_decode($result->php_calculation)
								),
								$guiMapper
							);
						}
						// setup the router parse
						if (isset($result->add_php_router_parse)
							&& $result->add_php_router_parse == 1
							&& isset($result->php_router_parse)
							&& StringHelper::check(
								$result->php_router_parse
							))
						{
							// set GUI mapper field
							$guiMapper['field'] = 'php_router_parse';
							$result->php_router_parse
							                    = CFactory::_('Customcode.Gui')->set(
								CFactory::_('Customcode')->add(
									base64_decode($result->php_router_parse)
								),
								$guiMapper
							);
						}
						else
						{
							$result->add_php_router_parse = 0;
						}
						// The array of the php scripts that should be added to the script builder
						$phpSripts = array('php_before_getitem',
							'php_after_getitem',
							'php_before_getitems',
							'php_after_getitems',
							'php_getlistquery');
						// load the php scripts
						foreach ($phpSripts as $script)
						{
							// add php script to the script builder
							if (isset($result->{'add_' . $script})
								&& $result->{'add_' . $script} == 1
								&& isset($result->{$script})
								&& StringHelper::check(
									$result->{$script}
								))
							{
								// move all main gets out to the customscript builder
								if ($result->gettype <= 2)
								{
									// set GUI mapper field
									$guiMapper['field']  = $script;
									$guiMapper['prefix'] = PHP_EOL . PHP_EOL;
									CFactory::_('Customcode.Dispenser')->set(
										$result->{$script},
										CFactory::_('Config')->build_target . '_' . $script,
										$view_code,
										null,
										$guiMapper,
										true,
										true,
										true
									);
									unset($guiMapper['prefix']);
									// remove from local item
									unset($result->{$script});
									unset($result->{'add_' . $script});
								}
								else
								{
									// set GUI mapper field
									$guiMapper['field']  = $script;
									$guiMapper['prefix'] = PHP_EOL;
									// only for custom gets
									$result->{$script}
										= CFactory::_('Customcode.Gui')->set(
										CFactory::_('Customcode')->add(
											base64_decode($result->{$script})
										),
										$guiMapper
									);
									unset($guiMapper['prefix']);
								}
							}
							else
							{
								// remove from local item
								unset($result->{$script});
								unset($result->{'add_' . $script});
							}
						}
						// set the getmethod code name
						$result->key = StringHelper::safe(
							$view_code . ' ' . $result->name . ' ' . $result->id
						);
						// reset buckets
						$result->main_get   = array();
						$result->custom_get = array();
						// should joineds and other weaks be added
						$addDynamicTweaksJoints = true;
						// set source data
						switch ($result->main_source)
						{
							case 1:
								// check if auto sync is set
								if ($result->select_all == 1)
								{
									$result->view_selection = '*';
								}
								// set the view data
								$result->main_get[0]['selection']
									                            = $this->setDataSelection(
									$result->key, $view_code,
									$result->view_selection,
									$result->view_table_main, 'a', null, 'view'
								);
								$result->main_get[0]['as']      = 'a';
								$result->main_get[0]['key']     = $result->key;
								$result->main_get[0]['context'] = $context;
								unset($result->view_selection);
								break;
							case 2:
								// check if auto sync is set
								if ($result->select_all == 1)
								{
									$result->db_selection = '*';
								}
								// set the database data
								$result->main_get[0]['selection']
									                            = $this->setDataSelection(
									$result->key, $view_code,
									$result->db_selection,
									$result->db_table_main, 'a', null, 'db'
								);
								$result->main_get[0]['as']      = 'a';
								$result->main_get[0]['key']     = $result->key;
								$result->main_get[0]['context'] = $context;
								unset($result->db_selection);
								break;
							case 3:
								// set GUI mapper field
								$guiMapper['field'] = 'php_custom_get';
								// get the custom query
								$customQueryString
									= CFactory::_('Customcode.Gui')->set(
									CFactory::_('Customcode')->add(
										base64_decode($result->php_custom_get)
									),
									$guiMapper
								);
								// get the table name
								$_searchQuery
									= GetHelper::between(
									$customQueryString, '$query->from(', ')'
								);
								if (StringHelper::check(
										$_searchQuery
									)
									&& strpos($_searchQuery, '#__') !== false)
								{
									$_queryName
										= GetHelper::between(
										$_searchQuery, '#__', "'"
									);
									if (!StringHelper::check(
										$_queryName
									))
									{
										$_queryName
											= GetHelper::between(
											$_searchQuery, '#__', '"'
										);
									}
								}
								// set to blank if not found
								if (!isset($_queryName)
									|| !StringHelper::check(
										$_queryName
									))
								{
									$_queryName = '';
								}
								// set custom script
								$result->main_get[0]['selection'] = array(
									'select' => $customQueryString,
									'from'   => '', 'table' => '', 'type' => '',
									'name'   => $_queryName);
								$result->main_get[0]['as']        = 'a';
								$result->main_get[0]['key']
								                                  = $result->key;
								$result->main_get[0]['context']   = $context;
								// do not add
								$addDynamicTweaksJoints = false;
								break;
						}
						// only add if main source is not custom
						if ($addDynamicTweaksJoints)
						{
							// set join_view_table details
							$result->join_view_table = json_decode(
								$result->join_view_table, true
							);
							if (ArrayHelper::check(
								$result->join_view_table
							))
							{
								// start the part of a table bucket
								$_part_of_a = array();
								// build relationship
								$_relationship = array_map(
									function ($op) use (&$_part_of_a) {
										$bucket = array();
										// array(on_field_as, on_field)
										$bucket['on_field'] = array_map(
											'trim',
											explode('.', $op['on_field'])
										);
										// array(join_field_as, join_field)
										$bucket['join_field'] = array_map(
											'trim',
											explode('.', $op['join_field'])
										);
										// triget filed that has table a relationship
										if ($op['row_type'] == 1
											&& ($bucket['on_field'][0] === 'a'
												|| isset($_part_of_a[$bucket['on_field'][0]])
												|| isset($_part_of_a[$bucket['join_field'][0]])))
										{
											$_part_of_a[$op['as']] = $op['as'];
										}

										return $bucket;
									}, $result->join_view_table
								);
								// loop joints
								foreach (
									$result->join_view_table as $nr => &$option
								)
								{
									if (StringHelper::check(
										$option['selection']
									))
									{
										// convert the type
										$option['type']
											= $typeArray[$option['type']];
										// convert the operator
										$option['operator']
											= $operatorArray[$option['operator']];
										// get the on field values
										$on_field
											= $_relationship[$nr]['on_field'];
										// get the join field values
										$join_field
											= $_relationship[$nr]['join_field'];
										// set selection
										$option['selection']
											               = $this->setDataSelection(
											$result->key, $view_code,
											$option['selection'],
											$option['view_table'],
											$option['as'], $option['row_type'],
											'view'
										);
										$option['key']     = $result->key;
										$option['context'] = $context;
										// load to the getters
										if ($option['row_type'] == 1)
										{
											$result->main_get[] = $option;
											if ($on_field[0] === 'a'
												|| isset($_part_of_a[$join_field[0]])
												|| isset($_part_of_a[$on_field[0]]))
											{
												$this->siteMainGet[CFactory::_('Config')->build_target][$view_code][$option['as']]
													= $option['as'];
											}
											else
											{
												$this->siteDynamicGet[CFactory::_('Config')->build_target][$view_code][$option['as']][$join_field[1]]
													= $on_field[0];
											}
										}
										elseif ($option['row_type'] == 2)
										{
											$result->custom_get[] = $option;
											if ($on_field[0] != 'a')
											{
												$this->siteDynamicGet[CFactory::_('Config')->build_target][$view_code][$option['as']][$join_field[1]]
													= $on_field[0];
											}
										}
									}
									unset($result->join_view_table[$nr]);
								}
							}
							unset($result->join_view_table);
							// set join_db_table details
							$result->join_db_table = json_decode(
								$result->join_db_table, true
							);
							if (ArrayHelper::check(
								$result->join_db_table
							))
							{
								// start the part of a table bucket
								$_part_of_a = array();
								// build relationship
								$_relationship = array_map(
									function ($op) use (&$_part_of_a) {
										$bucket = array();
										// array(on_field_as, on_field)
										$bucket['on_field'] = array_map(
											'trim',
											explode('.', $op['on_field'])
										);
										// array(join_field_as, join_field)
										$bucket['join_field'] = array_map(
											'trim',
											explode('.', $op['join_field'])
										);
										// triget filed that has table a relationship
										if ($op['row_type'] == 1
											&& ($bucket['on_field'][0] === 'a'
												|| isset($_part_of_a[$bucket['on_field'][0]])
												|| isset($_part_of_a[$bucket['join_field'][0]])))
										{
											$_part_of_a[$op['as']] = $op['as'];
										}

										return $bucket;
									}, $result->join_db_table
								);

								// loop joints
								foreach (
									$result->join_db_table as $nr => &$option1
								)
								{
									if (StringHelper::check(
										$option1['selection']
									))
									{
										// convert the type
										$option1['type']
											= $typeArray[$option1['type']];
										// convert the operator
										$option1['operator']
											= $operatorArray[$option1['operator']];
										// get the on field values
										$on_field
											= $_relationship[$nr]['on_field'];
										// get the join field values
										$join_field
											= $_relationship[$nr]['join_field'];
										// set selection
										$option1['selection']
											                = $this->setDataSelection(
											$result->key, $view_code,
											$option1['selection'],
											$option1['db_table'],
											$option1['as'],
											$option1['row_type'], 'db'
										);
										$option1['key']     = $result->key;
										$option1['context'] = $context;
										// load to the getters
										if ($option1['row_type'] == 1)
										{
											$result->main_get[] = $option1;
											if ($on_field[0] === 'a'
												|| isset($_part_of_a[$join_field[0]])
												|| isset($_part_of_a[$on_field[0]]))
											{
												$this->siteMainGet[CFactory::_('Config')->build_target][$view_code][$option1['as']]
													= $option1['as'];
											}
											else
											{
												$this->siteDynamicGet[CFactory::_('Config')->build_target][$view_code][$option1['as']][$join_field[1]]
													= $on_field[0];
											}
										}
										elseif ($option1['row_type'] == 2)
										{
											$result->custom_get[] = $option1;
											if ($on_field[0] != 'a')
											{
												$this->siteDynamicGet[CFactory::_('Config')->build_target][$view_code][$option1['as']][$join_field[1]]
													= $on_field[0];
											}
										}
									}
									unset($result->join_db_table[$nr]);
								}
							}
							unset($result->join_db_table);
							// set filter details
							$result->filter = json_decode(
								$result->filter, true
							);
							if (ArrayHelper::check(
								$result->filter
							))
							{
								foreach ($result->filter as $nr => &$option2)
								{
									if (isset($option2['operator']))
									{
										$option2['operator']
											            = $operatorArray[$option2['operator']];
										$option2['state_key']
											            = CFactory::_('Placeholder')->update(
											CFactory::_('Customcode')->add(
												$option2['state_key']
											), CFactory::_('Placeholder')->active
										);
										$option2['key'] = $result->key;
									}
									else
									{
										unset($result->filter[$nr]);
									}
								}
							}
							// set where details
							$result->where = json_decode($result->where, true);
							if (ArrayHelper::check(
								$result->where
							))
							{
								foreach ($result->where as $nr => &$option3)
								{
									if (isset($option3['operator']))
									{
										$option3['operator']
											= $operatorArray[$option3['operator']];
									}
									else
									{
										unset($result->where[$nr]);
									}
								}
							}
							else
							{
								unset($result->where);
							}
							// set order details
							$result->order = json_decode($result->order, true);
							if (!ArrayHelper::check(
								$result->order
							))
							{
								unset($result->order);
							}
							// set grouping
							$result->group = json_decode($result->group, true);
							if (!ArrayHelper::check(
								$result->group
							))
							{
								unset($result->group);
							}
							// set global details
							$result->global = json_decode(
								$result->global, true
							);
							if (!ArrayHelper::check(
								$result->global
							))
							{
								unset($result->global);
							}
						}
						else
						{
							// when we have a custom query script we do not add the dynamic options
							unset($result->join_view_table);
							unset($result->join_db_table);
							unset($result->filter);
							unset($result->where);
							unset($result->order);
							unset($result->group);
							unset($result->global);
						}
						// load the events if any is set
						if ($result->gettype == 1
							&& JsonHelper::check(
								$result->plugin_events
							))
						{
							$result->plugin_events = json_decode(
								$result->plugin_events, true
							);
						}
						else
						{
							$result->plugin_events = '';
						}
						// Trigger Event: jcb_ce_onAfterModelDynamicGetData
						CFactory::_J('Event')->trigger(
							'jcb_ce_onAfterModelDynamicGetData',
							array(&$this->componentContext, &$result, &$result->id, &$view_code, &$context)
						);
					}

					return $results;
				}
			}
		}

		return false;
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
	 *
	 */
	public function setSqlTweaking($settings)
	{
		if (ArrayHelper::check($settings))
		{
			foreach ($settings as $setting)
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
							$id_array = (array) array_map(
								'trim', explode(',', $ids)
							);
						}
						else
						{
							$id_array[] = trim($ids);
						}
						$id_array_new = array();
						// check for ranges
						foreach ($id_array as $key => $id)
						{
							if (strpos($id, '=>') !== false)
							{
								$id_range = (array) array_map(
									'trim', explode('=>', $id)
								);
								unset($id_array[$key]);
								// build range
								if (count((array) $id_range) == 2)
								{
									$range        = range(
										$id_range[0], $id_range[1]
									);
									$id_array_new = array_merge(
										$id_array_new, $range
									);
								}
							}
						}
						if (ArrayHelper::check($id_array_new))
						{
							$id_array = array_merge($id_array_new, $id_array);
						}
						// final fixing to array
						if (ArrayHelper::check($id_array))
						{
							// uniqe
							$id_array = array_unique($id_array, SORT_NUMERIC);
							// sort
							sort($id_array, SORT_NUMERIC);
							// now set it to global
							$this->sqlTweak[(int) $setting['adminview']]['where']
								= implode(',', $id_array);
						}
					}
				}
				else
				{
					// remove all sql dump options
					$this->sqlTweak[(int) $setting['adminview']]['remove']
						= true;
				}
			}
		}
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
	 *
	 */
	protected function setUpdateSQL($old, $new, $type, $key = null,
	                                $ignore = null
	)
	{
		// check if there were new items added
		if (ArrayHelper::check($new)
			&& ArrayHelper::check($old))
		{
			// check if this is old repeatable field
			if (isset($new[$type]))
			{
				foreach ($new[$type] as $item)
				{
					$newItem = true;
					// check if this is an id to ignore
					if (ArrayHelper::check($ignore)
						&& in_array(
							$item, $ignore
						))
					{
						// don't add ignored ids
						$newItem = false;
					}
					// check if this is old repeatable field
					elseif (isset($old[$type])
						&& ArrayHelper::check($old[$type]))
					{
						if (!in_array($item, $old[$type]))
						{
							// we have a new item, lets add to SQL
							$this->setAddSQL($type, $item, $key);
						}
						// add only once
						$newItem = false;
					}
					elseif (!isset($old[$type]))
					{
						// we have new values
						foreach ($old as $oldItem)
						{
							if (isset($oldItem[$type]))
							{
								if ($oldItem[$type] == $item[$type])
								{
									$newItem = false;
									break;
								}
							}
							else
							{
								$newItem = false;
								break;
							}
						}
					}
					else
					{
						$newItem = false;
					}
					// add if new
					if ($newItem)
					{
						// we have a new item, lets add to SQL
						$this->setAddSQL($type, $item[$type], $key);
					}
				}
			}
			else
			{
				foreach ($new as $item)
				{
					if (isset($item[$type]))
					{
						// search to see if this is a new value
						$newItem = true;
						// check if this is an id to ignore
						if (ArrayHelper::check($ignore)
							&& in_array($item[$type], $ignore))
						{
							// don't add ignored ids
							$newItem = false;
						}
						// check if this is old repeatable field
						elseif (isset($old[$type])
							&& ArrayHelper::check($old[$type]))
						{
							if (in_array($item[$type], $old[$type]))
							{
								$newItem = false;
							}
						}
						elseif (!isset($old[$type]))
						{
							// we have new values
							foreach ($old as $oldItem)
							{
								if (isset($oldItem[$type]))
								{
									if ($oldItem[$type] == $item[$type])
									{
										$newItem = false;
										break;
									}
								}
								else
								{
									$newItem = false;
									break;
								}
							}
						}
						else
						{
							$newItem = false;
						}
						// add if new
						if ($newItem)
						{
							// we have a new item, lets add to SQL
							$this->setAddSQL($type, $item[$type], $key);
						}
					}
				}
			}
		}
		elseif ($key
			&& ((StringHelper::check($new)
					&& StringHelper::check($old))
				|| (is_numeric($new) && is_numeric($old)))
			&& $new !== $old)
		{
			// the string changed, lets add to SQL update
			if (!isset($this->updateSQL[$type])
				|| !ArrayHelper::check($this->updateSQL[$type]))
			{
				$this->updateSQL[$type] = array();
			}
			// set at key
			$this->updateSQL[$type][$key] = array('old' => $old, 'new' => $new);
		}
	}

	/**
	 * Set the add sql
	 *
	 * @param   string  $type  The type of values
	 * @param   int     $item  The item id to add
	 * @param   int     $key   The id/key where values changed
	 *
	 * @return void
	 */
	protected function setAddSQL($type, $item, $key)
	{
		// we have a new item, lets add to SQL
		if (!isset($this->addSQL[$type])
			|| !ArrayHelper::check(
				$this->addSQL[$type]
			))
		{
			$this->addSQL[$type] = array();
		}
		// add key if found
		if ($key)
		{
			if (!isset($this->addSQL[$type][$key])
				|| !ArrayHelper::check(
					$this->addSQL[$type][$key]
				))
			{
				$this->addSQL[$type][$key] = array();
			}
			$this->addSQL[$type][$key][] = (int) $item;
		}
		else
		{
			// convert adminview id to name
			if ('adminview' === $type)
			{
				$this->addSQL[$type][] = StringHelper::safe(
					$this->getAdminViewData($item)->name_single
				);
			}
			else
			{
				$this->addSQL[$type][] = (int) $item;
			}
		}
	}

	/**
	 * Get Item History values
	 *
	 * @param   string  $type  The type of item
	 * @param   int     $id    The item ID
	 *
	 * @return  oject    The history
	 *
	 */
	protected function getHistoryWatch($type, $id)
	{
		// quick class object to store old history object
		$this->tmpHistory = null;
		// Create a new query object.
		$query = $this->db->getQuery(true);

		$query->select('h.*');
		$query->from('#__ucm_history AS h');
		$query->where(
			$this->db->quoteName('h.ucm_item_id') . ' = ' . (int) $id
		);
		// Join over the content type for the type id
		$query->join(
			'LEFT', '#__content_types AS ct ON ct.type_id = h.ucm_type_id'
		);
		$query->where(
			'ct.type_alias = ' . $this->db->quote(
				'com_componentbuilder.' . $type
			)
		);
		$query->order('h.save_date DESC');
		$this->db->setQuery($query, 0, 1);
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			// new version of this item found
			// so we need to mark it as the last compiled version
			$newActive = $this->db->loadObject();
			// set the new version watch
			$this->setHistoryWatch($newActive, 1);
		}
		// Get last compiled verion
		$query = $this->db->getQuery(true);

		$query->select('h.*');
		$query->from('#__ucm_history AS h');
		$query->where(
			$this->db->quoteName('h.ucm_item_id') . ' = ' . (int) $id
		);
		$query->where('h.keep_forever = 1');
		$query->where('h.version_note LIKE ' . $this->db->quote('%component%'));
		// make sure it does not return the active version
		if (isset($newActive) && isset($newActive->version_id))
		{
			$query->where('h.version_id != ' . (int) $newActive->version_id);
		}
		// Join over the content type for the type id
		$query->join(
			'LEFT', '#__content_types AS ct ON ct.type_id = h.ucm_type_id'
		);
		$query->where(
			'ct.type_alias = ' . $this->db->quote(
				'com_componentbuilder.' . $type
			)
		);
		$query->order('h.save_date DESC');
		$this->db->setQuery($query);
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			// the old active version was found
			// so we may need to do an SQL update
			// and unmark the old compiled version
			$oldActives = $this->db->loadObjectList();
			foreach ($oldActives as $oldActive)
			{
				// remove old version watch
				$this->setHistoryWatch($oldActive, 0);
			}
		}

		// return the last used history record or null.
		return $this->tmpHistory;
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
	 *
	 */
	protected function setHistoryWatch($object, $action)
	{
		// check the note
		if (JsonHelper::check($object->version_note))
		{
			$version_note = json_decode($object->version_note, true);
		}
		else
		{
			$version_note = array('component' => array());
		}
		// set watch
		switch ($action)
		{
			case 0:
				// remove watch
				if (isset($version_note['component'])
					&& ($key = array_search(
						CFactory::_('Config')->component_id, $version_note['component']
					)) !== false)
				{
					// last version that was used to build/compile
					$this->tmpHistory = json_decode($object->version_data);
					// remove it from this component
					unset($version_note['component'][$key]);
				}
				else
				{
					// since it was not found, no need to update anything
					return true;
				}
				break;
			case 1:
				// add watch
				if (!in_array(CFactory::_('Config')->component_id, $version_note['component']))
				{
					$version_note['component'][] = CFactory::_('Config')->component_id;
				}
				else
				{
					// since it is there already, no need to update anything
					return true;
				}
				break;
		}
		// check if we need to still keep this locked
		if (isset($version_note['component'])
			&& ArrayHelper::check($version_note['component']))
		{
			// insure component ids are only added once per item
			$version_note['component'] = array_unique(
				$version_note['component']
			);
			// we may change this, little risky (but since JCB does not have history notes it should be okay for now)
			$object->version_note = json_encode($version_note);
			$object->keep_forever = '1';
		}
		else
		{
			$object->version_note = '';
			$object->keep_forever = '0';
		}

		// run the update
		return $this->db->updateObject('#__ucm_history', $object, 'version_id');
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
	 *
	 */
	public function setTemplateAndLayoutData($default, $view, $found = false,
	                                         $templates = array(), $layouts = array()
	)
	{
		// to check inside the templates
		$again = array();
		// check if template keys were passed
		if (!ArrayHelper::check($templates))
		{
			// set the Template data
			$temp1 = GetHelper::allBetween(
				$default, "\$this->loadTemplate('", "')"
			);
			$temp2 = GetHelper::allBetween(
				$default, '$this->loadTemplate("', '")'
			);
			if (ArrayHelper::check($temp1)
				&& ArrayHelper::check($temp2))
			{
				$templates = array_merge($temp1, $temp2);
			}
			else
			{
				if (ArrayHelper::check($temp1))
				{
					$templates = $temp1;
				}
				elseif (ArrayHelper::check($temp2))
				{
					$templates = $temp2;
				}
			}
		}
		// check if we found templates
		if (ArrayHelper::check($templates, true))
		{
			foreach ($templates as $template)
			{
				if (!isset($this->templateData[CFactory::_('Config')->build_target][$view])
					|| !array_key_exists(
						$template, $this->templateData[CFactory::_('Config')->build_target][$view]
					))
				{
					$data = $this->getDataWithAlias(
						$template, 'template', $view
					);
					if (ArrayHelper::check($data))
					{
						// load it to the template data array
						$this->templateData[CFactory::_('Config')->build_target][$view][$template]
							= $data;
						// call self to get child data
						$again[] = array($data['html'], $view);
						$again[] = array($data['php_view'], $view);
					}
				}
				// check if we have the template set (and nothing yet found)
				if (!$found
					&& isset($this->templateData[CFactory::_('Config')->build_target][$view][$template]))
				{
					// something was found
					$found = true;
				}
			}
		}
		// check if layout keys were passed
		if (!ArrayHelper::check($layouts))
		{
			// set the Layout data
			$lay1 = GetHelper::allBetween(
				$default, "JLayoutHelper::render('", "',"
			);
			$lay2 = GetHelper::allBetween(
				$default, 'JLayoutHelper::render("', '",'
			);
			if (ArrayHelper::check($lay1)
				&& ArrayHelper::check($lay2))
			{
				$layouts = array_merge($lay1, $lay2);
			}
			else
			{
				if (ArrayHelper::check($lay1))
				{
					$layouts = $lay1;
				}
				elseif (ArrayHelper::check($lay2))
				{
					$layouts = $lay2;
				}
			}
		}
		// check if we found layouts
		if (ArrayHelper::check($layouts, true))
		{
			// get the other target if both
			$_target = null;
			if (CFactory::_('Config')->lang_target === 'both')
			{
				$_target = (CFactory::_('Config')->build_target === 'admin') ? 'site' : 'admin';
			}
			foreach ($layouts as $layout)
			{
				if (!isset($this->layoutData[CFactory::_('Config')->build_target])
					|| !ArrayHelper::check(
						$this->layoutData[CFactory::_('Config')->build_target]
					)
					|| !array_key_exists(
						$layout, $this->layoutData[CFactory::_('Config')->build_target]
					))
				{
					$data = $this->getDataWithAlias($layout, 'layout', $view);
					if (ArrayHelper::check($data))
					{
						// load it to the layout data array
						$this->layoutData[CFactory::_('Config')->build_target][$layout] = $data;
						// check if other target is set
						if (CFactory::_('Config')->lang_target === 'both' && $_target)
						{
							$this->layoutData[$_target][$layout] = $data;
						}
						// call self to get child data
						$again[] = array($data['html'], $view);
						$again[] = array($data['php_view'], $view);
					}
				}
				// check if we have the layout set (and nothing yet found)
				if (!$found && isset($this->layoutData[CFactory::_('Config')->build_target][$layout]))
				{
					// something was found
					$found = true;
				}
			}
		}
		// check again
		if (ArrayHelper::check($again))
		{
			foreach ($again as $go)
			{
				$found = $this->setTemplateAndLayoutData(
					$go[0], $go[1], $found
				);
			}
		}

		// return the proof that something was found
		return $found;
	}

	/**
	 * Get Data With Alias
	 *
	 * @param   string  $n_ame  The alias name
	 * @param   string  $table  The table where to find the alias
	 * @param   string  $view   The view code name
	 *
	 * @return  array The data found with the alias
	 *
	 */
	protected function getDataWithAlias($n_ame, $table, $view)
	{
		// if not set, get all keys in table and set by ID
		$this->setDataWithAliasKeys($table);
		// now check if key is found
		$name = preg_replace("/[^A-Za-z]/", '', $n_ame);
		if (isset($this->dataWithAliasKeys[$table][$name]))
		{
			$ID = $this->dataWithAliasKeys[$table][$name];
		}
		elseif (isset($this->dataWithAliasKeys[$table][$n_ame]))
		{
			$ID = $this->dataWithAliasKeys[$table][$n_ame];
		}
		else
		{
			return false;
		}
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_' . $table . ' AS a');
		$query->where(
			$this->db->quoteName('a.id') . ' = ' . (int) $ID
		);
		// get the other target if both
		$_targets = array(CFactory::_('Config')->build_target);
		if (CFactory::_('Config')->lang_target === 'both')
		{
			$_targets = array('site', 'admin');
		}
		$this->db->setQuery($query);
		// get the row
		$row = $this->db->loadObject();
		// we load this layout
		$php_view = '';
		if ($row->add_php_view == 1
			&& StringHelper::check($row->php_view))
		{
			$php_view = CFactory::_('Customcode.Gui')->set(
				CFactory::_('Customcode')->add(base64_decode($row->php_view)),
				array(
					'table' => $table,
					'field' => 'php_view',
					'id'    => (int) $row->id,
					'type'  => 'php')
			);
		}
		$contnent = CFactory::_('Customcode.Gui')->set(
			CFactory::_('Customcode')->add(base64_decode($row->{$table})),
			array(
				'table' => $table,
				'field' => $table,
				'id'    => (int) $row->id,
				'type'  => 'html')
		);
		// load all targets
		foreach ($_targets as $_target)
		{
			// load the library
			if (!isset($this->libManager[$_target]))
			{
				$this->libManager[$_target] = array();
			}
			if (!isset($this->libManager[$_target][$view]))
			{
				$this->libManager[$_target][$view] = array();
			}
			// make sure json become array
			if (JsonHelper::check($row->libraries))
			{
				$row->libraries = json_decode($row->libraries, true);
			}
			// if we have an array add it
			if (ArrayHelper::check($row->libraries))
			{
				foreach ($row->libraries as $library)
				{
					if (!isset($this->libManager[$_target][$view][$library]))
					{
						if ($this->getMediaLibrary((int) $library))
						{
							$this->libManager[$_target][$view][(int) $library]
								= true;
						}
					}
				}
			}
			elseif (is_numeric($row->libraries)
				&& !isset($this->libManager[$_target][$view][(int) $row->libraries]))
			{
				if ($this->getMediaLibrary((int) $row->libraries))
				{
					$this->libManager[$_target][$view][(int) $row->libraries]
						= true;
				}
			}
			// set footable to views and turn it on
			if (!isset($this->footableScripts[$_target][$view])
				|| !$this->footableScripts[$_target][$view])
			{
				$foundFoo = $this->getFootableScripts($contnent);
				if ($foundFoo)
				{
					$this->footableScripts[$_target][$view] = true;
				}
				if ($foundFoo && !$this->footable)
				{
					$this->footable = true;
				}
			}
			// set google charts to views and turn it on
			if (!isset($this->googleChart[$_target][$view])
				|| !$this->googleChart[$_target][$view])
			{
				$foundA = $this->getGoogleChart($php_view);
				$foundB = $this->getGoogleChart($contnent);
				if ($foundA || $foundB)
				{
					$this->googleChart[$_target][$view] = true;
				}
				if ($foundA || $foundB && !$this->googlechart)
				{
					$this->googlechart = true;
				}
			}
			// check for get module
			if (!isset($this->getModule[$_target][$view])
				|| !$this->getModule[$_target][$view])
			{
				$foundA = $this->getGetModule($php_view);
				$foundB = $this->getGetModule($contnent);
				if ($foundA || $foundB)
				{
					$this->getModule[$_target][$view] = true;
				}
			}
		}
		// load UIKIT if needed
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			if (!isset($this->uikitComp[$view]))
			{
				$this->uikitComp[$view] = array();
			}
			// set uikit to views
			$this->uikitComp[$view]
				= ComponentbuilderHelper::getUikitComp(
				$contnent, $this->uikitComp[$view]
			);
		}

		return array(
			'id'       => $row->id,
			'html'     => CFactory::_('Customcode.Gui')->set(
				$contnent,
				array(
					'table' => $table,
					'field' => $table,
					'id'    => $row->id,
					'type'  => 'html'
				)
			),
			'php_view' => CFactory::_('Customcode.Gui')->set(
				$php_view,
				array(
					'table' => $table,
					'field' => 'php_view',
					'id'    => $row->id,
					'type'  => 'php'
				)
			)
		);
	}

	/**
	 * set Data With Alias Keys
	 *
	 * @param   string  $table  The table where to find the alias
	 *
	 * @return  void
	 *
	 */
	protected function setDataWithAliasKeys($table)
	{
		// now check if key is found
		if (!isset($this->dataWithAliasKeys[$table]))
		{
			// load this table keys
			$this->dataWithAliasKeys[$table] = array();
			// Create a new query object.
			$query = $this->db->getQuery(true);
			$query->select(array('a.id', 'a.alias'));
			$query->from('#__componentbuilder_' . $table . ' AS a');
			$this->db->setQuery($query);
			$rows = $this->db->loadObjectList();
			// check if we have an array
			if (ArrayHelper::check($rows))
			{
				foreach ($rows as $row)
				{
					// build the key
					$k_ey = StringHelper::safe($row->alias);
					$key  = preg_replace("/[^A-Za-z]/", '', $k_ey);
					// set the keys
					$this->dataWithAliasKeys[$table][$row->alias] = $row->id;
					$this->dataWithAliasKeys[$table][$k_ey]       = $row->id;
					$this->dataWithAliasKeys[$table][$key]        = $row->id;
				}
			}
		}
	}

	/**
	 * Get Media Library Data and store globally
	 *
	 * @param   string  $id  the library id
	 *
	 * @return  bool    true on success
	 *
	 */
	protected function getMediaLibrary($id)
	{
		// check if the lib has already been set
		if (!isset($this->libraries[$id]))
		{
			// make sure we should continue and that the lib is not already being loaded
			switch ($id)
			{
				case 1: // No Library
					return false;
					break;
				case 3: // Uikit v3
					if (2 == $this->uikit || 3 == $this->uikit)
					{
						// already being loaded
						$this->libraries[$id] = false;
					}
					break;
				case 4: // Uikit v2
					if (2 == $this->uikit || 1 == $this->uikit)
					{
						// already being loaded
						$this->libraries[$id] = false;
					}
					break;
				case 5: // FooTable v2
					if (!isset($this->footableVersion)
						|| 2 == $this->footableVersion)
					{
						// already being loaded
						$this->libraries[$id] = false;
					}
					break;
				case 6: // FooTable v3
					if (3 == $this->footableVersion)
					{
						// already being loaded
						$this->libraries[$id] = false;
					}
					break;
			}
		}
		// check if the lib has already been set
		if (!isset($this->libraries[$id]))
		{
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'a.id',
						'a.name',
						'a.how',
						'a.type',
						'a.addconditions',
						'b.addconfig',
						'c.addfiles',
						'c.addfolders',
						'c.addfilesfullpath',
						'c.addfoldersfullpath',
						'c.addurls',
						'a.php_setdocument'
					), array(
						'id',
						'name',
						'how',
						'type',
						'addconditions',
						'addconfig',
						'addfiles',
						'addfolders',
						'addfilesfullpath',
						'addfoldersfullpath',
						'addurls',
						'php_setdocument'
					)
				)
			);
			// from these tables
			$query->from('#__componentbuilder_library AS a');
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_library_config', 'b')
				. ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('b.library') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_library_files_folders_urls', 'c'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('c.library') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$query->where($this->db->quoteName('a.target') . ' = 1');

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects
			$library = $this->db->loadObject();

			// check if this lib uses build-in behaviour
			if ($library->how == 4)
			{
				// fall back on build-in features
				$buildin = array(3 => array('uikit' => 3),
				                 4 => array('uikit' => 1),
				                 5 => array('footableVersion' => 2,
				                            'footable'        => true),
				                 6 => array('footableVersion' => 3,
				                            'footable'        => true));
				if (isset($buildin[$library->id])
					&& ArrayHelper::check(
						$buildin[$library->id]
					))
				{
					// set the lib switch
					foreach ($buildin[$library->id] as $lib => $val)
					{
						$this->{$lib} = $val;
					}
					// since we are falling back on build-in feature
					$library->how = 0;
				}
				else
				{
					// since we did not find build in behaviour we must load always.
					$library->how = 1;
				}
			}
			// check if this lib has dynamic behaviour
			if ($library->how > 0)
			{
				// set the add targets
				$addArray = array('files'           => 'files',
				                  'folders'         => 'folders',
				                  'urls'            => 'urls',
				                  'filesfullpath'   => 'files',
				                  'foldersfullpath' => 'folders');
				foreach ($addArray as $addTarget => $targetHere)
				{
					// set the add target data
					$library->{'add' . $addTarget} = (isset(
							$library->{'add' . $addTarget}
						)
						&& JsonHelper::check(
							$library->{'add' . $addTarget}
						)) ? json_decode($library->{'add' . $addTarget}, true)
						: null;
					if (ArrayHelper::check(
						$library->{'add' . $addTarget}
					))
					{
						if (isset($library->{$targetHere})
							&& ArrayHelper::check(
								$library->{$targetHere}
							))
						{
							foreach ($library->{'add' . $addTarget} as $taget)
							{
								$library->{$targetHere}[] = $taget;
							}
						}
						else
						{
							$library->{$targetHere} = array_values(
								$library->{'add' . $addTarget}
							);
						}
					}
					unset($library->{'add' . $addTarget});
				}
				// add config fields only if needed
				if ($library->how > 1)
				{
					// set the config data
					$library->addconfig = (isset($library->addconfig)
						&& JsonHelper::check(
							$library->addconfig
						)) ? json_decode($library->addconfig, true) : null;
					if (ArrayHelper::check($library->addconfig))
					{
						$library->config = array_map(
							function ($array) {
								$array['alias']    = 0;
								$array['title']    = 0;
								$array['settings'] = $this->getFieldData(
									$array['field']
								);

								return $array;
							}, array_values($library->addconfig)
						);
					}
				}
				// if this lib is controlled by custom script
				if (3 == $library->how)
				{
					// set Needed PHP
					if (isset($library->php_setdocument)
						&& StringHelper::check(
							$library->php_setdocument
						))
					{
						$library->document = CFactory::_('Customcode.Gui')->set(
							CFactory::_('Customcode')->add(
								base64_decode($library->php_setdocument)
							),
							array(
								'table' => 'library',
								'field' => 'php_setdocument',
								'id'    => (int) $id,
								'type'  => 'php')
						);
					}
				}
				// if this lib is controlled by conditions
				elseif (2 == $library->how)
				{
					// set the addconditions data
					$library->addconditions = (isset($library->addconditions)
						&& JsonHelper::check(
							$library->addconditions
						)) ? json_decode($library->addconditions, true) : null;
					if (ArrayHelper::check(
						$library->addconditions
					))
					{
						$library->conditions = array_values(
							$library->addconditions
						);
					}
				}
				unset($library->php_setdocument);
				unset($library->addconditions);
				unset($library->addconfig);
				// load to global lib
				$this->libraries[$id] = $library;
			}
			else
			{
				$this->libraries[$id] = false;
			}
		}
		// if set return
		if (isset($this->libraries[$id]))
		{
			return $this->libraries[$id];
		}

		return false;
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
	 *
	 */
	public function setDataSelection($method_key, $view_code, $string, $asset,
	                                 $as, $row_type, $type
	)
	{
		if (StringHelper::check($string))
		{
			if ('db' === $type)
			{
				$table     = '#__' . $asset;
				$queryName = $asset;
				$view      = '';
			}
			elseif ('view' === $type)
			{
				$view      = $this->getViewTableName($asset);
				$table     = '#__' . CFactory::_('Config')->component_code_name . '_' . $view;
				$queryName = $view;
			}
			// just get all values from table if * is found
			if ($string === '*' || strpos($string, '*') !== false)
			{
				if ($type == 'view')
				{
					$_string = ComponentbuilderHelper::getViewTableColumns(
						$asset, $as, $row_type
					);
				}
				else
				{
					$_string = ComponentbuilderHelper::getDbTableColumns(
						$asset, $as, $row_type
					);
				}
				// get only selected values
				$lines = explode(PHP_EOL, $_string);
				// make sure to set the string to *
				$string = '*';
			}
			else
			{
				// get only selected values
				$lines = explode(PHP_EOL, $string);
			}
			// only continue if lines are available
			if (ArrayHelper::check($lines))
			{
				$gets = array();
				$keys = array();
				// first load all options
				foreach ($lines as $line)
				{
					if (strpos($line, 'AS') !== false)
					{
						$lineArray = explode("AS", $line);
					}
					elseif (strpos($line, 'as') !== false)
					{
						$lineArray = explode("as", $line);
					}
					else
					{
						$lineArray = array($line, null);
					}
					// set the get and key
					$get = trim($lineArray[0]);
					$key = trim($lineArray[1]);
					// only add the view (we must adapt this)
					if (isset($this->getAsLookup[$method_key][$get])
						&& 'a' != $as
						&& 1 == $row_type
						&& 'view' === $type
						&& strpos('#' . $key, '#' . $view . '_') === false)
					{
						// this is a problem (TODO) since we may want to not add the view name.
						$key = $view . '_' . trim($key);
					}
					// continue only if we have get
					if (StringHelper::check($get))
					{
						$gets[] = $this->db->quote($get);
						if (StringHelper::check($key))
						{
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[]
							                                      = $this->db->quote(
								$key
							);
						}
						else
						{
							$key                                  = str_replace(
								$as . '.', '', $get
							);
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[]
							                                      = $this->db->quote(
								$key
							);
						}
						// make sure we have the view name
						if (StringHelper::check($view))
						{
							// prep the field name
							$field = str_replace($as . '.', '', $get);
							// make sure the array is set
							if (!isset($this->siteFields[$view][$field]))
							{
								$this->siteFields[$view][$field] = array();
							}
							// load to the site fields memory bucket
							$this->siteFields[$view][$field][$method_key . '___'
							. $as]
								= array('site' => $view_code, 'get' => $get,
								        'as'   => $as, 'key' => $key);
						}
					}
				}
				if (ArrayHelper::check($gets)
					&& ArrayHelper::check($keys))
				{
					// single joined selection needs the prefix to the values to avoid conflict in the names
					// so we must still add then AS
					if ($string == '*' && 1 != $row_type)
					{
						$querySelect = "\$query->select('" . $as . ".*');";
					}
					else
					{
						$querySelect = '$query->select($db->quoteName('
							. PHP_EOL . Indent::_(3) . 'array(' . implode(
								',', $gets
							) . '),' . PHP_EOL . Indent::_(3) . 'array('
							. implode(',', $keys) . ')));';
					}
					$queryFrom = '$db->quoteName(' . $this->db->quote($table)
						. ', ' . $this->db->quote($as) . ')';

					// return the select query
					return array('select'      => $querySelect,
					             'from'        => $queryFrom,
					             'name'        => $queryName,
					             'table'       => $table,
					             'type'        => $type,
					             'select_gets' => $gets,
					             'select_keys' => $keys);
				}
			}
		}

		return false;
	}

	/**
	 * Get the View Table Name
	 *
	 * @param   int  $id  The admin view in
	 *
	 * @return  string view code name
	 *
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
	 *
	 */
	public function buildSqlDump($tables, $view, $view_id)
	{
		// first build a query statment to get all the data (insure it must be added - check the tweaking)
		if (ArrayHelper::check($tables)
			&& (!isset($this->sqlTweak[$view_id]['remove'])
				|| !$this->sqlTweak[$view_id]['remove']))
		{
			$counter = 'a';
			// Create a new query object.
			$query = $this->db->getQuery(true);
			// switch to onlu trigger the run of the query if we have tables to query
			$runQuery = false;
			foreach ($tables as $table)
			{
				if (isset($table['table']))
				{
					if ($counter === 'a')
					{
						// the main table fields
						if (strpos($table['sourcemap'], PHP_EOL) !== false)
						{
							$fields = explode(PHP_EOL, $table['sourcemap']);
							if (ArrayHelper::check($fields))
							{
								// reset array buckets
								$sourceArray = array();
								$targetArray = array();
								foreach ($fields as $field)
								{
									if (strpos($field, "=>") !== false)
									{
										list($source, $target) = explode(
											"=>", $field
										);
										$sourceArray[] = $counter . '.' . trim(
												$source
											);
										$targetArray[] = trim($target);
									}
								}
								if (ArrayHelper::check(
										$sourceArray
									)
									&& ArrayHelper::check(
										$targetArray
									))
								{
									// add to query
									$query->select(
										$this->db->quoteName(
											$sourceArray, $targetArray
										)
									);
									$query->from(
										'#__' . $table['table'] . ' AS a'
									);
									$runQuery = true;
								}
								// we may need to filter the selection
								if (isset($this->sqlTweak[$view_id]['where']))
								{
									// add to query the where filter
									$query->where(
										'a.id IN ('
										. $this->sqlTweak[$view_id]['where']
										. ')'
									);
								}
							}
						}
					}
					else
					{
						// the other tables
						if (strpos($table['sourcemap'], PHP_EOL) !== false)
						{
							$fields = explode(PHP_EOL, $table['sourcemap']);
							if (ArrayHelper::check($fields))
							{
								// reset array buckets
								$sourceArray = array();
								$targetArray = array();
								foreach ($fields as $field)
								{
									if (strpos($field, "=>") !== false)
									{
										list($source, $target) = explode(
											"=>", $field
										);
										$sourceArray[] = $counter . '.' . trim(
												$source
											);
										$targetArray[] = trim($target);
									}
									if (strpos($field, "==") !== false)
									{
										list($aKey, $bKey) = explode(
											"==", $field
										);
										// add to query
										$query->join(
											'LEFT', $this->db->quoteName(
												'#__' . $table['table'],
												$counter
											) . ' ON (' . $this->db->quoteName(
												'a.' . trim($aKey)
											) . ' = ' . $this->db->quoteName(
												$counter . '.' . trim($bKey)
											) . ')'
										);
									}
								}
								if (ArrayHelper::check(
										$sourceArray
									)
									&& ArrayHelper::check(
										$targetArray
									))
								{
									// add to query
									$query->select(
										$this->db->quoteName(
											$sourceArray, $targetArray
										)
									);
								}
							}
						}
					}
					$counter++;
				}
				else
				{
					// see where
					// var_dump($view);
					// jexit();
				}
			}
			// check if we should run query
			if ($runQuery)
			{
				// now get the data
				$this->db->setQuery($query);
				$this->db->execute();
				if ($this->db->getNumRows())
				{
					// get the data
					$data = $this->db->loadObjectList();
					// start building the MySql dump
					$dump = "--";
					$dump .= PHP_EOL . "-- Dumping data for table `#__"
						. Placefix::_( "component" ) . "_" . $view
						. "`";
					$dump .= PHP_EOL . "--";
					$dump .= PHP_EOL . PHP_EOL . "INSERT INTO `#__" . Placefix::_("component" ) . "_" . $view . "` (";
					foreach ($data as $line)
					{
						$comaSet = 0;
						foreach ($line as $fieldName => $fieldValue)
						{
							if ($comaSet == 0)
							{
								$dump .= $this->db->quoteName($fieldName);
							}
							else
							{
								$dump .= ", " . $this->db->quoteName(
										$fieldName
									);
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
							$dump .= PHP_EOL . "(";
						}
						else
						{
							$dump .= "," . PHP_EOL . "(";
						}
						$comaSet = 0;
						foreach ($line as $fieldName => $fieldValue)
						{
							if ($comaSet == 0)
							{
								$dump .= $this->mysql_escape($fieldValue);
							}
							else
							{
								$dump .= ", " . $this->mysql_escape(
										$fieldValue
									);
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
		}

		return false;
	}

	/**
	 * Escape the values for a SQL dump
	 *
	 * @param   string  $value  the value to escape
	 *
	 * @return  string on success with escaped string
	 *
	 */
	public function mysql_escape($value)
	{
		// if array then return maped
		if (ArrayHelper::check($value))
		{
			return array_map(__METHOD__, $value);
		}
		// if string make sure it is correctly escaped
		if (StringHelper::check($value) && !is_numeric($value))
		{
			return $this->db->quote($value);
		}
		// if empty value return place holder
		if (empty($value))
		{
			return "''";
		}

		// if not array or string then return number
		return $value;
	}

	/**
	 * Creating an uniqueCode
	 *
	 * @param   string  $code  The planed code
	 *
	 * @return  string The unique code
	 *
	 */
	public function uniqueCode($code)
	{
		if (!isset($this->uniquecodes[CFactory::_('Config')->build_target])
			|| !in_array(
				$code, $this->uniquecodes[CFactory::_('Config')->build_target]
			))
		{
			$this->uniquecodes[CFactory::_('Config')->build_target][] = $code;

			return $code;
		}

		// make sure it is unique
		return $this->uniqueCode($code . $this->uniquekey(1));
	}

	/**
	 * Creating an unique local key
	 *
	 * @param   int  $size  The key size
	 *
	 * @return  string The unique localkey
	 *
	 */
	public function uniquekey($size, $random = false,
	                          $newBag = "vvvvvvvvvvvvvvvvvvv"
	)
	{
		if ($random)
		{
			$bag
				= "abcefghijknopqrstuwxyzABCDDEFGHIJKLLMMNOPQRSTUVVWXYZabcddefghijkllmmnopqrstuvvwxyzABCEFGHIJKNOPQRSTUWXYZ";
		}
		else
		{
			$bag = $newBag;
		}
		$key     = array();
		$bagsize = strlen($bag) - 1;
		for ($i = 0; $i < $size; $i++)
		{
			$get   = rand(0, $bagsize);
			$key[] = $bag[$get];
		}
		$key = implode($key);
		while (in_array($key, $this->uniquekeys))
		{
			$key++;
		}
		$this->uniquekeys[] = $key;

		return $key;
	}

	/**
	 * Check for footable scripts
	 *
	 * @param   string  $content  The content to check
	 *
	 * @return  boolean True if found
	 *
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
	 *
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
	 *
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
	 * @deprecated 3.3 Use CFactory::_('Customcode')->add($string, $debug);
	 */
	public function setDynamicValues($string, $debug = 0)
	{
		return CFactory::_('Customcode')->add($string, $debug);
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
						function ($a) {
							return $this->db->quote($a);
						}, $values
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
		$today         = JFactory::getDate()->toSql();
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
							$this->multiLangString[$string]['translation'], true
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
										= array();
								}
								if (!isset($this->languages[$target][$translations['language']][$area]))
								{
									$this->languages[$target][$translations['language']][$area]
										= array();
								}
								$this->languages[$target][$translations['language']][$area][$placeholder]
									= $translations['translation'];
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
								$this->multiLangString[$string][$target], true
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
							$this->newLangStrings[$target] = array();
						}
						$this->newLangStrings[$target][$counterInsert]
							= array();
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
			$this->newLangStrings[$target] = array();
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
			$this->existingLangStrings = array();
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
						function ($a) {
							return $this->db->quote($a);
						}, $values
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
				$today         = JFactory::getDate()->toSql();
				foreach ($otherStrings as $item)
				{
					if (JsonHelper::check($item[$target]))
					{
						$targets = (array) json_decode($item[$target], true);
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
											$item[$other_target], true
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
										$item['translation'], true
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
		$this->existingLangStrings[$counterUpdate]               = array();
		$this->existingLangStrings[$counterUpdate]['id']         = (int) $id;
		$this->existingLangStrings[$counterUpdate]['conditions'] = array();
		$this->existingLangStrings[$counterUpdate]['conditions'][]
		                                                         = $this->db->quoteName(
				'id'
			) . ' = ' . $this->db->quote($id);
		$this->existingLangStrings[$counterUpdate]['fields']     = array();
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
	 * @deprecated 3.3 Use CFactory::_('Customcode')->load($ids, $setLang, $debug);
	 */
	public function getCustomCode(?array $ids = null, bool $setLang = true, int $debug = 0)
	{
		CFactory::_('Customcode')->load($ids, $setLang, $debug);
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return [];
	}

	/**
	 * set the Joomla modules
	 *
	 * @return  true
	 *
	 */
	public function setJoomlaModule($id, &$component)
	{
		if (isset($this->joomlaModules[$id]))
		{
			return true;
		}
		else
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'f.addfiles',
						'f.addfolders',
						'f.addfilesfullpath',
						'f.addfoldersfullpath',
						'f.addurls',
						'u.version_update',
						'u.id'
					), array(
						'addfiles',
						'addfolders',
						'addfilesfullpath',
						'addfoldersfullpath',
						'addurls',
						'version_update',
						'version_update_id'
					)
				)
			);
			// from these tables
			$query->from('#__componentbuilder_joomla_module AS a');
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_module_updates', 'u'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('u.joomla_module') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_module_files_folders_urls', 'f'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('f.joomla_module') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$query->where($this->db->quoteName('a.published') . ' >= 1');
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// get the module data
				$module = $this->db->loadObject();
				// tweak system to set stuff to the module domain
				$_backup_target     = CFactory::_('Config')->build_target;
				$_backup_lang       = CFactory::_('Config')->lang_target;
				$_backup_langPrefix = CFactory::_('Config')->lang_prefix;
				// set some keys
				$module->target_type = 'M0dU|3';
				$module->key         = $module->id . '_' . $module->target_type;
				// update to point to module
				CFactory::_('Config')->build_target = $module->key;
				CFactory::_('Config')->lang_target = $module->key;
				// set version if not set
				if (empty($module->module_version))
				{
					$module->module_version = '1.0.0';
				}
				// set target client
				if ($module->target == 2)
				{
					$module->target_client = 'administrator';
				}
				else
				{
					// default is site area
					$module->target_client = 'site';
				}
				// set GUI mapper
				$guiMapper = array('table' => 'joomla_module',
				                   'id'    => (int) $id, 'type' => 'php');
				// update the name if it has dynamic values
				$module->name = CFactory::_('Placeholder')->update(
					CFactory::_('Customcode')->add($module->name), CFactory::_('Placeholder')->active
				);
				// set safe class function name
				$module->code_name
					= ClassfunctionHelper::safe(
					$module->name
				);
				// alias of code name
				$module->class_name = $module->code_name;
				// set official name
				$module->official_name = StringHelper::safe(
					$module->name, 'W'
				);
				// set langPrefix
				$this->langPrefix = 'MOD_' . strtoupper($module->code_name);
				CFactory::_('Config')->set('lang_prefix', $this->langPrefix);
				// set lang prefix
				$module->lang_prefix = CFactory::_('Config')->lang_prefix;
				// set module class name
				$module->class_helper_name = 'Mod' . ucfirst($module->code_name)
					. 'Helper';
				$module->class_data_name   = 'Mod' . ucfirst($module->code_name)
					. 'Data';
				// set module install class name
				$module->installer_class_name = 'mod_' . ucfirst(
						$module->code_name
					) . 'InstallerScript';
				// set module folder name
				$module->folder_name = 'mod_' . strtolower($module->code_name);
				// set the zip name
				$module->zip_name = $module->folder_name . '_v' . str_replace(
						'.', '_', $module->module_version
					) . '__J' . CFactory::_('Config')->joomla_version;
				// set module file name
				$module->file_name = $module->folder_name;
				// set module context
				$module->context = $module->file_name . '.' . $module->id;
				// set official_name lang strings
				CFactory::_('Language')->set(
					$module->key, CFactory::_('Config')->lang_prefix, $module->official_name
				);
				// set some placeholder for this module
				CFactory::_('Placeholder')->active[Placefix::_('Module_name')]
					= $module->official_name;
				CFactory::_('Placeholder')->active[Placefix::_('Module')]
					= ucfirst(
					$module->code_name
				);
				CFactory::_('Placeholder')->active[Placefix::_('module')]
					= strtolower(
					$module->code_name
				);
				CFactory::_('Placeholder')->active[Placefix::_('module.version')]
					= $module->module_version;
				CFactory::_('Placeholder')->active[Placefix::_('module_version')]
					= str_replace(
					'.', '_', $module->module_version
				);
				// set description (TODO) add description field to module
				if (!isset($module->description)
					|| !StringHelper::check(
						$module->description
					))
				{
					$module->description = '';
				}
				else
				{
					$module->description = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add($module->description),
						CFactory::_('Placeholder')->active
					);
					CFactory::_('Language')->set(
						$module->key, $module->lang_prefix . '_DESCRIPTION',
						$module->description
					);
					$module->description = '<p>' . $module->description
						. '</p>';
				}
				$module->xml_description = "<h1>" . $module->official_name
					. " (v." . $module->module_version
					. ")</h1> <div style='clear: both;'></div>"
					. $module->description . "<p>Created by <a href='" . trim(
						$component->website
					) . "' target='_blank'>" . trim(
						JFilterOutput::cleanText($component->author)
					) . "</a><br /><small>Development started "
					. JFactory::getDate($module->created)->format("jS F, Y")
					. "</small></p>";
				// set xml description
				CFactory::_('Language')->set(
					$module->key, $module->lang_prefix . '_XML_DESCRIPTION',
					$module->xml_description
				);
				// update the readme if set
				if ($module->addreadme == 1 && !empty($module->readme))
				{
					$module->readme = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(base64_decode($module->readme)),
						CFactory::_('Placeholder')->active
					);
				}
				else
				{
					$module->addreadme = 0;
					unset($module->readme);
				}
				// get the custom_get
				$module->custom_get = (isset($module->custom_get)
					&& JsonHelper::check($module->custom_get))
					? json_decode($module->custom_get, true) : null;
				if (ArrayHelper::check($module->custom_get))
				{
					$module->custom_get = $this->setGetData(
						$module->custom_get, $module->key, $module->key
					);
				}
				else
				{
					$module->custom_get = false;
				}
				// set helper class details
				if ($module->add_class_helper >= 1
					&& StringHelper::check(
						$module->class_helper_code
					))
				{
					if ($module->add_class_helper_header == 1
						&& StringHelper::check(
							$module->class_helper_header
						))
					{
						// set GUI mapper field
						$guiMapper['field'] = 'class_helper_header';
						// base64 Decode code
						$module->class_helper_header = PHP_EOL
							. CFactory::_('Customcode.Gui')->set(
								CFactory::_('Placeholder')->update(
									CFactory::_('Customcode')->add(
										base64_decode(
											$module->class_helper_header
										)
									), CFactory::_('Placeholder')->active
								),
								$guiMapper
							) . PHP_EOL;
					}
					else
					{
						$module->add_class_helper_header = 0;
						$module->class_helper_header     = '';
					}
					// set GUI mapper field
					$guiMapper['field'] = 'class_helper_code';
					// base64 Decode code
					$module->class_helper_code = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($module->class_helper_code)
							), CFactory::_('Placeholder')->active
						),
						$guiMapper
					);
					// set class type
					if ($module->add_class_helper == 2)
					{
						$module->class_helper_type = 'abstract class ';
					}
					else
					{
						$module->class_helper_type = 'class ';
					}
				}
				else
				{
					$module->add_class_helper    = 0;
					$module->class_helper_code   = '';
					$module->class_helper_header = '';
				}
				// base64 Decode mod_code
				if (isset($module->mod_code)
					&& StringHelper::check($module->mod_code))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'mod_code';
					$module->mod_code   = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($module->mod_code)
							), CFactory::_('Placeholder')->active
						),
						$guiMapper
					);
				}
				else
				{
					$module->mod_code = "// get the module class sfx";
					$module->mod_code .= PHP_EOL
						. "\$moduleclass_sfx = htmlspecialchars(\$params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');";
					$module->mod_code .= PHP_EOL . "// load the default Tmpl";
					$module->mod_code .= PHP_EOL
						. "require JModuleHelper::getLayoutPath('mod_"
						. strtolower($module->code_name)
						. "', \$params->get('layout', 'default'));";
				}
				// base64 Decode default header
				if (isset($module->default_header)
					&& StringHelper::check(
						$module->default_header
					))
				{
					// set GUI mapper field
					$guiMapper['field']     = 'default_header';
					$module->default_header = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($module->default_header)
							), CFactory::_('Placeholder')->active
						),
						$guiMapper
					);
				}
				else
				{
					$module->default_header = '';
				}
				// base64 Decode default
				if (isset($module->default)
					&& StringHelper::check($module->default))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'default';
					$guiMapper['type']  = 'html';
					$module->default    = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($module->default)
							), CFactory::_('Placeholder')->active
						),
						$guiMapper
					);
				}
				else
				{
					$module->default = '<h1>No Tmpl set</h1>';
				}
				// start the config array
				$module->config_fields = array();
				// create the form arrays
				$module->form_files      = array();
				$module->fieldsets_label = array();
				$module->fieldsets_paths = array();
				$module->add_rule_path = array();
				$module->add_field_path = array();
				// set global fields rule to default component path
				$module->fields_rules_paths = 1;
				// set the fields data
				$module->fields = (isset($module->fields)
					&& JsonHelper::check($module->fields))
					? json_decode($module->fields, true) : null;
				if (ArrayHelper::check($module->fields))
				{
					// ket global key
					$key            = $module->key;
					$dynamic_fields = array('fieldset'    => 'basic',
					                        'fields_name' => 'params',
					                        'file'        => 'config');
					foreach ($module->fields as $n => &$form)
					{
						if (isset($form['fields'])
							&& ArrayHelper::check(
								$form['fields']
							))
						{
							// make sure the dynamic_field is set to dynamic_value by default
							foreach (
								$dynamic_fields as $dynamic_field =>
								$dynamic_value
							)
							{
								if (!isset($form[$dynamic_field])
									|| !StringHelper::check(
										$form[$dynamic_field]
									))
								{
									$form[$dynamic_field] = $dynamic_value;
								}
								else
								{
									if ('fields_name' === $dynamic_field
										&& strpos($form[$dynamic_field], '.')
										!== false)
									{
										$form[$dynamic_field]
											= $form[$dynamic_field];
									}
									else
									{
										$form[$dynamic_field]
											= StringHelper::safe(
											$form[$dynamic_field]
										);
									}
								}
							}
							// check if field is external form file
							if (!isset($form['module']) || $form['module'] != 1)
							{
								// now build the form key
								$unique = $form['file'] . $form['fields_name']
									. $form['fieldset'];
							}
							else
							{
								// now build the form key
								$unique = $form['fields_name']
									. $form['fieldset'];
							}
							// set global fields rule path switches
							if ($module->fields_rules_paths == 1
								&& isset($form['fields_rules_paths'])
								&& $form['fields_rules_paths'] == 2)
							{
								$module->fields_rules_paths = 2;
							}
							// set where to path is pointing
							$module->fieldsets_paths[$unique]
								= $form['fields_rules_paths'];
							// check for extra rule paths
							if (isset($form['addrulepath'])
								&& ArrayHelper::check($form['addrulepath']))
							{
								foreach ($form['addrulepath'] as $add_rule_path)
								{
									if (StringHelper::check($add_rule_path['path']))
									{
										$module->add_rule_path[$unique] = $add_rule_path['path'];
									}
								}
							}
							// check for extra field paths
							if (isset($form['addfieldpath'])
								&& ArrayHelper::check($form['addfieldpath']))
							{
								foreach ($form['addfieldpath'] as $add_field_path)
								{
									if (StringHelper::check($add_field_path['path']))
									{
										$module->add_field_path[$unique] = $add_field_path['path'];
									}
								}
							}
							// add the label if set to lang
							if (isset($form['label'])
								&& StringHelper::check(
									$form['label']
								))
							{
								$module->fieldsets_label[$unique]
									= CFactory::_('Language')->key($form['label']);
							}
							// build the fields
							$form['fields'] = array_map(
								function ($field) use ($key, $unique) {
									// make sure the alias and title is 0
									$field['alias'] = 0;
									$field['title'] = 0;
									// set the field details
									$this->setFieldDetails(
										$field, $key, $key, $unique
									);
									// update the default if set
									if (StringHelper::check(
											$field['custom_value']
										)
										&& isset($field['settings']))
									{
										if (($old_default
												= GetHelper::between(
												$field['settings']->xml,
												'default="', '"', false
											)) !== false)
										{
											// replace old default
											$field['settings']->xml
												= str_replace(
												'default="' . $old_default
												. '"', 'default="'
												. $field['custom_value'] . '"',
												$field['settings']->xml
											);
										}
										else
										{
											// add the default (hmmm not ideal but okay it should work)
											$field['settings']->xml
												= 'default="'
												. $field['custom_value'] . '" '
												. $field['settings']->xml;
										}
									}
									unset($field['custom_value']);

									// return field
									return $field;
								}, array_values($form['fields'])
							);
							// check if field is external form file
							if (!isset($form['module']) || $form['module'] != 1)
							{
								// load the form file
								if (!isset($module->form_files[$form['file']]))
								{
									$module->form_files[$form['file']]
										= array();
								}
								if (!isset($module->form_files[$form['file']][$form['fields_name']]))
								{
									$module->form_files[$form['file']][$form['fields_name']]
										= array();
								}
								if (!isset($module->form_files[$form['file']][$form['fields_name']][$form['fieldset']]))
								{
									$module->form_files[$form['file']][$form['fields_name']][$form['fieldset']]
										= array();
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->getFieldName(
										$field, $module->key, $unique
									);
									// add the fields to the global form file builder
									$module->form_files[$form['file']][$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($module->fields[$n]);
							}
							else
							{
								// load the config form
								if (!isset($module->config_fields[$form['fields_name']]))
								{
									$module->config_fields[$form['fields_name']]
										= array();
								}
								if (!isset($module->config_fields[$form['fields_name']][$form['fieldset']]))
								{
									$module->config_fields[$form['fields_name']][$form['fieldset']]
										= array();
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->getFieldName(
										$field, $module->key, $unique
									);
									// add the fields to the config builder
									$module->config_fields[$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($module->fields[$n]);
							}
						}
						else
						{
							unset($module->fields[$n]);
						}
					}
				}
				unset($module->fields);
				// set the add targets
				$addArray = array('files'           => 'files',
				                  'folders'         => 'folders',
				                  'urls'            => 'urls',
				                  'filesfullpath'   => 'files',
				                  'foldersfullpath' => 'folders');
				foreach ($addArray as $addTarget => $targetHere)
				{
					// set the add target data
					$module->{'add' . $addTarget} = (isset(
							$module->{'add' . $addTarget}
						)
						&& JsonHelper::check(
							$module->{'add' . $addTarget}
						)) ? json_decode($module->{'add' . $addTarget}, true)
						: null;
					if (ArrayHelper::check(
						$module->{'add' . $addTarget}
					))
					{
						if (isset($module->{$targetHere})
							&& ArrayHelper::check(
								$module->{$targetHere}
							))
						{
							foreach ($module->{'add' . $addTarget} as $taget)
							{
								$module->{$targetHere}[] = $taget;
							}
						}
						else
						{
							$module->{$targetHere} = array_values(
								$module->{'add' . $addTarget}
							);
						}
					}
					unset($module->{'add' . $addTarget});
				}
				// load the library
				if (!isset($this->libManager[CFactory::_('Config')->build_target]))
				{
					$this->libManager[CFactory::_('Config')->build_target] = array();
				}
				if (!isset($this->libManager[CFactory::_('Config')->build_target][$module->code_name]))
				{
					$this->libManager[CFactory::_('Config')->build_target][$module->code_name]
						= array();
				}
				// make sure json become array
				if (JsonHelper::check($module->libraries))
				{
					$module->libraries = json_decode($module->libraries, true);
				}
				// if we have an array add it
				if (ArrayHelper::check($module->libraries))
				{
					foreach ($module->libraries as $library)
					{
						if (!isset($this->libManager[CFactory::_('Config')->build_target][$module->code_name][$library]))
						{
							if ($this->getMediaLibrary((int) $library))
							{
								$this->libManager[CFactory::_('Config')->build_target][$module->code_name][(int) $library]
									= true;
							}
						}
					}
				}
				elseif (is_numeric($module->libraries)
					&& !isset($this->libManager[CFactory::_('Config')->build_target][$module->code_name][(int) $module->libraries]))
				{
					if ($this->getMediaLibrary((int) $module->libraries))
					{
						$this->libManager[CFactory::_('Config')->build_target][$module->code_name][(int) $module->libraries]
							= true;
					}
				}
				// add PHP in module install
				$module->add_install_script = false;
				$addScriptMethods           = array('php_preflight',
					'php_postflight',
					'php_method');
				$addScriptTypes             = array('install', 'update',
					'uninstall');
				// the next are php placeholders
				$guiMapper['type'] = 'php';
				foreach ($addScriptMethods as $scriptMethod)
				{
					foreach ($addScriptTypes as $scriptType)
					{
						if (isset(
								$module->{'add_' . $scriptMethod . '_'
								. $scriptType}
							)
							&& $module->{'add_' . $scriptMethod . '_'
							. $scriptType} == 1
							&& StringHelper::check(
								$module->{$scriptMethod . '_' . $scriptType}
							))
						{
							// set GUI mapper field
							$guiMapper['field']         = $scriptMethod . '_'
								. $scriptType;
							$module->{$scriptMethod . '_' . $scriptType}
							                            = CFactory::_('Customcode.Gui')->set(
								CFactory::_('Placeholder')->update(
									CFactory::_('Customcode')->add(
										base64_decode(
											$module->{$scriptMethod . '_'
											. $scriptType}
										)
									), CFactory::_('Placeholder')->active
								),
								$guiMapper
							);
							$module->add_install_script = true;
						}
						else
						{
							unset($module->{$scriptMethod . '_' . $scriptType});
							$module->{'add_' . $scriptMethod . '_'
							. $scriptType}
								= 0;
						}
					}
				}
				// add_sql
				if ($module->add_sql == 1
					&& StringHelper::check($module->sql))
				{
					$module->sql = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(base64_decode($module->sql)),
						CFactory::_('Placeholder')->active
					);
				}
				else
				{
					unset($module->sql);
					$module->add_sql = 0;
				}
				// add_sql_uninstall
				if ($module->add_sql_uninstall == 1
					&& StringHelper::check(
						$module->sql_uninstall
					))
				{
					$module->sql_uninstall = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(
							base64_decode($module->sql_uninstall)
						), CFactory::_('Placeholder')->active
					);
				}
				else
				{
					unset($module->sql_uninstall);
					$module->add_sql_uninstall = 0;
				}
				// update the URL of the update_server if set
				if ($module->add_update_server == 1
					&& StringHelper::check(
						$module->update_server_url
					))
				{
					$module->update_server_url = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add($module->update_server_url),
						CFactory::_('Placeholder')->active
					);
				}
				// add the update/sales server FTP details if that is the expected protocol
				$serverArray = array('update_server', 'sales_server');
				foreach ($serverArray as $server)
				{
					if ($module->{'add_' . $server} == 1
						&& is_numeric(
							$module->{$server}
						)
						&& $module->{$server} > 0)
					{
						// get the server protocol
						$module->{$server . '_protocol'}
							= GetHelper::var(
							'server', (int) $module->{$server}, 'id', 'protocol'
						);
					}
					else
					{
						$module->{$server} = 0;
						// only change this for sales server (update server can be added loacaly to the zip file)
						if ('sales_server' === $server)
						{
							$module->{'add_' . $server} = 0;
						}
						$module->{$server . '_protocol'} = 0;
					}
				}
				// set the update server stuff (TODO)
				// update_server_xml_path
				// update_server_xml_file_name

				// rest globals
				CFactory::_('Config')->build_target = $_backup_target;
				CFactory::_('Config')->lang_target = $_backup_lang;
				$this->langPrefix = $_backup_langPrefix;
				CFactory::_('Config')->set('lang_prefix', $_backup_langPrefix);

				unset(
					CFactory::_('Placeholder')->active[Placefix::_('Module_name')]
				);
				unset(CFactory::_('Placeholder')->active[Placefix::_('Module')]);
				unset(CFactory::_('Placeholder')->active[Placefix::_('module')]);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_('module.version')]
				);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_('module_version')]
				);

				$this->joomlaModules[$id] = $module;

				return true;
			}
		}

		return false;
	}

	/**
	 * get the module xml template
	 *
	 * @return  string
	 *
	 */
	public function getModuleXMLTemplate(&$module)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= PHP_EOL . '<extension type="module" version="'
			. $this->joomlaVersions[CFactory::_('Config')->joomla_version]['xml_version'] . '" client="'
			. $module->target_client . '" method="upgrade">';
		$xml .= PHP_EOL . Indent::_(1) . '<name>' . $module->lang_prefix
			. '</name>';
		$xml .= PHP_EOL . Indent::_(1) . '<creationDate>' . Placefix::_h('BUILDDATE') . '</creationDate>';
		$xml .= PHP_EOL . Indent::_(1) . '<author>' . Placefix::_h('AUTHOR') . '</author>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorEmail>' . Placefix::_h('AUTHOREMAIL') . '</authorEmail>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorUrl>' . Placefix::_h('AUTHORWEBSITE') . '</authorUrl>';
		$xml .= PHP_EOL . Indent::_(1) . '<copyright>' . Placefix::_h('COPYRIGHT') . '</copyright>';
		$xml .= PHP_EOL . Indent::_(1) . '<license>' . Placefix::_h('LICENSE') . '</license>';
		$xml .= PHP_EOL . Indent::_(1) . '<version>' . $module->module_version
			. '</version>';
		$xml .= PHP_EOL . Indent::_(1) . '<description>' . $module->lang_prefix
			. '_XML_DESCRIPTION</description>';
		$xml .= Placefix::_h('MAINXML');
		$xml .= PHP_EOL . '</extension>';

		return $xml;
	}

	/**
	 * get the module admin custom script field
	 *
	 * @return  string
	 *
	 */
	public function getModAdminVvvvvvvdm($fieldScriptBucket)
	{
		$form_field_class   = array();
		$form_field_class[] = Placefix::_h('BOM') . PHP_EOL;
		$form_field_class[] = "//" . Line::_(__Line__, __Class__)
			. " No direct access to this file";
		$form_field_class[] = "defined('_JEXEC') or die('Restricted access');";
		$form_field_class[] = PHP_EOL . "use Joomla\CMS\Form\FormField;";
		$form_field_class[] = "use Joomla\CMS\Factory;";
		$form_field_class[] = PHP_EOL
			. "class JFormFieldModadminvvvvvvvdm extends FormField";
		$form_field_class[] = "{";
		$form_field_class[] = Indent::_(1)
			. "protected \$type = 'modadminvvvvvvvdm';";
		$form_field_class[] = PHP_EOL . Indent::_(1)
			. "protected function getLabel()";
		$form_field_class[] = Indent::_(1) . "{";
		$form_field_class[] = Indent::_(2) . "return;";
		$form_field_class[] = Indent::_(1) . "}";
		$form_field_class[] = PHP_EOL . Indent::_(1)
			. "protected function getInput()";
		$form_field_class[] = Indent::_(1) . "{";
		$form_field_class[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the document";
		$form_field_class[] = Indent::_(2)
			. "\$document = Factory::getDocument();";
		$form_field_class[] = implode(PHP_EOL, $fieldScriptBucket);
		$form_field_class[] = Indent::_(2) . "return; // noting for now :)";
		$form_field_class[] = Indent::_(1) . "}";
		$form_field_class[] = "}";

		return implode(PHP_EOL, $form_field_class);
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return '';
	}

	/**
	 * set the Joomla plugins
	 *
	 * @return  true
	 *
	 */
	public function setJoomlaPlugin($id, &$component)
	{
		if (isset($this->joomlaPlugins[$id]))
		{
			return true;
		}
		else
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'g.name',
						'e.name',
						'e.head',
						'e.comment',
						'e.id',
						'f.addfiles',
						'f.addfolders',
						'f.addfilesfullpath',
						'f.addfoldersfullpath',
						'f.addurls',
						'u.version_update',
						'u.id'
					), array(
						'group',
						'extends',
						'class_head',
						'comment',
						'class_id',
						'addfiles',
						'addfolders',
						'addfilesfullpath',
						'addfoldersfullpath',
						'addurls',
						'version_update',
						'version_update_id'
					)
				)
			);
			// from these tables
			$query->from('#__componentbuilder_joomla_plugin AS a');
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_plugin_group', 'g'
				) . ' ON (' . $this->db->quoteName('a.joomla_plugin_group')
				. ' = ' . $this->db->quoteName('g.id') . ')'
			);
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_class_extends', 'e')
				. ' ON (' . $this->db->quoteName('a.class_extends') . ' = '
				. $this->db->quoteName('e.id') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_plugin_updates', 'u'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('u.joomla_plugin') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_plugin_files_folders_urls', 'f'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('f.joomla_plugin') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$query->where($this->db->quoteName('a.published') . ' >= 1');
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// get the plugin data
				$plugin = $this->db->loadObject();
				// tweak system to set stuff to the plugin domain
				$_backup_target     = CFactory::_('Config')->build_target;
				$_backup_lang       = CFactory::_('Config')->lang_target;
				$_backup_langPrefix = CFactory::_('Config')->lang_prefix;
				// set some keys
				$plugin->target_type = 'P|uG!n';
				$plugin->key         = $plugin->id . '_' . $plugin->target_type;
				// update to point to plugin
				CFactory::_('Config')->build_target = $plugin->key;
				CFactory::_('Config')->lang_target = $plugin->key;
				// set version if not set
				if (empty($plugin->plugin_version))
				{
					$plugin->plugin_version = '1.0.0';
				}
				// set GUI mapper
				$guiMapper = array('table' => 'joomla_plugin',
				                   'id'    => (int) $id, 'type' => 'php');
				// update the name if it has dynamic values
				$plugin->name = CFactory::_('Placeholder')->update(
					CFactory::_('Customcode')->add($plugin->name), CFactory::_('Placeholder')->active
				);
				// update the name if it has dynamic values
				$plugin->code_name
					= ClassfunctionHelper::safe(
					$plugin->name
				);
				// set official name
				$plugin->official_name = ucwords(
					$plugin->group . ' - ' . $plugin->name
				);
				// set langPrefix
				$this->langPrefix
					= PluginHelper::safeLangPrefix(
						$plugin->code_name,
						$plugin->group
				);
				CFactory::_('Config')->set('lang_prefix', $this->langPrefix);
				// set lang prefix
				$plugin->lang_prefix = CFactory::_('Config')->lang_prefix;
				// set plugin class name
				$plugin->class_name
					= PluginHelper::safeClassName(
						$plugin->code_name,
						$plugin->group
				);
				// set plugin install class name
				$plugin->installer_class_name
					= PluginHelper::safeInstallClassName(
						$plugin->code_name,
						$plugin->group
				);
				// set plugin folder name
				$plugin->folder_name
					= PluginHelper::safeFolderName(
						$plugin->code_name,
						$plugin->group
				);
				// set the zip name
				$plugin->zip_name = $plugin->folder_name . '_v' . str_replace(
						'.', '_', $plugin->plugin_version
					) . '__J' . CFactory::_('Config')->joomla_version;
				// set plugin file name
				$plugin->file_name = strtolower($plugin->code_name);
				// set plugin context
				$plugin->context = $plugin->folder_name . '.' . $plugin->id;
				// set official_name lang strings
				CFactory::_('Language')->set(
					$plugin->key, CFactory::_('Config')->lang_prefix, $plugin->official_name
				);
				// set some placeholder for this plugin
				CFactory::_('Placeholder')->active[Placefix::_('Plugin_name')]
					= $plugin->official_name;
				CFactory::_('Placeholder')->active[Placefix::_h('PLUGIN_NAME')]
					= $plugin->official_name;
				CFactory::_('Placeholder')->active[Placefix::_('Plugin')]
					= ucfirst(
					$plugin->code_name
				);
				CFactory::_('Placeholder')->active[Placefix::_('plugin')]
					= strtolower(
					$plugin->code_name
				);
				CFactory::_('Placeholder')->active[Placefix::_('Plugin_group')]
					= ucfirst(
					$plugin->group
				);
				CFactory::_('Placeholder')->active[Placefix::_('plugin_group')]
					= strtolower(
					$plugin->group
				);
				CFactory::_('Placeholder')->active[Placefix::_('plugin.version')]
					= $plugin->plugin_version;
				CFactory::_('Placeholder')->active[Placefix::_h('VERSION')]
					= $plugin->plugin_version;
				CFactory::_('Placeholder')->active[Placefix::_('plugin_version')]
					= str_replace(
					'.', '_', $plugin->plugin_version
				);
				// set description
				CFactory::_('Placeholder')->active[Placefix::_h('DESCRIPTION')]
					= '';
				if (!isset($plugin->description)
					|| !StringHelper::check(
						$plugin->description
					))
				{
					$plugin->description = '';
				}
				else
				{
					$plugin->description = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add($plugin->description),
						CFactory::_('Placeholder')->active
					);
					CFactory::_('Language')->set(
						$plugin->key, $plugin->lang_prefix . '_DESCRIPTION',
						$plugin->description
					);
					// set description
					CFactory::_('Placeholder')->active[Placefix::_h('DESCRIPTION')]
						                 = $plugin->description;
					$plugin->description = '<p>' . $plugin->description
						. '</p>';
				}
				$plugin->xml_description = "<h1>" . $plugin->official_name
					. " (v." . $plugin->plugin_version
					. ")</h1> <div style='clear: both;'></div>"
					. $plugin->description . "<p>Created by <a href='" . trim(
						$component->website
					) . "' target='_blank'>" . trim(
						JFilterOutput::cleanText($component->author)
					) . "</a><br /><small>Development started "
					. JFactory::getDate($plugin->created)->format("jS F, Y")
					. "</small></p>";
				// set xml discription
				CFactory::_('Language')->set(
					$plugin->key, $plugin->lang_prefix . '_XML_DESCRIPTION',
					$plugin->xml_description
				);
				// update the readme if set
				if ($plugin->addreadme == 1 && !empty($plugin->readme))
				{
					$plugin->readme = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(base64_decode($plugin->readme)),
						CFactory::_('Placeholder')->active
					);
				}
				else
				{
					$plugin->addreadme = 0;
					unset($plugin->readme);
				}
				// open some base64 strings
				if (!empty($plugin->main_class_code))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'main_class_code';
					// base64 Decode main_class_code.
					$plugin->main_class_code = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($plugin->main_class_code)
							), CFactory::_('Placeholder')->active
						),
						$guiMapper
					);
				}
				// set the head :)
				if ($plugin->add_head == 1 && !empty($plugin->head))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'head';
					// base64 Decode head.
					$plugin->head = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($plugin->head)
							), CFactory::_('Placeholder')->active
						),
						$guiMapper
					);
				}
				elseif (!empty($plugin->class_head))
				{
					// base64 Decode head.
					$plugin->head = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($plugin->class_head)
							), CFactory::_('Placeholder')->active
						),
						array(
							'table' => 'class_extends',
							'field' => 'head',
							'id'    => (int) $plugin->class_id,
							'type'  => 'php')
					);
				}
				unset($plugin->class_head);
				// set the comment
				if (!empty($plugin->comment))
				{
					// base64 Decode comment.
					$plugin->comment = CFactory::_('Customcode.Gui')->set(
						CFactory::_('Placeholder')->update(
							CFactory::_('Customcode')->add(
								base64_decode($plugin->comment)
							), CFactory::_('Placeholder')->active
						),
						array(
							'table' => 'class_extends',
							'field' => 'comment',
							'id'    => (int) $plugin->class_id,
							'type'  => 'php')
					);
				}
				// start the config array
				$plugin->config_fields = array();
				// create the form arrays
				$plugin->form_files      = array();
				$plugin->fieldsets_label = array();
				$plugin->fieldsets_paths = array();
				$plugin->add_rule_path = array();
				$plugin->add_field_path = array();
				// set global fields rule to default component path
				$plugin->fields_rules_paths = 1;
				// set the fields data
				$plugin->fields = (isset($plugin->fields)
					&& JsonHelper::check($plugin->fields))
					? json_decode($plugin->fields, true) : null;
				if (ArrayHelper::check($plugin->fields))
				{
					// ket global key
					$key            = $plugin->key;
					$dynamic_fields = array('fieldset'    => 'basic',
					                        'fields_name' => 'params',
					                        'file'        => 'config');
					foreach ($plugin->fields as $n => &$form)
					{
						if (isset($form['fields'])
							&& ArrayHelper::check(
								$form['fields']
							))
						{
							// make sure the dynamic_field is set to dynamic_value by default
							foreach (
								$dynamic_fields as $dynamic_field =>
								$dynamic_value
							)
							{
								if (!isset($form[$dynamic_field])
									|| !StringHelper::check(
										$form[$dynamic_field]
									))
								{
									$form[$dynamic_field] = $dynamic_value;
								}
								else
								{
									if ('fields_name' === $dynamic_field
										&& strpos($form[$dynamic_field], '.')
										!== false)
									{
										$form[$dynamic_field]
											= $form[$dynamic_field];
									}
									else
									{
										$form[$dynamic_field]
											= StringHelper::safe(
											$form[$dynamic_field]
										);
									}
								}
							}
							// check if field is external form file
							if (!isset($form['plugin']) || $form['plugin'] != 1)
							{
								// now build the form key
								$unique = $form['file'] . $form['fields_name']
									. $form['fieldset'];
							}
							else
							{
								// now build the form key
								$unique = $form['fields_name']
									. $form['fieldset'];
							}
							// set global fields rule path switchs
							if ($plugin->fields_rules_paths == 1
								&& isset($form['fields_rules_paths'])
								&& $form['fields_rules_paths'] == 2)
							{
								$plugin->fields_rules_paths = 2;
							}
							// set where to path is pointing
							$plugin->fieldsets_paths[$unique]
								= $form['fields_rules_paths'];
							// add the label if set to lang
							if (isset($form['label'])
								&& StringHelper::check(
									$form['label']
								))
							{
								$plugin->fieldsets_label[$unique]
									= CFactory::_('Language')->key($form['label']);
							}
							// check for extra rule paths
							if (isset($form['addrulepath'])
								&& ArrayHelper::check($form['addrulepath']))
							{
								foreach ($form['addrulepath'] as $add_rule_path)
								{
									if (StringHelper::check($add_rule_path['path']))
									{
										$plugin->add_rule_path[$unique] = $add_rule_path['path'];
									}
								}
							}
							// check for extra field paths
							if (isset($form['addfieldpath'])
								&& ArrayHelper::check($form['addfieldpath']))
							{
								foreach ($form['addfieldpath'] as $add_field_path)
								{
									if (StringHelper::check($add_field_path['path']))
									{
										$plugin->add_field_path[$unique] = $add_field_path['path'];
									}
								}
							}
							// build the fields
							$form['fields'] = array_map(
								function ($field) use ($key, $unique) {
									// make sure the alias and title is 0
									$field['alias'] = 0;
									$field['title'] = 0;
									// set the field details
									$this->setFieldDetails(
										$field, $key, $key, $unique
									);
									// update the default if set
									if (StringHelper::check(
											$field['custom_value']
										)
										&& isset($field['settings']))
									{
										if (($old_default
												= GetHelper::between(
												$field['settings']->xml,
												'default="', '"', false
											)) !== false)
										{
											// replace old default
											$field['settings']->xml
												= str_replace(
												'default="' . $old_default
												. '"', 'default="'
												. $field['custom_value'] . '"',
												$field['settings']->xml
											);
										}
										else
										{
											// add the default (hmmm not ideal but okay it should work)
											$field['settings']->xml
												= 'default="'
												. $field['custom_value'] . '" '
												. $field['settings']->xml;
										}
									}
									unset($field['custom_value']);

									// return field
									return $field;
								}, array_values($form['fields'])
							);
							// check if field is external form file
							if (!isset($form['plugin']) || $form['plugin'] != 1)
							{
								// load the form file
								if (!isset($plugin->form_files[$form['file']]))
								{
									$plugin->form_files[$form['file']]
										= array();
								}
								if (!isset($plugin->form_files[$form['file']][$form['fields_name']]))
								{
									$plugin->form_files[$form['file']][$form['fields_name']]
										= array();
								}
								if (!isset($plugin->form_files[$form['file']][$form['fields_name']][$form['fieldset']]))
								{
									$plugin->form_files[$form['file']][$form['fields_name']][$form['fieldset']]
										= array();
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->getFieldName(
										$field, $plugin->key, $unique
									);
									// add the fields to the global form file builder
									$plugin->form_files[$form['file']][$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($plugin->fields[$n]);
							}
							else
							{
								// load the config form
								if (!isset($plugin->config_fields[$form['fields_name']]))
								{
									$plugin->config_fields[$form['fields_name']]
										= array();
								}
								if (!isset($plugin->config_fields[$form['fields_name']][$form['fieldset']]))
								{
									$plugin->config_fields[$form['fields_name']][$form['fieldset']]
										= array();
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->getFieldName(
										$field, $plugin->key, $unique
									);
									// add the fields to the config builder
									$plugin->config_fields[$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($plugin->fields[$n]);
							}
						}
						else
						{
							unset($plugin->fields[$n]);
						}
					}
				}
				unset($plugin->fields);
				// set the add targets
				$addArray = array('files'           => 'files',
				                  'folders'         => 'folders',
				                  'urls'            => 'urls',
				                  'filesfullpath'   => 'files',
				                  'foldersfullpath' => 'folders');
				foreach ($addArray as $addTarget => $targetHere)
				{
					// set the add target data
					$plugin->{'add' . $addTarget} = (isset(
							$plugin->{'add' . $addTarget}
						)
						&& JsonHelper::check(
							$plugin->{'add' . $addTarget}
						)) ? json_decode($plugin->{'add' . $addTarget}, true)
						: null;
					if (ArrayHelper::check(
						$plugin->{'add' . $addTarget}
					))
					{
						if (isset($plugin->{$targetHere})
							&& ArrayHelper::check(
								$plugin->{$targetHere}
							))
						{
							foreach ($plugin->{'add' . $addTarget} as $taget)
							{
								$plugin->{$targetHere}[] = $taget;
							}
						}
						else
						{
							$plugin->{$targetHere} = array_values(
								$plugin->{'add' . $addTarget}
							);
						}
					}
					unset($plugin->{'add' . $addTarget});
				}
				// add PHP in plugin install
				$plugin->add_install_script = false;
				$addScriptMethods           = array('php_preflight',
					'php_postflight',
					'php_method');
				$addScriptTypes             = array('install', 'update',
					'uninstall');
				foreach ($addScriptMethods as $scriptMethod)
				{
					foreach ($addScriptTypes as $scriptType)
					{
						if (isset(
								$plugin->{'add_' . $scriptMethod . '_'
								. $scriptType}
							)
							&& $plugin->{'add_' . $scriptMethod . '_'
							. $scriptType} == 1
							&& StringHelper::check(
								$plugin->{$scriptMethod . '_' . $scriptType}
							))
						{
							// set GUI mapper field
							$guiMapper['field']         = $scriptMethod . '_'
								. $scriptType;
							$plugin->{$scriptMethod . '_' . $scriptType}
							                            = CFactory::_('Customcode.Gui')->set(
								CFactory::_('Placeholder')->update(
									CFactory::_('Customcode')->add(
										base64_decode(
											$plugin->{$scriptMethod . '_'
											. $scriptType}
										)
									), CFactory::_('Placeholder')->active
								),
								$guiMapper
							);
							$plugin->add_install_script = true;
						}
						else
						{
							unset($plugin->{$scriptMethod . '_' . $scriptType});
							$plugin->{'add_' . $scriptMethod . '_'
							. $scriptType}
								= 0;
						}
					}
				}
				// add_sql
				if ($plugin->add_sql == 1
					&& StringHelper::check($plugin->sql))
				{
					$plugin->sql = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(base64_decode($plugin->sql)),
						CFactory::_('Placeholder')->active
					);
				}
				else
				{
					unset($plugin->sql);
					$plugin->add_sql = 0;
				}
				// add_sql_uninstall
				if ($plugin->add_sql_uninstall == 1
					&& StringHelper::check(
						$plugin->sql_uninstall
					))
				{
					$plugin->sql_uninstall = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add(
							base64_decode($plugin->sql_uninstall)
						), CFactory::_('Placeholder')->active
					);
				}
				else
				{
					unset($plugin->sql_uninstall);
					$plugin->add_sql_uninstall = 0;
				}
				// update the URL of the update_server if set
				if ($plugin->add_update_server == 1
					&& StringHelper::check(
						$plugin->update_server_url
					))
				{
					$plugin->update_server_url = CFactory::_('Placeholder')->update(
						CFactory::_('Customcode')->add($plugin->update_server_url),
						CFactory::_('Placeholder')->active
					);
				}
				// add the update/sales server FTP details if that is the expected protocol
				$serverArray = array('update_server', 'sales_server');
				foreach ($serverArray as $server)
				{
					if ($plugin->{'add_' . $server} == 1
						&& is_numeric(
							$plugin->{$server}
						)
						&& $plugin->{$server} > 0)
					{
						// get the server protocol
						$plugin->{$server . '_protocol'}
							= GetHelper::var(
							'server', (int) $plugin->{$server}, 'id', 'protocol'
						);
					}
					else
					{
						$plugin->{$server} = 0;
						// only change this for sales server (update server can be added locally to the zip file)
						if ('sales_server' === $server)
						{
							$plugin->{'add_' . $server} = 0;
						}
						$plugin->{$server . '_protocol'} = 0;
					}
				}
				// set the update server stuff (TODO)
				// update_server_xml_path
				// update_server_xml_file_name

				// rest globals
				CFactory::_('Config')->build_target = $_backup_target;
				CFactory::_('Config')->lang_target = $_backup_lang;
				$this->langPrefix = $_backup_langPrefix;
				CFactory::_('Config')->set('lang_prefix', $_backup_langPrefix);

				unset(
					CFactory::_('Placeholder')->active[Placefix::_('Plugin_name')]
				);
				unset(CFactory::_('Placeholder')->active[Placefix::_('Plugin')]);
				unset(CFactory::_('Placeholder')->active[Placefix::_('plugin')]);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_('Plugin_group')]
				);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_('plugin_group')]
				);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_('plugin.version')]
				);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_('plugin_version')]
				);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_h('VERSION')]
				);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_h('DESCRIPTION')]
				);
				unset(
					CFactory::_('Placeholder')->active[Placefix::_h('PLUGIN_NAME')]
				);

				$this->joomlaPlugins[$id] = $plugin;

				return true;
			}
		}

		return false;
	}

	/**
	 * get the plugin xml template
	 *
	 * @return  string
	 *
	 */
	public function getPluginXMLTemplate(&$plugin)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= PHP_EOL . '<extension type="plugin" version="'
			. $this->joomlaVersions[CFactory::_('Config')->joomla_version]['xml_version'] . '" group="'
			. strtolower($plugin->group) . '" method="upgrade">';
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
	 *
	 * @deprecated 3.3
	 */
	protected function setNewCustomCode($when = 1)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
	 *
	 * @deprecated 3.3
	 */
	protected function setExistingCustomCode($when = 1)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
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
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);

		return [];
	}

}
