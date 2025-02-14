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
use VDM\Joomla\Componentbuilder\Service\Crypt;
use VDM\Joomla\Componentbuilder\Package\Service\Database;
use VDM\Joomla\Componentbuilder\Service\Server;
use VDM\Joomla\Componentbuilder\Package\Service\Display;
use VDM\Joomla\Interfaces\FactoryInterface;
use VDM\Joomla\Abstraction\Factory as ExtendingFactory;


/**
 * Package Factory
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
	 * Create a container object
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	protected static function createContainer(): Container
	{
		return (new Container())
			->registerServiceProvider(new Database())
			->registerServiceProvider(new Crypt())
			->registerServiceProvider(new Server())
			->registerServiceProvider(new Display());
	}

}

