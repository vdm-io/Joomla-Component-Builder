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
use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Decision;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Form;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Harvest;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Inventory;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Language;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Message;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Proposal;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Plan;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Parsed;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Report;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Resolved;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Schema;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Scope;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Table;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\View;


/**
 * Extrusion Registry Service Provider
 * 
 * Every registry is shared, because they are the run's state and each service
 * must see the same instance. Scope is what clears them between runs.
 * 
 * @since 6.1.6
 */
class Registry implements ServiceProviderInterface
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
		$container->alias(Config::class, 'Extrusion.Config')
			->share('Extrusion.Config', [$this, 'getConfig'], true);

		$container->alias(Scope::class, 'Extrusion.Scope')
			->share('Extrusion.Scope', [$this, 'getScope'], true);

		$container->alias(Source::class, 'Extrusion.Registry.Source')
			->share('Extrusion.Registry.Source', [$this, 'getSource'], true);

		$container->alias(Inventory::class, 'Extrusion.Registry.Inventory')
			->share('Extrusion.Registry.Inventory', [$this, 'getInventory'], true);

		$container->alias(Table::class, 'Extrusion.Registry.Table')
			->share('Extrusion.Registry.Table', [$this, 'getTable'], true);

		$container->alias(Schema::class, 'Extrusion.Registry.Schema')
			->share('Extrusion.Registry.Schema', [$this, 'getSchema'], true);

		$container->alias(Form::class, 'Extrusion.Registry.Form')
			->share('Extrusion.Registry.Form', [$this, 'getForm'], true);

		$container->alias(Language::class, 'Extrusion.Registry.Language')
			->share('Extrusion.Registry.Language', [$this, 'getLanguage'], true);

		$container->alias(View::class, 'Extrusion.Registry.View')
			->share('Extrusion.Registry.View', [$this, 'getView'], true);

		$container->alias(Resolved::class, 'Extrusion.Registry.Resolved')
			->share('Extrusion.Registry.Resolved', [$this, 'getResolved'], true);

		$container->alias(Plan::class, 'Extrusion.Registry.Plan')
			->share('Extrusion.Registry.Plan', [$this, 'getPlan'], true);

		$container->alias(Proposal::class, 'Extrusion.Registry.Proposal')
			->share('Extrusion.Registry.Proposal', [$this, 'getProposal'], true);

		$container->alias(Harvest::class, 'Extrusion.Registry.Harvest')
			->share('Extrusion.Registry.Harvest', [$this, 'getHarvest'], true);

		$container->alias(Parsed::class, 'Extrusion.Registry.Parsed')
			->share('Extrusion.Registry.Parsed', [$this, 'getParsed'], true);

		$container->alias(Decision::class, 'Extrusion.Registry.Decision')
			->share('Extrusion.Registry.Decision', [$this, 'getDecision'], true);

		$container->alias(Report::class, 'Extrusion.Registry.Report')
			->share('Extrusion.Registry.Report', [$this, 'getReport'], true);

		$container->alias(Message::class, 'Extrusion.Registry.Message')
			->share('Extrusion.Registry.Message', [$this, 'getMessage'], true);
	}

	/**
	 * Get the Extrusion Config.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Config
	 * @since   6.1.6
	 */
	public function getConfig(Container $container): Config
	{
		return new Config();
	}

	/**
	 * Get the Extrusion Scope.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Scope
	 * @since   6.1.6
	 */
	public function getScope(Container $container): Scope
	{
		return new Scope(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Registry.Inventory'),
			$container->get('Extrusion.Registry.Table'),
			$container->get('Extrusion.Registry.Schema'),
			$container->get('Extrusion.Registry.Form'),
			$container->get('Extrusion.Registry.Language'),
			$container->get('Extrusion.Registry.View'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Extrusion.Registry.Harvest'),
			$container->get('Extrusion.Registry.Decision'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Registry.Message'),
			$container->get('Extrusion.Registry.Proposal'),
			$container->get('Extrusion.Registry.Plan'),
			$container->get('Extrusion.Registry.Parsed')
		);
	}

	/**
	 * Get the Source Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Source
	 * @since   6.1.6
	 */
	public function getSource(Container $container): Source
	{
		return new Source();
	}

	/**
	 * Get the Inventory Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Inventory
	 * @since   6.1.6
	 */
	public function getInventory(Container $container): Inventory
	{
		return new Inventory();
	}

	/**
	 * Get the Table Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Table
	 * @since   6.1.6
	 */
	public function getTable(Container $container): Table
	{
		return new Table();
	}

	/**
	 * Get the Schema Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Schema
	 * @since   6.1.6
	 */
	public function getSchema(Container $container): Schema
	{
		return new Schema();
	}

	/**
	 * Get the Form Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Form
	 * @since   6.1.6
	 */
	public function getForm(Container $container): Form
	{
		return new Form();
	}

	/**
	 * Get the Language Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Language
	 * @since   6.1.6
	 */
	public function getLanguage(Container $container): Language
	{
		return new Language();
	}

	/**
	 * Get the View Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  View
	 * @since   6.1.6
	 */
	public function getView(Container $container): View
	{
		return new View();
	}

	/**
	 * Get the Resolved Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resolved
	 * @since   6.1.6
	 */
	public function getResolved(Container $container): Resolved
	{
		return new Resolved();
	}

	/**
	 * Get the Harvest Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Harvest
	 * @since   6.1.7
	 */
	public function getHarvest(Container $container): Harvest
	{
		return new Harvest();
	}

	/**
	 * Get the operation-scoped lexical source cache.
	 *
	 * @param   Container  $container  The service container.
	 *
	 * @return  Parsed  The shared source observations.
	 * @since   6.2.0
	 */
	public function getParsed(Container $container): Parsed
	{
		return new Parsed();
	}

	/**
	 * Get the Decision Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Decision
	 * @since   6.1.7
	 */
	public function getDecision(Container $container): Decision
	{
		return new Decision();
	}

	/**
	 * Get the Message Bus.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Message
	 * @since   6.1.6
	 */
	public function getMessage(Container $container): Message
	{
		return new Message();
	}

	/**
	 * Get the Report Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Report
	 * @since   6.1.6
	 */
	public function getReport(Container $container): Report
	{
		return new Report();
	}

	/**
	 * Get the Proposal Registry.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Proposal
	 * @since   6.2.0
	 */
	public function getProposal(Container $container): Proposal
	{
		return new Proposal();
	}

	/**
	 * Get the complete-operation plan registry.
	 *
	 * @param   Container  $container  The service container.
	 *
	 * @return  Plan  The shared operation plan.
	 * @since   6.2.0
	 */
	public function getPlan(Container $container): Plan
	{
		return new Plan();
	}
}

