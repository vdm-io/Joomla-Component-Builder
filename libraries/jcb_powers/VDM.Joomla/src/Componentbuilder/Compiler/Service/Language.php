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
use VDM\Joomla\Componentbuilder\Compiler\Language as CompilerLanguage;
use VDM\Joomla\Componentbuilder\Compiler\Language\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Language\Fieldset;


/**
 * Compiler Language Service Provider
 * 
 * @since 3.2.0
 */
class Language implements ServiceProviderInterface
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
		$container->alias(CompilerLanguage::class, 'Language')
			->share('Language', [$this, 'getCompilerLanguage'], true);

		$container->alias(Extractor::class, 'Language.Extractor')
			->share('Language.Extractor', [$this, 'getExtractor'], true);

		$container->alias(Fieldset::class, 'Language.Fieldset')
			->share('Language.Fieldset', [$this, 'getFieldset'], true);
	}

	/**
	 * Get The Language Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerLanguage
	 * @since 3.2.0
	 */
	public function getCompilerLanguage(Container $container): CompilerLanguage
	{
		return new CompilerLanguage(
			$container->get('Config')
		);
	}

	/**
	 * Get The Extractor Class.
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
			$container->get('Language'),
			$container->get('Placeholder')
		);
	}

	/**
	 * Get The Fieldset Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Fieldset
	 * @since 3.2.0
	 */
	public function getFieldset(Container $container): Fieldset
	{
		return new Fieldset(
			$container->get('Language'),
			$container->get('Compiler.Builder.Meta.Data'),
			$container->get('Compiler.Builder.Access.Switch'),
			$container->get('Compiler.Builder.Access.Switch.List')
		);
	}
}

