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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Dashboard\ViewInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Dashboard\View as J6View;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Dashboard\View as J5View;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Dashboard\View as J4View;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Dashboard\View as J3View;


/**
 * Architecture Dashboard Service Provider
 * 
 * @since 5.1.5
 */
class ArchitectureDashboard implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var    int
	 * @since  5.1.5
	 **/
	protected $targetVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.1.5
	 */
	public function register(Container $container)
	{
		$container->alias(ViewInterface::class, 'Architecture.Dashboard.View')
			->share('Architecture.Dashboard.View', [$this, 'getViewInterface'], true);

		$container->alias(J6View::class, 'Architecture.Dashboard.J6.View')
			->share('Architecture.Dashboard.J6.View', [$this, 'getJ6View'], true);

		$container->alias(J5View::class, 'Architecture.Dashboard.J5.View')
			->share('Architecture.Dashboard.J5.View', [$this, 'getJ5View'], true);

		$container->alias(J4View::class, 'Architecture.Dashboard.J4.View')
			->share('Architecture.Dashboard.J4.View', [$this, 'getJ4View'], true);

		$container->alias(J3View::class, 'Architecture.Dashboard.J3.View')
			->share('Architecture.Dashboard.J3.View', [$this, 'getJ3View'], true);
	}

	/**
	 * Get The ViewInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ViewInterface
	 * @since   5.1.5
	 */
	public function getViewInterface(Container $container): ViewInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Dashboard.J' . $this->targetVersion . '.View');
	}

	/**
	 * Get The View Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6View
	 * @since   5.1.5
	 */
	public function getJ6View(Container $container): J6View
	{
		return new J6View(
			$container->get('Config'),
			$container->get('Component'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Utilities.Structure')
		);
	}

	/**
	 * Get The View Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5View
	 * @since   5.1.5
	 */
	public function getJ5View(Container $container): J5View
	{
		return new J5View(
			$container->get('Config'),
			$container->get('Component'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Utilities.Structure')
		);
	}

	/**
	 * Get The View Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4View
	 * @since   5.1.5
	 */
	public function getJ4View(Container $container): J4View
	{
		return new J4View(
			$container->get('Config'),
			$container->get('Component'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Utilities.Structure')
		);
	}

	/**
	 * Get The View Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3View
	 * @since   5.1.5
	 */
	public function getJ3View(Container $container): J3View
	{
		return new J3View(
			$container->get('Config'),
			$container->get('Component'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Utilities.Structure')
		);
	}
}

