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


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Joomlamodule\Data as Module;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Folder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\FileHelper;


/**
 * Joomla Module Builder Class
 * 
 * @since 3.2.0
 */
class Builder
{
	/**
	 * Compiler Joomla Module Data Class
	 *
	 * @var    Module
	 * @since 3.2.0
	 */
	protected Module $module;

	/**
	 * Compiler Component
	 *
	 * @var    Component
	 * @since 3.2.0
	 **/
	protected Component $component;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Customcode Dispenser
	 *
	 * @var    Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * Compiler Event
	 *
	 * @var    EventInterface
	 * @since 3.2.0
	 */
	protected EventInterface $event;

	/**
	 * Compiler Counter
	 *
	 * @var    Counter
	 * @since 3.2.0
	 */
	protected Counter $counter;

	/**
	 * Compiler Utilities Folder
	 *
	 * @var    Folder
	 * @since 3.2.0
	 */
	protected Folder $folder;

	/**
	 * Compiler Utilities File
	 *
	 * @var    File
	 * @since 3.2.0
	 */
	protected File $file;

	/**
	 * Compiler Utilities Files
	 *
	 * @var    Files
	 * @since 3.2.0
	 */
	protected Files $files;

	/**
	 * Constructor
	 *
	 * @param Module|null            $module       The compiler Joomla module data object.
	 * @param Component|null         $component    The component class.
	 * @param Config|null            $config       The compiler config object.
	 * @param Registry|null          $registry     The compiler registry object.
	 * @param Dispenser|null         $dispenser    The compiler customcode dispenser object.
	 * @param EventInterface|null    $event        The compiler event api object.
	 * @param Counter|null           $counter      The compiler counter object.
	 * @param Folder|null            $folder       The compiler folder object.
	 * @param File|null              $file         The compiler file object.
	 * @param Files|null             $files        The compiler files object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Module $module = null, ?Component $component = null,
		?Config $config = null, ?Registry $registry = null,
		?Dispenser $dispenser = null, ?EventInterface $event = null,
		?Counter $counter = null, ?Folder $folder = null,
		?File $file = null, ?Files $files = null)
	{
		$this->module = $module ?: Compiler::_('Joomlamodule.Data');
		$this->component = $component ?: Compiler::_('Component');
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->dispenser = $dispenser ?: Compiler::_('Customcode.Dispenser');
		$this->event = $event ?: Compiler::_('Event');
		$this->counter = $counter ?? Compiler::_('Utilities.Counter');
		$this->folder = $folder ?? Compiler::_('Utilities.Folder');
		$this->file = $file ?? Compiler::_('Utilities.File');
		$this->files = $files ?? Compiler::_('Utilities.Files');
	}

	/**
	 * Build the Modules files, folders, url's and config
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function run()
	{
		if ($this->module->exists())
		{
			// for plugin event TODO change event api signatures
			$component_context = $this->config->component_context;
			$modules = $this->module->get();
			// Trigger Event: jcb_ce_onBeforeSetModules
			$this->event->trigger(
				'jcb_ce_onBeforeBuildModules',
				array(&$component_context, &$modules)
			);

			foreach ($modules as $module)
			{
				if (ObjectHelper::check($module)
					&& isset($module->folder_name)
					&& StringHelper::check(
						$module->folder_name
					))
				{
					// module path
					$module->folder_path = $this->config->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler') . '/'
						. $module->folder_name;

					// set the module paths
					$this->registry->set('dynamic_paths.' . $module->key, $module->folder_path);

					// make sure there is no old build
					$this->folder->remove($module->folder_path);

					// creat the main module folder
					$this->folder->create($module->folder_path);

					// set main mod file
					$fileDetails = array('path' => $module->folder_path . '/'
						. $module->file_name . '.php',
					                     'name' => $module->file_name . '.php',
					                     'zip'  => $module->file_name . '.php');
					$this->file->write(
						$fileDetails['path'],
						'<?php' . PHP_EOL . '// main modfile' .
						PHP_EOL . Placefix::_h('BOM') . PHP_EOL .
						PHP_EOL . '// No direct access to this file' . PHP_EOL .
						"defined('_JEXEC') or die('Restricted access');"
						. PHP_EOL .
						Placefix::_h('MODCODE')
					);
					$this->files->appendArray($module->key, $fileDetails);

					// count the file created
					$this->counter->file++;

					// set custom_get
					if ($module->custom_get)
					{
						$fileDetails = array(
							'path' => $module->folder_path . '/data.php',
							'name' => 'data.php',
							'zip'  => 'data.php'
						);
						$this->file->write(
							$fileDetails['path'],
							'<?php' . PHP_EOL . '// get data file' .
							PHP_EOL . Placefix::_h('BOM') . PHP_EOL
							.
							PHP_EOL . '// No direct access to this file'
							. PHP_EOL .
							"defined('_JEXEC') or die('Restricted access');"
							. PHP_EOL . PHP_EOL .
							'/**' . PHP_EOL .
							' * Module ' . $module->official_name . ' Data'
							. PHP_EOL .
							' */' . PHP_EOL .
							"class " . $module->class_data_name
							. ' extends \JObject' . PHP_EOL .
							"{" . Placefix::_h('DYNAMICGETS') . "}"
							. PHP_EOL
						);
						$this->files->appendArray($module->key, $fileDetails);

						// count the file created
						$this->counter->file++;
					}

					// set helper file
					if ($module->add_class_helper >= 1)
					{
						$fileDetails = array('path' => $module->folder_path
							. '/helper.php',
						                     'name' => 'helper.php',
						                     'zip'  => 'helper.php');
						$this->file->write(
							$fileDetails['path'],
							'<?php' . PHP_EOL . '// helper file' .
							PHP_EOL . Placefix::_h('BOM') . PHP_EOL
							.
							PHP_EOL . '// No direct access to this file'
							. PHP_EOL .
							"defined('_JEXEC') or die('Restricted access');"
							. PHP_EOL .
							Placefix::_h('HELPERCODE')
						);
						$this->files->appendArray($module->key, $fileDetails);

						// count the file created
						$this->counter->file++;
					}

					// set main xml file
					$fileDetails = array('path' => $module->folder_path . '/'
						. $module->file_name . '.xml',
					                     'name' => $module->file_name . '.xml',
					                     'zip'  => $module->file_name . '.xml');
					$this->file->write(
						$fileDetails['path'],
						$this->getXML($module)
					);
					$this->files->appendArray($module->key, $fileDetails);

					// count the file created
					$this->counter->file++;

					// set tmpl folder
					$this->folder->create($module->folder_path . '/tmpl');

					// set default file
					$fileDetails = array('path' => $module->folder_path
						. '/tmpl/default.php',
					                     'name' => 'default.php',
					                     'zip'  => 'tmpl/default.php');
					$this->file->write(
						$fileDetails['path'],
						'<?php' . PHP_EOL . '// default tmpl' .
						PHP_EOL . Placefix::_h('BOM') . PHP_EOL .
						PHP_EOL . '// No direct access to this file' . PHP_EOL .
						"defined('_JEXEC') or die('Restricted access');"
						. PHP_EOL .
						Placefix::_h('MODDEFAULT')
					);
					$this->files->appendArray($module->key, $fileDetails);

					// count the file created
					$this->counter->file++;

					// set install script if needed
					if ($module->add_install_script)
					{
						$fileDetails = array('path' => $module->folder_path
							. '/script.php',
						                     'name' => 'script.php',
						                     'zip'  => 'script.php');
						$this->file->write(
							$fileDetails['path'],
							'<?php' . PHP_EOL . '// Script template' .
							PHP_EOL . Placefix::_h('BOM') . PHP_EOL
							.
							PHP_EOL . '// No direct access to this file'
							. PHP_EOL .
							"defined('_JEXEC') or die('Restricted access');"
							. PHP_EOL .
							Placefix::_h('INSTALLCLASS')
						);
						$this->files->appendArray($module->key, $fileDetails);

						// count the file created
						$this->counter->file++;
					}

					// set readme if found
					if ($module->addreadme)
					{
						$fileDetails = array('path' => $module->folder_path
							. '/README.md',
						                     'name' => 'README.md',
						                     'zip'  => 'README.md');
						$this->file->write($fileDetails['path'], $module->readme);
						$this->files->appendArray($module->key, $fileDetails);

						// count the file created
						$this->counter->file++;
					}

					// set the folders target path
					$target_path = '';
					if ($module->target_client === 'administrator')
					{
						$target_path = '/administrator';
					}

					// check if we have custom fields needed for scripts
					$module->add_scripts_field = false;
					$field_script_bucket       = [];

					// add any css from the fields
					if (($css = $this->dispenser->get(
							'css_view', $module->key
						)) !== null
						&& StringHelper::check($css))
					{
						// make sure this script does not have PHP
						if (strpos((string) $css, '<?php') === false)
						{
							// make sure the field is added
							$module->add_scripts_field = true;

							// create the css folder
							$this->folder->create($module->folder_path . '/css');

							// add the CSS file
							$fileDetails = array('path' => $module->folder_path
								. '/css/mod_admin.css',
							                     'name' => 'mod_admin.css',
							                     'zip'  => 'mod_admin.css');
							$this->file->write(
								$fileDetails['path'],
								Placefix::_h('BOM') . PHP_EOL
								. PHP_EOL . $css
							);
							$this->files->appendArray($module->key, $fileDetails);

							// count the file created
							$this->counter->file++;

							// add the field script
							$field_script_bucket[] = Indent::_(2) . "//"
								. Line::_(__Line__, __Class__) . " Custom CSS";
							$field_script_bucket[] = Indent::_(2)
								. "\$document->addStyleSheet('" . $target_path
								. "/modules/" . $module->folder_name
								. "/css/mod_admin.css', ['version' => 'auto', 'relative' => true]);";
						}
					}

					// add any JavaScript from the fields
					if (($javascript = $this->dispenser->get(
							'view_footer', $module->key
						)) !== null
						&& StringHelper::check($javascript))
					{
						// make sure this script does not have PHP
						if (strpos((string) $javascript, '<?php') === false)
						{
							// make sure the field is added
							$module->add_scripts_field = true;

							// add the JavaScript file
							$this->folder->create($module->folder_path . '/js');

							// add the CSS file
							$fileDetails = array('path' => $module->folder_path
								. '/js/mod_admin.js',
							                     'name' => 'mod_admin.js',
							                     'zip'  => 'mod_admin.js');
							$this->file->write(
								$fileDetails['path'],
								Placefix::_h('BOM') . PHP_EOL
								. PHP_EOL . $javascript
							);
							$this->files->appendArray($module->key, $fileDetails);

							// count the file created
							$this->counter->file++;

							// add the field script
							$field_script_bucket[] = Indent::_(2) . "//"
								. Line::_(__Line__, __Class__) . " Custom JS";
							$field_script_bucket[] = Indent::_(2)
								. "\$document->addScript('" . $target_path
								. "/modules/" . $module->folder_name
								. "/js/mod_admin.js', ['version' => 'auto', 'relative' => true]);";
						}
					}

					// set fields folders if needed
					if ($module->add_scripts_field
						|| (isset($module->fields_rules_paths)
							&& $module->fields_rules_paths == 2))
					{
						// create fields folder
						$this->folder->create($module->folder_path . '/fields');

						// add the custom script field
						if ($module->add_scripts_field)
						{
							$fileDetails = [
								'path' => $module->folder_path
								. '/fields/modadminvvvvvvvdm.php',
								'name' => 'modadminvvvvvvvdm.php',
								'zip'  => 'modadminvvvvvvvdm.php'
							];
							$this->file->write(
								$fileDetails['path'],
								$this->getCustomScriptField(
									$field_script_bucket
								)
							);
							$this->files->appendArray($module->key, $fileDetails);

							// count the file created
							$this->counter->file++;
						}
					}

					// set rules folders if needed
					if (isset($module->fields_rules_paths)
						&& $module->fields_rules_paths == 2)
					{
						// create rules folder
						$this->folder->create($module->folder_path . '/rules');
					}

					// set forms folder if needed
					if (isset($module->form_files)
						&& ArrayHelper::check(
							$module->form_files
						))
					{
						// create forms folder
						$this->folder->create($module->folder_path . '/forms');

						// set the template files
						foreach ($module->form_files as $file => $fields)
						{
							// set file details
							$fileDetails = array('path' => $module->folder_path
								. '/forms/' . $file . '.xml',
							                     'name' => $file . '.xml',
							                     'zip'  => 'forms/' . $file
								                     . '.xml');

							// build basic XML
							$xml = '<?xml version="1.0" encoding="utf-8"?>';
							$xml .= PHP_EOL . '<!--' . Line::_(__Line__, __Class__)
								. ' default paths of ' . $file
								. ' form points to ' . $this->config->component_code_name
								. ' -->';

							// search if we must add the component path
							$add_component_path = false;
							foreach ($fields as $field_name => $fieldsets)
							{
								if (!$add_component_path)
								{
									foreach ($fieldsets as $fieldset => $field)
									{
										if (!$add_component_path
											&& isset(
												$module->fieldsets_paths[$file
												. $field_name . $fieldset]
											)
											&& $module->fieldsets_paths[$file
											. $field_name . $fieldset] == 1)
										{
											$add_component_path = true;
										}
									}
								}
							}

							// only add if part of the component field types path is required
							if ($add_component_path)
							{
								$xml .= PHP_EOL . '<form';
								$xml .= PHP_EOL . Indent::_(1)
									. 'addrulepath="/administrator/components/com_'
									. $this->config->component_code_name
									. '/models/rules"';
								$xml .= PHP_EOL . Indent::_(1)
									. 'addfieldpath="/administrator/components/com_'
									. $this->config->component_code_name
									. '/models/fields"';
								$xml .= PHP_EOL . '>';
							}
							else
							{
								$xml .= PHP_EOL . '<form>';
							}

							// add the fields
							foreach ($fields as $field_name => $fieldsets)
							{
								// check if we have an double fields naming set
								$field_name_inner = '';
								$field_name_outer = $field_name;
								if (strpos((string) $field_name, '.') !== false)
								{
									$field_names = explode('.', (string) $field_name);
									if (count((array) $field_names) == 2)
									{
										$field_name_outer = $field_names[0];
										$field_name_inner = $field_names[1];
									}
								}
								$xml .= PHP_EOL . Indent::_(1)
									. '<fields name="' . $field_name_outer
									. '">';
								foreach ($fieldsets as $fieldset => $field)
								{
									// default to the field set name
									$label = $fieldset;
									if (isset($module->fieldsets_label[$file . $field_name . $fieldset]))
									{
										$label = $module->fieldsets_label[$file . $field_name . $fieldset];
									}

									// add path to module rules and custom fields
									if (isset($module->fieldsets_paths[$file . $field_name . $fieldset])
										&& ($module->fieldsets_paths[$file . $field_name . $fieldset] == 2
											|| $module->fieldsets_paths[$file . $field_name . $fieldset] == 3))
									{
										if ($module->target == 2)
										{
											if (!isset($module->add_rule_path[$file . $field_name . $fieldset]))
											{
												$module->add_rule_path[$file . $field_name . $fieldset] =
													'/administrator/modules/'
													. $module->file_name . '/rules';
											}

											if (!isset($module->add_field_path[$file . $field_name . $fieldset]))
											{
												$module->add_field_path[$file . $field_name . $fieldset] =
													'/administrator/modules/'
													. $module->file_name . '/fields';
											}
										}
										else
										{
											if (!isset($module->add_rule_path[$file . $field_name . $fieldset]))
											{
												$module->add_rule_path[$file . $field_name . $fieldset] =
													'/modules/' . $module->file_name
													. '/rules';
											}

											if (!isset($module->add_field_path[$file . $field_name . $fieldset]))
											{
												$module->add_field_path[$file . $field_name . $fieldset] =
													'/modules/' . $module->file_name
													. '/fields';
											}
										}
									}

									// add path to module rules and custom fields
									if (isset($module->add_rule_path[$file . $field_name . $fieldset])
										|| isset($module->add_field_path[$file . $field_name . $fieldset]))
									{

										$xml .= PHP_EOL . Indent::_(1) . '<!--'
											. Line::_(__Line__, __Class__) . ' default paths of '
											. $fieldset . ' fieldset points to the module -->';

										$xml .= PHP_EOL . Indent::_(1) . '<fieldset name="'
											. $fieldset . '" label="' . $label . '"';

										if (isset($module->add_rule_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . Indent::_(2)
												. 'addrulepath="' . $module->add_rule_path[$file . $field_name . $fieldset] . '"';
										}

										if (isset($module->add_field_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . Indent::_(2)
												. 'addfieldpath="' . $module->add_field_path[$file . $field_name . $fieldset] . '"';
										}

										$xml .= PHP_EOL . Indent::_(1) . '>';
									}
									else
									{
										$xml .= PHP_EOL . Indent::_(1) . '<fieldset name="'
											. $fieldset . '" label="' . $label . '">';
									}

									// check if we have an inner field set
									if (StringHelper::check(
										$field_name_inner
									))
									{
										$xml .= PHP_EOL . Indent::_(1)
											. '<fields name="'
											. $field_name_inner . '">';
									}

									// add the placeholder of the fields
									$xml .= Placefix::_h('FIELDSET_' . $file
										. $field_name . $fieldset );

									// check if we have an inner field set
									if (StringHelper::check(
										$field_name_inner
									))
									{
										$xml .= PHP_EOL . Indent::_(1)
											. '</fields>';
									}
									$xml .= PHP_EOL . Indent::_(1)
										. '</fieldset>';
								}
								$xml .= PHP_EOL . Indent::_(1) . '</fields>';
							}
							$xml .= PHP_EOL . '</form>';

							// add xml to file
							$this->file->write($fileDetails['path'], $xml);
							$this->files->appendArray($module->key, $fileDetails);

							// count the file created
							$this->counter->file++;
						}
					}

					// set SQL stuff if needed
					if ($module->add_sql || $module->add_sql_uninstall)
					{
						// create SQL folder
						$this->folder->create($module->folder_path . '/sql');

						// create mysql folder
						$this->folder->create(
							$module->folder_path . '/sql/mysql'
						);

						// now set the install file
						if ($module->add_sql)
						{
							$this->file->write(
								$module->folder_path . '/sql/mysql/install.sql',
								$module->sql
							);

							// count the file created
							$this->counter->file++;
						}

						// now set the uninstall file
						if ($module->add_sql_uninstall)
						{
							$this->file->write(
								$module->folder_path
								. '/sql/mysql/uninstall.sql',
								$module->sql_uninstall
							);

							// count the file created
							$this->counter->file++;
						}
					}

					// creat the language folder
					$this->folder->create($module->folder_path . '/language');
					// also create the lang tag folder
					$this->folder->create(
						$module->folder_path . '/language/' . $this->config->get('lang_tag', 'en-GB')
					);

					// check if this lib has files
					if (isset($module->files)
						&& ArrayHelper::check($module->files))
					{
						// add to component files
						foreach ($module->files as $file)
						{
							// set the pathfinder
							$file['target_type']          = $module->target_type;
							$file['target_id']            = $module->id;
							$this->component->appendArray('files', $file);
						}
					}

					// check if this lib has folders
					if (isset($module->folders)
						&& ArrayHelper::check($module->folders))
					{
						// add to component folders
						foreach ($module->folders as $folder)
						{
							// set the pathfinder
							$folder['target_type']          = $module->target_type;
							$folder['target_id']            = $module->id;
							$this->component->appendArray('folders', $folder);
						}
					}

					// check if this module has urls
					if (isset($module->urls)
						&& ArrayHelper::check($module->urls))
					{
						// add to component urls
						foreach ($module->urls as $n => &$url)
						{
							// should we add the local folder
							if (isset($url['type']) && $url['type'] > 1
								&& isset($url['url'])
								&& StringHelper::check(
									$url['url']
								))
							{
								// set file name
								$fileName = basename((string) $url['url']);

								// get the file contents
								$data = FileHelper::getContent(
									$url['url']
								);

								// build sub path
								if (strpos($fileName, '.js') !== false)
								{
									$path = '/js';
								}
								elseif (strpos($fileName, '.css') !== false)
								{
									$path = '/css';
								}
								else
								{
									$path = '';
								}

								// create sub media path if not set
								$this->folder->create(
									$module->folder_path . $path
								);

								// set the path to module file
								$url['path'] = $module->folder_path . $path
									. '/' . $fileName; // we need this for later

								// write data to path
								$this->file->write($url['path'], $data);

								// count the file created
								$this->counter->file++;
							}
						}
					}
				}
			}
		}
	}

	/**
	 * get the module xml template
	 *
	 * @param   object   $module    The module object
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function getXML(object &$module): string
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= PHP_EOL . '<extension type="module" version="'
			. $this->config->joomla_versions[$this->config->joomla_version]['xml_version'] . '" client="'
			. $module->target_client . '" method="upgrade">';
		$xml .= PHP_EOL . Indent::_(1) . '<name>' . $module->lang_prefix
			. '</name>';
		$xml .= PHP_EOL . Indent::_(1) . '<creationDate>' . Placefix::_h('BUILDDATE') . '</creationDate>';
		$xml .= PHP_EOL . Indent::_(1) . '<author>' . Placefix::_h('AUTHOR') . '</author>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorEmail>' . Placefix::_h('AUTHOREMAIL') . '</authorEmail>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorUrl>' . Placefix::_h('AUTHORWEBSITE') . '</authorUrl>';
		$xml .= PHP_EOL . Indent::_(1) . '<copyright>' . Placefix::_h('COPYRIGHT') . '</copyright>';
		$xml .= PHP_EOL . Indent::_(1) . '<license>' . Placefix::_h('LICENSE') . '</license>';
		$xml .= PHP_EOL . Indent::_(1) . '<version>' . $module->module_version
			. '</version>';
		$xml .= PHP_EOL . Indent::_(1) . '<description>' . $module->lang_prefix
			. '_XML_DESCRIPTION</description>';
		$xml .= Placefix::_h('MAINXML');
		$xml .= PHP_EOL . '</extension>';

		return $xml;
	}

	/**
	 * get the module admin custom script field
	 *
	 * @param   array   $fieldScriptBucket    The field
	 *
	 * @return  string
	 * @since 3.2.0
	 *
	 */
	protected function getCustomScriptField(array $fieldScriptBucket): string
	{
		$form_field_class   = [];
		$form_field_class[] = Placefix::_h('BOM') . PHP_EOL;
		$form_field_class[] = "//" . Line::_(__Line__, __Class__)
			. " No direct access to this file";
		$form_field_class[] = "defined('_JEXEC') or die('Restricted access');";
		$form_field_class[] = PHP_EOL . "use Joomla\CMS\Form\FormField;";
		$form_field_class[] = "use Joomla\CMS\Factory;";
		$form_field_class[] = PHP_EOL
			. "class JFormFieldModadminvvvvvvvdm extends FormField";
		$form_field_class[] = "{";
		$form_field_class[] = Indent::_(1)
			. "protected \$type = 'modadminvvvvvvvdm';";
		$form_field_class[] = PHP_EOL . Indent::_(1)
			. "protected function getLabel()";
		$form_field_class[] = Indent::_(1) . "{";
		$form_field_class[] = Indent::_(2) . "return;";
		$form_field_class[] = Indent::_(1) . "}";
		$form_field_class[] = PHP_EOL . Indent::_(1)
			. "protected function getInput()";
		$form_field_class[] = Indent::_(1) . "{";
		$form_field_class[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
			. " Get the document";
		$form_field_class[] = Indent::_(2)
			. "\$document = Factory::getDocument();";
		$form_field_class[] = implode(PHP_EOL, $fieldScriptBucket);
		$form_field_class[] = Indent::_(2) . "return; // noting for now :)";
		$form_field_class[] = Indent::_(1) . "}";
		$form_field_class[] = "}";

		return implode(PHP_EOL, $form_field_class);
	}

}

