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
use VDM\Joomla\Gitea\Organization as Org;
use VDM\Joomla\Gitea\Organization\Hooks;
use VDM\Joomla\Gitea\Organization\Labels;
use VDM\Joomla\Gitea\Organization\Members;
use VDM\Joomla\Gitea\Organization\PublicMembers as PublicMembers;
use VDM\Joomla\Gitea\Organization\Repository;
use VDM\Joomla\Gitea\Organization\Teams;
use VDM\Joomla\Gitea\Organization\Teams\Members as TeamsMembers;
use VDM\Joomla\Gitea\Organization\Teams\Repository as TeamsRepository;
use VDM\Joomla\Gitea\Organization\User;


/**
 * The Gitea Organization Service
 * 
 * @since 3.2.0
 */
class Organization implements ServiceProviderInterface
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
		$container->alias(Org::class, 'Gitea.Organization')
			->share('Gitea.Organization', [$this, 'getOrganization'], true);

		$container->alias(Hooks::class, 'Gitea.Organization.Hooks')
			->share('Gitea.Organization.Hooks', [$this, 'getHooks'], true);

		$container->alias(Labels::class, 'Gitea.Organization.Labels')
			->share('Gitea.Organization.Labels', [$this, 'getLabels'], true);

		$container->alias(Members::class, 'Gitea.Organization.Members')
			->share('Gitea.Organization.Members', [$this, 'getMembers'], true);

		$container->alias(PublicMembers::class, 'Gitea.Organization.Public.Members')
			->share('Gitea.Organization.Public.Members', [$this, 'getPublicMembers'], true);

		$container->alias(Repository::class, 'Gitea.Organization.Repository')
			->share('Gitea.Organization.Repository', [$this, 'getRepository'], true);

		$container->alias(Teams::class, 'Gitea.Organization.Teams')
			->share('Gitea.Organization.Teams', [$this, 'getTeams'], true);

		$container->alias(TeamsMembers::class, 'Gitea.Organization.Teams.Members')
			->share('Gitea.Organization.Teams.Members', [$this, 'getTeamsMembers'], true);

		$container->alias(TeamsRepository::class, 'Gitea.Organization.Teams.Repository')
			->share('Gitea.Organization.Teams.Repository', [$this, 'getTeamsRepository'], true);

		$container->alias(User::class, 'Gitea.Organization.User')
			->share('Gitea.Organization.User', [$this, 'getUser'], true);
	}

	/**
	 * Get the Organization class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Org
	 * @since 3.2.0
	 */
	public function getOrganization(Container $container): Org
	{
		return new Org(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Hooks class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Hooks
	 * @since 3.2.0
	 */
	public function getHooks(Container $container): Hooks
	{
		return new Hooks(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Labels class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Labels
	 * @since 3.2.0
	 */
	public function getLabels(Container $container): Labels
	{
		return new Labels(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Members class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Members
	 * @since 3.2.0
	 */
	public function getMembers(Container $container): Members
	{
		return new Members(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Public Members class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PublicMembers
	 * @since 3.2.0
	 */
	public function getPublicMembers(Container $container): PublicMembers
	{
		return new PublicMembers(
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
	 * Get the Teams class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Teams
	 * @since 3.2.0
	 */
	public function getTeams(Container $container): Teams
	{
		return new Teams(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Teams Members class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TeamsMembers
	 * @since 3.2.0
	 */
	public function getTeamsMembers(Container $container): TeamsMembers
	{
		return new TeamsMembers(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Teams Repository class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TeamsRepository
	 * @since 3.2.0
	 */
	public function getTeamsRepository(Container $container): TeamsRepository
	{
		return new TeamsRepository(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the User class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  User
	 * @since 3.2.0
	 */
	public function getUser(Container $container): User
	{
		return new User(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

}

