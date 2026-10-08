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
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Collector;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Access;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Locator\Form as FormLocator;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Locator\Language as LanguageLocator;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Locator\Schema as SchemaLocator;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Locator\Table as TableLocator;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Locator\View as ViewLocator;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Manifest;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Scanner;
use VDM\Joomla\Componentbuilder\Extrusion\Discovery\Selector;
use VDM\Joomla\Componentbuilder\Extrusion\Layout\Heuristic;
use VDM\Joomla\Componentbuilder\Extrusion\Layout\JoomlaFive;
use VDM\Joomla\Componentbuilder\Extrusion\Layout\JoomlaFour;
use VDM\Joomla\Componentbuilder\Extrusion\Layout\JoomlaSix;
use VDM\Joomla\Componentbuilder\Extrusion\Layout\JoomlaThree;


/**
 * Extrusion Discovery Service Provider
 * 
 * All four target-version layouts are registered even though the modern three
 * currently share one placement map, so a future divergence lands in the provider
 * and never in a consumer conditional.
 * 
 * @since 6.1.6
 */
class Discovery implements ServiceProviderInterface
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
		$container->alias(Scanner::class, 'Extrusion.Scanner')
			->share('Extrusion.Scanner', [$this, 'getScanner'], true);

		$container->alias(Manifest::class, 'Extrusion.Manifest')
			->share('Extrusion.Manifest', [$this, 'getManifest'], true);

		$container->alias(Heuristic::class, 'Extrusion.Heuristic')
			->share('Extrusion.Heuristic', [$this, 'getHeuristic'], true);

		$container->alias(JoomlaThree::class, 'Extrusion.Layout.J3')
			->share('Extrusion.Layout.J3', [$this, 'getJoomlaThree'], true);

		$container->alias(JoomlaFour::class, 'Extrusion.Layout.J4')
			->share('Extrusion.Layout.J4', [$this, 'getJoomlaFour'], true);

		$container->alias(JoomlaFive::class, 'Extrusion.Layout.J5')
			->share('Extrusion.Layout.J5', [$this, 'getJoomlaFive'], true);

		$container->alias(JoomlaSix::class, 'Extrusion.Layout.J6')
			->share('Extrusion.Layout.J6', [$this, 'getJoomlaSix'], true);

		$container->alias(Selector::class, 'Extrusion.Selector')
			->share('Extrusion.Selector', [$this, 'getSelector'], true);

		$container->alias(SchemaLocator::class, 'Extrusion.Locator.Schema')
			->share('Extrusion.Locator.Schema', [$this, 'getSchemaLocator'], true);

		$container->alias(FormLocator::class, 'Extrusion.Locator.Form')
			->share('Extrusion.Locator.Form', [$this, 'getFormLocator'], true);

		$container->alias(LanguageLocator::class, 'Extrusion.Locator.Language')
			->share('Extrusion.Locator.Language', [$this, 'getLanguageLocator'], true);

		$container->alias(TableLocator::class, 'Extrusion.Locator.Table')
			->share('Extrusion.Locator.Table', [$this, 'getTableLocator'], true);

		$container->alias(ViewLocator::class, 'Extrusion.Locator.View')
			->share('Extrusion.Locator.View', [$this, 'getViewLocator'], true);

		$container->alias(Access::class, 'Extrusion.Access')
			->share('Extrusion.Access', [$this, 'getAccess'], true);

		$container->alias(Collector::class, 'Extrusion.Collector')
			->share('Extrusion.Collector', [$this, 'getCollector'], true);
	}

	/**
	 * Get the Scanner.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Scanner
	 * @since   6.1.6
	 */
	public function getScanner(Container $container): Scanner
	{
		return new Scanner(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Registry.Plan')
		);
	}

	/**
	 * Get the Manifest reader.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Manifest
	 * @since   6.1.6
	 */
	public function getManifest(Container $container): Manifest
	{
		return new Manifest(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the content-signature Heuristic.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Heuristic
	 * @since   6.1.6
	 */
	public function getHeuristic(Container $container): Heuristic
	{
		return new Heuristic();
	}

	/**
	 * Get the Joomla 3 layout.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaThree
	 * @since   6.1.6
	 */
	public function getJoomlaThree(Container $container): JoomlaThree
	{
		return new JoomlaThree();
	}

	/**
	 * Get the Joomla 4 layout.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaFour
	 * @since   6.1.6
	 */
	public function getJoomlaFour(Container $container): JoomlaFour
	{
		return new JoomlaFour();
	}

	/**
	 * Get the Joomla 5 layout.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaFive
	 * @since   6.1.6
	 */
	public function getJoomlaFive(Container $container): JoomlaFive
	{
		return new JoomlaFive();
	}

	/**
	 * Get the Joomla 6 layout.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JoomlaSix
	 * @since   6.1.6
	 */
	public function getJoomlaSix(Container $container): JoomlaSix
	{
		return new JoomlaSix();
	}

	/**
	 * Get the layout Selector.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Selector
	 * @since   6.1.6
	 */
	public function getSelector(Container $container): Selector
	{
		return new Selector(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Layout.J3'),
			$container->get('Extrusion.Layout.J4'),
			$container->get('Extrusion.Layout.J5'),
			$container->get('Extrusion.Layout.J6')
		);
	}

	/**
	 * Get the Schema Locator.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SchemaLocator
	 * @since   6.1.6
	 */
	public function getSchemaLocator(Container $container): SchemaLocator
	{
		return new SchemaLocator(
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Selector'),
			$container->get('Extrusion.Heuristic'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Form Locator.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FormLocator
	 * @since   6.1.6
	 */
	public function getFormLocator(Container $container): FormLocator
	{
		return new FormLocator(
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Selector'),
			$container->get('Extrusion.Heuristic'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Language Locator.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LanguageLocator
	 * @since   6.1.6
	 */
	public function getLanguageLocator(Container $container): LanguageLocator
	{
		return new LanguageLocator(
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Selector'),
			$container->get('Extrusion.Heuristic'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the Table Class Locator.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TableLocator
	 * @since   6.1.6
	 */
	public function getTableLocator(Container $container): TableLocator
	{
		return new TableLocator(
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Selector'),
			$container->get('Extrusion.Heuristic'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the View Locator.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewLocator
	 * @since   6.1.6
	 */
	public function getViewLocator(Container $container): ViewLocator
	{
		return new ViewLocator(
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Selector'),
			$container->get('Extrusion.Heuristic'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}

	/**
	 * Get the discovery Collector.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Collector
	 * @since   6.1.6
	 */
	public function getCollector(Container $container): Collector
	{
		return new Collector(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Manifest'),
			$container->get('Extrusion.Registry.Inventory'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Registry.Message'),
			$container->get('Extrusion.Locator.Schema'),
			$container->get('Extrusion.Locator.Form'),
			$container->get('Extrusion.Locator.Language'),
			$container->get('Extrusion.Locator.Table'),
			$container->get('Extrusion.Locator.View'),
			$container->get('Extrusion.Access')
		);
	}

	/**
	 * Get the access rules reader.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Access
	 * @since   6.1.8
	 */
	public function getAccess(Container $container): Access
	{
		return new Access(
			$container->get('Extrusion.Scanner'),
			$container->get('Extrusion.Selector'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Report')
		);
	}
}

