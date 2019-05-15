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
 * Get class as the main compilers class
 */
class Get
{
	
	/**
	 * The hash placeholder
	 * 
	 * @var     string
	 */
	public $hhh = '#' . '#' . '#';

	/**
	 * The open bracket placeholder
	 * 
	 * @var     string
	 */
	public $bbb = '[' . '[' . '[';

	/**
	 * The close bracket placeholder
	 * 
	 * @var     string
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
	 * The global placeholders
	 * 
	 * @var     array
	 */
	public $globalPlaceholders = array();

	/**
	 * The placeholders
	 * 
	 * @var     array
	 */
	public $placeholders = array();

	/**
	 * The Compiler Path
	 * 
	 * @var     object
	 */
	public $compilerPath;

	/**
	 * Switch to add custom code placeholders
	 * 
	 * @var     bool
	 */
	public $addPlaceholders = false;

	/**
	 * The placeholders for custom code keys
	 * 
	 * @var     array
	 */
	protected $customCodeKeyPlacholders = array(
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

	/*	 * *********************************************************************************************
	 * 	The custom script placeholders - we use the (xxx) to avoid detection it should be (***)
	 * 	##################################--->  PHP/JS  <---####################################
	 * 
	 * 	New Insert Code		= /xxx[INSERT<>$$$$]xxx/                /xxx[/INSERT<>$$$$]xxx/
	 * 	New Replace Code	= /xxx[REPLACE<>$$$$]xxx/               /xxx[/REPLACE<>$$$$]xxx/
	 *
	 * 	//////////////////////////////// when JCB adds it back //////////////////////////////////
	 * 	JCB Add Inserted Code	= /xxx[INSERTED$$$$]xxx//x23x/          /xxx[/INSERTED$$$$]xxx/
	 * 	JCB Add Replaced Code	= /xxx[REPLACED$$$$]xxx//x25x/          /xxx[/REPLACED$$$$]xxx/
	 *
	 * 	/////////////////////////////// changeing existing custom code /////////////////////////
	 * 	Update Inserted Code	= /xxx[INSERTED<>$$$$]xxx//x23x/        /xxx[/INSERTED<>$$$$]xxx/
	 * 	Update Replaced Code	= /xxx[REPLACED<>$$$$]xxx//x25x/        /xxx[/REPLACED<>$$$$]xxx/
	 * 
	 * 	The custom script placeholders - we use the (==) to avoid detection it should be (--)
	 * 	###################################--->  HTML  <---#####################################
	 * 
	 * 	New Insert Code		= <!==[INSERT<>$$$$]==>                 <!==[/INSERT<>$$$$]==>
	 * 	New Replace Code	= <!==[REPLACE<>$$$$]==>                <!==[/REPLACE<>$$$$]==>
	 *
	 * 	///////////////////////////////// when JCB adds it back ///////////////////////////////
	 * 	JCB Add Inserted Code	= <!==[INSERTED$$$$]==><!==23==>        <!==[/INSERTED$$$$]==>
	 * 	JCB Add Replaced Code	= <!==[REPLACED$$$$]==><!==25==>        <!==[/REPLACED$$$$]==>
	 *
	 * 	//////////////////////////// changeing existing custom code ///////////////////////////
	 * 	Update Inserted Code	= <!==[INSERTED<>$$$$]==><!==23==>      <!==[/INSERTED<>$$$$]==>
	 * 	Update Replaced Code	= <!==[REPLACED<>$$$$]==><!==25==>      <!==[/REPLACED<>$$$$]==>
	 * 
	 * 	////////23 is the ID of the code in the system don't change it!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * 
	 * 	@var      array
	 * ********************************************************************************************* */
	protected $customCodePlaceholders = array(
		1 => 'REPLACE<>$$$$]',
		2 => 'INSERT<>$$$$]',
		3 => 'REPLACED<>$$$$]',
		4 => 'INSERTED<>$$$$]'
	);

	/**
	 * The custom code to be added
	 * 
	 * @var      array
	 */
	public $customCode;

	/**
	 * The custom code to be added
	 * 
	 * @var      array
	 */
	protected $customCodeData = array();

	/**
	 * The function name memory ids
	 * 
	 * @var      array
	 */
	public $functionNameMemory = array();

	/**
	 * The custom code for local memory
	 * 
	 * @var      array
	 */
	public $customCodeMemory = array();

	/**
	 * The custom code in local files that already exist in system
	 * 
	 * @var      array
	 */
	protected $existingCustomCode = array();

	/**
	 * The custom code in local files this are new
	 * 
	 * @var      array
	 */
	protected $newCustomCode = array();

	/**
	 * The index of code already loaded
	 * 
	 * @var      array
	 */
	protected $codeAreadyDone = array();

	/**
	 * The external code/string to be added
	 * 
	 * @var      array
	 */
	protected $externalCodeString = array();

	/*
	 * The line numbers Switch
	 * 
	 * @var      boolean
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
	 */
	public $langPrefix;

	/**
	 * The Language content
	 * 
	 * @var      array
	 */
	public $langContent = array();

	/**
	 * The Languages bucket
	 * 
	 * @var      array
	 */
	public $languages = array();

	/**
	 * The Main Languages
	 * 
	 * @var      string
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
	 */
	public $langMismatch = array();

	/**
	 * The Language SC matching check
	 * 
	 * @var      array
	 */
	public $langMatch = array();

	/**
	 * The Language string targets
	 * 
	 * @var      array
	 */
	public $langStringTargets = array(
		'Joomla' . '.JText._(',
		'JText:' . ':script(',
		'JText:' . ':_(',
		'JText:' . ':sprintf(',
		'JustTEXT:' . ':_('
	);

	/**
	 * The Component Code Name
	 * 
	 * @var      string
	 */
	public $componentCodeName;

	/**
	 * The Component ID
	 * 
	 * @var      int
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
	 * @var	boolean
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
	 * The Language target
	 * 
	 * @var     string
	 */
	public $lang = 'admin';

	/**
	 * The Build target Switch
	 * 
	 * @var     string
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
	 * Default Fields
	 * 
	 * @var    array
	 */
	public $defaultFields = array('created', 'created_by', 'modified', 'modified_by', 'published', 'ordering', 'access', 'version', 'hits', 'id');

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
	public $cryptionTypes = array('basic', 'medium', 'whmcs');

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
	 */
	public $minify = 0;

	/**
	 * Is Tidy Enabled
	 * 
	 * @var    bool
	 */
	public $tidy = false;

	/**
	 * Set Tidy warning once switch
	 * 
	 * @var    bool
	 */
	public $setTidyWarning = false;

	/**
	 * Tab/spacer bucket (to speed-up the build)
	 * 
	 * @var   array
	 */
	public $tabSpacerBucket = array();

	/**
	 * Set tab/spacer
	 * 
	 * @var   string
	 */
	public $tabSpacer = "\t";

	/**
	 * mysql table setting keys
	 * 
	 * @var    array
	 */
	public $mysqlTableKeys = array(
		'engine' => array('default' => 'MyISAM'),
		'charset' => array('default' => 'utf8'),
		'collate' => array('default' => 'utf8_general_ci'),
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

	public function __construct($config = array())
	{
		if (isset($config) && count($config))
		{
			// load application
			$this->app = JFactory::getApplication();
			// Set the params
			$this->params = JComponentHelper::getParams('com_componentbuilder');
			// set the minfy switch of the JavaScript
			$this->minify = (isset($config['minify']) && $config['minify'] != 2) ? $config['minify'] : $this->params->get('minify', 0);
			// set the global language
			$this->langTag = $this->params->get('language', $this->langTag);
			// setup the main language array
			$this->languages[$this->langTag] = array();
			// check if we have Tidy enabled
			$this->tidy = extension_loaded('Tidy');
			// set the field type builder
			$this->fieldBuilderType = $this->params->get('compiler_field_builder_type', 2);
			// check the field builder type logic
			if (!$this->tidy && $this->fieldBuilderType == 2)
			{
				// we do not have the tidy extention set fall back to StringManipulation
				$this->fieldBuilderType = 1;
				// load the sugestion to use string manipulation
				$this->app->enqueueMessage(JText::_('<hr /><h3>Field Notice</h3>'), 'Notice');
				$this->app->enqueueMessage(JText::_('Since you do not have <b>Tidy</b> extentsion setup on your system, we could not use the SimpleXMLElement class. We instead used <b>string manipulation</b> to build all your fields, this is a faster method, you must inspect the xml files in your component package to see if you are satisfied with the result.<br />You can make this method your default by opening the global options of JCB and under the <b>Global</b> tab set the <b>Field Builder Type</b> to string manipulation.'), 'Notice');
			}
			// load the compiler path
			$this->compilerPath = $this->params->get('compiler_folder_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler');
			// set the component ID
			$this->componentID = (int) $config['component'];
			// set this components code name
			if ($name_code = ComponentbuilderHelper::getVar('joomla_component', $this->componentID, 'id', 'name_code'))
			{
				// set lang prefix
				$this->langPrefix = 'COM_' . ComponentbuilderHelper::safeString($name_code, 'U');
				// set component code name
				$this->componentCodeName = ComponentbuilderHelper::safeString($name_code);
				// set if placeholders should be added to customcode
				$global = ((int) ComponentbuilderHelper::getVar('joomla_component', $this->componentID, 'id', 'add_placeholders') == 1) ? true : false;
				$this->addPlaceholders = ((int) $config['placeholders'] == 0) ? false : (((int) $config['placeholders'] == 1) ? true : $global);
				// set if line numbers should be added to comments
				$global = ((int) ComponentbuilderHelper::getVar('joomla_component', $this->componentID, 'id', 'debug_linenr') == 1) ? true : false;
				$this->debugLinenr = ((int) $config['debuglinenr'] == 0) ? false : (((int) $config['debuglinenr'] == 1) ? true : $global);
				// set the current user
				$this->user = JFactory::getUser();
				// Get a db connection.
				$this->db = JFactory::getDbo();
				// get global placeholders
				$this->globalPlaceholders = $this->getGlobalPlaceholders();
				// check if this component is install on the current website
				if ($paths = $this->getLocalInstallPaths())
				{
					// start Automatic import of custom code
					$today = JFactory::getDate()->toSql();
					// get the custom code from installed files
					$this->customCodeFactory($paths, $today);
				}
				// get the component data
				$this->componentData = $this->getComponentData();
				// make sure we have a version
				if (strpos($this->componentData->component_version, '.') === FALSE)
				{
					$this->componentData->component_version = '1.0.0';
				}
				// update the version
				if (!isset($this->componentData->old_component_version) && (ComponentbuilderHelper::checkArray($this->addSQL) || ComponentbuilderHelper::checkArray($this->updateSQL)))
				{
					// set the new version
					$version = (array) explode('.', $this->componentData->component_version);
					// get last key
					end($version);
					$key = key($version);
					// just increment the last
					$version[$key] ++;
					// set the old version
					$this->componentData->old_component_version = $this->componentData->component_version;
					// set the new version, and set update switch
					$this->componentData->component_version = implode('.', $version);
				}
				// set the percentage when a language can be added
				$this->percentageLanguageAdd = (int) $this->params->get('percentagelanguageadd', 50);

				return true;
			}
		}
		return false;
	}

	/**
	 * Set the tab/space
	 * 
	 * @param   int   $nr  The number of tag/space
	 * 
	 * @return  string
	 * 
	 */
	public function _t($nr)
	{
		// check if we already have the string
		if (!isset($this->tabSpacerBucket[$nr]))
		{
			// get the string
			$this->tabSpacerBucket[$nr] = str_repeat($this->tabSpacer, (int) $nr);
		}
		// return stored string
		return $this->tabSpacerBucket[$nr];
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
			return ' [Get ' . $nr . ']';
		}
		return '';
	}

	/**
	 * get all System Placeholders
	 *
	 * @return  array The global placeholders
	 * 
	 */
	public function getGlobalPlaceholders()
	{
		// reset bucket
		$bucket = array();
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('a.target','a.value')));
		// from these tables
		$query->from('#__componentbuilder_placeholder AS a');
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		// Load the items
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			$bucket = $this->db->loadAssocList('target', 'value');
			foreach ($bucket as $key => &$code)
			{
				$code = base64_decode($code);
			}
		}
		return $bucket;
	}

	/**
	 * get all Component Data
	 * 
	 * @param   int   $id  The component ID
	 *
	 * @return  oject The component data
	 * 
	 */
	public function getComponentData()
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		$query->select('a.*');
		$query->select(
			$this->db->quoteName(
				array(
				'b.addadmin_views',
				'b.id',
				'h.addconfig',
				'd.addcustom_admin_views',
				'g.addcustommenus',
				'j.addfiles',
				'j.addfolders',
				'j.addfilesfullpath',
				'j.addfoldersfullpath',
				'c.addsite_views',
				'i.dashboard_tab',
				'i.php_dashboard_methods',
				'f.sql_tweak',
				'e.version_update',
				'e.id',
				'k.addplaceholders'
				), array(
				'addadmin_views',
				'addadmin_views_id',
				'addconfig',
				'addcustom_admin_views',
				'addcustommenus',
				'addfiles',
				'addfolders',
				'addfilesfullpath',
				'addfoldersfullpath',
				'addsite_views',
				'dashboard_tab',
				'php_dashboard_methods',
				'sql_tweak',
				'version_update',
				'version_update_id',
				'_placeholders'
				)
			)
		);
		// from these tables
		$query->from('#__componentbuilder_joomla_component AS a');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_admin_views', 'b') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('b.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_site_views', 'c') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('c.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_custom_admin_views', 'd') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('d.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_updates', 'e') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('e.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_mysql_tweaks', 'f') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('f.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_custom_admin_menus', 'g') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('g.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_config', 'h') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('h.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_dashboard', 'i') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('i.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_files_folders', 'j') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('j.joomla_component') . ')');
		$query->join('LEFT', $this->db->quoteName('#__componentbuilder_component_placeholders', 'k') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('k.joomla_component') . ')');
		$query->where($this->db->quoteName('a.id') . ' = ' . (int) $this->componentID);

		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);

		// Load the results as a list of stdClass objects
		$component = $this->db->loadObject();

		// set upater
		$updater = array(
			'unique' => array(
				'addadmin_views' => array('table' => 'component_admin_views', 'val' => (int) $component->addadmin_views_id, 'key' => 'id'),
				'addconfig' => array('table' => 'component_config', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'addcustom_admin_views' => array('table' => 'component_custom_admin_views', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'addcustommenus' => array('table' => 'component_custom_admin_menus', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'addfiles' => array('table' => 'component_files_folders', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'addfolders' => array('table' => 'component_files_folders', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'addsite_views' => array('table' => 'component_site_views', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'dashboard_tab' => array('table' => 'component_dashboard', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'sql_tweak' => array('table' => 'component_mysql_tweaks', 'val' => (int) $this->componentID, 'key' => 'joomla_component'),
				'version_update' => array('table' => 'component_updates', 'val' => (int) $this->componentID, 'key' => 'joomla_component')
			),
			'table' => 'joomla_component',
			'key' => 'id',
			'val' => (int) $this->componentID
		);
		// repeatable fields to update
		$searchRepeatables = array(
			// repeatablefield => checker
			'addadmin_views' => 'adminview',
			'addconfig' => 'field',
			'addcontributors' => 'name',
			'addcustom_admin_views' => 'customadminview',
			'addcustommenus' => 'name',
			'addfiles' => 'file',
			'addfolders' => 'folder',
			'addsite_views' => 'siteview',
			'dashboard_tab' => 'name',
			'sql_tweak' => 'adminview',
			'version_update' => 'version'
		);
		// update the repeatable fields
		$component = ComponentbuilderHelper::convertRepeatableFields($component, $searchRepeatables, $updater);

		// set component place holders
		$this->placeholders[$this->hhh . 'component' . $this->hhh] = ComponentbuilderHelper::safeString($component->name_code);
		$this->placeholders[$this->hhh . 'Component' . $this->hhh] = ComponentbuilderHelper::safeString($component->name_code, 'F');
		$this->placeholders[$this->hhh . 'COMPONENT' . $this->hhh] = ComponentbuilderHelper::safeString($component->name_code, 'U');
		$this->placeholders[$this->bbb . 'component' . $this->ddd] = $this->placeholders[$this->hhh . 'component' . $this->hhh];
		$this->placeholders[$this->bbb . 'Component' . $this->ddd] = $this->placeholders[$this->hhh . 'Component' . $this->hhh];
		$this->placeholders[$this->bbb . 'COMPONENT' . $this->ddd] = $this->placeholders[$this->hhh . 'COMPONENT' . $this->hhh];

		// set the addcustommenus data
		$component->_placeholders = (isset($component->_placeholders) && ComponentbuilderHelper::checkJson($component->_placeholders)) ? json_decode($component->_placeholders, true) : null;
		if (ComponentbuilderHelper::checkArray($component->_placeholders))
		{
			foreach($component->_placeholders as $row)
			{
				$this->globalPlaceholders[$row['target']] = $row['value'];
			}
		}
		unset($component->_placeholders);

		// load the global placeholders
		if (ComponentbuilderHelper::checkArray($this->globalPlaceholders))
		{
			foreach ($this->globalPlaceholders as $globalPlaceholder => $gloabalValue)
			{
				$this->placeholders[$globalPlaceholder] = $gloabalValue;
			}
		}

		// set component sales name
		$component->sales_name = ComponentbuilderHelper::safeString($component->system_name);

		// ensure version naming is correct
		$this->component_version = preg_replace('/[^0-9.]+/', '', $component->component_version);

		// set the add targets
		$addArrayF = array('files' => 'files', 'folders' => 'folders', 'filesfullpath' => 'files', 'foldersfullpath' => 'folders');
		foreach ($addArrayF as $addTarget => $targetHere)
		{
			// set the add target data
			$component->{'add' . $addTarget} = (isset($component->{'add' . $addTarget}) && ComponentbuilderHelper::checkJson($component->{'add' . $addTarget})) ? json_decode($component->{'add' . $addTarget}, true) : null;
			if (ComponentbuilderHelper::checkArray($component->{'add' . $addTarget}))
			{
				if (isset($component->{$targetHere}) && ComponentbuilderHelper::checkArray($component->{$targetHere}))
				{
					foreach ($component->{'add' . $addTarget} as $taget)
					{
						$component->{$targetHere}[] = $taget;
					}
				}
				else
				{
					$component->{$targetHere} = array_values($component->{'add' . $addTarget});
				}
			}
			unset($component->{'add' . $addTarget});
		}

		// set the uikit switch
		$this->uikit = $component->adduikit;

		// set whmcs links if needed
		if (1 == $component->add_license && (!isset($component->whmcs_buy_link) || !ComponentbuilderHelper::checkString($component->whmcs_buy_link)))
		{
			// update with the whmcs url
			if (isset($component->whmcs_url) && ComponentbuilderHelper::checkString($component->whmcs_url))
			{
				$component->whmcs_buy_link = $component->whmcs_url;
			}
			// use the company website
			elseif (isset($component->website) && ComponentbuilderHelper::checkString($component->website))
			{
				$component->whmcs_buy_link = $component->website;
				$component->whmcs_url = rtrim($component->website, '/').'/whmcs';
			}
			// none set
			else
			{
				$component->whmcs_buy_link = '#';
				$component->whmcs_url = '#';
			}
		}
		// since the license details are not set clear
		elseif (0 == $component->add_license)
		{
			$component->whmcs_key = '';
			$component->whmcs_buy_link = '';
			$component->whmcs_url = '';
		}

		// set the footable switch
		if ($component->addfootable)
		{
			$this->footable = true;
			// add the version
			$this->footableVersion = (1 == $component->addfootable || 2 == $component->addfootable) ? 2 : $component->addfootable;
		}

		// set the addcustommenus data
		$component->addcustommenus = (isset($component->addcustommenus) && ComponentbuilderHelper::checkJson($component->addcustommenus)) ? json_decode($component->addcustommenus, true) : null;
		if (ComponentbuilderHelper::checkArray($component->addcustommenus))
		{
			$component->custommenus = array_values($component->addcustommenus);
		}
		unset($component->addcustommenus);

		// set the sql_tweak data
		$component->sql_tweak = (isset($component->sql_tweak) && ComponentbuilderHelper::checkJson($component->sql_tweak)) ? json_decode($component->sql_tweak, true) : null;
		if (ComponentbuilderHelper::checkArray($component->sql_tweak))
		{
			// build the tweak settings
			$this->setSqlTweaking(array_map(function($array)
				{
					return array_map(function($value)
					{
						if (!ComponentbuilderHelper::checkArray($value) && !ComponentbuilderHelper::checkObject($value) && strval($value) === strval(intval($value)))
						{
							return (int) $value;
						}
						return $value;
					}, $array);
				}, array_values($component->sql_tweak)));
		}
		unset($component->sql_tweak);

		// set the admin_view data
		$component->addadmin_views = (isset($component->addadmin_views) && ComponentbuilderHelper::checkJson($component->addadmin_views)) ? json_decode($component->addadmin_views, true) : null;
		if (ComponentbuilderHelper::checkArray($component->addadmin_views))
		{
			// sort the views acording to order
			usort($component->addadmin_views, function($a, $b)
			{
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
			});
			// build the admin_views settings
			$component->admin_views = array_map(function($array)
			{
				$array = array_map(function($value)
				{
					if (!ComponentbuilderHelper::checkArray($value) && !ComponentbuilderHelper::checkObject($value) && strval($value) === strval(intval($value)))
					{
						return (int) $value;
					}
					return $value;
				}, $array);
				// check if we must add to site
				if (isset($array['edit_create_site_view']) && is_numeric($array['edit_create_site_view']) && $array['edit_create_site_view'] > 0)
				{
					$this->siteEditView[$array['adminview']] = true;
					$this->lang = 'both';
				}
				if (isset($array['port']) && $array['port'] && !$this->addEximport)
				{
					$this->addEximport = true;
				}
				if (isset($array['history']) && $array['history'] && !$this->setTagHistory)
				{
					$this->setTagHistory = true;
				}
				if (isset($array['joomla_fields']) && $array['joomla_fields'] && !$this->setJoomlaFields)
				{
					$this->setJoomlaFields = true;
				}
				// has become a lacacy issue, can't remove this
				$array['view'] = $array['adminview'];
				// get the admin settings/data
				$array['settings'] = $this->getAdminViewData($array['view']);

				return $array;
			}, array_values($component->addadmin_views));
		}
		// set the site_view data
		$component->addsite_views = (isset($component->addsite_views) && ComponentbuilderHelper::checkJson($component->addsite_views)) ? json_decode($component->addsite_views, true) : null;
		if (ComponentbuilderHelper::checkArray($component->addsite_views))
		{
			$this->lang = 'site';
			$this->target = 'site';
			// build the site_views settings
			$component->site_views = array_map(function($array)
			{
				// has become a lacacy issue, can't remove this
				$array['view'] = $array['siteview'];
				$array['settings'] = $this->getCustomViewData($array['view']);
				return array_map(function($value)
				{
					if (!ComponentbuilderHelper::checkArray($value) && !ComponentbuilderHelper::checkObject($value) && strval($value) === strval(intval($value)))
					{
						return (int) $value;
					}
					return $value;
				}, $array);
			}, array_values($component->addsite_views));
			// unset original value
			unset($component->addsite_views);
		}

		// set the custom_admin_views data
		$component->addcustom_admin_views = (isset($component->addcustom_admin_views) && ComponentbuilderHelper::checkJson($component->addcustom_admin_views)) ? json_decode($component->addcustom_admin_views, true) : null;
		if (ComponentbuilderHelper::checkArray($component->addcustom_admin_views))
		{
			$this->lang = 'admin';
			$this->target = 'custom_admin';
			// build the custom_admin_views settings
			$component->custom_admin_views = array_map(function($array)
			{
				// has become a lacacy issue, can't remove this
				$array['view'] = $array['customadminview'];
				$array['settings'] = $this->getCustomViewData($array['view'], 'custom_admin_view');
				return array_map(function($value)
				{
					if (!ComponentbuilderHelper::checkArray($value) && !ComponentbuilderHelper::checkObject($value) && strval($value) === strval(intval($value)))
					{
						return (int) $value;
					}
					return $value;
				}, $array);
			}, array_values($component->addcustom_admin_views));
			// unset original value
			unset($component->addcustom_admin_views);
		}

		// set the config data
		$component->addconfig = (isset($component->addconfig) && ComponentbuilderHelper::checkJson($component->addconfig)) ? json_decode($component->addconfig, true) : null;
		if (ComponentbuilderHelper::checkArray($component->addconfig))
		{
			$component->config = array_map(function($field) {
				// make sure the alias and title is 0
				$field['alias'] = 0;
				$field['title'] = 0;
				// set the field details
				$this->setFieldDetails($field);
				// set unique name counter
				$this->setUniqueNameCounter($field['base_name'], 'configs');
				// return field
				return $field;
			}, array_values($component->addconfig));

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
		$component->addcontributors = (isset($component->addcontributors) && ComponentbuilderHelper::checkJson($component->addcontributors)) ? json_decode($component->addcontributors, true) : null;
		if (ComponentbuilderHelper::checkArray($component->addcontributors))
		{
			$this->addContributors = true;
			$component->contributors = array_values($component->addcontributors);
		}
		unset($component->addcontributors);

		// set the addcustommenus data
		$component->version_update = (isset($component->version_update) && ComponentbuilderHelper::checkJson($component->version_update)) ? json_decode($component->version_update, true) : null;
		if (ComponentbuilderHelper::checkArray($component->version_update))
		{
			$component->version_update = array_values($component->version_update);
		}

		// build update SQL
		$old_admin_views = $this->getHistoryWatch('component_admin_views', $component->addadmin_views_id);
		$old_component = $this->getHistoryWatch('joomla_component', $this->componentID);
		if ($old_component || $old_admin_views)
		{
			if (ComponentbuilderHelper::checkObject($old_admin_views))
			{
				// add new views if found
				if (isset($old_admin_views->addadmin_views) && ComponentbuilderHelper::checkJson($old_admin_views->addadmin_views))
				{
					$this->setUpdateSQL(json_decode($old_admin_views->addadmin_views, true), $component->addadmin_views, 'adminview');
				}
				// check if a new version was manualy set
				if (ComponentbuilderHelper::checkObject($old_component))
				{
					$old_component_version = preg_replace('/[^0-9.]+/', '', $old_component->component_version);
					if ($old_component_version != $this->component_version)
					{
						// yes, this is a new version, this mean there may be manual sql and must be checked and updated
						$component->old_component_version = $old_component_version;
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

		// add_javascript
		if ($component->add_javascript == 1)
		{
			$this->customScriptBuilder['component_js'] = base64_decode($component->javascript);
		}
		else
		{
			$this->customScriptBuilder['component_js'] = '';
		}
		unset($component->javascript);

		// add global CSS
		$addGlobalCss = array('admin', 'site');
		foreach ($addGlobalCss as $area)
		{
			// add_css if found
			if (isset($component->{'add_css_' . $area}) && $component->{'add_css_' . $area} == 1 && isset($component->{'css_' . $area}) && ComponentbuilderHelper::checkString($component->{'css_' . $area}))
			{
				$this->customScriptBuilder['component_css_' . $area] = base64_decode($component->{'css_' . $area});
			}
			else
			{
				$this->customScriptBuilder['component_css_' . $area] = '';
			}
			unset($component->{'css_' . $area});
		}
		// set the lang target
		$this->lang = 'admin';
		// add PHP in ADMIN
		$addScriptMethods = array('php_preflight', 'php_postflight', 'php_method');
		$addScriptTypes = array('install', 'update', 'uninstall');
		foreach ($addScriptMethods as $scriptMethod)
		{
			foreach ($addScriptTypes as $scriptType)
			{
				if (isset($component->{'add_' . $scriptMethod . '_' . $scriptType}) && $component->{'add_' . $scriptMethod . '_' . $scriptType} == 1 && ComponentbuilderHelper::checkString($component->{$scriptMethod . '_' . $scriptType}))
				{
					$this->customScriptBuilder[$scriptMethod][$scriptType] = $this->setDynamicValues(base64_decode($component->{$scriptMethod . '_' . $scriptType}));
				}
				else
				{
					$this->customScriptBuilder[$scriptMethod][$scriptType] = '';
				}
				unset($component->{$scriptMethod . '_' . $scriptType});
			}
		}
		// add_php_helper
		if ($component->add_php_helper_admin == 1 && ComponentbuilderHelper::checkString($component->php_helper_admin))
		{
			$this->lang = 'admin';
			$this->customScriptBuilder['component_php_helper_admin'] = PHP_EOL . PHP_EOL . $this->setDynamicValues(base64_decode($component->php_helper_admin));
		}
		else
		{
			$this->customScriptBuilder['component_php_helper_admin'] = '';
		}
		unset($component->php_helper);
		// add_admin_event
		if ($component->add_admin_event == 1 && ComponentbuilderHelper::checkString($component->php_admin_event))
		{
			$this->lang = 'admin';
			$this->customScriptBuilder['component_php_admin_event'] = $this->setDynamicValues(base64_decode($component->php_admin_event));
		}
		else
		{
			$this->customScriptBuilder['component_php_admin_event'] = '';
		}
		unset($component->php_admin_event);
		// add_php_helper_both
		if ($component->add_php_helper_both == 1 && ComponentbuilderHelper::checkString($component->php_helper_both))
		{
			$this->lang = 'both';
			$this->customScriptBuilder['component_php_helper_both'] = PHP_EOL . PHP_EOL . $this->setDynamicValues(base64_decode($component->php_helper_both));
		}
		else
		{
			$this->customScriptBuilder['component_php_helper_both'] = '';
		}
		// add_php_helper_site
		if ($component->add_php_helper_site == 1 && ComponentbuilderHelper::checkString($component->php_helper_site))
		{
			$this->lang = 'site';
			$this->customScriptBuilder['component_php_helper_site'] = PHP_EOL . PHP_EOL . $this->setDynamicValues(base64_decode($component->php_helper_site));
		}
		else
		{
			$this->customScriptBuilder['component_php_helper_site'] = '';
		}
		unset($component->php_helper);
		// add_site_event
		if ($component->add_site_event == 1 && ComponentbuilderHelper::checkString($component->php_site_event))
		{
			$this->lang = 'site';
			$this->customScriptBuilder['component_php_site_event'] = $this->setDynamicValues(base64_decode($component->php_site_event));
		}
		else
		{
			$this->customScriptBuilder['component_php_site_event'] = '';
		}
		unset($component->php_site_event);
		// add_sql
		if ($component->add_sql == 1)
		{
			$this->customScriptBuilder['sql']['component_sql'] = base64_decode($component->sql);
		}
		unset($component->sql);
		// add_sql_uninstall
		if ($component->add_sql_uninstall == 1)
		{
			$this->customScriptBuilder['sql_uninstall'] = base64_decode($component->sql_uninstall);
		}
		unset($component->sql_uninstall);
		// bom
		if (ComponentbuilderHelper::checkString($component->bom))
		{
			$this->bomPath = $this->compilerPath . '/' . $component->bom;
		}
		else
		{
			$this->bomPath = $this->compilerPath . '/default.txt';
		}
		unset($component->bom);
		// README
		if ($component->addreadme)
		{
			$component->readme = base64_decode($component->readme);
		}
		else
		{
			$component->readme = '';
		}

		// set lang now
		$nowLang = $this->lang;
		$this->lang = 'admin';
		// dashboard methods
		$component->dashboard_tab = (isset($component->dashboard_tab) && ComponentbuilderHelper::checkJson($component->dashboard_tab)) ? json_decode($component->dashboard_tab, true) : null;
		if (ComponentbuilderHelper::checkArray($component->dashboard_tab))
		{
			$component->dashboard_tab = array_map(function($array)
			{
				$array['html'] = $this->setDynamicValues($array['html']);
				return $array;
			}, array_values($component->dashboard_tab));
		}
		else
		{
			$component->dashboard_tab = '';
		}
		// add the php of the dashboard if set
		if (isset($component->php_dashboard_methods) && ComponentbuilderHelper::checkString($component->php_dashboard_methods))
		{
			// load the php for the dashboard model
			$component->php_dashboard_methods = $this->setDynamicValues(base64_decode($component->php_dashboard_methods));
		}
		else
		{
			$component->php_dashboard_methods = '';
		}
		// reset back to nowlang
		$this->lang = $nowLang;

		// add the update/sales server FTP details if that is the expected protocol
		$serverArray = array('update_server', 'sales_server');
		foreach ($serverArray as $server)
		{
			if ($component->{'add_' . $server} == 1 && is_numeric($component->{$server}) && $component->{$server} > 0)
			{
				// get the server protocol
				$component->{$server . '_protocol'} = ComponentbuilderHelper::getVar('server', (int) $component->{$server}, 'id', 'protocol');
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
		if (isset($component->toignore) && ComponentbuilderHelper::checkString($component->toignore))
		{
			if (strpos($component->toignore, ',') !== false)
			{
				$component->toignore = array_map('trim', (array) explode(',', $component->toignore));
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

		// return the found component data
		return $component;
	}

	/**
	 * Get all Admin View Data
	 * 
	 * @param   int   $id  The view ID
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
			$query->join('LEFT', $this->db->quoteName('#__componentbuilder_admin_fields', 'b') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('b.admin_view') . ')');
			$query->join('LEFT', $this->db->quoteName('#__componentbuilder_admin_fields_conditions', 'c') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('c.admin_view') . ')');
			$query->join('LEFT', $this->db->quoteName('#__componentbuilder_admin_fields_relations', 'r') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('r.admin_view') . ')');
			$query->join('LEFT', $this->db->quoteName('#__componentbuilder_admin_custom_tabs', 't') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('t.admin_view') . ')');
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$view = $this->db->loadObject();

			// setup view name to use in storing the data
			$name_single = ComponentbuilderHelper::safeString($view->name_single);
			$name_list = ComponentbuilderHelper::safeString($view->name_list);

			// set upater
			$updater = array(
				'unique' => array(
					'addfields' => array('table' => 'admin_fields', 'val' => (int) $view->addfields_id, 'key' => 'id'),
					'addconditions' => array('table' => 'admin_fields_conditions', 'val' => (int) $view->addconditions_id, 'key' => 'id')
				),
				'table' => 'admin_view',
				'key' => 'id',
				'val' => (int) $id
			);
			// repeatable fields to update
			$searchRepeatables = array(
				// repeatablefield => checker
				'addfields' => 'field',
				'addconditions' => 'target_field',
				'ajax_input' => 'value_name',
				'custom_button' => 'name',
				'addlinked_views' => 'adminview',
				'addtables' => 'table',
				'addtabs' => 'name',
				'addpermissions' => 'action'
			);
			// update the repeatable fields
			$view = ComponentbuilderHelper::convertRepeatableFields($view, $searchRepeatables, $updater);

			// setup token check
			if (!isset($this->customScriptBuilder['token']))
			{
				$this->customScriptBuilder['token'] = array();
			}
			$this->customScriptBuilder['token'][$name_single] = false;
			$this->customScriptBuilder['token'][$name_list] = false;
			// set some placeholders
			$this->placeholders[$this->hhh . 'view' . $this->hhh] = ComponentbuilderHelper::safeString($name_single);
			$this->placeholders[$this->hhh . 'views' . $this->hhh] = ComponentbuilderHelper::safeString($name_list);
			$this->placeholders[$this->hhh . 'View' . $this->hhh] = ComponentbuilderHelper::safeString($name_single, 'F');
			$this->placeholders[$this->hhh . 'Views' . $this->hhh] = ComponentbuilderHelper::safeString($name_list, 'F');
			$this->placeholders[$this->hhh . 'VIEW' . $this->hhh] = ComponentbuilderHelper::safeString($name_single, 'U');
			$this->placeholders[$this->hhh . 'VIEWS' . $this->hhh] = ComponentbuilderHelper::safeString($name_list, 'U');
			$this->placeholders[$this->bbb . 'view' . $this->ddd] = $this->placeholders[$this->hhh . 'view' . $this->hhh];
			$this->placeholders[$this->bbb . 'views' . $this->ddd] = $this->placeholders[$this->hhh . 'views' . $this->hhh];
			$this->placeholders[$this->bbb . 'View' . $this->ddd] = $this->placeholders[$this->hhh . 'View' . $this->hhh];
			$this->placeholders[$this->bbb . 'Views' . $this->ddd] = $this->placeholders[$this->hhh . 'Views' . $this->hhh];
			$this->placeholders[$this->bbb . 'VIEW' . $this->ddd] = $this->placeholders[$this->hhh . 'VIEW' . $this->hhh];
			$this->placeholders[$this->bbb . 'VIEWS' . $this->ddd] = $this->placeholders[$this->hhh . 'VIEWS' . $this->hhh];
			// add the tables
			$view->addtables = (isset($view->addtables) && ComponentbuilderHelper::checkJson($view->addtables)) ? json_decode($view->addtables, true) : null;
			if (ComponentbuilderHelper::checkArray($view->addtables))
			{
				$view->tables = array_values($view->addtables);
			}
			unset($view->addtables);

			// set custom tabs
			$this->customTabs[$name_single] = null;
			$view->customtabs = (isset($view->customtabs) && ComponentbuilderHelper::checkJson($view->customtabs)) ? json_decode($view->customtabs, true) : null;
			if (ComponentbuilderHelper::checkArray($view->customtabs))
			{
				// setup custom tabs to global data sets
				$this->customTabs[$name_single] = array_map( function ($tab) use($name_single) {
					// set the view name
					$tab['view'] = $name_single;
					// load the dynamic data
					$tab['html'] = $this->setPlaceholders($this->setDynamicValues($tab['html']), $this->placeholders);
					// set the tab name
					$tab['name'] = (isset($tab['name']) && ComponentbuilderHelper::checkString($tab['name'])) ? $tab['name'] : 'Tab';
					// set lang
					$tab['lang'] = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($tab['view'], 'U') . '_' . ComponentbuilderHelper::safeString($tab['name'], 'U');
					$this->langContent['both'][$tab['lang']] = trim($tab['name']);
					// set code name
					$tab['code'] = ComponentbuilderHelper::safeString($tab['name']);
					// check if the permissions for the tab should be added
					$_tab = '';
					if (isset($tab['permission']) && $tab['permission'] == 1)
					{
						$_tab = $this->_t(1);
					}
					// check if the php of the tab is set, if not load it now
					if (strpos($tab['html'], 'bootstrap.addTab') === false && strpos($tab['html'], 'bootstrap.endTab') === false)
					{
						// add the tab
						$tmp = PHP_EOL . $_tab . $this->_t(1) . "<?php echo JHtml::_('bootstrap.addTab', '" . $tab['view'] . "Tab', '" . $tab['code'] . "', JText::_('" . $tab['lang'] . "', true)); ?>";
						$tmp .= PHP_EOL . $_tab . $this->_t(2) . '<div class="row-fluid form-horizontal-desktop">';
						$tmp .= PHP_EOL . $_tab . $this->_t(3) . '<div class="span12">';
						$tmp .= PHP_EOL . $_tab . $this->_t(4) . implode(PHP_EOL . $_tab . $this->_t(4), (array) explode(PHP_EOL, trim($tab['html'])));
						$tmp .= PHP_EOL . $_tab . $this->_t(3) . '</div>';
						$tmp .= PHP_EOL . $_tab . $this->_t(2) . '</div>';
						$tmp .= PHP_EOL . $_tab . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endTab'); ?>";
						// update html
						$tab['html'] = $tmp;
					}
					else
					{
						$tab['html'] = PHP_EOL . $_tab. $this->_t(1) . implode(PHP_EOL . $_tab. $this->_t(1), (array) explode(PHP_EOL, trim($tab['html'])));
					}
					// add the permissions if needed
					if (isset($tab['permission']) && $tab['permission'] == 1)
					{
						$tmp = PHP_EOL . $this->_t(1) . "<?php if (\$this->canDo->get('" . $tab['view'] . "." . $tab['code'] . ".viewtab')) : ?>";
						$tmp .= $tab['html'];
						$tmp .= PHP_EOL . $this->_t(1) . "<?php endif; ?>";
						// update html
						$tab['html'] = $tmp;
						// set lang for permissions
						$tab['lang_permission'] = $tab['lang'] . '_TAB_PERMISSION';
						$tab['lang_permission_desc'] = $tab['lang'] . '_TAB_PERMISSION_DESC';
						$tab['lang_permission_title'] = $this->placeholders[$this->hhh . 'Views' . $this->hhh] . ' View ' . $tab['name'] . ' Tab';
						$this->langContent['both'][$tab['lang_permission']] = $tab['lang_permission_title'];
						$this->langContent['both'][$tab['lang_permission_desc']] = 'Allow the users in this group to view ' . $tab['name'] . ' Tab of ' . $this->placeholders[$this->hhh . 'views' . $this->hhh];
						// set the sort key
						$tab['sortKey'] = ComponentbuilderHelper::safeString($tab['lang_permission_title']);
					}
					// return tab
					return $tab;
				}, array_values($view->customtabs));
			}
			unset($view->customtabs);

			// add the local tabs
			$view->addtabs = (isset($view->addtabs) && ComponentbuilderHelper::checkJson($view->addtabs)) ? json_decode($view->addtabs, true) : null;
			if (ComponentbuilderHelper::checkArray($view->addtabs))
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
			if (($removeKey = array_search('publishing', array_map('strtolower', $view->tabs))) !== false)
			{
				$view->tabs[$removeKey] = 'publishing';
			}
			// make sure to set the publishing tab (just incase we need it)
			$view->tabs[15] = 'publishing';
			unset($view->addtabs);
			// add permissions
			$view->addpermissions = (isset($view->addpermissions) && ComponentbuilderHelper::checkJson($view->addpermissions)) ? json_decode($view->addpermissions, true) : null;
			if (ComponentbuilderHelper::checkArray($view->addpermissions))
			{
				$view->permissions = array_values($view->addpermissions);
			}
			unset($view->addpermissions);
			// reset fields
			$view->fields = array();
			// set fields
			$view->addfields = (isset($view->addfields) && ComponentbuilderHelper::checkJson($view->addfields)) ? json_decode($view->addfields, true) : null;
			if (ComponentbuilderHelper::checkArray($view->addfields))
			{
				$ignoreFields = array();
				// load the field data
				$view->fields = array_map(function($field) use($name_single, $name_list, &$ignoreFields)
				{
					// set the field details
					$this->setFieldDetails($field, $name_single, $name_list);
					// check if this field is a default field OR
					// check if this is none database related field
					if (in_array($field['base_name'], $this->defaultFields) ||
						ComponentbuilderHelper::fieldCheck($field['type_name'], 'spacer') ||
						(isset($field['list']) && $field['list'] == 2)) // 2 = none database
					{
						$ignoreFields[$field['field']] = $field['field'];
					}
					// return field
					return $field;
				}, array_values($view->addfields));
				// build update SQL
				if ($old_view = $this->getHistoryWatch('admin_fields', $view->addfields_id))
				{
					// add new fields were added
					if (isset($old_view->addfields) && ComponentbuilderHelper::checkJson($old_view->addfields))
					{
						$this->setUpdateSQL(json_decode($old_view->addfields, true), $view->addfields, 'field', $name_single, $ignoreFields);
					}
					// clear this data
					unset($old_view);
				}
				// sort the fields acording to order
				usort($view->fields, function($a, $b)
				{
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
				});
				// do some house cleaning (for fields)
				foreach ($view->fields as $field)
				{
					// so first we lock the field name in
					$field_name = $this->getFieldName($field, $name_list);
					// check if the field changed since the last compilation (default fields never change and are always added)
					if (!isset($ignoreFields[$field['field']]) && ComponentbuilderHelper::checkObject($field['settings']->history))
					{
						// check if the datatype changed
						if (isset($field['settings']->history->datatype))
						{
							$this->setUpdateSQL($field['settings']->history->datatype, $field['settings']->datatype, 'field.datatype', $name_single . '.' . $field_name);
						}
						// check if the datatype lenght changed
						if (isset($field['settings']->history->datalenght) && isset($field['settings']->history->datalenght_other))
						{
							$this->setUpdateSQL($field['settings']->history->datalenght . $field['settings']->history->datalenght_other, $field['settings']->datalenght . $field['settings']->datalenght_other, 'field.lenght', $name_single . '.' . $field_name);
						}
						// check if the name changed
						if (isset($field['settings']->history->xml) && ComponentbuilderHelper::checkJson($field['settings']->history->xml))
						{
							// only run if this is not an alias or a tag
							if ((!isset($field['alias']) || !$field['alias']) && 'tag' !== $field['settings']->type_name)
							{
								// build temp field bucket
								$tmpfield = array();
								$tmpfield['settings'] = new stdClass();
								// convert the xml json string to normal string
								$tmpfield['settings']->xml = $this->setDynamicValues(json_decode($field['settings']->history->xml));
								// add properties from current field as it is generic
								$tmpfield['settings']->properties = $field['settings']->properties;
								// add the old name
								$tmpfield['settings']->name = $field['settings']->history->name;
								// add the field type from current field since it is generic
								$tmpfield['settings']->type_name = $field['settings']->type_name;
								// get the old name
								$old_field_name = $this->getFieldName($tmpfield);

								// only run this if not a multi field
								if (!isset($this->uniqueNames[$name_list]['names'][$field_name]))
								{
									// this only works when the field is not multiple of the same field
									$this->setUpdateSQL($old_field_name, $field_name, 'field.name', $name_single . '.' . $field_name);
								}
								elseif ($old_field_name !== $field_name)
								{
									// give a notice atleast that the multi fields could have changed and no DB update was done
									$this->app->enqueueMessage(JText::_('<hr /><h3>Field Notice</h3>'), 'Notice');
									$this->app->enqueueMessage(JText::sprintf('You have a field called <b>%s</b> that has been added multiple times to the <b>%s</b> view, the name of that field has changed to <b>%s</b>. Normaly we would automaticly add the update SQL to your component, but with multiple fields this does not work automaticly since it could be that noting changed and it just seems like it did. Therefore you will have to do this manualy if it actualy did change!', $field_name, $name_single, $old_field_name), 'Notice');
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
				if (ComponentbuilderHelper::checkString($old_view->name_single))
				{
					$this->setUpdateSQL(ComponentbuilderHelper::safeString($old_view->name_single), $name_single, 'table_name', $name_single);
				}
				// loop the mysql table settings
				foreach ($this->mysqlTableKeys as $_mysqlTableKey => $_mysqlTableVal)
				{
					// check if the table engine changed
					if (isset($old_view->{'mysql_table_' . $_mysqlTableKey}) && isset($view->{'mysql_table_' . $_mysqlTableKey}))
					{
						$this->setUpdateSQL( $old_view->{'mysql_table_' . $_mysqlTableKey}, $view->{'mysql_table_' . $_mysqlTableKey}, 'table_' . $_mysqlTableKey, $name_single);
					}
					// check if there is no history on table engine, and it changed from the default/global
					elseif (isset($view->{'mysql_table_' . $_mysqlTableKey}) && ComponentbuilderHelper::checkString($view->{'mysql_table_' . $_mysqlTableKey}) && !is_numeric($view->{'mysql_table_' . $_mysqlTableKey}))
					{
						$this->setUpdateSQL($_mysqlTableVal['default'], $view->{'mysql_table_' . $_mysqlTableKey}, 'table_' . $_mysqlTableKey, $name_single);
					}
				}
				// clear this data
				unset($old_view);
			}
			// set the conditions
			$view->addconditions = (isset($view->addconditions) && ComponentbuilderHelper::checkJson($view->addconditions)) ? json_decode($view->addconditions, true) : null;
			if (ComponentbuilderHelper::checkArray($view->addconditions))
			{
				$view->conditions = array();
				$ne = 0;
				foreach ($view->addconditions as $nr => $conditionValue)
				{
					if (ComponentbuilderHelper::checkArray($conditionValue['target_field']) && ComponentbuilderHelper::checkArray($view->fields))
					{
						foreach ($conditionValue['target_field'] as $fieldKey => $fieldId)
						{
							foreach ($view->fields as $fieldValues)
							{
								if ((int) $fieldValues['field'] == (int) $fieldId)
								{
									// load the field details
									$required = ComponentbuilderHelper::getBetween($fieldValues['settings']->xml, 'required="', '"');
									$required = ($required == true) ? 'yes' : 'no';
									$filter = ComponentbuilderHelper::getBetween($fieldValues['settings']->xml, 'filter="', '"');
									$filter = ComponentbuilderHelper::checkString($filter) ? $filter : 'none';
									// set the field name
									$conditionValue['target_field'][$fieldKey] = array(
										'name' => $this->getFieldName($fieldValues, $name_list),
										'type' => $this->getFieldType($fieldValues),
										'required' => $required,
										'filter' => $filter
									);
									break;
								}
							}
						}
					}

					// load match field
					if (ComponentbuilderHelper::checkArray($view->fields) && isset($conditionValue['match_field']))
					{
						foreach ($view->fields as $fieldValue)
						{
							if ((int) $fieldValue['field'] == (int) $conditionValue['match_field'])
							{
								// set the type
								$type = $this->getFieldType($fieldValue);
								// set the field details
								$conditionValue['match_name'] = $this->getFieldName($fieldValue, $name_list);
								$conditionValue['match_type'] = $type;
								$conditionValue['match_xml'] = $fieldValue['settings']->xml;
								// if custom field load field being extended
								if (!ComponentbuilderHelper::fieldCheck($type))
								{
									$conditionValue['match_extends'] = ComponentbuilderHelper::getBetween($fieldValue['settings']->xml, 'extends="', '"');
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
			$this->fieldRelations[$name_list] = array();
			$this->listJoinBuilder[$name_list] = array();
			$this->listHeadOverRide[$name_list] = array();
			// set the relations
			$view->addrelations = (isset($view->addrelations) && ComponentbuilderHelper::checkJson($view->addrelations)) ? json_decode($view->addrelations, true) : null;
			if (ComponentbuilderHelper::checkArray($view->addrelations))
			{
				foreach ($view->addrelations as $nr => $relationsValue)
				{
					// only add if list view field is selected and joind fields are set
					if (isset($relationsValue['listfield']) && is_numeric($relationsValue['listfield']) && $relationsValue['listfield'] > 0 &&
						isset($relationsValue['area']) && is_numeric($relationsValue['area']) && $relationsValue['area'] > 0)
					{
						// do a dynamic update on the set values
						if (isset($relationsValue['set']) && ComponentbuilderHelper::checkString($relationsValue['set']))
						{
							$relationsValue['set'] = $this->setDynamicValues($relationsValue['set']);
						}
						// check that the arrays are set
						if (!isset($this->fieldRelations[$name_list][(int) $relationsValue['listfield']]) || !ComponentbuilderHelper::checkArray($this->fieldRelations[$name_list][(int) $relationsValue['listfield']]))
						{
							$this->fieldRelations[$name_list][(int) $relationsValue['listfield']] = array();
						}
						// load the field relations
						$this->fieldRelations[$name_list][ (int) $relationsValue['listfield']][ (int) $relationsValue['area']] = $relationsValue;
						// load the list joints
						if (isset($relationsValue['joinfields']) && ComponentbuilderHelper::checkArray($relationsValue['joinfields']))
						{
							foreach ($relationsValue['joinfields'] as $join)
							{
								$this->listJoinBuilder[$name_list][(int) $join] = (int) $join;
							}
						}
						// set header over-ride
						if (isset($relationsValue['column_name']) && ComponentbuilderHelper::checkString($relationsValue['column_name']))
						{
							$check_column_name = trim(strtolower($relationsValue['column_name']));
							// confirm it should really make the over ride
							if ('default' !== $check_column_name)
							{
								$column_name_lang = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($name_list, 'U') . '_' . ComponentbuilderHelper::safeString($relationsValue['column_name'], 'U');
								$this->langContent['admin'][$column_name_lang] = trim($relationsValue['column_name']);
								$this->listHeadOverRide[$name_list][(int) $relationsValue['listfield']] = $column_name_lang;
							}
						}
					}
				}
			}
			unset($view->addrelations);

			// set linked views
			$this->linkedAdminViews[$name_single] = null;
			$view->addlinked_views = (isset($view->addlinked_views) && ComponentbuilderHelper::checkJson($view->addlinked_views)) ? json_decode($view->addlinked_views, true) : null;
			if (ComponentbuilderHelper::checkArray($view->addlinked_views))
			{
				// setup linked views to global data sets
				$this->linkedAdminViews[$name_single] = array_values($view->addlinked_views);
			}
			unset($view->addlinked_views);
			// set the lang target
			$this->lang = 'admin';
			if (isset($this->siteEditView[$id]))
			{
				$this->lang = 'both';
			}
			// add_javascript
			$addArrayJ = array('javascript_view_file', 'javascript_view_footer', 'javascript_views_file', 'javascript_views_footer');
			foreach ($addArrayJ as $scripter)
			{
				if (isset($view->{'add_' . $scripter}) && $view->{'add_' . $scripter} == 1 && ComponentbuilderHelper::checkString($view->$scripter))
				{
					$view->{$scripter} = $this->setDynamicValues(base64_decode($view->{$scripter}));
					$scripter_target = str_replace('javascript_', '', $scripter);
					if (!isset($this->customScriptBuilder[$scripter_target]) || !isset($this->customScriptBuilder[$scripter_target][$name_single]))
					{
						// check if the script is set
						if (!isset($this->customScriptBuilder[$scripter_target]))
						{
							$this->customScriptBuilder[$scripter_target] = array();
						}
						// check if the script view is set
						if (!isset($this->customScriptBuilder[$scripter_target][$name_single]))
						{
							$this->customScriptBuilder[$scripter_target][$name_single] = '';
						}
					}
					// load the script to class array
					$this->customScriptBuilder[$scripter_target][$name_single] .= PHP_EOL . $view->{$scripter};
					// check if a token must be set
					if (strpos($view->$scripter, "token") !== false || strpos($view->$scripter, "task=ajax") !== false)
					{
						if (!$this->customScriptBuilder['token'][$name_single])
						{
							$this->customScriptBuilder['token'][$name_single] = true;
						}
					}
					unset($view->{$scripter});
				}
			}
			// add_css
			$addArrayC = array('css_view', 'css_views');
			foreach ($addArrayC as $scripter)
			{
				if (isset($view->{'add_' . $scripter}) && $view->{'add_' . $scripter} == 1 && ComponentbuilderHelper::checkString($view->{$scripter}))
				{
					$view->{$scripter} = $this->setDynamicValues(base64_decode($view->{$scripter}));
					if (!isset($this->customScriptBuilder[$scripter]) || !isset($this->customScriptBuilder[$scripter][$name_single]))
					{
						// check if the script is set
						if (!isset($this->customScriptBuilder[$scripter]))
						{
							$this->customScriptBuilder[$scripter] = array();
						}
						// check if the script view is set
						if (!isset($this->customScriptBuilder[$scripter][$name_single]))
						{
							$this->customScriptBuilder[$scripter][$name_single] = '';
						}
					}
					// load the script to class array
					$this->customScriptBuilder[$scripter][$name_single] .= PHP_EOL . $view->{$scripter};
					unset($view->{$scripter});
				}
			}
			// add_php
			$addArrayP = array('php_getitem', 'php_before_save', 'php_save', 'php_getform', 'php_postsavehook', 'php_getitems', 'php_getitems_after_all', 'php_getlistquery', 'php_allowadd', 'php_allowedit', 'php_before_delete', 'php_after_delete', 'php_before_publish', 'php_after_publish', 'php_batchcopy', 'php_batchmove', 'php_document');
			foreach ($addArrayP as $scripter)
			{
				if (isset($view->{'add_' . $scripter}) && $view->{'add_' . $scripter} == 1)
				{
					$this->customScriptBuilder[$scripter][$name_single] = $this->setDynamicValues(base64_decode($view->$scripter));
					unset($view->$scripter);
				}
			}
			// add the custom buttons
			if (isset($view->add_custom_button) && $view->add_custom_button == 1)
			{
				// set for the edit views
				if (ComponentbuilderHelper::checkString($view->php_model))
				{
					$view->php_model = $this->setDynamicValues(base64_decode($view->php_model));
				}
				if (ComponentbuilderHelper::checkString($view->php_controller))
				{
					$view->php_controller = $this->setDynamicValues(base64_decode($view->php_controller));
				}
				// set for the list views
				if (isset($view->php_model_list) && ComponentbuilderHelper::checkString($view->php_model_list))
				{
					$view->php_model_list = $this->setDynamicValues(base64_decode($view->php_model_list));
				}
				if (isset($view->php_controller_list) && ComponentbuilderHelper::checkString($view->php_controller_list))
				{
					$view->php_controller_list = $this->setDynamicValues(base64_decode($view->php_controller_list));
				}
				// set the button array
				$view->custom_button = (isset($view->custom_button) && ComponentbuilderHelper::checkJson($view->custom_button)) ? json_decode($view->custom_button, true) : null;
				if (ComponentbuilderHelper::checkArray($view->custom_button))
				{
					$view->custom_buttons = array_values($view->custom_button);
				}
				unset($view->custom_button);
			}
			// set custom import scripts
			if (isset($view->add_custom_import) && $view->add_custom_import == 1)
			{
				$addImportArray = array('php_import_ext', 'php_import_display', 'php_import', 'php_import_setdata', 'php_import_save', 'php_import_headers', 'html_import_view');
				foreach ($addImportArray as $importScripter)
				{
					if (isset($view->$importScripter) && strlen($view->$importScripter) > 0)
					{
						$this->customScriptBuilder[$importScripter]['import_' . $name_list] = $this->setDynamicValues(base64_decode($view->$importScripter));
						unset($view->$importScripter);
					}
					else
					{
						// load the default
						$this->customScriptBuilder[$importScripter]['import_' . $name_list] = ComponentbuilderHelper::getDynamicScripts($importScripter, true);
					}
				}
			}

			// add_Ajax for this view
			if (isset($view->add_php_ajax) && $view->add_php_ajax == 1)
			{
				// insure the token is added to edit view atleast
				$this->customScriptBuilder['token'][$name_single] = true;
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
				$view->ajax_input = (isset($view->ajax_input) && ComponentbuilderHelper::checkJson($view->ajax_input)) ? json_decode($view->ajax_input, true) : null;
				if (ComponentbuilderHelper::checkArray($view->ajax_input))
				{
					if ($addAjaxSite)
					{
						$this->customScriptBuilder['site']['ajax_controller'][$name_single] = array_values($view->ajax_input);
					}
					$this->customScriptBuilder['admin']['ajax_controller'][$name_single] = array_values($view->ajax_input);
					$this->addAjax = true;
					unset($view->ajax_input);
				}
				if (ComponentbuilderHelper::checkString($view->php_ajaxmethod))
				{
					$this->customScriptBuilder['admin']['ajax_model'][$name_single] = $this->setDynamicValues(base64_decode($view->php_ajaxmethod));
					if ($addAjaxSite)
					{
						$this->customScriptBuilder['site']['ajax_model'][$name_single] = $this->customScriptBuilder['admin']['ajax_model'][$name_single];
					}
					// unset anyway
					unset($view->php_ajaxmethod);
					$this->addAjax = true;
				}
			}
			// activate alias builder
			if (!isset($this->customAliasBuilder[$name_single]) && isset($view->alias_builder_type) && 2 == $view->alias_builder_type && isset($view->alias_builder) && ComponentbuilderHelper::checkJson($view->alias_builder))
			{
				// get the aliasFields
				$alias_fields = (array) json_decode($view->alias_builder, true);
				// get the active fields
				$alias_fields = (array) array_filter($view->fields, function($field) use($alias_fields)
					{
						// check if field is in view fields
						if (in_array($field['field'], $alias_fields))
						{
							return true;
						}
						return false;
					});
				// check if all is well
				if (ComponentbuilderHelper::checkArray($alias_fields))
				{
					// load the field names
					$this->customAliasBuilder[$name_single] = (array) array_map(function ($field) use($name_list)
						{
							return $this->getFieldName($field, $name_list);
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
					$this->customScriptBuilder['sql'][$name_single] = $this->buildSqlDump($view->tables, $name_single, $id);
					unset($view->tables);
				}
				elseif ($view->source == 2 && isset($view->sql))
				{
					// add the SQL dump string
					$this->customScriptBuilder['sql'][$name_single] = base64_decode($view->sql);
					unset($view->sql);
				}
			}
			// load table settings
			if (!isset($this->mysqlTableSetting[$name_single]))
			{
				$this->mysqlTableSetting[$name_single] = array();
			}
			// set mySql Table Settings
			foreach ($this->mysqlTableKeys as $_mysqlTableKey => $_mysqlTableVal)
			{
				if (isset($view->{'mysql_table_' . $_mysqlTableKey}) && ComponentbuilderHelper::checkString($view->{'mysql_table_' . $_mysqlTableKey}) && !is_numeric($view->{'mysql_table_' . $_mysqlTableKey}))
				{
					$this->mysqlTableSetting[$name_single][$_mysqlTableKey] = $view->{'mysql_table_' . $_mysqlTableKey};
				}
				else
				{
					$this->mysqlTableSetting[$name_single][$_mysqlTableKey] = $_mysqlTableVal['default'];
				}
				// remove the table values since we moved to another object
				unset($view->{'mysql_table_' . $_mysqlTableKey});
			}
			// clear placeholders
			unset($this->placeholders[$this->hhh . 'view' . $this->hhh]);
			unset($this->placeholders[$this->hhh . 'views' . $this->hhh]);
			unset($this->placeholders[$this->hhh . 'View' . $this->hhh]);
			unset($this->placeholders[$this->hhh . 'Views' . $this->hhh]);
			unset($this->placeholders[$this->hhh . 'VIEW' . $this->hhh]);
			unset($this->placeholders[$this->hhh . 'VIEWS' . $this->hhh]);
			unset($this->placeholders[$this->bbb . 'view' . $this->ddd]);
			unset($this->placeholders[$this->bbb . 'views' . $this->ddd]);
			unset($this->placeholders[$this->bbb . 'View' . $this->ddd]);
			unset($this->placeholders[$this->bbb . 'Views' . $this->ddd]);
			unset($this->placeholders[$this->bbb . 'VIEW' . $this->ddd]);
			unset($this->placeholders[$this->bbb . 'VIEWS' . $this->ddd]);

			// store this view to class object
			$this->_adminViewData[$id] = $view;
		}
		// return the found view data
		return $this->_adminViewData[$id];
	}

	/**
	 * Get all Custom View Data
	 * 
	 * @param   int      $id  The view ID
	 * @param   string   $table  The view table
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

		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$view = $this->db->loadObject();
		if ($table === 'site_view')
		{
			$this->lang = 'site';
			// repeatable fields to update
			$searchRepeatables = array(
				// repeatablefield => checker
				'ajax_input' => 'value_name',
				'custom_button' => 'name'
			);
		}
		else
		{
			$this->lang = 'admin';
			// repeatable fields to update
			$searchRepeatables = array(
				// repeatablefield => checker
				'custom_button' => 'name'
			);
		}
		// set upater
		$updater = array(
			'table' => $table,
			'key' => 'id',
			'val' => (int) $id
		);
		// update the repeatable fields
		$view = ComponentbuilderHelper::convertRepeatableFields($view, $searchRepeatables, $updater);

		// set the default data
		$view->default = $this->setDynamicValues(base64_decode($view->default));
		// fix alias to use in code
		$view->code = $this->uniqueCode(ComponentbuilderHelper::safeString($view->codename));
		$view->Code = ComponentbuilderHelper::safeString($view->code, 'F');
		$view->CODE = ComponentbuilderHelper::safeString($view->code, 'U');
		// load context if not set
		if (!isset($view->context) || !ComponentbuilderHelper::checkString($view->context))
		{
			$view->context = $view->code;
		}
		else
		{
			// always make sure context is a safe string
			$view->context = ComponentbuilderHelper::safeString($view->context);
		}
		// load the library
		if (!isset($this->libManager[$this->target]))
		{
			$this->libManager[$this->target] = array();
		}
		if (!isset($this->libManager[$this->target][$view->code]))
		{
			$this->libManager[$this->target][$view->code] = array();
		}
		// make sure json become array
		if (ComponentbuilderHelper::checkJson($view->libraries))
		{
			$view->libraries = json_decode($view->libraries, true);
		}
		// if we have an array add it
		if (ComponentbuilderHelper::checkArray($view->libraries))
		{
			foreach ($view->libraries as $library)
			{
				if (!isset($this->libManager[$this->target][$view->code][$library]))
				{
					if ($this->getLibrary((int) $library))
					{
						$this->libManager[$this->target][$view->code][(int) $library] = true;
					}
				}
			}
		}
		elseif (is_numeric($view->libraries) && !isset($this->libManager[$this->target][$view->code][(int) $view->libraries]))
		{
			if ($this->getLibrary((int) $view->libraries))
			{
				$this->libManager[$this->target][$view->code][(int) $view->libraries] = true;
			}
		}
		// setup template array
		$this->templateData[$this->target][$view->code] = array();
		// setup template and layout data
		$this->setTemplateAndLayoutData($view->default, $view->code);
		// insure the uikit components are loaded
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			if (!isset($this->uikitComp[$view->code]))
			{
				$this->uikitComp[$view->code] = array();
			}
			$this->uikitComp[$view->code] = ComponentbuilderHelper::getUikitComp($view->default, $this->uikitComp[$view->code]);
		}
		// check for footable
		if (!isset($this->footableScripts[$this->target][$view->code]) || !$this->footableScripts[$this->target][$view->code])
		{
			$foundFoo = $this->getFootableScripts($view->default);
			if ($foundFoo)
			{
				$this->footableScripts[$this->target][$view->code] = true;
			}
			if ($foundFoo && !$this->footableScripts)
			{
				$this->footable = true;
			}
		}
		// check for get module
		if (!isset($this->getModule[$this->target][$view->code]) || !$this->getModule[$this->target][$view->code])
		{
			$found = $this->getGetModule($view->default);
			if ($found)
			{
				$this->getModule[$this->target][$view->code] = true;
			}
		}
		// set the main get data
		$main_get = $this->setGetData(array($view->main_get), $view->code, $view->context);
		$view->main_get = $main_get[0];
		// set the custom_get data
		$view->custom_get = $this->setGetData(json_decode($view->custom_get, true), $view->code, $view->context);
		// set array adding array of scripts
		$addArray = array('php_view', 'php_jview', 'php_jview_display', 'php_document', 'javascript_file', 'js_document', 'css_document', 'css');
		foreach ($addArray as $scripter)
		{
			if (isset($view->{'add_' . $scripter}) && $view->{'add_' . $scripter} == 1 && ComponentbuilderHelper::checkString($view->$scripter))
			{
				$view->$scripter = $this->setDynamicValues(base64_decode($view->$scripter));
				if (2 == $this->uikit || 1 == $this->uikit)
				{
					if (!isset($this->uikitComp[$view->code]))
					{
						$this->uikitComp[$view->code] = array();
					}
					// set uikit to views
					$this->uikitComp[$view->code] = ComponentbuilderHelper::getUikitComp($view->$scripter, $this->uikitComp[$view->code]);
				}

				$this->setTemplateAndLayoutData($view->$scripter, $view->code);

				// check for footable
				if (!isset($this->footableScripts[$this->target][$view->code]) || !$this->footableScripts[$this->target][$view->code])
				{
					$foundFoo = $this->getFootableScripts($view->$scripter);
					if ($foundFoo)
					{
						$this->footableScripts[$this->target][$view->code] = true;
					}
					if ($foundFoo && !$this->footable)
					{
						$this->footable = true;
					}
				}
				// check for google chart
				if (!isset($this->googleChart[$this->target][$view->code]) || !$this->googleChart[$this->target][$view->code])
				{
					$found = $this->getGoogleChart($view->$scripter);
					if ($found)
					{
						$this->googleChart[$this->target][$view->code] = true;
					}
					if ($found && !$this->googlechart)
					{
						$this->googlechart = true;
					}
				}
				// check for get module
				if (!isset($this->getModule[$this->target][$view->code]) || !$this->getModule[$this->target][$view->code])
				{
					$found = $this->getGetModule($view->$scripter);
					if ($found)
					{
						$this->getModule[$this->target][$view->code] = true;
					}
				}
			}
		}
		// add_Ajax for this view
		if (isset($view->add_php_ajax) && $view->add_php_ajax == 1)
		{
			// ajax target (since we only have two options really)
			if ('site' === $this->target)
			{
				$target = 'site';
			}
			else
			{
				$target = 'admin';
			}
			$setAjax = false;
			// check if controller input as been set
			$view->ajax_input = (isset($view->ajax_input) && ComponentbuilderHelper::checkJson($view->ajax_input)) ? json_decode($view->ajax_input, true) : null;
			if (ComponentbuilderHelper::checkArray($view->ajax_input))
			{
				$this->customScriptBuilder[$target]['ajax_controller'][$view->code] = array_values($view->ajax_input);
				$setAjax = true;
			}
			unset($view->ajax_input);
			// load the ajax class mathods (if set)
			if (ComponentbuilderHelper::checkString($view->php_ajaxmethod))
			{
				$this->customScriptBuilder[$target]['ajax_model'][$view->code] = $this->setDynamicValues(base64_decode($view->php_ajaxmethod));
				$setAjax = true;
			}
			// unset anyway
			unset($view->php_ajaxmethod);
			// should ajax be set
			if ($setAjax)
			{
				// turn on ajax area
				if ('site' === $this->target)
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
			if (ComponentbuilderHelper::checkString($view->php_model))
			{
				$view->php_model = base64_decode($view->php_model);
				$view->php_model = $this->setDynamicValues($view->php_model);
			}
			$view->php_controller = base64_decode($view->php_controller);
			$view->php_controller = $this->setDynamicValues($view->php_controller);
			// set the button array
			$view->custom_button = (isset($view->custom_button) && ComponentbuilderHelper::checkJson($view->custom_button)) ? json_decode($view->custom_button, true) : null;
			if (ComponentbuilderHelper::checkArray($view->custom_button))
			{
				$view->custom_buttons = array_values($view->custom_button);
			}
			unset($view->custom_button);
		}
		// return the found view data
		return $view;
	}

	/**
	 * Get all Field Data
	 * 
	 * @param   int      $id  The field ID
	 * @param   string   $name_single The view edit or single name
	 * @param   string   $name_list  The view list name
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
			$query->select($this->db->quoteName(array('c.name', 'c.properties'), array('type_name', 'properties')));
			$query->from('#__componentbuilder_field AS a');
			$query->join('LEFT', $this->db->quoteName('#__componentbuilder_fieldtype', 'c') . ' ON (' . $this->db->quoteName('a.fieldtype') . ' = ' . $this->db->quoteName('c.id') . ')');
			$query->where($this->db->quoteName('a.id') . ' = ' . $this->db->quote($id));

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// Load the results as a list of stdClass objects (see later for more options on retrieving data).
				$field = $this->db->loadObject();

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
					'key' => 'id',
					'val' => (int) $id
				);
				// update the repeatable fields
				$field = ComponentbuilderHelper::convertRepeatableFields($field, $searchRepeatables, $updater);

				// load the values form params
				$field->xml = $this->setDynamicValues(json_decode($field->xml));

				// check if we have validate (validation rule set)
				$validationRule = ComponentbuilderHelper::getBetween($field->xml, 'validate="', '"');
				if (ComponentbuilderHelper::checkString($validationRule))
				{
					// make sure it is lowercase
					$validationRule = ComponentbuilderHelper::safeString($validationRule);
					// make sure it is not already set
					if (!isset($this->validationRules[$validationRule]))
					{
						// get joomla core validation names
						if ($coreValidationRules = ComponentbuilderHelper::getExistingValidationRuleNames(true))
						{
							// make sure this rule is not a core validation rule
							if (!in_array($validationRule, (array) $coreValidationRules))
							{
								// get the class methods for this rule if it exists
								if ($this->validationRules[$validationRule] = ComponentbuilderHelper::getVar('validation_rule', $validationRule, 'name', 'php'))
								{
									// open and set the validation rule
									$this->validationRules[$validationRule] = $this->setPlaceholders($this->setDynamicValues(base64_decode($this->validationRules[$validationRule])), $this->placeholders);
								}
								else
								{
									// set the notice that this validation rule is custom and was not found (TODO)
								}
							}
						}
					}
				}

				// load the type values form type params
				$field->properties = (isset($field->properties) && ComponentbuilderHelper::checkJson($field->properties)) ? json_decode($field->properties, true) : null;
				if (ComponentbuilderHelper::checkArray($field->properties))
				{
					$field->properties = array_values($field->properties);
				}
				// check if we have WHMCS encryption
				if (4 == $field->store && (!isset($this->whmcsEncryption) || !$this->whmcsEncryption))
				{
					$this->whmcsEncryption = true;
				}
				// check if we have basic encryption
				elseif (3 == $field->store && (!isset($this->basicEncryption) || !$this->basicEncryption))
				{
					$this->basicEncryption = true;
				}
				// check if we have better encryption
				elseif (5 == $field->store && (!isset($this->mediumEncryption) || !$this->mediumEncryption))
				{
					$this->mediumEncryption = true;
				}

				// get the last used version
				$field->history = $this->getHistoryWatch('field', $id);

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
			if (ComponentbuilderHelper::checkString($name_single) && !isset($this->customFieldScript[$name_single][$id]))
			{
				// add_javascript_view_footer
				if ($this->_fieldData[$id]->add_javascript_view_footer == 1 && ComponentbuilderHelper::checkString($this->_fieldData[$id]->javascript_view_footer))
				{
					if (!isset($this->customScriptBuilder['view_footer']))
					{
						$this->customScriptBuilder['view_footer'] = array();
					}
					if (!isset($this->customScriptBuilder['view_footer'][$name_single]))
					{
						$this->customScriptBuilder['view_footer'][$name_single] = '';
					}
					if (!isset($this->_fieldData[$id]->javascript_view_footer_decoded))
					{
						$this->_fieldData[$id]->javascript_view_footer = $this->setDynamicValues(base64_decode($this->_fieldData[$id]->javascript_view_footer));
						$this->_fieldData[$id]->javascript_view_footer_decoded = true;
					}
					$this->customScriptBuilder['view_footer'][$name_single] .= PHP_EOL . $this->_fieldData[$id]->javascript_view_footer;
					if (strpos($this->_fieldData[$id]->javascript_view_footer, "token") !== false ||
						strpos($this->_fieldData[$id]->javascript_view_footer, "task=ajax") !== false)
					{
						if (!isset($this->customScriptBuilder['token']))
						{
							$this->customScriptBuilder['token'] = array();
						}
						if (!isset($this->customScriptBuilder['token'][$name_single]) || !$this->customScriptBuilder['token'][$name_single])
						{
							$this->customScriptBuilder['token'][$name_single] = true;
						}
					}
				}

				// add_css_view
				if ($this->_fieldData[$id]->add_css_view == 1)
				{
					if (!isset($this->customScriptBuilder['css_view']))
					{
						$this->customScriptBuilder['css_view'] = array();
					}
					if (!isset($this->customScriptBuilder['css_view'][$name_single]))
					{
						$this->customScriptBuilder['css_view'][$name_single] = '';
					}
					if (!isset($this->_fieldData[$id]->css_view_decoded))
					{
						$this->_fieldData[$id]->css_view = base64_decode($this->_fieldData[$id]->css_view);
						// check for custom code
						$this->setCustomCodeData($this->_fieldData[$id]->css_view);
						$this->_fieldData[$id]->css_view_decoded = true;
					}
					$this->customScriptBuilder['css_view'][$name_single] .= PHP_EOL . $this->_fieldData[$id]->css_view;
				}

				// add this only once to view.
				$this->customFieldScript[$name_single][$id] = true;
			}
			// check if we should load scripts for list views
			if (ComponentbuilderHelper::checkString($name_list) && !isset($this->customFieldScript[$name_list][$id]))
			{
				// add_javascript_views_footer
				if ($this->_fieldData[$id]->add_javascript_views_footer == 1 && ComponentbuilderHelper::checkString($this->_fieldData[$id]->javascript_views_footer))
				{
					if (!isset($this->customScriptBuilder['views_footer']))
					{
						$this->customScriptBuilder['views_footer'] = array();
					}
					if (!isset($this->customScriptBuilder['views_footer'][$name_single]))
					{
						$this->customScriptBuilder['views_footer'][$name_single] = '';
					}
					if (!isset($this->_fieldData[$id]->javascript_views_footer_decoded))
					{
						$this->_fieldData[$id]->javascript_views_footer = $this->setDynamicValues(base64_decode($this->_fieldData[$id]->javascript_views_footer));
						$this->_fieldData[$id]->javascript_views_footer_decoded = true;
					}
					$this->customScriptBuilder['views_footer'][$name_single] .= PHP_EOL . $this->_fieldData[$id]->javascript_views_footer;
					if (strpos($this->_fieldData[$id]->javascript_views_footer, "token") !== false ||
						strpos($this->_fieldData[$id]->javascript_views_footer, "task=ajax") !== false)
					{
						if (!isset($this->customScriptBuilder['token']))
						{
							$this->customScriptBuilder['token'] = array();
						}
						if (!isset($this->customScriptBuilder['token'][$name_list]) || !$this->customScriptBuilder['token'][$name_list])
						{
							$this->customScriptBuilder['token'][$name_list] = true;
						}
					}
				}
				// add_css_views
				if ($this->_fieldData[$id]->add_css_views == 1)
				{
					if (!isset($this->customScriptBuilder['css_views']))
					{
						$this->customScriptBuilder['css_views'] = array();
					}
					if (!isset($this->customScriptBuilder['css_views'][$name_list]))
					{
						$this->customScriptBuilder['css_views'][$name_list] = '';
					}
					if (!isset($this->_fieldData[$id]->css_views_decoded))
					{
						$this->_fieldData[$id]->css_views = base64_decode($this->_fieldData[$id]->css_views);
						// check for custom code
						$this->setCustomCodeData($this->_fieldData[$id]->css_views);
						$this->_fieldData[$id]->css_views_decoded = true;
					}
					$this->customScriptBuilder['css_views'][$name_list] .= PHP_EOL . $this->_fieldData[$id]->css_views;
				}

				// add this only once to view.
				$this->customFieldScript[$name_list][$id] = true;
			}
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
	 * @param   object   $field           The field object
	 * @param   string   $singleViewName  The single view name
	 * @param   string   $listViewName    The list view name
	 * @param   string   $amicably        The peaceful resolve
	 * 
	 * @return  void
	 * 
	 */
	public function setFieldDetails(&$field, $singleViewName = null, $listViewName = null, $amicably = '')
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
			$field['settings'] = $this->getFieldData($field['field'], $singleViewName, $listViewName);
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
		if (isset($field['permission']) && !ComponentbuilderHelper::checkArray($field['permission']) && is_numeric($field['permission']) && $field['permission'] > 0)
		{
			$field['permission'] = array($field['permission']);
		}
		// set unigue name keeper
		if ($listViewName)
		{
			$this->setUniqueNameCounter($field['base_name'], $listViewName . $amicably);
		}
	}

	/**
	 * Get the field's actual type
	 * 
	 * @param   object   $field   The field object
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
		if (isset($field['settings']) && ComponentbuilderHelper::checkObject($field['settings']) && isset($field['settings']->properties) && ComponentbuilderHelper::checkArray($field['settings']->properties))
		{
			// search for own custom fields
			if (strpos($field['settings']->type_name, '@') !== false)
			{
				// set own custom field
				$field['settings']->own_custom = $field['settings']->type_name;
				$field['settings']->type_name = 'Custom';
			}
			// set the type name
			$type_name = ComponentbuilderHelper::safeString($field['settings']->type_name);
			// if custom (we must use the xml value)
			if ($type_name === 'custom' || $type_name === 'customuser')
			{
				$type = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($field['settings']->xml, 'type="', '"'));
			}
			else
			{
				// loop over properties looking for the type value
				foreach ($field['settings']->properties as $property)
				{
					if ($property['name'] === 'type') // type field is never ajustable (unless custom)
					{
						// force the default value
						if (isset($property['example']) && ComponentbuilderHelper::checkString($property['example']))
						{
							$type = ComponentbuilderHelper::safeString($property['example']);
						}
						// fallback on type name set in name field
						elseif (ComponentbuilderHelper::checkString($type_name))
						{
							$type = $type_name;
						}
						// fall back on the xml settings (not ideal)
						else
						{
							$type = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xml, 'type="', '"'));
						}
						// exit foreach loop
						break;
					}
				}
			}
			// check if the value is set
			if (ComponentbuilderHelper::checkString($type))
			{
				// add the value
				return $type;
			}
		}
		// fall back to text
		return 'text';
	}

	/**
	 * Get the field's actual name
	 * 
	 * @param   object   $field         The field object
	 * @param   string   $listViewName  The list view name
	 * @param   string   $amicably      The peaceful resolve
	 * 
	 * @return  string   Success returns field name
	 * 
	 */
	public function getFieldName(&$field, $listViewName = null, $amicably = '')
	{
		// return the unique name if already set
		if (ComponentbuilderHelper::checkString($listViewName) && isset($field['hash']) && isset($this->uniqueFieldNames[$listViewName . $amicably . $field['hash']]))
		{
			return $this->uniqueFieldNames[$listViewName . $amicably . $field['hash']];
		}
		// always make sure we have a field name and type
		if (!isset($field['settings']) || !isset($field['settings']->type_name) || !isset($field['settings']->name))
		{
			return 'error';
		}
		// set the type name
		$type_name = ComponentbuilderHelper::safeString($field['settings']->type_name);
		// set the name of the field
		$name = ComponentbuilderHelper::safeString($field['settings']->name);
		// check that we have the poperties
		if (ComponentbuilderHelper::checkArray($field['settings']->properties))
		{
			foreach ($field['settings']->properties as $property)
			{
				if ($property['name'] === 'name')
				{
					// if category then name must be catid (only one per view)
					if ($type_name === 'category')
					{
						// quick check if this is a category linked to view page
						$requeSt_id = ComponentbuilderHelper::getBetween($field['settings']->xml, 'name="', '"');
						if (strpos($requeSt_id, '_request_id') !== false || strpos($requeSt_id, '_request_catid') !== false)
						{
							// keep it then, don't change
							$name = $this->setPlaceholders($requeSt_id, $this->placeholders);
						}
						else
						{
							$name = 'catid';
						}
						// if list view name is set
						if (ComponentbuilderHelper::checkString($listViewName))
						{
							// check if we should use another Text Name as this views name
							$otherName = ComponentbuilderHelper::getBetween($field['settings']->xml, 'othername="', '"');
							$otherViews = ComponentbuilderHelper::getBetween($field['settings']->xml, 'views="', '"');
							$otherView = ComponentbuilderHelper::getBetween($field['settings']->xml, 'view="', '"');
							if (ComponentbuilderHelper::checkString($otherName) && ComponentbuilderHelper::checkString($otherViews) && ComponentbuilderHelper::checkString($otherView))
							{
								$this->catOtherName[$listViewName] = array(
									'name' => ComponentbuilderHelper::safeString($otherName),
									'views' => ComponentbuilderHelper::safeString($otherViews),
									'view' => ComponentbuilderHelper::safeString($otherView)
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
						$xml = ComponentbuilderHelper::safeString($this->setPlaceholders(ComponentbuilderHelper::getBetween($field['settings']->xml, 'name="', '"'), $this->placeholders));
						// check if a value was found
						if (ComponentbuilderHelper::checkString($xml))
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
		if (ComponentbuilderHelper::checkString($listViewName) && isset($field['hash']))
		{
			$this->uniqueFieldNames[$listViewName . $amicably . $field['hash']] = $this->uniqueName($name, $listViewName . $amicably);
			// now return the unique name
			return $this->uniqueFieldNames[$listViewName . $amicably . $field['hash']];
		}
		// fall back to global
		return $name;
	}

	/**
	 * Count how many times the same field is used per view
	 *
	 * @param   string   $name The name of the field
	 * @param   string   $view The name of the view
	 *
	 * @return  void
	 *
	 */
	protected function setUniqueNameCounter($name, $view)
	{
		if (!isset($this->uniqueNames[$view]))
		{
			$this->uniqueNames[$view] = array();
			$this->uniqueNames[$view]['counter'] = array();
			$this->uniqueNames[$view]['names'] = array();
		}
		if (!isset($this->uniqueNames[$view]['counter'][$name]))
		{
			$this->uniqueNames[$view]['counter'][$name] = 1;
			return;
		}
		// count how many times the field is used
		$this->uniqueNames[$view]['counter'][$name] ++;
		return;
	}

	/**
	 * Naming each field with an unique name
	 *
	 * @param   string   $name The name of the field
	 * @param   string   $view The name of the view
	 *
	 * @return  string   the name
	 *
	 */
	protected function uniqueName($name, $view)
	{
		// only increment if the field name is used multiple times
		if (isset($this->uniqueNames[$view]['counter'][$name]) && $this->uniqueNames[$view]['counter'][$name] > 1)
		{
			$counter = 1;
			// set the unique name
			$uniqueName = ComponentbuilderHelper::safeString($name . '_' . $counter);
			while (isset($this->uniqueNames[$view]['names'][$uniqueName]))
			{
				// increment the number
				$counter++;
				// try again
				$uniqueName = ComponentbuilderHelper::safeString($name . '_' . $counter);
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
	 * @param   array    $ids        The ids of the dynamic get
	 * @param   string   $view_code  The view code name
	 * @param   string   $context    The context for events
	 *
	 * @return  oject the get dynamicGet data
	 * 
	 */
	public function setGetData($ids, $view_code, $context)
	{
		if (ComponentbuilderHelper::checkArray($ids))
		{
			$ids = implode(',', $ids);
			if (ComponentbuilderHelper::checkString($ids))
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
					$results = $this->db->loadObjectList();
					$typeArray = array(1 => 'LEFT', 2 => 'LEFT OUTER', 3 => 'INNER', 4 => 'RIGHT', 5 => 'RIGHT OUTER');
					$operatorArray = array(1 => '=', 2 => '!=', 3 => '<>', 4 => '>', 5 => '<', 6 => '>=', 7 => '<=', 8 => '!<', 9 => '!>', 10 => 'IN', 11 => 'NOT IN');
					foreach ($results as $_nr => &$result)
					{
						// add calculations if set
						if ($result->addcalculation == 1 && ComponentbuilderHelper::checkString($result->php_calculation))
						{
							$result->php_calculation = $this->setDynamicValues(base64_decode($result->php_calculation));
						}
						// The array of the php scripts that should be added to the script builder
						$phpSripts = array('php_before_getitem', 'php_after_getitem', 'php_before_getitems', 'php_after_getitems', 'php_getlistquery');
						// load the php scripts
						foreach ($phpSripts as $script)
						{
							// add php script to the script builder
							if (isset($result->{'add_' . $script}) && $result->{'add_' . $script} == 1 && isset($result->{$script}) && ComponentbuilderHelper::checkString($result->{$script}))
							{
								// move all main gets out to the customscript builder
								if ($result->gettype <= 2)
								{
									if (!isset($this->customScriptBuilder[$this->target . '_' . $script][$view_code]))
									{
										$this->customScriptBuilder[$this->target . '_' . $script][$view_code] = '';
									}
									$this->customScriptBuilder[$this->target . '_' . $script][$view_code] .= $this->setDynamicValues(PHP_EOL . PHP_EOL . base64_decode($result->{$script}));
									// remove from local item
									unset($result->{$script});
									unset($result->{'add_' . $script});
								}
								else
								{
									// only for custom gets
									$result->{$script} = $this->setDynamicValues(PHP_EOL . base64_decode($result->{$script}));
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
						$result->key = ComponentbuilderHelper::safeString($view_code . ' ' . $result->name . ' ' . $result->id);
						// reset buckets
						$result->main_get = array();
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
								$result->main_get[0]['selection'] = $this->setDataSelection($result->key, $view_code, $result->view_selection, $result->view_table_main, 'a', null, 'view');
								$result->main_get[0]['as'] = 'a';
								$result->main_get[0]['key'] = $result->key;
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
								$result->main_get[0]['selection'] = $this->setDataSelection($result->key, $view_code, $result->db_selection, $result->db_table_main, 'a', null, 'db');
								$result->main_get[0]['as'] = 'a';
								$result->main_get[0]['key'] = $result->key;
								$result->main_get[0]['context'] = $context;
								unset($result->db_selection);
								break;
							case 3:
								// get the custom query
								$customQueryString = $this->setDynamicValues(base64_decode($result->php_custom_get));
								// get the table name
								$_searchQuery = ComponentbuilderHelper::getBetween($customQueryString, '$query->from(', ')');
								if (ComponentbuilderHelper::checkString($_searchQuery) && strpos($_searchQuery, '#__') !== false)
								{
									$_queryName = ComponentbuilderHelper::getBetween($_searchQuery, '#__', "'");
									if (!ComponentbuilderHelper::checkString($_queryName))
									{
										$_queryName = ComponentbuilderHelper::getBetween($_searchQuery, '#__', '"');
									}
								}
								// set to blank if not found
								if (!isset($_queryName) || !ComponentbuilderHelper::checkString($_queryName))
								{
									$_queryName = '';
								}
								// set custom script
								$result->main_get[0]['selection'] = array(
									'select' => $customQueryString,
									'from' => '', 'table' => '', 'type' => '', 'name' => $_queryName);
								$result->main_get[0]['as'] = 'a';
								$result->main_get[0]['key'] = $result->key;
								$result->main_get[0]['context'] = $context;
								// do not add
								$addDynamicTweaksJoints = false;
								break;
						}
						// only add if main source is not custom
						if ($addDynamicTweaksJoints)
						{
							// set join_view_table details
							$result->join_view_table = json_decode($result->join_view_table, true);
							if (ComponentbuilderHelper::checkArray($result->join_view_table))
							{
								foreach ($result->join_view_table as $nr => &$option)
								{
									if (ComponentbuilderHelper::checkString($option['selection']))
									{
										// convert the type
										$option['type'] = $typeArray[$option['type']];
										// convert the operator
										$option['operator'] = $operatorArray[$option['operator']];
										// get the on field values
										$on_field = array(); // array(on_field_as, on_field)
										$on_field = array_map('trim', explode('.', $option['on_field']));
										// get the join field values
										$join_field = array(); // array(join_field_as, join_field) 
										$join_field = array_map('trim', explode('.', $option['join_field']));
										$option['selection'] = $this->setDataSelection($result->key, $view_code, $option['selection'], $option['view_table'], $option['as'], $option['row_type'], 'view');
										$option['key'] = $result->key;
										$option['context'] = $context;
										// load to the getters
										if ($option['row_type'] == 1)
										{
											$result->main_get[] = $option;
											if ($on_field[0] === 'a')
											{
												$this->siteMainGet[$this->target][$view_code][$option['as']] = $option['as'];
											}
											else
											{
												$this->siteDynamicGet[$this->target][$view_code][$option['as']][$join_field[1]] = $on_field[0];
											}
										}
										elseif ($option['row_type'] == 2)
										{
											$result->custom_get[] = $option;
											if ($on_field[0] != 'a')
											{
												$this->siteDynamicGet[$this->target][$view_code][$option['as']][$join_field[1]] = $on_field[0];
											}
										}
									}
									unset($result->join_view_table[$nr]);
								}
							}
							unset($result->join_view_table);
							// set join_db_table details
							$result->join_db_table = json_decode($result->join_db_table, true);
							if (ComponentbuilderHelper::checkArray($result->join_db_table))
							{
								foreach ($result->join_db_table as $nr => &$option1)
								{
									if (ComponentbuilderHelper::checkString($option1['selection']))
									{
										// convert the type
										$option1['type'] = $typeArray[$option1['type']];
										// convert the operator
										$option1['operator'] = $operatorArray[$option1['operator']];
										// get the on field values
										$on_field = array(); // array(on_field_as, on_field)
										$on_field = array_map('trim', explode('.', $option1['on_field']));
										// get the join field values
										$join_field = array(); // array(join_field_as, join_field) 
										$join_field = array_map('trim', explode('.', $option1['join_field']));
										$option1['selection'] = $this->setDataSelection($result->key, $view_code, $option1['selection'], $option1['db_table'], $option1['as'], $option1['row_type'], 'db');
										$option1['key'] = $result->key;
										$option1['context'] = $context;
										// load to the getters
										if ($option1['row_type'] == 1)
										{
											$result->main_get[] = $option1;
											if ($on_field[0] === 'a')
											{
												$this->siteMainGet[$this->target][$view_code][$option1['as']] = $option1['as'];
											}
											else
											{
												$this->siteDynamicGet[$this->target][$view_code][$option1['as']][$join_field[1]] = $on_field[0];
											}
										}
										elseif ($option1['row_type'] == 2)
										{
											$result->custom_get[] = $option1;
											if ($on_field[0] != 'a')
											{
												$this->siteDynamicGet[$this->target][$view_code][$option1['as']][$join_field[1]] = $on_field[0];
											}
										}
									}
									unset($result->join_db_table[$nr]);
								}
							}
							unset($result->join_db_table);
							// set filter details
							$result->filter = json_decode($result->filter, true);
							if (ComponentbuilderHelper::checkArray($result->filter))
							{
								foreach ($result->filter as $nr => &$option2)
								{
									if (isset($option2['operator']))
									{
										$option2['operator'] = $operatorArray[$option2['operator']];
										$option2['state_key'] = $this->setPlaceholders($this->setDynamicValues($option2['state_key']), $this->placeholders);
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
							if (ComponentbuilderHelper::checkArray($result->where))
							{
								foreach ($result->where as $nr => &$option3)
								{
									if (isset($option3['operator']))
									{
										$option3['operator'] = $operatorArray[$option3['operator']];
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
							if (!ComponentbuilderHelper::checkArray($result->order))
							{
								unset($result->order);
							}
							// set grouping
							$result->group = json_decode($result->group, true);
							if (!ComponentbuilderHelper::checkArray($result->group))
							{
								unset($result->group);
							}
							// set global details
							$result->global = json_decode($result->global, true);
							if (!ComponentbuilderHelper::checkArray($result->global))
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
						if ($result->gettype == 1 && ComponentbuilderHelper::checkJson($result->plugin_events))
						{
							$result->plugin_events = json_decode($result->plugin_events, true);
						}
						else
						{
							$result->plugin_events = '';
						}
					}
					return $results;
				}
			}
		}
		return false;
	}

	/**
	 * To limit the SQL Demo date build in the views
	 * 
	 * @param   array   $settings  Tweaking array.
	 *
	 * @return  void
	 * 
	 */
	public function setSqlTweaking($settings)
	{
		if (ComponentbuilderHelper::checkArray($settings))
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
							$id_array = (array) array_map('trim', explode(',', $ids));
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
								$id_range = (array) array_map('trim', explode('=>', $id));
								unset($id_array[$key]);
								// build range
								if (count($id_range) == 2)
								{
									$range = range($id_range[0], $id_range[1]);
									$id_array_new = array_merge($id_array_new, $range);
								}
							}
						}
						if (ComponentbuilderHelper::checkArray($id_array_new))
						{
							$id_array = array_merge($id_array_new, $id_array);
						}
						// final fixing to array
						if (ComponentbuilderHelper::checkArray($id_array))
						{
							// uniqe
							$id_array = array_unique($id_array, SORT_NUMERIC);
							// sort
							sort($id_array, SORT_NUMERIC);
							// now set it to global
							$this->sqlTweak[(int) $setting['adminview']]['where'] = implode(',', $id_array);
						}
					}
				}
				else
				{
					// remove all sql dump options
					$this->sqlTweak[(int) $setting['adminview']]['remove'] = true;
				}
			}
		}
	}

	/**
	 * check if an update SQL is needed
	 * 
	 * @param   mix      $old    The old values
	 * @param   mix      $new    The new values
	 * @param   string   $type   The type of values
	 * @param   int      $key    The id/key where values changed
	 * @param   array    $ignore The ids to ignore
	 *
	 * @return  void
	 * 
	 */
	protected function setUpdateSQL($old, $new, $type, $key = null, $ignore = null)
	{
		// check if there were new items added
		if (ComponentbuilderHelper::checkArray($new) && ComponentbuilderHelper::checkArray($old))
		{
			// check if this is old repeatable field
			if (isset($new[$type]))
			{
				foreach ($new[$type] as $item)
				{
					$newItem = true;
					// check if this is an id to ignore
					if (ComponentbuilderHelper::checkArray($ignore) && in_array($item, $ignore))
					{
						// don't add ignored ids
						$newItem = false;
					}
					// check if this is old repeatable field
					elseif (isset($old[$type]) && ComponentbuilderHelper::checkArray($old[$type]))
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
						if (ComponentbuilderHelper::checkArray($ignore) && in_array($item[$type], $ignore))
						{
							// don't add ignored ids
							$newItem = false;
						}
						// check if this is old repeatable field
						elseif (isset($old[$type]) && ComponentbuilderHelper::checkArray($old[$type]))
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
		elseif ($key && ((ComponentbuilderHelper::checkString($new) && ComponentbuilderHelper::checkString($old)) || (is_numeric($new) && is_numeric($old))) && $new !== $old)
		{
			// the string changed, lets add to SQL update
			if (!isset($this->updateSQL[$type]) || !ComponentbuilderHelper::checkArray($this->updateSQL[$type]))
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
	 * @param   string   $type   The type of values
	 * @param   int      $item   The item id to add
	 * @param   int      $key    The id/key where values changed
	 * 
	 * @return void
	 */
	protected function setAddSQL($type, $item, $key)
	{
		// we have a new item, lets add to SQL
		if (!isset($this->addSQL[$type]) || !ComponentbuilderHelper::checkArray($this->addSQL[$type]))
		{
			$this->addSQL[$type] = array();
		}
		// add key if found
		if ($key)
		{
			if (!isset($this->addSQL[$type][$key]) || !ComponentbuilderHelper::checkArray($this->addSQL[$type][$key]))
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
				$this->addSQL[$type][] = ComponentbuilderHelper::safeString($this->getAdminViewData($item)->name_single);
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
	 * @param   string   $type  The type of item
	 * @param   int      $id    The item ID
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
		$query->where($this->db->quoteName('h.ucm_item_id') . ' = ' . (int) $id);
		// Join over the content type for the type id
		$query->join('LEFT', '#__content_types AS ct ON ct.type_id = h.ucm_type_id');
		$query->where('ct.type_alias = ' . $this->db->quote('com_componentbuilder.' . $type));
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
		$query->where($this->db->quoteName('h.ucm_item_id') . ' = ' . (int) $id);
		$query->where('h.keep_forever = 1');
		$query->where('h.version_note LIKE ' . $this->db->quote('%component%'));
		// make sure it does not return the active version
		if (isset($newActive) && isset($newActive->version_id))
		{
			$query->where('h.version_id != ' . (int) $newActive->version_id);
		}
		// Join over the content type for the type id
		$query->join('LEFT', '#__content_types AS ct ON ct.type_id = h.ucm_type_id');
		$query->where('ct.type_alias = ' . $this->db->quote('com_componentbuilder.' . $type));
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
	 * @param   Object   $object  The history object
	 * @param   int      $action  The action to take
	 * 				0 = remove watch
	 * 				1 = add watch
	 * @param   string   $type    The type of item
	 *
	 * @return  bool
	 * 
	 */
	protected function setHistoryWatch($object, $action)
	{
		// check the note
		if (ComponentbuilderHelper::checkJson($object->version_note))
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
				if (isset($version_note['component']) && ($key = array_search($this->componentID, $version_note['component'])) !== false)
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
				if (!in_array($this->componentID, $version_note['component']))
				{
					$version_note['component'][] = $this->componentID;
				}
				else
				{
					// since it is there already, no need to update anything
					return true;
				}
				break;
		}
		// check if we need to still keep this locked
		if (isset($version_note['component']) && ComponentbuilderHelper::checkArray($version_note['component']))
		{
			// insure component ids are only added once per item
			$version_note['component'] = array_unique($version_note['component']);
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
	 * @param   string   $default  The content to check
	 * @param   string   $view  The view code name
	 *
	 * @return  void
	 * 
	 */
	public function setTemplateAndLayoutData($default, $view)
	{
		// set the Tempale date
		$temp1 = ComponentbuilderHelper::getAllBetween($default, "\$this->loadTemplate('", "')");
		$temp2 = ComponentbuilderHelper::getAllBetween($default, '$this->loadTemplate("', '")');
		$templates = array();
		$again = array();
		if (ComponentbuilderHelper::checkArray($temp1) && ComponentbuilderHelper::checkArray($temp2))
		{
			$templates = array_merge($temp1, $temp2);
		}
		else
		{
			if (ComponentbuilderHelper::checkArray($temp1))
			{
				$templates = $temp1;
			}
			elseif (ComponentbuilderHelper::checkArray($temp2))
			{
				$templates = $temp2;
			}
		}
		if (ComponentbuilderHelper::checkArray($templates))
		{
			foreach ($templates as $template)
			{
				if (!isset($this->templateData[$this->target][$view]) || !array_key_exists($template, $this->templateData[$this->target][$view]))
				{
					$data = $this->getDataWithAlias($template, 'template', $view);
					if (ComponentbuilderHelper::checkArray($data))
					{
						$this->templateData[$this->target][$view][$template] = $data;
						// call self to get child data
						$again[] = array($data['html'], $view);
						$again[] = array($data['php_view'], $view);
					}
				}
			}
		}
		// set  the layout data
		$lay1 = ComponentbuilderHelper::getAllBetween($default, "JLayoutHelper::render('", "',");
		$lay2 = ComponentbuilderHelper::getAllBetween($default, 'JLayoutHelper::render("', '",');
		;
		if (ComponentbuilderHelper::checkArray($lay1) && ComponentbuilderHelper::checkArray($lay2))
		{
			$layouts = array_merge($lay1, $lay2);
		}
		else
		{
			if (ComponentbuilderHelper::checkArray($lay1))
			{
				$layouts = $lay1;
			}
			elseif (ComponentbuilderHelper::checkArray($lay2))
			{
				$layouts = $lay2;
			}
		}
		if (isset($layouts) && ComponentbuilderHelper::checkArray($layouts))
		{
			foreach ($layouts as $layout)
			{
				if (!isset($this->layoutData[$this->target]) || !ComponentbuilderHelper::checkArray($this->layoutData[$this->target]) || !array_key_exists($layout, $this->layoutData[$this->target]))
				{
					$data = $this->getDataWithAlias($layout, 'layout', $view);
					if (ComponentbuilderHelper::checkArray($data))
					{
						$this->layoutData[$this->target][$layout] = $data;
						// call self to get child data
						$again[] = array($data['html'], $view);
						$again[] = array($data['php_view'], $view);
					}
				}
			}
		}
		if (ComponentbuilderHelper::checkArray($again))
		{
			foreach ($again as $go)
			{
				$this->setTemplateAndLayoutData($go[0], $go[1]);
			}
		}
	}

	/**
	 * Get Data With Alias
	 * 
	 * @param   string   $n_ame  The alias name
	 * @param   string   $table  The table where to find the alias
	 * @param   string   $view  The view code name
	 *
	 * @return  array The data found with the alias
	 * 
	 */
	public function getDataWithAlias($n_ame, $table, $view)
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_' . $table . ' AS a');
		$this->db->setQuery($query);
		$rows = $this->db->loadObjectList();
		foreach ($rows as $row)
		{
			$k_ey = ComponentbuilderHelper::safeString($row->alias);
			$key = preg_replace("/[^A-Za-z]/", '', $k_ey);
			$name = preg_replace("/[^A-Za-z]/", '', $n_ame);
			if ($k_ey == $n_ame || $key == $name)
			{
				$php_view = '';
				if ($row->add_php_view == 1 && ComponentbuilderHelper::checkString($row->php_view))
				{
					$php_view = $this->setDynamicValues(base64_decode($row->php_view));
				}
				$contnent = $this->setDynamicValues(base64_decode($row->{$table}));
				// load the library
				if (!isset($this->libManager[$this->target]))
				{
					$this->libManager[$this->target] = array();
				}
				if (!isset($this->libManager[$this->target][$view]))
				{
					$this->libManager[$this->target][$view] = array();
				}
				// make sure json become array
				if (ComponentbuilderHelper::checkJson($row->libraries))
				{
					$row->libraries = json_decode($row->libraries, true);
				}
				// if we have an array add it
				if (ComponentbuilderHelper::checkArray($row->libraries))
				{
					foreach ($row->libraries as $library)
					{
						if (!isset($this->libManager[$this->target][$view][$library]))
						{
							if ($this->getLibrary((int) $library))
							{
								$this->libManager[$this->target][$view][(int) $library] = true;
							}
						}
					}
				}
				elseif (is_numeric($row->libraries) && !isset($this->libManager[$this->target][$view][(int) $row->libraries]))
				{
					if ($this->getLibrary((int) $row->libraries))
					{
						$this->libManager[$this->target][$view][(int) $row->libraries] = true;
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
					$this->uikitComp[$view] = ComponentbuilderHelper::getUikitComp($contnent, $this->uikitComp[$view]);
				}
				// set footable to views and turn it on
				if (!isset($this->footableScripts[$this->target][$view]) || !$this->footableScripts[$this->target][$view])
				{
					$foundFoo = $this->getFootableScripts($contnent);
					if ($foundFoo)
					{
						$this->footableScripts[$this->target][$view] = true;
					}
					if ($foundFoo && !$this->footable)
					{
						$this->footable = true;
					}
				}
				// set google charts to views and turn it on
				if (!isset($this->googleChart[$this->target][$view]) || !$this->googleChart[$this->target][$view])
				{
					$foundA = $this->getGoogleChart($php_view);
					$foundB = $this->getGoogleChart($contnent);
					if ($foundA || $foundB)
					{
						$this->googleChart[$this->target][$view] = true;
					}
					if ($foundA || $foundB && !$this->googlechart)
					{
						$this->googlechart = true;
					}
				}
				// check for get module
				if (!isset($this->getModule[$this->target][$view]) || !$this->getModule[$this->target][$view])
				{
					$foundA = $this->getGetModule($php_view);
					$foundB = $this->getGetModule($contnent);
					if ($foundA || $foundB)
					{
						$this->getModule[$this->target][$view] = true;
					}
				}
				return array('id' => $row->id, 'html' => $contnent, 'php_view' => $php_view);
			}
		}
		return false;
	}

	/**
	 * Get Library Data and store globaly
	 * 
	 * @param   string   $id the library id
	 *
	 * @return  bool    true on success
	 * 
	 */
	protected function getLibrary($id)
	{

		// check if the lib has already been set
		if (!isset($this->libraries[$id]))
		{
			// make sure we should continue and that the lib is not already bein loaded
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
					if (!isset($this->footableVersion) || 2 == $this->footableVersion)
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
			$query->join('LEFT', $this->db->quoteName('#__componentbuilder_library_config', 'b') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('b.library') . ')');
			$query->join('LEFT', $this->db->quoteName('#__componentbuilder_library_files_folders_urls', 'c') . ' ON (' . $this->db->quoteName('a.id') . ' = ' . $this->db->quoteName('c.library') . ')');
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects
			$library = $this->db->loadObject();

			// check if this lib uses build-in behaviour
			if ($library->how == 4)
			{
				// fall back on build-in features
				$buildin = array(3 => array('uikit' => 3), 4 => array('uikit' => 1), 5 => array('footableVersion' => 2, 'footable' => true), 6 => array('footableVersion' => 3, 'footable' => true));
				if (isset($buildin[$library->id]) && ComponentbuilderHelper::checkArray($buildin[$library->id]))
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
				$addArray = array('files' => 'files', 'folders' => 'folders', 'urls' => 'urls', 'filesfullpath' => 'files', 'foldersfullpath' => 'folders');
				foreach ($addArray as $addTarget => $targetHere)
				{
					// set the add target data
					$library->{'add' . $addTarget} = (isset($library->{'add' . $addTarget}) && ComponentbuilderHelper::checkJson($library->{'add' . $addTarget})) ? json_decode($library->{'add' . $addTarget}, true) : null;
					if (ComponentbuilderHelper::checkArray($library->{'add' . $addTarget}))
					{
						if (isset($library->{$targetHere}) && ComponentbuilderHelper::checkArray($library->{$targetHere}))
						{
							foreach ($library->{'add' . $addTarget} as $taget)
							{
								$library->{$targetHere}[] = $taget;
							}
						}
						else
						{
							$library->{$targetHere} = array_values($library->{'add' . $addTarget});
						}
					}
					unset($library->{'add' . $addTarget});
				}
				// add config fields only if needed
				if ($library->how > 1)
				{
					// set the config data
					$library->addconfig = (isset($library->addconfig) && ComponentbuilderHelper::checkJson($library->addconfig)) ? json_decode($library->addconfig, true) : null;
					if (ComponentbuilderHelper::checkArray($library->addconfig))
					{
						$library->config = array_map(function($array)
						{
							$array['alias'] = 0;
							$array['title'] = 0;
							$array['settings'] = $this->getFieldData($array['field']);
							return $array;
						}, array_values($library->addconfig));
					}
				}
				// if this lib is controlled by custom script
				if (3 == $library->how)
				{
					// set Needed PHP
					if (isset($library->php_setdocument) && ComponentbuilderHelper::checkString($library->php_setdocument))
					{
						$library->document = $this->setDynamicValues(base64_decode($library->php_setdocument));
					}
				}
				// if this lib is controlled by conditions
				elseif (2 == $library->how)
				{
					// set the addconditions data
					$library->addconditions = (isset($library->addconditions) && ComponentbuilderHelper::checkJson($library->addconditions)) ? json_decode($library->addconditions, true) : null;
					if (ComponentbuilderHelper::checkArray($library->addconditions))
					{
						$library->conditions = array_values($library->addconditions);
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
	 * @param   string   $content  The content
	 *
	 * @return  string The content with the updated Language place holder
	 *
	 */
	public function setLangStrings($content)
	{
		// get targets to search for
		$langStringTargets = array_filter(
			$this->langStringTargets, function($get) use($content)
		{
			if (strpos($content, $get) !== false)
			{
				return true;
			}
			return false;
		});
		// check if we should continue
		if (ComponentbuilderHelper::checkArray($langStringTargets))
		{
			// insure string is not broken
			$content = str_replace('COM_' . $this->hhh . 'COMPONENT' . $this->hhh, $this->langPrefix, $content);
			// reset some buckets
			$langHolders = array();
			$langCheck = array();
			$langOnly = array();
			$jsTEXT = array();
			$scTEXT = array();
			// first get the Joomla .JText._()
			if (in_array('Joomla' . '.JText._(', $langStringTargets))
			{
				$jsTEXT[] = ComponentbuilderHelper::getAllBetween($content, "Joomla" . ".JText._('", "'");
				$jsTEXT[] = ComponentbuilderHelper::getAllBetween($content, 'Joomla' . '.JText._("', '"');
				// combine into one array
				$jsTEXT = ComponentbuilderHelper::mergeArrays($jsTEXT);
				// we need to add a check to insure these JavaScript lang matchup
				if (ComponentbuilderHelper::checkArray($jsTEXT)) //<-- not really needed hmmm
				{
					// load the JS text to mismatch array
					$langCheck[] = $jsTEXT;
					$this->langMismatch = ComponentbuilderHelper::mergeArrays(array($jsTEXT, $this->langMismatch));
				}
			}
			// now get the JText: :script()
			if (in_array('JText:' . ':script(', $langStringTargets))
			{
				$scTEXT[] = ComponentbuilderHelper::getAllBetween($content, "JText:" . ":script('", "'");
				$scTEXT[] = ComponentbuilderHelper::getAllBetween($content, 'JText:' . ':script("', '"');
				// combine into one array
				$scTEXT = ComponentbuilderHelper::mergeArrays($scTEXT);
				// we need to add a check to insure these JavaScript lang matchup
				if (ComponentbuilderHelper::checkArray($scTEXT)) //<-- not really needed hmmm
				{
					// load the Script text to match array
					$langCheck[] = $scTEXT;
					$this->langMatch = ComponentbuilderHelper::mergeArrays(array($scTEXT, $this->langMatch));
				}
			}
			// now do the little trick for JustTEXT: :_('Just uppercase text');
			if (in_array('JustTEXT:' . ':_(', $langStringTargets))
			{
				$langOnly[] = ComponentbuilderHelper::getAllBetween($content, "JustTEXT:" . ":_('", "')");
				$langOnly[] = ComponentbuilderHelper::getAllBetween($content, 'JustTEXT:' . ':_("', '")');
				// merge lang only
				$langOnly = ComponentbuilderHelper::mergeArrays($langOnly);
			}
			// set language data
			foreach ($langStringTargets as $langStringTarget)
			{
				// need some special treatment here
				if ($langStringTarget === 'Joomla' . '.JText._(' ||
					$langStringTarget === 'JText:' . ':script(' ||
					$langStringTarget === 'JustTEXT:' . ':_(')
				{
					continue;
				}
				$langCheck[] = ComponentbuilderHelper::getAllBetween($content, $langStringTarget . "'", "'");
				$langCheck[] = ComponentbuilderHelper::getAllBetween($content, $langStringTarget . '"', '"');
			}
			// the normal loading of the language strings
			$langCheck = ComponentbuilderHelper::mergeArrays($langCheck);
			if (ComponentbuilderHelper::checkArray($langCheck)) //<-- not really needed hmmm
			{
				foreach ($langCheck as $string)
				{
					if ($keyLang = $this->setLang($string))
					{
						// load the language targets
						foreach ($langStringTargets as $langStringTarget)
						{
							// need some special treatment here
							if ($langStringTarget === 'JustTEXT:' . ':_(')
							{
								continue;
							}
							$langHolders[$langStringTarget . "'" . $string . "'"] = $langStringTarget . "'" . $keyLang . "'";
							$langHolders[$langStringTarget . '"' . $string . '"'] = $langStringTarget . '"' . $keyLang . '"';
						}
					}
				}
			}
			// the uppercase loading only (for arrays and other tricks)
			if (ComponentbuilderHelper::checkArray($langOnly))
			{
				foreach ($langOnly as $string)
				{
					if ($keyLang = $this->setLang($string))
					{
						// load the language targets
						$langHolders["JustTEXT:" . ":_('" . $string . "')"] = "'" . $keyLang . "'";
						$langHolders['JustTEXT:' . ':_("' . $string . '")'] = '"' . $keyLang . '"';
					}
				}
			}
			// only continue if we have value to replace
			if (ComponentbuilderHelper::checkArray($langHolders))
			{
				$content = $this->setPlaceholders($content, $langHolders);
			}
		}
		return $content;
	}

	/**
	 * Set the language String
	 * 
	 * @param   string   $string  The plan text string (English)
	 *
	 * @return  string   The key language string (all uppercase)
	 * 
	 */
	public function setLang($string)
	{
		// this is there to insure we dont break already added Language strings
		if (ComponentbuilderHelper::safeString($string, 'U') === $string)
		{
			return false;
		}
		// only load if string is not already set
		$keyLang = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($string, 'U');
		if (!isset($this->langContent[$this->lang][$keyLang]))
		{
			$this->langContent[$this->lang][$keyLang] = trim($string);
		}
		return $keyLang;
	}

	/**
	 * Set Data Selection of the dynamic get
	 * 
	 * @param   string         $method_key  The method unique key
	 * @param   string         $view_code  The code name of the view
	 * @param   string         $string  The data string
	 * @param   string         $asset  The asset in question
	 * @param   string         $as  The as string
	 * @param   int            $row_type  The row type
	 * @param   string         $type  The target type (db||view)
	 *
	 * @return  array the select query
	 * 
	 */
	public function setDataSelection($method_key, $view_code, $string, $asset, $as, $row_type, $type)
	{
		if (ComponentbuilderHelper::checkString($string))
		{
			if ('db' === $type)
			{
				$table = '#__' . $asset;
				$queryName = $asset;
				$view = '';
			}
			elseif ('view' === $type)
			{
				$view = $this->getViewTableName($asset);
				$table = '#__' . $this->componentCodeName . '_' . $view;
				$queryName = $view;
			}
			// just get all values from table if * is found
			if ($string === '*' || strpos($string, '*') !== false)
			{
				if ($type == 'view')
				{
					$_string = ComponentbuilderHelper::getViewTableColumns($asset, $as, $row_type);
				}
				else
				{
					$_string = ComponentbuilderHelper::getDbTableColumns($asset, $as, $row_type);
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
			if (ComponentbuilderHelper::checkArray($lines))
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
					if (isset($this->getAsLookup[$method_key][$get]) && 'a' != $as && 1 == $row_type && 'view' === $type && strpos('#' . $key, '#' . $view . '_') === false)
					{
						// this is a problem (TODO) since we may want to not add the view name.
						$key = $view . '_' . trim($key);
					}
					// continue only if we have get
					if (ComponentbuilderHelper::checkString($get))
					{
						$gets[] = $this->db->quote($get);
						if (ComponentbuilderHelper::checkString($key))
						{
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[] = $this->db->quote($key);
						}
						else
						{
							$key = str_replace($as . '.', '', $get);
							$this->getAsLookup[$method_key][$get] = $key;
							$keys[] = $this->db->quote($key);
						}
						// make sure we have the view name
						if (ComponentbuilderHelper::checkString($view))
						{
							// prep the field name
							$field = str_replace($as . '.', '', $get);
							// make sure the array is set
							if (!isset($this->siteFields[$view][$field]))
							{
								$this->siteFields[$view][$field] = array();
							}
							// load to the site fields memory bucket
							$this->siteFields[$view][$field][$method_key . '___' . $as] = array('site' => $view_code, 'get' => $get, 'as' => $as, 'key' => $key);
						}
					}
				}
				if (ComponentbuilderHelper::checkArray($gets) && ComponentbuilderHelper::checkArray($keys))
				{
					// single joined selection needs the prefix to the values to avoid conflict in the names
					// so we most still add then AS
					if ($string == '*' && 1 != $row_type)
					{
						$querySelect = "\$query->select('" . $as . ".*');";
					}
					else
					{
						$querySelect = '$query->select($db->quoteName(' . PHP_EOL . $this->_t(3) . 'array(' . implode(',', $gets) . '),' . PHP_EOL . $this->_t(3) . 'array(' . implode(',', $keys) . ')));';
					}
					$queryFrom = '$db->quoteName(' . $this->db->quote($table) . ', ' . $this->db->quote($as) . ')';
					// return the select query
					return array('select' => $querySelect, 'from' => $queryFrom, 'name' => $queryName, 'table' => $table, 'type' => $type, 'select_gets' => $gets, 'select_keys' => $keys);
				}
			}
		}
		return false;
	}

	/**
	 * Get the View Table Name
	 * 
	 * @param   int   $id  The admin view in
	 *
	 * @return  string view code name
	 * 
	 */
	public function getViewTableName($id)
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select($this->db->quoteName(array('a.name_single')));
		$query->from($this->db->quoteName('#__componentbuilder_admin_view', 'a'));
		$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
		$this->db->setQuery($query);
		return ComponentbuilderHelper::safeString($this->db->loadResult());
	}

	/**
	 * Build the SQL dump String for a view
	 * 
	 * @param   string   $tables  The tables to use in build
	 * @param   string   $view  The target view/table to dump in
	 * @param   int      $view_id  The id of the target view
	 *
	 * @return  string on success with the Dump SQL
	 * 
	 */
	public function buildSqlDump($tables, $view, $view_id)
	{
		// first build a query statment to get all the data (insure it must be added - check the tweaking)
		if (ComponentbuilderHelper::checkArray($tables) && (!isset($this->sqlTweak[$view_id]['remove']) || !$this->sqlTweak[$view_id]['remove']))
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
							if (ComponentbuilderHelper::checkArray($fields))
							{
								// reset array buckets
								$sourceArray = array();
								$targetArray = array();
								foreach ($fields as $field)
								{
									if (strpos($field, "=>") !== false)
									{
										list($source, $target) = explode("=>", $field);
										$sourceArray[] = $counter . '.' . trim($source);
										$targetArray[] = trim($target);
									}
								}
								if (ComponentbuilderHelper::checkArray($sourceArray) && ComponentbuilderHelper::checkArray($targetArray))
								{
									// add to query
									$query->select($this->db->quoteName($sourceArray, $targetArray));
									$query->from('#__' . $table['table'] . ' AS a');
									$runQuery = true;
								}
								// we may need to filter the selection
								if (isset($this->sqlTweak[$view_id]['where']))
								{
									// add to query the where filter
									$query->where('a.id IN (' . $this->sqlTweak[$view_id]['where'] . ')');
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
							if (ComponentbuilderHelper::checkArray($fields))
							{
								// reset array buckets
								$sourceArray = array();
								$targetArray = array();
								foreach ($fields as $field)
								{
									if (strpos($field, "=>") !== false)
									{
										list($source, $target) = explode("=>", $field);
										$sourceArray[] = $counter . '.' . trim($source);
										$targetArray[] = trim($target);
									}
									if (strpos($field, "==") !== false)
									{
										list($aKey, $bKey) = explode("==", $field);
										// add to query
										$query->join('LEFT', $this->db->quoteName('#__' . $table['table'], $counter) . ' ON (' . $this->db->quoteName('a.' . trim($aKey)) . ' = ' . $this->db->quoteName($counter . '.' . trim($bKey)) . ')');
									}
								}
								if (ComponentbuilderHelper::checkArray($sourceArray) && ComponentbuilderHelper::checkArray($targetArray))
								{
									// add to query
									$query->select($this->db->quoteName($sourceArray, $targetArray));
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
					$dump .= PHP_EOL . "-- Dumping data for table `#__" . $this->bbb . "component" . $this->ddd . "_" . $view . "`";
					$dump .= PHP_EOL . "--";
					$dump .= PHP_EOL . PHP_EOL . "INSERT INTO `#__" . $this->bbb . "component" . $this->ddd . "_" . $view . "` (";
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
								$dump .= ", " . $this->db->quoteName($fieldName);
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
								$dump .= ", " . $this->mysql_escape($fieldValue);
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
	 * @param   string   $value  the value to escape
	 *
	 * @return  string on success with escaped string
	 * 
	 */
	public function mysql_escape($value)
	{
		// if array then return maped
		if (ComponentbuilderHelper::checkArray($value))
		{
			return array_map(__METHOD__, $value);
		}
		// if string make sure it is correctly escaped
		if (ComponentbuilderHelper::checkString($value) && !is_numeric($value))
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
	 * @param   string   $code The planed code
	 *
	 * @return  string The unique code
	 * 
	 */
	public function uniqueCode($code)
	{
		if (!isset($this->uniquecodes[$this->target]) || !in_array($code, $this->uniquecodes[$this->target]))
		{
			$this->uniquecodes[$this->target][] = $code;
			return $code;
		}
		// make sure it is unique
		return $this->uniqueCode($code . $this->uniquekey(1));
	}

	/**
	 * Creating an unique local key
	 * 
	 * @param   int   $size The key size
	 *
	 * @return  string The unique localkey
	 * 
	 */
	public function uniquekey($size, $random = false, $newBag = "vvvvvvvvvvvvvvvvvvv")
	{
		if ($random)
		{
			$bag = "abcefghijknopqrstuwxyzABCDDEFGHIJKLLMMNOPQRSTUVVWXYZabcddefghijkllmmnopqrstuvvwxyzABCEFGHIJKNOPQRSTUWXYZ";
		}
		else
		{
			$bag = $newBag;
		}
		$key = array();
		$bagsize = strlen($bag) - 1;
		for ($i = 0; $i < $size; $i++)
		{
			$get = rand(0, $bagsize);
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
	 * @param   string   $content The content to check
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
	 * @param   string   $content The content to check
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
	 * @param   string   $content The content to check
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
	 * @param   string   $string The content to check
	 * @param   int      $debug  The switch to debug the update
	 *				We can now at any time debug the 
	 *				dynamic build values if it gets broken
	 *
	 * @return  string
	 * 
	 */
	public function setDynamicValues($string, $debug = 0)
	{
		if (ComponentbuilderHelper::checkString($string))
		{
			$string = $this->setLangStrings($this->setCustomCodeData($this->setExternalCodeString($string, $debug), $debug));
		}
		// if debug
		if ($debug)
		{
			jexit();
		}
		return $string;
	}

	/**
	 * Set the external code string & load it in to string
	 * 
	 * @param   string   $string The content to check
	 * @param   int      $debug  The switch to debug the update
	 *
	 * @return  string
	 * 
	 */
	public function setExternalCodeString($string, $debug = 0)
	{
		// check if content has custom code place holder
		if (strpos($string, '[EXTERNA' . 'LCODE=') !== false)
		{
			// if debug
			if ($debug)
			{
				echo 'External Code String:';
				var_dump($string);
			}
			// target content
			$bucket = array();
			$found = ComponentbuilderHelper::getAllBetween($string, '[EXTERNA' . 'LCODE=', ']');
			if (ComponentbuilderHelper::checkArray($found))
			{
				// build local bucket
				foreach ($found as $target)
				{
					// check if user has permission to use EXTERNAL code (we may add a custom access switch - use ADMIN for now)
					if ($this->user->authorise('core.admin', 'com_componentbuilder'))
					{
						// check if the target is valid URL or path
						if ((!filter_var($target, FILTER_VALIDATE_URL) === false && ComponentbuilderHelper::urlExists($target)) || (JPath::clean($target) === $target && JFile::exists($target)))
						{
							$this->getExternalCodeString($target, $bucket);
						}
						// give notice that target is not a valid url/path
						else
						{
							// set key
							$key = '[EXTERNA' . 'LCODE=' . $target . ']';
							// set the notice
							$this->app->enqueueMessage(JText::_('<hr /><h3>External Code Warning</h3>'), 'Warning');
							$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> is not a valid url/path!', $key), 'Warning');
							// remove the placeholder
							$bucket[$key] = '';
						}
					}
					else
					{
						// set key
						$key = '[EXTERNA' . 'LCODE=' . $target . ']';
						// set the notice
						$this->app->enqueueMessage(JText::_('<hr /><h3>External Code Error</h3>'), 'Error');
						$this->app->enqueueMessage(JText::sprintf('%s, you do not have permission to use <b>EXTERNALCODE</b> feature (so <b>%s</b> was removed from the compilation), please contact you system administrator for more info!<br /><small>(admin access required)</small>', $this->user->get('name'), $key), 'Error');
						// remove the placeholder
						$bucket[$key] = '';
					}
				}
				// now update local string if bucket has values
				if (ComponentbuilderHelper::checkArray($bucket))
				{
					$string = $this->setPlaceholders($string, $bucket);
				}
			}
			// if debug
			if ($debug)
			{
				echo 'External Code String After Update:';
				var_dump($string);
			}
		}
		return $string;
	}

	/**
	 * Get the External Code/String
	 * 
	 * @param   string   $string The content to check
	 * @param   array    $bucket The Placeholders bucket
	 *
	 * @return  void
	 * 
	 */
	protected function getExternalCodeString($target, &$bucket)
	{
		// set key
		$key = '[EXTERNA' . 'LCODE=' . $target . ']';
		// set URL key
		$targetKey = trim($target);
		// check if we already fetched this
		if (!isset($this->externalCodeString[$targetKey]))
		{
			// get the data string (code)
			$this->externalCodeString[$targetKey] = ComponentbuilderHelper::getFileContents($targetKey);
			// did we get any value
			if (ComponentbuilderHelper::checkString($this->externalCodeString[$targetKey]))
			{
				// check for changes
				$liveHash = md5($this->externalCodeString[$targetKey]);
				// check if it exist local
				if ($hash = ComponentbuilderHelper::getVar('external_code', $targetKey, 'target', 'hash'))
				{
					if ($hash !== $liveHash)
					{
						// update the hash since it changed
						$object = new stdClass();
						$object->target = $targetKey;
						$object->hash = $liveHash;
						// update local hash
						$this->db->updateObject('#__componentbuilder_external_code', $object, 'target');
						// give notice of the change
						$this->app->enqueueMessage(JText::_('<hr /><h3>External Code Warning</h3>'), 'Warning');
						$this->app->enqueueMessage(JText::sprintf('The code/string from <b>%s</b> has been <b>changed</b> since the last compilation, please investigate to insure the changes are safe!', $key), 'Warning');
					}
				}
				else
				{
					// add the hash to track changes
					$object = new stdClass();
					$object->target = $targetKey;
					$object->hash = $liveHash;
					// insert local hash
					$this->db->insertObject('#__componentbuilder_external_code', $object);
					// give notice the first time this is added
					$this->app->enqueueMessage(JText::_('<hr /><h3>External Code Notice</h3>'), 'Notice');
					$this->app->enqueueMessage(JText::sprintf('The code/string from <b>%s</b> has been added for the <b>first time</b>, please investigate to insure the correct code/string was used!', $key), 'Notice');
				}
			}
			else
			{
				// set notice that we could not get a valid string from the target
				$this->app->enqueueMessage(JText::_('<hr /><h3>External Code Warning</h3>'), 'Warning');
				$this->app->enqueueMessage(JText::sprintf('The <b>%s</b> returned an invalid string!', $key), 'Warning');
			}
		}
		// add to local bucket
		if (isset($this->externalCodeString[$targetKey]))
		{
			$bucket[$key] = $this->externalCodeString[$targetKey];
		}
	}

	/**
	 * We start set the custom code data & can load it in to string
	 * 
	 * @param   string   $string The content to check
	 * @param   int      $debug  The switch to debug the update
	 *
	 * @return  string
	 * 
	 */
	public function setCustomCodeData($string, $debug = 0, $not = null)
	{
		// insure the code is loaded
		$loaded = false;
		// check if content has custom code place holder
		if (strpos($string, '[CUSTO' . 'MCODE=') !== false)
		{
			// if debug
			if ($debug)
			{
				echo 'Custom Code String:';
				var_dump($string);
			}
			// the ids found in this content
			$bucket = array();
			$found = ComponentbuilderHelper::getAllBetween($string, '[CUSTO' . 'MCODE=', ']');
			if (ComponentbuilderHelper::checkArray($found))
			{
				foreach ($found as $key)
				{
					// if debug
					if ($debug)
					{
						echo '$key before update:';
						var_dump($key);
					}
					// check if we have args
					if (is_numeric($key))
					{
						$id = (int) $key;
					}
					elseif (ComponentbuilderHelper::checkString($key) && strpos($key, '+') === false)
					{
						$getFuncName = trim($key);
						if (!isset($this->functionNameMemory[$getFuncName]))
						{
							if (!$found_local = ComponentbuilderHelper::getVar('custom_code', $getFuncName, 'function_name', 'id'))
							{
								continue;
							}
							$this->functionNameMemory[$getFuncName] = $found_local;
						}
						$id = (int) $this->functionNameMemory[$getFuncName];
					}
					elseif (ComponentbuilderHelper::checkString($key) && strpos($key, '+') !== false)
					{
						$array = explode('+', $key);
						// set ID
						if (is_numeric($array[0]))
						{
							$id = (int) $array[0];
						}
						elseif (ComponentbuilderHelper::checkString($array[0]))
						{
							$getFuncName = trim($array[0]);
							if (!isset($this->functionNameMemory[$getFuncName]))
							{
								if (!$found_local = ComponentbuilderHelper::getVar('custom_code', $getFuncName, 'function_name', 'id'))
								{
									continue;
								}
								$this->functionNameMemory[$getFuncName] = $found_local;
							}
							$id = (int) $this->functionNameMemory[$getFuncName];
						}
						else
						{
							continue;
						}
						// load args for this ID
						if (isset($array[1]))
						{
							if (!isset($this->customCodeData[$id]['args']))
							{
								$this->customCodeData[$id]['args'] = array();
							}
							// only load if not already loaded
							if (!isset($this->customCodeData[$id]['args'][$key]))
							{
								if (strpos($array[1], ',') !== false)
								{
									// update the function values with the custom code key placholdres (this allow the use of [] + and , in the values)
									$this->customCodeData[$id]['args'][$key] = array_map(function($_key) {
											return $this->setPlaceholders($_key, $this->customCodeKeyPlacholders);
										}, (array) explode(',', $array[1]));
								}
								elseif (ComponentbuilderHelper::checkString($array[1]))
								{
									$this->customCodeData[$id]['args'][$key] = array();
									// update the function values with the custom code key placholdres (this allow the use of [] + and , in the values)
									$this->customCodeData[$id]['args'][$key][] = $this->setPlaceholders($array[1], $this->customCodeKeyPlacholders);
								}
							}
						}
					}
					else
					{
						continue;
					}
					// make sure to remove the not if set
					if ($not && is_numeric($not) && $not > 0 && $not == $id)
					{
						continue;
					}
					$bucket[$id] = $id;
				}
			}
			// if debug
			if ($debug)
			{
				echo 'Bucket:';
				var_dump($bucket);
			}
			// check if any custom code placeholders where found
			if (ComponentbuilderHelper::checkArray($bucket))
			{
				$_tmpLang = $this->lang;
				// insure we add the langs to both site and admin
				$this->lang = 'both';
				// now load the code to memory
				$loaded = $this->getCustomCode($bucket, false, $debug);
				// revert lang to current setting
				$this->lang = $_tmpLang;
			}
			// if debug
			if ($debug)
			{
				echo 'Loaded:';
				var_dump($loaded);
			}
			// when the custom code is loaded
			if ($loaded === true)
			{
				$string = $this->insertCustomCode($bucket, $string, $debug);
			}
			// if debug
			if ($debug)
			{
				echo 'Custom Code String After Update:';
				var_dump($string);
			}
		}
		return $string;
	}

	/**
	 * Insert the custom code into the string
	 * 
	 * @param   string   $string The content to check
	 * @param   int      $debug  The switch to debug the update
	 *
	 * @return  string on success
	 * 
	 */
	protected function insertCustomCode($ids, $string, $debug = 0)
	{
		$code = array();
		// load the code
		foreach ($ids as $id)
		{
			$this->buildCustomCodePlaceholders($this->customCodeMemory[$id], $code, $debug);
		}
		// if debug
		if ($debug)
		{
			echo 'Place holders to Update String:';
			var_dump($code);
			echo 'Custom Code String Before Update:';
			var_dump($string);
		}
		// now update the string
		return $this->setPlaceholders($string, $code);
	}

	/**
	 * Insert the custom code into the string
	 * 
	 * @param   string   $string The content to check
	 * @param   int      $debug  The switch to debug the update
	 *
	 * @return  string on success
	 * 
	 */
	protected function buildCustomCodePlaceholders($item, &$code, $debug = 0)
	{
		// check if there is args for this code
		if (isset($this->customCodeData[$item['id']]['args']) && ComponentbuilderHelper::checkArray($this->customCodeData[$item['id']]['args']))
		{
			// since we have args we cant update this code via IDE (TODO)
			$placeholder = $this->getPlaceHolder(3, null);
			// if debug
			if ($debug)
			{
				echo 'Custom Code Placeholders:';
				var_dump($placeholder);
			}
			// we have args and so need to load each
			foreach ($this->customCodeData[$item['id']]['args'] as $key => $args)
			{
				$this->setThesePlaceHolders('arg', $args);
				// if debug
				if ($debug)
				{
					echo 'Custom Code Global Placholders:';
					var_dump($this->placeholders);
				}
				$code['[CUSTOM' . 'CODE=' . $key . ']'] = $placeholder['start'] . PHP_EOL . $this->setPlaceholders($item['code'], $this->placeholders) . $placeholder['end'];
			}
			// always clear the args
			$this->clearFromPlaceHolders('arg');
		}
		else
		{
			if (($keyPlaceholder = array_search($item['id'], $this->functionNameMemory)) === false)
			{
				$keyPlaceholder = $item['id'];
			}
			// check what type of place holders we should load here
			$placeholderType = (int) $item['comment_type'] . '2';
			if (stripos($item['code'], $this->bbb . 'view') !== false || stripos($item['code'], $this->bbb . 'sview') !== false || stripos($item['code'], $this->bbb . 'arg') !== false)
			{
				// if view is being set dynamicly then we can't update this code via IDE (TODO)
				$placeholderType = 3;
			}
			// if now ars were found, clear it
			$this->clearFromPlaceHolders('arg');
			// load args for this code
			$placeholder = $this->getPlaceHolder($placeholderType, $item['id']);
			$code['[CUSTOM' . 'CODE=' . $keyPlaceholder . ']'] = $placeholder['start'] . PHP_EOL . $this->setPlaceholders($item['code'], $this->placeholders) . $placeholder['end'];
		}
	}

	/**
	 * Set a type of placeholder with set of values
	 * 
	 * @param   string   $key     The main string for placeholder key
	 * @param   array    $values  The values to add
	 *
	 * @return  void
	 */
	public function setThesePlaceHolders($key, $values)
	{
		// aways fist reset these
		$this->clearFromPlaceHolders($key);
		if (ComponentbuilderHelper::checkArray($values))
		{
			$number = 0;
			foreach ($values as $value)
			{
				$this->placeholders[$this->bbb . $key . $number . $this->ddd] = $value;
				$number++;
			}
		}
	}

	/**
	 * Remove a type of placeholder by main string
	 * 
	 * @param   string   $like     The main string for placeholder key
	 *
	 * @return  void
	 */
	public function clearFromPlaceHolders($like)
	{
		foreach ($this->placeholders as $something => $value)
		{
			if (stripos($something, $like) !== false)
			{
				unset($this->placeholders[$something]);
			}
		}
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
	 * @param   array    $values  The lang strings to get
	 * 
	 *
	 * @return  void
	 * 
	 */
	public function getMultiLangStrings($values)
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->from($this->db->quoteName('#__componentbuilder_language_translation', 'a'));
		if (ComponentbuilderHelper::checkArray($values))
		{
			$query->select($this->db->quoteName(array('a.id', 'a.translation', 'a.source', 'a.components', 'a.published')));
			$query->where($this->db->quoteName('a.source') . ' IN (' . implode(',', array_map(function($a)
					{
						return $this->db->quote($a);
					}, $values)) . ')');
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
	public function setLangPlaceholders($strings)
	{
		$counterInsert = 0;
		$counterUpdate = 0;
		$today = JFactory::getDate()->toSql();
		foreach ($this->languages[$this->langTag] as $area => $placeholders)
		{
			foreach ($placeholders as $placeholder => $string)
			{
				// to keep or remove
				$remove = false;
				// build the tranlations
				if (ComponentbuilderHelper::checkString($string) && isset($this->multiLangString[$string]))
				{
					// make sure we have converted the string to array
					if (isset($this->multiLangString[$string]['translation']) && ComponentbuilderHelper::checkJson($this->multiLangString[$string]['translation']))
					{
						$this->multiLangString[$string]['translation'] = json_decode($this->multiLangString[$string]['translation'], true);
					}
					// if we have an array continue
					if (isset($this->multiLangString[$string]['translation']) && ComponentbuilderHelper::checkArray($this->multiLangString[$string]['translation']))
					{
						// great lets build the multi languages strings
						foreach ($this->multiLangString[$string]['translation'] as $translations)
						{
							if (isset($translations['language']) && isset($translations['translation']))
							{
								// build arrays
								if (!isset($this->languages[$translations['language']]))
								{
									$this->languages[$translations['language']] = array();
								}
								if (!isset($this->languages[$translations['language']][$area]))
								{
									$this->languages[$translations['language']][$area] = array();
								}
								$this->languages[$translations['language']][$area][$placeholder] = $translations['translation'];
							}
						}
					}
					else
					{
						// remove this string not to be checked again
						$remove = true;
					}
				}
				// do the database managment
				if (ComponentbuilderHelper::checkString($string) && ($key = array_search($string, $strings)) !== false)
				{
					if (isset($this->multiLangString[$string]))
					{
						// update the existing placeholder in db
						$id = $this->multiLangString[$string]['id'];
						if (ComponentbuilderHelper::checkJson($this->multiLangString[$string]['components']))
						{
							$components = (array) json_decode($this->multiLangString[$string]['components'], true);
							// check if we should add the component ID
							if (in_array($this->componentID, $components))
							{
								// only skip the update if the string is published and has the component ID
								if ($this->multiLangString[$string]['published'] == 1)
								{
									continue;
								}
							}
							else
							{
								$components[] = $this->componentID;
							}
						}
						else
						{
							$components = array($this->componentID);
						}
						// start the bucket for this lang
						$this->setUpdateExistingLangStrings($id, $components, 1, $today, $counterUpdate);

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
						$this->newLangStrings[$counterInsert] = array();
						$this->newLangStrings[$counterInsert][] = $this->db->quote(json_encode(array($this->componentID))); // 'components'
						$this->newLangStrings[$counterInsert][] = $this->db->quote($string);  // 'source'
						$this->newLangStrings[$counterInsert][] = $this->db->quote(1);   // 'published'
						$this->newLangStrings[$counterInsert][] = $this->db->quote($today);  // 'created'
						$this->newLangStrings[$counterInsert][] = $this->db->quote((int) $this->user->id);   // 'created_by'
						$this->newLangStrings[$counterInsert][] = $this->db->quote(1);   // 'version'
						$this->newLangStrings[$counterInsert][] = $this->db->quote(1);   // 'access'

						$counterInsert++;

						// load to db 
						$this->setNewLangStrings(100);
					}
					// only set the string once
					unset($strings[$key]);
				}
			}
		}
		// just to make sure all is done
		$this->setExistingLangStrings();
		$this->setNewLangStrings();
	}

	/**
	 * store the language placeholders
	 * 
	 * @param   int	     $when  To set when to update
	 *
	 * @return  void
	 * 
	 */
	protected function setNewLangStrings($when = 1)
	{
		if (count($this->newLangStrings) >= $when)
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);
			$continue = false;
			// Insert columns.
			$columns = array('components', 'source', 'published', 'created', 'created_by', 'version', 'access');
			// Prepare the insert query.
			$query->insert($this->db->quoteName('#__componentbuilder_language_translation'));
			$query->columns($this->db->quoteName($columns));
			foreach ($this->newLangStrings as $values)
			{
				if (count($values) == 7)
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
			$this->newLangStrings = array();
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
	 * @param   int      $when  To set when to update
	 *
	 * @return  void
	 * 
	 */
	protected function setExistingLangStrings($when = 1)
	{
		if (count($this->existingLangStrings) >= $when)
		{
			foreach ($this->existingLangStrings as $values)
			{
				// Create a new query object.
				$query = $this->db->getQuery(true);
				// Prepare the update query.
				$query->update($this->db->quoteName('#__componentbuilder_language_translation'))->set($values['fields'])->where($values['conditions']);
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
	 * @param   int      $id  To string ID to remove
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

		$query->delete($this->db->quoteName('#__componentbuilder_language_translation'));
		$query->where($conditions);

		$this->db->setQuery($query);
		$this->db->execute();
	}

	/**
	 * Function to purge the unused languge strings
	 * 
	 * @param   string    $values  the active strings
	 *
	 * @return  void
	 * 
	 */
	public function purgeLanuageStrings($values)
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->from($this->db->quoteName('#__componentbuilder_language_translation', 'a'));
		$query->select($this->db->quoteName(array('a.id', 'a.translation', 'a.components')));
		// get all string that are not linked to this component
		$query->where($this->db->quoteName('a.source') . ' NOT IN (' . implode(',', array_map(function($a)
				{
					return $this->db->quote($a);
				}, $values)) . ')');
		$query->where($this->db->quoteName('a.published') . ' = 1');
		$this->db->setQuery($query);
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			$counterUpdate = 0;
			$otherStrings = $this->db->loadAssocList();
			$today = JFactory::getDate()->toSql();
			foreach ($otherStrings as $item)
			{
				if (ComponentbuilderHelper::checkJson($item['components']))
				{
					$components = (array) json_decode($item['components'], true);
					// if component is not found ignore this string, and do nothing
					if (($key = array_search($this->componentID, $components)) !== false)
					{
						// first remove the component from the string
						unset($components[$key]);
						// check if there are more components
						if (ComponentbuilderHelper::checkArray($components))
						{
							// just update the string to unlink the current component
							$this->setUpdateExistingLangStrings($item['id'], $components, 1, $today, $counterUpdate);

							$counterUpdate++;

							// load to db 
							$this->setExistingLangStrings(50);
						}
						// check if this string has been worked on
						elseif (ComponentbuilderHelper::checkJson($item['translation']))
						{
							$translation = json_decode($item['translation'], true);
							if (ComponentbuilderHelper::checkArray($translation))
							{
								// only archive the item and update the string to unlink the current component
								$this->setUpdateExistingLangStrings($item['id'], $components, 2, $today, $counterUpdate);

								$counterUpdate++;

								// load to db 
								$this->setExistingLangStrings(50);
							}
							else
							{
								// remove the string since no translation found and not linked to any other component
								$this->removeExitingLangString($item['id']);
							}
						}
						else
						{
							// remove the string since no translation found and not linked to any other component
							$this->removeExitingLangString($item['id']);
						}
					}
				}
			}
			// load to db 
			$this->setExistingLangStrings();
		}
	}

	/**
	 * just to add lang string to the existing Lang Strings array
	 * 
	 * @return  void
	 * 
	 */
	protected function setUpdateExistingLangStrings($id, $components, $published, $today, $counterUpdate)
	{
		// start the bucket for this lang
		$this->existingLangStrings[$counterUpdate] = array();
		$this->existingLangStrings[$counterUpdate]['id'] = (int) $id;
		$this->existingLangStrings[$counterUpdate]['conditions'] = array();
		$this->existingLangStrings[$counterUpdate]['conditions'][] = $this->db->quoteName('id') . ' = ' . $this->db->quote($id);
		$this->existingLangStrings[$counterUpdate]['fields'] = array();
		$this->existingLangStrings[$counterUpdate]['fields'][] = $this->db->quoteName('components') . ' = ' . $this->db->quote(json_encode($components));
		$this->existingLangStrings[$counterUpdate]['fields'][] = $this->db->quoteName('published') . ' = ' . $this->db->quote($published);
		$this->existingLangStrings[$counterUpdate]['fields'][] = $this->db->quoteName('modified') . ' = ' . $this->db->quote($today);
		$this->existingLangStrings[$counterUpdate]['fields'][] = $this->db->quoteName('modified_by') . ' = ' . $this->db->quote((int) $this->user->id);
	}

	/**
	 * get the custom code from the system
	 * 
	 * @return  void
	 * 
	 */
	public function getCustomCode($ids = null, $setLang = true, $debug = 0)
	{
		// should the result be stored in memory
		$loadInMemory = false;
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->from($this->db->quoteName('#__componentbuilder_custom_code', 'a'));
		if (ComponentbuilderHelper::checkArray($ids))
		{
			if ($idArray = $this->checkCustomCodeMemory($ids))
			{
				$query->select($this->db->quoteName(array('a.id', 'a.code', 'a.comment_type')));
				$query->where($this->db->quoteName('a.id') . ' IN (' . implode(',', $idArray) . ')');
				$query->where($this->db->quoteName('a.target') . ' = 2'); // <--- to load the correct target
				$loadInMemory = true;
			}
			else
			{
				// all values are already in memory continue
				return true;
			}
		}
		else
		{
			$query->select($this->db->quoteName(array('a.id', 'a.code', 'a.comment_type', 'a.component', 'a.from_line', 'a.hashtarget', 'a.hashendtarget', 'a.path', 'a.to_line', 'a.type')));
			$query->where($this->db->quoteName('a.component') . ' = ' . (int) $this->componentData->id);
			$query->where($this->db->quoteName('a.target') . ' = 1'); // <--- to load the correct target
			$query->order($this->db->quoteName('a.from_line') . ' ASC'); // <--- insrue we always add code from top of file
			// reset custom code
			$this->customCode = array();
		}
		$query->where($this->db->quoteName('a.published') . ' >= 1');
		$this->db->setQuery($query);
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			$bucket = $this->db->loadAssocList('id');
			// open the code
			foreach ($bucket as $nr => &$customCode)
			{
				$customCode['code'] = base64_decode($customCode['code']);
				// always insure that the external code is loaded
				$customCode['code'] = $this->setExternalCodeString($customCode['code']);
				// set the lang only if needed
				if ($setLang)
				{
					$customCode['code'] = $this->setLangStrings($customCode['code']);
				}
				// check for more custom code (since this is a custom code placeholder)
				else
				{
					$customCode['code'] = $this->setCustomCodeData($customCode['code'], $debug, $nr);
				}
				// build the hash array
				if (isset($customCode['hashtarget']))
				{
					$customCode['hashtarget'] = explode("__", $customCode['hashtarget']);
					// is this a replace code, set end has array
					if ($customCode['type'] == 1 && strpos($customCode['hashendtarget'], '__') !== false)
					{
						$customCode['hashendtarget'] = explode("__", $customCode['hashendtarget']);
						// NOW see if this is an end of page target (TODO not sure if the string is always d41d8cd98f00b204e9800998ecf8427e)
						// I know this fix is not air-tight, but it should work as the value of an empty line when md5'ed is ^^^^
						// Then if the line number is only >>>one<<< it is almost always end of the page.
						// So I am using those two values to detect end of page replace ending, to avoid mismatching the ending target hash.
						if ($customCode['hashendtarget'][0] == 1 && 'd41d8cd98f00b204e9800998ecf8427e' === $customCode['hashendtarget'][1])
						{
							// unset since this will force the replacement unto end of page.
							unset($customCode['hashendtarget']);
						}
					}
				}
			}
			// load this code into memory if needed
			if ($loadInMemory === true)
			{
				$this->customCodeMemory = $this->customCodeMemory + $bucket;
			}
			$this->customCode = array_merge($this->customCode, $bucket);
			return true;
		}
		return false;
	}

	/**
	 * check if we already have these ids in local memory
	 * 
	 * @return  void
	 * 
	 */
	protected function checkCustomCodeMemory($ids)
	{
		// reset custom code
		$this->customCode = array();
		foreach ($ids as $pointer => $id)
		{
			if (isset($this->customCodeMemory[$id]))
			{
				$this->customCode[] = $this->customCodeMemory[$id];
				unset($ids[$pointer]);
			}
		}
		// check if any ids left to fetch
		if (ComponentbuilderHelper::checkArray($ids))
		{
			return $ids;
		}
		return false;
	}

	/**
	 * store the code
	 * 
	 * @param   int	     $when  To set when to update
	 *
	 * @return  void
	 * 
	 */
	protected function setNewCustomCode($when = 1)
	{
		if (count($this->newCustomCode) >= $when)
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);
			$continue = false;
			// Insert columns.
			$columns = array('path', 'type', 'target', 'comment_type', 'component', 'published', 'created', 'created_by', 'version', 'access', 'hashtarget', 'from_line', 'to_line', 'code', 'hashendtarget');
			// Prepare the insert query.
			$query->insert($this->db->quoteName('#__componentbuilder_custom_code'));
			$query->columns($this->db->quoteName($columns));
			foreach ($this->newCustomCode as $values)
			{
				if (count($values) == 15)
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
			$this->newCustomCode = array();
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
	 * store the code
	 * 
	 * @param   int	     $when  To set when to update
	 *
	 * @return  void
	 * 
	 */
	protected function setExistingCustomCode($when = 1)
	{
		if (count($this->existingCustomCode) >= $when)
		{
			foreach ($this->existingCustomCode as $code)
			{
				// Create a new query object.
				$query = $this->db->getQuery(true);
				// Prepare the update query.
				$query->update($this->db->quoteName('#__componentbuilder_custom_code'))->set($code['fields'])->where($code['conditions']);
				// Set the query using our newly populated query object and execute it.
				$this->db->setQuery($query);
				$this->db->execute();
			}
			// clear the values array
			$this->existingCustomCode = array();
		}
	}

	/**
	 * get the custom code from the local files
	 * 
	 * @param   array   $paths  The local paths to parse
	 * @param   string  $today  The date for today
	 *
	 * @return  void
	 * 
	 */
	protected function customCodeFactory(&$paths, &$today)
	{
		// we must first store the current woking directory
		$joomla = getcwd();
		$counter = array(1 => 0, 2 => 0);
		// file types to get
		$fileTypes = array('\.php', '\.js');
		// set some local placeholders
		$placeholders = array();
		$placeholders[ComponentbuilderHelper::safeString($this->componentCodeName, 'F') . 'Helper::'] = $this->bbb . 'Component' . $this->ddd . 'Helper::';
		$placeholders['COM_' . ComponentbuilderHelper::safeString($this->componentCodeName, 'U')] = 'COM_' . $this->bbb . 'COMPONENT' . $this->ddd;
		$placeholders['com_' . $this->componentCodeName] = 'com_' . $this->bbb . 'component' . $this->ddd;

		foreach ($paths as $target => $path)
		{
			// we are changing the working directory to the componet path
			chdir($path);
			foreach ($fileTypes as $type)
			{
				// get a list of files in the current directory tree (only PHP and JS for now)
				$files = JFolder::files('.', $type, true, true);
				foreach ($files as $file)
				{
					$this->searchFileContent($counter, $file, $target, $this->customCodePlaceholders, $placeholders, $today);
					// insert new code
					if (ComponentbuilderHelper::checkArray($this->newCustomCode))
					{
						$this->setNewCustomCode(100);
					}
					// update existing custom code
					if (ComponentbuilderHelper::checkArray($this->existingCustomCode))
					{
						$this->setExistingCustomCode(30);
					}
				}
			}
		}
		// change back to Joomla working directory
		chdir($joomla);
		// make sure all code is stored
		if (ComponentbuilderHelper::checkArray($this->newCustomCode))
		{
			$this->setNewCustomCode();
		}
		// update existing custom code
		if (ComponentbuilderHelper::checkArray($this->existingCustomCode))
		{
			$this->setExistingCustomCode();
		}
	}

	/**
	 * search a file for placeholders and store result
	 * 
	 * @param   array   $counter      The counter for the arrays
	 * @param   string  $file         The file path to search
	 * @param   array   $searchArray  The values to search for
	 * @param   array   $placeholders The values to replace in the code being stored
	 * @param   string  $today        The date for today
	 *
	 * @return  array    on success
	 * 
	 */
	protected function searchFileContent(&$counter, &$file, &$target, &$searchArray, &$placeholders, &$today)
	{
		// reset each time per file
		$loadEndFingerPrint = false;
		$endFingerPrint = array();
		$fingerPrint = array();
		$codeBucket = array();
		$pointer = array();
		$reading = array();
		$reader = 0;
		// reset found Start type
		$commentType = 0;
		// make sure we have the path correct (the script file is not in admin path for example)
		// there may be more... will nead to keep our eye on this... since files could be moved during install
		$file = str_replace(  './', '', $file); # TODO (windows path issues)
		if ($file !== 'script.php')
		{
			$path = $target . '/' . $file;
		}
		else
		{
			$path = $file;
		}
		// now we go line by line
		foreach (new SplFileObject($file) as $lineNumber => $lineContent)
		{
			// we musk keep last few lines to dynamic find target entry later
			$fingerPrint[$lineNumber] = trim($lineContent);
			// load the end fingerprint
			if ($loadEndFingerPrint)
			{
				$endFingerPrint[$lineNumber] = trim($lineContent);
			}
			foreach ($searchArray as $type => $search)
			{
				$i = (int) ($type == 3 || $type == 4) ? 2 : 1;
				$_type = (int) ($type == 1 || $type == 3) ? 1 : 2;
				if ($reader === 0 || $reader === $i)
				{
					$targetKey = $type;
					$start = '/***[' . $search . '***/';
					$end = '/***[/' . $search . '***/';
					$startHTML = '<!--[' . $search . '-->';
					$endHTML = '<!--[/' . $search . '-->';
					// check if the ending place holder was found
					if (isset($reading[$targetKey]) && $reading[$targetKey] &&
						((trim($lineContent) === $end || strpos($lineContent, $end) !== false) ||
						(trim($lineContent) === $endHTML || strpos($lineContent, $endHTML) !== false)))
					{
						// trim the placeholder and if there is still data then load it
						if ($_line = $this->addLineChecker($endReplace, 2, $lineContent))
						{
							$codeBucket[$pointer[$targetKey]][] = $_line;
						}
						// deactivate the reader
						$reading[$targetKey] = false;
						if ($_type == 2)
						{
							// deactivate search
							$reader = 0;
						}
						else
						{
							// activate fingerPrint for replacement end target
							$loadEndFingerPrint = true;
							$backupTargetKey = $targetKey;
							$backupI = $i;
						}
						// all new records we can do a bulk insert
						if ($i === 1)
						{
							// end the bucket info for this code block
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote((int) $lineNumber);   // 'toline'
							// first reverse engineer this code block
							$c0de = $this->reversePlaceholders(implode('', $codeBucket[$pointer[$targetKey]]), $placeholders);
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote(base64_encode($c0de));  // 'code'
							if ($_type == 2)
							{
								// load the last value
								$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote(0); // 'hashendtarget'
							}
						}
						// the record already exist so we must update instead
						elseif ($i === 2)
						{
							// end the bucket info for this code block
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('to_line') . ' = ' . $this->db->quote($lineNumber);
							// first reverse engineer this code block
							$c0de = $this->reversePlaceholders(implode('', $codeBucket[$pointer[$targetKey]]), $placeholders, $this->existingCustomCode[$pointer[$targetKey]]['id']);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('code') . ' = ' . $this->db->quote(base64_encode($c0de));
							if ($_type == 2)
							{
								// load the last value
								$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('hashendtarget') . ' = ' . $this->db->quote(0);
							}
						}
					}
					// check if the endfingerprint is ready to save
					if (count($endFingerPrint) === 3)
					{
						$hashendtarget = '3__' . md5(implode('', $endFingerPrint));
						// all new records we can do a bulk insert
						if ($i === 1)
						{
							// load the last value
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote($hashendtarget); // 'hashendtarget'
						}
						// the record already exist so we must use module to update
						elseif ($i === 2)
						{
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('hashendtarget') . ' = ' . $this->db->quote($hashendtarget);
						}
						// reset the needed values
						$endFingerPrint = array();
						$loadEndFingerPrint = false;
						// deactivate reader (to allow other search)
						$reader = 0;
					}
					// then read in the code
					if (isset($reading[$targetKey]) && $reading[$targetKey])
					{
						$codeBucket[$pointer[$targetKey]][] = $lineContent;
					}
					// see if the custom code line starts now with PHP/JS comment type
					if ((!isset($reading[$targetKey]) || !$reading[$targetKey]) && (($i === 1 && trim($lineContent) === $start) || strpos($lineContent, $start) !== false))
					{
						$commentType = 1; // PHP/JS type
						$startReplace = $start;
						$endReplace = $end;
					}
					// see if the custom code line starts now with HTML comment type
					elseif ((!isset($reading[$targetKey]) || !$reading[$targetKey]) && (($i === 1 && trim($lineContent) === $startHTML) || strpos($lineContent, $startHTML) !== false))
					{
						$commentType = 2; // HTML type
						$startReplace = $startHTML;
						$endReplace = $endHTML;
					}
					// check if the starting place holder was found
					if ($commentType > 0)
					{
						// if we have all on one line we have a problem (don't load it TODO)
						if (strpos($lineContent, $endReplace) !== false)
						{
							// reset found comment type
							$commentType = 0;
							$this->app->enqueueMessage(JText::_('<hr /><h3>Custom Codes Warning</h3>'), 'Warning');
							$this->app->enqueueMessage(JText::sprintf('We found dynamic code <b>all in one line</b>, and ignored it! Please review (%s) for more details!', $path), 'Warning');
							continue;
						}
						// do a quick check to insure we have an id
						$id = false;
						if ($i === 2)
						{
							$id = $this->getSystemID($lineContent, array(1 => $start, 2 => $startHTML), $commentType);
						}
						if ($i === 2 && $id > 0)
						{
							// make sure we update it only once even if found again.
							if (isset($this->codeAreadyDone[$id]))
							{
								// reset found comment type
								$commentType = 0;
								continue;
							}
							// store the id to avoid duplication
							$this->codeAreadyDone[$id] = (int) $id;
						}
						// start replace
						$startReplace = $this->setStartReplace($id, $commentType, $startReplace);
						// set active reader (to lock out other search)
						$reader = $i;
						// set pointer
						$pointer[$targetKey] = $counter[$i];
						// activate the reader
						$reading[$targetKey] = true;
						// start code bucket
						$codeBucket[$pointer[$targetKey]] = array();
						// trim the placeholder and if there is still data then load it
						if ($_line = $this->addLineChecker($startReplace, 1, $lineContent))
						{
							$codeBucket[$pointer[$targetKey]][] = $_line;
						}
						// get the finger print around the custom code
						$inFinger = count($fingerPrint);
						$getFinger = $inFinger - 1;
						$hasharray = array_slice($fingerPrint, -$inFinger, $getFinger, true);
						$hasleng = count($hasharray);
						$hashtarget = $hasleng . '__' . md5(implode('', $hasharray));
						// for good practice
						ComponentbuilderHelper::fixPath($path);
						// all new records we can do a buldk insert
						if ($i === 1 || !$id)
						{
							// start the bucket for this code
							$this->newCustomCode[$pointer[$targetKey]] = array();
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote($path);   // 'path'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote((int) $_type);  // 'type'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote(1); // 'target'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote($commentType);  // 'comment_type'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote((int) $this->componentID); // 'component'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote(1); // 'published'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote($today);   // 'created'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote((int) $this->user->id); // 'created_by'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote(1); // 'version'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote(1); // 'access'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote($hashtarget);  // 'hashtarget'
							$this->newCustomCode[$pointer[$targetKey]][] = $this->db->quote((int) $lineNumber);  // 'fromline'
						}
						// the record already exist so we must update instead
						elseif ($i === 2 && $id > 0)
						{
							// start the bucket for this code
							$this->existingCustomCode[$pointer[$targetKey]] = array();
							$this->existingCustomCode[$pointer[$targetKey]]['id'] = (int) $id;
							$this->existingCustomCode[$pointer[$targetKey]]['conditions'] = array();
							$this->existingCustomCode[$pointer[$targetKey]]['conditions'][] = $this->db->quoteName('id') . ' = ' . $this->db->quote($id);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'] = array();
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('path') . ' = ' . $this->db->quote($path);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('type') . ' = ' . $this->db->quote($_type);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('comment_type') . ' = ' . $this->db->quote($commentType);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('component') . ' = ' . $this->db->quote($this->componentID);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('from_line') . ' = ' . $this->db->quote($lineNumber);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('modified') . ' = ' . $this->db->quote($today);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('modified_by') . ' = ' . $this->db->quote($this->user->id);
							$this->existingCustomCode[$pointer[$targetKey]]['fields'][] = $this->db->quoteName('hashtarget') . ' = ' . $this->db->quote($hashtarget);
						}
						else // this should actualy never happen
						{
							// de activate the reader
							$reading[$targetKey] = false;
							$reader = 0;
						}
						// reset found comment type
						$commentType = 0;
						// update the counter
						$counter[$i] ++;
					}
				}
			}
			// make sure only a few lines is kept at a time
			if (count($fingerPrint) > 10)
			{
				$fingerPrint = array_slice($fingerPrint, -6, 6, true);
			}
		}
		// if the code is at the end of the page and there were not three more lines
		if (count($endFingerPrint) > 0 || $loadEndFingerPrint)
		{
			if (count($endFingerPrint) > 0)
			{
				$leng = count($endFingerPrint);
				$hashendtarget = $leng . '__' . md5(implode('', $endFingerPrint));
			}
			else
			{
				$hashendtarget = 0;
			}
			// all new records we can do a buldk insert
			if ($backupI === 1)
			{
				// load the last value
				$this->newCustomCode[$pointer[$backupTargetKey]][] = $this->db->quote($hashendtarget); // 'hashendtarget'
			}
			// the record already exist so we must use module to update
			elseif ($backupI === 2)
			{
				$this->existingCustomCode[$pointer[$backupTargetKey]]['fields'][] = $this->db->quoteName('hashendtarget') . ' = ' . $this->db->quote($hashendtarget);
			}
		}
	}

	/**
	 * Check if this line should be added
	 * 
	 * @param   strin    $replaceKey   The key to remove from line
	 * @param   int      $type         The line type
	 * @param   string   $lineContent  The line to check
	 *
	 * @return  bool true    on success
	 * 
	 */
	protected function addLineChecker($replaceKey, $type, $lineContent)
	{
		$check = explode($replaceKey, $lineContent);
		switch ($type)
		{
			case 1:
				// beginning of code
				$i = trim($check[1]);
				if (ComponentbuilderHelper::checkString($i))
				{
					return $check[1];
				}
				break;
			case 2:
				// end of code
				$i = trim($check[0]);
				if (ComponentbuilderHelper::checkString($i))
				{
					return $check[0];
				}
				break;
		}
		return false;
	}

	/**
	 * set the start replace placeholder
	 * 
	 * @param   int      $id           The comment id
	 * @param   int      $commentType  The comment type
	 * @param   string   $startReplace The main replace string
	 *
	 * @return  array    on success
	 * 
	 */
	protected function setStartReplace($id, $commentType, $startReplace)
	{
		if ($id > 0)
		{
			switch ($commentType)
			{
				case 1: // the PHP & JS type
					$startReplace .= '/*' . $id . '*/';
					break;
				case 2: // the HTML type
					$startReplace .= '<!--' . $id . '-->';
					break;
			}
		}
		return $startReplace;
	}

	/**
	 * search for the system id in the line given
	 * 
	 * @param   string   $lineContent  The file path to search
	 * @param   string   $placeholders The values to search for
	 * @param   int      $commentType  The comment type
	 *
	 * @return  array    on success
	 * 
	 */
	protected function getSystemID(&$lineContent, $placeholders, $commentType)
	{
		$trim = '/';
		if ($commentType == 2)
		{
			$trim = '<!--';
		}
		// remove place holder from content
		$string = trim(str_replace($placeholders[$commentType] . $trim, '', $lineContent));
		// now get all numbers
		$numbers = array();
		preg_match_all('!\d+!', $string, $numbers);
		// return the first number
		if (isset($numbers[0]) && ComponentbuilderHelper::checkArray($numbers[0]))
		{
			return reset($numbers[0]);
		}
		return false;
	}

	/**
	 * Reverse Engineer the dynamic placeholders (TODO hmmmm this is not ideal)
	 * 
	 * @param   string   $string       The string to revers
	 * @param   int      $id           The custom code id
	 * @param   array    $placeholders The values to search for
	 *
	 * @return  string
	 * 
	 */
	protected function reversePlaceholders($string, &$placeholders, $id = null)
	{
		// get local code if set
		if ($id > 0 && $code = base64_decode(ComponentbuilderHelper::getVar('custom_code', $id, 'id', 'code')))
		{
			$string = $this->setReverseLangPlaceholders($string, $code);
		}
		return $this->setPlaceholders($string, $placeholders, 2);
	}

	/**
	 * Set the langs strings for the reveres prossess
	 * 
	 * @param   string   $updateString   The string to update
	 * @param   string   $string         The string to use lang update
	 *
	 * @return  array
	 * 
	 */
	protected function setReverseLangPlaceholders($updateString, $string)
	{
		// get targets to search for
		$langStringTargets = array_filter(
			$this->langStringTargets, function($get) use($string)
		{
			if (strpos($string, $get) !== false)
			{
				return true;
			}
			return false;
		});
		// check if we should continue
		if (ComponentbuilderHelper::checkArray($langStringTargets))
		{
			$langHolders = array();
			// set the lang for both since we don't know what area is being targeted
			$_tmp = $this->lang;
			$this->lang = 'both';
			// set language data
			foreach ($langStringTargets as $langStringTarget)
			{
				$langCheck[] = ComponentbuilderHelper::getAllBetween($string, $langStringTarget . "'", "'");
				$langCheck[] = ComponentbuilderHelper::getAllBetween($string, $langStringTarget . "'", "'");
			}
			// merge arrays
			$langArray = ComponentbuilderHelper::mergeArrays($langCheck);
			// continue only if strings were found
			if (ComponentbuilderHelper::checkArray($langArray)) //<-- not really needed hmmm
			{
				foreach ($langArray as $lang)
				{
					$_keyLang = ComponentbuilderHelper::safeString($lang, 'U');
					// this is there to insure we dont break already added Language strings
					if ($_keyLang === $lang)
					{
						continue;
					}
					// only load if string is not already set
					$keyLang = $this->langPrefix . '_' . $_keyLang;
					if (!isset($this->langContent[$this->lang][$keyLang]))
					{
						$this->langContent[$this->lang][$keyLang] = trim($lang);
					}
					// reverse the placeholders
					foreach ($langStringTargets as $langStringTarget)
					{
						$langHolders[$langStringTarget . "'" . $keyLang . "'"] = $langStringTarget . "'" . $lang . "'";
						$langHolders[$langStringTarget . '"' . $keyLang . '"'] = $langStringTarget . '"' . $lang . '"';
					}
				}
				// return the found placeholders
				$updateString = $this->setPlaceholders($updateString, $langHolders);
			}
			// reset the lang
			$this->lang = $_tmp;
		}
		return $updateString;
	}

	/**
	 * Update the data with the placeholders
	 * 
	 * @param   string   $data          The actual data
	 * @param   array    $placeholder   The placeholders
	 * @param   int      $action        The action to use
	 * 
	 * THE ACTION OPTIONS ARE
	 * 1 -> Just replace (default)
	 * 2 -> Check if data string has placeholders
	 * 3 -> Remove placeholders not in data string
	 * 
	 * @param   int      $langSwitch    The lang switch
	 *
	 * @return  string
	 * 
	 */
	public function setPlaceholders($data, &$placeholder, $action = 1)
	{
		// make sure the placeholders is an array
		if (!ComponentbuilderHelper::checkArray($placeholder))
		{
			// This is an error, (TODO) actualy we need to add a kind of log here to know that this happened
			return $data;
		}
		// continue with the work of replacement
		if (1 == $action) // <-- just replace (default)
		{
			return str_replace(array_keys($placeholder), array_values($placeholder), $data);
		}
		elseif (2 == $action) // <-- check if data string has placeholders
		{
			$replace = false;
			foreach ($placeholder as $key => $val)
			{
				if (strpos($data, $key) !== FALSE)
				{
					$replace = true;
					break;
				}
			}
			// only replace if the data has these placeholder values
			if ($replace === true)
			{

				return str_replace(array_keys($placeholder), array_values($placeholder), $data);
			}
		}
		elseif (3 == $action) // <-- remove placeholders not in data string
		{
			$replace = $placeholder;
			foreach ($replace as $key => $val)
			{
				if (strpos($data, $key) === FALSE)
				{
					unset($replace[$key]);
				}
			}
			// only replace if the data has these placeholder values
			if (ComponentbuilderHelper::checkArray($replace))
			{
				return str_replace(array_keys($replace), array_values($replace), $data);
			}
		}
		return $data;
	}

	/**
	 * return the placeholders for inserted and replaced code
	 * 
	 * @param   int      $type  The type of placement
	 * @param   int      $id    The code id in the system
	 *
	 * @return  array    on success
	 * 
	 */
	public function getPlaceHolder($type, $id)
	{
		switch ($type)
		{
			case 11:
				//***[REPLACED$$$$]***//*1*/
				if ($this->addPlaceholders === true)
				{
					return array(
						'start' => '/***[REPLACED$$$$]***//*' . $id . '*/',
						'end' => '/***[/REPLACED$$$$]***/');
				}
				else
				{
					return array(
						'start' => "",
						'end' => "");
				}
				break;
			case 12:
				//***[INSERTED$$$$]***//*1*/
				if ($this->addPlaceholders === true)
				{
					return array(
						'start' => '/***[INSERTED$$$$]***//*' . $id . '*/',
						'end' => '/***[/INSERTED$$$$]***/');
				}
				else
				{
					return array(
						'start' => "",
						'end' => "");
				}
				break;
			case 21:
				//<!--[REPLACED$$$$]--><!--1-->
				if ($this->addPlaceholders === true)
				{
					return array(
						'start' => '<!--[REPLACED$$$$]--><!--' . $id . '-->',
						'end' => '<!--[/REPLACED$$$$]-->');
				}
				else
				{
					return array(
						'start' => "",
						'end' => "");
				}
				break;
			case 22:
				//<!--[INSERTED$$$$]--><!--1-->
				if ($this->addPlaceholders === true)
				{
					return array(
						'start' => '<!--[INSERTED$$$$]--><!--' . $id . '-->',
						'end' => '<!--[/INSERTED$$$$]-->');
				}
				else
				{
					return array(
						'start' => "",
						'end' => " ");
				}
				break;
			case 3:
				return array(
					'start' => "",
					'end' => "");
				break;
		}
		return false;
	}

	/**
	 * get the local installed path of this component
	 *
	 * @return  array   of paths on success
	 * 
	 */
	protected function getLocalInstallPaths()
	{
		// set the local paths to search
		$localPaths = array();
		// admin path
		$localPaths['admin'] = JPATH_ADMINISTRATOR . '/components/com_' . $this->componentCodeName;
		// site path
		$localPaths['site'] = JPATH_ROOT . '/components/com_' . $this->componentCodeName;
		// TODO later to include the JS and CSS
		$localPaths['media'] = JPATH_ROOT . '/media/com_' . $this->componentCodeName;
		// check if the local install is found
		foreach ($localPaths as $key => $localPath)
		{
			if (!JFolder::exists($localPath))
			{
				unset($localPaths[$key]);
			}
		}
		if (ComponentbuilderHelper::checkArray($localPaths))
		{
			return $localPaths;
		}
		return false;
	}

}
