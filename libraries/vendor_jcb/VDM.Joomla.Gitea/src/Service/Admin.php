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
use VDM\Joomla\Gitea\Admin\Cron;
use VDM\Joomla\Gitea\Admin\Organizations;
use VDM\Joomla\Gitea\Admin\Unadopted;
use VDM\Joomla\Gitea\Admin\Users;
use VDM\Joomla\Gitea\Admin\Users\Keys;
use VDM\Joomla\Gitea\Admin\Users\Organization;
use VDM\Joomla\Gitea\Admin\Users\Repository;


/**
 * The Gitea Admin Service
 * 
 * @since 3.2.0
 */
class Admin implements ServiceProviderInterface
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
		$container->alias(Cron::class, 'Gitea.Admin.Cron')
			->share('Gitea.Admin.Cron', [$this, 'getCron'], true);

		$container->alias(Organizations::class, 'Gitea.Admin.Organizations')
			->share('Gitea.Admin.Organizations', [$this, 'getOrganizations'], true);

		$container->alias(Unadopted::class, 'Gitea.Admin.Unadopted')
			->share('Gitea.Admin.Unadopted', [$this, 'getUnadopted'], true);

		$container->alias(Users::class, 'Gitea.Admin.Users')
			->share('Gitea.Admin.Users', [$this, 'getUsers'], true);

		$container->alias(Keys::class, 'Gitea.Admin.Users.Keys')
			->share('Gitea.Admin.Users.Keys', [$this, 'getKeys'], true);

		$container->alias(Organization::class, 'Gitea.Admin.Users.Organization')
			->share('Gitea.Admin.Users.Organization', [$this, 'getOrganization'], true);

		$container->alias(Repository::class, 'Gitea.Admin.Users.Repository')
			->share('Gitea.Admin.Users.Repository', [$this, 'getRepository'], true);
	}

	/**
	 * Get the Cron class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Cron
	 * @since 3.2.0
	 */
	public function getCron(Container $container): Cron
	{
		return new Cron(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Organizations class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Organizations
	 * @since 3.2.0
	 */
	public function getOrganizations(Container $container): Organizations
	{
		return new Organizations(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Unadopted class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Unadopted
	 * @since 3.2.0
	 */
	public function getUnadopted(Container $container): Unadopted
	{
		return new Unadopted(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Users class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Users
	 * @since 3.2.0
	 */
	public function getUsers(Container $container): Users
	{
		return new Users(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Keys class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Keys
	 * @since 3.2.0
	 */
	public function getKeys(Container $container): Keys
	{
		return new Keys(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Organization class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Organization
	 * @since 3.2.0
	 */
	public function getOrganization(Container $container): Organization
	{
		return new Organization(
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
}

