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

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\CMS\Version;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaThree\Event as J3Event;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaFour\Event as J4Event;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaFive\Event as J5Event;


/**
 * Event Service Provider
 * 
 * @since 3.2.0
 */
class Event implements ServiceProviderInterface
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
		$container->alias(J3Event::class, 'J3.Event')
			->share('J3.Event', [$this, 'getJ3Event'], true);

		$container->alias(J4Event::class, 'J4.Event')
			->share('J4.Event', [$this, 'getJ4Event'], true);

		$container->alias(J5Event::class, 'J5.Event')
			->share('J5.Event', [$this, 'getJ5Event'], true);

		$container->alias(EventInterface::class, 'Event')
			->share('Event', [$this, 'getEvent'], true);
	}

	/**
	 * Get the Event
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  EventInterface
	 * @since 3.2.0
	 */
	public function getEvent(Container $container): EventInterface
	{
		if (empty($this->currentVersion))
		{
			$this->currentVersion = Version::MAJOR_VERSION;
		}

		return $container->get('J' . $this->currentVersion . '.Event');
	}

	/**
	 * Get the Joomla 3 Event
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Event
	 * @since 3.2.0
	 */
	public function getJ3Event(Container $container): J3Event
	{
		return new J3Event();
	}

	/**
	 * Get the Joomla 4 Event
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Event
	 * @since 3.2.0
	 */
	public function getJ4Event(Container $container): J4Event
	{
		return new J4Event();
	}

	/**
	 * Get the Joomla 5 Event
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Event
	 * @since 3.2.0
	 */
	public function getJ5Event(Container $container): J5Event
	{
		return new J5Event();
	}
}

