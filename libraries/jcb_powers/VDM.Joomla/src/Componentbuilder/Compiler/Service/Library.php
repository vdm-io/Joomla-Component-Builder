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
use VDM\Joomla\Componentbuilder\Compiler\Library\Data;
use VDM\Joomla\Componentbuilder\Compiler\Library\Builder;


/**
 * Compiler Library
 * 
 * @since 3.2.0
 */
class Library implements ServiceProviderInterface
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
		$container->alias(Data::class, 'Library.Data')
			->share('Library.Data', [$this, 'getData'], true);

		$container->alias(Builder::class, 'Library.Builder')
			->share('Library.Builder', [$this, 'getBuilder'], true);
	}

	/**
	 * Get the Compiler Library Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Data
	 * @since 3.2.0
	 */
	public function getData(Container $container): Data
	{
		return new Data(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Field.Data'),
			$container->get('Model.Filesfolders')
		);
	}

	/**
	 * Get the Compiler Library Builder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Builder
	 * @since 3.2.0
	 */
	public function getBuilder(Container $container): Builder
	{
		return new Builder(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Event'),
			$container->get('Component'),
			$container->get('Content'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Folder'),
			$container->get('Utilities.File')
		);
	}

}

