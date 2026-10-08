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
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Language\Admin as ArchitectureLanguageAdmin;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Language\Site as ArchitectureLanguageSite;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Language\SiteSys as ArchitectureLanguageSiteSys;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Language\AdminSys as ArchitectureLanguageAdminSys;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Language\Files as ArchitectureLanguageFiles;


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

		$container->alias(ArchitectureLanguageFiles::class, 'Architecture.Language.Files')
			->share('Architecture.Language.Files', [$this, 'getArchitectureLanguageFiles'], true);

		$container->alias(ArchitectureLanguageAdmin::class, 'Architecture.Language.Admin')
			->share('Architecture.Language.Admin', [$this, 'getArchitectureLanguageAdmin'], true);

		$container->alias(ArchitectureLanguageSite::class, 'Architecture.Language.Site')
			->share('Architecture.Language.Site', [$this, 'getArchitectureLanguageSite'], true);

		$container->alias(ArchitectureLanguageSiteSys::class, 'Architecture.Language.SiteSys')
			->share('Architecture.Language.SiteSys', [$this, 'getArchitectureLanguageSiteSys'], true);

		$container->alias(ArchitectureLanguageAdminSys::class, 'Architecture.Language.AdminSys')
			->share('Architecture.Language.AdminSys', [$this, 'getArchitectureLanguageAdminSys'], true);
	}

	/**
	 * Get The Architecture Language Files Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ArchitectureLanguageFiles
	 * @since   6.1.7
	 */
	public function getArchitectureLanguageFiles(Container $container): ArchitectureLanguageFiles
	{
		return new ArchitectureLanguageFiles(
			$container->get('Config'),
			$container->get('Component'),
			$container->get('Event'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Compiler.Builder.Multilingual'),
			$container->get('Language.Multilingual'),
			$container->get('Language.Set'),
			$container->get('Language.Purge'),
			$container->get('Language.Translation'),
			$container->get('Architecture.Language.Admin'),
			$container->get('Architecture.Language.AdminSys'),
			$container->get('Architecture.Language.Site'),
			$container->get('Architecture.Language.SiteSys'),
			$container->get('Utilities.Paths'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.File'),
			$container->get('Placeholder')
		);
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
			$container->get('Language.Update'),
			$container->get('Joomla.Database')
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
		return new Insert(
			$container->get('Joomla.Database')
		);
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
		return new Update(
			$container->get('Joomla.Database')
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
		return new Multilingual(
			$container->get('Joomla.Database')
		);
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

	/**
	 * Get The Architecture Language Admin Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ArchitectureLanguageAdmin
	 * @since   6.1.7
	 */
	public function getArchitectureLanguageAdmin(Container $container): ArchitectureLanguageAdmin
	{
		return new ArchitectureLanguageAdmin(
			$container->get('Config'),
			$container->get('Component'),
			$container->get('Language'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Event')
		);
	}
	/**
	 * Get The Architecture Language Site Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ArchitectureLanguageSite
	 * @since   6.1.7
	 */
	public function getArchitectureLanguageSite(Container $container): ArchitectureLanguageSite
	{
		return new ArchitectureLanguageSite(
			$container->get('Config'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Language'),
			$container->get('Event')
		);
	}

	/**
	 * Get The Architecture Language SiteSys Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ArchitectureLanguageSiteSys
	 * @since   6.1.7
	 */
	public function getArchitectureLanguageSiteSys(Container $container): ArchitectureLanguageSiteSys
	{
		return new ArchitectureLanguageSiteSys(
			$container->get('Config'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Language'),
			$container->get('Event')
		);
	}

	/**
	 * Get The Architecture Language AdminSys Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ArchitectureLanguageAdminSys
	 * @since   6.1.7
	 */
	public function getArchitectureLanguageAdminSys(Container $container): ArchitectureLanguageAdminSys
	{
		return new ArchitectureLanguageAdminSys(
			$container->get('Config'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Language'),
			$container->get('Event')
		);
	}
}

