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


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Joomlaplugin\Data as Plugin;
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
 * Joomla Plugin Builder Class
 * 
 * @since 3.2.0
 */
class Builder
{
	/**
	 * Compiler Joomla Plugin Data Class
	 *
	 * @var    Plugin
	 * @since 3.2.0
	 */
	protected Plugin $plugin;

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
	 * @param Plugin|null            $plugin       The compiler Joomla plugin data object.
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
	public function __construct(?Plugin $plugin = null, ?Component $component = null,
		?Config $config = null, ?Registry $registry = null,
		?Dispenser $dispenser = null, ?EventInterface $event = null,
		?Counter $counter = null, ?Folder $folder = null,
		?File $file = null, ?Files $files = null)
	{
		$this->plugin = $plugin ?: Compiler::_('Joomlaplugin.Data');
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
	 * Build the Plugins files, folders, url's and config
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function run()
	{
		if ($this->plugin->exists())
		{
			// for plugin event TODO change event api signatures
			$component_context = $this->config->component_context;
			$plugins = $this->plugin->get();
			// Trigger Event: jcb_ce_onBeforeSetPlugins
			$this->event->trigger(
				'jcb_ce_onBeforeBuildPlugins',
				array(&$component_context, &$plugins)
			);
			foreach ($plugins as $plugin)
			{
				if (ObjectHelper::check($plugin)
					&& isset($plugin->folder_name)
					&& StringHelper::check(
						$plugin->folder_name
					))
				{
					// plugin path
					$plugin->folder_path = $this->config->get('compiler_path', JPATH_COMPONENT_ADMINISTRATOR . '/compiler') . '/'
						. $plugin->folder_name;

					// set the plugin paths
					$this->registry->set('dynamic_paths.' . $plugin->key, $plugin->folder_path);

					// make sure there is no old build
					$this->folder->remove($plugin->folder_path);

					// creat the main component folder
					$this->folder->create($plugin->folder_path);

					// set main class file
					$fileDetails = array('path' => $plugin->folder_path . '/'
						. $plugin->file_name . '.php',
					                     'name' => $plugin->file_name . '.php',
					                     'zip'  => $plugin->file_name . '.php');
					$this->file->write(
						$fileDetails['path'],
						'<?php' . PHP_EOL . '// Plugin main class template' .
						PHP_EOL . Placefix::_h('BOM') . PHP_EOL .
						PHP_EOL . '// No direct access to this file' . PHP_EOL .
						"defined('_JEXEC') or die('Restricted access');"
						. PHP_EOL .
						Placefix::_h('MAINCLASS')
					);
					$this->files->appendArray($plugin->key, $fileDetails);

					// count the file created
					$this->counter->file++;

					// set main xml file
					$fileDetails = array('path' => $plugin->folder_path . '/'
						. $plugin->file_name . '.xml',
					                     'name' => $plugin->file_name . '.xml',
					                     'zip'  => $plugin->file_name . '.xml');
					$this->file->write(
						$fileDetails['path'],
						$this->getXML($plugin)
					);
					$this->files->appendArray($plugin->key, $fileDetails);

					// count the file created
					$this->counter->file++;

					// set install script if needed
					if ($plugin->add_install_script)
					{
						$fileDetails = array('path' => $plugin->folder_path
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
						$this->files->appendArray($plugin->key, $fileDetails);

						// count the file created
						$this->counter->file++;
					}

					// set readme if found
					if ($plugin->addreadme)
					{
						$fileDetails = array('path' => $plugin->folder_path
							. '/README.md',
						                     'name' => 'README.md',
						                     'zip'  => 'README.md');
						$this->file->write($fileDetails['path'], $plugin->readme);
						$this->files->appendArray($plugin->key, $fileDetails);

						// count the file created
						$this->counter->file++;
					}

					// set fields & rules folders if needed
					if (isset($plugin->fields_rules_paths)
						&& $plugin->fields_rules_paths == 2)
					{
						// create fields folder
						$this->folder->create($plugin->folder_path . '/fields');

						// create rules folder
						$this->folder->create($plugin->folder_path . '/rules');
					}

					// set forms folder if needed
					if (isset($plugin->form_files)
						&& ArrayHelper::check(
							$plugin->form_files
						))
					{
						// create forms folder
						$this->folder->create($plugin->folder_path . '/forms');

						// set the template files
						foreach ($plugin->form_files as $file => $fields)
						{
							// set file details
							$fileDetails = array('path' => $plugin->folder_path
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
												$plugin->fieldsets_paths[$file
												. $field_name . $fieldset]
											)
											&& $plugin->fieldsets_paths[$file
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
									if (isset($plugin->fieldsets_label[$file . $field_name . $fieldset]))
									{
										$label = $plugin->fieldsets_label[$file . $field_name . $fieldset];
									}

									// add path to plugin rules and custom fields
									if (isset($plugin->fieldsets_paths[$file . $field_name . $fieldset])
										&& ($plugin->fieldsets_paths[$file . $field_name . $fieldset] == 2
											|| $plugin->fieldsets_paths[$file . $field_name . $fieldset] == 3))
									{
										if (!isset($plugin->add_rule_path[$file . $field_name . $fieldset]))
										{
											$plugin->add_rule_path[$file . $field_name . $fieldset] =
												'/plugins/' . strtolower((string) $plugin->group
												) . '/' . strtolower((string) $plugin->code_name)
												. '/rules';
										}

										if (!isset($plugin->add_field_path[$file . $field_name . $fieldset]))
										{
											$plugin->add_field_path[$file . $field_name . $fieldset] =
												'/plugins/' . strtolower((string) $plugin->group
												) . '/' . strtolower((string) $plugin->code_name)
												. '/fields';
										}
									}

									// add path to plugin rules and custom fields
									if (isset($plugin->add_rule_path[$file . $field_name . $fieldset])
										|| isset($plugin->add_field_path[$file . $field_name . $fieldset]))
									{
										$xml .= PHP_EOL . Indent::_(1) . '<!--'
											. Line::_(__Line__, __Class__) . ' default paths of '
											. $fieldset . ' fieldset points to the plugin -->';

										$xml .= PHP_EOL . Indent::_(1) . '<fieldset name="'
											. $fieldset . '" label="' . $label . '"';

										if (isset($plugin->add_rule_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . Indent::_(2)
												. 'addrulepath="' . $plugin->add_rule_path[$file . $field_name . $fieldset] . '"';
										}

										if (isset($plugin->add_field_path[$file . $field_name . $fieldset]))
										{
											$xml .= PHP_EOL . Indent::_(2)
												. 'addfieldpath="' . $plugin->add_field_path[$file . $field_name . $fieldset] . '"';
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
							$this->files->appendArray($plugin->key, $fileDetails);

							// count the file created
							$this->counter->file++;
						}
					}

					// set SQL stuff if needed
					if ($plugin->add_sql || $plugin->add_sql_uninstall)
					{
						// create SQL folder
						$this->folder->create($plugin->folder_path . '/sql');

						// create mysql folder
						$this->folder->create(
							$plugin->folder_path . '/sql/mysql'
						);

						// now set the install file
						if ($plugin->add_sql)
						{
							$this->file->write(
								$plugin->folder_path . '/sql/mysql/install.sql',
								$plugin->sql
							);

							// count the file created
							$this->counter->file++;
						}

						// now set the uninstall file
						if ($plugin->add_sql_uninstall)
						{
							$this->file->write(
								$plugin->folder_path
								. '/sql/mysql/uninstall.sql',
								$plugin->sql_uninstall
							);

							// count the file created
							$this->counter->file++;
						}
					}

					// creat the language folder path
					$this->folder->create($plugin->folder_path . '/language');

					// also creat the lang tag folder path
					$this->folder->create(
						$plugin->folder_path . '/language/' . $this->config->get('lang_tag', 'en-GB')
					);

					// check if this lib has files
					if (isset($plugin->files)
						&& ArrayHelper::check($plugin->files))
					{
						// add to component files
						foreach ($plugin->files as $file)
						{
							// set the path finder
							$file['target_type']          = $plugin->target_type;
							$file['target_id']            = $plugin->id;
							$this->component->appendArray('files', $file);
						}
					}

					// check if this lib has folders
					if (isset($plugin->folders)
						&& ArrayHelper::check($plugin->folders))
					{
						// add to component folders
						foreach ($plugin->folders as $folder)
						{
							// set the path finder
							$folder['target_type']          = $plugin->target_type;
							$folder['target_id']            = $plugin->id;
							$this->component->appendArray('folders', $folder);
						}
					}

					// check if this plugin has urls
					if (isset($plugin->urls)
						&& ArrayHelper::check($plugin->urls))
					{
						// add to component urls
						foreach ($plugin->urls as $n => &$url)
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

								// create sub media media folder path if not set
								$this->folder->create(
									$plugin->folder_path . $path
								);

								// set the path to plugin file
								$url['path'] = $plugin->folder_path . $path
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
	 * get the plugin xml template
	 *
	 * @param   object   $module    The plugin object
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function getXML(object &$plugin): string
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= PHP_EOL . '<extension type="plugin" version="'
			. $this->config->joomla_versions[$this->config->joomla_version]['xml_version'] . '" group="'
			. strtolower((string) $plugin->group) . '" method="upgrade">';
		$xml .= PHP_EOL . Indent::_(1) . '<name>' . $plugin->lang_prefix
			. '</name>';
		$xml .= PHP_EOL . Indent::_(1) . '<creationDate>' . Placefix::_h('BUILDDATE') . '</creationDate>';
		$xml .= PHP_EOL . Indent::_(1) . '<author>' . Placefix::_h('AUTHOR') . '</author>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorEmail>' . Placefix::_h('AUTHOREMAIL') . '</authorEmail>';
		$xml .= PHP_EOL . Indent::_(1) . '<authorUrl>' . Placefix::_h('AUTHORWEBSITE') . '</authorUrl>';
		$xml .= PHP_EOL . Indent::_(1) . '<copyright>' . Placefix::_h('COPYRIGHT') . '</copyright>';
		$xml .= PHP_EOL . Indent::_(1) . '<license>' . Placefix::_h('LICENSE') . '</license>';
		$xml .= PHP_EOL . Indent::_(1) . '<version>' . $plugin->plugin_version
			. '</version>';
		$xml .= PHP_EOL . Indent::_(1) . '<description>' . $plugin->lang_prefix
			. '_XML_DESCRIPTION</description>';
		$xml .= Placefix::_h('MAINXML');
		$xml .= PHP_EOL . '</extension>';

		return $xml;
	}

}

