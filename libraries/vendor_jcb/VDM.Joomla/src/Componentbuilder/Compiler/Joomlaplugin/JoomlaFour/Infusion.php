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

namespace VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\JoomlaFour;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface as Header;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\PluginDataInterface as Data;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\GetScriptInterface as InstallScript;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Plugin\ExtensionInterface as Extension;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Plugin\ProviderInterface as Provider;
use VDM\Joomla\Componentbuilder\Interfaces\Architecture\Plugin\MainXMLInterface as MainXML;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldsetExtension;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Interfaces\Plugin\InfusionInterface;


/**
 * Joomla 4 Plugin Infusion Class
 * 
 * @since 5.0.2
 */
final class Infusion implements InfusionInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.0.2
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.0.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The Header Class.
	 *
	 * @var   Header
	 * @since 5.0.2
	 */
	protected Header $header;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 5.0.2
	 */
	protected Event $event;

	/**
	 * The PluginData Class.
	 *
	 * @var   Data
	 * @since 5.0.2
	 */
	protected Data $data;

	/**
	 * The GetScript Class.
	 *
	 * @var   InstallScript
	 * @since 5.0.2
	 */
	protected InstallScript $installscript;

	/**
	 * The Extension Class.
	 *
	 * @var   Extension
	 * @since 5.0.2
	 */
	protected Extension $extension;

	/**
	 * The Provider Class.
	 *
	 * @var   Provider
	 * @since 5.0.2
	 */
	protected Provider $provider;

	/**
	 * The MainXML Class.
	 *
	 * @var   MainXML
	 * @since 5.0.2
	 */
	protected MainXML $mainxml;

	/**
	 * The Content Multi Class.
	 *
	 * @var   ContentMulti
	 * @since 5.0.2
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Content One Class.
	 *
	 * @var   ContentOne
	 * @since 5.0.2
	 */
	protected ContentOne $contentone;

	/**
	 * The Fieldset Extension Class.
	 *
	 * @var   FieldsetExtension
	 * @since 5.0.2
	 */
	protected FieldsetExtension $fieldsetextension;

	/**
	 * Constructor.
	 *
	 * @param Config              $config              The Config Class.
	 * @param Placeholder         $placeholder         The Placeholder Class.
	 * @param Header              $header              The HeaderInterface Class.
	 * @param Event               $event               The EventInterface Class.
	 * @param Data                $data                The PluginDataInterface Class.
	 * @param InstallScript       $installscript       The GetScriptInterface Class.
	 * @param Extension           $extension           The ExtensionInterface Class.
	 * @param Provider            $provider            The ProviderInterface Class.
	 * @param MainXML             $mainxml             The MainXMLInterface Class.
	 * @param ContentMulti        $contentmulti        The ContentMulti Class.
	 * @param ContentOne          $contentone          The ContentOne Class.
	 * @param FieldsetExtension   $fieldsetextension   The FieldsetExtension Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Config $config, Placeholder $placeholder, Header $header,
		Event $event, Data $data, InstallScript $installscript,
		Extension $extension, Provider $provider,
		MainXML $mainxml, ContentMulti $contentmulti,
		ContentOne $contentone, FieldsetExtension $fieldsetextension)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->header = $header;
		$this->event = $event;
		$this->data = $data;
		$this->installscript = $installscript;
		$this->extension = $extension;
		$this->provider = $provider;
		$this->mainxml = $mainxml;
		$this->contentmulti = $contentmulti;
		$this->contentone = $contentone;
		$this->fieldsetextension = $fieldsetextension;
	}

	/**
	 * Infuse the plugin data into the content.
	 *
	 * This method processes each plugin in the data set, triggering events
	 * before and after infusion, setting placeholders, and adding content
	 * such as headers, classes, and XML configurations.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	public function set(): void
	{
		if (!$this->data->exists())
		{
			return;
		}

		foreach ($this->data->get() as $plugin)
		{
			if (!ObjectHelper::check($plugin))
			{
				continue;
			}

			$this->triggerBeforeInfusionEvent($plugin);
			$this->setPlaceholders($plugin);
			$this->buildPluginContent($plugin);
			$this->triggerAfterInfusionEvent($plugin);
		}
	}

	/**
	 * Trigger the event before infusing the plugin data.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function triggerBeforeInfusionEvent(&$plugin): void
	{
		$this->event->trigger('jcb_ce_onBeforeInfusePluginData', [&$plugin]);
	}

	/**
	 * Set placeholders based on plugin data.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setPlaceholders($plugin): void
	{
		$this->placeholder->set('PluginGroupNamespace', $plugin->group_namespace ?? '');
		$this->placeholder->set('PluginNamespace', $plugin->namespace ?? '');

		$this->config->build_target = $plugin->key;
		$this->config->lang_target = $plugin->key;
		$this->config->set('lang_prefix', $plugin->lang_prefix);
	}

	/**
	 * Build and set the content related to the plugin.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function buildPluginContent($plugin): void
	{
		$this->setExtensionClassHeader($plugin);
		$this->setExtensionClass($plugin);
		$this->setProviderClassHeader($plugin);
		$this->setProviderClass($plugin);

		if ($plugin->add_install_script)
		{
			$this->setInstallClass($plugin);
		}

		if (isset($plugin->form_files) && ArrayHelper::check($plugin->form_files))
		{
			$this->setFieldsets($plugin);
		}

		$this->setMainXml($plugin);
	}

	/**
	 * Set the extension class header content.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setExtensionClassHeader($plugin): void
	{
		$headerContent = trim(
			$this->header->get('plugin.extension.header', $plugin->class_name)
			. PHP_EOL . ($plugin->header ?? '')
		);

		$this->contentmulti->set("{$plugin->key}|EXTENSION_CLASS_HEADER",
			$this->placeholder->update($headerContent, $this->contentone->allActive())
		);
	}

	/**
	 * Set the extension class content.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setExtensionClass($plugin): void
	{
		$extensionContent = $this->extension->get($plugin);
		$this->contentmulti->set("{$plugin->key}|EXTENSION_CLASS", $extensionContent);
	}

	/**
	 * Set the provider class header content.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setProviderClassHeader($plugin): void
	{
		$providerHeader = $this->header->get('plugin.provider.header', $plugin->class_name);
		$this->contentmulti->set("{$plugin->key}|PROVIDER_CLASS_HEADER", $providerHeader);
	}

	/**
	 * Set the provider class content.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setProviderClass($plugin): void
	{
		$providerContent = $this->provider->get($plugin);
		$this->contentmulti->set("{$plugin->key}|PROVIDER_CLASS", $providerContent);
	}

	/**
	 * Set the install script content, if needed.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setInstallClass($plugin): void
	{
		$installContent = $this->installscript->get($plugin);
		$this->contentmulti->set("{$plugin->key}|INSTALL_CLASS", $installContent);
	}

	/**
	 * Set fieldset content based on form files.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setFieldsets($plugin): void
	{
		foreach ($plugin->form_files as $file => $files)
		{
			foreach ($files as $field_name => $fieldsets)
			{
				foreach ($fieldsets as $fieldset => $fields)
				{
					$fieldsetContent = $this->fieldsetextension->get($plugin, $fields);
					$this->contentmulti->set(
						"{$plugin->key}|FIELDSET_{$file}{$field_name}{$fieldset}",
						$fieldsetContent
					);
				}
			}
		}
	}

	/**
	 * Set the main XML content for the plugin.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function setMainXml($plugin): void
	{
		$mainXmlContent = $this->mainxml->get($plugin);
		$this->contentmulti->set("{$plugin->key}|MAINXML", $mainXmlContent);
	}

	/**
	 * Trigger the event after infusing the plugin data.
	 *
	 * @param object $plugin The plugin object being processed.
	 *
	 * @return void
	 * @since  5.0.2
	 */
	protected function triggerAfterInfusionEvent(&$plugin): void
	{
		$this->event->trigger('jcb_ce_onAfterInfusePluginData', [&$plugin]);
	}
}

