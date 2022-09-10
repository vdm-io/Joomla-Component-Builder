<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\CMS\Version;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaThree\History as J3History;


/**
 * History Service Provider
 * 
 * @since 3.2.0
 */
class History implements ServiceProviderInterface
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
		$container->alias(J3History::class, 'J3.History')
			->share('J3.History', [$this, 'getJ3History'], true);

		$container->alias(HistoryInterface::class, 'History')
			->share('History', [$this, 'getHistory'], true);
	}

	/**
	 * Get the History
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  HistoryInterface
	 * @since 3.2.0
	 */
	public function getHistory(Container $container): HistoryInterface
	{
		if (empty($this->currentVersion))
		{
			$this->currentVersion = Version::MAJOR_VERSION;
		}

		return $container->get('J' . $this->currentVersion . '.History');
	}

	/**
	 * Get the Joomla 3 History
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3History
	 * @since 3.2.0
	 */
	public function getJ3History(Container $container): J3History
	{
		return new J3History(
			$container->get('Config')
		);
	}

}

