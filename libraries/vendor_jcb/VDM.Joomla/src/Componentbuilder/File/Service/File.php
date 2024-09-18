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

namespace VDM\Joomla\Componentbuilder\File\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\File\Type;
use VDM\Joomla\Componentbuilder\File\Handler;
use VDM\Joomla\Componentbuilder\File\Manager;
use VDM\Joomla\Componentbuilder\File\Display;


/**
 * File Service Provider
 * 
 * @since  5.0.3
 */
class File implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 5.0.3
	 */
	public function register(Container $container)
	{
		$container->alias(Type::class, 'File.Type')
			->share('File.Type', [$this, 'getType'], true);

		$container->alias(Handler::class, 'File.Handler')
			->share('File.Handler', [$this, 'getHandler'], true);

		$container->alias(Manager::class, 'File.Manager')
			->share('File.Manager', [$this, 'getManager'], true);

		$container->alias(Display::class, 'File.Display')
			->share('File.Display', [$this, 'getDisplay'], true);
	}

	/**
	 * Get The Type Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Type
	 * @since 5.0.3
	 */
	public function getType(Container $container): Type
	{
		return new Type(
			$container->get('Data.Item')
		);
	}

	/**
	 * Get The Handler Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Handler
	 * @since 5.0.3
	 */
	public function getHandler(Container $container): Handler
	{
		return new Handler();
	}

	/**
	 * Get The Manager Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Manager
	 * @since 5.0.3
	 */
	public function getManager(Container $container): Manager
	{
		return new Manager(
			$container->get('Data.Item'),
			$container->get('Data.Items'),
			$container->get('File.Type'),
			$container->get('File.Handler')
		);
	}

	/**
	 * Get The Display Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Display
	 * @since 5.0.3
	 */
	public function getDisplay(Container $container): Display
	{
		return new Display(
			$container->get('Data.Item'),
			$container->get('Data.Items')
		);
	}
}

