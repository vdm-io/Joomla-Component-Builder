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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CanDeleteInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Model\CanDelete as J4ModelCanDelete;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model\CanDelete as J3ModelCanDelete;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CanEditStateInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Model\CanEditState as J4ModelCanEditState;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model\CanEditState as J3ModelCanEditState;


/**
 * Architecture Model Service Provider
 * 
 * @since 3.2.0
 */
class ArchitectureModel implements ServiceProviderInterface
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
		$container->alias(J3ModelCanDelete::class, 'Architecture.Model.J3.CanDelete')
			->share('Architecture.Model.J3.CanDelete', [$this, 'getJ3ModelCanDelete'], true);

		$container->alias(J4ModelCanDelete::class, 'Architecture.Model.J4.CanDelete')
			->share('Architecture.Model.J4.CanDelete', [$this, 'getJ4ModelCanDelete'], true);

		$container->alias(CanDeleteInterface::class, 'Architecture.Model.CanDelete')
			->share('Architecture.Model.CanDelete', [$this, 'getModelCanDelete'], true);

		$container->alias(J3ModelCanEditState::class, 'Architecture.Model.J3.CanEditState')
			->share('Architecture.Model.J3.CanEditState', [$this, 'getJ3ModelCanEditState'], true);

		$container->alias(J4ModelCanEditState::class, 'Architecture.Model.J4.CanEditState')
			->share('Architecture.Model.J4.CanEditState', [$this, 'getJ4ModelCanEditState'], true);

		$container->alias(CanEditStateInterface::class, 'Architecture.Model.CanEditState')
			->share('Architecture.Model.CanEditState', [$this, 'getModelCanEditState'], true);
	}

	/**
	 * Get The Model CanDelete Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CanDeleteInterface
	 * @since 3.2.0
	 */
	public function getModelCanDelete(Container $container): CanDeleteInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Model.J' . $this->targetVersion . '.CanDelete');
	}

	/**
	 * Get The Model CanDelete Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4ModelCanDelete
	 * @since 3.2.0
	 */
	public function getJ4ModelCanDelete(Container $container): J4ModelCanDelete
	{
		return new J4ModelCanDelete(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The Model CanDelete Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3ModelCanDelete
	 * @since 3.2.0
	 */
	public function getJ3ModelCanDelete(Container $container): J3ModelCanDelete
	{
		return new J3ModelCanDelete(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The Model Can Edit State Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CanEditStateInterface
	 * @since 3.2.0
	 */
	public function getModelCanEditState(Container $container): CanEditStateInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Model.J' . $this->targetVersion . '.CanEditState');
	}

	/**
	 * Get The Model Can Edit State Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4ModelCanEditState
	 * @since 3.2.0
	 */
	public function getJ4ModelCanEditState(Container $container): J4ModelCanEditState
	{
		return new J4ModelCanEditState(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The Model Can Edit State Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3ModelCanEditState
	 * @since 3.2.0
	 */
	public function getJ3ModelCanEditState(Container $container): J3ModelCanEditState
	{
		return new J3ModelCanEditState(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
	}
}

