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
use VDM\Joomla\Gitea\Miscellaneous\Activitypub;
use VDM\Joomla\Gitea\Miscellaneous\Gpg;
use VDM\Joomla\Gitea\Miscellaneous\Markdown;
use VDM\Joomla\Gitea\Miscellaneous\NodeInfo;
use VDM\Joomla\Gitea\Miscellaneous\Version;


/**
 * The Gitea Miscellaneous Service
 * 
 * @since 3.2.0
 */
class Miscellaneous implements ServiceProviderInterface
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
		$container->alias(Activitypub::class, 'Gitea.Miscellaneous.Activitypub')
			->share('Gitea.Miscellaneous.Activitypub', [$this, 'getActivitypub'], true);

		$container->alias(Gpg::class, 'Gitea.Miscellaneous.Gpg')
			->share('Gitea.Miscellaneous.Gpg', [$this, 'getGpg'], true);

		$container->alias(Markdown::class, 'Gitea.Miscellaneous.Markdown')
			->share('Gitea.Miscellaneous.Markdown', [$this, 'getMarkdown'], true);

		$container->alias(NodeInfo::class, 'Gitea.Miscellaneous.NodeInfo')
			->share('Gitea.Miscellaneous.NodeInfo', [$this, 'getNodeInfo'], true);

		$container->alias(Version::class, 'Gitea.Miscellaneous.Version')
			->share('Gitea.Miscellaneous.Version', [$this, 'getVersion'], true);
	}

	/**
	 * Get the Activitypub class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Activitypub
	 * @since 3.2.0
	 */
	public function getActivitypub(Container $container): Activitypub
	{
		return new Activitypub(
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
	 * Get the Markdown class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Markdown
	 * @since 3.2.0
	 */
	public function getMarkdown(Container $container): Markdown
	{
		return new Markdown(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the NodeInfo class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  NodeInfo
	 * @since 3.2.0
	 */
	public function getNodeInfo(Container $container): NodeInfo
	{
		return new NodeInfo(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Version class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Version
	 * @since 3.2.0
	 */
	public function getVersion(Container $container): Version
	{
		return new Version(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

}

