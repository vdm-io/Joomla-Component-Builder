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

namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Spreadsheet\Header;
use VDM\Joomla\Componentbuilder\Spreadsheet\Exporter;
use VDM\Joomla\Componentbuilder\Spreadsheet\Importer;


/**
 * Spreadsheet Service Provider
 * 
 * @since  5.0.3
 */
class Spreadsheet implements ServiceProviderInterface
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
		$container->alias(Header::class, 'Spreadsheet.Header')
			->share('Spreadsheet.Header', [$this, 'getHeader'], true);

		$container->alias(Exporter::class, 'Spreadsheet.Exporter')
			->share('Spreadsheet.Exporter', [$this, 'getExporter'], true);

		$container->alias(Importer::class, 'Spreadsheet.Importer')
			->share('Spreadsheet.Importer', [$this, 'getImporter'], true);
	}

	/**
	 * Get The Header Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Header
	 * @since 5.0.3
	 */
	public function getHeader(Container $container): Header
	{
		return new Header();
	}

	/**
	 * Get The Exporter Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Exporter
	 * @since 5.0.3
	 */
	public function getExporter(Container $container): Exporter
	{
		return new Exporter();
	}

	/**
	 * Get The Importer Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Importer
	 * @since 5.0.3
	 */
	public function getImporter(Container $container): Importer
	{
		return new Importer();
	}
}

