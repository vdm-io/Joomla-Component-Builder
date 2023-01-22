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
use VDM\Joomla\Componentbuilder\Compiler\Adminview\Data as AdminviewData;


/**
 * Compiler Adminview
 * 
 * @since 3.2.0
 */
class Adminview implements ServiceProviderInterface
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
		$container->alias(AdminviewData::class, 'Adminview.Data')
			->share('Adminview.Data', [$this, 'getAdminviewData'], true);
	}

	/**
	 * Get the Compiler Adminview Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminviewData
	 * @since 3.2.0
	 */
	public function getAdminviewData(Container $container): AdminviewData
	{
		return new AdminviewData(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Customcode.Dispenser'),
			$container->get('Model.Customtabs'),
			$container->get('Model.Tabs'),
			$container->get('Model.Fields'),
			$container->get('Model.Historyadminview'),
			$container->get('Model.Permissions'),
			$container->get('Model.Conditions'),
			$container->get('Model.Relations'),
			$container->get('Model.Linkedviews'),
			$container->get('Model.Javascriptadminview'),
			$container->get('Model.Cssadminview'),
			$container->get('Model.Phpadminview'),
			$container->get('Model.Custombuttons'),
			$container->get('Model.Customimportscripts'),
			$container->get('Model.Ajaxadmin'),
			$container->get('Model.Customalias'),
			$container->get('Model.Sql'),
			$container->get('Model.Mysqlsettings')
		);
	}

}

