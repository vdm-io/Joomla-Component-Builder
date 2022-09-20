<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder as CompilerPlaceholder;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder\Reverse;


/**
 * Compiler Placeholder Service Provider
 * 
 * @since 3.2.0
 */
class Placeholder implements ServiceProviderInterface
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
		$container->alias(CompilerPlaceholder::class, 'Placeholder')
			->share('Placeholder', [$this, 'getPlaceholder'], true);

		$container->alias(Reverse::class, 'Placeholder.Reverse')
			->share('Placeholder.Reverse', [$this, 'getPlaceholderReverse'], true);
	}

	/**
	 * Get the Compiler Placeholder
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerPlaceholder
	 * @since 3.2.0
	 */
	public function getPlaceholder(Container $container): CompilerPlaceholder
	{
		return new CompilerPlaceholder(
			$container->get('Config')
		);
	}

	/**
	 * Get the Compiler Placeholder Reverse
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Worker
	 * @since 3.2.0
	 */
	public function getPlaceholderReverse(Container $container): Reverse
	{
		return new Reverse(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Language'),
			$container->get('Language.Extractor')
		);
	}
}

