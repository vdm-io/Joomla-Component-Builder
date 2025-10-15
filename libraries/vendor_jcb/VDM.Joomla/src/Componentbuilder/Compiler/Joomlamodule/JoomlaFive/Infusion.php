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

namespace VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaFive;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\ProviderInterface as Provider;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\DispatcherInterface as Dispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\TemplateInterface as Template;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\HelperInterface as Helper;
use VDM\Joomla\Componentbuilder\Interfaces\Architecture\Module\MainXMLInterface as MainXML;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\ModuleDataInterface as Data;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface as Header;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\GetScriptInterface as InstallScript;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Creator\FieldsetExtension;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Methods;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Interfaces\Module\InfusionInterface;


/**
 * Joomla 5 module Infusion Class
 * 
 * @since 5.1.2
 */
final class Infusion implements InfusionInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The Provider Class.
	 *
	 * @var   Provider
	 * @since 5.1.2
	 */
	protected Provider $provider;

	/**
	 * The Dispatcher Class.
	 *
	 * @var   Dispatcher
	 * @since 5.1.2
	 */
	protected Dispatcher $dispatcher;

	/**
	 * The Template Class.
	 *
	 * @var   Template
	 * @since 5.1.2
	 */
	protected Template $template;

	/**
	 * The Helper Class.
	 *
	 * @var   Helper
	 * @since 5.1.2
	 */
	protected Helper $helper;

	/**
	 * The MainXML Class.
	 *
	 * @var   MainXML
	 * @since 5.1.2
	 */
	protected MainXML $mainxml;

	/**
	 * The ModuleData Class.
	 *
	 * @var   Data
	 * @since 5.1.2
	 */
	protected Data $data;

	/**
	 * The Header Class.
	 *
	 * @var   Header
	 * @since 5.1.2
	 */
	protected Header $header;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 5.1.2
	 */
	protected Event $event;

	/**
	 * The Install Class.
	 *
	 * @var   InstallScript
	 * @since 5.1.2
	 */
	protected InstallScript $installscript;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 5.1.2
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The FieldsetExtension Class.
	 *
	 * @var   FieldsetExtension
	 * @since 5.1.2
	 */
	protected FieldsetExtension $fieldsetextension;

	/**
	 * The Methods Class.
	 *
	 * @var   Methods
	 * @since 5.1.2
	 */
	protected Methods $methods;

	/**
	 * Constructor.
	 *
	 * @param Config              $config              The Config Class.
	 * @param Provider            $provider            The Provider Class.
	 * @param Dispatcher          $dispatcher          The Dispatcher Class.
	 * @param Template            $template            The Template Class.
	 * @param Helper              $helper              The Helper Class.
	 * @param MainXML             $mainxml             The MainXML Class.
	 * @param Data                $data                The ModuleData Class.
	 * @param Header              $header              The Header Class.
	 * @param Event               $event               The Event Class.
	 * @param InstallScript       $installscript       The GetScript Class.
	 * @param ContentMulti        $contentmulti        The ContentMulti Class.
	 * @param FieldsetExtension   $fieldsetextension   The FieldsetExtension Class.
	 * @param Methods             $methods             The Methods Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, Provider $provider, Dispatcher $dispatcher,
		Template $template, Helper $helper, MainXML $mainxml,
		Data $data, Header $header, Event $event,
		InstallScript $installscript, ContentMulti $contentmulti,
		FieldsetExtension $fieldsetextension, Methods $methods)
	{
		$this->config = $config;
		$this->provider = $provider;
		$this->dispatcher = $dispatcher;
		$this->template = $template;
		$this->helper = $helper;
		$this->mainxml = $mainxml;
		$this->data = $data;
		$this->header = $header;
		$this->event = $event;
		$this->installscript = $installscript;
		$this->contentmulti = $contentmulti;
		$this->fieldsetextension = $fieldsetextension;
		$this->methods = $methods;
	}

	/**
	 * Infuse the module data into the content.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	public function set(): void
	{
		if (!$this->data->exists())
		{
			return;
		}

		foreach ($this->data->get() as $module)
		{
			if (!ObjectHelper::check($module))
			{
				continue;
			}

			$this->triggerBeforeInfusionEvent($module);
			$this->setModuleConfiguration($module);
			$this->setProviderCode($module);
			$this->setDispatcherCode($module);
			$this->setDynamicGets($module);
			$this->setHelperCode($module);
			$this->setDefaultTemplates($module);
			$this->setInstallScript($module);
			$this->setFieldsets($module);
			$this->setMainXml($module);
			$this->triggerAfterInfusionEvent($module);
		}
	}

	/**
	 * Set core configuration from module data.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setModuleConfiguration(object $module): void
	{
		$this->config->build_target = $module->key;
		$this->config->lang_target = $module->key;
		$this->config->set('lang_prefix', $module->lang_prefix);
	}

	/**
	 * Set the provider provider code.
	 *
	 * @param object $module The module object being processed.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function setProviderCode($module): void
	{
		$header = trim((string) ($this->header->get('module.provider.header', $module->class_name) ?? ''));
		if ($header !== '')
		{
			$header = PHP_EOL . PHP_EOL . $header;
		}
		$this->contentmulti->set("{$module->key}|PROVIDER_CLASS_HEADER", $header);

		$providerContent = $this->provider->get($module);
		$this->contentmulti->set("{$module->key}|PROVIDER_CLASS", $providerContent);
	}

	/**
	 * Set dispatcher-generated module code.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setDispatcherCode(object $module): void
	{
		$header = trim((string) ($this->header->get('module.dispatcher.header', $module->class_name) ?? ''));
		if ($header !== '')
		{
			$header = PHP_EOL . PHP_EOL . $header;
		}
		$this->contentmulti->set("{$module->key}|DISPATCHER_CLASS_HEADER", $header);

		$code = $this->dispatcher->get($module);
		$this->contentmulti->set("{$module->key}|DISPATCHER_CLASS", $code);
	}

	/**
	 * Set dynamically generated get methods (dynamicGets).
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setDynamicGets(object $module): void
	{
		if ($module->custom_get)
		{
			$header = trim((string) ($this->header->get('module.dynamicgets.header', $module->class_name) ?? ''));
			if ($header !== '')
			{
				$header = PHP_EOL . PHP_EOL . $header;
			}
			$this->contentmulti->set("{$module->key}|DYNAMICGETS_HEADER", $header);

			$code = $this->methods->get($module, $module->key);
			$this->contentmulti->set("{$module->key}|DYNAMICGETS", $code);
		}
	}

	/**
	 * Set helper class code if enabled.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setHelperCode(object $module): void
	{
		if ($module->add_class_helper >= 1)
		{
			$header = trim((string) ($this->header->get('module.helper.header', $module->class_name) ?? ''));
			$header .= $this->helper->header($module);
			if (!empty($header))
			{
				$header = PHP_EOL . PHP_EOL . trim($header);
			}
			$this->contentmulti->set("{$module->key}|HELPER_CLASS_HEADER", $header);

			$code = $this->helper->get($module);
			$this->contentmulti->set("{$module->key}|HELPER_CLASS", $code);
		}
	}

	/**
	 * Set default and extra templates.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setDefaultTemplates(object $module): void
	{
		$header = trim((string) ($this->header->get('module.default.template.header', $module->class_name) ?? ''));
		if ($header !== '')
		{
			$header = PHP_EOL . PHP_EOL . $header;
		}
		$this->contentmulti->set("{$module->key}|MODDEFAULT_HEADER", $header);

		$header_code = $this->template->header($module);
		$this->contentmulti->set("{$module->key}|MODDEFAULT_HEADER_CODE", $header_code);

		$code = $this->template->default($module, $module->key);
		$this->contentmulti->set("{$module->key}|MODDEFAULT", $code);

		$this->template->extra($module);
	}

	/**
	 * Set install script content if required.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setInstallScript(object $module): void
	{
		if ($module->add_install_script)
		{
			$this->contentmulti->set("{$module->key}|INSTALLCLASS",
				$this->installscript->get($module));
		}
	}

	/**
	 * Set all fieldset content based on form files.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setFieldsets(object $module): void
	{
		if (!isset($module->form_files) || !ArrayHelper::check($module->form_files))
		{
			return;
		}

		foreach ($module->form_files as $file => $files)
		{
			foreach ($files as $field_name => $fieldsets)
			{
				foreach ($fieldsets as $fieldset => $fields)
				{
					$key = "{$module->key}|FIELDSET_{$file}{$field_name}{$fieldset}";
					$content = $this->fieldsetextension->get($module, $fields);
					$this->contentmulti->set($key, $content);
				}
			}
		}
	}

	/**
	 * Set main XML configuration content.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setMainXml(object $module): void
	{
		$this->contentmulti->set("{$module->key}|MAINXML", $this->mainxml->get($module));
	}

	/**
	 * Trigger before-infusion event.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function triggerBeforeInfusionEvent(object &$module): void
	{
		$this->event->trigger('jcb_ce_onBeforeInfuseModuleData', [&$module]);
	}

	/**
	 * Trigger after-infusion event.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function triggerAfterInfusionEvent(object &$module): void
	{
		$this->event->trigger('jcb_ce_onAfterInfuseModuleData', [&$module]);
	}
}

