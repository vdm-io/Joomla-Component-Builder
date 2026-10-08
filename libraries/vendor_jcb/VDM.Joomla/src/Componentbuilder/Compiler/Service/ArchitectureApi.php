<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    1st September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller\GetModel as ControllerGetModel;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller\RecordId as ControllerRecordId;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller\AllowView as ControllerAllowView;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller\AllowDelete as ControllerAllowDelete;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Controller\DisplayList as ControllerDisplayList;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View\Fields as ViewFields;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View\FieldPermissions as ViewFieldPermissions;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View\PrepareItem as ViewPrepareItem;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\View\Relationships as ViewRelationships;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Serializer\Relations as SerializerRelations;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Plugin\Routes as PluginRoutes;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Resources;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\GetModel as DynamicGetModel;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\AllowView as DynamicAllowView;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\Expectations as DynamicExpectations;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\PrepareItem as DynamicPrepareItem;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\Meta as DynamicMeta;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\Resource as DynamicResource;


/**
 * Architecture Api Service Provider
 * 
 * The renderers of the API area of a component. Their output is the same for
 * every Joomla target that has an API, so none of them is version selected.
 * 
 * @since 6.1.7
 */
class ArchitectureApi implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 6.1.7
	 */
	public function register(Container $container)
	{
		$container->alias(ControllerGetModel::class, 'Architecture.Api.Controller.GetModel')
			->share('Architecture.Api.Controller.GetModel', [$this, 'getControllerGetModel'], true);

		$container->alias(ControllerRecordId::class, 'Architecture.Api.Controller.RecordId')
			->share('Architecture.Api.Controller.RecordId', [$this, 'getControllerRecordId'], true);

		$container->alias(ControllerAllowView::class, 'Architecture.Api.Controller.AllowView')
			->share('Architecture.Api.Controller.AllowView', [$this, 'getControllerAllowView'], true);

		$container->alias(ControllerAllowDelete::class, 'Architecture.Api.Controller.AllowDelete')
			->share('Architecture.Api.Controller.AllowDelete', [$this, 'getControllerAllowDelete'], true);

		$container->alias(ControllerDisplayList::class, 'Architecture.Api.Controller.DisplayList')
			->share('Architecture.Api.Controller.DisplayList', [$this, 'getControllerDisplayList'], true);

		$container->alias(ViewFields::class, 'Architecture.Api.View.Fields')
			->share('Architecture.Api.View.Fields', [$this, 'getViewFields'], true);

		$container->alias(ViewFieldPermissions::class, 'Architecture.Api.View.FieldPermissions')
			->share('Architecture.Api.View.FieldPermissions', [$this, 'getViewFieldPermissions'], true);

		$container->alias(ViewPrepareItem::class, 'Architecture.Api.View.PrepareItem')
			->share('Architecture.Api.View.PrepareItem', [$this, 'getViewPrepareItem'], true);

		$container->alias(ViewRelationships::class, 'Architecture.Api.View.Relationships')
			->share('Architecture.Api.View.Relationships', [$this, 'getViewRelationships'], true);

		$container->alias(SerializerRelations::class, 'Architecture.Api.Serializer.Relations')
			->share('Architecture.Api.Serializer.Relations', [$this, 'getSerializerRelations'], true);

		$container->alias(PluginRoutes::class, 'Architecture.Api.Plugin.Routes')
			->share('Architecture.Api.Plugin.Routes', [$this, 'getPluginRoutes'], true);

		$container->alias(Resources::class, 'Architecture.Api.Resources')
			->share('Architecture.Api.Resources', [$this, 'getResources'], true);

		$container->alias(DynamicGetModel::class, 'Architecture.Api.Dynamic.GetModel')
			->share('Architecture.Api.Dynamic.GetModel', [$this, 'getDynamicGetModel'], true);

		$container->alias(DynamicAllowView::class, 'Architecture.Api.Dynamic.AllowView')
			->share('Architecture.Api.Dynamic.AllowView', [$this, 'getDynamicAllowView'], true);

		$container->alias(DynamicExpectations::class, 'Architecture.Api.Dynamic.Expectations')
			->share('Architecture.Api.Dynamic.Expectations', [$this, 'getDynamicExpectations'], true);

		$container->alias(DynamicPrepareItem::class, 'Architecture.Api.Dynamic.PrepareItem')
			->share('Architecture.Api.Dynamic.PrepareItem', [$this, 'getDynamicPrepareItem'], true);

		$container->alias(DynamicMeta::class, 'Architecture.Api.Dynamic.Meta')
			->share('Architecture.Api.Dynamic.Meta', [$this, 'getDynamicMeta'], true);

		$container->alias(DynamicResource::class, 'Architecture.Api.Dynamic.Resource')
			->share('Architecture.Api.Dynamic.Resource', [$this, 'getDynamicResource'], true);
	}

	/**
	 * Get The Api Controller GetModel Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ControllerGetModel
	 * @since 6.1.7
	 */
	public function getControllerGetModel(Container $container): ControllerGetModel
	{
		return new ControllerGetModel();
	}

	/**
	 * Get The Api Controller RecordId Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ControllerRecordId
	 * @since 6.1.7
	 */
	public function getControllerRecordId(Container $container): ControllerRecordId
	{
		return new ControllerRecordId(
			$container->get('Compiler.Builder.Database.Unique.Keys'),
			$container->get('Compiler.Builder.Database.Unique.Guid')
		);
	}

	/**
	 * Get The Api Controller AllowView Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ControllerAllowView
	 * @since 6.1.7
	 */
	public function getControllerAllowView(Container $container): ControllerAllowView
	{
		return new ControllerAllowView(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Compiler.Builder.Access.Switch')
		);
	}

	/**
	 * Get The Api Controller AllowDelete Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ControllerAllowDelete
	 * @since 6.1.7
	 */
	public function getControllerAllowDelete(Container $container): ControllerAllowDelete
	{
		return new ControllerAllowDelete(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The Api Controller DisplayList Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ControllerDisplayList
	 * @since 6.1.7
	 */
	public function getControllerDisplayList(Container $container): ControllerDisplayList
	{
		return new ControllerDisplayList(
			$container->get('Compiler.Builder.Filter'),
			$container->get('Compiler.Builder.Sort'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Access.Switch'),
			$container->get('Compiler.Builder.Field.Names')
		);
	}

	/**
	 * Get The Api View Fields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewFields
	 * @since 6.1.7
	 */
	public function getViewFields(Container $container): ViewFields
	{
		return new ViewFields(
			$container->get('Config'),
			$container->get('Compiler.Builder.Component.Fields'),
			$container->get('Compiler.Builder.Access.Switch'),
			$container->get('Compiler.Builder.Meta.Data'),
			$container->get('Compiler.Builder.Field.Names')
		);
	}

	/**
	 * Get The Api View FieldPermissions Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewFieldPermissions
	 * @since 6.1.7
	 */
	public function getViewFieldPermissions(Container $container): ViewFieldPermissions
	{
		return new ViewFieldPermissions(
			$container->get('Config'),
			$container->get('Compiler.Builder.Permission.Fields')
		);
	}

	/**
	 * Get The Api View PrepareItem Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewPrepareItem
	 * @since 6.1.7
	 */
	public function getViewPrepareItem(Container $container): ViewPrepareItem
	{
		return new ViewPrepareItem(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Json.String'),
			$container->get('Compiler.Builder.Json.Item'),
			$container->get('Compiler.Builder.Json.Item.Array'),
			$container->get('Compiler.Builder.Base.Six.Four'),
			$container->get('Compiler.Builder.Model.Basic.Field'),
			$container->get('Compiler.Builder.Model.Medium.Field'),
			$container->get('Compiler.Builder.Model.Whmcs.Field'),
			$container->get('Compiler.Builder.Items.Method.List.String'),
			$container->get('Compiler.Builder.Tags')
		);
	}

	/**
	 * Get The Api View Relationships Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewRelationships
	 * @since 6.1.7
	 */
	public function getViewRelationships(Container $container): ViewRelationships
	{
		return new ViewRelationships(
			$container->get('Config'),
			$container->get('Compiler.Builder.Component.Fields'),
			$container->get('Compiler.Builder.Field.Names'),
			$container->get('Compiler.Builder.Tags'),
			$container->get('Component')
		);
	}

	/**
	 * Get The Api Serializer Relations Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SerializerRelations
	 * @since 6.1.7
	 */
	public function getSerializerRelations(Container $container): SerializerRelations
	{
		return new SerializerRelations(
			$container->get('Architecture.Api.View.Relationships')
		);
	}

	/**
	 * Get The Api Plugin Routes Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PluginRoutes
	 * @since 6.1.7
	 */
	public function getPluginRoutes(Container $container): PluginRoutes
	{
		return new PluginRoutes(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Architecture.Api.Resources'),
			$container->get('Architecture.Api.Controller.RecordId')
		);
	}

	/**
	 * Get The Api Resources Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Resources
	 * @since 6.1.7
	 */
	public function getResources(Container $container): Resources
	{
		return new Resources(
			$container->get('Config')
		);
	}

	/**
	 * Get The Api Dynamic GetModel Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicGetModel
	 * @since 6.1.7
	 */
	public function getDynamicGetModel(Container $container): DynamicGetModel
	{
		return new DynamicGetModel();
	}

	/**
	 * Get The Api Dynamic AllowView Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicAllowView
	 * @since 6.1.7
	 */
	public function getDynamicAllowView(Container $container): DynamicAllowView
	{
		return new DynamicAllowView(
			$container->get('Config')
		);
	}

	/**
	 * Get The Api Dynamic Expectations Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicExpectations
	 * @since 6.1.7
	 */
	public function getDynamicExpectations(Container $container): DynamicExpectations
	{
		return new DynamicExpectations();
	}

	/**
	 * Get The Api Dynamic PrepareItem Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicPrepareItem
	 * @since 6.1.7
	 */
	public function getDynamicPrepareItem(Container $container): DynamicPrepareItem
	{
		return new DynamicPrepareItem(
			$container->get('Dynamicget.JoinStructure')
		);
	}

	/**
	 * Get The Api Dynamic Meta Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicMeta
	 * @since 6.1.7
	 */
	public function getDynamicMeta(Container $container): DynamicMeta
	{
		return new DynamicMeta();
	}

	/**
	 * Get The Api Dynamic Resource Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicResource
	 * @since 6.1.7
	 */
	public function getDynamicResource(Container $container): DynamicResource
	{
		return new DynamicResource(
			$container->get('Architecture.Api.Resources'),
			$container->get('Component'),
			$container->get('Header'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Architecture.Api.Dynamic.GetModel'),
			$container->get('Architecture.Api.Dynamic.AllowView'),
			$container->get('Architecture.Api.Dynamic.Expectations'),
			$container->get('Architecture.Api.Dynamic.PrepareItem'),
			$container->get('Architecture.Api.Dynamic.Meta')
		);
	}
}

