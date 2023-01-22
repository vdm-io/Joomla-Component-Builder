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
use VDM\Joomla\Componentbuilder\Compiler\Library\Data as LibraryData;


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
		$container->alias(LibraryData::class, 'Library.Data')
			->share('Library.Data', [$this, 'getLibraryData'], true);
	}

	/**
	 * Get the Compiler Library Data
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LibraryData
	 * @since 3.2.0
	 */
	public function getLibraryData(Container $container): LibraryData
	{
		return new LibraryData(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Field.Data'),
			$container->get('Model.Filesfolders')
		);
	}

}

