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

namespace VDM\Joomla\Gitea\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Gitea\Notifications as Notifi;
use VDM\Joomla\Gitea\Notifications\Repository;
use VDM\Joomla\Gitea\Notifications\Thread;


/**
 * The Gitea Notifications Service
 * 
 * @since 3.2.0
 */
class Notifications implements ServiceProviderInterface
{
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
		$container->alias(Notifi::class, 'Gitea.Notifications')
			->share('Gitea.Notifications', [$this, 'getNotifications'], true);

		$container->alias(Repository::class, 'Gitea.Notifications.Repository')
			->share('Gitea.Notifications.Repository', [$this, 'getRepository'], true);

		$container->alias(Thread::class, 'Gitea.Notifications.Thread')
			->share('Gitea.Notifications.Thread', [$this, 'getThread'], true);
	}

	/**
	 * Get the Notifications class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Notifi
	 * @since 3.2.0
	 */
	public function getNotifications(Container $container): Notifi
	{
		return new Notifi(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Repository class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Repository
	 * @since 3.2.0
	 */
	public function getRepository(Container $container): Repository
	{
		return new Repository(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Thread class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Thread
	 * @since 3.2.0
	 */
	public function getThread(Container $container): Thread
	{
		return new Thread(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

}

