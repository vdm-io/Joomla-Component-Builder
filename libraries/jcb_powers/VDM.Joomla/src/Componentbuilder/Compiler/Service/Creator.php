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
use VDM\Joomla\Componentbuilder\Compiler\Creator\Builders;
use VDM\Joomla\Componentbuilder\Compiler\Creator\CustomFieldTypeFile;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Layout;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Creator\SiteFieldData;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldsetString;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldsetXML;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldsetDynamic;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldXML;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldString;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldDynamic;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldAsString;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\Fieldtypeinterface as FieldType;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Creator\Fieldsetinterface as Fieldset;


/**
 * Creator Service Provider
 * 
 * @since 3.2.0
 */
class Creator implements ServiceProviderInterface
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
		$container->alias(Builders::class, 'Compiler.Creator.Builders')
			->share('Compiler.Creator.Builders', [$this, 'getBuilders'], true);

		$container->alias(CustomFieldTypeFile::class, 'Compiler.Creator.Custom.Field.Type.File')
			->share('Compiler.Creator.Custom.Field.Type.File', [$this, 'getCustomFieldTypeFile'], true);

		$container->alias(Layout::class, 'Compiler.Creator.Layout')
			->share('Compiler.Creator.Layout', [$this, 'getLayout'], true);

		$container->alias(Permission::class, 'Compiler.Creator.Permission')
			->share('Compiler.Creator.Permission', [$this, 'getPermission'], true);

		$container->alias(SiteFieldData::class, 'Compiler.Creator.Site.Field.Data')
			->share('Compiler.Creator.Site.Field.Data', [$this, 'getSiteFieldData'], true);

		$container->alias(FieldsetString::class, 'Compiler.Creator.Fieldset.String')
			->share('Compiler.Creator.Fieldset.String', [$this, 'getFieldsetString'], true);

		$container->alias(FieldsetXML::class, 'Compiler.Creator.Fieldset.XML')
			->share('Compiler.Creator.Fieldset.XML', [$this, 'getFieldsetXML'], true);

		$container->alias(FieldsetDynamic::class, 'Compiler.Creator.Fieldset.Dynamic')
			->share('Compiler.Creator.Fieldset.Dynamic', [$this, 'getFieldsetDynamic'], true);

		$container->alias(FieldXML::class, 'Compiler.Creator.Field.XML')
			->share('Compiler.Creator.Field.XML', [$this, 'getFieldXML'], true);

		$container->alias(FieldString::class, 'Compiler.Creator.Field.String')
			->share('Compiler.Creator.Field.String', [$this, 'getFieldString'], true);

		$container->alias(FieldDynamic::class, 'Compiler.Creator.Field.Dynamic')
			->share('Compiler.Creator.Field.Dynamic', [$this, 'getFieldDynamic'], true);

		$container->alias(FieldAsString::class, 'Compiler.Creator.Field.As.String')
			->share('Compiler.Creator.Field.As.String', [$this, 'getFieldAsString'], true);

		$container->alias(FieldType::class, 'Compiler.Creator.Field.Type')
			->share('Compiler.Creator.Field.Type', [$this, 'getFieldType'], true);

		$container->alias(Fieldset::class, 'Compiler.Creator.Fieldset')
			->share('Compiler.Creator.Fieldset', [$this, 'getFieldset'], true);
	}

	/**
	 * Get The Builders Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Builders
	 * @since 3.2.0
	 */
	public function getBuilders(Container $container): Builders
	{
		return new Builders(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Placeholder'),
			$container->get('Compiler.Creator.Layout'),
			$container->get('Compiler.Creator.Site.Field.Data'),
			$container->get('Compiler.Builder.Tags'),
			$container->get('Compiler.Builder.Database.Tables'),
			$container->get('Compiler.Builder.Database.Unique.Keys'),
			$container->get('Compiler.Builder.Database.Keys'),
			$container->get('Compiler.Builder.Database.Unique.Guid'),
			$container->get('Compiler.Builder.List.Join'),
			$container->get('Compiler.Builder.History'),
			$container->get('Compiler.Builder.Alias'),
			$container->get('Compiler.Builder.Title'),
			$container->get('Compiler.Builder.Category.Other.Name'),
			$container->get('Compiler.Builder.Lists'),
			$container->get('Compiler.Builder.Custom.List'),
			$container->get('Compiler.Builder.Field.Relations'),
			$container->get('Compiler.Builder.Hidden.Fields'),
			$container->get('Compiler.Builder.Integer.Fields'),
			$container->get('Compiler.Builder.Dynamic.Fields'),
			$container->get('Compiler.Builder.Main.Text.Field'),
			$container->get('Compiler.Builder.Custom.Field'),
			$container->get('Compiler.Builder.Custom.Field.Links'),
			$container->get('Compiler.Builder.Script.User.Switch'),
			$container->get('Compiler.Builder.Script.Media.Switch'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Category.Code'),
			$container->get('Compiler.Builder.Check.Box'),
			$container->get('Compiler.Builder.Json.String'),
			$container->get('Compiler.Builder.Base.Six.Four'),
			$container->get('Compiler.Builder.Model.Basic.Field'),
			$container->get('Compiler.Builder.Model.Whmcs.Field'),
			$container->get('Compiler.Builder.Model.Medium.Field'),
			$container->get('Compiler.Builder.Model.Expert.Field.Initiator'),
			$container->get('Compiler.Builder.Model.Expert.Field'),
			$container->get('Compiler.Builder.Json.Item'),
			$container->get('Compiler.Builder.Items.Method.List.String'),
			$container->get('Compiler.Builder.Json.Item.Array'),
			$container->get('Compiler.Builder.Items.Method.Eximport.String'),
			$container->get('Compiler.Builder.Selection.Translation'),
			$container->get('Compiler.Builder.Admin.Filter.Type'),
			$container->get('Compiler.Builder.Sort'),
			$container->get('Compiler.Builder.Search'),
			$container->get('Compiler.Builder.Filter'),
			$container->get('Compiler.Builder.Component.Fields')
		);
	}

	/**
	 * Get The CustomFieldTypeFile Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomFieldTypeFile
	 * @since 3.2.0
	 */
	public function getCustomFieldTypeFile(Container $container): CustomFieldTypeFile
	{
		return new CustomFieldTypeFile(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Builder.Site.Field.Data'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Component.Placeholder'),
			$container->get('Utilities.Structure'),
			$container->get('Field.Input.Button'),
			$container->get('Compiler.Builder.Field.Group.Control'),
			$container->get('Compiler.Builder.Extension.Custom.Fields')
		);
	}

	/**
	 * Get The Layout Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Layout
	 * @since 3.2.0
	 */
	public function getLayout(Container $container): Layout
	{
		return new Layout(
			$container->get('Config'),
			$container->get('Compiler.Builder.Order.Zero'),
			$container->get('Compiler.Builder.Tab.Counter'),
			$container->get('Compiler.Builder.Layout'),
			$container->get('Compiler.Builder.Moved.Publishing.Fields'),
			$container->get('Compiler.Builder.New.Publishing.Fields')
		);
	}

	/**
	 * Get The Permission Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Permission
	 * @since 3.2.0
	 */
	public function getPermission(Container $container): Permission
	{
		return new Permission(
			$container->get('Config'),
			$container->get('Compiler.Builder.Permission.Core'),
			$container->get('Compiler.Builder.Permission.Views'),
			$container->get('Compiler.Builder.Permission.Action'),
			$container->get('Compiler.Builder.Permission.Component'),
			$container->get('Compiler.Builder.Permission.Global.Action'),
			$container->get('Compiler.Builder.Permission.Dashboard'),
			$container->get('Utilities.Counter'),
			$container->get('Language')
		);
	}

	/**
	 * Get The SiteFieldData Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteFieldData
	 * @since 3.2.0
	 */
	public function getSiteFieldData(Container $container): SiteFieldData
	{
		return new SiteFieldData(
			$container->get('Config'),
			$container->get('Compiler.Builder.Site.Fields'),
			$container->get('Compiler.Builder.Site.Field.Data')
		);
	}

	/**
	 * Get The FieldsetString Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldsetString
	 * @since 3.2.0
	 */
	public function getFieldsetString(Container $container): FieldsetString
	{
		return new FieldsetString(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Language.Fieldset'),
			$container->get('Event'),
			$container->get('Adminview.Permission'),
			$container->get('Compiler.Creator.Field.Dynamic'),
			$container->get('Compiler.Builder.Field.Names'),
			$container->get('Compiler.Builder.Access.Switch'),
			$container->get('Compiler.Builder.Meta.Data'),
			$container->get('Compiler.Creator.Layout'),
			$container->get('Utilities.Counter')
		);
	}

	/**
	 * Get The FieldsetXML Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldsetXML
	 * @since 3.2.0
	 */
	public function getFieldsetXML(Container $container): FieldsetXML
	{
		return new FieldsetXML(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Language.Fieldset'),
			$container->get('Event'),
			$container->get('Adminview.Permission'),
			$container->get('Compiler.Creator.Field.Dynamic'),
			$container->get('Compiler.Builder.Field.Names'),
			$container->get('Compiler.Builder.Access.Switch'),
			$container->get('Compiler.Builder.Meta.Data'),
			$container->get('Compiler.Creator.Layout'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.Xml')
		);
	}

	/**
	 * Get The FieldsetDynamic Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldsetDynamic
	 * @since 3.2.0
	 */
	public function getFieldsetDynamic(Container $container): FieldsetDynamic
	{
		return new FieldsetDynamic(
			$container->get('Compiler.Creator.Field.As.String')
		);
	}

	/**
	 * Get The FieldXML Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldXML
	 * @since 3.2.0
	 */
	public function getFieldXML(Container $container): FieldXML
	{
		return new FieldXML(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Groups'),
			$container->get('Field.Name'),
			$container->get('Field.Type.Name'),
			$container->get('Field.Attributes'),
			$container->get('Utilities.Xml'),
			$container->get('Compiler.Creator.Custom.Field.Type.File'),
			$container->get('Utilities.Counter')
		);
	}

	/**
	 * Get The FieldString Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldString
	 * @since 3.2.0
	 */
	public function getFieldString(Container $container): FieldString
	{
		return new FieldString(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Field'),
			$container->get('Field.Groups'),
			$container->get('Field.Name'),
			$container->get('Field.Type.Name'),
			$container->get('Field.Attributes'),
			$container->get('Compiler.Creator.Custom.Field.Type.File'),
			$container->get('Utilities.Counter')
		);
	}

	/**
	 * Get The FieldDynamic Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldDynamic
	 * @since 3.2.0
	 */
	public function getFieldDynamic(Container $container): FieldDynamic
	{
		return new FieldDynamic(
			$container->get('Field.Name'),
			$container->get('Field.Type.Name'),
			$container->get('Field.Attributes'),
			$container->get('Field.Groups'),
			$container->get('Compiler.Builder.Field.Names'),
			$container->get('Compiler.Creator.Field.Type'),
			$container->get('Compiler.Creator.Builders'),
			$container->get('Compiler.Creator.Layout')
		);
	}

	/**
	 * Get The FieldAsString Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldAsString
	 * @since 3.2.0
	 */
	public function getFieldAsString(Container $container): FieldAsString
	{
		return new FieldAsString(
			$container->get('Compiler.Creator.Field.Dynamic'),
			$container->get('Utilities.Xml')
		);
	}

	/**
	 * Get The Fieldtypeinterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldType
	 * @since 3.2.0
	 */
	public function getFieldType(Container $container): FieldType
	{
		// check what type of field builder to use
		if ($container->get('Config')->get('field_builder_type', 2) == 1)
		{
			// build field set using string manipulation
			return $container->get('Compiler.Creator.Field.String');
		}
		else
		{
			// build field set with simpleXMLElement class
			return $container->get('Compiler.Creator.Field.XML');
		}
	}

	/**
	 * Get The Fieldsetinterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Fieldset
	 * @since 3.2.0
	 */
	public function getFieldset(Container $container): Fieldset
	{
		// check what type of field builder to use
		if ($container->get('Config')->get('field_builder_type', 2) == 1)
		{
			// build field set using string manipulation
			return $container->get('Compiler.Creator.Fieldset.String');
		}
		else
		{
			// build field set with simpleXMLElement class
			return $container->get('Compiler.Creator.Fieldset.XML');
		}
	}
}

