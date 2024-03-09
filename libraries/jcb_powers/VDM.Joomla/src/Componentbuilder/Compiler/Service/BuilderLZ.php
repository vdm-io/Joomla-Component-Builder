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
use VDM\Joomla\Componentbuilder\Compiler\Builder\LanguageMessages;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Layout;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LayoutData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LibraryManager;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListFieldClass;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListHeadOverride;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListJoin;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Lists;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MainTextField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MetaData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelBasicField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertFieldInitiator;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelMediumField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelWhmcsField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MovedPublishingFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MysqlTableSetting;
use VDM\Joomla\Componentbuilder\Compiler\Builder\NewPublishingFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OrderZero;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherFilter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherGroup;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherJoin;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherOrder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherQuery;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherWhere;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionAction;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionComponent;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionCore;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionDashboard;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionGlobalAction;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionViews;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Request;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Router;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ScriptMediaSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ScriptUserSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Search;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SelectionTranslation;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteDecrypt;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteDynamicGet;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteEditView;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldDecodeFilter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteMainGet;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Sort;
use VDM\Joomla\Componentbuilder\Compiler\Builder\TabCounter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Builder\TemplateData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Title;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UikitComp;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UpdateMysql;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ViewsDefaultOrdering;


/**
 * Builder L-Z Service Provider
 * 
 * @since 3.2.0
 */
