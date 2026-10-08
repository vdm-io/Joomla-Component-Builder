<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    15th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;
use VDM\Joomla\Utilities\StringHelper;


/**
 * License Lock Generation Class.
 * 
 * Generates the WHMCS license-lock fragments of a component: the helper
 * `isGenuine()` methods, the global lock initialization and `defined` guard,
 * and the per-view boolean lock methods with their check statements.
 * 
 * The generated fragments are stored in the shared ContentOne and
 * ContentMulti registries under the same placeholder keys the legacy
 * Interpretation helper used.
 * 
 * @since  6.1.7
 */
final class LicenseLock
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param Component      $component      The Component Class.
	 * @param ContentOne     $contentone     The ContentOne Class.
	 * @param ContentMulti   $contentmulti   The ContentMulti Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Component $component,
		ContentOne $contentone, ContentMulti $contentmulti)
	{
		$this->config = $config;
		$this->component = $component;
		$this->contentone = $contentone;
		$this->contentmulti = $contentmulti;
	}

	/**
	 * Set the global license-lock content.
	 *
	 * When the component uses the WHMCS license option, this stores the
	 * admin and site helper `isGenuine()` methods, the lock initialization
	 * statement, and the `defined` guard in ContentOne. Otherwise every
	 * license placeholder is cleared.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(): void
	{
		if ($this->component->get('add_license', 0) == 3)
		{
			if (!$this->contentone->exists('HELPER_SITE_LICENSE_LOCK'))
			{
				$whmcs = '_' . StringHelper::safe(
						Unique::get(10), 'U'
					);
				// add it to the system
				$this->contentone->set('HELPER_SITE_LICENSE_LOCK', $this->helperMethod());
				$this->contentone->set('HELPER_LICENSE_LOCK', $this->helperMethod());
				$this->contentone->set('LICENSE_LOCKED_INT', $this->initLock($whmcs));
				$this->contentone->set('LICENSE_LOCKED_DEFINED',
					PHP_EOL . PHP_EOL . 'defined(\'' . $whmcs
					. '\') or die(Joomla__' . '_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_(\'NIE_REG_NIE\'));');
			}
		}
		else
		{
			// don't add it to the system
			$this->contentone->set('HELPER_SITE_LICENSE_LOCK', '');
			$this->contentone->set('HELPER_LICENSE_LOCK', '');
			$this->contentone->set('LICENSE_LOCKED_INT', '');
			$this->contentone->set('LICENSE_LOCKED_DEFINED', '');
		}
	}

	/**
	 * Set the per-view license-lock content.
	 *
	 * When the component uses the WHMCS license option, this generates the
	 * view's boolean lock method and check statements once per view and
	 * stores them in ContentMulti. Otherwise the view placeholders are
	 * cleared, leaving any existing `BOOLMETHOD` value untouched.
	 *
	 * @param   string  $view  The single code name of the view.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function setView(string $view): void
	{
		if ($this->component->get('add_license', 0) == 3)
		{
			if (!$this->contentmulti->exists($view . '|BOOLMETHOD'))
			{
				$boolMethod = 'get' . StringHelper::safe(
						Unique::get(3), 'W'
					);
				$globalBool = 'set' . StringHelper::safe(
						Unique::get(3), 'W'
					);
				// add it to the system
				$this->contentmulti->set($view . '|LICENSE_LOCKED_SET_BOOL',
					$this->boolMethod($boolMethod, $globalBool));
				$this->contentmulti->set($view . '|LICENSE_LOCKED_CHECK',
					$this->checkStatement($boolMethod));
				$this->contentmulti->set($view . '|LICENSE_TABLE_LOCKED_CHECK',
					$this->checkStatement($boolMethod, '$table'));
				$this->contentmulti->set($view . '|BOOLMETHOD', $boolMethod);
			}
		}
		else
		{
			// don't add it to the system
			$this->contentmulti->set($view . '|LICENSE_LOCKED_SET_BOOL', '');
			$this->contentmulti->set($view . '|LICENSE_LOCKED_CHECK', '');
			$this->contentmulti->set($view . '|LICENSE_TABLE_LOCKED_CHECK', '');
		}
	}

	/**
	 * Get the license-locked check statement.
	 *
	 * @param   string  $boolMethod  The generated boolean method name.
	 * @param   string  $useThis     The object expression the check is called on.
	 *
	 * @return  string  The check statement code.
	 *
	 * @since   6.1.7
	 */
	public function checkStatement(string $boolMethod, string $useThis = '$this'): string
	{
		$statement = [];
		$statement[] = PHP_EOL . Indent::_(2) . "if (!" . $useThis . "->"
			. $boolMethod . "())";
		$statement[] = Indent::_(2) . "{";
		$statement[] = Indent::_(3) . "\$app = Joomla__" . "_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();";
		$statement[] = Indent::_(3) . "\$app->enqueueMessage(Text:"
			. ":_('NIE_REG_NIE'), 'error');";
		$statement[] = Indent::_(3) . "\$app->redirect('index.php');";
		$statement[] = Indent::_(3) . "return false;";
		$statement[] = Indent::_(2) . "}";

		// return the genuine mentod statement
		return implode(PHP_EOL, $statement);
	}

	/**
	 * Get the boolean license-lock method for a view.
	 *
	 * @param   string  $boolMethod  The generated boolean method name.
	 * @param   string  $globalBool  The generated private property name.
	 *
	 * @return  string  The boolean lock method code.
	 *
	 * @since   6.1.7
	 */
	public function boolMethod(string $boolMethod, string $globalBool): string
	{
		$bool = [];
		$bool[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$bool[] = Indent::_(1) . " * The private bool.";
		$bool[] = Indent::_(1) . " **/";
		$bool[] = Indent::_(1) . "private $" . $globalBool . ";";
		$bool[] = PHP_EOL . Indent::_(1) . "/**";
		$bool[] = Indent::_(1) . " * Check if this install has a license.";
		$bool[] = Indent::_(1) . " **/";
		$bool[] = Indent::_(1) . "public function " . $boolMethod . "()";
		$bool[] = Indent::_(1) . "{";
		$bool[] = Indent::_(2) . "if(!empty(\$this->" . $globalBool . "))";
		$bool[] = Indent::_(2) . "{";
		$bool[] = Indent::_(3) . "return \$this->" . $globalBool . ";";
		$bool[] = Indent::_(2) . "}";
		$bool[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the global params";
		$bool[] = Indent::_(2) . "\$params = ComponentHelper::getParams('com_"
			. $this->config->component_code_name . "', true);";
		$bool[] = Indent::_(2)
			. "\$whmcs_key = \$params->get('whmcs_key', null);";
		$bool[] = Indent::_(2) . "if (\$whmcs_key)";
		$bool[] = Indent::_(2) . "{";
		$bool[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " load the file";
		$bool[] = Indent::_(3)
			. "JLoader::import( 'whmcs', JPATH_ADMINISTRATOR .'/components/com_"
			. $this->config->component_code_name . "');";
		$bool[] = Indent::_(3) . "\$the = new \WHMCS(\$whmcs_key);";
		$bool[] = Indent::_(3) . "\$this->" . $globalBool . " = \$the->_is;";
		$bool[] = Indent::_(3) . "return \$this->" . $globalBool . ";";
		$bool[] = Indent::_(2) . "}";
		$bool[] = Indent::_(2) . "return false;";
		$bool[] = Indent::_(1) . "}";

		// return the genuine method statement
		return implode(PHP_EOL, $bool);
	}

	/**
	 * Get the helper `isGenuine()` license-lock method.
	 *
	 * @return  string  The helper lock method code.
	 *
	 * @since   6.1.7
	 */
	public function helperMethod(): string
	{
		$helper = [];
		$helper[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
		$helper[] = Indent::_(1) . " * Check if this install has a license.";
		$helper[] = Indent::_(1) . " **/";
		$helper[] = Indent::_(1) . "public static function isGenuine()";
		$helper[] = Indent::_(1) . "{";
		$helper[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the global params";
		$helper[] = Indent::_(2)
			. "\$params = ComponentHelper::getParams('com_"
			. $this->config->component_code_name . "', true);";
		$helper[] = Indent::_(2)
			. "\$whmcs_key = \$params->get('whmcs_key', null);";
		$helper[] = Indent::_(2) . "if (\$whmcs_key)";
		$helper[] = Indent::_(2) . "{";
		$helper[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " load the file";
		$helper[] = Indent::_(3)
			. "JLoader::import( 'whmcs', JPATH_ADMINISTRATOR .'/components/com_"
			. $this->config->component_code_name . "');";
		$helper[] = Indent::_(3) . "\$the = new \WHMCS(\$whmcs_key);";
		$helper[] = Indent::_(3) . "return \$the->_is;";
		$helper[] = Indent::_(2) . "}";
		$helper[] = Indent::_(2) . "return false;";
		$helper[] = Indent::_(1) . "}";

		// return the genuine mentod statement
		return implode(PHP_EOL, $helper);
	}

	/**
	 * Get the license-lock initialization statement.
	 *
	 * @param   string  $whmcs  The generated lock constant name.
	 *
	 * @return  string  The initializing statement code.
	 *
	 * @since   6.1.7
	 */
	public function initLock(string $whmcs): string
	{
		$init = [];
		$init[] = PHP_EOL . "if (!defined('" . $whmcs . "'))";
		$init[] = "{";
		$init[] = Indent::_(1) . "\$allow = "
			. $this->contentone->get('Component')
			. "Helper::isGenuine();";
		$init[] = Indent::_(1) . "if (\$allow)";
		$init[] = Indent::_(1) . "{";
		$init[] = Indent::_(2) . "define('" . $whmcs . "', 1);";
		$init[] = Indent::_(1) . "}";
		$init[] = "}";

		// return the initializing statement
		return implode(PHP_EOL, $init);
	}
}

