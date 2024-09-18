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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\ComHelperClass\CreateUserInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\ComHelperClass\CreateUser as J5CreateUser;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\ComHelperClass\CreateUser as J4CreateUser;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\ComHelperClass\CreateUser as J3CreateUser;


/**
 * Architecture Component Helper Class Service Provider
 * 
 * @since 5.0.2
 */
class ArchitectureComHelperClass implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since 5.0.2
	 **/
	protected $targetVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 5.0.2
	 */
	public function register(Container $container)
	{
		$container->alias(CreateUserInterface::class, 'Architecture.ComHelperClass.CreateUser')
			->share('Architecture.ComHelperClass.CreateUser', [$this, 'getCreateUser'], true);

		$container->alias(J5CreateUser::class, 'Architecture.ComHelperClass.J5.CreateUser')
			->share('Architecture.ComHelperClass.J5.CreateUser', [$this, 'getJ5CreateUser'], true);

		$container->alias(J4CreateUser::class, 'Architecture.ComHelperClass.J4.CreateUser')
			->share('Architecture.ComHelperClass.J4.CreateUser', [$this, 'getJ4CreateUser'], true);

		$container->alias(J3CreateUser::class, 'Architecture.ComHelperClass.J3.CreateUser')
			->share('Architecture.ComHelperClass.J3.CreateUser', [$this, 'getJ3CreateUser'], true);
	}

	/**
	 * Get The CreateUserInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CreateUserInterface
	 * @since   5.0.2
	 */
	public function getCreateUser(Container $container): CreateUserInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.ComHelperClass.J' . $this->targetVersion . '.CreateUser');
	}

	/**
	 * Get The CreateUser Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5CreateUser
	 * @since   5.0.2
	 */
	public function getJ5CreateUser(Container $container): J5CreateUser
	{
		return new J5CreateUser();
	}

	/**
	 * Get The CreateUser Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4CreateUser
	 * @since   5.0.2
	 */
	public function getJ4CreateUser(Container $container): J4CreateUser
	{
		return new J4CreateUser();
	}

	/**
	 * Get The CreateUser Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3CreateUser
	 * @since   5.0.2
	 */
	public function getJ3CreateUser(Container $container): J3CreateUser
	{
		return new J3CreateUser();
	}
}

