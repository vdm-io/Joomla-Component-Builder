<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Customcode as CompilerCustomcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\External;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Hash;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\LockBase;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Extractor\Paths;


/**
 * Compiler Custom Code Service Provider
 * 
 * @since 3.2.0
 */
class Customcode implements ServiceProviderInterface
{
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
		$container->alias(CompilerCustomcode::class, 'Customcode')
			->share('Customcode', [$this, 'getCustomcode'], true);

		$container->alias(External::class, 'Customcode.External')
			->share('Customcode.External', [$this, 'getExternal'], true);

		$container->alias(Gui::class, 'Customcode.Gui')
			->share('Customcode.Gui', [$this, 'getGui'], true);

		$container->alias(Hash::class, 'Customcode.Hash')
			->share('Customcode.Hash', [$this, 'getHash'], true);

		$container->alias(LockBase::class, 'Customcode.LockBase')
			->share('Customcode.LockBase', [$this, 'getLockBase'], true);

		$container->alias(Dispenser::class, 'Customcode.Dispenser')
			->share('Customcode.Dispenser', [$this, 'getDispenser'], true);

		$container->alias(Paths::class, 'Customcode.Extractor.Paths')
			->share('Customcode.Extractor.Paths', [$this, 'getPaths'], true);

		$container->alias(Extractor::class, 'Customcode.Extractor')
			->share('Customcode.Extractor', [$this, 'getExtractor'], true);
	}

	/**
	 * Get the Compiler Customcode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerCustomcode
	 * @since 3.2.0
	 */
	public function getCustomcode(Container $container): CompilerCustomcode
	{
		return new CompilerCustomcode(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Language.Extractor'),
			$container->get('Customcode.External')
		);
	}

	/**
	 * Get the Compiler Customcode External
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  External
	 * @since 3.2.0
	 */
	public function getExternal(Container $container): External
	{
		return new External(
			$container->get('Placeholder')
		);
	}

	/**
	 * Get the Compiler Customcode Gui
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Gui
	 * @since 3.2.0
	 */
	public function getGui(Container $container): Gui
	{
		return new Gui(
			$container->get('Config'),
			$container->get('Placeholder.Reverse')
		);
	}

	/**
	 * Get the Customcode Hash
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Hash
	 * @since 3.2.0
	 */
	public function getHash(Container $container): Hash
	{
		return new Hash(
			$container->get('Placeholder')
		);
	}

	/**
	 * Get the Customcode LockBase64
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LockBase
	 * @since 3.2.0
	 */
	public function getLockBase(Container $container): LockBase
	{
		return new LockBase(
			$container->get('Placeholder')
		);
	}

	/**
	 * Get the Customcode Dispenser
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Dispenser
	 * @since 3.2.0
	 */
	public function getDispenser(Container $container): Dispenser
	{
		return new Dispenser(
			$container->get('Placeholder'),
			$container->get('Customcode'),
			$container->get('Customcode.Gui'),
			$container->get('Customcode.Hash'),
			$container->get('Customcode.LockBase')
		);
	}

	/**
	 * Get the Customcode Extractor Paths
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Paths
	 * @since 3.2.0
	 */
	public function getPaths(Container $container): Paths
	{
		return new Paths(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Component.Placeholder'),
			$container->get('Customcode'),
			$container->get('Language.Extractor')
		);
	}

	/**
	 * Get the Customcode Extractor
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Extractor
	 * @since 3.2.0
	 */
	public function getExtractor(Container $container): Extractor
	{
		return new Extractor(
			$container->get('Config'),
			$container->get('Customcode.Gui'),
			$container->get('Customcode.Extractor.Paths'),
			$container->get('Placeholder.Reverse'),
			$container->get('Component.Placeholder')
		);
	}

}

