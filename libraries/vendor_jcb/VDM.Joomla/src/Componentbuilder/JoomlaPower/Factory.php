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

namespace VDM\Joomla\Componentbuilder\JoomlaPower;


use Joomla\DI\Container;
use VDM\Joomla\Componentbuilder\JoomlaPower\Service\JoomlaPower as Power;
use VDM\Joomla\Service\Database;
use VDM\Joomla\Service\Model;
use VDM\Joomla\Service\Data;
use VDM\Joomla\Componentbuilder\Service\Gitea;
use VDM\Joomla\Componentbuilder\Power\Service\Gitea as GiteaPower;
use VDM\Joomla\Gitea\Service\Utilities as GiteaUtilities;
use VDM\Joomla\Interfaces\FactoryInterface;
use VDM\Joomla\Abstraction\Factory as ExtendingFactory;


/**
 * Joomla Power Factory
 * 
 * @since 3.2.0
 */
abstract class Factory extends ExtendingFactory implements FactoryInterface
{
	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	protected static function createContainer(): Container
	{
		return (new Container())
			->registerServiceProvider(new Power())
			->registerServiceProvider(new Database())
			->registerServiceProvider(new Model())
			->registerServiceProvider(new Data())
			->registerServiceProvider(new Gitea())
			->registerServiceProvider(new GiteaPower())
			->registerServiceProvider(new GiteaUtilities());
	}
}

