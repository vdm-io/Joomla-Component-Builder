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

namespace VDM\Joomla\Componentbuilder\Compiler;


use Joomla\DI\Container;
use VDM\Joomla\Componentbuilder\Service\Crypt;
use VDM\Joomla\Componentbuilder\Service\Server;
use VDM\Joomla\Componentbuilder\Service\Api;
use VDM\Joomla\Componentbuilder\Service\Network;
use VDM\Joomla\Service\Database;
use VDM\Joomla\Service\Model as BaseModel;
use VDM\Joomla\Service\Data;
use VDM\Joomla\Componentbuilder\Compiler\Service\Model;
use VDM\Joomla\Componentbuilder\Compiler\Service\Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Service\Event;
use VDM\Joomla\Componentbuilder\Compiler\Service\Header;
use VDM\Joomla\Componentbuilder\Compiler\Service\History;
use VDM\Joomla\Componentbuilder\Compiler\Service\Language;
use VDM\Joomla\Componentbuilder\Compiler\Service\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Service\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Service\Package;
use VDM\Joomla\Componentbuilder\Compiler\Service\Power;
use VDM\Joomla\Componentbuilder\Compiler\Service\JoomlaPower;
use VDM\Joomla\Componentbuilder\Compiler\Service\Component;
use VDM\Joomla\Componentbuilder\Compiler\Service\Adminview;
use VDM\Joomla\Componentbuilder\Compiler\Service\Library;
use VDM\Joomla\Componentbuilder\Compiler\Service\Customview;
use VDM\Joomla\Componentbuilder\Compiler\Service\Templatelayout;
use VDM\Joomla\Componentbuilder\Compiler\Service\Extension;
use VDM\Joomla\Componentbuilder\Service\CoreRules;
use VDM\Joomla\Componentbuilder\Compiler\Service\Field;
use VDM\Joomla\Componentbuilder\Compiler\Service\Joomlamodule;
use VDM\Joomla\Componentbuilder\Compiler\Service\Joomlaplugin;
use VDM\Joomla\Componentbuilder\Compiler\Service\Utilities;
use VDM\Joomla\Componentbuilder\Compiler\Service\BuilderAJ;
use VDM\Joomla\Componentbuilder\Compiler\Service\BuilderLZ;
use VDM\Joomla\Componentbuilder\Compiler\Service\Creator;
use VDM\Joomla\Componentbuilder\Compiler\Service\ArchitectureComponent;
use VDM\Joomla\Componentbuilder\Compiler\Service\ArchitectureModel;
use VDM\Joomla\Componentbuilder\Compiler\Service\ArchitectureView;
use VDM\Joomla\Componentbuilder\Compiler\Service\ArchitectureController;
use VDM\Joomla\Componentbuilder\Compiler\Service\ArchitectureDashboard;
use VDM\Joomla\Componentbuilder\Compiler\Service\ArchitectureModule;
use VDM\Joomla\Componentbuilder\Compiler\Service\ArchitecturePlugin;
use VDM\Joomla\Componentbuilder\Power\Service\Git;
use VDM\Joomla\Componentbuilder\Power\Service\Github;
use VDM\Joomla\Github\Service\Utilities as GithubUtilities;
use VDM\Joomla\Componentbuilder\Service\Gitea;
use VDM\Joomla\Gitea\Service\Utilities as GiteaUtilities;
use VDM\Joomla\Gitea\Service\Settings as GiteaSettings;
use VDM\Joomla\Gitea\Service\Organization as GiteaOrg;
use VDM\Joomla\Gitea\Service\User as GiteaUser;
use VDM\Joomla\Gitea\Service\Repository as GiteaRepo;
use VDM\Joomla\Gitea\Service\Package as GiteaPackage;
use VDM\Joomla\Gitea\Service\Issue as GiteaIssue;
use VDM\Joomla\Gitea\Service\Notifications as GiteNotifi;
use VDM\Joomla\Gitea\Service\Miscellaneous as GiteaMisc;
use VDM\Joomla\Gitea\Service\Admin as GiteaAdmin;
use VDM\Joomla\Componentbuilder\Package\Service\ComponentGet;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaPluginGet;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaModuleGet;
use VDM\Joomla\Componentbuilder\Package\Service\AdminViewGet;
use VDM\Joomla\Componentbuilder\Package\Service\CustomAdminViewGet;
use VDM\Joomla\Componentbuilder\Package\Service\SiteViewGet;
use VDM\Joomla\Componentbuilder\Package\Service\TemplateGet;
use VDM\Joomla\Componentbuilder\Package\Service\LayoutGet;
use VDM\Joomla\Componentbuilder\Package\Service\DynamicGet;
use VDM\Joomla\Componentbuilder\Package\Service\CustomCodeGet;
use VDM\Joomla\Componentbuilder\Package\Service\LibraryGet;
use VDM\Joomla\Componentbuilder\Package\Service\FieldGet;
use VDM\Joomla\Componentbuilder\Package\Service\DependenciesGet;
use VDM\Joomla\Interfaces\FactoryInterface;
use VDM\Joomla\Abstraction\Factory as ExtendingFactory;


