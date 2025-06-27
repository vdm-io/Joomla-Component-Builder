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
use VDM\Joomla\Git\Repository\Contents;


/**
 * Power Git Service Provider
 * 
 * @since 5.1.1
 */
class Git implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since  5.1.1
	 */
	public function register(Container $container)
	{
		$container->alias(Contents::class, 'Git.Repository.Contents')
			->share('Git.Repository.Contents', [$this, 'getContents'], true);
	}

	/**
	 * Get the Contents class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Contents
	 * @since  5.1.1
	 */
	public function getContents(Container $container): Contents
	{
		return new Contents(
			$container->get('Gitea.Repository.Contents'),
			$container->get('Github.Repository.Contents')
		);
	}
}

