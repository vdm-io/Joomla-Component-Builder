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
use VDM\Joomla\Componentbuilder\Compiler\Service\Database;
use VDM\Joomla\Componentbuilder\Compiler\Service\Model;
use VDM\Joomla\Componentbuilder\Compiler\Service\Mapper;
use VDM\Joomla\Componentbuilder\Compiler\Service\Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Service\Event;
use VDM\Joomla\Componentbuilder\Compiler\Service\History;
use VDM\Joomla\Componentbuilder\Compiler\Service\Language;
use VDM\Joomla\Componentbuilder\Compiler\Service\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Service\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Service\Power;
use VDM\Joomla\Componentbuilder\Compiler\Service\Component;
use VDM\Joomla\Componentbuilder\Compiler\Service\Adminview;
use VDM\Joomla\Componentbuilder\Compiler\Service\Library;
use VDM\Joomla\Componentbuilder\Compiler\Service\Customview;
use VDM\Joomla\Componentbuilder\Compiler\Service\Templatelayout;
use VDM\Joomla\Componentbuilder\Compiler\Service\Extension;
use VDM\Joomla\Componentbuilder\Compiler\Service\Field;
use VDM\Joomla\Componentbuilder\Compiler\Service\Joomlamodule;
use VDM\Joomla\Componentbuilder\Compiler\Service\Joomlaplugin;
use VDM\Joomla\Componentbuilder\Compiler\Service\Utilities;
use VDM\Joomla\Componentbuilder\Compiler\Service\Builder;
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
use VDM\Joomla\Componentbuilder\Interfaces\FactoryInterface;


/**
 * Compiler Factory
 * 
 * @since 3.2.0
 */
abstract class Factory implements FactoryInterface
{
	/**
	 * Global Compiler Container
	 *
	 * @var     Container
	 * @since 3.2.0
	 **/
	protected static $container = null;

	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected static $JoomlaVersion;

	/**
	 * Get any class from the compiler container
	 *
	 * @param   string  $key  The container class key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public static function _($key)
	{
		return self::getContainer()->get($key);
	}

	/**
	 * Get version specific class from the compiler container
	 *
	 * @param   string  $key  The container class key
	 *
	 * @return  mixed
	 * @since 3.2.0
	 */
	public static function _J($key)
	{
		if (empty(self::$JoomlaVersion))
		{
			self::$JoomlaVersion = self::getContainer()->get('Config')->joomla_version;
		}

		return self::getContainer()->get('J' . self::$JoomlaVersion . '.' . $key);
	}

	/**
	 * Get the global compiler container
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	public static function getContainer(): Container
	{
		if (!self::$container)
		{
			self::$container = self::createContainer();
		}

		return self::$container;
	}

	/**
	 * Create a container object
	 *
	 * @return  Container
	 * @since 3.2.0
	 */
	protected static function createContainer(): Container
	{
		return (new Container())
			->registerServiceProvider(new Crypt())
			->registerServiceProvider(new Server())
			->registerServiceProvider(new Database())
			->registerServiceProvider(new Model())
			->registerServiceProvider(new Mapper())
			->registerServiceProvider(new Compiler())
			->registerServiceProvider(new Event())
			->registerServiceProvider(new History())
			->registerServiceProvider(new Language())
			->registerServiceProvider(new Placeholder())
			->registerServiceProvider(new Customcode())
			->registerServiceProvider(new Power())
			->registerServiceProvider(new Component())
			->registerServiceProvider(new Adminview())
			->registerServiceProvider(new Library())
			->registerServiceProvider(new Customview())
			->registerServiceProvider(new Templatelayout())
			->registerServiceProvider(new Extension())
			->registerServiceProvider(new Field())
			->registerServiceProvider(new Joomlamodule())
			->registerServiceProvider(new Joomlaplugin())
			->registerServiceProvider(new Utilities())
			->registerServiceProvider(new Builder())
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
			->registerServiceProvider(new GiteaAdmin());
	}

}

