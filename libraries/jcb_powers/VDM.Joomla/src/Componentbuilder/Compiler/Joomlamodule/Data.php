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

namespace VDM\Joomla\Componentbuilder\Compiler\Joomlamodule;


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
use VDM\Joomla\Componentbuilder\Compiler\Model\Libraries;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Data as Dynamicget;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Joomla Module Data Class
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
	 * Compiler Libraries Model
	 *
	 * @var    Libraries
	 * @since 3.2.0
	 */
	protected Libraries $libraries;

	/**
	 * Compiler Dynamic Get Data
	 *
	 * @var    Dynamicget
	 * @since 3.2.0
	 */
	protected Dynamicget $dynamic;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

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
	 * @param Libraries|null            $libraries        The compiler libraries model object.
	 * @param Dynamicget|null           $dynamic          The compiler dynamic get data object.
	 * @param \JDatabaseDriver|null     $db               The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Customcode $customcode = null,
		?Gui $gui = null, ?Placeholder $placeholder = null,
		?Language $language = null, ?Field $field = null, ?FieldName $fieldName = null,
		?Filesfolders $filesFolders = null, ?Libraries $libraries = null,
		?Dynamicget $dynamic = null, ?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->language = $language ?: Compiler::_('Language');
		$this->field = $field ?: Compiler::_('Field');
		$this->fieldName = $fieldName ?: Compiler::_('Field.Name');
		$this->filesFolders = $filesFolders ?: Compiler::_('Model.Filesfolders');
		$this->libraries = $libraries ?: Compiler::_('Model.Libraries');
		$this->dynamic = $dynamic ?: Compiler::_('Dynamicget.Data');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Get the Joomla Module/s
	 *
	 * @param   int|null   $id   the module id
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
	 * Check if the Joomla Module/s exists
	 *
	 * @param   int|null   $id   the module id
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
	 * Set the Joomla Module
	 *
	 * @param   int     $id     the module id
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
						'f.addfiles',
						'f.addfolders',
						'f.addfilesfullpath',
						'f.addfoldersfullpath',
						'f.addurls',
						'u.version_update',
						'u.id'
					), array(
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
			$query->from('#__componentbuilder_joomla_module AS a');
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_module_updates', 'u'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('u.joomla_module') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_joomla_module_files_folders_urls', 'f'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('f.joomla_module') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$query->where($this->db->quoteName('a.published') . ' >= 1');
			$this->db->setQuery($query);
			$this->db->execute();
			if ($this->db->getNumRows())
			{
				// get the module data
				$module = $this->db->loadObject();

				// tweak system to set stuff to the module domain
				$_backup_target     = $this->config->build_target;
				$_backup_lang       = $this->config->lang_target;
				$_backup_langPrefix = $this->config->lang_prefix;

				// set some keys
				$module->target_type = 'M0dU|3';
				$module->key         = $module->id . '_' . $module->target_type;

				// update to point to module
				$this->config->build_target = $module->key;
				$this->config->lang_target = $module->key;

				// set version if not set
				if (empty($module->module_version))
				{
					$module->module_version = '1.0.0';
				}

				// set target client
				if ($module->target == 2)
				{
					$module->target_client = 'administrator';
				}
				else
				{
					// default is site area
					$module->target_client = 'site';
				}

				// set GUI mapper
				$guiMapper = array('table' => 'joomla_module',
				                   'id'    => (int) $id, 'type' => 'php');
				// update the name if it has dynamic values
				$module->name = $this->placeholder->update_(
					$this->customcode->update($module->name)
				);

				// set safe class function name
				$module->code_name
					= ClassfunctionHelper::safe(
					$module->name
				);

				// alias of code name
				$module->class_name = $module->code_name;
				// set official name
				$module->official_name = StringHelper::safe(
					$module->name, 'W'
				);
				$this->config->set('lang_prefix', 'MOD_' . strtoupper((string) $module->code_name));

				// set lang prefix
				$module->lang_prefix = $this->config->lang_prefix;

				// set module class name
				$module->class_helper_name = 'Mod' . ucfirst((string) $module->code_name)
					. 'Helper';
				$module->class_data_name   = 'Mod' . ucfirst((string) $module->code_name)
					. 'Data';

				// set module install class name
				$module->installer_class_name = 'mod_' . ucfirst(
						(string) $module->code_name
					) . 'InstallerScript';

				// set module folder name
				$module->folder_name = 'mod_' . strtolower((string) $module->code_name);

				// set the zip name
				$module->zip_name = $module->folder_name . '_v' . str_replace(
						'.', '_', (string) $module->module_version
					) . '__J' . $this->config->joomla_version;

				// set module file name
				$module->file_name = $module->folder_name;

				// set module context
				$module->context = $module->file_name . '.' . $module->id;

				// set official_name lang strings
				$this->language->set(
					$module->key, $this->config->lang_prefix, $module->official_name
				);

				// set some placeholder for this module
				$this->placeholder->set('Module_name', $module->official_name);
				$this->placeholder->set('Module', ucfirst(
					(string) $module->code_name
				));
				$this->placeholder->set('module', strtolower(
					(string) $module->code_name
				));
				$this->placeholder->set('module.version', $module->module_version);
				$this->placeholder->set('module_version', str_replace(
					'.', '_', (string) $module->module_version
				));
				// set description (TODO) add description field to module
				if (!isset($module->description)
					|| !StringHelper::check(
						$module->description
					))
				{
					$module->description = '';
				}
				else
				{
					$module->description = $this->placeholder->update_(
						$this->customcode->update($module->description)
					);
					$this->language->set(
						$module->key, $module->lang_prefix . '_DESCRIPTION',
						$module->description
					);
					$module->description = '<p>' . $module->description
						. '</p>';
				}

				// get author name
				$project_author = $this->config->project_author;

				// set the description
				$module->xml_description = "<h1>" . $module->official_name
					. " (v." . $module->module_version
					. ")</h1> <div style='clear: both;'></div>"
					. $module->description . "<p>Created by <a href='" . trim(
						(string) $this->config->project_website
					) . "' target='_blank'>" . trim(
						(string) OutputFilter::cleanText($project_author)
					) . "</a><br /><small>Development started "
					. Factory::getDate($module->created)->format("jS F, Y")
					. "</small></p>";

				// set xml description
				$this->language->set(
					$module->key, $module->lang_prefix . '_XML_DESCRIPTION',
					$module->xml_description
				);

				// update the readme if set
				if ($module->addreadme == 1 && !empty($module->readme))
				{
					$module->readme = $this->placeholder->update_(
						$this->customcode->update(base64_decode((string) $module->readme))
					);
				}
				else
				{
					$module->addreadme = 0;
					unset($module->readme);
				}

				// get the custom_get
				$module->custom_get = (isset($module->custom_get)
					&& JsonHelper::check($module->custom_get))
					? json_decode((string) $module->custom_get, true) : null;

				if (ArrayHelper::check($module->custom_get))
				{
					$module->custom_get = $this->dynamic->get(
						$module->custom_get, $module->key, $module->key
					);
				}
				else
				{
					$module->custom_get = null;
				}

				// set helper class details
				if ($module->add_class_helper >= 1
					&& StringHelper::check(
						$module->class_helper_code
					))
				{
					if ($module->add_class_helper_header == 1
						&& StringHelper::check(
							$module->class_helper_header
						))
					{
						// set GUI mapper field
						$guiMapper['field'] = 'class_helper_header';
						// base64 Decode code
						$module->class_helper_header = PHP_EOL
							. $this->gui->set(
								$this->placeholder->update_(
									$this->customcode->update(
										base64_decode(
											(string) $module->class_helper_header
										)
									)
								),
								$guiMapper
							) . PHP_EOL;
					}
					else
					{
						$module->add_class_helper_header = 0;
						$module->class_helper_header     = '';
					}
					// set GUI mapper field
					$guiMapper['field'] = 'class_helper_code';
					// base64 Decode code
					$module->class_helper_code = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $module->class_helper_code)
							)
						),
						$guiMapper
					);
					// set class type
					if ($module->add_class_helper == 2)
					{
						$module->class_helper_type = 'abstract class ';
					}
					else
					{
						$module->class_helper_type = 'class ';
					}
				}
				else
				{
					$module->add_class_helper    = 0;
					$module->class_helper_code   = '';
					$module->class_helper_header = '';
				}

				// base64 Decode mod_code
				if (isset($module->mod_code)
					&& StringHelper::check($module->mod_code))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'mod_code';
					$module->mod_code   = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $module->mod_code)
							)
						),
						$guiMapper
					);
				}
				else
				{
					$module->mod_code = "// get the module class sfx";
					$module->mod_code .= PHP_EOL
						. "\$moduleclass_sfx = htmlspecialchars(\$params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');";
					$module->mod_code .= PHP_EOL . "// load the default Tmpl";
					$module->mod_code .= PHP_EOL
						. "require JModuleHelper::getLayoutPath('mod_"
						. strtolower((string) $module->code_name)
						. "', \$params->get('layout', 'default'));";
				}

				// base64 Decode default header
				if (isset($module->default_header)
					&& StringHelper::check(
						$module->default_header
					))
				{
					// set GUI mapper field
					$guiMapper['field']     = 'default_header';
					$module->default_header = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $module->default_header)
							)
						),
						$guiMapper
					);
				}
				else
				{
					$module->default_header = '';
				}

				// base64 Decode default
				if (isset($module->default)
					&& StringHelper::check($module->default))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'default';
					$guiMapper['type']  = 'html';
					$module->default    = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode((string) $module->default)
							)
						),
						$guiMapper
					);
				}
				else
				{
					$module->default = '<h1>No Tmpl set</h1>';
				}

				// start the config array
				$module->config_fields = [];
				// create the form arrays
				$module->form_files      = [];
				$module->fieldsets_label = [];
				$module->fieldsets_paths = [];
				$module->add_rule_path = [];
				$module->add_field_path = [];
				// set global fields rule to default component path
				$module->fields_rules_paths = 1;
				// set the fields data
				$module->fields = (isset($module->fields)
					&& JsonHelper::check($module->fields))
					? json_decode((string) $module->fields, true) : null;
				if (ArrayHelper::check($module->fields))
				{
					// ket global key
					$key            = $module->key;
					$dynamic_fields = array('fieldset'    => 'basic',
					                        'fields_name' => 'params',
					                        'file'        => 'config');
					foreach ($module->fields as $n => &$form)
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
							if (!isset($form['module']) || $form['module'] != 1)
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
							// set global fields rule path switches
							if ($module->fields_rules_paths == 1
								&& isset($form['fields_rules_paths'])
								&& $form['fields_rules_paths'] == 2)
							{
								$module->fields_rules_paths = 2;
							}
							// set where to path is pointing
							$module->fieldsets_paths[$unique]
								= $form['fields_rules_paths'];
							// check for extra rule paths
							if (isset($form['addrulepath'])
								&& ArrayHelper::check($form['addrulepath']))
							{
								foreach ($form['addrulepath'] as $add_rule_path)
								{
									if (StringHelper::check($add_rule_path['path']))
									{
										$module->add_rule_path[$unique] = $add_rule_path['path'];
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
										$module->add_field_path[$unique] = $add_field_path['path'];
									}
								}
							}
							// add the label if set to lang
							if (isset($form['label'])
								&& StringHelper::check(
									$form['label']
								))
							{
								$module->fieldsets_label[$unique]
									= $this->language->key($form['label']);
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
							if (!isset($form['module']) || $form['module'] != 1)
							{
								// load the form file
								if (!isset($module->form_files[$form['file']]))
								{
									$module->form_files[$form['file']]
										= [];
								}
								if (!isset($module->form_files[$form['file']][$form['fields_name']]))
								{
									$module->form_files[$form['file']][$form['fields_name']]
										= [];
								}
								if (!isset($module->form_files[$form['file']][$form['fields_name']][$form['fieldset']]))
								{
									$module->form_files[$form['file']][$form['fields_name']][$form['fieldset']]
										= [];
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->fieldName->get(
										$field, $module->key, $unique
									);
									// add the fields to the global form file builder
									$module->form_files[$form['file']][$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($module->fields[$n]);
							}
							else
							{
								// load the config form
								if (!isset($module->config_fields[$form['fields_name']]))
								{
									$module->config_fields[$form['fields_name']]
										= [];
								}
								if (!isset($module->config_fields[$form['fields_name']][$form['fieldset']]))
								{
									$module->config_fields[$form['fields_name']][$form['fieldset']]
										= [];
								}
								// do some house cleaning (for fields)
								foreach ($form['fields'] as $field)
								{
									// so first we lock the field name in
									$this->fieldName->get(
										$field, $module->key, $unique
									);
									// add the fields to the config builder
									$module->config_fields[$form['fields_name']][$form['fieldset']][]
										= $field;
								}
								// remove form
								unset($module->fields[$n]);
							}
						}
						else
						{
							unset($module->fields[$n]);
						}
					}
				}
				unset($module->fields);

				// set files and folders
				$this->filesFolders->set($module);

				// set libraries
				$this->libraries->set($module->code_name, $module);

				// add PHP in module install
				$module->add_install_script = true;
				$addScriptMethods = [
					'php_script',
					'php_preflight',
					'php_postflight',
					'php_method'
				];
				$addScriptTypes = [
					'install',
					'update',
					'uninstall'
				];
				// the next are php placeholders
				$guiMapper['type'] = 'php';
				foreach ($addScriptMethods as $scriptMethod)
				{
					foreach ($addScriptTypes as $scriptType)
					{
						if (isset($module->{'add_' . $scriptMethod . '_' . $scriptType})
							&& $module->{'add_' . $scriptMethod . '_' . $scriptType} == 1
							&& StringHelper::check(
								$module->{$scriptMethod . '_' . $scriptType}
							))
						{
							// set GUI mapper field
							$guiMapper['field'] = $scriptMethod . '_' . $scriptType;
							$module->{$scriptMethod . '_' . $scriptType} = $this->gui->set(
								$this->placeholder->update_(
									$this->customcode->update(
										base64_decode(
											(string) $module->{$scriptMethod . '_' . $scriptType}
										)
									)
								),
								$guiMapper
							);
						}
						else
						{
							unset($module->{$scriptMethod . '_' . $scriptType});
							$module->{'add_' . $scriptMethod . '_' . $scriptType} = 0;
						}
					}
				}

				// add_sql
				if ($module->add_sql == 1
					&& StringHelper::check($module->sql))
				{
					$module->sql = $this->placeholder->update_(
						$this->customcode->update(base64_decode((string) $module->sql))
					);
				}
				else
				{
					unset($module->sql);
					$module->add_sql = 0;
				}

				// add_sql_uninstall
				if ($module->add_sql_uninstall == 1
					&& StringHelper::check(
						$module->sql_uninstall
					))
				{
					$module->sql_uninstall = $this->placeholder->update_(
						$this->customcode->update(
							base64_decode((string) $module->sql_uninstall)
						)
					);
				}
				else
				{
					unset($module->sql_uninstall);
					$module->add_sql_uninstall = 0;
				}

				// update the URL of the update_server if set
				if ($module->add_update_server == 1
					&& StringHelper::check(
						$module->update_server_url
					))
				{
					$module->update_server_url = $this->placeholder->update_(
						$this->customcode->update($module->update_server_url)
					);
				}

				// add the update/sales server FTP details if that is the expected protocol
				$serverArray = array('update_server', 'sales_server');
				foreach ($serverArray as $server)
				{
					if ($module->{'add_' . $server} == 1
						&& is_numeric(
							$module->{$server}
						)
						&& $module->{$server} > 0)
					{
						// get the server protocol
						$module->{$server . '_protocol'}
							= GetHelper::var(
							'server', (int) $module->{$server}, 'id', 'protocol'
						);
					}
					else
					{
						$module->{$server} = 0;
						// only change this for sales server (update server can be added loacaly to the zip file)
						if ('sales_server' === $server)
						{
							$module->{'add_' . $server} = 0;
						}
						$module->{$server . '_protocol'} = 0;
					}
				}

				// set the update server stuff (TODO)
				// update_server_xml_path
				// update_server_xml_file_name

				// rest globals
				$this->config->build_target = $_backup_target;
				$this->config->lang_target = $_backup_lang;
				$this->config->lang_prefix = $_backup_langPrefix;

				$this->placeholder->remove('Module_name');
				$this->placeholder->remove('Module');
				$this->placeholder->remove('module');
				$this->placeholder->remove('module.version');
				$this->placeholder->remove('module_version');

				$this->data[$id] = $module;

				return true;
			}
		}

		return false;
	}

}