class BuilderLZ implements ServiceProviderInterface
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
		$container->alias(LanguageMessages::class, 'Compiler.Builder.Language.Messages')
			->share('Compiler.Builder.Language.Messages', [$this, 'getLanguageMessages'], true);

		$container->alias(Layout::class, 'Compiler.Builder.Layout')
			->share('Compiler.Builder.Layout', [$this, 'getLayout'], true);

		$container->alias(LayoutData::class, 'Compiler.Builder.Layout.Data')
			->share('Compiler.Builder.Layout.Data', [$this, 'getLayoutData'], true);

		$container->alias(LibraryManager::class, 'Compiler.Builder.Library.Manager')
			->share('Compiler.Builder.Library.Manager', [$this, 'getLibraryManager'], true);

		$container->alias(ListFieldClass::class, 'Compiler.Builder.List.Field.Class')
			->share('Compiler.Builder.List.Field.Class', [$this, 'getListFieldClass'], true);

		$container->alias(ListHeadOverride::class, 'Compiler.Builder.List.Head.Override')
			->share('Compiler.Builder.List.Head.Override', [$this, 'getListHeadOverride'], true);

		$container->alias(ListJoin::class, 'Compiler.Builder.List.Join')
			->share('Compiler.Builder.List.Join', [$this, 'getListJoin'], true);

		$container->alias(Lists::class, 'Compiler.Builder.Lists')
			->share('Compiler.Builder.Lists', [$this, 'getLists'], true);

		$container->alias(MainTextField::class, 'Compiler.Builder.Main.Text.Field')
			->share('Compiler.Builder.Main.Text.Field', [$this, 'getMainTextField'], true);

		$container->alias(MetaData::class, 'Compiler.Builder.Meta.Data')
			->share('Compiler.Builder.Meta.Data', [$this, 'getMetaData'], true);

		$container->alias(ModelBasicField::class, 'Compiler.Builder.Model.Basic.Field')
			->share('Compiler.Builder.Model.Basic.Field', [$this, 'getModelBasicField'], true);

		$container->alias(ModelExpertField::class, 'Compiler.Builder.Model.Expert.Field')
			->share('Compiler.Builder.Model.Expert.Field', [$this, 'getModelExpertField'], true);

		$container->alias(ModelExpertFieldInitiator::class, 'Compiler.Builder.Model.Expert.Field.Initiator')
			->share('Compiler.Builder.Model.Expert.Field.Initiator', [$this, 'getModelExpertFieldInitiator'], true);

		$container->alias(ModelMediumField::class, 'Compiler.Builder.Model.Medium.Field')
			->share('Compiler.Builder.Model.Medium.Field', [$this, 'getModelMediumField'], true);

		$container->alias(ModelWhmcsField::class, 'Compiler.Builder.Model.Whmcs.Field')
			->share('Compiler.Builder.Model.Whmcs.Field', [$this, 'getModelWhmcsField'], true);

		$container->alias(MovedPublishingFields::class, 'Compiler.Builder.Moved.Publishing.Fields')
			->share('Compiler.Builder.Moved.Publishing.Fields', [$this, 'getMovedPublishingFields'], true);

		$container->alias(MysqlTableSetting::class, 'Compiler.Builder.Mysql.Table.Setting')
			->share('Compiler.Builder.Mysql.Table.Setting', [$this, 'getMysqlTableSetting'], true);

		$container->alias(NewPublishingFields::class, 'Compiler.Builder.New.Publishing.Fields')
			->share('Compiler.Builder.New.Publishing.Fields', [$this, 'getNewPublishingFields'], true);

		$container->alias(OrderZero::class, 'Compiler.Builder.Order.Zero')
			->share('Compiler.Builder.Order.Zero', [$this, 'getOrderZero'], true);

		$container->alias(OtherFilter::class, 'Compiler.Builder.Other.Filter')
			->share('Compiler.Builder.Other.Filter', [$this, 'getOtherFilter'], true);

		$container->alias(OtherGroup::class, 'Compiler.Builder.Other.Group')
			->share('Compiler.Builder.Other.Group', [$this, 'getOtherGroup'], true);

		$container->alias(OtherJoin::class, 'Compiler.Builder.Other.Join')
			->share('Compiler.Builder.Other.Join', [$this, 'getOtherJoin'], true);

		$container->alias(OtherOrder::class, 'Compiler.Builder.Other.Order')
			->share('Compiler.Builder.Other.Order', [$this, 'getOtherOrder'], true);

		$container->alias(OtherQuery::class, 'Compiler.Builder.Other.Query')
			->share('Compiler.Builder.Other.Query', [$this, 'getOtherQuery'], true);

		$container->alias(OtherWhere::class, 'Compiler.Builder.Other.Where')
			->share('Compiler.Builder.Other.Where', [$this, 'getOtherWhere'], true);

		$container->alias(PermissionAction::class, 'Compiler.Builder.Permission.Action')
			->share('Compiler.Builder.Permission.Action', [$this, 'getPermissionAction'], true);

		$container->alias(PermissionComponent::class, 'Compiler.Builder.Permission.Component')
			->share('Compiler.Builder.Permission.Component', [$this, 'getPermissionComponent'], true);

		$container->alias(PermissionCore::class, 'Compiler.Builder.Permission.Core')
			->share('Compiler.Builder.Permission.Core', [$this, 'getPermissionCore'], true);

		$container->alias(PermissionDashboard::class, 'Compiler.Builder.Permission.Dashboard')
			->share('Compiler.Builder.Permission.Dashboard', [$this, 'getPermissionDashboard'], true);

		$container->alias(PermissionFields::class, 'Compiler.Builder.Permission.Fields')
			->share('Compiler.Builder.Permission.Fields', [$this, 'getPermissionFields'], true);

		$container->alias(PermissionGlobalAction::class, 'Compiler.Builder.Permission.Global.Action')
			->share('Compiler.Builder.Permission.Global.Action', [$this, 'getPermissionGlobalAction'], true);

		$container->alias(PermissionViews::class, 'Compiler.Builder.Permission.Views')
			->share('Compiler.Builder.Permission.Views', [$this, 'getPermissionViews'], true);

		$container->alias(Request::class, 'Compiler.Builder.Request')
			->share('Compiler.Builder.Request', [$this, 'getRequest'], true);

		$container->alias(Router::class, 'Compiler.Builder.Router')
			->share('Compiler.Builder.Router', [$this, 'getRouter'], true);

		$container->alias(ScriptMediaSwitch::class, 'Compiler.Builder.Script.Media.Switch')
			->share('Compiler.Builder.Script.Media.Switch', [$this, 'getScriptMediaSwitch'], true);

		$container->alias(ScriptUserSwitch::class, 'Compiler.Builder.Script.User.Switch')
			->share('Compiler.Builder.Script.User.Switch', [$this, 'getScriptUserSwitch'], true);

		$container->alias(Search::class, 'Compiler.Builder.Search')
			->share('Compiler.Builder.Search', [$this, 'getSearch'], true);

		$container->alias(SelectionTranslation::class, 'Compiler.Builder.Selection.Translation')
			->share('Compiler.Builder.Selection.Translation', [$this, 'getSelectionTranslation'], true);

		$container->alias(SiteDecrypt::class, 'Compiler.Builder.Site.Decrypt')
			->share('Compiler.Builder.Site.Decrypt', [$this, 'getSiteDecrypt'], true);

		$container->alias(SiteDynamicGet::class, 'Compiler.Builder.Site.Dynamic.Get')
			->share('Compiler.Builder.Site.Dynamic.Get', [$this, 'getSiteDynamicGet'], true);

		$container->alias(SiteEditView::class, 'Compiler.Builder.Site.Edit.View')
			->share('Compiler.Builder.Site.Edit.View', [$this, 'getSiteEditView'], true);

		$container->alias(SiteFieldData::class, 'Compiler.Builder.Site.Field.Data')
			->share('Compiler.Builder.Site.Field.Data', [$this, 'getSiteFieldData'], true);

		$container->alias(SiteFieldDecodeFilter::class, 'Compiler.Builder.Site.Field.Decode.Filter')
			->share('Compiler.Builder.Site.Field.Decode.Filter', [$this, 'getSiteFieldDecodeFilter'], true);

		$container->alias(SiteFields::class, 'Compiler.Builder.Site.Fields')
			->share('Compiler.Builder.Site.Fields', [$this, 'getSiteFields'], true);

		$container->alias(SiteMainGet::class, 'Compiler.Builder.Site.Main.Get')
			->share('Compiler.Builder.Site.Main.Get', [$this, 'getSiteMainGet'], true);

		$container->alias(Sort::class, 'Compiler.Builder.Sort')
			->share('Compiler.Builder.Sort', [$this, 'getSort'], true);

		$container->alias(TabCounter::class, 'Compiler.Builder.Tab.Counter')
			->share('Compiler.Builder.Tab.Counter', [$this, 'getTabCounter'], true);

		$container->alias(Tags::class, 'Compiler.Builder.Tags')
			->share('Compiler.Builder.Tags', [$this, 'getTags'], true);

		$container->alias(TemplateData::class, 'Compiler.Builder.Template.Data')
			->share('Compiler.Builder.Template.Data', [$this, 'getTemplateData'], true);

		$container->alias(Title::class, 'Compiler.Builder.Title')
			->share('Compiler.Builder.Title', [$this, 'getTitle'], true);

		$container->alias(UikitComp::class, 'Compiler.Builder.Uikit.Comp')
			->share('Compiler.Builder.Uikit.Comp', [$this, 'getUikitComp'], true);

		$container->alias(UpdateMysql::class, 'Compiler.Builder.Update.Mysql')
			->share('Compiler.Builder.Update.Mysql', [$this, 'getUpdateMysql'], true);

		$container->alias(ViewsDefaultOrdering::class, 'Compiler.Builder.Views.Default.Ordering')
			->share('Compiler.Builder.Views.Default.Ordering', [$this, 'getViewsDefaultOrdering'], true);
	}

	/**
	 * Get The LanguageMessages Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LanguageMessages
	 * @since 3.2.0
	 */
	public function getLanguageMessages(Container $container): LanguageMessages
	{
		return new LanguageMessages();
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
		return new Layout();
	}

	/**
	 * Get The LayoutData Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LayoutData
	 * @since 3.2.0
	 */
	public function getLayoutData(Container $container): LayoutData
	{
		return new LayoutData();
	}

	/**
	 * Get The LibraryManager Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LibraryManager
	 * @since 3.2.0
	 */
	public function getLibraryManager(Container $container): LibraryManager
	{
		return new LibraryManager();
	}

	/**
	 * Get The ListFieldClass Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ListFieldClass
	 * @since 3.2.0
	 */
	public function getListFieldClass(Container $container): ListFieldClass
	{
		return new ListFieldClass();
	}

	/**
	 * Get The ListHeadOverride Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ListHeadOverride
	 * @since 3.2.0
	 */
	public function getListHeadOverride(Container $container): ListHeadOverride
	{
		return new ListHeadOverride();
	}

	/**
	 * Get The ListJoin Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ListJoin
	 * @since 3.2.0
	 */
	public function getListJoin(Container $container): ListJoin
	{
		return new ListJoin();
	}

	/**
	 * Get The Lists Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Lists
	 * @since 3.2.0
	 */
	public function getLists(Container $container): Lists
	{
		return new Lists();
	}

	/**
	 * Get The MainTextField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MainTextField
	 * @since 3.2.0
	 */
	public function getMainTextField(Container $container): MainTextField
	{
		return new MainTextField();
	}

	/**
	 * Get The MetaData Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MetaData
	 * @since 3.2.0
	 */
	public function getMetaData(Container $container): MetaData
	{
		return new MetaData();
	}

	/**
	 * Get The ModelBasicField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ModelBasicField
	 * @since 3.2.0
	 */
	public function getModelBasicField(Container $container): ModelBasicField
	{
		return new ModelBasicField();
	}

	/**
	 * Get The ModelExpertField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ModelExpertField
	 * @since 3.2.0
	 */
	public function getModelExpertField(Container $container): ModelExpertField
	{
		return new ModelExpertField();
	}

	/**
	 * Get The ModelExpertFieldInitiator Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ModelExpertFieldInitiator
	 * @since 3.2.0
	 */
	public function getModelExpertFieldInitiator(Container $container): ModelExpertFieldInitiator
	{
		return new ModelExpertFieldInitiator();
	}

	/**
	 * Get The ModelMediumField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ModelMediumField
	 * @since 3.2.0
	 */
	public function getModelMediumField(Container $container): ModelMediumField
	{
		return new ModelMediumField();
	}

	/**
	 * Get The ModelWhmcsField Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ModelWhmcsField
	 * @since 3.2.0
	 */
	public function getModelWhmcsField(Container $container): ModelWhmcsField
	{
		return new ModelWhmcsField();
	}

	/**
	 * Get The MovedPublishingFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MovedPublishingFields
	 * @since 3.2.0
	 */
	public function getMovedPublishingFields(Container $container): MovedPublishingFields
	{
		return new MovedPublishingFields();
	}

	/**
	 * Get The MysqlTableSetting Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MysqlTableSetting
	 * @since 3.2.0
	 */
	public function getMysqlTableSetting(Container $container): MysqlTableSetting
	{
		return new MysqlTableSetting();
	}

	/**
	 * Get The NewPublishingFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  NewPublishingFields
	 * @since 3.2.0
	 */
	public function getNewPublishingFields(Container $container): NewPublishingFields
	{
		return new NewPublishingFields();
	}

	/**
	 * Get The OrderZero Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  OrderZero
	 * @since 3.2.0
	 */
	public function getOrderZero(Container $container): OrderZero
	{
		return new OrderZero();
	}

	/**
	 * Get The OtherFilter Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  OtherFilter
	 * @since 3.2.0
	 */
	public function getOtherFilter(Container $container): OtherFilter
	{
		return new OtherFilter();
	}

	/**
	 * Get The OtherGroup Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  OtherGroup
	 * @since 3.2.0
	 */
	public function getOtherGroup(Container $container): OtherGroup
	{
		return new OtherGroup();
	}

	/**
	 * Get The OtherJoin Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  OtherJoin
	 * @since 3.2.0
	 */
	public function getOtherJoin(Container $container): OtherJoin
	{
		return new OtherJoin();
	}

	/**
	 * Get The OtherOrder Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  OtherOrder
	 * @since 3.2.0
	 */
	public function getOtherOrder(Container $container): OtherOrder
	{
		return new OtherOrder();
	}

	/**
	 * Get The OtherQuery Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  OtherQuery
	 * @since 3.2.0
	 */
	public function getOtherQuery(Container $container): OtherQuery
	{
		return new OtherQuery();
	}

	/**
	 * Get The OtherWhere Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  OtherWhere
	 * @since 3.2.0
	 */
	public function getOtherWhere(Container $container): OtherWhere
	{
		return new OtherWhere();
	}

	/**
	 * Get The PermissionAction Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PermissionAction
	 * @since 3.2.0
	 */
	public function getPermissionAction(Container $container): PermissionAction
	{
		return new PermissionAction();
	}

	/**
	 * Get The PermissionComponent Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PermissionComponent
	 * @since 3.2.0
	 */
	public function getPermissionComponent(Container $container): PermissionComponent
	{
		return new PermissionComponent();
	}

	/**
	 * Get The PermissionCore Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PermissionCore
	 * @since 3.2.0
	 */
	public function getPermissionCore(Container $container): PermissionCore
	{
		return new PermissionCore();
	}

	/**
	 * Get The PermissionDashboard Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PermissionDashboard
	 * @since 3.2.0
	 */
	public function getPermissionDashboard(Container $container): PermissionDashboard
	{
		return new PermissionDashboard();
	}

	/**
	 * Get The PermissionFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PermissionFields
	 * @since 3.2.0
	 */
	public function getPermissionFields(Container $container): PermissionFields
	{
		return new PermissionFields();
	}

	/**
	 * Get The PermissionGlobalAction Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PermissionGlobalAction
	 * @since 3.2.0
	 */
	public function getPermissionGlobalAction(Container $container): PermissionGlobalAction
	{
		return new PermissionGlobalAction();
	}

	/**
	 * Get The PermissionViews Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  PermissionViews
	 * @since 3.2.0
	 */
	public function getPermissionViews(Container $container): PermissionViews
	{
		return new PermissionViews();
	}

	/**
	 * Get The Request Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Request
	 * @since 3.2.0
	 */
	public function getRequest(Container $container): Request
	{
		return new Request();
	}

	/**
	 * Get The Router Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Router
	 * @since 3.2.0
	 */
	public function getRouter(Container $container): Router
	{
		return new Router();
	}

	/**
	 * Get The ScriptMediaSwitch Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ScriptMediaSwitch
	 * @since 3.2.0
	 */
	public function getScriptMediaSwitch(Container $container): ScriptMediaSwitch
	{
		return new ScriptMediaSwitch();
	}

	/**
	 * Get The ScriptUserSwitch Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ScriptUserSwitch
	 * @since 3.2.0
	 */
	public function getScriptUserSwitch(Container $container): ScriptUserSwitch
	{
		return new ScriptUserSwitch();
	}

	/**
	 * Get The Search Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Search
	 * @since 3.2.0
	 */
	public function getSearch(Container $container): Search
	{
		return new Search();
	}

	/**
	 * Get The SelectionTranslation Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SelectionTranslation
	 * @since 3.2.0
	 */
	public function getSelectionTranslation(Container $container): SelectionTranslation
	{
		return new SelectionTranslation();
	}

	/**
	 * Get The SiteDecrypt Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteDecrypt
	 * @since 3.2.0
	 */
	public function getSiteDecrypt(Container $container): SiteDecrypt
	{
		return new SiteDecrypt();
	}

	/**
	 * Get The SiteDynamicGet Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteDynamicGet
	 * @since 3.2.0
	 */
	public function getSiteDynamicGet(Container $container): SiteDynamicGet
	{
		return new SiteDynamicGet();
	}

	/**
	 * Get The SiteEditView Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteEditView
	 * @since 3.2.0
	 */
	public function getSiteEditView(Container $container): SiteEditView
	{
		return new SiteEditView();
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
		return new SiteFieldData();
	}

	/**
	 * Get The SiteFieldDecodeFilter Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteFieldDecodeFilter
	 * @since 3.2.0
	 */
	public function getSiteFieldDecodeFilter(Container $container): SiteFieldDecodeFilter
	{
		return new SiteFieldDecodeFilter();
	}

	/**
	 * Get The SiteFields Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteFields
	 * @since 3.2.0
	 */
	public function getSiteFields(Container $container): SiteFields
	{
		return new SiteFields();
	}

	/**
	 * Get The SiteMainGet Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteMainGet
	 * @since 3.2.0
	 */
	public function getSiteMainGet(Container $container): SiteMainGet
	{
		return new SiteMainGet();
	}

	/**
	 * Get The Sort Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Sort
	 * @since 3.2.0
	 */
	public function getSort(Container $container): Sort
	{
		return new Sort();
	}

	/**
	 * Get The TabCounter Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TabCounter
	 * @since 3.2.0
	 */
	public function getTabCounter(Container $container): TabCounter
	{
		return new TabCounter();
	}

	/**
	 * Get The Tags Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Tags
	 * @since 3.2.0
	 */
	public function getTags(Container $container): Tags
	{
		return new Tags();
	}

	/**
	 * Get The TemplateData Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  TemplateData
	 * @since 3.2.0
	 */
	public function getTemplateData(Container $container): TemplateData
	{
		return new TemplateData();
	}

	/**
	 * Get The Title Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Title
	 * @since 3.2.0
	 */
	public function getTitle(Container $container): Title
	{
		return new Title();
	}

	/**
	 * Get The UikitComp Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  UikitComp
	 * @since 3.2.0
	 */
	public function getUikitComp(Container $container): UikitComp
	{
		return new UikitComp();
	}

	/**
	 * Get The UpdateMysql Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  UpdateMysql
	 * @since 3.2.0
	 */
	public function getUpdateMysql(Container $container): UpdateMysql
	{
		return new UpdateMysql();
	}

	/**
	 * Get The ViewsDefaultOrdering Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewsDefaultOrdering
	 * @since 3.2.0
	 */
	public function getViewsDefaultOrdering(Container $container): ViewsDefaultOrdering
	{
		return new ViewsDefaultOrdering();
	}
}