/**
 * Compiler Factory
 * 
 * @since 3.2.0
 */
abstract class Factory extends ExtendingFactory implements FactoryInterface
{
	/**
	 * Package Container
	 *
	 * @var   Container|null
	 * @since 5.0.3
	 **/
	protected static ?Container $container = null;

	/**
	 * Unset the container (for a fresh start)
	 *
	 * @return  void
	 * @since  5.1.5
	 */
	public static function unset(): void
	{
		self::$container = null;
	}

	/**
	 * Get array of all keys in container
	 *
	 * @return  array
	 * @since 3.2.0
	 */
	public static function getKeys(): array
	{
		return self::getContainer()->getKeys();
	}

	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	protected static function createContainer(): Container
	{
		/**
		 * Ensure JPATH_COMPONENT_ADMINISTRATOR is defined. (YES I WILL)
		 *
		 * This constant is not guaranteed to exist in CLI or certain bootstrap paths.
		 * We safely derive it using JPATH_ADMINISTRATOR, which is always defined in Joomla.
		 *
		 * @since  5.1.4
		 */
		if (!defined('JPATH_COMPONENT_ADMINISTRATOR'))
		{
			define(
				'JPATH_COMPONENT_ADMINISTRATOR',
				JPATH_ADMINISTRATOR . '/components/com_componentbuilder'
			);
		}

		return (new Container())
			->registerServiceProvider(new Crypt())
			->registerServiceProvider(new Server())
			->registerServiceProvider(new Api())
			->registerServiceProvider(new Network())
			->registerServiceProvider(new Database())
			->registerServiceProvider(new BaseModel())
			->registerServiceProvider(new Data())
			->registerServiceProvider(new Model())
			->registerServiceProvider(new Compiler())
			->registerServiceProvider(new Event())
			->registerServiceProvider(new Header())
			->registerServiceProvider(new History())
			->registerServiceProvider(new Language())
			->registerServiceProvider(new Placeholder())
			->registerServiceProvider(new Customcode())
			->registerServiceProvider(new Package())
			->registerServiceProvider(new Power())
			->registerServiceProvider(new JoomlaPower())
			->registerServiceProvider(new Component())
			->registerServiceProvider(new Adminview())
			->registerServiceProvider(new Library())
			->registerServiceProvider(new Customview())
			->registerServiceProvider(new Templatelayout())
			->registerServiceProvider(new Extension())
			->registerServiceProvider(new CoreRules())
			->registerServiceProvider(new Field())
			->registerServiceProvider(new Joomlamodule())
			->registerServiceProvider(new Joomlaplugin())
			->registerServiceProvider(new Utilities())
			->registerServiceProvider(new BuilderAJ())
			->registerServiceProvider(new BuilderLZ())
			->registerServiceProvider(new Creator())
			->registerServiceProvider(new ArchitectureComponent())
			->registerServiceProvider(new ArchitectureModel())
			->registerServiceProvider(new ArchitectureView())
			->registerServiceProvider(new ArchitectureController())
			->registerServiceProvider(new ArchitectureDashboard())
			->registerServiceProvider(new ArchitectureModule())
			->registerServiceProvider(new ArchitecturePlugin())
			->registerServiceProvider(new Git())
			->registerServiceProvider(new Github())
			->registerServiceProvider(new GithubUtilities())
			->registerServiceProvider(new Gitea())
			->registerServiceProvider(new GiteaUtilities())
			->registerServiceProvider(new GiteaSettings())
			->registerServiceProvider(new GiteaOrg())
			->registerServiceProvider(new GiteaUser())
			->registerServiceProvider(new GiteaRepo())
			->registerServiceProvider(new GiteaPackage())
			->registerServiceProvider(new GiteaIssue())
			->registerServiceProvider(new GiteNotifi())
			->registerServiceProvider(new GiteaMisc())
			->registerServiceProvider(new GiteaAdmin())
			->registerServiceProvider(new ComponentGet())
			->registerServiceProvider(new JoomlaPluginGet())
			->registerServiceProvider(new JoomlaModuleGet())
			->registerServiceProvider(new AdminViewGet())
			->registerServiceProvider(new CustomAdminViewGet())
			->registerServiceProvider(new SiteViewGet())
			->registerServiceProvider(new TemplateGet())
			->registerServiceProvider(new LayoutGet())
			->registerServiceProvider(new DynamicGet())
			->registerServiceProvider(new CustomCodeGet())
			->registerServiceProvider(new LibraryGet())
			->registerServiceProvider(new FieldGet())
			->registerServiceProvider(new DependenciesGet());
	}
}

