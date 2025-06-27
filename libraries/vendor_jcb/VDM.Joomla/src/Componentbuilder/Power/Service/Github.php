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
use VDM\Joomla\Github\Repository\Contents;
use VDM\Joomla\Github\Repository\Tags;
use VDM\Joomla\Github\Repository\Wiki;


/**
 * Power Github Service Provider
 * 
 * @since 5.1.1
 */
class Github implements ServiceProviderInterface
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
		$container->alias(Contents::class, 'Github.Repository.Contents')
			->share('Github.Repository.Contents', [$this, 'getContents'], true);

		$container->alias(Tags::class, 'Github.Repository.Tags')
			->share('Github.Repository.Tags', [$this, 'getTags'], true);

		$container->alias(Wiki::class, 'Github.Repository.Wiki')
			->share('Github.Repository.Wiki', [$this, 'getWiki'], true);
	}

	/**
	 * Get the Contents class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Contents
	 * @since   5.1.1
	 */
	public function getContents(Container $container): Contents
	{
		return new Contents(
			$container->get('Github.Utilities.Http'),
			$container->get('Github.Utilities.Uri'),
			$container->get('Github.Utilities.Response')
		);
	}

	/**
	 * Get the Tags class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Tags
	 * @since   5.1.1
	 */
	public function getTags(Container $container): Tags
	{
		return new Tags(
			$container->get('Github.Utilities.Http'),
			$container->get('Github.Utilities.Uri'),
			$container->get('Github.Utilities.Response')
		);
	}

	/**
	 * Get the Wiki class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Wiki
	 * @since   5.1.1
	 */
	public function getWiki(Container $container): Wiki
	{
		return new Wiki(
			$container->get('Github.Utilities.Http'),
			$container->get('Github.Utilities.Uri'),
			$container->get('Github.Utilities.Response')
		);
	}
}

