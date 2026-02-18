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

namespace VDM\Joomla\Componentbuilder\User;


use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\CMS\User\UserFactoryInterface;
use VDM\Joomla\Utilities\Component\Helper;


/**
 * Execution Identity Trait.
 * 
 * Provides a unified, security-hardened mechanism for resolving the effective
 * user identity based on the current execution context.
 * 
 * This trait enforces a strict trust boundary:
 * - In web execution, an authenticated user identity is required.
 * - In CLI execution, the context is treated as elevated and explicitly
 *   resolves the Super User identity (ID 1).
 * 
 * Silent privilege escalation is explicitly forbidden. If an identity cannot
 * be resolved according to the active execution context, execution is aborted
 * immediately with a runtime exception.
 * 
 * This trait is intended for use in privileged services, compilers, and
 * command handlers where deterministic ACL behaviour is required across
 * both web and CLI environments.
 * 
 * @since 5.1.4
 */
trait IdentityTrait
{
	/**
	 * Resolve the effective user for the current execution context.
	 *
	 * Identity resolution strategy:
	 * - Always attempt to retrieve the application identity first.
	 * - If identity retrieval fails or yields an invalid user, check whether
	 *   execution is occurring in a CLI context.
	 * - Only in CLI context is a configured privileged user explicitly assumed.
	 *
	 * Silent privilege escalation is forbidden. Privileged identities are never
	 * loaded in web execution contexts.
	 *
	 * @throws \RuntimeException If a valid identity cannot be resolved.
	 *
	 * @return User
	 * @since  5.1.4
	 */
	protected function getIdentity(): User
	{
		$app = Factory::getApplication();

		/*
		 * Fast path: application provides identity (web or CLI-aware apps)
		 */
		if (method_exists($app, 'getIdentity'))
		{
			try
			{
				$user = $app->getIdentity();

				if ($user instanceof User) // && !$user->guest) // allow quest mode for now
				{
					return $user;
				}
			}
			catch (\Throwable $e)
			{
				// Intentionally ignored — fallback handled below
			}
		}

		/*
		 * Slow path: identity unavailable - CLI-only elevation allowed
		 */
		if ($app->isClient('cli'))
		{
			$userId = (int) Helper::getParams('com_componentbuilder')->get('cli_user', 0);

			//if ($userId <= 0) // allow quest mode for now
			//{
			//	throw new \RuntimeException(
			//		'User resolution failed: No CLI user configured.'
			//	);
			//}

			$container = Factory::getContainer();

			if ($container->has(UserFactoryInterface::class))
			{
				$user = $container
					->get(UserFactoryInterface::class)
					->loadUserById($userId);
			}
			else
			{
				// Backward compatibility only
				$user = Factory::getUser($userId);
			}

			if ($user instanceof User) // && !$user->guest) // allow quest mode for now
			{
				return $user;
			}

			throw new \RuntimeException(
				'User resolution failed: Configured CLI user could not be loaded.'
			);
		}

		/*
		 * Web context with no valid identity → hard failure
		 */
		throw new \RuntimeException(
			'User resolution failed: No authenticated user available in web execution context.'
		);
	}
}

