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

namespace VDM\Joomla\Componentbuilder;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\Filesystem\File as JoomlaFile;
use Joomla\Filesystem\Folder as JoomlaFolder;
use VDM\Joomla\Componentbuilder\Compiler\Initializer;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Server;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\FilePaths;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\ModuleDataInterface as ModuleData;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\PluginDataInterface as PluginData;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode\ExternalInterface as CustomcodeExternal;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Language\ExtractorInterface as LanguageExtractor;
use VDM\Joomla\Componentbuilder\Compiler\Extension\Files\Updater;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Folder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\FileInjector;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LanguageMessages;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\MathHelper;
use VDM\Joomla\Componentbuilder\Compiler\Helper\Infusion;


/**
 *  Compiler Finalization and Packaging Handler.
 * 
 * Orchestrates the final compilation phase:
 * - File updates
 * - Custom code injection
 * - Language processing
 * - XML server publishing
 * - Repository syncing
 * - ZIP packaging (component, modules, plugins)
 * - Backup handling
 * - User notices
 * 
 * @since 5.1.4
 */
final class Compiler extends Infusion
{
	/**
	 * The Initializer Class.
	 *
	 * @var   Initializer
	 * @since 5.1.4
	 */
	protected Initializer $initializer;

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
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.4
	 */
	protected Placeholder $placeholder;

	/**
	 * The Server Class.
	 *
	 * @var   Server
	 * @since 5.1.4
	 */
	protected Server $server;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 5.1.4
	 */
	protected Component $component;

	/**
	 * The FilePaths Class.
	 *
	 * @var   FilePaths
	 * @since 5.1.4
	 */
	protected FilePaths $filepaths;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.4
	 */
	protected ContentOne $contentone;

	/**
	 * The ModuleData Class.
	 *
	 * @var   ModuleData
	 * @since 5.1.4
	 */
	protected ModuleData $moduledata;

	/**
	 * The PluginData Class.
	 *
	 * @var   PluginData
	 * @since 5.1.4
	 */
	protected PluginData $plugindata;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 5.1.4
	 */
	protected Customcode $customcode;

	/**
	 * The External Class.
	 *
	 * @var   CustomcodeExternal
	 * @since 5.1.4
	 */
	protected CustomcodeExternal $customcodeexternal;

	/**
	 * The Extractor Class.
	 *
	 * @var   LanguageExtractor
	 * @since 5.1.4
	 */
	protected LanguageExtractor $languageextractor;

	/**
	 * The Updater Class.
	 *
	 * @var   Updater
	 * @since 5.1.4
	 */
	protected Updater $updater;

	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 5.1.4
	 */
	protected Paths $paths;

	/**
	 * The File Class.
	 *
	 * @var   File
	 * @since 5.1.4
	 */
	protected File $file;

	/**
	 * The Files Class.
	 *
	 * @var   Files
	 * @since 5.1.4
	 */
	protected Files $files;

	/**
	 * The Folder Class.
	 *
	 * @var   Folder
	 * @since 5.1.4
	 */
	protected Folder $folder;

	/**
	 * The FileInjector Class.
	 *
	 * @var   FileInjector
	 * @since 5.1.4
	 */
	protected FileInjector $fileinjector;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 5.1.4
	 */
	protected Counter $counter;

	/**
	 * The LanguageMessages Class.
	 *
	 * @var   LanguageMessages
	 * @since 5.1.4
	 */
	protected LanguageMessages $languagemessages;

	/**
	 * The app
	 *
	 * @var     object
	 * @since 5.1.4
	 */
	// protected $app;

	/**
	 * The Temp path.
	 *
	 * @var      string
	 * @since    3.0.0
	 */
	protected $tempPath;

	/**
	 * Flag indicating that dynamic integrations are enabled (backup/server moves, etc.).
	 *
	 * This is enabled when backup integration is active in global/component configuration.
	 *
	 * @var      bool
	 * @since    3.0.0
	 */
	protected $dynamicIntegration = false;

	/**
	 * The resolved backup destination path (or false when disabled).
	 *
	 * @var      string|false
	 * @since    3.0.0
	 */
	protected $backupPath = false;

	/**
	 * The resolved local repository base path (or false when disabled).
	 *
	 * @var      string|false
	 * @since    3.0.0
	 */
	protected $repoPath = false;

	/**
	 * Constructor.
	 *
	 * @param Initializer          $initializer          The Initializer Class.
	 * @param Config               $config               The Config Class.
	 * @param Event                $event                The Event Class.
	 * @param Placeholder          $placeholder          The Placeholder Class.
	 * @param Server               $server               The Server Class.
	 * @param Component            $component            The Component Class.
	 * @param FilePaths            $filepaths            The FilePaths Class.
	 * @param ContentOne           $contentone           The ContentOne Class.
	 * @param ModuleData           $moduledata           The ModuleData Class.
	 * @param PluginData           $plugindata           The PluginData Class.
	 * @param Customcode           $customcode           The Customcode Class.
	 * @param CustomcodeExternal   $customcodeexternal   The External Class.
	 * @param LanguageExtractor    $languageextractor    The Extractor Class.
	 * @param Updater              $updater              The Updater Class.
	 * @param Paths                $paths                The Paths Class.
	 * @param File                 $file                 The File Class.
	 * @param Files                $files                The Files Class.
	 * @param Folder               $folder               The Folder Class.
	 * @param FileInjector         $fileinjector         The FileInjector Class.
	 * @param Counter              $counter              The Counter Class.
	 * @param LanguageMessages     $languagemessages     The LanguageMessages Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Initializer $initializer, Config $config, Event $event,
		Placeholder $placeholder, Server $server,
		Component $component, FilePaths $filepaths,
		ContentOne $contentone, ModuleData $moduledata,
		PluginData $plugindata, Customcode $customcode,
		CustomcodeExternal $customcodeexternal,
		LanguageExtractor $languageextractor, Updater $updater,
		Paths $paths, File $file, Files $files, Folder $folder,
		FileInjector $fileinjector, Counter $counter,
		LanguageMessages $languagemessages)
	{
		$this->initializer = $initializer;
		$this->config = $config;
		$this->event = $event;
		$this->placeholder = $placeholder;
		$this->server = $server;
		$this->component = $component;
		$this->filepaths = $filepaths;
		$this->contentone = $contentone;
		$this->moduledata = $moduledata;
		$this->plugindata = $plugindata;
		$this->customcode = $customcode;
		$this->customcodeexternal = $customcodeexternal;
		$this->languageextractor = $languageextractor;
		$this->updater = $updater;
		$this->paths = $paths;
		$this->file = $file;
		$this->files = $files;
		$this->folder = $folder;
		$this->fileinjector = $fileinjector;
		$this->counter = $counter;
		$this->languagemessages = $languagemessages;

		// load application
		// $this->app = Factory::getApplication();

		$this->startCompilationTimer();

		// initialize the component
		$this->initializer->init();

		// initialize the file values (legacy call to ancient tech)
		parent::__construct();
	}

	/**
	 * Run the compiler
	 *
	 * This method orchestrates the final compilation pipeline.
	 * - the exact execution order
	 * - the exact event triggers
	 * - the exact side effects (filesystem changes, messages, zipping, server moves)
	 *
	 * @return bool   True on success, false on failure.
	 * @since  5.1.4
	 */
	public function run(): bool
	{
		$this->initializeTempPath();
		$this->initializeBackupPath();
		$this->initializeRepoPath();

		$this->cleanupSiteFolderIfRequired();
		$this->cleanupApiFolderIfRequired();

		// Trigger Event: jcb_ce_onBeforeUpdateFiles
		$this->event->trigger(
			'jcb_ce_onBeforeUpdateFiles', [$this]
		);

		// now update the files
		if (!$this->updateExtensionFiles())
		{
			return false;
		}

		$this->handleCustomCodeInjection();

		// Trigger Event: jcb_ce_onBeforeSetLangFileData
		$this->event->trigger(
			'jcb_ce_onBeforeSetLangFileData'
		);

		// set the lang data now
		$this->setLangFileData();

		// show language messages (preserved)
		$this->handleLanguageMessages();

		// show assets table messages (preserved)
		$this->handleAssetsTableMessages();

		// move the xml files to servers
		$this->setXmlServers();

		// build read me
		$this->buildReadMe();

		// set local repos
		$this->setLocalRepos();

		// zip the component
		if (!$this->zipComponent())
		{
			// done with error
			return false;
		}

		// if there are modules zip them
		$this->zipModules();

		// if there are plugins zip them
		$this->zipPlugins();

		// do lang mismatch check
		$this->handleLanguageMismatchWarnings();

		// check if we should add a EXTERNALCODE notice
		$this->handleExternalCodeNotices();

		$this->endCompilationTimer();

		// completed the compilation
		return true;
	}

