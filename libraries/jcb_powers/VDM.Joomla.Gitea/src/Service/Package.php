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
use VDM\Joomla\Gitea\Package as Pack;
use VDM\Joomla\Gitea\Package\Files;
use VDM\Joomla\Gitea\Package\Owner;


/**
 * The Gitea Package Service
 * 
 * @since 3.2.0
 */
class Package implements ServiceProviderInterface
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
		$container->alias(Pack::class, 'Gitea.Package')
			->share('Gitea.Package', [$this, 'getPackage'], true);

		$container->alias(Files::class, 'Gitea.Package.Files')
			->share('Gitea.Package.Files', [$this, 'getFiles'], true);

		$container->alias(Owner::class, 'Gitea.Package.Owner')
			->share('Gitea.Package.Owner', [$this, 'getOwner'], true);
	}

	/**
	 * Get the Package class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Pack
	 * @since 3.2.0
	 */
	public function getPackage(Container $container): Pack
	{
		return new Pack(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Files class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Files
	 * @since 3.2.0
	 */
	public function getFiles(Container $container): Files
	{
		return new Files(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Owner class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Owner
	 * @since 3.2.0
	 */
	public function getOwner(Container $container): Owner
	{
		return new Owner(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

}

