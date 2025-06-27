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

namespace VDM\Joomla\Componentbuilder\Snippet;


use Joomla\DI\Container;
use VDM\Joomla\Componentbuilder\Snippet\Service\Snippet;
use VDM\Joomla\Componentbuilder\Package\Service\Power;
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
 * Snippet Power Factory
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
			->registerServiceProvider(new Snippet())
			->registerServiceProvider(new Power())
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

