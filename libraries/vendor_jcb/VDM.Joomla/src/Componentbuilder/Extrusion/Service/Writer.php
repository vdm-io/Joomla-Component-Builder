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
use VDM\Joomla\Componentbuilder\Extrusion\Writer\AdminFields;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\AdminFieldsConditions;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\AdminView;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\Component;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\ComponentAdminViews;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\ComponentCustomAdminViews;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\ComponentSiteViews;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\CustomAdminView;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\DynamicGet;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\SiteView;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\Dispatcher;
use VDM\Joomla\Componentbuilder\Extrusion\Writer\Field;


/**
 * Extrusion Writer Service Provider
 * 
 * Each writer receives the shared JCB data item service, which is what resolves
 * insert against update from the GUID and applies the declared storage encoding.
 * 
 * @since 6.1.6
 */
class Writer implements ServiceProviderInterface
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
		$container->alias(Field::class, 'Extrusion.Writer.Field')
			->share('Extrusion.Writer.Field', [$this, 'getField'], true);

		$container->alias(AdminView::class, 'Extrusion.Writer.AdminView')
			->share('Extrusion.Writer.AdminView', [$this, 'getAdminView'], true);

		$container->alias(AdminFields::class, 'Extrusion.Writer.AdminFields')
			->share('Extrusion.Writer.AdminFields', [$this, 'getAdminFields'], true);

		$container->alias(AdminFieldsConditions::class, 'Extrusion.Writer.AdminFieldsConditions')
			->share('Extrusion.Writer.AdminFieldsConditions', [$this, 'getAdminFieldsConditions'], true);

		$container->alias(ComponentAdminViews::class, 'Extrusion.Writer.ComponentAdminViews')
			->share('Extrusion.Writer.ComponentAdminViews', [$this, 'getComponentAdminViews'], true);

		$container->alias(Component::class, 'Extrusion.Writer.Component')
			->share('Extrusion.Writer.Component', [$this, 'getComponent'], true);

		$container->alias(SiteView::class, 'Extrusion.Writer.SiteView')
			->share('Extrusion.Writer.SiteView', [$this, 'getSiteView'], true);

		$container->alias(DynamicGet::class, 'Extrusion.Writer.DynamicGet')
			->share('Extrusion.Writer.DynamicGet', [$this, 'getDynamicGet'], true);

		$container->alias(CustomAdminView::class, 'Extrusion.Writer.CustomAdminView')
			->share('Extrusion.Writer.CustomAdminView', [$this, 'getCustomAdminView'], true);

		$container->alias(ComponentCustomAdminViews::class, 'Extrusion.Writer.ComponentCustomAdminViews')
			->share('Extrusion.Writer.ComponentCustomAdminViews', [$this, 'getComponentCustomAdminViews'], true);

		$container->alias(ComponentSiteViews::class, 'Extrusion.Writer.ComponentSiteViews')
			->share('Extrusion.Writer.ComponentSiteViews', [$this, 'getComponentSiteViews'], true);

		$container->alias(Dispatcher::class, 'Extrusion.Writer.Dispatcher')
			->share('Extrusion.Writer.Dispatcher', [$this, 'getDispatcher'], true);
	}

	/**
	 * Get the Field Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Field
	 * @since   6.1.6
	 */
	public function getField(Container $container): Field
	{
		return new Field(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Resolver.Record'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Pairing'),
			$container->get('Extrusion.Resolver.Placeholder')
		);
	}

	/**
	 * Get the Admin View Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminView
	 * @since   6.1.6
	 */
	public function getAdminView(Container $container): AdminView
	{
		return new AdminView(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Pairing'),
			$container->get('Extrusion.Resolver.Actions'),
			$container->get('Extrusion.Powers.Resolver.Placeholders'),
			$container->get('Extrusion.Resolver.Placeholder')
		);
	}

	/**
	 * Get the Admin Fields Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminFields
	 * @since   6.1.6
	 */
	public function getAdminFields(Container $container): AdminFields
	{
		return new AdminFields(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Load'),
			$container->get('Extrusion.Registry.Form')
		);
	}

	/**
	 * Get the Admin Fields Conditions Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminFieldsConditions
	 * @since   6.1.6
	 */
	public function getAdminFieldsConditions(Container $container): AdminFieldsConditions
	{
		return new AdminFieldsConditions(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.Source')
		);
	}

	/**
	 * Get the Site View Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteView
	 * @since   6.1.6
	 */
	public function getSiteView(Container $container): SiteView
	{
		return new SiteView(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.View'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Pairing'),
			$container->get('Extrusion.Resolver.Placeholder')
		);
	}

	/**
	 * Get the Dynamic Get Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicGet
	 * @since   6.1.8
	 */
	public function getDynamicGet(Container $container): DynamicGet
	{
		return new DynamicGet(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.View'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Source')
		);
	}

	/**
	 * Get the Custom Admin View Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomAdminView
	 * @since   6.1.8
	 */
	public function getCustomAdminView(Container $container): CustomAdminView
	{
		return new CustomAdminView(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.View'),
			$container->get('Extrusion.Resolver.Guid'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Pairing'),
			$container->get('Extrusion.Resolver.Text'),
			$container->get('Extrusion.Resolver.Placeholder')
		);
	}

	/**
	 * Get the Component Custom Admin Views Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ComponentCustomAdminViews
	 * @since   6.1.8
	 */
	public function getComponentCustomAdminViews(Container $container): ComponentCustomAdminViews
	{
		return new ComponentCustomAdminViews(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Load')
		);
	}

	/**
	 * Get the Component Site Views Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ComponentSiteViews
	 * @since   6.1.6
	 */
	public function getComponentSiteViews(Container $container): ComponentSiteViews
	{
		return new ComponentSiteViews(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Load')
		);
	}

	/**
	 * Get the Component Details Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Component
	 * @since   6.1.6
	 */
	public function getComponent(Container $container): Component
	{
		return new Component(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Extrusion.Resolver.Language'),
			$container->get('Extrusion.Resolver.Guid')
		);
	}

	/**
	 * Get the Component Admin Views Writer.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ComponentAdminViews
	 * @since   6.1.6
	 */
	public function getComponentAdminViews(Container $container): ComponentAdminViews
	{
		return new ComponentAdminViews(
			$container->get('Extrusion.Config'),
			$container->get('Extrusion.Registry.Resolved'),
			$container->get('Data.Item'),
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Resolver.Delta'),
			$container->get('Extrusion.Registry.Source'),
			$container->get('Load')
		);
	}

	/**
	 * Get the Writer Dispatcher.
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
			$container->get('Extrusion.Registry.Report'),
			$container->get('Extrusion.Writer.Field'),
			$container->get('Extrusion.Writer.AdminView'),
			$container->get('Extrusion.Writer.AdminFields'),
			$container->get('Extrusion.Writer.AdminFieldsConditions'),
			$container->get('Extrusion.Writer.ComponentAdminViews'),
			$container->get('Extrusion.Writer.Component'),
			$container->get('Extrusion.Writer.SiteView'),
			$container->get('Extrusion.Writer.ComponentSiteViews'),
			$container->get('Extrusion.Writer.DynamicGet'),
			$container->get('Extrusion.Writer.CustomAdminView'),
			$container->get('Extrusion.Writer.ComponentCustomAdminViews')
		);
	}
}

