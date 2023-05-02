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
use VDM\Joomla\Gitea\Settings\Api;
use VDM\Joomla\Gitea\Settings\Attachment;
use VDM\Joomla\Gitea\Settings\Repository;
use VDM\Joomla\Gitea\Settings\Ui;


/**
 * The Gitea Settings Service
 * 
 * @since 3.2.0
 */
class Settings implements ServiceProviderInterface
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
		$container->alias(Api::class, 'Gitea.Settings.Api')
			->share('Gitea.Settings.Api', [$this, 'getApi'], true);

		$container->alias(Attachment::class, 'Gitea.Settings.Attachment')
			->share('Gitea.Settings.Attachment', [$this, 'getAttachment'], true);

		$container->alias(Repository::class, 'Gitea.Settings.Repository')
			->share('Gitea.Settings.Repository', [$this, 'getRepository'], true);

		$container->alias(Ui::class, 'Gitea.Settings.Ui')
			->share('Gitea.Settings.Ui', [$this, 'getUi'], true);
	}

	/**
	 * Get the Api class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Api
	 * @since 3.2.0
	 */
	public function getApi(Container $container): Api
	{
		return new Api(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}

	/**
	 * Get the Attachment class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Attachment
	 * @since 3.2.0
	 */
	public function getAttachment(Container $container): Attachment
	{
		return new Attachment(
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
	 * Get the Ui class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Ui
	 * @since 3.2.0
	 */
	public function getUi(Container $container): Ui
	{
		return new Ui(
			$container->get('Gitea.Utilities.Http'),
			$container->get('Gitea.Dynamic.Uri'),
			$container->get('Gitea.Utilities.Response')
		);
	}


}

