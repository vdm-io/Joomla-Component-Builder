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

namespace VDM\Joomla\Componentbuilder\Package;


use Joomla\DI\Container;
use VDM\Joomla\Componentbuilder\Package\Service\ComponentGet;
use VDM\Joomla\Componentbuilder\Package\Service\ComponentSet;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaModuleGet;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaModuleSet;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaPluginGet;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaPluginSet;
use VDM\Joomla\Componentbuilder\Package\Service\AdminViewGet;
use VDM\Joomla\Componentbuilder\Package\Service\AdminViewSet;
use VDM\Joomla\Componentbuilder\Package\Service\CustomAdminViewGet;
use VDM\Joomla\Componentbuilder\Package\Service\CustomAdminViewSet;
use VDM\Joomla\Componentbuilder\Package\Service\SiteViewGet;
use VDM\Joomla\Componentbuilder\Package\Service\SiteViewSet;
use VDM\Joomla\Componentbuilder\Package\Service\CustomCodeGet;
use VDM\Joomla\Componentbuilder\Package\Service\CustomCodeSet;
use VDM\Joomla\Componentbuilder\Package\Service\DynamicGet;
use VDM\Joomla\Componentbuilder\Package\Service\DynamicSet;
use VDM\Joomla\Componentbuilder\Package\Service\TemplateGet;
use VDM\Joomla\Componentbuilder\Package\Service\TemplateSet;
use VDM\Joomla\Componentbuilder\Package\Service\LayoutGet;
use VDM\Joomla\Componentbuilder\Package\Service\LayoutSet;
use VDM\Joomla\Componentbuilder\Package\Service\LibraryGet;
use VDM\Joomla\Componentbuilder\Package\Service\LibrarySet;
use VDM\Joomla\Componentbuilder\Package\Service\FieldGet;
use VDM\Joomla\Componentbuilder\Package\Service\FieldSet;
use VDM\Joomla\Componentbuilder\Package\Service\Power;
use VDM\Joomla\Componentbuilder\Package\Service\DependenciesGet;
use VDM\Joomla\Componentbuilder\Package\Service\DependenciesSet;
use VDM\Joomla\Componentbuilder\Package\Service\Package;
use VDM\Joomla\Service\Database;
use VDM\Joomla\Service\Model;
use VDM\Joomla\Service\Data;
use VDM\Joomla\Componentbuilder\Power\Service\Git;
use VDM\Joomla\Componentbuilder\Power\Service\Github;
use VDM\Joomla\Github\Service\Utilities as GithubUtilities;
use VDM\Joomla\Componentbuilder\Service\Gitea;
use VDM\Joomla\Componentbuilder\Power\Service\Gitea as GiteaPower;
use VDM\Joomla\Gitea\Service\Utilities as GiteaUtilities;
use VDM\Joomla\Componentbuilder\Service\Api;
use VDM\Joomla\Componentbuilder\Service\Network;
use VDM\Joomla\Componentbuilder\Service\Utilities;
use VDM\Joomla\Interfaces\FactoryInterface;
use VDM\Joomla\Abstraction\Factory as ExtendingFactory;


/**
 * Package Power Factory
 * 
 * @since 5.1.1
 */
abstract class Factory extends ExtendingFactory implements FactoryInterface
{
	/**
	 * Package Container
	 *
	 * @var   Container|null
	 * @since 5.1.1
	 **/
	protected static ?Container $container = null;

	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since  5.1.1
	 */
	protected static function createContainer(): Container
	{
		return (new Container())
			->registerServiceProvider(new ComponentGet())
			->registerServiceProvider(new ComponentSet())
			->registerServiceProvider(new JoomlaModuleGet())
			->registerServiceProvider(new JoomlaModuleSet())
			->registerServiceProvider(new JoomlaPluginGet())
			->registerServiceProvider(new JoomlaPluginSet())
			->registerServiceProvider(new AdminViewGet())
			->registerServiceProvider(new AdminViewSet())
			->registerServiceProvider(new SiteViewGet())
			->registerServiceProvider(new SiteViewSet())
			->registerServiceProvider(new CustomAdminViewGet())
			->registerServiceProvider(new CustomAdminViewSet())
			->registerServiceProvider(new CustomCodeGet())
			->registerServiceProvider(new CustomCodeSet())
			->registerServiceProvider(new DynamicGet())
			->registerServiceProvider(new DynamicSet())
			->registerServiceProvider(new TemplateGet())
			->registerServiceProvider(new TemplateSet())
			->registerServiceProvider(new LayoutGet())
			->registerServiceProvider(new LayoutSet())
			->registerServiceProvider(new LibraryGet())
			->registerServiceProvider(new LibrarySet())
			->registerServiceProvider(new FieldGet())
			->registerServiceProvider(new FieldSet())
			->registerServiceProvider(new Power())
			->registerServiceProvider(new DependenciesGet())
			->registerServiceProvider(new DependenciesSet())
			->registerServiceProvider(new Package())
			->registerServiceProvider(new Database())
			->registerServiceProvider(new Model())
			->registerServiceProvider(new Data())
			->registerServiceProvider(new Git())
			->registerServiceProvider(new Github())
			->registerServiceProvider(new GithubUtilities())
			->registerServiceProvider(new Gitea())
			->registerServiceProvider(new GiteaPower())
			->registerServiceProvider(new GiteaUtilities())
			->registerServiceProvider(new Api())
			->registerServiceProvider(new Network())
			->registerServiceProvider(new Utilities());
	}
}

