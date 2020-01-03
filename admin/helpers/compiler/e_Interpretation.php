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
 * Compiler class
 */
class Interpretation extends Fields
{

	/**
	 * The global config Field Sets
	 *
	 * @var     array
	 */
	public $configFieldSets = array();

	/**
	 * The global config Field Sets Custom Fields
	 *
	 * @var     array
	 */
	public $configFieldSetsCustomField = array();

	/**
	 * The contributors
	 *
	 * @var    string
	 */
	public $theContributors = '';

	/**
	 * The unistall builder
	 *
	 * @var    array
	 */
	public $uninstallBuilder = array();

	/**
	 * The update SQL builder
	 *
	 * @var    array
	 */
	public $updateSQLBuilder = array();

	/**
	 * The List Column Builder
	 *
	 * @var    array
	 */
	public $listColnrBuilder = array();

	/**
	 * The permissions Builder
	 *
	 * @var    array
	 */
	public $permissionBuilder = array();

	/**
	 * The dashboard permissions builder
	 *
	 * @var    array
	 */
	public $permissionDashboard = array();

	/**
	 * The permissions core
	 *
	 * @var    array
	 */
	public $permissionCore = array();

	/**
	 * The customs field builder
	 *
	 * @var    array
	 */
	public $customFieldBuilder = array();

	/**
	 * The category builder
	 *
	 * @var    array
	 */
	public $buildCategories = array();

	/**
	 * The icon builder
	 *
	 * @var    array
	 */
	public $iconBuilder = array();

	/**
	 * The validation fix builder
	 *
	 * @var    array
	 */
	public $validationFixBuilder = array();

	/**
	 * The view script builder
	 *
	 * @var    array
	 */
	public $viewScriptBuilder = array();

	/**
	 * The target relation control
	 *
	 * @var    array
	 */
	public $targetRelationControl = array();

	/**
	 * The target control script checker
	 *
	 * @var    array
	 */
	public $targetControlsScriptChecker = array();

	/**
	 * The router helper
	 *
	 * @var    array
	 */
	public $setRouterHelpDone = array();

	/**
	 * The other where
	 *
	 * @var    array
	 */
	public $otherWhere = array();

	/**
	 * The dashboard get custom data
	 *
	 * @var    array
	 */
	public $DashboardGetCustomData = array();

	/**
	 * The custom admin added
	 *
	 * @var    array
	 */
	public $customAdminAdded = array();

	/**
	 * Switch to add form to site views
	 *
	 * @var    array
	 */
	public $addSiteForm = array();

	/**
	 * The extensions params
	 *
	 * @var    array
	 */
	protected $extensionsParams = array();

	/**
	 * The asset rules
	 *
	 * @var    array
	 */
	public $assetsRules = array();

	/**
	 * View Has Category Request
	 *
	 * @var    array
	 */
	protected $hasCatIdRequest = array();

	/**
	 * All fields with permissions
	 *
	 * @var    array
	 */
	public $permissionFields = array();

	/**
	 * Custom Admin View List Link
	 *
	 * @var    array
	 */
	protected $customAdminViewListLink = array();

	/**
	 * load Tracker of fields to fix
	 *
	 * @var    array
	 */
	protected $loadTracker = array();

	/**
	 * View Has Id Request
	 *
	 * @var    array
	 */
	protected $hasIdRequest = array();
	protected $libwarning = array();

	/**
	 * alignment names
	 * 
	 * @var    array
	 */
	protected $alignmentOptions = array(1 => 'left', 2 => 'right', 3 => 'fullwidth', 4 => 'above', 5 => 'under', 6 => 'leftside', 7 => 'rightside');

	/**
	 * Constructor
	 */
	public function __construct($config = array())
	{
		// first we run the perent constructor
		if (parent::__construct($config))
		{
			return true;
		}
		return false;
	}

	/**
	 * Set the line number in comments
	 *
	 * @param   int   $nr  The line number
	 *
	 * @return  string
	 */
	private function setLine($nr)
	{
		if ($this->debugLinenr)
		{
			return ' [Interpretation ' . $nr . ']';
		}
		return '';
	}

	/**
	 * add email helper
	 */
	public function addEmailHelper()
	{
		if (isset($this->componentData->add_email_helper) && $this->componentData->add_email_helper)
		{
			// set email helper in place with component name
			$component = $this->componentCodeName;
			$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
			$target = array('admin' => 'emailer');
			$done = $this->buildDynamique($target, 'emailer', $component);
			if ($done)
			{
				// the text for the file BAKING
				$this->fileContentDynamic['emailer_' . $component][$this->hhh . 'BAKING' . $this->hhh] = ''; // <<-- to insure it gets updated
				// return the code need to load the abstract class
				return PHP_EOL . "JLoader::register('" . $Component . "Email', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/" . $component . "email.php'); ";
			}
		}
		return '';
	}

	/**
	 * set the lock license (NOT OKAY)
	 */
	public function setLockLicense()
	{
		if ($this->componentData->add_license && $this->componentData->license_type == 3)
		{
			if (!isset($this->fileContentStatic[$this->hhh . 'HELPER_SITE_LICENSE_LOCK' . $this->hhh]))
			{
				$_WHMCS = '_' . ComponentbuilderHelper::safeString($this->uniquekey(10), 'U');
				// add it to the system
				$this->fileContentStatic[$this->hhh . 'HELPER_SITE_LICENSE_LOCK' . $this->hhh] = $this->setHelperLicenseLock($_WHMCS, 'site');
				$this->fileContentStatic[$this->hhh . 'HELPER_LICENSE_LOCK' . $this->hhh] = $this->setHelperLicenseLock($_WHMCS, 'admin');
				$this->fileContentStatic[$this->hhh . 'LICENSE_LOCKED_INT' . $this->hhh] = $this->setInitLicenseLock($_WHMCS);
				$this->fileContentStatic[$this->hhh . 'LICENSE_LOCKED_DEFINED' . $this->hhh] = PHP_EOL . PHP_EOL . 'defined(\'' . $_WHMCS . '\') or die(JText:' . ':_(\'NIE_REG_NIE\'));';
			}
		}
		else
		{
			// don't add it to the system
			$this->fileContentStatic[$this->hhh . 'HELPER_SITE_LICENSE_LOCK' . $this->hhh] = '';
			$this->fileContentStatic[$this->hhh . 'HELPER_LICENSE_LOCK' . $this->hhh] = '';
			$this->fileContentStatic[$this->hhh . 'LICENSE_LOCKED_INT' . $this->hhh] = '';
			$this->fileContentStatic[$this->hhh . 'LICENSE_LOCKED_DEFINED' . $this->hhh] = '';
		}
	}

	/**
	 * set Lock License Per
	 *
	 * @param type $view
	 * @param type $target
	 */
	public function setLockLicensePer(&$view, $target)
	{
		if ($this->componentData->add_license && $this->componentData->license_type == 3)
		{
			if (!isset($this->fileContentDynamic[$view][$this->hhh . 'BOOLMETHOD' . $this->hhh]))
			{
				$boolMethod = 'get' . ComponentbuilderHelper::safeString($this->uniquekey(3, false, 'ddd'), 'W');
				$globalbool = 'set' . ComponentbuilderHelper::safeString($this->uniquekey(3), 'W');
				// add it to the system
				$this->fileContentDynamic[$view][$this->hhh . 'LICENSE_LOCKED_SET_BOOL' . $this->hhh] = $this->setBoolLicenseLock($boolMethod, $globalbool);
				$this->fileContentDynamic[$view][$this->hhh . 'LICENSE_LOCKED_CHECK' . $this->hhh] = $this->checkStatmentLicenseLocked($boolMethod);
				$this->fileContentDynamic[$view][$this->hhh . 'LICENSE_TABLE_LOCKED_CHECK' . $this->hhh] = $this->checkStatmentLicenseLocked($boolMethod, '$table');
				$this->fileContentDynamic[$view][$this->hhh . 'BOOLMETHOD' . $this->hhh] = $boolMethod;
			}
		}
		else
		{
			// don't add it to the system
			$this->fileContentDynamic[$view][$this->hhh . 'LICENSE_LOCKED_SET_BOOL' . $this->hhh] = '';
			$this->fileContentDynamic[$view][$this->hhh . 'LICENSE_LOCKED_CHECK' . $this->hhh] = '';
			$this->fileContentDynamic[$view][$this->hhh . 'LICENSE_TABLE_LOCKED_CHECK' . $this->hhh] = '';
		}
	}

	/**
	 * Check statment license locked
	 *
	 * @param type $boolMethod
	 * @param type $thIIS
	 *
	 * @return string
	 */
	public function checkStatmentLicenseLocked($boolMethod, $thIIS = '$this')
	{
		$statment[] = PHP_EOL . $this->_t(2) . "if (!" . $thIIS . "->" . $boolMethod . "())";
		$statment[] = $this->_t(2) . "{";
		$statment[] = $this->_t(3) . "\$app = JFactory::getApplication();";
		$statment[] = $this->_t(3) . "\$app->enqueueMessage(JText:" . ":_('NIE_REG_NIE'), 'error');";
		$statment[] = $this->_t(3) . "\$app->redirect('index.php');";
		$statment[] = $this->_t(3) . "return false;";
		$statment[] = $this->_t(2) . "}";
		// return the genuine mentod statement
		return implode(PHP_EOL, $statment);
	}

	/**
	 * set Bool License Lock
	 *
	 * @param type $boolMethod
	 * @param type $globalbool
	 *
	 * @return string
	 */
	public function setBoolLicenseLock($boolMethod, $globalbool)
	{
		$bool[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$bool[] = $this->_t(1) . " * The private bool.";
		$bool[] = $this->_t(1) . " **/";
		$bool[] = $this->_t(1) . "private $" . $globalbool . ";";
		$bool[] = PHP_EOL . $this->_t(1) . "/**";
		$bool[] = $this->_t(1) . " * Check if this install has a license.";
		$bool[] = $this->_t(1) . " **/";
		$bool[] = $this->_t(1) . "public function " . $boolMethod . "()";
		$bool[] = $this->_t(1) . "{";
		$bool[] = $this->_t(2) . "if(!empty(\$this->" . $globalbool . "))";
		$bool[] = $this->_t(2) . "{";
		$bool[] = $this->_t(3) . "return \$this->" . $globalbool . ";";
		$bool[] = $this->_t(2) . "}";
		$bool[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the global params";
		$bool[] = $this->_t(2) . "\$params = JComponentHelper::getParams('com_" . $this->componentCodeName . "', true);";
		$bool[] = $this->_t(2) . "\$whmcs_key = \$params->get('whmcs_key', null);";
		$bool[] = $this->_t(2) . "if (\$whmcs_key)";
		$bool[] = $this->_t(2) . "{";
		$bool[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " load the file";
		$bool[] = $this->_t(3) . "JLoader::import( 'whmcs', JPATH_ADMINISTRATOR .'/components/com_" . $this->componentCodeName . "');";
		$bool[] = $this->_t(3) . "\$the = new WHMCS(\$whmcs_key);";
		$bool[] = $this->_t(3) . "\$this->" . $globalbool . " = \$the->_is;";
		$bool[] = $this->_t(3) . "return \$this->" . $globalbool . ";";
		$bool[] = $this->_t(2) . "}";
		$bool[] = $this->_t(2) . "return false;";
		$bool[] = $this->_t(1) . "}";
		// return the genuine mentod statement
		return implode(PHP_EOL, $bool);
	}

	/**
	 * set Helper License Lock
	 *
	 * @param type $_WHMCS
	 * @param type $target
	 *
	 * @return string
	 */
	public function setHelperLicenseLock($_WHMCS, $target)
	{
		$helper[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$helper[] = $this->_t(1) . " * Check if this install has a license.";
		$helper[] = $this->_t(1) . " **/";
		$helper[] = $this->_t(1) . "public static function isGenuine()";
		$helper[] = $this->_t(1) . "{";
		$helper[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the global params";
		$helper[] = $this->_t(2) . "\$params = JComponentHelper::getParams('com_" . $this->componentCodeName . "', true);";
		$helper[] = $this->_t(2) . "\$whmcs_key = \$params->get('whmcs_key', null);";
		$helper[] = $this->_t(2) . "if (\$whmcs_key)";
		$helper[] = $this->_t(2) . "{";
		$helper[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " load the file";
		$helper[] = $this->_t(3) . "JLoader::import( 'whmcs', JPATH_ADMINISTRATOR .'/components/com_" . $this->componentCodeName . "');";
		$helper[] = $this->_t(3) . "\$the = new WHMCS(\$whmcs_key);";
		$helper[] = $this->_t(3) . "return \$the->_is;";
		$helper[] = $this->_t(2) . "}";
		$helper[] = $this->_t(2) . "return false;";
		$helper[] = $this->_t(1) . "}";
		// return the genuine mentod statement
		return implode(PHP_EOL, $helper);
	}

	/**
	 * set Init License Lock
	 *
	 * @param type $_WHMCS
	 *
	 * @return string
	 */
	public function setInitLicenseLock($_WHMCS)
	{
		$init[] = PHP_EOL . "if (!defined('" . $_WHMCS . "'))";
		$init[] = "{";
		$init[] = $this->_t(1) . "\$allow = " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::isGenuine();";
		$init[] = $this->_t(1) . "if (\$allow)";
		$init[] = $this->_t(1) . "{";
		$init[] = $this->_t(2) . "define('" . $_WHMCS . "', 1);";
		$init[] = $this->_t(1) . "}";
		$init[] = "}";
		// return the initializing statement
		return implode(PHP_EOL, $init);
	}

	/**
	 * set WHMCS Cryption
	 *
	 * @return string
	 */
	public function setWHMCSCryption()
	{
		// make sure we have the correct file
		if (isset($this->componentData->whmcs_key) && ComponentbuilderHelper::checkString($this->componentData->whmcs_key))
		{
			// Get the basic encryption.
			$basickey = ComponentbuilderHelper::getCryptKey('basic');
			// Get the encryption object.
			$basic = new FOFEncryptAes($basickey);
			if (!empty($this->componentData->whmcs_key) && $basickey && !is_numeric($this->componentData->whmcs_key) && $this->componentData->whmcs_key === base64_encode(base64_decode($this->componentData->whmcs_key, true)))
			{
				// basic decrypt data whmcs_key.
				$this->componentData->whmcs_key = rtrim($basic->decryptString($this->componentData->whmcs_key), "\0");
				// set the needed string to connect to whmcs
				$key["kasier"] = $this->componentData->whmcs_url;
				$key["geheim"] = $this->componentData->whmcs_key;
				$key["onthou"] = 1;
				// prep the call info
				$theKey = base64_encode(serialize($key));
				// set the script
				$encrypt[] = "/**";
				$encrypt[] = "* " . $this->setLine(__LINE__) . "WHMCS Class ";
				$encrypt[] = "**/";
				$encrypt[] = "class WHMCS";
				$encrypt[] = "{";
				$encrypt[] = $this->_t(1) . "public \$_key = false;";
				$encrypt[] = $this->_t(1) . "public \$_is = false;";
				$encrypt[] = PHP_EOL . $this->_t(1) . "public function __construct(\$Vk5smi0wjnjb)";
				$encrypt[] = $this->_t(1) . "{";
				$encrypt[] = $this->_t(2) . "// get the session";
				$encrypt[] = $this->_t(2) . "\$session = JFactory::getSession();";
				$encrypt[] = $this->_t(2) . "\$V2uekt2wcgwk = \$session->get(\$Vk5smi0wjnjb, null);";
				$encrypt[] = $this->_t(2) . "\$h4sgrGsqq = \$this->get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk);";
				$encrypt[] = $this->_t(2) . "if (isset(\$h4sgrGsqq['nuut']) && \$h4sgrGsqq['nuut'] && (isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['eiegrendel']) && strlen(\$h4sgrGsqq['eiegrendel']) > 300)";
				$encrypt[] = $this->_t(2) . "{";
				$encrypt[] = $this->_t(3) . "\$session->set(\$Vk5smi0wjnjb, \$h4sgrGsqq['eiegrendel']);";
				$encrypt[] = $this->_t(2) . "}";
				$encrypt[] = $this->_t(2) . "if ((isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 && isset(\$h4sgrGsqq['customfields']) && strlen(\$h4sgrGsqq['customfields']) > 4)";
				$encrypt[] = $this->_t(2) . "{";
				$encrypt[] = $this->_t(3) . "\$this->_key = md5(\$h4sgrGsqq['customfields']);";
				$encrypt[] = $this->_t(2) . "}";
				$encrypt[] = $this->_t(2) . "if ((isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 )";
				$encrypt[] = $this->_t(2) . "{";
				$encrypt[] = $this->_t(3) . "\$this->_is = true;";
				$encrypt[] = $this->_t(2) . "}";
				$encrypt[] = $this->_t(1) . "}";
				$encrypt[] = PHP_EOL . $this->_t(1) . "private function get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk)";
				$encrypt[] = $this->_t(1) . "{";
				$encrypt[] = $this->_t(2) . "\$Viioj50xuqu2 = unserialize(base64_decode('" . $theKey . "'));";
				$encrypt[] = $this->_t(2) . "\$Visqfrd1caus = time() . md5(mt_rand(1000000000, 9999999999) . \$Vk5smi0wjnjb);";
				$encrypt[] = $this->_t(2) . "\$Vo4tezfgcf3e = date(\"Ymd\");";
				$encrypt[] = $this->_t(2) . "\$Vozblwvfym2f = \$_SERVER['SERVER_NAME'];";
				$encrypt[] = $this->_t(2) . "\$Vozblwvfym2fdie = isset(\$_SERVER['SERVER_ADDR']) ? \$_SERVER['SERVER_ADDR'] : \$_SERVER['LOCAL_ADDR'];";
				$encrypt[] = $this->_t(2) . "\$V343jp03dxco = dirname(__FILE__);";
				$encrypt[] = $this->_t(2) . "\$Vc2rayehw4f0 = unserialize(base64_decode('czozNjoibW9kdWxlcy9zZXJ2ZXJzL2xpY2Vuc2luZy92ZXJpZnkucGhwIjs='));";
				$encrypt[] = $this->_t(2) . "\$Vlpolphukogz = false;";
				$encrypt[] = $this->_t(2) . "if (\$V2uekt2wcgwk) {";
				$encrypt[] = $this->_t(3) . "\$V2uekt2wcgwk = str_replace(\"" . '".PHP_EOL."' . "\", '', \$V2uekt2wcgwk);";
				$encrypt[] = $this->_t(3) . "\$Vm5cxjdc43g4 = substr(\$V2uekt2wcgwk, 0, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = $this->_t(3) . "\$Vbgx0efeu2sy = substr(\$V2uekt2wcgwk, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = $this->_t(3) . "if (\$Vbgx0efeu2sy == md5(\$Vm5cxjdc43g4 . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = $this->_t(4) . "\$Vm5cxjdc43g4 = strrev(\$Vm5cxjdc43g4);";
				$encrypt[] = $this->_t(4) . "\$Vbgx0efeu2sy = substr(\$Vm5cxjdc43g4, 0, 32);";
				$encrypt[] = $this->_t(4) . "\$Vm5cxjdc43g4 = substr(\$Vm5cxjdc43g4, 32);";
				$encrypt[] = $this->_t(4) . "\$Vm5cxjdc43g4 = base64_decode(\$Vm5cxjdc43g4);";
				$encrypt[] = $this->_t(4) . "\$Vm5cxjdc43g4finding = unserialize(\$Vm5cxjdc43g4);";
				$encrypt[] = $this->_t(4) . "\$V3qqz0p00fbq  = \$Vm5cxjdc43g4finding['dan'];";
				$encrypt[] = $this->_t(4) . "if (\$Vbgx0efeu2sy == md5(\$V3qqz0p00fbq  . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = $this->_t(5) . "\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = $this->_t(5) . "if (\$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = $this->_t(6) . "\$Vlpolphukogz = true;";
				$encrypt[] = $this->_t(6) . "\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = $this->_t(6) . "\$Vcixw3trerrt = explode(',', \$Vwasqoybpyed['validdomain']);";
				$encrypt[] = $this->_t(6) . "if (!in_array(\$_SERVER['SERVER_NAME'], \$Vcixw3trerrt)) {";
				$encrypt[] = $this->_t(7) . "\$Vlpolphukogz = false;";
				$encrypt[] = $this->_t(7) . "\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = $this->_t(7) . "\$Vwasqoybpyed = array();";
				$encrypt[] = $this->_t(6) . "}";
				$encrypt[] = $this->_t(6) . "\$Vkni3xyhkqzv = explode(',', \$Vwasqoybpyed['validip']);";
				$encrypt[] = $this->_t(6) . "if (!in_array(\$Vozblwvfym2fdie, \$Vkni3xyhkqzv)) {";
				$encrypt[] = $this->_t(7) . "\$Vlpolphukogz = false;";
				$encrypt[] = $this->_t(7) . "\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = $this->_t(7) . "\$Vwasqoybpyed = array();";
				$encrypt[] = $this->_t(6) . "}";
				$encrypt[] = $this->_t(6) . "\$Vckfvnepoaxj = explode(',', \$Vwasqoybpyed['validdirectory']);";
				$encrypt[] = $this->_t(6) . "if (!in_array(\$V343jp03dxco, \$Vckfvnepoaxj)) {";
				$encrypt[] = $this->_t(7) . "\$Vlpolphukogz = false;";
				$encrypt[] = $this->_t(7) . "\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = $this->_t(7) . "\$Vwasqoybpyed = array();";
				$encrypt[] = $this->_t(6) . "}";
				$encrypt[] = $this->_t(5) . "}";
				$encrypt[] = $this->_t(4) . "}";
				$encrypt[] = $this->_t(3) . "}";
				$encrypt[] = $this->_t(2) . "}";
				$encrypt[] = $this->_t(2) . "if (!\$Vlpolphukogz) {";
				$encrypt[] = $this->_t(3) . "\$V1u0c4dl3ehp = array(";
				$encrypt[] = $this->_t(4) . "'licensekey' => \$Vk5smi0wjnjb,";
				$encrypt[] = $this->_t(4) . "'domain' => \$Vozblwvfym2f,";
				$encrypt[] = $this->_t(4) . "'ip' => \$Vozblwvfym2fdie,";
				$encrypt[] = $this->_t(4) . "'dir' => \$V343jp03dxco,";
				$encrypt[] = $this->_t(3) . ");";
				$encrypt[] = $this->_t(3) . "if (\$Visqfrd1caus) \$V1u0c4dl3ehp['check_token'] = \$Visqfrd1caus;";
				$encrypt[] = $this->_t(3) . "\$Vdsjeyjmpq2o = '';";
				$encrypt[] = $this->_t(3) . "foreach (\$V1u0c4dl3ehp AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = $this->_t(4) . "\$Vdsjeyjmpq2o .= \$V2sgyscukmgi.'='.urlencode(\$V1u00zkzmb1d).'&';";
				$encrypt[] = $this->_t(3) . "}";
				$encrypt[] = $this->_t(3) . "if (function_exists('curl_exec')) {";
				$encrypt[] = $this->_t(4) . "\$Vdathuqgjyf0 = curl_init();";
				$encrypt[] = $this->_t(4) . "curl_setopt(\$Vdathuqgjyf0, CURLOPT_URL, \$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0);";
				$encrypt[] = $this->_t(4) . "curl_setopt(\$Vdathuqgjyf0, CURLOPT_POST, 1);";
				$encrypt[] = $this->_t(4) . "curl_setopt(\$Vdathuqgjyf0, CURLOPT_POSTFIELDS, \$Vdsjeyjmpq2o);";
				$encrypt[] = $this->_t(4) . "curl_setopt(\$Vdathuqgjyf0, CURLOPT_TIMEOUT, 30);";
				$encrypt[] = $this->_t(4) . "curl_setopt(\$Vdathuqgjyf0, CURLOPT_RETURNTRANSFER, 1);";
				$encrypt[] = $this->_t(4) . "\$Vqojefyeohg5 = curl_exec(\$Vdathuqgjyf0);";
				$encrypt[] = $this->_t(4) . "curl_close(\$Vdathuqgjyf0);";
				$encrypt[] = $this->_t(3) . "} else {";
				$encrypt[] = $this->_t(4) . "\$Vrpmu4bvnmkp = fsockopen(\$Viioj50xuqu2['kasier'], 80, \$Vc0t5kmpwkwk, \$Va3g41fnofhu, 5);";
				$encrypt[] = $this->_t(4) . "if (\$Vrpmu4bvnmkp) {";
				$encrypt[] = $this->_t(5) . "\$Vznkm0a0me1y = \"\r" . PHP_EOL . "\";";
				$encrypt[] = $this->_t(5) . "\$V2sgyscukmgiop = \"POST \".\$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0 . \" HTTP/1.0\" . \$Vznkm0a0me1y;";
				$encrypt[] = $this->_t(5) . "\$V2sgyscukmgiop .= \"Host: \".\$Viioj50xuqu2['kasier'] . \$Vznkm0a0me1y;";
				$encrypt[] = $this->_t(5) . "\$V2sgyscukmgiop .= \"Content-type: application/x-www-form-urlencoded\" . \$Vznkm0a0me1y;";
				$encrypt[] = $this->_t(5) . "\$V2sgyscukmgiop .= \"Content-length: \".@strlen(\$Vdsjeyjmpq2o) . \$Vznkm0a0me1y;";
				$encrypt[] = $this->_t(5) . "\$V2sgyscukmgiop .= \"Connection: close\" . \$Vznkm0a0me1y . \$Vznkm0a0me1y;";
				$encrypt[] = $this->_t(5) . "\$V2sgyscukmgiop .= \$Vdsjeyjmpq2o;";
				$encrypt[] = $this->_t(5) . "\$Vqojefyeohg5 = '';";
				$encrypt[] = $this->_t(5) . "@stream_set_timeout(\$Vrpmu4bvnmkp, 20);";
				$encrypt[] = $this->_t(5) . "@fputs(\$Vrpmu4bvnmkp, \$V2sgyscukmgiop);";
				$encrypt[] = $this->_t(5) . "\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = $this->_t(5) . "while (!@feof(\$Vrpmu4bvnmkp)&&\$V2czq24pjexf) {";
				$encrypt[] = $this->_t(6) . "\$Vqojefyeohg5 .= @fgets(\$Vrpmu4bvnmkp, 1024);";
				$encrypt[] = $this->_t(6) . "\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = $this->_t(5) . "}";
				$encrypt[] = $this->_t(5) . "@fclose (\$Vqojefyeohg5);";
				$encrypt[] = $this->_t(4) . "}";
				$encrypt[] = $this->_t(3) . "}";
				$encrypt[] = $this->_t(3) . "if (!\$Vqojefyeohg5) {";
				$encrypt[] = $this->_t(4) . "\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = $this->_t(4) . "if (isset(\$V3qqz0p00fbq) && \$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = $this->_t(5) . "\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = $this->_t(4) . "} else {";
				$encrypt[] = $this->_t(5) . "\$Vwasqoybpyed = array();";
				$encrypt[] = $this->_t(5) . "\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = $this->_t(5) . "\$Vwasqoybpyed['description'] = \"Remote Check Failed\";";
				$encrypt[] = $this->_t(5) . "return \$Vwasqoybpyed;";
				$encrypt[] = $this->_t(4) . "}";
				$encrypt[] = $this->_t(3) . "} else {";
				$encrypt[] = $this->_t(4) . "preg_match_all('" . '/<(.*?)>([^<]+)<\/\\1>/i' . "', \$Vqojefyeohg5, \$V1ot20wob03f);";
				$encrypt[] = $this->_t(4) . "\$Vwasqoybpyed = array();";
				$encrypt[] = $this->_t(4) . "foreach (\$V1ot20wob03f[1] AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = $this->_t(5) . "\$Vwasqoybpyed[\$V1u00zkzmb1d] = \$V1ot20wob03f[2][\$V2sgyscukmgi];";
				$encrypt[] = $this->_t(4) . "}";
				$encrypt[] = $this->_t(3) . "}";
				$encrypt[] = $this->_t(3) . "if (!is_array(\$Vwasqoybpyed)) {";
				$encrypt[] = $this->_t(4) . "die(\"Invalid License Server Response\");";
				$encrypt[] = $this->_t(3) . "}";
				$encrypt[] = $this->_t(3) . "if (isset(\$Vwasqoybpyed['md5hash']) && \$Vwasqoybpyed['md5hash']) {";
				$encrypt[] = $this->_t(4) . "if (\$Vwasqoybpyed['md5hash'] != md5(\$Viioj50xuqu2['geheim'] . \$Visqfrd1caus)) {";
				$encrypt[] = $this->_t(5) . "\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = $this->_t(5) . "\$Vwasqoybpyed['description'] = \"MD5 Checksum Verification Failed\";";
				$encrypt[] = $this->_t(5) . "return \$Vwasqoybpyed;";
				$encrypt[] = $this->_t(4) . "}";
				$encrypt[] = $this->_t(3) . "}";
				$encrypt[] = $this->_t(3) . "if (isset(\$Vwasqoybpyed['status']) && \$Vwasqoybpyed['status'] == \"Active\") {";
				$encrypt[] = $this->_t(4) . "\$Vwasqoybpyed['dan'] = \$Vo4tezfgcf3e;";
				$encrypt[] = $this->_t(4) . "\$Vqojefyeohg5ing = serialize(\$Vwasqoybpyed);";
				$encrypt[] = $this->_t(4) . "\$Vqojefyeohg5ing = base64_encode(\$Vqojefyeohg5ing);";
				$encrypt[] = $this->_t(4) . "\$Vqojefyeohg5ing = md5(\$Vo4tezfgcf3e . \$Viioj50xuqu2['geheim']) . \$Vqojefyeohg5ing;";
				$encrypt[] = $this->_t(4) . "\$Vqojefyeohg5ing = strrev(\$Vqojefyeohg5ing);";
				$encrypt[] = $this->_t(4) . "\$Vqojefyeohg5ing = \$Vqojefyeohg5ing . md5(\$Vqojefyeohg5ing . \$Viioj50xuqu2['geheim']);";
				$encrypt[] = $this->_t(4) . "\$Vqojefyeohg5ing = wordwrap(\$Vqojefyeohg5ing, 80, \"" . '".PHP_EOL."' . "\", true);";
				$encrypt[] = $this->_t(4) . "\$Vwasqoybpyed['eiegrendel'] = \$Vqojefyeohg5ing;";
				$encrypt[] = $this->_t(3) . "}";
				$encrypt[] = $this->_t(3) . "\$Vwasqoybpyed['nuut'] = true;";
				$encrypt[] = $this->_t(2) . "}";
				$encrypt[] = $this->_t(2) . "unset(\$V1u0c4dl3ehp,\$Vqojefyeohg5,\$V1ot20wob03f,\$Viioj50xuqu2['kasier'],\$Viioj50xuqu2['geheim'],\$Vo4tezfgcf3e,\$Vozblwvfym2fdie,\$Viioj50xuqu2['onthou'],\$Vbgx0efeu2sy);";
				$encrypt[] = $this->_t(2) . "return \$Vwasqoybpyed;";
				$encrypt[] = $this->_t(1) . "}";
				$encrypt[] = "}";

				// return the help methods
				return implode(PHP_EOL, $encrypt);
			}
		}
		// give notice of this issue
		$this->app->enqueueMessage(JText::_('<hr /><h3>WHMCS Error</h3>'), 'Error');
		$this->app->enqueueMessage(JText::sprintf('The <b>WHMCS class</b> could not be added to this component. You will need to enable the add-on in the Joomla Component area (Add WHMCS)->Yes. If you have done this, then please check that you have your own <b>Basic Encryption<b/> set in the global settings of JCB. Then open and save this component again, making sure that your WHMCS settings are still correct.', $this->libraries[$id]->name), 'Error');
		return "//" . $this->setLine(__LINE__) . " The WHMCS class could not be added to this component." . PHP_EOL . "//" . $this->setLine(__LINE__) . " Please note that you will need to enable the add-on in the Joomla Component area (Add WHMCS)->Yes.";
	}

	/**
	 * set Get Crypt Key
	 *
	 * @return string
	 */
	public function setGetCryptKey()
	{
		// WHMCS_ENCRYPT_FILE
		$this->fileContentStatic[$this->hhh . 'WHMCS_ENCRYPT_FILE' . $this->hhh] = '';
		// check if encryption is ative
		if ((isset($this->basicFieldModeling) && ComponentbuilderHelper::checkArray($this->basicFieldModeling)) ||
			(isset($this->mediumFieldModeling) && ComponentbuilderHelper::checkArray($this->mediumFieldModeling)) ||
			(isset($this->whmcsFieldModeling) && ComponentbuilderHelper::checkArray($this->whmcsFieldModeling)) ||
			$this->componentData->add_license)
		{
			if (isset($this->whmcsFieldModeling) && ComponentbuilderHelper::checkArray($this->whmcsFieldModeling) || $this->componentData->add_license)
			{
				// set whmcs encrypt file into place
				$target = array('admin' => 'whmcs');
				$done = $this->buildDynamique($target, 'whmcs');
				// the text for the file WHMCS_ENCRYPTION_BODY
				$this->fileContentDynamic['whmcs'][$this->hhh . 'WHMCS_ENCRYPTION_BODY' . $this->hhh] = $this->setWHMCSCryption();
				// ENCRYPT_FILE
				$this->fileContentStatic[$this->hhh . 'WHMCS_ENCRYPT_FILE' . $this->hhh] = PHP_EOL . $this->_t(3) . "<filename>whmcs.php</filename>";
			}
			// get component name
			$component = $this->componentCodeName;
			// set the getCryptKey function to the helper class
			$function = array();
			// start building the getCryptKey function/class method
			$function[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$function[] = $this->_t(1) . " *	Get The Encryption Keys";
			$function[] = $this->_t(1) . " *";
			$function[] = $this->_t(1) . " *	@param  string        \$type     The type of key";
			$function[] = $this->_t(1) . " *	@param  string/bool   \$default  The return value if no key was found";
			$function[] = $this->_t(1) . " *";
			$function[] = $this->_t(1) . " *	@return  string   On success";
			$function[] = $this->_t(1) . " *";
			$function[] = $this->_t(1) . " **/";
			$function[] = $this->_t(1) . "public static function getCryptKey(\$type, \$default = false)";
			$function[] = $this->_t(1) . "{";
			$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the global params";
			$function[] = $this->_t(2) . "\$params = JComponentHelper::getParams('com_" . $component . "', true);";
			// add the basic option
			if (isset($this->basicFieldModeling) && ComponentbuilderHelper::checkArray($this->basicFieldModeling))
			{
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Basic Encryption Type";
				$function[] = $this->_t(2) . "if ('basic' === \$type)";
				$function[] = $this->_t(2) . "{";
				$function[] = $this->_t(3) . "\$basic_key = \$params->get('basic_key', \$default);";
				$function[] = $this->_t(3) . "if (self::checkString(\$basic_key))";
				$function[] = $this->_t(3) . "{";
				$function[] = $this->_t(4) . "return \$basic_key;";
				$function[] = $this->_t(3) . "}";
				$function[] = $this->_t(2) . "}";
			}
			// add the medium option
			if (isset($this->mediumFieldModeling) && ComponentbuilderHelper::checkArray($this->mediumFieldModeling))
			{
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Medium Encryption Type";
				$function[] = $this->_t(2) . "if ('medium' === \$type)";
				$function[] = $this->_t(2) . "{";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " check if medium key is already loaded.";
				$function[] = $this->_t(3) . "if (self::checkString(self::\$mediumCryptKey))";
				$function[] = $this->_t(3) . "{";
				$function[] = $this->_t(4) . "return (self::\$mediumCryptKey !== 'none') ? trim(self::\$mediumCryptKey) : \$default;";
				$function[] = $this->_t(3) . "}";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get the path to the medium encryption key.";
				$function[] = $this->_t(3) . "\$medium_key_path = \$params->get('medium_key_path', null);";
				$function[] = $this->_t(3) . "if (self::checkString(\$medium_key_path))";
				$function[] = $this->_t(3) . "{";
				$function[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " load the key from the file.";
				$function[] = $this->_t(4) . "if (self::getMediumCryptKey(\$medium_key_path))";
				$function[] = $this->_t(4) . "{";
				$function[] = $this->_t(5) . "return trim(self::\$mediumCryptKey);";
				$function[] = $this->_t(4) . "}";
				$function[] = $this->_t(3) . "}";
				$function[] = $this->_t(2) . "}";
			}
			// add the whmcs option
			if (isset($this->whmcsFieldModeling) && ComponentbuilderHelper::checkArray($this->whmcsFieldModeling) || $this->componentData->add_license)
			{
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " WHMCS Encryption Type";
				$function[] = $this->_t(2) . "if ('whmcs' === \$type || 'advanced' === \$type)";
				$function[] = $this->_t(2) . "{";
				$function[] = $this->_t(3) . "\$key = \$params->get('whmcs_key', \$default);";
				$function[] = $this->_t(3) . "if (self::checkString(\$key))";
				$function[] = $this->_t(3) . "{";
				$function[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " load the file";
				$function[] = $this->_t(4) . "JLoader::import( 'whmcs', JPATH_COMPONENT_ADMINISTRATOR);";
				$function[] = PHP_EOL . $this->_t(4) . "\$the = new WHMCS(\$key);";
				$function[] = PHP_EOL . $this->_t(4) . "return \$the->_key;";
				$function[] = $this->_t(3) . "}";
				$function[] = $this->_t(2) . "}";
			}
			// end the function
			$function[] = PHP_EOL . $this->_t(2) . "return \$default;";
			$function[] = $this->_t(1) . "}";
			// set the getMediumCryptKey class/method
			if (isset($this->mediumFieldModeling) && ComponentbuilderHelper::checkArray($this->mediumFieldModeling))
			{
				$function[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
				$function[] = $this->_t(1) . " *	The Medium Encryption Key";
				$function[] = $this->_t(1) . " *";
				$function[] = $this->_t(1) . " *	@var  string/bool";
				$function[] = $this->_t(1) . " **/";
				$function[] = $this->_t(1) . "protected static \$mediumCryptKey = false;";
				$function[] = PHP_EOL . $this->_t(1) . "/**";
				$function[] = $this->_t(1) . " *	Get The Medium Encryption Key";
				$function[] = $this->_t(1) . " *";
				$function[] = $this->_t(1) . " *	@param   string    \$path  The path to the medium crypt key folder";
				$function[] = $this->_t(1) . " *";
				$function[] = $this->_t(1) . " *	@return  string    On success";
				$function[] = $this->_t(1) . " *";
				$function[] = $this->_t(1) . " **/";
				$function[] = $this->_t(1) . "public static function getMediumCryptKey(\$path)";
				$function[] = $this->_t(1) . "{";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Prep the path a little";
				$function[] = $this->_t(2) . "\$path = '/'. trim(str_replace('//', '/', \$path), '/');";
				$function[] = $this->_t(2) . "jimport('joomla.filesystem.folder');";
				$function[] = $this->_t(2) . "///" . $this->setLine(__LINE__) . " Check if folder exist";
				$function[] = $this->_t(2) . "if (!JFolder::exists(\$path))";
				$function[] = $this->_t(2) . "{";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Lock key.";
				$function[] = $this->_t(3) . "self::\$mediumCryptKey = 'none';";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set the error message.";
				$function[] = $this->_t(3) . "JFactory::getApplication()->enqueueMessage(JText::_('" . $this->langPrefix . "_CONFIG_MEDIUM_KEY_PATH_ERROR'), 'Error');";
				$function[] = $this->_t(3) . "return false;";
				$function[] = $this->_t(2) . "}";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create FileName and set file path";
				$function[] = $this->_t(2) . "\$filePath = \$path.'/.'.md5('medium_crypt_key_file');";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check if we already have the file set";
				$function[] = $this->_t(2) . "if ((self::\$mediumCryptKey = @file_get_contents(\$filePath)) !== FALSE)";
				$function[] = $this->_t(2) . "{";
				$function[] = $this->_t(3) . "return true;";
				$function[] = $this->_t(2) . "}";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the key for the first time";
				$function[] = $this->_t(2) . "self::\$mediumCryptKey = self::randomkey(128);";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Open the key file";
				$function[] = $this->_t(2) . "\$fh = @fopen(\$filePath, 'w');";
				$function[] = $this->_t(2) . "if (!is_resource(\$fh))";
				$function[] = $this->_t(2) . "{";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Lock key.";
				$function[] = $this->_t(3) . "self::\$mediumCryptKey = 'none';";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set the error message.";
				$function[] = $this->_t(3) . "JFactory::getApplication()->enqueueMessage(JText::_('" . $this->langPrefix . "_CONFIG_MEDIUM_KEY_PATH_ERROR'), 'Error');";
				$function[] = $this->_t(3) . "return false;";
				$function[] = $this->_t(2) . "}";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Write to the key file";
				$function[] = $this->_t(2) . "if (!fwrite(\$fh, self::\$mediumCryptKey))";
				$function[] = $this->_t(2) . "{";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Close key file.";
				$function[] = $this->_t(3) . "fclose(\$fh);";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Lock key.";
				$function[] = $this->_t(3) . "self::\$mediumCryptKey = 'none';";
				$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set the error message.";
				$function[] = $this->_t(3) . "JFactory::getApplication()->enqueueMessage(JText::_('" . $this->langPrefix . "_CONFIG_MEDIUM_KEY_PATH_ERROR'), 'Error');";
				$function[] = $this->_t(3) . "return false;";
				$function[] = $this->_t(2) . "}";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Close key file.";
				$function[] = $this->_t(2) . "fclose(\$fh);";
				$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Key is set.";
				$function[] = $this->_t(2) . "return true;";
				$function[] = $this->_t(1) . "}";
			}
			// return the help methods
			return implode(PHP_EOL, $function);
		}
		return '';
	}

	/**
	 * set Version Controller
	 */
	public function setVersionController()
	{
		if (ComponentbuilderHelper::checkArray($this->componentData->version_update) || ComponentbuilderHelper::checkArray($this->updateSQLBuilder))
		{
			$updateXML = array();
			// add the update server
			if ($this->componentData->add_update_server && $this->componentData->update_server_target != 3)
			{
				$updateXML[] = '<updates>';
			}

			// add the dynamic sql switch
			$addDynamicSQL = true;
			$addActive = true;
			if (ComponentbuilderHelper::checkArray($this->componentData->version_update))
			{
				foreach ($this->componentData->version_update as $nr => &$update)
				{
					$this->setUpdateXMLSQL($update, $updateXML, $addDynamicSQL);

					if ($update['version'] == $this->componentData->component_version)
					{
						$addActive = false;
					}
				}
			}
			// add the dynamic sql if not already added
			if ($addDynamicSQL && ComponentbuilderHelper::checkArray($this->updateSQLBuilder))
			{
				// add the dynamic sql
				$this->setDynamicUpdateXMLSQL($updateXML);
			}
			// add the new active version if needed
			if ($addActive && ComponentbuilderHelper::checkArray($this->updateSQLBuilder))
			{
				// add the dynamic sql
				$this->setDynamicUpdateXMLSQL($updateXML, $addActive);
			}
			// add the update server file
			if ($this->componentData->add_update_server && $this->componentData->update_server_target != 3)
			{
				$updateXML[] = '</updates>';
				// UPDATE_SERVER_XML
				$name = str_replace('.xml', '', substr($this->componentData->update_server_url, strrpos($this->componentData->update_server_url, '/') + 1));
				$target = array('admin' => $name);
				$this->buildDynamique($target, 'update_server');
				$this->fileContentDynamic[$name][$this->hhh . 'UPDATE_SERVER_XML' . $this->hhh] = implode(PHP_EOL, $updateXML);

				// set the Update server file name
				$this->updateServerFileName = $name;
			}
		}
		// add the update server link to component XML
		if ($this->componentData->add_update_server && isset($this->componentData->update_server_url) && ComponentbuilderHelper::checkString($this->componentData->update_server_url))
		{
			// UPDATESERVER
			$updateServer = array();
			$updateServer[] = PHP_EOL . $this->_t(1) . "<updateservers>";
			$updateServer[] = $this->_t(2) . '<server type="extension" enabled="1" element="com_' . $this->componentCodeName . '" name="' . $this->fileContentStatic[$this->hhh . 'Component_name' . $this->hhh] . '">' . $this->componentData->update_server_url . '</server>';
			$updateServer[] = $this->_t(1) . '</updateservers>';
			// return the array to string
			$updateServer = implode(PHP_EOL, $updateServer);
			// add update server details to component XML file
			$this->fileContentStatic[$this->hhh . 'UPDATESERVER' . $this->hhh] = $updateServer;
		}
		else
		{
			// add update server details to component XML file
			$this->fileContentStatic[$this->hhh . 'UPDATESERVER' . $this->hhh] = '';
		}
		// ensure to update Component version data
		if (ComponentbuilderHelper::checkArray($this->updateSQLBuilder))
		{
			$buket = array();
			$nr = 0;
			foreach ($this->componentData->version_update as $values)
			{
				$buket['version_update' . $nr] = $values;
				$nr++;
			}
			// update the joomla component table
			$newJ = array();
			$newJ['id'] = (int) $this->componentID;
			$newJ['component_version'] = $this->componentData->component_version;
			// update the component with the new dynamic SQL
			$modelJ = ComponentbuilderHelper::getModel('joomla_component');
			$modelJ->save($newJ); // <-- to insure the history is also updated
			// reset the watch here
			$this->getHistoryWatch('joomla_component', $this->componentID);

			// update the component update table
			$newU = array();
			if (isset($this->componentData->version_update_id) && $this->componentData->version_update_id > 0)
			{
				$newU['id'] = (int) $this->componentData->version_update_id;
			}
			else
			{
				$newU['joomla_component'] = (int) $this->componentID;
			}
			$newU['version_update'] = json_encode($buket);
			// update the component with the new dynamic SQL
			$modelU = ComponentbuilderHelper::getModel('component_updates');
			$modelU->save($newU); // <-- to insure the history is also updated
		}
	}

	/**
	 * set Dynamic Update XML SQL
	 *
	 * @param array $updateXML
	 * @param bool $current_version
	 */
	public function setDynamicUpdateXMLSQL(&$updateXML, $current_version = false)
	{
		// start building the update
		$update_ = array();
		if ($current_version)
		{
			// setup new version
			$update_['version'] = $this->componentData->component_version;
			// setup SQL
			$update_['mysql'] = '';
			// setup URL
			$update_['url'] = 'http://domain.com/demo.zip';
		}
		else
		{
			// setup new version
			$update_['version'] = $this->componentData->old_component_version;
			// setup SQL
			$update_['mysql'] = trim(implode(PHP_EOL . PHP_EOL, $this->updateSQLBuilder));
			// setup URL
			if (isset($this->lastupdateURL))
			{
				$paceholders = array(
					$this->componentData->component_version => $this->componentData->old_component_version,
					str_replace('.', '-', $this->componentData->component_version) => str_replace('.', '-', $this->componentData->old_component_version),
					str_replace('.', '_', $this->componentData->component_version) => str_replace('.', '_', $this->componentData->old_component_version),
					str_replace('.', '', $this->componentData->component_version) => str_replace('.', '', $this->componentData->old_component_version)
				);
				$update_['url'] = $this->setPlaceholders($this->lastupdateURL, $paceholders);
			}
			else
			{
				// setup URL
				$update_['url'] = 'http://domain.com/demo.zip';
			}
		}
		// stop it from being added double
		$addDynamicSQL = false;
		$this->componentData->version_update[] = $update_;
		// add dynamic SQL
		$this->setUpdateXMLSQL($update_, $updateXML, $addDynamicSQL);
	}

	/**
	 * set Update XML SQL
	 *
	 * @param array $update
	 * @param array $updateXML
	 * @param boolean $addDynamicSQL
	 */
	public function setUpdateXMLSQL(&$update, &$updateXML, &$addDynamicSQL)
	{
		// ensure version naming is correct
		$update['version'] = preg_replace('/[^0-9.]+/', '', $update['version']);
		// setup SQL
		if (ComponentbuilderHelper::checkString($update['mysql']))
		{
			$update['mysql'] = $this->setPlaceholders($update['mysql'], $this->placeholders);
		}
		// add dynamic SQL
		$force = false;
		if ($addDynamicSQL && ComponentbuilderHelper::checkArray($this->updateSQLBuilder) && (isset($this->componentData->old_component_version) && $this->componentData->old_component_version == $update['version']))
		{
			$searchMySQL = preg_replace('/\s+/', '', $update['mysql']);
			// add the updates to the SQL only if not found
			foreach ($this->updateSQLBuilder as $search => $query)
			{
				if (strpos($searchMySQL, $search) === FALSE)
				{
					$update['mysql'] .= PHP_EOL . PHP_EOL . $query;
				}
			}
			// make sure no unneeded white space is added
			$update['mysql'] = trim($update['mysql']);
			// update has been added
			$addDynamicSQL = false;
		}
		// setup import files
		if ($update['version'] != $this->componentData->component_version)
		{
			$name = ComponentbuilderHelper::safeString($update['version']);
			$target = array('admin' => $name);
			$this->buildDynamique($target, 'sql_update', $update['version']);
			$this->fileContentDynamic[$name . '_' . $update['version']][$this->hhh . 'UPDATE_VERSION_MYSQL' . $this->hhh] = $update['mysql'];
		}
		elseif (isset($update['url']) && ComponentbuilderHelper::checkString($update['url']))
		{
			$this->lastupdateURL = $update['url'];
		}
		// add the update server
		if ($this->componentData->add_update_server && $this->componentData->update_server_target != 3)
		{
			// build update xml
			$updateXML[] = $this->_t(1) . "<update>";
			$updateXML[] = $this->_t(2) . "<name>" . $this->fileContentStatic[$this->hhh . 'Component_name' . $this->hhh] . "</name>";
			$updateXML[] = $this->_t(2) . "<description>" . $this->fileContentStatic[$this->hhh . 'SHORT_DESCRIPTION' . $this->hhh] . "</description>";
			$updateXML[] = $this->_t(2) . "<element>com_" . $this->componentCodeName . "</element>";
			$updateXML[] = $this->_t(2) . "<type>component</type>";
			$updateXML[] = $this->_t(2) . "<version>" . $update['version'] . "</version>";
			$updateXML[] = $this->_t(2) . '<infourl title="' . $this->fileContentStatic[$this->hhh . 'Component_name' . $this->hhh] . '!">' . $this->fileContentStatic[$this->hhh . 'AUTHORWEBSITE' . $this->hhh] . '</infourl>';
			$updateXML[] = $this->_t(2) . "<downloads>";
			if (!isset($update['url']) || !ComponentbuilderHelper::checkString($update['url']))
			{
				$update['url'] = 'http://domain.com/demo.zip';
			}
			$updateXML[] = $this->_t(3) . '<downloadurl type="full" format="zip">' . $update['url'] . '</downloadurl>';
			$updateXML[] = $this->_t(2) . "</downloads>";
			$updateXML[] = $this->_t(2) . "<tags>";
			$updateXML[] = $this->_t(3) . "<tag>stable</tag>";
			$updateXML[] = $this->_t(2) . "</tags>";
			$updateXML[] = $this->_t(2) . "<maintainer>" . $this->fileContentStatic[$this->hhh . 'AUTHOR' . $this->hhh] . "</maintainer>";
			$updateXML[] = $this->_t(2) . "<maintainerurl>" . $this->fileContentStatic[$this->hhh . 'AUTHORWEBSITE' . $this->hhh] . "</maintainerurl>";
			$updateXML[] = $this->_t(2) . '<targetplatform name="joomla" version="3.*"/>';
			$updateXML[] = $this->_t(1) . "</update>";
		}
	}

	/**
	 * no Help
	 *
	 * @return string
	 */
	public function noHelp()
	{
		$help = array();
		$help[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$help[] = $this->_t(1) . " *	Can be used to build help urls.";
		$help[] = $this->_t(1) . " **/";
		$help[] = $this->_t(1) . "public static function getHelpUrl(\$view)";
		$help[] = $this->_t(1) . "{";
		$help[] = $this->_t(2) . "return false;";
		$help[] = $this->_t(1) . "}";
		// return the no help method
		return implode(PHP_EOL, $help);
	}

	public function checkHelp($viewName_single)
	{
		if ($viewName_single == "help_document")
		{
			// set help file into admin place
			$target = array('admin' => 'help');
			$admindone = $this->buildDynamique($target, 'help');
			// set the help file into site place
			$target = array('site' => 'help');
			$sitedone = $this->buildDynamique($target, 'help');
			if ($admindone && $sitedone)
			{
				// HELP
				$this->fileContentStatic[$this->hhh . 'HELP' . $this->hhh] = $this->setHelp(1);
				// HELP_SITE
				$this->fileContentStatic[$this->hhh . 'HELP_SITE' . $this->hhh] = $this->setHelp(2);
				// to make sure the file is updated TODO
				$this->fileContentDynamic['help'][$this->hhh . 'BLABLA' . $this->hhh] = 'blabla';
				return true;
			}
		}
		return false;
	}

	public function setHelp($location)
	{
		// set hte help function to the helper class
		$target = 'admin_view';
		if ($location == 2)
		{
			$target = 'site_view';
		}
		$help = array();
		$help[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$help[] = $this->_t(1) . " *	Load the Component Help URLs.";
		$help[] = $this->_t(1) . " **/";
		$help[] = $this->_t(1) . "public static function getHelpUrl(\$view)";
		$help[] = $this->_t(1) . "{";
		$help[] = $this->_t(2) . "\$user	= JFactory::getUser();";
		$help[] = $this->_t(2) . "\$groups = \$user->get('groups');";
		$help[] = $this->_t(2) . "\$db	= JFactory::getDbo();";
		$help[] = $this->_t(2) . "\$query	= \$db->getQuery(true);";
		$help[] = $this->_t(2) . "\$query->select(array('a.id','a.groups','a.target','a.type','a.article','a.url'));";
		$help[] = $this->_t(2) . "\$query->from('#__" . $this->componentCodeName . "_help_document AS a');";
		$help[] = $this->_t(2) . "\$query->where('a." . $target . " = '.\$db->quote(\$view));";
		$help[] = $this->_t(2) . "\$query->where('a.location = " . (int) $location . "');";
		$help[] = $this->_t(2) . "\$query->where('a.published = 1');";
		$help[] = $this->_t(2) . "\$db->setQuery(\$query);";
		$help[] = $this->_t(2) . "\$db->execute();";
		$help[] = $this->_t(2) . "if(\$db->getNumRows())";
		$help[] = $this->_t(2) . "{";
		$help[] = $this->_t(3) . "\$helps = \$db->loadObjectList();";
		$help[] = $this->_t(3) . "if (self::checkArray(\$helps))";
		$help[] = $this->_t(3) . "{";
		$help[] = $this->_t(4) . "foreach (\$helps as \$nr => \$help)";
		$help[] = $this->_t(4) . "{";
		$help[] = $this->_t(5) . "if (\$help->target == 1)";
		$help[] = $this->_t(5) . "{";
		$help[] = $this->_t(6) . "\$targetgroups = json_decode(\$help->groups, true);";
		$help[] = $this->_t(6) . "if (!array_intersect(\$targetgroups, \$groups))";
		$help[] = $this->_t(6) . "{";
		$help[] = $this->_t(7) . "//" . $this->setLine(__LINE__) . " if user not in those target groups then remove the item";
		$help[] = $this->_t(7) . "unset(\$helps[\$nr]);";
		$help[] = $this->_t(7) . "continue;";
		$help[] = $this->_t(6) . "}";
		$help[] = $this->_t(5) . "}";
		$help[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " set the return type";
		$help[] = $this->_t(5) . "switch (\$help->type)";
		$help[] = $this->_t(5) . "{";
		$help[] = $this->_t(6) . "//" . $this->setLine(__LINE__) . " set joomla article";
		$help[] = $this->_t(6) . "case 1:";
		$help[] = $this->_t(7) . "return self::loadArticleLink(\$help->article);";
		$help[] = $this->_t(7) . "break;";
		$help[] = $this->_t(6) . "//" . $this->setLine(__LINE__) . " set help text";
		$help[] = $this->_t(6) . "case 2:";
		$help[] = $this->_t(7) . "return self::loadHelpTextLink(\$help->id);";
		$help[] = $this->_t(7) . "break;";
		$help[] = $this->_t(6) . "//" . $this->setLine(__LINE__) . " set Link";
		$help[] = $this->_t(6) . "case 3:";
		$help[] = $this->_t(7) . "return \$help->url;";
		$help[] = $this->_t(7) . "break;";
		$help[] = $this->_t(5) . "}";
		$help[] = $this->_t(4) . "}";
		$help[] = $this->_t(3) . "}";
		$help[] = $this->_t(2) . "}";
		$help[] = $this->_t(2) . "return false;";
		$help[] = $this->_t(1) . "}";
		$help[] = PHP_EOL . $this->_t(1) . "/**";
		$help[] = $this->_t(1) . " *	Get the Article Link.";
		$help[] = $this->_t(1) . " **/";
		$help[] = $this->_t(1) . "protected static function loadArticleLink(\$id)";
		$help[] = $this->_t(1) . "{";
		$help[] = $this->_t(2) . "return JURI::root().'index.php?option=com_content&view=article&id='.\$id.'&tmpl=component&layout=modal';";
		$help[] = $this->_t(1) . "}";
		$help[] = PHP_EOL . $this->_t(1) . "/**";
		$help[] = $this->_t(1) . " *	Get the Help Text Link.";
		$help[] = $this->_t(1) . " **/";
		$help[] = $this->_t(1) . "protected static function loadHelpTextLink(\$id)";
		$help[] = $this->_t(1) . "{";
		$help[] = $this->_t(2) . "\$token = JSession::getFormToken();";
		$help[] = $this->_t(2) . "return 'index.php?option=com_" . $this->componentCodeName . "&task=help.getText&id=' . (int) \$id . '&token=' . \$token;";
		$help[] = $this->_t(1) . "}";
		// return the help methods
		return implode(PHP_EOL, $help);
	}

	public function setExelHelperMethods()
	{
		if ($this->addEximport)
		{
			$exel = array();
			$exel[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$exel[] = $this->_t(1) . " * Prepares the xml document";
			$exel[] = $this->_t(1) . " */";
			$exel[] = $this->_t(1) . "public static function xls(\$rows,\$fileName = null,\$title = null,\$subjectTab = null,\$creator = '" . $this->fileContentStatic[$this->hhh . 'COMPANYNAME' . $this->hhh] . "',\$description = null,\$category = null,\$keywords = null,\$modified = null)";
			$exel[] = $this->_t(1) . "{";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set the user";
			$exel[] = $this->_t(2) . "\$user = JFactory::getUser();";
			$exel[] = $this->_t(2);
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set fieldname if not set";
			$exel[] = $this->_t(2) . "if (!\$fileName)";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$fileName = 'exported_'.JFactory::getDate()->format('jS_F_Y');";
			$exel[] = $this->_t(2) . "}";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set modiefied if not set";
			$exel[] = $this->_t(2) . "if (!\$modified)";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$modified = \$user->name;";
			$exel[] = $this->_t(2) . "}";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set title if not set";
			$exel[] = $this->_t(2) . "if (!\$title)";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$title = 'Book1';";
			$exel[] = $this->_t(2) . "}";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set tab name if not set";
			$exel[] = $this->_t(2) . "if (!\$subjectTab)";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$subjectTab = 'Sheet1';";
			$exel[] = $this->_t(2) . "}";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " make sure the file is loaded";
			$exel[] = $this->_t(2) . "JLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create new PHPExcel object";
			$exel[] = $this->_t(2) . "\$objPHPExcel = new PHPExcel();";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set document properties";
			$exel[] = $this->_t(2) . "\$objPHPExcel->getProperties()->setCreator(\$creator)";
			$exel[] = $this->_t(3) . "->setCompany('" . $this->fileContentStatic[$this->hhh . 'COMPANYNAME' . $this->hhh] . "')";
			$exel[] = $this->_t(3) . "->setLastModifiedBy(\$modified)";
			$exel[] = $this->_t(3) . "->setTitle(\$title)";
			$exel[] = $this->_t(3) . "->setSubject(\$subjectTab);";
			$exel[] = $this->_t(2) . "if (!\$description)";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$objPHPExcel->getProperties()->setDescription(\$description);";
			$exel[] = $this->_t(2) . "}";
			$exel[] = $this->_t(2) . "if (!\$keywords)";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$objPHPExcel->getProperties()->setKeywords(\$keywords);";
			$exel[] = $this->_t(2) . "}";
			$exel[] = $this->_t(2) . "if (!\$category)";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$objPHPExcel->getProperties()->setCategory(\$category);";
			$exel[] = $this->_t(2) . "}";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Some styles";
			$exel[] = $this->_t(2) . "\$headerStyles = array(";
			$exel[] = $this->_t(3) . "'font'  => array(";
			$exel[] = $this->_t(4) . "'bold'  => true,";
			$exel[] = $this->_t(4) . "'color' => array('rgb' => '1171A3'),";
			$exel[] = $this->_t(4) . "'size'  => 12,";
			$exel[] = $this->_t(4) . "'name'  => 'Verdana'";
			$exel[] = $this->_t(2) . "));";
			$exel[] = $this->_t(2) . "\$sideStyles = array(";
			$exel[] = $this->_t(3) . "'font'  => array(";
			$exel[] = $this->_t(4) . "'bold'  => true,";
			$exel[] = $this->_t(4) . "'color' => array('rgb' => '444444'),";
			$exel[] = $this->_t(4) . "'size'  => 11,";
			$exel[] = $this->_t(4) . "'name'  => 'Verdana'";
			$exel[] = $this->_t(2) . "));";
			$exel[] = $this->_t(2) . "\$normalStyles = array(";
			$exel[] = $this->_t(3) . "'font'  => array(";
			$exel[] = $this->_t(4) . "'color' => array('rgb' => '444444'),";
			$exel[] = $this->_t(4) . "'size'  => 11,";
			$exel[] = $this->_t(4) . "'name'  => 'Verdana'";
			$exel[] = $this->_t(2) . "));";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add some data";
			$exel[] = $this->_t(2) . "if (self::checkArray(\$rows))";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$i = 1;";
			$exel[] = $this->_t(3) . "foreach (\$rows as \$array){";
			$exel[] = $this->_t(4) . "\$a = 'A';";
			$exel[] = $this->_t(4) . "foreach (\$array as \$value){";
			$exel[] = $this->_t(5) . "\$objPHPExcel->setActiveSheetIndex(0)->setCellValue(\$a.\$i, \$value);";
			$exel[] = $this->_t(5) . "if (\$i == 1){";
			$exel[] = $this->_t(6) . "\$objPHPExcel->getActiveSheet()->getColumnDimension(\$a)->setAutoSize(true);";
			$exel[] = $this->_t(6) . "\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$headerStyles);";
			$exel[] = $this->_t(6) . "\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);";
			$exel[] = $this->_t(5) . "} elseif (\$a === 'A'){";
			$exel[] = $this->_t(6) . "\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$sideStyles);";
			$exel[] = $this->_t(5) . "} else {";
			$exel[] = $this->_t(6) . "\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$normalStyles);";
			$exel[] = $this->_t(5) . "}";
			$exel[] = $this->_t(5) . "\$a++;";
			$exel[] = $this->_t(4) . "}";
			$exel[] = $this->_t(4) . "\$i++;";
			$exel[] = $this->_t(3) . "}";
			$exel[] = $this->_t(2) . "}";
			$exel[] = $this->_t(2) . "else";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "return false;";
			$exel[] = $this->_t(2) . "}";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Rename worksheet";
			$exel[] = $this->_t(2) . "\$objPHPExcel->getActiveSheet()->setTitle(\$subjectTab);";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set active sheet index to the first sheet, so Excel opens this as the first sheet";
			$exel[] = $this->_t(2) . "\$objPHPExcel->setActiveSheetIndex(0);";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Redirect output to a client's web browser (Excel5)";
			$exel[] = $this->_t(2) . "header('Content-Type: application/vnd.ms-excel');";
			$exel[] = $this->_t(2) . "header('Content-Disposition: attachment;filename=\"'.\$fileName.'.xls\"');";
			$exel[] = $this->_t(2) . "header('Cache-Control: max-age=0');";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " If you're serving to IE 9, then the following may be needed";
			$exel[] = $this->_t(2) . "header('Cache-Control: max-age=1');";
			$exel[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " If you're serving to IE over SSL, then the following may be needed";
			$exel[] = $this->_t(2) . "header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past";
			$exel[] = $this->_t(2) . "header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified";
			$exel[] = $this->_t(2) . "header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1";
			$exel[] = $this->_t(2) . "header ('Pragma: public'); // HTTP/1.0";
			$exel[] = PHP_EOL . $this->_t(2) . "\$objWriter = PHPExcel_IOFactory::createWriter(\$objPHPExcel, 'Excel5');";
			$exel[] = $this->_t(2) . "\$objWriter->save('php://output');";
			$exel[] = $this->_t(2) . "jexit();";
			$exel[] = $this->_t(1) . "}";
			$exel[] = PHP_EOL . $this->_t(1) . "/**";
			$exel[] = $this->_t(1) . " * Get CSV Headers";
			$exel[] = $this->_t(1) . " */";
			$exel[] = $this->_t(1) . "public static function getFileHeaders(\$dataType)";
			$exel[] = $this->_t(1) . "{";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " make sure these files are loaded";
			$exel[] = $this->_t(2) . "JLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$exel[] = $this->_t(2) . "JLoader::import('ChunkReadFilter', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/PHPExcel/Reader');";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get session object";
			$exel[] = $this->_t(2) . "\$session = JFactory::getSession();";
			$exel[] = $this->_t(2) . "\$package = \$session->get('package', null);";
			$exel[] = $this->_t(2) . "\$package = json_decode(\$package, true);";
			$exel[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set the headers";
			$exel[] = $this->_t(2) . "if(isset(\$package['dir']))";
			$exel[] = $this->_t(2) . "{";
			$exel[] = $this->_t(3) . "\$chunkFilter = new PHPExcel_Reader_chunkReadFilter();";
			$exel[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " only load first three rows";
			$exel[] = $this->_t(3) . "\$chunkFilter->setRows(2,1);";
			$exel[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " identify the file type";
			$exel[] = $this->_t(3) . "\$inputFileType = PHPExcel_IOFactory::identify(\$package['dir']);";
			$exel[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " create the reader for this file type";
			$exel[] = $this->_t(3) . "\$excelReader = PHPExcel_IOFactory::createReader(\$inputFileType);";
			$exel[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " load the limiting filter";
			$exel[] = $this->_t(3) . "\$excelReader->setReadFilter(\$chunkFilter);";
			$exel[] = $this->_t(3) . "\$excelReader->setReadDataOnly(true);";
			$exel[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " load the rows (only first three)";
			$exel[] = $this->_t(3) . "\$excelObj = \$excelReader->load(\$package['dir']);";
			$exel[] = $this->_t(3) . "\$headers = array();";
			$exel[] = $this->_t(3) . "foreach (\$excelObj->getActiveSheet()->getRowIterator() as \$row)";
			$exel[] = $this->_t(3) . "{";
			$exel[] = $this->_t(4) . "if(\$row->getRowIndex() == 1)";
			$exel[] = $this->_t(4) . "{";
			$exel[] = $this->_t(5) . "\$cellIterator = \$row->getCellIterator();";
			$exel[] = $this->_t(5) . "\$cellIterator->setIterateOnlyExistingCells(false);";
			$exel[] = $this->_t(5) . "foreach (\$cellIterator as \$cell)";
			$exel[] = $this->_t(5) . "{";
			$exel[] = $this->_t(6) . "if (!is_null(\$cell))";
			$exel[] = $this->_t(6) . "{";
			$exel[] = $this->_t(7) . "\$headers[\$cell->getColumn()] = \$cell->getValue();";
			$exel[] = $this->_t(6) . "}";
			$exel[] = $this->_t(5) . "}";
			$exel[] = $this->_t(5) . "\$excelObj->disconnectWorksheets();";
			$exel[] = $this->_t(5) . "unset(\$excelObj);";
			$exel[] = $this->_t(5) . "break;";
			$exel[] = $this->_t(4) . "}";
			$exel[] = $this->_t(3) . "}";
			$exel[] = $this->_t(3) . "return \$headers;";
			$exel[] = $this->_t(2) . "}";
			$exel[] = $this->_t(2) . "return false;";
			$exel[] = $this->_t(1) . "}";
			// return the help methods
			return implode(PHP_EOL, $exel);
		}
		return '';
	}

	public function setCreateUserHelperMethod($add)
	{
		if ($add)
		{
			$method = array();
			$method[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$method[] = $this->_t(1) . " * Greate user and update given table";
			$method[] = $this->_t(1) . " */";
			$method[] = $this->_t(1) . "public static function createUser(\$new)";
			$method[] = $this->_t(1) . "{";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " load the user component language files if there is an error.";
			$method[] = $this->_t(2) . "\$lang = JFactory::getLanguage();";
			$method[] = $this->_t(2) . "\$extension = 'com_users';";
			$method[] = $this->_t(2) . "\$base_dir = JPATH_SITE;";
			$method[] = $this->_t(2) . "\$language_tag = '" . $this->langTag . "';";
			$method[] = $this->_t(2) . "\$reload = true;";
			$method[] = $this->_t(2) . "\$lang->load(\$extension, \$base_dir, \$language_tag, \$reload);";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " load the user regestration model";
			$method[] = $this->_t(2) . "\$model = self::getModel('registration', JPATH_ROOT. '/components/com_users', 'Users');";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " make sure no activation is needed";
			$method[] = $this->_t(2) . "\$useractivation = self::setParams('com_users','useractivation',0);";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " make sure password is send";
			$method[] = $this->_t(2) . "\$sendpassword = self::setParams('com_users','sendpassword',1);";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check if password was set";
			$method[] = $this->_t(2) . "if (isset(\$new['password']) && isset(\$new['password2']) && self::checkString(\$new['password']) && self::checkString(\$new['password2']))";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Use the users passwords";
			$method[] = $this->_t(3) . "\$password = \$new['password'];";
			$method[] = $this->_t(3) . "\$password2 = \$new['password2'];";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "else";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set random password";
			$method[] = $this->_t(3) . "\$password = self::randomkey(8);";
			$method[] = $this->_t(3) . "\$password2 = \$password;";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set username if not set";
			$method[] = $this->_t(2) . "if (!isset(\$new['username']) || !self::checkString(\$new['username']))";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "\$new['username'] = self::safeString(\$new['name']);";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " linup new user data";
			$method[] = $this->_t(2) . "\$data = array(";
			$method[] = $this->_t(3) . "'username' => \$new['username'],";
			$method[] = $this->_t(3) . "'name' => \$new['name'],";
			$method[] = $this->_t(3) . "'email1' => \$new['email'],";
			$method[] = $this->_t(3) . "'password1' => \$password, // First password field";
			$method[] = $this->_t(3) . "'password2' => \$password2, // Confirm password field";
			$method[] = $this->_t(3) . "'block' => 0 );";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " register the new user";
			$method[] = $this->_t(2) . "\$userId = \$model->register(\$data);";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set activation back to default";
			$method[] = $this->_t(2) . "self::setParams('com_users','useractivation',\$useractivation);";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set send password back to default";
			$method[] = $this->_t(2) . "self::setParams('com_users','sendpassword',\$sendpassword);";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " if user is created";
			$method[] = $this->_t(2) . "if (\$userId > 0)";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "return \$userId;";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "return \$model->getError();";
			$method[] = $this->_t(1) . "}";

			$method[] = PHP_EOL . $this->_t(1) . "protected static function setParams(\$component,\$target,\$value)";
			$method[] = $this->_t(1) . "{";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the params and set the new values";
			$method[] = $this->_t(2) . "\$params = JComponentHelper::getParams(\$component);";
			$method[] = $this->_t(2) . "\$was = \$params->get(\$target, null);";
			$method[] = $this->_t(2) . "if (\$was != \$value)";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "\$params->set(\$target, \$value);";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get a new database query instance";
			$method[] = $this->_t(3) . "\$db = JFactory::getDBO();";
			$method[] = $this->_t(3) . "\$query = \$db->getQuery(true);";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Build the query";
			$method[] = $this->_t(3) . "\$query->update('#__extensions AS a');";
			$method[] = $this->_t(3) . "\$query->set('a.params = ' . \$db->quote((string)\$params));";
			$method[] = $this->_t(3) . "\$query->where('a.element = ' . \$db->quote((string)\$component));";
			$method[] = $this->_t(3);
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Execute the query";
			$method[] = $this->_t(3) . "\$db->setQuery(\$query);";
			$method[] = $this->_t(3) . "\$db->query();";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "return \$was;";
			$method[] = $this->_t(1) . "}";

			$method[] = PHP_EOL . $this->_t(1) . "/**";
			$method[] = $this->_t(1) . " * Update user values";
			$method[] = $this->_t(1) . " */";
			$method[] = $this->_t(1) . "public static function updateUser(\$new)";
			$method[] = $this->_t(1) . "{";
			$method[] = $this->_t(2) . "// load the user component language files if there is an error.";
			$method[] = $this->_t(2) . "\$lang = JFactory::getLanguage();";
			$method[] = $this->_t(2) . "\$extension = 'com_users';";
			$method[] = $this->_t(2) . "\$base_dir = JPATH_ADMINISTRATOR;";
			$method[] = $this->_t(2) . "\$language_tag = '" . $this->langTag . "';";
			$method[] = $this->_t(2) . "\$reload = true;";
			$method[] = $this->_t(2) . "\$lang->load(\$extension, \$base_dir, \$language_tag, \$reload);";
			$method[] = $this->_t(2) . "// load the user model";
			$method[] = $this->_t(2) . "\$model = self::getModel('user', JPATH_ADMINISTRATOR . '/components/com_users', 'Users');";
			$method[] = $this->_t(2) . "// Check if password was set";
			$method[] = $this->_t(2) . "if (isset(\$new['password']) && isset(\$new['password2']) && self::checkString(\$new['password']) && self::checkString(\$new['password2']))";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "// Use the users passwords";
			$method[] = $this->_t(3) . "\$password = \$new['password'];";
			$method[] = $this->_t(3) . "\$password2 = \$new['password2'];";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "// set username";
			$method[] = $this->_t(2) . "if (isset(\$new['username']) && self::checkString(\$new['username']))";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "\$new['username'] = self::safeString(\$new['username']);";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "else";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "\$new['username'] = self::safeString(\$new['name']);";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "// linup update user data";
			$method[] = $this->_t(2) . "\$data = array(";
			$method[] = $this->_t(3) . "'id' => \$new['id'],";
			$method[] = $this->_t(3) . "'username' => \$new['username'],";
			$method[] = $this->_t(3) . "'name' => \$new['name'],";
			$method[] = $this->_t(3) . "'email' => \$new['email'],";
			$method[] = $this->_t(3) . "'password1' => \$password, // First password field";
			$method[] = $this->_t(3) . "'password2' => \$password2, // Confirm password field";
			$method[] = $this->_t(3) . "'block' => 0 );";
			$method[] = $this->_t(2) . "// set groups if found";
			$method[] = $this->_t(2) . "if (isset(\$new['groups']) && self::checkArray(\$new['groups']))";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "\$data['groups'] = \$new['groups'];";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "// register the new user";
			$method[] = $this->_t(2) . "\$done = \$model->save(\$data);";
			$method[] = $this->_t(2) . "// if user is updated";
			$method[] = $this->_t(2) . "if (\$done)";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "return \$new['id'];";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "return \$model->getError();";
			$method[] = $this->_t(1) . "}";

			// return the help method
			return implode(PHP_EOL, $method);
		}
		return '';
	}

	public function setAdminViewMenu(&$viewName_single, &$view)
	{
		$xml = '';
		// build the file target values
		$target = array('site' => $viewName_single);
		// build the edit.xml file
		if ($this->buildDynamique($target, 'admin_menu'))
		{
			// set the lang
			$lang = ComponentbuilderHelper::safeString('com_' . $this->componentCodeName . '_menu_' . $viewName_single, 'U');
			$this->setLangContent('adminsys', $lang . '_TITLE', 'Create ' . $view['settings']->name_single);
			$this->setLangContent('adminsys', $lang . '_OPTION', 'Create ' . $view['settings']->name_single);
			$this->setLangContent('adminsys', $lang . '_DESC', $view['settings']->short_description);
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= PHP_EOL . '<metadata>';
			$xml .= PHP_EOL . $this->_t(1) . '<layout title="' . $lang . '_TITLE" option="' . $lang . '_OPTION">';
			$xml .= PHP_EOL . $this->_t(2) . '<message>';
			$xml .= PHP_EOL . $this->_t(3) . '<![CDATA[' . $lang . '_DESC]]>';
			$xml .= PHP_EOL . $this->_t(2) . '</message>';
			$xml .= PHP_EOL . $this->_t(1) . '</layout>';
			$xml .= PHP_EOL . '</metadata>';
		}
		else
		{
			$this->app->enqueueMessage(JText::sprintf('<hr /><p>Site menu for <b>%s</b> was not build.</p>', $viewName_single), 'Warning');
		}
		return $xml;
	}

	public function setCustomViewMenu(&$view)
	{
		$xml = '';
		// build the file target values
		$target = array('site' => $view['settings']->code);
		// build the default.xml file
		if ($this->buildDynamique($target, 'menu'))
		{
			// set the lang
			$lang = ComponentbuilderHelper::safeString('com_' . $this->componentCodeName . '_menu_' . $view['settings']->code, 'U');
			$this->setLangContent('adminsys', $lang . '_TITLE', $view['settings']->name);
			$this->setLangContent('adminsys', $lang . '_OPTION', $view['settings']->name);
			$this->setLangContent('adminsys', $lang . '_DESC',  $view['settings']->description);
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= PHP_EOL . '<metadata>';
			$xml .= PHP_EOL . $this->_t(1) . '<layout title="' . $lang . '_TITLE" option="' . $lang . '_OPTION">';
			$xml .= PHP_EOL . $this->_t(2) . '<message>';
			$xml .= PHP_EOL . $this->_t(3) . '<![CDATA[' . $lang . '_DESC]]>';
			$xml .= PHP_EOL . $this->_t(2) . '</message>';
			$xml .= PHP_EOL . $this->_t(1) . '</layout>';
			if (isset($this->hasIdRequest[$view['settings']->code]) || isset($this->hasCatIdRequest[$view['settings']->code]))
			{
				$xml .= PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Add fields to the request variables for the layout. -->';
				$xml .= PHP_EOL . $this->_t(1) . '<fields name="request">';
				$xml .= PHP_EOL . $this->_t(2) . '<fieldset name="request"';
				$xml .= PHP_EOL . $this->_t(3) . 'addrulepath="/administrator/components/com_' . $this->componentCodeName . '/models/rules"';
				$xml .= PHP_EOL . $this->_t(3) . 'addfieldpath="/administrator/components/com_' . $this->componentCodeName . '/models/fields">';
				if (isset($this->hasIdRequest[$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->hasIdRequest[$view['settings']->code]))
				{
					foreach ($this->hasIdRequest[$view['settings']->code] as $requestFieldXML)
					{
						$xml .= PHP_EOL . $this->_t(3) . $requestFieldXML;
					}
				}
				if (isset($this->hasCatIdRequest[$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->hasCatIdRequest[$view['settings']->code]))
				{
					foreach ($this->hasCatIdRequest[$view['settings']->code] as $requestFieldXML)
					{
						$xml .= PHP_EOL . $this->_t(3) . $requestFieldXML;
					}
				}
				$xml .= PHP_EOL . $this->_t(2) . '</fieldset>';
				$xml .= PHP_EOL . $this->_t(1) . '</fields>';
			}
			if (isset($this->frontEndParams) && isset($this->frontEndParams[$view['settings']->name]))
			{
				// first we must setup the fields for the page use
				$params = $this->setupFrontendParamFields($this->frontEndParams[$view['settings']->name], $view['settings']->code);
				// now load the fields
				if (ComponentbuilderHelper::checkArray($params))
				{
					$xml .= PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Adding page parameters -->';
					$xml .= PHP_EOL . $this->_t(1) . '<fields name="params">';
					$xml .= PHP_EOL . $this->_t(2) . '<fieldset name="basic" label="COM_' . $this->fileContentStatic[$this->hhh . 'COMPONENT' . $this->hhh] . '"';
					$xml .= PHP_EOL . $this->_t(3) . 'addrulepath="/administrator/components/com_' . $this->componentCodeName . '/models/rules"';
					$xml .= PHP_EOL . $this->_t(3) . 'addfieldpath="/administrator/components/com_' . $this->componentCodeName . '/models/fields">';
					$xml .= implode($this->_t(3), $params);
					$xml .= PHP_EOL . $this->_t(2) . '</fieldset>';
					$xml .= PHP_EOL . $this->_t(1) . '</fields>';
				}
			}
			$xml .= PHP_EOL . '</metadata>';
		}
		else
		{
			$this->app->enqueueMessage(JText::sprintf('<hr /><p>Site menu for <b>%s</b> was not build.</p>', $view['settings']->code), 'Warning');
		}
		return $xml;
	}

	public function setupFrontendParamFields($params, $view)
	{
		$keep = array();
		$menuSetter = $view . '_menu';
		foreach ($params as $field)
		{
			// some switch to see if it should be added to front end params
			$target = ComponentbuilderHelper::getBetween($field, 'display="', '"');
			if (!ComponentbuilderHelper::checkString($target) || $target === 'menu')
			{
				$field = str_replace('display="menu"', '', $field);
				// we update fields that have options if not only added to menu
				if ($target !== 'menu' && strpos($field, 'Option Set. -->') !== false && strpos($field, $menuSetter) === false && !ComponentbuilderHelper::checkString($target))
				{
					// we add the global option
					$field = str_replace('Option Set. -->', $this->setLine(__LINE__) . ' Global & Option Set. -->' . PHP_EOL . $this->_t(3) . '<option value="">' . PHP_EOL . $this->_t(4) . 'JGLOBAL_USE_GLOBAL</option>', $field);
					// update the default to be global
					$field = preg_replace('/default=".+"/', 'default=""', $field);
					// update the default to be filter
					$field = preg_replace('/filter=".+"/', 'filter="string"', $field);
					// update required
					$field = str_replace('required="true"', 'required="false"', $field);
					// add to keeper array
					$keep[] = $field;
				}
				else
				{
					$keep[] = $field;
				}
			}
		}
		return $keep;
	}

	public function setCustomViewQuery(&$gets, &$code, $tab = '', $type = 'main')
	{
		$query = '';
		if (ComponentbuilderHelper::checkArray($gets))
		{
			$mainAsArray = array();
			$check = 'zzz';
			foreach ($gets as $nr => $the_get)
			{
				// to insure that there be no double entries of a call
				$checker = md5(serialize($the_get) . $code);
				if (!isset($this->customViewQueryChecker[$this->target]) || !in_array($checker, $this->customViewQueryChecker[$this->target]))
				{
					// load this unuiqe key
					$this->customViewQueryChecker[$this->target][] = $checker;
					if (isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))
					{
						$getItem = PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Get from " . $the_get['selection']['table'] . " as " . $the_get['as'];
						// set the selection
						$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . $the_get['selection']['select'];
					}
					else
					{
						$getItem = PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Get data";
						// set the selection
						$getItem .= PHP_EOL . $this->setPlaceholders($the_get['selection']['select'], $this->placeholders);
					}
					// load the from selection
					if (($nr == 0 && (!isset($the_get['join_field']) || !ComponentbuilderHelper::checkString($the_get['join_field'])) && (isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))) ||
						($type === 'custom' && (isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))))
					{
						$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . '$query->from(' . $the_get['selection']['from'] . ');';
					}
					elseif (isset($the_get['join_field']) && ComponentbuilderHelper::checkString($the_get['join_field']) && isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))
					{
						$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$query->join('" . $the_get['type'];
						$getItem .= "', (" . $the_get['selection']['from'];
						$getItem .= ") . ' ON (' . \$db->quoteName('" . $the_get['on_field'];
						$getItem .= "') . ' " . $the_get['operator'];
						$getItem .= " ' . \$db->quoteName('" . $the_get['join_field'] . "') . ')');";

						$check = current(explode(".", $the_get['on_field']));
					}

					// set the method defaults
					if (($default = $this->setCustomViewMethodDefaults($the_get, $code)) !== false)
					{
						if (isset($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && ComponentbuilderHelper::checkString($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && !in_array($check, $mainAsArray))
						{
							// load to other query
							if (!isset($this->otherQuery[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']]))
							{
								$this->otherQuery[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] = '';
							}
							$this->otherQuery[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] .= $getItem;
						}
						else
						{
							$mainAsArray[] = $default['as'];
							$query .= $getItem;
						}
					}
				}
			}
		}
		return $query;
	}

	public function setCustomViewFieldDecodeFilter(&$get, &$filters, $string, $removeString, $code, $tab)
	{
		$filter = '';
		// check if filter is set for this field
		if (ComponentbuilderHelper::checkArray($filters))
		{
			foreach ($filters as $field => $ter)
			{
				// build load counter
				$key = md5('setCustomViewFieldDecodeFilter' . $code . $get['key'] . $string . $ter['table_key']);
				// check if we should load this again
				if (strpos($get['selection']['select'], $ter['table_key']) !== false && !isset($this->loadTracker[$key]))
				{
					// set the key
					$this->loadTracker[$key] = $key;
					$as = '';
					$felt = '';
					list($as, $felt) = array_map('trim', explode('.', $ter['table_key']));
					if ($get['as'] == $as)
					{
						switch ($ter['filter_type'])
						{
							case 4:
								// COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
								$filter .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " filter " . $as . " based on user groups";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$remove = (count(array_intersect((array) \$this->groups, (array) " . $string . "->" . $field . "))) ? false : true;";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (\$remove)";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
								if ($removeString == $string)
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Remove " . $string . " if user not in groups";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . $string . " = null;";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "return false;";
								}
								else
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Unset " . $string . " if user not in groups";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "unset(" . $removeString . ");";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "continue;";
								}
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
								break;
							case 9:
								// COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE

								$filter .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(" . $string . "->" . $field . "))";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";

								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " do your thing here";

								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "else";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";

								if ($removeString == $string)
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Remove " . $string . " if not array.";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . $string . " = null;";
								}
								else
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Unset " . $string . " if not array.";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "unset(" . $removeString . ");";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "continue;";
								}

								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
								break;
							case 10:
								// COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
								$filter .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " filter " . $as . " based on repeatable value";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkString(" . $string . "->" . $field . "))";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";

								$filter .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "\$array = json_decode(" . $string . "->" . $field . ",true);";
								$filter .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$array))";
								$filter .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "{";

								$filter .= PHP_EOL . $this->_t(2) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " do your thing here";

								$filter .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "}";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "else";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "{";

								if ($removeString == $string)
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove " . $string . " if not array.";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . $string . " = null;";
								}
								else
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Unset " . $string . " if not array.";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "unset(" . $removeString . ");";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "continue;";
								}

								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "}";

								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "else";
								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";

								if ($removeString == $string)
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Remove " . $string . " if not string.";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . $string . " = null;";
								}
								else
								{
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Unset " . $string . " if not string.";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "unset(" . $removeString . ");";
									$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "continue;";
								}

								$filter .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
								break;
						}
					}
				}
			}
		}
		return $filter;
	}

	public function setCustomViewFieldDecode(&$get, $checker, $string, $code, $tab = '')
	{
		$fieldDecode = '';
		foreach ($checker as $field => $array)
		{
			// build load counter
			$key = md5('setCustomViewFieldDecode' . $code . $get['key'] . $string . $field);
			// check if we should load this again
			if (strpos($get['selection']['select'], $field) !== false && !isset($this->loadTracker[$key]) && ComponentbuilderHelper::checkArray($array['decode']))
			{
				// set the key
				$this->loadTracker[$key] = $key;
				// insure it is unique
				$array['decode'] = (array) array_unique(array_reverse((array) $array['decode']));
				// now loop the array
				foreach ($array['decode'] as $decode)
				{
					$if = '';
					$decoder = '';
					if ('json' === $decode)
					{
						$if = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkJson(" . $string . "->" . $field . "))" . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
						// json_decode
						$decoder = $string . "->" . $field . " = json_decode(" . $string . "->" . $field . ", true);";
					}
					elseif ('base64' === $decode)
					{
						$if = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (!empty(" . $string . "->" . $field . ") && " . $string . "->" . $field . " === base64_encode(base64_decode(" . $string . "->" . $field . ")))" . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
						// base64_decode
						$decoder = $string . "->" . $field . " = base64_decode(" . $string . "->" . $field . ");";
					}
					elseif (strpos($decode, '_encryption') !== false || 'expert_mode' === $decode)
					{
						foreach ($this->cryptionTypes as $cryptionType)
						{
							if ($cryptionType . '_encryption' === $decode || $cryptionType . '_mode' === $decode)
							{
								if ('expert' !== $cryptionType)
								{
									$if = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (!empty(" . $string . "->" . $field . ") && \$" . $cryptionType . "key && !is_numeric(" . $string . "->" . $field . ") && " . $string . "->" . $field . " === base64_encode(base64_decode(" . $string . "->" . $field . ", true)))" . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
									// set decryption
									$decoder = $string . "->" . $field . " = rtrim(\$" . $cryptionType . "->decryptString(" . $string . "->" . $field . "), " . '"\0"' . ");";
								}
								elseif (isset($this->{$cryptionType . 'FieldModeling'}[$array['admin_view']][$field]))
								{
									$_placeholder_for_field = array('[[[field]]]' => $string . "->" . $field);
									$fieldDecode .= $this->setPlaceholders(PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . implode(PHP_EOL . $this->_t(1) . $tab . $this->_t(1), $this->{$cryptionType . 'FieldModeling'}[$array['admin_view']][$field]['get']), $_placeholder_for_field);
								}
								// activate site decryption
								$this->siteDecrypt[$cryptionType][$code] = true;
							}
						}
					}
					// check if we have found the details
					if (ComponentbuilderHelper::checkString($if))
					{
						// build decoder string
						$fieldDecode .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Check if we can decode " . $field .$if . PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Decode " . $field;
					}
					if (ComponentbuilderHelper::checkString($decoder))
					{
						// build decoder string
						$fieldDecode .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . $decoder . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
					}
				}
			}
		}
		return $fieldDecode;
	}

	public function setCustomViewFieldonContentPrepareChecker(&$get, $checker, $string, $code, $tab = '')
	{
		$fieldPrepare = '';
		$runplugins = false;
		// set component
		$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
		// set context 
		$context = (isset($get['context'])) ? $get['context'] : $code;
		$context = 'com_' . $this->componentCodeName . '.' . $context;
		// load parms builder only once
		$params = false;
		foreach ($checker as $field => $array)
		{
			// build load counter
			$key = md5('setCustomViewFieldonContentPrepareChecker' . $code . $get['key'] . $string . $field);
			// check if we should load this again
			if (strpos($get['selection']['select'], $field) !== false && !isset($this->loadTracker[$key]))
			{
				// set the key
				$this->loadTracker[$key] = $key;
				// build decoder string
				if (!$runplugins)
				{
					$runplugins = PHP_EOL . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Load the JEvent Dispatcher";
					$runplugins .= PHP_EOL . $tab . $this->_t(1) . "JPluginHelper::importPlugin('content');";
					$runplugins .= PHP_EOL . $tab . $this->_t(1) . '$this->_dispatcher = JEventDispatcher::getInstance();';
				}
				if (!$params)
				{
					$fieldPrepare .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Check if item has params, or pass whole item.";
					$fieldPrepare .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$params = (isset(" . $string . "->params) && " . $Component . "Helper::checkJson(" . $string . "->params)) ? json_decode(" . $string . "->params) : " . $string . ";";
					$params = true;
				}
				$fieldPrepare .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Make sure the content prepare plugins fire on " . $field;
				$fieldPrepare .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$_" . $field . " = new stdClass();";
				$fieldPrepare .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$_" . $field . '->text =& ' . $string . '->' . $field . '; //' . $this->setLine(__LINE__) . ' value must be in text';
				$fieldPrepare .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Since all values are now in text (Joomla Limitation), we also add the field name (" . $field . ") to context";
				$fieldPrepare .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . '$this->_dispatcher->trigger("onContentPrepare", array(\'' . $context . '.' . $field . '\', &$_' . $field . ', &$params, 0));';
			}
		}
		// load dispatcher
		if ($runplugins)
		{
			$this->JEventDispatcher = array($this->hhh . 'DISPATCHER' . $this->hhh => $runplugins);
		}
		// return content prepare fix
		return $fieldPrepare;
	}

	public function setCustomViewFieldUikitChecker(&$get, $checker, $string, $code, $tab = '')
	{
		$fieldUikit = '';
		foreach ($checker as $field => $array)
		{
			// build load counter
			$key = md5('setCustomViewFieldUikitChecker' . $code . $get['key'] . $string . $field);
			// check if we should load this again
			if (strpos($get['selection']['select'], $field) !== false && !isset($this->loadTracker[$key]))
			{
				// set the key
				$this->loadTracker[$key] = $key;
				// only load for uikit version 2 (TODO) we may need to add another check here
				if (2 == $this->uikit || 1 == $this->uikit)
				{
					$fieldUikit .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Checking if " . $field . " has uikit components that must be loaded.";
					$fieldUikit .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$this->uikitComp = " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::getUikitComp(" . $string . "->" . $field . ",\$this->uikitComp);";
				}
			}
		}
		// return UIKIT fix
		return $fieldUikit;
	}

	public function setCustomViewCustomJoin(&$gets, $string, $code, &$asBucket, $tab = '')
	{
		if (ComponentbuilderHelper::checkArray($gets))
		{
			$customJoin = '';
			foreach ($gets as $get)
			{
				// set the value name $default
				if (($default = $this->setCustomViewMethodDefaults($get, $code)) !== false)
				{
					if ($this->checkJoint($default, $get, $asBucket))
					{
						// build custom join string
						$otherJoin = PHP_EOL . $this->_t(1) . $this->hhh . "TAB" . $this->hhh . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set " . $default['valueName'] . " to the " . $this->hhh . "STRING" . $this->hhh . " object.";
						$otherJoin .= PHP_EOL . $this->_t(1) . $this->hhh . "TAB" . $this->hhh . $this->_t(1) . $this->hhh . "STRING" . $this->hhh . "->" . $default['valueName'] . " = \$this->get" . $default['methodName'] . "(" . $this->hhh . "STRING" . $this->hhh . "->" . $this->getAsLookup[$get['key']][$get['on_field']] . ");";
						// load to other join
						if (!isset($this->otherJoin[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']]))
						{
							$this->otherJoin[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] = '';
						}
						$this->otherJoin[$this->target][$default['code']][$this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]][$default['valueName']] .= $otherJoin;
					}
					else
					{
						// build custom join string
						$customJoin .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set " . $default['valueName'] . " to the " . $string . " object.";
						$customJoin .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . $string . "->" . $default['valueName'] . " = \$this->get" . $default['methodName'] . "(" . $string . "->" . $this->getAsLookup[$get['key']][$get['on_field']] . ");";
					}
				}
			}
			return $customJoin;
		}
		return '';
	}

	public function checkJoint(&$default, &$get, &$asBucket)
	{
		// check if this function is not linked to the main call
		list($aJoin) = explode('.', $get['on_field']);
		if (ComponentbuilderHelper::checkArray($asBucket) && in_array($aJoin, $asBucket))
		{
			return false;
		}
		// default fallback
		elseif (isset($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && ComponentbuilderHelper::checkString($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]))
		{
			return true;
		}
		return false;
	}

	public function setCustomViewFilter(&$filter, &$code, $tab = '')
	{
		$filters = '';
		if (ComponentbuilderHelper::checkArray($filter))
		{
			foreach ($filter as $ter)
			{
				$as = '';
				$field = '';
				$string = '';
				if (strpos($ter['table_key'], '.') !== false)
				{
					list($as, $field) = array_map('trim', explode('.', $ter['table_key']));
				}
				switch ($ter['filter_type'])
				{
					case 1:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_ID
						$string = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " ' . (int) \$pk);";
						break;
					case 2:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_USER
						$string = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " ' . (int) \$this->userId);";
						break;
					case 3:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_ACCESS_LEVEL
						$string = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " (' . implode(',', \$this->levels) . ')');";
						break;
					case 4:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
						$decodeChecker = $this->siteFieldData['decode'][$code][$ter['key']][$as][$field];
						if (ComponentbuilderHelper::checkArray($decodeChecker) || $ter['state_key'] === 'array')
						{
							// set needed fields to filter after query
							$this->siteFieldDecodeFilter[$this->target][$code][$ter['key']][$as][$field] = $ter;
						}
						else
						{
							$string = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " (' . implode(',', \$this->groups) . ')');";
						}
						break;
					case 5:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_CATEGORIES
						$string = PHP_EOL . $this->_t(2) . $tab . "//" . $this->setLine(__LINE__) . " (TODO) The dynamic category filter is not ready.";
						break;
					case 6:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_TAGS
						$string = PHP_EOL . $this->_t(2) . $tab . "//" . $this->setLine(__LINE__) . " (TODO) The dynamic tags filter is not ready.";
						break;
					case 7:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_DATE
						$string = PHP_EOL . $this->_t(2) . $tab . "//" . $this->setLine(__LINE__) . " (TODO) The dynamic date filter is not ready.";
						break;
					case 8:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_FUNCTIONVAR
						if ($ter['operator'] === 'IN' || $ter['operator'] === 'NOT IN')
						{
							$string = PHP_EOL . $this->_t(2) . $tab . "//" . $this->setLine(__LINE__) . " Check if " . $ter['state_key'] . " is an array with values.";
							$string .= PHP_EOL . $this->_t(2) . $tab . "\$array = " . $ter['state_key'] . ";";
							$string .= PHP_EOL . $this->_t(2) . $tab . "if (isset(\$array) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$array))";
							$string .= PHP_EOL . $this->_t(2) . $tab . "{";
							$string .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " (' . implode(',', \$array) . ')');";
							$string .= PHP_EOL . $this->_t(2) . $tab . "}";
							$string .= PHP_EOL . $this->_t(2) . $tab . "else";
							$string .= PHP_EOL . $this->_t(2) . $tab . "{";
							$string .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "return false;";
							$string .= PHP_EOL . $this->_t(2) . $tab . "}";
						}
						else
						{
							$string = PHP_EOL . $this->_t(2) . $tab . "//" . $this->setLine(__LINE__) . " Check if " . $ter['state_key'] . " is a string or numeric value.";
							$string .= PHP_EOL . $this->_t(2) . $tab . "\$checkValue = " . $ter['state_key'] . ";";
							$string .= PHP_EOL . $this->_t(2) . $tab . "if (isset(\$checkValue) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkString(\$checkValue))";
							$string .= PHP_EOL . $this->_t(2) . $tab . "{";
							$string .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " ' . \$db->quote(\$checkValue));";
							$string .= PHP_EOL . $this->_t(2) . $tab . "}";
							$string .= PHP_EOL . $this->_t(2) . $tab . "elseif (is_numeric(\$checkValue))";
							$string .= PHP_EOL . $this->_t(2) . $tab . "{";
							$string .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " ' . \$checkValue);";
							$string .= PHP_EOL . $this->_t(2) . $tab . "}";
							$string .= PHP_EOL . $this->_t(2) . $tab . "else";
							$string .= PHP_EOL . $this->_t(2) . $tab . "{";
							$string .= PHP_EOL . $this->_t(2) . $tab . $this->_t(1) . "return false;";
							$string .= PHP_EOL . $this->_t(2) . $tab . "}";
						}
						break;
					case 9:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE
						$string = "";
						// set needed fields to filter after query
						$this->siteFieldDecodeFilter[$this->target][$code][$ter['key']][$as][$field] = $ter;
						break;
					case 10:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
						$string = "";
						// set needed fields to filter after query
						$this->siteFieldDecodeFilter[$this->target][$code][$ter['key']][$as][$field] = $ter;
						break;
					case 11:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_OTHER
						if (strpos($as, '(') !== false)
						{
							// TODO (for now we only fix extra sql methods here)
							list($dump, $as) = array_map('trim', explode('(', $as));
							$field = trim(str_replace(')', '', $field));
						}
						$string = PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$query->where('" . $ter['table_key'] . " " . $ter['operator'] . " " . $ter['state_key'] . "');";
						break;
				}
				// only add if the filter is set
				if (ComponentbuilderHelper::checkString($string))
				{
					// sort where
					if ($as === 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
					{
						$filters .= $string;
					}
					elseif ($as !== 'a')
					{
						$this->otherFilter[$this->target][$code][$as][$field] = $string;
					}
				}
			}
		}
		return $filters;
	}

	public function setCustomViewGroup(&$group, &$code, $tab = '')
	{
		$grouping = '';
		if (ComponentbuilderHelper::checkArray($group))
		{
			foreach ($group as $gr)
			{
				list($as, $field) = array_map('trim', explode('.', $gr['table_key']));
				// set the string
				$string = "\$query->group('" . $gr['table_key'] . "');";
				// sort where
				if ($as === 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
				{
					$grouping .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . $string;
				}
				else
				{
					$this->otherGroup[$this->target][$code][$as][$field] = PHP_EOL . $this->_t(2) . $string;
				}
			}
		}
		return $grouping;
	}

	public function setCustomViewOrder(&$order, &$code, $tab = '')
	{
		$ordering = '';
		if (ComponentbuilderHelper::checkArray($order))
		{
			foreach ($order as $or)
			{
				list($as, $field) = array_map('trim', explode('.', $or['table_key']));
				// check if random
				if ('RAND' === $or['direction'])
				{
					// set the string
					$string = "\$query->order('RAND()');";
				}
				else
				{
					// set the string
					$string = "\$query->order('" . $or['table_key'] . " " . $or['direction'] . "');";
				}
				// sort where
				if ($as === 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
				{
					$ordering .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . $string;
				}
				else
				{
					$this->otherOrder[$this->target][$code][$as][$field] = PHP_EOL . $this->_t(2) . $string;
				}
			}
		}
		return $ordering;
	}

	public function setCustomViewWhere(&$where, &$code, $tab = '')
	{
		$wheres = '';
		if (ComponentbuilderHelper::checkArray($where))
		{
			foreach ($where as $whe)
			{
				$as = '';
				$field = '';
				$value = '';
				list($as, $field) = array_map('trim', explode('.', $whe['table_key']));
				if (is_numeric($whe['value_key']))
				{
					$value = " " . $whe['value_key'] . "');";
				}
				elseif (strpos($whe['value_key'], '$') !== false)
				{
					if ($whe['operator'] === 'IN' || $whe['operator'] === 'NOT IN')
					{
						$value = " (' . implode(',', " . $whe['value_key'] . ") . ')');";
					}
					else
					{
						$value = " ' . \$db->quote(" . $whe['value_key'] . "));";
					}
				}
				elseif (strpos($whe['value_key'], '.') !== false)
				{
					if (strpos($whe['value_key'], "'") !== false)
					{
						$value = " ' . \$db->quote(" . $whe['value_key'] . "));";
					}
					else
					{
						$value = " " . $whe['value_key'] . "');";
					}
				}
				elseif (ComponentbuilderHelper::checkString($whe['value_key']))
				{
					$value = " " . $whe['value_key'] . "');";
				}
				// only load if there is a value
				if (ComponentbuilderHelper::checkString($value))
				{
					$tabe = '';
					if ($as === 'a')
					{
						$tabe = $tab;
					}
					// set the string
					if ($whe['operator'] === 'IN' || $whe['operator'] === 'NOT IN')
					{
						$string = "if (isset(" . $whe['value_key'] . ") && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(" . $whe['value_key'] . "))";
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(1) . "{";
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get where " . $whe['table_key'] . " is " . $whe['value_key'];
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(2) . "\$query->where('" . $whe['table_key'] . " " . $whe['operator'] . $value;
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(1) . "}";
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(1) . "else";
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(1) . "{";
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(2) . "return false;";
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(1) . "}";
					}
					else
					{
						$string = "//" . $this->setLine(__LINE__) . " Get where " . $whe['table_key'] . " is " . $whe['value_key'];
						$string .= PHP_EOL . $this->_t(1) . $tabe . $this->_t(1) . "\$query->where('" . $whe['table_key'] . " " . $whe['operator'] . $value;
					}
					// sort where
					if ($as === 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
					{
						$wheres .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . $string;
					}
					elseif ($as !== 'a')
					{
						$this->otherWhere[$this->target][$code][$as][$field] = PHP_EOL . $this->_t(2) . $string;
					}
				}
			}
		}
		return $wheres;
	}

	public function setCustomViewGlobals(&$global, $string, $as, $tab = '')
	{
		$globals = '';
		if (ComponentbuilderHelper::checkArray($global))
		{
			$as = array_unique($as);
			foreach ($global as $glo)
			{
				if (in_array($glo['as'], $as))
				{
					switch ($glo['type'])
					{
						case 1:
							// SET STATE
							$value = "\$this->setState('" . $glo['as'] . "." . $glo['name'] . "', " . $string . "->" . $glo['key'] . ");";
							break;
						case 2:
							// SET THIS
							$value = "\$this->" . $glo['as'] . "_" . $glo['name'] . " = " . $string . "->" . $glo['key'] . ";";
							break;
					}
					// only add if the filter is set
					if (ComponentbuilderHelper::checkString($value))
					{
						$globals .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set the global " . $glo['name'] . " value." . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . $value;
					}
				}
			}
		}
		return $globals;
	}

	/**
	 * @param $string
	 * @param string $type
	 * @return mixed
	 */
	public function removeAsDot($string, $type = '')
	{
		if (strpos($string, '.') !== false)
		{
			list($dump, $field) = array_map('trim', explode('.', $string));
		}
		else
		{
			$field = $string;
		}
		return $field;
	}

	/**
	 * @param type $view
	 * @param type $type
	 */
	public function setUserPermissionCheckAccess($view, $type)
	{
		if (isset($view['access']) && $view['access'] == 1)
		{
			switch ($type)
			{
				case 1:
					$userString = '$this->user';
					break;
				default:
					$userString = '$user';
					break;
			}
			// check that the default and the redirect page is not the same
			if (isset($this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh]) && $this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh] != $view['settings']->code)
			{
				$redirectMessage = $this->_t(3) . "//" . $this->setLine(__LINE__) . " redirect away to the default view if no access allowed.";
				$redirectString = "JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=" . $this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh] . "')";
			}
			else
			{
				$redirectMessage = $this->_t(3) . "//" . $this->setLine(__LINE__) . " redirect away to the home page if no access allowed.";
				$redirectString = 'JURI::root()';
			}
			$accessCheck[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if this user has permission to access item";
			$accessCheck[] = $this->_t(2) . "if (!" . $userString . "->authorise('site." . $view['settings']->code . ".access', 'com_" . $this->componentCodeName . "'))";
			$accessCheck[] = $this->_t(2) . "{";
			$accessCheck[] = $this->_t(3) . "\$app = JFactory::getApplication();";
			// set lang
			$langKeyWord = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Not authorised to view ' . $view['settings']->code . '!', 'U');
			$this->setLangContent('site', $langKeyWord, 'Not authorised to view ' . $view['settings']->code . '!');
			$accessCheck[] = $this->_t(3) . "\$app->enqueueMessage(JText:" . ":_('" . $langKeyWord . "'), 'error');";
			$accessCheck[] = $redirectMessage;
			$accessCheck[] = $this->_t(3) . "\$app->redirect(" . $redirectString . ");";
			$accessCheck[] = $this->_t(3) . "return false;";
			$accessCheck[] = $this->_t(2) . "}";

			// return the access check
			return implode(PHP_EOL, $accessCheck);
		}
		return '';
	}

	/**
	 * @param $get
	 * @param $code
	 * @param string $tab
	 * @param string $type
	 * @return string
	 */
	public function setCustomViewGetItem(&$get, &$code, $tab = '', $type = 'main')
	{
		if (ComponentbuilderHelper::checkObject($get))
		{
			// set the site decription switches
			foreach ($this->cryptionTypes as $cryptionType)
			{
				$this->siteDecrypt[$cryptionType][$code] = false;
			}
			// start the get Item
			$getItem = '';
			// set before item php
			if (isset($get->add_php_before_getitem) && $get->add_php_before_getitem == 1 && isset($get->php_before_getitem) && ComponentbuilderHelper::checkString($get->php_before_getitem))
			{
				$getItem .= $this->setPlaceholders($get->php_before_getitem, $this->placeholders);
			}
			// start loadin the get Item
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Get a db connection.";
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$db = JFactory::getDbo();";
			$getItem .= PHP_EOL . PHP_EOL . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$query = \$db->getQuery(true);";
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get, $code, $tab);
			// setup filters
			if (isset($get->filter))
			{
				$getItem .= $this->setCustomViewFilter($get->filter, $code, $tab);
			}
			// setup Where
			if (isset($get->where))
			{
				$getItem .= $this->setCustomViewWhere($get->where, $code, $tab);
			}
			// setup ordering
			if (isset($get->order))
			{
				$getItem .= $this->setCustomViewOrder($get->order, $code, $tab);
			}
			// setup grouping
			if (isset($get->group))
			{
				$getItem .= $this->setCustomViewGroup($get->group, $code, $tab);
			}
			// get ready to get query
			$getItem .= PHP_EOL . PHP_EOL . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Reset the query using our newly populated query object.";
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$db->setQuery(\$query);";
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Load the results as a stdClass object.";
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$data = \$db->loadObject();";
			// set after item php
			if (isset($get->add_php_after_getitem) && $get->add_php_after_getitem == 1 && isset($get->php_after_getitem) && ComponentbuilderHelper::checkString($get->php_after_getitem))
			{
				$getItem .= $this->setPlaceholders($get->php_after_getitem, $this->placeholders);
			}
			$getItem .= PHP_EOL . PHP_EOL . $tab . $this->_t(2) . "if (empty(\$data))";
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
			if ($type === 'main')
			{
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "\$app = JFactory::getApplication();";
				$langKeyWoord = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Not found or access denied', 'U');
				$this->setLangContent($this->lang, $langKeyWoord, 'Not found, or access denied.');
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " If no data is found redirect to default page and show warning.";
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "\$app->enqueueMessage(JText:" . ":_('" . $langKeyWoord . "'), 'warning');";
				if ('site' === $this->target)
				{
					// check that the default and the redirect page is not the same
					if (isset($this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh]) && $this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh] != $code)
					{
						$redirectString = "JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=" . $this->fileContentStatic[$this->hhh . 'SITE_DEFAULT_VIEW' . $this->hhh] . "')";
					}
					else
					{
						$redirectString = 'JURI::root()';
					}
					$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "\$app->redirect(" . $redirectString . ");";
				}
				else
				{
					$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "\$app->redirect('index.php?option=com_" . $this->componentCodeName . "');";
				}
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "return false;";
			}
			else
			{
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "return false;";
			}
			$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
			// dispatcher placholder
			$getItem .= $this->hhh . "DISPATCHER" . $this->hhh;
			if (ComponentbuilderHelper::checkArray($get->main_get))
			{
				$asBucket = array();
				foreach ($get->main_get as $main_get)
				{
					if (isset($main_get['key']) && isset($main_get['as']))
					{
						if (isset($this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']]))
						{
							$decodeChecker = $this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']];
							if (ComponentbuilderHelper::checkArray($decodeChecker))
							{
								// set decoding of needed fields
								$getItem .= $this->setCustomViewFieldDecode($main_get, $decodeChecker, '$data', $code, $tab);
							}
						}

						if (isset($this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']]))
						{
							$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']];
							if (ComponentbuilderHelper::checkArray($decodeFilter))
							{
								// also filter fields if needed
								$getItem .= $this->setCustomViewFieldDecodeFilter($main_get, $decodeFilter, '$data', '$data', $code, $tab);
							}
						}

						if (isset($this->siteFieldData['textareas'][$code][$main_get['key']][$main_get['as']]))
						{
							$contentprepareChecker = $this->siteFieldData['textareas'][$code][$main_get['key']][$main_get['as']];
							if (ComponentbuilderHelper::checkArray($contentprepareChecker))
							{
								// set contentprepare checkers on needed fields
								$getItem .= $this->setCustomViewFieldonContentPrepareChecker($main_get, $contentprepareChecker, '$data', $code, $tab);
							}
						}

						if (isset($this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']]))
						{
							$uikitChecker = $this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']];
							if (ComponentbuilderHelper::checkArray($uikitChecker))
							{
								// set uikit checkers on needed fields
								$getItem .= $this->setCustomViewFieldUikitChecker($main_get, $uikitChecker, '$data', $code, $tab);
							}
						}
						$asBucket[] = $main_get['as'];
					}
				}
			}
			// set the scripts
			$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
			$script = '';
			foreach ($this->cryptionTypes as $cryptionType)
			{
				if (isset($this->siteDecrypt[$cryptionType][$code]) && $this->siteDecrypt[$cryptionType][$code])
				{
					if ('expert' !== $cryptionType)
					{
						$script .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Get the " . $cryptionType . " encryption.";
						$script .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$" . $cryptionType . "key = " . $Component . "Helper::getCryptKey('" . $cryptionType . "');";
						$script .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Get the encryption object.";
						$script .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$" . $cryptionType . " = new FOFEncryptAes(\$" . $cryptionType . "key);";
					}
					elseif (isset($this->{$cryptionType . 'FieldModelInitiator'}[$code]) 
						&& isset($this->{$cryptionType . 'FieldModelInitiator'}[$code]['get']))
					{
						foreach ($this->{$cryptionType . 'FieldModelInitiator'}[$code]['get'] as $block)
						{
							$script .= PHP_EOL . $this->_t(1) . implode(PHP_EOL . $this->_t(1), $block);
						}
					}
				}
			}
			$getItem = $script . $getItem;
			// setup Globals
			$getItem .= $this->setCustomViewGlobals($get->global, '$data', $asBucket, $tab);
			// setup the custom gets that returns multipal values
			$getItem .= $this->setCustomViewCustomJoin($get->custom_get, '$data', $code, $asBucket, $tab);
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode(PHP_EOL, $this->setPlaceholders($get->php_calculation, $this->placeholders));
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . implode(PHP_EOL . $this->_t(1) . $tab . $this->_t(1), $get->php_calculation);
			}
			if ($type === 'custom')
			{
				// return the object
				$getItem .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " return data object.";
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "return \$data;";
			}
			else
			{
				// set the object
				$getItem .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set data object to item.";
				$getItem .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$this->_item[\$pk] = \$data;";
			}
			// only update if dispacher placholder is found
			if (strpos($getItem, $this->hhh . 'DISPATCHER' . $this->hhh) !== false)
			{
				// check if the dispather should be added
				if (!isset($this->JEventDispatcher) || !ComponentbuilderHelper::checkArray($this->JEventDispatcher))
				{
					$this->JEventDispatcher = array($this->hhh . 'DISPATCHER' . $this->hhh => '');
				}
				$getItem = str_replace(array_keys($this->JEventDispatcher), array_values($this->JEventDispatcher), $getItem);
			}
			return $getItem;
		}
		return PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . "add your custom code here.";
	}

	public function setCustomViewCustomMethods($main_view, $code)
	{
		$methods = '';
		// then set the needed custom methods
		if (ComponentbuilderHelper::checkArray($main_view) && isset($main_view['settings']) && ComponentbuilderHelper::checkObject($main_view['settings']) && isset($main_view['settings']->custom_get))
		{
			$_dynamic_get = $main_view['settings']->custom_get;
		}
		elseif (ComponentbuilderHelper::checkObject($main_view) && isset($main_view->custom_get))
		{
			$_dynamic_get = $main_view->custom_get;
		}
		// check if we have an array
		if (isset($_dynamic_get) && ComponentbuilderHelper::checkArray($_dynamic_get))
		{
			// start dynamic build
			foreach ($_dynamic_get as $view)
			{
				// fix alias to use in code
				$view->code = ComponentbuilderHelper::safeString($code);
				$view->Code = ComponentbuilderHelper::safeString($view->code, 'F');
				$view->CODE = ComponentbuilderHelper::safeString($view->code, 'U');
				$main       = '';
				if ($view->gettype == 3)
				{
					// SITE_GET_ITEM <<<DYNAMIC>>>
					$main .= PHP_EOL . PHP_EOL . $this->_t(2) . "if (!isset(\$this->initSet) || !\$this->initSet)";
					$main .= PHP_EOL . $this->_t(2) . "{";
					$main .= PHP_EOL . $this->_t(3) . "\$this->user = JFactory::getUser();";
					$main .= PHP_EOL . $this->_t(3) . "\$this->userId = \$this->user->get('id');";
					$main .= PHP_EOL . $this->_t(3) . "\$this->guest = \$this->user->get('guest');";
					$main .= PHP_EOL . $this->_t(3) . "\$this->groups = \$this->user->get('groups');";
					$main .= PHP_EOL . $this->_t(3) . "\$this->authorisedGroups = \$this->user->getAuthorisedGroups();";
					$main .= PHP_EOL . $this->_t(3) . "\$this->levels = \$this->user->getAuthorisedViewLevels();";
					$main .= PHP_EOL . $this->_t(3) . "\$this->initSet = true;";
					$main .= PHP_EOL . $this->_t(2) . "}";
					$main .= $this->setCustomViewGetItem($view, $view->code, '', 'custom');
					$type = 'mixed  item data object on success, false on failure.';
				}
				elseif ($view->gettype == 4)
				{
					$main .= PHP_EOL . PHP_EOL . $this->_t(2) . "if (!isset(\$this->initSet) || !\$this->initSet)";
					$main .= PHP_EOL . $this->_t(2) . "{";
					$main .= PHP_EOL . $this->_t(3) . "\$this->user = JFactory::getUser();";
					$main .= PHP_EOL . $this->_t(3) . "\$this->userId = \$this->user->get('id');";
					$main .= PHP_EOL . $this->_t(3) . "\$this->guest = \$this->user->get('guest');";
					$main .= PHP_EOL . $this->_t(3) . "\$this->groups = \$this->user->get('groups');";
					$main .= PHP_EOL . $this->_t(3) . "\$this->authorisedGroups = \$this->user->getAuthorisedGroups();";
					$main .= PHP_EOL . $this->_t(3) . "\$this->levels = \$this->user->getAuthorisedViewLevels();";
					$main .= PHP_EOL . $this->_t(3) . "\$this->initSet = true;";
					$main .= PHP_EOL . $this->_t(2) . "}";
					$main .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the global params";
					$main .= PHP_EOL . $this->_t(2) . "\$globalParams = JComponentHelper::getParams('com_" . $this->componentCodeName . "', true);";
					// set php before listquery
					if (isset($view->add_php_getlistquery) && $view->add_php_getlistquery == 1 && isset($view->php_getlistquery) && ComponentbuilderHelper::checkString($view->php_getlistquery))
					{
						$main .= $this->setPlaceholders($view->php_getlistquery, $this->placeholders);
					}
					// SITE_GET_LIST_QUERY <<<DYNAMIC>>>
					$main .= $this->setCustomViewListQuery($view, $view->code, false);
					// set before items php
					if (isset($view->add_php_before_getitems) && $view->add_php_before_getitems == 1 && isset($view->php_before_getitems) && ComponentbuilderHelper::checkString($view->php_before_getitems))
					{
						$main .= $this->setPlaceholders($view->php_before_getitems, $this->placeholders);
					}
					// load the object list
					$main .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Reset the query using our newly populated query object.";
					$main .= PHP_EOL . $this->_t(2) . "\$db->setQuery(\$query);";
					$main .= PHP_EOL . $this->_t(2) . "\$items = \$db->loadObjectList();";
					// set after items php
					if (isset($view->add_php_after_getitems) && $view->add_php_after_getitems == 1 && isset($view->php_after_getitems) && ComponentbuilderHelper::checkString($view->php_after_getitems))
					{
						$main .= $this->setPlaceholders($view->php_after_getitems, $this->placeholders);
					}
					$main .= PHP_EOL . PHP_EOL . $this->_t(2) . "if (empty(\$items))";
					$main .= PHP_EOL . $this->_t(2) . "{";
					$main .= PHP_EOL . $this->_t(3) . "return false;";
					$main .= PHP_EOL . $this->_t(2) . "}";
					// SITE_GET_ITEMS <<<DYNAMIC>>>
					$main .= $this->setCustomViewGetItems($view, $view->code);
					$main .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " return items";
					$main .= PHP_EOL . $this->_t(2) . "return \$items;";
					$type = 'mixed  An array of objects on success, false on failure.';
				}
				// load the main mehtod
				$methods .= $this->setMainCustomMehtod($main, $view->getcustom, $type);
				// SITE_CUSTOM_METHODS <<<DYNAMIC>>>
				$methods .= $this->setCustomViewCustomItemMethods($view, $view->code);
			}
		}
		// load uikit get method
		if (ComponentbuilderHelper::checkArray($main_view) && isset($main_view['settings']))
		{
			$methods .= $this->setUikitGetMethod();
		}

		return $methods;
	}

	public function setUikitHelperMethods()
	{
		// only load for uikit version 2
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			// build uikit get method
			$ukit = array();
			$ukit[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$ukit[] = $this->_t(1) . " *  UIKIT Component Classes";
			$ukit[] = $this->_t(1) . " **/";
			$ukit[] = $this->_t(1) . "public static \$uk_components = array(";
			$ukit[] = $this->_t(3) . "'data-uk-grid' => array(";
			$ukit[] = $this->_t(4) . "'grid' ),";
			$ukit[] = $this->_t(3) . "'uk-accordion' => array(";
			$ukit[] = $this->_t(4) . "'accordion' ),";
			$ukit[] = $this->_t(3) . "'uk-autocomplete' => array(";
			$ukit[] = $this->_t(4) . "'autocomplete' ),";
			$ukit[] = $this->_t(3) . "'data-uk-datepicker' => array(";
			$ukit[] = $this->_t(4) . "'datepicker' ),";
			$ukit[] = $this->_t(3) . "'uk-form-password' => array(";
			$ukit[] = $this->_t(4) . "'form-password' ),";
			$ukit[] = $this->_t(3) . "'uk-form-select' => array(";
			$ukit[] = $this->_t(4) . "'form-select' ),";
			$ukit[] = $this->_t(3) . "'data-uk-htmleditor' => array(";
			$ukit[] = $this->_t(4) . "'htmleditor' ),";
			$ukit[] = $this->_t(3) . "'data-uk-lightbox' => array(";
			$ukit[] = $this->_t(4) . "'lightbox' ),";
			$ukit[] = $this->_t(3) . "'uk-nestable' => array(";
			$ukit[] = $this->_t(4) . "'nestable' ),";
			$ukit[] = $this->_t(3) . "'UIkit.notify' => array(";
			$ukit[] = $this->_t(4) . "'notify' ),";
			$ukit[] = $this->_t(3) . "'data-uk-parallax' => array(";
			$ukit[] = $this->_t(4) . "'parallax' ),";
			$ukit[] = $this->_t(3) . "'uk-search' => array(";
			$ukit[] = $this->_t(4) . "'search' ),";
			$ukit[] = $this->_t(3) . "'uk-slider' => array(";
			$ukit[] = $this->_t(4) . "'slider' ),";
			$ukit[] = $this->_t(3) . "'uk-slideset' => array(";
			$ukit[] = $this->_t(4) . "'slideset' ),";
			$ukit[] = $this->_t(3) . "'uk-slideshow' => array(";
			$ukit[] = $this->_t(4) . "'slideshow',";
			$ukit[] = $this->_t(4) . "'slideshow-fx' ),";
			$ukit[] = $this->_t(3) . "'uk-sortable' => array(";
			$ukit[] = $this->_t(4) . "'sortable' ),";
			$ukit[] = $this->_t(3) . "'data-uk-sticky' => array(";
			$ukit[] = $this->_t(4) . "'sticky' ),";
			$ukit[] = $this->_t(3) . "'data-uk-timepicker' => array(";
			$ukit[] = $this->_t(4) . "'timepicker' ),";
			$ukit[] = $this->_t(3) . "'data-uk-tooltip' => array(";
			$ukit[] = $this->_t(4) . "'tooltip' ),";
			$ukit[] = $this->_t(3) . "'uk-placeholder' => array(";
			$ukit[] = $this->_t(4) . "'placeholder' ),";
			$ukit[] = $this->_t(3) . "'uk-dotnav' => array(";
			$ukit[] = $this->_t(4) . "'dotnav' ),";
			$ukit[] = $this->_t(3) . "'uk-slidenav' => array(";
			$ukit[] = $this->_t(4) . "'slidenav' ),";
			$ukit[] = $this->_t(3) . "'uk-form' => array(";
			$ukit[] = $this->_t(4) . "'form-advanced' ),";
			$ukit[] = $this->_t(3) . "'uk-progress' => array(";
			$ukit[] = $this->_t(4) . "'progress' ),";
			$ukit[] = $this->_t(3) . "'upload-drop' => array(";
			$ukit[] = $this->_t(4) . "'upload', 'form-file' )";
			$ukit[] = $this->_t(3) . ");";
			$ukit[] = PHP_EOL . $this->_t(1) . "/**";
			$ukit[] = $this->_t(1) . " *  Add UIKIT Components";
			$ukit[] = $this->_t(1) . " **/";
			$ukit[] = $this->_t(1) . "public static \$uikit = false;";
			$ukit[] = "";
			$ukit[] = $this->_t(1) . "/**";
			$ukit[] = $this->_t(1) . " *  Get UIKIT Components";
			$ukit[] = $this->_t(1) . " **/";
			$ukit[] = $this->_t(1) . "public static function getUikitComp(\$content,\$classes = array())";
			$ukit[] = $this->_t(1) . "{";
			$ukit[] = $this->_t(2) . "if (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = $this->_t(2) . "{";
			$ukit[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " reset";
			$ukit[] = $this->_t(3) . "\$temp = array();";
			$ukit[] = $this->_t(3) . "foreach (self::\$uk_components as \$looking => \$add)";
			$ukit[] = $this->_t(3) . "{";
			$ukit[] = $this->_t(4) . "if (strpos(\$content,\$looking) !== false)";
			$ukit[] = $this->_t(4) . "{";
			$ukit[] = $this->_t(5) . "\$temp[] = \$looking;";
			$ukit[] = $this->_t(4) . "}";
			$ukit[] = $this->_t(3) . "}";
			$ukit[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " make sure uikit is loaded to config";
			$ukit[] = $this->_t(3) . "if (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = $this->_t(3) . "{";
			$ukit[] = $this->_t(4) . "self::\$uikit = true;";
			$ukit[] = $this->_t(3) . "}";
			$ukit[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " sorter";
			$ukit[] = $this->_t(3) . "if (self::checkArray(\$temp))";
			$ukit[] = $this->_t(3) . "{";
			$ukit[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " merger";
			$ukit[] = $this->_t(4) . "if (self::checkArray(\$classes))";
			$ukit[] = $this->_t(4) . "{";
			$ukit[] = $this->_t(5) . "\$newTemp = array_merge(\$temp,\$classes);";
			$ukit[] = $this->_t(5) . "\$temp = array_unique(\$newTemp);";
			$ukit[] = $this->_t(4) . "}";
			$ukit[] = $this->_t(4) . "return \$temp;";
			$ukit[] = $this->_t(3) . "}";
			$ukit[] = $this->_t(2) . "}";
			$ukit[] = $this->_t(2) . "if (self::checkArray(\$classes))";
			$ukit[] = $this->_t(2) . "{";
			$ukit[] = $this->_t(3) . "return \$classes;";
			$ukit[] = $this->_t(2) . "}";
			$ukit[] = $this->_t(2) . "return false;";
			$ukit[] = $this->_t(1) . "}";

			// return the help methods
			return implode(PHP_EOL, $ukit);
		}
		return '';
	}

	public function setUikitGetMethod()
	{
		$method = '';
		// only load for uikit version 2
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			// build uikit get method
			$method .= PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$method .= PHP_EOL . $this->_t(1) . " * Get the uikit needed components";
			$method .= PHP_EOL . $this->_t(1) . " *";
			$method .= PHP_EOL . $this->_t(1) . " * @return mixed  An array of objects on success.";
			$method .= PHP_EOL . $this->_t(1) . " *";
			$method .= PHP_EOL . $this->_t(1) . " */";
			$method .= PHP_EOL . $this->_t(1) . "public function getUikitComp()";
			$method .= PHP_EOL . $this->_t(1) . "{";
			$method .= PHP_EOL . $this->_t(2) . "if (isset(\$this->uikitComp) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$this->uikitComp))";
			$method .= PHP_EOL . $this->_t(2) . "{";
			$method .= PHP_EOL . $this->_t(3) . "return \$this->uikitComp;";
			$method .= PHP_EOL . $this->_t(2) . "}";
			$method .= PHP_EOL . $this->_t(2) . "return false;";
			$method .= PHP_EOL . $this->_t(1) . "}";
		}
		return $method;
	}

	public function setMainCustomMehtod(&$body, $nAme, $type)
	{
		$method = '';
		if (ComponentbuilderHelper::checkString($body))
		{
			// build custom method
			$method .= PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$method .= PHP_EOL . $this->_t(1) . " * Custom Method";
			$method .= PHP_EOL . $this->_t(1) . " *";
			$method .= PHP_EOL . $this->_t(1) . " * @return " . $type;
			$method .= PHP_EOL . $this->_t(1) . " *";
			$method .= PHP_EOL . $this->_t(1) . " */";
			$method .= PHP_EOL . $this->_t(1) . "public function " . $nAme . "()";
			$method .= PHP_EOL . $this->_t(1) . "{" . $body;
			$method .= PHP_EOL . $this->_t(1) . "}";
		}
		return $method;
	}

	public function setCustomViewCustomItemMethods(&$main_get, $code)
	{
		$methods = '';
		$this->JEventDispatcher = '';
		// first set the needed item/s methods
		if (ComponentbuilderHelper::checkObject($main_get))
		{
			if (isset($main_get->custom_get) && ComponentbuilderHelper::checkArray($main_get->custom_get))
			{
				foreach ($main_get->custom_get as $get)
				{
					// set the site decription switch
					foreach ($this->cryptionTypes as $cryptionType)
					{
						$this->siteDecrypt[$cryptionType][$code] = false;
					}
					// set the method defaults
					if (($default = $this->setCustomViewMethodDefaults($get, $code)) !== false)
					{
						// build custom method
						$methods .= PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
						$methods .= PHP_EOL . $this->_t(1) . " * Method to get an array of " . $default['name'] . " Objects.";
						$methods .= PHP_EOL . $this->_t(1) . " *";
						$methods .= PHP_EOL . $this->_t(1) . " * @return mixed  An array of " . $default['name'] . " Objects on success, false on failure.";
						$methods .= PHP_EOL . $this->_t(1) . " *";
						$methods .= PHP_EOL . $this->_t(1) . " */";
						$methods .= PHP_EOL . $this->_t(1) . "public function get" . $default['methodName'] . "(\$" . $default['on_field'] . ")";
						$methods .= PHP_EOL . $this->_t(1) . "{" . $this->hhh . "CRYPT" . $this->hhh;
						$methods .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get a db connection.";
						$methods .= PHP_EOL . $this->_t(2) . "\$db = JFactory::getDbo();";
						$methods .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
						$methods .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
						$methods .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get from " . $get['selection']['table'] . " as " . $default['as'];
						$methods .= PHP_EOL . $this->_t(2) . $get['selection']['select'];
						$methods .= PHP_EOL . $this->_t(2) . '$query->from(' . $get['selection']['from'] . ');';
						// set the string
						if ($get['operator'] === 'IN' || $get['operator'] === 'NOT IN')
						{
							$methods .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check if \$" . $default['on_field'] . " is an array with values.";
							$methods .= PHP_EOL . $this->_t(2) . "\$array = \$" . $default['on_field'] . ";";
							$methods .= PHP_EOL . $this->_t(2) . "if (isset(\$array) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$array, true))";
							$methods .= PHP_EOL . $this->_t(2) . "{";
							$methods .= PHP_EOL . $this->_t(3) . "\$query->where('" . $get['join_field'] . " " . $get['operator'] . " (' . implode(',', \$array) . ')');";
							$methods .= PHP_EOL . $this->_t(2) . "}";
							$methods .= PHP_EOL . $this->_t(2) . "else";
							$methods .= PHP_EOL . $this->_t(2) . "{";
							$methods .= PHP_EOL . $this->_t(3) . "return false;";
							$methods .= PHP_EOL . $this->_t(2) . "}";
						}
						else
						{
							$methods .= PHP_EOL . $this->_t(2) . "\$query->where('" . $get['join_field'] . " " . $get['operator'] . " ' . \$db->quote(\$" . $default['on_field'] . "));";
						}
						// check if other queries should be loaded
						$queryChecker = (isset($this->otherQuery[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherQuery[$this->target][$default['code']][$default['as']])) ? $this->otherQuery[$this->target][$default['code']][$default['as']] : '';
						if (ComponentbuilderHelper::checkArray($queryChecker))
						{
							foreach ($queryChecker as $query)
							{
								$methods .= $query;
							}
						}
						// add any other filter that was set
						if (isset($this->otherFilter[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherFilter[$this->target][$default['code']][$default['as']]))
						{
							foreach ($this->otherFilter[$this->target][$default['code']][$default['as']] as $field => $string)
							{
								$methods .= $string;
							}
						}
						// add any other where that was set
						if (isset($this->otherWhere[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherWhere[$this->target][$default['code']][$default['as']]))
						{
							foreach ($this->otherWhere[$this->target][$default['code']][$default['as']] as $field => $string)
							{
								$methods .= $string;
							}
						}
						// add any other order that was set
						if (isset($this->otherOrder[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherOrder[$this->target][$default['code']][$default['as']]))
						{
							foreach ($this->otherOrder[$this->target][$default['code']][$default['as']] as $field => $string)
							{
								$methods .= $string;
							}
						}
						// add any other grouping that was set
						if (isset($this->otherGroup[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherGroup[$this->target][$default['code']][$default['as']]))
						{
							foreach ($this->otherGroup[$this->target][$default['code']][$default['as']] as $field => $string)
							{
								$methods .= $string;
							}
						}
						$methods .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Reset the query using our newly populated query object.";
						$methods .= PHP_EOL . $this->_t(2) . "\$db->setQuery(\$query);";
						$methods .= PHP_EOL . $this->_t(2) . "\$db->execute();";
						$methods .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if there was data returned";
						$methods .= PHP_EOL . $this->_t(2) . "if (\$db->getNumRows())";
						$methods .= PHP_EOL . $this->_t(2) . "{";
						// set dispatcher placeholder
						$methods .= $this->hhh . "DISPATCHER" . $this->hhh;
						// set decoding of needed fields
						if (isset($this->siteFieldData['decode'][$default['code']][$get['key']][$default['as']]))
						{
							$decodeChecker = $this->siteFieldData['decode'][$default['code']][$get['key']][$default['as']];
						}
						// also filter fields if needed
						if (isset($this->siteFieldDecodeFilter[$this->target][$default['code']][$get['key']][$default['as']]))
						{
							$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$default['code']][$get['key']][$default['as']];
						}
						// set uikit checkers on needed fields
						if (isset($this->siteFieldData['uikit'][$default['code']][$get['key']][$default['as']]))
						{
							$uikitChecker = $this->siteFieldData['uikit'][$default['code']][$get['key']][$default['as']];
						}
						// set contnetprepare on needed fields
						if (isset($this->siteFieldData['textareas'][$default['code']][$get['key']][$default['as']]))
						{
							$contentprepareChecker = $this->siteFieldData['textareas'][$default['code']][$get['key']][$default['as']];
						}
						// set joined values
						$placeholders = array($this->hhh . 'TAB' . $this->hhh => $this->_t(2), $this->hhh . 'STRING' . $this->hhh => '$item');
						$joinedChecker = (isset($this->otherJoin[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherJoin[$this->target][$default['code']][$default['as']])) ? $this->otherJoin[$this->target][$default['code']][$default['as']] : '';
						if ((isset($decodeChecker) && ComponentbuilderHelper::checkArray($decodeChecker)) ||
							(isset($uikitChecker) && ComponentbuilderHelper::checkArray($uikitChecker)) ||
							(isset($decodeFilter) && ComponentbuilderHelper::checkArray($decodeFilter)) ||
							(isset($contentprepareChecker) && ComponentbuilderHelper::checkArray($contentprepareChecker)) ||
							ComponentbuilderHelper::checkArray($joinedChecker))
						{
							$decoder = '';
							if (isset($decodeChecker) && ComponentbuilderHelper::checkArray($decodeChecker))
							{
								// also filter fields if needed
								$decoder = $this->setCustomViewFieldDecode($get, $decodeChecker, '$item', $default['code'], $this->_t(2));
							}
							$decoder_filter = '';
							if (isset($decodeFilter) && ComponentbuilderHelper::checkArray($decodeFilter))
							{
								$decoder_filter = $this->setCustomViewFieldDecodeFilter($get, $decodeFilter, '$item', '$items[$nr]', $default['code'], $this->_t(2));
							}
							$contentprepare = '';
							if (isset($contentprepareChecker) && ComponentbuilderHelper::checkArray($contentprepareChecker))
							{
								$contentprepare = $this->setCustomViewFieldonContentPrepareChecker($get, $contentprepareChecker, '$item', $default['code'], $this->_t(2));
							}
							$uikit = '';
							if (isset($uikitChecker) && ComponentbuilderHelper::checkArray($uikitChecker))
							{
								$uikit = $this->setCustomViewFieldUikitChecker($get, $uikitChecker, '$item', $default['code'], $this->_t(2));
							}
							$joine = '';
							if (ComponentbuilderHelper::checkArray($joinedChecker))
							{
								foreach ($joinedChecker as $joinedString)
								{
									$joine .= $this->setPlaceholders($joinedString, $placeholders);
								}
							}
							if (ComponentbuilderHelper::checkString($decoder) || ComponentbuilderHelper::checkString($contentprepare) || ComponentbuilderHelper::checkString($uikit) || ComponentbuilderHelper::checkString($decoder_filter) || ComponentbuilderHelper::checkString($joine))
							{
								$methods .= PHP_EOL . $this->_t(3) . "\$items = \$db->loadObjectList();";
								$methods .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Convert the parameter fields into objects.";
								$methods .= PHP_EOL . $this->_t(3) . "foreach (\$items as \$nr => &\$item)";
								$methods .= PHP_EOL . $this->_t(3) . "{";
								if (ComponentbuilderHelper::checkString($decoder))
								{
									$methods .= $decoder;
								}
								if (ComponentbuilderHelper::checkString($decoder_filter))
								{
									$methods .= $decoder_filter;
								}
								if (ComponentbuilderHelper::checkString($contentprepare))
								{
									$methods .= $contentprepare;
								}
								if (ComponentbuilderHelper::checkString($uikit))
								{
									$methods .= $uikit;
								}
								if (ComponentbuilderHelper::checkString($joine))
								{
									$methods .= $joine;
								}
								$methods .= PHP_EOL . $this->_t(3) . "}";
								$methods .= PHP_EOL . $this->_t(3) . "return \$items;";
							}
							else
							{
								$methods .= PHP_EOL . $this->_t(3) . "return \$db->loadObjectList();";
							}
						}
						else
						{
							$methods .= PHP_EOL . $this->_t(3) . "return \$db->loadObjectList();";
						}
						$methods .= PHP_EOL . $this->_t(2) . "}";
						$methods .= PHP_EOL . $this->_t(2) . "return false;";
						$methods .= PHP_EOL . $this->_t(1) . "}";

						// set the script if it was found
						$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
						$script = '';
						foreach ($this->cryptionTypes as $cryptionType)
						{
							if (isset($this->siteDecrypt[$cryptionType][$code]) && $this->siteDecrypt[$cryptionType][$code])
							{
								if ('expert' !== $cryptionType)
								{
									$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the " . $cryptionType . " encryption.";
									$script .= PHP_EOL . $this->_t(2) . "\$" . $cryptionType . "key = " . $Component . "Helper::getCryptKey('" . $cryptionType . "');";
									$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the encryption object.";
									$script .= PHP_EOL . $this->_t(2) . "\$" . $cryptionType . " = new FOFEncryptAes(\$" . $cryptionType . "key);" . PHP_EOL;
								}
								elseif (isset($this->{$cryptionType . 'FieldModelInitiator'}[$code]) 
									&& isset($this->{$cryptionType . 'FieldModelInitiator'}[$code]['get']))
								{
									foreach ($this->{$cryptionType . 'FieldModelInitiator'}[$code]['get'] as $block)
									{
										$script .= PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $block);
									}
								}
							}
						}
						$methods = str_replace($this->hhh . 'CRYPT' . $this->hhh, $script, $methods);
					}
				}
				// insure the crypt placeholder is removed
				if (ComponentbuilderHelper::checkString($methods))
				{
					$methods = str_replace($this->hhh . 'CRYPT' . $this->hhh, '', $methods);
				}
			}
		}
		// only update if dispacher placholder is found
		if (strpos($methods, $this->hhh . 'DISPATCHER' . $this->hhh) !== false)
		{
			// check if the dispather should be added
			if (!isset($this->JEventDispatcher) || !ComponentbuilderHelper::checkArray($this->JEventDispatcher))
			{
				$this->JEventDispatcher = array($this->hhh . 'DISPATCHER' . $this->hhh => '');
			}
			$methods = str_replace(array_keys($this->JEventDispatcher), array_values($this->JEventDispatcher), $methods);
		}
		// insure the crypt placeholder is removed
		if (ComponentbuilderHelper::checkString($methods))
		{
			return $methods . PHP_EOL;
		}
		return '';
	}

	public function setCustomViewMethodDefaults($get, $code)
	{
		if (isset($get['key']) && isset($get['as']))
		{
			$key = substr(ComponentbuilderHelper::safeString(preg_replace('/[0-9]+/', '', md5($get['key'])), 'F'), 0, 4);
			$method['on_field'] = (isset($get['on_field'])) ? $this->removeAsDot($get['on_field']) : null;
			$method['join_field'] = (isset($get['join_field'])) ? ComponentbuilderHelper::safeString($this->removeAsDot($get['join_field'])) : null;
			$method['Join_field'] = (isset($method['join_field'])) ? ComponentbuilderHelper::safeString($method['join_field'], 'F') : null;
			$method['name'] = ComponentbuilderHelper::safeString($get['selection']['name'], 'F');
			$method['code'] = ComponentbuilderHelper::safeString($code);
			$method['AS'] = ComponentbuilderHelper::safeString($get['as'], 'U');
			$method['as'] = ComponentbuilderHelper::safeString($get['as']);
			$method['valueName'] = $method['on_field'] . $method['Join_field'] . $method['name'] . $method['AS'];
			$method['methodName'] = ComponentbuilderHelper::safeString($method['on_field'], 'F') . $method['Join_field'] . $method['name'] . $key . '_' . $method['AS'];
			// return
			return $method;
		}
		return false;
	}

	/**
	 * get the a script from the custom script builder
	 *
	 * @param   string       $first        The first key
	 * @param   string       $second       The second key
	 * @param   string       $prefix       The prefix to add in front of the script if found
	 * @param   string/bool  $note         The switch/note to add to the script
	 * @param   bool         $unset        The switch to unset the value if found
	 * @param   string/bool  $default      The switch/string to use as default return if script not found
	 * @param   string       $sufix        The sufix  to add after the script if found
	 *
	 * @return  mix    The string/script if found or the default value if not found
	 *
	 */
	public function getCustomScriptBuilder($first, $second, $prefix = '', $note = null, $unset = null, $default = null, $sufix = '')
	{
		// default is to return an empty string
		$script = '';
		// check if there is any custom script
		if (isset($this->customScriptBuilder[$first][$second]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$first][$second]))
		{
			// add not if set
			if ($note)
			{
				$script .= $note;
			}
			// load the actual script
			$script .= $prefix . str_replace(array_keys($this->placeholders), array_values($this->placeholders), $this->customScriptBuilder[$first][$second]) . $sufix;
			// clear some memory
			if ($unset)
			{
				unset($this->customScriptBuilder[$first][$second]);
			}
		}
		// if not found return default
		if (!ComponentbuilderHelper::checkString($script) && $default)
		{
			return $default;
		}
		return $script;
	}

	public function setCustomViewListQuery(&$get, $code, $return = true)
	{
		if (ComponentbuilderHelper::checkObject($get))
		{
			if ($get->pagination == 1)
			{
				$getItem = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get a db connection.";
			}
			else
			{
				$getItem = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Make sure all records load, since no pagination allowed.";
				$getItem .= PHP_EOL . $this->_t(2) . "\$this->setState('list.limit', 0);";
				$getItem .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get a db connection.";
			}
			$getItem .= PHP_EOL . $this->_t(2) . "\$db = JFactory::getDbo();";
			$getItem .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
			$getItem .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get, $code);
			// check if there is any custom script
			$getItem .= $this->getCustomScriptBuilder($this->target . '_php_getlistquery', $code, '', PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filtering.", true);
			// setup filters
			if (isset($get->filter))
			{
				$getItem .= $this->setCustomViewFilter($get->filter, $code);
			}
			// setup where
			if (isset($get->where))
			{
				$getItem .= $this->setCustomViewWhere($get->where, $code);
			}
			// setup ordering
			if (isset($get->order))
			{
				$getItem .= $this->setCustomViewOrder($get->order, $code);
			}
			// setup grouping
			if (isset($get->group))
			{
				$getItem .= $this->setCustomViewGroup($get->group, $code);
			}
			if ($return)
			{
				// return the query object
				$getItem .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " return the query object" . PHP_EOL . $this->_t(2) . "return \$query;";
			}

			return $getItem;
		}
		return PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . "add your custom code here.";
	}

	/**
	 * @param $get
	 * @param $code
	 * @return string
	 */
	public function setCustomViewGetItems(&$get, $code)
	{
		$getItem = '';
		// set the site decrypt switch
		foreach ($this->cryptionTypes as $cryptionType)
		{
			$this->siteDecrypt[$cryptionType][$code] = false;
		}
		// set the component name
		$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
		// start load the get item
		if (ComponentbuilderHelper::checkObject($get))
		{
			$getItem .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Insure all item fields are adapted where needed.";
			$getItem .= PHP_EOL . $this->_t(2) . "if (" . $Component . "Helper::checkArray(\$items))";
			$getItem .= PHP_EOL . $this->_t(2) . "{";
			$getItem .= $this->hhh . "DISPATCHER" . $this->hhh;
			$getItem .= PHP_EOL . $this->_t(3) . "foreach (\$items as \$nr => &\$item)";
			$getItem .= PHP_EOL . $this->_t(3) . "{";
			$getItem .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Always create a slug for sef URL's";
			$getItem .= PHP_EOL . $this->_t(4) . "\$item->slug = (isset(\$item->alias) && isset(\$item->id)) ? \$item->id.':'.\$item->alias : \$item->id;";
			if (isset($get->main_get) && ComponentbuilderHelper::checkArray($get->main_get))
			{
				$asBucket = array();
				foreach ($get->main_get as $main_get)
				{
					if (isset($this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeChecker = $this->siteFieldData['decode'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeChecker))
						{
							// set decoding of needed fields
							$getItem .= $this->setCustomViewFieldDecode($main_get, $decodeChecker, "\$item", $code, $this->_t(2));
						}
					}
					// also filter fields if needed
					if (isset($this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeFilter))
						{
							$getItem .= $this->setCustomViewFieldDecodeFilter($main_get, $decodeFilter, "\$item", '$items[$nr]', $code, $this->_t(2));
						}
					}
					if (isset($this->siteFieldData['textareas'][$code][$main_get['key']][$main_get['as']]))
					{
						$contentprepareChecker = $this->siteFieldData['textareas'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($contentprepareChecker))
						{
							// set contentprepare checkers on needed fields
							$getItem .= $this->setCustomViewFieldonContentPrepareChecker($main_get, $contentprepareChecker, "\$item", $code, $this->_t(2));
						}
					}
					if (isset($this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']]))
					{
						$uikitChecker = $this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($uikitChecker))
						{
							// set uikit checkers on needed fields
							$getItem .= $this->setCustomViewFieldUikitChecker($main_get, $uikitChecker, "\$item", $code, $this->_t(2));
						}
					}
					$asBucket[] = $main_get['as'];
				}
			}
			// only update if dispacher placholder is found
			if (strpos($getItem, $this->hhh . 'DISPATCHER' . $this->hhh) !== false)
			{
				// check if the dispather should be added
				if (!isset($this->JEventDispatcher) || !ComponentbuilderHelper::checkArray($this->JEventDispatcher))
				{
					$this->JEventDispatcher = array($this->hhh . 'DISPATCHER' . $this->hhh => '');
				}
				$getItem = str_replace(array_keys($this->JEventDispatcher), array_values($this->JEventDispatcher), $getItem);
			}
			// setup Globals
			$getItem .= $this->setCustomViewGlobals($get->global, '$item', $asBucket, $this->_t(2));
			// setup the custom gets that returns multipal values
			$getItem .= $this->setCustomViewCustomJoin($get->custom_get, "\$item", $code, $asBucket, $this->_t(2));
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode(PHP_EOL, $get->php_calculation);
				if (ComponentbuilderHelper::checkArray($get->php_calculation))
				{
					$_tmp = PHP_EOL . $this->_t(4) . implode(PHP_EOL . $this->_t(4), $get->php_calculation);
					$getItem .= $this->setPlaceholders($_tmp, $this->placeholders);
				}
			}
			$getItem .= PHP_EOL . $this->_t(3) . "}";
			$getItem .= PHP_EOL . $this->_t(2) . "}";
			// remove empty foreach
			if (strlen($getItem) <= 100)
			{
				$getItem = PHP_EOL;
			}
		}

		// set the script if found
		$script = '';
		foreach ($this->cryptionTypes as $cryptionType)
		{
			if ($this->siteDecrypt[$cryptionType][$code])
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the " . $cryptionType . " encryption.";
					$script .= PHP_EOL . $this->_t(2) . "\$" . $cryptionType . "key = " . $Component . "Helper::getCryptKey('" . $cryptionType . "');";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the encryption object.";
					$script .= PHP_EOL . $this->_t(2) . "\$" . $cryptionType . " = new FOFEncryptAes(\$" . $cryptionType . "key);";
				}
				elseif (isset($this->{$cryptionType . 'FieldModelInitiator'}[$code]) 
					&& isset($this->{$cryptionType . 'FieldModelInitiator'}[$code]['get']))
				{
					foreach ($this->{$cryptionType . 'FieldModelInitiator'}[$code]['get'] as $block)
					{
						$script .= PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $block);
					}
				}
			}
		}
		return $script . $getItem;
	}

	public function setCustomViewDisplayMethod(&$view)
	{
		$method = '';
		if (isset($view['settings']->main_get) && ComponentbuilderHelper::checkObject($view['settings']->main_get))
		{
			
			// add events if needed
			if ($view['settings']->main_get->gettype == 1 && ComponentbuilderHelper::checkArray($view['settings']->main_get->plugin_events))
			{
				// load the dispatcher
				$method .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Initialise dispatcher.";
				$method .= PHP_EOL . $this->_t(2) . "\$dispatcher = JEventDispatcher::getInstance();";
			}
			if ($view['settings']->main_get->gettype == 1)
			{
				// for single views
				$method .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Initialise variables.";
				$method .= PHP_EOL . $this->_t(2) . "\$this->item = \$this->get('Item');";
			}
			elseif ($view['settings']->main_get->gettype == 2)
			{
				// for list views
				$method .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Initialise variables.";
				$method .= PHP_EOL . $this->_t(2) . "\$this->items = \$this->get('Items');";
				// only add if pagination is requered
				if ($view['settings']->main_get->pagination == 1)
				{
					$method .= PHP_EOL . $this->_t(2) . "\$this->pagination = \$this->get('Pagination');";
				}
				// add id to list view
				if (isset($this->customAdminViewListId[$view['settings']->code]))
				{
					// HIDDEN_INPUT_VALUES
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'HIDDEN_INPUT_VALUES' . $this->hhh] = PHP_EOL . $this->_t(1) . '<input type="hidden" name="id" value="<?php echo $this->app->input->getInt(\'id\', 0); ?>" />';
				}
				else
				{
					// also set the input value HIDDEN_INPUT_VALUES
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'HIDDEN_INPUT_VALUES' . $this->hhh] = '';
				}
			}
			// add the custom get methods
			if (isset($view['settings']->custom_get) && ComponentbuilderHelper::checkArray($view['settings']->custom_get))
			{
				foreach ($view['settings']->custom_get as $custom_get)
				{
					$custom_get_name = str_replace('get', '', $custom_get->getcustom);
					$method .= PHP_EOL . $this->_t(2) . "\$this->" . ComponentbuilderHelper::safeString($custom_get_name) . " = \$this->get('" . $custom_get_name . "');";
				}
			}
			// add custom script
			if ($view['settings']->add_php_jview_display == 1)
			{
				$view['settings']->php_jview_display = (array) explode(PHP_EOL, $view['settings']->php_jview_display);
				if (ComponentbuilderHelper::checkArray($view['settings']->php_jview_display))
				{
					$_tmp = PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $view['settings']->php_jview_display);
					$method .= $this->setPlaceholders($_tmp, $this->placeholders);
				}
			}
			if ('site' === $this->target)
			{
				$method .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the toolbar";
				$method .= PHP_EOL . $this->_t(2) . "\$this->addToolBar();";
				$method .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " set the document";
				$method .= PHP_EOL . $this->_t(2) . "\$this->_prepareDocument();";
			}
			elseif ('custom_admin' === $this->target)
			{
				$method .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " We don't need toolbar in the modal window.";
				$method .= PHP_EOL . $this->_t(2) . "if (\$this->getLayout() !== 'modal')";
				$method .= PHP_EOL . $this->_t(2) . "{";
				$method .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " add the tool bar";
				$method .= PHP_EOL . $this->_t(3) . "\$this->addToolBar();";
				$method .= PHP_EOL . $this->_t(2) . "}";
				$method .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " set the document";
				$method .= PHP_EOL . $this->_t(2) . "\$this->setDocument();";
			}

			$method .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check for errors.";
			$method .= PHP_EOL . $this->_t(2) . "if (count(\$errors = \$this->get('Errors')))";
			$method .= PHP_EOL . $this->_t(2) . "{";
			$method .= PHP_EOL . $this->_t(3) . "throw new Exception(implode(PHP_EOL, \$errors), 500);";
			$method .= PHP_EOL . $this->_t(2) . "}";
			// add events if needed
			if ($view['settings']->main_get->gettype == 1 && ComponentbuilderHelper::checkArray($view['settings']->main_get->plugin_events))
			{
				$method .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Process the content plugins.";
				$method .= PHP_EOL . $this->_t(2) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkObject(\$this->item))";
				$method .= PHP_EOL . $this->_t(2) . "{";
				$method .= PHP_EOL . $this->_t(3) . "JPluginHelper::importPlugin('content');";
				$method .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Setup Event Object.";
				$method .= PHP_EOL . $this->_t(3) . "\$this->item->event = new stdClass;";
				$method .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Check if item has params, or pass global params";
				$method .= PHP_EOL . $this->_t(3) . "\$params = (isset(\$this->item->params) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkJson(\$this->item->params)) ? json_decode(\$this->item->params) : \$this->params;";
				// load the defaults
				foreach ($view['settings']->main_get->plugin_events as $plugin_event)
				{
					// load the events
					if ('onContentPrepare' === $plugin_event)
					{
						// TODO the onContentPrepare already gets triggered on the fields of its relation
						// $method .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " onContentPrepare Event Trigger.";
						// $method .= PHP_EOL . $this->_t(2) . "\$dispatcher->trigger('onContentPrepare', array ('com_" . $this->componentCodeName . ".article', &\$this->item, &\$this->params, 0));";
					}
					else
					{
						$method .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " " . $plugin_event . " Event Trigger.";
						$method .= PHP_EOL . $this->_t(3) . "\$results = \$dispatcher->trigger('" . $plugin_event . "', array('com_" . $this->componentCodeName . "." . $view['settings']->context . "', &\$this->item, &\$params, 0));";
						$method .= PHP_EOL . $this->_t(3) . '$this->item->event->' . $plugin_event . ' = trim(implode("\n", $results));';
					}
				}
				$method .= PHP_EOL . $this->_t(2) . "}";
			}
			$method .= PHP_EOL . PHP_EOL . $this->_t(2) . "parent::display(\$tpl);";
		}
		return $method;
	}

	public function setPrepareDocument(&$view)
	{
		// fix just incase we missed it somewhere
		$tmp = $this->lang;
		if ('site' === $this->target)
		{
			$this->lang = 'site';
		}
		else
		{
			$this->lang = 'admin';
		}

		// ensure correct target is set
		$TARGET = ComponentbuilderHelper::safeString($this->target, 'U');

		// set libraries $TARGET.'_LIBRARIES_LOADER
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_LIBRARIES_LOADER' . $this->hhh] = $this->setLibrariesLoader($view);

		// set uikit $TARGET.'_UIKIT_LOADER
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_UIKIT_LOADER' . $this->hhh] = $this->setUikitLoader($view);

		// set Google Charts $TARGET.'_GOOGLECHART_LOADER
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_GOOGLECHART_LOADER' . $this->hhh] = $this->setGoogleChartLoader($view);

		// set Footable FOOTABLE_LOADER
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_FOOTABLE_LOADER' . $this->hhh] = $this->setFootableScriptsLoader($view);

		// set metadata DOCUMENT_METADATA
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_DOCUMENT_METADATA' . $this->hhh] = $this->setDocumentMetadata($view);

		// set custom php scripting DOCUMENT_CUSTOM_PHP
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_DOCUMENT_CUSTOM_PHP' . $this->hhh] = $this->setDocumentCustomPHP($view);

		// set custom css DOCUMENT_CUSTOM_CSS
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_DOCUMENT_CUSTOM_CSS' . $this->hhh] = $this->setDocumentCustomCSS($view);

		// set custom javascript DOCUMENT_CUSTOM_JS
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_DOCUMENT_CUSTOM_JS' . $this->hhh] = $this->setDocumentCustomJS($view);

		// set custom css file VIEWCSS
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_VIEWCSS' . $this->hhh] = $this->setCustomCSS($view);

		// incase no buttons are found
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_JAVASCRIPT_FOR_BUTTONS' . $this->hhh] = '';

		// set the custom buttons CUSTOM_BUTTONS
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_CUSTOM_BUTTONS' . $this->hhh] = $this->setCustomButtons($view);

		// see if we should add get modules to the view.html
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_GET_MODULE' . $this->hhh] = $this->setGetModules($view, $TARGET);

		// set a JavaScript file if needed
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_LIBRARIES_LOADER' . $this->hhh] .= $this->setJavaScriptFile($view, $TARGET);

		// fix just incase we missed it somewhere
		$this->lang = $tmp;
	}

	public function setGetModules($view, $TARGET)
	{
		if (isset($this->getModule[$this->target][$view['settings']->code]) && $this->getModule[$this->target][$view['settings']->code])
		{
			$addModule = array();
			$addModule[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$addModule[] = $this->_t(1) . " * Get the modules published in a position";
			$addModule[] = $this->_t(1) . " */";
			$addModule[] = $this->_t(1) . "public function getModules(\$position, \$seperator = '', \$class = '')";
			$addModule[] = $this->_t(1) . "{";
			$addModule[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " set default";
			$addModule[] = $this->_t(2) . "\$found = false;";
			$addModule[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if we aleady have these modules loaded";
			$addModule[] = $this->_t(2) . "if (isset(\$this->setModules[\$position]))";
			$addModule[] = $this->_t(2) . "{";
			$addModule[] = $this->_t(3) . "\$found = true;";
			$addModule[] = $this->_t(2) . "}";
			$addModule[] = $this->_t(2) . "else";
			$addModule[] = $this->_t(2) . "{";
			$addModule[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " this is where you want to load your module position";
			$addModule[] = $this->_t(3) . "\$modules = JModuleHelper::getModules(\$position);";
			$addModule[] = $this->_t(3) . "if (\$modules)";
			$addModule[] = $this->_t(3) . "{";
			$addModule[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " set the place holder";
			$addModule[] = $this->_t(4) . "\$this->setModules[\$position] = array();";
			$addModule[] = $this->_t(4) . "foreach(\$modules as \$module)";
			$addModule[] = $this->_t(4) . "{";
			$addModule[] = $this->_t(5) . "\$this->setModules[\$position][] = JModuleHelper::renderModule(\$module);";
			$addModule[] = $this->_t(4) . "}";
			$addModule[] = $this->_t(4) . "\$found = true;";
			$addModule[] = $this->_t(3) . "}";
			$addModule[] = $this->_t(2) . "}";
			$addModule[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if modules were found";
			$addModule[] = $this->_t(2) . "if (\$found && isset(\$this->setModules[\$position]) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$this->setModules[\$position]))";
			$addModule[] = $this->_t(2) . "{";
			$addModule[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " set class";
			$addModule[] = $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkString(\$class))";
			$addModule[] = $this->_t(3) . "{";
			$addModule[] = $this->_t(4) . "\$class = ' class=\"'.\$class.'\" ';";
			$addModule[] = $this->_t(3) . "}";
			$addModule[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " set seperating return values";
			$addModule[] = $this->_t(3) . "switch(\$seperator)";
			$addModule[] = $this->_t(3) . "{";
			$addModule[] = $this->_t(4) . "case 'none':";
			$addModule[] = $this->_t(5) . "return implode('', \$this->setModules[\$position]);";
			$addModule[] = $this->_t(5) . "break;";
			$addModule[] = $this->_t(4) . "case 'div':";
			$addModule[] = $this->_t(5) . "return '<div'.\$class.'>'.implode('</div><div'.\$class.'>', \$this->setModules[\$position]).'</div>';";
			$addModule[] = $this->_t(5) . "break;";
			$addModule[] = $this->_t(4) . "case 'list':";
			$addModule[] = $this->_t(5) . "return '<ul'.\$class.'><li>'.implode('</li><li>', \$this->setModules[\$position]).'</li></ul>';";
			$addModule[] = $this->_t(5) . "break;";
			$addModule[] = $this->_t(4) . "case 'array':";
			$addModule[] = $this->_t(4) . "case 'Array':";
			$addModule[] = $this->_t(5) . "return \$this->setModules[\$position];";
			$addModule[] = $this->_t(5) . "break;";
			$addModule[] = $this->_t(4) . "default:";
			$addModule[] = $this->_t(5) . "return implode('<br />', \$this->setModules[\$position]);";
			$addModule[] = $this->_t(5) . "break;";
			$addModule[] = $this->_t(4);
			$addModule[] = $this->_t(3) . "}";
			$addModule[] = $this->_t(2) . "}";
			$addModule[] = $this->_t(2) . "return false;";
			$addModule[] = $this->_t(1) . "}";

			$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_GET_MODULE_JIMPORT' . $this->hhh] = PHP_EOL . "jimport('joomla.application.module.helper');";

			return implode(PHP_EOL, $addModule);
		}
		$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_GET_MODULE_JIMPORT' . $this->hhh] = '';
		return '';
	}

	public function setDocumentCustomPHP(&$view)
	{
		if ($view['settings']->add_php_document == 1)
		{
			$view['settings']->php_document = (array) explode(PHP_EOL, $view['settings']->php_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->php_document))
			{
				$_tmp = PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $view['settings']->php_document);
				return $this->setPlaceholders($_tmp, $this->placeholders);
			}
		}
		return '';
	}

	public function setCustomButtons(&$view, $type = 1, $tab = '')
	{
		// do not validate selection
		$validateSelection = 'false';
		// ensure correct target is set
		$TARGET = ComponentbuilderHelper::safeString($this->target, 'U');
		if (1 == $type || 2 == $type)
		{
			if (1 == $type)
			{
				$viewName = $view['settings']->code;
			}
			if (2 == $type)
			{
				$viewName = ComponentbuilderHelper::safeString($view['settings']->name_single);
			}
			// set the custom buttons CUSTOM_BUTTONS_CONTROLLER
			$this->fileContentDynamic[$viewName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_CONTROLLER' . $this->hhh] = '';
			// set the custom buttons CUSTOM_BUTTONS_METHOD
			$this->fileContentDynamic[$viewName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_METHOD' . $this->hhh] = '';
		}
		elseif (3 == $type)
		{
			// set the names
			$viewName = ComponentbuilderHelper::safeString($view['settings']->name_single);
			$viewsName = ComponentbuilderHelper::safeString($view['settings']->name_list);
			// set the custom buttons CUSTOM_BUTTONS_CONTROLLER_LIST
			$this->fileContentDynamic[$viewsName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_CONTROLLER_LIST' . $this->hhh] = '';
			// set the custom buttons CUSTOM_BUTTONS_METHOD_LIST
			$this->fileContentDynamic[$viewsName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_METHOD_LIST' . $this->hhh] = '';
			// validate selection
			$validateSelection = 'true';
		}
		// if site add buttons to view
		if ($this->target === 'site')
		{
			// set the custom buttons SITE_TOP_BUTTON
			$this->fileContentDynamic[$viewName][$this->hhh . 'SITE_TOP_BUTTON' . $this->hhh] = '';
			// set the custom buttons SITE_BOTTOM_BUTTON
			$this->fileContentDynamic[$viewName][$this->hhh . 'SITE_BOTTOM_BUTTON' . $this->hhh] = '';
			// load into place
			switch ($view['settings']->button_position)
			{
				case 1:
					// set buttons to top right of the view
					$this->fileContentDynamic[$viewName][$this->hhh . 'SITE_TOP_BUTTON' . $this->hhh] = '<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>';
					break;
				case 2:
					// set buttons to top left of the view
					$this->fileContentDynamic[$viewName][$this->hhh . 'SITE_TOP_BUTTON' . $this->hhh] = '<?php echo $this->toolbar->render(); ?>';
					break;
				case 3:
					// set buttons to buttom right of the view
					$this->fileContentDynamic[$viewName][$this->hhh . 'SITE_BOTTOM_BUTTON' . $this->hhh] = '<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>';
					break;
				case 4:
					// set buttons to buttom left of the view
					$this->fileContentDynamic[$viewName][$this->hhh . 'SITE_BOTTOM_BUTTON' . $this->hhh] = '<?php echo $this->toolbar->render(); ?>';
					break;
				case 5:
					// set buttons to buttom left of the view
					$this->placeholders[$this->bbb . 'SITE_TOOLBAR' . $this->ddd] = '<?php echo $this->toolbar->render(); ?>';
					break;
			}
		}
		// check if custom button should be added
		if (isset($view['settings']->add_custom_button) && $view['settings']->add_custom_button == 1)
		{
			$buttons = array();
			$this->onlyFunctionButton = array();
			$functionNames = array();
			if (isset($view['settings']->custom_buttons) && ComponentbuilderHelper::checkArray($view['settings']->custom_buttons))
			{
				foreach ($view['settings']->custom_buttons as $custom_button)
				{
					// Load to lang
					$keyLang = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($custom_button['name'], 'U');
					$keyCode = ComponentbuilderHelper::safeString($custom_button['name']);
					$this->setLangContent($this->lang, $keyLang, $custom_button['name']);
					// load the button
					if (3 !== $type && ($custom_button['target'] != 2 || $this->target === 'site'))
					{
						// add cpanel button TODO does not work well on site with permissions
						if ($custom_button['target'] == 2 || $this->target === 'site')
						{
							$buttons[] = $this->_t(1) . $tab . $this->_t(1) . "if (\$this->user->authorise('" . $viewName . "." . $keyCode . "', 'com_" . $this->componentCodeName . "'))";
						}
						else
						{
							$buttons[] = $this->_t(1) . $tab . $this->_t(1) . "if (\$this->canDo->get('" . $viewName . "." . $keyCode . "'))";
						}
						$buttons[] = $this->_t(1) . $tab . $this->_t(1) . "{";
						$buttons[] = $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " add " . $custom_button['name'] . " button.";
						$buttons[] = $this->_t(1) . $tab . $this->_t(2) . "JToolBarHelper::custom('" . $viewName . "." . $custom_button['method'] . "', '" . $custom_button['icomoon'] . "', '', '" . $keyLang . "', false);";
						$buttons[] = $this->_t(1) . $tab . $this->_t(1) . "}";
					}
					// load the list button
					elseif (3 == $type && $custom_button['target'] != 1)
					{
						// This is only for list admin views
						if (isset($custom_button['type']) && $custom_button['type'] == 2)
						{
							if (!isset($this->onlyFunctionButton[$viewsName]))
							{
								$this->onlyFunctionButton[$viewsName] = array();
							}
							$this->onlyFunctionButton[$viewsName][] = $this->_t(1) . $tab . "if (\$this->user->authorise('" . $viewName . "." . $keyCode . "', 'com_" . $this->componentCodeName . "'))";
							$this->onlyFunctionButton[$viewsName][] = $this->_t(1) . $tab . "{";
							$this->onlyFunctionButton[$viewsName][] = $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " add " . $custom_button['name'] . " button.";
							$this->onlyFunctionButton[$viewsName][] = $this->_t(1) . $tab . $this->_t(1) . "JToolBarHelper::custom('" . $viewsName . "." . $custom_button['method'] . "', '" . $custom_button['icomoon'] . "', '', '" . $keyLang . "', false);";
							$this->onlyFunctionButton[$viewsName][] = $this->_t(1) . $tab . "}";
						}
						else
						{
							$buttons[] = $this->_t(1) . $tab . $this->_t(1) . "if (\$this->user->authorise('" . $viewName . "." . $keyCode . "', 'com_" . $this->componentCodeName . "'))";
							$buttons[] = $this->_t(1) . $tab . $this->_t(1) . "{";
							$buttons[] = $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " add " . $custom_button['name'] . " button.";
							$buttons[] = $this->_t(1) . $tab . $this->_t(2) . "JToolBarHelper::custom('" . $viewsName . "." . $custom_button['method'] . "', '" . $custom_button['icomoon'] . "', '', '" . $keyLang . "', '" . $validateSelection . "');";
							$buttons[] = $this->_t(1) . $tab . $this->_t(1) . "}";
						}
					}
				}
			}
			// load the model and controller
			if (3 == $type)
			{
				// insure the controller and model strings are added
				if (isset($view['settings']->php_controller_list) && ComponentbuilderHelper::checkString($view['settings']->php_controller_list) && $view['settings']->php_controller_list != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_CONTROLLER
					$this->fileContentDynamic[$viewsName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_CONTROLLER_LIST' . $this->hhh] = PHP_EOL . PHP_EOL . $this->setPlaceholders($view['settings']->php_controller_list, $this->placeholders);
				}
				// load the model
				if (isset($view['settings']->php_model_list) && ComponentbuilderHelper::checkString($view['settings']->php_model_list) && $view['settings']->php_model_list != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_METHOD
					$this->fileContentDynamic[$viewsName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_METHOD_LIST' . $this->hhh] = PHP_EOL . PHP_EOL . $this->setPlaceholders($view['settings']->php_model_list, $this->placeholders);
				}
			}
			else
			{
				// insure the controller and model strings are added
				if (ComponentbuilderHelper::checkString($view['settings']->php_controller) && $view['settings']->php_controller != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_CONTROLLER
					$this->fileContentDynamic[$viewName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_CONTROLLER' . $this->hhh] = PHP_EOL . PHP_EOL . $this->setPlaceholders($view['settings']->php_controller, $this->placeholders);
					if ('site' === $this->target)
					{
						// add the controller for this view
						// build the file
						$target = array($this->target => $viewName);
						$this->buildDynamique($target, 'custom_form');
						// GET_FORM_CUSTOM
					}
				}
				// load the model
				if (ComponentbuilderHelper::checkString($view['settings']->php_model) && $view['settings']->php_model != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_METHOD
					$this->fileContentDynamic[$viewName][$this->hhh . $TARGET . '_CUSTOM_BUTTONS_METHOD' . $this->hhh] = PHP_EOL . PHP_EOL . $this->setPlaceholders($view['settings']->php_model, $this->placeholders);
				}
			}
			// return buttons if they were build
			if (ComponentbuilderHelper::checkArray($buttons))
			{
				// only for site views
				if ('site' === $this->target)
				{
					// set the custom get form method  SITE_JAVASCRIPT_FOR_BUTTONS
					$this->fileContentDynamic[$view['settings']->code][$this->hhh . 'SITE_JAVASCRIPT_FOR_BUTTONS' . $this->hhh] = $this->setJavaScriptForButtons();
					// insure the form is added
					$this->addSiteForm[$view['settings']->code] = true;
				}
				return PHP_EOL . implode(PHP_EOL, $buttons);
			}
		}
		return '';
	}

	public function setJavaScriptForButtons()
	{
		// add behavior.framework to insure Joomla function is on the page
		$script = array();
		$script[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add the needed Javascript to insure that the buttons work.";
		$script[] = $this->_t(2) . "JHtml::_('behavior.framework', true);";
		$script[] = $this->_t(2) . "\$this->document->addScriptDeclaration(\"Joomla.submitbutton = function(task){if (task == ''){ return false; } else { Joomla.submitform(task); return true; }}\");";

		// return the script
		return PHP_EOL . implode(PHP_EOL, $script);
	}

	public function setFunctionOnlyButtons($viewName_list)
	{
		// return buttons if they were build
		if (isset($this->onlyFunctionButton[$viewName_list]) && ComponentbuilderHelper::checkArray($this->onlyFunctionButton[$viewName_list]))
		{
			return PHP_EOL . implode(PHP_EOL, $this->onlyFunctionButton[$viewName_list]);
		}
		return '';
	}

	public function setCustomCSS(&$view)
	{
		if ($view['settings']->add_css == 1)
		{
			if (ComponentbuilderHelper::checkString($view['settings']->css))
			{
				return $this->setPlaceholders($view['settings']->css, $this->placeholders);
			}
		}
		return '';
	}

	public function setDocumentCustomCSS(&$view)
	{
		if ($view['settings']->add_css_document == 1)
		{
			$view['settings']->css_document = (array) explode(PHP_EOL, $view['settings']->css_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->css_document))
			{
				$script = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the Custom CSS script to view" . PHP_EOL . $this->_t(2) . '$this->document->addStyleDeclaration("';
				$cssDocument = PHP_EOL . $this->_t(3) . str_replace('"', '\"', implode(PHP_EOL . $this->_t(3), $view['settings']->css_document));
				return $script . $this->setPlaceholders($cssDocument, $this->placeholders) . PHP_EOL . $this->_t(2) . '");';
			}
		}
		return '';
	}

	public function setJavaScriptFile(&$view, $TARGET)
	{
		if ($view['settings']->add_javascript_file == 1 && ComponentbuilderHelper::checkString($view['settings']->javascript_file))
		{
			// get dates
			$created = $this->getCreatedDate($view);
			$modified = $this->getLastModifiedDate($view);
			// add file to view
			$target = array($this->target => $view['settings']->code);
			$config = array($this->hhh . 'CREATIONDATE' . $this->hhh => $created, $this->hhh . 'BUILDDATE' . $this->hhh => $modified, $this->hhh . 'VERSION' . $this->hhh => $view['settings']->version);
			$this->buildDynamique($target, 'javascript_file', false, $config);
			// set path
			if ('site' === $this->target)
			{
				$path = '/components/com_' . $this->componentCodeName . '/assets/js/' . $view['settings']->code . '.js';
			}
			else
			{
				$path = '/administrator/components/com_' . $this->componentCodeName . '/assets/js/' . $view['settings']->code . '.js';
			}
			// add script to file
			$this->fileContentDynamic[$view['settings']->code][$this->hhh . $TARGET . '_JAVASCRIPT_FILE' . $this->hhh] = $this->setPlaceholders($view['settings']->javascript_file, $this->placeholders);
			// add script to view
			return PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add View JavaScript File" . PHP_EOL . $this->_t(2) . $this->setIncludeLibScript($path);
		}
		return '';
	}

	public function setDocumentCustomJS(&$view)
	{
		if ($view['settings']->add_js_document == 1)
		{
			$view['settings']->js_document = (array) explode(PHP_EOL, $view['settings']->js_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->js_document))
			{
				$script = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the Custom JS script to view" . PHP_EOL . $this->_t(2) . '$this->document->addScriptDeclaration("';
				$jsDocument = PHP_EOL . $this->_t(3) . str_replace('"', '\"', implode(PHP_EOL . $this->_t(3), $view['settings']->js_document));
				return $script . $this->setPlaceholders($jsDocument, $this->placeholders) . PHP_EOL . $this->_t(2) . '");';
			}
		}
		return '';
	}

	public function setFootableScriptsLoader(&$view)
	{
		if (isset($this->footableScripts[$this->target][$view['settings']->code]) && $this->footableScripts[$this->target][$view['settings']->code])
		{
			return $this->setFootableScripts(false);
		}
		return '';
	}

	public function setDocumentMetadata(&$view)
	{
		if ($view['settings']->main_get->gettype == 1 && isset($view['metadata']) && $view['metadata'] == 1)
		{
			return $this->setMetadataItem();
		}
		elseif (isset($view['metadata']) && $view['metadata'] == 1)
		{
			// lets check if we have a custom get method that has the same name as the view
			// if we do then it posibly can be that the metadata is loaded via that method
			// and we can load the full metadata structure with its vars
			if (isset($view['settings']->custom_get) && ComponentbuilderHelper::checkArray($view['settings']->custom_get))
			{
				$found = false;
				$searchFor = 'get' . $view['settings']->Code;
				foreach ($view['settings']->custom_get as $custom_get)
				{
					if ($searchFor == $custom_get->getcustom)
					{
						$found = true;
						break;
					}
				}
				// now lets see
				if ($found)
				{
					return $this->setMetadataItem($view['settings']->code);
				}
				else
				{
					return $this->setMetadataList();
				}
			}
			else
			{
				return $this->setMetadataList();
			}
		}
		return '';
	}

	public function setMetadataItem($item = 'item')
	{
		$meta = array();
		$meta[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " load the meta description";
		$meta[] = $this->_t(2) . "if (isset(\$this->" . $item . "->metadesc) && \$this->" . $item . "->metadesc)";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setDescription(\$this->" . $item . "->metadesc);";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "elseif (\$this->params->get('menu-meta_description'))";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " load the key words if set";
		$meta[] = $this->_t(2) . "if (isset(\$this->" . $item . "->metakey) && \$this->" . $item . "->metakey)";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setMetadata('keywords', \$this->" . $item . "->metakey);";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "elseif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check the robot params";
		$meta[] = $this->_t(2) . "if (isset(\$this->" . $item . "->robots) && \$this->" . $item . "->robots)";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setMetadata('robots', \$this->" . $item . "->robots);";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "elseif (\$this->params->get('robots'))";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if autor is to be set";
		$meta[] = $this->_t(2) . "if (isset(\$this->" . $item . "->created_by) && \$this->params->get('MetaAuthor') == '1')";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setMetaData('author', \$this->" . $item . "->created_by);";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if metadata is available";
		$meta[] = $this->_t(2) . "if (isset(\$this->" . $item . "->metadata) && \$this->" . $item . "->metadata)";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$mdata = json_decode(\$this->" . $item . "->metadata,true);";
		$meta[] = $this->_t(3) . "foreach (\$mdata as \$k => \$v)";
		$meta[] = $this->_t(3) . "{";
		$meta[] = $this->_t(4) . "if (\$v)";
		$meta[] = $this->_t(4) . "{";
		$meta[] = $this->_t(5) . "\$this->document->setMetadata(\$k, \$v);";
		$meta[] = $this->_t(4) . "}";
		$meta[] = $this->_t(3) . "}";
		$meta[] = $this->_t(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	public function setMetadataList()
	{
		$meta = array();
		$meta[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " load the meta description";
		$meta[] = $this->_t(2) . "if (\$this->params->get('menu-meta_description'))";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " load the key words if set";
		$meta[] = $this->_t(2) . "if (\$this->params->get('menu-meta_keywords'))";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = $this->_t(2) . "}";
		$meta[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check the robot params";
		$meta[] = $this->_t(2) . "if (\$this->params->get('robots'))";
		$meta[] = $this->_t(2) . "{";
		$meta[] = $this->_t(3) . "\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = $this->_t(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	public function setGoogleChartLoader(&$view)
	{
		if (isset($this->googleChart[$this->target][$view['settings']->code]) && $this->googleChart[$this->target][$view['settings']->code])
		{
			$chart = array();
			$chart[] = PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " add the google chart builder class.";
			$chart[] = $this->_t(2) . "require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/chartbuilder.php';";
			$chart[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " load the google chart js.";
			$chart[] = $this->_t(2) . "\$this->document->addScript(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/js/google.jsapi.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$chart[] = $this->_t(2) . "\$this->document->addScript('https://canvg.googlecode.com/svn/trunk/rgbcolor.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$chart[] = $this->_t(2) . "\$this->document->addScript('https://canvg.googlecode.com/svn/trunk/canvg.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			return implode(PHP_EOL, $chart);
		}
		return '';
	}

	public function setLibrariesLoader($view)
	{
		// check call sig
		if (isset($view['settings']) && isset($view['settings']->code))
		{
			$code = $view['settings']->code;
			$view_active = true;
		}
		elseif (isset($view->code_name))
		{
			$code = $view->code_name;
			$view_active = false;
		}
		// reset bucket
		$setter = '';
		// allways load these in
		if ($view_active)
		{
			$setter .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " always make sure jquery is loaded.";
			$setter .= PHP_EOL . $this->_t(2) . "JHtml::_('jquery.framework');";
			$setter .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Load the header checker class.";
			if ($this->target === 'site')
			{
				$setter .= PHP_EOL . $this->_t(2) . "require_once( JPATH_COMPONENT_SITE.'/helpers/headercheck.php' );";
			}
			else
			{
				$setter .= PHP_EOL . $this->_t(2) . "require_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/headercheck.php' );";
			}
			$setter .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Initialize the header checker.";
			$setter .= PHP_EOL . $this->_t(2) . "\$HeaderCheck = new " . $this->componentCodeName . "HeaderCheck;";
		}
		// check if this view should get libraries
		if (isset($this->libManager[$this->target][$code]) && ComponentbuilderHelper::checkArray($this->libManager[$this->target][$code]))
		{
			foreach ($this->libManager[$this->target][$code] as $id => $true)
			{
				if (isset($this->libraries[$id]) && ComponentbuilderHelper::checkObject($this->libraries[$id]) && isset($this->libraries[$id]->document) && ComponentbuilderHelper::checkString($this->libraries[$id]->document))
				{
					$setter .= PHP_EOL . PHP_EOL . $this->setPlaceholders(
							str_replace('$document->', '$this->document->', $this->libraries[$id]->document), $this->placeholders);
				}
				elseif (isset($this->libraries[$id]) && ComponentbuilderHelper::checkObject($this->libraries[$id]) && isset($this->libraries[$id]->how))
				{
					$setter .= $this->setLibraryDocument($id);
				}
			}
		}
		// convert back to $document if module call (oops :)
		if (!$view_active)
		{
			return str_replace('$this->document->', '$document->', $setter);
		}
		return $setter;
	}

	protected function setLibraryDocument($id)
	{
		if (2 == $this->libraries[$id]->how && isset($this->libraries[$id]->conditions) && ComponentbuilderHelper::checkArray($this->libraries[$id]->conditions))
		{
			// build document with the conditions values
			$this->setLibraryDocConditions($id, $this->setLibraryScripts($id, false));
		}
		elseif (1 == $this->libraries[$id]->how)
		{
			// build document to allways add all files and urls
			$this->setLibraryScripts($id);
		}
		// check if the document was build
		if (isset($this->libraries[$id]->document) && ComponentbuilderHelper::checkString($this->libraries[$id]->document))
		{
			return PHP_EOL . PHP_EOL . $this->libraries[$id]->document;
		}
		return '';
	}

	protected function setLibraryDocConditions($id, $scripts)
	{
		$document = '';
		// Start script builder for library files
		if (!isset($this->libwarning[$id]))
		{
			$this->app->enqueueMessage(JText::_('<hr /><h3>Conditional Script Warning</h3>'), 'Warning');
			$this->app->enqueueMessage(JText::sprintf('The conditional script builder for <b>%s</b> is not ready, sorry!', $this->libraries[$id]->name), 'Warning');
			// set the warning only once
			$this->libwarning[$id] = true;
		}
		// if there was any code added to document then set globaly
		if (ComponentbuilderHelper::checkString($document))
		{
			$this->libraries[$id]->document = $document;
		}
	}

	protected function setLibraryScripts($id, $buildDoc = true)
	{
		$scripts = array();
		// load the urls if found
		if (isset($this->libraries[$id]->urls) && ComponentbuilderHelper::checkArray($this->libraries[$id]->urls))
		{
			// set all the files
			foreach ($this->libraries[$id]->urls as $url)
			{
				// if local path is set, then use it first
				if (isset($url['path']))
				{
					// update the root path
					$path = $this->getScriptRootPath($url['path']);
					// load document script
					$scripts[md5($url['path'])] = $this->setIncludeLibScript($path);
					// load url also if not building document
					if (!$buildDoc)
					{
						// load document script
						$scripts[md5($url['url'])] = $this->setIncludeLibScript($url['url'], false);
					}
				}
				else
				{
					// load document script
					$scripts[md5($url['url'])] = $this->setIncludeLibScript($url['url'], false);
				}
			}
		}
		// load the local files if found
		if (isset($this->libraries[$id]->files) && ComponentbuilderHelper::checkArray($this->libraries[$id]->files))
		{
			// set all the files
			foreach ($this->libraries[$id]->files as $file)
			{
				$path = '/' . trim($file['path'], '/');
				// check if path has new file name (has extetion)
				$pathInfo = pathinfo($path);
				// update the root path
				$_path = $this->getScriptRootPath($path);
				if (isset($pathInfo['extension']) && $pathInfo['extension'])
				{
					// load document script
					$scripts[md5($path)] = $this->setIncludeLibScript($_path, false, $pathInfo);
				}
				else
				{
					// load document script
					$scripts[md5($path . '/' . trim($file['file'], '/'))] = $this->setIncludeLibScript($_path . '/' . trim($file['file'], '/'));
				}
			}
		}
		// load the local folders if found
		if (isset($this->libraries[$id]->folders) && ComponentbuilderHelper::checkArray($this->libraries[$id]->folders))
		{
			// get all the file paths
			foreach ($this->libraries[$id]->folders as $folder)
			{
				if (isset($folder['path']) && isset($folder['folder']))
				{
					$path = '/' . trim($folder['path'], '/');
					if (isset($folder['rename']) && 1 == $folder['rename'])
					{
						if ($_paths = ComponentbuilderHelper::getAllFilePaths($this->componentPath . $path))
						{
							$files[$path] = $_paths;
						}
					}
					else
					{
						$path = $path . '/' . trim($folder['folder'], '/');
						if ($_paths = ComponentbuilderHelper::getAllFilePaths($this->componentPath . $path))
						{
							$files[$path] = $_paths;
						}
					}
				}
			}
			// now load the script
			foreach ($files as $root => $paths)
			{
				// update the root path
				$_root = $this->getScriptRootPath($root);
				// load per path
				foreach ($paths as $path)
				{
					$scripts[md5($root . '/' . trim($path, '/'))] = $this->setIncludeLibScript($_root . '/' . trim($path, '/'));
				}
			}
		}
		// if there was any code added to document then set globaly
		if ($buildDoc && ComponentbuilderHelper::checkArray($scripts))
		{
			$this->libraries[$id]->document = $this->_t(2) . "//" . $this->setLine(__LINE__) . " always load these files." . PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $scripts);
			// success
			return true;
		}
		elseif (ComponentbuilderHelper::checkArray($scripts))
		{
			return $scripts;
		}
		return false;
	}

	protected function setIncludeLibScript($path, $local = true, $pathInfo = false)
	{
		// insure we have the path info
		if (!$pathInfo)
		{
			$pathInfo = pathinfo($path);
		}
		// set the local string
		$JURI = '';
		if ($local)
		{
			$JURI = 'JURI::root(true) . ';
		}
		// use the path info to build the script
		if (isset($pathInfo['extension']) && $pathInfo['extension'])
		{
			switch ($pathInfo['extension'])
			{
				case 'js':
					return '$this->document->addScript(' . $JURI . '"' . $path . '", (' . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");';
					break;
				case 'css':
				case 'less':
					return '$this->document->addStyleSheet(' . $JURI . '"' . $path . '", (' . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/css");';
					break;
				case 'php':
					if (strpos($path, 'http') === false)
					{
						return 'require_once("' . $path . '");';
					}
					break;
			}
		}
		return '';
	}

	protected function getScriptRootPath($root)
	{
		if (strpos($root, '/media/') !== false && strpos($root, '/admin/') === false && strpos($root, '/site/') === false)
		{
			return str_replace('/media/', '/media/com_' . $this->componentCodeName . '/', $root);
		}
		elseif (strpos($root, '/media/') === false && strpos($root, '/admin/') !== false && strpos($root, '/site/') === false)
		{
			return str_replace('/admin/', '/administrator/components/com_' . $this->componentCodeName . '/', $root);
		}
		elseif (strpos($root, '/media/') === false && strpos($root, '/admin/') === false && strpos($root, '/site/') !== false)
		{
			return str_replace('/site/', '/components/com_' . $this->componentCodeName . '/', $root);
		}
		return $root;
	}

	public function setUikitLoader(&$view)
	{
		// reset setter
		$setter = '';
		// load the defaults needed
		if ($this->uikit > 0)
		{
			$setter .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Load uikit options.";
			$setter .= PHP_EOL . $this->_t(2) . "\$uikit = \$this->params->get('uikit_load');";
			$setter .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set script size.";
			$setter .= PHP_EOL . $this->_t(2) . "\$size = \$this->params->get('uikit_min');";
			$tabV = "";
			// if both versions should be loaded then add some more logic
			if (2 == $this->uikit)
			{
				$setter .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Load uikit version.";
				$setter .= PHP_EOL . $this->_t(2) . "\$this->uikitVersion = \$this->params->get('uikit_version', 2);";
				$setter .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Use Uikit Version 2";
				$setter .= PHP_EOL . $this->_t(2) . "if (2 == \$this->uikitVersion)";
				$setter .= PHP_EOL . $this->_t(2) . "{";
				$tabV = $this->_t(1);
			}
		}
		// load the defaults needed
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set css style.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "\$style = \$this->params->get('uikit_style');";

			$setter .= PHP_EOL . PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " The uikit css.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "if ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$this->document->addStyleSheet(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v2/css/uikit'.\$style.\$size.'.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " The uikit js.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "if ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$this->document->addScript(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v2/js/uikit'.\$size.'.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "}";
		}
		// load the components need
		if ((2 == $this->uikit || 1 == $this->uikit) && isset($this->uikitComp[$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->uikitComp[$view['settings']->code]))
		{
			$setter .= PHP_EOL . PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Load the script to find all uikit components needed.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "if (\$uikit != 2)";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set the default uikit components in this view.";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$uikitComp = array();";
			foreach ($this->uikitComp[$view['settings']->code] as $class)
			{
				$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$uikitComp[] = '" . $class . "';";
			}
			// check content for more needed components
			if (isset($this->siteFieldData['uikit'][$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->siteFieldData['uikit'][$view['settings']->code]))
			{
				$setter .= PHP_EOL . PHP_EOL . $tabV . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get field uikit components needed in this view.";
				$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$uikitFieldComp = \$this->get('UikitComp');";
				$setter .= PHP_EOL . $tabV . $this->_t(3) . "if (isset(\$uikitFieldComp) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$uikitFieldComp))";
				$setter .= PHP_EOL . $tabV . $this->_t(3) . "{";
				$setter .= PHP_EOL . $tabV . $this->_t(4) . "if (isset(\$uikitComp) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$uikitComp))";
				$setter .= PHP_EOL . $tabV . $this->_t(4) . "{";
				$setter .= PHP_EOL . $tabV . $this->_t(5) . "\$uikitComp = array_merge(\$uikitComp, \$uikitFieldComp);";
				$setter .= PHP_EOL . $tabV . $this->_t(5) . "\$uikitComp = array_unique(\$uikitComp);";
				$setter .= PHP_EOL . $tabV . $this->_t(4) . "}";
				$setter .= PHP_EOL . $tabV . $this->_t(4) . "else";
				$setter .= PHP_EOL . $tabV . $this->_t(4) . "{";
				$setter .= PHP_EOL . $tabV . $this->_t(5) . "\$uikitComp = \$uikitFieldComp;";
				$setter .= PHP_EOL . $tabV . $this->_t(4) . "}";
				$setter .= PHP_EOL . $tabV . $this->_t(3) . "}";
			}
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "}";
			$setter .= PHP_EOL . PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Load the needed uikit components in this view.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "if (\$uikit != 2 && isset(\$uikitComp) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$uikitComp))";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "//" . $this->setLine(__LINE__) . " load just in case.";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "jimport('joomla.filesystem.file');";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "//" . $this->setLine(__LINE__) . " loading...";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "foreach (\$uikitComp as \$class)";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(4) . "foreach (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL . $tabV . $this->_t(4) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "//" . $this->setLine(__LINE__) . " check if the CSS file exists.";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "if (JFile::exists(JPATH_ROOT.'/media/com_" . $this->componentCodeName . "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "//" . $this->setLine(__LINE__) . " load the css.";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "\$this->document->addStyleSheet(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "//" . $this->setLine(__LINE__) . " check if the JavaScript file exists.";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "if (JFile::exists(JPATH_ROOT.'/media/com_" . $this->componentCodeName . "/uikit-v2/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "//" . $this->setLine(__LINE__) . " load the js.";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "\$this->document->addScript(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v2/js/components/'.\$name.\$size.'.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(4) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "}";
		}
		elseif ((2 == $this->uikit || 1 == $this->uikit) && isset($this->siteFieldData['uikit'][$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->siteFieldData['uikit'][$view['settings']->code]))
		{
			$setter .= PHP_EOL . PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Load the needed uikit components in this view.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "\$uikitComp = \$this->get('UikitComp');";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "if (\$uikit != 2 && isset(\$uikitComp) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$uikitComp))";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "//" . $this->setLine(__LINE__) . " load just in case.";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "jimport('joomla.filesystem.file');";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "//" . $this->setLine(__LINE__) . " loading...";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "foreach (\$uikitComp as \$class)";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(4) . "foreach (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL . $tabV . $this->_t(4) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "//" . $this->setLine(__LINE__) . " check if the CSS file exists.";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "if (JFile::exists(JPATH_ROOT.'/media/com_" . $this->componentCodeName . "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "//" . $this->setLine(__LINE__) . " load the css.";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "\$this->document->addStyleSheet(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "//" . $this->setLine(__LINE__) . " check if the JavaScript file exists.";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "if (JFile::exists(JPATH_ROOT.'/media/com_" . $this->componentCodeName . "/uikit-v2/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "//" . $this->setLine(__LINE__) . " load the js.";
			$setter .= PHP_EOL . $tabV . $this->_t(6) . "\$this->document->addScript(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v2/js/components/'.\$name.\$size.'.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('type' => 'text/javascript', 'async' => 'async') : true);";
			$setter .= PHP_EOL . $tabV . $this->_t(5) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(4) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "}";
		}
		// now set the version 3
		if (2 == $this->uikit || 3 == $this->uikit)
		{
			if (2 == $this->uikit)
			{
				$setter .= PHP_EOL . $this->_t(2) . "}";
				$setter .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Use Uikit Version 3";
				$setter .= PHP_EOL . $this->_t(2) . "elseif (3 == \$this->uikitVersion)";
				$setter .= PHP_EOL . $this->_t(2) . "{";
			}
			// add version 3 fiels to page
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " The uikit css.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "if ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$this->document->addStyleSheet(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v3/css/uikit'.\$size.'.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "}";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "//" . $this->setLine(__LINE__) . " The uikit js.";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "if ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "{";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$this->document->addScript(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v3/js/uikit'.\$size.'.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$setter .= PHP_EOL . $tabV . $this->_t(3) . "\$this->document->addScript(JURI::root(true) .'/media/com_" . $this->componentCodeName . "/uikit-v3/js/uikit-icons'.\$size.'.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$setter .= PHP_EOL . $tabV . $this->_t(2) . "}";
			if (2 == $this->uikit)
			{
				$setter .= PHP_EOL . $this->_t(2) . "}";
			}
		}
		return $setter;
	}

	public function setCustomViewExtraDisplayMethods(&$view)
	{
		if ($view['settings']->add_php_jview == 1)
		{
			return PHP_EOL . PHP_EOL . $this->setPlaceholders($view['settings']->php_jview, $this->placeholders);
		}
		return '';
	}

	public function setCustomViewBody(&$view)
	{
		if (ComponentbuilderHelper::checkString($view['settings']->default))
		{
			if ($view['settings']->main_get->gettype == 2 && $view['settings']->main_get->pagination == 1)
			{
				// build body
				$body = array();
				// add limit box
				if (strpos($view['settings']->default, $this->bbb . 'LIMITBOX' . $this->ddd) !== false)
				{
					$this->placeholders[$this->bbb . 'LIMITBOX' . $this->ddd] = '<?php echo $this->pagination->getLimitBox(); ?>';
				}
				$body[] = $this->setPlaceholders($view['settings']->default, $this->placeholders);
				$body[] = PHP_EOL . '<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>';
				$body[] = $this->_t(1) . '<div class="pagination">';
				$body[] = $this->_t(2) . '<?php if ($this->params->def(\'show_pagination_results\', 1)) : ?>';

				if (strpos($view['settings']->default, $this->bbb . 'LIMITBOX' . $this->ddd) === false)
				{
					$body[] = $this->_t(3) . '<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>';
				}
				else
				{
					$body[] = $this->_t(3) . '<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>';
				}
				$body[] = $this->_t(2) . '<?php endif; ?>';
				$body[] = $this->_t(2) . '<?php echo $this->pagination->getPagesLinks(); ?>';
				$body[] = $this->_t(1) . '</div>';
				$body[] = '<?php endif; ?>';
				// insure the form is added
				$this->addSiteForm[$view['settings']->code] = true;
				// return the body
				return implode(PHP_EOL, $body);
			}
			else
			{
				return PHP_EOL . $this->setPlaceholders($view['settings']->default, $this->placeholders);
			}
		}
		return '';
	}
	
	public function setCustomViewForm(&$view, $type)
	{
		if (isset($this->addSiteForm[$view]) && $this->addSiteForm[$view])
		{
			switch($type)
			{
				case 1:
					// top
					return '<form action="<?php echo JRoute::_(\'index.php?option=com_' . $this->componentCodeName . '\'); ?>" method="post" name="adminForm" id="adminForm">' . PHP_EOL;
					break;
				case 2:
					// bottom
					return PHP_EOL . '<input type="hidden" name="task" value="" />' . PHP_EOL . "<?php echo JHtml::_('form.token'); ?>" . PHP_EOL . '</form>';
					break;
			}
		}
		return '';
	}

	public function setCustomViewSubmitButtonScript(&$view)
	{
		if (ComponentbuilderHelper::checkString($view['settings']->default))
		{
			// add the script only if there is none set
			if (strpos($view['settings']->default, 'Joomla.submitbutton = function(task)') === false)
			{
				$script = array();
				$script[] = PHP_EOL . "<script type=\"text/javascript\">";
				$script[] = $this->_t(1) . "Joomla.submitbutton = function(task) {";
				$script[] = $this->_t(2) . "if (task === '" . $view['settings']->code . ".back') {";
				$script[] = $this->_t(3) . "parent.history.back();";
				$script[] = $this->_t(3) . "return false;";
				$script[] = $this->_t(2) . "} else {";
				$script[] = $this->_t(3) . "var form = document.getElementById('adminForm');";
				$script[] = $this->_t(3) . "form.task.value = task;";
				$script[] = $this->_t(3) . "form.submit();";
				$script[] = $this->_t(2) . "}";
				$script[] = $this->_t(1) . "}";
				$script[] = "</script>";

				return implode(PHP_EOL, $script);
			}
		}
		return '';
	}

	public function setCustomViewCodeBody(&$view)
	{
		if ($view['settings']->add_php_view == 1)
		{
			$view['settings']->php_view = (array) explode(PHP_EOL, $view['settings']->php_view);
			if (ComponentbuilderHelper::checkArray($view['settings']->php_view))
			{
				$_tmp = PHP_EOL . PHP_EOL . implode(PHP_EOL, $view['settings']->php_view);
				return $this->setPlaceholders($_tmp, $this->placeholders);
			}
		}
		return '';
	}

	public function setCustomViewTemplateBody(&$view)
	{
		if (isset($this->templateData[$this->target][$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->templateData[$this->target][$view['settings']->code]))
		{
			$created = $this->getCreatedDate($view);
			$modified = $this->getLastModifiedDate($view);
			foreach ($this->templateData[$this->target][$view['settings']->code] as $template => $data)
			{
				// build the file
				$target = array($this->target => $view['settings']->code);
				$config = array($this->hhh . 'CREATIONDATE' . $this->hhh => $created, $this->hhh . 'BUILDDATE' . $this->hhh => $modified, $this->hhh . 'VERSION' . $this->hhh => $view['settings']->version);
				$this->buildDynamique($target, 'template', $template, $config);
				// set the file data
				$TARGET = ComponentbuilderHelper::safeString($this->target, 'U');
				// SITE_TEMPLATE_BODY <<<DYNAMIC>>>
				$this->fileContentDynamic[$view['settings']->code . '_' . $template][$this->hhh . $TARGET . '_TEMPLATE_BODY' . $this->hhh] = PHP_EOL . $this->setPlaceholders($data['html'], $this->placeholders);
				// SITE_TEMPLATE_CODE_BODY <<<DYNAMIC>>>
				$this->fileContentDynamic[$view['settings']->code . '_' . $template][$this->hhh . $TARGET . '_TEMPLATE_CODE_BODY' . $this->hhh] = $this->setCustomViewTemplateCode($data['php_view']);
			}
		}
	}

	public function setCustomViewTemplateCode(&$php)
	{
		if (ComponentbuilderHelper::checkString($php))
		{
			$php_view = (array) explode(PHP_EOL, $php);
			if (ComponentbuilderHelper::checkArray($php_view))
			{
				$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);
				return $this->setPlaceholders($php_view, $this->placeholders);
			}
		}
		return '';
	}

	public function setCustomViewLayouts()
	{
		if (isset($this->layoutData[$this->target]) && ComponentbuilderHelper::checkArray($this->layoutData[$this->target]))
		{
			foreach ($this->layoutData[$this->target] as $layout => $data)
			{
				// build the file
				$target = array($this->target => $layout);
				$this->buildDynamique($target, 'layout');
				// set the file data
				$TARGET = ComponentbuilderHelper::safeString($this->target, 'U');
				// SITE_LAYOUT_CODE <<<DYNAMIC>>>
				$php_view = (array) explode(PHP_EOL, $data['php_view']);
				if (ComponentbuilderHelper::checkArray($php_view))
				{
					$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);
					$this->fileContentDynamic[$layout][$this->hhh . $TARGET . '_LAYOUT_CODE' . $this->hhh] = $this->setPlaceholders($php_view, $this->placeholders);
				}
				else
				{
					$this->fileContentDynamic[$layout][$this->hhh . $TARGET . '_LAYOUT_CODE' . $this->hhh] = '';
				}
				// SITE_LAYOUT_BODY <<<DYNAMIC>>>
				$this->fileContentDynamic[$layout][$this->hhh . $TARGET . '_LAYOUT_BODY' . $this->hhh] = PHP_EOL . $this->setPlaceholders($data['html'], $this->placeholders);
			}
		}
	}

	public function getReplacementNames()
	{
		foreach ($this->newFiles as $type => $files)
		{
			foreach ($files as $view => $file)
			{
				if (isset($file['path']) && ComponentbuilderHelper::checkArray($file))
				{
					if (JFile::exists($file['path']))
					{
						$string = ComponentbuilderHelper::getFileContents($file['path']);
						$buket['static'][] = $this->getInbetweenStrings($string);
					}
				}
				elseif (ComponentbuilderHelper::checkArray($file))
				{
					foreach ($file as $nr => $doc)
					{
						if (ComponentbuilderHelper::checkArray($doc))
						{
							if (JFile::exists($doc['path']))
							{
								$string = ComponentbuilderHelper::getFileContents($doc['path']);
								$buket[$view][] = $this->getInbetweenStrings($string);
							}
						}
					}
				}
			}
		}
		foreach ($buket as $type => $array)
		{
			foreach ($array as $replacments)
			{
				$replacments = array_unique($replacments);
				foreach ($replacments as $replacment)
				{
					if ($type !== 'static')
					{
						$echos[$replacment] = "#" . "#" . "#" . $replacment . "#" . "#" . "#<br />";
					}
					elseif ($type === 'static')
					{
						$echos[$replacment] = "#" . "#" . "#" . $replacment . "#" . "#" . "#<br />";
					}
				}
			}
		}

		foreach ($echos as $echo)
		{
			echo $echo . '<br />';
		}
	}

	public function setMethodGetItem(&$view)
	{
		$script = '';
		// get the component name
		$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
		// go from base64 to string
		if (isset($this->base64Builder[$view]) && ComponentbuilderHelper::checkArray($this->base64Builder[$view]))
		{
			foreach ($this->base64Builder[$view] as $baseString)
			{
				$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "if (!empty(\$item->" . $baseString . "))"; // TODO && base64_encode(base64_decode(\$item->".$baseString.", true)) === \$item->".$baseString.")";
				$script .= PHP_EOL . $this->_t(3) . "{";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " base64 Decode " . $baseString . ".";
				$script .= PHP_EOL . $this->_t(4) . "\$item->" . $baseString . " = base64_decode(\$item->" . $baseString . ");";
				$script .= PHP_EOL . $this->_t(3) . "}";
			}
		}
		// decryption
		foreach ($this->cryptionTypes as $cryptionType)
		{
			if (isset($this->{$cryptionType . 'FieldModeling'}[$view]) && ComponentbuilderHelper::checkArray($this->{$cryptionType . 'FieldModeling'}[$view]))
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the " . $cryptionType . " encryption.";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $cryptionType . "key = " . $Component . "Helper::getCryptKey('" . $cryptionType . "');";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the encryption object.";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $cryptionType . " = new FOFEncryptAes(\$" . $cryptionType . "key);";
					foreach ($this->{$cryptionType . 'FieldModeling'}[$view] as $baseString)
					{
						$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "if (!empty(\$item->" . $baseString . ") && \$" . $cryptionType . "key && !is_numeric(\$item->" . $baseString . ") && \$item->" . $baseString . " === base64_encode(base64_decode(\$item->" . $baseString . ", true)))";
						$script .= PHP_EOL . $this->_t(3) . "{";
						$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " " . $cryptionType . " decrypt data " . $baseString . ".";
						$script .= PHP_EOL . $this->_t(4) . "\$item->" . $baseString . " = rtrim(\$" . $cryptionType . "->decryptString(\$item->" . $baseString . "), " . '"\0"' . ");";
						$script .= PHP_EOL . $this->_t(3) . "}";
					}
				}
				else
				{
					if (isset($this->{$cryptionType . 'FieldModelInitiator'}[$view]['get']))
					{
						foreach ($this->{$cryptionType . 'FieldModelInitiator'}[$view]['get'] as $block)
						{
							$script .= PHP_EOL . $this->_t(3) . implode(PHP_EOL . $this->_t(3), $block);
						}
					}
					// set the expert script
					foreach ($this->{$cryptionType . 'FieldModeling'}[$view] as $baseString => $opener_)
					{
						$_placeholder_for_field = array('[[[field]]]' => '$item->' . $baseString);
						$script .= $this->setPlaceholders(PHP_EOL . $this->_t(3) . implode(PHP_EOL . $this->_t(3), $opener_['get']), $_placeholder_for_field);
					}
				}
			}
		}
		// go from json to array
		if (isset($this->jsonItemBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonItemBuilder[$view]))
		{
			foreach ($this->jsonItemBuilder[$view] as $jsonItem)
			{
				$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "if (!empty(\$item->" . $jsonItem . "))";
				$script .= PHP_EOL . $this->_t(3) . "{";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Convert the " . $jsonItem . " field to an array.";
				$script .= PHP_EOL . $this->_t(4) . "\$" . $jsonItem . " = new Registry;";
				$script .= PHP_EOL . $this->_t(4) . "\$" . $jsonItem . "->loadString(\$item->" . $jsonItem . ");";
				$script .= PHP_EOL . $this->_t(4) . "\$item->" . $jsonItem . " = \$" . $jsonItem . "->toArray();";
				$script .= PHP_EOL . $this->_t(3) . "}";
			}
		}
		// go from json to string
		if (isset($this->jsonStringBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonStringBuilder[$view]))
		{
			$makeArray = '';
			foreach ($this->jsonStringBuilder[$view] as $jsonString)
			{
				$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "if (!empty(\$item->" . $jsonString . "))";
				$script .= PHP_EOL . $this->_t(3) . "{";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " JSON Decode " . $jsonString . ".";
				if (isset($this->jsonItemBuilderArray[$view]) && ComponentbuilderHelper::checkArray($this->jsonItemBuilderArray[$view]) && in_array($jsonString, $this->jsonItemBuilderArray[$view]))
				{
					$makeArray = ',true';
				}
				elseif (strpos($jsonString, 'group') !== false)
				{
					$makeArray = ',true';
				}
				$script .= PHP_EOL . $this->_t(4) . "\$item->" . $jsonString . " = json_decode(\$item->" . $jsonString . $makeArray . ");";
				$script .= PHP_EOL . $this->_t(3) . "}";
			}
		}

		// add custom php to getitem method
		$script .= $this->getCustomScriptBuilder('php_getitem', $view, PHP_EOL . PHP_EOL);

		return $script;
	}

	public function setCheckboxSave(&$view)
	{
		$script = '';
		if (isset($this->checkboxBuilder[$view]) && ComponentbuilderHelper::checkArray($this->checkboxBuilder[$view]))
		{
			foreach ($this->checkboxBuilder[$view] as $checkbox)
			{
				$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the empty " . $checkbox . " item to data";
				$script .= PHP_EOL . $this->_t(2) . "if (!isset(\$data['" . $checkbox . "']))";
				$script .= PHP_EOL . $this->_t(2) . "{";
				$script .= PHP_EOL . $this->_t(3) . "\$data['" . $checkbox . "'] = '';";
				$script .= PHP_EOL . $this->_t(2) . "}";
			}
		}
		return $script;
	}

	public function setMethodItemSave(&$view)
	{
		$script = '';
		// get component name
		$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
		$component = $this->componentCodeName;
		// check if there was script added before modeling of data
		$script .= $this->getCustomScriptBuilder('php_before_save', $view, PHP_EOL . PHP_EOL);
		// turn array into JSON string
		if (isset($this->jsonItemBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonItemBuilder[$view]))
		{
			foreach ($this->jsonItemBuilder[$view] as $jsonItem)
			{
				$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the " . $jsonItem . " items to data.";
				$script .= PHP_EOL . $this->_t(2) . "if (isset(\$data['" . $jsonItem . "']) && is_array(\$data['" . $jsonItem . "']))";
				$script .= PHP_EOL . $this->_t(2) . "{";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $jsonItem . " = new JRegistry;";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $jsonItem . "->loadArray(\$data['" . $jsonItem . "']);";
				$script .= PHP_EOL . $this->_t(3) . "\$data['" . $jsonItem . "'] = (string) \$" . $jsonItem . ";";
				$script .= PHP_EOL . $this->_t(2) . "}";
				if (isset($this->permissionFields[$view]) && isset($this->permissionFields[$view][$jsonItem]) && ComponentbuilderHelper::checkArray($this->permissionFields[$view][$jsonItem]))
				{
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Also check permission since the value may be removed due to permissions";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Then we do not want to clear it out, but simple ignore the empty " . $jsonItem;
					$script .= PHP_EOL . $this->_t(2) . "elseif (!isset(\$data['" . $jsonItem . "'])";
					// only add permission that are available
					foreach ($this->permissionFields[$view][$jsonItem] as $permission_option => $fieldType)
					{
						$script .= PHP_EOL . $this->_t(3) . "&& JFactory::getUser()->authorise('" . $view . "." . $permission_option . "." . $jsonItem . "', 'com_" . $component . "')";
					}
					$script .= ")";
				}
				else
				{
					$script .= PHP_EOL . $this->_t(2) . "elseif (!isset(\$data['" . $jsonItem . "']))";
				}
				$script .= PHP_EOL . $this->_t(2) . "{";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set the empty " . $jsonItem . " to data";
				$script .= PHP_EOL . $this->_t(3) . "\$data['" . $jsonItem . "'] = '';";
				$script .= PHP_EOL . $this->_t(2) . "}";
			}
		}
		// turn string into json string
		if (isset($this->jsonStringBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonStringBuilder[$view]))
		{
			foreach ($this->jsonStringBuilder[$view] as $jsonString)
			{
				$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the " . $jsonString . " string to JSON string.";
				$script .= PHP_EOL . $this->_t(2) . "if (isset(\$data['" . $jsonString . "']))";
				$script .= PHP_EOL . $this->_t(2) . "{";
				$script .= PHP_EOL . $this->_t(3) . "\$data['" . $jsonString . "'] = (string) json_encode(\$data['" . $jsonString . "']);";
				$script .= PHP_EOL . $this->_t(2) . "}";
			}
		}
		// turn string into base 64 string
		if (isset($this->base64Builder[$view]) && ComponentbuilderHelper::checkArray($this->base64Builder[$view]))
		{
			foreach ($this->base64Builder[$view] as $baseString)
			{
				$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set the " . $baseString . " string to base64 string.";
				$script .= PHP_EOL . $this->_t(2) . "if (isset(\$data['" . $baseString . "']))";
				$script .= PHP_EOL . $this->_t(2) . "{";
				$script .= PHP_EOL . $this->_t(3) . "\$data['" . $baseString . "'] = base64_encode(\$data['" . $baseString . "']);";
				$script .= PHP_EOL . $this->_t(2) . "}";
			}
		}
		// turn string into encrypted string
		foreach ($this->cryptionTypes as $cryptionType)
		{
			if (isset($this->{$cryptionType . 'FieldModeling'}[$view]) && ComponentbuilderHelper::checkArray($this->{$cryptionType . 'FieldModeling'}[$view]))
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the " . $cryptionType . " encryption key.";
					$script .= PHP_EOL . $this->_t(2) . "\$" . $cryptionType . "key = " . $Component . "Helper::getCryptKey('" . $cryptionType . "');";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the encryption object";
					$script .= PHP_EOL . $this->_t(2) . "\$" . $cryptionType . " = new FOFEncryptAes(\$" . $cryptionType . "key);";
					foreach ($this->{$cryptionType . 'FieldModeling'}[$view] as $baseString)
					{
						$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Encrypt data " . $baseString . ".";
						$script .= PHP_EOL . $this->_t(2) . "if (isset(\$data['" . $baseString . "']) && \$" . $cryptionType . "key)";
						$script .= PHP_EOL . $this->_t(2) . "{";
						$script .= PHP_EOL . $this->_t(3) . "\$data['" . $baseString . "'] = \$" . $cryptionType . "->encryptString(\$data['" . $baseString . "']);";
						$script .= PHP_EOL . $this->_t(2) . "}";
					}
				}
				else
				{
					if (isset($this->{$cryptionType . 'FieldModelInitiator'}[$view]) && 
						isset($this->{$cryptionType . 'FieldModelInitiator'}[$view]['save']))
					{
						foreach ($this->{$cryptionType . 'FieldModelInitiator'}[$view]['save'] as $block)
						{
							$script .= PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $block);
						}
					}
					// set the expert script
					foreach ($this->{$cryptionType . 'FieldModeling'}[$view] as $baseString => $locker_)
					{
						$_placeholder_for_field = array('[[[field]]]' => "\$data['" . $baseString . "']");
						$script .= $this->setPlaceholders(PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $locker_['save']), $_placeholder_for_field);
					}
				}
			}
		}
		// add custom PHP to the save method
		$script .= $this->getCustomScriptBuilder('php_save', $view, PHP_EOL . PHP_EOL);
		return $script;
	}

	public function setJtableConstructor(&$view)
	{
		// reset
		$oserver = "";
		// set component name
		$component = $this->componentCodeName;
		// add the tags observer
		if (isset($this->tagsBuilder[$view]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$view]))
		{
			$oserver .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Adding Tag Options";
			$oserver .= PHP_EOL . $this->_t(2) . "JTableObserverTags::createObserver(\$this, array('typeAlias' => 'com_" . $component . "." . $view . "'));";
		}
		// add the history/version observer
		if (isset($this->historyBuilder[$view]) && ComponentbuilderHelper::checkString($this->historyBuilder[$view]))
		{
			$oserver .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Adding History Options";
			$oserver .= PHP_EOL . $this->_t(2) . "JTableObserverContenthistory::createObserver(\$this, array('typeAlias' => 'com_" . $component . "." . $view . "'));";
		}
		return $oserver;
	}

	public function setJtableAliasCategory(&$view)
	{
		// only add Observers if both title, alias and category is availabe in view
		if (array_key_exists($view, $this->catCodeBuilder))
		{
			$code = $this->catCodeBuilder[$view]['code'];
			return ", '" . $code . "' => \$this->" . $code;
		}
		return '';
	}

	public function setComponentToContentTypes($action)
	{
		$script = '';
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			// set component name
			$component = $this->componentCodeName;
			// reset
			$dbStuff = array();
			// start loading the content type data
			foreach ($this->componentData->admin_views as $viewData)
			{
				// set main keys
				$view = ComponentbuilderHelper::safeString($viewData['settings']->name_single);
				// set list view keys
				$views = ComponentbuilderHelper::safeString($viewData['settings']->name_list);
				// get this views content type data
				$dbStuff[$view] = $this->getContentType($view, $component);
				// get the correct views name
				$checkViews = (isset($this->catCodeBuilder[$view]['views']) && ComponentbuilderHelper::checkString($this->catCodeBuilder[$view]['views'])) ? $this->catCodeBuilder[$view]['views'] : $views;
				if (ComponentbuilderHelper::checkArray($dbStuff[$view]) && array_key_exists($view, $this->catCodeBuilder) && ($checkViews == $views))
				{
					$dbStuff[$view . ' category'] = $this->getCategoryContentType($view, $views, $component);
				}
				elseif (!isset($dbStuff[$view]) || !ComponentbuilderHelper::checkArray($dbStuff[$view]))
				{
					// remove if not array
					unset($dbStuff[$view]);
				}
			}
			// build the db insert query
			if (ComponentbuilderHelper::checkArray($dbStuff))
			{
				$taabb = '';
				if ($action === 'update')
				{
					$taabb = $this->_t(1);
				}
				$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get The Database object";
				$script .= PHP_EOL . $this->_t(3) . "\$db = JFactory::getDbo();";
				foreach ($dbStuff as $name => $tables)
				{
					if (ComponentbuilderHelper::checkArray($tables))
					{
						$code = ComponentbuilderHelper::safeString($name);
						$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create the " . $name . " content type object.";
						$script .= PHP_EOL . $this->_t(3) . "\$" . $code . " = new stdClass();";
						foreach ($tables as $table => $data)
						{
							$script .= PHP_EOL . $this->_t(3) . "\$" . $code . "->" . $table . " = '" . $data . "';";
						}
						if ($action === 'update')
						{
							// we first load script to check if data exist
							$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Check if " . $name . " type is already in content_type DB.";
							$script .= PHP_EOL . $this->_t(3) . "\$" . $code . "_id = null;";
							$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
							$script .= PHP_EOL . $this->_t(3) . "\$query->select(\$db->quoteName(array('type_id')));";
							$script .= PHP_EOL . $this->_t(3) . "\$query->from(\$db->quoteName('#__content_types'));";
							$script .= PHP_EOL . $this->_t(3) . "\$query->where(\$db->quoteName('type_alias') . ' LIKE '. \$db->quote($" . $code . "->type_alias));";
							$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
							$script .= PHP_EOL . $this->_t(3) . "\$db->execute();";
						}
						$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set the object into the content types table.";
						if ($action === 'update')
						{
							$script .= PHP_EOL . $this->_t(3) . "if (\$db->getNumRows())";
							$script .= PHP_EOL . $this->_t(3) . "{";
							$script .= PHP_EOL . $this->_t(4) . "\$" . $code . "->type_id = \$db->loadResult();";
							$script .= PHP_EOL . $this->_t(4) . "\$" . $code . "_Updated = \$db->updateObject('#__content_types', \$" . $code . ", 'type_id');";
							$script .= PHP_EOL . $this->_t(3) . "}";
							$script .= PHP_EOL . $this->_t(3) . "else";
							$script .= PHP_EOL . $this->_t(3) . "{";
						}
						$script .= PHP_EOL . $this->_t(3) . $taabb . "\$" . $code . "_Inserted = \$db->insertObject('#__content_types', \$" . $code . ");";
						if ($action === 'update')
						{
							$script .= PHP_EOL . $this->_t(3) . "}";
						}
					}
				}
				$script .= PHP_EOL . PHP_EOL;
			}
		}
		return $script;
	}

	public function setPostInstallScript()
	{
		// reset script
		$script = $this->setComponentToContentTypes('install');

		// set the component name
		$component = $this->componentCodeName;

		// add the assets table update for permissions rules
		if (isset($this->assetsRules) && ComponentbuilderHelper::checkArray($this->assetsRules))
		{
			if (ComponentbuilderHelper::checkString($script))
			{
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Install the global extenstion assets permission.";
			}
			else
			{
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Install the global extenstion assets permission.";
				$script .= PHP_EOL . $this->_t(3) . "\$db = JFactory::getDbo();";
			}
			$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Field to update.";
			$script .= PHP_EOL . $this->_t(3) . "\$fields = array(";
			$script .= PHP_EOL . $this->_t(4) . "\$db->quoteName('rules') . ' = ' . \$db->quote('{" . implode(',', $this->assetsRules) . "}'),";
			$script .= PHP_EOL . $this->_t(3) . ");";
			$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Condition.";
			$script .= PHP_EOL . $this->_t(3) . "\$conditions = array(";
			$script .= PHP_EOL . $this->_t(4) . "\$db->quoteName('name') . ' = ' . \$db->quote('com_" . $component . "')";
			$script .= PHP_EOL . $this->_t(3) . ");";
			$script .= PHP_EOL . $this->_t(3) . "\$query->update(\$db->quoteName('#__assets'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . $this->_t(3) . "\$allDone = \$db->execute();" . PHP_EOL;
		}
		// add the global params for the component global settings
		if (isset($this->extensionsParams) && ComponentbuilderHelper::checkArray($this->extensionsParams))
		{
			if (ComponentbuilderHelper::checkString($script))
			{
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Install the global extenstion params.";
			}
			else
			{
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Install the global extenstion params.";
				$script .= PHP_EOL . $this->_t(3) . "\$db = JFactory::getDbo();";
			}
			$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Field to update.";
			$script .= PHP_EOL . $this->_t(3) . "\$fields = array(";
			$script .= PHP_EOL . $this->_t(4) . "\$db->quoteName('params') . ' = ' . \$db->quote('{" . implode(',', $this->extensionsParams) . "}'),";
			$script .= PHP_EOL . $this->_t(3) . ");";
			$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Condition.";
			$script .= PHP_EOL . $this->_t(3) . "\$conditions = array(";
			$script .= PHP_EOL . $this->_t(4) . "\$db->quoteName('element') . ' = ' . \$db->quote('com_" . $component . "')";
			$script .= PHP_EOL . $this->_t(3) . ");";
			$script .= PHP_EOL . $this->_t(3) . "\$query->update(\$db->quoteName('#__extensions'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . $this->_t(3) . "\$allDone = \$db->execute();" . PHP_EOL;
		}
		// add the custom script
		$script .= $this->getCustomScriptBuilder('php_postflight', 'install', PHP_EOL . PHP_EOL, null, true);
		// add the component install notice
		if (ComponentbuilderHelper::checkString($script))
		{
			$script .= PHP_EOL . $this->_t(3) . 'echo \'<a target="_blank" href="' . $this->fileContentStatic[$this->hhh . 'AUTHORWEBSITE' . $this->hhh] . '" title="' . $this->fileContentStatic[$this->hhh . 'Component_name' . $this->hhh] . '">';
			$script .= PHP_EOL . $this->_t(4) . '<img src="components/com_' . $component . '/assets/images/vdm-component.' . $this->componentImageType . '"/>';
			$script .= PHP_EOL . $this->_t(4) . '</a>\';';

			return $script;
		}
		return PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " noting to install.";
	}

	public function setPostUpdateScript()
	{
		// reset script
		$script = $this->setComponentToContentTypes('update');
		// add the custom script
		$script .= $this->getCustomScriptBuilder('php_postflight', 'update', PHP_EOL . PHP_EOL, null, true);
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$script .= PHP_EOL . $this->_t(3) . 'echo \'<a target="_blank" href="' . $this->fileContentStatic[$this->hhh . 'AUTHORWEBSITE' . $this->hhh] . '" title="' . $this->fileContentStatic[$this->hhh . 'Component_name' . $this->hhh] . '">';
			$script .= PHP_EOL . $this->_t(4) . '<img src="components/com_' . $this->componentCodeName . '/assets/images/vdm-component.' . $this->componentImageType . '"/>';
			$script .= PHP_EOL . $this->_t(4) . '</a>';
			$script .= PHP_EOL . $this->_t(4) . "<h3>Upgrade to Version " . $this->fileContentStatic[$this->hhh . 'ACTUALVERSION' . $this->hhh] . " Was Successful! Let us know if anything is not working as expected.</h3>';";
		}

		if (ComponentbuilderHelper::checkString($script))
		{
			return $script;
		}
		return PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " noting to update.";
	}

	public function setUninstallScript()
	{
		// reset script
		$script = '';
		if (isset($this->uninstallScriptBuilder) && ComponentbuilderHelper::checkArray($this->uninstallScriptBuilder))
		{
			$component = $this->componentCodeName;
			// start loading the data to delet
			$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get Application object";
			$script .= PHP_EOL . $this->_t(2) . "\$app = JFactory::getApplication();";
			$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get The Database object";
			$script .= PHP_EOL . $this->_t(2) . "\$db = JFactory::getDbo();";

			foreach ($this->uninstallScriptBuilder as $viewName => $typeAlias)
			{
				// set a var value
				$view = ComponentbuilderHelper::safeString($viewName);

				// check if it has field relations
				if (isset($this->uninstallScriptFields) && isset($this->uninstallScriptFields[$viewName]))
				{
					// First check if data is till in table
					$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
					$script .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select ids from fields";
					$script .= PHP_EOL . $this->_t(2) . "\$query->select(\$db->quoteName('id'));";
					$script .= PHP_EOL . $this->_t(2) . "\$query->from(\$db->quoteName('#__fields'));";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Where " . $viewName . " context is found";
					$script .= PHP_EOL . $this->_t(2) . "\$query->where( \$db->quoteName('context') . ' = '. \$db->quote('" . $typeAlias . "') );";
					$script .= PHP_EOL . $this->_t(2) . "\$db->setQuery(\$query);";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Execute query to see if context is found";
					$script .= PHP_EOL . $this->_t(2) . "\$db->execute();";
					$script .= PHP_EOL . $this->_t(2) . "\$" . $view . "_found = \$db->getNumRows();";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Now check if there were any rows";
					$script .= PHP_EOL . $this->_t(2) . "if (\$" . $view . "_found)";
					$script .= PHP_EOL . $this->_t(2) . "{";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Since there are load the needed  " . $view . " field ids";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_field_ids = \$db->loadColumn();";

					// Now remove the actual type entry
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove " . $viewName . " from the field table";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_condition = array( \$db->quoteName('context') . ' = '. \$db->quote('" . $typeAlias . "') );";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
					$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . $this->_t(3) . "\$query->delete(\$db->quoteName('#__fields'));";
					$script .= PHP_EOL . $this->_t(3) . "\$query->where(\$" . $view . "_condition);";
					$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " items";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_done = \$db->execute();";
					$script .= PHP_EOL . $this->_t(3) . "if (\$" . $view . "_done)";
					$script .= PHP_EOL . $this->_t(3) . "{";
					$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " If succesfully remove " . $viewName . " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . $this->_t(4) . "\$app->enqueueMessage(JText:" . ":_('The fields with type (" . $typeAlias . ") context was removed from the <b>#__fields</b> table'));";
					$script .= PHP_EOL . $this->_t(3) . "}";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Also Remove " . $viewName . " field values";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_condition = array( \$db->quoteName('field_id') . ' IN ('. implode(',', \$" . $view . "_field_ids) .')');";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
					$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . $this->_t(3) . "\$query->delete(\$db->quoteName('#__fields_values'));";
					$script .= PHP_EOL . $this->_t(3) . "\$query->where(\$" . $view . "_condition);";
					$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " field values";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_done = \$db->execute();";
					$script .= PHP_EOL . $this->_t(3) . "if (\$" . $view . "_done)";
					$script .= PHP_EOL . $this->_t(3) . "{";
					$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " If succesfully remove " . $viewName . " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . $this->_t(4) . "\$app->enqueueMessage(JText:" . ":_('The fields values for " . $viewName . " was removed from the <b>#__fields_values</b> table'));";
					$script .= PHP_EOL . $this->_t(3) . "}";
					$script .= PHP_EOL . $this->_t(2) . "}";

					// First check if data is till in table
					$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
					$script .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select ids from field groups";
					$script .= PHP_EOL . $this->_t(2) . "\$query->select(\$db->quoteName('id'));";
					$script .= PHP_EOL . $this->_t(2) . "\$query->from(\$db->quoteName('#__fields_groups'));";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Where " . $viewName . " context is found";
					$script .= PHP_EOL . $this->_t(2) . "\$query->where( \$db->quoteName('context') . ' = '. \$db->quote('" . $typeAlias . "') );";
					$script .= PHP_EOL . $this->_t(2) . "\$db->setQuery(\$query);";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Execute query to see if context is found";
					$script .= PHP_EOL . $this->_t(2) . "\$db->execute();";
					$script .= PHP_EOL . $this->_t(2) . "\$" . $view . "_found = \$db->getNumRows();";
					$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Now check if there were any rows";
					$script .= PHP_EOL . $this->_t(2) . "if (\$" . $view . "_found)";
					$script .= PHP_EOL . $this->_t(2) . "{";

					// Now remove the actual type entry
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove " . $viewName . " from the field groups table";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_condition = array( \$db->quoteName('context') . ' = '. \$db->quote('" . $typeAlias . "') );";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
					$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . $this->_t(3) . "\$query->delete(\$db->quoteName('#__fields_groups'));";
					$script .= PHP_EOL . $this->_t(3) . "\$query->where(\$" . $view . "_condition);";
					$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
					$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " items";
					$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_done = \$db->execute();";
					$script .= PHP_EOL . $this->_t(3) . "if (\$" . $view . "_done)";
					$script .= PHP_EOL . $this->_t(3) . "{";
					$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " If succesfully remove " . $viewName . " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . $this->_t(4) . "\$app->enqueueMessage(JText:" . ":_('The field groups with type (" . $typeAlias . ") context was removed from the <b>#__fields_groups</b> table'));";
					$script .= PHP_EOL . $this->_t(3) . "}";
					$script .= PHP_EOL . $this->_t(2) . "}";
				}
				// First check if data is till in table
				$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
				$script .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select id from content type table";
				$script .= PHP_EOL . $this->_t(2) . "\$query->select(\$db->quoteName('type_id'));";
				$script .= PHP_EOL . $this->_t(2) . "\$query->from(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Where " . $viewName . " alias is found";
				$script .= PHP_EOL . $this->_t(2) . "\$query->where( \$db->quoteName('type_alias') . ' = '. \$db->quote('" . $typeAlias . "') );";
				$script .= PHP_EOL . $this->_t(2) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Execute query to see if alias is found";
				$script .= PHP_EOL . $this->_t(2) . "\$db->execute();";
				$script .= PHP_EOL . $this->_t(2) . "\$" . $view . "_found = \$db->getNumRows();";
				$script .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Now check if there were any rows";
				$script .= PHP_EOL . $this->_t(2) . "if (\$" . $view . "_found)";
				$script .= PHP_EOL . $this->_t(2) . "{";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Since there are load the needed  " . $view . " type ids";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_ids = \$db->loadColumn();";

				// Now remove the actual type entry
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove " . $viewName . " from the content type table";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('" . $typeAlias . "') );";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
				$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . $this->_t(3) . "\$query->delete(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL . $this->_t(3) . "\$query->where(\$" . $view . "_condition);";
				$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " items";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_done = \$db->execute();";
				$script .= PHP_EOL . $this->_t(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . $this->_t(3) . "{";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " If succesfully remove " . $viewName . " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . $this->_t(4) . "\$app->enqueueMessage(JText:" . ":_('The (" . $typeAlias . ") type alias was removed from the <b>#__content_type</b> table'));";
				$script .= PHP_EOL . $this->_t(3) . "}";

				// Now remove the related items from contentitem tag map table
				$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove " . $viewName . " items from the contentitem tag map table";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('" . $typeAlias . "') );";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
				$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . $this->_t(3) . "\$query->delete(\$db->quoteName('#__contentitem_tag_map'));";
				$script .= PHP_EOL . $this->_t(3) . "\$query->where(\$" . $view . "_condition);";
				$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " items";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_done = \$db->execute();";
				$script .= PHP_EOL . $this->_t(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . $this->_t(3) . "{";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " If succesfully remove " . $viewName . " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . $this->_t(4) . "\$app->enqueueMessage(JText:" . ":_('The (" . $typeAlias . ") type alias was removed from the <b>#__contentitem_tag_map</b> table'));";
				$script .= PHP_EOL . $this->_t(3) . "}";

				// Now remove the related items from ucm content table
				$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove " . $viewName . " items from the ucm content table";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_condition = array( \$db->quoteName('core_type_alias') . ' = ' . \$db->quote('" . $typeAlias . "') );";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
				$script .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . $this->_t(3) . "\$query->delete(\$db->quoteName('#__ucm_content'));";
				$script .= PHP_EOL . $this->_t(3) . "\$query->where(\$" . $view . "_condition);";
				$script .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " items";
				$script .= PHP_EOL . $this->_t(3) . "\$" . $view . "_done = \$db->execute();";
				$script .= PHP_EOL . $this->_t(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . $this->_t(3) . "{";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " If succesfully remove " . $viewName . " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . $this->_t(4) . "\$app->enqueueMessage(JText:" . ":_('The (" . $typeAlias . ") type alias was removed from the <b>#__ucm_content</b> table'));";
				$script .= PHP_EOL . $this->_t(3) . "}";

				// setup the foreach loop of ids
				$script .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Make sure that all the " . $viewName . " items are cleared from DB";
				$script .= PHP_EOL . $this->_t(3) . "foreach (\$" . $view . "_ids as \$" . $view . "_id)";
				$script .= PHP_EOL . $this->_t(3) . "{";

				// Now remove the related items from ucm base table
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Remove " . $viewName . " items from the ucm base table";
				$script .= PHP_EOL . $this->_t(4) . "\$" . $view . "_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$" . $view . "_id);";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
				$script .= PHP_EOL . $this->_t(4) . "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . $this->_t(4) . "\$query->delete(\$db->quoteName('#__ucm_base'));";
				$script .= PHP_EOL . $this->_t(4) . "\$query->where(\$" . $view . "_condition);";
				$script .= PHP_EOL . $this->_t(4) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " items";
				$script .= PHP_EOL . $this->_t(4) . "\$db->execute();";

				// Now remove the related items from ucm history table
				$script .= PHP_EOL . PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Remove " . $viewName . " items from the ucm history table";
				$script .= PHP_EOL . $this->_t(4) . "\$" . $view . "_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$" . $view . "_id);";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
				$script .= PHP_EOL . $this->_t(4) . "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . $this->_t(4) . "\$query->delete(\$db->quoteName('#__ucm_history'));";
				$script .= PHP_EOL . $this->_t(4) . "\$query->where(\$" . $view . "_condition);";
				$script .= PHP_EOL . $this->_t(4) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Execute the query to remove " . $viewName . " items";
				$script .= PHP_EOL . $this->_t(4) . "\$db->execute();";

				$script .= PHP_EOL . $this->_t(3) . "}";

				$script .= PHP_EOL . $this->_t(2) . "}";
			}

			$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " If All related items was removed queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL . $this->_t(2) . "\$app->enqueueMessage(JText:" . ":_('All related items was removed from the <b>#__ucm_base</b> table'));";
			$script .= PHP_EOL . $this->_t(2) . "\$app->enqueueMessage(JText:" . ":_('All related items was removed from the <b>#__ucm_history</b> table'));";
			// finaly remove the assets from the assets table
			$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Remove " . $component . " assets from the assets table";
			$script .= PHP_EOL . $this->_t(2) . "\$" . $component . "_condition = array( \$db->quoteName('name') . ' LIKE ' . \$db->quote('com_" . $component . "%') );";
			$script .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
			$script .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . $this->_t(2) . "\$query->delete(\$db->quoteName('#__assets'));";
			$script .= PHP_EOL . $this->_t(2) . "\$query->where(\$" . $component . "_condition);";
			$script .= PHP_EOL . $this->_t(2) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . $this->_t(2) . "\$" . $view . "_done = \$db->execute();";
			$script .= PHP_EOL . $this->_t(2) . "if (\$" . $view . "_done)";
			$script .= PHP_EOL . $this->_t(2) . "{";
			$script .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " If succesfully remove " . $component . " add queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL . $this->_t(3) . "\$app->enqueueMessage(JText:" . ":_('All related items was removed from the <b>#__assets</b> table'));";
			$script .= PHP_EOL . $this->_t(2) . "}";
			// done
			$script .= PHP_EOL;
		}
		// add the custom uninstall script
		$script .= $this->getCustomScriptBuilder('php_method', 'uninstall', "", null, true, null, PHP_EOL);
		return $script;
	}

	public function setMoveFolderScript()
	{
		if ($this->setMoveFolders)
		{
			// reset script
			$script = array();
			$script[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " We check if we have dynamic folders to copy";
			$script[] = $this->_t(2) . "\$this->setDynamicF0ld3rs(\$app, \$parent);";
			// done
			return PHP_EOL . implode(PHP_EOL, $script);
		}
		return '';
	}

	public function setMoveFolderMethod()
	{
		if ($this->setMoveFolders)
		{
			// reset script
			$script = array();
			$script[] = $this->_t(1) . "/**";
			$script[] = $this->_t(1) . " * Method to set/copy dynamic folders into place (use with caution)";
			$script[] = $this->_t(1) . " *";
			$script[] = $this->_t(1) . " * @return void";
			$script[] = $this->_t(1) . " */";
			$script[] = $this->_t(1) . "protected function setDynamicF0ld3rs(\$app, \$parent)";
			$script[] = $this->_t(1) . "{";
			$script[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get the instalation path";
			$script[] = $this->_t(2) . "\$installer = \$parent->getParent();";
			$script[] = $this->_t(2) . "\$installPath = \$installer->getPath('source');";
			$script[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get all the folders";
			$script[] = $this->_t(2) . "\$folders = JFolder::folders(\$installPath);";
			$script[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if we have folders we may want to copy";
			$script[] = $this->_t(2) . "\$doNotCopy = array('media','admin','site'); // Joomla already deals with these";
			$script[] = $this->_t(2) . "if (count((array) \$folders) > 1)";
			$script[] = $this->_t(2) . "{";
			$script[] = $this->_t(3) . "foreach (\$folders as \$folder)";
			$script[] = $this->_t(3) . "{";
			$script[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Only copy if not a standard folders";
			$script[] = $this->_t(4) . "if (!in_array(\$folder, \$doNotCopy))";
			$script[] = $this->_t(4) . "{";
			$script[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " set the source path";
			$script[] = $this->_t(5) . "\$src = \$installPath.'/'.\$folder;";
			$script[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " set the destination path";
			$script[] = $this->_t(5) . "\$dest = JPATH_ROOT.'/'.\$folder;";
			$script[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " now try to copy the folder";
			$script[] = $this->_t(5) . "if (!JFolder::copy(\$src, \$dest, '', true))";
			$script[] = $this->_t(5) . "{";
			$script[] = $this->_t(6) . "\$app->enqueueMessage('Could not copy '.\$folder.' folder into place, please make sure destination is writable!', 'error');";
			$script[] = $this->_t(5) . "}";
			$script[] = $this->_t(4) . "}";
			$script[] = $this->_t(3) . "}";
			$script[] = $this->_t(2) . "}";
			$script[] = $this->_t(1) . "}";
			// done
			return PHP_EOL . PHP_EOL . implode(PHP_EOL, $script);
		}
		return '';
	}

	public function getContentType($view, $component)
	{
		// add if history is to be kept or if tags is added
		if ((isset($this->historyBuilder[$view]) && ComponentbuilderHelper::checkString($this->historyBuilder[$view])) || (isset($this->tagsBuilder[$view]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$view])))
		{
			// reset array
			$array = array();
			// set needed defaults
			$alias = (array_key_exists($view, $this->aliasBuilder)) ? $this->aliasBuilder[$view] : 'null';
			$title = (array_key_exists($view, $this->titleBuilder)) ? $this->titleBuilder[$view] : 'null';
			$category = (array_key_exists($view, $this->catCodeBuilder)) ? $this->catCodeBuilder[$view]['code'] : 'null';
			$categoryHistory = (array_key_exists($view, $this->catCodeBuilder)) ?
				'{"sourceColumn": "' . $category . '","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},' : '';
			$Component = ComponentbuilderHelper::safeString($component, 'F');
			$View = ComponentbuilderHelper::safeString($view, 'F');
			$maintext = (isset($this->maintextBuilder[$view]) && ComponentbuilderHelper::checkString($this->maintextBuilder[$view])) ? $this->maintextBuilder[$view] : 'null';
			$hiddenFields = (isset($this->hiddenFieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->hiddenFieldsBuilder[$view])) ? $this->hiddenFieldsBuilder[$view] : '';
			$dynamicfields = (isset($this->dynamicfieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->dynamicfieldsBuilder[$view])) ? $this->dynamicfieldsBuilder[$view] : '';
			$intFields = (isset($this->intFieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->intFieldsBuilder[$view])) ? $this->intFieldsBuilder[$view] : '';
			$customfieldlinks = (isset($this->customFieldLinksBuilder[$view]) && ComponentbuilderHelper::checkString($this->customFieldLinksBuilder[$view])) ? $this->customFieldLinksBuilder[$view] : '';
			// build uninstall script for content types
			$this->uninstallScriptBuilder[$View] = 'com_' . $component . '.' . $view;
			$this->uninstallScriptContent[$view] = $view;
			// check if this view has metadata
			if (isset($this->metadataBuilder[$view]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view]))
			{
				$core_metadata = 'metadata';
				$core_metakey = 'metakey';
				$core_metadesc = 'metadesc';
			}
			else
			{
				$core_metadata = 'null';
				$core_metakey = 'null';
				$core_metadesc = 'null';
			}
			// check if view has access
			if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
			{
				$core_access = 'access';
				$accessHistory = ',{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"}';
			}
			else
			{
				$core_access = 'null';
				$accessHistory = '';
			}
			// set the title
			$array['type_title'] = $Component . ' ' . $View;
			// set the alias
			$array['type_alias'] = 'com_' . $component . '.' . $view;
			// set the table
			$array['table'] = '{"special": {"dbtable": "#__' . $component . '_' . $view . '","key": "id","type": "' . $View . '","prefix": "' . $component . 'Table","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			// set field map
			$array['field_mappings'] = '{"common": {"core_content_item_id": "id","core_title": "' . $title . '","core_state": "published","core_alias": "' . $alias . '","core_created_time": "created","core_modified_time": "modified","core_body": "' . $maintext . '","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "' . $core_access . '","core_params": "params","core_featured": "null","core_metadata": "' . $core_metadata . '","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "' . $core_metakey . '","core_metadesc": "' . $core_metadesc . '","core_catid": "' . $category . '","core_xreference": "null","asset_id": "asset_id"},"special": {' . $dynamicfields . '}}';
			// set the router class method
			$array['router'] = $Component . 'HelperRoute::get' . $View . 'Route';
			// set content history
			$array['content_history_options'] = '{"formFile": "administrator/components/com_' . $component . '/models/forms/' . $view . '.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"' . $hiddenFields . '],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"' . $intFields . '],"displayLookup": [' . $categoryHistory . '{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}' . $accessHistory . ',{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}' . $customfieldlinks . ']}';

			return $array;
		}
		return false;
	}

	public function getCategoryContentType($view, $views, $component)
	{
		$category = $this->catCodeBuilder[$view]['code'];
		$Component = ComponentbuilderHelper::safeString($component, 'F');
		$View = ComponentbuilderHelper::safeString($view, 'F');
		// build uninstall script for content types
		$this->uninstallScriptBuilder[$View . ' ' . $category] = 'com_' . $component . '.' . $views . '.category';
		$this->uninstallScriptContent[$View . ' ' . $category] = $View . ' ' . $category;
		// set the title
		$array['type_title'] = $Component . ' ' . $View . ' ' . ComponentbuilderHelper::safeString($category, 'F');
		// set the alias
		$array['type_alias'] = 'com_' . $component . '.' . $views . '.category';
		// set the table
		$array['table'] = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
		// set field map
		$array['field_mappings'] = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
		// set the router class method
		$array['router'] = $Component . 'HelperRoute::getCategoryRoute';
		// set content history
		$array['content_history_options'] = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

		return $array;
	}

	public function setRouterHelp($viewName_single, $viewName_list, $front = false)
	{
		// add if tags is added, also for all front item views
		if (((isset($this->tagsBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$viewName_single])) || $front) && (!in_array($viewName_single, $this->setRouterHelpDone)))
		{
			// insure we load a view only once
			$this->setRouterHelpDone[] = $viewName_single;
			// build view route helper
			$View = ComponentbuilderHelper::safeString($viewName_single, 'F');
			$routeHelper = array();
			$routeHelper[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$routeHelper[] = $this->_t(1) . " * @param int The route of the " . $View;
			$routeHelper[] = $this->_t(1) . " */";
			if ('category' === $viewName_single || 'categories' === $viewName_single)
			{
				$routeHelper[] = $this->_t(1) . "public static function get" . $View . "Route(\$id = 0)";
			}
			else
			{
				$routeHelper[] = $this->_t(1) . "public static function get" . $View . "Route(\$id = 0, \$catid = 0)";
			}
			$routeHelper[] = $this->_t(1) . "{";
			$routeHelper[] = $this->_t(2) . "if (\$id > 0)";
			$routeHelper[] = $this->_t(2) . "{";
			$routeHelper[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Initialize the needel array.";
			$routeHelper[] = $this->_t(3) . "\$needles = array(";
			$routeHelper[] = $this->_t(4) . "'" . $viewName_single . "'  => array((int) \$id)";
			$routeHelper[] = $this->_t(3) . ");";
			$routeHelper[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create the link";
			$routeHelper[] = $this->_t(3) . "\$link = 'index.php?option=com_" . $this->componentCodeName . "&view=" . $viewName_single . "&id='. \$id;";
			$routeHelper[] = $this->_t(2) . "}";
			$routeHelper[] = $this->_t(2) . "else";
			$routeHelper[] = $this->_t(2) . "{";
			$routeHelper[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Initialize the needel array.";
			$routeHelper[] = $this->_t(3) . "\$needles = array(";
			$routeHelper[] = $this->_t(4) . "'" . $viewName_single . "'  => array()";
			$routeHelper[] = $this->_t(3) . ");";
			$routeHelper[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create the link but don't add the id.";
			$routeHelper[] = $this->_t(3) . "\$link = 'index.php?option=com_" . $this->componentCodeName . "&view=" . $viewName_single . "';";
			$routeHelper[] = $this->_t(2) . "}";
			if ('category' != $viewName_single && 'categories' != $viewName_single)
			{
				$routeHelper[] = $this->_t(2) . "if (\$catid > 1)";
				$routeHelper[] = $this->_t(2) . "{";
				$routeHelper[] = $this->_t(3) . "\$categories = JCategories::getInstance('" . $this->componentCodeName . "." . $viewName_list . "');";
				$routeHelper[] = $this->_t(3) . "\$category = \$categories->get(\$catid);";
				$routeHelper[] = $this->_t(3) . "if (\$category)";
				$routeHelper[] = $this->_t(3) . "{";
				$routeHelper[] = $this->_t(4) . "\$needles['category'] = array_reverse(\$category->getPath());";
				$routeHelper[] = $this->_t(4) . "\$needles['categories'] = \$needles['category'];";
				$routeHelper[] = $this->_t(4) . "\$link .= '&catid='.\$catid;";
				$routeHelper[] = $this->_t(3) . "}";
				$routeHelper[] = $this->_t(2) . "}";
			}
			if (isset($this->hasMenuGlobal[$viewName_single]))
			{
				$routeHelper[] = PHP_EOL . $this->_t(2) . "if (\$item = self::_findItem(\$needles, '" . $viewName_single . "'))";
			}
			else
			{
				$routeHelper[] = PHP_EOL . $this->_t(2) . "if (\$item = self::_findItem(\$needles))";
			}
			$routeHelper[] = $this->_t(2) . "{";
			$routeHelper[] = $this->_t(3) . "\$link .= '&Itemid='.\$item;";
			$routeHelper[] = $this->_t(2) . "}";
			$routeHelper[] = PHP_EOL . $this->_t(2) . "return \$link;";
			$routeHelper[] = $this->_t(1) . "}";

			return implode(PHP_EOL, $routeHelper);
		}
		return '';
	}

	public function routerParseSwitch(&$view, $viewArray = null, $aliasView = true, $idView = true)
	{
		// reset buckets
		$routerSwitch = array();
		$isCategory = '';
		$viewTable = false;
		if ($viewArray && ComponentbuilderHelper::checkArray($viewArray) && isset($viewArray['settings']) && isset($viewArray['settings']->main_get))
		{
			// check if we have custom script for this router parse switch case
			if (isset($viewArray['settings']->main_get->add_php_router_parse) && $viewArray['settings']->main_get->add_php_router_parse == 1 && isset($viewArray['settings']->main_get->php_router_parse) && ComponentbuilderHelper::checkString($viewArray['settings']->main_get->php_router_parse))
			{
				// load the custom script for the switch based on dynamic get
				$routerSwitch[] = PHP_EOL . $this->_t(3) . "case '" . $view . "':";
				$routerSwitch[] = $this->setPlaceholders($viewArray['settings']->main_get->php_router_parse, $this->placeholders);
				$routerSwitch[] = $this->_t(4) . "break;";

				return implode(PHP_EOL, $routerSwitch);
			}
			// is this a catogory
			elseif (isset($viewArray['settings']->main_get->db_table_main) && $viewArray['settings']->main_get->db_table_main === 'categories')
			{
				$isCategory = ', true'; // TODO we will keep an eye on this....
			}
			// get the main table name
			elseif (isset($viewArray['settings']->main_get->main_get) && ComponentbuilderHelper::checkArray($viewArray['settings']->main_get->main_get))
			{
				foreach ($viewArray['settings']->main_get->main_get as $get)
				{
					if (isset($get['as']) && $get['as'] === 'a')
					{
						if (isset($get['selection']) && ComponentbuilderHelper::checkArray($get['selection']) && isset($get['selection']['select_gets']) && ComponentbuilderHelper::checkArray($get['selection']['select_gets']))
						{
							if (isset($get['selection']['table']))
							{
								$viewTable = str_replace('#__' . $this->componentCodeName . '_', '', $get['selection']['table']);
							}
						}
						break;
					}
				}
			}
		}
		// add if tags is added, also for all front item views
		if ($aliasView)
		{
			$routerSwitch[] = PHP_EOL . $this->_t(3) . "case '" . $view . "':";
			$routerSwitch[] = $this->_t(4) . "\$vars['view'] = '" . $view . "';";
			$routerSwitch[] = $this->_t(4) . "if (is_numeric(\$segments[\$count-1]))";
			$routerSwitch[] = $this->_t(4) . "{";
			$routerSwitch[] = $this->_t(5) . "\$vars['id'] = (int) \$segments[\$count-1];";
			$routerSwitch[] = $this->_t(4) . "}";
			$routerSwitch[] = $this->_t(4) . "elseif (\$segments[\$count-1])";
			$routerSwitch[] = $this->_t(4) . "{";
			// we need to get from the table of this views main get the alias so we need the table name
			if ($viewTable)
			{
				$routerSwitch[] = $this->_t(5) . "\$id = \$this->getVar('" . $viewTable . "', \$segments[\$count-1], 'alias', 'id'" . $isCategory . ");";
			}
			else
			{
				$routerSwitch[] = $this->_t(5) . "\$id = \$this->getVar('" . $view . "', \$segments[\$count-1], 'alias', 'id'" . $isCategory . ");";
			}
			$routerSwitch[] = $this->_t(5) . "if(\$id)";
			$routerSwitch[] = $this->_t(5) . "{";
			$routerSwitch[] = $this->_t(6) . "\$vars['id'] = \$id;";
			$routerSwitch[] = $this->_t(5) . "}";
			$routerSwitch[] = $this->_t(4) . "}";
			$routerSwitch[] = $this->_t(4) . "break;";
		}
		elseif ($idView)
		{
			$routerSwitch[] = PHP_EOL . $this->_t(3) . "case '" . $view . "':";
			$routerSwitch[] = $this->_t(4) . "\$vars['view'] = '" . $view . "';";
			$routerSwitch[] = $this->_t(4) . "if (is_numeric(\$segments[\$count-1]))";
			$routerSwitch[] = $this->_t(4) . "{";
			$routerSwitch[] = $this->_t(5) . "\$vars['id'] = (int) \$segments[\$count-1];";
			$routerSwitch[] = $this->_t(4) . "}";
			$routerSwitch[] = $this->_t(4) . "break;";
		}
		else
		{
			$routerSwitch[] = PHP_EOL . $this->_t(3) . "case '" . $view . "':";
			$routerSwitch[] = $this->_t(4) . "\$vars['view'] = '" . $view . "';";
			$routerSwitch[] = $this->_t(4) . "break;";
		}

		return implode(PHP_EOL, $routerSwitch);
	}

	public function routerBuildViews(&$view)
	{
		if (isset($this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh]) && ComponentbuilderHelper::checkString($this->fileContentStatic[$this->hhh . 'ROUTER_BUILD_VIEWS' . $this->hhh]))
		{
			return " || \$view === '" . $view . "'";
		}
		else
		{
			return "\$view === '" . $view . "'";
		}
	}

	public function setBatchMove($viewName_single)
	{
		// set needed defaults
		$category = false;
		$batchmove = array();
		$VIEW = ComponentbuilderHelper::safeString($viewName_single, 'U');
		// component helper name
		$Helper = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper';
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// only load category if set in this view
		if (array_key_exists($viewName_single, $this->catCodeBuilder))
		{
			$category = $this->catCodeBuilder[$viewName_single]['code'];
		}
		// prepare custom script
		$customScript = $this->getCustomScriptBuilder('php_batchmove', $viewName_single, PHP_EOL . PHP_EOL, null, true);

		$batchmove[] = PHP_EOL . $this->_t(1) . "/**";
		$batchmove[] = $this->_t(1) . " * Batch move items to a new category";
		$batchmove[] = $this->_t(1) . " *";
		$batchmove[] = $this->_t(1) . " * @param   integer  \$value     The new category ID.";
		$batchmove[] = $this->_t(1) . " * @param   array    \$pks       An array of row IDs.";
		$batchmove[] = $this->_t(1) . " * @param   array    \$contexts  An array of item contexts.";
		$batchmove[] = $this->_t(1) . " *";
		$batchmove[] = $this->_t(1) . " * @return  boolean  True if successful, false otherwise and internal error is set.";
		$batchmove[] = $this->_t(1) . " *";
		$batchmove[] = $this->_t(1) . " * @since 12.2";
		$batchmove[] = $this->_t(1) . " */";
		$batchmove[] = $this->_t(1) . "protected function batchMove(\$values, \$pks, \$contexts)";
		$batchmove[] = $this->_t(1) . "{";
		$batchmove[] = $this->_t(2) . "if (empty(\$this->batchSet))";
		$batchmove[] = $this->_t(2) . "{";
		$batchmove[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set some needed variables.";
		$batchmove[] = $this->_t(3) . "\$this->user		= JFactory::getUser();";
		$batchmove[] = $this->_t(3) . "\$this->table		= \$this->getTable();";
		$batchmove[] = $this->_t(3) . "\$this->tableClassName	= get_class(\$this->table);";
		$batchmove[] = $this->_t(3) . "\$this->canDo		= " . $Helper . "::getActions('" . $viewName_single . "');";
		$batchmove[] = $this->_t(2) . "}";

		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit']]))
		{
			$batchmove[] = PHP_EOL . $this->_t(2) . "if (!\$this->canDo->get('" . $core['core.edit'] . "') && !\$this->canDo->get('" . $core['core.batch'] . "'))";
		}
		else
		{
			$batchmove[] = PHP_EOL . $this->_t(2) . "if (!\$this->canDo->get('core.edit') && !\$this->canDo->get('core.batch'))";
		}
		$batchmove[] = $this->_t(2) . "{";
		$batchmove[] = $this->_t(3) . "\$this->setError(JText:" . ":_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";
		$batchmove[] = $this->_t(3) . "return false;";
		$batchmove[] = $this->_t(2) . "}" . $customScript;

		$batchmove[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " make sure published only updates if user has the permission.";
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$batchmove[] = $this->_t(2) . "if (isset(\$values['published']) && !\$this->canDo->get('" . $core['core.edit.state'] . "'))";
		}
		else
		{
			$batchmove[] = $this->_t(2) . "if (isset(\$values['published']) && !\$this->canDo->get('core.edit.state'))";
		}
		$batchmove[] = $this->_t(2) . "{";
		$batchmove[] = $this->_t(3) . "unset(\$values['published']);";
		$batchmove[] = $this->_t(2) . "}";

		$batchmove[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " remove move_copy from array";
		$batchmove[] = $this->_t(2) . "unset(\$values['move_copy']);";

		if ($category)
		{
			$batchmove[] = PHP_EOL . $this->_t(2) . "if (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchmove[] = $this->_t(2) . "{";
			$batchmove[] = $this->_t(3) . "return false;";
			$batchmove[] = $this->_t(2) . "}";
			$batchmove[] = $this->_t(2) . "elseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchmove[] = $this->_t(2) . "{";
			$batchmove[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " move the category value to correct field name";
			$batchmove[] = $this->_t(3) . "\$values['" . $category . "'] = \$values['category'];";
			$batchmove[] = $this->_t(3) . "unset(\$values['category']);";
			$batchmove[] = $this->_t(2) . "}";
			$batchmove[] = $this->_t(2) . "elseif (isset(\$values['category']))";
			$batchmove[] = $this->_t(2) . "{";
			$batchmove[] = $this->_t(3) . "unset(\$values['category']);";
			$batchmove[] = $this->_t(2) . "}" . PHP_EOL;
		}

		$batchmove[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Parent exists so we proceed";
		$batchmove[] = $this->_t(2) . "foreach (\$pks as \$pk)";
		$batchmove[] = $this->_t(2) . "{";
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit']]))
		{
			$batchmove[] = $this->_t(3) . "if (!\$this->user->authorise('" . $core['core.edit'] . "', \$contexts[\$pk]))";
		}
		else
		{
			$batchmove[] = $this->_t(3) . "if (!\$this->user->authorise('core.edit', \$contexts[\$pk]))";
		}
		$batchmove[] = $this->_t(3) . "{";
		$batchmove[] = $this->_t(4) . "\$this->setError(JText:" . ":_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";

		$batchmove[] = $this->_t(4) . "return false;";
		$batchmove[] = $this->_t(3) . "}";

		$batchmove[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Check that the row actually exists";
		$batchmove[] = $this->_t(3) . "if (!\$this->table->load(\$pk))";
		$batchmove[] = $this->_t(3) . "{";
		$batchmove[] = $this->_t(4) . "if (\$error = \$this->table->getError())";
		$batchmove[] = $this->_t(4) . "{";
		$batchmove[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " Fatal error";
		$batchmove[] = $this->_t(5) . "\$this->setError(\$error);";

		$batchmove[] = $this->_t(5) . "return false;";
		$batchmove[] = $this->_t(4) . "}";
		$batchmove[] = $this->_t(4) . "else";
		$batchmove[] = $this->_t(4) . "{";
		$batchmove[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " Not fatal error";
		$batchmove[] = $this->_t(5) . "\$this->setError(JText:" . ":sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchmove[] = $this->_t(5) . "continue;";
		$batchmove[] = $this->_t(4) . "}";
		$batchmove[] = $this->_t(3) . "}";

		$batchmove[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " insert all set values.";
		$batchmove[] = $this->_t(3) . "if (" . $Helper . "::checkArray(\$values))";
		$batchmove[] = $this->_t(3) . "{";
		$batchmove[] = $this->_t(4) . "foreach (\$values as \$key => \$value)";
		$batchmove[] = $this->_t(4) . "{";
		$batchmove[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " Do special action for access.";
		$batchmove[] = $this->_t(5) . "if ('access' === \$key && strlen(\$value) > 0)";
		$batchmove[] = $this->_t(5) . "{";
		$batchmove[] = $this->_t(6) . "\$this->table->\$key = \$value;";
		$batchmove[] = $this->_t(5) . "}";
		$batchmove[] = $this->_t(5) . "elseif (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchmove[] = $this->_t(5) . "{";
		$batchmove[] = $this->_t(6) . "\$this->table->\$key = \$value;";
		$batchmove[] = $this->_t(5) . "}";
		$batchmove[] = $this->_t(4) . "}";
		$batchmove[] = $this->_t(3) . "}" . PHP_EOL;

		$batchmove[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Check the row.";
		$batchmove[] = $this->_t(3) . "if (!\$this->table->check())";
		$batchmove[] = $this->_t(3) . "{";
		$batchmove[] = $this->_t(4) . "\$this->setError(\$this->table->getError());";

		$batchmove[] = PHP_EOL . $this->_t(4) . "return false;";
		$batchmove[] = $this->_t(3) . "}";

		$batchmove[] = PHP_EOL . $this->_t(3) . "if (!empty(\$this->type))";
		$batchmove[] = $this->_t(3) . "{";
		$batchmove[] = $this->_t(4) . "\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchmove[] = $this->_t(3) . "}";

		$batchmove[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Store the row.";
		$batchmove[] = $this->_t(3) . "if (!\$this->table->store())";
		$batchmove[] = $this->_t(3) . "{";
		$batchmove[] = $this->_t(4) . "\$this->setError(\$this->table->getError());";

		$batchmove[] = PHP_EOL . $this->_t(4) . "return false;";
		$batchmove[] = $this->_t(3) . "}";
		$batchmove[] = $this->_t(2) . "}";

		$batchmove[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Clean the cache";
		$batchmove[] = $this->_t(2) . "\$this->cleanCache();";

		$batchmove[] = PHP_EOL . $this->_t(2) . "return true;";
		$batchmove[] = $this->_t(1) . "}";

		return PHP_EOL . implode(PHP_EOL, $batchmove);
	}

	public function setBatchCopy($viewName_single)
	{
		// set needed defaults
		$title = false;
		$titles = array();
		$alias = false;
		$category = false;
		$batchcopy = array();
		$VIEW = ComponentbuilderHelper::safeString($viewName_single, 'U');
		// component helper name
		$Helper = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper';
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// only load category if set in this view
		if (array_key_exists($viewName_single, $this->catCodeBuilder))
		{
			$category = $this->catCodeBuilder[$viewName_single]['code'];
		}

		// only load alias if set in this view
		if (array_key_exists($viewName_single, $this->aliasBuilder))
		{
			$alias = $this->aliasBuilder[$viewName_single];
		}
		// only load title if set in this view
		if (isset($this->customAliasBuilder[$viewName_single]))
		{
			$titles = array_values($this->customAliasBuilder[$viewName_single]);
			$title = true;
		}
		elseif (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$titles = array($this->titleBuilder[$viewName_single]);
			$title = true;
		}
		// se the dynamic title
		if ($title)
		{
			// reset the bucket
			$titleData = array();
			// load the dynamic title builder
			foreach ($titles as $_title)
			{
				$titleData[] = "\$this->table->" . $_title;
			}
		}
		// prepare custom script
		$customScript = $this->getCustomScriptBuilder('php_batchcopy', $viewName_single, PHP_EOL . PHP_EOL, null, true);

		$batchcopy[] = PHP_EOL . $this->_t(1) . "/**";
		$batchcopy[] = $this->_t(1) . " * Batch copy items to a new category or current.";
		$batchcopy[] = $this->_t(1) . " *";
		$batchcopy[] = $this->_t(1) . " * @param   integer  \$values    The new values.";
		$batchcopy[] = $this->_t(1) . " * @param   array    \$pks       An array of row IDs.";
		$batchcopy[] = $this->_t(1) . " * @param   array    \$contexts  An array of item contexts.";
		$batchcopy[] = $this->_t(1) . " *";
		$batchcopy[] = $this->_t(1) . " * @return  mixed  An array of new IDs on success, boolean false on failure.";
		$batchcopy[] = $this->_t(1) . " *";
		$batchcopy[] = $this->_t(1) . " * @since 12.2";
		$batchcopy[] = $this->_t(1) . " */";
		$batchcopy[] = $this->_t(1) . "protected function batchCopy(\$values, \$pks, \$contexts)";
		$batchcopy[] = $this->_t(1) . "{";

		$batchcopy[] = $this->_t(2) . "if (empty(\$this->batchSet))";
		$batchcopy[] = $this->_t(2) . "{";
		$batchcopy[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set some needed variables.";
		$batchcopy[] = $this->_t(3) . "\$this->user 		= JFactory::getUser();";
		$batchcopy[] = $this->_t(3) . "\$this->table 		= \$this->getTable();";
		$batchcopy[] = $this->_t(3) . "\$this->tableClassName	= get_class(\$this->table);";
		$batchcopy[] = $this->_t(3) . "\$this->canDo		= " . $Helper . "::getActions('" . $viewName_single . "');";
		$batchcopy[] = $this->_t(2) . "}";
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.create']]))
		{
			$batchcopy[] = PHP_EOL . $this->_t(2) . "if (!\$this->canDo->get('" . $core['core.create'] . "') && !\$this->canDo->get('" . $core['core.batch'] . "'))";
		}
		else
		{
			$batchcopy[] = PHP_EOL . $this->_t(2) . "if (!\$this->canDo->get('core.create') || !\$this->canDo->get('core.batch'))";
		}
		$batchcopy[] = $this->_t(2) . "{";
		$batchcopy[] = $this->_t(3) . "return false;";
		$batchcopy[] = $this->_t(2) . "}" . $customScript;

		$batchcopy[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " get list of uniqe fields";
		$batchcopy[] = $this->_t(2) . "\$uniqeFields = \$this->getUniqeFields();";
		$batchcopy[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " remove move_copy from array";
		$batchcopy[] = $this->_t(2) . "unset(\$values['move_copy']);";

		$batchcopy[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " make sure published is set";
		$batchcopy[] = $this->_t(2) . "if (!isset(\$values['published']))";
		$batchcopy[] = $this->_t(2) . "{";
		$batchcopy[] = $this->_t(3) . "\$values['published'] = 0;";
		$batchcopy[] = $this->_t(2) . "}";
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$batchcopy[] = $this->_t(2) . "elseif (isset(\$values['published']) && !\$this->canDo->get('" . $core['core.edit.state'] . "'))";
		}
		else
		{
			$batchcopy[] = $this->_t(2) . "elseif (isset(\$values['published']) && !\$this->canDo->get('core.edit.state'))";
		}
		$batchcopy[] = $this->_t(2) . "{";
		$batchcopy[] = $this->_t(4) . "\$values['published'] = 0;";
		$batchcopy[] = $this->_t(2) . "}";

		if ($category)
		{
			$batchcopy[] = PHP_EOL . $this->_t(2) . "if (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchcopy[] = $this->_t(2) . "{";
			$batchcopy[] = $this->_t(3) . "return false;";
			$batchcopy[] = $this->_t(2) . "}";
			$batchcopy[] = $this->_t(2) . "elseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchcopy[] = $this->_t(2) . "{";
			$batchcopy[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " move the category value to correct field name";
			$batchcopy[] = $this->_t(3) . "\$values['" . $category . "'] = \$values['category'];";
			$batchcopy[] = $this->_t(3) . "unset(\$values['category']);";
			$batchcopy[] = $this->_t(2) . "}";
			$batchcopy[] = $this->_t(2) . "elseif (isset(\$values['category']))";
			$batchcopy[] = $this->_t(2) . "{";
			$batchcopy[] = $this->_t(3) . "unset(\$values['category']);";
			$batchcopy[] = $this->_t(2) . "}";
		}

		$batchcopy[] = PHP_EOL . $this->_t(2) . "\$newIds = array();";

		$batchcopy[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Parent exists so let's proceed";
		$batchcopy[] = $this->_t(2) . "while (!empty(\$pks))";
		$batchcopy[] = $this->_t(2) . "{";
		$batchcopy[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Pop the first ID off the stack";
		$batchcopy[] = $this->_t(3) . "\$pk = array_shift(\$pks);";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "\$this->table->reset();";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " only allow copy if user may edit this item.";
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit']]))
		{
			$batchcopy[] = $this->_t(3) . "if (!\$this->user->authorise('" . $core['core.edit'] . "', \$contexts[\$pk]))";
		}
		else
		{
			$batchcopy[] = $this->_t(3) . "if (!\$this->user->authorise('core.edit', \$contexts[\$pk]))";
		}
		$batchcopy[] = $this->_t(3) . "{";
		$batchcopy[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Not fatal error";
		$batchcopy[] = $this->_t(4) . "\$this->setError(JText:" . ":sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = $this->_t(4) . "continue;";
		$batchcopy[] = $this->_t(3) . "}";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Check that the row actually exists";
		$batchcopy[] = $this->_t(3) . "if (!\$this->table->load(\$pk))";
		$batchcopy[] = $this->_t(3) . "{";
		$batchcopy[] = $this->_t(4) . "if (\$error = \$this->table->getError())";
		$batchcopy[] = $this->_t(4) . "{";
		$batchcopy[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " Fatal error";
		$batchcopy[] = $this->_t(5) . "\$this->setError(\$error);";

		$batchcopy[] = $this->_t(5) . "return false;";
		$batchcopy[] = $this->_t(4) . "}";
		$batchcopy[] = $this->_t(4) . "else";
		$batchcopy[] = $this->_t(4) . "{";
		$batchcopy[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " Not fatal error";
		$batchcopy[] = $this->_t(5) . "\$this->setError(JText:" . ":sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = $this->_t(5) . "continue;";
		$batchcopy[] = $this->_t(4) . "}";
		$batchcopy[] = $this->_t(3) . "}";
		if ($category && $alias === 'alias' && ($title && count($titles) == 1 && in_array('title', $titles)))
		{
			$batchcopy[] = PHP_EOL . $this->_t(3) . "if (isset(\$values['" . $category . "']))";
			$batchcopy[] = $this->_t(3) . "{";
			$batchcopy[] = $this->_t(4) . "static::generateTitle((int) \$values['" . $category . "'], \$this->table);";
			$batchcopy[] = $this->_t(3) . "}";
			$batchcopy[] = $this->_t(3) . "else";
			$batchcopy[] = $this->_t(3) . "{";
			$batchcopy[] = $this->_t(4) . "static::generateTitle((int) \$this->table->" . $category . ", \$this->table);";
			$batchcopy[] = $this->_t(3) . "}";
		}
		elseif ($category && $alias && ($title && count($titles) == 1))
		{
			$batchcopy[] = PHP_EOL . $this->_t(3) . "if (isset(\$values['" . $category . "']))";
			$batchcopy[] = $this->_t(3) . "{";
			$batchcopy[] = $this->_t(4) . "list(\$this->table->" . implode('', $titles) . ", \$this->table->" . $alias . ") = \$this->generateNewTitle(\$values['" . $category . "'], \$this->table->" . $alias . ", \$this->table->" . implode('', $titles) . ");";
			$batchcopy[] = $this->_t(3) . "}";
			$batchcopy[] = $this->_t(3) . "else";
			$batchcopy[] = $this->_t(3) . "{";
			$batchcopy[] = $this->_t(4) . "list(\$this->table->" . implode('', $titles) . ", \$this->table->" . $alias . ") = \$this->generateNewTitle(\$this->table->" . $category . ", \$this->table->" . $alias . ", \$this->table->" . implode('', $titles) . ");";
			$batchcopy[] = $this->_t(3) . "}";
		}
		elseif (!$category && $alias && ($title && count($titles) == 1))
		{
			$batchcopy[] = $this->_t(3) . "list(\$this->table->" . implode('', $titles) . ", \$this->table->" . $alias . ") = \$this->_generateNewTitle(\$this->table->" . $alias . ", \$this->table->" . implode('', $titles) . ");";
		}
		elseif (!$category && $alias && $title)
		{
			$batchcopy[] = $this->_t(3) . "list(" . implode(', ', $titleData) . ", \$this->table->" . $alias . ") = \$this->_generateNewTitle(\$this->table->" . $alias . ", array(" . implode(', ', $titleData) . "));";
		}
		elseif (!$category && !$alias && ($title && count($titles) == 1 && !in_array('user', $titles) && !in_array('jobnumber', $titles))) // TODO [jobnumber] just for one project (not ideal)
		{
			$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Only for strings";
			$batchcopy[] = $this->_t(3) . "if (" . $Helper . "::checkString(\$this->table->" . implode('', $titles) . ") && !is_numeric(\$this->table->" . implode('', $titles) . "))";
			$batchcopy[] = $this->_t(3) . "{";
			$batchcopy[] = $this->_t(4) . "\$this->table->" . implode('', $titles) . " = \$this->generateUniqe('" . implode('', $titles) . "',\$this->table->" . implode('', $titles) . ");";
			$batchcopy[] = $this->_t(3) . "}";
		}

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " insert all set values";
		$batchcopy[] = $this->_t(3) . "if (" . $Helper . "::checkArray(\$values))";
		$batchcopy[] = $this->_t(3) . "{";
		$batchcopy[] = $this->_t(4) . "foreach (\$values as \$key => \$value)";
		$batchcopy[] = $this->_t(4) . "{";
		$batchcopy[] = $this->_t(5) . "if (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchcopy[] = $this->_t(5) . "{";
		$batchcopy[] = $this->_t(6) . "\$this->table->\$key = \$value;";
		$batchcopy[] = $this->_t(5) . "}";
		$batchcopy[] = $this->_t(4) . "}";
		$batchcopy[] = $this->_t(3) . "}" . PHP_EOL;

		$batchcopy[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " update all uniqe fields";
		$batchcopy[] = $this->_t(3) . "if (" . $Helper . "::checkArray(\$uniqeFields))";
		$batchcopy[] = $this->_t(3) . "{";
		$batchcopy[] = $this->_t(4) . "foreach (\$uniqeFields as \$uniqeField)";
		$batchcopy[] = $this->_t(4) . "{";
		$batchcopy[] = $this->_t(5) . "\$this->table->\$uniqeField = \$this->generateUniqe(\$uniqeField,\$this->table->\$uniqeField);";
		$batchcopy[] = $this->_t(4) . "}";
		$batchcopy[] = $this->_t(3) . "}";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Reset the ID because we are making a copy";
		$batchcopy[] = $this->_t(3) . "\$this->table->id = 0;";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " TODO: Deal with ordering?";
		$batchcopy[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " \$this->table->ordering = 1;";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Check the row.";
		$batchcopy[] = $this->_t(3) . "if (!\$this->table->check())";
		$batchcopy[] = $this->_t(3) . "{";
		$batchcopy[] = $this->_t(4) . "\$this->setError(\$this->table->getError());";

		$batchcopy[] = PHP_EOL . $this->_t(4) . "return false;";
		$batchcopy[] = $this->_t(3) . "}";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "if (!empty(\$this->type))";
		$batchcopy[] = $this->_t(3) . "{";
		$batchcopy[] = $this->_t(4) . "\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchcopy[] = $this->_t(3) . "}";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Store the row.";
		$batchcopy[] = $this->_t(3) . "if (!\$this->table->store())";
		$batchcopy[] = $this->_t(3) . "{";
		$batchcopy[] = $this->_t(4) . "\$this->setError(\$this->table->getError());";

		$batchcopy[] = PHP_EOL . $this->_t(4) . "return false;";
		$batchcopy[] = $this->_t(3) . "}";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the new item ID";
		$batchcopy[] = $this->_t(3) . "\$newId = \$this->table->get('id');";

		$batchcopy[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Add the new ID to the array";
		$batchcopy[] = $this->_t(3) . "\$newIds[\$pk] = \$newId;";
		$batchcopy[] = $this->_t(2) . "}";

		$batchcopy[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Clean the cache";
		$batchcopy[] = $this->_t(2) . "\$this->cleanCache();";

		$batchcopy[] = PHP_EOL . $this->_t(2) . "return \$newIds;";
		$batchcopy[] = $this->_t(1) . "}";

		return PHP_EOL . implode(PHP_EOL, $batchcopy);
	}

	public function setAliasTitleFix($viewName_single)
	{
		$fixUniqe = array();
		// only load this if these two items are set
		if (array_key_exists($viewName_single, $this->aliasBuilder) &&
			(array_key_exists($viewName_single, $this->titleBuilder) || isset($this->customAliasBuilder[$viewName_single])))
		{
			// set needed defaults
			$setCategory = false;
			$alias = $this->aliasBuilder[$viewName_single];
			$VIEW = ComponentbuilderHelper::safeString($viewName_single, 'U');
			if (array_key_exists($viewName_single, $this->catCodeBuilder))
			{
				$category = $this->catCodeBuilder[$viewName_single]['code'];
				$setCategory = true;
			}
			// set the title stuff
			if (isset($this->customAliasBuilder[$viewName_single]))
			{
				$titles = array_values($this->customAliasBuilder[$viewName_single]);
				if (isset($this->titleBuilder[$viewName_single]))
				{
					// $titles[] = $this->titleBuilder[$viewName_single]; // TODO this may be unexpected
				}
			}
			else
			{
				$titles = array($this->titleBuilder[$viewName_single]);
			}
			// start building the fix
			$fixUniqe[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Alter the " . implode(', ', $titles) . " for save as copy";
			$fixUniqe[] = $this->_t(2) . "if (\$input->get('task') === 'save2copy')";
			$fixUniqe[] = $this->_t(2) . "{";
			$fixUniqe[] = $this->_t(3) . "\$origTable = clone \$this->getTable();";
			$fixUniqe[] = $this->_t(3) . "\$origTable->load(\$input->getInt('id'));";
			// reset the buckets
			$ifStatment = array();
			$titleVars = array();
			$titleData = array();
			$titleUpdate = array();
			// load the dynamic title builder
			foreach ($titles as $title)
			{
				$ifStatment[] = "\$data['" . $title . "'] == \$origTable->" . $title;
				$titleVars[] = "\$" . $title;
				$titleData[] = "\$data['" . $title . "']";
				$titleUpdate[] = $this->_t(4) . "\$data['" . $title . "'] = \$" . $title . ";";
			}
			$fixUniqe[] = PHP_EOL . $this->_t(3) . "if (" . implode(' || ', $ifStatment) . ")";
			$fixUniqe[] = $this->_t(3) . "{";
			if ($setCategory && count((array) $titles) == 1)
			{
				$fixUniqe[] = $this->_t(4) . "list(" . implode('', $titleVars) . ", \$" . $alias . ") = \$this->generateNewTitle(\$data['" . $category . "'], \$data['" . $alias . "'], " . implode('', $titleData) . ");";
			}
			elseif (count((array) $titles) == 1)
			{
				$fixUniqe[] = $this->_t(4) . "list(" . implode(', ', $titleVars) . ", \$" . $alias . ") = \$this->_generateNewTitle(\$data['" . $alias . "'], " . implode('', $titleData) . ");";
			}
			else
			{
				$fixUniqe[] = $this->_t(4) . "list(" . implode(', ', $titleVars) . ", \$" . $alias . ") = \$this->_generateNewTitle(\$data['" . $alias . "'], array(" . implode(', ', $titleData) . "));";
			}
			$fixUniqe[] = implode("\n", $titleUpdate);
			$fixUniqe[] = $this->_t(4) . "\$data['" . $alias . "'] = \$" . $alias . ";";
			$fixUniqe[] = $this->_t(3) . "}";
			$fixUniqe[] = $this->_t(3) . "else";
			$fixUniqe[] = $this->_t(3) . "{";
			$fixUniqe[] = $this->_t(4) . "if (\$data['" . $alias . "'] == \$origTable->" . $alias . ")";
			$fixUniqe[] = $this->_t(4) . "{";
			$fixUniqe[] = $this->_t(5) . "\$data['" . $alias . "'] = '';";
			$fixUniqe[] = $this->_t(4) . "}";
			$fixUniqe[] = $this->_t(3) . "}";
			$fixUniqe[] = PHP_EOL . $this->_t(3) . "\$data['published'] = 0;";
			$fixUniqe[] = $this->_t(2) . "}";
			$fixUniqe[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Automatic handling of " . $alias . " for empty fields";
			$fixUniqe[] = $this->_t(2) . "if (in_array(\$input->get('task'), array('apply', 'save', 'save2new')) && (int) \$input->get('id') == 0)";
			$fixUniqe[] = $this->_t(2) . "{";
			$fixUniqe[] = $this->_t(3) . "if (\$data['" . $alias . "'] == null || empty(\$data['" . $alias . "']))";
			$fixUniqe[] = $this->_t(3) . "{";
			$fixUniqe[] = $this->_t(4) . "if (JFactory::getConfig()->get('unicodeslugs') == 1)";
			$fixUniqe[] = $this->_t(4) . "{";
			$fixUniqe[] = $this->_t(5) . "\$data['" . $alias . "'] = JFilterOutput::stringURLUnicodeSlug(" . implode(' . " " . ', $titleData) . ");";
			$fixUniqe[] = $this->_t(4) . "}";
			$fixUniqe[] = $this->_t(4) . "else";
			$fixUniqe[] = $this->_t(4) . "{";
			$fixUniqe[] = $this->_t(5) . "\$data['" . $alias . "'] = JFilterOutput::stringURLSafe(" . implode(' . " " . ', $titleData) . ");";
			$fixUniqe[] = $this->_t(4) . "}";
			$fixUniqe[] = PHP_EOL . $this->_t(4) . "\$table = JTable::getInstance('" . $viewName_single . "', '" . $this->componentCodeName . "Table');";
			if ($setCategory && count($titles) == 1)
			{
				$fixUniqe[] = PHP_EOL . $this->_t(4) . "if (\$table->load(array('" . $alias . "' => \$data['" . $alias . "'], '" . $category . "' => \$data['" . $category . "'])) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUniqe[] = $this->_t(4) . "{";
				$fixUniqe[] = $this->_t(5) . "\$msg = JText:" . ":_('COM_" . $this->fileContentStatic[$this->hhh . 'COMPONENT' . $this->hhh] . "_" . $VIEW . "_SAVE_WARNING');";
				$fixUniqe[] = $this->_t(4) . "}";
				$fixUniqe[] = PHP_EOL . $this->_t(4) . "list(" . implode('', $titleVars) . ", \$" . $alias . ") = \$this->generateNewTitle(\$data['" . $category . "'], \$data['" . $alias . "'], " . implode('', $titleData) . ");";
				$fixUniqe[] = $this->_t(4) . "\$data['" . $alias . "'] = \$" . $alias . ";";
			}
			else
			{
				$fixUniqe[] = PHP_EOL . $this->_t(4) . "if (\$table->load(array('" . $alias . "' => \$data['" . $alias . "'])) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUniqe[] = $this->_t(4) . "{";
				$fixUniqe[] = $this->_t(5) . "\$msg = JText:" . ":_('COM_" . $this->fileContentStatic[$this->hhh . 'COMPONENT' . $this->hhh] . "_" . $VIEW . "_SAVE_WARNING');";
				$fixUniqe[] = $this->_t(4) . "}";
				$fixUniqe[] = PHP_EOL . $this->_t(4) . "\$data['" . $alias . "'] = \$this->_generateNewTitle(\$data['" . $alias . "']);";
			}
			$fixUniqe[] = PHP_EOL . $this->_t(4) . "if (isset(\$msg))";
			$fixUniqe[] = $this->_t(4) . "{";
			$fixUniqe[] = $this->_t(5) . "JFactory::getApplication()->enqueueMessage(\$msg, 'warning');";
			$fixUniqe[] = $this->_t(4) . "}";
			$fixUniqe[] = $this->_t(3) . "}";
			$fixUniqe[] = $this->_t(2) . "}";

//			$fixUniqe[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Update alias if still empty at this point";
//			$fixUniqe[] = $this->_t(2) . "if (\$data['" . $alias . "'] == null || empty(\$data['" . $alias . "']))";
//			$fixUniqe[] = $this->_t(2) . "{";
//			$fixUniqe[] = $this->_t(3) . "if (JFactory::getConfig()->get('unicodeslugs') == 1)";
//			$fixUniqe[] = $this->_t(3) . "{";
//			$fixUniqe[] = $this->_t(4) . "\$data['" . $alias . "'] = JFilterOutput::stringURLUnicodeSlug(" . implode(' . " " . ', $titleData) . ");";
//			$fixUniqe[] = $this->_t(3) . "}";
//			$fixUniqe[] = $this->_t(3) . "else";
//			$fixUniqe[] = $this->_t(3) . "{";
//			$fixUniqe[] = $this->_t(4) . "\$data['" . $alias . "'] = JFilterOutput::stringURLSafe(" . implode(' . " " . ', $titleData) . ");";
//			$fixUniqe[] = $this->_t(3) . "}";
//			$fixUniqe[] = $this->_t(2) . "}";
		}
		// handel other uniqe fields
		$fixUniqe[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Alter the uniqe field for save as copy";
		$fixUniqe[] = $this->_t(2) . "if (\$input->get('task') === 'save2copy')";
		$fixUniqe[] = $this->_t(2) . "{";
		$fixUniqe[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Automatic handling of other uniqe fields";
		$fixUniqe[] = $this->_t(3) . "\$uniqeFields = \$this->getUniqeFields();";
		$fixUniqe[] = $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$uniqeFields))";
		$fixUniqe[] = $this->_t(3) . "{";
		$fixUniqe[] = $this->_t(4) . "foreach (\$uniqeFields as \$uniqeField)";
		$fixUniqe[] = $this->_t(4) . "{";
		$fixUniqe[] = $this->_t(5) . "\$data[\$uniqeField] = \$this->generateUniqe(\$uniqeField,\$data[\$uniqeField]);";
		$fixUniqe[] = $this->_t(4) . "}";
		$fixUniqe[] = $this->_t(3) . "}";
		$fixUniqe[] = $this->_t(2) . "}";

		return PHP_EOL . implode(PHP_EOL, $fixUniqe);
	}

	public function setGenerateNewTitle($viewName_single)
	{
		// if category is added to this view then do nothing
		if (array_key_exists($viewName_single, $this->aliasBuilder) &&
			(array_key_exists($viewName_single, $this->titleBuilder) || isset($this->customAliasBuilder[$viewName_single])))
		{
			// get component name
			$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
			// rest the new function
			$newFunction = array();
			$newFunction[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$newFunction[] = $this->_t(1) . " * Method to change the title/s & alias.";
			$newFunction[] = $this->_t(1) . " *";
			$newFunction[] = $this->_t(1) . " * @param   string         \$alias        The alias.";
			$newFunction[] = $this->_t(1) . " * @param   string/array   \$title        The title.";
			$newFunction[] = $this->_t(1) . " *";
			$newFunction[] = $this->_t(1) . " * @return	array/string  Contains the modified title/s and/or alias.";
			$newFunction[] = $this->_t(1) . " *";
			$newFunction[] = $this->_t(1) . " */";
			$newFunction[] = $this->_t(1) . "protected function _generateNewTitle(\$alias, \$title = null)";
			$newFunction[] = $this->_t(1) . "{";
			$newFunction[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Alter the title/s & alias";
			$newFunction[] = $this->_t(2) . "\$table = \$this->getTable();";
			$newFunction[] = PHP_EOL . $this->_t(2) . "while (\$table->load(array('alias' => \$alias)))";
			$newFunction[] = $this->_t(2) . "{";
			$newFunction[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Check if this is an array of titles";
			$newFunction[] = $this->_t(3) . "if (" . $Component . "Helper::checkArray(\$title))";
			$newFunction[] = $this->_t(3) . "{";
			$newFunction[] = $this->_t(4) . "foreach(\$title as \$nr => &\$_title)";
			$newFunction[] = $this->_t(4) . "{";
			$newFunction[] = $this->_t(5) . "\$_title = JString::increment(\$_title);";
			$newFunction[] = $this->_t(4) . "}";
			$newFunction[] = $this->_t(3) . "}";
			$newFunction[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Make sure we have a title";
			$newFunction[] = $this->_t(3) . "elseif (\$title)";
			$newFunction[] = $this->_t(3) . "{";
			$newFunction[] = $this->_t(4) . "\$title = JString::increment(\$title);";
			$newFunction[] = $this->_t(3) . "}";
			$newFunction[] = $this->_t(3) . "\$alias = JString::increment(\$alias, 'dash');";
			$newFunction[] = $this->_t(2) . "}";
			$newFunction[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check if this is an array of titles";
			$newFunction[] = $this->_t(2) . "if (" . $Component . "Helper::checkArray(\$title))";
			$newFunction[] = $this->_t(2) . "{";
			$newFunction[] = $this->_t(3) . "\$title[] = \$alias;";
			$newFunction[] = $this->_t(3) . "return \$title;";
			$newFunction[] = $this->_t(2) . "}";
			$newFunction[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Make sure we have a title";
			$newFunction[] = $this->_t(2) . "elseif (\$title)";
			$newFunction[] = $this->_t(2) . "{";
			$newFunction[] = $this->_t(3) . "return array(\$title, \$alias);";
			$newFunction[] = $this->_t(2) . "}";
			$newFunction[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " We only had an alias";
			$newFunction[] = $this->_t(2) . "return \$alias;";
			$newFunction[] = $this->_t(1) . "}";
			return implode(PHP_EOL, $newFunction);
		}
		elseif (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$newFunction = array();
			$newFunction[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$newFunction[] = $this->_t(1) . " * Method to change the title";
			$newFunction[] = $this->_t(1) . " *";
			$newFunction[] = $this->_t(1) . " * @param   string   \$title   The title.";
			$newFunction[] = $this->_t(1) . " *";
			$newFunction[] = $this->_t(1) . " * @return	array  Contains the modified title and alias.";
			$newFunction[] = $this->_t(1) . " *";
			$newFunction[] = $this->_t(1) . " */";
			$newFunction[] = $this->_t(1) . "protected function _generateNewTitle(\$title)";
			$newFunction[] = $this->_t(1) . "{";
			$newFunction[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Alter the title";
			$newFunction[] = $this->_t(2) . "\$table = \$this->getTable();";
			$newFunction[] = PHP_EOL . $this->_t(2) . "while (\$table->load(array('title' => \$title)))";
			$newFunction[] = $this->_t(2) . "{";
			$newFunction[] = $this->_t(3) . "\$title = JString::increment(\$title);";
			$newFunction[] = $this->_t(2) . "}";
			$newFunction[] = PHP_EOL . $this->_t(2) . "return \$title;";
			$newFunction[] = $this->_t(1) . "}";
			return implode(PHP_EOL, $newFunction);
		}
		return '';
	}

	public function setGenerateNewAlias($viewName_single)
	{
		// make sure this view has an alias
		if (isset($this->aliasBuilder[$viewName_single]))
		{
			// set the title stuff
			if (isset($this->customAliasBuilder[$viewName_single]))
			{
				$titles = array_values($this->customAliasBuilder[$viewName_single]);
			}
			elseif (isset($this->titleBuilder[$viewName_single]))
			{
				$titles = array($this->titleBuilder[$viewName_single]);
			}
			// reset the bucket
			$titleData = array();
			// load the dynamic title builder
			if (isset($titles) && ComponentbuilderHelper::checkArray($titles))
			{
				foreach ($titles as $title)
				{
					$titleData[] = "\$this->" . $title;
				}
			}
			else
			{
				$titleData = array("'-'"); // just incase some mad man does not set a title/customAlias (we fall back on the date)
			}
			// rest the new function
			$newFunction = array();
			$newFunction[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$newFunction[] = $this->_t(1) . " * Generate a valid alias from title / date.";
			$newFunction[] = $this->_t(1) . " * Remains public to be able to check for duplicated alias before saving";
			$newFunction[] = $this->_t(1) . " *";
			$newFunction[] = $this->_t(1) . " * @return  string";
			$newFunction[] = $this->_t(1) . " */";
			$newFunction[] = $this->_t(1) . "public function generateAlias()";
			$newFunction[] = $this->_t(1) . "{";
			$newFunction[] = $this->_t(2) . "if (empty(\$this->alias))";
			$newFunction[] = $this->_t(2) . "{";
			$newFunction[] = $this->_t(3) . "\$this->alias = " . implode(".' '.", $titleData) . ';';
			$newFunction[] = $this->_t(2) . "}";
			$newFunction[] = PHP_EOL . $this->_t(2) . "\$this->alias = JApplication::stringURLSafe(\$this->alias);";
			$newFunction[] = PHP_EOL . $this->_t(2) . "if (trim(str_replace('-', '', \$this->alias)) == '')";
			$newFunction[] = $this->_t(2) . "{";
			$newFunction[] = $this->_t(3) . "\$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');";
			$newFunction[] = $this->_t(2) . "}";
			$newFunction[] = PHP_EOL . $this->_t(2) . "return \$this->alias;";
			$newFunction[] = $this->_t(1) . "}";
			return implode(PHP_EOL, $newFunction);
		}
		// rest the new function
		$newFunction = array();
		$newFunction[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$newFunction[] = $this->_t(1) . " * This view does not actually have an alias";
		$newFunction[] = $this->_t(1) . " *";
		$newFunction[] = $this->_t(1) . " * @return  bool";
		$newFunction[] = $this->_t(1) . " */";
		$newFunction[] = $this->_t(1) . "public function generateAlias()";
		$newFunction[] = $this->_t(1) . "{";
		$newFunction[] = $this->_t(2) . "return false;";
		$newFunction[] = $this->_t(1) . "}";
		return implode(PHP_EOL, $newFunction);
	}

	public function setInstall()
	{
		if (isset($this->queryBuilder) && ComponentbuilderHelper::checkArray($this->queryBuilder))
		{
			// set the main db prefix
			$component = $this->componentCodeName;
			// start building the db
			$db = '';
			foreach ($this->queryBuilder as $view => $fields)
			{
				// build the uninstall array
				$this->uninstallBuilder[] = "DROP TABLE IF EXISTS `#__" . $component . "_" . $view . "`;";

				// setup the table DB string
				$db_ = '';
				$db_ .= "CREATE TABLE IF NOT EXISTS `#__" . $component . "_" . $view . "` (";
				// check if the table name has changed
				if (isset($this->updateSQL['table_name']) && isset($this->updateSQL['table_name'][$view]))
				{
					$old_table_name = $this->updateSQL['table_name'][$view]['old'];
					$this->updateSQLBuilder["RENAMETABLE`#__" . $component . "_" . $old_table_name . "`"] = "RENAME TABLE `#__" . $component . "_" . $old_table_name . "` to `#__" . $component . "_" . $view . "`;";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['id']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`id` INT(11) NOT NULL AUTO_INCREMENT,";
				}
				$db_ .= PHP_EOL . $this->_t(1) . "`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',";
				ksort($fields);
				$last_name = 'asset_id';
				foreach ($fields as $field => $data)
				{
					// set default
					$default = $data['default'];
					if ($default === 'Other')
					{
						$default = $data['other'];
					}
					if ($default === 'EMPTY')
					{
						$default = $data['null_switch'];
					}
					elseif ($default === 'DATETIME' || $default === 'CURRENT_TIMESTAMP')
					{
						$default = $default . ' ' . $data['null_switch'];
					}
					elseif ($default == 0 || $default)
					{
						if (is_numeric($default))
						{
							$default = $data['null_switch'] . " DEFAULT " . $default;
						}
						else
						{
							$default = $data['null_switch'] . " DEFAULT '" . $default . "'";
						}
					}
					elseif ($data['null_switch'] === 'NULL')
					{
						$default = "DEFAULT NULL";
					}
					else
					{
						$default = $data['null_switch'];
					}
					// set the lenght
					$lenght = '';
					if (isset($data['lenght']) && $data['lenght'] === 'Other' && isset($data['lenght_other']) && $data['lenght_other'] > 0)
					{
						$lenght = '(' . $data['lenght_other'] . ')';
					}
					elseif (isset($data['lenght']) && $data['lenght'] > 0)
					{
						$lenght = '(' . $data['lenght'] . ')';
					}
					// set the field to db
					$db_ .= PHP_EOL . $this->_t(1) . "`" . $field . "` " . $data['type'] . $lenght . " " . $default . ",";
					// check if this a new field that should be added via SQL update
					if (isset($this->addSQL['field']) && isset($this->addSQL['field'][$view]) && ComponentbuilderHelper::checkArray($this->addSQL['field'][$view]) && in_array($data['ID'], $this->addSQL['field'][$view]))
					{
						$this->updateSQLBuilder["ALTERTABLE`#__" . $component . "_" . $view . "`ADD`" . $field . "`"] = "ALTER TABLE `#__" . $component . "_" . $view . "` ADD `" . $field . "` " . $data['type'] . $lenght . " " . $default . " AFTER `" . $last_name . "`;";
					}
					// check if the field has changed name and/or data type and lenght
					elseif ((isset($this->updateSQL['field.datatype']) && isset($this->updateSQL['field.datatype'][$view . '.' . $field])) ||
						(isset($this->updateSQL['field.lenght']) && isset($this->updateSQL['field.lenght'][$view . '.' . $field])) ||
						(isset($this->updateSQL['field.name']) && isset($this->updateSQL['field.name'][$view . '.' . $field])))
					{
						// if the name changed
						if (isset($this->updateSQL['field.name']) && isset($this->updateSQL['field.name'][$view . '.' . $field]))
						{
							$oldName = $this->updateSQL['field.name'][$view . '.' . $field]['old'];
						}
						else
						{
							$oldName = $field;
						}
						// now set the update SQL
						$this->updateSQLBuilder["ALTERTABLE`#__" . $component . "_" . $view . "`CHANGE`" . $oldName . "``" . $field . "`"] = "ALTER TABLE `#__" . $component . "_" . $view . "` CHANGE `" . $oldName . "` `" . $field . "` " . $data['type'] . $lenght . " " . $default . ";";
					}
					// be sure to track the last name used :)
					$last_name = $field;
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['params']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`params` text NOT NULL,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['published']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`published` TINYINT(3) NOT NULL DEFAULT 1,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['created_by']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`created_by` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['modified_by']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['created']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['modified']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['checked_out']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`checked_out` int(11) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['checked_out_time']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['version']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`version` INT(10) unsigned NOT NULL DEFAULT 1,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['hits']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`hits` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if view has access
				if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]) && !isset($this->fieldsNames[$view]['access']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`access` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['ordering']))
				{
					$db_ .= PHP_EOL . $this->_t(1) . "`ordering` INT(11) NOT NULL DEFAULT 0,";
				}
				// check if metadata is added to this view
				if (isset($this->metadataBuilder[$view]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view]))
				{
					// check if default field was over written
					if (!isset($this->fieldsNames[$view]['metakey']))
					{
						$db_ .= PHP_EOL . $this->_t(1) . "`metakey` TEXT NOT NULL,";
					}
					// check if default field was over written
					if (!isset($this->fieldsNames[$view]['metadesc']))
					{
						$db_ .= PHP_EOL . $this->_t(1) . "`metadesc` TEXT NOT NULL,";
					}
					// check if default field was over written
					if (!isset($this->fieldsNames[$view]['metadata']))
					{
						$db_ .= PHP_EOL . $this->_t(1) . "`metadata` TEXT NOT NULL,";
					}
				}
				// TODO (we may want this to be dynamicly set)
				$db_ .= PHP_EOL . $this->_t(1) . "PRIMARY KEY  (`id`)";
				// check if a key was set for any of the default fields then we should not set it again
				$check_keys_set = array();
				if (isset($this->dbUniqueKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbUniqueKeys[$view]))
				{
					foreach ($this->dbUniqueKeys[$view] as $nr => $key)
					{
						$db_ .= "," . PHP_EOL . $this->_t(1) . "UNIQUE KEY `idx_" . $key . "` (`" . $key . "`)";
						$check_keys_set[$key] = $key;
					}
				}
				if (isset($this->dbKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbKeys[$view]))
				{
					foreach ($this->dbKeys[$view] as $nr => $key)
					{
						$db_ .= "," . PHP_EOL . $this->_t(1) . "KEY `idx_" . $key . "` (`" . $key . "`)";
						$check_keys_set[$key] = $key;
					}
				}
				// check if view has access
				if (!isset($check_keys_set['access']) && isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
				{
					$db_ .= "," . PHP_EOL . $this->_t(1) . "KEY `idx_access` (`access`)";
				}
				// check if default field was over written
				if (!isset($check_keys_set['checked_out']))
				{
					$db_ .= "," . PHP_EOL . $this->_t(1) . "KEY `idx_checkout` (`checked_out`)";
				}
				// check if default field was over written
				if (!isset($check_keys_set['created_by']))
				{
					$db_ .= "," . PHP_EOL . $this->_t(1) . "KEY `idx_createdby` (`created_by`)";
				}
				// check if default field was over written
				if (!isset($check_keys_set['modified_by']))
				{
					$db_ .= "," . PHP_EOL . $this->_t(1) . "KEY `idx_modifiedby` (`modified_by`)";
				}
				// check if default field was over written
				if (!isset($check_keys_set['published']))
				{
					$db_ .= "," . PHP_EOL . $this->_t(1) . "KEY `idx_state` (`published`)";
				}
				// easy bucket
				$easy = array();
				// get the mysql table settings
				foreach ($this->mysqlTableKeys as $_mysqlTableKey => $_mysqlTableVal)
				{
					if (isset($this->mysqlTableSetting[$view]) 
						&& ComponentbuilderHelper::checkArray($this->mysqlTableSetting[$view]) 
						&& isset($this->mysqlTableSetting[$view][$_mysqlTableKey]))
					{
						$easy[$_mysqlTableKey] = $this->mysqlTableSetting[$view][$_mysqlTableKey];
					}
					else
					{
						$easy[$_mysqlTableKey] = $this->mysqlTableKeys[$_mysqlTableKey]['default'];
					}
				}
				// add a little fix for the row_format
				if (ComponentbuilderHelper::checkString($easy['row_format']))
				{
					$easy['row_format'] = ' ROW_FORMAT=' . $easy['row_format'];
				}
				// now build db string
				$db_ .= PHP_EOL . ") ENGINE=" . $easy['engine'] . " AUTO_INCREMENT=0 DEFAULT CHARSET=" . $easy['charset'] . " DEFAULT COLLATE=" . $easy['collate'] . $easy['row_format'] . ";";

				// check if this is a new table that should be added via update SQL
				if (isset($this->addSQL['adminview']) && ComponentbuilderHelper::checkArray($this->addSQL['adminview']) && in_array($view, $this->addSQL['adminview']))
				{
					// build the update array
					$this->updateSQLBuilder["CREATETABLEIFNOTEXISTS`#__" . $component . "_" . $view . "`"] = $db_;
				}
				// check if the table row_format has changed
				if (ComponentbuilderHelper::checkString($easy['row_format']) && isset($this->updateSQL['table_row_format']) && isset($this->updateSQL['table_row_format'][$view]))
				{
					// build the update array
					$this->updateSQLBuilder["ALTERTABLE`#__" . $component . "_" . $view . "`" . trim($easy['row_format'])] = "ALTER TABLE `#__" . $component . "_" . $view . "`" . $easy['row_format'] . ";";
				}
				// check if the table engine has changed
				if (isset($this->updateSQL['table_engine']) && isset($this->updateSQL['table_engine'][$view]))
				{
					// build the update array
					$this->updateSQLBuilder["ALTERTABLE`#__" . $component . "_" . $view . "`ENGINE=" . $easy['engine']] = "ALTER TABLE `#__" . $component . "_" . $view . "` ENGINE = " . $easy['engine'] . ";";
				}
				// check if the table charset OR collation has changed (must be updated together)
				if ((isset($this->updateSQL['table_charset']) && isset($this->updateSQL['table_charset'][$view])) ||
					(isset($this->updateSQL['table_collate']) && isset($this->updateSQL['table_collate'][$view])))
				{
					// build the update array
					$this->updateSQLBuilder["ALTERTABLE`#__" . $component . "_" . $view . "CONVERTTOCHARACTERSET" . $easy['charset'] . "COLLATE" . $easy['collate']] = "ALTER TABLE `#__" . $component . "_" . $view . "` CONVERT TO CHARACTER SET " . $easy['charset'] . " COLLATE " . $easy['collate'] . ";";
				}

				// add to main DB string
				$db .= $db_ . PHP_EOL . PHP_EOL;
			}
			// add custom sql dump to the file
			if (isset($this->customScriptBuilder['sql']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder['sql']))
			{
				foreach ($this->customScriptBuilder['sql'] as $for => $customSql)
				{
					$placeholders = array($this->bbb . 'component' . $this->ddd => $component, $this->bbb . 'view' . $this->ddd => $for);
					$db .= $this->setPlaceholders($customSql, $placeholders) . PHP_EOL . PHP_EOL;
				}
				unset($this->customScriptBuilder['sql']);
			}
			return $db;
		}
		return '';
	}

	public function setUninstall()
	{
		$db = '';
		if (isset($this->queryBuilder) && ComponentbuilderHelper::checkArray($this->queryBuilder))
		{
			foreach ($this->uninstallBuilder as $line)
			{
				$db .= $line . PHP_EOL;
			}
		}
		// add custom sql uninstall dump to the file
		if (isset($this->customScriptBuilder['sql_uninstall']) && ComponentbuilderHelper::checkString($this->customScriptBuilder['sql_uninstall']))
		{
			$db .= $this->setPlaceholders($this->customScriptBuilder['sql_uninstall'], $this->placeholders) . PHP_EOL;
			unset($this->customScriptBuilder['sql_uninstall']);
		}
		return $db;
	}

	public function setLangAdmin()
	{
		// add final list of needed lang strings
		$componentName = JFilterOutput::cleanText($this->componentData->name);
		// Trigger Event: jcb_ce_onBeforeBuildAdminLang
		$this->triggerEvent('jcb_ce_onBeforeBuildAdminLang', array(&$this->componentContext, &$this->langContent['admin'], &$this->langPrefix, &$componentName));
		// start loding the defaults
		$this->setLangContent('adminsys', $this->langPrefix, $componentName);
		$this->setLangContent('adminsys', $this->langPrefix . '_CONFIGURATION', $componentName . ' Configuration');
		$this->setLangContent('admin', $this->langPrefix, $componentName);
		$this->setLangContent('admin', $this->langPrefix . '_BACK', 'Back');
		$this->setLangContent('admin', $this->langPrefix . '_DASH', 'Dashboard');
		$this->setLangContent('admin', $this->langPrefix . '_VERSION', 'Version');
		$this->setLangContent('admin', $this->langPrefix . '_DATE', 'Date');
		$this->setLangContent('admin', $this->langPrefix . '_AUTHOR', 'Author');
		$this->setLangContent('admin', $this->langPrefix . '_WEBSITE', 'Website');
		$this->setLangContent('admin', $this->langPrefix . '_LICENSE', 'License');
		$this->setLangContent('admin', $this->langPrefix . '_CONTRIBUTORS', 'Contributors');
		$this->setLangContent('admin', $this->langPrefix . '_CONTRIBUTOR', 'Contributor');
		$this->setLangContent('admin', $this->langPrefix . '_DASHBOARD', $componentName . ' Dashboard');
		$this->setLangContent('admin', $this->langPrefix . '_SAVE_SUCCESS', "Great! Item successfully saved.");
		$this->setLangContent('admin', $this->langPrefix . '_SAVE_WARNING', "The value already existed so please select another.");
		$this->setLangContent('admin', $this->langPrefix . '_HELP_MANAGER', "Help");
		$this->setLangContent('admin', $this->langPrefix . '_NEW', "New");
		$this->setLangContent('admin', $this->langPrefix . '_CLOSE_NEW', "Close & New");
		$this->setLangContent('admin', $this->langPrefix . '_CREATE_NEW_S', "Create New %s");
		$this->setLangContent('admin', $this->langPrefix . '_EDIT_S', "Edit %s");
		$this->setLangContent('admin', $this->langPrefix . '_KEEP_ORIGINAL_STATE', "- Keep Original State -");
		$this->setLangContent('admin', $this->langPrefix . '_KEEP_ORIGINAL_ACCESS', "- Keep Original Access -");
		$this->setLangContent('admin', $this->langPrefix . '_KEEP_ORIGINAL_CATEGORY', "- Keep Original Category -");
		$this->setLangContent('admin', $this->langPrefix . '_PUBLISHED', 'Published');
		$this->setLangContent('admin', $this->langPrefix . '_INACTIVE', 'Inactive');
		$this->setLangContent('admin', $this->langPrefix . '_ARCHIVED', 'Archived');
		$this->setLangContent('admin', $this->langPrefix . '_TRASHED', 'Trashed');
		$this->setLangContent('admin', $this->langPrefix . '_NO_ACCESS_GRANTED', "No Access Granted!");
		$this->setLangContent('admin', $this->langPrefix . '_NOT_FOUND_OR_ACCESS_DENIED', "Not found or access denied!");
		if ($this->componentData->add_license && $this->componentData->license_type == 3)
		{
			$this->setLangContent('admin', 'NIE_REG_NIE', "<br /><br /><center><h1>License not set for " . $componentName . ".</h1><p>Notify your administrator!<br />The license can be obtained from <a href='".$this->componentData->whmcs_buy_link."' target='_blank'>" . $this->componentData->companyname . "</a>.</p></center>");
		}
		// add the langug files needed to import and export data
		if ($this->addEximport)
		{
			$this->setLangContent('admin', $this->langPrefix . '_EXPORT_FAILED', "Export Failed");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_FAILED', "Import Failed");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_TITLE', "Data Importer");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_NO_IMPORT_TYPE_FOUND', "Import type not found.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE', "Package to import not found.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_ERROR', "Import error.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_SUCCESS', "Great! Import successful.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_WARNIMPORTFILE', "Warning, import file error.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_NO_FILE_SELECTED', "No import file selected.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_PLEASE_SELECT_A_FILE', "Please select a file to import.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_PLEASE_SELECT_ALL_COLUMNS', "Please link all columns.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY', "Please enter the file directory.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_WARNIMPORTUPLOADERROR', "Warning, import upload error.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY', "Please enter the file directory.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE', "Path does not have a valid file.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE', "Does not have a valid file type.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_ENTER_A_URL', "Please enter a url.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_MSG_INVALID_URL', "Invalid url.");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_CONTINUE', "Continue");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_FROM_UPLOAD', "Upload");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_SELECT_FILE', "Select File");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_UPLOAD_BOTTON', "Upload File");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_FROM_DIRECTORY', "Directory");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_SELECT_FILE_DIRECTORY', "Set the path to file");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_GET_BOTTON', "Get File");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_FROM_URL', "URL");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_SELECT_FILE_URL', "Enter file URL");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_UPDATE_DATA', "Import Data");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_FORMATS_ACCEPTED', "formats accepted");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_LINK_FILE_TO_TABLE_COLUMNS', "Link File to Table Columns");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_TABLE_COLUMNS', "Table Columns");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_FILE_COLUMNS', "File Columns");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_PLEASE_SELECT_COLUMN', "-- Please Select Column --");
			$this->setLangContent('admin', $this->langPrefix . '_IMPORT_IGNORE_COLUMN', "-- Ignore This Column --");
		}
		// check if the both array is set
		if (isset($this->langContent['both']) && ComponentbuilderHelper::checkArray($this->langContent['both']))
		{
			foreach ($this->langContent['both'] as $keylang => $langval)
			{
				$this->setLangContent('admin', $keylang, $langval);
			}
		}
		// check if the both admin array is set
		if (isset($this->langContent['bothadmin']) && ComponentbuilderHelper::checkArray($this->langContent['bothadmin']))
		{
			foreach ($this->langContent['bothadmin'] as $keylang => $langval)
			{
				$this->setLangContent('admin', $keylang, $langval);
			}
		}
		if (isset($this->langContent['admin']) && ComponentbuilderHelper::checkArray($this->langContent['admin']))
		{
			// Trigger Event: jcb_ce_onAfterBuildAdminLang
			$this->triggerEvent('jcb_ce_onAfterBuildAdminLang', array(&$this->componentContext, &$this->langContent['admin'], &$this->langPrefix, &$componentName));
			// sort the strings
			ksort($this->langContent['admin']);
			// load to global languages
			$this->languages[$this->langTag]['admin'] = $this->langContent['admin'];
			// remove tmp array
			unset($this->langContent['admin']);

			return true;
		}
		return false;
	}

	public function setLangSite()
	{
		// add final list of needed lang strings
		$componentName = JFilterOutput::cleanText($this->componentData->name);
		// Trigger Event: jcb_ce_onBeforeBuildSiteLang
		$this->triggerEvent('jcb_ce_onBeforeBuildSiteLang', array(&$this->componentContext, &$this->langContent['site'], &$this->langPrefix, &$componentName));
		// add final list of needed lang strings
		$this->setLangContent('site', $this->langPrefix, $componentName);
		// some more defaults
		$this->setLangContent('site', 'JTOOLBAR_APPLY', "Save");
		$this->setLangContent('site', 'JTOOLBAR_SAVE_AS_COPY', "Save as Copy");
		$this->setLangContent('site', 'JTOOLBAR_SAVE', "Save & Close");
		$this->setLangContent('site', 'JTOOLBAR_SAVE_AND_NEW', "Save & New");
		$this->setLangContent('site', 'JTOOLBAR_CANCEL', "Cancel");
		$this->setLangContent('site', 'JTOOLBAR_CLOSE', "Close");
		$this->setLangContent('site', 'JTOOLBAR_HELP', "Help");
		$this->setLangContent('site', 'JGLOBAL_FIELD_ID_LABEL', "ID");
		$this->setLangContent('site', 'JGLOBAL_FIELD_ID_DESC', "Record number in the database.");
		$this->setLangContent('site', 'JGLOBAL_FIELD_MODIFIED_LABEL', "Modified Date");
		$this->setLangContent('site', 'COM_CONTENT_FIELD_MODIFIED_DESC', "The last date this item was modified.");
		$this->setLangContent('site', 'JGLOBAL_FIELD_MODIFIED_BY_LABEL', "Modified By");
		$this->setLangContent('site', 'JGLOBAL_FIELD_MODIFIED_BY_DESC', "The user who did the last modification.");
		$this->setLangContent('site', $this->langPrefix . '_NEW', "New");
		$this->setLangContent('site', $this->langPrefix . '_CREATE_NEW_S', "Create New %s");
		$this->setLangContent('site', $this->langPrefix . '_EDIT_S', "Edit %s");
		$this->setLangContent('site', $this->langPrefix . '_NO_ACCESS_GRANTED', "No Access Granted!");
		$this->setLangContent('site', $this->langPrefix . '_NOT_FOUND_OR_ACCESS_DENIED', "Not found or access denied!");

		// check if the both array is set
		if (isset($this->langContent['both']) && ComponentbuilderHelper::checkArray($this->langContent['both']))
		{
			foreach ($this->langContent['both'] as $keylang => $langval)
			{
				$this->setLangContent('site', $keylang, $langval);
			}
		}
		// check if the both site array is set
		if (isset($this->langContent['bothsite']) && ComponentbuilderHelper::checkArray($this->langContent['bothsite']))
		{
			foreach ($this->langContent['bothsite'] as $keylang => $langval)
			{
				$this->setLangContent('site', $keylang, $langval);
			}
		}
		if (isset($this->langContent['site']) && ComponentbuilderHelper::checkArray($this->langContent['site']))
		{
			// Trigger Event: jcb_ce_onAfterBuildSiteLang
			$this->triggerEvent('jcb_ce_onAfterBuildSiteLang', array(&$this->componentContext, &$this->langContent['site'], &$this->langPrefix, &$componentName));
			// sort the strings
			ksort($this->langContent['site']);
			// load to global languages
			$this->languages[$this->langTag]['site'] = $this->langContent['site'];
			// remove tmp array
			unset($this->langContent['site']);

			return true;
		}
		return false;
	}

	public function setLangSiteSys()
	{
		// add final list of needed lang strings
		$componentName = JFilterOutput::cleanText($this->componentData->name);
		// Trigger Event: jcb_ce_onBeforeBuildSiteSysLang
		$this->triggerEvent('jcb_ce_onBeforeBuildSiteSysLang', array(&$this->componentContext, &$this->langContent['sitesys'], &$this->langPrefix, &$componentName));
		// add final list of needed lang strings
		$this->setLangContent('sitesys', $this->langPrefix, $componentName);
		$this->setLangContent('sitesys', $this->langPrefix . '_NO_ACCESS_GRANTED', "No Access Granted!");
		$this->setLangContent('sitesys', $this->langPrefix . '_NOT_FOUND_OR_ACCESS_DENIED', "Not found or access denied!");

		// check if the both site array is set
		if (isset($this->langContent['bothsite']) && ComponentbuilderHelper::checkArray($this->langContent['bothsite']))
		{
			foreach ($this->langContent['bothsite'] as $keylang => $langval)
			{
				$this->setLangContent('sitesys', $keylang, $langval);
			}
		}
		if (isset($this->langContent['sitesys']) && ComponentbuilderHelper::checkArray($this->langContent['sitesys']))
		{
			// Trigger Event: jcb_ce_onAfterBuildSiteSysLang
			$this->triggerEvent('jcb_ce_onAfterBuildSiteSysLang', array(&$this->componentContext, &$this->langContent['sitesys'], &$this->langPrefix, &$componentName));
			// sort strings
			ksort($this->langContent['sitesys']);
			// load to global languages
			$this->languages[$this->langTag]['sitesys'] = $this->langContent['sitesys'];
			// remove tmp array
			unset($this->langContent['sitesys']);

			return true;
		}
		return false;
	}

	public function setLangAdminSys()
	{
		// add final list of needed lang strings
		$componentName = JFilterOutput::cleanText($this->componentData->name);
		// Trigger Event: jcb_ce_onBeforeBuildAdminSysLang
		$this->triggerEvent('jcb_ce_onBeforeBuildAdminSysLang', array(&$this->componentContext, &$this->langContent['adminsys'], &$this->langPrefix, &$componentName));
		// check if the both admin array is set
		if (isset($this->langContent['bothadmin']) && ComponentbuilderHelper::checkArray($this->langContent['bothadmin']))
		{
			foreach ($this->langContent['bothadmin'] as $keylang => $langval)
			{
				$this->setLangContent('adminsys', $keylang, $langval);
			}
		}
		if (isset($this->langContent['adminsys']) && ComponentbuilderHelper::checkArray($this->langContent['adminsys']))
		{
			// Trigger Event: jcb_ce_onAfterBuildAdminSysLang
			$this->triggerEvent('jcb_ce_onAfterBuildAdminSysLang', array(&$this->componentContext, &$this->langContent['adminsys'], &$this->langPrefix, &$componentName));
			// sort strings
			ksort($this->langContent['adminsys']);
			// load to global languages
			$this->languages[$this->langTag]['adminsys'] = $this->langContent['adminsys'];
			// remove tmp array
			unset($this->langContent['adminsys']);

			return true;
		}
		return false;
	}

	public function setCustomAdminViewListLink($view, $viewName_list)
	{
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $custom_admin_view)
			{
				if (isset($custom_admin_view['adminviews']) && ComponentbuilderHelper::checkArray($custom_admin_view['adminviews']))
				{
					foreach ($custom_admin_view['adminviews'] as $adminview)
					{
						if (isset($view['adminview']) && $view['adminview'] == $adminview)
						{
							// set the needed keys
							$setId = false;
							if (ComponentbuilderHelper::checkArray($custom_admin_view['settings']->main_get->filter))
							{
								foreach ($custom_admin_view['settings']->main_get->filter as $filter)
								{
									if ($filter['filter_type'] == 1 || '$id' == $filter['state_key'])
									{
										$setId = true;
									}
								}
							}
							// set the needed array values
							$set = array(
								'icon' => $custom_admin_view['icomoon'],
								'link' => $custom_admin_view['settings']->code,
								'NAME' => $custom_admin_view['settings']->CODE,
								'name' => $custom_admin_view['settings']->name);
							// only load to list if it has id filter
							if ($setId)
							{
								// now load it to the global object for items list
								$this->customAdminViewListLink[$viewName_list][] = $set;
								// add to set id for list view if needed
								$this->customAdminViewListId[$custom_admin_view['settings']->code] = true;
							}
							else
							{
								// now load it to the global object for tool bar
								$this->customAdminDynamicButtons[$viewName_list][] = $set;
							}
							// log that it has been added already
							$this->customAdminAdded[$custom_admin_view['settings']->code] = $adminview;
						}
					}
				}
			}
		}
	}

	/**
	 * set the list body
	 *
	 * @param string  $viewName_single
	 * @param string  $viewName_list
	 *
	 * @return string
	 */
	public function setListBody($viewName_single, $viewName_list)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper';
			// setup correct core target
			$coreLoad = false;
			$core = null;
			if (isset($this->permissionCore[$viewName_single]))
			{
				$core = $this->permissionCore[$viewName_single];
				$coreLoad = true;
			}
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// add the default
			$body = "<?php foreach (\$this->items as \$i => \$item): ?>";
			$body .= PHP_EOL . $this->_t(1) . "<?php";
			$body .= PHP_EOL . $this->_t(2) . "\$canCheckin = \$this->user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$this->user->id || \$item->checked_out == 0;";
			$body .= PHP_EOL . $this->_t(2) . "\$userChkOut = JFactory::getUser(\$item->checked_out);";
			$body .= PHP_EOL . $this->_t(2) . "\$canDo = " . $Helper . "::getActions('" . $viewName_single . "',\$item,'" . $viewName_list . "');";
			$body .= PHP_EOL . $this->_t(1) . "?>";
			$body .= PHP_EOL . $this->_t(1) . '<tr class="row<?php echo $i % 2; ?>">';
			// only load if not over written
			if (!isset($this->fieldsNames[$viewName_single]['ordering']))
			{
				$body .= PHP_EOL . $this->_t(2) . '<td class="order nowrap center hidden-phone">';
				// check if the item has permissions.
				if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit.state']]))
				{
					$body .= PHP_EOL . $this->_t(2) . "<?php if (\$canDo->get('" . $core['core.edit.state'] . "')): ?>";
				}
				else
				{
					$body .= PHP_EOL . $this->_t(2) . "<?php if (\$canDo->get('core.edit.state')): ?>";
				}
				$body .= PHP_EOL . $this->_t(3) . "<?php";
				$body .= PHP_EOL . $this->_t(4) . "if (\$this->saveOrder)";
				$body .= PHP_EOL . $this->_t(4) . "{";
				$body .= PHP_EOL . $this->_t(5) . "\$iconClass = ' inactive';";
				$body .= PHP_EOL . $this->_t(4) . "}";
				$body .= PHP_EOL . $this->_t(4) . "else";
				$body .= PHP_EOL . $this->_t(4) . "{";
				$body .= PHP_EOL . $this->_t(5) . "\$iconClass = ' inactive tip-top" . '" hasTooltip" title="' . "' . JHtml::tooltipText('JORDERINGDISABLED');";
				$body .= PHP_EOL . $this->_t(4) . "}";
				$body .= PHP_EOL . $this->_t(3) . "?>";
				$body .= PHP_EOL . $this->_t(3) . '<span class="sortable-handler<?php echo $iconClass; ?>">';
				$body .= PHP_EOL . $this->_t(4) . '<i class="icon-menu"></i>';
				$body .= PHP_EOL . $this->_t(3) . "</span>";
				$body .= PHP_EOL . $this->_t(3) . "<?php if (\$this->saveOrder) : ?>";
				$body .= PHP_EOL . $this->_t(4) . '<input type="text" style="display:none" name="order[]" size="5"';
				$body .= PHP_EOL . $this->_t(4) . 'value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />';
				$body .= PHP_EOL . $this->_t(3) . "<?php endif; ?>";
				$body .= PHP_EOL . $this->_t(2) . "<?php else: ?>";
				$body .= PHP_EOL . $this->_t(3) . "&#8942;";
				$body .= PHP_EOL . $this->_t(2) . "<?php endif; ?>";
				$body .= PHP_EOL . $this->_t(2) . "</td>";
			}
			$body .= PHP_EOL . $this->_t(2) . '<td class="nowrap center">';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit']]))
			{
				$body .= PHP_EOL . $this->_t(2) . "<?php if (\$canDo->get('" . $core['core.edit'] . "')): ?>";
			}
			else
			{
				$body .= PHP_EOL . $this->_t(2) . "<?php if (\$canDo->get('core.edit')): ?>";
			}
			$body .= PHP_EOL . $this->_t(4) . "<?php if (\$item->checked_out) : ?>";
			$body .= PHP_EOL . $this->_t(5) . "<?php if (\$canCheckin) : ?>";
			$body .= PHP_EOL . $this->_t(6) . "<?php echo JHtml::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL . $this->_t(5) . "<?php else: ?>";
			$body .= PHP_EOL . $this->_t(6) . "&#9633;";
			$body .= PHP_EOL . $this->_t(5) . "<?php endif; ?>";
			$body .= PHP_EOL . $this->_t(4) . "<?php else: ?>";
			$body .= PHP_EOL . $this->_t(5) . "<?php echo JHtml::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL . $this->_t(4) . "<?php endif; ?>";
			$body .= PHP_EOL . $this->_t(2) . "<?php else: ?>";
			$body .= PHP_EOL . $this->_t(3) . "&#9633;";
			$body .= PHP_EOL . $this->_t(2) . "<?php endif; ?>";
			$body .= PHP_EOL . $this->_t(2) . "</td>";
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (isset($this->doNotEscape[$viewName_list]))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				// check if target is admin list
				if (1 == $item['target'] || 3 == $item['target'])
				{
					// set some defaults
					$customAdminViewButtons = '';
					// set the item default class
					$itemClass = 'hidden-phone';
					// set the item row
					$itemRow = $this->getListItemBuilder($item, $viewName_single, $viewName_list, $itemClass, $doNotEscape, $coreLoad, $core);
					// check if buttons was aready added
					if ($firstTimeBeingAdded) // TODO we must improve this to allow more items to be targeted instead of just the first item :)
					{
						// get custom admin view buttons
						$customAdminViewButtons = $this->getCustomAdminViewButtons($viewName_list);
						// make sure the custom admin view buttons are only added once
						$firstTimeBeingAdded = false;
					}
					// add row to body
					$body .= PHP_EOL . $this->_t(2) . "<td class=\"" . $this->getListFieldClass($item['code'], $viewName_list, $itemClass) . "\">";
					$body .= $itemRow;
					$body .= $customAdminViewButtons;
					$body .= PHP_EOL . $this->_t(2) . "</td>";
				}
			}
			// add the defaults
			if (!isset($this->fieldsNames[$viewName_single]['published']))
			{
				$body .= PHP_EOL . $this->_t(2) . '<td class="center">';
				// check if the item has permissions.
				if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit.state']]))
				{
					$body .= PHP_EOL . $this->_t(2) . "<?php if (\$canDo->get('" . $core['core.edit.state'] . "')) : ?>";
				}
				else
				{
					$body .= PHP_EOL . $this->_t(2) . "<?php if (\$canDo->get('core.edit.state')) : ?>";
				}
				$body .= PHP_EOL . $this->_t(4) . "<?php if (\$item->checked_out) : ?>";
				$body .= PHP_EOL . $this->_t(5) . "<?php if (\$canCheckin) : ?>";
				$body .= PHP_EOL . $this->_t(6) . "<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '" . $viewName_list . ".', true, 'cb'); ?>";
				$body .= PHP_EOL . $this->_t(5) . "<?php else: ?>";
				$body .= PHP_EOL . $this->_t(6) . "<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '" . $viewName_list . ".', false, 'cb'); ?>";
				$body .= PHP_EOL . $this->_t(5) . "<?php endif; ?>";
				$body .= PHP_EOL . $this->_t(4) . "<?php else: ?>";
				$body .= PHP_EOL . $this->_t(5) . "<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '" . $viewName_list . ".', true, 'cb'); ?>";
				$body .= PHP_EOL . $this->_t(4) . "<?php endif; ?>";
				$body .= PHP_EOL . $this->_t(2) . "<?php else: ?>";
				$body .= PHP_EOL . $this->_t(3) . "<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '" . $viewName_list . ".', false, 'cb'); ?>";
				$body .= PHP_EOL . $this->_t(2) . "<?php endif; ?>";
				$body .= PHP_EOL . $this->_t(2) . "</td>";
			}
			if (!isset($this->fieldsNames[$viewName_single]['id']))
			{
				$body .= PHP_EOL . $this->_t(2) . '<td class="' . $this->getListFieldClass($item['code'], $viewName_list, 'nowrap center hidden-phone') . '">';
				$body .= PHP_EOL . $this->_t(3) . "<?php echo \$item->id; ?>";
				$body .= PHP_EOL . $this->_t(2) . "</td>";
			}
			$body .= PHP_EOL . $this->_t(1) . "</tr>";
			$body .= PHP_EOL . "<?php endforeach; ?>";
			// return the build
			return $body;
		}
		return '';
	}

	/**
	 * Get the list item dynamic row
	 *
	 * @param   array    $item             The item array
	 * @param   string   $viewName_single  The single view code name
	 * @param   string   $viewName_list    The list view code name
	 * @param   string   $itemClass        The table row default class
	 * @param   bool     $doNotEscape      The do not escape global switch
	 * @param   bool     $coreLoad         The core permission loader switch
	 * @param   array    $core             The core permission values
	 * @param   bool     $class            The dive class adding switch
	 * @param   string   $ref              The link referral string
	 * @param   string   $escape           The escape code name
	 * @param   string   $user             The user code name
	 * @param   string   $refview          The override of the referral view code name
	 *
	 * @return  string of the completer item value for the table row
	 *
	 */
	protected function getListItemBuilder($item, $viewName_single, $viewName_list, &$itemClass, $doNotEscape, $coreLoad, $core, $class = true, $ref = null, $escape = '$this->escape', $user = '$this->user', $refview = null)
	{
		// check if we have relation fields
		if (isset($this->fieldRelations[$viewName_list]) && isset($this->fieldRelations[$viewName_list][(int) $item['id']]) && isset($this->fieldRelations[$viewName_list][(int) $item['id']][2]))
		{
			// set the fields array
			$field = array();
			// use custom code
			$useCustomCode = (isset($this->fieldRelations[$viewName_list][(int) $item['id']][2]['join_type']) && $this->fieldRelations[$viewName_list][(int) $item['id']][2]['join_type'] == 2 &&
				isset($this->fieldRelations[$viewName_list][(int) $item['id']][2]['set']) && ComponentbuilderHelper::checkString($this->fieldRelations[$viewName_list][(int) $item['id']][2]['set']));
			// load the main list view field
			$field['[field=' . (int) $item['id'] . ']'] = $this->getListItem($item, $viewName_single, $viewName_list, $itemClass, $doNotEscape, $coreLoad, $core, false, $ref, $escape, $user, $refview);
			// code name
			if (isset($item['code']) && $useCustomCode)
			{
				$field['$item->{' . (int) $item['id'] . '}'] = '$item->' . $item['code'];
			}
			// now load the relations
			if (isset($this->fieldRelations[$viewName_list][(int) $item['id']][2]['joinfields']) &&
				ComponentbuilderHelper::checkArray($this->fieldRelations[$viewName_list][(int) $item['id']][2]['joinfields']))
			{
				foreach ($this->fieldRelations[$viewName_list][(int) $item['id']][2]['joinfields'] as $join)
				{
					$blankClass = '';
					if (isset($this->listJoinBuilder[$viewName_list]) && isset($this->listJoinBuilder[$viewName_list][(int) $join]))
					{
						// code block
						$field['[field=' . (int) $join . ']'] = $this->getListItem($this->listJoinBuilder[$viewName_list][(int) $join], $viewName_single, $viewName_list, $blankClass, $doNotEscape, $coreLoad, $core, false, $ref, $escape, $user, $refview);
						// code name
						if (isset($this->listJoinBuilder[$viewName_list][(int) $join]['code']) && $useCustomCode)
						{
							$field['$item->{' . (int) $join . '}'] = '$item->' . $this->listJoinBuilder[$viewName_list][(int) $join]['code'];
						}
					}
				}
			}
			// join based on join type
			if ($useCustomCode)
			{
				// custom code
				return PHP_EOL . $this->_t(3) . "<div>" . $this->setPlaceholders(str_replace(array_keys($field), array_values($field), $this->fieldRelations[$viewName_list][(int) $item['id']][2]['set']), $this->placeholders) . PHP_EOL . $this->_t(3) . "</div>";
			}
			elseif (isset($this->fieldRelations[$viewName_list][(int) $item['id']]['set']) && ComponentbuilderHelper::checkString($this->fieldRelations[$viewName_list][(int) $item['id']][2]['set']))
			{
				// concatenate
				return PHP_EOL . $this->_t(3) . "<div>" . implode($this->fieldRelations[$viewName_list][(int) $item['id']][2]['set'], $field) . PHP_EOL . $this->_t(3) . "</div>";
			}
			// default
			return PHP_EOL . $this->_t(3) . "<div>" . implode('', $field) . PHP_EOL . $this->_t(3) . "</div>";
		}
		return $this->getListItem($item, $viewName_single, $viewName_list, $itemClass, $doNotEscape, $coreLoad, $core, $class, $ref, $escape, $user, $refview);
	}

	/**
	 * Get the list item row value
	 *
	 * @param   array    $item             The item array
	 * @param   string   $viewName_single  The single view code name
	 * @param   string   $viewName_list    The list view code name
	 * @param   string   $itemClass        The table row default class
	 * @param   bool     $doNotEscape      The do not escape global switch
	 * @param   bool     $coreLoad         The core permission loader switch
	 * @param   array    $core             The core permission values
	 * @param   bool     $class            The dive class adding switch
	 * @param   string   $ref              The link referral string
	 * @param   string   $escape           The escape code name
	 * @param   string   $user             The user code name
	 * @param   string   $refview          The override of the referral view code name
	 *
	 * @return  string of the single item value for the table row
	 *
	 */
	protected function getListItem($item, $viewName_single, $viewName_list, &$itemClass, $doNotEscape, $coreLoad, $core, $class = true, $ref = null, $escape = '$this->escape', $user = '$this->user', $refview = null)
	{
		// get list item code
		$itemCode = $this->getListItemCode($item, $viewName_list, $doNotEscape, $escape);
		// add default links
		$defaultLink = true;
		if (ComponentbuilderHelper::checkString($refview) && isset($item['custom']) && isset($item['custom']['view']) && $refview === $item['custom']['view'])
		{
			$defaultLink = false;
		}
		// is this a linked item
		if (($item['link'] || (ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user')) && $defaultLink)
		{
			// set some defaults
			$checkoutTriger = false;
			// set the item default class
			$itemClass = 'nowrap';
			// get list item link
			$itemLink = $this->getListItemLink($item, $checkoutTriger, $viewName_single, $viewName_list, $ref);
			// get list item link authority
			$itemLinkAuthority = $this->getListItemLinkAuthority($item, $viewName_single, $viewName_list, $coreLoad, $core, $user);
			// set item row
			return $this->getListItemLinkLogic($itemCode, $itemLink, $itemLinkAuthority, $viewName_list, $checkoutTriger, $class);
		}
		// return the default (no link)
		return PHP_EOL . $this->_t(3) . "<?php echo " . $itemCode . "; ?>";
	}

	/**
	 * Get the list item link logic
	 *
	 * @param   string   $itemCode		     The item code string
	 * @param   string   $itemLink           The item link string
	 * @param   string   $itemLinkAuthority  The link authority string
	 * @param   string   $viewName_list      The list view code name
	 * @param   bool     $checkoutTriger     The check out trigger
	 * @param   bool     $class              The dive class adding switch
	 *
	 * @return  string of the complete link logic of row item
	 *
	 */
	protected function getListItemLinkLogic($itemCode, $itemLink, $itemLinkAuthority, $viewName_list, $checkoutTriger, $class = true)
	{
		// build link
		$link = '';
		// add class
		$tab = '';
		if ($class)
		{
			$link .= PHP_EOL . $this->_t(3) . '<div class="name">';
			$tab = $this->_t(1);
		}
		// the link logic
		$link .= PHP_EOL . $tab . $this->_t(3) . "<?php if (" . $itemLinkAuthority . "): ?>";
		$link .= PHP_EOL . $tab . $this->_t(4) . '<a href="' . $itemLink . '"><?php echo ' . $itemCode . '; ?></a>';
		if ($checkoutTriger)
		{
			$link .= PHP_EOL . $tab . $this->_t(4) . "<?php if (\$item->checked_out): ?>";
			$link .= PHP_EOL . $tab . $this->_t(5) . "<?php echo JHtml::_('jgrid.checkedout', \$i, \$userChkOut->name, \$item->checked_out_time, '" . $viewName_list . ".', \$canCheckin); ?>";
			$link .= PHP_EOL . $tab . $this->_t(4) . "<?php endif; ?>";
		}
		$link .= PHP_EOL . $tab . $this->_t(3) . "<?php else: ?>";
		$link .= PHP_EOL . $tab . $this->_t(4) . "<?php echo " . $itemCode . "; ?>";
		$link .= PHP_EOL . $tab . $this->_t(3) . "<?php endif; ?>";
		// add class
		if ($class)
		{
			$link .= PHP_EOL . $this->_t(3) . "</div>";
		}
		// return the link logic
		return $link;
	}

	/**
	 * Get the custom admin view buttons
	 *
	 * @param   string   $viewName_list    The list view code name
	 * @param   string   $ref              The link referral string
	 *
	 * @return  string of the custom admin view buttons
	 *
	 */
	protected function getCustomAdminViewButtons($viewName_list, $ref = '')
	{
		$customAdminViewButton = '';
		// check if custom links should be added to this list views
		if (isset($this->customAdminViewListLink[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminViewListLink[$viewName_list]))
		{
			// start building the links
			$customAdminViewButton .= PHP_EOL . $this->_t(3) . '<div class="btn-group">';
			foreach ($this->customAdminViewListLink[$viewName_list] as $customLinkView)
			{
				$customAdminViewButton .= PHP_EOL . $this->_t(3) . "<?php if (\$canDo->get('" . $customLinkView['link'] . ".access')): ?>";
				$customAdminViewButton .= PHP_EOL . $this->_t(4) . '<a class="hasTooltip btn btn-mini" href="index.php?option=com_' . $this->componentCodeName . '&view=' . $customLinkView['link'] . '&id=<?php echo $item->id; ?>' . $ref . '" title="<?php echo JText:' . ':_(' . "'COM_" . $this->fileContentStatic[$this->hhh . 'COMPONENT' . $this->hhh] . '_' . $customLinkView['NAME'] . "'" . '); ?>" ><span class="icon-' . $customLinkView['icon'] . '"></span></a>';
				$customAdminViewButton .= PHP_EOL . $this->_t(3) . "<?php else: ?>";
				$customAdminViewButton .= PHP_EOL . $this->_t(4) . '<a class="hasTooltip btn btn-mini disabled" href="#" title="<?php echo JText:' . ':_(' . "'COM_" . $this->fileContentStatic[$this->hhh . 'COMPONENT' . $this->hhh] . '_' . $customLinkView['NAME'] . "'" . '); ?>"><span class="icon-' . $customLinkView['icon'] . '"></span></a>';
				$customAdminViewButton .= PHP_EOL . $this->_t(3) . "<?php endif; ?>";
			}
			$customAdminViewButton .= PHP_EOL . $this->_t(3) . '</div>';
		}
		return $customAdminViewButton;
	}

	/**
	 * Get the list item code value
	 *
	 * @param   array    $item             The item array
	 * @param   string   $viewName_list    The list view code name
	 * @param   bool     $doNotEscape      The do not escape global switch
	 * @param   string   $escape           The escape code name
	 *
	 * @return  string of the single item code
	 *
	 */
	protected function getListItemCode(&$item, $viewName_list, $doNotEscape, $escape = '$this->escape')
	{
		// first update the code id needed
		if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && isset($item['custom']['table']) && ComponentbuilderHelper::checkString($item['custom']['table']))
		{
			$item['id_code'] = $item['code'];
			if (!$item['multiple'])
			{
				$item['code'] = $item['code'] . '_' . $item['custom']['text'];
			}
		}
		// check if category
		if ($item['type'] === 'category' && !$item['title'])
		{
			return $escape . '($item->category_title)';
		}
		// check if user
		elseif ($item['type'] === 'user')
		{
			return 'JFactory::getUser((int)$item->' . $item['code'] . ')->name';
		}
		// check if custom user
		elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user' && isset($item['id_code']))
		{
			return 'JFactory::getUser((int)$item->' . $item['id_code'] . ')->name';
		}
		// check if translated value is used
		elseif (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list]) && array_key_exists($item['code'], $this->selectionTranslationFixBuilder[$viewName_list]))
		{
			return 'JText:' . ':_($item->' . $item['code'] . ')';
		}
		elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['text'] === 'user')
		{
			return 'JFactory::getUser((int)$item->' . $item['code'] . ')->name';
		}
		elseif ($doNotEscape)
		{
			if (in_array($item['code'], $this->doNotEscape[$viewName_list]))
			{
				return '$item->' . $item['code'];
			}
		}
		// default
		return $escape . '($item->' . $item['code'] . ')';
	}

	/**
	 * Get the list item link
	 *
	 * @param   array    $item             The item array
	 * @param   bool     $checkoutTriger   The checkout trigger switch
	 * @param   string   $viewName_single  The single view code name
	 * @param   string   $viewName_list    The list view code name
	 * @param   string   $ref              The link referral string
	 *
	 * @return  string of the single item link
	 *
	 */
	protected function getListItemLink($item, &$checkoutTriger, $viewName_single, $viewName_list, $ref = null)
	{
		// set referal if not set
		$referal = '';
		if (!$ref)
		{
			$ref = '&return=<?php echo $this->return_here; ?>';
		}
		// in linked tab/view so must add ref to default
		else
		{
			$referal = $ref;
		}
		// if to be linked
		if ($item['type'] === 'category' && !$item['title'])
		{
			// get the other view
			$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
			// return the link to category
			return 'index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->' . $item['code'] . '; ?>&extension=com_' . $this->componentCodeName . '.' . $otherViews;
		}
		elseif ($item['type'] === 'user' && !$item['title'])
		{
			// return user link
			return 'index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->' . $item['code'] . ' ?>';
		}
		elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] != 'user' && !$item['title'] && isset($item['id_code']))
		{
			// link to that linked item
			return 'index.php?option=' . $item['custom']['component'] . '&view=' . $item['custom']['views'] . '&task=' . $item['custom']['view'] . '.edit&id=<?php echo $item->' . $item['id_code'] . '; ?>' . $ref;
		}
		elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user' && !$item['title'] && isset($item['id_code']))
		{
			// return user link
			return 'index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->' . $item['id_code'] . ' ?>';
		}
		// make sure to triger the checkout
		$checkoutTriger = true;
		// basic default item link
		return '<?php echo $edit; ?>&id=<?php echo $item->id; ?>' . $referal;
	}

	/**
	 * Get the list item authority
	 *
	 * @param   array    $item             The item array
	 * @param   string   $viewName_single  The single view code name
	 * @param   string   $viewName_list    The list view code name
	 * @param   bool     $coreLoad         The core permission loader switch
	 * @param   array    $core             The core permission values
	 * @param   string   $user             The user code name
	 *
	 * @return  string of the single item link authority
	 *
	 */
	protected function getListItemLinkAuthority($item, $viewName_single, $viewName_list, $coreLoad, $core, $user = '$this->user')
	{
		// if to be linked
		if ($item['type'] === 'category' && !$item['title'])
		{
			// get the other view
			$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
			// return the authority to category
			return $user . "->authorise('core.edit', 'com_" . $this->componentCodeName . "." . $otherViews . ".category.' . (int)\$item->" . $item['code'] . ")";
		}
		elseif ($item['type'] === 'user' && !$item['title'])
		{
			// return user authority
			return $user . "->authorise('core.edit', 'com_users')";
		}
		elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] != 'user' && !$item['title'] && isset($item['id_code']))
		{
			// link to that linked item
			$coreLoadLink = false;
			if (isset($this->permissionCore[$item['custom']['view']]))
			{
				$coreLink = $this->permissionCore[$item['custom']['view']];
				$coreLoadLink = true;
			}
			// check if the item has permissions.
			if ($coreLoadLink && (isset($coreLink['core.edit']) && isset($this->permissionBuilder[$coreLink['core.edit']])) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$coreLink['core.edit']]) && in_array($item['custom']['view'], $this->permissionBuilder[$coreLink['core.edit']]))
			{
				return $user . "->authorise('" . $coreLink['core.edit'] . "', 'com_" . $this->componentCodeName . "." . $item['custom']['view'] . ".' . (int)\$item->" . $item['id_code'] . ")";
			}
			// return default for this external item
			return $user . "->authorise('core.edit', 'com_" . $this->componentCodeName . "." . $item['custom']['view'] . ".' . (int)\$item->" . $item['id_code'] . ")";
		}
		elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user' && !$item['title'] && isset($item['id_code']))
		{
			// return user link
			return $user . "->authorise('core.edit', 'com_users')";
		}
		// check if the item has custom permissions.
		elseif ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit']]))
		{
			// set permissions.
			return "\$canDo->get('" . $core['core.edit'] . "')";
		}
		// set core permissions.
		return "\$canDo->get('core.edit')";
	}

	/**
	 * Get the list field class
	 *
	 * @param   string   $name             The field code name
	 * @param   string   $listViewName     The list view code name
	 * @param   string   $default          The default
	 *
	 * @return  string  The list field class
	 *
	 */
	protected function getListFieldClass($name, $listViewName, $default = '')
	{
		return (isset($this->listFieldClass[$listViewName]) && isset($this->listFieldClass[$listViewName][$name])) ? $this->listFieldClass[$listViewName][$name] : $default;
	}

	/**
	 * set the list body table head
	 *
	 * @param string $viewName_single
	 * @param string $viewName_list
	 *
	 * @return string
	 */
	public function setListHead($viewName_single, $viewName_list)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// main lang prefix
			$langView = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($viewName_single, 'U');
			// set status lang
			$statusLangName = $langView . '_STATUS';
			// set id lang
			$idLangName = $langView . '_ID';
			// add to lang array
			$this->setLangContent($this->lang, $statusLangName, 'Status');
			// add to lang array
			$this->setLangContent($this->lang, $idLangName, 'Id');
			// set default
			$head = '<tr>';
			$head .= PHP_EOL . $this->_t(1) . "<?php if (\$this->canEdit&& \$this->canState): ?>";
			if (!isset($this->fieldsNames[$viewName_single]['ordering']))
			{
				$head .= PHP_EOL . $this->_t(2) . '<th width="1%" class="nowrap center hidden-phone">';
				$head .= PHP_EOL . $this->_t(3) . "<?php echo JHtml::_('grid.sort', '" . '<i class="icon-menu-2"></i>' . "', 'ordering', \$this->listDirn, \$this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>";
				$head .= PHP_EOL . $this->_t(2) . "</th>";
			}
			$head .= PHP_EOL . $this->_t(2) . '<th width="20" class="nowrap center">';
			$head .= PHP_EOL . $this->_t(3) . "<?php echo JHtml::_('grid.checkall'); ?>";
			$head .= PHP_EOL . $this->_t(2) . "</th>";
			$head .= PHP_EOL . $this->_t(1) . "<?php else: ?>";
			$head .= PHP_EOL . $this->_t(2) . '<th width="20" class="nowrap center hidden-phone">';
			$head .= PHP_EOL . $this->_t(3) . "&#9662;";
			$head .= PHP_EOL . $this->_t(2) . "</th>";
			$head .= PHP_EOL . $this->_t(2) . '<th width="20" class="nowrap center">';
			$head .= PHP_EOL . $this->_t(3) . "&#9632;";
			$head .= PHP_EOL . $this->_t(2) . "</th>";
			$head .= PHP_EOL . $this->_t(1) . "<?php endif; ?>";
			// set footer Column number
			$this->listColnrBuilder[$viewName_list] = 4;
			// build the dynamic fields
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				// check if target is admin list
				if (1 == $item['target'] || 3 == $item['target'])
				{
					// check if we have an over-ride
					if (isset($this->listHeadOverRide[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listHeadOverRide[$viewName_list]) && isset($this->listHeadOverRide[$viewName_list][$item['id']]))
					{
						$item['lang'] = $this->listHeadOverRide[$viewName_list][$item['id']];
					}
					// set the custom code
					if (ComponentbuilderHelper::checkArray($item['custom']))
					{
						$item['code'] = $item['code'] . '_' . $item['custom']['text'];
					}
					$class = 'nowrap hidden-phone';
					if ($item['link'])
					{
						$class = 'nowrap';
					}
					$title = "<?php echo JText:" . ":_('" . $item['lang'] . "'); ?>";
					if ($item['sort'])
					{
						$title = "<?php echo JHtml::_('grid.sort', '" . $item['lang'] . "', '" . $item['code'] . "', \$this->listDirn, \$this->listOrder); ?>";
					}
					$head .= PHP_EOL . $this->_t(1) . '<th class="' . $class . '" >';
					$head .= PHP_EOL . $this->_t(3) . $title;
					$head .= PHP_EOL . $this->_t(1) . "</th>";
					$this->listColnrBuilder[$viewName_list] ++;
				}
			}
			// set default
			if (!isset($this->fieldsNames[$viewName_single]['published']))
			{
				$head .= PHP_EOL . $this->_t(1) . "<?php if (\$this->canState): ?>";
				$head .= PHP_EOL . $this->_t(2) . '<th width="10" class="nowrap center" >';
				$head .= PHP_EOL . $this->_t(3) . "<?php echo JHtml::_('grid.sort', '" . $statusLangName . "', 'published', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL . $this->_t(2) . "</th>";
				$head .= PHP_EOL . $this->_t(1) . "<?php else: ?>";
				$head .= PHP_EOL . $this->_t(2) . '<th width="10" class="nowrap center" >';
				$head .= PHP_EOL . $this->_t(3) . "<?php echo JText:" . ":_('" . $statusLangName . "'); ?>";
				$head .= PHP_EOL . $this->_t(2) . "</th>";
				$head .= PHP_EOL . $this->_t(1) . "<?php endif; ?>";
			}
			if (!isset($this->fieldsNames[$viewName_single]['id']))
			{
				$head .= PHP_EOL . $this->_t(1) . '<th width="5" class="nowrap center hidden-phone" >';
				$head .= PHP_EOL . $this->_t(3) . "<?php echo JHtml::_('grid.sort', '" . $idLangName . "', 'id', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL . $this->_t(1) . "</th>";
			}
			$head .= PHP_EOL . "</tr>";

			return $head;
		}
		return '';
	}

	public function setListColnr($viewName_list)
	{
		if (isset($this->listColnrBuilder[$viewName_list]))
		{
			return $this->listColnrBuilder[$viewName_list];
		}
		return '';
	}

	/**
	 * set Tabs Layouts Fields Array
	 *
	 * @param   string   $view_name_single  The single view name
	 *
	 * @return  string   The array
	 *
	 */
	public function getTabLayoutFieldsArray($view_name_single)
	{
		// check if the load build is set for this view
		if (isset($this->layoutBuilder[$view_name_single]) && ComponentbuilderHelper::checkArray($this->layoutBuilder[$view_name_single]))
		{
			$layoutArray = array();
			foreach ($this->layoutBuilder[$view_name_single] as $layout => $alignments)
			{
				// sort the alignments
				ksort($alignments);
				$alignmentArray= array();
				foreach ($alignments as $alignment => $fields)
				{
					// sort the fields
					ksort($fields);
					$fieldArray= array();
					foreach ($fields as $field)
					{
						// add each field
						$fieldArray[] = PHP_EOL . $this->_t(4) . "'" . $field . "'";
					}
					// add the alignemnt key
					$alignmentArray[] = PHP_EOL . $this->_t(3) . "'" . $this->alignmentOptions[$alignment] . "' => array(" . implode(',', $fieldArray) . PHP_EOL . $this->_t(3) . ")";
				}
				// add the layout key
				$layoutArray[] = PHP_EOL . $this->_t(2) . "'" . ComponentbuilderHelper::safeString($layout) . "' => array(" . implode(',', $alignmentArray) . PHP_EOL . $this->_t(2) . ")";
			}
			return 'array(' . implode(',', $layoutArray) . PHP_EOL . $this->_t(1) . ")";
		}
		return 'array()';
	}

	/**
	 * set Edit Body
	 *
	 * @param   array    $view  The view data
	 *
	 * @return  string   The edit body
	 *
	 */
	public function setEditBody(&$view)
	{
		// set view name
		$view_name_single = ComponentbuilderHelper::safeString($view['settings']->name_single);
		// main lang prefix
		$langView = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($view_name_single, 'U');
		// check if the load build is set for this view
		if (isset($this->layoutBuilder[$view_name_single]) && ComponentbuilderHelper::checkArray($this->layoutBuilder[$view_name_single]))
		{
			// reset the linked keys
			$keys = array();
			$linkedViewIdentifier = array();
			// set the linked view tabs
			$linkedTab = $this->getEditBodyLinkedAdminViewsTabs($view, $view_name_single, $keys, $linkedViewIdentifier);
			// custom tab searching array
			$searchTabs = array();
			// reset tab values
			$leftside = '';
			$rightside = '';
			$footer = '';
			$header = '';
			$mainwidth = 12;
			$sidewidth = 0;
			// get the tabs with positions
			$tabBucket = $this->getEditBodyTabs($view_name_single, $langView, $linkedTab, $keys, $linkedViewIdentifier, $searchTabs, $leftside, $rightside, $footer, $header, $mainwidth, $sidewidth);
			// tab counter
			$tabCounter = 0;
			// check if width is still 12
			$span = '';
			if ($mainwidth != 12)
			{
				$span = 'span' . $mainwidth;
			}
			// start building body
			$body = PHP_EOL . '<div class="form-horizontal">';
			if (ComponentbuilderHelper::checkString($span))
			{
				$body .= PHP_EOL . $this->_t(1) . '<div class="' . $span . '">';
			}
			// now build the dynamic tabs
			foreach ($tabBucket as $tabCodeName => $positions)
			{
				// get lang string
				$tabLangName = $positions['lang'];
				// build main center position
				$main = '';
				$mainbottom = '';
				$this->setEditBodyTabMainCenterPositionDiv($main, $mainbottom, $positions);
				// set acctive tab (must be in side foreach loop to get active tab code name)
				if ($tabCounter == 0)
				{
					$body .= PHP_EOL . PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.startTabSet', '" . $view_name_single . "Tab', array('active' => '" . $tabCodeName . "')); ?>";
				}
				// check if custom tab must be added
				if (($_customTabHTML = $this->addCustomTabs($searchTabs[$tabCodeName], $view_name_single, 1)) !== false)
				{
					$body .= $_customTabHTML;
				}
				// if this is a linked view set permissions
				$closeIT = false;
				if (ComponentbuilderHelper::checkArray($linkedViewIdentifier) && in_array($tabCodeName, $linkedViewIdentifier))
				{
					// get view name
					$linkedViewId = array_search($tabCodeName, $linkedViewIdentifier);
					$linkedViewData = $this->getAdminViewData($linkedViewId);
					$linkedCodeName = ComponentbuilderHelper::safeString($linkedViewData->name_single);
					// setup correct core target
					$coreLoadLinked = false;
					if (isset($this->permissionCore[$linkedCodeName]))
					{
						$coreLinked = $this->permissionCore[$linkedCodeName];
						$coreLoadLinked = true;
					}
					// check if the item has permissions.
					if ($coreLoadLinked && isset($coreLinked['core.access']) && isset($this->permissionBuilder['global'][$coreLinked['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$coreLinked['core.access']]) && in_array($linkedCodeName, $this->permissionBuilder['global'][$coreLinked['core.access']]))
					{
						$body .= PHP_EOL . PHP_EOL . $this->_t(1) . "<?php if (\$this->canDo->get('" . $coreLinked['core.access'] . "')) : ?>";
						$closeIT = true;
					}
					else
					{
						$body .= PHP_EOL;
					}
					// insure clear
					unset($coreLoadLinked, $coreLinked, $linkedViewData);
				}
				else
				{
					$body .= PHP_EOL;
				}
				// start addtab body
				$body .= PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.addTab', '" . $view_name_single . "Tab', '" . $tabCodeName . "', JText:" . ":_('" . $tabLangName . "', true)); ?>";
				// add the main
				$body .= PHP_EOL . $this->_t(2) . '<div class="row-fluid form-horizontal-desktop">';
				$body .= $main;
				$body .= PHP_EOL . $this->_t(2) . "</div>";
				// add main body bottom div if needed
				if (strlen($mainbottom) > 0)
				{
					// add the main bottom
					$body .= PHP_EOL . $this->_t(2) . '<div class="row-fluid form-horizontal-desktop">';
					$body .= $mainbottom;
					$body .= PHP_EOL . $this->_t(2) . "</div>";
				}
				// end addtab body
				$body .= PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endTab'); ?>";
				// if we had permissions added
				if ($closeIT)
				{
					$body .= PHP_EOL . $this->_t(1) . "<?php endif; ?>";
				}
				// check if custom tab must be added
				if (($_customTabHTML = $this->addCustomTabs($searchTabs[$tabCodeName], $view_name_single, 2)) !== false)
				{
					$body .= $_customTabHTML;
				}
				// set counter
				$tabCounter++;
			}
			// add option to load forms loaded in via plugins (TODO) we may want to move these tab locations
			$body .= PHP_EOL . PHP_EOL . $this->_t(1) . "<?php \$this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>";
			$body .= PHP_EOL . $this->_t(1) . "<?php \$this->tab_name = '" . $view_name_single . "Tab'; ?>";
			$body .= PHP_EOL . $this->_t(1) . "<?php echo JLayoutHelper::render('joomla.edit.params', \$this); ?>";
			// add the publish and meta data tabs
			$body .= $this->getEditBodyPublishMetaTabs($view_name_single, $langView);
			// end the tab set
			$body .= PHP_EOL . PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endTabSet'); ?>";
			$body .= PHP_EOL . PHP_EOL . $this->_t(1) . "<div>";
			$body .= PHP_EOL . $this->_t(2) . '<input type="hidden" name="task" value="' . $view_name_single . '.edit" />';
			$body .= PHP_EOL . $this->_t(2) . "<?php echo JHtml::_('form.token'); ?>";
			$body .= PHP_EOL . $this->_t(1) . "</div>";
			// close divs
			if (ComponentbuilderHelper::checkString($span))
			{
				$body .= PHP_EOL . $this->_t(1) . "</div>";
			}
			$body .= PHP_EOL . "</div>";
			// check if left has been set
			if (strlen($leftside) > 0)
			{
				$left = '<div class="span' . $sidewidth . '">' . $leftside . PHP_EOL . "</div>";
			}
			else
			{
				$left = '';
			}
			// check if right has been set
			if (strlen($rightside) > 0)
			{
				$right = '<div class="span' . $sidewidth . '">' . $rightside . PHP_EOL . "</div>";
			}
			else
			{
				$right = '';
			}
			// set active tab and return
			return $header . $left . $body . $right . $footer;
		}
		return '';
	}

	/**
	 * get Edit Body Linked Admin Views
	 *
	 * @param   array    $view                   The view data
	 * @param   string   $view_name_single       The single view name
	 * @param   array    $keys                   The tabs to add in layout
	 * @param   array    $linkedViewIdentifier   The linked view identifier
	 *
	 * @return  array   The linked Admin Views tabs
	 *
	 */
	protected function getEditBodyLinkedAdminViewsTabs(&$view, &$view_name_single, &$keys, &$linkedViewIdentifier)
	{
		// start linked tabs bucket
		$linkedTab = array();
		// check if the view has linked admin view 
		if (isset($this->linkedAdminViews[$view_name_single]) && ComponentbuilderHelper::checkArray($this->linkedAdminViews[$view_name_single]))
		{
			foreach ($this->linkedAdminViews[$view_name_single] as $linkedView)
			{
				// get the tab name
				$tabName = $view['settings']->tabs[(int) $linkedView['tab']];
				// update the tab counter
				$this->tabCounter[$view_name_single][$linkedView['tab']] = $tabName;
				// add the linked view
				$linkedTab[$linkedView['adminview']] = $linkedView['tab'];
				// set the keys if values are set
				if (ComponentbuilderHelper::checkString($linkedView['key']) && ComponentbuilderHelper::checkString($linkedView['parentkey']))
				{
					$keys[$linkedView['adminview']] = array('key' => $linkedView['key'], 'parentKey' => $linkedView['parentkey']);
				}
				else
				{
					$keys[$linkedView['adminview']] = array('key' => null, 'parentKey' => null);
				}
				// set the button switches
				if (isset($linkedView['addnew']))
				{
					$keys[$linkedView['adminview']]['addNewButton'] = (int) $linkedView['addnew'];
				}
				else
				{
					$keys[$linkedView['adminview']]['addNewButton'] = 0;
				}
			}
		}
		return $linkedTab;
	}

	/**
	 * get Edit Body Tabs
	 *
	 * @param   string    $view_name_single        The single view name
	 * @param   string    $langView                The main lang prefix
	 * @param   array     $linkedTab               The linked admin view tabs
	 * @param   array     $keys                    The tabs to add in layout
	 * @param   array     $linkedViewIdentifier    The linked view identifier
	 * @param   array     $searchTabs              The tabs to add in layout
	 * @param   string    $leftside                The left side html string
	 * @param   string    $rightside               The right side html string
	 * @param   string    $footer                  The footer html string
	 * @param   string    $header                  The header html string
	 * @param   int       $mainwidth               The main width value
	 * @param   int       $sidewidth               The side width value
	 *
	 * @return  array   The linked tabs
	 *
	 */
	protected function getEditBodyTabs(&$view_name_single, &$langView, &$linkedTab, &$keys, &$linkedViewIdentifier, &$searchTabs, &$leftside, &$rightside, &$footer, &$header, &$mainwidth, &$sidewidth)
	{
		// start tabs 
		$tabs = array();
		// sort the tabs based on key order
		ksort($this->tabCounter[$view_name_single]);
		// start tab builinging loop
		foreach ($this->tabCounter[$view_name_single] as $tabNr => $tabName)
		{
			$tabWidth = 12;
			$lrCounter = 0;
			// set tab lang
			$tabLangName = $langView . '_' . ComponentbuilderHelper::safeString($tabName, 'U');
			// set tab code name
			$tabCodeName = ComponentbuilderHelper::safeString($tabName);
			/// set the values to use in search latter
			$searchTabs[$tabCodeName] = $tabNr;
			// add to lang array
			$this->setLangContent($this->lang, $tabLangName, $tabName);
			// check if linked view belongs to this tab
			$buildLayout = true;
			$linkedViewId = '';
			if (ComponentbuilderHelper::checkArray($linkedTab))
			{
				if (($linkedViewId = array_search($tabNr, $linkedTab)) !== false)
				{
					// don't build (since this is a linked view)
					$buildLayout = false;
				}
			}
			// build layout these are actual fields
			if ($buildLayout)
			{
				// sort to make sure it loads left first
				$alignments = $this->layoutBuilder[$view_name_single][$tabName];
				ksort($alignments);
				foreach ($alignments as $alignment => $names)
				{
					// set layout code name
					$layoutCodeName = $tabCodeName . '_' . $this->alignmentOptions[$alignment];
					// reset each time
					$items = '';
					$itemCounter = 0;
					// sort the names based on order of keys
					ksort($names);
					// build the items array for this alignment
					foreach ($names as $nr => $name)
					{
						if ($itemCounter == 0)
						{
							$items .= "'" . $name . "'";
						}
						else
						{
							$items .= "," . PHP_EOL . $this->_t(1) . "'" . $name . "'";
						}
						$itemCounter++;
					}
					// based on alignment build the layout
					switch ($alignment)
					{
						case 1: // left
						case 2: // right
							// count
							$lrCounter++;
							// set as items layout
							$this->setLayout($view_name_single, $layoutCodeName, $items, 'layoutitems');
							// set the lang to tab
							$tabs[$tabCodeName]['lang'] = $tabLangName;
							// load the body
							if (!isset($tabs[$tabCodeName][(int) $alignment]))
							{
								$tabs[$tabCodeName][(int) $alignment] = '';
							}
							$tabs[$tabCodeName][(int) $alignment] .= "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $layoutCodeName . "', \$this); ?>";
							break;
						case 3: // fullwidth
							// set as items layout
							$this->setLayout($view_name_single, $layoutCodeName, $items, 'layoutfull');
							// set the lang to tab
							$tabs[$tabCodeName]['lang'] = $tabLangName;
							// load the body
							if (!isset($tabs[$tabCodeName][(int) $alignment]))
							{
								$tabs[$tabCodeName][(int) $alignment] = '';
							}
							$tabs[$tabCodeName][(int) $alignment] .= "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $layoutCodeName . "', \$this); ?>";
							break;
						case 4: // above
							// set as title layout
							$this->setLayout($view_name_single, $layoutCodeName, $items, 'layouttitle');
							// load to header
							$header .= PHP_EOL . $this->_t(1) . "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $layoutCodeName . "', \$this); ?>";
							break;
						case 5: // under
							// set as title layout
							$this->setLayout($view_name_single, $layoutCodeName, $items, 'layouttitle');
							// load to footer
							$footer .= PHP_EOL . PHP_EOL . "<div class=\"clearfix\"></div>" . PHP_EOL . "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $layoutCodeName . "', \$this); ?>";
							break;
						case 6: // left side
							$tabWidth = $tabWidth - 2;
							// set as items layout
							$this->setLayout($view_name_single, $layoutCodeName, $items, 'layoutitems');
							// load the body
							$leftside .= PHP_EOL . $this->_t(1) . "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $layoutCodeName . "', \$this); ?>";
							break;
						case 7: // right side
							$tabWidth = $tabWidth - 2;
							// set as items layout
							$this->setLayout($view_name_single, $layoutCodeName, $items, 'layoutitems');
							// load the body
							$rightside .= PHP_EOL . $this->_t(1) . "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $layoutCodeName . "', \$this); ?>";
							break;
					}
				}
			}
			else
			{
				// set layout code name
				$layoutCodeName = $tabCodeName . '_fullwidth';
				// set identifiers
				$linkedViewIdentifier[$linkedViewId] = $tabCodeName;
				//set function name
				$codeName = ComponentbuilderHelper::safeString($this->uniquekey(3) . $tabCodeName);
				// set as items layout
				$this->setLayout($view_name_single, $layoutCodeName, $codeName, 'layoutlinkedview');
				// set the lang to tab
				$tabs[$tabCodeName]['lang'] = $tabLangName;
				// set all the linked view stuff
				$this->secondRunAdmin['setLinkedView'][] = array(
					'viewId' => $linkedViewId,
					'view_name_single' => $view_name_single,
					'codeName' => $codeName,
					'layoutCodeName' => $layoutCodeName,
					'key' => $keys[$linkedViewId]['key'],
					'parentKey' => $keys[$linkedViewId]['parentKey'],
					'addNewButon' => $keys[$linkedViewId]['addNewButton']);
				// load the body
				if (!isset($tabs[$tabCodeName][3]))
				{
					$tabs[$tabCodeName][3] = '';
				}
				$tabs[$tabCodeName][3] .= "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $layoutCodeName . "', \$this); ?>";
			}
			// width calculator :)
			if ($tabWidth == 8)
			{
				$mainwidth = 8;
				$sidewidth = 2;
			}
			elseif ($tabWidth == 10 && $mainwidth != 8)
			{
				$mainwidth = 9;
				$sidewidth = 3;
			}
			$tabs[$tabCodeName]['lr'] = $lrCounter;
		}
		return $tabs;
	}

	/**
	 * set Edit Body Main Center Positions Div
	 *
	 * @param   string    $main         The main position of this tab
	 * @param   string    $mainbottom   The main bottom position of this tab
	 * @param   array     $positions    The build positions of this tab
	 *
	 * @return  array   The linked Admin Views tabs
	 *
	 */
	protected function setEditBodyTabMainCenterPositionDiv(&$main, &$mainbottom, &$positions)
	{
		foreach ($positions as $position => $string)
		{
			if ($positions['lr'] == 2)
			{
				switch ($position)
				{
					case 1: // left
					case 2: // right
						$main .= PHP_EOL . $this->_t(3) . '<div class="span6">';
						$main .= PHP_EOL . $this->_t(4) . $string;
						$main .= PHP_EOL . $this->_t(3) . '</div>';
						break;
				}
			}
			else
			{
				switch ($position)
				{
					case 1: // left
					case 2: // right
						$main .= PHP_EOL . $this->_t(3) . '<div class="span12">';
						$main .= PHP_EOL . $this->_t(4) . $string;
						$main .= PHP_EOL . $this->_t(3) . '</div>';
						break;
				}
			}
			switch ($position)
			{
				case 3: // fullwidth
					$mainbottom .= PHP_EOL . $this->_t(3) . '<div class="span12">';
					$mainbottom .= PHP_EOL . $this->_t(4) . $string;
					$mainbottom .= PHP_EOL . $this->_t(3) . '</div>';
					break;
			}
		}
	}

	/**
	 * get Edit Body Publish and Meta Tab
	 *
	 * @param   string    $view_name_single    The single view name
	 * @param   string    $langView            The main lang prefix
	 *
	 * @return  string   The published and Meta Data Tabs
	 *
	 */
	protected function getEditBodyPublishMetaTabs(&$view_name_single, &$langView)
	{
		// build the two tabs
		$tabs = '';
		// set default publishing tab lang
		$tabLangName = $langView . '_PUBLISHING';
		// add to lang array
		$this->setLangContent($this->lang, $tabLangName, 'Publishing');
		// the default publishing items
		$items = array('left' => array(), 'right' => array());
		// Setup the default (custom) fields
		// only load (1 => 'left', 2 => 'right')
		$fieldsAddedRight = false;
		if (isset($this->newPublishingFields[$view_name_single]))
		{
			foreach ($this->newPublishingFields[$view_name_single] as $df_alignment => $df_items)
			{
				foreach ($df_items as $df_order => $df_name)
				{
					if ($df_alignment == 2 || $df_alignment == 1)
					{
						$items[$this->alignmentOptions[$df_alignment]][$df_order] = $df_name;
					}
					else
					{
						$this->app->enqueueMessage(JText::_('<hr /><h3>Field Warning</h3>'), 'Warning');
						$this->app->enqueueMessage(JText::sprintf('Your <b>%s</b> field could not be added, since the <b>%s</b> alignment position is not available in the %s (publishing) tab. Please only target <b>Left or right</b> in the publishing tab.', $df_name, $this->alignmentOptions[$df_alignment], $view_name_single), 'Warning');
					}
				}
			}
			// set switch to trigger notice if custom fields added to right
			if (ComponentbuilderHelper::checkArray($items['right']))
			{
				$fieldsAddedRight = true;
			}
		}
		// load all defaults
		$loadDefaultFields = array(
			'left' => array('created', 'created_by', 'modified', 'modified_by'),
			'right' => array('published', 'ordering', 'access', 'version', 'hits', 'id')
		);
		foreach ($loadDefaultFields as $d_alignment => $defaultFields)
		{
			foreach ($defaultFields as $defaultField)
			{
				if (!isset($this->movedPublishingFields[$view_name_single][$defaultField]))
				{
					if ($defaultField != 'access')
					{
						$items[$d_alignment][] = $defaultField;
					}
					elseif ($defaultField === 'access' && isset($this->accessBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view_name_single]))
					{
						$items[$d_alignment][] = $defaultField;
					}
				}
			}
		}
		// check if metadata is added to this view
		if (isset($this->metadataBuilder[$view_name_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view_name_single]))
		{
			// set default publishing tab code name
			$tabCodeNameLeft = 'publishing';
			$tabCodeNameRight = 'metadata';
			// the default publishing tiems
			if (ComponentbuilderHelper::checkArray($items['left']) || ComponentbuilderHelper::checkArray($items['right']))
			{
				$items_one = '';
				// load the items into one side
				if (ComponentbuilderHelper::checkArray($items['left']))
				{
					$items_one .= "'" . implode("'," . PHP_EOL . $this->_t(1) . "'", $items['left']) . "'";
				}
				if (ComponentbuilderHelper::checkArray($items['right']))
				{
					// there is already fields just add these
					if (strlen($items_one) > 3)
					{
						$items_one .= "," . PHP_EOL . $this->_t(1) . "'" . implode("'," . PHP_EOL . $this->_t(1) . "'", $items['right']) . "'";
					}
					// no fields has been added yet
					else
					{
						$items_one .= "'" . implode("'," . PHP_EOL . $this->_t(1) . "'", $items['right']) . "'";
					}
				}
				// only triger the info notice if there were custom fields targeted to the right alignment position.
				if ($fieldsAddedRight)
				{
					$this->app->enqueueMessage(JText::_('<hr /><h3>Field Notice</h3>'), 'Notice');
					$this->app->enqueueMessage(JText::sprintf('Your field/s added to the <b>right</b> alignment position in the %s (publishing) tab was added to the <b>left</b>. Since we have metadata fields on the right. Fields can only be loaded to the right of the publishing tab if there is no metadata fields.', $view_name_single), 'Notice');
				}
				// set the publishing layout
				$this->setLayout($view_name_single, $tabCodeNameLeft, $items_one, 'layoutpublished');
				$items_one = true;
			}
			else
			{
				$items_one = false;
			}
			// set the metadata layout
			$this->setLayout($view_name_single, $tabCodeNameRight, false, 'layoutmetadata');
			$items_two = true;
		}
		else
		{
			// set default publishing tab code name
			$tabCodeNameLeft = 'publishing';
			$tabCodeNameRight = 'publlshing';
			// the default publishing tiems
			if (ComponentbuilderHelper::checkArray($items['left']) || ComponentbuilderHelper::checkArray($items['right']))
			{
				// load left items that remain
				if (ComponentbuilderHelper::checkArray($items['left']))
				{
					// load all items
					$items_one = "'" . implode("'," . PHP_EOL . $this->_t(1) . "'", $items['left']) . "'";
					// set the publishing layout
					$this->setLayout($view_name_single, $tabCodeNameLeft, $items_one, 'layoutpublished');
					$items_one = true;
				}
				// load right items that remain
				if (ComponentbuilderHelper::checkArray($items['right']))
				{
					// load all items
					$items_two = "'" . implode("'," . PHP_EOL . $this->_t(1) . "'", $items['right']) . "'";
					// set the publishing layout
					$this->setLayout($view_name_single, $tabCodeNameRight, $items_two, 'layoutpublished');
					$items_two = true;
				}
			}
			else
			{
				$items_one = false;
				$items_two = false;
			}
		}
		if ($items_one && $items_two)
		{
			$classs = "span6";
		}
		elseif ($items_one || $items_two)
		{
			$classs = "span12";
		}
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$view_name_single]))
		{
			$core = $this->permissionCore[$view_name_single];
			$coreLoad = true;
		}
		// only load this if needed
		if ($items_one || $items_two)
		{
			// check if the item has permissions.
			$publishingPer = array();
			$allToBeChekced = array('core.delete', 'core.edit.created_by', 'core.edit.state', 'core.edit.created');
			foreach ($allToBeChekced as $core_permission)
			{
				if ($coreLoad && isset($core[$core_permission]) && isset($this->permissionBuilder['global'][$core[$core_permission]]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core[$core_permission]]) && in_array($view_name_single, $this->permissionBuilder['global'][$core[$core_permission]]))
				{
					// set permissions.
					$publishingPer[] = "\$this->canDo->get('" . $core[$core_permission] . "')";
				}
				else
				{
					// set permissions.
					$publishingPer[] = "\$this->canDo->get('" . $core_permission . "')";
				}
			}
			// check if custom tab must be added
			if (($_customTabHTML = $this->addCustomTabs(15, $view_name_single, 1)) !== false)
			{
				$tabs .= $_customTabHTML;
			}
			$tabs .= PHP_EOL . PHP_EOL . $this->_t(1) . "<?php if (" . implode(' || ', $publishingPer) . ") : ?>";
			// set the default publishing tab
			$tabs .= PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.addTab', '" . $view_name_single . "Tab', '" . $tabCodeNameLeft . "', JText:" . ":_('" . $tabLangName . "', true)); ?>";
			$tabs .= PHP_EOL . $this->_t(2) . '<div class="row-fluid form-horizontal-desktop">';
			if ($items_one)
			{
				$tabs .= PHP_EOL . $this->_t(3) . '<div class="' . $classs . '">';
				$tabs .= PHP_EOL . $this->_t(4) . "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $tabCodeNameLeft . "', \$this); ?>";
				$tabs .= PHP_EOL . $this->_t(3) . "</div>";
			}
			if ($items_two)
			{
				$tabs .= PHP_EOL . $this->_t(3) . '<div class="' . $classs . '">';
				$tabs .= PHP_EOL . $this->_t(4) . "<?php echo JLayoutHelper::render('" . $view_name_single . "." . $tabCodeNameRight . "', \$this); ?>";
				$tabs .= PHP_EOL . $this->_t(3) . "</div>";
			}
			$tabs .= PHP_EOL . $this->_t(2) . "</div>";
			$tabs .= PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$tabs .= PHP_EOL . $this->_t(1) . "<?php endif; ?>";
			// check if custom tab must be added
			if (($_customTabHTML = $this->addCustomTabs(15, $view_name_single, 2)) !== false)
			{
				$tabs .= $_customTabHTML;
			}
		}

		// make sure we dont load it to a view with the name component (as this will cause conflict with Joomla conventions)
		if ($view_name_single != 'component')
		{
			// set permissions tab lang
			$tabLangName = $langView . '_PERMISSION';
			// set permissions tab code name
			$tabCodeName = 'permissions';
			// add to lang array
			$this->setLangContent($this->lang, $tabLangName, 'Permissions');
			// set the permissions tab
			$tabs .= PHP_EOL . PHP_EOL . $this->_t(1) . "<?php if (\$this->canDo->get('core.admin')) : ?>";
			$tabs .= PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.addTab', '" . $view_name_single . "Tab', '" . $tabCodeName . "', JText:" . ":_('" . $tabLangName . "', true)); ?>";
			$tabs .= PHP_EOL . $this->_t(2) . '<div class="row-fluid form-horizontal-desktop">';
			$tabs .= PHP_EOL . $this->_t(3) . '<div class="span12">';
			$tabs .= PHP_EOL . $this->_t(4) . '<fieldset class="adminform">';
			$tabs .= PHP_EOL . $this->_t(5) . '<div class="adminformlist">';
			$tabs .= PHP_EOL . $this->_t(5) . "<?php foreach (\$this->form->getFieldset('accesscontrol') as \$field): ?>";
			$tabs .= PHP_EOL . $this->_t(6) . "<div>";
			$tabs .= PHP_EOL . $this->_t(7) . "<?php echo \$field->label; echo \$field->input;?>";
			$tabs .= PHP_EOL . $this->_t(6) . "</div>";
			$tabs .= PHP_EOL . $this->_t(6) . '<div class="clearfix"></div>';
			$tabs .= PHP_EOL . $this->_t(5) . "<?php endforeach; ?>";
			$tabs .= PHP_EOL . $this->_t(5) . "</div>";
			$tabs .= PHP_EOL . $this->_t(4) . "</fieldset>";
			$tabs .= PHP_EOL . $this->_t(3) . "</div>";
			$tabs .= PHP_EOL . $this->_t(2) . "</div>";
			$tabs .= PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endTab'); ?>";
			$tabs .= PHP_EOL . $this->_t(1) . "<?php endif; ?>";
		}
		return $tabs;
	}

	protected function addCustomTabs($nr, $name_single, $target)
	{
		// check if this view is having custom tabs
		if (isset($this->customTabs[$name_single]) && ComponentbuilderHelper::checkArray($this->customTabs[$name_single]))
		{
			$html = array();
			foreach ($this->customTabs[$name_single] as $customTab)
			{
				if (ComponentbuilderHelper::checkArray($customTab) && isset($customTab['html']))
				{
					if ($customTab['tab'] == $nr && $customTab['position'] == $target
						&& isset($customTab['html']) && ComponentbuilderHelper::checkString($customTab['html']))
					{
						$html[] = $customTab['html'];
					}
				}
			}
			// return if found
			if (ComponentbuilderHelper::checkArray($html))
			{
				return PHP_EOL . implode(PHP_EOL, $html);
			}
		}
		return false;
	}

	public function setFadeInEfect(&$view)
	{
		// check if we should load the fade in affect
		if ($view['settings']->add_fadein == 1)
		{
			// set view name
			$fadein[] = "<script type=\"text/javascript\">";
			$fadein[] = $this->_t(1) . "// waiting spinner";
			$fadein[] = $this->_t(1) . "var outerDiv = jQuery('body');";
			$fadein[] = $this->_t(1) . "jQuery('<div id=\"loading\"></div>')";
			$fadein[] = $this->_t(2) . ".css(\"background\", \"rgba(255, 255, 255, .8) url('components/com_" . $this->componentCodeName . "/assets/images/import.gif') 50% 15% no-repeat\")";
			$fadein[] = $this->_t(2) . ".css(\"top\", outerDiv.position().top - jQuery(window).scrollTop())";
			$fadein[] = $this->_t(2) . ".css(\"left\", outerDiv.position().left - jQuery(window).scrollLeft())";
			$fadein[] = $this->_t(2) . ".css(\"width\", outerDiv.width())";
			$fadein[] = $this->_t(2) . ".css(\"height\", outerDiv.height())";
			$fadein[] = $this->_t(2) . ".css(\"position\", \"fixed\")";
			$fadein[] = $this->_t(2) . ".css(\"opacity\", \"0.80\")";
			$fadein[] = $this->_t(2) . ".css(\"-ms-filter\", \"progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)\")";
			$fadein[] = $this->_t(2) . ".css(\"filter\", \"alpha(opacity = 80)\")";
			$fadein[] = $this->_t(2) . ".css(\"display\", \"none\")";
			$fadein[] = $this->_t(2) . ".appendTo(outerDiv);";
			$fadein[] = $this->_t(1) . "jQuery('#loading').show();";
			$fadein[] = $this->_t(1) . "// when page is ready remove and show";
			$fadein[] = $this->_t(1) . "jQuery(window).load(function() {";
			$fadein[] = $this->_t(2) . "jQuery('#" . $this->componentCodeName . "_loader').fadeIn('fast');";
			$fadein[] = $this->_t(2) . "jQuery('#loading').hide();";
			$fadein[] = $this->_t(1) . "});";
			$fadein[] = "</script>";
			$fadein[] = "<div id=\"" . $this->componentCodeName . "_loader\" style=\"display: none;\">";

			return implode(PHP_EOL, $fadein);
		}
		return "<div id=\"" . $this->componentCodeName . "_loader\">";
	}

	/**
	 * @param $viewName_single
	 * @param $layoutName
	 * @param $items
	 * @param $type
	 */
	public function setLayout($viewName_single, $layoutName, $items, $type)
	{
		// first build the layout file
		$target = array('admin' => $viewName_single);
		$this->buildDynamique($target, $type, $layoutName);
		// add to front if needed
		if ($this->lang === 'both')
		{
			$target = array('site' => $viewName_single);
			$this->buildDynamique($target, $type, $layoutName);
		}
		if (ComponentbuilderHelper::checkString($items))
		{
			// LAYOUTITEMS <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single . '_' . $layoutName][$this->hhh . 'LAYOUTITEMS' . $this->hhh] = $items;
		}
		else
		{
			// LAYOUTITEMS <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single . '_' . $layoutName][$this->hhh . 'bogus' . $this->hhh] = 'boom';
		}
	}

	/**
	 * @param $args
	 */
	public function setLinkedView($args)
	{
		/**
		 * @var $viewId
		 * @var $view_name_single
		 * @var $codeName
		 * @var $layoutCodeName
		 * @var $key
		 * @var $parentKey
		 * @var $addNewButon
		 */
		extract($args, EXTR_PREFIX_SAME, "oops");
		$single = '';
		$list = '';
		foreach ($this->componentData->admin_views as $array)
		{
			if ($array['adminview'] == $viewId)
			{
				$single = ComponentbuilderHelper::safeString($array['settings']->name_single);
				$list = ComponentbuilderHelper::safeString($array['settings']->name_list);
				break;
			}
		}
		if (ComponentbuilderHelper::checkString($single) && ComponentbuilderHelper::checkString($list))
		{
			$head = $this->setListHeadLinked($single, $list, $addNewButon, $view_name_single);
			$body = $this->setListBodyLinked($single, $list, $view_name_single);
			$functionName = ComponentbuilderHelper::safeString($codeName, 'F');
			// LAYOUTITEMSTABLE <<<DYNAMIC>>>
			$this->fileContentDynamic[$view_name_single . '_' . $layoutCodeName][$this->hhh . 'LAYOUTITEMSTABLE' . $this->hhh] = $head . $body;
			// LAYOUTITEMSHEADER <<<DYNAMIC>>>
			$headerscript = '//' . $this->setLine(__LINE__) . ' set the edit URL';
			$headerscript .= PHP_EOL . '$edit = "index.php?option=com_' . $this->componentCodeName . '&view=' . $list . '&task=' . $single . '.edit";';
			$headerscript .= PHP_EOL . '//' . $this->setLine(__LINE__) . ' set a return value';
			$headerscript .= PHP_EOL . '$return = ($id) ? "index.php?option=com_' . $this->componentCodeName . '&view=' . $view_name_single . '&layout=edit&id=" . $id : "";';
			$headerscript .= PHP_EOL . '//' . $this->setLine(__LINE__) . ' check for a return value';
			$headerscript .= PHP_EOL . '$jinput = JFactory::getApplication()->input;';
			$headerscript .= PHP_EOL . "if (\$_return = \$jinput->get('return', null, 'base64'))";
			$headerscript .= PHP_EOL . '{';
			$headerscript .= PHP_EOL . $this->_t(1) . '$return .= "&return=" . $_return;';
			$headerscript .= PHP_EOL . '}';
			$headerscript .= PHP_EOL . '//' . $this->setLine(__LINE__) . ' check if return value was set';
			$headerscript .= PHP_EOL . 'if (' . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper::checkString($return))';
			$headerscript .= PHP_EOL . '{';
			$headerscript .= PHP_EOL . $this->_t(1) . '//' . $this->setLine(__LINE__) . ' set the referral values';
			$headerscript .= PHP_EOL . $this->_t(1) . '$ref = ($id) ? "&ref=' . $view_name_single . '&refid=" . $id . "&return=" . urlencode(base64_encode($return)) : "&return=" . urlencode(base64_encode($return));';
			$headerscript .= PHP_EOL . '}';
			$headerscript .= PHP_EOL . 'else';
			$headerscript .= PHP_EOL . '{';
			$headerscript .= PHP_EOL . $this->_t(1) . '$ref = ($id) ? "&ref=' . $view_name_single . '&refid=" . $id : "";';
			$headerscript .= PHP_EOL . '}';
			if ($addNewButon > 0)
			{
				// add the link for new
				if ($addNewButon == 1 || $addNewButon == 2)
				{
					$headerscript .= PHP_EOL . '//' . $this->setLine(__LINE__) . ' set the create new URL';
					$headerscript .= PHP_EOL . '$new = "index.php?option=com_' . $this->componentCodeName . '&view=' . $list . '&task=' . $single . '.edit" . $ref;';
				}
				// and the link for close and new
				if ($addNewButon == 2 || $addNewButon == 3)
				{
					$headerscript .= PHP_EOL . '//' . $this->setLine(__LINE__) . ' set the create new and close URL';
					$headerscript .= PHP_EOL . '$close_new = "index.php?option=com_' . $this->componentCodeName . '&view=' . $list . '&task=' . $single . '.edit";';
				}
				$headerscript .= PHP_EOL . '//' . $this->setLine(__LINE__) . ' load the action object';
				$headerscript .= PHP_EOL . '$can = ' . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper::getActions(' . "'" . $single . "'" . ');';
			}
			$this->fileContentDynamic[$view_name_single . '_' . $layoutCodeName][$this->hhh . 'LAYOUTITEMSHEADER' . $this->hhh] = $headerscript;
			// LINKEDVIEWITEMS <<<DYNAMIC>>>
			$this->fileContentDynamic[$view_name_single][$this->hhh . 'LINKEDVIEWITEMS' . $this->hhh] .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get Linked view data" . PHP_EOL . $this->_t(2) . "\$this->" . $codeName . " = \$this->get('" . $functionName . "');";
			// LINKEDVIEWTABLESCRIPTS <<<DYNAMIC>>>
			$this->fileContentDynamic[$view_name_single][$this->hhh . 'LINKEDVIEWTABLESCRIPTS' . $this->hhh] = $this->setFootableScripts();
			if (strpos($parentKey, '-R>') !== false || strpos($parentKey, '-A>') !== false)
			{
				list($parent_key) = explode('-', $parentKey);
			}
			elseif (strpos($parentKey, '-OR>') !== false)
			{
				// this is not good... (TODO)
				$parent_keys = explode('-OR>', $parentKey);
			}
			else
			{
				$parent_key = $parentKey;
			}

			if (strpos($key, '-R>') !== false || strpos($key, '-A>') !== false)
			{
				list($_key) = explode('-', $key);
			}
			elseif (strpos($key, '-OR>') !== false)
			{
				$_key = str_replace('-OR>', '', $key);
			}
			else
			{
				$_key = $key;
			}
			// LINKEDVIEWGLOBAL <<<DYNAMIC>>>
			if (isset($parent_keys) && ComponentbuilderHelper::checkArray($parent_keys))
			{
				$globalKey = array();
				foreach ($parent_keys as $parent_key)
				{
					$globalKey[$parent_key] = ComponentbuilderHelper::safeString($_key . $this->uniquekey(4));
					$this->fileContentDynamic[$view_name_single][$this->hhh . 'LINKEDVIEWGLOBAL' . $this->hhh] .= PHP_EOL . $this->_t(2) . "\$this->" . $globalKey[$parent_key] . " = \$item->" . $parent_key . ";";
				}
			}
			else
			{
				// set the global key
				$globalKey = ComponentbuilderHelper::safeString($_key . $this->uniquekey(4));
				$this->fileContentDynamic[$view_name_single][$this->hhh . 'LINKEDVIEWGLOBAL' . $this->hhh] .= PHP_EOL . $this->_t(2) . "\$this->" . $globalKey . " = \$item->" . $parent_key . ";";
			}
			// LINKEDVIEWMETHODS <<<DYNAMIC>>>
			$this->fileContentDynamic[$view_name_single][$this->hhh . 'LINKEDVIEWMETHODS' . $this->hhh] .= $this->setListQueryLinked($single, $list, $functionName, $key, $_key, $parentKey, $parent_key, $globalKey);
		}
		else
		{
			$this->fileContentDynamic[$view_name_single . '_' . $layoutCodeName][$this->hhh . 'LAYOUTITEMSTABLE' . $this->hhh] = 'oops! error.....';
			$this->fileContentDynamic[$view_name_single . '_' . $layoutCodeName][$this->hhh . 'LAYOUTITEMSHEADER' . $this->hhh] = '';
		}
	}

	/**
	 * @param bool $init
	 * @return string
	 */
	public function setFootableScripts($init = true)
	{
		if (!isset($this->footableVersion) || 2 == $this->footableVersion) // loading version 2
		{
			$foo = PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add the CSS for Footable.";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addStyleSheet(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v2/css/footable.core.min.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$foo .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Use the Metro Style";
			$foo .= PHP_EOL . $this->_t(2) . "if (!isset(\$this->fooTableStyle) || 0 == \$this->fooTableStyle)";
			$foo .= PHP_EOL . $this->_t(2) . "{";
			$foo .= PHP_EOL . $this->_t(3) . "\$this->document->addStyleSheet(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v2/css/footable.metro.min.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$foo .= PHP_EOL . $this->_t(2) . "}";
			$foo .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Use the Legacy Style.";
			$foo .= PHP_EOL . $this->_t(2) . "elseif (isset(\$this->fooTableStyle) && 1 == \$this->fooTableStyle)";
			$foo .= PHP_EOL . $this->_t(2) . "{";
			$foo .= PHP_EOL . $this->_t(3) . "\$this->document->addStyleSheet(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v2/css/footable.standalone.min.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$foo .= PHP_EOL . $this->_t(2) . "}";
			$foo .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add the JavaScript for Footable";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addScript(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v2/js/footable.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addScript(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v2/js/footable.sort.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addScript(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v2/js/footable.filter.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addScript(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v2/js/footable.paginate.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			if ($init)
			{
				$foo .= PHP_EOL . PHP_EOL . $this->_t(2) . '$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery(' . "'.footable'" . ').footable(); }); jQuery(' . "'.nav-tabs'" . ').on(' . "'click'" . ', ' . "'li'" . ', function() { setTimeout(tableFix, 10); }); }); function tableFix() { jQuery(' . "'.footable'" . ').trigger(' . "'footable_resize'" . '); }";';
				$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addScriptDeclaration(\$footable);" . PHP_EOL;
			}
		}
		elseif (3 == $this->footableVersion) // loading version 3
		{

			$foo = PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add the CSS for Footable";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addStyleSheet('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addStyleSheet(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v3/css/footable.standalone.min.css', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');";
			$foo .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add the JavaScript for Footable (adding all funtions)";
			$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addScript(JURI::root() .'media/com_" . $this->componentCodeName . "/footable-v3/js/footable.min.js', (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');";
			if ($init)
			{
				$foo .= PHP_EOL . PHP_EOL . $this->_t(2) . '$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery(' . "'.footable'" . ').footable();});});";';
				$foo .= PHP_EOL . $this->_t(2) . "\$this->document->addScriptDeclaration(\$footable);" . PHP_EOL;
			}
		}
		return $foo;
	}

	/**
	 * set the list body of the linked admin view
	 *
	 * @param string $viewName_single
	 * @param string $viewName_list
	 * @param string $refview
	 *
	 * @return string
	 */
	public function setListBodyLinked($viewName_single, $viewName_list, $refview)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper';
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// setup correct core target
			$coreLoad = false;
			$core = null;
			if (isset($this->permissionCore[$viewName_single]))
			{
				$core = $this->permissionCore[$viewName_single];
				$coreLoad = true;
			}
			$counter = 0;
			// add the default
			$body = PHP_EOL . "<tbody>";
			$body .= PHP_EOL . "<?php foreach (\$items as \$i => \$item): ?>";
			$body .= PHP_EOL . $this->_t(1) . "<?php";
			$body .= PHP_EOL . $this->_t(2) . "\$canCheckin = \$user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$user->id || \$item->checked_out == 0;";
			$body .= PHP_EOL . $this->_t(2) . "\$userChkOut = JFactory::getUser(\$item->checked_out);";
			$body .= PHP_EOL . $this->_t(2) . "\$canDo = " . $Helper . "::getActions('" . $viewName_single . "',\$item,'" . $viewName_list . "');";
			$body .= PHP_EOL . $this->_t(1) . "?>";
			$body .= PHP_EOL . $this->_t(1) . '<tr>';
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (isset($this->doNotEscape[$viewName_list]))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				// check if target is linked list view
				if (1 == $item['target'] || 4 == $item['target'])
				{
					// set the ref
					$ref = '<?php echo $ref; ?>';
					// set some defaults
					$customAdminViewButtons = '';
					// set the item row
					$itemRow = $this->getListItemBuilder($item, $viewName_single, $viewName_list, $itemClass, $doNotEscape, $coreLoad, $core, false, $ref, '$displayData->escape', '$user', $refview);
					// check if buttons was aready added
					if ($firstTimeBeingAdded) // TODO we must improve this to allow more items to be targeted instead of just the first item :)
					{
						// get custom admin view buttons
						$customAdminViewButtons = $this->getCustomAdminViewButtons($viewName_list, $ref);
						// make sure the custom admin view buttons are only added once
						$firstTimeBeingAdded = false;
					}
					// add row to body
					$body .= PHP_EOL . $this->_t(2) . "<td>";
					$body .= $itemRow;
					$body .= $customAdminViewButtons;
					$body .= PHP_EOL . $this->_t(2) . "</td>";
					// increment counter
					$counter++;
				}
			}
			$counter = $counter + 2;
			$data_value = (3 == $this->footableVersion) ? 'data-sort-value' : 'data-value';
			// add the defaults
			$body .= PHP_EOL . $this->_t(2) . "<?php if (\$item->published == 1):?>";
			$body .= PHP_EOL . $this->_t(3) . '<td class="center"  ' . $data_value . '="1">';
			$body .= PHP_EOL . $this->_t(4) . '<span class="status-metro status-published" title="<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_PUBLISHED'" . ');  ?>">';
			$body .= PHP_EOL . $this->_t(5) . '<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_PUBLISHED'" . '); ?>';
			$body .= PHP_EOL . $this->_t(4) . '</span>';
			$body .= PHP_EOL . $this->_t(3) . '</td>';

			$body .= PHP_EOL . $this->_t(2) . "<?php elseif (\$item->published == 0):?>";
			$body .= PHP_EOL . $this->_t(3) . '<td class="center"  ' . $data_value . '="2">';
			$body .= PHP_EOL . $this->_t(4) . '<span class="status-metro status-inactive" title="<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_INACTIVE'" . ');  ?>">';
			$body .= PHP_EOL . $this->_t(5) . '<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_INACTIVE'" . '); ?>';
			$body .= PHP_EOL . $this->_t(4) . '</span>';
			$body .= PHP_EOL . $this->_t(3) . '</td>';

			$body .= PHP_EOL . $this->_t(2) . "<?php elseif (\$item->published == 2):?>";
			$body .= PHP_EOL . $this->_t(3) . '<td class="center"  ' . $data_value . '="3">';
			$body .= PHP_EOL . $this->_t(4) . '<span class="status-metro status-archived" title="<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_ARCHIVED'" . ');  ?>">';
			$body .= PHP_EOL . $this->_t(5) . '<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_ARCHIVED'" . '); ?>';
			$body .= PHP_EOL . $this->_t(4) . '</span>';
			$body .= PHP_EOL . $this->_t(3) . '</td>';

			$body .= PHP_EOL . $this->_t(2) . "<?php elseif (\$item->published == -2):?>";
			$body .= PHP_EOL . $this->_t(3) . '<td class="center"  ' . $data_value . '="4">';
			$body .= PHP_EOL . $this->_t(4) . '<span class="status-metro status-trashed" title="<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_TRASHED'" . ');  ?>">';
			$body .= PHP_EOL . $this->_t(5) . '<?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_TRASHED'" . '); ?>';
			$body .= PHP_EOL . $this->_t(4) . '</span>';
			$body .= PHP_EOL . $this->_t(3) . '</td>';
			$body .= PHP_EOL . $this->_t(2) . '<?php endif; ?>';

			$body .= PHP_EOL . $this->_t(2) . '<td class="nowrap center hidden-phone">';
			$body .= PHP_EOL . $this->_t(3) . "<?php echo \$item->id; ?>";
			$body .= PHP_EOL . $this->_t(2) . "</td>";
			$body .= PHP_EOL . $this->_t(1) . "</tr>";
			$body .= PHP_EOL . "<?php endforeach; ?>";
			$body .= PHP_EOL . "</tbody>";
			if (2 == $this->footableVersion)
			{
				$body .= PHP_EOL . '<tfoot class="hide-if-no-paging">';
				$body .= PHP_EOL . $this->_t(1) . '<tr>';
				$body .= PHP_EOL . $this->_t(2) . '<td colspan="' . $counter . '">';
				$body .= PHP_EOL . $this->_t(3) . '<div class="pagination pagination-centered"></div>';
				$body .= PHP_EOL . $this->_t(2) . '</td>';
				$body .= PHP_EOL . $this->_t(1) . '</tr>';
				$body .= PHP_EOL . '</tfoot>';
			}
			$body .= PHP_EOL . '</table>';
			$body .= PHP_EOL . '<?php else: ?>';
			$body .= PHP_EOL . $this->_t(1) . '<div class="alert alert-no-items">';
			$body .= PHP_EOL . $this->_t(2) . '<?php echo JText:' . ':_(' . "'JGLOBAL_NO_MATCHING_RESULTS'" . '); ?>';
			$body .= PHP_EOL . $this->_t(1) . '</div>';
			$body .= PHP_EOL . '<?php endif; ?>';
			// return the build
			return $body;
		}
		return '';
	}

	/**
	 * set the list body table head linked admin view
	 *
	 * @param string $viewName_single
	 * @param string $viewName_list
	 * @param bool   $addNewButon
	 * @param string $refview
	 *
	 * @return string
	 */
	public function setListHeadLinked($viewName_single, $viewName_list, $addNewButon, $refview)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper';
			$head = '';
			// only add new button if set
			if ($addNewButon > 0)
			{
				// setup correct core target
				$coreLoad = false;
				if (isset($this->permissionCore[$viewName_single]))
				{
					$core = $this->permissionCore[$viewName_single];
					$coreLoad = true;
				}
				// check if the item has permissions.
				if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.create']]))
				{
					// set permissions.
					$accessCheck = "\$can->get('" . $core['core.create'] . "')";
				}
				else
				{
					// set permissions.
					$accessCheck = "\$can->get('core.create')";
				}
				// add a button for new
				$head = '<?php if (' . $accessCheck . '): ?>';
				// make group button if needed
				$tabB = "";
				if ($addNewButon == 2)
				{
					$head .= PHP_EOL . $this->_t(1) . '<div class="btn-group">';
					$tabB = $this->_t(1);
				}
				// add the new buttons
				if ($addNewButon == 1 || $addNewButon == 2)
				{
					$head .= PHP_EOL . $tabB . $this->_t(1) . '<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_NEW'" . '); ?></a>';
				}
				// add the close and new button
				if ($addNewButon == 2 || $addNewButon == 3)
				{
					$head .= PHP_EOL . $tabB . $this->_t(1) . '<a class="btn btn-small" onclick="Joomla.submitbutton(\'' . $refview . '.cancel\');" href="<?php echo $close_new; ?>"><span class="icon-new"></span> <?php echo JText:' . ':_(' . "'" . $this->langPrefix . "_CLOSE_NEW'" . '); ?></a>';
				}
				// close group button if needed
				if ($addNewButon == 2)
				{
					$head .= PHP_EOL . $this->_t(1) . '</div><br /><br />';
				}
				else
				{
					$head .= '<br /><br />';
				}
				$head .= PHP_EOL . '<?php endif; ?>' . PHP_EOL;
			}
			$head .= '<?php if (' . $Helper . '::checkArray($items)): ?>';
			// set the style for V2
			$metro_blue = (2 == $this->footableVersion) ? ' metro-blue' : '';
			// set the toggle for V3
			$toggle = (3 == $this->footableVersion) ? ' data-show-toggle="true" data-toggle-column="first"' : '';
			// set paging
			$paging = (2 == $this->footableVersion) ? ' data-page-size="20" data-filter="#filter_' . $viewName_list . '"' : ' data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true"';
			// add html fix for V3
			$htmlFix = (3 == $this->footableVersion) ? ' data-type="html" data-sort-use="text"' : '';
			$head .= PHP_EOL . '<table class="footable table data ' . $viewName_list . $metro_blue . '"' . $toggle . $paging . '>';
			$head .= PHP_EOL . "<thead>";
			// main lang prefix
			$langView = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($viewName_single, 'U');
			// set status lang
			$statusLangName = $langView . '_STATUS';
			// set id lang
			$idLangName = $langView . '_ID';
			// make sure only first link is used as togeler
			$firstLink = true;
			// add to lang array
			$this->setLangContent($this->lang, $statusLangName, 'Status');
			// add to lang array
			$this->setLangContent($this->lang, $idLangName, 'Id');
			$head .= PHP_EOL . $this->_t(1) . "<tr>";
			// set controller for data hiding options
			$controller = 1;
			// build the dynamic fields
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				// check if target is linked list view
				if (1 == $item['target'] || 4 == $item['target'])
				{
					// check if we have an over-ride
					if (isset($this->listHeadOverRide[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listHeadOverRide[$viewName_list]) && isset($this->listHeadOverRide[$viewName_list][$item['id']]))
					{
						$item['lang'] = $this->listHeadOverRide[$viewName_list][$item['id']];
					}
					$setin = (2 == $this->footableVersion) ? ' data-hide="phone"' : ' data-breakpoints="xs sm"';
					if ($controller > 3)
					{
						$setin = (2 == $this->footableVersion) ? ' data-hide="phone,tablet"' : ' data-breakpoints="xs sm md"';
					}

					if ($controller > 6)
					{
						$setin = (2 == $this->footableVersion) ? ' data-hide="all"' : ' data-breakpoints="all"';
					}

					if ($item['link'] && $firstLink)
					{
						$setin = (2 == $this->footableVersion) ? ' data-toggle="true"' : '';
						$firstLink = false;
					}
					$head .= PHP_EOL . $this->_t(2) . "<th" . $setin . $htmlFix . ">";
					$head .= PHP_EOL . $this->_t(3) . "<?php echo JText:" . ":_('" . $item['lang'] . "'); ?>";
					$head .= PHP_EOL . $this->_t(2) . "</th>";
					$controller++;
				}
			}
			// set some V3 attr
			$data_hide = (2 == $this->footableVersion) ? 'data-hide="phone,tablet"' : 'data-breakpoints="xs sm md"';
			$data_type = (2 == $this->footableVersion) ? 'data-type="numeric"' : 'data-type="number"';
			// set default
			$head .= PHP_EOL . $this->_t(2) . '<th width="10" ' . $data_hide . '>';
			$head .= PHP_EOL . $this->_t(3) . "<?php echo JText:" . ":_('" . $statusLangName . "'); ?>";
			$head .= PHP_EOL . $this->_t(2) . "</th>";
			$head .= PHP_EOL . $this->_t(2) . '<th width="5" ' . $data_type . ' ' . $data_hide . '>';
			$head .= PHP_EOL . $this->_t(3) . "<?php echo JText:" . ":_('" . $idLangName . "'); ?>";
			$head .= PHP_EOL . $this->_t(2) . "</th>";
			$head .= PHP_EOL . $this->_t(1) . "</tr>";
			$head .= PHP_EOL . "</thead>";

			return $head;
		}
		return '';
	}

	/**
	 * @param $viewName_single
	 * @param $viewName_list
	 * @param $functionName
	 * @param $key
	 * @param $_key
	 * @param $parentKey
	 * @param $parent_key
	 * @param $globalKey
	 * @return string
	 */
	public function setListQueryLinked($viewName_single, $viewName_list, $functionName, $key, $_key, $parentKey, $parent_key, $globalKey)
	{
		// check if this view has category added
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			$categoryCodeName = $this->categoryBuilder[$viewName_list]['code'];
			$addCategory = true;
		}
		else
		{
			$addCategory = false;
		}
		$query = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$query .= PHP_EOL . $this->_t(1) . " * Method to get list data.";
		$query .= PHP_EOL . $this->_t(1) . " *";
		$query .= PHP_EOL . $this->_t(1) . " * @return mixed  An array of data items on success, false on failure.";
		$query .= PHP_EOL . $this->_t(1) . " */";
		$query .= PHP_EOL . $this->_t(1) . "public function get" . $functionName . "()";
		$query .= PHP_EOL . $this->_t(1) . "{";
		// setup the query
		$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the user object.";
		$query .= PHP_EOL . $this->_t(2) . "\$user = JFactory::getUser();";
		$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
		$query .= PHP_EOL . $this->_t(2) . "\$db = JFactory::getDBO();";
		$query .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select some fields";
		$query .= PHP_EOL . $this->_t(2) . "\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . $this->_t(2) . "\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " From the " . $this->componentCodeName . "_" . $viewName_single . " table";
		$query .= PHP_EOL . $this->_t(2) . "\$query->from(\$db->quoteName('#__" . $this->componentCodeName . "_" . $viewName_single . "', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . $this->_t(2) . "\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a." . $categoryCodeName . "') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
		$query .= $this->getCustomScriptBuilder('php_getlistquery', $viewName_single, PHP_EOL . PHP_EOL);
		// add the custom fields query
		$query .= $this->setCustomQuery($viewName_list, $viewName_single);
		if (ComponentbuilderHelper::checkString($globalKey) &&
			$key && strpos($key, '-R>') === false && strpos($key, '-A>') === false && strpos($key, '-OR>') === false &&
			$parentKey && strpos($parentKey, '-R>') === false && strpos($parentKey, '-A>') === false && strpos($parentKey, '-OR>') === false)
		{
			$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by " . $globalKey . " global.";
			$query .= PHP_EOL . $this->_t(2) . "\$" . $globalKey . " = \$this->" . $globalKey . ";";
			$query .= PHP_EOL . $this->_t(2) . "if (is_numeric(\$" . $globalKey . " ))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a." . $key . " = ' . (int) \$" . $globalKey . " );";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL . $this->_t(2) . "elseif (is_string(\$" . $globalKey . "))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a." . $key . " = ' . \$db->quote(\$" . $globalKey . "));";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL . $this->_t(2) . "else";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a." . $key . " = -5');";
			$query .= PHP_EOL . $this->_t(2) . "}";
		}
		elseif (strpos($parentKey, '-OR>') !== false || strpos($key, '-OR>') !== false)
		{
			// get both strings
			if (strpos($key, '-OR>') !== false)
			{
				$ORarray = explode('-OR>', $key);
			}
			else
			{
				$ORarray = array($key);
			}
			// make sure we have an array
			if (!ComponentbuilderHelper::checkArray($globalKey))
			{
				$globalKey = array($globalKey);
			}
			// now load the query (this may be to much... but hey let it write the code :)
			foreach ($globalKey as $_globalKey)
			{
				// now build the query
				$ORquery = array('s' => array(), 'i' => array());
				foreach ($ORarray as $ORkey)
				{
					$ORquery['i'][] = "a." . $ORkey . " = ' . (int) \$" . $_globalKey;
					$ORquery['s'][] = "a." . $ORkey . " = ' . \$db->quote(\$" . $_globalKey . ")";
				}
				$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by " . $_globalKey . " global.";
				$query .= PHP_EOL . $this->_t(2) . "\$" . $_globalKey . " = \$this->" . $_globalKey . ";";
				$query .= PHP_EOL . $this->_t(2) . "if (is_numeric(\$" . $_globalKey . " ))";
				$query .= PHP_EOL . $this->_t(2) . "{";
				$query .= PHP_EOL . $this->_t(3) . "\$query->where('" . implode(" . ' OR ", $ORquery['i']) . ", ' OR');";
				$query .= PHP_EOL . $this->_t(2) . "}";
				$query .= PHP_EOL . $this->_t(2) . "elseif (is_string(\$" . $_globalKey . "))";
				$query .= PHP_EOL . $this->_t(2) . "{";
				$query .= PHP_EOL . $this->_t(3) . "\$query->where('" . implode(" . ' OR ", $ORquery['s']) . ", ' OR');";
				$query .= PHP_EOL . $this->_t(2) . "}";
				$query .= PHP_EOL . $this->_t(2) . "else";
				$query .= PHP_EOL . $this->_t(2) . "{";
				$query .= PHP_EOL . $this->_t(3) . "\$query->where('a." . $ORkey . " = -5');";
				$query .= PHP_EOL . $this->_t(2) . "}";
			}
		}
		if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
		{
			$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Join over the asset groups.";
			$query .= PHP_EOL . $this->_t(2) . "\$query->select('ag.title AS access_level');";
			$query .= PHP_EOL . $this->_t(2) . "\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by access level.";
			$query .= PHP_EOL . $this->_t(2) . "if (\$access = \$this->getState('filter.access'))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a.access = ' . (int) \$access);";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Implement View Level Access";
			$query .= PHP_EOL . $this->_t(2) . "if (!\$user->authorise('core.options', 'com_" . $this->componentCodeName . "'))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a.access IN (' . \$groups . ')');";
			$query .= PHP_EOL . $this->_t(2) . "}";
		}
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Order the results by ordering";
		$query .= PHP_EOL . $this->_t(2) . "\$query->order('a.published  ASC');";
		$query .= PHP_EOL . $this->_t(2) . "\$query->order('a.ordering  ASC');";
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Load the items";
		$query .= PHP_EOL . $this->_t(2) . "\$db->setQuery(\$query);";
		$query .= PHP_EOL . $this->_t(2) . "\$db->execute();";
		$query .= PHP_EOL . $this->_t(2) . "if (\$db->getNumRows())";
		$query .= PHP_EOL . $this->_t(2) . "{";
		$query .= PHP_EOL . $this->_t(3) . "\$items = \$db->loadObjectList();";
		// add the fixing strings method
		$query .= $this->setGetItemsMethodStringFix($viewName_single, $viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh], $this->_t(1));
		// add translations
		$query .= $this->setSelectionTranslationFix($viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh], $this->_t(1));
		// filter by child repetable field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($key, '-R>') !== false && strpos($key, '-A>') === false)
		{
			list($field, $target) = explode('-R>', $key);
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Filter by " . $globalKey . " in this Repetable Field";
			$query .= PHP_EOL . $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$items) && isset(\$this->" . $globalKey . "))";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . $this->_t(4) . "{";
			$query .= PHP_EOL . $this->_t(5) . "if (isset(\$item->" . $field . ") && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkJson(\$item->" . $field . "))";
			$query .= PHP_EOL . $this->_t(5) . "{";
			$query .= PHP_EOL . $this->_t(6) . "\$tmpArray = json_decode(\$item->" . $field . ",true);";
			$query .= PHP_EOL . $this->_t(6) . "if (!isset(\$tmpArray['" . $target . "']) || !" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$tmpArray['" . $target . "']) || !in_array(\$this->" . $globalKey . ", \$tmpArray['" . $target . "']))";
			$query .= PHP_EOL . $this->_t(6) . "{";
			$query .= PHP_EOL . $this->_t(7) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . $this->_t(7) . "continue;";
			$query .= PHP_EOL . $this->_t(6) . "}";
			$query .= PHP_EOL . $this->_t(5) . "}";
			$query .= PHP_EOL . $this->_t(5) . "else";
			$query .= PHP_EOL . $this->_t(5) . "{";
			$query .= PHP_EOL . $this->_t(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . $this->_t(6) . "continue;";
			$query .= PHP_EOL . $this->_t(5) . "}";
			$query .= PHP_EOL . $this->_t(4) . "}";
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(3) . "else";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "return false;";
			$query .= PHP_EOL . $this->_t(3) . "}";
		}
		// filter by child array field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($key, '-R>') === false && strpos($key, '-A>') !== false)
		{
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Filter by " . $globalKey . " Array Field";
			$query .= PHP_EOL . $this->_t(3) . "\$" . $globalKey . " = \$this->" . $globalKey . ";";
			$query .= PHP_EOL . $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$items) && \$" . $globalKey . ")";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . $this->_t(4) . "{";
			list($bin, $target) = explode('-A>', $key);
			if (ComponentbuilderHelper::checkString($target))
			{
				$query .= PHP_EOL . $this->_t(5) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkJson(\$item->" . $target . "))";
				$query .= PHP_EOL . $this->_t(5) . "{";
				$query .= PHP_EOL . $this->_t(6) . "\$item->" . $target . " = json_decode(\$item->" . $target . ", true);";
				$query .= PHP_EOL . $this->_t(5) . "}";
				$query .= PHP_EOL . $this->_t(5) . "elseif (!isset(\$item->" . $target . ") || !" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$item->" . $target . "))";
				$query .= PHP_EOL . $this->_t(5) . "{";
				$query .= PHP_EOL . $this->_t(6) . "unset(\$items[\$nr]);";
				$query .= PHP_EOL . $this->_t(6) . "continue;";
				$query .= PHP_EOL . $this->_t(5) . "}";
				$query .= PHP_EOL . $this->_t(5) . "if (!in_array(\$" . $globalKey . ",\$item->" . $target . "))";
			}
			else
			{
				$query .= PHP_EOL . $this->_t(5) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkJson(\$item->" . $_key . "))";
				$query .= PHP_EOL . $this->_t(5) . "{";
				$query .= PHP_EOL . $this->_t(6) . "\$item->" . $_key . " = json_decode(\$item->" . $_key . ", true);";
				$query .= PHP_EOL . $this->_t(5) . "}";
				$query .= PHP_EOL . $this->_t(5) . "elseif (!isset(\$item->" . $_key . ") || !" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$item->" . $_key . "))";
				$query .= PHP_EOL . $this->_t(5) . "{";
				$query .= PHP_EOL . $this->_t(6) . "unset(\$items[\$nr]);";
				$query .= PHP_EOL . $this->_t(6) . "continue;";
				$query .= PHP_EOL . $this->_t(5) . "}";
				$query .= PHP_EOL . $this->_t(5) . "if (!in_array(\$" . $globalKey . ",\$item->" . $_key . "))";
			}
			$query .= PHP_EOL . $this->_t(5) . "{";
			$query .= PHP_EOL . $this->_t(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . $this->_t(6) . "continue;";
			$query .= PHP_EOL . $this->_t(5) . "}";
			$query .= PHP_EOL . $this->_t(4) . "}";
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(3) . "else";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "return false;";
			$query .= PHP_EOL . $this->_t(3) . "}";
		}
		// filter by parent repetable field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($parentKey, '-R>') !== false && strpos($parentKey, '-A>') === false)
		{
			list($bin, $target) = explode('-R>', $parentKey);
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Filter by " . $_key . " Repetable Field";
			$query .= PHP_EOL . $this->_t(3) . "\$" . $globalKey . " = json_decode(\$this->" . $globalKey . ",true);";
			$query .= PHP_EOL . $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$items) && isset(\$" . $globalKey . ") && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$" . $globalKey . "))";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . $this->_t(4) . "{";
			$query .= PHP_EOL . $this->_t(5) . "if (\$item->" . $_key . " && isset(\$" . $globalKey . "['" . $target . "']) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$" . $globalKey . "['" . $target . "']))";
			$query .= PHP_EOL . $this->_t(5) . "{";
			$query .= PHP_EOL . $this->_t(6) . "if (!in_array(\$item->" . $_key . ",\$" . $globalKey . "['" . $target . "']))";
			$query .= PHP_EOL . $this->_t(6) . "{";
			$query .= PHP_EOL . $this->_t(7) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . $this->_t(7) . "continue;";
			$query .= PHP_EOL . $this->_t(6) . "}";
			$query .= PHP_EOL . $this->_t(5) . "}";
			$query .= PHP_EOL . $this->_t(5) . "else";
			$query .= PHP_EOL . $this->_t(5) . "{";
			$query .= PHP_EOL . $this->_t(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . $this->_t(6) . "continue;";
			$query .= PHP_EOL . $this->_t(5) . "}";
			$query .= PHP_EOL . $this->_t(4) . "}";
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(3) . "else";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "return false;";
			$query .= PHP_EOL . $this->_t(3) . "}";
		}
		// filter by parent array field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($parentKey, '-R>') === false && strpos($parentKey, '-A>') !== false)
		{
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Filter by " . $globalKey . " Array Field";
			$query .= PHP_EOL . $this->_t(3) . "\$" . $globalKey . " = \$this->" . $globalKey . ";";
			$query .= PHP_EOL . $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$items) && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$" . $globalKey . "))";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . $this->_t(4) . "{";
			list($bin, $target) = explode('-A>', $parentKey);
			if (ComponentbuilderHelper::checkString($target))
			{
				$query .= PHP_EOL . $this->_t(5) . "if (\$item->" . $_key . " && " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$" . $globalKey . "['" . $target . "']))";
				$query .= PHP_EOL . $this->_t(5) . "{";
				$query .= PHP_EOL . $this->_t(6) . "if (!in_array(\$item->" . $_key . ",\$" . $globalKey . "['" . $target . "']))";
			}
			else
			{
				$query .= PHP_EOL . $this->_t(5) . "if (\$item->" . $_key . ")";
				$query .= PHP_EOL . $this->_t(5) . "{";
				$query .= PHP_EOL . $this->_t(6) . "if (!in_array(\$item->" . $_key . ",\$" . $globalKey . "))";
			}
			$query .= PHP_EOL . $this->_t(6) . "{";
			$query .= PHP_EOL . $this->_t(7) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . $this->_t(7) . "continue;";
			$query .= PHP_EOL . $this->_t(6) . "}";
			$query .= PHP_EOL . $this->_t(5) . "}";
			$query .= PHP_EOL . $this->_t(5) . "else";
			$query .= PHP_EOL . $this->_t(5) . "{";
			$query .= PHP_EOL . $this->_t(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . $this->_t(6) . "continue;";
			$query .= PHP_EOL . $this->_t(5) . "}";
			$query .= PHP_EOL . $this->_t(4) . "}";
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(3) . "else";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "return false;";
			$query .= PHP_EOL . $this->_t(3) . "}";
		}
		// add custom php to getitems method after all
		$query .= $this->getCustomScriptBuilder('php_getitems_after_all', $viewName_single, PHP_EOL . PHP_EOL . $this->_t(1));

		$query .= PHP_EOL . $this->_t(3) . "return \$items;";
		$query .= PHP_EOL . $this->_t(2) . "}";
		$query .= PHP_EOL . $this->_t(2) . "return false;";
		$query .= PHP_EOL . $this->_t(1) . "}";
		// SELECTIONTRANSLATIONFIXFUNC<<<DYNAMIC>>>
		$query .= $this->setSelectionTranslationFixFunc($viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh]);

		// fixe mothod name clash
		$query = str_replace('selectionTranslation(', 'selectionTranslation' . $functionName . '(', $query);

		return $query;
	}

	/**
	 * @param $viewName_list
	 * @return array|string
	 */
	public function setCustomAdminDynamicButton($viewName_list)
	{
		$buttons = '';
		if (isset($this->customAdminDynamicButtons[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminDynamicButtons[$viewName_list]))
		{
			$buttons = array();
			foreach ($this->customAdminDynamicButtons[$viewName_list] as $custom_button)
			{
				// Load to lang
				$keyLang = $this->langPrefix . '_' . $custom_button['NAME'];
				$this->setLangContent($this->lang, $keyLang, ComponentbuilderHelper::safeString($custom_button['name'], 'Ww'));
				// add cpanel button
				$buttons[] = $this->_t(2) . "if (\$this->canDo->get('" . $custom_button['link'] . ".access'))";
				$buttons[] = $this->_t(2) . "{";
				$buttons[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " add " . $custom_button['name'] . " button.";
				$buttons[] = $this->_t(3) . "JToolBarHelper::custom('" . $viewName_list . ".redirectTo" . ComponentbuilderHelper::safeString($custom_button['link'], 'F') . "', '" . $custom_button['icon'] . "', '', '" . $keyLang . "', true);";
				$buttons[] = $this->_t(2) . "}";
			}
			if (ComponentbuilderHelper::checkArray($buttons))
			{
				return implode(PHP_EOL, $buttons);
			}
		}
		return $buttons;
	}

	/**
	 * @param $viewName_list
	 * @return array|string
	 */
	public function setCustomAdminDynamicButtonController($viewName_list)
	{
		$method = '';
		if (isset($this->customAdminDynamicButtons[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminDynamicButtons[$viewName_list]))
		{
			$method = array();
			foreach ($this->customAdminDynamicButtons[$viewName_list] as $custom_button)
			{
				// add the custom redirect method
				$method[] = PHP_EOL . PHP_EOL . $this->_t(1) . "public function redirectTo" . ComponentbuilderHelper::safeString($custom_button['link'], 'F') . "()";
				$method[] = $this->_t(1) . "{";
				$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check for request forgeries";
				$method[] = $this->_t(2) . "JSession::checkToken() or die(JText:" . ":_('JINVALID_TOKEN'));";
				$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if export is allowed for this user.";
				$method[] = $this->_t(2) . "\$user = JFactory::getUser();";
				$method[] = $this->_t(2) . "if (\$user->authorise('" . $custom_button['link'] . ".access', 'com_" . $this->componentCodeName . "'))";
				$method[] = $this->_t(2) . "{";
				$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the input";
				$method[] = $this->_t(3) . "\$input = JFactory::getApplication()->input;";
				$method[] = $this->_t(3) . "\$pks = \$input->post->get('cid', array(), 'array');";
				$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Sanitize the input";
				$method[] = $this->_t(3) . "JArrayHelper::toInteger(\$pks);";
				$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " convert to string";
				$method[] = $this->_t(3) . "\$ids = implode('_', \$pks);";
				$method[] = $this->_t(3) . "\$this->setRedirect(JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=" . $custom_button['link'] . "&cid='.\$ids, false));";
				$method[] = $this->_t(3) . "return;";
				$method[] = $this->_t(2) . "}";
				$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Redirect to the list screen with error.";
				$method[] = $this->_t(2) . "\$message = JText:" . ":_('" . $this->langPrefix . "_ACCESS_TO_" . $custom_button['NAME'] . "_FAILED');";
				$method[] = $this->_t(2) . "\$this->setRedirect(JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=" . $viewName_list . "', false), \$message, 'error');";
				$method[] = $this->_t(2) . "return;";
				$method[] = $this->_t(1) . "}";
				// add to lang array
				$lankey = $this->langPrefix . "_ACCESS_TO_" . $custom_button['NAME'] . "_FAILED";
				$this->setLangContent($this->lang, $lankey, 'Access to ' . $custom_button['link'] . ' was denied.');
			}

			return implode(PHP_EOL, $method);
		}
		return $method;
	}

	/**
	 * A function that builds get Items Method for model
	 *
	 * @param   string   $viewName_single  The single view name
	 * @param   string   $viewName_list    The list view name
	 * @param   array    $config           The config details to adapt the method being build
	 *
	 * @return string
	 */
	public function setGetItemsModelMethod($viewName_single, $viewName_list, $config = array('functionName' => 'getExportData', 'docDesc' => 'Method to get list export data.', 'type' => 'export'))
	{
		// start the query string
		$query = '';
		// check if this is the export method
		$isExport = ('export' === $config['type']);
		// check if this view has export feature, and or if this is not an export method
		if ((isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list]) || !$isExport)
		{
			$query = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$query .= PHP_EOL . $this->_t(1) . " * " . $config['docDesc'];
			$query .= PHP_EOL . $this->_t(1) . " *";
			$query .= PHP_EOL . $this->_t(1) . " * @param   array  \$pks  The ids of the items to get";
			$query .= PHP_EOL . $this->_t(1) . " * @param   JUser  \$user  The user making the request";
			$query .= PHP_EOL . $this->_t(1) . " *";
			$query .= PHP_EOL . $this->_t(1) . " * @return mixed  An array of data items on success, false on failure.";
			$query .= PHP_EOL . $this->_t(1) . " */";
			$query .= PHP_EOL . $this->_t(1) . "public function " . $config['functionName'] . "(\$pks, \$user = null)";
			$query .= PHP_EOL . $this->_t(1) . "{";
			$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " setup the query";
			$query .= PHP_EOL . $this->_t(2) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$pks))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set a value to know this is " . $config['type'] . " method. (USE IN CUSTOM CODE TO ALTER OUTCOME)";
			$query .= PHP_EOL . $this->_t(3) . "\$_" . $config['type'] . " = true;";
			$query .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the user object if not set.";
			$query .= PHP_EOL . $this->_t(3) . "if (!isset(\$user) || !" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkObject(\$user))";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "\$user = JFactory::getUser();";
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
			$query .= PHP_EOL . $this->_t(3) . "\$db = JFactory::getDBO();";
			$query .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Select some fields";
			$query .= PHP_EOL . $this->_t(3) . "\$query->select('a.*');";
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " From the " . $this->componentCodeName . "_" . $viewName_single . " table";
			$query .= PHP_EOL . $this->_t(3) . "\$query->from(\$db->quoteName('#__" . $this->componentCodeName . "_" . $viewName_single . "', 'a'));";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a.id IN (' . implode(',',\$pks) . ')');";
			// add custom filtering php
			$query .= $this->getCustomScriptBuilder('php_getlistquery', $viewName_single, PHP_EOL . PHP_EOL . $this->_t(1));
			// first check if we export of text only is avalable
			if ($this->exportTextOnly)
			{
				// add switch
				$query .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get global switch to activate text only export";
				$query .= PHP_EOL . $this->_t(3) . "\$export_text_only = JComponentHelper::getParams('com_" . $this->componentCodeName . "')->get('export_text_only', 0);";
				// first check if we have custom queries
				$custom_query = $this->setCustomQuery($viewName_list, $viewName_single, $this->_t(2), true);
			}
			// if values were returned add the area
			if (isset($custom_query) && ComponentbuilderHelper::checkString($custom_query))
			{
				$query .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Add these queries only if text only is required";
				$query .= PHP_EOL . $this->_t(3) . "if (\$export_text_only)";
				$query .= PHP_EOL . $this->_t(3) . "{";
				// add the custom fields query
				$query .= $custom_query;
				$query .= PHP_EOL . $this->_t(3) . "}";
			}
			// add access levels if the view has access set
			if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
			{
				$query .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Implement View Level Access";
				$query .= PHP_EOL . $this->_t(3) . "if (!\$user->authorise('core.options', 'com_" . $this->componentCodeName . "'))";
				$query .= PHP_EOL . $this->_t(3) . "{";
				$query .= PHP_EOL . $this->_t(4) . "\$groups = implode(',', \$user->getAuthorisedViewLevels());";
				$query .= PHP_EOL . $this->_t(4) . "\$query->where('a.access IN (' . \$groups . ')');";
				$query .= PHP_EOL . $this->_t(3) . "}";
			}
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Order the results by ordering";
			$query .= PHP_EOL . $this->_t(3) . "\$query->order('a.ordering  ASC');";
			$query .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Load the items";
			$query .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
			$query .= PHP_EOL . $this->_t(3) . "\$db->execute();";
			$query .= PHP_EOL . $this->_t(3) . "if (\$db->getNumRows())";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "\$items = \$db->loadObjectList();";
			// set the string fixing code
			$query .= $this->setGetItemsMethodStringFix($viewName_single, $viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh], $this->_t(2), $isExport, true);
			// first check if we export of text only is avalable
			if ($this->exportTextOnly)
			{
				$query_translations = $this->setSelectionTranslationFix($viewName_list, $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh], $this->_t(3));
			}
			// add translations
			if (isset($query_translations) && ComponentbuilderHelper::checkString($query_translations))
			{
				$query .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Add these translation only if text only is required";
				$query .= PHP_EOL . $this->_t(3) . "if (\$export_text_only)";
				$query .= PHP_EOL . $this->_t(3) . "{";
				$query .= $query_translations;
				$query .= PHP_EOL . $this->_t(3) . "}";
			}
			// add custom php to getItems method after all
			$query .= $this->getCustomScriptBuilder('php_getitems_after_all', $viewName_single, PHP_EOL . PHP_EOL . $this->_t(2));
			// in privacy export we must return array of arrays
			if ('privacy' === $config['type'])
			{
				$query .= PHP_EOL . $this->_t(4) . "return json_decode(json_encode(\$items), true);";
			}
			else
			{
				$query .= PHP_EOL . $this->_t(4) . "return \$items;";
			}
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL . $this->_t(2) . "return false;";
			$query .= PHP_EOL . $this->_t(1) . "}";
			// get the header script
			if ($isExport)
			{
				$header = ComponentbuilderHelper::getDynamicScripts('headers');

				// add getExImPortHeaders
				$query .= $this->getCustomScriptBuilder('php_import_headers', 'import_' . $viewName_list, PHP_EOL . PHP_EOL, null, true,
					// set a default script for those with no custom script
					PHP_EOL . PHP_EOL . $this->setPlaceholders($header, $this->placeholders));
			}
		}
		return $query;
	}

	public function setControllerEximportMethod($viewName_single, $viewName_list)
	{
		$method = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			$method = array();

			// add the export method
			$method[] = PHP_EOL . PHP_EOL . $this->_t(1) . "public function exportData()";
			$method[] = $this->_t(1) . "{";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check for request forgeries";
			$method[] = $this->_t(2) . "JSession::checkToken() or die(JText:" . ":_('JINVALID_TOKEN'));";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if export is allowed for this user.";
			$method[] = $this->_t(2) . "\$user = JFactory::getUser();";
			$method[] = $this->_t(2) . "if (\$user->authorise('" . $viewName_single . ".export', 'com_" . $this->componentCodeName . "') && \$user->authorise('core.export', 'com_" . $this->componentCodeName . "'))";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the input";
			$method[] = $this->_t(3) . "\$input = JFactory::getApplication()->input;";
			$method[] = $this->_t(3) . "\$pks = \$input->post->get('cid', array(), 'array');";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Sanitize the input";
			$method[] = $this->_t(3) . "JArrayHelper::toInteger(\$pks);";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the model";
			$method[] = $this->_t(3) . "\$model = \$this->getModel('" . ComponentbuilderHelper::safeString($viewName_list, 'F') . "');";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get the data to export";
			$method[] = $this->_t(3) . "\$data = \$model->getExportData(\$pks);";
			$method[] = $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkArray(\$data))";
			$method[] = $this->_t(3) . "{";
			$method[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " now set the data to the spreadsheet";
			$method[] = $this->_t(4) . "\$date = JFactory::getDate();";
			$method[] = $this->_t(4) . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::xls(\$data,'" . ComponentbuilderHelper::safeString($viewName_list, 'F') . "_'.\$date->format('jS_F_Y'),'" . ComponentbuilderHelper::safeString($viewName_list, 'Ww') . " exported ('.\$date->format('jS F, Y').')','" . ComponentbuilderHelper::safeString($viewName_list, 'w') . "');";
			$method[] = $this->_t(3) . "}";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Redirect to the list screen with error.";
			$method[] = $this->_t(2) . "\$message = JText:" . ":_('" . $this->langPrefix . "_EXPORT_FAILED');";
			$method[] = $this->_t(2) . "\$this->setRedirect(JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=" . $viewName_list . "', false), \$message, 'error');";
			$method[] = $this->_t(2) . "return;";
			$method[] = $this->_t(1) . "}";

			// add the import method
			$method[] = PHP_EOL . PHP_EOL . $this->_t(1) . "public function importData()";
			$method[] = $this->_t(1) . "{";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check for request forgeries";
			$method[] = $this->_t(2) . "JSession::checkToken() or die(JText:" . ":_('JINVALID_TOKEN'));";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if import is allowed for this user.";
			$method[] = $this->_t(2) . "\$user = JFactory::getUser();";
			$method[] = $this->_t(2) . "if (\$user->authorise('" . $viewName_single . ".import', 'com_" . $this->componentCodeName . "') && \$user->authorise('core.import', 'com_" . $this->componentCodeName . "'))";
			$method[] = $this->_t(2) . "{";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get the import model";
			$method[] = $this->_t(3) . "\$model = \$this->getModel('" . ComponentbuilderHelper::safeString($viewName_list, 'F') . "');";
			$method[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get the headers to import";
			$method[] = $this->_t(3) . "\$headers = \$model->getExImPortHeaders();";
			$method[] = $this->_t(3) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkObject(\$headers))";
			$method[] = $this->_t(3) . "{";
			$method[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Load headers to session.";
			$method[] = $this->_t(4) . "\$session = JFactory::getSession();";
			$method[] = $this->_t(4) . "\$headers = json_encode(\$headers);";
			$method[] = $this->_t(4) . "\$session->set('" . $viewName_single . "_VDM_IMPORTHEADERS', \$headers);";
			$method[] = $this->_t(4) . "\$session->set('backto_VDM_IMPORT', '" . $viewName_list . "');";
			$method[] = $this->_t(4) . "\$session->set('dataType_VDM_IMPORTINTO', '" . $viewName_single . "');";
			$method[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Redirect to import view.";
			// add to lang array
			$selectImportFileNote = $this->langPrefix . "_IMPORT_SELECT_FILE_FOR_" . ComponentbuilderHelper::safeString($viewName_list, 'U');
			$this->setLangContent($this->lang, $selectImportFileNote, 'Select the file to import data to ' . $viewName_list . '.');
			$method[] = $this->_t(4) . "\$message = JText:" . ":_('" . $selectImportFileNote . "');";
			// if this view has custom script it must have as custom import (model, veiw, controller)
			if (isset($this->importCustomScripts[$viewName_list]) && $this->importCustomScripts[$viewName_list])
			{
				$method[] = $this->_t(4) . "\$this->setRedirect(JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=import_" . $viewName_list . "', false), \$message);";
			}
			else
			{
				$method[] = $this->_t(4) . "\$this->setRedirect(JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=import', false), \$message);";
			}
			$method[] = $this->_t(4) . "return;";
			$method[] = $this->_t(3) . "}";
			$method[] = $this->_t(2) . "}";
			$method[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Redirect to the list screen with error.";
			$method[] = $this->_t(2) . "\$message = JText:" . ":_('" . $this->langPrefix . "_IMPORT_FAILED');";
			$method[] = $this->_t(2) . "\$this->setRedirect(JRoute::_('index.php?option=com_" . $this->componentCodeName . "&view=" . $viewName_list . "', false), \$message, 'error');";
			$method[] = $this->_t(2) . "return;";
			$method[] = $this->_t(1) . "}";
			return implode(PHP_EOL, $method);
		}
		return $method;
	}

	public function setExportButton($viewName_single, $viewName_list)
	{
		$button = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			// main lang prefix
			$langExport = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Export Data', 'U');
			// add to lang array
			$this->setLangContent($this->lang, $langExport, 'Export Data');
			$button = array();
			$button[] = PHP_EOL . PHP_EOL . $this->_t(3) . "if (\$this->canDo->get('core.export') && \$this->canDo->get('" . $viewName_single . ".export'))";
			$button[] = $this->_t(3) . "{";
			$button[] = $this->_t(4) . "JToolBarHelper::custom('" . $viewName_list . ".exportData', 'download', '', '" . $langExport . "', true);";
			$button[] = $this->_t(3) . "}";
			return implode(PHP_EOL, $button);
		}
		return $button;
	}

	public function setImportButton($viewName_single, $viewName_list)
	{
		$button = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			// main lang prefix
			$langImport = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Import Data', 'U');
			// add to lang array
			$this->setLangContent($this->lang, $langImport, 'Import Data');
			$button = array();
			$button[] = PHP_EOL . PHP_EOL . $this->_t(2) . "if (\$this->canDo->get('core.import') && \$this->canDo->get('" . $viewName_single . ".import'))";
			$button[] = $this->_t(2) . "{";
			$button[] = $this->_t(3) . "JToolBarHelper::custom('" . $viewName_list . ".importData', 'upload', '', '" . $langImport . "', false);";
			$button[] = $this->_t(2) . "}";
			return implode(PHP_EOL, $button);
		}
		return $button;
	}

	public function setImportCustomScripts($viewName_list)
	{
		// setup Ajax files
		$target = array('admin' => 'import_' . $viewName_list);
		$this->buildDynamique($target, 'customimport');
		// load the custom script to the files
		// IMPORT_EXT_METHOD_CUSTOM <<<DYNAMIC>>>
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'IMPORT_EXT_METHOD_CUSTOM' . $this->hhh] = $this->getCustomScriptBuilder('php_import_ext', 'import_' . $viewName_list, PHP_EOL, null, true);
		// IMPORT_DISPLAY_METHOD_CUSTOM <<<DYNAMIC>>>
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'IMPORT_DISPLAY_METHOD_CUSTOM' . $this->hhh] = $this->getCustomScriptBuilder('php_import_display', 'import_' . $viewName_list, PHP_EOL, null, true);
		// IMPORT_SETDATE_METHOD_CUSTOM <<<DYNAMIC>>>
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'IMPORT_SETDATE_METHOD_CUSTOM' . $this->hhh] = $this->getCustomScriptBuilder('php_import_setdata', 'import_' . $viewName_list, PHP_EOL, null, true);
		// IMPORT_METHOD_CUSTOM <<<DYNAMIC>>>
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'IMPORT_METHOD_CUSTOM' . $this->hhh] = $this->getCustomScriptBuilder('php_import', 'import_' . $viewName_list, PHP_EOL, null, true);
		// IMPORT_SAVE_METHOD_CUSTOM <<<DYNAMIC>>>
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'IMPORT_SAVE_METHOD_CUSTOM' . $this->hhh] = $this->getCustomScriptBuilder('php_import_save', 'import_' . $viewName_list, PHP_EOL, null, true);
		// IMPORT_DEFAULT_VIEW_CUSTOM <<<DYNAMIC>>>
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'IMPORT_DEFAULT_VIEW_CUSTOM' . $this->hhh] = $this->getCustomScriptBuilder('html_import_view', 'import_' . $viewName_list, PHP_EOL, null, true);

		// insure we have the view placeholders setup
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'VIEW' . $this->hhh] = 'IMPORT_' . $this->placeholders[$this->hhh . 'VIEWS' . $this->hhh];
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'View' . $this->hhh] = 'Import_' . $this->placeholders[$this->hhh . 'views' . $this->hhh];
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'view' . $this->hhh] = 'import_' . $this->placeholders[$this->hhh . 'views' . $this->hhh];
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'VIEWS' . $this->hhh] = 'IMPORT_' . $this->placeholders[$this->hhh . 'VIEWS' . $this->hhh];
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'Views' . $this->hhh] = 'Import_' . $this->placeholders[$this->hhh . 'views' . $this->hhh];
		$this->fileContentDynamic['import_' . $viewName_list][$this->hhh . 'views' . $this->hhh] = 'import_' . $this->placeholders[$this->hhh . 'views' . $this->hhh];
	}

	public function setListQuery($viewName_single, $viewName_list)
	{
		// check if this view has category added
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			$categoryCodeName = $this->categoryBuilder[$viewName_list]['code'];
			$addCategory = true;
		}
		else
		{
			$addCategory = false;
		}
		// setup the query
		$query = "//" . $this->setLine(__LINE__) . " Get the user object.";
		$query .= PHP_EOL . $this->_t(2) . "\$user = JFactory::getUser();";
		$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
		$query .= PHP_EOL . $this->_t(2) . "\$db = JFactory::getDBO();";
		$query .= PHP_EOL . $this->_t(2) . "\$query = \$db->getQuery(true);";
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select some fields";
		$query .= PHP_EOL . $this->_t(2) . "\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . $this->_t(2) . "\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " From the " . $this->componentCodeName . "_item table";
		$query .= PHP_EOL . $this->_t(2) . "\$query->from(\$db->quoteName('#__" . $this->componentCodeName . "_" . $viewName_single . "', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . $this->_t(2) . "\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a." . $categoryCodeName . "') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
		$query .= $this->getCustomScriptBuilder('php_getlistquery', $viewName_single, PHP_EOL . PHP_EOL);
		// add the custom fields query
		$query .= $this->setCustomQuery($viewName_list, $viewName_single);
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by published state";
		$query .= PHP_EOL . $this->_t(2) . "\$published = \$this->getState('filter.published');";
		$query .= PHP_EOL . $this->_t(2) . "if (is_numeric(\$published))";
		$query .= PHP_EOL . $this->_t(2) . "{";
		$query .= PHP_EOL . $this->_t(3) . "\$query->where('a.published = ' . (int) \$published);";
		$query .= PHP_EOL . $this->_t(2) . "}";
		$query .= PHP_EOL . $this->_t(2) . "elseif (\$published === '')";
		$query .= PHP_EOL . $this->_t(2) . "{";
		$query .= PHP_EOL . $this->_t(3) . "\$query->where('(a.published = 0 OR a.published = 1)');";
		$query .= PHP_EOL . $this->_t(2) . "}";
		if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
		{
			$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Join over the asset groups.";
			$query .= PHP_EOL . $this->_t(2) . "\$query->select('ag.title AS access_level');";
			$query .= PHP_EOL . $this->_t(2) . "\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by access level.";
			$query .= PHP_EOL . $this->_t(2) . "if (\$access = \$this->getState('filter.access'))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a.access = ' . (int) \$access);";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Implement View Level Access";
			$query .= PHP_EOL . $this->_t(2) . "if (!\$user->authorise('core.options', 'com_" . $this->componentCodeName . "'))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a.access IN (' . \$groups . ')');";
			$query .= PHP_EOL . $this->_t(2) . "}";
		}
		// set the search query
		$query .= $this->setSearchQuery($viewName_list);
		// set other filters
		$query .= $this->setFilterQuery($viewName_list);
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by a single or group of categories.";
			$query .= PHP_EOL . $this->_t(2) . "\$baselevel = 1;";
			$query .= PHP_EOL . $this->_t(2) . "\$categoryId = \$this->getState('filter.category_id');";
			$query .= PHP_EOL;
			$query .= PHP_EOL . $this->_t(2) . "if (is_numeric(\$categoryId))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "\$cat_tbl = JTable::getInstance('Category', 'JTable');";
			$query .= PHP_EOL . $this->_t(3) . "\$cat_tbl->load(\$categoryId);";
			$query .= PHP_EOL . $this->_t(3) . "\$rgt = \$cat_tbl->rgt;";
			$query .= PHP_EOL . $this->_t(3) . "\$lft = \$cat_tbl->lft;";
			$query .= PHP_EOL . $this->_t(3) . "\$baselevel = (int) \$cat_tbl->level;";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('c.lft >= ' . (int) \$lft)";
			$query .= PHP_EOL . $this->_t(4) . "->where('c.rgt <= ' . (int) \$rgt);";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL . $this->_t(2) . "elseif (is_array(\$categoryId))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "JArrayHelper::toInteger(\$categoryId);";
			$query .= PHP_EOL . $this->_t(3) . "\$categoryId = implode(',', \$categoryId);";
			$query .= PHP_EOL . $this->_t(3) . "\$query->where('a.category IN (' . \$categoryId . ')');";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL;
		}
		$query .= PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add the list ordering clause.";
		$query .= PHP_EOL . $this->_t(2) . "\$orderCol = \$this->state->get('list.ordering', 'a.id');";
		$query .= PHP_EOL . $this->_t(2) . "\$orderDirn = \$this->state->get('list.direction', 'asc');	";
		$query .= PHP_EOL . $this->_t(2) . "if (\$orderCol != '')";
		$query .= PHP_EOL . $this->_t(2) . "{";
		$query .= PHP_EOL . $this->_t(3) . "\$query->order(\$db->escape(\$orderCol . ' ' . \$orderDirn));";
		$query .= PHP_EOL . $this->_t(2) . "}";
		$query .= PHP_EOL;
		$query .= PHP_EOL . $this->_t(2) . "return \$query;";

		return $query;
	}

	public function setSearchQuery($viewName_list)
	{
		if (isset($this->searchBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->searchBuilder[$viewName_list]))
		{
			// setup the searh options
			$search = "'(";
			foreach ($this->searchBuilder[$viewName_list] as $nr => $array)
			{
				// array( 'type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $field['list']);
				if ($nr == 0)
				{
					$search .= "a." . $array['code'] . " LIKE '.\$search.'";
					if (ComponentbuilderHelper::checkArray($array['custom']) && 1 == $array['list'])
					{
						$search .= " OR " . $array['custom']['db'] . "." . $array['custom']['text'] . " LIKE '.\$search.'";
					}
				}
				else
				{
					$search .= " OR a." . $array['code'] . " LIKE '.\$search.'";
					if (ComponentbuilderHelper::checkArray($array['custom']) && 1 == $array['list'])
					{
						$search .= " OR " . $array['custom']['db'] . "." . $array['custom']['text'] . " LIKE '.\$search.'";
					}
				}
			}
			$search .= ")'";
			// now setup query
			$query = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by search.";
			$query .= PHP_EOL . $this->_t(2) . "\$search = \$this->getState('filter.search');";
			$query .= PHP_EOL . $this->_t(2) . "if (!empty(\$search))";
			$query .= PHP_EOL . $this->_t(2) . "{";
			$query .= PHP_EOL . $this->_t(3) . "if (stripos(\$search, 'id:') === 0)";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "\$query->where('a.id = ' . (int) substr(\$search, 3));";
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(3) . "else";
			$query .= PHP_EOL . $this->_t(3) . "{";
			$query .= PHP_EOL . $this->_t(4) . "\$search = \$db->quote('%' . \$db->escape(\$search) . '%');";
			$query .= PHP_EOL . $this->_t(4) . "\$query->where(" . $search . ");";
			$query .= PHP_EOL . $this->_t(3) . "}";
			$query .= PHP_EOL . $this->_t(2) . "}";
			$query .= PHP_EOL;

			return $query;
		}
		return '';
	}

	public function setCustomQuery($viewName_list, $viewName_single, $tab = '', $just_text = false)
	{
		if (isset($this->customBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customBuilder[$viewName_list]))
		{
			$query = "";
			foreach ($this->customBuilder[$viewName_list] as $filter)
			{
				// only load this if table is set
				if ((isset($this->customBuilderList[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customBuilderList[$viewName_list]) && in_array($filter['code'], $this->customBuilderList[$viewName_list]) && isset($filter['custom']['table']) && ComponentbuilderHelper::checkString($filter['custom']['table']) && $filter['method'] == 0)
					|| ($just_text && isset($filter['custom']['table']) && ComponentbuilderHelper::checkString($filter['custom']['table']) && $filter['method'] == 0))
				{
					$query .= PHP_EOL . PHP_EOL . $this->_t(2) . $tab . "//" . $this->setLine(__LINE__) . " From the " . ComponentbuilderHelper::safeString(ComponentbuilderHelper::safeString($filter['custom']['table'], 'w')) . " table.";
					// we want to at times just have the words and not the ids as well
					if ($just_text)
					{
						$query .= PHP_EOL . $this->_t(2) . $tab . "\$query->select(\$db->quoteName('" . $filter['custom']['db'] . "." . $filter['custom']['text'] . "','" . $filter['code'] . "'));";
					}
					else
					{
						$query .= PHP_EOL . $this->_t(2) . $tab . "\$query->select(\$db->quoteName('" . $filter['custom']['db'] . "." . $filter['custom']['text'] . "','" . $filter['code'] . "_" . $filter['custom']['text'] . "'));";
					}
					$query .= PHP_EOL . $this->_t(2) . $tab . "\$query->join('LEFT', \$db->quoteName('" . $filter['custom']['table'] . "', '" . $filter['custom']['db'] . "') . ' ON (' . \$db->quoteName('a." . $filter['code'] . "') . ' = ' . \$db->quoteName('" . $filter['custom']['db'] . "." . $filter['custom']['id'] . "') . ')');";
				}
				// build the field type file
				$this->setCustomFieldTypeFile($filter, $viewName_list, $viewName_single);
			}
			return $query;
		}
	}

	public function setFilterQuery($viewName_list)
	{
		if (isset($this->filterBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$viewName_list]))
		{
			$filterQuery = "";
			foreach ($this->filterBuilder[$viewName_list] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']))
				{
					$filterQuery .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by " . $filter['code'] . ".";
					$filterQuery .= PHP_EOL . $this->_t(2) . "if (\$" . $filter['code'] . " = \$this->getState('filter." . $filter['code'] . "'))";
					$filterQuery .= PHP_EOL . $this->_t(2) . "{";
					$filterQuery .= PHP_EOL . $this->_t(3) . "\$query->where('a." . $filter['code'] . " = ' . \$db->quote(\$db->escape(\$" . $filter['code'] . ")));";
					$filterQuery .= PHP_EOL . $this->_t(2) . "}";
				}
				elseif ($filter['type'] != 'category')
				{
					$filterQuery .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Filter by " . ucwords($filter['code']) . ".";
					$filterQuery .= PHP_EOL . $this->_t(2) . "if (\$" . $filter['code'] . " = \$this->getState('filter." . $filter['code'] . "'))";
					$filterQuery .= PHP_EOL . $this->_t(2) . "{";
					$filterQuery .= PHP_EOL . $this->_t(3) . "\$query->where('a." . $filter['code'] . " = ' . \$db->quote(\$db->escape(\$" . $filter['code'] . ")));";
					$filterQuery .= PHP_EOL . $this->_t(2) . "}";
				}
			}
			return $filterQuery;
		}
		return '';
	}

	public function buildTheViewScript($viewArray)
	{
		// set the view name
		$viewName = ComponentbuilderHelper::safeString($viewArray['settings']->name_single);
		// add conditions to this view
		if (isset($viewArray['settings']->conditions) && ComponentbuilderHelper::checkArray($viewArray['settings']->conditions))
		{
			// reset defaults
			$getValue = array();
			$ifValue = array();
			$targetControls = array();
			$functions = array();

			foreach ($viewArray['settings']->conditions as $condition)
			{
				if (isset($condition['match_name']) && ComponentbuilderHelper::checkString($condition['match_name']))
				{
					$uniqueVar = $this->uniquekey(7);
					$matchName = $condition['match_name'] . '_' . $uniqueVar;
					$targetBehavior = ($condition['target_behavior'] == 1 || $condition['target_behavior'] == 3) ? 'show' : 'hide';
					$targetDefault = ($condition['target_behavior'] == 1 || $condition['target_behavior'] == 3) ? 'hide' : 'show';

					// set the realtation if any
					if ($condition['target_relation'])
					{
						// chain to other items of the same target
						$relations = $this->getTargetRelationScript($viewArray['settings']->conditions, $condition, $viewName);
						if (ComponentbuilderHelper::checkArray($relations))
						{
							// set behavior and default array
							$behaviors[$matchName] = $targetBehavior;
							$defaults[$matchName] = $targetDefault;
							$toggleSwitch[$matchName] = ($condition['target_behavior'] == 1 || $condition['target_behavior'] == 2) ? true : false;
							// set the type buket
							$typeBuket[$matchName] = $condition['match_type'];
							// set function array
							$functions[$uniqueVar][0] = $matchName;
							$matchNames[$matchName] = $condition['match_name'];
							// get the select value
							$getValue[$matchName] = $this->getValueScript($condition['match_type'], $condition['match_name'], $condition['match_extends'], $uniqueVar);
							// get the options
							$options = $this->getOptionsScript($condition['match_type'], $condition['match_options']);
							// set the if values
							$ifValue[$matchName] = $this->ifValueScript($matchName, $condition['match_behavior'], $condition['match_type'], $options);
							// set the target controls
							$targetControls[$matchName] = $this->setTargetControlsScript($toggleSwitch[$matchName], $condition['target_field'], $targetBehavior, $targetDefault, $uniqueVar, $viewName);

							foreach ($relations as $relation)
							{
								if (ComponentbuilderHelper::checkString($relation['match_name']))
								{
									$relationName = $relation['match_name'] . '_' . $uniqueVar;
									// set the type buket
									$typeBuket[$relationName] = $relation['match_type'];
									// set function array
									$functions[$uniqueVar][] = $relationName;
									$matchNames[$relationName] = $relation['match_name'];
									// get the relation option
									$relationOptions = $this->getOptionsScript($relation['match_type'], $relation['match_options']);
									$getValue[$relationName] = $this->getValueScript($relation['match_type'], $relation['match_name'], $condition['match_extends'], $uniqueVar);
									$ifValue[$relationName] = $this->ifValueScript($relationName, $relation['match_behavior'], $relation['match_type'], $relationOptions);
								}
							}
						}
					}
					else
					{
						// set behavior and default array
						$behaviors[$matchName] = $targetBehavior;
						$defaults[$matchName] = $targetDefault;
						$toggleSwitch[$matchName] = ($condition['target_behavior'] == 1 || $condition['target_behavior'] == 2) ? true : false;
						// set the type buket
						$typeBuket[$matchName] = $condition['match_type'];
						// set function array
						$functions[$uniqueVar][0] = $matchName;
						$matchNames[$matchName] = $condition['match_name'];
						// get the select value
						$getValue[$matchName] = $this->getValueScript($condition['match_type'], $condition['match_name'], $condition['match_extends'], $uniqueVar);
						// get the options
						$options = $this->getOptionsScript($condition['match_type'], $condition['match_options']);
						// set the if values
						$ifValue[$matchName] = $this->ifValueScript($matchName, $condition['match_behavior'], $condition['match_type'], $options);
						// set the target controls
						$targetControls[$matchName] = $this->setTargetControlsScript($toggleSwitch[$matchName], $condition['target_field'], $targetBehavior, $targetDefault, $uniqueVar, $viewName);
					}
				}
			}
			// reset buckets
			$initial = '';
			$func = '';
			$validation = '';
			$isSet = '';
			$listener = '';
			if (ComponentbuilderHelper::checkArray($functions))
			{
				// now build the initial script
				$initial .= "//" . $this->setLine(__LINE__) . " Initial Script" . PHP_EOL . "jQuery(document).ready(function()";
				$initial .= PHP_EOL . "{";
				foreach ($functions as $function => $matchKeys)
				{
					$func_call = $this->buildFunctionCall($function, $matchKeys, $getValue);
					$initial .= $func_call['code'];
				}
				$initial .= "});" . PHP_EOL;
				// for modal fields
				$modal = '';
				// now build the listener scripts
				foreach ($functions as $l_function => $l_matchKeys)
				{
					$funcCall = '';
					foreach ($l_matchKeys as $l_matchKey)
					{
						$name = $matchNames[$l_matchKey];
						$matchTypeKey = $typeBuket[$l_matchKey];
						$funcCall = $this->buildFunctionCall($l_function, $l_matchKeys, $getValue);

						if (isset($this->setScriptMediaSwitch) && ComponentbuilderHelper::checkArray($this->setScriptMediaSwitch) && in_array($matchTypeKey, $this->setScriptMediaSwitch))
						{
							$modal .= $funcCall['code'];
						}
						else
						{
							if (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($matchTypeKey, $this->setScriptUserSwitch))
							{
								$name = $name . '_id';
							}

							$listener .= PHP_EOL . "//" . $this->setLine(__LINE__) . " #jform_" . $name . " listeners for " . $l_matchKey . " function";
							$listener .= PHP_EOL . "jQuery('#jform_" . $name . "').on('keyup',function()";
							$listener .= PHP_EOL . "{";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL . "});";
							$listener .= PHP_EOL . "jQuery('#adminForm').on('change', '#jform_" . $name . "',function (e)";
							$listener .= PHP_EOL . "{";
							$listener .= PHP_EOL . $this->_t(1) . "e.preventDefault();";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL . "});" . PHP_EOL;
						}
					}
				}
				if (ComponentbuilderHelper::checkString($modal))
				{
					$listener .= PHP_EOL . "window.SqueezeBox.initialize({";
					$listener .= PHP_EOL . $this->_t(1) . "onClose:function(){";
					$listener .= $modal;
					$listener .= PHP_EOL . $this->_t(1) . "}";
					$listener .= PHP_EOL . "});" . PHP_EOL;
				}

				// now build the function
				$func = '';
				$head = '';
				foreach ($functions as $f_function => $f_matchKeys)
				{
					$map = '';
					// does this function require an array
					$addArray = false;
					$func_ = $this->buildFunctionCall($f_function, $f_matchKeys, $getValue);
					// set array switch
					if ($func_['array'])
					{
						$addArray = true;
					}
					$func .= PHP_EOL . "//" . $this->setLine(__LINE__) . " the " . $f_function . " function";
					$func .= PHP_EOL . "function " . $f_function . "(";
					$fucounter = 0;
					foreach ($f_matchKeys as $fu_matchKey)
					{
						if (ComponentbuilderHelper::checkString($fu_matchKey))
						{
							if ($fucounter == 0)
							{
								$func .= $fu_matchKey;
							}
							else
							{
								$func .= ',' . $fu_matchKey;
							}
							$fucounter++;
						}
					}
					$func .= ")";
					$func .= PHP_EOL . "{";
					if ($addArray)
					{
						foreach ($f_matchKeys as $a_matchKey)
						{
							$name = $matchNames[$a_matchKey];
							$func .= PHP_EOL . $this->_t(1) . "if (isSet(" . $a_matchKey . ") && " . $a_matchKey . ".constructor !== Array)" . PHP_EOL . $this->_t(1) . "{" . PHP_EOL . $this->_t(2) . "var temp_" . $f_function . " = " . $a_matchKey . ";" . PHP_EOL . $this->_t(2) . "var " . $a_matchKey . " = [];" . PHP_EOL . $this->_t(2) . $a_matchKey . ".push(temp_" . $f_function . ");" . PHP_EOL . $this->_t(1) . "}";
							$func .= PHP_EOL . $this->_t(1) . "else if (!isSet(" . $a_matchKey . "))" . PHP_EOL . $this->_t(1) . "{";
							$func .= PHP_EOL . $this->_t(2) . "var " . $a_matchKey . " = [];";
							$func .= PHP_EOL . $this->_t(1) . "}";
							$func .= PHP_EOL . $this->_t(1) . "var " . $name . " = " . $a_matchKey . ".some(" . $a_matchKey . "_SomeFunc);" . PHP_EOL;

							// setup the map function
							$map .= PHP_EOL . "//" . $this->setLine(__LINE__) . " the " . $f_function . " Some function";
							$map .= PHP_EOL . "function " . $a_matchKey . "_SomeFunc(" . $a_matchKey . ")";
							$map .= PHP_EOL . "{";
							$map .= PHP_EOL . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set the function logic";
							$map .= PHP_EOL . $this->_t(1) . "if (";
							$if = $ifValue[$a_matchKey];
							if (ComponentbuilderHelper::checkString($if))
							{
								$map .= $if;
							}
							$map .= ")";
							$map .= PHP_EOL . $this->_t(1) . "{";
							$map .= PHP_EOL . $this->_t(2) . "return true;";
							$map .= PHP_EOL . $this->_t(1) . "}" . PHP_EOL . $this->_t(1) . "return false;";
							$map .= PHP_EOL . "}" . PHP_EOL;
						}
						$func .= PHP_EOL . PHP_EOL . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set this function logic";
						$func .= PHP_EOL . $this->_t(1) . "if (";
						// set if counter
						$aifcounter = 0;
						foreach ($f_matchKeys as $af_matchKey)
						{
							$name = $matchNames[$af_matchKey];
							if ($aifcounter == 0)
							{
								$func .= $name;
							}
							else
							{
								$func .= ' && ' . $name;
							}
							$aifcounter++;
						}
						$func .= ")" . PHP_EOL . $this->_t(1) . "{";
					}
					else
					{
						$func .= PHP_EOL . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set the function logic";
						$func .= PHP_EOL . $this->_t(1) . "if (";
						// set if counter
						$ifcounter = 0;
						foreach ($f_matchKeys as $f_matchKey)
						{
							$if = $ifValue[$f_matchKey];
							if (ComponentbuilderHelper::checkString($if))
							{
								if ($ifcounter == 0)
								{
									$func .= $if;
								}
								else
								{
									$func .= ' && ' . $if;
								}
								$ifcounter++;
							}
						}
						$func .= ")" . PHP_EOL . $this->_t(1) . "{";
					}
					// get the controles
					$controls = $targetControls[$f_matchKeys[0]];
					// get target behavior and default
					$targetBehavior = $behaviors[$f_matchKeys[0]];
					$targetDefault = $defaults[$f_matchKeys[0]];
					// load the target behavior
					foreach ($controls as $target => $action)
					{
						$func .= $action['behavior'];
						if (ComponentbuilderHelper::checkString($action[$targetBehavior]))
						{
							$func .= $action[$targetBehavior];
							$head .= $action['requiredVar'];
						}
					}
					// check if this is a toggle switch
					if ($toggleSwitch[$f_matchKeys[0]])
					{
						$func .= PHP_EOL . $this->_t(1) . "}" . PHP_EOL . $this->_t(1) . "else" . PHP_EOL . $this->_t(1) . "{";
						// load the default behavior
						foreach ($controls as $target => $action)
						{
							$func .= $action['default'];
							if (ComponentbuilderHelper::checkString($action[$targetDefault]))
							{
								$func .= $action[$targetDefault];
							}
						}
					}
					$func .= PHP_EOL . $this->_t(1) . "}" . PHP_EOL . "}" . PHP_EOL . $map;
				}
				// add the needed validation to file
				if (isset($this->validationFixBuilder[$viewName]) && ComponentbuilderHelper::checkArray($this->validationFixBuilder[$viewName]))
				{
					$validation .= PHP_EOL . "// update required fields";
					$validation .= PHP_EOL . "function updateFieldRequired(name,status)";
					$validation .= PHP_EOL . "{";
					$validation .= PHP_EOL . $this->_t(1) . "var not_required = jQuery('#jform_not_required').val();";
					$validation .= PHP_EOL . PHP_EOL . $this->_t(1) . "if(status == 1)";
					$validation .= PHP_EOL . $this->_t(1) . "{";
					$validation .= PHP_EOL . $this->_t(2) . "if (isSet(not_required) && not_required != 0)";
					$validation .= PHP_EOL . $this->_t(2) . "{";
					$validation .= PHP_EOL . $this->_t(3) . "not_required = not_required+','+name;";
					$validation .= PHP_EOL . $this->_t(2) . "}";
					$validation .= PHP_EOL . $this->_t(2) . "else";
					$validation .= PHP_EOL . $this->_t(2) . "{";
					$validation .= PHP_EOL . $this->_t(3) . "not_required = ','+name;";
					$validation .= PHP_EOL . $this->_t(2) . "}";
					$validation .= PHP_EOL . $this->_t(1) . "}";
					$validation .= PHP_EOL . $this->_t(1) . "else";
					$validation .= PHP_EOL . $this->_t(1) . "{";
					$validation .= PHP_EOL . $this->_t(2) . "if (isSet(not_required) && not_required != 0)";
					$validation .= PHP_EOL . $this->_t(2) . "{";
					$validation .= PHP_EOL . $this->_t(3) . "not_required = not_required.replace(','+name,'');";
					$validation .= PHP_EOL . $this->_t(2) . "}";
					$validation .= PHP_EOL . $this->_t(1) . "}";
					$validation .= PHP_EOL . PHP_EOL . $this->_t(1) . "jQuery('#jform_not_required').val(not_required);";
					$validation .= PHP_EOL . "}" . PHP_EOL;
				}
				// set the isSet function
				$isSet = PHP_EOL . "// the isSet function";
				$isSet .= PHP_EOL . "function isSet(val)";
				$isSet .= PHP_EOL . "{";
				$isSet .= PHP_EOL . $this->_t(1) . "if ((val != undefined) && (val != null) && 0 !== val.length){";
				$isSet .= PHP_EOL . $this->_t(2) . "return true;";
				$isSet .= PHP_EOL . $this->_t(1) . "}";
				$isSet .= PHP_EOL . $this->_t(1) . "return false;";
				$isSet .= PHP_EOL . "}";
			}
			// load to this buket
			$fileScript = $initial . $func . $validation . $isSet;
			$footerScript = $listener;
		}
		// add custom script to edit form JS file
		if (!isset($fileScript))
		{
			$fileScript = '';
		}
		$fileScript .= $this->getCustomScriptBuilder('view_file', $viewName, PHP_EOL . PHP_EOL, null, true, '');
		// add custom script to footer
		if (isset($this->customScriptBuilder['view_footer'][$viewName]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['view_footer'][$viewName]))
		{
			$customFooterScript = PHP_EOL . PHP_EOL . $this->setPlaceholders($this->customScriptBuilder['view_footer'][$viewName], $this->placeholders);
			if (strpos($customFooterScript, '<?php') === false)
			{
				// only add now if no php is added to the footer script
				if (!isset($footerScript))
				{
					$footerScript = '';
				}
				$footerScript .= $customFooterScript;
				unset($customFooterScript);
			}
		}
		// set view listname
		$viewName_list = ComponentbuilderHelper::safeString($viewArray['settings']->name_list);
		// add custom script to list view JS file
		if (($list_fileScript = $this->getCustomScriptBuilder('views_file', $viewName, PHP_EOL . PHP_EOL, null, true, false)) !== false &&
			ComponentbuilderHelper::checkString($list_fileScript))
		{
			// get dates
			$_created = $this->getCreatedDate($viewArray);
			$_modified = $this->getLastModifiedDate($viewArray);
			// add file to view
			$_target = array($this->target => $viewName_list);
			$_config = array($this->hhh . 'CREATIONDATE' . $this->hhh => $_created, $this->hhh . 'BUILDDATE' . $this->hhh => $_modified, $this->hhh . 'VERSION' . $this->hhh => $viewArray['settings']->version);
			$this->buildDynamique($_target, 'javascript_file', false, $_config);
			// set path
			$_path = '/administrator/components/com_' . $this->componentCodeName . '/assets/js/' . $viewName_list . '.js';
			// load the file to the list view
			$this->fileContentDynamic[$viewName_list][$this->hhh . 'ADMIN_ADD_JAVASCRIPT_FILE' . $this->hhh] = PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add List View JavaScript File" . PHP_EOL . $this->_t(2) . $this->setIncludeLibScript($_path);
		}
		else
		{
			$list_fileScript = '';
			$this->fileContentDynamic[$viewName_list][$this->hhh . 'ADMIN_ADD_JAVASCRIPT_FILE' . $this->hhh] = '';
		}
		// minfy the script
		if ($this->minify && isset($list_fileScript) && ComponentbuilderHelper::checkString($list_fileScript))
		{
			// minify the fielScript javscript
			$minifier = new JS;
			$minifier->add($list_fileScript);
			$list_fileScript = $minifier->minify();
		}
		// minfy the script
		if ($this->minify && isset($fileScript) && ComponentbuilderHelper::checkString($fileScript))
		{
			// minify the fielScript javscript
			$minifier = new JS;
			$minifier->add($fileScript);
			$fileScript = $minifier->minify();
		}
		// minfy the script
		if ($this->minify && isset($footerScript) && ComponentbuilderHelper::checkString($footerScript))
		{
			// minify the footerScript javscript
			$minifier = new JS;
			$minifier->add($footerScript);
			$footerScript = $minifier->minify();
		}
		// make sure there is script to add
		if (isset($list_fileScript) && ComponentbuilderHelper::checkString($list_fileScript))
		{
			// load the script
			$this->viewScriptBuilder[$viewName]['list_fileScript'] = $list_fileScript;
		}
		// make sure there is script to add
		if (isset($fileScript) && ComponentbuilderHelper::checkString($fileScript))
		{
			// add the head script if set
			if (isset($head) && ComponentbuilderHelper::checkString($head))
			{
				$fileScript = "// Some Global Values" . PHP_EOL . $head . PHP_EOL . $fileScript;
			}
			// load the script
			$this->viewScriptBuilder[$viewName]['fileScript'] = $fileScript;
		}
		// make sure to add custom footer script if php was found in it, since we canot minfy it with php
		if (isset($customFooterScript) && ComponentbuilderHelper::checkString($customFooterScript))
		{
			if (!isset($footerScript))
			{
				$footerScript = '';
			}
			$footerScript .= $customFooterScript;
		}
		// make sure there is script to add
		if (isset($footerScript) && ComponentbuilderHelper::checkString($footerScript))
		{
			// add the needed script tags
			$footerScript = PHP_EOL . PHP_EOL . '<script type="text/javascript">' . PHP_EOL . $footerScript . PHP_EOL . "</script>";
			$this->viewScriptBuilder[$viewName]['footerScript'] = $footerScript;
		}
	}

	public function buildFunctionCall($function, $matchKeys, $getValue)
	{
		$initial = '';
		$funcsets = array();
		$array = false;
		foreach ($matchKeys as $matchKey)
		{
			$value = $getValue[$matchKey];
			if ($value['isArray'])
			{
				$initial .= PHP_EOL . $this->_t(1) . $value['get'];
				$funcsets[] = $matchKey;
				$array = true;
			}
			else
			{
				$initial .= PHP_EOL . $this->_t(1) . $value['get'];
				$funcsets[] = $matchKey;
			}
		}

		// make sure that the function is loaded only once
		if (ComponentbuilderHelper::checkArray($funcsets))
		{
			$initial .= PHP_EOL . $this->_t(1) . $function . "(";
			$initial .= implode(',', $funcsets);
			$initial .= ");" . PHP_EOL;
		}
		return array('code' => $initial, 'array' => $array);
	}

	public function getTargetRelationScript($relations, $condition, $view)
	{
		// reset the buket
		$buket = array();
		// convert to name array
		foreach ($condition['target_field'] as $targetField)
		{
			if (ComponentbuilderHelper::checkArray($targetField) && isset($targetField['name']))
			{
				$currentTargets[] = $targetField['name'];
			}
		}
		// start the search
		foreach ($relations as $relation)
		{
			// reset found
			$found = false;
			// chain only none matching fields
			if ($relation['match_field'] !== $condition['match_field'] && $relation['target_relation']) // Made this change to see if it improves the expected result (TODO)
			{
				if (ComponentbuilderHelper::checkArray($relation['target_field']))
				{
					foreach ($relation['target_field'] as $target)
					{
						if (ComponentbuilderHelper::checkArray($target) && $this->checkRelationControl($target['name'], $relation['match_name'], $condition['match_name'], $view))
						{
							if (in_array($target['name'], $currentTargets))
							{
								$this->targetRelationControl[$view][$target['name']] = array($relation['match_name'], $condition['match_name']);
								$found = true;
								break;
							}
						}
					}
					if ($found)
					{
						$buket[] = $relation;
					}
				}
			}
		}
		return $buket;
	}

	public function checkRelationControl($targetName, $relationMatchName, $conditionMatchName, $view)
	{
		if (isset($this->targetRelationControl[$view]) && ComponentbuilderHelper::checkArray($this->targetRelationControl[$view]))
		{
			if (isset($this->targetRelationControl[$view][$targetName]) && ComponentbuilderHelper::checkArray($this->targetRelationControl[$view][$targetName]))
			{
				if (!in_array($relationMatchName, $this->targetRelationControl[$view][$targetName]) || !in_array($conditionMatchName, $this->targetRelationControl[$view][$targetName]))
				{
					return true;
				}
			}
			else
			{
				return true;
			}
		}
		elseif (!isset($this->targetRelationControl[$view]) || !ComponentbuilderHelper::checkArray($this->targetRelationControl[$view]))
		{
			return true;
		}
		return false;
	}

	public function setTargetControlsScript($toggleSwitch, $targets, $targetBehavior, $targetDefault, $uniqueVar, $viewName)
	{
		$bucket = array();
		if (ComponentbuilderHelper::checkArray($targets) && !in_array($uniqueVar, $this->targetControlsScriptChecker))
		{
			foreach ($targets as $target)
			{
				if (ComponentbuilderHelper::checkArray($target))
				{
					// set the required var
					if ($target['required'] === 'yes')
					{
						$unique = $uniqueVar . $this->uniquekey(3);
						$bucket[$target['name']]['requiredVar'] = "jform_" . $unique . "_required = false;" . PHP_EOL;
					}
					else
					{
						$bucket[$target['name']]['requiredVar'] = '';
					}
					// set target type
					$targetTypeSufix = "";
					if (ComponentbuilderHelper::fieldCheck($target['type'], 'spacer'))
					{
						// target a class if this is a note or spacer
						$targetType = ".";
					}
					elseif ($target['type'] === 'editor' || $target['type'] === 'subform')
					{
						// target the label if  editor field
						$targetType = "#jform_";
						// since the id is not alway accessable we use the lable TODO (not best way)
						$targetTypeSufix = "-lbl";
					}
					else
					{
						// target an id if this is a field
						$targetType = "#jform_";
					}
					// set the target behavior
					$bucket[$target['name']]['behavior'] = PHP_EOL . $this->_t(2) . "jQuery('" . $targetType . $target['name'] . $targetTypeSufix . "').closest('.control-group')." . $targetBehavior . "();";
					// set the target default
					$bucket[$target['name']]['default'] = PHP_EOL . $this->_t(2) . "jQuery('" . $targetType . $target['name'] . $targetTypeSufix . "').closest('.control-group')." . $targetDefault . "();";
					// the hide required function
					if ($target['required'] === 'yes')
					{
						if ($toggleSwitch)
						{
							$hide = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " remove required attribute from " . $target['name'] . " field";
							$hide .= PHP_EOL . $this->_t(2) . "if (!jform_" . $unique . "_required)";
							$hide .= PHP_EOL . $this->_t(2) . "{";
							$hide .= PHP_EOL . $this->_t(3) . "updateFieldRequired('" . $target['name'] . "',1);";
							$hide .= PHP_EOL . $this->_t(3) . "jQuery('#jform_" . $target['name'] . "').removeAttr('required');";
							$hide .= PHP_EOL . $this->_t(3) . "jQuery('#jform_" . $target['name'] . "').removeAttr('aria-required');";
							$hide .= PHP_EOL . $this->_t(3) . "jQuery('#jform_" . $target['name'] . "').removeClass('required');";
							$hide .= PHP_EOL . $this->_t(3) . "jform_" . $unique . "_required = true;";
							$hide .= PHP_EOL . $this->_t(2) . "}";
							$bucket[$target['name']]['hide'] = $hide;
							// the show required function
							$show = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " add required attribute to " . $target['name'] . " field";
							$show .= PHP_EOL . $this->_t(2) . "if (jform_" . $unique . "_required)";
							$show .= PHP_EOL . $this->_t(2) . "{";
							$show .= PHP_EOL . $this->_t(3) . "updateFieldRequired('" . $target['name'] . "',0);";
							$show .= PHP_EOL . $this->_t(3) . "jQuery('#jform_" . $target['name'] . "').prop('required','required');";
							$show .= PHP_EOL . $this->_t(3) . "jQuery('#jform_" . $target['name'] . "').attr('aria-required',true);";
							$show .= PHP_EOL . $this->_t(3) . "jQuery('#jform_" . $target['name'] . "').addClass('required');";
							$show .= PHP_EOL . $this->_t(3) . "jform_" . $unique . "_required = false;";
							$show .= PHP_EOL . $this->_t(2) . "}";
							$bucket[$target['name']]['show'] = $show;
						}
						else
						{
							$hide = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " remove required attribute from " . $target['name'] . " field";
							$hide .= PHP_EOL . $this->_t(2) . "updateFieldRequired('" . $target['name'] . "',1);";
							$hide .= PHP_EOL . $this->_t(2) . "jQuery('#jform_" . $target['name'] . "').removeAttr('required');";
							$hide .= PHP_EOL . $this->_t(2) . "jQuery('#jform_" . $target['name'] . "').removeAttr('aria-required');";
							$hide .= PHP_EOL . $this->_t(2) . "jQuery('#jform_" . $target['name'] . "').removeClass('required');";
							$hide .= PHP_EOL . $this->_t(2) . "jform_" . $unique . "_required = true;" . PHP_EOL;
							$bucket[$target['name']]['hide'] = $hide;
							// the show required function
							$show = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " add required attribute to " . $target['name'] . " field";
							$show .= PHP_EOL . $this->_t(2) . "updateFieldRequired('" . $target['name'] . "',0);";
							$show .= PHP_EOL . $this->_t(2) . "jQuery('#jform_" . $target['name'] . "').prop('required','required');";
							$show .= PHP_EOL . $this->_t(2) . "jQuery('#jform_" . $target['name'] . "').attr('aria-required',true);";
							$show .= PHP_EOL . $this->_t(2) . "jQuery('#jform_" . $target['name'] . "').addClass('required');";
							$show .= PHP_EOL . $this->_t(2) . "jform_" . $unique . "_required = false;" . PHP_EOL;
							$bucket[$target['name']]['show'] = $show;
						}
						// make sure that the axaj and other needed things for this view is loaded
						$this->validationFixBuilder[$viewName][] = $target['name'];
					}
					else
					{
						$bucket[$target['name']]['hide'] = '';
						$bucket[$target['name']]['show'] = '';
					}
				}
			}
			$this->targetControlsScriptChecker[] = $uniqueVar;
		}
		return $bucket;
	}

	public function ifValueScript($value, $behavior, $type, $options)
	{
		// reset string
		$string = '';
		switch ($behavior)
		{
			case 1: // Is
				// only 4 list/radio/checkboxes
				if (ComponentbuilderHelper::fieldCheck($type, 'list') || ComponentbuilderHelper::fieldCheck($type, 'dynamic') || !ComponentbuilderHelper::fieldCheck($type))
				{
					if (ComponentbuilderHelper::checkArray($options))
					{
						foreach ($options as $option)
						{
							if (!is_numeric($option))
							{
								if ($option != 'true' && $option != 'false')
								{
									$option = "'" . $option . "'";
								}
							}
							if (ComponentbuilderHelper::checkString($string))
							{
								$string .= ' || ' . $value . ' == ' . $option;
							}
							else
							{
								$string .= $value . ' == ' . $option;
							}
						}
					}
					else
					{
						$string .= 'isSet(' . $value . ')';
					}
				}
				break;
			case 2: // Is Not
				// only 4 list/radio/checkboxes
				if (ComponentbuilderHelper::fieldCheck($type, 'list') || ComponentbuilderHelper::fieldCheck($type, 'dynamic') || !ComponentbuilderHelper::fieldCheck($type))
				{
					if (ComponentbuilderHelper::checkArray($options))
					{
						foreach ($options as $option)
						{
							if (!is_numeric($option))
							{
								if ($option != 'true' && $option != 'false')
								{
									$option = "'" . $option . "'";
								}
							}
							if (ComponentbuilderHelper::checkString($string))
							{
								$string .= ' || ' . $value . ' != ' . $option;
							}
							else
							{
								$string .= $value . ' != ' . $option;
							}
						}
					}
					else
					{
						$string .= '!isSet(' . $value . ')';
					}
				}
				break;
			case 3: // Any Selection
				// only 4 list/radio/checkboxes/dynamic_list
				if (ComponentbuilderHelper::fieldCheck($type, 'list') || ComponentbuilderHelper::fieldCheck($type, 'dynamic') || !ComponentbuilderHelper::fieldCheck($type))
				{
					if (ComponentbuilderHelper::checkArray($options))
					{
						foreach ($options as $option)
						{
							if (!is_numeric($option))
							{
								if ($option != 'true' && $option != 'false')
								{
									$option = "'" . $option . "'";
								}
							}
							if (ComponentbuilderHelper::checkString($string))
							{
								$string .= ' || ' . $value . ' == ' . $option;
							}
							else
							{
								$string .= $value . ' == ' . $option;
							}
						}
					}
					else
					{
						$userFix = '';
						if (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($type, $this->setScriptUserSwitch))
						{
							// TODO this needs a closer look, a bit buggy
							$userFix = " && " . $value . " != 0";
						}
						$string .= 'isSet(' . $value . ')' . $userFix;
					}
				}
				break;
			case 4: // Active (not empty)
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					$string .= 'isSet(' . $value . ')';
				}
				break;
			case 5: // Unactive (empty)
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					$string .= '!isSet(' . $value . ')';
				}
				break;
			case 6: // Key Word All (case-sensitive)
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					if (ComponentbuilderHelper::checkArray($options['keywords']))
					{
						foreach ($options['keywords'] as $keyword)
						{
							if (ComponentbuilderHelper::checkString($string))
							{
								$string .= ' && ' . $value . '.indexOf("' . $keyword . '") >= 0';
							}
							else
							{
								$string .= $value . '.indexOf("' . $keyword . '") >= 0';
							}
						}
					}
					if (!ComponentbuilderHelper::checkString($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 7: // Key Word Any (case-sensitive)
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					if (ComponentbuilderHelper::checkArray($options['keywords']))
					{
						foreach ($options['keywords'] as $keyword)
						{
							if (ComponentbuilderHelper::checkString($string))
							{
								$string .= ' || ' . $value . '.indexOf("' . $keyword . '") >= 0';
							}
							else
							{
								$string .= $value . '.indexOf("' . $keyword . '") >= 0';
							}
						}
					}
					if (!ComponentbuilderHelper::checkString($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 8: // Key Word All (case-insensitive)
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					if (ComponentbuilderHelper::checkArray($options['keywords']))
					{
						foreach ($options['keywords'] as $keyword)
						{
							$keyword = ComponentbuilderHelper::safeString($keyword, 'w');
							if (ComponentbuilderHelper::checkString($string))
							{
								$string .= ' && ' . $value . '.toLowerCase().indexOf("' . $keyword . '") >= 0';
							}
							else
							{
								$string .= $value . '.toLowerCase().indexOf("' . $keyword . '") >= 0';
							}
						}
					}
					if (!ComponentbuilderHelper::checkString($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 9: // Key Word Any (case-insensitive)
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					if (ComponentbuilderHelper::checkArray($options['keywords']))
					{
						foreach ($options['keywords'] as $keyword)
						{
							$keyword = ComponentbuilderHelper::safeString($keyword, 'w');
							if (ComponentbuilderHelper::checkString($string))
							{
								$string .= ' || ' . $value . '.toLowerCase().indexOf("' . $keyword . '") >= 0';
							}
							else
							{
								$string .= $value . '.toLowerCase().indexOf("' . $keyword . '") >= 0';
							}
						}
					}
					if (!ComponentbuilderHelper::checkString($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 10: // Min Length
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					if (ComponentbuilderHelper::checkArray($options))
					{
						if ($options['length'])
						{
							$string .= $value . '.length >= ' . (int) $options['length'];
						}
					}
					if (!ComponentbuilderHelper::checkString($string))
					{
						$string .= $value . '.length >= 5';
					}
				}
				break;
			case 11: // Max Length
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					if (ComponentbuilderHelper::checkArray($options))
					{
						if ($options['length'])
						{
							$string .= $value . '.length <= ' . (int) $options['length'];
						}
					}
					if (!ComponentbuilderHelper::checkString($string))
					{
						$string .= $value . '.length <= 5';
					}
				}
				break;
			case 12: // Exact Length
				// only 4 text_field
				if (ComponentbuilderHelper::fieldCheck($type, 'text'))
				{
					if (ComponentbuilderHelper::checkArray($options))
					{
						if ($options['length'])
						{
							$string .= $value . '.length == ' . (int) $options['length'];
						}
					}
					if (!ComponentbuilderHelper::checkString($string))
					{
						$string .= $value . '.length == 5';
					}
				}
				break;
		}
		if (!ComponentbuilderHelper::checkString($string))
		{
			$string = 0;
		}
		return $string;
	}

	public function getOptionsScript($type, $options)
	{
		$buket = array();
		if (ComponentbuilderHelper::checkString($options))
		{
			if (ComponentbuilderHelper::fieldCheck($type, 'list') || ComponentbuilderHelper::fieldCheck($type, 'dynamic') || !ComponentbuilderHelper::fieldCheck($type))
			{
				$optionsArray = array_map('trim', (array) explode(PHP_EOL, $options));
				if (!ComponentbuilderHelper::checkArray($optionsArray))
				{
					$optionsArray[] = $optionsArray;
				}
				foreach ($optionsArray as $option)
				{
					if (strpos($option, '|') !== false)
					{
						list($option) = array_map('trim', (array) explode('|', $option));
					}
					if ($option != 'dynamic_list')
					{
						// add option to return buket
						$buket[] = $option;
					}
				}
			}
			elseif (ComponentbuilderHelper::fieldCheck($type, 'text'))
			{
				// check to get the key words if set
				$keywords = ComponentbuilderHelper::getBetween($options, 'keywords="', '"');
				if (ComponentbuilderHelper::checkString($keywords))
				{
					if (strpos($keywords, ',') !== false)
					{
						$keywords = array_map('trim', (array) explode(',', $keywords));
						foreach ($keywords as $keyword)
						{
							$buket['keywords'][] = trim($keyword);
						}
					}
					else
					{
						$buket['keywords'][] = trim($keywords);
					}
				}
				// check to ket string length if set
				$length = ComponentbuilderHelper::getBetween($options, 'length="', '"');
				if (ComponentbuilderHelper::checkString($length))
				{
					$buket['length'] = $length;
				}
				else
				{
					$buket['length'] = false;
				}
			}
		}

		return $buket;
	}

	public function getValueScript($type, $name, $extends, $unique)
	{
		$select = '';
		$isArray = false;
		$keyName = $name . '_' . $unique;
		if ($type === 'checkboxes' || $extends === 'checkboxes')
		{
			$select = "var " . $keyName . " = [];" . PHP_EOL . $this->_t(1) . "jQuery('#jform_" . $name . " input[type=checkbox]').each(function()" . PHP_EOL . $this->_t(1) . "{" . PHP_EOL . $this->_t(2) . "if (jQuery(this).is(':checked'))" . PHP_EOL . $this->_t(2) . "{" . PHP_EOL . $this->_t(3) . $keyName . ".push(jQuery(this).prop('value'));" . PHP_EOL . $this->_t(2) . "}" . PHP_EOL . $this->_t(1) . "});";
			$isArray = true;
		}
		elseif ($type === 'checkbox')
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name . '").prop(\'checked\');';
		}
		elseif ($type === 'radio')
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name . ' input[type=\'radio\']:checked").val();';
		}
		elseif (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($type, $this->setScriptUserSwitch))
		{
			// this is only since 3.3.4
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name . '_id").val();';
		}
		elseif ($type === 'list' || ComponentbuilderHelper::fieldCheck($type, 'dynamic') || !ComponentbuilderHelper::fieldCheck($type))
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name . '").val();';
			$isArray = true;
		}
		elseif (ComponentbuilderHelper::fieldCheck($type, 'text'))
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name . '").val();';
		}
		return array('get' => $select, 'isArray' => $isArray);
	}

	public function clearValueScript($type, $name, $unique)
	{
		$clear = '';
		$isArray = false;
		$keyName = $name . '_' . $unique;
		if ($type === 'text' || $type === 'password' || $type === 'textarea')
		{
			$clear = "jQuery('#jform_" . $name . "').value = '';";
		}
		elseif ($type === 'radio')
		{
			$clear = "jQuery('#jform_" . $name . "').checked = false;";
		}
		elseif ($type === 'checkboxes' || $type === 'checkbox' || $type === 'checkbox')
		{
			$clear = "jQuery('#jform_" . $name . "').selectedIndex = -1;";
		}
		return $clear;
	}

	public function setViewScript(&$view, $type)
	{
		if (isset($this->viewScriptBuilder[$view]) && isset($this->viewScriptBuilder[$view][$type]))
		{
			return $this->viewScriptBuilder[$view][$type];
		}
		return '';
	}

	public function setValidationFix($view, $Component)
	{
		$fix = '';
		if (isset($this->validationFixBuilder[$view]) && ComponentbuilderHelper::checkArray($this->validationFixBuilder[$view]))
		{
			$fix .= PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$fix .= PHP_EOL . $this->_t(1) . " * Method to validate the form data.";
			$fix .= PHP_EOL . $this->_t(1) . " *";
			$fix .= PHP_EOL . $this->_t(1) . " * @param   JForm   \$form   The form to validate against.";
			$fix .= PHP_EOL . $this->_t(1) . " * @param   array   \$data   The data to validate.";
			$fix .= PHP_EOL . $this->_t(1) . " * @param   string  \$group  The name of the field group to validate.";
			$fix .= PHP_EOL . $this->_t(1) . " *";
			$fix .= PHP_EOL . $this->_t(1) . " * @return  mixed  Array of filtered data if valid, false otherwise.";
			$fix .= PHP_EOL . $this->_t(1) . " *";
			$fix .= PHP_EOL . $this->_t(1) . " * @see     JFormRule";
			$fix .= PHP_EOL . $this->_t(1) . " * @see     JFilterInput";
			$fix .= PHP_EOL . $this->_t(1) . " * @since   12.2";
			$fix .= PHP_EOL . $this->_t(1) . " */";
			$fix .= PHP_EOL . $this->_t(1) . "public function validate(\$form, \$data, \$group = null)";
			$fix .= PHP_EOL . $this->_t(1) . "{";
			$fix .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if the not_required field is set";
			$fix .= PHP_EOL . $this->_t(2) . "if (" . $Component . "Helper::checkString(\$data['not_required']))";
			$fix .= PHP_EOL . $this->_t(2) . "{";
			$fix .= PHP_EOL . $this->_t(3) . "\$requiredFields = (array) explode(',',(string) \$data['not_required']);";
			$fix .= PHP_EOL . $this->_t(3) . "\$requiredFields = array_unique(\$requiredFields);";
			$fix .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " now change the required field attributes value";
			$fix .= PHP_EOL . $this->_t(3) . "foreach (\$requiredFields as \$requiredField)";
			$fix .= PHP_EOL . $this->_t(3) . "{";
			$fix .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " make sure there is a string value";
			$fix .= PHP_EOL . $this->_t(4) . "if (" . $Component . "Helper::checkString(\$requiredField))";
			$fix .= PHP_EOL . $this->_t(4) . "{";
			$fix .= PHP_EOL . $this->_t(5) . "//" . $this->setLine(__LINE__) . " change to false";
			$fix .= PHP_EOL . $this->_t(5) . "\$form->setFieldAttribute(\$requiredField, 'required', 'false');";
			$fix .= PHP_EOL . $this->_t(5) . "//" . $this->setLine(__LINE__) . " also clear the data set";
			$fix .= PHP_EOL . $this->_t(5) . "\$data[\$requiredField] = '';";
			$fix .= PHP_EOL . $this->_t(4) . "}";
			$fix .= PHP_EOL . $this->_t(3) . "}";
			$fix .= PHP_EOL . $this->_t(2) . "}";
			$fix .= PHP_EOL . $this->_t(2) . "return parent::validate(\$form, \$data, \$group);";
			$fix .= PHP_EOL . $this->_t(1) . "}";
		}
		return $fix;
	}

	public function setAjaxToke(&$view)
	{
		$fix = '';
		if (isset($this->customScriptBuilder['token'][$view]) && $this->customScriptBuilder['token'][$view])
		{
			$fix .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Add Ajax Token";
			$fix .= PHP_EOL . $this->_t(2) . "\$this->document->addScriptDeclaration(\"var token = '\".JSession::getFormToken().\"';\");";
		}
		return $fix;
	}

	public function setRegisterAjaxTask($target)
	{
		$tasks = '';
		if (isset($this->customScriptBuilder[$target]['ajax_controller']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder[$target]['ajax_controller']))
		{
			$taskArray = array();
			foreach ($this->customScriptBuilder[$target]['ajax_controller'] as $view)
			{
				foreach ($view as $task)
				{
					$taskArray[$task['task_name']] = $task['task_name'];
				}
			}
			if (ComponentbuilderHelper::checkArray($taskArray))
			{
				foreach ($taskArray as $name)
				{
					$tasks .= PHP_EOL . $this->_t(2) . "\$this->registerTask('" . $name . "', 'ajax');";
				}
			}
		}
		return $tasks;
	}

	public function setAjaxInputReturn($target)
	{
		$cases = '';
		if (isset($this->customScriptBuilder[$target]['ajax_controller']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder[$target]['ajax_controller']))
		{
			$input = array();
			$valueArray = array();
			$ifArray = array();
			$getModel = array();
			$userCheck = array();
			foreach ($this->customScriptBuilder[$target]['ajax_controller'] as $view)
			{
				foreach ($view as $task)
				{
					$input[$task['task_name']][] = "\$" . $task['value_name'] . "Value = \$jinput->get('" . $task['value_name'] . "', " . $task['input_default'] . ", '" . $task['input_filter'] . "');";
					$valueArray[$task['task_name']][] = "\$" . $task['value_name'] . "Value";
					$getModel[$task['task_name']] = "\$result = \$this->getModel('ajax')->" . $task['method_name'] . "(" . $this->bbb . "valueArray" . $this->ddd . ");";
					// check if null or zero is allowed
					if (!isset($task['allow_zero']) || 1 != $task['allow_zero'])
					{
						$ifArray[$task['task_name']][] = "\$" . $task['value_name'] . "Value";
					}
					// see user check is needed
					if (!isset($userCheck[$task['task_name']]) && isset($task['user_check']) && 1 == $task['user_check'])
					{
						// add it since this means it was not set, and in the old method we assumed it was inplace
						// or it is set and 1 means we still want it inplace
						$ifArray[$task['task_name']][] = '$user->id != 0';
						// add it only once
						$userCheck[$task['task_name']] = true;
					}
				}
			}
			if (ComponentbuilderHelper::checkArray($getModel))
			{
				foreach ($getModel as $task => $getMethod)
				{
					$cases .= PHP_EOL . $this->_t(4) . "case '" . $task . "':";
					$cases .= PHP_EOL . $this->_t(5) . "try";
					$cases .= PHP_EOL . $this->_t(5) . "{";
					$cases .= PHP_EOL . $this->_t(6) . "\$returnRaw = \$jinput->get('raw', false, 'BOOLEAN');";
					foreach ($input[$task] as $string)
					{
						$cases .= PHP_EOL . $this->_t(6) . $string;
					}
					// set the values
					$values = implode(', ', $valueArray[$task]);
					// set the values to method
					$getMethod = str_replace($this->bbb . 'valueArray' . $this->ddd, $values, $getMethod);
					// check if we have some values to check
					if (isset($ifArray[$task]) && ComponentbuilderHelper::checkArray($ifArray[$task]))
					{
						// set if string
						$ifvalues = implode(' && ', $ifArray[$task]);
						// add to case
						$cases .= PHP_EOL . $this->_t(6) . "if(" . $ifvalues . ")";
						$cases .= PHP_EOL . $this->_t(6) . "{";
						$cases .= PHP_EOL . $this->_t(7) . $getMethod;
						$cases .= PHP_EOL . $this->_t(6) . "}";
						$cases .= PHP_EOL . $this->_t(6) . "else";
						$cases .= PHP_EOL . $this->_t(6) . "{";
						$cases .= PHP_EOL . $this->_t(7) . "\$result = false;";
						$cases .= PHP_EOL . $this->_t(6) . "}";
					}
					else
					{
						$cases .= PHP_EOL . $this->_t(6) . $getMethod;
					}
					// continue the build
					$cases .= PHP_EOL . $this->_t(6) . "if(\$callback = \$jinput->get('callback', null, 'CMD'))";
					$cases .= PHP_EOL . $this->_t(6) . "{";
					$cases .= PHP_EOL . $this->_t(7) . "echo \$callback . \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL . $this->_t(6) . "}";
					$cases .= PHP_EOL . $this->_t(6) . "elseif(\$returnRaw)";
					$cases .= PHP_EOL . $this->_t(6) . "{";
					$cases .= PHP_EOL . $this->_t(7) . "echo json_encode(\$result);";
					$cases .= PHP_EOL . $this->_t(6) . "}";
					$cases .= PHP_EOL . $this->_t(6) . "else";
					$cases .= PHP_EOL . $this->_t(6) . "{";
					$cases .= PHP_EOL . $this->_t(7) . "echo \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL . $this->_t(6) . "}";
					$cases .= PHP_EOL . $this->_t(5) . "}";
					$cases .= PHP_EOL . $this->_t(5) . "catch(Exception \$e)";
					$cases .= PHP_EOL . $this->_t(5) . "{";
					$cases .= PHP_EOL . $this->_t(6) . "if(\$callback = \$jinput->get('callback', null, 'CMD'))";
					$cases .= PHP_EOL . $this->_t(6) . "{";
					$cases .= PHP_EOL . $this->_t(7) . "echo \$callback.\"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL . $this->_t(6) . "}";
					$cases .= PHP_EOL . $this->_t(6) . "else";
					$cases .= PHP_EOL . $this->_t(6) . "{";
					$cases .= PHP_EOL . $this->_t(7) . "echo \"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL . $this->_t(6) . "}";
					$cases .= PHP_EOL . $this->_t(5) . "}";
					$cases .= PHP_EOL . $this->_t(4) . "break;";
				}
			}
		}
		return $cases;
	}

	public function setAjaxModelMethods($target)
	{
		$methods = '';
		if (isset($this->customScriptBuilder[$target]['ajax_model']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder[$target]['ajax_model']))
		{
			foreach ($this->customScriptBuilder[$target]['ajax_model'] as $view => $method)
			{
				$methods .= PHP_EOL . PHP_EOL . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Used in " . $view . PHP_EOL;
				$methods .= $this->setPlaceholders($method, $this->placeholders);
			}
		}
		return $methods;
	}

	public function setFilterFunctions($viewName_single, $viewName_list)
	{
		if (isset($this->filterBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$viewName_list]))
		{
			$function = array();
			// set component name
			$component = $this->componentCodeName;
			foreach ($this->filterBuilder[$viewName_list] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] === 'user')
				{
					$function[] = PHP_EOL . $this->_t(1) . "protected function getThe" . $filter['function'] . ComponentbuilderHelper::safeString($filter['custom']['text'], 'F') . "Selections()";
					$function[] = $this->_t(1) . "{";
					$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get a db connection.";
					$function[] = $this->_t(2) . "\$db = JFactory::getDbo();";
					$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
					$function[] = $this->_t(2) . "\$query = \$db->getQuery(true);";
					$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select the text.";
					$function[] = $this->_t(2) . "\$query->select(\$db->quoteName(array('a." . $filter['custom']['id'] . "','a." . $filter['custom']['text'] . "')));";
					$function[] = $this->_t(2) . "\$query->from(\$db->quoteName('" . $filter['custom']['table'] . "', 'a'));";
					$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get the targeted groups";
					$function[] = $this->_t(2) . "\$groups= JComponentHelper::getParams('com_" . $component . "')->get('" . $filter['type'] . "');";
					$function[] = $this->_t(2) . "if (!empty(\$groups) && count((array) \$groups) > 0)";
					$function[] = $this->_t(2) . "{";
					$function[] = $this->_t(3) . "\$query->join('LEFT', \$db->quoteName('#__user_usergroup_map', 'group') . ' ON (' . \$db->quoteName('group.user_id') . ' = ' . \$db->quoteName('a.id') . ')');";
					$function[] = $this->_t(3) . "\$query->where('group.group_id IN (' . implode(',', \$groups) . ')');";
					$function[] = $this->_t(2) . "}";
					$function[] = $this->_t(2) . "\$query->order('a." . $filter['custom']['text'] . " ASC');";
					$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Reset the query using our newly populated query object.";
					$function[] = $this->_t(2) . "\$db->setQuery(\$query);";
					$function[] = PHP_EOL . $this->_t(2) . "\$results = \$db->loadObjectList();";
					$function[] = $this->_t(2) . "if (\$results)";
					$function[] = $this->_t(2) . "{";
					$function[] = $this->_t(3) . "\$filter = array();";
					$function[] = $this->_t(3) . "\$batch = array();";
					$function[] = $this->_t(3) . "foreach (\$results as \$result)";
					$function[] = $this->_t(3) . "{";
					$function[] = $this->_t(4) . "\$filter[] = JHtml::_('select.option', \$result->" . $filter['custom']['id'] . ", \$result->" . $filter['custom']['text'] . ");";
					$function[] = $this->_t(3) . "}";
					$function[] = $this->_t(3) . "return  \$filter;";
					$function[] = $this->_t(2) . "}";
					$function[] = $this->_t(2) . "return false;";
					$function[] = $this->_t(1) . "}";

					/* else
					  {
					  $function[] = PHP_EOL.$this->_t(1) . "protected function getThe".$filter['function'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F')."Selections()";
					  $function[] = $this->_t(1) . "{";
					  $function[] = $this->_t(2) . "//".$this->setLine(__LINE__)." Get a db connection.";
					  $function[] = $this->_t(2) . "\$db = JFactory::getDbo();";
					  $function[] = PHP_EOL.$this->_t(2) . "//".$this->setLine(__LINE__)." Select the text.";
					  $function[] = $this->_t(2) . "\$query = \$db->getQuery(true);";
					  $function[] = PHP_EOL.$this->_t(2) . "//".$this->setLine(__LINE__)." Select the text.";
					  $function[] = $this->_t(2) . "\$query->select(\$db->quoteName(array('".$filter['custom']['id']."','".$filter['custom']['text']."')));";
					  $function[] = $this->_t(2) . "\$query->from(\$db->quoteName('".$filter['custom']['table']."'));";
					  $function[] = $this->_t(2) . "\$query->where(\$db->quoteName('published') . ' = 1');";
					  $function[] = $this->_t(2) . "\$query->order(\$db->quoteName('".$filter['custom']['text']."') . ' ASC');";
					  $function[] = PHP_EOL.$this->_t(2) . "//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					  $function[] = $this->_t(2) . "\$db->setQuery(\$query);";
					  $function[] = PHP_EOL.$this->_t(2) . "\$results = \$db->loadObjectList();";
					  $function[] = PHP_EOL.$this->_t(2) . "if (\$results)";
					  $function[] = $this->_t(2) . "{";
					  $function[] = $this->_t(3) . "\$filter = array();";
					  $function[] = $this->_t(3) . "\$batch = array();";
					  $function[] = $this->_t(3) . "foreach (\$results as \$result)";
					  $function[] = $this->_t(3) . "{";
					  if ($filter['custom']['text'] === 'user')
					  {
					  $function[] = $this->_t(4) . "\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['text'].", JFactory::getUser(\$result->".$filter['custom']['text'].")->name);";
					  $function[] = $this->_t(4) . "\$batch[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", JFactory::getUser(\$result->".$filter['custom']['text'].")->name);";
					  }
					  else
					  {
					  $function[] = $this->_t(4) . "\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['text'].", \$result->".$filter['custom']['text'].");";
					  $function[] = $this->_t(4) . "\$batch[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", \$result->".$filter['custom']['text'].");";
					  }
					  $function[] = $this->_t(3) . "}";
					  $function[] = $this->_t(3) . "return array('filter' => \$filter, 'batch' => \$batch);";
					  $function[] = $this->_t(2) . "}";
					  $function[] = $this->_t(2) . "return false;";
					  $function[] = $this->_t(1) . "}";
					  } */
				}
				elseif ($filter['type'] != 'category' && !ComponentbuilderHelper::checkArray($filter['custom']))
				{
					$translation = false;
					if (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list]) && array_key_exists($filter['code'], $this->selectionTranslationFixBuilder[$viewName_list]))
					{
						$translation = true;
					}
					$function[] = PHP_EOL . $this->_t(1) . "protected function getThe" . $filter['function'] . "Selections()";
					$function[] = $this->_t(1) . "{";
					$function[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get a db connection.";
					$function[] = $this->_t(2) . "\$db = JFactory::getDbo();";
					$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Create a new query object.";
					$function[] = $this->_t(2) . "\$query = \$db->getQuery(true);";

					// check if usergroup as we change to an object query
					if ($filter['type'] === 'usergroup')
					{
						$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select the text.";
						$function[] = $this->_t(2) . "\$query->select(\$db->quoteName('g." . $filter['code'] . "', 'id'));";
						$function[] = $this->_t(2) . "\$query->select(\$db->quoteName('ug.title', 'title'));";
						$function[] = $this->_t(2) . "\$query->from(\$db->quoteName('#__" . $component . "_" . $filter['database'] . "', 'g'));";
						$function[] = $this->_t(2) . "\$query->join('LEFT', \$db->quoteName('#__usergroups', 'ug') . ' ON (' . (\$db->quoteName('g." . $filter['code'] . "') . ' = ' . \$db->quoteName('ug.id') . ')'));";
						$function[] = $this->_t(2) . "\$query->order(\$db->quoteName('title') . ' ASC');";
						$function[] = $this->_t(2) . "\$query->group(\$db->quoteName('ug.id'));";
						$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Reset the query using our newly populated query object.";
						$function[] = $this->_t(2) . "\$db->setQuery(\$query);";
						$function[] = PHP_EOL . $this->_t(2) . "\$results = \$db->loadObjectList();";
					}
					else
					{
						$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Select the text.";
						$function[] = $this->_t(2) . "\$query->select(\$db->quoteName('" . $filter['code'] . "'));";
						$function[] = $this->_t(2) . "\$query->from(\$db->quoteName('#__" . $component . "_" . $filter['database'] . "'));";
						$function[] = $this->_t(2) . "\$query->order(\$db->quoteName('" . $filter['code'] . "') . ' ASC');";
						$function[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Reset the query using our newly populated query object.";
						$function[] = $this->_t(2) . "\$db->setQuery(\$query);";
						$function[] = PHP_EOL . $this->_t(2) . "\$results = \$db->loadColumn();";
					}

					$function[] = PHP_EOL . $this->_t(2) . "if (\$results)";
					$function[] = $this->_t(2) . "{";

					// check if translated value is used
					if ($translation)
					{
						$function[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " get model";
						$function[] = $this->_t(3) . "\$model = \$this->getModel();";
					}
					// check if usergroup as we change to an object query
					if ($filter['type'] !== 'usergroup')
					{
						$function[] = $this->_t(3) . "\$results = array_unique(\$results);";
					}
					$function[] = $this->_t(3) . "\$_filter = array();";
					$function[] = $this->_t(3) . "foreach (\$results as \$" . $filter['code'] . ")";
					$function[] = $this->_t(3) . "{";


					// check if translated value is used
					if ($translation)
					{
						$function[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Translate the " . $filter['code'] . " selection";
						$function[] = $this->_t(4) . "\$text = \$model->selectionTranslation(\$" . $filter['code'] . ",'" . $filter['code'] . "');";
						$function[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Now add the " . $filter['code'] . " and its text to the options array";
						$function[] = $this->_t(4) . "\$_filter[] = JHtml::_('select.option', \$" . $filter['code'] . ", JText:" . ":_(\$text));";
					}
					elseif ($filter['type'] === 'user')
					{
						$function[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Now add the " . $filter['code'] . " and its text to the options array";
						$function[] = $this->_t(4) . "\$_filter[] = JHtml::_('select.option', \$" . $filter['code'] . ", JFactory::getUser(\$" . $filter['code'] . ")->name);";
					}
					else if ($filter['type'] === 'usergroup')
					{
						$function[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Now add the " . $filter['code'] . " and its text to the options array";
						$function[] = $this->_t(4) . "\$_filter[] = JHtml::_('select.option', \$" . $filter['code'] . "->id, \$" . $filter['code'] . "->title);";
					}
					else
					{
						$function[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Now add the " . $filter['code'] . " and its text to the options array";
						$function[] = $this->_t(4) . "\$_filter[] = JHtml::_('select.option', \$" . $filter['code'] . ", \$" . $filter['code'] . ");";
					}
					$function[] = $this->_t(3) . "}";
					$function[] = $this->_t(3) . "return \$_filter;";
					$function[] = $this->_t(2) . "}";
					$function[] = $this->_t(2) . "return false;";
					$function[] = $this->_t(1) . "}";
				}
			}
			if (ComponentbuilderHelper::checkArray($function))
			{
				// return the function
				return PHP_EOL . implode(PHP_EOL, $function);
			}
		}
		return '';
	}

	public function setUniqueFields(&$view)
	{
		$fields = array();
		$fields[] = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$fields[] = $this->_t(1) . " * Method to get the unique fields of this table.";
		$fields[] = $this->_t(1) . " *";
		$fields[] = $this->_t(1) . " * @return  mixed  An array of field names, boolean false if none is set.";
		$fields[] = $this->_t(1) . " *";
		$fields[] = $this->_t(1) . " * @since   3.0";
		$fields[] = $this->_t(1) . " */";
		$fields[] = $this->_t(1) . "protected function getUniqeFields()";
		$fields[] = $this->_t(1) . "{";
		if (isset($this->dbUniqueKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbUniqueKeys[$view]))
		{
			$fields[] = $this->_t(2) . "return array('" . implode("','", $this->dbUniqueKeys[$view]) . "');";
		}
		else
		{
			$fields[] = $this->_t(2) . "return false;";
		}
		$fields[] = $this->_t(1) . "}";
		// return the unique fields
		return implode(PHP_EOL, $fields);
	}

	public function setOtherFilter(&$view)
	{
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			// get component name
			$Component = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh];
			$otherFilter = array();
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] !== 'user')
				{
					$CodeName = ComponentbuilderHelper::safeString($filter['code'] . ' ' . $filter['custom']['text'], 'W');
					$codeName = $filter['code'] . ComponentbuilderHelper::safeString($filter['custom']['text'], 'F');
					$type = ComponentbuilderHelper::safeString($filter['custom']['type'], 'F');
					$otherFilter[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set " . $CodeName . " Selection";
					$otherFilter[] = $this->_t(2) . "\$this->" . $codeName . "Options = JFormHelper::loadFieldType('" . $type . "')->options;";
					$otherFilter[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " We do some sanitation for " . $CodeName . " filter";
					$otherFilter[] = $this->_t(2) . "if (" . $Component . "Helper::checkArray(\$this->" . $codeName . "Options) &&";
					$otherFilter[] = $this->_t(3) . "isset(\$this->" . $codeName . "Options[0]->value) &&";
					$otherFilter[] = $this->_t(3) . "!" . $Component . "Helper::checkString(\$this->" . $codeName . "Options[0]->value))";
					$otherFilter[] = $this->_t(2) . "{";
					$otherFilter[] = $this->_t(3) . "unset(\$this->" . $codeName . "Options[0]);";
					$otherFilter[] = $this->_t(2) . "}";
					$otherFilter[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Only load " . $CodeName . " filter if it has values";
					$otherFilter[] = $this->_t(2) . "if (" . $Component . "Helper::checkArray(\$this->" . $codeName . "Options))";
					$otherFilter[] = $this->_t(2) . "{";
					$otherFilter[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " " . $CodeName . " Filter";
					$otherFilter[] = $this->_t(3) . "JHtmlSidebar::addFilter(";
					$otherFilter[] = $this->_t(4) . "'- Select '.JText:" . ":_('" . $filter['lang'] . "').' -',";
					$otherFilter[] = $this->_t(4) . "'filter_" . $filter['code'] . "',";
					$otherFilter[] = $this->_t(4) . "JHtml::_('select.options', \$this->" . $codeName . "Options, 'value', 'text', \$this->state->get('filter." . $filter['code'] . "'))";
					$otherFilter[] = $this->_t(3) . ");";

					$otherFilter[] = PHP_EOL . $this->_t(3) . "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$otherFilter[] = $this->_t(3) . "{";
					$otherFilter[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " " . $CodeName . " Batch Selection";
					$otherFilter[] = $this->_t(4) . "JHtmlBatch_::addListSelection(";
					$otherFilter[] = $this->_t(5) . "'- Keep Original '.JText:" . ":_('" . $filter['lang'] . "').' -',";
					$otherFilter[] = $this->_t(5) . "'batch[" . $filter['code'] . "]',";
					$otherFilter[] = $this->_t(5) . "JHtml::_('select.options', \$this->" . $codeName . "Options, 'value', 'text')";
					$otherFilter[] = $this->_t(4) . ");";
					$otherFilter[] = $this->_t(3) . "}";

					$otherFilter[] = $this->_t(2) . "}";
				}
				elseif ($filter['type'] != 'category')
				{
					$Codename = ComponentbuilderHelper::safeString($filter['code'], 'W');
					if (isset($filter['custom']) && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] === 'user')
					{
						$functionName = "\$this->getThe" . $filter['function'] . ComponentbuilderHelper::safeString($filter['custom']['text'], 'F') . "Selections();";
					}
					else
					{
						$functionName = "\$this->getThe" . $filter['function'] . "Selections();";
					}
					$otherFilter[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Set " . $Codename . " Selection";
					$otherFilter[] = $this->_t(2) . "\$this->" . $filter['code'] . "Options = " . $functionName;
					$otherFilter[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " We do some sanitation for " . $Codename . " filter";
					$otherFilter[] = $this->_t(2) . "if (" . $Component . "Helper::checkArray(\$this->" . $filter['code'] . "Options) &&";
					$otherFilter[] = $this->_t(3) . "isset(\$this->" . $filter['code'] . "Options[0]->value) &&";
					$otherFilter[] = $this->_t(3) . "!" . $Component . "Helper::checkString(\$this->" . $filter['code'] . "Options[0]->value))";
					$otherFilter[] = $this->_t(2) . "{";
					$otherFilter[] = $this->_t(3) . "unset(\$this->" . $filter['code'] . "Options[0]);";
					$otherFilter[] = $this->_t(2) . "}";
					$otherFilter[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Only load " . $Codename . " filter if it has values";
					$otherFilter[] = $this->_t(2) . "if (" . $Component . "Helper::checkArray(\$this->" . $filter['code'] . "Options))";
					$otherFilter[] = $this->_t(2) . "{";
					$otherFilter[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " " . $Codename . " Filter";
					$otherFilter[] = $this->_t(3) . "JHtmlSidebar::addFilter(";
					$otherFilter[] = $this->_t(4) . "'- Select '.JText:" . ":_('" . $filter['lang'] . "').' -',";
					$otherFilter[] = $this->_t(4) . "'filter_" . $filter['code'] . "',";
					$otherFilter[] = $this->_t(4) . "JHtml::_('select.options', \$this->" . $filter['code'] . "Options, 'value', 'text', \$this->state->get('filter." . $filter['code'] . "'))";
					$otherFilter[] = $this->_t(3) . ");";

					$otherFilter[] = PHP_EOL . $this->_t(3) . "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$otherFilter[] = $this->_t(3) . "{";
					$otherFilter[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " " . $Codename . " Batch Selection";
					$otherFilter[] = $this->_t(4) . "JHtmlBatch_::addListSelection(";
					$otherFilter[] = $this->_t(5) . "'- Keep Original '.JText:" . ":_('" . $filter['lang'] . "').' -',";
					$otherFilter[] = $this->_t(5) . "'batch[" . $filter['code'] . "]',";
					$otherFilter[] = $this->_t(5) . "JHtml::_('select.options', \$this->" . $filter['code'] . "Options, 'value', 'text')";
					$otherFilter[] = $this->_t(4) . ");";
					$otherFilter[] = $this->_t(3) . "}";

					$otherFilter[] = $this->_t(2) . "}";
				}
			}
			if (ComponentbuilderHelper::checkArray($otherFilter))
			{
				// return the filter
				return PHP_EOL . implode(PHP_EOL, $otherFilter);
			}
		}
		return '';
	}

	public function setCategoryFilter($viewName_list)
	{
		if (isset($this->categoryBuilder[$viewName_list])
			&& ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])
			&& isset($this->categoryBuilder[$viewName_list]['extension']))
		{
			// set component name
			$COPMONENT = ComponentbuilderHelper::safeString($this->componentData->name_code, 'U');
			// set filter
			$filter = array();
			$filter[] = PHP_EOL . PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Category Filter.";
			$filter[] = $this->_t(2) . "JHtmlSidebar::addFilter(";
			$filter[] = $this->_t(3) . "JText:" . ":_('JOPTION_SELECT_CATEGORY'),";
			$filter[] = $this->_t(3) . "'filter_category_id',";
			$filter[] = $this->_t(3) . "JHtml::_('select.options', JHtml::_('category.options', '" . $this->categoryBuilder[$viewName_list]['extension'] . "'), 'value', 'text', \$this->state->get('filter.category_id'))";
			$filter[] = $this->_t(2) . ");";


			$filter[] = PHP_EOL . $this->_t(2) . "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
			$filter[] = $this->_t(2) . "{";
			$filter[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Category Batch selection.";
			$filter[] = $this->_t(3) . "JHtmlBatch_::addListSelection(";
			$filter[] = $this->_t(4) . "JText:" . ":_('COM_" . $COPMONENT . "_KEEP_ORIGINAL_CATEGORY'),";
			$filter[] = $this->_t(4) . "'batch[category]',";
			$filter[] = $this->_t(4) . "JHtml::_('select.options', JHtml::_('category.options', '" . $this->categoryBuilder[$viewName_list]['extension'] . "'), 'value', 'text')";
			$filter[] = $this->_t(3) . ");";
			$filter[] = $this->_t(2) . "}";

			// return the filter
			return implode(PHP_EOL, $filter);
		}
		return '';
	}

	public function setRouterCategoryViews($viewName_single, $viewName_list)
	{
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			// get the actual extention
			$_extension = $this->categoryBuilder[$viewName_list]['extension'];
			$_extension = explode('.', $_extension);
			// set component name
			if (ComponentbuilderHelper::checkArray($_extension))
			{
				$component = str_replace('com_', '', $_extension[0]);
			}
			else
			{
				$component = $this->componentCodeName;
			}
			// check if category has another name
			if (isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// load the category helper details in not already loaded
			if (!isset($this->fileContentDynamic['category' . $otherViews][$this->hhh . 'view' . $this->hhh]))
			{
				// lets also set the category helper for this view
				$target = array('site' => 'category' . $viewName_list);
				$this->buildDynamique($target, 'category');
				// insure the file gets updated
				$this->fileContentDynamic['category' . $otherViews][$this->hhh . 'view' . $this->hhh] = $otherView;
				$this->fileContentDynamic['category' . $otherViews][$this->hhh . 'View' . $this->hhh] = ucfirst($otherView);
				$this->fileContentDynamic['category' . $otherViews][$this->hhh . 'views' . $this->hhh] = $otherViews;
				$this->fileContentDynamic['category' . $otherViews][$this->hhh . 'Views' . $this->hhh] = ucfirst($otherViews);
				// set script to global helper file
				$includeHelper = array();
				$includeHelper[] = "\n//" . $this->setLine(__LINE__) . "Insure this view category file is loaded.";
				$includeHelper[] = "\$classname = '" . ucfirst( $component ) . ucfirst($viewName_list) . "Categories';";
				$includeHelper[] = "if (!class_exists(\$classname))";
				$includeHelper[] = "{";
				$includeHelper[] = $this->_t(1) . "\$path = JPATH_SITE . '/components/com_" . $component . "/helpers/category" . $viewName_list . ".php';";
				$includeHelper[] = $this->_t(1) . "if (is_file(\$path))";
				$includeHelper[] = $this->_t(1) . "{";
				$includeHelper[] = $this->_t(2) . "include_once \$path;";
				$includeHelper[] = $this->_t(1) . "}";
				$includeHelper[] = "}";
				$this->fileContentStatic[$this->hhh . 'CATEGORY_CLASS_TREES' . $this->hhh] .= implode("\n", $includeHelper);
			}
			// return category view string
			if (isset($this->fileContentStatic[$this->hhh . 'ROUTER_CATEGORY_VIEWS' . $this->hhh]) && ComponentbuilderHelper::checkString($this->fileContentStatic[$this->hhh . 'ROUTER_CATEGORY_VIEWS' . $this->hhh]))
			{
				return "," . PHP_EOL . $this->_t(3) . '"' . $this->categoryBuilder[$viewName_list]['extension'] . '" => "' . $otherView . '"';
			}
			else
			{
				return PHP_EOL . $this->_t(3) . '"' . $this->categoryBuilder[$viewName_list]['extension'] . '" => "' . $otherView . '"';
			}
		}
		return '';
	}

	public function setJcontrollerAllowAdd($viewName_single, $viewName_list)
	{
		$allow = array();
		// set component name
		$component = $this->componentCodeName;
		// prepare custom permission script
		$customAllow = $this->getCustomScriptBuilder('php_allowadd', $viewName_single, '', null, true);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if item has category
		if (0) //isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])) <-- remove category from check
		{
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " get the user object";
			$allow[] = $this->_t(2) . "\$user = JFactory::getUser();";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($otherView, $this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Access check.";
				$allow[] = $this->_t(2) . "\$access = \$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "');";
				$allow[] = $this->_t(2) . "if (!\$access)";
				$allow[] = $this->_t(2) . "{";
				$allow[] = $this->_t(3) . "return false;";
				$allow[] = $this->_t(2) . "}";
			}
			$allow[] = $this->_t(2) . "\$categoryId = JArrayHelper::getValue(\$data, 'catid', \$this->input->getInt('filter_category_id'), 'int');";
			$allow[] = $this->_t(2) . "\$allow = null;";
			$allow[] = PHP_EOL . $this->_t(2) . "if (\$categoryId)";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " If the category has been passed in the URL check it.";
			$allow[] = $this->_t(3) . "\$allow = \$user->authorise('core.create', \$this->option . '." . $otherViews . ".category.' . \$categoryId);";
			$allow[] = $this->_t(2) . "}";
			$allow[] = PHP_EOL . $this->_t(2) . "if (\$allow === null)";
			$allow[] = $this->_t(2) . "{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.create']]))
			{
				// setup the default script
				$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(3) . "return \$user->authorise('" . $core['core.create'] . "', \$this->option);";
			}
			else
			{
				// setup the default script
				$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(3) . "return parent::allowAdd(\$data);";
			}
			$allow[] = $this->_t(2) . "}";
			$allow[] = $this->_t(2) . "else";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "return \$allow;";
			$allow[] = $this->_t(2) . "}";
		}
		else
		{
			$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get user object.";
			$allow[] = $this->_t(2) . "\$user = JFactory::getUser();";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Access check.";
				$allow[] = $this->_t(2) . "\$access = \$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "');";
				$allow[] = $this->_t(2) . "if (!\$access)";
				$allow[] = $this->_t(2) . "{";
				$allow[] = $this->_t(3) . "return false;";
				$allow[] = $this->_t(2) . "}";
			}
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.create']]))
			{
				// setup the default script
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return \$user->authorise('" . $core['core.create'] . "', \$this->option);";
			}
			else
			{
				// setup the default script
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return parent::allowAdd(\$data);";
			}
		}
		return implode(PHP_EOL, $allow);
	}

	public function setJcontrollerAllowEdit($viewName_single, $viewName_list)
	{
		$allow = array();
		// set component name
		$component = $this->componentCodeName;
		// prepare custom permission script
		$customAllow = $this->getCustomScriptBuilder('php_allowedit', $viewName_single, '', null, true);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get user object.";
			$allow[] = $this->_t(2) . "\$user = JFactory::getUser();";
			$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get record id.";
			$allow[] = $this->_t(2) . "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($otherView, $this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Access check.";
				$allow[] = $this->_t(2) . "\$access = (\$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "." . $otherView . ".' . (int) \$recordId) && \$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "'));";
				$allow[] = $this->_t(2) . "if (!\$access)";
				$allow[] = $this->_t(2) . "{";
				$allow[] = $this->_t(3) . "return false;";
				$allow[] = $this->_t(2) . "}";
			}
			$allow[] = PHP_EOL . $this->_t(2) . "if (\$recordId)";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($otherView, $this->permissionBuilder[$core['core.edit']]))
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('" . $core['core.edit'] . "', 'com_" . $component . "." . $otherView . ".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('core.edit', 'com_" . $component . "." . $otherView . ".' . (int) \$recordId);";
			}
			$allow[] = $this->_t(3) . "if (!\$permission)";
			$allow[] = $this->_t(3) . "{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder[$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.own']]) && in_array($otherView, $this->permissionBuilder[$core['core.edit.own']]))
			{
				$allow[] = $this->_t(4) . "if (\$user->authorise('" . $core['core.edit.own'] . "', 'com_" . $component . "." . $otherView . ".' . \$recordId))";
			}
			else
			{
				$allow[] = $this->_t(4) . "if (\$user->authorise('core.edit.own', 'com_" . $component . "." . $otherView . ".' . \$recordId))";
			}
			$allow[] = $this->_t(4) . "{";
			$allow[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " Fallback on edit.own. Now test the owner is the user.";
			$allow[] = $this->_t(5) . "\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = $this->_t(5) . "if (empty(\$ownerId))";
			$allow[] = $this->_t(5) . "{";
			$allow[] = $this->_t(6) . "//" . $this->setLine(__LINE__) . " Need to do a lookup from the model.";
			$allow[] = $this->_t(6) . "\$record = \$this->getModel()->getItem(\$recordId);";
			$allow[] = PHP_EOL . $this->_t(6) . "if (empty(\$record))";
			$allow[] = $this->_t(6) . "{";
			$allow[] = $this->_t(7) . "return false;";
			$allow[] = $this->_t(6) . "}";
			$allow[] = $this->_t(6) . "\$ownerId = \$record->created_by;";
			$allow[] = $this->_t(5) . "}";
			$allow[] = PHP_EOL . $this->_t(5) . "//" . $this->setLine(__LINE__) . " If the owner matches 'me' then do the test.";
			$allow[] = $this->_t(5) . "if (\$ownerId == \$user->id)";
			$allow[] = $this->_t(5) . "{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder['global'][$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.own']]) && in_array($otherView, $this->permissionBuilder['global'][$core['core.edit.own']]))
			{
				$allow[] = $this->_t(6) . "if (\$user->authorise('" . $core['core.edit.own'] . "', 'com_" . $component . "'))";
			}
			else
			{
				$allow[] = $this->_t(6) . "if (\$user->authorise('core.edit.own', 'com_" . $component . "'))";
			}
			$allow[] = $this->_t(6) . "{";
			$allow[] = $this->_t(7) . "return true;";
			$allow[] = $this->_t(6) . "}";
			$allow[] = $this->_t(5) . "}";
			$allow[] = $this->_t(4) . "}";
			$allow[] = $this->_t(4) . "return false;";
			$allow[] = $this->_t(3) . "}";
//			$allow[] = PHP_EOL.$this->_t(3) . "\$categoryId = (int) isset(\$data['catid']) ? \$data['catid']: \$this->getModel()->getItem(\$recordId)->catid;";  <-- remove category from check
//			$allow[] = PHP_EOL.$this->_t(3) . "if (\$categoryId)";
//			$allow[] = $this->_t(3) . "{";
//			$allow[] = $this->_t(4) . "//".$this->setLine(__LINE__)." The category has been set. Check the category permissions.";
//			$allow[] = $this->_t(4) . "\$catpermission = \$user->authorise('core.edit', \$this->option . '.".$otherView.".category.' . \$categoryId);";
//			$allow[] = $this->_t(4) . "if (!\$catpermission && !is_null(\$catpermission))";
//			$allow[] = $this->_t(4) . "{";
//			$allow[] = $this->_t(5) . "return false;";
//			$allow[] = $this->_t(4) . "}";
//			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(2) . "}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($otherView, $this->permissionBuilder['global'][$core['core.edit']]))
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Since there is no permission, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return \$user->authorise('" . $core['core.edit'] . "', \$this->option);";
			}
			else
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Since there is no permission, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return parent::allowEdit(\$data, \$key);";
			}
		}
		else
		{
			// setup the category script
			$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " get user object.";
			$allow[] = $this->_t(2) . "\$user = JFactory::getUser();";
			$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " get record id.";
			$allow[] = $this->_t(2) . "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder[$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.access']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.access']]))
			{
				$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Access check.";
				$allow[] = $this->_t(2) . "\$access = (\$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$recordId) &&  \$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "'));";
				$allow[] = $this->_t(2) . "if (!\$access)";
				$allow[] = $this->_t(2) . "{";
				$allow[] = $this->_t(3) . "return false;";
				$allow[] = $this->_t(2) . "}";
			}
			$allow[] = PHP_EOL . $this->_t(2) . "if (\$recordId)";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit']]))
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('" . $core['core.edit'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('core.edit', 'com_" . $component . "." . $viewName_single . ".' . (int) \$recordId);";
			}
			$allow[] = $this->_t(3) . "if (!\$permission)";
			$allow[] = $this->_t(3) . "{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder[$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.own']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.own']]))
			{
				$allow[] = $this->_t(4) . "if (\$user->authorise('" . $core['core.edit.own'] . "', 'com_" . $component . "." . $viewName_single . ".' . \$recordId))";
			}
			else
			{
				$allow[] = $this->_t(4) . "if (\$user->authorise('core.edit.own', 'com_" . $component . "." . $viewName_single . ".' . \$recordId))";
			}
			$allow[] = $this->_t(4) . "{";
			$allow[] = $this->_t(5) . "//" . $this->setLine(__LINE__) . " Now test the owner is the user.";
			$allow[] = $this->_t(5) . "\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = $this->_t(5) . "if (empty(\$ownerId))";
			$allow[] = $this->_t(5) . "{";
			$allow[] = $this->_t(6) . "//" . $this->setLine(__LINE__) . " Need to do a lookup from the model.";
			$allow[] = $this->_t(6) . "\$record = \$this->getModel()->getItem(\$recordId);";
			$allow[] = PHP_EOL . $this->_t(6) . "if (empty(\$record))";
			$allow[] = $this->_t(6) . "{";
			$allow[] = $this->_t(7) . "return false;";
			$allow[] = $this->_t(6) . "}";
			$allow[] = $this->_t(6) . "\$ownerId = \$record->created_by;";
			$allow[] = $this->_t(5) . "}";
			$allow[] = PHP_EOL . $this->_t(5) . "//" . $this->setLine(__LINE__) . " If the owner matches 'me' then allow.";
			$allow[] = $this->_t(5) . "if (\$ownerId == \$user->id)";
			$allow[] = $this->_t(5) . "{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder['global'][$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.own']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit.own']]))
			{
				$allow[] = $this->_t(6) . "if (\$user->authorise('" . $core['core.edit.own'] . "', 'com_" . $component . "'))";
			}
			else
			{
				$allow[] = $this->_t(6) . "if (\$user->authorise('core.edit.own', 'com_" . $component . "'))";
			}
			$allow[] = $this->_t(6) . "{";
			$allow[] = $this->_t(7) . "return true;";
			$allow[] = $this->_t(6) . "}";
			$allow[] = $this->_t(5) . "}";
			$allow[] = $this->_t(4) . "}";
			$allow[] = $this->_t(4) . "return false;";
			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(2) . "}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit']]))
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Since there is no permission, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return \$user->authorise('" . $core['core.edit'] . "', \$this->option);";
			}
			else
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Since there is no permission, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return parent::allowEdit(\$data, \$key);";
			}
		}

		return implode(PHP_EOL, $allow);
	}

	public function setJmodelAdminGetForm($viewName_single, $viewName_list)
	{
		// set component name
		$component = $this->componentCodeName;
		// allways load these
		$getForm = array();
		$getForm[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if xpath was set in options";
		$getForm[] = $this->_t(2) . "\$xpath = false;";
		$getForm[] = $this->_t(2) . "if (isset(\$options['xpath']))";
		$getForm[] = $this->_t(2) . "{";
		$getForm[] = $this->_t(3) . "\$xpath = \$options['xpath'];";
		$getForm[] = $this->_t(3) . "unset(\$options['xpath']);";
		$getForm[] = $this->_t(2) . "}";
		$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " check if clear form was set in options";
		$getForm[] = $this->_t(2) . "\$clear = false;";
		$getForm[] = $this->_t(2) . "if (isset(\$options['clear']))";
		$getForm[] = $this->_t(2) . "{";
		$getForm[] = $this->_t(3) . "\$clear = \$options['clear'];";
		$getForm[] = $this->_t(3) . "unset(\$options['clear']);";
		$getForm[] = $this->_t(2) . "}";
		$getForm[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the form.";
		$getForm[] = $this->_t(2) . "\$form = \$this->loadForm('com_" . $component . "." . $viewName_single . "', '" . $viewName_single . "', \$options, \$clear, \$xpath);";
		$getForm[] = PHP_EOL . $this->_t(2) . "if (empty(\$form))";
		$getForm[] = $this->_t(2) . "{";
		$getForm[] = $this->_t(3) . "return false;";
		$getForm[] = $this->_t(2) . "}";
		// load license locker
		if ($this->componentData->add_license && $this->componentData->license_type == 3 && isset($this->fileContentDynamic[$viewName_single][$this->hhh . 'BOOLMETHOD' . $this->hhh]))
		{
			$getForm[] = $this->checkStatmentLicenseLocked($this->fileContentDynamic[$viewName_single][$this->hhh . 'BOOLMETHOD' . $this->hhh]);
		}
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if (0) //isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))  <-- remove category from check
		{
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$getForm[] = PHP_EOL . $this->_t(2) . "\$jinput = JFactory::getApplication()->input;";
			$getForm[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$getForm[] = $this->_t(2) . "if (\$jinput->get('a_id'))";
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "\$id = \$jinput->get('a_id', 0, 'INT');";
			$getForm[] = $this->_t(2) . "}";
			$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$getForm[] = $this->_t(2) . "else";
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "\$id = \$jinput->get('id', 0, 'INT');";
			$getForm[] = $this->_t(2) . "}";
			$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Determine correct permissions to check.";
			$getForm[] = $this->_t(2) . "if (\$this->getState('" . $viewName_single . ".id'))";
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "\$id = \$this->getState('" . $viewName_single . ".id');";
			$getForm[] = PHP_EOL . $this->_t(3) . "\$catid = 0;";
			$getForm[] = $this->_t(3) . "if (isset(\$this->getItem(\$id)->catid))";
			$getForm[] = $this->_t(3) . "{";
			$getForm[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " set category id";
			$getForm[] = $this->_t(4) . "\$catid = \$this->getItem(\$id)->catid;";
			$getForm[] = PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Existing record. Can only edit in selected categories.";
			$getForm[] = $this->_t(4) . "\$form->setFieldAttribute('catid', 'action', 'core.edit');";
			$getForm[] = PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Existing record. Can only edit own items in selected categories.";
			$getForm[] = $this->_t(4) . "\$form->setFieldAttribute('catid', 'action', 'core.edit.own');";
			$getForm[] = $this->_t(3) . "}";
			$getForm[] = $this->_t(2) . "}";
			$getForm[] = $this->_t(2) . "else";
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " New record. Can only create in selected categories.";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('catid', 'action', 'core.create');";
			$getForm[] = $this->_t(2) . "}";
			$getForm[] = PHP_EOL . $this->_t(2) . "\$user = JFactory::getUser();";
			$getForm[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check for existing item.";
			$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on Edit State access controls.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.state']]))
			{
				$getForm[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
				$getForm[] = $this->_t(3) . "|| (isset(\$catid) && \$catid != 0 && !\$user->authorise('core.edit.state', 'com_" . $component . "." . $viewName_list . ".category.' . (int) \$catid))";
				$getForm[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "')))";
			}
			else
			{
				$getForm[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('core.edit.state', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
				$getForm[] = $this->_t(3) . "|| (isset(\$catid) && \$catid != 0 && !\$user->authorise('core.edit.state', 'com_" . $component . "." . $viewName_list . ".category.' . (int) \$catid))";
				$getForm[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('core.edit.state', 'com_" . $component . "')))";
			}
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('published', 'disabled', 'true');";
			$getForm[] = PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('published', 'filter', 'unset');";
			$getForm[] = $this->_t(2) . "}";
		}
		else
		{
			$getForm[] = PHP_EOL . $this->_t(2) . "\$jinput = JFactory::getApplication()->input;";
			$getForm[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$getForm[] = $this->_t(2) . "if (\$jinput->get('a_id'))";
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "\$id = \$jinput->get('a_id', 0, 'INT');";
			$getForm[] = $this->_t(2) . "}";
			$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$getForm[] = $this->_t(2) . "else";
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "\$id = \$jinput->get('id', 0, 'INT');";
			$getForm[] = $this->_t(2) . "}";
			$getForm[] = PHP_EOL . $this->_t(2) . "\$user = JFactory::getUser();";
			$getForm[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check for existing item.";
			$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on Edit State access controls.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.state']]))
			{
				$getForm[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
				$getForm[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "')))";
			}
			else
			{
				$getForm[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('core.edit.state', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
				$getForm[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('core.edit.state', 'com_" . $component . "')))";
			}
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('published', 'disabled', 'true');";
			$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('published', 'filter', 'unset');";
			$getForm[] = $this->_t(2) . "}";
		}
		$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " If this is a new item insure the greated by is set.";
		$getForm[] = $this->_t(2) . "if (0 == \$id)";
		$getForm[] = $this->_t(2) . "{";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set the created_by to this user";
		$getForm[] = $this->_t(3) . "\$form->setValue('created_by', null, \$user->id);";
		$getForm[] = $this->_t(2) . "}";
		$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on Edit Creaded By access controls.";
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit.created_by']) && isset($this->permissionBuilder[$core['core.edit.created_by']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.created_by']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.created_by']]))
		{
			$getForm[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $core['core.edit.created_by'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
			$getForm[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $core['core.edit.created_by'] . "', 'com_" . $component . "')))";
		}
		else
		{
			$getForm[] = $this->_t(2) . "if (!\$user->authorise('core.edit.created_by', 'com_" . $component . "'))";
		}
		$getForm[] = $this->_t(2) . "{";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
		$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('created_by', 'disabled', 'true');";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
		$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('created_by', 'readonly', 'true');";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
		$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('created_by', 'filter', 'unset');";
		$getForm[] = $this->_t(2) . "}";
		$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on Edit Creaded Date access controls.";
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit.created']) && isset($this->permissionBuilder[$core['core.edit.created']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.created']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.created']]))
		{
			$getForm[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $core['core.edit.created'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
			$getForm[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $core['core.edit.created'] . "', 'com_" . $component . "')))";
		}
		else
		{
			$getForm[] = $this->_t(2) . "if (!\$user->authorise('core.edit.created', 'com_" . $component . "'))";
		}
		$getForm[] = $this->_t(2) . "{";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
		$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('created', 'disabled', 'true');";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
		$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('created', 'filter', 'unset');";
		$getForm[] = $this->_t(2) . "}";
		// check if the item has access permissions.
		if ($coreLoad && isset($core['core.edit.access']) && isset($this->permissionBuilder[$core['core.edit.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.access']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.access']]))
		{
			$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on Edit Access 'access' controls.";
			$getForm[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $core['core.edit.access'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
			$getForm[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $core['core.edit.access'] . "', 'com_" . $component . "')))";
			$getForm[] = $this->_t(2) . "{";
			$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('access', 'disabled', 'true');";
			$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
			$getForm[] = $this->_t(3) . "\$form->setFieldAttribute('access', 'filter', 'unset');";
			$getForm[] = $this->_t(2) . "}";
		}
		// handel the fields permissions
		if (isset($this->permissionFields[$viewName_single]) && ComponentbuilderHelper::checkArray($this->permissionFields[$viewName_single]))
		{
			foreach ($this->permissionFields[$viewName_single] as $fieldName => $permission_options)
			{
				foreach($permission_options as $permission_option => $fieldType)
				{
					switch ($permission_option)
					{
						case 'edit':
							$this->setPermissionEditFields($getForm, $viewName_single, $fieldName, $fieldType, $component);
						break;
						case 'access':
							$this->setPermissionAccessFields($getForm, $viewName_single, $fieldName, $fieldType, $component);
						break;
						case 'view':
							$this->setPermissionViewFields($getForm, $viewName_single, $fieldName, $fieldType, $component);
						break;
						case 'edit.own':
						case 'access.own':
							// this must still be build (TODO)
						break;
					}
				}
			}
		}
		// add the redirect trick to set the field of origin
		$getForm[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Only load these values if no id is found";
		$getForm[] = $this->_t(2) . "if (0 == \$id)";
		$getForm[] = $this->_t(2) . "{";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set redirected view name";
		$getForm[] = $this->_t(3) . "\$redirectedView = \$jinput->get('ref', null, 'STRING');";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set field name (or fall back to view name)";
		$getForm[] = $this->_t(3) . "\$redirectedField = \$jinput->get('field', \$redirectedView, 'STRING');";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set redirected view id";
		$getForm[] = $this->_t(3) . "\$redirectedId = \$jinput->get('refid', 0, 'INT');";
		$getForm[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Set field id (or fall back to redirected view id)";
		$getForm[] = $this->_t(3) . "\$redirectedValue = \$jinput->get('field_id', \$redirectedId, 'INT');";
		$getForm[] = $this->_t(3) . "if (0 != \$redirectedValue && \$redirectedField)";
		$getForm[] = $this->_t(3) . "{";
		$getForm[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Now set the local-redirected field default value";
		$getForm[] = $this->_t(4) . "\$form->setValue(\$redirectedField, null, \$redirectedValue);";
		$getForm[] = $this->_t(3) . "}";
		// load custom script if found
		$getForm[] = $this->_t(2) . "}" . $this->getCustomScriptBuilder('php_getform', $viewName_single, PHP_EOL);
		// setup the default script
		$getForm[] = $this->_t(2) . "return \$form;";

		return implode(PHP_EOL, $getForm);
	}
	
	protected function setPermissionEditFields(&$allow, $viewName_single, $fieldName, $fieldType, $component)
	{
		// only for fields that can be edited
		if (!ComponentbuilderHelper::fieldCheck($fieldType, 'spacer'))
		{
			$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on Edit " . ComponentbuilderHelper::safeString($fieldName, 'W') . " access controls.";
			$allow[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $viewName_single . ".edit." . $fieldName . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
			$allow[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $viewName_single . ".edit." . $fieldName . "', 'com_" . $component . "')))";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
			$allow[] = $this->_t(3) . "\$form->setFieldAttribute('" . $fieldName . "', 'disabled', 'true');";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable fields for display.";
			$allow[] = $this->_t(3) . "\$form->setFieldAttribute('" . $fieldName . "', 'readonly', 'true');";
			if ('radio' === $fieldType || 'repeatable' === $fieldType)
			{
				$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Disable radio button for display.";
				$allow[] = $this->_t(3) . "\$class = \$form->getFieldAttribute('" . $fieldName . "', 'class', '');";
				$allow[] = $this->_t(3) . "\$form->setFieldAttribute('" . $fieldName . "', 'class', \$class.' disabled no-click');";
			}
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " If there is no value continue.";
			$allow[] = $this->_t(3) . "if (!\$form->getValue('" . $fieldName . "'))";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
			$allow[] = $this->_t(4) . "\$form->setFieldAttribute('" . $fieldName . "', 'filter', 'unset');";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
			$allow[] = $this->_t(4) . "\$form->setFieldAttribute('" . $fieldName . "', 'required', 'false');";
			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(2) . "}";
		}
	}
	
	protected function setPermissionAccessFields(&$allow, $viewName_single, $fieldName, $fieldType, $component)
	{
		$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the from the form based on " . ComponentbuilderHelper::safeString($fieldName, 'W') . " access controls.";
		$allow[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $viewName_single . ".access." . $fieldName . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
		$allow[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $viewName_single . ".access." . $fieldName . "', 'com_" . $component . "')))";
		$allow[] = $this->_t(2) . "{";
		$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove the field";
		$allow[] = $this->_t(3) . "\$form->removeField('" . $fieldName . "');";
		$allow[] = $this->_t(2) . "}";
	}
	
	protected function setPermissionViewFields(&$allow, $viewName_single, $fieldName, $fieldType, $component)
	{
		if (ComponentbuilderHelper::fieldCheck($fieldType, 'spacer'))
		{
			$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on View " . ComponentbuilderHelper::safeString($fieldName, 'W') . " access controls.";
			$allow[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $viewName_single . ".view." . $fieldName . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
			$allow[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $viewName_single . ".view." . $fieldName . "', 'com_" . $component . "')))";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove the field";
			$allow[] = $this->_t(3) . "\$form->removeField('" . $fieldName . "');";
			$allow[] = $this->_t(2) . "}";
		}
		else
		{
			$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Modify the form based on View " . ComponentbuilderHelper::safeString($fieldName, 'W') . " access controls.";
			$allow[] = $this->_t(2) . "if (\$id != 0 && (!\$user->authorise('" . $viewName_single . ".view." . $fieldName . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$id))";
			$allow[] = $this->_t(3) . "|| (\$id == 0 && !\$user->authorise('" . $viewName_single . ".view." . $fieldName . "', 'com_" . $component . "')))";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " Make the field hidded.";
			$allow[] = $this->_t(3) . "\$form->setFieldAttribute('" . $fieldName . "', 'type', 'hidden');";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " If there is no value continue.";
			$allow[] = $this->_t(3) . "if (!(\$val = \$form->getValue('" . $fieldName . "')))";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
			$allow[] = $this->_t(4) . "\$form->setFieldAttribute('" . $fieldName . "', 'filter', 'unset');";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Disable fields while saving.";
			$allow[] = $this->_t(4) . "\$form->setFieldAttribute('" . $fieldName . "', 'required', 'false');";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Make sure";
			$allow[] = $this->_t(4) . "\$form->setValue('" . $fieldName . "', null, '');";
			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(3) . "elseif (" . ucfirst($component) . "Helper::checkArray(\$val))";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " We have to unset then (TODO)";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Hiddend field can not handel array value";
			$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " Even if we convert to json we get an error";
			$allow[] = $this->_t(4) . "\$form->removeField('" . $fieldName . "');";
			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(2) . "}";
		}
	}

	public function setJmodelAdminAllowEdit($viewName_single, $viewName_list)
	{
		$allow = array();
		// set component name
		$component = $this->componentCodeName;
		// prepare custom permission script
		$customAllow = $this->getCustomScriptBuilder('php_allowedit', $viewName_single, $this->_t(2) . "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;" . PHP_EOL);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit']]))
		{
			$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check specific edit permission then general edit permission.";
			$allow[] = $this->_t(2) . "\$user = JFactory::getUser();";
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = $this->_t(2) . "return \$user->authorise('" . $core['core.edit'] . "', 'com_" . $component . "." . $viewName_single . ".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or \$user->authorise('" . $core['core.edit'] . "',  'com_" . $component . "');";
		}
		else
		{
			$allow[] = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check specific edit permission then general edit permission.";
			if (ComponentbuilderHelper::checkString($customAllow))
			{
				$allow[] = $this->_t(2) . "\$user = JFactory::getUser();";
			}
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = $this->_t(2) . "return JFactory::getUser()->authorise('core.edit', 'com_" . $component . "." . $viewName_single . ".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or parent::allowEdit(\$data, \$key);";
		}

		return implode(PHP_EOL, $allow);
	}

	public function setJmodelAdminCanDelete($viewName_single, $viewName_list)
	{
		$allow = array();
		// set component name
		$component = $this->componentCodeName;
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if (0) //isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))  <-- remove category from check
		{
			// check if category has another name
			if ($coreLoad && isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			// setup the category script
			$allow[] = PHP_EOL . $this->_t(2) . "if (!empty(\$record->id))";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "if (\$record->published != -2)";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "return;";
			$allow[] = $this->_t(3) . "}";
			$allow[] = PHP_EOL . $this->_t(3) . "\$user = JFactory::getUser();";
			$allow[] = $this->_t(3) . "\$allow = \$user->authorise('core.delete', 'com_" . $component . "." . $otherViews . ".category.' . (int) \$record->catid);";
			// check if the item has permissions.
			if ($coreLoad && isset($this->permissionBuilder[$core['core.delete']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.delete']]) && in_array($otherView, $this->permissionBuilder[$core['core.delete']]))
			{
				$allow[] = PHP_EOL . $this->_t(3) . "if (\$allow)";
				$allow[] = $this->_t(3) . "{";
				$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
				$allow[] = $this->_t(4) . "return \$user->authorise('" . $core['core.delete'] . "', 'com_" . $component . "." . $otherView . ".' . (int) \$record->id);";
				$allow[] = $this->_t(3) . "}";
			}
			else
			{
				$allow[] = PHP_EOL . $this->_t(3) . "if (\$allow)";
				$allow[] = $this->_t(3) . "{";
				$allow[] = $this->_t(4) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
				$allow[] = $this->_t(4) . "return \$user->authorise('core.delete', 'com_" . $component . "." . $otherView . ".' . (int) \$record->id);";
				$allow[] = $this->_t(3) . "}";
			}
			$allow[] = $this->_t(3) . "return \$allow;";
			$allow[] = $this->_t(2) . "}";
			$allow[] = $this->_t(2) . "return false;";
		}
		else
		{
			// setup the default script
			$allow[] = PHP_EOL . $this->_t(2) . "if (!empty(\$record->id))";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "if (\$record->published != -2)";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "return;";
			$allow[] = $this->_t(3) . "}";
			// check if the item has permissions.
			if ($coreLoad && (isset($core['core.delete']) && isset($this->permissionBuilder[$core['core.delete']])) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.delete']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.delete']]))
			{
				$allow[] = PHP_EOL . $this->_t(3) . "\$user = JFactory::getUser();";
				$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
				$allow[] = $this->_t(3) . "return \$user->authorise('" . $core['core.delete'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$record->id);";
			}
			else
			{
				$allow[] = PHP_EOL . $this->_t(3) . "\$user = JFactory::getUser();";
				$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
				$allow[] = $this->_t(3) . "return \$user->authorise('core.delete', 'com_" . $component . "." . $viewName_single . ".' . (int) \$record->id);";
			}
			$allow[] = $this->_t(2) . "}";
			$allow[] = $this->_t(2) . "return false;";
		}

		return implode(PHP_EOL, $allow);
	}

	public function setJmodelAdminCanEditState($viewName_single, $viewName_list)
	{
		$allow = array();
		// set component name
		$component = $this->componentCodeName;
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if (0) // isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))  <-- remove category from check
		{
			// check if category has another name
			if (isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
				$otherView = $this->catOtherName[$viewName_list]['view'];
			}
			else
			{
				$otherViews = $viewName_list;
				$otherView = $viewName_single;
			}
			$allow[] = PHP_EOL . $this->_t(2) . "\$user = JFactory::getUser();";
			$allow[] = $this->_t(2) . "\$recordId = (!empty(\$record->id)) ? \$record->id : 0;";
			$allow[] = PHP_EOL . $this->_t(2) . "if (\$recordId)";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('core.edit.state', 'com_" . $component . "." . $viewName_single . ".' . (int) \$recordId);";
			}
			$allow[] = $this->_t(3) . "if (!\$permission && !is_null(\$permission))";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "return false;";
			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(2) . "}";
			// setup the category script
			$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " Check against the category.";
			$allow[] = $this->_t(2) . "if (!empty(\$record->catid))";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "\$catpermission = \$user->authorise('core.edit.state', 'com_" . $component . "." . $otherViews . ".category.' . (int) \$record->catid);";
			$allow[] = $this->_t(3) . "if (!\$catpermission && !is_null(\$catpermission))";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "return false;";
			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(2) . "}";
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return \$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "');";
			}
			else
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return parent::canEditState(\$record);";
			}
		}
		else
		{
			// setup the default script
			$allow[] = PHP_EOL . $this->_t(2) . "\$user = JFactory::getUser();";
			$allow[] = $this->_t(2) . "\$recordId = (!empty(\$record->id)) ? \$record->id : 0;";
			$allow[] = PHP_EOL . $this->_t(2) . "if (\$recordId)";
			$allow[] = $this->_t(2) . "{";
			$allow[] = $this->_t(3) . "//" . $this->setLine(__LINE__) . " The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = $this->_t(3) . "\$permission = \$user->authorise('core.edit.state', 'com_" . $component . "." . $viewName_single . ".' . (int) \$recordId);";
			}
			$allow[] = $this->_t(3) . "if (!\$permission && !is_null(\$permission))";
			$allow[] = $this->_t(3) . "{";
			$allow[] = $this->_t(4) . "return false;";
			$allow[] = $this->_t(3) . "}";
			$allow[] = $this->_t(2) . "}";
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit.state']]))
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return \$user->authorise('" . $core['core.edit.state'] . "', 'com_" . $component . "');";
			}
			else
			{
				$allow[] = $this->_t(2) . "//" . $this->setLine(__LINE__) . " In the absense of better information, revert to the component permissions.";
				$allow[] = $this->_t(2) . "return parent::canEditState(\$record);";
			}
		}
		return implode(PHP_EOL, $allow);
	}

	public function setJviewListCanDo($viewName_single, $viewName_list)
	{
		$allow = array();
		// set component name
		$component = $this->componentCodeName;
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if the item has permissions for edit.
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit']]))
		{
			$allow[] = PHP_EOL . $this->_t(2) . "\$this->canEdit = \$this->canDo->get('" . $core['core.edit'] . "');";
		}
		else
		{
			$allow[] = PHP_EOL . $this->_t(2) . "\$this->canEdit = \$this->canDo->get('core.edit');";
		}
		// check if the item has permissions for edit state.
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$allow[] = $this->_t(2) . "\$this->canState = \$this->canDo->get('" . $core['core.edit.state'] . "');";
		}
		else
		{
			$allow[] = $this->_t(2) . "\$this->canState = \$this->canDo->get('core.edit.state');";
		}
		// check if the item has permissions for create.
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.create']]))
		{
			$allow[] = $this->_t(2) . "\$this->canCreate = \$this->canDo->get('" . $core['core.create'] . "');";
		}
		else
		{
			$allow[] = $this->_t(2) . "\$this->canCreate = \$this->canDo->get('core.create');";
		}
		// check if the item has permissions for delete.
		if ($coreLoad && isset($core['core.delete']) && isset($this->permissionBuilder['global'][$core['core.delete']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.delete']]) && in_array($viewName_single, $this->permissionBuilder['global'][$core['core.delete']]))
		{
			$allow[] = $this->_t(2) . "\$this->canDelete = \$this->canDo->get('" . $core['core.delete'] . "');";
		}
		else
		{
			$allow[] = $this->_t(2) . "\$this->canDelete = \$this->canDo->get('core.delete');";
		}
		// check if the item has permissions for batch.
		if ($coreLoad && isset($core['core.batch']) && isset($this->permissionBuilder['global']['global'][$core['core.batch']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global']['global'][$core['core.batch']]) && in_array($viewName_single, $this->permissionBuilder['global']['global'][$core['core.delete']]))
		{
			$allow[] = $this->_t(2) . "\$this->canBatch = (\$this->canDo->get('" . $core['core.batch'] . "') && \$this->canDo->get('core.batch'));";
		}
		else
		{
			$allow[] = $this->_t(2) . "\$this->canBatch = \$this->canDo->get('core.batch');";
		}

		return implode(PHP_EOL, $allow);
	}

	public function setFieldSetAccessControl(&$view)
	{
		$access = '';
		if ($view != 'component')
		{
			// set component name
			$component = $this->componentCodeName;
			// set label
			$label = 'Permissions in relation to this ' . $view;
			// set the access fieldset
			$access = "<!--" . $this->setLine(__LINE__) . " Access Control Fields. -->";
			$access .= PHP_EOL . $this->_t(1) . '<fieldset name="accesscontrol">';
			$access .= PHP_EOL . $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Asset Id Field. Type: Hidden (joomla) -->";
			$access .= PHP_EOL . $this->_t(2) . '<field';
			$access .= PHP_EOL . $this->_t(3) . 'name="asset_id"';
			$access .= PHP_EOL . $this->_t(3) . 'type="hidden"';
			$access .= PHP_EOL . $this->_t(3) . 'filter="unset"';
			$access .= PHP_EOL . $this->_t(2) . '/>';
			$access .= PHP_EOL . $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Rules Field. Type: Rules (joomla) -->";
			$access .= PHP_EOL . $this->_t(2) . '<field';
			$access .= PHP_EOL . $this->_t(3) . 'name="rules"';
			$access .= PHP_EOL . $this->_t(3) . 'type="rules"';
			$access .= PHP_EOL . $this->_t(3) . 'label="' . $label . '"';
			$access .= PHP_EOL . $this->_t(3) . 'translate_label="false"';
			$access .= PHP_EOL . $this->_t(3) . 'filter="rules"';
			$access .= PHP_EOL . $this->_t(3) . 'validate="rules"';
			$access .= PHP_EOL . $this->_t(3) . 'class="inputbox"';
			$access .= PHP_EOL . $this->_t(3) . 'component="com_' . $component . '"';
			$access .= PHP_EOL . $this->_t(3) . 'section="' . $view . '"';
			$access .= PHP_EOL . $this->_t(2) . '/>';
			$access .= PHP_EOL . $this->_t(1) . '</fieldset>';
		}
		// return access field set
		return $access;
	}

	public function setFilterFields(&$view)
	{
		// keep track of all fields already added
		$donelist = array('id', 'search', 'published', 'access', 'created_by', 'modified_by');
		// default filter fields
		$fields = "'a.id','id'";
		$fields .= "," . PHP_EOL . $this->_t(4) . "'a.published','published'";
		if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
		{
			$fields .= "," . PHP_EOL . $this->_t(4) . "'a.access','access'";
		}
		$fields .= "," . PHP_EOL . $this->_t(4) . "'a.ordering','ordering'";
		$fields .= "," . PHP_EOL . $this->_t(4) . "'a.created_by','created_by'";
		$fields .= "," . PHP_EOL . $this->_t(4) . "'a.modified_by','modified_by'";

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= "," . PHP_EOL . $this->_t(4) . "'c.title','category_title'";
						$fields .= "," . PHP_EOL . $this->_t(4) . "'c.id', 'category_id'";
						if ($filter['code'] != 'category')
						{
							$fields .= "," . PHP_EOL . $this->_t(4) . "'a." . $filter['code'] . "', '" . $filter['code'] . "'";
						}
					}
					else
					{
						// check if custom field is set
						/* if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$fields .= ",".PHP_EOL.$this->_t(4) . "'".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'";
						} */
						$fields .= "," . PHP_EOL . $this->_t(4) . "'a." . $filter['code'] . "','" . $filter['code'] . "'";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		// add the rest of the set filters
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= "," . PHP_EOL . $this->_t(4) . "'c.title','category_title'";
						$fields .= "," . PHP_EOL . $this->_t(4) . "'c.id', 'category_id'";
						if ($filter['code'] != 'category')
						{
							$fields .= "," . PHP_EOL . $this->_t(4) . "'a." . $filter['code'] . "', '" . $filter['code'] . "'";
						}
					}
					else
					{
						// check if custom field is set
						/* if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$fields .= ",".PHP_EOL.$this->_t(4) . "'".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'";
						} */
						$fields .= "," . PHP_EOL . $this->_t(4) . "'a." . $filter['code'] . "','" . $filter['code'] . "'";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		return $fields;
	}

	public function setStoredId(&$view)
	{
		// keep track of all fields already added
		$donelist = array('id', 'search', 'published', 'access', 'created_by', 'modified_by');
		// set the defaults first
		$stored = "//" . $this->setLine(__LINE__) . " Compile the store id.";
		$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.id');";
		$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.search');";
		$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.published');";
		if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
		{
			$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.access');";
		}
		$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.ordering');";
		$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.created_by');";
		$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.modified_by');";
		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.category');";
						$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.category_id');";
						if ($filter['code'] != 'category')
						{
							$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter." . $filter['code'] . "');";
						}
					}
					else
					{
						// check if custom field is set
						/* if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$stored .= PHP_EOL.$this->_t(2) . "\$id .= ':' . \$this->getState('filter.".$filter['code']."_".$filter['custom']['text']."');";
						} */
						$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter." . $filter['code'] . "');";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		// add the rest of the set filters
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.category');";
						$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.category_id');";
						if ($filter['code'] != 'category')
						{
							$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter." . $filter['code'] . "');";
						}
					}
					else
					{
						// check if custom field is set
						/* if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter.".$filter['code']."_".$filter['custom']['text']."');";
						} */
						$stored .= PHP_EOL . $this->_t(2) . "\$id .= ':' . \$this->getState('filter." . $filter['code'] . "');";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		return $stored;
	}

	public function setAddToolBar(&$view)
	{
		// set view name
		$viewName = ComponentbuilderHelper::safeString($view['settings']->name_single);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName]))
		{
			$core = $this->permissionCore[$viewName];
			$coreLoad = true;
		}
		// check type
		if ($view['settings']->type == 2)
		{
			// set lang strings
			$viewNameLang_readonly = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($view['settings']->name_single . ' readonly', 'U');
			// load to lang
			$this->setLangContent($this->lang, $viewNameLang_readonly, $view['settings']->name_single . ' :: Readonly');

			// build toolbar
			$toolBar = "JFactory::getApplication()->input->set('hidemainmenu', true);";
			$toolBar .= PHP_EOL . $this->_t(2) . "JToolBarHelper::title(JText:" . ":_('" . $viewNameLang_readonly . "'), '" . $viewName . "');";
			$toolBar .= PHP_EOL . $this->_t(2) . "JToolBarHelper::cancel('" . $viewName . ".cancel', 'JTOOLBAR_CLOSE');";
		}
		else
		{
			// set lang strings
			$viewNameLang_new = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($view['settings']->name_single . ' New', 'U');
			$viewNameLang_edit = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($view['settings']->name_single . ' Edit', 'U');
			// load to lang
			$this->setLangContent($this->lang, $viewNameLang_new, 'A New ' . $view['settings']->name_single);
			$this->setLangContent($this->lang, $viewNameLang_edit, 'Editing the ' . $view['settings']->name_single);
			// build toolbar
			$toolBar = "JFactory::getApplication()->input->set('hidemainmenu', true);";
			$toolBar .= PHP_EOL . $this->_t(2) . "\$user = JFactory::getUser();";
			$toolBar .= PHP_EOL . $this->_t(2) . "\$userId	= \$user->id;";
			$toolBar .= PHP_EOL . $this->_t(2) . "\$isNew = \$this->item->id == 0;";
			$toolBar .= PHP_EOL . PHP_EOL . $this->_t(2) . "JToolbarHelper::title( JText:" . ":_(\$isNew ? '" . $viewNameLang_new . "' : '" . $viewNameLang_edit . "'), 'pencil-2 article-add');";
			$toolBar .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Built the actions for new and existing records.";
			$toolBar .= PHP_EOL . $this->_t(2) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh]. "Helper::checkString(\$this->referral))";
			$toolBar .= PHP_EOL . $this->_t(2) . "{";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName, $this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL . $this->_t(3) . "if (\$this->canDo->get('" . $core['core.create'] . "') && \$isNew)";
			}
			else
			{
				$toolBar .= PHP_EOL . $this->_t(3) . "if (\$this->canDo->get('core.create') && \$isNew)";
			}
			$toolBar .= PHP_EOL . $this->_t(3) . "{";
			$toolBar .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " We can create the record.";
			$toolBar .= PHP_EOL . $this->_t(4) . "JToolBarHelper::save('" . $viewName . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . $this->_t(3) . "}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName, $this->permissionBuilder['global'][$core['core.edit']]))
			{
				$toolBar .= PHP_EOL . $this->_t(3) . "elseif (\$this->canDo->get('" . $core['core.edit'] . "'))";
			}
			else
			{
				$toolBar .= PHP_EOL . $this->_t(3) . "elseif (\$this->canDo->get('core.edit'))";
			}
			$toolBar .= PHP_EOL . $this->_t(3) . "{";
			$toolBar .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " We can save the record.";
			$toolBar .= PHP_EOL . $this->_t(4) . "JToolBarHelper::save('" . $viewName . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . $this->_t(3) . "}";
			$toolBar .= PHP_EOL . $this->_t(3) . "if (\$isNew)";
			$toolBar .= PHP_EOL . $this->_t(3) . "{";
			$toolBar .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Do not creat but cancel.";
			$toolBar .= PHP_EOL . $this->_t(4) . "JToolBarHelper::cancel('" . $viewName . ".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= PHP_EOL . $this->_t(3) . "}";
			$toolBar .= PHP_EOL . $this->_t(3) . "else";
			$toolBar .= PHP_EOL . $this->_t(3) . "{";
			$toolBar .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " We can close it.";
			$toolBar .= PHP_EOL . $this->_t(4) . "JToolBarHelper::cancel('" . $viewName . ".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= PHP_EOL . $this->_t(3) . "}";
			$toolBar .= PHP_EOL . $this->_t(2) . "}";
			$toolBar .= PHP_EOL . $this->_t(2) . "else";
			$toolBar .= PHP_EOL . $this->_t(2) . "{";
			$toolBar .= PHP_EOL . $this->_t(3) . "if (\$isNew)";
			$toolBar .= PHP_EOL . $this->_t(3) . "{";
			$toolBar .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " For new records, check the create permission.";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName, $this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->canDo->get('" . $core['core.create'] . "'))";
			}
			else
			{
				$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->canDo->get('core.create'))";
			}
			$toolBar .= PHP_EOL . $this->_t(4) . "{";
			$toolBar .= PHP_EOL . $this->_t(5) . "JToolBarHelper::apply('" . $viewName . ".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= PHP_EOL . $this->_t(5) . "JToolBarHelper::save('" . $viewName . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . $this->_t(5) . "JToolBarHelper::custom('" . $viewName . ".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= PHP_EOL . $this->_t(4) . "};";
			$toolBar .= PHP_EOL . $this->_t(4) . "JToolBarHelper::cancel('" . $viewName . ".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= PHP_EOL . $this->_t(3) . "}";
			$toolBar .= PHP_EOL . $this->_t(3) . "else";
			$toolBar .= PHP_EOL . $this->_t(3) . "{";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName, $this->permissionBuilder['global'][$core['core.edit']]))
			{
				$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->canDo->get('" . $core['core.edit'] . "'))";
			}
			else
			{
				$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->canDo->get('core.edit'))";
			}
			$toolBar .= PHP_EOL . $this->_t(4) . "{";
			$toolBar .= PHP_EOL . $this->_t(5) . "//" . $this->setLine(__LINE__) . " We can save the new record";
			$toolBar .= PHP_EOL . $this->_t(5) . "JToolBarHelper::apply('" . $viewName . ".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= PHP_EOL . $this->_t(5) . "JToolBarHelper::save('" . $viewName . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . $this->_t(5) . "//" . $this->setLine(__LINE__) . " We can save this record, but check the create permission to see";
			$toolBar .= PHP_EOL . $this->_t(5) . "//" . $this->setLine(__LINE__) . " if we can return to make a new one.";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName, $this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL . $this->_t(5) . "if (\$this->canDo->get('" . $core['core.create'] . "'))";
			}
			else
			{
				$toolBar .= PHP_EOL . $this->_t(5) . "if (\$this->canDo->get('core.create'))";
			}
			$toolBar .= PHP_EOL . $this->_t(5) . "{";
			$toolBar .= PHP_EOL . $this->_t(6) . "JToolBarHelper::custom('" . $viewName . ".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= PHP_EOL . $this->_t(5) . "}";
			$toolBar .= PHP_EOL . $this->_t(4) . "}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName, $this->permissionBuilder['global'][$core['core.edit']]))
			{
				if ($coreLoad && isset($this->historyBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->historyBuilder[$viewName]))
				{
					$toolBar .= PHP_EOL . $this->_t(4) . "\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('" . $core['core.version'] . "'));";
					$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->state->params->get('save_history', 1) && \$this->canDo->get('" . $core['core.edit'] . "') && \$canVersion)";
					$toolBar .= PHP_EOL . $this->_t(4) . "{";
					$toolBar .= PHP_EOL . $this->_t(5) . "JToolbarHelper::versions('com_" . $this->componentCodeName . "." . $viewName . "', \$this->item->id);";
					$toolBar .= PHP_EOL . $this->_t(4) . "}";
				}
			}
			else
			{
				if ($coreLoad && isset($this->historyBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->historyBuilder[$viewName]))
				{
					$toolBar .= PHP_EOL . $this->_t(4) . "\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('" . $core['core.version'] . "'));";
					$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->state->params->get('save_history', 1) && \$this->canDo->get('core.edit') && \$canVersion)";
					$toolBar .= PHP_EOL . $this->_t(4) . "{";
					$toolBar .= PHP_EOL . $this->_t(5) . "JToolbarHelper::versions('com_" . $this->componentCodeName . "." . $viewName . "', \$this->item->id);";
					$toolBar .= PHP_EOL . $this->_t(4) . "}";
				}
			}
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName, $this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->canDo->get('" . $core['core.create'] . "'))";
			}
			else
			{
				$toolBar .= PHP_EOL . $this->_t(4) . "if (\$this->canDo->get('core.create'))";
			}
			$toolBar .= PHP_EOL . $this->_t(4) . "{";
			$toolBar .= PHP_EOL . $this->_t(5) . "JToolBarHelper::custom('" . $viewName . ".save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);";
			$toolBar .= PHP_EOL . $this->_t(4) . "}";
			// add custom buttons
			$toolBar .= $this->setCustomButtons($view, 2, $this->_t(2));
			$toolBar .= PHP_EOL . $this->_t(4) . "JToolBarHelper::cancel('" . $viewName . ".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= PHP_EOL . $this->_t(3) . "}";
			$toolBar .= PHP_EOL . $this->_t(2) . "}";
			$toolBar .= PHP_EOL . $this->_t(2) . "JToolbarHelper::divider();";
			$toolBar .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " set help url for this view if found";
			$toolBar .= PHP_EOL . $this->_t(2) . "\$help_url = " . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::getHelpUrl('" . $viewName . "');";
			$toolBar .= PHP_EOL . $this->_t(2) . "if (" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkString(\$help_url))";
			$toolBar .= PHP_EOL . $this->_t(2) . "{";
			$toolBar .= PHP_EOL . $this->_t(3) . "JToolbarHelper::help('" . $this->langPrefix . "_HELP_MANAGER', false, \$help_url);";
			$toolBar .= PHP_EOL . $this->_t(2) . "}";
		}
		return $toolBar;
	}

	public function setPopulateState(&$view)
	{
		// reset buket
		$state = '';
		// keep track of all fields already added
		$donelist = array();

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = PHP_EOL . PHP_EOL . $this->_t(2);
						}
						$state .= $spacer . "\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
						$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter.category', \$category);";
						$state .= PHP_EOL . PHP_EOL . $this->_t(2) . "\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
						$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter.category_id', \$categoryId);";
						if ($filter['code'] != 'category')
						{
							$state .= PHP_EOL . PHP_EOL . $this->_t(2) . "\$" . $filter['code'] . " = \$app->getUserStateFromRequest(\$this->context . '.filter." . $filter['code'] . "', 'filter_" . $filter['code'] . "');";
							$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter." . $filter['code'] . "', \$" . $filter['code'] . ");";
						}
					}
					else
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = PHP_EOL . PHP_EOL . $this->_t(2);
						}
						// check if custom field is set
						/* if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$state .= $spacer."\$".$filter['code']."_".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."_".$filter['custom']['text']."', 'filter_".$filter['code']."_".$filter['custom']['text']."');";
							$state .= PHP_EOL.$this->_t(2) . "\$this->setState('filter.".$filter['code']."_".$filter['custom']['text']."', \$".$filter['code']."_".$filter['custom']['text'].");";
							$spacer = PHP_EOL.PHP_EOL.$this->_t(2);
						} */
						$state .= $spacer . "\$" . $filter['code'] . " = \$this->getUserStateFromRequest(\$this->context . '.filter." . $filter['code'] . "', 'filter_" . $filter['code'] . "');";
						$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter." . $filter['code'] . "', \$" . $filter['code'] . ");";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		// add the rest of the set filters
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = PHP_EOL . PHP_EOL . $this->_t(2);
						}
						$state .= $spacer . "\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
						$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter.category', \$category);";
						$state .= PHP_EOL . PHP_EOL . $this->_t(2) . "\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
						$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter.category_id', \$categoryId);";
						if ($filter['code'] != 'category')
						{
							$state .= PHP_EOL . PHP_EOL . $this->_t(2) . "\$" . $filter['code'] . " = \$app->getUserStateFromRequest(\$this->context . '.filter." . $filter['code'] . "', 'filter_" . $filter['code'] . "');";
							$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter." . $filter['code'] . "', \$" . $filter['code'] . ");";
						}
					}
					else
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = PHP_EOL . PHP_EOL . $this->_t(2);
						}
						// check if custom field is set
						/* if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$state .= $spacer."\$".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['custom']['text']."', 'filter_".$filter['custom']['text']."');";
							$state .= PHP_EOL.$this->_t(2) . "\$this->setState('filter.".$filter['custom']['text']."', \$".$filter['custom']['text'].");";
							$state .= PHP_EOL.$this->_t(2) . "\$".$filter['code']."_".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."_".$filter['custom']['text']."', 'filter_".$filter['code']."_".$filter['custom']['text']."');";
							$state .= PHP_EOL.$this->_t(2) . "\$this->setState('filter.".$filter['code']."_".$filter['custom']['text']."', \$".$filter['code']."_".$filter['custom']['text'].");";
							$spacer = PHP_EOL.PHP_EOL.$this->_t(2);
						} */
						$state .= $spacer . "\$" . $filter['code'] . " = \$this->getUserStateFromRequest(\$this->context . '.filter." . $filter['code'] . "', 'filter_" . $filter['code'] . "');";
						$state .= PHP_EOL . $this->_t(2) . "\$this->setState('filter." . $filter['code'] . "', \$" . $filter['code'] . ");";
					}
					$donelist[] = $filter['code'];
				}
			}
		}
		return $state;
	}

	public function setSortFields(&$view)
	{
		// keep track of all fields already added
		$donelist = array('sorting', 'published');
		// set the default first
		$fields = "return array(";
		$fields .= PHP_EOL . $this->_t(3) . "'a.sorting' => JText:" . ":_('JGRID_HEADING_ORDERING')";
		$fields .= "," . PHP_EOL . $this->_t(3) . "'a.published' => JText:" . ":_('JSTATUS')";

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= "," . PHP_EOL . $this->_t(3) . "'c.category_title' => JText:" . ":_('" . $filter['lang'] . "')";
					}
					elseif (ComponentbuilderHelper::checkArray($filter['custom']))
					{
						$fields .= "," . PHP_EOL . $this->_t(3) . "'" . $filter['custom']['db'] . "." . $filter['custom']['text'] . "' => JText:" . ":_('" . $filter['lang'] . "')";
					}
					else
					{
						$fields .= "," . PHP_EOL . $this->_t(3) . "'a." . $filter['code'] . "' => JText:" . ":_('" . $filter['lang'] . "')";
					}
				}
			}
		}
		$fields .= "," . PHP_EOL . $this->_t(3) . "'a.id' => JText:" . ":_('JGRID_HEADING_ID')";
		$fields .= PHP_EOL . $this->_t(2) . ");";
		// return fields
		return $fields;
	}

	public function setCheckinCall()
	{
		$call = PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " check in items";
		$call .= PHP_EOL . $this->_t(2) . "\$this->checkInNow();" . PHP_EOL;

		return $call;
	}

	public function setAutoCheckin($view, $component)
	{
		$checkin = PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
		$checkin .= PHP_EOL . $this->_t(1) . " * Build an SQL query to checkin all items left checked out longer then a set time.";
		$checkin .= PHP_EOL . $this->_t(1) . " *";
		$checkin .= PHP_EOL . $this->_t(1) . " * @return  a bool";
		$checkin .= PHP_EOL . $this->_t(1) . " *";
		$checkin .= PHP_EOL . $this->_t(1) . " */";
		$checkin .= PHP_EOL . $this->_t(1) . "protected function checkInNow()";
		$checkin .= PHP_EOL . $this->_t(1) . "{";
		$checkin .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get set check in time";
		$checkin .= PHP_EOL . $this->_t(2) . "\$time = JComponentHelper::getParams('com_" . $component . "')->get('check_in');";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(2) . "if (\$time)";
		$checkin .= PHP_EOL . $this->_t(2) . "{";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Get a db connection.";
		$checkin .= PHP_EOL . $this->_t(3) . "\$db = JFactory::getDbo();";
		$checkin .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " reset query";
		$checkin .= PHP_EOL . $this->_t(3) . "\$query = \$db->getQuery(true);";
		$checkin .= PHP_EOL . $this->_t(3) . "\$query->select('*');";
		$checkin .= PHP_EOL . $this->_t(3) . "\$query->from(\$db->quoteName('#__" . $component . "_" . $view . "'));";
		$checkin .= PHP_EOL . $this->_t(3) . "\$db->setQuery(\$query);";
		$checkin .= PHP_EOL . $this->_t(3) . "\$db->execute();";
		$checkin .= PHP_EOL . $this->_t(3) . "if (\$db->getNumRows())";
		$checkin .= PHP_EOL . $this->_t(3) . "{";
		$checkin .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Get Yesterdays date";
		$checkin .= PHP_EOL . $this->_t(4) . "\$date = JFactory::getDate()->modify(\$time)->toSql();";
		$checkin .= PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " reset query";
		$checkin .= PHP_EOL . $this->_t(4) . "\$query = \$db->getQuery(true);";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Fields to update.";
		$checkin .= PHP_EOL . $this->_t(4) . "\$fields = array(";
		$checkin .= PHP_EOL . $this->_t(5) . "\$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',";
		$checkin .= PHP_EOL . $this->_t(5) . "\$db->quoteName('checked_out') . '=0'";
		$checkin .= PHP_EOL . $this->_t(4) . ");";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Conditions for which records should be updated.";
		$checkin .= PHP_EOL . $this->_t(4) . "\$conditions = array(";
		$checkin .= PHP_EOL . $this->_t(5) . "\$db->quoteName('checked_out') . '!=0', ";
		$checkin .= PHP_EOL . $this->_t(5) . "\$db->quoteName('checked_out_time') . '<\''.\$date.'\''";
		$checkin .= PHP_EOL . $this->_t(4) . ");";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(4) . "//" . $this->setLine(__LINE__) . " Check table";
		$checkin .= PHP_EOL . $this->_t(4) . "\$query->update(\$db->quoteName('#__" . $component . "_" . $view . "'))->set(\$fields)->where(\$conditions); ";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(4) . "\$db->setQuery(\$query);";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(4) . "\$db->execute();";
		$checkin .= PHP_EOL . $this->_t(3) . "}";
		$checkin .= PHP_EOL . $this->_t(2) . "}";
		$checkin .= PHP_EOL . PHP_EOL . $this->_t(2) . "return false;";
		$checkin .= PHP_EOL . $this->_t(1) . "}";

		return $checkin;
	}

	public function setGetItemsMethodStringFix($viewName_single, $viewName_list, $Component, $tab = '', $export = false, $all = false)
	{
		// add the fix if this view has the need for it
		$fix = '';
		$forEachStart = '';
		$fix_access = '';
		// encryption switches
		foreach ($this->cryptionTypes as $cryptionType)
		{
			${$cryptionType . 'Crypt'} = false;
		}
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		$component = ComponentbuilderHelper::safeString($Component);
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder[$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.access']]) && in_array($viewName_single, $this->permissionBuilder[$core['core.access']]))
		{
			$fix_access = PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Remove items the user can't access.";
			$fix_access .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$access = (\$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$item->id) && \$user->authorise('" . $core['core.access'] . "', 'com_" . $component . "'));";
			$fix_access .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (!\$access)";
			$fix_access .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
			$fix_access .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "unset(\$items[\$nr]);";
			$fix_access .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "continue;";
			$fix_access .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "}" . PHP_EOL;
		}
		// get the correct array
		if ($export || $all)
		{
			$methodName = 'getItemsMethodEximportStringFixBuilder';
		}
		else
		{
			$methodName = 'getItemsMethodListStringFixBuilder';
		}
		// load the relations before modeling
		if (isset($this->fieldRelations[$viewName_list]) && ComponentbuilderHelper::checkArray($this->fieldRelations[$viewName_list]))
		{
			foreach ($this->fieldRelations[$viewName_list] as $field_id => $fields)
			{
				foreach ($fields as $area => $field)
				{
					if ($area == 1 && isset($field['code']))
					{
						$fix .= $this->setModelFieldRelation($field, $viewName_list, $tab);
					}
				}
			}
		}
		// open the values
		if (isset($this->{$methodName}[$viewName_single]) && ComponentbuilderHelper::checkArray($this->{$methodName}[$viewName_single]))
		{
			foreach ($this->{$methodName}[$viewName_single] as $item)
			{
				switch ($item['method'])
				{
					case 1:
						// JSON_STRING_ENCODE
						$decode = 'json_decode';
						$suffix_decode = ', true';
						break;
					case 2:
						// BASE_SIXTY_FOUR
						$decode = 'base64_decode';
						$suffix_decode = '';
						break;
					case 3:
						// BASIC_ENCRYPTION_LOCALKEY
						$decode = '$basic->decryptString';
						$basicCrypt = true;
						$suffix_decode = '';
						break;
					case 4:
						// WHMCS_ENCRYPTION_WHMCS
						$decode = '$whmcs->decryptString';
						$whmcsCrypt = true;
						$suffix_decode = '';
						break;
					case 5:
						// MEDIUM_ENCRYPTION_LOCALFILE
						$decode = '$medium->decryptString';
						$mediumCrypt = true;
						$suffix_decode = '';
						break;
					case 6:
						// EXPERT_ENCRYPTION
						$expertCrypt = true;
						break;
					default:
						// JSON_ARRAY_ENCODE
						$decode = 'json_decode';
						$suffix_decode = ', true';
						// fallback on json
						$item['method'] = 1;
						break;
				}

				if ($item['type'] === 'usergroup' && !$export && $item['method'] != 6)
				{
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " decode " . $item['name'];
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$" . $item['name'] . "Array = " . $decode . "(\$item->" . $item['name'] . $suffix_decode . ");";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (" . $Component . "Helper::checkArray(\$" . $item['name'] . "Array))";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "\$" . $item['name'] . "Names = array();";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "foreach (\$" . $item['name'] . "Array as \$" . $item['name'] . ")";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "{";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "\$" . $item['name'] . "Names[] = " . $Component . "Helper::getGroupName(\$" . $item['name'] . ");";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "}";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "\$item->" . $item['name'] . " =  implode(', ', \$" . $item['name'] . "Names);";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "}";
				}
				/* elseif ($item['type'] === 'usergroup' && $export)
				{
					$fix .= PHP_EOL.$this->_t(1).$tab.$this->_t(3) . "//".$this->setLine(__LINE__)." decode ".$item['name'];
					$fix .= PHP_EOL.$this->_t(1).$tab.$this->_t(3) . "\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= PHP_EOL.$this->_t(1).$tab.$this->_t(3) . "if (".$Component."Helper::checkArray(\$".$item['name']."Array))";
					$fix .= PHP_EOL.$this->_t(1).$tab.$this->_t(3) . "{";
					$fix .= PHP_EOL.$this->_t(1).$tab.$this->_t(4) . "\$item->".$item['name']." = implode('|',\$".$item['name']."Array);";
					$fix .= PHP_EOL.$this->_t(1).$tab.$this->_t(3) . "}";
				} */
				elseif ($item['translation'] && !$export && $item['method'] != 6)
				{
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " decode " . $item['name'];
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$" . $item['name'] . "Array = " . $decode . "(\$item->" . $item['name'] . $suffix_decode . ");";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (" . $Component . "Helper::checkArray(\$" . $item['name'] . "Array))";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "\$" . $item['name'] . "Names = array();";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "foreach (\$" . $item['name'] . "Array as \$" . $item['name'] . ")";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "{";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "\$" . $item['name'] . "Names[] = JText:" . ":_(\$this->selectionTranslation(\$" . $item['name'] . ", '" . $item['name'] . "'));";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "}";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "\$item->" . $item['name'] . " = implode(', ', \$" . $item['name'] . "Names);";
					$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "}";
				}
				else
				{
					if ($item['method'] == 2 || $item['method'] == 3 || $item['method'] == 4 || $item['method'] == 5 || $item['method'] == 6)
					{
						// expert mode (dev must do it all)
						if ($item['method'] == 6)
						{
							$_placeholder_for_field = array('[[[field]]]' => "\$item->" . $item['name']);
							$fix .= $this->setPlaceholders(PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . implode(PHP_EOL . $this->_t(1) . $tab . $this->_t(3), $this->expertFieldModeling[$viewName_single][$item['name']]['get']), $_placeholder_for_field);
						}
						else
						{
							$taber = '';
							if ($item['method'] == 3)
							{
								$taber = $this->_t(1);
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (\$basickey && !is_numeric(\$item->" . $item['name'] . ") && \$item->" . $item['name'] . " === base64_encode(base64_decode(\$item->" . $item['name'] . ", true)))";
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
							}
							elseif ($item['method'] == 5)
							{
								$taber = $this->_t(1);
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (\$mediumkey && !is_numeric(\$item->" . $item['name'] . ") && \$item->" . $item['name'] . " === base64_encode(base64_decode(\$item->" . $item['name'] . ", true)))";
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
							}
							elseif ($item['method'] == 4)
							{
								$taber = $this->_t(1);
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (\$whmcskey && !is_numeric(\$item->" . $item['name'] . ") && \$item->" . $item['name'] . " === base64_encode(base64_decode(\$item->" . $item['name'] . ", true)))";
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
							}
							if ($item['method'] == 3 || $item['method'] == 4 || $item['method'] == 5)
							{
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "//" . $this->setLine(__LINE__) . " decrypt " . $item['name'];
							}
							else
							{
								$fix .= PHP_EOL . $this->_t(1) . $tab . $taber . $this->_t(3) . "//" . $this->setLine(__LINE__) . " decode " . $item['name'];
							}
							$fix .= PHP_EOL . $this->_t(1) . $tab . $taber . $this->_t(3) . "\$item->" . $item['name'] . " = " . $decode . "(\$item->" . $item['name'] . ");";

							if ($item['method'] == 3 || $item['method'] == 4 || $item['method'] == 5)
							{
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "}";
							}
						}
					}
					else
					{
						if ($export && $item['type'] === 'repeatable')
						{
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " decode repeatable " . $item['name'];
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$" . $item['name'] . "Array = " . $decode . "(\$item->" . $item['name'] . $suffix_decode . ");";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (" . $Component . "Helper::checkArray(\$" . $item['name'] . "Array))";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "\$bucket" . $item['name'] . " = array();";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "foreach (\$" . $item['name'] . "Array as \$" . $item['name'] . "FieldName => \$" . $item['name'] . ")";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "{";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "if (" . $Component . "Helper::checkArray(\$" . $item['name'] . "))";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "{";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(6) . "\$bucket" . $item['name'] . "[] = \$" . $item['name'] . "FieldName . '<||VDM||>' . implode('<|VDM|>',\$" . $item['name'] . ");";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "}";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "}";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "//" . $this->setLine(__LINE__) . " make sure the bucket has values.";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "if (" . $Component . "Helper::checkArray(\$bucket" . $item['name'] . "))";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "{";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "//" . $this->setLine(__LINE__) . " clear the repeatable field.";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "unset(\$item->" . $item['name'] . ");";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "//" . $this->setLine(__LINE__) . " set repeatable field for export.";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "\$item->" . $item['name'] . " = implode('<|||VDM|||>',\$bucket" . $item['name'] . ");";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "//" . $this->setLine(__LINE__) . " unset the bucket.";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "unset(\$bucket" . $item['name'] . ");";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "}";
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "}";
						}
						elseif ($item['method'] == 1 && !$export)
						{
							// TODO we check if this works well.
							$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " convert " . $item['name'];
							if (isset($item['custom']['table']))
							{
								// check if this is a local table
								if (strpos($item['custom']['table'], '#__' . $this->componentCodeName . '_') !== false)
								{
									$keyTableNAme = str_replace('#__' . $this->componentCodeName . '_', '', $item['custom']['table']);
								}
								else
								{
									$keyTableNAme = $item['custom']['table'];
								}
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$item->" . $item['name'] . " = " . $Component . "Helper::jsonToString(\$item->" . $item['name'] . ", ', ', '" . $keyTableNAme . "', '" . $item['custom']['id'] . "', '" . $item['custom']['text'] . "');";
							}
							else
							{
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$item->" . $item['name'] . " = " . $Component . "Helper::jsonToString(\$item->" . $item['name'] . ", ', ', '" . $item['name'] . "');";
							}
						}
						else
						{
							if (!$export)
							{
								// For those we have not cached yet.
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " convert " . $item['name'];
								$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$item->" . $item['name'] . " = " . $Component . "Helper::jsonToString(\$item->" . $item['name'] . ");";
							}
						}
					}
				}
			}
		}
		/* // set translation (TODO) would be nice to cut down on double loops..
		if (!$export && isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list]))
		{
			foreach ($this->selectionTranslationFixBuilder[$viewName_list] as $name => $values)
			{
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " convert " . $name;
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$item->" . $name . " = \$this->selectionTranslation(\$item->" . $name . ", '" . $name . "');";
			}
		} */
		// load the relations after modeling
		if (isset($this->fieldRelations[$viewName_list]) && ComponentbuilderHelper::checkArray($this->fieldRelations[$viewName_list]))
		{
			foreach ($this->fieldRelations[$viewName_list] as $fields)
			{
				foreach ($fields as $area => $field)
				{
					if ($area == 3 && isset($field['code']))
					{
						$fix .= $this->setModelFieldRelation($field, $viewName_list, $tab);
					}
				}
			}
		}
		// close the foreach if needed
		if (ComponentbuilderHelper::checkString($fix) || ComponentbuilderHelper::checkString($fix_access) || $export || $all)
		{
			// start the loop
			$forEachStart = PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Set values to display correctly.";
			$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (" . $Component . "Helper::checkArray(\$items))";
			$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
			// do not add to export since it is already done
			if (!$export)
			{
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get the user object if not set.";
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "if (!isset(\$user) || !" . $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . "Helper::checkObject(\$user))";
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "{";
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$user = JFactory::getUser();";
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "}";
			}
			// the permissional acttion switch
			$hasPermissional = false;
			// add the permissional removal of values the user has not right to view or access
			if ($this->strictFieldExportPermissions && isset($this->permissionFields[$viewName_single]) && ComponentbuilderHelper::checkArray($this->permissionFields[$viewName_single]))
			{
				foreach ($this->permissionFields[$viewName_single] as $fieldName => $permission_options)
				{
					if (!$hasPermissional)
					{
						foreach($permission_options as $permission_option => $fieldType)
						{
							if (!$hasPermissional)
							{
								switch ($permission_option)
								{
									case 'access':
									case 'view':
										$hasPermissional = true;
									break;
								}
							}
						}
					}
				}
				// add the notes and get the global switch
				if ($hasPermissional)
				{
					$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Get global permissional control activation. (default is inactive)";
					$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "\$strict_permission_per_field = JComponentHelper::getParams('com_" . $component . "')->get('strict_permission_per_field', 0);" . PHP_EOL;
				}
			}
			$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "foreach (\$items as \$nr => &\$item)";
			$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "{";
			// add the access options
			$forEachStart .= $fix_access;
			// add the permissional removal of values the user has not right to view or access
			if ($hasPermissional)
			{
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " use permissional control if globaly set.";
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "if (\$strict_permission_per_field)";
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "{";
				foreach ($this->permissionFields[$viewName_single] as $fieldName => $permission_options)
				{
					foreach($permission_options as $permission_option => $fieldType)
					{
						switch ($permission_option)
						{
							case 'access':
							case 'view':
								$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "//" . $this->setLine(__LINE__) . " set " . $permission_option . " permissional control for " . $fieldName . " value.";
								$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "if (isset(\$item->"  . $fieldName . ") && (!\$user->authorise('" . $viewName_single . "." . $permission_option . "." . $fieldName . "', 'com_" . $component . "." . $viewName_single . ".' . (int) \$item->id)";
								$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "|| !\$user->authorise('" . $viewName_single .  "." . $permission_option . "."  . $fieldName . "', 'com_" . $component . "')))";
								$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "{";
								$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "//" . $this->setLine(__LINE__) . " We JUST empty the value (do you have a better idea)";
								$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(5) . "\$item->"  . $fieldName . " = '';";
								$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(4) . "}";
							break;
						}
					}
				}
				$forEachStart .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "}";
			}
			// remove these values if export
			if ($export)
			{
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " unset the values we don't want exported.";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "unset(\$item->asset_id);";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "unset(\$item->checked_out);";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "unset(\$item->checked_out_time);";
			}

			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "}";
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
			if ($export)
			{
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Add headers to items array.";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$headers = \$this->getExImPortHeaders();";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (" . $Component . "Helper::checkObject(\$headers))";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "array_unshift(\$items,\$headers);";
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}";
			}
		}

		// add custom php to getitems method
		$fix .= $this->getCustomScriptBuilder('php_getitems', $viewName_single, PHP_EOL . PHP_EOL . $tab);

		// load the encryption object if needed
		$script = '';
		foreach ($this->cryptionTypes as $cryptionType)
		{
			if (${$cryptionType . 'Crypt'})
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Get the " . $cryptionType . " encryption key.";
					$script .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$" . $cryptionType . "key = " . $Component . "Helper::getCryptKey('" . $cryptionType . "');";
					$script .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " Get the encryption object.";
					$script .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "\$" . $cryptionType . " = new FOFEncryptAes(\$" . $cryptionType . "key);";
				}
				elseif (isset($this->{$cryptionType . 'FieldModelInitiator'}[$viewName_single]) 
					&& isset($this->{$cryptionType . 'FieldModelInitiator'}[$viewName_single]['get']))
				{
					foreach ($this->{$cryptionType . 'FieldModelInitiator'}[$viewName_single]['get'] as $block)
					{
						$script .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . implode(PHP_EOL . $this->_t(1) . $tab . $this->_t(1), $block);
					}
				}
			}
		}
		// add the encryption script
		return $script . $forEachStart . $fix;
	}

	protected function setModelFieldRelation($item, $viewName_list, $tab)
	{
		$fix = '';
		// set fields
		$field = array();
		// set list field name
		$field['$item->{' . (int) $item['listfield'] . '}'] = '$item->' . $item['code'];
		// load joint field names
		if (isset($item['joinfields']) && ComponentbuilderHelper::checkArray($item['joinfields']))
		{
			foreach ($item['joinfields'] as $join)
			{
				$field['$item->{' . (int) $join . '}'] = '$item->' . $this->listJoinBuilder[$viewName_list][(int) $join]['code'];
			}
		}
		// set based on join_type
		if ($item['join_type'] == 2)
		{
			// code
			$code = (array) explode(PHP_EOL, str_replace(array_keys($field), array_values($field), $item['set']));
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . implode(PHP_EOL . $this->_t(1) . $tab . $this->_t(3), $code);
		}
		else
		{
			// concatenate
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " concatenate these fields";
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$item->" . $item['code'] . ' = ' . implode(" . '" . str_replace("'", '&apos;', $item['set']) . "' . ", $field) . ';';
		}
		return $this->setPlaceholders($fix, $this->placeholders);
	}

	public function setSelectionTranslationFix($views, $Component, $tab = '')
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (isset($this->selectionTranslationFixBuilder[$views]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$views]))
		{
			$fix .= PHP_EOL . PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "//" . $this->setLine(__LINE__) . " set selection value to a translatable value";
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "if (" . $Component . "Helper::checkArray(\$items))";
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "{";
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "foreach (\$items as \$nr => &\$item)";
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "{";
			foreach ($this->selectionTranslationFixBuilder[$views] as $name => $values)
			{
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "//" . $this->setLine(__LINE__) . " convert " . $name;
				$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(3) . "\$item->" . $name . " = \$this->selectionTranslation(\$item->" . $name . ", '" . $name . "');";
			}
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(2) . "}";
			$fix .= PHP_EOL . $this->_t(1) . $tab . $this->_t(1) . "}" . PHP_EOL;
		}
		return $fix;
	}

	public function setSelectionTranslationFixFunc($views, $Component)
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (isset($this->selectionTranslationFixBuilder[$views]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$views]))
		{
			$fix .= PHP_EOL . PHP_EOL . $this->_t(1) . "/**";
			$fix .= PHP_EOL . $this->_t(1) . " * Method to convert selection values to translatable string.";
			$fix .= PHP_EOL . $this->_t(1) . " *";
			$fix .= PHP_EOL . $this->_t(1) . " * @return translatable string";
			$fix .= PHP_EOL . $this->_t(1) . " */";
			$fix .= PHP_EOL . $this->_t(1) . "public function selectionTranslation(\$value,\$name)";
			$fix .= PHP_EOL . $this->_t(1) . "{";
			foreach ($this->selectionTranslationFixBuilder[$views] as $name => $values)
			{
				if (ComponentbuilderHelper::checkArray($values))
				{
					$fix .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Array of " . $name . " language strings";
					$fix .= PHP_EOL . $this->_t(2) . "if (\$name === '" . $name . "')";
					$fix .= PHP_EOL . $this->_t(2) . "{";
					$fix .= PHP_EOL . $this->_t(3) . "\$" . $name . "Array = array(";
					$counter = 0;
					foreach ($values as $value => $translang)
					{
						// only add quotes to strings
						if (ComponentbuilderHelper::checkString($value))
						{
							$key = "'" . $value . "'";
						}
						else
						{
							if ($value == '')
							{
								$value = 0;
							}
							$key = $value;
						}
						if ($counter == 0)
						{
							$fix .= PHP_EOL . $this->_t(4) . $key . " => '" . $translang . "'";
						}
						else
						{
							$fix .= "," . PHP_EOL . $this->_t(4) . $key . " => '" . $translang . "'";
						}
						$counter++;
					}
					$fix .= PHP_EOL . $this->_t(3) . ");";
					$fix .= PHP_EOL . $this->_t(3) . "//" . $this->setLine(__LINE__) . " Now check if value is found in this array";
					$fix .= PHP_EOL . $this->_t(3) . "if (isset(\$" . $name . "Array[\$value]) && " . $Component . "Helper::checkString(\$" . $name . "Array[\$value]))";
					$fix .= PHP_EOL . $this->_t(3) . "{";
					$fix .= PHP_EOL . $this->_t(4) . "return \$" . $name . "Array[\$value];";
					$fix .= PHP_EOL . $this->_t(3) . "}";
					$fix .= PHP_EOL . $this->_t(2) . "}";
				}
			}
			$fix .= PHP_EOL . $this->_t(2) . "return \$value;";
			$fix .= PHP_EOL . $this->_t(1) . "}";
		}
		return $fix;
	}

	public function setRouterCase($viewName)
	{
		if (strlen($viewName) > 0)
		{
			$router = PHP_EOL . $this->_t(2) . "case '" . $viewName . "':";
			$router .= PHP_EOL . $this->_t(3) . "\$id = explode(':', \$segments[$count-1]);";
			$router .= PHP_EOL . $this->_t(3) . "\$vars['id'] = (int) \$id[0];";
			$router .= PHP_EOL . $this->_t(3) . "\$vars['view'] = '" . $viewName . "';";
			$router .= PHP_EOL . $this->_t(2) . "break;";

			return $router;
		}
		return '';
	}

	public function setComponentImageType($path)
	{
		$type = ComponentbuilderHelper::imageInfo($path);
		if ($type)
		{
			$imagePath = $this->componentPath . '/admin/assets/images';
			// move the image to its place
			JFile::copy(JPATH_SITE . '/' . $path, $imagePath . '/vdm-component.' . $type, '', true);
			// now set the type to global for re-use
			$this->componentImageType = $type;
			// return image type
			return $type;
		}
		$this->componentImageType = 'jpg';
		return 'jpg';
	}

	public function setDashboardIconAccess()
	{
		if (isset($this->permissionDashboard) && ComponentbuilderHelper::checkArray($this->permissionDashboard))
		{
			$this->permissionDashboard = array_unique($this->permissionDashboard);
			return PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " view access array" . PHP_EOL . $this->_t(2) . "\$viewAccess = array(" . PHP_EOL . $this->_t(3) . implode("," . PHP_EOL . $this->_t(3), $this->permissionDashboard) . ");";
		}
		return '';
	}

	public function setDashboardIcons()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$icons = '';
			$counter = 0;
			$catArray = array();
			foreach ($this->componentData->admin_views as $view)
			{
				$name_single = ComponentbuilderHelper::safeString($view['settings']->name_single);
				$name_list = ComponentbuilderHelper::safeString($view['settings']->name_list);

				$icons .= $this->addCustomDashboardIcons($view, $counter);
				if (isset($view['dashboard_add']) && $view['dashboard_add'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo($view['settings']->icon_add);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $name_single . ".add"] = $view['settings']->icon_add;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'" . $type . $name_single . ".add'";
					}
					else
					{
						$icons .= ", '" . $type . $name_single . ".add'";
					}
					// build lang
					$langName = 'Add&nbsp;' . ComponentbuilderHelper::safeString($view['settings']->name_single, 'W') . '<br /><br />';
					$langKey = $this->langPrefix . '_DASHBOARD_' . ComponentbuilderHelper::safeString($view['settings']->name_single, 'U') . '_ADD';
					// add to lang
					$this->setLangContent($this->lang, $langKey, $langName);
					$counter++;
				}
				if (isset($view['dashboard_list']) && $view['dashboard_list'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo($view['settings']->icon);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $name_list] = $view['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'" . $type . $name_list . "'";
					}
					else
					{
						$icons .= ", '" . $type . $name_list . "'";
					}
					// build lang
					$langName = ComponentbuilderHelper::safeString($view['settings']->name_list, 'W') . '<br /><br />';
					$langKey = $this->langPrefix . '_DASHBOARD_' . ComponentbuilderHelper::safeString($view['settings']->name_list, 'U');
					// add to lang
					$this->setLangContent($this->lang, $langKey, $langName);
					$counter++;
				}
				if (isset($this->categoryBuilder[$name_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$name_list]))
				{
					$catCode = $this->categoryBuilder[$name_list]['code'];

					// check if category has another name
					if (isset($this->catOtherName[$name_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$name_list]))
					{
						$otherViews = $this->catOtherName[$name_list]['views'];
						$otherNames = $this->catOtherName[$name_list]['name'];
						// build lang
						$langName = ComponentbuilderHelper::safeString($otherNames, 'W');
					}
					else
					{
						$otherViews = $name_list;
						// build lang
						$langName = 'Categories&nbsp;For<br />' . ComponentbuilderHelper::safeString($otherViews, 'W');
					}
					if (!in_array($otherViews, $catArray))
					{
						// add to lang
						$langKey = $this->langPrefix . '_DASHBOARD_' . ComponentbuilderHelper::safeString($otherViews, 'U') . '_' . ComponentbuilderHelper::safeString($catCode, 'U');
						$this->setLangContent($this->lang, $langKey, $langName);
						// get image type
						$type = ComponentbuilderHelper::imageInfo($view['settings']->icon_category);
						if ($type)
						{
							$type = $type . ".";
							// icon builder loader
							$this->iconBuilder[$type . $otherViews . "." . $catCode] = $view['settings']->icon_category;
						}
						else
						{
							$type = 'png.';
						}
						if ($counter == 0)
						{
							$icons .= "'" . $type . $otherViews . "." . $catCode . "'";
						}
						else
						{
							$icons .= ", '" . $type . $otherViews . "." . $catCode . "'";
						}
						$counter++;
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
				}
			}
			if (isset($this->lastCustomDashboardIcon) && ComponentbuilderHelper::checkArray($this->lastCustomDashboardIcon))
			{
				foreach ($this->lastCustomDashboardIcon as $icon)
				{
					$icons .= $icon;
				}
				unset($this->lastCustomDashboardIcon);
			}
			if (isset($this->iconBuilder) && ComponentbuilderHelper::checkArray($this->iconBuilder))
			{
				$imagePath = $this->componentPath . '/admin/assets/images/icons';
				foreach ($this->iconBuilder as $icon => $path)
				{
					$array_buket = explode('.', $icon);
					if (count((array) $array_buket) == 3)
					{
						list($type, $name, $action) = $array_buket;
					}
					else
					{
						list($type, $name) = $array_buket;
						$action = false;
					}
					// set the new image name
					if ($action)
					{
						$imageName = $name . '_' . $action . '.' . $type;
					}
					else
					{
						$imageName = $name . '.' . $type;
					}
					// move the image to its place
					JFile::copy(JPATH_SITE . '/' . $path, $imagePath . '/' . $imageName, '', true);
				}
			}
			return $icons;
		}
		return false;
	}

	public function setDashboardModelMethods()
	{
		if (isset($this->componentData->php_dashboard_methods) && ComponentbuilderHelper::checkString($this->componentData->php_dashboard_methods))
		{
			// get all the mothods that should load date to the view
			$this->DashboardGetCustomData = ComponentbuilderHelper::getAllBetween($this->componentData->php_dashboard_methods, 'public function get', '()');

			// return the methods
			return PHP_EOL . PHP_EOL . $this->setPlaceholders($this->componentData->php_dashboard_methods, $this->placeholders);
		}
		return '';
	}

	public function setDashboardGetCustomData()
	{
		if (isset($this->DashboardGetCustomData) && ComponentbuilderHelper::checkArray($this->DashboardGetCustomData))
		{
			// gets array reset
			$gets = array();
			// set dashboard gets
			foreach ($this->DashboardGetCustomData as $get)
			{
				$string = ComponentbuilderHelper::safeString($get);
				$gets[] = "\$this->" . $string . " = \$this->get('" . $get . "');";
			}
			// return the gets
			return PHP_EOL . $this->_t(2) . implode(PHP_EOL . $this->_t(2), $gets);
		}
		return '';
	}

	public function setDashboardDisplayData()
	{
		// display array reset
		$display = array();
		$mainAccordianName = 'cPanel';
		$builder = array();
		$tab = $this->_t(1);
		$loadTabs = false;
		// check if we have custom tabs
		if (isset($this->componentData->dashboard_tab) && ComponentbuilderHelper::checkArray($this->componentData->dashboard_tab))
		{
			// build the tabs and accordians
			foreach ($this->componentData->dashboard_tab as $data)
			{
				$builder[$data['name']][$data['header']] = $this->setPlaceholders($data['html'], $this->placeholders);
			}
			// since we have custom tabs we must load the tab structure around the cpanel
			$display[] = '<div id="j-main-container">';
			$display[] = $this->_t(1) . '<div class="form-horizontal">';
			$display[] = $this->_t(1) . "<?php echo JHtml::_('bootstrap.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>";
			$display[] = PHP_EOL . $this->_t(2) . "<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'cpanel', JText:" . ":_('cPanel', true)); ?>";
			$display[] = $this->_t(2) . '<div class="row-fluid">';
			// set the tab to insure correct spacing
			$tab = $this->_t(3);
			// change the name of the main tab
			$mainAccordianName = 'Control Panel';
			$loadTabs = true;
		}
		else
		{
			$display[] = '<div id="j-main-container">';
		}
		// set dashboard display
		$display[] = $tab . '<div class="span9">';
		$display[] = $tab . $this->_t(1) . "<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_left', array('active' => 'main')); ?>";
		$display[] = $tab . $this->_t(2) . "<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_left', '" . $mainAccordianName . "', 'main'); ?>";
		$display[] = $tab . $this->_t(3) . "<?php echo \$this->loadTemplate('main');?>";
		$display[] = $tab . $this->_t(2) . "<?php echo JHtml::_('bootstrap.endSlide'); ?>";
		$display[] = $tab . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endAccordion'); ?>";
		$display[] = $tab . "</div>";
		$display[] = $tab . '<div class="span3">';
		$display[] = $tab . $this->_t(1) . "<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_right', array('active' => 'vdm')); ?>";
		$display[] = $tab . $this->_t(2) . "<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_right', '" . $this->fileContentStatic[$this->hhh . 'COMPANYNAME' . $this->hhh] . "', 'vdm'); ?>";
		$display[] = $tab . $this->_t(3) . "<?php echo \$this->loadTemplate('vdm');?>";
		$display[] = $tab . $this->_t(2) . "<?php echo JHtml::_('bootstrap.endSlide'); ?>";
		$display[] = $tab . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endAccordion'); ?>";
		$display[] = $tab . "</div>";

		if ($loadTabs)
		{
			$display[] = $this->_t(2) . "</div>";
			$display[] = $this->_t(2) . "<?php echo JHtml::_('bootstrap.endTab'); ?>";
			// load the new tabs
			foreach ($builder as $tabname => $accordians)
			{
				$alias = ComponentbuilderHelper::safeString($tabname);
				$display[] = PHP_EOL . $this->_t(2) . "<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', '" . $alias . "', JText:" . ":_('" . $tabname . "', true)); ?>";
				$display[] = $this->_t(2) . '<div class="row-fluid">';
				$display[] = $tab . '<div class="span12">';
				$display[] = $tab . $this->_t(1) . "<?php  echo JHtml::_('bootstrap.startAccordion', '" . $alias . "_accordian', array('active' => '" . $alias . "_one')); ?>";
				$slidecounter = 1;
				foreach ($accordians as $accordianname => $html)
				{
					$ac_alias = ComponentbuilderHelper::safeString($accordianname);
					$counterName = ComponentbuilderHelper::safeString($slidecounter);
					$tempName = $alias . '_' . $ac_alias;
					$display[] = $tab . $this->_t(2) . "<?php  echo JHtml::_('bootstrap.addSlide', '" . $alias . "_accordian', '" . $accordianname . "', '" . $alias . "_" . $counterName . "'); ?>";
					$display[] = $tab . $this->_t(3) . "<?php echo \$this->loadTemplate('" . $tempName . "');?>";
					$display[] = $tab . $this->_t(2) . "<?php  echo JHtml::_('bootstrap.endSlide'); ?>";
					$slidecounter++;
					// build the template file
					$target = array('custom_admin' => $this->componentCodeName);
					$this->buildDynamique($target, 'template', $tempName);
					// set the file data
					$TARGET = ComponentbuilderHelper::safeString($this->target, 'U');
					// SITE_TEMPLATE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$this->componentCodeName . '_' . $tempName][$this->hhh . 'CUSTOM_ADMIN_TEMPLATE_BODY' . $this->hhh] = PHP_EOL . $html;
					// SITE_TEMPLATE_CODE_BODY <<<DYNAMIC>>>
					$this->fileContentDynamic[$this->componentCodeName . '_' . $tempName][$this->hhh . 'CUSTOM_ADMIN_TEMPLATE_CODE_BODY' . $this->hhh] = '';
				}
				$display[] = $tab . $this->_t(1) . "<?php  echo JHtml::_('bootstrap.endAccordion'); ?>";
				$display[] = $tab . "</div>";
				$display[] = $this->_t(2) . "</div>";
				$display[] = $this->_t(2) . "<?php echo JHtml::_('bootstrap.endTab'); ?>";
			}

			$display[] = PHP_EOL . $this->_t(1) . "<?php echo JHtml::_('bootstrap.endTabSet'); ?>";
			$display[] = $this->_t(1) . "</div>";
		}
		$display[] = "</div>";
		// return the display
		return PHP_EOL . implode(PHP_EOL, $display);
	}

	public function addCustomDashboardIcons(&$view, &$counter)
	{
		$icon = '';
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]) && isset($menu['dashboard_list']) && $menu['dashboard_list'] == 1 && $menu['before'] == $view['adminview'])
				{
					$type = ComponentbuilderHelper::imageInfo($menu['settings']->icon);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $menu['settings']->code] = $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName = $menu['settings']->name . '<br /><br />';
					$langKey = $this->langPrefix . '_DASHBOARD_' . $menu['settings']->CODE;
					// add to lang
					$this->setLangContent($this->lang, $langKey, $langName);
					// set icon
					if ($counter == 0)
					{
						$counter++;
						$icon .= "'" . $type . $menu['settings']->code . "'";
					}
					else
					{
						$counter++;
						$icon .= ", '" . $type . $menu['settings']->code . "'";
					}
				}
				elseif (!isset($this->customAdminAdded[$menu['settings']->code]) && isset($menu['dashboard_list']) && $menu['dashboard_list'] == 1 && empty($menu['before']))
				{
					$type = ComponentbuilderHelper::imageInfo($menu['settings']->icon);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $menu['settings']->code] = $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName = $menu['settings']->name . '<br /><br />';
					$langKey = $this->langPrefix . '_DASHBOARD_' . $menu['settings']->CODE;
					// add to lang
					$this->setLangContent($this->lang, $langKey, $langName);
					// set icon
					$this->lastCustomDashboardIcon[$nr] = ", '" . $type . $menu['settings']->code . "'";
				}
			}
		}
		// see if we should have custom menus
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				$nr = $nr + 100;
				$nameList = ComponentbuilderHelper::safeString($menu['name_code']);
				$nameUpper = ComponentbuilderHelper::safeString($menu['name_code'], 'U');
				if (isset($menu['dashboard_list']) && $menu['dashboard_list'] == 1 && $view['adminview'] == $menu['before'])
				{
					$type = ComponentbuilderHelper::imageInfo('images/' . $menu['icon']);
					if ($type)
					{
						// icon builder loader
						$this->iconBuilder[$type . "." . $nameList] = 'images/' . $menu['icon'];
					}
					else
					{
						$type = 'png';
					}
					// build lang
					$langName = $menu['name'] . '<br /><br />';
					$langKey = $this->langPrefix . '_DASHBOARD_' . $nameUpper;
					// add to lang
					$this->setLangContent($this->lang, $langKey, $langName);

					// if this is a link build the icon values with pipe
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						// set icon
						if ($counter == 0)
						{
							$counter++;
							$icon .= "'" . $type . "||" . $nameList . "||" . $menu['link'] . "'";
						}
						else
						{
							$counter++;
							$icon .= ", '" . $type . "||" . $nameList . "||" . $menu['link'] . "'";
						}
					}
					else
					{
						// set icon
						if ($counter == 0)
						{
							$counter++;
							$icon .= "'" . $type . "." . $nameList . "'";
						}
						else
						{
							$counter++;
							$icon .= ", '" . $type . "." . $nameList . "'";
						}
					}
				}
				elseif (isset($menu['dashboard_list']) && $menu['dashboard_list'] == 1 && empty($menu['before']))
				{
					$type = ComponentbuilderHelper::imageInfo('images/' . $menu['icon']);
					if ($type)
					{
						// icon builder loader
						$this->iconBuilder[$type . "." . $nameList] = 'images/' . $menu['icon'];
					}
					else
					{
						$type = 'png';
					}
					// build lang
					$langName = $menu['name'] . '<br /><br />';
					$langKey = $this->langPrefix . '_DASHBOARD_' . $nameUpper;
					// add to lang
					$this->setLangContent($this->lang, $langKey, $langName);

					// if this is a link build the icon values with pipe
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '" . $type . "||" . $nameList . "||" . $menu['link'] . "'";
					}
					else
					{
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '" . $type . "." . $nameList . "'";
					}
				}
			}
		}
		return $icon;
	}

	public function setSubMenus()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$menus = '';
			// main lang prefix
			$lang = $this->langPrefix . '_SUBMENU';
			// set the code name
			$codeName = $this->componentCodeName;
			// set default dashboard
			if (!ComponentbuilderHelper::checkString($this->dynamicDashboard))
			{
				$menus .= "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_DASHBOARD'), 'index.php?option=com_" . $codeName . "&view=" . $codeName . "', \$submenu === '" . $codeName . "');";
				$this->setLangContent($this->lang, $lang . '_DASHBOARD', 'Dashboard');
			}
			$catArray = array();
			foreach ($this->componentData->admin_views as $view)
			{
				// set custom menu
				$menus .= $this->addCustomSubMenu($view, $codeName, $lang);
				$nameSingle = ComponentbuilderHelper::safeString($view['settings']->name_single);
				$nameList = ComponentbuilderHelper::safeString($view['settings']->name_list);
				$nameUpper = ComponentbuilderHelper::safeString($view['settings']->name_list, 'U');
				if (isset($view['submenu']) && $view['submenu'] == 1)
				{
					// setup access defaults
					$tab = "";
					$coreLoad = false;
					if (isset($this->permissionCore[$nameSingle]))
					{
						$core = $this->permissionCore[$nameSingle];
						$coreLoad = true;
					}
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle, $this->permissionBuilder['global'][$core['core.access']]))
					{
						$menus .= PHP_EOL . $this->_t(2) . "if (\$user->authorise('" . $core['core.access'] . "', 'com_" . $codeName . "') && \$user->authorise('" . $nameSingle . ".submenu', 'com_" . $codeName . "'))";
						$menus .= PHP_EOL . $this->_t(2) . "{";
						// add tab to lines to follow
						$tab = $this->_t(1);
					}
					$menus .= PHP_EOL . $this->_t(2) . $tab . "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_" . $nameUpper . "'), 'index.php?option=com_" . $codeName . "&view=" . $nameList . "', \$submenu === '" . $nameList . "');";
					$this->setLangContent($this->lang, $lang . "_" . $nameUpper, $view['settings']->name_list);
					// check if category has another name
					if (isset($this->catOtherName[$nameList]) && ComponentbuilderHelper::checkArray($this->catOtherName[$nameList]))
					{
						$otherViews = $this->catOtherName[$nameList]['views'];
					}
					else
					{
						$otherViews = $nameList;
					}
					if (isset($this->categoryBuilder[$nameList]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$nameList]) && !in_array($otherViews, $catArray))
					{
						// get the extention array
						$_extetion_array = (array) explode('.', $this->categoryBuilder[$nameList]['extension']);
						// set the meny selection
						if (isset($_extetion_array[1]))
						{
							$_menu = "categories." . trim($_extetion_array[1]);
						}
						else
						{
							$_menu = "categories";
						}
						// now load the menus
						$menus .= PHP_EOL . $this->_t(2) . $tab . "JHtmlSidebar::addEntry(JText:" . ":_('" . $this->categoryBuilder[$nameList]['name'] . "'), 'index.php?option=com_categories&view=categories&extension=" . $this->categoryBuilder[$nameList]['extension'] . "', \$submenu === '" . $_menu ."');";
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle, $this->permissionBuilder['global'][$core['core.access']]))
					{
						$menus .= PHP_EOL . $this->_t(2) . "}";
					}
				}
				// set the Joomla cutstom fields options
				if (isset($view['joomla_fields']) && $view['joomla_fields'] == 1)
				{
					$menus .= PHP_EOL . $this->_t(2) . "if (JComponentHelper::isEnabled('com_fields'))";
					$menus .= PHP_EOL . $this->_t(2) . "{";
					$menus .= PHP_EOL . $this->_t(3) . "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_" . $nameUpper . "_FIELDS'), 'index.php?option=com_fields&context=com_" . $codeName . "." . $nameSingle . "', \$submenu === 'fields.fields');";
					$menus .= PHP_EOL . $this->_t(3) . "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_" . $nameUpper . "_FIELDS_GROUPS'), 'index.php?option=com_fields&view=groups&context=com_" . $codeName . "." . $nameSingle . "', \$submenu === 'fields.groups');";
					$menus .= PHP_EOL . $this->_t(2) . "}";
					$this->setLangContent($this->lang, $lang . "_" . $nameUpper . "_FIELDS", $view['settings']->name_list . ' Fields');
					$this->setLangContent($this->lang, $lang . "_" . $nameUpper . "_FIELDS_GROUPS", $view['settings']->name_list . ' Field Groups');
					// build uninstall script for fields
					$this->uninstallScriptBuilder[$nameSingle] = 'com_' . $codeName . '.' . $nameSingle;
					$this->uninstallScriptFields[$nameSingle] = $nameSingle;
				}
			}
			if (isset($this->lastCustomSubMenu) && ComponentbuilderHelper::checkArray($this->lastCustomSubMenu))
			{
				foreach ($this->lastCustomSubMenu as $menu)
				{
					$menus .= $menu;
				}
				unset($this->lastCustomSubMenu);
			}
			return $menus;
		}
		return false;
	}

	public function addCustomSubMenu(&$view, &$codeName, &$lang)
	{
		// see if we should have custom menus
		$custom = '';
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]))
				{
					if (($_custom = $this->setCustomAdminSubMenu($view, $codeName, $lang, $nr, $menu, 'customView')) !== false)
					{
						$custom .= $_custom;
					}
				}
			}
		}
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				if (($_custom = $this->setCustomAdminSubMenu($view, $codeName, $lang, $nr, $menu, 'customMenu')) !== false)
				{
					$custom .= $_custom;
				}
			}
		}
		return $custom;
	}

	public function setCustomAdminSubMenu(&$view, &$codeName, &$lang, &$nr, &$menu, $type)
	{
		if ($type === 'customMenu')
		{
			$name = $menu['name'];
			$nameSingle = ComponentbuilderHelper::safeString($menu['name']);
			$nameList = ComponentbuilderHelper::safeString($menu['name']);
			$nameUpper = ComponentbuilderHelper::safeString($menu['name'], 'U');
		}
		elseif ($type === 'customView')
		{
			$name = $menu['settings']->name;
			$nameSingle = $menu['settings']->code;
			$nameList = $menu['settings']->code;
			$nameUpper = $menu['settings']->CODE;
		}
		if (isset($menu['submenu']) && $menu['submenu'] == 1 && $view['adminview'] == $menu['before'])
		{
			// setup access defaults
			$tab = "";

			$coreLoad = false;
			if (isset($this->permissionCore[$nameSingle]))
			{
				$core = $this->permissionCore[$nameSingle];
				$coreLoad = true;
			}
			$custom = '';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle, $this->permissionBuilder['global'][$core['core.access']]))
			{
				$custom .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Access control (" . $core['core.access'] . " && " . $nameSingle . ".submenu).";
				$custom .= PHP_EOL . $this->_t(2) . "if (\$user->authorise('" . $core['core.access'] . "', 'com_" . $codeName . "') && \$user->authorise('" . $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$custom .= PHP_EOL . $this->_t(2) . "{";
				// add tab to lines to follow
				$tab = $this->_t(1);
			}
			else
			{
				$custom .= PHP_EOL . $this->_t(2) . "//" . $this->setLine(__LINE__) . " Access control (" . $nameSingle . ".submenu).";
				$custom .= PHP_EOL . $this->_t(2) . "if (\$user->authorise('" . $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$custom .= PHP_EOL . $this->_t(2) . "{";
				// add tab to lines to follow
				$tab = $this->_t(1);
			}
			if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
			{

				$this->setLangContent($this->lang, $lang . '_' . $nameUpper, $name);
				// add custom menu
				$custom .= PHP_EOL . $this->_t(2) . $tab . "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_" . $nameUpper . "'), '" . $menu['link'] . "', \$submenu === '" . $nameList . "');";
			}
			else
			{
				$this->setLangContent($this->lang, $lang . '_' . $nameUpper, $name);
				// add custom menu
				$custom .= PHP_EOL . $this->_t(2) . $tab . "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_" . $nameUpper . "'), 'index.php?option=com_" . $codeName . "&view=" . $nameList . "', \$submenu === '" . $nameList . "');";
			}
			// check if the item has permissions.
			$custom .= PHP_EOL . $this->_t(2) . "}";

			return $custom;
		}
		elseif (isset($menu['submenu']) && $menu['submenu'] == 1 && empty($menu['before']))
		{
			// setup access defaults
			$tab = "";
			$nameSingle = ComponentbuilderHelper::safeString($name);
			$coreLoad = false;
			if (isset($this->permissionCore[$nameSingle]))
			{
				$core = $this->permissionCore[$nameSingle];
				$coreLoad = true;
			}
			$this->lastCustomSubMenu[$nr] = '';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle, $this->permissionBuilder['global'][$core['core.access']]))
			{
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . $this->_t(2) . "if (\$user->authorise('" . $core['core.access'] . "', 'com_" . $codeName . "') && \$user->authorise('" . $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . $this->_t(2) . "{";
				// add tab to lines to follow
				$tab = $this->_t(1);
			}
			else
			{
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . $this->_t(2) . "if (\$user->authorise('" . $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . $this->_t(2) . "{";
				// add tab to lines to follow
				$tab = $this->_t(1);
			}
			if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
			{
				$this->setLangContent($this->lang, $lang . '_' . $nameUpper, $name);
				// add custom menu
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . $this->_t(2) . $tab . "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_" . $nameUpper . "'), '" . $menu['link'] . "', \$submenu === '" . $nameList . "');";
			}
			else
			{
				$this->setLangContent($this->lang, $lang . '_' . $nameUpper, $name);
				// add custom menu
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . $this->_t(2) . $tab . "JHtmlSidebar::addEntry(JText:" . ":_('" . $lang . "_" . $nameUpper . "'), 'index.php?option=com_" . $codeName . "&view=" . $nameList . "', \$submenu === '" . $nameList . "');";
			}
			// check if the item has permissions.
			$this->lastCustomSubMenu[$nr] .= PHP_EOL . $this->_t(2) . "}";
		}
		return false;
	}

	public function setMainMenus()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$menus = '';
			// main lang prefix
			$lang = $this->langPrefix . '_MENU';
			// set the code name
			$codeName = $this->componentCodeName;
			// default prefix is none
			$prefix = '';
			// check if local is set
			if (isset($this->componentData->add_menu_prefix) && is_numeric($this->componentData->add_menu_prefix))
			{
				// set main menu prefix switch
				$addPrefix = $this->componentData->add_menu_prefix;
				if ($addPrefix == 1 && isset($this->componentData->menu_prefix) && ComponentbuilderHelper::checkString($this->componentData->menu_prefix))
				{
					$prefix = trim($this->componentData->menu_prefix) . ' ';
				}
			}
			else
			{
				// set main menu prefix switch
				$addPrefix = $this->params->get('add_menu_prefix', 1);
				if ($addPrefix == 1)
				{
					$prefix = trim($this->params->get('menu_prefix', '&#187;')) . ' ';
				}
			}
			// add the prefix
			if ($addPrefix == 1)
			{
				$this->setLangContent('adminsys', $lang, $prefix . $this->componentData->name);
			}
			else
			{
				$this->setLangContent('adminsys', $lang, $this->componentData->name);
			}
			// loop over the admin views
			foreach ($this->componentData->admin_views as $view)
			{
				// set custom menu
				$menus .= $this->addCustomMainMenu($view, $codeName, $lang);
				if (isset($view['mainmenu']) && $view['mainmenu'] == 1)
				{
					$nameList = ComponentbuilderHelper::safeString($view['settings']->name_list);
					$nameUpper = ComponentbuilderHelper::safeString($view['settings']->name_list, 'U');
					$menus .= PHP_EOL . $this->_t(3) . '<menu option="com_' . $codeName . '" view="' . $nameList . '">' . $lang . '_' . $nameUpper . '</menu>';
					$this->setLangContent('adminsys', $lang . '_' . $nameUpper, $view['settings']->name_list);
				}
			}
			if (isset($this->lastCustomMainMenu) && ComponentbuilderHelper::checkArray($this->lastCustomMainMenu))
			{
				foreach ($this->lastCustomMainMenu as $menu)
				{
					$menus .= $menu;
				}
				unset($this->lastCustomMainMenu);
			}
			return $menus;
		}
		return false;
	}

	public function addCustomMainMenu(&$view, &$codeName, &$lang)
	{
		$customMenu = '';
		// see if we should have custom admin views
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]))
				{
					if (isset($menu['mainmenu']) && $menu['mainmenu'] == 1 && $view['adminview'] == $menu['before'])
					{
						$this->setLangContent('adminsys', $lang . '_' . $menu['settings']->CODE, $menu['settings']->name);
						// add custom menu
						$customMenu .= PHP_EOL . $this->_t(3) . '<menu option="com_' . $codeName . '" view="' . $menu['settings']->code . '">' . $lang . '_' . $menu['settings']->CODE . '</menu>';
					}
					elseif (isset($menu['mainmenu']) && $menu['mainmenu'] == 1 && empty($menu['before']))
					{
						$this->setLangContent('adminsys', $lang . '_' . $menu['settings']->CODE, $menu['settings']->name);
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL . $this->_t(3) . '<menu option="com_' . $codeName . '" view="' . $menu['settings']->code . '">' . $lang . '_' . $menu['settings']->CODE . '</menu>';
					}
				}
			}
		}
		// see if we should have custom menus
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				$nr = $nr + 100;
				if (isset($menu['mainmenu']) && $menu['mainmenu'] == 1 && $view['adminview'] == $menu['before'])
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList = ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper = ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->setLangContent('adminsys', $lang . '_' . $nameUpper, $menu['name']);
						// sanitize url
						if (strpos($menu['link'], 'http') === false)
						{
							$menu['link'] = str_replace('/administrator/index.php?', '', $menu['link']);
							$menu['link'] = str_replace('administrator/index.php?', '', $menu['link']);
							// check if the index is still there
							if (strpos($menu['link'], 'index.php?') !== false)
							{
								$menu['link'] = str_replace('/index.php?', '', $menu['link']);
								$menu['link'] = str_replace('index.php?', '', $menu['link']);
							}
						}
						// urlencode
						$menu['link'] = htmlspecialchars($menu['link'], ENT_XML1, 'UTF-8');
						// add custom menu
						$customMenu .= PHP_EOL . $this->_t(3) . '<menu link="' . $menu['link'] . '">' . $lang . '_' . $nameUpper . '</menu>';
					}
					else
					{
						$nameList = ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper = ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->setLangContent('adminsys', $lang . '_' . $nameUpper, $menu['name']);
						// add custom menu
						$customMenu .= PHP_EOL . $this->_t(3) . '<menu option="com_' . $codeName . '" view="' . $nameList . '">' . $lang . '_' . $nameUpper . '</menu>';
					}
				}
				elseif (isset($menu['mainmenu']) && $menu['mainmenu'] == 1 && empty($menu['before']))
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList = ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper = ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->setLangContent('adminsys', $lang . '_' . $nameUpper, $menu['name']);
						// sanitize url
						if (strpos($menu['link'], 'http') === false)
						{
							$menu['link'] = str_replace('/administrator/index.php?', '', $menu['link']);
							$menu['link'] = str_replace('administrator/index.php?', '', $menu['link']);
							// check if the index is still there
							if (strpos($menu['link'], 'index.php?') !== false)
							{
								$menu['link'] = str_replace('/index.php?', '', $menu['link']);
								$menu['link'] = str_replace('index.php?', '', $menu['link']);
							}
						}
						// urlencode
						$menu['link'] = htmlspecialchars($menu['link'], ENT_XML1, 'UTF-8');
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL . $this->_t(3) . '<menu link="' . $menu['link'] . '">' . $lang . '_' . $nameUpper . '</menu>';
					}
					else
					{
						$nameList = ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper = ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->setLangContent('adminsys', $lang . '_' . $nameUpper, $menu['name']);
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL . $this->_t(3) . '<menu option="com_' . $codeName . '" view="' . $nameList . '">' . $lang . '_' . $nameUpper . '</menu>';
					}
				}
			}
		}
		return $customMenu;
	}

	public function setConfigFieldsets($timer = 0)
	{
		// main lang prefix
		$lang = $this->langPrefix . '_CONFIG';
		if (1 == $timer) // this is before the admin views are build
		{
			// start loading Global params
			$autorName = ComponentbuilderHelper::htmlEscape($this->componentData->author);
			$autorEmail = ComponentbuilderHelper::htmlEscape($this->componentData->email);
			$this->extensionsParams[] = '"autorName":"' . $autorName . '","autorEmail":"' . $autorEmail . '"';
			// set the custom fields
			if (isset($this->componentData->config) && ComponentbuilderHelper::checkArray($this->componentData->config))
			{
				// set component code name
				$component = $this->componentCodeName;
				$viewName = 'config';
				$listViewName = 'configs';
				// set place holders
				$placeholders = array();
				$placeholders[$this->hhh . 'component' . $this->hhh] = $this->componentCodeName;
				$placeholders[$this->hhh . 'Component' . $this->hhh] = ComponentbuilderHelper::safeString($this->componentData->name_code, 'F');
				$placeholders[$this->hhh . 'COMPONENT' . $this->hhh] = ComponentbuilderHelper::safeString($this->componentData->name_code, 'U');
				$placeholders[$this->hhh . 'view' . $this->hhh] = $viewName;
				$placeholders[$this->hhh . 'views' . $this->hhh] = $listViewName;
				$placeholders[$this->bbb . 'component' . $this->ddd] = $this->componentCodeName;
				$placeholders[$this->bbb . 'Component' . $this->ddd] = $placeholders[$this->hhh . 'Component' . $this->hhh];
				$placeholders[$this->bbb . 'COMPONENT' . $this->ddd] = $placeholders[$this->hhh . 'COMPONENT' . $this->hhh];
				$placeholders[$this->bbb . 'view' . $this->ddd] = $viewName;
				$placeholders[$this->bbb . 'views' . $this->ddd] = $listViewName;
				// load the global placeholders
				if (ComponentbuilderHelper::checkArray($this->globalPlaceholders))
				{
					foreach ($this->globalPlaceholders as $globalPlaceholder => $gloabalValue)
					{
						$placeholders[$globalPlaceholder] = $gloabalValue;
					}
				}
				$view = '';
				$viewType = 0;
				// set the custom table key
				$dbkey = 'g';
				// Trigger Event: jcb_ce_onBeforeSetConfigFieldsets
				$this->triggerEvent('jcb_ce_onBeforeSetConfigFieldsets', array(&$this->componentContext, &$timer, &$this->configFieldSets, &$this->configFieldSetsCustomField, &$this->componentData->config, &$this->extensionsParams, &$placeholders));
				// build the config fields
				foreach ($this->componentData->config as $field)
				{
					// check the field builder type
					if ($this->fieldBuilderType == 1)
					{
						// string manipulation
						$xmlField = $this->setDynamicField($field, $view, $viewType, $lang, $viewName, $listViewName, $placeholders, $dbkey, false);
					}
					else
					{
						// simpleXMLElement class
						$newxmlField = $this->setDynamicField($field, $view, $viewType, $lang, $viewName, $listViewName, $placeholders, $dbkey, false);
						if (isset($newxmlField->fieldXML))
						{
							$xmlField = dom_import_simplexml($newxmlField->fieldXML);
							$xmlField = PHP_EOL . $this->_t(1) . "<!--" . $this->setLine(__LINE__) . " " . $newxmlField->comment . ' -->' . PHP_EOL . $this->_t(1) . $this->xmlPrettyPrint($xmlField, 'field');
						}
					}
					// make sure the xml is set and a string
					if (isset($xmlField) && ComponentbuilderHelper::checkString($xmlField))
					{
						$this->configFieldSetsCustomField[$field['tabname']][] = $xmlField;
						// set global params to db on install
						$fieldName = ComponentbuilderHelper::safeString($this->setPlaceholders(ComponentbuilderHelper::getBetween($xmlField, 'name="', '"'), $placeholders));
						$fieldDefault = $this->setPlaceholders(ComponentbuilderHelper::getBetween($xmlField, 'default="', '"'), $placeholders);
						if (isset($field['custom_value']) && ComponentbuilderHelper::checkString($field['custom_value']))
						{
							// add array if found
							if ((strpos($field['custom_value'], '["') !== false) && (strpos($field['custom_value'], '"]') !== false))
							{
								// load the Global checkin defautls
								$this->extensionsParams[] = '"' . $fieldName . '":' . $field['custom_value'];
							}
							else
							{
								// load the Global checkin defautls
								$this->extensionsParams[] = '"' . $fieldName . '":"' . $field['custom_value'] . '"';
							}
						}
						elseif (ComponentbuilderHelper::checkString($fieldDefault))
						{
							// load the Global checkin defautls
							$this->extensionsParams[] = '"' . $fieldName . '":"' . $fieldDefault . '"';
						}
					}
				}
			}
			// first run we must set the globals
			$this->setGlobalConfigFieldsets($lang, $autorName, $autorEmail);
			$this->setSiteControlConfigFieldsets($lang);
		}
		elseif (2 == $timer) // this is after the admin views are build
		{
			// Trigger Event: jcb_ce_onBeforeSetConfigFieldsets
			$this->triggerEvent('jcb_ce_onBeforeSetConfigFieldsets', array(&$this->componentContext, &$timer, &$this->configFieldSets, &$this->configFieldSetsCustomField, &$this->componentData->config, &$this->extensionsParams, &$this->placeholders));
			// these field sets can only be added after admin view is build
			$this->setGroupControlConfigFieldsets($lang);
			// these can be added anytime really (but looks best after groups
			$this->setUikitConfigFieldsets($lang);
			$this->setGooglechartConfigFieldsets($lang);
			$this->setEmailHelperConfigFieldsets($lang);
			$this->setEncryptionConfigFieldsets($lang);
			// these are the coustom settings
			$this->setCustomControlConfigFieldsets($lang);
		}
		// Trigger Event: jcb_ce_onAfterSetConfigFieldsets
		$this->triggerEvent('jcb_ce_onAfterSetConfigFieldsets', array(&$this->componentContext, &$timer, &$this->configFieldSets, &$this->configFieldSetsCustomField, &$this->extensionsParams, &$this->frontEndParams, &$this->placeholders));
	}

	public function setSiteControlConfigFieldsets($lang)
	{
		$front_end = array();
		// do quick build of front-end views
		if (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views))
		{
			// load the names only to link the page params
			foreach ($this->componentData->site_views as $siteView)
			{
				// now load the view name to the front-end array
				$front_end[] = $siteView['settings']->name;
			}
		}

		// add frontend view stuff including menus
		if (isset($this->configFieldSetsCustomField) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField))
		{
			foreach ($this->configFieldSetsCustomField as $tab => &$tabFields)
			{
				$tabCode = ComponentbuilderHelper::safeString($tab) . '_custom_config';
				$tabUpper = ComponentbuilderHelper::safeString($tab, 'U');
				$tabLower = ComponentbuilderHelper::safeString($tab);
				// load the request id setters for menu views
				$viewRequest = 'name="' . $tabLower . '_request_id';
				foreach ($tabFields as $et => $id_field)
				{
					if (strpos($id_field, $viewRequest) !== false)
					{
						$this->setRequestValues($tabLower, $id_field, $viewRequest, 'id', 'hasIdRequest');
						unset($tabFields[$et]);
					}
					elseif (strpos($id_field, '_request_id') !== false)
					{
						// not loaded to a tab "view" name
						$_viewRequest = ComponentbuilderHelper::getBetween($id_field, 'name="', '_request_id');
						$searchIdKe = 'name="' . $_viewRequest . '_request_id';
						$this->setRequestValues($_viewRequest, $id_field, $searchIdKe, 'id', 'hasIdRequest');
						unset($tabFields[$et]);
					}
				}
				// load the request catid setters for menu views
				$viewRequestC = 'name="' . $tabLower . '_request_catid';
				foreach ($tabFields as $ci => $catid_field)
				{
					if (strpos($catid_field, $viewRequestC) !== false)
					{

						$this->setRequestValues($tabLower, $catid_field, $viewRequestC, 'catid', 'hasCatIdRequest');
						unset($tabFields[$ci]);
					}
					elseif (strpos($catid_field, '_request_catid') !== false)
					{
						// not loaded to a tab "view" name
						$_viewRequestC = ComponentbuilderHelper::getBetween($catid_field, 'name="', '_request_catid');
						$searchCatidKe = 'name="' . $_viewRequestC . '_request_catid';
						$this->setRequestValues($_viewRequestC, $catid_field, $searchCatidKe, 'catid', 'hasCatIdRequest');
						unset($tabFields[$ci]);
					}
				}
				// load the global menu setters for single fields
				$menuSetter = $tabLower . '_menu';
				$pageSettings = array();
				foreach ($tabFields as $ct => $field)
				{
					if (strpos($field, $menuSetter) !== false)
					{
						// set the values needed to insure route is done correclty
						$this->hasMenuGlobal[$tabLower] = $menuSetter;
					}
					elseif (strpos($field, '_menu"') !== false)
					{
						// not loaded to a tab "view" name
						$_tabLower = ComponentbuilderHelper::getBetween($field, 'name="', '_menu"');
						// set the values needed to insure route is done correclty
						$this->hasMenuGlobal[$_tabLower] = $_tabLower . '_menu';
					}
					else
					{
						$pageSettings[$ct] = $field;
					}
				}
				// insure we load the needed params
				if (in_array($tab, $front_end))
				{
					$this->frontEndParams[$tab] = $pageSettings;
				}
			}
		}
	}

	protected function setRequestValues($view, $field, $search, $target, $store)
	{
		$key = ComponentbuilderHelper::getBetween($field, $search, '"');
		if (!ComponentbuilderHelper::checkString($key))
		{
			// is not having special var
			$key = $target;
			// update field
			$field = str_replace($search . '"', 'name="' . $key . '"', $field);
		}
		else
		{
			// update field
			$field = str_replace($search . $key . '"', 'name="' . $key . '"', $field);
		}
		if (!isset($this->{$store}[$view]))
		{
			$this->{$store}[$view] = array();
		}
		// set the values needed for view requests to be made
		$this->{$store}[$view][$key] = $field;
	}

	public function setCustomControlConfigFieldsets($lang)
	{
		// add custom new global fields set
		if (isset($this->configFieldSetsCustomField) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField))
		{
			foreach ($this->configFieldSetsCustomField as $tab => $tabFields)
			{
				$tabCode = ComponentbuilderHelper::safeString($tab) . '_custom_config';
				$tabUpper = ComponentbuilderHelper::safeString($tab, 'U');
				$tabLower = ComponentbuilderHelper::safeString($tab);
				// remove display targeted fields
				$bucket = array();
				foreach ($tabFields as $tabField)
				{
					$display = ComponentbuilderHelper::getBetween($tabField, 'display="', '"');
					if (!ComponentbuilderHelper::checkString($display) || $display === 'config')
					{
						// remove this display since it is not used in Joomla
						$bucket[] = str_replace('display="config"', '', $tabField);
					}
				}
				// only add the tab if it has values
				if (ComponentbuilderHelper::checkArray($bucket))
				{
					// setup lang
					$this->setLangContent($this->lang, $lang . '_' . $tabUpper, $tab);
					// start field set
					$this->configFieldSets[] = $this->_t(1) . "<fieldset";
					$this->configFieldSets[] = $this->_t(2) . 'name="' . $tabCode . '"';
					$this->configFieldSets[] = $this->_t(2) . 'label="' . $lang . '_' . $tabUpper . '">';
					// set the fields
					$this->configFieldSets[] = implode("", $bucket);
					// close field set
					$this->configFieldSets[] = $this->_t(1) . "</fieldset>";
				}
				// remove after loading
				unset($this->configFieldSetsCustomField[$tab]);
			}
		}
	}

	public function setGroupControlConfigFieldsets($lang)
	{
		// start loading Group control params if needed
		if (isset($this->setGroupControl) && ComponentbuilderHelper::checkArray($this->setGroupControl))
		{
			// start building field set for config
			$this->configFieldSets[] = $this->_t(1) . "<fieldset";
			$this->configFieldSets[] = $this->_t(2) . 'name="group_config"';
			$this->configFieldSets[] = $this->_t(2) . 'label="' . $lang . '_GROUPS_LABEL"';
			$this->configFieldSets[] = $this->_t(2) . 'description="' . $lang . '_GROUPS_DESC">';
			// setup lang
			$this->setLangContent($this->lang, $lang . '_GROUPS_LABEL', "Target Groups");
			$this->setLangContent($this->lang, $lang . '_GROUPS_DESC', "The Parameters for the targeted groups are set here.");
			$this->setLangContent($this->lang, $lang . '_TARGET_GROUP_DESC', "Set the group/s being targeted by this user type.");

			foreach ($this->setGroupControl as $selector => $label)
			{
				$this->configFieldSets[] = $this->_t(2) . '<field name="' . $selector . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="usergroup"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $label . '"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_TARGET_GROUP_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'multiple="true"';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				// set params defaults
				$this->extensionsParams[] = '"' . $selector . '":["2"]';
			}
			// add custom Target Groups fields
			if (isset($this->configFieldSetsCustomField['Target Groups']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Target Groups']))
			{
				$this->configFieldSets[] = implode("", $this->configFieldSetsCustomField['Target Groups']);
				unset($this->configFieldSetsCustomField['Target Groups']);
			}
			// close that fieldse
			$this->configFieldSets[] = $this->_t(1) . "</fieldset>";
		}
	}

	/**
	 * @param $lang
	 * @param $autorName
	 * @param $autorEmail
	 */
	public function setGlobalConfigFieldsets($lang, $autorName, $autorEmail)
	{
		// set component name
		$component = $this->componentCodeName;

		// start building field set for config
		$this->configFieldSets[] = '<fieldset';
		$this->configFieldSets[] = $this->_t(2) . 'addrulepath="/administrator/components/com_' . $component . '/models/rules"';
		$this->configFieldSets[] = $this->_t(2) . 'addfieldpath="/administrator/components/com_' . $component . '/models/fields"';
		$this->configFieldSets[] = $this->_t(2) . 'name="global_config"';
		$this->configFieldSets[] = $this->_t(2) . 'label="' . $lang . '_GLOBAL_LABEL"';
		$this->configFieldSets[] = $this->_t(2) . 'description="' . $lang . '_GLOBAL_DESC">';
		// setup lang
		$this->setLangContent($this->lang, $lang . '_GLOBAL_LABEL', "Global");
		$this->setLangContent($this->lang, $lang . '_GLOBAL_DESC', "The Global Parameters");
		// add auto checin if required
		if ($this->addCheckin)
		{
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . 'name="check_in"';
			$this->configFieldSets[] = $this->_t(3) . 'type="list"';
			$this->configFieldSets[] = $this->_t(3) . 'default="0"';
			$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_CHECK_TIMER_LABEL"';
			$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_CHECK_TIMER_DESC">';
			$this->configFieldSets[] = $this->_t(3) . '<option';
			$this->configFieldSets[] = $this->_t(4) . 'value="-5 hours">' . $lang . '_CHECK_TIMER_OPTION_ONE</option>';
			$this->configFieldSets[] = $this->_t(3) . '<option';
			$this->configFieldSets[] = $this->_t(4) . 'value="-12 hours">' . $lang . '_CHECK_TIMER_OPTION_TWO</option>';
			$this->configFieldSets[] = $this->_t(3) . '<option';
			$this->configFieldSets[] = $this->_t(4) . 'value="-1 day">' . $lang . '_CHECK_TIMER_OPTION_THREE</option>';
			$this->configFieldSets[] = $this->_t(3) . '<option';
			$this->configFieldSets[] = $this->_t(4) . 'value="-2 day">' . $lang . '_CHECK_TIMER_OPTION_FOUR</option>';
			$this->configFieldSets[] = $this->_t(3) . '<option';
			$this->configFieldSets[] = $this->_t(4) . 'value="-1 week">' . $lang . '_CHECK_TIMER_OPTION_FIVE</option>';
			$this->configFieldSets[] = $this->_t(3) . '<option';
			$this->configFieldSets[] = $this->_t(4) . 'value="0">' . $lang . '_CHECK_TIMER_OPTION_SIX</option>';
			$this->configFieldSets[] = $this->_t(2) . "</field>";
			$this->configFieldSets[] = $this->_t(2) . '<field type="spacer" name="spacerAuthor" hr="true" />';
			// setup lang
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_LABEL', "Check in timer");
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_DESC', "Set the intervals for the auto checkin fuction of tables that checks out the items to an user.");
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_OPTION_ONE', "Every five hours");
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_OPTION_TWO', "Every twelve hours");
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_OPTION_THREE', "Once a day");
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_OPTION_FOUR', "Every second day");
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_OPTION_FIVE', "Once a week");
			$this->setLangContent($this->lang, $lang . '_CHECK_TIMER_OPTION_SIX', "Never");
			// load the Global checkin defautls
			$this->extensionsParams[] = '"check_in":"-1 day"';
		}
		// set history control
		if ($this->setTagHistory)
		{
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . 'name="save_history"';
			$this->configFieldSets[] = $this->_t(3) . 'type="radio"';
			$this->configFieldSets[] = $this->_t(3) . 'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = $this->_t(3) . 'default="1"';
			$this->configFieldSets[] = $this->_t(3) . 'label="JGLOBAL_SAVE_HISTORY_OPTIONS_LABEL"';
			$this->configFieldSets[] = $this->_t(3) . 'description="JGLOBAL_SAVE_HISTORY_OPTIONS_DESC"';
			$this->configFieldSets[] = $this->_t(3) . ">";
			$this->configFieldSets[] = $this->_t(3) . '<option value="1">JYES</option>';
			$this->configFieldSets[] = $this->_t(3) . '<option value="0">JNO</option>';
			$this->configFieldSets[] = $this->_t(2) . "</field>";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . 'name="history_limit"';
			$this->configFieldSets[] = $this->_t(3) . 'type="text"';
			$this->configFieldSets[] = $this->_t(3) . 'filter="integer"';
			$this->configFieldSets[] = $this->_t(3) . 'label="JGLOBAL_HISTORY_LIMIT_OPTIONS_LABEL"';
			$this->configFieldSets[] = $this->_t(3) . 'description="JGLOBAL_HISTORY_LIMIT_OPTIONS_DESC"';
			$this->configFieldSets[] = $this->_t(3) . 'default="10"';
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . '<field type="spacer" name="spacerHistory" hr="true" />';
			// load the Global checkin defautls
			$this->extensionsParams[] = '"save_history":"1","history_limit":"10"';
		}
		// add custom global fields
		if (isset($this->configFieldSetsCustomField['Global']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Global']))
		{
			$this->configFieldSets[] = implode("", $this->configFieldSetsCustomField['Global']);
			unset($this->configFieldSetsCustomField['Global']);
		}
		// set the author details
		$this->configFieldSets[] = $this->_t(2) . '<field name="autorTitle"';
		$this->configFieldSets[] = $this->_t(3) . 'type="spacer"';
		$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_AUTHOR"';
		$this->configFieldSets[] = $this->_t(2) . "/>";
		$this->configFieldSets[] = $this->_t(2) . '<field name="autorName"';
		$this->configFieldSets[] = $this->_t(3) . 'type="text"';
		$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_AUTHOR_NAME_LABEL"';
		$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_AUTHOR_NAME_DESC"';
		$this->configFieldSets[] = $this->_t(3) . 'size="60"';
		$this->configFieldSets[] = $this->_t(3) . 'default="' . $autorName . '"';
		$this->configFieldSets[] = $this->_t(3) . 'readonly="true"';
		$this->configFieldSets[] = $this->_t(3) . 'class="readonly"';
		$this->configFieldSets[] = $this->_t(2) . "/>";
		$this->configFieldSets[] = $this->_t(2) . '<field name="autorEmail"';
		$this->configFieldSets[] = $this->_t(3) . 'type="email"';
		$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_AUTHOR_EMAIL_LABEL"';
		$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_AUTHOR_EMAIL_DESC"';
		$this->configFieldSets[] = $this->_t(3) . 'size="60"';
		$this->configFieldSets[] = $this->_t(3) . 'default="' . $autorEmail . '"';
		$this->configFieldSets[] = $this->_t(3) . 'readonly="true"';
		$this->configFieldSets[] = $this->_t(3) . 'class="readonly"';
		$this->configFieldSets[] = $this->_t(2) . "/>";
		// setup lang
		$this->setLangContent($this->lang, $lang . '_AUTHOR', "Author Info");
		$this->setLangContent($this->lang, $lang . '_AUTHOR_NAME_LABEL', "Author Name");
		$this->setLangContent($this->lang, $lang . '_AUTHOR_NAME_DESC', "The name of the author of this component.");
		$this->setLangContent($this->lang, $lang . '_AUTHOR_EMAIL_LABEL', "Author Email");
		$this->setLangContent($this->lang, $lang . '_AUTHOR_EMAIL_DESC', "The email address of the author of this component.");
		// set if contributors were added
		$langCont = $lang . '_CONTRIBUTOR';
		if (isset($this->addContributors) && $this->addContributors && isset($this->componentData->contributors) && ComponentbuilderHelper::checkArray($this->componentData->contributors))
		{
			foreach ($this->componentData->contributors as $counter => $contributor)
			{
				// make sure we dont use 0
				$counter++;
				// get the word for this number
				$COUNTER = ComponentbuilderHelper::safeString($counter, 'U');
				// set the dynamic values
				$cbTitle = htmlspecialchars($contributor['title'], ENT_XML1, 'UTF-8');
				$cbName = htmlspecialchars($contributor['name'], ENT_XML1, 'UTF-8');
				$cbEmail = htmlspecialchars($contributor['email'], ENT_XML1, 'UTF-8');
				$cbWebsite = htmlspecialchars($contributor['website'], ENT_XML1, 'UTF-8'); // ComponentbuilderHelper::htmlEscape($contributor['website']);
				// load to the $fieldsets
				$this->configFieldSets[] = $this->_t(2) . '<field type="spacer" name="spacerContributor' . $counter . '" hr="true" />';
				$this->configFieldSets[] = $this->_t(2) . '<field name="contributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="spacer"';
				$this->configFieldSets[] = $this->_t(3) . 'class="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_' . $COUNTER . '"';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="titleContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_TITLE_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_TITLE_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default="' . $cbTitle . '"';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="nameContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_NAME_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_NAME_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default="' . $cbName . '"';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="emailContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="email"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_EMAIL_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_EMAIL_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default="' . $cbEmail . '"';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="linkContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="url"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_LINK_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_LINK_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default="' . $cbWebsite . '"';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="useContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="list"';
				$this->configFieldSets[] = $this->_t(3) . 'default="' . (int) $contributor['use'] . '"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_USE_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_USE_DESC">';
				$this->configFieldSets[] = $this->_t(3) . '<option value="0">' . $langCont . '_USE_NONE</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="1">' . $langCont . '_USE_EMAIL</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="2">' . $langCont . '_USE_WWW</option>';
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="showContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="list"';
				$this->configFieldSets[] = $this->_t(3) . 'default="' . (int) $contributor['show'] . '"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_SHOW_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_SHOW_DESC">';
				$this->configFieldSets[] = $this->_t(3) . '<option value="0">' . $langCont . '_SHOW_NONE</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="1">' . $langCont . '_SHOW_BACK</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="2">' . $langCont . '_SHOW_FRONT</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="3">' . $langCont . '_SHOW_ALL</option>';
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				// add the contributor
				$this->theContributors .= PHP_EOL . $this->_t(1) . "@" . strtolower($contributor['title']) . $this->_t(2) . $contributor['name'] . ' <' . $contributor['website'] . '>';
				// setup lang
				$Counter = ComponentbuilderHelper::safeString($counter, 'Ww');
				$this->setLangContent($this->lang, $langCont . '_' . $COUNTER, "Contributor " . $Counter);
				// load the Global checkin defautls
				$this->extensionsParams[] = '"titleContributor' . $counter . '":"' . $cbTitle . '"';
				$this->extensionsParams[] = '"nameContributor' . $counter . '":"' . $cbName . '"';
				$this->extensionsParams[] = '"emailContributor' . $counter . '":"' . $cbEmail . '"';
				$this->extensionsParams[] = '"linkContributor' . $counter . '":"' . $cbWebsite . '"';
				$this->extensionsParams[] = '"useContributor' . $counter . '":"' . (int) $contributor['use'] . '"';
				$this->extensionsParams[] = '"showContributor' . $counter . '":"' . (int) $contributor['show'] . '"';
			}
		}
		// add more contributors if required
		if (1 == $this->componentData->emptycontributors)
		{
			if (isset($counter))
			{
				$min = $counter + 1;
				unset($counter);
			}
			else
			{
				$min = 1;
			}
			$max = $min + $this->componentData->number - 1;
			$moreContributerFields = range($min, $max, 1);
			foreach ($moreContributerFields as $counter)
			{
				$COUNTER = ComponentbuilderHelper::safeString($counter, 'U');

				$this->configFieldSets[] = $this->_t(2) . '<field type="spacer" name="spacerContributor' . $counter . '" hr="true" />';
				$this->configFieldSets[] = $this->_t(2) . '<field name="contributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="spacer"';
				$this->configFieldSets[] = $this->_t(3) . 'class="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_' . $COUNTER . '"';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="titleContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_TITLE_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_TITLE_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default=""';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="nameContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_NAME_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_NAME_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default=""';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="emailContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="email"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_EMAIL_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_EMAIL_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default=""';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="linkContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="url"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_LINK_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_LINK_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default=""';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="useContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="list"';
				$this->configFieldSets[] = $this->_t(3) . 'default="0"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_USE_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_USE_DESC">';
				$this->configFieldSets[] = $this->_t(3) . '<option value="0">' . $langCont . '_USE_NONE</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="1">' . $langCont . '_USE_EMAIL</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="2">' . $langCont . '_USE_WWW</option>';
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				$this->configFieldSets[] = $this->_t(2) . '<field name="showContributor' . $counter . '"';
				$this->configFieldSets[] = $this->_t(3) . 'type="list"';
				$this->configFieldSets[] = $this->_t(3) . 'default="0"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $langCont . '_SHOW_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $langCont . '_SHOW_DESC">';
				$this->configFieldSets[] = $this->_t(3) . '<option value="0">' . $langCont . '_SHOW_NONE</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="1">' . $langCont . '_SHOW_BACK</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="2">' . $langCont . '_SHOW_FRONT</option>';
				$this->configFieldSets[] = $this->_t(3) . '<option value="3">' . $langCont . '_SHOW_ALL</option>';
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				// setup lang
				$Counter = ComponentbuilderHelper::safeString($counter, 'Ww');
				$this->setLangContent($this->lang, $langCont . '_' . $COUNTER, "Contributor " . $Counter);
			}
		}
		if ($this->addContributors || $this->componentData->emptycontributors == 1)
		{
			// setup lang
			$this->setLangContent($this->lang, $langCont . '_TITLE_LABEL', "Contributor Job Title");
			$this->setLangContent($this->lang, $langCont . '_TITLE_DESC', "The job title that best describes the contributor's relationship to this component.");
			$this->setLangContent($this->lang, $langCont . '_NAME_LABEL', "Contributor Name");
			$this->setLangContent($this->lang, $langCont . '_NAME_DESC', "The name of this contributor.");
			$this->setLangContent($this->lang, $langCont . '_EMAIL_LABEL', "Contributor Email");
			$this->setLangContent($this->lang, $langCont . '_EMAIL_DESC', "The email of this contributor.");
			$this->setLangContent($this->lang, $langCont . '_LINK_LABEL', "Contributor Website");
			$this->setLangContent($this->lang, $langCont . '_LINK_DESC', "The link to this contributor's website.");
			$this->setLangContent($this->lang, $langCont . '_USE_LABEL', "Use");
			$this->setLangContent($this->lang, $langCont . '_USE_DESC', "How should we link to this contributor.");
			$this->setLangContent($this->lang, $langCont . '_USE_NONE', "None");
			$this->setLangContent($this->lang, $langCont . '_USE_EMAIL', "Email");
			$this->setLangContent($this->lang, $langCont . '_USE_WWW', "Website");
			$this->setLangContent($this->lang, $langCont . '_SHOW_LABEL', "Show");
			$this->setLangContent($this->lang, $langCont . '_SHOW_DESC', "Select where you want this contributor's details to show in the component.");
			$this->setLangContent($this->lang, $langCont . '_SHOW_NONE', "Hide");
			$this->setLangContent($this->lang, $langCont . '_SHOW_BACK', "Back-end");
			$this->setLangContent($this->lang, $langCont . '_SHOW_FRONT', "Front-end");
			$this->setLangContent($this->lang, $langCont . '_SHOW_ALL', "Both Front & Back-end");
		}
		// close that fieldset
		$this->configFieldSets[] = $this->_t(1) . "</fieldset>";
	}

	public function setUikitConfigFieldsets($lang)
	{
		if ($this->uikit > 0)
		{
			// main lang prefix
			$lang = $lang . '';
			// start building field set for uikit functions
			$this->configFieldSets[] = $this->_t(1) . "<fieldset";
			$this->configFieldSets[] = $this->_t(2) . 'name="uikit_config"';
			$this->configFieldSets[] = $this->_t(2) . 'label="' . $lang . '_UIKIT_LABEL"';
			$this->configFieldSets[] = $this->_t(2) . 'description="' . $lang . '_UIKIT_DESC">';
			// set tab lang
			if (1 == $this->uikit)
			{
				$this->setLangContent($this->lang, $lang . '_UIKIT_LABEL', "Uikit2 Settings");
				$this->setLangContent($this->lang, $lang . '_UIKIT_DESC', "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href=\"https://getuikit.com/v2/\" target=\"_blank\">https://getuikit.com/v2/</a>");
			}
			elseif (2 == $this->uikit)
			{
				$this->setLangContent($this->lang, $lang . '_UIKIT_LABEL', "Uikit2 and Uikit3 Settings");
				$this->setLangContent($this->lang, $lang . '_UIKIT_DESC', "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href=\"https://getuikit.com/v2/\" target=\"_blank\">version 2</a> or <a href=\"https://getuikit.com/\" target=\"_blank\">version 3</a>");
			}
			elseif (3 == $this->uikit)
			{
				$this->setLangContent($this->lang, $lang . '_UIKIT_LABEL', "Uikit3 Settings");
				$this->setLangContent($this->lang, $lang . '_UIKIT_DESC', "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href=\"https://getuikit.com/\" target=\"_blank\">https://getuikit.com/</a>");
			}

			// add version selection
			if (2 == $this->uikit)
			{
				// set field lang
				$this->setLangContent($this->lang, $lang . '_UIKIT_VERSION_LABEL', "Uikit Versions");
				$this->setLangContent($this->lang, $lang . '_UIKIT_VERSION_DESC', "Select what version you would like to use");
				$this->setLangContent($this->lang, $lang . '_UIKIT_V2', "Version 2");
				$this->setLangContent($this->lang, $lang . '_UIKIT_V3', "Version 3");
				// set the field
				$this->configFieldSets[] = $this->_t(2) . '<field name="uikit_version"';
				$this->configFieldSets[] = $this->_t(3) . 'type="radio"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_UIKIT_VERSION_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_UIKIT_VERSION_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'class="btn-group btn-group-yesno"';
				$this->configFieldSets[] = $this->_t(3) . 'default="2">';
				$this->configFieldSets[] = $this->_t(3) . '<!--' . $this->setLine(__LINE__) . ' Option Set. -->';
				$this->configFieldSets[] = $this->_t(3) . '<option value="2">';
				$this->configFieldSets[] = $this->_t(4) . $lang . '_UIKIT_V2</option>"';
				$this->configFieldSets[] = $this->_t(3) . '<option value="3">';
				$this->configFieldSets[] = $this->_t(4) . $lang . '_UIKIT_V3</option>"';
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				// set params defaults
				$this->extensionsParams[] = '"uikit_version":"2"';
			}

			// set field lang
			$this->setLangContent($this->lang, $lang . '_UIKIT_LOAD_LABEL', "Loading Options");
			$this->setLangContent($this->lang, $lang . '_UIKIT_LOAD_DESC', "Set the uikit loading option.");
			$this->setLangContent($this->lang, $lang . '_AUTO_LOAD', "Auto");
			$this->setLangContent($this->lang, $lang . '_FORCE_LOAD', "Force");
			$this->setLangContent($this->lang, $lang . '_DONT_LOAD', "Not");
			$this->setLangContent($this->lang, $lang . '_ONLY_EXTRA', "Only Extra");
			// set the field
			$this->configFieldSets[] = $this->_t(2) . '<field name="uikit_load"';
			$this->configFieldSets[] = $this->_t(3) . 'type="radio"';
			$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_UIKIT_LOAD_LABEL"';
			$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_UIKIT_LOAD_DESC"';
			$this->configFieldSets[] = $this->_t(3) . 'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = $this->_t(3) . 'default="">';
			$this->configFieldSets[] = $this->_t(3) . '<!--' . $this->setLine(__LINE__) . ' Option Set. -->';
			$this->configFieldSets[] = $this->_t(3) . '<option value="">';
			$this->configFieldSets[] = $this->_t(4) . $lang . '_AUTO_LOAD</option>"';
			$this->configFieldSets[] = $this->_t(3) . '<option value="1">';
			$this->configFieldSets[] = $this->_t(4) . $lang . '_FORCE_LOAD</option>"';
			if (2 == $this->uikit || 1 == $this->uikit)
			{
				$this->configFieldSets[] = $this->_t(3) . '<option value="3">';
				$this->configFieldSets[] = $this->_t(4) . $lang . '_ONLY_EXTRA</option>"';
			}
			$this->configFieldSets[] = $this->_t(3) . '<option value="2">';
			$this->configFieldSets[] = $this->_t(4) . $lang . '_DONT_LOAD</option>"';
			$this->configFieldSets[] = $this->_t(2) . "</field>";
			// set params defaults
			$this->extensionsParams[] = '"uikit_load":"1"';

			// set field lang
			$this->setLangContent($this->lang, $lang . '_UIKIT_MIN_LABEL', "Load Minified");
			$this->setLangContent($this->lang, $lang . '_UIKIT_MIN_DESC', "Should the minified version of uikit files be loaded?");
			$this->setLangContent($this->lang, $lang . '_YES', "Yes");
			$this->setLangContent($this->lang, $lang . '_NO', "No");
			// set the field
			$this->configFieldSets[] = $this->_t(2) . '<field name="uikit_min"';
			$this->configFieldSets[] = $this->_t(3) . 'type="radio"';
			$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_UIKIT_MIN_LABEL"';
			$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_UIKIT_MIN_DESC"';
			$this->configFieldSets[] = $this->_t(3) . 'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = $this->_t(3) . 'default="">';
			$this->configFieldSets[] = $this->_t(3) . '<!--' . $this->setLine(__LINE__) . ' Option Set. -->';
			$this->configFieldSets[] = $this->_t(3) . '<option value="">';
			$this->configFieldSets[] = $this->_t(4) . $lang . '_NO</option>"';
			$this->configFieldSets[] = $this->_t(3) . '<option value=".min">';
			$this->configFieldSets[] = $this->_t(4) . $lang . '_YES</option>"';
			$this->configFieldSets[] = $this->_t(2) . "</field>";
			// set params defaults
			$this->extensionsParams[] = '"uikit_min":""';

			if (2 == $this->uikit || 1 == $this->uikit)
			{
				// set field lang
				$this->setLangContent($this->lang, $lang . '_UIKIT_STYLE_LABEL', "css Style");
				$this->setLangContent($this->lang, $lang . '_UIKIT_STYLE_DESC', "Set the css style that should be used.");
				$this->setLangContent($this->lang, $lang . '_FLAT_LOAD', "Flat");
				$this->setLangContent($this->lang, $lang . '_ALMOST_FLAT_LOAD', "Almost Flat");
				$this->setLangContent($this->lang, $lang . '_GRADIANT_LOAD', "Gradient");
				// set the field
				$this->configFieldSets[] = $this->_t(2) . '<field name="uikit_style"';
				$this->configFieldSets[] = $this->_t(3) . 'type="radio"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_UIKIT_STYLE_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_UIKIT_STYLE_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'class="btn-group btn-group-yesno"';
				if (2 == $this->uikit)
				{
					$this->configFieldSets[] = $this->_t(3) . 'showon="uikit_version:2"';
				}
				$this->configFieldSets[] = $this->_t(3) . 'default="">';
				$this->configFieldSets[] = $this->_t(3) . '<!--' . $this->setLine(__LINE__) . ' Option Set. -->';
				$this->configFieldSets[] = $this->_t(3) . '<option value="">';
				$this->configFieldSets[] = $this->_t(4) . $lang . '_FLAT_LOAD</option>"';
				$this->configFieldSets[] = $this->_t(3) . '<option value=".almost-flat">';
				$this->configFieldSets[] = $this->_t(4) . $lang . '_ALMOST_FLAT_LOAD</option>"';
				$this->configFieldSets[] = $this->_t(3) . '<option value=".gradient">';
				$this->configFieldSets[] = $this->_t(4) . $lang . '_GRADIANT_LOAD</option>"';
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				// set params defaults
				$this->extensionsParams[] = '"uikit_style":""';
			}
			// add custom Uikit Settings fields
			if (isset($this->configFieldSetsCustomField['Uikit Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Uikit Settings']))
			{
				$this->configFieldSets[] = implode("", $this->configFieldSetsCustomField['Uikit Settings']);
				unset($this->configFieldSetsCustomField['Uikit Settings']);
			}
			// close that fieldset
			$this->configFieldSets[] = $this->_t(1) . "</fieldset>";
		}
	}

	public function setEmailHelperConfigFieldsets($lang)
	{
		if (isset($this->componentData->add_email_helper) && $this->componentData->add_email_helper)
		{
			// main lang prefix
			$lang = $lang . '';
			// set main lang string
			$this->setLangContent($this->lang, $lang . '_MAIL_CONFIGURATION', "Mail Configuration");
			$this->setLangContent($this->lang, $lang . '_DKIM', "DKIM");
			// start building field set for email helper functions
			$this->configFieldSets[] = PHP_EOL . $this->_t(1) . "<fieldset";
			$this->configFieldSets[] = $this->_t(2) . "name=\"mail_configuration_custom_config\"";
			$this->configFieldSets[] = $this->_t(2) . "label=\"" . $lang . "_MAIL_CONFIGURATION\">";
			// add custom Mail Configurations
			if (isset($this->configFieldSetsCustomField['Mail Configuration']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Mail Configuration']))
			{
				$this->configFieldSets[] = implode("", $this->configFieldSetsCustomField['Mail Configuration']);
				unset($this->configFieldSetsCustomField['Mail Configuration']);
			}
			else
			{
				// set all the laguage strings
				$this->setLangContent($this->lang, $lang . '_MAILONLINE_LABEL', "Mailer Status");
				$this->setLangContent($this->lang, $lang . '_MAILONLINE_DESCRIPTION', "Warning this will stop all emails from going out.");
				$this->setLangContent($this->lang, $lang . '_ON', "On");
				$this->setLangContent($this->lang, $lang . '_OFF', "Off");
				$this->setLangContent($this->lang, $lang . '_MAILER_LABEL', "Mailer");
				$this->setLangContent($this->lang, $lang . '_MAILER_DESCRIPTION', "Select what mailer you would like to use to send emails.");
				$this->setLangContent($this->lang, $lang . '_GLOBAL', "Global");
				$this->setLangContent($this->lang, $lang . '_PHP_MAIL', "PHP Mail");
				$this->setLangContent($this->lang, $lang . '_SENDMAIL', "Sendmail");
				$this->setLangContent($this->lang, $lang . '_SMTP', "SMTP");
				$this->setLangContent($this->lang, $lang . '_EMAILFROM_LABEL', " From Email");
				$this->setLangContent($this->lang, $lang . '_EMAILFROM_DESCRIPTION', "The global email address that will be used to send system email.");
				$this->setLangContent($this->lang, $lang . '_EMAILFROM_HINT', "Email Address Here");
				$this->setLangContent($this->lang, $lang . '_FROMNAME_LABEL', "From Name");
				$this->setLangContent($this->lang, $lang . '_FROMNAME_DESCRIPTION', "Text displayed in the header &quot;From:&quot; field when sending a site email. Usually the site name."); 
				$this->setLangContent($this->lang, $lang . '_FROMNAME_HINT', "From Name Here"); 
				$this->setLangContent($this->lang, $lang . '_EMAILREPLY_LABEL', " Reply to Email"); 
				$this->setLangContent($this->lang, $lang . '_EMAILREPLY_DESCRIPTION', "The global email address that will be used to set as the reply email. (leave blank for none)"); 
				$this->setLangContent($this->lang, $lang . '_EMAILREPLY_HINT', "Email Address Here"); 
				$this->setLangContent($this->lang, $lang . '_REPLYNAME_LABEL', "Reply to Name"); 
				$this->setLangContent($this->lang, $lang . '_REPLYNAME_DESCRIPTION', "Text displayed in the header &quot;Reply To:&quot; field when replying to the site email. Usually the the person that receives the response. (leave blank for none)"); 
				$this->setLangContent($this->lang, $lang . '_REPLYNAME_HINT', "Reply Name Here"); 
				$this->setLangContent($this->lang, $lang . '_SENDMAIL_LABEL', "Sendmail Path"); 
				$this->setLangContent($this->lang, $lang . '_SENDMAIL_DESCRIPTION', "Enter the path to the sendmail program directory on your host server."); 
				$this->setLangContent($this->lang, $lang . '_SENDMAIL_HINT', "/usr/sbin/sendmail"); 
				$this->setLangContent($this->lang, $lang . '_SMTPAUTH_LABEL', "SMTP Authentication");
				$this->setLangContent($this->lang, $lang . '_SMTPAUTH_DESCRIPTION', "Select yes if your SMTP host requires SMTP Authentication.");
				$this->setLangContent($this->lang, $lang . '_YES', "Yes");
				$this->setLangContent($this->lang, $lang . '_NO', "No");
				$this->setLangContent($this->lang, $lang . '_SMTPSECURE_LABEL', "SMTP Security");
				$this->setLangContent($this->lang, $lang . '_SMTPSECURE_DESCRIPTION', "Select the security model that your SMTP server uses.");
				$this->setLangContent($this->lang, $lang . '_NONE', "None");
				$this->setLangContent($this->lang, $lang . '_SSL', "SSL");
				$this->setLangContent($this->lang, $lang . '_TLS', "TLS");
				$this->setLangContent($this->lang, $lang . '_SMTPPORT_LABEL', "SMTP Port");
				$this->setLangContent($this->lang, $lang . '_SMTPPORT_DESCRIPTION', "Enter the port number of your SMTP server. Use 25 for most unsecured servers and 465 for most secure servers.");
				$this->setLangContent($this->lang, $lang . '_SMTPPORT_HINT', "25");
				$this->setLangContent($this->lang, $lang . '_SMTPUSER_LABEL', "SMTP Username");
				$this->setLangContent($this->lang, $lang . '_SMTPUSER_DESCRIPTION', "Enter the username for access to the SMTP host.");
				$this->setLangContent($this->lang, $lang . '_SMTPUSER_HINT', "email@demo.com");
				$this->setLangContent($this->lang, $lang . '_SMTPPASS_LABEL', "SMTP Password");
				$this->setLangContent($this->lang, $lang . '_SMTPPASS_DESCRIPTION', "Enter the password for access to the SMTP host.");
				$this->setLangContent($this->lang, $lang . '_SMTPHOST_LABEL', "SMTP Host");
				$this->setLangContent($this->lang, $lang . '_SMTPHOST_DESCRIPTION', "Enter the name of the SMTP host.");
				$this->setLangContent($this->lang, $lang . '_SMTPHOST_HINT', "localhost");

				// set the mailer fields
				$this->configFieldSets[] = PHP_EOL . $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Mailonline Field. Type: Radio. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"radio\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"mailonline\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_MAILONLINE_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_MAILONLINE_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"btn-group btn-group-yesno\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"1\">";
				$this->configFieldSets[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"1\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_ON</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"0\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_OFF</option>";
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Mailer Field. Type: List. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"list\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"mailer\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_MAILER_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_MAILER_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"list_class\"";
				$this->configFieldSets[] = $this->_t(3) . "multiple=\"false\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"WORD\"";
				$this->configFieldSets[] = $this->_t(3) . "required=\"true\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"global\">";
				$this->configFieldSets[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"global\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_GLOBAL</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"default\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_PHP_MAIL</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"sendmail\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_SENDMAIL</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"smtp\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_SMTP</option>";
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Emailfrom Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"emailfrom\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_EMAILFROM_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_EMAILFROM_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "validate=\"email\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add email address here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_EMAILFROM_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Fromname Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"fromname\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_FROMNAME_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_FROMNAME_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add some name here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_FROMNAME_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Email reply to Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"replyto\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_EMAILREPLY_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_EMAILREPLY_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "validate=\"email\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add email address here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_EMAILREPLY_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Reply to name Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"replytoname\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_REPLYNAME_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_REPLYNAME_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add some name here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_REPLYNAME_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Sendmail Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"sendmail\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_SENDMAIL_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_SENDMAIL_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "required=\"false\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"PATH\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add path to you local sendmail here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_SENDMAIL_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:sendmail\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Smtpauth Field. Type: Radio. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"radio\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"smtpauth\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_SMTPAUTH_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_SMTPAUTH_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"btn-group btn-group-yesno\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"0\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp\">";
				$this->configFieldSets[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"1\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_YES</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"0\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_NO</option>";
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Smtpsecure Field. Type: List. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"list\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"smtpsecure\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_SMTPSECURE_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_SMTPSECURE_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"list_class\"";
				$this->configFieldSets[] = $this->_t(3) . "multiple=\"false\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"WORD\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"none\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp\">";
				$this->configFieldSets[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"none\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_NONE</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"ssl\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_SSL</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"tls\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_TLS</option>";
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Smtpport Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"smtpport\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_SMTPPORT_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"25\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_SMTPPORT_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add the port number of your SMTP server here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_SMTPPORT_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Smtpuser Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"smtpuser\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_SMTPUSER_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_SMTPUSER_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add the username for SMTP server here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_SMTPUSER_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Smtppass Field. Type: Password. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"password\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"smtppass\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_SMTPPASS_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_SMTPPASS_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"raw\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add the password for SMTP server here.\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Smtphost Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"smtphost\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_SMTPHOST_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"localhost\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_SMTPHOST_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add the name of the SMTP host here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_SMTPHOST_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"mailer:smtp\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
			}
			// close that fieldset
			$this->configFieldSets[] = $this->_t(1) . "</fieldset>";

			// start dkim field set
			$this->configFieldSets[] = $this->_t(1) . "<fieldset";
			$this->configFieldSets[] = $this->_t(2) . "name=\"dkim_custom_config\"";
			$this->configFieldSets[] = $this->_t(2) . "label=\"" . $lang . "_DKIM\">";
			// add custom DKIM fields
			if (isset($this->configFieldSetsCustomField['DKIM']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['DKIM']))
			{
				$this->configFieldSets[] = implode("", $this->configFieldSetsCustomField['DKIM']);
				unset($this->configFieldSetsCustomField['DKIM']);
			}
			else
			{
				$this->setLangContent($this->lang, $lang . '_DKIM_LABEL', "Enable DKIM");
				$this->setLangContent($this->lang, $lang . '_DKIM_DESCRIPTION', "Set this option to Yes if you want to sign your emails using DKIM.");
				$this->setLangContent($this->lang, $lang . '_YES', "Yes");
				$this->setLangContent($this->lang, $lang . '_NO', "No");
				$this->setLangContent($this->lang, $lang . '_DKIM_DOMAIN_LABEL', "Domain");
				$this->setLangContent($this->lang, $lang . '_DKIM_DOMAIN_DESCRIPTION', "Set the domain. Eg. domain.com");
				$this->setLangContent($this->lang, $lang . '_DKIM_DOMAIN_HINT', "domain.com");
				$this->setLangContent($this->lang, $lang . '_DKIM_SELECTOR_LABEL', "Selector");
				$this->setLangContent($this->lang, $lang . '_DKIM_SELECTOR_DESCRIPTION', "Set your DKIM/DNS selector.");
				$this->setLangContent($this->lang, $lang . '_DKIM_SELECTOR_HINT', "vdm");
				$this->setLangContent($this->lang, $lang . '_DKIM_PASSPHRASE_LABEL', "Passphrase");
				$this->setLangContent($this->lang, $lang . '_DKIM_PASSPHRASE_DESCRIPTION', "Enter your passphrase here.");
				$this->setLangContent($this->lang, $lang . '_DKIM_IDENTITY_LABEL', "Identity");
				$this->setLangContent($this->lang, $lang . '_DKIM_IDENTITY_DESCRIPTION', "Set DKIM identity. This can be in the format of an email address 'you@yourdomain.com' typically used as the source of the email.");
				$this->setLangContent($this->lang, $lang . '_DKIM_IDENTITY_HINT', "you@yourdomain.com");
				$this->setLangContent($this->lang, $lang . '_DKIM_PRIVATE_KEY_LABEL', "Private key");
				$this->setLangContent($this->lang, $lang . '_DKIM_PRIVATE_KEY_DESCRIPTION', "set private key");
				$this->setLangContent($this->lang, $lang . '_DKIM_PUBLIC_KEY_LABEL', "Public key");
				$this->setLangContent($this->lang, $lang . '_DKIM_PUBLIC_KEY_DESCRIPTION', "set public key");
				$this->setLangContent($this->lang, $lang . '_NOTE_DKIM_USE_LABEL', "Server Configuration");
				$this->setLangContent($this->lang, $lang . '_NOTE_DKIM_USE_DESCRIPTION', "<p>Using the below details, you need to configure your DNS by adding a TXT record on your domain: <b><span id='a_dkim_domain'></span></b></p>
<script>
jQuery(document).ready(function()
{
	// house cleaning
        if( !jQuery('#jform_dkim_domain').val() ) {
            jQuery('#jform_dkim_domain').val(window.location.hostname);
        }
        jQuery('#jform_dkim_key').click(function(){
            jQuery(this).select();
        });
        jQuery('#jform_dkim_value').click(function(){
            jQuery(this).select();
        });
        vdm_dkim();
});

function vdm_dkim() {
        jQuery('#a_dkim_domain').text(jQuery('#jform_dkim_domain').val());
	jQuery('#jform_dkim_key').val(jQuery('#jform_dkim_selector').val() + '._domainkey');
	if( !jQuery('#jform_dkim_public_key').val() ) {
	        jQuery('#jform_dkim_value').val('v=DKIM1;k=rsa;g=*;s=email;h=sha1;t=s;p=PUBLICKEY');
        } else {
	        jQuery('#jform_dkim_value').val('v=DKIM1;k=rsa;g=*;s=email;h=sha1;t=s;p=' + jQuery('#jform_dkim_public_key').val());
        }
}
</script>");
				$this->setLangContent($this->lang, $lang . '_DKIM_KEY_LABEL', "Key");
				$this->setLangContent($this->lang, $lang . '_DKIM_KEY_DESCRIPTION', "This is the KEY to use in the DNS record.");
				$this->setLangContent($this->lang, $lang . '_DKIM_KEY_HINT', "vdm._domainkey");
				$this->setLangContent($this->lang, $lang . '_DKIM_VALUE_LABEL', "Value");
				$this->setLangContent($this->lang, $lang . '_DKIM_VALUE_DESCRIPTION', "This is the TXT value to use in the DNS. Replace the PUBLICKEY with your public key.");
				$this->setLangContent($this->lang, $lang . '_DKIM_VALUE_HINT', "v=DKIM1;k=rsa;g=*;s=email;h=sha1;t=s;p=PUBLICKEY");


				$this->configFieldSets[] = PHP_EOL . $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim Field. Type: Radio. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"radio\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"btn-group btn-group-yesno\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"0\"";
				$this->configFieldSets[] = $this->_t(3) . "required=\"true\">";
				$this->configFieldSets[] = $this->_t(3) . "<!--" . $this->setLine(__LINE__) . " Option Set. -->";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"1\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_YES</option>";
				$this->configFieldSets[] = $this->_t(3) . "<option value=\"0\">";
				$this->configFieldSets[] = $this->_t(4) . $lang . "_NO</option>";
				$this->configFieldSets[] = $this->_t(2) . "</field>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_domain Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_domain\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_DOMAIN_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_DOMAIN_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add DKIM Domain here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_DKIM_DOMAIN_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(3) . "onchange=\"vdm_dkim();\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_selector Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_selector\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_SELECTOR_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "default=\"vdm\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_SELECTOR_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add DKIM/DNS selector here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_DKIM_SELECTOR_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(3) . "onchange=\"vdm_dkim();\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_passphrase Field. Type: Password. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"password\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_passphrase\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_PASSPHRASE_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_PASSPHRASE_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"raw\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add  passphrase here.\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_identity Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_identity\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_IDENTITY_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"60\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_IDENTITY_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"raw\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add  DKIM Identity here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_DKIM_IDENTITY_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_private_key Field. Type: Textarea. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"textarea\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_private_key\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_PRIVATE_KEY_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "rows=\"15\"";
				$this->configFieldSets[] = $this->_t(3) . "cols=\"5\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_PRIVATE_KEY_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"input-xxlarge span12\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_public_key Field. Type: Textarea. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"textarea\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_public_key\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_PUBLIC_KEY_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "rows=\"5\"";
				$this->configFieldSets[] = $this->_t(3) . "cols=\"5\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_PUBLIC_KEY_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"input-xxlarge span12\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(3) . "onchange=\"vdm_dkim();\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Note_dkim_use Field. Type: Note. A None Database Field. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field type=\"note\" name=\"note_dkim_use\" label=\"" . $lang . "_NOTE_DKIM_USE_LABEL\" description=\"" . $lang . "_NOTE_DKIM_USE_DESCRIPTION\" heading=\"h4\" class=\"note_dkim_use\" showon=\"dkim:1\" />";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_key Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_key\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_KEY_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"40\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"150\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_KEY_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add KEY here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_DKIM_KEY_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
				$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Dkim_value Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = $this->_t(2) . "<field";
				$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
				$this->configFieldSets[] = $this->_t(3) . "name=\"dkim_value\"";
				$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_DKIM_VALUE_LABEL\"";
				$this->configFieldSets[] = $this->_t(3) . "size=\"80\"";
				$this->configFieldSets[] = $this->_t(3) . "maxlength=\"350\"";
				$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_DKIM_VALUE_DESCRIPTION\"";
				$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
				$this->configFieldSets[] = $this->_t(3) . "filter=\"STRING\"";
				$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add TXT record here.\"";
				$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_DKIM_VALUE_HINT\"";
				$this->configFieldSets[] = $this->_t(3) . "showon=\"dkim:1\"";
				$this->configFieldSets[] = $this->_t(2) . "/>";
			}
			// close that fieldset
			$this->configFieldSets[] = $this->_t(1) . "</fieldset>";
		}
	}

	public function setGooglechartConfigFieldsets($lang)
	{
		if ($this->googlechart)
		{
			$this->configFieldSets[] = PHP_EOL . $this->_t(1) . "<fieldset";
			$this->configFieldSets[] = $this->_t(2) . "name=\"googlechart_config\"";
			$this->configFieldSets[] = $this->_t(2) . "label=\"" . $lang . "_CHART_SETTINGS_LABEL\"";
			$this->configFieldSets[] = $this->_t(2) . "description=\"" . $lang . "_CHART_SETTINGS_DESC\">";
			$this->configFieldSets[] = $this->_t(2);
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"note\" name=\"chart_admin_naote\" class=\"alert alert-info\" label=\"" . $lang . "_ADMIN_CHART_NOTE_LABEL\" description=\"" . $lang . "_ADMIN_CHART_NOTE_DESC\"  />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_chartbackground Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_chartbackground\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#F7F7FA\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTBACKGROUND_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTBACKGROUND_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_mainwidth Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_mainwidth\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_MAINWIDTH_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_MAINWIDTH_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add area width here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_MAINWIDTH_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartadmin_hr_a Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartadmin_hr_a\" hr=\"true\" class=\"spacer_chartadmin_hr_a\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_chartareatop Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_chartareatop\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTAREATOP_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTAREATOP_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add top spacing here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_CHARTAREATOP_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_chartarealeft Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_chartarealeft\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTAREALEFT_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTAREALEFT_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add left spacing here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_CHARTAREALEFT_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_chartareawidth Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_chartareawidth\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTAREAWIDTH_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTAREAWIDTH_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add chart width here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_CHARTAREAWIDTH_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartadmin_hr_b Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartadmin_hr_b\" hr=\"true\" class=\"spacer_chartadmin_hr_b\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_legendtextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_legendtextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_LEGENDTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_legendtextstylefontsize Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_legendtextstylefontsize\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_LEGENDTEXTSTYLEFONTSIZE_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_LEGENDTEXTSTYLEFONTSIZE_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add size of the legend here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_LEGENDTEXTSTYLEFONTSIZE_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartadmin_hr_c Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartadmin_hr_c\" hr=\"true\" class=\"spacer_chartadmin_hr_c\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_vaxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_vaxistextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_VAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_VAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartadmin_hr_d Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartadmin_hr_d\" hr=\"true\" class=\"spacer_chartadmin_hr_d\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_haxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_haxistextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_HAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_HAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Admin_haxistitletextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"admin_haxistitletextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2);
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"note\" name=\"chart_site_note\" class=\"alert alert-info\" label=\"" . $lang . "_SITE_CHART_NOTE_LABEL\" description=\"" . $lang . "_SITE_CHART_NOTE_DESC\"  />";
			$this->configFieldSets[] = $this->_t(2);
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_chartbackground Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_chartbackground\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#F7F7FA\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTBACKGROUND_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTBACKGROUND_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_mainwidth Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_mainwidth\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_MAINWIDTH_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_MAINWIDTH_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add area width here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_MAINWIDTH_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartsite_hr_a Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartsite_hr_a\" hr=\"true\" class=\"spacer_chartsite_hr_a\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_chartareatop Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_chartareatop\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTAREATOP_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTAREATOP_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add top spacing here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_CHARTAREATOP_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_chartarealeft Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_chartarealeft\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTAREALEFT_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTAREALEFT_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add left spacing here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_CHARTAREALEFT_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_chartareawidth Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_chartareawidth\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_CHARTAREAWIDTH_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_CHARTAREAWIDTH_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add chart width here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_CHARTAREAWIDTH_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartsite_hr_b Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartsite_hr_b\" hr=\"true\" class=\"spacer_chartsite_hr_b\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_legendtextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_legendtextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_LEGENDTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_legendtextstylefontsize Field. Type: Text. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"text\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_legendtextstylefontsize\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_LEGENDTEXTSTYLEFONTSIZE_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "size=\"20\"";
			$this->configFieldSets[] = $this->_t(3) . "maxlength=\"50\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_LEGENDTEXTSTYLEFONTSIZE_DESC\"";
			$this->configFieldSets[] = $this->_t(3) . "class=\"text_area\"";
			$this->configFieldSets[] = $this->_t(3) . "filter=\"INT\"";
			$this->configFieldSets[] = $this->_t(3) . "message=\"Error! Please add size of the legend here.\"";
			$this->configFieldSets[] = $this->_t(3) . "hint=\"" . $lang . "_LEGENDTEXTSTYLEFONTSIZE_HINT\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartsite_hr_c Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartsite_hr_c\" hr=\"true\" class=\"spacer_chartsite_hr_c\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_vaxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_vaxistextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_VAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_VAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Spacer_chartsite_hr_d Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field type=\"spacer\" name=\"spacer_chartsite_hr_d\" hr=\"true\" class=\"spacer_chartsite_hr_d\" />";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_haxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_haxistextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_HAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_HAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";
			$this->configFieldSets[] = $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " Site_haxistitletextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = $this->_t(2) . "<field";
			$this->configFieldSets[] = $this->_t(3) . "type=\"color\"";
			$this->configFieldSets[] = $this->_t(3) . "name=\"site_haxistitletextstylefontcolor\"";
			$this->configFieldSets[] = $this->_t(3) . "default=\"#63B1F2\"";
			$this->configFieldSets[] = $this->_t(3) . "label=\"" . $lang . "_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = $this->_t(3) . "description=\"" . $lang . "_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = $this->_t(2) . "/>";

			// add custom Encryption Settings fields
			if (isset($this->configFieldSetsCustomField['Chart Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Chart Settings']))
			{
				$this->configFieldSets[] = implode("", $this->configFieldSetsCustomField['Chart Settings']);
				unset($this->configFieldSetsCustomField['Chart Settings']);
			}

			$this->configFieldSets[] = $this->_t(1) . "</fieldset>";

			// set params defaults
			$this->extensionsParams[] = '"admin_chartbackground":"#F7F7FA","admin_mainwidth":"1000","admin_chartareatop":"20","admin_chartarealeft":"20","admin_chartareawidth":"170","admin_legendtextstylefontcolor":"10","admin_legendtextstylefontsize":"20","admin_vaxistextstylefontcolor":"#63B1F2","admin_haxistextstylefontcolor":"#63B1F2","admin_haxistitletextstylefontcolor":"#63B1F2","site_chartbackground":"#F7F7FA","site_mainwidth":"1000","site_chartareatop":"20","site_chartarealeft":"20","site_chartareawidth":"170","site_legendtextstylefontcolor":"10","site_legendtextstylefontsize":"20","site_vaxistextstylefontcolor":"#63B1F2","site_haxistextstylefontcolor":"#63B1F2","site_haxistitletextstylefontcolor":"#63B1F2"';

			// set field lang
			$this->setLangContent($this->lang, $lang . '_CHART_SETTINGS_LABEL', "Chart Settings");
			$this->setLangContent($this->lang, $lang . '_CHART_SETTINGS_DESC', "The Google Chart Display Settings Are Made Here.");
			$this->setLangContent($this->lang, $lang . '_ADMIN_CHART_NOTE_LABEL', "Admin Settings");
			$this->setLangContent($this->lang, $lang . '_ADMIN_CHART_NOTE_DESC', "The following settings are used on the back-end of the site called (admin).");
			$this->setLangContent($this->lang, $lang . '_SITE_CHART_NOTE_LABEL', "Site Settings");
			$this->setLangContent($this->lang, $lang . '_SITE_CHART_NOTE_DESC', "The following settings are used on the front-end of the site called (site).");

			$this->setLangContent($this->lang, $lang . '_CHARTAREALEFT_DESC', "Set in pixels the spacing from the left of the chart area to the beginning of the chart it self. Please don't add the px sign");
			$this->setLangContent($this->lang, $lang . '_CHARTAREALEFT_HINT', "170");
			$this->setLangContent($this->lang, $lang . '_CHARTAREALEFT_LABEL', "Left Spacing");
			$this->setLangContent($this->lang, $lang . '_CHARTAREATOP_DESC', "Set in pixels the spacing from the top of the chart area to the beginning of the chart it self. Please don't add the px sign");
			$this->setLangContent($this->lang, $lang . '_CHARTAREATOP_HINT', "20");
			$this->setLangContent($this->lang, $lang . '_CHARTAREATOP_LABEL', "Top Spacing");
			$this->setLangContent($this->lang, $lang . '_CHARTAREAWIDTH_DESC', "Set in % the width of the chart it self inside the chart area. Please don't add the % sign");
			$this->setLangContent($this->lang, $lang . '_CHARTAREAWIDTH_HINT', "60");
			$this->setLangContent($this->lang, $lang . '_CHARTAREAWIDTH_LABEL', "Chart Width");
			$this->setLangContent($this->lang, $lang . '_CHARTBACKGROUND_DESC', "Select the chart background color here.");
			$this->setLangContent($this->lang, $lang . '_CHARTBACKGROUND_LABEL', "Chart Background");
			$this->setLangContent($this->lang, $lang . '_HAXISTEXTSTYLEFONTCOLOR_DESC', "Select the horizontal axis font color.");
			$this->setLangContent($this->lang, $lang . '_HAXISTEXTSTYLEFONTCOLOR_LABEL', "hAxis Font Color");
			$this->setLangContent($this->lang, $lang . '_HAXISTITLETEXTSTYLEFONTCOLOR_DESC', "Select the horizontal axis title's font color.");
			$this->setLangContent($this->lang, $lang . '_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL', "hAxis Title Font Color");
			$this->setLangContent($this->lang, $lang . '_LEGENDTEXTSTYLEFONTCOLOR_DESC', "Select the legend font color.");
			$this->setLangContent($this->lang, $lang . '_LEGENDTEXTSTYLEFONTCOLOR_LABEL', "Legend Font Color");
			$this->setLangContent($this->lang, $lang . '_LEGENDTEXTSTYLEFONTSIZE_DESC', "Set in pixels the font size of the legend");
			$this->setLangContent($this->lang, $lang . '_LEGENDTEXTSTYLEFONTSIZE_HINT', "10");
			$this->setLangContent($this->lang, $lang . '_LEGENDTEXTSTYLEFONTSIZE_LABEL', "Legend Font Size");
			$this->setLangContent($this->lang, $lang . '_MAINWIDTH_DESC', "Set the width of the entire chart area");
			$this->setLangContent($this->lang, $lang . '_MAINWIDTH_HINT', "1000");
			$this->setLangContent($this->lang, $lang . '_MAINWIDTH_LABEL', "Chart Area Width");
			$this->setLangContent($this->lang, $lang . '_VAXISTEXTSTYLEFONTCOLOR_DESC', "Select the vertical axis font color.");
			$this->setLangContent($this->lang, $lang . '_VAXISTEXTSTYLEFONTCOLOR_LABEL', "vAxis Font Color");
		}
	}

	/**
	 * @param $lang
	 */
	public function setEncryptionConfigFieldsets($lang)
	{
		// enable the loading of dynamic field sets
		$dynamicAddFields = array();
		// Add encryption if needed
		if ((isset($this->basicEncryption) && $this->basicEncryption) ||
			(isset($this->whmcsEncryption) && $this->whmcsEncryption) ||
			(isset($this->mediumEncryption) && $this->mediumEncryption) ||
			$this->componentData->add_license ||
			(isset($this->configFieldSetsCustomField['Encryption Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Encryption Settings'])))
		{
			$dynamicAddFields[] = "Encryption Settings";
			// start building field set for encryption functions
			$this->configFieldSets[] = $this->_t(1) . "<fieldset";
			$this->configFieldSets[] = $this->_t(2) . 'name="encryption_config"';
			$this->configFieldSets[] = $this->_t(2) . 'label="' . $lang . '_ENCRYPTION_LABEL"';
			$this->configFieldSets[] = $this->_t(2) . 'description="' . $lang . '_ENCRYPTION_DESC">';

			// set tab lang
			if (((isset($this->basicEncryption) && $this->basicEncryption) ||
				(isset($this->mediumEncryption) && $this->mediumEncryption) ||
				(isset($this->whmcsEncryption) && $this->whmcsEncryption)) &&
				$this->componentData->add_license && $this->componentData->license_type == 3)
			{
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_LABEL', "License & Encryption Settings");
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_DESC', "The license & encryption keys are set here.");
				// add the next dynamic option
				$dynamicAddFields[] = "License & Encryption Settings";
			}
			elseif (((isset($this->basicEncryption) && $this->basicEncryption) ||
				(isset($this->mediumEncryption) && $this->mediumEncryption) ||
				(isset($this->whmcsEncryption) && $this->whmcsEncryption)) &&
				$this->componentData->add_license && $this->componentData->license_type == 2)
			{
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_LABEL', "Update & Encryption Settings");
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_DESC', "The update & encryption keys are set here.");
				// add the next dynamic option
				$dynamicAddFields[] = "Update & Encryption Settings";
			}
			elseif ($this->componentData->add_license && $this->componentData->license_type == 3)
			{
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_LABEL',  "License Settings");
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_DESC',  "The license key is set here.");
				// add the next dynamic option
				$dynamicAddFields[] = "License Settings";
			}
			elseif ($this->componentData->add_license && $this->componentData->license_type == 2)
			{
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_LABEL', "Update Settings");
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_DESC', "The update key is set here.");
				// add the next dynamic option
				$dynamicAddFields[] = "Update Settings";
			}
			else
			{
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_LABEL', "Encryption Settings");
				$this->setLangContent($this->lang, $lang . '_ENCRYPTION_DESC', "The encryption key for the field encryption is set here.");
			}

			if (isset($this->basicEncryption) && $this->basicEncryption)
			{
				// set field lang
				$this->setLangContent($this->lang, $lang . '_BASIC_KEY_LABEL', "Basic Key");
				$this->setLangContent($this->lang, $lang . '_BASIC_KEY_DESC', "Set the basic local key here.");
				$this->setLangContent($this->lang, $lang . '_BASIC_KEY_NOTE_LABEL', "Basic Encryption");
				$this->setLangContent($this->lang, $lang . '_BASIC_KEY_NOTE_DESC', "When using the basic encryption please use set a 32 character passphrase.<br />Never change this passphrase once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>");
				// set the field
				$this->configFieldSets[] = $this->_t(2) . '<field type="note" name="basic_key_note" class="alert alert-info" label="' . $lang . '_BASIC_KEY_NOTE_LABEL" description="' . $lang . '_BASIC_KEY_NOTE_DESC"  />';
				$this->configFieldSets[] = $this->_t(2) . '<field name="basic_key"';
				$this->configFieldSets[] = $this->_t(3) . 'type="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_BASIC_KEY_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_BASIC_KEY_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default=""';
				$this->configFieldSets[] = $this->_t(2) . "/>";
			}
			if (isset($this->mediumEncryption) && $this->mediumEncryption)
			{
				// set field lang
				$this->setLangContent($this->lang, $lang . '_MEDIUM_KEY_LABEL', "Medium Key (Path)");
				$this->setLangContent($this->lang, $lang . '_MEDIUM_KEY_DESC', "Set the full path to where the key file must be stored. Make sure it is behind the root folder of your website, so that it is not public accessible.");
				$this->setLangContent($this->lang, $lang . '_MEDIUM_KEY_NOTE_LABEL', "Medium Encryption");
				$this->setLangContent($this->lang, $lang . '_MEDIUM_KEY_NOTE_DESC', "When using the medium encryption option, the system generates its own key and stores it in a file at the folder/path you set here.<br />Never change this key once it is set, or remove the key file! <b>DATA WILL GET CORRUPTED IF YOU DO!</b> Also make sure the full path to where the the key file should be stored, is behind the root folder of your website/system, so that it is not public accessible. Making a backup of this key file over a <b>secure connection</b> is recommended!");
				// set the field
				$this->configFieldSets[] = $this->_t(2) . '<field type="note" name="medium_key_note" class="alert alert-info" label="' . $lang . '_MEDIUM_KEY_NOTE_LABEL" description="' . $lang . '_MEDIUM_KEY_NOTE_DESC" />';
				$this->configFieldSets[] = $this->_t(2) . '<field name="medium_key_path"';
				$this->configFieldSets[] = $this->_t(3) . 'type="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_MEDIUM_KEY_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_MEDIUM_KEY_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="160"';
				$this->configFieldSets[] = $this->_t(3) . 'filter="PATH"';
				$this->configFieldSets[] = $this->_t(3) . 'hint="/home/user/hiddenfolder123/"';
				$this->configFieldSets[] = $this->_t(3) . 'default=""';
				$this->configFieldSets[] = $this->_t(2) . "/>";
				// set some error message if the path does not exist
				$this->setLangContent($this->lang, $lang . '_MEDIUM_KEY_PATH_ERROR', "Medium key path (for encryption of various fields) does not exist, or is not writable. Please check the path and update it in the global option of this component.");
			}
			if (isset($this->whmcsEncryption) && $this->whmcsEncryption || $this->componentData->add_license)
			{
				// set field lang label and description
				if ($this->componentData->add_license && $this->componentData->license_type == 3)
				{
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_LABEL', $this->componentData->companyname . " License Key");
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_DESC', "Add the license key you recieved from " . $this->componentData->companyname . " here.");
				}
				elseif ($this->componentData->add_license && $this->componentData->license_type == 2)
				{
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_LABEL', $this->componentData->companyname . " Update Key");
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_DESC', "Add the update key you recieved from " . $this->componentData->companyname . " here.");
				}
				else
				{
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_LABEL', $this->componentData->companyname . " Key");
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_DESC', "Add the key you recieved from " . $this->componentData->companyname . " here.");
				}
				// ajust the notice based on license
				if ($this->componentData->license_type == 3)
				{
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_NOTE_LABEL', "Your " . $this->componentData->companyname . " License Key");
				}
				elseif ($this->componentData->license_type == 2)
				{
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_NOTE_LABEL', "Your " . $this->componentData->companyname . " Update Key");
				}
				else
				{
					if (isset($this->whmcsEncryption) && $this->whmcsEncryption)
					{
						$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_NOTE_LABEL', "Your " . $this->componentData->companyname . " Field Encryption Key");
					}
					else
					{
						$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_NOTE_LABEL', "Your " . $this->componentData->companyname . " Key");
					}
				}
				// add the description based on global settings
				if (isset($this->whmcsEncryption) && $this->whmcsEncryption)
				{
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_NOTE_DESC', "You need to get this key from <a href='".$this->componentData->whmcs_buy_link."' target='_blank'>" . $this->componentData->companyname . "</a>.<br />When using the " . $this->componentData->companyname . " field encryption you can never change this key once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>");
				}
				else
				{
					$this->setLangContent($this->lang, $lang . '_WHMCS_KEY_NOTE_DESC', "You need to get this key from <a href='".$this->componentData->whmcs_buy_link."' target='_blank'>" . $this->componentData->companyname . "</a>.");
				}
				// set the fields
				$this->configFieldSets[] = $this->_t(2) . '<field type="note" name="whmcs_key_note" class="alert alert-info" label="' . $lang . '_WHMCS_KEY_NOTE_LABEL" description="' . $lang . '_WHMCS_KEY_NOTE_DESC"  />';
				$this->configFieldSets[] = $this->_t(2) . '<field name="whmcs_key"'; // We had to change this from license_key & advanced_key to whmcs_key
				$this->configFieldSets[] = $this->_t(3) . 'type="text"';
				$this->configFieldSets[] = $this->_t(3) . 'label="' . $lang . '_WHMCS_KEY_LABEL"';
				$this->configFieldSets[] = $this->_t(3) . 'description="' . $lang . '_WHMCS_KEY_DESC"';
				$this->configFieldSets[] = $this->_t(3) . 'size="60"';
				$this->configFieldSets[] = $this->_t(3) . 'default=""';
				$this->configFieldSets[] = $this->_t(2) . "/>";
			}
			// load the dynamic field sets
			foreach ($dynamicAddFields as $dynamicAddField)
			{
				// add custom Encryption Settings fields
				if (isset($this->configFieldSetsCustomField[$dynamicAddField]) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField[$dynamicAddField]))
				{
					$this->configFieldSets[] = implode("", $this->configFieldSetsCustomField[$dynamicAddField]);
					unset($this->configFieldSetsCustomField[$dynamicAddField]);
				}
			}
			// close that fieldset
			$this->configFieldSets[] = $this->_t(1) . "</fieldset>";
		}
	}

	public function setAccessSectionsCategory($viewName_single, $viewName_list)
	{
		$component = '';
		// check if view has category
		if (array_key_exists($viewName_single, $this->catCodeBuilder))
		{
			$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
			if ($otherViews == $viewName_list)
			{
				$component .= PHP_EOL . $this->_t(1) . '<section name="category.' . $otherViews . '">';
				$component .= PHP_EOL . $this->_t(2) . '<action name="core.create" title="JACTION_CREATE" description="JACTION_CREATE_COMPONENT_DESC" />';
				$component .= PHP_EOL . $this->_t(2) . '<action name="core.delete" title="JACTION_DELETE" description="COM_CATEGORIES_ACCESS_DELETE_DESC" />';
				$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit" title="JACTION_EDIT" description="COM_CATEGORIES_ACCESS_EDIT_DESC" />';
				$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_CATEGORIES_ACCESS_EDITSTATE_DESC" />';
				$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit.own" title="JACTION_EDITOWN" description="COM_CATEGORIES_ACCESS_EDITOWN_DESC" />';
				$component .= PHP_EOL . $this->_t(1) . "</section>";
			}
		}
		return $component;
	}

	public function setAccessSectionsJoomlaFields()
	{
		$component = '';
		// set all the core field permissions
		$component .= PHP_EOL . $this->_t(1) . '<section name="fieldgroup">';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.create" title="JACTION_CREATE" description="COM_FIELDS_GROUP_PERMISSION_CREATE_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.delete" title="JACTION_DELETE" description="COM_FIELDS_GROUP_PERMISSION_DELETE_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit" title="JACTION_EDIT" description="COM_FIELDS_GROUP_PERMISSION_EDIT_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_FIELDS_GROUP_PERMISSION_EDITSTATE_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit.own" title="JACTION_EDITOWN" description="COM_FIELDS_GROUP_PERMISSION_EDITOWN_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit.value" title="JACTION_EDITVALUE" description="COM_FIELDS_GROUP_PERMISSION_EDITVALUE_DESC" />';
		$component .= PHP_EOL . $this->_t(1) . '</section>';
		$component .= PHP_EOL . $this->_t(1) . '<section name="field">';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.delete" title="JACTION_DELETE" description="COM_FIELDS_FIELD_PERMISSION_DELETE_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit" title="JACTION_EDIT" description="COM_FIELDS_FIELD_PERMISSION_EDIT_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_FIELDS_FIELD_PERMISSION_EDITSTATE_DESC" />';
		$component .= PHP_EOL . $this->_t(2) . '<action name="core.edit.value" title="JACTION_EDITVALUE" description="COM_FIELDS_FIELD_PERMISSION_EDITVALUE_DESC" />';
		$component .= PHP_EOL . $this->_t(1) . '</section>';
		return $component;
	}

	public function setAccessSections()
	{
		// set the default component access values
		$this->componentHead = array();
		$this->componentGlobal = array();
		$this->permissionViews = array();

		// Trigger Event: jcb_ce_onBeforeBuildAccessSections
		$this->triggerEvent('jcb_ce_onBeforeBuildAccessSections', array(&$this->componentContext, $this));

		$this->componentHead[] = '<section name="component">';

		$this->componentHead[] = $this->_t(2) . '<action name="core.admin" title="JACTION_ADMIN" description="JACTION_ADMIN_COMPONENT_DESC" />';
		$this->componentHead[] = $this->_t(2) . '<action name="core.options" title="JACTION_OPTIONS" description="JACTION_OPTIONS_COMPONENT_DESC" />';
		$this->componentHead[] = $this->_t(2) . '<action name="core.manage" title="JACTION_MANAGE" description="JACTION_MANAGE_COMPONENT_DESC" />';
		if ($this->addEximport)
		{
			$exportTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Export Data', 'U');
			$exportDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Export Data', 'U') . '_DESC';
			$this->setLangContent('bothadmin', $exportTitle, 'Export Data');
			$this->setLangContent('bothadmin', $exportDesc, ' Allows users in this group to export data.');
			$this->componentHead[] = $this->_t(2) . '<action name="core.export" title="' . $exportTitle . '" description="' . $exportDesc . '" />';

			$importTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Import Data', 'U');
			$importDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Import Data', 'U') . '_DESC';
			$this->setLangContent('bothadmin', $importTitle, 'Import Data');
			$this->setLangContent('bothadmin', $importDesc, ' Allows users in this group to import data.');
			$this->componentHead[] = $this->_t(2) . '<action name="core.import" title="' . $importTitle . '" description="' . $importDesc . '" />';
		}
		// version permission
		$batchTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Use Batch', 'U');
		$batchDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Use Batch', 'U') . '_DESC';
		$this->setLangContent('bothadmin', $batchTitle, 'Use Batch');
		$this->setLangContent('bothadmin', $batchDesc, ' Allows users in this group to use batch copy/update method.');
		$this->componentHead[] = $this->_t(2) . '<action name="core.batch" title="' . $batchTitle . '" description="' . $batchDesc . '" />';
		// version permission
		$importTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Edit Versions', 'U');
		$importDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Edit Versions', 'U') . '_DESC';
		$this->setLangContent('bothadmin', $importTitle, 'Edit Version');
		$this->setLangContent('bothadmin', $importDesc, ' Allows users in this group to edit versions.');
		$this->componentHead[] = $this->_t(2) . '<action name="core.version" title="' . $importTitle . '" description="' . $importDesc . '" />';
		// set the defaults
		$this->componentHead[] = $this->_t(2) . '<action name="core.create" title="JACTION_CREATE" description="JACTION_CREATE_COMPONENT_DESC" />';
		$this->componentHead[] = $this->_t(2) . '<action name="core.delete" title="JACTION_DELETE" description="JACTION_DELETE_COMPONENT_DESC" />';
		$this->componentHead[] = $this->_t(2) . '<action name="core.edit" title="JACTION_EDIT" description="JACTION_EDIT_COMPONENT_DESC" />';
		$this->componentHead[] = $this->_t(2) . '<action name="core.edit.state" title="JACTION_EDITSTATE" description="JACTION_ACCESS_EDITSTATE_DESC" />';
		$this->componentHead[] = $this->_t(2) . '<action name="core.edit.own" title="JACTION_EDITOWN" description="JACTION_EDITOWN_COMPONENT_DESC" />';
		// set the Joomla fields
		if ($this->setJoomlaFields)
		{
			$this->componentHead[] = $this->_t(2) . '    <action name="core.edit.value" title="JACTION_EDITVALUE" description="JACTION_EDITVALUE_COMPONENT_DESC" />';
		}
		// new custom created by permissions
		$created_byTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Edit Created By', 'U');
		$created_byDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Edit Created By', 'U') . '_DESC';
		$this->setLangContent('bothadmin', $created_byTitle, 'Edit Created By');
		$this->setLangContent('bothadmin', $created_byDesc, ' Allows users in this group to edit created by.');
		$this->componentHead[] = $this->_t(2) . '<action name="core.edit.created_by" title="' . $created_byTitle . '" description="' . $created_byDesc . '" />';
		// new custom created date permissions
		$createdTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Edit Created Date', 'U');
		$createdDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString('Edit Created Date', 'U') . '_DESC';
		$this->setLangContent('bothadmin', $createdTitle, 'Edit Created Date');
		$this->setLangContent('bothadmin', $createdDesc, ' Allows users in this group to edit created date.');
		$this->componentHead[] = $this->_t(2) . '<action name="core.edit.created" title="' . $createdTitle . '" description="' . $createdDesc . '" />';

		// set the menu controller lookup
		$menuControllers = array('access', 'submenu', 'dashboard_list', 'dashboard_add');
		// set the custom admin views permissions
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $custom_admin_view)
			{
				// new custom permissions to access this view
				$customAdminName = $custom_admin_view['settings']->name;
				$customAdminCode = $custom_admin_view['settings']->code;
				$customAdminTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($customAdminName . ' Access', 'U');
				$customAdminDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($customAdminName . ' Access', 'U') . '_DESC';
				$sortKey = ComponentbuilderHelper::safeString($customAdminName . ' Access');
				$this->setLangContent('bothadmin', $customAdminTitle, $customAdminName . ' Access');
				$this->setLangContent('bothadmin', $customAdminDesc,  ' Allows the users in this group to access ' . ComponentbuilderHelper::safeString($customAdminName, 'w') . '.');
				$this->componentGlobal[$sortKey] = $this->_t(2) . '<action name="' . $customAdminCode . '.access" title="' . $customAdminTitle . '" description="' . $customAdminDesc . '" />';
				// add the custom permissions to use the buttons of this view
				$this->addCustomButtonPermissions($custom_admin_view['settings'], $customAdminName, $customAdminCode);
				// add menu controll view that has menus options
				foreach ($menuControllers as $menuController)
				{
					// add menu controll view that has menus options
					if (isset($custom_admin_view[$menuController]) && $custom_admin_view[$menuController])
					{
						$targetView_ = 'views.';
						if ($menuController === 'dashboard_add')
						{
							$targetView_ = 'view.';
						}
						// menucontroller
						$menucontrollerView['action'] = $targetView_ . $menuController;
						$menucontrollerView['implementation'] = '2';
						if (isset($custom_admin_view['settings']->permissions) && ComponentbuilderHelper::checkArray($custom_admin_view['settings']->permissions))
						{
							array_push($custom_admin_view['settings']->permissions, $menucontrollerView);
						}
						else
						{
							$custom_admin_view['settings']->permissions = array();
							$custom_admin_view['settings']->permissions[] = $menucontrollerView;
						}
						unset($menucontrollerView);
					}
				}
				$this->buildPermissions($custom_admin_view, $customAdminCode, $customAdminCode, $menuControllers, 'customAdmin');
			}
		}
		// set the site views permissions
		if (isset($this->componentData->site_views) && ComponentbuilderHelper::checkArray($this->componentData->site_views))
		{
			foreach ($this->componentData->site_views as $site_view)
			{
				// new custom permissions to access this view
				$siteName = $site_view['settings']->name;
				$siteCode = $site_view['settings']->code;
				$siteTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($siteName . ' Access Site', 'U');
				$siteDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($siteName . ' Access Site', 'U') . '_DESC';
				$sortKey = ComponentbuilderHelper::safeString($siteName . ' Access Site');
				if (isset($site_view['access']) && $site_view['access'] == 1)
				{
					$this->setLangContent('bothadmin', $siteTitle, $siteName . ' (Site) Access');
					$this->setLangContent('bothadmin', $siteDesc, ' Allows the users in this group to access site ' . ComponentbuilderHelper::safeString($siteName, 'w') . '.');
					$this->componentGlobal[$sortKey] = $this->_t(2) . '<action name="site.' . $siteCode . '.access" title="' . $siteTitle . '" description="' . $siteDesc . '" />';

					// check if this site view requires access rule to default to public
					if (isset($site_view['public_access']) && $site_view['public_access'] == 1)
					{
						// we use one as public group (TODO we see if we run into any issues)
						$this->assetsRules[] = '"site.' . $siteCode . '.access":{"1":1}';
					}
				}
				// add the custom permissions to use the buttons of this view
				$this->addCustomButtonPermissions($site_view['settings'], $siteName, $siteCode);
			}
		}
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			foreach ($this->componentData->admin_views as $view)
			{
				// set view name
				$nameView = ComponentbuilderHelper::safeString($view['settings']->name_single);
				$nameViews = ComponentbuilderHelper::safeString($view['settings']->name_list);
				// add custom tab permissions if found
				if (isset($this->customTabs[$nameView]) && ComponentbuilderHelper::checkArray($this->customTabs[$nameView]))
				{
					foreach ($this->customTabs[$nameView] as $_customTab)
					{
						if (isset($_customTab['permission']) && $_customTab['permission'] == 1)
						{
							$this->componentGlobal[$_customTab['sortKey']] = $this->_t(2) . '<action name="' . $_customTab['view'] . '.' . $_customTab['code'] . '.viewtab" title="' . $_customTab['lang_permission'] . '" description="' . $_customTab['lang_permission_desc'] . '" />';
						}
					}
				}
				// add the custom permissions to use the buttons of this view
				$this->addCustomButtonPermissions($view['settings'], $view['settings']->name_single, $nameView);
				if ($nameView != 'component')
				{
					// add menu controll view that has menus options
					foreach ($menuControllers as $menuController)
					{
						// add menu controll view that has menus options
						if (isset($view[$menuController]) && $view[$menuController])
						{
							$targetView_ = 'views.';
							if ($menuController === 'dashboard_add')
							{
								$targetView_ = 'view.';
							}
							// menucontroller
							$menucontrollerView['action'] = $targetView_ . $menuController;
							$menucontrollerView['implementation'] = '2';
							if (isset($view['settings']->permissions) && ComponentbuilderHelper::checkArray($view['settings']->permissions))
							{
								array_push($view['settings']->permissions, $menucontrollerView);
							}
							else
							{
								$view['settings']->permissions = array();
								$view['settings']->permissions[] = $menucontrollerView;
							}
							unset($menucontrollerView);
						}
					}
					// check if there are fields
					if (ComponentbuilderHelper::checkArray($view['settings']->fields))
					{
						// field permission options
						$permission_options = array(1 => 'edit', 2 => 'access', 3 => 'view');
						// check the fields for their permission settings
						foreach ($view['settings']->fields as $field)
						{
							// see if field require permissions to be set
							if (isset($field['permission']) && ComponentbuilderHelper::checkArray($field['permission']))
							{
								if (ComponentbuilderHelper::checkArray($field['settings']->properties))
								{
									$fieldType = $this->getFieldType($field);
									$fieldName = $this->getFieldName($field, $nameViews);
									// loop the permission options
									foreach ($field['permission'] as $permission_id)
									{
										// set the permission key word
										$permission_option = $permission_options[ (int) $permission_id];
										// reset the bucket
										$fieldView = array();
										// set the permission for this field
										$fieldView['action'] = 'view.' . $permission_option . '.' . $fieldName;
										$fieldView['implementation'] = '3';
										// check if persmissions was already set
										if (isset($view['settings']->permissions) && ComponentbuilderHelper::checkArray($view['settings']->permissions))
										{
											array_push($view['settings']->permissions, $fieldView);
										}
										else
										{
											$view['settings']->permissions = array();
											$view['settings']->permissions[] = $fieldView;
										}
										// insure that no default field get loaded
										if (!in_array($fieldName, $this->defaultFields))
										{
											// make sure the array is set
											if (!isset($this->permissionFields[$nameView]) || !ComponentbuilderHelper::checkArray($this->permissionFields[$nameView]))
											{
												$this->permissionFields[$nameView] = array();
											}
											if (!isset($this->permissionFields[$nameView][$fieldName]) || !ComponentbuilderHelper::checkArray($this->permissionFields[$nameView][$fieldName]))
											{
												$this->permissionFields[$nameView][$fieldName] = array();
											}
											// load to global field permission set
											$this->permissionFields[$nameView][$fieldName][$permission_option] = $fieldType;
										}
									}
								}
							}
						}
					}
					$this->buildPermissions($view, $nameView, $nameViews, $menuControllers);
				}
			}

			// Trigger Event: jcb_ce_onAfterBuildAccessSections
			$this->triggerEvent('jcb_ce_onAfterBuildAccessSections', array(&$this->componentContext, $this));

			// set the views permissions now
			if (ComponentbuilderHelper::checkArray($this->permissionViews))
			{
				foreach ($this->permissionViews as $viewName => $actions)
				{
					$componentViews[] = $this->_t(1) . '<section name="' . $viewName . '">';
					foreach ($actions as $action)
					{
						$componentViews[] = $this->_t(2) . $action;
					}
					$componentViews[] = $this->_t(1) . "</section>";
				}
			}
			/// now build the section
			$component = implode(PHP_EOL, $this->componentHead);
			// sort the array to insure easy search
			ksort($this->componentGlobal, SORT_STRING);
			// add global to the compnent section
			$component .= PHP_EOL . implode(PHP_EOL, $this->componentGlobal) . PHP_EOL . $this->_t(1) . "</section>";
			// add views to the compnent section
			$component .= PHP_EOL . implode(PHP_EOL, $componentViews);
			// be sure to reset again. (memory)
			$this->componentHead = null;
			$this->componentGlobal = null;
			$this->permissionViews = null;
			// return the build
			return $component;
		}
		return false;
	}

	protected function addCustomButtonPermissions($settings, $nameView, $code)
	{
		// add the custom permissions to use the buttons of this view
		if (isset($settings->custom_buttons) && ComponentbuilderHelper::checkArray($settings->custom_buttons))
		{
			foreach ($settings->custom_buttons as $custom_buttons)
			{
				$customButtonName = $custom_buttons['name'];
				$customButtonCode = ComponentbuilderHelper::safeString($customButtonName);
				$customButtonTitle = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($nameView . ' ' . $customButtonName . ' Button Access', 'U');
				$customButtonDesc = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($nameView . ' ' . $customButtonName . ' Button Access', 'U') . '_DESC';
				$sortButtonKey = ComponentbuilderHelper::safeString($nameView . ' ' . $customButtonName . ' Button Access');
				$this->setLangContent('bothadmin', $customButtonTitle, $nameView . ' ' . $customButtonName . ' Button Access');
				$this->setLangContent('bothadmin', $customButtonDesc, ' Allows the users in this group to access the ' . ComponentbuilderHelper::safeString($customButtonName, 'w') . ' button.');
				$this->componentGlobal[$sortButtonKey] = $this->_t(2) . '<action name="' . $code . '.' . $customButtonCode . '" title="' . $customButtonTitle . '" description="' . $customButtonDesc . '" />';
			}
		}
	}

	public function buildPermissions(&$view, $nameView, $nameViews, $menuControllers, $type = 'admin')
	{
		if (isset($view['settings']->permissions) && ComponentbuilderHelper::checkArray($view['settings']->permissions) || (isset($view['port']) && $view['port']) || (isset($view['history']) && $view['history']))
		{
			// add export/import permissions to each view that has export/import options
			if (isset($view['port']) && $view['port'])
			{
				// export
				$exportView['action'] = 'view.export';
				$exportView['implementation'] = '2';
				if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
				{
					array_push($view['settings']->permissions, $exportView);
				}
				else
				{
					$view['settings']->permissions = array();
					$view['settings']->permissions[] = $exportView;
				}
				// import
				$importView['action'] = 'view.import';
				$importView['implementation'] = '2';
				if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
				{
					array_push($view['settings']->permissions, $importView);
				}
				else
				{
					$view['settings']->permissions = array();
					$view['settings']->permissions[] = $importView;
				}
			}
			// add version opstions to each view that has it added
			if (isset($view['history']) && $view['history'])
			{
				// set version control
				$versionView['action'] = 'view.version';
				$versionView['implementation'] = '3';
				if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
				{
					array_push($view['settings']->permissions, $versionView);
				}
				else
				{
					$view['settings']->permissions = array();
					$view['settings']->permissions[] = $versionView;
				}
			}
			// add batch permissions
			if ($type === 'admin')
			{
				// set batch control
				$batchView['action'] = 'view.batch';
				$batchView['implementation'] = '2';
				if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
				{
					array_push($view['settings']->permissions, $batchView);
				}
				else
				{
					$view['settings']->permissions = array();
					$view['settings']->permissions[] = $batchView;
				}
			}
			// load the permissions
			foreach ($view['settings']->permissions as $permission)
			{
				// set acction name
				$arr = explode('.', trim($permission['action']));
				if ($arr[0] != 'core' || $arr[0] === 'view')
				{
					array_shift($arr);
					$actionMain = implode('.', $arr);
					$action = $nameView . '.' . $actionMain;
				}
				else
				{
					if ($arr[0] === 'core')
					{
						// core is already set in global access
						$permission['implementation'] = 1;
					}
					$action = $permission['action'];
				}
				// build action name
				$actionNameBuilder = explode('.', trim($permission['action']));
				array_shift($actionNameBuilder);
				$nameBuilder = trim(implode('___', $actionNameBuilder));
				$customName = trim(implode(' ', $actionNameBuilder));
				// check if we have access set for this view (if not skip)
				if ($nameBuilder === 'edit___access' && $type === 'admin' && (!isset($view['access']) || $view['access'] != 1))
				{
					continue;
				}
				// build the names
				if ($type === 'admin')
				{
					$W_NameList = ComponentbuilderHelper::safeString($view['settings']->name_list, 'W');
					$w_NameList = ComponentbuilderHelper::safeString($customName . ' ' . $view['settings']->name_list, 'w');
					$w_NameSingle = ComponentbuilderHelper::safeString($view['settings']->name_single, 'w');
				}
				elseif ($type === 'customAdmin')
				{
					$W_NameList = ComponentbuilderHelper::safeString($view['settings']->name, 'W');
					$w_NameList = $view['settings']->name;
					$w_NameSingle = $view['settings']->name;
				}
				// set title (only if not set already)
				if (!isset($permission['title']) || !ComponentbuilderHelper::checkString($permission['title']))
				{
					// set the title based on the name builder
					switch ($nameBuilder)
					{
						case 'edit':
							// set edit title
							$permission['title'] = $W_NameList . ' Edit';
							break;
						case 'edit___own':
							// set edit title
							$permission['title'] = $W_NameList . ' Edit Own';
							break;
						case 'edit___access':
							// set edit title
							$permission['title'] = $W_NameList . ' Edit Access';
							break;
						case 'edit___state':
							// set edit title
							$permission['title'] = $W_NameList . ' Edit State';
							break;
						case 'edit___created_by':
							// set edit title
							$permission['title'] = $W_NameList . ' Edit Created By';
							break;
						case 'edit___created':
							// set edit title
							$permission['title'] = $W_NameList . ' Edit Created Date';
							break;
						case 'create':
							// set edit title
							$permission['title'] = $W_NameList . ' Create';
							break;
						case 'delete':
							// set edit title
							$permission['title'] = $W_NameList . ' Delete';
							break;
						case 'access':
							// set edit title
							$permission['title'] = $W_NameList . ' Access';
							break;
						case 'export':
							// set edit title
							$permission['title'] = $W_NameList . ' Export';
							break;
						case 'import':
							// set edit title
							$permission['title'] = $W_NameList . ' Import';
							break;
						case 'version':
							// set edit title
							$permission['title'] = $W_NameList . ' Edit Version';
							break;
						case 'batch':
							// set edit title
							$permission['title'] = $W_NameList . ' Batch Use';
							break;
						default:
							// set edit title
							$permission['title'] = $W_NameList . ' ' . ComponentbuilderHelper::safeString($customName, 'W');
							break;
					}
				}
				// set description (only if not set already)
				if (!isset($permission['description']) || !ComponentbuilderHelper::checkString($permission['description']))
				{
					// set the title based on the name builder
					switch ($nameBuilder)
					{
						case 'edit':
							// set edit description
							$permission['description'] = ' Allows the users in this group to edit the ' . $w_NameSingle;
							break;
						case 'edit___own':
							// set edit description
							$permission['description'] = ' Allows the users in this group to edit ' . $w_NameList . ' created by them';
							break;
						case 'edit___access':
							// set edit description
							$permission['description'] = ' Allows the users in this group to change the access of the ' . $w_NameList;
							break;
						case 'edit___state':
							// set edit description
							$permission['description'] = ' Allows the users in this group to update the state of the ' . $w_NameSingle;
							break;
						case 'edit___created_by':
							// set edit description
							$permission['description'] = ' Allows the users in this group to update the created by of the ' . $w_NameList;
							break;
						case 'edit___created':
							// set edit description
							$permission['description'] = ' Allows the users in this group to update the created date of the ' . $w_NameList;
							break;
						case 'create':
							// set edit description
							$permission['description'] = ' Allows the users in this group to create ' . $w_NameList;
							break;
						case 'delete':
							// set edit description
							$permission['description'] = ' Allows the users in this group to delete ' . $w_NameList;
							break;
						case 'access':
							// set edit description
							$permission['description'] = ' Allows the users in this group to access ' . $w_NameList;
							break;
						case 'export':
							// set edit description
							$permission['description'] = ' Allows the users in this group to export ' . $w_NameList;
							break;
						case 'import':
							// set edit description
							$permission['description'] = ' Allows the users in this group to import ' . $w_NameList;
							break;
						case 'version':
							// set edit description
							$permission['description'] = ' Allows users in this group to edit versions of ' . $w_NameList;
							break;
						case 'batch':
							// set edit description
							$permission['description'] = ' Allows users in this group to use batch copy/update method of ' . $w_NameList;
							break;
						default:
							// set edit description
							$permission['description'] = ' Allows the users in this group to ' . ComponentbuilderHelper::safeString($customName, 'w') . ' of ' . $w_NameSingle;
							break;
					}
				}
				// if core is not used update all core strings
				$coreCheck = explode('.', $action);
				$coreCheck[0] = 'core';
				$coreTarget = implode('.', $coreCheck);
				$this->permissionCore[$nameView][$coreTarget] = $action;
				// set array sort name
				$sortKey = ComponentbuilderHelper::safeString($permission['title']);
				// set title
				$title = $this->langPrefix . '_' . ComponentbuilderHelper::safeString($permission['title'], 'U');
				// load the actions
				if ($permission['implementation'] == 1)
				{
					// only related to view
					$this->permissionViews[$nameView][] = '<action name="' . $action . '" title="' . $title . '" description="' . $title . '_DESC" />';
					// load permission to action
					$this->permissionBuilder[$action][$nameView] = $nameView;
				}
				elseif ($permission['implementation'] == 2)
				{
					// relation to whole component
					$this->componentGlobal[$sortKey] = $this->_t(2) . '<action name="' . $action . '" title="' . $title . '" description="' . $title . '_DESC" />';
					// build permission switch
					$this->permissionBuilder['global'][$action][$nameView] = $nameView;
					// dashboard icon checker
					if ($coreTarget === 'core.access')
					{
						$this->permissionDashboard[] = "'" . $nameViews . ".access' => '" . $action . "'";
						$this->permissionDashboard[] = "'" . $nameView . ".access' => '" . $action . "'";
					}
					if ($coreTarget === 'core.create')
					{
						$this->permissionDashboard[] = "'" . $nameView . ".create' => '" . $action . "'";
					}
					// add menu controll view that has menus options
					foreach ($menuControllers as $menuController)
					{
						if ($coreTarget === 'core.' . $menuController)
						{
							if ($menuController === 'dashboard_add')
							{
								$this->permissionDashboard[] = "'" . $nameView . "." . $menuController . "' => '" . $action . "'";
							}
							else
							{
								$this->permissionDashboard[] = "'" . $nameViews . "." . $menuController . "' => '" . $action . "'";
							}
						}
					}
				}
				elseif ($permission['implementation'] == 3)
				{
					// only related to view
					$this->permissionViews[$nameView][] = '<action name="' . $action . '" title="' . $title . '" description="' . $title . '_DESC" />';
					// load permission to action
					$this->permissionBuilder[$action][$nameView] = $nameView;
					// relation to whole component
					$this->componentGlobal[$sortKey] = $this->_t(2) . '<action name="' . $action . '" title="' . $title . '" description="' . $title . '_DESC" />';
					// build permission switch
					$this->permissionBuilder['global'][$action][$nameView] = $nameView;
					// dashboard icon checker
					if ($coreTarget === 'core.access')
					{
						$this->permissionDashboard[] = "'" . $nameViews . ".access' => '" . $action . "'";
						$this->permissionDashboard[] = "'" . $nameView . ".access' => '" . $action . "'";
					}
					if ($coreTarget === 'core.create')
					{
						$this->permissionDashboard[] = "'" . $nameView . ".create' => '" . $action . "'";
					}
					// add menu controll view that has menus options
					foreach ($menuControllers as $menuController)
					{
						if ($coreTarget === 'core.' . $menuController)
						{
							if ($menuController === 'dashboard_add')
							{
								$this->permissionDashboard[] = "'" . $nameView . "." . $menuController . "' => '" . $action . "'";
							}
							else
							{
								$this->permissionDashboard[] = "'" . $nameViews . "." . $menuController . "' => '" . $action . "'";
							}
						}
					}
				}
				// set to language file
				$this->setLangContent('bothadmin', $title, $permission['title']);
				$this->setLangContent('bothadmin', $title . '_DESC', $permission['description']);
			}
		}
	}

	public function getInbetweenStrings($str, $start = '#' . '#' . '#', $end = '#' . '#' . '#')
	{
		$matches = array();
		$regex = "/$start([a-zA-Z0-9_]*)$end/";
		preg_match_all($regex, $str, $matches);
		return $matches[1];
	}

	public function getModCode(&$module)
	{
		// get component helper string
		$Helper = $this->fileContentStatic[$this->hhh . 'Component' . $this->hhh] . 'Helper';
		$component = $this->fileContentStatic[$this->hhh . 'component' . $this->hhh];
		$_helper = '';
		// get libraries code
		$libraries = array($this->bbb . 'MOD_LIBRARIES' . $this->ddd  => $this->getModLibCode($module));
		$code = $this->setPlaceholders($module->mod_code, $libraries);
		// check if component helper class should be added
		if (strpos($code, $Helper . '::') !== false && strpos($code, "/components/com_" . $component . "/helpers/" . $component . ".php") === false)
		{
			$_helper = '//' . $this->setLine(__LINE__) . ' Include the component helper functions only once';
			$_helper .= PHP_EOL . "JLoader::register('". $Helper . "', JPATH_ADMINISTRATOR . '/components/com_" . $component . "/helpers/" . $component . ".php');";
		}
		return $_helper . PHP_EOL . $code . PHP_EOL;
	}

	public function getModDefault(&$module)
	{
		return PHP_EOL . $module->default_header . PHP_EOL . '?>' . PHP_EOL . $module->default . PHP_EOL;
	}

	public function getModHelperCode(&$module)
	{
		return
			$module->class_helper_header . PHP_EOL .
			$module->class_helper_type . $module->class_helper_name . PHP_EOL . '{' . PHP_EOL .
			$module->class_helper_code . PHP_EOL .
			"}" . PHP_EOL;
	}

	public function getModLibCode(&$module)
	{
		$setter = '';
		if (isset($this->libManager[$module->key][$module->code_name]) && ComponentbuilderHelper::checkArray($this->libManager[$module->key][$module->code_name]))
		{
			$setter .= '//' . $this->setLine(__LINE__) . 'get the document object';
			$setter .= PHP_EOL . '$document = JFactory::getDocument();';
			foreach ($this->libManager[$module->key][$module->code_name] as $id => $true)
			{
				if (isset($this->libraries[$id]) && ComponentbuilderHelper::checkObject($this->libraries[$id]) && isset($this->libraries[$id]->document) && ComponentbuilderHelper::checkString($this->libraries[$id]->document))
				{
					$setter .= PHP_EOL . $this->libraries[$id]->document;
				}
				elseif (isset($this->libraries[$id]) && ComponentbuilderHelper::checkObject($this->libraries[$id]) && isset($this->libraries[$id]->how))
				{
					$setter .= $this->setLibraryDocument($id);
				}
			}
		}
		// check if we have string
		if (ComponentbuilderHelper::checkString($setter))
		{
			return $this->setPlaceholders(
				str_replace('$this->document->', '$document->',
					implode(PHP_EOL,
						array_map(trim,
							(array) explode(PHP_EOL, $setter)
						)
					)
				),
				$this->placeholders);
		}
		return '';
	}

	public function getModuleMainXML(&$module)
	{
		// set the custom table key
		$dbkey = 'yyy';
		// build the xml
		$xml = '';
		// search if we must add the component path
		$add_component_path = false;
		// build the config fields
		$config_fields = array();
		if (isset($module->config_fields) && ComponentbuilderHelper::checkArray($module->config_fields))
		{
			foreach ($module->config_fields as $field_name => $fieldsets)
			{
				foreach ($fieldsets as $fieldset => $fields)
				{
					// get the field set
					$xmlFields = $this->getExtensionFieldsetXML($module, $fields, $dbkey);
					// make sure the xml is set and a string
					if (isset($xmlFields) && ComponentbuilderHelper::checkString($xmlFields))
					{
						$config_fields[$field_name . $fieldset] = $xmlFields;
					}
					$dbkey++;
					// check if the fieldset path requiers component paths
					if (!$add_component_path && isset($module->fieldsets_paths[$field_name . $fieldset]) && $module->fieldsets_paths[$field_name . $fieldset] == 1)
					{
						$add_component_path = true;
					}
				}
			}
		}
		// switch to add the xml
		$addLang = false;
		// now build the language files
		if (isset($this->langContent[$module->key]))
		{
			$lang = array_map(function ($langstring, $placeholder)
			{
				return $placeholder . '="' . $langstring . '"';
			}, $this->langContent[$module->key], array_keys($this->langContent[$module->key]));
			// add to language file
			$this->writeFile($module->folder_path . '/language/' . $this->langTag . '/' . $this->langTag . '.' . $module->file_name . '.ini', implode(PHP_EOL, $lang));
			$this->writeFile($module->folder_path . '/language/' . $this->langTag . '/' . $this->langTag . '.' . $module->file_name . '.sys.ini', implode(PHP_EOL, $lang));
			// set the line counter
			$this->lineCount = $this->lineCount + count((array) $lang);
			unset($lang);
			// trigger the xml
			$addLang = true;
		}
		// get all files and folders in module folder
		$files = JFolder::files($module->folder_path);
		$folders = JFolder::folders($module->folder_path);
		// the files/folders to ignore
		$ignore = array('sql', 'language', 'script.php', $module->file_name . '.xml', $module->file_name . '.php');
		// should the scriptfile be added
		if ($module->add_install_script)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Scripts to run on installation -->';
			$xml .= PHP_EOL . $this->_t(1) . '<scriptfile>script.php</scriptfile>';
		}
		// should the sql install be added
		if ($module->add_sql)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Runs on install; New in Joomla 1.5 -->';
			$xml .= PHP_EOL . $this->_t(1) . '<install>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(3) . '<file driver="mysql" charset="utf8">sql/mysql/install.sql</file>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(1) . '</install>';
		}
		// should the sql uninstall be added
		if ($module->add_sql_uninstall)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Runs on uninstall; New in Joomla 1.5 -->';
			$xml .= PHP_EOL . $this->_t(1) . '<uninstall>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(3) . '<file driver="mysql" charset="utf8">sql/mysql/uninstall.sql</file>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(1) . '</uninstall>';
		}
		// should the language xml be added
		if ($addLang)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Language files -->';
			$xml .= PHP_EOL . $this->_t(1) . '<languages folder="language">';
			$xml .= PHP_EOL . $this->_t(2) . '<language tag="en-GB">' . $this->langTag . '/' . $this->langTag . '.' . $module->file_name . '.ini</language>';
			$xml .= PHP_EOL . $this->_t(2) . '<language tag="en-GB">' . $this->langTag . '/' . $this->langTag . '.' . $module->file_name . '.sys.ini</language>';
			$xml .= PHP_EOL . $this->_t(1) . '</languages>';
		}
		// add the module files
		$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Model files -->';
		$xml .= PHP_EOL . $this->_t(1) . '<files>';
		$xml .= PHP_EOL . $this->_t(2) . '<filename module="' . $module->file_name . '">'  . $module->file_name . '.php</filename>';
		// add other files found
		if (ComponentbuilderHelper::checkArray($files))
		{
			foreach ($files as $file)
			{
				// only add what is not ignored
				if (!in_array($file, $ignore))
				{
					$xml .= PHP_EOL . $this->_t(2) . '<filename>'  . $file . '</filename>';
				}
			}
		}
		// add language folder
		if ($addLang)
		{
			$xml .= PHP_EOL . $this->_t(2) . '<folder>language</folder>';
		}
		// add sql folder
		if ($module->add_sql || $module->add_sql_uninstall)
		{
			$xml .= PHP_EOL . $this->_t(2) . '<folder>sql</folder>';
		}
		// add other files found
		if (ComponentbuilderHelper::checkArray($folders))
		{
			foreach ($folders as $folder)
			{
				// only add what is not ignored
				if (!in_array($folder, $ignore))
				{
					$xml .= PHP_EOL . $this->_t(2) . '<folder>'  . $folder . '</folder>';
				}
			}
		}
		$xml .= PHP_EOL . $this->_t(1) . '</files>';
		// now add the Config Params if needed
		if (ComponentbuilderHelper::checkArray($config_fields))
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Config parameter -->';
			// only add if part of the component field types path is required
			if ($add_component_path)
			{
				// add path to module rules and custom fields
				$xml .= PHP_EOL . $this->_t(1) . '<config';
				$xml .= PHP_EOL . $this->_t(2) . 'addrulepath="/administrator/components/com_' . $this->componentCodeName . '/modules/rules"';
				$xml .= PHP_EOL . $this->_t(2) . 'addfieldpath="/administrator/components/com_' . $this->componentCodeName . '/modules/fields"';
				$xml .= PHP_EOL . $this->_t(1) . '>';
			}
			else
			{
				$xml .= PHP_EOL . $this->_t(1) . '<config>';
			}
			// add the fields
			foreach ($module->config_fields as $field_name => $fieldsets)
			{
				$xml .= PHP_EOL . $this->_t(1) . '<fields name="' . $field_name . '">';
				foreach ($fieldsets as $fieldset => $fields)
				{
					// default to the field set name
					$label = $fieldset;
					if (isset($module->fieldsets_label[$field_name.$fieldset]))
					{
						$label = $module->fieldsets_label[$field_name.$fieldset];
					}
					// add path to module rules and custom fields
					if (isset($module->fieldsets_paths[$field_name . $fieldset]) && $module->fieldsets_paths[$field_name . $fieldset] == 2)
					{
						$xml .= PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' default paths of ' . $fieldset . ' fieldset points to the module -->';
						$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="' . $fieldset . '" label="' . $label . '"';
						$xml .= PHP_EOL . $this->_t(2) . 'addrulepath="/modules/' . $module->file_name . '/rules"';
						$xml .= PHP_EOL . $this->_t(2) . 'addfieldpath="/modules/' . $module->file_name . '/fields"';
						$xml .= PHP_EOL . $this->_t(1) . '>';
					}
					else
					{
						$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="' . $fieldset . '" label="' . $label . '">';
					}
					// load the fields
					if (isset($config_fields[$field_name.$fieldset]))
					{
						$xml .= $config_fields[$field_name.$fieldset];
						unset($config_fields[$field_name.$fieldset]);
					}
					$xml .= PHP_EOL . $this->_t(1) . '</fieldset>';
				}
				$xml .= PHP_EOL . $this->_t(1) . '</fields>';
			}
			$xml .= PHP_EOL . $this->_t(1) . '</config>';
		}
		// set update server if found
		if ($module->add_update_server)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Update servers -->';
			$xml .= PHP_EOL . $this->_t(1) . '<updateservers>';
			$xml .= PHP_EOL . $this->_t(2) . '<server type="extension" priority="1" name="' . $module->official_name . '">' . $module->update_server_url . '</server>';
			$xml .= PHP_EOL . $this->_t(1) . '</updateservers>';
		}

		return $xml;
	}

	public function getPluginMainClass(&$plugin)
	{
		return
			PHP_EOL . $plugin->head . PHP_EOL .
			$plugin->comment . PHP_EOL . 'class ' .
			$plugin->class_name . ' extends ' .
			$plugin->extends . PHP_EOL . '{' . PHP_EOL .
			$plugin->main_class_code . PHP_EOL .
			"}" . PHP_EOL;
	}

	public function getPluginMainXML(&$plugin)
	{
		// set some defaults
		$view = '';
		$viewType = 0;
		// set the custom table key
		$dbkey = 'yy';
		// build the xml
		$xml = '';
		// search if we must add the component path
		$add_component_path = false;
		// build the config fields
		$config_fields = array();
		if (isset($plugin->config_fields) && ComponentbuilderHelper::checkArray($plugin->config_fields))
		{
			foreach ($plugin->config_fields as $field_name => $fieldsets)
			{
				foreach ($fieldsets as $fieldset => $fields)
				{
					// get the field set
					$xmlFields = $this->getExtensionFieldsetXML($plugin, $fields, $dbkey);
					// make sure the xml is set and a string
					if (isset($xmlFields) && ComponentbuilderHelper::checkString($xmlFields))
					{
						$config_fields[$field_name . $fieldset] = $xmlFields;
					}
					$dbkey++;
					// check if the fieldset path requiers component paths
					if (!$add_component_path && isset($plugin->fieldsets_paths[$field_name . $fieldset]) && $plugin->fieldsets_paths[$field_name . $fieldset] == 1)
					{
						$add_component_path = true;
					}
				}
			}
		}
		// switch to add the xml
		$addLang = false;
		// now build the language files
		if (isset($this->langContent[$plugin->key]))
		{
			$lang = array_map(function ($langstring, $placeholder)
			{
				return $placeholder . '="' . $langstring . '"';
			}, $this->langContent[$plugin->key], array_keys($this->langContent[$plugin->key]));
			// add to language file
			$this->writeFile($plugin->folder_path . '/language/' . $this->langTag . '/' . $this->langTag . '.plg_' . strtolower($plugin->group) . '_' . strtolower($plugin->code_name) . '.ini', implode(PHP_EOL, $lang));
			$this->writeFile($plugin->folder_path . '/language/' . $this->langTag . '/' . $this->langTag . '.plg_' . strtolower($plugin->group) . '_' . strtolower($plugin->code_name) . '.sys.ini', implode(PHP_EOL, $lang));
			// set the line counter
			$this->lineCount = $this->lineCount + count((array) $lang);
			unset($lang);
			// trigger the xml
			$addLang = true;
		}
		// get all files and folders in plugin folder
		$files = JFolder::files($plugin->folder_path);
		$folders = JFolder::folders($plugin->folder_path);
		// the files/folders to ignore
		$ignore = array('sql', 'language', 'script.php', $plugin->file_name . '.xml', $plugin->file_name . '.php');
		// should the scriptfile be added
		if ($plugin->add_install_script)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Scripts to run on installation -->';
			$xml .= PHP_EOL . $this->_t(1) . '<scriptfile>script.php</scriptfile>';
		}
		// should the sql install be added
		if ($plugin->add_sql)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Runs on install; New in Joomla 1.5 -->';
			$xml .= PHP_EOL . $this->_t(1) . '<install>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(3) . '<file driver="mysql" charset="utf8">sql/mysql/install.sql</file>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(1) . '</install>';
		}
		// should the sql uninstall be added
		if ($plugin->add_sql_uninstall)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Runs on uninstall; New in Joomla 1.5 -->';
			$xml .= PHP_EOL . $this->_t(1) . '<uninstall>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(3) . '<file driver="mysql" charset="utf8">sql/mysql/uninstall.sql</file>';
			$xml .= PHP_EOL . $this->_t(2) . '<sql>';
			$xml .= PHP_EOL . $this->_t(1) . '</uninstall>';
		}
		// should the language xml be added
		if ($addLang)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Language files -->';
			$xml .= PHP_EOL . $this->_t(1) . '<languages folder="language">';
			$xml .= PHP_EOL . $this->_t(2) . '<language tag="en-GB">' . $this->langTag . '/' . $this->langTag . '.plg_' . strtolower($plugin->group) . '_' . strtolower($plugin->code_name) . '.ini</language>';
			$xml .= PHP_EOL . $this->_t(2) . '<language tag="en-GB">' . $this->langTag . '/' . $this->langTag . '.plg_' . strtolower($plugin->group) . '_' . strtolower($plugin->code_name) . '.sys.ini</language>';
			$xml .= PHP_EOL . $this->_t(1) . '</languages>';
		}
		// add the plugin files
		$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Plugin files -->';
		$xml .= PHP_EOL . $this->_t(1) . '<files>';
		$xml .= PHP_EOL . $this->_t(2) . '<filename plugin="' . $plugin->file_name . '">'  . $plugin->file_name . '.php</filename>';
		// add other files found
		if (ComponentbuilderHelper::checkArray($files))
		{
			foreach ($files as $file)
			{
				// only add what is not ignored
				if (!in_array($file, $ignore))
				{
					$xml .= PHP_EOL . $this->_t(2) . '<filename>'  . $file . '</filename>';
				}
			}
		}
		// add language folder
		if ($addLang)
		{
			$xml .= PHP_EOL . $this->_t(2) . '<folder>language</folder>';
		}
		// add sql folder
		if ($plugin->add_sql || $plugin->add_sql_uninstall)
		{
			$xml .= PHP_EOL . $this->_t(2) . '<folder>sql</folder>';
		}
		// add other files found
		if (ComponentbuilderHelper::checkArray($folders))
		{
			foreach ($folders as $folder)
			{
				// only add what is not ignored
				if (!in_array($folder, $ignore))
				{
					$xml .= PHP_EOL . $this->_t(2) . '<folder>'  . $folder . '</folder>';
				}
			}
		}
		$xml .= PHP_EOL . $this->_t(1) . '</files>';
		// now add the Config Params if needed
		if (ComponentbuilderHelper::checkArray($config_fields))
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Config parameter -->';
			// only add if part of the component field types path is required
			if ($add_component_path)
			{
				// add path to plugin rules and custom fields
				$xml .= PHP_EOL . $this->_t(1) . '<config';
				$xml .= PHP_EOL . $this->_t(2) . 'addrulepath="/administrator/components/com_' . $this->componentCodeName . '/models/rules"';
				$xml .= PHP_EOL . $this->_t(2) . 'addfieldpath="/administrator/components/com_' . $this->componentCodeName . '/models/fields"';
				$xml .= PHP_EOL . $this->_t(1) . '>';
			}
			else
			{
				$xml .= PHP_EOL . $this->_t(1) . '<config>';
			}
			// add the fields
			foreach ($plugin->config_fields as $field_name => $fieldsets)
			{
				$xml .= PHP_EOL . $this->_t(1) . '<fields name="' . $field_name . '">';
				foreach ($fieldsets as $fieldset => $fields)
				{
					// default to the field set name
					$label = $fieldset;
					if (isset($plugin->fieldsets_label[$field_name.$fieldset]))
					{
						$label = $plugin->fieldsets_label[$field_name.$fieldset];
					}
					// add path to plugin rules and custom fields
					if (isset($plugin->fieldsets_paths[$field_name . $fieldset]) && $plugin->fieldsets_paths[$field_name . $fieldset] == 2)
					{
						$xml .= PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' default paths of ' . $fieldset . ' fieldset points to the plugin -->';
						$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="' . $fieldset . '" label="' . $label . '"';
						$xml .= PHP_EOL . $this->_t(2) . 'addrulepath="/plugins/' . strtolower($plugin->group) . '/' . strtolower($plugin->code_name) . '/rules"';
						$xml .= PHP_EOL . $this->_t(2) . 'addfieldpath="/plugins/' . strtolower($plugin->group) . '/' . strtolower($plugin->code_name) . '/fields"';
						$xml .= PHP_EOL . $this->_t(1) . '>';
					}
					else
					{
						$xml .= PHP_EOL . $this->_t(1) . '<fieldset name="' . $fieldset . '" label="' . $label . '">';
					}
					// load the fields
					if (isset($config_fields[$field_name.$fieldset]))
					{
						$xml .= $config_fields[$field_name.$fieldset];
						unset($config_fields[$field_name.$fieldset]);
					}
					$xml .= PHP_EOL . $this->_t(1) . '</fieldset>';
				}
				$xml .= PHP_EOL . $this->_t(1) . '</fields>';
			}
			$xml .= PHP_EOL . $this->_t(1) . '</config>';
		}
		// set update server if found
		if ($plugin->add_update_server)
		{
			$xml .= PHP_EOL . PHP_EOL . $this->_t(1) . '<!--' . $this->setLine(__LINE__) . ' Update servers -->';
			$xml .= PHP_EOL . $this->_t(1) . '<updateservers>';
			$xml .= PHP_EOL . $this->_t(2) . '<server type="extension" priority="1" name="' . $plugin->official_name . '">' . $plugin->update_server_url . '</server>';
			$xml .= PHP_EOL . $this->_t(1) . '</updateservers>';
		}

		return $xml;
	}

	public function getExtensionFieldsetXML(&$extension, &$fields, $dbkey = 'zz')
	{
		// set some defaults
		$view = '';
		$viewType = 0;
		// build the fieldset
		$fieldset = '';

		if (ComponentbuilderHelper::checkArray($fields))
		{
			foreach ($fields as $field)
			{
				// check the field builder type
				if ($this->fieldBuilderType == 1)
				{
					// string manipulation
					$xmlField = $this->setDynamicField($field, $view, $viewType, $extension->lang_prefix, $extension->key, $extension->key, $this->globalPlaceholders, $dbkey, false);
				}
				else
				{
					// simpleXMLElement class
					$newxmlField = $this->setDynamicField($field, $view, $viewType, $extension->lang_prefix, $extension->key, $extension->key, $this->globalPlaceholders, $dbkey, false);
					if (isset($newxmlField->fieldXML))
					{
						$xmlField = dom_import_simplexml($newxmlField->fieldXML);
						$xmlField = PHP_EOL . $this->_t(2) . "<!--" . $this->setLine(__LINE__) . " " . $newxmlField->comment . ' -->' . PHP_EOL . $this->_t(1) . $this->xmlPrettyPrint($xmlField, 'field');
					}
				}
				// make sure the xml is set and a string
				if (isset($xmlField) && ComponentbuilderHelper::checkString($xmlField))
				{
					$fieldset .= $xmlField;
				}
			}
		}
		return $fieldset;
	}

	public function getExtensionInstallClass(&$extension)
	{
		// yes we are adding it
		$script = PHP_EOL . '/**';
		$script .= PHP_EOL . ' * ' . $extension->official_name . ' script file.';
		$script .= PHP_EOL . ' *';
		$script .= PHP_EOL . ' * @package ' . $extension->class_name;
		$script .= PHP_EOL . ' */';
		$script .= PHP_EOL . 'class ' . $extension->installer_class_name;
		$script .= PHP_EOL . '{';
		// set constructor
		if (isset($extension->add_php_script_construct)
			&& $extension->add_php_script_construct == 1
			&& ComponentbuilderHelper::checkString($extension->php_script_construct))
		{
			$script .= $this->setInstallMethodScript('construct', $extension->php_script_construct);
		}
		// add PHP in extension install
		$addScriptMethods = array('php_preflight', 'php_postflight', 'php_method');
		$addScriptTypes = array('install', 'update', 'uninstall', 'discover_install');
		// set some buckets for sorting
		$function_install = array();
		$function_update = array();
		$function_uninstall = array();
		$has_php_preflight = false;
		$function_php_preflight = array('install' => array(), 'uninstall' => array(), 'discover_install' => array(), 'update' => array());
		$has_php_postflight = false;
		$function_php_postflight = array('install' => array(), 'uninstall' => array(), 'discover_install' => array(), 'update' => array());
		// the function sorter
		foreach ($addScriptMethods as $scriptMethod)
		{
			foreach ($addScriptTypes as $scriptType)
			{
				if (isset($extension->{'add_' . $scriptMethod . '_' . $scriptType})
					&& $extension->{'add_' . $scriptMethod . '_' . $scriptType} == 1
					&& ComponentbuilderHelper::checkString($extension->{$scriptMethod . '_' . $scriptType}))
				{
					// add to the main methods
					if ('php_method' === $scriptMethod)
					{
						${'function_' . $scriptType}[] = $extension->{$scriptMethod . '_' . $scriptType};
					}
					else
					{
						${'function_' . $scriptMethod}[$scriptType][] = $extension->{$scriptMethod . '_' . $scriptType};
						${'has_' . $scriptMethod} = true;
					}
				}
			}
		}
		// now add the install script.
		if (ComponentbuilderHelper::checkArray($function_install))
		{
			$script .= $this->setInstallMethodScript('install', $function_install);
		}
		// now add the update script.
		if (ComponentbuilderHelper::checkArray($function_update))
		{
			$script .= $this->setInstallMethodScript('update', $function_update);
		}
		// now add the uninstall script.
		if (ComponentbuilderHelper::checkArray($function_uninstall))
		{
			$script .= $this->setInstallMethodScript('uninstall', $function_uninstall);
		}
		// now add the preflight script.
		if ($has_php_preflight)
		{
			$script .= $this->setInstallMethodScript('preflight', $function_php_preflight);
		}
		// now add the postflight script.
		if ($has_php_postflight)
		{
			$script .= $this->setInstallMethodScript('postflight', $function_php_postflight);
		}
		$script .= PHP_EOL . '}' . PHP_EOL;

		return $script;
	}

	protected function setInstallMethodScript($function_name, &$scripts)
	{
		$script = '';
		// build function
		switch($function_name)
		{
			case 'install':
			case 'update':
			case 'uninstall':
				// the main function types
				$script = PHP_EOL . PHP_EOL . $this->_t(1) .'/**';
				$script .= PHP_EOL . $this->_t(1) .' * Called on ' . $function_name;
				$script .= PHP_EOL . $this->_t(1) .' *';
				$script .= PHP_EOL . $this->_t(1) .' * @param   JAdapterInstance  $adapter  The object responsible for running this script';
				$script .= PHP_EOL . $this->_t(1) .' *';
				$script .= PHP_EOL . $this->_t(1) .' * @return  boolean  True on success';
				$script .= PHP_EOL . $this->_t(1) .' */';
				$script .= PHP_EOL . $this->_t(1) .'public function ' . $function_name . '(JAdapterInstance $adapter)';
				$script .= PHP_EOL . $this->_t(1) .'{';
				$script .= PHP_EOL . implode(PHP_EOL . PHP_EOL, $scripts);
				// return true
				if ('uninstall' !== $function_name)
				{
					$script .= PHP_EOL . $this->_t(2) . 'return true;';
				}
				break;
			case 'preflight':
			case 'postflight':
				// the pre/post function types
				$script = PHP_EOL . PHP_EOL . $this->_t(1) .'/**';
				$script .= PHP_EOL . $this->_t(1) .' * Called before any type of action';
				$script .= PHP_EOL . $this->_t(1) .' *';
				$script .= PHP_EOL . $this->_t(1) .' * @param   string  $route  Which action is happening (install|uninstall|discover_install|update)';
				$script .= PHP_EOL . $this->_t(1) .' * @param   JAdapterInstance  $adapter  The object responsible for running this script';
				$script .= PHP_EOL . $this->_t(1) .' *';
				$script .= PHP_EOL . $this->_t(1) .' * @return  boolean  True on success';
				$script .= PHP_EOL . $this->_t(1) .' */';
				$script .= PHP_EOL . $this->_t(1) .'public function ' . $function_name . '($route, JAdapterInstance $adapter)';
				$script .= PHP_EOL . $this->_t(1) .'{';
				$script .= PHP_EOL . $this->_t(2) . '//' . $this->setLine(__LINE__) . ' get application';
				$script .= PHP_EOL . $this->_t(2) . '$app = JFactory::getApplication();' . PHP_EOL;
				// add the default version check (TODO) must make this dynamic
				if ('preflight' === $function_name)
				{
					$script .= PHP_EOL . $this->_t(2) . '//' . $this->setLine(__LINE__) . ' the default for both install and update';
					$script .= PHP_EOL . $this->_t(2) . '$jversion = new JVersion();';
					$script .= PHP_EOL . $this->_t(2) . "if (!\$jversion->isCompatible('3.8.0'))";
					$script .= PHP_EOL . $this->_t(2) . '{';
					$script .= PHP_EOL . $this->_t(3) . "\$app->enqueueMessage('Please upgrade to at least Joomla! 3.8.0 before continuing!', 'error');";
					$script .= PHP_EOL . $this->_t(3) . 'return false;';
					$script .= PHP_EOL . $this->_t(2) . '}' . PHP_EOL;
				}
				// now add the scripts
				foreach ($scripts as $route => $_script)
				{
					if (ComponentbuilderHelper::checkArray($_script))
					{
						// set the if and script
						$script .= PHP_EOL . $this->_t(2) . "if ('" . $route . "' === \$route)";
						$script .= PHP_EOL . $this->_t(2) . '{';
						$script .= PHP_EOL . implode(PHP_EOL . PHP_EOL, $_script);
						$script .= PHP_EOL . $this->_t(2) . '}' . PHP_EOL;
					}
				}
				// return true
				$script .= PHP_EOL . $this->_t(2) . 'return true;';
				break;
			case 'construct':
				// the __construct script
				$script = PHP_EOL . PHP_EOL . $this->_t(1) .'/**';
				$script .= PHP_EOL . $this->_t(1) .' * Constructor';
				$script .= PHP_EOL . $this->_t(1) .' *';
				$script .= PHP_EOL . $this->_t(1) .' * @param   JAdapterInstance  $adapter  The object responsible for running this script';
				$script .= PHP_EOL . $this->_t(1) .' */';
				$script .= PHP_EOL . $this->_t(1) .'public function __construct(JAdapterInstance $adapter)';
				$script .= PHP_EOL . $this->_t(1) .'{';
				$script .= PHP_EOL . $scripts;
				break;
			default:
				// oops error
				return '';
		}
		// close the function
		$script .= PHP_EOL . $this->_t(1) . '}';

		return $script;
	}

}
