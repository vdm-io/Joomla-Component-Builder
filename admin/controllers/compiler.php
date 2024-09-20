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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use Joomla\CMS\Version;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use Joomla\CMS\Uri\Uri;

/**
 * Compiler Admin Controller
 */
class ComponentbuilderControllerCompiler extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_COMPILER';

	/**
	 * Proxy for getModel.
	 * @since    2.5
	 */
	public function getModel($name = 'Compiler', $prefix = 'ComponentbuilderModel', $config = [])
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	public function dashboard()
	{
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder', false));
		return;
	}

	/**
	 * get all the animations used in the compiler
	 *
	 * @return  true on success
	 */
	public function getDynamicContent()
	{
		// Check for request forgeries
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_DOWNLOAD_THE_COMPILER_ANIMATIONS');
		// currently only those with permissions can get these images
		if($user->authorise('compiler.compiler_animations', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('compiler');
			if ($model->getDynamicContent($message))
			{
				$message = Text::_('COM_COMPONENTBUILDER_BALL_THE_COMPILER_ANIMATIONS_WERE_SUCCESSFULLY_DOWNLOADED_TO_THIS_JOOMLA_INSTALLB');
				$this->setRedirect($redirect_url, $message, 'message');
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	/**
	 * Run the Compiler
	 *
	 * @return  true on success
	 */
	public function compiler()
	{
		// Check for request forgeries
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// currently only those with admin access can compile a component
		if($user->authorise('core.manage', 'com_componentbuilder'))
		{
			$model = $this->getModel('compiler');
			if ($model->builder())
			{
				$cache = Factory::getCache('mod_menu');
				$cache->clean();
				// TODO: Reset the users acl here as well to kill off any missing bits
			}
			else
			{
				return false;
			}

			// switch to set multi install button
			$add_multi_install = false;
			$add_plugin_install = false;
			$add_module_install = false;
			// get application
			$app = Factory::getApplication();
			// set redirection URL
			$redirect_url = $app->getUserState('com_componentbuilder.redirect_url');
			// get system messages
			$message = $app->getUserState('com_componentbuilder.message');
			if (empty($redirect_url) && CFactory::_('Config')->component_id > 0)
			{
				// start new message
				$message = array();
				// update the redirection URL
				$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
				if (($pos = strpos($model->compiler->filepath['component'], "/tmp/")) !== FALSE)
				{
				    $url = Uri::root() . substr($model->compiler->filepath['component'], $pos + 1);
				}
				// check if we have plugins
				$add_plugin_install = UtilitiesArrayHelper::check($model->compiler->filepath['plugins'], true);
				// check if we have modules
				$add_module_install = UtilitiesArrayHelper::check($model->compiler->filepath['modules'], true);
				// if a multi install we set another kind of header
				if ($add_plugin_install || $add_module_install)
				{
					// Message of successful builds
					$message[] = '<h1>The Extensions were Successfully Compiled!</h1>';
					$message[] = '<h4>You can install any one of the following extensions!</h4>';
					// set multi install
					$add_multi_install = true;
				}
				else
				{
					// Message of successful build
					$message[] = '<h1>The (' . $model->compiler->filepath['component-folder'] . ') was Successfully Compiled!</h1>';
				}

				if (CFactory::_('Config')->joomla_version == Version::MAJOR_VERSION)
				{
					$message[] = '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledComponent\')">';
					$message[] = 'Install ' . $model->compiler->filepath['component-folder'] . ' on this <span class="icon-joomla icon-white"></span>Joomla website. (component)</button></p>';
					// check if we have modules
					if ($add_module_install)
					{
						foreach ($model->compiler->filepath['modules-folder'] as $module_id => $module_folder)
						{
							$message[] = '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledModule\', ' . (int) $module_id . ')">';
							$message[] = 'Install ' . $module_folder . ' on this <span class="icon-joomla icon-white"></span>Joomla website. (module)</button></p>';
						}
					}
					// check if we have plugins
					if ($add_plugin_install)
					{
						foreach ($model->compiler->filepath['plugins-folder'] as $plugin_id => $plugin_folder)
						{
							$message[] = '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledPlugin\', ' . (int) $plugin_id . ')">';
							$message[] = 'Install ' . $plugin_folder . ' on this <span class="icon-joomla icon-white"></span>Joomla website. (plugin)</button></p>';
						}
					}
					// set multi install button
					if ($add_multi_install)
					{
						$message[] = '<h4>You can install all compiled extensions!</h4>';
						$message[] = '<p><button class="btn btn-small btn-success" onclick="Joomla.submitbutton(\'compiler.installCompiledExtensions\')">';
						$message[] = 'Install all above extensions on this <span class="icon-joomla icon-white"></span>Joomla! website.</button></p>';
					}
				}
				$message[] = '<h2>Total time saved</h2>';
				$message[] = '<ul>';
				$message[] = '<li>Total folders created: <b>#'.'##FOLDER_COUNT##'.'#</b></li>';
				$message[] = '<li>Total files created: <b>#'.'##FILE_COUNT##'.'#</b></li>';
				$message[] = '<li>Total fields created: <b>#'.'##FIELD_COUNT##'.'#</b></li>';
				$message[] = '<li>Total lines written: <b>#'.'##LINE_COUNT##'.'#</b></li>';
				$message[] = '<li>A4 Book of: <b>#'.'##PAGE_COUNT##'.'# pages</b></li>';
				$message[] = '</ul>';
				$message[] = '<p><b>#'.'##totalHours##'.'# Hours</b> or <b>#'.'##totalDays##'.'# Eight Hour Days</b> <em>(actual time you saved)</em><br />';
				$message[] = '<small>(if creating a folder and file took <b>5 seconds</b> and writing one line of code took <b>10 seconds</b>, never making one mistake or taking any coffee break.)</small><br />';
				$message[] = '<b>#'.'##actualHoursSpent##'.'# Hours</b> or <b>#'.'##actualDaysSpent##'.'# Eight Hour Days</b> <em>(the actual time you spent)</em><br />';
				$message[] = '<small>(with the following break down: <b>debugging @#'.'##debuggingHours##'.'#hours</b> = codingtime / 4; <b>planning @#'.'##planningHours##'.'#hours</b> = codingtime / 7; <b>mapping @#'.'##mappingHours##'.'#hours</b> = codingtime / 10; <b>office @#'.'##officeHours##'.'#hours</b> = codingtime / 6;)</small></p>';
				$message[] = '<p><b>#'.'##actualTotalHours##'.'# Hours</b> or <b>#'.'##actualTotalDays##'.'# Eight Hour Days</b> <em>(a total of the realistic time frame for this project)</em><br />';
				$message[] = '<small>(if creating a folder and file took <b>5 seconds</b> and writing one line of code took <b>10 seconds</b>, with the normal everyday realities at the office, that includes the component planning, mapping & debugging.)</small></p>';
				$message[] = '<p>Project duration: <b>'.$model->compiler->projectWeekTime. ' weeks</b> or <b>#'.'##projectMonthTime##'.'# months</b></p>';
				// check if we have modules or plugins
				if ($add_multi_install)
				{
					$message[] = '<h2>Path to Zip Files</h2>';
					$message[] = '<p><b>Component Path:</b> <code>' . $model->compiler->filepath['component'] . '</code><br />';
					$message[] = '<b>Component URL:</b> <code>' . $url . '</code><br /><br />';
					// load modules if found
					if ($add_module_install)
					{
						$module_urls = array();
						// load the modules path/url
						foreach ($model->compiler->filepath['modules'] as $module_id => $module_path)
						{
							// set module path
							$message[] = '<b>Module Path:</b> <code>' . $module_path . '</code><br />';
							if (($pos = strpos($module_path, "/tmp/")) !== FALSE)
							{
								$module_urls[$module_id] = Uri::root() . substr($module_path, $pos + 1);
								$message[] = '<b>Module URL:</b> <code>' . $module_urls[$module_id] . '</code><br />';
							}
						}
					}
					// load plugins if found
					if ($add_plugin_install)
					{
						$plugin_urls = array();
						// load the plugins path/url
						foreach ($model->compiler->filepath['plugins'] as $plugin_id => $plugin_path)
						{
							// set plugin path
							$message[] = '<b>Plugin Path:</b> <code>' . $plugin_path . '</code><br />';
							if (($pos = strpos($plugin_path, "/tmp/")) !== FALSE)
							{
								$plugin_urls[$plugin_id] = Uri::root() . substr($plugin_path, $pos + 1);
								$message[] = '<b>Plugin URL:</b> <code>' . $plugin_urls[$plugin_id] . '</code><br />';
							}
						}
					}
					$message[] = '<br /><small>Hey! you can also download these zip files right now!</small><br />';
					$message[] = '<a class="btn btn-success" href="' . $url . '" ><span class="icon-download icon-white"></span>Download Component</a>&nbsp;&nbsp;';
					// load the module download URL's
					if (isset($module_urls) && UtilitiesArrayHelper::check($module_urls))
					{
						foreach ($module_urls as $module_id => $module_url)
						{
							$message[] = ' <a class="btn btn-success" href="' . $module_url . '" >';
							$message[] = '<span class="icon-download icon-white"></span>Download ' . $model->compiler->filepath['modules-folder'][$module_id] . '</a>&nbsp;&nbsp;';
						}
					}
					// load the plugin download URL's
					if (isset($plugin_urls) && UtilitiesArrayHelper::check($plugin_urls))
					{
						foreach ($plugin_urls as $plugin_id => $plugin_url)
						{
							$message[] = ' <a class="btn btn-success" href="' . $plugin_url . '" >';
							$message[] = '<span class="icon-download icon-white"></span>Download ' . $model->compiler->filepath['plugins-folder'][$plugin_id] . '</a>&nbsp;&nbsp;';
						}
					}
					$message[] = '</p>';
					$message[] = '<p><small><b>Remember!</b> These zip files are in your tmp folder and therefore publicly accessible until you click [Clear tmp]!</small></p>';
				}
				else
				{
					$message[] = '<h2>Path to Zip File</h2>';
					$message[] = '<p><b>Path:</b> <code>' . $model->compiler->filepath['component'] . '</code><br />';
					$message[] = '<b>URL:</b> <code>' . $url . '</code><br /><br />';
					$message[] = '<small>Hey! you can also download the zip file right now!</small><br />';
					$message[] = '<a class="btn btn-success" href="' . $url . '" ><span class="icon-download icon-white"></span>Download</a></p>';
					$message[] = '<p><small><b>Remember!</b> This zip file is in your tmp folder and therefore publicly accessible until you click [Clear tmp]!</small> </p>';
				}
				$message[] = '<p><small>Compilation took <b>#'.'##COMPILER_TIMER##'.'#</b> seconds to complete.</small> </p>';
				// pass the message via the user state... wow this is painful
				$app->setUserState('com_componentbuilder.success_message',
					CFactory::_('Placeholder')->update(
						implode(PHP_EOL, $message),
						CFactory::_('Compiler.Builder.Content.One')->allActive()
					)
				);
				// set redirect
				$this->setRedirect($redirect_url, '<h2>Successful Build!</h2>', 'message');
				$app->setUserState('com_componentbuilder.component_folder_name', $model->compiler->filepath['component-folder']);
				// check if we have modules
				if ($add_module_install)
				{
					$app->setUserState('com_componentbuilder.modules_folder_name', $model->compiler->filepath['modules-folder']);
				}
				// check if we have plugins
				if ($add_plugin_install)
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
				$app->setUserState('com_componentbuilder.success_message', '');
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
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THESE_EXTENSIONS');
		// currently only those with admin access can install a component via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_EXTENSIONS');
			$_message = array('success' => array(), 'error' => array());
			$app = Factory::getApplication();
			// start file name array
			$fileNames = array();
			$fileNames[] = $app->getUserState('com_componentbuilder.component_folder_name', null);
			// check if we have modules
			$fileNames = UtilitiesArrayHelper::merge(array($fileNames, $app->getUserState('com_componentbuilder.modules_folder_name', array()) ));
			// check if we have plugins
			$fileNames = UtilitiesArrayHelper::merge(array($fileNames, $app->getUserState('com_componentbuilder.plugins_folder_name', array()) ));

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$app->setUserState('com_componentbuilder.success_message', '');

			// loop and install all extensions found
			foreach ($fileNames as $fileName)
			{
				if ($this->installExtension($fileName))
				{
					$_message['success'][] = Text::sprintf('COM_COMPONENTBUILDER_SZIP_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileName);
				}
				else
				{
					$_message['error'][] = Text::sprintf('COM_COMPONENTBUILDER_SZIP_COULD_NOT_BE_INSTALLED', $fileName);
				}
			}
			// catch errors
			if (UtilitiesArrayHelper::check($_message['error']))
			{
				$app->enqueueMessage(implode('<br />', $_message['error']), 'Error');
			}
			// build success message
			if (UtilitiesArrayHelper::check($_message['success']))
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
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_COMPONENT');
		// currently only those with admin access can install a component via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_COMPONENT');
			$app = Factory::getApplication();
			$fileName = $app->getUserState('com_componentbuilder.component_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$app->setUserState('com_componentbuilder.success_message', '');

			if ($this->installExtension($fileName))
			{
				$message = Text::sprintf('COM_COMPONENTBUILDER_ONLY_SZIP_FILE_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileName);
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
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_MODULE');
		// currently only those with admin access can install a molule via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_MODULE');
			$app = Factory::getApplication();
			$fileNames = $app->getUserState('com_componentbuilder.modules_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$app->setUserState('com_componentbuilder.success_message', '');

			if (UtilitiesArrayHelper::check($fileNames))
			{
				$jinput = Factory::getApplication()->input;
				$moduleId = $jinput->post->get('install_item_id', 0, 'INT');
				if ($moduleId > 0 && isset($fileNames[$moduleId]) && $this->installExtension($fileNames[$moduleId]))
				{
					$message = Text::sprintf('COM_COMPONENTBUILDER_ONLY_SZIP_FILE_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileNames[$moduleId]);
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
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_INSTALL_THE_PLUGIN');
		// currently only those with admin access can install a plugin via JCB
		if($user->authorise('core.manage'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_INSTALL_PLUGIN');
			$app = Factory::getApplication();
			$fileNames = $app->getUserState('com_componentbuilder.plugins_folder_name');

			// wipe out the user c-m-p since we are done with them all
			$app->setUserState('com_componentbuilder.component_folder_name', '');
			$app->setUserState('com_componentbuilder.modules_folder_name', '');
			$app->setUserState('com_componentbuilder.plugins_folder_name', '');
			$app->setUserState('com_componentbuilder.success_message', '');

			if (UtilitiesArrayHelper::check($fileNames))
			{
				$jinput = Factory::getApplication()->input;
				$pluginId = $jinput->post->get('install_item_id', 0, 'INT');
				if ($pluginId > 0 && isset($fileNames[$pluginId]) && $this->installExtension($fileNames[$pluginId]))
				{
					$message = Text::sprintf('COM_COMPONENTBUILDER_ONLY_SZIP_FILE_WAS_REMOVED_THE_FROM_TMP_FOLDER_DURING_INSTALLATION', $fileNames[$pluginId]);
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
			$this->_installer_lang = Factory::getLanguage();
			$extension = 'com_installer';
			$base_dir = JPATH_ADMINISTRATOR;
			$language_tag = 'en-GB';
			$reload = true;
			$this->_installer_lang->load($extension, $base_dir, $language_tag, $reload);
		}
		// make sure we have a string
		if (StringHelper::check($fileName))
		{
			return $this->_compiler_model->install($fileName.'.zip');
		}
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
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_CLEAR_THE_TMP_FOLDER');
		if($user->authorise('compiler.clear_tmp', 'com_componentbuilder') && $user->authorise('core.manage', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('compiler');
			// get tmp folder
			$comConfig = Factory::getConfig();
			$tmp = $comConfig->get('tmp_path');
			if ($model->emptyFolder($tmp))
			{
				$message = Text::_('COM_COMPONENTBUILDER_BTHE_TMP_FOLDER_HAS_BEEN_CLEARED_SUCCESSFULLYB');
				$this->setRedirect($redirect_url, $message, 'message');
				// get application
				$app = Factory::getApplication();
				// wipe out the user c-m-p since we are done with them all
				$app->setUserState('com_componentbuilder.component_folder_name', '');
				$app->setUserState('com_componentbuilder.modules_folder_name', '');
				$app->setUserState('com_componentbuilder.plugins_folder_name', '');
				$app->setUserState('com_componentbuilder.success_message', '');

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
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=compiler', false);
		// set massage
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_RUN_THE_TRANSLATOR_MODULE');
		// check if this user has the right to run expansion
		if($user->authorise('compiler.run_translator', 'com_componentbuilder'))
		{
			// set massage
			$message = Text::_('COM_COMPONENTBUILDER_TRANSLATION_FAILED_SINCE_THERE_ARE_NO_COMPONENTS_LINKED_WITH_TRANSLATION_TOOLS');
			// run translator via API
			$result = ComponentbuilderHelper::getFileContents(Uri::root() . 'index.php?option=com_componentbuilder&task=api.translator');
			// is there a message returned
			if (!is_numeric($result) && StringHelper::check($result))
			{
				$this->setRedirect($redirect_url, $result);
				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

}
