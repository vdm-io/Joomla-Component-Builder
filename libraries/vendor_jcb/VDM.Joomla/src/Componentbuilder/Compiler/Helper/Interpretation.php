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


use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Language\Text;
// use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper; (for Joomla 4 and above)
use VDM\Joomla\FOF\Encrypt\AES;
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
use VDM\Joomla\Componentbuilder\Compiler\Helper\Fields;


/**
 * Interpretation class
 * 
 * @deprecated 3.3
 */
class Interpretation extends Fields
{
	/**
	 * The global config Field Sets
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Config.Fieldsets')->add($key, $value);
	 */
	public $configFieldSets = [];

	/**
	 * The global config Field Sets Custom Fields
	 *
	 * @var     array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Config.Fieldsets.Customfield')->add($key, $value);
	 */
	public $configFieldSetsCustomField = [];

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
	 * @deprecated 3.3 Use CFactory::_('Builder.Database.Uninstall')->set(...);
	 */
	public $uninstallBuilder = [];

	/**
	 * The update SQL builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Model.Updatesql')->set($old, $new, string $type, $key = null, ?array $ignore = null);
	 */
	public $updateSQLBuilder = [];

	/**
	 * The List Column Builder
	 *
	 * @var    array
	 */
	public $listColnrBuilder = [];

	/**
	 * The permissions Builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Permission.Action')->set($action, $nameView, $nameView);
	 * @deprecated 3.3 or Use CFactory::_('Compiler.Builder.Permission.Global')->set($action, $nameView, $nameView);
	 */
	public $permissionBuilder = [];

	/**
	 * The dashboard permissions builder
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Permission.Dashboard')->add('icon', $key, $value)
	 */
	public $permissionDashboard = [];

	/**
	 * The permissions core
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Permission.Core')->set($nameView, $coreTarget, $action);
	 */
	public $permissionCore = [];

	/**
	 * The customs field builder
	 *
	 * @var    array
	 */
	public $customFieldBuilder = [];

	/**
	 * The category builder
	 *
	 * @var    array
	 */
	public $buildCategories = [];

	/**
	 * The icon builder
	 *
	 * @var    array
	 */
	public $iconBuilder = [];

	/**
	 * The validation fix builder
	 *
	 * @var    array
	 */
	public $validationFixBuilder = [];

	/**
	 * The view script builder
	 *
	 * @var    array
	 */
	public $viewScriptBuilder = [];

	/**
	 * The target relation control
	 *
	 * @var    array
	 */
	public $targetRelationControl = [];

	/**
	 * The target control script checker
	 *
	 * @var    array
	 */
	public $targetControlsScriptChecker = [];

	/**
	 * The router helper
	 *
	 * @var    array
	 */
	public $setRouterHelpDone = [];

	/**
	 * The other where
	 *
	 * @var    array
	 */
	public $otherWhere = [];

	/**
	 * The dashboard get custom data
	 *
	 * @var    array
	 */
	public $DashboardGetCustomData = [];

	/**
	 * The custom admin added
	 *
	 * @var    array
	 */
	public $customAdminAdded = [];

	/**
	 * Switch to add form to views
	 *
	 * @var    array
	 */
	public $addCustomForm = [];

	/**
	 * The extensions params
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Extensions.Params')
	 */
	protected $extensionsParams = [];

	/**
	 * The asset rules
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Assets.Rules')
	 */
	public $assetsRules = [];

	/**
	 * View Has Category Request
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Request')->get("catid.$key")
	 */
	protected $hasCatIdRequest = [];

	/**
	 * All fields with permissions
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Permission.Fields')
	 */
	public $permissionFields = [];

	/**
	 * Custom Admin View List Link
	 *
	 * @var    array
	 */
	protected $customAdminViewListLink = [];

	/**
	 * load Tracker of fields to fix
	 *
	 * @var    array
	 */
	protected $loadTracker = [];

	/**
	 * View Has Id Request
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Request')->get("id.$key")
	 */
	protected $hasIdRequest = [];

	/**
	 * Library warning
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Library.Warning')
	 */
	protected $libwarning = [];

	/**
	 * Language message bucket
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Language.Messages')
	 */
	public $langNot = [];

	/**
	 * Language message bucket
	 *
	 * @var    array
	 * @deprecated 3.3 Use CFactory::_('Compiler.Builder.Language.Messages')
	 */
	public $langSet = [];

	/**
	 * alignment names
	 *
	 * @var    array
	 */
	protected $alignmentOptions
		= array(1 => 'left', 2 => 'right', 3 => 'fullwidth', 4 => 'above',
			5 => 'under', 6 => 'leftside', 7 => 'rightside');

	/**
	 * Constructor
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
	 * add email helper
	 */
	public function addEmailHelper()
	{
		if (CFactory::_('Component')->get('add_email_helper'))
		{
			// set email helper in place with component name
			$component = CFactory::_('Config')->component_code_name;
			$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
			$target    = array('admin' => 'emailer');
			$done      = CFactory::_('Utilities.Structure')->build($target, 'emailer', $component);
			if ($done)
			{
				// the text for the file BAKING
				CFactory::_('Compiler.Builder.Content.Multi')->set('emailer_' . $component . '|BAKING', ''); // <<-- to insure it gets updated
				// return the code need to load the abstract class
				return PHP_EOL . "\JLoader::register('" . $Component
					. "Email', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/"
					. $component . "email.php'); ";
			}
		}

		return '';
	}

	/**
	 * set the lock license (NOT OKAY)
	 */
	public function setLockLicense()
	{
		if (CFactory::_('Component')->get('add_license', 0) == 3)
		{
			if (!CFactory::_('Compiler.Builder.Content.One')->exists('HELPER_SITE_LICENSE_LOCK'))
			{
				$_WHMCS = '_' . StringHelper::safe(
						$this->uniquekey(10), 'U'
					);
				// add it to the system
				CFactory::_('Compiler.Builder.Content.One')->set('HELPER_SITE_LICENSE_LOCK', $this->setHelperLicenseLock($_WHMCS, 'site'));
				CFactory::_('Compiler.Builder.Content.One')->set('HELPER_LICENSE_LOCK', $this->setHelperLicenseLock($_WHMCS, 'admin'));
				CFactory::_('Compiler.Builder.Content.One')->set('LICENSE_LOCKED_INT', $this->setInitLicenseLock($_WHMCS));
				CFactory::_('Compiler.Builder.Content.One')->set('LICENSE_LOCKED_DEFINED',
					PHP_EOL . PHP_EOL . 'defined(\'' . $_WHMCS
					. '\') or die(Text:' . ':_(\'NIE_REG_NIE\'));');
			}
		}
		else
		{
			// don't add it to the system
			CFactory::_('Compiler.Builder.Content.One')->set('HELPER_SITE_LICENSE_LOCK', '');
			CFactory::_('Compiler.Builder.Content.One')->set('HELPER_LICENSE_LOCK', '');
			CFactory::_('Compiler.Builder.Content.One')->set('LICENSE_LOCKED_INT', '');
			CFactory::_('Compiler.Builder.Content.One')->set('LICENSE_LOCKED_DEFINED', '');
		}
	}

	/**
	 * set Lock License Per
	 *
	 * @param   string  $view
	 * @param   string  $target
	 */
	public function setLockLicensePer(&$view, $target)
	{
		if (CFactory::_('Component')->get('add_license', 0) == 3)
		{
			if (!CFactory::_('Compiler.Builder.Content.Multi')->exists($view . '|BOOLMETHOD'))
			{
				$boolMethod = 'get' . StringHelper::safe(
						$this->uniquekey(3, false, 'ddd'), 'W'
					);
				$globalbool = 'set' . StringHelper::safe(
						$this->uniquekey(3), 'W'
					);
				// add it to the system
				CFactory::_('Compiler.Builder.Content.Multi')->set($view . '|LICENSE_LOCKED_SET_BOOL',
					$this->setBoolLicenseLock($boolMethod, $globalbool));
				CFactory::_('Compiler.Builder.Content.Multi')->set($view . '|LICENSE_LOCKED_CHECK',
					$this->checkStatmentLicenseLocked($boolMethod));
				CFactory::_('Compiler.Builder.Content.Multi')->set($view . '|LICENSE_TABLE_LOCKED_CHECK',
					$this->checkStatmentLicenseLocked($boolMethod, '$table'));
				CFactory::_('Compiler.Builder.Content.Multi')->set($view . '|BOOLMETHOD', $boolMethod);
			}
		}
		else
		{
			// don't add it to the system
			CFactory::_('Compiler.Builder.Content.Multi')->set($view . '|LICENSE_LOCKED_SET_BOOL', '');
			CFactory::_('Compiler.Builder.Content.Multi')->set($view . '|LICENSE_LOCKED_CHECK', '');
			CFactory::_('Compiler.Builder.Content.Multi')->set($view . '|LICENSE_TABLE_LOCKED_CHECK', '');
		}
	}

	/**
	 * Check statment license locked
	 *
	 * @param   type  $boolMethod
	 * @param   type  $thIIS
	 *
	 * @return string
	 */
	public function checkStatmentLicenseLocked($boolMethod, $thIIS = '$this')
	{
		$statment[] = PHP_EOL . Indent::_(2) . "if (!" . $thIIS . "->"
			. $boolMethod . "())";
		$statment[] = Indent::_(2) . "{";
		$statment[] = Indent::_(3) . "\$app = Factory::getApplication();";
		$statment[] = Indent::_(3) . "\$app->enqueueMessage(Text:"
			. ":_('NIE_REG_NIE'), 'error');";
		$statment[] = Indent::_(3) . "\$app->redirect('index.php');";
		$statment[] = Indent::_(3) . "return false;";
		$statment[] = Indent::_(2) . "}";

		// return the genuine mentod statement
		return implode(PHP_EOL, $statment);
	}

	/**
	 * set Bool License Lock
	 *
	 * @param   type  $boolMethod
	 * @param   type  $globalbool
	 *
	 * @return string
	 */
	public function setBoolLicenseLock($boolMethod, $globalbool)
	{
		$bool[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$bool[] = Indent::_(1) . " * The private bool.";
		$bool[] = Indent::_(1) . " **/";
		$bool[] = Indent::_(1) . "private $" . $globalbool . ";";
		$bool[] = PHP_EOL . Indent::_(1) . "/**";
		$bool[] = Indent::_(1) . " * Check if this install has a license.";
		$bool[] = Indent::_(1) . " **/";
		$bool[] = Indent::_(1) . "public function " . $boolMethod . "()";
		$bool[] = Indent::_(1) . "{";
		$bool[] = Indent::_(2) . "if(!empty(\$this->" . $globalbool . "))";
		$bool[] = Indent::_(2) . "{";
		$bool[] = Indent::_(3) . "return \$this->" . $globalbool . ";";
		$bool[] = Indent::_(2) . "}";
		$bool[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the global params";
		$bool[] = Indent::_(2) . "\$params = ComponentHelper::getParams('com_"
			. CFactory::_('Config')->component_code_name . "', true);";
		$bool[] = Indent::_(2)
			. "\$whmcs_key = \$params->get('whmcs_key', null);";
		$bool[] = Indent::_(2) . "if (\$whmcs_key)";
		$bool[] = Indent::_(2) . "{";
		$bool[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " load the file";
		$bool[] = Indent::_(3)
			. "JLoader::import( 'whmcs', JPATH_ADMINISTRATOR .'/components/com_"
			. CFactory::_('Config')->component_code_name . "');";
		$bool[] = Indent::_(3) . "\$the = new \WHMCS(\$whmcs_key);";
		$bool[] = Indent::_(3) . "\$this->" . $globalbool . " = \$the->_is;";
		$bool[] = Indent::_(3) . "return \$this->" . $globalbool . ";";
		$bool[] = Indent::_(2) . "}";
		$bool[] = Indent::_(2) . "return false;";
		$bool[] = Indent::_(1) . "}";

		// return the genuine method statement
		return implode(PHP_EOL, $bool);
	}

	/**
	 * set Helper License Lock
	 *
	 * @param   type  $_WHMCS
	 * @param   type  $target
	 *
	 * @return string
	 */
	public function setHelperLicenseLock($_WHMCS, $target)
	{
		$helper[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$helper[] = Indent::_(1) . " * Check if this install has a license.";
		$helper[] = Indent::_(1) . " **/";
		$helper[] = Indent::_(1) . "public static function isGenuine()";
		$helper[] = Indent::_(1) . "{";
		$helper[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the global params";
		$helper[] = Indent::_(2)
			. "\$params = ComponentHelper::getParams('com_"
			. CFactory::_('Config')->component_code_name . "', true);";
		$helper[] = Indent::_(2)
			. "\$whmcs_key = \$params->get('whmcs_key', null);";
		$helper[] = Indent::_(2) . "if (\$whmcs_key)";
		$helper[] = Indent::_(2) . "{";
		$helper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " load the file";
		$helper[] = Indent::_(3)
			. "JLoader::import( 'whmcs', JPATH_ADMINISTRATOR .'/components/com_"
			. CFactory::_('Config')->component_code_name . "');";
		$helper[] = Indent::_(3) . "\$the = new \WHMCS(\$whmcs_key);";
		$helper[] = Indent::_(3) . "return \$the->_is;";
		$helper[] = Indent::_(2) . "}";
		$helper[] = Indent::_(2) . "return false;";
		$helper[] = Indent::_(1) . "}";

		// return the genuine mentod statement
		return implode(PHP_EOL, $helper);
	}

	/**
	 * set Init License Lock
	 *
	 * @param   type  $_WHMCS
	 *
	 * @return string
	 */
	public function setInitLicenseLock($_WHMCS)
	{
		$init[] = PHP_EOL . "if (!defined('" . $_WHMCS . "'))";
		$init[] = "{";
		$init[] = Indent::_(1) . "\$allow = "
			. CFactory::_('Compiler.Builder.Content.One')->get('Component')
			. "Helper::isGenuine();";
		$init[] = Indent::_(1) . "if (\$allow)";
		$init[] = Indent::_(1) . "{";
		$init[] = Indent::_(2) . "define('" . $_WHMCS . "', 1);";
		$init[] = Indent::_(1) . "}";
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
		if (CFactory::_('Component')->isString('whmcs_key'))
		{
			// Get the basic encryption.
			$basickey = \ComponentbuilderHelper::getCryptKey('basic');
			$key = CFactory::_('Component')->get('whmcs_key');

			// Get the encryption object.
			$basic = new AES($basickey);
			if ($basickey && $key === base64_encode(
					base64_decode((string) $key, true)
				))
			{
				// basic decrypt data whmcs_key.
				$key = rtrim(
					(string) $basic->decryptString($key), "\0"
				);
				// set the needed string to connect to whmcs
				$key["kasier"] = CFactory::_('Component')->get('whmcs_url', '');
				$key["geheim"] = $key;
				$key["onthou"] = 1;
				// prep the call info
				$theKey = base64_encode(serialize($key));
				// set the script
				$encrypt[] = "/**";
				$encrypt[] = "* " . Line::_(__Line__, __Class__) . "WHMCS Class ";
				$encrypt[] = "**/";
				$encrypt[] = "class WHMCS";
				$encrypt[] = "{";
				$encrypt[] = Indent::_(1) . "public \$_key = false;";
				$encrypt[] = Indent::_(1) . "public \$_is = false;";
				$encrypt[] = PHP_EOL . Indent::_(1)
					. "public function __construct(\$Vk5smi0wjnjb)";
				$encrypt[] = Indent::_(1) . "{";
				$encrypt[] = Indent::_(2) . "// get the session";
				$encrypt[] = Indent::_(2)
					. "\$session = Factory::getSession();";
				$encrypt[] = Indent::_(2)
					. "\$V2uekt2wcgwk = \$session->get(\$Vk5smi0wjnjb, null);";
				$encrypt[] = Indent::_(2)
					. "\$h4sgrGsqq = \$this->get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk);";
				$encrypt[] = Indent::_(2)
					. "if (isset(\$h4sgrGsqq['nuut']) && \$h4sgrGsqq['nuut'] && (isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['eiegrendel']) && strlen(\$h4sgrGsqq['eiegrendel']) > 300)";
				$encrypt[] = Indent::_(2) . "{";
				$encrypt[] = Indent::_(3)
					. "\$session->set(\$Vk5smi0wjnjb, \$h4sgrGsqq['eiegrendel']);";
				$encrypt[] = Indent::_(2) . "}";
				$encrypt[] = Indent::_(2)
					. "if ((isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 && isset(\$h4sgrGsqq['customfields']) && strlen(\$h4sgrGsqq['customfields']) > 4)";
				$encrypt[] = Indent::_(2) . "{";
				$encrypt[] = Indent::_(3)
					. "\$this->_key = md5(\$h4sgrGsqq['customfields']);";
				$encrypt[] = Indent::_(2) . "}";
				$encrypt[] = Indent::_(2)
					. "if ((isset(\$h4sgrGsqq['status']) && 'Active' === \$h4sgrGsqq['status']) && isset(\$h4sgrGsqq['md5hash']) && strlen(\$h4sgrGsqq['md5hash']) == 32 )";
				$encrypt[] = Indent::_(2) . "{";
				$encrypt[] = Indent::_(3) . "\$this->_is = true;";
				$encrypt[] = Indent::_(2) . "}";
				$encrypt[] = Indent::_(1) . "}";
				$encrypt[] = PHP_EOL . Indent::_(1)
					. "private function get(\$Vk5smi0wjnjb,\$V2uekt2wcgwk)";
				$encrypt[] = Indent::_(1) . "{";
				$encrypt[] = Indent::_(2)
					. "\$Viioj50xuqu2 = unserialize(base64_decode('" . $theKey
					. "'));";
				$encrypt[] = Indent::_(2)
					. "\$Visqfrd1caus = time() . md5(mt_rand(1000000000, 9999999999) . \$Vk5smi0wjnjb);";
				$encrypt[] = Indent::_(2) . "\$Vo4tezfgcf3e = date(\"Ymd\");";
				$encrypt[] = Indent::_(2)
					. "\$Vozblwvfym2f = \$_SERVER['SERVER_NAME'];";
				$encrypt[] = Indent::_(2)
					. "\$Vozblwvfym2fdie = isset(\$_SERVER['SERVER_ADDR']) ? \$_SERVER['SERVER_ADDR'] : \$_SERVER['LOCAL_ADDR'];";
				$encrypt[] = Indent::_(2)
					. "\$V343jp03dxco = dirname(__FILE__);";
				$encrypt[] = Indent::_(2)
					. "\$Vc2rayehw4f0 = unserialize(base64_decode('czozNjoibW9kdWxlcy9zZXJ2ZXJzL2xpY2Vuc2luZy92ZXJpZnkucGhwIjs='));";
				$encrypt[] = Indent::_(2) . "\$Vlpolphukogz = false;";
				$encrypt[] = Indent::_(2) . "if (\$V2uekt2wcgwk) {";
				$encrypt[] = Indent::_(3) . "\$V2uekt2wcgwk = str_replace(\""
					. '".PHP_EOL."' . "\", '', \$V2uekt2wcgwk);";
				$encrypt[] = Indent::_(3)
					. "\$Vm5cxjdc43g4 = substr(\$V2uekt2wcgwk, 0, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = Indent::_(3)
					. "\$Vbgx0efeu2sy = substr(\$V2uekt2wcgwk, strlen(\$V2uekt2wcgwk) - 32);";
				$encrypt[] = Indent::_(3)
					. "if (\$Vbgx0efeu2sy == md5(\$Vm5cxjdc43g4 . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = Indent::_(4)
					. "\$Vm5cxjdc43g4 = strrev(\$Vm5cxjdc43g4);";
				$encrypt[] = Indent::_(4)
					. "\$Vbgx0efeu2sy = substr(\$Vm5cxjdc43g4, 0, 32);";
				$encrypt[] = Indent::_(4)
					. "\$Vm5cxjdc43g4 = substr(\$Vm5cxjdc43g4, 32);";
				$encrypt[] = Indent::_(4)
					. "\$Vm5cxjdc43g4 = base64_decode(\$Vm5cxjdc43g4);";
				$encrypt[] = Indent::_(4)
					. "\$Vm5cxjdc43g4finding = unserialize(\$Vm5cxjdc43g4);";
				$encrypt[] = Indent::_(4)
					. "\$V3qqz0p00fbq  = \$Vm5cxjdc43g4finding['dan'];";
				$encrypt[] = Indent::_(4)
					. "if (\$Vbgx0efeu2sy == md5(\$V3qqz0p00fbq  . \$Viioj50xuqu2['geheim'])) {";
				$encrypt[] = Indent::_(5)
					. "\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = Indent::_(5)
					. "if (\$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = Indent::_(6) . "\$Vlpolphukogz = true;";
				$encrypt[] = Indent::_(6)
					. "\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = Indent::_(6)
					. "\$Vcixw3trerrt = explode(',', \$Vwasqoybpyed['validdomain']);";
				$encrypt[] = Indent::_(6)
					. "if (!in_array(\$_SERVER['SERVER_NAME'], \$Vcixw3trerrt)) {";
				$encrypt[] = Indent::_(7) . "\$Vlpolphukogz = false;";
				$encrypt[] = Indent::_(7)
					. "\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = Indent::_(7) . "\$Vwasqoybpyed = [];";
				$encrypt[] = Indent::_(6) . "}";
				$encrypt[] = Indent::_(6)
					. "\$Vkni3xyhkqzv = explode(',', \$Vwasqoybpyed['validip']);";
				$encrypt[] = Indent::_(6)
					. "if (!in_array(\$Vozblwvfym2fdie, \$Vkni3xyhkqzv)) {";
				$encrypt[] = Indent::_(7) . "\$Vlpolphukogz = false;";
				$encrypt[] = Indent::_(7)
					. "\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = Indent::_(7) . "\$Vwasqoybpyed = [];";
				$encrypt[] = Indent::_(6) . "}";
				$encrypt[] = Indent::_(6)
					. "\$Vckfvnepoaxj = explode(',', \$Vwasqoybpyed['validdirectory']);";
				$encrypt[] = Indent::_(6)
					. "if (!in_array(\$V343jp03dxco, \$Vckfvnepoaxj)) {";
				$encrypt[] = Indent::_(7) . "\$Vlpolphukogz = false;";
				$encrypt[] = Indent::_(7)
					. "\$Vm5cxjdc43g4finding['status'] = \"sleg\";";
				$encrypt[] = Indent::_(7) . "\$Vwasqoybpyed = [];";
				$encrypt[] = Indent::_(6) . "}";
				$encrypt[] = Indent::_(5) . "}";
				$encrypt[] = Indent::_(4) . "}";
				$encrypt[] = Indent::_(3) . "}";
				$encrypt[] = Indent::_(2) . "}";
				$encrypt[] = Indent::_(2) . "if (!\$Vlpolphukogz) {";
				$encrypt[] = Indent::_(3) . "\$V1u0c4dl3ehp = array(";
				$encrypt[] = Indent::_(4) . "'licensekey' => \$Vk5smi0wjnjb,";
				$encrypt[] = Indent::_(4) . "'domain' => \$Vozblwvfym2f,";
				$encrypt[] = Indent::_(4) . "'ip' => \$Vozblwvfym2fdie,";
				$encrypt[] = Indent::_(4) . "'dir' => \$V343jp03dxco,";
				$encrypt[] = Indent::_(3) . ");";
				$encrypt[] = Indent::_(3)
					. "if (\$Visqfrd1caus) \$V1u0c4dl3ehp['check_token'] = \$Visqfrd1caus;";
				$encrypt[] = Indent::_(3) . "\$Vdsjeyjmpq2o = '';";
				$encrypt[] = Indent::_(3)
					. "foreach (\$V1u0c4dl3ehp AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = Indent::_(4)
					. "\$Vdsjeyjmpq2o .= \$V2sgyscukmgi.'='.urlencode(\$V1u00zkzmb1d).'&';";
				$encrypt[] = Indent::_(3) . "}";
				$encrypt[] = Indent::_(3)
					. "if (function_exists('curl_exec')) {";
				$encrypt[] = Indent::_(4) . "\$Vdathuqgjyf0 = curl_init();";
				$encrypt[] = Indent::_(4)
					. "curl_setopt(\$Vdathuqgjyf0, CURLOPT_URL, \$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0);";
				$encrypt[] = Indent::_(4)
					. "curl_setopt(\$Vdathuqgjyf0, CURLOPT_POST, 1);";
				$encrypt[] = Indent::_(4)
					. "curl_setopt(\$Vdathuqgjyf0, CURLOPT_POSTFIELDS, \$Vdsjeyjmpq2o);";
				$encrypt[] = Indent::_(4)
					. "curl_setopt(\$Vdathuqgjyf0, CURLOPT_TIMEOUT, 30);";
				$encrypt[] = Indent::_(4)
					. "curl_setopt(\$Vdathuqgjyf0, CURLOPT_RETURNTRANSFER, 1);";
				$encrypt[] = Indent::_(4)
					. "\$Vqojefyeohg5 = curl_exec(\$Vdathuqgjyf0);";
				$encrypt[] = Indent::_(4) . "curl_close(\$Vdathuqgjyf0);";
				$encrypt[] = Indent::_(3) . "} else {";
				$encrypt[] = Indent::_(4)
					. "\$Vrpmu4bvnmkp = fsockopen(\$Viioj50xuqu2['kasier'], 80, \$Vc0t5kmpwkwk, \$Va3g41fnofhu, 5);";
				$encrypt[] = Indent::_(4) . "if (\$Vrpmu4bvnmkp) {";
				$encrypt[] = Indent::_(5) . "\$Vznkm0a0me1y = \"\r" . PHP_EOL
					. "\";";
				$encrypt[] = Indent::_(5)
					. "\$V2sgyscukmgiop = \"POST \".\$Viioj50xuqu2['kasier'] . \$Vc2rayehw4f0 . \" HTTP/1.0\" . \$Vznkm0a0me1y;";
				$encrypt[] = Indent::_(5)
					. "\$V2sgyscukmgiop .= \"Host: \".\$Viioj50xuqu2['kasier'] . \$Vznkm0a0me1y;";
				$encrypt[] = Indent::_(5)
					. "\$V2sgyscukmgiop .= \"Content-type: application/x-www-form-urlencoded\" . \$Vznkm0a0me1y;";
				$encrypt[] = Indent::_(5)
					. "\$V2sgyscukmgiop .= \"Content-length: \".@strlen(\$Vdsjeyjmpq2o) . \$Vznkm0a0me1y;";
				$encrypt[] = Indent::_(5)
					. "\$V2sgyscukmgiop .= \"Connection: close\" . \$Vznkm0a0me1y . \$Vznkm0a0me1y;";
				$encrypt[] = Indent::_(5)
					. "\$V2sgyscukmgiop .= \$Vdsjeyjmpq2o;";
				$encrypt[] = Indent::_(5) . "\$Vqojefyeohg5 = '';";
				$encrypt[] = Indent::_(5)
					. "@stream_set_timeout(\$Vrpmu4bvnmkp, 20);";
				$encrypt[] = Indent::_(5)
					. "@fputs(\$Vrpmu4bvnmkp, \$V2sgyscukmgiop);";
				$encrypt[] = Indent::_(5)
					. "\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = Indent::_(5)
					. "while (!@feof(\$Vrpmu4bvnmkp)&&\$V2czq24pjexf) {";
				$encrypt[] = Indent::_(6)
					. "\$Vqojefyeohg5 .= @fgets(\$Vrpmu4bvnmkp, 1024);";
				$encrypt[] = Indent::_(6)
					. "\$V2czq24pjexf = @socket_get_status(\$Vrpmu4bvnmkp);";
				$encrypt[] = Indent::_(5) . "}";
				$encrypt[] = Indent::_(5) . "@fclose (\$Vqojefyeohg5);";
				$encrypt[] = Indent::_(4) . "}";
				$encrypt[] = Indent::_(3) . "}";
				$encrypt[] = Indent::_(3) . "if (!\$Vqojefyeohg5) {";
				$encrypt[] = Indent::_(4)
					. "\$Vbfbwv2y4kre = date(\"Ymd\", mktime(0, 0, 0, date(\"m\"), date(\"d\") - \$Viioj50xuqu2['onthou'], date(\"Y\")));";
				$encrypt[] = Indent::_(4)
					. "if (isset(\$V3qqz0p00fbq) && \$V3qqz0p00fbq  > \$Vbfbwv2y4kre) {";
				$encrypt[] = Indent::_(5)
					. "\$Vwasqoybpyed = \$Vm5cxjdc43g4finding;";
				$encrypt[] = Indent::_(4) . "} else {";
				$encrypt[] = Indent::_(5) . "\$Vwasqoybpyed = [];";
				$encrypt[] = Indent::_(5)
					. "\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = Indent::_(5)
					. "\$Vwasqoybpyed['description'] = \"Remote Check Failed\";";
				$encrypt[] = Indent::_(5) . "return \$Vwasqoybpyed;";
				$encrypt[] = Indent::_(4) . "}";
				$encrypt[] = Indent::_(3) . "} else {";
				$encrypt[] = Indent::_(4) . "preg_match_all('"
					. '/<(.*?)>([^<]+)<\/\\1>/i'
					. "', \$Vqojefyeohg5, \$V1ot20wob03f);";
				$encrypt[] = Indent::_(4) . "\$Vwasqoybpyed = [];";
				$encrypt[] = Indent::_(4)
					. "foreach (\$V1ot20wob03f[1] AS \$V2sgyscukmgi=>\$V1u00zkzmb1d) {";
				$encrypt[] = Indent::_(5)
					. "\$Vwasqoybpyed[\$V1u00zkzmb1d] = \$V1ot20wob03f[2][\$V2sgyscukmgi];";
				$encrypt[] = Indent::_(4) . "}";
				$encrypt[] = Indent::_(3) . "}";
				$encrypt[] = Indent::_(3) . "if (!is_array(\$Vwasqoybpyed)) {";
				$encrypt[] = Indent::_(4)
					. "die(\"Invalid License Server Response\");";
				$encrypt[] = Indent::_(3) . "}";
				$encrypt[] = Indent::_(3)
					. "if (isset(\$Vwasqoybpyed['md5hash']) && \$Vwasqoybpyed['md5hash']) {";
				$encrypt[] = Indent::_(4)
					. "if (\$Vwasqoybpyed['md5hash'] != md5(\$Viioj50xuqu2['geheim'] . \$Visqfrd1caus)) {";
				$encrypt[] = Indent::_(5)
					. "\$Vwasqoybpyed['status'] = \"sleg\";";
				$encrypt[] = Indent::_(5)
					. "\$Vwasqoybpyed['description'] = \"MD5 Checksum Verification Failed\";";
				$encrypt[] = Indent::_(5) . "return \$Vwasqoybpyed;";
				$encrypt[] = Indent::_(4) . "}";
				$encrypt[] = Indent::_(3) . "}";
				$encrypt[] = Indent::_(3)
					. "if (isset(\$Vwasqoybpyed['status']) && \$Vwasqoybpyed['status'] == \"Active\") {";
				$encrypt[] = Indent::_(4)
					. "\$Vwasqoybpyed['dan'] = \$Vo4tezfgcf3e;";
				$encrypt[] = Indent::_(4)
					. "\$Vqojefyeohg5ing = serialize(\$Vwasqoybpyed);";
				$encrypt[] = Indent::_(4)
					. "\$Vqojefyeohg5ing = base64_encode(\$Vqojefyeohg5ing);";
				$encrypt[] = Indent::_(4)
					. "\$Vqojefyeohg5ing = md5(\$Vo4tezfgcf3e . \$Viioj50xuqu2['geheim']) . \$Vqojefyeohg5ing;";
				$encrypt[] = Indent::_(4)
					. "\$Vqojefyeohg5ing = strrev(\$Vqojefyeohg5ing);";
				$encrypt[] = Indent::_(4)
					. "\$Vqojefyeohg5ing = \$Vqojefyeohg5ing . md5(\$Vqojefyeohg5ing . \$Viioj50xuqu2['geheim']);";
				$encrypt[] = Indent::_(4)
					. "\$Vqojefyeohg5ing = wordwrap(\$Vqojefyeohg5ing, 80, \""
					. '".PHP_EOL."' . "\", true);";
				$encrypt[] = Indent::_(4)
					. "\$Vwasqoybpyed['eiegrendel'] = \$Vqojefyeohg5ing;";
				$encrypt[] = Indent::_(3) . "}";
				$encrypt[] = Indent::_(3) . "\$Vwasqoybpyed['nuut'] = true;";
				$encrypt[] = Indent::_(2) . "}";
				$encrypt[] = Indent::_(2)
					. "unset(\$V1u0c4dl3ehp,\$Vqojefyeohg5,\$V1ot20wob03f,\$Viioj50xuqu2['kasier'],\$Viioj50xuqu2['geheim'],\$Vo4tezfgcf3e,\$Vozblwvfym2fdie,\$Viioj50xuqu2['onthou'],\$Vbgx0efeu2sy);";
				$encrypt[] = Indent::_(2) . "return \$Vwasqoybpyed;";
				$encrypt[] = Indent::_(1) . "}";
				$encrypt[] = "}";

				// return the help methods
				return implode(PHP_EOL, $encrypt);
			}
		}
		// give notice of this issue
		$this->app->enqueueMessage(
			Text::_('COM_COMPONENTBUILDER_HR_HTHREEWHMCS_ERRORHTHREE'), 'Error'
		);
		$this->app->enqueueMessage(
			Text::_(
				'The <b>WHMCS class</b> could not be added to this component. You will need to enable the add-on in the Joomla Component area (Add WHMCS)->Yes. If you have done this, then please check that you have your own <b>Basic Encryption<b/> set in the global settings of JCB. Then open and save this component again, making sure that your WHMCS settings are still correct.'
			), 'Error'
		);

		return "//" . Line::_(__Line__, __Class__)
			. " The WHMCS class could not be added to this component." . PHP_EOL
			. "//" . Line::_(__Line__, __Class__)
			. " Please note that you will need to enable the add-on in the Joomla Component area (Add WHMCS)->Yes.";
	}

	/**
	 * set Get Crypt Key
	 *
	 * @return string
	 */
	public function setGetCryptKey()
	{
		// WHMCS_ENCRYPT_FILE
		CFactory::_('Compiler.Builder.Content.One')->set('WHMCS_ENCRYPT_FILE', '');
		// check if encryption is ative
		if (CFactory::_('Compiler.Builder.Model.Basic.Field')->isActive()
			|| CFactory::_('Compiler.Builder.Model.Medium.Field')->isActive()
			|| CFactory::_('Compiler.Builder.Model.Whmcs.Field')->isActive()
			|| CFactory::_('Component')->get('add_license'))
		{
			if (CFactory::_('Compiler.Builder.Model.Whmcs.Field')->isActive()
				|| CFactory::_('Component')->get('add_license'))
			{
				// set whmcs encrypt file into place
				$target = array('admin' => 'whmcs');
				$done   = CFactory::_('Utilities.Structure')->build($target, 'whmcs');
				// the text for the file WHMCS_ENCRYPTION_BODY
				CFactory::_('Compiler.Builder.Content.Multi')->set('whmcs' . '|WHMCS_ENCRYPTION_BODY', $this->setWHMCSCryption());
				// ENCRYPT_FILE
				CFactory::_('Compiler.Builder.Content.One')->set('WHMCS_ENCRYPT_FILE', PHP_EOL . Indent::_(3) . "<filename>whmcs.php</filename>");
			}
			// get component name
			$component = CFactory::_('Config')->component_code_name;
			// set the getCryptKey function to the helper class
			$function = [];
			// start building the getCryptKey function/class method
			$function[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$function[] = Indent::_(1) . " *	Get The Encryption Keys";
			$function[] = Indent::_(1) . " *";
			$function[] = Indent::_(1)
				. " *	@param  string        \$type     The type of key";
			$function[] = Indent::_(1)
				. " *	@param  string/bool   \$default  The return value if no key was found";
			$function[] = Indent::_(1) . " *";
			$function[] = Indent::_(1) . " *	@return  string   On success";
			$function[] = Indent::_(1) . " *";
			$function[] = Indent::_(1) . " **/";
			$function[] = Indent::_(1)
				. "public static function getCryptKey(\$type, \$default = false)";
			$function[] = Indent::_(1) . "{";
			$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Get the global params";
			$function[] = Indent::_(2)
				. "\$params = ComponentHelper::getParams('com_" . $component
				. "', true);";
			// add the basic option
			if (CFactory::_('Compiler.Builder.Model.Basic.Field')->isActive())
			{
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Basic Encryption Type";
				$function[] = Indent::_(2) . "if ('basic' === \$type)";
				$function[] = Indent::_(2) . "{";
				$function[] = Indent::_(3)
					. "\$basic_key = \$params->get('basic_key', \$default);";
				$function[] = Indent::_(3)
					. "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$basic_key))";
				$function[] = Indent::_(3) . "{";
				$function[] = Indent::_(4) . "return \$basic_key;";
				$function[] = Indent::_(3) . "}";
				$function[] = Indent::_(2) . "}";
			}
			// add the medium option
			if (CFactory::_('Compiler.Builder.Model.Medium.Field')->isActive())
			{
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Medium Encryption Type";
				$function[] = Indent::_(2) . "if ('medium' === \$type)";
				$function[] = Indent::_(2) . "{";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " check if medium key is already loaded.";
				$function[] = Indent::_(3)
					. "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(self::\$mediumCryptKey))";
				$function[] = Indent::_(3) . "{";
				$function[] = Indent::_(4)
					. "return (self::\$mediumCryptKey !== 'none') ? trim(self::\$mediumCryptKey) : \$default;";
				$function[] = Indent::_(3) . "}";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " get the path to the medium encryption key.";
				$function[] = Indent::_(3)
					. "\$medium_key_path = \$params->get('medium_key_path', null);";
				$function[] = Indent::_(3)
					. "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$medium_key_path))";
				$function[] = Indent::_(3) . "{";
				$function[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " load the key from the file.";
				$function[] = Indent::_(4)
					. "if (self::getMediumCryptKey(\$medium_key_path))";
				$function[] = Indent::_(4) . "{";
				$function[] = Indent::_(5)
					. "return trim(self::\$mediumCryptKey);";
				$function[] = Indent::_(4) . "}";
				$function[] = Indent::_(3) . "}";
				$function[] = Indent::_(2) . "}";
			}
			// add the whmcs option
			if (CFactory::_('Compiler.Builder.Model.Whmcs.Field')->isActive()
				|| CFactory::_('Component')->get('add_license'))
			{
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " WHMCS Encryption Type";
				$function[] = Indent::_(2)
					. "if ('whmcs' === \$type || 'advanced' === \$type)";
				$function[] = Indent::_(2) . "{";
				$function[] = Indent::_(3)
					. "\$key = \$params->get('whmcs_key', \$default);";
				$function[] = Indent::_(3) . "if (Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$key))";
				$function[] = Indent::_(3) . "{";
				$function[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
					. " load the file";
				$function[] = Indent::_(4)
					. "JLoader::import( 'whmcs', JPATH_COMPONENT_ADMINISTRATOR);";
				$function[] = PHP_EOL . Indent::_(4)
					. "\$the = new \WHMCS(\$key);";
				$function[] = PHP_EOL . Indent::_(4) . "return \$the->_key;";
				$function[] = Indent::_(3) . "}";
				$function[] = Indent::_(2) . "}";
			}
			// end the function
			$function[] = PHP_EOL . Indent::_(2) . "return \$default;";
			$function[] = Indent::_(1) . "}";
			// set the getMediumCryptKey class/method
			if (CFactory::_('Compiler.Builder.Model.Medium.Field')->isActive())
			{
				$function[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
				$function[] = Indent::_(1) . " *	The Medium Encryption Key";
				$function[] = Indent::_(1) . " *";
				$function[] = Indent::_(1) . " *	@var  string/bool";
				$function[] = Indent::_(1) . " **/";
				$function[] = Indent::_(1)
					. "protected static \$mediumCryptKey = false;";
				$function[] = PHP_EOL . Indent::_(1) . "/**";
				$function[] = Indent::_(1)
					. " *	Get The Medium Encryption Key";
				$function[] = Indent::_(1) . " *";
				$function[] = Indent::_(1)
					. " *	@param   string    \$path  The path to the medium crypt key folder";
				$function[] = Indent::_(1) . " *";
				$function[] = Indent::_(1)
					. " *	@return  string    On success";
				$function[] = Indent::_(1) . " *";
				$function[] = Indent::_(1) . " **/";
				$function[] = Indent::_(1)
					. "public static function getMediumCryptKey(\$path)";
				$function[] = Indent::_(1) . "{";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Prep the path a little";
				$function[] = Indent::_(2)
					. "\$path = '/'. trim(str_replace('//', '/', \$path), '/');";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Check if folder exist";
				$function[] = Indent::_(2) . "if (!Folder::exists(\$path))";
				$function[] = Indent::_(2) . "{";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Lock key.";
				$function[] = Indent::_(3) . "self::\$mediumCryptKey = 'none';";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Set the error message.";
				$function[] = Indent::_(3)
					. "Factory::getApplication()->enqueueMessage(Text:" . ":_('"
					. CFactory::_('Config')->lang_prefix
					. "_CONFIG_MEDIUM_KEY_PATH_ERROR'), 'Error');";
				$function[] = Indent::_(3) . "return false;";
				$function[] = Indent::_(2) . "}";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Create FileName and set file path";
				$function[] = Indent::_(2)
					. "\$filePath = \$path.'/.'.md5('medium_crypt_key_file');";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Check if we already have the file set";
				$function[] = Indent::_(2)
					. "if ((self::\$mediumCryptKey = @file_get_contents(\$filePath)) !== FALSE)";
				$function[] = Indent::_(2) . "{";
				$function[] = Indent::_(3) . "return true;";
				$function[] = Indent::_(2) . "}";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Set the key for the first time";
				$function[] = Indent::_(2)
					. "self::\$mediumCryptKey = self::randomkey(128);";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Open the key file";
				$function[] = Indent::_(2) . "\$fh = @fopen(\$filePath, 'w');";
				$function[] = Indent::_(2) . "if (!is_resource(\$fh))";
				$function[] = Indent::_(2) . "{";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Lock key.";
				$function[] = Indent::_(3) . "self::\$mediumCryptKey = 'none';";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Set the error message.";
				$function[] = Indent::_(3)
					. "Factory::getApplication()->enqueueMessage(Text:" . ":_('"
					. CFactory::_('Config')->lang_prefix
					. "_CONFIG_MEDIUM_KEY_PATH_ERROR'), 'Error');";
				$function[] = Indent::_(3) . "return false;";
				$function[] = Indent::_(2) . "}";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Write to the key file";
				$function[] = Indent::_(2)
					. "if (!fwrite(\$fh, self::\$mediumCryptKey))";
				$function[] = Indent::_(2) . "{";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Close key file.";
				$function[] = Indent::_(3) . "fclose(\$fh);";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Lock key.";
				$function[] = Indent::_(3) . "self::\$mediumCryptKey = 'none';";
				$function[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Set the error message.";
				$function[] = Indent::_(3)
					. "Factory::getApplication()->enqueueMessage(Text:" . ":_('"
					. CFactory::_('Config')->lang_prefix
					. "_CONFIG_MEDIUM_KEY_PATH_ERROR'), 'Error');";
				$function[] = Indent::_(3) . "return false;";
				$function[] = Indent::_(2) . "}";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Close key file.";
				$function[] = Indent::_(2) . "fclose(\$fh);";
				$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Key is set.";
				$function[] = Indent::_(2) . "return true;";
				$function[] = Indent::_(1) . "}";
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
		if (CFactory::_('Component')->isArray('version_update')
			|| CFactory::_('Compiler.Builder.Update.Mysql')->isActive())
		{
			$updateXML = [];
			// add the update server
			if (CFactory::_('Component')->get('update_server_target', 3) != 3)
			{
				$updateXML[] = '<updates>';
			}

			// add the dynamic sql switch
			$addDynamicSQL = true;
			$addActive     = true;
			if (CFactory::_('Component')->isArray('version_update'))
			{
				$updates = CFactory::_('Component')->get('version_update');
				foreach ($updates as $nr => &$update)
				{
					$this->setUpdateXMLSQL($update, $updateXML, $addDynamicSQL);

					if ($update['version']
						== CFactory::_('Component')->get('component_version'))
					{
						$addActive = false;
					}
				}
				CFactory::_('Component')->set('version_update', $updates);
			}
			// add the dynamic sql if not already added
			if ($addDynamicSQL
				&& CFactory::_('Compiler.Builder.Update.Mysql')->isActive())
			{
				// add the dynamic sql
				$this->setDynamicUpdateXMLSQL($updateXML);
			}
			// add the new active version if needed
			if ($addActive && CFactory::_('Compiler.Builder.Update.Mysql')->isActive())
			{
				// add the dynamic sql
				$this->setDynamicUpdateXMLSQL($updateXML, $addActive);
			}
			// add the update server file
			if (CFactory::_('Component')->get('update_server_target', 3) != 3)
			{
				$updateXML[] = '</updates>';
				// UPDATE_SERVER_XML
				$name   = substr(
					(string) CFactory::_('Component')->get('update_server_url'),
					strrpos((string) CFactory::_('Component')->get('update_server_url'), '/')
					+ 1
				);
				$name   = explode('.xml', $name)[0];
				$target = array('admin' => $name);
				CFactory::_('Utilities.Structure')->build($target, 'update_server');
				CFactory::_('Compiler.Builder.Content.Multi')->set($name . '|UPDATE_SERVER_XML', implode(PHP_EOL, $updateXML));

				// set the Update server file name
				$this->updateServerFileName = $name;
			}
		}
		// add the update server link to component XML
		if (CFactory::_('Component')->get('add_update_server')
			&& CFactory::_('Component')->isString('update_server_url'))
		{
			// UPDATESERVER
			$updateServer   = [];
			$updateServer[] = PHP_EOL . Indent::_(1) . "<updateservers>";
			$updateServer[] = Indent::_(2)
				. '<server type="extension" enabled="1" element="com_'
				. CFactory::_('Config')->component_code_name . '" name="'
				. CFactory::_('Compiler.Builder.Content.One')->get('Component_name') . '">' . CFactory::_('Component')->get('update_server_url')
				. '</server>';
			$updateServer[] = Indent::_(1) . '</updateservers>';
			// return the array to string
			$updateServer = implode(PHP_EOL, $updateServer);
			// add update server details to component XML file
			CFactory::_('Compiler.Builder.Content.One')->set('UPDATESERVER', $updateServer);
		}
		else
		{
			// add update server details to component XML file
			CFactory::_('Compiler.Builder.Content.One')->set('UPDATESERVER', '');
		}
		// ensure to update Component version data
		if (CFactory::_('Compiler.Builder.Update.Mysql')->isActive())
		{
			$buket = [];
			$nr    = 0;
			foreach (CFactory::_('Component')->get('version_update') as $values)
			{
				$buket['version_update' . $nr] = $values;
				$nr++;
			}
			// update the joomla component table
			$newJ       = [];
			$newJ['id'] = (int) CFactory::_('Config')->component_id;
			$newJ['component_version']
				= CFactory::_('Component')->get('component_version');
			// update the component with the new dynamic SQL
			CFactory::_('Data.Item')->table('joomla_component')->set((object) $newJ, 'id'); // <-- to insure the history is also updated
			// reset the watch here
			CFactory::_('History')->get('joomla_component', CFactory::_('Config')->component_id);

			// update the component update table
			$newU = [];
			if (CFactory::_('Component')->get('version_update_id', 0)  > 0)
			{
				$newU['id'] = (int) CFactory::_('Component')->get('version_update_id', 0);
			}
			else
			{
				$newU['joomla_component'] = (int) CFactory::_('Config')->component_id;
			}
			$newU['version_update'] = $buket;
			// update the component with the new dynamic SQL
			CFactory::_('Data.Item')->table('component_updates')->set((object) $newU, 'id'); // <-- to insure the history is also updated
		}
	}

	/**
	 * set Dynamic Update XML SQL
	 *
	 * @param   array  $updateXML
	 * @param   bool   $current_version
	 */
	public function setDynamicUpdateXMLSQL(&$updateXML, $current_version = false
	)
	{
		// start building the update
		$update_ = [];
		if ($current_version)
		{
			// setup new version
			$update_['version'] = CFactory::_('Component')->get('component_version');
			// setup SQL
			$update_['mysql'] = '';
			// setup URL
			$update_['url'] = 'http://domain.com/demo.zip';
		}
		else
		{
			// setup new version
			$update_['version'] = CFactory::_('Component')->get('old_component_version');
			// setup SQL
			$update_['mysql'] = trim(
				implode(PHP_EOL . PHP_EOL, CFactory::_('Compiler.Builder.Update.Mysql')->allActive())
			);
			// setup URL
			if (isset($this->lastupdateURL))
			{
				$paceholders    = array(
					CFactory::_('Component')->get('component_version') => CFactory::_('Component')->get('old_component_version'),
					str_replace(
						'.', '-', (string) CFactory::_('Component')->get('component_version')
					)                                       => str_replace(
						'.', '-', (string) CFactory::_('Component')->get('old_component_version')
					),
					str_replace(
						'.', '_', (string) CFactory::_('Component')->get('component_version')
					)                                       => str_replace(
						'.', '_', (string) CFactory::_('Component')->get('old_component_version')
					),
					str_replace(
						'.', '', (string) CFactory::_('Component')->get('component_version')
					)                                       => str_replace(
						'.', '', (string) CFactory::_('Component')->get('old_component_version')
					)
				);
				$update_['url'] = CFactory::_('Placeholder')->update(
					$this->lastupdateURL, $paceholders
				);
			}
			else
			{
				// setup URL
				$update_['url'] = 'http://domain.com/demo.zip';
			}
		}
		// stop it from being added double
		$addDynamicSQL = false;
		// add dynamic SQL
		$this->setUpdateXMLSQL($update_, $updateXML, $addDynamicSQL);

		CFactory::_('Component')->appendArray('version_update', $update_);
	}

	/**
	 * set Update XML SQL
	 *
	 * @param   array    $update
	 * @param   array    $updateXML
	 * @param   boolean  $addDynamicSQL
	 */
	public function setUpdateXMLSQL(&$update, &$updateXML, &$addDynamicSQL)
	{
		// ensure version naming is correct
		$update['version'] = preg_replace('/^v/i', '', (string) $update['version']);
		// setup SQL
		if (StringHelper::check($update['mysql']))
		{
			$update['mysql'] = CFactory::_('Placeholder')->update_(
				$update['mysql']
			);
		}
		// add dynamic SQL
		$force = false;
		if ($addDynamicSQL
			&& CFactory::_('Compiler.Builder.Update.Mysql')->isActive()
			&& CFactory::_('Component')->get('old_component_version') == $update['version'])
		{
			$searchMySQL = preg_replace('/\s+/', '', (string) $update['mysql']);
			// add the updates to the SQL only if not found
			foreach (CFactory::_('Compiler.Builder.Update.Mysql')->allActive() as $search => $query)
			{
				if (strpos($searchMySQL, $search) === false)
				{
					$update['mysql'] .= PHP_EOL . PHP_EOL . $query;
				}
			}
			// make sure no unneeded white space is added
			$update['mysql'] = trim((string) $update['mysql']);
			// update has been added
			$addDynamicSQL = false;
		}
		// setup import files
		if ($update['version'] != CFactory::_('Component')->get('component_version'))
		{
			$name   = StringHelper::safe($update['version']);
			$target = array('admin' => $name);
			CFactory::_('Utilities.Structure')->build($target, 'sql_update', $update['version']);
			$_name = preg_replace('/[\.]+/', '_', (string) $update['version']);
			CFactory::_('Compiler.Builder.Content.Multi')->set($name . '_' . $_name . '|UPDATE_VERSION_MYSQL',
				$update['mysql']
			);
		}
		elseif (isset($update['url'])
			&& StringHelper::check(
				$update['url']
			))
		{
			$this->lastupdateURL = $update['url'];
		}
		// add the update server
		if (CFactory::_('Component')->get('add_update_server', 3) != 3)
		{
			// we set the defaults
			$u_element = 'com_' . CFactory::_('Config')->component_code_name;
			$u_server_type = 'component';
			$u_state = 'stable';
			$u_target_version = '3.*';
			$u_client = null;
			// check if we have advance options set
			if (isset($update['update_server_adv']) && $update['update_server_adv'])
			{
				$u_element = (isset($update['update_element']) && strlen((string) $update['update_element']) > 0)
					? $update['update_element'] : $u_element;
				$u_server_type = (isset($update['update_server_type']) && strlen((string) $update['update_server_type']) > 0)
					? $update['update_server_type'] : $u_server_type;
				$u_state = (isset($update['update_state']) && strlen((string) $update['update_state']) > 0)
					? $update['update_state'] : $u_state;
				$u_target_version = (isset($update['update_target_version']) && strlen((string) $update['update_target_version']) > 0)
					? $update['update_target_version'] : $u_target_version;
				$u_client = (isset($update['update_client']) && strlen((string) $update['update_client']) > 0)
					? $update['update_client'] : $u_client;
			}
			// build update xml
			$updateXML[] = Indent::_(1) . "<update>";
			$updateXML[] = Indent::_(2) . "<name>"
				. CFactory::_('Compiler.Builder.Content.One')->get('Component_name') . "</name>";
			$updateXML[] = Indent::_(2) . "<description>"
				. CFactory::_('Compiler.Builder.Content.One')->get('SHORT_DESCRIPTION') . "</description>";
			$updateXML[] = Indent::_(2) . "<element>$u_element</element>";
			$updateXML[] = Indent::_(2) . "<type>$u_server_type</type>";
			// check if we should add the target client value
			if ($u_client)
			{
				$updateXML[] = Indent::_(2) . "<client>$u_client</client>";
			}
			$updateXML[] = Indent::_(2) . "<version>" . $update['version']
				. "</version>";
			$updateXML[] = Indent::_(2) . '<infourl title="'
				. CFactory::_('Compiler.Builder.Content.One')->get('Component_name') . '!">' . CFactory::_('Compiler.Builder.Content.One')->get('AUTHORWEBSITE') . '</infourl>';
			$updateXML[] = Indent::_(2) . "<downloads>";
			if (!isset($update['url'])
				|| !StringHelper::check(
					$update['url']
				))
			{
				$update['url'] = 'http://domain.com/demo.zip';
			}
			$updateXML[] = Indent::_(3)
				. '<downloadurl type="full" format="zip">' . $update['url']
				. '</downloadurl>';
			$updateXML[] = Indent::_(2) . "</downloads>";
			$updateXML[] = Indent::_(2) . "<tags>";
			$updateXML[] = Indent::_(3) . "<tag>$u_state</tag>";
			$updateXML[] = Indent::_(2) . "</tags>";
			$updateXML[] = Indent::_(2) . "<maintainer>"
				. CFactory::_('Compiler.Builder.Content.One')->get('AUTHOR')
				. "</maintainer>";
			$updateXML[] = Indent::_(2) . "<maintainerurl>"
				. CFactory::_('Compiler.Builder.Content.One')->get('AUTHORWEBSITE') . "</maintainerurl>";
			$updateXML[] = Indent::_(2)
				. '<targetplatform name="joomla" version="' . $u_target_version . '"/>';
			$updateXML[] = Indent::_(1) . "</update>";
		}
	}

	/**
	 * no Help
	 *
	 * @return string
	 */
	public function noHelp()
	{
		$help   = [];
		$help[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$help[] = Indent::_(1) . " *	Can be used to build help urls.";
		$help[] = Indent::_(1) . " **/";
		$help[] = Indent::_(1) . "public static function getHelpUrl(\$view)";
		$help[] = Indent::_(1) . "{";
		$help[] = Indent::_(2) . "return false;";
		$help[] = Indent::_(1) . "}";

		// return the no help method
		return implode(PHP_EOL, $help);
	}

	public function checkHelp($nameSingleCode)
	{
		if ($nameSingleCode == "help_document")
		{
			// set help file into admin place
			$target    = array('admin' => 'help');
			$admindone = CFactory::_('Utilities.Structure')->build($target, 'help');
			// set the help file into site place
			$target   = array('site' => 'help');
			$sitedone = CFactory::_('Utilities.Structure')->build($target, 'help');
			if ($admindone && $sitedone)
			{
				// HELP
				CFactory::_('Compiler.Builder.Content.One')->set('HELP', $this->setHelp(1));
				// HELP_SITE
				CFactory::_('Compiler.Builder.Content.One')->set('HELP_SITE', $this->setHelp(2));
				// to make sure the file is updated TODO
				CFactory::_('Compiler.Builder.Content.Multi')->set('help' . '|BLABLA', 'blabla');

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
		$help   = [];
		$help[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$help[] = Indent::_(1) . " *	Load the Component Help URLs.";
		$help[] = Indent::_(1) . " **/";
		$help[] = Indent::_(1) . "public static function getHelpUrl(\$view)";
		$help[] = Indent::_(1) . "{";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$help[] = Indent::_(2) . "\$user	= Factory::getUser();";
		}
		else
		{
			$help[] = Indent::_(2) . "\$user	= Factory::getApplication()->getIdentity();";
		}
		$help[] = Indent::_(2) . "\$groups = \$user->get('groups');";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$help[] = Indent::_(2) . "\$db	= Factory::getDbo();";
		}
		else
		{
			$help[] = Indent::_(2) . "\$db	= Factory::getContainer()->get(DatabaseInterface::class);";
		}
		$help[] = Indent::_(2) . "\$query	= \$db->getQuery(true);";
		$help[] = Indent::_(2)
			. "\$query->select(array('a.id','a.groups','a.target','a.type','a.article','a.url'));";
		$help[] = Indent::_(2) . "\$query->from('#__" . CFactory::_('Config')->component_code_name
			. "_help_document AS a');";
		$help[] = Indent::_(2) . "\$query->where('a." . $target
			. " = '.\$db->quote(\$view));";
		$help[] = Indent::_(2) . "\$query->where('a.location = "
			. (int) $location . "');";
		$help[] = Indent::_(2) . "\$query->where('a.published = 1');";
		$help[] = Indent::_(2) . "\$db->setQuery(\$query);";
		$help[] = Indent::_(2) . "\$db->execute();";
		$help[] = Indent::_(2) . "if(\$db->getNumRows())";
		$help[] = Indent::_(2) . "{";
		$help[] = Indent::_(3) . "\$helps = \$db->loadObjectList();";
		$help[] = Indent::_(3) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$helps))";
		$help[] = Indent::_(3) . "{";
		$help[] = Indent::_(4) . "foreach (\$helps as \$nr => \$help)";
		$help[] = Indent::_(4) . "{";
		$help[] = Indent::_(5) . "if (\$help->target == 1)";
		$help[] = Indent::_(5) . "{";
		$help[] = Indent::_(6)
			. "\$targetgroups = json_decode(\$help->groups, true);";
		$help[] = Indent::_(6)
			. "if (!array_intersect(\$targetgroups, \$groups))";
		$help[] = Indent::_(6) . "{";
		$help[] = Indent::_(7) . "//" . Line::_(__Line__, __Class__)
			. " if user not in those target groups then remove the item";
		$help[] = Indent::_(7) . "unset(\$helps[\$nr]);";
		$help[] = Indent::_(7) . "continue;";
		$help[] = Indent::_(6) . "}";
		$help[] = Indent::_(5) . "}";
		$help[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
			. " set the return type";
		$help[] = Indent::_(5) . "switch (\$help->type)";
		$help[] = Indent::_(5) . "{";
		$help[] = Indent::_(6) . "//" . Line::_(__Line__, __Class__)
			. " set joomla article";
		$help[] = Indent::_(6) . "case 1:";
		$help[] = Indent::_(7)
			. "return self::loadArticleLink(\$help->article);";
		$help[] = Indent::_(7) . "break;";
		$help[] = Indent::_(6) . "//" . Line::_(__Line__, __Class__)
			. " set help text";
		$help[] = Indent::_(6) . "case 2:";
		$help[] = Indent::_(7) . "return self::loadHelpTextLink(\$help->id);";
		$help[] = Indent::_(7) . "break;";
		$help[] = Indent::_(6) . "//" . Line::_(__Line__, __Class__) . " set Link";
		$help[] = Indent::_(6) . "case 3:";
		$help[] = Indent::_(7) . "return \$help->url;";
		$help[] = Indent::_(7) . "break;";
		$help[] = Indent::_(5) . "}";
		$help[] = Indent::_(4) . "}";
		$help[] = Indent::_(3) . "}";
		$help[] = Indent::_(2) . "}";
		$help[] = Indent::_(2) . "return false;";
		$help[] = Indent::_(1) . "}";
		$help[] = PHP_EOL . Indent::_(1) . "/**";
		$help[] = Indent::_(1) . " *	Get the Article Link.";
		$help[] = Indent::_(1) . " **/";
		$help[] = Indent::_(1)
			. "protected static function loadArticleLink(\$id)";
		$help[] = Indent::_(1) . "{";
		$help[] = Indent::_(2)
			. "return Uri::root() . 'index.php?option=com_content&view=article&id='.\$id.'&tmpl=component&layout=modal';";
		$help[] = Indent::_(1) . "}";
		$help[] = PHP_EOL . Indent::_(1) . "/**";
		$help[] = Indent::_(1) . " *	Get the Help Text Link.";
		$help[] = Indent::_(1) . " **/";
		$help[] = Indent::_(1)
			. "protected static function loadHelpTextLink(\$id)";
		$help[] = Indent::_(1) . "{";
		$help[] = Indent::_(2) . "\$token = Session::getFormToken();";
		$help[] = Indent::_(2) . "return 'index.php?option=com_"
			. CFactory::_('Config')->component_code_name
			. "&task=help.getText&id=' . (int) \$id . '&' . \$token . '=1';";
		$help[] = Indent::_(1) . "}";

		// return the help methods
		return implode(PHP_EOL, $help);
	}

	public function setHelperExelMethods()
	{
		if (CFactory::_('Config')->get('add_eximport', false))
		{
			// we use the company name set in the GUI
			$company_name = CFactory::_('Compiler.Builder.Content.One')->get('COMPANYNAME');
			// start building the xml function
			$exel   = [];
			$exel[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$exel[] = Indent::_(1) . "* Prepares the xml document";
			$exel[] = Indent::_(1) . "*/";
			$exel[] = Indent::_(1)
				. "public static function xls(\$rows, \$fileName = null, \$title = null, \$subjectTab = null, \$creator = '$company_name', \$description = null, \$category = null,\$keywords = null, \$modified = null)";
			$exel[] = Indent::_(1) . "{";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set the user";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$exel[] = Indent::_(2) . "\$user = Factory::getUser();";
			}
			else
			{
				$help[] = Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";
			}
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set fileName if not set";
			$exel[] = Indent::_(2) . "if (!\$fileName)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3)
				. "\$fileName = 'exported_'.Factory::getDate()->format('jS_F_Y');";
			$exel[] = Indent::_(2) . "}";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set modified if not set";
			$exel[] = Indent::_(2) . "if (!\$modified)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3) . "\$modified = \$user->name;";
			$exel[] = Indent::_(2) . "}";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set title if not set";
			$exel[] = Indent::_(2) . "if (!\$title)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3) . "\$title = 'Book1';";
			$exel[] = Indent::_(2) . "}";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set tab name if not set";
			$exel[] = Indent::_(2) . "if (!\$subjectTab)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3) . "\$subjectTab = 'Sheet1';";
			$exel[] = Indent::_(2) . "}";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " make sure we have the composer classes loaded";
			$exel[] = Indent::_(2)
				. "self::composerAutoload('phpspreadsheet');";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Create new Spreadsheet object";
			$exel[] = Indent::_(2) . "\$spreadsheet = new Spreadsheet();";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Set document properties";
			$exel[] = Indent::_(2) . "\$spreadsheet->getProperties()";
			$exel[] = Indent::_(3) . "->setCreator(\$creator)";
			$exel[] = Indent::_(3) . "->setCompany('$company_name')";
			$exel[] = Indent::_(3) . "->setLastModifiedBy(\$modified)";
			$exel[] = Indent::_(3) . "->setTitle(\$title)";
			$exel[] = Indent::_(3) . "->setSubject(\$subjectTab);";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " The file type";
			$exel[] = Indent::_(2) . "\$file_type = 'Xls';";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set description";
			$exel[] = Indent::_(2) . "if (\$description)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3)
				. "\$spreadsheet->getProperties()->setDescription(\$description);";
			$exel[] = Indent::_(2) . "}";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set keywords";
			$exel[] = Indent::_(2) . "if (\$keywords)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3)
				. "\$spreadsheet->getProperties()->setKeywords(\$keywords);";
			$exel[] = Indent::_(2) . "}";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set category";
			$exel[] = Indent::_(2) . "if (\$category)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3)
				. "\$spreadsheet->getProperties()->setCategory(\$category);";
			$exel[] = Indent::_(2) . "}";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Some styles";
			$exel[] = Indent::_(2) . "\$headerStyles = array(";
			$exel[] = Indent::_(3) . "'font'  => array(";
			$exel[] = Indent::_(4) . "'bold'  => true,";
			$exel[] = Indent::_(4) . "'color' => array('rgb' => '1171A3'),";
			$exel[] = Indent::_(4) . "'size'  => 12,";
			$exel[] = Indent::_(4) . "'name'  => 'Verdana'";
			$exel[] = Indent::_(2) . "));";
			$exel[] = Indent::_(2) . "\$sideStyles = array(";
			$exel[] = Indent::_(3) . "'font'  => array(";
			$exel[] = Indent::_(4) . "'bold'  => true,";
			$exel[] = Indent::_(4) . "'color' => array('rgb' => '444444'),";
			$exel[] = Indent::_(4) . "'size'  => 11,";
			$exel[] = Indent::_(4) . "'name'  => 'Verdana'";
			$exel[] = Indent::_(2) . "));";
			$exel[] = Indent::_(2) . "\$normalStyles = array(";
			$exel[] = Indent::_(3) . "'font'  => array(";
			$exel[] = Indent::_(4) . "'color' => array('rgb' => '444444'),";
			$exel[] = Indent::_(4) . "'size'  => 11,";
			$exel[] = Indent::_(4) . "'name'  => 'Verdana'";
			$exel[] = Indent::_(2) . "));";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Add some data";
			$exel[] = Indent::_(2)
				. "if ((\$size = Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$rows)) !== false)";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3) . "\$i = 1;";
			$exel[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Based on data size we adapt the behaviour.";
			$exel[] = Indent::_(3) . "\$xls_mode = 1;";
			$exel[] = Indent::_(3) . "if (\$size > 3000)";
			$exel[] = Indent::_(3) . "{";
			$exel[] = Indent::_(4) . "\$xls_mode = 3;";
			$exel[] = Indent::_(4) . "\$file_type = 'Csv';";
			$exel[] = Indent::_(3) . "}";
			$exel[] = Indent::_(3) . "elseif (\$size > 2000)";
			$exel[] = Indent::_(3) . "{";
			$exel[] = Indent::_(4) . "\$xls_mode = 2;";
			$exel[] = Indent::_(3) . "}";
			$exel[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Set active sheet and get it.";
			$exel[] = Indent::_(3)
				. "\$active_sheet = \$spreadsheet->setActiveSheetIndex(0);";
			$exel[] = Indent::_(3) . "foreach (\$rows as \$array)";
			$exel[] = Indent::_(3) . "{";
			$exel[] = Indent::_(4) . "\$a = 'A';";
			$exel[] = Indent::_(4) . "foreach (\$array as \$value)";
			$exel[] = Indent::_(4) . "{";
			$exel[] = Indent::_(5)
				. "\$active_sheet->setCellValue(\$a.\$i, \$value);";
			$exel[] = Indent::_(5) . "if (\$xls_mode != 3)";
			$exel[] = Indent::_(5) . "{";
			$exel[] = Indent::_(6) . "if (\$i == 1)";
			$exel[] = Indent::_(6) . "{";
			$exel[] = Indent::_(7)
				. "\$active_sheet->getColumnDimension(\$a)->setAutoSize(true);";
			$exel[] = Indent::_(7)
				. "\$active_sheet->getStyle(\$a.\$i)->applyFromArray(\$headerStyles);";
			$exel[] = Indent::_(7)
				. "\$active_sheet->getStyle(\$a.\$i)->getAlignment()->setHorizontal(PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);";
			$exel[] = Indent::_(6) . "}";
			$exel[] = Indent::_(6) . "elseif (\$a === 'A')";
			$exel[] = Indent::_(6) . "{";
			$exel[] = Indent::_(7)
				. "\$active_sheet->getStyle(\$a.\$i)->applyFromArray(\$sideStyles);";
			$exel[] = Indent::_(6) . "}";
			$exel[] = Indent::_(6) . "elseif (\$xls_mode == 1)";
			$exel[] = Indent::_(6) . "{";
			$exel[] = Indent::_(7)
				. "\$active_sheet->getStyle(\$a.\$i)->applyFromArray(\$normalStyles);";
			$exel[] = Indent::_(6) . "}";
			$exel[] = Indent::_(5) . "}";
			$exel[] = Indent::_(5) . "\$a++;";
			$exel[] = Indent::_(4) . "}";
			$exel[] = Indent::_(4) . "\$i++;";
			$exel[] = Indent::_(3) . "}";
			$exel[] = Indent::_(2) . "}";
			$exel[] = Indent::_(2) . "else";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3) . "return false;";
			$exel[] = Indent::_(2) . "}";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Rename worksheet";
			$exel[] = Indent::_(2)
				. "\$spreadsheet->getActiveSheet()->setTitle(\$subjectTab);";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Set active sheet index to the first sheet, so Excel opens this as the first sheet";
			$exel[] = Indent::_(2) . "\$spreadsheet->setActiveSheetIndex(0);";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Redirect output to a client's web browser (Excel5)";
			$exel[] = Indent::_(2)
				. "header('Content-Type: application/vnd.ms-excel');";
			$exel[] = Indent::_(2)
				. "header('Content-Disposition: attachment;filename=\"' . \$fileName . '.' . strtolower(\$file_type) .'\"');";
			$exel[] = Indent::_(2) . "header('Cache-Control: max-age=0');";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " If you're serving to IE 9, then the following may be needed";
			$exel[] = Indent::_(2) . "header('Cache-Control: max-age=1');";
			$exel[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " If you're serving to IE over SSL, then the following may be needed";
			$exel[] = Indent::_(2)
				. "header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); //"
				. Line::_(__Line__, __Class__) . " Date in the past";
			$exel[] = Indent::_(2)
				. "header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); //"
				. Line::_(__Line__, __Class__) . " always modified";
			$exel[] = Indent::_(2)
				. "header ('Cache-Control: cache, must-revalidate'); //"
				. Line::_(__Line__, __Class__) . " HTTP/1.1";
			$exel[] = Indent::_(2) . "header ('Pragma: public'); //"
				. Line::_(__Line__, __Class__) . " HTTP/1.0";
			$exel[] = PHP_EOL . Indent::_(2)
				. "\$writer = IOFactory::createWriter(\$spreadsheet, \$file_type);";
			$exel[] = Indent::_(2) . "\$writer->save('php://output');";
			$exel[] = Indent::_(2) . "jexit();";
			$exel[] = Indent::_(1) . "}";
			$exel[] = PHP_EOL . Indent::_(1) . "/**";
			$exel[] = Indent::_(1) . "* Get CSV Headers";
			$exel[] = Indent::_(1) . "*/";
			$exel[] = Indent::_(1)
				. "public static function getFileHeaders(\$dataType)";
			$exel[] = Indent::_(1) . "{";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " make sure we have the composer classes loaded";
			$exel[] = Indent::_(2)
				. "self::composerAutoload('phpspreadsheet');";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get session object";
			$exel[] = Indent::_(2) . "\$session = Factory::getSession();";
			$exel[] = Indent::_(2)
				. "\$package = \$session->get('package', null);";
			$exel[] = Indent::_(2)
				. "\$package = json_decode(\$package, true);";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set the headers";
			$exel[] = Indent::_(2) . "if(isset(\$package['dir']))";
			$exel[] = Indent::_(2) . "{";
			$exel[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " only load first three rows";
			$exel[] = Indent::_(3)
				. "\$chunkFilter = new PhpOffice\PhpSpreadsheet\Reader\chunkReadFilter(2,1);";
			$exel[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " identify the file type";
			$exel[] = Indent::_(3)
				. "\$inputFileType = IOFactory::identify(\$package['dir']);";
			$exel[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " create the reader for this file type";
			$exel[] = Indent::_(3)
				. "\$excelReader = IOFactory::createReader(\$inputFileType);";
			$exel[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " load the limiting filter";
			$exel[] = Indent::_(3)
				. "\$excelReader->setReadFilter(\$chunkFilter);";
			$exel[] = Indent::_(3) . "\$excelReader->setReadDataOnly(true);";
			$exel[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " load the rows (only first three)";
			$exel[] = Indent::_(3)
				. "\$excelObj = \$excelReader->load(\$package['dir']);";
			$exel[] = Indent::_(3) . "\$headers = [];";
			$exel[] = Indent::_(3)
				. "foreach (\$excelObj->getActiveSheet()->getRowIterator() as \$row)";
			$exel[] = Indent::_(3) . "{";
			$exel[] = Indent::_(4) . "if(\$row->getRowIndex() == 1)";
			$exel[] = Indent::_(4) . "{";
			$exel[] = Indent::_(5)
				. "\$cellIterator = \$row->getCellIterator();";
			$exel[] = Indent::_(5)
				. "\$cellIterator->setIterateOnlyExistingCells(false);";
			$exel[] = Indent::_(5) . "foreach (\$cellIterator as \$cell)";
			$exel[] = Indent::_(5) . "{";
			$exel[] = Indent::_(6) . "if (!is_null(\$cell))";
			$exel[] = Indent::_(6) . "{";
			$exel[] = Indent::_(7)
				. "\$headers[\$cell->getColumn()] = \$cell->getValue();";
			$exel[] = Indent::_(6) . "}";
			$exel[] = Indent::_(5) . "}";
			$exel[] = Indent::_(5) . "\$excelObj->disconnectWorksheets();";
			$exel[] = Indent::_(5) . "unset(\$excelObj);";
			$exel[] = Indent::_(5) . "break;";
			$exel[] = Indent::_(4) . "}";
			$exel[] = Indent::_(3) . "}";
			$exel[] = Indent::_(3) . "return \$headers;";
			$exel[] = Indent::_(2) . "}";
			$exel[] = Indent::_(2) . "return false;";
			$exel[] = Indent::_(1) . "}";
			$exel[] = PHP_EOL . Indent::_(1) . "/**";
			$exel[] = Indent::_(1)
				. "* Load the Composer Vendor phpspreadsheet";
			$exel[] = Indent::_(1) . "*/";
			$exel[] = Indent::_(1)
				. "protected static function composephpspreadsheet()";
			$exel[] = Indent::_(1) . "{";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " load the autoloader for phpspreadsheet";
			$exel[] = Indent::_(2)
				. "require_once JPATH_SITE . '/libraries/phpspreadsheet/vendor/autoload.php';";
			$exel[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " do not load again";
			$exel[] = Indent::_(2)
				. "self::\$composer['phpspreadsheet'] = true;";
			$exel[] = PHP_EOL . Indent::_(2) . "return  true;";
			$exel[] = Indent::_(1) . "}";

			// return the help methods
			return implode(PHP_EOL, $exel);
		}

		return '';
	}

	/**
	 * Generates the method definition for creating or updating a user based on the provided parameters.
	 *
	 * This method returns a string representation of a PHP function that includes various 
	 * steps for handling user creation and updates, depending on the mode (site registration or admin registration).
	 * 
	 * @param   int   $add    Determines whether to generate the user creation method or not.
	 *                                      If true, the method will be generated and returned as a string.
	 *
	 * @return  string  The generated method code as a string if $add is true. 
	 *                              Returns an empty string if $add is false.
	 *
	 * @since  3.0
	 * @deprecated 5.0.3 Use CFactory::_('Architecture.ComHelperClass.CreateUser')->get($add);
	 */
	public function setCreateUserHelperMethod($add): string
	{
		return CFactory::_('Architecture.ComHelperClass.CreateUser')->get($add);
	}

	public function setAdminViewMenu(&$nameSingleCode, &$view)
	{
		$xml = '';
		// build the file target values
		$target = array('site' => $nameSingleCode);
		// build the edit.xml file
		if (CFactory::_('Utilities.Structure')->build($target, 'admin_menu'))
		{
			// set the lang
			$lang = StringHelper::safe(
				'com_' . CFactory::_('Config')->component_code_name . '_menu_'
				. $nameSingleCode,
				'U'
			);
			CFactory::_('Language')->set(
				'adminsys', $lang . '_TITLE',
				'Create ' . $view['settings']->name_single
			);
			CFactory::_('Language')->set(
				'adminsys', $lang . '_OPTION',
				'Create ' . $view['settings']->name_single
			);
			CFactory::_('Language')->set(
				'adminsys', $lang . '_DESC',
				$view['settings']->short_description
			);
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= PHP_EOL . '<metadata>';
			$xml .= PHP_EOL . Indent::_(1) . '<layout title="' . $lang
				. '_TITLE" option="' . $lang . '_OPTION">';
			$xml .= PHP_EOL . Indent::_(2) . '<message>';
			$xml .= PHP_EOL . Indent::_(3) . '<![CDATA[' . $lang . '_DESC]]>';
			$xml .= PHP_EOL . Indent::_(2) . '</message>';
			$xml .= PHP_EOL . Indent::_(1) . '</layout>';
			$xml .= PHP_EOL . '</metadata>';
		}
		else
		{
			$this->app->enqueueMessage(
				Text::sprintf(
					'<hr /><p>Site menu for <b>%s</b> was not build.</p>',
					$nameSingleCode
				), 'Warning'
			);
		}

		return $xml;
	}

	public function setCustomViewMenu(&$view)
	{
		$target_area = 'Administrator';
		if (CFactory::_('Config')->build_target === 'site')
		{
			$target_area = 'Site';
		}
		$xml = '';
		// build the file target values
		$target = array('site' => $view['settings']->code);
		// build the default.xml file
		if (CFactory::_('Utilities.Structure')->build($target, 'menu'))
		{
			// set the lang
			$lang = StringHelper::safe(
				'com_' . CFactory::_('Config')->component_code_name . '_menu_'
				. $view['settings']->code, 'U'
			);
			CFactory::_('Language')->set(
				'adminsys', $lang . '_TITLE', $view['settings']->name
			);
			CFactory::_('Language')->set(
				'adminsys', $lang . '_OPTION', $view['settings']->name
			);
			CFactory::_('Language')->set(
				'adminsys', $lang . '_DESC', $view['settings']->description
			);
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= PHP_EOL . '<metadata>';
			$xml .= PHP_EOL . Indent::_(1) . '<layout title="' . $lang
				. '_TITLE" option="' . $lang . '_OPTION">';
			$xml .= PHP_EOL . Indent::_(2) . '<message>';
			$xml .= PHP_EOL . Indent::_(3) . '<![CDATA[' . $lang . '_DESC]]>';
			$xml .= PHP_EOL . Indent::_(2) . '</message>';
			$xml .= PHP_EOL . Indent::_(1) . '</layout>';
			if (CFactory::_('Compiler.Builder.Request')->isArray("id.{$view['settings']->code}")
				|| CFactory::_('Compiler.Builder.Request')->isArray("catid.{$view['settings']->code}"))
			{
				$xml .= PHP_EOL . Indent::_(1) . '<!--' . Line::_(
						__LINE__,__CLASS__
					)
					. ' Add fields to the request variables for the layout. -->';
				$xml .= PHP_EOL . Indent::_(1) . '<fields name="request">';
				$xml .= PHP_EOL . Indent::_(2) . '<fieldset name="request"';

				if (CFactory::_('Config')->get('joomla_version', 3) == 3)
				{
					$xml .= PHP_EOL . Indent::_(3)
						. 'addrulepath="/administrator/components/com_'
						. CFactory::_('Config')->component_code_name . '/models/rules"';
					$xml .= PHP_EOL . Indent::_(3)
						. 'addfieldpath="/administrator/components/com_'
						. CFactory::_('Config')->component_code_name . '/models/fields">';
				}
				else
				{
					$xml .= PHP_EOL . Indent::_(3)
						. 'addruleprefix="' . CFactory::_('Config')->namespace_prefix
						. '\Component\\' . CFactory::_('Compiler.Builder.Content.One')->get('ComponentNamespace')
						. '\\'. $target_area . '\Rule"';
					$xml .= PHP_EOL . Indent::_(3)
						. 'addfieldprefix="' . CFactory::_('Config')->namespace_prefix
						. '\Component\\' . CFactory::_('Compiler.Builder.Content.One')->get('ComponentNamespace')
						. '\\'. $target_area . '\Field">';
				}

				if (CFactory::_('Compiler.Builder.Request')->isArray("id.{$view['settings']->code}"))
				{
					foreach (CFactory::_('Compiler.Builder.Request')->
						get("id.{$view['settings']->code}") as $requestFieldXML)
					{
						$xml .= PHP_EOL . Indent::_(3) . $requestFieldXML;
					}
				}
				if (CFactory::_('Compiler.Builder.Request')->isArray("catid.{$view['settings']->code}"))
				{
					foreach (CFactory::_('Compiler.Builder.Request')->
						get("catid.{$view['settings']->code}") as $requestFieldXML)
					{
						$xml .= PHP_EOL . Indent::_(3) . $requestFieldXML;
					}
				}
				$xml .= PHP_EOL . Indent::_(2) . '</fieldset>';
				$xml .= PHP_EOL . Indent::_(1) . '</fields>';
			}
			if (CFactory::_('Compiler.Builder.Frontend.Params')->exists($view['settings']->name))
			{
				// first we must setup the fields for the page use
				$params = $this->setupFrontendParamFields(
					CFactory::_('Compiler.Builder.Frontend.Params')->get($view['settings']->name),
					$view['settings']->code
				);
				// now load the fields
				if (ArrayHelper::check($params))
				{
					$xml .= PHP_EOL . Indent::_(1) . '<!--' . Line::_(
							__LINE__,__CLASS__
						) . ' Adding page parameters -->';
					$xml .= PHP_EOL . Indent::_(1) . '<fields name="params">';
					$xml .= PHP_EOL . Indent::_(2)
						. '<fieldset name="basic" label="COM_'
						. CFactory::_('Compiler.Builder.Content.One')->get('COMPONENT') . '"';
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						$xml .= PHP_EOL . Indent::_(3)
							. 'addrulepath="/administrator/components/com_'
							. CFactory::_('Config')->component_code_name . '/models/rules"';
						$xml .= PHP_EOL . Indent::_(3)
							. 'addfieldpath="/administrator/components/com_'
							. CFactory::_('Config')->component_code_name . '/models/fields">';
					}
					else
					{
						$xml .= PHP_EOL . Indent::_(3)
							. 'addruleprefix="' . CFactory::_('Config')->namespace_prefix
							. '\Component\\' . CFactory::_('Compiler.Builder.Content.One')->get('ComponentNamespace')
							. '\\'. $target_area . '\Rule"';
						$xml .= PHP_EOL . Indent::_(3)
							. 'addfieldprefix="' . CFactory::_('Config')->namespace_prefix
							. '\Component\\' . CFactory::_('Compiler.Builder.Content.One')->get('ComponentNamespace')
							. '\\'. $target_area . '\Field">';
					}
					$xml .= implode(Indent::_(3), $params);
					$xml .= PHP_EOL . Indent::_(2) . '</fieldset>';
					$xml .= PHP_EOL . Indent::_(1) . '</fields>';
				}
			}
			$xml .= PHP_EOL . '</metadata>';
		}
		else
		{
			$this->app->enqueueMessage(
				Text::sprintf(
					'<hr /><p>Site menu for <b>%s</b> was not build.</p>',
					$view['settings']->code
				), 'Warning'
			);
		}

		return $xml;
	}

	public function setupFrontendParamFields($params, $view)
	{
		$keep       = [];
		$menuSetter = $view . '_menu';
		foreach ($params as $field)
		{
			// some switch to see if it should be added to front end params
			$target = GetHelper::between(
				$field, 'display="', '"'
			);
			if (!StringHelper::check($target)
				|| $target === 'menu')
			{
				$field = str_replace('display="menu"', '', (string) $field);
				// we update fields that have options if not only added to menu
				if ($target !== 'menu'
					&& strpos($field, 'Option Set. -->') !== false
					&& strpos($field, $menuSetter) === false
					&& !StringHelper::check($target))
				{
					// we add the global option
					$field = str_replace(
						'Option Set. -->',
						Line::_(__Line__, __Class__) . ' Global & Option Set. -->'
						. PHP_EOL . Indent::_(3) . '<option value="">' . PHP_EOL
						. Indent::_(4) . 'JGLOBAL_USE_GLOBAL</option>', $field
					);
					// update the default to be global
					$field = preg_replace(
						'/default=".+"/', 'default=""', $field
					);
					// update the default to be filter
					$field = preg_replace(
						'/filter=".+"/', 'filter="string"', $field
					);
					// update required
					$field = str_replace(
						'required="true"', 'required="false"', $field
					);
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

	public function setCustomViewQuery(&$gets, &$code, $tab = '', $type = 'main'
	)
	{
		$query = '';
		if (ArrayHelper::check($gets))
		{
			$mainAsArray = [];
			$check       = 'zzz';
			foreach ($gets as $nr => $the_get)
			{
				// to insure that there be no double entries of a call
				$checker = md5(serialize($the_get) . $code);
				if (!isset($this->customViewQueryChecker[CFactory::_('Config')->build_target])
					|| !isset($checker, $this->customViewQueryChecker[CFactory::_('Config')->build_target][$checker]))
				{
					// load this unuiqe key
					$this->customViewQueryChecker[CFactory::_('Config')->build_target][$checker]
						= true;
					if (isset($the_get['selection']['type'])
						&& StringHelper::check(
							$the_get['selection']['type']
						))
					{
						$getItem = PHP_EOL . PHP_EOL . Indent::_(1) . $tab
							. Indent::_(1) . "//" . Line::_(__Line__, __Class__)
							. " Get from " . $the_get['selection']['table']
							. " as " . $the_get['as'];
						// set the selection
						$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. $the_get['selection']['select'];
					}
					else
					{
						$getItem = PHP_EOL . PHP_EOL . Indent::_(1) . $tab
							. Indent::_(1) . "//" . Line::_(__Line__, __Class__)
							. " Get data";
						// set the selection
						$getItem .= PHP_EOL . CFactory::_('Placeholder')->update_(
								$the_get['selection']['select']
							);
					}
					// load the from selection
					if (($nr == 0
							&& (!isset($the_get['join_field'])
								|| !StringHelper::check(
									$the_get['join_field']
								))
							&& (isset($the_get['selection']['type'])
								&& StringHelper::check(
									$the_get['selection']['type']
								)))
						|| ($type === 'custom'
							&& (isset($the_get['selection']['type'])
								&& StringHelper::check(
									$the_get['selection']['type']
								))))
					{
						$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. '$query->from(' . $the_get['selection']['from']
							. ');';
					}
					elseif (isset($the_get['join_field'])
						&& StringHelper::check(
							$the_get['join_field']
						)
						&& isset($the_get['selection']['type'])
						&& StringHelper::check(
							$the_get['selection']['type']
						))
					{
						$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$query->join('" . $the_get['type'];
						$getItem .= "', (" . $the_get['selection']['from'];
						$getItem .= ") . ' ON (' . \$db->quoteName('"
							. $the_get['on_field'];
						$getItem .= "') . ' " . $the_get['operator'];
						$getItem .= " ' . \$db->quoteName('"
							. $the_get['join_field'] . "') . ')');";

						$check = current(explode(".", (string) $the_get['on_field']));
					}

					// set the method defaults
					if (($default = $this->setCustomViewMethodDefaults($the_get, $code)) !== false)
					{
						if (($join_field_ = CFactory::_('Compiler.Builder.Site.Dynamic.Get')->get(CFactory::_('Config')->build_target .
								'.' . $default['code'] . '.' . $default['as'] . '.' . $default['join_field'])) !== null
							&& !in_array($check, $mainAsArray))
						{
							// load to other query
							CFactory::_('Compiler.Builder.Other.Query')->add(
								CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $join_field_ . '.' . $default['valueName'],
								$getItem,
								false
							);
						}
						else
						{
							$mainAsArray[] = $default['as'];
							$query         .= $getItem;
						}
					}
				}
			}
		}

		return $query;
	}

	public function setCustomViewFieldDecodeFilter(&$get, &$filters, $string,
	                                               $removeString, $code, $tab
	)
	{
		$filter = '';
		// check if filter is set for this field
		if (ArrayHelper::check($filters))
		{
			foreach ($filters as $field => $ter)
			{
				// build load counter
				$key = md5(
					'setCustomViewFieldDecodeFilter' . $code . $get['key']
					. $string . $ter['table_key']
				);
				// check if we should load this again
				if (strpos((string) $get['selection']['select'], (string) $ter['table_key'])
					!== false
					&& !isset($this->loadTracker[$key]))
				{
					// set the key
					$this->loadTracker[$key] = $key;
					$as                      = '';
					$felt                    = '';
					list($as, $felt) = array_map(
						'trim', explode('.', (string) $ter['table_key'])
					);
					if ($get['as'] == $as)
					{
						switch ($ter['filter_type'])
						{
							case 4:
								// COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
								$filter .= PHP_EOL . PHP_EOL . Indent::_(1)
									. $tab . Indent::_(1) . "//"
									. Line::_(__Line__, __Class__) . " filter "
									. $as . " based on user groups";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1)
									. "\$remove = (count(array_intersect((array) \$this->groups, (array) "
									. $string . "->" . $field
									. "))) ? false : true;";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "if (\$remove)";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "{";
								if ($removeString == $string)
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Remove " . $string
										. " if user not in groups";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . $string . " = null;";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "return false;";
								}
								else
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Unset " . $string
										. " if user not in groups";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "unset("
										. $removeString . ");";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "continue;";
								}
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "}";
								break;
							case 9:
								// COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE

								$filter .= PHP_EOL . PHP_EOL . Indent::_(1)
									. $tab . Indent::_(1) . "if ("
									. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(" . $string . "->"
									. $field . "))";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "{";

								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(2) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " do your thing here";

								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "}";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "else";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "{";

								if ($removeString == $string)
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Remove " . $string
										. " if not array.";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . $string . " = null;";
								}
								else
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Unset " . $string
										. " if not array.";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "unset("
										. $removeString . ");";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "continue;";
								}

								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "}";
								break;
							case 10:
								// COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
								$filter .= PHP_EOL . PHP_EOL . Indent::_(1)
									. $tab . Indent::_(1) . "//"
									. Line::_(__Line__, __Class__) . " filter "
									. $as . " based on repeatable value";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "if ("
									. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(" . $string . "->"
									. $field . "))";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "{";

								$filter .= PHP_EOL . Indent::_(2) . $tab
									. Indent::_(1) . "\$array = json_decode("
									. $string . "->" . $field . ",true);";
								$filter .= PHP_EOL . Indent::_(2) . $tab
									. Indent::_(1) . "if ("
									. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$array))";
								$filter .= PHP_EOL . Indent::_(2) . $tab
									. Indent::_(1) . "{";

								$filter .= PHP_EOL . Indent::_(2) . $tab
									. Indent::_(2) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " do your thing here";

								$filter .= PHP_EOL . Indent::_(2) . $tab
									. Indent::_(1) . "}";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(2) . "else";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(2) . "{";

								if ($removeString == $string)
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(3) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Remove " . $string
										. " if not array.";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(3) . $string . " = null;";
								}
								else
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(3) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Unset " . $string
										. " if not array.";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(3) . "unset("
										. $removeString . ");";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(3) . "continue;";
								}

								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(2) . "}";

								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "}";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "else";
								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "{";

								if ($removeString == $string)
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Remove " . $string
										. " if not string.";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . $string . " = null;";
								}
								else
								{
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "//" . Line::_(
											__LINE__,__CLASS__
										) . " Unset " . $string
										. " if not string.";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "unset("
										. $removeString . ");";
									$filter .= PHP_EOL . Indent::_(1) . $tab
										. Indent::_(2) . "continue;";
								}

								$filter .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(1) . "}";
								break;
						}
					}
				}
			}
		}

		return $filter;
	}

	public function setCustomViewFieldDecode(&$get, $checker, $string, $code,
	                                         $tab = ''
	)
	{
		$fieldDecode = '';
		foreach ($checker as $field => $array)
		{
			// build load counter
			$key = md5(
				'setCustomViewFieldDecode' . $code . $get['key'] . $string
				. $field
			);
			// check if we should load this again
			if (strpos((string) $get['selection']['select'], (string) $field) !== false
				&& !isset($this->loadTracker[$key])
				&& ArrayHelper::check($array['decode']))
			{
				// set the key
				$this->loadTracker[$key] = $key;
				// insure it is unique
				$array['decode'] = (array) array_unique(
					array_reverse((array) $array['decode'])
				);
				// now loop the array
				foreach ($array['decode'] as $decode)
				{
					$if      = '';
					$decoder = '';
					if ('json' === $decode)
					{
						$if = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "if (isset(" . $string . "->" . $field . ") && "
							. "Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check("
							. $string . "->" . $field . "))" . PHP_EOL
							. Indent::_(1) . $tab . Indent::_(1) . "{";
						// json_decode
						$decoder = $string . "->" . $field . " = json_decode("
							. $string . "->" . $field . ", true);";
					}
					elseif ('base64' === $decode)
					{
						$if = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "if (!empty(" . $string . "->" . $field . ") && "
							. $string . "->" . $field
							. " === base64_encode(base64_decode(" . $string
							. "->" . $field . ")))" . PHP_EOL . Indent::_(1)
							. $tab . Indent::_(1) . "{";
						// base64_decode
						$decoder = $string . "->" . $field . " = base64_decode("
							. $string . "->" . $field . ");";
					}
					elseif (strpos((string) $decode, '_encryption') !== false
						|| 'expert_mode' === $decode)
					{
						foreach (CFactory::_('Config')->cryption_types as $cryptionType)
						{
							if ($cryptionType . '_encryption' === $decode
								|| $cryptionType . '_mode' === $decode)
							{
								if ('expert' !== $cryptionType)
								{
									$if = PHP_EOL . Indent::_(1) . $tab
										. Indent::_(1) . "if (!empty(" . $string
										. "->" . $field . ") && \$"
										. $cryptionType . "key && !is_numeric("
										. $string . "->" . $field . ") && "
										. $string . "->" . $field
										. " === base64_encode(base64_decode("
										. $string . "->" . $field . ", true)))"
										. PHP_EOL . Indent::_(1) . $tab
										. Indent::_(1) . "{";
									// set decryption
									$decoder = $string . "->" . $field
										. " = rtrim(\$" . $cryptionType
										. "->decryptString(" . $string . "->"
										. $field . "), " . '"\0"' . ");";
								}
								elseif (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->
									exists($array['admin_view'] . '.' . $field))
								{
									$_placeholder_for_field
										= array('[[[field]]]' => $string
										. "->" . $field);
									$fieldDecode .= CFactory::_('Placeholder')->update(
										PHP_EOL . Indent::_(1) . $tab
										. Indent::_(1) . implode(
											PHP_EOL . Indent::_(1) . $tab
											. Indent::_(1),
											CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->get(
												$array['admin_view'] . '.' . $field . '.get', ['error'])
										), $_placeholder_for_field
									);
								}
								// activate site decryption
								CFactory::_('Compiler.Builder.Site.Decrypt')->set("{$cryptionType}.{$code}", true);
							}
						}
					}
					// check if we have found the details
					if (StringHelper::check($if))
					{
						// build decoder string
						$fieldDecode .= PHP_EOL . Indent::_(1) . $tab
							. Indent::_(1) . "//" . Line::_(__Line__, __Class__)
							. " Check if we can decode " . $field . $if
							. PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
							. "//" . Line::_(__Line__, __Class__) . " Decode "
							. $field;
					}
					if (StringHelper::check($decoder))
					{
						// build decoder string
						$fieldDecode .= PHP_EOL . Indent::_(1) . $tab
							. Indent::_(2) . $decoder . PHP_EOL . Indent::_(1)
							. $tab . Indent::_(1) . "}";
					}
				}
			}
		}

		return $fieldDecode;
	}

	public function setCustomViewFieldonContentPrepareChecker(&$get, $checker,
	                                                          $string, $code, $tab = ''
	)
	{
		$fieldPrepare = '';
		$runplugins   = false;
		// set component
		$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
		// set context
		$context = (isset($get['context'])) ? $get['context'] : $code;
		$context = 'com_' . CFactory::_('Config')->component_code_name . '.' . $context;
		// load parms builder only once
		$params = false;
		foreach ($checker as $field => $array)
		{
			// build load counter
			$key = md5(
				'setCustomViewFieldonContentPrepareChecker' . $code
				. $get['key'] . $string . $field
			);
			// check if we should load this again
			if (strpos((string) $get['selection']['select'], (string) $field) !== false
				&& !isset($this->loadTracker[$key]))
			{
				// set the key
				$this->loadTracker[$key] = $key;
				// build decoder string
				if (!$runplugins)
				{
					$runplugins = PHP_EOL . $tab . Indent::_(1) . "//"
						. Line::_(__Line__, __Class__)
						. " Load the JEvent Dispatcher";
					$runplugins .= PHP_EOL . $tab . Indent::_(1)
						. "PluginHelper::importPlugin('content');";
					$runplugins .= PHP_EOL . $tab . Indent::_(1)
						. '$this->_dispatcher = Factory::getApplication();';
				}
				if (!$params)
				{
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							1
						) . "//" . Line::_(__Line__, __Class__)
						. " Check if item has params, or pass whole item.";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							1
						) . "\$params = (isset(" . $string . "->params) && "
						. "Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check(" . $string
						. "->params)) ? json_decode(" . $string . "->params) : "
						. $string . ";";
					$params       = true;
				}
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "//" . Line::_(__Line__, __Class__)
					. " Make sure the content prepare plugins fire on "
					. $field;
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$_" . $field . " = new \stdClass();";
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$_" . $field . '->text =& ' . $string . '->' . $field
					. '; //' . Line::_(__Line__, __Class__)
					. ' value must be in text';
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "//" . Line::_(__Line__, __Class__)
					. " Since all values are now in text (Joomla Limitation), we also add the field name ("
					. $field . ") to context";
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. '$this->_dispatcher->triggerEvent("onContentPrepare", array(\''
					. $context . '.' . $field . '\', &$_' . $field
					. ', &$params, 0));';
			}
		}
		// load dispatcher
		if ($runplugins)
		{
			$this->JEventDispatcher = array(Placefix::_h('DISPATCHER') => $runplugins);
		}

		// return content prepare fix
		return $fieldPrepare;
	}

	public function setCustomViewFieldUikitChecker(&$get, $checker, $string,
	                                               $code, $tab = ''
	)
	{
		$fieldUikit = '';
		foreach ($checker as $field => $array)
		{
			// build load counter
			$key = md5(
				'setCustomViewFieldUikitChecker' . $code . $get['key'] . $string
				. $field
			);
			// check if we should load this again
			if (strpos((string) $get['selection']['select'], (string) $field) !== false
				&& !isset($this->loadTracker[$key]))
			{
				// set the key
				$this->loadTracker[$key] = $key;
				// only load for uikit version 2 (TODO) we may need to add another check here
				if (2 == CFactory::_('Config')->uikit || 1 == CFactory::_('Config')->uikit)
				{
					$fieldUikit .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "//" . Line::_(__Line__, __Class__) . " Checking if "
						. $field . " has uikit components that must be loaded.";
					$fieldUikit .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$this->uikitComp = "
						. CFactory::_('Compiler.Builder.Content.One')->get('Component') . "Helper::getUikitComp(" . $string . "->"
						. $field . ",\$this->uikitComp);";
				}
			}
		}

		// return UIKIT fix
		return $fieldUikit;
	}

	public function setCustomViewCustomJoin(&$gets, $string, $code, &$asBucket,
	                                        $tab = ''
	)
	{
		if (ArrayHelper::check($gets))
		{
			$customJoin = '';
			foreach ($gets as $get)
			{
				// set the value name $default
				if (($default = $this->setCustomViewMethodDefaults($get, $code))
					!== false)
				{
					if ($this->checkJoint($default, $get, $asBucket))
					{
						// build custom join string
						$otherJoin = PHP_EOL . Indent::_(1) . Placefix::_h("TAB")
							. Indent::_(1) . "//" . Line::_(__LINE__,__CLASS__)
							. " set " . $default['valueName'] . " to the "
							. Placefix::_h("STRING")  . " object.";
						$otherJoin .= PHP_EOL . Indent::_(1) . Placefix::_h("TAB")
							. Indent::_(1) . Placefix::_h("STRING") . "->"
							. $default['valueName'] . " = \$this->get"
							. $default['methodName'] . "(" . Placefix::_h("STRING")  . "->"
							. CFactory::_('Compiler.Builder.Get.As.Lookup')->
								get($get['key'] . '.' . $get['on_field'], 'Error')
							. ");";
						$join_field_ = CFactory::_('Compiler.Builder.Site.Dynamic.Get')->get(CFactory::_('Config')->build_target .
							'.' . $default['code'] . '.' . $default['as'] . '.' . $default['join_field'], 'ZZZ');
						// load to other join
						CFactory::_('Compiler.Builder.Other.Join')->add(
							CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $join_field_ . '.' . $default['valueName'],
							$otherJoin,
							false
						);
					}
					else
					{
						// build custom join string
						$customJoin .= PHP_EOL . Indent::_(1) . $tab
							. Indent::_(1) . "//" . Line::_(__Line__, __Class__)
							. " set " . $default['valueName'] . " to the "
							. $string . " object.";
						$customJoin .= PHP_EOL . Indent::_(1) . $tab
							. Indent::_(1) . $string . "->"
							. $default['valueName'] . " = \$this->get"
							. $default['methodName'] . "(" . $string . "->"
							. CFactory::_('Compiler.Builder.Get.As.Lookup')->
								get($get['key'] . '.' . $get['on_field'], 'Error')
							. ");";
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
		list($aJoin) = explode('.', (string) $get['on_field']);
		if (ArrayHelper::check($asBucket) && in_array($aJoin, $asBucket))
		{
			return false;
		}
		// default fallback
		elseif (CFactory::_('Compiler.Builder.Site.Dynamic.Get')->exists(
			CFactory::_('Config')->build_target . '.' . $default['code'] . '.' .
			$default['as'] . '.' . $default['join_field']
		))
		{
			return true;
		}

		return false;
	}

	public function setCustomViewFilter(&$filter, &$code, $tab = '')
	{
		$filters = '';
		if (ArrayHelper::check($filter))
		{
			foreach ($filter as $ter)
			{
				$as     = '';
				$field  = '';
				$string = '';
				if (strpos((string) $ter['table_key'], '.') !== false)
				{
					list($as, $field) = array_map(
						'trim', explode('.', (string) $ter['table_key'])
					);
				}
				$path = $code . '.' . $ter['key'] . '.' . $as . '.' . $field;
				switch ($ter['filter_type'])
				{
					case 1:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_ID
						$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$query->where('" . $ter['table_key'] . " "
							. $ter['operator'] . " ' . (int) \$pk);";
						break;
					case 2:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_USER
						$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$query->where('" . $ter['table_key'] . " "
							. $ter['operator'] . " ' . (int) \$this->userId);";
						break;
					case 3:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_ACCESS_LEVEL
						$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$query->where('" . $ter['table_key'] . " "
							. $ter['operator']
							. " (' . implode(',', \$this->levels) . ')');";
						break;
					case 4:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_USER_GROUPS
						$decodeChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->
							get('decode.' . $path);
						if (ArrayHelper::check($decodeChecker)
							|| $ter['state_key'] === 'array')
						{
							// set needed fields to filter after query
							CFactory::_('Compiler.Builder.Site.Field.Decode.Filter')->
								set(CFactory::_('Config')->build_target . '.' . $path, $ter);
						}
						else
						{
							$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(
									1
								) . "\$query->where('" . $ter['table_key'] . " "
								. $ter['operator']
								. " (' . implode(',', \$this->groups) . ')');";
						}
						break;
					case 5:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_CATEGORIES
						$string = PHP_EOL . Indent::_(2) . $tab . "//"
							. Line::_(__Line__, __Class__)
							. " (TODO) The dynamic category filter is not ready.";
						break;
					case 6:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_TAGS
						$string = PHP_EOL . Indent::_(2) . $tab . "//"
							. Line::_(__Line__, __Class__)
							. " (TODO) The dynamic tags filter is not ready.";
						break;
					case 7:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_DATE
						$string = PHP_EOL . Indent::_(2) . $tab . "//"
							. Line::_(__Line__, __Class__)
							. " (TODO) The dynamic date filter is not ready.";
						break;
					case 8:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_FUNCTIONVAR
						if ($ter['operator'] === 'IN'
							|| $ter['operator'] === 'NOT IN')
						{
							$string = PHP_EOL . Indent::_(2) . $tab . "//"
								. Line::_(__Line__, __Class__) . " Check if "
								. $ter['state_key']
								. " is an array with values.";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. "\$array = " . $ter['state_key'] . ";";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. "if (isset(\$array) && "
								. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$array))";
							$string .= PHP_EOL . Indent::_(2) . $tab . "{";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. Indent::_(1) . "\$query->where('"
								. $ter['table_key'] . " " . $ter['operator']
								. " (' . implode(',', \$array) . ')');";
							$string .= PHP_EOL . Indent::_(2) . $tab . "}";
							// check if empty is allowed
							if (!isset($ter['empty']) || !$ter['empty'])
							{
								$string .= PHP_EOL . Indent::_(2) . $tab
									. "else";
								$string .= PHP_EOL . Indent::_(2) . $tab . "{";
								$string .= PHP_EOL . Indent::_(2) . $tab
									. Indent::_(1) . "return false;";
								$string .= PHP_EOL . Indent::_(2) . $tab . "}";
							}
						}
						else
						{
							$string = PHP_EOL . Indent::_(2) . $tab . "//"
								. Line::_(__Line__, __Class__) . " Check if "
								. $ter['state_key']
								. " is a string or numeric value.";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. "\$checkValue = " . $ter['state_key'] . ";";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. "if (isset(\$checkValue) && "
								. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$checkValue))";
							$string .= PHP_EOL . Indent::_(2) . $tab . "{";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. Indent::_(1) . "\$query->where('"
								. $ter['table_key'] . " " . $ter['operator']
								. " ' . \$db->quote(\$checkValue));";
							$string .= PHP_EOL . Indent::_(2) . $tab . "}";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. "elseif (is_numeric(\$checkValue))";
							$string .= PHP_EOL . Indent::_(2) . $tab . "{";
							$string .= PHP_EOL . Indent::_(2) . $tab
								. Indent::_(1) . "\$query->where('"
								. $ter['table_key'] . " " . $ter['operator']
								. " ' . \$checkValue);";
							$string .= PHP_EOL . Indent::_(2) . $tab . "}";
							// check if empty is allowed
							if (!isset($ter['empty']) || !$ter['empty'])
							{
								$string .= PHP_EOL . Indent::_(2) . $tab
									. "else";
								$string .= PHP_EOL . Indent::_(2) . $tab . "{";
								$string .= PHP_EOL . Indent::_(2) . $tab
									. Indent::_(1) . "return false;";
								$string .= PHP_EOL . Indent::_(2) . $tab . "}";
							}
						}
						break;
					case 9:
					case 10:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_ARRAY_VALUE
						// COM_COMPONENTBUILDER_DYNAMIC_GET_REPEATABLE_VALUE
						$string = "";
						// set needed fields to filter after query
						CFactory::_('Compiler.Builder.Site.Field.Decode.Filter')->
							set(CFactory::_('Config')->build_target . '.' . $path, $ter);
						break;
					case 11:
						// COM_COMPONENTBUILDER_DYNAMIC_GET_OTHER
						if (strpos($as, '(') !== false)
						{
							// TODO (for now we only fix extra sql methods here)
							list($dump, $as) = array_map(
								'trim', explode('(', $as)
							);
							$field = trim(str_replace(')', '', $field));
						}
						$string = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$query->where('" . $ter['table_key'] . " "
							. $ter['operator'] . " " . $ter['state_key']
							. "');";
						break;
				}
				// only add if the filter is set
				if (StringHelper::check($string))
				{
					// sort where
					if ($as === 'a' || CFactory::_('Compiler.Builder.Site.Main.Get')->
						exists(CFactory::_('Config')->build_target . '.' . $code . '.' . $as))
					{
						$filters .= $string;
					}
					elseif ($as !== 'a')
					{
						CFactory::_('Compiler.Builder.Other.Filter')->
							set(CFactory::_('Config')->build_target . '.' . $code . '.' . $as . '.' . $field, $string);;
					}
				}
			}
		}

		return $filters;
	}

	public function setCustomViewGroup(&$group, &$code, $tab = '')
	{
		$grouping = '';
		if (ArrayHelper::check($group))
		{
			foreach ($group as $gr)
			{
				list($as, $field) = array_map(
					'trim', explode('.', (string) $gr['table_key'])
				);
				// set the string
				$string = "\$query->group('" . $gr['table_key'] . "');";
				// sort where
				if ($as === 'a' || CFactory::_('Compiler.Builder.Site.Main.Get')->
					exists(CFactory::_('Config')->build_target . '.' . $code . '.' . $as))
				{
					$grouping .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. $string;
				}
				else
				{
					CFactory::_('Compiler.Builder.Other.Group')->set(
						CFactory::_('Config')->build_target . '.' . $code . '.' . $as . '.' . $field,
						PHP_EOL . Indent::_(2) . $string
					);
				}
			}
		}

		return $grouping;
	}

	public function setCustomViewOrder(&$order, &$code, $tab = '')
	{
		$ordering = '';
		if (ArrayHelper::check($order))
		{
			foreach ($order as $or)
			{
				list($as, $field) = array_map(
					'trim', explode('.', (string) $or['table_key'])
				);
				// check if random
				if ('RAND' === $or['direction'])
				{
					// set the string
					$string = "\$query->order('RAND()');";
				}
				else
				{
					// set the string
					$string = "\$query->order('" . $or['table_key'] . " "
						. $or['direction'] . "');";
				}
				// sort where
				if ($as === 'a' || CFactory::_('Compiler.Builder.Site.Main.Get')->
					exists(CFactory::_('Config')->build_target . '.' . $code . '.' . $as))
				{
					$ordering .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . $string;
				}
				else
				{
					CFactory::_('Compiler.Builder.Other.Order')->set(
						CFactory::_('Config')->build_target . '.' . $code . '.' . $as . '.' . $field,
						PHP_EOL . Indent::_(2) . $string
					);
				}
			}
		}

		return $ordering;
	}

	public function setCustomViewWhere(&$where, &$code, $tab = '')
	{
		$wheres = '';
		if (ArrayHelper::check($where))
		{
			foreach ($where as $whe)
			{
				$as    = '';
				$field = '';
				$value = '';
				list($as, $field) = array_map(
					'trim', explode('.', (string) $whe['table_key'])
				);
				if (is_numeric($whe['value_key']))
				{
					$value = " " . $whe['value_key'] . "');";
				}
				elseif (strpos((string) $whe['value_key'], '$') !== false)
				{
					if ($whe['operator'] === 'IN'
						|| $whe['operator'] === 'NOT IN')
					{
						$value = " (' . implode(',', " . $whe['value_key']
							. ") . ')');";
					}
					else
					{
						$value = " ' . \$db->quote(" . $whe['value_key']
							. "));";
					}
				}
				elseif (strpos((string) $whe['value_key'], '.') !== false)
				{
					if (strpos((string) $whe['value_key'], "'") !== false)
					{
						$value = " ' . \$db->quote(" . $whe['value_key']
							. "));";
					}
					else
					{
						$value = " " . $whe['value_key'] . "');";
					}
				}
				elseif (StringHelper::check($whe['value_key']))
				{
					$value = " " . $whe['value_key'] . "');";
				}
				// only load if there is a value
				if (StringHelper::check($value))
				{
					$tabe = '';
					if ($as === 'a')
					{
						$tabe = $tab;
					}
					// set the string
					if ($whe['operator'] === 'IN'
						|| $whe['operator'] === 'NOT IN')
					{
						$string = "if (isset(" . $whe['value_key'] . ") && "
							. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check("
							. $whe['value_key'] . "))";
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1)
							. "{";
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(2)
							. "//" . Line::_(__Line__, __Class__) . " Get where "
							. $whe['table_key'] . " is " . $whe['value_key'];
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(2)
							. "\$query->where('" . $whe['table_key'] . " "
							. $whe['operator'] . $value;
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1)
							. "}";
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1)
							. "else";
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1)
							. "{";
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(2)
							. "return false;";
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1)
							. "}";
					}
					else
					{
						$string = "//" . Line::_(__Line__, __Class__)
							. " Get where " . $whe['table_key'] . " is "
							. $whe['value_key'];
						$string .= PHP_EOL . Indent::_(1) . $tabe . Indent::_(1)
							. "\$query->where('" . $whe['table_key'] . " "
							. $whe['operator'] . $value;
					}
					// sort where
					if ($as === 'a' || CFactory::_('Compiler.Builder.Site.Main.Get')->
						exists(CFactory::_('Config')->build_target . '.' . $code . '.' . $as))
					{
						$wheres .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . $string;
					}
					elseif ($as !== 'a')
					{
						CFactory::_('Compiler.Builder.Other.Where')->set(
							CFactory::_('Config')->build_target . '.' . $code . '.' . $as . '.' . $field,
							PHP_EOL . Indent::_(2) . $string
						);
					}
				}
			}
		}

		return $wheres;
	}

	public function setCustomViewGlobals(&$global, $string, $as, $tab = '')
	{
		$globals = '';
		if (ArrayHelper::check($global))
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
							$value = "\$this->setState('" . $glo['as'] . "."
								. $glo['name'] . "', " . $string . "->"
								. $glo['key'] . ");";
							break;
						case 2:
							// SET THIS
							$value = "\$this->" . $glo['as'] . "_"
								. $glo['name'] . " = " . $string . "->"
								. $glo['key'] . ";";
							break;
					}
					// only add if the filter is set
					if (StringHelper::check($value))
					{
						$globals .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "//" . Line::_(__Line__, __Class__)
							. " set the global " . $glo['name'] . " value."
							. PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. $value;
					}
				}
			}
		}

		return $globals;
	}

	/**
	 * @param           $string
	 * @param   string  $type
	 *
	 * @return mixed
	 */
	public function removeAsDot($string, $type = '')
	{
		if (strpos((string) $string, '.') !== false)
		{
			list($dump, $field) = array_map('trim', explode('.', (string) $string));
		}
		else
		{
			$field = $string;
		}

		return $field;
	}

	/**
	 * @param   type  $view
	 * @param   type  $type
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
			if (CFactory::_('Compiler.Builder.Content.One')->exists('SITE_DEFAULT_VIEW')
				&& CFactory::_('Compiler.Builder.Content.One')->get('SITE_DEFAULT_VIEW') != $view['settings']->code)
			{
				$redirectMessage = Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					)
					. " redirect away to the default view if no access allowed.";
				$redirectString  = "Route::_('index.php?option=com_"
					. CFactory::_('Config')->component_code_name . "&view="
					. CFactory::_('Compiler.Builder.Content.One')->get('SITE_DEFAULT_VIEW') . "')";
			}
			else
			{
				$redirectMessage = Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " redirect away to the home page if no access allowed.";
				$redirectString  = 'Uri::root()';
			}
			$accessCheck[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if this user has permission to access item";
			$accessCheck[] = Indent::_(2) . "if (!" . $userString
				. "->authorise('site." . $view['settings']->code
				. ".access', 'com_" . CFactory::_('Config')->component_code_name . "'))";
			$accessCheck[] = Indent::_(2) . "{";
			$accessCheck[] = Indent::_(3)
				. "\$app = Factory::getApplication();";
			// set lang
			$langKeyWord = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe(
					'Not authorised to view ' . $view['settings']->code . '!',
					'U'
				);
			CFactory::_('Language')->set(
				'site', $langKeyWord,
				'Not authorised to view ' . $view['settings']->code . '!'
			);
			$accessCheck[] = Indent::_(3) . "\$app->enqueueMessage(Text:"
				. ":_('" . $langKeyWord . "'), 'error');";
			$accessCheck[] = $redirectMessage;
			$accessCheck[] = Indent::_(3) . "\$app->redirect(" . $redirectString
				. ");";
			$accessCheck[] = Indent::_(3) . "return false;";
			$accessCheck[] = Indent::_(2) . "}";

			// return the access check
			return implode(PHP_EOL, $accessCheck);
		}

		return '';
	}

	/**
	 * @param           $get
	 * @param           $code
	 * @param   string  $tab
	 * @param   string  $type
	 *
	 * @return string
	 */
	public function setCustomViewGetItem(&$get, &$code, $tab = '', $type = 'main')
	{
		if (ObjectHelper::check($get))
		{
			// set the site decription switches
			foreach (CFactory::_('Config')->cryption_types as $cryptionType)
			{
				CFactory::_('Compiler.Builder.Site.Decrypt')->set("{$cryptionType}.{$code}", false);
			}
			// start the get Item
			$getItem = '';
			// set before item php
			if (isset($get->add_php_before_getitem)
				&& $get->add_php_before_getitem == 1
				&& isset($get->php_before_getitem)
				&& StringHelper::check(
					$get->php_before_getitem
				))
			{
				$getItem .= CFactory::_('Placeholder')->update_(
					$get->php_before_getitem
				);
			}
			// start loadin the get Item
			$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "//"
				. Line::_(__Line__, __Class__) . " Get a db connection.";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$db = Factory::getDbo();";
			}
			else
			{
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$db = \$this->getDatabase();";
			}
			$getItem .= PHP_EOL . PHP_EOL . $tab . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Create a new query object.";
			$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. "\$query = \$db->getQuery(true);";
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get, $code, $tab);
			// setup filters
			if (isset($get->filter))
			{
				$getItem .= $this->setCustomViewFilter(
					$get->filter, $code, $tab
				);
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
			// db set query data placeholder
			$getItem .= Placefix::_h("DB_SET_QUERY_DATA") ;
			// set after item php
			if (isset($get->add_php_after_getitem)
				&& $get->add_php_after_getitem == 1
				&& isset($get->php_after_getitem)
				&& StringHelper::check($get->php_after_getitem))
			{
				$getItem .= CFactory::_('Placeholder')->update_(
					$get->php_after_getitem
				);
			}
			// check the getItem string to see if we should still add set query to data
			if (strpos($getItem, '$data =') === false)
			{
				// get ready to get query
				$setQuery[Placefix::_h("DB_SET_QUERY_DATA")] =
					PHP_EOL . PHP_EOL . $tab . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__)
					. " Reset the query using our newly populated query object.";
				$setQuery[Placefix::_h("DB_SET_QUERY_DATA")] .=
					PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$db->setQuery(\$query);";
				$setQuery[Placefix::_h("DB_SET_QUERY_DATA")] .=
					PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "//"
					. Line::_(__Line__, __Class__)
					. " Load the results as a stdClass object.";
				$setQuery[Placefix::_h("DB_SET_QUERY_DATA")] .=
					PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$data = \$db->loadObject();";
				// add the db set query to data
			}
			else
			{
				// remove our placeholder
				$setQuery[Placefix::_h("DB_SET_QUERY_DATA")] = '';
			}
			// add the db set query to data
			$getItem = str_replace(
				array_keys($setQuery),
				array_values($setQuery), $getItem
			);
			$getItem .= PHP_EOL . PHP_EOL . $tab . Indent::_(2)
				. "if (empty(\$data))";
			$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "{";
			if ($type === 'main')
			{
				$getItem      .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "\$app = Factory::getApplication();";
				$langKeyWoord = CFactory::_('Config')->lang_prefix . '_'
					. StringHelper::safe(
						'Not found or access denied', 'U'
					);
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $langKeyWoord, 'Not found, or access denied.'
				);
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__)
					. " If no data is found redirect to default page and show warning.";
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "\$app->enqueueMessage(Text:" . ":_('" . $langKeyWoord
					. "'), 'warning');";
				if ('site' === CFactory::_('Config')->build_target)
				{
					// check that the default and the redirect page is not the same
					if (CFactory::_('Compiler.Builder.Content.One')->exists('SITE_DEFAULT_VIEW')
						&& CFactory::_('Compiler.Builder.Content.One')->get('SITE_DEFAULT_VIEW') != $code)
					{
						$redirectString = "Route::_('index.php?option=com_"
							. CFactory::_('Config')->component_code_name . "&view="
							. CFactory::_('Compiler.Builder.Content.One')->get('SITE_DEFAULT_VIEW') . "')";
					}
					else
					{
						$redirectString = 'Uri::root()';
					}
					$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
						. "\$app->redirect(" . $redirectString . ");";
				}
				else
				{
					$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
						. "\$app->redirect('index.php?option=com_"
						. CFactory::_('Config')->component_code_name . "');";
				}
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "return false;";
			}
			else
			{
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "return false;";
			}
			$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}";
			// dispatcher placeholder
			$getItem .= Placefix::_h("DISPATCHER") ;
			if (ArrayHelper::check($get->main_get))
			{
				$asBucket = [];
				foreach ($get->main_get as $main_get)
				{
					if (isset($main_get['key']) && isset($main_get['as']))
					{
						// build path
						$path = $code . '.' . $main_get['key'] . '.' . $main_get['as'];

						$decodeChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->get('decode.' . $path);
						if (ArrayHelper::check($decodeChecker))
						{
							// set decoding of needed fields
							$getItem .= $this->setCustomViewFieldDecode(
								$main_get, $decodeChecker, '$data', $code,
								$tab
							);
						}

						$decodeFilter = CFactory::_('Compiler.Builder.Site.Field.Decode.Filter')->
							get(CFactory::_('Config')->build_target . '.' . $path);
						if (ArrayHelper::check($decodeFilter))
						{
							// also filter fields if needed
							$getItem .= $this->setCustomViewFieldDecodeFilter(
								$main_get, $decodeFilter, '$data', '$data',
								$code, $tab
							);
						}

						$contentprepareChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->
							get('textareas.' . $path);
						if (ArrayHelper::check($contentprepareChecker))
						{
							// set contentprepare checkers on needed fields
							$getItem .= $this->setCustomViewFieldonContentPrepareChecker(
								$main_get, $contentprepareChecker, '$data',
								$code, $tab
							);
						}

						$uikitChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->get('uikit.' . $path);
						if (ArrayHelper::check($uikitChecker))
						{
							// set uikit checkers on needed fields
							$getItem .= $this->setCustomViewFieldUikitChecker(
								$main_get, $uikitChecker, '$data', $code,
								$tab
							);
						}

						$asBucket[] = $main_get['as'];
					}
				}
			}
			// set the scripts
			$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
			$script    = '';
			foreach (CFactory::_('Config')->cryption_types as $cryptionType)
			{
				if (CFactory::_('Compiler.Builder.Site.Decrypt')->get("{$cryptionType}.{$code}", false))
				{
					if ('expert' !== $cryptionType)
					{
						$script .= PHP_EOL . PHP_EOL . Indent::_(1) . $tab
							. Indent::_(1) . "//" . Line::_(__Line__, __Class__)
							. " Get the " . $cryptionType . " encryption.";
						$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$" . $cryptionType . "key = " . $Component
							. "Helper::getCryptKey('" . $cryptionType . "');";
						$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "//" . Line::_(__Line__, __Class__)
							. " Get the encryption object.";
						$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "\$" . $cryptionType . " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$"
							. $cryptionType . "key);";
					}
					elseif (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
						exists("{$code}.get"))
					{
						foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
							get("{$code}.get") as $block)
						{
							$script .= PHP_EOL . Indent::_(1) . implode(
								PHP_EOL . Indent::_(1), $block
							);
						}
					}
				}
			}
			$getItem = $script . $getItem;
			// setup Globals
			$getItem .= $this->setCustomViewGlobals(
				$get->global, '$data', $asBucket, $tab
			);
			// setup the custom gets that returns multiple values
			$getItem .= $this->setCustomViewCustomJoin(
				$get->custom_get, '$data', $code, $asBucket, $tab
			);
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode(
					PHP_EOL, (string) CFactory::_('Placeholder')->update_(
					$get->php_calculation
				)
				);
				$getItem .= PHP_EOL . Indent::_(1) . $tab
					. Indent::_(1) . implode(
						PHP_EOL . Indent::_(1) . $tab . Indent::_(1),
						$get->php_calculation
					);
			}
			if ($type === 'custom')
			{
				// return the object
				$getItem .= PHP_EOL . PHP_EOL . Indent::_(1) . $tab . Indent::_(
						1
					) . "//" . Line::_(__Line__, __Class__)
					. " return data object.";
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "return \$data;";
			}
			else
			{
				// set the object
				$getItem .= PHP_EOL . PHP_EOL . Indent::_(1) . $tab . Indent::_(
						1
					) . "//" . Line::_(__Line__, __Class__)
					. " set data object to item.";
				$getItem .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$this->_item[\$pk] = \$data;";
			}
			// only update if dispacher placholder is found
			if (strpos($getItem, (string) Placefix::_h('DISPATCHER'))
				!== false)
			{
				// check if the dispather should be added
				if (!isset($this->JEventDispatcher)
					|| !ArrayHelper::check(
						$this->JEventDispatcher
					))
				{
					$this->JEventDispatcher = array(Placefix::_h('DISPATCHER') => '');
				}
				$getItem = str_replace(
					array_keys($this->JEventDispatcher),
					array_values($this->JEventDispatcher), $getItem
				);
			}

			return $getItem;
		}

		return PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "//"
			. Line::_(__Line__, __Class__) . "add your custom code here.";
	}

	public function setCustomViewCustomMethods($main_view, $code)
	{
		$methods = '';
		// then set the needed custom methods
		if (ArrayHelper::check($main_view)
			&& isset($main_view['settings'])
			&& ObjectHelper::check($main_view['settings'])
			&& isset($main_view['settings']->custom_get))
		{
			$_dynamic_get = $main_view['settings']->custom_get;
		}
		elseif (ObjectHelper::check($main_view)
			&& isset($main_view->custom_get))
		{
			$_dynamic_get = $main_view->custom_get;
		}
		// check if we have an array
		if (isset($_dynamic_get)
			&& ArrayHelper::check(
				$_dynamic_get
			))
		{
			// start dynamic build
			foreach ($_dynamic_get as $view)
			{
				// fix alias to use in code
				$view->code = StringHelper::safe($code);
				$view->Code = StringHelper::safe(
					$view->code, 'F'
				);
				$view->CODE = StringHelper::safe(
					$view->code, 'U'
				);
				$main       = '';
				if ($view->gettype == 3)
				{
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						// SITE_GET_ITEM <<<DYNAMIC>>>
						$main .= PHP_EOL . PHP_EOL . Indent::_(2)
							. "if (!isset(\$this->initSet) || !\$this->initSet)";
						$main .= PHP_EOL . Indent::_(2) . "{";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->user = Factory::getUser();";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->userId = \$this->user->get('id');";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->guest = \$this->user->get('guest');";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->groups = \$this->user->get('groups');";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->authorisedGroups = \$this->user->getAuthorisedGroups();";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->levels = \$this->user->getAuthorisedViewLevels();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->initSet = true;";
						$main .= PHP_EOL . Indent::_(2) . "}";
					}
					$main .= $this->setCustomViewGetItem(
						$view, $view->code, '', 'custom'
					);
					$type
						= 'mixed  item data object on success, false on failure.';
				}
				elseif ($view->gettype == 4)
				{
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						$main .= PHP_EOL . PHP_EOL . Indent::_(2)
							. "if (!isset(\$this->initSet) || !\$this->initSet)";
						$main .= PHP_EOL . Indent::_(2) . "{";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->user = Factory::getUser();";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->userId = \$this->user->get('id');";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->guest = \$this->user->get('guest');";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->groups = \$this->user->get('groups');";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->authorisedGroups = \$this->user->getAuthorisedGroups();";
						$main .= PHP_EOL . Indent::_(3)
							. "\$this->levels = \$this->user->getAuthorisedViewLevels();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->initSet = true;";
						$main .= PHP_EOL . Indent::_(2) . "}";
					}
					$main .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Get the global params";
					$main .= PHP_EOL . Indent::_(2)
						. "\$globalParams = ComponentHelper::getParams('com_"
						. CFactory::_('Config')->component_code_name . "', true);";
					// set php before listquery
					if (isset($view->add_php_getlistquery)
						&& $view->add_php_getlistquery == 1
						&& isset($view->php_getlistquery)
						&& StringHelper::check(
							$view->php_getlistquery
						))
					{
						$main .= CFactory::_('Placeholder')->update_(
							$view->php_getlistquery
						);
					}
					// SITE_GET_LIST_QUERY <<<DYNAMIC>>>
					$main .= $this->setCustomViewListQuery(
						$view, $view->code, false
					);
					// set before items php
					if (isset($view->add_php_before_getitems)
						&& $view->add_php_before_getitems == 1
						&& isset($view->php_before_getitems)
						&& StringHelper::check(
							$view->php_before_getitems
						))
					{
						$main .= CFactory::_('Placeholder')->update_(
							$view->php_before_getitems
						);
					}
					// load the object list
					$main .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Reset the query using our newly populated query object.";
					$main .= PHP_EOL . Indent::_(2)
						. "\$db->setQuery(\$query);";
					$main .= PHP_EOL . Indent::_(2)
						. "\$items = \$db->loadObjectList();";
					// set after items php
					if (isset($view->add_php_after_getitems)
						&& $view->add_php_after_getitems == 1
						&& isset($view->php_after_getitems)
						&& StringHelper::check(
							$view->php_after_getitems
						))
					{
						$main .= CFactory::_('Placeholder')->update_(
							$view->php_after_getitems
						);
					}
					$main .= PHP_EOL . PHP_EOL . Indent::_(2)
						. "if (empty(\$items))";
					$main .= PHP_EOL . Indent::_(2) . "{";
					$main .= PHP_EOL . Indent::_(3) . "return false;";
					$main .= PHP_EOL . Indent::_(2) . "}";
					// SITE_GET_ITEMS <<<DYNAMIC>>>
					$main .= $this->setCustomViewGetItems($view, $view->code);
					$main .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " return items";
					$main .= PHP_EOL . Indent::_(2) . "return \$items;";
					$type
						= 'mixed  An array of objects on success, false on failure.';
				}
				// load the main mehtod
				$methods .= $this->setMainCustomMehtod(
					$main, $view->getcustom, $type
				);
				// SITE_CUSTOM_METHODS <<<DYNAMIC>>>
				$methods .= $this->setCustomViewCustomItemMethods(
					$view, $view->code
				);
			}
		}
		// load uikit get method
		if (ArrayHelper::check($main_view)
			&& isset($main_view['settings']))
		{
			$methods .= $this->setUikitGetMethod();
		}

		return $methods;
	}

	public function setUikitHelperMethods()
	{
		// only load for uikit version 2
		if (2 == CFactory::_('Config')->uikit || 1 == CFactory::_('Config')->uikit)
		{
			// build uikit get method
			$ukit   = [];
			$ukit[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$ukit[] = Indent::_(1) . " *  UIKIT Component Classes";
			$ukit[] = Indent::_(1) . " **/";
			$ukit[] = Indent::_(1) . "public static \$uk_components = array(";
			$ukit[] = Indent::_(3) . "'data-uk-grid' => array(";
			$ukit[] = Indent::_(4) . "'grid' ),";
			$ukit[] = Indent::_(3) . "'uk-accordion' => array(";
			$ukit[] = Indent::_(4) . "'accordion' ),";
			$ukit[] = Indent::_(3) . "'uk-autocomplete' => array(";
			$ukit[] = Indent::_(4) . "'autocomplete' ),";
			$ukit[] = Indent::_(3) . "'data-uk-datepicker' => array(";
			$ukit[] = Indent::_(4) . "'datepicker' ),";
			$ukit[] = Indent::_(3) . "'uk-form-password' => array(";
			$ukit[] = Indent::_(4) . "'form-password' ),";
			$ukit[] = Indent::_(3) . "'uk-form-select' => array(";
			$ukit[] = Indent::_(4) . "'form-select' ),";
			$ukit[] = Indent::_(3) . "'data-uk-htmleditor' => array(";
			$ukit[] = Indent::_(4) . "'htmleditor' ),";
			$ukit[] = Indent::_(3) . "'data-uk-lightbox' => array(";
			$ukit[] = Indent::_(4) . "'lightbox' ),";
			$ukit[] = Indent::_(3) . "'uk-nestable' => array(";
			$ukit[] = Indent::_(4) . "'nestable' ),";
			$ukit[] = Indent::_(3) . "'UIkit.notify' => array(";
			$ukit[] = Indent::_(4) . "'notify' ),";
			$ukit[] = Indent::_(3) . "'data-uk-parallax' => array(";
			$ukit[] = Indent::_(4) . "'parallax' ),";
			$ukit[] = Indent::_(3) . "'uk-search' => array(";
			$ukit[] = Indent::_(4) . "'search' ),";
			$ukit[] = Indent::_(3) . "'uk-slider' => array(";
			$ukit[] = Indent::_(4) . "'slider' ),";
			$ukit[] = Indent::_(3) . "'uk-slideset' => array(";
			$ukit[] = Indent::_(4) . "'slideset' ),";
			$ukit[] = Indent::_(3) . "'uk-slideshow' => array(";
			$ukit[] = Indent::_(4) . "'slideshow',";
			$ukit[] = Indent::_(4) . "'slideshow-fx' ),";
			$ukit[] = Indent::_(3) . "'uk-sortable' => array(";
			$ukit[] = Indent::_(4) . "'sortable' ),";
			$ukit[] = Indent::_(3) . "'data-uk-sticky' => array(";
			$ukit[] = Indent::_(4) . "'sticky' ),";
			$ukit[] = Indent::_(3) . "'data-uk-timepicker' => array(";
			$ukit[] = Indent::_(4) . "'timepicker' ),";
			$ukit[] = Indent::_(3) . "'data-uk-tooltip' => array(";
			$ukit[] = Indent::_(4) . "'tooltip' ),";
			$ukit[] = Indent::_(3) . "'uk-placeholder' => array(";
			$ukit[] = Indent::_(4) . "'placeholder' ),";
			$ukit[] = Indent::_(3) . "'uk-dotnav' => array(";
			$ukit[] = Indent::_(4) . "'dotnav' ),";
			$ukit[] = Indent::_(3) . "'uk-slidenav' => array(";
			$ukit[] = Indent::_(4) . "'slidenav' ),";
			$ukit[] = Indent::_(3) . "'uk-form' => array(";
			$ukit[] = Indent::_(4) . "'form-advanced' ),";
			$ukit[] = Indent::_(3) . "'uk-progress' => array(";
			$ukit[] = Indent::_(4) . "'progress' ),";
			$ukit[] = Indent::_(3) . "'upload-drop' => array(";
			$ukit[] = Indent::_(4) . "'upload', 'form-file' )";
			$ukit[] = Indent::_(3) . ");";
			$ukit[] = PHP_EOL . Indent::_(1) . "/**";
			$ukit[] = Indent::_(1) . " *  Add UIKIT Components";
			$ukit[] = Indent::_(1) . " **/";
			$ukit[] = Indent::_(1) . "public static \$uikit = false;";
			$ukit[] = "";
			$ukit[] = Indent::_(1) . "/**";
			$ukit[] = Indent::_(1) . " *  Get UIKIT Components";
			$ukit[] = Indent::_(1) . " **/";
			$ukit[] = Indent::_(1)
				. "public static function getUikitComp(\$content,\$classes = array())";
			$ukit[] = Indent::_(1) . "{";
			$ukit[] = Indent::_(2)
				. "if (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = Indent::_(2) . "{";
			$ukit[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__) . " reset";
			$ukit[] = Indent::_(3) . "\$temp = [];";
			$ukit[] = Indent::_(3)
				. "foreach (self::\$uk_components as \$looking => \$add)";
			$ukit[] = Indent::_(3) . "{";
			$ukit[] = Indent::_(4)
				. "if (strpos(\$content,\$looking) !== false)";
			$ukit[] = Indent::_(4) . "{";
			$ukit[] = Indent::_(5) . "\$temp[] = \$looking;";
			$ukit[] = Indent::_(4) . "}";
			$ukit[] = Indent::_(3) . "}";
			$ukit[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " make sure uikit is loaded to config";
			$ukit[] = Indent::_(3)
				. "if (strpos(\$content,'class=\"uk-') !== false)";
			$ukit[] = Indent::_(3) . "{";
			$ukit[] = Indent::_(4) . "self::\$uikit = true;";
			$ukit[] = Indent::_(3) . "}";
			$ukit[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " sorter";
			$ukit[] = Indent::_(3) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$temp))";
			$ukit[] = Indent::_(3) . "{";
			$ukit[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " merger";
			$ukit[] = Indent::_(4) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$classes))";
			$ukit[] = Indent::_(4) . "{";
			$ukit[] = Indent::_(5)
				. "\$newTemp = array_merge(\$temp,\$classes);";
			$ukit[] = Indent::_(5) . "\$temp = array_unique(\$newTemp);";
			$ukit[] = Indent::_(4) . "}";
			$ukit[] = Indent::_(4) . "return \$temp;";
			$ukit[] = Indent::_(3) . "}";
			$ukit[] = Indent::_(2) . "}";
			$ukit[] = Indent::_(2) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$classes))";
			$ukit[] = Indent::_(2) . "{";
			$ukit[] = Indent::_(3) . "return \$classes;";
			$ukit[] = Indent::_(2) . "}";
			$ukit[] = Indent::_(2) . "return false;";
			$ukit[] = Indent::_(1) . "}";

			// return the help methods
			return implode(PHP_EOL, $ukit);
		}

		return '';
	}

	public function setUikitGetMethod()
	{
		$method = '';
		// only load for uikit version 2
		if (2 == CFactory::_('Config')->uikit || 1 == CFactory::_('Config')->uikit)
		{
			// build uikit get method
			$method .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$method .= PHP_EOL . Indent::_(1)
				. " * Get the uikit needed components";
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1)
				. " * @return mixed  An array of objects on success.";
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1) . " */";
			$method .= PHP_EOL . Indent::_(1)
				. "public function getUikitComp()";
			$method .= PHP_EOL . Indent::_(1) . "{";
			$method .= PHP_EOL . Indent::_(2)
				. "if (isset(\$this->uikitComp) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->uikitComp))";
			$method .= PHP_EOL . Indent::_(2) . "{";
			$method .= PHP_EOL . Indent::_(3) . "return \$this->uikitComp;";
			$method .= PHP_EOL . Indent::_(2) . "}";
			$method .= PHP_EOL . Indent::_(2) . "return false;";
			$method .= PHP_EOL . Indent::_(1) . "}";
		}

		return $method;
	}

	public function setMainCustomMehtod(&$body, $nAme, $type)
	{
		$method = '';
		if (StringHelper::check($body))
		{
			// build custom method
			$method .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$method .= PHP_EOL . Indent::_(1) . " * Custom Method";
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1) . " * @return " . $type;
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1) . " */";
			$method .= PHP_EOL . Indent::_(1) . "public function " . $nAme
				. "()";
			$method .= PHP_EOL . Indent::_(1) . "{" . $body;
			$method .= PHP_EOL . Indent::_(1) . "}";
		}

		return $method;
	}

	public function setCustomViewCustomItemMethods(&$main_get, $code)
	{
		$methods                = '';
		$this->JEventDispatcher = '';
		// first set the needed item/s methods
		if (ObjectHelper::check($main_get))
		{
			if (isset($main_get->custom_get)
				&& ArrayHelper::check($main_get->custom_get))
			{
				foreach ($main_get->custom_get as $get)
				{
					// set the site decription switch
					foreach (CFactory::_('Config')->cryption_types as $cryptionType)
					{
						CFactory::_('Compiler.Builder.Site.Decrypt')->set("{$cryptionType}.{$code}", false);
					}
					// set the method defaults
					if (($default = $this->setCustomViewMethodDefaults($get, $code)) !== false)
					{
						// build custom method
						$methods .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
						$methods .= PHP_EOL . Indent::_(1)
							. " * Method to get an array of " . $default['name']
							. " Objects.";
						$methods .= PHP_EOL . Indent::_(1) . " *";
						$methods .= PHP_EOL . Indent::_(1)
							. " * @return mixed  An array of "
							. $default['name']
							. " Objects on success, false on failure.";
						$methods .= PHP_EOL . Indent::_(1) . " *";
						$methods .= PHP_EOL . Indent::_(1) . " */";
						$methods .= PHP_EOL . Indent::_(1)
							. "public function get" . $default['methodName']
							. "(\$" . $default['on_field'] . ")";
						$methods .= PHP_EOL . Indent::_(1) . "{" . Placefix::_h("CRYPT") ;
						$methods .= PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__)
							. " Get a db connection.";
						if (CFactory::_('Config')->get('joomla_version', 3) == 3)
						{
							$methods .= PHP_EOL . Indent::_(2)
								. "\$db = Factory::getDbo();";
						}
						else
						{
							$methods .= PHP_EOL . Indent::_(2)
								. "\$db = \$this->getDatabase();";
						}
						$methods .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__)
							. " Create a new query object.";
						$methods .= PHP_EOL . Indent::_(2)
							. "\$query = \$db->getQuery(true);";
						$methods .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__) . " Get from "
							. $get['selection']['table'] . " as "
							. $default['as'];
						$methods .= PHP_EOL . Indent::_(2)
							. $get['selection']['select'];
						$methods .= PHP_EOL . Indent::_(2) . '$query->from('
							. $get['selection']['from'] . ');';
						// set the string
						if ($get['operator'] === 'IN'
							|| $get['operator'] === 'NOT IN')
						{
							$methods .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
								. Line::_(__Line__, __Class__) . " Check if \$"
								. $default['on_field']
								. " is an array with values.";
							$methods .= PHP_EOL . Indent::_(2) . "\$array = ("
								. "Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check(\$"
								. $default['on_field']
								. ", true)) ? json_decode(\$"
								. $default['on_field'] . ",true) : \$"
								. $default['on_field'] . ";";
							$methods .= PHP_EOL . Indent::_(2)
								. "if (isset(\$array) && "
								. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$array, true))";
							$methods .= PHP_EOL . Indent::_(2) . "{";
							$methods .= PHP_EOL . Indent::_(3)
								. "\$query->where('" . $get['join_field'] . " "
								. $get['operator']
								. " (' . implode(',', \$array) . ')');";
							$methods .= PHP_EOL . Indent::_(2) . "}";
							$methods .= PHP_EOL . Indent::_(2) . "else";
							$methods .= PHP_EOL . Indent::_(2) . "{";
							$methods .= PHP_EOL . Indent::_(3)
								. "return false;";
							$methods .= PHP_EOL . Indent::_(2) . "}";
						}
						else
						{
							$methods .= PHP_EOL . Indent::_(2)
								. "\$query->where('" . $get['join_field'] . " "
								. $get['operator'] . " ' . \$db->quote(\$"
								. $default['on_field'] . "));";
						}
						// check if other queries should be loaded
						foreach (CFactory::_('Compiler.Builder.Other.Query')->
							get(CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $default['as'], [])
								as $query)
						{
							$methods .= $query;
						}
						// add any other filter that was set
						foreach (CFactory::_('Compiler.Builder.Other.Filter')->
							get(CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $default['as'], [])
								as $field => $string)
						{
							$methods .= $string;
						}
						// add any other where that was set
						foreach (CFactory::_('Compiler.Builder.Other.Where')->
							get(CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $default['as'], [])
								as $field => $string)
						{
							$methods .= $string;
						}
						// add any other order that was set
						foreach (CFactory::_('Compiler.Builder.Other.Order')->
							get(CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $default['as'], [])
								 as $field => $string)
						{
							$methods .= $string;
						}
						// add any other grouping that was set
						foreach (CFactory::_('Compiler.Builder.Other.Group')->
							get(CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $default['as'], [])
								as $field => $string)
						{
							$methods .= $string;
						}
						$methods .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__)
							. " Reset the query using our newly populated query object.";
						$methods .= PHP_EOL . Indent::_(2)
							. "\$db->setQuery(\$query);";
						$methods .= PHP_EOL . Indent::_(2) . "\$db->execute();";
						$methods .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__)
							. " check if there was data returned";
						$methods .= PHP_EOL . Indent::_(2)
							. "if (\$db->getNumRows())";
						$methods .= PHP_EOL . Indent::_(2) . "{";
						// set dispatcher placeholder
						$methods .= Placefix::_h("DISPATCHER");
						// build path
						$path = $default['code'] . '.' . $get['key'] . '.' . $default['as'];
						// set decoding of needed fields
						$decodeChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->get('decode.' . $path);
						// also filter fields if needed
						$decodeFilter = CFactory::_('Compiler.Builder.Site.Field.Decode.Filter')->
							get(CFactory::_('Config')->build_target . '.' . $path);
						// set uikit checkers on needed fields
						$uikitChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->get('uikit.' . $path);
						// set content prepare on needed fields
						$contentprepareChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->
							get('textareas.' . $path);
						// set placeholder values
						$placeholders = [
							Placefix::_h('TAB') => Indent::_(2),
							Placefix::_h('STRING') => '$item'
						];
						// set joined values
						$joinedChecker = CFactory::_('Compiler.Builder.Other.Join')->
							get(CFactory::_('Config')->build_target . '.' . $default['code'] . '.' . $default['as']);
						if ($decodeChecker !== null || $uikitChecker !== null
							|| $decodeFilter !== null || $contentprepareChecker !== null
							|| $joinedChecker !== null)
						{
							$decoder = '';
							if ($decodeChecker !== null && ArrayHelper::check($decodeChecker))
							{
								// also filter fields if needed
								$decoder = $this->setCustomViewFieldDecode(
									$get, $decodeChecker, '$item',
									$default['code'], Indent::_(2)
								);
							}
							$decoder_filter = '';
							if ($decodeFilter !== null && ArrayHelper::check($decodeFilter))
							{
								$decoder_filter
									= $this->setCustomViewFieldDecodeFilter(
									$get, $decodeFilter, '$item', '$items[$nr]',
									$default['code'], Indent::_(2)
								);
							}
							$contentprepare = '';
							if ($contentprepareChecker !== null && ArrayHelper::check($contentprepareChecker))
							{
								$contentprepare
									= $this->setCustomViewFieldonContentPrepareChecker(
									$get, $contentprepareChecker, '$item',
									$default['code'], Indent::_(2)
								);
							}
							$uikit = '';
							if ($uikitChecker !== null && ArrayHelper::check($uikitChecker))
							{
								$uikit = $this->setCustomViewFieldUikitChecker(
									$get, $uikitChecker, '$item',
									$default['code'], Indent::_(2)
								);
							}
							$joine = '';
							if ($joinedChecker !== null && ArrayHelper::check($joinedChecker))
							{
								foreach ($joinedChecker as $joinedString)
								{
									$joine .= CFactory::_('Placeholder')->update(
										$joinedString, $placeholders
									);
								}
							}
							if (StringHelper::check($decoder) || StringHelper::check($contentprepare)
								|| StringHelper::check($uikit) || StringHelper::check($decoder_filter)
								|| StringHelper::check($joine))
							{
								$methods .= PHP_EOL . Indent::_(3)
									. "\$items = \$db->loadObjectList();";
								$methods .= PHP_EOL . PHP_EOL . Indent::_(3)
									. "//" . Line::_(__Line__, __Class__)
									. " Convert the parameter fields into objects.";
								$methods .= PHP_EOL . Indent::_(3)
									. "foreach (\$items as \$nr => &\$item)";
								$methods .= PHP_EOL . Indent::_(3) . "{";
								if (StringHelper::check($decoder))
								{
									$methods .= $decoder;
								}
								if (StringHelper::check($decoder_filter))
								{
									$methods .= $decoder_filter;
								}
								if (StringHelper::check($contentprepare))
								{
									$methods .= $contentprepare;
								}
								if (StringHelper::check($uikit))
								{
									$methods .= $uikit;
								}
								if (StringHelper::check($joine))
								{
									$methods .= $joine;
								}
								$methods .= PHP_EOL . Indent::_(3) . "}";
								$methods .= PHP_EOL . Indent::_(3)
									. "return \$items;";
							}
							else
							{
								$methods .= PHP_EOL . Indent::_(3)
									. "return \$db->loadObjectList();";
							}
						}
						else
						{
							$methods .= PHP_EOL . Indent::_(3)
								. "return \$db->loadObjectList();";
						}
						$methods .= PHP_EOL . Indent::_(2) . "}";
						$methods .= PHP_EOL . Indent::_(2) . "return false;";
						$methods .= PHP_EOL . Indent::_(1) . "}";

						// set the script if it was found
						$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
						$script    = '';
						foreach (CFactory::_('Config')->cryption_types as $cryptionType)
						{
							if (CFactory::_('Compiler.Builder.Site.Decrypt')->get("{$cryptionType}.{$code}", false))
							{
								if ('expert' !== $cryptionType)
								{
									$script .= PHP_EOL . Indent::_(2) . "//"
										. Line::_(__Line__, __Class__) . " Get the "
										. $cryptionType . " encryption.";
									$script .= PHP_EOL . Indent::_(2) . "\$"
										. $cryptionType . "key = " . $Component
										. "Helper::getCryptKey('"
										. $cryptionType . "');";
									$script .= PHP_EOL . Indent::_(2) . "//"
										. Line::_(__Line__, __Class__)
										. " Get the encryption object.";
									$script .= PHP_EOL . Indent::_(2) . "\$"
										. $cryptionType
										. " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$"
										. $cryptionType . "key);" . PHP_EOL;
								}
								elseif (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
									exists("{$code}.get"))
								{
									foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
										exists("{$code}.get") as $block)
									{
										$script .= PHP_EOL . Indent::_(2) . implode(
											PHP_EOL . Indent::_(2), $block
										);
									}
								}
							}
						}
						$methods = str_replace(
							Placefix::_h('CRYPT'), $script, $methods
						);
					}
				}
				// insure the crypt placeholder is removed
				if (StringHelper::check($methods))
				{
					$methods = str_replace(
						Placefix::_h('CRYPT'), '', $methods
					);
				}
			}
		}
		// only update if dispacher placholder is found
		if (strpos($methods, (string) Placefix::_h('DISPATCHER')) !== false)
		{
			// check if the dispather should be added
			if (!isset($this->JEventDispatcher)
				|| !ArrayHelper::check($this->JEventDispatcher))
			{
				$this->JEventDispatcher = array(Placefix::_h('DISPATCHER') => '');
			}
			$methods = str_replace(
				array_keys($this->JEventDispatcher),
				array_values($this->JEventDispatcher), $methods
			);
		}
		// insure the crypt placeholder is removed
		if (StringHelper::check($methods))
		{
			return $methods . PHP_EOL;
		}

		return '';
	}

	public function setCustomViewMethodDefaults($get, $code)
	{
		if (isset($get['key']) && isset($get['as']))
		{
			$key                  = substr(
				(string) StringHelper::safe(
					preg_replace('/[0-9]+/', '', md5((string) $get['key'])), 'F'
				), 0, 4
			);
			$method['on_field']   = (isset($get['on_field']))
				? $this->removeAsDot($get['on_field']) : null;
			$method['join_field'] = (isset($get['join_field']))
				? StringHelper::safe(
					$this->removeAsDot($get['join_field'])
				) : null;
			$method['Join_field'] = (isset($method['join_field']))
				? StringHelper::safe($method['join_field'], 'F')
				: null;
			$method['name']       = StringHelper::safe(
				$get['selection']['name'], 'F'
			);
			$method['code']       = StringHelper::safe($code);
			$method['AS']         = StringHelper::safe(
				$get['as'], 'U'
			);
			$method['as']         = StringHelper::safe(
				$get['as']
			);
			$method['valueName']  = $method['on_field'] . $method['Join_field']
				. $method['name'] . $method['AS'];
			$method['methodName'] = StringHelper::safe(
					$method['on_field'], 'F'
				) . $method['Join_field'] . $method['name'] . $key . '_'
				. $method['AS'];

			// return
			return $method;
		}

		return false;
	}

	public function setCustomViewListQuery(&$get, $code, $return = true)
	{
		if (ObjectHelper::check($get))
		{
			if ($get->pagination == 1)
			{
				$getItem = PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Get a db connection.";
			}
			else
			{
				$getItem = PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					)
					. " Make sure all records load, since no pagination allowed.";
				$getItem .= PHP_EOL . Indent::_(2)
					. "\$this->setState('list.limit', 0);";
				$getItem .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Get a db connection.";
			}
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$getItem .= PHP_EOL . Indent::_(2) . "\$db = Factory::getDbo();";
			}
			else
			{
				$getItem .= PHP_EOL . Indent::_(2) . "\$db = \$this->getDatabase();";
			}
			$getItem .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Create a new query object.";
			$getItem .= PHP_EOL . Indent::_(2)
				. "\$query = \$db->getQuery(true);";
			// set main get query
			$getItem .= $this->setCustomViewQuery($get->main_get, $code);
			// check if there is any custom script
			$getItem .= CFactory::_('Customcode.Dispenser')->get(
				CFactory::_('Config')->build_target . '_php_getlistquery', $code, '',
				PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Filtering.", true
			);
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
				$getItem .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " return the query object"
					. PHP_EOL . Indent::_(2) . "return \$query;";
			}

			return $getItem;
		}

		return PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. "add your custom code here.";
	}

	/**
	 * @param $get
	 * @param $code
	 *
	 * @return string
	 */
	public function setCustomViewGetItems(&$get, $code)
	{
		$getItem = '';
		// set the site decrypt switch
		foreach (CFactory::_('Config')->cryption_types as $cryptionType)
		{
			CFactory::_('Compiler.Builder.Site.Decrypt')->set("{$cryptionType}.{$code}", false);
		}
		// set the component name
		$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
		// start load the get item
		if (ObjectHelper::check($get))
		{
			$getItem .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__)
				. " Insure all item fields are adapted where needed.";
			$getItem .= PHP_EOL . Indent::_(2) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items))";
			$getItem .= PHP_EOL . Indent::_(2) . "{";
			$getItem .= Placefix::_h("DISPATCHER") ;
			$getItem .= PHP_EOL . Indent::_(3)
				. "foreach (\$items as \$nr => &\$item)";
			$getItem .= PHP_EOL . Indent::_(3) . "{";
			$getItem .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Always create a slug for sef URL's";
			$getItem .= PHP_EOL . Indent::_(4)
				. "\$item->slug = (\$item->id ?? '0') . (isset(\$item->alias) ? ':' . \$item->alias : '');";
			if (isset($get->main_get)
				&& ArrayHelper::check(
					$get->main_get
				))
			{
				$asBucket = [];
				foreach ($get->main_get as $main_get)
				{
					// build path
					$path = $code . '.' . $main_get['key'] . '.' . $main_get['as'];

					$decodeChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->get('decode.' . $path);
					if (ArrayHelper::check($decodeChecker))
					{
						// set decoding of needed fields
						$getItem .= $this->setCustomViewFieldDecode(
							$main_get, $decodeChecker, "\$item", $code,
							Indent::_(2)
						);
					}

					// also filter fields if needed
					$decodeFilter = CFactory::_('Compiler.Builder.Site.Field.Decode.Filter')->
						get(CFactory::_('Config')->build_target . '.' . $path);
					if (ArrayHelper::check($decodeFilter))
					{
						$getItem .= $this->setCustomViewFieldDecodeFilter(
							$main_get, $decodeFilter, "\$item",
							'$items[$nr]', $code, Indent::_(2)
						);
					}

					$contentprepareChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->get('textareas.' . $path);
					if (ArrayHelper::check($contentprepareChecker))
					{
						// set contentprepare checkers on needed fields
						$getItem .= $this->setCustomViewFieldonContentPrepareChecker(
							$main_get, $contentprepareChecker, "\$item",
							$code, Indent::_(2)
						);
					}

					$uikitChecker = CFactory::_('Compiler.Builder.Site.Field.Data')->get('uikit.' . $path);
					if (ArrayHelper::check($uikitChecker))
					{
						// set uikit checkers on needed fields
						$getItem .= $this->setCustomViewFieldUikitChecker(
							$main_get, $uikitChecker, "\$item", $code,
							Indent::_(2)
						);
					}

					$asBucket[] = $main_get['as'];
				}
			}
			// only update if dispacher placholder is found
			if (strpos($getItem, (string) Placefix::_h('DISPATCHER'))
				!== false)
			{
				// check if the dispather should be added
				if (!isset($this->JEventDispatcher)
					|| !ArrayHelper::check(
						$this->JEventDispatcher
					))
				{
					$this->JEventDispatcher = array(Placefix::_h('DISPATCHER') => '');
				}
				$getItem = str_replace(
					array_keys($this->JEventDispatcher),
					array_values($this->JEventDispatcher), $getItem
				);
			}
			// setup Globals
			$getItem .= $this->setCustomViewGlobals(
				$get->global, '$item', $asBucket, Indent::_(2)
			);
			// setup the custom gets that returns multipal values
			$getItem .= $this->setCustomViewCustomJoin(
				$get->custom_get, "\$item", $code, $asBucket, Indent::_(2)
			);
			// set calculations
			if ($get->addcalculation == 1)
			{
				$get->php_calculation = (array) explode(
					PHP_EOL, (string) $get->php_calculation
				);
				if (ArrayHelper::check($get->php_calculation))
				{
					$_tmp    = PHP_EOL . Indent::_(4) . implode(
							PHP_EOL . Indent::_(4), $get->php_calculation
						);
					$getItem .= CFactory::_('Placeholder')->update_(
						$_tmp
					);
				}
			}
			$getItem .= PHP_EOL . Indent::_(3) . "}";
			$getItem .= PHP_EOL . Indent::_(2) . "}";
			// remove empty foreach
			if (strlen($getItem) <= 100)
			{
				$getItem = PHP_EOL;
			}
		}

		// set the script if found
		$script = '';
		foreach (CFactory::_('Config')->cryption_types as $cryptionType)
		{
			if (CFactory::_('Compiler.Builder.Site.Decrypt')->get("{$cryptionType}.{$code}", false))
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Get the " . $cryptionType
						. " encryption.";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $cryptionType
						. "key = " . $Component . "Helper::getCryptKey('"
						. $cryptionType . "');";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Get the encryption object.";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $cryptionType
						. " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$" . $cryptionType . "key);";
				}
				elseif (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
					exists("{$code}.get"))
				{
					foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
						get("{$code}.get") as $block)
					{
						$script .= PHP_EOL . Indent::_(2) . implode(
							PHP_EOL . Indent::_(2), $block
						);
					}
				}
			}
		}

		return $script . $getItem;
	}

	/**
	 * build code for the admin view display method
	 *
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 */
	public function setAdminViewDisplayMethod($nameListCode)
	{
		$script = '';
		// add the new filter methods for the search toolbar above the list view (2 = topbar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
		{
			$script .= PHP_EOL . Indent::_(2) . "//"
				. Line::_(
					__LINE__,__CLASS__
				) . " Load the filter form from xml.";
			$script .= PHP_EOL . Indent::_(2) . "\$this->filterForm "
				. "= \$this->get('FilterForm');";
			$script .= PHP_EOL . Indent::_(2) . "//"
				. Line::_(
					__LINE__,__CLASS__
				) . " Load the active filters.";
			$script .= PHP_EOL . Indent::_(2) . "\$this->activeFilters "
				. "= \$this->get('ActiveFilters');";
		}
		// get the default ordering values
		$default_ordering = $this->getListViewDefaultOrdering($nameListCode);
		// now add the default ordering
		$script .= PHP_EOL . Indent::_(2) . "//"
			. Line::_(
				__LINE__,__CLASS__
			) . " Add the list ordering clause.";
		$script .= PHP_EOL . Indent::_(2)
			. "\$this->listOrder = \$this->escape(\$this->state->get('list.ordering', '"
			. $default_ordering['name'] . "'));";
		$script .= PHP_EOL . Indent::_(2)
			. "\$this->listDirn = \$this->escape(\$this->state->get('list.direction', '"
			. $default_ordering['direction'] . "'));";

		return $script;
	}

	public function setCustomViewDisplayMethod(&$view)
	{
		$method = '';
		if (isset($view['settings']->main_get)
			&& ObjectHelper::check($view['settings']->main_get))
		{
			// add events if needed
			if ($view['settings']->main_get->gettype == 1
				&& ArrayHelper::check(
					$view['settings']->main_get->plugin_events
				))
			{
				// load the dispatcher
				$method .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Initialise dispatcher.";
				$method .= PHP_EOL . Indent::_(2)
					. "\$dispatcher = JEventDispatcher::getInstance();";
			}
			if ($view['settings']->main_get->gettype == 1)
			{
				// for single views
				$method .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Initialise variables.";
				$method .= PHP_EOL . Indent::_(2)
					. "\$this->item = \$this->get('Item');";
			}
			elseif ($view['settings']->main_get->gettype == 2)
			{
				// for list views
				$method .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Initialise variables.";
				$method .= PHP_EOL . Indent::_(2)
					. "\$this->items = \$this->get('Items');";
				// only add if pagination is requered
				if ($view['settings']->main_get->pagination == 1)
				{
					$method .= PHP_EOL . Indent::_(2)
						. "\$this->pagination = \$this->get('Pagination');";
				}
			}
			// add the custom get methods
			if (isset($view['settings']->custom_get)
				&& ArrayHelper::check(
					$view['settings']->custom_get
				))
			{
				foreach ($view['settings']->custom_get as $custom_get)
				{
					$custom_get_name = str_replace(
						'get', '', (string) $custom_get->getcustom
					);
					$method          .= PHP_EOL . Indent::_(2) . "\$this->"
						. StringHelper::safe($custom_get_name)
						. " = \$this->get('" . $custom_get_name . "');";
				}
			}
			// add custom script
			if ($view['settings']->add_php_jview_display == 1)
			{
				$view['settings']->php_jview_display = (array) explode(
					PHP_EOL, (string) $view['settings']->php_jview_display
				);
				if (ArrayHelper::check(
					$view['settings']->php_jview_display
				))
				{
					$_tmp   = PHP_EOL . Indent::_(2) . implode(
							PHP_EOL . Indent::_(2),
							$view['settings']->php_jview_display
						);
					$method .= CFactory::_('Placeholder')->update_(
						$_tmp
					);
				}
			}
			if ('site' === CFactory::_('Config')->build_target)
			{
				$method .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Set the toolbar";
				$method .= PHP_EOL . Indent::_(2) . "\$this->addToolBar();";
				$method .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Set the html view document stuff";
				$method .= PHP_EOL . Indent::_(2)
					. "\$this->_prepareDocument();";
			}
			elseif ('custom_admin' === CFactory::_('Config')->build_target)
			{
				$method .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__)
					. " We don't need toolbar in the modal window.";
				$method .= PHP_EOL . Indent::_(2)
					. "if (\$this->getLayout() !== 'modal')";
				$method .= PHP_EOL . Indent::_(2) . "{";
				$method .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " add the tool bar";
				$method .= PHP_EOL . Indent::_(3) . "\$this->addToolBar();";
				$method .= PHP_EOL . Indent::_(2) . "}";

				if (CFactory::_('Config')->get('joomla_version', 3) == 3)
				{
					$method .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " set the document";
					$method .= PHP_EOL . Indent::_(2) . "\$this->setDocument();";
				}
			}

			$method .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Check for errors.";
			$method .= PHP_EOL . Indent::_(2)
				. "if (count(\$errors = \$this->get('Errors')))";
			$method .= PHP_EOL . Indent::_(2) . "{";
			$method .= PHP_EOL . Indent::_(3)
				. "throw new \Exception(implode(PHP_EOL, \$errors), 500);";
			$method .= PHP_EOL . Indent::_(2) . "}";
			// add events if needed
			if ($view['settings']->main_get->gettype == 1
				&& ArrayHelper::check(
					$view['settings']->main_get->plugin_events
				))
			{
				$method .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Process the content plugins.";
				$method .= PHP_EOL . Indent::_(2) . "if ("
					. "Super_" . "__91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(\$this->item))";
				$method .= PHP_EOL . Indent::_(2) . "{";
				$method .= PHP_EOL . Indent::_(3)
					. "PluginHelper::importPlugin('content');";
				$method .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Setup Event Object.";
				$method .= PHP_EOL . Indent::_(3)
					. "\$this->item->event = new \stdClass;";
				$method .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Check if item has params, or pass global params";
				$method .= PHP_EOL . Indent::_(3)
					. "\$params = (isset(\$this->item->params) && "
					. "Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check(\$this->item->params)) ? json_decode(\$this->item->params) : \$this->params;";
				// load the defaults
				foreach (
					$view['settings']->main_get->plugin_events as $plugin_event
				)
				{
					// load the events
					if ('onContentPrepare' === $plugin_event)
					{
						// TODO the onContentPrepare already gets triggered on the fields of its relation
						// $method .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__) . " onContentPrepare Event Trigger.";
						// $method .= PHP_EOL . Indent::_(2) . "\$dispatcher->trigger('onContentPrepare', array ('com_" . CFactory::_('Config')->component_code_name . ".article', &\$this->item, &\$this->params, 0));";
					}
					else
					{
						$method .= PHP_EOL . Indent::_(3) . "//"
							. Line::_(__Line__, __Class__) . " " . $plugin_event
							. " Event Trigger.";
						$method .= PHP_EOL . Indent::_(3)
							. "\$results = \$dispatcher->trigger('"
							. $plugin_event . "', array('com_"
							. CFactory::_('Config')->component_code_name . "."
							. $view['settings']->context
							. "', &\$this->item, &\$params, 0));";
						$method .= PHP_EOL . Indent::_(3)
							. '$this->item->event->' . $plugin_event
							. ' = trim(implode("\n", $results));';
					}
				}
				$method .= PHP_EOL . Indent::_(2) . "}";
			}
			$method .= PHP_EOL . PHP_EOL . Indent::_(2)
				. "parent::display(\$tpl);";
		}

		return $method;
	}

	public function setPrepareDocument(&$view)
	{
		// fix just incase we missed it somewhere
		$tmp = CFactory::_('Config')->lang_target;
		if ('site' === CFactory::_('Config')->build_target)
		{
			CFactory::_('Config')->lang_target = 'site';
		}
		else
		{
			CFactory::_('Config')->lang_target = 'admin';
		}

		// ensure correct target is set
		$TARGET = StringHelper::safe(CFactory::_('Config')->build_target, 'U');

		// set libraries $TARGET.'_LIBRARIES_LOADER
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_LIBRARIES_LOADER',
			$this->setLibrariesLoader($view)
		);

		// set uikit $TARGET.'_UIKIT_LOADER
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_UIKIT_LOADER',
			$this->setUikitLoader($view)
		);

		// set Google Charts $TARGET.'_GOOGLECHART_LOADER
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' .$TARGET . '_GOOGLECHART_LOADER',
			$this->setGoogleChartLoader($view)
		);

		// set Footable FOOTABLE_LOADER
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_FOOTABLE_LOADER',
			$this->setFootableScriptsLoader($view)
		);

		// set metadata DOCUMENT_METADATA
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_DOCUMENT_METADATA',
			$this->setDocumentMetadata($view)
		);

		// set custom php scripting DOCUMENT_CUSTOM_PHP
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_DOCUMENT_CUSTOM_PHP',
			$this->setDocumentCustomPHP($view)
		);

		// set custom css DOCUMENT_CUSTOM_CSS
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' .$TARGET . '_DOCUMENT_CUSTOM_CSS',
			$this->setDocumentCustomCSS($view)
		);

		// set custom javascript DOCUMENT_CUSTOM_JS
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_DOCUMENT_CUSTOM_JS',
			$this->setDocumentCustomJS($view)
		);

		// set custom css file VIEWCSS
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_VIEWCSS',
			$this->setCustomCSS($view)
		);

		// incase no buttons are found
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|SITE_JAVASCRIPT_FOR_BUTTONS', '');

		// set the custom buttons CUSTOM_BUTTONS
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_CUSTOM_BUTTONS',
			$this->setCustomButtons($view)
		);

		// see if we should add get modules to the view.html
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_GET_MODULE',
			$this->setGetModules($view, $TARGET)
		);

		// set a JavaScript file if needed
		CFactory::_('Compiler.Builder.Content.Multi')->add($view['settings']->code . '|' . $TARGET . '_LIBRARIES_LOADER',
			$this->setJavaScriptFile($view, $TARGET), false
		);
		// fix just incase we missed it somewhere
		CFactory::_('Config')->lang_target = $tmp;
	}

	public function setGetModules($view, $TARGET)
	{
		if (CFactory::_('Compiler.Builder.Get.Module')->
			exists(CFactory::_('Config')->build_target . '.' . $view['settings']->code))
		{
			$addModule   = [];
			$addModule[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$addModule[] = Indent::_(1)
				. " * Get the modules published in a position";
			$addModule[] = Indent::_(1) . " */";
			$addModule[] = Indent::_(1)
				. "public function getModules(\$position, \$seperator = '', \$class = '')";
			$addModule[] = Indent::_(1) . "{";
			$addModule[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set default";
			$addModule[] = Indent::_(2) . "\$found = false;";
			$addModule[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if we aleady have these modules loaded";
			$addModule[] = Indent::_(2)
				. "if (isset(\$this->setModules[\$position]))";
			$addModule[] = Indent::_(2) . "{";
			$addModule[] = Indent::_(3) . "\$found = true;";
			$addModule[] = Indent::_(2) . "}";
			$addModule[] = Indent::_(2) . "else";
			$addModule[] = Indent::_(2) . "{";
			$addModule[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " this is where you want to load your module position";
			$addModule[] = Indent::_(3)
				. "\$modules = ModuleHelper::getModules(\$position);";
			$addModule[] = Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$modules, true))";
			$addModule[] = Indent::_(3) . "{";
			$addModule[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " set the place holder";
			$addModule[] = Indent::_(4)
				. "\$this->setModules[\$position] = [];";
			$addModule[] = Indent::_(4) . "foreach(\$modules as \$module)";
			$addModule[] = Indent::_(4) . "{";
			$addModule[] = Indent::_(5)
				. "\$this->setModules[\$position][] = ModuleHelper::renderModule(\$module);";
			$addModule[] = Indent::_(4) . "}";
			$addModule[] = Indent::_(4) . "\$found = true;";
			$addModule[] = Indent::_(3) . "}";
			$addModule[] = Indent::_(2) . "}";
			$addModule[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if modules were found";
			$addModule[] = Indent::_(2)
				. "if (\$found && isset(\$this->setModules[\$position]) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->setModules[\$position]))";
			$addModule[] = Indent::_(2) . "{";
			$addModule[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " set class";
			$addModule[] = Indent::_(3) . "if ("
				. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$class))";
			$addModule[] = Indent::_(3) . "{";
			$addModule[] = Indent::_(4)
				. "\$class = ' class=\"'.\$class.'\" ';";
			$addModule[] = Indent::_(3) . "}";
			$addModule[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " set seperating return values";
			$addModule[] = Indent::_(3) . "switch(\$seperator)";
			$addModule[] = Indent::_(3) . "{";
			$addModule[] = Indent::_(4) . "case 'none':";
			$addModule[] = Indent::_(5)
				. "return implode('', \$this->setModules[\$position]);";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "case 'div':";
			$addModule[] = Indent::_(5)
				. "return '<div'.\$class.'>'.implode('</div><div'.\$class.'>', \$this->setModules[\$position]).'</div>';";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "case 'list':";
			$addModule[] = Indent::_(5)
				. "return '<ul'.\$class.'><li>'.implode('</li><li>', \$this->setModules[\$position]).'</li></ul>';";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "case 'array':";
			$addModule[] = Indent::_(4) . "case 'Array':";
			$addModule[] = Indent::_(5)
				. "return \$this->setModules[\$position];";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "default:";
			$addModule[] = Indent::_(5)
				. "return implode('<br />', \$this->setModules[\$position]);";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(3) . "}";
			$addModule[] = Indent::_(2) . "}";
			$addModule[] = Indent::_(2) . "return false;";
			$addModule[] = Indent::_(1) . "}";

			CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_GET_MODULE_JIMPORT',
				PHP_EOL . "use Joomla\CMS\Helper\ModuleHelper;"
			);

			return implode(PHP_EOL, $addModule);
		}
		CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET . '_GET_MODULE_JIMPORT', '');

		return '';
	}

	public function setDocumentCustomPHP(&$view)
	{
		if ($view['settings']->add_php_document == 1)
		{
			$view['settings']->php_document = (array) explode(
				PHP_EOL, (string) $view['settings']->php_document
			);
			if (ArrayHelper::check(
				$view['settings']->php_document
			))
			{
				$_tmp = PHP_EOL . Indent::_(2) . implode(
					PHP_EOL . Indent::_(2), $view['settings']->php_document
				);

				return CFactory::_('Placeholder')->update_($_tmp);
			}
		}

		return '';
	}

	public function setCustomButtons(&$view, $type = 1, $tab = '')
	{
		// do not validate selection
		$validateSelection = 'false';
		// ensure correct target is set
		$TARGET = StringHelper::safe(CFactory::_('Config')->build_target, 'U');
		if (1 == $type || 2 == $type)
		{
			if (1 == $type)
			{
				$viewCodeName = $view['settings']->code;
			}
			if (2 == $type)
			{
				$viewCodeName = $view['settings']->name_single_code;
			}
		}
		elseif (3 == $type)
		{
			// set the names
			$viewCodeName  = $view['settings']->name_single_code;
			$viewsCodeName = $view['settings']->name_list_code;
			// if it's not been set before
			if (!CFactory::_('Compiler.Builder.Content.Multi')->exists($viewsCodeName . '|' . $TARGET . '_CUSTOM_BUTTONS_METHOD_LIST'))
			{
				// set the custom buttons CUSTOM_BUTTONS_CONTROLLER_LIST
				CFactory::_('Compiler.Builder.Content.Multi')->set($viewsCodeName . '|' . $TARGET . '_CUSTOM_BUTTONS_CONTROLLER_LIST', '');
				// set the custom buttons CUSTOM_BUTTONS_METHOD_LIST
				CFactory::_('Compiler.Builder.Content.Multi')->set($viewsCodeName . '|' . $TARGET . '_CUSTOM_BUTTONS_METHOD_LIST', '');
			}
			// validate selection
			$validateSelection = 'true';
		}
		// if it's not been set before
		if (!CFactory::_('Compiler.Builder.Content.Multi')->exists($viewCodeName . '|' . $TARGET . '_CUSTOM_BUTTONS_METHOD'))
		{
			// set the custom buttons CUSTOM_BUTTONS_CONTROLLER
			CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|' . $TARGET . '_CUSTOM_BUTTONS_CONTROLLER', '');
			// set the custom buttons CUSTOM_BUTTONS_METHOD
			CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|' . $TARGET . '_CUSTOM_BUTTONS_METHOD', '');
		}
		// reset buttons
		$buttons = [];
		// if site add buttons to view
		if (CFactory::_('Config')->build_target === 'site')
		{
			// set the custom buttons SITE_TOP_BUTTON
			CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|SITE_TOP_BUTTON', '');
			// set the custom buttons SITE_BOTTOM_BUTTON
			CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|SITE_BOTTOM_BUTTON', '');
			// load into place
			switch ($view['settings']->button_position)
			{
				case 1:
					// set buttons to top right of the view
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|SITE_TOP_BUTTON',
						'<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>'
					);
					break;
				case 2:
					// set buttons to top left of the view
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|SITE_TOP_BUTTON', '<?php echo $this->toolbar->render(); ?>');
					break;
				case 3:
					// set buttons to buttom right of the view
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|SITE_BOTTOM_BUTTON',
						'<div class="uk-clearfix"><div class="uk-float-right"><?php echo $this->toolbar->render(); ?></div></div>'
					);
					break;
				case 4:
					// set buttons to buttom left of the view
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|SITE_BOTTOM_BUTTON', '<?php echo $this->toolbar->render(); ?>');
					break;
				case 5:
					// set buttons to custom placement of the view
					CFactory::_('Placeholder')->set_('SITE_TOOLBAR',
						'<?php echo $this->toolbar->render(); ?>');
					break;
			}
		}
		// add some buttons if custom admin view
		elseif (1 == $type)
		{
			// add this button only if this is not the default view
			$dynamic_dashboard = CFactory::_('Registry')->get('build.dashboard', '');
			$dynamic_dashboard_type = CFactory::_('Registry')->get('build.dashboard.type', '');
			if ($dynamic_dashboard_type !== 'custom_admin_views'
				|| ($dynamic_dashboard_type === 'custom_admin_views'
					&& $dynamic_dashboard !== $viewCodeName))
			{
				$buttons[] = $tab . Indent::_(2)
					. "//" . Line::_(__Line__, __Class__) . " add cpanel button";
				$buttons[] = $tab . Indent::_(2)
					. "ToolbarHelper::custom('" . $viewCodeName . "."
					. "dashboard', 'grid-2', '', 'COM_"
					. CFactory::_('Compiler.Builder.Content.One')->get('COMPONENT')
					. "_DASH', false);";
			}
		}
		// check if custom button should be added
		if (isset($view['settings']->add_custom_button)
			&& $view['settings']->add_custom_button == 1)
		{
			$this->onlyFunctionButton = [];
			$functionNames            = [];
			if (isset($view['settings']->custom_buttons)
				&& ArrayHelper::check(
					$view['settings']->custom_buttons
				))
			{
				foreach ($view['settings']->custom_buttons as $custom_button)
				{
					// Load to lang
					$keyLang = CFactory::_('Config')->lang_prefix . '_'
						. StringHelper::safe(
							$custom_button['name'], 'U'
						);
					$keyCode = StringHelper::safe(
						$custom_button['name']
					);
					CFactory::_('Language')->set(
						CFactory::_('Config')->lang_target, $keyLang, $custom_button['name']
					);
					// load the button
					if (3 !== $type
						&& ($custom_button['target'] != 2
							|| CFactory::_('Config')->build_target === 'site'))
					{
						// add cpanel button TODO does not work well on site with permissions
						if ($custom_button['target'] == 2
							|| CFactory::_('Config')->build_target === 'site')
						{
							$buttons[] = Indent::_(1) . $tab . Indent::_(1)
								. "if (\$this->user->authorise('"
								. $viewCodeName
								. "." . $keyCode . "', 'com_"
								. CFactory::_('Config')->component_code_name . "'))";
						}
						else
						{
							$buttons[] = Indent::_(1) . $tab . Indent::_(1)
								. "if (\$this->canDo->get('" . $viewCodeName
								. "."
								. $keyCode . "'))";
						}
						$buttons[] = Indent::_(1) . $tab . Indent::_(1) . "{";
						$buttons[] = Indent::_(1) . $tab . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__) . " add "
							. $custom_button['name'] . " button.";
						$buttons[] = Indent::_(1) . $tab . Indent::_(2)
							. "ToolbarHelper::custom('" . $viewCodeName . "."
							. $custom_button['method'] . "', '"
							. $custom_button['icomoon'] . " custom-button-"
							. strtolower((string) $custom_button['method']) . "', '', '"
							. $keyLang
							. "', false);";
						$buttons[] = Indent::_(1) . $tab . Indent::_(1) . "}";
					}
					// load the list button
					elseif (3 == $type && $custom_button['target'] != 1)
					{
						// This is only for list admin views
						if (isset($custom_button['type'])
							&& $custom_button['type'] == 2)
						{
							if (!isset($this->onlyFunctionButton[$viewsCodeName]))
							{
								$this->onlyFunctionButton[$viewsCodeName]
									= [];
							}
							$this->onlyFunctionButton[$viewsCodeName][]
								= Indent::_(
									1
								) . $tab . "if (\$this->user->authorise('"
								. $viewCodeName . "." . $keyCode . "', 'com_"
								. CFactory::_('Config')->component_code_name . "'))";
							$this->onlyFunctionButton[$viewsCodeName][]
								= Indent::_(
									1
								) . $tab . "{";
							$this->onlyFunctionButton[$viewsCodeName][]
								= Indent::_(
									1
								) . $tab . Indent::_(1) . "//" . Line::_(
									__LINE__,__CLASS__
								) . " add " . $custom_button['name']
								. " button.";
							$this->onlyFunctionButton[$viewsCodeName][]
								= Indent::_(
									1
								) . $tab . Indent::_(1)
								. "ToolbarHelper::custom('" . $viewsCodeName
								. "."
								. $custom_button['method'] . "', '"
								. $custom_button['icomoon'] . " custom-button-"
								. strtolower((string) $custom_button['method'])
								. "', '', '"
								. $keyLang . "', false);";
							$this->onlyFunctionButton[$viewsCodeName][]
								= Indent::_(
									1
								) . $tab . "}";
						}
						else
						{
							$buttons[] = Indent::_(1) . $tab . Indent::_(1)
								. "if (\$this->user->authorise('"
								. $viewCodeName
								. "." . $keyCode . "', 'com_"
								. CFactory::_('Config')->component_code_name . "'))";
							$buttons[] = Indent::_(1) . $tab . Indent::_(1)
								. "{";
							$buttons[] = Indent::_(1) . $tab . Indent::_(2)
								. "//" . Line::_(__Line__, __Class__) . " add "
								. $custom_button['name'] . " button.";
							$buttons[] = Indent::_(1) . $tab . Indent::_(2)
								. "ToolbarHelper::custom('" . $viewsCodeName
								. "."
								. $custom_button['method'] . "', '"
								. $custom_button['icomoon'] . " custom-button-"
								. strtolower((string) $custom_button['method'])
								. "', '', '"
								. $keyLang . "', '" . $validateSelection
								. "');";
							$buttons[] = Indent::_(1) . $tab . Indent::_(1)
								. "}";
						}
					}
				}
			}
			// load the model and controller
			if (3 == $type)
			{
				// insure the controller and model strings are added
				if (isset($view['settings']->php_controller_list)
					&& StringHelper::check(
						$view['settings']->php_controller_list
					)
					&& $view['settings']->php_controller_list != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_CONTROLLER
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewsCodeName . '|' . $TARGET . '_CUSTOM_BUTTONS_CONTROLLER_LIST',
						PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
							$view['settings']->php_controller_list
						));
				}
				// load the model
				if (isset($view['settings']->php_model_list)
					&& StringHelper::check(
						$view['settings']->php_model_list
					)
					&& $view['settings']->php_model_list != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_METHOD
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewsCodeName . '|' . $TARGET
						. '_CUSTOM_BUTTONS_METHOD_LIST', PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
							$view['settings']->php_model_list
						));
				}
			}
			else
			{
				// insure the controller and model strings are added
				if (StringHelper::check(
						$view['settings']->php_controller
					)
					&& $view['settings']->php_controller != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_CONTROLLER
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|' . $TARGET
						. '_CUSTOM_BUTTONS_CONTROLLER', PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
							$view['settings']->php_controller
						));
					if ('site' === CFactory::_('Config')->build_target)
					{
						// add the controller for this view
						// build the file
						$target = array(CFactory::_('Config')->build_target => $viewCodeName);
						CFactory::_('Utilities.Structure')->build($target, 'custom_form');
						// GET_FORM_CUSTOM
					}
				}
				// load the model
				if (StringHelper::check(
						$view['settings']->php_model
					) && $view['settings']->php_model != '//')
				{
					// set the custom buttons CUSTOM_BUTTONS_METHOD
					CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|' . $TARGET
						. '_CUSTOM_BUTTONS_METHOD', PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
							$view['settings']->php_model
						)
					);
				}
			}
		}
		// return buttons if they were build
		if (ArrayHelper::check($buttons))
		{
			// just to check if the submission script is manually added
			if (!isset($view['settings']->php_document)
				|| (ArrayHelper::check(
						$view['settings']->php_document
					)
					&& strpos(
						implode(' ', $view['settings']->php_document),
						'/submitbutton.js'
					) === false)
				|| (StringHelper::check(
						$view['settings']->php_document
					)
					&& strpos(
						(string) $view['settings']->php_document,
						'/submitbutton.js'
					) === false))
			{
				// set the custom get form method  JAVASCRIPT_FOR_BUTTONS
				CFactory::_('Compiler.Builder.Content.Multi')->set($viewCodeName . '|' . $TARGET
					. '_JAVASCRIPT_FOR_BUTTONS', $this->setJavaScriptForButtons()
				);
			}
			// insure the form is added (only if no form exist)
			if (isset($view['settings']->default)
				&& strpos(
					(string) $view['settings']->default, '<form'
				) === false)
			{
				$this->addCustomForm[CFactory::_('Config')->build_target][$viewCodeName]
					= true;
			}

			return PHP_EOL . implode(PHP_EOL, $buttons);
		}

		return '';
	}

	public function setJavaScriptForButtons()
	{
		// add behavior.framework to insure Joomla function is on the page
		$script   = [];
		$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Add the needed Javascript to insure that the buttons work.";
		$script[] = Indent::_(2) . "Html::_('behavior.framework', true);";
		$script[] = Indent::_(2)
			. "\$this->getDocument()->addScriptDeclaration(\"Joomla.submitbutton = function(task){if (task == ''){ return false; } else { Joomla.submitform(task); return true; }}\");";

		// return the script
		return PHP_EOL . implode(PHP_EOL, $script);
	}

	public function setFunctionOnlyButtons($nameListCode)
	{
		// return buttons if they were build
		if (isset($this->onlyFunctionButton[$nameListCode])
			&& ArrayHelper::check(
				$this->onlyFunctionButton[$nameListCode]
			))
		{
			return PHP_EOL . implode(
					PHP_EOL, $this->onlyFunctionButton[$nameListCode]
				);
		}

		return '';
	}

	public function setCustomCSS(&$view)
	{
		if ($view['settings']->add_css == 1)
		{
			if (StringHelper::check($view['settings']->css))
			{
				return CFactory::_('Placeholder')->update_(
					$view['settings']->css
				);
			}
		}

		return '';
	}

	public function setDocumentCustomCSS(&$view)
	{
		if ($view['settings']->add_css_document == 1)
		{
			$view['settings']->css_document = (array) explode(
				PHP_EOL, (string) $view['settings']->css_document
			);
			if (ArrayHelper::check(
				$view['settings']->css_document
			))
			{
				$script      = PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Set the Custom CSS script to view" . PHP_EOL
					. Indent::_(2) . '$this->document->addStyleDeclaration("';
				$cssDocument = PHP_EOL . Indent::_(3) . str_replace(
						'"', '\"', implode(
							PHP_EOL . Indent::_(3),
							$view['settings']->css_document
						)
					);

				return $script . CFactory::_('Placeholder')->update_(
						$cssDocument
					) . PHP_EOL . Indent::_(2) . '");';
			}
		}

		return '';
	}

	public function setJavaScriptFile(&$view, $TARGET)
	{
		if ($view['settings']->add_javascript_file == 1
			&& StringHelper::check(
				$view['settings']->javascript_file
			))
		{
			// get dates
			$created  = CFactory::_('Model.Createdate')->get($view);
			$modified = CFactory::_('Model.Modifieddate')->get($view);
			// add file to view
			$target = array(CFactory::_('Config')->build_target => $view['settings']->code);
			$config = array(Placefix::_h('CREATIONDATE')                          => $created,
				Placefix::_h('BUILDDATE') => $modified,
				Placefix::_h('VERSION')                          => $view['settings']->version);
			CFactory::_('Utilities.Structure')->build($target, 'javascript_file', false, $config);
			// set path
			if ('site' === CFactory::_('Config')->build_target)
			{
				$path = '/components/com_' . CFactory::_('Config')->component_code_name
					. '/assets/js/' . $view['settings']->code . '.js';
			}
			else
			{
				$path = '/administrator/components/com_'
					. CFactory::_('Config')->component_code_name . '/assets/js/'
					. $view['settings']->code . '.js';
			}
			// add script to file
			CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '|' . $TARGET
				. '_JAVASCRIPT_FILE', CFactory::_('Placeholder')->update_(
				$view['settings']->javascript_file
			));

			// add script to view
			return PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add View JavaScript File" . PHP_EOL . Indent::_(2)
				. $this->setIncludeLibScript($path);
		}

		return '';
	}

	public function setDocumentCustomJS(&$view)
	{
		if ($view['settings']->add_js_document == 1)
		{
			$view['settings']->js_document = (array) explode(
				PHP_EOL, (string) $view['settings']->js_document
			);
			if (ArrayHelper::check(
				$view['settings']->js_document
			))
			{
				$script     = PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Set the Custom JS script to view" . PHP_EOL
					. Indent::_(2) . '$this->getDocument()->addScriptDeclaration("';
				$jsDocument = PHP_EOL . Indent::_(3) . str_replace(
						'"', '\"', implode(
							PHP_EOL . Indent::_(3),
							$view['settings']->js_document
						)
					);

				return $script . CFactory::_('Placeholder')->update_(
						$jsDocument
					) . PHP_EOL . Indent::_(2) . '");';
			}
		}

		return '';
	}

	public function setFootableScriptsLoader(&$view)
	{
		if (CFactory::_('Compiler.Builder.Footable.Scripts')->
			exists(CFactory::_('Config')->build_target . '.' . $view['settings']->code))
		{
			return $this->setFootableScripts(false);
		}

		return '';
	}

	public function setDocumentMetadata(&$view)
	{
		if ($view['settings']->main_get->gettype == 1
			&& isset($view['metadata'])
			&& $view['metadata'] == 1)
		{
			return $this->setMetadataItem();
		}
		elseif (isset($view['metadata']) && $view['metadata'] == 1)
		{
			// lets check if we have a custom get method that has the same name as the view
			// if we do then it posibly can be that the metadata is loaded via that method
			// and we can load the full metadata structure with its vars
			if (isset($view['settings']->custom_get)
				&& ArrayHelper::check(
					$view['settings']->custom_get
				))
			{
				$found     = false;
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
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			return $this->setMetadataItemJ3($item);
		}
		return $this->setMetadataItemJ4($item);
	}

	public function setMetadataList()
	{
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			return $this->setMetadataListJ3();
		}
		return $this->setMetadataListJ4();
	}

	public function setMetadataItemJ3($item = 'item')
	{
		$meta   = [];
		$meta[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the meta description";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metadesc) && \$this->" . $item . "->metadesc)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . "\$this->document->setDescription(\$this->"
			. $item . "->metadesc);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2)
			. "elseif (\$this->params->get('menu-meta_description'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the key words if set";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metakey) && \$this->" . $item . "->metakey)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setMetadata('keywords', \$this->" . $item
			. "->metakey);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2)
			. "elseif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check the robot params";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->robots) && \$this->" . $item . "->robots)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setMetadata('robots', \$this->" . $item
			. "->robots);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "elseif (\$this->params->get('robots'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if autor is to be set";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->created_by) && \$this->params->get('MetaAuthor') == '1')";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setMetaData('author', \$this->" . $item
			. "->created_by);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if metadata is available";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metadata) && \$this->" . $item . "->metadata)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . "\$mdata = json_decode(\$this->" . $item
			. "->metadata,true);";
		$meta[] = Indent::_(3) . "foreach (\$mdata as \$k => \$v)";
		$meta[] = Indent::_(3) . "{";
		$meta[] = Indent::_(4) . "if (\$v)";
		$meta[] = Indent::_(4) . "{";
		$meta[] = Indent::_(5) . "\$this->document->setMetadata(\$k, \$v);";
		$meta[] = Indent::_(4) . "}";
		$meta[] = Indent::_(3) . "}";
		$meta[] = Indent::_(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	public function setMetadataListJ3()
	{
		$meta   = [];
		$meta[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the meta description";
		$meta[] = Indent::_(2)
			. "if (\$this->params->get('menu-meta_description'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the key words if set";
		$meta[] = Indent::_(2)
			. "if (\$this->params->get('menu-meta_keywords'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check the robot params";
		$meta[] = Indent::_(2) . "if (\$this->params->get('robots'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->document->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = Indent::_(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	public function setMetadataItemJ4($item = 'item')
	{
		$meta   = [];
		$meta[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the meta description";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metadesc) && \$this->" . $item . "->metadesc)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . "\$this->getDocument()->setDescription(\$this->"
			. $item . "->metadesc);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2)
			. "elseif (\$this->params->get('menu-meta_description'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the key words if set";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metakey) && \$this->" . $item . "->metakey)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setMetadata('keywords', \$this->" . $item
			. "->metakey);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2)
			. "elseif (\$this->params->get('menu-meta_keywords'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check the robot params";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->robots) && \$this->" . $item . "->robots)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setMetadata('robots', \$this->" . $item
			. "->robots);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "elseif (\$this->params->get('robots'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if autor is to be set";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->created_by) && \$this->params->get('MetaAuthor') == '1')";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setMetaData('author', \$this->" . $item
			. "->created_by);";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if metadata is available";
		$meta[] = Indent::_(2) . "if (isset(\$this->" . $item
			. "->metadata) && \$this->" . $item . "->metadata)";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3) . "\$mdata = json_decode(\$this->" . $item
			. "->metadata,true);";
		$meta[] = Indent::_(3) . "foreach (\$mdata as \$k => \$v)";
		$meta[] = Indent::_(3) . "{";
		$meta[] = Indent::_(4) . "if (\$v)";
		$meta[] = Indent::_(4) . "{";
		$meta[] = Indent::_(5) . "\$this->getDocument()->setMetadata(\$k, \$v);";
		$meta[] = Indent::_(4) . "}";
		$meta[] = Indent::_(3) . "}";
		$meta[] = Indent::_(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	public function setMetadataListJ4()
	{
		$meta   = [];
		$meta[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the meta description";
		$meta[] = Indent::_(2)
			. "if (\$this->params->get('menu-meta_description'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setDescription(\$this->params->get('menu-meta_description'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " load the key words if set";
		$meta[] = Indent::_(2)
			. "if (\$this->params->get('menu-meta_keywords'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setMetadata('keywords', \$this->params->get('menu-meta_keywords'));";
		$meta[] = Indent::_(2) . "}";
		$meta[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check the robot params";
		$meta[] = Indent::_(2) . "if (\$this->params->get('robots'))";
		$meta[] = Indent::_(2) . "{";
		$meta[] = Indent::_(3)
			. "\$this->getDocument()->setMetadata('robots', \$this->params->get('robots'));";
		$meta[] = Indent::_(2) . "}";

		return implode(PHP_EOL, $meta);
	}

	public function setGoogleChartLoader(&$view)
	{
		if (CFactory::_('Compiler.Builder.Google.Chart')->
			exists(CFactory::_('Config')->build_target . '.' . $view['settings']->code))
		{
			$chart   = [];
			$chart[] = PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " add the google chart builder class.";
			$chart[] = Indent::_(2)
				. "require_once JPATH_COMPONENT_ADMINISTRATOR.'/helpers/chartbuilder.php';";
			$chart[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " load the google chart js.";
			$chart[] = Indent::_(2)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name . "/js/google.jsapi.js', ['version' => 'auto']);";
			$chart[] = Indent::_(2)
				. "Html::_('script', 'https://canvg.googlecode.com/svn/trunk/rgbcolor.js', ['version' => 'auto']);";
			$chart[] = Indent::_(2)
				. "Html::_('script', 'https://canvg.googlecode.com/svn/trunk/canvg.js', ['version' => 'auto']);";

			return implode(PHP_EOL, $chart);
		}

		return '';
	}

	public function setLibrariesLoader($view)
	{
		// check call sig
		if (isset($view['settings']) && isset($view['settings']->code))
		{
			$code        = $view['settings']->code;
			$view_active = true;
		}
		elseif (isset($view->code_name))
		{
			$code        = $view->code_name;
			$view_active = false;
		}
		// reset bucket
		$setter = '';
		// always load these in
		if ($view_active)
		{
			$setter .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Only load jQuery if needed. (default is true)";
			$setter .= PHP_EOL . Indent::_(2) . "if (\$this->params->get('add_jquery_framework', 1) == 1)";
			$setter .= PHP_EOL . Indent::_(2) . "{";
			$setter .= PHP_EOL . Indent::_(3) . "Html::_('jquery.framework');";
			$setter .= PHP_EOL . Indent::_(2) . "}";
			$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Load the header checker class.";

			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				if (CFactory::_('Config')->build_target === 'site')
				{
					$setter .= PHP_EOL . Indent::_(2)
						. "require_once( JPATH_COMPONENT_SITE.'/helpers/headercheck.php' );";
				}
				else
				{
					$setter .= PHP_EOL . Indent::_(2)
						. "require_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/headercheck.php' );";
				}
				$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Initialize the header checker.";
				$setter .= PHP_EOL . Indent::_(2) . "\$HeaderCheck = new "
					. CFactory::_('Config')->component_code_name . "HeaderCheck();";
			}
			else
			{
				$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Initialize the header checker.";
				$setter .= PHP_EOL . Indent::_(2) . "\$HeaderCheck = new HeaderCheck();";
			}
		}
		// check if this view should get libraries
		if (($data = CFactory::_('Compiler.Builder.Library.Manager')->
			get(CFactory::_('Config')->build_target . '.' . $code)) !== null)
		{
			foreach ($data as $id => $true)
			{
				// get the library
				$library = CFactory::_('Registry')->get("builder.libraries.$id", null);
				if (is_object($library) && isset($library->document)
					&& StringHelper::check($library->document))
				{
					$setter .= PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
							str_replace(
								[
									'$document->',
									'$this->document->'
								],
								'$this->getDocument()->',
								(string) $library->document
							)
						);
				}
				elseif (is_object($library)
					&& isset($library->how))
				{
					$setter .= $this->setLibraryDocument($id);
				}
			}
		}
		// convert back to $document if module call (oops :)
		if (!$view_active)
		{
			return str_replace(['$this->getDocument()->', '$this->document->'], '$document->', $setter);
		}

		return $setter;
	}

	protected function setLibraryDocument($id)
	{
		// get the library
		$library = CFactory::_('Registry')->get("builder.libraries.$id", null);
		// make sure we have an object
		if (is_object($library))
		{
			if (isset($library->how) && 2 == $library->how
				&& isset($library->conditions)
				&& ArrayHelper::check(
					$library->conditions
				))
			{
				// build document with the conditions values
				$this->setLibraryDocConditions(
					$id, $this->setLibraryScripts($id, false)
				);
			}
			elseif (isset($library->how) && 1 == $library->how)
			{
				// build document to allways add all files and urls
				$this->setLibraryScripts($id);
			}
			// check if the document was build
			if (isset($library->document)
				&& StringHelper::check(
					$library->document
				))
			{
				return PHP_EOL . PHP_EOL . $library->document;
			}
		}

		return '';
	}

	protected function setLibraryDocConditions($id, $scripts)
	{
		// Start script builder for library files
		if (!isset($this->libwarning[$id]))
		{
			// set the warning only once
			$this->libwarning[$id] = true;

			// get the library
			$library = CFactory::_('Registry')->get("builder.libraries.$id", null);

			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREECONDITIONAL_SCRIPT_WARNINGHTHREE'), 'Warning'
			);

			// message with name
			if (is_object($library) && isset($library->name))
			{
				$this->app->enqueueMessage(
					Text::sprintf(
						'The conditional script builder for <b>%s</b> is not ready, sorry!',
						$library->name
					), 'Warning'
				);
			}
			else
			{
				$this->app->enqueueMessage(
					Text::_(
						'The conditional script builder for ID:<b>%s</b> is not ready, sorry!',
						$id
					), 'Warning'
				);
			}
		}
	}

	protected function setLibraryScripts($id, $buildDoc = true)
	{
		$scripts = [];
		// get the library
		$library = CFactory::_('Registry')->get("builder.libraries.$id", null);
		// check that we have a library
		if (is_object($library))
		{
			// load the urls if found
			if (isset($library->urls)
				&& ArrayHelper::check($library->urls))
			{
				// set all the files
				foreach ($library->urls as $url)
				{
					// if local path is set, then use it first
					if (isset($url['path']))
					{
						// update the root path
						$path = $this->getScriptRootPath($url['path']);
						// load document script
						$scripts[md5((string) $url['path'])] = $this->setIncludeLibScript(
							$path
						);
						// load url also if not building document
						if (!$buildDoc)
						{
							// load document script
							$scripts[md5((string) $url['url'])] = $this->setIncludeLibScript(
								$url['url'], false
							);
						}
					}
					else
					{
						// load document script
						$scripts[md5((string) $url['url'])] = $this->setIncludeLibScript(
							$url['url'], false
						);
					}
				}
			}
			// load the local files if found
			if (isset($library->files)
				&& ArrayHelper::check($library->files))
			{
				// set all the files
				foreach ($library->files as $file)
				{
					$path = '/' . trim((string) $file['path'], '/');
					// check if path has new file name (has extetion)
					$pathInfo = pathinfo($path);
					// update the root path
					$_path = $this->getScriptRootPath($path);
					if (isset($pathInfo['extension']) && $pathInfo['extension'])
					{
						// load document script
						$scripts[md5($path)] = $this->setIncludeLibScript(
							$_path, false, $pathInfo
						);
					}
					else
					{
						// load document script
						$scripts[md5($path . '/' . trim((string) $file['file'], '/'))]
							= $this->setIncludeLibScript(
							$_path . '/' . trim((string) $file['file'], '/')
						);
					}
				}
			}
			// load the local folders if found
			if (isset($library->folders)
				&& ArrayHelper::check(
					$library->folders
				))
			{
				// get all the file paths
				$files = [];
				foreach ($library->folders as $folder)
				{
					if (isset($folder['path']) && isset($folder['folder']))
					{
						$path = '/' . trim((string)$folder['path'], '/');
						if (isset($folder['rename']) && 1 == $folder['rename'])
						{
							if ($_paths = FileHelper::getPaths(
								CFactory::_('Utilities.Paths')->component_path . $path
							))
							{
								$files[$path] = $_paths;
							}
						}
						else
						{
							$path = $path . '/' . trim((string)$folder['folder'], '/');
							if ($_paths = FileHelper::getPaths(
								CFactory::_('Utilities.Paths')->component_path . $path
							))
							{
								$files[$path] = $_paths;
							}
						}
					}
				}
				// now load the script
				if (ArrayHelper::check($files))
				{
					foreach ($files as $root => $paths)
					{
						// update the root path
						$_root = $this->getScriptRootPath($root);
						// load per path
						foreach ($paths as $path)
						{
							$scripts[md5($root . '/' . trim((string)$path, '/'))]
								= $this->setIncludeLibScript(
								$_root . '/' . trim((string)$path, '/')
							);
						}
					}
				}
			}
		}

		// if there was any code added to document then set globally
		if ($buildDoc && ArrayHelper::check($scripts))
		{
			CFactory::_('Registry')->set("builder.libraries.${id}.document", Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " always load these files."
				. PHP_EOL . Indent::_(2) . implode(
					PHP_EOL . Indent::_(2), $scripts
				)
			);

			// success
			return true;
		}
		elseif (ArrayHelper::check($scripts))
		{
			return $scripts;
		}

		return false;
	}

	protected function setIncludeLibScript($path, $local = true,
	                                       $pathInfo = false
	)
	{
		// insure we have the path info
		if (!$pathInfo)
		{
			$pathInfo = pathinfo((string) $path);
		}
		// use the path info to build the script
		if (isset($pathInfo['extension']) && $pathInfo['extension'])
		{
			switch ($pathInfo['extension'])
			{
				case 'js':
					return 'Html::_(\'script\', "' . ltrim($path, '/')
						. '", [\'version\' => \'auto\']);';
					break;
				case 'css':
				case 'less':
					return 'Html::_(\'stylesheet\', "'
						. ltrim($path, '/') . '", [\'version\' => \'auto\']);';
					break;
				case 'php':
					if (strpos((string) $path, 'http') === false)
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
		if (strpos((string) $root, '/media/') !== false
			&& strpos((string) $root, '/admin/') === false
			&& strpos((string) $root, '/site/') === false)
		{
			return str_replace(
				'/media/', '/media/com_' . CFactory::_('Config')->component_code_name . '/', (string) $root
			);
		}
		elseif (strpos((string) $root, '/media/') === false
			&& strpos((string) $root, '/admin/') !== false
			&& strpos((string) $root, '/site/') === false)
		{
			return str_replace(
				'/admin/',
				'/administrator/components/com_' . CFactory::_('Config')->component_code_name
				. '/', (string) $root
			);
		}
		elseif (strpos((string) $root, '/media/') === false
			&& strpos((string) $root, '/admin/') === false
			&& strpos((string) $root, '/site/') !== false)
		{
			return str_replace(
				'/site/', '/components/com_' . CFactory::_('Config')->component_code_name . '/',
				(string) $root
			);
		}

		return $root;
	}

	public function setUikitLoader(&$view)
	{
		// reset setter
		$setter = '';
		// load the defaults needed
		if (CFactory::_('Config')->uikit > 0)
		{
			$setter .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Load uikit options.";
			$setter .= PHP_EOL . Indent::_(2)
				. "\$uikit = \$this->params->get('uikit_load');";
			$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Set script size.";
			$setter .= PHP_EOL . Indent::_(2)
				. "\$size = \$this->params->get('uikit_min');";
			$tabV   = "";
			// if both versions should be loaded then add some more logic
			if (2 == CFactory::_('Config')->uikit)
			{
				$setter .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Load uikit version.";
				$setter .= PHP_EOL . Indent::_(2)
					. "\$this->uikitVersion = \$this->params->get('uikit_version', 2);";
				$setter .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Use Uikit Version 2";
				$setter .= PHP_EOL . Indent::_(2)
					. "if (2 == \$this->uikitVersion)";
				$setter .= PHP_EOL . Indent::_(2) . "{";
				$tabV   = Indent::_(1);
			}
		}
		// load the defaults needed
		if (2 == CFactory::_('Config')->uikit || 1 == CFactory::_('Config')->uikit)
		{
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Set css style.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "\$style = \$this->params->get('uikit_style');";

			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " The uikit css.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/css/uikit'.\$style.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " The uikit js.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/js/uikit'.\$size.'.js', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
		}
		// load the components need
		if ((2 == CFactory::_('Config')->uikit || 1 == CFactory::_('Config')->uikit)
			&& ($data_ = CFactory::_('Compiler.Builder.Uikit.Comp')->get($view['settings']->code)) !== null)
		{
			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__)
				. " Load the script to find all uikit components needed.";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "if (\$uikit != 2)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Set the default uikit components in this view.";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "\$uikitComp = [];";
			foreach ($data_ as $class)
			{
				$setter .= PHP_EOL . $tabV . Indent::_(3) . "\$uikitComp[] = '"
					. $class . "';";
			}
			// check content for more needed components
			if (CFactory::_('Compiler.Builder.Site.Field.Data')->exists('uikit.' . $view['settings']->code))
			{
				$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__)
					. " Get field uikit components needed in this view.";
				$setter .= PHP_EOL . $tabV . Indent::_(3)
					. "\$uikitFieldComp = \$this->get('UikitComp');";
				$setter .= PHP_EOL . $tabV . Indent::_(3)
					. "if (isset(\$uikitFieldComp) && "
					. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitFieldComp))";
				$setter .= PHP_EOL . $tabV . Indent::_(3) . "{";
				$setter .= PHP_EOL . $tabV . Indent::_(4)
					. "if (isset(\$uikitComp) && "
					. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitComp))";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
				$setter .= PHP_EOL . $tabV . Indent::_(5)
					. "\$uikitComp = array_merge(\$uikitComp, \$uikitFieldComp);";
				$setter .= PHP_EOL . $tabV . Indent::_(5)
					. "\$uikitComp = array_unique(\$uikitComp);";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "else";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
				$setter .= PHP_EOL . $tabV . Indent::_(5)
					. "\$uikitComp = \$uikitFieldComp;";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
				$setter .= PHP_EOL . $tabV . Indent::_(3) . "}";
			}
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__)
				. " Load the needed uikit components in this view.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if (\$uikit != 2 && isset(\$uikitComp) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitComp))";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " loading...";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "foreach (\$uikitComp as \$class)";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "foreach ("
				. CFactory::_('Compiler.Builder.Content.One')->get('Component') . "Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the CSS file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the css.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the JavaScript file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the js.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
		}
		elseif ((2 == CFactory::_('Config')->uikit || 1 == CFactory::_('Config')->uikit)
			&& CFactory::_('Compiler.Builder.Site.Field.Data')->exists('uikit.' . $view['settings']->code))
		{
			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__)
				. " Load the needed uikit components in this view.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "\$uikitComp = \$this->get('UikitComp');";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if (\$uikit != 2 && isset(\$uikitComp) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitComp))";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " loading...";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "foreach (\$uikitComp as \$class)";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "foreach ("
				. CFactory::_('Compiler.Builder.Content.One')->get('Component') . "Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the CSS file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the css.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the JavaScript file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the js.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
		}
		// now set the version 3
		if (2 == CFactory::_('Config')->uikit || 3 == CFactory::_('Config')->uikit)
		{
			if (2 == CFactory::_('Config')->uikit)
			{
				$setter .= PHP_EOL . Indent::_(2) . "}";
				$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Use Uikit Version 3";
				$setter .= PHP_EOL . Indent::_(2)
					. "elseif (3 == \$this->uikitVersion)";
				$setter .= PHP_EOL . Indent::_(2) . "{";
			}
			// add version 3 fiels to page
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " The uikit css.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v3/css/uikit'.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " The uikit js.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v3/js/uikit'.\$size.'.js', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/uikit-v3/js/uikit-icons'.\$size.'.js', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			if (2 == CFactory::_('Config')->uikit)
			{
				$setter .= PHP_EOL . Indent::_(2) . "}";
			}
		}

		return $setter;
	}

	public function setCustomViewExtraDisplayMethods(&$view)
	{
		if ($view['settings']->add_php_jview == 1)
		{
			return PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
					$view['settings']->php_jview
				);
		}

		return '';
	}

	public function setCustomViewBody(&$view)
	{
		if (StringHelper::check($view['settings']->default))
		{
			if ($view['settings']->main_get->gettype == 2
				&& $view['settings']->main_get->pagination == 1)
			{
				// does this view have a custom limitbox position
				$has_limitbox = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('LIMITBOX')
					) !== false);
				// does this view have a custom pages counter position
				$has_pagescounter = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGESCOUNTER')
					) !== false);
				// does this view have a custom pages links position
				$has_pageslinks = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGESLINKS')
					) !== false);
				// does this view have a custom pagination start position
				$has_pagination_start = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGINATIONSTART')
					) !== false);
				// does this view have a custom pagination end position
				$has_pagination_end = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGINATIONEND')
					) !== false);

				// add pagination start
				CFactory::_('Placeholder')->add_('PAGINATIONSTART', PHP_EOL
					. '<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>');
				CFactory::_('Placeholder')->add_('PAGINATIONSTART',
					PHP_EOL . Indent::_(1) . '<div class="pagination">');
				CFactory::_('Placeholder')->add_('PAGINATIONSTART',
					PHP_EOL . Indent::_(2)
					. '<?php if ($this->params->def(\'show_pagination_results\', 1)) : ?>');

				// add pagination end
				CFactory::_('Placeholder')->set_('PAGINATIONEND',
					Indent::_(2) . '<?php endif; ?>');
				// only add if no custom page link is found
				if (!$has_pageslinks)
				{
					if (CFactory::_('Config')->build_target === 'custom_admin')
					{
						CFactory::_('Placeholder')->add_('PAGINATIONEND',
							PHP_EOL . Indent::_(2)
							. '<?php echo $this->pagination->getListFooter(); ?>');
					}
					else
					{
						CFactory::_('Placeholder')->add_('PAGINATIONEND',
							PHP_EOL . Indent::_(2)
							. '<?php echo $this->pagination->getPagesLinks(); ?>');
					}
				}
				CFactory::_('Placeholder')->add_('PAGINATIONEND',
					PHP_EOL . Indent::_(1) . '</div>');
				CFactory::_('Placeholder')->add_('PAGINATIONEND',
					PHP_EOL . '<?php endif; ?>');

				// add limit box
				CFactory::_('Placeholder')->set_('LIMITBOX',
					'<?php echo $this->pagination->getLimitBox(); ?>');

				// add pages counter
				CFactory::_('Placeholder')->set_('PAGESCOUNTER',
					'<?php echo $this->pagination->getPagesCounter(); ?>');

				// add pages links
				if (CFactory::_('Config')->build_target === 'custom_admin')
				{
					CFactory::_('Placeholder')->set_('PAGESLINKS',
						'<?php echo $this->pagination->getListFooter(); ?>');
				}
				else
				{
					CFactory::_('Placeholder')->set_('PAGESLINKS',
						'<?php echo $this->pagination->getPagesLinks(); ?>');
				}

				// build body
				$body = [];
				// Load the default values to the body
				$body[] = CFactory::_('Placeholder')->update_(
					$view['settings']->default
				);

				// add pagination start
				if (!$has_pagination_start)
				{
					$body[] = CFactory::_('Placeholder')->get_('PAGINATIONSTART');
				}

				if (!$has_limitbox && !$has_pagescounter)
				{
					$body[] = Indent::_(3)
						. '<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>';
				}
				elseif (!$has_limitbox)
				{
					$body[] = Indent::_(3)
						. '<p class="counter pull-right"> <?php echo $this->pagination->getLimitBox(); ?></p>';
				}
				elseif (!$has_pagescounter)
				{
					$body[] = Indent::_(3)
						. '<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>';
				}
				// add pagination end
				if (!$has_pagination_end)
				{
					$body[] = CFactory::_('Placeholder')->get_('PAGINATIONEND');
				}

				// lets clear the placeholders just in case
				CFactory::_('Placeholder')->remove_('LIMITBOX');
				CFactory::_('Placeholder')->remove_('PAGESCOUNTER');
				CFactory::_('Placeholder')->remove_('PAGESLINKS');
				CFactory::_('Placeholder')->remove_('PAGINATIONSTART');
				CFactory::_('Placeholder')->remove_('PAGINATIONEND');

				// insure the form is added (only if no form exist)
				if (strpos((string) $view['settings']->default, '<form') === false)
				{
					$this->addCustomForm[CFactory::_('Config')->build_target][$view['settings']->code]
						= true;
				}

				// return the body
				return implode(PHP_EOL, $body);
			}
			else
			{
				// insure the form is added (only if no form exist)
				if ('site' !== CFactory::_('Config')->build_target
					&& strpos(
						(string) $view['settings']->default, '<form'
					) === false)
				{
					$this->addCustomForm[CFactory::_('Config')->build_target][$view['settings']->code]
						= true;
				}

				return PHP_EOL . CFactory::_('Placeholder')->update_(
						$view['settings']->default
					);
			}
		}

		return '';
	}

	public function setCustomViewForm(&$view, &$gettype, $type)
	{
		if (isset($this->addCustomForm[CFactory::_('Config')->build_target])
			&& isset($this->addCustomForm[CFactory::_('Config')->build_target][$view])
			&& $this->addCustomForm[CFactory::_('Config')->build_target][$view])
		{
			switch ($type)
			{
				case 1:
					// top
					if ('site' === CFactory::_('Config')->build_target)
					{
						return '<form action="<?php echo Route::_(\'index.php?option=com_'
							. CFactory::_('Config')->component_code_name
							. '\'); ?>" method="post" name="adminForm" id="adminForm">'
							. PHP_EOL;
					}
					else
					{
						if ($gettype == 2)
						{
							return '<form action="<?php echo Route::_(\'index.php?option=com_'
								. CFactory::_('Config')->component_code_name . '&view=' . $view
								. '\'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">'
								. PHP_EOL;
						}
						else
						{
							return '<form action="<?php echo Route::_(\'index.php?option=com_'
								. CFactory::_('Config')->component_code_name . '&view=' . $view
								. '\' . $urlId); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">'
								. PHP_EOL;
						}
					}
					break;
				case 2:
					// bottom
					$input = '';
					if ('admin' === CFactory::_('Config')->build_target
						&& isset($this->customAdminViewListId[$view]))
					{
						$input = PHP_EOL . Indent::_(1)
							. '<input type="hidden" name="id" value="<?php echo $this->app->input->getInt(\'id\', 0); ?>" />';
					}

					return $input . PHP_EOL
						. '<input type="hidden" name="task" value="" />'
						. PHP_EOL . "<?php echo Html::_('form.token'); ?>"
						. PHP_EOL . '</form>';
					break;
			}
		}

		return '';
	}

	public function setCustomViewSubmitButtonScript(&$view)
	{
		if (StringHelper::check($view['settings']->default))
		{
			// add the script only if there is none set
			if (strpos(
					(string) $view['settings']->default,
					'Joomla.submitbutton = function('
				) === false)
			{
				$script   = [];
				$script[] = PHP_EOL . "<script type=\"text/javascript\">";
				$script[] = Indent::_(1)
					. "Joomla.submitbutton = function(task) {";
				$script[] = Indent::_(2) . "if (task === '"
					. $view['settings']->code . ".back') {";
				$script[] = Indent::_(3) . "parent.history.back();";
				$script[] = Indent::_(3) . "return false;";
				$script[] = Indent::_(2) . "} else {";
				$script[] = Indent::_(3)
					. "var form = document.getElementById('adminForm');";
				$script[] = Indent::_(3) . "form.task.value = task;";
				$script[] = Indent::_(3) . "form.submit();";
				$script[] = Indent::_(2) . "}";
				$script[] = Indent::_(1) . "}";
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
			$view['settings']->php_view = (array) explode(
				PHP_EOL, (string) $view['settings']->php_view
			);
			if (ArrayHelper::check($view['settings']->php_view))
			{
				$_tmp = PHP_EOL . PHP_EOL . implode(
						PHP_EOL, $view['settings']->php_view
					);

				return CFactory::_('Placeholder')->update_($_tmp);
			}
		}

		return '';
	}

	public function setCustomViewTemplateBody(&$view)
	{
		if (($data_ = CFactory::_('Compiler.Builder.Template.Data')->
			get(CFactory::_('Config')->build_target . '.' . $view['settings']->code)) !== null)
		{
			$created  = CFactory::_('Model.Createdate')->get($view);
			$modified = CFactory::_('Model.Modifieddate')->get($view);
			foreach ($data_ as $template => $data)
			{
				// build the file
				$target = [
					CFactory::_('Config')->build_target => $view['settings']->code
				];
				$config = [
					Placefix::_h('CREATIONDATE') => $created,
					Placefix::_h('BUILDDATE') => $modified,
					Placefix::_h('VERSION') => $view['settings']->version
				];
				CFactory::_('Utilities.Structure')->build($target, 'template', $template, $config);
				// set the file data
				$TARGET = StringHelper::safe(
					CFactory::_('Config')->build_target, 'U'
				);
				if (!isset($data['html']) || $data['html'] === null)
				{
					echo '<pre>';
					var_dump($data);
					exit;
				}
				// SITE_TEMPLATE_BODY <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '_'
					. $template . '|' . $TARGET . '_TEMPLATE_BODY', PHP_EOL . CFactory::_('Placeholder')->update_(
						$data['html']
					));
				if (!isset($data['php_view']) || $data['php_view'] === null)
				{
					echo '<pre>';
					var_dump($data);
					exit;
				}
				// SITE_TEMPLATE_CODE_BODY <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($view['settings']->code . '_'
					. $template . '|' . $TARGET . '_TEMPLATE_CODE_BODY',
					$this->setTemplateCode($data['php_view'])
				);
			}
		}
	}

	public function setTemplateCode(&$php)
	{
		if (StringHelper::check($php))
		{
			$php_view = (array) explode(PHP_EOL, (string) $php);
			if (ArrayHelper::check($php_view))
			{
				$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);

				return CFactory::_('Placeholder')->update_($php_view);
			}
		}

		return '';
	}

	public function setCustomViewLayouts()
	{
		if (($data_ = CFactory::_('Compiler.Builder.Layout.Data')->
			get(CFactory::_('Config')->build_target)) !== null)
		{
			foreach ($data_ as $layout => $data)
			{
				// build the file
				$target = array(CFactory::_('Config')->build_target => $layout);
				CFactory::_('Utilities.Structure')->build($target, 'layout');
				// set the file data
				$TARGET = StringHelper::safe(
					CFactory::_('Config')->build_target, 'U'
				);
				// SITE_LAYOUT_CODE <<<DYNAMIC>>>
				$php_view = (array) explode(PHP_EOL, (string) $data['php_view']);
				if (ArrayHelper::check($php_view))
				{
					$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);
					CFactory::_('Compiler.Builder.Content.Multi')->set($layout . '|' . $TARGET . '_LAYOUT_CODE',
						CFactory::_('Placeholder')->update_(
							$php_view
						)
					);
				}
				else
				{
					CFactory::_('Compiler.Builder.Content.Multi')->set($layout . '|' . $TARGET
						. '_LAYOUT_CODE',  '');
				}
				// SITE_LAYOUT_BODY <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($layout . '|' . $TARGET . '_LAYOUT_BODY',
					PHP_EOL . CFactory::_('Placeholder')->update_(
						$data['html']
					)
				);
				// SITE_LAYOUT_HEADER <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($layout . '|' . $TARGET . '_LAYOUT_HEADER',
					(($header = CFactory::_('Header')->get(
							str_replace('_', '.', (string) CFactory::_('Config')->build_target) . '.layout',
							$layout, false)) !== false) ? PHP_EOL . PHP_EOL . $header : ''
				);
			}
		}
	}

	public function getReplacementNames()
	{
		foreach (CFactory::_('Utilities.Files')->toArray() as $type => $files)
		{
			foreach ($files as $view => $file)
			{
				if (isset($file['path'])
					&& ArrayHelper::check(
						$file
					))
				{
					if (@file_exists($file['path']))
					{
						$string            = FileHelper::getContent(
							$file['path']
						);
						$buket['static'][] = $this->getInbetweenStrings(
							$string
						);
					}
				}
				elseif (ArrayHelper::check($file))
				{
					foreach ($file as $nr => $doc)
					{
						if (ArrayHelper::check($doc))
						{
							if (@file_exists($doc['path']))
							{
								$string
									= FileHelper::getContent(
									$doc['path']
								);
								$buket[$view][] = $this->getInbetweenStrings(
									$string
								);
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
						$echos[$replacment] = "#" . "#" . "#" . $replacment
							. "#" . "#" . "#<br />";
					}
					elseif ($type === 'static')
					{
						$echos[$replacment] = "#" . "#" . "#" . $replacment
							. "#" . "#" . "#<br />";
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
		$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
		$component = CFactory::_('Compiler.Builder.Content.One')->get('component');
		// go from base64 to string
		if (CFactory::_('Compiler.Builder.Base.Six.Four')->exists($view))
		{
			foreach (CFactory::_('Compiler.Builder.Base.Six.Four')->get($view) as $baseString)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(3)
					. "if (!empty(\$item->" . $baseString
					. "))"; // TODO && base64_encode(base64_decode(\$item->".$baseString.", true)) === \$item->".$baseString.")";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " base64 Decode " . $baseString . ".";
				$script .= PHP_EOL . Indent::_(4) . "\$item->" . $baseString
					. " = base64_decode(\$item->" . $baseString . ");";
				$script .= PHP_EOL . Indent::_(3) . "}";
			}
		}
		// decryption
		foreach (CFactory::_('Config')->cryption_types as $cryptionType)
		{
			if (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->exists($view))
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " Get the " . $cryptionType
						. " encryption.";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $cryptionType
						. "key = " . $Component . "Helper::getCryptKey('"
						. $cryptionType . "');";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Get the encryption object.";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $cryptionType
						. " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$" . $cryptionType . "key);";
					foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->get($view) as $baseString)
					{
						$script .= PHP_EOL . PHP_EOL . Indent::_(3)
							. "if (!empty(\$item->" . $baseString . ") && \$"
							. $cryptionType . "key && !is_numeric(\$item->"
							. $baseString . ") && \$item->" . $baseString
							. " === base64_encode(base64_decode(\$item->"
							. $baseString . ", true)))";
						$script .= PHP_EOL . Indent::_(3) . "{";
						$script .= PHP_EOL . Indent::_(4) . "//"
							. Line::_(__Line__, __Class__) . " " . $cryptionType
							. " decrypt data " . $baseString . ".";
						$script .= PHP_EOL . Indent::_(4) . "\$item->"
							. $baseString . " = rtrim(\$" . $cryptionType
							. "->decryptString(\$item->" . $baseString . "), "
							. '"\0"' . ");";
						$script .= PHP_EOL . Indent::_(3) . "}";
					}
				}
				else
				{
					if (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
						exists("{$view}.get"))
					{
						foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
							get("{$view}.get") as $block
						)
						{
							$script .= PHP_EOL . Indent::_(3) . implode(
								PHP_EOL . Indent::_(3), $block
							);
						}
					}
					// set the expert script
					foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->
						get($view) as $baseString => $opener_)
					{
						$_placeholder_for_field = array('[[[field]]]' => '$item->' . $baseString);
						$script .= CFactory::_('Placeholder')->update(
							PHP_EOL . Indent::_(3) . implode(
								PHP_EOL . Indent::_(3), $opener_['get']
							), $_placeholder_for_field
						);
					}
				}
			}
		}
		// go from json to array
		if (CFactory::_('Compiler.Builder.Json.Item')->exists($view))
		{
			foreach (CFactory::_('Compiler.Builder.Json.Item')->get($view) as $jsonItem)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(3)
					. "if (!empty(\$item->" . $jsonItem . "))";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Convert the " . $jsonItem . " field to an array.";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $jsonItem
					. " = new Registry;";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $jsonItem
					. "->loadString(\$item->" . $jsonItem . ");";
				$script .= PHP_EOL . Indent::_(4) . "\$item->" . $jsonItem
					. " = \$" . $jsonItem . "->toArray();";
				$script .= PHP_EOL . Indent::_(3) . "}";
			}
		}
		// go from json to string
		if (CFactory::_('Compiler.Builder.Json.String')->exists($view))
		{
			$makeArray = '';
			foreach (CFactory::_('Compiler.Builder.Json.String')->get($view) as $jsonString)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(3)
					. "if (!empty(\$item->" . $jsonString . "))";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " JSON Decode " . $jsonString . ".";
				if (CFactory::_('Compiler.Builder.Json.Item.Array')->inArray($jsonString, $view) ||
					strpos((string) $jsonString, 'group') !== false)
				{
					$makeArray = ',true';
				}
				$script .= PHP_EOL . Indent::_(4) . "\$item->" . $jsonString
					. " = json_decode(\$item->" . $jsonString . $makeArray
					. ");";
				$script .= PHP_EOL . Indent::_(3) . "}";
			}
		}
		// add the tag get options
		if (CFactory::_('Compiler.Builder.Tags')->exists($view))
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(3)
				. "if (!empty(\$item->id))";
			$script .= PHP_EOL . Indent::_(3) . "{";
			$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get Tag IDs.";
			$script .= PHP_EOL . Indent::_(4) . "\$item->tags"
				. " = new TagsHelper;";
			$script .= PHP_EOL . Indent::_(4)
				. "\$item->tags->getTagIds(\$item->id, 'com_$component.$view');";
			$script .= PHP_EOL . Indent::_(3) . "}";
		}
		// add custom php to getitem method
		$script .= CFactory::_('Customcode.Dispenser')->get(
			'php_getitem', $view, PHP_EOL . PHP_EOL
		);

		return $script;
	}

	public function setCheckboxSave(&$view)
	{
		$script = '';
		if (CFactory::_('Compiler.Builder.Check.Box')->exists($view))
		{
			foreach (CFactory::_('Compiler.Builder.Check.Box')->get($view) as $checkbox)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Set the empty " . $checkbox
					. " item to data";
				$script .= PHP_EOL . Indent::_(2) . "if (!isset(\$data['"
					. $checkbox . "']))";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "\$data['" . $checkbox
					. "'] = '';";
				$script .= PHP_EOL . Indent::_(2) . "}";
			}
		}

		return $script;
	}

	public function setMethodItemSave(&$view)
	{
		$script = '';
		// get component name
		$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
		$component = CFactory::_('Config')->component_code_name;
		// check if there was script added before modeling of data
		$script .= CFactory::_('Customcode.Dispenser')->get(
			'php_before_save', $view, PHP_EOL . PHP_EOL
		);
		// turn array into JSON string
		if (CFactory::_('Compiler.Builder.Json.Item')->exists($view))
		{
			foreach (CFactory::_('Compiler.Builder.Json.Item')->get($view) as $jsonItem)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Set the " . $jsonItem
					. " items to data.";
				$script .= PHP_EOL . Indent::_(2) . "if (isset(\$data['"
					. $jsonItem . "']) && is_array(\$data['" . $jsonItem
					. "']))";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $jsonItem
					. " = new Registry;";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $jsonItem
					. "->loadArray(\$data['" . $jsonItem . "']);";
				$script .= PHP_EOL . Indent::_(3) . "\$data['" . $jsonItem
					. "'] = (string) \$" . $jsonItem . ";";
				$script .= PHP_EOL . Indent::_(2) . "}";
				if (CFactory::_('Compiler.Builder.Permission.Fields')->isArray("$view.$jsonItem"))
				{
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						)
						. " Also check permission since the value may be removed due to permissions";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						)
						. " Then we do not want to clear it out, but simple ignore the empty "
						. $jsonItem;
					$script .= PHP_EOL . Indent::_(2)
						. "elseif (!isset(\$data['" . $jsonItem . "'])";
					// only add permission that are available
					foreach (CFactory::_('Compiler.Builder.Permission.Fields')->get("$view.$jsonItem")
						as $permission_option => $fieldType
					)
					{
						if (CFactory::_('Config')->get('joomla_version', 3) == 3)
						{
							$script .= PHP_EOL . Indent::_(3)
								. "&& Factory::getUser()->authorise('" . $view
								. "." . $permission_option . "." . $jsonItem
								. "', 'com_" . $component . "')";
						}
						else
						{
							$script .= PHP_EOL . Indent::_(3)
								. "&& Factory::getApplication()->getIdentity()->authorise('" . $view
								. "." . $permission_option . "." . $jsonItem
								. "', 'com_" . $component . "')";
						}
					}
					$script .= ")";
				}
				else
				{
					$script .= PHP_EOL . Indent::_(2)
						. "elseif (!isset(\$data['" . $jsonItem . "']))";
				}
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Set the empty " . $jsonItem . " to data";
				$script .= PHP_EOL . Indent::_(3) . "\$data['" . $jsonItem
					. "'] = '';";
				$script .= PHP_EOL . Indent::_(2) . "}";
			}
		}
		// turn string into json string
		if (CFactory::_('Compiler.Builder.Json.String')->exists($view))
		{
			foreach (CFactory::_('Compiler.Builder.Json.String')->get($view) as $jsonString)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Set the " . $jsonString
					. " string to JSON string.";
				$script .= PHP_EOL . Indent::_(2) . "if (isset(\$data['"
					. $jsonString . "']))";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "\$data['" . $jsonString
					. "'] = (string) json_encode(\$data['" . $jsonString
					. "']);";
				$script .= PHP_EOL . Indent::_(2) . "}";
			}
		}
		// turn string into base 64 string
		if (CFactory::_('Compiler.Builder.Base.Six.Four')->exists($view))
		{
			foreach (CFactory::_('Compiler.Builder.Base.Six.Four')->get($view) as $baseString)
			{
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Set the " . $baseString
					. " string to base64 string.";
				$script .= PHP_EOL . Indent::_(2) . "if (isset(\$data['"
					. $baseString . "']))";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "\$data['" . $baseString
					. "'] = base64_encode(\$data['" . $baseString . "']);";
				$script .= PHP_EOL . Indent::_(2) . "}";
			}
		}
		// turn string into encrypted string
		foreach (CFactory::_('Config')->cryption_types as $cryptionType)
		{
			if (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->
				exists($view))
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Get the " . $cryptionType
						. " encryption key.";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $cryptionType
						. "key = " . $Component . "Helper::getCryptKey('"
						. $cryptionType . "');";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Get the encryption object";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $cryptionType
						. " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$" . $cryptionType . "key);";
					foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->
						get($view) as $baseString)
					{
						$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__) . " Encrypt data "
							. $baseString . ".";
						$script .= PHP_EOL . Indent::_(2) . "if (isset(\$data['"
							. $baseString . "']) && \$" . $cryptionType
							. "key)";
						$script .= PHP_EOL . Indent::_(2) . "{";
						$script .= PHP_EOL . Indent::_(3) . "\$data['"
							. $baseString . "'] = \$" . $cryptionType
							. "->encryptString(\$data['" . $baseString . "']);";
						$script .= PHP_EOL . Indent::_(2) . "}";
					}
				}
				else
				{
					if (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
						exists("{$view}.save"))
					{
						foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
							get("{$view}.save") as $block)
						{
							$script .= PHP_EOL . Indent::_(2) . implode(
								PHP_EOL . Indent::_(2), $block
							);
						}
					}
					// set the expert script
					foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field')->
						get($view) as $baseString => $locker_)
					{
						$_placeholder_for_field
							= array('[[[field]]]' => "\$data['"
							. $baseString . "']");
						$script .= CFactory::_('Placeholder')->update(
							PHP_EOL . Indent::_(2) . implode(
								PHP_EOL . Indent::_(2), $locker_['save']
							), $_placeholder_for_field
						);
					}
				}
			}
		}
		// add custom PHP to the save method
		$script .= CFactory::_('Customcode.Dispenser')->get(
			'php_save', $view, PHP_EOL . PHP_EOL
		);

		return $script;
	}

	public function setJtableConstructor(&$view)
	{
		// reset
		$oserver = "";
		// set component name
		$component = CFactory::_('Config')->component_code_name;
		// add the tags observer
		if (CFactory::_('Compiler.Builder.Tags')->exists($view))
		{
			$oserver .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Adding Tag Options";
			$oserver .= PHP_EOL . Indent::_(2)
				. "TableObserverTags::createObserver(\$this, array('typeAlias' => 'com_"
				. $component . "." . $view . "'));";
		}
		// add the history/version observer
		if (CFactory::_('Compiler.Builder.History')->exists($view))
		{
			$oserver .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Adding History Options";
			$oserver .= PHP_EOL . Indent::_(2)
				. "TableObserverContenthistory::createObserver(\$this, array('typeAlias' => 'com_"
				. $component . "." . $view . "'));";
		}

		return $oserver;
	}

	public function setJtableAliasCategory(&$view)
	{
		// only add Observers if both title, alias and category is available in view
		$code = CFactory::_('Compiler.Builder.Category.Code')->get("{$view}.code");
		if ($code !== null)
		{
			return ", '" . $code . "' => \$this->" . $code;
		}

		return '';
	}

	public function setComponentToContentTypes($action)
	{
		if (CFactory::_('Component')->isArray('admin_views'))
		{
			// set component name
			$component = CFactory::_('Config')->component_code_name;
			// reset
			$dbStuff = [];
			// start loading the content type data
			foreach (CFactory::_('Component')->get('admin_views') as $viewData)
			{
				// set main keys
				$view = StringHelper::safe(
					$viewData['settings']->name_single
				);
				// set list view keys
				$views = StringHelper::safe(
					$viewData['settings']->name_list
				);
				// get this views content type data
				$dbStuff[$view] = $this->getContentType($view, $component);
				// get the correct views name
				$checkViews = CFactory::_('Compiler.Builder.Category.Code')->getString("{$view}.views", $views);
				if (ArrayHelper::check($dbStuff[$view])
					&& CFactory::_('Compiler.Builder.Category.Code')->exists($view)
					&& ($checkViews == $views))
				{
					$dbStuff[$view . ' category']
						= $this->getCategoryContentType(
						$view, $views, $component
					);
				}
				elseif (!isset($dbStuff[$view])
					|| !ArrayHelper::check($dbStuff[$view]))
				{
					// remove if not array
					unset($dbStuff[$view]);
				}
			}

			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				return $this->setComponentToContentTypesJ3($action, $dbStuff);
			}

			return $this->setComponentToContentTypesJ4($action, $dbStuff);
		}

		return '';
	}

	protected function setComponentToContentTypesJ3($action, $dbStuff)
	{
		// build the db insert query
		if (ArrayHelper::check($dbStuff))
		{
			$script = '';
			$taabb = '';
			if ($action === 'update')
			{
				$taabb = Indent::_(1);
			}
			$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
				. Line::_(__Line__, __Class__) . " Get The Database object";
			$script .= PHP_EOL . Indent::_(3)
				. "\$db = Factory::getDbo();";
			foreach ($dbStuff as $name => $tables)
			{
				if (ArrayHelper::check($tables))
				{
					$code   = StringHelper::safe($name);
					$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " Create the " . $name
						. " content type object.";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $code
						. " = new \stdClass();";
					foreach ($tables as $table => $data)
					{
						$script .= PHP_EOL . Indent::_(3) . "\$" . $code
							. "->" . $table . " = '" . $data . "';";
					}
					if ($action === 'update')
					{
						// we first load script to check if data exist
						$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
							. Line::_(__Line__, __Class__) . " Check if "
							. $name
							. " type is already in content_type DB.";
						$script .= PHP_EOL . Indent::_(3) . "\$" . $code
							. "_id = null;";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query = \$db->getQuery(true);";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query->select(\$db->quoteName(array('type_id')));";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query->from(\$db->quoteName('#__content_types'));";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query->where(\$db->quoteName('type_alias') . ' LIKE '. \$db->quote($"
							. $code . "->type_alias));";
						$script .= PHP_EOL . Indent::_(3)
							. "\$db->setQuery(\$query);";
						$script .= PHP_EOL . Indent::_(3)
							. "\$db->execute();";
					}
					$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__)
						. " Set the object into the content types table.";
					if ($action === 'update')
					{
						$script .= PHP_EOL . Indent::_(3)
							. "if (\$db->getNumRows())";
						$script .= PHP_EOL . Indent::_(3) . "{";
						$script .= PHP_EOL . Indent::_(4) . "\$" . $code
							. "->type_id = \$db->loadResult();";
						$script .= PHP_EOL . Indent::_(4) . "\$" . $code
							. "_Updated = \$db->updateObject('#__content_types', \$"
							. $code . ", 'type_id');";
						$script .= PHP_EOL . Indent::_(3) . "}";
						$script .= PHP_EOL . Indent::_(3) . "else";
						$script .= PHP_EOL . Indent::_(3) . "{";
					}
					$script .= PHP_EOL . Indent::_(3) . $taabb . "\$"
						. $code
						. "_Inserted = \$db->insertObject('#__content_types', \$"
						. $code . ");";
					if ($action === 'update')
					{
						$script .= PHP_EOL . Indent::_(3) . "}";
					}
				}
			}

			$script .= PHP_EOL . PHP_EOL;
			return $script;
		}

		return '';
	}

	protected function setComponentToContentTypesJ4($action, $dbStuff)
	{
		// build the db insert query
		if (ArrayHelper::check($dbStuff))
		{
			$script = PHP_EOL;
			foreach ($dbStuff as $name => $columns)
			{
				if (ArrayHelper::check($columns))
				{
					$script .= PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " "
						. StringHelper::safe($action, 'Ww') . " "
						. StringHelper::safe($name, 'Ww') . " Content Types.";

					$script .= PHP_EOL . Indent::_(3) .
						'$this->setContentType(';
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " typeTitle";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['type_title']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " typeAlias";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['type_alias']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " table";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['table']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " rules";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['rules']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " fieldMappings";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['field_mappings']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " router";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['router']}',";
					$script .= PHP_EOL . Indent::_(4) .
						"//" . Line::_(__Line__, __Class__) . " contentHistoryOptions";
					$script .= PHP_EOL . Indent::_(4) .
						"'{$columns['content_history_options']}'";
					$script .= PHP_EOL . Indent::_(3) .
						');';

				}
			}
			$script .= PHP_EOL . PHP_EOL;
			return $script;
		}

		return '';
	}

	public function setPostInstallScript()
	{
		// reset script
		$script = $this->setComponentToContentTypes('install');

		// add the Intelligent Fix script if needed
		$script .= $this->getAssetsTableIntelligentInstall();

		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$script .= $this->setPostInstallScriptJ3();
		}
		else
		{
			$script .= $this->setPostInstallScriptJ4();
		}

		// add the custom script
		$script .= CFactory::_('Customcode.Dispenser')->get(
			'php_postflight', 'install', PHP_EOL . PHP_EOL, null, true
		);

		// add the component installation notice
		if (StringHelper::check($script))
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(3)
				. 'echo \'<div style="background-color: #fff;" class="alert alert-info"><a target="_blank" href="'
				. CFactory::_('Compiler.Builder.Content.One')->get('AUTHORWEBSITE') . '" title="'
				. CFactory::_('Compiler.Builder.Content.One')->get('Component_name') . '">';
			$script .= PHP_EOL . Indent::_(4) . '<img src="components/com_'
				. CFactory::_('Config')->component_code_name . '/assets/images/vdm-component.'
				. $this->componentImageType . '"/>';
			$script .= PHP_EOL . Indent::_(4) . '</a></div>\';';

			return $script;
		}

		return PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " noting to install.";
	}

	public function setPostInstallScriptJ3()
	{
		// reset script
		$script = '';

		// set the component name
		$component = CFactory::_('Config')->component_code_name;

		// add the assets table update for permissions rules
		if (CFactory::_('Compiler.Builder.Assets.Rules')->isArray('site'))
		{
			if (StringHelper::check($script))
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extenstion assets permission.";
			}
			else
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extension assets permission.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$db = Factory::getDbo();";
			}
			$script .= PHP_EOL . Indent::_(3)
				. "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Field to update.";
			$script .= PHP_EOL . Indent::_(3) . "\$fields = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('rules') . ' = ' . \$db->quote('{" . implode(
					',', CFactory::_('Compiler.Builder.Assets.Rules')->get('site')
				) . "}'),";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Condition.";
			$script .= PHP_EOL . Indent::_(3) . "\$conditions = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('name') . ' = ' . \$db->quote('com_"
				. $component . "')";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3)
				. "\$query->update(\$db->quoteName('#__assets'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . Indent::_(3) . "\$allDone = \$db->execute();"
				. PHP_EOL;
		}

		// add the global params for the component global settings
		if (CFactory::_('Compiler.Builder.Extensions.Params')->isArray('component'))
		{
			if (StringHelper::check($script))
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extension params.";
			}
			else
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extension params.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$db = Factory::getDbo();";
			}
			$script .= PHP_EOL . Indent::_(3)
				. "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Field to update.";
			$script .= PHP_EOL . Indent::_(3) . "\$fields = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('params') . ' = ' . \$db->quote('{"
				. implode(',', CFactory::_('Compiler.Builder.Extensions.Params')->get('component')) . "}'),";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Condition.";
			$script .= PHP_EOL . Indent::_(3) . "\$conditions = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('element') . ' = ' . \$db->quote('com_"
				. $component . "')";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3)
				. "\$query->update(\$db->quoteName('#__extensions'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . Indent::_(3) . "\$allDone = \$db->execute();"
				. PHP_EOL;
		}

		return $script;
	}

	public function setPostInstallScriptJ4()
	{
		// reset script
		$script = '';

		// add the assets table update for permissions rules
		if (CFactory::_('Compiler.Builder.Assets.Rules')->isArray('site'))
		{
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Install the global extension assets permission.";
			$script .= PHP_EOL . Indent::_(3) . "\$this->setAssetsRules(";
			$script .= PHP_EOL . Indent::_(4) . "'{" . implode(
					',', CFactory::_('Compiler.Builder.Assets.Rules')->get('site')
				) . "}'";
			$script .= PHP_EOL . Indent::_(3) . ");" . PHP_EOL;
		}

		// add the global params for the component global settings
		if (CFactory::_('Compiler.Builder.Extensions.Params')->isArray('component'))
		{
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Install the global extension params.";
			$script .= PHP_EOL . Indent::_(3) . "\$this->setExtensionsParams(";
			$script .= PHP_EOL . Indent::_(4) . "'{"
				. implode(',', CFactory::_('Compiler.Builder.Extensions.Params')->get('component')
				) . "}'";
			$script .= PHP_EOL . Indent::_(3) . ");" . PHP_EOL;
		}

		return $script;
	}

	public function setPostUpdateScript()
	{
		// reset script
		$script = $this->setComponentToContentTypes('update');
		// add the custom script
		$script .= CFactory::_('Customcode.Dispenser')->get(
			'php_postflight', 'update', PHP_EOL . PHP_EOL, null, true
		);
		if (CFactory::_('Component')->isArray('admin_views'))
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(3)
				. 'echo \'<div style="background-color: #fff;" class="alert alert-info"><a target="_blank" href="'
				. CFactory::_('Compiler.Builder.Content.One')->get('AUTHORWEBSITE') . '" title="'
				. CFactory::_('Compiler.Builder.Content.One')->get('Component_name') . '">';
			$script .= PHP_EOL . Indent::_(4) . '<img src="components/com_'
				. CFactory::_('Config')->component_code_name . '/assets/images/vdm-component.'
				. $this->componentImageType . '"/>';
			$script .= PHP_EOL . Indent::_(4) . '</a>';
			$script .= PHP_EOL . Indent::_(4) . "<h3>Upgrade to Version "
				. CFactory::_('Compiler.Builder.Content.One')->get('ACTUALVERSION')
				. " Was Successful! Let us know if anything is not working as expected.</h3></div>';";
		}

		if (StringHelper::check($script))
		{
			return $script;
		}

		return PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " noting to update.";
	}

	public function setUninstallScript()
	{
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			return $this->setUninstallScriptJ3();
		}

		return $this->setUninstallScriptJ4();
	}

	public function setUninstallScriptJ3()
	{
		// reset script
		$script = '';
		if (isset($this->uninstallScriptBuilder)
			&& ArrayHelper::check(
				$this->uninstallScriptBuilder
			))
		{
			$component = CFactory::_('Config')->component_code_name;
			// start loading the data to delete
			$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Get Application object";
			$script .= PHP_EOL . Indent::_(2)
				. "\$app = Factory::getApplication();";
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get The Database object";
			$script .= PHP_EOL . Indent::_(2) . "\$db = Factory::getDbo();";

			foreach (
				$this->uninstallScriptBuilder as $viewsCodeName => $typeAlias
			)
			{
				// set a var value
				$view = StringHelper::safe($viewsCodeName);

				// check if it has field relations
				if (isset($this->uninstallScriptFields)
					&& isset($this->uninstallScriptFields[$viewsCodeName]))
				{
					// First check if data is till in table
					$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Create a new query object.";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Select ids from fields";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->select(\$db->quoteName('id'));";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->from(\$db->quoteName('#__fields'));";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Where " . $viewsCodeName . " context is found";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->where( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(2)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute query to see if context is found";
					$script .= PHP_EOL . Indent::_(2) . "\$db->execute();";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $view
						. "_found = \$db->getNumRows();";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Now check if there were any rows";
					$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view
						. "_found)";
					$script .= PHP_EOL . Indent::_(2) . "{";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Since there are load the needed  " . $view
						. " field ids";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_field_ids = \$db->loadColumn();";

					// Now remove the actual type entry
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Remove " . $viewsCodeName
						. " from the field table";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_condition = array( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Create a new query object.";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query->delete(\$db->quoteName('#__fields'));";
					$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$"
						. $view . "_condition);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute the query to remove " . $viewsCodeName
						. " items";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_done = \$db->execute();";
					$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view
						. "_done)";
					$script .= PHP_EOL . Indent::_(3) . "{";
					$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " If successfully remove " . $viewsCodeName
						. " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . Indent::_(4)
						. "\$app->enqueueMessage(Text:"
						. ":_('The fields with type (" . $typeAlias
						. ") context was removed from the <b>#__fields</b> table'));";
					$script .= PHP_EOL . Indent::_(3) . "}";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Also Remove " . $viewsCodeName . " field values";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_condition = array( \$db->quoteName('field_id') . ' IN ('. implode(',', \$"
						. $view . "_field_ids) .')');";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Create a new query object.";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query->delete(\$db->quoteName('#__fields_values'));";
					$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$"
						. $view . "_condition);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute the query to remove " . $viewsCodeName
						. " field values";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_done = \$db->execute();";
					$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view
						. "_done)";
					$script .= PHP_EOL . Indent::_(3) . "{";
					$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " If successfully remove " . $viewsCodeName
						. " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . Indent::_(4)
						. "\$app->enqueueMessage(Text:"
						. ":_('The fields values for " . $viewsCodeName
						. " was removed from the <b>#__fields_values</b> table'));";
					$script .= PHP_EOL . Indent::_(3) . "}";
					$script .= PHP_EOL . Indent::_(2) . "}";

					// First check if data is till in table
					$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Create a new query object.";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Select ids from field groups";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->select(\$db->quoteName('id'));";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->from(\$db->quoteName('#__fields_groups'));";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Where " . $viewsCodeName . " context is found";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->where( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(2)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute query to see if context is found";
					$script .= PHP_EOL . Indent::_(2) . "\$db->execute();";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $view
						. "_found = \$db->getNumRows();";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Now check if there were any rows";
					$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view
						. "_found)";
					$script .= PHP_EOL . Indent::_(2) . "{";

					// Now remove the actual type entry
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Remove " . $viewsCodeName
						. " from the field groups table";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_condition = array( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Create a new query object.";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query->delete(\$db->quoteName('#__fields_groups'));";
					$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$"
						. $view . "_condition);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute the query to remove " . $viewsCodeName
						. " items";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_done = \$db->execute();";
					$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view
						. "_done)";
					$script .= PHP_EOL . Indent::_(3) . "{";
					$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " If successfully remove " . $viewsCodeName
						. " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . Indent::_(4)
						. "\$app->enqueueMessage(Text:"
						. ":_('The field groups with type (" . $typeAlias
						. ") context was removed from the <b>#__fields_groups</b> table'));";
					$script .= PHP_EOL . Indent::_(3) . "}";
					$script .= PHP_EOL . Indent::_(2) . "}";
				}
				// First check if data is till in table
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Select id from content type table";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query->select(\$db->quoteName('type_id'));";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query->from(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Where " . $viewsCodeName . " alias is found";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query->where( \$db->quoteName('type_alias') . ' = '. \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(2) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute query to see if alias is found";
				$script .= PHP_EOL . Indent::_(2) . "\$db->execute();";
				$script .= PHP_EOL . Indent::_(2) . "\$" . $view
					. "_found = \$db->getNumRows();";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Now check if there were any rows";
				$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view
					. "_found)";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Since there are load the needed  " . $view
					. " type ids";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_ids = \$db->loadColumn();";

				// Now remove the actual type entry
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Remove " . $viewsCodeName
					. " from the content type table";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query->delete(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_done = \$db->execute();";
				$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " If successfully remove " . $viewsCodeName
					. " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . Indent::_(4)
					. "\$app->enqueueMessage(Text:" . ":_('The (" . $typeAlias
					. ") type alias was removed from the <b>#__content_type</b> table'));";
				$script .= PHP_EOL . Indent::_(3) . "}";

				// Now remove the related items from contentitem tag map table
				$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Remove " . $viewsCodeName
					. " items from the contentitem tag map table";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query->delete(\$db->quoteName('#__contentitem_tag_map'));";
				$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_done = \$db->execute();";
				$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " If successfully remove " . $viewsCodeName
					. " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . Indent::_(4)
					. "\$app->enqueueMessage(Text:" . ":_('The (" . $typeAlias
					. ") type alias was removed from the <b>#__contentitem_tag_map</b> table'));";
				$script .= PHP_EOL . Indent::_(3) . "}";

				// Now remove the related items from ucm content table
				$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Remove " . $viewsCodeName
					. " items from the ucm content table";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_condition = array( \$db->quoteName('core_type_alias') . ' = ' . \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query->delete(\$db->quoteName('#__ucm_content'));";
				$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_done = \$db->execute();";
				$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " If successfully removed " . $viewsCodeName
					. " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . Indent::_(4)
					. "\$app->enqueueMessage(Text:" . ":_('The (" . $typeAlias
					. ") type alias was removed from the <b>#__ucm_content</b> table'));";
				$script .= PHP_EOL . Indent::_(3) . "}";

				// setup the foreach loop of ids
				$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Make sure that all the "
					. $viewsCodeName . " items are cleared from DB";
				$script .= PHP_EOL . Indent::_(3) . "foreach (\$" . $view
					. "_ids as \$" . $view . "_id)";
				$script .= PHP_EOL . Indent::_(3) . "{";

				// Now remove the related items from ucm base table
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Remove " . $viewsCodeName
					. " items from the ucm base table";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $view
					. "_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$"
					. $view . "_id);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query->delete(\$db->quoteName('#__ucm_base'));";
				$script .= PHP_EOL . Indent::_(4) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(4) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(4) . "\$db->execute();";

				// Now remove the related items from ucm history table
				$script .= PHP_EOL . PHP_EOL . Indent::_(4) . "//"
					. Line::_(__Line__, __Class__) . " Remove " . $viewsCodeName
					. " items from the ucm history table";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $view
					. "_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$"
					. $view . "_id);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query->delete(\$db->quoteName('#__ucm_history'));";
				$script .= PHP_EOL . Indent::_(4) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(4) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(4) . "\$db->execute();";

				$script .= PHP_EOL . Indent::_(3) . "}";

				$script .= PHP_EOL . Indent::_(2) . "}";
			}

			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " If All related items was removed queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL . Indent::_(2) . "\$app->enqueueMessage(Text:"
				. ":_('All related items was removed from the <b>#__ucm_base</b> table'));";
			$script .= PHP_EOL . Indent::_(2) . "\$app->enqueueMessage(Text:"
				. ":_('All related items was removed from the <b>#__ucm_history</b> table'));";
			// finaly remove the assets from the assets table
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Remove " . $component . " assets from the assets table";
			$script .= PHP_EOL . Indent::_(2) . "\$" . $component
				. "_condition = array( \$db->quoteName('name') . ' LIKE ' . \$db->quote('com_"
				. $component . "%') );";
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Create a new query object.";
			$script .= PHP_EOL . Indent::_(2)
				. "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . Indent::_(2)
				. "\$query->delete(\$db->quoteName('#__assets'));";
			$script .= PHP_EOL . Indent::_(2) . "\$query->where(\$" . $component
				. "_condition);";
			$script .= PHP_EOL . Indent::_(2) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . Indent::_(2) . "\$" . $view
				. "_done = \$db->execute();";
			$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view . "_done)";
			$script .= PHP_EOL . Indent::_(2) . "{";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " If successfully removed " . $component
				. " add queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL . Indent::_(3) . "\$app->enqueueMessage(Text:"
				. ":_('All related items was removed from the <b>#__assets</b> table'));";
			$script .= PHP_EOL . Indent::_(2) . "}";
			// done
			$script .= PHP_EOL;
		}
		elseif (CFactory::_('Config')->add_assets_table_fix == 2)
		{
			// start loading the data to delete (WE NEED THIS)
			$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Get Application object";
			$script .= PHP_EOL . Indent::_(2)
				. "\$app = Factory::getApplication();";
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get The Database object";
			$script .= PHP_EOL . Indent::_(2) . "\$db = Factory::getDbo();";
		}
		// add the Intelligent Reversal script if needed
		$script .= $this->getAssetsTableIntelligentUninstall();
		// add the custom uninstall script
		$script .= CFactory::_('Customcode.Dispenser')->get(
			'php_method', 'uninstall', "", null, true, null, PHP_EOL
		);

		return $script;
	}

	public function setUninstallScriptJ4()
	{
		// reset script
		$script = '';
		if (isset($this->uninstallScriptBuilder)
			&& ArrayHelper::check(
				$this->uninstallScriptBuilder
			))
		{
			// start loading the data to delete
			$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Remove Related Component Data.";
			foreach ($this->uninstallScriptBuilder as $viewsCodeName => $context)
			{
				// set a var value
				$View = StringHelper::safe($viewsCodeName, 'Ww');
				// First check if data is till in table
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__)
					. " Remove $View Data";
				$field = '';
				// check if it has field relations
				if (isset($this->uninstallScriptFields)
					&& isset($this->uninstallScriptFields[$viewsCodeName]))
				{
					$field = ', true';
				}
				// First check if data is till in table
				$script .= PHP_EOL . Indent::_(2) . "\$this->removeViewData(\"$context\"$field);";
			}

			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Remove Asset Data.";
			$script .= PHP_EOL . Indent::_(2) . "\$this->removeAssetData();";
			// done
			$script .= PHP_EOL;
		}

		// add the Intelligent Reversal script if needed
		$script .= $this->getAssetsTableIntelligentUninstall();

		// add the custom uninstallation script
		$script .= CFactory::_('Customcode.Dispenser')->get(
			'php_method', 'uninstall', "", null, true, null, PHP_EOL
		);

		return $script;
	}

	/**
	 * build code for the assets table script intelligent fix
	 *
	 * @return  string The php to place in script.php
	 *
	 */
	protected function getAssetsTableIntelligentInstall()
	{
		// WHY DO WE NEED AN ASSET TABLE FIX?
		// https://www.mysqltutorial.org/mysql-varchar/
		// https://stackoverflow.com/a/15227917/1429677
		// https://forums.mysql.com/read.php?24,105964,105964
		// https://git.vdm.dev/joomla/Component-Builder/issues/616#issuecomment-12085
		// 30 actions each +-20 characters with 8 groups
		// that makes 4800 characters and the current Joomla
		// column size is varchar(5120)

		// check if we should add the intelligent fix treatment for the assets table
		if (CFactory::_('Config')->add_assets_table_fix == 2)
		{
			// get worse case
			$access_worse_case = CFactory::_('Config')->get('access_worse_case', 0);
			// get the type we will convert to
			$data_type = ($access_worse_case > 64000) ? "MEDIUMTEXT"
				: "TEXT";

			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$script   = [];
				$script[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Fix the assets table rules column size.";
				$script[] = Indent::_(3) . '$this->setDatabaseAssetsRulesFix('
					. (int) $access_worse_case . ', "' . $data_type . '");';

				return PHP_EOL . implode(PHP_EOL, $script);
			}

			// the if statement about $rule_length
			$codeIF = "\$rule_length <= " . $access_worse_case;
			// fix column size
			$script   = [];
			$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " Fix the assets table rules column size";
			$script[] = Indent::_(5)
				. '$fix_rules_size = "ALTER TABLE `#__assets` CHANGE `rules` `rules` '
				. $data_type
				. ' NOT NULL COMMENT \'JSON encoded access control. Enlarged to '
				. $data_type . ' by JCB\';";';
			$script[] = Indent::_(5) . "\$db->setQuery(\$fix_rules_size);";
			$script[] = Indent::_(5) . "\$db->execute();";
			$codeA    = implode(PHP_EOL, $script);
			// fixed message
			$messageA = Indent::_(5)
				. "\$app->enqueueMessage(Text:" . ":_('The <b>#__assets</b> table rules column was resized to the "
				. $data_type
				. " datatype for the components possible large permission rules.'));";
			// do nothing
			$codeB = "";
			// fix not needed so ignore
			$messageB = "";

			// done
			return $this->getAssetsTableIntelligentCode(
				$codeIF, $codeA, $codeB, $messageA, $messageB, 2
			);
		}

		return '';
	}

	/**
	 * build code for the assets table script intelligent reversal
	 *
	 * @return  string The php to place in script.php
	 *
	 */
	protected function getAssetsTableIntelligentUninstall()
	{
		// check if we should add the intelligent uninstall treatment for the assets table
		if (CFactory::_('Config')->add_assets_table_fix == 2)
		{
			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$script   = [];
				$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Revert the assets table rules column back to the default.";
				$script[] = Indent::_(2) . '$this->removeDatabaseAssetsRulesFix();';

				return PHP_EOL . implode(PHP_EOL, $script);
			}
			// the if statement about $rule_length
			$codeIF = "\$rule_length < 5120";
			// reverse column size
			$script   = [];
			$script[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Revert the assets table rules column back to the default";
			$script[] = Indent::_(4)
				. '$revert_rule = "ALTER TABLE `#__assets` CHANGE `rules` `rules` varchar(5120) NOT NULL COMMENT \'JSON encoded access control.\';";';
			$script[] = Indent::_(4) . "\$db->setQuery(\$revert_rule);";
			$script[] = Indent::_(4) . "\$db->execute();";
			$codeA    = implode(PHP_EOL, $script);
			// reverted message
			$messageA = Indent::_(4)
				. "\$app->enqueueMessage(Text::_('COM_COMPONENTBUILDER_REVERTED_THE_B_ASSETSB_TABLE_RULES_COLUMN_BACK_TO_ITS_DEFAULT_SIZE_OF_VARCHARFIVE_THOUSAND_ONE_HUNDRED_AND_TWENTY'));";
			// do nothing
			$codeB = "";
			// not reverted message
			$messageB = Indent::_(4)
				. "\$app->enqueueMessage(Text:" . ":_('Could not revert the <b>#__assets</b> table rules column back to its default size of varchar(5120), since there is still one or more components that still requires the column to be larger.'));";

			// done
			return $this->getAssetsTableIntelligentCode(
				$codeIF, $codeA, $codeB, $messageA, $messageB
			);
		}

		return '';
	}

	/**
	 * set code for both install, update and uninstall
	 *
	 * @param   string  $codeIF    The IF code to fix this issue
	 * @param   string  $codeA     The a code to fix this issue
	 * @param   string  $codeB     The b code to fix this issue
	 * @param   string  $messageA  The fix a message
	 * @param   string  $messageB  The fix b message
	 *
	 * @return  string
	 *
	 */
	protected function getAssetsTableIntelligentCode($codeIF, $codeA, $codeB,
	                                                 $messageA, $messageB, $tab = 1
	)
	{
		// reset script
		$script   = [];
		$script[] = Indent::_($tab) . Indent::_(1) . "//" . Line::_(
				__LINE__,__CLASS__
			)
			. " Get the biggest rule column in the assets table at this point.";
		$script[] = Indent::_($tab) . Indent::_(1)
			. '$get_rule_length = "SELECT CHAR_LENGTH(`rules`) as rule_size FROM #__assets ORDER BY rule_size DESC LIMIT 1";';
		$script[] = Indent::_($tab) . Indent::_(1)
			. "\$db->setQuery(\$get_rule_length);";
		$script[] = Indent::_($tab) . Indent::_(1) . "if (\$db->execute())";
		$script[] = Indent::_($tab) . Indent::_(1) . "{";
		$script[] = Indent::_($tab) . Indent::_(2)
			. "\$rule_length = \$db->loadResult();";
		// https://github.com/joomla/joomla-cms/blob/3.10.0-alpha3/installation/sql/mysql/joomla.sql#L22
		// Checked 1st December 2020 (let us know if this changes)
		$script[] = Indent::_($tab) . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			)
			. " Check the size of the rules column";
		$script[] = Indent::_($tab) . Indent::_(2) . "if (" . $codeIF . ")";
		$script[] = Indent::_($tab) . Indent::_(2) . "{";
		$script[] = $codeA;
		$script[] = $messageA;
		$script[] = Indent::_($tab) . Indent::_(2) . "}";
		// only ad this if there is a B part
		if (StringHelper::check($codeB)
			|| StringHelper::check($messageB))
		{
			$script[] = Indent::_($tab) . Indent::_(2) . "else";
			$script[] = Indent::_($tab) . Indent::_(2) . "{";
			$script[] = $codeB;
			$script[] = $messageB;
			$script[] = Indent::_($tab) . Indent::_(2) . "}";
		}
		$script[] = Indent::_($tab) . Indent::_(1) . "}";

		// done
		return PHP_EOL . implode(PHP_EOL, $script);
	}

	public function setMoveFolderScript()
	{
		if (CFactory::_('Registry')->get('set_move_folders_install_script'))
		{
			$function = 'setDynamicF0ld3rs($app, $parent)';
			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$function = 'moveFolders($adapter)';
			}
			// reset script
			$script   = [];
			$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " We check if we have dynamic folders to copy";
			$script[] = Indent::_(2)
				. "\$this->{$function};";

			// done
			return PHP_EOL . implode(PHP_EOL, $script);
		}

		return '';
	}

	public function setMoveFolderMethod()
	{
		if (CFactory::_('Registry')->get('set_move_folders_install_script'))
		{
			// reset script
			$script   = [];
			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$script[] = Indent::_(1) . "/**";
				$script[] = Indent::_(1)
					. " * Method to move folders into place.";
				$script[] = Indent::_(1) . " *";
				$script[] = Indent::_(1) . " * @param   InstallerAdapter  \$adapter  The adapter calling this method";
				$script[] = Indent::_(1) . " *";
				$script[] = Indent::_(1) . " * @return void";
				$script[] = Indent::_(1) . " * @since 4.4.2";
				$script[] = Indent::_(1) . " */";
				$script[] = Indent::_(1)
					. "protected function moveFolders(InstallerAdapter \$adapter): void";
				$script[] = Indent::_(1) . "{";
				$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " get the installation path";
				$script[] = Indent::_(2) . "\$installer = \$adapter->getParent();";
			}
			else
			{
				$script[] = Indent::_(1) . "/**";
				$script[] = Indent::_(1)
					. " * Method to set/copy dynamic folders into place (use with caution)";
				$script[] = Indent::_(1) . " *";
				$script[] = Indent::_(1) . " * @return void";
				$script[] = Indent::_(1) . " */";
				$script[] = Indent::_(1)
					. "protected function setDynamicF0ld3rs(\$app, \$parent)";
				$script[] = Indent::_(1) . "{";
				$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " get the installation path";
				$script[] = Indent::_(2) . "\$installer = \$parent->getParent();";
			}

			$script[] = Indent::_(2)
				. "\$installPath = \$installer->getPath('source');";
			$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " get all the folders";
			$script[] = Indent::_(2)
				. "\$folders = Folder::folders(\$installPath);";
			$script[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if we have folders we may want to copy";
			$script[] = Indent::_(2)
				. "\$doNotCopy = ['media','admin','site']; // Joomla already deals with these";
			$script[] = Indent::_(2) . "if (count((array) \$folders) > 1)";
			$script[] = Indent::_(2) . "{";
			$script[] = Indent::_(3) . "foreach (\$folders as \$folder)";
			$script[] = Indent::_(3) . "{";
			$script[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Only copy if not a standard folders";
			$script[] = Indent::_(4) . "if (!in_array(\$folder, \$doNotCopy))";
			$script[] = Indent::_(4) . "{";
			$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " set the source path";
			$script[] = Indent::_(5) . "\$src = \$installPath.'/'.\$folder;";
			$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " set the destination path";
			$script[] = Indent::_(5) . "\$dest = JPATH_ROOT.'/'.\$folder;";
			$script[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " now try to copy the folder";
			$script[] = Indent::_(5)
				. "if (!Folder::copy(\$src, \$dest, '', true))";
			$script[] = Indent::_(5) . "{";

			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$script[] = Indent::_(6)
				. "\$this->app->enqueueMessage('Could not copy '.\$folder.' folder into place, please make sure destination is writable!', 'error');";
			}
			else
			{
				$script[] = Indent::_(6)
					. "\$app->enqueueMessage('Could not copy '.\$folder.' folder into place, please make sure destination is writable!', 'error');";
			}

			$script[] = Indent::_(5) . "}";
			$script[] = Indent::_(4) . "}";
			$script[] = Indent::_(3) . "}";
			$script[] = Indent::_(2) . "}";
			$script[] = Indent::_(1) . "}";

			// done
			return PHP_EOL . PHP_EOL . implode(PHP_EOL, $script);
		}

		return '';
	}

	public function getContentType($view, $component)
	{
		// add if history is to be kept or if tags is added
		if (CFactory::_('Compiler.Builder.History')->exists($view)
			|| CFactory::_('Compiler.Builder.Tags')->exists($view))
		{
			// reset array
			$array = [];
			// set needed defaults
			$alias            = CFactory::_('Compiler.Builder.Alias')->get($view, 'null');
			$title            = CFactory::_('Compiler.Builder.Title')->get($view, 'null');
			$category         = CFactory::_('Compiler.Builder.Category.Code')->getString("{$view}.code", 'null');
			$categoryHistory  = (CFactory::_('Compiler.Builder.Category.Code')->exists($view))
				?
				'{"sourceColumn": "' . $category
				. '","targetTable": "#__categories","targetColumn": "id","displayColumn": "title"},'
				: '';
			$Component        = StringHelper::safe(
				$component, 'F'
			);
			$View             = StringHelper::safe($view, 'F');
			$maintext         = CFactory::_('Compiler.Builder.Main.Text.Field')->get($view, 'null');
			$hiddenFields     = CFactory::_('Compiler.Builder.Hidden.Fields')->toString($view, '');
			$dynamicfields    = CFactory::_('Compiler.Builder.Dynamic.Fields')->toString($view, ',');
			$intFields        = CFactory::_('Compiler.Builder.Integer.Fields')->toString($view, '');
			$customfieldlinks = CFactory::_('Compiler.Builder.Custom.Field.Links')->toString($view, '');
			// build uninstall script for content types
			$this->uninstallScriptBuilder[$View] = 'com_' . $component . '.' . $view;
			$this->uninstallScriptContent[$view] = $view;
			// check if this view has metadata
			if (CFactory::_('Compiler.Builder.Meta.Data')->isString($view))
			{
				$core_metadata = 'metadata';
				$core_metakey  = 'metakey';
				$core_metadesc = 'metadesc';
			}
			else
			{
				$core_metadata = 'null';
				$core_metakey  = 'null';
				$core_metadesc = 'null';
			}
			// check if view has access
			if (CFactory::_('Compiler.Builder.Access.Switch')->exists($view))
			{
				$core_access = 'access';
				$accessHistory
					= ',{"sourceColumn": "access","targetTable": "#__viewlevels","targetColumn": "id","displayColumn": "title"}';
			}
			else
			{
				$core_access   = 'null';
				$accessHistory = '';
			}
			// set the title
			$array['type_title'] = $Component . ' ' . $View;
			// set the alias
			$array['type_alias'] = 'com_' . $component . '.' . $view;
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				// set the table
				$array['table'] = '{"special": {"dbtable": "#__' . $component . '_'
					. $view . '","key": "id","type": "' . $View . '","prefix": "'
					. $component
					. 'Table","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';
			}
			else
			{
				// set the table
				$array['table'] = '{"special": {"dbtable": "#__' . $component . '_'
					. $view . '","key": "id","type": "' . $View . 'Table","prefix": "' . CFactory::_('Config')->namespace_prefix
					. '\\Component\\' . CFactory::_('Compiler.Builder.Content.One')->get('ComponentNamespace')
					. '\\Administrator\\Table"}}';

				// set rules field
				$array['rules'] = '';
			}

			// set field map
			$array['field_mappings']
				= '{"common": {"core_content_item_id": "id","core_title": "'
				. $title . '","core_state": "published","core_alias": "'
				. $alias
				. '","core_created_time": "created","core_modified_time": "modified","core_body": "'
				. $maintext
				. '","core_hits": "hits","core_publish_up": "null","core_publish_down": "null","core_access": "'
				. $core_access
				. '","core_params": "params","core_featured": "null","core_metadata": "'
				. $core_metadata
				. '","core_language": "null","core_images": "null","core_urls": "null","core_version": "version","core_ordering": "ordering","core_metakey": "'
				. $core_metakey . '","core_metadesc": "' . $core_metadesc
				. '","core_catid": "' . $category
				. '","core_xreference": "null","asset_id": "asset_id"},"special": {'
				. $dynamicfields . '}}';

			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				// set the router class method
				$array['router'] = $Component . 'HelperRoute::get' . $View
					. 'Route';
			}
			else
			{
				// set the router class method
				$array['router'] = '';
			}

			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				// set content history
				$array['content_history_options']
					= '{"formFile": "administrator/components/com_' . $component
					. '/models/forms/' . $view
					. '.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"'
					. $hiddenFields
					. '],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"'
					. $intFields . '],"displayLookup": [' . $categoryHistory
					. '{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'
					. $accessHistory
					. ',{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'
					. $customfieldlinks . ']}';
			}
			else
			{
				// set content history
				$array['content_history_options']
					= '{"formFile": "administrator/components/com_' . $component
					. '/forms/' . $view
					. '.xml","hideFields": ["asset_id","checked_out","checked_out_time"'
					. $hiddenFields
					. '],"ignoreChanges": ["modified_by","modified","checked_out","checked_out_time","version","hits"],"convertToInt": ["published","ordering","version","hits"'
					. $intFields . '],"displayLookup": [' . $categoryHistory
					. '{"sourceColumn": "created_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'
					. $accessHistory
					. ',{"sourceColumn": "modified_by","targetTable": "#__users","targetColumn": "id","displayColumn": "name"}'
					. $customfieldlinks . ']}';
			}

			return $array;
		}

		return false;
	}

	public function getCategoryContentType($view, $views, $component)
	{
		// get the other view
		$otherView = CFactory::_('Compiler.Builder.Category.Code')->getString("{$view}.view", 'error');
		$category  = CFactory::_('Compiler.Builder.Category.Code')->getString("{$view}.code", 'error');
		$Component = StringHelper::safe($component, 'F');
		$View      = StringHelper::safe($view, 'F');
		// build uninstall script for content types
		$this->uninstallScriptBuilder[$View . ' ' . $category] = 'com_'
			. $component . '.' . $otherView . '.category';
		$this->uninstallScriptContent[$View . ' ' . $category] = $View . ' '
			. $category;
		// set the title
		$array['type_title'] = $Component . ' ' . $View . ' '
			. StringHelper::safe($category, 'F');
		// set the alias
		$array['type_alias'] = 'com_' . $component . '.' . $otherView
			. '.category';
		// set the table
		$array['table']
			= '{"special":{"dbtable":"#__categories","key":"id","type":"Category","prefix":"JTable","config":"array()"},"common":{"dbtable":"#__ucm_content","key":"ucm_id","type":"Corecontent","prefix":"JTable","config":"array()"}}';
		if (CFactory::_('Config')->get('joomla_version', 3) != 3)
		{
			// set rules field
			$array['rules'] = '';
		}
		// set field map
		$array['field_mappings']
			= '{"common":{"core_content_item_id":"id","core_title":"title","core_state":"published","core_alias":"alias","core_created_time":"created_time","core_modified_time":"modified_time","core_body":"description", "core_hits":"hits","core_publish_up":"null","core_publish_down":"null","core_access":"access", "core_params":"params", "core_featured":"null", "core_metadata":"metadata", "core_language":"language", "core_images":"null", "core_urls":"null", "core_version":"version", "core_ordering":"null", "core_metakey":"metakey", "core_metadesc":"metadesc", "core_catid":"parent_id", "core_xreference":"null", "asset_id":"asset_id"}, "special":{"parent_id":"parent_id","lft":"lft","rgt":"rgt","level":"level","path":"path","extension":"extension","note":"note"}}';

		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			// set the router class method
			$array['router'] = $Component . 'HelperRoute::getCategoryRoute';
			// set content history
			$array['content_history_options']
				= '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';
		}
		else
		{
			// set the router class method
			$array['router'] = '';
			// set content history
			$array['content_history_options']
				= '{"formFile":"administrator\/components\/com_categories\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';
		}

		return $array;
	}

	public function setRouterHelp($nameSingleCode, $nameListCode,
	                              $front = false
	)
	{
		// add if tags is added, also for all front item views
		if ((CFactory::_('Compiler.Builder.Tags')->exists($nameSingleCode)
				|| $front)
			&& (!in_array($nameSingleCode, $this->setRouterHelpDone)))
		{
			// insure we load a view only once
			$this->setRouterHelpDone[] = $nameSingleCode;
			// build view route helper
			$View          = StringHelper::safe(
				$nameSingleCode, 'F'
			);
			$routeHelper   = [];
			$routeHelper[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$routeHelper[] = Indent::_(1) . " * @param int The route of the "
				. $View;
			$routeHelper[] = Indent::_(1) . " */";
			if ('category' === $nameSingleCode
				|| 'categories' === $nameSingleCode)
			{
				$routeHelper[] = Indent::_(1) . "public static function get"
					. $View . "Route(\$id = 0)";
			}
			else
			{
				$routeHelper[] = Indent::_(1) . "public static function get"
					. $View . "Route(\$id = 0, \$catid = 0)";
			}
			$routeHelper[] = Indent::_(1) . "{";
			$routeHelper[] = Indent::_(2) . "if (\$id > 0)";
			$routeHelper[] = Indent::_(2) . "{";
			$routeHelper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Initialize the needel array.";
			$routeHelper[] = Indent::_(3) . "\$needles = array(";
			$routeHelper[] = Indent::_(4) . "'" . $nameSingleCode
				. "'  => array((int) \$id)";
			$routeHelper[] = Indent::_(3) . ");";
			$routeHelper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Create the link";
			$routeHelper[] = Indent::_(3) . "\$link = 'index.php?option=com_"
				. CFactory::_('Config')->component_code_name . "&view=" . $nameSingleCode
				. "&id='. \$id;";
			$routeHelper[] = Indent::_(2) . "}";
			$routeHelper[] = Indent::_(2) . "else";
			$routeHelper[] = Indent::_(2) . "{";
			$routeHelper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Initialize the needel array.";
			$routeHelper[] = Indent::_(3) . "\$needles = array(";
			$routeHelper[] = Indent::_(4) . "'" . $nameSingleCode
				. "'  => array()";
			$routeHelper[] = Indent::_(3) . ");";
			$routeHelper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Create the link but don't add the id.";
			$routeHelper[] = Indent::_(3) . "\$link = 'index.php?option=com_"
				. CFactory::_('Config')->component_code_name . "&view=" . $nameSingleCode
				. "';";
			$routeHelper[] = Indent::_(2) . "}";
			if ('category' != $nameSingleCode
				&& 'categories' != $nameSingleCode)
			{
				$routeHelper[] = Indent::_(2) . "if (\$catid > 1)";
				$routeHelper[] = Indent::_(2) . "{";
				$routeHelper[] = Indent::_(3)
					. "\$categories = Categories::getInstance('"
					. CFactory::_('Config')->component_code_name . "." . $nameListCode . "');";
				$routeHelper[] = Indent::_(3)
					. "\$category = \$categories->get(\$catid);";
				$routeHelper[] = Indent::_(3) . "if (\$category)";
				$routeHelper[] = Indent::_(3) . "{";
				$routeHelper[] = Indent::_(4)
					. "\$needles['category'] = array_reverse(\$category->getPath());";
				$routeHelper[] = Indent::_(4)
					. "\$needles['categories'] = \$needles['category'];";
				$routeHelper[] = Indent::_(4) . "\$link .= '&catid='.\$catid;";
				$routeHelper[] = Indent::_(3) . "}";
				$routeHelper[] = Indent::_(2) . "}";
			}
			if (CFactory::_('Compiler.Builder.Has.Menu.Global')->exists($nameSingleCode))
			{
				$routeHelper[] = PHP_EOL . Indent::_(2)
					. "if (\$item = self::_findItem(\$needles, '"
					. $nameSingleCode . "'))";
			}
			else
			{
				$routeHelper[] = PHP_EOL . Indent::_(2)
					. "if (\$item = self::_findItem(\$needles))";
			}
			$routeHelper[] = Indent::_(2) . "{";
			$routeHelper[] = Indent::_(3) . "\$link .= '&Itemid='.\$item;";
			$routeHelper[] = Indent::_(2) . "}";
			$routeHelper[] = PHP_EOL . Indent::_(2) . "return \$link;";
			$routeHelper[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $routeHelper);
		}

		return '';
	}

	public function routerParseSwitch(&$view, $viewArray = null,
	                                  $aliasView = true, $idView = true
	)
	{
		// reset buckets
		$routerSwitch = [];
		$isCategory   = '';
		$viewTable    = false;
		if ($viewArray && ArrayHelper::check($viewArray)
			&& isset($viewArray['settings'])
			&& isset($viewArray['settings']->main_get))
		{
			// check if we have custom script for this router parse switch case
			if (isset($viewArray['settings']->main_get->add_php_router_parse)
				&& $viewArray['settings']->main_get->add_php_router_parse == 1
				&& isset($viewArray['settings']->main_get->php_router_parse)
				&& StringHelper::check(
					$viewArray['settings']->main_get->php_router_parse
				))
			{
				// load the custom script for the switch based on dynamic get
				$routerSwitch[] = PHP_EOL . Indent::_(3) . "case '" . $view
					. "':";
				$routerSwitch[] = CFactory::_('Placeholder')->update_(
					$viewArray['settings']->main_get->php_router_parse
				);
				$routerSwitch[] = Indent::_(4) . "break;";

				return implode(PHP_EOL, $routerSwitch);
			}
			// is this a catogory
			elseif (isset($viewArray['settings']->main_get->db_table_main)
				&& $viewArray['settings']->main_get->db_table_main
				=== 'categories')
			{
				$isCategory = ', true'; // TODO we will keep an eye on this....
			}
			// get the main table name
			elseif (isset($viewArray['settings']->main_get->main_get)
				&& ArrayHelper::check(
					$viewArray['settings']->main_get->main_get
				))
			{
				foreach ($viewArray['settings']->main_get->main_get as $get)
				{
					if (isset($get['as']) && $get['as'] === 'a')
					{
						if (isset($get['selection'])
							&& ArrayHelper::check(
								$get['selection']
							)
							&& isset($get['selection']['select_gets'])
							&& ArrayHelper::check(
								$get['selection']['select_gets']
							))
						{
							if (isset($get['selection']['table']))
							{
								$viewTable = str_replace(
									'#__' . CFactory::_('Config')->component_code_name . '_', '',
									(string) $get['selection']['table']
								);
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
			$routerSwitch[] = PHP_EOL . Indent::_(3) . "case '" . $view . "':";
			$routerSwitch[] = Indent::_(4) . "\$vars['view'] = '" . $view
				. "';";
			$routerSwitch[] = Indent::_(4)
				. "if (is_numeric(\$segments[\$count-1]))";
			$routerSwitch[] = Indent::_(4) . "{";
			$routerSwitch[] = Indent::_(5)
				. "\$vars['id'] = (int) \$segments[\$count-1];";
			$routerSwitch[] = Indent::_(4) . "}";
			$routerSwitch[] = Indent::_(4) . "elseif (\$segments[\$count-1])";
			$routerSwitch[] = Indent::_(4) . "{";
			// we need to get from the table of this views main get the alias so we need the table name
			if ($viewTable)
			{
				$routerSwitch[] = Indent::_(5) . "\$id = \$this->getVar('"
					. $viewTable . "', \$segments[\$count-1], 'alias', 'id'"
					. $isCategory . ");";
			}
			else
			{
				$routerSwitch[] = Indent::_(5) . "\$id = \$this->getVar('"
					. $view . "', \$segments[\$count-1], 'alias', 'id'"
					. $isCategory . ");";
			}
			$routerSwitch[] = Indent::_(5) . "if(\$id)";
			$routerSwitch[] = Indent::_(5) . "{";
			$routerSwitch[] = Indent::_(6) . "\$vars['id'] = \$id;";
			$routerSwitch[] = Indent::_(5) . "}";
			$routerSwitch[] = Indent::_(4) . "}";
			$routerSwitch[] = Indent::_(4) . "break;";
		}
		elseif ($idView)
		{
			$routerSwitch[] = PHP_EOL . Indent::_(3) . "case '" . $view . "':";
			$routerSwitch[] = Indent::_(4) . "\$vars['view'] = '" . $view
				. "';";
			$routerSwitch[] = Indent::_(4)
				. "if (is_numeric(\$segments[\$count-1]))";
			$routerSwitch[] = Indent::_(4) . "{";
			$routerSwitch[] = Indent::_(5)
				. "\$vars['id'] = (int) \$segments[\$count-1];";
			$routerSwitch[] = Indent::_(4) . "}";
			$routerSwitch[] = Indent::_(4) . "break;";
		}
		else
		{
			$routerSwitch[] = PHP_EOL . Indent::_(3) . "case '" . $view . "':";
			$routerSwitch[] = Indent::_(4) . "\$vars['view'] = '" . $view
				. "';";
			$routerSwitch[] = Indent::_(4) . "break;";
		}

		return implode(PHP_EOL, $routerSwitch);
	}

	public function routerBuildViews(&$view)
	{
		if (CFactory::_('Compiler.Builder.Content.One')->exists('ROUTER_BUILD_VIEWS')
			&& StringHelper::check(
				CFactory::_('Compiler.Builder.Content.One')->get('ROUTER_BUILD_VIEWS')
			))
		{
			return " || \$view === '" . $view . "'";
		}
		else
		{
			return "\$view === '" . $view . "'";
		}
	}

	public function setBatchMove($nameSingleCode)
	{
		// set needed defaults
		$category  = CFactory::_('Compiler.Builder.Category.Code')->getString("{$nameSingleCode}.code");
		$batchmove = [];
		$VIEW      = StringHelper::safe($nameSingleCode, 'U');
		// component helper name
		$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
		// prepare custom script
		$customScript = CFactory::_('Customcode.Dispenser')->get(
			'php_batchmove', $nameSingleCode, PHP_EOL . PHP_EOL, null, true
		);

		$batchmove[] = PHP_EOL . Indent::_(1) . "/**";
		$batchmove[] = Indent::_(1) . " * Batch move items to a new category";
		$batchmove[] = Indent::_(1) . " *";
		$batchmove[] = Indent::_(1)
			. " * @param   integer  \$value     The new category ID.";
		$batchmove[] = Indent::_(1)
			. " * @param   array    \$pks       An array of row IDs.";
		$batchmove[] = Indent::_(1)
			. " * @param   array    \$contexts  An array of item contexts.";
		$batchmove[] = Indent::_(1) . " *";
		$batchmove[] = Indent::_(1)
			. " * @return  boolean  True if successful, false otherwise and internal error is set.";
		$batchmove[] = Indent::_(1) . " *";
		$batchmove[] = Indent::_(1) . " * @since 12.2";
		$batchmove[] = Indent::_(1) . " */";
		$batchmove[] = Indent::_(1)
			. "protected function batchMove(\$values, \$pks, \$contexts)";
		$batchmove[] = Indent::_(1) . "{";
		$batchmove[] = Indent::_(2) . "if (empty(\$this->batchSet))";
		$batchmove[] = Indent::_(2) . "{";
		$batchmove[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set some needed variables.";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$batchmove[] = Indent::_(3)
				. "\$this->user		= Factory::getUser();";
		}
		else
		{
			$batchmove[] = Indent::_(3)
				. "\$this->user		= Factory::getApplication()->getIdentity();";
		}
		$batchmove[] = Indent::_(3)
			. "\$this->table		= \$this->getTable();";
		$batchmove[] = Indent::_(3)
			. "\$this->tableClassName	= get_class(\$this->table);";
		$batchmove[] = Indent::_(3) . "\$this->canDo		= " . $Helper
			. "::getActions('" . $nameSingleCode . "');";
		$batchmove[] = Indent::_(2) . "}";

		$batchmove[] = PHP_EOL . Indent::_(2) . "if (!\$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit') . "') && !\$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.batch') . "'))";

		$batchmove[] = Indent::_(2) . "{";
		$batchmove[] = Indent::_(3) . "\$this->setError(Text:"
			. ":_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";
		$batchmove[] = Indent::_(3) . "return false;";
		$batchmove[] = Indent::_(2) . "}" . $customScript;

		$batchmove[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " make sure published only updates if user has the permission.";
		$batchmove[] = Indent::_(2)
			. "if (isset(\$values['published']) && !\$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit.state') . "'))";

		$batchmove[] = Indent::_(2) . "{";
		$batchmove[] = Indent::_(3) . "unset(\$values['published']);";
		$batchmove[] = Indent::_(2) . "}";

		$batchmove[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " remove move_copy from array";
		$batchmove[] = Indent::_(2) . "unset(\$values['move_copy']);";

		if ($category !== null)
		{
			$batchmove[] = PHP_EOL . Indent::_(2)
				. "if (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchmove[] = Indent::_(2) . "{";
			$batchmove[] = Indent::_(3) . "return false;";
			$batchmove[] = Indent::_(2) . "}";
			$batchmove[] = Indent::_(2)
				. "elseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchmove[] = Indent::_(2) . "{";
			$batchmove[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " move the category value to correct field name";
			$batchmove[] = Indent::_(3) . "\$values['" . $category
				. "'] = \$values['category'];";
			$batchmove[] = Indent::_(3) . "unset(\$values['category']);";
			$batchmove[] = Indent::_(2) . "}";
			$batchmove[] = Indent::_(2)
				. "elseif (isset(\$values['category']))";
			$batchmove[] = Indent::_(2) . "{";
			$batchmove[] = Indent::_(3) . "unset(\$values['category']);";
			$batchmove[] = Indent::_(2) . "}" . PHP_EOL;
		}

		$batchmove[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Parent exists so we proceed";
		$batchmove[] = Indent::_(2) . "foreach (\$pks as \$pk)";
		$batchmove[] = Indent::_(2) . "{";
		$batchmove[] = Indent::_(3) . "if (!\$this->user->authorise('"
			. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit') . "', \$contexts[\$pk]))";
		$batchmove[] = Indent::_(3) . "{";
		$batchmove[] = Indent::_(4) . "\$this->setError(Text:"
			. ":_('JLIB_APPLICATION_ERROR_BATCH_CANNOT_EDIT'));";

		$batchmove[] = Indent::_(4) . "return false;";
		$batchmove[] = Indent::_(3) . "}";

		$batchmove[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Check that the row actually exists";
		$batchmove[] = Indent::_(3) . "if (!\$this->table->load(\$pk))";
		$batchmove[] = Indent::_(3) . "{";
		$batchmove[] = Indent::_(4)
			. "if (\$error = \$this->table->getError())";
		$batchmove[] = Indent::_(4) . "{";
		$batchmove[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
			. " Fatal error";
		$batchmove[] = Indent::_(5) . "\$this->setError(\$error);";

		$batchmove[] = Indent::_(5) . "return false;";
		$batchmove[] = Indent::_(4) . "}";
		$batchmove[] = Indent::_(4) . "else";
		$batchmove[] = Indent::_(4) . "{";
		$batchmove[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
			. " Not fatal error";
		$batchmove[] = Indent::_(5) . "\$this->setError(Text:"
			. ":sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchmove[] = Indent::_(5) . "continue;";
		$batchmove[] = Indent::_(4) . "}";
		$batchmove[] = Indent::_(3) . "}";

		$batchmove[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " insert all set values.";
		$batchmove[] = Indent::_(3) . "if ("
			. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$values))";
		$batchmove[] = Indent::_(3) . "{";
		$batchmove[] = Indent::_(4) . "foreach (\$values as \$key => \$value)";
		$batchmove[] = Indent::_(4) . "{";
		$batchmove[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
			. " Do special action for access.";
		$batchmove[] = Indent::_(5)
			. "if ('access' === \$key && strlen(\$value) > 0)";
		$batchmove[] = Indent::_(5) . "{";
		$batchmove[] = Indent::_(6) . "\$this->table->\$key = \$value;";
		$batchmove[] = Indent::_(5) . "}";
		$batchmove[] = Indent::_(5)
			. "elseif (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchmove[] = Indent::_(5) . "{";
		$batchmove[] = Indent::_(6) . "\$this->table->\$key = \$value;";
		$batchmove[] = Indent::_(5) . "}";
		$batchmove[] = Indent::_(4) . "}";
		$batchmove[] = Indent::_(3) . "}" . PHP_EOL;

		$batchmove[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Check the row.";
		$batchmove[] = Indent::_(3) . "if (!\$this->table->check())";
		$batchmove[] = Indent::_(3) . "{";
		$batchmove[] = Indent::_(4)
			. "\$this->setError(\$this->table->getError());";

		$batchmove[] = PHP_EOL . Indent::_(4) . "return false;";
		$batchmove[] = Indent::_(3) . "}";

		$batchmove[] = PHP_EOL . Indent::_(3) . "if (!empty(\$this->type))";
		$batchmove[] = Indent::_(3) . "{";
		$batchmove[] = Indent::_(4)
			. "\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchmove[] = Indent::_(3) . "}";

		$batchmove[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Store the row.";
		$batchmove[] = Indent::_(3) . "if (!\$this->table->store())";
		$batchmove[] = Indent::_(3) . "{";
		$batchmove[] = Indent::_(4)
			. "\$this->setError(\$this->table->getError());";

		$batchmove[] = PHP_EOL . Indent::_(4) . "return false;";
		$batchmove[] = Indent::_(3) . "}";
		$batchmove[] = Indent::_(2) . "}";

		$batchmove[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Clean the cache";
		$batchmove[] = Indent::_(2) . "\$this->cleanCache();";

		$batchmove[] = PHP_EOL . Indent::_(2) . "return true;";
		$batchmove[] = Indent::_(1) . "}";

		return PHP_EOL . implode(PHP_EOL, $batchmove);
	}

	public function setBatchCopy($nameSingleCode)
	{
		// set needed defaults
		$title     = false;
		$titles    = [];
		// only load alias if set in this view
		$alias     = CFactory::_('Compiler.Builder.Alias')->get($nameSingleCode);
		$category  = CFactory::_('Compiler.Builder.Category.Code')->getString("{$nameSingleCode}.code");
		$batchcopy = [];
		$VIEW      = StringHelper::safe($nameSingleCode, 'U');
		// component helper name
		$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';

		// only load title if set in this view
		if (($customAliasBuilder = CFactory::_('Compiler.Builder.Custom.Alias')->get($nameSingleCode)) !== null)
		{
			$titles = array_values(
				$customAliasBuilder
			);
			$title  = true;
		}
		elseif (CFactory::_('Compiler.Builder.Title')->exists($nameSingleCode))
		{
			$titles = [CFactory::_('Compiler.Builder.Title')->get($nameSingleCode)];
			$title  = true;
		}
		// se the dynamic title
		if ($title)
		{
			// reset the bucket
			$titleData = [];
			// load the dynamic title builder
			foreach ($titles as $_title)
			{
				$titleData[] = "\$this->table->" . $_title;
			}
		}
		// prepare custom script
		$customScript = CFactory::_('Customcode.Dispenser')->get(
			'php_batchcopy', $nameSingleCode, PHP_EOL . PHP_EOL, null, true
		);

		$batchcopy[] = PHP_EOL . Indent::_(1) . "/**";
		$batchcopy[] = Indent::_(1)
			. " * Batch copy items to a new category or current.";
		$batchcopy[] = Indent::_(1) . " *";
		$batchcopy[] = Indent::_(1)
			. " * @param   integer  \$values    The new values.";
		$batchcopy[] = Indent::_(1)
			. " * @param   array    \$pks       An array of row IDs.";
		$batchcopy[] = Indent::_(1)
			. " * @param   array    \$contexts  An array of item contexts.";
		$batchcopy[] = Indent::_(1) . " *";
		$batchcopy[] = Indent::_(1)
			. " * @return  mixed  An array of new IDs on success, boolean false on failure.";
		$batchcopy[] = Indent::_(1) . " *";
		$batchcopy[] = Indent::_(1) . " * @since 12.2";
		$batchcopy[] = Indent::_(1) . " */";
		$batchcopy[] = Indent::_(1)
			. "protected function batchCopy(\$values, \$pks, \$contexts)";
		$batchcopy[] = Indent::_(1) . "{";

		$batchcopy[] = Indent::_(2) . "if (empty(\$this->batchSet))";
		$batchcopy[] = Indent::_(2) . "{";
		$batchcopy[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set some needed variables.";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$batchcopy[] = Indent::_(3)
				. "\$this->user 		= Factory::getUser();";
		}
		else
		{
			$batchcopy[] = Indent::_(3)
				. "\$this->user 		= Factory::getApplication()->getIdentity();";
		}
		$batchcopy[] = Indent::_(3)
			. "\$this->table 		= \$this->getTable();";
		$batchcopy[] = Indent::_(3)
			. "\$this->tableClassName	= get_class(\$this->table);";
		$batchcopy[] = Indent::_(3) . "\$this->canDo		= " . $Helper
			. "::getActions('" . $nameSingleCode . "');";
		$batchcopy[] = Indent::_(2) . "}";
		$batchcopy[] = PHP_EOL . Indent::_(2) . "if (!\$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.create') . "') && !\$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.batch') . "'))";
		$batchcopy[] = Indent::_(2) . "{";
		$batchcopy[] = Indent::_(3) . "return false;";
		$batchcopy[] = Indent::_(2) . "}" . $customScript;

		$batchcopy[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " get list of unique fields";
		$batchcopy[] = Indent::_(2)
			. "\$uniqueFields = \$this->getUniqueFields();";
		$batchcopy[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " remove move_copy from array";
		$batchcopy[] = Indent::_(2) . "unset(\$values['move_copy']);";

		$batchcopy[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " make sure published is set";
		$batchcopy[] = Indent::_(2) . "if (!isset(\$values['published']))";
		$batchcopy[] = Indent::_(2) . "{";
		$batchcopy[] = Indent::_(3) . "\$values['published'] = 0;";
		$batchcopy[] = Indent::_(2) . "}";
		$batchcopy[] = Indent::_(2)
			. "elseif (isset(\$values['published']) && !\$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit.state') . "'))";
		$batchcopy[] = Indent::_(2) . "{";
		$batchcopy[] = Indent::_(4) . "\$values['published'] = 0;";
		$batchcopy[] = Indent::_(2) . "}";

		if ($category)
		{
			$batchcopy[] = PHP_EOL . Indent::_(2)
				. "if (isset(\$values['category']) && (int) \$values['category'] > 0 && !static::checkCategoryId(\$values['category']))";
			$batchcopy[] = Indent::_(2) . "{";
			$batchcopy[] = Indent::_(3) . "return false;";
			$batchcopy[] = Indent::_(2) . "}";
			$batchcopy[] = Indent::_(2)
				. "elseif (isset(\$values['category']) && (int) \$values['category'] > 0)";
			$batchcopy[] = Indent::_(2) . "{";
			$batchcopy[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " move the category value to correct field name";
			$batchcopy[] = Indent::_(3) . "\$values['" . $category
				. "'] = \$values['category'];";
			$batchcopy[] = Indent::_(3) . "unset(\$values['category']);";
			$batchcopy[] = Indent::_(2) . "}";
			$batchcopy[] = Indent::_(2)
				. "elseif (isset(\$values['category']))";
			$batchcopy[] = Indent::_(2) . "{";
			$batchcopy[] = Indent::_(3) . "unset(\$values['category']);";
			$batchcopy[] = Indent::_(2) . "}";
		}

		$batchcopy[] = PHP_EOL . Indent::_(2) . "\$newIds = [];";

		$batchcopy[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Parent exists so let's proceed";
		$batchcopy[] = Indent::_(2) . "while (!empty(\$pks))";
		$batchcopy[] = Indent::_(2) . "{";
		$batchcopy[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Pop the first ID off the stack";
		$batchcopy[] = Indent::_(3) . "\$pk = array_shift(\$pks);";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "\$this->table->reset();";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " only allow copy if user may edit this item.";
		$batchcopy[] = Indent::_(3) . "if (!\$this->user->authorise('"
			. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit') . "', \$contexts[\$pk]))";
		$batchcopy[] = Indent::_(3) . "{";
		$batchcopy[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
			. " Not fatal error";
		$batchcopy[] = Indent::_(4) . "\$this->setError(Text:"
			. ":sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = Indent::_(4) . "continue;";
		$batchcopy[] = Indent::_(3) . "}";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Check that the row actually exists";
		$batchcopy[] = Indent::_(3) . "if (!\$this->table->load(\$pk))";
		$batchcopy[] = Indent::_(3) . "{";
		$batchcopy[] = Indent::_(4)
			. "if (\$error = \$this->table->getError())";
		$batchcopy[] = Indent::_(4) . "{";
		$batchcopy[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
			. " Fatal error";
		$batchcopy[] = Indent::_(5) . "\$this->setError(\$error);";

		$batchcopy[] = Indent::_(5) . "return false;";
		$batchcopy[] = Indent::_(4) . "}";
		$batchcopy[] = Indent::_(4) . "else";
		$batchcopy[] = Indent::_(4) . "{";
		$batchcopy[] = Indent::_(5) . "//" . Line::_(__Line__, __Class__)
			. " Not fatal error";
		$batchcopy[] = Indent::_(5) . "\$this->setError(Text:"
			. ":sprintf('JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', \$pk));";
		$batchcopy[] = Indent::_(5) . "continue;";
		$batchcopy[] = Indent::_(4) . "}";
		$batchcopy[] = Indent::_(3) . "}";
		if ($category && $alias === 'alias'
			&& ($title && count($titles) == 1
				&& in_array('title', $titles)))
		{
			$batchcopy[] = PHP_EOL . Indent::_(3) . "if (isset(\$values['"
				. $category . "']))";
			$batchcopy[] = Indent::_(3) . "{";
			$batchcopy[] = Indent::_(4)
				. "static::generateTitle((int) \$values['" . $category
				. "'], \$this->table);";
			$batchcopy[] = Indent::_(3) . "}";
			$batchcopy[] = Indent::_(3) . "else";
			$batchcopy[] = Indent::_(3) . "{";
			$batchcopy[] = Indent::_(4)
				. "static::generateTitle((int) \$this->table->" . $category
				. ", \$this->table);";
			$batchcopy[] = Indent::_(3) . "}";
		}
		elseif ($category && $alias && ($title && count($titles) == 1))
		{
			$batchcopy[] = PHP_EOL . Indent::_(3) . "if (isset(\$values['"
				. $category . "']))";
			$batchcopy[] = Indent::_(3) . "{";
			$batchcopy[] = Indent::_(4) . "list(\$this->table->" . implode(
					'', $titles
				) . ", \$this->table->" . $alias
				. ") = \$this->generateNewTitle(\$values['" . $category
				. "'], \$this->table->" . $alias . ", \$this->table->"
				. implode('', $titles) . ");";
			$batchcopy[] = Indent::_(3) . "}";
			$batchcopy[] = Indent::_(3) . "else";
			$batchcopy[] = Indent::_(3) . "{";
			$batchcopy[] = Indent::_(4) . "list(\$this->table->" . implode(
					'', $titles
				) . ", \$this->table->" . $alias
				. ") = \$this->generateNewTitle(\$this->table->" . $category
				. ", \$this->table->" . $alias . ", \$this->table->" . implode(
					'', $titles
				) . ");";
			$batchcopy[] = Indent::_(3) . "}";
		}
		elseif (!$category && $alias && ($title && count($titles) == 1))
		{
			$batchcopy[] = Indent::_(3) . "list(\$this->table->" . implode(
					'', $titles
				) . ", \$this->table->" . $alias
				. ") = \$this->_generateNewTitle(\$this->table->" . $alias
				. ", \$this->table->" . implode('', $titles) . ");";
		}
		elseif (!$category && $alias && $title)
		{
			$batchcopy[] = Indent::_(3) . "list(" . implode(', ', $titleData)
				. ", \$this->table->" . $alias
				. ") = \$this->_generateNewTitle(\$this->table->" . $alias
				. ", array(" . implode(', ', $titleData) . "));";
		}
		elseif (!$category && !$alias
			&& ($title && count($titles) == 1
				&& !in_array('user', $titles)
				&& !in_array(
					'jobnumber', $titles
				))) // TODO [jobnumber] just for one project (not ideal)
		{
			$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Only for strings";
			$batchcopy[] = Indent::_(3) . "if ("
				. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->table->" . implode('', $titles)
				. ") && !is_numeric(\$this->table->" . implode('', $titles)
				. "))";
			$batchcopy[] = Indent::_(3) . "{";
			$batchcopy[] = Indent::_(4) . "\$this->table->" . implode(
					'', $titles
				) . " = \$this->generateUnique('" . implode('', $titles)
				. "',\$this->table->" . implode('', $titles) . ");";
			$batchcopy[] = Indent::_(3) . "}";
		}

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " insert all set values";
		$batchcopy[] = Indent::_(3) . "if ("
			. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$values))";
		$batchcopy[] = Indent::_(3) . "{";
		$batchcopy[] = Indent::_(4) . "foreach (\$values as \$key => \$value)";
		$batchcopy[] = Indent::_(4) . "{";
		$batchcopy[] = Indent::_(5)
			. "if (strlen(\$value) > 0 && isset(\$this->table->\$key))";
		$batchcopy[] = Indent::_(5) . "{";
		$batchcopy[] = Indent::_(6) . "\$this->table->\$key = \$value;";
		$batchcopy[] = Indent::_(5) . "}";
		$batchcopy[] = Indent::_(4) . "}";
		$batchcopy[] = Indent::_(3) . "}" . PHP_EOL;

		$batchcopy[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " update all unique fields";
		$batchcopy[] = Indent::_(3) . "if ("
			. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uniqueFields))";
		$batchcopy[] = Indent::_(3) . "{";
		$batchcopy[] = Indent::_(4)
			. "foreach (\$uniqueFields as \$uniqueField)";
		$batchcopy[] = Indent::_(4) . "{";
		$batchcopy[] = Indent::_(5)
			. "\$this->table->\$uniqueField = \$this->generateUnique(\$uniqueField,\$this->table->\$uniqueField);";
		$batchcopy[] = Indent::_(4) . "}";
		$batchcopy[] = Indent::_(3) . "}";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Reset the ID because we are making a copy";
		$batchcopy[] = Indent::_(3) . "\$this->table->id = 0;";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " TODO: Deal with ordering?";
		$batchcopy[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " \$this->table->ordering = 1;";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Check the row.";
		$batchcopy[] = Indent::_(3) . "if (!\$this->table->check())";
		$batchcopy[] = Indent::_(3) . "{";
		$batchcopy[] = Indent::_(4)
			. "\$this->setError(\$this->table->getError());";

		$batchcopy[] = PHP_EOL . Indent::_(4) . "return false;";
		$batchcopy[] = Indent::_(3) . "}";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "if (!empty(\$this->type))";
		$batchcopy[] = Indent::_(3) . "{";
		$batchcopy[] = Indent::_(4)
			. "\$this->createTagsHelper(\$this->tagsObserver, \$this->type, \$pk, \$this->typeAlias, \$this->table);";
		$batchcopy[] = Indent::_(3) . "}";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Store the row.";
		$batchcopy[] = Indent::_(3) . "if (!\$this->table->store())";
		$batchcopy[] = Indent::_(3) . "{";
		$batchcopy[] = Indent::_(4)
			. "\$this->setError(\$this->table->getError());";

		$batchcopy[] = PHP_EOL . Indent::_(4) . "return false;";
		$batchcopy[] = Indent::_(3) . "}";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Get the new item ID";
		$batchcopy[] = Indent::_(3) . "\$newId = \$this->table->get('id');";

		$batchcopy[] = PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Add the new ID to the array";
		$batchcopy[] = Indent::_(3) . "\$newIds[\$pk] = \$newId;";
		$batchcopy[] = Indent::_(2) . "}";

		$batchcopy[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Clean the cache";
		$batchcopy[] = Indent::_(2) . "\$this->cleanCache();";

		$batchcopy[] = PHP_EOL . Indent::_(2) . "return \$newIds;";
		$batchcopy[] = Indent::_(1) . "}";

		return PHP_EOL . implode(PHP_EOL, $batchcopy);
	}

	public function setAliasTitleFix($nameSingleCode)
	{
		$fixUnique = [];
		// only load this if these two items are set
		if (CFactory::_('Compiler.Builder.Alias')->exists($nameSingleCode)
			&& (CFactory::_('Compiler.Builder.Title')->exists($nameSingleCode)
				|| CFactory::_('Compiler.Builder.Custom.Alias')->exists($nameSingleCode)))
		{
			// set needed defaults
			$category = CFactory::_('Compiler.Builder.Category.Code')->getString("{$nameSingleCode}.code");
			$alias       = CFactory::_('Compiler.Builder.Alias')->get($nameSingleCode);
			$VIEW        = StringHelper::safe(
				$nameSingleCode, 'U'
			);
			// set the title stuff
			if (($customAliasBuilder = CFactory::_('Compiler.Builder.Custom.Alias')->get($nameSingleCode)) !== null)
			{
				$titles = array_values(
					$customAliasBuilder
				);
			}
			else
			{
				$titles = [CFactory::_('Compiler.Builder.Title')->get($nameSingleCode)];
			}
			// start building the fix
			$fixUnique[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Alter the " . implode(', ', $titles)
				. " for save as copy";
			$fixUnique[] = Indent::_(2)
				. "if (\$input->get('task') === 'save2copy')";
			$fixUnique[] = Indent::_(2) . "{";
			$fixUnique[] = Indent::_(3)
				. "\$origTable = clone \$this->getTable();";
			$fixUnique[] = Indent::_(3)
				. "\$origTable->load(\$input->getInt('id'));";
			// reset the buckets
			$ifStatment  = [];
			$titleVars   = [];
			$titleData   = [];
			$titleUpdate = [];
			// load the dynamic title builder
			foreach ($titles as $title)
			{
				$ifStatment[]  = "\$data['" . $title . "'] == \$origTable->"
					. $title;
				$titleVars[]   = "\$" . $title;
				$titleData[]   = "\$data['" . $title . "']";
				$titleUpdate[] = Indent::_(4) . "\$data['" . $title . "'] = \$"
					. $title . ";";
			}
			$fixUnique[] = PHP_EOL . Indent::_(3) . "if (" . implode(
					' || ', $ifStatment
				) . ")";
			$fixUnique[] = Indent::_(3) . "{";
			if ($category !== null && count((array) $titles) == 1)
			{
				$fixUnique[] = Indent::_(4) . "list(" . implode('', $titleVars)
					. ", \$" . $alias . ") = \$this->generateNewTitle(\$data['"
					. $category . "'], \$data['" . $alias . "'], " . implode(
						'', $titleData
					) . ");";
			}
			elseif (count((array) $titles) == 1)
			{
				$fixUnique[] = Indent::_(4) . "list(" . implode(
						', ', $titleVars
					)
					. ", \$" . $alias . ") = \$this->_generateNewTitle(\$data['"
					. $alias . "'], " . implode('', $titleData) . ");";
			}
			else
			{
				$fixUnique[] = Indent::_(4) . "list(" . implode(
						', ', $titleVars
					)
					. ", \$" . $alias . ") = \$this->_generateNewTitle(\$data['"
					. $alias . "'], array(" . implode(', ', $titleData) . "));";
			}
			$fixUnique[] = implode("\n", $titleUpdate);
			$fixUnique[] = Indent::_(4) . "\$data['" . $alias . "'] = \$"
				. $alias . ";";
			$fixUnique[] = Indent::_(3) . "}";
			$fixUnique[] = Indent::_(3) . "else";
			$fixUnique[] = Indent::_(3) . "{";
			$fixUnique[] = Indent::_(4) . "if (\$data['" . $alias
				. "'] == \$origTable->" . $alias . ")";
			$fixUnique[] = Indent::_(4) . "{";
			$fixUnique[] = Indent::_(5) . "\$data['" . $alias . "'] = '';";
			$fixUnique[] = Indent::_(4) . "}";
			$fixUnique[] = Indent::_(3) . "}";
			$fixUnique[] = PHP_EOL . Indent::_(3) . "\$data['published'] = 0;";
			$fixUnique[] = Indent::_(2) . "}";
			$fixUnique[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Automatic handling of " . $alias . " for empty fields";
			$fixUnique[] = Indent::_(2)
				. "if (in_array(\$input->get('task'), array('apply', 'save', 'save2new')) && (int) \$input->get('id') == 0)";
			$fixUnique[] = Indent::_(2) . "{";
			$fixUnique[] = Indent::_(3) . "if (\$data['" . $alias
				. "'] == null || empty(\$data['" . $alias . "']))";
			$fixUnique[] = Indent::_(3) . "{";
			$fixUnique[] = Indent::_(4)
				. "if (Factory::getConfig()->get('unicodeslugs') == 1)";
			$fixUnique[] = Indent::_(4) . "{";
			$fixUnique[] = Indent::_(5) . "\$data['" . $alias
				. "'] = OutputFilter::stringURLUnicodeSlug(" . implode(
					' . " " . ', $titleData
				) . ");";
			$fixUnique[] = Indent::_(4) . "}";
			$fixUnique[] = Indent::_(4) . "else";
			$fixUnique[] = Indent::_(4) . "{";
			$fixUnique[] = Indent::_(5) . "\$data['" . $alias
				. "'] = OutputFilter::stringURLSafe(" . implode(
					' . " " . ', $titleData
				) . ");";
			$fixUnique[] = Indent::_(4) . "}";
			$fixUnique[] = PHP_EOL . Indent::_(4)
				. "\$table = clone \$this->getTable();";
			if ($category !== null && count($titles) == 1)
			{
				$fixUnique[] = PHP_EOL . Indent::_(4)
					. "if (\$table->load(['" . $alias . "' => \$data['"
					. $alias . "'], '" . $category . "' => \$data['" . $category
					. "']]) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUnique[] = Indent::_(4) . "{";
				$fixUnique[] = Indent::_(5) . "\$msg = Text:" . ":_('COM_"
					. CFactory::_('Compiler.Builder.Content.One')->get('COMPONENT') . "_" . $VIEW . "_SAVE_WARNING');";
				$fixUnique[] = Indent::_(4) . "}";
				$fixUnique[] = PHP_EOL . Indent::_(4) . "list(" . implode(
						'', $titleVars
					) . ", \$" . $alias
					. ") = \$this->generateNewTitle(\$data['" . $category
					. "'], \$data['" . $alias . "'], " . implode('', $titleData)
					. ");";
				$fixUnique[] = Indent::_(4) . "\$data['" . $alias . "'] = \$"
					. $alias . ";";
			}
			else
			{
				$fixUnique[] = PHP_EOL . Indent::_(4)
					. "if (\$table->load(array('" . $alias . "' => \$data['"
					. $alias
					. "'])) && (\$table->id != \$data['id'] || \$data['id'] == 0))";
				$fixUnique[] = Indent::_(4) . "{";
				$fixUnique[] = Indent::_(5) . "\$msg = Text:" . ":_('COM_"
					. CFactory::_('Compiler.Builder.Content.One')->get('COMPONENT') . "_" . $VIEW . "_SAVE_WARNING');";
				$fixUnique[] = Indent::_(4) . "}";
				$fixUnique[] = PHP_EOL . Indent::_(4) . "\$data['" . $alias
					. "'] = \$this->_generateNewTitle(\$data['" . $alias
					. "']);";
			}
			$fixUnique[] = PHP_EOL . Indent::_(4) . "if (isset(\$msg))";
			$fixUnique[] = Indent::_(4) . "{";
			$fixUnique[] = Indent::_(5)
				. "Factory::getApplication()->enqueueMessage(\$msg, 'warning');";
			$fixUnique[] = Indent::_(4) . "}";
			$fixUnique[] = Indent::_(3) . "}";
			$fixUnique[] = Indent::_(2) . "}";

//			$fixUnique[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__) . " Update alias if still empty at this point";
//			$fixUnique[] = Indent::_(2) . "if (\$data['" . $alias . "'] == null || empty(\$data['" . $alias . "']))";
//			$fixUnique[] = Indent::_(2) . "{";
//			$fixUnique[] = Indent::_(3) . "if (Factory::getConfig()->get('unicodeslugs') == 1)";
//			$fixUnique[] = Indent::_(3) . "{";
//			$fixUnique[] = Indent::_(4) . "\$data['" . $alias . "'] = OutputFilter::stringURLUnicodeSlug(" . implode(' . " " . ', $titleData) . ");";
//			$fixUnique[] = Indent::_(3) . "}";
//			$fixUnique[] = Indent::_(3) . "else";
//			$fixUnique[] = Indent::_(3) . "{";
//			$fixUnique[] = Indent::_(4) . "\$data['" . $alias . "'] = OutputFilter::stringURLSafe(" . implode(' . " " . ', $titleData) . ");";
//			$fixUnique[] = Indent::_(3) . "}";
//			$fixUnique[] = Indent::_(2) . "}";
		}
		// handel other unique fields
		$fixUnique[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Alter the unique field for save as copy";
		$fixUnique[] = Indent::_(2)
			. "if (\$input->get('task') === 'save2copy')";
		$fixUnique[] = Indent::_(2) . "{";
		$fixUnique[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Automatic handling of other unique fields";
		$fixUnique[] = Indent::_(3)
			. "\$uniqueFields = \$this->getUniqueFields();";
		$fixUnique[] = Indent::_(3) . "if ("
			. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uniqueFields))";
		$fixUnique[] = Indent::_(3) . "{";
		$fixUnique[] = Indent::_(4)
			. "foreach (\$uniqueFields as \$uniqueField)";
		$fixUnique[] = Indent::_(4) . "{";
		$fixUnique[] = Indent::_(5)
			. "\$data[\$uniqueField] = \$this->generateUnique(\$uniqueField,\$data[\$uniqueField]);";
		$fixUnique[] = Indent::_(4) . "}";
		$fixUnique[] = Indent::_(3) . "}";
		$fixUnique[] = Indent::_(2) . "}";

		return PHP_EOL . implode(PHP_EOL, $fixUnique);
	}

	public function setGenerateNewTitle($nameSingleCode)
	{
		// if category is added to this view then do nothing
		if (CFactory::_('Compiler.Builder.Alias')->exists($nameSingleCode)
			&& (CFactory::_('Compiler.Builder.Title')->exists($nameSingleCode)
				|| CFactory::_('Compiler.Builder.Custom.Alias')->exists($nameSingleCode)))
		{
			// get component name
			$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
			// rest the new function
			$newFunction   = [];
			$newFunction[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$newFunction[] = Indent::_(1)
				. " * Method to change the title/s & alias.";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1)
				. " * @param   string         \$alias        The alias.";
			$newFunction[] = Indent::_(1)
				. " * @param   string/array   \$title        The title.";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1)
				. " * @return	array/string  Contains the modified title/s and/or alias.";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1) . " */";
			$newFunction[] = Indent::_(1)
				. "protected function _generateNewTitle(\$alias, \$title = null)";
			$newFunction[] = Indent::_(1) . "{";
			$newFunction[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Alter the title/s & alias";
			$newFunction[] = Indent::_(2) . "\$table = \$this->getTable();";
			$newFunction[] = PHP_EOL . Indent::_(2)
				. "while (\$table->load(['alias' => \$alias]))";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Check if this is an array of titles";
			$newFunction[] = Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$title))";
			$newFunction[] = Indent::_(3) . "{";
			$newFunction[] = Indent::_(4)
				. "foreach(\$title as \$nr => &\$_title)";
			$newFunction[] = Indent::_(4) . "{";
			$newFunction[] = Indent::_(5)
				. "\$_title = StringHelper::increment(\$_title);";
			$newFunction[] = Indent::_(4) . "}";
			$newFunction[] = Indent::_(3) . "}";
			$newFunction[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Make sure we have a title";
			$newFunction[] = Indent::_(3) . "elseif (\$title)";
			$newFunction[] = Indent::_(3) . "{";
			$newFunction[] = Indent::_(4)
				. "\$title = StringHelper::increment(\$title);";
			$newFunction[] = Indent::_(3) . "}";
			$newFunction[] = Indent::_(3)
				. "\$alias = StringHelper::increment(\$alias, 'dash');";
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Check if this is an array of titles";
			$newFunction[] = Indent::_(2) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$title))";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3) . "\$title[] = \$alias;";
			$newFunction[] = Indent::_(3) . "return \$title;";
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Make sure we have a title";
			$newFunction[] = Indent::_(2) . "elseif (\$title)";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3) . "return array(\$title, \$alias);";
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " We only had an alias";
			$newFunction[] = Indent::_(2) . "return \$alias;";
			$newFunction[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $newFunction);
		}
		elseif (CFactory::_('Compiler.Builder.Title')->exists($nameSingleCode))
		{
			$newFunction   = [];
			$newFunction[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$newFunction[] = Indent::_(1) . " * Method to change the title";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1)
				. " * @param   string   \$title   The title.";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1)
				. " * @return	array  Contains the modified title and alias.";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1) . " */";
			$newFunction[] = Indent::_(1)
				. "protected function _generateNewTitle(\$title)";
			$newFunction[] = Indent::_(1) . "{";
			$newFunction[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Alter the title";
			$newFunction[] = Indent::_(2) . "\$table = \$this->getTable();";
			$newFunction[] = PHP_EOL . Indent::_(2)
				. "while (\$table->load(['title' => \$title]))";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3)
				. "\$title = StringHelper::increment(\$title);";
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = PHP_EOL . Indent::_(2) . "return \$title;";
			$newFunction[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $newFunction);
		}

		return '';
	}

	public function setGenerateNewAlias($nameSingleCode)
	{
		// make sure this view has an alias
		if (CFactory::_('Compiler.Builder.Alias')->exists($nameSingleCode))
		{
			// set the title stuff
			if (($customAliasBuilder = CFactory::_('Compiler.Builder.Custom.Alias')->get($nameSingleCode)) !== null)
			{
				$titles = array_values(
					$customAliasBuilder
				);
			}
			elseif (CFactory::_('Compiler.Builder.Title')->exists($nameSingleCode))
			{
				$titles = [CFactory::_('Compiler.Builder.Title')->get($nameSingleCode)];
			}
			// reset the bucket
			$titleData = [];
			// load the dynamic title builder
			if (isset($titles) && ArrayHelper::check($titles))
			{
				foreach ($titles as $title)
				{
					$titleData[] = "\$this->" . $title;
				}
			}
			else
			{
				$titleData
					= array("'-'"); // just encase some mad man does not set a title/customAlias (we fall back on the date)
			}
			// rest the new function
			$newFunction   = [];
			$newFunction[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$newFunction[] = Indent::_(1)
				. " * Generate a valid alias from title / date.";
			$newFunction[] = Indent::_(1)
				. " * Remains public to be able to check for duplicated alias before saving";
			$newFunction[] = Indent::_(1) . " *";
			$newFunction[] = Indent::_(1) . " * @return  string";
			$newFunction[] = Indent::_(1) . " */";
			$newFunction[] = Indent::_(1) . "public function generateAlias()";
			$newFunction[] = Indent::_(1) . "{";
			$newFunction[] = Indent::_(2) . "if (empty(\$this->alias))";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3) . "\$this->alias = " . implode(
					".' '.", $titleData
				) . ';';
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = PHP_EOL . Indent::_(2)
				. "\$this->alias = ApplicationHelper::stringURLSafe(\$this->alias);";
			$newFunction[] = PHP_EOL . Indent::_(2)
				. "if (trim(str_replace('-', '', \$this->alias)) == '')";
			$newFunction[] = Indent::_(2) . "{";
			$newFunction[] = Indent::_(3)
				. "\$this->alias = Factory::getDate()->format('Y-m-d-H-i-s');";
			$newFunction[] = Indent::_(2) . "}";
			$newFunction[] = PHP_EOL . Indent::_(2) . "return \$this->alias;";
			$newFunction[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $newFunction);
		}
		// rest the new function
		$newFunction   = [];
		$newFunction[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$newFunction[] = Indent::_(1)
			. " * This view does not actually have an alias";
		$newFunction[] = Indent::_(1) . " *";
		$newFunction[] = Indent::_(1) . " * @return  bool";
		$newFunction[] = Indent::_(1) . " */";
		$newFunction[] = Indent::_(1) . "public function generateAlias()";
		$newFunction[] = Indent::_(1) . "{";
		$newFunction[] = Indent::_(2) . "return false;";
		$newFunction[] = Indent::_(1) . "}";

		return implode(PHP_EOL, $newFunction);
	}

	public function setInstall()
	{
		if (($database_tables = CFactory::_('Compiler.Builder.Database.Tables')->allActive()) !== [])
		{
			// set the main db prefix
			$component = CFactory::_('Config')->component_code_name;
			// start building the db
			$db = '';
			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$db .= 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";' . PHP_EOL;
				$db .= 'SET time_zone = "+00:00";' . PHP_EOL . PHP_EOL;;
			}

			foreach ($database_tables as $view => $fields)
			{
				// cast the object to an array TODO we must update all to use the object
				$fields = (array) $fields;
				// build the uninstallation array
				CFactory::_('Compiler.Builder.Database.Uninstall')->add('table', "DROP TABLE IF EXISTS `#__"
					. $component . "_" . $view . "`;");

				// setup the table DB string
				$db_ = '';
				$db_ .= "CREATE TABLE IF NOT EXISTS `#__" . $component . "_"
					. $view . "` (";
				// check if the table name has changed
				if (($old_table_name = CFactory::_('Registry')->
					get('builder.update_sql.table_name.' . $view . '.old', null)) !== null)
				{
					$key_ = "RENAMETABLE`#__" . $component . "_" . $old_table_name . "`";
					$value_ = "RENAME TABLE `#__" . $component . "_" . $old_table_name . "` to `#__"
						. $component . "_" . $view . "`;";

					CFactory::_('Compiler.Builder.Update.Mysql')->set($key_, $value_);
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.id'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`id` INT(11) NOT NULL AUTO_INCREMENT,";
				}
				$db_ .= PHP_EOL . Indent::_(1)
					. "`asset_id` INT(10) unsigned NULL DEFAULT 0 COMMENT 'FK to the #__assets table.',";
				ksort($fields);
				$last_name = 'asset_id';
				foreach ($fields as $field => $data)
				{
					// cast the object to an array TODO we must update all to use the object
					$data = (array) $data;
					// set default
					$default = $data['default'];
					if ($default === 'Other')
					{
						$default = $data['other'];
					}
					// to get just null value add EMPTY to other value.
					if ($default === 'EMPTY')
					{
						$default = $data['null_switch'];
					}
					elseif ($default === 'DATETIME'
						|| $default === 'CURRENT_TIMESTAMP')
					{
						$default = $data['null_switch'] . ' DEFAULT '
							. $default;
					}
					elseif (is_numeric($default))
					{
						$default = $data['null_switch'] . " DEFAULT "
							. $default;
					}
					else
					{
						$default = $data['null_switch'] . " DEFAULT '"
							. $default . "'";
					}

					// set the length (lenght) <-- TYPO :: LVDM :: DON'T TOUCH
					$length = '';
					if (isset($data['lenght']) && $data['lenght'] === 'Other'
						&& isset($data['lenght_other'])
						&& $data['lenght_other'] > 0)
					{
						$length = '(' . $data['lenght_other'] . ')';
					}
					elseif (isset($data['lenght']) && $data['lenght'] > 0)
					{
						$length = '(' . $data['lenght'] . ')';
					}
					// set the field to db
					$db_ .= PHP_EOL . Indent::_(1) . "`" . $field . "` "
						. $data['type'] . $length . " " . $default . ",";
					// check if this a new field that should be added via SQL update
					if (CFactory::_('Registry')->
						get('builder.add_sql.field.' . $view . '.' . $data['ID'], null))
					{
						// to soon....
						// $key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`ADDCOLUMNIFNOTEXISTS`" . $field . "`";
						// $value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` ADD COLUMN IF NOT EXISTS `" . $field . "` " . $data['type']
						//	. length . " " . $default . " AFTER `" . $last_name . "`;";
						$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`ADD`" . $field . "`";
						$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` ADD `" . $field . "` " . $data['type']
							. $length . " " . $default . " AFTER `" . $last_name . "`;";

						CFactory::_('Compiler.Builder.Update.Mysql')->set($key_, $value_);
					}
					// check if the field has changed name and/or data type and lenght
					elseif (CFactory::_('Registry')->
						get('builder.update_sql.field.datatype.' . $view . '.' . $field, null)
						|| CFactory::_('Registry')->
						get('builder.update_sql.field.lenght.' . $view . '.' . $field, null)
						|| CFactory::_('Registry')->
						get('builder.update_sql.field.name.' . $view . '.' . $field, null))
					{
						// if the name changed
						if (($oldName = CFactory::_('Registry')->
							get('builder.update_sql.field.name.' . $view . '.' . $field . '.old', null)) === null)
						{
							$oldName = $field;
						}

						// now set the update SQL
						$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`CHANGE`" . $oldName . "``"
							. $field . "`";
						$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` CHANGE `" . $oldName . "` `"
							. $field . "` " . $data['type'] . $length . " " . $default . ";";

						CFactory::_('Compiler.Builder.Update.Mysql')->set($key_, $value_);
					}
					// be sure to track the last name used :)
					$last_name = $field;
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.params'))
				{
					$db_ .= PHP_EOL . Indent::_(1) . "`params` TEXT NULL,";
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.published'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`published` TINYINT(3) NULL DEFAULT 1,";
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.created_by'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`created_by` INT(10) unsigned NULL DEFAULT 0,";
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.modified_by'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`modified_by` INT(10) unsigned NULL DEFAULT 0,";
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.created'))
				{
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						$db_ .= PHP_EOL . Indent::_(1)
							. "`created` DATETIME NULL DEFAULT '0000-00-00 00:00:00',";
					}
					else
					{
						$db_ .= PHP_EOL . Indent::_(1)
							. "`created` DATETIME DEFAULT CURRENT_TIMESTAMP,";
					}
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.modified'))
				{
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						$db_ .= PHP_EOL . Indent::_(1)
							. "`modified` DATETIME NULL DEFAULT '0000-00-00 00:00:00',";
					}
					else
					{
						$db_ .= PHP_EOL . Indent::_(1)
							. "`modified` DATETIME DEFAULT NULL,";
					}
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.checked_out'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`checked_out` int(11) unsigned NULL DEFAULT 0,";
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.checked_out_time'))
				{
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						$db_ .= PHP_EOL . Indent::_(1)
							. "`checked_out_time` DATETIME NULL DEFAULT '0000-00-00 00:00:00',";
					}
					else
					{
						$db_ .= PHP_EOL . Indent::_(1)
							. "`checked_out_time` DATETIME DEFAULT NULL,";
					}
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.version'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`version` INT(10) unsigned NULL DEFAULT 1,";
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.hits'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`hits` INT(10) unsigned NULL DEFAULT 0,";
				}
				// check if view has access
				if (CFactory::_('Compiler.Builder.Access.Switch')->exists($view)
					&& !CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.access'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`access` INT(10) unsigned NULL DEFAULT 0,";
						// add to component dynamic fields
						CFactory::_('Compiler.Builder.Component.Fields')->set($view . '.access',
							[
								'name' => 'access',
								'label' => 'Access',
								'type' => 'accesslevel',
								'title' => false,
								'store' => NULL,
								'tab_name' => NULL,
								'db' => [
									'type' => 'INT(10) unsigned',
									'default' => '0',
									'key' => true,
									'null_switch' => 'NULL'
								]
							]
						);
				}
				// check if default field was overwritten
				if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.ordering'))
				{
					$db_ .= PHP_EOL . Indent::_(1)
						. "`ordering` INT(11) NULL DEFAULT 0,";
				}
				// check if metadata is added to this view
				if (CFactory::_('Compiler.Builder.Meta.Data')->isString($view))
				{
					// check if default field was overwritten
					if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.metakey'))
					{
						if (CFactory::_('Config')->get('joomla_version', 3) == 3)
						{
							$db_ .= PHP_EOL . Indent::_(1)
								. "`metakey` TEXT NULL,";
						}
						else
						{
							$db_ .= PHP_EOL . Indent::_(1)
								. "`metakey` TEXT,";
						}
					}
					// check if default field was overwritten
					if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.metadesc'))
					{
						if (CFactory::_('Config')->get('joomla_version', 3) == 3)
						{
							$db_ .= PHP_EOL . Indent::_(1)
								. "`metadesc` TEXT NULL,";
						}
						else
						{
							$db_ .= PHP_EOL . Indent::_(1)
								. "`metadesc` TEXT,";
						}
					}
					// check if default field was overwritten
					if (!CFactory::_('Compiler.Builder.Field.Names')->isString($view . '.metadata'))
					{
						if (CFactory::_('Config')->get('joomla_version', 3) == 3)
						{
							$db_ .= PHP_EOL . Indent::_(1)
								. "`metadata` TEXT NULL,";
						}
						else
						{
							$db_ .= PHP_EOL . Indent::_(1)
								. "`metadata` TEXT,";
						}
					}
					// add to component dynamic fields
					CFactory::_('Compiler.Builder.Component.Fields')->set($view . '.metakey',
						[
							'name' => 'metakey',
							'label' => 'Meta Keywords',
							'type' => 'textarea',
							'title' => false,
							'store' => NULL,
							'tab_name' => 'publishing',
							'db' => [
								'type' => 'TEXT'
							]
						]
					);
					CFactory::_('Compiler.Builder.Component.Fields')->set($view . '.metadesc',
						[
							'name' => 'metadesc',
							'label' => 'Meta Description',
							'type' => 'textarea',
							'title' => false,
							'store' => NULL,
							'tab_name' => 'publishing',
							'db' => [
								'type' => 'TEXT'
							]
						]
					);
					CFactory::_('Compiler.Builder.Component.Fields')->set($view . '.metadata',
						[
							'name' => 'metadata',
							'label' => 'Meta Data',
							'type' => NULL,
							'title' => false,
							'store' => 'json',
							'tab_name' => 'publishing',
							'db' => [
								'type' => 'TEXT'
							]
						]
					);
				}
				// TODO (we may want this to be dynamicly set)
				$db_ .= PHP_EOL . Indent::_(1) . "PRIMARY KEY  (`id`)";
				// check if a key was set for any of the default fields then we should not set it again
				$check_keys_set = [];
				if (CFactory::_('Compiler.Builder.Database.Unique.Keys')->exists($view))
				{
					foreach (CFactory::_('Compiler.Builder.Database.Unique.Keys')->get($view) as $nr => $key)
					{
						$db_ .= "," . PHP_EOL . Indent::_(1)
							. "UNIQUE KEY `idx_" . $key . "` (`" . $key . "`)";
						$check_keys_set[$key] = $key;
					}
				}
				if (CFactory::_('Compiler.Builder.Database.Keys')->exists($view))
				{
					foreach (CFactory::_('Compiler.Builder.Database.Keys')->get($view) as $nr => $key)
					{
						$db_ .= "," . PHP_EOL . Indent::_(1)
							. "KEY `idx_" . $key . "` (`" . $key . "`)";
						$check_keys_set[$key] = $key;
					}
				}
				// check if view has access
				if (!isset($check_keys_set['access'])
					&& CFactory::_('Compiler.Builder.Access.Switch')->exists($view))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_access` (`access`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['checked_out']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_checkout` (`checked_out`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['created_by']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_createdby` (`created_by`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['modified_by']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_modifiedby` (`modified_by`)";
				}
				// check if default field was overwritten
				if (!isset($check_keys_set['published']))
				{
					$db_ .= "," . PHP_EOL . Indent::_(1)
						. "KEY `idx_state` (`published`)";
				}
				// easy bucket
				$easy = [];
				// get the mysql table settings
				foreach (
					CFactory::_('Config')->mysql_table_keys as $_mysqlTableKey => $_mysqlTableVal
				)
				{
					if (($easy[$_mysqlTableKey] = CFactory::_('Compiler.Builder.Mysql.Table.Setting')->
						get($view . '.' . $_mysqlTableKey)) === null)
					{
						$easy[$_mysqlTableKey]
							= CFactory::_('Config')->mysql_table_keys[$_mysqlTableKey]['default'];
					}
				}
				// add a little fix for the row_format
				if (StringHelper::check($easy['row_format']))
				{
					$easy['row_format'] = ' ROW_FORMAT=' . $easy['row_format'];
				}
				// now build db string
				$db_ .= PHP_EOL . ") ENGINE=" . $easy['engine']
					. " AUTO_INCREMENT=0 DEFAULT CHARSET=" . $easy['charset']
					. " DEFAULT COLLATE=" . $easy['collate']
					. $easy['row_format'] . ";";

				// check if this is a new table that should be added via update SQL
				if (CFactory::_('Registry')->
					get('builder.add_sql.adminview.' . $view, null))
				{
					// build the update array
					$key_ = "CREATETABLEIFNOTEXISTS`#__" . $component . "_" . $view . "`";
					CFactory::_('Compiler.Builder.Update.Mysql')->set($key_, $db_);
				}
				// check if the table row_format has changed
				if (StringHelper::check($easy['row_format'])
					&& CFactory::_('Registry')->
					get('builder.update_sql.table_row_format.' . $view, null))
				{
					// build the update array
					$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`" . trim((string) $easy['row_format']);
					$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "`" . $easy['row_format'] . ";";
					CFactory::_('Compiler.Builder.Update.Mysql')->set($key_, $value_);
				}
				// check if the table engine has changed
				if (CFactory::_('Registry')->
					get('builder.update_sql.table_engine.' . $view, null))
				{
					// build the update array
					$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "`ENGINE=" . $easy['engine'];
					$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` ENGINE = " . $easy['engine'] . ";";
					CFactory::_('Compiler.Builder.Update.Mysql')->set($key_, $value_);
				}
				// check if the table charset OR collation has changed (must be updated together)
				if (CFactory::_('Registry')->
					get('builder.update_sql.table_charset.' . $view, null)
					|| CFactory::_('Registry')->
					get('builder.update_sql.table_collate.' . $view, null))
				{
					// build the update array
					$key_ = "ALTERTABLE`#__" . $component . "_" . $view . "CONVERTTOCHARACTERSET"
						. $easy['charset'] . "COLLATE" . $easy['collate'];
					$value_ = "ALTER TABLE `#__" . $component . "_" . $view . "` CONVERT TO CHARACTER SET "
						. $easy['charset'] . " COLLATE " . $easy['collate'] . ";";

					CFactory::_('Compiler.Builder.Update.Mysql')->set($key_, $value_);
				}

				// add to main DB string
				$db .= $db_ . PHP_EOL . PHP_EOL;
			}

			// add custom sql dump to the file
			if (isset(CFactory::_('Customcode.Dispenser')->hub['sql'])
				&& ArrayHelper::check(
					CFactory::_('Customcode.Dispenser')->hub['sql']
				))
			{
				foreach (CFactory::_('Customcode.Dispenser')->hub['sql'] as $for => $customSql)
				{
					$placeholders = [
						Placefix::_('component') => $component,
						Placefix::_('view') => $for
					]; // dont change this just use ###view### or componentbuilder (took you a while to get here right :)

					$db .= CFactory::_('Placeholder')->update(
						$customSql, $placeholders
					) . PHP_EOL . PHP_EOL;
				}

				unset(CFactory::_('Customcode.Dispenser')->hub['sql']);
			}

			// WHY DO WE NEED AN ASSET TABLE FIX?
			// https://www.mysqltutorial.org/mysql-varchar/
			// https://stackoverflow.com/a/15227917/1429677
			// https://forums.mysql.com/read.php?24,105964,105964
			// https://github.com/vdm-io/Joomla-Component-Builder/issues/616#issuecomment-741502980
			// 30 actions each +-20 characters with 8 groups
			// that makes 4800 characters and the current Joomla
			// column size is varchar(5120)

			// just a little event tracking in classes
			// count actions = setAccessSections
			//                 around line206 (infusion call)
			//                 around line26454 (interpretation function)
			// first fix = setInstall
			//                 around line1600 (infusion call)
			//                 around line10063 (interpretation function)
			// second fix = setUninstallScript
			//                 around line2161 (infusion call)
			//                 around line8030 (interpretation function)

			// check if this component needs larger rules
			// also check if the developer will allow this
			// the access actions length must be checked before this
			// only add this option if set to SQL fix
			if (CFactory::_('Config')->add_assets_table_fix == 1)
			{
				// 400 actions worse case is larger the 65535 characters
				if (CFactory::_('Utilities.Counter')->accessSize > 400)
				{
					$db .= PHP_EOL;
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. '--' . Line::_(
							__LINE__,__CLASS__
						)
						. ' Always insure this column rules is large enough for all the access control values.';
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. "ALTER TABLE `#__assets` CHANGE `rules` `rules` MEDIUMTEXT NOT NULL COMMENT 'JSON encoded access control. Enlarged to MEDIUMTEXT by JCB';";
				}
				// smaller then 400 makes TEXT large enough
				elseif (CFactory::_('Config')->add_assets_table_fix == 1)
				{
					$db .= PHP_EOL;
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. '--' . Line::_(
							__LINE__,__CLASS__
						)
						. ' Always insure this column rules is large enough for all the access control values.';
					$db .= PHP_EOL . '--';
					$db .= PHP_EOL
						. "ALTER TABLE `#__assets` CHANGE `rules` `rules` TEXT NOT NULL COMMENT 'JSON encoded access control. Enlarged to TEXT by JCB';";
				}
			}

			// check if this component needs larger names
			// also check if the developer will allow this
			// the config length must be checked before this
			// only add this option if set to SQL fix
			if (CFactory::_('Config')->add_assets_table_fix && CFactory::_('Config')->add_assets_table_name_fix)
			{
				$db .= PHP_EOL;
				$db .= PHP_EOL . '--';
				$db .= PHP_EOL
					. '--' . Line::_(
						__LINE__,__CLASS__
					)
					. ' Always insure this column name is large enough for long component and view names.';
				$db .= PHP_EOL . '--';
				$db .= PHP_EOL
					. "ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';";
			}

			return $db;
		}

		return '';
	}

	public function setUninstall()
	{
		$db = '';
		if (CFactory::_('Compiler.Builder.Database.Uninstall')->isArray('table'))
		{
			$db .= implode(PHP_EOL, CFactory::_('Compiler.Builder.Database.Uninstall')->get('table')) . PHP_EOL;
		}
		// add custom sql uninstall dump to the file
		if (isset(CFactory::_('Customcode.Dispenser')->hub['sql_uninstall'])
			&& StringHelper::check(
				CFactory::_('Customcode.Dispenser')->hub['sql_uninstall']
			))
		{
			$db .= CFactory::_('Placeholder')->update_(
					CFactory::_('Customcode.Dispenser')->hub['sql_uninstall']
				) . PHP_EOL;
			unset(CFactory::_('Customcode.Dispenser')->hub['sql_uninstall']);
		}

		// check if this component used larger rules
		// now revert them back on uninstall
		// only add this option if set to SQL fix
		if (CFactory::_('Config')->add_assets_table_fix == 1)
		{
			// https://github.com/joomla/joomla-cms/blob/3.10.0-alpha3/installation/sql/mysql/joomla.sql#L22
			// Checked 1st December 2020 (let us know if this changes)
			$db .= PHP_EOL;
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. '--' . Line::_(
					__LINE__,__CLASS__
				)
				. ' Always insure this column rules is reversed to Joomla defaults on uninstall. (as on 1st Dec 2020)';
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. "ALTER TABLE `#__assets` CHANGE `rules` `rules` varchar(5120) NOT NULL COMMENT 'JSON encoded access control.';";
		}

		// check if this component used larger names
		// now revert them back on uninstall
		// only add this option if set to SQL fix
		if (CFactory::_('Config')->add_assets_table_fix == 1 && CFactory::_('Config')->add_assets_table_name_fix)
		{
			// https://github.com/joomla/joomla-cms/blob/3.10.0-alpha3/installation/sql/mysql/joomla.sql#L20
			// Checked 1st December 2020 (let us know if this changes)
			$db .= PHP_EOL;
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. '--' . Line::_(
					__LINE__,__CLASS__
				)
				. ' Always insure this column name is reversed to Joomla defaults on uninstall. (as on 1st Dec 2020).';
			$db .= PHP_EOL . '--';
			$db .= PHP_EOL
				. "ALTER TABLE `#__assets` CHANGE `name` `name` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.';";
		}

		return $db;
	}

	public function setLangAdmin(string $componentName): bool
	{
		// Trigger Event: jcb_ce_onBeforeBuildAdminLang
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeBuildAdminLang'
		);

		// start loading the defaults
		CFactory::_('Language')->set('adminsys', CFactory::_('Config')->lang_prefix, $componentName);
		CFactory::_('Language')->set(
			'adminsys', CFactory::_('Config')->lang_prefix . '_CONFIGURATION',
			$componentName . ' Configuration'
		);
		CFactory::_('Language')->set('admin', CFactory::_('Config')->lang_prefix, $componentName);
		CFactory::_('Language')->set('admin', CFactory::_('Config')->lang_prefix . '_BACK', 'Back');
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_DASH', 'Dashboard'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_VERSION', 'Version'
		);
		CFactory::_('Language')->set('admin', CFactory::_('Config')->lang_prefix . '_DATE', 'Date');
		CFactory::_('Language')->set('admin', CFactory::_('Config')->lang_prefix . '_AUTHOR', 'Author');
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_WEBSITE', 'Website'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_LICENSE', 'License'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_CONTRIBUTORS', 'Contributors'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_CONTRIBUTOR', 'Contributor'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_DASHBOARD',
			$componentName . ' Dashboard'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_SAVE_SUCCESS',
			"Great! Item successfully saved."
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_SAVE_WARNING',
			"The value already existed so please select another."
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_HELP_MANAGER', "Help"
		);
		CFactory::_('Language')->set('admin', CFactory::_('Config')->lang_prefix . '_NEW', "New");
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_CLOSE_NEW', "Close & New"
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_CREATE_NEW_S', "Create New %s"
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_EDIT_S', "Edit %s"
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_KEEP_ORIGINAL_STATE',
			"- Keep Original State -"
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_KEEP_ORIGINAL_ACCESS',
			"- Keep Original Access -"
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_KEEP_ORIGINAL_CATEGORY',
			"- Keep Original Category -"
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_PUBLISHED', 'Published'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_INACTIVE', 'Inactive'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_ARCHIVED', 'Archived'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_TRASHED', 'Trashed'
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_NO_ACCESS_GRANTED',
			"No Access Granted!"
		);
		CFactory::_('Language')->set(
			'admin', CFactory::_('Config')->lang_prefix . '_NOT_FOUND_OR_ACCESS_DENIED',
			"Not found or access denied!"
		);

		if (CFactory::_('Component')->get('add_license')
			&& CFactory::_('Component')->get('license_type') == 3)
		{
			CFactory::_('Language')->set(
				'admin', 'NIE_REG_NIE',
				"<br /><br /><center><h1>License not set for " . $componentName
				. ".</h1><p>Notify your administrator!<br />The license can be obtained from <a href='"
				. CFactory::_('Component')->get('whmcs_buy_link') . "' target='_blank'>"
				. CFactory::_('Component')->get('companyname') . "</a>.</p></center>"
			);
		}

		// add the langug files needed to import and export data
		if (CFactory::_('Config')->get('add_eximport', false))
		{
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_EXPORT_FAILED', "Export Failed"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_FAILED', "Import Failed"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_TITLE', "Data Importer"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_NO_IMPORT_TYPE_FOUND',
				"Import type not found."
			);
			CFactory::_('Language')->set(
				'admin',
				CFactory::_('Config')->lang_prefix . '_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE',
				"Package to import not found."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_ERROR', "Import error."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_SUCCESS',
				"Great! Import successful."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_WARNIMPORTFILE',
				"Warning, import file error."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_NO_FILE_SELECTED',
				"No import file selected."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_PLEASE_SELECT_A_FILE',
				"Please select a file to import."
			);
			CFactory::_('Language')->set(
				'admin',
				CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_PLEASE_SELECT_ALL_COLUMNS',
				"Please link all columns."
			);
			CFactory::_('Language')->set(
				'admin',
				CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY',
				"Please enter the file directory."
			);
			CFactory::_('Language')->set(
				'admin',
				CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_WARNIMPORTUPLOADERROR',
				"Warning, import upload error."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix
				. '_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY',
				"Please enter the file directory."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix
				. '_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE',
				"Path does not have a valid file."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix
				. '_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE',
				"Does not have a valid file type."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_ENTER_A_URL',
				"Please enter a url."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_MSG_INVALID_URL',
				"Invalid url."
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_CONTINUE', "Continue"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_FROM_UPLOAD', "Upload"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_SELECT_FILE',
				"Select File"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_UPLOAD_BOTTON',
				"Upload File"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_FROM_DIRECTORY',
				"Directory"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_SELECT_FILE_DIRECTORY',
				"Set the path to file"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_GET_BOTTON', "Get File"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_FROM_URL', "URL"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_SELECT_FILE_URL',
				"Enter file URL"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_UPDATE_DATA',
				"Import Data"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_FORMATS_ACCEPTED',
				"formats accepted"
			);
			CFactory::_('Language')->set(
				'admin',
				CFactory::_('Config')->lang_prefix . '_IMPORT_LINK_FILE_TO_TABLE_COLUMNS',
				"Link File to Table Columns"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_TABLE_COLUMNS',
				"Table Columns"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_FILE_COLUMNS',
				"File Columns"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_PLEASE_SELECT_COLUMN',
				"-- Please Select Column --"
			);
			CFactory::_('Language')->set(
				'admin', CFactory::_('Config')->lang_prefix . '_IMPORT_IGNORE_COLUMN',
				"-- Ignore This Column --"
			);
		}

		// check if the both array is set
		if (CFactory::_('Language')->exist('both'))
		{
			foreach (CFactory::_('Language')->getTarget('both') as $keylang => $langval)
			{
				CFactory::_('Language')->set('admin', $keylang, $langval);
			}
		}

		// check if the both admin array is set
		if (CFactory::_('Language')->exist('bothadmin'))
		{
			foreach (CFactory::_('Language')->getTarget('bothadmin') as $keylang => $langval)
			{
				CFactory::_('Language')->set('admin', $keylang, $langval);
			}
		}

		if (CFactory::_('Language')->exist('admin'))
		{
			// Trigger Event: jcb_ce_onAfterBuildAdminLang
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterBuildAdminLang'
			);
			// get language content
			$langContent = CFactory::_('Language')->getTarget('admin');
			// sort the strings
			ksort($langContent);
			// load to global languages
			$langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
			CFactory::_('Compiler.Builder.Languages')->set(
				"components.{$langTag}.admin",
				$langContent
			);
			// remove tmp array
			CFactory::_('Language')->setTarget('admin', null);

			return true;
		}

		return false;
	}

	public function setLangSite(string $componentName): bool
	{
		// Trigger Event: jcb_ce_onBeforeBuildSiteLang
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeBuildSiteLang'
		);

		// add final list of needed lang strings
		CFactory::_('Language')->set('site', CFactory::_('Config')->lang_prefix, $componentName);
		// some more defaults
		CFactory::_('Language')->set('site', 'JTOOLBAR_APPLY', "Save");
		CFactory::_('Language')->set('site', 'JTOOLBAR_SAVE_AS_COPY', "Save as Copy");
		CFactory::_('Language')->set('site', 'JTOOLBAR_SAVE', "Save & Close");
		CFactory::_('Language')->set('site', 'JTOOLBAR_SAVE_AND_NEW', "Save & New");
		CFactory::_('Language')->set('site', 'JTOOLBAR_CANCEL', "Cancel");
		CFactory::_('Language')->set('site', 'JTOOLBAR_CLOSE', "Close");
		CFactory::_('Language')->set('site', 'JTOOLBAR_HELP', "Help");
		CFactory::_('Language')->set('site', 'JGLOBAL_FIELD_ID_LABEL', "ID");
		CFactory::_('Language')->set(
			'site', 'JGLOBAL_FIELD_ID_DESC', "Record number in the database."
		);
		CFactory::_('Language')->set(
			'site', 'JGLOBAL_FIELD_MODIFIED_LABEL', "Modified Date"
		);
		CFactory::_('Language')->set(
			'site', 'COM_CONTENT_FIELD_MODIFIED_DESC',
			"The last date this item was modified."
		);
		CFactory::_('Language')->set(
			'site', 'JGLOBAL_FIELD_MODIFIED_BY_LABEL', "Modified By"
		);
		CFactory::_('Language')->set(
			'site', 'JGLOBAL_FIELD_MODIFIED_BY_DESC',
			"The user who did the last modification."
		);
		CFactory::_('Language')->set('site', CFactory::_('Config')->lang_prefix . '_NEW', "New");
		CFactory::_('Language')->set(
			'site', CFactory::_('Config')->lang_prefix . '_CREATE_NEW_S', "Create New %s"
		);
		CFactory::_('Language')->set('site', CFactory::_('Config')->lang_prefix . '_EDIT_S', "Edit %s");
		CFactory::_('Language')->set(
			'site', CFactory::_('Config')->lang_prefix . '_NO_ACCESS_GRANTED',
			"No Access Granted!"
		);
		CFactory::_('Language')->set(
			'site', CFactory::_('Config')->lang_prefix . '_NOT_FOUND_OR_ACCESS_DENIED',
			"Not found or access denied!"
		);

		// check if the both array is set
		if (CFactory::_('Language')->exist('both'))
		{
			foreach (CFactory::_('Language')->getTarget('both') as $keylang => $langval)
			{
				CFactory::_('Language')->set('site', $keylang, $langval);
			}
		}

		// check if the both site array is set
		if (CFactory::_('Language')->exist('bothsite'))
		{
			foreach (CFactory::_('Language')->getTarget('bothsite') as $keylang => $langval)
			{
				CFactory::_('Language')->set('site', $keylang, $langval);
			}
		}

		if (CFactory::_('Language')->exist('site'))
		{
			// Trigger Event: jcb_ce_onAfterBuildSiteLang
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterBuildSiteLang'
			);

			// Get the site language content
			$langContent = CFactory::_('Language')->getTarget('site');
			// sort the strings
			ksort($langContent);
			// load to global languages
			$langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
			CFactory::_('Compiler.Builder.Languages')->set(
				"components.{$langTag}.site",
				$langContent
			);
			// remove tmp array
			CFactory::_('Language')->setTarget('site', null);

			return true;
		}

		return false;
	}

	public function setLangSiteSys(string $componentName): bool
	{
		// Trigger Event: jcb_ce_onBeforeBuildSiteSysLang
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeBuildSiteSysLang'
		);

		// add final list of needed lang strings
		CFactory::_('Language')->set('sitesys', CFactory::_('Config')->lang_prefix, $componentName);
		CFactory::_('Language')->set(
			'sitesys', CFactory::_('Config')->lang_prefix . '_NO_ACCESS_GRANTED',
			"No Access Granted!"
		);
		CFactory::_('Language')->set(
			'sitesys', CFactory::_('Config')->lang_prefix . '_NOT_FOUND_OR_ACCESS_DENIED',
			"Not found or access denied!"
		);

		// check if the both site array is set
		if (CFactory::_('Language')->exist('bothsite'))
		{
			foreach (CFactory::_('Language')->getTarget('bothsite') as $keylang => $langval)
			{
				CFactory::_('Language')->set('sitesys', $keylang, $langval);
			}
		}
		if (CFactory::_('Language')->exist('sitesys'))
		{
			// Trigger Event: jcb_ce_onAfterBuildSiteSysLang
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterBuildSiteSysLang'
			);
			// get site system language content
			$langContent = CFactory::_('Language')->getTarget('sitesys');
			// sort strings
			ksort($langContent);
			// load to global languages
			$langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
			CFactory::_('Compiler.Builder.Languages')->set(
				"components.{$langTag}.sitesys",
				$langContent
			);
			// remove tmp array
			CFactory::_('Language')->setTarget('sitesys', null);

			return true;
		}

		return false;
	}

	public function setLangAdminSys(): bool
	{
		// Trigger Event: jcb_ce_onBeforeBuildAdminSysLang
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeBuildAdminSysLang'
		);

		// check if the both admin array is set
		if (CFactory::_('Language')->exist('bothadmin'))
		{
			foreach (CFactory::_('Language')->getTarget('bothadmin') as $keylang => $langval)
			{
				CFactory::_('Language')->set('adminsys', $keylang, $langval);
			}
		}
		if (CFactory::_('Language')->exist('adminsys'))
		{
			// Trigger Event: jcb_ce_onAfterBuildAdminSysLang
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterBuildAdminSysLang'
			);
			// get admin system langauge content
			$langContent = CFactory::_('Language')->getTarget('adminsys');
			// sort strings
			ksort($langContent);
			// load to global languages
			$langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
			CFactory::_('Compiler.Builder.Languages')->set(
				"components.{$langTag}.adminsys",
				$langContent
			);
			// remove tmp array
			CFactory::_('Language')->setTarget('adminsys', null);

			return true;
		}

		return false;
	}

	public function setCustomAdminViewListLink($view, $nameListCode)
	{
		if (CFactory::_('Component')->isArray('custom_admin_views'))
		{
			foreach (CFactory::_('Component')->get('custom_admin_views') as $custom_admin_view)
			{
				if (isset($custom_admin_view['adminviews'])
					&& ArrayHelper::check(
						$custom_admin_view['adminviews']
					))
				{
					foreach ($custom_admin_view['adminviews'] as $adminview)
					{
						if (isset($view['adminview'])
							&& $view['adminview'] == $adminview)
						{
							// set the needed keys
							$setId = false;
							if (ArrayHelper::check(
								$custom_admin_view['settings']->main_get->filter
							))
							{
								foreach (
									$custom_admin_view['settings']->main_get->filter
									as $filter
								)
								{
									if ($filter['filter_type'] == 1
										|| '$id' == $filter['state_key'])
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
								$this->customAdminViewListLink[$nameListCode][]
									= $set;
								// add to set id for list view if needed
								$this->customAdminViewListId[$custom_admin_view['settings']->code]
									= true;
							}
							else
							{
								// now load it to the global object for tool bar
								$this->customAdminDynamicButtons[$nameListCode][]
									= $set;
							}
							// log that it has been added already
							$this->customAdminAdded[$custom_admin_view['settings']->code]
								= $adminview;
						}
					}
				}
			}
		}
	}

	/**
	 * set the list body
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 *
	 * @return string
	 */
	public function setListBody($nameSingleCode, $nameListCode)
	{
		if (($items = CFactory::_('Compiler.Builder.Lists')->get($nameListCode)) !== null)
		{
			// component helper name
			$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			// add the default
			$body = "<?php foreach (\$this->items as \$i => \$item): ?>";
			$body .= PHP_EOL . Indent::_(1) . "<?php";
			$body .= PHP_EOL . Indent::_(2)
				. "\$canCheckin = \$this->user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$this->user->id || \$item->checked_out == 0;";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$body .= PHP_EOL . Indent::_(2)
					. "\$userChkOut = Factory::getUser(\$item->checked_out);";
			}
			else
			{
				$body .= PHP_EOL . Indent::_(2)
					. "\$userChkOut = Factory::getContainer()->";
				$body .= PHP_EOL . Indent::_(3)
					. "get(\Joomla\CMS\User\UserFactoryInterface::class)->";
				$body .= PHP_EOL . Indent::_(4)
					. "loadUserById(\$item->checked_out);";
			}
			$body .= PHP_EOL . Indent::_(2) . "\$canDo = " . $Helper
				. "::getActions('" . $nameSingleCode . "',\$item,'"
				. $nameListCode . "');";
			$body .= PHP_EOL . Indent::_(1) . "?>";
			$body .= PHP_EOL . Indent::_(1)
				. '<tr class="row<?php echo $i % 2; ?>">';
			// only load if not overwritten
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.ordering'))
			{
				$body .= PHP_EOL . Indent::_(2)
					. '<td class="order nowrap center hidden-phone">';
				// check if the item has permissions.
				$body .= PHP_EOL . Indent::_(2) . "<?php if (\$canDo->get('"
						. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit.state') . "')): ?>";
				$body .= PHP_EOL . Indent::_(3) . "<?php";
				$body .= PHP_EOL . Indent::_(4) . "\$iconClass = '';";
				$body .= PHP_EOL . Indent::_(4) . "if (!\$this->saveOrder)";
				$body .= PHP_EOL . Indent::_(4) . "{";
				$body .= PHP_EOL . Indent::_(5)
					. "\$iconClass = ' inactive tip-top"
					. '" hasTooltip" title="'
					. "' . Html::tooltipText('JORDERINGDISABLED');";
				$body .= PHP_EOL . Indent::_(4) . "}";
				$body .= PHP_EOL . Indent::_(3) . "?>";
				$body .= PHP_EOL . Indent::_(3)
					. '<span class="sortable-handler<?php echo $iconClass; ?>">';
				$body .= PHP_EOL . Indent::_(4) . '<i class="icon-menu"></i>';
				$body .= PHP_EOL . Indent::_(3) . "</span>";
				$body .= PHP_EOL . Indent::_(3)
					. "<?php if (\$this->saveOrder) : ?>";
				$body .= PHP_EOL . Indent::_(4)
					. '<input type="text" style="display:none" name="order[]" size="5"';
				$body .= PHP_EOL . Indent::_(4)
					. 'value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />';
				$body .= PHP_EOL . Indent::_(3) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(3) . "&#8942;";
				$body .= PHP_EOL . Indent::_(2) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "</td>";
			}
			$body .= PHP_EOL . Indent::_(2) . '<td class="nowrap center">';
			// check if the item has permissions.
			$body .= PHP_EOL . Indent::_(2) . "<?php if (\$canDo->get('"
					. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit') . "')): ?>";
			$body .= PHP_EOL . Indent::_(4)
				. "<?php if (\$item->checked_out) : ?>";
			$body .= PHP_EOL . Indent::_(5) . "<?php if (\$canCheckin) : ?>";
			$body .= PHP_EOL . Indent::_(6)
				. "<?php echo Html::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL . Indent::_(5) . "<?php else: ?>";
			$body .= PHP_EOL . Indent::_(6) . "&#9633;";
			$body .= PHP_EOL . Indent::_(5) . "<?php endif; ?>";
			$body .= PHP_EOL . Indent::_(4) . "<?php else: ?>";
			$body .= PHP_EOL . Indent::_(5)
				. "<?php echo Html::_('grid.id', \$i, \$item->id); ?>";
			$body .= PHP_EOL . Indent::_(4) . "<?php endif; ?>";
			$body .= PHP_EOL . Indent::_(2) . "<?php else: ?>";
			$body .= PHP_EOL . Indent::_(3) . "&#9633;";
			$body .= PHP_EOL . Indent::_(2) . "<?php endif; ?>";
			$body .= PHP_EOL . Indent::_(2) . "</td>";
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (CFactory::_('Compiler.Builder.Do.Not.Escape')->exists($nameListCode))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($items as $item)
			{
				// check if target is admin list
				if (1 == $item['target'] || 3 == $item['target'])
				{
					// set some defaults
					$customAdminViewButtons = '';
					// set the item default class
					$itemClass = 'hidden-phone';
					// set the item row
					$itemRow = $this->getListItemBuilder(
						$item, $nameSingleCode, $nameListCode, $itemClass, $doNotEscape
					);
					// check if buttons was already added
					if ($firstTimeBeingAdded) // TODO we must improve this to allow more items to be targeted instead of just the first item :)
					{
						// get custom admin view buttons
						$customAdminViewButtons
							= $this->getCustomAdminViewButtons($nameListCode);
						// make sure the custom admin view buttons are only added once
						$firstTimeBeingAdded = false;
					}
					// add row to body
					$body .= PHP_EOL . Indent::_(2) . "<td class=\""
						. $this->getListFieldClass(
							$item['code'], $nameListCode, $itemClass
						) . "\">";
					$body .= $itemRow;
					$body .= $customAdminViewButtons;
					$body .= PHP_EOL . Indent::_(2) . "</td>";
				}
			}
			// add the defaults
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
			{
				$body .= PHP_EOL . Indent::_(2) . '<td class="center">';
				// check if the item has permissions.
				$body .= PHP_EOL . Indent::_(2) . "<?php if (\$canDo->get('"
					. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit.state') . "')) : ?>";
				$body .= PHP_EOL . Indent::_(4)
					. "<?php if (\$item->checked_out) : ?>";
				$body .= PHP_EOL . Indent::_(5)
					. "<?php if (\$canCheckin) : ?>";
				$body .= PHP_EOL . Indent::_(6)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', true, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(5) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(6)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', false, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(5) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(4) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(5)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', true, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(4) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "<?php else: ?>";
				$body .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('jgrid.published', \$item->published, \$i, '"
					. $nameListCode . ".', false, 'cb'); ?>";
				$body .= PHP_EOL . Indent::_(2) . "<?php endif; ?>";
				$body .= PHP_EOL . Indent::_(2) . "</td>";
			}
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.id'))
			{
				$body .= PHP_EOL . Indent::_(2) . '<td class="'
					. $this->getListFieldClass(
						$item['code'], $nameListCode,
						'nowrap center hidden-phone'
					) . '">';
				$body .= PHP_EOL . Indent::_(3) . "<?php echo \$item->id; ?>";
				$body .= PHP_EOL . Indent::_(2) . "</td>";
			}
			$body .= PHP_EOL . Indent::_(1) . "</tr>";
			$body .= PHP_EOL . "<?php endforeach; ?>";

			// return the build
			return $body;
		}

		return '';
	}

	/**
	 * Get the list item dynamic row
	 *
	 * @param   array   $item            The item array
	 * @param   string  $nameSingleCode  The single view code name
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $itemClass       The table row default class
	 * @param   bool    $doNotEscape     The do not escape global switch
	 * @param   bool    $class           The dive class adding switch
	 * @param   string  $ref             The link referral string
	 * @param   string  $escape          The escape code name
	 * @param   string  $user            The user code name
	 * @param   string  $refview         The override of the referral view code name
	 *
	 * @return  string of the completer item value for the table row
	 *
	 */
	protected function getListItemBuilder($item, $nameSingleCode,
	                                      $nameListCode, &$itemClass, $doNotEscape,
	                                      $class = true, $ref = null, $escape = '$this->escape',
	                                      $user = '$this->user', $refview = null
	)
	{
		// check if we have relation fields
		if (($field_relations =
			CFactory::_('Compiler.Builder.Field.Relations')->get($nameListCode . '.' . (int) $item['id'] . '.2')) !== null)
		{
			// set the fields array
			$field = [];
			// use custom code
			$useCustomCode
				= (isset($field_relations['join_type'])
				&& $field_relations['join_type']
				== 2
				&& isset($field_relations['set'])
				&& StringHelper::check(
					$field_relations['set']
				));
			// load the main list view field
			$field['[field=' . (int) $item['id'] . ']'] = $this->getListItem(
				$item, $nameSingleCode, $nameListCode, $itemClass,
				$doNotEscape,false, $ref, $escape, $user,
				$refview
			);
			// code name
			if (isset($item['code']) && $useCustomCode)
			{
				$field['$item->{' . (int) $item['id'] . '}'] = '$item->'
					. $item['code'];
			}
			// now load the relations
			if (isset($field_relations['joinfields'])
				&& ArrayHelper::check($field_relations['joinfields']))
			{
				foreach ($field_relations['joinfields'] as $join)
				{
					$blankClass = '';
					if (($join_item =
						CFactory::_('Compiler.Builder.List.Join')->get($nameListCode . '.' . (int) $join)) !== null)
					{
						// code block
						$field['[field=' . (int) $join . ']']
							= $this->getListItem(
							$join_item, $nameSingleCode, $nameListCode, $blankClass,
							$doNotEscape, false, $ref,
							$escape, $user, $refview
						);
						// code name
						if (isset($join_item['code'])
							&& $useCustomCode)
						{
							$field['$item->{' . (int) $join . '}'] = '$item->'
								. $join_item['code'];
						}
					}
				}
			}
			// join based on join type
			if ($useCustomCode)
			{
				// custom code
				return PHP_EOL . Indent::_(3) . "<div>"
					. CFactory::_('Placeholder')->update_(
						str_replace(
							array_keys($field), array_values($field),
							(string) $field_relations['set']
						)
					) . PHP_EOL . Indent::_(3) . "</div>";
			}
			elseif (isset($field_relations['set'])
				&& StringHelper::check(
					$field_relations['set']
				))
			{
				// concatenate
				return PHP_EOL . Indent::_(3) . "<div>" . implode(
						$field_relations['set'],
						$field
					) . PHP_EOL . Indent::_(3) . "</div>";
			}

			// default
			return PHP_EOL . Indent::_(3) . "<div>" . implode('', $field)
				. PHP_EOL . Indent::_(3) . "</div>";
		}

		return $this->getListItem(
			$item, $nameSingleCode, $nameListCode, $itemClass, $doNotEscape,
			$class, $ref, $escape, $user, $refview
		);
	}

	/**
	 * Get the list item row value
	 *
	 * @param   array   $item            The item array
	 * @param   string  $nameSingleCode  The single view code name
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $itemClass       The table row default class
	 * @param   bool    $doNotEscape     The do not escape global switch
	 * @param   bool    $class           The dive class adding switch
	 * @param   string  $ref             The link referral string
	 * @param   string  $escape          The escape code name
	 * @param   string  $user            The user code name
	 * @param   string  $refview         The override of the referral view code name
	 *
	 * @return  string of the single item value for the table row
	 *
	 */
	protected function getListItem($item, $nameSingleCode, $nameListCode,
	                               &$itemClass, $doNotEscape, $class = true, $ref = null,
	                               $escape = '$this->escape', $user = '$this->user', $refview = null
	)
	{
		// get list item code
		$itemCode = $this->getListItemCode(
			$item, $nameListCode, $doNotEscape, $escape
		);
		// add default links
		$defaultLink = true;
		if (StringHelper::check($refview)
			&& isset($item['custom'])
			&& isset($item['custom']['view'])
			&& $refview === $item['custom']['view'])
		{
			$defaultLink = false;
		}
		// is this a linked item
		$extends_field = $item['custom']['extends'] ?? '';
		if (($item['link'] || $extends_field === 'user') && $defaultLink)
		{
			// set some defaults
			$checkoutTriger = false;
			// set the item default class
			$itemClass = 'nowrap';
			// get list item link
			$itemLink = $this->getListItemLink(
				$item, $checkoutTriger, $nameSingleCode, $nameListCode, $ref
			);
			// get list item link authority
			$itemLinkAuthority = $this->getListItemLinkAuthority(
				$item, $nameSingleCode, $nameListCode, $user
			);

			// set item row
			return $this->getListItemLinkLogic(
				$itemCode, $itemLink, $itemLinkAuthority, $nameListCode,
				$checkoutTriger, $class
			);
		}

		// return the default (no link)
		return PHP_EOL . Indent::_(3) . "<?php echo " . $itemCode . "; ?>";
	}

	/**
	 * Get the list item link logic
	 *
	 * @param   string  $itemCode           The item code string
	 * @param   string  $itemLink           The item link string
	 * @param   string  $itemLinkAuthority  The link authority string
	 * @param   string  $nameListCode       The list view code name
	 * @param   bool    $checkoutTriger     The check out trigger
	 * @param   bool    $class              The dive class adding switch
	 *
	 * @return  string of the complete link logic of row item
	 *
	 */
	protected function getListItemLinkLogic($itemCode, $itemLink,
	                                        $itemLinkAuthority, $nameListCode, $checkoutTriger, $class = true
	)
	{
		// build link
		$link = '';
		// add class
		$tab = '';
		if ($class)
		{
			$link .= PHP_EOL . Indent::_(3) . '<div class="name">';
			$tab  = Indent::_(1);
		}
		// the link logic
		$link .= PHP_EOL . $tab . Indent::_(3) . "<?php if ("
			. $itemLinkAuthority . "): ?>";
		$link .= PHP_EOL . $tab . Indent::_(4) . '<a href="' . $itemLink
			. '"><?php echo ' . $itemCode . '; ?></a>';
		if ($checkoutTriger)
		{
			$link .= PHP_EOL . $tab . Indent::_(4)
				. "<?php if (\$item->checked_out): ?>";
			$link .= PHP_EOL . $tab . Indent::_(5)
				. "<?php echo Html::_('jgrid.checkedout', \$i, \$userChkOut->name, \$item->checked_out_time, '"
				. $nameListCode . ".', \$canCheckin); ?>";
			$link .= PHP_EOL . $tab . Indent::_(4) . "<?php endif; ?>";
		}
		$link .= PHP_EOL . $tab . Indent::_(3) . "<?php else: ?>";
		$link .= PHP_EOL . $tab . Indent::_(4) . "<?php echo " . $itemCode
			. "; ?>";
		$link .= PHP_EOL . $tab . Indent::_(3) . "<?php endif; ?>";
		// add class
		if ($class)
		{
			$link .= PHP_EOL . Indent::_(3) . "</div>";
		}

		// return the link logic
		return $link;
	}

	/**
	 * Get the custom admin view buttons
	 *
	 * @param   string  $nameListCode  The list view code name
	 * @param   string  $ref           The link referral string
	 *
	 * @return  string of the custom admin view buttons
	 *
	 */
	protected function getCustomAdminViewButtons($nameListCode, $ref = '')
	{
		$customAdminViewButton = '';
		// check if custom links should be added to this list views
		if (isset($this->customAdminViewListLink[$nameListCode])
			&& ArrayHelper::check(
				$this->customAdminViewListLink[$nameListCode]
			))
		{
			// start building the links
			$customAdminViewButton .= PHP_EOL . Indent::_(3)
				. '<div class="btn-group">';
			foreach (
				$this->customAdminViewListLink[$nameListCode] as
				$customLinkView
			)
			{
				$customAdminViewButton .= PHP_EOL . Indent::_(3)
					. "<?php if (\$canDo->get('" . $customLinkView['link']
					. ".access')): ?>";
				$customAdminViewButton .= PHP_EOL . Indent::_(4)
					. '<a class="hasTooltip btn btn-mini" href="index.php?option=com_'
					. CFactory::_('Config')->component_code_name . '&view='
					. $customLinkView['link'] . '&id=<?php echo $item->id; ?>'
					. $ref . '" title="<?php echo Text:' . ':_(' . "'COM_"
					. CFactory::_('Compiler.Builder.Content.One')->get('COMPONENT') . '_' . $customLinkView['NAME'] . "'"
					. '); ?>" ><span class="icon-' . $customLinkView['icon']
					. '"></span></a>';
				$customAdminViewButton .= PHP_EOL . Indent::_(3)
					. "<?php else: ?>";
				$customAdminViewButton .= PHP_EOL . Indent::_(4)
					. '<a class="hasTooltip btn btn-mini disabled" href="#" title="<?php echo Text:'
					. ':_(' . "'COM_" . CFactory::_('Compiler.Builder.Content.One')->get('COMPONENT') . '_' . $customLinkView['NAME']
					. "'" . '); ?>"><span class="icon-'
					. $customLinkView['icon'] . '"></span></a>';
				$customAdminViewButton .= PHP_EOL . Indent::_(3)
					. "<?php endif; ?>";
			}
			$customAdminViewButton .= PHP_EOL . Indent::_(3) . '</div>';
		}

		return $customAdminViewButton;
	}

	/**
	 * Get the list item code value
	 *
	 * @param   array   $item          The item array
	 * @param   string  $nameListCode  The list view code name
	 * @param   bool    $doNotEscape   The do not escape global switch
	 * @param   string  $escape        The escape code name
	 *
	 * @return  string of the single item code
	 *
	 */
	protected function getListItemCode(&$item, $nameListCode, $doNotEscape,
	                                   $escape = '$this->escape'
	)
	{
		// first update the code id needed
		if (isset($item['custom'])
			&& ArrayHelper::check(
				$item['custom']
			)
			&& isset($item['custom']['table'])
			&& StringHelper::check($item['custom']['table']))
		{
			$item['id_code'] = $item['code'];
			if (!$item['multiple'])
			{
				$item['code'] = $item['code'] . '_' . $item['custom']['text'];
			}
		}
		//  set the extends value
		$extends_field = $item['custom']['extends'] ?? '';
		$extends_text = $item['custom']['text'] ?? '';
		// check if category
		if ($item['type'] === 'category' && !$item['title'])
		{
			return $escape . '($item->category_title)';
		}
		// check if user
		elseif ($item['type'] === 'user')
		{
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				return 'Factory::getUser((int)$item->' . $item['code'] . ')->name';
			}
			else
			{
				return 'Factory::getContainer()->'
					. 'get(\Joomla\CMS\User\UserFactoryInterface::class)->'
					. 'loadUserById((int) $item->' . $item['code'] . ')->name';
			}
		}
		// check if custom user
		elseif (isset($item['custom'])
			&& ArrayHelper::check($item['custom'])
			&& $extends_field === 'user'
			&& isset($item['id_code']))
		{
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				return 'Factory::getUser((int)$item->' . $item['id_code'] . ')->name';
			}
			else
			{
				return 'Factory::getContainer()->'
					. 'get(\Joomla\CMS\User\UserFactoryInterface::class)->'
					. 'loadUserById((int) $item->' . $item['id_code'] . ')->name';
			}
		}
		// check if translated value is used
		elseif (CFactory::_('Compiler.Builder.Selection.Translation')->
			exists($nameListCode . '.' . $item['code']))
		{
			return 'Text:' . ':_($item->' . $item['code'] . ')';
		}
		elseif (isset($item['custom'])
			&& ArrayHelper::check($item['custom'])
			&& ($extends_text === 'user' || $extends_field === 'user'))
		{
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				return 'Factory::getUser((int)$item->' . $item['code'] . ')->name';
			}
			else
			{
				return 'Factory::getContainer()->'
					. 'get(\Joomla\CMS\User\UserFactoryInterface::class)->'
					. 'loadUserById((int) $item->' . $item['code'] . ')->name';
			}
		}
		elseif ($doNotEscape)
		{
			if (CFactory::_('Compiler.Builder.Do.Not.Escape')->exists($nameListCode . '.' . $item['code']))
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
	 * @param   array   $item            The item array
	 * @param   bool    $checkoutTriger  The checkout trigger switch
	 * @param   string  $nameSingleCode  The single view code name
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $ref             The link referral string
	 *
	 * @return  string of the single item link
	 *
	 */
	protected function getListItemLink($item, &$checkoutTriger,
	                                   $nameSingleCode, $nameListCode, $ref = null
	)
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
			// return the link to category
			return 'index.php?option=com_categories&task=category.edit&id=<?php echo (int)$item->'
				. $item['code'] . '; ?>&extension='
				. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension", 'error');
		}
		elseif ($item['type'] === 'user' && !$item['title'])
		{
			// return user link
			return 'index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'
				. $item['code'] . ' ?>';
		}
		elseif (isset($item['custom'])
			&& ArrayHelper::check(
				$item['custom']
			)
			&& $item['custom']['extends'] != 'user'
			&& !$item['title']
			&& isset($item['id_code']))
		{
			// build GUID link
			if (isset($item['custom']['id']) && $item['custom']['id'] !== 'id')
			{
				// link to that linked item
				return 'index.php?option=' . $item['custom']['component'] . '&view='
					. $item['custom']['views'] . '&task=' . $item['custom']['view']
					. '.edit&id=<?php echo $item->' . $item['id_code'] . '_id; ?>'
					. $ref;
			}
			// link to that linked item
			return 'index.php?option=' . $item['custom']['component'] . '&view='
				. $item['custom']['views'] . '&task=' . $item['custom']['view']
				. '.edit&id=<?php echo $item->' . $item['id_code'] . '; ?>'
				. $ref;
		}
		elseif (isset($item['custom'])
			&& ArrayHelper::check(
				$item['custom']
			)
			&& $item['custom']['extends'] === 'user'
			&& !$item['title']
			&& isset($item['id_code']))
		{
			// return user link
			return 'index.php?option=com_users&task=user.edit&id=<?php echo (int) $item->'
				. $item['id_code'] . ' ?>';
		}
		// make sure to triger the checkout
		$checkoutTriger = true;

		// basic default item link
		return '<?php echo $edit; ?>&id=<?php echo $item->id; ?>' . $referal;
	}

	/**
	 * Get the list item authority
	 *
	 * @param   array   $item            The item array
	 * @param   string  $nameSingleCode  The single view code name
	 * @param   string  $nameListCode    The list view code name
	 * @param   string  $user            The user code name
	 *
	 * @return  string of the single item link authority
	 *
	 */
	protected function getListItemLinkAuthority($item, $nameSingleCode, $nameListCode, $user = '$this->user'
	)
	{
		// if to be linked
		if ($item['type'] === 'category' && !$item['title'])
		{
			// get the other view
			$otherView = CFactory::_('Compiler.Builder.Category.Code')->getString("{$nameSingleCode}.view", 'error');

			// return the authority to category
			return $user . "->authorise('core.edit', 'com_"
				. CFactory::_('Config')->component_code_name . "." . $otherView
				. ".category.' . (int)\$item->" . $item['code'] . ")";
		}
		elseif ($item['type'] === 'user' && !$item['title'])
		{
			// return user authority
			return $user . "->authorise('core.edit', 'com_users')";
		}
		elseif (isset($item['custom'])
			&& ArrayHelper::check(
				$item['custom']
			)
			&& $item['custom']['extends'] != 'user'
			&& !$item['title']
			&& isset($item['id_code']))
		{
			// do this with GUID
			if (isset($item['custom']['id']) && $item['custom']['id'] !== 'id')
			{
				return $user . "->authorise('" . CFactory::_('Compiler.Creator.Permission')->getAction($item['custom']['view'], 'core.edit')
					. "', 'com_" . CFactory::_('Config')->component_code_name . "."
					. $item['custom']['view'] . ".' . (int) \$item->" . $item['id_code'] . "_id)";
			}
			else
			{
				return $user . "->authorise('" . CFactory::_('Compiler.Creator.Permission')->getAction($item['custom']['view'], 'core.edit')
					. "', 'com_" . CFactory::_('Config')->component_code_name . "."
					. $item['custom']['view'] . ".' . (int) \$item->" . $item['id_code'] . ")";
			}
		}
		elseif (isset($item['custom'])
			&& ArrayHelper::check(
				$item['custom']
			)
			&& $item['custom']['extends'] === 'user'
			&& !$item['title']
			&& isset($item['id_code']))
		{
			// return user link
			return $user . "->authorise('core.edit', 'com_users')";
		}

		// set core permissions.
		return "\$canDo->get('" . CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit') . "')";
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
	 */
	protected function getListFieldClass($name, $nameListCode, $default = '')
	{
		return CFactory::_('Compiler.Builder.List.Field.Class')->get($nameListCode . '.' . $name, $default);
	}

	/**
	 * set the default views body
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 *
	 * @return string
	 */
	public function setDefaultViewsBody(string $nameSingleCode, string $nameListCode): string
	{
		// set component name
		$component = CFactory::_('Config')->component_code_name;
		$Component = ucfirst((string) $component);
		$COMPONENT = strtoupper((string) $component);
		// set uppercase view
		$VIEWS = strtoupper($nameListCode);
		// build the body
		$body = [];
		// check if the filter type is sidebar (1 = sidebar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1)
		{
			$body[] = "<script type=\"text/javascript\">";
			$body[] = Indent::_(1) . "Joomla.orderTable = function()";
			$body[] = Indent::_(1) . "{";
			$body[] = Indent::_(2)
				. "table = document.getElementById(\"sortTable\");";
			$body[] = Indent::_(2)
				. "direction = document.getElementById(\"directionTable\");";
			$body[] = Indent::_(2)
				. "order = table.options[table.selectedIndex].value;";
			$body[] = Indent::_(2)
				. "if (order != '<?php echo \$this->listOrder; ?>')";
			$body[] = Indent::_(2) . "{";
			$body[] = Indent::_(3) . "dirn = 'asc';";
			$body[] = Indent::_(2) . "}";
			$body[] = Indent::_(2) . "else";
			$body[] = Indent::_(2) . "{";
			$body[] = Indent::_(3)
				. "dirn = direction.options[direction.selectedIndex].value;";
			$body[] = Indent::_(2) . "}";
			$body[] = Indent::_(2) . "Joomla.tableOrdering(order, dirn, '');";
			$body[] = Indent::_(1) . "}";
			$body[] = "</script>";
		}
		// Trigger Event: jcb_ce_onSetDefaultViewsBodyTop
		CFactory::_('Event')->trigger(
			'jcb_ce_onSetDefaultViewsBodyTop', [&$body, &$nameSingleCode, &$nameListCode]
		);
		$body[] = "<form action=\"<?php echo Route::_('index.php?option=com_"
			. $component . "&view=" . $nameListCode
			. "'); ?>\" method=\"post\" name=\"adminForm\" id=\"adminForm\">";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$body[] = "<?php if(!empty( \$this->sidebar)): ?>";
			$body[] = Indent::_(1)
				. "<div id=\"j-sidebar-container\" class=\"span2\">";
			$body[] = Indent::_(2) . "<?php echo \$this->sidebar; ?>";
			$body[] = Indent::_(1) . "</div>";
			$body[] = Indent::_(1)
				. "<div id=\"j-main-container\" class=\"span10\">";
			$body[] = "<?php else : ?>";
			$body[] = Indent::_(1) . "<div id=\"j-main-container\">";
			$body[] = "<?php endif; ?>";
		}
		else
		{
			$body[] = Indent::_(1)
				. "<div id=\"j-main-container\">";
		}
		// Trigger Event: jcb_ce_onSetDefaultViewsFormTop
		CFactory::_('Event')->trigger(
			'jcb_ce_onSetDefaultViewsFormTop', [&$body, &$nameSingleCode, &$nameListCode]
		);
		// check if the filter type is sidebar (2 = topbar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
		{
			$body[] = "<?php";
			// build code to add the trash helper layout
			$addTrashHelper = Indent::_(1)
				. "echo LayoutHelper::render('trashhelper', \$this);";
			// add the trash helper layout if found in JCB
			if (CFactory::_('Templatelayout.Data')->set($addTrashHelper, $nameListCode))
			{
				$body[] = Indent::_(1) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Add the trash helper layout";
				$body[] = $addTrashHelper;
			}
			// add the new search toolbar ;)
			$body[] = Indent::_(1) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add the searchtools";
			$body[] = Indent::_(1)
				. "echo LayoutHelper::render('joomla.searchtools.default', array('view' => \$this));";
			$body[] = "?>";
		}
		$body[] = "<?php if (empty(\$this->items)): ?>";
		// check if the filter type is sidebar (1 = sidebar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1)
		{
			$body[] = Indent::_(1)
				. "<?php echo \$this->loadTemplate('toolbar');?>";
		}
		$body[] = Indent::_(1)
			. "<div class=\"alert alert-no-items\">";
		$body[] = Indent::_(2)
			. "<?php echo Text:" . ":_('JGLOBAL_NO_MATCHING_RESULTS'); ?>";
		$body[] = Indent::_(1) . "</div>";
		$body[] = "<?php else : ?>";
		// check if the filter type is sidebar (1 = sidebar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1)
		{
			$body[] = Indent::_(1)
				. "<?php echo \$this->loadTemplate('toolbar');?>";
		}
		$body[] = Indent::_(1) . "<table class=\"table table-striped\" id=\""
			. $nameSingleCode . "List\">";
		$body[] = Indent::_(2)
			. "<thead><?php echo \$this->loadTemplate('head');?></thead>";
		$body[] = Indent::_(2)
			. "<tfoot><?php echo \$this->loadTemplate('foot');?></tfoot>";
		$body[] = Indent::_(2)
			. "<tbody><?php echo \$this->loadTemplate('body');?></tbody>";
		$body[] = Indent::_(1) . "</table>";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$body[] = Indent::_(1) . "<?php //" . Line::_(
					__LINE__, __CLASS__
				) . " Load the batch processing form. ?>";
			$body[] = Indent::_(1)
				. "<?php if (\$this->canCreate && \$this->canEdit) : ?>";
			$body[] = Indent::_(2) . "<?php echo Html::_(";
			$body[] = Indent::_(3) . "'bootstrap.renderModal',";
			$body[] = Indent::_(3) . "'collapseModal',";
			$body[] = Indent::_(3) . "array(";
			$body[] = Indent::_(4) . "'title' => Text:" . ":_('COM_" . $COMPONENT . "_"
				. $VIEWS
				. "_BATCH_OPTIONS'),";
			$body[] = Indent::_(4)
				. "'footer' => \$this->loadTemplate('batch_footer')";
			$body[] = Indent::_(3) . "),";
			$body[] = Indent::_(3) . "\$this->loadTemplate('batch_body')";
			$body[] = Indent::_(2) . "); ?>";
			$body[] = Indent::_(1) . "<?php endif; ?>";
		}
		// check if the filter type is sidebar (1 = sidebar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1)
		{
			$body[] = Indent::_(1)
				. "<input type=\"hidden\" name=\"filter_order\" value=\"<?php echo \$this->listOrder; ?>\" />";
			$body[] = Indent::_(1)
				. "<input type=\"hidden\" name=\"filter_order_Dir\" value=\"<?php echo \$this->listDirn; ?>\" />";
		}
		$body[] = Indent::_(1)
			. "<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />";
		$body[] = Indent::_(1) . "</div>";
		$body[] = "<?php endif; ?>";
		$body[] = Indent::_(1)
			. "<input type=\"hidden\" name=\"task\" value=\"\" />";
		$body[] = Indent::_(1) . "<?php echo Html::_('form.token'); ?>";
		// Trigger Event: jcb_ce_onSetDefaultViewsFormBottom
		CFactory::_('Event')->trigger(
			'jcb_ce_onSetDefaultViewsFormBottom', [&$body, &$nameSingleCode, &$nameListCode]
		);
		$body[] = "</form>";
		// Trigger Event: jcb_ce_onSetDefaultViewsBodyBottom
		CFactory::_('Event')->trigger(
			'jcb_ce_onSetDefaultViewsBodyBottom', [&$body, &$nameSingleCode, &$nameListCode]
		);

		return implode(PHP_EOL, $body);
	}

	/**
	 * set the list body table head
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 *
	 * @return string
	 */
	public function setListHead($nameSingleCode, $nameListCode)
	{
		if (($items = CFactory::_('Compiler.Builder.Lists')->get($nameListCode)) !== null)
		{
			// set the Html values based on filter type
			$jhtml_sort        = "grid.sort";
			$jhtml_sort_icon   = "<i class=\"icon-menu-2\"></i>";
			$jhtml_sort_icon_2 = "";
			// for the new filter (2 = topbar)
			if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
			{
				$jhtml_sort        = "searchtools.sort";
				$jhtml_sort_icon   = "";
				$jhtml_sort_icon_2 = ", 'icon-menu-2'";
			}
			// main lang prefix
			$langView = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe($nameSingleCode, 'U');
			// set status lang
			$statusLangName = $langView . '_STATUS';
			// set id lang
			$idLangName = $langView . '_ID';
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $statusLangName, 'Status');
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $idLangName, 'Id');
			// set default
			$head = '<tr>';
			$head .= PHP_EOL . Indent::_(1)
				. "<?php if (\$this->canEdit&& \$this->canState): ?>";
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.ordering'))
			{
				$head .= PHP_EOL . Indent::_(2)
					. '<th width="1%" class="nowrap center hidden-phone">';
				$head .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('" . $jhtml_sort . "', '"
					. $jhtml_sort_icon . "'"
					. ", 'a.ordering', \$this->listDirn, \$this->listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'"
					. $jhtml_sort_icon_2 . "); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
			}
			$head .= PHP_EOL . Indent::_(2)
				. '<th width="20" class="nowrap center">';
			$head .= PHP_EOL . Indent::_(3)
				. "<?php echo Html::_('grid.checkall'); ?>";
			$head .= PHP_EOL . Indent::_(2) . "</th>";
			$head .= PHP_EOL . Indent::_(1) . "<?php else: ?>";
			$head .= PHP_EOL . Indent::_(2)
				. '<th width="20" class="nowrap center hidden-phone">';
			$head .= PHP_EOL . Indent::_(3) . "&#9662;";
			$head .= PHP_EOL . Indent::_(2) . "</th>";
			$head .= PHP_EOL . Indent::_(2)
				. '<th width="20" class="nowrap center">';
			$head .= PHP_EOL . Indent::_(3) . "&#9632;";
			$head .= PHP_EOL . Indent::_(2) . "</th>";
			$head .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
			// set footer Column number
			$this->listColnrBuilder[$nameListCode] = 4;
			// build the dynamic fields
			foreach ($items as $item)
			{
				// check if target is admin list
				if (1 == $item['target'] || 3 == $item['target'])
				{
					// check if we have an over-ride
					if (($list_head_override = CFactory::_('Compiler.Builder.List.Head.Override')->
						get($nameListCode . '.' . (int) $item['id'])) !== null)
					{
						$item['lang'] = $list_head_override;
					}
					$class = 'nowrap hidden-phone';
					if ($item['link'])
					{
						$class = 'nowrap';
					}
					// add sort options if required
					if ($item['sort'])
					{
						// if category
						if ($item['type'] === 'category')
						{
							// only one category per/view allowed at this point
							$title = "<?php echo Html::_('" . $jhtml_sort
								. "', '"
								. $item['lang'] . "', 'category_title"
								. "', \$this->listDirn, \$this->listOrder); ?>";
						}
						// set the custom code
						elseif (ArrayHelper::check(
							$item['custom']
						))
						{
							// keep an eye on this
							$title = "<?php echo Html::_('" . $jhtml_sort
								. "', '"
								. $item['lang'] . "', '" . $item['custom']['db']
								. "." . $item['custom']['text']
								. "', \$this->listDirn, \$this->listOrder); ?>";
						}
						else
						{
							$title = "<?php echo Html::_('" . $jhtml_sort
								. "', '"
								. $item['lang'] . "', 'a." . $item['code']
								. "', \$this->listDirn, \$this->listOrder); ?>";
						}
					}
					else
					{
						$title = "<?php echo Text:" . ":_('" . $item['lang']
							. "'); ?>";
					}
					$head .= PHP_EOL . Indent::_(1) . '<th class="' . $class
						. '" >';
					$head .= PHP_EOL . Indent::_(3) . $title;
					$head .= PHP_EOL . Indent::_(1) . "</th>";
					$this->listColnrBuilder[$nameListCode]++;
				}
			}
			// set default
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
			{
				$head .= PHP_EOL . Indent::_(1)
					. "<?php if (\$this->canState): ?>";
				$head .= PHP_EOL . Indent::_(2)
					. '<th width="10" class="nowrap center" >';
				$head .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('" . $jhtml_sort . "', '"
					. $statusLangName
					. "', 'a.published', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
				$head .= PHP_EOL . Indent::_(1) . "<?php else: ?>";
				$head .= PHP_EOL . Indent::_(2)
					. '<th width="10" class="nowrap center" >';
				$head .= PHP_EOL . Indent::_(3) . "<?php echo Text:" . ":_('"
					. $statusLangName . "'); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
				$head .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
			}
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.id'))
			{
				$head .= PHP_EOL . Indent::_(1)
					. '<th width="5" class="nowrap center hidden-phone" >';
				$head .= PHP_EOL . Indent::_(3)
					. "<?php echo Html::_('" . $jhtml_sort . "', '"
					. $idLangName
					. "', 'a.id', \$this->listDirn, \$this->listOrder); ?>";
				$head .= PHP_EOL . Indent::_(1) . "</th>";
			}
			$head .= PHP_EOL . "</tr>";

			return $head;
		}

		return '';
	}

	public function setListColnr($nameListCode)
	{
		if (isset($this->listColnrBuilder[$nameListCode]))
		{
			return $this->listColnrBuilder[$nameListCode];
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
	 */
	public function getTabLayoutFieldsArray($nameSingleCode)
	{
		// check if the load build is set for this view
		if (CFactory::_('Compiler.Builder.Layout')->exists($nameSingleCode))
		{
			$layout_builder = CFactory::_('Compiler.Builder.Layout')->get($nameSingleCode);
			$layoutArray = [];
			foreach ($layout_builder as $layout => $alignments)
			{
				$alignments = (array) $alignments;
				// sort the alignments
				ksort($alignments);
				$alignmentArray = [];
				foreach ($alignments as $alignment => $fields)
				{
					$fields = (array) $fields;
					// sort the fields
					ksort($fields);
					$fieldArray = [];
					foreach ($fields as $field)
					{
						// add each field
						$fieldArray[] = PHP_EOL . Indent::_(4) . "'" . $field
							. "'";
					}
					// add the alignemnt key
					$alignmentArray[] = PHP_EOL . Indent::_(3) . "'"
						. $this->alignmentOptions[$alignment] . "' => array("
						. implode(',', $fieldArray) . PHP_EOL . Indent::_(3)
						. ")";
				}
				// add the layout key
				$layoutArray[] = PHP_EOL . Indent::_(2) . "'"
					. StringHelper::safe($layout)
					. "' => array(" . implode(',', $alignmentArray) . PHP_EOL
					. Indent::_(2) . ")";
			}

			return 'array(' . implode(',', $layoutArray) . PHP_EOL . Indent::_(
					1
				) . ")";
		}

		return 'array()';
	}

	/**
	 * set Edit Body
	 *
	 * @param   array  $view  The view data
	 *
	 * @return  string   The edit body
	 *
	 */
	public function setEditBody(&$view)
	{
		// set view name
		$nameSingleCode = $view['settings']->name_single_code;
		// main lang prefix
		$langView = CFactory::_('Config')->lang_prefix . '_'
			. StringHelper::safe($nameSingleCode, 'U');
		// check if the load build is set for this view
		if (CFactory::_('Compiler.Builder.Layout')->exists($nameSingleCode))
		{
			// reset the linked keys
			$keys                 = [];
			$linkedViewIdentifier = [];
			// set the linked view tabs
			$linkedTab = $this->getEditBodyLinkedAdminViewsTabs(
				$view, $nameSingleCode, $keys, $linkedViewIdentifier
			);
			// custom tab searching array
			$searchTabs = [];
			// reset tab values
			$leftside    = '';
			$rightside   = '';
			$side_open   = '';
			$side_close  = '';
			$footer      = '';
			$header      = '';
			$mainwidth   = 12;
			$sidewidth   = 0;
			$width_class = 'span';
			$row_class   = 'row-fluid form-horizontal-desktop';
			$form_class  = 'form-horizontal';
			$uitab       = 'bootstrap';
			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$width_class = 'col-md-';
				$row_class   = 'row';
				$form_class  = 'main-card';
				$uitab       = 'uitab';
				$side_open   = '<div class="m-md-3">';
				$side_close  = '</div>';
			}
			// get the tabs with positions
			$tabBucket = $this->getEditBodyTabs(
				$nameSingleCode, $langView, $linkedTab, $keys,
				$linkedViewIdentifier, $searchTabs, $leftside, $rightside,
				$footer, $header, $mainwidth, $sidewidth
			);
			// tab counter
			$tabCounter = 0;
			// check if width is still 12
			$span = '';
			if ($mainwidth != 12)
			{
				$span = $width_class . $mainwidth;
			}
			// start building body
			$body = PHP_EOL . '<div class="' . $form_class . '">';
			if (CFactory::_('Config')->get('joomla_version', 3) != 3 &&
				(strlen((string) $leftside) > 2 || strlen((string) $rightside) > 2))
			{
				$body .= PHP_EOL . '<div class="row">';
			}
			if (StringHelper::check($span))
			{
				$body .= PHP_EOL . Indent::_(1) . '<div class="' . $span . '">';
			}
			// now build the dynamic tabs
			foreach ($tabBucket as $tabCodeName => $positions)
			{
				// get lang string
				$tabLangName = $positions['lang'];
				// build main center position
				$main       = '';
				$mainbottom = '';
				$this->setEditBodyTabMainCenterPositionDiv(
					$main, $mainbottom, $positions
				);
				// set acctive tab (must be in side foreach loop to get active tab code name)
				if ($tabCounter == 0)
				{
					$body .= PHP_EOL . PHP_EOL . Indent::_(1)
						. "<?php echo Html::_('{$uitab}.startTabSet', '"
						. $nameSingleCode . "Tab', ['active' => '"
						. $tabCodeName . "', 'recall' => true]); ?>";
				}
				// check if custom tab must be added
				if (($_customTabHTML = $this->addCustomTabs(
						$searchTabs[$tabCodeName], $nameSingleCode, 1
					)) !== false)
				{
					$body .= $_customTabHTML;
				}
				// if this is a linked view set permissions
				$closeIT = false;
				if (ArrayHelper::check($linkedViewIdentifier)
					&& in_array($tabCodeName, $linkedViewIdentifier))
				{
					// get view name
					$linkedViewId   = array_search(
						$tabCodeName, $linkedViewIdentifier
					);
					$linkedViewData = CFactory::_('Adminview.Data')->get($linkedViewId);
					$linkedCodeName = StringHelper::safe(
						$linkedViewData->name_single
					);
					// check if the item has permissions.
					if (CFactory::_('Compiler.Creator.Permission')->globalExist($linkedCodeName, 'core.access'))
					{
						$body .= PHP_EOL . PHP_EOL . Indent::_(1)
							. "<?php if (\$this->canDo->get('"
							. CFactory::_('Compiler.Creator.Permission')->getGlobal($linkedCodeName, 'core.access') . "')) : ?>";
						$closeIT = true;
					}
					else
					{
						$body .= PHP_EOL;
					}
				}
				else
				{
					$body .= PHP_EOL;
				}
				// start addtab body
				$body .= PHP_EOL . Indent::_(1)
					. "<?php echo Html::_('{$uitab}.addTab', '"
					. $nameSingleCode . "Tab', '" . $tabCodeName . "', Text:"
					. ":_('" . $tabLangName . "', true)); ?>";
				// add the main
				$body .= PHP_EOL . Indent::_(2)
					. '<div class="' . $row_class . '">';
				$body .= $main;
				$body .= PHP_EOL . Indent::_(2) . "</div>";
				// add main body bottom div if needed
				if (strlen((string) $mainbottom) > 0)
				{
					// add the main bottom
					$body .= PHP_EOL . Indent::_(2)
						. '<div class="' . $row_class . '">';
					$body .= $mainbottom;
					$body .= PHP_EOL . Indent::_(2) . "</div>";
				}
				// end addtab body
				$body .= PHP_EOL . Indent::_(1)
					. "<?php echo Html::_('{$uitab}.endTab'); ?>";
				// if we had permissions added
				if ($closeIT)
				{
					$body .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
				}
				// check if custom tab must be added
				if (($_customTabHTML = $this->addCustomTabs(
						$searchTabs[$tabCodeName], $nameSingleCode, 2
					)) !== false)
				{
					$body .= $_customTabHTML;
				}
				// set counter
				$tabCounter++;
			}
			// add option to load forms loaded in via plugins (TODO) we may want to move these tab locations
			$body .= PHP_EOL . PHP_EOL . Indent::_(1)
				. "<?php \$this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>";
			$body .= PHP_EOL . Indent::_(1) . "<?php \$this->tab_name = '"
				. $nameSingleCode . "Tab'; ?>";
			$body .= PHP_EOL . Indent::_(1)
				. "<?php echo LayoutHelper::render('joomla.edit.params', \$this); ?>";
			// add the publish and meta data tabs
			$body .= $this->getEditBodyPublishMetaTabs(
				$nameSingleCode, $langView
			);
			// end the tab set
			$body .= PHP_EOL . PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTabSet'); ?>";
			$body .= PHP_EOL . PHP_EOL . Indent::_(1) . "<div>";
			$body .= PHP_EOL . Indent::_(2)
				. '<input type="hidden" name="task" value="' . $nameSingleCode
				. '.edit" />';
			$body .= PHP_EOL . Indent::_(2)
				. "<?php echo Html::_('form.token'); ?>";
			$body .= PHP_EOL . Indent::_(1) . "</div>";
			// close divs
			if (StringHelper::check($span))
			{
				$body .= PHP_EOL . Indent::_(1) . "</div>";
			}
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$body .= PHP_EOL . "</div>";
			}
			// check if left has been set
			if (strlen((string) $leftside) > 2)
			{
				$left = PHP_EOL . Indent::_(1) . '<div class="' . $width_class . $sidewidth . '">' . $side_open;
				$left .= $leftside;
				$left .= PHP_EOL . Indent::_(1) . $side_close . "</div>";
			}
			else
			{
				$left = '';
			}
			// check if right has been set
			if (strlen((string) $rightside) > 2)
			{
				$right = PHP_EOL . Indent::_(1) . '<div class="' . $width_class . $sidewidth . '">' . $side_open;
				$right .= $rightside;
				$right .= PHP_EOL . Indent::_(1) . $side_close . "</div>";
			}
			else
			{
				$right = '';
			}

			if (CFactory::_('Config')->get('joomla_version', 3) != 3 &&
				(strlen((string) $leftside) > 2 || strlen((string) $rightside) > 2))
			{
				$right .= PHP_EOL . '</div>';
				$right .= PHP_EOL . '</div>';
			}
			elseif (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$body .= PHP_EOL . '</div>';
			}

			// set active tab and return
			return $header . $left . $body . $right . $footer;
		}

		return '';
	}

	/**
	 * get Edit Body Linked Admin Views
	 *
	 * @param   array   $view                  The view data
	 * @param   string  $nameSingleCode        The single view name
	 * @param   array   $keys                  The tabs to add in layout
	 * @param   array   $linkedViewIdentifier  The linked view identifier
	 *
	 * @return  array   The linked Admin Views tabs
	 *
	 */
	protected function getEditBodyLinkedAdminViewsTabs(&$view,
	                                                   &$nameSingleCode, &$keys, &$linkedViewIdentifier
	)
	{
		// start linked tabs bucket
		$linkedTab = [];
		// check if the view has linked admin view
		if (($linkedAdminViews = CFactory::_('Registry')->get('builder.linked_admin_views.' . $nameSingleCode, null)) !== null
			&& ArrayHelper::check($linkedAdminViews))
		{
			foreach ($linkedAdminViews as $linkedView)
			{
				// when this happens tell me.
				if (!isset($view['settings']->tabs[(int) $linkedView['tab']]))
				{
					echo "Tab Mismatch Oops! Check your linked views in admin view ($nameSingleCode) that they line-up.";
					echo '<pre>';
					var_dump($view['settings']->tabs, $linkedView);
					exit;
				}
				// get the tab name
				$tabName = $view['settings']->tabs[(int) $linkedView['tab']];
				// update the tab counter
				CFactory::_('Compiler.Builder.Tab.Counter')->set($nameSingleCode . '.' . $linkedView['tab'], $tabName);
				// add the linked view
				$linkedTab[$linkedView['adminview']] = $linkedView['tab'];
				// set the keys if values are set
				if (StringHelper::check($linkedView['key'])
					&& StringHelper::check(
						$linkedView['parentkey']
					))
				{
					$keys[$linkedView['adminview']]
						= array('key'       => $linkedView['key'],
						'parentKey' => $linkedView['parentkey']);
				}
				else
				{
					$keys[$linkedView['adminview']] = array('key'       => null,
						'parentKey' => null);
				}
				// set the button switches
				if (isset($linkedView['addnew']))
				{
					$keys[$linkedView['adminview']]['addNewButton']
						= (int) $linkedView['addnew'];
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
	 * @param   string  $nameSingleCode        The single view name
	 * @param   string  $langView              The main lang prefix
	 * @param   array   $linkedTab             The linked admin view tabs
	 * @param   array   $keys                  The tabs to add in layout
	 * @param   array   $linkedViewIdentifier  The linked view identifier
	 * @param   array   $searchTabs            The tabs to add in layout
	 * @param   string  $leftside              The left side html string
	 * @param   string  $rightside             The right side html string
	 * @param   string  $footer                The footer html string
	 * @param   string  $header                The header html string
	 * @param   int     $mainwidth             The main width value
	 * @param   int     $sidewidth             The side width value
	 *
	 * @return  array   The linked tabs
	 *
	 */
	protected function getEditBodyTabs(&$nameSingleCode, &$langView,
	                                   &$linkedTab, &$keys, &$linkedViewIdentifier, &$searchTabs, &$leftside,
	                                   &$rightside, &$footer, &$header, &$mainwidth, &$sidewidth
	)
	{
		// start tabs
		$tabs = [];
		// sort the tabs based on key order
		$tab_counter = (array) CFactory::_('Compiler.Builder.Tab.Counter')->get($nameSingleCode, []);
		ksort($tab_counter);
		// start tab building loop
		foreach ($tab_counter as $tabNr => $tabName)
		{
			$tabWidth  = 12;
			$lrCounter = 0;
			// set tab lang
			$tabLangName = $langView . '_' . StringHelper::safe(
					$tabName, 'U'
				);
			// set tab code name
			$tabCodeName = StringHelper::safe($tabName);
			/// set the values to use in search latter
			$searchTabs[$tabCodeName] = $tabNr;
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $tabLangName, $tabName);
			// check if linked view belongs to this tab
			$buildLayout  = true;
			$linkedViewId = '';
			if (ArrayHelper::check($linkedTab))
			{
				if (($linkedViewId = array_search($tabNr, $linkedTab))
					!== false)
				{
					// don't build (since this is a linked view)
					$buildLayout = false;
				}
			}
			// build layout these are actual fields
			if ($buildLayout && CFactory::_('Compiler.Builder.Layout')->exists($nameSingleCode . '.' . $tabName))
			{
				// sort to make sure it loads left first
				$alignments = CFactory::_('Compiler.Builder.Layout')->get($nameSingleCode . '.' . $tabName);
				ksort($alignments);
				foreach ($alignments as $alignment => $names)
				{
					// set layout code name
					$layoutCodeName = $tabCodeName . '_'
						. $this->alignmentOptions[$alignment];
					// reset each time
					$items       = '';
					$itemCounter = 0;
					// sort the names based on order of keys
					$names = (array) $names;
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
							$items .= "," . PHP_EOL . Indent::_(1) . "'" . $name
								. "'";
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
							$this->setLayout(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutitems'
							);
							// set the lang to tab
							$tabs[$tabCodeName]['lang'] = $tabLangName;
							// load the body
							if (!isset($tabs[$tabCodeName][(int) $alignment]))
							{
								$tabs[$tabCodeName][(int) $alignment] = '';
							}
							$tabs[$tabCodeName][(int) $alignment] .= "<?php echo LayoutHelper::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 3: // fullwidth
							// set as items layout
							$this->setLayout(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutfull'
							);
							// set the lang to tab
							$tabs[$tabCodeName]['lang'] = $tabLangName;
							// load the body
							if (!isset($tabs[$tabCodeName][(int) $alignment]))
							{
								$tabs[$tabCodeName][(int) $alignment] = '';
							}
							$tabs[$tabCodeName][(int) $alignment] .= "<?php echo LayoutHelper::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 4: // above
							// set as title layout
							$this->setLayout(
								$nameSingleCode, $layoutCodeName, $items,
								'layouttitle'
							);
							// load to header
							$header .= PHP_EOL
								. "<?php echo LayoutHelper::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 5: // under
							// set as title layout
							$this->setLayout(
								$nameSingleCode, $layoutCodeName, $items,
								'layouttitle'
							);
							// load to footer
							$footer .= PHP_EOL . PHP_EOL
								. "<div class=\"clearfix\"></div>" . PHP_EOL
								. "<?php echo LayoutHelper::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 6: // left side
							$tabWidth = $tabWidth - 2;
							// set as items layout
							$this->setLayout(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutitems'
							);
							// load the body
							$leftside .= PHP_EOL . Indent::_(2)
								. "<?php echo LayoutHelper::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 7: // right side
							$tabWidth = $tabWidth - 2;
							// set as items layout
							$this->setLayout(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutitems'
							);
							// load the body
							$rightside .= PHP_EOL . Indent::_(2)
								. "<?php echo LayoutHelper::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
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
				$codeName = StringHelper::safe(
					$this->uniquekey(3) . $tabCodeName
				);
				// set as items layout
				$this->setLayout(
					$nameSingleCode, $layoutCodeName, $codeName,
					'layoutlinkedview'
				);
				// set the lang to tab
				$tabs[$tabCodeName]['lang'] = $tabLangName;
				// set all the linked view stuff
				$this->secondRunAdmin['setLinkedView'][] = array(
					'viewId'         => $linkedViewId,
					'nameSingleCode' => $nameSingleCode,
					'codeName'       => $codeName,
					'layoutCodeName' => $layoutCodeName,
					'key'            => $keys[$linkedViewId]['key'],
					'parentKey'      => $keys[$linkedViewId]['parentKey'],
					'addNewButon'    => $keys[$linkedViewId]['addNewButton']);
				// load the body
				if (!isset($tabs[$tabCodeName][3]))
				{
					$tabs[$tabCodeName][3] = '';
				}
				$tabs[$tabCodeName][3] .= "<?php echo LayoutHelper::render('"
					. $nameSingleCode . "." . $layoutCodeName
					. "', \$this); ?>";
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
	 * @param   string  $main        The main position of this tab
	 * @param   string  $mainbottom  The main bottom position of this tab
	 * @param   array   $positions   The build positions of this tab
	 *
	 * @return  array   The linked Admin Views tabs
	 *
	 */
	protected function setEditBodyTabMainCenterPositionDiv(&$main, &$mainbottom,
														   &$positions
	)
	{
		$width_class       = 'span';
		if (CFactory::_('Config')->get('joomla_version', 3) != 3)
		{
			$width_class = 'col-md-';
		}

		foreach ($positions as $position => $string)
		{
			if ($positions['lr'] == 2)
			{
				switch ($position)
				{
					case 1: // left
					case 2: // right
						$main .= PHP_EOL . Indent::_(3) . '<div class="' . $width_class . '6">';
						$main .= PHP_EOL . Indent::_(4) . $string;
						$main .= PHP_EOL . Indent::_(3) . '</div>';
						break;
				}
			}
			else
			{
				switch ($position)
				{
					case 1: // left
					case 2: // right
						$main .= PHP_EOL . Indent::_(3)
							. '<div class="' . $width_class . '12">';
						$main .= PHP_EOL . Indent::_(4) . $string;
						$main .= PHP_EOL . Indent::_(3) . '</div>';
						break;
				}
			}
			switch ($position)
			{
				case 3: // fullwidth
					$mainbottom .= PHP_EOL . Indent::_(3)
						. '<div class="' . $width_class . '12">';
					$mainbottom .= PHP_EOL . Indent::_(4) . $string;
					$mainbottom .= PHP_EOL . Indent::_(3) . '</div>';
					break;
			}
		}
	}

	/**
	 * get Edit Body Publish and Meta Tab
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $langView        The main lang prefix
	 *
	 * @return  string   The published and Meta Data Tabs
	 *
	 */
	protected function getEditBodyPublishMetaTabs(&$nameSingleCode, &$langView
	)
	{
		// build the two tabs
		$tabs = '';
		// set default publishing tab lang
		$tabLangName = $langView . '_PUBLISHING';
		// add to lang array
		CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $tabLangName, 'Publishing');
		// the default publishing items
		$items = array('left' => array(), 'right' => array());
		// Setup the default (custom) fields
		// only load (1 => 'left', 2 => 'right')
		$fieldsAddedRight = false;
		$width_class      = 'span';
		$row_class        = 'row-fluid form-horizontal-desktop';
		$uitab            = 'bootstrap';
		if (CFactory::_('Config')->get('joomla_version', 3) != 3)
		{
			$width_class = 'col-md-';
			$row_class   = 'row';
			$uitab       = 'uitab';
		}
		if (CFactory::_('Compiler.Builder.New.Publishing.Fields')->exists($nameSingleCode))
		{
			$new_published_fields = CFactory::_('Compiler.Builder.New.Publishing.Fields')->get($nameSingleCode);
			foreach ($new_published_fields as $df_alignment => $df_items)
			{
				foreach ($df_items as $df_order => $df_name)
				{
					if ($df_alignment == 2 || $df_alignment == 1)
					{
						$items[$this->alignmentOptions[$df_alignment]][$df_order]
							= $df_name;
					}
					else
					{
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREEFIELD_WARNINGHTHREE'), 'Warning'
						);
						$this->app->enqueueMessage(
							Text::sprintf(
								'Your <b>%s</b> field could not be added, since the <b>%s</b> alignment position is not available in the %s (publishing) tab. Please only target <b>Left or right</b> in the publishing tab.',
								$df_name,
								$this->alignmentOptions[$df_alignment],
								$nameSingleCode
							), 'Warning'
						);
					}
				}
			}
			// set switch to trigger notice if custom fields added to right
			if (ArrayHelper::check($items['right']))
			{
				$fieldsAddedRight = true;
			}
		}
		// load all defaults
		$loadDefaultFields = array(
			'left'  => array('created', 'created_by', 'modified',
				'modified_by'),
			'right' => array('published', 'ordering', 'access', 'version',
				'hits', 'id')
		);
		foreach ($loadDefaultFields as $d_alignment => $defaultFields)
		{
			foreach ($defaultFields as $defaultField)
			{
				if (!CFactory::_('Compiler.Builder.Moved.Publishing.Fields')->exists($nameSingleCode . '.' . $defaultField))
				{
					if ($defaultField != 'access')
					{
						$items[$d_alignment][] = $defaultField;
					}
					elseif ($defaultField === 'access'
						&& CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode))
					{
						$items[$d_alignment][] = $defaultField;
					}
				}
			}
		}
		// check if metadata is added to this view
		if (CFactory::_('Compiler.Builder.Meta.Data')->exists($nameSingleCode))
		{
			// set default publishing tab code name
			$tabCodeNameLeft  = 'publishing';
			$tabCodeNameRight = 'metadata';
			// the default publishing tiems
			if (ArrayHelper::check($items['left'])
				|| ArrayHelper::check($items['right']))
			{
				$items_one = '';
				// load the items into one side
				if (ArrayHelper::check($items['left']))
				{
					$items_one .= "'" . implode(
							"'," . PHP_EOL . Indent::_(1) . "'", $items['left']
						) . "'";
				}
				if (ArrayHelper::check($items['right']))
				{
					// there is already fields just add these
					if (strlen($items_one) > 3)
					{
						$items_one .= "," . PHP_EOL . Indent::_(1) . "'"
							. implode(
								"'," . PHP_EOL . Indent::_(1) . "'",
								$items['right']
							) . "'";
					}
					// no fields has been added yet
					else
					{
						$items_one .= "'" . implode(
								"'," . PHP_EOL . Indent::_(1) . "'",
								$items['right']
							) . "'";
					}
				}
				// only triger the info notice if there were custom fields targeted to the right alignment position.
				if ($fieldsAddedRight)
				{
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HR_HTHREEFIELD_NOTICEHTHREE'), 'Notice'
					);
					$this->app->enqueueMessage(
						Text::sprintf(
							'Your field/s added to the <b>right</b> alignment position in the %s (publishing) tab was added to the <b>left</b>. Since we have metadata fields on the right. Fields can only be loaded to the right of the publishing tab if there is no metadata fields.',
							$nameSingleCode
						), 'Notice'
					);
				}
				// set the publishing layout
				$this->setLayout(
					$nameSingleCode, $tabCodeNameLeft, $items_one,
					'layoutpublished'
				);
				$items_one = true;
			}
			else
			{
				$items_one = false;
			}
			// set the metadata layout
			$this->setLayout(
				$nameSingleCode, $tabCodeNameRight, false, 'layoutmetadata'
			);
			$items_two = true;
		}
		else
		{
			// set default publishing tab code name
			$tabCodeNameLeft  = 'publishing';
			$tabCodeNameRight = 'publlshing';
			// the default publishing tiems
			if (ArrayHelper::check($items['left'])
				|| ArrayHelper::check($items['right']))
			{
				// load left items that remain
				if (ArrayHelper::check($items['left']))
				{
					// load all items
					$items_one = "'" . implode(
							"'," . PHP_EOL . Indent::_(1) . "'", $items['left']
						) . "'";
					// set the publishing layout
					$this->setLayout(
						$nameSingleCode, $tabCodeNameLeft, $items_one,
						'layoutpublished'
					);
					$items_one = true;
				}
				// load right items that remain
				if (ArrayHelper::check($items['right']))
				{
					// load all items
					$items_two = "'" . implode(
							"'," . PHP_EOL . Indent::_(1) . "'", $items['right']
						) . "'";
					// set the publishing layout
					$this->setLayout(
						$nameSingleCode, $tabCodeNameRight, $items_two,
						'layoutpublished'
					);
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
			$classs = "{$width_class}6";
		}
		elseif ($items_one || $items_two)
		{
			$classs = "{$width_class}12";
		}
		// only load this if needed
		if ($items_one || $items_two)
		{
			// check if the item has permissions.
			$publishingPerOR  = [];
			$allToBeChekcedOR = array('core.edit.created_by',
				'core.edit.created',
				'core.edit.state');
			foreach ($allToBeChekcedOR as $core_permission)
			{
				// set permissions.
				$publishingPerOR[] = "\$this->canDo->get('"
					. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, $core_permission) . "')";
			}
			$publishingPerAND  = [];
			$allToBeChekcedAND = array('core.delete', 'core.edit.state');
			foreach ($allToBeChekcedAND as $core_permission)
			{
				// set permissions.
				$publishingPerAND[] = "\$this->canDo->get('"
					. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, $core_permission) . "')";
			}
			// check if custom tab must be added
			if (($_customTabHTML = $this->addCustomTabs(
					15, $nameSingleCode, 1
				)) !== false)
			{
				$tabs .= $_customTabHTML;
			}
			// add the AND values to OR
			$publishingPerOR[] = '(' . implode(' && ', $publishingPerAND) . ')';
			// now build the complete showhide behaviour for the publishing area
			$tabs .= PHP_EOL . PHP_EOL . Indent::_(1) . "<?php if (" . implode(
					' || ', $publishingPerOR
				) . ") : ?>";
			// set the default publishing tab
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.addTab', '"
				. $nameSingleCode . "Tab', '" . $tabCodeNameLeft . "', Text:"
				. ":_('" . $tabLangName . "', true)); ?>";
			$tabs .= PHP_EOL . Indent::_(2)
				. '<div class="' . $row_class . '">';
			if ($items_one)
			{
				$tabs .= PHP_EOL . Indent::_(3) . '<div class="' . $classs
					. '">';
				$tabs .= PHP_EOL . Indent::_(4)
					. "<?php echo LayoutHelper::render('" . $nameSingleCode
					. "." . $tabCodeNameLeft . "', \$this); ?>";
				$tabs .= PHP_EOL . Indent::_(3) . "</div>";
			}
			if ($items_two)
			{
				$tabs .= PHP_EOL . Indent::_(3) . '<div class="' . $classs
					. '">';
				$tabs .= PHP_EOL . Indent::_(4)
					. "<?php echo LayoutHelper::render('" . $nameSingleCode
					. "." . $tabCodeNameRight . "', \$this); ?>";
				$tabs .= PHP_EOL . Indent::_(3) . "</div>";
			}
			$tabs .= PHP_EOL . Indent::_(2) . "</div>";
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			$tabs .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
			// check if custom tab must be added
			if (($_customTabHTML = $this->addCustomTabs(
					15, $nameSingleCode, 2
				)) !== false)
			{
				$tabs .= $_customTabHTML;
			}
		}

		// make sure we don't load it to a view with the name component (as this will cause conflict with Joomla conventions)
		if ($nameSingleCode != 'component'
			&& CFactory::_('Compiler.Builder.Has.Permissions')->exists($nameSingleCode))
		{
			// set permissions tab lang
			$tabLangName = $langView . '_PERMISSION';
			// set permissions tab code name
			$tabCodeName = 'permissions';
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $tabLangName, 'Permissions');
			// set the permissions tab
			$tabs .= PHP_EOL . PHP_EOL . Indent::_(1)
				. "<?php if (\$this->canDo->get('core.admin')) : ?>";
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.addTab', '"
				. $nameSingleCode . "Tab', '" . $tabCodeName . "', Text:"
				. ":_('" . $tabLangName . "', true)); ?>";
			$tabs .= PHP_EOL . Indent::_(2)
				. '<div class="' . $row_class . '">';
			$tabs .= PHP_EOL . Indent::_(3) . '<div class="' . $width_class . '12">';
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$tabs .= PHP_EOL . Indent::_(4) . '<fieldset class="adminform">';
				$tabs .= PHP_EOL . Indent::_(5) . '<div class="adminformlist">';
				$tabs .= PHP_EOL . Indent::_(5)
					. "<?php foreach (\$this->form->getFieldset('accesscontrol') as \$field): ?>";
				$tabs .= PHP_EOL . Indent::_(6) . "<div>";
				$tabs .= PHP_EOL . Indent::_(7)
					. "<?php echo \$field->label; echo \$field->input;?>";
				$tabs .= PHP_EOL . Indent::_(6) . "</div>";
				$tabs .= PHP_EOL . Indent::_(6) . '<div class="clearfix"></div>';
				$tabs .= PHP_EOL . Indent::_(5) . "<?php endforeach; ?>";
				$tabs .= PHP_EOL . Indent::_(5) . "</div>";
				$tabs .= PHP_EOL . Indent::_(4) . "</fieldset>";
            }
			else
			{
				$tabs .= PHP_EOL . Indent::_(4) . '<fieldset id="fieldset-rules" class="options-form">';
				$tabs .= PHP_EOL . Indent::_(5)
					. "<legend><?php echo Text:"
					. ":_('{$tabLangName}'); ?></legend>";
				$tabs .= PHP_EOL . Indent::_(5) . "<div>";
				$tabs .= PHP_EOL . Indent::_(6)
					. "<?php echo \$this->form->getInput('rules'); ?>";
				$tabs .= PHP_EOL . Indent::_(5) . "</div>";
				$tabs .= PHP_EOL . Indent::_(4) . "</fieldset>";
			}
			$tabs .= PHP_EOL . Indent::_(3) . "</div>";
			$tabs .= PHP_EOL . Indent::_(2) . "</div>";
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			$tabs .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
		}

		return $tabs;
	}

	protected function addCustomTabs($nr, $name_single, $target)
	{
		// check if this view is having custom tabs
		if (($tabs = CFactory::_('Compiler.Builder.Custom.Tabs')->get($name_single)) !== null
			&& ArrayHelper::check($tabs))
		{
			$html = [];
			foreach ($tabs as $customTab)
			{
				if (ArrayHelper::check($customTab)
					&& isset($customTab['html']))
				{
					if ($customTab['tab'] == $nr
						&& $customTab['position'] == $target
						&& isset($customTab['html'])
						&& StringHelper::check(
							$customTab['html']
						))
					{
						$html[] = $customTab['html'];
					}
				}
			}
			// return if found
			if (ArrayHelper::check($html))
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
			$fadein[] = Indent::_(1) . "// waiting spinner";
			$fadein[] = Indent::_(1) . "var outerDiv = document.querySelector('body');";
			$fadein[] = Indent::_(1) . "var loadingDiv = document.createElement('div');";
			$fadein[] = Indent::_(1) . "loadingDiv.id = 'loading';";
			$fadein[] = Indent::_(1) . "loadingDiv.style.cssText = \"background: rgba(255, 255, 255, .8) url('components/com_"
				. CFactory::_('Config')->component_code_name
				. "/assets/images/import.gif') 50% 15% no-repeat; top: \" + (outerDiv.getBoundingClientRect().top + window.pageYOffset) + \"px; left: \" + (outerDiv.getBoundingClientRect().left + window.pageXOffset) + \"px; width: \" + outerDiv.offsetWidth + \"px; height: \" + outerDiv.offsetHeight + \"px; position: fixed; opacity: 0.80; -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80); filter: alpha(opacity=80); display: none;\";";
			$fadein[] = Indent::_(1) . "outerDiv.appendChild(loadingDiv);";
			$fadein[] = Indent::_(1) . "loadingDiv.style.display = 'block';";
			$fadein[] = Indent::_(1) . "// when page is ready remove and show";
			$fadein[] = Indent::_(1) . "window.addEventListener('load', function() {";
			$fadein[] = Indent::_(2) . "var componentLoader = document.getElementById('" . CFactory::_('Config')->component_code_name . "_loader');";
			$fadein[] = Indent::_(2) . "if (componentLoader) componentLoader.style.display = 'block';";
			$fadein[] = Indent::_(2) . "loadingDiv.style.display = 'none';";
			$fadein[] = Indent::_(1) . "});";
			$fadein[] = "</script>";
			$fadein[] = "<div id=\"" . CFactory::_('Config')->component_code_name . "_loader\" style=\"display: none;\">";

			return implode(PHP_EOL, $fadein);
		}

		return "<div id=\"" . CFactory::_('Config')->component_code_name . "_loader\">";
	}

	/**
	 * @param $nameSingleCode
	 * @param $layoutName
	 * @param $items
	 * @param $type
	 */
	public function setLayout($nameSingleCode, $layoutName, $items, $type)
	{
		// we check if there is a local override
		if (!$this->setLayoutOverride($nameSingleCode, $layoutName, $items))
		{
			// first build the layout file
			$target = array('admin' => $nameSingleCode);
			CFactory::_('Utilities.Structure')->build($target, $type, $layoutName);
			// add to front if needed
			if (CFactory::_('Config')->lang_target === 'both')
			{
				$target = array('site' => $nameSingleCode);
				CFactory::_('Utilities.Structure')->build($target, $type, $layoutName);
			}
			if (StringHelper::check($items))
			{
				// LAYOUTITEMS <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutName . '|LAYOUTITEMS', $items);
			}
			else
			{
				// LAYOUTITEMS <<<DYNAMIC>>>
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutName . '|bogus', 'boom');
			}
		}
	}

	/**
	 * @param   string  $nameSingleCode
	 * @param   string  $layoutName
	 * @param   string  $items
	 *
	 * @return  boolean  true if override was found
	 */
	protected function setLayoutOverride($nameSingleCode, $layoutName, $items)
	{
		if (($data = $this->getLayoutOverride($nameSingleCode, $layoutName))
			!== null)
		{
			// first build the layout file
			$target = array('admin' => $nameSingleCode);
			CFactory::_('Utilities.Structure')->build($target, 'layoutoverride', $layoutName);
			// add to front if needed
			if (CFactory::_('Config')->lang_target === 'both')
			{
				$target = array('site' => $nameSingleCode);
				CFactory::_('Utilities.Structure')->build($target, 'layoutoverride', $layoutName);
			}
			// make sure items is an empty string (should not be needed.. but)
			if (!StringHelper::check($items))
			{
				$items = '';
			}
			// set placeholder
			$placeholder                                    = CFactory::_('Placeholder')->active;
			$placeholder[Placefix::_h('LAYOUTITEMS')] = $items;
			// OVERRIDE_LAYOUT_CODE <<<DYNAMIC>>>
			$php_view = (array) explode(PHP_EOL, (string) $data['php_view'] ?? '');
			if (ArrayHelper::check($php_view))
			{
				$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_CODE',
					CFactory::_('Placeholder')->update(
						$php_view, $placeholder
					)
				);
			}
			else
			{
				CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_CODE', '');
			}
			// OVERRIDE_LAYOUT_BODY <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_BODY',
				PHP_EOL . CFactory::_('Placeholder')->update(
					$data['html'] ?? '', $placeholder
				)
			);
			// OVERRIDE_LAYOUT_HEADER <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_HEADER',
				(($header = CFactory::_('Header')->get(
						'override.layout',
						$layoutName, false)
					) !== false) ? PHP_EOL . PHP_EOL . $header : ''
			);

			// since override was found
			return true;
		}

		return false;
	}

	/**
	 * @param   string  $nameSingleCode
	 * @param   string  $layoutName
	 *
	 * @return  array|null  the layout data
	 */
	protected function getLayoutOverride($nameSingleCode, $layoutName): ?array
	{
		$get_key = null;
		// check if there is an override by component name, view name, & layout name
		if ($this->setTemplateAndLayoutData(
			'override', $nameSingleCode, false, array(''),
			array(CFactory::_('Config')->component_code_name . $nameSingleCode . $layoutName)
		))
		{
			$get_key = CFactory::_('Config')->component_code_name . $nameSingleCode . $layoutName;
		}
		// check if there is an override by component name & layout name
		elseif ($this->setTemplateAndLayoutData(
			'override', $nameSingleCode, false, array(''),
			array(CFactory::_('Config')->component_code_name . $layoutName)
		))
		{
			$get_key = CFactory::_('Config')->component_code_name . $layoutName;
		}
		// check if there is an override by view & layout name
		elseif ($this->setTemplateAndLayoutData(
			'override', $nameSingleCode, false, array(''),
			array($nameSingleCode . $layoutName)
		))
		{
			$get_key = $nameSingleCode . $layoutName;
		}
		// check if there is an override by layout name (global layout)
		elseif ($this->setTemplateAndLayoutData(
			'override', $nameSingleCode, false, array(''),
			array($layoutName)
		))
		{
			$get_key = $layoutName;
		}

		// check if we have a get key
		if ($get_key)
		{
			$data = CFactory::_('Compiler.Builder.Layout.Data')->
				get(CFactory::_('Config')->build_target . '.' . $get_key);

			if ($data === null)
			{
				var_dump(CFactory::_('Config')->build_target . '.' . $get_key);
				var_dump('admin.' .$get_key);
				var_dump(CFactory::_('Compiler.Builder.Layout.Data')->get('admin.' .$get_key));
				var_dump('site.' .$get_key);
				var_dump(CFactory::_('Compiler.Builder.Layout.Data')->get('site.' . $get_key));
				var_dump('both.' .$get_key);
				var_dump(CFactory::_('Compiler.Builder.Layout.Data')->get('both.' . $get_key));
				exit;
			}
			// remove since we will add the layout now
			if (CFactory::_('Config')->lang_target === 'both')
			{
				CFactory::_('Compiler.Builder.Layout.Data')->
					remove('admin.' . $get_key);
				CFactory::_('Compiler.Builder.Layout.Data')->
					remove('site.' . $get_key);
				CFactory::_('Compiler.Builder.Layout.Data')->
					remove('both.' . $get_key);
			}
			else
			{
				CFactory::_('Compiler.Builder.Layout.Data')->
					remove(CFactory::_('Config')->build_target . '.' . $get_key);
			}

			return $data;
		}

		return null;
	}

	/**
	 * @param $args
	 */
	public function setLinkedView($args)
	{
		/**
		 * @var $viewId
		 * @var $nameSingleCode
		 * @var $codeName
		 * @var $layoutCodeName
		 * @var $key
		 * @var $parentKey
		 * @var $addNewButon
		 */
		extract($args, EXTR_PREFIX_SAME, "oops");
		$single         = '';
		$name_list_code = '';
		foreach (CFactory::_('Component')->get('admin_views') as $array)
		{
			if ($array['adminview'] == $viewId)
			{
				$name_single_code = $array['settings']->name_single_code;
				$name_list_code   = $array['settings']->name_list_code;
				break;
			}
		}
		if (StringHelper::check($name_single_code)
			&& StringHelper::check($name_list_code))
		{
			$head         = $this->setListHeadLinked(
				$name_single_code, $name_list_code, $addNewButon,
				$nameSingleCode
			);
			$body         = $this->setListBodyLinked(
				$name_single_code, $name_list_code, $nameSingleCode
			);
			$functionName = StringHelper::safe($codeName, 'F');
			// LAYOUTITEMSTABLE <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSTABLE',
				$head . $body
			);
			// LAYOUTITEMSHEADER <<<DYNAMIC>>>
			$headerscript = '//' . Line::_(__Line__, __Class__)
				. ' set the edit URL';
			$headerscript .= PHP_EOL . '$edit = "index.php?option=com_'
				. CFactory::_('Config')->component_code_name . '&view=' . $name_list_code
				. '&task='
				. $name_single_code . '.edit";';
			$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
				. ' set a return value';
			$headerscript .= PHP_EOL
				. '$return = ($id) ? "index.php?option=com_'
				. CFactory::_('Config')->component_code_name . '&view=' . $nameSingleCode
				. '&layout=edit&id=" . $id : "";';
			$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
				. ' check for a return value';
			$headerscript .= PHP_EOL
				. '$jinput = Factory::getApplication()->input;';
			$headerscript .= PHP_EOL
				. "if (\$_return = \$jinput->get('return', null, 'base64'))";
			$headerscript .= PHP_EOL . '{';
			$headerscript .= PHP_EOL . Indent::_(1)
				. '$return .= "&return=" . $_return;';
			$headerscript .= PHP_EOL . '}';
			$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
				. ' check if return value was set';
			$headerscript .= PHP_EOL . 'if ('
				. 'Super' . '___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($return))';
			$headerscript .= PHP_EOL . '{';
			$headerscript .= PHP_EOL . Indent::_(1) . '//' . Line::_(
					__LINE__,__CLASS__
				) . ' set the referral values';
			$headerscript .= PHP_EOL . Indent::_(1) . '$ref = ($id) ? "&ref='
				. $nameSingleCode
				. '&refid=" . $id . "&return=" . urlencode(base64_encode($return)) : "&return=" . urlencode(base64_encode($return));';
			$headerscript .= PHP_EOL . '}';
			$headerscript .= PHP_EOL . 'else';
			$headerscript .= PHP_EOL . '{';
			$headerscript .= PHP_EOL . Indent::_(1) . '$ref = ($id) ? "&ref='
				. $nameSingleCode . '&refid=" . $id : "";';
			$headerscript .= PHP_EOL . '}';
			if ($addNewButon > 0)
			{
				if (CFactory::_('Config')->get('joomla_version', 3) == 3)
				{
					$add_key = 'edit';
				}
				else
				{
					$add_key = 'add';
				}
				// add the link for new
				if ($addNewButon == 1 || $addNewButon == 2)
				{
					$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
						. ' set the create new URL';
					$headerscript .= PHP_EOL . '$new = "index.php?option=com_'
						. CFactory::_('Config')->component_code_name . '&view=' . $name_list_code
						. '&task='
						. $name_single_code . '.' . $add_key . '" . $ref;';
				}
				// and the link for close and new
				if ($addNewButon == 2 || $addNewButon == 3)
				{
					$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
						. ' set the create new and close URL';
					$headerscript .= PHP_EOL
						. '$close_new = "index.php?option=com_'
						. CFactory::_('Config')->component_code_name . '&view=' . $name_list_code
						. '&task='
						. $name_single_code . '.' . $add_key . '";';
				}
				$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
					. ' load the action object';
				$headerscript .= PHP_EOL . '$can = '
					. CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper::getActions(' . "'"
					. $name_single_code . "'"
					. ');';
			}
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSHEADER',
				$headerscript
			);
			// LINKEDVIEWITEMS <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->add($nameSingleCode . '|LINKEDVIEWITEMS',
				PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get Linked view data" . PHP_EOL . Indent::_(2)
				. "\$this->" . $codeName . " = \$this->get('" . $functionName
				. "');", false
			);
			// LINKEDVIEWTABLESCRIPTS <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '|LINKEDVIEWTABLESCRIPTS', $this->setFootableScripts());
			if (strpos((string) $parentKey, '-R>') !== false
				|| strpos((string) $parentKey, '-A>') !== false)
			{
				list($parent_key) = explode('-', (string) $parentKey);
			}
			elseif (strpos((string) $parentKey, '-OR>') !== false)
			{
				// this is not good... (TODO)
				$parent_keys = explode('-OR>', (string) $parentKey);
			}
			else
			{
				$parent_key = $parentKey;
			}

			if (strpos((string) $key, '-R>') !== false || strpos((string) $key, '-A>') !== false)
			{
				list($_key) = explode('-', (string) $key);
			}
			elseif (strpos((string) $key, '-OR>') !== false)
			{
				$_key = str_replace('-OR>', '', (string) $key);
			}
			else
			{
				$_key = $key;
			}
			// LINKEDVIEWGLOBAL <<<DYNAMIC>>>
			if (isset($parent_keys)
				&& ArrayHelper::check(
					$parent_keys
				))
			{
				$globalKey = [];
				foreach ($parent_keys as $parent_key)
				{
					$globalKey[$parent_key]
						= StringHelper::safe(
						$_key . $this->uniquekey(4)
					);
					CFactory::_('Compiler.Builder.Content.Multi')->add($nameSingleCode . '|LINKEDVIEWGLOBAL',
						PHP_EOL . Indent::_(2) . "\$this->"
						. $globalKey[$parent_key] . " = \$item->" . $parent_key . ";", false
					);
				}
			}
			else
			{
				// set the global key
				$globalKey = StringHelper::safe(
					$_key . $this->uniquekey(4)
				);
				CFactory::_('Compiler.Builder.Content.Multi')->add($nameSingleCode . '|LINKEDVIEWGLOBAL',
					PHP_EOL . Indent::_(2) . "\$this->" . $globalKey
					. " = \$item->" . $parent_key . ";", false
				);
			}
			// LINKEDVIEWMETHODS <<<DYNAMIC>>>
			CFactory::_('Compiler.Builder.Content.Multi')->add($nameSingleCode . '|LINKEDVIEWMETHODS',
				$this->setListQueryLinked(
					$name_single_code, $name_list_code, $functionName, $key, $_key,
					$parentKey,
					$parent_key, $globalKey
				), false
			);
		}
		else
		{
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSTABLE',
				'oops! error.....'
			);
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSHEADER', '');
		}
	}

	/**
	 * @param   bool  $init
	 *
	 * @return string
	 */
	public function setFootableScripts($init = true)
	{
		$footable_version = CFactory::_('Config')->get('footable_version', 2);
		if (2 == $footable_version) // loading version 2
		{
			$foo = PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add the CSS for Footable.";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v2/css/footable.core.min.css', ['version' => 'auto']);";
			$foo .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Use the Metro Style";
			$foo .= PHP_EOL . Indent::_(2)
				. "if (!isset(\$this->fooTableStyle) || 0 == \$this->fooTableStyle)";
			$foo .= PHP_EOL . Indent::_(2) . "{";
			$foo .= PHP_EOL . Indent::_(3)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v2/css/footable.metro.min.css', ['version' => 'auto']);";
			$foo .= PHP_EOL . Indent::_(2) . "}";
			$foo .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Use the Legacy Style.";
			$foo .= PHP_EOL . Indent::_(2)
				. "elseif (isset(\$this->fooTableStyle) && 1 == \$this->fooTableStyle)";
			$foo .= PHP_EOL . Indent::_(2) . "{";
			$foo .= PHP_EOL . Indent::_(3)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v2/css/footable.standalone.min.css', ['version' => 'auto']);";
			$foo .= PHP_EOL . Indent::_(2) . "}";
			$foo .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add the JavaScript for Footable";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name . "/footable-v2/js/footable.js', ['version' => 'auto']);";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v2/js/footable.sort.js', ['version' => 'auto']);";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v2/js/footable.filter.js', ['version' => 'auto']);";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v2/js/footable.paginate.js', ['version' => 'auto']);";
			if ($init)
			{
				$foo .= PHP_EOL . PHP_EOL . Indent::_(2)
					. '$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery('
					. "'.footable'" . ').footable(); }); jQuery('
					. "'.nav-tabs'" . ').on(' . "'click'" . ', ' . "'li'"
					. ', function() { setTimeout(tableFix, 10); }); }); function tableFix() { jQuery('
					. "'.footable'" . ').trigger(' . "'footable_resize'"
					. '); }";';
				$foo .= PHP_EOL . Indent::_(2)
					. "\$this->getDocument()->addScriptDeclaration(\$footable);"
					. PHP_EOL;
			}
		}
		elseif (3 == $footable_version) // loading version 3
		{

			$foo = PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add the CSS for Footable";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('stylesheet', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', ['version' => 'auto']);";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('stylesheet', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v3/css/footable.standalone.min.css', ['version' => 'auto']);";
			$foo .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Add the JavaScript for Footable (adding all functions)";
			$foo .= PHP_EOL . Indent::_(2)
				. "Html::_('script', 'media/com_"
				. CFactory::_('Config')->component_code_name
				. "/footable-v3/js/footable.min.js', ['version' => 'auto']);";
			if ($init)
			{
				$foo .= PHP_EOL . PHP_EOL . Indent::_(2)
					. '$footable = "jQuery(document).ready(function() { jQuery(function () { jQuery('
					. "'.footable'" . ').footable();});});";';
				$foo .= PHP_EOL . Indent::_(2)
					. "\$this->getDocument()->addScriptDeclaration(\$footable);"
					. PHP_EOL;
			}
		}

		return $foo;
	}

	/**
	 * set the list body of the linked admin view
	 *
	 * @param   string  $nameSingleCode
	 * @param   string  $nameListCode
	 * @param   string  $refview
	 *
	 * @return string
	 */
	public function setListBodyLinked($nameSingleCode, $nameListCode, $refview)
	{
		if (($items = CFactory::_('Compiler.Builder.Lists')->get($nameListCode)) !== null)
		{
			// component helper name
			$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
			$footable_version = CFactory::_('Config')->get('footable_version', 2);
			// make sure the custom links are only added once
			$firstTimeBeingAdded = true;
			$counter = 0;
			// add the default
			$body = PHP_EOL . "<tbody>";
			$body .= PHP_EOL . "<?php foreach (\$items as \$i => \$item): ?>";
			$body .= PHP_EOL . Indent::_(1) . "<?php";
			$body .= PHP_EOL . Indent::_(2)
				. "\$canCheckin = \$user->authorise('core.manage', 'com_checkin') || \$item->checked_out == \$user->id || \$item->checked_out == 0;";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$body .= PHP_EOL . Indent::_(2)
					. "\$userChkOut = Factory::getUser(\$item->checked_out);";
			}
			else
			{
				$body .= PHP_EOL . Indent::_(2)
					. "\$userChkOut = Factory::getContainer()->";
				$body .= PHP_EOL . Indent::_(3)
					. "get(\Joomla\CMS\User\UserFactoryInterface::class)->";
				$body .= PHP_EOL . Indent::_(4)
					. "loadUserById(\$item->checked_out);";
			}
			$body .= PHP_EOL . Indent::_(2) . "\$canDo = " . $Helper
				. "::getActions('" . $nameSingleCode . "',\$item,'"
				. $nameListCode . "');";
			$body .= PHP_EOL . Indent::_(1) . "?>";
			$body .= PHP_EOL . Indent::_(1) . '<tr>';
			// check if this view has fields that should not be escaped
			$doNotEscape = false;
			if (CFactory::_('Compiler.Builder.Do.Not.Escape')->exists($nameListCode))
			{
				$doNotEscape = true;
			}
			// start adding the dynamic
			foreach ($items as $item)
			{
				// check if target is linked list view
				if (1 == $item['target'] || 4 == $item['target'])
				{
					// set the ref
					$ref = '<?php echo $ref; ?>';
					// set some defaults
					$customAdminViewButtons = '';
					// set the item row
					$itemRow = $this->getListItemBuilder(
						$item, $nameSingleCode, $nameListCode, $itemClass,
						$doNotEscape, false, $ref,
						'$displayData->escape', '$user', $refview
					);
					// check if buttons was aready added
					if ($firstTimeBeingAdded) // TODO we must improve this to allow more items to be targeted instead of just the first item :)
					{
						// get custom admin view buttons
						$customAdminViewButtons
							= $this->getCustomAdminViewButtons(
							$nameListCode, $ref
						);
						// make sure the custom admin view buttons are only added once
						$firstTimeBeingAdded = false;
					}
					// add row to body
					$body .= PHP_EOL . Indent::_(2) . "<td>";
					$body .= $itemRow;
					$body .= $customAdminViewButtons;
					$body .= PHP_EOL . Indent::_(2) . "</td>";
					// increment counter
					$counter++;
				}
			}
			$data_value = (3 == $footable_version) ? 'data-sort-value'
				: 'data-value';

			// add the defaults
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
			{
				$counter++;
				// add the defaults
				$body .= PHP_EOL . Indent::_(2)
					. "<?php if (\$item->published == 1): ?>";
				$body .= PHP_EOL . Indent::_(3) . '<td class="center"  '
					. $data_value . '="1">';
				$body .= PHP_EOL . Indent::_(4)
					. '<span class="status-metro status-published" title="<?php echo Text:'
					. ':_(' . "'" . CFactory::_('Config')->lang_prefix . "_PUBLISHED'"
					. ');  ?>">';
				$body .= PHP_EOL . Indent::_(5) . '<?php echo Text:' . ':_('
					. "'"
					. CFactory::_('Config')->lang_prefix . "_PUBLISHED'" . '); ?>';
				$body .= PHP_EOL . Indent::_(4) . '</span>';
				$body .= PHP_EOL . Indent::_(3) . '</td>';

				$body .= PHP_EOL . Indent::_(2)
					. "<?php elseif (\$item->published == 0): ?>";
				$body .= PHP_EOL . Indent::_(3) . '<td class="center"  '
					. $data_value . '="2">';
				$body .= PHP_EOL . Indent::_(4)
					. '<span class="status-metro status-inactive" title="<?php echo Text:'
					. ':_(' . "'" . CFactory::_('Config')->lang_prefix . "_INACTIVE'"
					. ');  ?>">';
				$body .= PHP_EOL . Indent::_(5) . '<?php echo Text:' . ':_('
					. "'"
					. CFactory::_('Config')->lang_prefix . "_INACTIVE'" . '); ?>';
				$body .= PHP_EOL . Indent::_(4) . '</span>';
				$body .= PHP_EOL . Indent::_(3) . '</td>';

				$body .= PHP_EOL . Indent::_(2)
					. "<?php elseif (\$item->published == 2): ?>";
				$body .= PHP_EOL . Indent::_(3) . '<td class="center"  '
					. $data_value . '="3">';
				$body .= PHP_EOL . Indent::_(4)
					. '<span class="status-metro status-archived" title="<?php echo Text:'
					. ':_(' . "'" . CFactory::_('Config')->lang_prefix . "_ARCHIVED'"
					. ');  ?>">';
				$body .= PHP_EOL . Indent::_(5) . '<?php echo Text:' . ':_('
					. "'"
					. CFactory::_('Config')->lang_prefix . "_ARCHIVED'" . '); ?>';
				$body .= PHP_EOL . Indent::_(4) . '</span>';
				$body .= PHP_EOL . Indent::_(3) . '</td>';

				$body .= PHP_EOL . Indent::_(2)
					. "<?php elseif (\$item->published == -2): ?>";
				$body .= PHP_EOL . Indent::_(3) . '<td class="center"  '
					. $data_value . '="4">';
				$body .= PHP_EOL . Indent::_(4)
					. '<span class="status-metro status-trashed" title="<?php echo Text:'
					. ':_(' . "'" . CFactory::_('Config')->lang_prefix . "_TRASHED'"
					. ');  ?>">';
				$body .= PHP_EOL . Indent::_(5) . '<?php echo Text:' . ':_('
					. "'"
					. CFactory::_('Config')->lang_prefix . "_TRASHED'" . '); ?>';
				$body .= PHP_EOL . Indent::_(4) . '</span>';
				$body .= PHP_EOL . Indent::_(3) . '</td>';
				$body .= PHP_EOL . Indent::_(2) . '<?php endif; ?>';
			}

			// add the defaults
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.id'))
			{
				$counter++;
				$body .= PHP_EOL . Indent::_(2)
					. '<td class="nowrap center hidden-phone">';
				$body .= PHP_EOL . Indent::_(3) . "<?php echo \$item->id; ?>";
				$body .= PHP_EOL . Indent::_(2) . "</td>";
			}
			$body .= PHP_EOL . Indent::_(1) . "</tr>";
			$body .= PHP_EOL . "<?php endforeach; ?>";
			$body .= PHP_EOL . "</tbody>";
			if (2 == $footable_version)
			{
				$body .= PHP_EOL . '<tfoot class="hide-if-no-paging">';
				$body .= PHP_EOL . Indent::_(1) . '<tr>';
				$body .= PHP_EOL . Indent::_(2) . '<td colspan="' . $counter
					. '">';
				$body .= PHP_EOL . Indent::_(3)
					. '<div class="pagination pagination-centered"></div>';
				$body .= PHP_EOL . Indent::_(2) . '</td>';
				$body .= PHP_EOL . Indent::_(1) . '</tr>';
				$body .= PHP_EOL . '</tfoot>';
			}
			$body .= PHP_EOL . '</table>';
			$body .= PHP_EOL . '<?php else: ?>';
			$body .= PHP_EOL . Indent::_(1)
				. '<div class="alert alert-no-items">';
			$body .= PHP_EOL . Indent::_(2) . '<?php echo Text:' . ':_('
				. "'JGLOBAL_NO_MATCHING_RESULTS'" . '); ?>';
			$body .= PHP_EOL . Indent::_(1) . '</div>';
			$body .= PHP_EOL . '<?php endif; ?>';

			// return the build
			return $body;
		}

		return '';
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
	 */
	public function setListHeadLinked($nameSingleCode, $nameListCode,
	                                  $addNewButon, $refview
	)
	{
		if (($items = CFactory::_('Compiler.Builder.Lists')->get($nameListCode)) !== null)
		{
			// component helper name
			$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
			$head   = '';
			$footable_version = CFactory::_('Config')->get('footable_version', 2);
			// only add new button if set
			if ($addNewButon > 0)
			{
				// set permissions.
				$accessCheck = "\$can->get('" . CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.create') . "')";
				// add a button for new
				$head = '<?php if (' . $accessCheck . '): ?>';
				// make group button if needed
				$tabB = "";
				if ($addNewButon == 2)
				{
					$head .= PHP_EOL . Indent::_(1) . '<div class="btn-group">';
					$tabB = Indent::_(1);
				}
				// add the new buttons
				if ($addNewButon == 1 || $addNewButon == 2)
				{
					$head .= PHP_EOL . $tabB . Indent::_(1)
						. '<a class="btn btn-small btn-success" href="<?php echo $new; ?>"><span class="icon-new icon-white"></span> <?php echo Text:'
						. ':_(' . "'" . CFactory::_('Config')->lang_prefix . "_NEW'"
						. '); ?></a>';
				}
				// add the close and new button
				if ($addNewButon == 2 || $addNewButon == 3)
				{
					$head .= PHP_EOL . $tabB . Indent::_(1)
						. '<a class="btn btn-small" onclick="Joomla.submitbutton(\''
						. $refview
						. '.cancel\');" href="<?php echo $close_new; ?>"><span class="icon-new"></span> <?php echo Text:'
						. ':_(' . "'" . CFactory::_('Config')->lang_prefix . "_CLOSE_NEW'"
						. '); ?></a>';
				}
				// close group button if needed
				if ($addNewButon == 2)
				{
					$head .= PHP_EOL . Indent::_(1) . '</div><br /><br />';
				}
				else
				{
					$head .= '<br /><br />';
				}
				$head .= PHP_EOL . '<?php endif; ?>' . PHP_EOL;
			}
			$head .= '<?php if (Super_' . '__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($items)): ?>';
			// set the style for V2
			$metro_blue = (2 == $footable_version) ? ' metro-blue' : '';
			// set the toggle for V3
			$toggle = (3 == $footable_version)
				? ' data-show-toggle="true" data-toggle-column="first"' : '';
			// set paging
			$paging = (2 == $footable_version)
				? ' data-page-size="20" data-filter="#filter_' . $nameListCode
				. '"'
				: ' data-sorting="true" data-paging="true" data-paging-size="20" data-filtering="true"';
			// add html fix for V3
			$htmlFix = (3 == $footable_version)
				? ' data-type="html" data-sort-use="text"' : '';
			$head    .= PHP_EOL . '<table class="footable table data '
				. $nameListCode . $metro_blue . '"' . $toggle . $paging . '>';
			$head    .= PHP_EOL . "<thead>";
			// main lang prefix
			$langView = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe($nameSingleCode, 'U');
			// set status lang
			$statusLangName = $langView . '_STATUS';
			// set id lang
			$idLangName = $langView . '_ID';
			// make sure only first link is used as togeler
			$firstLink = true;
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $statusLangName, 'Status');
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $idLangName, 'Id');
			$head .= PHP_EOL . Indent::_(1) . "<tr>";
			// set controller for data hiding options
			$controller = 1;
			// build the dynamic fields
			foreach ($items as $item)
			{
				// check if target is linked list view
				if (1 == $item['target'] || 4 == $item['target'])
				{
					// check if we have an over-ride
					if (($list_head_override = CFactory::_('Compiler.Builder.List.Head.Override')->
						get($nameListCode . '.' . (int) $item['id'])) !== null)
					{
						$item['lang'] = $list_head_override;
					}
					$setin = (2 == $footable_version)
						? ' data-hide="phone"' : ' data-breakpoints="xs sm"';
					if ($controller > 3)
					{
						$setin = (2 == $footable_version)
							? ' data-hide="phone,tablet"'
							: ' data-breakpoints="xs sm md"';
					}

					if ($controller > 6)
					{
						$setin = (2 == $footable_version)
							? ' data-hide="all"' : ' data-breakpoints="all"';
					}

					if ($item['link'] && $firstLink)
					{
						$setin     = (2 == $footable_version)
							? ' data-toggle="true"' : '';
						$firstLink = false;
					}
					$head .= PHP_EOL . Indent::_(2) . "<th" . $setin . $htmlFix
						. ">";
					$head .= PHP_EOL . Indent::_(3) . "<?php echo Text:"
						. ":_('" . $item['lang'] . "'); ?>";
					$head .= PHP_EOL . Indent::_(2) . "</th>";
					$controller++;
				}
			}
			// set some V3 attr
			$data_hide = (2 == $footable_version)
				? 'data-hide="phone,tablet"' : 'data-breakpoints="xs sm md"';
			// add the defaults
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
			{
				$head .= PHP_EOL . Indent::_(2) . '<th width="10" ' . $data_hide
					. '>';
				$head .= PHP_EOL . Indent::_(3) . "<?php echo Text:" . ":_('"
					. $statusLangName . "'); ?>";
				$head .= PHP_EOL . Indent::_(2) . "</th>";
			}

			// add the defaults
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.id'))
			{
				$data_type = (2 == $footable_version)
					? 'data-type="numeric"'
					: 'data-type="number"';
				$head      .= PHP_EOL . Indent::_(2) . '<th width="5" '
					. $data_type
					. ' ' . $data_hide . '>';
				$head      .= PHP_EOL . Indent::_(3) . "<?php echo Text:"
					. ":_('"
					. $idLangName . "'); ?>";
				$head      .= PHP_EOL . Indent::_(2) . "</th>";
			}
			$head .= PHP_EOL . Indent::_(1) . "</tr>";
			$head .= PHP_EOL . "</thead>";

			return $head;
		}

		return '';
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
	public function setListQueryLinked($nameSingleCode, $nameListCode,
		$functionName, $key, $_key, $parentKey, $parent_key, $globalKey)
	{
		// check if this view has category added
		if (CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.code"))
		{
			$categoryCodeName = CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.code");
			$addCategory      = true;
		}
		else
		{
			$addCategory = false;
		}
		$query = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$query .= PHP_EOL . Indent::_(1) . " * Method to get list data.";
		$query .= PHP_EOL . Indent::_(1) . " *";
		$query .= PHP_EOL . Indent::_(1)
			. " * @return mixed  An array of data items on success, false on failure.";
		$query .= PHP_EOL . Indent::_(1) . " */";
		$query .= PHP_EOL . Indent::_(1) . "public function get" . $functionName
			. "()";
		$query .= PHP_EOL . Indent::_(1) . "{";
		// setup the query
		$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the user object.";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$query .= PHP_EOL . Indent::_(2) . "\$user = Factory::getUser();";
		}
		else
		{
			$query .= PHP_EOL . Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";
		}
		$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Create a new query object.";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$query .= PHP_EOL . Indent::_(2) . "\$db = Factory::getDBO();";
		}
		else
		{
			$query .= PHP_EOL . Indent::_(2) . "\$db = \$this->getDatabase();";
		}
		$query .= PHP_EOL . Indent::_(2) . "\$query = \$db->getQuery(true);";
		$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Select some fields";
		$query .= PHP_EOL . Indent::_(2) . "\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " From the " . CFactory::_('Config')->component_code_name . "_"
			. $nameSingleCode
			. " table";
		$query .= PHP_EOL . Indent::_(2) . "\$query->from(\$db->quoteName('#__"
			. CFactory::_('Config')->component_code_name . "_" . $nameSingleCode . "', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a."
				. $categoryCodeName
				. "') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
		$query .= CFactory::_('Customcode.Dispenser')->get(
			'php_getlistquery', $nameSingleCode, PHP_EOL . PHP_EOL
		);
		// add the custom fields query
		$query .= $this->setCustomQuery($nameListCode, $nameSingleCode);
		if (StringHelper::check($globalKey) && $key
			&& strpos(
				(string) $key, '-R>'
			) === false
			&& strpos((string) $key, '-A>') === false
			&& strpos((string) $key, '-OR>') === false
			&& $parentKey
			&& strpos((string) $parentKey, '-R>') === false
			&& strpos((string) $parentKey, '-A>') === false
			&& strpos((string) $parentKey, '-OR>') === false)
		{
			$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Filter by " . $globalKey . " global.";
			$query .= PHP_EOL . Indent::_(2) . "\$" . $globalKey . " = \$this->"
				. $globalKey . ";";
			$query .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$" . $globalKey
				. " ))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3) . "\$query->where('a." . $key
				. " = ' . (int) \$" . $globalKey . " );";
			$query .= PHP_EOL . Indent::_(2) . "}";
			$query .= PHP_EOL . Indent::_(2) . "elseif (is_string(\$"
				. $globalKey . "))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3) . "\$query->where('a." . $key
				. " = ' . \$db->quote(\$" . $globalKey . "));";
			$query .= PHP_EOL . Indent::_(2) . "}";
			$query .= PHP_EOL . Indent::_(2) . "else";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3) . "\$query->where('a." . $key
				. " = -5');";
			$query .= PHP_EOL . Indent::_(2) . "}";
		}
		elseif (strpos((string) $parentKey, '-OR>') !== false
			|| strpos((string) $key, '-OR>') !== false)
		{
			// get both strings
			if (strpos((string) $key, '-OR>') !== false)
			{
				$ORarray = explode('-OR>', (string) $key);
			}
			else
			{
				$ORarray = array($key);
			}
			// make sure we have an array
			if (!ArrayHelper::check($globalKey))
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
					$ORquery['i'][] = "a." . $ORkey . " = ' . (int) \$"
						. $_globalKey;
					$ORquery['s'][] = "a." . $ORkey . " = ' . \$db->quote(\$"
						. $_globalKey . ")";
				}
				$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Filter by " . $_globalKey
					. " global.";
				$query .= PHP_EOL . Indent::_(2) . "\$" . $_globalKey
					. " = \$this->" . $_globalKey . ";";
				$query .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$"
					. $_globalKey . " ))";
				$query .= PHP_EOL . Indent::_(2) . "{";
				$query .= PHP_EOL . Indent::_(3) . "\$query->where('" . implode(
						" . ' OR ", $ORquery['i']
					) . ", ' OR');";
				$query .= PHP_EOL . Indent::_(2) . "}";
				$query .= PHP_EOL . Indent::_(2) . "elseif (is_string(\$"
					. $_globalKey . "))";
				$query .= PHP_EOL . Indent::_(2) . "{";
				$query .= PHP_EOL . Indent::_(3) . "\$query->where('" . implode(
						" . ' OR ", $ORquery['s']
					) . ", ' OR');";
				$query .= PHP_EOL . Indent::_(2) . "}";
				$query .= PHP_EOL . Indent::_(2) . "else";
				$query .= PHP_EOL . Indent::_(2) . "{";
				$query .= PHP_EOL . Indent::_(3) . "\$query->where('a." . $ORkey
					. " = -5');";
				$query .= PHP_EOL . Indent::_(2) . "}";
			}
		}
		if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode))
		{
			$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Join over the asset groups.";
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->select('ag.title AS access_level');";
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			// check if the access field was over ridden
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
			{
				// component helper name
				$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
				// load the access filter query code
				$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					)
					. " Filter by access level.";
				$query .= PHP_EOL . Indent::_(2)
					. "\$_access = \$this->getState('filter.access');";
				$query .= PHP_EOL . Indent::_(2)
					. "if (\$_access && is_numeric(\$_access))";
				$query .= PHP_EOL . Indent::_(2) . "{";
				$query .= PHP_EOL . Indent::_(3)
					. "\$query->where('a.access = ' . (int) \$_access);";
				$query .= PHP_EOL . Indent::_(2) . "}";
				$query .= PHP_EOL . Indent::_(2) . "elseif ("
					. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$_access))";
				$query .= PHP_EOL . Indent::_(2) . "{";
				$query .= PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__)
					. " Secure the array for the query";
				$query .= PHP_EOL . Indent::_(3)
					. "\$_access = ArrayHelper::toInteger(\$_access);";
				$query .= PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Filter by the Access Array.";
				$query .= PHP_EOL . Indent::_(3)
					. "\$query->where('a.access IN (' . implode(',', \$_access) . ')');";
				$query .= PHP_EOL . Indent::_(2) . "}";
			}
			// TODO the following will fight against the above access filter
			$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Implement View Level Access";
			$query .= PHP_EOL . Indent::_(2)
				. "if (!\$user->authorise('core.options', 'com_"
				. CFactory::_('Config')->component_code_name . "'))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3)
				. "\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= PHP_EOL . Indent::_(3)
				. "\$query->where('a.access IN (' . \$groups . ')');";
			$query .= PHP_EOL . Indent::_(2) . "}";
		}
		// add dynamic ordering (Linked view)
		if (CFactory::_('Compiler.Builder.Views.Default.Ordering')->
			get("$nameListCode.add_linked_ordering", 0) == 1)
		{
			foreach (CFactory::_('Compiler.Builder.Views.Default.Ordering')->
				get("$nameListCode.linked_ordering_fields", []) as $order_field)
			{
				if (($order_field_name = CFactory::_('Field.Database.Name')->get(
						$nameListCode, $order_field['field']
					// We Removed This 'listJoinBuilder' as targetArea
					// we will keep an eye on this
					)) !== false)
				{
					// default ordering is by publish and ordering
					$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(
							__LINE__,__CLASS__
						) . " Order the results by ordering";
					$query .= PHP_EOL . Indent::_(2)
						. "\$query->order('"
						. $order_field_name . " " . $order_field['direction']
						. "');";
				}
			}
		}
		else
		{
			// default ordering is by publish and ordering
			$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Order the results by ordering";
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->order('a.published  ASC');";
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->order('a.ordering  ASC');";
		}
		$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Load the items";
		$query .= PHP_EOL . Indent::_(2) . "\$db->setQuery(\$query);";
		$query .= PHP_EOL . Indent::_(2) . "\$db->execute();";
		$query .= PHP_EOL . Indent::_(2) . "if (\$db->getNumRows())";
		$query .= PHP_EOL . Indent::_(2) . "{";
		$query .= PHP_EOL . Indent::_(3) . "\$items = \$db->loadObjectList();";
		// add the fixing strings method
		$query .= $this->setGetItemsMethodStringFix(
			$nameSingleCode, $nameListCode,
			CFactory::_('Compiler.Builder.Content.One')->get('Component'),
			Indent::_(1)
		);
		// add translations
		$query .= $this->setSelectionTranslationFix(
			$nameListCode,
			CFactory::_('Compiler.Builder.Content.One')->get('Component'),
			Indent::_(1)
		);
		// filter by child repetable field values
		if (StringHelper::check($globalKey) && $key
			&& strpos(
				(string) $key, '-R>'
			) !== false
			&& strpos((string) $key, '-A>') === false)
		{
			list($field, $target) = explode('-R>', (string) $key);
			$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Filter by " . $globalKey . " in this Repetable Field";
			$query .= PHP_EOL . Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items) && isset(\$this->"
				. $globalKey . "))";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . Indent::_(4) . "{";
			$query .= PHP_EOL . Indent::_(5) . "if (isset(\$item->" . $field
				. ") && Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check(\$item->" . $field . "))";
			$query .= PHP_EOL . Indent::_(5) . "{";
			$query .= PHP_EOL . Indent::_(6)
				. "\$tmpArray = json_decode(\$item->" . $field . ",true);";
			$query .= PHP_EOL . Indent::_(6) . "if (!isset(\$tmpArray['"
				. $target . "']) || !Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$tmpArray['"
				. $target . "']) || !in_array(\$this->" . $globalKey
				. ", \$tmpArray['" . $target . "']))";
			$query .= PHP_EOL . Indent::_(6) . "{";
			$query .= PHP_EOL . Indent::_(7) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . Indent::_(7) . "continue;";
			$query .= PHP_EOL . Indent::_(6) . "}";
			$query .= PHP_EOL . Indent::_(5) . "}";
			$query .= PHP_EOL . Indent::_(5) . "else";
			$query .= PHP_EOL . Indent::_(5) . "{";
			$query .= PHP_EOL . Indent::_(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . Indent::_(6) . "continue;";
			$query .= PHP_EOL . Indent::_(5) . "}";
			$query .= PHP_EOL . Indent::_(4) . "}";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(3) . "else";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4) . "return false;";
			$query .= PHP_EOL . Indent::_(3) . "}";
		}
		// filter by child array field values
		if (StringHelper::check($globalKey) && $key
			&& strpos(
				(string) $key, '-R>'
			) === false
			&& strpos((string) $key, '-A>') !== false)
		{
			$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Filter by " . $globalKey . " Array Field";
			$query .= PHP_EOL . Indent::_(3) . "\$" . $globalKey . " = \$this->"
				. $globalKey . ";";
			$query .= PHP_EOL . Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items) && \$" . $globalKey
				. ")";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . Indent::_(4) . "{";
			list($bin, $target) = explode('-A>', (string) $key);
			if (StringHelper::check($target))
			{
				$query .= PHP_EOL . Indent::_(5) . "if (isset(\$item->" . $target
					. ") && Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check(\$item->" . $target . "))";
				$query .= PHP_EOL . Indent::_(5) . "{";
				$query .= PHP_EOL . Indent::_(6) . "\$item->" . $target
					. " = json_decode(\$item->" . $target . ", true);";
				$query .= PHP_EOL . Indent::_(5) . "}";
				$query .= PHP_EOL . Indent::_(5) . "elseif (!isset(\$item->"
					. $target . ") || !Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$item->"
					. $target . "))";
				$query .= PHP_EOL . Indent::_(5) . "{";
				$query .= PHP_EOL . Indent::_(6) . "unset(\$items[\$nr]);";
				$query .= PHP_EOL . Indent::_(6) . "continue;";
				$query .= PHP_EOL . Indent::_(5) . "}";
				$query .= PHP_EOL . Indent::_(5) . "if (!in_array(\$"
					. $globalKey . ",\$item->" . $target . "))";
			}
			else
			{
				$query .= PHP_EOL . Indent::_(5) . "if (isset(\$item->" . $_key . ") && "
					. "Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check(\$item->" . $_key . "))";
				$query .= PHP_EOL . Indent::_(5) . "{";
				$query .= PHP_EOL . Indent::_(6) . "\$item->" . $_key
					. " = json_decode(\$item->" . $_key . ", true);";
				$query .= PHP_EOL . Indent::_(5) . "}";
				$query .= PHP_EOL . Indent::_(5) . "elseif (!isset(\$item->"
					. $_key . ") || !Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$item->"
					. $_key . "))";
				$query .= PHP_EOL . Indent::_(5) . "{";
				$query .= PHP_EOL . Indent::_(6) . "unset(\$items[\$nr]);";
				$query .= PHP_EOL . Indent::_(6) . "continue;";
				$query .= PHP_EOL . Indent::_(5) . "}";
				$query .= PHP_EOL . Indent::_(5) . "if (!in_array(\$"
					. $globalKey . ",\$item->" . $_key . "))";
			}
			$query .= PHP_EOL . Indent::_(5) . "{";
			$query .= PHP_EOL . Indent::_(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . Indent::_(6) . "continue;";
			$query .= PHP_EOL . Indent::_(5) . "}";
			$query .= PHP_EOL . Indent::_(4) . "}";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(3) . "else";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4) . "return false;";
			$query .= PHP_EOL . Indent::_(3) . "}";
		}
		// filter by parent repetable field values
		if (StringHelper::check($globalKey) && $key
			&& strpos(
				(string) $parentKey, '-R>'
			) !== false
			&& strpos((string) $parentKey, '-A>') === false)
		{
			list($bin, $target) = explode('-R>', (string) $parentKey);
			$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Filter by " . $_key . " Repetable Field";
			$query .= PHP_EOL . Indent::_(3) . "\$" . $globalKey
				. " = json_decode(\$this->" . $globalKey . ",true);";
			$query .= PHP_EOL . Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items) && isset(\$"
				. $globalKey . ") && Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
				. $globalKey . "))";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . Indent::_(4) . "{";
			$query .= PHP_EOL . Indent::_(5) . "if (\$item->" . $_key
				. " && isset(\$" . $globalKey . "['" . $target . "']) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$" . $globalKey . "['"
				. $target . "']))";
			$query .= PHP_EOL . Indent::_(5) . "{";
			$query .= PHP_EOL . Indent::_(6) . "if (!in_array(\$item->" . $_key
				. ",\$" . $globalKey . "['" . $target . "']))";
			$query .= PHP_EOL . Indent::_(6) . "{";
			$query .= PHP_EOL . Indent::_(7) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . Indent::_(7) . "continue;";
			$query .= PHP_EOL . Indent::_(6) . "}";
			$query .= PHP_EOL . Indent::_(5) . "}";
			$query .= PHP_EOL . Indent::_(5) . "else";
			$query .= PHP_EOL . Indent::_(5) . "{";
			$query .= PHP_EOL . Indent::_(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . Indent::_(6) . "continue;";
			$query .= PHP_EOL . Indent::_(5) . "}";
			$query .= PHP_EOL . Indent::_(4) . "}";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(3) . "else";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4) . "return false;";
			$query .= PHP_EOL . Indent::_(3) . "}";
		}
		// filter by parent array field values
		if (StringHelper::check($globalKey) && $key
			&& strpos(
				(string) $parentKey, '-R>'
			) === false
			&& strpos((string) $parentKey, '-A>') !== false)
		{
			$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Filter by " . $globalKey . " Array Field";
			$query .= PHP_EOL . Indent::_(3) . "\$" . $globalKey . " = \$this->"
				. $globalKey . ";";
			$query .= PHP_EOL . Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$" . $globalKey . "))";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "foreach (\$items as \$nr => &\$item)";
			$query .= PHP_EOL . Indent::_(4) . "{";
			list($bin, $target) = explode('-A>', (string) $parentKey);
			if (StringHelper::check($target))
			{
				$query .= PHP_EOL . Indent::_(5) . "if (\$item->" . $_key
					. " && Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$" . $globalKey . "['"
					. $target . "']))";
				$query .= PHP_EOL . Indent::_(5) . "{";
				$query .= PHP_EOL . Indent::_(6) . "if (!in_array(\$item->"
					. $_key . ",\$" . $globalKey . "['" . $target . "']))";
			}
			else
			{
				$query .= PHP_EOL . Indent::_(5) . "if (\$item->" . $_key . ")";
				$query .= PHP_EOL . Indent::_(5) . "{";
				$query .= PHP_EOL . Indent::_(6) . "if (!in_array(\$item->"
					. $_key . ",\$" . $globalKey . "))";
			}
			$query .= PHP_EOL . Indent::_(6) . "{";
			$query .= PHP_EOL . Indent::_(7) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . Indent::_(7) . "continue;";
			$query .= PHP_EOL . Indent::_(6) . "}";
			$query .= PHP_EOL . Indent::_(5) . "}";
			$query .= PHP_EOL . Indent::_(5) . "else";
			$query .= PHP_EOL . Indent::_(5) . "{";
			$query .= PHP_EOL . Indent::_(6) . "unset(\$items[\$nr]);";
			$query .= PHP_EOL . Indent::_(6) . "continue;";
			$query .= PHP_EOL . Indent::_(5) . "}";
			$query .= PHP_EOL . Indent::_(4) . "}";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(3) . "else";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4) . "return false;";
			$query .= PHP_EOL . Indent::_(3) . "}";
		}
		// add custom php to getitems method after all
		$query .= CFactory::_('Customcode.Dispenser')->get(
			'php_getitems_after_all', $nameSingleCode,
			PHP_EOL . PHP_EOL . Indent::_(1)
		);

		$query .= PHP_EOL . Indent::_(3) . "return \$items;";
		$query .= PHP_EOL . Indent::_(2) . "}";
		$query .= PHP_EOL . Indent::_(2) . "return false;";
		$query .= PHP_EOL . Indent::_(1) . "}";
		// SELECTIONTRANSLATIONFIXFUNC<<<DYNAMIC>>>
		$query .= $this->setSelectionTranslationFixFunc(
			$nameListCode,
			CFactory::_('Compiler.Builder.Content.One')->get('Component')
		);

		// fixe mothod name clash
		$query = str_replace(
			'selectionTranslation(',
			'selectionTranslation' . $functionName . '(', $query
		);

		return $query;
	}

	/**
	 * @param $nameListCode
	 *
	 * @return array|string
	 */
	public function setCustomAdminDynamicButton($nameListCode)
	{
		$buttons = '';
		if (isset($this->customAdminDynamicButtons[$nameListCode])
			&& ArrayHelper::check(
				$this->customAdminDynamicButtons[$nameListCode]
			))
		{
			$buttons = [];
			foreach (
				$this->customAdminDynamicButtons[$nameListCode] as
				$custom_button
			)
			{
				// Load to lang
				$keyLang = CFactory::_('Config')->lang_prefix . '_' . $custom_button['NAME'];
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $keyLang, StringHelper::safe(
					$custom_button['name'], 'Ww'
				)
				);
				// add cpanel button
				$buttons[] = Indent::_(2) . "if (\$this->canDo->get('"
					. $custom_button['link'] . ".access'))";
				$buttons[] = Indent::_(2) . "{";
				$buttons[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " add " . $custom_button['name'] . " button.";
				$buttons[] = Indent::_(3) . "ToolbarHelper::custom('"
					. $nameListCode . ".redirectTo"
					. StringHelper::safe(
						$custom_button['link'], 'F'
					) . "', '" . $custom_button['icon'] . "', '', '" . $keyLang
					. "', true);";
				$buttons[] = Indent::_(2) . "}";
			}
			if (ArrayHelper::check($buttons))
			{
				return implode(PHP_EOL, $buttons);
			}
		}

		return $buttons;
	}

	/**
	 * @param $nameListCode
	 *
	 * @return array|string
	 */
	public function setCustomAdminDynamicButtonController($nameListCode)
	{
		$method = '';
		if (isset($this->customAdminDynamicButtons[$nameListCode])
			&& ArrayHelper::check(
				$this->customAdminDynamicButtons[$nameListCode]
			))
		{
			$method = [];
			foreach (
				$this->customAdminDynamicButtons[$nameListCode] as
				$custom_button
			)
			{
				// add the custom redirect method
				$method[] = PHP_EOL . PHP_EOL . Indent::_(1)
					. "public function redirectTo"
					. StringHelper::safe(
						$custom_button['link'], 'F'
					) . "()";
				$method[] = Indent::_(1) . "{";
				$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Check for request forgeries";
				$method[] = Indent::_(2)
					. "Session::checkToken() or die(Text:"
					. ":_('JINVALID_TOKEN'));";
				$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " check if export is allowed for this user.";
				if (CFactory::_('Config')->get('joomla_version', 3) == 3)
				{
					$method[] = Indent::_(2) . "\$user = Factory::getUser();";
				}
				else
				{
					$method[] = Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";
				}
				$method[] = Indent::_(2) . "if (\$user->authorise('"
					. $custom_button['link'] . ".access', 'com_"
					. CFactory::_('Config')->component_code_name . "'))";
				$method[] = Indent::_(2) . "{";
				$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Get the input";
				$method[] = Indent::_(3)
					. "\$input = Factory::getApplication()->input;";
				$method[] = Indent::_(3)
					. "\$pks = \$input->post->get('cid', array(), 'array');";
				$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Sanitize the input";
				$method[] = Indent::_(3)
					. "\$pks = ArrayHelper::toInteger(\$pks);";
				$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " convert to string";
				$method[] = Indent::_(3) . "\$ids = implode('_', \$pks);";
				$method[] = Indent::_(3)
					. "\$this->setRedirect(Route::_('index.php?option=com_"
					. CFactory::_('Config')->component_code_name . "&view="
					. $custom_button['link'] . "&cid='.\$ids, false));";
				$method[] = Indent::_(3) . "return;";
				$method[] = Indent::_(2) . "}";
				$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
					. " Redirect to the list screen with error.";
				$method[] = Indent::_(2) . "\$message = Text:" . ":_('"
					. CFactory::_('Config')->lang_prefix . "_ACCESS_TO_" . $custom_button['NAME']
					. "_FAILED');";
				$method[] = Indent::_(2)
					. "\$this->setRedirect(Route::_('index.php?option=com_"
					. CFactory::_('Config')->component_code_name . "&view=" . $nameListCode
					. "', false), \$message, 'error');";
				$method[] = Indent::_(2) . "return;";
				$method[] = Indent::_(1) . "}";
				// add to lang array
				$lankey = CFactory::_('Config')->lang_prefix . "_ACCESS_TO_"
					. $custom_button['NAME'] . "_FAILED";
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lankey,
					'Access to ' . $custom_button['link'] . ' was denied.'
				);
			}

			return implode(PHP_EOL, $method);
		}

		return $method;
	}

	/**
	 * A function that builds get Items Method for model
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 * @param   array   $config          The config details to adapt the method being build
	 *
	 * @return string
	 */
	public function setGetItemsModelMethod(&$nameSingleCode, &$nameListCode,
	                                       $config
	                                       = array('functionName' => 'getExportData',
		                                       'docDesc'      => 'Method to get list export data.',
		                                       'type'         => 'export')
	)
	{
		// start the query string
		$query = '';
		// check if this is the export method
		$isExport = ('export' === $config['type']);
		// check if this view has export feature, and or if this is not an export method
		if ((isset($this->eximportView[$nameListCode])
				&& $this->eximportView[$nameListCode])
			|| !$isExport)
		{
			$query = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$query .= PHP_EOL . Indent::_(1) . " * " . $config['docDesc'];
			$query .= PHP_EOL . Indent::_(1) . " *";
			$query .= PHP_EOL . Indent::_(1)
				. " * @param   array  \$pks  The ids of the items to get";
			$query .= PHP_EOL . Indent::_(1)
				. " * @param   JUser  \$user  The user making the request";
			$query .= PHP_EOL . Indent::_(1) . " *";
			$query .= PHP_EOL . Indent::_(1)
				. " * @return mixed  An array of data items on success, false on failure.";
			$query .= PHP_EOL . Indent::_(1) . " */";
			$query .= PHP_EOL . Indent::_(1) . "public function "
				. $config['functionName'] . "(\$pks, \$user = null)";
			$query .= PHP_EOL . Indent::_(1) . "{";
			$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " setup the query";
			$query .= PHP_EOL . Indent::_(2) . "if ((\$pks_size = "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$pks)) !== false || 'bulk' === \$pks)";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Set a value to know this is " . $config['type']
				. " method. (USE IN CUSTOM CODE TO ALTER OUTCOME)";
			$query .= PHP_EOL . Indent::_(3) . "\$_" . $config['type']
				. " = true;";
			$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Get the user object if not set.";
			$query .= PHP_EOL . Indent::_(3) . "if (!isset(\$user) || !"
				. "Super_" . "__91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(\$user))";
			$query .= PHP_EOL . Indent::_(3) . "{";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$query .= PHP_EOL . Indent::_(4) . "\$user = Factory::getUser();";
			}
			else
			{
				$query .= PHP_EOL . Indent::_(4) . "\$user = \$this->getCurrentUser();";
			}
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Create a new query object.";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$query .= PHP_EOL . Indent::_(3) . "\$db = Factory::getDBO();";
			}
			else
			{
				$query .= PHP_EOL . Indent::_(3) . "\$db = \$this->getDatabase();";
			}
			$query .= PHP_EOL . Indent::_(3)
				. "\$query = \$db->getQuery(true);";
			$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Select some fields";
			$query .= PHP_EOL . Indent::_(3) . "\$query->select('a.*');";
			$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " From the " . CFactory::_('Config')->component_code_name . "_"
				. $nameSingleCode . " table";
			$query .= PHP_EOL . Indent::_(3)
				. "\$query->from(\$db->quoteName('#__"
				. CFactory::_('Config')->component_code_name . "_" . $nameSingleCode
				. "', 'a'));";
			$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " The bulk export path";
			$query .= PHP_EOL . Indent::_(3) . "if ('bulk' === \$pks)";
			$query .= PHP_EOL . Indent::_(3)
				. "{";
			$query .= PHP_EOL . Indent::_(4)
				. "\$query->where('a.id > 0');";
			$query .= PHP_EOL . Indent::_(3)
				. "}";
			$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " A large array of ID's will not work out well";
			$query .= PHP_EOL . Indent::_(3) . "elseif (\$pks_size > 500)";
			$query .= PHP_EOL . Indent::_(3)
				. "{";
			$query .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Use lowest ID";
			$query .= PHP_EOL . Indent::_(4)
				. "\$query->where('a.id >= ' . (int) min(\$pks));";
			$query .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Use highest ID";
			$query .= PHP_EOL . Indent::_(4)
				. "\$query->where('a.id <= ' . (int) max(\$pks));";
			$query .= PHP_EOL . Indent::_(3)
				. "}";
			$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " The normal default path";
			$query .= PHP_EOL . Indent::_(3) . "else";
			$query .= PHP_EOL . Indent::_(3)
				. "{";
			$query .= PHP_EOL . Indent::_(4)
				. "\$query->where('a.id IN (' . implode(',',\$pks) . ')');";
			$query .= PHP_EOL . Indent::_(3)
				. "}";
			// add custom filtering php
			$query .= CFactory::_('Customcode.Dispenser')->get(
				'php_getlistquery', $nameSingleCode,
				PHP_EOL . PHP_EOL . Indent::_(1)
			);
			// first check if we export of text only is avalable
			if (CFactory::_('Config')->get('export_text_only', 0))
			{
				// add switch
				$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Get global switch to activate text only export";
				$query .= PHP_EOL . Indent::_(3)
					. "\$export_text_only = ComponentHelper::getParams('com_"
					. CFactory::_('Config')->component_code_name
					. "')->get('export_text_only', 0);";
				// first check if we have custom queries
				$custom_query = $this->setCustomQuery(
					$nameListCode, $nameSingleCode, Indent::_(2), true
				);
			}
			// if values were returned add the area
			if (isset($custom_query)
				&& StringHelper::check(
					$custom_query
				))
			{
				$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Add these queries only if text only is required";
				$query .= PHP_EOL . Indent::_(3) . "if (\$export_text_only)";
				$query .= PHP_EOL . Indent::_(3) . "{";
				// add the custom fields query
				$query .= $custom_query;
				$query .= PHP_EOL . Indent::_(3) . "}";
			}
			// add access levels if the view has access set
			if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode))
			{
				$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Implement View Level Access";
				$query .= PHP_EOL . Indent::_(3)
					. "if (!\$user->authorise('core.options', 'com_"
					. CFactory::_('Config')->component_code_name . "'))";
				$query .= PHP_EOL . Indent::_(3) . "{";
				$query .= PHP_EOL . Indent::_(4)
					. "\$groups = implode(',', \$user->getAuthorisedViewLevels());";
				$query .= PHP_EOL . Indent::_(4)
					. "\$query->where('a.access IN (' . \$groups . ')');";
				$query .= PHP_EOL . Indent::_(3) . "}";
			}
			// add dynamic ordering (Exported data)
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
						$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
							. Line::_(
								__LINE__,__CLASS__
							) . " Order the results by ordering";
						$query .= PHP_EOL . Indent::_(3)
							. "\$query->order('"
							. $order_field_name . " "
							. $order_field['direction'] . "');";
					}
				}
			}
			else
			{
				$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
					. Line::_(
						__LINE__,__CLASS__
					) . " Order the results by ordering";
				$query .= PHP_EOL . Indent::_(3)
					. "\$query->order('a.ordering  ASC');";
			}
			$query .= PHP_EOL . PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Load the items";
			$query .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
			$query .= PHP_EOL . Indent::_(3) . "\$db->execute();";
			$query .= PHP_EOL . Indent::_(3) . "if (\$db->getNumRows())";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "\$items = \$db->loadObjectList();";
			// set the string fixing code
			$query .= $this->setGetItemsMethodStringFix(
				$nameSingleCode, $nameListCode,
				CFactory::_('Compiler.Builder.Content.One')->get('Component'),
				Indent::_(2), $isExport, true
			);
			// first check if we export of text only is avalable
			if (CFactory::_('Config')->get('export_text_only', 0))
			{
				$query_translations = $this->setSelectionTranslationFix(
					$nameListCode,
					CFactory::_('Compiler.Builder.Content.One')->get('Component'), Indent::_(3)
				);
			}
			// add translations
			if (isset($query_translations)
				&& StringHelper::check($query_translations))
			{
				$query .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Add these translation only if text only is required";
				$query .= PHP_EOL . Indent::_(3) . "if (\$export_text_only)";
				$query .= PHP_EOL . Indent::_(3) . "{";
				$query .= $query_translations;
				$query .= PHP_EOL . Indent::_(3) . "}";
			}
			// add custom php to getItems method after all
			$query .= CFactory::_('Customcode.Dispenser')->get(
				'php_getitems_after_all', $nameSingleCode,
				PHP_EOL . PHP_EOL . Indent::_(2)
			);
			// in privacy export we must return array of arrays
			if ('privacy' === $config['type'])
			{
				$query .= PHP_EOL . Indent::_(4)
					. "return json_decode(json_encode(\$items), true);";
			}
			else
			{
				$query .= PHP_EOL . Indent::_(4) . "return \$items;";
			}
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(2) . "}";
			$query .= PHP_EOL . Indent::_(2) . "return false;";
			$query .= PHP_EOL . Indent::_(1) . "}";
			// get the header script
			if ($isExport)
			{
				$header = \ComponentbuilderHelper::getDynamicScripts('headers');

				// add getExImPortHeaders
				$query .= CFactory::_('Customcode.Dispenser')->get(
					'php_import_headers', 'import_' . $nameListCode,
					PHP_EOL . PHP_EOL, null, true,
					// set a default script for those with no custom script
					PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
						$header
					)
				);
			}
		}

		return $query;
	}

	public function setControllerEximportMethod($nameSingleCode,
	                                            $nameListCode
	)
	{
		$method = '';
		if (isset($this->eximportView[$nameListCode])
			&& $this->eximportView[$nameListCode])
		{
			$method = [];

			// add the export method
			$method[] = PHP_EOL . PHP_EOL . Indent::_(1)
				. "public function exportData()";
			$method[] = Indent::_(1) . "{";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Check for request forgeries";
			$method[] = Indent::_(2) . "Session::checkToken() or die(Text:"
				. ":_('JINVALID_TOKEN'));";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if export is allowed for this user.";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$method[] = Indent::_(2) . "\$user = Factory::getUser();";
			}
			else
			{
				$method[] = Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";
			}
			$method[] = Indent::_(2) . "if (\$user->authorise('"
				. $nameSingleCode . ".export', 'com_"
				. CFactory::_('Config')->component_code_name
				. "') && \$user->authorise('core.export', 'com_"
				. CFactory::_('Config')->component_code_name . "'))";
			$method[] = Indent::_(2) . "{";
			$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Get the input";
			$method[] = Indent::_(3)
				. "\$input = Factory::getApplication()->input;";
			$method[] = Indent::_(3)
				. "\$pks = \$input->post->get('cid', array(), 'array');";
			$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Sanitize the input";
			$method[] = Indent::_(3) . "\$pks = ArrayHelper::toInteger(\$pks);";
			$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Get the model";
			$method[] = Indent::_(3) . "\$model = \$this->getModel('"
				. StringHelper::safe($nameListCode, 'F')
				. "');";
			$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " get the data to export";
			$method[] = Indent::_(3)
				. "\$data = \$model->getExportData(\$pks);";
			$method[] = Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$data))";
			$method[] = Indent::_(3) . "{";
			$method[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " now set the data to the spreadsheet";
			$method[] = Indent::_(4) . "\$date = Factory::getDate();";
			$method[] = Indent::_(4) . CFactory::_('Compiler.Builder.Content.One')->get('Component') . "Helper::xls(\$data,'"
				. StringHelper::safe($nameListCode, 'F')
				. "_'.\$date->format('jS_F_Y'),'"
				. StringHelper::safe($nameListCode, 'Ww')
				. " exported ('.\$date->format('jS F, Y').')','"
				. StringHelper::safe($nameListCode, 'w')
				. "');";
			$method[] = Indent::_(3) . "}";
			$method[] = Indent::_(2) . "}";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Redirect to the list screen with error.";
			$method[] = Indent::_(2) . "\$message = Text:" . ":_('"
				. CFactory::_('Config')->lang_prefix . "_EXPORT_FAILED');";
			$method[] = Indent::_(2)
				. "\$this->setRedirect(Route::_('index.php?option=com_"
				. CFactory::_('Config')->component_code_name . "&view=" . $nameListCode
				. "', false), \$message, 'error');";
			$method[] = Indent::_(2) . "return;";
			$method[] = Indent::_(1) . "}";

			// add the import method
			$method[] = PHP_EOL . PHP_EOL . Indent::_(1)
				. "public function importData()";
			$method[] = Indent::_(1) . "{";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Check for request forgeries";
			$method[] = Indent::_(2) . "Session::checkToken() or die(Text:"
				. ":_('JINVALID_TOKEN'));";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if import is allowed for this user.";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$method[] = Indent::_(2) . "\$user = Factory::getUser();";
			}
			else
			{
				$method[] = Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";
			}
			$method[] = Indent::_(2) . "if (\$user->authorise('"
				. $nameSingleCode . ".import', 'com_"
				. CFactory::_('Config')->component_code_name
				. "') && \$user->authorise('core.import', 'com_"
				. CFactory::_('Config')->component_code_name . "'))";
			$method[] = Indent::_(2) . "{";
			$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Get the import model";
			$method[] = Indent::_(3) . "\$model = \$this->getModel('"
				. StringHelper::safe($nameListCode, 'F')
				. "');";
			$method[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " get the headers to import";
			$method[] = Indent::_(3)
				. "\$headers = \$model->getExImPortHeaders();";
			$method[] = Indent::_(3) . "if ("
				. "Super_" . "__91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(\$headers))";
			$method[] = Indent::_(3) . "{";
			$method[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Load headers to session.";
			$method[] = Indent::_(4) . "\$session = Factory::getSession();";
			$method[] = Indent::_(4) . "\$headers = json_encode(\$headers);";
			$method[] = Indent::_(4) . "\$session->set('" . $nameSingleCode
				. "_VDM_IMPORTHEADERS', \$headers);";
			$method[] = Indent::_(4) . "\$session->set('backto_VDM_IMPORT', '"
				. $nameListCode . "');";
			$method[] = Indent::_(4)
				. "\$session->set('dataType_VDM_IMPORTINTO', '"
				. $nameSingleCode . "');";
			$method[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Redirect to import view.";
			// add to lang array
			$selectImportFileNote = CFactory::_('Config')->lang_prefix
				. "_IMPORT_SELECT_FILE_FOR_"
				. StringHelper::safe($nameListCode, 'U');
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $selectImportFileNote,
				'Select the file to import data to ' . $nameListCode . '.'
			);
			$method[] = Indent::_(4) . "\$message = Text:" . ":_('"
				. $selectImportFileNote . "');";
			// if this view has custom script it must have as custom import (model, veiw, controller)
			if (isset($this->importCustomScripts[$nameListCode])
				&& $this->importCustomScripts[$nameListCode])
			{
				$method[] = Indent::_(4)
					. "\$this->setRedirect(Route::_('index.php?option=com_"
					. CFactory::_('Config')->component_code_name . "&view=import_"
					. $nameListCode . "', false), \$message);";
			}
			else
			{
				$method[] = Indent::_(4)
					. "\$this->setRedirect(Route::_('index.php?option=com_"
					. CFactory::_('Config')->component_code_name
					. "&view=import', false), \$message);";
			}
			$method[] = Indent::_(4) . "return;";
			$method[] = Indent::_(3) . "}";
			$method[] = Indent::_(2) . "}";
			$method[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Redirect to the list screen with error.";
			$method[] = Indent::_(2) . "\$message = Text:" . ":_('"
				. CFactory::_('Config')->lang_prefix . "_IMPORT_FAILED');";
			$method[] = Indent::_(2)
				. "\$this->setRedirect(Route::_('index.php?option=com_"
				. CFactory::_('Config')->component_code_name . "&view=" . $nameListCode
				. "', false), \$message, 'error');";
			$method[] = Indent::_(2) . "return;";
			$method[] = Indent::_(1) . "}";

			return implode(PHP_EOL, $method);
		}

		return $method;
	}

	public function setExportButton($nameSingleCode, $nameListCode)
	{
		$button = '';
		if (isset($this->eximportView[$nameListCode])
			&& $this->eximportView[$nameListCode]
			&& CFactory::_('Config')->get('joomla_version', 3) == 3) // needs fixing for Joomla 4 and above
		{
			// main lang prefix
			$langExport = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe('Export Data', 'U');
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langExport, 'Export Data');
			$button   = [];
			$button[] = PHP_EOL . PHP_EOL . Indent::_(3)
				. "if (\$this->canDo->get('core.export') && \$this->canDo->get('"
				. $nameSingleCode . ".export'))";
			$button[] = Indent::_(3) . "{";
			$button[] = Indent::_(4) . "ToolbarHelper::custom('"
				. $nameListCode . ".exportData', 'download', '', '"
				. $langExport . "', true);";
			$button[] = Indent::_(3) . "}";

			return implode(PHP_EOL, $button);
		}

		return $button;
	}

	public function setImportButton($nameSingleCode, $nameListCode)
	{
		$button = '';
		if (isset($this->eximportView[$nameListCode])
			&& $this->eximportView[$nameListCode]
			&& CFactory::_('Config')->get('joomla_version', 3) == 3) // needs fixing for Joomla 4 and above
		{
			// main lang prefix
			$langImport = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe('Import Data', 'U');
			// add to lang array
			CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langImport, 'Import Data');
			$button   = [];
			$button[] = PHP_EOL . PHP_EOL . Indent::_(2)
				. "if (\$this->canDo->get('core.import') && \$this->canDo->get('"
				. $nameSingleCode . ".import'))";
			$button[] = Indent::_(2) . "{";
			$button[] = Indent::_(3) . "ToolbarHelper::custom('"
				. $nameListCode . ".importData', 'upload', '', '"
				. $langImport
				. "', false);";
			$button[] = Indent::_(2) . "}";

			return implode(PHP_EOL, $button);
		}

		return $button;
	}

	public function setImportCustomScripts($nameListCode)
	{
		// setup Ajax files
		$target = array('admin' => 'import_' . $nameListCode);
		CFactory::_('Utilities.Structure')->build($target, 'customimport');
		// load the custom script to the files
		// IMPORT_EXT_METHOD <<<DYNAMIC>>>
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_EXT_METHOD', CFactory::_('Customcode.Dispenser')->get(
			'php_import_ext', 'import_' . $nameListCode, PHP_EOL, null,
			true
		));
		// IMPORT_DISPLAY_METHOD_CUSTOM <<<DYNAMIC>>>
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_DISPLAY_METHOD_CUSTOM', CFactory::_('Customcode.Dispenser')->get(
			'php_import_display', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));
		// IMPORT_SETDATA_METHOD <<<DYNAMIC>>>
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_SETDATA_METHOD', CFactory::_('Customcode.Dispenser')->get(
			'php_import_setdata', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));
		// IMPORT_METHOD_CUSTOM <<<DYNAMIC>>>
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_METHOD_CUSTOM', CFactory::_('Customcode.Dispenser')->get(
			'php_import', 'import_' . $nameListCode, PHP_EOL, null,
			true
		));
		// IMPORT_SAVE_METHOD <<<DYNAMIC>>>
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_SAVE_METHOD', CFactory::_('Customcode.Dispenser')->get(
			'php_import_save', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));
		// IMPORT_DEFAULT_VIEW_CUSTOM <<<DYNAMIC>>>
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_DEFAULT_VIEW_CUSTOM', CFactory::_('Customcode.Dispenser')->get(
			'html_import_view', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));

		// insure we have the view placeholders setup
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|VIEW', 'IMPORT_' . CFactory::_('Placeholder')->get_h('VIEWS'));
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|View', 'Import_' . CFactory::_('Placeholder')->get_h('views'));
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|view', 'import_' . CFactory::_('Placeholder')->get_h('views'));
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|VIEWS', 'IMPORT_' . CFactory::_('Placeholder')->get_h('VIEWS'));
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|Views', 'Import_' . CFactory::_('Placeholder')->get_h('views'));
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|views', 'import_' . CFactory::_('Placeholder')->get_h('views'));

		// IMPORT_CUSTOM_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_CUSTOM_CONTROLLER_HEADER', CFactory::_('Header')->get(
			'import.custom.controller',
			$nameListCode
		));

		// IMPORT_CUSTOM_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
		CFactory::_('Compiler.Builder.Content.Multi')->set('import_' . $nameListCode . '|IMPORT_CUSTOM_MODEL_HEADER', CFactory::_('Header')->get(
			'import.custom.model',
			$nameListCode
		));
	}

	public function setListQuery(&$nameSingleCode, &$nameListCode)
	{
		// check if this view has category added
		if (CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.code"))
		{
			$categoryCodeName = CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.code");
			$addCategory      = true;
			$addCategoryFilter
				= CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.filter", 'error');
		}
		else
		{
			$addCategory       = false;
			$addCategoryFilter = 0;
		}
		// setup the query
		$query = "//" . Line::_(__Line__, __Class__) . " Get the user object.";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$query .= PHP_EOL . Indent::_(2) . "\$user = Factory::getUser();";
		}
		else
		{
			$query .= PHP_EOL . Indent::_(2) . "\$user = \$this->getCurrentUser();";
		}
		$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Create a new query object.";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$query .= PHP_EOL . Indent::_(2) . "\$db = Factory::getDBO();";
		}
		else
		{
			$query .= PHP_EOL . Indent::_(2) . "\$db = \$this->getDatabase();";
		}
		$query .= PHP_EOL . Indent::_(2) . "\$query = \$db->getQuery(true);";
		$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Select some fields";
		$query .= PHP_EOL . Indent::_(2) . "\$query->select('a.*');";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->select(\$db->quoteName('c.title','category_title'));";
		}
		$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " From the " . CFactory::_('Config')->component_code_name . "_item table";
		$query .= PHP_EOL . Indent::_(2) . "\$query->from(\$db->quoteName('#__"
			. CFactory::_('Config')->component_code_name . "_" . $nameSingleCode . "', 'a'));";
		// add the category
		if ($addCategory)
		{
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->join('LEFT', \$db->quoteName('#__categories', 'c') . ' ON (' . \$db->quoteName('a."
				. $categoryCodeName
				. "') . ' = ' . \$db->quoteName('c.id') . ')');";
		}
		// add custom filtering php
		$query .= CFactory::_('Customcode.Dispenser')->get(
			'php_getlistquery', $nameSingleCode, PHP_EOL . PHP_EOL
		);
		// add the custom fields query
		$query .= $this->setCustomQuery($nameListCode, $nameSingleCode);
		$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Filter by published state";
		$query .= PHP_EOL . Indent::_(2)
			. "\$published = \$this->getState('filter.published');";
		$query .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$published))";
		$query .= PHP_EOL . Indent::_(2) . "{";
		$query .= PHP_EOL . Indent::_(3)
			. "\$query->where('a.published = ' . (int) \$published);";
		$query .= PHP_EOL . Indent::_(2) . "}";
		$query .= PHP_EOL . Indent::_(2) . "elseif (\$published === '')";
		$query .= PHP_EOL . Indent::_(2) . "{";
		$query .= PHP_EOL . Indent::_(3)
			. "\$query->where('(a.published = 0 OR a.published = 1)');";
		$query .= PHP_EOL . Indent::_(2) . "}";
		if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode))
		{
			$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Join over the asset groups.";
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->select('ag.title AS access_level');";
			$query .= PHP_EOL . Indent::_(2)
				. "\$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');";
			// check if the access field was over ridden
			if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
			{
				// component helper name
				$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
				// load the access filter query code
				$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					)
					. " Filter by access level.";
				$query .= PHP_EOL . Indent::_(2)
					. "\$_access = \$this->getState('filter.access');";
				$query .= PHP_EOL . Indent::_(2)
					. "if (\$_access && is_numeric(\$_access))";
				$query .= PHP_EOL . Indent::_(2) . "{";
				$query .= PHP_EOL . Indent::_(3)
					. "\$query->where('a.access = ' . (int) \$_access);";
				$query .= PHP_EOL . Indent::_(2) . "}";
				$query .= PHP_EOL . Indent::_(2) . "elseif ("
					. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$_access))";
				$query .= PHP_EOL . Indent::_(2) . "{";
				$query .= PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__)
					. " Secure the array for the query";
				$query .= PHP_EOL . Indent::_(3)
					. "\$_access = ArrayHelper::toInteger(\$_access);";
				$query .= PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Filter by the Access Array.";
				$query .= PHP_EOL . Indent::_(3)
					. "\$query->where('a.access IN (' . implode(',', \$_access) . ')');";
				$query .= PHP_EOL . Indent::_(2) . "}";
			}
			// TODO the following will fight against the above access filter
			$query .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Implement View Level Access";
			$query .= PHP_EOL . Indent::_(2)
				. "if (!\$user->authorise('core.options', 'com_"
				. CFactory::_('Config')->component_code_name . "'))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3)
				. "\$groups = implode(',', \$user->getAuthorisedViewLevels());";
			$query .= PHP_EOL . Indent::_(3)
				. "\$query->where('a.access IN (' . \$groups . ')');";
			$query .= PHP_EOL . Indent::_(2) . "}";
		}
		// set the search query
		$query .= $this->setSearchQuery($nameListCode);
		// set other filters
		$query .= $this->setFilterQuery($nameListCode);
		// add the category
		if ($addCategory && $addCategoryFilter >= 1)
		{
			$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Filter by a single or group of categories.";
			$query .= PHP_EOL . Indent::_(2) . "\$baselevel = 1;";
			$query .= PHP_EOL . Indent::_(2)
				. "\$categoryId = \$this->getState('filter.category_id');";
			$query .= PHP_EOL;
			$query .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$categoryId))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3)
				. "\$cat_tbl = Table::getInstance('Category', 'JTable');";
			$query .= PHP_EOL . Indent::_(3) . "\$cat_tbl->load(\$categoryId);";
			$query .= PHP_EOL . Indent::_(3) . "\$rgt = \$cat_tbl->rgt;";
			$query .= PHP_EOL . Indent::_(3) . "\$lft = \$cat_tbl->lft;";
			$query .= PHP_EOL . Indent::_(3)
				. "\$baselevel = (int) \$cat_tbl->level;";
			$query .= PHP_EOL . Indent::_(3)
				. "\$query->where('c.lft >= ' . (int) \$lft)";
			$query .= PHP_EOL . Indent::_(4)
				. "->where('c.rgt <= ' . (int) \$rgt);";
			$query .= PHP_EOL . Indent::_(2) . "}";
			$query .= PHP_EOL . Indent::_(2)
				. "elseif (is_array(\$categoryId))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3)
				. "\$categoryId = ArrayHelper::toInteger(\$categoryId);";
			$query .= PHP_EOL . Indent::_(3)
				. "\$categoryId = implode(',', \$categoryId);";
			$query .= PHP_EOL . Indent::_(3)
				. "\$query->where('a." . $categoryCodeName
				. " IN (' . \$categoryId . ')');";
			$query .= PHP_EOL . Indent::_(2) . "}";
			$query .= PHP_EOL;
		}
		// setup values for the view ordering
		// add dynamic ordering (Admin view)
		if (CFactory::_('Compiler.Builder.Views.Default.Ordering')->
			get("$nameListCode.add_admin_ordering", 0) == 1)
		{
			// the first is from the state
			$order_first = true;
			foreach (CFactory::_('Compiler.Builder.Views.Default.Ordering')->
				get("$nameListCode.admin_ordering_fields", []) as $order_field)
			{
				if (($order_field_name = CFactory::_('Field.Database.Name')->get(
						$nameListCode, $order_field['field']
					)) !== false)
				{
					if ($order_first)
					{
						// just the first field is based on state
						$order_first = false;
						$query       .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
							. Line::_(
								__LINE__,__CLASS__
							) . " Add the list ordering clause.";
						$query       .= PHP_EOL . Indent::_(2)
							. "\$orderCol = \$this->getState('list.ordering', '"
							. $order_field_name . "');";
						$query       .= PHP_EOL . Indent::_(2)
							. "\$orderDirn = \$this->getState('list.direction', '"
							. $order_field['direction'] . "');";
						$query       .= PHP_EOL . Indent::_(2)
							. "if (\$orderCol != '')";
						$query       .= PHP_EOL . Indent::_(2) . "{";
						$query       .= PHP_EOL . Indent::_(3) . "//" . Line::_(__LINE__,__CLASS__
							) . " Check that the order direction is valid encase we have a field called direction as part of filers.";
						$query .= PHP_EOL . Indent::_(3)
							. "\$orderDirn = (is_string(\$orderDirn) && in_array(strtolower(\$orderDirn), ['asc', 'desc'])) ? \$orderDirn : '"
							. $order_field['direction'] . "';";
						$query       .= PHP_EOL . Indent::_(3)
							. "\$query->order(\$db->escape(\$orderCol . ' ' . \$orderDirn));";
						$query       .= PHP_EOL . Indent::_(2) . "}";
					}
					else
					{
						$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
							. Line::_(
								__LINE__,__CLASS__
							) . " Add a permanent list ordering.";
						$query .= PHP_EOL . Indent::_(2)
							. "\$query->order(\$db->escape('"
							. $order_field_name . " "
							. $order_field['direction'] . "'));";
					}
				}
			}
		}
		else
		{
			$query .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add the list ordering clause.";
			$query .= PHP_EOL . Indent::_(2)
				. "\$orderCol = \$this->getState('list.ordering', 'a.id');";
			$query .= PHP_EOL . Indent::_(2)
				. "\$orderDirn = \$this->getState('list.direction', 'desc');";
			$query .= PHP_EOL . Indent::_(2) . "if (\$orderCol != '')";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query       .= PHP_EOL . Indent::_(3) . "//" . Line::_(__LINE__,__CLASS__
				) . " Check that the order direction is valid encase we have a field called direction as part of filers.";
			$query .= PHP_EOL . Indent::_(3)
				. "\$orderDirn = (is_string(\$orderDirn) && in_array(strtolower(\$orderDirn), ['asc', 'desc'])) ? \$orderDirn : 'desc';";
			$query .= PHP_EOL . Indent::_(3)
				. "\$query->order(\$db->escape(\$orderCol . ' ' . \$orderDirn));";
			$query .= PHP_EOL . Indent::_(2) . "}";
		}
		$query .= PHP_EOL;
		$query .= PHP_EOL . Indent::_(2) . "return \$query;";

		return $query;
	}

	public function setSearchQuery($nameListCode)
	{
		if (CFactory::_('Compiler.Builder.Search')->exists($nameListCode))
		{
			// setup the searh options
			$search = "'(";
			foreach (CFactory::_('Compiler.Builder.Search')->get($nameListCode) as $nr => $array)
			{
				// array( 'type' => $typeName, 'code' => $name, 'custom' => $custom, 'list' => $field['list']);
				if ($nr == 0)
				{
					$search .= "a." . $array['code'] . " LIKE '.\$search.'";
					if (ArrayHelper::check($array['custom'])
						&& 1 == $array['list'])
					{
						$search .= " OR " . $array['custom']['db'] . "."
							. $array['custom']['text'] . " LIKE '.\$search.'";
					}
				}
				else
				{
					$search .= " OR a." . $array['code'] . " LIKE '.\$search.'";
					if (ArrayHelper::check($array['custom'])
						&& 1 == $array['list'])
					{
						$search .= " OR " . $array['custom']['db'] . "."
							. $array['custom']['text'] . " LIKE '.\$search.'";
					}
				}
			}
			$search .= ")'";
			// now setup query
			$query = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Filter by search.";
			$query .= PHP_EOL . Indent::_(2)
				. "\$search = \$this->getState('filter.search');";
			$query .= PHP_EOL . Indent::_(2) . "if (!empty(\$search))";
			$query .= PHP_EOL . Indent::_(2) . "{";
			$query .= PHP_EOL . Indent::_(3)
				. "if (stripos(\$search, 'id:') === 0)";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "\$query->where('a.id = ' . (int) substr(\$search, 3));";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(3) . "else";
			$query .= PHP_EOL . Indent::_(3) . "{";
			$query .= PHP_EOL . Indent::_(4)
				. "\$search = \$db->quote('%' . \$db->escape(\$search) . '%');";
			$query .= PHP_EOL . Indent::_(4) . "\$query->where(" . $search
				. ");";
			$query .= PHP_EOL . Indent::_(3) . "}";
			$query .= PHP_EOL . Indent::_(2) . "}";
			$query .= PHP_EOL;

			return $query;
		}

		return '';
	}

	public function setCustomQuery($nameListCode, $nameSingleCode,
	                               $tab = '',
	                               $just_text = false
	)
	{
		if (CFactory::_('Compiler.Builder.Custom.Field')->exists($nameListCode))
		{
			$query = "";
			foreach (CFactory::_('Compiler.Builder.Custom.Field')->get($nameListCode) as $filter)
			{
				// only load this if table is set
				if ((CFactory::_('Compiler.Builder.Custom.List')->exists($nameSingleCode . '.' . $filter['code'])
						&& isset($filter['custom']['table'])
						&& StringHelper::check($filter['custom']['table'])
						&& $filter['method'] == 0)
					|| ($just_text && isset($filter['custom']['table'])
						&& StringHelper::check($filter['custom']['table'])
						&& $filter['method'] == 0))
				{
					$query .= PHP_EOL . PHP_EOL . Indent::_(2) . $tab . "//"
						. Line::_(__Line__, __Class__) . " From the "
						. StringHelper::safe(
							StringHelper::safe(
								$filter['custom']['table'], 'w'
							)
						) . " table.";
					// we must add some fix for none ID keys (I know this is horrible... but we need it)
					// TODO we assume that all tables in admin has ids
					if ($filter['custom']['id'] !== 'id')
					{
						// we want to at times just have the words and not the ids as well
						if ($just_text)
						{
							$query .= PHP_EOL . Indent::_(2) . $tab
								. "\$query->select(\$db->quoteName(['"
								. $filter['custom']['db'] . "."
								. $filter['custom']['text'] . "','"
								. $filter['custom']['db'] . ".id'],['"
								. $filter['code'] . "','"
								. $filter['code'] . "_id']));";
						}
						else
						{
							$query .= PHP_EOL . Indent::_(2) . $tab
								. "\$query->select(\$db->quoteName(['"
								. $filter['custom']['db'] . "."
								. $filter['custom']['text'] . "','"
								. $filter['custom']['db'] . ".id'],['"
								. $filter['code'] . "_" . $filter['custom']['text']
								. "','" . $filter['code'] . "_id']));";
						}
					}
					else
					{
						// we want to at times just have the words and not the ids as well
						if ($just_text)
						{
							$query .= PHP_EOL . Indent::_(2) . $tab
								. "\$query->select(\$db->quoteName('"
								. $filter['custom']['db'] . "."
								. $filter['custom']['text'] . "','"
								. $filter['code'] . "'));";
						}
						else
						{
							$query .= PHP_EOL . Indent::_(2) . $tab
								. "\$query->select(\$db->quoteName('"
								. $filter['custom']['db'] . "."
								. $filter['custom']['text'] . "','"
								. $filter['code'] . "_" . $filter['custom']['text']
								. "'));";
						}
					}
					$query .= PHP_EOL . Indent::_(2) . $tab
						. "\$query->join('LEFT', \$db->quoteName('"
						. $filter['custom']['table'] . "', '"
						. $filter['custom']['db']
						. "') . ' ON (' . \$db->quoteName('a." . $filter['code']
						. "') . ' = ' . \$db->quoteName('"
						. $filter['custom']['db'] . "."
						. $filter['custom']['id'] . "') . ')');";
				}
				// build the field type file
				CFactory::_('Compiler.Creator.Custom.Field.Type.File')->set(
					$filter, $nameListCode, $nameSingleCode
				);
			}

			return $query;
		}
	}

	/**
	 * build model filter per/field in the list view
	 *
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  string The php to place in model to filter
	 *
	 */
	public function setFilterQuery($nameListCode)
	{
		if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
		{
			// component helper name
			$Helper = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
			// start building the filter query
			$filterQuery = "";
			foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $filter)
			{
				// only add for none category fields
				if ($filter['type'] != 'category')
				{
					$filterQuery .= PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Filter by "
						. ucwords((string) $filter['code']) . ".";
					// we only add multi filter option if new filter type
					// and we have multi filter set for this field (2 = topbar)
					if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2
						&& isset($filter['multi'])
						&& $filter['multi'] == 2)
					{
						$filterQuery .= $this->setMultiFilterQuery(
							$filter, $Helper
						);
					}
					else
					{
						$filterQuery .= $this->setSingleFilterQuery(
							$filter, $Helper
						);
					}
				}
			}

			return $filterQuery;
		}

		return '';
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
	 */
	protected function setSingleFilterQuery($filter, $Helper, $a = "a")
	{
		$filterQuery = PHP_EOL . Indent::_(2) . "\$_"
			. $filter['code'] . " = \$this->getState('filter."
			. $filter['code'] . "');";
		$filterQuery .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3) . "if (is_float(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (float) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(3) . "else";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (int) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "elseif ("
			. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$_" . $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . \$db->quote(\$db->escape(\$_" . $filter['code']
			. ")));";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";

		return $filterQuery;
	}

	/**
	 * build multiple filter query
	 *
	 * @param   array   $filter  The field/filter
	 * @param   string  $Helper  The helper name of the component being build
	 * @param   string  $a       The db table target name (a)
	 *
	 * @return  string The php to place in model to filter this field
	 *
	 */
	protected function setMultiFilterQuery($filter, $Helper, $a = "a")
	{
		$filterQuery = PHP_EOL . Indent::_(2) . "\$_"
			. $filter['code'] . " = \$this->getState('filter."
			. $filter['code'] . "');";
		$filterQuery .= PHP_EOL . Indent::_(2) . "if (is_numeric(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3) . "if (is_float(\$_"
			. $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (float) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(3) . "else";
		$filterQuery .= PHP_EOL . Indent::_(3) . "{";
		$filterQuery .= PHP_EOL . Indent::_(4)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . (int) \$_" . $filter['code'] . ");";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "elseif ("
			. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$_" . $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";
		$filterQuery .= PHP_EOL . Indent::_(3)
			. "\$query->where('" . $a . "." . $filter['code']
			. " = ' . \$db->quote(\$db->escape(\$_" . $filter['code']
			. ")));";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";
		$filterQuery .= PHP_EOL . Indent::_(2) . "elseif ("
			. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$_" . $filter['code'] . "))";
		$filterQuery .= PHP_EOL . Indent::_(2) . "{";

		$filterQuery .= PHP_EOL . Indent::_(3) . "//"
			. Line::_(__Line__, __Class__) . " Secure the array for the query";

		$filterQuery .= PHP_EOL . Indent::_(3) . "\$_" . $filter['code']
			. " = array_map( function (\$val) use(&\$db) {";
		$filterQuery .= PHP_EOL . Indent::_(4) . "if (is_numeric(\$val))";
		$filterQuery .= PHP_EOL . Indent::_(4) . "{";
		$filterQuery .= PHP_EOL . Indent::_(5) . "if (is_float(\$val))";
		$filterQuery .= PHP_EOL . Indent::_(5) . "{";
		$filterQuery .= PHP_EOL . Indent::_(6) . "return (float) \$val;";
		$filterQuery .= PHP_EOL . Indent::_(5) . "}";
		$filterQuery .= PHP_EOL . Indent::_(5) . "else";
		$filterQuery .= PHP_EOL . Indent::_(5) . "{";
		$filterQuery .= PHP_EOL . Indent::_(6) . "return (int) \$val;";
		$filterQuery .= PHP_EOL . Indent::_(5) . "}";
		$filterQuery .= PHP_EOL . Indent::_(4) . "}";
		$filterQuery .= PHP_EOL . Indent::_(4) . "elseif ("
			. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$val))";
		$filterQuery .= PHP_EOL . Indent::_(4) . "{";
		$filterQuery .= PHP_EOL . Indent::_(5)
			. "return \$db->quote(\$db->escape(\$val));";
		$filterQuery .= PHP_EOL . Indent::_(4) . "}";
		$filterQuery .= PHP_EOL . Indent::_(3) . "}, \$_"
			. $filter['code'] . ");";

		$filterQuery .= PHP_EOL . Indent::_(3) . "//"
			. Line::_(__Line__, __Class__) . " Filter by the "
			. ucwords((string) $filter['code']) . " Array.";

		$filterQuery .= PHP_EOL . Indent::_(3)
			. "\$query->where('" . $a . "." . $filter['code']
			. " IN (' . implode(',', \$_" . $filter['code'] . ") . ')');";
		$filterQuery .= PHP_EOL . Indent::_(2) . "}";

		return $filterQuery;
	}

	public function buildTheViewScript($viewArray)
	{
		// set the view name
		$nameSingleCode = $viewArray['settings']->name_single_code;
		// add conditions to this view
		if (isset($viewArray['settings']->conditions)
			&& ArrayHelper::check(
				$viewArray['settings']->conditions
			))
		{
			// reset defaults
			$getValue       = [];
			$ifValue        = [];
			$targetControls = [];
			$functions      = [];

			foreach ($viewArray['settings']->conditions as $condition)
			{
				if (isset($condition['match_name'])
					&& StringHelper::check(
						$condition['match_name']
					))
				{
					$uniqueVar      = $this->uniquekey(7);
					$matchName      = $condition['match_name'] . '_'
						. $uniqueVar;
					$targetBehavior = ($condition['target_behavior'] == 1
						|| $condition['target_behavior'] == 3) ? 'show'
						: 'hide';
					$targetDefault  = ($condition['target_behavior'] == 1
						|| $condition['target_behavior'] == 3) ? 'hide'
						: 'show';

					// set the realtation if any
					if ($condition['target_relation'])
					{
						// chain to other items of the same target
						$relations = $this->getTargetRelationScript(
							$viewArray['settings']->conditions, $condition,
							$nameSingleCode
						);
						if (ArrayHelper::check($relations))
						{
							// set behavior and default array
							$behaviors[$matchName] = $targetBehavior;
							$defaults[$matchName]  = $targetDefault;
							$toggleSwitch[$matchName]
								= ($condition['target_behavior']
								== 1
								|| $condition['target_behavior'] == 2) ? true
								: false;
							// set the type buket
							$typeBuket[$matchName] = $condition['match_type'];
							// set function array
							$functions[$uniqueVar][0] = $matchName;
							$matchNames[$matchName]
								= $condition['match_name'];
							// get the select value
							$getValue[$matchName] = $this->getValueScript(
								$condition['match_type'],
								$condition['match_name'],
								$condition['match_extends'], $uniqueVar
							);
							// get the options
							$options = $this->getOptionsScript(
								$condition['match_type'],
								$condition['match_options']
							);
							// set the if values
							$ifValue[$matchName] = $this->ifValueScript(
								$matchName, $condition['match_behavior'],
								$condition['match_type'], $options
							);
							// set the target controls
							$targetControls[$matchName]
								= $this->setTargetControlsScript(
								$toggleSwitch[$matchName],
								$condition['target_field'], $targetBehavior,
								$targetDefault, $uniqueVar, $nameSingleCode
							);

							foreach ($relations as $relation)
							{
								if (StringHelper::check(
									$relation['match_name']
								))
								{
									$relationName = $relation['match_name']
										. '_' . $uniqueVar;
									// set the type buket
									$typeBuket[$relationName]
										= $relation['match_type'];
									// set function array
									$functions[$uniqueVar][] = $relationName;
									$matchNames[$relationName]
										= $relation['match_name'];
									// get the relation option
									$relationOptions = $this->getOptionsScript(
										$relation['match_type'],
										$relation['match_options']
									);
									$getValue[$relationName]
										= $this->getValueScript(
										$relation['match_type'],
										$relation['match_name'],
										$condition['match_extends'], $uniqueVar
									);
									$ifValue[$relationName]
										= $this->ifValueScript(
										$relationName,
										$relation['match_behavior'],
										$relation['match_type'],
										$relationOptions
									);
								}
							}
						}
					}
					else
					{
						// set behavior and default array
						$behaviors[$matchName] = $targetBehavior;
						$defaults[$matchName]  = $targetDefault;
						$toggleSwitch[$matchName]
							= ($condition['target_behavior']
							== 1
							|| $condition['target_behavior'] == 2) ? true
							: false;
						// set the type buket
						$typeBuket[$matchName] = $condition['match_type'];
						// set function array
						$functions[$uniqueVar][0] = $matchName;
						$matchNames[$matchName]   = $condition['match_name'];
						// get the select value
						$getValue[$matchName] = $this->getValueScript(
							$condition['match_type'], $condition['match_name'],
							$condition['match_extends'], $uniqueVar
						);
						// get the options
						$options = $this->getOptionsScript(
							$condition['match_type'],
							$condition['match_options']
						);
						// set the if values
						$ifValue[$matchName] = $this->ifValueScript(
							$matchName, $condition['match_behavior'],
							$condition['match_type'], $options
						);
						// set the target controls
						$targetControls[$matchName]
							= $this->setTargetControlsScript(
							$toggleSwitch[$matchName],
							$condition['target_field'], $targetBehavior,
							$targetDefault, $uniqueVar, $nameSingleCode
						);
					}
				}
			}
			// reset buckets
			$initial    = '';
			$func       = '';
			$validation = '';
			$isSet      = '';
			$listener   = '';
			if (ArrayHelper::check($functions))
			{
				// now build the initial script
				$initial .= "//" . Line::_(__Line__, __Class__) . " Initial Script"
					. PHP_EOL . "document.addEventListener('DOMContentLoaded', function()";
				$initial .= PHP_EOL . "{";
				foreach ($functions as $function => $matchKeys)
				{
					$func_call = $this->buildFunctionCall(
						$function, $matchKeys, $getValue
					);
					$initial   .= $func_call['code'];
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
						$name         = $matchNames[$l_matchKey];
						$matchTypeKey = $typeBuket[$l_matchKey];
						$funcCall     = $this->buildFunctionCall(
							$l_function, $l_matchKeys, $getValue
						);

						if (CFactory::_('Compiler.Builder.Script.Media.Switch')->inArray($matchTypeKey))
						{
							$modal .= $funcCall['code'];
						}
						else
						{
							if (CFactory::_('Compiler.Builder.Script.User.Switch')->inArray($matchTypeKey))
							{
								$name = $name . '_id';
							}

							$listener .= PHP_EOL . "//" . Line::_(
									__LINE__,__CLASS__
								) . " #jform_" . $name . " listeners for "
								. $l_matchKey . " function";
							$listener .= PHP_EOL . "jQuery('#jform_" . $name
								. "').on('keyup',function()";
							$listener .= PHP_EOL . "{";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL . "});";
							$listener .= PHP_EOL
								. "jQuery('#adminForm').on('change', '#jform_"
								. $name . "',function (e)";
							$listener .= PHP_EOL . "{";
							$listener .= PHP_EOL . Indent::_(1)
								. "e.preventDefault();";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL . "});" . PHP_EOL;
						}
					}
				}
				if (StringHelper::check($modal))
				{
					$listener .= PHP_EOL . "window.SqueezeBox.initialize({";
					$listener .= PHP_EOL . Indent::_(1) . "onClose:function(){";
					$listener .= $modal;
					$listener .= PHP_EOL . Indent::_(1) . "}";
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
					$func_    = $this->buildFunctionCall(
						$f_function, $f_matchKeys, $getValue
					);
					// set array switch
					if ($func_['array'])
					{
						$addArray = true;
					}
					$func      .= PHP_EOL . "//" . Line::_(__Line__, __Class__)
						. " the " . $f_function . " function";
					$func      .= PHP_EOL . "function " . $f_function . "(";
					$fucounter = 0;
					foreach ($f_matchKeys as $fu_matchKey)
					{
						if (StringHelper::check($fu_matchKey))
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
							$func .= PHP_EOL . Indent::_(1) . "if (isSet("
								. $a_matchKey . ") && " . $a_matchKey
								. ".constructor !== Array)" . PHP_EOL
								. Indent::_(1) . "{" . PHP_EOL . Indent::_(2)
								. "var temp_" . $f_function . " = "
								. $a_matchKey . ";" . PHP_EOL . Indent::_(2)
								. "var " . $a_matchKey . " = [];" . PHP_EOL
								. Indent::_(2) . $a_matchKey . ".push(temp_"
								. $f_function . ");" . PHP_EOL . Indent::_(1)
								. "}";
							$func .= PHP_EOL . Indent::_(1) . "else if (!isSet("
								. $a_matchKey . "))" . PHP_EOL . Indent::_(1)
								. "{";
							$func .= PHP_EOL . Indent::_(2) . "var "
								. $a_matchKey . " = [];";
							$func .= PHP_EOL . Indent::_(1) . "}";
							$func .= PHP_EOL . Indent::_(1) . "var " . $name
								. " = " . $a_matchKey . ".some(" . $a_matchKey
								. "_SomeFunc);" . PHP_EOL;

							// setup the map function
							$map .= PHP_EOL . "//" . Line::_(__Line__, __Class__)
								. " the " . $f_function . " Some function";
							$map .= PHP_EOL . "function " . $a_matchKey
								. "_SomeFunc(" . $a_matchKey . ")";
							$map .= PHP_EOL . "{";
							$map .= PHP_EOL . Indent::_(1) . "//"
								. Line::_(__Line__, __Class__)
								. " set the function logic";
							$map .= PHP_EOL . Indent::_(1) . "if (";
							$if  = $ifValue[$a_matchKey];
							if (StringHelper::check($if))
							{
								$map .= $if;
							}
							$map .= ")";
							$map .= PHP_EOL . Indent::_(1) . "{";
							$map .= PHP_EOL . Indent::_(2) . "return true;";
							$map .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL
								. Indent::_(1) . "return false;";
							$map .= PHP_EOL . "}" . PHP_EOL;
						}
						$func .= PHP_EOL . PHP_EOL . Indent::_(1) . "//"
							. Line::_(__Line__, __Class__)
							. " set this function logic";
						$func .= PHP_EOL . Indent::_(1) . "if (";
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
						$func .= ")" . PHP_EOL . Indent::_(1) . "{";
					}
					else
					{
						$func .= PHP_EOL . Indent::_(1) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " set the function logic";
						$func .= PHP_EOL . Indent::_(1) . "if (";
						// set if counter
						$ifcounter = 0;
						foreach ($f_matchKeys as $f_matchKey)
						{
							$if = $ifValue[$f_matchKey];
							if (StringHelper::check($if))
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
						$func .= ")" . PHP_EOL . Indent::_(1) . "{";
					}
					// get the controles
					$controls = $targetControls[$f_matchKeys[0]];
					// get target behavior and default
					$targetBehavior = $behaviors[$f_matchKeys[0]];
					$targetDefault  = $defaults[$f_matchKeys[0]];
					// load the target behavior
					foreach ($controls as $target => $action)
					{
						$func .= $action['behavior'];
						if (StringHelper::check(
							$action[$targetBehavior]
						))
						{
							$func .= $action[$targetBehavior];
							$head .= $action['requiredVar'];
						}
					}
					// check if this is a toggle switch
					if ($toggleSwitch[$f_matchKeys[0]])
					{
						$func .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL
							. Indent::_(1) . "else" . PHP_EOL . Indent::_(1)
							. "{";
						// load the default behavior
						foreach ($controls as $target => $action)
						{
							$func .= $action['default'];
							if (StringHelper::check(
								$action[$targetDefault]
							))
							{
								$func .= $action[$targetDefault];
							}
						}
					}
					$func .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL . "}"
						. PHP_EOL . $map;
				}
				// add the needed validation to file
				if (isset($this->validationFixBuilder[$nameSingleCode])
					&& ArrayHelper::check(
						$this->validationFixBuilder[$nameSingleCode]
					))
				{
					$validation .= PHP_EOL . "// update fields required";
					$validation .= PHP_EOL
						. "function updateFieldRequired(name, status) {";
					$validation .= PHP_EOL . Indent::_(1)
						. "// check if not_required exist";
					$validation .= PHP_EOL . Indent::_(1)
						. "if (document.getElementById('jform_not_required')) {";
					$validation .= PHP_EOL . Indent::_(2)
						. "var not_required = jQuery('#jform_not_required').val().split(\",\");";
					$validation .= PHP_EOL . PHP_EOL . Indent::_(2)
						. "if(status == 1)";
					$validation .= PHP_EOL . Indent::_(2) . "{";
					$validation .= PHP_EOL . Indent::_(3)
						. "not_required.push(name);";
					$validation .= PHP_EOL . Indent::_(2) . "}";
					$validation .= PHP_EOL . Indent::_(2) . "else";
					$validation .= PHP_EOL . Indent::_(2) . "{";
					$validation .= PHP_EOL . Indent::_(3)
						. "not_required = removeFieldFromNotRequired(not_required, name);";
					$validation .= PHP_EOL . Indent::_(2) . "}";
					$validation .= PHP_EOL . PHP_EOL . Indent::_(2)
						. "jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());";
					$validation .= PHP_EOL . Indent::_(1) . "}";
					$validation .= PHP_EOL . "}" . PHP_EOL;
					$validation .= PHP_EOL
						. "// remove field from not_required";
					$validation .= PHP_EOL
						. "function removeFieldFromNotRequired(array, what) {";
					$validation .= PHP_EOL . Indent::_(1)
						. "return array.filter(function(element){";
					$validation .= PHP_EOL . Indent::_(2)
						. "return element !== what;";
					$validation .= PHP_EOL . Indent::_(1) . "});";
					$validation .= PHP_EOL . "}" . PHP_EOL;
					$validation .= PHP_EOL . "// fix not required array";
					$validation .= PHP_EOL
						. "function fixNotRequiredArray(array) {";
					$validation .= PHP_EOL . Indent::_(1) . "var seen = {};";
					$validation .= PHP_EOL . Indent::_(1)
						. "return removeEmptyFromNotRequiredArray(array).filter(function(item) {";
					$validation .= PHP_EOL . Indent::_(2)
						. "return seen.hasOwnProperty(item) ? false : (seen[item] = true);";
					$validation .= PHP_EOL . Indent::_(1) . "});";
					$validation .= PHP_EOL . "}" . PHP_EOL;
					$validation .= PHP_EOL
						. "// remove empty from not_required array";
					$validation .= PHP_EOL
						. "function removeEmptyFromNotRequiredArray(array) {";
					$validation .= PHP_EOL . Indent::_(1)
						. "return array.filter(function (el) {";
					$validation .= PHP_EOL . Indent::_(2)
						. "// remove ( 一_一) as well - lol";
					$validation .= PHP_EOL . Indent::_(2)
						. "return (el.length > 0 && '一_一' !== el);";
					$validation .= PHP_EOL . Indent::_(1) . "});";
					$validation .= PHP_EOL . "}" . PHP_EOL;
				}
				// set the isSet function
				$isSet = PHP_EOL . "// the isSet function";
				$isSet .= PHP_EOL . "function isSet(val)";
				$isSet .= PHP_EOL . "{";
				$isSet .= PHP_EOL . Indent::_(1)
					. "if ((val != undefined) && (val != null) && 0 !== val.length){";
				$isSet .= PHP_EOL . Indent::_(2) . "return true;";
				$isSet .= PHP_EOL . Indent::_(1) . "}";
				$isSet .= PHP_EOL . Indent::_(1) . "return false;";
				$isSet .= PHP_EOL . "}";
			}
			// load to this buket
			$fileScript   = $initial . $func . $validation . $isSet;
			$footerScript = $listener;
		}
		// add custom script to edit form JS file
		if (!isset($fileScript))
		{
			$fileScript = '';
		}
		$fileScript .= CFactory::_('Customcode.Dispenser')->get(
			'view_file', $nameSingleCode, PHP_EOL . PHP_EOL, null, true, ''
		);
		// add custom script to footer
		if (isset(CFactory::_('Customcode.Dispenser')->hub['view_footer'][$nameSingleCode])
			&& StringHelper::check(
				CFactory::_('Customcode.Dispenser')->hub['view_footer'][$nameSingleCode]
			))
		{
			$customFooterScript = PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
					CFactory::_('Customcode.Dispenser')->hub['view_footer'][$nameSingleCode]
				);
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
		$nameListCode = $viewArray['settings']->name_list_code;
		// add custom script to list view JS file
		if (($list_fileScript = CFactory::_('Customcode.Dispenser')->get(
				'views_file', $nameSingleCode, PHP_EOL . PHP_EOL, null, true,
				false
			)) !== false
			&& StringHelper::check($list_fileScript))
		{
			// get dates
			$_created  = CFactory::_('Model.Createdate')->get($viewArray);
			$_modified = CFactory::_('Model.Modifieddate')->get($viewArray);
			// add file to view
			$_target = array(CFactory::_('Config')->build_target => $nameListCode);
			$_config = array(Placefix::_h('CREATIONDATE') => $_created,
				Placefix::_h('BUILDDATE') => $_modified,
				Placefix::_h('VERSION') => $viewArray['settings']->version);
			CFactory::_('Utilities.Structure')->build($_target, 'javascript_file', false, $_config);
			// set path
			$_path = '/administrator/components/com_' . CFactory::_('Config')->component_code_name
				. '/assets/js/' . $nameListCode . '.js';
			// load the file to the list view
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_ADD_JAVASCRIPT_FILE', PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add List View JavaScript File" . PHP_EOL . Indent::_(2)
				. $this->setIncludeLibScript($_path)
			);
		}
		else
		{
			$list_fileScript = '';
			CFactory::_('Compiler.Builder.Content.Multi')->set($nameListCode . '|ADMIN_ADD_JAVASCRIPT_FILE', '');
		}
		// minify the script
		if (CFactory::_('Config')->get('minify', 0) && isset($list_fileScript)
			&& StringHelper::check($list_fileScript))
		{
			// minify the fileScript javascript
			$list_fileScript = Minify::js($list_fileScript);
		}
		// minify the script
		if (CFactory::_('Config')->get('minify', 0) && isset($fileScript)
			&& StringHelper::check($fileScript))
		{
			// minify the fileScript javascript
			$fileScript = Minify::js($fileScript);
		}
		// minify the script
		if (CFactory::_('Config')->get('minify', 0) && isset($footerScript)
			&& StringHelper::check($footerScript))
		{
			// minify the footerScript javascript
			$footerScript = Minify::js($footerScript);
		}
		// make sure there is script to add
		if (isset($list_fileScript)
			&& StringHelper::check(
				$list_fileScript
			))
		{
			// load the script
			$this->viewScriptBuilder[$nameListCode]['list_fileScript']
				= $list_fileScript;
		}
		// make sure there is script to add
		if (isset($fileScript)
			&& StringHelper::check(
				$fileScript
			))
		{
			// add the head script if set
			if (isset($head) && StringHelper::check($head))
			{
				$fileScript = "// Some Global Values" . PHP_EOL . $head
					. PHP_EOL . $fileScript;
			}
			// load the script
			$this->viewScriptBuilder[$nameSingleCode]['fileScript']
				= $fileScript;
		}
		// make sure to add custom footer script if php was found in it, since we canot minfy it with php
		if (isset($customFooterScript)
			&& StringHelper::check(
				$customFooterScript
			))
		{
			if (!isset($footerScript))
			{
				$footerScript = '';
			}
			$footerScript .= $customFooterScript;
		}
		// make sure there is script to add
		if (isset($footerScript)
			&& StringHelper::check(
				$footerScript
			))
		{
			// add the needed script tags
			$footerScript = PHP_EOL
				. PHP_EOL . '<script type="text/javascript">' . PHP_EOL
				. $footerScript . PHP_EOL . "</script>";
			$this->viewScriptBuilder[$nameSingleCode]['footerScript']
				= $footerScript;
		}
	}

	public function buildFunctionCall($function, $matchKeys, $getValue)
	{
		$initial  = '';
		$funcsets = [];
		$array    = false;
		foreach ($matchKeys as $matchKey)
		{
			$value = $getValue[$matchKey];
			if ($value['isArray'])
			{
				$initial    .= PHP_EOL . Indent::_(1) . $value['get'];
				$funcsets[] = $matchKey;
				$array      = true;
			}
			else
			{
				$initial    .= PHP_EOL . Indent::_(1) . $value['get'];
				$funcsets[] = $matchKey;
			}
		}

		// make sure that the function is loaded only once
		if (ArrayHelper::check($funcsets))
		{
			$initial .= PHP_EOL . Indent::_(1) . $function . "(";
			$initial .= implode(',', $funcsets);
			$initial .= ");" . PHP_EOL;
		}

		return array('code' => $initial, 'array' => $array);
	}

	public function getTargetRelationScript($relations, $condition, $view)
	{
		// reset the buket
		$buket = [];
		// convert to name array
		foreach ($condition['target_field'] as $targetField)
		{
			if (ArrayHelper::check($targetField)
				&& isset($targetField['name']))
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
			if ($relation['match_field'] !== $condition['match_field']
				&& $relation['target_relation']) // Made this change to see if it improves the expected result (TODO)
			{
				if (ArrayHelper::check(
					$relation['target_field']
				))
				{
					foreach ($relation['target_field'] as $target)
					{
						if (ArrayHelper::check($target)
							&& $this->checkRelationControl(
								$target['name'], $relation['match_name'],
								$condition['match_name'], $view
							))
						{
							if (in_array($target['name'], $currentTargets))
							{
								$this->targetRelationControl[$view][$target['name']]
									= array($relation['match_name'],
									$condition['match_name']);
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

	public function checkRelationControl($targetName, $relationMatchName,
	                                     $conditionMatchName, $view
	)
	{
		if (isset($this->targetRelationControl[$view])
			&& ArrayHelper::check(
				$this->targetRelationControl[$view]
			))
		{
			if (isset($this->targetRelationControl[$view][$targetName])
				&& ArrayHelper::check(
					$this->targetRelationControl[$view][$targetName]
				))
			{
				if (!in_array(
						$relationMatchName,
						$this->targetRelationControl[$view][$targetName]
					)
					|| !in_array(
						$conditionMatchName,
						$this->targetRelationControl[$view][$targetName]
					))
				{
					return true;
				}
			}
			else
			{
				return true;
			}
		}
		elseif (!isset($this->targetRelationControl[$view])
			|| !ArrayHelper::check(
				$this->targetRelationControl[$view]
			))
		{
			return true;
		}

		return false;
	}

	public function setTargetControlsScript($toggleSwitch, $targets,
	                                        $targetBehavior, $targetDefault, $uniqueVar, $nameSingleCode
	)
	{
		$bucket = [];
		if (ArrayHelper::check($targets)
			&& !in_array(
				$uniqueVar, $this->targetControlsScriptChecker
			))
		{
			foreach ($targets as $target)
			{
				if (ArrayHelper::check($target))
				{
					// set the required var
					if ($target['required'] === 'yes')
					{
						$unique                                 = $uniqueVar
							. $this->uniquekey(3);
						$bucket[$target['name']]['requiredVar'] = "jform_"
							. $unique . "_required = false;" . PHP_EOL;
					}
					else
					{
						$bucket[$target['name']]['requiredVar'] = '';
					}
					// set target type
					$targetTypeSufix = "";
					if (CFactory::_('Field.Groups')->check(
						$target['type'], 'spacer'
					))
					{
						// target a class if this is a note or spacer
						$targetType = ".";
					}
					elseif ($target['type'] === 'editor'
						|| $target['type'] === 'subform')
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
					$bucket[$target['name']]['behavior'] = PHP_EOL . Indent::_(
							2
						) . "jQuery('" . $targetType . $target['name']
						. $targetTypeSufix . "').closest('.control-group')."
						. $targetBehavior . "();";
					// set the target default
					$bucket[$target['name']]['default'] = PHP_EOL . Indent::_(2)
						. "jQuery('" . $targetType . $target['name']
						. $targetTypeSufix . "').closest('.control-group')."
						. $targetDefault . "();";
					// the hide required function
					if ($target['required'] === 'yes')
					{
						if ($toggleSwitch)
						{
							$hide                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " remove required attribute from "
								. $target['name'] . " field";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "if (!jform_" . $unique
								. "_required)";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "{";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "updateFieldRequired('"
								. $target['name'] . "',1);";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('required');";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('aria-required');";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').removeClass('required');";
							$hide                            .= PHP_EOL
								. Indent::_(3) . "jform_" . $unique
								. "_required = true;";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "}";
							$bucket[$target['name']]['hide'] = $hide;
							// the show required function
							$show                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " add required attribute to "
								. $target['name'] . " field";
							$show                            .= PHP_EOL
								. Indent::_(2) . "if (jform_" . $unique
								. "_required)";
							$show                            .= PHP_EOL
								. Indent::_(2) . "{";
							$show                            .= PHP_EOL
								. Indent::_(3) . "updateFieldRequired('"
								. $target['name'] . "',0);";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').prop('required','required');";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name']
								. "').attr('aria-required',true);";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jQuery('#jform_"
								. $target['name'] . "').addClass('required');";
							$show                            .= PHP_EOL
								. Indent::_(3) . "jform_" . $unique
								. "_required = false;";
							$show                            .= PHP_EOL
								. Indent::_(2) . "}";
							$bucket[$target['name']]['show'] = $show;
						}
						else
						{
							$hide                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " remove required attribute from "
								. $target['name'] . " field";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "updateFieldRequired('"
								. $target['name'] . "',1);";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('required');";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').removeAttr('aria-required');";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').removeClass('required');";
							$hide                            .= PHP_EOL
								. Indent::_(2) . "jform_" . $unique
								. "_required = true;" . PHP_EOL;
							$bucket[$target['name']]['hide'] = $hide;
							// the show required function
							$show                            = PHP_EOL
								. Indent::_(2) . "//" . Line::_(__Line__, __Class__)
								. " add required attribute to "
								. $target['name'] . " field";
							$show                            .= PHP_EOL
								. Indent::_(2) . "updateFieldRequired('"
								. $target['name'] . "',0);";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').prop('required','required');";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name']
								. "').attr('aria-required',true);";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jQuery('#jform_"
								. $target['name'] . "').addClass('required');";
							$show                            .= PHP_EOL
								. Indent::_(2) . "jform_" . $unique
								. "_required = false;" . PHP_EOL;
							$bucket[$target['name']]['show'] = $show;
						}
						// make sure that the axaj and other needed things for this view is loaded
						$this->validationFixBuilder[$nameSingleCode][]
							= $target['name'];
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
				if (CFactory::_('Field.Groups')->check($type, 'list')
					|| CFactory::_('Field.Groups')->check($type, 'dynamic')
					|| !CFactory::_('Field.Groups')->check($type))
				{
					if (ArrayHelper::check($options))
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
							if (StringHelper::check($string))
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
				if (CFactory::_('Field.Groups')->check($type, 'list')
					|| CFactory::_('Field.Groups')->check($type, 'dynamic')
					|| !CFactory::_('Field.Groups')->check($type))
				{
					if (ArrayHelper::check($options))
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
							if (StringHelper::check($string))
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
				if (CFactory::_('Field.Groups')->check($type, 'list')
					|| CFactory::_('Field.Groups')->check($type, 'dynamic')
					|| !CFactory::_('Field.Groups')->check($type))
				{
					if (ArrayHelper::check($options))
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
							if (StringHelper::check($string))
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
						if (CFactory::_('Compiler.Builder.Script.User.Switch')->inArray($type))
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
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					$string .= 'isSet(' . $value . ')';
				}
				break;
			case 5: // Unactive (empty)
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					$string .= '!isSet(' . $value . ')';
				}
				break;
			case 6: // Key Word All (case-sensitive)
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					if (ArrayHelper::check(
						$options['keywords']
					))
					{
						foreach ($options['keywords'] as $keyword)
						{
							if (StringHelper::check($string))
							{
								$string .= ' && ' . $value . '.indexOf("'
									. $keyword . '") >= 0';
							}
							else
							{
								$string .= $value . '.indexOf("' . $keyword
									. '") >= 0';
							}
						}
					}
					if (!StringHelper::check($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 7: // Key Word Any (case-sensitive)
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					if (ArrayHelper::check(
						$options['keywords']
					))
					{
						foreach ($options['keywords'] as $keyword)
						{
							if (StringHelper::check($string))
							{
								$string .= ' || ' . $value . '.indexOf("'
									. $keyword . '") >= 0';
							}
							else
							{
								$string .= $value . '.indexOf("' . $keyword
									. '") >= 0';
							}
						}
					}
					if (!StringHelper::check($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 8: // Key Word All (case-insensitive)
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					if (ArrayHelper::check(
						$options['keywords']
					))
					{
						foreach ($options['keywords'] as $keyword)
						{
							$keyword = StringHelper::safe(
								$keyword, 'w'
							);
							if (StringHelper::check($string))
							{
								$string .= ' && ' . $value
									. '.toLowerCase().indexOf("' . $keyword
									. '") >= 0';
							}
							else
							{
								$string .= $value . '.toLowerCase().indexOf("'
									. $keyword . '") >= 0';
							}
						}
					}
					if (!StringHelper::check($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 9: // Key Word Any (case-insensitive)
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					if (ArrayHelper::check(
						$options['keywords']
					))
					{
						foreach ($options['keywords'] as $keyword)
						{
							$keyword = StringHelper::safe(
								$keyword, 'w'
							);
							if (StringHelper::check($string))
							{
								$string .= ' || ' . $value
									. '.toLowerCase().indexOf("' . $keyword
									. '") >= 0';
							}
							else
							{
								$string .= $value . '.toLowerCase().indexOf("'
									. $keyword . '") >= 0';
							}
						}
					}
					if (!StringHelper::check($string))
					{
						$string .= $value . ' == "error"';
					}
				}
				break;
			case 10: // Min Length
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					if (ArrayHelper::check($options))
					{
						if ($options['length'])
						{
							$string .= $value . '.length >= '
								. (int) $options['length'];
						}
					}
					if (!StringHelper::check($string))
					{
						$string .= $value . '.length >= 5';
					}
				}
				break;
			case 11: // Max Length
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					if (ArrayHelper::check($options))
					{
						if ($options['length'])
						{
							$string .= $value . '.length <= '
								. (int) $options['length'];
						}
					}
					if (!StringHelper::check($string))
					{
						$string .= $value . '.length <= 5';
					}
				}
				break;
			case 12: // Exact Length
				// only 4 text_field
				if (CFactory::_('Field.Groups')->check($type, 'text'))
				{
					if (ArrayHelper::check($options))
					{
						if ($options['length'])
						{
							$string .= $value . '.length == '
								. (int) $options['length'];
						}
					}
					if (!StringHelper::check($string))
					{
						$string .= $value . '.length == 5';
					}
				}
				break;
		}
		if (!StringHelper::check($string))
		{
			$string = 0;
		}

		return $string;
	}

	public function getOptionsScript($type, $options)
	{
		$buket = [];
		if (StringHelper::check($options))
		{
			if (CFactory::_('Field.Groups')->check($type, 'list')
				|| CFactory::_('Field.Groups')->check($type, 'dynamic')
				|| !CFactory::_('Field.Groups')->check($type))
			{
				$optionsArray = array_map(
					'trim', (array) explode(PHP_EOL, (string) $options)
				);
				if (!ArrayHelper::check($optionsArray))
				{
					$optionsArray[] = $optionsArray;
				}
				foreach ($optionsArray as $option)
				{
					if (strpos($option, '|') !== false)
					{
						list($option) = array_map(
							'trim', (array) explode('|', $option)
						);
					}
					if ($option != 'dynamic_list')
					{
						// add option to return buket
						$buket[] = $option;
					}
				}
			}
			elseif (CFactory::_('Field.Groups')->check($type, 'text'))
			{
				// check to get the key words if set
				$keywords = GetHelper::between(
					$options, 'keywords="', '"'
				);
				if (StringHelper::check($keywords))
				{
					if (strpos((string) $keywords, ',') !== false)
					{
						$keywords = array_map(
							'trim', (array) explode(',', (string) $keywords)
						);
						foreach ($keywords as $keyword)
						{
							$buket['keywords'][] = trim($keyword);
						}
					}
					else
					{
						$buket['keywords'][] = trim((string) $keywords);
					}
				}
				// check to ket string length if set
				$length = GetHelper::between(
					$options, 'length="', '"'
				);
				if (StringHelper::check($length))
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
		$select  = '';
		$isArray = false;
		$keyName = $name . '_' . $unique;
		if ($type === 'checkboxes' || $extends === 'checkboxes')
		{
			$select  = "var " . $keyName . " = [];" . PHP_EOL . Indent::_(1)
				. "jQuery('#jform_" . $name
				. " input[type=checkbox]').each(function()" . PHP_EOL
				. Indent::_(1) . "{" . PHP_EOL . Indent::_(2)
				. "if (jQuery(this).is(':checked'))" . PHP_EOL . Indent::_(2)
				. "{" . PHP_EOL . Indent::_(3) . $keyName
				. ".push(jQuery(this).prop('value'));" . PHP_EOL . Indent::_(2)
				. "}" . PHP_EOL . Indent::_(1) . "});";
			$isArray = true;
		}
		elseif ($type === 'checkbox')
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '").prop(\'checked\');';
		}
		elseif ($type === 'radio')
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. ' input[type=\'radio\']:checked").val();';
		}
		elseif (CFactory::_('Compiler.Builder.Script.User.Switch')->inArray($type))
		{
			// this is only since 3.3.4
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '_id").val();';
		}
		elseif ($type === 'list'
			|| CFactory::_('Field.Groups')->check(
				$type, 'dynamic'
			)
			|| !CFactory::_('Field.Groups')->check($type))
		{
			$select  = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '").val();';
			$isArray = true;
		}
		elseif (CFactory::_('Field.Groups')->check($type, 'text'))
		{
			$select = 'var ' . $keyName . ' = jQuery("#jform_' . $name
				. '").val();';
		}

		return array('get' => $select, 'isArray' => $isArray);
	}

	public function clearValueScript($type, $name, $unique)
	{
		$clear   = '';
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
		elseif ($type === 'checkboxes' || $type === 'checkbox'
			|| $type === 'checkbox')
		{
			$clear = "jQuery('#jform_" . $name . "').selectedIndex = -1;";
		}

		return $clear;
	}

	public function setViewScript(&$view, $type)
	{
		if (isset($this->viewScriptBuilder[$view])
			&& isset($this->viewScriptBuilder[$view][$type]))
		{
			return $this->viewScriptBuilder[$view][$type];
		}

		return '';
	}

	public function setValidationFix($view, $Component)
	{
		$fix = '';
		if (isset($this->validationFixBuilder[$view])
			&& ArrayHelper::check(
				$this->validationFixBuilder[$view]
			))
		{
			$fix .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$fix .= PHP_EOL . Indent::_(1)
				. " * Method to validate the form data.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @param   JForm   \$form   The form to validate against.";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @param   array   \$data   The data to validate.";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @param   string  \$group  The name of the field group to validate.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1)
				. " * @return  mixed  Array of filtered data if valid, false otherwise.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1) . " * @see     JFormRule";
			$fix .= PHP_EOL . Indent::_(1) . " * @see     JFilterInput";
			$fix .= PHP_EOL . Indent::_(1) . " * @since   12.2";
			$fix .= PHP_EOL . Indent::_(1) . " */";
			$fix .= PHP_EOL . Indent::_(1)
				. "public function validate(\$form, \$data, \$group = null)";
			$fix .= PHP_EOL . Indent::_(1) . "{";
			$fix .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if the not_required field is set";
			$fix .= PHP_EOL . Indent::_(2)
				. "if (isset(\$data['not_required']) && "
				. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$data['not_required']))";
			$fix .= PHP_EOL . Indent::_(2) . "{";
			$fix .= PHP_EOL . Indent::_(3)
				. "\$requiredFields = (array) explode(',',(string) \$data['not_required']);";
			$fix .= PHP_EOL . Indent::_(3)
				. "\$requiredFields = array_unique(\$requiredFields);";
			$fix .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " now change the required field attributes value";
			$fix .= PHP_EOL . Indent::_(3)
				. "foreach (\$requiredFields as \$requiredField)";
			$fix .= PHP_EOL . Indent::_(3) . "{";
			$fix .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " make sure there is a string value";
			$fix .= PHP_EOL . Indent::_(4) . "if ("
				. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$requiredField))";
			$fix .= PHP_EOL . Indent::_(4) . "{";
			$fix .= PHP_EOL . Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " change to false";
			$fix .= PHP_EOL . Indent::_(5)
				. "\$form->setFieldAttribute(\$requiredField, 'required', 'false');";
			$fix .= PHP_EOL . Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " also clear the data set";
			$fix .= PHP_EOL . Indent::_(5) . "\$data[\$requiredField] = '';";
			$fix .= PHP_EOL . Indent::_(4) . "}";
			$fix .= PHP_EOL . Indent::_(3) . "}";
			$fix .= PHP_EOL . Indent::_(2) . "}";
			$fix .= PHP_EOL . Indent::_(2)
				. "return parent::validate(\$form, \$data, \$group);";
			$fix .= PHP_EOL . Indent::_(1) . "}";
		}

		return $fix;
	}

	public function setAjaxToke(&$view)
	{
		$fix = '';
		if (isset(CFactory::_('Customcode.Dispenser')->hub['token'][$view])
			&& CFactory::_('Customcode.Dispenser')->hub['token'][$view])
		{
			$fix .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Add Ajax Token";
			$fix .= PHP_EOL . Indent::_(2)
				. "\$this->getDocument()->addScriptDeclaration(\"var token = '\" . Session::getFormToken() . \"';\");";
		}

		return $fix;
	}

	public function setRegisterAjaxTask($target)
	{
		$tasks = '';
		if (isset(CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_controller'])
			&& ArrayHelper::check(
				CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_controller']
			))
		{
			$taskArray = [];
			foreach (
				CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_controller'] as $view
			)
			{
				foreach ($view as $task)
				{
					$taskArray[$task['task_name']] = $task['task_name'];
				}
			}
			if (ArrayHelper::check($taskArray))
			{
				foreach ($taskArray as $name)
				{
					$tasks .= PHP_EOL . Indent::_(2) . "\$this->registerTask('"
						. $name . "', 'ajax');";
				}
			}
		}

		return $tasks;
	}

	public function setAjaxInputReturn($target)
	{
		$cases = '';
		if (isset(CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_controller'])
			&& ArrayHelper::check(
				CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_controller']
			))
		{
			$input      = [];
			$valueArray = [];
			$ifArray    = [];
			$getModel   = [];
			$userCheck  = [];
			$prefix     = ($target == 'site') ? 'Site':'Administrator';
			$isJoomla3  = (CFactory::_('Config')->get('joomla_version', 3) == 3);
			$failed     = "false";
			if (!$isJoomla3)
			{
				$failed = "['error' => 'There was an error! [149]']";
			}
			foreach (
				CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_controller'] as $view
			)
			{
				foreach ($view as $task)
				{
					$input[$task['task_name']][]      = "\$"
						. $task['value_name'] . "Value = \$jinput->get('"
						. $task['value_name'] . "', " . $task['input_default']
						. ", '" . $task['input_filter'] . "');";
					$valueArray[$task['task_name']][] = "\$"
						. $task['value_name'] . "Value";
					$getModel[$task['task_name']] =
						"\$result = \$ajaxModule->"
						. $task['method_name'] . "(" . Placefix::_("valueArray") . ");";
					// check if null or zero is allowed
					if (!isset($task['allow_zero']) || 1 != $task['allow_zero'])
					{
						$ifArray[$task['task_name']][] = "\$"
							. $task['value_name'] . "Value";
					}
					// see user check is needed
					if (!isset($userCheck[$task['task_name']])
						&& isset($task['user_check'])
						&& 1 == $task['user_check'])
					{
						// add it since this means it was not set, and in the old method we assumed it was inplace
						// or it is set and 1 means we still want it inplace
						$ifArray[$task['task_name']][] = '$user->id != 0';
						// add it only once
						$userCheck[$task['task_name']] = true;
					}
				}
			}
			if (ArrayHelper::check($getModel))
			{
				foreach ($getModel as $task => $getMethod)
				{
					$cases .= PHP_EOL . Indent::_(4) . "case '" . $task . "':";
					$cases .= PHP_EOL . Indent::_(5) . "try";
					$cases .= PHP_EOL . Indent::_(5) . "{";
					foreach ($input[$task] as $string)
					{
						$cases .= PHP_EOL . Indent::_(6) . $string;
					}
					// set the values
					$values = implode(', ', $valueArray[$task]);
					// set the values to method
					$getMethod = str_replace(
						Placefix::_('valueArray'), $values,
						$getMethod
					);
					// check if we have some values to check
					if (isset($ifArray[$task])
						&& ArrayHelper::check($ifArray[$task]))
					{
						// set if string
						$ifvalues = implode(' && ', $ifArray[$task]);
						// add to case
						$cases .= PHP_EOL . Indent::_(6) . "if(" . $ifvalues
							. ")";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						if ($isJoomla3)
						{
							$cases .= PHP_EOL . Indent::_(7) . "\$ajaxModule = \$this->getModel('ajax');";
						}
						else
						{
							$cases .= PHP_EOL . Indent::_(7) . "\$ajaxModule = \$this->getModel('ajax', '$prefix');";
						}
						$cases .= PHP_EOL . Indent::_(7) . "if (\$ajaxModule)";
						$cases .= PHP_EOL . Indent::_(7) . "{";
						$cases .= PHP_EOL . Indent::_(8) . $getMethod;
						$cases .= PHP_EOL . Indent::_(7) . "}";
						$cases .= PHP_EOL . Indent::_(7) . "else";
						$cases .= PHP_EOL . Indent::_(7) . "{";
						$cases .= PHP_EOL . Indent::_(8) . "\$result = $failed;";
						$cases .= PHP_EOL . Indent::_(7) . "}";
						$cases .= PHP_EOL . Indent::_(6) . "}";
						$cases .= PHP_EOL . Indent::_(6) . "else";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						$cases .= PHP_EOL . Indent::_(7) . "\$result = $failed;";
						$cases .= PHP_EOL . Indent::_(6) . "}";
					}
					else
					{
						if ($isJoomla3)
						{
							$cases .= PHP_EOL . Indent::_(6) . "\$ajaxModule = \$this->getModel('ajax');";
						}
						else
						{
							$cases .= PHP_EOL . Indent::_(6) . "\$ajaxModule = \$this->getModel('ajax', '$prefix');";
						}
						$cases .= PHP_EOL . Indent::_(6) . "if (\$ajaxModule)";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						$cases .= PHP_EOL . Indent::_(7) . $getMethod;
						$cases .= PHP_EOL . Indent::_(6) . "}";
						$cases .= PHP_EOL . Indent::_(6) . "else";
						$cases .= PHP_EOL . Indent::_(6) . "{";
						$cases .= PHP_EOL . Indent::_(7) . "\$result = $failed;";
						$cases .= PHP_EOL . Indent::_(6) . "}";
					}
					// continue the build
					$cases .= PHP_EOL . Indent::_(6)
						. "if(\$callback)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \$callback . \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6) . "elseif(\$returnRaw)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo json_encode(\$result);";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6) . "else";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \"(\".json_encode(\$result).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(5) . "}";
					$cases .= PHP_EOL . Indent::_(5) . "catch(\Exception \$e)";
					$cases .= PHP_EOL . Indent::_(5) . "{";
					$cases .= PHP_EOL . Indent::_(6)
						. "if(\$callback)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \$callback.\"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6)
						. "elseif(\$returnRaw)";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo json_encode(\$e);";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(6) . "else";
					$cases .= PHP_EOL . Indent::_(6) . "{";
					$cases .= PHP_EOL . Indent::_(7)
						. "echo \"(\".json_encode(\$e).\");\";";
					$cases .= PHP_EOL . Indent::_(6) . "}";
					$cases .= PHP_EOL . Indent::_(5) . "}";
					$cases .= PHP_EOL . Indent::_(4) . "break;";
				}
			}
		}

		return $cases;
	}

	public function setAjaxModelMethods($target)
	{
		$methods = '';
		if (isset(CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_model'])
			&& ArrayHelper::check(
				CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_model']
			))
		{
			foreach (
				CFactory::_('Customcode.Dispenser')->hub[$target]['ajax_model'] as $view =>
				$method
			)
			{
				$methods .= PHP_EOL . PHP_EOL . Indent::_(1) . "//"
					. Line::_(__Line__, __Class__) . " Used in " . $view . PHP_EOL;
				$methods .= CFactory::_('Placeholder')->update_(
					$method
				);
			}
		}

		return $methods;
	}

	public function setJquery(&$view)
	{
		$addJQuery = '';
		if (true) // TODO we just add it everywhere for now.
		{
			$addJQuery .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Load jQuery";
			$addJQuery .= PHP_EOL . Indent::_(2) . "Html::_('jquery.framework');";
		}

		return $addJQuery;
	}

	/**
	 * build filter functions
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 */
	public function setFilterFieldHelper(&$nameSingleCode, &$nameListCode)
	{
		// the old filter type uses these functions
		if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
		{
			// set the function or file path (2 = topbar)
			$funtion_path = true;
			if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
			{
				$funtion_path = false;
			}
			$function = [];
			// set component name
			$component = CFactory::_('Config')->component_code_name;
			$Component = ucfirst((string) $component);
			foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $filter)
			{
				if ($filter['type'] != 'category'
					&& ArrayHelper::check($filter['custom'])
					&& $filter['custom']['extends'] === 'user')
				{
					// add if this is a function path
					if ($funtion_path)
					{
						$function[] = PHP_EOL . Indent::_(1)
							. "protected function getThe" . $filter['function']
							. StringHelper::safe(
								$filter['custom']['text'], 'F'
							) . "Selections()";
						$function[] = Indent::_(1) . "{";
					}
					$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
						. " Get a db connection.";
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						$function[] = Indent::_(2) . "\$db = Factory::getDbo();";
					}
					else
					{
						$function[] = Indent::_(2) . "\$db = Factory::getContainer()->get(\Joomla\Database\DatabaseInterface::class);";
					}
					$function[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Create a new query object.";
					$function[] = Indent::_(2)
						. "\$query = \$db->getQuery(true);";
					$function[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Select the text.";
					$function[] = Indent::_(2)
						. "\$query->select(\$db->quoteName(array('a."
						. $filter['custom']['id'] . "','a."
						. $filter['custom']['text'] . "')));";
					$function[] = Indent::_(2)
						. "\$query->from(\$db->quoteName('"
						. $filter['custom']['table'] . "', 'a'));";
					$function[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
						. " get the targeted groups";
					$function[] = Indent::_(2)
						. "\$groups= ComponentHelper::getParams('com_"
						. $component . "')->get('" . $filter['type'] . "');";
					$function[] = Indent::_(2)
						. "if (!empty(\$groups) && count((array) \$groups) > 0)";
					$function[] = Indent::_(2) . "{";
					$function[] = Indent::_(3)
						. "\$query->join('LEFT', \$db->quoteName('#__user_usergroup_map', 'group') . ' ON (' . \$db->quoteName('group.user_id') . ' = ' . \$db->quoteName('a.id') . ')');";
					$function[] = Indent::_(3)
						. "\$query->where('group.group_id IN (' . implode(',', \$groups) . ')');";
					$function[] = Indent::_(2) . "}";
					$function[] = Indent::_(2) . "\$query->order('a."
						. $filter['custom']['text'] . " ASC');";
					$function[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Reset the query using our newly populated query object.";
					$function[] = Indent::_(2) . "\$db->setQuery(\$query);";
					$function[] = PHP_EOL . Indent::_(2)
						. "\$results = \$db->loadObjectList();";
					$function[] = Indent::_(2) . "\$_filter = [];";
					// if this is not a multi field
					if (!$funtion_path && $filter['multi'] == 1)
					{
						$function[] = Indent::_(2)
							. "\$_filter[] = Html::_('select.option', '', '- Select ' . Text:"
							. ":_('" . $filter['lang'] . "') . ' -');";
					}
					$function[] = Indent::_(2) . "if (\$results)";
					$function[] = Indent::_(2) . "{";
					$function[] = Indent::_(3)
						. "foreach (\$results as \$result)";
					$function[] = Indent::_(3) . "{";
					$function[] = Indent::_(4)
						. "\$_filter[] = Html::_('select.option', \$result->"
						. $filter['custom']['id'] . ", \$result->"
						. $filter['custom']['text'] . ");";
					$function[] = Indent::_(3) . "}";
					$function[] = Indent::_(2) . "}";
					$function[] = Indent::_(2) . "return  \$_filter;";
					// add if this is a function path
					if ($funtion_path)
					{
						$function[] = Indent::_(1) . "}";
					}

					/* else
					  {
					  $function[] = PHP_EOL.Indent::_(1) . "protected function getThe".$filter['function'].StringHelper::safe($filter['custom']['text'],'F')."Selections()";
					  $function[] = Indent::_(1) . "{";
					  $function[] = Indent::_(2) . "//".Line::_(__Line__, __Class__)." Get a db connection.";
					  $function[] = Indent::_(2) . "\$db = Factory::getDbo();";
					  $function[] = PHP_EOL.Indent::_(2) . "//".Line::_(__Line__, __Class__)." Select the text.";
					  $function[] = Indent::_(2) . "\$query = \$db->getQuery(true);";
					  $function[] = PHP_EOL.Indent::_(2) . "//".Line::_(__Line__, __Class__)." Select the text.";
					  $function[] = Indent::_(2) . "\$query->select(\$db->quoteName(array('".$filter['custom']['id']."','".$filter['custom']['text']."')));";
					  $function[] = Indent::_(2) . "\$query->from(\$db->quoteName('".$filter['custom']['table']."'));";
					  $function[] = Indent::_(2) . "\$query->where(\$db->quoteName('published') . ' = 1');";
					  $function[] = Indent::_(2) . "\$query->order(\$db->quoteName('".$filter['custom']['text']."') . ' ASC');";
					  $function[] = PHP_EOL.Indent::_(2) . "//".Line::_(__Line__, __Class__)." Reset the query using our newly populated query object.";
					  $function[] = Indent::_(2) . "\$db->setQuery(\$query);";
					  $function[] = PHP_EOL.Indent::_(2) . "\$results = \$db->loadObjectList();";
					  $function[] = PHP_EOL.Indent::_(2) . "if (\$results)";
					  $function[] = Indent::_(2) . "{";
					  $function[] = Indent::_(3) . "\$filter = [];";
					  $function[] = Indent::_(3) . "\$batch = [];";
					  $function[] = Indent::_(3) . "foreach (\$results as \$result)";
					  $function[] = Indent::_(3) . "{";
					  if ($filter['custom']['text'] === 'user')
					  {
					  $function[] = Indent::_(4) . "\$filter[] = Html::_('select.option', \$result->".$filter['custom']['text'].", Factory::getUser(\$result->".$filter['custom']['text'].")->name);";
					  $function[] = Indent::_(4) . "\$batch[] = Html::_('select.option', \$result->".$filter['custom']['id'].", Factory::getUser(\$result->".$filter['custom']['text'].")->name);";
					  }
					  else
					  {
					  $function[] = Indent::_(4) . "\$filter[] = Html::_('select.option', \$result->".$filter['custom']['text'].", \$result->".$filter['custom']['text'].");";
					  $function[] = Indent::_(4) . "\$batch[] = Html::_('select.option', \$result->".$filter['custom']['id'].", \$result->".$filter['custom']['text'].");";
					  }
					  $function[] = Indent::_(3) . "}";
					  $function[] = Indent::_(3) . "return array('filter' => \$filter, 'batch' => \$batch);";
					  $function[] = Indent::_(2) . "}";
					  $function[] = Indent::_(2) . "return false;";
					  $function[] = Indent::_(1) . "}";
					  } */
				}
				elseif ($filter['type'] != 'category'
					&& !ArrayHelper::check($filter['custom']))
				{
					$translation = false;
					if (CFactory::_('Compiler.Builder.Selection.Translation')->
						exists($nameListCode . '.' . $filter['code']))
					{
						$translation = true;
					}
					// add if this is a function path
					if ($funtion_path)
					{
						$function[] = PHP_EOL . Indent::_(1)
							. "protected function getThe" . $filter['function']
							. "Selections()";
						$function[] = Indent::_(1) . "{";
						$function[] = Indent::_(2) . "//" . Line::_(
								__LINE__,__CLASS__
							)
							. " Get a db connection.";
					}
					else
					{
						$function[] = "//" . Line::_(__Line__, __Class__)
							. " Get a db connection.";
					}
					if (CFactory::_('Config')->get('joomla_version', 3) == 3)
					{
						$function[] = Indent::_(2) . "\$db = Factory::getDbo();";
					}
					else
					{
						$function[] = Indent::_(2) . "\$db = Factory::getContainer()->get(\Joomla\Database\DatabaseInterface::class);";
					}
					$function[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Create a new query object.";
					$function[] = Indent::_(2)
						. "\$query = \$db->getQuery(true);";

					// check if usergroup as we change to an object query
					if ($filter['type'] === 'usergroup' || $filter['type'] === 'usergrouplist')
					{
						$function[] = PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__) . " Select the text.";
						$function[] = Indent::_(2)
							. "\$query->select(\$db->quoteName('g."
							. $filter['code'] . "', 'id'));";
						$function[] = Indent::_(2)
							. "\$query->select(\$db->quoteName('ug.title', 'title'));";
						$function[] = Indent::_(2)
							. "\$query->from(\$db->quoteName('#__" . $component
							. "_" . $filter['database'] . "', 'g'));";
						$function[] = Indent::_(2)
							. "\$query->join('LEFT', \$db->quoteName('#__usergroups', 'ug') . ' ON (' . (\$db->quoteName('g."
							. $filter['code']
							. "') . ' = ' . \$db->quoteName('ug.id') . ')'));";
						$function[] = Indent::_(2)
							. "\$query->order(\$db->quoteName('title') . ' ASC');";
						$function[] = Indent::_(2)
							. "\$query->group(\$db->quoteName('ug.id'));";
						$function[] = PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__)
							. " Reset the query using our newly populated query object.";
						$function[] = Indent::_(2) . "\$db->setQuery(\$query);";
						$function[] = PHP_EOL . Indent::_(2)
							. "\$_results = \$db->loadObjectList();";
					}
					else
					{
						$function[] = PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__) . " Select the text.";
						$function[] = Indent::_(2)
							. "\$query->select(\$db->quoteName('"
							. $filter['code'] . "'));";
						$function[] = Indent::_(2)
							. "\$query->from(\$db->quoteName('#__" . $component
							. "_" . $filter['database'] . "'));";
						$function[] = Indent::_(2)
							. "\$query->order(\$db->quoteName('"
							. $filter['code'] . "') . ' ASC');";
						$function[] = PHP_EOL . Indent::_(2) . "//"
							. Line::_(__Line__, __Class__)
							. " Reset the query using our newly populated query object.";
						$function[] = Indent::_(2) . "\$db->setQuery(\$query);";
						$function[] = PHP_EOL . Indent::_(2)
							. "\$_results = \$db->loadColumn();";
					}
					$function[] = Indent::_(2) . "\$_filter = [];";
					// if this is not a multi field
					if (!$funtion_path && $filter['multi'] == 1)
					{
						$function[] = Indent::_(2)
							. "\$_filter[] = Html::_('select.option', '', '- ' . Text:"
							. ":_('" . $filter['lang_select'] . "') . ' -');";
					}
					$function[] = PHP_EOL . Indent::_(2) . "if (\$_results)";
					$function[] = Indent::_(2) . "{";

					// check if translated value is used
					if ($funtion_path && $translation)
					{
						$function[] = Indent::_(3) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " get model";
						$function[] = Indent::_(3)
							. "\$_model = \$this->getModel();";
					}
					elseif ($translation)
					{
						$function[] = Indent::_(3) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " get " . $nameListCode . "model";
						$function[] = Indent::_(3)
							. "\$_model = " . $Component . "Helper::getModel('"
							. $nameListCode . "');";
					}
					// check if usergroup as we change to an object query
					if ($filter['type'] !== 'usergroup' && $filter['type'] !== 'usergrouplist')
					{
						$function[] = Indent::_(3)
							. "\$_results = array_unique(\$_results);";
					}
					$function[] = Indent::_(3) . "foreach (\$_results as \$"
						. $filter['code'] . ")";
					$function[] = Indent::_(3) . "{";

					// check if translated value is used
					if ($translation)
					{
						$function[] = Indent::_(4) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " Translate the " . $filter['code']
							. " selection";
						$function[] = Indent::_(4)
							. "\$_text = \$_model->selectionTranslation(\$"
							. $filter['code'] . ",'" . $filter['code'] . "');";
						$function[] = Indent::_(4) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " Now add the " . $filter['code']
							. " and its text to the options array";
						$function[] = Indent::_(4)
							. "\$_filter[] = Html::_('select.option', \$"
							. $filter['code'] . ", Text:" . ":_(\$_text));";
					}
					elseif ($filter['type'] === 'user')
					{
						$function[] = Indent::_(4) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " Now add the " . $filter['code']
							. " and its text to the options array";
						if (CFactory::_('Config')->get('joomla_version', 3) == 3)
						{
							$function[] = Indent::_(4)
								. "\$_filter[] = Html::_('select.option', \$"
								. $filter['code'] . ", Factory::getUser(\$"
								. $filter['code'] . ")->name);";
						}
						else
						{
							$function[] = Indent::_(4)
								. "\$_filter[] = Html::_('select.option', \$"
								. $filter['code'] . ",";
							$function[] = Indent::_(5)
								. "Factory::getContainer()->";
								$function[] = Indent::_(5)
									. "get(\Joomla\CMS\User\UserFactoryInterface::class)->";
								$function[] = Indent::_(5)
									. "loadUserById(\$"
									. $filter['code'] . ")->name";
								$function[] = Indent::_(5)
									. ");";
							}
					}
					else
					{
						if ($filter['type'] === 'usergroup' || $filter['type'] === 'usergrouplist')
						{
							$function[] = Indent::_(4) . "//" . Line::_(
									__LINE__,__CLASS__
								) . " Now add the " . $filter['code']
								. " and its text to the options array";
							$function[] = Indent::_(4)
								. "\$_filter[] = Html::_('select.option', \$"
								. $filter['code'] . "->id, \$" . $filter['code']
								. "->title);";
						}
						else
						{
							$function[] = Indent::_(4) . "//" . Line::_(
									__LINE__,__CLASS__
								) . " Now add the " . $filter['code']
								. " and its text to the options array";
							$function[] = Indent::_(4)
								. "\$_filter[] = Html::_('select.option', \$"
								. $filter['code'] . ", \$" . $filter['code']
								. ");";
						}
					}
					$function[] = Indent::_(3) . "}";
					$function[] = Indent::_(2) . "}";
					$function[] = Indent::_(2) . "return \$_filter;";
					// add if this is a function path
					if ($funtion_path)
					{
						$function[] = Indent::_(1) . "}";
					}
				}
				// we check if this is a multi field
				// and if there is a blank option
				// and give a notice that this will cause an issue
				elseif (!$funtion_path && $filter['type'] != 'category'
					&& $filter['multi'] == 2
					&& ArrayHelper::check($filter['custom']))
				{
					// get the field code
					$field_code = $this->getCustomFieldCode(
						$filter['custom']
					)['JFORM_TYPE_PHP'];
					// check for the [Html::_('select.option', '',] code
					if (strpos((string) $field_code, "Html::_('select.option', '',")
						!== false
						&& strpos((string) $field_code, '($this->multiple === false)')
						=== false)
					{
						// for now we just give an error message (don't fix it)
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREEMULTI_FILTER_ERRORHTHREE'),
							'Error'
						);
						$field_url
							= '"index.php?option=com_componentbuilder&view=fields&task=field.edit&id='
							. $filter['id'] . '" target="_blank"';
						$field_fix
							= "<pre>if (\$this->multiple === false) { // <-- this if statement is needed";
						$field_fix .= PHP_EOL . Indent::_(1)
							. "\$options[] = Html::_('select.option', '', 'Select an option'); // <-- the empty option";
						$field_fix .= PHP_EOL . "}</pre>";
						$this->app->enqueueMessage(
							Text::sprintf(
								'We detected that you have an empty option in a <a href=%s>custom field (%s)</a> that is used in a multi filter.<br />This will cause a problem, you will need to add the following code to it.<br />%s',
								$field_url,
								$filter['code'],
								$field_fix
							), 'Error'
						);
					}
				}
				// divert the code to a file if this is not a funtion path
				if (!$funtion_path
					&& ArrayHelper::check(
						$function
					))
				{
					// set the filter file
					$this->setFilterFieldFile(
						implode(PHP_EOL, $function), $filter
					);
					// clear the filter out
					$function = [];
				}
			}
			// if this is a function path, return the function if set
			if ($funtion_path && ArrayHelper::check($function))
			{
				// return the function
				return PHP_EOL . implode(PHP_EOL, $function);
			}
		}

		return '';
	}

	public function setUniqueFields(&$view)
	{
		$fields   = [];
		$fields[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$fields[] = Indent::_(1)
			. " * Method to get the unique fields of this table.";
		$fields[] = Indent::_(1) . " *";
		$fields[] = Indent::_(1)
			. " * @return  mixed  An array of field names, boolean false if none is set.";
		$fields[] = Indent::_(1) . " *";
		$fields[] = Indent::_(1) . " * @since   3.0";
		$fields[] = Indent::_(1) . " */";
		$fields[] = Indent::_(1) . "protected function getUniqueFields()";
		$fields[] = Indent::_(1) . "{";
		if (CFactory::_('Compiler.Builder.Database.Unique.Keys')->exists($view))
		{
			// if guid should also be added
			if (CFactory::_('Compiler.Builder.Database.Unique.Guid')->exists($view))
			{
				$fields[] = Indent::_(2) . "return array('" . implode(
						"','", CFactory::_('Compiler.Builder.Database.Unique.Keys')->get($view)
					) . "', 'guid');";
			}
			else
			{
				$fields[] = Indent::_(2) . "return array('" . implode(
						"','", CFactory::_('Compiler.Builder.Database.Unique.Keys')->get($view)
					) . "');";
			}
		}
		// if only GUID is found
		elseif (CFactory::_('Compiler.Builder.Database.Unique.Guid')->exists($view))
		{
			$fields[] = Indent::_(2) . "return array('guid');";
		}
		else
		{
			$fields[] = Indent::_(2) . "return false;";
		}
		$fields[] = Indent::_(1) . "}";

		// return the unique fields
		return implode(PHP_EOL, $fields);
	}

	/**
	 * build sidebar filter loading scripts
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 */
	public function setFilterFieldSidebarDisplayHelper(&$nameSingleCode,
	                                                   &$nameListCode
	)
	{
		// start the filter bucket
		$fieldFilters = [];
		// add the default filter
		$this->setDefaultSidebarFilterHelper(
			$fieldFilters, $nameSingleCode, $nameListCode
		);
		// add the category filter stuff
		$this->setCategorySidebarFilterHelper($fieldFilters, $nameListCode);
		// check if filter fields are added (1 = sidebar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1
			&& CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
		{
			// get component name
			$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
			// load the rest of the filters
			foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $filter)
			{
				if ($filter['type'] != 'category'
					&& ArrayHelper::check($filter['custom'])
					&& $filter['custom']['extends'] !== 'user')
				{
					$CodeName       = StringHelper::safe(
						$filter['code'] . ' ' . $filter['custom']['text'], 'W'
					);
					$codeName       = $filter['code']
						. StringHelper::safe(
							$filter['custom']['text'], 'F'
						);
					$type           = StringHelper::safe(
						$filter['custom']['type'], 'F'
					);
					$fieldFilters[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Set " . $CodeName
						. " Selection";
					$fieldFilters[] = Indent::_(2) . "\$this->" . $codeName
						. "Options = FormHelper::loadFieldType('" . $type
						. "')->options;";
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " We do some sanitation for " . $CodeName
						. " filter";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $codeName
						. "Options) &&";
					$fieldFilters[] = Indent::_(3) . "isset(\$this->"
						. $codeName
						. "Options[0]->value) &&";
					$fieldFilters[] = Indent::_(3) . "!"
						. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $codeName
						. "Options[0]->value))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "unset(\$this->"
						. $codeName
						. "Options[0]);";
					$fieldFilters[] = Indent::_(2) . "}";
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Only load " . $CodeName
						. " filter if it has values";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $codeName
						. "Options))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $CodeName . " Filter";
					$fieldFilters[] = Indent::_(3) . "\JHtmlSidebar::addFilter(";
					$fieldFilters[] = Indent::_(4) . "'- Select ' . Text:"
						. ":_('" . $filter['lang'] . "') . ' -',";
					$fieldFilters[] = Indent::_(4) . "'filter_"
						. $filter['code']
						. "',";
					$fieldFilters[] = Indent::_(4)
						. "Html::_('select.options', \$this->" . $codeName
						. "Options, 'value', 'text', \$this->state->get('filter."
						. $filter['code'] . "'))";
					$fieldFilters[] = Indent::_(3) . ");";
					$fieldFilters[] = Indent::_(2) . "}";
				}
				elseif ($filter['type'] != 'category')
				{
					$Codename = StringHelper::safe(
						$filter['code'], 'W'
					);
					if (isset($filter['custom'])
						&& ArrayHelper::check($filter['custom'])
						&& $filter['custom']['extends'] === 'user')
					{
						$functionName = "\$this->getThe" . $filter['function']
							. StringHelper::safe(
								$filter['custom']['text'], 'F'
							) . "Selections();";
					}
					else
					{
						$functionName = "\$this->getThe" . $filter['function']
							. "Selections();";
					}
					$fieldFilters[] = PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__) . " Set " . $Codename
						. " Selection";
					$fieldFilters[] = Indent::_(2) . "\$this->"
						. $filter['code']
						. "Options = " . $functionName;
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " We do some sanitation for " . $Codename
						. " filter";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $filter['code']
						. "Options) &&";
					$fieldFilters[] = Indent::_(3) . "isset(\$this->"
						. $filter['code'] . "Options[0]->value) &&";
					$fieldFilters[] = Indent::_(3) . "!"
						. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $filter['code']
						. "Options[0]->value))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "unset(\$this->"
						. $filter['code'] . "Options[0]);";
					$fieldFilters[] = Indent::_(2) . "}";
					$fieldFilters[] = Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Only load " . $Codename
						. " filter if it has values";
					$fieldFilters[] = Indent::_(2) . "if ("
						. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $filter['code']
						. "Options))";
					$fieldFilters[] = Indent::_(2) . "{";
					$fieldFilters[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $Codename . " Filter";
					$fieldFilters[] = Indent::_(3) . "\JHtmlSidebar::addFilter(";
					$fieldFilters[] = Indent::_(4) . "'- Select '.Text:"
						. ":_('" . $filter['lang'] . "').' -',";
					$fieldFilters[] = Indent::_(4) . "'filter_"
						. $filter['code']
						. "',";
					$fieldFilters[] = Indent::_(4)
						. "Html::_('select.options', \$this->"
						. $filter['code']
						. "Options, 'value', 'text', \$this->state->get('filter."
						. $filter['code'] . "'))";
					$fieldFilters[] = Indent::_(3) . ");";

					$fieldFilters[] = Indent::_(2) . "}";
				}
			}
		}
		// did we find filters
		if (ArrayHelper::check($fieldFilters))
		{
			// return the filter
			return PHP_EOL . implode(PHP_EOL, $fieldFilters);
		}

		return '';
	}

	/**
	 * add default filter helper
	 *
	 * @param   array   $filter          The batch code array
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  void
	 *
	 */
	protected function setDefaultSidebarFilterHelper(&$filter, &$nameSingleCode,
	                                                 &$nameListCode
	)
	{
		// add the default filters if we are on the old filter paths (1 = sidebar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1)
		{
			// set batch
			$filter[] = PHP_EOL . Indent::_(2)
				. "//" . Line::_(__Line__, __Class__)
				. " Only load publish filter if state change is allowed";
			$filter[] = Indent::_(2)
				. "if (\$this->canState)";
			$filter[] = Indent::_(2) . "{";
			$filter[] = Indent::_(3) . "\JHtmlSidebar::addFilter(";
			$filter[] = Indent::_(4) . "Text:"
				. ":_('JOPTION_SELECT_PUBLISHED'),";
			$filter[] = Indent::_(4) . "'filter_published',";
			$filter[] = Indent::_(4)
				. "Html::_('select.options', Html::_('jgrid.publishedOptions'), 'value', 'text', \$this->state->get('filter.published'), true)";
			$filter[] = Indent::_(3) . ");";
			$filter[] = Indent::_(2) . "}";
			// check if view has access
			if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode)
				&& !CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
			{
				$filter[] = PHP_EOL . Indent::_(2) . "\JHtmlSidebar::addFilter(";
				$filter[] = Indent::_(3) . "Text:"
					. ":_('JOPTION_SELECT_ACCESS'),";
				$filter[] = Indent::_(3) . "'filter_access',";
				$filter[] = Indent::_(3)
					. "Html::_('select.options', Html::_('access.assetgroups'), 'value', 'text', \$this->state->get('filter.access'))";
				$filter[] = Indent::_(2) . ");";
			}
		}
	}

	/**
	 * build category sidebar display filter helper
	 *
	 * @param   array   $filter        The filter code array
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  void
	 *
	 */
	protected function setCategorySidebarFilterHelper(&$filter, &$nameListCode)
	{
		// add the category filter if we are on the old filter paths (1 = sidebar)
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1
			&& CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.extension")
			&& CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.filter", 0) >= 1)
		{
			// set filter
			$filter[] = PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Category Filter.";
			$filter[] = Indent::_(2) . "\JHtmlSidebar::addFilter(";
			$filter[] = Indent::_(3) . "Text:"
				. ":_('JOPTION_SELECT_CATEGORY'),";
			$filter[] = Indent::_(3) . "'filter_category_id',";
			$filter[] = Indent::_(3)
				. "Html::_('select.options', Html::_('category.options', '"
				. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension")
				. "'), 'value', 'text', \$this->state->get('filter.category_id'))";
			$filter[] = Indent::_(2) . ");";
		}
	}

	/**
	 * build batch loading helper scripts
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The php to place in view.html.php
	 *
	 */
	public function setBatchDisplayHelper(&$nameSingleCode, &$nameListCode)
	{
		// temp fix
		if (CFactory::_('Config')->get('joomla_version', 3) != 3)
		{
			return '';
		}

		// start the batch bucket
		$fieldBatch = [];
		// add the default batch
		$this->setDefaultBatchHelper($fieldBatch, $nameSingleCode);
		// add the category filter stuff
		$this->setCategoryBatchHelper($fieldBatch, $nameListCode);
		// check if we have other batch options to add
		if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
		{
			// check if we should add some help to get the values (2 = topbar)
			$get_values = false;
			if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
			{
				// since the old path is not used, we need to add those values here
				$get_values = true;
			}
			// get component name
			$Component = CFactory::_('Compiler.Builder.Content.One')->get('Component');
			// load the rest of the batch options
			foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $filter)
			{
				if ($filter['type'] != 'category'
					&& ArrayHelper::check($filter['custom'])
					&& $filter['custom']['extends'] !== 'user')
				{
					$CodeName     = StringHelper::safe(
						$filter['code'] . ' ' . $filter['custom']['text'], 'W'
					);
					$codeName     = $filter['code']
						. StringHelper::safe(
							$filter['custom']['text'], 'F'
						);
					$fieldBatch[] = PHP_EOL . Indent::_(2)
						. "//" . Line::_(__Line__, __Class__)
						. " Only load " . $CodeName
						. " batch if create, edit, and batch is allowed";
					$fieldBatch[] = Indent::_(2)
						. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$fieldBatch[] = Indent::_(2) . "{";
					// add the get values here
					if ($get_values)
					{
						$type         = StringHelper::safe(
							$filter['custom']['type'], 'F'
						);
						$fieldBatch[] = Indent::_(3) . "//"
							. Line::_(__Line__, __Class__) . " Set " . $CodeName
							. " Selection";
						$fieldBatch[] = Indent::_(3) . "\$this->" . $codeName
							. "Options = FormHelper::loadFieldType('" . $type
							. "')->options;";
						$fieldBatch[] = Indent::_(3) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " We do some sanitation for " . $CodeName
							. " filter";
						$fieldBatch[] = Indent::_(3) . "if ("
							. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $codeName
							. "Options) &&";
						$fieldBatch[] = Indent::_(4) . "isset(\$this->"
							. $codeName
							. "Options[0]->value) &&";
						$fieldBatch[] = Indent::_(4) . "!"
							. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $codeName
							. "Options[0]->value))";
						$fieldBatch[] = Indent::_(3) . "{";
						$fieldBatch[] = Indent::_(4) . "unset(\$this->"
							. $codeName
							. "Options[0]);";
						$fieldBatch[] = Indent::_(3) . "}";
					}
					$fieldBatch[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $CodeName . " Batch Selection";
					$fieldBatch[] = Indent::_(3)
						. "JHtmlBatch_::addListSelection(";
					$fieldBatch[] = Indent::_(4) . "'- Keep Original '.Text:"
						. ":_('" . $filter['lang'] . "').' -',";
					$fieldBatch[] = Indent::_(4) . "'batch[" . $filter['code']
						. "]',";
					$fieldBatch[] = Indent::_(4)
						. "Html::_('select.options', \$this->" . $codeName
						. "Options, 'value', 'text')";
					$fieldBatch[] = Indent::_(3) . ");";
					$fieldBatch[] = Indent::_(2) . "}";
				}
				elseif ($filter['type'] != 'category')
				{
					$CodeName = StringHelper::safe(
						$filter['code'], 'W'
					);

					$fieldBatch[] = PHP_EOL . Indent::_(2)
						. "//" . Line::_(__Line__, __Class__)
						. " Only load " . $CodeName
						. " batch if create, edit, and batch is allowed";
					$fieldBatch[] = Indent::_(2)
						. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
					$fieldBatch[] = Indent::_(2) . "{";
					// add the get values here
					if ($get_values)
					{
						$fieldBatch[] = Indent::_(3) . "//"
							. Line::_(__Line__, __Class__) . " Set " . $CodeName
							. " Selection";
						$fieldBatch[] = Indent::_(3) . "\$this->"
							. $filter['code']
							. "Options = FormHelper::loadFieldType('"
							. $filter['filter_type']
							. "')->options;";
						$fieldBatch[] = Indent::_(3) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " We do some sanitation for " . $CodeName
							. " filter";
						$fieldBatch[] = Indent::_(3) . "if ("
							. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->" . $filter['code']
							. "Options) &&";
						$fieldBatch[] = Indent::_(4) . "isset(\$this->"
							. $filter['code'] . "Options[0]->value) &&";
						$fieldBatch[] = Indent::_(4) . "!"
							. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->" . $filter['code']
							. "Options[0]->value))";
						$fieldBatch[] = Indent::_(3) . "{";
						$fieldBatch[] = Indent::_(4) . "unset(\$this->"
							. $filter['code'] . "Options[0]);";
						$fieldBatch[] = Indent::_(3) . "}";
					}
					$fieldBatch[] = Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " " . $CodeName . " Batch Selection";
					$fieldBatch[] = Indent::_(3)
						. "JHtmlBatch_::addListSelection(";
					$fieldBatch[] = Indent::_(4) . "'- Keep Original '.Text:"
						. ":_('" . $filter['lang'] . "').' -',";
					$fieldBatch[] = Indent::_(4) . "'batch[" . $filter['code']
						. "]',";
					$fieldBatch[] = Indent::_(4)
						. "Html::_('select.options', \$this->"
						. $filter['code'] . "Options, 'value', 'text')";
					$fieldBatch[] = Indent::_(3) . ");";
					$fieldBatch[] = Indent::_(2) . "}";
				}
			}
		}
		// did we find batch options
		if (ArrayHelper::check($fieldBatch))
		{
			// return the batch
			return PHP_EOL . implode(PHP_EOL, $fieldBatch);
		}

		return '';
	}

	/**
	 * add default batch helper
	 *
	 * @param   array   $batch           The batch code array
	 * @param   string  $nameSingleCode  The single view name
	 *
	 * @return  void
	 *
	 */
	protected function setDefaultBatchHelper(&$batch, &$nameSingleCode)
	{
		// set component name
		$COPMONENT = CFactory::_('Component')->get('name_code');
		$COPMONENT = StringHelper::safe(
			$COPMONENT, 'U'
		);
		// set batch
		$batch[] = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__Line__, __Class__)
			. " Only load published batch if state and batch is allowed";
		$batch[] = Indent::_(2)
			. "if (\$this->canState && \$this->canBatch)";
		$batch[] = Indent::_(2) . "{";
		$batch[] = Indent::_(3) . "JHtmlBatch_::addListSelection(";
		$batch[] = Indent::_(4) . "Text:" . ":_('COM_" . $COPMONENT
			. "_KEEP_ORIGINAL_STATE'),";
		$batch[] = Indent::_(4) . "'batch[published]',";
		$batch[] = Indent::_(4)
			. "Html::_('select.options', Html::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)";
		$batch[] = Indent::_(3) . ");";
		$batch[] = Indent::_(2) . "}";
		// check if view has access
		if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode)
			&& !CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
		{
			$batch[] = PHP_EOL . Indent::_(2)
				. "//" . Line::_(__Line__, __Class__)
				. " Only load access batch if create, edit and batch is allowed";
			$batch[] = Indent::_(2)
				. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
			$batch[] = Indent::_(2) . "{";
			$batch[] = Indent::_(3) . "JHtmlBatch_::addListSelection(";
			$batch[] = Indent::_(4) . "Text:" . ":_('COM_" . $COPMONENT
				. "_KEEP_ORIGINAL_ACCESS'),";
			$batch[] = Indent::_(4) . "'batch[access]',";
			$batch[] = Indent::_(4)
				. "Html::_('select.options', Html::_('access.assetgroups'), 'value', 'text')";
			$batch[] = Indent::_(3) . ");";
			$batch[] = Indent::_(2) . "}";
		}
	}

	/**
	 * build category batch helper
	 *
	 * @param   array   $batch         The batch code array
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  mixed The php to place in view.html.php
	 *
	 */
	protected function setCategoryBatchHelper(&$batch, &$nameListCode)
	{
		if (CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.extension"))
		{
			// set component name
			$COPMONENT = CFactory::_('Component')->get('name_code');
			$COPMONENT = StringHelper::safe($COPMONENT, 'U');
			// set filter
			$batch[] = PHP_EOL . Indent::_(2)
				. "if (\$this->canBatch && \$this->canCreate && \$this->canEdit)";
			$batch[] = Indent::_(2) . "{";
			$batch[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Category Batch selection.";
			$batch[] = Indent::_(3) . "JHtmlBatch_::addListSelection(";
			$batch[] = Indent::_(4) . "Text:" . ":_('COM_" . $COPMONENT
				. "_KEEP_ORIGINAL_CATEGORY'),";
			$batch[] = Indent::_(4) . "'batch[category]',";
			$batch[] = Indent::_(4)
				. "Html::_('select.options', Html::_('category.options', '"
				. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension")
				. "'), 'value', 'text')";
			$batch[] = Indent::_(3) . ");";
			$batch[] = Indent::_(2) . "}";
		}
	}

	public function setRouterCategoryViews($nameSingleCode, $nameListCode)
	{
		if (CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.extension"))
		{
			// get the actual extension
			$_extension = CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension");
			$_extension = explode('.', (string) $_extension);
			// set component name
			if (ArrayHelper::check($_extension))
			{
				$component = str_replace('com_', '', $_extension[0]);
			}
			else
			{
				$component = CFactory::_('Config')->component_code_name;
			}
			// check if category has another name
			$otherViews = CFactory::_('Compiler.Builder.Category.Other.Name')->
				get($nameListCode . '.views', $nameListCode);
			$otherView  = CFactory::_('Compiler.Builder.Category.Other.Name')->
				get($nameListCode . '.view', $nameSingleCode);
			// set the OtherView value
			CFactory::_('Compiler.Builder.Content.Multi')->set('category' . $otherView . '|otherview', $otherView);
			// load the category helper details in not already loaded
			if (!CFactory::_('Compiler.Builder.Content.Multi')->exists('category' . $otherView . '|view'))
			{
				// lets also set the category helper for this view
				$target = array('site' => 'category' . $otherView);
				CFactory::_('Utilities.Structure')->build($target, 'category');
				// insure the file gets updated
				CFactory::_('Compiler.Builder.Content.Multi')->set('category' . $otherView . '|view', $otherView);
				CFactory::_('Compiler.Builder.Content.Multi')->set('category' . $otherView . '|View', ucfirst((string) $otherView));
				CFactory::_('Compiler.Builder.Content.Multi')->set('category' . $otherView . '|views', $otherViews);
				CFactory::_('Compiler.Builder.Content.Multi')->set('category' . $otherView . '|Views', ucfirst((string) $otherViews));
				// set script to global helper file
				$includeHelper   = [];
				$includeHelper[] = "\n//" . Line::_(__Line__, __Class__)
					. "Insure this view category file is loaded.";
				$includeHelper[] = "\$classname = '" . ucfirst((string) $component)
					. ucfirst((string) $otherView) . "Categories';";
				$includeHelper[] = "if (!class_exists(\$classname))";
				$includeHelper[] = "{";
				$includeHelper[] = Indent::_(1)
					. "\$path = JPATH_SITE . '/components/com_" . $component
					. "/helpers/category" . $otherView . ".php';";
				$includeHelper[] = Indent::_(1) . "if (is_file(\$path))";
				$includeHelper[] = Indent::_(1) . "{";
				$includeHelper[] = Indent::_(2) . "include_once \$path;";
				$includeHelper[] = Indent::_(1) . "}";
				$includeHelper[] = "}";
				CFactory::_('Compiler.Builder.Content.One')->add('CATEGORY_CLASS_TREES', implode("\n", $includeHelper));
			}
			// return category view string
			if (CFactory::_('Compiler.Builder.Content.One')->exists('ROUTER_CATEGORY_VIEWS')
				&& StringHelper::check(
					CFactory::_('Compiler.Builder.Content.One')->get('ROUTER_CATEGORY_VIEWS')
				))
			{
				return "," . PHP_EOL . Indent::_(3) . '"'
					. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension")
					. '" => "' . $otherView . '"';
			}
			else
			{
				return PHP_EOL . Indent::_(3) . '"'
					. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension")
					. '" => "' . $otherView . '"';
			}
		}

		return '';
	}

	/**
	 * Get Admin Controller Allow Add
	 *
	 * @param   string  $nameSingleCode  The view edit or single name
	 * @param   string  $nameListCode    The view list name
	 *
	 * @return  string The method code
	 * @deprecated 3.3 Use CFactory::_('Architecture.Controller.AllowAdd')->get($nameSingleCode);
	 */
	public function setJcontrollerAllowAdd($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.Controller.AllowAdd')->get($nameSingleCode);
	}

	/**
	 * Get Admin Controller Allow Edit
	 *
	 * @param   string  $nameSingleCode  The view edit or single name
	 * @param   string  $nameListCode    The view list name
	 *
	 * @return  string The method code
	 * @deprecated 3.3 Use CFactory::_('Architecture.Controller.AllowEdit')->get($nameSingleCode, $nameListCode);
	 */
	public function setJcontrollerAllowEdit($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.Controller.AllowEdit')->get($nameSingleCode, $nameListCode);
	}

	public function setJmodelAdminGetForm($nameSingleCode, $nameListCode)
	{
		// set component name
		$component = CFactory::_('Config')->component_code_name;
		// allways load these
		$getForm   = [];
		$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if xpath was set in options";
		$getForm[] = Indent::_(2) . "\$xpath = false;";
		$getForm[] = Indent::_(2) . "if (isset(\$options['xpath']))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "\$xpath = \$options['xpath'];";
		$getForm[] = Indent::_(3) . "unset(\$options['xpath']);";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " check if clear form was set in options";
		$getForm[] = Indent::_(2) . "\$clear = false;";
		$getForm[] = Indent::_(2) . "if (isset(\$options['clear']))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "\$clear = \$options['clear'];";
		$getForm[] = Indent::_(3) . "unset(\$options['clear']);";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the form.";
		$getForm[] = Indent::_(2) . "\$form = \$this->loadForm('com_"
			. $component . "." . $nameSingleCode . "', '" . $nameSingleCode
			. "', \$options, \$clear, \$xpath);";
		$getForm[] = PHP_EOL . Indent::_(2) . "if (empty(\$form))";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "return false;";
		$getForm[] = Indent::_(2) . "}";
		// load license locker
		if (CFactory::_('Component')->get('add_license') && CFactory::_('Component')->get('license_type') == 3
			&& CFactory::_('Compiler.Builder.Content.Multi')->exists($nameSingleCode . '|BOOLMETHOD'))
		{
			$getForm[] = $this->checkStatmentLicenseLocked(
				CFactory::_('Compiler.Builder.Content.Multi')->get($nameSingleCode . '|BOOLMETHOD', '')
			);
		}
		if (0) //CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}"))  <-- remove category from check
		{
			// check if category has another name
			$otherViews = CFactory::_('Compiler.Builder.Category.Other.Name')->
				get($nameListCode . '.views', $nameListCode);
			$otherView  = CFactory::_('Compiler.Builder.Category.Other.Name')->
				get($nameListCode . '.view', $nameSingleCode);
			// setup the category script
			$getForm[] = PHP_EOL . Indent::_(2)
				. "\$jinput = Factory::getApplication()->input;";
			$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				)
				. " The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$getForm[] = Indent::_(2) . "if (\$jinput->get('a_id'))";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3)
				. "\$id = \$jinput->get('a_id', 0, 'INT');";
			$getForm[] = Indent::_(2) . "}";
			$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$getForm[] = Indent::_(2) . "else";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "\$id = \$jinput->get('id', 0, 'INT');";
			$getForm[] = Indent::_(2) . "}";
			$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Determine correct permissions to check.";
			$getForm[] = Indent::_(2) . "if (\$this->getState('"
				. $nameSingleCode . ".id'))";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "\$id = \$this->getState('"
				. $nameSingleCode . ".id');";
			$getForm[] = PHP_EOL . Indent::_(3) . "\$catid = 0;";
			$getForm[] = Indent::_(3)
				. "if (isset(\$this->getItem(\$id)->catid))";
			$getForm[] = Indent::_(3) . "{";
			$getForm[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " set category id";
			$getForm[] = Indent::_(4)
				. "\$catid = \$this->getItem(\$id)->catid;";
			$getForm[] = PHP_EOL . Indent::_(4) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Existing record. Can only edit in selected categories.";
			$getForm[] = Indent::_(4)
				. "\$form->setFieldAttribute('catid', 'action', 'core.edit');";
			$getForm[] = PHP_EOL . Indent::_(4) . "//" . Line::_(
					__LINE__,__CLASS__
				)
				. " Existing record. Can only edit own items in selected categories.";
			$getForm[] = Indent::_(4)
				. "\$form->setFieldAttribute('catid', 'action', 'core.edit.own');";
			$getForm[] = Indent::_(3) . "}";
			$getForm[] = Indent::_(2) . "}";
			$getForm[] = Indent::_(2) . "else";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " New record. Can only create in selected categories.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('catid', 'action', 'core.create');";
			$getForm[] = Indent::_(2) . "}";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$getForm[] = PHP_EOL . Indent::_(2)
					. "\$user = Factory::getUser();";
			}
			else
			{
				$getForm[] = PHP_EOL . Indent::_(2)
					. "\$user = Factory::getApplication()->getIdentity();";
			}
			$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Check for existing item.";
			$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on Edit State access controls.";
			// get the other view
			$otherView = CFactory::_('Compiler.Builder.Category.Code')->getString("{$nameSingleCode}.view", 'error');
			// check if the item has permissions.
			$getForm[] = Indent::_(2)
				. "if (\$id != 0 && (!\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.state')
				. "', 'com_" . $component . "."
				. $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3)
				. "|| (isset(\$catid) && \$catid != 0 && !\$user->authorise('core.edit.state', 'com_"
				. $component . "." . $otherView
				. ".category.' . (int) \$catid))";
			$getForm[] = Indent::_(3)
				. "|| (\$id == 0 && !\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.state')
				. "', 'com_" . $component . "')))";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields for display.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('published', 'disabled', 'true');";
			$getForm[] = PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Disable fields while saving.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('published', 'filter', 'unset');";
			$getForm[] = Indent::_(2) . "}";
		}
		else
		{
			$getForm[] = PHP_EOL . Indent::_(2)
				. "\$jinput = Factory::getApplication()->input;";
			$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				)
				. " The front end calls this model and uses a_id to avoid id clashes so we need to check for that first.";
			$getForm[] = Indent::_(2) . "if (\$jinput->get('a_id'))";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3)
				. "\$id = \$jinput->get('a_id', 0, 'INT');";
			$getForm[] = Indent::_(2) . "}";
			$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " The back end uses id so we use that the rest of the time and set it to 0 by default.";
			$getForm[] = Indent::_(2) . "else";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "\$id = \$jinput->get('id', 0, 'INT');";
			$getForm[] = Indent::_(2) . "}";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$getForm[] = PHP_EOL . Indent::_(2)
					. "\$user = Factory::getUser();";
			}
			else
			{
				$getForm[] = PHP_EOL . Indent::_(2)
					. "\$user = Factory::getApplication()->getIdentity();";
			}
			$getForm[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Check for existing item.";
			$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on Edit State access controls.";
			// check if the item has permissions.
			$getForm[] = Indent::_(2)
				. "if (\$id != 0 && (!\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.state') . "', 'com_" . $component . "."
				. $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3)
				. "|| (\$id == 0 && !\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.state') . "', 'com_" . $component
				. "')))";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields for display.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('ordering', 'disabled', 'true');";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('published', 'disabled', 'true');";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('ordering', 'filter', 'unset');";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('published', 'filter', 'unset');";
			$getForm[] = Indent::_(2) . "}";
		}
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " If this is a new item insure the greated by is set.";
		$getForm[] = Indent::_(2) . "if (0 == \$id)";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set the created_by to this user";
		$getForm[] = Indent::_(3)
			. "\$form->setValue('created_by', null, \$user->id);";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Modify the form based on Edit Creaded By access controls.";
		// check if the item has permissions.
		if (CFactory::_('Compiler.Creator.Permission')->actionExist($nameSingleCode, 'core.edit.created_by'))
		{
			$getForm[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.created_by')
				. "', 'com_" . $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.created_by')
				. "', 'com_" . $component . "')))";
		}
		else
		{
			$getForm[] = Indent::_(2)
				. "if (!\$user->authorise('core.edit.created_by', 'com_" . $component . "'))";
		}
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Disable fields for display.";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('created_by', 'disabled', 'true');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Disable fields for display.";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('created_by', 'readonly', 'true');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Disable fields while saving.";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('created_by', 'filter', 'unset');";
		$getForm[] = Indent::_(2) . "}";
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Modify the form based on Edit Creaded Date access controls.";
		// check if the item has permissions.
		if (CFactory::_('Compiler.Creator.Permission')->actionExist($nameSingleCode, 'core.edit.created'))
		{
			$getForm[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.created')
				. "', 'com_" . $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.created')
				. "', 'com_" . $component . "')))";
		}
		else
		{
			$getForm[] = Indent::_(2)
				. "if (!\$user->authorise('core.edit.created', 'com_"
				. $component . "'))";
		}
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Disable fields for display.";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('created', 'disabled', 'true');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Disable fields while saving.";
		$getForm[] = Indent::_(3)
			. "\$form->setFieldAttribute('created', 'filter', 'unset');";
		$getForm[] = Indent::_(2) . "}";
		// check if the item has access permissions.
		if (CFactory::_('Compiler.Creator.Permission')->actionExist($nameSingleCode, 'core.edit.access'))
		{
			$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on Edit Access 'access' controls.";
			$getForm[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.access')
				. "', 'com_" . $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$getForm[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit.access')
				. "', 'com_" . $component . "')))";
			$getForm[] = Indent::_(2) . "{";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields for display.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('access', 'disabled', 'true');";
			$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$getForm[] = Indent::_(3)
				. "\$form->setFieldAttribute('access', 'filter', 'unset');";
			$getForm[] = Indent::_(2) . "}";
		}
		// handel the fields permissions
		if (CFactory::_('Compiler.Builder.Permission.Fields')->isArray($nameSingleCode))
		{
			foreach (CFactory::_('Compiler.Builder.Permission.Fields')->get($nameSingleCode)
				as $fieldName => $permission_options)
			{
				foreach ($permission_options as $permission_option => $fieldType)
				{
					switch ($permission_option)
					{
						case 'edit':
							$this->setPermissionEditFields(
								$getForm, $nameSingleCode, $fieldName,
								$fieldType, $component
							);
							break;
						case 'access':
							$this->setPermissionAccessFields(
								$getForm, $nameSingleCode, $fieldName,
								$fieldType, $component
							);
							break;
						case 'view':
							$this->setPermissionViewFields(
								$getForm, $nameSingleCode, $fieldName,
								$fieldType, $component
							);
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
		$getForm[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Only load these values if no id is found";
		$getForm[] = Indent::_(2) . "if (0 == \$id)";
		$getForm[] = Indent::_(2) . "{";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set redirected view name";
		$getForm[] = Indent::_(3)
			. "\$redirectedView = \$jinput->get('ref', null, 'STRING');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set field name (or fall back to view name)";
		$getForm[] = Indent::_(3)
			. "\$redirectedField = \$jinput->get('field', \$redirectedView, 'STRING');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set redirected view id";
		$getForm[] = Indent::_(3)
			. "\$redirectedId = \$jinput->get('refid', 0, 'INT');";
		$getForm[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Set field id (or fall back to redirected view id)";
		$getForm[] = Indent::_(3)
			. "\$redirectedValue = \$jinput->get('field_id', \$redirectedId, 'INT');";
		$getForm[] = Indent::_(3)
			. "if (0 != \$redirectedValue && \$redirectedField)";
		$getForm[] = Indent::_(3) . "{";
		$getForm[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
			. " Now set the local-redirected field default value";
		$getForm[] = Indent::_(4)
			. "\$form->setValue(\$redirectedField, null, \$redirectedValue);";
		$getForm[] = Indent::_(3) . "}";
		// load custom script if found
		$getForm[] = Indent::_(2) . "}" . CFactory::_('Customcode.Dispenser')->get(
				'php_getform', $nameSingleCode, PHP_EOL
			);
		// setup the default script
		$getForm[] = Indent::_(2) . "return \$form;";

		return implode(PHP_EOL, $getForm);
	}

	protected function setPermissionEditFields(&$allow, $nameSingleCode,
	                                           $fieldName, $fieldType, $component
	)
	{
		// only for fields that can be edited
		if (!CFactory::_('Field.Groups')->check($fieldType, 'spacer'))
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on Edit "
				. StringHelper::safe($fieldName, 'W')
				. " access controls.";
			$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $nameSingleCode . ".edit." . $fieldName . "', 'com_"
				. $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $nameSingleCode . ".edit." . $fieldName . "', 'com_"
				. $component . "')))";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields for display.";
			$allow[] = Indent::_(3) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'disabled', 'true');";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields for display.";
			$allow[] = Indent::_(3) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'readonly', 'true');";
			if ('radio' === $fieldType || 'repeatable' === $fieldType)
			{
				$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
					. " Disable radio button for display.";
				$allow[] = Indent::_(3)
					. "\$class = \$form->getFieldAttribute('" . $fieldName
					. "', 'class', '');";
				$allow[] = Indent::_(3) . "\$form->setFieldAttribute('"
					. $fieldName . "', 'class', \$class.' disabled no-click');";
			}
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " If there is no value continue.";
			$allow[] = Indent::_(3) . "if (!\$form->getValue('" . $fieldName
				. "'))";
			$allow[] = Indent::_(3) . "{";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'filter', 'unset');";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'required', 'false');";
			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(2) . "}";
		}
	}

	protected function setPermissionAccessFields(&$allow, $nameSingleCode,
	                                             $fieldName, $fieldType, $component
	)
	{
		$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Modify the from the form based on "
			. StringHelper::safe($fieldName, 'W')
			. " access controls.";
		$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
			. $nameSingleCode . ".access." . $fieldName . "', 'com_"
			. $component . "." . $nameSingleCode . ".' . (int) \$id))";
		$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
			. $nameSingleCode . ".access." . $fieldName . "', 'com_"
			. $component . "')))";
		$allow[] = Indent::_(2) . "{";
		$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Remove the field";
		$allow[] = Indent::_(3) . "\$form->removeField('" . $fieldName . "');";
		$allow[] = Indent::_(2) . "}";
	}

	protected function setPermissionViewFields(&$allow, $nameSingleCode,
	                                           $fieldName, $fieldType, $component
	)
	{
		if (CFactory::_('Field.Groups')->check($fieldType, 'spacer'))
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on View "
				. StringHelper::safe($fieldName, 'W')
				. " access controls.";
			$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "')))";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Remove the field";
			$allow[] = Indent::_(3) . "\$form->removeField('" . $fieldName
				. "');";
			$allow[] = Indent::_(2) . "}";
		}
		else
		{
			$allow[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Modify the form based on View "
				. StringHelper::safe($fieldName, 'W')
				. " access controls.";
			$allow[] = Indent::_(2) . "if (\$id != 0 && (!\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "." . $nameSingleCode . ".' . (int) \$id))";
			$allow[] = Indent::_(3) . "|| (\$id == 0 && !\$user->authorise('"
				. $nameSingleCode . ".view." . $fieldName . "', 'com_"
				. $component . "')))";
			$allow[] = Indent::_(2) . "{";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Make the field hidded.";
			$allow[] = Indent::_(3) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'type', 'hidden');";
			$allow[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " If there is no value continue.";
			$allow[] = Indent::_(3) . "if (!(\$val = \$form->getValue('"
				. $fieldName . "')))";
			$allow[] = Indent::_(3) . "{";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'filter', 'unset');";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Disable fields while saving.";
			$allow[] = Indent::_(4) . "\$form->setFieldAttribute('" . $fieldName
				. "', 'required', 'false');";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Make sure";
			$allow[] = Indent::_(4) . "\$form->setValue('" . $fieldName
				. "', null, '');";
			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(3) . "elseif ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$val))";
			$allow[] = Indent::_(3) . "{";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " We have to unset then (TODO)";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Hiddend field can not handel array value";
			$allow[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Even if we convert to json we get an error";
			$allow[] = Indent::_(4) . "\$form->removeField('" . $fieldName
				. "');";
			$allow[] = Indent::_(3) . "}";
			$allow[] = Indent::_(2) . "}";
		}
	}

	public function setJmodelAdminAllowEdit($nameSingleCode, $nameListCode)
	{
		$allow = [];
		// set component name
		$component = CFactory::_('Config')->component_code_name;
		// prepare custom permission script
		$customAllow = CFactory::_('Customcode.Dispenser')->get(
			'php_allowedit', $nameSingleCode, Indent::_(2)
			. "\$recordId = (int) isset(\$data[\$key]) ? \$data[\$key] : 0;"
			. PHP_EOL
		);
		// check if the item has permissions.
		if (CFactory::_('Compiler.Creator.Permission')->actionExist($nameSingleCode, 'core.edit'))
		{
			$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Check specific edit permission then general edit permission.";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$allow[] = Indent::_(2) . "\$user = Factory::getUser();";
			}
			else
			{
				$allow[] = Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";
			}
			// load custom permission script
			$allow[] = $customAllow;
			$allow[] = Indent::_(2) . "return \$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit')
				. "', 'com_" . $component . "." . $nameSingleCode
				. ".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or \$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.edit')
				. "',  'com_" . $component . "');";
		}
		else
		{
			$allow[] = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Check specific edit permission then general edit permission.";
			if (StringHelper::check($customAllow))
			{
				if (CFactory::_('Config')->get('joomla_version', 3) == 3)
				{
					$allow[] = Indent::_(2) . "\$user = Factory::getUser();";
				}
				else
				{
					$allow[] = Indent::_(2) . "\$user = Factory::getApplication()->getIdentity();";
				}
			}
			// load custom permission script
			$allow[] = $customAllow;
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$allow[] = Indent::_(2)
					. "return Factory::getUser()->authorise('core.edit', 'com_"
					. $component . "." . $nameSingleCode
					. ".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or parent::allowEdit(\$data, \$key);";
			}
			else
			{
				$allow[] = Indent::_(2)
					. "return Factory::getApplication()->getIdentity()->authorise('core.edit', 'com_"
					. $component . "." . $nameSingleCode
					. ".'. ((int) isset(\$data[\$key]) ? \$data[\$key] : 0)) or parent::allowEdit(\$data, \$key);";
			}
		}

		return implode(PHP_EOL, $allow);
	}

	/**
	 * Get Admin Module Can Delete
	 *
	 * @param   string  $nameSingleCode  The view edit or single name
	 * @param   string  $nameListCode    The view list name
	 *
	 * @return  string The method code
	 * @deprecated 3.3 Use CFactory::_('Architecture.Model.CanDelete')->get($nameSingleCode);
	 */
	public function setJmodelAdminCanDelete($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.Model.CanDelete')->get($nameSingleCode);
	}

	/**
	 * Get Admin Module Can Delete
	 *
	 * @param   string  $nameSingleCode  The view edit or single name
	 * @param   string  $nameListCode    The view list name
	 *
	 * @return  string The method code
	 * @deprecated 3.3 Use CFactory::_('Architecture.Model.CanEditState')->get($nameSingleCode);
	 */
	public function setJmodelAdminCanEditState($nameSingleCode, $nameListCode)
	{
		return CFactory::_('Architecture.Model.CanEditState')->get($nameSingleCode);
	}

	public function setJviewListCanDo($nameSingleCode, $nameListCode)
	{
		$allow = [];
		// set component name
		$component = CFactory::_('Config')->component_code_name;
		// check if the item has permissions for edit.
		$allow[] = PHP_EOL . Indent::_(2)
			. "\$this->canEdit = \$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit')
			. "');";
		// check if the item has permissions for edit state.
		$allow[] = Indent::_(2) . "\$this->canState = \$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit.state')
			. "');";
		// check if the item has permissions for create.
		$allow[] = Indent::_(2) . "\$this->canCreate = \$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.create') . "');";
		// check if the item has permissions for delete.
		$allow[] = Indent::_(2) . "\$this->canDelete = \$this->canDo->get('"
			. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.delete') . "');";
		// check if the item has permissions for batch.
		if (CFactory::_('Compiler.Creator.Permission')->globalExist($nameSingleCode, 'core.batch'))
		{
			$allow[] = Indent::_(2) . "\$this->canBatch = (\$this->canDo->get('"
				. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.batch')
				. "') && \$this->canDo->get('core.batch'));";
		}
		else
		{
			$allow[] = Indent::_(2)
				. "\$this->canBatch = \$this->canDo->get('core.batch');";
		}

		return implode(PHP_EOL, $allow);
	}

	public function setFieldSetAccessControl(&$view)
	{
		$access = '';
		if ($view != 'component')
		{
			// set component name
			$component = CFactory::_('Config')->component_code_name;
			// set label
			$label = 'Permissions in relation to this ' . $view;
			// set the access fieldset
			$access = "<!--" . Line::_(__Line__, __Class__)
				. " Access Control Fields. -->";
			$access .= PHP_EOL . Indent::_(1)
				. '<fieldset name="accesscontrol">';
			$access .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Asset Id Field. Type: Hidden (joomla) -->";
			$access .= PHP_EOL . Indent::_(2) . '<field';
			$access .= PHP_EOL . Indent::_(3) . 'name="asset_id"';
			$access .= PHP_EOL . Indent::_(3) . 'type="hidden"';
			$access .= PHP_EOL . Indent::_(3) . 'filter="unset"';
			$access .= PHP_EOL . Indent::_(2) . '/>';
			$access .= PHP_EOL . Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Rules Field. Type: Rules (joomla) -->";
			$access .= PHP_EOL . Indent::_(2) . '<field';
			$access .= PHP_EOL . Indent::_(3) . 'name="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'type="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'label="' . $label . '"';
			$access .= PHP_EOL . Indent::_(3) . 'translate_label="false"';
			$access .= PHP_EOL . Indent::_(3) . 'filter="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'validate="rules"';
			$access .= PHP_EOL . Indent::_(3) . 'class="inputbox"';
			$access .= PHP_EOL . Indent::_(3) . 'component="com_' . $component
				. '"';
			$access .= PHP_EOL . Indent::_(3) . 'section="' . $view . '"';
			$access .= PHP_EOL . Indent::_(2) . '/>';
			$access .= PHP_EOL . Indent::_(1) . '</fieldset>';
		}

		// return access field set
		return $access;
	}

	/**
	 * set the filter fields
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The code for the filter fields array
	 *
	 */
	public function setFilterFieldsArray(&$nameSingleCode, &$nameListCode)
	{
		// keep track of all fields already added
		$donelist = array('id'         => true, 'search' => true,
			'published'  => true, 'access' => true,
			'created_by' => true, 'modified_by' => true);
		// default filter fields
		$fields = "'a.id','id'";
		$fields .= "," . PHP_EOL . Indent::_(4) . "'a.published','published'";
		if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode))
		{
			$fields .= "," . PHP_EOL . Indent::_(4) . "'a.access','access'";
		}
		$fields .= "," . PHP_EOL . Indent::_(4) . "'a.ordering','ordering'";
		$fields .= "," . PHP_EOL . Indent::_(4) . "'a.created_by','created_by'";
		$fields .= "," . PHP_EOL . Indent::_(4)
			. "'a.modified_by','modified_by'";

		// add the rest of the set filters
		if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$fields                    .= $this->getFilterFieldCode(
						$filter
					);
					$donelist[$filter['code']] = true;
				}
			}
		}
		// add the rest of the set filters
		if (CFactory::_('Compiler.Builder.Sort')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Sort')->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$fields .= $this->getFilterFieldCode(
						$filter
					);
					$donelist[$filter['code']] = true;
				}
			}
		}

		return $fields;
	}

	/**
	 * Add the code of the filter field array
	 *
	 * @param   array  $filter  The field/filter array
	 *
	 * @return  string    The code for the filter array
	 *
	 */
	protected function getFilterFieldCode(&$filter)
	{
		// add the category stuff (may still remove these) TODO
		if ($filter['type'] === 'category')
		{
			$field = "," . PHP_EOL . Indent::_(4)
				. "'c.title','category_title'";
			$field .= "," . PHP_EOL . Indent::_(4)
				. "'c.id', 'category_id'";
			if ($filter['code'] != 'category')
			{
				$field .= "," . PHP_EOL . Indent::_(4) . "'a."
					. $filter['code'] . "','" . $filter['code']
					. "'";
			}
		}
		else
		{
			// check if custom field is set
			if (ArrayHelper::check(
					$filter['custom']
				)
				&& isset($filter['custom']['db'])
				&& StringHelper::check(
					$filter['custom']['db']
				)
				&& isset($filter['custom']['text'])
				&& StringHelper::check(
					$filter['custom']['text']
				))
			{
				$field = "," . PHP_EOL . Indent::_(4) . "'"
					. $filter['custom']['db'] . "."
					. $filter['custom']['text'] . "','" . $filter['code']
					. "'";
			}
			else
			{
				$field = "," . PHP_EOL . Indent::_(4) . "'a."
					. $filter['code'] . "','" . $filter['code']
					. "'";
			}
		}

		return $field;
	}

	/**
	 * set the sotred ids
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The code for the populate state
	 *
	 */
	public function setStoredId(&$nameSingleCode, &$nameListCode)
	{
		// set component name
		$Component = ucwords((string) CFactory::_('Config')->component_code_name);
		// keep track of all fields already added
		$donelist = array('id'         => true, 'search' => true,
			'published'  => true, 'access' => true,
			'created_by' => true, 'modified_by' => true);
		// set the defaults first
		$stored = "//" . Line::_(__Line__, __Class__) . " Compile the store id.";
		$stored .= PHP_EOL . Indent::_(2)
			. "\$id .= ':' . \$this->getState('filter.id');";
		$stored .= PHP_EOL . Indent::_(2)
			. "\$id .= ':' . \$this->getState('filter.search');";
		// add this if not already added
		if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
		{
			$stored .= PHP_EOL . Indent::_(2)
				. "\$id .= ':' . \$this->getState('filter.published');";
		}
		// add if view calls for it, and not already added
		if (CFactory::_('Compiler.Builder.Access.Switch')->exists($nameSingleCode)
			&& !CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
		{
			// the side bar option is single
			if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1)
			{
				$stored .= PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter.access');";
			}
			else
			{
				// top bar selection can result in
				// an array due to multi selection
				$stored .= $this->getStoredIdCodeMulti('access', $Component);
			}
		}
		$stored .= PHP_EOL . Indent::_(2)
			. "\$id .= ':' . \$this->getState('filter.ordering');";
		// add this if not already added
		if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.created_by'))
		{
			$stored .= PHP_EOL . Indent::_(2)
				. "\$id .= ':' . \$this->getState('filter.created_by');";
		}
		// add this if not already added
		if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.modified_by'))
		{
			$stored .= PHP_EOL . Indent::_(2)
				. "\$id .= ':' . \$this->getState('filter.modified_by');";
		}
		// add the rest of the set filters
		if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$stored .= $this->getStoredIdCode(
						$filter, $nameListCode, $Component
					);
					$donelist[$filter['code']] = true;
				}
			}
		}
		// add the rest of the set filters
		if (CFactory::_('Compiler.Builder.Sort')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Sort')->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$stored .= $this->getStoredIdCode(
						$filter, $nameListCode, $Component
					);
					$donelist[$filter['code']] = true;
				}
			}
		}

		return $stored;
	}

	/**
	 * Add the code of the stored ids
	 *
	 * @param   array   $filter        The field/filter array
	 * @param   string  $nameListCode  The list view name
	 * @param   string  $Component     The Component name
	 *
	 * @return  string    The code for the stored IDs
	 *
	 */
	protected function getStoredIdCode(&$filter, &$nameListCode, &$Component)
	{
		if ($filter['type'] === 'category')
		{
			// the side bar option is single (1 = sidebar)
			if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 1)
			{
				$stored = PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter.category');";
				$stored .= PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter.category_id');";
				if ($filter['code'] != 'category')
				{
					$stored .= PHP_EOL . Indent::_(2)
						. "\$id .= ':' . \$this->getState('filter."
						. $filter['code'] . "');";
				}
			}
			else
			{
				$stored = $this->getStoredIdCodeMulti('category', $Component);
				$stored .= $this->getStoredIdCodeMulti(
					'category_id', $Component
				);
				if ($filter['code'] != 'category')
				{
					$stored .= $this->getStoredIdCodeMulti(
						$filter['code'], $Component
					);
				}
			}
		}
		else
		{
			// check if this is the topbar filter, and multi option (2 = topbar)
			if (isset($filter['multi']) && $filter['multi'] == 2
				&& CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
			{
				// top bar selection can result in
				// an array due to multi selection
				$stored = $this->getStoredIdCodeMulti(
					$filter['code'], $Component
				);
			}
			else
			{
				$stored = PHP_EOL . Indent::_(2)
					. "\$id .= ':' . \$this->getState('filter."
					. $filter['code'] . "');";
			}
		}

		return $stored;
	}

	/**
	 * Add the code of the stored multi ids
	 *
	 * @param   string  $key        The key field name
	 * @param   string  $Component  The Component name
	 *
	 * @return  string    The code for the stored IDs
	 *
	 */
	protected function getStoredIdCodeMulti($key, &$Component)
	{
		// top bar selection can result in
		// an array due to multi selection
		$stored = PHP_EOL . Indent::_(2)
			. "//" . Line::_(__Line__, __Class__)
			. " Check if the value is an array";
		$stored .= PHP_EOL . Indent::_(2)
			. "\$_" . $key . " = \$this->getState('filter."
			. $key . "');";
		$stored .= PHP_EOL . Indent::_(2)
			. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$_"
			. $key . "))";
		$stored .= PHP_EOL . Indent::_(2)
			. "{";
		$stored .= PHP_EOL . Indent::_(3)
			. "\$id .= ':' . implode(':', \$_" . $key . ");";
		$stored .= PHP_EOL . Indent::_(2)
			. "}";
		$stored .= PHP_EOL . Indent::_(2)
			. "//" . Line::_(__Line__, __Class__)
			. " Check if this is only an number or string";
		$stored .= PHP_EOL . Indent::_(2)
			. "elseif (is_numeric(\$_" . $key . ")";
		$stored .= PHP_EOL . Indent::_(2)
			. " || Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$_" . $key . "))";
		$stored .= PHP_EOL . Indent::_(2)
			. "{";
		$stored .= PHP_EOL . Indent::_(3)
			. "\$id .= ':' . \$_" . $key . ";";
		$stored .= PHP_EOL . Indent::_(2)
			. "}";

		return $stored;
	}

	public function setAddToolBar(&$view)
	{
		// set view name
		$nameSingleCode = $view['settings']->name_single_code;
		if (CFactory::_('Config')->get('joomla_version', 3) != 3)
		{
			$langViews = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe(
					$view['settings']->name_list_code, 'U'
				);
			$name_list = strtolower($view['settings']->name_list);
			$name_single = strtolower($view['settings']->name_single);
			// add empty title
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target,
				$langViews . '_EMPTYSTATE_TITLE',
				'No ' . $name_list . ' have been created yet.'
			);
			// add empty content
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target,
				$langViews . '_EMPTYSTATE_CONTENT',
				$view['settings']->description
			);
			// add empty button add
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target,
				$langViews . '_EMPTYSTATE_BUTTON_ADD',
				'Add your first ' . $name_single
			);
		}
		// check type
		if ($view['settings']->type == 2)
		{
			// set lang strings
			$viewNameLang_readonly = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe(
					$view['settings']->name_single . ' readonly', 'U'
				);
			// load to lang
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $viewNameLang_readonly,
				$view['settings']->name_single . ' :: Readonly'
			);

			// build toolbar
			$toolBar
				= "Factory::getApplication()->input->set('hidemainmenu', true);";
			$toolBar .= PHP_EOL . Indent::_(2) . "ToolbarHelper::title(Text:"
				. ":_('" . $viewNameLang_readonly . "'), '" . $nameSingleCode
				. "');";
			$toolBar .= PHP_EOL . Indent::_(2) . "ToolbarHelper::cancel('"
				. $nameSingleCode . ".cancel', 'JTOOLBAR_CLOSE');";
		}
		else
		{
			// set lang strings
			$viewNameLang_new  = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe(
					$view['settings']->name_single . ' New', 'U'
				);
			$viewNameLang_edit = CFactory::_('Config')->lang_prefix . '_'
				. StringHelper::safe(
					$view['settings']->name_single . ' Edit', 'U'
				);
			// load to lang
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $viewNameLang_new,
				'A New ' . $view['settings']->name_single
			);
			CFactory::_('Language')->set(
				CFactory::_('Config')->lang_target, $viewNameLang_edit,
				'Editing the ' . $view['settings']->name_single
			);
			// build toolbar
			$toolBar
				= "Factory::getApplication()->input->set('hidemainmenu', true);";
			if (CFactory::_('Config')->get('joomla_version', 3) == 3)
			{
				$toolBar .= PHP_EOL . Indent::_(2)
					. "\$user = Factory::getUser();";
			}
			else
			{
				$toolBar .= PHP_EOL . Indent::_(2)
					. "\$user = Factory::getApplication()->getIdentity();";
			}
			$toolBar .= PHP_EOL . Indent::_(2) . "\$userId	= \$user->id;";
			$toolBar .= PHP_EOL . Indent::_(2)
				. "\$isNew = \$this->item->id == 0;";
			$toolBar .= PHP_EOL . PHP_EOL . Indent::_(2)
				. "ToolbarHelper::title( Text:" . ":_(\$isNew ? '"
				. $viewNameLang_new . "' : '" . $viewNameLang_edit
				. "'), 'pencil-2 article-add');";
			$toolBar .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Built the actions for new and existing records.";
			$toolBar .= PHP_EOL . Indent::_(2) . "if ("
				. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->referral))";
			$toolBar .= PHP_EOL . Indent::_(2) . "{";
			$toolBar .= PHP_EOL . Indent::_(3) . "if (\$this->canDo->get('"
				. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.create') . "') && \$isNew)";
			$toolBar .= PHP_EOL . Indent::_(3) . "{";
			$toolBar .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " We can create the record.";
			$toolBar .= PHP_EOL . Indent::_(4) . "ToolbarHelper::save('"
				. $nameSingleCode . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . Indent::_(3) . "}";
			$toolBar .= PHP_EOL . Indent::_(3)
				. "elseif (\$this->canDo->get('"
				. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit')
				. "'))";
			$toolBar .= PHP_EOL . Indent::_(3) . "{";
			$toolBar .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " We can save the record.";
			$toolBar .= PHP_EOL . Indent::_(4) . "ToolbarHelper::save('"
				. $nameSingleCode . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . Indent::_(3) . "}";
			$toolBar .= PHP_EOL . Indent::_(3) . "if (\$isNew)";
			$toolBar .= PHP_EOL . Indent::_(3) . "{";
			$toolBar .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " Do not creat but cancel.";
			$toolBar .= PHP_EOL . Indent::_(4) . "ToolbarHelper::cancel('"
				. $nameSingleCode . ".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= PHP_EOL . Indent::_(3) . "}";
			$toolBar .= PHP_EOL . Indent::_(3) . "else";
			$toolBar .= PHP_EOL . Indent::_(3) . "{";
			$toolBar .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " We can close it.";
			$toolBar .= PHP_EOL . Indent::_(4) . "ToolbarHelper::cancel('"
				. $nameSingleCode . ".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= PHP_EOL . Indent::_(3) . "}";
			$toolBar .= PHP_EOL . Indent::_(2) . "}";
			$toolBar .= PHP_EOL . Indent::_(2) . "else";
			$toolBar .= PHP_EOL . Indent::_(2) . "{";
			$toolBar .= PHP_EOL . Indent::_(3) . "if (\$isNew)";
			$toolBar .= PHP_EOL . Indent::_(3) . "{";
			$toolBar .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " For new records, check the create permission.";
			$toolBar .= PHP_EOL . Indent::_(4) . "if (\$this->canDo->get('"
				. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.create') . "'))";
			$toolBar .= PHP_EOL . Indent::_(4) . "{";
			$toolBar .= PHP_EOL . Indent::_(5) . "ToolbarHelper::apply('"
				. $nameSingleCode . ".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= PHP_EOL . Indent::_(5) . "ToolbarHelper::save('"
				. $nameSingleCode . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . Indent::_(5) . "ToolbarHelper::custom('"
				. $nameSingleCode
				. ".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= PHP_EOL . Indent::_(4) . "};";
			$toolBar .= PHP_EOL . Indent::_(4) . "ToolbarHelper::cancel('"
				. $nameSingleCode . ".cancel', 'JTOOLBAR_CANCEL');";
			$toolBar .= PHP_EOL . Indent::_(3) . "}";
			$toolBar .= PHP_EOL . Indent::_(3) . "else";
			$toolBar .= PHP_EOL . Indent::_(3) . "{";
			$toolBar .= PHP_EOL . Indent::_(4) . "if (\$this->canDo->get('"
				. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit') . "'))";
			$toolBar .= PHP_EOL . Indent::_(4) . "{";
			$toolBar .= PHP_EOL . Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " We can save the new record";
			$toolBar .= PHP_EOL . Indent::_(5) . "ToolbarHelper::apply('"
				. $nameSingleCode . ".apply', 'JTOOLBAR_APPLY');";
			$toolBar .= PHP_EOL . Indent::_(5) . "ToolbarHelper::save('"
				. $nameSingleCode . ".save', 'JTOOLBAR_SAVE');";
			$toolBar .= PHP_EOL . Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " We can save this record, but check the create permission to see";
			$toolBar .= PHP_EOL . Indent::_(5) . "//" . Line::_(__Line__, __Class__)
				. " if we can return to make a new one.";
			$toolBar .= PHP_EOL . Indent::_(5) . "if (\$this->canDo->get('"
				. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.create') . "'))";
			$toolBar .= PHP_EOL . Indent::_(5) . "{";
			$toolBar .= PHP_EOL . Indent::_(6) . "ToolbarHelper::custom('"
				. $nameSingleCode
				. ".save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);";
			$toolBar .= PHP_EOL . Indent::_(5) . "}";
			$toolBar .= PHP_EOL . Indent::_(4) . "}";
			if (CFactory::_('Compiler.Creator.Permission')->globalExist($nameSingleCode, 'core.edit'))
			{
				if (CFactory::_('Compiler.Builder.History')->exists($nameSingleCode))
				{
					$toolBar .= PHP_EOL . Indent::_(4)
						. "\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('"
						. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.version')
						. "'));";
					$toolBar .= PHP_EOL . Indent::_(4)
						. "if (\$this->state->params->get('save_history', 1) && \$this->canDo->get('"
						. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.edit')
						. "') && \$canVersion)";
					$toolBar .= PHP_EOL . Indent::_(4) . "{";
					$toolBar .= PHP_EOL . Indent::_(5)
						. "ToolbarHelper::versions('com_"
						. CFactory::_('Config')->component_code_name . "." . $nameSingleCode
						. "', \$this->item->id);";
					$toolBar .= PHP_EOL . Indent::_(4) . "}";
				}
			}
			else
			{
				if (CFactory::_('Compiler.Builder.History')->exists($nameSingleCode))
				{
					$toolBar .= PHP_EOL . Indent::_(4)
						. "\$canVersion = (\$this->canDo->get('core.version') && \$this->canDo->get('"
						. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.version') . "'));";
					$toolBar .= PHP_EOL . Indent::_(4)
						. "if (\$this->state->params->get('save_history', 1) && \$this->canDo->get('core.edit') && \$canVersion)";
					$toolBar .= PHP_EOL . Indent::_(4) . "{";
					$toolBar .= PHP_EOL . Indent::_(5)
						. "ToolbarHelper::versions('com_"
						. CFactory::_('Config')->component_code_name . "." . $nameSingleCode
						. "', \$this->item->id);";
					$toolBar .= PHP_EOL . Indent::_(4) . "}";
				}
			}
			$toolBar .= PHP_EOL . Indent::_(4) . "if (\$this->canDo->get('"
				. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.create') . "'))";
			$toolBar .= PHP_EOL . Indent::_(4) . "{";
			$toolBar .= PHP_EOL . Indent::_(5) . "ToolbarHelper::custom('"
				. $nameSingleCode
				. ".save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);";
			$toolBar .= PHP_EOL . Indent::_(4) . "}";
			// add custom buttons
			$toolBar .= $this->setCustomButtons($view, 2, Indent::_(2));
			$toolBar .= PHP_EOL . Indent::_(4) . "ToolbarHelper::cancel('"
				. $nameSingleCode . ".cancel', 'JTOOLBAR_CLOSE');";
			$toolBar .= PHP_EOL . Indent::_(3) . "}";
			$toolBar .= PHP_EOL . Indent::_(2) . "}";
			$toolBar .= PHP_EOL . Indent::_(2) . "ToolbarHelper::divider();";
			if (CFactory::_('Config')->get('joomla_version', 3) != 3)
			{
				$toolBar .= PHP_EOL . Indent::_(2) . "ToolbarHelper::inlinehelp();";
			}
			$toolBar .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set help url for this view if found";
			$toolBar .= PHP_EOL . Indent::_(2) . "\$this->help_url = "
				. CFactory::_('Compiler.Builder.Content.One')->get('Component') . "Helper::getHelpUrl('" . $nameSingleCode
				. "');";
			$toolBar .= PHP_EOL . Indent::_(2) . "if ("
				. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$this->help_url))";
			$toolBar .= PHP_EOL . Indent::_(2) . "{";
			$toolBar .= PHP_EOL . Indent::_(3) . "ToolbarHelper::help('"
				. CFactory::_('Config')->lang_prefix . "_HELP_MANAGER', false, \$this->help_url);";
			$toolBar .= PHP_EOL . Indent::_(2) . "}";
		}

		return $toolBar;
	}

	/**
	 * set the populate state code
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The code for the populate state
	 *
	 */
	public function setPopulateState(&$nameSingleCode, &$nameListCode)
	{
		// reset bucket
		$state = '';
		// keep track of all fields already added
		$donelist = [];
		// we must add the formSubmited code if new above filters is used (2 = topbar)
		$new_filter = false;
		if (CFactory::_('Compiler.Builder.Admin.Filter.Type')->get($nameListCode, 1) == 2)
		{
			$state      .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " Check if the form was submitted";
			$state      .= PHP_EOL . Indent::_(2) . "\$formSubmited"
				. " = \$app->input->post->get('form_submited');";
			$new_filter = true;
		}
		// add the default populate states (this must be added first)
		$state .= $this->setDefaultPopulateState($nameSingleCode, $new_filter);
		// add the filters
		if (CFactory::_('Compiler.Builder.Filter')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Filter')->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$state                     .= $this->getPopulateStateFilterCode(
						$filter, $new_filter
					);
					$donelist[$filter['code']] = true;
				}
			}
		}
		// add the rest of the set filters
		if (CFactory::_('Compiler.Builder.Sort')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Sort')->get($nameListCode) as $filter)
			{
				if (!isset($donelist[$filter['code']]))
				{
					$state .= $this->getPopulateStateFilterCode(
						$filter, $new_filter
					);
					$donelist[$filter['code']] = true;
				}
			}
		}

		return $state;
	}

	/**
	 * Add the code of the filter in the populate state
	 *
	 * @param   array   $filter     The field/filter array
	 * @param   bool    $newFilter  The switch to use the new filter
	 * @param   string  $extra      The defaults/extra options of the filter
	 *
	 * @return  string    The code for the populate state
	 *
	 */
	protected function getPopulateStateFilterCode(&$filter, $newFilter,
	                                              $extra = ''
	)
	{
		$state = '';
		// add category stuff (may still remove these) TODO
		if (isset($filter['type']) && $filter['type'] === 'category')
		{
			$state .= PHP_EOL . PHP_EOL . Indent::_(2)
				. "\$category = \$app->getUserStateFromRequest(\$this->context . '.filter.category', 'filter_category');";
			$state .= PHP_EOL . Indent::_(2)
				. "\$this->setState('filter.category', \$category);";
			$state .= PHP_EOL . PHP_EOL . Indent::_(2)
				. "\$categoryId = \$this->getUserStateFromRequest(\$this->context . '.filter.category_id', 'filter_category_id');";
			$state .= PHP_EOL . Indent::_(2)
				. "\$this->setState('filter.category_id', \$categoryId);";
		}
		// always add the default filter
		$state .= PHP_EOL . PHP_EOL . Indent::_(2) . "\$" . $filter['code']
			. " = \$this->getUserStateFromRequest(\$this->context . '.filter."
			. $filter['code'] . "', 'filter_" . $filter['code']
			. "'" . $extra . ");";
		if ($newFilter)
		{
			// add the new filter option
			$state .= PHP_EOL . Indent::_(2)
				. "if (\$formSubmited)";
			$state .= PHP_EOL . Indent::_(2) . "{";
			$state .= PHP_EOL . Indent::_(3) . "\$" . $filter['code']
				. " = \$app->input->post->get('" . $filter['code'] . "');";
			$state .= PHP_EOL . Indent::_(3)
				. "\$this->setState('filter." . $filter['code']
				. "', \$" . $filter['code'] . ");";
			$state .= PHP_EOL . Indent::_(2) . "}";
		}
		else
		{
			// the old filter option
			$state .= PHP_EOL . Indent::_(2)
				. "\$this->setState('filter." . $filter['code']
				. "', \$" . $filter['code'] . ");";
		}

		return $state;
	}

	/**
	 * set the default populate state code
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   bool    $newFilter       The switch to use the new filter
	 *
	 * @return  string The state code added
	 *
	 */
	protected function setDefaultPopulateState(&$nameSingleCode, $newFilter)
	{
		$state = '';
		// start filter
		$filter = array('type' => 'text');
		// if access is not set add its default filter here
		if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.access'))
		{
			$filter['code'] = "access";
			$state          .= $this->getPopulateStateFilterCode(
				$filter, $newFilter, ", 0, 'int'"
			);
		}
		// if published is not set add its default filter here
		if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.published'))
		{
			$filter['code'] = "published";
			$state          .= $this->getPopulateStateFilterCode(
				$filter, false, ", ''"
			);
		}
		// if created_by is not set add its default filter here
		if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.created_by'))
		{
			$filter['code'] = "created_by";
			$state          .= $this->getPopulateStateFilterCode(
				$filter, false, ", ''"
			);
		}
		// if created is not set add its default filter here
		if (!CFactory::_('Compiler.Builder.Field.Names')->isString($nameSingleCode . '.created'))
		{
			$filter['code'] = "created";
			$state          .= $this->getPopulateStateFilterCode(
				$filter, false
			);
		}

		// the sorting defaults are always added
		$filter['code'] = "sorting";
		$state          .= $this->getPopulateStateFilterCode(
			$filter, false, ", 0, 'int'"
		);
		// the search defaults are always added
		$filter['code'] = "search";
		$state          .= $this->getPopulateStateFilterCode($filter, false);

		return $state;
	}

	/**
	 * set the sorted field array for the getSortFields method
	 *
	 * @param   string  $nameSingleCode  The single view name
	 *
	 * @return  string The array/string of fields to add to the getSortFields method
	 *
	 */
	public function setSortFields(&$nameListCode)
	{
		// keep track of all fields already added
		$donelist = array('ordering', 'published');
		// set the default first
		$fields = "return array(";
		$fields .= PHP_EOL . Indent::_(3) . "'a.ordering' => Text:"
			. ":_('JGRID_HEADING_ORDERING')";
		$fields .= "," . PHP_EOL . Indent::_(3) . "'a.published' => Text:"
			. ":_('JSTATUS')";

		// add the rest of the set filters
		if (CFactory::_('Compiler.Builder.Sort')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Sort')->get($nameListCode) as $filter)
			{
				if (!in_array($filter['code'], $donelist))
				{
					if ($filter['type'] === 'category')
					{
						$fields .= "," . PHP_EOL . Indent::_(3)
							. "'category_title' => Text:" . ":_('"
							. $filter['lang'] . "')";
					}
					elseif (ArrayHelper::check(
						$filter['custom']
					))
					{
						$fields .= "," . PHP_EOL . Indent::_(3) . "'"
							. $filter['custom']['db'] . "."
							. $filter['custom']['text'] . "' => Text:" . ":_('"
							. $filter['lang'] . "')";
					}
					else
					{
						$fields .= "," . PHP_EOL . Indent::_(3) . "'a."
							. $filter['code'] . "' => Text:" . ":_('"
							. $filter['lang'] . "')";
					}
				}
			}
		}
		$fields .= "," . PHP_EOL . Indent::_(3) . "'a.id' => Text:"
			. ":_('JGRID_HEADING_ID')";
		$fields .= PHP_EOL . Indent::_(2) . ");";

		// return fields
		return $fields;
	}

	public function setCheckinCall()
	{
		$call = PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Check in items";
		$call .= PHP_EOL . Indent::_(2) . "\$this->checkInNow();" . PHP_EOL;

		return $call;
	}

	public function setAutoCheckin($view, $component)
	{
		$checkin = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$checkin .= PHP_EOL . Indent::_(1)
			. " * Build an SQL query to checkin all items left checked out longer then a set time.";
		$checkin .= PHP_EOL . Indent::_(1) . " *";
		$checkin .= PHP_EOL . Indent::_(1) . " * @return bool";
		$checkin .= PHP_EOL . Indent::_(1) . " * @since 3.2.0";
		$checkin .= PHP_EOL . Indent::_(1) . " */";
		$checkin .= PHP_EOL . Indent::_(1) . "protected function checkInNow(): bool";
		$checkin .= PHP_EOL . Indent::_(1) . "{";
		$checkin .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get set check in time";
		$checkin .= PHP_EOL . Indent::_(2)
			. "\$time = ComponentHelper::getParams('com_" . $component
			. "')->get('check_in');";
		$checkin .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (\$time)";
		$checkin .= PHP_EOL . Indent::_(2) . "{";
		$checkin .= PHP_EOL . Indent::_(3) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Get a db connection.";
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			$checkin .= PHP_EOL . Indent::_(3) . "\$db = Factory::getDbo();";
		}
		else
		{
			$checkin .= PHP_EOL . Indent::_(3) . "\$db = \$this->getDatabase();";
		}
		$checkin .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Reset query.";
		$checkin .= PHP_EOL . Indent::_(3) . "\$query = \$db->getQuery(true);";
		$checkin .= PHP_EOL . Indent::_(3) . "\$query->select('*');";
		$checkin .= PHP_EOL . Indent::_(3)
			. "\$query->from(\$db->quoteName('#__" . $component . "_" . $view
			. "'));";
		$checkin .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " Only select items that are checked out.";
		$checkin .= PHP_EOL . Indent::_(3)
			. "\$query->where(\$db->quoteName('checked_out') . '!=0');";
		Indent::_(3) . "//" . Line::_(__Line__, __Class__)
		. " Query only to see if we have a rows";
		$checkin .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query, 0, 1);";
		$checkin .= PHP_EOL . Indent::_(3) . "\$db->execute();";
		$checkin .= PHP_EOL . Indent::_(3) . "if (\$db->getNumRows())";
		$checkin .= PHP_EOL . Indent::_(3) . "{";
		$checkin .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
			. " Get Yesterdays date.";
		$checkin .= PHP_EOL . Indent::_(4)
			. "\$date = Factory::getDate()->modify(\$time)->toSql();";
		$checkin .= PHP_EOL . Indent::_(4) . "//" . Line::_(__Line__, __Class__)
			. " Reset query.";
		$checkin .= PHP_EOL . Indent::_(4) . "\$query = \$db->getQuery(true);";
		$checkin .= PHP_EOL . PHP_EOL . Indent::_(4) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Fields to update.";
		$checkin .= PHP_EOL . Indent::_(4) . "\$fields = array(";
		$checkin .= PHP_EOL . Indent::_(5)
			. "\$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',";
		$checkin .= PHP_EOL . Indent::_(5)
			. "\$db->quoteName('checked_out') . '=0'";
		$checkin .= PHP_EOL . Indent::_(4) . ");";
		$checkin .= PHP_EOL . PHP_EOL . Indent::_(4) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Conditions for which records should be updated.";
		$checkin .= PHP_EOL . Indent::_(4) . "\$conditions = array(";
		$checkin .= PHP_EOL . Indent::_(5)
			. "\$db->quoteName('checked_out') . '!=0', ";
		$checkin .= PHP_EOL . Indent::_(5)
			. "\$db->quoteName('checked_out_time') . '<\''.\$date.'\''";
		$checkin .= PHP_EOL . Indent::_(4) . ");";
		$checkin .= PHP_EOL . PHP_EOL . Indent::_(4) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Check table.";
		$checkin .= PHP_EOL . Indent::_(4)
			. "\$query->update(\$db->quoteName('#__" . $component . "_" . $view
			. "'))->set(\$fields)->where(\$conditions); ";
		$checkin .= PHP_EOL . PHP_EOL . Indent::_(4)
			. "\$db->setQuery(\$query);";
		$checkin .= PHP_EOL . PHP_EOL . Indent::_(4) . "return \$db->execute();";
		$checkin .= PHP_EOL . Indent::_(3) . "}";
		$checkin .= PHP_EOL . Indent::_(2) . "}";
		$checkin .= PHP_EOL . PHP_EOL . Indent::_(2) . "return false;";
		$checkin .= PHP_EOL . Indent::_(1) . "}";

		return $checkin;
	}

	public function setGetItemsMethodStringFix($nameSingleCode, $nameListCode,
		$Component, $tab = '', $export = false, $all = false)
	{
		// add the fix if this view has the need for it
		$fix          = '';
		$forEachStart = '';
		$fix_access   = '';
		// encryption switches
		foreach (CFactory::_('Config')->cryption_types as $cryptionType)
		{
			${$cryptionType . 'Crypt'} = false;
		}
		$component = StringHelper::safe($Component);
		// check if the item has permissions.
		if (CFactory::_('Compiler.Creator.Permission')->actionExist($nameSingleCode, 'core.access'))
		{
			$fix_access = PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
				. Line::_(__Line__, __Class__)
				. " Remove items the user can't access.";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "\$access = (\$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.access')
				. "', 'com_" . $component . "." . $nameSingleCode
				. ".' . (int) \$item->id) && \$user->authorise('"
				. CFactory::_('Compiler.Creator.Permission')->getAction($nameSingleCode, 'core.access')
				. "', 'com_" . $component . "'));";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "if (!\$access)";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "unset(\$items[\$nr]);";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "continue;";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}"
				. PHP_EOL;
		}
		// add the tags if needed
		if (CFactory::_('Compiler.Builder.Tags')->exists($nameSingleCode))
		{
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
				. Line::_(
					__LINE__,__CLASS__
				) . " Add the tags";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "\$item->tags = new TagsHelper;";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "\$item->tags->getTagIds(";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "\$item->id, 'com_"
				. CFactory::_('Compiler.Builder.Content.One')->get('component') . ".$nameSingleCode'";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . ");";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "if (\$item->tags->tags)";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "\$item->tags = implode(', ',";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
				. "\$item->tags->getTagNames(";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(6)
				. "explode(',', \$item->tags->tags)";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5) . ")";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . ");";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "else";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "\$item->tags = '';";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
		}
		// get the correct array
		if ($export || $all)
		{
			$action_ = 'Eximport';
		}
		else
		{
			$action_ = 'List';
		}
		// load the relations before modeling
		if (($field_relations =
			CFactory::_('Compiler.Builder.Field.Relations')->get($nameListCode)) !== null)
		{
			foreach ($field_relations as $field_id => $fields)
			{
				foreach ($fields as $area => $field)
				{
					if ($area == 1 && isset($field['code']))
					{
						$fix .= $this->setModelFieldRelation(
							$field, $nameListCode, $tab
						);
					}
				}
			}
		}
		// open the values
		if (CFactory::_("Compiler.Builder.Items.Method.{$action_}.String")->exists($nameSingleCode))
		{
			foreach (CFactory::_("Compiler.Builder.Items.Method.{$action_}.String")->
				get($nameSingleCode) as $item)
			{
				switch ($item['method'])
				{
					case 1:
						// JSON_STRING_ENCODE
						$decode        = 'json_decode';
						$suffix_decode = ', true';
						break;
					case 2:
						// BASE_SIXTY_FOUR
						$decode        = 'base64_decode';
						$suffix_decode = '';
						break;
					case 3:
						// BASIC_ENCRYPTION_LOCALKEY
						$decode        = '$basic->decryptString';
						$basicCrypt    = true;
						$suffix_decode = '';
						break;
					case 4:
						// WHMCS_ENCRYPTION_WHMCS
						$decode        = '$whmcs->decryptString';
						$whmcsCrypt    = true;
						$suffix_decode = '';
						break;
					case 5:
						// MEDIUM_ENCRYPTION_LOCALFILE
						$decode        = '$medium->decryptString';
						$mediumCrypt   = true;
						$suffix_decode = '';
						break;
					case 6:
						// EXPERT_ENCRYPTION
						$expertCrypt = true;
						break;
					default:
						// JSON_ARRAY_ENCODE
						$decode        = 'json_decode';
						$suffix_decode = ', true';
						// fallback on json
						$item['method'] = 1;
						break;
				}

				if (($item['type'] === 'usergroup' || $item['type'] === 'usergrouplist') && !$export
					&& $item['method'] != 6)
				{
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " decode " . $item['name'];
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$"
						. $item['name'] . "Array = " . $decode . "(\$item->"
						. $item['name'] . $suffix_decode . ");";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
						. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
						. $item['name'] . "Array))";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "\$"
						. $item['name'] . "Names = [];";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "foreach (\$" . $item['name'] . "Array as \$"
						. $item['name'] . ")";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5) . "\$"
						. $item['name'] . "Names[] = " . $Component
						. "Helper::getGroupName(\$" . $item['name'] . ");";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "}";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "\$item->" . $item['name'] . " =  implode(', ', \$"
						. $item['name'] . "Names);";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
				}
				/* elseif (($item['type'] === 'usergroup' || $item['type'] === 'usergrouplist') && $export)
				{
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "//".Line::_(__Line__, __Class__)." decode ".$item['name'];
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$".$item['name']."Array))";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "{";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(4) . "\$item->".$item['name']." = implode('|',\$".$item['name']."Array);";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "}";
				} */
				elseif ($item['translation'] && !$export
					&& $item['method'] != 6)
				{
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " decode " . $item['name'];
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$"
						. $item['name'] . "Array = " . $decode . "(\$item->"
						. $item['name'] . $suffix_decode . ");";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
						. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
						. $item['name'] . "Array))";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "\$"
						. $item['name'] . "Names = [];";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "foreach (\$" . $item['name'] . "Array as \$"
						. $item['name'] . ")";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5) . "\$"
						. $item['name'] . "Names[] = Text:"
						. ":_(\$this->selectionTranslation(\$" . $item['name']
						. ", '" . $item['name'] . "'));";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "}";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "\$item->" . $item['name'] . " = implode(', ', \$"
						. $item['name'] . "Names);";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
				}
				else
				{
					if ($item['method'] == 2 || $item['method'] == 3 || $item['method'] == 4
						|| $item['method'] == 5 || $item['method'] == 6)
					{
						// expert mode (dev must do it all)
						if ($item['method'] == 6)
						{
							$_placeholder_for_field
								= array('[[[field]]]' => "\$item->" . $item['name']);
							$fix .= CFactory::_('Placeholder')->update(
								PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. implode(PHP_EOL . Indent::_(1) . $tab . Indent::_(3),
									CFactory::_('Compiler.Builder.Model.Expert.Field')->get(
										$nameSingleCode . '.' . $item['name'] . '.get', []
									)
								), $_placeholder_for_field
							);
						}
						else
						{
							$taber = '';
							if ($item['method'] == 3)
							{
								$taber = Indent::_(1);
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3)
									. "if (\$basickey && !is_numeric(\$item->"
									. $item['name'] . ") && \$item->"
									. $item['name']
									. " === base64_encode(base64_decode(\$item->"
									. $item['name'] . ", true)))";
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "{";
							}
							elseif ($item['method'] == 5)
							{
								$taber = Indent::_(1);
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3)
									. "if (\$mediumkey && !is_numeric(\$item->"
									. $item['name'] . ") && \$item->"
									. $item['name']
									. " === base64_encode(base64_decode(\$item->"
									. $item['name'] . ", true)))";
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "{";
							}
							elseif ($item['method'] == 4)
							{
								$taber = Indent::_(1);
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3)
									. "if (\$whmcskey && !is_numeric(\$item->"
									. $item['name'] . ") && \$item->"
									. $item['name']
									. " === base64_encode(base64_decode(\$item->"
									. $item['name'] . ", true)))";
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "{";
							}
							if ($item['method'] == 3 || $item['method'] == 4
								|| $item['method'] == 5)
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " decrypt " . $item['name'];
							}
							else
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab . $taber
									. Indent::_(3) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " decode " . $item['name'];
							}
							$fix .= PHP_EOL . Indent::_(1) . $tab . $taber
								. Indent::_(3) . "\$item->" . $item['name']
								. " = " . $decode . "(\$item->" . $item['name']
								. ");";

							if ($item['method'] == 3 || $item['method'] == 4
								|| $item['method'] == 5)
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "}";
							}
						}
					}
					else
					{
						if ($export && $item['type'] === 'repeatable')
						{
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "//" . Line::_(__Line__, __Class__)
								. " decode repeatable " . $item['name'];
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "\$" . $item['name'] . "Array = " . $decode
								. "(\$item->" . $item['name'] . $suffix_decode
								. ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
								. $item['name'] . "Array))";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "\$bucket" . $item['name'] . " = [];";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "foreach (\$" . $item['name'] . "Array as \$"
								. $item['name'] . "FieldName => \$"
								. $item['name'] . ")";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
								. $item['name'] . "))";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(6)
								. "\$bucket" . $item['name'] . "[] = \$"
								. $item['name']
								. "FieldName . '<||VDM||>' . implode('<|VDM|>',\$"
								. $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "}";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "}";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "//" . Line::_(__Line__, __Class__)
								. " make sure the bucket has values.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$bucket"
								. $item['name'] . "))";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "//" . Line::_(__Line__, __Class__)
								. " clear the repeatable field.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "unset(\$item->" . $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "//" . Line::_(__Line__, __Class__)
								. " set repeatable field for export.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "\$item->" . $item['name']
								. " = implode('<|||VDM|||>',\$bucket"
								. $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "//" . Line::_(__Line__, __Class__)
								. " unset the bucket.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "unset(\$bucket" . $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "}";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "}";
						}
						elseif ($item['method'] == 1 && !$export)
						{
							// TODO we check if this works well.
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "//" . Line::_(__Line__, __Class__) . " convert "
								. $item['name'];
							if (isset($item['custom']['table']))
							{
								// check if this is a local table
								if (strpos(
										(string) $item['custom']['table'],
										'#__' . CFactory::_('Config')->component_code_name . '_'
									) !== false)
								{
									$keyTableNAme = str_replace(
										'#__' . CFactory::_('Config')->component_code_name . '_',
										'', (string) $item['custom']['table']
									);
								}
								else
								{
									$keyTableNAme = $item['custom']['table'];
								}
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "\$item->" . $item['name']
									. " = Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(\$item->"
									. $item['name'] . ", ', ', '"
									. $keyTableNAme . "', '"
									. $item['custom']['id'] . "', '"
									. $item['custom']['text'] . "');";
							}
							else
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "\$item->" . $item['name']
									. " = Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(\$item->"
									. $item['name'] . ", ', ', '"
									. $item['name'] . "');";
							}
						}
						else
						{
							if (!$export)
							{
								// For those we have not cached yet.
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " convert " . $item['name'];
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "\$item->" . $item['name']
									. " = Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(\$item->"
									. $item['name'] . ");";
							}
						}
					}
				}
			}
		}
		/* // set translation (TODO) would be nice to cut down on double loops..
		if (!$export && CFactory::_('Compiler.Builder.Selection.Translation')->exists($nameListCode))
		{
			foreach (CFactory::_('Compiler.Builder.Selection.Translation')->get($nameListCode) as $name => $values)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//" . Line::_(__Line__, __Class__) . " convert " . $name;
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$item->" . $name . " = \$this->selectionTranslation(\$item->" . $name . ", '" . $name . "');";
			}
		} */
		// load the relations after modeling
		if (($field_relations =
			CFactory::_('Compiler.Builder.Field.Relations')->get($nameListCode)) !== null)
		{
			foreach ($field_relations as $fields)
			{
				foreach ($fields as $area => $field)
				{
					if ($area == 3 && isset($field['code']))
					{
						$fix .= $this->setModelFieldRelation(
							$field, $nameListCode, $tab
						);
					}
				}
			}
		}
		// close the foreach if needed
		if (StringHelper::check($fix) || StringHelper::check($fix_access) || $export || $all)
		{
			// start the loop
			$forEachStart = PHP_EOL . PHP_EOL . Indent::_(1) . $tab . Indent::_(
					1
				) . "//" . Line::_(__Line__, __Class__)
				. " Set values to display correctly.";
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items))";
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "{";
			// do not add to export since it is already done
			if (!$export)
			{
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "//" . Line::_(__Line__, __Class__)
					. " Get the user object if not set.";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "if (!isset(\$user) || !"
					. "Super_" . "__91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(\$user))";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "{";
				if (CFactory::_('Config')->get('joomla_version', 3) == 3)
				{
					$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
						. "\$user = Factory::getUser();";
				}
				else
				{
					$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
						. "\$user = \$this->getCurrentUser();";
				}
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "}";
			}
			// the permissional acttion switch
			$hasPermissional = false;
			// add the permissional removal of values the user has not right to view or access
			if (CFactory::_('Config')->get('permission_strict_per_field', false)
				&& CFactory::_('Compiler.Builder.Permission.Fields')->isArray($nameSingleCode))
			{
				foreach (CFactory::_('Compiler.Builder.Permission.Fields')->get($nameSingleCode)
					as $fieldName => $permission_options)
				{
					if (!$hasPermissional)
					{
						foreach ($permission_options as $permission_option => $fieldType)
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
					$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							2
						) . "//" . Line::_(__Line__, __Class__)
						. " Get global permissional control activation. (default is inactive)";
					$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							2
						)
						. "\$strict_permission_per_field = ComponentHelper::getParams('com_"
						. $component
						. "')->get('strict_permission_per_field', 0);"
						. PHP_EOL;
				}
			}
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
				. "foreach (\$items as \$nr => &\$item)";
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "{";
			// add the access options
			$forEachStart .= $fix_access;
			// add the permissional removal of values the user has not right to view or access
			if ($hasPermissional)
			{
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "//" . Line::_(__Line__, __Class__)
					. " use permissional control if globally set.";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "if (\$strict_permission_per_field)";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "{";
				foreach (CFactory::_('Compiler.Builder.Permission.Fields')->get($nameSingleCode)
					as $fieldName => $permission_options)
				{
					foreach ($permission_options as $permission_option => $fieldType)
					{
						switch ($permission_option)
						{
							case 'access':
							case 'view':
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " set " . $permission_option
									. " permissional control for " . $fieldName
									. " value.";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "if (isset(\$item->"
									. $fieldName . ") && (!\$user->authorise('"
									. $nameSingleCode . "."
									. $permission_option . "." . $fieldName
									. "', 'com_" . $component . "."
									. $nameSingleCode
									. ".' . (int) \$item->id)";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(5) . "|| !\$user->authorise('"
									. $nameSingleCode . "."
									. $permission_option . "." . $fieldName
									. "', 'com_" . $component . "')))";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "{";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(5) . "//" . Line::_(
										__LINE__,__CLASS__
									)
									. " We JUST empty the value (do you have a better idea)";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(5) . "\$item->" . $fieldName
									. " = '';";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "}";
								break;
						}
					}
				}
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "}";
			}
			// remove these values if export
			if ($export)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__)
					. " unset the values we don't want exported.";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "unset(\$item->asset_id);";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "unset(\$item->checked_out);";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "unset(\$item->checked_out_time);";
			}

			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "}";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}";
			if ($export)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "//"
					. Line::_(__Line__, __Class__) . " Add headers to items array.";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$headers = \$this->getExImPortHeaders();";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "if ("
					. "Super_" . "__91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(\$headers))";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "{";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "array_unshift(\$items,\$headers);";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}";
			}
		}

		// add custom php to getitems method
		$fix .= CFactory::_('Customcode.Dispenser')->get(
			'php_getitems', $nameSingleCode, PHP_EOL . PHP_EOL . $tab
		);

		// load the encryption object if needed
		$script = '';
		foreach (CFactory::_('Config')->cryption_types as $cryptionType)
		{
			if (${$cryptionType . 'Crypt'})
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . Indent::_(1) . $tab
						. Indent::_(1) . "//" . Line::_(__Line__, __Class__)
						. " Get the " . $cryptionType . " encryption key.";
					$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$" . $cryptionType . "key = " . $Component
						. "Helper::getCryptKey('" . $cryptionType . "');";
					$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "//" . Line::_(__Line__, __Class__)
						. " Get the encryption object.";
					$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$" . $cryptionType . " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$"
						. $cryptionType . "key);";
				}
				elseif (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
					exists("{$nameSingleCode}.get"))
				{
					foreach (CFactory::_('Compiler.Builder.Model.' . ucfirst($cryptionType).  '.Field.Initiator')->
						get("{$nameSingleCode}.get") as $block)
					{
						$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . implode(
							PHP_EOL . Indent::_(1) . $tab . Indent::_(1), $block
						);
					}
				}
			}
		}

		// add the encryption script
		return $script . $forEachStart . $fix;
	}

	/**
	 * Build headers for the various files
	 *
	 * @param   string  $context     The name of the context
	 * @param   string  $codeName    The view, views, or layout code name
	 * @param   string  $default     The default to return if none is found
	 *
	 * @return  string The php to place in the header
	 * @deprecated 3.3 Use CFactory::_('Header')->get($context, $codeName, $default);
	 */
	public function setFileHeader($context, $codeName, $default = '')
	{
		return CFactory::_('Header')->get($context, $codeName, $default);
	}

	/**
	 * set Helper Dynamic Headers
	 *
	 * @param   array   $headers  The headers array
	 * @param   string  $target_client
	 *
	 * @return void
	 * @deprecated 3.3
	 */
	protected function setHelperClassHeader(&$headers, $target_client)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_HR_HTHREES_WARNINGHTHREE', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	/**
	 * Build chosen multi selection headers for the view
	 *
	 * @param   array   $headers       The headers array
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	protected function setChosenMultiSelectionHeaders(&$headers, $nameListCode)
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_HR_HTHREES_WARNINGHTHREE', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	protected function setModelFieldRelation($item, $nameListCode, $tab)
	{
		$fix = '';
		// set fields
		$field = [];
		// set list field name
		$field['$item->{' . (int) $item['listfield'] . '}'] = '$item->'
			. $item['code'];
		// load joint field names
		if (isset($item['joinfields'])
			&& ArrayHelper::check(
				$item['joinfields']
			))
		{
			foreach ($item['joinfields'] as $join)
			{
				$field['$item->{' . (int) $join . '}'] = '$item->'
					. CFactory::_('Compiler.Builder.List.Join')->get($nameListCode . '.' . (int) $join . '.code', 'error');
			}
		}
		// set based on join_type
		if ($item['join_type'] == 2)
		{
			// code
			$code = (array) explode(
				PHP_EOL, str_replace(
					array_keys($field), array_values($field), (string) $item['set']
				)
			);
			$fix  .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . implode(
					PHP_EOL . Indent::_(1) . $tab . Indent::_(3), $code
				);
		}
		else
		{
			// concatenate
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
				. Line::_(__Line__, __Class__) . " concatenate these fields";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$item->"
				. $item['code'] . ' = ' . implode(
					" . '" . str_replace("'", '&apos;', (string) $item['set']) . "' . ",
					$field
				) . ';';
		}

		return CFactory::_('Placeholder')->update_($fix);
	}

	public function setSelectionTranslationFix($views, $Component, $tab = '')
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (CFactory::_('Compiler.Builder.Selection.Translation')->exists($views))
		{
			$fix .= PHP_EOL . PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. "//" . Line::_(__Line__, __Class__)
				. " set selection value to a translatable value";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items))";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "{";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
				. "foreach (\$items as \$nr => &\$item)";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "{";
			foreach (CFactory::_('Compiler.Builder.Selection.Translation')->
				get($views) as $name => $values)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " convert " . $name;
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "\$item->" . $name
					. " = \$this->selectionTranslation(\$item->" . $name . ", '"
					. $name . "');";
			}
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "}";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}"
				. PHP_EOL;
		}

		return $fix;
	}

	public function setSelectionTranslationFixFunc($views, $Component)
	{
		// add the fix if this view has the need for it
		$fix = '';
		if (CFactory::_('Compiler.Builder.Selection.Translation')->exists($views))
		{
			$fix .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$fix .= PHP_EOL . Indent::_(1)
				. " * Method to convert selection values to translatable string.";
			$fix .= PHP_EOL . Indent::_(1) . " *";
			$fix .= PHP_EOL . Indent::_(1) . " * @return  string   The translatable string.";
			$fix .= PHP_EOL . Indent::_(1) . " */";
			$fix .= PHP_EOL . Indent::_(1)
				. "public function selectionTranslation(\$value,\$name)";
			$fix .= PHP_EOL . Indent::_(1) . "{";
			foreach (CFactory::_('Compiler.Builder.Selection.Translation')->
				get($views) as $name => $values)
			{
				if (ArrayHelper::check($values))
				{
					$fix     .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Array of " . $name . " language strings";
					$fix     .= PHP_EOL . Indent::_(2) . "if (\$name === '"
						. $name . "')";
					$fix     .= PHP_EOL . Indent::_(2) . "{";
					$fix     .= PHP_EOL . Indent::_(3) . "\$" . $name
						. "Array = array(";
					$counter = 0;
					foreach ($values as $value => $translang)
					{
						// only add quotes to strings
						if (StringHelper::check($value))
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
							$fix .= PHP_EOL . Indent::_(4) . $key . " => '"
								. $translang . "'";
						}
						else
						{
							$fix .= "," . PHP_EOL . Indent::_(4) . $key
								. " => '" . $translang . "'";
						}
						$counter++;
					}
					$fix .= PHP_EOL . Indent::_(3) . ");";
					$fix .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Now check if value is found in this array";
					$fix .= PHP_EOL . Indent::_(3) . "if (isset(\$" . $name
						. "Array[\$value]) && "
						. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$" . $name . "Array[\$value]))";
					$fix .= PHP_EOL . Indent::_(3) . "{";
					$fix .= PHP_EOL . Indent::_(4) . "return \$" . $name
						. "Array[\$value];";
					$fix .= PHP_EOL . Indent::_(3) . "}";
					$fix .= PHP_EOL . Indent::_(2) . "}";
				}
			}
			$fix .= PHP_EOL . Indent::_(2) . "return \$value;";
			$fix .= PHP_EOL . Indent::_(1) . "}";
		}

		return $fix;
	}

	public function setRouterCase($viewsCodeName)
	{
		if (strlen((string) $viewsCodeName) > 0)
		{
			$router = PHP_EOL . Indent::_(2) . "case '" . $viewsCodeName . "':";
			$router .= PHP_EOL . Indent::_(3)
				. "\$id = explode(':', \$segments[\$count-1]);";
			$router .= PHP_EOL . Indent::_(3) . "\$vars['id'] = (int) \$id[0];";
			$router .= PHP_EOL . Indent::_(3) . "\$vars['view'] = '"
				. $viewsCodeName
				. "';";
			$router .= PHP_EOL . Indent::_(2) . "break;";

			return $router;
		}

		return '';
	}

	public function setComponentImageType($path)
	{
		$type = \ComponentbuilderHelper::imageInfo($path);
		if ($type)
		{
			$imagePath = CFactory::_('Utilities.Paths')->component_path . '/admin/assets/images';
			// move the image to its place
			File::copy(
				JPATH_SITE . '/' . $path,
				$imagePath . '/vdm-component.' . $type
			);
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
		return CFactory::_('Compiler.Builder.Permission.Dashboard')->build();
	}

	public function setDashboardIcons()
	{
		if (CFactory::_('Component')->isArray('admin_views'))
		{
			$icons    = '';
			$counter  = 0;
			$catArray = [];
			foreach (CFactory::_('Component')->get('admin_views') as $view)
			{
				$name_single = StringHelper::safe(
					$view['settings']->name_single
				);
				$name_list   = StringHelper::safe(
					$view['settings']->name_list
				);

				$icons .= $this->addCustomDashboardIcons($view, $counter);
				if (isset($view['dashboard_add'])
					&& $view['dashboard_add'] == 1)
				{
					$type = \ComponentbuilderHelper::imageInfo(
						$view['settings']->icon_add
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $name_single . ".add"]
							= $view['settings']->icon_add;
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
					$langName = 'Add&nbsp;'
						. StringHelper::safe(
							$view['settings']->name_single, 'W'
						) . '<br /><br />';
					$langKey  = CFactory::_('Config')->lang_prefix . '_DASHBOARD_'
						. StringHelper::safe(
							$view['settings']->name_single, 'U'
						) . '_ADD';
					// add to lang
					CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langKey, $langName);
					$counter++;
				}
				if (isset($view['dashboard_list'])
					&& $view['dashboard_list'] == 1)
				{
					$type = \ComponentbuilderHelper::imageInfo(
						$view['settings']->icon
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $name_list]
							= $view['settings']->icon;
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
					$langName = StringHelper::safe(
							$view['settings']->name_list, 'W'
						) . '<br /><br />';
					$langKey  = CFactory::_('Config')->lang_prefix . '_DASHBOARD_'
						. StringHelper::safe(
							$view['settings']->name_list, 'U'
						);
					// add to lang
					CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langKey, $langName);
					$counter++;
				}
				// dashboard link to category on dashboard is build here
				if (CFactory::_('Compiler.Builder.Category')->exists("{$name_list}.code") &&
					CFactory::_('Compiler.Builder.Category')->get("{$name_list}.add_icon"))
				{
					$catCode = CFactory::_('Compiler.Builder.Category')->get("{$name_list}.code");

					// check if category has another name
					$otherViews = CFactory::_('Compiler.Builder.Category.Other.Name')->
						get($name_list . '.views', $name_list);
					$otherNames  = CFactory::_('Compiler.Builder.Category.Other.Name')->
						get($name_list . '.name');
					if ($otherNames !== null)
					{
						// build lang
						$langName = StringHelper::safe(
							$otherNames, 'W'
						);
					}
					else
					{
						// build lang
						$langName = 'Categories&nbsp;For<br />'
							. StringHelper::safe(
								$otherViews, 'W'
							);
					}
					// only load this category once
					if (!in_array($otherViews, $catArray))
					{
						// set the extension key string, new convention (more stable)
						$_key_extension = str_replace(
							'.', '_po0O0oq_',
							(string) CFactory::_('Compiler.Builder.Category')->get("{$name_list}.extension", 'error')
						);

						// add to lang
						$langKey = CFactory::_('Config')->lang_prefix . '_DASHBOARD_'
							. StringHelper::safe(
								$otherViews, 'U'
							) . '_' . StringHelper::safe(
								$catCode, 'U'
							);
						CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langKey, $langName);
						// get image type
						$type = \ComponentbuilderHelper::imageInfo(
							$view['settings']->icon_category
						);
						if ($type)
						{
							$type = $type . ".";
							// icon builder loader
							$this->iconBuilder[$type . $otherViews . "."
							. $catCode]
								= $view['settings']->icon_category;
						}
						else
						{
							$type = 'png.';
						}
						if ($counter == 0)
						{
							$icons .= "'" . $type . $otherViews . "." . $catCode
								. '_qpo0O0oqp_' . $_key_extension . "'";
						}
						else
						{
							$icons .= ", '" . $type . $otherViews . "."
								. $catCode . '_qpo0O0oqp_' . $_key_extension
								. "'";
						}
						$counter++;
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
				}
			}
			if (isset($this->lastCustomDashboardIcon)
				&& ArrayHelper::check(
					$this->lastCustomDashboardIcon
				))
			{
				foreach ($this->lastCustomDashboardIcon as $icon)
				{
					$icons .= $icon;
				}
				unset($this->lastCustomDashboardIcon);
			}
			if (isset($this->iconBuilder)
				&& ArrayHelper::check(
					$this->iconBuilder
				))
			{
				$imagePath = CFactory::_('Utilities.Paths')->component_path
					. '/admin/assets/images/icons';
				foreach ($this->iconBuilder as $icon => $path)
				{
					$array_buket = explode('.', (string) $icon);
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
					File::copy(
						JPATH_SITE . '/' . $path, $imagePath . '/' . $imageName
					);
				}
			}

			return $icons;
		}

		return false;
	}

	public function setDashboardModelMethods()
	{
		if (CFactory::_('Component')->isString('php_dashboard_methods'))
		{
			// get hte value
			$php_dashboard_methods = CFactory::_('Component')->get('php_dashboard_methods');
			// get all the mothods that should load date to the view
			$this->DashboardGetCustomData
				= GetHelper::allBetween(
				$php_dashboard_methods,
				'public function get', '()'
			);

			// return the methods
			return PHP_EOL . PHP_EOL . CFactory::_('Placeholder')->update_(
					$php_dashboard_methods
				);
		}

		return '';
	}

	public function setDashboardGetCustomData()
	{
		if (isset($this->DashboardGetCustomData)
			&& ArrayHelper::check(
				$this->DashboardGetCustomData
			))
		{
			// gets array reset
			$gets = [];
			// set dashboard gets
			foreach ($this->DashboardGetCustomData as $get)
			{
				$string = StringHelper::safe($get);
				$gets[] = "\$this->" . $string . " = \$this->get('" . $get
					. "');";
			}

			// return the gets
			return PHP_EOL . Indent::_(2) . implode(
					PHP_EOL . Indent::_(2), $gets
				);
		}

		return '';
	}

	public function setDashboardDisplayData()
	{
		if (CFactory::_('Config')->get('joomla_version', 3) == 3)
		{
			return $this->setDashboardDisplayDataJ3();
		}
		return $this->setDashboardDisplayDataJ4();
	}

	public function setDashboardDisplayDataJ3()
	{
		// display array reset
		$display           = [];
		$mainAccordianName = 'cPanel';
		$builder           = [];
		$tab               = Indent::_(3);
		$loadTabs          = false;
		$width_class       = 'span';
		$row_class         = 'row-fluid';
		$form_class        = 'form-horizontal';
		$uitab             = 'bootstrap';

		// check if we have custom tabs
		if (CFactory::_('Component')->isArray('dashboard_tab'))
		{
			// build the tabs and accordians
			foreach (CFactory::_('Component')->get('dashboard_tab') as $data)
			{
				$builder[$data['name']][$data['header']]
					= CFactory::_('Placeholder')->update_(
					$data['html']
				);
			}
			// since we have custom tabs we must load the tab structure around the cpanel
			$display[] = '<div id="j-main-container">';
			$display[] = Indent::_(1) . '<div class="' . $form_class . '">';
			$display[] = Indent::_(1)
				. "<?php echo Html::_('{$uitab}.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>";
			$display[] = PHP_EOL . Indent::_(2)
				. "<?php echo Html::_('{$uitab}.addTab', 'cpanel_tab', 'cpanel', Text:"
				. ":_('cPanel', true)); ?>";
			$display[] = Indent::_(2) . '<div class="' . $row_class . '">';
			// change the name of the main tab
			$mainAccordianName = 'Control Panel';
			$loadTabs          = true;
		}
		else
		{
			$display[] = '<div id="j-main-container">';
			$display[] = Indent::_(1) . '<div class="' . $form_class . '" style="padding: 20px;">';
			$display[] = Indent::_(2) . '<div class="' . $row_class . '">';
		}
		// set dashboard display
		$display[] = $tab . '<div class="' . $width_class . '9">';
		$display[] = $tab . Indent::_(1)
			. "<?php echo Html::_('bootstrap.startAccordion', 'dashboard_left', array('active' => 'main')); ?>";
		$display[] = $tab . Indent::_(2)
			. "<?php echo Html::_('bootstrap.addSlide', 'dashboard_left', '"
			. $mainAccordianName . "', 'main'); ?>";
		$display[] = $tab . Indent::_(3)
			. "<?php echo \$this->loadTemplate('main');?>";
		$display[] = $tab . Indent::_(2)
			. "<?php echo Html::_('bootstrap.endSlide'); ?>";
		$display[] = $tab . Indent::_(1)
			. "<?php echo Html::_('bootstrap.endAccordion'); ?>";
		$display[] = $tab . "</div>";
		$display[] = $tab . '<div class="' . $width_class . '3">';
		$display[] = $tab . Indent::_(1)
			. "<?php echo Html::_('bootstrap.startAccordion', 'dashboard_right', array('active' => 'vdm')); ?>";
		$display[] = $tab . Indent::_(2)
			. "<?php echo Html::_('bootstrap.addSlide', 'dashboard_right', '"
			. CFactory::_('Compiler.Builder.Content.One')->get('COMPANYNAME')
			. "', 'vdm'); ?>";
		$display[] = $tab . Indent::_(3)
			. "<?php echo \$this->loadTemplate('vdm');?>";
		$display[] = $tab . Indent::_(2)
			. "<?php echo Html::_('bootstrap.endSlide'); ?>";
		$display[] = $tab . Indent::_(1)
			. "<?php echo Html::_('bootstrap.endAccordion'); ?>";
		$display[] = $tab . "</div>";

		if ($loadTabs)
		{
			$display[] = Indent::_(2) . "</div>";
			$display[] = Indent::_(2)
				. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			// load the new tabs
			foreach ($builder as $tabname => $accordians)
			{
				$alias        = StringHelper::safe($tabname);
				$display[]    = PHP_EOL . Indent::_(2)
					. "<?php echo Html::_('{$uitab}.addTab', 'cpanel_tab', '"
					. $alias . "', Text:" . ":_('" . $tabname
					. "', true)); ?>";
				$display[]    = Indent::_(2) . '<div class="' . $row_class . '">';
				$display[]    = $tab . '<div class="' . $width_class . '12">';
				$display[]    = $tab . Indent::_(1)
					. "<?php  echo Html::_('bootstrap.startAccordion', '"
					. $alias . "_accordian', array('active' => '" . $alias
					. "_one')); ?>";
				$slidecounter = 1;
				foreach ($accordians as $accordianname => $html)
				{
					$ac_alias    = StringHelper::safe(
						$accordianname
					);
					$counterName = StringHelper::safe(
						$slidecounter
					);
					$tempName    = $alias . '_' . $ac_alias;
					$display[]   = $tab . Indent::_(2)
						. "<?php  echo Html::_('bootstrap.addSlide', '"
						. $alias . "_accordian', '" . $accordianname . "', '"
						. $alias . "_" . $counterName . "'); ?>";
					$display[]   = $tab . Indent::_(3)
						. "<?php echo \$this->loadTemplate('" . $tempName
						. "');?>";
					$display[]   = $tab . Indent::_(2)
						. "<?php  echo Html::_('bootstrap.endSlide'); ?>";
					$slidecounter++;
					// build the template file
					$target = array('custom_admin' => CFactory::_('Config')->component_code_name);
					CFactory::_('Utilities.Structure')->build($target, 'template', $tempName);
					// set the file data
					$TARGET = StringHelper::safe(
						CFactory::_('Config')->build_target, 'U'
					);
					// SITE_TEMPLATE_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '_' . $tempName . '|CUSTOM_ADMIN_TEMPLATE_BODY', PHP_EOL . $html);
					// SITE_TEMPLATE_CODE_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '_' . $tempName . '|CUSTOM_ADMIN_TEMPLATE_CODE_BODY', '');
				}
				$display[] = $tab . Indent::_(1)
					. "<?php  echo Html::_('bootstrap.endAccordion'); ?>";
				$display[] = $tab . "</div>";
				$display[] = Indent::_(2) . "</div>";
				$display[] = Indent::_(2)
					. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			}

			$display[] = PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTabSet'); ?>";
		}
		else
		{
			$display[] = Indent::_(2) . "</div>";
		}
		$display[] = Indent::_(1) . "</div>";
		$display[] = "</div>";

		// return the display
		return PHP_EOL . implode(PHP_EOL, $display);
	}

	public function setDashboardDisplayDataJ4()
	{
		// display array reset
		$display           = [];
		$mainAccordianName = 'cPanel';
		$builder           = [];
		$tab               = Indent::_(3);
		$loadTabs          = false;
		$width_class       = 'col-md-';
		$row_class         = 'row';
		$form_class        = 'main-card';
		$uitab             = 'uitab';

		// check if we have custom tabs
		if (CFactory::_('Component')->isArray('dashboard_tab'))
		{
			// build the tabs and accordians
			foreach (CFactory::_('Component')->get('dashboard_tab') as $data)
			{
				$builder[$data['name']][$data['header']]
					= CFactory::_('Placeholder')->update_(
					$data['html']
				);
			}
			// since we have custom tabs we must load the tab structure around the cpanel
			$display[] = '<div id="j-main-container">';
			$display[] = Indent::_(1) . '<div class="' . $form_class . '">';
			$display[] = Indent::_(1)
				. "<?php echo Html::_('{$uitab}.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>";
			$display[] = PHP_EOL . Indent::_(2)
				. "<?php echo Html::_('{$uitab}.addTab', 'cpanel_tab', 'cpanel', Text:"
				. ":_('cPanel', true)); ?>";
			$display[] = Indent::_(2) . '<div class="' . $row_class . '">';
			// change the name of the main tab
			$mainAccordianName = 'Control Panel';
			$loadTabs          = true;
		}
		else
		{
			$display[] = '<div id="j-main-container">';
			$display[] = Indent::_(1) . '<div class="' . $form_class . '" style="padding: 20px;">';
			$display[] = Indent::_(2) . '<div class="' . $row_class . '">';
		}
		// set dashboard display
		$display[] = $tab . '<div class="' . $width_class . '9">';
		$display[] = $tab . Indent::_(1)
			. "<?php echo \$this->loadTemplate('main');?>";
		$display[] = $tab . "</div>";
		$display[] = $tab . '<div class="' . $width_class . '3">';
		$display[] = $tab . Indent::_(1)
			. "<?php echo \$this->loadTemplate('vdm');?>";
		$display[] = $tab . "</div>";

		if ($loadTabs)
		{
			$display[] = Indent::_(2) . "</div>";
			$display[] = Indent::_(2)
				. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			// load the new tabs
			foreach ($builder as $tabname => $accordians)
			{
				$alias        = StringHelper::safe($tabname);
				$display[]    = PHP_EOL . Indent::_(2)
					. "<?php echo Html::_('{$uitab}.addTab', 'cpanel_tab', '"
					. $alias . "', Text:" . ":_('" . $tabname
					. "', true)); ?>";
				$display[]    = Indent::_(2) . '<div class="' . $row_class . '">';
				$display[]    = $tab . '<div class="' . $width_class . '12">';
				$slidecounter = 1;
				foreach ($accordians as $accordianname => $html)
				{
					$ac_alias    = StringHelper::safe(
						$accordianname
					);
					$counterName = StringHelper::safe(
						$slidecounter
					);
					$tempName    = $alias . '_' . $ac_alias;
					$display[]   = $tab . Indent::_(1)
						. "<?php echo \$this->loadTemplate('" . $tempName
						. "');?>";
					$slidecounter++;
					// build the template file
					$target = array('custom_admin' => CFactory::_('Config')->component_code_name);
					CFactory::_('Utilities.Structure')->build($target, 'template', $tempName);
					// set the file data
					$TARGET = StringHelper::safe(
						CFactory::_('Config')->build_target, 'U'
					);
					// SITE_TEMPLATE_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '_' . $tempName . '|CUSTOM_ADMIN_TEMPLATE_BODY', PHP_EOL . $html);
					// SITE_TEMPLATE_CODE_BODY <<<DYNAMIC>>>
					CFactory::_('Compiler.Builder.Content.Multi')->set(CFactory::_('Config')->component_code_name . '_' . $tempName . '|CUSTOM_ADMIN_TEMPLATE_CODE_BODY', '');
				}
				$display[] = $tab . "</div>";
				$display[] = Indent::_(2) . "</div>";
				$display[] = Indent::_(2)
					. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			}

			$display[] = PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTabSet'); ?>";
		}
		else
		{
			$display[] = Indent::_(2) . "</div>";
		}
		$display[] = Indent::_(1) . "</div>";
		$display[] = "</div>";

		// return the display
		return PHP_EOL . implode(PHP_EOL, $display);
	}

	public function addCustomDashboardIcons(&$view, &$counter)
	{
		$icon = '';
		if (CFactory::_('Component')->isArray('custom_admin_views'))
		{
			foreach (CFactory::_('Component')->get('custom_admin_views') as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code])
					&& isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& $menu['before'] == $view['adminview'])
				{
					$type = \ComponentbuilderHelper::imageInfo(
						$menu['settings']->icon
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $menu['settings']->code]
							= $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName = $menu['settings']->name . '<br /><br />';
					$langKey  = CFactory::_('Config')->lang_prefix . '_DASHBOARD_'
						. $menu['settings']->CODE;
					// add to lang
					CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langKey, $langName);
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
				elseif (!isset($this->customAdminAdded[$menu['settings']->code])
					&& isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& empty($menu['before']))
				{
					$type = \ComponentbuilderHelper::imageInfo(
						$menu['settings']->icon
					);
					if ($type)
					{
						$type = $type . ".";
						// icon builder loader
						$this->iconBuilder[$type . $menu['settings']->code]
							= $menu['settings']->icon;
					}
					else
					{
						$type = 'png.';
					}
					// build lang
					$langName = $menu['settings']->name . '<br /><br />';
					$langKey  = CFactory::_('Config')->lang_prefix . '_DASHBOARD_'
						. $menu['settings']->CODE;
					// add to lang
					CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langKey, $langName);
					// set icon
					$this->lastCustomDashboardIcon[$nr] = ", '" . $type
						. $menu['settings']->code . "'";
				}
			}
		}
		// see if we should have custom menus
		if (CFactory::_('Component')->isArray('custommenus'))
		{
			foreach (CFactory::_('Component')->get('custommenus') as $nr => $menu)
			{
				$nr        = $nr + 100;
				$nameList  = StringHelper::safe(
					$menu['name_code']
				);
				$nameUpper = StringHelper::safe(
					$menu['name_code'], 'U'
				);
				if (isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& $view['adminview'] == $menu['before'])
				{
					$type = \ComponentbuilderHelper::imageInfo(
						'images/' . $menu['icon']
					);
					if ($type)
					{
						// icon builder loader
						$this->iconBuilder[$type . "." . $nameList] = 'images/'
							. $menu['icon'];
					}
					else
					{
						$type = 'png';
					}
					// build lang
					$langName = $menu['name'] . '<br /><br />';
					$langKey  = CFactory::_('Config')->lang_prefix . '_DASHBOARD_' . $nameUpper;
					// add to lang
					CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langKey, $langName);

					// if this is a link build the icon values with pipe
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						// set icon
						if ($counter == 0)
						{
							$counter++;
							$icon .= "'" . $type . "||" . $nameList . "||"
								. $menu['link'] . "'";
						}
						else
						{
							$counter++;
							$icon .= ", '" . $type . "||" . $nameList . "||"
								. $menu['link'] . "'";
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
				elseif (isset($menu['dashboard_list'])
					&& $menu['dashboard_list'] == 1
					&& empty($menu['before']))
				{
					$type = \ComponentbuilderHelper::imageInfo(
						'images/' . $menu['icon']
					);
					if ($type)
					{
						// icon builder loader
						$this->iconBuilder[$type . "." . $nameList] = 'images/'
							. $menu['icon'];
					}
					else
					{
						$type = 'png';
					}
					// build lang
					$langName = $menu['name'] . '<br /><br />';
					$langKey  = CFactory::_('Config')->lang_prefix . '_DASHBOARD_' . $nameUpper;
					// add to lang
					CFactory::_('Language')->set(CFactory::_('Config')->lang_target, $langKey, $langName);

					// if this is a link build the icon values with pipe
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '" . $type
							. "||" . $nameList . "||" . $menu['link'] . "'";
					}
					else
					{
						// set icon
						$this->lastCustomDashboardIcon[$nr] = ", '" . $type
							. "." . $nameList . "'";
					}
				}
			}
		}

		return $icon;
	}

	public function setSubMenus()
	{
		if (CFactory::_('Component')->isArray('admin_views'))
		{
			$menus = '';
			// main lang prefix
			$lang = CFactory::_('Config')->lang_prefix . '_SUBMENU';
			// set the code name
			$codeName = CFactory::_('Config')->component_code_name;
			// set default dashboard
			if (!CFactory::_('Registry')->get('build.dashboard'))
			{
				$menus .= "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang
					. "_DASHBOARD'), 'index.php?option=com_" . $codeName
					. "&view=" . $codeName . "', \$submenu === '" . $codeName
					. "');";
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lang . '_DASHBOARD', 'Dashboard'
				);
			}
			$catArray = [];
			// loop over all the admin views
			foreach (CFactory::_('Component')->get('admin_views') as $view)
			{
				// set custom menu
				$menus          .= $this->addCustomSubMenu(
					$view, $codeName, $lang
				);
				$nameSingleCode = $view['settings']->name_single_code;
				$nameListCode   = $view['settings']->name_list_code;
				$nameUpper      = StringHelper::safe(
					$view['settings']->name_list, 'U'
				);
				// check if view is set to be in the sub-menu
				if (isset($view['submenu']) && $view['submenu'] == 1)
				{
					// setup access defaults
					$tab      = "";
					$has_permissions = false;
					// check if the item has permissions.
					if (CFactory::_('Compiler.Creator.Permission')->globalExist($nameSingleCode, 'core.access'))
					{
						$menus .= PHP_EOL . Indent::_(2)
							. "if (\$user->authorise('"
							. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingleCode, 'core.access')
							. "', 'com_" . $codeName
							. "') && \$user->authorise('" . $nameSingleCode
							. ".submenu', 'com_" . $codeName . "'))";
						$menus .= PHP_EOL . Indent::_(2) . "{";
						// add tab to lines to follow
						$tab = Indent::_(1);
						$has_permissions = true;
					}
					$menus .= PHP_EOL . Indent::_(2) . $tab
						. "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang . "_"
						. $nameUpper . "'), 'index.php?option=com_" . $codeName
						. "&view=" . $nameListCode . "', \$submenu === '"
						. $nameListCode . "');";
					CFactory::_('Language')->set(
						CFactory::_('Config')->lang_target, $lang . "_" . $nameUpper,
						$view['settings']->name_list
					);
					// check if category has another name
					$otherViews = CFactory::_('Compiler.Builder.Category.Other.Name')->
						get($nameListCode . '.views', $nameListCode);
					// first check if category sub-menu should be added
					// then check if view has category, if true add sub-menu for it
					if ($view['settings']->add_category_submenu == 1
						&& CFactory::_('Compiler.Builder.Category')->exists("{$nameListCode}.extension")
						&& !in_array($otherViews, $catArray))
					{
						// get the extension array
						$_extension_array = (array) explode(
							'.',
							(string) CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension")
						);
						// set the menu selection
						if (isset($_extension_array[1]))
						{
							$_menu = "categories." . trim($_extension_array[1]);
						}
						else
						{
							$_menu = "categories";
						}
						// now load the menus
						$menus .= PHP_EOL . Indent::_(2) . $tab
							. "\JHtmlSidebar::addEntry(Text:" . ":_('"
							. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.name", 'error')
							. "'), 'index.php?option=com_categories&view=categories&extension="
							. CFactory::_('Compiler.Builder.Category')->get("{$nameListCode}.extension")
							. "', \$submenu === '" . $_menu . "');";
						// make sure we add a category only once
						$catArray[] = $otherViews;
					}
					// check if the item has permissions.
					if ($has_permissions)
					{
						$menus .= PHP_EOL . Indent::_(2) . "}";
					}
				}
				// set the Joomla custom fields options
				if (isset($view['joomla_fields'])
					&& $view['joomla_fields'] == 1)
				{
					$menus .= PHP_EOL . Indent::_(2)
						. "if (ComponentHelper::isEnabled('com_fields'))";
					$menus .= PHP_EOL . Indent::_(2) . "{";
					$menus .= PHP_EOL . Indent::_(3)
						. "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang . "_"
						. $nameUpper
						. "_FIELDS'), 'index.php?option=com_fields&context=com_"
						. $codeName . "." . $nameSingleCode
						. "', \$submenu === 'fields.fields');";
					$menus .= PHP_EOL . Indent::_(3)
						. "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang . "_"
						. $nameUpper
						. "_FIELDS_GROUPS'), 'index.php?option=com_fields&view=groups&context=com_"
						. $codeName . "." . $nameSingleCode
						. "', \$submenu === 'fields.groups');";
					$menus .= PHP_EOL . Indent::_(2) . "}";
					CFactory::_('Language')->set(
						CFactory::_('Config')->lang_target, $lang . "_" . $nameUpper . "_FIELDS",
						$view['settings']->name_list . ' Fields'
					);
					CFactory::_('Language')->set(
						CFactory::_('Config')->lang_target,
						$lang . "_" . $nameUpper . "_FIELDS_GROUPS",
						$view['settings']->name_list . ' Field Groups'
					);
					// build uninstall script for fields
					$this->uninstallScriptBuilder[$nameSingleCode] = 'com_'
						. $codeName . '.' . $nameSingleCode;
					$this->uninstallScriptFields[$nameSingleCode]
						= $nameSingleCode;
				}
			}
			if (isset($this->lastCustomSubMenu)
				&& ArrayHelper::check($this->lastCustomSubMenu))
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
		if (CFactory::_('Component')->isArray('custom_admin_views'))
		{
			foreach (CFactory::_('Component')->get('custom_admin_views') as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]))
				{
					if (($_custom = $this->setCustomAdminSubMenu(
							$view, $codeName, $lang, $nr, $menu, 'customView'
						)) !== false)
					{
						$custom .= $_custom;
					}
				}
			}
		}
		if (CFactory::_('Component')->isArray('custommenus'))
		{
			foreach (CFactory::_('Component')->get('custommenus') as $nr => $menu)
			{
				if (($_custom = $this->setCustomAdminSubMenu(
						$view, $codeName, $lang, $nr, $menu, 'customMenu'
					)) !== false)
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
			$name       = $menu['name'];
			$nameSingle = StringHelper::safe($menu['name']);
			$nameList   = StringHelper::safe($menu['name']);
			$nameUpper  = StringHelper::safe(
				$menu['name'], 'U'
			);
		}
		elseif ($type === 'customView')
		{
			$name       = $menu['settings']->name;
			$nameSingle = $menu['settings']->code;
			$nameList   = $menu['settings']->code;
			$nameUpper  = $menu['settings']->CODE;
		}
		if (isset($menu['submenu']) && $menu['submenu'] == 1
			&& $view['adminview'] == $menu['before'])
		{
			// setup access defaults
			$tab = "";
			$custom = '';
			// check if the item has permissions.
			if (CFactory::_('Compiler.Creator.Permission')->globalExist($nameSingle, 'core.access'))
			{
				$custom .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Access control (" . CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingle, 'core.access') . " && "
					. $nameSingle . ".submenu).";
				$custom .= PHP_EOL . Indent::_(2) . "if (\$user->authorise('"
					. CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingle, 'core.access') . "', 'com_" . $codeName
					. "') && \$user->authorise('" . $nameSingle
					. ".submenu', 'com_" . $codeName . "'))";
				$custom .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			else
			{
				$custom .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Access control (" . $nameSingle . ".submenu).";
				$custom .= PHP_EOL . Indent::_(2) . "if (\$user->authorise('"
					. $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$custom .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			if (isset($menu['link'])
				&& StringHelper::check(
					$menu['link']
				))
			{

				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$custom .= PHP_EOL . Indent::_(2) . $tab
					. "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang . "_"
					. $nameUpper . "'), '" . $menu['link']
					. "', \$submenu === '" . $nameList . "');";
			}
			else
			{
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$custom .= PHP_EOL . Indent::_(2) . $tab
					. "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang . "_"
					. $nameUpper . "'), 'index.php?option=com_" . $codeName
					. "&view=" . $nameList . "', \$submenu === '" . $nameList
					. "');";
			}
			// check if the item has permissions.
			$custom .= PHP_EOL . Indent::_(2) . "}";

			return $custom;
		}
		elseif (isset($menu['submenu']) && $menu['submenu'] == 1
			&& empty($menu['before']))
		{
			// setup access defaults
			$tab        = "";
			$nameSingle = StringHelper::safe($name);
			$this->lastCustomSubMenu[$nr] = '';
			// check if the item has permissions.
			if (CFactory::_('Compiler.Creator.Permission')->globalExist($nameSingle, 'core.access'))
			{
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . Indent::_(2)
					. "if (\$user->authorise('" . CFactory::_('Compiler.Creator.Permission')->getGlobal($nameSingle, 'core.access')
					. "', 'com_" . $codeName . "') && \$user->authorise('"
					. $nameSingle . ".submenu', 'com_" . $codeName . "'))";
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			else
			{
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . Indent::_(2)
					. "if (\$user->authorise('" . $nameSingle
					. ".submenu', 'com_" . $codeName . "'))";
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . Indent::_(2) . "{";
				// add tab to lines to follow
				$tab = Indent::_(1);
			}
			if (isset($menu['link'])
				&& StringHelper::check(
					$menu['link']
				))
			{
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . Indent::_(2) . $tab
					. "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang . "_"
					. $nameUpper . "'), '" . $menu['link']
					. "', \$submenu === '" . $nameList . "');";
			}
			else
			{
				CFactory::_('Language')->set(
					CFactory::_('Config')->lang_target, $lang . '_' . $nameUpper, $name
				);
				// add custom menu
				$this->lastCustomSubMenu[$nr] .= PHP_EOL . Indent::_(2) . $tab
					. "\JHtmlSidebar::addEntry(Text:" . ":_('" . $lang . "_"
					. $nameUpper . "'), 'index.php?option=com_" . $codeName
					. "&view=" . $nameList . "', \$submenu === '" . $nameList
					. "');";
			}
			// check if the item has permissions.
			$this->lastCustomSubMenu[$nr] .= PHP_EOL . Indent::_(2) . "}";
		}

		return false;
	}

	public function setMainMenus()
	{
		if (CFactory::_('Component')->isArray('admin_views'))
		{
			$menus = '';
			// main lang prefix
			$lang = CFactory::_('Config')->lang_prefix . '_MENU';
			// set the code name
			$codeName = CFactory::_('Config')->component_code_name;
			// default prefix is none
			$prefix = '';
			// check if local is set
			if (CFactory::_('Component')->isNumeric('add_menu_prefix'))
			{
				// set main menu prefix switch
				$addPrefix = CFactory::_('Component')->get('add_menu_prefix');
				if ($addPrefix == 1 && CFactory::_('Component')->isString('menu_prefix'))
				{
					$prefix = trim((string) CFactory::_('Component')->get('menu_prefix')) . ' ';
				}
			}
			else
			{
				// set main menu prefix switch
				$addPrefix = $this->params->get('add_menu_prefix', 1);
				if ($addPrefix == 1)
				{
					$prefix = trim((string) $this->params->get('menu_prefix', '&#187;'))
						. ' ';
				}
			}
			// add the prefix
			if ($addPrefix == 1)
			{
				CFactory::_('Language')->set(
					'adminsys', $lang, $prefix . CFactory::_('Component')->get('name')
				);
			}
			else
			{
				CFactory::_('Language')->set(
					'adminsys', $lang, CFactory::_('Component')->get('name')
				);
			}

			if (CFactory::_('Config')->get('joomla_version', 3) != 3
				&& CFactory::_('Registry')->get('build.dashboard', null) === null)
			{
				$menus .= PHP_EOL . Indent::_(3) . '<menu option="com_'
					. $codeName . '" view="' . $codeName . '">' . $lang
					. '_DASHBOARD</menu>';

				CFactory::_('Language')->set(
					'adminsys', $lang . '_DASHBOARD',
					'Dashboard'
				);
			}

			// loop over the admin views
			foreach (CFactory::_('Component')->get('admin_views') as $view)
			{
				// set custom menu
				$menus .= $this->addCustomMainMenu($view, $codeName, $lang);
				if (isset($view['mainmenu']) && $view['mainmenu'] == 1)
				{
					$nameList  = StringHelper::safe(
						$view['settings']->name_list
					);
					$nameUpper = StringHelper::safe(
						$view['settings']->name_list, 'U'
					);
					$menus     .= PHP_EOL . Indent::_(3) . '<menu option="com_'
						. $codeName . '" view="' . $nameList . '">' . $lang
						. '_' . $nameUpper . '</menu>';
					CFactory::_('Language')->set(
						'adminsys', $lang . '_' . $nameUpper,
						$view['settings']->name_list
					);
				}
			}
			if (isset($this->lastCustomMainMenu)
				&& ArrayHelper::check(
					$this->lastCustomMainMenu
				))
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
		if (CFactory::_('Component')->isArray('custom_admin_views'))
		{
			foreach (CFactory::_('Component')->get('custom_admin_views') as $nr => $menu)
			{
				if (!isset($this->customAdminAdded[$menu['settings']->code]))
				{
					if (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
						&& $view['adminview'] == $menu['before'])
					{
						CFactory::_('Language')->set(
							'adminsys', $lang . '_' . $menu['settings']->CODE,
							$menu['settings']->name
						);
						// add custom menu
						$customMenu .= PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $menu['settings']->code . '">' . $lang . '_'
							. $menu['settings']->CODE . '</menu>';
					}
					elseif (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
						&& empty($menu['before']))
					{
						CFactory::_('Language')->set(
							'adminsys', $lang . '_' . $menu['settings']->CODE,
							$menu['settings']->name
						);
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $menu['settings']->code . '">' . $lang . '_'
							. $menu['settings']->CODE . '</menu>';
					}
				}
			}
		}
		// see if we should have custom menus
		if (CFactory::_('Component')->isArray('custommenus'))
		{
			foreach (CFactory::_('Component')->get('custommenus') as $nr => $menu)
			{
				$nr = $nr + 100;
				if (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
					&& $view['adminview'] == $menu['before'])
				{
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						$nameList  = StringHelper::safe(
							$menu['name']
						);
						$nameUpper = StringHelper::safe(
							$menu['name'], 'U'
						);
						CFactory::_('Language')->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// sanitize url
						if (strpos((string) $menu['link'], 'http') === false)
						{
							$menu['link'] = str_replace(
								'/administrator/index.php?', '', (string) $menu['link']
							);
							$menu['link'] = str_replace(
								'administrator/index.php?', '', $menu['link']
							);
							// check if the index is still there
							if (strpos($menu['link'], 'index.php?') !== false)
							{
								$menu['link'] = str_replace(
									'/index.php?', '', $menu['link']
								);
								$menu['link'] = str_replace(
									'index.php?', '', $menu['link']
								);
							}
						}
						// urlencode
						$menu['link'] = htmlspecialchars(
							(string) $menu['link'], ENT_XML1, 'UTF-8'
						);
						// add custom menu
						$customMenu .= PHP_EOL . Indent::_(3) . '<menu link="'
							. $menu['link'] . '">' . $lang . '_' . $nameUpper
							. '</menu>';
					}
					else
					{
						$nameList  = StringHelper::safe(
							$menu['name_code']
						);
						$nameUpper = StringHelper::safe(
							$menu['name_code'], 'U'
						);
						CFactory::_('Language')->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// add custom menu
						$customMenu .= PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $nameList . '">' . $lang . '_' . $nameUpper
							. '</menu>';
					}
				}
				elseif (isset($menu['mainmenu']) && $menu['mainmenu'] == 1
					&& empty($menu['before']))
				{
					if (isset($menu['link'])
						&& StringHelper::check($menu['link']))
					{
						$nameList  = StringHelper::safe(
							$menu['name']
						);
						$nameUpper = StringHelper::safe(
							$menu['name'], 'U'
						);
						CFactory::_('Language')->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// sanitize url
						if (strpos((string) $menu['link'], 'http') === false)
						{
							$menu['link'] = str_replace(
								'/administrator/index.php?', '', (string) $menu['link']
							);
							$menu['link'] = str_replace(
								'administrator/index.php?', '', $menu['link']
							);
							// check if the index is still there
							if (strpos($menu['link'], 'index.php?') !== false)
							{
								$menu['link'] = str_replace(
									'/index.php?', '', $menu['link']
								);
								$menu['link'] = str_replace(
									'index.php?', '', $menu['link']
								);
							}
						}
						// urlencode
						$menu['link'] = htmlspecialchars(
							(string) $menu['link'], ENT_XML1, 'UTF-8'
						);
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL . Indent::_(3)
							. '<menu link="' . $menu['link'] . '">' . $lang
							. '_' . $nameUpper . '</menu>';
					}
					else
					{
						$nameList  = StringHelper::safe(
							$menu['name_code']
						);
						$nameUpper = StringHelper::safe(
							$menu['name_code'], 'U'
						);
						CFactory::_('Language')->set(
							'adminsys', $lang . '_' . $nameUpper, $menu['name']
						);
						// add custom menu
						$this->lastCustomMainMenu[$nr] = PHP_EOL . Indent::_(3)
							. '<menu option="com_' . $codeName . '" view="'
							. $nameList . '">' . $lang . '_' . $nameUpper
							. '</menu>';
					}
				}
			}
		}

		return $customMenu;
	}

	/**
	 * Set Config Fieldsets
	 *
	 * @param int $timer
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets')->set($timer);
	 */
	public function setConfigFieldsets(int $timer = 0): void
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets')->set($timer);
	}

	/**
	 * Set Site Control Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Site.Control')->set($lang);
	 */
	public function setSiteControlConfigFieldsets(string $lang): void
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Site.Control')->set($lang);
	}

	/**
	 * Set the request values
	 *
	 * @param string $view
	 * @param string $field
	 * @param string $search
	 * @param string $target
	 *
	 * @since 1.0
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Request')->set($view, $field, $search, $target);
	 */
	protected function setRequestValues(string $view, string $field, string $search, string $target): void
	{
		CFactory::_('Compiler.Creator.Request')->set($view, $field, $search, $target);
	}

	/**
	 * Set Custom Control Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Customfield')->set($lang);
	 */
	public function setCustomControlConfigFieldsets(string $lang): void
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Customfield')->set($lang);
	}

	/**
	 * Set Group Control Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Group.Control')->set($lang);
	 */
	public function setGroupControlConfigFieldsets(string $lang): void
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Group.Control')->set($lang);
	}

	/**
	 * Set Global Config Fieldsets
	 *
	 * @param string $lang
	 * @param string $authorName
	 * @param string $authorEmail
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Global')->set($lang, $authorName, $authorEmail);
	 */
	public function setGlobalConfigFieldsets(string $lang, string $authorName, string $authorEmail): void
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Global')->set($lang, $authorName, $authorEmail);
	}

	/**
	 * Set Uikit Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Uikit')->set($lang);
	 */
	public function setUikitConfigFieldsets($lang)
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Uikit')->set($lang);
	}

	/**
	 * Set Email Helper Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Email.Helper')->set($lang);
	 */
	public function setEmailHelperConfigFieldsets($lang)
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Email.Helper')->set($lang);
	}

	/**
	 * Set Googlechart Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Googlechart')->set($lang);
	 */
	public function setGooglechartConfigFieldsets($lang)
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Googlechart')->set($lang);
	}

	/**
	 * Set Encryption Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Config.Fieldsets.Encryption')->set($lang);
	 */
	public function setEncryptionConfigFieldsets($lang)
	{
		CFactory::_('Compiler.Creator.Config.Fieldsets.Encryption')->set($lang);
	}

	/**
	 * Set Access Sections Category
	 *
	 * @param string $nameSingleCode
	 * @param string $nameListCode
	 *
	 * @return  string
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Access.Sections.Category')->get($nameSingleCode, $nameListCode);
	 */
	public function setAccessSectionsCategory(string $nameSingleCode, string $nameListCode): string
	{
		return CFactory::_('Compiler.Creator.Access.Sections.Category')->get($nameSingleCode, $nameListCode);
	}

	/**
	 * Set Access Sections Joomla Fields
	 *
	 * @return  string
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Access.Sections.Joomla.Fields')->get();
	 */
	public function setAccessSectionsJoomlaFields(): string
	{
		return CFactory::_('Compiler.Creator.Access.Sections.Joomla.Fields')->get();
	}

	/**
	 * Set Access Sections
	 *
	 * @return  string
	 * @since 1.0
	 * @deprecated 3.3 CFactory::_('Compiler.Creator.Access.Sections')->get();
	 */
	public function setAccessSections()
	{
		return CFactory::_('Compiler.Creator.Access.Sections')->get();
	}

	/**
	 * Add Custom Button Permissions
	 *
	 * @param object    $settings    The view settings
	 * @param string    $nameView    The view name
	 * @param string    $code        The view code name.
	 *
	 * @since 1.0
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Custom.Button.Permissions')->add($settings, $nameView, $code);
	 */
	protected function addCustomButtonPermissions($settings, $nameView, $code)
	{
		CFactory::_('Compiler.Creator.Custom.Button.Permissions')->add($settings, $nameView, $code);
	}

	/**
	 * Set the permissions
	 *
	 * @param   array   $view             View details
	 * @param   string  $nameView         View Single Code Name
	 * @param   string  $nameViews        View List Code Name
	 * @param   array   $menuControllers  Menu Controllers
	 * @param   string  $type             Type of permissions area
	 *
	 * @return  void
	 * @deprecated 3.3 Use CFactory::_('Compiler.Creator.Permission')->set($view, $nameView, $nameViews, $menuControllers, $type);
	 */
	public function buildPermissions(&$view, $nameView, $nameViews, $menuControllers, $type = 'admin')
	{
		CFactory::_('Compiler.Creator.Permission')->set($view, $nameView, $nameViews, $menuControllers, $type);
	}

	public function getInbetweenStrings($str, $start = '#' . '#' . '#', $end = '#' . '#' . '#')
	{
		$matches = [];
		$regex   = "/$start([a-zA-Z0-9_]*)$end/";
		preg_match_all($regex, (string) $str, $matches);

		return $matches[1];
	}

	public function getModCode(&$module)
	{
		// get component helper string
		$Helper    = CFactory::_('Compiler.Builder.Content.One')->get('Component') . 'Helper';
		$component = CFactory::_('Compiler.Builder.Content.One')->get('component');
		$_helper   = '';
		// get libraries code
		$libraries = array(Placefix::_('MOD_LIBRARIES') => $this->getModLibCode($module));
		$code      = CFactory::_('Placeholder')->update($module->mod_code, $libraries);
		// check if component helper class should be added
		if (strpos((string) $code, $Helper . '::') !== false
			&& strpos(
				(string) $code,
				"/components/com_" . $component . "/helpers/" . $component
				. ".php"
			) === false)
		{
			$_helper = '//' . Line::_(__Line__, __Class__)
				. ' Include the component helper functions only once';
			$_helper .= PHP_EOL . "JLoader::register('" . $Helper
				. "', JPATH_ADMINISTRATOR . '/components/com_" . $component
				. "/helpers/" . $component . ".php');";
		}

		return CFactory::_('Placeholder')->update($_helper . PHP_EOL . $code . PHP_EOL, CFactory::_('Compiler.Builder.Content.One')->allActive());
	}

	public function getModDefault(&$module, &$key)
	{
		// first add the header
		$default = PHP_EOL . $module->default_header . PHP_EOL . '?>';
		// add any css from the fields
		$default .= CFactory::_('Customcode.Dispenser')->get(
			'css_views', $key, PHP_EOL . '<style>', '', true, null,
			PHP_EOL . '</style>' . PHP_EOL
		);
		// now add the body
		$default .= PHP_EOL . $module->default . PHP_EOL;
		// add any JavaScript from the fields
		$default .= CFactory::_('Customcode.Dispenser')->get(
			'views_footer', $key,
			PHP_EOL . '<script type="text/javascript">', '', true,
			null, PHP_EOL . '</script>' . PHP_EOL
		);

		// return the default content for the model default area
		return CFactory::_('Placeholder')->update($default, CFactory::_('Compiler.Builder.Content.One')->allActive());
	}

	public function setModTemplates(&$module)
	{
		if (($data_ = CFactory::_('Compiler.Builder.Template.Data')->
			get(CFactory::_('Config')->build_target . '.' . $module->code_name)) !== null)
		{
			foreach ($data_ as $template => $data)
			{
				$header = $data['php_view'] ?? '';
				$body = $data['html'] ?? '';
				$default = PHP_EOL . $header . PHP_EOL . '?>';
				$default .= PHP_EOL . $body;
				$TARGET = StringHelper::safe("MODDEFAULT_{$template}", 'U');
				CFactory::_('Compiler.Builder.Content.Multi')->set($module->key . '|' . $TARGET,
					CFactory::_('Placeholder')->update(
						$default, CFactory::_('Compiler.Builder.Content.One')->allActive()
					)
				);
			}
		}
	}

	public function getModHelperCode(&$module)
	{
		return
			CFactory::_('Placeholder')->update($module->class_helper_header . PHP_EOL .
				$module->class_helper_type . $module->class_helper_name . PHP_EOL
				. '{' . PHP_EOL .
				$module->class_helper_code . PHP_EOL .
				"}" . PHP_EOL, CFactory::_('Compiler.Builder.Content.One')->allActive());
	}

	public function getModLibCode(&$module)
	{
		$setter = '';
		if (($data_ = CFactory::_('Compiler.Builder.Library.Manager')->
			get($module->key . '.' . $module->code_name)) !== null)
		{
			$setter .= '//' . Line::_(__Line__, __Class__)
				. 'get the document object';
			$setter .= PHP_EOL . '$document = Factory::getDocument();';
			foreach ($data_ as $id => $true)
			{
				// get the library
				$library = CFactory::_('Registry')->get("builder.libraries.$id", null);
				if (is_object($library)
					&& isset($library->document)
					&& StringHelper::check(
						$library->document
					))
				{
					$setter .= PHP_EOL . $library->document;
				}
				elseif (is_object($library)
					&& isset($library->how))
				{
					$setter .= $this->setLibraryDocument($id);
				}
			}
		}
		// check if we have string
		if (StringHelper::check($setter))
		{
			return CFactory::_('Placeholder')->update( CFactory::_('Placeholder')->update_(
				str_replace(
					'$this->document->', '$document->',
					implode(
						PHP_EOL,
						array_map(
							'trim',
							(array) explode(PHP_EOL, $setter)
						)
					)
				)
			), CFactory::_('Compiler.Builder.Content.One')->allActive());
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
		$config_fields = [];
		if (isset($module->config_fields)
			&& ArrayHelper::check(
				$module->config_fields
			))
		{
			$add_scripts_field = true;
			foreach ($module->config_fields as $field_name => $fieldsets)
			{
				foreach ($fieldsets as $fieldset => $fields)
				{
					// get the field set
					$xmlFields = CFactory::_('Compiler.Creator.Fieldset.Extension')->get(
						$module, $fields, $dbkey
					);
					// check if the custom script field must be set
					if ($add_scripts_field && $module->add_scripts_field)
					{
						// get the custom script field
						$xmlFields .= PHP_EOL . Indent::_(2)
							. "<field type=\"modadminvvvvvvvdm\" />";
						// don't add it again
						$add_scripts_field = false;
					}
					// make sure the xml is set and a string
					if (isset($xmlFields)
						&& StringHelper::check($xmlFields))
					{
						$config_fields[$field_name . $fieldset] = $xmlFields;
					}
					$dbkey++;
					// check if the fieldset path requiers component paths
					if (!$add_component_path
						&& isset(
							$module->fieldsets_paths[$field_name . $fieldset]
						)
						&& $module->fieldsets_paths[$field_name . $fieldset]
						== 1)
					{
						$add_component_path = true;
					}
				}
			}
		}
		// switch to add the language xml
		$addLang = [];
		// now build the language files
		if (CFactory::_('Language')->exist($module->key))
		{
			// get model lang content
			$langContent = CFactory::_('Language')->getTarget($module->key);
			// Trigger Event: jcb_ce_onBeforeBuildModuleLang
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeBuildModuleLang', [&$module, &$langContent]
			);
			// get other languages
			$values = array_unique($langContent);
			// get the other lang strings if there is any
			CFactory::_('Compiler.Builder.Multilingual')->set('modules',
				CFactory::_('Language.Multilingual')->get($values)
			);
			// start the modules language bucket (must rest every time)
			$langTag = CFactory::_('Config')->get('lang_tag', 'en-GB');
			CFactory::_('Compiler.Builder.Languages')->set(
				"modules.{$langTag}.all",
				$langContent
			);
			CFactory::_('Language')->setTarget($module->key, null);
			// update insert the current lang in to DB
			CFactory::_('Language.Set')->execute($values, $module->id, 'modules');
			// remove old unused language strings
			CFactory::_('Language.Purge')->execute($values, $module->id, 'modules');
			$total = count($values);
			unset($values);

			// Trigger Event: jcb_ce_onBeforeBuildModuleLangFiles
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeBuildModuleLangFiles', [&$module]
			);

			// now we insert the values into the files
			if (CFactory::_('Compiler.Builder.Languages')->IsArray('modules'))
			{
				foreach (CFactory::_('Compiler.Builder.Languages')->get('modules') as $tag => $areas)
				{
					// trim the tag
					$tag = trim($tag);
					foreach ($areas as $area => $languageStrings)
					{
						$file_name = $tag . '.' . $module->file_name . '.ini';
						// check if language should be added
						if (CFactory::_('Language.Translation')->check(
							$tag, $languageStrings, $total,
							$file_name
						))
						{
							$lang = array_map(
								fn($langstring, $placeholder) => $placeholder . '="' . $langstring  . '"',
								array_values($languageStrings),
								array_keys($languageStrings)
							);
							// set path
							$path = $module->folder_path . '/language/' . $tag . '/';
							// create path if not exist
							if (!Folder::exists($path))
							{
								Folder::create($path);
								// count the folder created
								CFactory::_('Utilities.Counter')->folder++;
							}
							// add to language files (for now we add all to both TODO)
							CFactory::_('Utilities.File')->write(
								$path . $file_name,
								implode(PHP_EOL, $lang)
							);
							CFactory::_('Utilities.File')->write(
								$path . $tag . '.' . $module->file_name
								. '.sys.ini',
								implode(PHP_EOL, $lang)
							);
							// set the line counter
							CFactory::_('Utilities.Counter')->line += count(
									(array) $lang
								);
							unset($lang);
							// trigger to add language
							$addLang[$tag] = $tag;
						}
					}
				}
			}
		}
		// get all files and folders in module folder
		$files   = Folder::files($module->folder_path);
		$folders = Folder::folders($module->folder_path);
		// the files/folders to ignore
		$ignore = array('sql', 'language', 'script.php',
			$module->file_name . '.xml',
			$module->file_name . '.php');
		// should the scriptfile be added
		if ($module->add_install_script)
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Scripts to run on installation -->';
			$xml .= PHP_EOL . Indent::_(1)
				. '<scriptfile>script.php</scriptfile>';
		}
		// should the sql install be added
		if ($module->add_sql)
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Runs on install; New in Joomla 1.5 -->';
			$xml .= PHP_EOL . Indent::_(1) . '<install>';
			$xml .= PHP_EOL . Indent::_(2) . '<sql>';
			$xml .= PHP_EOL . Indent::_(3)
				. '<file driver="mysql" charset="utf8">sql/mysql/install.sql</file>';
			$xml .= PHP_EOL . Indent::_(2) . '</sql>';
			$xml .= PHP_EOL . Indent::_(1) . '</install>';
		}
		// should the sql uninstall be added
		if ($module->add_sql_uninstall)
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Runs on uninstall; New in Joomla 1.5 -->';
			$xml .= PHP_EOL . Indent::_(1) . '<uninstall>';
			$xml .= PHP_EOL . Indent::_(2) . '<sql>';
			$xml .= PHP_EOL . Indent::_(3)
				. '<file driver="mysql" charset="utf8">sql/mysql/uninstall.sql</file>';
			$xml .= PHP_EOL . Indent::_(2) . '</sql>';
			$xml .= PHP_EOL . Indent::_(1) . '</uninstall>';
		}
		// should the language xml be added
		if (ArrayHelper::check($addLang))
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Language files -->';
			$xml .= PHP_EOL . Indent::_(1)
				. '<languages folder="language">';
			// load all the language files to xml
			foreach ($addLang as $addTag)
			{
				$xml .= PHP_EOL . Indent::_(2) . '<language tag="'
					. $addTag . '">' . $addTag . '/' . $addTag . '.'
					. $module->file_name . '.ini</language>';
				$xml .= PHP_EOL . Indent::_(2) . '<language tag="'
					. $addTag . '">' . $addTag . '/' . $addTag . '.'
					. $module->file_name . '.sys.ini</language>';
			}
			$xml .= PHP_EOL . Indent::_(1) . '</languages>';
		}
		// add the module files
		$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
				__LINE__,__CLASS__
			) . ' Model files -->';
		$xml .= PHP_EOL . Indent::_(1) . '<files>';
		$xml .= PHP_EOL . Indent::_(2) . '<filename module="'
			. $module->file_name . '">' . $module->file_name
			. '.php</filename>';
		// add other files found
		if (ArrayHelper::check($files))
		{
			foreach ($files as $file)
			{
				// only add what is not ignored
				if (!in_array($file, $ignore))
				{
					$xml .= PHP_EOL . Indent::_(2) . '<filename>' . $file
						. '</filename>';
				}
			}
		}
		// add language folder
		if (ArrayHelper::check($addLang))
		{
			$xml .= PHP_EOL . Indent::_(2) . '<folder>language</folder>';
		}
		// add sql folder
		if ($module->add_sql || $module->add_sql_uninstall)
		{
			$xml .= PHP_EOL . Indent::_(2) . '<folder>sql</folder>';
		}
		// add other files found
		if (ArrayHelper::check($folders))
		{
			foreach ($folders as $folder)
			{
				// only add what is not ignored
				if (!in_array($folder, $ignore))
				{
					$xml .= PHP_EOL . Indent::_(2) . '<folder>' . $folder
						. '</folder>';
				}
			}
		}
		$xml .= PHP_EOL . Indent::_(1) . '</files>';
		// now add the Config Params if needed
		if (ArrayHelper::check($config_fields))
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Config parameter -->';
			// only add if part of the component field types path is required
			if ($add_component_path)
			{
				// add path to module rules and custom fields
				$xml .= PHP_EOL . Indent::_(1) . '<config';
				if (CFactory::_('Config')->get('joomla_version', 3) == 3)
				{
					$xml .= PHP_EOL . Indent::_(2)
						. 'addrulepath="/administrator/components/com_'
						. CFactory::_('Config')->component_code_name . '/models/rules"';
					$xml .= PHP_EOL . Indent::_(2)
						. 'addfieldpath="/administrator/components/com_'
						. CFactory::_('Config')->component_code_name . '/models/fields"';
				}
				else
				{
					$xml .= PHP_EOL . Indent::_(3)
						. 'addruleprefix="' . CFactory::_('Config')->namespace_prefix
						. '\Component\\' . CFactory::_('Compiler.Builder.Content.One')->get('ComponentNamespace')
						. '\Administrator\Rule"';
					$xml .= PHP_EOL . Indent::_(3)
						. 'addfieldprefix="' . CFactory::_('Config')->namespace_prefix
						. '\Component\\' . CFactory::_('Compiler.Builder.Content.One')->get('ComponentNamespace')
						. '\Administrator\Field">';
				}
				$xml .= PHP_EOL . Indent::_(1) . '>';
			}
			else
			{
				$xml .= PHP_EOL . Indent::_(1) . '<config>';
			}
			// add the fields
			foreach ($module->config_fields as $field_name => $fieldsets)
			{
				$xml .= PHP_EOL . Indent::_(1) . '<fields name="' . $field_name
					. '">';
				foreach ($fieldsets as $fieldset => $fields)
				{
					// default to the field set name
					$label = $fieldset;
					if (isset($module->fieldsets_label[$field_name . $fieldset]))
					{
						$label = $module->fieldsets_label[$field_name . $fieldset];
					}
					// add path to module rules and custom fields
					if (isset($module->fieldsets_paths[$field_name . $fieldset])
						&& ($module->fieldsets_paths[$field_name . $fieldset] == 2
							|| $module->fieldsets_paths[$field_name . $fieldset] == 3))
					{
						if ($module->target == 2)
						{
							if (!isset($module->add_rule_path[$field_name . $fieldset]))
							{
								$module->add_rule_path[$field_name . $fieldset] =
									'/administrator/modules/'
									. $module->file_name . '/rules';
							}

							if (!isset($module->add_field_path[$field_name . $fieldset]))
							{
								$module->add_field_path[$field_name . $fieldset] =
									'/administrator/modules/'
									. $module->file_name . '/fields';
							}
						}
						else
						{
							if (!isset($module->add_rule_path[$field_name . $fieldset]))
							{
								$module->add_rule_path[$field_name . $fieldset] =
									'/modules/' . $module->file_name
									. '/rules';
							}

							if (!isset($module->add_field_path[$field_name . $fieldset]))
							{
								$module->add_field_path[$field_name . $fieldset] =
									'/modules/' . $module->file_name
									. '/fields';
							}
						}
					}
					// add path to module rules and custom fields
					if (isset($module->add_rule_path[$field_name . $fieldset])
						|| isset($module->add_field_path[$field_name . $fieldset]))
					{

						$xml .= PHP_EOL . Indent::_(1) . '<!--'
							. Line::_(__Line__, __Class__) . ' default paths of '
							. $fieldset . ' fieldset points to the module -->';

						$xml .= PHP_EOL . Indent::_(1) . '<fieldset name="'
							. $fieldset . '" label="' . $label . '"';

						if (isset($module->add_rule_path[$field_name . $fieldset]))
						{
							$xml .= PHP_EOL . Indent::_(2)
								. 'addrulepath="' . $module->add_rule_path[$field_name . $fieldset] . '"';
						}

						if (isset($module->add_field_path[$field_name . $fieldset]))
						{
							$xml .= PHP_EOL . Indent::_(2)
								. 'addfieldpath="' . $module->add_field_path[$field_name . $fieldset] . '"';
						}

						$xml .= PHP_EOL . Indent::_(1) . '>';
					}
					else
					{
						$xml .= PHP_EOL . Indent::_(1) . '<fieldset name="'
							. $fieldset . '" label="' . $label . '">';
					}
					// load the fields
					if (isset($config_fields[$field_name . $fieldset]))
					{
						$xml .= $config_fields[$field_name . $fieldset];
						unset($config_fields[$field_name . $fieldset]);
					}
					$xml .= PHP_EOL . Indent::_(1) . '</fieldset>';
				}
				$xml .= PHP_EOL . Indent::_(1) . '</fields>';
			}
			$xml .= PHP_EOL . Indent::_(1) . '</config>';
		}
		// set update server if found
		if ($module->add_update_server)
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Update servers -->';
			$xml .= PHP_EOL . Indent::_(1) . '<updateservers>';
			$xml .= PHP_EOL . Indent::_(2)
				. '<server type="extension" priority="1" name="'
				. $module->official_name . '">' . $module->update_server_url
				. '</server>';
			$xml .= PHP_EOL . Indent::_(1) . '</updateservers>';
		}

		return $xml;
	}

	/**
	 * get Plugin Main Class
	 *
	 * @param   object  $plugin  The plugin object
	 *
	 * @return  string The fields set in xml
	 * @deprecated 3.4 CFactory::_('Architecture.Plugin.Extension')->get(...);
	 */
	public function getPluginMainClass(&$plugin)
	{
		return CFactory::_('Architecture.Plugin.Extension')->get($plugin);
	}

	/**
	 * get Plugin Main XML
	 *
	 * @param   object  $plugin  The plugin object
	 *
	 * @return  string The xml
	 * @deprecated 3.4 CFactory::_('Architecture.Plugin.MainXML')->get(...);
	 */
	public function getPluginMainXML(&$plugin)
	{
		return CFactory::_('Architecture.Plugin.MainXML')->get($plugin);
	}

	/**
	 * get power code
	 *
	 * @param   object  $power
	 *
	 * @return  string
	 * @deprecated 3.4 (line 393 private Compiler.Power.Infusion->code())
	 */
	public function getPowerCode(&$power)
	{
		$code = [];
		// set the name space
		$code[] = 'namespace ' . $power->_namespace . ';' . PHP_EOL;
		// check if we have header data
		if (StringHelper::check($power->head))
		{
			$code[] = PHP_EOL . $power->head;
		}
		// add description if set
		if (StringHelper::check($power->description))
		{
			// check if this is escaped
			if (strpos((string) $power->description, '/*') === false)
			{
				// make this description escaped
				$power->description = '/**' . PHP_EOL . ' * ' . implode(PHP_EOL . ' * ', explode(PHP_EOL, (string) $power->description)) . PHP_EOL . ' */';
			}
			$code[] = PHP_EOL . $power->description;
		}
		// build power declaration
		$declaration = $power->type . ' ' . $power->class_name;
		// check if we have extends
		if (StringHelper::check($power->extends_name))
		{
			$declaration .= ' extends ' . $power->extends_name;
		}
		// check if we have implements
		if (ArrayHelper::check($power->implement_names))
		{
			$declaration .= ' implements ' . implode(', ', $power->implement_names);
		}
		$code[] = $declaration;
		$code[] = '{';
		// add the main code if set
		if (StringHelper::check($power->main_class_code))
		{
			$code[] = $power->main_class_code;
		}
		$code[] = '}' . PHP_EOL . PHP_EOL;

		return CFactory::_('Placeholder')->update(implode(PHP_EOL, $code), CFactory::_('Compiler.Builder.Content.One')->allActive());
	}

	/**
	 * build field set for an extention
	 *
	 * @param   object  $extension  The extention object
	 * @param   array   $fields     The fields to build
	 * @param   string  $dbkey      The database key
	 *
	 * @return  string The fields set in xml
	 * @deprecated 3.4 CFactory::_('Compiler.Creator.Access.Sections.Joomla.Fields')->get(...);
	 */
	public function getExtensionFieldsetXML(&$extension, &$fields, $dbkey = 'zz'): string
	{
		// build the fieldset
		return CFactory::_('Compiler.Creator.Fieldset.Extension')->get($extension, $fields, $dbkey);
	}

	/**
	 * check if a translation should be added
	 *
	 * @return  bool
	 * @deprecated 3.4 Use CFactory::_('Language.Translation')->check(...);
	 */
	public function shouldLanguageBeAdded(&$tag, &$languageStrings, &$total, &$file_name)
	{
		return CFactory::_('Language.Translation')->check($tag, $languageStrings, $total, $file_name);
	}
}

