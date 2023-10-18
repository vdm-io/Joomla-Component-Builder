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
use VDM\Joomla\Componentbuilder\Server\Model\Load as ServerLoad;
use VDM\Joomla\Componentbuilder\Compiler\Model\Joomlaplugins;
use VDM\Joomla\Componentbuilder\Compiler\Model\Joomlamodules;
use VDM\Joomla\Componentbuilder\Compiler\Model\Historycomponent;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customadminviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Ajaxcustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Javascriptcustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Csscustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Phpcustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Dynamicget;
use VDM\Joomla\Componentbuilder\Compiler\Model\Libraries;
use VDM\Joomla\Componentbuilder\Compiler\Model\Siteviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Permissions;
use VDM\Joomla\Componentbuilder\Compiler\Model\Historyadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Mysqlsettings;
use VDM\Joomla\Componentbuilder\Compiler\Model\Sql;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customalias;
use VDM\Joomla\Componentbuilder\Compiler\Model\Ajaxadmin;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customimportscripts;
use VDM\Joomla\Componentbuilder\Compiler\Model\Custombuttons;
use VDM\Joomla\Componentbuilder\Compiler\Model\Loader;
use VDM\Joomla\Componentbuilder\Compiler\Model\Phpadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Cssadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Javascriptadminview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Linkedviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Relations;
use VDM\Joomla\Componentbuilder\Compiler\Model\Conditions;
use VDM\Joomla\Componentbuilder\Compiler\Model\Fields;
use VDM\Joomla\Componentbuilder\Compiler\Model\Updatesql;
use VDM\Joomla\Componentbuilder\Compiler\Model\Tabs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customtabs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Adminviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Sqltweaking;
use VDM\Joomla\Componentbuilder\Compiler\Model\Sqldump;
use VDM\Joomla\Componentbuilder\Compiler\Model\Whmcs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Filesfolders;
use VDM\Joomla\Componentbuilder\Compiler\Model\Modifieddate;
use VDM\Joomla\Componentbuilder\Compiler\Model\Createdate;
use VDM\Joomla\Componentbuilder\Compiler\Model\Updateserver;


/**
 * Model Service Provider
 * 
 * @since 3.2.0
 */
