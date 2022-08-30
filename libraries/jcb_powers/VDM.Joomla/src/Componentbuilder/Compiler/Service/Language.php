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
use VDM\Joomla\Componentbuilder\Compiler\Language as CompilerLanguage;
use VDM\Joomla\Componentbuilder\Compiler\Language\Extractor;


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
			->share('Language', [$this, 'getLanguage'], true);

		$container->alias(Extractor::class, 'Language.Extractor')
			->share('Language.Extractor', [$this, 'getLanguageExtractor'], true);
	}

	/**
	 * Get the Compiler Language
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CompilerLanguage
	 * @since 3.2.0
	 */
	public function getLanguage(Container $container): CompilerLanguage
	{
		return new CompilerLanguage(
			$container->get('Config')
		);
	}

	/**
	 * Get the Compiler Language Extractor
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Extractor
	 * @since 3.2.0
	 */
	public function getLanguageExtractor(Container $container): Extractor
	{
		return new Extractor(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Placeholder')
		);
	}

}

