<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Extruder;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\ExtruderInterface;


/**
 * Extrusion Entry Service Provider
 * 
 * Registers the one service a caller resolves. Everything else in the domain
 * arrives through constructor injection below it.
 * 
 * @since 6.1.6
 */
class Extrusion implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	public function register(Container $container)
	{
		$container->alias(Extruder::class, 'Extruder')
			->alias(ExtruderInterface::class, 'Extruder')
			->share('Extruder', [$this, 'getExtruder'], true);
	}

	/**
	 * Get the Extruder.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Extruder
	 * @since   6.1.6
	 */
	public function getExtruder(Container $container): Extruder
	{
		return new Extruder(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Scope'),
			$container->get('Extrusion.Collector'),
			$container->get('Extrusion.Reader.Dispatcher'),
			$container->get('Extrusion.Assembler'),
			$container->get('Extrusion.Writer.Dispatcher'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Registry.Message'),
			$container->get('Extrusion.Reader.Schema'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Prefix'),
			$container->get('Extrusion.Resolver.Reuse'),
			$container->get('Extrusion.Resolver.Candidates'),
			$container->get('Extrusion.Resolver.Sharing'),
			$container->get('Extrusion.Registry.Plan'),
			$container->get('Extrusion.Resolver.Commit'),
			$container->get('Extrusion.Powers.Extruder')
		);
	}
}