class Model implements ServiceProviderInterface
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
		$container->alias(Joomlaplugins::class, 'Model.Joomlaplugins')
			->share('Model.Joomlaplugins', [$this, 'getModelJoomlaplugins'], true);

		$container->alias(Joomlamodules::class, 'Model.Joomlamodules')
			->share('Model.Joomlamodules', [$this, 'getModelJoomlamodules'], true);

		$container->alias(Historycomponent::class, 'Model.Historycomponent')
			->share('Model.Historycomponent', [$this, 'getModelHistorycomponent'], true);

		$container->alias(Customadminviews::class, 'Model.Customadminviews')
			->share('Model.Customadminviews', [$this, 'getModelCustomadminviews'], true);

		$container->alias(Ajaxcustomview::class, 'Model.Ajaxcustomview')
			->share('Model.Ajaxcustomview', [$this, 'getModelAjaxcustomview'], true);

		$container->alias(Javascriptcustomview::class, 'Model.Javascriptcustomview')
			->share('Model.Javascriptcustomview', [$this, 'getModelJavascriptcustomview'], true);

		$container->alias(Csscustomview::class, 'Model.Csscustomview')
			->share('Model.Csscustomview', [$this, 'getModelCsscustomview'], true);

		$container->alias(Phpcustomview::class, 'Model.Phpcustomview')
			->share('Model.Phpcustomview', [$this, 'getModelPhpcustomview'], true);

		$container->alias(Dynamicget::class, 'Model.Dynamicget')
			->share('Model.Dynamicget', [$this, 'getModelDynamicget'], true);

		$container->alias(Libraries::class, 'Model.Libraries')
			->share('Model.Libraries', [$this, 'getModelLibraries'], true);

		$container->alias(Siteviews::class, 'Model.Siteviews')
			->share('Model.Siteviews', [$this, 'getModelSiteviews'], true);

		$container->alias(Permissions::class, 'Model.Permissions')
			->share('Model.Permissions', [$this, 'getModelPermissions'], true);

		$container->alias(Historyadminview::class, 'Model.Historyadminview')
			->share('Model.Historyadminview', [$this, 'getModelHistoryadminview'], true);

		$container->alias(Mysqlsettings::class, 'Model.Mysqlsettings')
			->share('Model.Mysqlsettings', [$this, 'getModelMysqlsettings'], true);

		$container->alias(Sql::class, 'Model.Sql')
			->share('Model.Sql', [$this, 'getModelSql'], true);

		$container->alias(Customalias::class, 'Model.Customalias')
			->share('Model.Customalias', [$this, 'getModelCustomalias'], true);

		$container->alias(Ajaxadmin::class, 'Model.Ajaxadmin')
			->share('Model.Ajaxadmin', [$this, 'getModelAjaxadmin'], true);

		$container->alias(Customimportscripts::class, 'Model.Customimportscripts')
			->share('Model.Customimportscripts', [$this, 'getModelCustomimportscripts'], true);

		$container->alias(Custombuttons::class, 'Model.Custombuttons')
			->share('Model.Custombuttons', [$this, 'getModelCustombuttons'], true);

		$container->alias(Loader::class, 'Model.Loader')
			->share('Model.Loader', [$this, 'getModelLoader'], true);

		$container->alias(Phpadminview::class, 'Model.Phpadminview')
			->share('Model.Phpadminview', [$this, 'getModelPhpadminview'], true);

		$container->alias(Cssadminview::class, 'Model.Cssadminview')
			->share('Model.Cssadminview', [$this, 'getModelCssadminview'], true);

		$container->alias(Javascriptadminview::class, 'Model.Javascriptadminview')
			->share('Model.Javascriptadminview', [$this, 'getModelJavascriptadminview'], true);

		$container->alias(Linkedviews::class, 'Model.Linkedviews')
			->share('Model.Linkedviews', [$this, 'getModelLinkedviews'], true);

		$container->alias(Relations::class, 'Model.Relations')
			->share('Model.Relations', [$this, 'getModelRelations'], true);

		$container->alias(Conditions::class, 'Model.Conditions')
			->share('Model.Conditions', [$this, 'getModelConditions'], true);

		$container->alias(Fields::class, 'Model.Fields')
			->share('Model.Fields', [$this, 'getModelFields'], true);

		$container->alias(Updatesql::class, 'Model.Updatesql')
			->share('Model.Updatesql', [$this, 'getModelUpdatesql'], true);

		$container->alias(Tabs::class, 'Model.Tabs')
			->share('Model.Tabs', [$this, 'getModelTabs'], true);

		$container->alias(Customtabs::class, 'Model.Customtabs')
			->share('Model.Customtabs', [$this, 'getModelCustomtabs'], true);

		$container->alias(Adminviews::class, 'Model.Adminviews')
			->share('Model.Adminviews', [$this, 'getModelAdminviews'], true);

		$container->alias(Sqltweaking::class, 'Model.Sqltweaking')
			->share('Model.Sqltweaking', [$this, 'getModelSqltweaking'], true);

		$container->alias(Sqldump::class, 'Model.Sqldump')
			->share('Model.Sqldump', [$this, 'getModelSqldump'], true);

		$container->alias(Whmcs::class, 'Model.Whmcs')
			->share('Model.Whmcs', [$this, 'getModelWhmcs'], true);

		$container->alias(Modifieddate::class, 'Model.Modifieddate')
			->share('Model.Modifieddate', [$this, 'getModifieddate'], true);

		$container->alias(Createdate::class, 'Model.Createdate')
			->share('Model.Createdate', [$this, 'getCreatedate'], true);

		$container->alias(Updateserver::class, 'Model.Updateserver')
			->share('Model.Updateserver', [$this, 'getUpdateserver'], true);

		$container->alias(Filesfolders::class, 'Model.Filesfolders')
			->share('Model.Filesfolders', [$this, 'getModelFilesfolders'], true);

		$container->alias(ServerLoad::class, 'Model.Server.Load')
			->share('Model.Server.Load', [$this, 'getServerLoad'], true);
	}

	/**
	 * Get the Joomla plugins Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Joomlaplugins
	 * @since 3.2.0
	 */
	public function getModelJoomlaplugins(Container $container): Joomlaplugins
	{
		return new Joomlaplugins(
			$container->get('Joomlaplugin.Data')
		);
	}

	/**
	 * Get the Joomla modules Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Joomlamodules
	 * @since 3.2.0
	 */
	public function getModelJoomlamodules(Container $container): Joomlamodules
	{
		return new Joomlamodules(
			$container->get('Joomlamodule.Data')
		);
	}

	/**
	 * Get the history component Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Historycomponent
	 * @since 3.2.0
	 */
	public function getModelHistorycomponent(Container $container): Historycomponent
	{
		return new Historycomponent(
			$container->get('Config'),
			$container->get('History'),
			$container->get('Model.Updatesql')
		);
	}

	/**
	 * Get the custom admin views Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Customadminviews
	 * @since 3.2.0
	 */
	public function getModelCustomadminviews(Container $container): Customadminviews
	{
		return new Customadminviews(
			$container->get('Customview.Data'),
			$container->get('Config')
		);
	}

	/**
	 * Get the ajax custom view Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Ajaxcustomview
	 * @since 3.2.0
	 */
	public function getModelAjaxcustomview(Container $container): Ajaxcustomview
	{
		return new Ajaxcustomview(
			$container->get('Config'),
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get the javascript custom view Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Javascriptcustomview
	 * @since 3.2.0
	 */
	public function getModelJavascriptcustomview(Container $container): Javascriptcustomview
	{
		return new Javascriptcustomview(
			$container->get('Customcode'),
			$container->get('Customcode.Gui')
		);
	}

	/**
	 * Get the css custom view Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Csscustomview
	 * @since 3.2.0
	 */
	public function getModelCsscustomview(Container $container): Csscustomview
	{
		return new Csscustomview(
			$container->get('Customcode')
		);
	}

	/**
	 * Get the php custom view Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Phpcustomview
	 * @since 3.2.0
	 */
	public function getModelPhpcustomview(Container $container): Phpcustomview
	{
		return new Phpcustomview(
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Model.Loader'),
			$container->get('Templatelayout.Data')
		);
	}

	/**
	 * Get the dynamic get Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Dynamicget
	 * @since 3.2.0
	 */
	public function getModelDynamicget(Container $container): Dynamicget
	{
		return new Dynamicget(
			$container->get('Config'),
			$container->get('Compiler.Builder.Site.Dynamic.Get'),
			$container->get('Compiler.Builder.Site.Main.Get'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Placeholder'),
			$container->get('Dynamicget.Selection')
		);
	}

	/**
	 * Get the libraries Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Libraries
	 * @since 3.2.0
	 */
	public function getModelLibraries(Container $container): Libraries
	{
		return new Libraries(
			$container->get('Config'),
			$container->get('Compiler.Builder.Library.Manager'),
			$container->get('Library.Data')
		);
	}

	/**
	 * Get the site views Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Siteviews
	 * @since 3.2.0
	 */
	public function getModelSiteviews(Container $container): Siteviews
	{
		return new Siteviews(
			$container->get('Customview.Data'),
			$container->get('Config')
		);
	}

	/**
	 * Get the permissions Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Permissions
	 * @since 3.2.0
	 */
	public function getModelPermissions(Container $container): Permissions
	{
		return new Permissions();
	}

	/**
	 * Get the admin view history Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Historyadminview
	 * @since 3.2.0
	 */
	public function getModelHistoryadminview(Container $container): Historyadminview
	{
		return new Historyadminview(
			$container->get('Config'),
			$container->get('History'),
			$container->get('Model.Updatesql')
		);
	}

	/**
	 * Get the MySQL settings Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Mysqlsettings
	 * @since 3.2.0
	 */
	public function getModelMysqlsettings(Container $container): Mysqlsettings
	{
		return new Mysqlsettings(
			$container->get('Config'),
			$container->get('Compiler.Builder.Mysql.Table.Setting')
		);
	}

	/**
	 * Get the Sql Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Sql
	 * @since 3.2.0
	 */
	public function getModelSql(Container $container): Sql
	{
		return new Sql(
			$container->get('Customcode.Dispenser'),
			$container->get('Model.Sqldump')
		);
	}

	/**
	 * Get the custom alias Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Customalias
	 * @since 3.2.0
	 */
	public function getModelCustomalias(Container $container): Customalias
	{
		return new Customalias(
			$container->get('Compiler.Builder.Custom.Alias'),
			$container->get('Field.Name')
		);
	}

	/**
	 * Get the Admin Ajax Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Ajaxadmin
	 * @since 3.2.0
	 */
	public function getModelAjaxadmin(Container $container): Ajaxadmin
	{
		return new Ajaxadmin(
			$container->get('Config'),
			$container->get('Compiler.Builder.Site.Edit.View'),
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get the custom import scripts Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Customimportscripts
	 * @since 3.2.0
	 */
	public function getModelCustomimportscripts(Container $container): Customimportscripts
	{
		return new Customimportscripts(
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get the custom import scripts Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Custombuttons
	 * @since 3.2.0
	 */
	public function getModelCustombuttons(Container $container): Custombuttons
	{
		return new Custombuttons(
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Templatelayout.Data')
		);
	}

	/**
	 * Get The Model Loader Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Loader
	 * @since 3.2.0
	 */
	public function getModelLoader(Container $container): Loader
	{
		return new Loader(
			$container->get('Config'),
			$container->get('Compiler.Builder.Footable.Scripts'),
			$container->get('Compiler.Builder.Google.Chart'),
			$container->get('Compiler.Builder.Get.Module'),
			$container->get('Compiler.Builder.Uikit.Comp')
		);
	}

	/**
	 * Get the php admin view Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Phpadminview
	 * @since 3.2.0
	 */
	public function getModelPhpadminview(Container $container): Phpadminview
	{
		return new Phpadminview(
			$container->get('Customcode.Dispenser'),
			$container->get('Templatelayout.Data')
		);
	}

	/**
	 * Get the Css Adminview Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Cssadminview
	 * @since 3.2.0
	 */
	public function getModelCssadminview(Container $container): Cssadminview
	{
		return new Cssadminview(
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get the Javascript Adminview Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Javascriptadminview
	 * @since 3.2.0
	 */
	public function getModelJavascriptadminview(Container $container): Javascriptadminview
	{
		return new Javascriptadminview(
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get the linked views Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Linkedviews
	 * @since 3.2.0
	 */
	public function getModelLinkedviews(Container $container): Linkedviews
	{
		return new Linkedviews(
			$container->get('Registry')
		);
	}

	/**
	 * Get the relations Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Relations
	 * @since 3.2.0
	 */
	public function getModelRelations(Container $container): Relations
	{
		return new Relations(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Customcode'),
			$container->get('Compiler.Builder.List.Join'),
			$container->get('Compiler.Builder.List.Head.Override'),
			$container->get('Compiler.Builder.Field.Relations')
		);
	}

	/**
	 * Get the conditions Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Conditions
	 * @since 3.2.0
	 */
	public function getModelConditions(Container $container): Conditions
	{
		return new Conditions(
			$container->get('Field.Type.Name'),
			$container->get('Field.Name'),
			$container->get('Field.Groups')
		);
	}

	/**
	 * Get the fields Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Fields
	 * @since 3.2.0
	 */
	public function getModelFields(Container $container): Fields
	{
		return new Fields(
			$container->get('Config'),
			$container->get('Registry'),
			$container->get('History'),
			$container->get('Customcode'),
			$container->get('Field'),
			$container->get('Field.Name'),
			$container->get('Field.Groups'),
			$container->get('Model.Updatesql')
		);
	}

	/**
	 * Get the update sql Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Updatesql
	 * @since 3.2.0
	 */
	public function getModelUpdatesql(Container $container): Updatesql
	{
		return new Updatesql(
			$container->get('Registry')
		);
	}

	/**
	 * Get the tabs Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Updatesql
	 * @since 3.2.0
	 */
	public function getModelTabs(Container $container): Tabs
	{
		return new Tabs();
	}

	/**
	 * Get the custom tabs Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Customtabs
	 * @since 3.2.0
	 */
	public function getModelCustomtabs(Container $container): Customtabs
	{
		return new Customtabs(
			$container->get('Config'),
			$container->get('Compiler.Builder.Custom.Tabs'),
			$container->get('Language'),
			$container->get('Placeholder'),
			$container->get('Customcode')
		);
	}

	/**
	 * Get the admin views Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Adminviews
	 * @since 3.2.0
	 */
	public function getModelAdminviews(Container $container): Adminviews
	{
		return new Adminviews(
			$container->get('Config'),
			$container->get('Adminview.Data'),
			$container->get('Compiler.Builder.Site.Edit.View'),
			$container->get('Compiler.Builder.Admin.Filter.Type')
		);
	}

	/**
	 * Get the SQL tweaking Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Sqltweaking
	 * @since 3.2.0
	 */
	public function getModelSqltweaking(Container $container): Sqltweaking
	{
		return new Sqltweaking(
			$container->get('Registry')
		);
	}

	/**
	 * Get the SQL dump Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Sqldump
	 * @since 3.2.0
	 */
	public function getModelSqldump(Container $container): Sqldump
	{
		return new Sqldump(
			$container->get('Registry')
		);
	}

	/**
	 * Get the whmcs Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Whmcs
	 * @since 3.2.0
	 */
	public function getModelWhmcs(Container $container): Whmcs
	{
		return new Whmcs();
	}

	/**
	 * Get the modified date Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Modifieddate
	 * @since 3.2.0
	 */
	public function getModifieddate(Container $container): Modifieddate
	{
		return new Modifieddate();
	}

	/**
	 * Get the create date Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Createdate
	 * @since 3.2.0
	 */
	public function getCreatedate(Container $container): Createdate
	{
		return new Createdate();
	}

	/**
	 * Get the update server Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Updateserver
	 * @since 3.2.0
	 */
	public function getUpdateserver(Container $container): Updateserver
	{
		return new Updateserver();
	}

	/**
	 * Get the files folders Model
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Filesfolders
	 * @since 3.2.0
	 */
	public function getModelFilesfolders(Container $container): Filesfolders
	{
		return new Filesfolders();
	}

	/**
	 * Get the Server Model Server Loader class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ServerLoad
	 * @since 3.2.0
	 */
	public function getServerLoad(Container $container): ServerLoad
	{
		return new ServerLoad(
			$container->get('Crypt'),
			$container->get('Table')
		);
	}
}

