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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowAddInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Controller\AllowAdd as J5ControllerAllowAdd;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Controller\AllowAdd as J4ControllerAllowAdd;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Controller\AllowAdd as J3ControllerAllowAdd;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowEditInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Controller\AllowEdit as J5ControllerAllowEdit;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Controller\AllowEdit as J4ControllerAllowEdit;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Controller\AllowEdit as J3ControllerAllowEdit;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowEditViewsInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Controller\AllowEditViews as J5ControllerAllowEditViews;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Controller\AllowEditViews as J4ControllerAllowEditViews;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Controller\AllowEditViews as J3ControllerAllowEditViews;


/**
 * Architecture Controller Service Provider
 * 
 * @since 3.2.0
 */
class ArchitectureController implements ServiceProviderInterface
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
		$container->alias(AllowAddInterface::class, 'Architecture.Controller.AllowAdd')
			->share('Architecture.Controller.AllowAdd', [$this, 'getAllowAdd'], true);

		$container->alias(J5ControllerAllowAdd::class, 'Architecture.Controller.J5.AllowAdd')
			->share('Architecture.Controller.J5.AllowAdd', [$this, 'getJ5ControllerAllowAdd'], true);

		$container->alias(J4ControllerAllowAdd::class, 'Architecture.Controller.J4.AllowAdd')
			->share('Architecture.Controller.J4.AllowAdd', [$this, 'getJ4ControllerAllowAdd'], true);

		$container->alias(J3ControllerAllowAdd::class, 'Architecture.Controller.J3.AllowAdd')
			->share('Architecture.Controller.J3.AllowAdd', [$this, 'getJ3ControllerAllowAdd'], true);

		$container->alias(AllowEditInterface::class, 'Architecture.Controller.AllowEdit')
			->share('Architecture.Controller.AllowEdit', [$this, 'getAllowEdit'], true);

		$container->alias(J5ControllerAllowEdit::class, 'Architecture.Controller.J5.AllowEdit')
			->share('Architecture.Controller.J5.AllowEdit', [$this, 'getJ5ControllerAllowEdit'], true);

		$container->alias(J4ControllerAllowEdit::class, 'Architecture.Controller.J4.AllowEdit')
			->share('Architecture.Controller.J4.AllowEdit', [$this, 'getJ4ControllerAllowEdit'], true);

		$container->alias(J3ControllerAllowEdit::class, 'Architecture.Controller.J3.AllowEdit')
			->share('Architecture.Controller.J3.AllowEdit', [$this, 'getJ3ControllerAllowEdit'], true);

		$container->alias(AllowEditViewsInterface::class, 'Architecture.Controller.AllowEditViews')
			->share('Architecture.Controller.AllowEditViews', [$this, 'getAllowEditViews'], true);

		$container->alias(J5ControllerAllowEditViews::class, 'Architecture.Controller.J5.AllowEditViews')
			->share('Architecture.Controller.J5.AllowEditViews', [$this, 'getJ5ControllerAllowEditViews'], true);

		$container->alias(J4ControllerAllowEditViews::class, 'Architecture.Controller.J4.AllowEditViews')
			->share('Architecture.Controller.J4.AllowEditViews', [$this, 'getJ4ControllerAllowEditViews'], true);

		$container->alias(J3ControllerAllowEditViews::class, 'Architecture.Controller.J3.AllowEditViews')
			->share('Architecture.Controller.J3.AllowEditViews', [$this, 'getJ3ControllerAllowEditViews'], true);
	}

	/**
	 * Get The AllowAddInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AllowAddInterface
	 * @since 3.2.0
	 */
	public function getAllowAdd(Container $container): AllowAddInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Controller.J' . $this->targetVersion . '.AllowAdd');
	}

	/**
	 * Get The AllowAdd Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5ControllerAllowAdd
	 * @since 3.2.0
	 */
	public function getJ5ControllerAllowAdd(Container $container): J5ControllerAllowAdd
	{
		return new J5ControllerAllowAdd(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get The AllowAdd Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4ControllerAllowAdd
	 * @since 3.2.0
	 */
	public function getJ4ControllerAllowAdd(Container $container): J4ControllerAllowAdd
	{
		return new J4ControllerAllowAdd(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser')
		);
	}

	/**
	 * Get The AllowAdd Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3ControllerAllowAdd
	 * @since 3.2.0
	 */
	public function getJ3ControllerAllowAdd(Container $container): J3ControllerAllowAdd
	{
		return new J3ControllerAllowAdd(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser')
		);
	}
	
		/**
	 * Get The AllowEditInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AllowEditInterface
	 * @since 3.2.0
	 */
	public function getAllowEdit(Container $container): AllowEditInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Controller.J' . $this->targetVersion . '.AllowEdit');
	}

	/**
	 * Get The AllowEdit Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5ControllerAllowEdit
	 * @since 3.2.0
	 */
	public function getJ5ControllerAllowEdit(Container $container): J5ControllerAllowEdit
	{
		return new J5ControllerAllowEdit(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}

	/**
	 * Get The AllowEdit Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4ControllerAllowEdit
	 * @since 3.2.0
	 */
	public function getJ4ControllerAllowEdit(Container $container): J4ControllerAllowEdit
	{
		return new J4ControllerAllowEdit(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}

	/**
	 * Get The AllowEdit Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3ControllerAllowEdit
	 * @since 3.2.0
	 */
	public function getJ3ControllerAllowEdit(Container $container): J3ControllerAllowEdit
	{
		return new J3ControllerAllowEdit(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}

	/**
	 * Get The AllowEditViewsInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AllowEditViewsInterface
	 * @since 5.0.2
	 */
	public function getAllowEditViews(Container $container): AllowEditViewsInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Controller.J' . $this->targetVersion . '.AllowEditViews');
	}

	/**
	 * Get The AllowEditViews Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5ControllerAllowEdit
	 * @since 5.0.2
	 */
	public function getJ5ControllerAllowEditViews(Container $container): J5ControllerAllowEditViews
	{
		return new J5ControllerAllowEditViews(
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}

	/**
	 * Get The AllowEditViews Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4ControllerAllowEditViews
	 * @since 5.0.2
	 */
	public function getJ4ControllerAllowEditViews(Container $container): J4ControllerAllowEditViews
	{
		return new J4ControllerAllowEditViews(
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}

	/**
	 * Get The AllowEditViews Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3ControllerAllowEditViews
	 * @since 5.0.2
	 */
	public function getJ3ControllerAllowEditViews(Container $container): J3ControllerAllowEditViews
	{
		return new J3ControllerAllowEditViews(
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Category'),
			$container->get('Compiler.Builder.Category.Other.Name')
		);
	}
}

