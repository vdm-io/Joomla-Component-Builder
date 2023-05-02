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
use VDM\Joomla\Gitea\User as Usr;
use VDM\Joomla\Gitea\User\Applications;
use VDM\Joomla\Gitea\User\Emails;
use VDM\Joomla\Gitea\User\Followers;
use VDM\Joomla\Gitea\User\Following;
use VDM\Joomla\Gitea\User\Gpg;
use VDM\Joomla\Gitea\User\Keys;
use VDM\Joomla\Gitea\User\Repos;
use VDM\Joomla\Gitea\User\Settings;
use VDM\Joomla\Gitea\User\Starred;
use VDM\Joomla\Gitea\User\Subscriptions;
use VDM\Joomla\Gitea\User\Teams;
use VDM\Joomla\Gitea\User\Times;
use VDM\Joomla\Gitea\User\Tokens;


/**
 * The Gitea User Service
 * 
 * @since 3.2.0
 */
class User implements ServiceProviderInterface
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
		$container->alias(Usr::class, 'Gitea.User')
			->share('Gitea.User', [$this, 'getUser'], true);

		$container->alias(Applications::class, 'Gitea.User.Applications')
			->share('Gitea.User.Applications', [$this, 'getApplications'], true);

		$container->alias(Emails::class, 'Gitea.User.Emails')
			->share('Gitea.User.Emails', [$this, 'getEmails'], true);

		$container->alias(Followers::class, 'Gitea.User.Followers')
			->share('Gitea.User.Followers', [$this, 'getFollowers'], true);

		$container->alias(Following::class, 'Gitea.User.Following')
			->share('Gitea.User.Following', [$this, 'getFollowing'], true);

		$container->alias(Gpg::class, 'Gitea.User.Gpg')
			->share('Gitea.User.Gpg', [$this, 'getGpg'], true);

		$container->alias(Keys::class, 'Gitea.User.Keys')
			->share('Gitea.User.Keys', [$this, 'getKeys'], true);

		$container->alias(Repos::class, 'Gitea.User.Repos')
			->share('Gitea.User.Repos', [$this, 'getRepos'], true);

		$container->alias(Settings::class, 'Gitea.User.Settings')
			->share('Gitea.User.Settings', [$this, 'getSettings'], true);

		$container->alias(Starred::class, 'Gitea.User.Starred')
			->share('Gitea.User.Starred', [$this, 'getStarred'], true);

		$container->alias(Subscriptions::class, 'Gitea.User.Subscriptions')
			->share('Gitea.User.Subscriptions', [$this, 'getSubscriptions'], true);

		$container->alias(Teams::class, 'Gitea.User.Teams')
			->share('Gitea.User.Teams', [$this, 'getTeams'], true);

		$container->alias(Times::class, 'Gitea.User.Times')
			->share('Gitea.User.Times', [$this, 'getTimes'], true);

		$container->alias(Tokens::class, 'Gitea.User.Tokens')
			->share('Gitea.User.Tokens', [$this, 'getTokens'], true);
	}

	/**
	 * Get the User class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Usr
	 * @since 3.2.0
	 */
	public function getUser(Container $container): Usr
	{
		return new Usr(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Applications class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Applications
	 * @since 3.2.0
	 */
	public function getApplications(Container $container): Applications
	{
		return new Applications(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Emails class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Emails
	 * @since 3.2.0
	 */
	public function getEmails(Container $container): Emails
	{
		return new Emails(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Followers class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Followers
	 * @since 3.2.0
	 */
	public function getFollowers(Container $container): Followers
	{
		return new Followers(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Following class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Following
	 * @since 3.2.0
	 */
	public function getFollowing(Container $container): Following
	{
		return new Following(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Gpg class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Gpg
	 * @since 3.2.0
	 */
	public function getGpg(Container $container): Gpg
	{
		return new Gpg(
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
	 * Get the Repos class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Repos
	 * @since 3.2.0
	 */
	public function getRepos(Container $container): Repos
	{
		return new Repos(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Settings class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Settings
	 * @since 3.2.0
	 */
	public function getSettings(Container $container): Settings
	{
		return new Settings(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Starred class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Starred
	 * @since 3.2.0
	 */
	public function getStarred(Container $container): Starred
	{
		return new Starred(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Subscriptions class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Subscriptions
	 * @since 3.2.0
	 */
	public function getSubscriptions(Container $container): Subscriptions
	{
		return new Subscriptions(
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
	 * Get the Times class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Times
	 * @since 3.2.0
	 */
	public function getTimes(Container $container): Times
	{
		return new Times(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Tokens class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Tokens
	 * @since 3.2.0
	 */
	public function getTokens(Container $container): Tokens
	{
		return new Tokens(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

}

