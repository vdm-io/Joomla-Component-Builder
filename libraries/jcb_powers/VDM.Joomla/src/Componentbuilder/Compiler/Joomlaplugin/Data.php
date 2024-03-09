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

namespace VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin;


use Joomla\CMS\Factory;
use Joomla\CMS\Filter\OutputFilter;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Field;
use VDM\Joomla\Componentbuilder\Compiler\Field\Name as FieldName;
use VDM\Joomla\Componentbuilder\Compiler\Model\Filesfolders;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\String\PluginHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Joomla Plugin Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * Compiler Joomla Plugins Data
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $data = [];

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Compiler Language
	 *
	 * @var    Language
	 * @since 3.2.0
	 **/
	protected Language $language;

	/**
	 * Compiler Field
	 *
	 * @var    Field
	 * @since 3.2.0
	 */
	protected Field $field;

	/**
	 * Compiler field name
	 *
	 * @var    FieldName
	 * @since 3.2.0
	 */
	protected FieldName $fieldName;

	/**
	 * Compiler Files Folders
	 *
	 * @var    Filesfolders
	 * @since 3.2.0
	 */
	protected Filesfolders $filesFolders;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param Customcode|null           $customcode       The compiler customcode object.
	 * @param Gui|null                  $gui              The compiler customcode gui.
	 * @param Placeholder|null          $placeholder      The compiler placeholder object.
	 * @param Language|null             $language         The compiler Language object.
	 * @param Field|null                $field            The compiler field data object.
	 * @param FieldName|null            $fieldName        The compiler  field name object.
	 * @param Filesfolders|null         $filesFolders     The compiler files folders object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Customcode $customcode = null,
		?Gui $gui = null, ?Placeholder $placeholder = null,
		?Language $language = null, ?Field $field = null, ?FieldName $fieldName = null,
		?Filesfolders $filesFolders = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->language = $language ?: Compiler::_('Language');
		$this->field = $field ?: Compiler::_('Field');
		$this->fieldName = $fieldName ?: Compiler::_('Field.Name');
		$this->filesFolders = $filesFolders ?: Compiler::_('Model.Filesfolders');
		$this->db = Factory::getDbo();
	}

	/**
	 * Get the Joomla Plugin/s
	 *
	 * @param   int|null   $id   the plugin id
	 *
	 * @return  object|array|null    if ID found it returns object, if no ID given it returns all set
	 * @since 3.2.0
	 */
	public function get(int $id = null)
	{
		if (is_null($id) && $this->exists())
		{
			return $this->data;
		}
		elseif ($this->exists($id))
		{
			return $this->data[$id];
		}

		return null;
	}

	/**
	 * Check if the Joomla Plugin/s exists
	 *
	 * @param   int|null   $id   the plugin id
	 *
	 * @return  bool    if ID found it returns true, if no ID given it returns true if any are set
	 * @since 3.2.0
	 */
	public function exists(int $id = null): bool
	{
		if (is_null($id))
		{
			return ArrayHelper::check($this->data);
		}
		elseif (isset($this->data[$id]))
		{
			return true;
		}

		return $this->set($id);
	}

	/**
	 * Set the Joomla Plugin
	 *
	 * @param   int      $id   the plugin id
	 *
	 * @return  bool    true on success
	 * @since 3.2.0
	 */
	public function set(int $id): bool
	{
		if (isset($this->data[$id]))
		{
			return true;
		}
		else
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'g.name',
						'e.name',
						'e.head',
						'e.comment',
						'e.id',
						'f.addfiles',
						'f.addfolders',
						'f.addfilesfullpath',
						'f.addfoldersfullpath',
						'f.addurls',
						'u.version_update',
						'u.id'
					), array(
						'group',
						'extends',
						'class_head',
						'comment',
						'class_id',
						'addfiles',
						'addfolders',
						'addfilesfullpath',
						'addfoldersfullpath',
						'addurls',
						'version_update',
						'version_update_id'
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
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_class_extends', 'e')
				. ' ON (' . $this->db->quoteName('a.class_extends') . ' = '
				. $this->db->quoteName('e.id') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_plugin_updates', 'u'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('u.joomla_plugin') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_plugin_files_folders_urls', 'f'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('f.joomla_plugin') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$query->where($this->db->quoteName('a.published') . ' >= 1');
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// get the plugin data
				$plugin = $this->db->loadObject();

				// tweak system to set stuff to the plugin domain
				$_backup_target     = $this->config->build_target;
				$_backup_lang       = $this->config->lang_target;
				$_backup_langPrefix = $this->config->lang_prefix;

				// set some keys
				$plugin->target_type = 'pLuG!n';
				$plugin->key         = $plugin->id . '_' . $plugin->target_type;

				// update to point to plugin
				$this->config->build_target = $plugin->key;
				$this->config->lang_target = $plugin->key;

				// set version if not set
				if (empty($plugin->plugin_version))
				{
					$plugin->plugin_version = '1.0.0';
				}

				// set GUI mapper
				$guiMapper = array('table' => 'joomla_plugin',
				                   'id'    => (int) $id, 'type' => 'php');

				// update the name if it has dynamic values
				$plugin->name = $this->placeholder->update_(
					$this->customcode->update($plugin->name)
				);

				// update the name if it has dynamic values
				$plugin->code_name
					= ClassfunctionHelper::safe(
					$plugin->name
				);

				// set official name
				$plugin->official_name = ucwords(
					$plugin->group . ' - ' . $plugin->name
				);

				// set lang prefix
				$plugin->lang_prefix = PluginHelper::safeLangPrefix(
					$plugin->code_name,
					$plugin->group
				);

				// set langPrefix
				$this->config->lang_prefix = $plugin->lang_prefix;

				// set plugin class name
				$plugin->class_name
					= PluginHelper::safeClassName(
						$plugin->code_name,
						$plugin->group
				);

				// set plugin install class name
				$plugin->installer_class_name
					= PluginHelper::safeInstallClassName(
						$plugin->code_name,
						$plugin->group
				);

				// set plugin folder name
				$plugin->folder_name
					= PluginHelper::safeFolderName(
						$plugin->code_name,
						$plugin->group
				);

				// set the zip name
				$plugin->zip_name = $plugin->folder_name . '_v' . str_replace(
						'.', '_', (string) $plugin->plugin_version
					) . '__J' . $this->config->joomla_version;

				// set plugin file name
				$plugin->file_name = strtolower((string) $plugin->code_name);

				// set plugin context
				$plugin->context = $plugin->folder_name . '.' . $plugin->id;

				// set official_name lang strings
				$this->language->set(
					$plugin->key, $this->config->lang_prefix, $plugin->official_name
				);

				// set some placeholder for this plugin
				$this->placeholder->set('Plugin_name', $plugin->official_name);
				$this->placeholder->set('PLUGIN_NAME', $plugin->official_name);
				$this->placeholder->set('Plugin', ucfirst((string) $plugin->code_name));
				$this->placeholder->set('plugin', strtolower((string) $plugin->code_name));
				$this->placeholder->set('Plugin_group', ucfirst((string) $plugin->group));
				$this->placeholder->set('plugin_group', strtolower((string) $plugin->group));
				$this->placeholder->set('plugin.version', $plugin->plugin_version);
				$this->placeholder->set('VERSION', $plugin->plugin_version);
				$this->placeholder->set('plugin_version', str_replace(
					'.', '_', (string) $plugin->plugin_version
				));

				// set description
				$this->placeholder->set('DESCRIPTION', '');
				if (!isset($plugin->description)
					|| !StringHelper::check(
						$plugin->description
					))
				{
					$plugin->description = '';
				}
				else
				{
					$plugin->description = $this->placeholder->update_(
						$this->customcode->update($plugin->description)
					);
					$this->language->set(
						$plugin->key, $plugin->lang_prefix . '_DESCRIPTION',
						$plugin->description
					);
					// set description
					$this->placeholder->set('DESCRIPTION', $plugin->description);
					$plugin->description = '<p>' . $plugin->description . '</p>';
				}

				// get author name
				$project_author = $this->config->project_author;

				// we can only set these if the component was passed
				$plugin->xml_description = "<h1>" . $plugin->official_name
					. " (v." . $plugin->plugin_version
					. ")</h1> <div style='clear: both;'></div>"
					. $plugin->description . "<p>Created by <a href='" . trim(
						(string) $this->config->project_website
					) . "' target='_blank'>" . trim(
						(string) OutputFilter::cleanText($project_author)
					) . "</a><br /><small>Development started "
					. Factory::getDate($plugin->created)->format("jS F, Y")
					. "</small></p>";

				// set xml discription
				$this->language->set(
					$plugin->key, $plugin->lang_prefix . '_XML_DESCRIPTION',
					$plugin->xml_description
				);

				// update the readme if set
				if ($plugin->addreadme == 1 && !empty($plugin->readme))
				{
					$plugin->readme = $this->placeholder->update_(
						$this->customcode->update(base64_decode((string) $plugin->readme))
					);
				}
				else
				{
					$plugin->addreadme = 0;
					unset($plugin->readme);
				}

				// open some base64 strings
				if (!empty($plugin->main_class_code))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'main_class_code';
					// base64 Decode main_class_code.
					$plugin->main_class_code = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $plugin->main_class_code)
							)
						),
						$guiMapper
					);
				}

				// set the head :)
				if ($plugin->add_head == 1 && !empty($plugin->head))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'head';
					// base64 Decode head.
					$plugin->head = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $plugin->head)
							)
						),
						$guiMapper
					);
				}
				elseif (!empty($plugin->class_head))
				{
					// base64 Decode head.
					$plugin->head = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $plugin->class_head)
							)
						),
						array(
							'table' => 'class_extends',
							'field' => 'head',
							'id'    => (int) $plugin->class_id,
							'type'  => 'php')
					);
				}
				unset($plugin->class_head);

				// set the comment
				if (!empty($plugin->comment))
				{
					// base64 Decode comment.
					$plugin->comment = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $plugin->comment)
							)
						),
						array(
							'table' => 'class_extends',
							'field' => 'comment',
							'id'    => (int) $plugin->class_id,
							'type'  => 'php')
					);
				}

				// start the config array
				$plugin->config_fields = [];
				// create the form arrays
				$plugin->form_files      = [];
				$plugin->fieldsets_label = [];
				$plugin->fieldsets_paths = [];
				$plugin->add_rule_path = [];
				$plugin->add_field_path = [];
				// set global fields rule to default component path
				$plugin->fields_rules_paths = 1;
				// set the fields data
				$plugin->fields = (isset($plugin->fields)
					&& JsonHelper::check($plugin->fields))
					? json_decode((string) $plugin->fields, true) : null;
				if (ArrayHelper::check($plugin->fields))
				{
					// ket global key
					$key            = $plugin->key;
					$dynamic_fields = array('fieldset'    => 'basic',
					                        'fields_name' => 'params',
					                        'file'        => 'config');
					foreach ($plugin->fields as $n => &$form)
					{
						if (isset($form['fields'])
							&& ArrayHelper::check(
								$form['fields']
							))
						{
							// make sure the dynamic_field is set to dynamic_value by default
							foreach (
								$dynamic_fields as $dynamic_field =>
								$dynamic_value
							)
							{
								if (!isset($form[$dynamic_field])
									|| !StringHelper::check(
										$form[$dynamic_field]
									))
								{
									$form[$dynamic_field] = $dynamic_value;
								}
								else
								{
									if ('fields_name' === $dynamic_field
										&& strpos((string) $form[$dynamic_field], '.')
										!== false)
									{
										$form[$dynamic_field]
											= $form[$dynamic_field];
									}
									else
									{
										$form[$dynamic_field]
											= StringHelper::safe(
											$form[$dynamic_field]
										);
									}
								}
							}
							// check if field is external form file
							if (!isset($form['plugin']) || $form['plugin'] != 1)
							{
								// now build the form key
								$unique = $form['file'] . $form['fields_name']
									. $form['fieldset'];
							}
							else
							{
								// now build the form key
								$unique = $form['fields_name']
									. $form['fieldset'];
							}
							// set global fields rule path switchs
							if ($plugin->fields_rules_paths == 1
								&& isset($form['fields_rules_paths'])
								&& $form['fields_rules_paths'] == 2)
							{
								$plugin->fields_rules_paths = 2;
							}
							// set where to path is pointing
							$plugin->fieldsets_paths[$unique]
								= $form['fields_rules_paths'];
							// add the label if set to lang
							if (isset($form['label'])
								&& StringHelper::check(
									$form['label']
								))
							{
								$plugin->fieldsets_label[$unique]
									= $this->language->key($form['label']);
							}
							// check for extra rule paths
							if (isset($form['addrulepath'])
								&& ArrayHelper::check($form['addrulepath']))
							{
								foreach ($form['addrulepath'] as $add_rule_path)
								{
									if (StringHelper::check($add_rule_path['path']))
									{
										$plugin->add_rule_path[$unique] = $add_rule_path['path'];
									}
								}
							}
							// check for extra field paths
							if (isset($form['addfieldpath'])
								&& ArrayHelper::check($form['addfieldpath']))
							{
								foreach ($form['addfieldpath'] as $add_field_path)
								{
									if (StringHelper::check($add_field_path['path']))
									{
										$plugin->add_field_path[$unique] = $add_field_path['path'];
									}
								}
							}
							// build the fields
							$form['fields'] = array_map(
								function ($field) use ($key, $unique) {
									// make sure the alias and title is 0
									$field['alias'] = 0;
									$field['title'] = 0;
									// set the field details
									$this->field->set(
										$field, $key, $key, $unique
									);
									// update the default if set
									if (StringHelper::check(
											$field['custom_value']
										)
										&& isset($field['settings']))
									{
										if (($old_default
												= GetHelper::between(
												$field['settings']->xml,
												'default="', '"', false
											)) !== false)
										{
											// replace old default
											$field['settings']->xml
												= str_replace(
												'default="' . $old_default
												. '"', 'default="'
												. $field['custom_value'] . '"',
												(string) $field['settings']->xml
											);
										}
										else
										{
											// add the default (hmmm not ideal but okay it should work)
											$field['settings']->xml
												= 'default="'
												. $field['custom_value'] . '" '
												. $field['settings']->xml;
										}
									}
									unset($field['custom_value']);

									// return field
									return $field;
								}, array_values($form['fields'])
							);
							// check if field is external form file
							if (!isset($form['plugin']) || $form['plugin'] != 1)
							{
								// load the form file
								if (!isset($plugin->form_files[$form['file']]))
								{
									$plugin->form_files[$form['file']]
										= [];
								}
								if (!isset($plugin->form_files[$form['file']][$form['fields_name']]))
								{
									$plugin->form_files[$form['file']][$form['fields_name']]
										= [];
								}
								if (!isset($plugin->form_files[$form['file']][$form['fields_name']][$form['fieldset']]))
								{
									$plugin->form_files[$form['file']][$form['fields_name']][$form['fieldset']]
										= [];
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->fieldName->get(
										$field, $plugin->key, $unique
									);
									// add the fields to the global form file builder
									$plugin->form_files[$form['file']][$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($plugin->fields[$n]);
							}
							else
							{
								// load the config form
								if (!isset($plugin->config_fields[$form['fields_name']]))
								{
									$plugin->config_fields[$form['fields_name']]
										= [];
								}
								if (!isset($plugin->config_fields[$form['fields_name']][$form['fieldset']]))
								{
									$plugin->config_fields[$form['fields_name']][$form['fieldset']]
										= [];
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->fieldName->get(
										$field, $plugin->key, $unique
									);
									// add the fields to the config builder
									$plugin->config_fields[$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($plugin->fields[$n]);
							}
						}
						else
						{
							unset($plugin->fields[$n]);
						}
					}
				}
				unset($plugin->fields);

				// set files and folders
				$this->filesFolders->set($plugin);

				// add PHP in plugin install
				$plugin->add_install_script = true;
				$addScriptMethods = [
					'php_preflight',
					'php_postflight',
					'php_method'
				];
				$addScriptTypes = [
					'install',
					'update',
					'uninstall'
				];
				foreach ($addScriptMethods as $scriptMethod)
				{
					foreach ($addScriptTypes as $scriptType)
					{
						if (isset( $plugin->{'add_' . $scriptMethod . '_' . $scriptType})
							&& $plugin->{'add_' . $scriptMethod . '_' . $scriptType} == 1
							&& StringHelper::check(
								$plugin->{$scriptMethod . '_' . $scriptType}
							))
						{
							// set GUI mapper field
							$guiMapper['field'] = $scriptMethod . '_' . $scriptType;
							$plugin->{$scriptMethod . '_' . $scriptType} = $this->gui->set(
								$this->placeholder->update_(
									$this->customcode->update(
										base64_decode(
											(string) $plugin->{$scriptMethod . '_' . $scriptType}
										)
									)
								),
								$guiMapper
							);
						}
						else
						{
							unset($plugin->{$scriptMethod . '_' . $scriptType});
							$plugin->{'add_' . $scriptMethod . '_' . $scriptType} = 0;
						}
					}
				}

				// add_sql
				if ($plugin->add_sql == 1
					&& StringHelper::check($plugin->sql))
				{
					$plugin->sql = $this->placeholder->update_(
						$this->customcode->update(base64_decode((string) $plugin->sql))
					);
				}
				else
				{
					unset($plugin->sql);
					$plugin->add_sql = 0;
				}

				// add_sql_uninstall
				if ($plugin->add_sql_uninstall == 1
					&& StringHelper::check(
						$plugin->sql_uninstall
					))
				{
					$plugin->sql_uninstall = $this->placeholder->update_(
						$this->customcode->update(
							base64_decode((string) $plugin->sql_uninstall)
						)
					);
				}
				else
				{
					unset($plugin->sql_uninstall);
					$plugin->add_sql_uninstall = 0;
				}

				// update the URL of the update_server if set
				if ($plugin->add_update_server == 1
					&& StringHelper::check(
						$plugin->update_server_url
					))
				{
					$plugin->update_server_url = $this->placeholder->update_(
						$this->customcode->update($plugin->update_server_url)
					);
				}

				// add the update/sales server FTP details if that is the expected protocol
				$serverArray = array('update_server', 'sales_server');
				foreach ($serverArray as $server)
				{
					if ($plugin->{'add_' . $server} == 1
						&& is_numeric(
							$plugin->{$server}
						)
						&& $plugin->{$server} > 0)
					{
						// get the server protocol
						$plugin->{$server . '_protocol'}
							= GetHelper::var(
							'server', (int) $plugin->{$server}, 'id', 'protocol'
						);
					}
					else
					{
						$plugin->{$server} = 0;
						// only change this for sales server (update server can be added locally to the zip file)
						if ('sales_server' === $server)
						{
							$plugin->{'add_' . $server} = 0;
						}
						$plugin->{$server . '_protocol'} = 0;
					}
				}

				// set the update server stuff (TODO)
				// update_server_xml_path
				// update_server_xml_file_name

				// rest globals
				$this->config->build_target = $_backup_target;
				$this->config->lang_target = $_backup_lang;
				$this->config->set('lang_prefix', $_backup_langPrefix);

				$this->placeholder->remove('Plugin_name');
				$this->placeholder->remove('Plugin');
				$this->placeholder->remove('plugin');
				$this->placeholder->remove('Plugin_group');
				$this->placeholder->remove('plugin_group');
				$this->placeholder->remove('plugin.version');
				$this->placeholder->remove('plugin_version');
				$this->placeholder->remove('VERSION');
				$this->placeholder->remove('DESCRIPTION');
				$this->placeholder->remove('PLUGIN_NAME');

				$this->data[$id] = $plugin;

				return true;
			}
		}

		return false;
	}

}

