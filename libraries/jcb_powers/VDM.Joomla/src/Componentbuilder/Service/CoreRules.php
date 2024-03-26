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

namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\CMS\Version;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaThree\CoreRule as J3CoreRule;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFour\CoreRule as J4CoreRule;
use VDM\Joomla\Componentbuilder\Compiler\Field\JoomlaFive\CoreRule as J5CoreRule;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Field\CoreRuleInterface as CoreRule;


/**
 * Joomla Core Rules
 * 
 * @since 3.2.0
 */
class CoreRules implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version We are IN
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected $currentVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(J3CoreRule::class, 'J3.Field.Core.Rule')
			->share('J3.Field.Core.Rule', [$this, 'getJ3CoreRule'], true);

		$container->alias(J4CoreRule::class, 'J4.Field.Core.Rule')
			->share('J4.Field.Core.Rule', [$this, 'getJ4CoreRule'], true);

		$container->alias(J5CoreRule::class, 'J5.Field.Core.Rule')
			->share('J5.Field.Core.Rule', [$this, 'getJ5CoreRule'], true);

		$container->alias(CoreRule::class, 'Field.Core.Rule')
			->share('Field.Core.Rule', [$this, 'getCoreRule'], true);
	}

	/**
	 * Get The CoreRule Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3CoreRule
	 * @since 3.2.0
	 */
	public function getJ3CoreRule(Container $container): J3CoreRule
	{
		return new J3CoreRule();
	}

	/**
	 * Get The CoreRule Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4CoreRule
	 * @since 3.2.0
	 */
	public function getJ4CoreRule(Container $container): J4CoreRule
	{
		return new J4CoreRule();
	}

	/**
	 * Get The CoreRule Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5CoreRule
	 * @since 3.2.0
	 */
	public function getJ5CoreRule(Container $container): J5CoreRule
	{
		return new J5CoreRule();
	}

	/**
	 * Get The CoreRuleInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CoreRule
	 * @since 3.2.0
	 */
	public function getCoreRule(Container $container): CoreRule
	{
		if (empty($this->currentVersion))
		{
			$this->currentVersion = Version::MAJOR_VERSION;
		}

		return $container->get('J' . $this->currentVersion . '.Field.Core.Rule');
	}
}