	/**
	 * Start compilation timers and counters.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function startCompilationTimer(): void
	{
		$this->counter->start();
	}

	/**
	 * End compilation timers and counters.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function endCompilationTimer(): void
	{
		$this->counter->end();
	}

	/**
	 * Resolve and set the Joomla temporary directory path.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function initializeTempPath(): void
	{
		// set temp directory
		$this->tempPath = $this->config->tmp_path;
	}

	/**
	 * Resolve backup integration settings and backup path overrides.
	 *
	 * This sets:
	 * - $this->backupPath
	 * - $this->dynamicIntegration
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function initializeBackupPath(): void
	{
		// set some folder paths in relation to distribution
		if ($this->config->backup)
		{
			$this->backupPath = $this->config->get(
				'backup_folder_path', $this->tempPath
			);

			// see if component has overriding options set
			if ($this->component->get('add_backup_folder_path', 0) == 1)
			{
				$this->backupPath = $this->component->get('backup_folder_path', $this->backupPath);
			}

			$this->dynamicIntegration = true;
		}
	}

	/**
	 * Resolve repository integration settings and repository path overrides.
	 *
	 * This sets:
	 * - $this->repoPath
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function initializeRepoPath(): void
	{
		// set local repos switch
		if ($this->config->repository)
		{
			$this->repoPath = $this->config->get('git_folder_path', null);

			// see if component has overriding options set
			if ($this->component->get('add_git_folder_path', 0) == 1)
			{
				$this->repoPath = $this->component->get('git_folder_path', $this->repoPath);
			}
		}
	}

	/**
	 * Remove the site folder and update the component XML when configured.
	 *
	 * This preserves the legacy behaviour exactly, including:
	 * - deleting /site
	 * - removing the <files folder="site"> and <languages folder="site"> blocks from the component XML
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function cleanupSiteFolderIfRequired(): void
	{
		// remove site folder if not needed (TODO add check if custom script was moved to site folder then we must do a more complex cleanup here)
		if ($this->config->remove_site_folder && $this->config->remove_site_edit_folder)
		{
			// first remove the files and folders
			$this->folder->remove($this->paths->component_path . '/site');

			// clear form component xml
			$xmlPath      = $this->paths->component_path . '/'
				. $this->contentone->get('component') . '.xml';
			$componentXML = FileHelper::getContent($xmlPath);

			$textToSite = GetHelper::between(
				$componentXML, '<files folder="site">', '</files>'
			);
			$textToSiteLang = GetHelper::between(
				$componentXML, '<languages folder="site">', '</languages>'
			);

			$componentXML = str_replace(
				[
					'<files folder="site">' . $textToSite . "</files>",
					'<languages folder="site">' . $textToSiteLang . "</languages>"
				],
				['', ''],
				(string) $componentXML
			);

			$this->file->write($xmlPath, $componentXML);
		}
	}

	/**
	 * Remove the API folder when API support is disabled.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function cleanupApiFolderIfRequired(): void
	{
		// remove API
		if ($this->config->get('add_api') === null)
		{
			// first remove the files and folders
			$this->folder->remove($this->paths->component_path . '/api');
		}
	}

	/**
	 * Update generated extension files through the updater service.
	 *
	 * @return bool  True on success, false on failure.
	 * @since  5.1.4
	 */
	protected function updateExtensionFiles(): bool
	{
		// now update the files
		if (!$this->updater->update())
		{
			return false;
		}

		// Trigger Event: jcb_ce_onBeforeGetCustomCode
		$this->event->trigger(
			'jcb_ce_onBeforeGetCustomCode'
		);

		return true;
	}

