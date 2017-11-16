<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.6.0
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		compiler.php
	@author			Llewellyn van der Merwe <http://www.vdm.io>
	@my wife		Roline van der Merwe <http://www.vdm.io/>	
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Compiler class
 */
class Interpretation extends Fields
{	
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
	 * The edit body script builder
	 * 
	 * @var    array
	 */
	public $editBodyViewScriptBuilder = array();
	
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
	 * View Has Id Request
	 * 
	 * @var    array
	 */
	protected $hasIdRequest = array();

	/**
	 * Constructor
	 */
	public function __construct($config = array ())
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
	 * @return  void
	 * 
	 */
	private function setLine($nr)
	{
		if ($this->debugLinenr)
		{
			return ' [Interpretation '.$nr.']';	
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
			$component = $this->fileContentStatic['###component###'];
			$Component = $this->fileContentStatic['###Component###'];
			$target = array('admin' => 'emailer');
			$done = $this->buildDynamique($target,'emailer',$component);
			if ($done)
			{
				// the text for the file ###BAKING###
				$this->fileContentDynamic['emailer_'.$component]['###BAKING###'] = ''; // <<-- to insure it gets updated
				// return the code need to load the abstract class
				return PHP_EOL."JLoader::register('".$Component."Email', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/".$component."email.php'); ";
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
			if (!isset($this->fileContentStatic['###HELPER_SITE_LICENSE_LOCK###']))
			{
				$_VDM = '_'.ComponentbuilderHelper::safeString($this->uniquekey(10),'U');
				// add it to the system
				$this->fileContentStatic['###HELPER_SITE_LICENSE_LOCK###'] = $this->setHelperLincenseLock($_VDM,'site');
				$this->fileContentStatic['###HELPER_LICENSE_LOCK###'] = $this->setHelperLincenseLock($_VDM,'admin');
				$this->fileContentStatic['###LICENSE_LOCKED_INT###'] = $this->setInitLincenseLock($_VDM);
				$this->fileContentStatic['###LICENSE_LOCKED_DEFINED###'] = PHP_EOL.PHP_EOL.'defined(\''.$_VDM.'\') or die(JText::_(\'NIE_REG_NIE\'));';
			}
		}
		else
		{
			// don't add it to the system
			$this->fileContentStatic['###HELPER_SITE_LICENSE_LOCK###'] = '';
			$this->fileContentStatic['###HELPER_LICENSE_LOCK###'] = '';
			$this->fileContentStatic['###LICENSE_LOCKED_INT###'] = '';
			$this->fileContentStatic['###LICENSE_LOCKED_DEFINED###'] = '';
		}
	}

	/**
	 * @param $view
	*/
	public function setLockLicensePer(&$view, $target)
	{
		if ($this->componentData->add_license && $this->componentData->license_type == 3)
		{
			if (!isset($this->fileContentDynamic[$view]['###BOOLMETHOD###']))
			{
				$boolMethod	= 'get'.ComponentbuilderHelper::safeString($this->uniquekey(3, false, 'ddd'), 'W');
				$globalbool	= 'set'.ComponentbuilderHelper::safeString($this->uniquekey(3), 'W');
				// add it to the system
				$this->fileContentDynamic[$view]['###LICENSE_LOCKED_SET_BOOL###']	= $this->setBoolLincenseLock($boolMethod,$globalbool);
				$this->fileContentDynamic[$view]['###LICENSE_LOCKED_CHECK###']		= $this->checkStatmentLicenseLocked($boolMethod);
				$this->fileContentDynamic[$view]['###LICENSE_TABLE_LOCKED_CHECK###']	= $this->checkStatmentLicenseLocked($boolMethod, '$table');
				$this->fileContentDynamic[$view]['###BOOLMETHOD###']			= $boolMethod;
			}
		}
		else
		{
			// don't add it to the system
			$this->fileContentDynamic[$view]['###LICENSE_LOCKED_SET_BOOL###']	= '';
			$this->fileContentDynamic[$view]['###LICENSE_LOCKED_CHECK###']		= '';
			$this->fileContentDynamic[$view]['###LICENSE_TABLE_LOCKED_CHECK###']	= '';
		}
	}
	
	public function checkStatmentLicenseLocked($boolMethod, $thIIS = '$this')
	{
		$statment[] = PHP_EOL."\t\tif (!".$thIIS."->".$boolMethod."())";
		$statment[] = "\t\t{";
		$statment[] = "\t\t\t\$app = JFactory::getApplication();";
		$statment[] = "\t\t\t\$app->enqueueMessage(JText::_('NIE_REG_NIE'), 'error');";
		$statment[] = "\t\t\t\$app->redirect('index.php');";
		$statment[] = "\t\t\treturn false;";
		$statment[] = "\t\t}";
		// return the genuine mentod statement
		return implode(PHP_EOL, $statment);
	}
	
	public function setBoolLincenseLock($boolMethod,$globalbool)
	{
		$bool[] = PHP_EOL.PHP_EOL."\t/**";
		$bool[] = "\t* The private bool.";
		$bool[] = "\t**/";
		$bool[] = "\tprivate $".$globalbool.";";
		$bool[] = PHP_EOL."\t/**";
		$bool[] = "\t* Check if this install has a license.";
		$bool[] = "\t**/";
		$bool[] = "\tpublic function ".$boolMethod."()";
		$bool[] = "\t{";
		$bool[] = "\t\tif(!empty(\$this->".$globalbool."))";
		$bool[] = "\t\t{";
		$bool[] = "\t\t\treturn \$this->".$globalbool.";";
		$bool[] = "\t\t}";
		$bool[] = "\t\t//".$this->setLine(__LINE__)." Get the global params";
		$bool[] = "\t\t\$params = JComponentHelper::getParams('com_".$this->fileContentStatic['###component###']."', true);";
		$bool[] = "\t\t\$license_key = \$params->get('license_key', null);";
		$bool[] = "\t\tif (\$license_key)";
		$bool[] = "\t\t{";
		$bool[] = "\t\t\t//".$this->setLine(__LINE__)." load the file";
		$bool[] = "\t\t\tJLoader::import( 'vdm', JPATH_ADMINISTRATOR .'/components/com_".$this->fileContentStatic['###component###']."');";
		$bool[] = "\t\t\t\$the = new VDM(\$license_key);";
		$bool[] = "\t\t\t\$this->".$globalbool." = \$the->_is;";
		$bool[] = "\t\t\treturn \$this->".$globalbool.";";
		$bool[] = "\t\t}";
		$bool[] = "\t\treturn false;";
		$bool[] = "\t}";
		// return the genuine mentod statement
		return implode(PHP_EOL, $bool);
	}
	
	public function setHelperLincenseLock($_VDM,$target)
	{
		$helper[] = PHP_EOL.PHP_EOL."\t/**";
		$helper[] = "\t* Check if this install has a license.";
		$helper[] = "\t**/";
		$helper[] = "\tpublic static function isGenuine()";
		$helper[] = "\t{";
		$helper[] = "\t\t//".$this->setLine(__LINE__)." Get the global params";
		$helper[] = "\t\t\$params = JComponentHelper::getParams('com_".$this->fileContentStatic['###component###']."', true);";
		$helper[] = "\t\t\$license_key = \$params->get('license_key', null);";
		$helper[] = "\t\tif (\$license_key)";
		$helper[] = "\t\t{";
		$helper[] = "\t\t\t//".$this->setLine(__LINE__)." load the file";
		$helper[] = "\t\t\tJLoader::import( 'vdm', JPATH_ADMINISTRATOR .'/components/com_".$this->fileContentStatic['###component###']."');";
		$helper[] = "\t\t\t\$the = new VDM(\$license_key);";
		$helper[] = "\t\t\treturn \$the->_is;";
		$helper[] = "\t\t}";
		$helper[] = "\t\treturn false;";
		$helper[] = "\t}";
		// return the genuine mentod statement
		return implode(PHP_EOL, $helper);
	}
	
	public function setInitLincenseLock($_VDM)
	{
		$init[] = PHP_EOL."if (!defined('".$_VDM."'))";
		$init[] = "{";
		$init[] = "\t\$allow = ".$this->fileContentStatic['###Component###']."Helper::isGenuine();";
		$init[] = "\tif (\$allow)";
		$init[] = "\t{";
		$init[] = "\t\tdefine('".$_VDM."', 1);";
		$init[] = "\t}";
		$init[] = "}";
		// return the initializing statement
		return implode(PHP_EOL, $init);
	}
	
	public function setVDMCryption()
	{
		// make sure we have the correct file
		if (isset($this->componentData->whmcs_key) && ComponentbuilderHelper::checkString($this->componentData->whmcs_key))
		{
			// Get the basic encryption.
			$basickey = ComponentbuilderHelper::getCryptKey('basic');
			// Get the encryption object.
			$basic = new FOFEncryptAes($basickey, 128);
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
				$encrypt[] = "* ".$this->setLine(__LINE__)."VDM Class ";
				$encrypt[] = "**/";
				$encrypt[] = PHP_EOL."class VDM";
				$encrypt[] = "{";
				$encrypt[] = "\tpublic \$_key = false;";
				$encrypt[] = "\tpublic \$_is = false;";
				$encrypt[] = "\t";
				$encrypt[] = "\tpublic function __construct(\$Vk5smi0wjnjb)";
				$encrypt[] = "\t{";
				$encrypt[] = "\t\t// get the session";
				$encrypt[] = "\t\t\$session = JFactory::getSession();";
				$encrypt[] = "\t\t\$V2uekt2wcgwk = \$session->get(\$Vk5smi0wjnjb, null);";
				$encrypt[] = "\t\t\$h4sgrGsqq = \$this->get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk);";
				$encrypt[] = "\t\tif (isset(\$h4sgrGsqq['nuut']) && \$h4sgrGsqq['nuut'] && (isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['eiegrendel']) && strlen(\$h4sgrGsqq['eiegrendel']) > 300)";
				$encrypt[] = "\t\t{";
				$encrypt[] = "\t\t\t\$session->set(\$Vk5smi0wjnjb, \$h4sgrGsqq['eiegrendel']);";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tif ((isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 && isset(\$h4sgrGsqq['customfields']) && strlen(\$h4sgrGsqq['customfields']) > 4)";
				$encrypt[] = "\t\t{";
				$encrypt[] = "\t\t\t\$this->_key = md5(\$h4sgrGsqq['customfields']);";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tif ((isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 )";
				$encrypt[] = "\t\t{";
				$encrypt[] = "\t\t\t\$this->_is = true;";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t}";
				$encrypt[] = "\t";
				$encrypt[] = "\tprivate function get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk)";
				$encrypt[] = "\t{";
				$encrypt[] = "\t\t\$Viioj50xuqu2 = unserialize(base64_decode('".$theKey."'));";
				$encrypt[] = "\t\t\$Visqfrd1caus = time() . md5(mt_rand(1000000000, 9999999999) . \$Vk5smi0wjnjb);";
				$encrypt[] = "\t\t\$Vo4tezfgcf3e = date(\"Ymd\");";
				$encrypt[] = "\t\t\$Vozblwvfym2f = \$_SERVER['SERVER_NAME'];";
				$encrypt[] = "\t\t\$Vozblwvfym2fdie = isset(\$_SERVER['SERVER_ADDR']) ? \$_SERVER['SERVER_ADDR'] : \$_SERVER['LOCAL_ADDR'];";
				$encrypt[] = "\t\t\$V343jp03dxco = dirname(__FILE__);";
				$encrypt[] = "\t\t\$Vc2rayehw4f0 = unserialize(base64_decode('czozNjoibW9kdWxlcy9zZXJ2ZXJzL2xpY2Vuc2luZy92ZXJpZnkucGhwIjs='));";
				$encrypt[] = "\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\tif (\$V2uekt2wcgwk) {";
				$encrypt[] = "\t\t\t\$V2uekt2wcgwk = str_replace(\"".'".PHP_EOL."'."\", '', \$V2uekt2wcgwk);";
				$encrypt[] = "\t\t\t\$Vm5cxjdc43g4 = substr(\$V2uekt2wcgwk, 0, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = "\t\t\t\$Vbgx0efeu2sy = substr(\$V2uekt2wcgwk, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = "\t\t\tif (\$Vbgx0efeu2sy == md5(\$Vm5cxjdc43g4 . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4 = strrev(\$Vm5cxjdc43g4);";
				$encrypt[] = "\t\t\t\t\$Vbgx0efeu2sy = substr(\$Vm5cxjdc43g4, 0, 32);";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4 = substr(\$Vm5cxjdc43g4, 32);";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4 = base64_decode(\$Vm5cxjdc43g4);";
				$encrypt[] = "\t\t\t\t\$Vm5cxjdc43g4finding = unserialize(\$Vm5cxjdc43g4);";
				$encrypt[] = "\t\t\t\t\$V3qqz0p00fbq  = \$Vm5cxjdc43g4finding['dan'];";
				$encrypt[] = "\t\t\t\tif (\$Vbgx0efeu2sy == md5(\$V3qqz0p00fbq  . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = "\t\t\t\t\t\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = "\t\t\t\t\tif (\$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = "\t\t\t\t\t\t\$Vlpolphukogz = true;";
				$encrypt[] = "\t\t\t\t\t\t\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = "\t\t\t\t\t\t\$Vcixw3trerrt = explode(',', \$Vwasqoybpyed['validdomain']);";
				$encrypt[] = "\t\t\t\t\t\tif (!in_array(\$_SERVER['SERVER_NAME'], \$Vcixw3trerrt)) {";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t\t\$Vkni3xyhkqzv = explode(',', \$Vwasqoybpyed['validip']);";
				$encrypt[] = "\t\t\t\t\t\tif (!in_array(\$Vozblwvfym2fdie, \$Vkni3xyhkqzv)) {";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t\t\$Vckfvnepoaxj = explode(',', \$Vwasqoybpyed['validdirectory']);";
				$encrypt[] = "\t\t\t\t\t\tif (!in_array(\$V343jp03dxco, \$Vckfvnepoaxj)) {";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vlpolphukogz = false;";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tif (!\$Vlpolphukogz) {";
				$encrypt[] = "\t\t\t\$V1u0c4dl3ehp = array(";
				$encrypt[] = "\t\t\t\t'licensekey' => \$Vk5smi0wjnjb,";
				$encrypt[] = "\t\t\t\t'domain' => \$Vozblwvfym2f,";
				$encrypt[] = "\t\t\t\t'ip' => \$Vozblwvfym2fdie,";
				$encrypt[] = "\t\t\t\t'dir' => \$V343jp03dxco,";
				$encrypt[] = "\t\t\t);";
				$encrypt[] = "\t\t\tif (\$Visqfrd1caus) \$V1u0c4dl3ehp['check_token'] = \$Visqfrd1caus;";
				$encrypt[] = "\t\t\t\$Vdsjeyjmpq2o = '';";
				$encrypt[] = "\t\t\tforeach (\$V1u0c4dl3ehp AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = "\t\t\t\t\$Vdsjeyjmpq2o .= \$V2sgyscukmgi.'='.urlencode(\$V1u00zkzmb1d).'&';";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (function_exists('curl_exec')) {";
				$encrypt[] = "\t\t\t\t\$Vdathuqgjyf0 = curl_init();";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_URL, \$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_POST, 1);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_POSTFIELDS, \$Vdsjeyjmpq2o);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_TIMEOUT, 30);";
				$encrypt[] = "\t\t\t\tcurl_setopt(\$Vdathuqgjyf0, CURLOPT_RETURNTRANSFER, 1);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5 = curl_exec(\$Vdathuqgjyf0);";
				$encrypt[] = "\t\t\t\tcurl_close(\$Vdathuqgjyf0);";
				$encrypt[] = "\t\t\t} else {";
				$encrypt[] = "\t\t\t\t\$Vrpmu4bvnmkp = fsockopen(\$Viioj50xuqu2['kasier'], 80, \$Vc0t5kmpwkwk, \$Va3g41fnofhu, 5);";
				$encrypt[] = "\t\t\t\tif (\$Vrpmu4bvnmkp) {";
				$encrypt[] = "\t\t\t\t\t\$Vznkm0a0me1y = \"\r".PHP_EOL."\";";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop = \"POST \".\$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0 . \" HTTP/1.0\" . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Host: \".\$Viioj50xuqu2['kasier'] . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Content-type: application/x-www-form-urlencoded\" . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Content-length: \".@strlen(\$Vdsjeyjmpq2o) . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \"Connection: close\" . \$Vznkm0a0me1y . \$Vznkm0a0me1y;";
				$encrypt[] = "\t\t\t\t\t\$V2sgyscukmgiop .= \$Vdsjeyjmpq2o;";
				$encrypt[] = "\t\t\t\t\t\$Vqojefyeohg5 = '';";
				$encrypt[] = "\t\t\t\t\t@stream_set_timeout(\$Vrpmu4bvnmkp, 20);";
				$encrypt[] = "\t\t\t\t\t@fputs(\$Vrpmu4bvnmkp, \$V2sgyscukmgiop);";
				$encrypt[] = "\t\t\t\t\t\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = "\t\t\t\t\twhile (!@feof(\$Vrpmu4bvnmkp)&&\$V2czq24pjexf) {";
				$encrypt[] = "\t\t\t\t\t\t\$Vqojefyeohg5 .= @fgets(\$Vrpmu4bvnmkp, 1024);";
				$encrypt[] = "\t\t\t\t\t\t\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = "\t\t\t\t\t}";
				$encrypt[] = "\t\t\t\t\t@fclose (\$Vqojefyeohg5);";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (!\$Vqojefyeohg5) {";
				$encrypt[] = "\t\t\t\t\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = "\t\t\t\tif (isset(\$V3qqz0p00fbq) && \$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = "\t\t\t\t} else {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['description'] = \"Remote Check Failed\";";
				$encrypt[] = "\t\t\t\t\treturn \$Vwasqoybpyed;";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t} else {";
				$encrypt[] = "\t\t\t\tpreg_match_all('".'/<(.*?)>([^<]+)<\/\\1>/i'."', \$Vqojefyeohg5, \$V1ot20wob03f);";
				$encrypt[] = "\t\t\t\t\$Vwasqoybpyed = array();";
				$encrypt[] = "\t\t\t\tforeach (\$V1ot20wob03f[1] AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed[\$V1u00zkzmb1d] = \$V1ot20wob03f[2][\$V2sgyscukmgi];";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (!is_array(\$Vwasqoybpyed)) {";
				$encrypt[] = "\t\t\t\tdie(\"Invalid License Server Response\");";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (isset(\$Vwasqoybpyed['md5hash']) && \$Vwasqoybpyed['md5hash']) {";
				$encrypt[] = "\t\t\t\tif (\$Vwasqoybpyed['md5hash'] != md5(\$Viioj50xuqu2['geheim'] . \$Visqfrd1caus)) {";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = "\t\t\t\t\t\$Vwasqoybpyed['description'] = \"MD5 Checksum Verification Failed\";";
				$encrypt[] = "\t\t\t\t\treturn \$Vwasqoybpyed;";
				$encrypt[] = "\t\t\t\t}";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\tif (isset(\$Vwasqoybpyed['status']) && \$Vwasqoybpyed['status'] == \"Active\") {";
				$encrypt[] = "\t\t\t\t\$Vwasqoybpyed['dan'] = \$Vo4tezfgcf3e;";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = serialize(\$Vwasqoybpyed);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = base64_encode(\$Vqojefyeohg5ing);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = md5(\$Vo4tezfgcf3e . \$Viioj50xuqu2['geheim']) . \$Vqojefyeohg5ing;";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = strrev(\$Vqojefyeohg5ing);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = \$Vqojefyeohg5ing . md5(\$Vqojefyeohg5ing . \$Viioj50xuqu2['geheim']);";
				$encrypt[] = "\t\t\t\t\$Vqojefyeohg5ing = wordwrap(\$Vqojefyeohg5ing, 80, \"".'".PHP_EOL."'."\", true);";
				$encrypt[] = "\t\t\t\t\$Vwasqoybpyed['eiegrendel'] = \$Vqojefyeohg5ing;";
				$encrypt[] = "\t\t\t}";
				$encrypt[] = "\t\t\t\$Vwasqoybpyed['nuut'] = true;";
				$encrypt[] = "\t\t}";
				$encrypt[] = "\t\tunset(\$V1u0c4dl3ehp,\$Vqojefyeohg5,\$V1ot20wob03f,\$Viioj50xuqu2['kasier'],\$Viioj50xuqu2['geheim'],\$Vo4tezfgcf3e,\$Vozblwvfym2fdie,\$Viioj50xuqu2['onthou'],\$Vbgx0efeu2sy);";
				$encrypt[] = "\t\treturn \$Vwasqoybpyed;";
				$encrypt[] = "\t}";
				$encrypt[] = "}";

				// return the help methods
				return implode(PHP_EOL,$encrypt);
			}
		}
		return '';
	}

	public function setGetCryptKey()
	{
		// ###ENCRYPT_FILE###
		$this->fileContentStatic['###ENCRYPT_FILE###'] = '';
		if ((isset($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder)) || (isset($this->advancedEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder)) || $this->componentData->add_license)
		{
			if (isset($this->advancedEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder) || $this->componentData->add_license)
			{
				// set advanced encrypt file into place
				$target = array('admin' => 'encrypt');
				$done = $this->buildDynamique($target,'encrypt');
				// the text for the file ###VDM_ENCRYPTION_BODY###
				$this->fileContentDynamic['encrypt']['###VDM_ENCRYPTION_BODY###'] = $this->setVDMCryption();
				// ###ENCRYPT_FILE###
				$this->fileContentStatic['###ENCRYPT_FILE###'] = PHP_EOL."\t\t\t<filename>vdm.php</filename>";
			}
			// get component name
			$component	= $this->fileContentStatic['###component###'];
			// set the getCryptKey function to the helper class
			$function = array();
			if (isset($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder))
			{
				$function[] = PHP_EOL.PHP_EOL."\tpublic static function getCryptKey(\$type, \$default = null)";
				$function[] = "\t{";
				$function[] = "\t\t//".$this->setLine(__LINE__)." Get the global params";
				$function[] = "\t\t\$params = JComponentHelper::getParams('com_".$component."', true);";
				$function[] = "\t\tif ('advanced' === \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t\$advanced_key = \$params->get('advanced_key', \$default);";
				$function[] = "\t\t\tif (\$advanced_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." load the file";
				$function[] = "\t\t\t\tJLoader::import( 'vdm', JPATH_COMPONENT_ADMINISTRATOR);";
				$function[] = PHP_EOL."\t\t\t\t\$the = new VDM(\$advanced_key);";
				$function[] = PHP_EOL."\t\t\t\treturn \$the->_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\telseif ('basic' === \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t\$basic_key = \$params->get('basic_key', \$default);";
				$function[] = "\t\t\tif (\$basic_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\treturn \$basic_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\treturn false;";
				$function[] = "\t}";
			}
			elseif (isset($this->advancedEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder))
			{
				$function[] = PHP_EOL.PHP_EOL."\tpublic static function getCryptKey(\$type, \$default = null)";
				$function[] = "\t{";
				$function[] = "\t\tif ('advanced' === \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t//".$this->setLine(__LINE__)." Get the global params";
				$function[] = "\t\t\t\$params = JComponentHelper::getParams('com_".$component."', true);";
				$function[] = "\t\t\t\$advanced_key = \$params->get('advanced_key', \$default);";
				$function[] = "\t\t\tif (\$advanced_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." load the file";
				$function[] = "\t\t\t\tJLoader::import( 'vdm', JPATH_COMPONENT_ADMINISTRATOR);";
				$function[] = PHP_EOL."\t\t\t\t\$the = new VDM(\$advanced_key);";
				$function[] = PHP_EOL."\t\t\t\treturn \$the->_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\treturn false;";
				$function[] = "\t}";
			}
			elseif (isset($this->basicEncryptionBuilder) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder))
			{
				$function[] = PHP_EOL.PHP_EOL."\tpublic static function getCryptKey(\$type, \$default = null)";
				$function[] = "\t{";
				$function[] = "\t\tif ('basic' === \$type)";
				$function[] = "\t\t{";
				$function[] = "\t\t\t//".$this->setLine(__LINE__)." Get the global params";
				$function[] = "\t\t\t\$params = JComponentHelper::getParams('com_".$component."', true);";
				$function[] = "\t\t\t\$basic_key = \$params->get('basic_key', \$default);";
				$function[] = "\t\t\tif (\$basic_key)";
				$function[] = "\t\t\t{";
				$function[] = "\t\t\t\treturn \$basic_key;";
				$function[] = "\t\t\t}";
				$function[] = "\t\t}";
				$function[] = "\t\treturn false;";
				$function[] = "\t}";
			}
			// return the help methods
			return implode(PHP_EOL,$function);
		}
		return '';
	}
	
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
				// ###UPDATE_SERVER_XML###
				$name = str_replace('.xml', '', substr($this->componentData->update_server, strrpos($this->componentData->update_server, '/') + 1));
				$target = array('admin' => $name);
				$this->buildDynamique($target,'update_server');
				$this->fileContentDynamic[$name]['###UPDATE_SERVER_XML###'] = implode(PHP_EOL, $updateXML);
				
				// set the Update server file name
				$this->updateServerFileName = $name;
			}
		}
		// add the update server link to component XML
		if ($this->componentData->add_update_server && isset($this->componentData->update_server) && ComponentbuilderHelper::checkString($this->componentData->update_server))
		{
			// ###UPDATESERVER###
			$updateServer = array();
			$updateServer[] = PHP_EOL."\t<updateservers>";
			$updateServer[] = "\t\t".'<server type="extension" enabled="1" element="com_'.$this->fileContentStatic['###component###'].'" name="'.$this->fileContentStatic['###Component_name###'].'">'.$this->componentData->update_server.'</server>';
			$updateServer[] = "\t</updateservers>";
			// return the array to string
			$updateServer = implode(PHP_EOL, $updateServer);
			// add update server details to component XML file
			$this->fileContentStatic['###UPDATESERVER###'] = $updateServer;
		}
		else
		{
			// add update server details to component XML file
			$this->fileContentStatic['###UPDATESERVER###'] = '';
		}
		// ensure to update Component version data
		if (ComponentbuilderHelper::checkArray($this->updateSQLBuilder))
		{
			$buket = array();
			$nr = 0;
			foreach ($this->componentData->version_update as $values)
			{
				$buket['version_update'.$nr] = $values;
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
			$update_['mysql'] = trim(implode(PHP_EOL.PHP_EOL, $this->updateSQLBuilder));
			// setup URL
			if (isset($this->lastupdateURL))
			{
				$paceholders = array(
					$this->componentData->component_version => $this->componentData->old_component_version,
					str_replace('.','-', $this->componentData->component_version) => str_replace('.','-', $this->componentData->old_component_version),
					str_replace('.','_', $this->componentData->component_version) => str_replace('.','_', $this->componentData->old_component_version),
					str_replace('.','', $this->componentData->component_version) => str_replace('.','', $this->componentData->old_component_version)
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
		if ($addDynamicSQL && ComponentbuilderHelper::checkArray($this->updateSQLBuilder)
			&& (isset($this->componentData->old_component_version) && $this->componentData->old_component_version == $update['version']))
		{
			$searchMySQL = preg_replace('/\s+/', '', $update['mysql']);
			// add the updates to the SQL only if not found
			foreach ($this->updateSQLBuilder as $search => $query)
			{
				if (strpos($searchMySQL, $search) === FALSE)
				{
					$update['mysql'] .= PHP_EOL.PHP_EOL.$query;
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
			$this->buildDynamique($target,'sql_update',$update['version']);
			$this->fileContentDynamic[$name.'_'.$update['version']]['###UPDATE_VERSION_MYSQL###'] = $update['mysql'];
		}
		elseif (isset($update['url']) && ComponentbuilderHelper::checkString($update['url']))
		{
			$this->lastupdateURL = $update['url'];
		}
		// add the update server
		if ($this->componentData->add_update_server && $this->componentData->update_server_target != 3)
		{
			// build update xml
			$updateXML[] = "\t<update>";
			$updateXML[] = "\t\t<name>".$this->fileContentStatic['###Component_name###']."</name>";
			$updateXML[] = "\t\t<description>".$this->fileContentStatic['###SHORT_DESCRIPTION###']."</description>";
			$updateXML[] = "\t\t<element>com_".$this->fileContentStatic['###component###']."</element>";
			$updateXML[] = "\t\t<type>component</type>";
			$updateXML[] = "\t\t<version>".$update['version']."</version>";
			$updateXML[] = "\t\t".'<infourl title="'.$this->fileContentStatic['###Component_name###'].'!">'.$this->fileContentStatic['###AUTHORWEBSITE###'].'</infourl>';
			$updateXML[] = "\t\t<downloads>";
			if (!isset($update['url']) || !ComponentbuilderHelper::checkString($update['url']))
			{
				$update['url'] = 'http://domain.com/demo.zip';
			}
			$updateXML[] = "\t\t\t".'<downloadurl type="full" format="zip">'.$update['url'].'</downloadurl>';
			$updateXML[] = "\t\t</downloads>";
			$updateXML[] = "\t\t<tags>";
			$updateXML[] = "\t\t\t<tag>stable</tag>";
			$updateXML[] = "\t\t</tags>";
			$updateXML[] = "\t\t<maintainer>".$this->fileContentStatic['###AUTHOR###']."</maintainer>";
			$updateXML[] = "\t\t<maintainerurl>".$this->fileContentStatic['###AUTHORWEBSITE###']."</maintainerurl>";
			$updateXML[] = "\t\t".'<targetplatform name="joomla" version="3.*"/>';
			$updateXML[] = "\t</update>";
		}
	}

	public function noHelp()
	{
		$help = array();
		$help[] = PHP_EOL.PHP_EOL."\t/**";
		$help[] = "\t*	Can be used to build help urls.";
		$help[] = "\t**/";
		$help[] = "\tpublic static function getHelpUrl(\$view)";
		$help[] = "\t{";
		$help[] = "\t\treturn false;";
		$help[] = "\t}";
		// return the no help method
		return implode(PHP_EOL,$help);
	}

	public function checkHelp($viewName_single)
	{
		if ($viewName_single == "help_document")
		{
			// set help file into admin place
			$target = array('admin' => 'help');
			$admindone = $this->buildDynamique($target,'help');
			// set the help file into site place
			$target = array('site' => 'help');
			$sitedone = $this->buildDynamique($target,'help');
			if ($admindone && $sitedone)
			{
				// ###HELP###
				$this->fileContentStatic['###HELP###'] = $this->setHelp(1);
				// ###HELP_SITE###
				$this->fileContentStatic['###HELP_SITE###'] = $this->setHelp(2);
				// to make sure the file is updated TODO
				$this->fileContentDynamic['help']['###BLABLA###'] = 'blabla';
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
		$help[] = PHP_EOL.PHP_EOL."\t/**";
		$help[] = "\t*	Load the Component Help URLs.";
		$help[] = "\t**/";
		$help[] = "\tpublic static function getHelpUrl(\$view)";
		$help[] = "\t{";
		$help[] = "\t\t\$user	= JFactory::getUser();";
		$help[] = "\t\t\$groups = \$user->get('groups');";
		$help[] = "\t\t\$db	= JFactory::getDbo();";
		$help[] = "\t\t\$query	= \$db->getQuery(true);";
		$help[] = "\t\t\$query->select(array('a.id','a.groups','a.target','a.type','a.article','a.url'));";
		$help[] = "\t\t\$query->from('#__".$this->fileContentStatic['###component###']."_help_document AS a');";
		$help[] = "\t\t\$query->where('a.".$target." = '.\$db->quote(\$view));";
		$help[] = "\t\t\$query->where('a.location = ".(int) $location."');";
		$help[] = "\t\t\$query->where('a.published = 1');";
		$help[] = "\t\t\$db->setQuery(\$query);";
		$help[] = "\t\t\$db->execute();";
		$help[] = "\t\tif(\$db->getNumRows())";
		$help[] = "\t\t{";
		$help[] = "\t\t\t\$helps = \$db->loadObjectList();";
		$help[] = "\t\t\tif (self::checkArray(\$helps))";
		$help[] = "\t\t\t{";
		$help[] = "\t\t\t\tforeach (\$helps as \$nr => \$help)";
		$help[] = "\t\t\t\t{";
		$help[] = "\t\t\t\t\tif (\$help->target == 1)";
		$help[] = "\t\t\t\t\t{";
		$help[] = "\t\t\t\t\t\t\$targetgroups = json_decode(\$help->groups, true);";
		$help[] = "\t\t\t\t\t\tif (!array_intersect(\$targetgroups, \$groups))";
		$help[] = "\t\t\t\t\t\t{";
		$help[] = "\t\t\t\t\t\t\t//".$this->setLine(__LINE__)." if user not in those target groups then remove the item";
		$help[] = "\t\t\t\t\t\t\tunset(\$helps[\$nr]);";
		$help[] = "\t\t\t\t\t\t\tcontinue;";
		$help[] = "\t\t\t\t\t\t}";
		$help[] = "\t\t\t\t\t}";
		$help[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." set the return type";
		$help[] = "\t\t\t\t\tswitch (\$help->type)";
		$help[] = "\t\t\t\t\t{";
		$help[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." set joomla article";
		$help[] = "\t\t\t\t\t\tcase 1:";
		$help[] = "\t\t\t\t\t\t\treturn self::loadArticleLink(\$help->article);";
		$help[] = "\t\t\t\t\t\tbreak;";
		$help[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." set help text";
		$help[] = "\t\t\t\t\t\tcase 2:";
		$help[] = "\t\t\t\t\t\t\treturn self::loadHelpTextLink(\$help->id);";
		$help[] = "\t\t\t\t\t\tbreak;";
		$help[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." set Link";
		$help[] = "\t\t\t\t\t\tcase 3:";
		$help[] = "\t\t\t\t\t\t\treturn \$help->url;";
		$help[] = "\t\t\t\t\t\tbreak;";
		$help[] = "\t\t\t\t\t}";
		$help[] = "\t\t\t\t}";
		$help[] = "\t\t\t}";
		$help[] = "\t\t}";
		$help[] = "\t\treturn false;";
		$help[] = "\t}";
		$help[] = PHP_EOL."\t/**";
		$help[] = "\t*	Get the Article Link.";
		$help[] = "\t**/";
		$help[] = "\tprotected static function loadArticleLink(\$id)";
		$help[] = "\t{";
		$help[] = "\t\treturn JURI::root().'index.php?option=com_content&view=article&id='.\$id.'&tmpl=component&layout=modal';";
		$help[] = "\t}";
		$help[] = PHP_EOL."\t/**";
		$help[] = "\t*	Get the Help Text Link.";
		$help[] = "\t**/";
		$help[] = "\tprotected static function loadHelpTextLink(\$id)";
		$help[] = "\t{";
		$help[] = "\t\t\$token = JSession::getFormToken();";
		$help[] = "\t\treturn 'index.php?option=com_".$this->fileContentStatic['###component###']."&task=help.getText&id=' . (int) \$id . '&token=' . \$token;";
		$help[] = "\t}";
		// return the help methods
		return implode(PHP_EOL,$help);
	}

	public function setExelHelperMethods()
	{
		if ($this->addEximport)
		{
			$exel = array();
			$exel[] = PHP_EOL.PHP_EOL."\t/**";
			$exel[] = "\t * Prepares the xml document";
			$exel[] = "\t */";
			$exel[] = "\tpublic static function xls(\$rows,\$fileName = null,\$title = null,\$subjectTab = null,\$creator = '".$this->fileContentStatic['###COMPANYNAME###']."',\$description = null,\$category = null,\$keywords = null,\$modified = null)";
			$exel[] = "\t{";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set the user";
			$exel[] = "\t\t\$user = JFactory::getUser();";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set fieldname if not set";
			$exel[] = "\t\tif (!\$fileName)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$fileName = 'exported_'.JFactory::getDate()->format('jS_F_Y');";
			$exel[] = "\t\t}";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set modiefied if not set";
			$exel[] = "\t\tif (!\$modified)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$modified = \$user->name;";
			$exel[] = "\t\t}";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set title if not set";
			$exel[] = "\t\tif (!\$title)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$title = 'Book1';";
			$exel[] = "\t\t}";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set tab name if not set";
			$exel[] = "\t\tif (!\$subjectTab)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$subjectTab = 'Sheet1';";
			$exel[] = "\t\t}";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." make sure the file is loaded\t\t";
			$exel[] = "\t\tJLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Create new PHPExcel object";
			$exel[] = "\t\t\$objPHPExcel = new PHPExcel();";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Set document properties";
			$exel[] = "\t\t\$objPHPExcel->getProperties()->setCreator(\$creator)";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setCompany('".$this->fileContentStatic['###COMPANYNAME###']."')";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setLastModifiedBy(\$modified)";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setTitle(\$title)";
			$exel[] = "\t\t\t\t\t\t\t\t\t ->setSubject(\$subjectTab);";
			$exel[] = "\t\tif (!\$description)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$objPHPExcel->getProperties()->setDescription(\$description);";
			$exel[] = "\t\t}";
			$exel[] = "\t\tif (!\$keywords)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$objPHPExcel->getProperties()->setKeywords(\$keywords);";
			$exel[] = "\t\t}";
			$exel[] = "\t\tif (!\$category)";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$objPHPExcel->getProperties()->setCategory(\$category);";
			$exel[] = "\t\t}";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Some styles";
			$exel[] = "\t\t\$headerStyles = array(";
			$exel[] = "\t\t\t'font'  => array(";
			$exel[] = "\t\t\t\t'bold'  => true,";
			$exel[] = "\t\t\t\t'color' => array('rgb' => '1171A3'),";
			$exel[] = "\t\t\t\t'size'  => 12,";
			$exel[] = "\t\t\t\t'name'  => 'Verdana'";
			$exel[] = "\t\t));";
			$exel[] = "\t\t\$sideStyles = array(";
			$exel[] = "\t\t\t'font'  => array(";
			$exel[] = "\t\t\t\t'bold'  => true,";
			$exel[] = "\t\t\t\t'color' => array('rgb' => '444444'),";
			$exel[] = "\t\t\t\t'size'  => 11,";
			$exel[] = "\t\t\t\t'name'  => 'Verdana'";
			$exel[] = "\t\t));";
			$exel[] = "\t\t\$normalStyles = array(";
			$exel[] = "\t\t\t'font'  => array(";
			$exel[] = "\t\t\t\t'color' => array('rgb' => '444444'),";
			$exel[] = "\t\t\t\t'size'  => 11,";
			$exel[] = "\t\t\t\t'name'  => 'Verdana'";
			$exel[] = "\t\t));";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Add some data";
			$exel[] = "\t\tif (self::checkArray(\$rows))";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$i = 1;";
			$exel[] = "\t\t\tforeach (\$rows as \$array){";
			$exel[] = "\t\t\t\t\$a = 'A';";
			$exel[] = "\t\t\t\tforeach (\$array as \$value){";
			$exel[] = "\t\t\t\t\t\$objPHPExcel->setActiveSheetIndex(0)->setCellValue(\$a.\$i, \$value);";
			$exel[] = "\t\t\t\t\tif (\$i == 1){";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getColumnDimension(\$a)->setAutoSize(true);";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$headerStyles);";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);";
			$exel[] = "\t\t\t\t\t} elseif (\$a === 'A'){";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$sideStyles);";
			$exel[] = "\t\t\t\t\t} else {";
			$exel[] = "\t\t\t\t\t\t\$objPHPExcel->getActiveSheet()->getStyle(\$a.\$i)->applyFromArray(\$normalStyles);";
			$exel[] = "\t\t\t\t\t}";
			$exel[] = "\t\t\t\t\t\$a++;";
			$exel[] = "\t\t\t\t}";
			$exel[] = "\t\t\t\t\$i++;";
			$exel[] = "\t\t\t}";
			$exel[] = "\t\t}";
			$exel[] = "\t\telse";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\treturn false;";
			$exel[] = "\t\t}";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Rename worksheet";
			$exel[] = "\t\t\$objPHPExcel->getActiveSheet()->setTitle(\$subjectTab);";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Set active sheet index to the first sheet, so Excel opens this as the first sheet";
			$exel[] = "\t\t\$objPHPExcel->setActiveSheetIndex(0);";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." Redirect output to a client's web browser (Excel5)";
			$exel[] = "\t\theader('Content-Type: application/vnd.ms-excel');";
			$exel[] = "\t\theader('Content-Disposition: attachment;filename=\"'.\$fileName.'.xls\"');";
			$exel[] = "\t\theader('Cache-Control: max-age=0');";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." If you're serving to IE 9, then the following may be needed";
			$exel[] = "\t\theader('Cache-Control: max-age=1');";
			$exel[] = "\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." If you're serving to IE over SSL, then the following may be needed";
			$exel[] = "\t\theader ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past";
			$exel[] = "\t\theader ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified";
			$exel[] = "\t\theader ('Cache-Control: cache, must-revalidate'); // HTTP/1.1";
			$exel[] = "\t\theader ('Pragma: public'); // HTTP/1.0";
			$exel[] = "\t\t";
			$exel[] = "\t\t\$objWriter = PHPExcel_IOFactory::createWriter(\$objPHPExcel, 'Excel5');";
			$exel[] = "\t\t\$objWriter->save('php://output');";
			$exel[] = "\t\tjexit();";
			$exel[] = "\t}";
			$exel[] = "\t";
			$exel[] = "\t/**";
			$exel[] = "\t* Get CSV Headers";
			$exel[] = "\t*/";
			$exel[] = "\tpublic static function getFileHeaders(\$dataType)";
			$exel[] = "\t{\t\t";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." make sure these files are loaded\t\t";
			$exel[] = "\t\tJLoader::import('PHPExcel', JPATH_COMPONENT_ADMINISTRATOR . '/helpers');";
			$exel[] = "\t\tJLoader::import('ChunkReadFilter', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/PHPExcel/Reader');";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." get session object";
			$exel[] = "\t\t\$session\t= JFactory::getSession();";
			$exel[] = "\t\t\$package\t= \$session->get('package', null);";
			$exel[] = "\t\t\$package\t= json_decode(\$package, true);";
			$exel[] = "\t\t//".$this->setLine(__LINE__)." set the headers";
			$exel[] = "\t\tif(isset(\$package['dir']))";
			$exel[] = "\t\t{";
			$exel[] = "\t\t\t\$chunkFilter = new PHPExcel_Reader_chunkReadFilter();";
			$exel[] = "\t\t\t//".$this->setLine(__LINE__)." only load first three rows";
			$exel[] = "\t\t\t\$chunkFilter->setRows(2,1);";
			$exel[] = "\t\t\t//".$this->setLine(__LINE__)." identify the file type";
			$exel[] = "\t\t\t\$inputFileType = PHPExcel_IOFactory::identify(\$package['dir']);";
			$exel[] = "\t\t\t//".$this->setLine(__LINE__)." create the reader for this file type";
			$exel[] = "\t\t\t\$excelReader = PHPExcel_IOFactory::createReader(\$inputFileType);";
			$exel[] = "\t\t\t//".$this->setLine(__LINE__)." load the limiting filter";
			$exel[] = "\t\t\t\$excelReader->setReadFilter(\$chunkFilter);";
			$exel[] = "\t\t\t\$excelReader->setReadDataOnly(true);";
			$exel[] = "\t\t\t//".$this->setLine(__LINE__)." load the rows (only first three)";
			$exel[] = "\t\t\t\$excelObj = \$excelReader->load(\$package['dir']);";
			$exel[] = "\t\t\t\$headers = array();";
			$exel[] = "\t\t\tforeach (\$excelObj->getActiveSheet()->getRowIterator() as \$row)";
			$exel[] = "\t\t\t{";
			$exel[] = "\t\t\t\tif(\$row->getRowIndex() == 1)";
			$exel[] = "\t\t\t\t{";
			$exel[] = "\t\t\t\t\t\$cellIterator = \$row->getCellIterator();";
			$exel[] = "\t\t\t\t\t\$cellIterator->setIterateOnlyExistingCells(false);";
			$exel[] = "\t\t\t\t\tforeach (\$cellIterator as \$cell)";
			$exel[] = "\t\t\t\t\t{";
			$exel[] = "\t\t\t\t\t\tif (!is_null(\$cell))";
			$exel[] = "\t\t\t\t\t\t{";
			$exel[] = "\t\t\t\t\t\t\t\$headers[\$cell->getColumn()] = \$cell->getValue();";
			$exel[] = "\t\t\t\t\t\t}";
			$exel[] = "\t\t\t\t\t}";
			$exel[] = "\t\t\t\t\t\$excelObj->disconnectWorksheets();";
			$exel[] = "\t\t\t\t\tunset(\$excelObj);";
			$exel[] = "\t\t\t\t\tbreak;";
			$exel[] = "\t\t\t\t}";
			$exel[] = "\t\t\t}";
			$exel[] = "\t\t\treturn \$headers;";
			$exel[] = "\t\t}";
			$exel[] = "\t\treturn false;";
			$exel[] = "\t}";
			// return the help methods
			return implode(PHP_EOL,$exel);
		}
		return '';
	}

	public function setCreateUserHelperMethod($add)
	{
		if ($add)
		{
			$method = array();
			$method[] = PHP_EOL.PHP_EOL."\t/**";
			$method[] = "\t* Greate user and update given table";
			$method[] = "\t*/";
			$method[] = "\tpublic static function createUser(\$new)";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." load the user component language files if there is an error.";
			$method[] = "\t\t\$lang = JFactory::getLanguage();";
			$method[] = "\t\t\$extension = 'com_users';";
			$method[] = "\t\t\$base_dir = JPATH_SITE;";
			$method[] = "\t\t\$language_tag = 'en-GB';";
			$method[] = "\t\t\$reload = true;";
			$method[] = "\t\t\$lang->load(\$extension, \$base_dir, \$language_tag, \$reload);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." load the user regestration model";
			$method[] = "\t\t\$model = self::getModel('registration', JPATH_ROOT. '/components/com_users', 'Users');";
			$method[] = "\t\t//".$this->setLine(__LINE__)." make sure no activation is needed";
			$method[] = "\t\t\$useractivation = self::setParams('com_users','useractivation',0);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." make sure password is send";
			$method[] = "\t\t\$sendpassword = self::setParams('com_users','sendpassword',1);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Check if password was set";
			$method[] = "\t\tif (isset(\$new['password']) && isset(\$new['password2']) && self::checkString(\$new['password']) && self::checkString(\$new['password2']))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Use the users passwords";
			$method[] = "\t\t\t\$password = \$new['password'];";
			$method[] = "\t\t\t\$password2 = \$new['password2'];";
			$method[] = "\t\t}";
			$method[] = "\t\telse";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Set random password";
			$method[] = "\t\t\t\$password = self::randomkey(8);";
			$method[] = "\t\t\t\$password2 = \$password;";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." set username if not set";
			$method[] = "\t\tif (!isset(\$new['username']) || !self::checkString(\$new['username']))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t\$new['username'] = self::safeString(\$new['name']);";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." linup new user data";
			$method[] = "\t\t\$data = array(";
			$method[] = "\t\t\t'username' => \$new['username'],";
			$method[] = "\t\t\t'name' => \$new['name'],";
			$method[] = "\t\t\t'email1' => \$new['email'],";
			$method[] = "\t\t\t'password1' => \$password, // First password field";
			$method[] = "\t\t\t'password2' => \$password2, // Confirm password field";
			$method[] = "\t\t\t'block' => 0 );";
			$method[] = "\t\t//".$this->setLine(__LINE__)." register the new user";
			$method[] = "\t\t\$userId = \$model->register(\$data);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." set activation back to default";
			$method[] = "\t\tself::setParams('com_users','useractivation',\$useractivation);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." set send password back to default";
			$method[] = "\t\tself::setParams('com_users','sendpassword',\$sendpassword);";
			$method[] = "\t\t//".$this->setLine(__LINE__)." if user is created";
			$method[] = "\t\tif (\$userId > 0)";
			$method[] = "\t\t{";
			$method[] = "\t\t\treturn \$userId;";
			$method[] = "\t\t}";
			$method[] = "\t\treturn \$model->getError();";
			$method[] = "\t}";

			$method[] = PHP_EOL."\tprotected static function setParams(\$component,\$target,\$value)";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Get the params and set the new values";
			$method[] = "\t\t\$params = JComponentHelper::getParams(\$component);";
			$method[] = "\t\t\$was = \$params->get(\$target, null);";
			$method[] = "\t\tif (\$was != \$value)";
			$method[] = "\t\t{";
			$method[] = "\t\t\t\$params->set(\$target, \$value);";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get a new database query instance";
			$method[] = "\t\t\t\$db = JFactory::getDBO();";
			$method[] = "\t\t\t\$query = \$db->getQuery(true);";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Build the query";
			$method[] = "\t\t\t\$query->update('#__extensions AS a');";
			$method[] = "\t\t\t\$query->set('a.params = ' . \$db->quote((string)\$params));";
			$method[] = "\t\t\t\$query->where('a.element = ' . \$db->quote((string)\$component));";
			$method[] = "\t\t\t";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Execute the query";
			$method[] = "\t\t\t\$db->setQuery(\$query);";
			$method[] = "\t\t\t\$db->query();";
			$method[] = "\t\t}";
			$method[] = "\t\treturn \$was;";
			$method[] = "\t}";
			
			$method[] = PHP_EOL."\t/**";
			$method[] = "\t* Update user values";
			$method[] = "\t*/";
			$method[] = "\tpublic static function updateUser(\$new)";
			$method[] = "\t{";
			$method[] = "\t\t// load the user component language files if there is an error.";
			$method[] = "\t\t\$lang = JFactory::getLanguage();";
			$method[] = "\t\t\$extension = 'com_users';";
			$method[] = "\t\t\$base_dir = JPATH_ADMINISTRATOR;";
			$method[] = "\t\t\$language_tag = 'en-GB';";
			$method[] = "\t\t\$reload = true;";
			$method[] = "\t\t\$lang->load(\$extension, \$base_dir, \$language_tag, \$reload);";
			$method[] = "\t\t// load the user model";
			$method[] = "\t\t\$model = self::getModel('user', JPATH_ADMINISTRATOR . '/components/com_users', 'Users');";
			$method[] = "\t\t// Check if password was set";
			$method[] = "\t\tif (isset(\$new['password']) && isset(\$new['password2']) && self::checkString(\$new['password']) && self::checkString(\$new['password2']))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t// Use the users passwords";
			$method[] = "\t\t\t\$password = \$new['password'];";
			$method[] = "\t\t\t\$password2 = \$new['password2'];";
			$method[] = "\t\t}";
			$method[] = "\t\t// set username";
			$method[] = "\t\tif (isset(\$new['username']) && self::checkString(\$new['username']))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t\$new['username'] = self::safeString(\$new['username']);";
			$method[] = "\t\t}";
			$method[] = "\t\telse";
			$method[] = "\t\t{";
			$method[] = "\t\t\t\$new['username'] = self::safeString(\$new['name']);\t\t\t";
			$method[] = "\t\t}";
			$method[] = "\t\t// linup update user data";
			$method[] = "\t\t\$data = array(";
			$method[] = "\t\t\t'id' => \$new['id'],";
			$method[] = "\t\t\t'username' => \$new['username'],";
			$method[] = "\t\t\t'name' => \$new['name'],";
			$method[] = "\t\t\t'email' => \$new['email'],";
			$method[] = "\t\t\t'password1' => \$password, // First password field";
			$method[] = "\t\t\t'password2' => \$password2, // Confirm password field";
			$method[] = "\t\t\t'block' => 0 );";
			$method[] = "\t\t// register the new user";
			$method[] = "\t\t\$done = \$model->save(\$data);";
			$method[] = "\t\t// if user is updated";
			$method[] = "\t\tif (\$done)";
			$method[] = "\t\t{";
			$method[] = "\t\t\treturn \$new['id'];";
			$method[] = "\t\t}";
			$method[] = "\t\treturn \$model->getError();";
			$method[] = "\t}";

			// return the help method
			return implode(PHP_EOL,$method);
		}
		return '';
	}

	public function setCustomViewMenu(&$view)
	{
		$xml = '';
		// build the file
		$target = array('site' => $view['settings']->code);
		$done = $this->buildDynamique($target,'menu');
		if ($done)
		{
			// set the lang
			$lang = ComponentbuilderHelper::safeString('com_'.$this->fileContentStatic['###component###'].'_menu_'.$view['settings']->code, 'U');
			$this->langContent['adminsys'][$lang.'_TITLE'] = $view['settings']->name;
			$this->langContent['adminsys'][$lang.'_OPTION'] = $view['settings']->name;
			$this->langContent['adminsys'][$lang.'_DESC'] = $view['settings']->description;
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= PHP_EOL.'<metadata>';
			$xml .= PHP_EOL."\t".'<layout title="'.$lang.'_TITLE" option="'.$lang.'_OPTION">';
			$xml .= PHP_EOL."\t\t".'<message>';
			$xml .= PHP_EOL."\t\t\t".'<![CDATA['.$lang.'_DESC]]>';
			$xml .= PHP_EOL."\t\t".'</message>';
			$xml .= PHP_EOL."\t".'</layout>';
			if (isset($this->hasIdRequest[$view['settings']->code]) || isset($this->hasCatIdRequest[$view['settings']->code]))
			{
				$xml .= PHP_EOL."\t".'<!--'.$this->setLine(__LINE__).' Add fields to the request variables for the layout. -->';
				$xml .= PHP_EOL."\t".'<fields name="request">';
				$xml .= PHP_EOL."\t\t".'<fieldset name="request"';
				$xml .= PHP_EOL."\t\t\t".'addrulepath="/administrator/components/com_'.$this->fileContentStatic['###component###'].'/models/rules"';
				$xml .= PHP_EOL."\t\t\t".'addfieldpath="/administrator/components/com_'.$this->fileContentStatic['###component###'].'/models/fields">';
				if (isset($this->hasIdRequest[$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->hasIdRequest[$view['settings']->code]))
				{
					foreach($this->hasIdRequest[$view['settings']->code] as $requestFieldXML)
					{
						$xml .= PHP_EOL."\t\t\t".$requestFieldXML;
					}
				}
				if (isset($this->hasCatIdRequest[$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->hasCatIdRequest[$view['settings']->code]))
				{
					foreach($this->hasCatIdRequest[$view['settings']->code] as $requestFieldXML)
					{
						$xml .= PHP_EOL."\t\t\t".$requestFieldXML;
					}
				}
				$xml .= PHP_EOL."\t\t".'</fieldset>';
				$xml .= PHP_EOL."\t".'</fields>';
			}
			if (isset($this->frontEndParams) && isset($this->frontEndParams[$view['settings']->name]))
			{
				// first we must setup the fields for the page use
				$params = $this->setupFrontendParamFields($this->frontEndParams[$view['settings']->name],$view['settings']->code);
				// now load the fields
				if (ComponentbuilderHelper::checkArray($params))
				{
					$xml .= PHP_EOL."\t".'<!--'.$this->setLine(__LINE__).' Adding page parameters -->';
					$xml .= PHP_EOL."\t".'<fields name="params">';
					$xml .= PHP_EOL."\t\t".'<fieldset name="basic" label="COM_'.$this->fileContentStatic['###COMPONENT###'].'"';
					$xml .= PHP_EOL."\t\t\t".'addrulepath="/administrator/components/com_'.$this->fileContentStatic['###component###'].'/models/rules"';
					$xml .= PHP_EOL."\t\t\t".'addfieldpath="/administrator/components/com_'.$this->fileContentStatic['###component###'].'/models/fields">';
					$xml .= implode("\t\t\t",$params);
					$xml .= PHP_EOL."\t\t".'</fieldset>';
					$xml .= PHP_EOL."\t".'</fields>';
				}
			}
			$xml .= PHP_EOL.'</metadata>';
		}
		return $xml;
	}
	
	public function setupFrontendParamFields($params,$view)
	{
		$keep = array();
		$menuSetter = $view.'_menu';
		foreach ($params as $field)
		{
			// some switch to see if it should be added to front end params
			$target = ComponentbuilderHelper::getBetween($field, 'display="', '"');
			if (!ComponentbuilderHelper::checkString($target) || $target === 'menu')
			{
				
				$field = str_replace('display="menu"', '', $field);
				// we load fields that have options
				if (strpos($field,'Option Set. -->') !== false && strpos($field,$menuSetter) === false && !ComponentbuilderHelper::checkString($target))
				{
					// we add the global option
					$field = str_replace('Option Set. -->', $this->setLine(__LINE__).' Global & Option Set. -->'.PHP_EOL."\t\t\t".'<option value="">'.PHP_EOL."\t\t\t\t".'JGLOBAL_USE_GLOBAL</option>', $field);
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

	public function setCustomViewQuery(&$gets,&$code,$tab = '',$type = 'main')
	{
		$query = '';
		if (ComponentbuilderHelper::checkArray($gets))
		{
			$mainAsArray = array();
			$check = 'zzz';
			foreach ($gets as $nr => $the_get)
			{
				// to insure that there be no double entries of a call
				$checker = md5(serialize($the_get).$code);
				if (!isset($this->customViewQueryChecker[$this->target]) || !in_array($checker,$this->customViewQueryChecker[$this->target]))
				{
					// load this unuiqe key 
					$this->customViewQueryChecker[$this->target][] = $checker;
					if (ComponentbuilderHelper::checkString($the_get['selection']['type']))
					{
						$getItem = PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get from ".$the_get['selection']['table']." as ".$the_get['as'];
					}
					else
					{
						$getItem = PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get data";
					}
					// set the selection
					$getItem .= PHP_EOL."\t".$tab."\t".$the_get['selection']['select'];
					if (($nr == 0 && (!isset($the_get['join_field']) || !ComponentbuilderHelper::checkString($the_get['join_field'])) && (isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))) ||
						($type === 'custom' && (isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))))
					{
						$getItem .= PHP_EOL."\t".$tab."\t".'$query->from('.$the_get['selection']['from'].');';
					}
					elseif (isset($the_get['join_field']) && ComponentbuilderHelper::checkString($the_get['join_field']) && isset($the_get['selection']['type']) && ComponentbuilderHelper::checkString($the_get['selection']['type']))
					{
						$getItem .= PHP_EOL."\t".$tab."\t\$query->join('".$the_get['type'];
						$getItem .= "', (".$the_get['selection']['from'];
						$getItem .= ") . ' ON (' . \$db->quoteName('".$the_get['on_field'];
						$getItem .= "') . ' ".$the_get['operator'];
						$getItem .= " ' . \$db->quoteName('".$the_get['join_field']."') . ')');";

						$check = current(explode(".", $the_get['on_field']));
					}

					// set the method defaults
					$default = $this->setCustomViewMethodDefaults($the_get,$code);
					if (isset($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && ComponentbuilderHelper::checkString($this->siteDynamicGet[$this->target][$default['code']][$default['as']][$default['join_field']]) && !in_array($check,$mainAsArray))
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
		return $query;
	}

	public function setCustomViewFieldDecodeFilter(&$get,&$filters,$string,$removeString,$code,$tab)
	{
		$filter = '';
		// check if filter is set for this field
		if (ComponentbuilderHelper::checkArray($filters))
		{
			foreach ($filters as $field => $ter)
			{
				if (strpos($get['selection']['select'], $ter['table_key']) !== false)
				{
					$as = '';
					$felt = '';
					list($as,$felt) = array_map('trim', explode('.',$ter['table_key']));
					if ($get['as'] == $as)
					{
						switch ($ter['filter_type'])
						{
							case 4:
							// COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
							$filter .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." filter ".$as." based on user groups";
							$filter .= PHP_EOL."\t".$tab."\t\$remove = (count(array_intersect((array) \$this->groups, (array) ".$string."->".$field."))) ? false : true;";
							$filter .= PHP_EOL."\t".$tab."\tif (\$remove)";
							$filter .= PHP_EOL."\t".$tab."\t{";
							if ($removeString == $string)
							{
								$filter .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." Remove ".$string." if user not in groups";
								$filter .= PHP_EOL."\t".$tab."\t\t".$string." = null;";
								$filter .= PHP_EOL."\t".$tab."\t\treturn false;";
							}
							else
							{
								$filter .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." Unset ".$string." if user not in groups";
								$filter .= PHP_EOL."\t".$tab."\t\tunset(".$removeString.");";
								$filter .= PHP_EOL."\t".$tab."\t\tcontinue;";
							}
							$filter .= PHP_EOL."\t".$tab."\t}";
							break;
							case 9:
							// COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE

							$filter .= PHP_EOL.PHP_EOL."\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(".$string."->".$field."))";
							$filter .= PHP_EOL."\t".$tab."\t{";

							$filter .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." do your thing here";

							$filter .= PHP_EOL."\t".$tab."\t}";
							$filter .= PHP_EOL."\t".$tab."\telse";
							$filter .= PHP_EOL."\t".$tab."\t{";

							if ($removeString == $string)
							{
								$filter .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." Remove ".$string." if not array.";
								$filter .= PHP_EOL."\t".$tab."\t\t".$string." = null;";
							}
							else
							{
								$filter .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." Unset ".$string." if not array.";
								$filter .= PHP_EOL."\t".$tab."\t\tunset(".$removeString.");";
								$filter .= PHP_EOL."\t".$tab."\t\tcontinue;";
							}

							$filter .= PHP_EOL."\t".$tab."\t}";
							break;
							case 10:
							// COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
							$filter .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." filter ".$as." based on repeatable value";
							$filter .= PHP_EOL."\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkString(".$string."->".$field."))";
							$filter .= PHP_EOL."\t".$tab."\t{";

							$filter .= PHP_EOL."\t\t".$tab."\t\$array = json_decode(".$string."->".$field.",true);";
							$filter .= PHP_EOL."\t\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$array))";
							$filter .= PHP_EOL."\t\t".$tab."\t{";

							$filter .= PHP_EOL."\t\t".$tab."\t\t//".$this->setLine(__LINE__)." do your thing here";

							$filter .= PHP_EOL."\t\t".$tab."\t}";
							$filter .= PHP_EOL."\t".$tab."\t\telse";
							$filter .= PHP_EOL."\t".$tab."\t\t{";

							if ($removeString == $string)
							{
								$filter .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." Remove ".$string." if not array.";
								$filter .= PHP_EOL."\t".$tab."\t\t\t".$string." = null;";
							}
							else
							{
								$filter .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." Unset ".$string." if not array.";
								$filter .= PHP_EOL."\t".$tab."\t\t\tunset(".$removeString.");";
								$filter .= PHP_EOL."\t".$tab."\t\t\tcontinue;";
							}

							$filter .= PHP_EOL."\t".$tab."\t\t}";

							$filter .= PHP_EOL."\t".$tab."\t}";
							$filter .= PHP_EOL."\t".$tab."\telse";
							$filter .= PHP_EOL."\t".$tab."\t{";

							if ($removeString == $string)
							{
								$filter .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." Remove ".$string." if not string.";
								$filter .= PHP_EOL."\t".$tab."\t\t".$string." = null;";
							}
							else
							{
								$filter .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." Unset ".$string." if not string.";
								$filter .= PHP_EOL."\t".$tab."\t\tunset(".$removeString.");";
								$filter .= PHP_EOL."\t".$tab."\t\tcontinue;";
							}

							$filter .= PHP_EOL."\t".$tab."\t}";
							break;
						}
					}
				}
			}
		}
		return $filter;
	}

	public function setCustomViewFieldDecode(&$get,$checker,$string,$code,$tab = '')
	{
		$fieldDecode = '';
		foreach ($checker as $field => $array)
		{
			if (strpos($get['selection']['select'], $field) !== false)
			{
				if ($array['decode'] === 'json')
				{
					$if = PHP_EOL."\t".$tab."\tif (".$this->fileContentStatic['###Component###']."Helper::checkJson(".$string."->".$field."))".PHP_EOL."\t".$tab."\t{";
					// json_decode
					$decoder = $string."->".$field." = json_decode(".$string."->".$field.", true);";
					// TODO Use the type of field to prepare it even more for use in the view
				}
				elseif ($array['decode'] === 'base64')
				{
					$if = PHP_EOL."\t".$tab."\tif (!empty(".$string."->".$field.") && ".$string."->".$field." === base64_encode(base64_decode(".$string."->".$field.")))".PHP_EOL."\t".$tab."\t{";
					// base64_decode
					$decoder = $string."->".$field." = base64_decode(".$string."->".$field.");";
					// TODO Use the type of field to prepare it even more for use in the view
				}
				elseif ($array['decode'] === 'basic_encryption')
				{
					$if = PHP_EOL."\t".$tab."\tif (!empty(".$string."->".$field.") && \$basickey && !is_numeric(".$string."->".$field.") && ".$string."->".$field." === base64_encode(base64_decode(".$string."->".$field.", true)))".PHP_EOL."\t".$tab."\t{";
					// basic decryption
					$decoder = $string."->".$field." = rtrim(\$basic->decryptString(".$string."->".$field."), ".'"\0"'.");";
					$this->siteDecrypt['basic'][$code] = true;
				}
				elseif ($array['decode'] === 'advance_encryption')
				{
					$if = PHP_EOL."\t".$tab."\tif (!empty(".$string."->".$field.") && \$advancedkey && !is_numeric(".$string."->".$field.") && ".$string."->".$field." === base64_encode(base64_decode(".$string."->".$field.", true)))".PHP_EOL."\t".$tab."\t{";
					// advanced decryption
					$decoder = $string."->".$field." = rtrim(\$advanced->decryptString(".$string."->".$field."), ".'"\0"'.");";
					$this->siteDecrypt['advanced'][$code] = true;
				}

				// build decoder string
				$fieldDecode .= $if.PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." Decode ".$field;
				$fieldDecode .= PHP_EOL."\t".$tab."\t\t".$decoder.PHP_EOL."\t".$tab."\t}";
			}
		}
		return $fieldDecode;
	}

	public function setCustomViewFieldUikitChecker(&$get, $checker, $string, $code, $tab = '')
	{
		$fieldUikit = '';
		foreach ($checker as $field => $array)
		{
			if (strpos($get['selection']['select'], $field) !== false)
			{
				// build decoder string
				$fieldUikit .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Make sure the content prepare plugins fire on ".$field." (TODO)";
				$fieldUikit .= PHP_EOL."\t".$tab."\t".$string."->".$field." = JHtml::_('content.prepare',".$string."->".$field.");";
				// only load for uikit version 2 (TODO) we may need to add another check here
				if (2 == $this->uikit || 1 == $this->uikit)
				{
					$fieldUikit .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Checking if ".$field." has uikit components that must be loaded.";
					$fieldUikit .= PHP_EOL."\t".$tab."\t\$this->uikitComp = ".$this->fileContentStatic['###Component###']."Helper::getUikitComp(".$string."->".$field.",\$this->uikitComp);";
				}
			}
		}
		return $fieldUikit;
	}

	public function setCustomViewCustomJoin(&$gets,$string,$code,&$asBucket,$tab = '')
	{
		if (ComponentbuilderHelper::checkArray($gets))
		{
			$customJoin = '';
			foreach ($gets as $get)
			{
				// set the value name $default
				$default = $this->setCustomViewMethodDefaults($get,$code);
				if ($this->checkJoint($default,$get,$asBucket))
				{
					// build custom join string
					$otherJoin = PHP_EOL."\t###TAB###\t//".$this->setLine(__LINE__)." set ".$default['valueName']." to the ###STRING### object.";
					$otherJoin .= PHP_EOL."\t###TAB###\t###STRING###->".$default['valueName']." = \$this->get".$default['methodName']."(###STRING###->".$this->getAsLookup[$get['key']][$get['on_field']].");";
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
					$customJoin .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." set ".$default['valueName']." to the ".$string." object.";
					$customJoin .= PHP_EOL."\t".$tab."\t".$string."->".$default['valueName']." = \$this->get".$default['methodName']."(".$string."->".$this->getAsLookup[$get['key']][$get['on_field']].");";
				}
			}
			return $customJoin;
		}
		return '';
	}
	
	public function checkJoint(&$default,&$get,&$asBucket)
	{
		// check if this function is not linked to the main call 
		list($aJoin) = explode('.',$get['on_field']);
		if (ComponentbuilderHelper::checkArray($asBucket) && in_array($aJoin,$asBucket))
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

	public function setCustomViewFilter(&$filter,&$code,$tab = '')
	{
		$filters = '';
		if (ComponentbuilderHelper::checkArray($filter))
		{
			foreach ($filter as $ter)
			{
				$as = '';
				$field = '';
				$string = '';
				if (strpos($ter['table_key'],'.') !== false)
				{
					list($as,$field) = array_map('trim', explode('.',$ter['table_key']));
				}
				switch ($ter['filter_type'])
				{
					case 1:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_ID
					$string = PHP_EOL."\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . (int) \$pk);";
					break;
					case 2:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_USER
					$string = PHP_EOL."\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . (int) \$this->userId);";
					break;
					case 3:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_ACCESS_LEVEL
					$string = PHP_EOL."\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " (' . implode(',', \$this->levels) . ')');";
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
						$string = PHP_EOL."\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " (' . implode(',', \$this->groups) . ')');";
					}
					break;
					case 5:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_CATEGORIES
					$string = PHP_EOL."\t\t".$tab."//".$this->setLine(__LINE__)." (TODO) The dynamic category filter is not ready.";
					break;
					case 6:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_TAGS
					$string = PHP_EOL."\t\t".$tab."//".$this->setLine(__LINE__)." (TODO) The dynamic tags filter is not ready.";
					break;
					case 7:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_DATE
					$string = PHP_EOL."\t\t".$tab."//".$this->setLine(__LINE__)." (TODO) The dynamic date filter is not ready.";
					break;
					case 8:
					// COM_COMPONENTBUILDER_DYNAMIC_GET_FUNCTIONVAR
					if ($ter['operator'] === 'IN' || $ter['operator'] === 'NOT IN')
					{						
						$string = PHP_EOL."\t\t".$tab."//".$this->setLine(__LINE__)." Check if " . $ter['state_key'] . " is an array with values.";
						$string .= PHP_EOL."\t\t".$tab."\$array = " . $ter['state_key'].";";
						$string .= PHP_EOL."\t\t".$tab."if (isset(\$array) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$array))";
						$string .= PHP_EOL."\t\t".$tab."{";
						$string .= PHP_EOL."\t\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator']  . " (' . implode(',', \$array) . ')');";
						$string .= PHP_EOL."\t\t".$tab."}";
						$string .= PHP_EOL."\t\t".$tab."else";
						$string .= PHP_EOL."\t\t".$tab."{";
						$string .= PHP_EOL."\t\t".$tab."\treturn false;";
						$string .= PHP_EOL."\t\t".$tab."}";
					}
					else
					{						
						$string = PHP_EOL."\t\t".$tab."//".$this->setLine(__LINE__)." Check if " . $ter['state_key'] . " is a string or numeric value.";
						$string .= PHP_EOL."\t\t".$tab."\$checkValue = " . $ter['state_key'].";";
						$string .= PHP_EOL."\t\t".$tab."if (isset(\$checkValue) && ".$this->fileContentStatic['###Component###']."Helper::checkString(\$checkValue))";
						$string .= PHP_EOL."\t\t".$tab."{";
						$string .= PHP_EOL."\t\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . \$db->quote(\$checkValue));";
						$string .= PHP_EOL."\t\t".$tab."}";
						$string .= PHP_EOL."\t\t".$tab."elseif (is_numeric(\$checkValue))";
						$string .= PHP_EOL."\t\t".$tab."{";
						$string .= PHP_EOL."\t\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ' . \$checkValue);";
						$string .= PHP_EOL."\t\t".$tab."}";
						$string .= PHP_EOL."\t\t".$tab."else";
						$string .= PHP_EOL."\t\t".$tab."{";
						$string .= PHP_EOL."\t\t".$tab."\treturn false;";
						$string .= PHP_EOL."\t\t".$tab."}";
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
					if (strpos($as,'(') !== false)
					{
						// TODO (for now we only fix extra sql methods here)
						list($dump,$as) = array_map('trim', explode('(',$as));
						$field = trim(str_replace(')', '', $field));
					}
					$string = PHP_EOL."\t".$tab."\t\$query->where('".$ter['table_key'] . " " . $ter['operator'] . " ". $ter['state_key']."');";
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
					elseif($as !== 'a')
					{
						$this->otherFilter[$this->target][$code][$as][$field] = $string;
					}
				}
			}
		}
		return $filters;
	}

	public function setCustomViewOrder(&$order,&$code,$tab = '')
	{
		$ordering = '';
		if (ComponentbuilderHelper::checkArray($order))
		{
			foreach ($order as $or)
			{
				list($as,$field) = array_map('trim', explode('.',$or['table_key']));

				// set the string
				$string = "\$query->order('".$or['table_key']." ".$or['direction']."');";
				// sort where
				if ($as === 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
				{
					$ordering .= PHP_EOL."\t".$tab."\t".$string;
				}
				else
				{
					$this->otherOrder[$this->target][$code][$as][$field] = PHP_EOL."\t\t".$string;
				}
			}
		}
		return $ordering;
	}

	public function setCustomViewWhere(&$where,&$code,$tab = '')
	{
		$wheres = '';
		if (ComponentbuilderHelper::checkArray($where))
		{
			foreach ($where as $whe)
			{
				$as = '';
				$field = '';
				$value = '';
				list($as,$field) = array_map('trim', explode('.',$whe['table_key']));
				if (is_numeric($whe['value_key']))
				{
					$value = " ".$whe['value_key']."');";

				}
				elseif (strpos($whe['value_key'],'$') !== false)
				{
					if ($whe['operator'] === 'IN' || $whe['operator'] === 'NOT IN')
					{
						$value = " (' . implode(',', " . $whe['value_key'] . ") . ')');";
					}
					else
					{
						$value = " ' . \$db->quote(".$whe['value_key']."));";
					}
				}
				elseif (strpos($whe['value_key'],'.') !== false)
				{
					if (strpos($whe['value_key'],"'") !== false)
					{
						$value = " ' . \$db->quote(".$whe['value_key']."));";
					}
					else
					{
						$value = " ".$whe['value_key']."');";
					}
				}
				elseif (ComponentbuilderHelper::checkString($whe['value_key']))
				{
					$value = " ".$whe['value_key']."');";
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
						$string = "if (isset(" . $whe['value_key']. ") && ".$this->fileContentStatic['###Component###']."Helper::checkArray(" . $whe['value_key']. "))";
						$string .= PHP_EOL."\t".$tabe."\t{";
						$string .= PHP_EOL."\t".$tabe."\t\t//".$this->setLine(__LINE__)." Get where ".$whe['table_key']." is " . $whe['value_key'];
						$string .= PHP_EOL."\t".$tabe."\t\t\$query->where('".$whe['table_key']." ".$whe['operator'].$value;
						$string .= PHP_EOL."\t".$tabe."\t}";
						$string .= PHP_EOL."\t".$tabe."\telse";
						$string .= PHP_EOL."\t".$tabe."\t{";
						$string .= PHP_EOL."\t".$tabe."\t\treturn false;";
						$string .= PHP_EOL."\t".$tabe."\t}";

					}
					else
					{
						$string = "//".$this->setLine(__LINE__)." Get where ".$whe['table_key']." is " . $whe['value_key'];
						$string .= PHP_EOL."\t".$tabe."\t\$query->where('".$whe['table_key']." ".$whe['operator'].$value;
					}
					// sort where
					if ($as === 'a' || (isset($this->siteMainGet[$this->target][$code][$as]) && ComponentbuilderHelper::checkString($this->siteMainGet[$this->target][$code][$as])))
					{
						$wheres .= PHP_EOL."\t".$tab."\t".$string;
					}
					elseif ($as !== 'a')
					{
						$this->otherWhere[$this->target][$code][$as][$field] = PHP_EOL."\t\t".$string;
					}
				}
			}
		}
		return $wheres;
	}

	public function setCustomViewGlobals(&$global,$string,$as,$tab = '')
	{
		$globals = '';
		if (ComponentbuilderHelper::checkArray($global))
		{
			$as = array_unique($as);
			foreach ($global as $glo)
			{
				if (in_array($glo['as'],$as))
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
						$globals .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." set the global " . $glo['name'] . " value.".PHP_EOL."\t".$tab."\t".$value;
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
		if (strpos($string,'.') !== false)
		{
			list($dump,$field) = array_map('trim', explode('.',$string));
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
			switch($type)
			{
				case 1:
					$userString = '$this->user';
					break;
				default:
					$userString = '$user';
					break;
			}
			// check that the default and the redirect page is not the same
			if (isset($this->fileContentStatic['###SITE_DEFAULT_VIEW###']) && $this->fileContentStatic['###SITE_DEFAULT_VIEW###'] != $view['settings']->code)
			{
				$redirectMessage = "\t\t\t//".$this->setLine(__LINE__)." redirect away to the default view if no access allowed.";
				$redirectString = "JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$this->fileContentStatic['###SITE_DEFAULT_VIEW###']."')";
			}
			else
			{
				$redirectMessage = "\t\t\t//".$this->setLine(__LINE__)." redirect away to the home page if no access allowed.";
				$redirectString = 'JURI::root()';
			}
			$accessCheck[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." check if this user has permission to access item";
			$accessCheck[] = "\t\tif (!".$userString."->authorise('site.".$view['settings']->code.".access', 'com_".$this->fileContentStatic['###component###']."'))";
			$accessCheck[] = "\t\t{";
			$accessCheck[] = "\t\t\t\$app = JFactory::getApplication();";
			// set lang
			$langKeyWord = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Not authorised to view '.$view['settings']->code.'!','U');
			if (!isset($this->langContent['site'][$langKeyWord]))
			{
				$this->langContent['site'][$langKeyWord] = 'Not authorised to view '.$view['settings']->code.'!';
			}
			$accessCheck[] = "\t\t\t\$app->enqueueMessage(JText::_('".$langKeyWord."'), 'error');";
			$accessCheck[] = $redirectMessage;
			$accessCheck[] = "\t\t\t\$app->redirect(".$redirectString.");";
			$accessCheck[] = "\t\t\treturn false;";
			$accessCheck[] = "\t\t}";
			
			// return the access check
			return implode(PHP_EOL,$accessCheck);
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
			$this->siteDecrypt['basic'][$code] = false;
			$this->siteDecrypt['advanced'][$code] = false;

			$getItem = PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get a db connection.";
			$getItem .= PHP_EOL."\t".$tab."\t\$db = JFactory::getDbo();";
			$getItem .= PHP_EOL.PHP_EOL.$tab."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$getItem .= PHP_EOL."\t".$tab."\t\$query = \$db->getQuery(true);";
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get,$code,$tab);
			// setup filters
			$getItem .= $this->setCustomViewFilter($get->filter,$code,$tab);
			// setup Where
			$getItem .= $this->setCustomViewWhere($get->where,$code,$tab);
			// setup ordering
			$getItem .= $this->setCustomViewOrder($get->order,$code,$tab);
			// get ready to get query
			$getItem .= PHP_EOL.PHP_EOL.$tab."\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
			$getItem .= PHP_EOL."\t".$tab."\t\$db->setQuery(\$query);";
			$getItem .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Load the results as a stdClass object.";
			$getItem .= PHP_EOL."\t".$tab."\t\$data = \$db->loadObject();";
			$getItem .= PHP_EOL.PHP_EOL.$tab."\t\tif (empty(\$data))";
			$getItem .= PHP_EOL."\t".$tab."\t{";
			if ($type === 'main')
			{
				$getItem .= PHP_EOL."\t".$tab."\t\t\$app = JFactory::getApplication();";
				$langKeyWoord = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Not found or access denied','U');
				if (!isset($this->langContent[$this->lang][$langKeyWoord]))
				{
					$this->langContent[$this->lang][$langKeyWoord] = 'Not found, or access denied.';
				}
				$getItem .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." If no data is found redirect to default page and show warning.";
				$getItem .= PHP_EOL."\t".$tab."\t\t\$app->enqueueMessage(JText::_('".$langKeyWoord."'), 'warning');";
				if ('site' === $this->target)
				{
					// check that the default and the redirect page is not the same
					if (isset($this->fileContentStatic['###SITE_DEFAULT_VIEW###']) && $this->fileContentStatic['###SITE_DEFAULT_VIEW###'] != $code)
					{
						$redirectString = "JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$this->fileContentStatic['###SITE_DEFAULT_VIEW###']."')";
					}
					else
					{
						$redirectString = 'JURI::root()';
					}
					$getItem .= PHP_EOL."\t".$tab."\t\t\$app->redirect(".$redirectString.");";
				}
				else
				{
					$getItem .= PHP_EOL."\t".$tab."\t\t\$app->redirect('index.php?option=com_".$this->fileContentStatic['###component###']."');";
				}
				$getItem .= PHP_EOL."\t".$tab."\t\treturn false;";
			}
			else
			{
				$getItem .= PHP_EOL."\t".$tab."\t\treturn false;";
			}
			$getItem .= PHP_EOL."\t".$tab."\t}";
			if (ComponentbuilderHelper::checkArray($get->main_get))
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
							$getItem .= $this->setCustomViewFieldDecode($main_get,$decodeChecker,'$data',$code,$tab);
						}
					}
						
					if (isset ($this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeFilter))
						{
							// also filter fields if needed
							$getItem .= $this->setCustomViewFieldDecodeFilter($main_get,$decodeFilter,'$data','$data',$code,$tab);
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

			if ((isset($this->siteDecrypt['basic'][$code]) && $this->siteDecrypt['basic'][$code]) || (isset($this->siteDecrypt['advanced'][$code]) && $this->siteDecrypt['advanced'][$code]))
			{
				$Component	= $this->fileContentStatic['###Component###'];
				$script = '';
				if (isset($this->siteDecrypt['basic'][$code]) && $this->siteDecrypt['basic'][$code])
				{
					$script .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the basic encryption.";
					$script .= PHP_EOL."\t".$tab."\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
					$script .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the encryption object.";
					$script .= PHP_EOL."\t".$tab."\t\$basic = new FOFEncryptAes(\$basickey, 128);";
				}
				if (isset($this->siteDecrypt['advanced'][$code]) && $this->siteDecrypt['advanced'][$code])
				{
					$script .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the advanced encryption.";
					$script .= PHP_EOL."\t".$tab."\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
					$script .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the encryption object.";
					$script .= PHP_EOL."\t".$tab."\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
				}
				$getItem = $script . $getItem;
			}
			// setup Globals
			$getItem .= $this->setCustomViewGlobals($get->global,'$data',$asBucket,$tab);
			// setup the custom gets that returns multipal values
			$getItem .= $this->setCustomViewCustomJoin($get->custom_get,'$data',$code,$asBucket,$tab);
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode(PHP_EOL,$get->php_calculation);
				$getItem .= PHP_EOL."\t".$tab."\t".implode(PHP_EOL."\t".$tab."\t",$get->php_calculation);
			}
			if ($type === 'custom')
			{
				// return the object
				$getItem .=  PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." return data object.";
				$getItem .=  PHP_EOL."\t".$tab."\treturn \$data;";
			}
			else
			{
				// set the object
				$getItem .=  PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." set data object to item.";
				$getItem .=  PHP_EOL."\t".$tab."\t\$this->_item[\$pk] = \$data;";
			}
			return $getItem;
		}
		return PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)."add your custom code here.";
	}

	public function setCustomViewCustomMethods($main_view,$code)
	{
		$methods = '';
		// then set the needed custom methods
		if (ComponentbuilderHelper::checkArray($main_view['settings']->custom_get))
		{
			// start dynamic build
			foreach ($main_view['settings']->custom_get as $view)
			{
				// fix alias to use in code
				$view->code = ComponentbuilderHelper::safeString($code);
				$view->Code = ComponentbuilderHelper::safeString($view->code, 'F');
				$view->CODE = ComponentbuilderHelper::safeString($view->code, 'U');
				$main = '';
				if ($view->gettype == 3)
				{
					// ###SITE_GET_ITEM### <<<DYNAMIC>>>
					$main .= PHP_EOL.PHP_EOL."\t\tif (!isset(\$this->initSet) || !\$this->initSet)";
					$main .= PHP_EOL."\t\t{";
					$main .= PHP_EOL."\t\t\t\$this->user\t\t= JFactory::getUser();";
					$main .= PHP_EOL."\t\t\t\$this->userId\t\t= \$this->user->get('id');";
					$main .= PHP_EOL."\t\t\t\$this->guest\t\t= \$this->user->get('guest');";
					$main .= PHP_EOL."\t\t\t\$this->groups\t\t= \$this->user->get('groups');";
					$main .= PHP_EOL."\t\t\t\$this->authorisedGroups\t= \$this->user->getAuthorisedGroups();";
					$main .= PHP_EOL."\t\t\t\$this->levels\t\t= \$this->user->getAuthorisedViewLevels();";
					$main .= PHP_EOL."\t\t\t\$this->initSet\t\t= true;";
					$main .= PHP_EOL."\t\t}";
					$main .= $this->setCustomViewGetItem($view, $view->code,'','custom');
					$type = 'mixed  item data object on success, false on failure.';
				}
				elseif ($view->gettype == 4)
				{
					$main .= PHP_EOL.PHP_EOL."\t\tif (!isset(\$this->initSet) || !\$this->initSet)";
					$main .= PHP_EOL."\t\t{";
					$main .= PHP_EOL."\t\t\t\$this->user\t\t= JFactory::getUser();";
					$main .= PHP_EOL."\t\t\t\$this->userId\t\t= \$this->user->get('id');";
					$main .= PHP_EOL."\t\t\t\$this->guest\t\t= \$this->user->get('guest');";
					$main .= PHP_EOL."\t\t\t\$this->groups\t\t= \$this->user->get('groups');";
					$main .= PHP_EOL."\t\t\t\$this->authorisedGroups\t= \$this->user->getAuthorisedGroups();";
					$main .= PHP_EOL."\t\t\t\$this->levels\t\t= \$this->user->getAuthorisedViewLevels();";
					$main .= PHP_EOL."\t\t\t\$this->initSet\t\t= true;";
					$main .= PHP_EOL."\t\t}";
					$main .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the global params";
					$main .= PHP_EOL."\t\t\$globalParams = JComponentHelper::getParams('com_".$this->fileContentStatic['###component###']."', true);";
					// ###SITE_GET_LIST_QUERY### <<<DYNAMIC>>>
					$main .= $this->setCustomViewListQuery($view, $view->code, false);
					// load the object list
					$main .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$main .= PHP_EOL."\t\t\$db->setQuery(\$query);";
					$main .= PHP_EOL."\t\t\$items = \$db->loadObjectList();";
					$main .= PHP_EOL.PHP_EOL."\t\tif (empty(\$items))";
					$main .= PHP_EOL."\t\t{";
					$main .= PHP_EOL."\t\t\treturn false;";
					$main .= PHP_EOL."\t\t}";
					// ###SITE_GET_ITEMS### <<<DYNAMIC>>>
					$main .= $this->setCustomViewGetItems($view,$view->code);
					$main .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." return items";
					$main .= PHP_EOL."\t\treturn \$items;";
					$type = 'mixed  An array of objects on success, false on failure.';
				}
				// load the main mehtod
				$methods .= $this->setMainCustomMehtod($main,$view->getcustom,$type);
				// ###SITE_CUSTOM_METHODS### <<<DYNAMIC>>>
				$methods .= $this->setCustomViewCustomItemMethods($view, $view->code);
			}
		}
		// load uikit get method
		$methods .= $this->setUikitGetMethod();

		return $methods;
	}

	public function setUikitHelperMethods()
	{
		// only load for uikit version 2
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			// build uikit get method
			$ukit = array();
			$ukit[] = PHP_EOL.PHP_EOL."\t/**";
			$ukit[] = "\t* \tUIKIT Component Classes";
			$ukit[] = "\t**/";
			$ukit[] = "\tpublic static \$uk_components = array(";
			$ukit[] = "\t\t\t'data-uk-grid' => array(";
			$ukit[] = "\t\t\t\t'grid' ),";
			$ukit[] = "\t\t\t'uk-accordion' => array(";
			$ukit[] = "\t\t\t\t'accordion' ),";
			$ukit[] = "\t\t\t'uk-autocomplete' => array(";
			$ukit[] = "\t\t\t\t'autocomplete' ),";
			$ukit[] = "\t\t\t'data-uk-datepicker' => array(";
			$ukit[] = "\t\t\t\t'datepicker' ),";
			$ukit[] = "\t\t\t'uk-form-password' => array(";
			$ukit[] = "\t\t\t\t'form-password' ),";
			$ukit[] = "\t\t\t'uk-form-select' => array(";
			$ukit[] = "\t\t\t\t'form-select' ),";
			$ukit[] = "\t\t\t'data-uk-htmleditor' => array(";
			$ukit[] = "\t\t\t\t'htmleditor' ),";
			$ukit[] = "\t\t\t'data-uk-lightbox' => array(";
			$ukit[] = "\t\t\t\t'lightbox' ),";
			$ukit[] = "\t\t\t'uk-nestable' => array(";
			$ukit[] = "\t\t\t\t'nestable' ),";
			$ukit[] = "\t\t\t'UIkit.notify' => array(";
			$ukit[] = "\t\t\t\t'notify' ),";
			$ukit[] = "\t\t\t'data-uk-parallax' => array(";
			$ukit[] = "\t\t\t\t'parallax' ),";
			$ukit[] = "\t\t\t'uk-search' => array(";
			$ukit[] = "\t\t\t\t'search' ),";
			$ukit[] = "\t\t\t'uk-slider' => array(";
			$ukit[] = "\t\t\t\t'slider' ),";
			$ukit[] = "\t\t\t'uk-slideset' => array(";
			$ukit[] = "\t\t\t\t'slideset' ),";
			$ukit[] = "\t\t\t'uk-slideshow' => array(";
			$ukit[] = "\t\t\t\t'slideshow',";
			$ukit[] = "\t\t\t\t'slideshow-fx' ),";
			$ukit[] = "\t\t\t'uk-sortable' => array(";
			$ukit[] = "\t\t\t\t'sortable' ),";
			$ukit[] = "\t\t\t'data-uk-sticky' => array(";
			$ukit[] = "\t\t\t\t'sticky' ),";
			$ukit[] = "\t\t\t'data-uk-timepicker' => array(";
			$ukit[] = "\t\t\t\t'timepicker' ),";
			$ukit[] = "\t\t\t'data-uk-tooltip' => array(";
			$ukit[] = "\t\t\t\t'tooltip' ),";
			$ukit[] = "\t\t\t'uk-placeholder' => array(";
			$ukit[] = "\t\t\t\t'placeholder' ),";
			$ukit[] = "\t\t\t'uk-dotnav' => array(";
			$ukit[] = "\t\t\t\t'dotnav' ),";
			$ukit[] = "\t\t\t'uk-slidenav' => array(";
			$ukit[] = "\t\t\t\t'slidenav' ),";
			$ukit[] = "\t\t\t'uk-form' => array(";
			$ukit[] = "\t\t\t\t'form-advanced' ),";
			$ukit[] = "\t\t\t'uk-progress' => array(";
			$ukit[] = "\t\t\t\t'progress' ),";
			$ukit[] = "\t\t\t'upload-drop' => array(";
			$ukit[] = "\t\t\t\t'upload', 'form-file' )";
			$ukit[] = "\t\t\t);";
			$ukit[] = "\t";
			$ukit[] = "\t/**";
			$ukit[] = "\t* \tAdd UIKIT Components";
			$ukit[] = "\t**/";
			$ukit[] = "\tpublic static \$uikit = false;";
			$ukit[] = "";
			$ukit[] = "\t/**";
			$ukit[] = "\t* \tGet UIKIT Components";
			$ukit[] = "\t**/";
			$ukit[] = "\tpublic static function getUikitComp(\$content,\$classes = array())";
			$ukit[] = "\t{";
			$ukit[] = "\t\tif (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = "\t\t{";
			$ukit[] = "\t\t\t//".$this->setLine(__LINE__)." reset";
			$ukit[] = "\t\t\t\$temp = array();";
			$ukit[] = "\t\t\tforeach (self::\$uk_components as \$looking => \$add)";
			$ukit[] = "\t\t\t{";
			$ukit[] = "\t\t\t\tif (strpos(\$content,\$looking) !== false)";
			$ukit[] = "\t\t\t\t{";
			$ukit[] = "\t\t\t\t\t\$temp[] = \$looking;";
			$ukit[] = "\t\t\t\t}";
			$ukit[] = "\t\t\t}";
			$ukit[] = "\t\t\t//".$this->setLine(__LINE__)." make sure uikit is loaded to config";
			$ukit[] = "\t\t\tif (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = "\t\t\t{";
			$ukit[] = "\t\t\t\tself::\$uikit = true;";
			$ukit[] = "\t\t\t}";
			$ukit[] = "\t\t\t//".$this->setLine(__LINE__)." sorter";
			$ukit[] = "\t\t\tif (self::checkArray(\$temp))";
			$ukit[] = "\t\t\t{";
			$ukit[] = "\t\t\t\t//".$this->setLine(__LINE__)." merger";
			$ukit[] = "\t\t\t\tif (self::checkArray(\$classes))";
			$ukit[] = "\t\t\t\t{";
			$ukit[] = "\t\t\t\t\t\$newTemp = array_merge(\$temp,\$classes);";
			$ukit[] = "\t\t\t\t\t\$temp = array_unique(\$newTemp);";
			$ukit[] = "\t\t\t\t}";
			$ukit[] = "\t\t\t\treturn \$temp;";
			$ukit[] = "\t\t\t}";
			$ukit[] = "\t\t}\t";
			$ukit[] = "\t\tif (self::checkArray(\$classes))";
			$ukit[] = "\t\t{";
			$ukit[] = "\t\t\treturn \$classes;";
			$ukit[] = "\t\t}";
			$ukit[] = "\t\treturn false;";
			$ukit[] = "\t}";

			// return the help methods
			return implode(PHP_EOL,$ukit);
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
			$method .= PHP_EOL.PHP_EOL."\t/**";
			$method .= PHP_EOL."\t* Get the uikit needed components";
			$method .= PHP_EOL."\t*";
			$method .= PHP_EOL."\t* @return mixed  An array of objects on success.";
			$method .= PHP_EOL."\t*";
			$method .= PHP_EOL."\t*/";
			$method .= PHP_EOL."\tpublic function getUikitComp()";
			$method .= PHP_EOL."\t{";
			$method .= PHP_EOL."\t\tif (isset(\$this->uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$this->uikitComp))";
			$method .= PHP_EOL."\t\t{";
			$method .= PHP_EOL."\t\t\treturn \$this->uikitComp;";
			$method .= PHP_EOL."\t\t}";
			$method .= PHP_EOL."\t\treturn false;";
			$method .= PHP_EOL."\t}";
		}
		return $method;
	}

	public function setMainCustomMehtod(&$body,$nAme,$type)
	{
		$method = '';
		if (ComponentbuilderHelper::checkString($body))
		{
			// build custom method
			$method .= PHP_EOL.PHP_EOL."\t/**";
			$method .= PHP_EOL."\t* Custom Method";
			$method .= PHP_EOL."\t*";
			$method .= PHP_EOL."\t* @return ".$type;
			$method .= PHP_EOL."\t*";
			$method .= PHP_EOL."\t*/";
			$method .= PHP_EOL."\tpublic function ".$nAme."()";
			$method .= PHP_EOL."\t{".$body;
			$method .= PHP_EOL."\t}";
		}
		return $method;
	}

	public function setCustomViewCustomItemMethods(&$main_get,$code)
	{
		$methods = '';
		// first set the needed item/s methods
		if (ComponentbuilderHelper::checkObject($main_get))
		{
			if (isset($main_get->custom_get) && ComponentbuilderHelper::checkArray($main_get->custom_get))
			{
				foreach ($main_get->custom_get as $get)
				{
					$this->siteDecrypt['basic'][$code] = false;
					$this->siteDecrypt['advanced'][$code] = false;
					// set the method defaults
					$default = $this->setCustomViewMethodDefaults($get,$code);
					// build custom method
					$methods .= PHP_EOL.PHP_EOL."\t/**";
					$methods .= PHP_EOL."\t* Method to get an array of ".$default['name']." Objects.";
					$methods .= PHP_EOL."\t*";
					$methods .= PHP_EOL."\t* @return mixed  An array of ".$default['name']." Objects on success, false on failure.";
					$methods .= PHP_EOL."\t*";
					$methods .= PHP_EOL."\t*/";
					$methods .= PHP_EOL."\tpublic function get".$default['methodName']."(\$".$default['on_field'].")";
					$methods .= PHP_EOL."\t{###CRYPT###";
					$methods .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get a db connection.";
					$methods .= PHP_EOL."\t\t\$db = JFactory::getDbo();";
					$methods .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
					$methods .= PHP_EOL."\t\t\$query = \$db->getQuery(true);";
					$methods .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get from ".$get['selection']['table']." as ".$default['as'];
					$methods .= PHP_EOL."\t\t".$get['selection']['select'];
					$methods .= PHP_EOL."\t\t".'$query->from('.$get['selection']['from'].');';
					// set the string
					if ($get['operator'] === 'IN' || $get['operator'] === 'NOT IN')
					{
						$methods .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Check if \$" . $default['on_field'] . " is an array with values.";
						$methods .= PHP_EOL."\t\t\$array = \$" . $default['on_field'] . ";";
						$methods .= PHP_EOL."\t\tif (isset(\$array) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$array, true))";
						$methods .= PHP_EOL."\t\t{";
						$methods .= PHP_EOL."\t\t\t\$query->where('".$get['join_field']." ".$get['operator']." (' . implode(',', \$array) . ')');";
						$methods .= PHP_EOL."\t\t}";
						$methods .= PHP_EOL."\t\telse";
						$methods .= PHP_EOL."\t\t{";
						$methods .= PHP_EOL."\t\t\treturn false;";
						$methods .= PHP_EOL."\t\t}";
					}
					else
					{
						$methods .= PHP_EOL."\t\t\$query->where('".$get['join_field']." ".$get['operator']." ' . \$db->quote(\$".$default['on_field']."));";
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
					$methods .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$methods .= PHP_EOL."\t\t\$db->setQuery(\$query);";
					$methods .= PHP_EOL."\t\t\$db->execute();";
					$methods .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." check if there was data returned";
					$methods .= PHP_EOL."\t\tif (\$db->getNumRows())";
					$methods .= PHP_EOL."\t\t{";
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
					// set joined values
					$placeholders = array('###TAB###' => "\t\t", '###STRING###' => '$item');
					$joinedChecker = (isset($this->otherJoin[$this->target][$default['code']][$default['as']]) && ComponentbuilderHelper::checkArray($this->otherJoin[$this->target][$default['code']][$default['as']])) ? $this->otherJoin[$this->target][$default['code']][$default['as']] : '';
					if (	(isset($decodeChecker) && ComponentbuilderHelper::checkArray($decodeChecker)) || 
						(isset($uikitChecker) && ComponentbuilderHelper::checkArray($uikitChecker)) || 
						(isset($decodeFilter) && ComponentbuilderHelper::checkArray($decodeFilter)) || 
						ComponentbuilderHelper::checkArray($joinedChecker))
					{
						$decoder = '';
						if (isset($decodeChecker) && ComponentbuilderHelper::checkArray($decodeChecker))
						{
							// also filter fields if needed
							$decoder = $this->setCustomViewFieldDecode($get,$decodeChecker,'$item',$default['code'],"\t\t");
						}
						$decoder_filter = '';
						if (isset($decodeFilter) && ComponentbuilderHelper::checkArray($decodeFilter))
						{
							$decoder_filter = $this->setCustomViewFieldDecodeFilter($get,$decodeFilter,'$item','$items[$nr]',$default['code'],"\t\t");
						}
						$uikit = '';
						if (isset($uikitChecker) && ComponentbuilderHelper::checkArray($uikitChecker))
						{
							$uikit = $this->setCustomViewFieldUikitChecker($get,$uikitChecker,'$item',$default['code'],"\t\t");
						}
						$joine = '';
						if (ComponentbuilderHelper::checkArray($joinedChecker))
						{
							foreach ($joinedChecker as $joinedString)
							{
								$joine .= $this->setPlaceholders($joinedString, $placeholders);
							}
						}
						if (ComponentbuilderHelper::checkString($decoder) || ComponentbuilderHelper::checkString($uikit) || ComponentbuilderHelper::checkString($decoder_filter) || ComponentbuilderHelper::checkString($joine))
						{
							$methods .= PHP_EOL."\t\t\t\$items = \$db->loadObjectList();";
							$methods .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Convert the parameter fields into objects.";
							$methods .= PHP_EOL."\t\t\tforeach (\$items as \$nr => &\$item)";
							$methods .= PHP_EOL."\t\t\t{";
							if (ComponentbuilderHelper::checkString($decoder))
							{
								$methods .= $decoder;
							}
							if (ComponentbuilderHelper::checkString($decoder_filter))
							{
								$methods .= $decoder_filter;
							}
							if (ComponentbuilderHelper::checkString($uikit))
							{
								$methods .= $uikit;
							}
							if (ComponentbuilderHelper::checkString($joine))
							{
								$methods .= $joine;
							}
							$methods .= PHP_EOL."\t\t\t}";
							$methods .= PHP_EOL."\t\t\treturn \$items;";
						}
						else
						{
							$methods .= PHP_EOL."\t\t\treturn \$db->loadObjectList();";
						}
					}
					else
					{
						$methods .= PHP_EOL."\t\t\treturn \$db->loadObjectList();";
					}
					$methods .= PHP_EOL."\t\t}";
					$methods .= PHP_EOL."\t\treturn false;";
					$methods .= PHP_EOL."\t}";

					if ((isset($this->siteDecrypt['basic'][$code]) && $this->siteDecrypt['basic'][$code]) || (isset($this->siteDecrypt['advanced'][$code]) && $this->siteDecrypt['advanced'][$code]))
					{
						$Component	= $this->fileContentStatic['###Component###'];
						$script = '';
						if ($this->siteDecrypt['basic'][$code])
						{
							$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the basic encryption.";
							$script .= PHP_EOL."\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
							$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the encryption object.";
							$script .= PHP_EOL."\t\t\$basic = new FOFEncryptAes(\$basickey, 128);".PHP_EOL;
						}
						if ($this->siteDecrypt['advanced'][$code])
						{
							$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the advanced encryption.";
							$script .= PHP_EOL."\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
							$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the encryption object.";
							$script .= PHP_EOL."\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);".PHP_EOL;
						}
						$methods = str_replace('###CRYPT###',$script,$methods);
					}
				}
				$methods = str_replace('###CRYPT###','',$methods);
			}
		}
		return $methods.PHP_EOL;
	}

	public function setCustomViewMethodDefaults($get,$code)
	{
		$key = substr(ComponentbuilderHelper::safeString(preg_replace('/[0-9]+/', '', md5($get['key'])),'F'), 0, 4);
		$method['on_field'] = (isset($get['on_field'])) ? $this->removeAsDot($get['on_field']):null;
		$method['join_field'] = (isset($get['join_field'])) ? ComponentbuilderHelper::safeString($this->removeAsDot($get['join_field'])):null;
		$method['Join_field'] = (isset($method['join_field'])) ? ComponentbuilderHelper::safeString($method['join_field'],'F'):null;
		$method['name'] = ComponentbuilderHelper::safeString($get['selection']['name'],'F');
		$method['code'] = ComponentbuilderHelper::safeString($code);
		$method['AS'] = ComponentbuilderHelper::safeString($get['as'],'U');
		$method['as'] = ComponentbuilderHelper::safeString($get['as']);
		$method['valueName'] = $method['on_field'] . $method['Join_field'] . $method['name'] . $method['AS'];
		$method['methodName'] = ComponentbuilderHelper::safeString($method['on_field'],'F') . $method['Join_field'] . $method['name'] . $key .'_'. $method['AS'];
		// return
		return $method;
	}

	public function getCustomScriptBuilder($first, $second, $prefix = '', $note = null, $unset = null, $default = null, $sufix = '')
	{
                // check if there is any custom script
                $script = '';
		if (isset($this->customScriptBuilder[$first][$second]) && ComponentbuilderHelper::checkString($this->customScriptBuilder[$first][$second]))
		{
                        // add not if set
                        if ($note)
                        {
                                $script .= $note;
                        }
			$script .= $prefix . str_replace( array_keys($this->placeholders), array_values($this->placeholders), $this->customScriptBuilder[$first][$second]) . $sufix;
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

	public function setCustomViewListQuery(&$get,$code,$return = true)
	{
		if (ComponentbuilderHelper::checkObject($get))
		{
			if ($get->pagination == 1)
			{
				$getItem = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get a db connection.";
			}
			else
			{
				$getItem = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Make sure all records load, since no pagination allowed.";
				$getItem .= PHP_EOL."\t\t\$this->setState('list.limit', 0);";
				$getItem .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get a db connection.";
			}
			$getItem .= PHP_EOL."\t\t\$db = JFactory::getDbo();";
			$getItem .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$getItem .= PHP_EOL."\t\t\$query = \$db->getQuery(true);";
			// check if there is any custom script
                        $getItem .= $this->getCustomScriptBuilder($this->target.'_php_getlistquery', $code, '', PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filtering.", true);
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get,$code);
			// setup filters
			$getItem .= $this->setCustomViewFilter($get->filter,$code);
			// setup where
			$getItem .= $this->setCustomViewWhere($get->where,$code);
			// setup ordering
			$getItem .= $this->setCustomViewOrder($get->order,$code);
			if ($return)
			{
				// return the query object
				$getItem .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." return the query object".PHP_EOL."\t\treturn \$query;";
			}

			return $getItem;
		}
		return PHP_EOL."\t\t//".$this->setLine(__LINE__)."add your custom code here.";
	}

	/**
	 * @param $get
	 * @param $code
	 * @return string
     */
	public function setCustomViewGetItems(&$get, $code)
	{
		$getItem = '';
		$this->siteDecrypt['basic'][$code] = false;
		$this->siteDecrypt['advanced'][$code] = false;
		$Component = $this->fileContentStatic['###Component###'];
		if (ComponentbuilderHelper::checkObject($get))
		{
			$getItem .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Convert the parameter fields into objects.";
			$getItem .= PHP_EOL."\t\tif (".$Component."Helper::checkArray(\$items))";
			$getItem .= PHP_EOL."\t\t{";
			$getItem .= PHP_EOL."\t\t\tforeach (\$items as \$nr => &\$item)";
			$getItem .= PHP_EOL."\t\t\t{";
			$getItem .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Always create a slug for sef URL's";
			$getItem .= PHP_EOL."\t\t\t\t\$item->slug = (isset(\$item->alias) && isset(\$item->id)) ? \$item->id.':'.\$item->alias : \$item->id;";
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
							$getItem .= $this->setCustomViewFieldDecode($main_get,$decodeChecker,"\$item",$code,"\t\t");
						}
					}
					// also filter fields if needed
					if (isset($this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']]))
					{
						$decodeFilter = $this->siteFieldDecodeFilter[$this->target][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($decodeFilter))
						{
							$getItem .= $this->setCustomViewFieldDecodeFilter($main_get,$decodeFilter,"\$item",'$items[$nr]',$code,"\t\t");
						}
					}
					if (isset($this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']]))
					{
						$uikitChecker = $this->siteFieldData['uikit'][$code][$main_get['key']][$main_get['as']];
						if (ComponentbuilderHelper::checkArray($uikitChecker))
						{
							// set uikit checkers on needed fields
							$getItem .= $this->setCustomViewFieldUikitChecker($main_get,$uikitChecker,"\$item",$code,"\t\t");
						}
					}
					$asBucket[] = $main_get['as'];
				}
			}
			// setup Globals
			$getItem .= $this->setCustomViewGlobals($get->global,'$item',$asBucket,"\t\t");
			// setup the custom gets that returns multipal values
			$getItem .= $this->setCustomViewCustomJoin($get->custom_get,"\$item",$code,$asBucket,"\t\t");
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode(PHP_EOL,$get->php_calculation);
				if (ComponentbuilderHelper::checkArray($get->php_calculation))
				{
					$_tmp = PHP_EOL."\t\t\t\t".implode(PHP_EOL."\t\t\t\t",$get->php_calculation);
					$getItem .= $this->setPlaceholders($_tmp, $this->placeholders);
				}
			}
			$getItem .= PHP_EOL."\t\t\t}";
			$getItem .= PHP_EOL."\t\t}";
			// remove empty foreach
			if (strlen($getItem) <= 100)
			{
				$getItem = PHP_EOL;
			}
		}

		if ($this->siteDecrypt['basic'][$code] || $this->siteDecrypt['advanced'][$code])
		{
			$script = '';
			if ($this->siteDecrypt['basic'][$code])
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the basic encryption.";
				$script .= PHP_EOL."\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the encryption object.";
				$script .= PHP_EOL."\t\t\$basic = new FOFEncryptAes(\$basickey, 128);";
			}
			if ($this->siteDecrypt['advanced'][$code])
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the advanced encryption.";
				$script .= PHP_EOL."\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the encryption object.";
				$script .= PHP_EOL."\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
			}
			$getItem = $script . $getItem;
		}
		return $getItem;
	}

	public function setCustomViewDisplayMethod(&$view)
	{
		$method = '';
		if (isset($view['settings']->main_get) && ComponentbuilderHelper::checkObject($view['settings']->main_get))
		{
			if ($view['settings']->main_get->gettype == 1)
			{
				// for single views
				$method .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Initialise variables.";
				$method .= PHP_EOL."\t\t\$this->item\t= \$this->get('Item');";
			}
			elseif ($view['settings']->main_get->gettype == 2)
			{
				// for list views
				$method .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Initialise variables.";
				$method .= PHP_EOL."\t\t\$this->items\t= \$this->get('Items');";
				// only add if pagination is requered
				if ($view['settings']->main_get->pagination == 1)
				{
					$method .= PHP_EOL."\t\t\$this->pagination\t= \$this->get('Pagination');";
				}
				// add id to list view
				if (isset($this->customAdminViewListId[$view['settings']->code]))
				{
					// ###HIDDEN_INPUT_VALUES###
					$this->fileContentDynamic[$view['settings']->code]['###HIDDEN_INPUT_VALUES###'] = PHP_EOL."\t".'<input type="hidden" name="id" value="<?php echo $this->app->input->getInt(\'id\', 0); ?>" />';
				}
				else
				{
					// also set the input value ###HIDDEN_INPUT_VALUES###
					$this->fileContentDynamic[$view['settings']->code]['###HIDDEN_INPUT_VALUES###'] = '';
				}
			}
			// add the custom get methods
			if (isset($view['settings']->custom_get) && ComponentbuilderHelper::checkArray($view['settings']->custom_get))
			{
				foreach ($view['settings']->custom_get as $custom_get)
				{
					$custom_get_name = str_replace('get','',$custom_get->getcustom);
					$method .= PHP_EOL."\t\t\$this->".ComponentbuilderHelper::safeString($custom_get_name)."\t= \$this->get('".$custom_get_name."');";
				}
			}
			// add custom script
			if ($view['settings']->add_php_jview_display == 1)
			{
				$view['settings']->php_jview_display = (array) explode(PHP_EOL,$view['settings']->php_jview_display);
				if (ComponentbuilderHelper::checkArray($view['settings']->php_jview_display))
				{
					$_tmp = PHP_EOL."\t\t".implode(PHP_EOL."\t\t",$view['settings']->php_jview_display);
					$method .= $this->setPlaceholders($_tmp, $this->placeholders);
				}
			}
			if ('site' === $this->target)
			{
				$method .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set the toolbar";
				$method .= PHP_EOL."\t\t\$this->addToolBar();";
				$method .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." set the document";
				$method .= PHP_EOL."\t\t\$this->_prepareDocument();";
			}
			elseif ('custom_admin' === $this->target)
			{
				$method .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." We don't need toolbar in the modal window.";
				$method .= PHP_EOL."\t\tif (\$this->getLayout() !== 'modal')";
				$method .= PHP_EOL."\t\t{";
				$method .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." add the tool bar";
				$method .= PHP_EOL."\t\t\t\$this->addToolBar();";
				$method .= PHP_EOL."\t\t}";
				$method .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." set the document";
				$method .= PHP_EOL."\t\t\$this->setDocument();";
			}

			$method .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Check for errors.";
			$method .= PHP_EOL."\t\tif (count(\$errors = \$this->get('Errors')))";
			$method .= PHP_EOL."\t\t{";
			$method .= PHP_EOL."\t\t\tthrow new Exception(implode(".'"\n", $errors), 500);';
			$method .= PHP_EOL."\t\t}";
			
			$method .= PHP_EOL.PHP_EOL."\t\tparent::display(\$tpl);";
		}
		return $method;
	}

	public function setPrepareDocument(&$view)
	{
		// ensure correct target is set
		$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
		// set uikit ###'.$TARGET.'_UIKIT_LOADER###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_UIKIT_LOADER###'] = $this->setUikitLoader($view);

		// set Google Charts ###'.$TARGET.'_GOOGLECHART_LOADER###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GOOGLECHART_LOADER###'] = $this->setGoogleChartLoader($view);

		// set Footable ###FOOTABLE_LOADER###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_FOOTABLE_LOADER###'] = $this->setFootableScriptsLoader($view);

		// set metadata ###DOCUMENT_METADATA###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_METADATA###'] = $this->setDocumentMetadata($view);

		// set custom php scripting ###DOCUMENT_CUSTOM_PHP###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_CUSTOM_PHP###'] = $this->setDocumentCustomPHP($view);

		// set custom css ###DOCUMENT_CUSTOM_CSS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_CUSTOM_CSS###'] = $this->setDocumentCustomCSS($view);

		// set custom javascript ###DOCUMENT_CUSTOM_JS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_DOCUMENT_CUSTOM_JS###'] = $this->setDocumentCustomJS($view);

		// set custom css file ###VIEWCSS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_VIEWCSS###'] = $this->setCustomCSS($view);

		// set the custom buttons ###CUSTOM_BUTTONS###
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_CUSTOM_BUTTONS###'] = $this->setCustomButtons($view);
		
		// only set the custom get form method if site target
		if ('site' === $this->target)
		{
			// set the custom get form method  ###SITE_CUSTOM_GET_FORM_METHOD###
			$this->fileContentDynamic[$view['settings']->code]['###SITE_CUSTOM_GET_FORM_METHOD###'] = $this->setCustomGetForm($view);
		}
		
		// see if we should add get modules to the view.html
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GET_MODULE###'] = $this->setGetModules($view,$TARGET);
		
	}
	
	public function setGetModules($view,$TARGET)
	{
		if (isset($this->getModule[$this->target][$view['settings']->code]) && $this->getModule[$this->target][$view['settings']->code])
		{
			$addModule = array();
			$addModule[] = PHP_EOL.PHP_EOL."\t/**";
			$addModule[] = "\t * Get the modules published in a position";
			$addModule[] = "\t */";
			$addModule[] = "\tpublic function getModules(\$position, \$seperator = '', \$class = '')";
			$addModule[] = "\t{";
			$addModule[] = "\t\t//".$this->setLine(__LINE__)." set default";
			$addModule[] = "\t\t\$found = false;";
			$addModule[] = "\t\t//".$this->setLine(__LINE__)." check if we aleady have these modules loaded";
			$addModule[] = "\t\tif (isset(\$this->setModules[\$position]))";
			$addModule[] = "\t\t{";
			$addModule[] = "\t\t\t\$found = true;";
			$addModule[] = "\t\t}";
			$addModule[] = "\t\telse";
			$addModule[] = "\t\t{";
			$addModule[] = "\t\t\t//".$this->setLine(__LINE__)." this is where you want to load your module position";
			$addModule[] = "\t\t\t\$modules = JModuleHelper::getModules(\$position);";
			$addModule[] = "\t\t\tif (\$modules)";
			$addModule[] = "\t\t\t{";
			$addModule[] = "\t\t\t\t//".$this->setLine(__LINE__)." set the place holder";
			$addModule[] = "\t\t\t\t\$this->setModules[\$position] = array();";
			$addModule[] = "\t\t\t\tforeach(\$modules as \$module)";
			$addModule[] = "\t\t\t\t{";
			$addModule[] = "\t\t\t\t\t\$this->setModules[\$position][] = JModuleHelper::renderModule(\$module);";
			$addModule[] = "\t\t\t\t}";
			$addModule[] = "\t\t\t\t\$found = true;";
			$addModule[] = "\t\t\t}";
			$addModule[] = "\t\t}";
			$addModule[] = "\t\t//".$this->setLine(__LINE__)." check if modules were found";
			$addModule[] = "\t\tif (\$found && isset(\$this->setModules[\$position]) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$this->setModules[\$position]))";
			$addModule[] = "\t\t{";
			$addModule[] = "\t\t\t//".$this->setLine(__LINE__)." set class";
			$addModule[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkString(\$class))";
			$addModule[] = "\t\t\t{";
			$addModule[] = "\t\t\t\t\$class = ' class=\"'.\$class.'\" ';";
			$addModule[] = "\t\t\t}";
			$addModule[] = "\t\t\t//".$this->setLine(__LINE__)." set seperating return values";
			$addModule[] = "\t\t\tswitch(\$seperator)";
			$addModule[] = "\t\t\t{";
			$addModule[] = "\t\t\t\tcase 'none':";
			$addModule[] = "\t\t\t\t\treturn implode('', \$this->setModules[\$position]);";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tcase 'div':";
			$addModule[] = "\t\t\t\t\treturn '<div'.\$class.'>'.implode('</div><div'.\$class.'>', \$this->setModules[\$position]).'</div>';";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tcase 'list':";
			$addModule[] = "\t\t\t\t\treturn '<ul'.\$class.'><li>'.implode('</li><li>', \$this->setModules[\$position]).'</li></ul>';";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tcase 'array':";
			$addModule[] = "\t\t\t\tcase 'Array':";
			$addModule[] = "\t\t\t\t\treturn \$this->setModules[\$position];";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\tdefault:";
			$addModule[] = "\t\t\t\t\treturn implode('<br />', \$this->setModules[\$position]);";
			$addModule[] = "\t\t\t\t\tbreak;";
			$addModule[] = "\t\t\t\t";
			$addModule[] = "\t\t\t}";
			$addModule[] = "\t\t}";
			$addModule[] = "\t\treturn false;";
			$addModule[] = "\t}";
			
			$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GET_MODULE_JIMPORT###'] = PHP_EOL."jimport('joomla.application.module.helper');";
			
			return implode(PHP_EOL,$addModule);
		}	
		$this->fileContentDynamic[$view['settings']->code]['###'.$TARGET.'_GET_MODULE_JIMPORT###'] = '';
		return '';
	}

	public function setCustomGetForm(&$view)
	{
		return '';
	}

	public function setDocumentCustomPHP(&$view)
	{
		if ($view['settings']->add_php_document == 1)
		{
			$view['settings']->php_document = (array) explode(PHP_EOL,$view['settings']->php_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->php_document))
			{
				$_tmp = PHP_EOL."\t\t".implode(PHP_EOL."\t\t",$view['settings']->php_document);
				return $this->setPlaceholders($_tmp, $this->placeholders);
			}
		}
		return '';
	}

	public function setCustomButtons(&$view, $type = 1, $tab = '')
	{
		// ensure correct target is set
		$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
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
			// set the custom buttons ###CUSTOM_BUTTONS_CONTROLLER###
			$this->fileContentDynamic[$viewName]['###'.$TARGET.'_CUSTOM_BUTTONS_CONTROLLER###'] = '';
			// set the custom buttons ###CUSTOM_BUTTONS_METHOD###
			$this->fileContentDynamic[$viewName]['###'.$TARGET.'_CUSTOM_BUTTONS_METHOD###'] = '';
		}
		elseif (3 == $type)
		{
			// set the names
			$viewName = ComponentbuilderHelper::safeString($view['settings']->name_single);
			$viewsName = ComponentbuilderHelper::safeString($view['settings']->name_list);
			// set the custom buttons ###CUSTOM_BUTTONS_CONTROLLER_LIST###
			$this->fileContentDynamic[$viewsName]['###'.$TARGET.'_CUSTOM_BUTTONS_CONTROLLER_LIST###'] = '';
			// set the custom buttons ###CUSTOM_BUTTONS_METHOD_LIST###
			$this->fileContentDynamic[$viewsName]['###'.$TARGET.'_CUSTOM_BUTTONS_METHOD_LIST###'] = '';
		}
		// if site add buttons to view
		if ($this->target === 'site')
		{
			// set the custom buttons ###SITE_TOP_BUTTON###
			$this->fileContentDynamic[$viewName]['###SITE_TOP_BUTTON###'] = '';
			// set the custom buttons ###SITE_BOTTOM_BUTTON###
			$this->fileContentDynamic[$viewName]['###SITE_BOTTOM_BUTTON###'] = '';
			// load into place
			switch ($view['settings']->button_position)
			{
				case 1:
					// set buttons to top right of the view
					$this->fileContentDynamic[$viewName]['###SITE_TOP_BUTTON###'] = '<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>';
					break;
				case 2:
					// set buttons to top left of the view
					$this->fileContentDynamic[$viewName]['###SITE_TOP_BUTTON###'] = '<?php echo $this->toolbar->render(); ?>';
					break;
				case 3:
					// set buttons to buttom right of the view
					$this->fileContentDynamic[$viewName]['###SITE_BOTTOM_BUTTON###'] = '<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>';
					break;
				case 4:
					// set buttons to buttom left of the view
					$this->fileContentDynamic[$viewName]['###SITE_BOTTOM_BUTTON###'] = '<?php echo $this->toolbar->render(); ?>';
					break;
				case 5:
					// set buttons to buttom left of the view
					$this->placeholders['[[[SITE_TOOLBAR]]]'] = '<?php echo $this->toolbar->render(); ?>';
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
					if (3 !== $type && ($custom_button['target'] != 2 || $this->target === 'site'))
					{
						// Load to lang
						$keyLang = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($custom_button['name'],'U');
                                                $keyCode = ComponentbuilderHelper::safeString($custom_button['name']);
						$this->langContent[$this->lang][$keyLang] = trim($custom_button['name']);
						// add cpanel button TODO does not work well on site with permissions
						if ($custom_button['target'] == 2)
						{
							$buttons[] = "\t".$tab."\tif (\$this->user->authorise('".$viewName.".".$keyCode."'))";
						}
						else
						{
							$buttons[] = "\t".$tab."\tif (\$this->canDo->get('".$viewName.".".$keyCode."'))";
						}
						$buttons[] = "\t".$tab."\t{";
						$buttons[] = "\t".$tab."\t\t//".$this->setLine(__LINE__)." add ".$custom_button['name']." button.";
						$buttons[] = "\t".$tab."\t\tJToolBarHelper::custom('".$viewName.".".$custom_button['method']."', '".$custom_button['icomoon']."', '', '".$keyLang."', false);";
						$buttons[] = "\t".$tab."\t}";
					}
					// load the list button
					elseif (3 == $type && $custom_button['target'] != 1)
					{
						// Load to lang
						$keyLang = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($custom_button['name'],'U');
                                                $keyCode = ComponentbuilderHelper::safeString($custom_button['name']);
						$this->langContent[$this->lang][$keyLang] = trim($custom_button['name']);
						// add cpanel button TODO does not work well on site with permissions
						if (isset($custom_button['type']) && $custom_button['type'] == 2)
						{
							if (!isset($this->onlyFunctionButton[$viewsName]))
							{
								$this->onlyFunctionButton[$viewsName] = array();
							}
							$this->onlyFunctionButton[$viewsName][] = "\t".$tab."if (\$this->user->authorise('".$viewName.".".$keyCode."', 'com_".$this->fileContentStatic['###component###']."'))";
							$this->onlyFunctionButton[$viewsName][] = "\t".$tab."{";
							$this->onlyFunctionButton[$viewsName][] = "\t".$tab."\t//".$this->setLine(__LINE__)." add ".$custom_button['name']." button.";
							$this->onlyFunctionButton[$viewsName][] = "\t".$tab."\tJToolBarHelper::custom('".$viewsName.".".$custom_button['method']."', '".$custom_button['icomoon']."', '', '".$keyLang."', false);";
							$this->onlyFunctionButton[$viewsName][] = "\t".$tab."}";
						}
						else
						{
							$buttons[] = "\t".$tab."\tif (\$this->user->authorise('".$viewName.".".$keyCode."', 'com_".$this->fileContentStatic['###component###']."'))";
							$buttons[] = "\t".$tab."\t{";
							$buttons[] = "\t".$tab."\t\t//".$this->setLine(__LINE__)." add ".$custom_button['name']." button.";
							$buttons[] = "\t".$tab."\t\tJToolBarHelper::custom('".$viewsName.".".$custom_button['method']."', '".$custom_button['icomoon']."', '', '".$keyLang."', false);";
							$buttons[] = "\t".$tab."\t}";
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
					// set the custom buttons ###CUSTOM_BUTTONS_CONTROLLER###
					$this->fileContentDynamic[$viewsName]['###'.$TARGET.'_CUSTOM_BUTTONS_CONTROLLER_LIST###'] =
					PHP_EOL.PHP_EOL.$this->setPlaceholders($view['settings']->php_controller_list, $this->placeholders);
				}
				// load the model
				if (isset($view['settings']->php_model_list) && ComponentbuilderHelper::checkString($view['settings']->php_model_list) && $view['settings']->php_model_list != '//')
				{
					// set the custom buttons ###CUSTOM_BUTTONS_METHOD###
					$this->fileContentDynamic[$viewsName]['###'.$TARGET.'_CUSTOM_BUTTONS_METHOD_LIST###'] =
					PHP_EOL.PHP_EOL.$this->setPlaceholders($view['settings']->php_model_list, $this->placeholders);
				}
			}
			else
			{
				// insure the controller and model strings are added
				if (ComponentbuilderHelper::checkString($view['settings']->php_controller) && $view['settings']->php_controller != '//')
				{
					// set the custom buttons ###CUSTOM_BUTTONS_CONTROLLER###
					$this->fileContentDynamic[$viewName]['###'.$TARGET.'_CUSTOM_BUTTONS_CONTROLLER###'] =
					PHP_EOL.PHP_EOL.$this->setPlaceholders($view['settings']->php_controller, $this->placeholders);
					if ('site' === $this->target)
					{
						// add the controller for this view
						// build the file
						$target = array($this->target => $viewName);
						$this->buildDynamique($target,'custom_form');
						###GET_FORM_CUSTOM###
					}
				}
				// load the model
				if (ComponentbuilderHelper::checkString($view['settings']->php_model) && $view['settings']->php_model != '//')
				{
					// set the custom buttons ###CUSTOM_BUTTONS_METHOD###
					$this->fileContentDynamic[$viewName]['###'.$TARGET.'_CUSTOM_BUTTONS_METHOD###'] =
					PHP_EOL.PHP_EOL.$this->setPlaceholders($view['settings']->php_model, $this->placeholders);
				}
			}
			// return buttons if they were build
			if (ComponentbuilderHelper::checkArray($buttons))
			{
				return PHP_EOL.implode(PHP_EOL,$buttons);
			}
		}
		return '';
	}

	public function setFunctionOnlyButtons($viewName_list)
	{
		// return buttons if they were build
		if (isset($this->onlyFunctionButton[$viewName_list]) && ComponentbuilderHelper::checkArray($this->onlyFunctionButton[$viewName_list]))
		{
			return PHP_EOL.implode(PHP_EOL,$this->onlyFunctionButton[$viewName_list]);
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
			$view['settings']->css_document = (array) explode(PHP_EOL,$view['settings']->css_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->css_document))
			{
				$script = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set the Custom CSS script to view".PHP_EOL."\t\t".'$this->document->addStyleDeclaration("';
				$cssDocument = PHP_EOL."\t\t\t".str_replace('"', '\"', implode(PHP_EOL."\t\t\t",$view['settings']->css_document));
				return $script.$this->setPlaceholders($cssDocument, $this->placeholders).PHP_EOL."\t\t".'");';
			}
		}
		return '';
	}

	public function setDocumentCustomJS(&$view)
	{
		if ($view['settings']->add_js_document == 1)
		{
			$view['settings']->js_document = (array) explode(PHP_EOL,$view['settings']->js_document);
			if (ComponentbuilderHelper::checkArray($view['settings']->js_document))
			{
				$script = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set the Custom JS script to view".PHP_EOL."\t\t".'$this->document->addScriptDeclaration("';
				$jsDocument = PHP_EOL."\t\t\t".str_replace('"', '\"', implode(PHP_EOL."\t\t\t",$view['settings']->js_document));
				return $script.$this->setPlaceholders($jsDocument, $this->placeholders).PHP_EOL."\t\t".'");';
			}
		}
		return '';
	}

	public function setFootableScriptsLoader(&$view)
	{
		if (isset($this->footableScripts[$this->target][$view['settings']->code]) && $this->footableScripts[$this->target][$view['settings']->code])
		{
			return $this->setFootableScripts(false,'$this->document');
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
				$searchFor = 'get'.$view['settings']->Code;
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
		$meta[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." load the meta description";
		$meta[] = "\t\tif (isset(\$this->".$item."->metadesc) && \$this->".$item."->metadesc)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setDescription(\$this->".$item."->metadesc);";
		$meta[] = "\t\t}";
		$meta[] = "\t\telseif (\$this->params->get('menu-meta_description'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." load the key words if set";
		$meta[] = "\t\tif (isset(\$this->".$item."->metakey) && \$this->".$item."->metakey)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('keywords', \$this->".$item."->metakey);";
		$meta[] = "\t\t}";
		$meta[] = "\t\telseif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check the robot params";
		$meta[] = "\t\tif (isset(\$this->".$item."->robots) && \$this->".$item."->robots)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('robots', \$this->".$item."->robots);";
		$meta[] = "\t\t}";
		$meta[] = "\t\telseif (\$this->params->get('robots'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check if autor is to be set";
		$meta[] = "\t\tif (isset(\$this->".$item."->created_by) && \$this->params->get('MetaAuthor') == '1')";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetaData('author', \$this->".$item."->created_by);";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check if metadata is available";
		$meta[] = "\t\tif (isset(\$this->".$item."->metadata) && \$this->".$item."->metadata)";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$mdata = json_decode(\$this->".$item."->metadata,true);";
		$meta[] = "\t\t\tforeach (\$mdata as \$k => \$v)";
		$meta[] = "\t\t\t{";
		$meta[] = "\t\t\t\tif (\$v)";
		$meta[] = "\t\t\t\t{";
		$meta[] = "\t\t\t\t\t\$this->document->setMetadata(\$k, \$v);";
		$meta[] = "\t\t\t\t}";
		$meta[] = "\t\t\t}";
		$meta[] = "\t\t}";

		return implode(PHP_EOL,$meta);
	}
	
	public function setMetadataList()
	{
		$meta = array();
		$meta[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." load the meta description";
		$meta[] = "\t\tif (\$this->params->get('menu-meta_description'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." load the key words if set";
		$meta[] = "\t\tif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = "\t\t}";
		$meta[] = "\t\t//".$this->setLine(__LINE__)." check the robot params";
		$meta[] = "\t\tif (\$this->params->get('robots'))";
		$meta[] = "\t\t{";
		$meta[] = "\t\t\t\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = "\t\t}";

		return implode(PHP_EOL,$meta);
	}

	public function setGoogleChartLoader(&$view)
	{
		if (isset($this->googleChart[$this->target][$view['settings']->code]) && $this->googleChart[$this->target][$view['settings']->code])
		{
			$chart = array();
			$chart[] = PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." add the google chart builder class.";
			$chart[] = "\t\trequire_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/chartbuilder.php';";
			$chart[] = "\t\t//".$this->setLine(__LINE__)." load the google chart js.";
			$chart[] = "\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/js/google.jsapi.js');";
			$chart[] = "\t\t\$this->document->addScript('https://canvg.googlecode.com/svn/trunk/rgbcolor.js');";
			$chart[] = "\t\t\$this->document->addScript('https://canvg.googlecode.com/svn/trunk/canvg.js');";
			return implode(PHP_EOL,$chart);
		}
		return '';
	}

	public function setUikitLoader(&$view)
	{
		// reset buktes
		$setter = '';
		$loader['css'] = array();
		$loader['js'] = array();
		// allways load these in
		$setter .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." always make sure jquery is loaded.";
		$setter .= PHP_EOL."\t\tJHtml::_('jquery.framework');";
		$setter .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Load the header checker class.";
		if ($this->target === 'site')
		{
			$setter .= PHP_EOL."\t\trequire_once( JPATH_COMPONENT_SITE.'/helpers/headercheck.php' );";
		}
		else
		{
			$setter .= PHP_EOL."\t\trequire_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/headercheck.php' );";
		}
		$setter .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Initialize the header checker.";
		$setter .= PHP_EOL."\t\t\$HeaderCheck = new ".$this->fileContentStatic['###component###']."HeaderCheck;";
		// load the defaults needed
		if ($this->uikit > 0)
		{
			$setter .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Load uikit options.";
			$setter .= PHP_EOL."\t\t\$uikit = \$this->params->get('uikit_load');";
			$setter .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set script size.";
			$setter .= PHP_EOL."\t\t\$size = \$this->params->get('uikit_min');";
			$tabV = "";
			// if both versions should be loaded then add some more logic
			if (2 == $this->uikit)
			{
				$setter .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Load uikit version.";
				$setter .= PHP_EOL."\t\t\$uikitVersion = \$this->params->get('uikit_version', 2);";
				$setter .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Use Uikit Version 2";
				$setter .= PHP_EOL."\t\tif (2 == \$uikitVersion)";
				$setter .= PHP_EOL."\t\t{";
				$tabV = "\t";
			}
		}
		// load the defaults needed
		if (2 == $this->uikit || 1 == $this->uikit)
		{
			$setter .= PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." Set css style.";
			$setter .= PHP_EOL.$tabV."\t\t\$style = \$this->params->get('uikit_style');";

			$setter .= PHP_EOL.PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." The uikit css.";
			$setter .= PHP_EOL.$tabV."\t\tif ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL.$tabV."\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\$this->document->addStyleSheet(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/uikit'.\$style.\$size.'.css');";
			$setter .= PHP_EOL.$tabV."\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." The uikit js.";
			$setter .= PHP_EOL.$tabV."\t\tif ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL.$tabV."\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/uikit'.\$size.'.js');";
			$setter .= PHP_EOL.$tabV."\t\t}";
		}
		// load the components need
		if ((2 == $this->uikit || 1 == $this->uikit) && isset($this->uikitComp[$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->uikitComp[$view['settings']->code]))
		{
			$setter .= PHP_EOL.PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." Load the script to find all uikit components needed.";
			$setter .= PHP_EOL.$tabV."\t\tif (\$uikit != 2)";
			$setter .= PHP_EOL.$tabV."\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t//".$this->setLine(__LINE__)." Set the default uikit components in this view.";
			$setter .= PHP_EOL.$tabV."\t\t\t\$uikitComp = array();";
			foreach ($this->uikitComp[$view['settings']->code] as $class)
			{
				$setter .= PHP_EOL.$tabV."\t\t\t\$uikitComp[] = '".$class."';";
			}
			// check content for more needed components
			if (isset($this->siteFieldData['uikit'][$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->siteFieldData['uikit'][$view['settings']->code]))
			{
				$setter .= PHP_EOL.PHP_EOL.$tabV."\t\t\t//".$this->setLine(__LINE__)." Get field uikit components needed in this view.";
				$setter .= PHP_EOL.$tabV."\t\t\t\$uikitFieldComp = \$this->get('UikitComp');";
				$setter .= PHP_EOL.$tabV."\t\t\tif (isset(\$uikitFieldComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitFieldComp))";
				$setter .= PHP_EOL.$tabV."\t\t\t{";
				$setter .= PHP_EOL.$tabV."\t\t\t\tif (isset(\$uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitComp))";
				$setter .= PHP_EOL.$tabV."\t\t\t\t{";
				$setter .= PHP_EOL.$tabV."\t\t\t\t\t\$uikitComp = array_merge(\$uikitComp, \$uikitFieldComp);";
				$setter .= PHP_EOL.$tabV."\t\t\t\t\t\$uikitComp = array_unique(\$uikitComp);";
				$setter .= PHP_EOL.$tabV."\t\t\t\t}";
				$setter .= PHP_EOL.$tabV."\t\t\t\telse";
				$setter .= PHP_EOL.$tabV."\t\t\t\t{";
				$setter .= PHP_EOL.$tabV."\t\t\t\t\t\$uikitComp = \$uikitFieldComp;";
				$setter .= PHP_EOL.$tabV."\t\t\t\t}";
				$setter .= PHP_EOL.$tabV."\t\t\t}";
			}
			$setter .= PHP_EOL.$tabV."\t\t}";
			$setter .= PHP_EOL.PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." Load the needed uikit components in this view.";
			$setter .= PHP_EOL.$tabV."\t\tif (\$uikit != 2 && isset(\$uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitComp))";
			$setter .= PHP_EOL.$tabV."\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t//".$this->setLine(__LINE__)." load just in case.";
			$setter .= PHP_EOL.$tabV."\t\t\tjimport('joomla.filesystem.file');";
			$setter .= PHP_EOL.$tabV."\t\t\t//".$this->setLine(__LINE__)." loading...";
			$setter .= PHP_EOL.$tabV."\t\t\tforeach (\$uikitComp as \$class)";
			$setter .= PHP_EOL.$tabV."\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\tforeach (".$this->fileContentStatic['###Component###']."Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL.$tabV."\t\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t//".$this->setLine(__LINE__)." check if the CSS file exists.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the css.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t\$this->document->addStyleSheet(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css');";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t//".$this->setLine(__LINE__)." check if the JavaScript file exists.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the js.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js', 'text/javascript', true);";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t}";
		}
		elseif ((2 == $this->uikit || 1 == $this->uikit) && isset($this->siteFieldData['uikit'][$view['settings']->code]) && ComponentbuilderHelper::checkArray($this->siteFieldData['uikit'][$view['settings']->code]))
		{
			$setter .= PHP_EOL.PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." Load the needed uikit components in this view.";
			$setter .= PHP_EOL.$tabV."\t\t\$uikitComp = \$this->get('UikitComp');";
			$setter .= PHP_EOL.$tabV."\t\tif (\$uikit != 2 && isset(\$uikitComp) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uikitComp))";
			$setter .= PHP_EOL.$tabV."\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t//".$this->setLine(__LINE__)." load just in case.";
			$setter .= PHP_EOL.$tabV."\t\t\tjimport('joomla.filesystem.file');";
			$setter .= PHP_EOL.$tabV."\t\t\t//".$this->setLine(__LINE__)." loading...";
			$setter .= PHP_EOL.$tabV."\t\t\tforeach (\$uikitComp as \$class)";
			$setter .= PHP_EOL.$tabV."\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\tforeach (".$this->fileContentStatic['###Component###']."Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL.$tabV."\t\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t//".$this->setLine(__LINE__)." check if the CSS file exists.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the css.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t\$this->document->addStyleSheet(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/css/components/'.\$name.\$style.\$size.'.css');";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t//".$this->setLine(__LINE__)." check if the JavaScript file exists.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\tif (JFile::exists(JPATH_ROOT.'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t//".$this->setLine(__LINE__)." load the js.";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit/js/components/'.\$name.\$size.'.js', 'text/javascript', true);";
			$setter .= PHP_EOL.$tabV."\t\t\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t}";
		}		
		// now set the version 3	
		if (2 == $this->uikit || 3 == $this->uikit)
		{
			if (2 == $this->uikit)
			{
				$setter .= PHP_EOL."\t\t}";
				$setter .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Use Uikit Version 3";
				$setter .= PHP_EOL."\t\telseif (3 == \$uikitVersion)";
				$setter .= PHP_EOL."\t\t{";
			}
			// add version 3 fiels to page
			$setter .= PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." The uikit css.";
			$setter .= PHP_EOL.$tabV."\t\tif ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL.$tabV."\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\$this->document->addStyleSheet(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit-3/css/uikit'.\$size.'.css');";
			$setter .= PHP_EOL.$tabV."\t\t}";
			$setter .= PHP_EOL.$tabV."\t\t//".$this->setLine(__LINE__)." The uikit js.";
			$setter .= PHP_EOL.$tabV."\t\tif ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL.$tabV."\t\t{";
			$setter .= PHP_EOL.$tabV."\t\t\t\$this->document->addScript(JURI::root(true) .'/media/com_".$this->fileContentStatic['###component###']."/uikit-3/js/uikit'.\$size.'.js');";
			$setter .= PHP_EOL.$tabV."\t\t}";
			if (2 == $this->uikit)
			{
				$setter .= PHP_EOL."\t\t}";
			}
		}
		return $setter;
	}

	public function setCustomViewExtraDisplayMethods(&$view)
	{
		if ($view['settings']->add_php_jview == 1)
		{
			return PHP_EOL.PHP_EOL.$this->setPlaceholders($view['settings']->php_jview, $this->placeholders);
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
				if (strpos($view['settings']->default, '[[[LIMITBOX]]]') !== false)
				{
					$this->placeholders['[[[LIMITBOX]]]'] = '<?php echo $this->pagination->getLimitBox(); ?>';
				}
				$body[] = $this->setPlaceholders($view['settings']->default, $this->placeholders);
				$body[] = PHP_EOL.'<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>';
				$body[] = '<form name="adminForm" method="post">';
				$body[] = "\t".'<div class="pagination">';
				$body[] = "\t\t".'<?php if ($this->params->def(\'show_pagination_results\', 1)) : ?>';
				
				if (strpos($view['settings']->default, '[[[LIMITBOX]]]') === false)
				{
					$body[] = "\t\t\t".'<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>';
				}
				else
				{
					$body[] = "\t\t\t".'<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>';
				}
				$body[] = "\t\t".'<?php endif; ?>';
				$body[] = "\t\t".'<?php echo $this->pagination->getPagesLinks(); ?>';
				$body[] = "\t".'</div>';
				$body[] = '</form>';
				$body[] = '<?php endif; ?>';
				
				return implode(PHP_EOL,$body);
			}
			else
			{
				return PHP_EOL. $this->setPlaceholders($view['settings']->default, $this->placeholders);
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
				$script[] = PHP_EOL."<script type=\"text/javascript\">";
				$script[] = "\tJoomla.submitbutton = function(task) {";
				$script[] = "\t\tif (task === '".$view['settings']->code.".back') {";
				$script[] = "\t\t\tparent.history.back();";
				$script[] = "\t\t\treturn false;";
				$script[] = "\t\t} else {";
				$script[] = "\t\t\tvar form = document.getElementById('adminForm');";
				$script[] = "\t\t\tform.task.value = task;";
				$script[] = "\t\t\tform.submit();";
				$script[] = "\t\t}";
				$script[] = "\t}";
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
			$view['settings']->php_view = (array) explode(PHP_EOL,$view['settings']->php_view);
			if (ComponentbuilderHelper::checkArray($view['settings']->php_view))
			{
				$_tmp = PHP_EOL.PHP_EOL.implode(PHP_EOL,$view['settings']->php_view);
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
				$config = array('###CREATIONDATE###' => $created, '###BUILDDATE###' => $modified,'###VERSION###' => $view['settings']->version);
				$this->buildDynamique($target,'template', $template, $config);
				// set the file data
				$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
				// ###SITE_TEMPLATE_BODY### <<<DYNAMIC>>>
				$this->fileContentDynamic[$view['settings']->code.'_'.$template]['###'.$TARGET.'_TEMPLATE_BODY###'] = PHP_EOL . $this->setPlaceholders($data['html'], $this->placeholders);
				// ###SITE_TEMPLATE_CODE_BODY### <<<DYNAMIC>>>
				$this->fileContentDynamic[$view['settings']->code.'_'.$template]['###'.$TARGET.'_TEMPLATE_CODE_BODY###'] = $this->setCustomViewTemplateCode($data['php_view']);
			}
		}
	}

	public function setCustomViewTemplateCode(&$php)
	{
		if (ComponentbuilderHelper::checkString($php))
		{
			$php_view = (array) explode(PHP_EOL,$php);
			if (ComponentbuilderHelper::checkArray($php_view))
			{
				$php_view = PHP_EOL.PHP_EOL.implode(PHP_EOL,$php_view);
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
				$this->buildDynamique($target,'layout');
				// set the file data
				$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
				// ###SITE_LAYOUT_CODE### <<<DYNAMIC>>>
				$php_view = (array) explode(PHP_EOL,$data['php_view']);
				if (ComponentbuilderHelper::checkArray($php_view))
				{
					$php_view = PHP_EOL.PHP_EOL.implode(PHP_EOL,$php_view);
					$this->fileContentDynamic[$layout]['###'.$TARGET.'_LAYOUT_CODE###'] = $this->setPlaceholders($php_view, $this->placeholders);
				}
				else
				{
					$this->fileContentDynamic[$layout]['###'.$TARGET.'_LAYOUT_CODE###'] = '';
				}
				// ###SITE_LAYOUT_BODY### <<<DYNAMIC>>>
				$this->fileContentDynamic[$layout]['###'.$TARGET.'_LAYOUT_BODY###'] = PHP_EOL . $this->setPlaceholders($data['html'], $this->placeholders);

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
						//var_dump($replacment); echo PHP_EOL;
						$echos[$replacment] = "###".$replacment."###<br />";
					}
					elseif ($type === 'static')
					{
						//var_dump($replacment); echo PHP_EOL;
						$echos[$replacment] = "###".$replacment."###<br />";
					}
				}
			}
		}

		foreach ($echos as $echo)
		{
			echo $echo.'<br />';
		}
	}

	public function writeFile($path, $data)
	{
		return ComponentbuilderHelper::writeFile($path, $data);
	}

	public function setMethodGetItem(&$view)
	{
		$script = '';
		// go from json to array
		if(isset($this->jsonItemBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonItemBuilder[$view]))
		{
			foreach ($this->jsonItemBuilder[$view] as $jsonItem)
			{
				$script .= PHP_EOL.PHP_EOL."\t\t\tif (!empty(\$item->".$jsonItem."))";
				$script .= PHP_EOL."\t\t\t{";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Convert the ".$jsonItem." field to an array.";
				$script .= PHP_EOL."\t\t\t\t\$".$jsonItem." = new Registry;";
				$script .= PHP_EOL."\t\t\t\t\$".$jsonItem."->loadString(\$item->".$jsonItem.");";
				$script .= PHP_EOL."\t\t\t\t\$item->".$jsonItem." = \$".$jsonItem."->toArray();";
				$script .= PHP_EOL."\t\t\t}";
			}
		}
		// go from json to string
		if (isset($this->jsonStringBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonStringBuilder[$view]))
		{
			$makeArray = '';
			foreach ($this->jsonStringBuilder[$view] as $jsonString)
			{
				$script .= PHP_EOL.PHP_EOL."\t\t\tif (!empty(\$item->".$jsonString."))";
				$script .= PHP_EOL."\t\t\t{";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." JSON Decode ".$jsonString.".";
				if (isset($this->jsonItemBuilderArray[$view])
					&& ComponentbuilderHelper::checkArray($this->jsonItemBuilderArray[$view])
					&& in_array($jsonString, $this->jsonItemBuilderArray[$view]))
				{
					$makeArray = ',true';
				}
				elseif (strpos($jsonString, 'group') !== false)
				{
					$makeArray = ',true';
				}
				$script .= PHP_EOL."\t\t\t\t\$item->".$jsonString." = json_decode(\$item->".$jsonString.$makeArray.");";
				$script .= PHP_EOL."\t\t\t}";
			}
		}
		// go from base64 to string
		if (isset($this->base64Builder[$view]) && ComponentbuilderHelper::checkArray($this->base64Builder[$view]))
		{
			foreach ($this->base64Builder[$view] as $baseString)
			{
				$script .= PHP_EOL.PHP_EOL."\t\t\tif (!empty(\$item->".$baseString."))"; // TODO && base64_encode(base64_decode(\$item->".$baseString.", true)) === \$item->".$baseString.")";
				$script .= PHP_EOL."\t\t\t{";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." base64 Decode ".$baseString.".";
				$script .= PHP_EOL."\t\t\t\t\$item->".$baseString." = base64_decode(\$item->".$baseString.");";
				$script .= PHP_EOL."\t\t\t}";
			}
		}
		// decryption
		if ((isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view])) || (isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view])))
		{
			$Component	= $this->fileContentStatic['###Component###'];
			if (isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view]))
			{
				$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get the basic encryption.";
				$script .= PHP_EOL."\t\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get the encryption object.";
				$script .= PHP_EOL."\t\t\t\$basic = new FOFEncryptAes(\$basickey, 128);";
				foreach ($this->basicEncryptionBuilder[$view] as $baseString)
				{
					$script .= PHP_EOL.PHP_EOL."\t\t\tif (!empty(\$item->".$baseString.") && \$basickey && !is_numeric(\$item->".$baseString.") && \$item->".$baseString." === base64_encode(base64_decode(\$item->".$baseString.", true)))";
					$script .= PHP_EOL."\t\t\t{";
					$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." basic decrypt data ".$baseString.".";
					$script .= PHP_EOL."\t\t\t\t\$item->".$baseString." = rtrim(\$basic->decryptString(\$item->".$baseString."), ".'"\0"'.");";
					$script .= PHP_EOL."\t\t\t}";
				}
			}
			if (isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view]))
			{
				$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get the advanced encryption key.";
				$script .= PHP_EOL."\t\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get the encryption object.";
				$script .= PHP_EOL."\t\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
				foreach ($this->advancedEncryptionBuilder[$view] as $baseString)
				{
					$script .= PHP_EOL.PHP_EOL."\t\t\tif (!empty(\$item->".$baseString.") && \$advancedkey && !is_numeric(\$item->".$baseString.") && \$item->".$baseString." === base64_encode(base64_decode(\$item->".$baseString.", true)))";
					$script .= PHP_EOL."\t\t\t{";
					$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." advanced decrypt data ".$baseString.".";
					$script .= PHP_EOL."\t\t\t\t\$item->".$baseString." = rtrim(\$advanced->decryptString(\$item->".$baseString."), ".'"\0"'.");";
					$script .= PHP_EOL."\t\t\t}";
				}
			}
		}

		// add custom php to getitem method
                $script .= $this->getCustomScriptBuilder('php_getitem', $view, PHP_EOL.PHP_EOL);

		return $script;
	}

	public function setCheckboxSave(&$view)
	{
		$script = '';
		if(isset($this->checkboxBuilder[$view]) && ComponentbuilderHelper::checkArray($this->checkboxBuilder[$view]))
		{
			foreach ($this->checkboxBuilder[$view] as $checkbox)
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set the empty ".$checkbox." item to data";
				$script .= PHP_EOL."\t\tif (!isset(\$data['".$checkbox."']))";
				$script .= PHP_EOL."\t\t{";
				$script .= PHP_EOL."\t\t\t\$data['".$checkbox."'] = '';";
				$script .= PHP_EOL."\t\t}";
			}
		}
		return $script;
	}

	public function setMethodItemSave(&$view)
	{
		$script = '';
		// check if there was script added before modeling of data
		$script .= $this->getCustomScriptBuilder('php_before_save', $view, PHP_EOL.PHP_EOL);
		// turn array into JSON string
		if(isset($this->jsonItemBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonItemBuilder[$view]))
		{
			foreach ($this->jsonItemBuilder[$view] as $jsonItem)
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set the ".$jsonItem." items to data.";
				$script .= PHP_EOL."\t\tif (isset(\$data['".$jsonItem."']) && is_array(\$data['".$jsonItem."']))";
				$script .= PHP_EOL."\t\t{";
				$script .= PHP_EOL."\t\t\t\$".$jsonItem." = new JRegistry;";
				$script .= PHP_EOL."\t\t\t\$".$jsonItem."->loadArray(\$data['".$jsonItem."']);";
				$script .= PHP_EOL."\t\t\t\$data['".$jsonItem."'] = (string) \$".$jsonItem.";";
				$script .= PHP_EOL."\t\t}";
				$script .= PHP_EOL."\t\telseif (!isset(\$data['".$jsonItem."']))";
				$script .= PHP_EOL."\t\t{";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Set the empty ".$jsonItem." to data";
				$script .= PHP_EOL."\t\t\t\$data['".$jsonItem."'] = '';";
				$script .= PHP_EOL."\t\t}";
			}
		}
		// turn string into json string
		if(isset($this->jsonStringBuilder[$view]) && ComponentbuilderHelper::checkArray($this->jsonStringBuilder[$view]))
		{
			foreach ($this->jsonStringBuilder[$view] as $jsonString)
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set the ".$jsonString." string to JSON string.";
				$script .= PHP_EOL."\t\tif (isset(\$data['".$jsonString."']))";
				$script .= PHP_EOL."\t\t{";
				$script .= PHP_EOL."\t\t\t\$data['".$jsonString."'] = (string) json_encode(\$data['".$jsonString."']);";
				$script .= PHP_EOL."\t\t}";
			}
		}
		// turn string into base 64 string
		if(isset($this->base64Builder[$view]) && ComponentbuilderHelper::checkArray($this->base64Builder[$view]))
		{
			foreach ($this->base64Builder[$view] as $baseString)
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set the ".$baseString." string to base64 string.";
				$script .= PHP_EOL."\t\tif (isset(\$data['".$baseString."']))";
				$script .= PHP_EOL."\t\t{";
				$script .= PHP_EOL."\t\t\t\$data['".$baseString."'] = base64_encode(\$data['".$baseString."']);";
				$script .= PHP_EOL."\t\t}";
			}
		}
		// turn string into encrypted string
		if((isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view])) || (isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view])))
		{
			$Component	= $this->fileContentStatic['###Component###'];
			if(isset($this->basicEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->basicEncryptionBuilder[$view]))
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the basic encryption key.";
				$script .= PHP_EOL."\t\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the encryption object";
				$script .= PHP_EOL."\t\t\$basic = new FOFEncryptAes(\$basickey, 128);";
				foreach ($this->basicEncryptionBuilder[$view] as $baseString)
				{
					$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Encrypt data ".$baseString.".";
					$script .= PHP_EOL."\t\tif (isset(\$data['".$baseString."']) && \$basickey)";
					$script .= PHP_EOL."\t\t{";
					$script .= PHP_EOL."\t\t\t\$data['".$baseString."'] = \$basic->encryptString(\$data['".$baseString."']);";
					$script .= PHP_EOL."\t\t}";
				}
			}
			if(isset($this->advancedEncryptionBuilder[$view]) && ComponentbuilderHelper::checkArray($this->advancedEncryptionBuilder[$view]))
			{
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the advanced encryption key.";
				$script .= PHP_EOL."\t\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the encryption object";
				$script .= PHP_EOL."\t\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
				foreach ($this->advancedEncryptionBuilder[$view] as $baseString)
				{
					$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Encrypt data ".$baseString.".";
					$script .= PHP_EOL."\t\tif (isset(\$data['".$baseString."']) && \$advancedkey)";
					$script .= PHP_EOL."\t\t{";
					$script .= PHP_EOL."\t\t\t\$data['".$baseString."'] = \$advanced->encryptString(\$data['".$baseString."']);";
					$script .= PHP_EOL."\t\t}";
				}
			}
		}
		// add custom PHP to the save method
                $script .= $this->getCustomScriptBuilder('php_save', $view, PHP_EOL.PHP_EOL);
		return $script;
	}

	public function setJtableConstructor(&$view)
	{
		// reset
		$oserver = "";
		// set component name
		$component	= $this->fileContentStatic['###component###'];
		// add the tags observer
		if (isset($this->tagsBuilder[$view]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$view]))
		{
			$oserver .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Adding Tag Options";
			$oserver .= PHP_EOL."\t\tJTableObserverTags::createObserver(\$this, array('typeAlias' => 'com_".$component.".".$view."'));";
		}
		// add the history/version observer
		if (isset($this->historyBuilder[$view]) && ComponentbuilderHelper::checkString($this->historyBuilder[$view]))
		{
			$oserver .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Adding History Options";
			$oserver .= PHP_EOL."\t\tJTableObserverContenthistory::createObserver(\$this, array('typeAlias' => 'com_".$component.".".$view."'));";
		}
		return $oserver;
	}

	public function setJtableAliasCategory(&$view)
	{
		// only add Observers if both title, alias and category is availabe in view
		if (array_key_exists($view, $this->catCodeBuilder))
		{
			$code = $this->catCodeBuilder[$view]['code'];
			return ", '".$code."' => \$this->".$code;
		}
		return '';
	}
	
	public function setComponentToContentTypes($action)
	{
		$script = '';
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			// set component name
			$component	= $this->fileContentStatic['###component###'];
			// reset
			$dbStuff	= array();
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
					$dbStuff[$view.' category'] = $this->getCategoryContentType($view, $views, $component);
				}
				elseif(!isset($dbStuff[$view]) || !ComponentbuilderHelper::checkArray($dbStuff[$view]))
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
					$taabb = "\t";
				}
				$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get The Database object";
				$script .= PHP_EOL."\t\t\t\$db = JFactory::getDbo();";
				foreach ($dbStuff as $name => $tables)
				{
					if (ComponentbuilderHelper::checkArray($tables))
					{
						$code = ComponentbuilderHelper::safeString($name);
						$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Create the ".$name." content type object.";
						$script .= PHP_EOL."\t\t\t\$".$code." = new stdClass();";						
						foreach ($tables as $table => $data)
						{
							$script .= PHP_EOL."\t\t\t\$".$code."->".$table." = '".$data."';";
						}
						if ($action === 'update')
						{
							// we first load script to check if data exist
							$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Check if ".$name." type is already in content_type DB.";
							$script .= PHP_EOL."\t\t\t\$".$code."_id = null;";
							$script .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
							$script .= PHP_EOL."\t\t\t\$query->select(\$db->quoteName(array('type_id')));";
							$script .= PHP_EOL."\t\t\t\$query->from(\$db->quoteName('#__content_types'));";
							$script .= PHP_EOL."\t\t\t\$query->where(\$db->quoteName('type_alias') . ' LIKE '. \$db->quote($".$code."->type_alias));";
							$script .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
							$script .= PHP_EOL."\t\t\t\$db->execute();";
						}
						$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Set the object into the content types table.";
						if ($action === 'update')
						{
							$script .= PHP_EOL."\t\t\tif (\$db->getNumRows())";
							$script .= PHP_EOL."\t\t\t{";
							$script .= PHP_EOL."\t\t\t\t\$".$code."->type_id = \$db->loadResult();";
							$script .= PHP_EOL."\t\t\t\t\$".$code."_Updated = \$db->updateObject('#__content_types', \$".$code.", 'type_id');";
							$script .= PHP_EOL."\t\t\t}";
							$script .= PHP_EOL."\t\t\telse";
							$script .= PHP_EOL."\t\t\t{";
						}
						$script .= PHP_EOL."\t\t\t".$taabb."\$".$code."_Inserted = \$db->insertObject('#__content_types', \$".$code.");";
						if ($action === 'update')
						{
							$script .= PHP_EOL."\t\t\t}";
						}
					}
				}
				$script .= PHP_EOL.PHP_EOL;
			}
		}
		return $script;
	}

	public function setPostInstallScript()
	{
		// reset script
		$script = $this->setComponentToContentTypes('install');
		
		// set the component name
		$component = $this->fileContentStatic['###component###'];
		
		// add the assets table update for permissions rules
		if (isset($this->assetsRules) && ComponentbuilderHelper::checkArray($this->assetsRules))
		{
			if (ComponentbuilderHelper::checkString($script))
			{
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Install the global extenstion assets permission.";
			}
			else
			{
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Install the global extenstion assets permission.";
				$script .= PHP_EOL."\t\t\t\$db = JFactory::getDbo();";
			}
			$script .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
			$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Field to update.";
			$script .= PHP_EOL."\t\t\t\$fields = array(";
			$script .= PHP_EOL."\t\t\t\t\$db->quoteName('rules') . ' = ' . \$db->quote('{".implode(',', $this->assetsRules)."}'),";
			$script .= PHP_EOL."\t\t\t);";
			$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Condition.";
			$script .= PHP_EOL."\t\t\t\$conditions = array(";
			$script .= PHP_EOL."\t\t\t\t\$db->quoteName('name') . ' = ' . \$db->quote('com_".$component."')";
			$script .= PHP_EOL."\t\t\t);";
			$script .= PHP_EOL."\t\t\t\$query->update(\$db->quoteName('#__assets'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
			$script .= PHP_EOL."\t\t\t\$allDone = \$db->execute();".PHP_EOL;
		}
		// add the global params for the component global settings
		if (isset($this->extensionsParams) && ComponentbuilderHelper::checkArray($this->extensionsParams))
		{
			if (ComponentbuilderHelper::checkString($script))
			{
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Install the global extenstion params.";
			}
			else
			{
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Install the global extenstion params.";
				$script .= PHP_EOL."\t\t\t\$db = JFactory::getDbo();";
			}
			$script .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
			$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Field to update.";
			$script .= PHP_EOL."\t\t\t\$fields = array(";
			$script .= PHP_EOL."\t\t\t\t\$db->quoteName('params') . ' = ' . \$db->quote('{".implode(',', $this->extensionsParams)."}'),";
			$script .= PHP_EOL."\t\t\t);";
			$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Condition.";
			$script .= PHP_EOL."\t\t\t\$conditions = array(";
			$script .= PHP_EOL."\t\t\t\t\$db->quoteName('element') . ' = ' . \$db->quote('com_".$component."')";
			$script .= PHP_EOL."\t\t\t);";
			$script .= PHP_EOL."\t\t\t\$query->update(\$db->quoteName('#__extensions'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
			$script .= PHP_EOL."\t\t\t\$allDone = \$db->execute();".PHP_EOL;
		}
		// add the custom script
		$script .= $this->getCustomScriptBuilder('php_postflight', 'install', PHP_EOL.PHP_EOL, null, true);
		// add the component install notice
		if (ComponentbuilderHelper::checkString($script))
		{
			$script .= PHP_EOL."\t\t\t".'echo \'<a target="_blank" href="'.$this->fileContentStatic['###AUTHORWEBSITE###'].'" title="'.$this->fileContentStatic['###Component_name###'].'">';
			$script .= PHP_EOL."\t\t\t\t".'<img src="components/com_'.$component.'/assets/images/vdm-component.'.$this->componentImageType.'"/>';
			$script .= PHP_EOL."\t\t\t\t".'</a>\';';
			
			return $script;
		}
		return PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." noting to install.";
	}
	
	public function setPostUpdateScript()
	{
		// reset script
		$script = $this->setComponentToContentTypes('update');
		// add the custom script
		$script .= $this->getCustomScriptBuilder('php_postflight', 'update', PHP_EOL.PHP_EOL, null, true);
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$script .= PHP_EOL."\t\t\t".'echo \'<a target="_blank" href="'.$this->fileContentStatic['###AUTHORWEBSITE###'].'" title="'.$this->fileContentStatic['###Component_name###'].'">';
			$script .= PHP_EOL."\t\t\t\t".'<img src="components/com_'.$this->fileContentStatic['###component###'].'/assets/images/vdm-component.'.$this->componentImageType.'"/>';
			$script .= PHP_EOL."\t\t\t\t".'</a>';
			$script .= PHP_EOL."\t\t\t\t<h3>Upgrade to Version ".$this->fileContentStatic['###ACTUALVERSION###']." Was Successful! Let us know if anything is not working as expected.</h3>';";
		}

		if (ComponentbuilderHelper::checkString($script))
		{
			return $script;
		}
		return PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." noting to update.";
	}

	public function setUninstallScript()
	{
		// reset script
		$script = '';
		if (isset($this->uninstallScriptBuilder) && ComponentbuilderHelper::checkArray($this->uninstallScriptBuilder))
		{
			$component = $this->fileContentStatic['###component###'];
			// start loading the data to delet
			$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get Application object";
			$script .= PHP_EOL."\t\t\$app = JFactory::getApplication();";
			$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get The Database object";
			$script .= PHP_EOL."\t\t\$db = JFactory::getDbo();";

			foreach ($this->uninstallScriptBuilder as $viewName => $typeAlias)
			{
				// set a var value
				$view = ComponentbuilderHelper::safeString($viewName);

				// First check if data is till in table
				$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= PHP_EOL."\t\t\$query = \$db->getQuery(true);";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Select id from content type table";
				$script .= PHP_EOL."\t\t\$query->select(\$db->quoteName('type_id'));";
				$script .= PHP_EOL."\t\t\$query->from(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Where ".$viewName." alias is found";
				$script .= PHP_EOL."\t\t\$query->where( \$db->quoteName('type_alias') . ' = '. \$db->quote('".$typeAlias."') );";
				$script .= PHP_EOL."\t\t\$db->setQuery(\$query);";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Execute query to see if alias is found";
				$script .= PHP_EOL."\t\t\$db->execute();";
				$script .= PHP_EOL."\t\t\$".$view."_found = \$db->getNumRows();";
				$script .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Now check if there were any rows";
				$script .= PHP_EOL."\t\tif (\$".$view."_found)";
				$script .= PHP_EOL."\t\t{";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Since there are load the needed  ".$view." type ids";
				$script .= PHP_EOL."\t\t\t\$".$view."_ids = \$db->loadColumn();";

				// Now remove the actual type entry
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." from the content type table";
				$script .= PHP_EOL."\t\t\t\$".$view."_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('".$typeAlias."') );";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
				$script .= PHP_EOL."\t\t\t\$query->delete(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL."\t\t\t\$query->where(\$".$view."_condition);";
				$script .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= PHP_EOL."\t\t\t\$".$view."_done = \$db->execute();";
				$script .= PHP_EOL."\t\t\tif (\$".$view."_done);";
				$script .= PHP_EOL."\t\t\t{";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$viewName." add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL."\t\t\t\t\$app->enqueueMessage(JText::_('The (".$typeAlias.") type alias was removed from the <b>#__content_type</b> table'));";
				$script .= PHP_EOL."\t\t\t}";

				// Now remove the related items from contentitem tag map table
				$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the contentitem tag map table";
				$script .= PHP_EOL."\t\t\t\$".$view."_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('".$typeAlias."') );";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
				$script .= PHP_EOL."\t\t\t\$query->delete(\$db->quoteName('#__contentitem_tag_map'));";
				$script .= PHP_EOL."\t\t\t\$query->where(\$".$view."_condition);";
				$script .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= PHP_EOL."\t\t\t\$".$view."_done = \$db->execute();";
				$script .= PHP_EOL."\t\t\tif (\$".$view."_done);";
				$script .= PHP_EOL."\t\t\t{";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$viewName." add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL."\t\t\t\t\$app->enqueueMessage(JText::_('The (".$typeAlias.") type alias was removed from the <b>#__contentitem_tag_map</b> table'));";
				$script .= PHP_EOL."\t\t\t}";

				// Now remove the related items from ucm content table
				$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the ucm content table";
				$script .= PHP_EOL."\t\t\t\$".$view."_condition = array( \$db->quoteName('core_type_alias') . ' = ' . \$db->quote('".$typeAlias."') );";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
				$script .= PHP_EOL."\t\t\t\$query->delete(\$db->quoteName('#__ucm_content'));";
				$script .= PHP_EOL."\t\t\t\$query->where(\$".$view."_condition);";
				$script .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
				$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= PHP_EOL."\t\t\t\$".$view."_done = \$db->execute();";
				$script .= PHP_EOL."\t\t\tif (\$".$view."_done);";
				$script .= PHP_EOL."\t\t\t{";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$viewName." add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL."\t\t\t\t\$app->enqueueMessage(JText::_('The (".$typeAlias.") type alias was removed from the <b>#__ucm_content</b> table'));";
				$script .= PHP_EOL."\t\t\t}";

				// setup the foreach loop of ids
				$script .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Make sure that all the ".$viewName." items are cleared from DB";
				$script .= PHP_EOL."\t\t\tforeach (\$".$view."_ids as \$".$view."_id)";
				$script .= PHP_EOL."\t\t\t{";

				// Now remove the related items from ucm base table
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the ucm base table";
				$script .= PHP_EOL."\t\t\t\t\$".$view."_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$".$view."_id);";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= PHP_EOL."\t\t\t\t\$query = \$db->getQuery(true);";
				$script .= PHP_EOL."\t\t\t\t\$query->delete(\$db->quoteName('#__ucm_base'));";
				$script .= PHP_EOL."\t\t\t\t\$query->where(\$".$view."_condition);";
				$script .= PHP_EOL."\t\t\t\t\$db->setQuery(\$query);";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= PHP_EOL."\t\t\t\t\$db->execute();";

				// Now remove the related items from ucm history table
				$script .= PHP_EOL.PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Remove ".$viewName." items from the ucm history table";
				$script .= PHP_EOL."\t\t\t\t\$".$view."_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$".$view."_id);";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
				$script .= PHP_EOL."\t\t\t\t\$query = \$db->getQuery(true);";
				$script .= PHP_EOL."\t\t\t\t\$query->delete(\$db->quoteName('#__ucm_history'));";
				$script .= PHP_EOL."\t\t\t\t\$query->where(\$".$view."_condition);";
				$script .= PHP_EOL."\t\t\t\t\$db->setQuery(\$query);";
				$script .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Execute the query to remove ".$viewName." items";
				$script .= PHP_EOL."\t\t\t\t\$db->execute();";

				$script .= PHP_EOL."\t\t\t}";

				$script .= PHP_EOL."\t\t}";
			}

			$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." If All related items was removed queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL."\t\t\$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_base</b> table'));";
			$script .= PHP_EOL."\t\t\$app->enqueueMessage(JText::_('All related items was removed from the <b>#__ucm_history</b> table'));";
			// finaly remove the assets from the assets table
			$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Remove ".$component." assets from the assets table";
			$script .= PHP_EOL."\t\t\$".$component."_condition = array( \$db->quoteName('name') . ' LIKE ' . \$db->quote('com_".$component."%') );";
			$script .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$script .= PHP_EOL."\t\t\$query = \$db->getQuery(true);";
			$script .= PHP_EOL."\t\t\$query->delete(\$db->quoteName('#__assets'));";
			$script .= PHP_EOL."\t\t\$query->where(\$".$component."_condition);";
			$script .= PHP_EOL."\t\t\$db->setQuery(\$query);";
			$script .= PHP_EOL."\t\t\$".$view."_done = \$db->execute();";
			$script .= PHP_EOL."\t\tif (\$".$view."_done);";
			$script .= PHP_EOL."\t\t{";
			$script .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." If succesfully remove ".$component." add queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL."\t\t\t\$app->enqueueMessage(JText::_('All related items was removed from the <b>#__assets</b> table'));";
			$script .= PHP_EOL."\t\t}";
			// done
			$script .= PHP_EOL;
		}
		// add the custom uninstall script
		$script .= $this->getCustomScriptBuilder('php_method', 'uninstall', "", null, true, null, PHP_EOL);
		return $script;
	}

	public function getContentType($view, $component)
	{
		// add if history is to be kept or if tags is added
		if ((isset($this->historyBuilder[$view]) && ComponentbuilderHelper::checkString($this->historyBuilder[$view])) || (isset($this->tagsBuilder[$view]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$view])))
		{
			// reset array
			$array = array();
			// set needed defaults
			$alias			= (array_key_exists($view, $this->aliasBuilder)) ? $this->aliasBuilder[$view] : 'null';
			$title			= (array_key_exists($view, $this->titleBuilder)) ? $this->titleBuilder[$view] : 'null';
			$category		= (array_key_exists($view, $this->catCodeBuilder)) ? $this->catCodeBuilder[$view]['code'] : 'null';
			$categoryHistory	= (array_key_exists($view, $this->catCodeBuilder)) ?
			'{"sourceColumn": "'.$category.'","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},': '';
			$Component		= ComponentbuilderHelper::safeString($component, 'F');
			$View			= ComponentbuilderHelper::safeString($view, 'F');
			$maintext		= (isset($this->maintextBuilder[$view]) && ComponentbuilderHelper::checkString($this->maintextBuilder[$view])) ? $this->maintextBuilder[$view] : 'null';
			$hiddenFields 		= (isset($this->hiddenFieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->hiddenFieldsBuilder[$view])) ? $this->hiddenFieldsBuilder[$view]: '';
			$dynamicfields 		= (isset($this->dynamicfieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->dynamicfieldsBuilder[$view])) ? $this->dynamicfieldsBuilder[$view] : '';
			$intFields 		= (isset($this->intFieldsBuilder[$view]) && ComponentbuilderHelper::checkString($this->intFieldsBuilder[$view])) ? $this->intFieldsBuilder[$view] : '';
			$customfieldlinks	= (isset($this->customFieldLinksBuilder[$view]) && ComponentbuilderHelper::checkString($this->customFieldLinksBuilder[$view])) ? $this->customFieldLinksBuilder[$view] : '';
			// build uninstall script for content types
			$this->uninstallScriptBuilder[$View] = 'com_'.$component.'.'.$view;
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
			$array['type_title'] = $Component.' '.$View;
			// set the alias
			$array['type_alias'] = 'com_'.$component.'.'.$view;
			// set the table
			$array['table'] = '{"special": {"dbtable": "#__'.$component.'_'.$view.'","key": "id","type": "'.$View.'","prefix": "'.$component.'Table","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			// set field map
			$array['field_mappings'] = '{"common": {"core_content_item_id": "id","core_title": "'.$title.'","core_state": "published","core_alias": "'.$alias.'","core_created_time": "created","core_modified_time": "modified","core_body": "'.$maintext.'","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "'.$core_access.'","core_params": "params","core_featured": "null","core_metadata": "'.$core_metadata.'","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "'.$core_metakey.'","core_metadesc": "'.$core_metadesc.'","core_catid": "'.$category.'","core_xreference": "null","asset_id": "asset_id"},"special": {'.$dynamicfields.'}}';
			// set the router class method
			$array['router'] = $Component.'HelperRoute::get'.$View.'Route';
			// set content history
			$array['content_history_options'] = '{"formFile": "administrator/components/com_'.$component.'/models/forms/'.$view.'.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"'.$hiddenFields.'],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering"'.$intFields.'],"displayLookup": ['.$categoryHistory.'{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'.$accessHistory.',{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'.$customfieldlinks.']}';

			return $array;
		}
		return false;
	}

	public function getCategoryContentType($view, $views, $component)
	{
		$category		= $this->catCodeBuilder[$view]['code'];
		$Component		= ComponentbuilderHelper::safeString($component, 'F');
		$View			= ComponentbuilderHelper::safeString($view, 'F');
		// build uninstall script for content types
		$this->uninstallScriptBuilder[$View.' '.$category] = 'com_'.$component.'.'.$views.'.category';
		// set the title
		$array['type_title'] = $Component.' '.$View.' '.ComponentbuilderHelper::safeString($category, 'F');
		// set the alias
		$array['type_alias'] = 'com_'.$component.'.'.$views.'.category';
		// set the table
		$array['table'] = '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
		// set field map
		$array['field_mappings'] = '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';
		// set the router class method
		$array['router'] = $Component.'HelperRoute::getCategoryRoute';
		// set content history
		$array['content_history_options'] = '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';

		return $array;
	}

	public function setRouterHelp($viewName_single, $viewName_list, $front = false)
	{
		// add if tags is added, also for all front item views
		if (((isset($this->tagsBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->tagsBuilder[$viewName_single])) || $front) && (!in_array($viewName_single,$this->setRouterHelpDone)))
		{
			// insure we load a view only once
			$this->setRouterHelpDone[] = $viewName_single;
			// build view route helper
			$View = ComponentbuilderHelper::safeString($viewName_single, 'F');
			$routeHelper = array();
			$routeHelper[] = PHP_EOL.PHP_EOL."\t/**";
			$routeHelper[] = "\t* @param int The route of the ".$View;
			$routeHelper[] = "\t*/";
			if ('category' === $viewName_single || 'categories' === $viewName_single)
			{
				$routeHelper[] = "\tpublic static function get".$View."Route(\$id = 0)";
			}
			else
			{
				$routeHelper[] = "\tpublic static function get".$View."Route(\$id = 0, \$catid = 0)";
			}
			$routeHelper[] = "\t{";
			$routeHelper[] = "\t\tif (\$id > 0)";
			$routeHelper[] = "\t\t{";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)." Initialize the needel array.";
			$routeHelper[] = "\t\t\t\$needles = array(";
			$routeHelper[] = "\t\t\t\t'".$viewName_single."'  => array((int) \$id)";
			$routeHelper[] = "\t\t\t);";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)." Create the link";
			$routeHelper[] = "\t\t\t\$link = 'index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_single."&id='. \$id;";
			$routeHelper[] = "\t\t}";
			$routeHelper[] = "\t\telse";
			$routeHelper[] = "\t\t{";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)." Initialize the needel array.";
			$routeHelper[] = "\t\t\t\$needles = array();";
			$routeHelper[] = "\t\t\t//".$this->setLine(__LINE__)."Create the link but don't add the id.";
			$routeHelper[] = "\t\t\t\$link = 'index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_single."';";
			$routeHelper[] = "\t\t}";			
			if ('category' != $viewName_single && 'categories' != $viewName_single)
			{
				$routeHelper[] = "\t\tif (\$catid > 1)";
				$routeHelper[] = "\t\t{";
				$routeHelper[] = "\t\t\t\$categories = JCategories::getInstance('".$this->fileContentStatic['###component###'].".".$viewName_list."');";
				$routeHelper[] = "\t\t\t\$category = \$categories->get(\$catid);";
				$routeHelper[] = "\t\t\tif (\$category)";
				$routeHelper[] = "\t\t\t{";
				$routeHelper[] = "\t\t\t\t\$needles['category'] = array_reverse(\$category->getPath());";
				$routeHelper[] = "\t\t\t\t\$needles['categories'] = \$needles['category'];";
				$routeHelper[] = "\t\t\t\t\$link .= '&catid='.\$catid;";
				$routeHelper[] = "\t\t\t}";
				$routeHelper[] = "\t\t}";
			}
			if (isset($this->hasMenuGlobal[$viewName_single]))
			{
				$routeHelper[] = PHP_EOL."\t\tif (\$item = self::_findItem(\$needles, '".$viewName_single."'))";
			}
			else
			{				
				$routeHelper[] = PHP_EOL."\t\tif (\$item = self::_findItem(\$needles))";
			}
			$routeHelper[] = "\t\t{";
			$routeHelper[] = "\t\t\t\$link .= '&Itemid='.\$item;";
			$routeHelper[] = "\t\t}";
			$routeHelper[] = PHP_EOL."\t\treturn \$link;";
			$routeHelper[] = "\t}";

			return implode(PHP_EOL,$routeHelper);
		}
		return '';
	}
	
	public function routerParseSwitch(&$view, $viewArray = null, $aliasView = true, $idView = true)
	{
		$isCategory = '';
		$viewTable = false;
		if ($viewArray && ComponentbuilderHelper::checkArray($viewArray))
		{
			if (isset($viewArray['settings']->main_get->db_table_main) && $viewArray['settings']->main_get->db_table_main === 'categories')
			{
				$isCategory = ', true'; // TODO we will keep an eye on this....
			}
//			elseif (isset($viewArray['settings']->main_get->gettype) && $viewArray['settings']->main_get->gettype == 2)
//			{
//				$idView = false; // TODO we will keep an eye on this....
//				$aliasView = false;
//			}
			elseif (isset($viewArray['settings']->main_get->main_get) && ComponentbuilderHelper::checkArray($viewArray['settings']->main_get->main_get))
			{
				foreach ($viewArray['settings']->main_get->main_get as $get)
				{
					if ($get['as'] === 'a')
					{
						if (isset($get['selection']) && ComponentbuilderHelper::checkArray($get['selection'])
							&& isset($get['selection']['select_gets']) 
							&& ComponentbuilderHelper::checkArray($get['selection']['select_gets']))
						{
							if (isset($get['selection']['table']))
							{
								$viewTable = str_replace('#__'.$this->fileContentStatic['###component###'].'_', '', $get['selection']['table']);
							}
						}
						
					}
				}
			}
		}
		// add if tags is added, also for all front item views
		if ($aliasView)
		{
			// build view route switch
			$routerSwitch = array();
			
			$routerSwitch[] = PHP_EOL."\t\t\tcase '".$view."':";
			$routerSwitch[] = "\t\t\t\t\$vars['view'] = '".$view."';";
			$routerSwitch[] = "\t\t\t\tif (is_numeric(\$segments[\$count-1]))";
			$routerSwitch[] = "\t\t\t\t{";
			$routerSwitch[] = "\t\t\t\t\t\$vars['id'] = (int) \$segments[\$count-1];";
			$routerSwitch[] = "\t\t\t\t}";
			$routerSwitch[] = "\t\t\t\telseif (\$segments[\$count-1])";
			$routerSwitch[] = "\t\t\t\t{";
			// we need to get from the table of this views main get the alias so we need the table name
			if ($viewTable)
			{
				$routerSwitch[] = "\t\t\t\t\t\$id = \$this->getVar('".$viewTable."', \$segments[\$count-1], 'alias', 'id'".$isCategory.");";
			}
			else
			{
				$routerSwitch[] = "\t\t\t\t\t\$id = \$this->getVar('".$view."', \$segments[\$count-1], 'alias', 'id'".$isCategory.");";
			}
			$routerSwitch[] = "\t\t\t\t\tif(\$id)";
			$routerSwitch[] = "\t\t\t\t\t{";
			$routerSwitch[] = "\t\t\t\t\t\t\$vars['id'] = \$id;";
			$routerSwitch[] = "\t\t\t\t\t}";
			$routerSwitch[] = "\t\t\t\t}";
			$routerSwitch[] = "\t\t\t\tbreak;";

			return implode(PHP_EOL,$routerSwitch);
		}
		elseif ($idView)
		{
			// build view route switch
			$routerSwitch = array();
			
			$routerSwitch[] = PHP_EOL."\t\t\tcase '".$view."':";
			$routerSwitch[] = "\t\t\t\t\$vars['view'] = '".$view."';";
			$routerSwitch[] = "\t\t\t\tif (is_numeric(\$segments[\$count-1]))";
			$routerSwitch[] = "\t\t\t\t{";
			$routerSwitch[] = "\t\t\t\t\t\$vars['id'] = (int) \$segments[\$count-1];";
			$routerSwitch[] = "\t\t\t\t}";
			$routerSwitch[] = "\t\t\t\tbreak;";

			return implode(PHP_EOL,$routerSwitch);
		}
		else
		{
			// build view route switch
			$routerSwitch = array();
			
			$routerSwitch[] = PHP_EOL."\t\t\tcase '".$view."':";
			$routerSwitch[] = "\t\t\t\t\$vars['view'] = '".$view."';";
			$routerSwitch[] = "\t\t\t\tbreak;";

			return implode(PHP_EOL,$routerSwitch);
		}
		return '';
	}
	
	public function routerBuildViews(&$view)
	{
		if (isset($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']) && ComponentbuilderHelper::checkString($this->fileContentStatic['###ROUTER_BUILD_VIEWS###']))
		{
			return " || \$view === '".$view."'";
		}
		else
		{
			return "\$view === '".$view."'";
		}
	}

	public function setBatchMove($viewName_single)
	{
		// set needed defaults
		$title			= false;
		$alias			= false;
		$category		= false;
		$batchmove		= array();
		$VIEW			= ComponentbuilderHelper::safeString($viewName_single, 'U');
		// component helper name
		$Helper = $this->fileContentStatic['###Component###'].'Helper';
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
			$category		= $this->catCodeBuilder[$viewName_single]['code'];
		}
		// only load alias if set in this view
		if (array_key_exists($viewName_single, $this->aliasBuilder))
		{
			$alias		= $this->aliasBuilder[$viewName_single];
		}
		// only load title if set in this view
		if (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$title 		= $this->titleBuilder[$viewName_single];
		}
		// prepare custom script
                $customScript = $this->getCustomScriptBuilder('php_batchmove', $viewName_single, PHP_EOL.PHP_EOL, null, true);

		$batchmove[] = PHP_EOL."\t/**";
		$batchmove[] = "\t * Batch move items to a new category";
		$batchmove[] = "\t *";
		$batchmove[] = "\t * @param   integer  \$value     The new category ID.";
		$batchmove[] = "\t * @param   array    \$pks       An array of row IDs.";
		$batchmove[] = "\t * @param   array    \$contexts  An array of item contexts.";
		$batchmove[] = "\t *";
		$batchmove[] = "\t * @return  boolean  True if successful, false otherwise and internal error is set.";
		$batchmove[] = "\t *";
		$batchmove[] = "\t * @since\t12.2";
		$batchmove[] = "\t */";
		$batchmove[] = "\tprotected function batchMove(\$values, \$pks, \$contexts)";
		$batchmove[] = "\t{";
		$batchmove[] = "\t\tif (empty(\$this->batchSet))";
		$batchmove[] = "\t\t{";
		$batchmove[] = "\t\t\t//".$this->setLine(__LINE__)." Set some needed variables.";
		$batchmove[] = "\t\t\t\$this->user		= JFactory::getUser();";
		$batchmove[] = "\t\t\t\$this->table		= \$this->getTable();";
		$batchmove[] = "\t\t\t\$this->tableClassName	= get_class(\$this->table);";
		$batchmove[] = "\t\t\t\$this->contentType	= new JUcmType;";
		$batchmove[] = "\t\t\t\$this->type		= \$this->contentType->getTypeByTable(\$this->tableClassName);";
		$batchmove[] = "\t\t\t\$this->canDo		= ".$Helper."::getActions('".$viewName_single."');";
		$batchmove[] = "\t\t}";

		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
		{
			$batchmove[] = PHP_EOL."\t\tif (!\$this->canDo->get('".$core['core.edit']."') && !\$this->canDo->get('".$core['core.batch']."'))";
		}
		else
		{
			$batchmove[] = PHP_EOL."\t\tif (!\$this->canDo->get('core.edit') && !\$this->canDo->get('core.batch'))";
		}
		$batchmove[] = "\t\t{";
		$batchmove[] = "\t\t\t\$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";
		$batchmove[] = "\t\t\treturn false;";
		$batchmove[] = "\t\t}".$customScript;

		$batchmove[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." make sure published only updates if user has the permission.";
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$batchmove[] = "\t\tif (isset(\$values['published']) && !\$this->canDo->get('".$core['core.edit.state']."'))";
		}
		else
		{
			$batchmove[] = "\t\tif (isset(\$values['published']) && !\$this->canDo->get('core.edit.state'))";
		}
		$batchmove[] = "\t\t{";
		$batchmove[] = "\t\t\tunset(\$values['published']);";
		$batchmove[] = "\t\t}";

		$batchmove[] = "\t\t//".$this->setLine(__LINE__)." remove move_copy from array";
		$batchmove[] = "\t\tunset(\$values['move_copy']);";

		if ($category)
		{
			$batchmove[] = PHP_EOL."\t\tif (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchmove[] = "\t\t{";
			$batchmove[] = "\t\t\treturn false;";
			$batchmove[] = "\t\t}";
			$batchmove[] = "\t\telseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchmove[] = "\t\t{";
			$batchmove[] = "\t\t\t//".$this->setLine(__LINE__)." move the category value to correct field name";
			$batchmove[] = "\t\t\t\$values['".$category."'] = \$values['category'];";
			$batchmove[] = "\t\t\tunset(\$values['category']);";
			$batchmove[] = "\t\t}";
			$batchmove[] = "\t\telseif (isset(\$values['category']))";
			$batchmove[] = "\t\t{";
			$batchmove[] = "\t\t\tunset(\$values['category']);";
			$batchmove[] = "\t\t}".PHP_EOL;
		}

		$batchmove[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Parent exists so we proceed";
		$batchmove[] = "\t\tforeach (\$pks as \$pk)";
		$batchmove[] = "\t\t{";
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
		{
			$batchmove[] = "\t\t\tif (!\$this->user->authorise('".$core['core.edit']."', \$contexts[\$pk]))";
		}
		else
		{
			$batchmove[] = "\t\t\tif (!\$this->user->authorise('core.edit', \$contexts[\$pk]))";
		}
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->setError(JText::_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";

		$batchmove[] = PHP_EOL."\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Check that the row actually exists";
		$batchmove[] = "\t\t\tif (!\$this->table->load(\$pk))";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\tif (\$error = \$this->table->getError())";
		$batchmove[] = "\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Fatal error";
		$batchmove[] = "\t\t\t\t\t\$this->setError(\$error);";

		$batchmove[] = PHP_EOL."\t\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t\t}";
		$batchmove[] = "\t\t\t\telse";
		$batchmove[] = "\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Not fatal error";
		$batchmove[] = "\t\t\t\t\t\$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchmove[] = "\t\t\t\t\tcontinue;";
		$batchmove[] = "\t\t\t\t}";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." insert all set values.";
		$batchmove[] = "\t\t\tif (".$Helper."::checkArray(\$values))";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\tforeach (\$values as \$key => \$value)";
		$batchmove[] = "\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Do special action for access.";
		$batchmove[] = "\t\t\t\t\tif ('access' === \$key && strlen(\$value) > 0)";
		$batchmove[] = "\t\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t\t\$this->table->\$key = \$value;";
		$batchmove[] = "\t\t\t\t\t}";
		$batchmove[] = "\t\t\t\t\telseif (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchmove[] = "\t\t\t\t\t{";
		$batchmove[] = "\t\t\t\t\t\t\$this->table->\$key = \$value;";
		$batchmove[] = "\t\t\t\t\t}";
		$batchmove[] = "\t\t\t\t}";
		$batchmove[] = "\t\t\t}".PHP_EOL;

		$batchmove[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Check the row.";
		$batchmove[] = "\t\t\tif (!\$this->table->check())";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchmove[] = PHP_EOL."\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = PHP_EOL."\t\t\tif (!empty(\$this->type))";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchmove[] = "\t\t\t}";

		$batchmove[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Store the row.";
		$batchmove[] = "\t\t\tif (!\$this->table->store())";
		$batchmove[] = "\t\t\t{";
		$batchmove[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchmove[] = PHP_EOL."\t\t\t\treturn false;";
		$batchmove[] = "\t\t\t}";
		$batchmove[] = "\t\t}";

		$batchmove[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Clean the cache";
		$batchmove[] = "\t\t\$this->cleanCache();";

		$batchmove[] = PHP_EOL."\t\treturn true;";
		$batchmove[] = "\t}";

		return PHP_EOL.implode(PHP_EOL,$batchmove);
	}

	public function setBatchCopy($viewName_single)
	{
		// set needed defaults
		$title			= false;
		$alias			= false;
		$category		= false;
		$batchcopy		= array();
		$VIEW			= ComponentbuilderHelper::safeString($viewName_single, 'U');
		// component helper name
		$Helper = $this->fileContentStatic['###Component###'].'Helper';
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
		if (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$title = $this->titleBuilder[$viewName_single];
		}
		// prepare custom script
                $customScript = $this->getCustomScriptBuilder('php_batchcopy', $viewName_single, PHP_EOL.PHP_EOL, null, true);

		$batchcopy[] = PHP_EOL."\t/**";
		$batchcopy[] = "\t * Batch copy items to a new category or current.";
		$batchcopy[] = "\t *";
		$batchcopy[] = "\t * @param   integer  \$values    The new values.";
		$batchcopy[] = "\t * @param   array    \$pks       An array of row IDs.";
		$batchcopy[] = "\t * @param   array    \$contexts  An array of item contexts.";
		$batchcopy[] = "\t *";
		$batchcopy[] = "\t * @return  mixed  An array of new IDs on success, boolean false on failure.";
		$batchcopy[] = "\t *";
		$batchcopy[] = "\t * @since\t12.2";
		$batchcopy[] = "\t */";
		$batchcopy[] = "\tprotected function batchCopy(\$values, \$pks, \$contexts)";
		$batchcopy[] = "\t{";

		$batchcopy[] = "\t\tif (empty(\$this->batchSet))";
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." Set some needed variables.";
		$batchcopy[] = "\t\t\t\$this->user 		= JFactory::getUser();";
		$batchcopy[] = "\t\t\t\$this->table 		= \$this->getTable();";
		$batchcopy[] = "\t\t\t\$this->tableClassName	= get_class(\$this->table);";
		$batchcopy[] = "\t\t\t\$this->contentType	= new JUcmType;";
		$batchcopy[] = "\t\t\t\$this->type		= \$this->contentType->getTypeByTable(\$this->tableClassName);";
		$batchcopy[] = "\t\t\t\$this->canDo		= ".$Helper."::getActions('".$viewName_single."');";
		$batchcopy[] = "\t\t}";
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
		{
			$batchcopy[] = PHP_EOL."\t\tif (!\$this->canDo->get('".$core['core.create']."') && !\$this->canDo->get('".$core['core.batch']."'))";
		}
		else
		{
			$batchcopy[] = PHP_EOL."\t\tif (!\$this->canDo->get('core.create') || !\$this->canDo->get('core.batch'))";
		}
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\treturn false;";
		$batchcopy[] = "\t\t}".$customScript;

		$batchcopy[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." get list of uniqe fields";
		$batchcopy[] = "\t\t\$uniqeFields = \$this->getUniqeFields();";
		$batchcopy[] = "\t\t//".$this->setLine(__LINE__)." remove move_copy from array";
		$batchcopy[] = "\t\tunset(\$values['move_copy']);";

		$batchcopy[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." make sure published is set";
		$batchcopy[] = "\t\tif (!isset(\$values['published']))";
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t\$values['published'] = 0;";
		$batchcopy[] = "\t\t}";
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$batchcopy[] = "\t\telseif (isset(\$values['published']) && !\$this->canDo->get('".$core['core.edit.state']."'))";
		}
		else
		{
			$batchcopy[] = "\t\telseif (isset(\$values['published']) && !\$this->canDo->get('core.edit.state'))";
		}
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t\t\$values['published'] = 0;";
		$batchcopy[] = "\t\t}";

		if ($category)
		{
			$batchcopy[] = PHP_EOL."\t\tif (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchcopy[] = "\t\t{";
			$batchcopy[] = "\t\t\treturn false;";
			$batchcopy[] = "\t\t}";
			$batchcopy[] = "\t\telseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchcopy[] = "\t\t{";
			$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." move the category value to correct field name";
			$batchcopy[] = "\t\t\t\$values['".$category."'] = \$values['category'];";
			$batchcopy[] = "\t\t\tunset(\$values['category']);";
			$batchcopy[] = "\t\t}";
			$batchcopy[] = "\t\telseif (isset(\$values['category']))";
			$batchcopy[] = "\t\t{";
			$batchcopy[] = "\t\t\tunset(\$values['category']);";
			$batchcopy[] = "\t\t}";
		}

		$batchcopy[] = PHP_EOL."\t\t\$newIds = array();";

		$batchcopy[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Parent exists so let's proceed";
		$batchcopy[] = "\t\twhile (!empty(\$pks))";
		$batchcopy[] = "\t\t{";
		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." Pop the first ID off the stack";
		$batchcopy[] = "\t\t\t\$pk = array_shift(\$pks);";

		$batchcopy[] = PHP_EOL."\t\t\t\$this->table->reset();";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." only allow copy if user may edit this item.";
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
		{
			$batchcopy[] = PHP_EOL."\t\t\tif (!\$this->user->authorise('".$core['core.edit']."', \$contexts[\$pk]))";
		}
		else
		{
			$batchcopy[] = PHP_EOL."\t\t\tif (!\$this->user->authorise('core.edit', \$contexts[\$pk]))";
		}
		$batchcopy[] = PHP_EOL."\t\t\t{";
		$batchcopy[] = PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Not fatal error";
		$batchcopy[] = PHP_EOL."\t\t\t\t\$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = PHP_EOL."\t\t\t\tcontinue;";
		$batchcopy[] = PHP_EOL."\t\t\t}";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Check that the row actually exists";
		$batchcopy[] = "\t\t\tif (!\$this->table->load(\$pk))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\tif (\$error = \$this->table->getError())";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Fatal error";
		$batchcopy[] = "\t\t\t\t\t\$this->setError(\$error);";

		$batchcopy[] = PHP_EOL."\t\t\t\t\treturn false;";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t\telse";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Not fatal error";
		$batchcopy[] = "\t\t\t\t\t\$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = "\t\t\t\t\tcontinue;";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t}";
		if ($category && $alias === 'alias' && $title === 'title')
		{
			$batchcopy[] = PHP_EOL."\t\t\tif (isset(\$values['".$category."']))";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tstatic::generateTitle((int) \$values['".$category."'], \$this->table);";
			$batchcopy[] = "\t\t\t}";
			$batchcopy[] = "\t\t\telse";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tstatic::generateTitle((int) \$this->table->".$category.", \$this->table);";
			$batchcopy[] = "\t\t\t}";
		}
		elseif ($category && $alias && $title)
		{
			$batchcopy[] = PHP_EOL."\t\t\tif (isset(\$values['".$category."']))";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tlist(\$this->table->".$title.", \$this->table->".$alias.") = \$this->generateNewTitle(\$values['".$category."'], \$this->table->".$alias.", \$this->table->".$title.");";
			$batchcopy[] = "\t\t\t}";
			$batchcopy[] = "\t\t\telse";
			$batchcopy[] = "\t\t\t{";
			$batchcopy[] = "\t\t\t\tlist(\$this->table->".$title.", \$this->table->".$alias.") = \$this->generateNewTitle(\$this->table->".$category.", \$this->table->".$alias.", \$this->table->".$title.");";
			$batchcopy[] = "\t\t\t}";
		}
		elseif (!$category && $alias && $title)
		{
			$batchcopy[] = PHP_EOL."\t\t\tlist(\$this->table->".$title.", \$this->table->".$alias.") = \$this->_generateNewTitle(\$this->table->".$alias.", \$this->table->".$title.");";
		}
		elseif (!$category && !$alias && $title && $title != 'user' && $title != 'jobnumber') // TODO [jobnumber] just for one project (not ideal)
		{
			$batchcopy[] = PHP_EOL."\t\t\t\$this->table->".$title." = \$this->generateUniqe('".$title."',\$this->table->".$title.");";
		}

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." insert all set values";
		$batchcopy[] = "\t\t\tif (".$Helper."::checkArray(\$values))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\tforeach (\$values as \$key => \$value)";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\tif (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchcopy[] = "\t\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t\t\$this->table->\$key = \$value;";
		$batchcopy[] = "\t\t\t\t\t}";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t}".PHP_EOL;

		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." update all uniqe fields";
		$batchcopy[] = "\t\t\tif (".$Helper."::checkArray(\$uniqeFields))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\tforeach (\$uniqeFields as \$uniqeField)";
		$batchcopy[] = "\t\t\t\t{";
		$batchcopy[] = "\t\t\t\t\t\$this->table->\$uniqeField = \$this->generateUniqe(\$uniqeField,\$this->table->\$uniqeField);";
		$batchcopy[] = "\t\t\t\t}";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Reset the ID because we are making a copy";
		$batchcopy[] = "\t\t\t\$this->table->id = 0;";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." TODO: Deal with ordering?";
		$batchcopy[] = "\t\t\t//".$this->setLine(__LINE__)." \$this->table->ordering\t= 1;";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Check the row.";
		$batchcopy[] = "\t\t\tif (!\$this->table->check())";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchcopy[] = PHP_EOL."\t\t\t\treturn false;";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = PHP_EOL."\t\t\tif (!empty(\$this->type))";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\t\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Store the row.";
		$batchcopy[] = "\t\t\tif (!\$this->table->store())";
		$batchcopy[] = "\t\t\t{";
		$batchcopy[] = "\t\t\t\t\$this->setError(\$this->table->getError());";

		$batchcopy[] = PHP_EOL."\t\t\t\treturn false;";
		$batchcopy[] = "\t\t\t}";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get the new item ID";
		$batchcopy[] = "\t\t\t\$newId = \$this->table->get('id');";

		$batchcopy[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Add the new ID to the array";
		$batchcopy[] = "\t\t\t\$newIds[\$pk] = \$newId;";
		$batchcopy[] = "\t\t}";

		$batchcopy[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Clean the cache";
		$batchcopy[] = "\t\t\$this->cleanCache();";

		$batchcopy[] = PHP_EOL."\t\treturn \$newIds;";
		$batchcopy[] = "\t}";

		return PHP_EOL.implode(PHP_EOL,$batchcopy);
	}

	public function setAliasTitleFix($viewName_single)
	{
		$fixUniqe = array();
		// only load this if these two items are set
		if (array_key_exists($viewName_single, $this->aliasBuilder) && array_key_exists($viewName_single, $this->titleBuilder))
		{
			// set needed defaults
			$setCategory	= false;
			$alias			= $this->aliasBuilder[$viewName_single];
			$title			= $this->titleBuilder[$viewName_single];
			$VIEW			= ComponentbuilderHelper::safeString($viewName_single, 'U');
			if (array_key_exists($viewName_single, $this->catCodeBuilder))
			{
				$category		= $this->catCodeBuilder[$viewName_single]['code'];
				$setCategory	= true;
			}
			// start building the fix
			$fixUniqe[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Alter the ".$title." for save as copy";
			$fixUniqe[] = "\t\tif (\$input->get('task') === 'save2copy')";
			$fixUniqe[] = "\t\t{";
			$fixUniqe[] = "\t\t\t\$origTable = clone \$this->getTable();";
			$fixUniqe[] = "\t\t\t\$origTable->load(\$input->getInt('id'));";
			$fixUniqe[] = PHP_EOL."\t\t\tif (\$data['".$title."'] == \$origTable->".$title.")";
			$fixUniqe[] = "\t\t\t{";
			if ($setCategory)
			{
				$fixUniqe[] = "\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->generateNewTitle(\$data['".$category."'], \$data['".$alias."'], \$data['".$title."']);";
			}
			else
			{
				$fixUniqe[] = "\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->_generateNewTitle(\$data['".$alias."'], \$data['".$title."']);";
			}
			$fixUniqe[] = "\t\t\t\t\$data['".$title."'] = \$".$title.";";
			$fixUniqe[] = "\t\t\t\t\$data['".$alias."'] = \$".$alias.";";
			$fixUniqe[] = "\t\t\t}";
			$fixUniqe[] = "\t\t\telse";
			$fixUniqe[] = "\t\t\t{";
			$fixUniqe[] = "\t\t\t\tif (\$data['".$alias."'] == \$origTable->".$alias.")";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\t\$data['".$alias."'] = '';";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = "\t\t\t}";
			$fixUniqe[] = PHP_EOL."\t\t\t\$data['published'] = 0;";
			$fixUniqe[] = "\t\t}";
			$fixUniqe[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Automatic handling of ".$alias." for empty fields";
			$fixUniqe[] = "\t\tif (in_array(\$input->get('task'), array('apply', 'save', 'save2new')) && (int) \$input->get('id') == 0)";
			$fixUniqe[] = "\t\t{";
			$fixUniqe[] = "\t\t\tif (\$data['".$alias."'] == null)";
			$fixUniqe[] = "\t\t\t{";
			$fixUniqe[] = "\t\t\t\tif (JFactory::getConfig()->get('unicodeslugs') == 1)";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\t\$data['".$alias."'] = JFilterOutput::stringURLUnicodeSlug(\$data['".$title."']);";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = "\t\t\t\telse";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\t\$data['".$alias."'] = JFilterOutput::stringURLSafe(\$data['".$title."']);";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = PHP_EOL."\t\t\t\t\$table = JTable::getInstance('".$viewName_single."', '".$this->fileContentStatic['###component###']."Table');";
			if ($setCategory)
			{
				$fixUniqe[] = PHP_EOL."\t\t\t\tif (\$table->load(array('".$alias."' => \$data['".$alias."'], '".$category."' => \$data['".$category."'])) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUniqe[] = "\t\t\t\t{";
				$fixUniqe[] = "\t\t\t\t\t\$msg = JText::_('COM_".$this->fileContentStatic['###COMPONENT###']."_".$VIEW."_SAVE_WARNING');";
				$fixUniqe[] = "\t\t\t\t}";
				$fixUniqe[] = PHP_EOL."\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->generateNewTitle(\$data['".$category."'], \$data['".$alias."'], \$data['".$title."']);";
			}
			else
			{
				$fixUniqe[] = PHP_EOL."\t\t\t\tif (\$table->load(array('".$alias."' => \$data['".$alias."'])) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUniqe[] = "\t\t\t\t{";
				$fixUniqe[] = "\t\t\t\t\t\$msg = JText::_('COM_".$this->fileContentStatic['###COMPONENT###']."_".$VIEW."_SAVE_WARNING');";
				$fixUniqe[] = "\t\t\t\t}";
				$fixUniqe[] = PHP_EOL."\t\t\t\tlist(\$".$title.", \$".$alias.") = \$this->_generateNewTitle(\$data['".$alias."'], \$data['".$title."']);";
			}
			$fixUniqe[] = "\t\t\t\t\$data['".$alias."'] = \$".$alias.";";
			$fixUniqe[] = PHP_EOL."\t\t\t\tif (isset(\$msg))";
			$fixUniqe[] = "\t\t\t\t{";
			$fixUniqe[] = "\t\t\t\t\tJFactory::getApplication()->enqueueMessage(\$msg, 'warning');";
			$fixUniqe[] = "\t\t\t\t}";
			$fixUniqe[] = "\t\t\t}";
			$fixUniqe[] = "\t\t}";
		}
		// handel other uniqe fields
		$fixUniqe[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Alter the uniqe field for save as copy";
		$fixUniqe[] = "\t\tif (\$input->get('task') === 'save2copy')";
		$fixUniqe[] = "\t\t{";
		$fixUniqe[] = "\t\t\t//".$this->setLine(__LINE__)." Automatic handling of other uniqe fields";
		$fixUniqe[] = "\t\t\t\$uniqeFields = \$this->getUniqeFields();";
		$fixUniqe[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$uniqeFields))";
		$fixUniqe[] = "\t\t\t{";
		$fixUniqe[] = "\t\t\t\tforeach (\$uniqeFields as \$uniqeField)";
		$fixUniqe[] = "\t\t\t\t{";
		$fixUniqe[] = "\t\t\t\t\t\$data[\$uniqeField] = \$this->generateUniqe(\$uniqeField,\$data[\$uniqeField]);";
		$fixUniqe[] = "\t\t\t\t}";
		$fixUniqe[] = "\t\t\t}";
		$fixUniqe[] = "\t\t}";

		return PHP_EOL.implode(PHP_EOL,$fixUniqe);
	}

	public function setGenerateNewTitle($viewName_single)
	{
		// if category is added to this view then do nothing
		if (array_key_exists($viewName_single, $this->aliasBuilder) && array_key_exists($viewName_single, $this->titleBuilder))
		{
			$newFunction = array();
			$newFunction[] = PHP_EOL.PHP_EOL."\t/**";
			$newFunction[] = "\t* Method to change the title & alias.";
			$newFunction[] = "\t*";
			$newFunction[] = "\t* @param   string   \$alias        The alias.";
			$newFunction[] = "\t* @param   string   \$title        The title.";
	 		$newFunction[] = "\t*";
	 		$newFunction[] = "\t* @return	array  Contains the modified title and alias.";
	 		$newFunction[] = "\t*";
			$newFunction[] = "\t*/";
			$newFunction[] = "\tprotected function _generateNewTitle(\$alias, \$title)";
			$newFunction[] = "\t{";
			$newFunction[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Alter the title & alias";
			$newFunction[] = "\t\t\$table = \$this->getTable();";
			$newFunction[] = PHP_EOL."\t\twhile (\$table->load(array('alias' => \$alias)))";
			$newFunction[] = "\t\t{";
			$newFunction[] = "\t\t\t\$title = JString::increment(\$title);";
			$newFunction[] = "\t\t\t\$alias = JString::increment(\$alias, 'dash');";
			$newFunction[] = "\t\t}";
			$newFunction[] = PHP_EOL."\t\treturn array(\$title, \$alias);";
			$newFunction[] = "\t}";
			return implode(PHP_EOL,$newFunction);
		}
		elseif (array_key_exists($viewName_single, $this->titleBuilder))
		{
			$newFunction = array();
			$newFunction[] = PHP_EOL.PHP_EOL."\t/**";
			$newFunction[] = "\t* Method to change the title & alias.";
			$newFunction[] = "\t*";
			$newFunction[] = "\t* @param   string   \$title        The title.";
	 		$newFunction[] = "\t*";
	 		$newFunction[] = "\t* @return	array  Contains the modified title and alias.";
	 		$newFunction[] = "\t*";
			$newFunction[] = "\t*/";
			$newFunction[] = "\tprotected function _generateNewTitle(\$title)";
			$newFunction[] = "\t{";
			$newFunction[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Alter the title";
			$newFunction[] = "\t\t\$table = \$this->getTable();";
			$newFunction[] = PHP_EOL."\t\twhile (\$table->load(array('title' => \$title)))";
			$newFunction[] = "\t\t{";
			$newFunction[] = "\t\t\t\$title = JString::increment(\$title);";
			$newFunction[] = "\t\t}";
			$newFunction[] = PHP_EOL."\t\treturn \$title;";
			$newFunction[] = "\t}";
			return implode(PHP_EOL,$newFunction);
		}
		return '';
	}

	public function setInstall()
	{
		if (isset($this->queryBuilder) && ComponentbuilderHelper::checkArray($this->queryBuilder))
		{
			// set the main db prefix
			$component = $this->fileContentStatic['###component###'];
			// start building the db

			$db = '';
			foreach ($this->queryBuilder as $view => $fields)
			{
				// build the uninstall array
				$this->uninstallBuilder[] = "DROP TABLE IF EXISTS `#__".$component."_".$view."`;";

				// setup the table DB string
				$db_ = '';
				$db_ .= "CREATE TABLE IF NOT EXISTS `#__".$component."_".$view."` (";
				// check if the table name has changed
				if (isset($this->updateSQL['table_name']) && isset($this->updateSQL['table_name'][$view]))
				{
					$old_table_name = $this->updateSQL['table_name'][$view]['old'];
					$this->updateSQLBuilder["RENAMETABLE`#__".$component."_".$old_table_name."`"] 
						= "RENAME TABLE `#__".$component."_".$old_table_name."` to `#__".$component."_".$view."`;";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['id']))
				{
					$db_ .= PHP_EOL."\t`id` INT(11) NOT NULL AUTO_INCREMENT,";
				}
				$db_ .= PHP_EOL."\t`asset_id` INT(10) unsigned NOT NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',";
				ksort($fields);
				$last_name = 'asset_id';
				foreach ($fields as $field => $data)
				{
					// set default
					$default = $data['default'];
					if ( $default === 'Other' )
					{
						$default = $data['other'];
					}
					if ($default === 'EMPTY')
					{
						$default = $data['null_switch'];
					}
					elseif ($default === 'DATETIME' || $default === 'CURRENT_TIMESTAMP')
					{
						$default =  $default.' '.$data['null_switch'];
					}
					elseif ($default == 0 || $default)
					{
						if (is_numeric($default))
						{
							$default = $data['null_switch']." DEFAULT ".$default;
						}
						else
						{
							$default = $data['null_switch']." DEFAULT '".$default."'";
						}
					}
					elseif ($data['null_switch'] === 'NULL')
					{
						$default = "DEFAULT NULL";
					}
					else
					{
						$default = $data['null_switch']." DEFAULT ''";
					}
					// set the lenght
					$lenght = '';
					if (isset($data['lenght']) && $data['lenght'] === 'Other' && isset($data['lenght_other']) && $data['lenght_other'] > 0)
					{
						$lenght = '('.$data['lenght_other'].')';
					}
					elseif (isset($data['lenght']) && $data['lenght'] > 0)
					{
						$lenght = '('.$data['lenght'].')';
					}
					// set the field to db
					$db_ .= PHP_EOL."\t`".$field."` ".$data['type'].$lenght." ".$default.",";
					// check if this a new field that should be added via SQL update
					if (isset($this->addSQL['field']) && isset($this->addSQL['field'][$view]) 
						&& ComponentbuilderHelper::checkArray($this->addSQL['field'][$view])
						&& in_array($data['ID'], $this->addSQL['field'][$view]))
					{
						$this->updateSQLBuilder["ALTERTABLE`#__".$component."_".$view."`ADD`".$field."`"] 
							= "ALTER TABLE `#__".$component."_".$view."` ADD `".$field."` ".$data['type'].$lenght." ".$default." AFTER `".$last_name."`;";
					}
					// check if the field has changed name and/or data type and lenght
					elseif (0)
					{
						// hmmm tough one
					}
					// be sure to track the last name used :)
					$last_name = $field;
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['params']))
				{
					$db_ .= PHP_EOL."\t`params` text NOT NULL DEFAULT '',";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['published']))
				{
					$db_ .= PHP_EOL."\t`published` TINYINT(3) NOT NULL DEFAULT 1,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['created_by']))
				{
					$db_ .= PHP_EOL."\t`created_by` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['modified_by']))
				{
					$db_ .= PHP_EOL."\t`modified_by` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['created']))
				{
					$db_ .= PHP_EOL."\t`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['modified']))
				{
					$db_ .= PHP_EOL."\t`modified` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['checked_out']))
				{
					$db_ .= PHP_EOL."\t`checked_out` int(11) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['checked_out_time']))
				{
					$db_ .= PHP_EOL."\t`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['version']))
				{
					$db_ .= PHP_EOL."\t`version` INT(10) unsigned NOT NULL DEFAULT 1,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['hits']))
				{
					$db_ .= PHP_EOL."\t`hits` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if view has access
				if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
				{
					$db_ .= PHP_EOL."\t`access` INT(10) unsigned NOT NULL DEFAULT 0,";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['ordering']))
				{
					$db_ .= PHP_EOL."\t`ordering` INT(11) NOT NULL DEFAULT 0,";
				}
				// check if metadata is added to this view
				if (isset($this->metadataBuilder[$view]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$view]))
				{
					$db_ .= PHP_EOL."\t`metakey` TEXT NOT NULL DEFAULT '',";
					$db_ .= PHP_EOL."\t`metadesc` TEXT NOT NULL DEFAULT '',";
					$db_ .= PHP_EOL."\t`metadata` TEXT NOT NULL DEFAULT '',";
				}
				$db_ .= PHP_EOL."\tPRIMARY KEY  (`id`)";
				if (isset($this->dbUniqueKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbUniqueKeys[$view]))
				{
					foreach ($this->dbUniqueKeys[$view] as $nr => $key)
					{
						$db_ .= ",".PHP_EOL."\tUNIQUE KEY `idx_".$key."` (`".$key."`)";
					}
				}
				// check if view has access
				if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
				{
					$db_ .= ",".PHP_EOL."\tKEY `idx_access` (`access`)";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['checked_out']))
				{
					$db_ .= ",".PHP_EOL."\tKEY `idx_checkout` (`checked_out`)";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['created_by']))
				{
					$db_ .= ",".PHP_EOL."\tKEY `idx_createdby` (`created_by`)";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['modified_by']))
				{
					$db_ .= ",".PHP_EOL."\tKEY `idx_modifiedby` (`modified_by`)";
				}
				// check if default field was over written
				if (!isset($this->fieldsNames[$view]['published']))
				{
					$db_ .= ",".PHP_EOL."\tKEY `idx_state` (`published`)";
				}
				if (isset($this->dbKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbKeys[$view]))
				{
					foreach ($this->dbKeys[$view] as $nr => $key)
					{
						$db_ .= ",".PHP_EOL."\tKEY `idx_".$key."` (`".$key."`)";
					}
				}
				$db_ .= PHP_EOL.") ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
				
				// check if this is a new table that should be added via update SQL
				if (isset($this->addSQL['adminview']) && ComponentbuilderHelper::checkArray($this->addSQL['adminview'])
					&& in_array($view, $this->addSQL['adminview']))
				{
					// build the update array
					$this->updateSQLBuilder["CREATETABLEIFNOTEXISTS`#__".$component."_".$view."`"] = $db_;
				}
				
				// add to main DB string
				$db .= $db_.PHP_EOL.PHP_EOL;
			}
			// add custom sql dump to the file
			if (isset($this->customScriptBuilder['sql']) && ComponentbuilderHelper::checkArray($this->customScriptBuilder['sql']))
			{
				foreach ($this->customScriptBuilder['sql'] as $for => $customSql)
				{
					$placeholders = array('[[[component]]]' => $component, '[[[view]]]' => $for);
					$db .= $this->setPlaceholders($customSql, $placeholders).PHP_EOL.PHP_EOL;
				}

			}
			return $db;
		}
		return '';
	}

	public function setUninstall()
	{
		if (isset($this->queryBuilder) && ComponentbuilderHelper::checkArray($this->queryBuilder))
		{
			$bd = '';
			foreach ($this->uninstallBuilder as $line)
			{
				$bd .= $line.PHP_EOL;
			}
			return $bd;
		}
		return '';
	}

	public function setLangAdmin()
	{
		// add final list of needed lang strings
		$componentName = JFilterOutput::cleanText($this->componentData->name);
		$this->langContent['adminsys'][$this->langPrefix]				= $componentName;
		$this->langContent['adminsys'][$this->langPrefix.'_CONFIGURATION']		= $componentName.' Configuration';
		$this->langContent[$this->lang][$this->langPrefix]				= $componentName;
		$this->langContent['admin'][$this->langPrefix.'_BACK']				= 'Back';
		$this->langContent['admin'][$this->langPrefix.'_DASH']				= 'Dashboard';
		$this->langContent['admin'][$this->langPrefix.'_VERSION']			= 'Version';
		$this->langContent['admin'][$this->langPrefix.'_DATE']				= 'Date';
		$this->langContent['admin'][$this->langPrefix.'_AUTHOR']			= 'Author';
		$this->langContent['admin'][$this->langPrefix.'_WEBSITE']			= 'Website';
		$this->langContent['admin'][$this->langPrefix.'_LICENSE']			= 'License';
		$this->langContent['admin'][$this->langPrefix.'_CONTRIBUTORS']			= 'Contributors';
		$this->langContent['admin'][$this->langPrefix.'_CONTRIBUTOR']			= 'Contributor';
		$this->langContent['admin'][$this->langPrefix.'_DASHBOARD']			= $componentName.' Dashboard';
		$this->langContent['admin'][$this->langPrefix.'_SAVE_SUCCESS']			= "Great! Item successfully saved.";
		$this->langContent['admin'][$this->langPrefix.'_SAVE_WARNING']			= "The value already existed so please select another.";
		$this->langContent['admin'][$this->langPrefix.'_HELP_MANAGER']			= "Help";
		$this->langContent['admin'][$this->langPrefix.'_NEW']				= "New";
		$this->langContent['admin'][$this->langPrefix.'_CREATE_NEW_S']			= "Create New %s";
		$this->langContent['admin'][$this->langPrefix.'_EDIT_S']			= "Edit %s";
		$this->langContent['admin'][$this->langPrefix.'_KEEP_ORIGINAL_STATE']           = "- Keep Original State -";
		$this->langContent['admin'][$this->langPrefix.'_KEEP_ORIGINAL_ACCESS']          = "- Keep Original Access -";
		$this->langContent['admin'][$this->langPrefix.'_KEEP_ORIGINAL_CATEGORY']        = "- Keep Original Category -";
		$this->langContent['admin'][$this->langPrefix.'_PUBLISHED']			= 'Published';
		$this->langContent['admin'][$this->langPrefix.'_INACTIVE']			= 'Inactive';
		$this->langContent['admin'][$this->langPrefix.'_ARCHIVED']			= 'Archived';
		$this->langContent['admin'][$this->langPrefix.'_TRASHED']			= 'Trashed';
		if ($this->componentData->add_license && $this->componentData->license_type == 3)
		{
			$this->langContent['admin']['NIE_REG_NIE'] = "<br /><br /><center><h1>Lincense not set for ".$componentName.".</h1><p>Notify your administrator!<br />The lincense can be obtained from ".$this->componentData->companyname.".</p></center>";
		}
		// add the langug files needed to import and export data
		if ($this->addEximport)
		{
			$this->langContent['admin'][$this->langPrefix.'_EXPORT_FAILED']					= "Export Failed";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FAILED']					= "Import Failed";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_TITLE']					= "Data Importer";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_NO_IMPORT_TYPE_FOUND']			= "Import type not found.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE']		= "Package to import not found.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_ERROR']					= "Import error.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SUCCESS']				= "Great! Import successful.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_WARNIMPORTFILE']			= "Warning, import file error.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_NO_FILE_SELECTED']			= "No import file selected.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_SELECT_A_FILE']		= "Please select a file to import.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_SELECT_ALL_COLUMNS']          = "Please link all columns.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY'] 		= "Please enter the file directory.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_WARNIMPORTUPLOADERROR']		= "Warning, import upload error.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY']	= "Please enter the file directory.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE']	= "Path does not have a valid file.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE']	= "Does not have a valid file type.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_ENTER_A_URL']			= "Please enter a url.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_MSG_INVALID_URL']			= "Invalid url.";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_CONTINUE']				= "Continue";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FROM_UPLOAD']				= "Upload";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SELECT_FILE']				= "Select File";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_UPLOAD_BOTTON']				= "Upload File";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FROM_DIRECTORY']				= "Directory";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SELECT_FILE_DIRECTORY']			= "Set the path to file";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_GET_BOTTON']				= "Get File";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FROM_URL']				= "URL";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_SELECT_FILE_URL']			= "Enter file URL";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_UPDATE_DATA']				= "Import Data";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FORMATS_ACCEPTED']			= "formats accepted";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_LINK_FILE_TO_TABLE_COLUMNS']		= "Link File to Table Columns";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_TABLE_COLUMNS']				= "Table Columns";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_FILE_COLUMNS']				= "File Columns";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_PLEASE_SELECT_COLUMN']			= "-- Please Select Column --";
			$this->langContent['admin'][$this->langPrefix.'_IMPORT_IGNORE_COLUMN']				= "-- Ignore This Column --";
                        $this->langContent['admin'][$this->langPrefix.'_NO_ACCESS_GRANTED']				= "No Access Granted!";
		}
		// check if the both array is set
		if (isset($this->langContent['both']) && ComponentbuilderHelper::checkArray($this->langContent['both']))
		{
			foreach ($this->langContent['both'] as $keylang => $langval)
			{
				$this->langContent['admin'][$keylang] = $langval;
			}
		}
		// check if the both admin array is set
		if (isset($this->langContent['bothadmin']) && ComponentbuilderHelper::checkArray($this->langContent['bothadmin']))
		{
			foreach ($this->langContent['bothadmin'] as $keylang => $langval)
			{
				$this->langContent['admin'][$keylang] = $langval;
			}
		}
		if (isset($this->langContent['admin']) && ComponentbuilderHelper::checkArray($this->langContent['admin']))
		{
			ksort($this->langContent['admin']);
			// load to global languages
			$this->languages['en-GB']['admin'] = $this->langContent['admin'];
			// remove tmp array
			unset($this->langContent['admin']);
			
			return true;
		}
		return false;
	}

	public function setLangSite()
	{
		// add final list of needed lang strings
		$this->langContent['site'][$this->langPrefix] = ComponentbuilderHelper::safeString($this->componentData->name,'W');
		// some more defaults
		$this->langContent['site']['JTOOLBAR_APPLY']		= "Save";
		$this->langContent['site']['JTOOLBAR_SAVE_AS_COPY']	= "Save as Copy";
		$this->langContent['site']['JTOOLBAR_SAVE']		= "Save & Close";
		$this->langContent['site']['JTOOLBAR_SAVE_AND_NEW']	= "Save & New";
		$this->langContent['site']['JTOOLBAR_CANCEL']		= "Cancel";
		$this->langContent['site']['JTOOLBAR_CLOSE']		= "Close";
		$this->langContent['site']['JTOOLBAR_HELP']		= "Help";
		$this->langContent['site']['JGLOBAL_FIELD_ID_LABEL']		= "ID";
		$this->langContent['site']['JGLOBAL_FIELD_ID_DESC']		= "Record number in the database.";
		$this->langContent['site']['JGLOBAL_FIELD_MODIFIED_LABEL']	= "Modified Date";
		$this->langContent['site']['COM_CONTENT_FIELD_MODIFIED_DESC']	= "The last date this item was modified.";
		$this->langContent['site']['JGLOBAL_FIELD_MODIFIED_BY_LABEL']	= "Modified By";
		$this->langContent['site']['JGLOBAL_FIELD_MODIFIED_BY_DESC']	= "The user who did the last modification.";
		$this->langContent['site'][$this->langPrefix.'_NEW']		= "New";
		$this->langContent['site'][$this->langPrefix.'_CREATE_NEW_S']	= "Create New %s";
		$this->langContent['site'][$this->langPrefix.'_EDIT_S']		= "Edit %s";
		$this->langContent['site'][$this->langPrefix.'_NO_ACCESS_GRANTED'] = "No Access Granted!";
		
		// check if the both array is set
		if (isset($this->langContent['both']) && ComponentbuilderHelper::checkArray($this->langContent['both']))
		{
			foreach ($this->langContent['both'] as $keylang => $langval)
			{
				$this->langContent['site'][$keylang] = $langval;
			}
		}
		// check if the both site array is set
		if (isset($this->langContent['bothsite']) && ComponentbuilderHelper::checkArray($this->langContent['bothsite']))
		{
			foreach ($this->langContent['bothsite'] as $keylang => $langval)
			{
				$this->langContent['site'][$keylang] = $langval;
			}
		}
		if (isset($this->langContent['site']) && ComponentbuilderHelper::checkArray($this->langContent['site']))
		{
			ksort($this->langContent['site']);
			// load to global languages
			$this->languages['en-GB']['site'] = $this->langContent['site'];
			// remove tmp array
			unset($this->langContent['site']);
			
			return true;
		}
		return false;
	}

	public function setLangSiteSys()
	{
		// add final list of needed lang strings
		$this->langContent['sitesys'][$this->langPrefix] = ComponentbuilderHelper::safeString($this->componentData->name,'W');
		$this->langContent['sitesys'][$this->langPrefix.'_NO_ACCESS_GRANTED'] = "No Access Granted!";

		// check if the both site array is set
		if (isset($this->langContent['bothsite']) && ComponentbuilderHelper::checkArray($this->langContent['bothsite']))
		{
			foreach ($this->langContent['bothsite'] as $keylang => $langval)
			{
				$this->langContent['sitesys'][$keylang] = $langval;
			}
		}
		if (isset($this->langContent['sitesys']) && ComponentbuilderHelper::checkArray($this->langContent['sitesys']))
		{
			ksort($this->langContent['sitesys']);
			// load to global languages
			$this->languages['en-GB']['sitesys'] = $this->langContent['sitesys'];
			// remove tmp array
			unset($this->langContent['sitesys']);
			
			return true;
		}
		return false;
	}

	public function setLangAdminSys()
	{
		// check if the both admin array is set
		if (isset($this->langContent['bothadmin']) && ComponentbuilderHelper::checkArray($this->langContent['bothadmin']))
		{
			foreach ($this->langContent['bothadmin'] as $keylang => $langval)
			{
				$this->langContent['adminsys'][$keylang] = $langval;
			}
		}
		if (isset($this->langContent['adminsys']) && ComponentbuilderHelper::checkArray($this->langContent['adminsys']))
		{
			ksort($this->langContent['adminsys']);
			// load to global languages
			$this->languages['en-GB']['adminsys'] = $this->langContent['adminsys'];
			// remove tmp array
			unset($this->langContent['adminsys']);
			
			return true;
		}
		return false;
	}

	public function setCustomAdminViewListLink($view,$viewName_list)
	{
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $custom_admin_view)
			{
				if (ComponentbuilderHelper::checkArray($custom_admin_view['adminviews']))
				{
					foreach ($custom_admin_view['adminviews'] as $adminview)
					{
						if ($view['adminview'] == $adminview)
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

	public function setListBody($viewName_single,$viewName_list)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic['###Component###'].'Helper';
			// setup correct core target
			$coreLoad = false;
			if (isset($this->permissionCore[$viewName_single]))
			{
				$core = $this->permissionCore[$viewName_single];
				$coreLoad = true;
			}
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// add the default
			$body = "<?php foreach (\$this->items as \$i => \$item): ?>";
			$body .= PHP_EOL."\t<?php";
			$body .= PHP_EOL."\t\t\$canCheckin = \$this->user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$this->user->id || \$item->checked_out == 0;";
			$body .= PHP_EOL."\t\t\$userChkOut = JFactory::getUser(\$item->checked_out);";
			$body .= PHP_EOL."\t\t\$canDo = ".$Helper."::getActions('".$viewName_single."',\$item,'".$viewName_list."');";
			$body .= PHP_EOL."\t?>";
			$body .= PHP_EOL."\t".'<tr class="row<?php echo $i % 2; ?>">';
			// only load if not over written
			if (!isset($this->fieldsNames[$viewName_single]['ordering']))
			{
				$body .= PHP_EOL."\t\t".'<td class="order nowrap center hidden-phone">';
				// check if the item has permissions.
				if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
				{
					$body .= PHP_EOL."\t\t<?php if (\$canDo->get('".$core['core.edit.state']."')): ?>";
				}
				else
				{
					$body .= PHP_EOL."\t\t<?php if (\$canDo->get('core.edit.state')): ?>";
				}
				$body .= PHP_EOL."\t\t\t<?php";
				$body .= PHP_EOL."\t\t\t\tif (\$this->saveOrder)";
				$body .= PHP_EOL."\t\t\t\t{";
				$body .= PHP_EOL."\t\t\t\t\t\$iconClass = ' inactive';";
				$body .= PHP_EOL."\t\t\t\t}";
				$body .= PHP_EOL."\t\t\t\telse";
				$body .= PHP_EOL."\t\t\t\t{";
				$body .= PHP_EOL."\t\t\t\t\t\$iconClass = ' inactive tip-top".'" hasTooltip" title="'."' . JHtml::tooltipText('JORDERINGDISABLED');";
				$body .= PHP_EOL."\t\t\t\t}";
				$body .= PHP_EOL."\t\t\t?>";
				$body .= PHP_EOL."\t\t\t".'<span class="sortable-handler<?php echo $iconClass; ?>">';
				$body .= PHP_EOL."\t\t\t\t".'<i class="icon-menu"></i>';
				$body .= PHP_EOL."\t\t\t</span>";
				$body .= PHP_EOL."\t\t\t<?php if (\$this->saveOrder) : ?>";
				$body .= PHP_EOL."\t\t\t\t".'<input type="text" style="display:none" name="order[]" size="5"';
				$body .= PHP_EOL."\t\t\t\t".'value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />';
				$body .= PHP_EOL."\t\t\t<?php endif; ?>";
				$body .= PHP_EOL."\t\t<?php else: ?>";
				$body .= PHP_EOL."\t\t\t&#8942;";
				$body .= PHP_EOL."\t\t<?php endif; ?>";
				$body .= PHP_EOL."\t\t</td>";
			}
			$body .= PHP_EOL."\t\t".'<td class="nowrap center">';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$body .= PHP_EOL."\t\t<?php if (\$canDo->get('".$core['core.edit']."')): ?>";
			}
			else
			{
				$body .= PHP_EOL."\t\t<?php if (\$canDo->get('core.edit')): ?>";
			}
			$body .= PHP_EOL."\t\t\t\t<?php if (\$item->checked_out) : ?>";
			$body .= PHP_EOL."\t\t\t\t\t<?php if (\$canCheckin) : ?>";
			$body .= PHP_EOL."\t\t\t\t\t\t<?php echo JHtml::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL."\t\t\t\t\t<?php else: ?>";
			$body .= PHP_EOL."\t\t\t\t\t\t&#9633;";
			$body .= PHP_EOL."\t\t\t\t\t<?php endif; ?>";
			$body .= PHP_EOL."\t\t\t\t<?php else: ?>";
			$body .= PHP_EOL."\t\t\t\t\t<?php echo JHtml::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL."\t\t\t\t<?php endif; ?>";
			$body .= PHP_EOL."\t\t<?php else: ?>";
			$body .= PHP_EOL."\t\t\t&#9633;";
			$body .= PHP_EOL."\t\t<?php endif; ?>";
			$body .= PHP_EOL."\t\t</td>";
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (isset($this->doNotEscape[$viewName_list]))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				$checkoutTriger = false;
				if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && isset($item['custom']['table']) && ComponentbuilderHelper::checkString($item['custom']['table']))
				{
					$item['id'] = $item['code'];
					if (!$item['multiple'])
					{
						$item['code'] = $item['code'].'_'.$item['custom']['text'];
					}
				}
				// check if translated value is used
				if (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list])
					&& array_key_exists($item['code'],$this->selectionTranslationFixBuilder[$viewName_list]))
				{
					$itemCode = '<?php echo JText::_($item->'.$item['code'].'); ?>';
				}
				elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['text'] === 'user')
				{
					$itemCode = '<?php echo JFactory::getUser((int)$item->'.$item['code'].')->name; ?>';
				}
				elseif ($doNotEscape)
				{
					if (in_array($item['code'], $this->doNotEscape[$viewName_list]))
					{
						$itemCode = '<?php echo $item->'.$item['code'].'; ?>';
					}
					else
					{
						$itemCode = '<?php echo $this->escape($item->'.$item['code'].'); ?>';
					}
				}
				else
				{
					$itemCode = '<?php echo $this->escape($item->'.$item['code'].'); ?>';
				}
				if ($item['link'])
				{
					// allways rest custom links
					$customAdminView = '';
					// if to be linked
					if ($item['type'] === 'category' && !$item['title'])
					{
						$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
						// category and linked
						$body .= PHP_EOL."\t\t".'<td class="nowrap">';
						$body .= PHP_EOL."\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$otherViews.".category.' . (int)\$item->".$item['code'].")): ?>";
						$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->'.$item['code'].'; ?>&extension=com_'.$this->fileContentStatic['###component###'].'.'.$otherViews.'"><?php echo $this->escape($item->category_title); ?></a>';
						$body .= PHP_EOL."\t\t\t<?php else: ?>";
						$body .= PHP_EOL."\t\t\t\t<?php echo \$this->escape(\$item->category_title); ?>";
						$body .= PHP_EOL."\t\t\t<?php endif; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					elseif ($item['type'] === 'user' && !$item['title'])
					{
						// user and linked
						$body .= PHP_EOL."\t\t<?php \$".$item['code']."User = JFactory::getUser(\$item->".$item['code']."); ?>";
						$body .= PHP_EOL."\t\t".'<td class="nowrap">';
						$body .= PHP_EOL."\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_users')): ?>";
						$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['code'].' ?>"><?php echo $'.$item['code'].'User->name; ?></a>';
						$body .= PHP_EOL."\t\t\t<?php else: ?>";
						$body .= PHP_EOL."\t\t\t\t<?php echo \$".$item['code']."User->name; ?>";
						$body .= PHP_EOL."\t\t\t<?php endif; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					else
					{
						$add = true;
						if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] != 'user' && !$item['title'])
						{
							// link to that item instead
							$link = 'index.php?option='.$item['custom']['component'].'&view='.$item['custom']['views'].'&task='.$item['custom']['view'].'.edit&id=<?php echo $item->'.$item['id'].'; ?>&ref='.$viewName_list;
							
							$coreLoadLink = false;
							if (isset($this->permissionCore[$item['custom']['view']]))
							{
								$coreLink = $this->permissionCore[$item['custom']['view']];
								$coreLoadLink = true;
							}
							// check if the item has permissions.
							if ($coreLoadLink && (isset($coreLink['core.edit']) && isset($this->permissionBuilder[$coreLink['core.edit']])) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$coreLink['core.edit']]) && in_array($item['custom']['view'],$this->permissionBuilder[$coreLink['core.edit']]))
							{
								$accessCheck = "\$this->user->authorise('".$coreLink['core.edit']."', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
							}
							else
							{
								$accessCheck = "\$this->user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
							}
						}
						elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user' && !$item['title'])
						{
							// user and linked
							$body .= PHP_EOL."\t\t<?php \$".$item['id']." = JFactory::getUser(\$item->".$item['id']."); ?>";
							$body .= PHP_EOL."\t\t".'<td class="nowrap">';
							$body .= PHP_EOL."\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_users')): ?>";
							$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $'.$item['id'].'->name; ?></a>';
							$body .= PHP_EOL."\t\t\t<?php else: ?>";
							$body .= PHP_EOL."\t\t\t\t<?php echo \$".$item['id']."->name; ?>";
							$body .= PHP_EOL."\t\t\t<?php endif; ?>";
							$body .= PHP_EOL."\t\t</td>";

							$add = false;
						}
						else
						{
                                                        // start building the links
							$link = '<?php echo $edit; ?>&id=<?php echo $item->id; ?>';
                                                        // check if custom links should be added to this list views
                                                        if (isset($this->customAdminViewListLink[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminViewListLink[$viewName_list]) && $firstTimeBeingAdded)
                                                        {
                                                                // make sure the custom links are only added once
                                                                $firstTimeBeingAdded = false;
                                                                // start building the links
                                                                $customAdminView = PHP_EOL."\t\t\t".'<div class="btn-group">';
                                                                foreach ($this->customAdminViewListLink[$viewName_list] as $customLinkView)
                                                                {
                                                                        $customAdminView .= PHP_EOL."\t\t\t<?php if (\$canDo->get('".$customLinkView['link'].".access')): ?>";
                                                                        $customAdminView .= PHP_EOL."\t\t\t\t".'<a class="hasTooltip btn btn-mini" href="index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$customLinkView['link'].'&id=<?php echo $item->id; ?>" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>" ><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= PHP_EOL."\t\t\t<?php else: ?>";
                                                                        $customAdminView .= PHP_EOL."\t\t\t\t".'<a class="hasTooltip btn btn-mini disabled" href="#" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>"><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= PHP_EOL."\t\t\t<?php endif; ?>";
                                                                }
                                                                $customAdminView .= PHP_EOL."\t\t\t".'</div>';

                                                        }
							// check if the item has permissions.
							if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
							{
								// set permissions.
								$accessCheck = "\$canDo->get('".$core['core.edit']."')";
							}
							else
							{
								// set permissions.
								$accessCheck = "\$canDo->get('core.edit')";
							}
							// triger the checked out script to be added
							$checkoutTriger = true;
						}

						if ($add)
						{
							// set as linked
							$body .= PHP_EOL."\t\t".'<td class="nowrap">';
							$body .= PHP_EOL."\t\t\t<?php if (".$accessCheck."): ?>";
							$body .= PHP_EOL."\t\t\t\t".'<div class="name">'.PHP_EOL."\t\t\t\t\t".'<a href="'.$link.'">'.$itemCode.'</a>';
							if ($checkoutTriger)
							{
								$body .= PHP_EOL."\t\t\t\t\t<?php if (\$item->checked_out): ?>";
								$body .= PHP_EOL."\t\t\t\t\t\t<?php echo JHtml::_('jgrid.checkedout', \$i, \$userChkOut->name, \$item->checked_out_time, '".$viewName_list.".', \$canCheckin); ?>";
								$body .= PHP_EOL."\t\t\t\t\t<?php endif; ?>";
							}
							$body .= PHP_EOL."\t\t\t\t".'</div>';
							$body .= PHP_EOL."\t\t\t<?php else: ?>";
							$body .= PHP_EOL."\t\t\t\t".'<div class="name">'.$itemCode.'</div>';
							$body .= PHP_EOL."\t\t\t<?php endif; ?>";
                                                        $body .= $customAdminView;
							$body .= PHP_EOL."\t\t</td>";
						}
					}
				}
				else
				{
					if ($item['type'] === 'category')
					{
						$body .= PHP_EOL."\t\t<td class=\"hidden-phone\">";
						$body .= PHP_EOL."\t\t\t<?php echo \$this->escape(\$item->category_title); ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					elseif (ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user')
					{
						// custom user and linked
						$body .= PHP_EOL."\t\t<?php \$".$item['code']." = JFactory::getUser(\$item->".$item['id']."); ?>";
						$body .= PHP_EOL."\t\t".'<td class="nowrap hidden-phone">';
						$body .= PHP_EOL."\t\t\t<?php if (\$this->user->authorise('core.edit', 'com_users')): ?>";
						$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $'.$item['code'].'->name; ?></a>';
						$body .= PHP_EOL."\t\t\t<?php else: ?>";
						$body .= PHP_EOL."\t\t\t\t<?php echo \$".$item['code']."->name; ?>";
						$body .= PHP_EOL."\t\t\t<?php endif; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					elseif ($item['type'] === 'user')
					{
						// user name only
						$body .= PHP_EOL."\t\t<?php \$".$item['code']."User = JFactory::getUser(\$item->".$item['code']."); ?>";
						$body .= PHP_EOL."\t\t".'<td class="nowrap">';
						$body .= PHP_EOL."\t\t\t<?php echo \$".$item['code']."User->name; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					else
					{
						// normal not linked
						$body .= PHP_EOL."\t\t<td class=\"hidden-phone\">";
						$body .= PHP_EOL."\t\t\t".$itemCode;
						$body .= PHP_EOL."\t\t</td>";
					}
				}
			}
			// add the defaults
			if (!isset($this->fieldsNames[$viewName_single]['published']))
			{
				$body .= PHP_EOL."\t\t".'<td class="center">';
				// check if the item has permissions.
				if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
				{
					$body .= PHP_EOL."\t\t<?php if (\$canDo->get('".$core['core.edit.state']."')) : ?>";
				}
				else
				{
					$body .= PHP_EOL."\t\t<?php if (\$canDo->get('core.edit.state')) : ?>";
				}
				$body .= PHP_EOL."\t\t\t\t<?php if (\$item->checked_out) : ?>";
				$body .= PHP_EOL."\t\t\t\t\t<?php if (\$canCheckin) : ?>";
				$body .= PHP_EOL."\t\t\t\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', true, 'cb'); ?>";
				$body .= PHP_EOL."\t\t\t\t\t<?php else: ?>";
				$body .= PHP_EOL."\t\t\t\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', false, 'cb'); ?>";
				$body .= PHP_EOL."\t\t\t\t\t<?php endif; ?>";
				$body .= PHP_EOL."\t\t\t\t<?php else: ?>";
				$body .= PHP_EOL."\t\t\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', true, 'cb'); ?>";
				$body .= PHP_EOL."\t\t\t\t<?php endif; ?>";
				$body .= PHP_EOL."\t\t<?php else: ?>";
				$body .= PHP_EOL."\t\t\t<?php echo JHtml::_('jgrid.published', \$item->published, \$i, '".$viewName_list.".', false, 'cb'); ?>";
				$body .= PHP_EOL."\t\t<?php endif; ?>";
				$body .= PHP_EOL."\t\t</td>";
			}	
			if (!isset($this->fieldsNames[$viewName_single]['id']))
			{
				$body .= PHP_EOL."\t\t".'<td class="nowrap center hidden-phone">';
				$body .= PHP_EOL."\t\t\t<?php echo \$item->id; ?>";
				$body .= PHP_EOL."\t\t</td>";
			}
			$body .= PHP_EOL."\t</tr>";
			$body .= PHP_EOL."<?php endforeach; ?>";
			// return the build
			return $body;
		}
		return '';
	}

	public function setListHead($viewName_single,$viewName_list)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// main lang prefix
			$langView = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($viewName_single,'U');
			// set status lang
			$statusLangName = $langView.'_STATUS';
			// set id lang
			$idLangName = $langView.'_ID';
			// add to lang array
			if (!isset($this->langContent[$this->lang][$statusLangName]))
			{
				$this->langContent[$this->lang][$statusLangName] = 'Status';
			}
			// add to lang array
			if (!isset($this->langContent[$this->lang][$idLangName ]))
			{
				$this->langContent[$this->lang][$idLangName] = 'Id';
			}
			// set default
			$head = '<tr>';
			$head .= PHP_EOL."\t<?php if (\$this->canEdit&& \$this->canState): ?>";
			if (!isset($this->fieldsNames[$viewName_single]['ordering']))
			{
				$head .= PHP_EOL."\t\t".'<th width="1%" class="nowrap center hidden-phone">';
				$head .= PHP_EOL."\t\t\t<?php echo JHtml::_('grid.sort', '".'<i class="icon-menu-2"></i>'."', 'ordering', \$this->listDirn, \$this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>";
				$head .= PHP_EOL."\t\t</th>";
			}
			$head .= PHP_EOL."\t\t".'<th width="20" class="nowrap center">';
			$head .= PHP_EOL."\t\t\t<?php echo JHtml::_('grid.checkall'); ?>";
			$head .= PHP_EOL."\t\t</th>";
			$head .= PHP_EOL."\t<?php else: ?>";
			$head .= PHP_EOL."\t\t".'<th width="20" class="nowrap center hidden-phone">';
			$head .= PHP_EOL."\t\t\t&#9662;";
			$head .= PHP_EOL."\t\t</th>";
			$head .= PHP_EOL."\t\t".'<th width="20" class="nowrap center">';
			$head .= PHP_EOL."\t\t\t&#9632;";
			$head .= PHP_EOL."\t\t</th>";
			$head .= PHP_EOL."\t<?php endif; ?>";
			// set footer Column number
			$this->listColnrBuilder[$viewName_list] = 4;
			// build the dynamic fields
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				if (ComponentbuilderHelper::checkArray($item['custom']))
				{
					$item['code'] = $item['code'].'_'.$item['custom']['text'];
				}
				$class = 'nowrap hidden-phone';
				if ($item['link'])
				{
					$class = 'nowrap';
				}
				$title = "<?php echo JText::_('".$item['lang']."'); ?>";
				if ($item['sort'])
				{
					$title = "<?php echo JHtml::_('grid.sort', '".$item['lang']."', '".$item['code']."', \$this->listDirn, \$this->listOrder); ?>";
				}
				$head .= PHP_EOL."\t".'<th class="'.$class.'" >';
				$head .= PHP_EOL."\t\t\t".$title;
				$head .= PHP_EOL."\t</th>";
				$this->listColnrBuilder[$viewName_list]++;
			}
			// set default
			if (!isset($this->fieldsNames[$viewName_single]['published']))
			{
				$head .= PHP_EOL."\t<?php if (\$this->canState): ?>";
				$head .= PHP_EOL."\t\t".'<th width="10" class="nowrap center" >';
				$head .= PHP_EOL."\t\t\t<?php echo JHtml::_('grid.sort', '".$statusLangName."', 'published', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL."\t\t</th>";
				$head .= PHP_EOL."\t<?php else: ?>";
				$head .= PHP_EOL."\t\t".'<th width="10" class="nowrap center" >';
				$head .= PHP_EOL."\t\t\t<?php echo JText::_('".$statusLangName."'); ?>";
				$head .= PHP_EOL."\t\t</th>";
				$head .= PHP_EOL."\t<?php endif; ?>";
			}
			if (!isset($this->fieldsNames[$viewName_single]['id']))
			{
				$head .= PHP_EOL."\t".'<th width="5" class="nowrap center hidden-phone" >';
				$head .= PHP_EOL."\t\t\t<?php echo JHtml::_('grid.sort', '".$idLangName."', 'id', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL."\t</th>";
			}
 			$head .= PHP_EOL."</tr>";

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

	public function setEditBody(&$view)
	{
		// set view name
		$viewName_single = ComponentbuilderHelper::safeString($view['settings']->name_single);
		// alignment
		$alignmentNames = array(1 => 'left', 2 => 'right', 3 => 'fullwidth', 4 => 'above', 5 => 'under', 6 => 'leftside', 7 => 'rightside');
		// main lang prefix
		$langView = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($viewName_single,'U');

		if (isset($this->layoutBuilder[$viewName_single]) && ComponentbuilderHelper::checkArray($this->layoutBuilder[$viewName_single]))
		{
			// set the linked view tabs
			$linkedTab = array();
			$keys = array();
			// setup correct core target
			$coreLoad = false;
			if (isset($this->permissionCore[$viewName_single]))
			{
				$core = $this->permissionCore[$viewName_single];
				$coreLoad = true;
			}
			if (isset($this->linkedAdminViews[$viewName_single]) && ComponentbuilderHelper::checkArray($this->linkedAdminViews[$viewName_single]))
			{
				foreach ($this->linkedAdminViews[$viewName_single] as $linkedView)
				{
					$tabName = $view['settings']->tabs[(int) $linkedView['tab']];
					$this->tabCounter[$viewName_single][$linkedView['tab']] = $tabName;
					$linkedTab[$linkedView['adminview']] = $linkedView['tab'];
					if (ComponentbuilderHelper::checkString($linkedView['key']) && ComponentbuilderHelper::checkString($linkedView['parentkey']))
					{
						$keys[$linkedView['adminview']] = array( 'key' => $linkedView['key'], 'parentKey' => $linkedView['parentkey']);
					}
					else
					{
						$keys[$linkedView['adminview']] = array( 'key' => null, 'parentKey' => null);
					}
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
			// start tab set
			$bucket = array();
			$leftside = '';
			$rightside = '';
			$footer = '';
			$header = '';
			$mainwidth = 12;
			$sidewidth = 0;
			ksort($this->tabCounter[$viewName_single]);
			foreach ($this->tabCounter[$viewName_single] as $tabNr => $tabName)
			{
				$tabWidth = 12;
				$lrCounter = 0;
				// set tab lang
				$tabLangName = $langView.'_'.ComponentbuilderHelper::safeString($tabName,'U');
				// set tab code name
				$tabCodeName = ComponentbuilderHelper::safeString($tabName);
				// add to lang array
				if (!isset($this->langContent[$this->lang][$tabLangName]))
				{
					$this->langContent[$this->lang][$tabLangName] = $tabName;
				}
				// check if linked view belongs to this tab
				$buildLayout = true;
				$linkedViewId = '';
				if (ComponentbuilderHelper::checkArray($linkedTab))
				{
					if (($linkedViewId = array_search($tabNr, $linkedTab)) !== false)
					{
						// don't build
						$buildLayout = false;
					}
				}
				if ($buildLayout)
				{
					// sort to make sure it loads left first
					$alignments = $this->layoutBuilder[$viewName_single][$tabName];
					ksort($alignments);
					foreach ($alignments as $alignment => $names)
					{
						// set layout code name
						$layoutCodeName = $tabCodeName.'_'.$alignmentNames[$alignment];
						// reset each time
						$items  = '';
						$itemCounter = 0;
						ksort($names);
						foreach ($names as $nr => $name)
						{
							if ($itemCounter == 0)
							{
								$items .= "'".$name."'";
							}
							else
							{
								$items .= ",".PHP_EOL."\t'".$name."'";
							}
							$itemCounter++;
						}
						switch($alignment)
						{
							case 1: // left
							case 2: // right
								// count
								$lrCounter++;
								// set as items layout
								$this->setLayout($viewName_single,$layoutCodeName,$items,'layoutitems');
								// set the lang to tab
								$bucket[$tabCodeName]['lang'] = $tabLangName;
								// load the body
								if (!isset($bucket[$tabCodeName][(int) $alignment]))
								{
									$bucket[$tabCodeName][(int) $alignment] = '';
								}
								$bucket[$tabCodeName][(int) $alignment] .= "<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 3: // fullwidth
								// set as items layout
								$this->setLayout($viewName_single,$layoutCodeName,$items,'layoutfull');
								// set the lang to tab
								$bucket[$tabCodeName]['lang'] = $tabLangName;
								// load the body
								if (!isset($bucket[$tabCodeName][(int) $alignment]))
								{
									$bucket[$tabCodeName][(int) $alignment] = '';
								}
								$bucket[$tabCodeName][(int) $alignment] .= "<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 4: // above
								// set as title layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layouttitle');
								// load to header
								$header .= PHP_EOL."\t<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 5: // under
								// set as title layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layouttitle');
								// load to footer
								$footer .= PHP_EOL.PHP_EOL."<div class=\"clearfix\"></div>".PHP_EOL."<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 6: // left side
								$tabWidth = $tabWidth - 2;
								// set as items layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layoutitems');
								// load the body
								$leftside .= PHP_EOL."\t<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
							case 7: // right side
								$tabWidth = $tabWidth - 2;
								// set as items layout
								$this->setLayout($viewName_single, $layoutCodeName, $items, 'layoutitems');
								// load the body
								$rightside .= PHP_EOL."\t<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
							break;
						}
					}
				}
				else
				{
					// set layout code name
					$layoutCodeName = $tabCodeName.'_fullwidth';
					// set identifiers
					$linkedViewIdentifier[$linkedViewId] = $tabCodeName;
					//set function name
					$codeName = ComponentbuilderHelper::safeString($this->uniquekey(3).$tabCodeName);
					// set as items layout
					$this->setLayout($viewName_single,$layoutCodeName,$codeName,'layoutlinkedview');
					// set the lang to tab
					$bucket[$tabCodeName]['lang'] = $tabLangName;
					// set all the linked view stuff
					$this->secondRunAdmin['setLinkedView'][] = array(
						'viewId' => $linkedViewId,
						'viewName_single' => $viewName_single,
						'codeName' => $codeName,
						'layoutCodeName' => $layoutCodeName,
						'key' => $keys[$linkedViewId]['key'],
						'parentKey' => $keys[$linkedViewId]['parentKey'],
						'addNewButon' => $keys[$linkedViewId]['addNewButton']);
					// load the body
					if (!isset($bucket[$tabCodeName][3]))
					{
						$bucket[$tabCodeName][3] = '';
					}
					$bucket[$tabCodeName][3] .= "<?php echo JLayoutHelper::render('".$viewName_single.".".$layoutCodeName."', \$this); ?>";
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
				$bucket[$tabCodeName]['lr'] = $lrCounter;
			}
			// tab counter
			$tabCounter = 0;
			// check if width is still 12
			$span = '';
			if ($mainwidth != 12)
			{
				$span = 'span'.$mainwidth;
			}
			// start building body
			$body = PHP_EOL.'<div class="form-horizontal">';
			if (ComponentbuilderHelper::checkString($span))
			{
				$body .= PHP_EOL."\t".'<div class="'.$span.'">';
			}
			// now build the template
			foreach ($bucket as $tabCodeName => $posions)
			{
				// check main if both left and right is set
				$lrCounter = $posions['lr'];
				// get lang string
				$tabLangName = $posions['lang'];
				// build main center
				$main 		= '';
				$mainbottom = '';
				foreach ($posions as $posion => $string)
				{
					if ($lrCounter == 2)
					{
						switch($posion)
						{
							case 1: // left
							case 2: // right
								$main .= PHP_EOL."\t\t\t".'<div class="span6">';
								$main .= PHP_EOL."\t\t\t\t".$string;
								$main .= PHP_EOL."\t\t\t".'</div>';
							break;
						}
					}
					else
					{
						switch($posion)
						{
							case 1: // left
							case 2: // right
								$main .= PHP_EOL."\t\t\t".'<div class="span12">';
								$main .= PHP_EOL."\t\t\t\t".$string;
								$main .= PHP_EOL."\t\t\t".'</div>';
							break;
						}
					}
					switch($posion)
					{
						case 3: // fullwidth
							$mainbottom .= PHP_EOL."\t\t\t".'<div class="span12">';
							$mainbottom .= PHP_EOL."\t\t\t\t".$string;
							$mainbottom .= PHP_EOL."\t\t\t".'</div>';
						break;
					}
				}
				// set acctive tab
				if ($tabCounter == 0)
				{
					$body .= PHP_EOL.PHP_EOL."\t<?php echo JHtml::_('bootstrap.startTabSet', '".$viewName_single."Tab', array('active' => '".$tabCodeName."')); ?>";
				}
				// if this is a linked view set permissions
				$closeIT = false;
				if(isset($linkedViewIdentifier) && ComponentbuilderHelper::checkArray($linkedViewIdentifier) && in_array($tabCodeName,$linkedViewIdentifier))
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
					if ($coreLoadLinked && isset($coreLinked['core.access']) && isset($this->permissionBuilder['global'][$coreLinked['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$coreLinked['core.access']]) && in_array($linkedCodeName,$this->permissionBuilder['global'][$coreLinked['core.access']]))
					{
						$body .= PHP_EOL.PHP_EOL."\t<?php if (\$this->canDo->get('".$coreLinked['core.access']."')) : ?>";
						$closeIT = true;
					}
					else
					{
						$body .= PHP_EOL;
					}
					// insure clear
					unset($coreLoadLinked,$coreLinked,$linkedViewData);
				}
				else
				{
					$body .= PHP_EOL;
				}
				// start tab
				$body .= PHP_EOL."\t<?php echo JHtml::_('bootstrap.addTab', '".$viewName_single."Tab', '".$tabCodeName."', JText::_('".$tabLangName."', true)); ?>";
				// add the main
				$body .= PHP_EOL."\t\t".'<div class="row-fluid form-horizontal-desktop">';
				$body .= $main;
				$body .= PHP_EOL."\t\t</div>";
				if (strlen($mainbottom) > 0)
				{
					// add the main bottom
					$body .= PHP_EOL."\t\t".'<div class="row-fluid form-horizontal-desktop">';
					$body .= $mainbottom;
					$body .= PHP_EOL."\t\t</div>";
				}
				$body .= PHP_EOL."\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
				if($closeIT)
				{
					$body .= PHP_EOL."\t<?php endif; ?>";
				}
				// set counter
				$tabCounter++;
			}
			// set default publishing tab lang
			$tabLangName = $langView.'_PUBLISHING';
			// add to lang array
			if (!isset($this->langContent[$this->lang][$tabLangName]))
			{
				$this->langContent[$this->lang][$tabLangName] = 'Publishing';
			}
			// the default publishing items
			$items = array('left' => array(), 'right' => array());
			// Setup the default (custom) fields
			// only load (1 => 'left', 2 => 'right')
			$fieldsAddedRight = false;
			if (isset($this->newPublishingFields[$viewName_single]))
			{
				foreach($this->newPublishingFields[$viewName_single] as $df_alignment => $df_items)
				{
					foreach($df_items as $df_order => $df_name)
					{
						if ($df_alignment == 2 || $df_alignment == 1)
						{
							$items[$alignmentNames[$df_alignment]][$df_order] = $df_name;
						}
						else
						{
							$this->app->enqueueMessage(JText::sprintf('Your <b>%s</b> field could not be added, since the <b>%s</b> alignment position is not available in the %s (publishing) tab. Please only target <b>Left or right</b> in the publishing tab.', $df_name, $alignmentNames[$df_alignment], $viewName_single), 'warning');
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
				foreach($defaultFields as $defaultField)
				{
					if (!isset($this->movedPublishingFields[$viewName_single][$defaultField]))
					{
						if ($defaultField != 'access')
						{
							$items[$d_alignment][] = $defaultField;
						}
						elseif ($defaultField === 'access' && isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
						{
							$items[$d_alignment][] = $defaultField;
						}
					}
				}
			}
			// check if metadata is added to this view
			if (isset($this->metadataBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->metadataBuilder[$viewName_single]))
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
						$items_one .= "'". implode("',".PHP_EOL."\t'", $items['left'])."'";
					}
					if (ComponentbuilderHelper::checkArray($items['right']))
					{
						// there is already fields just add these
						if (strlen($items_one) > 3)
						{
							$items_one .= ",".PHP_EOL."\t'". implode("',".PHP_EOL."\t'", $items['right'])."'";
						}
						// no fields has been added yet
						else
						{
							$items_one .= "'". implode("',".PHP_EOL."\t'", $items['right'])."'";
						}
					}
					// only triger the info notice if there were custom fields targeted to the right alignment position.
					if ($fieldsAddedRight)
					{
						$this->app->enqueueMessage(JText::sprintf('Your field/s added to the <b>right</b> alignment position in the %s (publishing) tab was added to the <b>left</b>. Since we have metadata fields on the right. Fields can only be loaded to the right of the publishing tab if there is no metadata fields.', $viewName_single), 'Notice');
					}
					// set the publishing layout
					$this->setLayout($viewName_single, $tabCodeNameLeft, $items_one, 'layoutpublished');
					$items_one = true;
				}
				else
				{
					$items_one = false;				
				}
				// set the metadata layout
				$this->setLayout($viewName_single, $tabCodeNameRight, false, 'layoutmetadata');	
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
						$items_one = "'". implode("',".PHP_EOL."\t'", $items['left'])."'";
						// set the publishing layout
						$this->setLayout($viewName_single, $tabCodeNameLeft, $items_one, 'layoutpublished');
						$items_one = true;
					}
					// load right items that remain
					if (ComponentbuilderHelper::checkArray($items['right']))
					{
						// load all items
						$items_two = "'". implode("',".PHP_EOL."\t'", $items['right'])."'";
						// set the publishing layout
						$this->setLayout($viewName_single, $tabCodeNameRight, $items_two, 'layoutpublished');
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
			// only load this if needed
			if ($items_one || $items_two)
			{
				// check if the item has permissions.
				$publishingPer = array();
				$allToBeChekced = array('core.delete','core.edit.created_by','core.edit.state','core.edit.created');
				foreach ($allToBeChekced as $core_permission)
				{
					if ($coreLoad && isset($core[$core_permission]) && isset($this->permissionBuilder['global'][$core[$core_permission]]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core[$core_permission]]) && in_array($viewName_single,$this->permissionBuilder['global'][$core[$core_permission]]))
					{
						// set permissions.
						$publishingPer[] = "\$this->canDo->get('".$core[$core_permission]."')";
					}
					else
					{
						// set permissions.
						$publishingPer[] = "\$this->canDo->get('".$core_permission."')";
					}
				}
				$body .= PHP_EOL.PHP_EOL."\t<?php if (".implode(' || ', $publishingPer).") : ?>";
				// set the default publishing tab
				$body .= PHP_EOL."\t<?php echo JHtml::_('bootstrap.addTab', '".$viewName_single."Tab', '".$tabCodeNameLeft."', JText::_('".$tabLangName."', true)); ?>";
				$body .= PHP_EOL."\t\t".'<div class="row-fluid form-horizontal-desktop">';
				if ($items_one)
				{
					$body .= PHP_EOL."\t\t\t".'<div class="'.$classs.'">';
					$body .= PHP_EOL."\t\t\t\t<?php echo JLayoutHelper::render('".$viewName_single.".".$tabCodeNameLeft."', \$this); ?>";
					$body .= PHP_EOL."\t\t\t</div>";
				}
				if ($items_two)
				{
					$body .= PHP_EOL."\t\t\t".'<div class="'.$classs.'">';
					$body .= PHP_EOL."\t\t\t\t<?php echo JLayoutHelper::render('".$viewName_single.".".$tabCodeNameRight."', \$this); ?>";
					$body .= PHP_EOL."\t\t\t</div>";
				}
				$body .= PHP_EOL."\t\t</div>";
				$body .= PHP_EOL."\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
				$body .= PHP_EOL."\t<?php endif; ?>";
			}
			// make sure we dont load it to a view with the name component
			if ($viewName_single != 'component')
			{
				// set permissions tab lang
				$tabLangName = $langView.'_PERMISSION';
				// set permissions tab code name
				$tabCodeName = 'permissions';
				// add to lang array
				if (!isset($this->langContent[$this->lang][$tabLangName]))
				{
					$this->langContent[$this->lang][$tabLangName] = 'Permissions';
				}
				// set the permissions tab
				$body .= PHP_EOL.PHP_EOL."\t<?php if (\$this->canDo->get('core.admin')) : ?>";
				$body .= PHP_EOL."\t<?php echo JHtml::_('bootstrap.addTab', '".$viewName_single."Tab', '".$tabCodeName."', JText::_('".$tabLangName."', true)); ?>";
				$body .= PHP_EOL."\t\t".'<div class="row-fluid form-horizontal-desktop">';
				$body .= PHP_EOL."\t\t\t".'<div class="span12">';
				$body .= PHP_EOL."\t\t\t\t".'<fieldset class="adminform">';
				$body .= PHP_EOL."\t\t\t\t\t".'<div class="adminformlist">';
				$body .= PHP_EOL."\t\t\t\t\t<?php foreach (\$this->form->getFieldset('accesscontrol') as \$field): ?>";
				$body .= PHP_EOL."\t\t\t\t\t\t<div>";
				$body .= PHP_EOL."\t\t\t\t\t\t\t<?php echo \$field->label; echo \$field->input;?>";
				$body .= PHP_EOL."\t\t\t\t\t\t</div>";
				$body .= PHP_EOL."\t\t\t\t\t\t".'<div class="clearfix"></div>';
				$body .= PHP_EOL."\t\t\t\t\t<?php endforeach; ?>";
				$body .= PHP_EOL."\t\t\t\t\t</div>";
				$body .= PHP_EOL."\t\t\t\t</fieldset>";
				$body .= PHP_EOL."\t\t\t</div>";
				$body .= PHP_EOL."\t\t</div>";
				$body .= PHP_EOL."\t<?php echo JHtml::_('bootstrap.endTab'); ?>";
				$body .= PHP_EOL."\t<?php endif; ?>";
			}
			// end the tab set
			$body .= PHP_EOL.PHP_EOL."\t<?php echo JHtml::_('bootstrap.endTabSet'); ?>";
			$body .= PHP_EOL.PHP_EOL."\t<div>";
			$body .= PHP_EOL."\t\t".'<input type="hidden" name="task" value="'.$viewName_single.'.edit" />';
			$body .= PHP_EOL."\t\t<?php echo JHtml::_('form.token'); ?>";
			$body .= PHP_EOL."\t</div>";
			$body .= PHP_EOL."\t</div>";
			$body .= PHP_EOL."</div>";
			// check if left has been set
			if (strlen($leftside) > 0 )
			{
				$left = '<div class="span'.$sidewidth.'">'.$leftside.PHP_EOL."</div>";
			}
			else
			{
				$left = '';
			}
			// check if right has been set
			if (strlen($rightside) > 0 )
			{
				$right = '<div class="span'.$sidewidth.'">'.$rightside.PHP_EOL."</div>";
			}
			else
			{
				$right = '';
			}
			// set active tab and return
			return $header.$left.$body.$right.$footer;
		}
		return '';
	}
	
	public function setFadeInEfect(&$view)
	{
		// check if we should load the fade in affect
		if ($view['settings']->add_fadein == 1)
		{
			// set view name
			$fadein[] = "<script type=\"text/javascript\">";
			$fadein[] = "\t// waiting spinner";
			$fadein[] = "\tvar outerDiv = jQuery('body');";
			$fadein[] = "\tjQuery('<div id=\"loading\"></div>')";
			$fadein[] = "\t\t.css(\"background\", \"rgba(255, 255, 255, .8) url('components/com_".$this->fileContentStatic['###component###']."/assets/images/import.gif') 50% 15% no-repeat\")";
			$fadein[] = "\t\t.css(\"top\", outerDiv.position().top - jQuery(window).scrollTop())";
			$fadein[] = "\t\t.css(\"left\", outerDiv.position().left - jQuery(window).scrollLeft())";
			$fadein[] = "\t\t.css(\"width\", outerDiv.width())";
			$fadein[] = "\t\t.css(\"height\", outerDiv.height())";
			$fadein[] = "\t\t.css(\"position\", \"fixed\")";
			$fadein[] = "\t\t.css(\"opacity\", \"0.80\")";
			$fadein[] = "\t\t.css(\"-ms-filter\", \"progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)\")";
			$fadein[] = "\t\t.css(\"filter\", \"alpha(opacity = 80)\")";
			$fadein[] = "\t\t.css(\"display\", \"none\")";
			$fadein[] = "\t\t.appendTo(outerDiv);";
			$fadein[] = "\tjQuery('#loading').show();";
			$fadein[] = "\t// when page is ready remove and show";
			$fadein[] = "\tjQuery(window).load(function() {";
			$fadein[] = "\t\tjQuery('#".$this->fileContentStatic['###component###']."_loader').fadeIn('fast');";
			$fadein[] = "\t\tjQuery('#loading').hide();";
			$fadein[] = "\t});";
			$fadein[] = "</script>";
			$fadein[] = "<div id=\"".$this->fileContentStatic['###component###']."_loader\" style=\"display: none;\">";

			return implode(PHP_EOL, $fadein);
		}
		return "<div id=\"".$this->fileContentStatic['###component###']."_loader\">";
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
		$this->buildDynamique($target,$type,$layoutName);
		// add to front if needed
		if ($this->lang === 'both')
		{
			$target = array('site' => $viewName_single);
			$this->buildDynamique($target,$type,$layoutName);
		}
		if (ComponentbuilderHelper::checkString($items))
		{
			// ###LAYOUTITEMS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single.'_'.$layoutName]['###LAYOUTITEMS###'] = $items;
		}
		else
		{
			// ###LAYOUTITEMS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single.'_'.$layoutName]['###bogus###'] = 'boom';
		}
	}

	/**
	 * @param $args
	*/
	public function setLinkedView($args)
	{
		/**
		 * @var $viewId
		 * @var $viewName_single
		 * @var $codeName
		 * @var $layoutCodeName
		 * @var $key
		 * @var $parentKey
		 * @var $addNewButon
		 */
		extract($args, EXTR_PREFIX_SAME, "oops");
		$single = '';
		$list 	= '';
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
			$head = $this->setListHeadLinked($single,$list,$addNewButon);
			$body = $this->setListBodyLinked($single,$list,$viewName_single);
			$functionName = ComponentbuilderHelper::safeString($codeName,'F');
			// ###LAYOUTITEMSTABLE### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSTABLE###'] = $head.$body;
			// ###LAYOUTITEMSHEADER### <<<DYNAMIC>>>
			$headerscript = '$edit	= "index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$list.'&task='.$single.'.edit";';
			if ($addNewButon)
			{
				$headerscript .= PHP_EOL.'$ref	= ($id) ? "&ref='.$viewName_single.'&refid=".$id : "";';
				$headerscript .= PHP_EOL.'$new	= "index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$single.'&layout=edit".$ref;';
				$headerscript .= PHP_EOL.'$can	= '.$this->fileContentStatic['###Component###'].'Helper::getActions('."'".$single."'".');';
			}
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSHEADER###'] = $headerscript;
			// ###LINKEDVIEWITEMS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWITEMS###'] .=  PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get Linked view data".PHP_EOL."\t\t\$this->".$codeName."\t\t= \$this->get('".$functionName."');";
			// ###LINKEDVIEWTABLESCRIPTS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWTABLESCRIPTS###'] = $this->setFootableScripts();
			if(strpos($parentKey, '-R>') !== false || strpos($parentKey, '-A>') !== false)
			{
				list($parent_key) = explode('-',$parentKey);
			}
			elseif(strpos($parentKey, '-OR>') !== false)
			{
				// this is not good... (TODO)
				$parent_keys = explode('-OR>',$parentKey);
			}
			else
			{
				$parent_key = $parentKey;
			}
			
			if(strpos($key, '-R>') !== false || strpos($key, '-A>') !== false)
			{
				list($_key) = explode('-',$key);
			}
			elseif(strpos($key, '-OR>') !== false)
			{
				$_key = str_replace('-OR>', '',$key);
			}
			else
			{
				$_key = $key;
			}
			// ###LINKEDVIEWGLOBAL### <<<DYNAMIC>>>
			if (isset($parent_keys) && ComponentbuilderHelper::checkArray($parent_keys))
			{
				$globalKey = array();
				foreach ($parent_keys as $parent_key)
				{
					$globalKey[$parent_key] = ComponentbuilderHelper::safeString($_key.$this->uniquekey(4));
					$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWGLOBAL###'] .= PHP_EOL."\t\t\$this->".$globalKey[$parent_key]." = \$item->".$parent_key.";";
				}
			}
			else
			{
				// set the global key
				$globalKey = ComponentbuilderHelper::safeString($_key.$this->uniquekey(4));
				$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWGLOBAL###'] .= PHP_EOL."\t\t\$this->".$globalKey." = \$item->".$parent_key.";";
			}
			// ###LINKEDVIEWMETHODS### <<<DYNAMIC>>>
			$this->fileContentDynamic[$viewName_single]['###LINKEDVIEWMETHODS###'] .= $this->setListQueryLinked($single, $list, $functionName, $key, $_key, $parentKey, $parent_key, $globalKey);
		}
		else
		{
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSTABLE###'] = 'oops! error.....';
			$this->fileContentDynamic[$viewName_single.'_'.$layoutCodeName]['###LAYOUTITEMSHEADER###'] = '';
		}
	}

	/**
	 * @param bool $init
	 * @param string $document
	 * @return string
     */
	public function setFootableScripts($init = true, $document = '$document')
	{
		if (!isset($this->footableVersion) || 2 == $this->footableVersion) // loading version 2
		{
			$foo = PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Add the CSS for Footable.";
			$foo .= PHP_EOL."\t\t".$document."->addStyleSheet(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/css/footable.core.min.css');";
			$foo .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Use the Metro Style";
			$foo .= PHP_EOL."\t\tif (!isset(\$this->fooTableStyle) || 0 == \$this->fooTableStyle)";
			$foo .= PHP_EOL."\t\t{";
			$foo .= PHP_EOL."\t\t\t".$document."->addStyleSheet(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/css/footable.metro.min.css');";
			$foo .= PHP_EOL."\t\t}";
			$foo .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Use the Legacy Style.";
			$foo .= PHP_EOL."\t\telseif (isset(\$this->fooTableStyle) && 1 == \$this->fooTableStyle)";
			$foo .= PHP_EOL."\t\t{";
			$foo .= PHP_EOL."\t\t\t".$document."->addStyleSheet(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/css/footable.standalone.min.css');";
			$foo .= PHP_EOL."\t\t}";
			$foo .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Add the JavaScript for Footable";
			$foo .= PHP_EOL."\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.js');";
			$foo .= PHP_EOL."\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.sort.js');";
			$foo .= PHP_EOL."\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.filter.js');";
			$foo .= PHP_EOL."\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.paginate.js');";
			if ($init)
			{
				$foo .= PHP_EOL.PHP_EOL."\t\t".'$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery('."'.footable'".').footable(); }); jQuery('."'.nav-tabs'".').on('."'click'".', '."'li'".', function() { setTimeout(tableFix, 10); }); }); function tableFix() { jQuery('."'.footable'".').trigger('."'footable_resize'".'); }";';
				$foo .= PHP_EOL."\t\t\$document->addScriptDeclaration(\$footable);".PHP_EOL;
			}
		}
		elseif (3 == $this->footableVersion) // loading version 3
		{
			
			$foo = PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Add the CSS for Footable";
			$foo .= PHP_EOL."\t\t".$document."->addStyleSheet('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');";
			$foo .= PHP_EOL."\t\t".$document."->addStyleSheet(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/css/footable.standalone.min.css');";
			$foo .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Add the JavaScript for Footable (adding all funtions)";
			$foo .= PHP_EOL."\t\t".$document."->addScript(JURI::root() .'media/com_".$this->fileContentStatic['###component###']."/footable/js/footable.min.js');";
			if ($init)
			{
				$foo .= PHP_EOL.PHP_EOL."\t\t".'$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery('."'.footable'".').footable();});});";';
				$foo .= PHP_EOL."\t\t\$document->addScriptDeclaration(\$footable);".PHP_EOL;
			}
		}
		return $foo;
	}

	/**
	 * @param $viewName_single
	 * @param $viewName_list
	 * @param $refview
	 * @return string
	*/
	public function setListBodyLinked($viewName_single, $viewName_list, $refview)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic['###Component###'].'Helper';
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// setup correct core target
			$coreLoad = false;
			if (isset($this->permissionCore[$viewName_single]))
			{
				$core = $this->permissionCore[$viewName_single];
				$coreLoad = true;
			}
			$counter = 0;
			// add the default
			$body = PHP_EOL."<tbody>";
			$body .= PHP_EOL."<?php foreach (\$items as \$i => \$item): ?>";
			$body .= PHP_EOL."\t<?php";
			$body .= PHP_EOL."\t\t\$canCheckin = \$user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$user->id || \$item->checked_out == 0;";
			$body .= PHP_EOL."\t\t\$userChkOut = JFactory::getUser(\$item->checked_out);";
			$body .= PHP_EOL."\t\t\$canDo = ".$Helper."::getActions('".$viewName_single."',\$item,'".$viewName_list."');";
			$body .= PHP_EOL."\t?>";
			$body .= PHP_EOL."\t".'<tr>';
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (isset($this->doNotEscape[$viewName_list]))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				$counter++;
				$checkoutTriger = false;
				if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && isset($item['custom']['table']) && ComponentbuilderHelper::checkString($item['custom']['table']))
				{
					$item['id'] = $item['code'];
					if (!$item['multiple'])
					{
						$item['code'] = $item['code'].'_'.$item['custom']['text'];
					}
				}
				// check if translated vlaue is used
				if (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list])
					&& array_key_exists($item['code'],$this->selectionTranslationFixBuilder[$viewName_list]))
				{
					$itemCode = '<?php echo JText::_($item->'.$item['code'].'); ?>';
				}
				elseif ($item['custom']['text'] === 'user')
				{
					$itemCode = '<?php echo JFactory::getUser((int)$item->'.$item['code'].')->name; ?>';
				}
				elseif ($doNotEscape)
				{
					if (in_array($item['code'], $this->doNotEscape[$viewName_list]))
					{
						$itemCode = '<?php echo $item->'.$item['code'].'; ?>';
					}
					else
					{
						$itemCode = '<?php echo $displayData->escape($item->'.$item['code'].'); ?>';
					}
				}
				else
				{
					$itemCode = '<?php echo $displayData->escape($item->'.$item['code'].'); ?>';
				}

				if ($item['link'])
				{
					// allways rest custom links
					$customAdminView = '';
					// if to be linked
					if ($item['type'] === 'category' && !$item['title'])
					{
						$otherViews = $this->catCodeBuilder[$viewName_single]['views'];
						// category and linked
						$body .= PHP_EOL."\t\t".'<td class="nowrap">';
						$body .= PHP_EOL."\t\t\t<?php if (\$user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$otherViews.".category.' . (int)\$item->".$item['code'].")): ?>";
						$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->'.$item['code'].'; ?>&extension=com_'.$this->fileContentStatic['###component###'].'.'.$otherViews.'"><?php echo $displayData->escape($item->category_title); ?></a>';
						$body .= PHP_EOL."\t\t\t<?php else: ?>";
						$body .= PHP_EOL."\t\t\t\t<?php echo \$displayData->escape(\$item->category_title); ?>";
						$body .= PHP_EOL."\t\t\t<?php endif; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					elseif ($item['type'] === 'user' && !$item['title'])
					{
						// user and linked
						$body .= PHP_EOL."\t\t<?php \$".$item['code']."User = JFactory::getUser(\$item->".$item['code']."); ?>";
						$body .= PHP_EOL."\t\t".'<td class="nowrap">';
						$body .= PHP_EOL."\t\t\t<?php if (\$user->authorise('core.edit', 'com_users')): ?>";
						$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['code'].' ?>"><?php echo $'.$item['code'].'User->name; ?></a>';
						$body .= PHP_EOL."\t\t\t<?php else: ?>";
						$body .= PHP_EOL."\t\t\t\t<?php echo \$".$item['code']."User->name; ?>";
						$body .= PHP_EOL."\t\t\t<?php endif; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					else
					{
						$add = true;
						if (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] != 'user' && !$item['title'])
						{
							if ($refview === $item['custom']['view'])
							{
								// normal not linked
								$body .= PHP_EOL."\t\t<td>";
								$body .= PHP_EOL."\t\t\t".$itemCode;
								$body .= PHP_EOL."\t\t</td>";

								$add = false;
							}
							else
							{
								// link to that item instead
								$link = 'index.php?option='.$item['custom']['component'].'&view='.$item['custom']['views'].'&task='.$item['custom']['view'].'.edit&id=<?php echo $item->'.$item['id'].'; ?>&ref='.$refview.'&refid=<?php echo $id; ?>';

								
								$coreLoadLink = false;
								if (isset($this->permissionCore[$item['custom']['view']]))
								{
									$coreLink = $this->permissionCore[$item['custom']['view']];
									$coreLoadLink = true;
								}
								// check if the item has permissions.
								if ($coreLoadLink && isset($this->permissionBuilder[$coreLink['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$coreLink['core.edit']]) && in_array($item['custom']['view'],$this->permissionBuilder[$coreLink['core.edit']]))
								{
									$accessCheck = "\$user->authorise('".$coreLink['core.edit']."', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
								}
								else
								{
									$accessCheck = "\$user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###'].".".$item['custom']['view'].".' . (int)\$item->".$item['id'].")";
								}
							}
						}
						elseif (isset($item['custom']) && ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user' && !$item['title'])
						{
							// user and linked
							$body .= PHP_EOL."\t\t<?php \$_".$item['id']." = JFactory::getUser(\$item->".$item['id']."); ?>";
							$body .= PHP_EOL."\t\t".'<td class="nowrap">';
							$body .= PHP_EOL."\t\t\t<?php if (\$user->authorise('core.edit', 'com_users')): ?>";
							$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $_'.$item['id'].'->name; ?></a>';
							$body .= PHP_EOL."\t\t\t<?php else: ?>";
							$body .= PHP_EOL."\t\t\t\t<?php echo \$_".$item['id']."->name; ?>";
							$body .= PHP_EOL."\t\t\t<?php endif; ?>";
							$body .= PHP_EOL."\t\t</td>";

							$add = false;
						}
						else
						{
							$link = '<?php echo $edit; ?>&id=<?php echo $item->id; ?>&ref='.$refview.'&refid=<?php echo $id; ?>';
							// check if custom links should be added to this list views
							if (isset($this->customAdminViewListLink[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customAdminViewListLink[$viewName_list]) && $firstTimeBeingAdded)
							{
								// make sure the custom links are only added once
								$firstTimeBeingAdded = false;
								// start building the links
								$customAdminView = PHP_EOL."\t\t\t".'<div class="btn-group">';
								foreach ($this->customAdminViewListLink[$viewName_list] as $customLinkView)
								{
                                                                        $customAdminView .= PHP_EOL."\t\t\t<?php if (\$canDo->get('".$customLinkView['link'].".access')): ?>";
									$customAdminView .= PHP_EOL."\t\t\t\t".'<a class="hasTooltip btn btn-mini" href="index.php?option=com_'.$this->fileContentStatic['###component###'].'&view='.$customLinkView['link'].'&id=<?php echo $item->id; ?>&ref='.$refview.'&refid=<?php echo $id; ?>" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>" ><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= PHP_EOL."\t\t\t<?php else: ?>";
									$customAdminView .= PHP_EOL."\t\t\t\t".'<a class="hasTooltip btn btn-mini disabled" href="#" title="<?php echo JText::_('."'COM_".$this->fileContentStatic['###COMPONENT###'].'_'.$customLinkView['NAME']."'".'); ?>"><span class="icon-'.$customLinkView['icon'].'"></span></a>';
                                                                        $customAdminView .= PHP_EOL."\t\t\t<?php endif; ?>";
								}
								$customAdminView .= PHP_EOL."\t\t\t".'</div>';

							}
							// check if the item has permissions.
							if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
							{
								// set permissions.
								$accessCheck = "\$canDo->get('".$core['core.edit']."')";
							}
							else
							{
								// set permissions.
								$accessCheck = "\$canDo->get('core.edit')";
							}
							// triger the checked out script to be added
							$checkoutTriger = true;
						}

						if ($add)
						{
							// set as linked
							$body .= PHP_EOL."\t\t".'<td class="nowrap">';
							$body .= PHP_EOL."\t\t\t<?php if (".$accessCheck."): ?>";
							$body .= PHP_EOL."\t\t\t\t".'<a href="'.$link.'">'.$itemCode.'</a>';
							if ($checkoutTriger)
							{
								$body .= PHP_EOL."\t\t\t\t\t<?php if (\$item->checked_out): ?>";
								$body .= PHP_EOL."\t\t\t\t\t\t<?php echo JHtml::_('jgrid.checkedout', \$i, \$userChkOut->name, \$item->checked_out_time, '".$viewName_list.".', \$canCheckin); ?>";
								$body .= PHP_EOL."\t\t\t\t\t<?php endif; ?>";
							}
							$body .= PHP_EOL."\t\t\t<?php else: ?>";
							$body .= PHP_EOL."\t\t\t\t".'<div class="name">'.$itemCode.'</div>';
							$body .= PHP_EOL."\t\t\t<?php endif; ?>";
                                                        $body .= $customAdminView;
							$body .= PHP_EOL."\t\t</td>";
						}
					}
				}
				else
				{
					if ($item['type'] === 'category')
					{
						$body .= PHP_EOL."\t\t<td>";
						$body .= PHP_EOL."\t\t\t<?php echo \$displayData->escape(\$item->category_title); ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					elseif (ComponentbuilderHelper::checkArray($item['custom']) && $item['custom']['extends'] === 'user')
					{
						// custom user and linked
						$body .= PHP_EOL."\t\t<?php \$_".$item['code']." = JFactory::getUser(\$item->".$item['id']."); ?>";
						$body .= PHP_EOL."\t\t".'<td>';
						$body .= PHP_EOL."\t\t\t<?php if (\$user->authorise('core.edit', 'com_users')): ?>";
						$body .= PHP_EOL."\t\t\t\t".'<a href="index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'.$item['id'].' ?>"><?php echo $_'.$item['code'].'->name; ?></a>';
						$body .= PHP_EOL."\t\t\t<?php else: ?>";
						$body .= PHP_EOL."\t\t\t\t<?php echo \$_".$item['code']."->name; ?>";
						$body .= PHP_EOL."\t\t\t<?php endif; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					elseif ($item['type'] === 'user')
					{
						// user name only
						$body .= PHP_EOL."\t\t<?php \$".$item['code']."User = JFactory::getUser(\$item->".$item['code']."); ?>";
						$body .= PHP_EOL."\t\t".'<td class="nowrap">';
						$body .= PHP_EOL."\t\t\t<?php echo \$".$item['code']."User->name; ?>";
						$body .= PHP_EOL."\t\t</td>";
					}
					else
					{
						// normal not linked
						$body .= PHP_EOL."\t\t<td>";
						$body .= PHP_EOL."\t\t\t".$itemCode;
						$body .= PHP_EOL."\t\t</td>";
					}
				}
			}
			$counter = $counter + 2;
			$data_value =  (3 == $this->footableVersion) ? 'data-sort-value':'data-value';
			// add the defaults 
			$body .= PHP_EOL."\t\t<?php if (\$item->published == 1):?>";
                        $body .= PHP_EOL."\t\t\t".'<td class="center"  '.$data_value.'="1">';
                        $body .= PHP_EOL."\t\t\t\t".'<span class="status-metro status-published" title="<?php echo JText::_('."'".$this->langPrefix."_PUBLISHED'".');  ?>">';
                        $body .= PHP_EOL."\t\t\t\t\t".'<?php echo JText::_('."'".$this->langPrefix."_PUBLISHED'".'); ?>';
                        $body .= PHP_EOL."\t\t\t\t".'</span>';
                        $body .= PHP_EOL."\t\t\t".'</td>';

			$body .= PHP_EOL."\t\t<?php elseif (\$item->published == 0):?>";
                        $body .= PHP_EOL."\t\t\t".'<td class="center"  '.$data_value.'="2">';
                        $body .= PHP_EOL."\t\t\t\t".'<span class="status-metro status-inactive" title="<?php echo JText::_('."'".$this->langPrefix."_INACTIVE'".');  ?>">';
                        $body .= PHP_EOL."\t\t\t\t\t".'<?php echo JText::_('."'".$this->langPrefix."_INACTIVE'".'); ?>';
                        $body .= PHP_EOL."\t\t\t\t".'</span>';
                        $body .= PHP_EOL."\t\t\t".'</td>';

			$body .= PHP_EOL."\t\t<?php elseif (\$item->published == 2):?>";
                        $body .= PHP_EOL."\t\t\t".'<td class="center"  '.$data_value.'="3">';
                        $body .= PHP_EOL."\t\t\t\t".'<span class="status-metro status-archived" title="<?php echo JText::_('."'".$this->langPrefix."_ARCHIVED'".');  ?>">';
                        $body .= PHP_EOL."\t\t\t\t\t".'<?php echo JText::_('."'".$this->langPrefix."_ARCHIVED'".'); ?>';
                        $body .= PHP_EOL."\t\t\t\t".'</span>';
                        $body .= PHP_EOL."\t\t\t".'</td>';

			$body .= PHP_EOL."\t\t<?php elseif (\$item->published == -2):?>";
                        $body .= PHP_EOL."\t\t\t".'<td class="center"  '.$data_value.'="4">';
                        $body .= PHP_EOL."\t\t\t\t".'<span class="status-metro status-trashed" title="<?php echo JText::_('."'".$this->langPrefix."_TRASHED'".');  ?>">';
                        $body .= PHP_EOL."\t\t\t\t\t".'<?php echo JText::_('."'".$this->langPrefix."_TRASHED'".'); ?>';
                        $body .= PHP_EOL."\t\t\t\t".'</span>';
                        $body .= PHP_EOL."\t\t\t".'</td>';
                        $body .= PHP_EOL."\t\t".'<?php endif; ?>';

			$body .= PHP_EOL."\t\t".'<td class="nowrap center hidden-phone">';
			$body .= PHP_EOL."\t\t\t<?php echo \$item->id; ?>";
			$body .= PHP_EOL."\t\t</td>";
			$body .= PHP_EOL."\t</tr>";
			$body .= PHP_EOL."<?php endforeach; ?>";
			$body .= PHP_EOL."</tbody>";
			if (2 == $this->footableVersion)
			{
				$body .= PHP_EOL.'<tfoot class="hide-if-no-paging">';
				$body .= PHP_EOL."\t".'<tr>';
				$body .= PHP_EOL."\t\t".'<td colspan="'.$counter.'">';
				$body .= PHP_EOL."\t\t\t".'<div class="pagination pagination-centered"></div>';
				$body .= PHP_EOL."\t\t".'</td>';
				$body .= PHP_EOL."\t".'</tr>';
				$body .= PHP_EOL.'</tfoot>';
			}
                        $body .= PHP_EOL.'</table>';
			$body .= PHP_EOL.'<?php else: ?>';
			$body .= PHP_EOL."\t".'<div class="alert alert-no-items">';
			$body .= PHP_EOL."\t\t".'<?php echo JText::_('."'JGLOBAL_NO_MATCHING_RESULTS'".'); ?>';
			$body .= PHP_EOL."\t".'</div>';
			$body .= PHP_EOL.'<?php endif; ?>';
			// return the build
			return $body;
		}
		return '';
	}

	public function setListHeadLinked($viewName_single,$viewName_list,$addNewButon)
	{
		if (isset($this->listBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->listBuilder[$viewName_list]))
		{
			// component helper name
			$Helper = $this->fileContentStatic['###Component###'].'Helper';
			$head = '';
			// only add new button if set
			if ($addNewButon)
			{
				// setup correct core target
				$coreLoad = false;
				if (isset($this->permissionCore[$viewName_single]))
				{
					$core = $this->permissionCore[$viewName_single];
					$coreLoad = true;
				}
				// check if the item has permissions.
				if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
				{
					// set permissions.
					$accessCheck = "\$can->get('".$core['core.create']."')";
				}
				else
				{
					// set permissions.
					$accessCheck = "\$can->get('core.create')";
				}
				// add a button for new
				$head = '<?php if ('.$accessCheck.'): ?>';
				$head .= PHP_EOL."\t".'<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo JText::_('."'".$this->langPrefix."_NEW'".'); ?></a><br /><br />';
				$head .= PHP_EOL.'<?php endif; ?>'.PHP_EOL;
			}
			$head .= '<?php if ('.$Helper.'::checkArray($items)): ?>';
			// set the style for V2
			$metro_blue = (2 == $this->footableVersion) ? ' metro-blue':'';
			// set the toggle for V3
			$toggle = (3 == $this->footableVersion) ? ' data-show-toggle="true" data-toggle-column="first"':'';
			// set paging
			$paging = (2 == $this->footableVersion) ?' data-page-size="20" data-filter="#filter_'.$viewName_list.'"':' data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true"';
			// add html fix for V3
			$htmlFix = (3 == $this->footableVersion) ? ' data-type="html" data-sort-use="text"':'';
			$head .= PHP_EOL.'<table class="footable table data '.$viewName_list.$metro_blue.'"'.$toggle.$paging.'>';
			$head .= PHP_EOL."<thead>";
			// main lang prefix
			$langView = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($viewName_single,'U');
			// set status lang
			$statusLangName = $langView.'_STATUS';
			// set id lang
			$idLangName = $langView.'_ID';
			// make sure only first link is used as togeler
			$firstLink = true;
			// add to lang array
			if (!isset($this->langContent[$this->lang][$statusLangName]))
			{
				$this->langContent[$this->lang][$statusLangName] = 'Status';
			}
			// add to lang array
			if (!isset($this->langContent[$this->lang][$idLangName ]))
			{
				$this->langContent[$this->lang][$idLangName] = 'Id';
			}
 			$head .= PHP_EOL."\t<tr>";
			// set controller for data hiding options
			$controller = 1;
			// build the dynamic fields
			foreach ($this->listBuilder[$viewName_list] as $item)
			{
				$setin =  (2 == $this->footableVersion) ? ' data-hide="phone"':' data-breakpoints="xs sm"';
				if ($controller > 3)
				{
					$setin = (2 == $this->footableVersion) ? ' data-hide="phone,tablet"' : ' data-breakpoints="xs sm md"';
				}

				if ($controller > 6)
				{
					$setin = (2 == $this->footableVersion) ? ' data-hide="all"':' data-breakpoints="all"';
				}

				if ($item['link'] && $firstLink)
				{
					$setin = (2 == $this->footableVersion) ? ' data-toggle="true"':'';
					$firstLink = false;
				}
				$head .= PHP_EOL."\t\t<th".$setin.$htmlFix.">";
				$head .= PHP_EOL."\t\t\t<?php echo JText::_('".$item['lang']."'); ?>";
				$head .= PHP_EOL."\t\t</th>";
				$controller++;
			}
			// set some V3 attr
			$data_hide = (2 == $this->footableVersion) ? 'data-hide="phone,tablet"' : 'data-breakpoints="xs sm md"';
			$data_type = (2 == $this->footableVersion) ? 'data-type="numeric"':'data-type="number"';
			// set default
 			$head .= PHP_EOL."\t\t".'<th width="10" '.$data_hide.'>';
   			$head .= PHP_EOL."\t\t\t<?php echo JText::_('".$statusLangName."'); ?>";
 			$head .= PHP_EOL."\t\t</th>";
 			$head .= PHP_EOL."\t\t".'<th width="5" '.$data_type.' '.$data_hide.'>';
   			$head .= PHP_EOL."\t\t\t<?php echo JText::_('".$idLangName."'); ?>";
 			$head .= PHP_EOL."\t\t</th>";
 			$head .= PHP_EOL."\t</tr>";
			$head .= PHP_EOL."</thead>";

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
		$query = PHP_EOL.PHP_EOL."\t/**";
		$query .= PHP_EOL."\t* Method to get list data.";
		$query .= PHP_EOL."\t*";
		$query .= PHP_EOL."\t* @return mixed  An array of data items on success, false on failure.";
		$query .= PHP_EOL."\t*/";
		$query .= PHP_EOL."\tpublic function get".$functionName."()";
		$query .= PHP_EOL."\t{";
		// setup the query
		$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the user object.";
		$query .= PHP_EOL."\t\t\$user = JFactory::getUser();";
		$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
		$query .= PHP_EOL."\t\t\$db = JFactory::getDBO();";
		$query .= PHP_EOL."\t\t\$query = \$db->getQuery(true);";
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Select some fields";
		$query .= PHP_EOL."\t\t\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL."\t\t\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." From the ".$this->fileContentStatic['###component###']."_".$viewName_single." table";
		$query .= PHP_EOL."\t\t\$query->from(\$db->quoteName('#__".$this->fileContentStatic['###component###']."_".$viewName_single."', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL."\t\t\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a.".$categoryCodeName."') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
                $query .= $this->getCustomScriptBuilder('php_getlistquery', $viewName_single, PHP_EOL.PHP_EOL);
		// add the custom fields query
		$query .= $this->setCustomQuery($viewName_list, $viewName_single);
		if (ComponentbuilderHelper::checkString($globalKey) &&
			$key && strpos($key,'-R>') === false && strpos($key,'-A>') === false && strpos($key,'-OR>') === false &&
			$parentKey && strpos($parentKey,'-R>') === false && strpos($parentKey,'-A>') === false && strpos($parentKey,'-OR>') === false)
		{
			$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." global.";
			$query .= PHP_EOL."\t\t\$".$globalKey." = \$this->".$globalKey.";";
			$query .= PHP_EOL."\t\tif (is_numeric(\$".$globalKey." ))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$query->where('a.".$key." = ' . (int) \$".$globalKey." );";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL."\t\telseif (is_string(\$".$globalKey."))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$query->where('a.".$key." = ' . \$db->quote(\$".$globalKey."));";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL."\t\telse";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$query->where('a.".$key." = -5');";
			$query .= PHP_EOL."\t\t}";
		}
		elseif (strpos($parentKey,'-OR>') !== false || strpos($key,'-OR>') !== false)
		{
			// get both strings
			if (strpos($key,'-OR>') !== false)
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
					$ORquery['i'][] = "a.".$ORkey." = ' . (int) \$".$_globalKey;
					$ORquery['s'][] = "a.".$ORkey." = ' . \$db->quote(\$".$_globalKey.")";
				}
				$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by ".$_globalKey." global.";
				$query .= PHP_EOL."\t\t\$".$_globalKey." = \$this->".$_globalKey.";";
				$query .= PHP_EOL."\t\tif (is_numeric(\$".$_globalKey." ))";
				$query .= PHP_EOL."\t\t{";
				$query .= PHP_EOL."\t\t\t\$query->where('" . implode(" . ' OR ", $ORquery['i']) . ", ' OR');";
				$query .= PHP_EOL."\t\t}";
				$query .= PHP_EOL."\t\telseif (is_string(\$".$_globalKey."))";
				$query .= PHP_EOL."\t\t{";
				$query .= PHP_EOL."\t\t\t\$query->where('" . implode(" . ' OR ", $ORquery['s']) . ", ' OR');";
				$query .= PHP_EOL."\t\t}";
				$query .= PHP_EOL."\t\telse";
				$query .= PHP_EOL."\t\t{";
				$query .= PHP_EOL."\t\t\t\$query->where('a.".$ORkey." = -5');";
				$query .= PHP_EOL."\t\t}";
			}
		}
		if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
		{
			$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Join over the asset groups.";
			$query .= PHP_EOL."\t\t\$query->select('ag.title AS access_level');";
			$query .= PHP_EOL."\t\t\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by access level.";
			$query .= PHP_EOL."\t\tif (\$access = \$this->getState('filter.access'))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$query->where('a.access = ' . (int) \$access);";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Implement View Level Access";
			$query .= PHP_EOL."\t\tif (!\$user->authorise('core.options', 'com_".$this->fileContentStatic['###component###']."'))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= PHP_EOL."\t\t\t\$query->where('a.access IN (' . \$groups . ')');";
			$query .= PHP_EOL."\t\t}";
		}
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Order the results by ordering";
		$query .= PHP_EOL."\t\t\$query->order('a.published  ASC');";
		$query .= PHP_EOL."\t\t\$query->order('a.ordering  ASC');";
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Load the items";
		$query .= PHP_EOL."\t\t\$db->setQuery(\$query);";
		$query .= PHP_EOL."\t\t\$db->execute();";
		$query .= PHP_EOL."\t\tif (\$db->getNumRows())";
		$query .= PHP_EOL."\t\t{";
		$query .= PHP_EOL."\t\t\t\$items = \$db->loadObjectList();";
		// ###STORE_METHOD_FIX### <<<DYNAMIC>>>
		$query .= $this->setGetItemsMethodStringFix($viewName_single,$this->fileContentStatic['###Component###'],"\t");
		// ###SELECTIONTRANSLATIONFIX### <<<DYNAMIC>>>
		$query .= $this->setSelectionTranslationFix($viewName_list,$this->fileContentStatic['###Component###'],"\t");
		// filter by child repetable field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($key,'-R>') !== false && strpos($key,'-A>') === false)
		{
			list($field,$target) = explode('-R>',$key);
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." in this Repetable Field";
			$query .= PHP_EOL."\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$items) && isset(\$this->".$globalKey."))";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\tforeach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL."\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\tif (isset(\$item->".$field.") && ".$this->fileContentStatic['###Component###']."Helper::checkJson(\$item->".$field."))";
			$query .= PHP_EOL."\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\t\$tmpArray = json_decode(\$item->".$field.",true);";
			$query .= PHP_EOL."\t\t\t\t\t\tif (!isset(\$tmpArray['".$target."']) || !".$this->fileContentStatic['###Component###']."Helper::checkArray(\$tmpArray['".$target."']) || !in_array(\$this->".$globalKey.", \$tmpArray['".$target."']))";
			$query .= PHP_EOL."\t\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= PHP_EOL."\t\t\t\t\t\t\tcontinue;";
			$query .= PHP_EOL."\t\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t\telse";
			$query .= PHP_EOL."\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= PHP_EOL."\t\t\t\t\t\tcontinue;";
			$query .= PHP_EOL."\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t\telse";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\treturn false;";
			$query .= PHP_EOL."\t\t\t}";
		}
		// filter by child array field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($key,'-R>') === false && strpos($key,'-A>') !== false)
		{
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." Array Field";
			$query .= PHP_EOL."\t\t\t\$".$globalKey." = \$this->".$globalKey.";";
			$query .= PHP_EOL."\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$items) && \$".$globalKey.")";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\tforeach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL."\t\t\t\t{";
			list($bin,$target) = explode('-A>',$key);
			if (ComponentbuilderHelper::checkString($target))
			{				
				$query .= PHP_EOL."\t\t\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkJson(\$item->".$target."))";
				$query .= PHP_EOL."\t\t\t\t\t{";
				$query .= PHP_EOL."\t\t\t\t\t\t\$item->".$target." = json_decode(\$item->".$target.", true);";
				$query .= PHP_EOL."\t\t\t\t\t}";
				$query .= PHP_EOL."\t\t\t\t\telseif (!isset(\$item->".$target.") || !".$this->fileContentStatic['###Component###']."Helper::checkArray(\$item->".$target."))";
				$query .= PHP_EOL."\t\t\t\t\t{";
				$query .= PHP_EOL."\t\t\t\t\t\tunset(\$items[\$nr]);";
				$query .= PHP_EOL."\t\t\t\t\t\tcontinue;";
				$query .= PHP_EOL."\t\t\t\t\t}";
				$query .= PHP_EOL."\t\t\t\t\tif (!in_array(\$".$globalKey.",\$item->".$target."))";
			}
			else
			{			
				$query .= PHP_EOL."\t\t\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkJson(\$item->".$_key."))";
				$query .= PHP_EOL."\t\t\t\t\t{";
				$query .= PHP_EOL."\t\t\t\t\t\t\$item->".$_key." = json_decode(\$item->".$_key.", true);";
				$query .= PHP_EOL."\t\t\t\t\t}";
				$query .= PHP_EOL."\t\t\t\t\telseif (!isset(\$item->".$_key.") || !".$this->fileContentStatic['###Component###']."Helper::checkArray(\$item->".$_key."))";
				$query .= PHP_EOL."\t\t\t\t\t{";
				$query .= PHP_EOL."\t\t\t\t\t\tunset(\$items[\$nr]);";
				$query .= PHP_EOL."\t\t\t\t\t\tcontinue;";
				$query .= PHP_EOL."\t\t\t\t\t}";
				$query .= PHP_EOL."\t\t\t\t\tif (!in_array(\$".$globalKey.",\$item->".$_key."))";
			}
			$query .= PHP_EOL."\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= PHP_EOL."\t\t\t\t\t\tcontinue;";
			$query .= PHP_EOL."\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t\telse";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\treturn false;";
			$query .= PHP_EOL."\t\t\t}";

		}
		// filter by parent repetable field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($parentKey,'-R>') !== false && strpos($parentKey,'-A>') === false)
		{
			list($bin,$target) = explode('-R>',$parentKey);
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Filter by ".$_key." Repetable Field";
			$query .= PHP_EOL."\t\t\t\$".$globalKey." = json_decode(\$this->".$globalKey.",true);";
			$query .= PHP_EOL."\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$items) && isset(\$".$globalKey.") && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."))";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\tforeach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL."\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\tif (\$item->".$_key." && isset(\$".$globalKey."['".$target."']) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."['".$target."']))";
			$query .= PHP_EOL."\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\tif (!in_array(\$item->".$_key.",\$".$globalKey."['".$target."']))";
			$query .= PHP_EOL."\t\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= PHP_EOL."\t\t\t\t\t\t\tcontinue;";
			$query .= PHP_EOL."\t\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t\telse";
			$query .= PHP_EOL."\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= PHP_EOL."\t\t\t\t\t\tcontinue;";
			$query .= PHP_EOL."\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t\telse";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\treturn false;";
			$query .= PHP_EOL."\t\t\t}";
		}
		// filter by parent array field values
		if (ComponentbuilderHelper::checkString($globalKey) && $key && strpos($parentKey,'-R>') === false && strpos($parentKey,'-A>') !== false)
		{
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Filter by ".$globalKey." Array Field";
			$query .= PHP_EOL."\t\t\t\$".$globalKey." = \$this->".$globalKey.";";
			$query .= PHP_EOL."\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$items) && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."))";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\tforeach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL."\t\t\t\t{";
			list($bin,$target) = explode('-A>',$parentKey);
			if (ComponentbuilderHelper::checkString($target))
			{
				$query .= PHP_EOL."\t\t\t\t\tif (\$item->".$_key." && ".$this->fileContentStatic['###Component###']."Helper::checkArray(\$".$globalKey."['".$target."']))";
				$query .= PHP_EOL."\t\t\t\t\t{";
				$query .= PHP_EOL."\t\t\t\t\t\tif (!in_array(\$item->".$_key.",\$".$globalKey."['".$target."']))";
			}
			else
			{
				$query .= PHP_EOL."\t\t\t\t\tif (\$item->".$_key.")";
				$query .= PHP_EOL."\t\t\t\t\t{";
				$query .= PHP_EOL."\t\t\t\t\t\tif (!in_array(\$item->".$_key.",\$".$globalKey."))";
			}
			$query .= PHP_EOL."\t\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= PHP_EOL."\t\t\t\t\t\t\tcontinue;";
			$query .= PHP_EOL."\t\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t\telse";
			$query .= PHP_EOL."\t\t\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\t\tunset(\$items[\$nr]);";
			$query .= PHP_EOL."\t\t\t\t\t\tcontinue;";
			$query .= PHP_EOL."\t\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t\t}";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t\telse";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\treturn false;";
			$query .= PHP_EOL."\t\t\t}";
		}
                // add custom php to getitems method after all
                $query .= $this->getCustomScriptBuilder('php_getitems_after_all', $viewName_single, PHP_EOL.PHP_EOL."\t");

		$query .= PHP_EOL."\t\t\treturn \$items;";
		$query .= PHP_EOL."\t\t}";
		$query .= PHP_EOL."\t\treturn false;";
		$query .= PHP_EOL."\t}";
		// ###SELECTIONTRANSLATIONFIXFUNC###<<<DYNAMIC>>>
		$query .= $this->setSelectionTranslationFixFunc($viewName_list,$this->fileContentStatic['###Component###']);

		// fixe mothod name clash
		$query = str_replace('selectionTranslation(','selectionTranslation'.$functionName.'(',$query);

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
				$keyLang = $this->langPrefix.'_'.$custom_button['NAME'];
				$this->langContent[$this->lang][$keyLang] = ComponentbuilderHelper::safeString($custom_button['name'],'Ww');
				// add cpanel button
				$buttons[] = "\t\tif (\$this->canDo->get('".$custom_button['link'].".access'))";
				$buttons[] = "\t\t{";
				$buttons[] = "\t\t\t//".$this->setLine(__LINE__)." add ".$custom_button['name']." button.";
				$buttons[] = "\t\t\tJToolBarHelper::custom('".$viewName_list.".redirectTo".ComponentbuilderHelper::safeString($custom_button['link'],'F')."', '".$custom_button['icon']."', '', '".$keyLang."', true);";
				$buttons[] = "\t\t}";
			}
			if (ComponentbuilderHelper::checkArray($buttons))
			{
				return implode(PHP_EOL,$buttons);
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
				$method[] = PHP_EOL.PHP_EOL."\tpublic function redirectTo".ComponentbuilderHelper::safeString($custom_button['link'],'F')."()";
				$method[] = "\t{";
				$method[] = "\t\t//".$this->setLine(__LINE__)." Check for request forgeries";
				$method[] = "\t\tJSession::checkToken() or die(JText::_('JINVALID_TOKEN'));";
				$method[] = "\t\t//".$this->setLine(__LINE__)." check if export is allowed for this user.";
				$method[] = "\t\t\$user = JFactory::getUser();";
				$method[] = "\t\tif (\$user->authorise('".$custom_button['link'].".access', 'com_".$this->fileContentStatic['###component###']."'))";
				$method[] = "\t\t{";
				$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the input";
				$method[] = "\t\t\t\$input = JFactory::getApplication()->input;";
				$method[] = "\t\t\t\$pks = \$input->post->get('cid', array(), 'array');";
				$method[] = "\t\t\t//".$this->setLine(__LINE__)." Sanitize the input";
				$method[] = "\t\t\tJArrayHelper::toInteger(\$pks);";
				$method[] = "\t\t\t//".$this->setLine(__LINE__)." convert to string";
				$method[] = "\t\t\t\$ids = implode('_', \$pks);";
				$method[] = "\t\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$custom_button['link']."&cid='.\$ids, false));";
				$method[] = "\t\t\treturn;";
				$method[] = "\t\t}";
				$method[] = "\t\t//".$this->setLine(__LINE__)." Redirect to the list screen with error.";
				$method[] = "\t\t\$message = JText::_('".$this->langPrefix."_ACCESS_TO_".$custom_button['NAME']."_FAILED');";
				$method[] = "\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_list."', false), \$message, 'error');";
				$method[] = "\t\treturn;";
				$method[] = "\t}";
				// add to lang array
				$lankey = $this->langPrefix."_ACCESS_TO_".$custom_button['NAME']."_FAILED";
				if (!isset($this->langContent[$this->lang][$lankey]))
				{
					$this->langContent[$this->lang][$lankey] = 'Access to '.$custom_button['link'].' was denied.';
				}
			}

			return implode(PHP_EOL,$method);
		}
		return $method;
	}

	/**
	 * @param $viewName_single
	 * @param $viewName_list
	 * @return string
	 */
	public function setModelExportMethod($viewName_single, $viewName_list)
	{
		$query = '';
		if ($this->eximportView[$viewName_list])
		{
			$query = PHP_EOL.PHP_EOL."\t/**";
			$query .= PHP_EOL."\t* Method to get list export data.";
			$query .= PHP_EOL."\t*";
			$query .= PHP_EOL."\t* @return mixed  An array of data items on success, false on failure.";
			$query .= PHP_EOL."\t*/";
			$query .= PHP_EOL."\tpublic function getExportData(\$pks)";
			$query .= PHP_EOL."\t{";
			$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." setup the query";
			$query .= PHP_EOL."\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$pks))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Set a value to know this is exporting method.";
			$query .= PHP_EOL."\t\t\t\$_export = true;";
			$query .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get the user object.";
			$query .= PHP_EOL."\t\t\t\$user = JFactory::getUser();";
			$query .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Create a new query object.";
			$query .= PHP_EOL."\t\t\t\$db = JFactory::getDBO();";
			$query .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Select some fields";
			$query .= PHP_EOL."\t\t\t\$query->select('a.*');";
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." From the ".$this->fileContentStatic['###component###']."_".$viewName_single." table";
			$query .= PHP_EOL."\t\t\t\$query->from(\$db->quoteName('#__".$this->fileContentStatic['###component###']."_".$viewName_single."', 'a'));";
			$query .= PHP_EOL."\t\t\t\$query->where('a.id IN (' . implode(',',\$pks) . ')');";
			// add custom filtering php
                        $query .= $this->getCustomScriptBuilder('php_getlistquery', $viewName_single, PHP_EOL.PHP_EOL."\t");
                        
			if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
			{
				$query .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Implement View Level Access";
				$query .= PHP_EOL."\t\t\tif (!\$user->authorise('core.options', 'com_".$this->fileContentStatic['###component###']."'))";
				$query .= PHP_EOL."\t\t\t{";
				$query .= PHP_EOL."\t\t\t\t\$groups = implode(',', \$user->getAuthorisedViewLevels());";
				$query .= PHP_EOL."\t\t\t\t\$query->where('a.access IN (' . \$groups . ')');";
				$query .= PHP_EOL."\t\t\t}";
			}
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Order the results by ordering";
			$query .= PHP_EOL."\t\t\t\$query->order('a.ordering  ASC');";
			$query .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Load the items";
			$query .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
			$query .= PHP_EOL."\t\t\t\$db->execute();";
			$query .= PHP_EOL."\t\t\tif (\$db->getNumRows())";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\$items = \$db->loadObjectList();";
			$query .= $this->setGetItemsMethodStringFix($viewName_single, $this->fileContentStatic['###Component###'], "\t\t", true);
                        // add custom php to getitems method after all
                        $query .= $this->getCustomScriptBuilder('php_getitems_after_all', $viewName_single, PHP_EOL.PHP_EOL."\t\t");
			$query .= PHP_EOL."\t\t\t\treturn \$items;";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL."\t\treturn false;";
			$query .= PHP_EOL."\t}";

			$query .= PHP_EOL.PHP_EOL."\t/**";
			$query .= PHP_EOL."\t* Method to get header.";
			$query .= PHP_EOL."\t*";
			$query .= PHP_EOL."\t* @return mixed  An array of data items on success, false on failure.";
			$query .= PHP_EOL."\t*/";
			$query .= PHP_EOL."\tpublic function getExImPortHeaders()";
			$query .= PHP_EOL."\t{";
			$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get a db connection.";
			$query .= PHP_EOL."\t\t\$db = JFactory::getDbo();";
			$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." get the columns";
			$query .= PHP_EOL."\t\t\$columns = \$db->getTableColumns(".'"#__'.$this->fileContentStatic['###component###'].'_'.$viewName_single.'");';
			$query .= PHP_EOL."\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$columns))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." remove the headers you don't import/export.";
			$query .= PHP_EOL."\t\t\tunset(\$columns['asset_id']);";
			$query .= PHP_EOL."\t\t\tunset(\$columns['checked_out']);";
			$query .= PHP_EOL."\t\t\tunset(\$columns['checked_out_time']);";
			$query .= PHP_EOL."\t\t\t\$headers = new stdClass();";
			$query .= PHP_EOL."\t\t\tforeach (\$columns as \$column => \$type)";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\$headers->{\$column} = \$column;";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t\treturn \$headers;";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL."\t\treturn false;";
			$query .= PHP_EOL."\t}";
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
			$method[] = PHP_EOL.PHP_EOL."\tpublic function exportData()";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Check for request forgeries";
			$method[] = "\t\tJSession::checkToken() or die(JText::_('JINVALID_TOKEN'));";
			$method[] = "\t\t//".$this->setLine(__LINE__)." check if export is allowed for this user.";
			$method[] = "\t\t\$user = JFactory::getUser();";
			$method[] = "\t\tif (\$user->authorise('".$viewName_single.".export', 'com_".$this->fileContentStatic['###component###']."') && \$user->authorise('core.export', 'com_".$this->fileContentStatic['###component###']."'))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the input";
			$method[] = "\t\t\t\$input = JFactory::getApplication()->input;";
			$method[] = "\t\t\t\$pks = \$input->post->get('cid', array(), 'array');";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Sanitize the input";
			$method[] = "\t\t\tJArrayHelper::toInteger(\$pks);";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the model";
			$method[] = "\t\t\t\$model = \$this->getModel('".ComponentbuilderHelper::safeString($viewName_list,'F')."');";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." get the data to export";
			$method[] = "\t\t\t\$data = \$model->getExportData(\$pks);";
			$method[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkArray(\$data))";
			$method[] = "\t\t\t{";
			$method[] = "\t\t\t\t//".$this->setLine(__LINE__)." now set the data to the spreadsheet";
			$method[] = "\t\t\t\t\$date = JFactory::getDate();";
			$method[] = "\t\t\t\t".$this->fileContentStatic['###Component###']."Helper::xls(\$data,'".ComponentbuilderHelper::safeString($viewName_list,'F')."_'.\$date->format('jS_F_Y'),'".ComponentbuilderHelper::safeString($viewName_list,'Ww')." exported ('.\$date->format('jS F, Y').')','".ComponentbuilderHelper::safeString($viewName_list,'w')."');";
			$method[] = "\t\t\t}";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Redirect to the list screen with error.";
			$method[] = "\t\t\$message = JText::_('".$this->langPrefix."_EXPORT_FAILED');";
			$method[] = "\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_list."', false), \$message, 'error');";
			$method[] = "\t\treturn;";
			$method[] = "\t}";

			// add the import method
			$method[] = PHP_EOL.PHP_EOL."\tpublic function importData()";
			$method[] = "\t{";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Check for request forgeries";
			$method[] = "\t\tJSession::checkToken() or die(JText::_('JINVALID_TOKEN'));";
			$method[] = "\t\t//".$this->setLine(__LINE__)." check if import is allowed for this user.";
			$method[] = "\t\t\$user = JFactory::getUser();";
			$method[] = "\t\tif (\$user->authorise('".$viewName_single.".import', 'com_".$this->fileContentStatic['###component###']."') && \$user->authorise('core.import', 'com_".$this->fileContentStatic['###component###']."'))";
			$method[] = "\t\t{";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." Get the import model";
			$method[] = "\t\t\t\$model = \$this->getModel('".ComponentbuilderHelper::safeString($viewName_list,'F')."');";
			$method[] = "\t\t\t//".$this->setLine(__LINE__)." get the headers to import";
			$method[] = "\t\t\t\$headers = \$model->getExImPortHeaders();";
			$method[] = "\t\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkObject(\$headers))";
			$method[] = "\t\t\t{";
			$method[] = "\t\t\t\t//".$this->setLine(__LINE__)." Load headers to session.";
			$method[] = "\t\t\t\t\$session = JFactory::getSession();";
			$method[] = "\t\t\t\t\$headers = json_encode(\$headers);";
			$method[] = "\t\t\t\t\$session->set('".$viewName_single."_VDM_IMPORTHEADERS', \$headers);";
			$method[] = "\t\t\t\t\$session->set('backto_VDM_IMPORT', '".$viewName_list."');";
			$method[] = "\t\t\t\t\$session->set('dataType_VDM_IMPORTINTO', '".$viewName_single."');";
			$method[] = "\t\t\t\t//".$this->setLine(__LINE__)." Redirect to import view.";
			// add to lang array
			$selectImportFileNote = $this->langPrefix."_IMPORT_SELECT_FILE_FOR_".ComponentbuilderHelper::safeString($viewName_list,'U');
			if (!isset($this->langContent[$this->lang][$selectImportFileNote]))
			{
				$this->langContent[$this->lang][$selectImportFileNote] = 'Select the file to import data to '.$viewName_list.'.';
			}
			$method[] = "\t\t\t\t\$message = JText::_('".$selectImportFileNote."');";
			// if this view has custom script it must have as custom import (model, veiw, controller)
			if (isset($this->importCustomScripts[$viewName_list]) && $this->importCustomScripts[$viewName_list])
			{
				$method[] = "\t\t\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=import_".$viewName_list."', false), \$message);";
			}
			else
			{
				$method[] = "\t\t\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=import', false), \$message);";
			}
			$method[] = "\t\t\t\treturn;";
			$method[] = "\t\t\t}";
			$method[] = "\t\t}";
			$method[] = "\t\t//".$this->setLine(__LINE__)." Redirect to the list screen with error.";
			$method[] = "\t\t\$message = JText::_('".$this->langPrefix."_IMPORT_FAILED');";
			$method[] = "\t\t\$this->setRedirect(JRoute::_('index.php?option=com_".$this->fileContentStatic['###component###']."&view=".$viewName_list."', false), \$message, 'error');";
			$method[] = "\t\treturn;";
			$method[] = "\t}";
			return implode(PHP_EOL,$method);
		}
		return $method;
	}

	public function setExportButton($viewName_single, $viewName_list)
	{
		$button = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			// main lang prefix
			$langExport = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Export Data','U');
			// add to lang array
			if (!isset($this->langContent[$this->lang][$langExport]))
			{
				$this->langContent[$this->lang][$langExport] = 'Export Data';
			}
			$button = array();
			$button[] = PHP_EOL.PHP_EOL."\t\t\tif (\$this->canDo->get('core.export') && \$this->canDo->get('".$viewName_single.".export'))";
			$button[] = "\t\t\t{";
			$button[] = "\t\t\t\tJToolBarHelper::custom('".$viewName_list.".exportData', 'download', '', '".$langExport."', true);";
			$button[] = "\t\t\t}";
			return implode(PHP_EOL,$button);
		}
		return $button;
	}

	public function setImportButton($viewName_single, $viewName_list)
	{
		$button = '';
		if (isset($this->eximportView[$viewName_list]) && $this->eximportView[$viewName_list])
		{
			// main lang prefix
			$langImport = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Import Data','U');
			// add to lang array
			if (!isset($this->langContent[$this->lang][$langImport]))
			{
				$this->langContent[$this->lang][$langImport] = 'Import Data';
			}
			$button = array();
			$button[] = PHP_EOL.PHP_EOL."\t\tif (\$this->canDo->get('core.import') && \$this->canDo->get('".$viewName_single.".import'))";
			$button[] = "\t\t{";
			$button[] = "\t\t\tJToolBarHelper::custom('".$viewName_list.".importData', 'upload', '', '".$langImport."', false);";
			$button[] = "\t\t}";
			return implode(PHP_EOL,$button);
		}
		return $button;
	}

	public function setImportCustomScripts($viewName_list)
	{
		// setup Ajax files
		$target = array('admin' => 'import_'.$viewName_list);
		$this->buildDynamique($target, 'customimport');
		// load the custom script to the files
		// ###IMPORT_EXT_METHOD_CUSTOM### <<<DYNAMIC>>>
		$this->fileContentDynamic['import_'.$viewName_list]['###IMPORT_EXT_METHOD_CUSTOM###'] = $this->getCustomScriptBuilder('php_import_ext', 'import_'.$viewName_list, PHP_EOL, null, true);
                // ###IMPORT_DISPLAY_METHOD_CUSTOM### <<<DYNAMIC>>>
		$this->fileContentDynamic['import_'.$viewName_list]['###IMPORT_DISPLAY_METHOD_CUSTOM###'] = $this->getCustomScriptBuilder('php_import_display', 'import_'.$viewName_list, PHP_EOL, null, true);
                // ###IMPORT_SETDATE_METHOD_CUSTOM### <<<DYNAMIC>>>
		$this->fileContentDynamic['import_'.$viewName_list]['###IMPORT_SETDATE_METHOD_CUSTOM###'] = $this->getCustomScriptBuilder('php_import_setdata', 'import_'.$viewName_list, PHP_EOL, null, true);
                // ###IMPORT_METHOD_CUSTOM### <<<DYNAMIC>>>
		$this->fileContentDynamic['import_'.$viewName_list]['###IMPORT_METHOD_CUSTOM###'] = $this->getCustomScriptBuilder('php_import', 'import_'.$viewName_list, PHP_EOL, null, true);
                // ###IMPORT_SAVE_METHOD_CUSTOM### <<<DYNAMIC>>>
		$this->fileContentDynamic['import_'.$viewName_list]['###IMPORT_SAVE_METHOD_CUSTOM###'] = $this->getCustomScriptBuilder('php_import_save', 'import_'.$viewName_list, PHP_EOL, null, true);
                // ###IMPORT_DEFAULT_VIEW_CUSTOM### <<<DYNAMIC>>>
		$this->fileContentDynamic['import_'.$viewName_list]['###IMPORT_DEFAULT_VIEW_CUSTOM###'] = $this->getCustomScriptBuilder('html_import_view', 'import_'.$viewName_list, PHP_EOL, null, true);
		
		// insure we have the view placeholders setup
		$this->fileContentDynamic['import_'.$viewName_list]['###VIEW###'] = 'IMPORT_'.$this->placeholders['###VIEWS###'];
		$this->fileContentDynamic['import_'.$viewName_list]['###View###'] = 'Import_'.$this->placeholders['###views###'];
		$this->fileContentDynamic['import_'.$viewName_list]['###view###'] = 'import_'.$this->placeholders['###views###'];
		$this->fileContentDynamic['import_'.$viewName_list]['###VIEWS###'] = 'IMPORT_'.$this->placeholders['###VIEWS###'];
		$this->fileContentDynamic['import_'.$viewName_list]['###Views###'] = 'Import_'.$this->placeholders['###views###'];
		$this->fileContentDynamic['import_'.$viewName_list]['###views###'] = 'import_'.$this->placeholders['###views###'];
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
		$query = "//".$this->setLine(__LINE__)." Get the user object.";
		$query .= PHP_EOL."\t\t\$user = JFactory::getUser();";
		$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
		$query .= PHP_EOL."\t\t\$db = JFactory::getDBO();";
		$query .= PHP_EOL."\t\t\$query = \$db->getQuery(true);";
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Select some fields";
		$query .= PHP_EOL."\t\t\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL."\t\t\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." From the ".$this->fileContentStatic['###component###']."_item table";
		$query .= PHP_EOL."\t\t\$query->from(\$db->quoteName('#__".$this->fileContentStatic['###component###']."_".$viewName_single."', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL."\t\t\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a.".$categoryCodeName."') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
                $query .= $this->getCustomScriptBuilder('php_getlistquery', $viewName_single, PHP_EOL.PHP_EOL);
		// add the custom fields query
		$query .= $this->setCustomQuery($viewName_list, $viewName_single);
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by published state";
		$query .= PHP_EOL."\t\t\$published = \$this->getState('filter.published');";
		$query .= PHP_EOL."\t\tif (is_numeric(\$published))";
		$query .= PHP_EOL."\t\t{";
		$query .= PHP_EOL."\t\t\t\$query->where('a.published = ' . (int) \$published);";
		$query .= PHP_EOL."\t\t}";
		$query .= PHP_EOL."\t\telseif (\$published === '')";
		$query .= PHP_EOL."\t\t{";
		$query .= PHP_EOL."\t\t\t\$query->where('(a.published = 0 OR a.published = 1)');";
		$query .= PHP_EOL."\t\t}";
		if (isset($this->accessBuilder[$viewName_single]) && ComponentbuilderHelper::checkString($this->accessBuilder[$viewName_single]))
		{
			$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Join over the asset groups.";
			$query .= PHP_EOL."\t\t\$query->select('ag.title AS access_level');";
			$query .= PHP_EOL."\t\t\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by access level.";
			$query .= PHP_EOL."\t\tif (\$access = \$this->getState('filter.access'))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$query->where('a.access = ' . (int) \$access);";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Implement View Level Access";
			$query .= PHP_EOL."\t\tif (!\$user->authorise('core.options', 'com_".$this->fileContentStatic['###component###']."'))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= PHP_EOL."\t\t\t\$query->where('a.access IN (' . \$groups . ')');";
			$query .= PHP_EOL."\t\t}";
		}
		// set the search query
		$query .= $this->setSearchQuery($viewName_list);
		// set other filters
		$query .= $this->setFilterQuery($viewName_list);
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by a single or group of categories.";
			$query .= PHP_EOL."\t\t\$baselevel = 1;";
			$query .= PHP_EOL."\t\t\$categoryId = \$this->getState('filter.category_id');";
			$query .= PHP_EOL;
			$query .= PHP_EOL."\t\tif (is_numeric(\$categoryId))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\t\$cat_tbl = JTable::getInstance('Category', 'JTable');";
			$query .= PHP_EOL."\t\t\t\$cat_tbl->load(\$categoryId);";
			$query .= PHP_EOL."\t\t\t\$rgt = \$cat_tbl->rgt;";
			$query .= PHP_EOL."\t\t\t\$lft = \$cat_tbl->lft;";
			$query .= PHP_EOL."\t\t\t\$baselevel = (int) \$cat_tbl->level;";
			$query .= PHP_EOL."\t\t\t\$query->where('c.lft >= ' . (int) \$lft)";
			$query .= PHP_EOL."\t\t\t\t->where('c.rgt <= ' . (int) \$rgt);";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL."\t\telseif (is_array(\$categoryId))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\tJArrayHelper::toInteger(\$categoryId);";
			$query .= PHP_EOL."\t\t\t\$categoryId = implode(',', \$categoryId);";
			$query .= PHP_EOL."\t\t\t\$query->where('a.category IN (' . \$categoryId . ')');";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL;
		}
		$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Add the list ordering clause.";
		$query .= PHP_EOL."\t\t\$orderCol = \$this->state->get('list.ordering', 'a.id');";
		$query .= PHP_EOL."\t\t\$orderDirn = \$this->state->get('list.direction', 'asc');	";
		$query .= PHP_EOL."\t\tif (\$orderCol != '')";
		$query .= PHP_EOL."\t\t{";
		$query .= PHP_EOL."\t\t\t\$query->order(\$db->escape(\$orderCol . ' ' . \$orderDirn));";
		$query .= PHP_EOL."\t\t}";
		$query .= PHP_EOL;
		$query .= PHP_EOL."\t\treturn \$query;";

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
					$search .= "a.".$array['code']." LIKE '.\$search.'";
					if (ComponentbuilderHelper::checkArray($array['custom']) && 1 == $array['list'])
					{
						$search .= " OR ".$array['custom']['db'].".".$array['custom']['text']." LIKE '.\$search.'";
					}
				}
				else
				{
					$search .= " OR a.".$array['code']." LIKE '.\$search.'";
					if (ComponentbuilderHelper::checkArray($array['custom']) && 1 == $array['list'])
					{
						$search .= " OR ".$array['custom']['db'].".".$array['custom']['text']." LIKE '.\$search.'";
					}
				}
			}
			$search .= ")'";
			// now setup query
			$query = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by search.";
			$query .= PHP_EOL."\t\t\$search = \$this->getState('filter.search');";
			$query .= PHP_EOL."\t\tif (!empty(\$search))";
			$query .= PHP_EOL."\t\t{";
			$query .= PHP_EOL."\t\t\tif (stripos(\$search, 'id:') === 0)";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\$query->where('a.id = ' . (int) substr(\$search, 3));";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t\telse";
			$query .= PHP_EOL."\t\t\t{";
			$query .= PHP_EOL."\t\t\t\t\$search = \$db->quote('%' . \$db->escape(\$search) . '%');";
			$query .= PHP_EOL."\t\t\t\t\$query->where(".$search.");";
			$query .= PHP_EOL."\t\t\t}";
			$query .= PHP_EOL."\t\t}";
			$query .= PHP_EOL;

			return $query;
		}
		return '';
	}

	public function setCustomQuery($viewName_list, $viewName_single)
	{
		if (isset($this->customBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->customBuilder[$viewName_list]))
		{
			$query = "";
			foreach ($this->customBuilder[$viewName_list] as $filter)
			{
				// only load this if table is set
				if (isset($this->customBuilderList[$viewName_list]) 
					&& ComponentbuilderHelper::checkArray($this->customBuilderList[$viewName_list]) 
					&& in_array($filter['code'],$this->customBuilderList[$viewName_list])
					&& isset($filter['custom']['table']) 
					&& ComponentbuilderHelper::checkString($filter['custom']['table'])
					&& $filter['method'] == 0)
				{
					$query .= PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." From the ".ComponentbuilderHelper::safeString(ComponentbuilderHelper::safeString($filter['custom']['table'],'w'))." table.";
					$query .= PHP_EOL."\t\t\$query->select(\$db->quoteName('".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'));";
					$query .= PHP_EOL."\t\t\$query->join('LEFT', \$db->quoteName('".$filter['custom']['table']."', '".$filter['custom']['db']."') . ' ON (' . \$db->quoteName('a.".$filter['code']."') . ' = ' . \$db->quoteName('".$filter['custom']['db'].".".$filter['custom']['id']."') . ')');";
				}
				// build the field type file
				$this->setCustomFieldTypeFile($filter, $viewName_list, $viewName_single);
			}
			return $query;
		}
	}

	public function setAddButttonToListField($targetView,$targetViews)
	{
		$addButton = array();
		$addButton[] = PHP_EOL."\t/**";
		$addButton[] = "\t * Override to add new button";
		$addButton[] = "\t *";
		$addButton[] = "\t * @return  string  The field input markup.";
		$addButton[] = "\t *";
		$addButton[] = "\t * @since   3.2";
		$addButton[] = "\t */";
		$addButton[] = "\tprotected function getInput()";
		$addButton[] = "\t{";
		$addButton[] = "\t\t//".$this->setLine(__LINE__)." see if we should add buttons";
		$addButton[] = "\t\t\$setButton = \$this->getAttribute('button');";
		$addButton[] = "\t\t//".$this->setLine(__LINE__)." get html";
		$addButton[] = "\t\t\$html = parent::getInput();";
		$addButton[] = "\t\t//".$this->setLine(__LINE__)." if true set button";
		$addButton[] = "\t\tif (\$setButton === 'true')";
		$addButton[] = "\t\t{";
		$addButton[] = "\t\t\t\$button = array();";
		$addButton[] = "\t\t\t\$script = array();";
		$addButton[] = "\t\t\t\$buttonName = \$this->getAttribute('name');";
		$addButton[] = "\t\t\t//".$this->setLine(__LINE__)." get the input from url";
		$addButton[] = "\t\t\t\$app = JFactory::getApplication();";
		$addButton[] = "\t\t\t\$jinput = \$app->input;";
		$addButton[] = "\t\t\t//".$this->setLine(__LINE__)." get the view name & id";
		$addButton[] = "\t\t\t\$values = \$jinput->getArray(array(";
		$addButton[] = "\t\t\t\t'id' => 'int',";
		$addButton[] = "\t\t\t\t'view' => 'word'";
		$addButton[] = "\t\t\t));";
		$addButton[] = "\t\t\t//".$this->setLine(__LINE__)." check if new item";
		$addButton[] = "\t\t\t\$ref = '';";
		$addButton[] = "\t\t\t\$refJ = '';";
		$addButton[] = "\t\t\tif (!is_null(\$values['id']) && strlen(\$values['view']))";
		$addButton[] = "\t\t\t{";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." only load referal if not new item.";
		$addButton[] = "\t\t\t\t\$ref = '&amp;ref=' . \$values['view'] . '&amp;refid=' . \$values['id'];";
		$addButton[] = "\t\t\t\t\$refJ = '&ref=' . \$values['view'] . '&refid=' . \$values['id'];";
		$addButton[] = "\t\t\t}";
		$addButton[] = "\t\t\t\$user = JFactory::getUser();";
		$addButton[] = "\t\t\t//".$this->setLine(__LINE__)." only add if user allowed to create " . $targetView;
		// get core permissions
		$coreLoad = false;
		if (isset($this->permissionCore[$targetView]))
		{
			$core = $this->permissionCore[$targetView];
			$coreLoad = true;
		}
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($targetView,$this->permissionBuilder['global'][$core['core.create']]))
		{
			$addButton[] = "\t\t\tif (\$user->authorise('".$core['core.create']."', 'com_".$this->fileContentStatic['###component###']."') && \$app->isAdmin()) // TODO for now only in admin area.";
		}
		else
		{
			$addButton[] = "\t\t\tif (\$user->authorise('core.create', 'com_".$this->fileContentStatic['###component###']."') && \$app->isAdmin()) // TODO for now only in admin area.";
		}
		$addButton[] = "\t\t\t{";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." build Create button";
		$addButton[] = "\t\t\t\t\$buttonNamee = trim(\$buttonName);";
                $addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/_+/', ' ', \$buttonNamee);";
                $addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/\s+/', ' ', \$buttonNamee);";
                $addButton[] = "\t\t\t\t\$buttonNamee = preg_replace(\"/[^A-Za-z ]/\", '', \$buttonNamee);";
		$addButton[] = "\t\t\t\t\$buttonNamee = ucfirst(strtolower(\$buttonNamee));";
		$addButton[] = "\t\t\t\t\$button[] = '<a id=\"'.\$buttonName.'Create\" class=\"btn btn-small btn-success hasTooltip\" title=\"'.JText::sprintf('".$this->langPrefix."_CREATE_NEW_S', \$buttonNamee).'\" style=\"border-radius: 0px 4px 4px 0px; padding: 4px 4px 4px 7px;\"";
		$addButton[] = "\t\t\t\t\thref=\"index.php?option=com_" . $this->fileContentStatic['###component###'] . "&amp;view=" . $targetView . "&amp;layout=edit'.\$ref.'\" >";
		$addButton[] = "\t\t\t\t\t<span class=\"icon-new icon-white\"></span></a>';";
		$addButton[] = "\t\t\t}";
		$addButton[] = "\t\t\t//".$this->setLine(__LINE__)." only add if user allowed to edit " . $targetView;
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($targetView,$this->permissionBuilder['global'][$core['core.edit']]))
		{
			$addButton[] = "\t\t\tif ((\$buttonName === '".$targetView."' || \$buttonName === '".$targetViews."') && \$user->authorise('".$core['core.edit']."', 'com_".$this->fileContentStatic['###component###']."') && \$app->isAdmin()) // TODO for now only in admin area.";
		}
		else
		{
			$addButton[] = "\t\t\tif ((\$buttonName === '".$targetView."' || \$buttonName === '".$targetViews."')  && \$user->authorise('core.edit', 'com_".$this->fileContentStatic['###component###']."') && \$app->isAdmin()) // TODO for now only in admin area.";
		}
		$addButton[] = "\t\t\t{";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." build edit button";
		$addButton[] = "\t\t\t\t\$buttonNamee = trim(\$buttonName);";
                $addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/_+/', ' ', \$buttonNamee);";
                $addButton[] = "\t\t\t\t\$buttonNamee = preg_replace('/\s+/', ' ', \$buttonNamee);";
                $addButton[] = "\t\t\t\t\$buttonNamee = preg_replace(\"/[^A-Za-z ]/\", '', \$buttonNamee);";
		$addButton[] = "\t\t\t\t\$buttonNamee = ucfirst(strtolower(\$buttonNamee));";
		$addButton[] = "\t\t\t\t\$button[] = '<a id=\"'.\$buttonName.'Edit\" class=\"btn btn-small hasTooltip\" title=\"'.JText::sprintf('".$this->langPrefix."_EDIT_S', \$buttonNamee).'\" style=\"display: none; padding: 4px 4px 4px 7px;\" href=\"#\" >";
		$addButton[] = "\t\t\t\t\t<span class=\"icon-edit\"></span></a>';";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." build script";
		$addButton[] = "\t\t\t\t\$script[] = \"";
		$addButton[] = "\t\t\t\t\tjQuery(document).ready(function() {";
		$addButton[] = "\t\t\t\t\t\tjQuery('#adminForm').on('change', '#jform_\".\$buttonName.\"',function (e) {";
		$addButton[] = "\t\t\t\t\t\t\te.preventDefault();";
		$addButton[] = "\t\t\t\t\t\t\tvar \".\$buttonName.\"Value = jQuery('#jform_\".\$buttonName.\"').val();";
		$addButton[] = "\t\t\t\t\t\t\t\".\$buttonName.\"Button(\".\$buttonName.\"Value);";
		$addButton[] = "\t\t\t\t\t\t});";		
		$addButton[] = "\t\t\t\t\t\tvar \".\$buttonName.\"Value = jQuery('#jform_\".\$buttonName.\"').val();";
		$addButton[] = "\t\t\t\t\t\t\".\$buttonName.\"Button(\".\$buttonName.\"Value);";
		$addButton[] = "\t\t\t\t\t});";
		$addButton[] = "\t\t\t\t\tfunction \".\$buttonName.\"Button(value) {";
		$addButton[] = "\t\t\t\t\t\tif (value > 0) {"; // TODO not ideal since value may not be an (int)
		$addButton[] = "\t\t\t\t\t\t\t// hide the create button";
		$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Create').hide();";
		$addButton[] = "\t\t\t\t\t\t\t// show edit button";
		$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Edit').show();";
		$addButton[] = "\t\t\t\t\t\t\tvar url = 'index.php?option=com_" . $this->fileContentStatic['###component###'] . "&view=".$targetViews."&task=" . $targetView . ".edit&id='+value+'\".\$refJ.\"';"; // TODO this value may not be the ID
		$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Edit').attr('href', url);";
		$addButton[] = "\t\t\t\t\t\t} else {";
		$addButton[] = "\t\t\t\t\t\t\t// show the create button";
		$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Create').show();";
		$addButton[] = "\t\t\t\t\t\t\t// hide edit button";
		$addButton[] = "\t\t\t\t\t\t\tjQuery('#\".\$buttonName.\"Edit').hide();";
		$addButton[] = "\t\t\t\t\t\t}";
		$addButton[] = "\t\t\t\t\t}\";";
		$addButton[] = "\t\t\t}";
		$addButton[] = "\t\t\t//".$this->setLine(__LINE__)." check if button was created for " . $targetView ." field.";
		$addButton[] = "\t\t\tif (is_array(\$button) && count(\$button) > 0)";
		$addButton[] = "\t\t\t{";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." Load the needed script.";
		$addButton[] = "\t\t\t\t\$document = JFactory::getDocument();";
		$addButton[] = "\t\t\t\t\$document->addScriptDeclaration(implode(' ',\$script));";
		$addButton[] = "\t\t\t\t//".$this->setLine(__LINE__)." return the button attached to input field.";
		$addButton[] = "\t\t\t\treturn '<div class=\"input-append\">' .\$html . implode('',\$button).'</div>';";
		$addButton[] = "\t\t\t}";
		$addButton[] = "\t\t}";
		$addButton[] = "\t\treturn \$html;";
		$addButton[] = "\t}";

		return implode(PHP_EOL,$addButton);
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
					$filterQuery .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by ".$filter['code'].".";
					$filterQuery .= PHP_EOL."\t\tif (\$".$filter['code']." = \$this->getState('filter.".$filter['code']."'))";
					$filterQuery .= PHP_EOL."\t\t{";
					$filterQuery .= PHP_EOL."\t\t\t\$query->where('a.".$filter['code']." = ' . \$db->quote(\$db->escape(\$".$filter['code'].")));";
					$filterQuery .= PHP_EOL."\t\t}";

				}
				elseif ($filter['type'] != 'category')
				{
					$filterQuery .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Filter by ".ucwords($filter['code']).".";
					$filterQuery .= PHP_EOL."\t\tif (\$".$filter['code']." = \$this->getState('filter.".$filter['code']."'))";
					$filterQuery .= PHP_EOL."\t\t{";
					$filterQuery .= PHP_EOL."\t\t\t\$query->where('a.".$filter['code']." = ' . \$db->quote(\$db->escape(\$".$filter['code'].")));";
					$filterQuery .= PHP_EOL."\t\t}";
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
			$getValue		= array();
			$ifValue		= array();
			$targetControls		= array();
			$functions		= array();
			foreach ($viewArray['settings']->conditions as $condition)
			{
				if (isset($condition['match_name']) && ComponentbuilderHelper::checkString($condition['match_name']))
				{
					$uniqueVar		= $this->uniquekey(7);
					$matchName 		= $condition['match_name'].'_'.$uniqueVar;
					$targetBehavior		= ($condition['target_behavior'] == 1) ? 'show' : 'hide';
					$targetDefault		= ($condition['target_behavior'] == 1) ? 'hide' : 'show';

					// make sure only one relation is set
					$firstTime = true;
					// set the realtation if any
					if ($condition['target_relation'] && $firstTime)
					{
						// chain to other items of the same target
						$relations = $this->getTargetRelationScript($viewArray['settings']->conditions,$condition,$viewName);
						if (ComponentbuilderHelper::checkArray($relations))
						{
							// set behavior and default array
							$behaviors[$matchName]		= $targetBehavior;
							$defaults[$matchName]		= $targetDefault;
							// set the type buket
							$typeBuket[$matchName]		= $condition['match_type'];
							// set function array
							$functions[$uniqueVar][0]	= $matchName;
							$matchNames[$matchName]		= $condition['match_name'];
							// get the select value
							$getValue[$matchName]		= $this->getValueScript($condition['match_type'],$condition['match_name'],$condition['match_extends'],$uniqueVar);
							// get the options
							$options			= $this->getOptionsScript($condition['match_type'],$condition['match_options']);
							// set the if values
							$ifValue[$matchName]		= $this->ifValueScript($matchName,$condition['match_behavior'],$condition['match_type'],$options);
							// set the target controls
							$targetControls[$matchName]	= $this->setTargetControlsScript($condition['target_field'],$targetBehavior,$targetDefault,$uniqueVar,$viewName);

							$firstTime = false;
							foreach($relations as $relation)
							{
								if (ComponentbuilderHelper::checkString($relation['match_name']))
								{
									$relationName			= $relation['match_name'].'_'.$uniqueVar;
									// set the type buket
									$typeBuket[$relationName]	= $relation['match_type'];
									// set function array
									$functions[$uniqueVar][]	= $relationName;
									$matchNames[$relationName]	= $relation['match_name'];
									// get the relation option
									$relationOptions		= $this->getOptionsScript($relation['match_type'],$relation['match_options']);
									$getValue[$relationName]	= $this->getValueScript($relation['match_type'],$relation['match_name'],$condition['match_extends'],$uniqueVar);
									$ifValue[$relationName]		= $this->ifValueScript($relationName,$relation['match_behavior'],$relation['match_type'],$relationOptions);
								}
							}
						}
					}
					else
					{
						// set behavior and default array
						$behaviors[$matchName]		= $targetBehavior;
						$defaults[$matchName]		= $targetDefault;
						// set the type buket
						$typeBuket[$matchName]		= $condition['match_type'];
						// set function array
						$functions[$uniqueVar][0]	= $matchName;
						$matchNames[$matchName]		= $condition['match_name'];
						// get the select value
						$getValue[$matchName]		= $this->getValueScript($condition['match_type'],$condition['match_name'],$condition['match_extends'],$uniqueVar);
						// get the options
						$options			= $this->getOptionsScript($condition['match_type'],$condition['match_options']);
						// set the if values
						$ifValue[$matchName]		= $this->ifValueScript($matchName,$condition['match_behavior'],$condition['match_type'],$options);
						// set the target controls
						$targetControls[$matchName]	= $this->setTargetControlsScript($condition['target_field'],$targetBehavior,$targetDefault,$uniqueVar,$viewName);
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
				$initial .= "// Initial Script".PHP_EOL."jQuery(document).ready(function()";
				$initial .= PHP_EOL."{";
				foreach ($functions as $function => $matchKeys)
				{
					$func_call = $this->buildFunctionCall($function,$matchKeys,$getValue);
					$initial .= $func_call['code'];
				}
				$initial .= "});".PHP_EOL;
				// for modal fields
				$modal = '';
				// now build the listener scripts
				foreach ($functions as $l_function => $l_matchKeys)
				{
					$funcCall = '';
					foreach ($l_matchKeys as $l_matchKey)
					{
						$name		= $matchNames[$l_matchKey];
						$matchTypeKey	= $typeBuket[$l_matchKey];
						$funcCall	= $this->buildFunctionCall($l_function,$l_matchKeys,$getValue);
						
						if(isset($this->setScriptMediaSwitch) && ComponentbuilderHelper::checkArray($this->setScriptMediaSwitch) && in_array($matchTypeKey,$this->setScriptMediaSwitch))
						{
							$modal .= $funcCall['code'];
						}
						else
						{
							if (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($matchTypeKey,$this->setScriptUserSwitch))
							{
								$name = $name.'_id';
							}

							$listener .= PHP_EOL."// #jform_".$name." listeners for ".$l_matchKey." function";
							$listener .= PHP_EOL."jQuery('#jform_".$name."').on('keyup',function()";
							$listener .= PHP_EOL."{";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL."});";
							$listener .= PHP_EOL."jQuery('#adminForm').on('change', '#jform_".$name."',function (e)";
							$listener .= PHP_EOL."{";
							$listener .= PHP_EOL."\te.preventDefault();";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL."});".PHP_EOL;
						}
					}
				}
				if (ComponentbuilderHelper::checkString($modal))
				{
					$listener .= PHP_EOL."window.SqueezeBox.initialize({";
					$listener .= PHP_EOL."\tonClose:function(){";
					$listener .= $modal;
					$listener .= PHP_EOL."\t}";
					$listener .= PHP_EOL."});".PHP_EOL;
				}

				// now build the function
				$func = '';
				$head = '';
				foreach ($functions as $f_function => $f_matchKeys)
				{
					$map = '';
					// does this function require an array
					$addArray = false;
					$func_ = $this->buildFunctionCall($f_function,$f_matchKeys,$getValue);
					// set array switch
					if ($func_['array'])
					{
						$addArray = true;
					}
					$func .= PHP_EOL."// the ".$f_function." function";
					$func .= PHP_EOL."function ".$f_function."(";
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
								$func .= ','.$fu_matchKey;
							}
							$fucounter++;
						}
					}
					$func .= ")";
					$func .= PHP_EOL."{";
					if ($addArray)
					{
						foreach ($f_matchKeys as $a_matchKey)
						{
							$name = $matchNames[$a_matchKey];
							$func .= PHP_EOL."\tif (isSet(".$a_matchKey.") && ".$a_matchKey.".constructor !== Array)".PHP_EOL."\t{".PHP_EOL."\t\tvar temp_".$f_function." = ".$a_matchKey.";".PHP_EOL."\t\tvar ".$a_matchKey." = [];".PHP_EOL."\t\t".$a_matchKey.".push(temp_".$f_function.");".PHP_EOL."\t}";
							$func .= PHP_EOL."\telse if (!isSet(".$a_matchKey."))".PHP_EOL."\t{";
							$func .= PHP_EOL."\t\tvar ".$a_matchKey." = [];";
							$func .= PHP_EOL."\t}";
							$func .= PHP_EOL."\tvar ".$name." = ".$a_matchKey.".some(".$a_matchKey."_SomeFunc);".PHP_EOL;

							// setup the map function
							$map .= PHP_EOL."// the ".$f_function." Some function";
							$map .= PHP_EOL."function ".$a_matchKey."_SomeFunc(".$a_matchKey.")";
							$map .= PHP_EOL."{";
							$map .= PHP_EOL."\t//".$this->setLine(__LINE__)." set the function logic";
							$map .= PHP_EOL."\tif (";
							$if = $ifValue[$a_matchKey];
							if (ComponentbuilderHelper::checkString($if))
							{
								$map .= $if;
							}
							$map .= ")";
							$map .= PHP_EOL."\t{";
							$map .= PHP_EOL."\t\treturn true;";
							$map .= PHP_EOL."\t}".PHP_EOL."\treturn false;";
							$map .= PHP_EOL."}".PHP_EOL;
						}
						$func .= PHP_EOL.PHP_EOL."\t//".$this->setLine(__LINE__)." set this function logic";
						$func .= PHP_EOL."\tif (";
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
								$func .= ' && '.$name;
							}
							$aifcounter++;
						}
						$func .= ")".PHP_EOL."\t{";

					}
					else
					{
						$func .= PHP_EOL."\t//".$this->setLine(__LINE__)." set the function logic";
						$func .= PHP_EOL."\tif (";
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
									$func .= ' && '.$if;
								}
								$ifcounter++;
							}
						}
						$func .= ")".PHP_EOL."\t{";
					}
					// get the controles
					$controls = $targetControls[$f_matchKeys[0]];
					// get target behavior and default
					$targetBehavior = $behaviors[$f_matchKeys[0]];
					$targetDefault = $defaults[$f_matchKeys[0]];
					// load the target behavior
					foreach($controls as $target => $action)
					{
						$func .= $action['behavior'];
						if (ComponentbuilderHelper::checkString($action['hide']))
						{
							$func .= $action[$targetBehavior];
							$head .= $action['requiredVar'];
						}
					}
					$func .= PHP_EOL."\t}".PHP_EOL."\telse".PHP_EOL."\t{";
					foreach($controls as $target => $action)
					{
						$func .= $action['default'];
						if (ComponentbuilderHelper::checkString($action['hide']))
						{
							$func .= $action[$targetDefault];
						}
					}
					$func .= PHP_EOL."\t}".PHP_EOL."}".PHP_EOL.$map;
				}
				// add the needed validation to file
				if (isset($this->validationFixBuilder[$viewName]) && ComponentbuilderHelper::checkArray($this->validationFixBuilder[$viewName]))
				{
					$validation .= PHP_EOL."// update required fields";
					$validation .= PHP_EOL."function updateFieldRequired(name,status)";
					$validation .= PHP_EOL."{";
					$validation .= PHP_EOL."\tvar not_required = jQuery('#jform_not_required').val();";
					$validation .= PHP_EOL.PHP_EOL."\tif(status == 1)";
					$validation .= PHP_EOL."\t{";
					$validation .= PHP_EOL."\t\tif (isSet(not_required) && not_required != 0)";
					$validation .= PHP_EOL."\t\t{";
					$validation .= PHP_EOL."\t\t\tnot_required = not_required+','+name;";
					$validation .= PHP_EOL."\t\t}";
					$validation .= PHP_EOL."\t\telse";
					$validation .= PHP_EOL."\t\t{";
					$validation .= PHP_EOL."\t\t\tnot_required = ','+name;";
					$validation .= PHP_EOL."\t\t}";
					$validation .= PHP_EOL."\t}";
					$validation .= PHP_EOL."\telse";
					$validation .= PHP_EOL."\t{";
					$validation .= PHP_EOL."\t\tif (isSet(not_required) && not_required != 0)";
					$validation .= PHP_EOL."\t\t{";
					$validation .= PHP_EOL."\t\t\tnot_required = not_required.replace(','+name,'');";
					$validation .= PHP_EOL."\t\t}";
					$validation .= PHP_EOL."\t}";
					$validation .= PHP_EOL.PHP_EOL."\tjQuery('#jform_not_required').val(not_required);";
					$validation .= PHP_EOL."}".PHP_EOL;
				}
				// set the isSet function
				$isSet = PHP_EOL."// the isSet function";
				$isSet .= PHP_EOL."function isSet(val)";
				$isSet .= PHP_EOL."{";
				$isSet .= PHP_EOL."\tif ((val != undefined) && (val != null) && 0 !== val.length){";
				$isSet .= PHP_EOL."\t\treturn true;";
				$isSet .= PHP_EOL."\t}";
				$isSet .= PHP_EOL."\treturn false;";
				$isSet .= PHP_EOL."}";
			}
			// load to this buket
			$fileScript	= $initial.$func.$validation.$isSet;
			$footerScript	= $listener;
		}
		// add custom script to file
		if (isset($this->customScriptBuilder['view_file'][$viewName]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['view_file'][$viewName]))
		{
			if (!isset($fileScript))
			{
				$fileScript = '';
			}
			$fileScript .= PHP_EOL.PHP_EOL.$this->setPlaceholders($this->customScriptBuilder['view_file'][$viewName], $this->placeholders);
		}
		// add custom script to footer
		if (isset($this->customScriptBuilder['view_footer'][$viewName]) && ComponentbuilderHelper::checkString($this->customScriptBuilder['view_footer'][$viewName]))
		{
			$customFooterScript = PHP_EOL.PHP_EOL.$this->setPlaceholders($this->customScriptBuilder['view_footer'][$viewName], $this->placeholders);
			if (strpos($customFooterScript,'<?php') === false)
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
		// minfy the script
		if ($this->params->get('minify') && isset($fileScript) && ComponentbuilderHelper::checkString($fileScript))
		{
			// minify the fielScript javscript
			$minifier = new JS;
			$minifier->add($fileScript);
			$fileScript = $minifier->minify();
		}
		// minfy the script
		if ($this->params->get('minify') && isset($footerScript) && ComponentbuilderHelper::checkString($footerScript))
		{
			// minify the footerScript javscript
			$minifier = new JS;
			$minifier->add($footerScript);
			$footerScript = $minifier->minify();
		}
		// make sure there is script to add
		if (isset($fileScript) && ComponentbuilderHelper::checkString($fileScript))
		{
			// add the head script if set
			if (isset($head) && ComponentbuilderHelper::checkString($head))
			{
				$fileScript = "// Some Global Values".PHP_EOL.$head.PHP_EOL.$fileScript;
			}
			// load the script
			$this->editBodyViewScriptBuilder[$viewName]['fileScript'] = $fileScript;
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
			$footerScript = PHP_EOL.PHP_EOL.'<script type="text/javascript">'.PHP_EOL.$footerScript.PHP_EOL."</script>";
			$this->editBodyViewScriptBuilder[$viewName]['footerScript'] = $footerScript;
		}
	}

	public function buildFunctionCall($function,$matchKeys,$getValue)
	{
		$initial	= '';
		$funcsets	= array();
		$array		= false;
		foreach ($matchKeys as $matchKey)
		{
			$value = $getValue[$matchKey];
			if ($value['isArray'])
			{
				$initial .= PHP_EOL."\t".$value['get'];
				$funcsets[] = $matchKey;
				$array = true;
			}
			else
			{
				$initial .= PHP_EOL."\t".$value['get'];
				$funcsets[] = $matchKey;
			}
		}

		// make sure that the function is loaded only once
		if (ComponentbuilderHelper::checkArray($funcsets))
		{
			$initial .= PHP_EOL."\t".$function."(";
			$initial .= implode(',',$funcsets);
			$initial .= ");".PHP_EOL;
		}
		return array('code' => $initial, 'array' => $array);
	}

	public function getTargetRelationScript($relations,$condition,$view)
	{
		// reset the buket
		$buket = array();
		// convert to name array
		foreach ($condition['target_field'] as $targetField)
		{
			if (ComponentbuilderHelper::checkArray($targetField))
			{
				$currentTargets[] = $targetField['name'];
			}
		}
		// start the search
		foreach($relations as $relation)
		{
			// reset found
			$found = false;
			if ($relation['match_field'] != $condition['match_field'])
			{
				if (ComponentbuilderHelper::checkArray($relation['target_field']))
				{
					foreach($relation['target_field'] as $target)
					{
						if (ComponentbuilderHelper::checkArray($target) && $this->checkRelationControl($target['name'],$relation['match_name'],$condition['match_name'],$view))
						{
							if (in_array($target['name'],$currentTargets))
							{
								$this->targetRelationControl[$view][$target['name']] = array($relation['match_name'],$condition['match_name']);
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

	public function checkRelationControl($targetName,$relationMatchName,$conditionMatchName,$view)
	{
		if(isset($this->targetRelationControl[$view]) && ComponentbuilderHelper::checkArray($this->targetRelationControl[$view]))
		{
			if(isset($this->targetRelationControl[$view][$targetName]) && ComponentbuilderHelper::checkArray($this->targetRelationControl[$view][$targetName]))
			{
				if (!in_array($relationMatchName,$this->targetRelationControl[$view][$targetName]) || !in_array($conditionMatchName,$this->targetRelationControl[$view][$targetName]))
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

	public function setTargetControlsScript($targets,$targetBehavior,$targetDefault,$uniqueVar,$viewName)
	{
		$bucket = array();
		if (ComponentbuilderHelper::checkArray($targets) && !in_array($uniqueVar,$this->targetControlsScriptChecker))
		{
			foreach($targets as $target)
			{
				if (ComponentbuilderHelper::checkArray($target))
				{
					// set the required var
					if($target['required'] === 'yes')
					{
						$unique = $uniqueVar.$this->uniquekey(3);
						$bucket[$target['name']]['requiredVar'] = "jform_".$unique."_required = false;".PHP_EOL;
					}
					else
					{
						$bucket[$target['name']]['requiredVar'] = '';
					}
					// set target type
					$targetTypeSufix = "";
					if ($this->defaultField($target['type'], 'spacer'))
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
					$bucket[$target['name']]['behavior'] = PHP_EOL."\t\tjQuery('".$targetType.$target['name'].$targetTypeSufix."').closest('.control-group').".$targetBehavior."();";
					// set the target default
					$bucket[$target['name']]['default'] = PHP_EOL."\t\tjQuery('".$targetType.$target['name'].$targetTypeSufix."').closest('.control-group').".$targetDefault."();";
					// the hide required function
					if($target['required'] === 'yes')
					{
						$hide = PHP_EOL."\t\tif (!jform_".$unique."_required)";
						$hide .= PHP_EOL."\t\t{";
						$hide .= PHP_EOL."\t\t\tupdateFieldRequired('".$target['name']."',1);";
						$hide .= PHP_EOL."\t\t\tjQuery('#jform_".$target['name']."').removeAttr('required');";
						$hide .= PHP_EOL."\t\t\tjQuery('#jform_".$target['name']."').removeAttr('aria-required');";
						$hide .= PHP_EOL."\t\t\tjQuery('#jform_".$target['name']."').removeClass('required');";
						$hide .= PHP_EOL."\t\t\tjform_".$unique."_required = true;";
						$hide .= PHP_EOL."\t\t}";
						$bucket[$target['name']]['hide'] = $hide;
						// the show required function
						$show = PHP_EOL."\t\tif (jform_".$unique."_required)";
						$show .= PHP_EOL."\t\t{";
						$show .= PHP_EOL."\t\t\tupdateFieldRequired('".$target['name']."',0);";
						$show .= PHP_EOL."\t\t\tjQuery('#jform_".$target['name']."').prop('required','required');";
						$show .= PHP_EOL."\t\t\tjQuery('#jform_".$target['name']."').attr('aria-required',true);";
						$show .= PHP_EOL."\t\t\tjQuery('#jform_".$target['name']."').addClass('required');";
						$show .= PHP_EOL."\t\t\tjform_".$unique."_required = false;";
						$show .= PHP_EOL."\t\t}".PHP_EOL;
						$bucket[$target['name']]['show'] = $show;
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


	public function ifValueScript($value,$behavior,$type,$options)
	{
		// reset string
		$string = '';
		switch ($behavior)
		{
			case 1: // Is
			// only 4 list/radio/checkboxes
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option)
					{
						if (!is_numeric($option))
						{
							if($option != 'true' && $option != 'false')
							{
								$option = "'".$option."'";
							}
						}
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.' == '.$option;
						}
						else
						{
							$string .= $value.' == '.$option;
						}
					}
				}
				else
				{
					$string .= 'isSet('.$value.')';
				}
			}
			break;
			case 2: // Is Not
			// only 4 list/radio/checkboxes
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option)
					{
						if (!is_numeric($option))
						{
							if($option != 'true' && $option != 'false')
							{
								$option = "'".$option."'";
							}
						}
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.' != '.$option;
						}
						else
						{
							$string .= $value.' != '.$option;
						}
					}
				}
				else
				{
					$string .= '!isSet('.$value.')';
				}
			}
			break;
			case 3: // Any Selection
			// only 4 list/radio/checkboxes/dynamic_list
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					foreach ($options as $option)
					{
						if (!is_numeric($option))
						{
							if($option != 'true' && $option != 'false')
							{
								$option = "'".$option."'";
							}
						}
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.' == '.$option;
						}
						else
						{
							$string .= $value.' == '.$option;
						}
					}
				}
				else
				{
					$userFix = '';
					if (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($type,$this->setScriptUserSwitch))
					{
						// TODO this needs a closer look, a bit buggy
						$userFix = " && ".$value." != 0";
					}
					//echo '<pre>'; var_dump($type);exit;
					$string .= 'isSet('.$value.')'.$userFix;
				}
			}
			break;
			case 4: // Active (not empty)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				$string .= 'isSet('.$value.')';
			}
			break;
			case 5: // Unactive (empty)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				$string .= '!isSet('.$value.')';
			}
			break;
			case 6: // Key Word All (case-sensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' && '.$value.'.indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 7: // Key Word Any (case-sensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.'.indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 8: // Key Word All (case-insensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						$keyword = ComponentbuilderHelper::safeString($keyword, 'w');
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' && '.$value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 9: // Key Word Any (case-insensitive)
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options['keywords']))
				{
					foreach ($options['keywords'] as $keyword)
					{
						$keyword = ComponentbuilderHelper::safeString($keyword, 'w');
						if(ComponentbuilderHelper::checkString($string))
						{
							$string .= ' || '.$value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
						else
						{
							$string .= $value.'.toLowerCase().indexOf("'.$keyword.'") >= 0';
						}
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.' == "error"';
				}
			}
			break;
			case 10: // Min Length
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					if ($options['length'])
					{
						$string .= $value.'.length >= '.(int) $options['length'];
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.'.length >= 5';
				}
			}
			break;
			case 11: // Max Length
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))

			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					if ($options['length'])
					{
						$string .= $value.'.length <= '.(int) $options['length'];
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.'.length <= 5';
				}
			}
			break;
			case 12: // Exact Length
			// only 4 text_field
			if(ComponentbuilderHelper::typeField($type, 'text'))
			{
				if (ComponentbuilderHelper::checkArray($options))
				{
					if ($options['length'])
					{
						$string .= $value.'.length == '.(int) $options['length'];
					}
				}
				if(!ComponentbuilderHelper::checkString($string))
				{
					$string .= $value.'.length == 5';
				}
			}
			break;
		}
		if(!ComponentbuilderHelper::checkString($string))
		{
			$string = 0;
		}
		return $string;
	}

	public function getOptionsScript($type,$options)
	{
		$buket = array();
		if(ComponentbuilderHelper::checkString($options))
		{
			if(ComponentbuilderHelper::typeField($type, 'list') || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
			{
				$optionsArray = explode(PHP_EOL, $options);
				if (!ComponentbuilderHelper::checkArray($optionsArray))
				{
					$optionsArray[] = $optionsArray;
				}
				foreach($optionsArray as $option)
				{
					if (strpos($option,'|') !== false)
					{
						list($option) = explode('|', $option);
					}
					if ($option != 'dynamic_list')
					{
						// add option to return buket
						$buket[] = $option;
					}
				}
			}
			elseif(ComponentbuilderHelper::typeField($type, 'text'))
			{
				// check to get the key words if set
				$keywords = ComponentbuilderHelper::getBetween($options,'keywords="','"');
				if (ComponentbuilderHelper::checkString($keywords))
				{
					if (strpos($keywords,',') !== false)
					{
						$keywords = explode(',', $keywords);
						foreach($keywords as $keyword)
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
				$length = ComponentbuilderHelper::getBetween($options,'length="','"');
				if (ComponentbuilderHelper::checkString($length))
				{
					$buket['length'] = $length;
				} else {
					$buket['length'] = false;
				}
			}
		}

		return $buket;
	}

	public function getValueScript($type,$name,$extends,$unique)
	{
		$select		= '';
		$isArray	= false;
		$keyName	= $name.'_'.$unique;
		if ($type === 'checkboxes' || $extends === 'checkboxes')
		{
			$select =  "var ".$keyName." = [];".PHP_EOL."\tjQuery('#jform_".$name." input[type=checkbox]').each(function()".PHP_EOL."\t{".PHP_EOL."\t\tif (jQuery(this).is(':checked'))".PHP_EOL."\t\t{".PHP_EOL."\t\t\t".$keyName.".push(jQuery(this).prop('value'));".PHP_EOL."\t\t}".PHP_EOL."\t});";
			$isArray = true;
		}
		elseif($type === 'checkbox')
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.'").prop(\'checked\');';
		}
		elseif ($type === 'radio')
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.' input[type=\'radio\']:checked").val();';
		}
		elseif (isset($this->setScriptUserSwitch) && ComponentbuilderHelper::checkArray($this->setScriptUserSwitch) && in_array($type,$this->setScriptUserSwitch))
		{
			// this is only since 3.3.4
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.'_id").val();';
		}
		elseif ($type === 'list' || ComponentbuilderHelper::typeField($type, 'dynamic') || !ComponentbuilderHelper::typeField($type))
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.'").val();';
			$isArray = true;
		}
		elseif(ComponentbuilderHelper::typeField($type, 'text'))
		{
			$select = 'var '.$keyName.' = jQuery("#jform_'.$name.'").val();';
		}
		return array( 'get' => $select, 'isArray' => $isArray);
	}

	public function clearValueScript($type,$name,$unique)
	{
		$clear		= '';
		$isArray	= false;
		$keyName	= $name.'_'.$unique;
		if($type === 'text' || $type === 'password' || $type === 'textarea')
		{
			$clear =  "jQuery('#jform_".$name."').value = '';";
		}
		elseif($type === 'radio')
		{
			$clear = "jQuery('#jform_".$name."').checked = false;";
		}
		elseif($type === 'checkboxes' || $type === 'checkbox' || $type === 'checkbox')
		{
			$clear = "jQuery('#jform_".$name."').selectedIndex = -1;";
		}
		return $clear;
	}

	public function setViewScript(&$view)
	{
		if (isset($this->editBodyViewScriptBuilder[$view]) && isset($this->editBodyViewScriptBuilder[$view]['fileScript']))
		{
			return $this->editBodyViewScriptBuilder[$view]['fileScript'];
		}
		return '';
	}

	public function setEditBodyScript(&$view)
	{
		if (isset($this->editBodyViewScriptBuilder[$view]) && isset($this->editBodyViewScriptBuilder[$view]['footerScript']))
		{
			return $this->editBodyViewScriptBuilder[$view]['footerScript'];
		}
		return '';
	}

	public function setValidationFix($view,$Component)
	{
		$fix = '';
		if (isset($this->validationFixBuilder[$view]) && ComponentbuilderHelper::checkArray($this->validationFixBuilder[$view]))
		{
			$fix .= PHP_EOL.PHP_EOL."\t/**";
			$fix .= PHP_EOL."\t* Method to validate the form data.";
			$fix .= PHP_EOL."\t*";
			$fix .= PHP_EOL."\t* @param   JForm   \$form   The form to validate against.";
			$fix .= PHP_EOL."\t* @param   array   \$data   The data to validate.";
			$fix .= PHP_EOL."\t* @param   string  \$group  The name of the field group to validate.";
			$fix .= PHP_EOL."\t*";
			$fix .= PHP_EOL."\t* @return  mixed  Array of filtered data if valid, false otherwise.";
			$fix .= PHP_EOL."\t*";
			$fix .= PHP_EOL."\t* @see     JFormRule";
			$fix .= PHP_EOL."\t* @see     JFilterInput";
			$fix .= PHP_EOL."\t* @since   12.2";
			$fix .= PHP_EOL."\t*/";
			$fix .= PHP_EOL."\tpublic function validate(\$form, \$data, \$group = null)";
			$fix .= PHP_EOL."\t{";
			$fix .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." check if the not_required field is set";
			$fix .= PHP_EOL."\t\tif (".$Component."Helper::checkString(\$data['not_required']))";
			$fix .= PHP_EOL."\t\t{";
			$fix .= PHP_EOL."\t\t\t\$requiredFields = (array) explode(',',(string) \$data['not_required']);";
			$fix .= PHP_EOL."\t\t\t\$requiredFields = array_unique(\$requiredFields);";
			$fix .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." now change the required field attributes value";
			$fix .= PHP_EOL."\t\t\tforeach (\$requiredFields as \$requiredField)";
			$fix .= PHP_EOL."\t\t\t{";
			$fix .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." make sure there is a string value";
			$fix .= PHP_EOL."\t\t\t\tif (".$Component."Helper::checkString(\$requiredField))";
			$fix .= PHP_EOL."\t\t\t\t{";
			$fix .= PHP_EOL."\t\t\t\t\t//".$this->setLine(__LINE__)." change to false";
			$fix .= PHP_EOL."\t\t\t\t\t\$form->setFieldAttribute(\$requiredField, 'required', 'false');";
			$fix .= PHP_EOL."\t\t\t\t\t//".$this->setLine(__LINE__)." also clear the data set";
			$fix .= PHP_EOL."\t\t\t\t\t\$data[\$requiredField] = '';";
			$fix .= PHP_EOL."\t\t\t\t}";
			$fix .= PHP_EOL."\t\t\t}";
			$fix .= PHP_EOL."\t\t}";
			$fix .= PHP_EOL."\t\treturn parent::validate(\$form, \$data, \$group);";
			$fix .= PHP_EOL."\t}";
		}
		return $fix;
	}

	public function setAjaxToke(&$view)
	{
		$fix = '';
		if (isset($this->customScriptBuilder['token'][$view]) && $this->customScriptBuilder['token'][$view])
		{
			$fix .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Add Ajax Token";
			$fix .= PHP_EOL."\t\t\$document->addScriptDeclaration(\"var token = '\".JSession::getFormToken().\"';\");";
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
					$tasks .= PHP_EOL."\t\t\$this->registerTask('".$name."', 'ajax');";
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
			$getModel = array();
			$userCheck = array();
			foreach ($this->customScriptBuilder[$target]['ajax_controller'] as $view)
			{
				foreach ($view as $task)
				{
					$input[$task['task_name']][] = PHP_EOL."\t\t\t\t\t\t\$".$task['value_name']."Value = \$jinput->get('".$task['value_name']."', ".$task['input_default'].", '".$task['input_filter']."');";
					$valueArray[$task['task_name']][] = "\$".$task['value_name']."Value";
					$getModel[$task['task_name']] = PHP_EOL."\t\t\t\t\t\t\t\$result = \$this->getModel('ajax')->".$task['method_name']."([[[valueArray]]]);";
					
					// see user check is needed
					if (isset($task['user_check']) && 1 == $task['user_check'])
					{
						// add it since this means it was not set, and in the old method we assumed it was inplace
						// or it is set and 1 means we still want it inplace
						$userCheck[$task['task_name']] = ' && $user->id != 0';
					}
					else
					{
						$userCheck[$task['task_name']] = '';
					}
				}
			}
			if (ComponentbuilderHelper::checkArray($getModel))
			{
				foreach ($getModel as $task => $getMethod)
				{
					$cases .= PHP_EOL."\t\t\t\tcase '".$task."':";
					$cases .= PHP_EOL."\t\t\t\t\ttry";
					$cases .= PHP_EOL."\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\t\$returnRaw = \$jinput->get('raw', false, 'BOOLEAN');";
					foreach ($input[$task] as $string)
					{
						$cases .= $string;
					}
					// set the values
					$values = implode(', ',$valueArray[$task]);
					$ifvalues = implode(' && ',$valueArray[$task]);
					// set the values to method
					$getMethod = str_replace('[[[valueArray]]]',$values,$getMethod);
					$cases .= PHP_EOL."\t\t\t\t\t\tif(".$ifvalues.$userCheck[$task].")";
					$cases .= PHP_EOL."\t\t\t\t\t\t{";
					$cases .= $getMethod;
					$cases .= PHP_EOL."\t\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\t\telse";
					$cases .= PHP_EOL."\t\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\t\t\$result = false;";
					$cases .= PHP_EOL."\t\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\t\tif(\$callback = \$jinput->get('callback', null, 'CMD'))";
					$cases .= PHP_EOL."\t\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\t\techo \$callback . \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL."\t\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\t\telseif(\$returnRaw)";
					$cases .= PHP_EOL."\t\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\t\techo json_encode(\$result);";
					$cases .= PHP_EOL."\t\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\t\telse";
					$cases .= PHP_EOL."\t\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\t\techo \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL."\t\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\tcatch(Exception \$e)";
					$cases .= PHP_EOL."\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\tif(\$callback = \$jinput->get('callback', null, 'CMD'))";
					$cases .= PHP_EOL."\t\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\t\techo \$callback.\"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL."\t\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\t\telse";
					$cases .= PHP_EOL."\t\t\t\t\t\t{";
					$cases .= PHP_EOL."\t\t\t\t\t\t\techo \"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL."\t\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\t\t}";
					$cases .= PHP_EOL."\t\t\t\tbreak;";
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
				$methods .= PHP_EOL.PHP_EOL."\t//".$this->setLine(__LINE__)." Used in ".$view.PHP_EOL;
				$methods .= $this->setPlaceholders($method, $this->placeholders);
			}
		}
		return $methods;
	}


	public function setFilterFunctions($viewName_single,$viewName_list)
	{
		if (isset($this->filterBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$viewName_list]))
		{
			$function = array();
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
			foreach ($this->filterBuilder[$viewName_list] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] === 'user')
				{
					$function[] = PHP_EOL."\tprotected function getThe".$filter['function'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F')."Selections()";
					$function[] = "\t{";
					$function[] = "\t\t//".$this->setLine(__LINE__)." Get a db connection.";
					$function[] = "\t\t\$db = JFactory::getDbo();";
					$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
					$function[] = "\t\t\$query = \$db->getQuery(true);";
					$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Select the text.";
					$function[] = "\t\t\$query->select(\$db->quoteName(array('a.".$filter['custom']['id']."','a.".$filter['custom']['text']."')));";
					$function[] = "\t\t\$query->from(\$db->quoteName('".$filter['custom']['table']."', 'a'));";
					$function[] = "\t\t//".$this->setLine(__LINE__)." get the targeted groups";
					$function[] = "\t\t\$groups= JComponentHelper::getParams('com_".$component."')->get('".$filter['type']."');";
					$function[] = "\t\tif (count(\$groups) > 0)";
					$function[] = "\t\t{";
					$function[] = "\t\t\t\$query->join('LEFT', \$db->quoteName('#__user_usergroup_map', 'group') . ' ON (' . \$db->quoteName('group.user_id') . ' = ' . \$db->quoteName('a.id') . ')');";
					$function[] = "\t\t\t\$query->where('group.group_id IN (' . implode(',', \$groups) . ')');";
					$function[] = "\t\t}";
					$function[] = "\t\t\$query->order('a.".$filter['custom']['text']." ASC');";
					$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$function[] = "\t\t\$db->setQuery(\$query);";
					$function[] = PHP_EOL."\t\t\$results = \$db->loadObjectList();";
					$function[] = "\t\tif (\$results)";
					$function[] = "\t\t{";
					$function[] = "\t\t\t\$filter = array();";
					$function[] = "\t\t\t\$batch = array();";
					$function[] = "\t\t\tforeach (\$results as \$result)";
					$function[] = "\t\t\t{";
					$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", \$result->".$filter['custom']['text'].");";
					$function[] = "\t\t\t}";
					$function[] = "\t\t\treturn  \$filter;";
					$function[] = "\t\t}";
					$function[] = "\t\treturn false;";
					$function[] = "\t}";

					/* else
					{
						$function[] = PHP_EOL."\tprotected function getThe".$filter['function'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F')."Selections()";
						$function[] = "\t{";
						$function[] = "\t\t//".$this->setLine(__LINE__)." Get a db connection.";
						$function[] = "\t\t\$db = JFactory::getDbo();";
						$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Select the text.";
						$function[] = "\t\t\$query = \$db->getQuery(true);";
						$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Select the text.";
						$function[] = "\t\t\$query->select(\$db->quoteName(array('".$filter['custom']['id']."','".$filter['custom']['text']."')));";
						$function[] = "\t\t\$query->from(\$db->quoteName('".$filter['custom']['table']."'));";
						$function[] = "\t\t\$query->where(\$db->quoteName('published') . ' = 1');";
						$function[] = "\t\t\$query->order(\$db->quoteName('".$filter['custom']['text']."') . ' ASC');";
						$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
						$function[] = "\t\t\$db->setQuery(\$query);";
						$function[] = PHP_EOL."\t\t\$results = \$db->loadObjectList();";
						$function[] = PHP_EOL."\t\tif (\$results)";
						$function[] = "\t\t{";
						$function[] = "\t\t\t\$filter = array();";
						$function[] = "\t\t\t\$batch = array();";
						$function[] = "\t\t\tforeach (\$results as \$result)";
						$function[] = "\t\t\t{";
						if ($filter['custom']['text'] === 'user')
						{
							$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['text'].", JFactory::getUser(\$result->".$filter['custom']['text'].")->name);";
							$function[] = "\t\t\t\t\$batch[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", JFactory::getUser(\$result->".$filter['custom']['text'].")->name);";
						}
						else
						{
							$function[] = "\t\t\t\t\$filter[] = JHtml::_('select.option', \$result->".$filter['custom']['text'].", \$result->".$filter['custom']['text'].");";
							$function[] = "\t\t\t\t\$batch[] = JHtml::_('select.option', \$result->".$filter['custom']['id'].", \$result->".$filter['custom']['text'].");";
						}
						$function[] = "\t\t\t}";
						$function[] = "\t\t\treturn array('filter' => \$filter, 'batch' => \$batch);";
						$function[] = "\t\t}";
						$function[] = "\t\treturn false;";
						$function[] = "\t}";
					}*/
				}
				elseif ($filter['type'] != 'category' && !ComponentbuilderHelper::checkArray($filter['custom']))
				{
					$translation = false;
					if (isset($this->selectionTranslationFixBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$viewName_list])
						&& array_key_exists($filter['code'],$this->selectionTranslationFixBuilder[$viewName_list]))
					{
						$translation = true;
					}
					$function[] = PHP_EOL."\tprotected function getThe".$filter['function']."Selections()";
					$function[] = "\t{";
					$function[] = "\t\t//".$this->setLine(__LINE__)." Get a db connection.";
					$function[] = "\t\t\$db = JFactory::getDbo();";
					$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Create a new query object.";
					$function[] = "\t\t\$query = \$db->getQuery(true);";
					$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Select the text.";
					$function[] = "\t\t\$query->select(\$db->quoteName('".$filter['code']."'));";
					$function[] = "\t\t\$query->from(\$db->quoteName('#__".$component."_".$filter['database']."'));";
					$function[] = "\t\t\$query->order(\$db->quoteName('".$filter['code']."') . ' ASC');";
					$function[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Reset the query using our newly populated query object.";
					$function[] = "\t\t\$db->setQuery(\$query);";
					$function[] = PHP_EOL."\t\t\$results = \$db->loadColumn();";
					$function[] = PHP_EOL."\t\tif (\$results)";
					$function[] = "\t\t{";
					// check if translated vlaue is used
					if ($translation)
					{
						$function[] = "\t\t\t//".$this->setLine(__LINE__)." get model";
						$function[] = "\t\t\t\$model = \$this->getModel();";
					}
					$function[] = "\t\t\t\$results = array_unique(\$results);";
					$function[] = "\t\t\t\$_filter = array();";
					$function[] = "\t\t\tforeach (\$results as \$".$filter['code'].")";
					$function[] = "\t\t\t{";

					// check if translated vlaue is used
					if ($translation)
					{
						$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." Translate the ".$filter['code']." selection";
						$function[] = "\t\t\t\t\$text = \$model->selectionTranslation(\$".$filter['code'].",'".$filter['code']."');";
						$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." Now add the ".$filter['code']." and its text to the options array";
						$function[] = "\t\t\t\t\$_filter[] = JHtml::_('select.option', \$".$filter['code'].", JText::_(\$text));";
					}
					elseif ($filter['type'] === 'user')
					{
						$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." Now add the ".$filter['code']." and its text to the options array";
						$function[] = "\t\t\t\t\$_filter[] = JHtml::_('select.option', \$".$filter['code'].", JFactory::getUser(\$".$filter['code'].")->name);";
					}
					else
					{
						$function[] = "\t\t\t\t//".$this->setLine(__LINE__)." Now add the ".$filter['code']." and its text to the options array";
						$function[] = "\t\t\t\t\$_filter[] = JHtml::_('select.option', \$".$filter['code'].", \$".$filter['code'].");";
					}
					$function[] = "\t\t\t}";
					$function[] = "\t\t\treturn \$_filter;";
					$function[] = "\t\t}";
					$function[] = "\t\treturn false;";
					$function[] = "\t}";
				}
			}
			if (ComponentbuilderHelper::checkArray($function))
			{
				// return the function
				return PHP_EOL.implode(PHP_EOL,$function);
			}
		}
		return '';
	}

	public function setUniqueFields(&$view)
	{
		$fields = array();
		$fields[] = PHP_EOL.PHP_EOL."\t/**";
		$fields[] = "\t * Method to get the unique fields of this table.";
		$fields[] = "\t *";
		$fields[] = "\t * @return  mixed  An array of field names, boolean false if none is set.";
		$fields[] = "\t *";
		$fields[] = "\t * @since   3.0";
		$fields[] = "\t */";
		$fields[] = "\tprotected function getUniqeFields()";
		$fields[] = "\t{";
		if (isset($this->dbUniqueKeys[$view]) && ComponentbuilderHelper::checkArray($this->dbUniqueKeys[$view]))
		{
			$fields[] = "\t\treturn array('".implode("','",$this->dbUniqueKeys[$view])."');";
		}
		else
		{
			$fields[] = "\t\treturn false;";
		}
		$fields[] = "\t}";
		// return the unique fields
		return implode(PHP_EOL,$fields);
	}

	public function setOtherFilter(&$view)
	{
		if (isset($this->filterBuilder[$view]) && ComponentbuilderHelper::checkArray($this->filterBuilder[$view]))
		{
			$otherFilter = array();
			foreach ($this->filterBuilder[$view] as $filter)
			{
				if ($filter['type'] != 'category' && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] !== 'user')
				{
					$CodeName = ComponentbuilderHelper::safeString($filter['code'].' '.$filter['custom']['text'],'W');
					$codeName = $filter['code'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F');
					$type = ComponentbuilderHelper::safeString($filter['custom']['type'],'F');
					$otherFilter[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set ".$CodeName." Selection";
					$otherFilter[] = "\t\t\$this->".$codeName."Options = JFormHelper::loadFieldType('".$type."')->getOptions();";
					$otherFilter[] = "\t\tif (\$this->".$codeName."Options)";
					$otherFilter[] = "\t\t{";
					$otherFilter[] = "\t\t\t//".$this->setLine(__LINE__)." ".$CodeName." Filter";
					$otherFilter[] = "\t\t\tJHtmlSidebar::addFilter(";
					$otherFilter[] = "\t\t\t\t'- Select '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t'filter_".$filter['code']."',";
					$otherFilter[] = "\t\t\t\tJHtml::_('select.options', \$this->".$codeName."Options, 'value', 'text', \$this->state->get('filter.".$filter['code']."'))";
					$otherFilter[] = "\t\t\t);";

					$otherFilter[] = PHP_EOL."\t\t\tif (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$otherFilter[] = "\t\t\t{";
					$otherFilter[] = "\t\t\t\t//".$this->setLine(__LINE__)." ".$CodeName." Batch Selection";
					$otherFilter[] = "\t\t\t\tJHtmlBatch_::addListSelection(";
					$otherFilter[] = "\t\t\t\t\t'- Keep Original '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t\t'batch[".$filter['code']."]',";
					$otherFilter[] = "\t\t\t\t\tJHtml::_('select.options', \$this->".$codeName."Options, 'value', 'text')";
					$otherFilter[] = "\t\t\t\t);";
					$otherFilter[] = "\t\t\t}";

					$otherFilter[] = "\t\t}";
				}
				elseif ($filter['type'] != 'category')
				{
					$Codename = ComponentbuilderHelper::safeString($filter['code'],'W');
					if (isset($filter['custom']) && ComponentbuilderHelper::checkArray($filter['custom']) && $filter['custom']['extends'] === 'user')
					{
						$functionName = "\$this->getThe".$filter['function'].ComponentbuilderHelper::safeString($filter['custom']['text'],'F')."Selections();";
					}
					else
					{
						$functionName = "\$this->getThe".$filter['function']."Selections();";
					}
					$otherFilter[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Set ".$Codename." Selection";
					$otherFilter[] = "\t\t\$this->".$filter['code']."Options = ".$functionName;
					$otherFilter[] = "\t\tif (\$this->".$filter['code']."Options)";
					$otherFilter[] = "\t\t{";
					$otherFilter[] = "\t\t\t//".$this->setLine(__LINE__)." ".$Codename." Filter";
					$otherFilter[] = "\t\t\tJHtmlSidebar::addFilter(";
					$otherFilter[] = "\t\t\t\t'- Select '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t'filter_".$filter['code']."',";
					$otherFilter[] = "\t\t\t\tJHtml::_('select.options', \$this->".$filter['code']."Options, 'value', 'text', \$this->state->get('filter.".$filter['code']."'))";
					$otherFilter[] = "\t\t\t);";

					$otherFilter[] = PHP_EOL."\t\t\tif (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$otherFilter[] = "\t\t\t{";
					$otherFilter[] = "\t\t\t\t//".$this->setLine(__LINE__)." ".$Codename." Batch Selection";
					$otherFilter[] = "\t\t\t\tJHtmlBatch_::addListSelection(";
					$otherFilter[] = "\t\t\t\t\t'- Keep Original '.JText::_('".$filter['lang']."').' -',";
					$otherFilter[] = "\t\t\t\t\t'batch[".$filter['code']."]',";
					$otherFilter[] = "\t\t\t\t\tJHtml::_('select.options', \$this->".$filter['code']."Options, 'value', 'text')";
					$otherFilter[] = "\t\t\t\t);";
					$otherFilter[] = "\t\t\t}";

					$otherFilter[] = "\t\t}";
				}
			}
			if (ComponentbuilderHelper::checkArray($otherFilter))
			{
				// return the filter
				return PHP_EOL.implode(PHP_EOL,$otherFilter);
			}
		}
		return '';
	}

	public function setCategoryFilter($viewName_list)
	{
		if (isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))
		{
			// check if category has another name
			if (isset($this->catOtherName[$viewName_list]) && ComponentbuilderHelper::checkArray($this->catOtherName[$viewName_list]))
			{
				$otherViews = $this->catOtherName[$viewName_list]['views'];
			}
			else
			{
				$otherViews = $viewName_list;
			}
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
			$COMONENT = ComponentbuilderHelper::safeString($this->componentData->name_code,'U');
			// set filter
			$filter = array();
			$filter[] = PHP_EOL.PHP_EOL."\t\t//".$this->setLine(__LINE__)." Category Filter.";
			$filter[] = "\t\tJHtmlSidebar::addFilter(";
			$filter[] = "\t\t\tJText::_('JOPTION_SELECT_CATEGORY'),";
			$filter[] = "\t\t\t'filter_category_id',";
			$filter[] = "\t\t\tJHtml::_('select.options', JHtml::_('category.options', 'com_".$component.".".$otherViews."'), 'value', 'text', \$this->state->get('filter.category_id'))";
			$filter[] = "\t\t);";


			$filter[] = PHP_EOL."\t\tif (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
			$filter[] = "\t\t{";
			$filter[] = "\t\t\t//".$this->setLine(__LINE__)." Category Batch selection.";
			$filter[] = "\t\t\tJHtmlBatch_::addListSelection(";
			$filter[] = "\t\t\t\tJText::_('COM_".$COMONENT."_KEEP_ORIGINAL_CATEGORY'),";
			$filter[] = "\t\t\t\t'batch[category]',";
			$filter[] = "\t\t\t\tJHtml::_('select.options', JHtml::_('category.options', 'com_".$component.".".$otherViews."'), 'value', 'text')";
			$filter[] = "\t\t\t);";
			$filter[] = "\t\t}";

			// return the filter
			return implode(PHP_EOL,$filter);
		}
		return '';
	}



	public function setRouterCategoryViews($viewName_single,$viewName_list)
	{
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
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
			if (!isset($this->fileContentDynamic['category'.$otherViews]['###view###']))
			{
				// lets also set the category helper for this view
				$target = array('site' => 'category'.$viewName_list);
				$this->buildDynamique($target, 'category');
				// insure the file gets updated
				$this->fileContentDynamic['category'.$otherViews]['###view###'] = $otherView;
				$this->fileContentDynamic['category'.$otherViews]['###View###'] = ucfirst($otherView);
				$this->fileContentDynamic['category'.$otherViews]['###views###'] = $otherViews;
				$this->fileContentDynamic['category'.$otherViews]['###Views###'] = ucfirst($otherViews);
				// set script to global helper file
				$includeHelper = array();
				$includeHelper[] = "\n//".$this->setLine(__LINE__)."Insure this view category file is loaded.";
				$includeHelper[] = "\$classname = '".$this->fileContentStatic['###component###'] . ucfirst($viewName_list) . "Categories';";
				$includeHelper[] = "if (!class_exists(\$classname))";
				$includeHelper[] = "{";
				$includeHelper[] = "\t\$path = JPATH_SITE . '/components/com_".$this->fileContentStatic['###component###']."/helpers/category" . $viewName_list . ".php';";
				$includeHelper[] = "\tif (is_file(\$path))";
				$includeHelper[] = "\t{";
				$includeHelper[] = "\t\tinclude_once \$path;";
				$includeHelper[] = "\t}";
				$includeHelper[] = "}";
				$this->fileContentStatic['###CATEGORY_CLASS_TREES###'] .= implode("\n",$includeHelper);
			}
			// return category view string
			if (isset($this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###']) && ComponentbuilderHelper::checkString($this->fileContentStatic['###ROUTER_CATEGORY_VIEWS###']))
			{
				return ",".PHP_EOL."\t\t\t".'"com_'.$component.'.'.$otherViews.'" => "'.$otherView.'"';
			}
			else
			{
				return PHP_EOL."\t\t\t".'"com_'.$component.'.'.$otherViews.'" => "'.$otherView.'"';
			}
		}
		return '';

	}

	public function setJcontrollerAllowAdd($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if item has category
		if(0) //isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])) <-- remove category from check
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
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." get the user object";
			$allow[] = "\t\t\$user = JFactory::getUser();";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = \$user->authorise('".$core['core.access']."', 'com_".$component."');";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			$allow[] = "\t\t\$categoryId = JArrayHelper::getValue(\$data, 'catid', \$this->input->getInt('filter_category_id'), 'int');";
			$allow[] = "\t\t\$allow = null;";
			$allow[] = PHP_EOL."\t\tif (\$categoryId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." If the category has been passed in the URL check it.";
			$allow[] = "\t\t\t\$allow = \$user->authorise('core.create', \$this->option . '.".$otherViews.".category.' . \$categoryId);";
			$allow[] = "\t\t}";
			$allow[] = PHP_EOL."\t\tif (\$allow === null)";
			$allow[] = "\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
			{
				// setup the default script
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\t\treturn \$user->authorise('".$core['core.create']."', \$this->option);";
			}
			else
			{
				// setup the default script
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\t\treturn parent::allowAdd(\$data);";
			}
			$allow[] = "\t\t}";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\treturn \$allow;";
			$allow[] = "\t\t}";
		}
		else
		{
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = JFactory::getUser()->authorise('".$core['core.access']."', 'com_".$component."');";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
			{
				// setup the default script
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn JFactory::getUser()->authorise('".$core['core.create']."', \$this->option);";
			}
			else
			{
				// setup the default script
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn parent::allowAdd(\$data);";
			}
		}
		return implode(PHP_EOL,$allow);
	}

	public function setJcontrollerAllowEdit($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// prepare custom permission script
                $customAllow = $this->getCustomScriptBuilder('php_allowedit', $viewName_single, '', null, true);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list])){
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
			$allow[] = "\t\t//".$this->setLine(__LINE__)." get user object.";
			$allow[] = "\t\t\$user\t\t= JFactory::getUser();";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." get record id.";
			$allow[] = "\t\t\$recordId\t= (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = (\$user->authorise('".$core['core.access']."', 'com_".$component.".".$otherView.".' . (int) \$recordId) && \$user->authorise('".$core['core.access']."', 'com_".$component."'));";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			$allow[] = PHP_EOL."\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($otherView,$this->permissionBuilder[$core['core.edit']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit']."', 'com_".$component.".".$otherView.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit', 'com_".$component.".".$otherView.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission)";
			$allow[] = "\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder[$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.own']]) && in_array($otherView,$this->permissionBuilder[$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component.".".$otherView.".' . \$recordId))";
			}
			else
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component.".".$otherView.".' . \$recordId))";
			}
			$allow[] = "\t\t\t\t{";
			$allow[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Fallback on edit.own. Now test the owner is the user.";
			$allow[] = "\t\t\t\t\t\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = "\t\t\t\t\tif (empty(\$ownerId))";
			$allow[] = "\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." Need to do a lookup from the model.";
			$allow[] = "\t\t\t\t\t\t\$record = \$this->getModel()->getItem(\$recordId);";
			$allow[] = PHP_EOL."\t\t\t\t\t\tif (empty(\$record))";
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn false;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t\t\$ownerId = \$record->created_by;";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = PHP_EOL."\t\t\t\t\t//".$this->setLine(__LINE__)." If the owner matches 'me' then do the test.";
			$allow[] = "\t\t\t\t\tif (\$ownerId == \$user->id)";
			$allow[] = "\t\t\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder['global'][$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.own']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component."'))";
			}
			else
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component."'))";
			}
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn true;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = "\t\t\t\t}";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
//			$allow[] = PHP_EOL."\t\t\t\$categoryId = (int) isset(\$data['catid']) ? \$data['catid']: \$this->getModel()->getItem(\$recordId)->catid;";  <-- remove category from check
//			$allow[] = PHP_EOL."\t\t\tif (\$categoryId)";
//			$allow[] = "\t\t\t{";
//			$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." The category has been set. Check the category permissions.";
//			$allow[] = "\t\t\t\t\$catpermission = \$user->authorise('core.edit', \$this->option . '.".$otherView.".category.' . \$categoryId);";
//			$allow[] = "\t\t\t\tif (!\$catpermission && !is_null(\$catpermission))";
//			$allow[] = "\t\t\t\t{";
//			$allow[] = "\t\t\t\t\treturn false;";
//			$allow[] = "\t\t\t\t}";
//			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($otherView,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit']."', \$this->option);";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn parent::allowEdit(\$data, \$key);";
			}
		}
		else
		{
			// setup the category script
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." get user object.";
			$allow[] = "\t\t\$user\t\t= JFactory::getUser();";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." get record id.";
			$allow[] = "\t\t\$recordId\t= (int) isset(\$data[\$key]) ? \$data[\$key] : 0;";
			// load custom permission script
			$allow[] = $customAllow;
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder[$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.access']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.access']]))
			{
				$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Access check.";
				$allow[] = "\t\t\$access = (\$user->authorise('".$core['core.access']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId) &&  \$user->authorise('".$core['core.access']."', 'com_".$component."'));";
				$allow[] = "\t\tif (!\$access)";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\treturn false;";
				$allow[] = "\t\t}";
			}
			$allow[] = PHP_EOL."\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission)";
			$allow[] = "\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder[$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.own']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component.".".$viewName_single.".' . \$recordId))";
			}
			else
			{
				$allow[] = "\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component.".".$viewName_single.".' . \$recordId))";
			}
			$allow[] = "\t\t\t\t{";
			$allow[] = "\t\t\t\t\t//".$this->setLine(__LINE__)." Now test the owner is the user.";
			$allow[] = "\t\t\t\t\t\$ownerId = (int) isset(\$data['created_by']) ? \$data['created_by'] : 0;";
			$allow[] = "\t\t\t\t\tif (empty(\$ownerId))";
			$allow[] = "\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t//".$this->setLine(__LINE__)." Need to do a lookup from the model.";
			$allow[] = "\t\t\t\t\t\t\$record = \$this->getModel()->getItem(\$recordId);";
			$allow[] = PHP_EOL."\t\t\t\t\t\tif (empty(\$record))";
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn false;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t\t\$ownerId = \$record->created_by;";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = PHP_EOL."\t\t\t\t\t//".$this->setLine(__LINE__)." If the owner matches 'me' then allow.";
			$allow[] = "\t\t\t\t\tif (\$ownerId == \$user->id)";
			$allow[] = "\t\t\t\t\t{";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.own']) && isset($this->permissionBuilder['global'][$core['core.edit.own']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.own']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.own']]))
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('".$core['core.edit.own']."', 'com_".$component."'))";
			}
			else
			{
				$allow[] = "\t\t\t\t\t\tif (\$user->authorise('core.edit.own', 'com_".$component."'))";
			}
			$allow[] = "\t\t\t\t\t\t{";
			$allow[] = "\t\t\t\t\t\t\treturn true;";
			$allow[] = "\t\t\t\t\t\t}";
			$allow[] = "\t\t\t\t\t}";
			$allow[] = "\t\t\t\t}";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit']."', \$this->option);";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Since there is no permission, revert to the component permissions.";
				$allow[] = "\t\treturn parent::allowEdit(\$data, \$key);";
			}
		}

		return implode(PHP_EOL,$allow);
	}

	public function setJmodelAdminGetForm($viewName_single,$viewName_list)
	{
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// allways load these
		$allow = array();
		$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get the form.";
		$allow[] = "\t\t\$form = \$this->loadForm('com_".$component.".".$viewName_single."', '".$viewName_single."', array('control' => 'jform', 'load_data' => \$loadData));";
		$allow[] = PHP_EOL."\t\tif (empty(\$form))";
		$allow[] = "\t\t{";
		$allow[] = "\t\t\treturn false;";
		$allow[] = "\t\t}";
		// load license locker
		if ($this->componentData->add_license && $this->componentData->license_type == 3 && isset($this->fileContentDynamic[$viewName_single]['###BOOLMETHOD###']))
		{
			$allow[] = $this->checkStatmentLicenseLocked($this->fileContentDynamic[$viewName_single]['###BOOLMETHOD###']);
		}
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(0) //isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))  <-- remove category from check
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
			$allow[] = PHP_EOL."\t\t\$jinput = JFactory::getApplication()->input;";
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$allow[] = "\t\tif (\$jinput->get('a_id'))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('a_id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Determine correct permissions to check.";
			$allow[] = "\t\tif (\$this->getState('".$viewName_single.".id'))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$this->getState('".$viewName_single.".id');";
			$allow[] = PHP_EOL."\t\t\t\$catid = 0;";
			$allow[] = "\t\t\tif (isset(\$this->getItem(\$id)->catid))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." set category id";
			$allow[] = "\t\t\t\t\$catid = \$this->getItem(\$id)->catid;";
			$allow[] = PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Existing record. Can only edit in selected categories.";
			$allow[] = "\t\t\t\t\$form->setFieldAttribute('catid', 'action', 'core.edit');";
			$allow[] = PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Existing record. Can only edit own items in selected categories.";
			$allow[] = "\t\t\t\t\$form->setFieldAttribute('catid', 'action', 'core.edit.own');";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." New record. Can only create in selected categories.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('catid', 'action', 'core.create');";
			$allow[] = "\t\t}";
			$allow[] = PHP_EOL."\t\t\$user = JFactory::getUser();";
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Check for existing item.";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit State access controls.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (isset(\$catid) && \$catid != 0 && !\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_list.".category.' . (int) \$catid))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.state']."', 'com_".$component."')))";
			}
			else
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (isset(\$catid) && \$catid != 0 && !\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_list.".category.' . (int) \$catid))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('core.edit.state', 'com_".$component."')))";
			}
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'disabled', 'true');";
			$allow[] = PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'filter', 'unset');";
			$allow[] = "\t\t}";
		}
		else
		{
			$allow[] = PHP_EOL."\t\t\$jinput = JFactory::getApplication()->input;";
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$allow[] = "\t\tif (\$jinput->get('a_id'))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('a_id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$allow[] = "\t\telse";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$id = \$jinput->get('id', 0, 'INT');";
			$allow[] = "\t\t}";
			$allow[] = PHP_EOL."\t\t\$user = JFactory::getUser();";
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Check for existing item.";
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit State access controls.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.state']."', 'com_".$component."')))";
			}
			else
			{
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('core.edit.state', 'com_".$component."')))";
			}
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'disabled', 'true');";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
			$allow[] = "\t\t\t\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$allow[] = "\t\t\t\$form->setFieldAttribute('published', 'filter', 'unset');";
			$allow[] = "\t\t}";
		}		
		$allow[] = "\t\t//".$this->setLine(__LINE__)." If this is a new item insure the greated by is set.";
		$allow[] = "\t\tif (0 == \$id)";
		$allow[] = "\t\t{";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Set the created_by to this user";
		$allow[] = "\t\t\t\$form->setValue('created_by', null, \$user->id);";
		$allow[] = "\t\t}";
		$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit Creaded By access controls.";
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit.created_by']) && isset($this->permissionBuilder[$core['core.edit.created_by']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.created_by']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.created_by']]))
		{
			$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.created_by']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
			$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.created_by']."', 'com_".$component."')))";
		}
		else
		{
			$allow[] = "\t\tif (!\$user->authorise('core.edit.created_by', 'com_".$component."'))";
		}
		$allow[] = "\t\t{";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created_by', 'disabled', 'true');";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created_by', 'readonly', 'true');";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created_by', 'filter', 'unset');";
		$allow[] = "\t\t}";
		$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit Creaded Date access controls.";
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit.created']) && isset($this->permissionBuilder[$core['core.edit.created']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.created']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.created']]))
		{
			$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$core['core.edit.created']."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
			$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$core['core.edit.created']."', 'com_".$component."')))";
		}
		else
		{
			$allow[] = "\t\tif (!\$user->authorise('core.edit.created', 'com_".$component."'))";
		}
		$allow[] = "\t\t{";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created', 'disabled', 'true');";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
		$allow[] = "\t\t\t\$form->setFieldAttribute('created', 'filter', 'unset');";
		$allow[] = "\t\t}";
		// handel the fields permissions
		if (isset($this->permissionFields[$viewName_single]) && ComponentbuilderHelper::checkArray($this->permissionFields[$viewName_single]))
		{
			foreach ($this->permissionFields[$viewName_single] as $fieldName => $fieldType)
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." Modify the form based on Edit ".ComponentbuilderHelper::safeString($fieldName, 'W')." access controls.";
				$allow[] = "\t\tif (\$id != 0 && (!\$user->authorise('".$viewName_single.".edit.".$fieldName."', 'com_".$component.".".$viewName_single.".' . (int) \$id))";
				$allow[] = "\t\t\t|| (\$id == 0 && !\$user->authorise('".$viewName_single.".edit.".$fieldName."', 'com_".$component."')))";
				$allow[] = "\t\t{";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
				$allow[] = "\t\t\t\$form->setFieldAttribute('".$fieldName."', 'disabled', 'true');";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable fields for display.";
				$allow[] = "\t\t\t\$form->setFieldAttribute('".$fieldName."', 'readonly', 'true');";
				if ('radio' === $fieldType || 'repeatable' === $fieldType)
				{
					$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Disable radio button for display.";
					$allow[] = "\t\t\t\$class = \$form->getFieldAttribute('".$fieldName."', 'class', '');";
					$allow[] = "\t\t\t\$form->setFieldAttribute('".$fieldName."', 'class', \$class.' disabled no-click');";
				}
				$allow[] = "\t\t\tif (!\$form->getValue('".$fieldName."'))";
				$allow[] = "\t\t\t{";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
				$allow[] = "\t\t\t\t\$form->setFieldAttribute('".$fieldName."', 'filter', 'unset');";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." Disable fields while saving.";
				$allow[] = "\t\t\t\t\$form->setFieldAttribute('".$fieldName."', 'required', 'false');";
				$allow[] = "\t\t\t}";
				$allow[] = "\t\t}";
			}
		}
		// add the redirect trick to set the field of origin		
		$allow[] = "\t\t//".$this->setLine(__LINE__)." Only load these values if no id is found";
		$allow[] = "\t\tif (0 == \$id)";
		$allow[] = "\t\t{";		
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Set redirected field name";
		$allow[] = "\t\t\t\$redirectedField = \$jinput->get('ref', null, 'STRING');";
		$allow[] = "\t\t\t//".$this->setLine(__LINE__)." Set redirected field value";
		$allow[] = "\t\t\t\$redirectedValue = \$jinput->get('refid', 0, 'INT');";
		$allow[] = "\t\t\tif (0 != \$redirectedValue && \$redirectedField)";
		$allow[] = "\t\t\t{";
		$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." Now set the local-redirected field default value";
		$allow[] = "\t\t\t\t\$form->setValue(\$redirectedField, null, \$redirectedValue);";
		$allow[] = "\t\t\t}";
		$allow[] = "\t\t}";
		// setup the default script
		$allow[] = PHP_EOL."\t\treturn \$form;";

		return implode(PHP_EOL,$allow);
	}

	public function setJmodelAdminAllowEdit($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// prepare custom permission script
                $customAllow = $this->getCustomScriptBuilder('php_allowedit', $viewName_single, "\t\t\$recordId\t= (int) isset(\$data[\$key]) ? \$data[\$key] : 0;".PHP_EOL);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder[$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit']]))
		{
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Check specific edit permission then general edit permission.";
			$allow[] = "\t\t\$user = JFactory::getUser();";
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = "\t\treturn \$user->authorise('".$core['core.edit']."', 'com_".$component.".".$viewName_single.".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or \$user->authorise('".$core['core.edit']."',  'com_".$component."');";
		}
		else
		{
			$allow[] = PHP_EOL."\t\t//".$this->setLine(__LINE__)." Check specific edit permission then general edit permission.";
			if (ComponentbuilderHelper::checkString($customAllow))
			{
				$allow[] = "\t\t\$user = JFactory::getUser();";
			}
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = "\t\treturn JFactory::getUser()->authorise('core.edit', 'com_".$component.".".$viewName_single.".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or parent::allowEdit(\$data, \$key);";
		}

		return implode(PHP_EOL,$allow);
	}

	public function setJmodelAdminCanDelete($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(0) //isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))  <-- remove category from check
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
			$allow[] = PHP_EOL."\t\tif (!empty(\$record->id))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\tif (\$record->published != -2)";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn;";
			$allow[] = "\t\t\t}";
			$allow[] = PHP_EOL."\t\t\t\$user = JFactory::getUser();";
			$allow[] = "\t\t\t\$allow = \$user->authorise('core.delete', 'com_".$component.".".$otherViews.".category.' . (int) \$record->catid);";
			// check if the item has permissions.
			if ($coreLoad && isset($this->permissionBuilder[$core['core.delete']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.delete']]) && in_array($otherView,$this->permissionBuilder[$core['core.delete']]))
			{
				$allow[] = PHP_EOL."\t\t\tif (\$allow)";
				$allow[] = "\t\t\t{";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\t\treturn \$user->authorise('".$core['core.delete']."', 'com_".$component.".".$otherView.".' . (int) \$record->id);";
				$allow[] = "\t\t\t}";
			}
			else
			{
				$allow[] = PHP_EOL."\t\t\tif (\$allow)";
				$allow[] = "\t\t\t{";
				$allow[] = "\t\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\t\treturn \$user->authorise('core.delete', 'com_".$component.".".$otherView.".' . (int) \$record->id);";
				$allow[] = "\t\t\t}";
			}
			$allow[] = "\t\t\treturn \$allow;";
			$allow[] = "\t\t}";
			$allow[] = "\t\treturn false;";
		}
		else
		{
			// setup the default script
			$allow[] = PHP_EOL."\t\tif (!empty(\$record->id))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\tif (\$record->published != -2)";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn;";
			$allow[] = "\t\t\t}";
			// check if the item has permissions.
			if ($coreLoad && (isset($core['core.delete']) && isset($this->permissionBuilder[$core['core.delete']])) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.delete']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.delete']]))
			{
				$allow[] = PHP_EOL."\t\t\t\$user = JFactory::getUser();";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\treturn \$user->authorise('".$core['core.delete']."', 'com_".$component.".".$viewName_single.".' . (int) \$record->id);";
			}
			else
			{
				$allow[] = PHP_EOL."\t\t\t\$user = JFactory::getUser();";
				$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
				$allow[] = "\t\t\treturn \$user->authorise('core.delete', 'com_".$component.".".$viewName_single.".' . (int) \$record->id);";
			}
			$allow[] = "\t\t}";
			$allow[] = "\t\treturn false;";
		}

		return implode(PHP_EOL,$allow);
	}

	public function setJmodelAdminCanEditState($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		if(0) // isset($this->categoryBuilder[$viewName_list]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$viewName_list]))  <-- remove category from check
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
			$allow[] = PHP_EOL."\t\t\$user = JFactory::getUser();";
			$allow[] = "\t\t\$recordId\t= (!empty(\$record->id)) ? \$record->id : 0;";
			$allow[] = PHP_EOL."\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission && !is_null(\$permission))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			// setup the category script
			$allow[] = "\t\t//".$this->setLine(__LINE__)." Check against the category.";
			$allow[] = "\t\tif (!empty(\$record->catid))";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t\$catpermission = \$user->authorise('core.edit.state', 'com_".$component.".".$otherViews.".category.' . (int) \$record->catid);";
			$allow[] = "\t\t\tif (!\$catpermission && !is_null(\$catpermission))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit.state']."', 'com_".$component."');";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn parent::canEditState(\$record);";
			}
		}
		else
		{
			// setup the default script
			$allow[] = PHP_EOL."\t\t\$user = JFactory::getUser();";
			$allow[] = "\t\t\$recordId\t= (!empty(\$record->id)) ? \$record->id : 0;";
			$allow[] = PHP_EOL."\t\tif (\$recordId)";
			$allow[] = "\t\t{";
			$allow[] = "\t\t\t//".$this->setLine(__LINE__)." The record has been set. Check the record permissions.";
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder[$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder[$core['core.edit.state']]))
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('".$core['core.edit.state']."', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			else
			{
				$allow[] = "\t\t\t\$permission = \$user->authorise('core.edit.state', 'com_".$component.".".$viewName_single.".' . (int) \$recordId);";
			}
			$allow[] = "\t\t\tif (!\$permission && !is_null(\$permission))";
			$allow[] = "\t\t\t{";
			$allow[] = "\t\t\t\treturn false;";
			$allow[] = "\t\t\t}";
			$allow[] = "\t\t}";
			if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn \$user->authorise('".$core['core.edit.state']."', 'com_".$component."');";
			}
			else
			{
				$allow[] = "\t\t//".$this->setLine(__LINE__)." In the absense of better information, revert to the component permissions.";
				$allow[] = "\t\treturn parent::canEditState(\$record);";
			}
		}
		return implode(PHP_EOL,$allow);
	}



	public function setJviewListCanDo($viewName_single,$viewName_list)
	{
		$allow = array();
		// set component name
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$viewName_single]))
		{
			$core = $this->permissionCore[$viewName_single];
			$coreLoad = true;
		}
		// check if the item has permissions for edit.
		if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit']]))
		{
			$allow[] = PHP_EOL."\t\t\$this->canEdit\t\t= \$this->canDo->get('".$core['core.edit']."');";
		}
		else
		{
			$allow[] = PHP_EOL."\t\t\$this->canEdit\t\t= \$this->canDo->get('core.edit');";
		}
		// check if the item has permissions for edit state.
		if ($coreLoad && isset($core['core.edit.state']) && isset($this->permissionBuilder['global'][$core['core.edit.state']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit.state']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.edit.state']]))
		{
			$allow[] = "\t\t\$this->canState\t\t= \$this->canDo->get('".$core['core.edit.state']."');";
		}
		else
		{
			$allow[] = "\t\t\$this->canState\t\t= \$this->canDo->get('core.edit.state');";
		}
		// check if the item has permissions for create.
		if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.create']]))
		{
			$allow[] = "\t\t\$this->canCreate\t= \$this->canDo->get('".$core['core.create']."');";
		}
		else
		{
			$allow[] = "\t\t\$this->canCreate\t= \$this->canDo->get('core.create');";
		}
		// check if the item has permissions for delete.
		if ($coreLoad && isset($core['core.delete']) && isset($this->permissionBuilder['global'][$core['core.delete']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.delete']]) && in_array($viewName_single,$this->permissionBuilder['global'][$core['core.delete']]))
		{
			$allow[] = "\t\t\$this->canDelete\t= \$this->canDo->get('".$core['core.delete']."');";
		}
		else
		{
			$allow[] = "\t\t\$this->canDelete\t= \$this->canDo->get('core.delete');";
		}
		// check if the item has permissions for batch.
		if ($coreLoad && isset($core['core.batch']) && isset($this->permissionBuilder['global']['global'][$core['core.batch']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global']['global'][$core['core.batch']]) && in_array($viewName_single,$this->permissionBuilder['global']['global'][$core['core.delete']]))
		{
			$allow[] = "\t\t\$this->canBatch\t= (\$this->canDo->get('".$core['core.batch']."') && \$this->canDo->get('core.batch'));";
		}
		else
		{
			$allow[] = "\t\t\$this->canBatch\t= \$this->canDo->get('core.batch');";
		}

		return implode(PHP_EOL,$allow);
	}

	public function setFieldSetAccessControl(&$view)
	{
		$access = '';
		if ($view != 'component')
		{
			// set component name
			$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// set label
			$label = 'Permissions in relation to this '.$view;
			// set the access fieldset
			$access = "<!--".$this->setLine(__LINE__)." Access Control Fields. -->";
			$access .= PHP_EOL."\t".'<fieldset name="accesscontrol">';
			$access .= PHP_EOL."\t\t<!--".$this->setLine(__LINE__)." Asset Id Field. Type: Hidden (joomla) -->";
			$access .= PHP_EOL."\t\t".'<field';
			$access .= PHP_EOL."\t\t\t".'name="asset_id"';
			$access .= PHP_EOL."\t\t\t".'type="hidden"';
			$access .= PHP_EOL."\t\t\t".'filter="unset"';
			$access .= PHP_EOL."\t\t".'/>';
			$access .= PHP_EOL."\t\t<!--".$this->setLine(__LINE__)." Rules Field. Type: Rules (joomla) -->";
			$access .= PHP_EOL."\t\t".'<field';
			$access .= PHP_EOL."\t\t\t".'name="rules"';
			$access .= PHP_EOL."\t\t\t".'type="rules"';
			$access .= PHP_EOL."\t\t\t".'label="'.$label.'"';
			$access .= PHP_EOL."\t\t\t".'translate_label="false"';
			$access .= PHP_EOL."\t\t\t".'filter="rules"';
			$access .= PHP_EOL."\t\t\t".'validate="rules"';
			$access .= PHP_EOL."\t\t\t".'class="inputbox"';
			$access .= PHP_EOL."\t\t\t".'component="com_'.$component.'"';
			$access .= PHP_EOL."\t\t\t".'section="'.$view.'"';
			$access .= PHP_EOL."\t\t".'/>';
			$access .= PHP_EOL."\t".'</fieldset>';
		}
		// return access field set
		return $access;
	}

	public function setFilterFields(&$view)
	{
		// keep track of all fields already added
		$donelist = array('id','search','published','access','created_by','modified_by');
		// default filter fields
		$fields = "'a.id','id'";
		$fields .= ",".PHP_EOL."\t\t\t\t'a.published','published'";
		if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
		{
			$fields .= ",".PHP_EOL."\t\t\t\t'a.access','access'";
		}
		$fields .= ",".PHP_EOL."\t\t\t\t'a.ordering','ordering'";
		$fields .= ",".PHP_EOL."\t\t\t\t'a.created_by','created_by'";
		$fields .= ",".PHP_EOL."\t\t\t\t'a.modified_by','modified_by'";

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= ",".PHP_EOL."\t\t\t\t'c.title','category_title'";
						$fields .= ",".PHP_EOL."\t\t\t\t'c.id', 'category_id'";
						if ($filter['code'] != 'category')
						{
							$fields .= ",".PHP_EOL."\t\t\t\t'a.".$filter['code']."', '".$filter['code']."'";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$fields .= ",".PHP_EOL."\t\t\t\t'".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'";
						}*/
						$fields .= ",".PHP_EOL."\t\t\t\t'a.".$filter['code']."','".$filter['code']."'";
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
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= ",".PHP_EOL."\t\t\t\t'c.title','category_title'";
						$fields .= ",".PHP_EOL."\t\t\t\t'c.id', 'category_id'";
						if ($filter['code'] != 'category')
						{
							$fields .= ",".PHP_EOL."\t\t\t\t'a.".$filter['code']."', '".$filter['code']."'";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$fields .= ",".PHP_EOL."\t\t\t\t'".$filter['custom']['db'].".".$filter['custom']['text']."','".$filter['code']."_".$filter['custom']['text']."'";
						}*/
						$fields .= ",".PHP_EOL."\t\t\t\t'a.".$filter['code']."','".$filter['code']."'";
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
		$donelist = array('id','search','published','access','created_by','modified_by');
		// set the defaults first
		$stored = "//".$this->setLine(__LINE__)." Compile the store id.";
		$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.id');";
		$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.search');";
		$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.published');";
		if (isset($this->accessBuilder[$view]) && ComponentbuilderHelper::checkString($this->accessBuilder[$view]))
		{
			$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.access');";
		}
		$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.ordering');";
		$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.created_by');";
		$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.modified_by');";
		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] === 'category')
					{
						$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.category');";
						$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.category_id');";
						if ($filter['code'] != 'category')
						{
							$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."_".$filter['custom']['text']."');";
						}*/
						$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
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
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] === 'category')
					{
						$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.category');";
						$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.category_id');";
						if ($filter['code'] != 'category')
						{
							$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
						}
					}
					else
					{
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."_".$filter['custom']['text']."');";
						}*/
						$stored .= PHP_EOL."\t\t\$id .= ':' . \$this->getState('filter.".$filter['code']."');";
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
			$viewNameLang_readonly	= $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_single.' readonly','U');
			// load to lang
			$this->langContent[$this->lang][$viewNameLang_readonly] = $view['settings']->name_single.' :: Readonly';

			// build toolbar
			$toolBar = "JFactory::getApplication()->input->set('hidemainmenu', true);";
			$toolBar .= PHP_EOL."\t\tJToolBarHelper::title(JText::_('".$viewNameLang_readonly."'), '".$viewName."');";
			$toolBar .= PHP_EOL."\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CLOSE');";
		}
		else
		{
			// set lang strings
			$viewNameLang_new	= $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_single.' New','U');
			$viewNameLang_edit	= $this->langPrefix.'_'.ComponentbuilderHelper::safeString($view['settings']->name_single.' Edit','U');
			// load to lang
			$this->langContent[$this->lang][$viewNameLang_new] = 'A New '.$view['settings']->name_single;
			$this->langContent[$this->lang][$viewNameLang_edit] = 'Editing the '.$view['settings']->name_single;
			// build toolbar
			$toolBar = "JFactory::getApplication()->input->set('hidemainmenu', true);";
			$toolBar .= PHP_EOL."\t\t\$user = JFactory::getUser();";
			$toolBar .= PHP_EOL."\t\t\$userId	= \$user->id;";
			$toolBar .= PHP_EOL."\t\t\$isNew = \$this->item->id == 0;";
			$toolBar .= PHP_EOL.PHP_EOL."\t\tJToolbarHelper::title( JText::_(\$isNew ? '".$viewNameLang_new."' : '".$viewNameLang_edit."'), 'pencil-2 article-add');";
			$toolBar .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Built the actions for new and existing records.";
			$toolBar .= PHP_EOL."\t\tif (\$this->refid || \$this->ref)";
			$toolBar .= PHP_EOL."\t\t{";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL."\t\t\tif (\$this->canDo->get('".$core['core.create']."') && \$isNew)";
			}
			else
			{
				$toolBar .= PHP_EOL."\t\t\tif (\$this->canDo->get('core.create') && \$isNew)";
			}
			$toolBar .= PHP_EOL."\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." We can create the record.";
			$toolBar .= PHP_EOL."\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL."\t\t\t}";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$toolBar .= PHP_EOL."\t\t\telseif (\$this->canDo->get('".$core['core.edit']."'))";
			}
			else
			{
				$toolBar .= PHP_EOL."\t\t\telseif (\$this->canDo->get('core.edit'))";
			}
			$toolBar .= PHP_EOL."\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." We can save the record.";
			$toolBar .= PHP_EOL."\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL."\t\t\t}";
			$toolBar .= PHP_EOL."\t\t\tif (\$isNew)";
			$toolBar .= PHP_EOL."\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Do not creat but cancel.";
			$toolBar .= PHP_EOL."\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= PHP_EOL."\t\t\t}";
			$toolBar .= PHP_EOL."\t\t\telse";
			$toolBar .= PHP_EOL."\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." We can close it.";
			$toolBar .= PHP_EOL."\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= PHP_EOL."\t\t\t}";
			$toolBar .= PHP_EOL."\t\t}";
			$toolBar .= PHP_EOL."\t\telse";
			$toolBar .= PHP_EOL."\t\t{";
			$toolBar .= PHP_EOL."\t\t\tif (\$isNew)";
			$toolBar .= PHP_EOL."\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." For new records, check the create permission.";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL."\t\t\t\tif (\$this->canDo->get('".$core['core.create']."'))";
			}
			else
			{
				$toolBar .= PHP_EOL."\t\t\t\tif (\$this->canDo->get('core.create'))";
			}
			$toolBar .= PHP_EOL."\t\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t\tJToolBarHelper::apply('".$viewName.".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= PHP_EOL."\t\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL."\t\t\t\t\tJToolBarHelper::custom('".$viewName.".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= PHP_EOL."\t\t\t\t};";
			$toolBar .= PHP_EOL."\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= PHP_EOL."\t\t\t}";
			$toolBar .= PHP_EOL."\t\t\telse";
			$toolBar .= PHP_EOL."\t\t\t{";
			if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.edit']]))
			{
				$toolBar .= PHP_EOL."\t\t\t\tif (\$this->canDo->get('".$core['core.edit']."'))";
			}
			else
			{
				$toolBar .= PHP_EOL."\t\t\t\tif (\$this->canDo->get('core.edit'))";
			}
			$toolBar .= PHP_EOL."\t\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t\t//".$this->setLine(__LINE__)." We can save the new record";
			$toolBar .= PHP_EOL."\t\t\t\t\tJToolBarHelper::apply('".$viewName.".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= PHP_EOL."\t\t\t\t\tJToolBarHelper::save('".$viewName.".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL."\t\t\t\t\t//".$this->setLine(__LINE__)." We can save this record, but check the create permission to see";
			$toolBar .= PHP_EOL."\t\t\t\t\t//".$this->setLine(__LINE__)." if we can return to make a new one.";
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL."\t\t\t\t\tif (\$this->canDo->get('".$core['core.create']."'))";
			}
			else
			{
				$toolBar .= PHP_EOL."\t\t\t\t\tif (\$this->canDo->get('core.create'))";
			}
			$toolBar .= PHP_EOL."\t\t\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t\t\tJToolBarHelper::custom('".$viewName.".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= PHP_EOL."\t\t\t\t\t}";
			$toolBar .= PHP_EOL."\t\t\t\t}";
                        if ($coreLoad && isset($core['core.edit']) && isset($this->permissionBuilder['global'][$core['core.edit']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.edit']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.edit']]))
                        {
                                if ($coreLoad && isset($this->historyBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->historyBuilder[$viewName]))
                                {
                                        $toolBar .= PHP_EOL."\t\t\t\t\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('".$core['core.version']."'));";
                                        $toolBar .= PHP_EOL."\t\t\t\tif (\$this->state->params->get('save_history', 1) && \$this->canDo->get('".$core['core.edit']."') && \$canVersion)";
                                        $toolBar .= PHP_EOL."\t\t\t\t{";
                                        $toolBar .= PHP_EOL."\t\t\t\t\tJToolbarHelper::versions('com_".$this->fileContentStatic['###component###'].".".$viewName."', \$this->item->id);";
                                        $toolBar .= PHP_EOL."\t\t\t\t}";
                                }
                        }
                        else
                        {                                
                                if ($coreLoad && isset($this->historyBuilder[$viewName]) && ComponentbuilderHelper::checkString($this->historyBuilder[$viewName]))
                                {
                                        $toolBar .= PHP_EOL."\t\t\t\t\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('".$core['core.version']."'));";
                                        $toolBar .= PHP_EOL."\t\t\t\tif (\$this->state->params->get('save_history', 1) && \$this->canDo->get('core.edit') && \$canVersion)";
                                        $toolBar .= PHP_EOL."\t\t\t\t{";
                                        $toolBar .= PHP_EOL."\t\t\t\t\tJToolbarHelper::versions('com_".$this->fileContentStatic['###component###'].".".$viewName."', \$this->item->id);";
                                        $toolBar .= PHP_EOL."\t\t\t\t}";
                                }
                        }
			if ($coreLoad && isset($core['core.create']) && isset($this->permissionBuilder['global'][$core['core.create']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.create']]) && in_array($viewName,$this->permissionBuilder['global'][$core['core.create']]))
			{
				$toolBar .= PHP_EOL."\t\t\t\tif (\$this->canDo->get('".$core['core.create']."'))";
			}
			else
			{
				$toolBar .= PHP_EOL."\t\t\t\tif (\$this->canDo->get('core.create'))";
			}
			$toolBar .= PHP_EOL."\t\t\t\t{";
			$toolBar .= PHP_EOL."\t\t\t\t\tJToolBarHelper::custom('".$viewName.".save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);";
			$toolBar .= PHP_EOL."\t\t\t\t}";
                        // add custom buttons
                        $toolBar .= $this->setCustomButtons($view, 2, "\t\t");
			$toolBar .= PHP_EOL."\t\t\t\tJToolBarHelper::cancel('".$viewName.".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= PHP_EOL."\t\t\t}";
			$toolBar .= PHP_EOL."\t\t}";
			$toolBar .= PHP_EOL."\t\tJToolbarHelper::divider();";
			$toolBar .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." set help url for this view if found";
			$toolBar .= PHP_EOL."\t\t\$help_url = ".$this->fileContentStatic['###Component###']."Helper::getHelpUrl('".$viewName."');";
			$toolBar .= PHP_EOL."\t\tif (".$this->fileContentStatic['###Component###']."Helper::checkString(\$help_url))";
			$toolBar .= PHP_EOL."\t\t{";
			$toolBar .= PHP_EOL."\t\t\tJToolbarHelper::help('".$this->langPrefix."_HELP_MANAGER', false, \$help_url);";
			$toolBar .= PHP_EOL."\t\t}";
		}
		return $toolBar;
	}

	public function setPopulateState(&$view)
	{
		// rest buket
		$state = '';
		// keep track of all fields already added
		$donelist = array();

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] === 'category')
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = PHP_EOL.PHP_EOL."\t\t";
						}
						$state .= $spacer."\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
						$state .= PHP_EOL."\t\t\$this->setState('filter.category', \$category);";
						$state .= PHP_EOL.PHP_EOL."\t\t\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
						$state .= PHP_EOL."\t\t\$this->setState('filter.category_id', \$categoryId);";
						if ($filter['code'] != 'category')
						{
							$state .= PHP_EOL.PHP_EOL."\t\t\$".$filter['code']." = \$app->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
							$state .= PHP_EOL."\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
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
							$spacer = PHP_EOL.PHP_EOL."\t\t";
						}
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$state .= $spacer."\$".$filter['code']."_".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."_".$filter['custom']['text']."', 'filter_".$filter['code']."_".$filter['custom']['text']."');";
							$state .= PHP_EOL."\t\t\$this->setState('filter.".$filter['code']."_".$filter['custom']['text']."', \$".$filter['code']."_".$filter['custom']['text'].");";
							$spacer = PHP_EOL.PHP_EOL."\t\t";
						}*/
						$state .= $spacer."\$".$filter['code']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
						$state .= PHP_EOL."\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
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
				if (!in_array($filter['code'],$donelist))
				{
					if ($filter['type'] === 'category')
					{
						if (strlen($state) == 0)
						{
							$spacer = "";
						}
						else
						{
							$spacer = PHP_EOL.PHP_EOL."\t\t";
						}
						$state .= $spacer."\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
						$state .= PHP_EOL."\t\t\$this->setState('filter.category', \$category);";
						$state .= PHP_EOL.PHP_EOL."\t\t\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
						$state .= PHP_EOL."\t\t\$this->setState('filter.category_id', \$categoryId);";
						if ($filter['code'] != 'category')
						{
							$state .= PHP_EOL.PHP_EOL."\t\t\$".$filter['code']." = \$app->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
							$state .= PHP_EOL."\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
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
							$spacer = PHP_EOL.PHP_EOL."\t\t";
						}
						// check if custom field is set
						/*if (ComponentbuilderHelper::checkArray($filter['custom']))
						{
							$state .= $spacer."\$".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['custom']['text']."', 'filter_".$filter['custom']['text']."');";
							$state .= PHP_EOL."\t\t\$this->setState('filter.".$filter['custom']['text']."', \$".$filter['custom']['text'].");";
							$state .= PHP_EOL."\t\t\$".$filter['code']."_".$filter['custom']['text']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."_".$filter['custom']['text']."', 'filter_".$filter['code']."_".$filter['custom']['text']."');";
							$state .= PHP_EOL."\t\t\$this->setState('filter.".$filter['code']."_".$filter['custom']['text']."', \$".$filter['code']."_".$filter['custom']['text'].");";
							$spacer = PHP_EOL.PHP_EOL."\t\t";
						}*/
						$state .= $spacer."\$".$filter['code']." = \$this->getUserStateFromRequest(\$this->context . '.filter.".$filter['code']."', 'filter_".$filter['code']."');";
						$state .= PHP_EOL."\t\t\$this->setState('filter.".$filter['code']."', \$".$filter['code'].");";
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
		$donelist = array('sorting','published');
		// set the default first
		$fields = "return array(";
		$fields .= PHP_EOL."\t\t\t'a.sorting' => JText::_('JGRID_HEADING_ORDERING')";
		$fields .= ",".PHP_EOL."\t\t\t'a.published' => JText::_('JSTATUS')";

		// add the rest of the set filters
		if (isset($this->sortBuilder[$view]) && ComponentbuilderHelper::checkArray($this->sortBuilder[$view]))
		{
			foreach ($this->sortBuilder[$view] as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= ",".PHP_EOL."\t\t\t'c.category_title' => JText::_('".$filter['lang']."')";
					}
					elseif (ComponentbuilderHelper::checkArray($filter['custom']))
					{
						$fields .= ",".PHP_EOL."\t\t\t'".$filter['custom']['db'].".".$filter['custom']['text']."' => JText::_('".$filter['lang']."')";
					}
					else
					{
						$fields .= ",".PHP_EOL."\t\t\t'a.".$filter['code']."' => JText::_('".$filter['lang']."')";
					}
				}
			}
		}
		$fields .= ",".PHP_EOL."\t\t\t'a.id' => JText::_('JGRID_HEADING_ID')";
		$fields .= PHP_EOL."\t\t);";
		// return fields
		return $fields;
	}

	public function setCheckinCall()
	{
		$call = PHP_EOL."\t\t//".$this->setLine(__LINE__)." check in items";
		$call .= PHP_EOL."\t\t\$this->checkInNow();".PHP_EOL;

		return $call;
	}

	public function setAutoCheckin($view,$component)
	{
		$checkin = PHP_EOL.PHP_EOL."\t/**";
		$checkin .= PHP_EOL."\t* Build an SQL query to checkin all items left checked out longer then a set time.";
		$checkin .= PHP_EOL."\t*";
		$checkin .= PHP_EOL."\t* @return  a bool";
		$checkin .= PHP_EOL."\t*";
		$checkin .= PHP_EOL."\t*/";
		$checkin .= PHP_EOL."\tprotected function checkInNow()";
		$checkin .= PHP_EOL."\t{";
		$checkin .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Get set check in time";
		$checkin .= PHP_EOL."\t\t\$time = JComponentHelper::getParams('com_".$component."')->get('check_in');";
		$checkin .= PHP_EOL."\t\t";
		$checkin .= PHP_EOL."\t\tif (\$time)";
		$checkin .= PHP_EOL."\t\t{";
		$checkin .= PHP_EOL.PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Get a db connection.";
		$checkin .= PHP_EOL."\t\t\t\$db = JFactory::getDbo();";
		$checkin .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." reset query";
		$checkin .= PHP_EOL."\t\t\t\$query = \$db->getQuery(true);";
		$checkin .= PHP_EOL."\t\t\t\$query->select('*');";
		$checkin .= PHP_EOL."\t\t\t\$query->from(\$db->quoteName('#__".$component."_".$view."'));";
		$checkin .= PHP_EOL."\t\t\t\$db->setQuery(\$query);";
		$checkin .= PHP_EOL."\t\t\t\$db->execute();";
		$checkin .= PHP_EOL."\t\t\tif (\$db->getNumRows())";
		$checkin .= PHP_EOL."\t\t\t{";
		$checkin .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Get Yesterdays date";
		$checkin .= PHP_EOL."\t\t\t\t\$date = JFactory::getDate()->modify(\$time)->toSql();";
		$checkin .= PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." reset query";
		$checkin .= PHP_EOL."\t\t\t\t\$query = \$db->getQuery(true);";
		$checkin .= PHP_EOL.PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Fields to update.";
		$checkin .= PHP_EOL."\t\t\t\t\$fields = array(";
		$checkin .= PHP_EOL."\t\t\t\t\t\$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',";
		$checkin .= PHP_EOL."\t\t\t\t\t\$db->quoteName('checked_out') . '=0'";
		$checkin .= PHP_EOL."\t\t\t\t);";
		$checkin .= PHP_EOL.PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Conditions for which records should be updated.";
		$checkin .= PHP_EOL."\t\t\t\t\$conditions = array(";
		$checkin .= PHP_EOL."\t\t\t\t\t\$db->quoteName('checked_out') . '!=0', ";
		$checkin .= PHP_EOL."\t\t\t\t\t\$db->quoteName('checked_out_time') . '<\''.\$date.'\''";
		$checkin .= PHP_EOL."\t\t\t\t);";
		$checkin .= PHP_EOL.PHP_EOL."\t\t\t\t//".$this->setLine(__LINE__)." Check table";
		$checkin .= PHP_EOL."\t\t\t\t\$query->update(\$db->quoteName('#__".$component."_".$view."'))->set(\$fields)->where(\$conditions); ";
		$checkin .= PHP_EOL.PHP_EOL."\t\t\t\t\$db->setQuery(\$query);";
		$checkin .= PHP_EOL.PHP_EOL."\t\t\t\t\$db->execute();";
		$checkin .= PHP_EOL."\t\t\t}";
		$checkin .= PHP_EOL."\t\t}";
		$checkin .= PHP_EOL.PHP_EOL."\t\treturn false;";
		$checkin .= PHP_EOL."\t}";

		return $checkin;
	}

	public function setGetItemsMethodStringFix($view, $Component, $tab = '', $export = false)
	{
		// add the fix if this view has the need for it
		$fix = '';
		// encryption switches
		$basicCrypt = false;
		$advancedCrypt = false;
		// setup correct core target
		$coreLoad = false;
		if (isset($this->permissionCore[$view]))
		{
			$core = $this->permissionCore[$view];
			$coreLoad = true;
		}
		$component = ComponentbuilderHelper::safeString($Component);
		// check if the item has permissions.
		if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder[$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder[$core['core.access']]) && in_array($view,$this->permissionBuilder[$core['core.access']]))
		{
			$fix .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." set values to display correctly.";
			$fix .= PHP_EOL."\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
			$fix .= PHP_EOL."\t".$tab."\t{";
			$fix .= PHP_EOL."\t".$tab."\t\t//".$this->setLine(__LINE__)." get user object.";
			$fix .= PHP_EOL."\t".$tab."\t\t\$user = JFactory::getUser();";
			$fix .= PHP_EOL."\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
			$fix .= PHP_EOL."\t".$tab."\t\t{";
			$fix .= PHP_EOL."\t".$tab."\t\t\t\$access = (\$user->authorise('".$core['core.access']."', 'com_".$component.".".$view.".' . (int) \$item->id) && \$user->authorise('".$core['core.access']."', 'com_".$component."'));";
			$fix .= PHP_EOL."\t".$tab."\t\t\tif (!\$access)";
			$fix .= PHP_EOL."\t".$tab."\t\t\t{";
			$fix .= PHP_EOL."\t".$tab."\t\t\t\tunset(\$items[\$nr]);";
			$fix .= PHP_EOL."\t".$tab."\t\t\t\tcontinue;";
			$fix .= PHP_EOL."\t".$tab."\t\t\t}".PHP_EOL;

		}
		
		if (!$export)
		{
			$methodName = 'getItemsMethodListStringFixBuilder';
		}
		else
		{
			$methodName = 'getItemsMethodEximportStringFixBuilder';
		}
		
		if (isset($this->{$methodName}[$view]) && ComponentbuilderHelper::checkArray($this->{$methodName}[$view]))
		{
			if (!ComponentbuilderHelper::checkString($fix))
			{
				$fix .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." set values to display correctly.";
				$fix .= PHP_EOL."\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
				$fix .= PHP_EOL."\t".$tab."\t{";
				$fix .= PHP_EOL."\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
				$fix .= PHP_EOL."\t".$tab."\t\t{";
			}
			
			foreach ($this->{$methodName}[$view] as $item)
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
					// ADVANCE_ENCRYPTION_VDMKEY
					$decode = '$advanced->decryptString';
					$advancedCrypt = true;
					$suffix_decode = '';
					break;
					default:
					// JSON_ARRAY_ENCODE
					$decode = 'json_decode';
					$suffix_decode = ', true';
					break;
				}
				
				if ($item['type'] === 'usergroup' && !$export)
				{
					$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." decode ".$item['name'];
					$fix .= PHP_EOL."\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= PHP_EOL."\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
					$fix .= PHP_EOL."\t".$tab."\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$".$item['name']."Names = '';";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$counter = 0;";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\tforeach (\$".$item['name']."Array as \$".$item['name'].")";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\tif (\$counter == 0)";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= ".$Component."Helper::getGroupName(\$".$item['name'].");";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t}";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\telse";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= ', '.".$Component."Helper::getGroupName(\$".$item['name'].");";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t}";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\$counter++;";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t}";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$item->".$item['name']." = \$".$item['name']."Names;";
					$fix .= PHP_EOL."\t".$tab."\t\t\t}";
				}
				/*elseif ($item['type'] === 'usergroup' && $export)
				{
					$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." decode ".$item['name'];
					$fix .= PHP_EOL."\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= PHP_EOL."\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
					$fix .= PHP_EOL."\t".$tab."\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$item->".$item['name']." = implode('|',\$".$item['name']."Array);";
					$fix .= PHP_EOL."\t".$tab."\t\t\t}";
				}*/
				elseif ($item['translation'] && !$export)
				{
					$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." convert ".$item['name'];
					$fix .= PHP_EOL."\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= PHP_EOL."\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
					$fix .= PHP_EOL."\t".$tab."\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$".$item['name']."Names = '';";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$counter = 0;";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\tforeach (\$".$item['name']."Array as \$".$item['name'].")";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\tif (\$counter == 0)";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= JText::_(\$this->selectionTranslation(\$".$item['name'].", '".$item['name']."'));";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t}";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\telse";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t{";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\t\$".$item['name']."Names .= ', '.JText::_(\$this->selectionTranslation(\$".$item['name'].", '".$item['name']."'));";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t}";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\$counter++;";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t}";
					$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$item->".$item['name']." = \$".$item['name']."Names;";
					$fix .= PHP_EOL."\t".$tab."\t\t\t}";
				}
				else
				{
					if ($item['method'] == 2 || $item['method'] == 3 || $item['method'] == 4)
					{
						$taber = '';
						if ($item['method'] == 3)
						{
							$taber = "\t";
							$fix .= PHP_EOL."\t".$tab."\t\t\tif (\$basickey && !is_numeric(\$item->".$item['name'].") && \$item->".$item['name']." === base64_encode(base64_decode(\$item->".$item['name'].", true)))";
							$fix .= PHP_EOL."\t".$tab."\t\t\t{";
						}
						if ($item['method'] == 4)
						{
							$taber = "\t";
							$fix .= PHP_EOL."\t".$tab."\t\t\tif (\$advancedkey && !is_numeric(\$item->".$item['name'].") && \$item->".$item['name']." === base64_encode(base64_decode(\$item->".$item['name'].", true)))";
							$fix .= PHP_EOL."\t".$tab."\t\t\t{";
						}
						if ($item['method'] == 3 || $item['method'] == 4)
						{
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t//".$this->setLine(__LINE__)." decrypt ".$item['name'];
						}
						else
						{
							$fix .= PHP_EOL."\t".$tab.$taber."\t\t\t//".$this->setLine(__LINE__)." decode ".$item['name'];
						}
						$fix .= PHP_EOL."\t".$tab.$taber."\t\t\t\$item->".$item['name']." = ".$decode."(\$item->".$item['name'].");";

						if ($item['method'] == 3 || $item['method'] == 4)
						{
							$fix .= PHP_EOL."\t".$tab."\t\t\t}";
						}
					}
					else
					{
						if ($export && $item['type'] === 'repeatable')
						{
							$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." decode repeatable ".$item['name'];
							$fix .= PHP_EOL."\t".$tab."\t\t\t\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
							$fix .= PHP_EOL."\t".$tab."\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."Array))";
							$fix .= PHP_EOL."\t".$tab."\t\t\t{";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\$bucket".$item['name']." = array();";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\tforeach (\$".$item['name']."Array as \$".$item['name']."FieldName => \$".$item['name'].")";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t{";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\tif (".$Component."Helper::checkArray(\$".$item['name']."))";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t{";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\t\$bucket".$item['name']."[] = \$".$item['name']."FieldName . '<||VDM||>' . implode('<|VDM|>',\$".$item['name'].");";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t}";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t}";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t//".$this->setLine(__LINE__)." make sure the bucket has values.";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\tif (".$Component."Helper::checkArray(\$bucket".$item['name']."))";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t{";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t//".$this->setLine(__LINE__)." clear the repeatable field.";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\tunset(\$item->".$item['name'].");";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t//".$this->setLine(__LINE__)." set repeatable field for export.";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t\$item->".$item['name']." = implode('<|||VDM|||>',\$bucket".$item['name'].");";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\t//".$this->setLine(__LINE__)." unset the bucket.";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t\tunset(\$bucket".$item['name'].");";
							$fix .= PHP_EOL."\t".$tab."\t\t\t\t}";
							$fix .= PHP_EOL."\t".$tab."\t\t\t}";
						}
						elseif ($item['method'] == 1 && !$export)
						{
							// TODO we check if this works well.
							$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." convert ".$item['name'];
							if (isset($item['custom']['table']))
							{
								$keyTableNAme = str_replace('#__'.$this->fileContentStatic['###component###'] .'_', '', $item['custom']['table']);
								$fix .= PHP_EOL."\t".$tab."\t\t\t\$item->".$item['name']." = ".$Component."Helper::jsonToString(\$item->".$item['name'].", ', ', '".$keyTableNAme."');";
							}
							else
							{
								$fix .= PHP_EOL."\t".$tab."\t\t\t\$item->".$item['name']." = ".$Component."Helper::jsonToString(\$item->".$item['name'].", ', ', '".$item['name']."');";
							}
						}
						else
						{
							if (!$export)
							{
								// For thos we have not cached yet.
								$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." convert ".$item['name'];
								$fix .= PHP_EOL."\t".$tab."\t\t\t\$item->".$item['name']." = ".$Component."Helper::jsonToString(\$item->".$item['name'].");";
							}
						}
					}
				}
			}
		}

		// close the foreach if needed
		if (!ComponentbuilderHelper::checkString($fix) && $export)
		{
			$fix .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." set values to display correctly.";
			$fix .= PHP_EOL."\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
			$fix .= PHP_EOL."\t".$tab."\t{";
			$fix .= PHP_EOL."\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
			$fix .= PHP_EOL."\t".$tab."\t\t{";
		}
		// close the foreach if needed
		if (ComponentbuilderHelper::checkString($fix))
		{
			// remove these values if export
			if ($export)
			{
				$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." unset the values we don't want exported.";
				$fix .= PHP_EOL."\t".$tab."\t\t\tunset(\$item->asset_id);";
				$fix .= PHP_EOL."\t".$tab."\t\t\tunset(\$item->checked_out);";
				$fix .= PHP_EOL."\t".$tab."\t\t\tunset(\$item->checked_out_time);";
			}
			$fix .= PHP_EOL."\t".$tab."\t\t}";
			$fix .= PHP_EOL."\t".$tab."\t}";
			if ($export)
			{
				$fix .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Add headers to items array.";
				$fix .= PHP_EOL."\t".$tab."\t\$headers = \$this->getExImPortHeaders();";
				$fix .= PHP_EOL."\t".$tab."\tif (".$Component."Helper::checkObject(\$headers))";
				$fix .= PHP_EOL."\t".$tab."\t{";
				$fix .= PHP_EOL."\t".$tab."\t\tarray_unshift(\$items,\$headers);";
				$fix .= PHP_EOL."\t".$tab."\t}";
			}
		}

		// add custom php to getitems method
                $fix .= $this->getCustomScriptBuilder('php_getitems', $view, PHP_EOL.PHP_EOL.$tab);

		if ($basicCrypt)
		{
			$script = PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the basic encryption key.";
			$script .= PHP_EOL."\t".$tab."\t\$basickey = ".$Component."Helper::getCryptKey('basic');";
			$script .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the encryption object.";
			$script .= PHP_EOL."\t".$tab."\t\$basic = new FOFEncryptAes(\$basickey, 128);";
			// add the encryption script
			$fix = $script . $fix;
		}

		if ($advancedCrypt)
		{
			$script = PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the advanced encryption key.";
			$script .= PHP_EOL."\t".$tab."\t\$advancedkey = ".$Component."Helper::getCryptKey('advanced');";
			$script .= PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." Get the encryption object.";
			$script .= PHP_EOL."\t".$tab."\t\$advanced = new FOFEncryptAes(\$advancedkey, 256);";
			// add the encryption script
			$fix = $script . $fix;
		}

		return $fix;
	}

	public function setSelectionTranslationFix($views,$Component,$tab = '')
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (isset($this->selectionTranslationFixBuilder[$views]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$views]))
		{
			$fix .= PHP_EOL.PHP_EOL."\t".$tab."\t//".$this->setLine(__LINE__)." set selection value to a translatable value";
			$fix .= PHP_EOL."\t".$tab."\tif (".$Component."Helper::checkArray(\$items))";
			$fix .= PHP_EOL."\t".$tab."\t{";
			$fix .= PHP_EOL."\t".$tab."\t\tforeach (\$items as \$nr => &\$item)";
			$fix .= PHP_EOL."\t".$tab."\t\t{";
			foreach ($this->selectionTranslationFixBuilder[$views] as $name => $values)
			{
				$fix .= PHP_EOL."\t".$tab."\t\t\t//".$this->setLine(__LINE__)." convert ".$name;
				$fix .= PHP_EOL."\t".$tab."\t\t\t\$item->".$name." = \$this->selectionTranslation(\$item->".$name.", '".$name."');";
			}
			$fix .= PHP_EOL."\t".$tab."\t\t}";
			$fix .= PHP_EOL."\t".$tab."\t}".PHP_EOL;
		}
		return $fix;
	}

	public function setSelectionTranslationFixFunc($views,$Component)
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (isset( $this->selectionTranslationFixBuilder[$views]) && ComponentbuilderHelper::checkArray($this->selectionTranslationFixBuilder[$views]))
		{
			$fix .= PHP_EOL.PHP_EOL."\t/**";
			$fix .= PHP_EOL."\t* Method to convert selection values to translatable string.";
			$fix .= PHP_EOL."\t*";
			$fix .= PHP_EOL."\t* @return translatable string";
			$fix .= PHP_EOL."\t*/";
			$fix .= PHP_EOL."\tpublic function selectionTranslation(\$value,\$name)";
			$fix .= PHP_EOL."\t{";
			foreach ($this->selectionTranslationFixBuilder[$views] as $name => $values)
			{
				if (ComponentbuilderHelper::checkArray($values))
				{
					$fix .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Array of ".$name." language strings";
					$fix .= PHP_EOL."\t\tif (\$name === '".$name."')";
					$fix .= PHP_EOL."\t\t{";
					$fix .= PHP_EOL."\t\t\t\$".$name."Array = array(";
					$counter = 0;
					foreach ($values as $value => $translang)
					{
						// only add quotes to strings
						if (ComponentbuilderHelper::checkString($value))
						{
							$key = "'".$value."'";
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
							$fix .=  PHP_EOL."\t\t\t\t".$key." => '".$translang."'";
						}
						else
						{
							$fix .= ",".PHP_EOL."\t\t\t\t".$key." => '".$translang."'";
						}
						$counter++;
					}
					$fix .= PHP_EOL."\t\t\t);";
					$fix .= PHP_EOL."\t\t\t//".$this->setLine(__LINE__)." Now check if value is found in this array";
					$fix .= PHP_EOL."\t\t\tif (isset(\$".$name."Array[\$value]) && ".$Component."Helper::checkString(\$".$name."Array[\$value]))";
					$fix .= PHP_EOL."\t\t\t{";
					$fix .= PHP_EOL."\t\t\t\treturn \$".$name."Array[\$value];";
					$fix .= PHP_EOL."\t\t\t}";
					$fix .= PHP_EOL."\t\t}";
				}
			}
			$fix .= PHP_EOL."\t\treturn \$value;";
			$fix .= PHP_EOL."\t}";
		}
		return $fix;
	}

	public function setRouterCase($viewName)
	{
		if (strlen($viewName) > 0)
		{
			$router = PHP_EOL."\t\tcase '".$viewName."':";
			$router .= PHP_EOL."\t\t\t\$id = explode(':', \$segments[$count-1]);";
			$router .= PHP_EOL."\t\t\t\$vars['id'] = (int) \$id[0];";
			$router .= PHP_EOL."\t\t\t\$vars['view'] = '".$viewName."';";
			$router .= PHP_EOL."\t\tbreak;";

			return $router;
		}
		return '';

	}

	public function setComponentImageType($path)
	{
		$type = ComponentbuilderHelper::imageInfo($path);
		if ($type)
		{
			$imagePath = $this->componentPath.'/admin/assets/images';
			// move the image to its place
			JFile::copy(JPATH_SITE.'/'.$path, $imagePath.'/vdm-component.'.$type,'',true);
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
			return PHP_EOL."\t\t//".$this->setLine(__LINE__)." view access array".PHP_EOL."\t\t\$viewAccess = array(".PHP_EOL."\t\t\t".implode(",".PHP_EOL."\t\t\t",$this->permissionDashboard).");";
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

				$icons .= $this->addCustomDashboardIcons($view,$counter);
				if (isset($view['dashboard_add']) && $view['dashboard_add'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo($view['settings']->icon_add);
					if ($type)
					{
						$type = $type.".";
						// icon builder loader
						$this->iconBuilder[$type.$name_single.".add"] = $view['settings']->icon_add;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'".$type.$name_single.".add'";
					}
					else
					{
						$icons .= ", '".$type.$name_single.".add'";
					}
					// build lang
					$langName	= 'Add&nbsp;'.ComponentbuilderHelper::safeString($view['settings']->name_single, 'W').'<br /><br />';
					$langKey	= $this->langPrefix.'_DASHBOARD_'.ComponentbuilderHelper::safeString($view['settings']->name_single,'U').'_ADD';
					// add to lang
					$this->langContent[$this->lang][$langKey] = $langName;
					$counter++;
				}
				if (isset($view['dashboard_list']) && $view['dashboard_list'] == 1)
				{
					$type = ComponentbuilderHelper::imageInfo($view['settings']->icon);
					if ($type)
					{
						$type = $type.".";
						// icon builder loader
						$this->iconBuilder[$type.$name_list] = $view['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					if ($counter == 0)
					{
						$icons .= "'".$type.$name_list."'";
					}
					else
					{
						$icons .= ", '".$type.$name_list."'";
					}
					// build lang
					$langName	= ComponentbuilderHelper::safeString($view['settings']->name_list, 'W').'<br /><br />';
					$langKey	= $this->langPrefix.'_DASHBOARD_'.ComponentbuilderHelper::safeString($view['settings']->name_list,'U');
					// add to lang
					$this->langContent[$this->lang][$langKey] = $langName;
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
						$langName = 'Category &nbsp;For<br />'.ComponentbuilderHelper::safeString($otherViews, 'W');
					}
					if(!in_array($otherViews,$catArray))
					{
						// add to lang
						$langKey = $this->langPrefix.'_DASHBOARD_'.ComponentbuilderHelper::safeString($otherViews,'U').'_'.ComponentbuilderHelper::safeString($catCode,'U');
						$this->langContent[$this->lang][$langKey] = $langName;
						// get image type
						$type = ComponentbuilderHelper::imageInfo($view['settings']->icon_category);
						if ($type)
						{
							$type = $type.".";
							// icon builder loader
							$this->iconBuilder[$type.$otherViews.".".$catCode] = $view['settings']->icon_category;
						}
						else
						{
							$type = 'png.';
						}
						if ($counter == 0)
						{
							$icons .= "'".$type.$otherViews.".".$catCode."'";
						}
						else
						{
							$icons .= ", '".$type.$otherViews.".".$catCode."'";
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
				$imagePath = $this->componentPath.'/admin/assets/images/icons';
				foreach ($this->iconBuilder as $icon => $path)
				{
					$array_buket = explode('.', $icon);
					if (count($array_buket) == 3)
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
						$imageName 	= $name.'_'.$action.'.'.$type;
					}
					else
					{
						$imageName 	= $name.'.'.$type;
					}
					// move the image to its place
					JFile::copy(JPATH_SITE.'/'.$path, $imagePath.'/'.$imageName,'',true);
				}
			}
			return $icons;
		}
		return false;
	}
	
	public function setDashboardModelMethods()
	{
		if ($this->componentData->add_php_dashboard_methods)
		{
			// get all the mothods that should load date to the view
			$this->DashboardGetCustomData = ComponentbuilderHelper::getAllBetween($this->componentData->php_dashboard_methods,'public function get','()');

			// return the methods
			return PHP_EOL.PHP_EOL.$this->setPlaceholders($this->componentData->php_dashboard_methods, $this->placeholders);
		}
		return '';
	}
	
	public function setDashboardGetCustomData()
	{
		if (ComponentbuilderHelper::checkArray($this->DashboardGetCustomData))
		{
			// gets array reset
			$gets = array();
			// set dashboard gets
			foreach($this->DashboardGetCustomData as $get)
			{
				$string = ComponentbuilderHelper::safeString($get);
				$tabs = (\strlen($string) < 8) ? "\t\t\t" : (\strlen($string) < 16) ? "\t\t" : (\strlen($string) < 24) ? "\t" : ' ';
				$gets[] = "\$this->".$string.$tabs."= \$this->get('".$get."');";
			}
			// return the gets
			return PHP_EOL."\t\t".implode(PHP_EOL."\t\t",$gets);
		}
		return '';
	}
	
	public function setDashboardDisplayData()
	{
		// display array reset
		$display = array();
		$mainAccordianName = 'cPanel';
		$builder = array();
		$tab = "\t";
		$loadTabs = false;
		// check if we have custom tabs
		if ($this->componentData->add_php_dashboard_methods && ComponentbuilderHelper::checkArray($this->componentData->dashboard_tab))
		{
			// build the tabs and accordians
			foreach ($this->componentData->dashboard_tab as $data)
			{
				$builder[$data['name']][$data['header']] = $this->setPlaceholders($data['html'], $this->placeholders);
			}
			// since we have custom tabs we must load the tab structure around the cpanel
			$display[] = '<div id="j-main-container">';
			$display[] = "\t".'<div class="form-horizontal">';
			$display[] = "\t<?php echo JHtml::_('bootstrap.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>";
			$display[] = PHP_EOL."\t\t<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', 'cpanel', JText::_('cPanel', true)); ?>";
			$display[] = "\t\t".'<div class="row-fluid">';
			// set the tab to insure correct spacing
			$tab = "\t\t\t";
			// change the name of the main tab
			$mainAccordianName = 'Control Panel';
			$loadTabs = true;
		}
		else
		{
			$display[] = '<div id="j-main-container">';
		}
		// set dashboard display
		$display[] = $tab.'<div class="span9">';
		$display[] = $tab."\t<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_left', array('active' => 'main')); ?>";
		$display[] = $tab."\t\t<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_left', '".$mainAccordianName."', 'main'); ?>";
		$display[] = $tab."\t\t\t<?php echo \$this->loadTemplate('main');?>";
		$display[] = $tab."\t\t<?php echo JHtml::_('bootstrap.endSlide'); ?>";
		$display[] = $tab."\t<?php echo JHtml::_('bootstrap.endAccordion'); ?>";
		$display[] = $tab."</div>";
		$display[] = $tab.'<div class="span3">';
		$display[] = $tab."\t<?php echo JHtml::_('bootstrap.startAccordion', 'dashboard_right', array('active' => 'vdm')); ?>";
		$display[] = $tab."\t\t<?php echo JHtml::_('bootstrap.addSlide', 'dashboard_right', '".$this->fileContentStatic['###COMPANYNAME###']."', 'vdm'); ?>";
		$display[] = $tab."\t\t\t<?php echo \$this->loadTemplate('vdm');?>";
		$display[] = $tab."\t\t<?php echo JHtml::_('bootstrap.endSlide'); ?>";
		$display[] = $tab."\t<?php echo JHtml::_('bootstrap.endAccordion'); ?>";
		$display[] = $tab."</div>";
		
		if ($loadTabs)
		{
			$display[] = "\t\t</div>";
			$display[] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>";  
			// load the new tabs
			foreach($builder as $tabname => $accordians)
			{
				$alias = ComponentbuilderHelper::safeString($tabname);
				$display[] = PHP_EOL."\t\t<?php echo JHtml::_('bootstrap.addTab', 'cpanel_tab', '".$alias."', JText::_('".$tabname."', true)); ?>";
				$display[] = "\t\t".'<div class="row-fluid">';
				$display[] = $tab.'<div class="span12">';
				$display[] = $tab."\t<?php  echo JHtml::_('bootstrap.startAccordion', '".$alias."_accordian', array('active' => '".$alias."_one')); ?>";
				$slidecounter = 1;
				foreach($accordians as $accordianname => $html)
				{
					$ac_alias = ComponentbuilderHelper::safeString($accordianname);
					$counterName = ComponentbuilderHelper::safeString($slidecounter);
					$tempName = $alias.'_'.$ac_alias;
					$display[] = $tab."\t\t<?php  echo JHtml::_('bootstrap.addSlide', '".$alias."_accordian', '".$accordianname."', '".$alias."_".$counterName."'); ?>";
					$display[] = $tab."\t\t\t<?php echo \$this->loadTemplate('".$tempName."');?>";
					$display[] = $tab."\t\t<?php  echo JHtml::_('bootstrap.endSlide'); ?>";
					$slidecounter++;
					// build the template file
					$target = array('custom_admin' => $this->fileContentStatic['###component###']);
					$this->buildDynamique($target,'template',$tempName);
					// set the file data
					$TARGET = ComponentbuilderHelper::safeString($this->target,'U');
					// ###SITE_TEMPLATE_BODY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$this->fileContentStatic['###component###'].'_'.$tempName]['###CUSTOM_ADMIN_TEMPLATE_BODY###'] = PHP_EOL.$html;
					// ###SITE_TEMPLATE_CODE_BODY### <<<DYNAMIC>>>
					$this->fileContentDynamic[$this->fileContentStatic['###component###'].'_'.$tempName]['###CUSTOM_ADMIN_TEMPLATE_CODE_BODY###'] = '';
				}
				$display[] = $tab."\t<?php  echo JHtml::_('bootstrap.endAccordion'); ?>";
				$display[] = $tab."</div>";
				$display[] = "\t\t</div>";
				$display[] = "\t\t<?php echo JHtml::_('bootstrap.endTab'); ?>"; 
			}
			
			$display[] = PHP_EOL."\t<?php echo JHtml::_('bootstrap.endTabSet'); ?>";
			$display[] = "\t</div>";
		}
		$display[] = "</div>";
		// return the display
		return PHP_EOL.implode(PHP_EOL,$display);
	}

	public function addCustomDashboardIcons(&$view,&$counter)
	{
		$icon = '';
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]) && $menu['dashboard_list'] == 1 && $menu['before'] == $view['adminview'])
				{
					$type = ComponentbuilderHelper::imageInfo($menu['settings']->icon);
					if ($type)
					{
						$type = $type.".";
						// icon builder loader
						$this->iconBuilder[$type.$menu['settings']->code] = $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName	= $menu['settings']->name.'<br /><br />';
					$langKey	= $this->langPrefix.'_DASHBOARD_'.$menu['settings']->CODE;
					// add to lang
					$this->langContent[$this->lang][$langKey] = $langName;
					// set icon
					if ($counter == 0)
					{
						$counter++;
						$icon .= "'".$type.$menu['settings']->code."'";
					}
					else
					{
						$counter++;
						$icon .= ", '".$type.$menu['settings']->code."'";
					}
				}
				elseif(!isset($this->customAdminAdded[$menu['settings']->code]) && $menu['dashboard_list'] == 1 && empty($menu['before']))
				{
					$type = ComponentbuilderHelper::imageInfo($menu['settings']->icon);
					if ($type)
					{
						$type = $type.".";
						// icon builder loader
						$this->iconBuilder[$type.$menu['settings']->code] = $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName	= $menu['settings']->name.'<br /><br />';
					$langKey	= $this->langPrefix.'_DASHBOARD_'.$menu['settings']->CODE;
					// add to lang
					$this->langContent[$this->lang][$langKey] = $langName;
					// set icon
					$this->lastCustomDashboardIcon[$nr] = ", '".$type.$menu['settings']->code."'";
				}
			}
		}
		// see if we should have custom menus
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				$nr		= $nr + 100;
				$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
				$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
				if ($menu['dashboard_list'] == 1 && $view['adminview'] == $menu['before'])
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						// TODO must look at adding custom links to icons aswell
						return '';
					}
					else
					{
						$type = ComponentbuilderHelper::imageInfo('images/'.$menu['icon']);
						if ($type)
						{
							$type = $type.".";
							// icon builder loader
							$this->iconBuilder[$type.$nameList] = 'images/'.$menu['icon'];
						}
						else
						{
							$type = 'png.';
						}
						// build lang
						$langName	= $menu['name'].'<br /><br />';
						$langKey	= $this->langPrefix.'_DASHBOARD_'.$nameUpper;
						// add to lang
						$this->langContent[$this->lang][$langKey] = $langName;
						// set icon
						if ($counter == 0)
						{
							$counter++;
							$icon .= "'".$type.$nameList."'";
						}
						else
						{
							$counter++;
							$icon .= ", '".$type.$nameList."'";
						}
					}
				}
				elseif($menu['dashboard_list'] == 1 && empty($menu['before']))
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						// TODO must look at adding custom links to icons aswell
						return '';
					}
					else
					{
						$type = ComponentbuilderHelper::imageInfo('images/'.$menu['icon']);
						if ($type)
						{
							$type = $type.".";
							// icon builder loader
							$this->iconBuilder[$type.$nameList] = 'images/'.$menu['icon'];
						}
						else
						{
							$type = 'png.';
						}
						// build lang
						$langName	= $menu['name'].'<br /><br />';
						$langKey	= $this->langPrefix.'_DASHBOARD_'.$nameUpper;
						// add to lang
						$this->langContent[$this->lang][$langKey] = $langName;
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '".$type.$nameList."'";
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
			$lang = $this->langPrefix.'_SUBMENU';
			// set the code name
			$codeName = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// set dashboard
			$menus .= "JHtmlSidebar::addEntry(JText::_('".$lang."_DASHBOARD'), 'index.php?option=com_".$codeName."&view=".$codeName."', \$submenu === '".$codeName."');";
			$this->langContent[$this->lang][$lang.'_DASHBOARD'] = 'Dashboard';
			$catArray = array();
			foreach ($this->componentData->admin_views as $view)
			{
				// set custom menu
				$menus .= $this->addCustomSubMenu($view,$codeName,$lang);
				if (isset($view['submenu']) && $view['submenu'] == 1)
				{
					// setup access defaults
					$tab = "";
					$nameSingle = ComponentbuilderHelper::safeString($view['settings']->name_single);
					$coreLoad = false;
					if (isset($this->permissionCore[$nameSingle]))
					{
						$core = $this->permissionCore[$nameSingle];
						$coreLoad = true;
					}
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
					{
						$menus .= PHP_EOL."\t\tif (\$user->authorise('".$core['core.access']."', 'com_".$codeName."') && \$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
						$menus .= PHP_EOL."\t\t{";
						// add tab to lines to follow
						$tab = "\t";
					}
					$nameList	= ComponentbuilderHelper::safeString($view['settings']->name_list);
					$nameUpper	= ComponentbuilderHelper::safeString($view['settings']->name_list, 'U');
					$menus .= PHP_EOL."\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), 'index.php?option=com_".$codeName."&view=".$nameList."', \$submenu === '".$nameList."');";
					$this->langContent[$this->lang][$lang."_".$nameUpper] = $view['settings']->name_list;
					// check if category has another name
					if (isset($this->catOtherName[$nameList]) && ComponentbuilderHelper::checkArray($this->catOtherName[$nameList]))
					{
						$otherViews = $this->catOtherName[$nameList]['views'];
					}
					else
					{
						$otherViews = $nameList;
					}
					if (isset($this->categoryBuilder[$nameList]) && ComponentbuilderHelper::checkArray($this->categoryBuilder[$nameList]) && !in_array($otherViews,$catArray))
					{
						$menus .= PHP_EOL."\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$this->categoryBuilder[$nameList]['name']."'), 'index.php?option=com_categories&view=categories&extension=com_".$codeName.".".$otherViews."', \$submenu === 'categories.".$otherViews."');";
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
					// check if the item has permissions.
					if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
					{
						$menus .= PHP_EOL."\t\t}";
					}
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

	public function addCustomSubMenu(&$view,&$codeName,&$lang)
	{
		// see if we should have custom menus
		$custom = '';
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]))
				{
					if ($custom = $this->setCustomAdminSubMenu($view,$codeName,$lang,$nr,$menu,'customView'))
					{
						break;
					}
				}
			}
		}
		if (isset($this->componentData->custommenus) && ComponentbuilderHelper::checkArray($this->componentData->custommenus))
		{
			foreach ($this->componentData->custommenus as $nr => $menu)
			{
				if ($custom2 = $this->setCustomAdminSubMenu($view,$codeName,$lang,$nr,$menu,'customMenu'))
				{
					$custom = $custom.$custom2;
					break;
				}
			}
		}
		return $custom;

	}
	
	public function setCustomAdminSubMenu(&$view,&$codeName,&$lang,&$nr,&$menu,$type)
	{
		if ($type === 'customMenu')
		{
			$name		= $menu['name'];
			$nameSingle	= ComponentbuilderHelper::safeString($menu['name']);
			$nameList	= ComponentbuilderHelper::safeString($menu['name']);
			$nameUpper	= ComponentbuilderHelper::safeString($menu['name'], 'U');
		}
		elseif ($type === 'customView')
		{
			$name		= $menu['settings']->name;
			$nameSingle	= $menu['settings']->code;
			$nameList	= $menu['settings']->code;
			$nameUpper	= $menu['settings']->CODE;
		}
		
		if ($menu['submenu'] == 1 && $view['adminview'] == $menu['before'])
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
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$custom .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Access control (".$core['core.access']." && ".$nameSingle.".submenu).";
				$custom .= PHP_EOL."\t\tif (\$user->authorise('".$core['core.access']."', 'com_".$codeName."') && \$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
				$custom .= PHP_EOL."\t\t{";
				// add tab to lines to follow
				$tab = "\t";
			}
			else
			{
				$custom .= PHP_EOL."\t\t//".$this->setLine(__LINE__)." Access control (".$nameSingle.".submenu).";
				$custom .= PHP_EOL."\t\tif (\$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
				$custom .= PHP_EOL."\t\t{";
				// add tab to lines to follow
				$tab = "\t";
			}
			if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
			{
				
				$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $name;
				// add custom menu
				$custom .= PHP_EOL."\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), '".$menu['link']."', \$submenu === '".$nameList."');";
			}
			else
			{
				$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $name;
				// add custom menu
				$custom .= PHP_EOL."\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), 'index.php?option=com_".$codeName."&view=".$nameList."', \$submenu === '".$nameList."');";
			}
			// check if the item has permissions.
			$custom .= PHP_EOL."\t\t}";

			return $custom;
		}
		elseif($menu['submenu'] == 1 && empty($menu['before']))
		{
			// setup access defaults
			$tab = "";
			$nameSingle	= ComponentbuilderHelper::safeString($name);
			$coreLoad = false;
			if (isset($this->permissionCore[$nameSingle]))
			{
				$core = $this->permissionCore[$nameSingle];
				$coreLoad = true;
			}
			$this->lastCustomSubMenu[$nr] = '';
			// check if the item has permissions.
			if ($coreLoad && isset($core['core.access']) && isset($this->permissionBuilder['global'][$core['core.access']]) && ComponentbuilderHelper::checkArray($this->permissionBuilder['global'][$core['core.access']]) && in_array($nameSingle,$this->permissionBuilder['global'][$core['core.access']]))
			{
				$this->lastCustomSubMenu[$nr] .= PHP_EOL."\t\tif (\$user->authorise('".$core['core.access']."', 'com_".$codeName."') && \$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
				$this->lastCustomSubMenu[$nr] .= PHP_EOL."\t\t{";
				// add tab to lines to follow
				$tab = "\t";
			}
			else
			{
				$this->lastCustomSubMenu[$nr] .= PHP_EOL."\t\tif (\$user->authorise('".$nameSingle.".submenu', 'com_".$codeName."'))";
				$this->lastCustomSubMenu[$nr] .= PHP_EOL."\t\t{";
				// add tab to lines to follow
				$tab = "\t";
			}
			if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
			{
				$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $name;
				// add custom menu
				$this->lastCustomSubMenu[$nr] .= PHP_EOL."\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), '".$menu['link']."', \$submenu === '".$nameList."');";
			}
			else
			{
				$this->langContent[$this->lang][$lang.'_'.$nameUpper] = $name;
				// add custom menu
				$this->lastCustomSubMenu[$nr] .= PHP_EOL."\t\t".$tab."JHtmlSidebar::addEntry(JText::_('".$lang."_".$nameUpper."'), 'index.php?option=com_".$codeName."&view=".$nameList."', \$submenu === '".$nameList."');";
			}
			// check if the item has permissions.
			$this->lastCustomSubMenu[$nr] .= PHP_EOL."\t\t}";
		}
		return false;
	}

	public function setMainMenus()
	{
		if (isset($this->componentData->admin_views) && ComponentbuilderHelper::checkArray($this->componentData->admin_views))
		{
			$menus = '';
			// main lang prefix
			$lang = $this->langPrefix.'_MENU';
			// set the code name
			$codeName = ComponentbuilderHelper::safeString($this->componentData->name_code);
			// set main menu name to lang
			$this->langContent['adminsys'][$lang] = '&#187; '.$this->componentData->name;
			foreach ($this->componentData->admin_views as $view)
			{
				// set custom menu
				$menus .= $this->addCustomMainMenu($view,$codeName,$lang);
				if (isset($view['mainmenu']) && $view['mainmenu'] == 1)
				{
					$nameList	= ComponentbuilderHelper::safeString($view['settings']->name_list);
					$nameUpper	= ComponentbuilderHelper::safeString($view['settings']->name_list, 'U');
					$menus .= PHP_EOL."\t\t\t".'<menu option="com_'.$codeName.'" view="'.$nameList.'">'.$lang.'_'.$nameUpper.'</menu>';
					$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $view['settings']->name_list;
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

	public function addCustomMainMenu(&$view,&$codeName,&$lang)
	{
		$customMenu = '';
		// see if we should have custom admin views
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
			foreach ($this->componentData->custom_admin_views as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]))
				{
					if ($menu['mainmenu'] == 1 && $view['adminview'] == $menu['before'])
					{
						$this->langContent['adminsys'][$lang.'_'.$menu['settings']->CODE] = $menu['settings']->name;
						// add custom menu
						$customMenu .= PHP_EOL."\t\t\t".'<menu option="com_'.$codeName.'" view="'.$menu['settings']->code.'">'.$lang.'_'.$menu['settings']->CODE.'</menu>';
					}
					elseif($menu['mainmenu'] == 1 && empty($menu['before']))
					{
						$this->langContent['adminsys'][$lang.'_'.$menu['settings']->CODE] = $menu['settings']->name;
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL."\t\t\t".'<menu option="com_'.$codeName.'" view="'.$menu['settings']->code.'">'.$lang.'_'.$menu['settings']->CODE.'</menu>';
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
				if ($menu['mainmenu'] == 1 && $view['adminview'] == $menu['before'])
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$customMenu .= PHP_EOL."\t\t\t".'<menu link="'.$menu['link'].'">'.$lang.'_'.$nameUpper.'</menu>';
					}
					else
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$customMenu .= PHP_EOL."\t\t\t".'<menu option="com_'.$codeName.'" view="'.$nameList.'">'.$lang.'_'.$nameUpper.'</menu>';
					}
				}
				elseif($menu['mainmenu'] == 1 && empty($menu['before']))
				{
					if (isset($menu['link']) && ComponentbuilderHelper::checkString($menu['link']))
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL."\t\t\t".'<menu link="'.$menu['link'].'">'.$lang.'_'.$nameUpper.'</menu>';
					}
					else
					{
						$nameList	= ComponentbuilderHelper::safeString($menu['name_code']);
						$nameUpper	= ComponentbuilderHelper::safeString($menu['name_code'], 'U');
						$this->langContent['adminsys'][$lang.'_'.$nameUpper] = $menu['name'];
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL."\t\t\t".'<menu option="com_'.$codeName.'" view="'.$nameList.'">'.$lang.'_'.$nameUpper.'</menu>';
					}
				}
			}
		}
		return $customMenu;

	}

	public function setConfigFieldsets($timer = 0)
	{
		// main lang prefix
		$lang = $this->langPrefix.'_CONFIG';
		if (1 == $timer) // this is before the admin views are build
		{
			// start loading Global params
			$autorName = ComponentbuilderHelper::htmlEscape($this->componentData->author);
			$autorEmail = ComponentbuilderHelper::htmlEscape($this->componentData->email);
			$this->extensionsParams[] = '"autorName":"'.$autorName.'","autorEmail":"'.$autorEmail.'"';
			// set the custom fields
			if (isset($this->componentData->config) && ComponentbuilderHelper::checkArray($this->componentData->config))
			{
				$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
				$viewName = 'config';
				$listViewName = 'configs';
				$placeholders = array(
						'###component###' => $component,
						'###view###' => $viewName,
						'###views###' => $listViewName);
				$spacerCounter = 'a';
				$view = '';
				$viewType = 0;
				// set the custom table key
				$dbkey = 'g';
				foreach ($this->componentData->config as $field)
				{
					$xmlField = $this->setDynamicField($field, $view, $viewType, $lang, $viewName, $listViewName, $spacerCounter, $placeholders, $dbkey, false);

					if (ComponentbuilderHelper::checkString($xmlField))
					{
						$this->configFieldSetsCustomField[$field['tabname']][] = $xmlField;
						// set global params to db on install
						$fieldName = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xmlField,'name="','"'));
						$fieldDefault = ComponentbuilderHelper::getBetween($xmlField,'default="','"');
						if (isset($field['custom_value']) && ComponentbuilderHelper::checkString($field['custom_value']))
						{
							// add array if found
							if ((strpos($field['custom_value'], '["') !== false) && (strpos($field['custom_value'], '"]') !== false))
							{
								// load the Global checkin defautls
								$this->extensionsParams[] = '"'.$fieldName.'":'.$field['custom_value'];
							}
							else
							{
								// load the Global checkin defautls
								$this->extensionsParams[] = '"'.$fieldName.'":"'.$field['custom_value'].'"';
							}
						}
						elseif (ComponentbuilderHelper::checkString($fieldDefault))
						{
							// load the Global checkin defautls
							$this->extensionsParams[] = '"'.$fieldName.'":"'.$fieldDefault.'"';
						}
					}
				}
			}
			// first run we must set the globals
			$this->setGlobalConfigFieldsets($lang,$autorName,$autorEmail);
			$this->setSiteControlConfigFieldsets($lang);
			
		}
		elseif (2 == $timer) // this is after the admin views are build
		{
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
		// we cad add more event (timers as we need)
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
				$tabCode = ComponentbuilderHelper::safeString($tab).'_custom_config';
				$tabUpper = ComponentbuilderHelper::safeString($tab,'U');
				$tabLower = ComponentbuilderHelper::safeString($tab);
				// load the request id setters for menu views
				$viewRequest = 'name="'.$tabLower.'_request_id';
				foreach($tabFields as $et => $id_field)
				{
					if(strpos($id_field,$viewRequest) !== false)
					{
						$this->setRequestValues($tabLower, $id_field, $viewRequest, 'id', 'hasIdRequest');
						unset($tabFields[$et]);
					}
					elseif (strpos($id_field,'_request_id') !== false)
					{
						// not loaded to a tab "view" name
						$_viewRequest = ComponentbuilderHelper::getBetween($id_field,'name="','_request_id');
						$searchIdKe = 'name="'.$_viewRequest.'_request_id';
						$this->setRequestValues($_viewRequest, $id_field, $searchIdKe, 'id', 'hasIdRequest');
						unset($tabFields[$et]);
					}
				}
				// load the request catid setters for menu views
				$viewRequestC = 'name="'.$tabLower.'_request_catid';
				foreach($tabFields as $ci => $catid_field)
				{
					if(strpos($catid_field,$viewRequestC) !== false)
					{
						
						$this->setRequestValues($tabLower, $catid_field, $viewRequestC, 'catid', 'hasCatIdRequest');
						unset($tabFields[$ci]);
					}
					elseif (strpos($catid_field,'_request_catid') !== false)
					{
						// not loaded to a tab "view" name
						$_viewRequestC = ComponentbuilderHelper::getBetween($catid_field,'name="','_request_catid');
						$searchCatidKe = 'name="'.$_viewRequestC.'_request_catid';
						$this->setRequestValues($_viewRequestC, $catid_field, $searchCatidKe, 'catid', 'hasCatIdRequest');
						unset($tabFields[$ci]);
					}
				}
				// load the global menu setters for single fields
				$menuSetter = $tabLower.'_menu';
				$pageSettings = array();
				foreach($tabFields as $ct => $field)
				{
					if(strpos($field,$menuSetter) !== false)
					{
						// set the values needed to insure route is done correclty
						$this->hasMenuGlobal[$tabLower] = $menuSetter;
					}
					elseif (strpos($field,'_menu"') !== false)
					{
						// not loaded to a tab "view" name
						$_tabLower = ComponentbuilderHelper::getBetween($field,'name="','_menu"');
						// set the values needed to insure route is done correclty
						$this->hasMenuGlobal[$_tabLower] = $_tabLower.'_menu';
					}
					else
					{
						$pageSettings[$ct] = $field;
					}
				}
				// insure we load the needed params
				if (in_array($tab,$front_end))
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
			$field = str_replace($search . '"', 'name="'. $key . '"', $field);
		}
		else
		{
			// update field
			$field = str_replace($search . $key . '"', 'name="'. $key . '"', $field);
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
				$tabCode = ComponentbuilderHelper::safeString($tab).'_custom_config';
				$tabUpper = ComponentbuilderHelper::safeString($tab,'U');
				$tabLower = ComponentbuilderHelper::safeString($tab);
				// setup lang
				$this->langContent[$this->lang][$lang.'_'.$tabUpper] = $tab;
				// start field set
				$this->configFieldSets[] = "\t<fieldset";
				$this->configFieldSets[] = "\t\t".'name="'.$tabCode.'"';
				$this->configFieldSets[] = "\t\t".'label="'.$lang.'_'.$tabUpper.'">';
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
				// set the fields
				$this->configFieldSets[] = implode("\t\t",$bucket);
				// close field set
				$this->configFieldSets[] = "\t</fieldset>";
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
			$this->configFieldSets[] = "\t<fieldset";
			$this->configFieldSets[] = "\t\t".'name="group_config"';
			$this->configFieldSets[] = "\t\t".'label="'.$lang.'_GROUPS_LABEL"';
			$this->configFieldSets[] = "\t\t".'description="'.$lang.'_GROUPS_DESC">';
			// setup lang
			$this->langContent[$this->lang][$lang.'_GROUPS_LABEL']		= "Target Groups";
			$this->langContent[$this->lang][$lang.'_GROUPS_DESC']		= "The Parameters for the targeted groups are set here.";
			$this->langContent[$this->lang][$lang.'_TARGET_GROUP_DESC']	= "Set the group/s being targeted by this user type.";

			foreach ($this->setGroupControl as $selector => $label)
			{
				$this->configFieldSets[] = "\t\t".'<field name="'.$selector.'"';
				$this->configFieldSets[] = "\t\t\t".'type="usergroup"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$label.'"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_TARGET_GROUP_DESC"';
				$this->configFieldSets[] = "\t\t\t".'multiple="true"';
				$this->configFieldSets[] = "\t\t/>";
				// set params defaults
				$this->extensionsParams[] = '"'.$selector.'":["2"]';
			}
			// add custom Target Groups fields
			if (isset($this->configFieldSetsCustomField['Target Groups']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Target Groups']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Target Groups']);
				unset($this->configFieldSetsCustomField['Target Groups']);
			}
			// close that fieldse
			$this->configFieldSets[] = "\t</fieldset>";
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
		$component = ComponentbuilderHelper::safeString($this->componentData->name_code);
	    
		// start building field set for config
		$this->configFieldSets[] = '<fieldset';
		$this->configFieldSets[] = "\t\t".'addrulepath="/administrator/components/com_'.$component.'/models/rules"';
		$this->configFieldSets[] = "\t\t".'addfieldpath="/administrator/components/com_'.$component.'/models/fields"';
		$this->configFieldSets[] = "\t\t".'name="global_config"';
		$this->configFieldSets[] = "\t\t".'label="'.$lang.'_GLOBAL_LABEL"';
		$this->configFieldSets[] = "\t\t".'description="'.$lang.'_GLOBAL_DESC">';
		// set application update License Key
		if ($this->componentData->add_license && 1 != $this->componentData->license_type)
		{
			// set licence type switch
			switch ($this->componentData->license_type)
			{
				case 2:
					// for updates
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_LABEL']= "Your License Key";
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_DESC']	= "To get updates you must add the license key here that you recieved from ".$this->componentData->companyname;
					// set the field
					$this->configFieldSets[] = "\t\t".'<field type="note" name="license_key_note" class="alert alert-info" label="'.$lang.'_LICENSE_KEY_NOTE_LABEL" description="'.$lang.'_LICENSE_KEY_NOTE_DESC"  />';
					break;
				case 3:
					// with vdm to lock down ownership
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_LABEL']= "Your License Key";
					$this->langContent[$this->lang][$lang.'_LICENSE_KEY_NOTE_DESC']	= "To use this component you must add the license key here that you recieved from ".$this->componentData->companyname;
					// set the field
					$this->configFieldSets[] = "\t\t".'<field type="note" name="license_key_note" class="alert alert-info" label="'.$lang.'_LICENSE_KEY_NOTE_LABEL" description="'.$lang.'_LICENSE_KEY_NOTE_DESC"  />';
					break;
			}
			// setup lang
			$this->langContent[$this->lang][$lang.'_LICENSE_KEY_LABEL']	= "License Key";
			$this->langContent[$this->lang][$lang.'_LICENSE_KEY_DESC']	= "Add your license key here.";
			// add the field
			$this->configFieldSets[] = "\t\t".'<field name="license_key"';
			$this->configFieldSets[] = "\t\t\t".'type="text"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_LICENSE_KEY_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_LICENSE_KEY_DESC"';
			$this->configFieldSets[] = "\t\t\t".'size="60"';
			$this->configFieldSets[] = "\t\t\t".'default=""';
			$this->configFieldSets[] = "\t\t/>";
			$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerLicense" hr="true" />';
		}
		// setup lang
		$this->langContent[$this->lang][$lang.'_GLOBAL_LABEL']	= "Global";
		$this->langContent[$this->lang][$lang.'_GLOBAL_DESC']	= "The Global Parameters";
		// add auto checin if required
		if ($this->addCheckin)
		{
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\t".'name="check_in"';
			$this->configFieldSets[] = "\t\t\t".'type="list"';
			$this->configFieldSets[] = "\t\t\t".'default="0"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_CHECK_TIMER_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_CHECK_TIMER_DESC">';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-5 hours">'.$lang.'_CHECK_TIMER_OPTION_ONE</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-12 hours">'.$lang.'_CHECK_TIMER_OPTION_TWO</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-1 day">'.$lang.'_CHECK_TIMER_OPTION_THREE</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-2 day">'.$lang.'_CHECK_TIMER_OPTION_FOUR</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="-1 week">'.$lang.'_CHECK_TIMER_OPTION_FIVE</option>';
			$this->configFieldSets[] = "\t\t\t".'<option';
			$this->configFieldSets[] = "\t\t\t\t".'value="0">'.$lang.'_CHECK_TIMER_OPTION_SIX</option>';
			$this->configFieldSets[] = "\t\t</field>";
			$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerAuthor" hr="true" />';
			// setup lang
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_LABEL']		= "Check in timer";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_DESC']		= "Set the intervals for the auto checkin fuction of tables that checks out the items to an user.";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_ONE']	= "Every five hours";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_TWO']	= "Every twelve hours";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_THREE']	= "Once a day";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_FOUR']	= "Every second day";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_FIVE']	= "Once a week";
			$this->langContent[$this->lang][$lang.'_CHECK_TIMER_OPTION_SIX']	= "Never";
			// load the Global checkin defautls
			$this->extensionsParams[] = '"check_in":"-1 day"';
		}
		// set history control
		if ($this->setTagHistory)
		{
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\t".'name="save_history"';
			$this->configFieldSets[] = "\t\t\t".'type="radio"';
			$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = "\t\t\t".'default="1"';
			$this->configFieldSets[] = "\t\t\t".'label="JGLOBAL_SAVE_HISTORY_OPTIONS_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="JGLOBAL_SAVE_HISTORY_OPTIONS_DESC"';
			$this->configFieldSets[] = "\t\t\t>";
			$this->configFieldSets[] = "\t\t\t".'<option value="1">JYES</option>';
			$this->configFieldSets[] = "\t\t\t".'<option value="0">JNO</option>';
			$this->configFieldSets[] = "\t\t</field>";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\t".'name="history_limit"';
			$this->configFieldSets[] = "\t\t\t".'type="text"';
			$this->configFieldSets[] = "\t\t\t".'filter="integer"';
			$this->configFieldSets[] = "\t\t\t".'label="JGLOBAL_HISTORY_LIMIT_OPTIONS_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="JGLOBAL_HISTORY_LIMIT_OPTIONS_DESC"';
			$this->configFieldSets[] = "\t\t\t".'default="10"';
			$this->configFieldSets[] = "\t\t/>";
			$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerHistory" hr="true" />';
			// load the Global checkin defautls
			$this->extensionsParams[] = '"save_history":"1","history_limit":"10"';
		}
		// add custom global fields
		if (isset($this->configFieldSetsCustomField['Global']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Global']))
		{
			$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Global']);
			unset($this->configFieldSetsCustomField['Global']);
		}
		// set the author details
		$this->configFieldSets[] = "\t\t".'<field name="autorTitle"';
		$this->configFieldSets[] = "\t\t\t".'type="spacer"';
		$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_AUTHOR"';
		$this->configFieldSets[] = "\t\t/>";
		$this->configFieldSets[] = "\t\t".'<field name="autorName"';
		$this->configFieldSets[] = "\t\t\t".'type="text"';
		$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_AUTHOR_NAME_LABEL"';
		$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_AUTHOR_NAME_DESC"';
		$this->configFieldSets[] = "\t\t\t".'size="60"';
		$this->configFieldSets[] = "\t\t\t".'default="'.$autorName.'"';
		$this->configFieldSets[] = "\t\t\t".'readonly="true"';
		$this->configFieldSets[] = "\t\t\t".'class="readonly"';
		$this->configFieldSets[] = "\t\t/>";
		$this->configFieldSets[] = "\t\t".'<field name="autorEmail"';
		$this->configFieldSets[] = "\t\t\t".'type="email"';
		$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_AUTHOR_EMAIL_LABEL"';
		$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_AUTHOR_EMAIL_DESC"';
		$this->configFieldSets[] = "\t\t\t".'size="60"';
		$this->configFieldSets[] = "\t\t\t".'default="'.$autorEmail.'"';
		$this->configFieldSets[] = "\t\t\t".'readonly="true"';
		$this->configFieldSets[] = "\t\t\t".'class="readonly"';
		$this->configFieldSets[] = "\t\t/>";
		// setup lang
		$this->langContent[$this->lang][$lang.'_AUTHOR']		= "Author Info";
		$this->langContent[$this->lang][$lang.'_AUTHOR_NAME_LABEL']	= "Author Name";
		$this->langContent[$this->lang][$lang.'_AUTHOR_NAME_DESC']	= "The name of the author of this component.";
		$this->langContent[$this->lang][$lang.'_AUTHOR_EMAIL_LABEL']	= "Author Email";
		$this->langContent[$this->lang][$lang.'_AUTHOR_EMAIL_DESC']	= "The email address of the author of this component.";
		// set if contributors were added
		$langCont = $lang.'_CONTRIBUTOR';
		if (isset($this->addContributors) && $this->addContributors && isset($this->componentData->contributors) && ComponentbuilderHelper::checkArray($this->componentData->contributors))
		{
			foreach ($this->componentData->contributors as $counter => $contributor)
			{
				// make sure we dont use 0
				$counter++;
				// get the word for this number
				$COUNTER = ComponentbuilderHelper::safeString($counter,'U');
				// set the dynamic values
				$cbTitle	= htmlspecialchars($contributor['title'], ENT_XML1, 'UTF-8');
				$cbName		= htmlspecialchars($contributor['name'], ENT_XML1, 'UTF-8');
				$cbEmail	= htmlspecialchars($contributor['email'], ENT_XML1, 'UTF-8');
				$cbWebsite	= htmlspecialchars($contributor['website'], ENT_XML1, 'UTF-8'); // ComponentbuilderHelper::htmlEscape($contributor['website']);
				// load to the $fieldsets
				$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerContributor'.$counter.'" hr="true" />';
				$this->configFieldSets[] = "\t\t".'<field name="contributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="spacer"';
				$this->configFieldSets[] = "\t\t\t".'class="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_'.$COUNTER.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="titleContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_TITLE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_TITLE_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbTitle.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="nameContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_NAME_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_NAME_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbName.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="emailContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="email"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_EMAIL_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_EMAIL_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbEmail.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="linkContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="url"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_LINK_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_LINK_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default="'.$cbWebsite.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="useContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="'.(int) $contributor['use'].'"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_USE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_USE_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_USE_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_USE_EMAIL</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_USE_WWW</option>';
				$this->configFieldSets[] = "\t\t</field>";
				$this->configFieldSets[] = "\t\t".'<field name="showContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="'.(int) $contributor['show'].'"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_SHOW_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_SHOW_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_SHOW_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_SHOW_BACK</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_SHOW_FRONT</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="3">'.$langCont.'_SHOW_ALL</option>';
				$this->configFieldSets[] = "\t\t</field>";
				// add the contributor
				$this->theContributors .= PHP_EOL."\t@".strtolower($contributor['title'])."\t\t".$contributor['name'].' <'.$contributor['website'].'>';
				// setup lang
				$Counter = ComponentbuilderHelper::safeString($counter,'Ww');
				$this->langContent[$this->lang][$langCont.'_'.$COUNTER]	= "Contributor ".$Counter;
				// load the Global checkin defautls
				$this->extensionsParams[] = '"titleContributor'.$counter.'":"'.$cbTitle.'"';
				$this->extensionsParams[] = '"nameContributor'.$counter.'":"'.$cbName.'"';
				$this->extensionsParams[] = '"emailContributor'.$counter.'":"'.$cbEmail.'"';
				$this->extensionsParams[] = '"linkContributor'.$counter.'":"'.$cbWebsite.'"';
				$this->extensionsParams[] = '"useContributor'.$counter.'":"'.(int) $contributor['use'].'"';
				$this->extensionsParams[] = '"showContributor'.$counter.'":"'.(int) $contributor['show'].'"';
			}
		}
		// add more contributors if required
		if (1 == $this->componentData->emptycontributors)
		{
			if (isset($counter)){
				$min = $counter + 1;
				unset($counter);
			}
			else
			{
				$min = 1;
			}
			$max = $min + $this->componentData->number - 1;
			$moreContributerFields = range($min,$max, 1);
			foreach ($moreContributerFields as $counter)
			{
				$COUNTER = ComponentbuilderHelper::safeString($counter,'U');

				$this->configFieldSets[] = "\t\t".'<field type="spacer" name="spacerContributor'.$counter.'" hr="true" />';
				$this->configFieldSets[] = "\t\t".'<field name="contributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="spacer"';
				$this->configFieldSets[] = "\t\t\t".'class="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_'.$COUNTER.'"';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="titleContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_TITLE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_TITLE_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="nameContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_NAME_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_NAME_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="emailContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="email"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_EMAIL_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_EMAIL_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="linkContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="url"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_LINK_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_LINK_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
				$this->configFieldSets[] = "\t\t".'<field name="useContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="0"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_USE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_USE_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_USE_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_USE_EMAIL</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_USE_WWW</option>';
				$this->configFieldSets[] = "\t\t</field>";
				$this->configFieldSets[] = "\t\t".'<field name="showContributor'.$counter.'"';
				$this->configFieldSets[] = "\t\t\t".'type="list"';
				$this->configFieldSets[] = "\t\t\t".'default="0"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$langCont.'_SHOW_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$langCont.'_SHOW_DESC">';
				$this->configFieldSets[] = "\t\t\t".'<option value="0">'.$langCont.'_SHOW_NONE</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="1">'.$langCont.'_SHOW_BACK</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">'.$langCont.'_SHOW_FRONT</option>';
				$this->configFieldSets[] = "\t\t\t".'<option value="3">'.$langCont.'_SHOW_ALL</option>';
				$this->configFieldSets[] = "\t\t</field>";
				// setup lang
				$Counter = ComponentbuilderHelper::safeString($counter,'Ww');
				$this->langContent[$this->lang][$langCont.'_'.$COUNTER]	= "Contributor ".$Counter;
			}
		}
		if ($this->addContributors || $this->componentData->emptycontributors == 1)
		{
			// setup lang
			$this->langContent[$this->lang][$langCont.'_TITLE_LABEL']	= "Contributor Job Title";
			$this->langContent[$this->lang][$langCont.'_TITLE_DESC']	= "The job title that best describes the contributor's relationship to this component.";
			$this->langContent[$this->lang][$langCont.'_NAME_LABEL']	= "Contributor Name";
			$this->langContent[$this->lang][$langCont.'_NAME_DESC']		= "The name of this contributor.";
			$this->langContent[$this->lang][$langCont.'_EMAIL_LABEL']	= "Contributor Email";
			$this->langContent[$this->lang][$langCont.'_EMAIL_DESC']	= "The email of this contributor.";
			$this->langContent[$this->lang][$langCont.'_LINK_LABEL']	= "Contributor Website";
			$this->langContent[$this->lang][$langCont.'_LINK_DESC']		= "The link to this contributor's website.";
			$this->langContent[$this->lang][$langCont.'_USE_LABEL']		= "Use";
			$this->langContent[$this->lang][$langCont.'_USE_DESC']		= "How should we link to this contributor.";
			$this->langContent[$this->lang][$langCont.'_USE_NONE']		= "None";
			$this->langContent[$this->lang][$langCont.'_USE_EMAIL']		= "Email";
			$this->langContent[$this->lang][$langCont.'_USE_WWW']		= "Website";
			$this->langContent[$this->lang][$langCont.'_SHOW_LABEL']	= "Show";
			$this->langContent[$this->lang][$langCont.'_SHOW_DESC']		= "Select where you want this contributor's details to show in the component.";
			$this->langContent[$this->lang][$langCont.'_SHOW_NONE']		= "Hide";
			$this->langContent[$this->lang][$langCont.'_SHOW_BACK']		= "Back-end";
			$this->langContent[$this->lang][$langCont.'_SHOW_FRONT']	= "Front-end";
			$this->langContent[$this->lang][$langCont.'_SHOW_ALL']		= "Both Front & Back-end";
		}
		// close that fieldset
		$this->configFieldSets[] = "\t</fieldset>";
	}
	
	public function setUikitConfigFieldsets($lang)
	{
		if ($this->uikit > 0)
		{
			// main lang prefix
			$lang = $lang.'';
			// start building field set for uikit functions
			$this->configFieldSets[] = "\t<fieldset";
			$this->configFieldSets[] = "\t\t".'name="uikit_config"';
			$this->configFieldSets[] = "\t\t".'label="'.$lang.'_UIKIT_LABEL"';
			$this->configFieldSets[] = "\t\t".'description="'.$lang.'_UIKIT_DESC">';
			// set tab lang
			if (1 == $this->uikit)
			{
				$this->langContent[$this->lang][$lang.'_UIKIT_LABEL']	= "Uikit2 Settings";
				$this->langContent[$this->lang][$lang.'_UIKIT_DESC']	= "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href=\"https://getuikit.com/v2/\" target=\"_blank\">https://getuikit.com/v2/</a>";
			}
			elseif (2  == $this->uikit)
			{
				$this->langContent[$this->lang][$lang.'_UIKIT_LABEL']	= "Uikit2 and Uikit3 Settings";
				$this->langContent[$this->lang][$lang.'_UIKIT_DESC']	= "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href=\"https://getuikit.com/v2/\" target=\"_blank\">version 2</a> or <a href=\"https://getuikit.com/\" target=\"_blank\">version 3</a>";
			}
			elseif (3  == $this->uikit)
			{
				$this->langContent[$this->lang][$lang.'_UIKIT_LABEL']	= "Uikit3 Settings";
				$this->langContent[$this->lang][$lang.'_UIKIT_DESC']	= "<b>The Parameters for the uikit are set here.</b><br />Uikit is a lightweight and modular front-end framework
for developing fast and powerful web interfaces. For more info visit <a href=\"https://getuikit.com/\" target=\"_blank\">https://getuikit.com/</a>";
			}
			
			// add version selection
			if (2 == $this->uikit)
			{
				// set field lang
				$this->langContent[$this->lang][$lang.'_UIKIT_VERSION_LABEL']	= "Uikit Versions";
				$this->langContent[$this->lang][$lang.'_UIKIT_VERSION_DESC']	= "Select what version you would like to use";
				$this->langContent[$this->lang][$lang.'_UIKIT_V2']		= "Version 2";
				$this->langContent[$this->lang][$lang.'_UIKIT_V3']		= "Version 3";
				// set the field
				$this->configFieldSets[] = "\t\t".'<field name="uikit_version"';
				$this->configFieldSets[] = "\t\t\t".'type="radio"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_UIKIT_VERSION_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_UIKIT_VERSION_DESC"';
				$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
				$this->configFieldSets[] = "\t\t\t".'default="2">';
				$this->configFieldSets[] = "\t\t\t".'<!--'.$this->setLine(__LINE__).' Option Set. -->';
				$this->configFieldSets[] = "\t\t\t".'<option value="2">';
				$this->configFieldSets[] = "\t\t\t\t".$lang.'_UIKIT_V2</option>"';
				$this->configFieldSets[] = "\t\t\t".'<option value="3">';
				$this->configFieldSets[] = "\t\t\t\t".$lang.'_UIKIT_V3</option>"';
				$this->configFieldSets[] = "\t\t</field>";
				// set params defaults
				$this->extensionsParams[] = '"uikit_version":"2"';
			}
			
			// set field lang
			$this->langContent[$this->lang][$lang.'_UIKIT_LOAD_LABEL']	= "Loading Options";
			$this->langContent[$this->lang][$lang.'_UIKIT_LOAD_DESC']	= "Set the uikit loading option.";
			$this->langContent[$this->lang][$lang.'_AUTO_LOAD']		= "Auto";
			$this->langContent[$this->lang][$lang.'_FORCE_LOAD']		= "Force";
			$this->langContent[$this->lang][$lang.'_DONT_LOAD']		= "Not";
			$this->langContent[$this->lang][$lang.'_ONLY_EXTRA']		= "Only Extra";
			// set the field
			$this->configFieldSets[] = "\t\t".'<field name="uikit_load"';
			$this->configFieldSets[] = "\t\t\t".'type="radio"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_UIKIT_LOAD_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_UIKIT_LOAD_DESC"';
			$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = "\t\t\t".'default="">';
			$this->configFieldSets[] = "\t\t\t".'<!--'.$this->setLine(__LINE__).' Option Set. -->';
			$this->configFieldSets[] = "\t\t\t".'<option value="">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_AUTO_LOAD</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value="1">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_FORCE_LOAD</option>"';
			if (2  == $this->uikit || 1 == $this->uikit)
			{
				$this->configFieldSets[] = "\t\t\t".'<option value="3">';
				$this->configFieldSets[] = "\t\t\t\t".$lang.'_ONLY_EXTRA</option>"';
			}
			$this->configFieldSets[] = "\t\t\t".'<option value="2">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_DONT_LOAD</option>"';
			$this->configFieldSets[] = "\t\t</field>";
			// set params defaults
			$this->extensionsParams[] = '"uikit_load":"1"';
			
			// set field lang
			$this->langContent[$this->lang][$lang.'_UIKIT_MIN_LABEL']	= "Load Minified";
			$this->langContent[$this->lang][$lang.'_UIKIT_MIN_DESC']	= "Should the minified version of uikit files be loaded?";
			$this->langContent[$this->lang][$lang.'_YES']			= "Yes";
			$this->langContent[$this->lang][$lang.'_NO']			= "No";
			// set the field
			$this->configFieldSets[] = "\t\t".'<field name="uikit_min"';
			$this->configFieldSets[] = "\t\t\t".'type="radio"';
			$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_UIKIT_MIN_LABEL"';
			$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_UIKIT_MIN_DESC"';
			$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
			$this->configFieldSets[] = "\t\t\t".'default="">';
			$this->configFieldSets[] = "\t\t\t".'<!--'.$this->setLine(__LINE__).' Option Set. -->';
			$this->configFieldSets[] = "\t\t\t".'<option value="">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_NO</option>"';
			$this->configFieldSets[] = "\t\t\t".'<option value=".min">';
			$this->configFieldSets[] = "\t\t\t\t".$lang.'_YES</option>"';
			$this->configFieldSets[] = "\t\t</field>";
			// set params defaults
			$this->extensionsParams[] = '"uikit_min":""';
			
			if (2  == $this->uikit || 1 == $this->uikit)
			{
				// set field lang
				$this->langContent[$this->lang][$lang.'_UIKIT_STYLE_LABEL']	= "css Style";
				$this->langContent[$this->lang][$lang.'_UIKIT_STYLE_DESC']	= "Set the css style that should be used.";
				$this->langContent[$this->lang][$lang.'_FLAT_LOAD']		= "Flat";
				$this->langContent[$this->lang][$lang.'_ALMOST_FLAT_LOAD']	= "Almost Flat";
				$this->langContent[$this->lang][$lang.'_GRADIANT_LOAD']		= "Gradient";
				// set the field
				$this->configFieldSets[] = "\t\t".'<field name="uikit_style"';
				$this->configFieldSets[] = "\t\t\t".'type="radio"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_UIKIT_STYLE_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_UIKIT_STYLE_DESC"';
				$this->configFieldSets[] = "\t\t\t".'class="btn-group btn-group-yesno"';
				if (2  == $this->uikit)
				{
					$this->configFieldSets[] = "\t\t\t".'showon="uikit_version:2"';
				}
				$this->configFieldSets[] = "\t\t\t".'default="">';
				$this->configFieldSets[] = "\t\t\t".'<!--'.$this->setLine(__LINE__).' Option Set. -->';
				$this->configFieldSets[] = "\t\t\t".'<option value="">';
				$this->configFieldSets[] = "\t\t\t\t".$lang.'_FLAT_LOAD</option>"';
				$this->configFieldSets[] = "\t\t\t".'<option value=".almost-flat">';
				$this->configFieldSets[] = "\t\t\t\t".$lang.'_ALMOST_FLAT_LOAD</option>"';
				$this->configFieldSets[] = "\t\t\t".'<option value=".gradient">';
				$this->configFieldSets[] = "\t\t\t\t".$lang.'_GRADIANT_LOAD</option>"';
				$this->configFieldSets[] = "\t\t</field>";
				// set params defaults
				$this->extensionsParams[] = '"uikit_style":""';
			}
			// add custom Uikit Settings fields
			if (isset($this->configFieldSetsCustomField['Uikit Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Uikit Settings']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Uikit Settings']);
				unset($this->configFieldSetsCustomField['Uikit Settings']);
			}
			// close that fieldset
			$this->configFieldSets[] = "\t</fieldset>";
		}

	}
	
	public function setEmailHelperConfigFieldsets($lang)
	{
		if (isset($this->componentData->add_email_helper) && $this->componentData->add_email_helper)
		{
			// main lang prefix
			$lang = $lang.'';
			// set main lang string
			$this->langContent[$this->lang][$lang.'_MAIL_CONFIGURATION'] = "Mail Configuration";
			$this->langContent[$this->lang][$lang.'_DKIM'] = "DKIM";
			// start building field set for email helper functions
			$this->configFieldSets[] = PHP_EOL."\t<fieldset";
			$this->configFieldSets[] = "\t\tname=\"mail_configuration_custom_config\"";
			$this->configFieldSets[] = "\t\tlabel=\"".$lang."_MAIL_CONFIGURATION\">";
			// add custom Mail Configurations
			if (isset($this->configFieldSetsCustomField['Mail Configuration']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Mail Configuration']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Mail Configuration']);
				unset($this->configFieldSetsCustomField['Mail Configuration']);
			}
			else
			{
				// set all the laguage strings
				$this->langContent[$this->lang][$lang.'_MAILONLINE_LABEL'] = "Mailer Status";
				$this->langContent[$this->lang][$lang.'_MAILONLINE_DESCRIPTION'] = "Warning this will stop all emails from going out.";
				$this->langContent[$this->lang][$lang.'_ON'] = "On";
				$this->langContent[$this->lang][$lang.'_OFF'] = "Off";
				$this->langContent[$this->lang][$lang.'_MAILER_LABEL'] = "Mailer";
				$this->langContent[$this->lang][$lang.'_MAILER_DESCRIPTION'] = "Select what mailer you would like to use to send emails.";
				$this->langContent[$this->lang][$lang.'_GLOBAL'] = "Global";
				$this->langContent[$this->lang][$lang.'_PHP_MAIL'] = "PHP Mail";
				$this->langContent[$this->lang][$lang.'_SENDMAIL'] = "Sendmail";
				$this->langContent[$this->lang][$lang.'_SMTP'] = "SMTP";
				$this->langContent[$this->lang][$lang.'_EMAILFROM_LABEL'] = " From Email";
				$this->langContent[$this->lang][$lang.'_EMAILFROM_DESCRIPTION'] = "The global email address that will be used to send system email.";
				$this->langContent[$this->lang][$lang.'_EMAILFROM_HINT'] = "Email Address Here";
				$this->langContent[$this->lang][$lang.'_FROMNAME_LABEL'] = "From Name";
				$this->langContent[$this->lang][$lang.'_FROMNAME_DESCRIPTION'] = "Text displayed in the header &quot;From:&quot; field when sending a site email. Usually the site name.";
				$this->langContent[$this->lang][$lang.'_FROMNAME_HINT'] = "From Name Here";
				$this->langContent[$this->lang][$lang.'_EMAILREPLY_LABEL'] = " Reply to Email";
				$this->langContent[$this->lang][$lang.'_EMAILREPLY_DESCRIPTION'] = "The global email address that will be used to set as the reply email. (leave blank for none)";
				$this->langContent[$this->lang][$lang.'_EMAILREPLY_HINT'] = "Email Address Here";
				$this->langContent[$this->lang][$lang.'_REPLYNAME_LABEL'] = "Reply to Name";
				$this->langContent[$this->lang][$lang.'_REPLYNAME_DESCRIPTION'] = "Text displayed in the header &quot;Reply To:&quot; field when replying to the site email. Usually the the person that receives the response. (leave blank for none)";
				$this->langContent[$this->lang][$lang.'_REPLYNAME_HINT'] = "Reply Name Here";
				$this->langContent[$this->lang][$lang.'_SENDMAIL_LABEL'] = "Sendmail Path";
				$this->langContent[$this->lang][$lang.'_SENDMAIL_DESCRIPTION'] = "Enter the path to the sendmail program directory on your host server.";
				$this->langContent[$this->lang][$lang.'_SENDMAIL_HINT'] = "/usr/sbin/sendmail";
				$this->langContent[$this->lang][$lang.'_SMTPAUTH_LABEL'] = "SMTP Authentication";
				$this->langContent[$this->lang][$lang.'_SMTPAUTH_DESCRIPTION'] = "Select yes if your SMTP host requires SMTP Authentication.";
				$this->langContent[$this->lang][$lang.'_YES'] = "Yes";
				$this->langContent[$this->lang][$lang.'_NO'] = "No";
				$this->langContent[$this->lang][$lang.'_SMTPSECURE_LABEL'] = "SMTP Security";
				$this->langContent[$this->lang][$lang.'_SMTPSECURE_DESCRIPTION'] = "Select the security model that your SMTP server uses.";
				$this->langContent[$this->lang][$lang.'_NONE'] = "None";
				$this->langContent[$this->lang][$lang.'_SSL'] = "SSL";
				$this->langContent[$this->lang][$lang.'_TLS'] = "TLS";
				$this->langContent[$this->lang][$lang.'_SMTPPORT_LABEL'] = "SMTP Port";
				$this->langContent[$this->lang][$lang.'_SMTPPORT_DESCRIPTION'] = "Enter the port number of your SMTP server. Use 25 for most unsecured servers and 465 for most secure servers.";
				$this->langContent[$this->lang][$lang.'_SMTPPORT_HINT'] = "25";
				$this->langContent[$this->lang][$lang.'_SMTPUSER_LABEL'] = "SMTP Username";
				$this->langContent[$this->lang][$lang.'_SMTPUSER_DESCRIPTION'] = "Enter the username for access to the SMTP host.";
				$this->langContent[$this->lang][$lang.'_SMTPUSER_HINT'] = "email@demo.com";
				$this->langContent[$this->lang][$lang.'_SMTPPASS_LABEL'] = "SMTP Password";
				$this->langContent[$this->lang][$lang.'_SMTPPASS_DESCRIPTION'] = "Enter the password for access to the SMTP host.";
				$this->langContent[$this->lang][$lang.'_SMTPHOST_LABEL'] = "SMTP Host";
				$this->langContent[$this->lang][$lang.'_SMTPHOST_DESCRIPTION'] = "Enter the name of the SMTP host.";
				$this->langContent[$this->lang][$lang.'_SMTPHOST_HINT'] = "localhost";

				// set the mailer fields
				$this->configFieldSets[] = PHP_EOL."\t\t<!--".$this->setLine(__LINE__)." Mailonline Field. Type: Radio. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"radio\"";
				$this->configFieldSets[] = "\t\t\tname=\"mailonline\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_MAILONLINE_LABEL\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_MAILONLINE_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"btn-group btn-group-yesno\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"1\">";
				$this->configFieldSets[] = "\t\t\t<!--".$this->setLine(__LINE__)." Option Set. -->";
				$this->configFieldSets[] = "\t\t\t<option value=\"1\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_ON</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"0\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_OFF</option>";
				$this->configFieldSets[] = "\t\t</field>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Mailer Field. Type: List. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"list\"";
				$this->configFieldSets[] = "\t\t\tname=\"mailer\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_MAILER_LABEL\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_MAILER_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"list_class\"";
				$this->configFieldSets[] = "\t\t\tmultiple=\"false\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"WORD\"";
				$this->configFieldSets[] = "\t\t\trequired=\"true\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"global\">";
				$this->configFieldSets[] = "\t\t\t<!--".$this->setLine(__LINE__)." Option Set. -->";
				$this->configFieldSets[] = "\t\t\t<option value=\"global\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_GLOBAL</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"default\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_PHP_MAIL</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"sendmail\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_SENDMAIL</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"smtp\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_SMTP</option>";
				$this->configFieldSets[] = "\t\t</field>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Emailfrom Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"emailfrom\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_EMAILFROM_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_EMAILFROM_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tvalidate=\"email\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add email address here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_EMAILFROM_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Fromname Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"fromname\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_FROMNAME_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_FROMNAME_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add some name here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_FROMNAME_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Email reply to Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"replyto\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_EMAILREPLY_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_EMAILREPLY_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tvalidate=\"email\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add email address here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_EMAILREPLY_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Reply to name Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"replytoname\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_REPLYNAME_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_REPLYNAME_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add some name here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_REPLYNAME_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp,sendmail,default\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Sendmail Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"sendmail\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_SENDMAIL_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_SENDMAIL_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\trequired=\"false\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"PATH\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add path to you local sendmail here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_SENDMAIL_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:sendmail\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Smtpauth Field. Type: Radio. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"radio\"";
				$this->configFieldSets[] = "\t\t\tname=\"smtpauth\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_SMTPAUTH_LABEL\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_SMTPAUTH_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"btn-group btn-group-yesno\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"0\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp\">";
				$this->configFieldSets[] = "\t\t\t<!--".$this->setLine(__LINE__)." Option Set. -->";
				$this->configFieldSets[] = "\t\t\t<option value=\"1\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_YES</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"0\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_NO</option>";
				$this->configFieldSets[] = "\t\t</field>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Smtpsecure Field. Type: List. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"list\"";
				$this->configFieldSets[] = "\t\t\tname=\"smtpsecure\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_SMTPSECURE_LABEL\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_SMTPSECURE_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"list_class\"";
				$this->configFieldSets[] = "\t\t\tmultiple=\"false\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"WORD\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"none\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp\">";
				$this->configFieldSets[] = "\t\t\t<!--".$this->setLine(__LINE__)." Option Set. -->";
				$this->configFieldSets[] = "\t\t\t<option value=\"none\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_NONE</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"ssl\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_SSL</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"tls\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_TLS</option>";
				$this->configFieldSets[] = "\t\t</field>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Smtpport Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"smtpport\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_SMTPPORT_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"25\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_SMTPPORT_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add the port number of your SMTP server here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_SMTPPORT_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Smtpuser Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"smtpuser\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_SMTPUSER_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_SMTPUSER_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add the username for SMTP server here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_SMTPUSER_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Smtppass Field. Type: Password. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"password\"";
				$this->configFieldSets[] = "\t\t\tname=\"smtppass\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_SMTPPASS_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_SMTPPASS_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"raw\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add the password for SMTP server here.\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Smtphost Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"smtphost\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_SMTPHOST_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"localhost\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_SMTPHOST_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add the name of the SMTP host here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_SMTPHOST_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"mailer:smtp\"";
				$this->configFieldSets[] = "\t\t/>";
			}
			// close that fieldset
			$this->configFieldSets[] = "\t</fieldset>";
				
			// start dkim field set
			$this->configFieldSets[] = "\t<fieldset";
			$this->configFieldSets[] = "\t\tname=\"dkim_custom_config\"";
			$this->configFieldSets[] = "\t\tlabel=\"".$lang."_DKIM\">";
			// add custom DKIM fields
			if (isset($this->configFieldSetsCustomField['DKIM']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['DKIM']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['DKIM']);
				unset($this->configFieldSetsCustomField['DKIM']);
			}
			else
			{
				$this->langContent[$this->lang][$lang.'_DKIM_LABEL'] = "Enable DKIM";
				$this->langContent[$this->lang][$lang.'_DKIM_DESCRIPTION'] = "Set this option to Yes if you want to sign your emails using DKIM.";
				$this->langContent[$this->lang][$lang.'_YES'] = "Yes";
				$this->langContent[$this->lang][$lang.'_NO'] = "No";
				$this->langContent[$this->lang][$lang.'_DKIM_DOMAIN_LABEL'] = "Domain";
				$this->langContent[$this->lang][$lang.'_DKIM_DOMAIN_DESCRIPTION'] = "Set the domain. Eg. domain.com";
				$this->langContent[$this->lang][$lang.'_DKIM_DOMAIN_HINT'] = "domain.com";
				$this->langContent[$this->lang][$lang.'_DKIM_SELECTOR_LABEL'] = "Selector";
				$this->langContent[$this->lang][$lang.'_DKIM_SELECTOR_DESCRIPTION'] = "Set your DKIM/DNS selector.";
				$this->langContent[$this->lang][$lang.'_DKIM_SELECTOR_HINT'] = "vdm";
				$this->langContent[$this->lang][$lang.'_DKIM_PASSPHRASE_LABEL'] = "Passphrase";
				$this->langContent[$this->lang][$lang.'_DKIM_PASSPHRASE_DESCRIPTION'] = "Enter your passphrase here.";
				$this->langContent[$this->lang][$lang.'_DKIM_IDENTITY_LABEL'] = "Identity";
				$this->langContent[$this->lang][$lang.'_DKIM_IDENTITY_DESCRIPTION'] = "Set DKIM identity. This can be in the format of an email address 'you@yourdomain.com' typically used as the source of the email.";
				$this->langContent[$this->lang][$lang.'_DKIM_IDENTITY_HINT'] = "you@yourdomain.com";
				$this->langContent[$this->lang][$lang.'_DKIM_PRIVATE_KEY_LABEL'] = "Private key";
				$this->langContent[$this->lang][$lang.'_DKIM_PRIVATE_KEY_DESCRIPTION'] = "set private key";
				$this->langContent[$this->lang][$lang.'_DKIM_PUBLIC_KEY_LABEL'] = "Public key";
				$this->langContent[$this->lang][$lang.'_DKIM_PUBLIC_KEY_DESCRIPTION'] = "set public key";
				$this->langContent[$this->lang][$lang.'_NOTE_DKIM_USE_LABEL'] = "Server Configuration";
				$this->langContent[$this->lang][$lang.'_NOTE_DKIM_USE_DESCRIPTION'] = "<p>Using the below details, you need to configure your DNS by adding a TXT record on your domain: <b><span id='a_dkim_domain'></span></b></p>
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
</script>";
				$this->langContent[$this->lang][$lang.'_DKIM_KEY_LABEL'] = "Key";
				$this->langContent[$this->lang][$lang.'_DKIM_KEY_DESCRIPTION'] = "This is the KEY to use in the DNS record.";
				$this->langContent[$this->lang][$lang.'_DKIM_KEY_HINT'] = "vdm._domainkey";
				$this->langContent[$this->lang][$lang.'_DKIM_VALUE_LABEL'] = "Value";
				$this->langContent[$this->lang][$lang.'_DKIM_VALUE_DESCRIPTION'] = "This is the TXT value to use in the DNS. Replace the PUBLICKEY with your public key.";
				$this->langContent[$this->lang][$lang.'_DKIM_VALUE_HINT'] = "v=DKIM1;k=rsa;g=*;s=email;h=sha1;t=s;p=PUBLICKEY";


				$this->configFieldSets[] = PHP_EOL."\t\t<!--".$this->setLine(__LINE__)." Dkim Field. Type: Radio. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"radio\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_LABEL\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"btn-group btn-group-yesno\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"0\"";
				$this->configFieldSets[] = "\t\t\trequired=\"true\">";
				$this->configFieldSets[] = "\t\t\t<!--".$this->setLine(__LINE__)." Option Set. -->";
				$this->configFieldSets[] = "\t\t\t<option value=\"1\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_YES</option>";
				$this->configFieldSets[] = "\t\t\t<option value=\"0\">";
				$this->configFieldSets[] = "\t\t\t\t".$lang."_NO</option>";
				$this->configFieldSets[] = "\t\t</field>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_domain Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_domain\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_DOMAIN_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_DOMAIN_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add DKIM Domain here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_DKIM_DOMAIN_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t\tonchange=\"vdm_dkim();\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_selector Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_selector\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_SELECTOR_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdefault=\"vdm\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_SELECTOR_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add DKIM/DNS selector here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_DKIM_SELECTOR_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t\tonchange=\"vdm_dkim();\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_passphrase Field. Type: Password. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"password\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_passphrase\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_PASSPHRASE_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_PASSPHRASE_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"raw\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add  passphrase here.\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_identity Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_identity\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_IDENTITY_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"60\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_IDENTITY_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"raw\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add  DKIM Identity here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_DKIM_IDENTITY_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_private_key Field. Type: Textarea. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"textarea\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_private_key\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_PRIVATE_KEY_LABEL\"";
				$this->configFieldSets[] = "\t\t\trows=\"15\"";
				$this->configFieldSets[] = "\t\t\tcols=\"5\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_PRIVATE_KEY_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"input-xxlarge span12\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_public_key Field. Type: Textarea. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"textarea\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_public_key\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_PUBLIC_KEY_LABEL\"";
				$this->configFieldSets[] = "\t\t\trows=\"5\"";
				$this->configFieldSets[] = "\t\t\tcols=\"5\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_PUBLIC_KEY_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"input-xxlarge span12\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t\tonchange=\"vdm_dkim();\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Note_dkim_use Field. Type: Note. A None Database Field. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field type=\"note\" name=\"note_dkim_use\" label=\"".$lang."_NOTE_DKIM_USE_LABEL\" description=\"".$lang."_NOTE_DKIM_USE_DESCRIPTION\" heading=\"h4\" class=\"note_dkim_use\" showon=\"dkim:1\" />\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_key Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_key\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_KEY_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"40\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"150\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_KEY_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add KEY here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_DKIM_KEY_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t/>\t\t";
				$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Dkim_value Field. Type: Text. (joomla) -->";
				$this->configFieldSets[] = "\t\t<field";
				$this->configFieldSets[] = "\t\t\ttype=\"text\"";
				$this->configFieldSets[] = "\t\t\tname=\"dkim_value\"";
				$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_DKIM_VALUE_LABEL\"";
				$this->configFieldSets[] = "\t\t\tsize=\"80\"";
				$this->configFieldSets[] = "\t\t\tmaxlength=\"350\"";
				$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_DKIM_VALUE_DESCRIPTION\"";
				$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
				$this->configFieldSets[] = "\t\t\tfilter=\"STRING\"";
				$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add TXT record here.\"";
				$this->configFieldSets[] = "\t\t\thint=\"".$lang."_DKIM_VALUE_HINT\"";
				$this->configFieldSets[] = "\t\t\tshowon=\"dkim:1\"";
				$this->configFieldSets[] = "\t\t/>";
			}
			// close that fieldset
			$this->configFieldSets[] = "\t</fieldset>";
		}

	}
	
	public function setGooglechartConfigFieldsets($lang)
	{
		if ($this->googlechart)
		{
			$this->configFieldSets[] = PHP_EOL."\t<fieldset";
			$this->configFieldSets[] = "\t\tname=\"googlechart_config\"";
			$this->configFieldSets[] = "\t\tlabel=\"".$lang."_CHART_SETTINGS_LABEL\"";
			$this->configFieldSets[] = "\t\tdescription=\"".$lang."_CHART_SETTINGS_DESC\">";
			$this->configFieldSets[] = "\t\t";
			$this->configFieldSets[] = "\t\t<field type=\"note\" name=\"chart_admin_naote\" class=\"alert alert-info\" label=\"".$lang."_ADMIN_CHART_NOTE_LABEL\" description=\"".$lang."_ADMIN_CHART_NOTE_DESC\"  />";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartbackground Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartbackground\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#F7F7FA\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTBACKGROUND_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTBACKGROUND_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_mainwidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_mainwidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_MAINWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_MAINWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add area width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_MAINWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_a Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_a\" hr=\"true\" class=\"spacer_chartadmin_hr_a\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartareatop Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartareatop\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREATOP_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREATOP_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add top spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREATOP_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartarealeft Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartarealeft\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREALEFT_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREALEFT_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add left spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREALEFT_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_chartareawidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_chartareawidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREAWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREAWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add chart width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREAWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_b Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_b\" hr=\"true\" class=\"spacer_chartadmin_hr_b\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_legendtextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_legendtextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_legendtextstylefontsize Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_legendtextstylefontsize\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add size of the legend here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_c Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_c\" hr=\"true\" class=\"spacer_chartadmin_hr_c\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_vaxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_vaxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartadmin_hr_d Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartadmin_hr_d\" hr=\"true\" class=\"spacer_chartadmin_hr_d\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_haxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_haxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Admin_haxistitletextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"admin_haxistitletextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>";
			$this->configFieldSets[] = "\t\t";
			$this->configFieldSets[] = "\t\t<field type=\"note\" name=\"chart_site_note\" class=\"alert alert-info\" label=\"".$lang."_SITE_CHART_NOTE_LABEL\" description=\"".$lang."_SITE_CHART_NOTE_DESC\"  />";
			$this->configFieldSets[] = "\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartbackground Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartbackground\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#F7F7FA\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTBACKGROUND_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTBACKGROUND_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_mainwidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_mainwidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_MAINWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_MAINWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add area width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_MAINWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_a Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_a\" hr=\"true\" class=\"spacer_chartsite_hr_a\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartareatop Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartareatop\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREATOP_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREATOP_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add top spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREATOP_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartarealeft Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartarealeft\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREALEFT_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREALEFT_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add left spacing here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREALEFT_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_chartareawidth Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_chartareawidth\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_CHARTAREAWIDTH_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_CHARTAREAWIDTH_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add chart width here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_CHARTAREAWIDTH_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_b Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_b\" hr=\"true\" class=\"spacer_chartsite_hr_b\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_legendtextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_legendtextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_legendtextstylefontsize Field. Type: Text. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"text\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_legendtextstylefontsize\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_LABEL\"";
			$this->configFieldSets[] = "\t\t\tsize=\"20\"";
			$this->configFieldSets[] = "\t\t\tmaxlength=\"50\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_DESC\"";
			$this->configFieldSets[] = "\t\t\tclass=\"text_area\"";
			$this->configFieldSets[] = "\t\t\tfilter=\"INT\"";
			$this->configFieldSets[] = "\t\t\tmessage=\"Error! Please add size of the legend here.\"";
			$this->configFieldSets[] = "\t\t\thint=\"".$lang."_LEGENDTEXTSTYLEFONTSIZE_HINT\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_c Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_c\" hr=\"true\" class=\"spacer_chartsite_hr_c\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_vaxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_vaxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_VAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Spacer_chartsite_hr_d Field. Type: Spacer. A None Database Field. -->";
			$this->configFieldSets[] = "\t\t<field type=\"spacer\" name=\"spacer_chartsite_hr_d\" hr=\"true\" class=\"spacer_chartsite_hr_d\" />\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_haxistextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_haxistextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>\t\t";
			$this->configFieldSets[] = "\t\t<!--".$this->setLine(__LINE__)." Site_haxistitletextstylefontcolor Field. Type: Color. -->";
			$this->configFieldSets[] = "\t\t<field";
			$this->configFieldSets[] = "\t\t\ttype=\"color\"";
			$this->configFieldSets[] = "\t\t\tname=\"site_haxistitletextstylefontcolor\"";
			$this->configFieldSets[] = "\t\t\tdefault=\"#63B1F2\"";
			$this->configFieldSets[] = "\t\t\tlabel=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"";
			$this->configFieldSets[] = "\t\t\tdescription=\"".$lang."_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"";
			$this->configFieldSets[] = "\t\t/>";
			
			// add custom Encryption Settings fields
			if (isset($this->configFieldSetsCustomField['Chart Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Chart Settings']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Chart Settings']);
				unset($this->configFieldSetsCustomField['Chart Settings']);
			}
			
			$this->configFieldSets[] = "\t</fieldset>";

			// set params defaults
			$this->extensionsParams[] = '"admin_chartbackground":"#F7F7FA","admin_mainwidth":"1000","admin_chartareatop":"20","admin_chartarealeft":"20","admin_chartareawidth":"170","admin_legendtextstylefontcolor":"10","admin_legendtextstylefontsize":"20","admin_vaxistextstylefontcolor":"#63B1F2","admin_haxistextstylefontcolor":"#63B1F2","admin_haxistitletextstylefontcolor":"#63B1F2","site_chartbackground":"#F7F7FA","site_mainwidth":"1000","site_chartareatop":"20","site_chartarealeft":"20","site_chartareawidth":"170","site_legendtextstylefontcolor":"10","site_legendtextstylefontsize":"20","site_vaxistextstylefontcolor":"#63B1F2","site_haxistextstylefontcolor":"#63B1F2","site_haxistitletextstylefontcolor":"#63B1F2"';

			// set field lang
			$this->langContent[$this->lang][$lang.'_CHART_SETTINGS_LABEL']			= "Chart Settings";
			$this->langContent[$this->lang][$lang.'_CHART_SETTINGS_DESC']			= "The Google Chart Display Settings Are Made Here.";
			$this->langContent[$this->lang][$lang.'_ADMIN_CHART_NOTE_LABEL']		= "Admin Settings";
			$this->langContent[$this->lang][$lang.'_ADMIN_CHART_NOTE_DESC']			= "The following settings are used on the back-end of the site called (admin).";
			$this->langContent[$this->lang][$lang.'_SITE_CHART_NOTE_LABEL']			= "Site Settings";
			$this->langContent[$this->lang][$lang.'_SITE_CHART_NOTE_DESC']			= "The following settings are used on the front-end of the site called (site).";

			$this->langContent[$this->lang][$lang.'_CHARTAREALEFT_DESC']			= "Set in pixels the spacing from the left of the chart area to the beginning of the chart it self. Please don't add the px sign";
			$this->langContent[$this->lang][$lang.'_CHARTAREALEFT_HINT']			= "170";
			$this->langContent[$this->lang][$lang.'_CHARTAREALEFT_LABEL']			= "Left Spacing";
			$this->langContent[$this->lang][$lang.'_CHARTAREATOP_DESC']			= "Set in pixels the spacing from the top of the chart area to the beginning of the chart it self. Please don't add the px sign";
			$this->langContent[$this->lang][$lang.'_CHARTAREATOP_HINT']			= "20";
			$this->langContent[$this->lang][$lang.'_CHARTAREATOP_LABEL']			= "Top Spacing";
			$this->langContent[$this->lang][$lang.'_CHARTAREAWIDTH_DESC']			= "Set in % the width of the chart it self inside the chart area. Please don't add the % sign";
			$this->langContent[$this->lang][$lang.'_CHARTAREAWIDTH_HINT']			= "60";
			$this->langContent[$this->lang][$lang.'_CHARTAREAWIDTH_LABEL']			= "Chart Width";
			$this->langContent[$this->lang][$lang.'_CHARTBACKGROUND_DESC']			= "Select the chart background color here.";
			$this->langContent[$this->lang][$lang.'_CHARTBACKGROUND_LABEL']			= "Chart Background";
			$this->langContent[$this->lang][$lang.'_HAXISTEXTSTYLEFONTCOLOR_DESC']		= "Select the horizontal axis font color.";
			$this->langContent[$this->lang][$lang.'_HAXISTEXTSTYLEFONTCOLOR_LABEL']		= "hAxis Font Color";
			$this->langContent[$this->lang][$lang.'_HAXISTITLETEXTSTYLEFONTCOLOR_DESC']     = "Select the horizontal axis title's font color.";
			$this->langContent[$this->lang][$lang.'_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL']    = "hAxis Title Font Color";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTCOLOR_DESC']		= "Select the legend font color.";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTCOLOR_LABEL']        = "Legend Font Color";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTSIZE_DESC']		= "Set in pixels the font size of the legend";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTSIZE_HINT']		= "10";
			$this->langContent[$this->lang][$lang.'_LEGENDTEXTSTYLEFONTSIZE_LABEL']		= "Legend Font Size";
			$this->langContent[$this->lang][$lang.'_MAINWIDTH_DESC']			= "Set the width of the entire chart area";
			$this->langContent[$this->lang][$lang.'_MAINWIDTH_HINT']			= "1000";
			$this->langContent[$this->lang][$lang.'_MAINWIDTH_LABEL']			= "Chart Area Width";
			$this->langContent[$this->lang][$lang.'_VAXISTEXTSTYLEFONTCOLOR_DESC']		= "Select the vertical axis font color.";
			$this->langContent[$this->lang][$lang.'_VAXISTEXTSTYLEFONTCOLOR_LABEL']		= "vAxis Font Color";
		}
	}

	/**
	 * @param $lang
     */
	public function setEncryptionConfigFieldsets($lang)
	{
		// Add encryption if needed
		if ((isset($this->basicEncryption) && $this->basicEncryption) || (isset($this->advancedEncryption) && $this->advancedEncryption))
		{
			// start building field set for encryption functions
			$this->configFieldSets[] = "\t<fieldset";
			$this->configFieldSets[] = "\t\t".'name="encryption_config"';
			$this->configFieldSets[] = "\t\t".'label="'.$lang.'_ENCRYPTION_LABEL"';
			$this->configFieldSets[] = "\t\t".'description="'.$lang.'_ENCRYPTION_DESC">';
			// set tab lang
			$this->langContent[$this->lang][$lang.'_ENCRYPTION_LABEL']	= "Encryption Settings";
			$this->langContent[$this->lang][$lang.'_ENCRYPTION_DESC']	= "The encryption key for the field encryption is set here.";

			if (isset($this->basicEncryption) && $this->basicEncryption)
			{
				// set field lang
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_LABEL']	= "Basic Key <small>(basic encryption)</small>";
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_DESC']	= "Set the basic local key here.";
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_NOTE_LABEL']	= "Basic Encryption";
				$this->langContent[$this->lang][$lang.'_BASIC_KEY_NOTE_DESC']	= "When using the basic encryption please use a 32 character passphrase.<br />Never change this passphrase once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>";
				// set the field
				$this->configFieldSets[] = "\t\t".'<field type="note" name="basic_key_note" class="alert alert-info" label="'.$lang.'_BASIC_KEY_NOTE_LABEL" description="'.$lang.'_BASIC_KEY_NOTE_DESC"  />';
				$this->configFieldSets[] = "\t\t".'<field name="basic_key"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_BASIC_KEY_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_BASIC_KEY_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
			}

			if (isset($this->advancedEncryption) && $this->advancedEncryption)
			{
				// set field lang
				$this->langContent[$this->lang][$lang.'_VDM_KEY_LABEL']		= "Advanced Key <small>(advanced encryption)</small>";
				$this->langContent[$this->lang][$lang.'_VDM_KEY_DESC']		= "Add the advanced key here.";
				$this->langContent[$this->lang][$lang.'_VDM_KEY_NOTE_LABEL']	= "Advanced Encryption";
				$this->langContent[$this->lang][$lang.'_VDM_KEY_NOTE_DESC']	= "When using the advanced encryption you need to get an advanced key from ".$this->componentData->companyname.".<br />Never change this advanced key once it is set! <b>DATA WILL GET CORRUPTED IF YOU DO!</b>";
				// set the field
				$this->configFieldSets[] = "\t\t".'<field type="note" name="vdm_key_note" class="alert alert-info" label="'.$lang.'_VDM_KEY_NOTE_LABEL" description="'.$lang.'_VDM_KEY_NOTE_DESC"  />';
				$this->configFieldSets[] = "\t\t".'<field name="advanced_key"';
				$this->configFieldSets[] = "\t\t\t".'type="text"';
				$this->configFieldSets[] = "\t\t\t".'label="'.$lang.'_VDM_KEY_LABEL"';
				$this->configFieldSets[] = "\t\t\t".'description="'.$lang.'_VDM_KEY_DESC"';
				$this->configFieldSets[] = "\t\t\t".'size="60"';
				$this->configFieldSets[] = "\t\t\t".'default=""';
				$this->configFieldSets[] = "\t\t/>";
			}
			// add custom Encryption Settings fields
			if (isset($this->configFieldSetsCustomField['Encryption Settings']) && ComponentbuilderHelper::checkArray($this->configFieldSetsCustomField['Encryption Settings']))
			{
				$this->configFieldSets[] = implode("\t\t",$this->configFieldSetsCustomField['Encryption Settings']);
				unset($this->configFieldSetsCustomField['Encryption Settings']);
			}
			// close that fieldset
			$this->configFieldSets[] = "\t</fieldset>";
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
				$component .= PHP_EOL."\t".'<section name="category.'.$otherViews.'">';
				$component .= PHP_EOL."\t\t".'<action name="core.create" title="JACTION_CREATE" description="JACTION_CREATE_COMPONENT_DESC" />';
				$component .= PHP_EOL."\t\t".'<action name="core.delete" title="JACTION_DELETE" description="COM_CATEGORIES_ACCESS_DELETE_DESC" />';
				$component .= PHP_EOL."\t\t".'<action name="core.edit" title="JACTION_EDIT" description="COM_CATEGORIES_ACCESS_EDIT_DESC" />';
				$component .= PHP_EOL."\t\t".'<action name="core.edit.state" title="JACTION_EDITSTATE" description="COM_CATEGORIES_ACCESS_EDITSTATE_DESC" />';
				$component .= PHP_EOL."\t\t".'<action name="core.edit.own" title="JACTION_EDITOWN" description="COM_CATEGORIES_ACCESS_EDITOWN_DESC" />';
				$component .= PHP_EOL."\t</section>";
			}
		}
		return $component;
	}

	public function setAccessSections()
	{
		// set the default component access values
		$this->componentHead	= array();
		$this->componentGlobal	= array();
		$this->permissionViews	= array();
		
		$this->componentHead[] = '<section name="component">';
		$this->componentHead[] = "\t\t".'<action name="core.admin" title="JACTION_ADMIN" description="JACTION_ADMIN_COMPONENT_DESC" />';
		$this->componentHead[] = "\t\t".'<action name="core.options" title="JACTION_OPTIONS" description="JACTION_OPTIONS_COMPONENT_DESC" />';
		$this->componentHead[] = "\t\t".'<action name="core.manage" title="JACTION_MANAGE" description="JACTION_MANAGE_COMPONENT_DESC" />';
		if ($this->addEximport)
		{
			$exportTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Export Data','U');
			$exportDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Export Data','U').'_DESC';
			$this->langContent['bothadmin'][$exportTitle]	= 'Export Data';
			$this->langContent['bothadmin'][$exportDesc]	= ' Allows users in this group to export data.';
			$this->componentHead[] = "\t\t".'<action name="core.export" title="'.$exportTitle.'" description="'.$exportDesc.'" />';

			$importTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Import Data','U');
			$importDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Import Data','U').'_DESC';
			$this->langContent['bothadmin'][$importTitle]	= 'Import Data';
			$this->langContent['bothadmin'][$importDesc]	= ' Allows users in this group to import data.';
			$this->componentHead[] = "\t\t".'<action name="core.import" title="'.$importTitle.'" description="'.$importDesc.'" />';
		}
		// version permission
		$batchTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Use Batch','U');
		$batchDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Use Batch','U').'_DESC';
		$this->langContent['bothadmin'][$batchTitle]	= 'Use Batch';
		$this->langContent['bothadmin'][$batchDesc]	= ' Allows users in this group to use batch copy/update method.';
		$this->componentHead[] = "\t\t".'<action name="core.batch" title="'.$batchTitle.'" description="'.$batchDesc.'" />';
		// version permission
		$importTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Versions','U');
		$importDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Versions','U').'_DESC';
		$this->langContent['bothadmin'][$importTitle]	= 'Edit Version';
		$this->langContent['bothadmin'][$importDesc]	= ' Allows users in this group to edit versions.';
		$this->componentHead[] = "\t\t".'<action name="core.version" title="'.$importTitle.'" description="'.$importDesc.'" />';
		// set the defaults
		$this->componentHead[] = "\t\t".'<action name="core.create" title="JACTION_CREATE" description="JACTION_CREATE_COMPONENT_DESC" />';
		$this->componentHead[] = "\t\t".'<action name="core.delete" title="JACTION_DELETE" description="JACTION_DELETE_COMPONENT_DESC" />';
		$this->componentHead[] = "\t\t".'<action name="core.edit" title="JACTION_EDIT" description="JACTION_EDIT_COMPONENT_DESC" />';
		$this->componentHead[] = "\t\t".'<action name="core.edit.state" title="JACTION_EDITSTATE" description="JACTION_ACCESS_EDITSTATE_DESC" />';
		$this->componentHead[] = "\t\t".'<action name="core.edit.own" title="JACTION_EDITOWN" description="JACTION_EDITOWN_COMPONENT_DESC" />';
		// new custom created by permissions
		$created_byTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created By','U');
		$created_byDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created By','U').'_DESC';
		$this->langContent['bothadmin'][$created_byTitle]	= 'Edit Created By';
		$this->langContent['bothadmin'][$created_byDesc]	= ' Allows users in this group to edit created by.';
		$this->componentHead[] = "\t\t".'<action name="core.edit.created_by" title="'.$created_byTitle.'" description="'.$created_byDesc.'" />';
		// new custom created date permissions
		$createdTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created Date','U');
		$createdDesc = $this->langPrefix.'_'.ComponentbuilderHelper::safeString('Edit Created Date','U').'_DESC';
		$this->langContent['bothadmin'][$createdTitle]	= 'Edit Created Date';
		$this->langContent['bothadmin'][$createdDesc]	= ' Allows users in this group to edit created date.';
		$this->componentHead[] = "\t\t".'<action name="core.edit.created" title="'.$createdTitle.'" description="'.$createdDesc.'" />';
		
		// set the menu controller lookup
		$menuControllers = array('access','submenu','dashboard_list','dashboard_add');
                // set the custom admin views permissions
		if (isset($this->componentData->custom_admin_views) && ComponentbuilderHelper::checkArray($this->componentData->custom_admin_views))
		{
                        foreach ($this->componentData->custom_admin_views as $custom_admin_view)
			{
                                // new custom permissions to access this view
                                $customAdminName        = $custom_admin_view['settings']->name;
                                $customAdminCode        = $custom_admin_view['settings']->code;
                                $customAdminTitle       = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($customAdminName.' Access','U');
                                $customAdminDesc        = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($customAdminName.' Access','U').'_DESC';
                                $sortKey                = ComponentbuilderHelper::safeString($customAdminName.' Access');
                                $this->langContent['bothadmin'][$customAdminTitle]	= $customAdminName.' Access';
                                $this->langContent['bothadmin'][$customAdminDesc]	= ' Allows the users in this group to access '.ComponentbuilderHelper::safeString($customAdminName,'w').'.';
                                $this->componentGlobal[$sortKey]                      = "\t\t".'<action name="'.$customAdminCode.'.access" title="'.$customAdminTitle.'" description="'.$customAdminDesc.'" />';
                                // add the custom permissions to use the buttons of this view
                                $this->addCustomButtonPermissions($custom_admin_view['settings'], $customAdminName, $customAdminCode);
				// add menu controll view that has menus options
				foreach ($menuControllers  as $menuController)
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
						$menucontrollerView['action'] = $targetView_.$menuController;
						$menucontrollerView['implementation'] = '2';
						if (isset($custom_admin_view['settings']->permissions) && ComponentbuilderHelper::checkArray($custom_admin_view['settings']->permissions))
						{
							array_push($custom_admin_view['settings']->permissions,$menucontrollerView);
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
                                $siteName       = $site_view['settings']->name;
                                $siteCode       = $site_view['settings']->code;
				$siteTitle      = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($siteName.' Access Site','U');
				$siteDesc       = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($siteName.' Access Site','U').'_DESC';
				$sortKey        = ComponentbuilderHelper::safeString($siteName.' Access Site');
				if (isset($site_view['access']) && $site_view['access'] == 1)
				{
					$this->langContent['bothadmin'][$siteTitle]	= $siteName.' (Site) Access';
					$this->langContent['bothadmin'][$siteDesc]	= ' Allows the users in this group to access site '.ComponentbuilderHelper::safeString($siteName,'w').'.';
					$this->componentGlobal[$sortKey]              = "\t\t".'<action name="site.'.$siteCode.'.access" title="'.$siteTitle.'" description="'.$siteDesc.'" />';
					
					// check if this site view requires access rule to default to public
					if (isset($site_view['public']) && $site_view['public'] == 1)
					{
						// we use one as public group (TODO we see if we run into any issues)
						$this->assetsRules[] = '"site.'.$siteCode.'.access":{"1":1}';
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
                                // add the custom permissions to use the buttons of this view
                                $this->addCustomButtonPermissions($view['settings'], $view['settings']->name_single, $nameView);
				if ($nameView != 'component')
				{

					// add menu controll view that has menus options
					foreach ($menuControllers  as $menuController)
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
							$menucontrollerView['action'] = $targetView_.$menuController;
							$menucontrollerView['implementation'] = '2';
							if (isset($view['settings']->permissions) && ComponentbuilderHelper::checkArray($view['settings']->permissions))
							{
								array_push($view['settings']->permissions,$menucontrollerView);
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
						// check the fields for their permission settings
						foreach($view['settings']->fields as $field)
						{
							// see if field require permissions to be set
							if (isset($field['permission']) && $field['permission'])
							{
								if (ComponentbuilderHelper::checkArray($field['settings']->properties))
								{
									foreach ($field['settings']->properties as $property)
									{
										if ($property['name'] === 'type')
										{
											$propertyType = $property;
										}
									}
									$fieldType = $this->getFieldType($field['settings']->type_name,$field['settings']->xml,$propertyType);
									$fieldName = $this->getFieldName($fieldType,$field['settings']->xml,$field['alias']);
									$fieldView = array();
									// set the permission for this field
									$fieldView['action'] = 'view.edit.'.$fieldName;
									$fieldView['implementation'] = '3';
									if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
									{
										array_push($view['settings']->permissions,$fieldView);
									}
									else
									{
										$view['settings']->permissions = array();
										$view['settings']->permissions[] = $fieldView;
									}
									// insure that no default field get loaded
									if (!in_array($fieldName, $this->defaultFields))
									{
										// load to global field permission set
										$this->permissionFields[$nameView][$fieldName] = $fieldType;
									}
								}
							}
						}
					}
					$this->buildPermissions($view, $nameView, $nameViews, $menuControllers);
				}
			}
			// set the views permissions now
			if (ComponentbuilderHelper::checkArray($this->permissionViews))
			{
				foreach ($this->permissionViews as $viewName => $actions)
				{
					$componentViews[] = "\t".'<section name="'.$viewName.'">';
					foreach ($actions as $action)
					{
						$componentViews[] = "\t\t".$action;
					}
					$componentViews[] = "\t</section>";
				}
			}
			/// now build the section
			$component = implode(PHP_EOL,$this->componentHead);
			// sort the array to insure easy search
			ksort($this->componentGlobal,SORT_STRING);
			// add global to the compnent section
			$component .= PHP_EOL.implode(PHP_EOL,$this->componentGlobal).PHP_EOL."\t</section>";
			// add views to the compnent section
			$component .= PHP_EOL.implode(PHP_EOL,$componentViews);
			// be sure to reset again. (memory)
			$this->componentHead	= null;
			$this->componentGlobal	= null;
			$this->permissionViews	= null;
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
			        $customButtonName  = $custom_buttons['name'];
			        $customButtonCode  = ComponentbuilderHelper::safeString($customButtonName);
			        $customButtonTitle = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($nameView.' '.$customButtonName.' Button Access','U');
			        $customButtonDesc  = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($nameView.' '.$customButtonName.' Button Access','U').'_DESC';
			        $sortButtonKey     = ComponentbuilderHelper::safeString($nameView.' '.$customButtonName.' Button Access');
			        $this->langContent['bothadmin'][$customButtonTitle]	= $nameView.' '.$customButtonName.' Button Access';
			        $this->langContent['bothadmin'][$customButtonDesc]	= ' Allows the users in this group to access the '.ComponentbuilderHelper::safeString($customButtonName,'w').' button.';
			        $this->componentGlobal[$sortButtonKey]  = "\t\t".'<action name="'.$code.'.'.$customButtonCode.'" title="'.$customButtonTitle.'" description="'.$customButtonDesc.'" />';
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
					array_push($view['settings']->permissions,$exportView);
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
					array_push($view['settings']->permissions,$importView);
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
					array_push($view['settings']->permissions,$versionView);
				}
				else
				{
					$view['settings']->permissions = array();
					$view['settings']->permissions[] = $versionView;
				}
			}
			if ($type === 'admin')
			{
				// set batch control
				$batchView['action'] = 'view.batch';
				$batchView['implementation'] = '2';
				if (ComponentbuilderHelper::checkArray($view['settings']->permissions))
				{
					array_push($view['settings']->permissions,$batchView);
				}
				else
				{
					$view['settings']->permissions = array();
					$view['settings']->permissions[] = $batchView;
				}
			}
			foreach ($view['settings']->permissions as $permission)
			{
				// set acction name
				$arr = explode('.',trim($permission['action']));
				if ($arr[0] != 'core' || $arr[0] === 'view')
				{
					array_shift($arr);
					$actionMain = implode('.',$arr);
					$action = $nameView.'.'.$actionMain;
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
				$actionNameBuilder = explode('.',trim($permission['action']));
				array_shift($actionNameBuilder);
				$nameBuilder = trim(implode('___',$actionNameBuilder));
				$customName = trim(implode(' ',$actionNameBuilder));
				if ($type === 'admin')
				{
					$W_NameList = ComponentbuilderHelper::safeString($view['settings']->name_list, 'W');
					$w_NameList = ComponentbuilderHelper::safeString($customName.' '.$view['settings']->name_list, 'w');
					$w_NameSingle = ComponentbuilderHelper::safeString($view['settings']->name_single, 'w');
				}
				elseif ($type === 'customAdmin')
				{
					$W_NameList = ComponentbuilderHelper::safeString($view['settings']->name, 'W');
					$w_NameList =  $view['settings']->name;
					$w_NameSingle = $view['settings']->name;
				}
				switch ($nameBuilder)
				{
					case 'edit':
					// set edit title
					$permission['title'] =  $W_NameList . ' Edit';
					// set edit description
					$permission['description'] = ' Allows the users in this group to edit the ' . $w_NameSingle;
					break;
					case 'edit___own':
					// set edit title
					$permission['title'] = $W_NameList . ' Edit Own';
					// set edit description
					$permission['description'] = ' Allows the users in this group to edit ' . $w_NameList . ' created by them';
					break;
					case 'edit___state':
					// set edit title
					$permission['title'] = $W_NameList . ' Edit State';
					// set edit description
					$permission['description'] = ' Allows the users in this group to update the state of the ' . $w_NameSingle;
					break;
					case 'edit___created_by':
					// set edit title
					$permission['title'] = $W_NameList . ' Edit Created By';
					// set edit description
					$permission['description'] = ' Allows the users in this group to update the created by of the ' . $w_NameList;
					break;
					case 'edit___created':
					// set edit title
					$permission['title'] = $W_NameList . ' Edit Created Date';
					// set edit description
					$permission['description'] = ' Allows the users in this group to update the created date of the ' . $w_NameList;
					break;
					case 'create':
					// set edit title
					$permission['title'] = $W_NameList . ' Create';
					// set edit description
					$permission['description'] = ' Allows the users in this group to create ' . $w_NameList;
					break;
					case 'delete':
					// set edit title
					$permission['title'] = $W_NameList . ' Delete';
					// set edit description
					$permission['description'] = ' Allows the users in this group to delete ' . $w_NameList;
					break;
					case 'access':
					// set edit title
					$permission['title'] = $W_NameList . ' Access';
					// set edit description
					$permission['description'] = ' Allows the users in this group to access ' . $w_NameList;
					break;
					case 'export':
					// set edit title
					$permission['title'] = $W_NameList . ' Export';
					// set edit description
					$permission['description'] = ' Allows the users in this group to export ' . $w_NameList;
					break;
					case 'import':
					// set edit title
					$permission['title'] = $W_NameList . ' Import';
					// set edit description
					$permission['description'] = ' Allows the users in this group to import ' . $w_NameList;
					break;
					case 'version':
					// set edit title
					$permission['title'] = $W_NameList . ' Edit Version';
					// set edit description
					$permission['description'] = ' Allows users in this group to edit versions of ' . $w_NameList;
					break;
					case 'batch':
					// set edit title
					$permission['title'] = $W_NameList . ' Batch Use';
					// set edit description
					$permission['description'] = ' Allows users in this group to use batch copy/update method of ' . $w_NameList;
					break;
					default:
					// set edit title
					$permission['title'] = $W_NameList . ' ' . ComponentbuilderHelper::safeString($customName, 'W');
					// set edit description
					$permission['description'] = ' Allows the users in this group to update the ' . ComponentbuilderHelper::safeString($customName, 'w') . ' of the ' . $w_NameSingle;
					break;
				}
				// if core is not used update all core strings
				$coreCheck = explode('.',$action);
				$coreCheck[0] = 'core';
				$coreTarget = implode('.',$coreCheck);
				$this->permissionCore[$nameView][$coreTarget] = $action;
				// set array sort name
				$sortKey = ComponentbuilderHelper::safeString($permission['title']);
				// set title
				$title = $this->langPrefix.'_'.ComponentbuilderHelper::safeString($permission['title'],'U');
				// load the actions
				if ($permission['implementation'] == 1)
				{
					// only related to view
					$this->permissionViews[$nameView][] = '<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
					// load permission to action
					$this->permissionBuilder[$action][$nameView] = $nameView;
				}
				elseif ($permission['implementation'] == 2)
				{
					// relation to whole component
					$this->componentGlobal[$sortKey] = "\t\t".'<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
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
					foreach ($menuControllers  as $menuController)
					{
						if ($coreTarget === 'core.'.$menuController)
						{
							if ($menuController === 'dashboard_add')
							{
								$this->permissionDashboard[] = "'" . $nameView . ".".$menuController."' => '" . $action . "'";
							}
							else
							{
								$this->permissionDashboard[] = "'" . $nameViews . ".".$menuController."' => '" . $action . "'";
							}
						}
					}
				}
				elseif ($permission['implementation'] == 3)
				{
					// only related to view
					$this->permissionViews[$nameView][] = '<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
					// load permission to action
					$this->permissionBuilder[$action][$nameView] = $nameView;
					// relation to whole component
					$this->componentGlobal[$sortKey] = "\t\t".'<action name="'.$action.'" title="'.$title.'" description="'.$title.'_DESC" />';
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
					foreach ($menuControllers  as $menuController)
					{
						if ($coreTarget === 'core.'.$menuController)
						{
							if ($menuController === 'dashboard_add')
							{
								$this->permissionDashboard[] = "'" . $nameView . ".".$menuController."' => '" . $action . "'";
							}
							else
							{
								$this->permissionDashboard[] = "'" . $nameViews . ".".$menuController."' => '" . $action . "'";
							}
						}
					}
				}
				// set to language file
				$this->langContent['bothadmin'][$title]		= trim($permission['title']);
				$this->langContent['bothadmin'][$title.'_DESC']	= trim($permission['description']);
			}
		}
	}

	public function getFieldName($typeName,$xml,$alias)
	{
		// if category then name must be catid (only one per view)
		if ($typeName === 'category')
		{
			return 'catid';

		}
		// if tag is set then enable all tag options for this view (only one per view)
		elseif ($typeName === 'tag')
		{
			return 'tags';
		}
		// if the field is set as alias it must be called alias
		elseif ($alias)
		{
			return 'alias';
		}
		elseif ($typeName === 'spacer')
		{
			// make sure the name is unique
			return false;
		}
		else
		{
			return ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xml,'name="','"'));
		}
	}

	public function getFieldType($typeName,$xml,$property)
	{
		// make sure its lower case
		$typeName = ComponentbuilderHelper::safeString($typeName);

		if ($typeName === 'custom' || $typeName === 'customuser')
		{
			$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xml,'type="','"'));
		}
		// use field core type only if not found
		elseif (ComponentbuilderHelper::checkString($typeName))
		{
			$xmlValue = $typeName;
		}
		// make sure none adjustable fields are set
		elseif (isset($property['example']) && ComponentbuilderHelper::checkString($property['example']) && $property['adjustable'] == 0)
		{
			$xmlValue = $property['example'];
		}
		// fall back on the xml settings
		else
		{
			$xmlValue = ComponentbuilderHelper::safeString(ComponentbuilderHelper::getBetween($xml,'type="','"'));
		}

		// check if the value is set
		if (ComponentbuilderHelper::checkString($xmlValue))
		{
			// add the value
			return $xmlValue;
		}
		else
		{
			// fall back to text
			return 'text';
		}
	}

	public function getInbetweenStrings($str, $start = '###', $end = '###')
	{
		$matches = array();
		$regex = "/$start([a-zA-Z0-9_]*)$end/";
		preg_match_all($regex, $str, $matches);
		return $matches[1];
	}
}
