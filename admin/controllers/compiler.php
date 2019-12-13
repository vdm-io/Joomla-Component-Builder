<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Compiler Controller
 */
class ComponentbuilderControllerCompiler extends JControllerAdmin
{
	protected $text_prefix = 'COM_COMPONENTBUILDER_COMPILER';
	/**
	 * Proxy for getModel.
	 * @since	2.5
	 */
	public function getModel($name = 'Compiler', $prefix = 'ComponentbuilderModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

        public function dashboard()
	{
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder', false));
		return;
	}

	/**
	 * Run the Compiler
	 *
	 * @return  true on success
	 */
	public function compiler()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		if($user->authorise('core.admin', 'com_componentbuilder'))
		{
			// get the post values
			$jinput = JFactory::getApplication()->input;
			$componentId = $jinput->post->get('component', 0, 'INT');
			$version = $jinput->post->get('version', 0, 'INT');
			$addBackup = $jinput->post->get('backup', 0, 'INT');
			$addRepo = $jinput->post->get('repository', 0, 'INT');
			$addPlaceholders = $jinput->post->get('placeholders', 2, 'INT');
			$debugLinenr = $jinput->post->get('debuglinenr', 2, 'INT');
			$minify = $jinput->post->get('minify', 2, 'INT');
			// include component compiler
			require_once JPATH_ADMINISTRATOR.'/components/com_componentbuilder/helpers/compiler.php';
			$model = $this->getModel('compiler');
			if ($model->builder($version, $componentId, $addBackup, $addRepo, $addPlaceholders, $debugLinenr, $minify))
			{
				$cache = JFactory::getCache('mod_menu');
				$cache->clean();
				// TODO: Reset the users acl here as well to kill off any missing bits
			}
			else
			{
				return false;
			}

			$app = JFactory::getApplication();
			$redirect_url = $app->getUserState('com_componentbuilder.redirect_url');
			$message = $app->getUserState('com_componentbuilder.message');
			if (empty($redirect_url) && $componentId > 0)
			{
				$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
				if (($pos = strpos($model->compiler->filepath['component'], "/tmp/")) !== FALSE)
				{
				    $url = JURI::root() . substr($model->compiler->filepath['component'], $pos + 1);
				}
				// check if we have plugins
				if (ComponentbuilderHelper::checkArray($model->compiler->filepath['plugins']))
				{
					// Message of successful build
					$message = '<h1>The Extensions were Successfully Compiled!</h1>';
					$message .= '<h4>You can install any one of the following extensions!</h4>';
				}
				else
				{
					// Message of successful build
					$message = '<h1>The (' . $model->compiler->filepath['component-folder'] . ') was Successfully Compiled!</h1>';
				}
				$message .= '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledComponent\')">';
				$message .= 'Install ' . $model->compiler->filepath['component-folder'] . ' on this <span class="icon-joomla icon-white"></span>Joomla website. (component)</button></p>';
				// switch to set multi install button
				$add_multi_install = true;
				// check if we have modules
				if (ComponentbuilderHelper::checkArray($model->compiler->filepath['modules']))
				{
					foreach ($model->compiler->filepath['modules-folder'] as $module_id => $module_folder)
					{
						$message .= '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledModule\', ' . (int) $module_id . ')">';
						$message .= 'Install ' . $module_folder . ' on this <span class="icon-joomla icon-white"></span>Joomla website. (module)</button></p>';
					}
				}
				// check if we have plugins
				if (ComponentbuilderHelper::checkArray($model->compiler->filepath['plugins']))
				{
					$add_multi_install = true;
					foreach ($model->compiler->filepath['plugins-folder'] as $plugin_id => $plugin_folder)
					{
						$message .= '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledPlugin\', ' . (int) $plugin_id . ')">';
						$message .= 'Install ' . $plugin_folder . ' on this <span class="icon-joomla icon-white"></span>Joomla website. (plugin)</button></p>';
					}
				}
				// set multi install button
				if ($add_multi_install)
				{
					$message .= '<h4>You can install all compiled extensions!</h4>';
					$message .= '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledExtensions\')">';
					$message .= 'Install all above extensions on this <span class="icon-joomla icon-white"></span>Joomla website.</button></p>';
				}
				$message .= '<h2>Total time saved</h2>';
				$message .= '<ul>';
				$message .= '<li>Total folders created: <b>'.$model->compiler->folderCount.'</b></li>';
				$message .= '<li>Total files created: <b>'.$model->compiler->fileCount.'</b></li>';
				$message .= '<li>Total fields created: <b>'.$model->compiler->fieldCount.'</b></li>';
				$message .= '<li>Total lines written: <b>'.$model->compiler->lineCount.'</b></li>';
				$message .= '<li>A4 Book of: <b>'.$model->compiler->pageCount.' pages</b></li>';
				$message .= '</ul>';
				$message .= '<p><b>'.$model->compiler->totalHours.' Hours</b> or <b>'.$model->compiler->totalDays.' Eight Hour Days</b> <em>(actual time you saved)</em><br />';
				$message .= '<small>(if creating a folder and file took <b>5 seconds</b> and writing one line of code took <b>10 seconds</b>, never making one mistake or taking any coffee break.)</small><br />';
				$message .= '<b>'.$model->compiler->actualHoursSpent.' Hours</b> or <b>'.$model->compiler->actualDaysSpent.' Eight Hour Days</b> <em>(the actual time you spent)</em><br />';
				$message .= '<small>(with the following break down: <b>debugging @'.$model->compiler->debuggingHours.'hours</b> = codingtime / 4; <b>planning @'.$model->compiler->planningHours.'hours</b> = codingtime / 7; <b>mapping @'.$model->compiler->mappingHours.'hours</b> = codingtime / 10; <b>office @'.$model->compiler->officeHours.'hours</b> = codingtime / 6;)</small></p>';
				$message .= '<p><b>'.$model->compiler->actualTotalHours.' Hours</b> or <b>'.$model->compiler->actualTotalDays.' Eight Hour Days</b> <em>(a total of the realistic time frame for this project)</em><br />';
				$message .= '<small>(if creating a folder and file took <b>5 seconds</b> and writing one line of code took <b>10 seconds</b>, with the normal everyday realities at the office, that includes the component planning, mapping & debugging.)</small></p>';
				$message .= '<p>Project duration: <b>'.$model->compiler->projectWeekTime. ' weeks</b> or <b>'.$model->compiler->projectMonthTime.' months</b></p>';
				// check if we have modules or plugins
				if (ComponentbuilderHelper::checkArray($model->compiler->filepath['plugins']) || ComponentbuilderHelper::checkArray($model->compiler->filepath['modules']))
				{
					$message .= '<h2>Path to Zip Files</h2>';
					$message .= '<p><b>Component Path:</b> <code>' . $model->compiler->filepath['component'] . '</code><br />';
					$message .= '<b>Component URL:</b> <code>' . $url . '</code><br /><br />';
					// load plugins if found
					if (ComponentbuilderHelper::checkArray($model->compiler->filepath['plugins']))
					{
						$plugin_urls = array();
						// load the plugins path/url
						foreach ($model->compiler->filepath['plugins'] as $plugin_id => $plugin_path)
						{
							// set plugin path
							$message .= '<b>Plugin Path:</b> <code>' . $plugin_path . '</code><br />';
							if (($pos = strpos($plugin_path, "/tmp/")) !== FALSE)
							{
								$plugin_urls[$plugin_id] = JURI::root() . substr($plugin_path, $pos + 1);
								$message .= '<b>Plugin URL:</b> <code>' . $plugin_urls[$plugin_id] . '</code><br />';
							}
						}
					}
					// load modules if found
					if (ComponentbuilderHelper::checkArray($model->compiler->filepath['modules']))
					{
						$module_urls = array();
						// load the modules path/url
						foreach ($model->compiler->filepath['modules'] as $module_id => $module_path)
						{
							// set module path
							$message .= '<b>Module Path:</b> <code>' . $module_path . '</code><br />';
							if (($pos = strpos($module_path, "/tmp/")) !== FALSE)
							{
								$module_urls[$module_id] = JURI::root() . substr($module_path, $pos + 1);
								$message .= '<b>Module URL:</b> <code>' . $module_urls[$module_id] . '</code><br />';
							}
						}
					}
					$message .= '<br /><small>Hey! you can also download these zip files right now!</small><br />';
					$message .= '<a class="btn btn-success" href="' . $url . '" ><span class="icon-download icon-white"></span>Download Component</a>&nbsp;&nbsp;';
					// load the module download URL's
					if (isset($module_urls) && ComponentbuilderHelper::checkArray($module_urls))
					{
						foreach ($module_urls as $module_id => $module_url)
						{
							$message .= ' <a class="btn btn-success" href="' . $module_url . '" >';
							$message .= '<span class="icon-download icon-white"></span>Download ' . $model->compiler->filepath['modules-folder'][$module_id] . '</a>&nbsp;&nbsp;';
						}
					}
					// load the plugin download URL's
					if (isset($plugin_urls) && ComponentbuilderHelper::checkArray($plugin_urls))
					{
						foreach ($plugin_urls as $plugin_id => $plugin_url)
						{
							$message .= ' <a class="btn btn-success" href="' . $plugin_url . '" >';
							$message .= '<span class="icon-download icon-white"></span>Download ' . $model->compiler->filepath['plugins-folder'][$plugin_id] . '</a>&nbsp;&nbsp;';
						}
					}
					$message .= '</p>';
					$message .= '<p><small><b>Remember!</b> These zip files are in your tmp folder and therefore publicly accessible until you click [Clear tmp]!</small></p>';
				}
				else
				{
					$message .= '<h2>Path to Zip File</h2>';
					$message .= '<p><b>Path:</b> <code>' . $model->compiler->filepath['component'] . '</code><br />';
					$message .= '<b>URL:</b> <code>' . $url . '</code><br /><br />';
					$message .= '<small>Hey! you can also download the zip file right now!</small><br />';
					$message .= '<a class="btn btn-success" href="' . $url . '" ><span class="icon-download icon-white"></span>Download</a></p>';
					$message .= '<p><small><b>Remember!</b> This zip file is in your tmp folder and therefore publicly accessible until you click [Clear tmp]!</small> </p>';
				}
				$message .= '<p><small>Compilation took <b>'.$model->compiler->secondsCompiled.'</b> seconds to complete.</small> </p>';
				// set redirect
				$this->setRedirect($redirect_url, $message, 'message');
				$app->setUserState('com_componentbuilder.component_folder_name', $model->compiler->filepath['component-folder']);
				// check if we have modules
				if (ComponentbuilderHelper::checkArray($model->compiler->filepath['modules']))
				{
					$app->setUserState('com_componentbuilder.modules_folder_name', $model->compiler->filepath['modules-folder']);
				}
				// check if we have plugins
				if (ComponentbuilderHelper::checkArray($model->compiler->filepath['plugins']))
				{
					$app->setUserState('com_componentbuilder.plugins_folder_name', $model->compiler->filepath['plugins-folder']);
				}
			} 
			else
			{
				// wipe out the user state when we're going to redirect
				$app->setUserState('com_componentbuilder.redirect_url', '');
				$app->setUserState('com_componentbuilder.message', '');
				$app->setUserState('com_componentbuilder.extension_message', '');
				$app->setUserState('com_componentbuilder.component_folder_name', '');
				$app->setUserState('com_componentbuilder.modules_folder_name', '');
				$app->setUserState('com_componentbuilder.plugins_folder_name', '');
				// set redirect
				$this->setRedirect($redirect_url, $message);
			}
			return true;
		}
		return false;
	}

