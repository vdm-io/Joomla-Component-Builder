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

namespace VDM\Joomla\Componentbuilder\Compiler\Utilities;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Abstraction\Registry;


/**
 * Compiler Utilities Paths
 * 
 * @since 3.2.0
 */
class Paths extends Registry
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Compiler Component
	 *
	 * @var    Component
	 * @since 3.2.0
	 **/
	protected Component $component;

	/**
	 * Constructor
	 *
	 * @param Config        $config       The compiler config object.
	 * @param Component     $component    The component class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config = null, Component $component = null)
	{
		$this->config = $config;
		$this->component = $component;
	}

	/**
	 * Checks whether a particular registry path exists.
	 *
	 * This override guarantees that the registry is fully initialized before
	 * any existence checks are performed. Initialization is idempotent and
	 * will only execute once per registry lifecycle.
	 *
	 * After initialization, the existence check is delegated entirely to the
	 * parent registry implementation, ensuring full behavioral compatibility.
	 *
	 * @param  string  $path  Registry path (e.g. vdm.content.builder)
	 *
	 * @throws \InvalidArgumentException If any segment of the path is not a string or number.
	 *
	 * @return bool  True if the registry path exists, false otherwise.
	 *
	 * @since  5.1.4
	 */
	public function exists(string $path): bool
	{
		// Ensure the registry is fully initialized before access
		$this->init();

		// Delegate existence check to the base registry implementation
		return parent::exists($path);
	}

	/**
	 * Retrieves a value (or sub-array) from the registry using a dot-notated path.
	 *
	 * This override guarantees that the registry is fully initialized before
	 * any read operation is performed. Initialization is idempotent and will
	 * only occur once for the lifetime of the registry instance.
	 *
	 * After initialization, value resolution is delegated entirely to the
	 * parent registry implementation, preserving full backward compatibility
	 * and expected behavior.
	 *
	 * @param  string  $path     Registry path (e.g. vdm.content.builder)
	 * @param  mixed   $default  Optional default value, returned if the path does not exist.
	 *
	 * @throws \InvalidArgumentException If any segment of the path is not a string or number.
	 *
	 * @return mixed  The resolved value, sub-array, or the provided default.
	 *
	 * @since  5.1.4
	 */
	public function get(string $path, $default = null): mixed
	{
		// Ensure the registry is fully initialized before access
		$this->init();

		// Delegate value resolution to the base registry implementation
		return parent::get($path, $default);
	}

	/**
	 * Initialize the registry state.
	 *
	 * This method performs a one-time, ordered initialization of all
	 * registry-derived component paths and naming conventions required
	 * by the system.
	 *
	 * Initialization is idempotent:
	 * - If the registry is already active, the method exits immediately.
	 * - No state is recalculated or overwritten once activation is complete.
	 *
	 * Responsibilities performed during initialization:
	 * - Resolve and register the base template path.
	 * - Resolve and register the component sales name.
	 * - Resolve and register the component backup name.
	 * - Resolve and register the component folder name.
	 * - Resolve and register the absolute component path.
	 * - Resolve and register the custom template path.
	 *
	 * This method acts as the single authoritative bootstrap point for
	 * registry readiness. Any consumer relying on registry values may
	 * safely assume that, once this method has completed, all dependent
	 * paths and identifiers are valid, consistent, and immutable for the
	 * lifetime of the request.
	 *
	 * This initializer must never:
	 * - Perform conditional logic beyond activation checks.
	 * - Load external services or perform I/O.
	 * - Be called partially or out of order.
	 *
	 * @return void
	 *
	 * @since  5.1.4
	 */
	private function init(): void
	{
		if ($this->isActive())
		{
			return;
		}

		// set the template path
		$this->setTemplatePath();

		// set component sales name
		$this->setComponentSalesName();

		// set component backup name
		$this->setComponentBackupName();

		// set component folder name
		$this->setComponentFolderName();

		// set component path
		$this->setComponentPath();

		// set the template path for custom
		$this->setTemplatePathCustom();
	}

	/**
	 * getting any valid paths
	 *
	 * @param   string  $key The value's key/path name
	 *
	 * @return  string    The path found as a string
	 * @since 3.2.0
	 * @throws  \InvalidArgumentException If $key is not a valid function name.
	 */
	public function __get($key)
	{
		// check if it has been set
		if ($this->exists($key))
		{
			return $this->get($key);
		}

		throw new \InvalidArgumentException(sprintf('Path %s could not be found in the Paths Class.', $key));
	}

	/**
	 * Set the template path
	 *
	 * @return void
	 *
	 * @since 3.2.0
	 */
	private function setTemplatePath(): void
	{
		$this->set('template_path',
			$this->config->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler') . '/joomla_'
			. $this->config->joomla_versions[$this->config->joomla_version]['folder_key']
		);
	}

	/**
	 * Set component sales name
	 *
	 * @return void
	 *
	 * @since 3.2.0
	 */
	private function setComponentSalesName(): void
	{
		$this->set('component_sales_name',
			'com_' . $this->component->get('sales_name') . '__J'
			. $this->config->joomla_version
		);
	}

	/**
	 * Set component backup name
	 *
	 * @return void
	 *
	 * @since 3.2.0
	 */
	private function setComponentBackupName(): void
	{
		$this->set('component_backup_name',
			'com_' . $this->component->get('sales_name') . '_v' . str_replace(
				'.', '_', (string) $this->component->get('component_version')
			) . '__J' . $this->config->joomla_version
		);
	}

	/**
	 * Set component folder name
	 *
	 * @return void
	 *
	 * @since 3.2.0
	 */
	private function setComponentFolderName(): void
	{
		$this->set('component_folder_name',
			'com_' . $this->component->get('name_code') . '_v' . str_replace(
				'.', '_', (string) $this->component->get('component_version')
			) . '__J' . $this->config->joomla_version
		);
	}

	/**
	 * Set component path
	 *
	 * @return void
	 *
	 * @since 3.2.0
	 */
	private function setComponentPath(): void
	{
		$this->set('component_path',
			$this->config->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler') . '/'
			. $this->get('component_folder_name')
		);
	}

	/**
	 * set the template path for custom TODO: just use custom_folder_path in config
	 *
	 * @return void
	 *
	 * @since 3.2.0
	 */
	private function setTemplatePathCustom(): void
	{
		$this->set('template_path_custom',
			$this->config->get(
				'custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR . '/custom'
			)
		);
	}
}

