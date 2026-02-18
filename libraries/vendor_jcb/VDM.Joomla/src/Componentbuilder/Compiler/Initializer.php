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

namespace VDM\Joomla\Componentbuilder\Compiler;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode\ExtractorInterface as Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Power;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Component\Structure as ComponentStructure;
use VDM\Joomla\Componentbuilder\Compiler\Component\Structuresingle;
use VDM\Joomla\Componentbuilder\Compiler\Component\Structuremultiple;
use VDM\Joomla\Componentbuilder\Compiler\Component\Dashboard;
use VDM\Joomla\Componentbuilder\Compiler\Library\Structure as LibraryStructure;
use VDM\Joomla\Componentbuilder\Compiler\Power\Structure as PowerStructure;
use VDM\Joomla\Componentbuilder\Interfaces\Module\StructureInterface as ModuleStructure;
use VDM\Joomla\Componentbuilder\Interfaces\Plugin\StructureInterface as PluginStructure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Folder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;


/**
 * Compiler Initializer.
 * 
 * Responsible for fully preparing the compiler runtime environment:
 * - Application context
 * - Configuration sanity
 * - Language & helpers
 * - Version management
 * - Custom code extraction
 * - Utility power loading
 * - Filesystem cleanup
 * - Full component / plugin / module structure preparation
 * 
 * This class MUST run before any compiler execution.
 * 
 * @since 5.1.4
 */
