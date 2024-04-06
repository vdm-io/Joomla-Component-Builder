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

namespace VDM\Joomla\Componentbuilder\Power\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Gitea\Repository\Contents;


/**
 * Power Gitea Service Provider
 * 
 * @since 3.2.0
 */
class Gitea implements ServiceProviderInterface
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
		$container->alias(Contents::class, 'Gitea.Repository.Contents')
			->share('Gitea.Repository.Contents', [$this, 'getContents'], true);
	}

	/**
	 * Get the Contents class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Contents
	 * @since 3.2.0
	 */
	public function getContents(Container $container): Contents
	{
		return new Contents(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}
}

