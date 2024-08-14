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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Plugin;


use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Language\Set;
use VDM\Joomla\Componentbuilder\Compiler\Language\Purge;
use VDM\Joomla\Componentbuilder\Compiler\Language\Translation;
use VDM\Joomla\Componentbuilder\Compiler\Language\Multilingual;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldsetExtension;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Languages;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Multilingual as BuilderMultilingual;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Interfaces\Architecture\Plugin\MainXMLInterface;


/**
 * Joomla 5 Plugin Main XML Class
 * 
 * @since 5.0.2
 */
final class MainXML implements MainXMLInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.0.2
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 5.0.2
	 */
	protected Language $language;

	/**
	 * The Set Class.
	 *
	 * @var   Set
	 * @since 5.0.2
	 */
	protected Set $set;

	/**
	 * The Purge Class.
	 *
	 * @var   Purge
	 * @since 5.0.2
	 */
	protected Purge $purge;

	/**
	 * The Translation Class.
	 *
	 * @var   Translation
	 * @since 5.0.2
	 */
	protected Translation $translation;

	/**
	 * The Multilingual Class.
	 *
	 * @var   Multilingual
	 * @since 5.0.2
	 */
	protected Multilingual $multilingual;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 5.0.2
	 */
	protected Event $event;

	/**
	 * The FieldsetExtension Class.
	 *
	 * @var   FieldsetExtension
	 * @since 5.0.2
	 */
	protected FieldsetExtension $fieldsetextension;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.0.2
	 */
	protected ContentOne $contentone;

	/**
	 * The Languages Class.
	 *
	 * @var   Languages
	 * @since 5.0.2
	 */
	protected Languages $languages;

	/**
	 * The Multilingual Class.
	 *
	 * @var   BuilderMultilingual
	 * @since 5.0.2
	 */
	protected BuilderMultilingual $buildermultilingual;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 5.0.2
	 */
	protected Counter $counter;

	/**
	 * The File Class.
	 *
	 * @var   File
	 * @since 5.0.2
	 */
	protected File $file;

	/**
	 * Constructor.
	 *
	 * @param Config                $config                The Config Class.
	 * @param Language              $language              The Language Class.
	 * @param Set                   $set                   The Set Class.
	 * @param Purge                 $purge                 The Purge Class.
	 * @param Translation           $translation           The Translation Class.
	 * @param Multilingual          $multilingual          The Multilingual Class.
	 * @param Event                 $event                 The EventInterface Class.
	 * @param FieldsetExtension     $fieldsetextension     The FieldsetExtension Class.
	 * @param ContentOne            $contentone            The ContentOne Class.
	 * @param Languages             $languages             The Languages Class.
	 * @param BuilderMultilingual   $buildermultilingual   The Multilingual Class.
	 * @param Counter               $counter               The Counter Class.
	 * @param File                  $file                  The File Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Config $config, Language $language, Set $set, Purge $purge,
		Translation $translation, Multilingual $multilingual,
		Event $event, FieldsetExtension $fieldsetextension,
		ContentOne $contentone, Languages $languages,
		BuilderMultilingual $buildermultilingual,
		Counter $counter, File $file)
	{
		$this->config = $config;
		$this->language = $language;
		$this->set = $set;
		$this->purge = $purge;
		$this->translation = $translation;
		$this->multilingual = $multilingual;
		$this->event = $event;
		$this->fieldsetextension = $fieldsetextension;
		$this->contentone = $contentone;
		$this->languages = $languages;
		$this->buildermultilingual = $buildermultilingual;
		$this->counter = $counter;
		$this->file = $file;
	}

	/**
	 * Generates the main XML for the plugin.
	 *
	 * @param object $plugin The plugin object.
	 *
	 * @return string The generated XML.
	 * @since  5.0.2
	 */
	public function get(object $plugin): string
	{
		$config_fields = $this->buildConfigFields($plugin);
		$add_component_path = $this->shouldAddComponentPath($plugin);
		$language_files = $this->generateLanguageFiles($plugin);

		$xml = $this->generateScriptAndSqlXml($plugin);
		$xml .= $this->generateLanguageXml($plugin, $language_files);
		$xml .= $this->generateFileXml($plugin, $language_files);
		$xml .= $this->generateConfigXml($plugin, $config_fields, $add_component_path);
		$xml .= $this->generateUpdateServerXml($plugin);

		return $xml;
	}

	/**
	 * Build configuration fields XML.
	 *
	 * @param object $plugin The plugin object.
	 *
	 * @return array The configuration fields.
	 * @since  5.0.2
	 */
	protected function buildConfigFields(object $plugin): array
	{
		$configFields = [];
		if (!isset($plugin->config_fields) || !ArrayHelper::check($plugin->config_fields))
		{
			return $configFields;
		}

		$dbKey = 'yy';

		foreach ($plugin->config_fields as $fieldName => $fieldsets)
		{
			foreach ($fieldsets as $fieldset => $fields)
			{
				$xmlFields = $this->fieldsetextension->get($plugin, $fields, $dbKey);
				if (isset($xmlFields) && StringHelper::check($xmlFields))
				{
					$configFields["{$fieldName}{$fieldset}"] = $xmlFields;
				}
				$dbKey++;
			}
		}

		return $configFields;
	}

	/**
	 * Determine if the component path should be added.
	 *
	 * @param object $plugin The plugin object.
	 *
	 * @return bool True if the component path should be added, false otherwise.
	 * @since  5.0.2
	 */
	protected function shouldAddComponentPath(object $plugin): bool
	{
		if (!isset($plugin->config_fields) || !ArrayHelper::check($plugin->config_fields) ||
			!isset($plugin->fieldsets_paths) || !ArrayHelper::check($plugin->fieldsets_paths))
		{
			return false;
		}

		foreach ($plugin->config_fields as $fieldName => $fieldsets)
		{
			foreach ($fieldsets as $fieldset => $fields)
			{
				if (isset($plugin->fieldsets_paths["{$fieldName}{$fieldset}"]) &&
					$plugin->fieldsets_paths["{$fieldName}{$fieldset}"] == 1)
				{
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Generate XML for script and SQL files.
	 *
	 * @param object $plugin The plugin object.
	 *
	 * @return string The XML for script and SQL files.
	 * @since  5.0.2
	 */
	protected function generateScriptAndSqlXml(object $plugin): string
	{
		$xml = '';

		if ($plugin->add_install_script)
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
				__LINE__,__CLASS__
			) . ' Scripts to run on installation -->';
			$xml .= PHP_EOL . Indent::_(1) . '<scriptfile>script.php</scriptfile>';
		}

		if ($plugin->add_sql)
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
				__LINE__,__CLASS__
			) . ' Runs on install -->';
			$xml .= PHP_EOL . Indent::_(1) . '<install>';
			$xml .= PHP_EOL . Indent::_(2) . '<sql>';
			$xml .= PHP_EOL . Indent::_(3) . '<file driver="mysql" charset="utf8">sql/mysql/install.sql</file>';
			$xml .= PHP_EOL . Indent::_(2) . '</sql>';
			$xml .= PHP_EOL . Indent::_(1) . '</install>';
		}

		if ($plugin->add_sql_uninstall)
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
				__LINE__,__CLASS__
			) . ' Runs on uninstall -->';
			$xml .= PHP_EOL . Indent::_(1) . '<uninstall>';
			$xml .= PHP_EOL . Indent::_(2) . '<sql>';
			$xml .= PHP_EOL . Indent::_(3) . '<file driver="mysql" charset="utf8">sql/mysql/uninstall.sql</file>';
			$xml .= PHP_EOL . Indent::_(2) . '</sql>';
			$xml .= PHP_EOL . Indent::_(1) . '</uninstall>';
		}

		return $xml;
	}

	/**
	 * Generate XML for language files.
	 *
	 * @param object $plugin           The plugin object.
	 * @param array  $languageFiles    The language files.
	 *
	 * @return string The XML for language files.
	 * @since  5.0.2
	 */
	protected function generateLanguageXml(object $plugin, array $languageFiles): string
	{
		$xml = '';

		if (ArrayHelper::check($languageFiles))
		{
			$xml .= PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Language files -->';
			$xml .= PHP_EOL . Indent::_(1) . '<languages folder="language">';

			foreach ($languageFiles as $addTag)
			{
				$xml .= PHP_EOL . Indent::_(2) . '<language tag="'
					. $addTag . '">' . $addTag . '/plg_'
					. strtolower((string) $plugin->group) . '_' .
						(string) $plugin->file_name
					. '.ini</language>';
				$xml .= PHP_EOL . Indent::_(2) . '<language tag="'
					. $addTag . '">' . $addTag . '/plg_'
					. strtolower((string) $plugin->group) . '_' .
						(string) $plugin->file_name
					. '.sys.ini</language>';
			}
			$xml .= PHP_EOL . Indent::_(1) . '</languages>';
		}

		return $xml;
	}

	/**
	 * Generate the XML for the files.
	 *
	 * @param object $plugin           The plugin object.
	 * @param array  $languageFiles    The language files.
	 *
	 * @return string The XML for the files.
	 * @since  5.0.2
	 */
	protected function generateFileXml(object $plugin, array $languageFiles): string
	{
		$files = Folder::files($plugin->folder_path);
		$folders = Folder::folders($plugin->folder_path);
		$ignore = ['sql', 'language', 'script.php', "{$plugin->file_name}.xml"];

		$xml = PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
				__LINE__,__CLASS__
			) . ' Plugin files -->';
		$xml .= PHP_EOL . Indent::_(1) . '<files>';
		$xml .= PHP_EOL . Indent::_(2) . "<folder plugin=\"{$plugin->context_name}\">services</folder>";

		foreach ($files as $file)
		{
			if (!in_array($file, $ignore))
			{
				$xml .= PHP_EOL . Indent::_(2) . "<filename>{$file}</filename>";
			}
		}

		if (!empty($languageFiles))
		{
			// $xml .= PHP_EOL . Indent::_(2) . '<folder>language</folder>';
		}

		if ($plugin->add_sql || $plugin->add_sql_uninstall)
		{
			$xml .= PHP_EOL . Indent::_(2) . '<folder>sql</folder>';
		}

		foreach ($folders as $folder)
		{
			if (!in_array($folder, $ignore))
			{
				$xml .= PHP_EOL . Indent::_(2) . "<folder>{$folder}</folder>";
			}
		}

		$xml .= PHP_EOL . Indent::_(1) . '</files>';

		return $xml;
	}

	/**
	 * Generate XML for configuration fields.
	 *
	 * @param object $plugin           The plugin object.
	 * @param array  $configFields     The configuration fields.
	 * @param bool   $addComponentPath Whether to add the component path.
	 *
	 * @return string The XML for configuration fields.
	 * @since  5.0.2
	 */
	protected function generateConfigXml(object $plugin, array $configFields, bool $addComponentPath): string
	{
		if (!isset($plugin->config_fields) || !ArrayHelper::check($configFields))
		{
			return '';
		}

		$xml = PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
			__LINE__,__CLASS__
		) . ' Config parameters -->';
		$xml .= $addComponentPath ? PHP_EOL . Indent::_(1) . '<config' : PHP_EOL . Indent::_(1) . '<config>';

		if ($addComponentPath)
		{
			$xml .= PHP_EOL . Indent::_(3) . 'addruleprefix="' . $this->config->namespace_prefix . '\Component\\' . $this->contentone->get('ComponentNamespace') . '\Administrator\Rule"';
			$xml .= PHP_EOL . Indent::_(3) . 'addfieldprefix="' . $this->config->namespace_prefix . '\Component\\' . $this->contentone->get('ComponentNamespace') . '\Administrator\Field">';
			$xml .= PHP_EOL . Indent::_(1) . '>';
		}

		foreach ($plugin->config_fields as $fieldName => $fieldsets)
		{
			$xml .= PHP_EOL . Indent::_(1) . "<fields name=\"{$fieldName}\">";

			foreach ($fieldsets as $fieldset => $fields)
			{
				$label = $plugin->fieldsets_label["{$fieldName}{$fieldset}"] ?? $fieldset;

				$xml .= PHP_EOL . Indent::_(1) . "<fieldset name=\"{$fieldset}\" label=\"{$label}\">";

				if (isset($configFields["{$fieldName}{$fieldset}"]))
				{
					$xml .= $configFields["{$fieldName}{$fieldset}"];
				}

				$xml .= PHP_EOL . Indent::_(1) . '</fieldset>';
			}

			$xml .= PHP_EOL . Indent::_(1) . '</fields>';
		}

		$xml .= PHP_EOL . Indent::_(1) . '</config>';

		return $xml;
	}

	/**
	 * Generate XML for update servers.
	 *
	 * @param object $plugin The plugin object.
	 *
	 * @return string The XML for update servers.
	 * @since  5.0.2
	 */
	protected function generateUpdateServerXml(object $plugin): string
	{
		$xml = '';

		if ($plugin->add_update_server)
		{
			$xml = PHP_EOL . PHP_EOL . Indent::_(1) . '<!--' . Line::_(
					__LINE__,__CLASS__
				) . ' Update servers -->';
			$xml .= PHP_EOL . Indent::_(1) . '<updateservers>';
			$xml .= PHP_EOL . Indent::_(2) . '<server type="extension" priority="1" name="' . $plugin->official_name . '">' . $plugin->update_server_url . '</server>';
			$xml .= PHP_EOL . Indent::_(1) . '</updateservers>';
		}

		return $xml;
	}

	/**
	 * Generate language files.
	 *
	 * @param object $plugin The plugin object.
	 *
	 * @return array The language files.
	 * @since  5.0.2
	 */
	protected function generateLanguageFiles(object $plugin): array
	{
		$languageFiles = [];

		if (!$this->language->exist($plugin->key))
		{
			return $languageFiles;
		}

		$langContent = $this->language->getTarget($plugin->key);
		$this->event->trigger('jcb_ce_onBeforeBuildPluginLang', [&$plugin, &$langContent]);

		$values = array_unique($langContent);
		$this->buildermultilingual->set('plugins', $this->multilingual->get($values));

		$langTag = $this->config->get('lang_tag', 'en-GB');
		$this->languages->set("plugins.{$langTag}.all", $langContent);
		$this->language->setTarget($plugin->key, null);

		$this->set->execute($values, $plugin->id, 'plugins');
		$this->purge->execute($values, $plugin->id, 'plugins');

		$this->event->trigger('jcb_ce_onBeforeBuildPluginLangFiles', [&$plugin]);

		if ($this->languages->IsArray('plugins'))
		{
			foreach ($this->languages->get('plugins') as $tag => $areas)
			{
				$tag = trim($tag);
				foreach ($areas as $area => $languageStrings)
				{
					$fileName = "plg_" . strtolower((string)$plugin->group) . '_' . $plugin->file_name . '.ini';
					$total = count($values);
					if ($this->translation->check($tag, $languageStrings, $total, $fileName))
					{
						$lang = array_map(
							fn($langString, $placeholder) => "{$placeholder}=\"{$langString}\"",
							array_values($languageStrings),
							array_keys($languageStrings)
						);

						$path = "{$plugin->folder_path}/language/{$tag}/";

						if (!Folder::exists($path))
						{
							Folder::create($path);
							$this->counter->folder++;
						}

						$this->file->write($path . $fileName, implode(PHP_EOL, $lang));
						$this->file->write(
							$path . 'plg_' . strtolower((string)$plugin->group) . '_' . $plugin->file_name . '.sys.ini',
							implode(PHP_EOL, $lang)
						);

						$this->counter->line += count($lang);
						unset($lang);

						$languageFiles[$tag] = $tag;
					}
				}
			}
		}

		return $languageFiles;
	}
}

