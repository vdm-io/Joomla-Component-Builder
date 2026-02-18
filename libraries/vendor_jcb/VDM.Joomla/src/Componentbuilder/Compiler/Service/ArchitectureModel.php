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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\AllowEditInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Model\AllowEdit as J6ModelAllowEdit;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Model\AllowEdit as J5ModelAllowEdit;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Model\AllowEdit as J4ModelAllowEdit;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model\AllowEdit as J3ModelAllowEdit;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CanDeleteInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Model\CanDelete as J6ModelCanDelete;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Model\CanDelete as J5ModelCanDelete;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Model\CanDelete as J4ModelCanDelete;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model\CanDelete as J3ModelCanDelete;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CanEditStateInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Model\CanEditState as J6ModelCanEditState;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Model\CanEditState as J5ModelCanEditState;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Model\CanEditState as J4ModelCanEditState;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model\CanEditState as J3ModelCanEditState;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CheckInNowInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Model\CheckInNow as J6CheckInNow;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Model\CheckInNow as J5CheckInNow;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Model\CheckInNow as J4CheckInNow;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Model\CheckInNow as J3CheckInNow;


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
		$container->alias(J3ModelAllowEdit::class, 'Architecture.Model.J3.AllowEdit')
			->share('Architecture.Model.J3.AllowEdit', [$this, 'getJ3ModelAllowEdit'], true);

		$container->alias(J4ModelAllowEdit::class, 'Architecture.Model.J4.AllowEdit')
			->share('Architecture.Model.J4.AllowEdit', [$this, 'getJ4ModelAllowEdit'], true);

		$container->alias(J5ModelAllowEdit::class, 'Architecture.Model.J5.AllowEdit')
			->share('Architecture.Model.J5.AllowEdit', [$this, 'getJ5ModelAllowEdit'], true);

		$container->alias(J6ModelAllowEdit::class, 'Architecture.Model.J6.AllowEdit')
			->share('Architecture.Model.J6.AllowEdit', [$this, 'getJ6ModelAllowEdit'], true);

		$container->alias(AllowEditInterface::class, 'Architecture.Model.AllowEdit')
			->share('Architecture.Model.AllowEdit', [$this, 'getModelAllowEdit'], true);

		$container->alias(J3ModelCanDelete::class, 'Architecture.Model.J3.CanDelete')
			->share('Architecture.Model.J3.CanDelete', [$this, 'getJ3ModelCanDelete'], true);

		$container->alias(J4ModelCanDelete::class, 'Architecture.Model.J4.CanDelete')
			->share('Architecture.Model.J4.CanDelete', [$this, 'getJ4ModelCanDelete'], true);

		$container->alias(J5ModelCanDelete::class, 'Architecture.Model.J5.CanDelete')
			->share('Architecture.Model.J5.CanDelete', [$this, 'getJ5ModelCanDelete'], true);

		$container->alias(J6ModelCanDelete::class, 'Architecture.Model.J6.CanDelete')
			->share('Architecture.Model.J6.CanDelete', [$this, 'getJ6ModelCanDelete'], true);

		$container->alias(CanDeleteInterface::class, 'Architecture.Model.CanDelete')
			->share('Architecture.Model.CanDelete', [$this, 'getModelCanDelete'], true);

		$container->alias(J3ModelCanEditState::class, 'Architecture.Model.J3.CanEditState')
			->share('Architecture.Model.J3.CanEditState', [$this, 'getJ3ModelCanEditState'], true);

		$container->alias(J4ModelCanEditState::class, 'Architecture.Model.J4.CanEditState')
			->share('Architecture.Model.J4.CanEditState', [$this, 'getJ4ModelCanEditState'], true);

		$container->alias(J5ModelCanEditState::class, 'Architecture.Model.J5.CanEditState')
			->share('Architecture.Model.J5.CanEditState', [$this, 'getJ5ModelCanEditState'], true);

		$container->alias(J6ModelCanEditState::class, 'Architecture.Model.J6.CanEditState')
			->share('Architecture.Model.J6.CanEditState', [$this, 'getJ6ModelCanEditState'], true);

		$container->alias(CanEditStateInterface::class, 'Architecture.Model.CanEditState')
			->share('Architecture.Model.CanEditState', [$this, 'getModelCanEditState'], true);

		$container->alias(CheckInNowInterface::class, 'Architecture.Model.CheckInNow')
			->share('Architecture.Model.CheckInNow', [$this, 'getCheckInNow'], true);

		$container->alias(J6CheckInNow::class, 'Architecture.Model.J6.CheckInNow')
			->share('Architecture.Model.J6.CheckInNow', [$this, 'getJ6CheckInNow'], true);

		$container->alias(J5CheckInNow::class, 'Architecture.Model.J5.CheckInNow')
			->share('Architecture.Model.J5.CheckInNow', [$this, 'getJ5CheckInNow'], true);

		$container->alias(J4CheckInNow::class, 'Architecture.Model.J4.CheckInNow')
			->share('Architecture.Model.J4.CheckInNow', [$this, 'getJ4CheckInNow'], true);

		$container->alias(J3CheckInNow::class, 'Architecture.Model.J3.CheckInNow')
			->share('Architecture.Model.J3.CheckInNow', [$this, 'getJ3CheckInNow'], true);
	}

	/**
	 * Get The AllowEdit Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AllowEditInterface
	 * @since   5.1.4
	 */
	public function getModelAllowEdit(Container $container): AllowEditInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Model.J' . $this->targetVersion . '.AllowEdit');
	}

	/**
	 * Get The AllowEdit Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6ModelAllowEdit
	 * @since   5.1.4
	 */
	public function getJ6ModelAllowEdit(Container $container): J6ModelAllowEdit
	{
		return new J6ModelAllowEdit(
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
	 * @return  J5ModelAllowEdit
	 * @since   5.1.4
	 */
	public function getJ5ModelAllowEdit(Container $container): J5ModelAllowEdit
	{
		return new J5ModelAllowEdit(
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
	 * @return  J4ModelAllowEdit
	 * @since   5.1.4
	 */
	public function getJ4ModelAllowEdit(Container $container): J4ModelAllowEdit
	{
		return new J4ModelAllowEdit(
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
	 * @return  J3ModelAllowEdit
	 * @since   5.1.4
	 */
	public function getJ3ModelAllowEdit(Container $container): J3ModelAllowEdit
	{
		return new J3ModelAllowEdit(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Customcode.Dispenser')
		);
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
	 * @return  J6ModelCanDelete
	 * @since   5.1.2
	 */
	public function getJ6ModelCanDelete(Container $container): J6ModelCanDelete
	{
		return new J6ModelCanDelete(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The Model CanDelete Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5ModelCanDelete
	 * @since 3.2.0
	 */
	public function getJ5ModelCanDelete(Container $container): J5ModelCanDelete
	{
		return new J5ModelCanDelete(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
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
	 * @return  J6ModelCanEditState
	 * @since  5.1.2
	 */
	public function getJ6ModelCanEditState(Container $container): J6ModelCanEditState
	{
		return new J6ModelCanEditState(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The Model Can Edit State Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5ModelCanEditState
	 * @since 3.2.0
	 */
	public function getJ5ModelCanEditState(Container $container): J5ModelCanEditState
	{
		return new J5ModelCanEditState(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission')
		);
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

	/**
	 * Get The Model CanDelete Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CheckInNowInterface
	 * @since   5.1.2
	 */
	public function getCheckInNow(Container $container): CheckInNowInterface
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Model.J' . $this->targetVersion . '.CheckInNow');
	}

	/**
	 * Get The Model CheckInNow Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6CheckInNow
	 * @since   5.1.2
	 */
	public function getJ6CheckInNow(Container $container): J6CheckInNow
	{
		return new J6CheckInNow();
	}


	/**
	 * Get The Model CheckInNow Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5CheckInNow
	 * @since   5.1.2
	 */
	public function getJ5CheckInNow(Container $container): J5CheckInNow
	{
		return new J5CheckInNow();
	}

	/**
	 * Get The Model CheckInNow Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4CheckInNow
	 * @since   5.1.2
	 */
	public function getJ4CheckInNow(Container $container): J4CheckInNow
	{
		return new J4CheckInNow();
	}

	/**
	 * Get The Model CheckInNow Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3CheckInNow
	 * @since   5.1.2
	 */
	public function getJ3CheckInNow(Container $container): J3CheckInNow
	{
		return new J3CheckInNow();
	}
}

