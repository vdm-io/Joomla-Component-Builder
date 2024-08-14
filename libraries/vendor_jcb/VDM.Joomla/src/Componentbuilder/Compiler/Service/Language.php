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
use VDM\Joomla\Componentbuilder\Compiler\Language\Set;
use VDM\Joomla\Componentbuilder\Compiler\Language\Purge;
use VDM\Joomla\Componentbuilder\Compiler\Language\Insert;
use VDM\Joomla\Componentbuilder\Compiler\Language\Update;
use VDM\Joomla\Componentbuilder\Compiler\Language\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Language\Fieldset;
use VDM\Joomla\Componentbuilder\Compiler\Language\Multilingual;
use VDM\Joomla\Componentbuilder\Compiler\Language\Translation;


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

		$container->alias(Set::class, 'Language.Set')
			->share('Language.Set', [$this, 'getSet'], true);

		$container->alias(Purge::class, 'Language.Purge')
			->share('Language.Purge', [$this, 'getPurge'], true);

		$container->alias(Insert::class, 'Language.Insert')
			->share('Language.Insert', [$this, 'getInsert'], true);

		$container->alias(Update::class, 'Language.Update')
			->share('Language.Update', [$this, 'getUpdate'], true);

		$container->alias(Extractor::class, 'Language.Extractor')
			->share('Language.Extractor', [$this, 'getExtractor'], true);

		$container->alias(Fieldset::class, 'Language.Fieldset')
			->share('Language.Fieldset', [$this, 'getFieldset'], true);

		$container->alias(Multilingual::class, 'Language.Multilingual')
			->share('Language.Multilingual', [$this, 'getMultilingual'], true);

		$container->alias(Translation::class, 'Language.Translation')
			->share('Language.Translation', [$this, 'getTranslation'], true);
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
	 * Get The Set Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Set
	 * @since 3.2.0
	 */
	public function getSet(Container $container): Set
	{
		return new Set(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Compiler.Builder.Multilingual'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Language.Insert'),
			$container->get('Language.Update')
		);
	}

	/**
	 * Get The Purge Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Purge
	 * @since   5.0.2
	 */
	public function getPurge(Container $container): Purge
	{
		return new Purge(
			$container->get('Language.Update')
		);
	}

	/**
	 * Get The Insert Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Insert
	 * @since   5.0.2
	 */
	public function getInsert(Container $container): Insert
	{
		return new Insert();
	}

	/**
	 * Get The Update Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Update
	 * @since   5.0.2
	 */
	public function getUpdate(Container $container): Update
	{
		return new Update();
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

	/**
	 * Get The Multilingual Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Multilingual
	 * @since   5.0.2
	 */
	public function getMultilingual(Container $container): Multilingual
	{
		return new Multilingual();
	}

	/**
	 * Get The Translation Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Translation
	 * @since 3.2.0
	 */
	public function getTranslation(Container $container): Translation
	{
		return new Translation(
			$container->get('Config'),
			$container->get('Compiler.Builder.Language.Messages')
		);
	}
}

