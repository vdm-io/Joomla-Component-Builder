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

namespace VDM\Joomla\Componentbuilder\Import;


use Joomla\DI\Container;
use VDM\Joomla\Service\Table;
use VDM\Joomla\Service\Database;
use VDM\Joomla\Service\Model;
use VDM\Joomla\Service\Data;
use VDM\Joomla\Componentbuilder\Import\Service\Import;
use VDM\Joomla\Componentbuilder\File\Service\File;
use VDM\Joomla\Componentbuilder\Service\Spreadsheet;
use VDM\Joomla\Interfaces\FactoryInterface;
use VDM\Joomla\Abstraction\Factory as ExtendingFactory;


/**
 * Import Factory
 * 
 * @since 3.2.2
 */
abstract class Factory extends ExtendingFactory implements FactoryInterface
{
	/**
	 * Global Package Container
	 *
	 * @var   Container|null
	 * @since 0.0.0
	 **/
	protected static ?Container $container = null;

	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since 3.2.2
	 */
	protected static function createContainer(): Container
	{
		return (new Container())
			->registerServiceProvider(new Table())
			->registerServiceProvider(new Database())
			->registerServiceProvider(new Model())
			->registerServiceProvider(new Data())
			->registerServiceProvider(new Import())
			->registerServiceProvider(new File())
			->registerServiceProvider(new Spreadsheet());
	}
}

