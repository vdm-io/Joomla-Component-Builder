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

namespace VDM\Joomla\Componentbuilder\Compiler\Customcode\Extractor;


use Joomla\CMS\Factory;
use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder as ComponentPlaceholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Language\Extractor;


/**
 * Compiler Custom Code Paths
 * 
 * @since 3.2.0
 */
class Paths
{
	/**
	 * The local paths
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $active = [];

	/**
	 * Compiler Component Placeholder
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $componentPlaceholder;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 **/
	protected Customcode $customcode;

	/**
	 * Compiler Language Extractor
	 *
	 * @var    Extractor
	 * @since 3.2.0
	 **/
	protected Extractor $extractor;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor.
	 *
	 * @param Config|null                 $config               The compiler config object.
	 * @param Placeholder|null            $placeholder          The compiler placeholder object.
	 * @param ComponentPlaceholder|null   $componentPlaceholder The compiler component placeholder object.
	 * @param Customcode|null   	      $customcode           The compiler customcode object.
	 * @param Extractor|null              $extractor            The compiler language extractor object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Placeholder $placeholder = null,
		?ComponentPlaceholder $componentPlaceholder = null, ?Customcode $customcode = null,
		?Extractor $extractor = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		/** @var ComponentPlaceholder $componentPlaceholder */
		$componentPlaceholder = $componentPlaceholder ?: Compiler::_('Component.Placeholder');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->extractor = $extractor ?: Compiler::_('Language.Extractor');
		$this->db = Factory::getDbo();

		// load the placeholders to local array
		$this->componentPlaceholder = $componentPlaceholder->get();

