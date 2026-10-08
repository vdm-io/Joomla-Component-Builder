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
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Dispatcher;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Form as FormReader;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Language as LanguageReader;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Php\Literal;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Php\Template;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Schema as SchemaReader;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Sql\CreateTable;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Sql\Insert;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Sql\Splitter;
use VDM\Joomla\Componentbuilder\Extrusion\Reader\Table as TableReader;


/**
 * Extrusion Reader Service Provider
 * 
 * Every reader is pure with respect to JCB: it reads a file from an untrusted
 * source tree into a registry, and never touches the database.
 * 
 * @since 6.1.6
 */
class Reader implements ServiceProviderInterface
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
		$container->alias(Splitter::class, 'Extrusion.Sql.Splitter')
			->share('Extrusion.Sql.Splitter', [$this, 'getSplitter'], true);

		$container->alias(CreateTable::class, 'Extrusion.Sql.CreateTable')
			->share('Extrusion.Sql.CreateTable', [$this, 'getCreateTable'], true);

		$container->alias(Insert::class, 'Extrusion.Sql.Insert')
			->share('Extrusion.Sql.Insert', [$this, 'getInsert'], true);

		$container->alias(Template::class, 'Extrusion.Php.Template')
			->share('Extrusion.Php.Template', [$this, 'getTemplate'], true);

		$container->alias(Literal::class, 'Extrusion.Php.Literal')
			->share('Extrusion.Php.Literal', [$this, 'getLiteral'], true);

		$container->alias(SchemaReader::class, 'Extrusion.Reader.Schema')
			->share('Extrusion.Reader.Schema', [$this, 'getSchemaReader'], true);

		$container->alias(FormReader::class, 'Extrusion.Reader.Form')
			->share('Extrusion.Reader.Form', [$this, 'getFormReader'], true);

		$container->alias(LanguageReader::class, 'Extrusion.Reader.Language')
			->share('Extrusion.Reader.Language', [$this, 'getLanguageReader'], true);

		$container->alias(TableReader::class, 'Extrusion.Reader.Table')
			->share('Extrusion.Reader.Table', [$this, 'getTableReader'], true);

		$container->alias(Dispatcher::class, 'Extrusion.Reader.Dispatcher')
			->share('Extrusion.Reader.Dispatcher', [$this, 'getDispatcher'], true);
	}

	/**
	 * Get the SQL Splitter.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Splitter
	 * @since   6.1.6
	 */
	public function getSplitter(Container $container): Splitter
	{
		return new Splitter();
	}

	/**
	 * Get the CREATE TABLE parser.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CreateTable
	 * @since   6.1.6
	 */
	public function getCreateTable(Container $container): CreateTable
	{
		return new CreateTable();
	}

	/**
	 * Get the INSERT parser.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Insert
	 * @since   6.1.6
	 */
	public function getInsert(Container $container): Insert
	{
		return new Insert();
	}

	/**
	 * Get the literal-only PHP array parser.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Literal
	 * @since   6.1.6
	 */
	public function getLiteral(Container $container): Literal
	{
		return new Literal();
	}

	/**
	 * Get the Schema Reader.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SchemaReader
	 * @since   6.1.6
	 */
	public function getSchemaReader(Container $container): SchemaReader
	{
		return new SchemaReader(
			$container->get('Extrusion.Registry.Schema'),
			$container->get('Extrusion.Sql.Splitter'),
			$container->get('Extrusion.Sql.CreateTable'),
			$container->get('Extrusion.Sql.Insert'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Form Reader.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FormReader
	 * @since   6.1.6
	 */
	public function getFormReader(Container $container): FormReader
	{
		return new FormReader(
			$container->get('Extrusion.Registry.Form'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Language Reader.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LanguageReader
	 * @since   6.1.6
	 */
	public function getLanguageReader(Container $container): LanguageReader
	{
		return new LanguageReader(
			$container->get('Extrusion.Registry.Language'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Table Class Reader.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TableReader
	 * @since   6.1.6
	 */
	public function getTableReader(Container $container): TableReader
	{
		return new TableReader(
			$container->get('Extrusion.Registry.Table'),
			$container->get('Extrusion.Php.Literal'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Reader Dispatcher.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Dispatcher
	 * @since   6.1.6
	 */
	public function getDispatcher(Container $container): Dispatcher
	{
		return new Dispatcher(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Inventory'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Reader.Language'),
			$container->get('Extrusion.Reader.Table'),
			$container->get('Extrusion.Reader.Schema'),
			$container->get('Extrusion.Reader.Form'),
			$container->get('Extrusion.Registry.View'),
			$container->get('Extrusion.Php.Template')
		);
	}

	/**
	 * Get the view template reader.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Template
	 * @since   6.2.0
	 */
	public function getTemplate(Container $container): Template
	{
		return new Template();
	}
}

