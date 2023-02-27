<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\MathHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;

// Use the component builder autoloader
ComponentbuilderHelper::autoLoader();

/**
 * Compiler class
 * @deprecated 3.3
 */
class Compiler extends Infusion
{

	/**
	 * The Temp path
	 *
	 * @var      string
	 */
	public $tempPath;

	/**
	 * The timer
	 *
	 * @var      string
	 */
	private $time_start;
	private $time_end;
	public $secondsCompiled;

	/**
	 * The file path array
	 *
	 * @var      string
	 */
	public $filepath
		= array(
			'component'        => '',
			'component-folder' => '',
			'package'          => '',
			'plugins'          => array(),
			'plugins-folders'  => array(),
			'modules'          => array()
		);

	// fixed pathes
	protected $dynamicIntegration = false;
	protected $backupPath = false;
	protected $repoPath = false;
	protected $addCustomCodeAt = array();

	/**
	 * Constructor
	 */
	public function __construct($config = array())
	{
		// to check the compiler speed
		$this->time_start = microtime(true);
		CFactory::_('Utilities.Counter')->start();
		// first we run the parent constructors
		if (parent::__construct())
		{
			// set temp directory
			$comConfig      = JFactory::getConfig();
			$this->tempPath = $comConfig->get('tmp_path');
			// set some folder paths in relation to distribution
			if (CFactory::_('Config')->backup)
			{
				$this->backupPath         = $this->params->get(
					'backup_folder_path', $this->tempPath
				);
				$this->dynamicIntegration = true;
			}
			// set local repos switch
			if (CFactory::_('Config')->repository)
			{
				$this->repoPath = $this->params->get('git_folder_path', null);
			}
			// remove site folder if not needed (TODO add check if custom script was moved to site folder then we must do a more complex cleanup here)
			if (CFactory::_('Config')->remove_site_folder && CFactory::_('Config')->remove_site_edit_folder)
			{
				// first remove the files and folders
				CFactory::_('Utilities.Folder')->remove(CFactory::_('Utilities.Paths')->component_path . '/site');
				// clear form component xml
				$xmlPath        = CFactory::_('Utilities.Paths')->component_path . '/'
					. CFactory::_('Content')->get('component') . '.xml';
				$componentXML   = FileHelper::getContent($xmlPath);
				$textToSite     = GetHelper::between(
					$componentXML, '<files folder="site">', '</files>'
				);
				$textToSiteLang = GetHelper::between(
					$componentXML, '<languages folder="site">', '</languages>'
				);
				$componentXML   = str_replace(
					array('<files folder="site">' . $textToSite . "</files>",
					      '<languages folder="site">' . $textToSiteLang
					      . "</languages>"), array('', ''), (string) $componentXML
				);
				CFactory::_('Utilities.File')->write($xmlPath, $componentXML);
			}
			// for plugin event TODO change event api signatures
			$component_context = CFactory::_('Config')->component_context;
			// Trigger Event: jcb_ce_onBeforeUpdateFiles
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeUpdateFiles',
				array(&$component_context, &$this)
			);
			// now update the files
			if (!$this->updateFiles())
			{
				return false;
			}
			// Trigger Event: jcb_ce_onBeforeGetCustomCode
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeGetCustomCode',
				array(&$component_context, &$this)
			);
			// now insert into the new files
			if (CFactory::_('Customcode')->get())
			{
				// Trigger Event: jcb_ce_onBeforeAddCustomCode
				CFactory::_('Event')->trigger(
					'jcb_ce_onBeforeAddCustomCode',
					array(&$component_context, &$this)
				);

				$this->addCustomCode();
			}
			// Trigger Event: jcb_ce_onBeforeSetLangFileData
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeSetLangFileData',
				array(&$component_context, &$this)
			);
			// set the lang data now
			$this->setLangFileData();
			// set the language notice if it was set
			if (ArrayHelper::check($this->langNot)
				|| ArrayHelper::check($this->langSet))
			{
				if (ArrayHelper::check($this->langNot))
				{
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Language Warning</h3>'), 'Warning'
					);
					foreach ($this->langNot as $tag => $percentage)
					{
						$this->app->enqueueMessage(
							JText::sprintf(
								'The <b>%s</b> language has %s&#37; translated, you will need to translate %s&#37; of the language strings before it will be added.',
								$tag, $percentage, $this->percentageLanguageAdd
							), 'Warning'
						);
					}
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Language Notice</h3>'), 'Notice'
					);
					$this->app->enqueueMessage(
						JText::sprintf(
							'<b>You can change this percentage of translated strings required in the global options of JCB.</b><br />Please watch this <a href=%s>tutorial for more help surrounding the JCB translations manager</a>.',
							'"https://youtu.be/zzAcVkn_cWU?list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank" title="JCB Tutorial surrounding Translation Manager"'
						), 'Notice'
					);
				}
				// set why the strings were added
				$whyAddedLang = JText::sprintf(
					'because more then %s&#37; of the strings have been translated.',
					$this->percentageLanguageAdd
				);
				if (CFactory::_('Config')->get('debug_line_nr', false))
				{
					$whyAddedLang = JText::_(
						'because the debugging mode is on. (debug line numbers)'
					);
				}
				// show languages that were added
				if (ArrayHelper::check($this->langSet))
				{
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Language Notice</h3>'), 'Notice'
					);
					foreach ($this->langSet as $tag => $percentage)
					{
						$this->app->enqueueMessage(
							JText::sprintf(
								'The <b>%s</b> language has %s&#37; translated. Was added %s',
								$tag, $percentage, $whyAddedLang
							), 'Notice'
						);
					}
				}
			}
			// set assets table column fix type messages
			$message_fix['intelligent'] = JText::_(
				'The <b>intelligent</b> fix only updates the #__assets table\'s column when it detects that it is too small for the worse case. The intelligent fix also only reverse the #__assets table\'s update on uninstall of the component if it detects that no other component needs the rules column to be larger any longer. This options also shows a notice to the end user of all that it does to the #__assets table on installation and uninstalling of the component.'
			);
			$message_fix['sql']         = JText::_(
				'The <b>SQL</b> fix updates the #__assets table\'s column size on installation of the component and reverses it back to the Joomla default on uninstall of the component.'
			);
			// get the asset table fix switch
			$add_assets_table_fix = CFactory::_('Config')->get('add_assets_table_fix', 0);
			// set assets table rules column notice
			if ($add_assets_table_fix)
			{
				$this->app->enqueueMessage(
					JText::_('<hr /><h3>Assets Table Notice</h3>'), 'Notice'
				);
				$asset_table_fix_type = ($add_assets_table_fix == 2)
					? 'intelligent' : 'sql';
				$this->app->enqueueMessage(
					JText::sprintf(
						'The #__assets table <b>%s</b> fix has been added to this component. %s',
						$asset_table_fix_type,
						$message_fix[$asset_table_fix_type]
					), 'Notice'
				);
			}
			// set assets table rules column Warning
			elseif ($this->accessSize >= 30)
			{
				$this->app->enqueueMessage(
					JText::_('<hr /><h3>Assets Table Warning</h3>'), 'Warning'
				);
				$this->app->enqueueMessage(
					JText::sprintf(
						'The Joomla #__assets table\'s rules column has to be fixed for this component to work coherently. JCB has detected that in worse case the rules column in the #__assets table may require <b>%s</b> characters, and yet the Joomla default is only <b>varchar(5120)</b>. JCB has three option to resolve this issue, first <b>use less permissions</b> in your component, second use the <b>SQL</b> fix, or the <b>intelligent</b> fix. %s %s',
						CFactory::_('Config')->access_worse_case, $message_fix['intelligent'],
						$message_fix['sql']
					), 'Warning'
				);
			}
			// set assets table name column warning if not set
			if (!$add_assets_table_fix && CFactory::_('Config')->add_assets_table_name_fix)
			{
				// only add if not already added
				if ($this->accessSize < 30)
				{
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Assets Table Warning</h3>'),
						'Warning'
					);
				}
				$this->app->enqueueMessage(
					JText::sprintf(
						'The Joomla #__assets table\'s name column has to be fixed for this component to work correctly. JCB has detected that the #__assets table name column will need to be enlarged because this component\'s own naming convention is larger than varchar(50) which is the Joomla default. JCB has three option to resolve this issue, first <b>shorter names</b> for your component and/or its admin views, second use the <b>SQL</b> fix, or the <b>intelligent</b> fix. %s %s',
						$message_fix['intelligent'],
						$message_fix['sql']
					), 'Warning'
				);
			}
			// move the update server into place
			$this->setUpdateServer();
			// build read me
			$this->buildReadMe();
			// set local repos
			$this->setLocalRepos();
			// zip the component
			if (!$this->zipComponent())
			{
				// done with error
				return false;
			}
			// if there are modules zip them
			$this->zipModules();
			// if there are plugins zip them
			$this->zipPlugins();
			// do lang mismatch check
			if (ArrayHelper::check(CFactory::_('Language.Extractor')->langMismatch))
			{
				if (ArrayHelper::check(CFactory::_('Language.Extractor')->langMatch))
				{
					$mismatch = array_diff(
						array_unique(CFactory::_('Language.Extractor')->langMismatch),
						array_unique(CFactory::_('Language.Extractor')->langMatch)
					);
				}
				else
				{
					$mismatch = array_unique(CFactory::_('Language.Extractor')->langMismatch);
				}
				// set a notice if we have a mismatch
				if (isset($mismatch)
					&& ArrayHelper::check(
						$mismatch
					))
				{
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Language Warning</h3>'), 'Warning'
					);
					if (count((array) $mismatch) > 1)
					{
						$this->app->enqueueMessage(
							JText::_(
								'<h3>Please check the following mismatching Joomla.JText language constants.</h3>'
							), 'Warning'
						);
					}
					else
					{
						$this->app->enqueueMessage(
							JText::_(
								'<h3>Please check the following mismatch Joomla.JText language constant.</h3>'
							), 'Warning'
						);
					}
					// add the mismatching issues
					foreach ($mismatch as $string)
					{
						$constant = CFactory::_('Config')->lang_prefix . '_'
							. StringHelper::safe($string, 'U');
						$this->app->enqueueMessage(
							JText::sprintf(
								'The <b>Joomla.JText._(&apos;%s&apos;)</b> language constant for <b>%s</b> does not have a corresponding <code>JText::script(&apos;%s&apos;)</code> decalaration, please add it.',
								$constant, $string, $string
							), 'Warning'
						);
					}
				}
			}
			// check if we should add a EXTERNALCODE notice
			if (ArrayHelper::check($this->externalCodeString))
			{
				// number of external code strings
				$externalCount = count($this->externalCodeString);
				// the correct string
				$externalCodeString = ($externalCount == 1) ? JText::_(
					'code/string'
				) : JText::_('code/strings');
				// the notice
				$this->app->enqueueMessage(
					JText::_('<hr /><h3>External Code Notice</h3>'), 'Notice'
				);
				$this->app->enqueueMessage(
					JText::sprintf(
						'There has been <b>%s - %s</b> added to this component as EXTERNALCODE. To avoid shipping your component with malicious %s always make sure that the correct <b>code/string values</b> were used.',
						$externalCount, $externalCodeString, $externalCodeString
					), 'Notice'
				);
			}
			// end the timer here
			$this->time_end        = microtime(true);
			$this->secondsCompiled = $this->time_end - $this->time_start;
			CFactory::_('Utilities.Counter')->end();

			// completed the compilation
			return true;
		}

		return false;
	}

	/**
	 * Set the dynamic data to the created fils
	 *
	 * @return  bool true on success
	 *
	 */
	protected function updateFiles()
	{
		if (CFactory::_('Utilities.Files')->exists('static')
			&& CFactory::_('Utilities.Files')->exists('dynamic'))
		{
			// get the bom file
			$bom = FileHelper::getContent(CFactory::_('Config')->bom_path);
			// first we do the static files
			foreach (CFactory::_('Utilities.Files')->get('static') as $static)
			{
				if (File::exists($static['path']))
				{
					$this->setFileContent(
						$static['name'], $static['path'], $bom
					);
				}
			}
			// now we do the dynamic files
			foreach (CFactory::_('Utilities.Files')->get('dynamic') as $view => $files)
			{
				if (CFactory::_('Content')->exist_($view)
					&& ArrayHelper::check(
						CFactory::_('Content')->get_($view)
					))
				{
					foreach ($files as $file)
					{
						if ($file['view'] == $view)
						{
							if (File::exists($file['path']))
							{
								$this->setFileContent(
									$file['name'], $file['path'], $bom,
									$file['view']
								);
							}
						}
					}
				}
				// free up some memory
				CFactory::_('Content')->remove_($view);
			}
			// free up some memory
			CFactory::_('Utilities.Files')->remove('dynamic');
			// do modules if found
			if (CFactory::_('Joomlamodule.Data')->exists())
			{
				foreach (CFactory::_('Joomlamodule.Data')->get() as $module)
				{
					if (ObjectHelper::check($module)
						&& CFactory::_('Utilities.Files')->exists($module->key))
					{
						// move field or rule if needed
						if (isset($module->fields_rules_paths)
							&& $module->fields_rules_paths == 2)
						{
							// check the config fields
							if (isset($module->config_fields)
								&& ArrayHelper::check(
									$module->config_fields
								))
							{
								foreach (
									$module->config_fields as $field_name =>
									$fieldsets
								)
								{
									foreach ($fieldsets as $fieldset => $fields)
									{
										foreach ($fields as $field)
										{
											$this->moveFieldsRules(
												$field, $module->folder_path
											);
										}
									}
								}
							}
							// check the fieldsets
							if (isset($module->form_files)
								&& ArrayHelper::check(
									$module->form_files
								))
							{
								foreach ($module->form_files as $file => $files)
								{
									foreach (
										$files as $field_name => $fieldsets
									)
									{
										foreach (
											$fieldsets as $fieldset => $fields
										)
										{
											foreach ($fields as $field)
											{
												$this->moveFieldsRules(
													$field, $module->folder_path
												);
											}
										}
									}
								}
							}
						}
						// update the module files
						foreach (CFactory::_('Utilities.Files')->get($module->key) as $module_file)
						{
							if (File::exists($module_file['path']))
							{
								$this->setFileContent(
									$module_file['name'], $module_file['path'],
									$bom, $module->key
								);
							}
						}
						// free up some memory
						CFactory::_('Utilities.Files')->remove($module->key);
						CFactory::_('Content')->remove_($module->key);
					}
				}
			}
			// do plugins if found
			if (CFactory::_('Joomlaplugin.Data')->exists())
			{
				foreach (CFactory::_('Joomlaplugin.Data')->get() as $plugin)
				{
					if (ObjectHelper::check($plugin)
						&& CFactory::_('Utilities.Files')->exists($plugin->key))
					{
						// move field or rule if needed
						if (isset($plugin->fields_rules_paths)
							&& $plugin->fields_rules_paths == 2)
						{
							// check the config fields
							if (isset($plugin->config_fields)
								&& ArrayHelper::check(
									$plugin->config_fields
								))
							{
								foreach (
									$plugin->config_fields as $field_name =>
									$fieldsets
								)
								{
									foreach ($fieldsets as $fieldset => $fields)
									{
										foreach ($fields as $field)
										{
											$this->moveFieldsRules(
												$field, $plugin->folder_path
											);
										}
									}
								}
							}
							// check the fieldsets
							if (isset($plugin->form_files)
								&& ArrayHelper::check(
									$plugin->form_files
								))
							{
								foreach ($plugin->form_files as $file => $files)
								{
									foreach (
										$files as $field_name => $fieldsets
									)
									{
										foreach (
											$fieldsets as $fieldset => $fields
										)
										{
											foreach ($fields as $field)
											{
												$this->moveFieldsRules(
													$field, $plugin->folder_path
												);
											}
										}
									}
								}
							}
						}
						// update the plugin files
						foreach (CFactory::_('Utilities.Files')->get($plugin->key) as $plugin_file)
						{
							if (File::exists($plugin_file['path']))
							{
								$this->setFileContent(
									$plugin_file['name'], $plugin_file['path'],
									$bom, $plugin->key
								);
							}
						}
						// free up some memory
						CFactory::_('Utilities.Files')->remove($plugin->key);
						CFactory::_('Content')->remove_($plugin->key);
					}
				}
			}
			// do powers if found
			if (ArrayHelper::check(CFactory::_('Power')->active))
			{
				foreach (CFactory::_('Power')->active as $power)
				{
					if (ObjectHelper::check($power)
						&& CFactory::_('Utilities.Files')->exists($power->key))
					{
						// update the power files
						foreach (CFactory::_('Utilities.Files')->get($power->key) as $power_file)
						{
							if (File::exists($power_file['path']))
							{
								$this->setFileContent(
									$power_file['name'], $power_file['path'],
									$bom, $power->key
								);
							}
						}
						// free up some memory
						CFactory::_('Utilities.Files')->remove($power->key);
						CFactory::_('Content')->remove_($power->key);
					}
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * set the file content
	 *
	 * @return  void
	 *
	 */
	protected function setFileContent(&$name, &$path, &$bom, $view = null)
	{
		// for plugin event TODO change event api signatures
		$component_context = CFactory::_('Config')->component_context;

		// Trigger Event: jcb_ce_onBeforeSetFileContent
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeSetFileContent',
			array(&$component_context, &$name, &$path, &$bom, &$view)
		);

		// set the file name
		CFactory::_('Content')->set('FILENAME', $name);

		// check if the file should get PHP opening
		$php = '';
		if (ComponentbuilderHelper::checkFileType($name, 'php'))
		{
			$php = "<?php\n";
		}

		// get content of the file
		$string = FileHelper::getContent($path);

		// Trigger Event: jcb_ce_onGetFileContents
		CFactory::_('Event')->trigger(
			'jcb_ce_onGetFileContents',
			array(&$component_context, &$string, &$name, &$path, &$bom,
			      &$view)
		);

		// see if we should add a BOM
		if (strpos((string) $string, (string) Placefix::_h('BOM')) !== false)
		{
			list($wast, $code) = explode(
				Placefix::_h('BOM'), (string) $string
			);
			$string = $php . $bom . $code;
		}

		// set the answer
		$answer = CFactory::_('Placeholder')->update($string, CFactory::_('Content')->active, 3);

		// set the dynamic answer
		if ($view)
		{
			$answer = CFactory::_('Placeholder')->update(
				$answer, CFactory::_('Content')->get_($view), 3
			);
		}

		// check if this file needs extra care :)
		if (CFactory::_('Registry')->exists('update.file.content.' . $path))
		{
			$answer = CFactory::_('Customcode')->update($answer);
		}

		// Trigger Event: jcb_ce_onBeforeSetFileContent
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeWriteFileContent',
			array(&$component_context, &$answer, &$name, &$path, &$bom,
			      &$view)
		);

		// add answer back to file
		CFactory::_('Utilities.File')->write($path, $answer);

		// count the file lines
		CFactory::_('Utilities.Counter')->line += substr_count((string) $answer, PHP_EOL);
	}

	/**
	 * move the local update server xml file to a remote ftp server
	 *
	 * @return  void
	 *
	 */
	protected function setUpdateServer()
	{
		// move the component update server to host
		if (CFactory::_('Component')->get('add_update_server', 0) == 1
			&& isset($this->updateServerFileName)
			&& $this->dynamicIntegration)
		{
			$update_server_xml_path = CFactory::_('Utilities.Paths')->component_path . '/'
				. $this->updateServerFileName . '.xml';
			// make sure we have the correct file
			if (File::exists($update_server_xml_path)
				&& ($update_server = CFactory::_('Component')->get('update_server')) !== null)
			{
				// move to server
				if (!CFactory::_('Server')->legacyMove(
					$update_server_xml_path,
					$this->updateServerFileName . '.xml',
					(int) $update_server,
					CFactory::_('Component')->get('update_server_protocol')
				))
				{
					$this->app->enqueueMessage(
						JText::sprintf(
							'Upload of component (%s) update server XML failed.',
							CFactory::_('Component')->get('system_name')
						), 'Error'
					);
				}
				// remove the local file
				File::delete($update_server_xml_path);
			}
		}
		// move the modules update server to host
		if (CFactory::_('Joomlamodule.Data')->exists())
		{
			foreach (CFactory::_('Joomlamodule.Data')->get() as $module)
			{
				if (ObjectHelper::check($module)
					&& isset($module->add_update_server)
					&& $module->add_update_server == 1
					&& isset($module->update_server_target)
					&& $module->update_server_target == 1
					&& isset($module->update_server)
					&& is_numeric($module->update_server)
					&& $module->update_server > 0
					&& isset($module->update_server_xml_path)
					&& File::exists($module->update_server_xml_path)
					&& isset($module->update_server_xml_file_name)
					&& StringHelper::check(
						$module->update_server_xml_file_name
					))
				{
					// move to server
					if (!CFactory::_('Server')->legacyMove(
						$module->update_server_xml_path,
						$module->update_server_xml_file_name,
						(int) $module->update_server,
						$module->update_server_protocol
					))
					{
						$this->app->enqueueMessage(
							JText::sprintf(
								'Upload of module (%s) update server XML failed.',
								$module->name
							), 'Error'
						);
					}
					// remove the local file
					File::delete($module->update_server_xml_path);
				}
				// var_dump($module->update_server_xml_path);exit;
			}
		}
		// move the plugins update server to host
		if (CFactory::_('Joomlaplugin.Data')->exists())
		{
			foreach (CFactory::_('Joomlaplugin.Data')->get() as $plugin)
			{
				if (ObjectHelper::check($plugin)
					&& isset($plugin->add_update_server)
					&& $plugin->add_update_server == 1
					&& isset($plugin->update_server_target)
					&& $plugin->update_server_target == 1
					&& isset($plugin->update_server)
					&& is_numeric($plugin->update_server)
					&& $plugin->update_server > 0
					&& isset($plugin->update_server_xml_path)
					&& File::exists($plugin->update_server_xml_path)
					&& isset($plugin->update_server_xml_file_name)
					&& StringHelper::check(
						$plugin->update_server_xml_file_name
					))
				{
					// move to server
					if (!CFactory::_('Server')->legacyMove(
						$plugin->update_server_xml_path,
						$plugin->update_server_xml_file_name,
						(int) $plugin->update_server,
						$plugin->update_server_protocol
					))
					{
						$this->app->enqueueMessage(
							JText::sprintf(
								'Upload of plugin (%s) update server XML failed.',
								$plugin->name
							), 'Error'
						);
					}
					// remove the local file
					File::delete($plugin->update_server_xml_path);
				}
			}
		}
	}

	// link changes made to views into the file license
	protected function fixLicenseValues($data)
	{
		// check if these files have its own config data)
		if (isset($data['config'])
			&& ArrayHelper::check(
				$data['config']
			)
			&& CFactory::_('Component')->get('mvc_versiondate', 0) == 1)
		{
			foreach ($data['config'] as $key => $value)
			{
				if (Placefix::_h('VERSION') === $key)
				{
					// hmm we sould in some way make it known that this version number
					// is not in relation the the project but to the file only... any ideas?
					// this is the best for now...
					if (1 == $value)
					{
						$value = '@first version of this MVC';
					}
					else
					{
						$value = '@update number ' . $value . ' of this MVC';
					}
				}
				CFactory::_('Content')->set($key, $value);
			}

			return true;
		}
		// else insure to reset to global
		CFactory::_('Content')->set('CREATIONDATE', CFactory::_('Content')->get('GLOBALCREATIONDATE'));
		CFactory::_('Content')->set('BUILDDATE', CFactory::_('Content')->get('GLOBALBUILDDATE'));
		CFactory::_('Content')->set('VERSION', CFactory::_('Content')->get('GLOBALVERSION'));
	}

	/**
	 * Set all global numbers
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	protected function setCountingStuff()
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	private function buildReadMe()
	{
		// do a final run to update the readme file
		$two = 0;
		// counter data if not set already
		if (!CFactory::_('Content')->exist('LINE_COUNT')
			|| CFactory::_('Content')->get('LINE_COUNT') != CFactory::_('Utilities.Counter')->line)
		{
			CFactory::_('Utilities.Counter')->set();
		}
		// search for the readme
		foreach (CFactory::_('Utilities.Files')->get('static') as $static)
		{
			if (('README.md' === $static['name']
					|| 'README.txt' === $static['name'])
				&& CFactory::_('Component')->get('addreadme')
				&& File::exists($static['path']))
			{
				$this->setReadMe($static['path']);
				$two++;
			}
			if ($two == 2)
			{
				break;
			}
		}
		CFactory::_('Utilities.Files')->remove('static');
	}

	private function setReadMe($path)
	{
		// get the file
		$string = FileHelper::getContent($path);
		// update the file
		$answer = CFactory::_('Placeholder')->update($string, CFactory::_('Content')->active);
		// add to zip array
		CFactory::_('Utilities.File')->write($path, $answer);
	}

	/**
	 * Build README data
	 *
	 * @return  void
	 * @deprecated 3.3
	 */
	private function buildReadMeData()
	{
		// set notice that we could not get a valid string from the target
		$this->app->enqueueMessage(
			JText::sprintf('<hr /><h3>%s Warning</h3>', __CLASS__), 'Error'
		);
		$this->app->enqueueMessage(
			JText::sprintf(
				'Use of a deprecated method (%s)!', __METHOD__
			), 'Error'
		);
	}

	private function setLocalRepos()
	{
		// move it to the repo folder if set
		if (isset($this->repoPath)
			&& StringHelper::check(
				$this->repoPath
			))
		{
			// set the repo path
			$repoFullPath = $this->repoPath . '/com_'
				. CFactory::_('Component')->get('sales_name') . '__joomla_'
				. CFactory::_('Config')->get('version', 3);
			// for plugin event TODO change event api signatures
			$component_context = CFactory::_('Config')->component_context;
			$component_path = CFactory::_('Utilities.Paths')->component_path;
			// Trigger Event: jcb_ce_onBeforeUpdateRepo
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeUpdateRepo',
				array(&$component_context, &$component_path,
				      &$repoFullPath, &$this->componentData)
			);
			// remove old data
			CFactory::_('Utilities.Folder')->remove($repoFullPath, CFactory::_('Component')->get('toignore'));
			// set the new data
			Folder::copy(CFactory::_('Utilities.Paths')->component_path, $repoFullPath, '', true);
			// Trigger Event: jcb_ce_onAfterUpdateRepo
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterUpdateRepo',
				array(&$component_context, &$component_path,
				      &$repoFullPath, &$this->componentData)
			);

			// move the modules to local folder repos
			if (CFactory::_('Joomlamodule.Data')->exists())
			{
				foreach (CFactory::_('Joomlamodule.Data')->get() as $module)
				{
					if (ObjectHelper::check($module)
						&& isset($module->file_name))
					{
						$module_context = 'module.' . $module->file_name . '.'
							. $module->id;
						// set the repo path
						$repoFullPath = $this->repoPath . '/'
							. $module->folder_name . '__joomla_'
							. CFactory::_('Config')->get('version', 3);
						// Trigger Event: jcb_ce_onBeforeUpdateRepo
						CFactory::_('Event')->trigger(
							'jcb_ce_onBeforeUpdateRepo',
							array(&$module_context, &$module->folder_path,
							      &$repoFullPath, &$module)
						);
						// remove old data
						CFactory::_('Utilities.Folder')->remove(
							$repoFullPath, CFactory::_('Component')->get('toignore')
						);
						// set the new data
						Folder::copy(
							$module->folder_path, $repoFullPath, '', true
						);
						// Trigger Event: jcb_ce_onAfterUpdateRepo
						CFactory::_('Event')->trigger(
							'jcb_ce_onAfterUpdateRepo',
							array(&$module_context, &$module->folder_path,
							      &$repoFullPath, &$module)
						);
					}
				}
			}
			// move the plugins to local folder repos
			if (CFactory::_('Joomlaplugin.Data')->exists())
			{
				foreach (CFactory::_('Joomlaplugin.Data')->get() as $plugin)
				{
					if (ObjectHelper::check($plugin)
						&& isset($plugin->file_name))
					{
						$plugin_context = 'plugin.' . $plugin->file_name . '.'
							. $plugin->id;
						// set the repo path
						$repoFullPath = $this->repoPath . '/'
							. $plugin->folder_name . '__joomla_'
							. CFactory::_('Config')->get('version', 3);
						// Trigger Event: jcb_ce_onBeforeUpdateRepo
						CFactory::_('Event')->trigger(
							'jcb_ce_onBeforeUpdateRepo',
							array(&$plugin_context, &$plugin->folder_path,
							      &$repoFullPath, &$plugin)
						);
						// remove old data
						CFactory::_('Utilities.Folder')->remove(
							$repoFullPath, CFactory::_('Component')->get('toignore')
						);
						// set the new data
						Folder::copy(
							$plugin->folder_path, $repoFullPath, '', true
						);
						// Trigger Event: jcb_ce_onAfterUpdateRepo
						CFactory::_('Event')->trigger(
							'jcb_ce_onAfterUpdateRepo',
							array(&$plugin_context, &$plugin->folder_path,
							      &$repoFullPath, &$plugin)
						);
					}
				}
			}
		}
	}

	private function zipComponent()
	{
		// Component Folder Name
		$this->filepath['component-folder'] = CFactory::_('Utilities.Paths')->component_folder_name;
		// the name of the zip file to create
		$this->filepath['component'] = $this->tempPath . '/'
			. $this->filepath['component-folder'] . '.zip';
		// for plugin event TODO change event api signatures
		$component_context = CFactory::_('Config')->component_context;
		$component_path = CFactory::_('Utilities.Paths')->component_path;
		$component_sales_name = CFactory::_('Utilities.Paths')->component_sales_name;
		$component_folder_name = CFactory::_('Utilities.Paths')->component_folder_name;
		// Trigger Event: jcb_ce_onBeforeZipComponent
		CFactory::_('Event')->trigger(
			'jcb_ce_onBeforeZipComponent',
			array(&$component_context, &$component_path,
			      &$this->filepath['component'], &$this->tempPath,
			      &$component_folder_name, &$this->componentData)
		);
		//create the zip file
		if (FileHelper::zip(
			CFactory::_('Utilities.Paths')->component_path, $this->filepath['component']
		))
		{
			// now move to backup if zip was made and backup is required
			if ($this->backupPath && $this->dynamicIntegration)
			{
				// Trigger Event: jcb_ce_onBeforeBackupZip
				CFactory::_('Event')->trigger(
					'jcb_ce_onBeforeBackupZip', array(&$component_context,
					                                  &$this->filepath['component'],
					                                  &$this->tempPath,
					                                  &$this->backupPath,
					                                  &$this->componentData)
				);
				// copy the zip to backup path
				File::copy(
					$this->filepath['component'],
					$this->backupPath . '/' . CFactory::_('Utilities.Paths')->component_backup_name
					. '.zip'
				);
			}
			// move to sales server host
			if (CFactory::_('Component')->get('add_sales_server', 0) == 1
				&& $this->dynamicIntegration)
			{
				// make sure we have the correct file
				if (CFactory::_('Component')->get('sales_server'))
				{
					// Trigger Event: jcb_ce_onBeforeMoveToServer
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeMoveToServer',
						array(&$component_context,
						      &$this->filepath['component'], &$this->tempPath,
						      &$component_sales_name, &$this->componentData)
					);
					// move to server
					if (!CFactory::_('Server')->legacyMove(
						$this->filepath['component'],
						$component_sales_name . '.zip',
						(int) CFactory::_('Component')->get('sales_server'),
						CFactory::_('Component')->get('sales_server_protocol')
					))
					{
						$this->app->enqueueMessage(
							JText::sprintf(
								'Upload of component (%s) zip file failed.',
								CFactory::_('Component')->get('system_name')
							), 'Error'
						);
					}
				}
			}
			// Trigger Event: jcb_ce_onAfterZipComponent
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterZipComponent',
				array(&$component_context, &$this->filepath['component'],
				      &$this->tempPath, &$component_folder_name,
				      &$this->componentData)
			);
			// remove the component folder since we are done
			if (CFactory::_('Utilities.Folder')->remove(CFactory::_('Utilities.Paths')->component_path))
			{
				return true;
			}
		}

		return false;
	}

	private function zipModules()
	{
		if (CFactory::_('Joomlamodule.Data')->exists())
		{
			foreach (CFactory::_('Joomlamodule.Data')->get() as $module)
			{
				if (ObjectHelper::check($module)
					&& isset($module->zip_name)
					&& StringHelper::check($module->zip_name)
					&& isset($module->folder_path)
					&& StringHelper::check(
						$module->folder_path
					))
				{
					// set module context
					$module_context = $module->file_name . '.' . $module->id;
					// Component Folder Name
					$this->filepath['modules-folder'][$module->id]
						= $module->zip_name;
					// the name of the zip file to create
					$this->filepath['modules'][$module->id] = $this->tempPath
						. '/' . $module->zip_name . '.zip';
					// Trigger Event: jcb_ce_onBeforeZipModule
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeZipModule',
						array(&$module_context, &$module->folder_path,
						      &$this->filepath['modules'][$module->id],
						      &$this->tempPath, &$module->zip_name, &$module)
					);
					//create the zip file
					if (FileHelper::zip(
						$module->folder_path,
						$this->filepath['modules'][$module->id]
					))
					{
						// now move to backup if zip was made and backup is required
						if ($this->backupPath)
						{
							$__module_context = 'module.' . $module_context;
							// Trigger Event: jcb_ce_onBeforeBackupZip
							CFactory::_('Event')->trigger(
								'jcb_ce_onBeforeBackupZip',
								array(&$__module_context,
								      &$this->filepath['modules'][$module->id],
								      &$this->tempPath, &$this->backupPath,
								      &$module)
							);
							// copy the zip to backup path
							File::copy(
								$this->filepath['modules'][$module->id],
								$this->backupPath . '/' . $module->zip_name
								. '.zip'
							);
						}

						// move to sales server host
						if ($module->add_sales_server == 1)
						{
							// make sure we have the correct file
							if (isset($module->sales_server))
							{
								// Trigger Event: jcb_ce_onBeforeMoveToServer
								CFactory::_('Event')->trigger(
									'jcb_ce_onBeforeMoveToServer',
									array(&$__module_context,
									      &$this->filepath['modules'][$module->id],
									      &$this->tempPath, &$module->zip_name,
									      &$module)
								);
								// move to server
								if (!CFactory::_('Server')->legacyMove(
									$this->filepath['modules'][$module->id],
									$module->zip_name . '.zip',
									(int) $module->sales_server,
									$module->sales_server_protocol
								))
								{
									$this->app->enqueueMessage(
										JText::sprintf(
											'Upload of module (%s) zip file failed.',
											$module->name
										), 'Error'
									);
								}
							}
						}
						// Trigger Event: jcb_ce_onAfterZipModule
						CFactory::_('Event')->trigger(
							'jcb_ce_onAfterZipModule', array(&$module_context,
							                                 &$this->filepath['modules'][$module->id],
							                                 &$this->tempPath,
							                                 &$module->zip_name,
							                                 &$module)
						);
						// remove the module folder since we are done
						CFactory::_('Utilities.Folder')->remove($module->folder_path);
					}
				}
			}
		}
	}

	private function zipPlugins()
	{
		if (CFactory::_('Joomlaplugin.Data')->exists())
		{
			foreach (CFactory::_('Joomlaplugin.Data')->get() as $plugin)
			{
				if (ObjectHelper::check($plugin)
					&& isset($plugin->zip_name)
					&& StringHelper::check($plugin->zip_name)
					&& isset($plugin->folder_path)
					&& StringHelper::check(
						$plugin->folder_path
					))
				{
					// set plugin context
					$plugin_context = $plugin->file_name . '.' . $plugin->id;
					// Component Folder Name
					$this->filepath['plugins-folder'][$plugin->id]
						= $plugin->zip_name;
					// the name of the zip file to create
					$this->filepath['plugins'][$plugin->id] = $this->tempPath
						. '/' . $plugin->zip_name . '.zip';
					// Trigger Event: jcb_ce_onBeforeZipPlugin
					CFactory::_('Event')->trigger(
						'jcb_ce_onBeforeZipPlugin',
						array(&$plugin_context, &$plugin->folder_path,
						      &$this->filepath['plugins'][$plugin->id],
						      &$this->tempPath, &$plugin->zip_name, &$plugin)
					);
					//create the zip file
					if (FileHelper::zip(
						$plugin->folder_path,
						$this->filepath['plugins'][$plugin->id]
					))
					{
						// now move to backup if zip was made and backup is required
						if ($this->backupPath)
						{
							$__plugin_context = 'plugin.' . $plugin_context;
							// Trigger Event: jcb_ce_onBeforeBackupZip
							CFactory::_('Event')->trigger(
								'jcb_ce_onBeforeBackupZip',
								array(&$__plugin_context,
								      &$this->filepath['plugins'][$plugin->id],
								      &$this->tempPath, &$this->backupPath,
								      &$plugin)
							);
							// copy the zip to backup path
							File::copy(
								$this->filepath['plugins'][$plugin->id],
								$this->backupPath . '/' . $plugin->zip_name
								. '.zip'
							);
						}

						// move to sales server host
						if ($plugin->add_sales_server == 1)
						{
							// make sure we have the correct file
							if (isset($plugin->sales_server))
							{
								// Trigger Event: jcb_ce_onBeforeMoveToServer
								CFactory::_('Event')->trigger(
									'jcb_ce_onBeforeMoveToServer',
									array(&$__plugin_context,
									      &$this->filepath['plugins'][$plugin->id],
									      &$this->tempPath, &$plugin->zip_name,
									      &$plugin)
								);
								// move to server
								if (!CFactory::_('Server')->legacyMove(
									$this->filepath['plugins'][$plugin->id],
									$plugin->zip_name . '.zip',
									(int) $plugin->sales_server,
									$plugin->sales_server_protocol
								))
								{
									$this->app->enqueueMessage(
										JText::sprintf(
											'Upload of plugin (%s) zip file failed.',
											$plugin->name
										), 'Error'
									);
								}
							}
						}
						// Trigger Event: jcb_ce_onAfterZipPlugin
						CFactory::_('Event')->trigger(
							'jcb_ce_onAfterZipPlugin', array(&$plugin_context,
							                                 &$this->filepath['plugins'][$plugin->id],
							                                 &$this->tempPath,
							                                 &$plugin->zip_name,
							                                 &$plugin)
						);
						// remove the plugin folder since we are done
						CFactory::_('Utilities.Folder')->remove($plugin->folder_path);
					}
				}
			}
		}
	}

	protected function addCustomCode()
	{
		// reset all these
		CFactory::_('Placeholder')->clearType('view');
		CFactory::_('Placeholder')->clearType('arg');
		foreach (CFactory::_('Customcode')->active as $nr => $target)
		{
			// reset each time per custom code
			$fingerPrint = array();
			if (isset($target['hashtarget'][0]) && $target['hashtarget'][0] > 3
				&& isset($target['path'])
				&& StringHelper::check($target['path'])
				&& isset($target['hashtarget'][1])
				&& StringHelper::check(
					$target['hashtarget'][1]
				))
			{
				$file      = CFactory::_('Utilities.Paths')->component_path . '/' . $target['path'];
				$size      = (int) $target['hashtarget'][0];
				$hash      = $target['hashtarget'][1];
				$cut       = $size - 1;
				$found     = false;
				$bites     = 0;
				$lineBites = array();
				$replace   = array();
				if ($target['type'] == 1 && isset($target['hashendtarget'][0])
					&& $target['hashendtarget'][0] > 0)
				{
					$foundEnd = false;
					$sizeEnd  = (int) $target['hashendtarget'][0];
					$hashEnd  = $target['hashendtarget'][1];
					$cutEnd   = $sizeEnd - 1;
				}
				else
				{
					// replace to the end of the file
					$foundEnd = true;
				}
				$counter = 0;
				// check if file exist			
				if (File::exists($file))
				{
					foreach (
						new SplFileObject($file) as $lineNumber => $lineContent
					)
					{
						// if not found we need to load line bites per line
						$lineBites[$lineNumber] = (int) mb_strlen(
							$lineContent, '8bit'
						);
						if (!$found)
						{
							$bites = (int) MathHelper::bc(
								'add', $lineBites[$lineNumber], $bites
							);
						}
						if ($found && !$foundEnd)
						{
							$replace[] = (int) $lineBites[$lineNumber];
							// we musk keep last three lines to dynamic find target entry
							$fingerPrint[$lineNumber] = trim($lineContent);
							// check lines each time if it fits our target
							if (count((array) $fingerPrint) === $sizeEnd
								&& !$foundEnd)
							{
								$fingerTest = md5(implode('', $fingerPrint));
								if ($fingerTest === $hashEnd)
								{
									// we are done here
									$foundEnd = true;
									$replace  = array_slice(
										$replace, 0, count($replace) - $sizeEnd
									);
									break;
								}
								else
								{
									$fingerPrint = array_slice(
										$fingerPrint, -$cutEnd, $cutEnd, true
									);
								}
							}
							continue;
						}
						if ($found && $foundEnd)
						{
							$replace[] = (int) $lineBites[$lineNumber];
						}
						// we musk keep last three lines to dynamic find target entry
						$fingerPrint[$lineNumber] = trim($lineContent);
						// check lines each time if it fits our target
						if (count((array) $fingerPrint) === $size && !$found)
						{
							$fingerTest = md5(implode('', $fingerPrint));
							if ($fingerTest === $hash)
							{
								// we are done here
								$found = true;
								// reset in case
								$fingerPrint = array();
								// break if it is insertion
								if ($target['type'] == 2)
								{
									break;
								}
							}
							else
							{
								$fingerPrint = array_slice(
									$fingerPrint, -$cut, $cut, true
								);
							}
						}
					}
					if ($found)
					{
						$placeholder = CFactory::_('Placeholder')->keys(
							(int) $target['comment_type'] . $target['type'],
							$target['id']
						);
						$data        = $placeholder['start'] . PHP_EOL
							. CFactory::_('Placeholder')->update_(
								$target['code']
							) . $placeholder['end'] . PHP_EOL;
						if ($target['type'] == 2)
						{
							// found it now add code from the next line
							$this->addDataToFile($file, $data, $bites);
						}
						elseif ($target['type'] == 1 && $foundEnd)
						{
							// found it now add code from the next line
							$this->addDataToFile(
								$file, $data, $bites, (int) array_sum($replace)
							);
						}
						else
						{
							// Load escaped code since the target endhash has changed
							$this->loadEscapedCode($file, $target, $lineBites);
							$this->app->enqueueMessage(
								JText::_('<hr /><h3>Custom Code Warning</h3>'),
								'Warning'
							);
							$this->app->enqueueMessage(
								JText::sprintf(
									'Custom code %s could not be added to <b>%s</b> please review the file after install at <b>line %s</b> and reposition the code, remove the comments and recompile to fix the issue. The issue could be due to a change to <b>lines below</b> the custom code.',
									'<a href="index.php?option=com_componentbuilder&view=custom_codes&task=custom_code.edit&id='
									. $target['id'] . '" target="_blank">#'
									. $target['id'] . '</a>', $target['path'],
									$target['from_line']
								), 'Warning'
							);
						}
					}
					else
					{
						// Load escaped code since the target hash has changed
						$this->loadEscapedCode($file, $target, $lineBites);
						$this->app->enqueueMessage(
							JText::_('<hr /><h3>Custom Code Warning</h3>'),
							'Warning'
						);
						$this->app->enqueueMessage(
							JText::sprintf(
								'Custom code %s could not be added to <b>%s</b> please review the file after install at <b>line %s</b> and reposition the code, remove the comments and recompile to fix the issue. The issue could be due to a change to <b>lines above</b> the custom code.',
								'<a href="index.php?option=com_componentbuilder&view=custom_codes&task=custom_code.edit&id='
								. $target['id'] . '" target="_blank">#'
								. $target['id'] . '</a>', $target['path'],
								$target['from_line']
							), 'Warning'
						);
					}
				}
				else
				{
					// Give developer a notice that file is not found.
					$this->app->enqueueMessage(
						JText::_('<hr /><h3>Custom Code Warning</h3>'),
						'Warning'
					);
					$this->app->enqueueMessage(
						JText::sprintf(
							'File <b>%s</b> could not be found, so the custom code for this file could not be addded.',
							$target['path']
						), 'Warning'
					);
				}
			}
		}
	}

	protected function loadEscapedCode($file, $target, $lineBites)
	{
		// get comment type
		if ($target['comment_type'] == 1)
		{
			$commentType  = "// ";
			$_commentType = "";
		}
		else
		{
			$commentType  = "<!--";
			$_commentType = " -->";
		}
		// escape the code
		$code = explode(PHP_EOL, (string) $target['code']);
		$code = PHP_EOL . $commentType . implode(
				$_commentType . PHP_EOL . $commentType, $code
			) . $_commentType . PHP_EOL;
		// get place holders
		$placeholder = CFactory::_('Placeholder')->keys(
			(int) $target['comment_type'] . $target['type'], $target['id']
		);
		// build the data
		$data = $placeholder['start'] . $code . $placeholder['end'] . PHP_EOL;
		// get the bites before insertion
		$bitBucket = array();
		foreach ($lineBites as $line => $value)
		{
			if ($line < $target['from_line'])
			{
				$bitBucket[] = $value;
			}
		}
		// add to the file
		$this->addDataToFile($file, $data, (int) array_sum($bitBucket));
	}

	// Thanks to http://stackoverflow.com/a/16813550/1429677
	protected function addDataToFile($file, $data, $position, $replace = null)
	{
		// start the process
		$fpFile = fopen($file, "rw+");
		$fpTemp = fopen('php://temp', "rw+");
		// make a copy of the file
		stream_copy_to_stream($fpFile, $fpTemp);
		// move to the position where we should add the data
		fseek($fpFile, $position);
		// Add the data
		fwrite($fpFile, (string) $data);
		// truncate file at the end of the data that was added
		$remove = MathHelper::bc(
			'add', $position, mb_strlen((string) $data, '8bit')
		);
		ftruncate($fpFile, $remove);
		// check if this was a replacement of data
		if ($replace)
		{
			$position = MathHelper::bc(
				'add', $position, $replace
			);
		}
		// move to the position of the data that should remain below the new data
		fseek($fpTemp, $position);
		// copy that remaining data to the file
		stream_copy_to_stream($fpTemp, $fpFile); // @Jack
		// done close both files
		fclose($fpFile);
		fclose($fpTemp);

		// any help to improve this is welcome...
	}

}
