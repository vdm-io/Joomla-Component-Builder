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
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\LibraryInterface as Library;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Module\Library as J6Library;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module\Library as J5Library;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Module\Library as J4Library;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module\Library as J3Library;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\TemplateInterface as Template;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Module\Template as J6Template;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module\Template as J5Template;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Module\Template as J4Template;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module\Template as J3Template;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\HelperInterface as Helper;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Module\Helper as J6Helper;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module\Helper as J5Helper;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Module\Helper as J4Helper;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module\Helper as J3Helper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\DispatcherInterface as Dispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Module\Dispatcher as J6Dispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module\Dispatcher as J5Dispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Module\Dispatcher as J4Dispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module\Dispatcher as J3Dispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\ProviderInterface as Provider;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Module\Provider as J6Provider;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module\Provider as J5Provider;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Module\Provider as J4Provider;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module\Provider as J3Provider;
use VDM\Joomla\Componentbuilder\Interfaces\Architecture\Module\MainXMLInterface as MainXML;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Module\MainXML as J6MainXML;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module\MainXML as J5MainXML;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Module\MainXML as J4MainXML;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module\MainXML as J3MainXML;


/**
 * Architecture Module Service Provider
 * 
 * @since 5.1.2
 */
class ArchitectureModule implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var    int
	 * @since  5.1.2
	 **/
	protected int $targetVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	public function register(Container $container)
	{
		$container->alias(Library::class, 'Architecture.Module.Library')
			->share('Architecture.Module.Library', [$this, 'getLibrary'], true);

		$container->alias(J6Library::class, 'Architecture.Module.J6.Library')
			->share('Architecture.Module.J6.Library', [$this, 'getJ6Library'], true);

		$container->alias(J5Library::class, 'Architecture.Module.J5.Library')
			->share('Architecture.Module.J5.Library', [$this, 'getJ5Library'], true);

		$container->alias(J4Library::class, 'Architecture.Module.J4.Library')
			->share('Architecture.Module.J4.Library', [$this, 'getJ4Library'], true);

		$container->alias(J3Library::class, 'Architecture.Module.J3.Library')
			->share('Architecture.Module.J3.Library', [$this, 'getJ3Library'], true);

		$container->alias(Template::class, 'Architecture.Module.Template')
			->share('Architecture.Module.Template', [$this, 'getTemplate'], true);

		$container->alias(J6Template::class, 'Architecture.Module.J6.Template')
			->share('Architecture.Module.J6.Template', [$this, 'getJ6Template'], true);

		$container->alias(J5Template::class, 'Architecture.Module.J5.Template')
			->share('Architecture.Module.J5.Template', [$this, 'getJ5Template'], true);

		$container->alias(J4Template::class, 'Architecture.Module.J4.Template')
			->share('Architecture.Module.J4.Template', [$this, 'getJ4Template'], true);

		$container->alias(J3Template::class, 'Architecture.Module.J3.Template')
			->share('Architecture.Module.J3.Template', [$this, 'getJ3Template'], true);

		$container->alias(Helper::class, 'Architecture.Module.Helper')
			->share('Architecture.Module.Helper', [$this, 'getHelper'], true);

		$container->alias(J6Helper::class, 'Architecture.Module.J6.Helper')
			->share('Architecture.Module.J6.Helper', [$this, 'getJ6Helper'], true);

		$container->alias(J5Helper::class, 'Architecture.Module.J5.Helper')
			->share('Architecture.Module.J5.Helper', [$this, 'getJ5Helper'], true);

		$container->alias(J4Helper::class, 'Architecture.Module.J4.Helper')
			->share('Architecture.Module.J4.Helper', [$this, 'getJ4Helper'], true);

		$container->alias(J3Helper::class, 'Architecture.Module.J3.Helper')
			->share('Architecture.Module.J3.Helper', [$this, 'getJ3Helper'], true);

		$container->alias(Dispatcher::class, 'Architecture.Module.Dispatcher')
			->share('Architecture.Module.Dispatcher', [$this, 'getDispatcher'], true);

		$container->alias(J6Dispatcher::class, 'Architecture.Module.J6.Dispatcher')
			->share('Architecture.Module.J6.Dispatcher', [$this, 'getJ6Dispatcher'], true);

		$container->alias(J5Dispatcher::class, 'Architecture.Module.J5.Dispatcher')
			->share('Architecture.Module.J5.Dispatcher', [$this, 'getJ5Dispatcher'], true);

		$container->alias(J4Dispatcher::class, 'Architecture.Module.J4.Dispatcher')
			->share('Architecture.Module.J4.Dispatcher', [$this, 'getJ4Dispatcher'], true);

		$container->alias(J3Dispatcher::class, 'Architecture.Module.J3.Dispatcher')
			->share('Architecture.Module.J3.Dispatcher', [$this, 'getJ3Dispatcher'], true);

		$container->alias(Provider::class, 'Architecture.Module.Provider')
			->share('Architecture.Module.Provider', [$this, 'getProvider'], true);

		$container->alias(J6Provider::class, 'Architecture.Module.J6.Provider')
			->share('Architecture.Module.J6.Provider', [$this, 'getJ6Provider'], true);

		$container->alias(J5Provider::class, 'Architecture.Module.J5.Provider')
			->share('Architecture.Module.J5.Provider', [$this, 'getJ5Provider'], true);

		$container->alias(J4Provider::class, 'Architecture.Module.J4.Provider')
			->share('Architecture.Module.J4.Provider', [$this, 'getJ4Provider'], true);

		$container->alias(J3Provider::class, 'Architecture.Module.J3.Provider')
			->share('Architecture.Module.J3.Provider', [$this, 'getJ3Provider'], true);

		$container->alias(MainXML::class, 'Architecture.Module.MainXML')
			->share('Architecture.Module.MainXML', [$this, 'getMainXML'], true);

		$container->alias(J6MainXML::class, 'Architecture.Module.J6.MainXML')
			->share('Architecture.Module.J6.MainXML', [$this, 'getJ6MainXML'], true);

		$container->alias(J5MainXML::class, 'Architecture.Module.J5.MainXML')
			->share('Architecture.Module.J5.MainXML', [$this, 'getJ5MainXML'], true);

		$container->alias(J4MainXML::class, 'Architecture.Module.J4.MainXML')
			->share('Architecture.Module.J4.MainXML', [$this, 'getJ4MainXML'], true);

		$container->alias(J3MainXML::class, 'Architecture.Module.J3.MainXML')
			->share('Architecture.Module.J3.MainXML', [$this, 'getJ3MainXML'], true);
	}

	/**
	 * Get The Library Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Library
	 * @since   5.1.2
	 */
	public function getLibrary(Container $container): Library
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Module.J' . $this->targetVersion . '.Library');
	}

	/**
	 * Get The Library Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Library
	 * @since   5.1.2
	 */
	public function getJ6Library(Container $container): J6Library
	{
		return new J6Library(
			$container->get('Compiler.Builder.Library.Manager'),
			$container->get('Library.Document'),
			$container->get('Registry'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Library Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Library
	 * @since   5.1.2
	 */
	public function getJ5Library(Container $container): J5Library
	{
		return new J5Library(
			$container->get('Compiler.Builder.Library.Manager'),
			$container->get('Library.Document'),
			$container->get('Registry'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Library Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Library
	 * @since   5.1.2
	 */
	public function getJ4Library(Container $container): J4Library
	{
		return new J4Library(
			$container->get('Compiler.Builder.Library.Manager'),
			$container->get('Library.Document'),
			$container->get('Registry'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Library Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Library
	 * @since   5.1.2
	 */
	public function getJ3Library(Container $container): J3Library
	{
		return new J3Library(
			$container->get('Compiler.Builder.Library.Manager'),
			$container->get('Library.Document'),
			$container->get('Registry'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Template Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Template
	 * @since   5.1.2
	 */
	public function getTemplate(Container $container): Template
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Module.J' . $this->targetVersion . '.Template');
	}

	/**
	 * Get The Template Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Template
	 * @since   5.1.2
	 */
	public function getJ6Template(Container $container): J6Template
	{
		return new J6Template(
			$container->get('Config'),
			$container->get('Header'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi')
		);
	}

	/**
	 * Get The Template Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Template
	 * @since   5.1.2
	 */
	public function getJ5Template(Container $container): J5Template
	{
		return new J5Template(
			$container->get('Config'),
			$container->get('Header'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi')
		);
	}

	/**
	 * Get The Template Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Template
	 * @since   5.1.2
	 */
	public function getJ4Template(Container $container): J4Template
	{
		return new J4Template(
			$container->get('Config'),
			$container->get('Header'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi')
		);
	}

	/**
	 * Get The Template Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Template
	 * @since   5.1.2
	 */
	public function getJ3Template(Container $container): J3Template
	{
		return new J3Template(
			$container->get('Config'),
			$container->get('Customcode.Dispenser'),
			$container->get('Compiler.Builder.Template.Data'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi')
		);
	}

	/**
	 * Get The Helper Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Helper
	 * @since   5.1.2
	 */
	public function getHelper(Container $container): Helper
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Module.J' . $this->targetVersion . '.Helper');
	}

	/**
	 * Get The Helper Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Helper
	 * @since   5.1.2
	 */
	public function getJ6Helper(Container $container): J6Helper
	{
		return new J6Helper(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Helper Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Helper
	 * @since   5.1.2
	 */
	public function getJ5Helper(Container $container): J5Helper
	{
		return new J5Helper(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Helper Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Helper
	 * @since   5.1.2
	 */
	public function getJ4Helper(Container $container): J4Helper
	{
		return new J4Helper(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Helper Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Helper
	 * @since   5.1.2
	 */
	public function getJ3Helper(Container $container): J3Helper
	{
		return new J3Helper(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Dispatcher Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Dispatcher
	 * @since   5.1.2
	 */
	public function getDispatcher(Container $container): Dispatcher
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Module.J' . $this->targetVersion . '.Dispatcher');
	}

	/**
	 * Get The Dispatcher Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Dispatcher
	 * @since   5.1.2
	 */
	public function getJ6Dispatcher(Container $container): J6Dispatcher
	{
		return new J6Dispatcher(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.Module.Library')
		);
	}

	/**
	 * Get The Dispatcher Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Dispatcher
	 * @since   5.1.2
	 */
	public function getJ5Dispatcher(Container $container): J5Dispatcher
	{
		return new J5Dispatcher(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.Module.Library')
		);
	}

	/**
	 * Get The Dispatcher Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Dispatcher
	 * @since   5.1.2
	 */
	public function getJ4Dispatcher(Container $container): J4Dispatcher
	{
		return new J4Dispatcher(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.Module.Library')
		);
	}

	/**
	 * Get The Dispatcher Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Dispatcher
	 * @since   5.1.2
	 */
	public function getJ3Dispatcher(Container $container): J3Dispatcher
	{
		return new J3Dispatcher(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.Module.Library')
		);
	}

	/**
	 * Get The ProviderInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Provider
	 * @since   5.1.2
	 */
	public function getProvider(Container $container): Provider
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Module.J' . $this->targetVersion . '.Provider');
	}

	/**
	 * Get The Provider Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6Provider
	 * @since   5.1.2
	 */
	public function getJ6Provider(Container $container): J6Provider
	{
		return new J6Provider(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Provider Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5Provider
	 * @since   5.1.2
	 */
	public function getJ5Provider(Container $container): J5Provider
	{
		return new J5Provider(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Provider Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4Provider
	 * @since   5.1.2
	 */
	public function getJ4Provider(Container $container): J4Provider
	{
		return new J4Provider(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The Provider Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3Provider
	 * @since   5.1.2
	 */
	public function getJ3Provider(Container $container): J3Provider
	{
		return new J3Provider(
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One')
		);
	}

	/**
	 * Get The MainXML Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  MainXML
	 * @since   5.1.2
	 */
	public function getMainXML(Container $container): MainXML
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.Module.J' . $this->targetVersion . '.MainXML');
	}

	/**
	 * Get The MainXML Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6MainXML
	 * @since   5.1.2
	 */
	public function getJ6MainXML(Container $container): J6MainXML
	{
		return new J6MainXML(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Language.Set'),
			$container->get('Language.Purge'),
			$container->get('Language.Translation'),
			$container->get('Language.Multilingual'),
			$container->get('Event'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Compiler.Builder.Multilingual'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.File')
		);
	}

	/**
	 * Get The MainXML Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5MainXML
	 * @since   5.1.2
	 */
	public function getJ5MainXML(Container $container): J5MainXML
	{
		return new J5MainXML(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Language.Set'),
			$container->get('Language.Purge'),
			$container->get('Language.Translation'),
			$container->get('Language.Multilingual'),
			$container->get('Event'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Compiler.Builder.Multilingual'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.File')
		);
	}

	/**
	 * Get The MainXML Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4MainXML
	 * @since   5.1.2
	 */
	public function getJ4MainXML(Container $container): J4MainXML
	{
		return new J4MainXML(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Language.Set'),
			$container->get('Language.Purge'),
			$container->get('Language.Translation'),
			$container->get('Language.Multilingual'),
			$container->get('Event'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Compiler.Builder.Multilingual'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.File')
		);
	}

	/**
	 * Get The MainXML Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3MainXML
	 * @since   5.1.2
	 */
	public function getJ3MainXML(Container $container): J3MainXML
	{
		return new J3MainXML(
			$container->get('Config'),
			$container->get('Language'),
			$container->get('Language.Set'),
			$container->get('Language.Purge'),
			$container->get('Language.Translation'),
			$container->get('Language.Multilingual'),
			$container->get('Event'),
			$container->get('Compiler.Creator.Fieldset.Extension'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Languages'),
			$container->get('Compiler.Builder.Multilingual'),
			$container->get('Utilities.Counter'),
			$container->get('Utilities.File')
		);
	}
}

