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
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitchList;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AssetsRules;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Alias;
use VDM\Joomla\Componentbuilder\Compiler\Builder\BaseSixFour;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryCode;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryOtherName;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CheckBox;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ComponentFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Contributors;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomAlias;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomFieldLinks;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomList;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomTabs;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseKeys;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseTables;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueGuid;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUniqueKeys;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DatabaseUninstall;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DoNotEscape;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DynamicFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionCustomFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionsParams;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldGroupControl;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldNames;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldRelations;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FootableScripts;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FrontendParams;
use VDM\Joomla\Componentbuilder\Compiler\Builder\GetAsLookup;
use VDM\Joomla\Componentbuilder\Compiler\Builder\GetModule;
use VDM\Joomla\Componentbuilder\Compiler\Builder\GoogleChart;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HasMenuGlobal;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HasPermissions;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HiddenFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\History;
use VDM\Joomla\Componentbuilder\Compiler\Builder\IntegerFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ItemsMethodEximportString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ItemsMethodListString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItem;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonItemArray;
use VDM\Joomla\Componentbuilder\Compiler\Builder\JsonString;


/**
 * Builder A-J Service Provider
 * 
 * @since 3.2.0
 */
class BuilderAJ implements ServiceProviderInterface
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
		$container->alias(AccessSwitch::class, 'Compiler.Builder.Access.Switch')
			->share('Compiler.Builder.Access.Switch', [$this, 'getAccessSwitch'], true);

		$container->alias(AccessSwitchList::class, 'Compiler.Builder.Access.Switch.List')
			->share('Compiler.Builder.Access.Switch.List', [$this, 'getAccessSwitchList'], true);

		$container->alias(AssetsRules::class, 'Compiler.Builder.Assets.Rules')
			->share('Compiler.Builder.Assets.Rules', [$this, 'getAssetsRules'], true);

		$container->alias(AdminFilterType::class, 'Compiler.Builder.Admin.Filter.Type')
			->share('Compiler.Builder.Admin.Filter.Type', [$this, 'getAdminFilterType'], true);

		$container->alias(Alias::class, 'Compiler.Builder.Alias')
			->share('Compiler.Builder.Alias', [$this, 'getAlias'], true);

		$container->alias(BaseSixFour::class, 'Compiler.Builder.Base.Six.Four')
			->share('Compiler.Builder.Base.Six.Four', [$this, 'getBaseSixFour'], true);

		$container->alias(Category::class, 'Compiler.Builder.Category')
			->share('Compiler.Builder.Category', [$this, 'getCategory'], true);

		$container->alias(CategoryCode::class, 'Compiler.Builder.Category.Code')
			->share('Compiler.Builder.Category.Code', [$this, 'getCategoryCode'], true);

		$container->alias(CategoryOtherName::class, 'Compiler.Builder.Category.Other.Name')
			->share('Compiler.Builder.Category.Other.Name', [$this, 'getCategoryOtherName'], true);

		$container->alias(CheckBox::class, 'Compiler.Builder.Check.Box')
			->share('Compiler.Builder.Check.Box', [$this, 'getCheckBox'], true);

		$container->alias(ComponentFields::class, 'Compiler.Builder.Component.Fields')
			->share('Compiler.Builder.Component.Fields', [$this, 'getComponentFields'], true);

		$container->alias(ConfigFieldsets::class, 'Compiler.Builder.Config.Fieldsets')
			->share('Compiler.Builder.Config.Fieldsets', [$this, 'getConfigFieldsets'], true);

		$container->alias(ConfigFieldsetsCustomfield::class, 'Compiler.Builder.Config.Fieldsets.Customfield')
			->share('Compiler.Builder.Config.Fieldsets.Customfield', [$this, 'getConfigFieldsetsCustomfield'], true);

		$container->alias(ContentMulti::class, 'Compiler.Builder.Content.Multi')
			->share('Compiler.Builder.Content.Multi', [$this, 'getContentMulti'], true);

		$container->alias(ContentOne::class, 'Compiler.Builder.Content.One')
			->share('Compiler.Builder.Content.One', [$this, 'getContentOne'], true);

		$container->alias(Contributors::class, 'Compiler.Builder.Contributors')
			->share('Compiler.Builder.Contributors', [$this, 'getContributors'], true);

		$container->alias(CustomAlias::class, 'Compiler.Builder.Custom.Alias')
			->share('Compiler.Builder.Custom.Alias', [$this, 'getCustomAlias'], true);

		$container->alias(CustomField::class, 'Compiler.Builder.Custom.Field')
			->share('Compiler.Builder.Custom.Field', [$this, 'getCustomField'], true);

		$container->alias(CustomFieldLinks::class, 'Compiler.Builder.Custom.Field.Links')
			->share('Compiler.Builder.Custom.Field.Links', [$this, 'getCustomFieldLinks'], true);

		$container->alias(CustomList::class, 'Compiler.Builder.Custom.List')
			->share('Compiler.Builder.Custom.List', [$this, 'getCustomList'], true);

		$container->alias(CustomTabs::class, 'Compiler.Builder.Custom.Tabs')
			->share('Compiler.Builder.Custom.Tabs', [$this, 'getCustomTabs'], true);

		$container->alias(DatabaseKeys::class, 'Compiler.Builder.Database.Keys')
			->share('Compiler.Builder.Database.Keys', [$this, 'getDatabaseKeys'], true);

		$container->alias(DatabaseTables::class, 'Compiler.Builder.Database.Tables')
			->share('Compiler.Builder.Database.Tables', [$this, 'getDatabaseTables'], true);

		$container->alias(DatabaseUniqueGuid::class, 'Compiler.Builder.Database.Unique.Guid')
			->share('Compiler.Builder.Database.Unique.Guid', [$this, 'getDatabaseUniqueGuid'], true);

		$container->alias(DatabaseUniqueKeys::class, 'Compiler.Builder.Database.Unique.Keys')
			->share('Compiler.Builder.Database.Unique.Keys', [$this, 'getDatabaseUniqueKeys'], true);

		$container->alias(DatabaseUninstall::class, 'Compiler.Builder.Database.Uninstall')
			->share('Compiler.Builder.Database.Uninstall', [$this, 'getDatabaseUninstall'], true);

		$container->alias(DoNotEscape::class, 'Compiler.Builder.Do.Not.Escape')
			->share('Compiler.Builder.Do.Not.Escape', [$this, 'getDoNotEscape'], true);

		$container->alias(DynamicFields::class, 'Compiler.Builder.Dynamic.Fields')
			->share('Compiler.Builder.Dynamic.Fields', [$this, 'getDynamicFields'], true);

		$container->alias(ExtensionCustomFields::class, 'Compiler.Builder.Extension.Custom.Fields')
			->share('Compiler.Builder.Extension.Custom.Fields', [$this, 'getExtensionCustomFields'], true);

		$container->alias(ExtensionsParams::class, 'Compiler.Builder.Extensions.Params')
			->share('Compiler.Builder.Extensions.Params', [$this, 'getExtensionsParams'], true);

		$container->alias(FieldGroupControl::class, 'Compiler.Builder.Field.Group.Control')
			->share('Compiler.Builder.Field.Group.Control', [$this, 'getFieldGroupControl'], true);

		$container->alias(FieldNames::class, 'Compiler.Builder.Field.Names')
			->share('Compiler.Builder.Field.Names', [$this, 'getFieldNames'], true);

		$container->alias(FieldRelations::class, 'Compiler.Builder.Field.Relations')
			->share('Compiler.Builder.Field.Relations', [$this, 'getFieldRelations'], true);

		$container->alias(Filter::class, 'Compiler.Builder.Filter')
			->share('Compiler.Builder.Filter', [$this, 'getFilter'], true);

		$container->alias(FootableScripts::class, 'Compiler.Builder.Footable.Scripts')
			->share('Compiler.Builder.Footable.Scripts', [$this, 'getFootableScripts'], true);

		$container->alias(FrontendParams::class, 'Compiler.Builder.Frontend.Params')
			->share('Compiler.Builder.Frontend.Params', [$this, 'getFrontendParams'], true);

		$container->alias(GetAsLookup::class, 'Compiler.Builder.Get.As.Lookup')
			->share('Compiler.Builder.Get.As.Lookup', [$this, 'getGetAsLookup'], true);

		$container->alias(GetModule::class, 'Compiler.Builder.Get.Module')
			->share('Compiler.Builder.Get.Module', [$this, 'getGetModule'], true);

		$container->alias(GoogleChart::class, 'Compiler.Builder.Google.Chart')
			->share('Compiler.Builder.Google.Chart', [$this, 'getGoogleChart'], true);

		$container->alias(HasMenuGlobal::class, 'Compiler.Builder.Has.Menu.Global')
			->share('Compiler.Builder.Has.Menu.Global', [$this, 'getHasMenuGlobal'], true);

		$container->alias(HasPermissions::class, 'Compiler.Builder.Has.Permissions')
			->share('Compiler.Builder.Has.Permissions', [$this, 'getHasPermissions'], true);

		$container->alias(HiddenFields::class, 'Compiler.Builder.Hidden.Fields')
			->share('Compiler.Builder.Hidden.Fields', [$this, 'getHiddenFields'], true);

		$container->alias(History::class, 'Compiler.Builder.History')
			->share('Compiler.Builder.History', [$this, 'getHistory'], true);

		$container->alias(IntegerFields::class, 'Compiler.Builder.Integer.Fields')
			->share('Compiler.Builder.Integer.Fields', [$this, 'getIntegerFields'], true);

		$container->alias(ItemsMethodEximportString::class, 'Compiler.Builder.Items.Method.Eximport.String')
			->share('Compiler.Builder.Items.Method.Eximport.String', [$this, 'getItemsMethodEximportString'], true);

		$container->alias(ItemsMethodListString::class, 'Compiler.Builder.Items.Method.List.String')
			->share('Compiler.Builder.Items.Method.List.String', [$this, 'getItemsMethodListString'], true);

		$container->alias(JsonItem::class, 'Compiler.Builder.Json.Item')
			->share('Compiler.Builder.Json.Item', [$this, 'getJsonItem'], true);

		$container->alias(JsonItemArray::class, 'Compiler.Builder.Json.Item.Array')
			->share('Compiler.Builder.Json.Item.Array', [$this, 'getJsonItemArray'], true);

		$container->alias(JsonString::class, 'Compiler.Builder.Json.String')
			->share('Compiler.Builder.Json.String', [$this, 'getJsonString'], true);
	}

	/**
	 * Get The AccessSwitch Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AccessSwitch
	 * @since 3.2.0
	 */
	public function getAccessSwitch(Container $container): AccessSwitch
	{
		return new AccessSwitch();
	}

	/**
	 * Get The AccessSwitchList Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AccessSwitchList
	 * @since 3.2.0
	 */
	public function getAccessSwitchList(Container $container): AccessSwitchList
	{
		return new AccessSwitchList();
	}

	/**
	 * Get The AssetsRules Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AssetsRules
	 * @since 3.2.0
	 */
	public function getAssetsRules(Container $container): AssetsRules
	{
		return new AssetsRules();
	}

	/**
	 * Get The AdminFilterType Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminFilterType
	 * @since 3.2.0
	 */
	public function getAdminFilterType(Container $container): AdminFilterType
	{
		return new AdminFilterType();
	}

	/**
	 * Get The Alias Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Alias
	 * @since 3.2.0
	 */
	public function getAlias(Container $container): Alias
	{
		return new Alias();
	}

	/**
	 * Get The BaseSixFour Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  BaseSixFour
	 * @since 3.2.0
	 */
	public function getBaseSixFour(Container $container): BaseSixFour
	{
		return new BaseSixFour();
	}

	/**
	 * Get The Category Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Category
	 * @since 3.2.0
	 */
	public function getCategory(Container $container): Category
	{
		return new Category();
	}

	/**
	 * Get The CategoryCode Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CategoryCode
	 * @since 3.2.0
	 */
	public function getCategoryCode(Container $container): CategoryCode
	{
		return new CategoryCode();
	}

	/**
	 * Get The CategoryOtherName Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CategoryOtherName
	 * @since 3.2.0
	 */
	public function getCategoryOtherName(Container $container): CategoryOtherName
	{
		return new CategoryOtherName();
	}

	/**
	 * Get The CheckBox Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CheckBox
	 * @since 3.2.0
	 */
	public function getCheckBox(Container $container): CheckBox
	{
		return new CheckBox();
	}

	/**
	 * Get The ComponentFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ComponentFields
	 * @since 3.2.0
	 */
	public function getComponentFields(Container $container): ComponentFields
	{
		return new ComponentFields();
	}

	/**
	 * Get The ConfigFieldsets Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ConfigFieldsets
	 * @since 3.2.0
	 */
	public function getConfigFieldsets(Container $container): ConfigFieldsets
	{
		return new ConfigFieldsets();
	}

	/**
	 * Get The ConfigFieldsetsCustomfield Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ConfigFieldsetsCustomfield
	 * @since 3.2.0
	 */
	public function getConfigFieldsetsCustomfield(Container $container): ConfigFieldsetsCustomfield
	{
		return new ConfigFieldsetsCustomfield();
	}

	/**
	 * Get The ContentMulti Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ContentMulti
	 * @since 3.2.0
	 */
	public function getContentMulti(Container $container): ContentMulti
	{
		return new ContentMulti();
	}

	/**
	 * Get The ContentOne Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ContentOne
	 * @since 3.2.0
	 */
	public function getContentOne(Container $container): ContentOne
	{
		return new ContentOne();
	}

	/**
	 * Get The Contributors Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Contributors
	 * @since 3.2.0
	 */
	public function getContributors(Container $container): Contributors
	{
		return new Contributors();
	}

	/**
	 * Get The CustomAlias Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomAlias
	 * @since 3.2.0
	 */
	public function getCustomAlias(Container $container): CustomAlias
	{
		return new CustomAlias();
	}

	/**
	 * Get The CustomField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomField
	 * @since 3.2.0
	 */
	public function getCustomField(Container $container): CustomField
	{
		return new CustomField();
	}

	/**
	 * Get The CustomFieldLinks Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomFieldLinks
	 * @since 3.2.0
	 */
	public function getCustomFieldLinks(Container $container): CustomFieldLinks
	{
		return new CustomFieldLinks();
	}

	/**
	 * Get The CustomList Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomList
	 * @since 3.2.0
	 */
	public function getCustomList(Container $container): CustomList
	{
		return new CustomList();
	}

	/**
	 * Get The CustomTabs Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomTabs
	 * @since 3.2.0
	 */
	public function getCustomTabs(Container $container): CustomTabs
	{
		return new CustomTabs();
	}

	/**
	 * Get The DatabaseKeys Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DatabaseKeys
	 * @since 3.2.0
	 */
	public function getDatabaseKeys(Container $container): DatabaseKeys
	{
		return new DatabaseKeys();
	}

	/**
	 * Get The DatabaseTables Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DatabaseTables
	 * @since 3.2.0
	 */
	public function getDatabaseTables(Container $container): DatabaseTables
	{
		return new DatabaseTables();
	}

	/**
	 * Get The DatabaseUniqueGuid Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DatabaseUniqueGuid
	 * @since 3.2.0
	 */
	public function getDatabaseUniqueGuid(Container $container): DatabaseUniqueGuid
	{
		return new DatabaseUniqueGuid();
	}

	/**
	 * Get The DatabaseUniqueKeys Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DatabaseUniqueKeys
	 * @since 3.2.0
	 */
	public function getDatabaseUniqueKeys(Container $container): DatabaseUniqueKeys
	{
		return new DatabaseUniqueKeys();
	}

	/**
	 * Get The DatabaseUninstall Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DatabaseUninstall
	 * @since 3.2.0
	 */
	public function getDatabaseUninstall(Container $container): DatabaseUninstall
	{
		return new DatabaseUninstall();
	}

	/**
	 * Get The DoNotEscape Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DoNotEscape
	 * @since 3.2.0
	 */
	public function getDoNotEscape(Container $container): DoNotEscape
	{
		return new DoNotEscape();
	}

	/**
	 * Get The DynamicFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicFields
	 * @since 3.2.0
	 */
	public function getDynamicFields(Container $container): DynamicFields
	{
		return new DynamicFields();
	}

	/**
	 * Get The ExtensionCustomFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ExtensionCustomFields
	 * @since 3.2.0
	 */
	public function getExtensionCustomFields(Container $container): ExtensionCustomFields
	{
		return new ExtensionCustomFields();
	}

	/**
	 * Get The ExtensionsParams Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ExtensionsParams
	 * @since 3.2.0
	 */
	public function getExtensionsParams(Container $container): ExtensionsParams
	{
		return new ExtensionsParams();
	}

	/**
	 * Get The FieldGroupControl Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldGroupControl
	 * @since 3.2.0
	 */
	public function getFieldGroupControl(Container $container): FieldGroupControl
	{
		return new FieldGroupControl();
	}

	/**
	 * Get The FieldNames Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldNames
	 * @since 3.2.0
	 */
	public function getFieldNames(Container $container): FieldNames
	{
		return new FieldNames();
	}

	/**
	 * Get The FieldRelations Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FieldRelations
	 * @since 3.2.0
	 */
	public function getFieldRelations(Container $container): FieldRelations
	{
		return new FieldRelations();
	}

	/**
	 * Get The Filter Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Filter
	 * @since 3.2.0
	 */
	public function getFilter(Container $container): Filter
	{
		return new Filter();
	}

	/**
	 * Get The FootableScripts Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FootableScripts
	 * @since 3.2.0
	 */
	public function getFootableScripts(Container $container): FootableScripts
	{
		return new FootableScripts();
	}

	/**
	 * Get The FrontendParams Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FrontendParams
	 * @since 3.2.0
	 */
	public function getFrontendParams(Container $container): FrontendParams
	{
		return new FrontendParams();
	}

	/**
	 * Get The GetAsLookup Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GetAsLookup
	 * @since 3.2.0
	 */
	public function getGetAsLookup(Container $container): GetAsLookup
	{
		return new GetAsLookup();
	}

	/**
	 * Get The GetModule Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GetModule
	 * @since 3.2.0
	 */
	public function getGetModule(Container $container): GetModule
	{
		return new GetModule();
	}

	/**
	 * Get The GoogleChart Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  GoogleChart
	 * @since 3.2.0
	 */
	public function getGoogleChart(Container $container): GoogleChart
	{
		return new GoogleChart();
	}

	/**
	 * Get The HasMenuGlobal Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  HasMenuGlobal
	 * @since 3.2.0
	 */
	public function getHasMenuGlobal(Container $container): HasMenuGlobal
	{
		return new HasMenuGlobal();
	}

	/**
	 * Get The HasPermissions Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  HasPermissions
	 * @since 3.2.0
	 */
	public function getHasPermissions(Container $container): HasPermissions
	{
		return new HasPermissions();
	}

	/**
	 * Get The HiddenFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  HiddenFields
	 * @since 3.2.0
	 */
	public function getHiddenFields(Container $container): HiddenFields
	{
		return new HiddenFields();
	}

	/**
	 * Get The History Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  History
	 * @since 3.2.0
	 */
	public function getHistory(Container $container): History
	{
		return new History();
	}

	/**
	 * Get The IntegerFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  IntegerFields
	 * @since 3.2.0
	 */
	public function getIntegerFields(Container $container): IntegerFields
	{
		return new IntegerFields();
	}

	/**
	 * Get The ItemsMethodEximportString Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemsMethodEximportString
	 * @since 3.2.0
	 */
	public function getItemsMethodEximportString(Container $container): ItemsMethodEximportString
	{
		return new ItemsMethodEximportString();
	}

	/**
	 * Get The ItemsMethodListString Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemsMethodListString
	 * @since 3.2.0
	 */
	public function getItemsMethodListString(Container $container): ItemsMethodListString
	{
		return new ItemsMethodListString();
	}

	/**
	 * Get The JsonItem Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JsonItem
	 * @since 3.2.0
	 */
	public function getJsonItem(Container $container): JsonItem
	{
		return new JsonItem();
	}

	/**
	 * Get The JsonItemArray Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JsonItemArray
	 * @since 3.2.0
	 */
	public function getJsonItemArray(Container $container): JsonItemArray
	{
		return new JsonItemArray();
	}

	/**
	 * Get The JsonString Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  JsonString
	 * @since 3.2.0
	 */
	public function getJsonString(Container $container): JsonString
	{
		return new JsonString();
	}
}

