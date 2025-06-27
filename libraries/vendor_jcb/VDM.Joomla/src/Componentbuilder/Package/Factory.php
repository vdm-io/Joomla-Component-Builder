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
use VDM\Joomla\Componentbuilder\Package\Service\Component;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaModule;
use VDM\Joomla\Componentbuilder\Package\Service\JoomlaPlugin;
use VDM\Joomla\Componentbuilder\Package\Service\AdminView;
use VDM\Joomla\Componentbuilder\Package\Service\CustomAdminView;
use VDM\Joomla\Componentbuilder\Package\Service\SiteView;
use VDM\Joomla\Componentbuilder\Package\Service\CustomCode;
use VDM\Joomla\Componentbuilder\Package\Service\DynamicGet;
use VDM\Joomla\Componentbuilder\Package\Service\Template;
use VDM\Joomla\Componentbuilder\Package\Service\Layout;
use VDM\Joomla\Componentbuilder\Package\Service\Library;
use VDM\Joomla\Componentbuilder\Package\Service\Field;
use VDM\Joomla\Componentbuilder\Package\Service\Power;
use VDM\Joomla\Componentbuilder\Package\Service\Dependencies;
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
			->registerServiceProvider(new Component())
			->registerServiceProvider(new JoomlaModule())
			->registerServiceProvider(new JoomlaPlugin())
			->registerServiceProvider(new AdminView())
			->registerServiceProvider(new SiteView())
			->registerServiceProvider(new CustomAdminView())
			->registerServiceProvider(new CustomCode())
			->registerServiceProvider(new DynamicGet())
			->registerServiceProvider(new Template())
			->registerServiceProvider(new Layout())
			->registerServiceProvider(new Library())
			->registerServiceProvider(new Field())
			->registerServiceProvider(new Power())
			->registerServiceProvider(new Dependencies())
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

