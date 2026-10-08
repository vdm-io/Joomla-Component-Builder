<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion;


use Joomla\DI\Container;
use VDM\Joomla\Abstraction\Factory as ExtendingFactory;
use VDM\Joomla\Componentbuilder\Extrusion\Service\Discovery;
use VDM\Joomla\Componentbuilder\Extrusion\Service\Extrusion;
use VDM\Joomla\Componentbuilder\Extrusion\Service\Powers;
use VDM\Joomla\Componentbuilder\Extrusion\Service\Reader;
use VDM\Joomla\Componentbuilder\Extrusion\Service\Registry;
use VDM\Joomla\Componentbuilder\Extrusion\Service\Resolver;
use VDM\Joomla\Componentbuilder\Extrusion\Service\Writer;
use VDM\Joomla\Service\Data;
use VDM\Joomla\Service\Database;
use VDM\Joomla\Service\Model;
use VDM\Joomla\Service\Table;
use VDM\Joomla\Interfaces\FactoryInterface;


/**
 * Extrusion Factory
 * 
 * The composition entry point for the extrusion engine. Resolving the Extruder
 * from here is the only permitted static resolution: every class below it takes
 * its collaborators by constructor injection, and the providers are the only
 * place a collaborator is constructed.
 * 
 * The JCB data pipeline is composed in as well, because writing goes through it
 * rather than around it.
 * 
 * @since 6.1.6
 */
abstract class Factory extends ExtendingFactory implements FactoryInterface
{
	/**
	 * Package Container
	 *
	 * @var   Container|null
	 * @since 6.1.6
	 **/
	protected static ?Container $container = null;

	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since   6.1.6
	 */
	protected static function createContainer(): Container
	{
		return (new Container())
			->registerServiceProvider(new Database())
			->registerServiceProvider(new Table())
			->registerServiceProvider(new Model())
			->registerServiceProvider(new Data())
			->registerServiceProvider(new Registry())
			->registerServiceProvider(new Discovery())
			->registerServiceProvider(new Reader())
			->registerServiceProvider(new Resolver())
			->registerServiceProvider(new Writer())
			->registerServiceProvider(new Powers())
			->registerServiceProvider(new Extrusion());
	}
}

