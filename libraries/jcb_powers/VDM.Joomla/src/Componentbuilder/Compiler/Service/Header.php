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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaThree\Header as J3Header;
use VDM\Joomla\Componentbuilder\Compiler\JoomlaFour\Header as J4Header;


/**
 * Header Service Provider
 * 
 * @since 3.2.0
 */
class Header implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var     int
	 * @since 3.2.0
	 **/
	protected $targetVersion;

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
		$container->alias(J3Header::class, 'J3.Header')
			->share('J3.Header', [$this, 'getJ3Header'], true);

		$container->alias(J4Header::class, 'J4.Header')
			->share('J4.Header', [$this, 'getJ4Header'], true);

		$container->alias(HeaderInterface::class, 'Header')
			->share('Header', [$this, 'getHeader'], true);
	}

	/**
	 * Get the Header
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  HeaderInterface
	 * @since 3.2.0
	 */
	public function getHeader(Container $container): HeaderInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('J' . $this->targetVersion . '.Header');
	}

	/**
	 * Get The Header Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Header
	 * @since 3.2.0
	 */
	public function getJ3Header(Container $container): J3Header
	{
		return new J3Header(
			$container->get('Config'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Compiler.Builder.Uikit.Comp'),
			$container->get('Compiler.Builder.Admin.Filter.Type'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Access.Switch.List'),
			$container->get('Compiler.Builder.Filter'),
			$container->get('Compiler.Builder.Tags')
		);
	}

	/**
	 * Get The Header Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Header
	 * @since 3.2.0
	 */
	public function getJ4Header(Container $container): J4Header
	{
		return new J4Header(
			$container->get('Config'),
			$container->get('Event'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Compiler.Builder.Uikit.Comp'),
			$container->get('Compiler.Builder.Admin.Filter.Type'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Access.Switch.List'),
			$container->get('Compiler.Builder.Filter'),
			$container->get('Compiler.Builder.Tags')
		);
	}
}