	/**
	 * Install All Compiled Extensions
	 *
	 * @return  true on success
	 */
	public function installCompiledExtensions()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THESE_EXTENSIONS');
		if($user->authorise('core.admin'))
		{
			$message = JText::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_EXTENTIONS');
			$_message = array('success' => array(), 'error' => array());
			$app = JFactory::getApplication();
			// start file name array
			$fileNames = array();
			$fileNames[] = $app->getUserState('com_componentbuilder.component_folder_name', null);
			// check if we have modules
			$fileNames = ComponentbuilderHelper::mergeArrays(array($fileNames, $app->getUserState('com_componentbuilder.modules_folder_name', array()) ));
			// check if we have plugins
			$fileNames = ComponentbuilderHelper::mergeArrays(array($fileNames, $app->getUserState('com_componentbuilder.plugins_folder_name', array()) ));

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');

			// loop and install all extensions found
			foreach ($fileNames as $fileName)
			{
				if ($this->installExtension($fileName))
				{
					$_message['success'][] = JText::sprintf('COM_COMPONENTBUILDER_SZIP_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileName);
				}
				else
				{
					$_message['error'][] = JText::sprintf('COM_COMPONENTBUILDER_SZIP_COULD_NOT_BE_INSTALLED', $fileName);
				}
			}
			// catch errors
			if (ComponentbuilderHelper::checkArray($_message['error']))
			{
				$app->enqueueMessage(implode('<br />', $_message['error']), 'Error');
			}
			// build success message
			if (ComponentbuilderHelper::checkArray($_message['success']))
			{
				$this->setRedirect($redirect_url, implode('<br />', $_message['success']), 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	/**
	 * Install Compiled Component
	 *
	 * @return  true on success
	 */
	public function installCompiledComponent()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_COMPONENT');
		if($user->authorise('core.admin'))
		{
			$message = JText::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_COMPONENT');
			$app = JFactory::getApplication();
			$fileName = $app->getUserState('com_componentbuilder.component_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');

			if ($this->installExtension($fileName))
			{
				$message = JText::sprintf('COM_COMPONENTBUILDER_ONLY_SZIP_FILE_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileName);
				$this->setRedirect($redirect_url, $message, 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	/**
	 * Install Compiled Module
	 *
	 * @return  true on success
	 */
	public function installCompiledModule()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_MODULE');
		if($user->authorise('core.admin'))
		{
			$message = JText::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_MODULE');
			$app = JFactory::getApplication();
			$fileNames = $app->getUserState('com_componentbuilder.modules_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');

			if (ComponentbuilderHelper::checkArray($fileNames))
			{
				$jinput = JFactory::getApplication()->input;
				$moduleId = $jinput->post->get('install_item_id', 0, 'INT');
				if ($moduleId > 0 && isset($fileNames[$moduleId]) && $this->installExtension($fileNames[$moduleId]))
				{
					$message = JText::sprintf('COM_COMPONENTBUILDER_ONLY_SZIP_FILE_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileNames[$moduleId]);
					$this->setRedirect($redirect_url, $message, 'message');
					return true;
				}
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	/**
	 * Install Compiled Plugin
	 *
	 * @return  true on success
	 */
	public function installCompiledPlugin()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_PLUGIN');
		if($user->authorise('core.admin'))
		{
			$message = JText::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_PLUGIN');
			$app = JFactory::getApplication();
			$fileNames = $app->getUserState('com_componentbuilder.plugins_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');

			if (ComponentbuilderHelper::checkArray($fileNames))
			{
				$jinput = JFactory::getApplication()->input;
				$pluginId = $jinput->post->get('install_item_id', 0, 'INT');
				if ($pluginId > 0 && isset($fileNames[$pluginId]) && $this->installExtension($fileNames[$pluginId]))
				{
					$message = JText::sprintf('COM_COMPONENTBUILDER_ONLY_SZIP_FILE_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileNames[$pluginId]);
					$this->setRedirect($redirect_url, $message, 'message');
					return true;
				}
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	/**
	 * Install Extension
	 *
	 * @return  true on success
	 */
	protected function installExtension($fileName)
	{
		// check that the model is set
		if (!isset($this->_compiler_model))
		{
			// get the compiler model
			$this->_compiler_model = $this->getModel('compiler');
		}
		// set the language if not set
		if (!isset($this->_installer_lang))
		{
			$this->_installer_lang = JFactory::getLanguage();
			$extension = 'com_installer';
			$base_dir = JPATH_ADMINISTRATOR;
			$language_tag = 'en-GB';
			$reload = true;
			$this->_installer_lang->load($extension, $base_dir, $language_tag, $reload);
		}
		// make sure we have a string
		if (ComponentbuilderHelper::checkString($fileName))
		{
			return $this->_compiler_model->install($fileName.'.zip');
		}
		return false;
	}

	/**
	 * Run the Expansion
	 *
	 * @return  void
	 */
	public function runExpansion()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		// set massage
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_EXPANSION_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('compiler.run_expansion', 'com_componentbuilder'))
		{
			// set massage
			$message = JText::_('COM_COMPONENTBUILDER_EXPANSION_FAILED_PLEASE_CHECK_YOUR_SETTINGS_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_DEVELOPMENT_METHOD_TAB');
			// run expansion via API
			$result = ComponentbuilderHelper::getFileContents(JURI::root() . 'index.php?option=com_componentbuilder&task=api.expand');
			// is there a message returned
			if (!is_numeric($result) && ComponentbuilderHelper::checkString($result))
			{
				$this->setRedirect($redirect_url, $result);
				return true;
			}
			elseif (is_numeric($result) && 1 == $result)
			{
				$message = JText::_('COM_COMPONENTBUILDER_BTHE_EXPANSION_WAS_SUCCESSFULLYB_TO_SEE_MORE_INFORMATION_CHANGE_THE_BRETURN_OPTIONS_FOR_BUILDB_TO_BDISPLAY_MESSAGEB_IN_THE_GLOBAL_OPTIONS_OF_JCB_UNDER_THE_DEVELOPMENT_METHOD_TABB');
				$this->setRedirect($redirect_url, $message, 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}


	/**
	 * Clear tmp folder
	 *
	 * @return  true on success
	 */
	public function clearTmp()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = JText::_('COM_COMPONENTBUILDER_COULD_NOT_CLEAR_THE_TMP_FOLDER');
		if($user->authorise('compiler.clear_tmp', 'com_componentbuilder') && $user->authorise('core.options', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('compiler');
			// get tmp folder
			$comConfig = JFactory::getConfig();
			$tmp = $comConfig->get('tmp_path');
			if ($model->emptyFolder($tmp))
			{
				$message = JText::_('COM_COMPONENTBUILDER_BTHE_TMP_FOLDER_HAS_BEEN_CLEAR_SUCCESSFULLYB');
				$this->setRedirect($redirect_url, $message, 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}


	/**
	 * Run the Translator
	 *
	 * @return  void
	 */
	public function runTranslator()
	{
		// Check for request forgeries
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = JFactory::getUser();
		// set page redirect
		$redirect_url = JRoute::_('index.php?option=com_componentbuilder&view=compiler', false);
		// set massage
		$message = JText::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_TRANSLATOR_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('compiler.run_translator', 'com_componentbuilder'))
		{
			// set massage
			$message = JText::_('COM_COMPONENTBUILDER_TRANSLATION_FAILED_SINCE_THERE_ARE_NO_COMPONENTS_LINKED_WITH_TRANSLATION_TOOLS');
			// run translator via API
			$result = ComponentbuilderHelper::getFileContents(JURI::root() . 'index.php?option=com_componentbuilder&task=api.translator');
			// is there a message returned
			if (!is_numeric($result) && ComponentbuilderHelper::checkString($result))
			{
				$this->setRedirect($redirect_url, $result);
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

}
