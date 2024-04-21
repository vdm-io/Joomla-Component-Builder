<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Component\Componentbuilder\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\User\User;
use Joomla\Utilities\ArrayHelper;
use Joomla\Input\Input;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\CMS\Helper\TagsHelper;
use VDM\Joomla\Componentbuilder\Package\Factory as PackageFactory;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\Base64Helper;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\FOF\Encrypt\AES;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_components List Model
 *
 * @since  1.6
 */
class Joomla_componentsModel extends ListModel
{
	/**
	 * The application object.
	 *
	 * @var   CMSApplicationInterface  The application instance.
	 * @since 3.2.0
	 */
	protected CMSApplicationInterface $app;

	/**
	 * The styles array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $styles = [
		'administrator/components/com_componentbuilder/assets/css/admin.css',
		'administrator/components/com_componentbuilder/assets/css/joomla_components.css'
 	];

	/**
	 * The scripts array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $scripts = [
		'administrator/components/com_componentbuilder/assets/js/admin.js'
 	];

	/**
	 * Constructor
	 *
	 * @param   array                 $config   An array of configuration options (name, state, dbo, table_path, ignore_request).
	 * @param   ?MVCFactoryInterface  $factory  The factory.
	 *
	 * @since   1.6
	 * @throws  \Exception
	 */
	public function __construct($config = [], MVCFactoryInterface $factory = null)
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
				'a.access','access',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'a.companyname','companyname',
				'a.author','author',
				'a.system_name','system_name',
				'a.name_code','name_code',
				'a.short_description','short_description',
				'a.created','created',
				'a.modified','modified'
			);
		}

		parent::__construct($config, $factory);

		$this->app ??= Factory::getApplication();
	}

	public $user;
	public $packagePath = false;
	public $packageName = false;
	public $zipPath = false;
	public $key = array();
	public $exportBuyLinks = array();
	public $joomlaSourceLinks = array();
	public $info = array(
		'name' => array(),
		'short_description' => array(),
		'component_version' => array(),
		'companyname' => array(),
		'author' => array(),
		'email' => array(),
		'website' => array(),
		'license' => array(),
		'copyright' => array(),
		'getKeyFrom' => null
		);
	public $activeType = 'export';
	public $backupType = 1;

	protected $params;
	protected $tempPath;
	protected $customPath;
	protected $smartBox = array();
	protected $smartIDs = array();
	protected $customCodeM = array();
	protected $placeholderM = array();
	protected $placeholderS = array();
	protected $fieldTypes = array();
	protected $isMultiple = array();

	/**
	* Method to clone the component
	*
	* @return bool on success.
	*/
	public function cloner($pks)
	{
		// get the components 
		if ($items = $this->getComponents($pks))
		{
			// update $pks with returned IDs
			$pks = array();
			// start loading the components
			$this->smartBox['joomla_component'] = array();
			foreach ($items as $nr => &$item)
			{
				// check if user has access
				$access = ($this->user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $this->user->authorise('joomla_component.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}
				// make sure old fields are not exported any more
				$this->removeOldComponentValues($item);
				// load to global object
				$this->smartBox['joomla_component'][$item->id] = $item;
				// set the powers linked to this joomla component
				$this->setSmartIDs($this->getValues($item->params, 'power', 'joomla_component_headers', null), 'power', false);
				// add to pks
				$pks[] = $item->id;
			}

			// has any data been set for this component
			if (JCBArrayHelper::check($pks))
			{
				// load the linked stuff
				$this->getLinkedToComponents($pks);
			}

			// has any data been set for this component
			if (isset($this->smartBox['joomla_component']) && JCBArrayHelper::check($this->smartBox['joomla_component']))
			{
				// set the folder and move the files of each component to the folder
				return $this->smartCloner();
			}
		}
		return false;
	}

	/**
	* Method to build the export package
	*
	* @return bool on success.
	*/
	public function getSmartExport($pks)
	{
		// get the components 
		if ($items = $this->getComponents($pks))
		{
			// set custom folder path
			$this->customPath = $this->params->get('custom_folder_path', JPATH_COMPONENT_ADMINISTRATOR.'/custom');
			// set the backup paths
			$comConfig = Factory::getConfig();
			$this->backupPath = $comConfig->get('tmp_path');
			// check what type of export or backup this is
			if ('backup' === $this->activeType || 'manualBackup' === $this->activeType)
			{
				// set the zip path
				$this->zipPath = $this->params->get('cronjob_backup_folder_path', $this->backupPath);
				// check what backup type we are working with here
				$this->backupType = $this->params->get('cronjob_backup_type', 1); // 1 = local folder; 2 = remote server (default is local)
				// if remote server get the ID
				if (2 == $this->backupType)
				{
					$this->backupServer = $this->params->get('cronjob_backup_server', null);
				}
				// set the date array
				$date = Factory::getDate();
				$placeholderDate = array();
				$placeholderDate['[YEAR]'] = $date->format('Y');
				$placeholderDate['[MONTH]'] = $date->format('m');
				$placeholderDate['[DAY]'] = $date->format('d');
				$placeholderDate['[HOUR]'] = $date->format('H');
				$placeholderDate['[MINUTE]'] = $date->format('i');
				// get the package name
				$packageName = $this->params->get('backup_package_name', 'JCB_Backup_[YEAR]_[MONTH]_[DAY]');
				$this->packageName = str_replace(array_keys($placeholderDate), array_values($placeholderDate), $packageName);
			}
			else
			{
				// set the zip path
				$this->zipPath = $this->backupPath;
				// set the package name
				if (count($items) == 1)
				{
					$this->packageName = 'JCB_' . $this->getPackageName($items);
				}
				else
				{
					$this->packageName = 'JCB_smartPackage';
				}
			}

			// set the package path
			$this->packagePath = rtrim($this->backupPath, '/') . '/' . $this->packageName;
			$this->zipPath =  rtrim($this->zipPath, '/') . '/' . $this->packageName .'.zip';
			if (FileHelper::exists($this->packagePath))
			{
				// remove if old folder is found
				ComponentbuilderHelper::removeFolder($this->packagePath);
			}

			// create the folders
			JFolder::create($this->packagePath);

			// update $pks with returned IDs
			$pks = array();

			// start loading the components
			$this->smartBox['joomla_component'] = array();
			foreach ($items as $nr => &$item)
			{
				// check if user has access
				$access = ($this->user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $this->user->authorise('joomla_component.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

				// make sure old fields are not exported any more
				$this->removeOldComponentValues($item);

				// build information data set
				$this->info['name'][$item->id] = $item->name;
				$this->info['short_description'][$item->id] = $item->short_description;
				$this->info['component_version'][$item->id] = $item->component_version;
				$this->info['companyname'][$item->id] = $item->companyname;
				$this->info['author'][$item->id] = $item->author;
				$this->info['email'][$item->id] = $item->email;
				$this->info['website'][$item->id] = $item->website;
				$this->info['license'][$item->id] = $item->license;
				$this->info['copyright'][$item->id] = $item->copyright;

				// set the keys
				if (isset($item->export_key) && StringHelper::check($item->export_key))
				{
					// keep the key locked for exported data set
					$export_key = $item->export_key;
					if (!is_numeric($item->export_key) && $item->export_key === base64_encode(base64_decode($item->export_key, true)))
					{
						$export_key = PackageFactory::_('Crypt')->decrypt($item->export_key, 'basic');
					}
					// make sure we have a string
					if (strlen($export_key) > 4 )
					{
						$this->key[$item->id] = $export_key;
					}
				}

				// get name of this item key_name
				if (isset($item->system_name))
				{
					$keyName = StringHelper::safe($item->system_name, 'cAmel');
				}
				else
				{
					$keyName = StringHelper::safe($item->name_code);
				}

				// set the export buy links
				if (isset($item->export_buy_link) && StringHelper::check($item->export_buy_link))
				{
					// set the export buy link
					$this->info['export_buy_link'][$item->id] = $item->export_buy_link;
				}

				// set the export buy links
				if (isset($item->joomla_source_link) && StringHelper::check($item->joomla_source_link))
				{
					// set the source link
					$this->info['joomla_source_link'][$item->id] = $item->joomla_source_link;
				}

				// component image
				$this->moveIt(array($item->image), 'image');
				// set the custom code ID's
				$this->setCodePlaceholdersIds($item, 'joomla_component');
				// set the placeholder ID's
				$this->setCodePlaceholdersIds($item, 'joomla_component', 'placeholder');
				// set the language strings for this component
				$this->setLanguageTranslation($item->id);
				// load to global object
				$this->smartBox['joomla_component'][$item->id] = $item;
				// set the powers linked to this joomla component
				$this->setSmartIDs($this->getValues($item->params, 'power', 'joomla_component_headers', null), 'power', false);
				// add to pks
				$pks[] = $item->id;
			}

			// has any data been set for this component
			if (JCBArrayHelper::check($pks))
			{
				// load the linked stuff
				$this->getLinkedToComponents($pks);
			}

			// has any data been set for this component
			if (isset($this->smartBox['joomla_component']) && JCBArrayHelper::check($this->smartBox['joomla_component']))
			{
				// set the folder and move the files of each component to the folder
				return $this->smartExportBuilder();
			}
		}
		return false;
	}

	/**
	* Get Everything Linked to Components
	*
	* @return void
	*/
	protected function getLinkedToComponents($pks)
	{
		// array of tables linked to joomla_component
		$linkedTables = array(
			'custom_code' => 'component',
			'component_files_folders' => 'joomla_component',
			'component_admin_views' => 'joomla_component',
			'component_config' => 'joomla_component',
			'component_site_views' => 'joomla_component',
			'component_custom_admin_views' => 'joomla_component',
			'component_updates' => 'joomla_component',
			'component_mysql_tweaks' => 'joomla_component',
			'component_custom_admin_menus' => 'joomla_component',
			'component_dashboard' => 'joomla_component',
			'component_placeholders' => 'joomla_component',
			'component_modules' => 'joomla_component',
			'component_plugins' => 'joomla_component');
		// load all tables linked to joomla_component
		foreach($linkedTables as $table => $field)
		{
			$this->setData($table, $pks, $field);
		}
		// add fields conditions and relations
		if (isset($this->smartIDs['admin_view']) && JCBArrayHelper::check($this->smartIDs['admin_view']))
		{
			$this->setData('admin_fields', array_values($this->smartIDs['admin_view']), 'admin_view');
			$this->setData('admin_fields_conditions', array_values($this->smartIDs['admin_view']), 'admin_view');
			$this->setData('admin_fields_relations', array_values($this->smartIDs['admin_view']), 'admin_view');
			$this->setData('admin_custom_tabs', array_values($this->smartIDs['admin_view']), 'admin_view');
		}
		// add joomla module
		if (isset($this->smartIDs['joomla_module']) && JCBArrayHelper::check($this->smartIDs['joomla_module']))
		{
			$this->setData('joomla_module', array_values($this->smartIDs['joomla_module']), 'id');
			$this->setData('joomla_module_updates', array_values($this->smartIDs['joomla_module']), 'joomla_module');
			$this->setData('joomla_module_files_folders_urls', array_values($this->smartIDs['joomla_module']), 'joomla_module');
		}
		// add joomla plugin
		if (isset($this->smartIDs['joomla_plugin']) && JCBArrayHelper::check($this->smartIDs['joomla_plugin']))
		{
			$this->setData('joomla_plugin', array_values($this->smartIDs['joomla_plugin']), 'id');
			$this->setData('joomla_plugin_updates', array_values($this->smartIDs['joomla_plugin']), 'joomla_plugin');
			$this->setData('joomla_plugin_files_folders_urls', array_values($this->smartIDs['joomla_plugin']), 'joomla_plugin');
		}
		// add validation rules
		if (isset($this->smartIDs['validation_rule']) && JCBArrayHelper::check($this->smartIDs['validation_rule']))
		{
			$this->setData('validation_rule', array_values($this->smartIDs['validation_rule']), 'name');
		}
		// add field types
		if (isset($this->smartIDs['fieldtype']) && JCBArrayHelper::check($this->smartIDs['fieldtype']))
		{
			$this->setData('fieldtype', array_values($this->smartIDs['fieldtype']), 'id');
		}
		// add templates
		if (isset($this->smartIDs['template']) && JCBArrayHelper::check($this->smartIDs['template']))
		{
			$this->setData('template', array_values($this->smartIDs['template']), 'id');
		}
		// add layouts
		if (isset($this->smartIDs['layout']) && JCBArrayHelper::check($this->smartIDs['layout']))
		{
			$this->setData('layout', array_values($this->smartIDs['layout']), 'id');
		}
		// add dynamic get
		if (isset($this->smartIDs['dynamic_get']) && JCBArrayHelper::check($this->smartIDs['dynamic_get']))
		{
			$this->setData('dynamic_get', array_values($this->smartIDs['dynamic_get']), 'id');
		}
		// only if exporting
		if ('clone' !== $this->activeType)
		{
			// add class_property
			if (isset($this->smartIDs['class_property']) && JCBArrayHelper::check($this->smartIDs['class_property']))
			{
				$this->setData('class_property', array_values($this->smartIDs['class_property']), 'id');
			}
			// add class_method
			if (isset($this->smartIDs['class_method']) && JCBArrayHelper::check($this->smartIDs['class_method']))
			{
				$this->setData('class_method', array_values($this->smartIDs['class_method']), 'id');
			}
			// add joomla_plugin_group
			if (isset($this->smartIDs['joomla_plugin_group']) && JCBArrayHelper::check($this->smartIDs['joomla_plugin_group']))
			{
				$this->setData('joomla_plugin_group', array_values($this->smartIDs['joomla_plugin_group']), 'id');
			}
			// add class_extends
			if (isset($this->smartIDs['class_extends']) && JCBArrayHelper::check($this->smartIDs['class_extends']))
			{
				$this->setData('class_extends', array_values($this->smartIDs['class_extends']), 'id');
			}
			// add snippets
			if (isset($this->smartIDs['snippet']) && JCBArrayHelper::check($this->smartIDs['snippet']))
			{
				$this->setData('snippet', array_values($this->smartIDs['snippet']), 'id');
			}
			// add custom code
			if (isset($this->smartIDs['custom_code']) && JCBArrayHelper::check($this->smartIDs['custom_code']))
			{
				$this->setData('custom_code', array_values($this->smartIDs['custom_code']), 'id');
			}
			// add placeholder
			if (isset($this->smartIDs['placeholder']) && JCBArrayHelper::check($this->smartIDs['placeholder']))
			{
				$this->setData('placeholder', array_values($this->smartIDs['placeholder']), 'id');
			}
			// add powers
			if (isset($this->smartIDs['power']) && JCBArrayHelper::check($this->smartIDs['power']))
			{
				$this->setData('power', array_values($this->smartIDs['power']), 'guid');
			}
			// set limiter
			$limit = 0;
			// and add those custom codes found in custom codes
			while (isset($this->smartIDs['custom_code']) && JCBArrayHelper::check($this->smartIDs['custom_code']) && $limit < 100)
			{
				$this->setData('custom_code', array_values($this->smartIDs['custom_code']), 'id');
				// make sure we break
				$limit++; // just in case (should not be needed)
			}
		}
	}

	/**
	* Get Components
	*
	* @return array of objects.
	*/
	protected function getComponents($pks)
	{
		// setup the query
		if (JCBArrayHelper::check($pks))
		{
			// Get the user object.
			if (!ObjectHelper::check($this->user))
			{
				$this->user = Factory::getUser();
			}
			// Create a new query object.
			if (!ObjectHelper::check($this->_db))
			{
				$this->_db = Factory::getDBO();
			}
			$query = $this->_db->getQuery(true);

			// Select some fields
			$query->select(array('a.*'));
			
			// From the componentbuilder_joomla_component table
			$query->from($this->_db->quoteName('#__componentbuilder_joomla_component', 'a'));
			$query->where('a.id IN (' . implode(',',$pks) . ')');
			
			// Implement View Level Access
			if (!$this->user->authorise('core.options', 'com_componentbuilder'))
			{
				$groups = implode(',', $this->user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.ordering  ASC');

			// Load the items
			$this->_db->setQuery($query);
			$this->_db->execute();
			if ($this->_db->getNumRows())
			{
				// load the items from db
				$items = $this->_db->loadObjectList();
				// check if we have items
				if (JCBArrayHelper::check($items))
				{
					// set params
					if (!ObjectHelper::check($this->params))
					{
						$this->params = ComponentHelper::getParams('com_componentbuilder');
					}
					return $items;
				}
			}
		}
		return false;
	}

	/**
	* Remove all values that are no longer relevant.
	*
	* @return void.
	*/
	protected function removeOldComponentValues(&$item)
	{
		// make sure old fields are not used any more
		unset($item->addconfig);
		unset($item->addadmin_views);
		unset($item->addcustom_admin_views);
		unset($item->addsite_views);
		unset($item->version_update);
		unset($item->sql_tweak);
		unset($item->addcustommenus);
		unset($item->dashboard_tab);
		unset($item->php_dashboard_methods);
		unset($item->addfiles);
		unset($item->addfolders);
	}

	/**
	* Set export IDs.
	*
	* @return void.
	*/
	protected function setSmartIDs($value, $table, $int = true)
	{
		// check if table has been set
		if (!isset($this->smartIDs[$table]))
		{
			$this->smartIDs[$table] = array();
		}
		// convert if value is in json
		if (JsonHelper::check($value))
		{
			$value = json_decode($value, true);
		}
		// now update the fields
		if (JCBArrayHelper::check($value))
		{
			foreach ($value as $id)
			{
				if ($int && (StringHelper::check($id) || is_numeric($id)) && 0 !== (int) $id)
				{
					$this->smartIDs[$table][(int) $id] = (int) $id;
				}
				elseif (!$int && StringHelper::check($id))
				{
					$this->smartIDs[$table][$id] = $this->_db->quote($id);
				}
			}
		}
		elseif ($int && (StringHelper::check($value) || is_numeric($value)) && 0 !== (int) $value)
		{
			$this->smartIDs[$table][(int) $value] = (int) $value;
		}
		elseif (!$int && StringHelper::check($value))
		{
			$this->smartIDs[$table][$value] = $this->_db->quote($value);
		}
	}

	/**
	* Method to get values from repeatable or subform.
	*
	* @return mixed  An array of values on success, false on failure.
	*/
	protected function getValues($values, $type, $key = null, $prep = 'table')
	{
		// the ids bucket
		$bucket = array();
		// if json convert to array
		if (JsonHelper::check($values))
		{
			$values = json_decode($values, true);
		}
		// check that the array has values
		if (JCBArrayHelper::check($values))
		{
			// check if the key is an array (targeting subform)
			if ('subform' === $type && $key)
			{
				foreach ($values as $value)
				{
					if (isset($value[$key]))
					{
						if (is_numeric($value[$key]))
						{
							$bucket[] = $value[$key];
						}
						elseif (StringHelper::check($value[$key]))
						{
							if ('table' === $prep)
							{
								$bucket[] = $this->_db->quote($value[$key]);
							}
							else
							{
								$bucket[] = $value[$key];
							}
						}
					}
				}
				// only return if we set the ids
				if (JCBArrayHelper::check($bucket))
				{
					// now set the values back
					return array_unique($bucket);
				}
			}
			// check if the key is an array (targeting subform subform)
			if ('subform++' === $type && strpos($key, '.') !== false)
			{
				$_key = explode('.', $key);
				foreach ($values as $value)
				{
					if (isset($value[$_key[0]]) && JCBArrayHelper::check($value[$_key[0]]))
					{
						foreach ($value[$_key[0]] as $_value)
						{
							if (is_numeric($_value[$_key[1]]))
							{
								$bucket[] = $_value[$_key[1]];
							}
							elseif (StringHelper::check($_value[$_key[1]]))
							{
								if ('table' === $prep)
								{
									$bucket[] = $this->_db->quote($_value[$_key[1]]);
								}
								else
								{
									$bucket[] = $_value[$_key[1]];
								}
							}
						}
					}
				}
				// only return if we set the ids
				if (JCBArrayHelper::check($bucket))
				{
					// now set the values back
					return array_unique($bucket);
				}
			}
			// check if the key is an array (targeting repeatable)
			if ('repeatable' === $type && $key)
			{
				if (isset($values[$key]))
				{
					return array_map(function($value) use($prep){
						if (is_numeric($value))
						{
							return $value;
						}
						elseif (StringHelper::check($value))
						{
							if ('table' === $prep)
							{
								return  $this->_db->quote($value);
							}
							else
							{
								return $value;
							}
						}
					}, array_unique($values[$key]) );
				}
			}
			// get the powers
			if ('power' === $type)
			{
				if (isset($values[$key]))
				{
					foreach ($values[$key] as $k => $val)
					{
						if (strpos($k, 'power_') !== false && JCBArrayHelper::check($val))
						{
							foreach ($val as $v)
							{
								if (JCBArrayHelper::check($v) && isset($v['power']))
								{
									$bucket[$v['power']] = $v['power'];
								}
							}
						}
					}
					// only return if we set the ids
					if (JCBArrayHelper::check($bucket))
					{
						// now return the values back
						return array_values($bucket);
					}
				}
			}
		}
		return false;
	}

	/**
	* Method to get data of a given table.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	protected function setData($table, $values, $key, $string = false)
	{
		// lets check for json strings
		if (JsonHelper::check($values))
		{
			$values = json_decode($values, true);
		}
		// let's check for just a string or int
		elseif (is_string($values) || (is_numeric($values) && $values > 0))
		{
			$values = [$values];
		}

		// make sure we have an array of values
		if (!JCBArrayHelper::check($values, true) || !StringHelper::check($table) || !StringHelper::check($key))
		{
			return false;
		}

		// start the query
		$query = $this->_db->getQuery(true);
		// Select some fields
		$query->select(array('a.*'));

		// From the componentbuilder_ANY table
		$query->from($this->_db->quoteName('#__componentbuilder_'. $table, 'a'));

		// check if this is an array of integers 
		if ($this->is_numeric($values))
		{
			// set the where query
			$query->where('a.'.$key.' IN (' . implode(',', $values) . ')');
		}
		else
		{
			// set the where query
			$query->where('a.'.$key.' IN (' . implode(',', array_map( function ($var) {
				// check if already quoted
				if (preg_match('/^(["\']).*\1$/m', $var))
				{
					return $var;
				}
				return $this->_db->quote($var);
			}, $values)) . ')');
		}

		// Implement View Level Access
		if (!$this->user->authorise('core.options', 'com_componentbuilder'))
		{
			$groups = implode(',', $this->user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}

		// Order the results by ordering
		$query->order('a.ordering  ASC');
		// Load the items
		$this->_db->setQuery($query);
		$this->_db->execute();
		if ($this->_db->getNumRows())
		{
			// get the items
			$items = $this->_db->loadObjectList();
			// reset the search array (only search for template/layouts)
			$searchTLArray = array();
			// check if we have items
			if (JCBArrayHelper::check($items))
			{
				// set search array if site/custom admin view
				if ('site_view' === $table || 'custom_admin_view' === $table)
				{
					$searchTLArray = array(
						'default' => 'force_it',
						'php_view' => 'add_php_view',
						'php_jview' => 'add_php_jview',
						'php_jview_display' => 'add_php_jview_display',
						'php_document' => 'add_php_document',
						'javascript_file' => 'add_javascript_file',
						'js_document' => 'add_js_document',
						'css_document' => 'add_css_document',
						'css' => 'add_css'
					);
				}
				// set search array if admin view
				if ('admin_view' === $table)
				{
					$searchTLArray = array(
						'php_getitem' => 'add_php_getitem',
						'php_before_save' => 'add_php_before_save',
						'php_save' => 'add_php_save',
						'php_getform' => 'add_php_getform',
						'php_postsavehook' => 'add_php_postsavehook',
						'php_getitems' => 'add_php_getitems',
						'php_getitems_after_all' => 'add_php_getitems_after_all',
						'php_getlistquery' => 'add_php_getlistquery',
						'php_allowadd' => 'add_php_allowadd',
						'php_allowedit' => 'add_php_allowedit',
						'php_before_cancel' => 'add_php_before_cancel',
						'php_after_cancel' => 'add_php_after_cancel',
						'php_before_delete' => 'add_php_before_delete',
						'php_after_delete' => 'add_php_after_delete',
						'php_before_publish' => 'add_php_before_publish',
						'php_after_publish' => 'add_php_after_publish',
						'php_batchcopy' => 'add_php_batchcopy',
						'php_batchmove' => 'add_php_batchmove',
						'php_document' => 'add_php_document',
						'php_model' => 'add_custom_button',
						'php_controller' => 'add_custom_button',
						'php_model_list' => 'add_custom_button',
						'php_controller_list' => 'add_custom_button'
					);
				}
				// reset the global array
				if ('template' === $table)
				{
					$this->smartIDs['template'] = array();
				}
				elseif ('layout' === $table)
				{
					$this->smartIDs['layout'] = array();
				}
				elseif ('custom_code' === $table && 'id' === $key && !isset($this->smartIDs['custom_code']))
				{
					$this->smartIDs['custom_code'] = array();
				}
				elseif ('placeholder' === $table && 'id' === $key && !isset($this->smartIDs['placeholder']))
				{
					$this->smartIDs['placeholder'] = array();
				}
				// start loading the data
				if (!isset($this->smartBox[$table]))
				{
					$this->smartBox[$table] = array();
				}
				// start loading the found items
				foreach ($items as $nr => &$item)
				{
					// set the data per id only once
					if (!isset($item->id) || 0 === (int) $item->id || isset($this->smartBox[$table][$item->id]))
					{
						continue;
					}
					// actions to take before storing the item if table is template, layout, site_view, or custom_admin_view
					if ('layout' === $table || 'template' === $table || 'site_view' === $table || 'custom_admin_view' === $table)
					{
						// unset snippets (we no longer export snippets)
						if (isset($item->snippet))
						{
							unset($item->snippet);
						}
					}
					// actions to take before storing the item if table is joomla_component
					if ('joomla_component' === $table)
					{
						// make sure old fields are not exported any more
						$this->removeOldComponentValues($item);
						// set the powers linked to this joomla component
						$this->setSmartIDs($this->getValues($item->params, 'power', 'joomla_component_headers', null), 'power', false);
					}
					// actions to take before storing the item if table is admin_view
					if ('admin_view' === $table)
					{
						// make sure old fields are not exported any more
						unset($item->addfields);
						unset($item->addconditions);
					}
					// load to global object
					$this->smartBox[$table][$item->id] = $item;
					// set the custom code ID's
					$this->setCodePlaceholdersIds($item, $table);
					// set the placeholder ID's
					$this->setCodePlaceholdersIds($item, $table, 'placeholder');
					// actions to take if table is component_files_folders
					if (('component_files_folders' === $table || 'joomla_plugin_files_folders_urls' === $table || 'joomla_module_files_folders_urls' === $table) && 'clone' !== $this->activeType)
					{
						// build files
						$this->moveIt($this->getValues($item->addfiles, 'subform', 'file', null), 'file');
						// build folders
						$this->moveIt($this->getValues($item->addfolders, 'subform', 'folder', null), 'folder');
						// build full path files
						$this->moveIt($this->getValues($item->addfilesfullpath, 'subform', 'filepath', null), 'file', true);
						// build full path folders
						$this->moveIt($this->getValues($item->addfoldersfullpath, 'subform', 'folderpath', null), 'folder', true);
					}
					// actions to take if table is component_dashboard
					if ('component_dashboard' === $table)
					{
						// set the powers linked to this dashboard
						$this->setSmartIDs($this->getValues($item->params, 'power', 'component_dashboard_headers', null), 'power', false);
					}
					// actions to take if table is component_config
					if ('component_config' === $table)
					{
						// add config fields
						$this->setData('field', $this->getValues($item->addconfig, 'subform', 'field'), 'id');
					}
					// actions to take if table is component_admin_views
					if ('component_admin_views' === $table)
					{
						// add admin views
						$this->setData('admin_view', $this->getValues($item->addadmin_views, 'subform', 'adminview'), 'id');
					}
					// actions to take if table is component_site_views
					if ('component_site_views' === $table)
					{
						// add site views
						$this->setData('site_view', $this->getValues($item->addsite_views, 'subform', 'siteview'), 'id');
					}
					// actions to take if table is component_custom_admin_views
					if ('component_custom_admin_views' === $table)
					{
						// add custom admin views
						$this->setData('custom_admin_view', $this->getValues($item->addcustom_admin_views, 'subform', 'customadminview'), 'id');
					}
					// actions to take if table is component_modules
					if ('component_modules' === $table)
					{
						// we remove those modules not part of the export
						if (isset($item->addjoomla_modules) && JsonHelper::check($item->addjoomla_modules))
						{
							$item->addjoomla_modules = array_filter(
								json_decode($item->addjoomla_modules, true),
								function ($module) {
									// target 2 is only export and target 0 is both (1 is only compile)
									if (isset($module['target']) && ($module['target'] == 2 || $module['target'] == 0))
									{
										return true;
									}
									return false;
								}
							);
						}
						// add custom admin views
						$this->setData('joomla_module', $this->getValues($item->addjoomla_modules, 'subform', 'module'), 'id');
					}
					// actions to take if table is component_plugins
					if ('component_plugins' === $table)
					{
						// we remove those plugins not part of the export
						if (isset($item->addjoomla_plugins) && JsonHelper::check($item->addjoomla_plugins))
						{
							$item->addjoomla_plugins = array_filter(
								json_decode($item->addjoomla_plugins, true),
								function ($plugin) {
									// target 2 is only export and target 0 is both (1 is only compile)
									if (isset($plugin['target']) && ($plugin['target'] == 2 || $plugin['target'] == 0))
									{
										return true;
									}
									return false;
								}
							);
						}
						// add custom admin views
						$this->setData('joomla_plugin', $this->getValues($item->addjoomla_plugins, 'subform', 'plugin'), 'id');
					}
					// actions to take if table is admin_view
					if ('admin_view' === $table)
					{
						// add fields & conditions
						$this->setSmartIDs($item->id, 'admin_view');
						// set the powers linked to this admin view
						$this->setSmartIDs($this->getValues($item->params, 'power', 'admin_view_headers', null), 'power', false);
						// do not move anything if clone
						if ('clone' !== $this->activeType)
						{
							// admin icon
							$this->moveIt(array($item->icon), 'image');
							// admin icon_add
							$this->moveIt(array($item->icon_add), 'image');
							// admin icon_category
							$this->moveIt(array($item->icon_category), 'image');
						}
					}
					// actions to take if table is admin_fields
					if ('admin_fields' === $table)
					{
						// add fields
						$this->setData('field', $this->getValues($item->addfields, 'subform', 'field'), 'id');
					}
					// actions to take if table is admin_fields_conditions
					if ('admin_fields_conditions' === $table)
					{
						// add fields (all should already be added)
						$this->setData('field', $this->getValues($item->addconditions, 'subform', 'target_field'), 'id');
						$this->setData('field', $this->getValues($item->addconditions, 'subform', 'match_field'), 'id');
					}
					// actions to take if table is admin_fields_relations
					if ('admin_fields_relations' === $table)
					{
						// add fields (all should already be added)
						$this->setData('field', $this->getValues($item->addrelations, 'subform', 'listfield'), 'id');
						$this->setData('field', $this->getValues($item->addrelations, 'subform', 'joinfields'), 'id');
					}
					// actions to take if table is field
					if ('field' === $table)
					{
						// add field types
						$this->setSmartIDs($item->fieldtype, 'fieldtype');
						// check if this field has multiple fields
						if ($this->checkMultiFields($item->fieldtype))
						{
							$fields = GetHelper::between(json_decode($item->xml), 'fields="', '"');
							$fieldsSets = array();
							if (strpos($fields, ',') !== false)
							{
								// multiple fields
								$fieldsSets = (array) explode(',', $fields);
							}
							elseif (is_numeric($fields))
							{
								// single field
								$fieldsSets[] = (int) $fields;
							}
							// get fields
							if (JCBArrayHelper::check($fieldsSets))
							{
								$this->setData('field', $fieldsSets, 'id');
							}
						}
						// check if validation rule is found
						$validationRule = GetHelper::between(json_decode($item->xml), 'validate="', '"');
						if (StringHelper::check($validationRule))
						{
							// make sure it is lowercase
							$validationRule = StringHelper::safe($validationRule);
							// get core validation rules
							if ($coreValidationRules = ComponentbuilderHelper::getExistingValidationRuleNames(true))
							{
								// make sure this rule is not a core validation rule
								if (!in_array($validationRule, (array) $coreValidationRules))
								{
									// okay load the rule
									$this->setSmartIDs($validationRule, 'validation_rule', false);
								}
							}
						}
					}
					// check if a search is required
					if (isset($searchTLArray) && JCBArrayHelper::check($searchTLArray)){

						// add search array templates and layouts
						foreach ($searchTLArray as $scripter => $add)
						{
							if ($add === 'force_it' || (isset($item->{$add}) && $item->{$add} == 1))
							{
								$this->getTemplateLayout($item->{$scripter});
							}
						}
					}
					// actions to take if table is site_view and custom_admin_view
					if ('site_view' === $table || 'custom_admin_view' === $table)
					{
						// add dynamic gets
						$this->setSmartIDs($item->main_get, 'dynamic_get');
						$this->setSmartIDs($item->custom_get, 'dynamic_get');
						$this->setSmartIDs($item->dynamic_get, 'dynamic_get');
						// move the icon
						if ('custom_admin_view' === $table && isset($item->icon) && 'clone' !== $this->activeType)
						{
							// view icon
							$this->moveIt(array($item->icon), 'image');
						}
						// add snippets (was removed please use snippet importer)
						if (isset($item->snippet) && is_numeric($item->snippet))
						{
							$this->setSmartIDs((int) $item->snippet, 'snippet');
						}
						// actions to take if table is site_view
						if ('site_view' === $table)
						{
							// set the powers linked to this admin view
							$this->setSmartIDs($this->getValues($item->params, 'power', 'site_view_headers', null), 'power', false);
						}
						// actions to take if table is custom_admin_view
						elseif ('custom_admin_view' === $table)
						{
							// set the powers linked to this admin view
							$this->setSmartIDs($this->getValues($item->params, 'power', 'custom_admin_view_headers', null), 'power', false);
						}
					}
					// actions to take if table is template and layout
					if ('layout' === $table || 'template' === $table)
					{
						// add snippets (was removed please use snippet importer)
						if (isset($item->snippet) && is_numeric($item->snippet))
						{
							$this->setSmartIDs((int) $item->snippet, 'snippet');
						}
						// search for templates & layouts
						$this->getTemplateLayout($item->$table, $this->user);
						// add search array templates and layouts
						if (isset($item->add_php_view) && $item->add_php_view == 1)
						{
							$this->getTemplateLayout($item->php_view, $this->user);
						}
						// add dynamic gets
						$this->setSmartIDs((int) $item->dynamic_get, 'dynamic_get');
					}
					// actions to take if table is joomla_module
					if ('joomla_module' === $table)
					{
						// add the updates and folder stuff
						$this->setSmartIDs($item->id, 'joomla_module');
						// add class_extends
						$this->setSmartIDs((int) $item->class_extends, 'class_extends');
						// add fields
						$this->setData('field', $this->getValues($item->fields, 'subform++', 'fields.field'), 'id');
						// add dynamic gets
						$this->setSmartIDs($item->custom_get, 'dynamic_get');
						// set module language strings
						$this->setLanguageTranslation($item->id, 'modules');
					}
					// actions to take if table is joomla_plugin
					if ('joomla_plugin' === $table)
					{
						// add the updates and folder stuff
						$this->setSmartIDs($item->id, 'joomla_plugin');
						// add class_extends
						$this->setSmartIDs((int) $item->class_extends, 'class_extends');
						// add joomla_plugin_group
						$this->setSmartIDs((int) $item->joomla_plugin_group, 'joomla_plugin_group');
						// add fields
						$this->setData('field', $this->getValues($item->fields, 'subform++', 'fields.field'), 'id');
						// add property_selection
						$this->setData('class_property', $this->getValues($item->property_selection, 'subform', 'property'), 'id');
						// add class_method
						$this->setData('class_method', $this->getValues($item->method_selection, 'subform', 'method'), 'id');
						// set plugin language strings
						$this->setLanguageTranslation($item->id, 'plugins');
					}
					// actions to take if table is joomla_plugin_group
					if ('joomla_plugin_group' === $table)
					{
						// add class_extends
						$this->setSmartIDs((int) $item->class_extends, 'class_extends');
					}
					// actions to take if table is class_method or 
					if ('class_method' === $table || 'class_property' === $table )
					{
						// add joomla_plugin_group
						$this->setSmartIDs((int) $item->joomla_plugin_group, 'joomla_plugin_group');
					}
					// actions to take if table is dynamic_get
					if ('dynamic_get' === $table)
					{
						// add dynamic_get_headers
						$this->setSmartIDs($this->getValues($item->params, 'power', 'dynamic_get_headers', null), 'power', false);
					}
					// actions to take if table is power
					if ('power' === $table)
					{
						// add the extended class (powers)
						$this->setData('power', $item->extends, 'guid');
						// add implements interfaces (powers)
						$this->setData('power', $item->implements, 'guid');
						// add use classes (powers)
						$this->setData('power', $this->getValues($item->use_selection, 'subform', 'use'), 'guid');
						// add load classes (powers)
						$this->setData('power', $this->getValues($item->load_selection, 'subform', 'load'), 'guid');
						// add property_selection
						$this->setData('class_property', $this->getValues($item->property_selection, 'subform', 'property'), 'id');
						// add class_method
						$this->setData('class_method', $this->getValues($item->method_selection, 'subform', 'method'), 'id');
					}
				}
			}
		}
	}

	/**
	 * Method to check if array has only numiric values
	 *
	 * @return bool
	 **/
	protected function is_numeric($array)
	{
		foreach ($array as $value)
		{
			if (!is_numeric($value))
			{
				return false;
			}
		}
		return true;
	}

	/**
	* Method to do the smart cloning
	*
	* @return bool
	*/
	protected function smartCloner()
	{
		// check if data is set
		if (isset($this->smartBox) && JCBArrayHelper::check($this->smartBox))
		{
			// get the import_joomla_components
			$model = ComponentbuilderHelper::getModel('import_joomla_components');
			// do not show more information
			$model->moreInfo = 0;
			// trigger the create new (clone) feature
			$model->canmerge = 0;
			// set some postfix
			$model->postfix = ' ('.StringHelper::random(2).')';
			// get App
			$model->app = Factory::getApplication();
			// set user
			$model->user = $this->user;
			// set today's date
			$model->today = Factory::getDate()->toSql();
			// load the data
			$model->data = $this->smartBox;
			// remove smart box to safe on memory
			unset($this->smartBox);
			// the array of tables to store
			$tables = array(
				'fieldtype', 'field', 'admin_view', 'snippet', 'dynamic_get', 'custom_admin_view', 'site_view',
				'template', 'layout', 'joomla_component', 'language', 'language_translation', 'custom_code', 'placeholder',
				'joomla_module', 'joomla_module_files_folders_urls', 'joomla_module_updates',
				'joomla_plugin', 'joomla_plugin_files_folders_urls', 'joomla_plugin_updates', 'power',
				'admin_fields', 'admin_fields_conditions', 'admin_fields_relations',  'admin_custom_tabs', 'component_admin_views',
				'component_site_views', 'component_custom_admin_views', 'component_updates', 'component_mysql_tweaks',
				'component_custom_admin_menus', 'component_config', 'component_dashboard', 'component_files_folders',
				'component_placeholders', 'component_modules', 'component_plugins'
			);
			// smart table loop
			foreach ($tables as $table)
			{
				// save the table to database
				if (!$model->saveSmartItems($table))
				{
					return false;
				}
			}
			// do an after all run on all items that need it
			$model->updateAfterAll();
			// finally move the old datasets
			$model->moveDivergedData();
			// we had success
			return true;
		}
		return false;
	}

	/**
	* Method to build the package to export
	*
	* @return bool
	*/
	protected function smartExportBuilder()
	{
		// check if data is set
		if (isset($this->smartBox) && JCBArrayHelper::check($this->smartBox))
		{
			// set db data
			$data = serialize($this->smartBox);

			// Set the key owner information
			$this->info['source'] = array();
			$this->info['source']['company'] = $this->params->get('export_company', null);
			$this->info['source']['owner'] = $this->params->get('export_owner', null);
			$this->info['source']['email'] = $this->params->get('export_email', null);
			$this->info['source']['website'] = $this->params->get('export_website', null);
			$this->info['source']['license'] = $this->params->get('export_license', null);
			$this->info['source']['copyright'] = $this->params->get('export_copyright', null);

			// lock the data if set
			if (JCBArrayHelper::check($this->key))
			{
				// lock the data
				$this->key = md5(implode('', $this->key));

				// lock the data
				$data = PackageFactory::_('Crypt')->encrypt($data, 'aes', $this->key);

				// Set the key owner information
				$this->info['getKeyFrom'] = array();
				$this->info['getKeyFrom']['company'] = $this->info['source']['company'];
				$this->info['getKeyFrom']['owner'] = $this->info['source']['owner'];
				$this->info['getKeyFrom']['email'] = $this->info['source']['email'];
				$this->info['getKeyFrom']['website'] = $this->info['source']['website'];
				$this->info['getKeyFrom']['license'] = $this->info['source']['license'];
				$this->info['getKeyFrom']['copyright'] = $this->info['source']['copyright'];
				// add buy link if only one link is set
				if (isset($this->info['export_buy_link'])
					&& JCBArrayHelper::check($this->info['export_buy_link'])
					&& count((array) $this->info['export_buy_link']) == 1)
				{
					$this->info['getKeyFrom']['buy_link'] = array_values($this->info['export_buy_link'])[0];
				}
				else
				{
					// use global if more then one component is exported
					// (since they now have one key), or if none has a buy link
					$this->info['getKeyFrom']['buy_link'] = $this->params->get('export_buy_link', null);
				}
				// no remove the buy links
				unset($this->info['export_buy_link']);
				// if we have multi links add them also
				// we started adding this at v2.7.7
				$this->info['key'] = true;
				// Changed: 25th Feb. 2023 at v3.1.18
				// $this->info['phpseclib'] = false;
				// we started adding this at v3.1.18
				$this->info['phpseclib3'] = true;
			}
			else
			{
				// we started adding this at v2.7.7
				$this->info['key'] = false;
				// we started adding this at v3.0.11 and v2.12.17
				// $this->info['phpseclib'] = false;
				// we started adding this at v3.1.18
				$this->info['phpseclib3'] = false;
				// base 64 encode the data
				$data = base64_encode($data);
			}

			// set the path
			$dbPath = $this->packagePath . '/db.vdm';

			// write the db data to file in package
			if (!FileHelper::write($dbPath, wordwrap($data, 128, "\n", true)))
			{
				return false;
			}

			// lock the info data
			$info = PackageFactory::_('Crypt')->encrypt(json_encode($this->info), 'local');

			// set the path
			$infoPath = $this->packagePath . '/info.vdm';

			// write the info data to file in package
			if (!FileHelper::write($infoPath, wordwrap($info, 128, "\n", true)))
			{
					return false;
			}

			// lock all files
			$this->lockFiles();

			// remove old zip files with the same name
			if (JFile::exists($this->zipPath))
			{
				// remove file if found
				JFile::delete($this->zipPath);
			}

			// zip the folder
			if (!FileHelper::zip($this->packagePath, $this->zipPath))
			{
				return false;
			}

			// move to remote server if needed
			if (2 == $this->backupType)
			{
				if (!PackageFactory::_('Server')->legacyMove(
					$this->zipPath, $this->packageName.'.zip',
					$this->backupServer, null, 'joomla_component.export'
					)
				)
				{
					return false;
				}

				// remove the local file
				JFile::delete($this->zipPath);
			}

			// remove the folder
			if (!ComponentbuilderHelper::removeFolder($this->packagePath))
			{
				return false;
			}

			return true;
		}
		return false;
	}

	/**
	* Method to lock all files
	*
	* @return void
	*/
	protected function lockFiles()
	{
		// lock the data if set
		if (StringHelper::check($this->key) && strlen($this->key) == 32)
		{
			// we must first store the current working directory
			$joomla = getcwd();

			// to avoid that it encrypt the db and info file again we must move per/folder
			$folders = array('images', 'custom', 'dynamic');

			// loop the folders
			foreach ($folders as $folder)
			{
				// the sub path
				$subPath = $this->packagePath.'/'.$folder;

				// go to the package sub folder if found
				if (FileHelper::exists($subPath))
				{
					$this->lock($subPath);
				}
			}

			// change back to working dir
			chdir($joomla);
		}
	}

	/**
	* The Locker
	*
	* @return void
	*/	
	protected function lock(&$tmpPath)
	{
		// we are changing the working directory to the tmp path (important)
		chdir($tmpPath);

		// get a list of files in the current directory tree (all)
		$files = JFolder::files('.', '.', true, true);

		// read in the file content
		foreach ($files as $file)
		{
			// get file content
			$content = FileHelper::getContent($file);

			// write the encrypted string back to file
			$content = PackageFactory::_('Crypt')->encrypt($content, 'eac', $this->key);

			// store the encrypted file content in the same file
			FileHelper::write($file, wordwrap($content, 128, "\n", true));
		}
	}

	/**
	* Method to move the files and folder to the package folder
	*
	* @return bool
	*/
	protected function moveIt($paths, $type, $dynamic = false)
	{
		// make sure we have an array
		if (!JCBArrayHelper::check($paths))
		{
			return false;
		}

		// set the name of the folder
		if ('file' === $type || 'folder' === $type)
		{
			$folderName = 'custom';
			// if these are full paths use dynamic folder
			if ($dynamic)
			{
				$folderName = 'dynamic';
			}
		}
		elseif ('image' === $type)
		{
			$folderName = 'images';
		}
		else
		{
			return false;
		}

		// setup the type path
		$tmpPath = str_replace('//', '/', $this->packagePath . '/' . $folderName);

		// create type path if not set
		if (!FileHelper::exists($tmpPath))
		{
			// create the folders if not found
			JFolder::create($tmpPath);
		}

		// now move it
		foreach ($paths as $item)
		{
			// make sure we have a string
			if (StringHelper::check($item))
			{
				// if the file type
				if ('file' === $type)
				{
					// if dynamic paths
					if ($dynamic)
					{
						$tmpFilePath = $tmpPath.'/'.$this->setDynamicPathName($item);
						$customFilePath = str_replace('//', '/', $this->setFullPath($item));
					}
					else
					{
						$tmpFilePath = str_replace('//', '/', $tmpPath.'/'.$item);
						$customFilePath = str_replace('//', '/', $this->customPath.'/'.$item);
					}
					// now check if file exist
					if (!JFile::exists($tmpFilePath) && JFile::exists($customFilePath))
					{
						// move the file to its place
						JFile::copy($customFilePath, $tmpFilePath);
					}
				}

				// if the image type
				if ('image' === $type)
				{
					$imageName = basename($item);
					$imagePath = str_replace($imageName, '', $item);
					$imageFolderPath = str_replace('//', '/', $this->packagePath.'/'. $imagePath);

					// check if image folder exist
					if (!FileHelper::exists($imageFolderPath))
					{
						// create the folders if not found
						JFolder::create($imageFolderPath);
					}
					$tmpImagePath = str_replace('//', '/', $this->packagePath.'/'.$item);
					$customImagePath = str_replace('//', '/', JPATH_ROOT.'/'.$item);
					if (!JFile::exists($tmpImagePath) && JFile::exists($customImagePath))
					{
						// move the file to its place
						JFile::copy($customImagePath, $tmpImagePath);
					}
				}

				// if the folder type
				if ('folder' === $type)
				{
					// if dynamic paths
					if ($dynamic)
					{
						$tmpFolderPath = $tmpPath.'/'.$this->setDynamicPathName($item);
						$customFolderPath = str_replace('//', '/', $this->setFullPath($item));
					}
					else
					{
						$tmpFolderPath = str_replace('//', '/', $tmpPath.'/'.$item);
						$customFolderPath = str_replace('//', '/', $this->customPath.'/'.$item);
					}

					if (!FileHelper::exists($tmpFolderPath) && FileHelper::exists($customFolderPath))
					{
						// move the folder to its place
						JFolder::copy($customFolderPath, $tmpFolderPath,'',true);
					}
				}
			}
		}
		return true;
	}

	/**
	 * Check if a field has multiple fields
	 * 
	 * @param   string   $typeID  The type ID
	 *
	 * @return  bool true on success
	 * 
	 */
	protected function checkMultiFields($typeID)
	{
		if(isset($this->isMultiple[$typeID]))
		{
			return $this->isMultiple[$typeID];
		}
		elseif ($type = $this->getFieldType($typeID))
		{
			if ('repeatable' === $type || 'subform' === $type )
			{
				$this->isMultiple[$typeID] = true;
			}
			else
			{
				$this->isMultiple[$typeID] = false;
			}
			return $this->isMultiple[$typeID];
		}
		return false;
	}

	/**
	 * Get the field type
	 * 
	 * @param   string   $id  The field type id
	 *
	 * @return  string field type
	 * 
	 */
	protected function getFieldType($id)
	{
		if (!isset($this->fieldTypes[$id]))
		{
			$properties = GetHelper::var('fieldtype', $id, 'id', 'properties');
			if (JsonHelper::check($properties))
			{
				$properties = json_decode($properties, true);
				foreach ($properties as $property)
				{
					if ('type' === $property['name'])
					{
						if (isset($property['example'])  && StringHelper::check($property['example']))
						{
							$this->fieldTypes[$id] = $property['example'];
							break;
						}
					}
				}
			}
			// if not found
			if (!isset($this->fieldTypes[$id]) && $name = GetHelper::var('fieldtype', $id, 'id', 'name'))
			{
				$this->fieldTypes[$id] = StringHelper::safe($name);
			}
		}
		// return the type
		if (isset($this->fieldTypes[$id]))
		{
			return $this->fieldTypes[$id];
		}
		return false;
	}

	/**
	 * Set Template and Layout Data
	 * 
	 * @param   string   $default  The content to check
	 *
	 * @return  void
	 * 
	 */
	protected function getTemplateLayout($default, $user = false)
	{
		// check if we have base64 encoding
		if (base64_encode(base64_decode($default, true)) === $default)
		{
			$default = base64_decode($default);
		}
		// set the Template data
		$temp1 = GetHelper::allBetween($default, "\$this->loadTemplate('","')");
		$temp2 = GetHelper::allBetween($default, '$this->loadTemplate("','")');
		$templates = array();
		$again = array();
		if (JCBArrayHelper::check($temp1) && JCBArrayHelper::check($temp2))
		{
			$templates = array_merge($temp1,$temp2);
		}
		else
		{
			if (JCBArrayHelper::check($temp1))
			{
				$templates = $temp1;
			}
			elseif (JCBArrayHelper::check($temp2))
			{
				$templates = $temp2;
			}
		}
		if (JCBArrayHelper::check($templates))
		{
			foreach ($templates as $template)
			{
				$data = $this->getDataWithAlias($template, 'template');
				if (JCBArrayHelper::check($data))
				{
					if (!isset($this->smartIDs['template']) || !isset($this->smartIDs['template'][$data['id']]))
					{
						$this->setSmartIDs($data['id'], 'template');
						// call self to get child data
						$again[] = $data['html'];
						$again[] = $data['php_view'];
					}
				}
			}
		}
		// set  the layout data
		$lay1 = GetHelper::allBetween($default, "LayoutHelper::render('","',");
		$lay2 = GetHelper::allBetween($default, 'LayoutHelper::render("','",');
		if (JCBArrayHelper::check($lay1) && JCBArrayHelper::check($lay2))
		{
			$layouts = array_merge($lay1,$lay2);
		}
		else
		{
			if (JCBArrayHelper::check($lay1))
			{
				$layouts = $lay1;
			}
			elseif (JCBArrayHelper::check($lay2))
			{
				$layouts = $lay2;
			}
		}
		if (isset($layouts) && JCBArrayHelper::check($layouts))
		{
			foreach ($layouts as $layout)
			{
				$data = $this->getDataWithAlias($layout, 'layout');
				if (JCBArrayHelper::check($data))
				{
					if (!isset($this->smartIDs['layout']) || !isset($this->smartIDs['layout'][$data['id']]))
					{
						$this->setSmartIDs($data['id'], 'layout');
						// call self to get child data
						$again[] = $data['html'];
						$again[] = $data['php_view'];
					}
				}
			}
		}
		if (JCBArrayHelper::check($again))
		{
			foreach ($again as $get)
			{
				$this->getTemplateLayout($get);
			}
		}
		// Set the Data 
		if ($user)
		{
			// add templates
			if (isset($this->smartIDs['template']) && JCBArrayHelper::check($this->smartIDs['template']))
			{
				$this->setData('template', array_values($this->smartIDs['template']), 'id');
			}
			// add layouts
			if (isset($this->smartIDs['layout']) && JCBArrayHelper::check($this->smartIDs['layout']))
			{
				$this->setData('layout', array_values($this->smartIDs['layout']), 'id');
			}
		}
	}
	
	/**
	 * Get Data With Alias
	 * 
	 * @param   string   $n_ame  The alias name
	 * @param   string   $table  The table where to find the alias
	 * @param   string   $view  The view code name
	 *
	 * @return  array The data found with the alias
	 * 
	 */
	protected function getDataWithAlias($n_ame, $table)
	{
		// Create a new query object.
		$query = $this->_db->getQuery(true);
		$query->select($this->_db->quoteName(array('a.id', 'a.alias', 'a.'.$table, 'a.php_view', 'a.add_php_view')));
		$query->from('#__componentbuilder_'.$table.' AS a');
		$this->_db->setQuery($query);
		$rows = $this->_db->loadObjectList();
		foreach ($rows as $row)
		{
			$k_ey = StringHelper::safe($row->alias);
			$key = preg_replace("/[^A-Za-z]/", '', $k_ey);
			$name = preg_replace("/[^A-Za-z]/", '', $n_ame);
			if ($k_ey == $n_ame || $key == $name)
			{
				$php_view = '';
				if ($row->add_php_view == 1)
				{
					$php_view = base64_decode($row->php_view);
				}
				$contnent = base64_decode($row->{$table});
				// return to continue the search
				return array('id' => $row->id, 'html' => $contnent, 'php_view' => $php_view);
			}
		}
		return false;
	}

	/**
	* Set the ids of the found code placeholders
	*
	*  @param   object    $item   The item being searched
	*  @param   string    $target  The target table
	*  @param   string    $type    The type of placeholder to search and set
	* 
	*  @return  void
	* 
	*/
	protected function setCodePlaceholdersIds($item, $target, $type = 'custom_code')
	{
		if ($keys = $this->getCodeSearchKeys($target))
		{
			foreach ($keys['search'] as $key)
			{
				if ('id' === $key || 'name' === $key || 'system_name' === $key)
				{
					continue;
				}
				elseif (!isset($keys['not_base64'][$key]))
				{
					$value = Base64Helper::open($item->{$key}, null);
				}
				elseif (isset($keys['not_base64'][$key]) && 'json' === $keys['not_base64'][$key] && 'xml' === $key) // just for field search
				{
					$value = json_decode($item->{$key});
				}
				else
				{
					$value = $item->{$key};
				}
				// check if we should search for base64 string inside the text
				if (isset($keys['base64_search']) && isset($keys['base64_search'][$key])
					&& isset($keys['base64_search'][$key]['start']) && strpos($value, $keys['base64_search'][$key]['start']) !== false)
				{
					// search and open the base64 strings
					$this->searchOpenBase64($value, $keys['base64_search'][$key]);
				}
				// based on the type of search
				if ('custom_code' === $type)
				{
					// search the value to see if it has custom code
					$codeArray = GetHelper::allBetween($value, '[CUSTOMC' . 'ODE=',']');
					if (JCBArrayHelper::check($codeArray))
					{
						foreach ($codeArray as $func)
						{
							// first make sure we have only the function key
							if (strpos($func, '+') !== false)
							{
								$funcArray = explode('+', $func);
								$func = $funcArray[0];
							}
							if (!isset($this->customCodeM[$func]))
							{
								$this->customCodeM[$func] = $func;
								// if numeric add to ids
								if (is_numeric($func))
								{
									$this->setSmartIDs($func, $type);
								}
								elseif (StringHelper::check($func))
								{
									if (($funcID = GetHelper::var($type, $func, 'function_name', 'id')) !== false && is_numeric($funcID))
									{
										$this->setSmartIDs($funcID, $type);
									}
									else
									{
										// set a notice that custom code was not found (weird)
									}
								}
							}
						}
					}
				}
				elseif ('placeholder' === $type)
				{
					// check if we already have the placeholder search array
					if (!JCBArrayHelper::check($this->placeholderM) && !JCBArrayHelper::check($this->placeholderS))
					{
						$this->placeholderS = ComponentbuilderHelper::getVars($type, 1, 'published', 'target');
					}
					// only continue search if placeholders found
					if (JCBArrayHelper::check($this->placeholderS))
					{
						foreach ($this->placeholderS as $remove => $placeholder)
						{
							// search the value to see if it has this placeholder and is not already set
							if (!isset($this->placeholderM[$placeholder]) && strpos($value, $placeholder) !== false)
							{
								// add only once
								$this->placeholderM[$placeholder] = $placeholder;
								unset($this->placeholderS[$remove]);
								// get the ID
								if (($placeholderID = GetHelper::var($type, $placeholder, 'target', 'id')) !== false && is_numeric($placeholderID))
								{
									$this->setSmartIDs($placeholderID, $type);
								}
								else
								{
									// set a notice that placeholder was not found (weird)
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	* Set the language strings for this component
	*
	*  @param   int    $id   The component id
	* 
	*  @return  void
	* 
	*/
	protected function setLanguageTranslation(&$id, $target = 'components')
	{
		// check if the export of language strings is allowed
		if ($this->params->get('export_language_strings', 1) != 1)
		{
			return;
		}
		// Create a new query object.
		$query = $this->_db->getQuery(true);
		$query->select(array('a.*'));
		$query->from('#__componentbuilder_language_translation AS a');
		// Implement View Level Access
		if (!$this->user->authorise('core.options', 'com_componentbuilder'))
		{
			$groups = implode(',', $this->user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}

		// Order the results by ordering
		$query->order('a.ordering  ASC');

		// Load the items
		$this->_db->setQuery($query);
		$this->_db->execute();
		if ($this->_db->getNumRows())
		{
			$items = $this->_db->loadObjectList();
			// check if we have items
			if (JCBArrayHelper::check($items))
			{
				if (!isset($this->smartBox['language_translation']))
				{
					$this->smartBox['language_translation'] = array();
				}
				foreach ($items as $item)
				{
					if (!isset($this->smartBox['language_translation'][$item->id]) && JsonHelper::check($item->{$target}))
					{
						$targets = json_decode($item->{$target}, true);
						if (in_array($id, $targets))
						{
							// load to global object
							$this->smartBox['language_translation'][$item->id] = $item;
							// add languages
							if (isset($item->translation))
							{
								$this->setData('language', $this->getValues($item->translation, 'subform', 'language'), 'langtag');
							}
						}
					}
				}
			}
		}
	}

	/**
	* Get the package name
	*
	*  @param   array    $items of all components
	* 
	*  @return  string     The package name
	* 
	*/
	protected function getPackageName(&$items)
	{
		foreach ($items as $item)
		{
			if (isset($item->system_name))
			{
				return StringHelper::safe($item->system_name, 'cAmel');
			}
			else
			{
				return StringHelper::safe($item->name_code);
			}
		}
	}

	/**
	 * Convert the path to a name
	 * 
	 * @param   string   $path  The full path
	 *
	 * @return  string   The path name
	 * 
	 */
	protected function setDynamicPathName($path)
	{
		// remove the full path if possible
		$path = str_replace('//', '/', $this->setConstantPath($path));
		// now convert to string
		return str_replace('/', '__v_d_m__', $path);
	}

	/**
	 * Update real full path value with constant path string
	 * 
	 * @param   string   $path  The full path
	 *
	 * @return  string   The updated path
	 * 
	 */
	protected function setConstantPath($path)
	{
		return str_replace(array_values(ComponentbuilderHelper::$constantPaths), array_keys(ComponentbuilderHelper::$constantPaths), $path);
	}

	/**
	 * Update constant path with real full path value
	 * 
	 * @param   string   $path  The full path
	 *
	 * @return  string   The updated path
	 * 
	 */
	protected function setFullPath($path)
	{
		return str_replace(array_keys(ComponentbuilderHelper::$constantPaths), array_values(ComponentbuilderHelper::$constantPaths), $path);
	}

	/**
	* Search for base64 strings and decode them
	*
	*  @param   string    $value  The string to search
	*  @param   array    $target   The target search values
	* 
	*  @return  void
	* 
	*/
	protected function searchOpenBase64(&$value, &$target)
	{
		// first get the start property (if dynamic)
		$starts =  array();
		if (isset($target['_start']))
		{
			// get all values
			$allBetween = GetHelper::allBetween($value, $target['start'], $target['_start']);
			// just again make sure we found some
			if (UtilitiesArrayHelper::check($allBetween))
			{
				if (count((array) $allBetween) > 1)
				{
					// search for many
					foreach ($allBetween as $between)
					{
						// load the starting property
						$start = $target['start'];
						$start .= $between;
						$start .= $target['_start'];

						$starts[] = $start;
					}
				}
				else
				{
					// load the starting property
					$start = $target['start'];
					$start .= array_values($allBetween)[0];
					$start .= $target['_start'];

					$starts[] = $start;
				}
			}
		}
		else
		{
			$starts[] = $target['start'];
		}
		// has any been found
		if (UtilitiesArrayHelper::check($starts))
		{
			foreach ($starts as $_start)
			{
				// get the base64 string
				$base64 = GetHelper::between($value, $_start, $target['end']);
				// now open the base64 text
				$tmp = Base64Helper::open($base64);
				// insert it back into the value (so we still search the whole string)
				$value = str_replace($base64, $tmp, $value);
			}
		}
	}


	/**
	 * The code search keys/targets
	 * 
	 * @var      array
	 */
	protected $codeSearchKeys = array(
		// #__componentbuilder_joomla_component (a)
		'joomla_component' => array(
			'search' => array('id', 'system_name', 'php_preflight_install', 'php_postflight_install',
				'php_preflight_update', 'php_postflight_update', 'php_method_uninstall', 'php_method_install',
				'php_helper_admin', 'php_admin_event', 'php_helper_both', 'php_helper_site',
				'php_site_event', 'javascript', 'readme', 'sql', 'sql_uninstall'),
			'views' => 'joomla_components',
			'not_base64' => array(),
			'name' => 'system_name'
		),
		// #__componentbuilder_component_dashboard (b)
		'component_dashboard' => array(
			'search' => array('id', 'joomla_component', 'php_dashboard_methods', 'dashboard_tab'),
			'views' => 'components_dashboard',
			'not_base64' => array('dashboard_tab' => 'json'),
			'name' => 'joomla_component->id:joomla_component.system_name'
		),
		// #__componentbuilder_component_placeholders (c)
		'component_placeholders' => array(
			'search' => array('id', 'joomla_component', 'addplaceholders'),
			'views' => 'components_placeholders',
			'not_base64' => array('addplaceholders' => 'json'),
			'name' => 'joomla_component->id:joomla_component.system_name'
		),
		// #__componentbuilder_admin_view (d)
		'admin_view' => array(
			'search' => array('id', 'system_name', 'javascript_view_file', 'javascript_view_footer',
				'javascript_views_file', 'javascript_views_footer', 'html_import_view',
				'php_after_delete', 'php_after_publish', 'php_ajaxmethod', 'php_allowedit', 'php_batchcopy',
				'php_batchmove', 'php_before_delete', 'php_before_publish', 'php_before_save', 'php_controller',
				'php_controller_list', 'php_document', 'php_getitem', 'php_getitems', 'php_getitems_after_all',
				'php_getlistquery', 'php_import', 'php_import_display', 'php_import_ext', 'php_import_headers', 'php_getform',
				'php_import_save', 'php_import_setdata', 'php_model', 'php_model_list', 'php_postsavehook', 'php_save', 'sql'),
			'views' => 'admin_views',
			'not_base64' => array(),
			'name' => 'system_name'
		),
		// #__componentbuilder_admin_fields_relations (e)
		'admin_fields_relations' => array(
			'search' => array('id', 'admin_view', 'addrelations'),
			'views' => 'admins_fields_relations',
			'not_base64' => array('addrelations' => 'json'),
			'name' => 'admin_view->id:admin_view.system_name'
		),
		// #__componentbuilder_admin_custom_tabs (f)
		'admin_custom_tabs' => array(
			'search' => array('id', 'admin_view', 'tabs'),
			'views' => 'admins_custom_tabs',
			'not_base64' => array('tabs' => 'json'),
			'name' => 'admin_view->id:admin_view.system_name'
		),
		// #__componentbuilder_custom_admin_view (g)
		'custom_admin_view' => array(
			'search' => array('id', 'system_name', 'default', 'php_view', 'php_jview', 'php_jview_display', 'php_document',
				'javascript_file', 'js_document', 'css_document', 'css', 'php_ajaxmethod', 'php_model', 'php_controller'),
			'views' => 'custom_admin_views',
			'not_base64' => array(),
			'name' => 'system_name'
		),
		// #__componentbuilder_site_view (h)
		'site_view' => array(
			'search' => array('id', 'system_name', 'default', 'php_view', 'php_jview', 'php_jview_display', 'php_document',
				'javascript_file', 'js_document', 'css_document', 'css', 'php_ajaxmethod', 'php_model', 'php_controller'),
			'views' => 'site_views',
			'not_base64' => array(),
			'name' => 'system_name'
		),
		// #__componentbuilder_field (i)
		'field' => array(
			'search' => array('id', 'name', 'xml', 'javascript_view_footer', 'javascript_views_footer', 'on_save_model_field', 'on_get_model_field', 'initiator_on_save_model', 'initiator_on_get_model'),
			'views' => 'fields',
			'not_base64' => array('xml' => 'json'),
			'base64_search' => array('xml' => array('start' => 'type_php', '_start' => '="', 'end' => '"')),
			'name' => 'name'
		),
		// #__componentbuilder_fieldtype (j)
		'fieldtype' => array(
			'search' => array('id', 'name', 'properties'),
			'views' => 'fieldtypes',
			'not_base64' => array('properties' => 'json'),
			'name' => 'name'
		),
		// #__componentbuilder_dynamic_get (k)
		'dynamic_get' => array(
			'search' => array('id', 'name', 'php_before_getitem', 'php_after_getitem', 'php_before_getitems', 'php_after_getitems',
				'php_getlistquery', 'php_calculation'),
			'views' => 'dynamic_gets',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_template (l)
		'template' => array(
			'search' => array('id', 'name', 'php_view', 'template'),
			'views' => 'templates',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_layout (m)
		'layout' => array(
			'search' => array('id', 'name', 'php_view', 'layout'),
			'views' => 'layouts',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_library (n)
		'library' => array(
			'search' => array('id', 'name', 'php_setdocument'),
			'views' => 'libraries',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_custom_code (o)
		'custom_code' => array(
			'search' => array('id', 'system_name', 'code'),
			'views' => 'custom_codes',
			'not_base64' => array(),
			'name' => 'system_name'
		),
		// #__componentbuilder_validation_rule (p)
		'validation_rule' => array(
			'search' => array('id', 'name', 'php'),
			'views' => 'validation_rules',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_joomla_module (q)
		'joomla_module' => array(
			'search' => array('id', 'system_name', 'name', 'default', 'description', 'mod_code', 'class_helper_header', 'class_helper_code', 'php_script_construct', 'php_preflight_install', 'php_preflight_update',
				'php_preflight_uninstall', 'php_postflight_install', 'php_postflight_update', 'php_method_uninstall',  'sql', 'sql_uninstall', 'readme'),
			'views' => 'joomla_modules',
			'not_base64' => array('description' => 'string', 'readme' => 'string'),
			'name' => 'system_name'
		),
		// #__componentbuilder_joomla_plugin (r)
		'joomla_plugin' => array(
			'search' => array('id', 'system_name', 'name', 'main_class_code', 'head', 'description', 'php_script_construct', 'php_preflight_install', 'php_preflight_update',
				'php_preflight_uninstall', 'php_postflight_install', 'php_postflight_update', 'php_method_uninstall', 'sql', 'sql_uninstall', 'readme'),
			'views' => 'joomla_plugins',
			'not_base64' => array('description' => 'string', 'readme' => 'string'),
			'name' => 'system_name'
		),
		// #__componentbuilder_class_extends (s)
		'class_extends' => array(
			'search' => array('id', 'name', 'head', 'comment'),
			'views' => 'class_extendings',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_class_property (t)
		'class_property' => array(
			'search' => array('id', 'name', 'default', 'comment'),
			'views' => 'class_properties',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_class_method (u)
		'class_method' => array(
			'search' => array('id', 'name', 'code', 'comment'),
			'views' => 'class_methods',
			'not_base64' => array(),
			'name' => 'name'
		),
		// #__componentbuilder_power (v)
		'power' => array(
			'search' => array('id', 'system_name', 'name', 'description', 'head', 'namespace', 'main_class_code'),
			'views' => 'powers',
			'not_base64' => array('description'),
			'name' => 'system_name'
		)
	);

	/**
	* Get the keys of the values to search custom code in
	*
	*  @param   string    $target  The table targeted
	*  @param   string    $type   The type of get
	* 
	*  @return  array      The query options
	* 
	*/
	protected function getCodeSearchKeys($target, $type = null)
	{
		// set the template if type is query
		if ('query' === $type)
		{
			// setup the tables
			$tables = array();
			$key = 'a';
			foreach (array_keys($this->codeSearchKeys) as $table)
			{
				$tables[$key] = $table;
				$key++;
			}
			// check if we have a match
			if (isset($tables[$target]))
			{
				$target = $tables[$target];
			}
		}
		// return result ready for a.query
		if (('query' === $type || 'query_' === $type) && isset($this->codeSearchKeys[$target]))
		{
			// set the targets
			$codeSearchTarget = $this->codeSearchKeys[$target];
			// add the .a to the selection array
			$codeSearchTarget['select'] = array_map( function($select) { return 'a.' . $select; }, $codeSearchTarget['search']);
			// also set the table
			$codeSearchTarget['table'] = $target;
			// remove search
			unset($codeSearchTarget['search']);
			// return targeted array to use in query
			return $codeSearchTarget;
		}
		// does the target exist
		elseif (isset($this->codeSearchKeys[$target]))
		{
			// return target array values to use in search
			return $this->codeSearchKeys[$target];
		}
		return false;
	}


	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   An optional ordering field.
	 * @param   string  $direction  An optional direction (asc|desc).
	 *
	 * @return  void
	 * @since   1.7.0
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = $this->app;

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		// Check if the form was submitted
		$formSubmited = $app->input->post->get('form_submited');

		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		if ($formSubmited)
		{
			$access = $app->input->post->get('access');
			$this->setState('filter.access', $access);
		}

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$companyname = $this->getUserStateFromRequest($this->context . '.filter.companyname', 'filter_companyname');
		if ($formSubmited)
		{
			$companyname = $app->input->post->get('companyname');
			$this->setState('filter.companyname', $companyname);
		}

		$author = $this->getUserStateFromRequest($this->context . '.filter.author', 'filter_author');
		if ($formSubmited)
		{
			$author = $app->input->post->get('author');
			$this->setState('filter.author', $author);
		}

		$system_name = $this->getUserStateFromRequest($this->context . '.filter.system_name', 'filter_system_name');
		if ($formSubmited)
		{
			$system_name = $app->input->post->get('system_name');
			$this->setState('filter.system_name', $system_name);
		}

		$name_code = $this->getUserStateFromRequest($this->context . '.filter.name_code', 'filter_name_code');
		if ($formSubmited)
		{
			$name_code = $app->input->post->get('name_code');
			$this->setState('filter.name_code', $name_code);
		}

		$short_description = $this->getUserStateFromRequest($this->context . '.filter.short_description', 'filter_short_description');
		if ($formSubmited)
		{
			$short_description = $app->input->post->get('short_description');
			$this->setState('filter.short_description', $short_description);
		}

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		if ($formSubmited)
		{
			$created = $app->input->post->get('created');
			$this->setState('filter.created', $created);
		}

		$modified = $this->getUserStateFromRequest($this->context . '.filter.modified', 'filter_modified');
		if ($formSubmited)
		{
			$modified = $app->input->post->get('modified');
			$this->setState('filter.modified', $modified);
		}

		// List state information.
		parent::populateState($ordering, $direction);
	}

	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 * @since   1.6
	 */
	public function getItems()
	{
		// Check in items
		$this->checkInNow();

		// load parent items
		$items = parent::getItems();

		// Set values to display correctly.
		if (UtilitiesArrayHelper::check($items))
		{
			// Get the user object if not set.
			if (!isset($user) || !ObjectHelper::check($user))
			{
				$user = $this->getCurrentUser();
			}
			foreach ($items as $nr => &$item)
			{
				// Remove items the user can't access.
				$access = ($user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $user->authorise('joomla_component.access', 'com_componentbuilder'));
				if (!$access)
				{
					unset($items[$nr]);
					continue;
				}

			}
		}

		// return items
		return $items;
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return  string    An SQL query
	 * @since   1.6
	 */
	protected function getListQuery()
	{
		// Get the user object.
		$user = $this->getCurrentUser();
		// Create a new query object.
		$db = $this->getDatabase();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the componentbuilder_item table
		$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		// Filter by access level.
		$_access = $this->getState('filter.access');
		if ($_access && is_numeric($_access))
		{
			$query->where('a.access = ' . (int) $_access);
		}
		elseif (UtilitiesArrayHelper::check($_access))
		{
			// Secure the array for the query
			$_access = ArrayHelper::toInteger($_access);
			// Filter by the Access Array.
			$query->where('a.access IN (' . implode(',', $_access) . ')');
		}
		// Implement View Level Access
		if (!$user->authorise('core.options', 'com_componentbuilder'))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}
		// Filter by search.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search) . '%');
				$query->where('(a.system_name LIKE '.$search.' OR a.name_code LIKE '.$search.' OR a.short_description LIKE '.$search.' OR a.companyname LIKE '.$search.' OR a.author LIKE '.$search.' OR a.email LIKE '.$search.' OR a.website LIKE '.$search.' OR a.name LIKE '.$search.')');
			}
		}

		// Filter by Companyname.
		$_companyname = $this->getState('filter.companyname');
		if (is_numeric($_companyname))
		{
			if (is_float($_companyname))
			{
				$query->where('a.companyname = ' . (float) $_companyname);
			}
			else
			{
				$query->where('a.companyname = ' . (int) $_companyname);
			}
		}
		elseif (StringHelper::check($_companyname))
		{
			$query->where('a.companyname = ' . $db->quote($db->escape($_companyname)));
		}
		elseif (UtilitiesArrayHelper::check($_companyname))
		{
			// Secure the array for the query
			$_companyname = array_map( function ($val) use(&$db) {
				if (is_numeric($val))
				{
					if (is_float($val))
					{
						return (float) $val;
					}
					else
					{
						return (int) $val;
					}
				}
				elseif (StringHelper::check($val))
				{
					return $db->quote($db->escape($val));
				}
			}, $_companyname);
			// Filter by the Companyname Array.
			$query->where('a.companyname IN (' . implode(',', $_companyname) . ')');
		}
		// Filter by Author.
		$_author = $this->getState('filter.author');
		if (is_numeric($_author))
		{
			if (is_float($_author))
			{
				$query->where('a.author = ' . (float) $_author);
			}
			else
			{
				$query->where('a.author = ' . (int) $_author);
			}
		}
		elseif (StringHelper::check($_author))
		{
			$query->where('a.author = ' . $db->quote($db->escape($_author)));
		}
		elseif (UtilitiesArrayHelper::check($_author))
		{
			// Secure the array for the query
			$_author = array_map( function ($val) use(&$db) {
				if (is_numeric($val))
				{
					if (is_float($val))
					{
						return (float) $val;
					}
					else
					{
						return (int) $val;
					}
				}
				elseif (StringHelper::check($val))
				{
					return $db->quote($db->escape($val));
				}
			}, $_author);
			// Filter by the Author Array.
			$query->where('a.author IN (' . implode(',', $_author) . ')');
		}

		// Add the list ordering clause.
		$orderCol = $this->getState('list.ordering', 'a.id');
		$orderDirn = $this->getState('list.direction', 'desc');
		if ($orderCol != '')
		{
			// Check that the order direction is valid encase we have a field called direction as part of filers.
			$orderDirn = (is_string($orderDirn) && in_array(strtolower($orderDirn), ['asc', 'desc'])) ? $orderDirn : 'desc';
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Method to get list export data.
	 *
	 * @param   array  $pks  The ids of the items to get
	 * @param   JUser  $user  The user making the request
	 *
	 * @return mixed  An array of data items on success, false on failure.
	 */
	public function getExportData($pks, $user = null)
	{
		// setup the query
		if (($pks_size = UtilitiesArrayHelper::check($pks)) !== false || 'bulk' === $pks)
		{
			// Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// Get the user object if not set.
			if (!isset($user) || !ObjectHelper::check($user))
			{
				$user = $this->getCurrentUser();
			}
			// Create a new query object.
			$db = $this->getDatabase();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select('a.*');

			// From the componentbuilder_joomla_component table
			$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));
			// The bulk export path
			if ('bulk' === $pks)
			{
				$query->where('a.id > 0');
			}
			// A large array of ID's will not work out well
			elseif ($pks_size > 500)
			{
				// Use lowest ID
				$query->where('a.id >= ' . (int) min($pks));
				// Use highest ID
				$query->where('a.id <= ' . (int) max($pks));
			}
			// The normal default path
			else
			{
				$query->where('a.id IN (' . implode(',',$pks) . ')');
			}
			// Implement View Level Access
			if (!$user->authorise('core.options', 'com_componentbuilder'))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.id desc');

			// Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// Get the basic encryption key.
				$basickey = ComponentbuilderHelper::getCryptKey('basic');
				// Get the encryption object.
				$basic = new AES($basickey);

				// Set values to display correctly.
				if (UtilitiesArrayHelper::check($items))
				{
					foreach ($items as $nr => &$item)
					{
						// Remove items the user can't access.
						$access = ($user->authorise('joomla_component.access', 'com_componentbuilder.joomla_component.' . (int) $item->id) && $user->authorise('joomla_component.access', 'com_componentbuilder'));
						if (!$access)
						{
							unset($items[$nr]);
							continue;
						}

						// decode php_site_event
						$item->php_site_event = base64_decode($item->php_site_event);
						// decode php_admin_event
						$item->php_admin_event = base64_decode($item->php_admin_event);
						if ($basickey && !is_numeric($item->crowdin_username) && $item->crowdin_username === base64_encode(base64_decode($item->crowdin_username, true)))
						{
							// decrypt crowdin_username
							$item->crowdin_username = $basic->decryptString($item->crowdin_username);
						}
						// decode php_preflight_install
						$item->php_preflight_install = base64_decode($item->php_preflight_install);
						// decode php_method_uninstall
						$item->php_method_uninstall = base64_decode($item->php_method_uninstall);
						// decode css_admin
						$item->css_admin = base64_decode($item->css_admin);
						// decode php_postflight_install
						$item->php_postflight_install = base64_decode($item->php_postflight_install);
						// decode sql
						$item->sql = base64_decode($item->sql);
						// decode buildcompsql
						$item->buildcompsql = base64_decode($item->buildcompsql);
						// decode php_helper_admin
						$item->php_helper_admin = base64_decode($item->php_helper_admin);
						// decode php_helper_site
						$item->php_helper_site = base64_decode($item->php_helper_site);
						if ($basickey && !is_numeric($item->whmcs_key) && $item->whmcs_key === base64_encode(base64_decode($item->whmcs_key, true)))
						{
							// decrypt whmcs_key
							$item->whmcs_key = $basic->decryptString($item->whmcs_key);
						}
						// decode javascript
						$item->javascript = base64_decode($item->javascript);
						// decode css_site
						$item->css_site = base64_decode($item->css_site);
						// decode php_preflight_update
						$item->php_preflight_update = base64_decode($item->php_preflight_update);
						// decode php_postflight_update
						$item->php_postflight_update = base64_decode($item->php_postflight_update);
						// decode php_method_install
						$item->php_method_install = base64_decode($item->php_method_install);
						// decode sql_uninstall
						$item->sql_uninstall = base64_decode($item->sql_uninstall);
						if ($basickey && !is_numeric($item->export_key) && $item->export_key === base64_encode(base64_decode($item->export_key, true)))
						{
							// decrypt export_key
							$item->export_key = $basic->decryptString($item->export_key);
						}
						// decode readme
						$item->readme = base64_decode($item->readme);
						if ($basickey && !is_numeric($item->crowdin_project_api_key) && $item->crowdin_project_api_key === base64_encode(base64_decode($item->crowdin_project_api_key, true)))
						{
							// decrypt crowdin_project_api_key
							$item->crowdin_project_api_key = $basic->decryptString($item->crowdin_project_api_key);
						}
						if ($basickey && !is_numeric($item->crowdin_account_api_key) && $item->crowdin_account_api_key === base64_encode(base64_decode($item->crowdin_account_api_key, true)))
						{
							// decrypt crowdin_account_api_key
							$item->crowdin_account_api_key = $basic->decryptString($item->crowdin_account_api_key);
						}
						// decode php_helper_both
						$item->php_helper_both = base64_decode($item->php_helper_both);
						// unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// Add headers to items array.
				$headers = $this->getExImPortHeaders();
				if (ObjectHelper::check($headers))
				{
					array_unshift($items,$headers);
				}
				return $items;
			}
		}
		return false;
	}

	/**
	* Method to get header.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getExImPortHeaders()
	{
		// Get a db connection.
		$db = Factory::getDbo();
		// get the columns
		$columns = $db->getTableColumns("#__componentbuilder_joomla_component");
		if (UtilitiesArrayHelper::check($columns))
		{
			// remove the headers you don't import/export.
			unset($columns['asset_id']);
			unset($columns['checked_out']);
			unset($columns['checked_out_time']);
			$headers = new \stdClass();
			foreach ($columns as $column => $type)
			{
				$headers->{$column} = $column;
			}
			return $headers;
		}
		return false;
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * @return  string  A store id.
	 * @since   1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.id');
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		// Check if the value is an array
		$_access = $this->getState('filter.access');
		if (UtilitiesArrayHelper::check($_access))
		{
			$id .= ':' . implode(':', $_access);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_access)
		 || StringHelper::check($_access))
		{
			$id .= ':' . $_access;
		}
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		// Check if the value is an array
		$_companyname = $this->getState('filter.companyname');
		if (UtilitiesArrayHelper::check($_companyname))
		{
			$id .= ':' . implode(':', $_companyname);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_companyname)
		 || StringHelper::check($_companyname))
		{
			$id .= ':' . $_companyname;
		}
		// Check if the value is an array
		$_author = $this->getState('filter.author');
		if (UtilitiesArrayHelper::check($_author))
		{
			$id .= ':' . implode(':', $_author);
		}
		// Check if this is only an number or string
		elseif (is_numeric($_author)
		 || StringHelper::check($_author))
		{
			$id .= ':' . $_author;
		}
		$id .= ':' . $this->getState('filter.system_name');
		$id .= ':' . $this->getState('filter.name_code');
		$id .= ':' . $this->getState('filter.short_description');
		$id .= ':' . $this->getState('filter.created');
		$id .= ':' . $this->getState('filter.modified');

		return parent::getStoreId($id);
	}

	/**
	 * Method to get the styles that have to be included on the view
	 *
	 * @return  array    styles files
	 * @since   4.3
	 */
	public function getStyles(): array
	{
		return $this->styles;
	}

	/**
	 * Method to set the styles that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setStyles(string $path): void
	{
		$this->styles[] = $path;
	}

	/**
	 * Method to get the script that have to be included on the view
	 *
	 * @return  array    script files
	 * @since   4.3
	 */
	public function getScripts(): array
	{
		return $this->scripts;
	}

	/**
	 * Method to set the script that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setScript(string $path): void
	{
		$this->scripts[] = $path;
	}

	/**
	 * Build an SQL query to checkin all items left checked out longer then a set time.
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	protected function checkInNow(): bool
	{
		// Get set check in time
		$time = ComponentHelper::getParams('com_componentbuilder')->get('check_in');

		if ($time)
		{
			// Get a db connection.
			$db = $this->getDatabase();
			// Reset query.
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__componentbuilder_joomla_component'));
			// Only select items that are checked out.
			$query->where($db->quoteName('checked_out') . '!=0');
			$db->setQuery($query, 0, 1);
			$db->execute();
			if ($db->getNumRows())
			{
				// Get Yesterdays date.
				$date = Factory::getDate()->modify($time)->toSql();
				// Reset query.
				$query = $db->getQuery(true);

				// Fields to update.
				$fields = array(
					$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',
					$db->quoteName('checked_out') . '=0'
				);

				// Conditions for which records should be updated.
				$conditions = array(
					$db->quoteName('checked_out') . '!=0', 
					$db->quoteName('checked_out_time') . '<\''.$date.'\''
				);

				// Check table.
				$query->update($db->quoteName('#__componentbuilder_joomla_component'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				return $db->execute();
			}
		}

		return false;
	}
}