		// load the paths on initialization
		$this->load();
	}

	/**
	 * get the local installed path of this component
 	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function load()
	{
		// set the local paths to search
		$local_paths = [];

		// admin path
		$local_paths['admin'] = JPATH_ADMINISTRATOR . '/components/com_'
			. $this->config->component_code_name;

		// site path
		$local_paths['site'] = JPATH_ROOT . '/components/com_'
			. $this->config->component_code_name;

		// media path
		$local_paths['media'] = JPATH_ROOT . '/media/com_'
			. $this->config->component_code_name;

		// power path
		$local_paths['power'] = JPATH_ROOT . '/' . $this->config->get('jcb_powers_path', 'libraries/jcb_powers');

		// lets also go over the REPOS - TODO

		// Painful but we need to folder paths for the linked modules
		if (($module_ids = $this->getModuleIDs()) !== false)
		{
			foreach ($module_ids as $module_id)
			{
				// get the module folder path
				if (($path = $this->getModulePath($module_id)) !== false)
				{
					// set the path
					$local_paths['module_' . str_replace('/', '_', (string) $path)] = $path;
				}
			}
		}

		// Painful but we need to folder paths for the linked plugins
		if (($plugin_ids = $this->getPluginIDs()) !== false)
		{
			foreach ($plugin_ids as $plugin_id)
			{
				// get the plugin group and folder name
				if (($path = $this->getPluginPath($plugin_id)) !== false)
				{
					// set the path
					$local_paths['plugin_' . str_replace('/', '_', (string) $path)] = JPATH_ROOT . '/plugins/' . $path;
				}
			}
		}

		// check if the local install is found
		foreach ($local_paths as $key => $localPath)
		{
			if (!Folder::exists($localPath))
			{
				unset($local_paths[$key]);
			}
		}

		if (ArrayHelper::check($local_paths))
		{
			$this->active =  $local_paths;
		}
	}

	/**
	 * get the Joomla Modules IDs
	 *
	 * @return  mixed of IDs on success
	 * @since 3.2.0
	 */
	protected function getModuleIDs()
	{
		if (($addjoomla_modules = GetHelper::var(
				'component_modules', $this->config->component_id, 'joomla_component',
				'addjoomla_modules'
			)) !== false)
		{
			$addjoomla_modules = (JsonHelper::check(
				$addjoomla_modules
			)) ? json_decode((string) $addjoomla_modules, true) : null;

			if (ArrayHelper::check($addjoomla_modules))
			{
				$joomla_modules = array_filter(
					array_values($addjoomla_modules),
					// only load the modules whose target association call for it
					fn($array): bool => !isset($array['target']) || $array['target'] != 2
				);
				// if we have values we return IDs
				if (ArrayHelper::check($joomla_modules))
				{
					return array_map(
						fn($array) => (int) $array['module'], $joomla_modules
					);
				}
			}
		}

		return false;
	}

	/**
	 * get the Joomla module path
	 *
	 * @return  mixed of module path and target site area on success
	 * @since 3.2.0
	 */
	protected function getModulePath($id)
	{
		if (is_numeric($id) && $id > 0)
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'a.name',
						'a.target'
					), array(
						'name',
						'target'
					)
				)
			);
			// from these tables
			$query->from('#__componentbuilder_joomla_module AS a');
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// get the module data
				$module = $this->db->loadObject();
				// update the name if it has dynamic values
				$module->name = $this->placeholder->update(
					$this->customcode->update($module->name),
					$this->componentPlaceholder
				);

				// set safe class function name
				$module->code_name
					= ClassfunctionHelper::safe(
					$module->name
				);
				// set module folder name
				$module->folder_name = 'mod_' . strtolower((string) $module->code_name);

				// set the lang key
				$this->extractor->langKeys[strtoupper($module->folder_name)] = 
					$module->id . '_M0dUl3';

				// return the path
				if ($module->target == 2)
				{
					// administrator client area
					return JPATH_ADMINISTRATOR . '/modules/'
						. $module->folder_name;
				}
				else
				{
					// default is the site client area
					return JPATH_ROOT . '/modules/' . $module->folder_name;
				}
			}
		}

		return false;
	}

	/**
	 * get the Joomla plugins IDs
	 *
	 * @return  mixed of IDs on success
	 * @since 3.2.0
	 */
	protected function getPluginIDs()
	{
		if (($addjoomla_plugins = GetHelper::var(
				'component_plugins', $this->config->component_id, 'joomla_component',
				'addjoomla_plugins'
			)) !== false)
		{
			$addjoomla_plugins = (JsonHelper::check(
				$addjoomla_plugins
			)) ? json_decode((string) $addjoomla_plugins, true) : null;

			if (ArrayHelper::check($addjoomla_plugins))
			{
				$joomla_plugins = array_filter(
					array_values($addjoomla_plugins),
					function ($array) {
						// only load the plugins whose target association call for it
						if (!isset($array['target']) || $array['target'] != 2)
						{
							return true;
						}

						return false;
					}
				);
				// if we have values we return IDs
				if (ArrayHelper::check($joomla_plugins))
				{
					return array_map(
						fn($array) => (int) $array['plugin'], $joomla_plugins
					);
				}
			}
		}

		return false;
	}

	/**
	 * get the Joomla plugin path
	 *
	 * @return  mixed  of plugin path on success
	 * @deprecated 3.3
	 */
	protected function getPluginPath($id)
	{
		if (is_numeric($id) && $id > 0)
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'a.name',
						'g.name'
					), array(
						'name',
						'group'
					)
				)
			);

			// from these tables
			$query->from('#__componentbuilder_joomla_plugin AS a');
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_plugin_group', 'g'
				) . ' ON (' . $this->db->quoteName('a.joomla_plugin_group')
				. ' = ' . $this->db->quoteName('g.id') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$this->db->setQuery($query);
			$this->db->execute();

			if ($this->db->getNumRows())
			{
				// get the plugin data
				$plugin = $this->db->loadObject();

				// update the name if it has dynamic values
				$plugin->name = $this->placeholder->update(
					$this->customcode->update($plugin->name),
					$this->componentPlaceholder
				);

				// update the name if it has dynamic values
				$plugin->code_name
					= ClassfunctionHelper::safe(
					$plugin->name
				);

				// set plugin folder name
				$plugin->group = strtolower((string) $plugin->group);
				// set plugin file name
				$plugin->file_name = strtolower((string) $plugin->code_name);

				// set the lang key
				$this->extractor->langKeys['PLG_' . strtoupper(
					$plugin->group . '_' . $plugin->file_name
				)] = $plugin->id . '_pLuG!n';

				// return the path
				return $plugin->group . '/' . $plugin->file_name;
			}
		}

		return false;
	}

}

