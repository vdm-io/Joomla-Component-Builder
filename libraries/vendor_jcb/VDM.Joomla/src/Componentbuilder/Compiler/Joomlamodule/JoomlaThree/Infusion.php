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

namespace VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\JoomlaThree;


use VDM\Joomla\Componentbuilder\Compiler\Config;
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
 * Joomla 3 module Infusion Class
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
	 * The DispatcherInterface Class.
	 *
	 * @var   Dispatcher
	 * @since 5.1.2
	 */
	protected Dispatcher $dispatcher;

	/**
	 * The TemplateInterface Class.
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
	 * The MainXMLInterface Class.
	 *
	 * @var   MainXML
	 * @since 5.1.2
	 */
	protected MainXML $mainxml;

	/**
	 * The ModuleDataInterface Class.
	 *
	 * @var   Data
	 * @since 5.1.2
	 */
	protected Data $data;

	/**
	 * The HeaderInterface Class.
	 *
	 * @var   Header
	 * @since 5.1.2
	 */
	protected Header $header;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 5.1.2
	 */
	protected Event $event;

	/**
	 * The InstallInterface Class.
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
	 * @param Dispatcher          $dispatcher          The DispatcherInterface Class.
	 * @param Template            $template            The TemplateInterface Class.
	 * @param Helper              $helper              The Helper Class.
	 * @param MainXML             $mainxml             The MainXMLInterface Class.
	 * @param Data                $data                The ModuleDataInterface Class.
	 * @param Header              $header              The HeaderInterface Class.
	 * @param Event               $event               The EventInterface Class.
	 * @param InstallScript       $installscript       The InstallInterface Class.
	 * @param ContentMulti        $contentmulti        The ContentMulti Class.
	 * @param FieldsetExtension   $fieldsetextension   The FieldsetExtension Class.
	 * @param Methods             $methods             The Methods Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, Dispatcher $dispatcher, Template $template,
		Helper $helper, MainXML $mainxml, Data $data,
		Header $header, Event $event,
		InstallScript $installscript, ContentMulti $contentmulti,
		FieldsetExtension $fieldsetextension, Methods $methods)
	{
		$this->config = $config;
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
	 * Set dispatcher-generated module code.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setDispatcherCode(object $module): void
	{
		$this->contentmulti->set("{$module->key}|MODCODE", $header . $this->dispatcher->get($module));
	}

	/**
	 * Set dynamically generated methods.
	 *
	 * @param object $module
	 *
	 * @return void
	 * @since 5.1.2
	 */
	protected function setDynamicGets(object $module): void
	{
		$this->contentmulti->set("{$module->key}|DYNAMICGETS", $this->methods->get($module, $module->key));
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
			$header = $this->helper->header($module);
			$code = $this->helper->get($module);

			$this->contentmulti->set("{$module->key}|HELPERCODE", $header . $code);
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
		$this->contentmulti->set(
			"{$module->key}|MODDEFAULT",
			$this->template->default($module, $module->key)
		);

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

