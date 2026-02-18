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
use VDM\Joomla\Componentbuilder\Spreadsheet\Exporter;
use VDM\Joomla\Componentbuilder\Spreadsheet\RowDataArray;
use VDM\Joomla\Spreadsheet\Header;
use VDM\Joomla\Import\Spreadsheet\Reader;
use VDM\Joomla\Import\Spreadsheet\FileReader;


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
		$container->alias(Exporter::class, 'Spreadsheet.Exporter')
			->share('Spreadsheet.Exporter', [$this, 'getExporter'], true);

		$container->alias(RowDataArray::class, 'Spreadsheet.RowDataArray')
			->share('Spreadsheet.RowDataArray', [$this, 'getRowDataArray'], true);

		$container->alias(Header::class, 'Spreadsheet.Header')
			->share('Spreadsheet.Header', [$this, 'getHeader'], true);

		$container->alias(Reader::class, 'Spreadsheet.Reader')
			->share('Spreadsheet.Reader', [$this, 'getReader'], true);

		$container->alias(FileReader::class, 'Spreadsheet.FileReader')
			->share('Spreadsheet.FileReader', [$this, 'getFileReader'], true);
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
	 * Get The RowDataArray Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  RowDataArray
	 * @since 5.0.2
	 */
	public function getRowDataArray(Container $container): RowDataArray
	{
		return new RowDataArray();
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
	 * Get The Reader Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Reader
	 * @since 5.0.3
	 */
	public function getReader(Container $container): Reader
	{
		return new Reader(
			$container->get('Spreadsheet.FileReader')
		);
	}

	/**
	 * Get The FileReader Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FileReader
	 * @since 5.0.3
	 */
	public function getFileReader(Container $container): FileReader
	{
		return new FileReader();
	}
}