	/**
	 * Handle custom code retrieval and injection into the generated files.
	 *
	 * Preserves the legacy event ordering:
	 * - jcb_ce_onBeforeGetCustomCode (triggered earlier)
	 * - jcb_ce_onBeforeAddCustomCode
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function handleCustomCodeInjection(): void
	{
		// now insert into the new files
		if ($this->customcode->get())
		{
			// Trigger Event: jcb_ce_onBeforeAddCustomCode
			$this->event->trigger(
				'jcb_ce_onBeforeAddCustomCode'
			);

			$this->addCustomCode();
		}
	}

	/**
	 * Render language include/exclude notices as produced by the language builder.
	 *
	 * All legacy messaging content and conditions are preserved exactly.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function handleLanguageMessages(): void
	{
		// set the language notice if it was set
		if ($this->languagemessages->isActive())
		{
			if ($this->languagemessages->isArray('exclude'))
			{
				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_HR_HTHREELANGUAGE_WARNINGHTHREE'), 'Warning'
				);

				foreach ($this->languagemessages->get('exclude') as $tag => $targets)
				{
					foreach ($targets as $extention => $files)
					{
						if (is_array($files))
						{
							foreach ($files as $file => $percentage)
							{
								$this->app->enqueueMessage(
									Text::sprintf('COM_COMPONENTBUILDER_THE_SS_BSB_LANGUAGE_HAS_STHIRTY_SEVEN_TRANSLATED_YOU_WILL_NEED_TO_TRANSLATE_STHIRTY_SEVEN_OF_THE_LANGUAGE_STRINGS_BEFORE_IT_WILL_BE_ADDED',
										$extention,
										$file,
										$tag,
										$percentage,
										$this->config->percentage_language_add
									),
									'Warning'
								);
							}
						}
						elseif (is_string($files))
						{
							$this->app->enqueueMessage(
								Text::sprintf('COM_COMPONENTBUILDER_THE_SS_LANGUAGE_HAS_STHIRTY_SEVEN_TRANSLATED_YOU_WILL_NEED_TO_TRANSLATE_STHIRTY_SEVEN_OF_THE_LANGUAGE_STRINGS_BEFORE_IT_WILL_BE_ADDED',
									$tag,
									$extention,
									$files,
									$this->config->percentage_language_add
								),
								'Warning'
							);
						}
					}
				}

				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_HR_HTHREELANGUAGE_NOTICEHTHREE'), 'Notice'
				);

				$this->app->enqueueMessage(
					Text::sprintf('COM_COMPONENTBUILDER_BYOU_CAN_CHANGE_THIS_PERCENTAGE_OF_TRANSLATED_STRINGS_REQUIRED_IN_THE_GLOBAL_OPTIONS_OF_JCBBBR_PLEASE_WATCH_THIS_A_HREFSTUTORIAL_FOR_MORE_HELP_SURROUNDING_THE_JCB_TRANSLATIONS_MANAGERA',
						'"https://youtu.be/zzAcVkn_cWU?list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank" title="JCB Tutorial surrounding Translation Manager"'
					),
					'Notice'
				);
			}

			// set why the strings were added
			$whyAddedLang = Text::sprintf('COM_COMPONENTBUILDER_BECAUSE_MORE_THEN_STHIRTY_SEVEN_OF_THE_STRINGS_HAVE_BEEN_TRANSLATED',
				$this->config->percentage_language_add
			);

			if ($this->config->get('debug_line_nr', false))
			{
				$whyAddedLang = Text::_('COM_COMPONENTBUILDER_BECAUSE_THE_DEBUGGING_MODE_IS_ON_DEBUG_LINE_NUMBERS');
			}

			// show languages that were added
			if ($this->languagemessages->isArray('include'))
			{
				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_HR_HTHREELANGUAGE_NOTICEHTHREE'), 'Notice'
				);

				foreach ($this->languagemessages->get('include') as $tag => $targets)
				{
					foreach ($targets as $extention => $files)
					{
						foreach ($files as $file => $percentage)
						{
							$this->app->enqueueMessage(
								Text::sprintf('COM_COMPONENTBUILDER_THE_SS_BSB_LANGUAGE_HAS_STHIRTY_SEVEN_TRANSLATED_WAS_ADDED_S',
									$extention,
									$file,
									$tag,
									$percentage,
									$whyAddedLang
								),
								'Notice'
							);
						}
					}
				}
			}
		}
	}

	/**
	 * Render assets table warnings/notices based on configuration and measured ACL size.
	 *
	 * All legacy messaging content and conditions are preserved exactly.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function handleAssetsTableMessages(): void
	{
		// set assets table column fix type messages
		$message_fix['intelligent'] = Text::_('COM_COMPONENTBUILDER_THE_BINTELLIGENTB_FIX_ONLY_UPDATES_THE_ASSETS_TABLE_COLUMN_WHEN_IT_DETECTS_THAT_IT_IS_TOO_SMALL_FOR_THE_WORSE_CASE_THE_INTELLIGENT_FIX_ALSO_ONLY_REVERSE_THE_ASSETS_TABLE_UPDATE_ON_UNINSTALL_OF_THE_COMPONENT_IF_IT_DETECTS_THAT_NO_OTHER_COMPONENT_NEEDS_THE_RULES_COLUMN_TO_BE_LARGER_ANY_LONGER_THIS_OPTIONS_ALSO_SHOWS_A_NOTICE_TO_THE_END_USER_OF_ALL_THAT_IT_DOES_TO_THE_ASSETS_TABLE_ON_INSTALLATION_AND_UNINSTALLING_OF_THE_COMPONENT');
		$message_fix['sql'] = Text::_('COM_COMPONENTBUILDER_THE_BSQLB_FIX_UPDATES_THE_ASSETS_TABLE_COLUMN_SIZE_ON_INSTALLATION_OF_THE_COMPONENT_AND_REVERSES_IT_BACK_TO_THE_JOOMLA_DEFAULT_ON_UNINSTALL_OF_THE_COMPONENT');

		// get the asset table fix switch
		$add_assets_table_fix = $this->config->get('add_assets_table_fix', 0);

		// set assets table rules column notice
		if ($add_assets_table_fix)
		{
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREEASSETS_TABLE_NOTICEHTHREE'), 'Notice'
			);

			$asset_table_fix_type = ($add_assets_table_fix == 2)
				? 'intelligent' : 'sql';

			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_THE_ASSETS_TABLE_BSB_FIX_HAS_BEEN_ADDED_TO_THIS_COMPONENT_S',
					$asset_table_fix_type,
					$message_fix[$asset_table_fix_type]
				),
				'Notice'
			);
		}
		// set assets table rules column Warning
		elseif ($this->counter->accessSize >= 30)
		{
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREEASSETS_TABLE_WARNINGHTHREE'), 'Warning'
			);

			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_THE_JOOMLA_ASSETS_TABLE_RULES_COLUMN_HAS_TO_BE_FIXED_FOR_THIS_COMPONENT_TO_WORK_COHERENTLY_JCB_HAS_DETECTED_THAT_IN_WORSE_CASE_THE_RULES_COLUMN_IN_THE_ASSETS_TABLE_MAY_REQUIRE_BSB_CHARACTERS_AND_YET_THE_JOOMLA_DEFAULT_IS_ONLY_BVARCHARFIVE_THOUSAND_ONE_HUNDRED_AND_TWENTYB_JCB_HAS_THREE_OPTION_TO_RESOLVE_THIS_ISSUE_FIRST_BUSE_LESS_PERMISSIONSB_IN_YOUR_COMPONENT_SECOND_USE_THE_BSQLB_FIX_OR_THE_BINTELLIGENTB_FIX_S_S',
					$this->config->access_worse_case,
					$message_fix['intelligent'],
					$message_fix['sql']
				),
				'Warning'
			);
		}

		// set assets table name column warning if not set
		if (!$add_assets_table_fix && $this->config->add_assets_table_name_fix)
		{
			// only add if not already added
			if ($this->counter->accessSize < 30)
			{
				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_HR_HTHREEASSETS_TABLE_WARNINGHTHREE'),
					'Warning'
				);
			}

			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_THE_JOOMLA_ASSETS_TABLE_NAME_COLUMN_HAS_TO_BE_FIXED_FOR_THIS_COMPONENT_TO_WORK_CORRECTLY_JCB_HAS_DETECTED_THAT_THE_ASSETS_TABLE_NAME_COLUMN_WILL_NEED_TO_BE_ENLARGED_BECAUSE_THIS_COMPONENT_OWN_NAMING_CONVENTION_IS_LARGER_THAN_VARCHARFIFTY_WHICH_IS_THE_JOOMLA_DEFAULT_JCB_HAS_THREE_OPTION_TO_RESOLVE_THIS_ISSUE_FIRST_BSHORTER_NAMESB_FOR_YOUR_COMPONENT_ANDOR_ITS_ADMIN_VIEWS_SECOND_USE_THE_BSQLB_FIX_OR_THE_BINTELLIGENTB_FIX_S_S',
					$message_fix['intelligent'],
					$message_fix['sql']
				),
				'Warning'
			);
		}
	}

	/**
	 * Emit language mismatch warnings related to JText and Text::script usage.
	 *
	 * All legacy behaviour and message strings are preserved exactly.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function handleLanguageMismatchWarnings(): void
	{
		// do lang mismatch check
		if (ArrayHelper::check($this->languageextractor->langMismatch))
		{
			if (ArrayHelper::check($this->languageextractor->langMatch))
			{
				$mismatch = array_diff(
					array_unique($this->languageextractor->langMismatch),
					array_unique($this->languageextractor->langMatch)
				);
			}
			else
			{
				$mismatch = array_unique($this->languageextractor->langMismatch);
			}

			// set a notice if we have a mismatch
			if (isset($mismatch) && ArrayHelper::check($mismatch))
			{
				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_HR_HTHREELANGUAGE_WARNINGHTHREE'), 'Warning'
				);

				if (count((array) $mismatch) > 1)
				{
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HTHREEPLEASE_CHECK_THE_FOLLOWING_MISMATCHING_JOOMLAJTEXT_LANGUAGE_CONSTANTSHTHREE'),
						'Warning'
					);
				}
				else
				{
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HTHREEPLEASE_CHECK_THE_FOLLOWING_MISMATCH_JOOMLAJTEXT_LANGUAGE_CONSTANTHTHREE'),
						'Warning'
					);
				}

				// add the mismatching issues
				foreach ($mismatch as $string)
				{
					$constant = $this->config->lang_prefix . '_'
						. StringHelper::safe($string, 'U');

					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_THE_BJOOMLATEXT_APOSSAPOSB_LANGUAGE_CONSTANT_FOR_BSB_DOES_NOT_HAVE_A_CORRESPONDING_CODETEXTSCRIPTAPOSSAPOSCODE_DECALARATION_PLEASE_ADD_IT',
							$constant,
							$string,
							$string
						),
						'Warning'
					);
				}
			}
		}
	}

	/**
	 * Emit EXTERNALCODE notices when external code strings were recorded.
	 *
	 * All legacy behaviour and message strings are preserved exactly.
	 *
	 * @return void
	 * @since  5.1.4
	 */
	protected function handleExternalCodeNotices(): void
	{
		// check if we should add a EXTERNALCODE notice
		$externalCount = $this->customcodeexternal->count();
		if ($externalCount > 0)
		{
			// the correct string
			$externalCodeString = ($externalCount == 1)
				? Text::_('COM_COMPONENTBUILDER_CODESTRING')
				: Text::_('COM_COMPONENTBUILDER_CODESTRINGS');

			// the notice
			$this->app->enqueueMessage(
				Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_NOTICEHTHREE'), 'Notice'
			);

			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_THERE_HAS_BEEN_BS_SB_ADDED_TO_THIS_COMPONENT_AS_EXTERNALCODE_TO_AVOID_SHIPPING_YOUR_COMPONENT_WITH_MALICIOUS_S_ALWAYS_MAKE_SURE_THAT_THE_CORRECT_BCODESTRING_VALUESB_WERE_USED',
					$externalCount,
					$externalCodeString,
					$externalCodeString
				),
				'Notice'
			);
		}
	}

	/**
	 * Move the local server XML files (component, modules, plugins) to their remote servers.
	 *
	 * @return  void
	 * @since   5.1.2
	 */
	protected function setXmlServers(): void
	{
		$this->moveComponentXmlServers();
		$this->moveModulesUpdateServers();
		$this->movePluginsUpdateServers();
	}

	/**
	 * Move the component update server and changelog XML files to their remote servers.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function moveComponentXmlServers(): void
	{
		if (!$this->dynamicIntegration)
		{
			return;
		}

		$types = ['update_server', 'changelog_server'];

		foreach ($types as $type)
		{
			// Dynamically resolve keys
			$add      = $this->component->get("add_{$type}", 0);
			$target   = $this->component->get("{$type}_target", 0);
			$server   = $this->component->get($type);
			$protocol = $this->component->get("{$type}_protocol");
			$fileName = $this->component->get("{$type}_xml_file_name", 'error');

			$xmlPath = $this->paths->component_path . '/' . $fileName;

			// Skip if conditions not met
			if ($add != 1 || $target != 1 || empty($fileName) || empty($protocol) || !is_file($xmlPath) || empty($server))
			{
				continue;
			}

			// Try to move the file
			if (!$this->moveXmlToServer($xmlPath, $fileName, (int) $server, $protocol))
			{
				$this->app->enqueueMessage(
					Text::sprintf('COM_COMPONENTBUILDER_UPLOAD_OF_COMPONENT_S_S_XML_FAILED',
						$this->component->get('system_name'),
						str_replace('_', ' ', $type)
					),
					'Error'
				);
			}

			JoomlaFile::delete($xmlPath);
		}
	}

	/**
	 * Move all module update server XML files to their respective remote servers.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function moveModulesUpdateServers(): void
	{
		if (!$this->moduledata->exists())
		{
			return;
		}

		foreach ($this->moduledata->get() as $module)
		{
			if ($this->isValidUpdateServerObject($module))
			{
				if (!$this->moveXmlToServer(
					$module->update_server_xml_path,
					$module->update_server_xml_file_name,
					(int) $module->update_server,
					$module->update_server_protocol
				))
				{
					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_UPLOAD_OF_MODULE_S_UPDATE_SERVER_XML_FAILED',
							$module->name
						),
						'Error'
					);
				}

				JoomlaFile::delete($module->update_server_xml_path);
			}
		}
	}

	/**
	 * Move all plugin update server XML files to their respective remote servers.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function movePluginsUpdateServers(): void
	{
		if (!$this->plugindata->exists())
		{
			return;
		}

		foreach ($this->plugindata->get() as $plugin)
		{
			if ($this->isValidUpdateServerObject($plugin))
			{
				if (!$this->moveXmlToServer(
					$plugin->update_server_xml_path,
					$plugin->update_server_xml_file_name,
					(int) $plugin->update_server,
					$plugin->update_server_protocol
				))
				{
					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_UPLOAD_OF_PLUGIN_S_UPDATE_SERVER_XML_FAILED',
							$plugin->name
						),
						'Error'
					);
				}

				JoomlaFile::delete($plugin->update_server_xml_path);
			}
		}
	}

	/**
	 * Validate if a given object has a proper update server configuration and XML file.
	 *
	 * @param  object  $item  The module or plugin object.
	 *
	 * @return bool  True if object has valid update server info and file, false otherwise.
	 * @since  5.1.2
	 */
	protected function isValidUpdateServerObject(object $item): bool
	{
		return ObjectHelper::check($item)
			&& isset($item->add_update_server, $item->update_server_target, $item->update_server)
			&& $item->add_update_server == 1
			&& $item->update_server_target == 1
			&& is_numeric($item->update_server)
			&& $item->update_server > 0
			&& isset($item->update_server_xml_path, $item->update_server_xml_file_name)
			&& is_file($item->update_server_xml_path)
			&& StringHelper::check($item->update_server_xml_file_name);
	}

	/**
	 * Perform the actual file transfer to the server.
	 *
	 * @param  string  $path      Full local file path.
	 * @param  string  $fileName  Name of the file on the server.
	 * @param  int     $serverId  The update server ID.
	 * @param  string  $protocol  The protocol to use for the transfer.
	 *
	 * @return bool  True if move succeeded, false otherwise.
	 * @since  5.1.2
	 */
	protected function moveXmlToServer(string $path, string $fileName, int $serverId, string $protocol): bool
	{
		return $this->server->legacyMove($path, $fileName, $serverId, $protocol);
	}

	/**
	 * Move the local changelog XML file to a remote server.
	 *
	 * NOTE: This legacy method is preserved for backwards compatibility.
	 * The newer logic is handled via moveComponentXmlServers().
	 *
	 * @return  void
	 * @since   3.0.0
	 */
	protected function setChangeLogServer()
	{
		// move the component changelog xml to host
		if ($this->component->get('add_changelog_server', 0) == 1
			&& $this->component->get('changelog_server_target', 0) == 1
			&& $this->dynamicIntegration)
		{
			$changelog_xml_path = $this->paths->component_path . '/CHANGELOG.xml';

			// make sure we have the correct file
			if (is_file($changelog_xml_path)
				&& ($changelog_server = $this->component->get('changelog_server')) !== null)
			{
				// move to server
				if (!$this->server->legacyMove(
					$changelog_xml_path, 'CHANGELOG.xml', (int) $changelog_server,
					$this->component->get('changelog_server_protocol')
				))
				{
					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_UPLOAD_OF_COMPONENT_S_CHANGELOG_XML_FAILED',
							$this->component->get('system_name')
						), 'Error'
					);
				}

				// remove the local file
				JoomlaFile::delete($changelog_xml_path);
			}
		}
	}

	/**
	 * Link changes made to views into the file license placeholders.
	 *
	 * This method mutates the Content.One placeholders depending on view-specific config.
	 * Legacy behaviour is preserved, including resetting to global values if no override applies.
	 *
	 * @param  array  $data  The license/config data array.
	 *
	 * @return bool|null  True when view config was applied, otherwise null (legacy behaviour).
	 * @since  3.0.0
	 */
	protected function fixLicenseValues($data)
	{
		// check if these files have its own config data)
		if (isset($data['config'])
			&& ArrayHelper::check($data['config'])
			&& $this->component->get('mvc_versiondate', 0) == 1)
		{
			foreach ($data['config'] as $key => $value)
			{
				if (Placefix::_h('VERSION') === $key)
				{
					// hmm we sould in some way make it known that this version number
					// is not in relation the the project but to the file only... any ideas?
					// this is the best for now...
					if (1 == $value)
					{
						$value = '@first version of this MVC';
					}
					else
					{
						$value = '@update number ' . $value . ' of this MVC';
					}
				}

				$this->contentone->set($key, $value);
			}

			return true;
		}

		// else insure to reset to global
		$this->contentone->set('CREATIONDATE', $this->contentone->get('GLOBALCREATIONDATE'));
		$this->contentone->set('BUILDDATE', $this->contentone->get('GLOBALBUILDDATE'));
		$this->contentone->set('VERSION', $this->contentone->get('GLOBALVERSION'));
	}

	/**
	 * Build/refresh README files just before packaging.
	 *
	 * Legacy behaviour is preserved:
	 * - ensures counter values are set
	 * - updates README.md and/or README.txt if present and enabled
	 * - clears static file list after processing
	 *
	 * @return void
	 * @since  3.0.0
	 */
	private function buildReadMe()
	{
		// do a final run to update the readme file
		$two = 0;

		// counter data if not set already
		if (!$this->contentone->exists('LINE_COUNT')
			|| $this->contentone->get('LINE_COUNT') != $this->counter->line)
		{
			$this->counter->set();
		}

		// search for the readme
		foreach ($this->files->get('static') as $static)
		{
			if (('README.md' === $static['name'] || 'README.txt' === $static['name'])
				&& $this->component->get('addreadme')
				&& is_file($static['path']))
			{
				$this->setReadMe($static['path']);
				$two++;
			}

			if ($two == 2)
			{
				break;
			}
		}

		$this->files->remove('static');
	}

	/**
	 * Update a README file by applying placeholders.
	 *
	 * @param  string  $path  Full file path to README file.
	 *
	 * @return void
	 * @since  3.0.0
	 */
	private function setReadMe($path)
	{
		// get the file
		$string = FileHelper::getContent($path);

		// update the file
		$answer = $this->placeholder->update($string, $this->contentone->allActive());

		// write updated readme
		$this->file->write($path, $answer);
	}

	/**
	 * Sync the generated component/modules/plugins into local repository folders when enabled.
	 *
	 * @return void
	 * @since  3.0.0
	 */
	private function setLocalRepos()
	{
		// move it to the repo folder if set
		if (isset($this->repoPath) && StringHelper::check($this->repoPath))
		{
			// set the repo path
			$repoFullPath = $this->repoPath . '/com_'
				. $this->component->get('sales_name') . '__joomla_'
				. $this->config->get('joomla_version', 3);

			// for plugin event TODO change event api signatures
			$component_context = $this->config->component_context;
			$component_path    = $this->paths->component_path;

			// Trigger Event: jcb_ce_onBeforeUpdateRepo
			$this->event->trigger(
				'jcb_ce_onBeforeUpdateRepo',
				array(&$component_context, &$component_path, &$repoFullPath)
			);

			// remove old data
			$this->folder->remove($repoFullPath, $this->component->get('toignore'));

			// set the new data
			try
			{
				JoomlaFolder::copy($this->paths->component_path, $repoFullPath, '', true);
			}
			catch (\RuntimeException $e)
			{
				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_WE_WHERE_WAS_UNABLE_TO_TRANSFER_THE_COMPONENT_TO_THE_GIT_REPOSITORY') . ' ' . $e->getMessage(),
					'Error'
				);
			}

			// Trigger Event: jcb_ce_onAfterUpdateRepo
			$this->event->trigger(
				'jcb_ce_onAfterUpdateRepo',
				array(&$component_context, &$component_path, &$repoFullPath)
			);

			// move the modules to local folder repos
			if ($this->moduledata->exists())
			{
				foreach ($this->moduledata->get() as $module)
				{
					if (ObjectHelper::check($module) && isset($module->file_name))
					{
						$module_context = 'module.' . $module->file_name . '.' . $module->id;

						// set the repo path
						$repoFullPath = $this->repoPath . '/'
							. $module->folder_name . '__joomla_'
							. $this->config->get('joomla_version', 3);

						// Trigger Event: jcb_ce_onBeforeUpdateRepo
						$this->event->trigger(
							'jcb_ce_onBeforeUpdateRepo',
							array(&$module_context, &$module->folder_path, &$repoFullPath, &$module)
						);

						// remove old data
						$this->folder->remove(
							$repoFullPath, $this->component->get('toignore')
						);

						// set the new data
						try
						{
							JoomlaFolder::copy($module->folder_path, $repoFullPath, '', true);
						}
						catch (\RuntimeException $e)
						{
							$this->app->enqueueMessage(
								Text::sprintf('COM_COMPONENTBUILDER_WE_WHERE_WAS_UNABLE_TO_TRANSFER_THE_S_MODULE_TO_THE_GIT_REPOSITORY',
									$module->name
								) . ' ' . $e->getMessage(),
								'Error'
							);
						}

						// Trigger Event: jcb_ce_onAfterUpdateRepo
						$this->event->trigger(
							'jcb_ce_onAfterUpdateRepo',
							array(&$module_context, &$module->folder_path, &$repoFullPath, &$module)
						);
					}
				}
			}

			// move the plugins to local folder repos
			if ($this->plugindata->exists())
			{
				foreach ($this->plugindata->get() as $plugin)
				{
					if (ObjectHelper::check($plugin) && isset($plugin->file_name))
					{
						$plugin_context = 'plugin.' . $plugin->file_name . '.' . $plugin->id;

						// set the repo path
						$repoFullPath = $this->repoPath . '/'
							. $plugin->folder_name . '__joomla_'
							. $this->config->get('joomla_version', 3);

						// Trigger Event: jcb_ce_onBeforeUpdateRepo
						$this->event->trigger(
							'jcb_ce_onBeforeUpdateRepo',
							array(&$plugin_context, &$plugin->folder_path, &$repoFullPath, &$plugin)
						);

						// remove old data
						$this->folder->remove(
							$repoFullPath, $this->component->get('toignore')
						);

						// set the new data
						try
						{
							JoomlaFolder::copy($plugin->folder_path, $repoFullPath, '', true);
						}
						catch (\RuntimeException $e)
						{
							$this->app->enqueueMessage(
								Text::sprintf('COM_COMPONENTBUILDER_WE_WHERE_WAS_UNABLE_TO_TRANSFER_THE_S_PLUGIN_TO_THE_GIT_REPOSITORY',
									$plugin->name
								) . ' ' . $e->getMessage(),
								'Error'
							);
						}

						// Trigger Event: jcb_ce_onAfterUpdateRepo
						$this->event->trigger(
							'jcb_ce_onAfterUpdateRepo',
							array(&$plugin_context, &$plugin->folder_path, &$repoFullPath, &$plugin)
						);
					}
				}
			}
		}
	}

	/**
	 * Zip the component and handle backup/server transfer where configured.
	 *
	 * @return bool  True on success, false on failure.
	 * @since  3.0.0
	 */
	private function zipComponent()
	{
		// Component Folder Name
		$this->filepaths->set('component-folder', $this->paths->component_folder_name);

		// the name of the zip file to create
		$this->filepaths->set('component', $this->tempPath . '/'
			. $this->filepaths->get('component-folder') . '.zip');

		// for plugin event TODO change event api signatures
		$component_context     = $this->config->component_context;
		$component_path        = $this->paths->component_path;
		$component_sales_name  = $this->paths->component_sales_name;
		$component_folder_name = $this->paths->component_folder_name;
		$component_zip_path    = $this->filepaths->get('component');

		// Trigger Event: jcb_ce_onBeforeZipComponent
		$this->event->trigger(
			'jcb_ce_onBeforeZipComponent',
			[&$component_path, &$component_zip_path, &$this->tempPath, &$component_folder_name]
		);

		//create the zip file
		if (FileHelper::zip(
			$this->paths->component_path,
			$component_zip_path
		))
		{
			// now move to backup if zip was made and backup is required
			if ($this->backupPath && $this->dynamicIntegration)
			{
				// Trigger Event: jcb_ce_onBeforeBackupZip
				$this->event->trigger(
					'jcb_ce_onBeforeBackupZip',
					[&$component_zip_path, &$this->tempPath, &$this->backupPath]
				);

				// copy the zip to backup path
				try
				{
					JoomlaFile::copy(
						$component_zip_path,
						$this->backupPath . '/' . $this->paths->component_backup_name . '.zip'
					);
				}
				catch (\RuntimeException $e)
				{
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_WE_WHERE_WAS_UNABLE_TO_TRANSFER_THE_COMPONENT_ZIP_FILE_TO_THE_BACKUP_FOLDER') . ' ' . $e->getMessage(),
						'Error'
					);
				}
			}

			// move to sales server host
			if ($this->component->get('add_sales_server', 0) == 1 && $this->dynamicIntegration)
			{
				// make sure we have the correct file
				if ($this->component->get('sales_server'))
				{
					// Trigger Event: jcb_ce_onBeforeMoveToServer
					$this->event->trigger(
						'jcb_ce_onBeforeMoveToServer',
						[&$component_zip_path, &$this->tempPath, &$component_sales_name]
					);

					// move to server
					if (!$this->server->legacyMove(
						$component_zip_path,
						$component_sales_name . '.zip',
						(int) $this->component->get('sales_server'),
						$this->component->get('sales_server_protocol')
					))
					{
						$this->app->enqueueMessage(
							Text::sprintf('COM_COMPONENTBUILDER_UPLOAD_OF_COMPONENT_S_ZIP_FILE_FAILED',
								$this->component->get('system_name')
							),
							'Error'
						);
					}
				}
			}

			// Trigger Event: jcb_ce_onAfterZipComponent
			$this->event->trigger(
				'jcb_ce_onAfterZipComponent',
				[&$component_zip_path, &$this->tempPath, &$component_folder_name]
			);

			$this->filepaths->set('component', $component_zip_path);

			// remove the component folder since we are done
			if ($this->folder->remove($this->paths->component_path))
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Zip all modules and handle backup/server transfers where configured.
	 *
	 * Legacy behaviour is preserved exactly, including events and folder cleanup.
	 *
	 * @return void
	 * @since  3.0.0
	 */
	private function zipModules()
	{
		if ($this->moduledata->exists())
		{
			foreach ($this->moduledata->get() as $module)
			{
				if (ObjectHelper::check($module)
					&& isset($module->zip_name)
					&& StringHelper::check($module->zip_name)
					&& isset($module->folder_path)
					&& StringHelper::check($module->folder_path))
				{
					// set module context
					$module_context = $module->file_name . '.' . $module->id;

					// Component Folder Name
					$this->filepaths->set("modules-folder.{$module->id}", $module->zip_name);

					// the name of the zip file to create
					$module_zip_path = $this->tempPath . '/' . $module->zip_name . '.zip';
					$this->filepaths->set("modules.{$module->id}", $module_zip_path);

					// Trigger Event: jcb_ce_onBeforeZipModule
					$this->event->trigger(
						'jcb_ce_onBeforeZipModule',
						array(&$module_context, &$module->folder_path,
							&$module_zip_path,
							&$this->tempPath, &$module->zip_name, &$module)
					);

					//create the zip file
					if (FileHelper::zip(
						$module->folder_path,
						$module_zip_path
					))
					{
						// now move to backup if zip was made and backup is required
						if ($this->backupPath)
						{
							$__module_context = 'module.' . $module_context;

							// Trigger Event: jcb_ce_onBeforeBackupZip
							$this->event->trigger(
								'jcb_ce_onBeforeBackupZip',
								array(&$__module_context,
									&$module_zip_path,
									&$this->tempPath, &$this->backupPath,
									&$module)
							);

							// copy the zip to backup path
							try
							{
								JoomlaFile::copy(
									$module_zip_path,
									$this->backupPath . '/' . $module->zip_name . '.zip'
								);
							}
							catch (\RuntimeException $e)
							{
								$this->app->enqueueMessage(
									Text::sprintf('COM_COMPONENTBUILDER_WE_WHERE_WAS_UNABLE_TO_TRANSFER_THE_S_MODULE_ZIP_FILE_TO_THE_BACKUP_FOLDER',
										$module->name
									) . ' ' . $e->getMessage(),
									'Error'
								);
							}
						}

						// move to sales server host
						if ($module->add_sales_server == 1)
						{
							// make sure we have the correct file
							if (isset($module->sales_server))
							{
								// Trigger Event: jcb_ce_onBeforeMoveToServer
								$this->event->trigger(
									'jcb_ce_onBeforeMoveToServer',
									array(&$__module_context,
										&$module_zip_path,
										&$this->tempPath, &$module->zip_name,
										&$module)
								);

								// move to server
								if (!$this->server->legacyMove(
									$module_zip_path,
									$module->zip_name . '.zip',
									(int) $module->sales_server,
									$module->sales_server_protocol
								))
								{
									$this->app->enqueueMessage(
										Text::sprintf('COM_COMPONENTBUILDER_UPLOAD_OF_MODULE_S_ZIP_FILE_FAILED',
											$module->name
										),
										'Error'
									);
								}
							}
						}

						// Trigger Event: jcb_ce_onAfterZipModule
						$this->event->trigger(
							'jcb_ce_onAfterZipModule',
							array(&$module_context,
								&$module_zip_path,
								&$this->tempPath,
								&$module->zip_name,
								&$module)
						);

						$this->filepaths->set("modules.{$module->id}", $module_zip_path);

						// remove the module folder since we are done
						$this->folder->remove($module->folder_path);
					}
				}
			}
		}
	}

	/**
	 * Zip all plugins and handle backup/server transfers where configured.
	 *
	 * Legacy behaviour is preserved exactly, including events and folder cleanup.
	 *
	 * @return void
	 * @since  3.0.0
	 */
	private function zipPlugins()
	{
		if ($this->plugindata->exists())
		{
			foreach ($this->plugindata->get() as $plugin)
			{
				if (ObjectHelper::check($plugin)
					&& isset($plugin->zip_name)
					&& StringHelper::check($plugin->zip_name)
					&& isset($plugin->folder_path)
					&& StringHelper::check($plugin->folder_path))
				{
					// set plugin context
					$plugin_context = $plugin->file_name . '.' . $plugin->id;

					// Component Folder Name
					$this->filepaths->set("plugins-folder.{$plugin->id}", $plugin->zip_name);

					// the name of the zip file to create
					$plugin_zip_path = $this->tempPath . '/' . $plugin->zip_name . '.zip';
					$this->filepaths->set("plugins.{$plugin->id}", $plugin_zip_path);

					// Trigger Event: jcb_ce_onBeforeZipPlugin
					$this->event->trigger(
						'jcb_ce_onBeforeZipPlugin',
						array(&$plugin_context, &$plugin->folder_path,
							&$plugin_zip_path,
							&$this->tempPath, &$plugin->zip_name, &$plugin)
					);

					//create the zip file
					if (FileHelper::zip(
						$plugin->folder_path,
						$plugin_zip_path
					))
					{
						// now move to backup if zip was made and backup is required
						if ($this->backupPath)
						{
							$__plugin_context = 'plugin.' . $plugin_context;

							// Trigger Event: jcb_ce_onBeforeBackupZip
							$this->event->trigger(
								'jcb_ce_onBeforeBackupZip',
								array(&$__plugin_context,
									&$plugin_zip_path,
									&$this->tempPath, &$this->backupPath,
									&$plugin)
							);

							// copy the zip to backup path
							try
							{
								JoomlaFile::copy(
									$plugin_zip_path,
									$this->backupPath . '/' . $plugin->zip_name . '.zip'
								);
							}
							catch (\RuntimeException $e)
							{
								$this->app->enqueueMessage(
									Text::sprintf('COM_COMPONENTBUILDER_WE_WHERE_WAS_UNABLE_TO_TRANSFER_THE_S_PLUGIN_ZIP_FILE_TO_THE_BACKUP_FOLDER',
										$plugin->name
									) . ' ' . $e->getMessage(),
									'Error'
								);
							}
						}

						// move to sales server host
						if ($plugin->add_sales_server == 1)
						{
							// make sure we have the correct file
							if (isset($plugin->sales_server))
							{
								// Trigger Event: jcb_ce_onBeforeMoveToServer
								$this->event->trigger(
									'jcb_ce_onBeforeMoveToServer',
									array(&$__plugin_context,
										&$plugin_zip_path,
										&$this->tempPath, &$plugin->zip_name,
										&$plugin)
								);

								// move to server
								if (!$this->server->legacyMove(
									$plugin_zip_path,
									$plugin->zip_name . '.zip',
									(int) $plugin->sales_server,
									$plugin->sales_server_protocol
								))
								{
									$this->app->enqueueMessage(
										Text::sprintf('COM_COMPONENTBUILDER_UPLOAD_OF_PLUGIN_S_ZIP_FILE_FAILED',
											$plugin->name
										),
										'Error'
									);
								}
							}
						}

						// Trigger Event: jcb_ce_onAfterZipPlugin
						$this->event->trigger(
							'jcb_ce_onAfterZipPlugin',
							array(&$plugin_context,
								&$plugin_zip_path,
								&$this->tempPath,
								&$plugin->zip_name,
								&$plugin)
						);

						$this->filepaths->set("plugins.{$plugin->id}", $plugin_zip_path);

						// remove the plugin folder since we are done
						$this->folder->remove($plugin->folder_path);
					}
				}
			}
		}
	}

	/**
	 * Inject custom code blocks into compiled files.
	 *
	 * This method is preserved as-is (logic unchanged). It:
	 * - locates hashed targets in the generated file
	 * - injects custom code using FileInjector
	 * - falls back to escaped code insertion when hashes do not match
	 * - emits warnings for manual review when required
	 *
	 * @return void
	 * @since  3.0.0
	 */
	protected function addCustomCode()
	{
		// reset all these
		$this->placeholder->clearType('view');
		$this->placeholder->clearType('arg');
		foreach ($this->customcode->active as $nr => $target)
		{
			// reset each time per custom code
			$fingerPrint = [];
			if (isset($target['hashtarget'][0]) && $target['hashtarget'][0] > 3
				&& isset($target['path'])
				&& StringHelper::check($target['path'])
				&& isset($target['hashtarget'][1])
				&& StringHelper::check(
					$target['hashtarget'][1]
				))
			{
				$file      = $this->paths->component_path . '/' . $target['path'];
				$size      = (int) $target['hashtarget'][0];
				$hash      = $target['hashtarget'][1];
				$cut       = $size - 1;
				$found     = false;
				$bites     = 0;
				$lineBites = [];
				$replace   = [];
				if ($target['type'] == 1 && isset($target['hashendtarget'][0])
					&& $target['hashendtarget'][0] > 0)
				{
					$foundEnd = false;
					$sizeEnd  = (int) $target['hashendtarget'][0];
					$hashEnd  = $target['hashendtarget'][1];
					$cutEnd   = $sizeEnd - 1;
				}
				else
				{
					// replace to the end of the file
					$foundEnd = true;
				}
				$counter = 0;
				// check if file exist			
				if (is_file($file))
				{
					foreach (
						new \SplFileObject($file) as $lineNumber => $lineContent
					)
					{
						// if not found we need to load line bites per line
						$lineBites[$lineNumber] = (int) mb_strlen(
							$lineContent, '8bit'
						);
						if (!$found)
						{
							$bites = (int) MathHelper::bc(
								'add', $lineBites[$lineNumber], $bites
							);
						}
						if ($found && !$foundEnd)
						{
							$replace[] = (int) $lineBites[$lineNumber];
							// we must keep last three lines to dynamic find target entry
							$fingerPrint[$lineNumber] = trim($lineContent);
							// check lines each time if it fits our target
							if (count((array) $fingerPrint) === $sizeEnd
								&& !$foundEnd)
							{
								$fingerTest = md5(implode('', $fingerPrint));
								if ($fingerTest === $hashEnd)
								{
									// we are done here
									$foundEnd = true;
									$replace  = array_slice(
										$replace, 0, count($replace) - $sizeEnd
									);
									break;
								}
								else
								{
									$fingerPrint = array_slice(
										$fingerPrint, -$cutEnd, $cutEnd, true
									);
								}
							}
							continue;
						}
						if ($found && $foundEnd)
						{
							$replace[] = (int) $lineBites[$lineNumber];
						}
						// we must keep last three lines to dynamic find target entry
						$fingerPrint[$lineNumber] = trim($lineContent);
						// check lines each time if it fits our target
						if (count((array) $fingerPrint) === $size && !$found)
						{
							$fingerTest = md5(implode('', $fingerPrint));
							if ($fingerTest === $hash)
							{
								// we are done here
								$found = true;
								// reset in case
								$fingerPrint = [];
								// break if it is insertion
								if ($target['type'] == 2)
								{
									break;
								}
							}
							else
							{
								$fingerPrint = array_slice(
									$fingerPrint, -$cut, $cut, true
								);
							}
						}
					}
					if ($found)
					{
						$placeholder = $this->placeholder->keys(
							(int) $target['comment_type'] . $target['type'],
							$target['id']
						);
						$data        = $placeholder['start'] . PHP_EOL
							. $this->placeholder->update_(
								$target['code']
							) . $placeholder['end'] . PHP_EOL;
						if ($target['type'] == 2)
						{
							// found it now add code from the next line
							$this->fileinjector->add($file, $data, $bites);
						}
						elseif ($target['type'] == 1 && $foundEnd)
						{
							// found it now add code from the next line
							$this->fileinjector->add(
								$file, $data, $bites, (int) array_sum($replace)
							);
						}
						else
						{
							// Load escaped code since the target endhash has changed
							$this->loadEscapedCode($file, $target, $lineBites);
							$this->app->enqueueMessage(
								Text::_('COM_COMPONENTBUILDER_HR_HTHREECUSTOM_CODE_WARNINGHTHREE'),
								'Warning'
							);
							$this->app->enqueueMessage(
								Text::sprintf('COM_COMPONENTBUILDER_CUSTOM_CODE_S_COULD_NOT_BE_ADDED_TO_BSB_PLEASE_REVIEW_THE_FILE_AFTER_INSTALL_AT_BLINE_SB_AND_REPOSITION_THE_CODE_REMOVE_THE_COMMENTS_AND_RECOMPILE_TO_FIX_THE_ISSUE_THE_ISSUE_COULD_BE_DUE_TO_A_CHANGE_TO_BLINES_BELOWB_THE_CUSTOM_CODE',
									'<a href="index.php?option=com_componentbuilder&view=custom_codes&task=custom_code.edit&id='
									. $target['id'] . '" target="_blank">#'
									. $target['id'] . '</a>', $target['path'],
									$target['from_line']
								),
								'Warning'
							);
						}
					}
					else
					{
						// Load escaped code since the target hash has changed
						$this->loadEscapedCode($file, $target, $lineBites);
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREECUSTOM_CODE_WARNINGHTHREE'),
							'Warning'
						);
						$this->app->enqueueMessage(
							Text::sprintf('COM_COMPONENTBUILDER_CUSTOM_CODE_S_COULD_NOT_BE_ADDED_TO_BSB_PLEASE_REVIEW_THE_FILE_AFTER_INSTALL_AT_BLINE_SB_AND_REPOSITION_THE_CODE_REMOVE_THE_COMMENTS_AND_RECOMPILE_TO_FIX_THE_ISSUE_THE_ISSUE_COULD_BE_DUE_TO_A_CHANGE_TO_BLINES_ABOVEB_THE_CUSTOM_CODE',
								'<a href="index.php?option=com_componentbuilder&view=custom_codes&task=custom_code.edit&id='
								. $target['id'] . '" target="_blank">#'
								. $target['id'] . '</a>', $target['path'],
								$target['from_line']
							),
							'Warning'
						);
					}
				}
				else
				{
					// Give developer a notice that file is not found.
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HR_HTHREECUSTOM_CODE_WARNINGHTHREE'),
						'Warning'
					);
					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_FILE_BSB_COULD_NOT_BE_FOUND_SO_THE_CUSTOM_CODE_FOR_THIS_FILE_COULD_NOT_BE_ADDDED',
							$target['path']
						),
						'Warning'
					);
				}
			}
		}
	}

	/**
	 * Inject an escaped (commented) version of the custom code when hashes do not match.
	 *
	 * This ensures the code is still present in the compiled output for manual intervention.
	 *
	 * @param  string  $file       The full file path.
	 * @param  array   $target     The custom code target configuration.
	 * @param  array   $lineBites  Line length map used to calculate byte insertion offsets.
	 *
	 * @return void
	 * @since  3.0.0
	 */
	protected function loadEscapedCode($file, $target, $lineBites)
	{
		// get comment type
		if ($target['comment_type'] == 1)
		{
			$commentType  = "// ";
			$_commentType = "";
		}
		else
		{
			$commentType  = "<!--";
			$_commentType = " -->";
		}
		// escape the code
		$code = explode(PHP_EOL, (string) $target['code']);
		$code = PHP_EOL . $commentType . implode(
			$_commentType . PHP_EOL . $commentType, $code
		) . $_commentType . PHP_EOL;
		// get placeholders
		$placeholder = $this->placeholder->keys(
			(int) $target['comment_type'] . $target['type'], $target['id']
		);
		// build the data
		$data = $placeholder['start'] . $code . $placeholder['end'] . PHP_EOL;
		// get the bites before insertion
		$bitBucket = [];
		foreach ($lineBites as $line => $value)
		{
			if ($line < $target['from_line'])
			{
				$bitBucket[] = $value;
			}
		}
		// add to the file
		$this->fileinjector->add($file, $data, (int) array_sum($bitBucket));
	}
}