final class Initializer
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.4
	 */
	protected Config $config;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 5.1.4
	 */
	protected Event $event;

	/**
	 * The Extractor Class.
	 *
	 * @var   Extractor
	 * @since 5.1.4
	 */
	protected Extractor $extractor;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 5.1.4
	 */
	protected Component $component;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 5.1.4
	 */
	protected Registry $registry;

	/**
	 * The Power Class.
	 *
	 * @var   Power
	 * @since 5.1.4
	 */
	protected Power $power;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.4
	 */
	protected ContentOne $contentone;

	/**
	 * The Structure Class.
	 *
	 * @var   ComponentStructure
	 * @since 5.1.4
	 */
	protected ComponentStructure $componentstructure;

	/**
	 * The Structuresingle Class.
	 *
	 * @var   Structuresingle
	 * @since 5.1.4
	 */
	protected Structuresingle $structuresingle;

	/**
	 * The Structuremultiple Class.
	 *
	 * @var   Structuremultiple
	 * @since 5.1.4
	 */
	protected Structuremultiple $structuremultiple;

	/**
	 * The Dashboard Class.
	 *
	 * @var   Dashboard
	 * @since 5.1.4
	 */
	protected Dashboard $dashboard;

	/**
	 * The Structure Class.
	 *
	 * @var   LibraryStructure
	 * @since 5.1.4
	 */
	protected LibraryStructure $librarystructure;

	/**
	 * The Structure Class.
	 *
	 * @var   PowerStructure
	 * @since 5.1.4
	 */
	protected PowerStructure $powerstructure;

	/**
	 * The StructureInterface Class.
	 *
	 * @var   ModuleStructure
	 * @since 5.1.4
	 */
	protected ModuleStructure $modulestructure;

	/**
	 * The StructureInterface Class.
	 *
	 * @var   PluginStructure
	 * @since 5.1.4
	 */
	protected PluginStructure $pluginstructure;

	/**
	 * The Folder Class.
	 *
	 * @var   Folder
	 * @since 5.1.4
	 */
	protected Folder $folder;

	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 5.1.4
	 */
	protected Paths $paths;

	/**
	 * Joomla application instance.
	 *
	 * @var    object
	 * @since 5.1.4
	 */
	protected $app;

	/**
	 * The switch to ensure we init only once.
	 *
	 * @var   int
	 * @since 5.1.4
	 */
	protected int $init = 0;

	/**
	 * Constructor.
	 *
	 * @param Config               $config               The Config Class.
	 * @param Event                $event                The EventInterface Class.
	 * @param Extractor            $extractor            The ExtractorInterface Class.
	 * @param Component            $component            The Component Class.
	 * @param Registry             $registry             The Registry Class.
	 * @param Power                $power                The Power Class.
	 * @param ContentOne           $contentone           The ContentOne Class.
	 * @param ComponentStructure   $componentstructure   The Structure Class.
	 * @param Structuresingle      $structuresingle      The Structuresingle Class.
	 * @param Structuremultiple    $structuremultiple    The Structuremultiple Class.
	 * @param Dashboard            $dashboard            The Dashboard Class.
	 * @param LibraryStructure     $librarystructure     The Structure Class.
	 * @param PowerStructure       $powerstructure       The Structure Class.
	 * @param ModuleStructure      $modulestructure      The StructureInterface Class.
	 * @param PluginStructure      $pluginstructure      The StructureInterface Class.
	 * @param Folder               $folder               The Folder Class.
	 * @param Paths                $paths                The Paths Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, Event $event, Extractor $extractor,
		Component $component, Registry $registry, Power $power,
		ContentOne $contentone,
		ComponentStructure $componentstructure,
		Structuresingle $structuresingle,
		Structuremultiple $structuremultiple,
		Dashboard $dashboard, LibraryStructure $librarystructure,
		PowerStructure $powerstructure,
		ModuleStructure $modulestructure,
		PluginStructure $pluginstructure, Folder $folder,
		Paths $paths)
	{
		$this->config = $config;
		$this->event = $event;
		$this->extractor = $extractor;
		$this->component = $component;
		$this->registry = $registry;
		$this->power = $power;
		$this->contentone = $contentone;
		$this->componentstructure = $componentstructure;
		$this->structuresingle = $structuresingle;
		$this->structuremultiple = $structuremultiple;
		$this->dashboard = $dashboard;
		$this->librarystructure = $librarystructure;
		$this->powerstructure = $powerstructure;
		$this->modulestructure = $modulestructure;
		$this->pluginstructure = $pluginstructure;
		$this->folder = $folder;
		$this->paths = $paths;
		$this->app = Factory::getApplication();
	}

	/**
	 * Trigger initialization compiler event.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	public function init(): void
	{
		// ensure we init only once
		if ($this->init === 1)
		{
			return;
		}
		$this->init = 1;

		$this->triggerBeforeGet();

		$this->initializeLanguageTag();
		$this->initializeFieldBuilderType();

		$this->extractCustomCode();

		$this->buildComponent();

		$this->ensureComponentVersion();
		$this->updateComponentVersionIfNeeded();

		$this->resetBuildDirectory();

		$this->loadUtilityPowers();

		$this->triggerAfterGet();

		$this->initializeStructureDefaults();
		$this->buildExternalStructures();
		$this->buildComponentStructure();
	}

	/**
	 * Trigger pre-initialization compiler event.
	 *
	 * @param   array  $config
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function triggerBeforeGet(): void
	{
		$this->event->trigger('jcb_ce_onBeforeGet');
	}

	/**
	 * Set language tag for helper safe strings.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function initializeLanguageTag(): void
	{
		ComponentbuilderHelper::$langTag =
			$this->config->get('lang_tag', 'en-GB');
	}

	/**
	 * Resolve and validate field builder strategy.
	 *
	 * Falls back to string manipulation if Tidy is unavailable.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function initializeFieldBuilderType(): void
	{
		$fieldBuilderType = (int) $this->config->get('field_builder_type', 2);

		if (!$this->config->get('tidy', false) && $fieldBuilderType === 2)
		{
			$fieldBuilderType = 1;
			$this->enqueueTidyFallbackNotice();
		}

		$this->config->set('field_builder_type', $fieldBuilderType);
	}

	/**
	 * Notify user of Tidy fallback behavior.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function enqueueTidyFallbackNotice(): void
	{
		$this->app->enqueueMessage(
			Text::_('COM_COMPONENTBUILDER_HR_HTHREEFIELD_NOTICEHTHREE'), 'Notice'
		);

		$this->app->enqueueMessage(
			Text::_('COM_COMPONENTBUILDER_SINCE_YOU_DO_NOT_HAVE_BTIDYB_EXTENSION_SETUP_ON_YOUR_SYSTEM_WE_COULD_NOT_USE_THE_SIMPLEXMLELEMENT_CLASS_WE_INSTEAD_USED_BSTRING_MANIPULATIONB_TO_BUILD_ALL_YOUR_FIELDS_THIS_IS_A_FASTER_METHOD_YOU_MUST_INSPECT_THE_XML_FILES_IN_YOUR_COMPONENT_PACKAGE_TO_SEE_IF_YOU_ARE_SATISFIED_WITH_THE_RESULTBR_YOU_CAN_MAKE_THIS_METHOD_YOUR_DEFAULT_BY_OPENING_THE_GLOBAL_OPTIONS_OF_JCB_AND_UNDER_THE_BGLOBALB_TAB_SET_THE_BFIELD_BUILDER_TYPEB_TO_STRING_MANIPULATION'),
			'Notice'
		);
	}

	/**
	 * Extract installed custom code snippets.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function extractCustomCode(): void
	{
		$this->extractor->run();
	}

	/**
	 * Ensure component is build right now.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function buildComponent(): void
	{
		$this->component->build();
	}

	/**
	 * Ensure component version exists.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function ensureComponentVersion(): void
	{
		if (strpos((string) $this->component->component_version, '.') === false)
		{
			$this->component->set('component_version', '1.0.0');
		}
	}

	/**
	 * Increment component version when SQL changes are detected.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function updateComponentVersionIfNeeded(): void
	{
		if (
			!$this->component->exists('old_component_version')
			&& (
				$this->registry->get('builder.add_sql')
				|| $this->registry->get('builder.update_sql')
			)
		)
		{
			$version = explode('.', (string) $this->component->component_version);
			$version[count($version) - 1]++;

			$this->component->set(
				'old_component_version',
				$this->component->component_version
			);

			$this->component->set(
				'component_version',
				implode('.', $version)
			);
		}
	}

	/**
	 * Load all required utility powers.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function loadUtilityPowers(): void
	{
		$this->power->get('1f28cb53-60d9-4db1-b517-3c7dc6b429ef', 1);
		$this->power->get('0a59c65c-9daf-4bc9-baf4-e063ff9e6a8a', 1);
		$this->power->get('640b5352-fb09-425f-a26e-cd44eda03f15', 1);
		$this->power->get('91004529-94a9-4590-b842-e7c6b624ecf5', 1);
		$this->power->get('db87c339-5bb6-4291-a7ef-2c48ea1b06bc', 1);
		$this->power->get('4b225c51-d293-48e4-b3f6-5136cf5c3f18', 1);
		$this->power->get('1198aecf-84c6-45d2-aea8-d531aa4afdfa', 1);
	}

	/**
	 * Initialize default structure placeholders.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function initializeStructureDefaults(): void
	{
		$this->contentone->set('EXSTRA_ADMIN_FOLDERS', '');
		$this->contentone->set('EXSTRA_SITE_FOLDERS', '');
		$this->contentone->set('EXSTRA_MEDIA_FOLDERS', '');
		$this->contentone->set('EXSTRA_ADMIN_FILES', '');
		$this->contentone->set('EXSTRA_SITE_FILES', '');
		$this->contentone->set('EXSTRA_MEDIA_FILES', '');
	}

	/**
	 * Remove any previous build artifacts.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function resetBuildDirectory(): void
	{
		$this->folder->remove($this->paths->component_path);
	}

	/**
	 * Build all external extension structures.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function buildExternalStructures(): void
	{
		$this->librarystructure->build();
		$this->powerstructure->build();
		$this->modulestructure->build();
		$this->pluginstructure->build();

		$this->dashboard->set();
	}

	/**
	 * Build full component filesystem structure.
	 *
	 * @throws \RuntimeException
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function buildComponentStructure(): void
	{
		if (!$this->componentstructure->build())
		{
			throw new \RuntimeException('Failed to build component base structure.');
		}

		if (!$this->structuresingle->build())
		{
			throw new \RuntimeException('Failed to build single-instance structure.');
		}

		if (!$this->structuremultiple->build())
		{
			throw new \RuntimeException('Failed to build dynamic structure.');
		}
	}

	/**
	 * Trigger post-initialization compiler event.
	 *
	 * @return void
	 * @since 5.1.4
	 */
	protected function triggerAfterGet(): void
	{
		$this->event->trigger('jcb_ce_onAfterGet');
	}
}

