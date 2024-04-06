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
	 * @param   string       $key     The value's key/path name
	 *
	 * @return  string    The path found as a string
	 * @since 3.2.0
	 * @throws  \InvalidArgumentException If $key is not a valid function name.
	 */
	public function __get(string $key): string
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

